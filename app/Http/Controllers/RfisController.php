<?php namespace App\Http\Controllers;

use App\Http\Requests;
use Session;

class RfisController extends Controller
{
    /**
     * Show the rfi list to the user.
     *
     * @return View
     */    
    public function index()
    {
        $project = Session::get('project');
                
        return view('rfis.index')
            ->with('project', $project);
    }
    
    /**
     * Display the form to create a new RFI
     *
     * @return View
     */    
    public function create()
    {
        return view('rfis.create');
    }
}