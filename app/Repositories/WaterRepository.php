<?php

namespace App\Repositories;

class WaterRepository
{    
    /**
     * Soma o acúmulo de água
     *
     * @param  array $array
     * @param  int $length
     * @return int
     */
    public function sumWaterAccumulation(array $array, int $length)
    {
        $accumulation = 0;

        $left[0] = $array[0];
        for ($i = 1; $i < $length; $i++) {
            $left[$i] = max($left[$i - 1], $array[$i]);
        }
        
        $right[$length - 1] = $array[$length - 1];
        for ($j = $length - 2; $j >= 0; $j--) {
            $right[$j] = max($right[$j + 1], $array[$j]);
        }
        
        for ($k = 0; $k < $length; $k++) {
            $accumulation += min($left[$k], $right[$k]) - $array[$k];
        }

        return $accumulation;
    }
}
