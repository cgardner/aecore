<?php namespace App\Http\Controllers;

use App\Repositories\ProjectRepository;
use App\Repositories\SlackIntegrationRepository;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class IntegrationsController extends Controller
{
    /**
     * @var ProjectRepository
     */
    private $projectRepository;
    
    /**
     * @var SlackIntegrationRepository
     */
    private $slackIntegrationRepository;
    
    /**
     * Create a new controller instance.
     * @param ProjectRepository $projectRepository Project Repository.
     * @param ProjectUserRepository $projectUserRepository Project/User Repository
     */
    public function __construct(ProjectRepository $projectRepository, SlackIntegrationRepository $slackIntegrationRepository)
    {
        $this->middleware('auth');
        $this->middleware('project.permissions');
        
        $this->projectRepository = $projectRepository;
        $this->slackIntegrationRepository = $slackIntegrationRepository;
    }
    
    /**
     * Open the print options modal
     */
    public function slackModal($projectId)
    {
        $project = $this->projectRepository
            ->find($projectId);
        
        $slack = $this->slackIntegrationRepository
            ->findSlackProject($projectId);
        
        $channel = (count($slack) == 0) ? '#' . str_replace(' ', '', strtolower($project->number . $project->name)) : $slack->channel;
        $username = (count($slack) == 0) ? 'Aecore Bot' : $slack->username;
        
        return view('integrations.modals.slack')
            ->with([
                'project' => $project,
                'channel' => $channel,
                'username' => $username,
                'slack' => $slack
            ]);
    }
    
    /**
     * Add or update slack integration
     */
    public function addSlackProject()
    {
        
        $input = Request::all();
        $input['channel'] = str_replace(' ', '', strtolower($input['channel']));
        
        // Find project
        $project = $this->projectRepository
                ->find($input['project_id']);
        
        if(!Request::has('id')) {
                
            // Create slack integration
            $this->slackIntegrationRepository
                ->create($input);
            
            if($input['channel'] == "") {
                $input['channel'] == null;
            }
            
            $this->slackIntegrationRepository
                ->sendSlackNotification(
                        $slack->webhook,
                        $slack->channel,
                        $slack->username,
                        Auth::User()->name . ' added a Slack integration on project #' . $project->number . ' ' . $project->name
                    );
            
        } else {
            
            // Update slack integration
            $slack = $this->slackIntegrationRepository
                ->find(Request::get('id'));
            $slack->fill($input);
            $slack->save();
                                
            $this->slackIntegrationRepository
                ->sendSlackNotification(
                        $input['webhook'],
                        $input['channel'],
                        $input['username'],
                        Auth::User()->name . ' updated the Slack integration on project #' . $project->number . ' ' . $project->name
                    ); 
        }
        
        return redirect('projects');

    }
    
}