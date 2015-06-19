<?php namespace App\Http\Controllers;

use App\Repositories\ProjectRepository;
use App\Repositories\ProjectUserRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Session;

class ProjectsController extends Controller
{
    /**
     * @var ProjectRepository
     */
    private $projectRepository;

    /**
     * @var ProjectUserRepository;
     */
    private $projectUserRepository;

    /**
     * Create a new controller instance.
     * @param ProjectRepository $projectRepository Project Repository.
     * @param ProjectUserRepository $projectUserRepository Project/User Repository
     */
    public function __construct(ProjectRepository $projectRepository, ProjectUserRepository $projectUserRepository)
    {
        $this->middleware('auth');
        $this->middleware('project.permissions');
        $this->projectRepository = $projectRepository;
        $this->projectUserRepository = $projectUserRepository;
    }

    /**
     * Show the application dashboard to the user.
     *
     * @return View
     */
    public function index()
    {
        $projectUsers = $this->projectUserRepository
            ->findActiveForUser(Auth::User()->id);

        return view('projects.index')
            ->with('projectUsers', $projectUsers);
    }

    /**
     * Display the form to create a new Project
     *
     * @return View
     */
    public function create()
    {
        return view('projects.create');
    }

    /**
     * Store the Project Resource.
     */
    public function store()
    {
        $input = Request::except('value', 'size', '_token');

        $user = Auth::User();

        $input['projectcode'] = Str::random(10);
        $input['user_id'] = $user->id;
        $input['value'] = filter_var(Request::get('value'), FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $input['size'] = filter_var(Request::get('size'), FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $input['company_id'] = $user->company_id;

        $this->saveProject($input);
        return new RedirectResponse(route('projects.index'));
    }

    /**
     * Save the project data
     *
     * @param array $input
     * @return \Illuminate\Support\Collection
     */
    private function saveProject(array $input)
    {
        if (!Request::has('id')) {
            return $this->projectRepository
                ->create($input);
        }

        $project = $this->projectRepository
            ->find(Request::get('id'));
        $project->fill($input);
        $project->save();
        return $project;
    }

    public function show($projectId)
    {
        $project = $this->projectRepository
            ->find($projectId);

        Session::set('project', $project);

        return redirect('dashboard');
    }

    public function edit($projectId)
    {
        $project = $this->projectRepository
            ->find($projectId);

        return view('projects.edit')
            ->with('project', $project);
    }
}