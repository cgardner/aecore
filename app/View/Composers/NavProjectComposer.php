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
                'icon' => 'glyphicon-stats'
            ],
            [
                'title' => 'Collaborators',
                'url' => route('collaborators.index'),
                'icon' => 'glyphicon-user'
            ],
            [
                'title' => 'Documents',
                'url' => url('documents'),
                'icon' => 'glyphicon-folder-open'
            ],            
            [
                'title' => 'Bidding',
                'url' => url('bidding'),
                'icon' => 'glyphicon-bullhorn'
            ],
            [
                'title' => 'Plan Room',
                'url' => url('planroom'),
                'icon' => 'glyphicon-th-large'
            ],            
            [
                'title' => 'Requests For Information',
                'url' => url('rfis'),
                'icon' => 'glyphicon-question-sign'
            ],
            [
                'title' => 'Submittals',
                'url' => url('submittals'),
                'icon' => 'glyphicon-tags'
            ],
            [
                'title' => 'Meeting Minutes',
                'url' => url('minutes'),
                'icon' => 'glyphicon-pencil'
            ],
            [
                'title' => 'Daily Reports',
                'url' => url('daily-reports'),
                'icon' => 'glyphicon-book'
            ],
            [
                'title' => 'Punchlist',
                'url' => url('punchlist'),
                'icon' => 'glyphicon-star'
            ]
        ];
        return $navigation;
    }
}