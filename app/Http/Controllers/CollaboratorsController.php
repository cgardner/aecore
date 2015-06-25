<?php namespace App\Http\Controllers;

use App\Models\Projectuser;
use App\Models\User;
use App\Repositories\ProjectUserRepository;
use App\Repositories\UserRepository;
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
        $collaborators = $this->projectUserRepository
            ->findActiveByProject($project->id);
        return view('collaborators.index')->with(['collaborators' => $collaborators, 'project' => $project]);
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

        if (is_null($collaborator)) {
            return (string)false;
        }

        return (string)$collaborator->fill(\Request::all())
            ->save();
    }

    public function destroy($collaboratorId)
    {
        /** @var Projectuser|null $collaborator */
        $collaborator = $this->projectUserRepository
            ->find($collaboratorId);

        if (is_null($collaborator)) {
            return (string)false;
        }

        return (string)$collaborator->delete();
    }
    
    /**
     * Open the add collaborators modal
     *
     */
    public function addModal()
    {
        return view('collaborators.modals.add');
    }

    /**
     * Open the help modal
     *
     */
    public function helpModal()
    {
        return view('collaborators.modals.help');
    }

    private function addUserToProject(User $user)
    {
        /** @var \App\Models\Project $project */
        $project = \Session::get('project');

        $this->projectUserRepository
            ->create([
                'project_id' => $project->id,
                'user_id' => $user->id,
                'access' => Projectuser::ACCESS_USER,
                'status' => Projectuser::STATUS_ACTIVE,
                'role' => Projectuser::ROLE_DEFAULT,
            ]);
    }
}
