<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Input;
use Auth;
use DB;
use Response;

// Models
use App\Models\Company;
use App\Models\Companylogo;
use App\Models\User;
use App\Models\Useravatar;
use App\Models\Tasklist;

class AutocompleteController extends Controller {

  public function findCompanies() {

    // Get search term
    $term = Input::get('term');

    // Run query
    $result = Company::where('companys.name', 'ILIKE', '%'.trim($term).'%')->orderBy('companys.name', 'asc')
              ->leftjoin('companylocations', 'companys.id', '=', 'companylocations.company_id')
              ->get(array(
                  'companys.id',
                  'companys.name',
                  'companylocations.city',
                  'companylocations.state'
                ));

    // Build array
    $data = array();
    $companylogo = new Companylogo;

    foreach($result as $row){

      if ($row->city != "" && $row->state != "") {
        $location = $row->city . ', ' . $row->state;
      } elseif ($row->city != "" && $row->state == "") {
        $location = $row->city;
      } else {
        $location = '';
      }

      $data[] = array(
        'value'=>$row->id,
        'label'=>$row->name,
        'logo'=>'<img class="avatar_company" src="' . $companylogo->getCompanyAvatar($row->id) . '"/>',
        'location'=>'<span class="small text-muted">' . $location . '</span>'
      );
    }
    // Return array data
    return Response::json($data);
  }

  public function findUsers() {

    // Get search term
    $term = Input::get('term');

    // Run query
    $result = User::where('users.name', 'ILIKE', '%'.trim($term).'%')
              ->where('users.status', '=', 'active')
              ->where('users.id', '!=', Auth::User()->id)
              ->orderBy('users.name', 'asc')
              ->get(array(
                  'users.id',
                  'users.usercode',
                  'users.name',
                  'users.title'
                ));

    // Build array
    $data = array();
    $useravatar = new Useravatar;

    foreach($result as $row){
      
      if($row->title == "") {
        $row->title = "No title";
      }
      
      $data[] = array(
        'value'     => $row->id,
        'usercode'  => $row->usercode,
        'label'     => $row->name,
        'title'     => $row->title,
        'avatar'    => '<img class="avatar_company" src="' . $useravatar->getUserAvatar($row->id, 'sm') . '"/>'
      );
    }
    
    // Return array data
    return Response::json($data);
  }

  public function findTasklists() {

    // Get search term
    $term = Input::get('term');

    // Run query
    $result = Tasklist::where('tasklists.list', 'ILIKE', '%'.trim($term).'%')
              ->where('tasklists.status', '=', 'active')
              ->where('tasklists.user_id', '=', Auth::User()->id)
              ->orderBy('tasklists.list', 'asc')
              ->get(array(
                  'tasklists.id',
                  'tasklists.listcode',
                  'tasklists.list'
                ));

    // Build array
    $data = array();

    foreach($result as $row){
      
      if($row->title == "") {
        $row->title = "No title";
      }
      
      $data[] = array(
        'value'     => $row->id,
        'label'     => $row->list
      );
    }
    
    // Return array data
    return Response::json($data);
  }
  
}
