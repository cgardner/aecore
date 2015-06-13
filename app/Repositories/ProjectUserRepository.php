<?php
namespace App\Repositories;

use App\Models\Projectuser;

class ProjectUserRepository extends AbstractRepository implements RepositoryInterface
{
    /**
     * @var Projectuser
     */
    protected $model;

    /**
     * ProjectUserRepository constructor.
     * @param Projectuser $model
     */
    public function __construct(Projectuser $model)
    {
        $this->model = $model;
    }

    /**
     * Find Active users for a project.
     * @param integer $projectId
     * @return \Illuminate\Database\Eloquent\Model[]
     * @codeCoverageIgnore
     */
    public function findActiveByProject($projectId)
    {
        $query = $this->model
            ->newQuery()
            ->where('project_id', '=', $projectId);
        return $query->getModels();
    }
}