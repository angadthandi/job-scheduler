<?php

class MinHeap extends SplMinHeap
{
    public function compare($item1, $item2) {
        if (is_array($item1) && is_array($item2)) {
            $zeroIdxDiff = (int) $item2[0] - $item1[0];
            // error_log('zeroIdxDiff: ' . $zeroIdxDiff);
            // error_log($item1[0] . ' - ' . $item2[0]);
            if ($zeroIdxDiff == 0) {
                // error_log('ethe');
                // error_log($item1[1] . ' - ' . $item2[1]);
                return (int) $item2[1] - $item1[1];
            }
            return $zeroIdxDiff;
        }
        return (int) $item2 - $item1;
    }
}