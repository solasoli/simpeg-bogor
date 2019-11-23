<?php
class IndoDateTime{
    private $date = ''; // yyyy-mm-dd
    private $day = '';
    private $month = '';
    private $year = '';
    private $months = '';

    public function IndoDateTime($date) {
        $this->date = $date;
        $this->day = substr($this->date, 8, 2);
        $this->month = substr($this->date, 5, 2);
        $this->year = substr($this->date, 0, 4);

        $this->initMonths();
    }

    private function initMonths(){
        $this->months['01'] = 'Januari';
        $this->months['02'] = 'Februari';
        $this->months['03'] = 'Maret';
        $this->months['04'] = 'April';
        $this->months['05'] = 'Mei';
        $this->months['06'] = 'Juni';
        $this->months['07'] = 'Juli';
        $this->months['08'] = 'Agustus';
        $this->months['09'] = 'September';
        $this->months['10'] = 'Oktober';
        $this->months['11'] = 'November';
        $this->months['12'] = 'Desember';
    }

    public function format($format){
        switch($format){
            case "F":
                return $this->day." ".$this->months[$this->month]." ".$this->year;
            default:
                return $this->day." ".$this->months[$this->month]." ".$this->year;
        }
    }
    
    public function getDay(){
		return $this->day;	 
	 }    	
	 
	 public function getMonth(){
		return $this->month; 	 
	 }
	 
	 public function getYear(){
	 	return $this->year;	
	 }

}
?>