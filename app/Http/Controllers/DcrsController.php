<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Repositories\DcrRepository;
use App\Repositories\ProjectUserRepository;
use Session;

class DcrsController extends Controller
{
    /**
     * @var DcrRepository
     */
    private $dcrRepository;
    
    /**
     * @var ProjectUserRepository
     */
    private $projectUserRepository;
    
    /**
     * Create a new controller instance.
     * @param ProjectUserRepository $projectUserRepository
     */
    public function __construct(DcrRepository $dcrRepository, ProjectUserRepository $projectUserRepository)
    {
        $this->middleware('auth');
        $this->middleware('project.permissions');

        $this->dcrRepository = $dcrRepository;
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
                
        // Get projects for current user
        $dcrs = $this->dcrRepository
            ->findDcrsForUser($project->id);
        
        return view('dcrs.index')
            ->with([
                'dcrs'=> $dcrs,
                'project' => $project,
                'projectUser' => Session::get('projectUser')
            ]);
    }
    
    public function show($dcrId)
    {
        $dcr = $this->dcrRepository
            ->find($dcrId);
        
        if(count($dcr) > 0) {
            return view('dcrs.show')
                ->with([
                    'dcr'=> $dcr
                ]);
        } else {
            //Access denied or not found
            return redirect('dcrs');
        }
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
        
        return view('dcrs.create')
                ->with('collaborators', $collaborators);
    }
    
    /**
     * Display the form to create a new RFI
     *
     * @return View
     */    
    public function store()
    {
        $input = \Request::all();
        
        /** Get active project info */
        $project = \Session::get('project');
        $input['project_id'] = $project->id;
              
        /** Get active use info */
        $user = \Auth::User();
        $input['company_id'] = $user->company_id;
        
        $this->saveDcr($input);
        
        return redirect('dcrs');
    }
    
    /**
     * Save the dcr data
     *
     * @param array $input
     * @return \Illuminate\Support\Collection
     */
    private function saveDcr(array $input)
    {
        if (!\Request::has('id')) {
            return $this->dcrRepository
                ->create($input);
        }

        $dcr = $this->dcrRepository
            ->find(Request::get('id'));
        $dcr->fill($input);
        $dcr->save();
        
//        //Send to Slack
//        $slack = $this->slackIntegrationRepository
//            ->findSlackProject($project->id);
//        
//        if(count($slack) > 0) {
//            $this->slackIntegrationRepository
//                ->sendSlackNotification( $slack->webhook, $slack->channel, $slack->username,
//                    ':pencil: ' . Auth::User()->name . ' edited project *#' . $project->number . ' ' . $project->name . '*'
//                );
//        }
        
        return $dcr;
    }    
}