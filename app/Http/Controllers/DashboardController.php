<?php namespace App\Http\Controllers;

use App\Http\Requests;
use Session;

class DashboardController extends Controller
{
    public function showDashboard()
    {
        $project = Session::get('project');
        return view('projects.dashboard')
            ->with('project', $project);
    }
}
