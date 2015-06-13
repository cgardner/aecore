<?php namespace App\Http\Controllers;

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
     * Create a new controller instance.
     * @param ProjectUserRepository $projectUserRepository
     */
    public function __construct(ProjectUserRepository $projectUserRepository)
    {
        $this->middleware('auth');
        $this->middleware('project.permissions');

        $this->projectUserRepository = $projectUserRepository;
    }

    /**
     * Show the application dashboard to the user.
     *
     * @return View
     */
    public function index()
    {
        $project = \Session::get('project');
        $collaborators = $this->projectUserRepository->findActiveByProject($project->id);
        return view('collaborators.index')->with(['collaborators' => $collaborators, 'project' => $project]);
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
}
