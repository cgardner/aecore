<?php
namespace Models;

use App\Models\Project;

/**
 * @covers \App\Models\Project
 */
class ProjectTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Project
     */
    private $project;

    public function testGetDaysLeftAttribute()
    {
        $this->project
            ->setNow(new \DateTime('2015-06-01'));

        $finish = new \DateTime('2015-06-04');
        $this->project->finish = $finish->format('m/d/Y');

        $this->assertEquals(3, $this->project->daysLeft);
    }

    public function testGetProgressAttribute()
    {
        $this->project
            ->setNow(new \DateTime('2015-06-06'));

        $start = new \DateTime('2015-06-01');
        $finish = new \DateTime('2015-06-11');
        $this->project->finish = $finish->format('m/d/Y');
        $this->project->start = $start->format('m/d/Y');

        $this->assertEquals(50, $this->project->progress);
    }

    protected function setUp()
    {
        $this->project = new Project();
    }

}
