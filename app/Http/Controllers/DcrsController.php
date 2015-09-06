<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Repositories\DcrRepository;
use App\Repositories\DcrWorkRepository;
use App\Repositories\DcrEquipmentRepository;
use App\Repositories\DcrInspectionRepository;
use App\Repositories\DcrAttachmentRepository;
use App\Repositories\ProjectUserRepository;
use App\Repositories\SlackIntegrationRepository;
use Forecast\Forecast;
use Session;

// Models
use App\Models\Dcr;
use App\Models\Dcrwork;
use App\Models\Dcrequipment;
use App\Models\Dcrinspection;
use App\Models\DcrAttachment;

class DcrsController extends Controller
{
    /** @var DcrRepository */
    private $dcrRepository;
    
    /** @var DcrWorkRepository */
    private $dcrWorkRepository;
    
    /** @var DcrInspectionRepository */
    private $dcrInspectionRepository;
    
    /** @var DcrEquipmentRepository */
    private $dcrEquipmentRepository;
    
    /** @var DcrAttachmentRepository */
    private $dcrAttachmentRepository;
    
    /** @var ProjectUserRepository */
    private $projectUserRepository;
    
    /**
     * Create a new controller instance.
     * @param ProjectUserRepository $projectUserRepository
     */
    public function __construct(
                            DcrRepository $dcrRepository,
                            DcrWorkRepository $dcrWorkRepository,
                            DcrEquipmentRepository $dcrEquipmentRepository,
                            DcrInspectionRepository $dcrInspectionRepository,
                            DcrAttachmentRepository $dcrAttachmentRepository,
                            ProjectUserRepository $projectUserRepository,
                            SlackIntegrationRepository $slackIntegrationRepository
                        )
    {
        $this->middleware('auth');
        $this->middleware('project.permissions');

        $this->dcrRepository = $dcrRepository;
        $this->dcrWorkRepository = $dcrWorkRepository;
        $this->dcrEquipmentRepository = $dcrEquipmentRepository;
        $this->dcrInspectionRepository = $dcrInspectionRepository;
        $this->dcrAttachmentRepository = $dcrAttachmentRepository;
        $this->projectUserRepository = $projectUserRepository;
        $this->slackIntegrationRepository = $slackIntegrationRepository;
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
        
        foreach($dcrs as $dcr) {
            // Count workers
            $dcr->crew = $this->dcrWorkRepository
                    ->sumDcrWork($dcr->id);
        }
        
        return view('dcrs.index')
            ->with([
                'dcrs'=> $dcrs,
                'project' => $project,
                'projectUser' => Session::get('projectUser')
            ]);
    }
    
    /**
     * Display the form to create a new DCR
     *
     * @return View
     */    
    public function create()
    {
        // Previous DCR info
        $dcr_previous = Dcr::where('date', '<', \Timezone::convertFromUTC(\Carbon::now(), \Auth::user()->timezone, 'Y-m-d'))
            ->where('project_id', '=', \Session::get('project')->id)
            ->where('status', '=', 'active')
            ->orderBy('date', 'DESC')
            ->orderBy('created_at', 'DESC')
            ->first();
        
        $dcrWorks = $this->dcrWorkRepository
                    ->findDcrWorks($dcr_previous->id);
        
        // Get the current forecast for a given latitude and longitude
        $project = Session::get('project');
        $location = \Geocode::make()->address($project->city . ',' . $project->state, $project->state);
        
        $forecastio = new Forecast(env('FORECAST_API_KEY'));
        $forecast = $forecastio->get($location->latitude(), $location->longitude());
        
        switch ($forecast->daily->data[0]->icon) {
            default:
                $forecast->weather = 'Clear';
            break;
            case 'clear-day':
            case 'clear-night':
                $forecast->weather = 'Clear';
            break;
            case 'partly-cloudy-day':
            case 'partly-cloudy-night':
                $forecast->weather = 'Partly Cloudy';
            break;
            case 'cloudy':
                $forecast->weather = 'Cloudy';
            break;
            case 'fog':
                $forecast->weather = 'Fog';
            break;
            case 'rain':
            case 'thunderstorm':
                $forecast->weather = 'Rain';
            break;
            case 'snow':
            case 'hail':
            case 'sleet':
                $forecast->weather = 'Snow';
            break;
            case 'wind':
                $forecast->weather = 'Wind';
            break;
        }

        return view('dcrs.create')
            ->with([
                'dcrWorks'  => $dcrWorks,
                'forecast'  => $forecast,
                'location'  => $location
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
        
        if(count($dcr) > 0) {
            
            // Previous DCR info
            $dcr_previous = Dcr::where('date', '<', $dcr->date)
                ->where('id', '!=', $dcr->id)
                ->where('project_id', '=', \Session::get('project')->id)
                ->where('status', '=', 'active')
                ->orderBy('date', 'DESC')
                ->orderBy('created_at', 'DESC')
                ->first();
            
            // Next DCR info
            $dcr_next = Dcr::where('date', '>', $dcr->date)
                ->where('id', '!=', $dcr->id)
                ->where('project_id', '=', \Session::get('project')->id)
                ->where('status', '=', 'active')
                ->orderBy('date', 'ASC')
                ->orderBy('created_at', 'DESC')
                ->first();
            
            $dcrWorks = $this->dcrWorkRepository
                    ->findDcrWorks($dcrId);

            $dcrEquipments = $this->dcrEquipmentRepository
                    ->findDcrEquipments($dcrId);

            $dcrInspections = $this->dcrInspectionRepository
                    ->findDcrInspections($dcrId);

            $dcrAttachments = $this->dcrAttachmentRepository
                    ->findDcrAttachments($dcrId);
            
            
            return view('dcrs.show')
                ->with([
                    'dcr'               => $dcr,
                    'dcrWorks'          => $dcrWorks,
                    'dcrEquipments'     => $dcrEquipments,
                    'dcrInspections'    => $dcrInspections,
                    'dcrAttachments'    => $dcrAttachments,
                    'dcr_next'          => $dcr_next,
                    'dcr_previous'      => $dcr_previous,
                    'functionscontroller'   => new FunctionsController
                ]);
        } else {
            //Access denied or not found
            return redirect('dcrs');
        }
    }
    
    public function edit($dcrId)
    {
        $dcr = $this->dcrRepository
                ->find($dcrId)
                ->where('id', '=', $dcrId)
                ->where('project_id', '=', \Session::get('project')->id)
                ->where('status', '=', 'active')
                ->first();
        
        if(count($dcr) > 0) {
            
            // Previous DCR info
            $dcr_previous = Dcr::where('date', '<', $dcr->date)
                ->where('id', '!=', $dcr->id)
                ->where('project_id', '=', \Session::get('project')->id)
                ->where('status', '=', 'active')
                ->orderBy('date', 'DESC')
                ->orderBy('created_at', 'DESC')
                ->first();
            
            // Next DCR info
            $dcr_next = Dcr::where('date', '>', $dcr->date)
                ->where('id', '!=', $dcr->id)
                ->where('project_id', '=', \Session::get('project')->id)
                ->where('status', '=', 'active')
                ->orderBy('date', 'ASC')
                ->orderBy('created_at', 'DESC')
                ->first();
            
            $dcrWorks = $this->dcrWorkRepository
                    ->findDcrWorks($dcrId);

            $dcrEquipments = $this->dcrEquipmentRepository
                    ->findDcrEquipments($dcrId);

            $dcrInspections = $this->dcrInspectionRepository
                    ->findDcrInspections($dcrId);

            $dcrAttachments = $this->dcrAttachmentRepository
                    ->findDcrAttachments($dcrId);
            
            // Get the current forecast for a given latitude and longitude
            $project = Session::get('project');
            $location = \Geocode::make()->address($project->city . ',' . $project->state, $project->state);
            
            $forecastio = new Forecast(env('FORECAST_API_KEY'));
            $forecast = $forecastio->get($location->latitude(), $location->longitude());
        
            return view('dcrs.edit')
                ->with([
                    'dcr'               => $dcr,
                    'dcrWorks'          => $dcrWorks,
                    'dcrEquipments'     => $dcrEquipments,
                    'dcrInspections'    => $dcrInspections,
                    'dcrAttachments'    => $dcrAttachments,
                    'dcr_next'          => $dcr_next,
                    'dcr_previous'      => $dcr_previous,
                    'forecast'          => $forecast,
                    'location'          => $location,
                    'functionscontroller'   => new FunctionsController
                ]);
        } else {
            //Access denied or not found
            return redirect('dcrs');
        }
    }
    
    /**
     * Open collaborator modals
     */
    public function editWorkModal($rId)
    {
       return view('dcrs.modals.editWork')
            ->with([
                'rId' => $rId
            ]);
    }
        
    /**
     * Display the form to save a DCR
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

        //Send to Slack
        $slack = $this->slackIntegrationRepository
            ->findSlackProject($project->id);

        if(count($slack) > 0) {
            $this->slackIntegrationRepository
                ->sendSlackNotification( $slack->webhook, $slack->channel, $slack->username,
                    ':notebook: ' . \Auth::User()->name . ' saved a Daily Report dated ' . $input['date']
                );
        }

        if (!\Request::has('dcr_id')) {
            return redirect('dcrs');
        } else {
            return redirect('dcrs/' . $input['dcr_id']);
        }
    }
    
    /**
     * Save the dcr data
     *
     * @param array $input
     * @return \Illuminate\Support\Collection
     */
    private function saveDcr(array $input)
    {
        // Update general DCR info
        $dcr = $this->dcrRepository
            ->UpdateOrCreate(['id' => \Request::get('dcr_id')], $input);
           
        // Set manpower, equipment, inspections and attachments to disabled
        // Resets with each form input update below, allows us not to have to consider deletions in form
        if (\Request::has('dcr_id')) {
            Dcrwork::where('dcr_id', $dcr->id)->update([ 'status' => 'disabled' ]);
            Dcrequipment::where('dcr_id', $dcr->id)->update([ 'status' => 'disabled' ]);
            Dcrinspection::where('dcr_id', $dcr->id)->update([ 'status' => 'disabled' ]);
            Dcrattachment::where('dcr_id', $dcr->id)->update([ 'status' => 'disabled' ]);
        }

        // Update manpower
        if (\Request::get('crew_company')[0] != "") {
            for ($i = 0; $i < count(\Request::get('crew_company')); $i++)
            {
                Dcrwork::UpdateOrCreate(['id' => \Request::get('crew_id')[$i]], [
                    'dcr_id'        => $dcr->id,
                    'crew_company'  => \Request::get('crew_company')[$i],
                    'crew_size'     => \Request::get('crew_size')[$i],
                    'crew_hours'    => \Request::get('crew_hours')[$i],
                    'crew_work'     => \Request::get('crew_work')[$i],
                    'status'        => 'active'
                ]);
            }
        }

        // Equipment
        if (\Request::get('equipment_type')[0] != "") {
            for ($i = 0; $i < count(\Request::get('equipment_type')); $i++) 
            {
                Dcrequipment::UpdateOrCreate(['id' => \Request::get('equipment_id')[$i]], [
                    'dcr_id'            => $dcr->id,
                    'equipment_type'    => \Request::get('equipment_type')[$i],
                    'equipment_qty'     => \Request::get('equipment_qty')[$i],
                    'status'            => 'active'
                ]);
            }
        }
            
        // Inspections            
        if (\Request::get('inspection_agency')[0] != "") {
            for ($i = 0; $i < count(\Request::get('inspection_agency')); $i++)
            {
                Dcrinspection::UpdateOrCreate(['id' => \Request::get('inspection_id')[$i]],[
                    'dcr_id'            => $dcr->id,
                    'inspection_agency' => \Request::get('inspection_agency')[$i],
                    'inspection_type'   => \Request::get('inspection_type')[$i],
                    'inspection_status' => \Request::get('inspection_status')[$i],
                    'status'            => 'active'
                ]);
            }
        }

        // Attachments
        if (\Request::get('file_id')[0] != "") {
            for ($i = 0; $i < count(\Request::get('file_id')); $i++)
            {                
                Dcrattachment::UpdateOrCreate(['id' => \Request::get('attachment_id')[$i]],[
                    'dcr_id'    => $dcr->id,
                    's3file_id' => \Request::get('file_id')[$i],
                    'status'    => 'active'
                ]);
            }
        }
            
        return $dcr;
        
    }
}