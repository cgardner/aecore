<?php
use App\Models\Project;
use App\Models\User;

class ProjectsControllerTest extends \TestCase
{
    public function testStoreSavesNewProject()
    {
        $user = new User(['company_id' => 1, 'company_user_status' => 'active']);

        $this->be($user);

        $this->createMockModel('App\Models\Project')
            ->shouldReceive('create')
            ->once()
            ->andReturnSelf();

        $this->call('POST', 'projects');
        $this->assertRedirectedToRoute('projects.index');
    }

    public function testProjectEditPageRedirectsUserToProjectsListWhenEditingAProjectTheyDidNotCreate()
    {
        $user = new User(['id' => 1, 'company_id' => 1, 'company_user_status' => 'active']);

        $this->be($user);

        $project = new Project(['company_id' => 2]);

        $mockProject = $this->createMock('App\Models\Project', 'App\Models\Project');

        $mockProject->shouldReceive('newQuery->find')
            ->with(1)
            ->andReturn($project);

        $this->call('GET', 'projects/1/edit');
        $this->assertRedirectedToRoute('projects.index');
    }

    public function testProjectShowRedirectsToDashboard()
    {
        $user = new User(['id' => 1, 'company_id' => 1, 'company_user_status' => 'active']);

        $this->be($user);

        $project = new Project(['company_id' => 1]);

        $mockProject = $this->createMock('App\Models\Project', 'App\Models\Project');

        $mockProject->shouldReceive('newQuery->find')
            ->with(1)
            ->andReturn($project);

        $this->call('GET', 'projects/1');

        $this->assertRedirectedTo('dashboard', ['project' => $project]);
    }

    public function testProjectShowRedirectsToProjectListWhenNoProjectFound()
    {
        $user = new User(['id' => 1, 'company_id' => 1, 'company_user_status' => 'active']);

        $this->be($user);

        $mockProject = $this->createMock('App\Models\Project', 'App\Models\Project');

        $mockProject->shouldReceive('newQuery->find')
            ->with(1)
            ->andReturn(null);

        $this->call('GET', 'projects/1');

        $this->assertRedirectedTo('projects');
    }
}