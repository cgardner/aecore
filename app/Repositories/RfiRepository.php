<?php
namespace App\Repositories;

use App\Models\Rfi;

class RfiRepository extends AbstractRepository
{
    /**
     * ProjectUserRepository constructor.
     * @param Rfi $model
     */
    public function __construct(Rfi $model)
    {
        $this->model = $model;
    }

    /**
     * Find all Active Projects for a project.
     *
     * @param $projectId
     * @return \Illuminate\Database\Eloquent\Model[]
     */
    public function findActiveByProjectId($projectId)
    {
        return $this->model
            ->newQuery()
            ->where('project_id', '=', $projectId)
            ->getModels();
    }

    /**
     * Find the next RFI Id for the project.
     * @param $projectId Integer
     */
    public function findNextRfiId($projectId)
    {
        $rfiId = $this->model
            ->newQuery()
            ->where('project_id', '=', $projectId)
            ->max('rfi_id');

        return $rfiId + 1;
    }
}