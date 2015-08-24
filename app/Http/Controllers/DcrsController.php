<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Repositories\DcrRepository;
use App\Repositories\DcrEquipmentRepository;
use App\Repositories\ProjectUserRepository;
use Session;

// Models
use App\Models\Dcrequipment;

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
    public function __construct(
                            DcrRepository $dcrRepository,
                            DcrEquipmentRepository $dcrEquipmentRepository,
                            ProjectUserRepository $projectUserRepository
                        )
    {
        $this->middleware('auth');
        $this->middleware('project.permissions');

        $this->dcrRepository = $dcrRepository;
        $this->dcrEquipmentRepository = $dcrEquipmentRepository;
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
                ->find($dcrId)
                ->where('id', '=', $dcrId)
                ->where('project_id', '=', \Session::get('project')->id)
                ->where('status', '=', 'active')
                ->first();
        
        $dcrEquipments = $this->dcrEquipmentRepository
                ->findDcrEquipment($dcrId);
        
        if(count($dcr) > 0) {
            
            // Previous DCR info
            $dcr_previous = $this->dcrRepository
                ->find($dcrId)
                ->where('id', \DB::raw("(select max(id) from dcrs where id < $dcrId )"))
                ->where('project_id', '=', \Session::get('project')->id)
                ->where('status', '=', 'active')
                ->first();
            
            // Next DCR info
            $dcr_next = $this->dcrRepository
                ->find($dcrId)
                ->where('id', '>', $dcrId)
                ->where('project_id', '=', \Session::get('project')->id)
                ->where('status', '=', 'active')
                ->first();
            
            return view('dcrs.show')
                ->with([
                    'dcr'           => $dcr,
                    'dcrEquipments' => $dcrEquipments,
                    'dcr_next'      => $dcr_next,
                    'dcr_previous'  => $dcr_previous
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
        return view('dcrs.create');
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
            $dcr = $this->dcrRepository
                ->create($input);
            
            // Equipment
            if (count(\Request::get('equipment_type')) > 0) {
                for ($i = 0; $i < count(\Request::get('equipment_type')); $i++) {
                    
                    $eqp_type = \Request::get('equipment_type')[$i];
                    $eqp_qty = \Request::get('equipment_qty')[$i];
            
                    Dcrequipment::create([
                        'dcr_id'            => $dcr->id,
                        'equipment_type'    => $eqp_type,
                        'equipment_qty'     => $eqp_qty
                      ]);
                }
            }
            
        
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
        } else {

            $dcr = $this->dcrRepository
                ->find(\Request::get('id'));
            $dcr->fill($input);
            $dcr->save();
            
            return $dcr;
        }
        
    } 
}