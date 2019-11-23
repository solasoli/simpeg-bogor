<?php

class Format{

	public function __construct(){

	}

	public function date_dmY($engdate, $format=null){


		$pattern = "/^\d{4}\-(0?[1-9]|1[012])\-(0?[1-9]|[12][0-9]|3[01])$/";

		if(! preg_match($pattern, $engdate)){
			return NULL;
		}


		$strdate = explode("-",$engdate);
		$year = $strdate[0];
		$month = $strdate[1];
		$day = $strdate[2];

		if($format){
			return date($f,mktime(0,0,0,$month,$day,$year));
		}else{
			return date("d-m-Y",mktime(0,0,0,$month,$day,$year));
		}
	}

	function tanggal_indo($date, $format=NULL){

		if(!$date){
			return "-";
		}
		list($thn,$bln,$tgl) = explode("-",$date);



		if($format){

			switch($format){

				case ("d-m") :
					return $tgl." ".$this->bulan($bln);
					break;
				case ("m-Y") :
					return $this->bulan($bln)." ".$thn;
					break;
				case ("m"):
					return $this->bulan($bln);
					break;
				case ("Y"):
					return $thn;
					break;
				default :
					return $tgl." ".$this->bulan($bln)." ".$thn;
			}
		}else{
			return $tgl." ".$this->bulan($bln)." ".$thn;
		}



	}

	public function date_Ymd($inddate){

		$pattern = "/^(\d{1,2})-(\d{1,2})-(\d{4})$/";
		if(! preg_match($pattern, $inddate)){
			return NULL;
		}
		$strdate = explode("-",$inddate);
		$year = $strdate[2];
		$month = $strdate[1];
		$day = $strdate[0];

		if(@$f){
			return date(@$f,mktime(0,0,0,$month,$day,$year));
		}else{
			return date("Y-m-d",mktime(0,0,0,$month,$day,$year));
		}
	}

    function date_Ymd2($inddate){

		if($inddate == '00/00/0000'){
			$date = date('Y-m-d');
		}else{
			$date = $inddate;
		}
		$strdate = explode("/",$date);
		$year = $strdate[2];
		$month = $strdate[1];
		$day = $strdate[0];

		return date("Y-m-d",mktime(0,0,0,$month,$day,$year));
	}

	function add_date($date,$y=0,$m=0,$d=0){

		if($date == '0000-00-00'){
			$date = date('Y-m-d');
		}else{
			$date = $date;
		}
		$strdate = explode("-",$date);
		$year = $strdate[0]+$y;
		$month = $strdate[1]+$m;
		$day = $strdate[2]+$d;

		//echo $year.'<br>';
		if($year > 2038){
			return date("Y-m-d",mktime(0,0,0,$month,$day,$year));
		}else{
			return $day.'-'.$month.'-'.$year;
		}

	}

	function currency($str){

		return number_format($str,0,',','.');
	}

	function terbilang($x){

	  $abil = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
	  if ($x < 12)
	    return " " . $abil[$x];
	  elseif ($x < 20)
	    return $this->terbilang($x - 10) . "belas";
	  elseif ($x < 100)
	    return $this->terbilang($x / 10) . " puluh" . $this->terbilang($x % 10);
	  elseif ($x < 200)
	    return " seratus" . $this->terbilang($x - 100);
	  elseif ($x < 1000)
	    return $this->terbilang($x / 100) . " ratus" . $this->terbilang($x % 100);
	  elseif ($x < 2000)
	    return " seribu" . $this->terbilang($x - 1000);
	  elseif ($x < 1000000)
	    return $this->terbilang($x / 1000) . " ribu" . $this->terbilang($x % 1000);
	  elseif ($x < 1000000000)
	    return $this->terbilang($x / 1000000) . " juta" . $this->terbilang($x % 1000000);
	 elseif ($x < 1000000000000)
	    return $this->terbilang($x / 1000000000) . " miliar" . $this->terbilang($x % 1000000000);
	 elseif ($x < 1000000000000000)
	    return $this->terbilang($x / 1000000000000) . " trilyun" . $this->terbilang($x % 1000000000000);
	}

	function datediff($tgl1, $tgl2){

		 $tgl1 = (is_string($tgl1) ? strtotime($tgl1) : $tgl1);
		 $tgl2 = (is_string($tgl2) ? strtotime($tgl2) : $tgl2);
		 $diff_secs = abs($tgl1 - $tgl2);
		 $base_year = min(date("Y", $tgl1), date("Y", $tgl2));
		 $diff = mktime(0, 0, $diff_secs, 1, 1, $base_year);
		 return array( "years" => date("Y", $diff) - $base_year,"months_total" => (date("Y", $diff) - $base_year) * 12 + date("n", $diff) - 1,
		"months" => date("n", $diff) - 1,
		"days_total" => floor($diff_secs / (3600 * 24)),
		"days" => date("j", $diff) - 1,
		"hours_total" => floor($diff_secs / 3600),
		"hours" => date("G", $diff),
		"minutes_total" => floor($diff_secs / 60),
		"minutes" => (int) date("i", $diff),
		"seconds_total" => $diff_secs,
		"seconds" => (int) date("s", $diff)  );

	}

	/*
	 * $d adalah 3 suku kata pertama hari dalam inggris
	 * */
	function hari($d){

		$d = strtolower($d);

		switch ($d){
			case "sun":
				return "Minggu";
				break;
			case "mon":
				return "Senin";
				break;
			case "tue":
				return "Selasa";
				break;
			case "wed":
				return "Rabu";
				break;
			case "thu":
				return "Kamis";
				break;
			case "fri":
				return "Jumat";
				break;
			case "sat":
				return "Sabtu";
				break;
			default:
				return "hari tidak terdefinisi : ".$d;

		}
	}

	function bulan($m){

		switch ($m){

			case 1:
				return "Januari";
				break;
			case 2:
				return "Februari";
				break;
			case 3:
				return "Maret";
				break;
			case 4:
				return "April";
				break;
			case 5:
				return "Mei";
				break;
			case 6:
				return "Juni";
				break;
			case 7:
				return "Juli";
				break;
			case 8:
				return "Agustus";
				break;
			case 9:
				return "September";
				break;
			case 10:
				return "Oktober";
				break;
			case 11:
				return "November";
				break;
			case 12:
				return "Desember";
				break;
			default :
				echo "out of range bro";
		}



	}
}
