<?php
namespace App\Repositories;

use App\Models\RfiComment;

class RfiCommentRepository extends AbstractRepository
{
    /**
     * @var RfiComment
     */
    protected $model;

    /**
     * RfiCommentRepository constructor.
     * @param RfiComment $model
     */
    public function __construct(RfiComment $model)
    {
        $this->model = $model;
    }
}