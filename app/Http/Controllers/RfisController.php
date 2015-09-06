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
     *
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
            ->with(
                [
                    'project',
                    $project,
                    'projectUser' => Session::get('projectUser'),
                    'rfis' => $rfis
                ]
            );
    }

    /**
     * Display the form to create a new RFI
     *
     * @return View
     */
    public function create()
    {
        $collaborators = $this->getCollaborators();
        $rfi = $this->rfiRepository
            ->newInstance();

        return view('rfis.create')
            ->with(['rfi' => $rfi, 'collaborators' => $collaborators]);
    }

    /**
     * Display the form to modify an rfi
     *
     * @param integer $rfiId
     * @return View
     */
    public function edit($rfiId)
    {
        $rfi = $this->rfiRepository
            ->find($rfiId);

        $collaborators = $this->getCollaborators();

        return view('rfis.edit')
            ->with(['rfi' => $rfi, 'collaborators' => $collaborators]);
    }

    /**
     * Store the user in the database.
     *
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

    /**
     * Update an existing RFI.
     *
     * @param integer $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update($id)
    {
        $rfi = $this->rfiRepository
            ->find($id);
        if (is_null($rfi)) {
            return redirect('rfis.index');
        }

        $fillable = $this->rfiRepository
            ->getFillable();

        $input = call_user_func_array(array('\Input', 'only'), $fillable);

        if (count($input) == 0) {
            return redirect(route('rfis.edit', ['rfis' => $id]));
        }

        $input['cost_impact_amount'] = filter_var($input['cost_impact_amount'], FILTER_SANITIZE_NUMBER_FLOAT);
        if (isset($input['cost_impact_amount']) && empty($input['cost_impact_amount'])) {
            unset($input['cost_impact_amount']);
        }
        $input['schedule_impact_days'] = filter_var($input['schedule_impact_days'], FILTER_SANITIZE_NUMBER_INT);
        if (isset($input['schedule_impact_days']) && empty($input['schedule_impact_days'])) {
            unset($input['schedule_impact_days']);
        }
        $input['draft'] = boolval($input['draft']);
        $input['updated_by'] = $this->fetchUser()
            ->id;
        $input['project_id'] = Session::get('project')->id;

        $rfi->fill($input);

        $rfi->save();
        return redirect(route('rfis.show', ['rfis' => $id]));
    }

    /**
     * Show a single RFI.
     * @param integer $id
     * @return View
     */
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

    /**
     * Get a list of the collaborators for the project
     *
     * @return Model[]
     */
    private function getCollaborators()
    {
        /** Get active project info */
        $project = \Session::get('project');

        /** @var Model[] $collaborators */
        $collaborators = $this->projectUserRepository
            ->findActiveByProject($project->id);
        return $collaborators;
    }
}