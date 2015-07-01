<?php
namespace App\Repositories;

use App\Models\Project;
use App\Models\Projectuser;
use App\Models\User;
use DB;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

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

    /**
     * Get a collection of projects for the given user.
     *
     * @param integer $userId
     * @codeCoverageIgnore
     * @return \Illuminate\Database\Eloquent\Model[]
     */
    public function findActiveProjectsForUser($userId)
    {
        
        $query = $this->model
            ->newQuery()
            ->where('projects.status', '!=', Project::STATUS_ARCHIVED)
            ->whereHas(
                'projectuser',
                function (Builder $query) use ($userId) {
                    $query->has('user')
                        ->where('projectusers.status', '!=', Projectuser::STATUS_DISABLED)
                        ->where('projectusers.user_id', '=', $userId);
                }
            );

        return $query->getModels();
    }
}