<?php

require_once __DIR__ . "/../minheap/minheap.php";
require_once __DIR__ . "/../maxheap/maxheap.php";
require_once __DIR__ . "/../job/job.php";

class Scheduler {

    public const FCFS = 0;
    public const SJF = 1;
    public const FPS = 2;
    public const EDF = 3;

    private array $jobs; // Job[]
    private array $fcfsMinHeap; // MinHeap[] -- first come first serve
    private array $sjfMinHeap; // MinHeap[] -- shortest job first
    private array $fpsMinHeap; // MinHeap[] -- fixed priority scheduling
    private array $edfMinHeap; // MinHeap[] -- earliest deadline first

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
        Int $num
    ): array {
        return [];
    }

}