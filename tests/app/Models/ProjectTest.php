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
            ->setNow(new \DateTime('2015-06-18'));

        $finish = new \DateTime('2015-07-30');
        $this->project->finish = $finish->format('m/d/Y');

        $this->assertEquals(42, $this->project->daysLeft);
    }

    public function testGetProgressAttribute()
    {
        $this->project
            ->setNow(new \DateTime('2015-06-12'));

        $start = new \DateTime('2015-05-11');
        $finish = new \DateTime('2015-06-17');
        $this->project->finish = $finish->format('m/d/Y');
        $this->project->start = $start->format('m/d/Y');

        $this->assertEquals(86.49, $this->project->progress);
    }

    protected function setUp()
    {
        $this->project = new Project();
    }

}
