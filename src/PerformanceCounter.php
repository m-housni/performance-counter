<?php

namespace ClarkeTech\PerformanceCounter; // namespace acts as the folder path of the current file classes

/**
 * Calculates the average iteration time for a given process
 *
 * Keys can be nested which enables you to measure the performance of inner and outer loops.
 * Designed to be used as a development utility tool. Recommended to be removed from code after use.
 *
 * @see PerformanceCounterTest::average_process_time_can_be_obtained_for_multiple_keys for a demo
 * of how this works
 *
 * @author Gary Clarke <info@garyclarke.tech>
 */
final class PerformanceCounter // final class is used to prevent extension
{
    /**
     * @var array
     */
    private $startTimes = []; // private properties can only be accessed by the class itself

    /**
     * @var array
     */
    private $endTimes = []; 

    /**
     * @var array
     */
    private $iterations = []; // number of times a process has been run

    /**
     * @var array
     */
    private $totalTimes = []; // total time taken for a process to run

    /**
     * @var array
     */
    private $averageTimes = []; // average time taken for a process to run

    /**
     * @var array
     */
    private $keys = []; // keys are used to identify a process

    /**
     * @var array
     */
    private $keyStack = []; // used to track nested keys

    /**
     * @var array
     */
    private $keyStackCount = []; // used to track nested keys number

    /**
     * @var array
     */
    private $keyStackTotalTime = []; // used to track nested keys total time

    /**
     * @var array
     */
    private $keyStackAverageTime = []; // used to track nested keys average time

    /**
     * @var array
     */
    private $keyStackIterations = []; // used to track nested keys number of iterations

    /**
     * @var array
     */
    private $keyStackStartTime = []; // used to track nested keys start time

    /**
     * @var array
     */
    private $keyStackEndTime = []; // used to track nested keys end time

    /**
     * @var array
     */
    private $keyStackTotalTimeByIteration = []; // used to track nested keys total time by iteration

    /**
     * @var array
     */
    private $keyStackAverageTimeByIteration = []; // used to track nested keys average time by iteration

    /**
     * @var array
     */
    private $keyStackTotalTimeByIterationCount = []; // used to track nested keys total time by iteration count

    /**
     * @var array
     */
    private $keyStackAverageTimeByIterationCount = []; // used to track nested keys average time by iteration count

    /**
     * @var array
     */
    private $keyStackTotalTimeByIterationTotalTime = []; // used to track nested keys total time by iteration total time

    /**
     * @var array
     */
    private $keyStackAverageTimeByIterationTotalTime = []; // used to track nested keys average time by iteration total time

    /**
     * @var array
     */
    private $keyStackTotalTimeByIterationAverageTime = []; // used to track nested keys total time by iteration average time

    /**
     * @var array
     */
    private $keyStackAverageTimeByIterationAverageTime = []; // used to track nested keys average time by iteration average time

    /**
     * @var array
     */
    private $keyStackTotalTimeByIterationIterations = []; // used to track nested keys total time by iteration iterations

    /**
     * @var array
     */
    private $keyStackAverageTimeByIterationIterations = []; // used to track nested keys average time by iteration iterations
    /**
     * @var array
     */
    private $keyStackTotalTimeByIterationStartTime = []; // used to track nested keys total time by iteration start time

    /**
     * @var array
     */
    private $keyStackAverageTimeByIterationStartTime = []; // used to track nested keys average time by iteration start time

    
    private static ?self $instance = null; // $instance is used to store the instance of the class
    private array $start = []; // $start is used to store the start time of the process
    private array $iterationCount = []; // $iterationCount is used to store the number of iterations of the process
    private array $totalElapsedTime = []; // $totalElapsedTime is used to store the total elapsed time of the process
    private array $averageIterationTime = []; // $averageIterationTime is used to store the average iteration time of the process

    private function __construct()
    {
    }

    /**
     * getInstance is used to get the instance of the class
     * 
     * @return PerformanceCounter
     */
    public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * Capture the start time for one iteration for a given key
     */
    public function timeIterationStart($key): void
    {
        if (!isset($this->iterationCount[$key])) {
            $this->iterationCount[$key] = 0;
            $this->totalElapsedTime[$key] = 0;
        }

        $this->iterationCount[$key] ++;

        $this->start[$key] = microtime(true); // example: 1666545527.8784
    }

    /**
     * Capture the end time for one iteration for a given key
     * 
     * @return void
     */
    public function timeIterationEnd($key)
    {
        $endTime = microtime(true);

        $this->totalElapsedTime[$key] += round($endTime - $this->start[$key], 3) * 1000; // output in milliseconds

        $this->averageIterationTime[$key] = $this->totalElapsedTime[$key] / max($this->iterationCount[$key], 1); // prevent division by zero
    }

    /**
     * Get the average iteration time for a given key
     * 
     * @return float
     */
    public function getAverageIterationTime($key)
    {
        return $this->averageIterationTime[$key];
    }

    /**
     * Clear key
     * 
     * @return void
     */
    public function clearKey($key): void
    {
        unset(
            $this->start[$key],
            $this->iterationCount[$key],
            $this->totalElapsedTime[$key],
            $this->averageIterationTime[$key]
        );
    }

    /**
     * Reset properties
     * 
     * @return void
     */
    public function reset(): void
    {
        $this->start = [];
        $this->iterationCount = [];
        $this->totalElapsedTime = [];
        $this->averageIterationTime = [];
    }

    /**
     * change for version 1.1
     * 
     * return array
     */
    public function getKeys()
    {
        return array_keys($this->iterationCount);
    }
}