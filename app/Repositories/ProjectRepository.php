<?php
namespace App\Repositories;

use App\Models\Project;

class ProjectRepository extends AbstractRepository
{
    /**
     * @var Project
     */
    protected $model;

    function __construct(Project $model)
    {
        $this->model = $model;
    }
}