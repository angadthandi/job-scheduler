<?php

require_once __DIR__ . "/../job/job.php";

class Scheduler {

    private array $jobs; // Job[]
    private array $fcfsMinHeap; // MinHeap[] -- first come first serve
    private array $sjfMinHeap; // MinHeap[] -- shortest job first
    private array $fpsMinHeap; // MinHeap[] -- fixed priority scheduling
    private array $edfMinHeap; // MinHeap[] -- earliest deadline first

    public function __construct() {
        
    }

}