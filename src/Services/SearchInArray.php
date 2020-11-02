<?php


namespace App\Services;


class SearchInArray
{
    /**
     * @param array $arrayNums
     * @param int $num
     * @return bool
     */
    public function findNum(array $arrayNums, int $num): bool
    {
        $sizeArray = count($arrayNums);
        for ($i = 0; $i < $sizeArray; $i++) {
            if ($num == $arrayNums[$i]) {
                return true;
            }
        }

        /*
         * requires 3 times more memory */
        /*$halfIndex = ceil(($sizeArray - 1) / 2);
        if ($halfIndex > 0) {
            list($leftChunk, $rightChunk) = array_chunk($arrayNums, $halfIndex);

            if ($arrayNums[$halfIndex] === $num) {
                return true;
            } elseif ($rightChunk && $num > $arrayNums[$halfIndex]) {
                return $this->findNum($rightChunk, $num);
            } elseif ($leftChunk && $num < $arrayNums[$halfIndex]) {
                return $this->findNum($leftChunk, $num);
            }
        }*/

        return false;
    }
}