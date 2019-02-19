<?php 
/**
 * Class: Workschedule, prepares the timetable according to specifications. 
 * 
 * @author Carlos Eduardo da Silva <carlosedasilva@gmail.com>
 */

class Workschedule 
{
    /**
     * Persisting all the partial results.
     */
    private $timeTable = array();
    
    /**
     * Class constructor, preparing the setting. 
     */
    public function __construct($workHours, $dayHours, $pattern)
    {
        $amountOfHours  = 0;
        $variation      = 0;
        $listPatterns   = str_split($pattern);

        foreach($listPatterns as $p) $amountOfHours+=($p!='?')?$p:0; 

        $variation = $workHours - $amountOfHours;

        $this->createTimeTable($listPatterns, 0, $variation, $dayHours);

        return $this->timeTable;
    }

    /**
     * Estimates all possibilities. 
     * 
     * @param $listPatterns {array} List of available patterns. 
     * @param $idx          {int}   Param index. 
     * @param $variation    {int}   Time difference. 
     * @param $dayHours     {int}   Hours per day.
     * @return void 
     */
    private function createTimeTable($listPatterns, $idx, $variation, $dayHours)
    {
        if($idx == count($listPatterns))
        {
            if($variation == 0) array_push($this->timeTable,implode('', $listPatterns));
            return;
        }

        // Using recursive function technique like in fibonacci series.
        if($listPatterns[$idx] == '?')
        {
            for($i = 0; $i <= $dayHours; $i++)
            {
                $buffer = $listPatterns[$idx];
                $listPatterns[$idx] = $i; 

                $this->createTimeTable($listPatterns, $idx+1, $variation-$i, $dayHours);
                $listPatterns[$idx] = $buffer;
            }
        }
        else
            $this->createTimeTable($listPatterns, $idx+1, $variation, $dayHours);
    }


    /**
     * Returns the final results. 
     *
     * @return array
     */
    public function getTimeTable()
    {
        return $this->timeTable;
    }
}


/**
 * Simple function just to simulate HackerRank environment.
 */
function findSchedules($workHours, $dayHours, $pattern) 
{
    $myWorkSchedule = new Workschedule($workHours, $dayHours, $pattern);
    return $myWorkSchedule->getTimeTable();
}

// Just a small test, not used in the real test. 
echo("<pre>");
print_r(findSchedules(3, 2, '??2??00'));
