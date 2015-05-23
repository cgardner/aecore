<?php namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\User;
use Auth;
use Illuminate\View\View;
use Illuminate\Support\Str;
use Request;

class ProjectsController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard to the user.
     *
     * @return View
     */
    public function index()
    {
        $projects = Project::where('company_id', Auth::User()->company_id)->get();
        
        foreach($projects AS $project) {
          
          // Format blank size
          if($project->size == '') {
            $project->size = 'N/A';
          }
          
          // Format size unit
          if($project->size_unit == 'feet' && $project->size != '') {
            $project->size_unit = 'SF';
          } elseif($project->size_unit == 'meters' && $project->size != '') {
            $project->size_unit = 'SM';
          }
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

        $input['projectcode'] = Str::random(10);
        $input['user_id'] = Auth::User()->id;
        $input['value'] = filter_var(Request::get('value'), FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $input['size'] = filter_var(Request::get('size'), FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $input['company_id'] = Auth::User()->company_id;

        $project = $this->saveProject($input);
          
        // Add current user to this project
        Projectuser::create([
            'project_id'  => $project->id,
            'user_id'     => Auth::User()->id,
            'access'      => 'admin',
            'role'        => Auth::User()->Company->type
        ]);
          
        return Redirect::to('projects');
    }

    public function show($projectId)
    {
        $project = Project::find($projectId);

        return view('projects.show')
            ->with('project', $project);
    }

    public function edit($projectId)
    {
      
        $project = Project::find($projectId);

        return view('projects.edit')
            ->with('project', $project);
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
          return Project::create($input);
        }

        $project = Project::find(Request::get('id'));
        $project->fill($input);
        $project->save();
        return $project;
    }
}
