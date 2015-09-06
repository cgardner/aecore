<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Repositories\DcrRepository;
use App\Repositories\DcrWorkRepository;
use Session;

// Models
use App\Models\Dcr;
use App\Models\Dcrwork;

class DashboardController extends Controller
{
    /** @var DcrRepository */
    private $dcrRepository;
    
    /** @var DcrWorkRepository */
    private $dcrWorkRepository;
    
    /**
     * Create a new controller instance.
     */
    public function __construct( DcrRepository $dcrRepository, DcrWorkRepository $dcrWorkRepository)
    {
        $this->dcrRepository = $dcrRepository;
        $this->dcrWorkRepository = $dcrWorkRepository;
    }
    
    public function showDashboard()
    {
        $project = Session::get('project');
        
        // Format size unit
        if($project->size_unit == "feet") { $project->size_unit = "SF"; }
        if($project->size_unit == "meters") { $project->size_unit = "SM"; }
                
        $location = \Geocode::make()->address($project->city . ',' . $project->state, $project->state);

        /** Get dcrs for current project **/
        $dcrs = $this->dcrRepository
            ->findDcrsForUser($project->id);
        
        foreach($dcrs as $dcr) {
            /** Count crew & hours for chart **/
            $dcr->crew = $this->dcrWorkRepository
                    ->sumDcrWork($dcr->id);
            $dcr->crewhours = $this->dcrWorkRepository
                    ->sumDcrWorkHours($dcr->id);
            $dcr->manhours = ($dcr->crew)*($dcr->crewhours);
        }
        
        return view('projects.dashboard')
            ->with([
                'dcrs'      => $dcrs,
                'project'   => $project,
                'location'  => $location
            ]);
    }
}