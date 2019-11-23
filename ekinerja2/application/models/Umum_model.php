<?php
    class Umum_model extends CI_Model{
        public function monthName($bln){
            switch ($bln) {
                case '01':
                    $namabln = 'Januari';
                    break;
                case '02':
                    $namabln = 'Februari';
                    break;
                case '03':
                    $namabln = 'Maret';
                    break;
                case '04':
                    $namabln = 'April';
                    break;
                case '05':
                    $namabln = 'Mei';
                    break;
                case '06':
                    $namabln = 'Juni';
                    break;
                case '07':
                    $namabln = 'Juli';
                    break;
                case '08':
                    $namabln = 'Agustus';
                    break;
                case '09':
                    $namabln = 'September';
                    break;
                case '10':
                    $namabln = 'Oktober';
                    break;
                case '11':
                    $namabln = 'November';
                    break;
                case '12':
                    $namabln = 'Desember';
                    break;
            }
            return $namabln;
        }

        public function dayName($hari){
            switch ($hari) {
                case 'Sunday':
                    $namahari = 'Minggu';
                    break;
                case 'Monday':
                    $namahari = 'Senin';
                    break;
                case 'Tuesday':
                    $namahari = 'Selasa';
                    break;
                case 'Wednesday':
                    $namahari = 'Rabu';
                    break;
                case 'Thursday':
                    $namahari = 'Kamis';
                    break;
                case 'Friday':
                    $namahari = 'Jumat';
                    break;
                case 'Saturday':
                    $namahari = 'Sabtu';
                    break;
            }
            return $namahari;
        }

        public function kekata($x) {
            $x = abs($x);
            $angka = array("", "satu", "dua", "tiga", "empat", "lima",
                "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
            $temp = "";
            if ($x <12) {
                $temp = " ". $angka[$x];
            } else if ($x <20) {
                $temp = $this->kekata($x - 10). " belas";
            } else if ($x <100) {
                $temp = $this->kekata($x/10)." puluh". $this->kekata($x % 10);
            } else if ($x <200) {
                $temp = " seratus" . $this->kekata($x - 100);
            } else if ($x <1000) {
                $temp = $this->kekata($x/100) . " ratus" . $this->kekata($x % 100);
            } else if ($x <2000) {
                $temp = " seribu" . $this->kekata($x - 1000);
            } else if ($x <1000000) {
                $temp = $this->kekata($x/1000) . " ribu" . $this->kekata($x % 1000);
            } else if ($x <1000000000) {
                $temp = $this->kekata($x/1000000) . " juta" . $this->kekata($x % 1000000);
            } else if ($x <1000000000000) {
                $temp = $this->kekata($x/1000000000) . " milyar" . $this->kekata(fmod($x,1000000000));
            } else if ($x <1000000000000000) {
                $temp = $this->kekata($x/1000000000000) . " trilyun" . $this->kekata(fmod($x,1000000000000));
            }
            return $temp;
        }

        public function listBulan(){
            $bln = array
            (
                array(1,"Januari"),
                array(2,"Februari"),
                array(3,"Maret"),
                array(4,"April"),
                array(5,"Mei"),
                array(6,"Juni"),
                array(7,"Juli"),
                array(8,"Agustus"),
                array(9,"September"),
                array(10,"Oktober"),
                array(11,"November"),
                array(12,"Desember")
            );
            return $bln;
        }

        public function listTahun(){
            $i = 2;
            $thn[$i] = date("Y");
            for ($x = 0; $x <= 1; $x++) {
                $thn[$x] = $thn[$i] - ($i-$x);
            }
            for ($x = 3; $x <= 6; $x++) {
                $thn[$x] = $thn[$i] + ($x-2);
            }
            return $thn;
        }

        private function intPart($float)
        {
            if ($float < -0.0000001)
                return ceil($float - 0.0000001);
            else
                return floor($float + 0.0000001);
        }

        public function Hijri2Greg($day, $month, $year, $string = false)
        {
            $day   = (int) $day;
            $month = (int) $month;
            $year  = (int) $year;

            $jd = $this->intPart((11*$year+3) / 30) + 354 * $year + 30 * $month - $this->intPart(($month-1)/2) + $day + 1948440 - 385;

            if ($jd > 2299160)
            {
                $l = $jd+68569;
                $n = $this->intPart((4*$l)/146097);
                $l = $l-$this->intPart((146097*$n+3)/4);
                $i = $this->intPart((4000*($l+1))/1461001);
                $l = $l-$this->intPart((1461*$i)/4)+31;
                $j = $this->intPart((80*$l)/2447);
                $day = $l-$this->intPart((2447*$j)/80);
                $l = $this->intPart($j/11);
                $month = $j+2-12*$l;
                $year  = 100*($n-49)+$i+$l;
            }
            else
            {
                $j = $jd+1402;
                $k = $this->intPart(($j-1)/1461);
                $l = $j-1461*$k;
                $n = $this->intPart(($l-1)/365)-$this->intPart($l/1461);
                $i = $l-365*$n+30;
                $j = $this->intPart((80*$i)/2447);
                $day = $i-$this->intPart((2447*$j)/80);
                $i = $this->intPart($j/11);
                $month = $j+2-12*$i;
                $year = 4*$k+$n+$i-4716;
            }

            $data = array();
            $date['year']  = $year;
            $date['month'] = $month;
            $date['day']   = $day;

            if (!$string)
                return $date;
            else
                return     "{$year}-{$month}-{$day}";
        }

        public function Greg2Hijri($day, $month, $year, $string = false)
        {
            $day   = (int) $day;
            $month = (int) $month;
            $year  = (int) $year;

            if (($year > 1582) or (($year == 1582) and ($month > 10)) or (($year == 1582) and ($month == 10) and ($day > 14)))
            {
                $jd = $this->intPart((1461*($year+4800+$this->intPart(($month-14)/12)))/4)+$this->intPart((367*($month-2-12*($this->intPart(($month-14)/12))))/12)-
                    $this->intPart( (3* ($this->intPart(  ($year+4900+    $this->intPart( ($month-14)/12)     )/100)    )   ) /4)+$day-32075;
            }
            else
            {
                $jd = 367*$year-$this->intPart((7*($year+5001+$this->intPart(($month-9)/7)))/4)+$this->intPart((275*$month)/9)+$day+1729777;
            }

            $l = $jd-1948440+10632;
            $n = $this->intPart(($l-1)/10631);
            $l = $l-10631*$n+354;
            $j = ($this->intPart((10985-$l)/5316))*($this->intPart((50*$l)/17719))+($this->intPart($l/5670))*($this->intPart((43*$l)/15238));
            $l = $l-($this->intPart((30-$j)/15))*($this->intPart((17719*$j)/50))-($this->intPart($j/16))*($this->intPart((15238*$j)/43))+29;

            $month = $this->intPart((24*$l)/709);
            $day   = $l-$this->intPart((709*$month)/24);
            $year  = 30*$n+$j-30;

            $date = array();
            $date['year']  = $year;
            $date['month'] = $month;
            $date['day']   = $day;

            if (!$string)
                return $date;
            else
                return     "{$year}-{$month}-{$day}";
        }

        public function getTglCurHijriyah($tgl, $bln, $thn){
            $hijriyah = $this->Greg2Hijri($tgl,$bln,$thn);
            return $hijriyah['day'].' '.$this->blnHijriyah[(Int)$hijriyah['month']].' '.$hijriyah['year'].' H';
        }

        public function listJam(){
            for($i=0;$i<=23;$i++){
                if(strlen($i)==1){
                    $jam[$i] = '0'.$i;
                }else{
                    $jam[$i] = $i;
                }
            }
            return $jam;
        }

        public function listMenit(){
            for($i=0;$i<=59;$i++){
                $menit[$i] = $i;
            }
            return $menit;
        }

        public function listTanggal(){
            for($i=0;$i<=31;$i++){
                $tgl[$i] = $i;
            }
            return $tgl;
        }

    }

?>