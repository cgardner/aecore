<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Auth;
use Redirect;

//Requests
use App\Http\Requests\CreateTaskRequest;
use App\Http\Requests\CreateTasklistRequest;

// Models
use App\Models\Tasklist;


class TasksController extends Controller {

  /**
   * Make sure the user is authenticated.
   * 
   */
  public function __construct()
  {
    $this->middleware('auth');
  }
  
	public function index()
	{
    
    $lists = Tasklist::where('user_id', Auth::User()->id)->get();
    
		return view('tasks.list')
        ->with([
            'lists' => $lists
          ]);
	}

	public function createList(CreateTasklistRequest $request)
	{
    $listcode = Str::random(10);
    
		Tasklist::create([
      'user_id'   => Auth::User()->id,
      'listcode'  => $listcode,
      'list'      => $request->get('list_name')
    ]);
    return Redirect::to('tasks/'.$listcode);
	}

}