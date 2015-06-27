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
            ->where('project_id', '=', $projectId)
            ->where('status', '!=', 'disabled');
        return $query->getModels();
    }

    /**
     * Find Active Projects that a user has access to.
     * @param $userId
     * @return \Illuminate\Database\Eloquent\Model[]
     */
    public function findActiveForUser($userId)
    {
        $query = $this->model
            ->newQuery()
            ->where('user_id', '=', $userId)
            ->where('status', '=', Projectuser::STATUS_ACTIVE);
        return $query->getModels();
    }

    /**
     * Find current project user
     * @param $userId
     * @return Projectuser
     */
    public function findByUserId($userId, $projectId)
    {
        $query = $this->model
            ->newQuery()
            ->where('user_id', '=', $userId)
            ->where('project_id', '=', $projectId);
        return $query->first();
    }
}