<?php namespace App\Providers;

use App\Models\Project;
use App\Models\Projectuser;
use Auth;
use Illuminate\Contracts\Events\Dispatcher as DispatcherContract;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{

    /**
     * The event handler mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'event.name' => [
            'EventListener',
        ],
    ];

    /**
     * Register any other events for your application.
     *
     * @param  \Illuminate\Contracts\Events\Dispatcher $events
     * @return void
     */
    public function boot(DispatcherContract $events)
    {
        parent::boot($events);

        Project::created(
            function (Project $project) {
                $user = Auth::user();
                // Add current user to this project
                Projectuser::create(
                    [
                        'project_id' => $project->id,
                        'user_id' => $user->id,
                        'access' => 'admin',
                        'role' => $user->company->type
                    ]
                );
            }
        );
    }

}
