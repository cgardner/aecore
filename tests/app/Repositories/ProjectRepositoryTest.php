<?php
namespace App\Repositories;

class ProjectRepositoryTest extends RepositoryTestCase
{

    /**
     * @var \Mockery\MockInterface|\App\Models\Project
     */
    protected $model;

    /**
     * @var ProjectRepository
     */
    protected $repository;

    public function setUp()
    {
        parent::setUp();
        $this->model = $this->createMockModel('\App\Models\Project');

        $this->repository = new ProjectRepository($this->model);
    }
}
