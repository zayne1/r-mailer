<?php

/**
 * Model
 * Handles all the user and api data work
 * 
 */

class Model
{
    private $APIUrlEmployees;
    private $employees;
    private $birthdaySkips;
    private $currMonth;
    private $currDay;
    private $todaysBirthdayRecs;
    private $todaysAnniversaryRecs;

    public function __construct() {

        $this->APIUrlEmployees = Config::getConfig('APIUrlEmployees');
        $this->APIUrlNoBirthdays = Config::getConfig('APIUrlNoBirthdays');
        
        $this->employees = $this->getAllEmplyees();
        $this->birthdaySkips = $this->_getBirthdaySkips();
        $this->currMonth = date('m');
        $this->currDay = date('d');
    }

    public function getAllEmplyees() {

        // exec("curl -i ".$this->APIUrlEmployees."", $arrStr);
        // // $arrStores = json_decode($arrStr[18], true);

        $employees = file_get_contents($this->APIUrlEmployees, false);
        return json_decode($employees);
    }

    public function getTodaysBirthdays() {

        foreach ($this->employees as $key => $val) {
            if ( !in_array($val->id, $this->birthdaySkips)
                && $val->employmentEndDate == null
                && $val->employmentStartDate !== null
                ) 
                {

                $dateArray = getdate(strtotime($val->dateOfBirth));
                
                if ( ($dateArray['mon'] == $this->currMonth) && ($dateArray['mday']==$this->currDay) ) {
                    
                    // create/populate today's birthday array
                    $this->todaysBirthdayRecs[] = $val;
                }
            }
        }
        return $this->todaysBirthdayRecs;
    }

    public function getTodaysAnniversaries() {

        foreach ($this->employees as $key => $val) {
            if ( $val->employmentEndDate == null
                && $val->employmentStartDate !== null
                ) 
                {

                $dateArray = getdate(strtotime($val->employmentStartDate));
                
                if ( ($dateArray['mon'] == $this->currMonth) && ($dateArray['mday']==$this->currDay) ) {
                    
                    // create/populate today's birthday array
                    $this->todaysAnniversaryRecs[] = $val;
                }
            }
        }
        return $this->todaysAnniversaryRecs;
    }

    private function _getBirthdaySkips() {

        $birthdaySkips = file_get_contents($this->APIUrlNoBirthdays, false);
        return json_decode($birthdaySkips);
    }
}
