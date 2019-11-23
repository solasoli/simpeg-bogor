<?php
class Umum_model extends CI_Model
{
    var $blnHijriyah;
    public function __construct()
    {
        $this->blnHijriyah = array(1 => 'Muharram', 'Safar', 'Rabiul awal', 'Rabiul akhir', 'Jumadil awal', 'Jumadil akhir', 'Rajab', 'Sya\'ban', 'Ramadhan', 'Syawal', 'Dzulkaidah', 'Dzulhijjah');
    }

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

    public function getTglCurHijriyah(){
        $hijriyah = $this->Greg2Hijri(date('d'),date('m'),date('Y'));
        return /*$hijriyah['day'].*/' '.$this->blnHijriyah[(Int)$hijriyah['month']].' '.$hijriyah['year'].' H';
    }

    public function getGolongan(){
        $sql = "SELECT * FROM golongan ORDER BY id_golongan";
        $query = $this->db->query($sql);
        return $query->result();
    }

    public function getUnitKerja(){
        $sql = "SELECT uk.id_unit_kerja, uk.nama_baru AS unit
        FROM unit_kerja uk WHERE uk.tahun = (SELECT MAX(tahun) FROM unit_kerja uk1)
        AND uk.nama_baru <> 'Pemerintah Kota Bogor'
        ORDER BY unit";
        $query = $this->db->query($sql);
        return $query->result();
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

    public function getUnitKerjaByIdSKPD($id_skpd){
        $sql = "SELECT uk.id_unit_kerja, uk.nama_baru AS unit
        FROM unit_kerja uk WHERE uk.tahun = (SELECT MAX(tahun) FROM unit_kerja uk1)
        AND uk.nama_baru <> 'Pemerintah Kota Bogor' AND uk.id_skpd = $id_skpd 
        ORDER BY unit";
        $query = $this->db->query($sql);
        return $query->result();
    }

    public function getUnitKerjaByIdUnitKerja($id_skpd){
        $sql = "SELECT uk.id_unit_kerja, uk.nama_baru AS unit
        FROM unit_kerja uk WHERE uk.tahun = (SELECT MAX(tahun) FROM unit_kerja uk1)
        AND uk.nama_baru <> 'Pemerintah Kota Bogor' AND uk.id_unit_kerja = $id_skpd 
        ORDER BY unit";
        $query = $this->db->query($sql);
        return $query->result();
    }

    public function dayName($day){
        switch ($day) {
            case '1':
                $namahari = 'Senin';
                break;
            case '2':
                $namahari = 'Selasa';
                break;
            case '3':
                $namahari = 'Rabu';
                break;
            case '4':
                $namahari = 'Kamis';
                break;
            case '5':
                $namahari = 'Jumat';
                break;
            case '6':
                $namahari = 'Sabtu';
                break;
            case '7':
                $namahari = 'Minggu';
                break;
        }
        return $namahari;
    }

    public function infoPegawai($nip){
        $sql = "SELECT p.id_pegawai,
                p.nip_baru, CONCAT(CASE WHEN p.gelar_depan = '' THEN '' ELSE CONCAT(p.gelar_depan, ' ') END,
                nama, CASE WHEN p.gelar_belakang = '' THEN '' ELSE CONCAT(' ',p.gelar_belakang) END) AS nama,
                p.jenjab, p.pangkat_gol, CASE WHEN j.eselon IS NULL THEN 'Staf' ELSE j.eselon END AS eselon,
                CASE WHEN p.jenjab = 'Fungsional' THEN (jafung.kode_jabatan_jafung) ELSE
                CASE WHEN p.id_j IS NULL THEN (jfu.kode_jabatan_jfu) ELSE j.id_j END END AS kode_jabatan,
                CASE WHEN p.jenjab = 'Fungsional' THEN (jafung.kelas_jabatan_jafung) ELSE
                CASE WHEN p.id_j IS NULL THEN (jfu.kelas_jabatan_jfu) ELSE j.kelas_jabatan END END AS kelas_jabatan,
                CASE WHEN p.jenjab = 'Fungsional' THEN (jafung.nilai_jabatan_jafung) ELSE
                CASE WHEN p.id_j IS NULL THEN (jfu.nilai_jabatan_jfu) ELSE j.nilai_jabatan END END AS nilai_jabatan,
                CASE WHEN p.jenjab = 'Fungsional' THEN (CASE WHEN jafung.nama_jafung IS NULL THEN p.jabatan ELSE jafung.nama_jafung END) ELSE
                CASE WHEN p.id_j IS NULL THEN (jfu.nama_jfu) ELSE j.jabatan END END AS jabatan, p.status_aktif 
                FROM pegawai p LEFT JOIN jabatan j ON p.id_j = j.id_j
                LEFT JOIN (
                SELECT b.id_pegawai, jm.id_jfu as kode_jabatan_jfu, jm.kelas_jabatan as kelas_jabatan_jfu,
                jm.nilai_jabatan as nilai_jabatan_jfu, jm.nama_jfu
                FROM (SELECT a.*, jp.id_jfu FROM
                (SELECT jp.id_pegawai, MAX(jp.id) as id_jfu_pegawai FROM jfu_pegawai jp,
                (SELECT id_pegawai, MAX(tmt) as max_tmt FROM jfu_pegawai WHERE tmt IS NOT NULL GROUP BY id_pegawai) x
                WHERE jp.id_pegawai = x.id_pegawai AND jp.tmt = x.max_tmt
                GROUP BY jp.id_pegawai) a
                INNER JOIN jfu_pegawai jp ON a.id_jfu_pegawai = jp.id) b
                INNER JOIN jfu_master jm ON b.id_jfu = jm.id_jfu) jfu ON jfu.id_pegawai = p.id_pegawai
                LEFT JOIN (
                SELECT b.id_pegawai, jm.id_jafung as kode_jabatan_jafung, jm.kelas_jabatan as kelas_jabatan_jafung,
                jm.nilai_jabatan as nilai_jabatan_jafung, jm.nama_jafung
                FROM (SELECT a.*, jp.id_jafung FROM
                (SELECT jp.id_pegawai, MAX(jp.id) as id_jafung_pegawai FROM jafung_pegawai jp,
                (SELECT id_pegawai, MAX(tmt) as max_tmt FROM jafung_pegawai WHERE tmt IS NOT NULL GROUP BY id_pegawai) x
                WHERE jp.id_pegawai = x.id_pegawai AND jp.tmt = x.max_tmt
                GROUP BY jp.id_pegawai) a
                INNER JOIN jafung_pegawai jp ON a.id_jafung_pegawai = jp.id) b
                INNER JOIN jafung jm ON b.id_jafung = jm.id_jafung) jafung ON jafung.id_pegawai = p.id_pegawai
                LEFT JOIN current_lokasi_kerja clk ON p.id_pegawai = clk.id_pegawai
                LEFT JOIN unit_kerja uk ON clk.id_unit_kerja = uk.id_unit_kerja
                WHERE p.flag_pensiun = 0 AND p.nip_baru = '".$nip."'";
        $query = $this->db->query($sql);
        return $query->result();
    }
    
}

?>