<?php
namespace App\Http\Middleware;

use App\Models\Project;
use App\Models\User;

class ProjectPermissionsTest extends \TestCase {

    /**
     * @var ProjectPermissions
     */
    private $middleware;

    /**
     * @var Project|\Mockery\MockInterface
     */
    private $project;

    /**
     * @var \Illuminate\Http\Request|\Mockery\MockInterface
     */
    private $request;

    public function setUp()
    {
        parent::setUp();

        $this->project = \Mockery::mock('\App\Models\Project');
        $this->request = \Mockery::mock('\Illuminate\Http\Request');

        $this->middleware = new ProjectPermissions($this->project);
    }


    public function testHandleOnARouteWithoutProjectParameter()
    {
        $this->request
            ->shouldReceive('route->getParameter')
            ->with('projects', false)
            ->andReturn(false);

        $response = $this->middleware
            ->handle($this->request, function(){ return 'Redirected!'; });

        $this->assertEquals('Redirected!', $response);
    }

    public function testHandleOnARouteWithProjectParameterWhereTheCompanyDoesNotMatch()
    {
        $this->request
            ->shouldReceive('route->getParameter')
            ->once()
            ->with('projects', false)
            ->andReturn(1);

        $this->project
            ->shouldReceive('newQuery->find')
            ->once()
            ->with(1)
            ->andSet('company_id', 123)
            ->andReturnSelf();


        $user = new User(['company_id' => 124]);
        \Auth::shouldReceive('User')
            ->once()
            ->andReturn($user);

        $response = $this->middleware
            ->handle($this->request, function(){});

        $this->assertInstanceOf('Illuminate\Http\RedirectResponse', $response);
    }

    public function testHandleOnARouteWithProjectParameterWhereTheCompanyDoesMatch()
    {
        $this->request
            ->shouldReceive('route->getParameter')
            ->once()
            ->with('projects', false)
            ->andReturn(1);

        $this->project
            ->shouldReceive('newQuery->find')
            ->once()
            ->with(1)
            ->andSet('company_id', 123)
            ->andReturnSelf();


        $user = new User(['company_id' => 123]);
        \Auth::shouldReceive('User')
            ->once()
            ->andReturn($user);

        $response = $this->middleware
            ->handle($this->request, function($request) { return 'Success!'; });

        $this->assertEquals('Success!', $response);
    }

    public function testHandleOnARouteWhenNoProjectExists()
    {
        $this->request
            ->shouldReceive('route->getParameter')
            ->once()
            ->with('projects', false)
            ->andReturn(1);

        $this->project
            ->shouldReceive('newQuery->find')
            ->once()
            ->with(1)
            ->andReturn(null);

        $user = new User(['company_id' => 123]);
        \Auth::shouldReceive('User')
            ->once()
            ->andReturn($user);

        $response = $this->middleware
            ->handle($this->request, function($request) { return 'Success!'; });

        $this->assertInstanceOf('Illuminate\Http\RedirectResponse', $response);
    }


}
