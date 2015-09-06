<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Repositories\ProjectUserRepository;
use App\Repositories\RfiRepository;
use Session;

class RfisController extends Controller
{
    /**
     * @var ProjectUserRepository
     */
    private $projectUserRepository;

    /**
     * @var RfiRepository
     */
    private $rfiRepository;

    /**
     * Create a new controller instance.
     * @param ProjectUserRepository $projectUserRepository
     * @param RfiRepository $rfiRepository
     */
    public function __construct(ProjectUserRepository $projectUserRepository, RfiRepository $rfiRepository)
    {
        $this->middleware('auth');
        $this->middleware('project.permissions');

        $this->projectUserRepository = $projectUserRepository;
        $this->rfiRepository = $rfiRepository;
    }
    
    /**
     * Show the rfi list to the user.
     *
     * @return View
     */    
    public function index()
    {
        $project = \Session::get('project');

        $rfis = $this->rfiRepository
            ->findActiveByProjectId($project->id);
                
        return view('rfis.index')
            ->with([
                'project', $project,
                'projectUser' => Session::get('projectUser'),
                'rfis' => $rfis
            ]);
    }
    
    /**
     * Display the form to create a new RFI
     *
     * @return View
     */    
    public function create()
    {
        /** Get active project info */
        $project = \Session::get('project');
        
        /** @var Model[] $collaborators */
        $collaborators = $this->projectUserRepository
            ->findActiveByProject($project->id);
        
        return view('rfis.create')
                ->with('collaborators', $collaborators);
    }

    /**
     * Store the user in the database.
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store()
    {
        $input = call_user_func_array(array('\Input', 'only'), $this->rfiRepository->getFillable());

        if (count($input) == 0) {
            return redirect(route('rfis.create'));
        }

        $user = $this->fetchUser();

        $project = Session::get('project');

        $input['cost_impact_amount'] = filter_var($input['cost_impact_amount'], FILTER_SANITIZE_NUMBER_FLOAT);
        if (isset($input['cost_impact_amount']) && empty($input['cost_impact_amount'])) {
            unset($input['cost_impact_amount']);
        }
        $input['schedule_impact_days'] = filter_var($input['schedule_impact_days'], FILTER_SANITIZE_NUMBER_INT);
        if (isset($input['schedule_impact_days']) && empty($input['schedule_impact_days'])) {
            unset($input['schedule_impact_days']);
        }

        $input['project_id'] = $project->id;
        $input['draft'] = boolval($input['draft']);

        // Store the RFI as a draft and attach any files
        $rfi = $this->rfiRepository
            ->fill($input);

        $rfi->created_by = $user->id;
        $rfi->updated_by = $user->id;
        $rfi->company_id = $user->company_id;
        $rfi->rfi_id = $this->rfiRepository->findNextRfiId($project->id);

        $rfi->save();

        return redirect(route('rfis.show', ['rfis' => $rfi->id]));
    }

    public function show($id)
    {
        $rfi = $this->rfiRepository
            ->find($id);

        return view('rfis.show')
            ->with('rfi', $rfi);
    }

    /**
     * Get the user object for the logged in user.
     *
     * @return \App\Models\User
     */
    private function fetchUser()
    {
        return \Auth::User();
    }
}