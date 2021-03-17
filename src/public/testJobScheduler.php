<?php

require_once __DIR__ . "/../app/minheap/minheap.php";
require_once __DIR__ . "/../app/job/job.php";
require_once __DIR__ . "/../app/scheduler/scheduler.php";

error_log('test job scheduler!');

// error_log('minHeapWithArrElem');
// $minHeapWithArrElem = new MinHeap();
// $minHeapWithArrElem->insert( [4, 1, []] );
// $minHeapWithArrElem->insert( [8, 2, []] );
// $minHeapWithArrElem->insert( [0, 3, []] );
// $minHeapWithArrElem->insert( [0, 4, []] );

// error_log(print_r($minHeapWithArrElem,true));

// $arrWithArrElem=[];
// $k = 3;
// foreach($minHeapWithArrElem as $arrElem) {
//     $arrWithArrElem[]=$arrElem;
//     $k -= 1;
//     if ($k==0) break;
// }
// error_log(print_r($arrWithArrElem,true));

// ---------------------------------------------------------

$job1 = new Job("J1", 10, 0, 10, Job::ROOT);
$job2 = new Job("J2", 20, 0, 40, Job::ADMIN);

$scheduler1 = new Scheduler;
$scheduler1->AddJob($job1);
$scheduler1->AddJob($job2);

$scheduler1->GetSchedulingSequence(Scheduler::FCFS, 2);
