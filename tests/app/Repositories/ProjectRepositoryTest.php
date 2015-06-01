<?php
namespace App\Repositories;

class ProjectRepositoryTest extends \TestCase {

    /**
     * @var \Mockery\MockInterface|\App\Models\Project
     */
    private $model;

    /**
     * @var ProjectRepository
     */
    private $projectRepository;

    public function setUp()
    {
        parent::setUp();
        $this->model = $this->createMockModel('\App\Models\Project');

        $this->projectRepository = new ProjectRepository($this->model);
    }

    public function testCreate()
    {
        $attributes = [
            'key1' => uniqid(),
            'key2' => uniqid()
        ];
        $this->model
            ->shouldReceive('save')
            ->once()
            ->with($attributes)
            ->andReturnSelf();

        $project = $this->projectRepository
            ->create($attributes);

        $this->assertSame($this->model, $project);
    }

    public function testFind()
    {
        $this->model
            ->shouldReceive('newQuery->find')
            ->once()
            ->andReturn($this->model);

        $project = $this->projectRepository
            ->find(1);

        $this->assertSame($this->model, $project);
    }

    public function testAll()
    {
        $this->model
            ->shouldReceive('newQuery->get')
            ->once()
            ->andReturn([$this->model]);

        $projects = $this->projectRepository
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

        $count = $this->projectRepository
            ->destroy(1);

        $this->assertEquals(1, $count);
    }


}
