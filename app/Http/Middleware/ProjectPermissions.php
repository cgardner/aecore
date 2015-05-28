<?php
namespace App\Http\Middleware;

use App\Models\Project;
use Closure;
use Illuminate\Contracts\Routing\Middleware;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class ProjectPermissions implements Middleware
{
    private $project;

    public function __construct(Project $project)
    {
        $this->project = $project;
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

        $project = $this->project
            ->newQuery()
            ->find($projectId);

        $user = Auth::User();
        if ($project == null || $user->company_id != $project->company_id) {
            return new RedirectResponse(route('projects.index'));
        }

        return $next($request);
    }
}