<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Auth;
use Input;
use Redirect;
use Session;
use DateTime;
use Timezone;
use Carbon;

//Requests
use App\Http\Requests\CreateTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Http\Requests\CreateTasklistRequest;
use App\Http\Requests\AddTaskFollowerRequest;

// Models
use App\Models\Task;
use App\Models\Taskdate;
use App\Models\Taskfollower;
use App\Models\Tasklist;
use App\Models\Taskrefresh;


class TasksController extends Controller {

  /**
   * Make sure the user is authenticated.
   * 
   */
  public function __construct()
  {
    $this->middleware('auth');
  }
  
	public function index($listcode=NULL)
	{
    // Filters
    $allowed = array('open', 'complete');
    $filter = in_array(Input::get('filter'), $allowed) ? Input::get('filter') : 'open'; // if user type in the url a column that doesnt exist app will default to open
    if($filter == 'open') {
      Session::put('filter_text', 'Open Tasks');
    } elseif($filter == 'complete') {
      Session::put('filter_text', 'Completed Tasks');
    } else {
      Session::put('filter_text', 'Open Tasks');
    }
    
    // Get user's lists
    $lists = Tasklist::where('user_id', Auth::User()->id)
            ->where('status', 'active')
            ->orderby('list', 'asc')
            ->get(['id', 'listcode', 'list']);
    
    $lists_following = Taskfollower::leftjoin('tasks', 'taskfollowers.task_id', '=', 'tasks.id')
              ->leftjoin('users', 'tasks.user_id', '=', 'users.id')
              ->where('taskfollowers.user_id', '=', Auth::User()->id)
              ->where('tasks.status', '=', $filter)
              ->where('tasks.user_id', '!=', Auth::User()->id)
              ->groupby('tasks.user_id', 'users.usercode', 'users.name')
              ->orderby('users.name', 'asc')
              ->get(array('tasks.user_id', 'users.usercode', 'users.name'));
    
    // Get active list data
    $list = Tasklist::where('user_id', Auth::User()->id)
            ->where('listcode', $listcode)
            ->where('status', 'active')
            ->first();
    
    // Set active list name
    if(count($list) == 0) {
      $listname = 'All Tasks';
      Session::put('listcode', '');
    } else {
      $listname = $list->list;
      Session::put('listcode', $listcode);
    }
    
    // Get tasks for active list
    $mytasks = Task::leftjoin('taskdates', 'tasks.id', '=', 'taskdates.task_id')
            ->leftjoin('taskrefreshdates', 'tasks.user_id', '=', 'taskrefreshdates.user_id')
            ->leftjoin('tasklists', 'tasklists.id', '=', 'tasks.tasklist_id')
            ->where('tasks.user_id', '=', Auth::User()->id)
            ->where(function($query) use ($list) {
              if(count($list) > 0 && $list->id != '0') {
               $query->where('tasks.tasklist_id', $list->id);
              }
            })
            ->where(function($query_a) use ($filter) {
              $query_a->where('tasks.status', '=', $filter);
              $query_a->orwhere(function($query_b) {
                $query_b->where('tasks.status', '=', 'complete');
                $query_b->where(\DB::raw('taskrefreshdates.date_refresh', '%Y%m%d%H%i%s'), '<', \DB::raw('taskdates.date_complete', '%Y%m%d%H%i%s'));
              });
              $query_a->orwhere(function($query_c) {
                $query_c->where('tasks.status', '=', 'complete');
                $query_c->where('taskrefreshdates.date_refresh', '=', null);
              });
            })
            ->orderby('tasks.priority', 'desc')
            ->orderBy('taskdates.date_due')
            ->orderBy('tasks.created_at')
            ->get([
                'tasks.id',
                'tasks.taskcode',
                'tasks.task',
                'tasks.tasklist_id',
                'tasks.priority',
                'tasks.status',
                'taskdates.date_due',
                'tasklists.list',
                'tasklists.listcode',
                'tasklists.status AS list_status',
                ]);
            
    $completed_count = 0;
    foreach($mytasks as $mytask) {
      
      // Completed tasks
      if($mytask->status == 'complete') {
        $completed_count++;
      }
      
      // Format tasklist
      if($mytask->tasklist_id != "0" && $mytask->tasklist_id != "" && $mytask->list_status != "disabled") {
        $mytask->list = $mytask->list;
      } else {
        $mytask->list = "";
      }
      
      // Format due date
      if($mytask->date_due == null) {
        $mytask->date_due = '';
      } elseif(Timezone::convertFromUTC(Carbon::now(), Auth::user()->timezone, 'Y-m-d') > date('Y-m-d', strtotime($mytask->date_due))) {
        $mytask->date_due = '<span class="text-danger bold">Overdue</span>';
      } elseif(Timezone::convertFromUTC(Carbon::now(), Auth::user()->timezone, 'Y-m-d') == date('Y-m-d', strtotime($mytask->date_due))) {
        $mytask->date_due = '<span class="text-success bold">Today</span>';
      } elseif(Timezone::convertFromUTC(Carbon::now()->addDay(), Auth::user()->timezone, 'Y-m-d') == date('Y-m-d', strtotime($mytask->date_due))) {
        $mytask->date_due = 'Tomorrow';
      } else {
        $mytask->date_due = date('D m/d', strtotime($mytask->date_due));
      }
    }
    
		return view('tasks.list')
        ->with([
            'lists'     => $lists,
            'lists_following'     => $lists_following,
            'listname'  => $listname,
            'mytasks'   => $mytasks,
            'completed_count' => $completed_count
          ]);
	}

	public function createTask(CreateTaskRequest $request)
	{ 
    if(Session::get('listcode') != "") { 
      $list = Tasklist::where('listcode', Session::get('listcode'))->first();
      $list_id = $list->id;
    } else {
      $list_id = "0";
    }
    
		Task::create([
      'user_id'     => Auth::User()->id,
      'assigned_by' => Auth::User()->id,
      'tasklist_id' => $list_id,
      'taskcode'    => Str::random(10),
      'task'        => $request->get('task')
    ]);
    
    // Add task comment
    $comment_text = "created this task";
    //$this->taskComment($task_id_instert, 'activity', $comment_text);
      
    return Redirect::to('tasks/'.Session::get('listcode'));
	}

	public function updateTask(UpdateTaskRequest $request)
	{
    // Get task id
    $task = Task::where('tasks.taskcode', '=', $request->get('taskcode'))->first(array('id'));
    
    if($request->get('type') != 'date_due') { //exclude some updates on task table
      Task::where('taskcode', $request->get('taskcode'))
            ->where('user_id', Auth::User()->id)
            ->update([
              $request->get('type') => $request->get('data')
            ]);
    }
    
    if($request->get('data') == 'open') {
      // Add task comment
      $comment_text = '<span class="glyphicon glyphicon-unchecked"></span> reopened this task';
      //$this->taskComment($task->id, 'activity', $comment_text);          
    }
    
    if($request->get('data') == 'complete') {
      Taskdate::UpdateOrCreate(['task_id' => $task->id], [
                  'task_id' => $task->id, //pkey
                  'date_complete' => \Carbon::now()
                ]);
      // Add task comment
      $comment_text = '<span class="glyphicon glyphicon-check"></span> completed this task';
      //$this->taskComment($task->id, 'activity', $comment_text);       
    }
    
    if($request->get('type') == 'user_id') {
      Task::where('taskcode', $request->get('taskcode'))
          ->update([
            'assigned_by' => Auth::User()->id
          ]);
      // Add task comment
      $comment_text = '<span class="glyphicon glyphicon-user"></span> reassigned this task';
      //$this->taskComment($task->id, 'activity', $comment_text);
      
      if($request->get('data') != Auth::User()->id) {
        $this->updateFollower($request->get('taskcode'), Auth::User()->id, 'active');
      }
      
    }
    
    if($request->get('type') == 'date_due') {
      // Format datetime
      $date = new DateTime($request->get('data'));
      $date_due = $date->format('Y-m-d H:i:s');
      
      Taskdate::UpdateOrCreate(['task_id' => $task->id], [
                  'task_id' => $task->id, //pkey
                  'date_due' => $date_due
                ]);
      // Add task comment
      $comment_text = '<span class="glyphicon glyphicon-calendar"></span> changed date due to <strong>' . $request->get('data') . '</strong>';
      //$this->taskComment($task->id, 'activity', $comment_text);
    }
	}

  public function priorityChange($priority, $taskcode)
  {
    Task::where('taskcode', '=', $taskcode)
              ->where('user_id', Auth::User()->id)
              ->update([
                  'priority' => $priority
               ]);
    
    if($priority == '3') { $priority_text = '<span class="label label-danger">high</span>'; }
    if($priority == '2') { $priority_text = '<span class="label label-warning">medium</span>'; }
    if($priority == '1') { $priority_text = '<span class="label label-primary">low</span>'; }

    // Add task comment
    $comment_text = "changed the task priority to " . $priority_text;
    //$this->taskComment($task->id, 'activity', $comment_text);
      
    return Redirect::to('tasks/'.Session::get('listcode'));
  }
  
  public function refreshList()
  {
    Taskrefresh::UpdateOrCreate(['user_id' => Auth::User()->id], [
                'user_id' => Auth::User()->id, //pkey
                'date_refresh' => \Carbon::now()
              ]);
    return Redirect::to('tasks/'.Session::get('listcode'));
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
  
	public function removeList()
	{
		Tasklist::where('user_id', Auth::User()->id)
            ->where('listcode', \Input::get('listcode'))
            ->update([
              'status' => 'disabled'
            ]);
	}
  
  public function showTask($taskcode) {
    
    $taskdata = Task::leftjoin('users', 'tasks.user_id', '=', 'users.id')
              ->leftjoin('taskdates', 'tasks.id', '=', 'taskdates.task_id')
              ->leftjoin('tasklists', 'tasklists.id', '=', 'tasks.tasklist_id')
              ->where('tasks.taskcode', '=', $taskcode)
              ->where('tasks.status', '!=', 'disabled')
              ->first(array('tasks.id', 'tasks.user_id', 'tasks.taskcode', 'users.name', 'tasks.task', 'tasks.status', 'tasks.priority', 'taskdates.date_due'));
    
    $taskfollowers = Taskfollower::leftjoin('users', 'taskfollowers.user_id', '=', 'users.id')
              ->leftjoin('tasks', 'taskfollowers.task_id', '=', 'tasks.id')
              ->where('taskfollowers.task_id', '=', $taskdata->id)
              ->where('taskfollowers.status', '=', 'active')
              ->where('taskfollowers.user_id', '!=', $taskdata->user_id)
              ->get(array('taskfollowers.id', 'tasks.taskcode', 'taskfollowers.user_id', 'users.name'));
//    
//    $attachments = \DB::table('taskattachments')
//              ->leftjoin('s3files', 'taskattachments.file_id', '=', 's3files.id')
//              ->where('task_id', '=', $taskdata->id)
//              ->where('status', '=', 'active')
//              ->orderby('s3files.file_name', 'asc')
//              ->get();
//    
//    $activitys = \DB::table('taskcomments')
//              ->leftjoin('users', 'taskcomments.user_id', '=', 'users.id')
//              ->where('taskcomments.task_id', '=', $taskdata->id)
//              ->where('taskcomments.status', '=', 'active')
//              ->orderby('taskcomments.created_at', 'asc')
//              ->get(array('users.name', 'taskcomments.user_id', 'taskcomments.comment', 'taskcomments.comment_type', 'taskcomments.created_at'));
    
    return view('tasks.info')
            ->with(array(
              'taskdata' => $taskdata,
              'taskfollowers' => $taskfollowers,
              //'attachments' => $attachments,
              //'activitys' => $activitys,
              //'functionscontroller' => new FunctionsController
            ));
  }

  public function updateFollower($taskcode, $user_id, $status) {

    // Get post data from javascript
    if($taskcode==null) {
      $taskcode = Input::get('taskcode');
    }
    if($user_id==null) {
      $user_id = Input::get('user_id');
    }
    if($status==null) {
      $status = Input::get('status');
    }
    
    // Get task id
    $task = Task::where('tasks.taskcode', '=', $taskcode)->first(array('id'));
    
    // Check if user is already assigned and update status
    $taskfollower = Taskfollower::where('task_id', $task->id)
            ->where('user_id', $user_id)
            ->first();
    
    if(count($taskfollower) > 0) {
      // Update status
      Taskfollower::where(['task_id'=>$task->id])
          ->where('user_id', $user_id)
          ->update(['status' => $status]);
    } else {
      // Create new entry
      Taskfollower::create([
          'task_id' => $task->id,
          'user_id' => $user_id,
          'status' => $status
      ]);
    }
  }
}