<?php

require_once __DIR__ . "/../minheap/minheap.php";
require_once __DIR__ . "/../job/job.php";

class Scheduler {

    public const FCFS = 0;
    public const SJF = 1;
    public const FPS = 2;
    public const EDF = 3;

    private array $jobs; // Job[]
    private object $fcfsMinHeap; // MinHeap[] -- first come first serve
    private object $sjfMinHeap; // MinHeap[] -- shortest job first
    private object $fpsMinHeap; // MinHeap[] -- fixed priority scheduling
    private object $edfMinHeap; // MinHeap[] -- earliest deadline first

    public function __construct() {
        $this->jobs = [];
        $this->fcfsMinHeap = new MinHeap;
        $this->sjfMinHeap = new MinHeap;
        $this->fpsMinHeap = new MinHeap;
        $this->edfMinHeap = new MinHeap;
    }

    public function AddJob(Job $job): void {
        $this->jobs[] = $job;
        $this->fcfsMinHeap->insert(
            [$job->GetID(), 0, 0, $job]
        );
        $this->sjfMinHeap->insert(
            [$job->GetDuration(), $job->GetPriority(), 0, $job]
        );
        $this->fpsMinHeap->insert(
            [$job->GetPriority(), $job->GetUserType(),
            $job->GetDuration(), $job]
        );
        $this->edfMinHeap->insert(
            [$job->GetDeadline(), $job->GetPriority(),
            $job->GetDuration(), $job]
        );
    }

    public function GetSchedulingSequence(
        Int $scheduleAlgo,
        Int $numOfThreads
    ): array {
        // $ret = [] * $numOfThreads; // Thread[]Job[]
        $ret = array_fill(0, $numOfThreads, []); // Thread[]Job[]
        $threadCapacity = array_fill(0, $numOfThreads, 0);
        $totalTimeTaken = array_fill(0, $numOfThreads, 0);

        switch ($scheduleAlgo) {
            case self::FCFS:
                while($this->fcfsMinHeap->count() > 0) {
                    for ($i=0; $i<$numOfThreads; $i++) {
                        // error_log(
                        //     'i:' .$i .
                        //     '; threadCapacity[$i]:' . $threadCapacity[$i]
                        // );
                        if ($threadCapacity[$i] == 0) {

                            if ($this->fcfsMinHeap->count() > 0) {
                                // $count = $this->fcfsMinHeap->count();
                                // error_log('count: ' . print_r($count,true));
                                // $top = $this->fcfsMinHeap->top();
                                // error_log('top: ' . print_r($top,true));
                                // $pop = $this->fcfsMinHeap->extract();
                                // error_log('pop: ' . print_r($pop,true));
                                // $top1 = $this->fcfsMinHeap->top();
                                // error_log('top1: ' . print_r($top1,true));
                                // $count1 = $this->fcfsMinHeap->count();
                                // error_log('count1: ' . print_r($count1,true));

                                $headData = $this->fcfsMinHeap->top();
                                $job = $headData[3];
                                $ret[$i][] = $job;
                                $threadCapacity[$i] += $job->GetDuration();
                                // pop
                                $this->fcfsMinHeap->extract();
                            }
                        }
                    }
                    // error_log(print_r($threadCapacity,true));
                    $this->processThreads($threadCapacity);
                    // error_log(print_r($threadCapacity,true));
                }
                break;
            case self::SJF:
                while($this->sjfMinHeap->count() > 0) {
                    for ($i=0; $i<$numOfThreads; $i++) {
                        if ($threadCapacity[$i] == 0) {

                            if ($this->sjfMinHeap->count() > 0) {
                                $headData = $this->sjfMinHeap->top();
                                $job = $headData[3];
                                $ret[$i][] = $job;
                                $threadCapacity[$i] += $job->GetDuration();
                                // pop
                                $this->sjfMinHeap->extract();
                            }
                        }
                    }
                    $this->processThreads($threadCapacity);
                }
                break;
            case self::FPS:
                while($this->fpsMinHeap->count() > 0) {
                    for ($i=0; $i<$numOfThreads; $i++) {
                        if ($threadCapacity[$i] == 0) {

                            if ($this->fpsMinHeap->count() > 0) {
                                $headData = $this->fpsMinHeap->top();
                                $job = $headData[3];
                                $ret[$i][] = $job;
                                $threadCapacity[$i] += $job->GetDuration();
                                // pop
                                $this->fpsMinHeap->extract();
                            }
                        }
                    }
                    $this->processThreads($threadCapacity);
                }
                break;
            case self::EDF:
                while($this->edfMinHeap->count() > 0) {
                    for ($i=0; $i<$numOfThreads; $i++) {
                        if ($threadCapacity[$i] == 0) {

                            if ($this->edfMinHeap->count() > 0) {
                                $headData = $this->edfMinHeap->top();
                                $job = $headData[3];
                                $totalTimeTaken[$i] += $job->GetDuration();
                                if($totalTimeTaken[$i] <= $job->GetDeadline()) {
                                    $ret[$i][] = $job;
                                } else {
                                    $totalTimeTaken[$i] -= $job->GetDuration();
                                }
                                $threadCapacity[$i] += $job->GetDuration();
                                // pop
                                $this->edfMinHeap->extract();
                            }
                        }
                    }
                    $this->processThreads($threadCapacity);
                }
                break;
            default:
                error_log("Invalid case : " . (string)$scheduleAlgo);
                break;
        }

        return $ret;
    }

    public function processThreads(Array &$threadCapacity): void {
        $minElement = min($threadCapacity);
        for($i = 0; $i < count($threadCapacity); $i++) {
            $threadCapacity[$i] -= $minElement;
        }
    }

}