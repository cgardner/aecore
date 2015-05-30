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
    
    public function listProjectsDropdown()
    {
      //if(Session::has('company_id')) {
        $projects = DB::table('projects')
                ->select([
                  'projects.code',
                  'projects.name',
                  DB::raw('primaryNumber.number AS primaryNumber'),
                  DB::raw('altNumber.number AS altNumber')])
                ->leftjoin('projectnumbers AS primaryNumber', 'projects.id', '=', 'primaryNumber.project_id')
                ->leftjoin('projectnumbers AS altNumber', 'projects.id', '=', 'altNumber.project_id')
                ->leftjoin('projectusers', 'projects.id', '=', 'projectusers.project_id')
                ->where('projectusers.user_id', '=', '' . Auth::user()->id . '')
                ->where('projects.status', '!=', 'Archived')
                ->where('projects.status', '!=', 'Completed')
                ->orderby('altNumber.number', 'asc')
                ->orderby('primaryNumber.number', 'asc')
                ->get();
        
        echo '<select class="form-control sidebar-project-list" onChange="location.href=\'/projects/launch/\'+this.options[this.selectedIndex].value;">';
        foreach($projects AS $project) {
          //Format number
          if($project->altNumber != null && $project->altNumber != "") {
            $project->number = $project->altNumber;
          } elseif(isset($project->primaryNumber) && $project->primaryNumber != "") {
            $project->number = $project->primaryNumber;
          }
          
          if(Session::get('project_code') == $project->code) {
            $selected = 'selected="selected"';
          } else {
            $selected = '';
          }
          echo '<option value="'.$project->code.'" '.$selected.'>#' . $project->number . ' '. $project->name . '</option>';
        }
        echo '</select>';
      //}
    }    
}
