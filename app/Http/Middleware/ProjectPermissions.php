<?php
namespace App\Http\Middleware;

use App\Repositories\ProjectRepository;
use Closure;
use Illuminate\Contracts\Routing\Middleware;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class ProjectPermissions implements Middleware
{
    /**
     * @var ProjectRepository
     */
    private $projectRepository;

    public function __construct(ProjectRepository $projectRepository)
    {
        $this->projectRepository = $projectRepository;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $projectId = $request->route()
            ->getParameter('projects', false);

        if (!$projectId) {
            return $next($request);
        }

        $project = $this->projectRepository
            ->find($projectId);
        if ($project == null) {
            return new RedirectResponse(route('projects.index'));
        }

        return $next($request);
    }
}