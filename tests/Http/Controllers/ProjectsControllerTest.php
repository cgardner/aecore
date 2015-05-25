<?php
use App\Models\Project;
use App\Models\User;
use Illuminate\Support\Facades\Redirect;

class ProjectsControllerTest extends \TestCase
{
    public function testStoreSavesNewProject()
    {
        $user = new User();
        $user->company_id = 1;
        $user->company_user_status = 'active';

        $this->be($user);

        $this->createMock('App\Models\Project')
            ->shouldReceive('create')
            ->once()
            ->andReturnSelf();

        $this->call('POST', 'projects');
        $this->assertRedirectedToRoute('projects.index');
    }

    public function testProjectEditPageRedirectsUserToProjectsListWhenEditingAProjectTheyDidntCreate()
    {
        $this->markTestIncomplete();
        $user = new User();
        $user->id = 1;
        $user->company_id = 1;
        $user->company_user_status = 'active';

        $this->be($user);

        $project = new Project();
        $project->company_id = 2;

        $this->createMock('App\Models\Project', ['find'])
            ->shouldReceive('find')
            ->once()
            ->andReturn($project);

        $response = $this->call('GET', 'projects/1/edit');
        dd($response->getContent());
        $this->assertRedirectedToRoute('projects.index');
    }


}