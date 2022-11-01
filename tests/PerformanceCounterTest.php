<?php

namespace ClarkeTech\PerformanceCounter\Tests;

use ClarkeTech\PerformanceCounter\PerformanceCounter;
use PHPUnit\Framework\TestCase; // PHPUnit is a unit testing framework for PHP

class PerformanceCounterTest extends TestCase
{
    private string $counterKey1 = 'test_counter1'; // private properties can only be accessed by the class itself
    private string $counterKey2 = 'test_counter2'; 
    private PerformanceCounter $unit;

    protected function setUp(): void
    {
        $this->unit = PerformanceCounter::getInstance();
        $this->unit->reset();
    }

    /**
     * Summary of average_process_time_can_be_obtained_for_multiple_keys
     * @return void
     */
    public function average_process_time_can_be_obtained_for_multiple_keys()
    {
        $this->unit->timeIterationStart($this->counterKey1);

        usleep(random_int(100, 100000));

        for ($i = 1; $i <= 5; $i++) {
            $this->unit->timeIterationStart($this->counterKey2); // $this->unit is an instance of the PerformanceCounter class
            usleep(random_int(100, 100000)); // usleep pauses execution for a given number of microseconds 
            $this->unit->timeIterationEnd($this->counterKey2); // timeIterationEnd is a method of the PerformanceCounter class
        }

        $this->unit->timeIterationEnd($this->counterKey1);

        $this->assertGreaterThan(10, $this->unit->getAverageIterationTime($this->counterKey1));
        $this->assertLessThan(100, $this->unit->getAverageIterationTime($this->counterKey2));
    }

    /**
     * Summary of a_key_can_be_cleared
     * @return void
     */
    public function a_key_can_be_cleared()
    {
        $this->unit->timeIterationStart($this->counterKey1);

        $this->unit->timeIterationStart($this->counterKey2);

        $this->unit->clearKey($this->counterKey2);

        $this->assertContains($this->counterKey1, $this->unit->getKeys());
        $this->assertNotContains($this->counterKey2, $this->unit->getKeys());
    }

    /**
     * Summary of the_counter_can_be_reset
     * @return void
     */
    public function the_counter_can_be_reset()
    {
        $this->unit->timeIterationStart($this->counterKey1);

        $this->unit->timeIterationStart($this->counterKey2);

        $this->unit->reset();

        $this->assertEmpty($this->unit->getKeys());
    }
}