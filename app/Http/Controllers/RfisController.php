<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Repositories\ProjectUserRepository;
use Session;

class RfisController extends Controller
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
     * Show the rfi list to the user.
     *
     * @return View
     */    
    public function index()
    {
        $project = \Session::get('project');
                
        return view('rfis.index')
            ->with([
                'project', $project,
                'projectUser' => Session::get('projectUser')
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
}