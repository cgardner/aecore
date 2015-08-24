<?php
namespace App\Repositories;

use App\Models\Rfi;

class RfiRepository extends AbstractRepository
{
    /**
     * ProjectUserRepository constructor.
     * @param Rfi|Projectuser $model
     */
    public function __construct(Rfi $model)
    {
        $this->model = $model;
    }

    public function findActiveByProjectId($projectId)
    {
        return $this->model
            ->newQuery()
            ->where('project_id', '=', $projectId)
            ->getModels();
    }
}