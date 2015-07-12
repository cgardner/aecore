<?php namespace App\Http\Controllers;

use App\Models\Projectuser;
use App\Models\User;
use App\Repositories\ProjectUserRepository;
use App\Repositories\UserRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\View\View;
use Session;

class CollaboratorsController extends Controller
{
    /**
     * @var ProjectUserRepository
     */
    private $projectUserRepository;

    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * Create a new controller instance.
     * @param ProjectUserRepository $projectUserRepository
     * @param UserRepository $userRepository
     */
    public function __construct(ProjectUserRepository $projectUserRepository, UserRepository $userRepository)
    {
        $this->middleware('auth');
        $this->middleware('project.permissions');

        $this->projectUserRepository = $projectUserRepository;
        $this->userRepository = $userRepository;
    }

    /**
     * Show the application dashboard to the user.
     *
     * @return View
     */
    public function index()
    {
        $project = \Session::get('project');
        /** @var Model[] $collaborators */
        $collaborators = $this->projectUserRepository
            ->findActiveByProject($project->id);

        if (count($collaborators)) {
            usort(
                $collaborators,
                function ($a, $b) {
                    return strcasecmp($a->user->name, $b->user->name);
                }
            );
        }

        return view('collaborators.index')
            ->with(
                [
                    'collaborators' => $collaborators,
                    'project' => $project,
                    'projectUser' => Session::get('projectUser')
                ]
            );
    }

    public function store()
    {
        $userCodes = \Request::get('usercode');

        if (count($userCodes) == 0) {
            return redirect('collaborators');
        }

        $users = array_map(array($this->userRepository, 'findByUserCode'), $userCodes);
        array_walk($users, array($this, 'addUserToProject'));
        
        return redirect('collaborators');
    }

    /**
     * @param $collaboratorId
     * @return bool
     */
    public function update($collaboratorId)
    {
        /** @var Projectuser|null $collaborator */
        $collaborator = $this->projectUserRepository
            ->find($collaboratorId);

        if (is_null($collaborator) || count($collaborator) == 0) {
            return (string)false;
        }

        return (string)$collaborator->fill(\Request::all())
            ->save();
    }

    /**
     * Open collaborator modals
     */
    public function collabModal($type)
    {
        return view('collaborators.modals.' . $type);
    }
    
    private function addUserToProject(User $user)
    {
        /** @var \App\Models\Project $project */
        $project = \Session::get('project');

        $collaborator = $this->projectUserRepository
            ->findByUserId($user->id, $project->id);

        $role = Projectuser::ROLE_DEFAULT;

        if ($user->company) {
            $role = $user->company->type;
        }
        
        if (is_null($collaborator)) {
            $this->projectUserRepository
                ->create(
                    [
                        'project_id' => $project->id,
                        'user_id' => $user->id,
                        'access' => Projectuser::ACCESS_COLLAB,
                        'status' => Projectuser::STATUS_ACTIVE,
                        'role' => $role,
                    ]
                );
            
            // Issue user notification
            \Notifynder::category('collaborators.add')
                ->from(\Auth::User()->id)
                ->to($user->id)
                ->url('/projects/'.$project->id)
                ->send();
            
            return;
            
        } elseif ($collaborator->status != 'active') {
            
            $collaborator->fill(
                [
                    'access' => Projectuser::ACCESS_COLLAB,
                    'status' => Projectuser::STATUS_ACTIVE
                ]
            )
            ->save();
            
            // Issue user notification
            \Notifynder::category('collaborators.add')
                ->from(\Auth::User()->id)
                ->to($user->id)
                ->url('/projects/'.$project->id)
                ->send();
        }
    }
}
