<?php
namespace App\Repositories;

abstract class RepositoryTestCase extends \TestCase
{

    /**
     * @var \Mockery\MockInterface|\App\Models\User
     */
    protected $model;

    /**
     * @var UserRepository
     */
    protected $repository;

    public function setUp()
    {
        parent::setUp();
    }

    public function testCreate()
    {
        $attributes = [
            'key1' => uniqid(),
            'key2' => uniqid()
        ];
        $this->model
            ->shouldReceive('create')
            ->once()
            ->with($attributes)
            ->andReturnSelf();

        $project = $this->repository
            ->create($attributes);

        $this->assertSame($this->model, $project);
    }

    public function testFind()
    {
        $this->model
            ->shouldReceive('newQuery->find')
            ->once()
            ->andReturn($this->model);

        $project = $this->repository
            ->find(1);

        $this->assertSame($this->model, $project);
    }

    public function testAll()
    {
        $this->model
            ->shouldReceive('newQuery->get')
            ->once()
            ->andReturn([$this->model]);

        $projects = $this->repository
            ->all();

        $this->assertEquals([$this->model], $projects);
    }

    public function testDestroy()
    {
        $this->model
            ->shouldReceive('getKeyName')
            ->andReturn('id');

        $this->model
            ->shouldReceive('newQuery->getQuery->whereIn->get')
            ->andReturn([$this->model]);

        $this->model
            ->shouldReceive('delete')
            ->andReturn(true);

        $count = $this->repository
            ->destroy(1);

        $this->assertEquals(1, $count);
    }

    public function testMagicCallMethodCallsTheModelMethod()
    {
        $expectation = $this->model
            ->shouldReceive('getGlobalScopes')
            ->once();

        $this->repository
            ->getGlobalScopes();

        $this->assertNotFalse($expectation->verify());
    }

    /**
     * @expectedException \App\Repositories\Exception\MethodNotFoundException
     * @expectedExceptionMessage shouldNotExist is not a valid method
     */
    public function testMagicCallThrowsExceptionWhenMethodDoesNotExist()
    {
        $this->repository
            ->shouldNotExist();
    }
}