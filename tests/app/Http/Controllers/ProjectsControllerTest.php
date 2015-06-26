<?php
use App\Models\Project;
use App\Models\User;

/**
 * @coversDefaultClass \App\Http\Controllers\ProjectsController
 */
class ProjectsControllerTest extends \TestCase
{
    /**
     * @var User
     */
    private $user;

    public function setUp()
    {
        parent::setUp();
        $this->user = new User(
            ['company_id' => 1, 'company_user_status' => 'active', 'timezone' => 'America/Los_Angeles']
        );
    }

    public function testStoreSavesNewProject()
    {
        $this->be($this->user);

        $project = new Project(['id' => 123]);

        $projectRepository = Mockery::mock('\App\Repositories\AbstractRepository, \App\Repositories\ProjectRepository');

        $projectRepository->shouldReceive('create')
            ->once()
            ->andReturn($project);

        $this->app
            ->instance('App\Repositories\ProjectRepository', $projectRepository);

        $this->call('POST', 'projects');
        $this->assertRedirectedToRoute('projects.index');
    }

    public function testProjectShowRedirectsToDashboard()
    {
        $this->be($this->user);

        $project = new Project(['company_id' => 1]);

        $projectRepository = Mockery::mock('\App\Repositories\AbstractRepository, \App\Repositories\ProjectRepository');
        $this->app
            ->instance('App\Repositories\ProjectRepository', $projectRepository);

        $projectRepository->shouldReceive('find')
            ->with(1)
            ->andReturn($project);

        $this->call('GET', 'projects/1');

        $this->assertRedirectedTo('dashboard', ['project' => $project]);
    }

    public function testProjectShowRedirectsToProjectListWhenNoProjectFound()
    {
        $this->be($this->user);

        $projectRepository = Mockery::mock('\App\Repositories\AbstractRepository, \App\Repositories\ProjectRepository');
        $this->app
            ->instance('App\Repositories\ProjectRepository', $projectRepository);

        $projectRepository->shouldReceive('find')
            ->with(1)
            ->andReturn(null);

        $this->call('GET', 'projects/1');

        $this->assertRedirectedTo('projects');
    }
}