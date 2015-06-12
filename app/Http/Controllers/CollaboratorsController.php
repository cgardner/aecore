<?php namespace App\Http\Controllers;

use App\Models\Project;
use App\Repositories\ProjectRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Session;

class CollaboratorsController extends Controller
{
    

    /**
     * Create a new controller instance.
     * @param ProjectRepository $project Project Repository.
     */
    public function __construct(ProjectRepository $project)
    {
        $this->middleware('auth');
        $this->middleware('project.permissions');
    }

    /**
     * Show the application dashboard to the user.
     *
     * @return View
     */
    public function index()
    {
        return view('collaborators.index');
    }

    /**
     * Open the help modal
     *
     */
    public function help()
    {
        return view('collaborators.modals.help');
    }

}
