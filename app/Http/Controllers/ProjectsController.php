<?php namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Session;

class ProjectsController extends Controller
{
    /**
     * @var Project
     */
    private $project;

    /**
     * Create a new controller instance.
     * @param Project $project Project Model.
     */
    public function __construct(Project $project)
    {
        $this->middleware('auth');
        $this->middleware('project.permissions');
        $this->project = $project;
    }

    /**
     * Show the application dashboard to the user.
     *
     * @return View
     */
    public function index()
    {
        $projects = $this->project
            ->forUser(Auth::User());
        
        // Format size unit
        foreach($projects as $project) {
            if($project->size_unit == "feet") { $project->size_unit = "SF"; }
            if($project->size_unit == "meters") { $project->size_unit = "SM"; }
        }
                
        return view('projects.index')
            ->with('projects', $projects);
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
            return $this->project
                ->create($input);
        }

        $project = $this->project
            ->newQuery()
            ->find(Request::get('id'));
        $project->fill($input);
        $project->save();
        return $project;
    }

    public function show($projectId)
    {
        $project = $this->project
            ->newQuery()
            ->find($projectId);

        Session::set('project', $project);

        return redirect('dashboard');
    }

    public function edit($projectId)
    {
        $project = $this->project
            ->newQuery()
            ->find($projectId);

        return view('projects.edit')
            ->with('project', $project);
    }
    
    public function listProjects()
    {

        $projects = Project::leftjoin('projectusers', 'projects.id', '=', 'projectusers.project_id')
            ->where('projectusers.user_id', '=', '' . Auth::user()->id . '')
            ->where('projects.status', '!=', 'Archived')
            ->orderby('projects.number', 'asc')
            ->orderby('projects.name', 'asc')
            ->get([
                'projects.id',
                'projects.number',
                'projects.name'
            ]);
        
        echo '<select class="form-control sidebar-project-list" onChange="location.href=\'/projects/\'+this.options[this.selectedIndex].value;">';
        foreach ($projects AS $project) {
            if(Session::get('project')->id == $project->id) {
                $selected = 'selected="selected"';
            } else {
                $selected = '';
            }
            echo '<option value="' . $project->id . '" ' . $selected . '>#' . $project->number . ' ' . $project->name . '</option>';
        }
        echo '</select>';
    }

}
