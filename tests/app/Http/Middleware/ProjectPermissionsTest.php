<?php
namespace App\Http\Middleware;

use App\Models\Project;
use App\Models\User;
use Mockery;

class ProjectPermissionsTest extends \TestCase
{

    /**
     * @var ProjectPermissions
     */
    private $middleware;

    /**
     * @var \App\Repositories\ProjectRepository|\Mockery\MockInterface
     */
    private $projectRepository;

    /**
     * @var \Illuminate\Http\Request|\Mockery\MockInterface
     */
    private $request;

    /**
     * @var User
     */
    private $user;

    /**
     * Set up the test.
     */
    public function setUp()
    {
        parent::setUp();

        $this->projectRepository = Mockery::mock(
            '\App\Repositories\AbstractRepository, \App\Repositories\ProjectRepository'
        );
        $this->request = Mockery::mock('\Illuminate\Http\Request');

        $this->middleware = new ProjectPermissions($this->projectRepository);

        $this->user = new User(['company_id' => 123, 'timezone' => 'America/Los_Angeles']);
        \Auth::shouldReceive('user')
            ->zeroOrMoreTimes()
            ->andReturn($this->user);
    }


    public function testHandleOnARouteWithoutProjectParameter()
    {
        $this->request
            ->shouldReceive('route->getParameter')
            ->with('projects', false)
            ->andReturn(false);

        $response = $this->middleware
            ->handle(
                $this->request,
                function () {
                    return 'Redirected!';
                }
            );

        $this->assertEquals('Redirected!', $response);
    }

    public function testHandleOnARouteWithProjectParameterWhereTheCompanyDoesMatch()
    {
        $this->request
            ->shouldReceive('route->getParameter')
            ->once()
            ->with('projects', false)
            ->andReturn(1);

        $project = new Project(['company_id' => 123]);

        $this->projectRepository
            ->shouldReceive('find')
            ->once()
            ->with(1)
            ->andReturn($project);

        $response = $this->middleware
            ->handle(
                $this->request,
                function () {
                    return 'Success!';
                }
            );

        $this->assertEquals('Success!', $response);
    }

    public function testHandleOnARouteWhenNoProjectExists()
    {
        $this->request
            ->shouldReceive('route->getParameter')
            ->once()
            ->with('projects', false)
            ->andReturn(1);

        $this->projectRepository
            ->shouldReceive('find')
            ->once()
            ->with(1)
            ->andReturn(null);

        $response = $this->middleware
            ->handle(
                $this->request,
                function () {
                    return 'Success!';
                }
            );

        $this->assertInstanceOf('Illuminate\Http\RedirectResponse', $response);
    }


}
