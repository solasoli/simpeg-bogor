<?php

class Terbilang_model extends CI_Model{

    function __construct()
    {

    }

    public function Terbilang($satuan){
        $huruf = array("", "Satu", "Dua", "Tiga", "Empat", "Lima",
            "Enam", "Tujuh", "Delapan", "Sembilan", "Sepuluh", "Sebelas");

        if ($satuan < 12)
            return " " . $huruf[$satuan];
        elseif ($satuan < 20)
            return $this->Terbilang($satuan - 10) . " Belas";
        elseif ($satuan < 100)
            return $this->Terbilang($satuan / 10) . " Puluh" . $this->Terbilang($satuan % 10);
        elseif ($satuan < 200)
            return " Seratus" . $this->Terbilang($satuan - 100);
        elseif ($satuan < 1000)
            return $this->Terbilang($satuan / 100) . " Ratus" . $this->Terbilang($satuan % 100);
        elseif ($satuan < 2000)
            return " Seribu" . Terbilang($satuan - 1000);
        elseif ($satuan < 1000000)
            return $this->Terbilang($satuan / 1000) . " Ribu" . $this->Terbilang($satuan % 1000);
        elseif ($satuan < 1000000000)
            return $this->Terbilang($satuan / 1000000) . " Juta" . $this->Terbilang($satuan % 1000000);
        elseif ($satuan >= 1000000000)
            echo "Hasil terbilang tidak dapat di proses karena nilai uang terlalu besar!";
    }

    public function getNamaBulan($a){
        switch ($a) {
            case '01':
                return "Januari";
                break;
            case '02':
                return "Februari";
                break;
            case '03':
                return "Maret";
                break;
            case '04':
                return "April";
                break;
            case '05':
                return "Mei";
                break;
            case '06':
                return "Juni";
                break;
            case '07':
                return "Juli";
                break;
            case '08':
                return "Agustus";
                break;
            case '09':
                return "September";
                break;
            case '10':
                return "Oktober";
                break;
            case '11':
                return "November";
                break;
            case '12':
                return "Desember";
                break;
        }
    }

    public function getNamaHari($date){
        $day = date('l', strtotime($date));
        switch ($day) {
            case 'Monday':
                return "Senin";
                break;
            case 'Tuesday':
                return "Selasa";
                break;
            case 'Wednesday':
                return "Rabu";
                break;
            case 'Thursday':
                return "Kamis";
                break;
            case 'Friday':
                return "Jumat";
                break;
            case 'Saturday':
                return "Sabtu";
                break;
            case 'Sunday':
                return "Minggu";
                break;
        }
    }
}
?>