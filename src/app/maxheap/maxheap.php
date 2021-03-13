<?php
class MaxHeap extends SplMaxHeap
{
    public function compare($item1, $item2) {
        if (is_array($item1) && is_array($item2)) {
            $zeroIdxDiff = (int) $item1[0] - $item2[0];
            // error_log('zeroIdxDiff: ' . $zeroIdxDiff);
            // error_log($item1[0] . ' - ' . $item2[0]);
            if ($zeroIdxDiff == 0) {
                // error_log('ethe');
                // error_log($item1[1] . ' - ' . $item2[1]);
                return (int) $item1[1] - $item2[1];
            }
            return $zeroIdxDiff;
        }
        return (int) $item1 - $item2;
    }
}