<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Models\RfiComment;
use App\Repositories\RfiCommentRepository;
use Illuminate\Http\Request;

class RfiCommentController extends Controller
{
    /**
     * @var RfiCommentRepository
     */
    private $rfiCommentRepository;

    /**
     * RfiCommentController constructor.
     * @param RfiCommentRepository $rfiCommentRepository
     */
    public function __construct(RfiCommentRepository $rfiCommentRepository)
    {
        $this->rfiCommentRepository = $rfiCommentRepository;
    }

    /**
     * Store the comments to the database.
     *
     * @param integer $rfiId RFI Id
     * @param Request $request Request Information
     * @return RfiComment
     */
    public function store($rfiId, Request $request)
    {
        return $this->rfiCommentRepository
            ->create([
                'rfi_id' => $rfiId,
                'comment' => $request->get('comment'),
                'created_by' => Auth::user()->id
            ]);
    }
}
