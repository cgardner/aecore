<?php
namespace App\View\Composers;

use App\Repositories\ProjectRepository;
use Auth;
use Illuminate\Contracts\View\View;
use Session;

class NavProjectComposer
{
    /**
     * @var ProjectRepository
     */
    private $projectRepository;

    /**
     * NavProjectComposer constructor.
     * @param ProjectRepository $projectRepository
     */
    public function __construct(ProjectRepository $projectRepository)
    {
        $this->projectRepository = $projectRepository;
    }


    public function compose(View $view)
    {
        $userProjects = $this->projectRepository
            ->findActiveProjectsForUser(Auth::user()->id);
        
        if (count($userProjects)) {
            usort(
                $userProjects,
                function ($a, $b) {
                    return strcasecmp($a->number, $b->number);
                }
            );
        }
        
        $navigation = $this->getNavigation();

        $view->with('projects', $userProjects)
            ->with('activeProject', Session::get('project'))
            ->with('navigation', $navigation);
    }

    /**
     * @return array
     */
    private function getNavigation()
    {
        $navigation = [
            [
                'title' => 'Dashboard',
                'url' => url('dashboard'),
                'icon' => 'fa-bar-chart'
            ],
            [
                'title' => 'Collaborators',
                'url' => route('collaborators.index'),
                'icon' => 'fa-user'
            ],
//            [
//                'title' => 'Bidding',
//                'url' => url('bidding'),
//                'icon' => ''
//            ],            
//            [
//                'title' => 'Documents',
//                'url' => url('documents'),
//                'icon' => ''
//            ],
//            [
//                'title' => 'Plan Room',
//                'url' => url('planroom'),
//                'icon' => ''
//            ],
            [
                'title' => 'Requests For Information',
                'url' => url('rfis'),
                'icon' => 'fa-question-circle'
            ],
//            [
//                'title' => 'Potential Change Orders',
//                'url' => url('pcos'),
//                'icon' => 'fa-dollar'
//            ],  
//            [
//                'title' => 'Submittals',
//                'url' => url('submittals'),
//                'icon' => ''
//            ],
//            [
//                'title' => 'Meeting Minutes',
//                'url' => url('minutes'),
//                'icon' => ''
//            ],
            [
                'title' => 'Daily Reports',
                'url' => url('dcrs'),
                'icon' => 'fa-book'
            ],
//            [
//                'title' => 'Punchlist',
//                'url' => url('punchlist'),
//                'icon' => ''
//            ]
        ];
        return $navigation;
    }
}