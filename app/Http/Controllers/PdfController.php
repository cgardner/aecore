<?php namespace App\Http\Controllers;

    use Illuminate\View\View;
    use App\Http\Requests;
    use App\Repositories\UserRepository;    
    use App\Repositories\ProjectUserRepository;
    use Session;
    
    use App\Models\User;
    use App\Models\Useravatar;
    use App\Models\Companylogo;
    use App\Models\Task;
      
  use Carbon;
  use DateTime;
  use Timezone;
  use Hash;
  use DB;
  use URL;
  use Response;
  use TCPDF;
  
    
class MYPDF extends TCPDF {
    
    //Page header
    public function Header() {
      
        global $page_title;
        global $page_subtitle;
            
        //Company logo
        $logo = new companylogo();
        $image_file = $logo->getCompanyLogo(\Auth::User()->company_id);
        list($width, $height) = getimagesize($image_file);
        if ($width > ($height*3)) { 
            $img_ht = "0.5";
        } elseif($width > ($height*2)) { 
            $img_ht = "0.65";
        } else { 
            $img_ht = "0.75";
        }

        $this->Image($image_file, '', '', '', $img_ht, '', '', 'T', false, 300, '', false, false, 0, false, false, false);
        // Set font
        $this->SetFont('helvetica', 'B', 20);
        // Title
        $this->SetFillColor(240,50,20);
        //Cell($w,$h = 0,$txt = '',$border = 0,$ln = 0,$align = '',$fill = false,$link = '',$stretch = 0,$ignore_min_height = false,$calign = 'T',$valign = 'M')
        $this->Cell(0, 0, $page_title, 0, false, 'R', false, '', 0, false, 'T', 'T');
        $this->Ln();
        $this->SetFont('helvetica', 'R', 12);
        $this->Cell(0, 0, $page_subtitle, 0, false, 'R', false, '', 0, false, 'T', 'T');
        $this->Ln();
    }

    // Page footer
    public function Footer() {
        // Position at 15 mm from bottom
        $this->SetY(-0.5);
        // Set font
        $this->SetFont('helvetica', 'I', 8);
        // Page number
        $this->Cell(3, 0.3, Session::get('company_name'), 0, false, 'L', false, '', 0, false, 'T', 'M');
        $this->Cell(0, 0.3, 'Page ' . $this->PageNo() . ' of ' . $this->getNumPages(), 0, false, 'R', false, '', 0, false, 'T', 'M');
    }
}

class PdfController extends Controller {
  
    /**
     * @var ProjectUserRepository
     */
    private $projectUserRepository;

    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * Create a new controller instance.
     * @param ProjectUserRepository $projectUserRepository
     * @param UserRepository $userRepository
     */
    public function __construct(
                        ProjectUserRepository $projectUserRepository,
                        UserRepository $userRepository
                    )
    {
        $this->middleware('auth');
        $this->middleware('project.permissions'); 

        $this->projectUserRepository = $projectUserRepository;
        $this->userRepository = $userRepository;
    }
      
    private function pdfDefaults() {

        $pdf = new MYPDF('P', 'in', 'LETTER', true, 'UTF-8', false);

        // Extend page margin based on logo size
        $logo = new companylogo();
        $image_file = $logo->getCompanyLogo(\Auth::User()->company_id);
        list($width, $height) = getimagesize($image_file);
        if($width > ($height*3)) { $img_ht = "0.5"; } elseif($width > ($height*2)) { $img_ht = "0.65"; } else { $img_ht = "0.75"; }

        // set margins
        $pdf->SetMargins(0.5, 0.75+$img_ht, 0.5);
        $pdf->SetHeaderMargin(0.5);
        $pdf->SetFooterMargin(0.5);

        // set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor(\Auth::User()->name);
        
        //set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, 0.5);
        
        return $pdf;
    }

    public function pdfTeam() {

        $pdf = $this->pdfDefaults();

        $project = \Session::get('project');

        global $page_title;
        $page_title = 'Project Directory';

        global $page_subtitle;
        $page_subtitle = '#' . $project->number . ' ' . $project->name;
        $file_name = Timezone::convertFromUTC(Carbon::now(), \Auth::user()->timezone, 'Y-m-d') . ' Project Directory';
        $pdf->SetTitle($file_name);

        $pdf->SetFont('helvetica', 'R', 10);

        /** @var Model[] $collaborators */
        $collaborators = $this->projectUserRepository
            ->findActiveByProject($project->id);
        
        $html = '<p>' . Timezone::convertFromUTC(Carbon::now(), \Auth::user()->timezone, 'F d, Y') . '</p>';

        $html = $html.'<table border="0">';
        foreach($collaborators AS $collaborator) {
          $html = $html.'
            <tr>
              <td style="width:45px;"><img src="' . $collaborator->user->gravatar . '" height="37px;" width="37px;" /></td>
              <td style="width:150px;">
                <strong>' . $collaborator->user->name . '</strong><br>
                ' . $collaborator->user->title . '<br>
                ' . '<a href="mailto:' . $collaborator->user->email . '">' . $collaborator->user->email . '</a>
              </td>
              <td style="width:180px;">
                ' . $collaborator->user->company->name . '<br>
                ' . $collaborator->user->company->companylocation->street . '<br>
                ' . $collaborator->user->company->companylocation->city . ', ' . $collaborator->user->company->companylocation->state . ' ' . $collaborator->user->company->companylocation->zipcode . '
              </td>
              <td style="width:164px;">
                ' . 'Mobile: ' . $collaborator->user->userphone->mobile . '<br>
                ' . 'Direct: ' . $collaborator->user->userphone->direct . '<br>
                ' . 'Office: ' . $collaborator->user->company->phone . '
              </td>
            </tr>
            <tr><td colspan="4" style="border-bottom:1px solid #ddd;"></td></tr>
            <tr><td colspan="4"></td></tr>';
        }
        $html = $html.'</table>';

        $pdf->AddPage();
        $pdf->writeHTML($html, true, false, true, false);

        // Output PDF document
        return Response::make($pdf->Output($file_name, 'I'), 200, array('Content-Type' => 'application/pdf'));

    }

    public function pdfTaskList() {

        $pdf = $this->pdfDefaults();

        $project = \Session::get('project');

        global $page_title;
        $page_title = 'My Tasks';

        global $page_subtitle;
        $page_subtitle = Timezone::convertFromUTC(Carbon::now(), \Auth::user()->timezone, 'F d, Y');
        $file_name = Timezone::convertFromUTC(Carbon::now(), \Auth::user()->timezone, 'Y-m-d') . ' Task List';
        $pdf->SetTitle($file_name);

        $pdf->SetFont('helvetica', 'R', 12);

        $filter = 'open';

        // Get tasks for active list
        $tasks = Task::leftjoin('taskdates', 'tasks.id', '=', 'taskdates.task_id')
                ->leftjoin('taskrefreshdates', 'tasks.user_id', '=', 'taskrefreshdates.user_id')
                ->leftjoin('tasklists', 'tasklists.id', '=', 'tasks.tasklist_id')
                ->where('tasks.user_id', '=', \Auth::User()->id)
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
                ->orderby('tasklists.list', 'asc')
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

        
        $html = '<table border="0" cellpadding="1" mobilepadding="3" mobilespacing="0">';
        $last = '';
        foreach($tasks as $task) {
            
            $current = $task->list;
            if ($last != $current) {
                if($current != "") {
                    $html = $html . '
                        <tr>
                            <td colspan="3"></td>
                        </tr>';
                }
                $html = $html . '
                    <tr>
                        <td colspan="3" style="font-weight:bold;">' . $current . '</td>
                    </tr>';
                $last = $current;
            }
        
            $html = $html.'
                <tr>
                  <td style="width:14px;"><img src="' . URL::asset('css/img/sprites/checkbox.png') . '"/></td>
                  <td style="width:5px;"></td>
                  <td style="width:520px;">' . $task->task . '</td>
                </tr>';
        }
        $html = $html.'</table>';

        $pdf->AddPage();
        $pdf->writeHTML($html, true, false, true, false);

        // Output PDF document
        return Response::make($pdf->Output($file_name, 'I'), 200, array('Content-Type' => 'application/pdf'));

    }

      public function pdfDrawingLog() {

        global $page_title;
        $page_title = 'Drawing Log';

        global $page_subtitle;
        $page_subtitle = '';

        $file_name = Timezone::convertFromUTC(Carbon::now(), \Auth::user()->timezone, 'Y-m-d') . ' Drawing Log';

        $pdf = new MYPDF('P', 'in', 'LETTER', true, 'UTF-8', false);

        // set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor(\Auth::User()->name);
        $pdf->SetTitle($file_name);

        // Extend page margin based on logo size
        $logo = new companylogo();
        $image_file = $logo->getCompanyLogo(\Auth::User()->company_id);
        list($width, $height) = getimagesize($image_file);
        if($width > ($height*3)) { $img_ht = "0.5"; } elseif($width > ($height*2)) { $img_ht = "0.65"; } else { $img_ht = "0.75"; }

        // set margins
        $pdf->SetMargins(0.5, 0.75+$img_ht, 0.5);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        //set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        $listcode = null;
        $filter = 'active';

        $sheets = DB::table('plansetsheets AS t1')
                ->leftjoin('plansets', 'plansets.id', '=', 't1.planset_id')
                ->leftjoin('plansetsheets AS t2', function($query) {
                  $query->on('t1.sheet_number','=','t2.sheet_number');
                  $query->on('t1.sheet_revision','<','t2.sheet_revision');
                })
                ->where('plansets.project_id', '=', Session::get('project_id'))
                ->where('t1.sheet_status', '=', 'processed')
                ->where('t2.id', null)
                ->orderby('t1.sheet_discipline', 'asc')
                ->orderby(DB::raw('LENGTH(t1.sheet_number) asc, t1.sheet_number'), 'asc')
                ->get(array('t1.*', 'plansets.set_name'));

        $pdf->SetFont('helvetica', 'R', 10);

        $html = '<p>' . Timezone::convertFromUTC(Carbon::now(), \Auth::user()->timezone, 'F d, Y') . '</p>';
        $html = $html.'<p>Project #'.Session::get('project_number') . '<br>' . Session::get('project_name') . '</p>';

        $html = $html.'<table border="0" cellpadding="4" cellspacing="0">
            <thead>
              <tr style="background-color:#000; color:#FFF; font-weight:bold;">
                <th style="width:60px;">Number</th>
                <th style="width:215px;">Title</th>
                <th style="width:70px;">Date</th>
                <th style="width:30px;text-align:center;">Rev</th>
                <th style="width:163px;">Set Name</th>
              </tr>
            </thead>
            <tbody>';
        foreach($sheets AS $i => $sheet) {
          if(($i % 2 != 0)) {
            $background = 'background-color:#f2f2f2;';
          } else {
            $background = '';
          }

          $html = $html.'
              <tr>
                <td style="width:60px; ' . $background . '">' . $sheet->sheet_number . '</td>
                <td style="width:215px; ' . $background . '">' . $sheet->sheet_name . '</td>
                <td style="width:70px; ' . $background . '">' . date('m-d-Y', strtotime($sheet->sheet_date)) . '</td>
                <td style="width:30px;text-align:center; ' . $background . '">' . $sheet->sheet_revision . '</td>
                <td style="width:163px; ' . $background . '">' . $sheet->set_name . '</td>
              </tr>';
        }
        $html = $html.'</tbody></table>';

        $pdf->AddPage();
        $pdf->writeHTML($html, true, false, true, false);

        // Output PDF document
        return Response::make($pdf->Output($file_name, 'I'), 200, array('Content-Type' => 'application/pdf'));

    }  
}