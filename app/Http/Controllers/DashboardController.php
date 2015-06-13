<?php namespace App\Http\Controllers;

use App\Http\Requests;
use Session;

class DashboardController extends Controller
{
    public function showDashboard()
    {
        $project = Session::get('project');
        
        // Format size unit
        if($project->size_unit == "feet") { $project->size_unit = "SF"; }
        if($project->size_unit == "meters") { $project->size_unit = "SM"; }
                
        return view('projects.dashboard')
            ->with('project', $project);
    }
}