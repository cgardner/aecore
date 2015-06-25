<?php namespace App\Http\Controllers;

use App\Repositories\ProjectUserRepository;
use App\Repositories\UserRepository;
use Illuminate\View\View;
use Session;

class PdfsController extends Controller
{
    /**
     * @var ProjectUserRepository
     */
    private $projectUserRepository;

    /**
     * Create a new controller instance.
     * @param ProjectUserRepository $projectUserRepository
     */
    public function __construct(ProjectUserRepository $projectUserRepository)
    {
        $this->middleware('auth');
        $this->middleware('project.permissions');

        $this->projectUserRepository = $projectUserRepository;
    }

    /**
     * Open the print options modal
     */
    public function pdfModal($view)
    {
        return view($view . '.modals.print-log');
    }
    
    /**
     * Send session variable to print specific object
     */
    public function pdf($type)
    {
        return view('pdfs.' . $type);
    }

}
