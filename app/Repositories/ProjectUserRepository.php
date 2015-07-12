<?php
namespace App\Repositories;

use App\Models\Project;
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
    public function findActiveForUser($userId, $projectFilter)
    {
        $query = $this->model
            ->newQuery()
            ->where('projectusers.user_id', '=', $userId)
            ->where('projectusers.status', '=', Projectuser::STATUS_ACTIVE)
            ->whereHas(
                'project',
                function ($query) use ($projectFilter) {
                    if($projectFilter == 'All Active') {
                        $query->where('projects.status', '!=', Project::STATUS_ARCHIVED);
                    } else {
                        $query->where('projects.status', '=', $projectFilter);
                    }
                }
            );
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