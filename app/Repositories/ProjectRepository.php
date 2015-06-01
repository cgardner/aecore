<?php
namespace App\Repositories;

use App\Models\Project;
use App\Models\User;
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
     * @param User $user
     * @return Collection
     */
    public function forUser(User $user)
    {
        return \DB::table('projects')
            ->select('projects.*')
            ->leftJoin('projectusers', 'projectusers.project_id', '=', 'projects.id')
            ->where('projectusers.user_id', '=', $user->id)
            ->get();
    }
}