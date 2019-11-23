<?php

class report_absensi_model extends CI_Model
{
    public function __construct()
    {

    }

    public function countListDataAbsensi($idskpd, $tgl, $status, $jenjab, $keywordCari){
        $andKlausa = "";

        if($tgl!=''){
            $tgl = explode('.',$tgl);
            $andKlausa = " AND ra.tgl = '".$tgl[2].'-'.$tgl[1].'-'.$tgl[0]."'";
        }

        if($status!='0'){
            $andKlausa .= " AND ra.status = '".$status."'";
        }

        if($jenjab!='0'){
            $andKlausa .= " AND p.jenjab = '".$jenjab."'";
        }

        if (!(trim($keywordCari)== "") && !(trim($keywordCari)== "0")){
            $andKlausa .= " AND (p.nama LIKE '%$keywordCari%' OR p.nip_baru LIKE '%$keywordCari%'
                            OR (CASE WHEN p.jenjab = 'Fungsional' THEN (CASE WHEN jafung.nama_jafung IS NULL THEN p.jabatan ELSE jafung.nama_jafung END) ELSE
                            CASE WHEN p.id_j IS NULL THEN (jfu.nama_jfu) ELSE j.jabatan END END) LIKE '%$keywordCari%') ";
        }

        $sql_list = "SELECT COUNT(*) as jumlah_all
                    FROM (SELECT DATE_FORMAT(ra.tgl, '%d/%m/%Y') AS tgl, ra.tgl AS tgl_ori, ra.status, p.id_pegawai, p.nip_baru, CONCAT(CASE WHEN p.gelar_depan = '' THEN '' ELSE CONCAT(p.gelar_depan, ' ') END,
                    nama, CASE WHEN p.gelar_belakang = '' THEN '' ELSE CONCAT(' ',p.gelar_belakang) END) AS nama,
                    p.jenjab, p.pangkat_gol,
                    CASE WHEN p.jenjab = 'Fungsional' THEN (CASE WHEN jafung.nama_jafung IS NULL THEN p.jabatan ELSE jafung.nama_jafung END) ELSE
                    CASE WHEN p.id_j IS NULL THEN (jfu.nama_jfu) ELSE j.jabatan END END AS jabatan,
                    CASE WHEN j.eselon IS NULL THEN 'Staf' ELSE j.eselon END AS eselon
                    FROM  report_absensi ra, unit_kerja ukra, pegawai p
                    LEFT JOIN jabatan j ON p.id_j = j.id_j
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
                    WHERE ra.id_unit_kerja = ukra.id_unit_kerja AND ra.id_pegawai = p.id_pegawai
                    AND ukra.id_skpd = $idskpd $andKlausa) AS report_absensi";
        $query = $this->db->query($sql_list);
        foreach ($query->result() as $row){
            $count = $row->jumlah_all;
        }
        return $count;
    }

    public function listDataAbsensi($row_number_start, $idskpd, $tgl, $status, $jenjab, $keywordCari, $limit){
        $andKlausa = "";

        if($tgl!=''){
            $tgl = explode('.',$tgl);
            $andKlausa = " AND ra.tgl = '".$tgl[2].'-'.$tgl[1].'-'.$tgl[0]."'";
        }

        if($status!='0'){
            $andKlausa .= " AND ra.status = '".$status."'";
        }

        if($jenjab!='0'){
            $andKlausa .= " AND p.jenjab = '".$jenjab."'";
        }

        if (!(trim($keywordCari)== "") && !(trim($keywordCari)== "0")){
            $andKlausa .= " AND (p.nama LIKE '%$keywordCari%' OR p.nip_baru LIKE '%$keywordCari%'
                            OR (CASE WHEN p.jenjab = 'Fungsional' THEN (CASE WHEN jafung.nama_jafung IS NULL THEN p.jabatan ELSE jafung.nama_jafung END) ELSE
                            CASE WHEN p.id_j IS NULL THEN (jfu.nama_jfu) ELSE j.jabatan END END) LIKE '%$keywordCari%') ";
        }

        $this->db->query("SET @row_number := $row_number_start");

        $sql_list = "SELECT DATE_FORMAT(ra.tgl, '%d/%m/%Y') AS tgl, ra.tgl AS tgl_ori, ra.status, p.id_pegawai, p.nip_baru, CONCAT(CASE WHEN p.gelar_depan = '' THEN '' ELSE CONCAT(p.gelar_depan, ' ') END,
                    nama, CASE WHEN p.gelar_belakang = '' THEN '' ELSE CONCAT(' ',p.gelar_belakang) END) AS nama,
                    p.jenjab, p.pangkat_gol,
                    CASE WHEN p.jenjab = 'Fungsional' THEN (CASE WHEN jafung.nama_jafung IS NULL THEN p.jabatan ELSE jafung.nama_jafung END) ELSE
                    CASE WHEN p.id_j IS NULL THEN (jfu.nama_jfu) ELSE j.jabatan END END AS jabatan,
                    CASE WHEN j.eselon IS NULL THEN 'Staf' ELSE j.eselon END AS eselon
                    FROM  report_absensi ra, unit_kerja ukra, pegawai p
                    LEFT JOIN jabatan j ON p.id_j = j.id_j
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
                    WHERE ra.id_unit_kerja = ukra.id_unit_kerja AND ra.id_pegawai = p.id_pegawai
                    AND ukra.id_skpd = $idskpd $andKlausa ORDER BY tgl_ori DESC, p.pangkat_gol DESC
                    LIMIT $row_number_start, $limit";

        $query = $this->db->query($sql_list);
        $data = null;
        foreach ($query->result() as $row)
        {
            $data[] = $row;
        }
        return $data;
    }

    public function getCountDataAbsensi($idskpd, $tgl, $status){
        $andKlausa = "";
        if($tgl!=''){
            $tgl = explode(".",$tgl);
            $andKlausa = " AND a.tgl = '".$tgl[2]."-".$tgl[1]."-".$tgl[0]."'";
        }
        if($status!='0'){
            $andKlausa .= " AND a.status = '".$status."'";
        }
        $sql_list = "SELECT COUNT(*) as jumlah_all FROM
                (SELECT ra.tgl, ra.status, p.nip_baru, CONCAT(CASE WHEN p.gelar_depan = '' THEN '' ELSE CONCAT(p.gelar_depan, ' ') END,
                nama, CASE WHEN p.gelar_belakang = '' THEN '' ELSE CONCAT(' ',p.gelar_belakang) END) AS nama, p.pangkat_gol,
                CASE WHEN p.jenjab = 'Fungsional' THEN p.jabatan ELSE CASE WHEN p.id_j IS NULL THEN 'Fungsional Umum'
                ELSE j.jabatan END END AS jabatan, uk.id_skpd
                FROM pegawai p LEFT JOIN jabatan j ON p.id_j = j.id_j, current_lokasi_kerja clk, unit_kerja uk, report_absensi ra
                WHERE p.flag_pensiun = 0 AND p.flag_mpp IS NULL AND p.id_pegawai = clk.id_pegawai AND clk.id_unit_kerja = uk.id_unit_kerja AND ra.id_pegawai = p.id_pegawai
                ORDER BY ra.tgl DESC) a, unit_kerja uk
                WHERE a.id_skpd = uk.id_unit_kerja AND a.id_skpd = ".$idskpd.$andKlausa;

        $query = $this->db->query($sql_list);
        foreach ($query->result() as $row){
            $count = $row->jumlah_all;
        }
        return $count;
    }

    public function getSKPD(){
        $sql = "select id_unit_kerja, nama_baru from unit_kerja
				where tahun = (select max(tahun) from unit_kerja)
				and id_unit_kerja = id_skpd
				order by nama_baru ASC";
        $query = $this->db->query($sql);
        $data = null;
        foreach ($query->result() as $row)
        {
            $data[] = $row;
        }
        return $data;
    }

    public function getNamaUnitKerja($idunit){
        $sql = "SELECT a.opd, b.jabatan, b.nip_baru, b.nama FROM
                (SELECT id_unit_kerja, nama_baru as opd FROM unit_kerja
                WHERE id_unit_kerja = $idunit) a INNER JOIN
                (SELECT j.jabatan, p.nip_baru, CONCAT(CASE WHEN p.gelar_depan = '' THEN '' ELSE CONCAT(p.gelar_depan, ' ') END,
                nama, CASE WHEN p.gelar_belakang = '' THEN '' ELSE CONCAT(' ',p.gelar_belakang) END) AS nama, j.id_unit_kerja
                FROM jabatan j, pegawai p
                WHERE j.eselon='IIB' AND j.tahun= (SELECT MAX(TAHUN) FROM jabatan) AND j.id_unit_kerja = $idunit
                AND j.id_j = p.id_j) b
                ON a.id_unit_kerja = b.id_unit_kerja";
        $query = $this->db->query($sql);
        $data = null;
        foreach ($query->result() as $row)
        {
            $data[] = $row;
        }
        return $data;
    }

    public function getNamaUnitKerja2($idunit){
        $sql = "select nama_baru as opd from unit_kerja where id_unit_kerja = $idunit";
        $query = $this->db->query($sql);
        $data = null;
        foreach ($query->result() as $row)
        {
            $data[] = $row;
        }
        return $data;
    }

    public function getStatusAbsen($status){
        $whereKlause = "";
        if($status!='0'){
            $whereKlause .= "Where rsa.idstatus = '".$status."'";
        }
        $sql = "select * from ref_status_absensi rsa $whereKlause";
        $query = $this->db->query($sql);
        $data = null;
        foreach ($query->result() as $row){
            $data[] = $row;
        }
        return $data;
    }

    public function rekapJumlahOPD($group, $bln, $thn, $skpd, $idunit){
        $sql = "CALL PRCD_ABSEN_JADWAL_KHUSUS($skpd, ".(Int)$bln.", ".(Int)$thn.")";
        if ($this->db->query($sql)){
            $this->db->query("SET @outputvar := ''");
            $sql = "CALL PRCD_ABSEN_REPORT_ADMIN('".(($idunit>0 and $idunit!=$skpd)?'unit':'')."', ".(($idunit>0 and $idunit!=$skpd)?$idunit:$skpd).", '$thn-$bln', $skpd, ".(Int)$bln.", ".(Int)$thn.", @outputvar, '')";
            if ($this->db->query($sql)){
                $sql = "CALL PRCD_ABSEN_REKAP_OPD('$group', ".(($idunit>0 and $idunit!=$skpd)?$idunit:$skpd).", '$thn-$bln', $skpd, ".(Int)$bln.", ".(Int)$thn.", @outputvar)";
                $query = $this->db->query($sql);
                if ($query){
                    return $query->result();
                }else{
                    return false;
                }
            }else{
                return false;
            }
        }else{
            return false;
        }
    }

    public function rekapListOPD($bln, $thn, $skpd, $idunit, $nip){
        $sql = "CALL PRCD_ABSEN_JADWAL_KHUSUS($skpd, ".(Int)$bln.", ".(Int)$thn.")";
        if ($this->db->query($sql)){
            $this->db->query("SET @outputvar := ''");
            $sql = "CALL PRCD_ABSEN_REPORT_ADMIN('".(($idunit>0 and $idunit!=$skpd)?'unit':'')."', ".(($idunit>0 and $idunit!=$skpd)?$idunit:$skpd).", '$thn-$bln', $skpd, ".(Int)$bln.", ".(Int)$thn.", @outputvar, '$nip')";
            if ($this->db->query($sql)){
                $sql = "CALL PRCD_ABSEN_REKAP_PEGAWAI('', ".(($idunit>0 and $idunit!=$skpd)?$idunit:$skpd).", '$thn-$bln', $skpd, ".(Int)$bln.", ".(Int)$thn.", @outputvar, '$nip')";
                $query = $this->db->query($sql);
                if ($query){
                    return $query->result();
                }else{
                    return false;
                }
            }else{
                return false;
            }
        }else{
            return false;
        }
    }

    //================================================================================================================//
    //================================================================================================================//

    public function getProfilAbsensi1($bln, $thn, $skpd){
        $query = $this->db->query("CALL PRCD_ABSENSI_HARIAN_PROFIL1($bln, $thn, $skpd)");
        $data = null;
        foreach ($query->result() as $row)
        {
            $data[] = $row;
        }
        return $data;
    }

    public function getProfilAbsensi2($bln, $thn, $skpd){
        $query = $this->db->query("CALL PRCD_ABSENSI_HARIAN_PROFIL2($bln, $thn, $skpd)");
        $data = null;
        foreach ($query->result() as $row)
        {
            $data[] = $row;
        }
        return $data;
    }

    public function getProfilAbsensi3($bln, $thn){
        $query = $this->db->query("CALL PRCD_ABSENSI_CETAK_ALL_OPD($bln, $thn)");
        $data = null;
        foreach ($query->result() as $row)
        {
            $data[] = $row;
        }
        return $data;
    }

    public function getRekapAbsensiBulanan($bln, $thn, $skpd){
        $query = $this->db->query("CALL PRCD_ABSENSI_HARIAN_REKAP_HARI($bln, $thn, $skpd)");
        $data = null;
        foreach ($query->result() as $row)
        {
            $data[] = $row;
        }
        return $data;
    }

    public function getRekapAbsensiPegawai($bln, $thn, $skpd){
        $query = $this->db->query("CALL PRCD_ABSENSI_HARIAN_PEGAWAI($bln, $thn, $skpd)");
        $data = null;
        foreach ($query->result() as $row)
        {
            $data[] = $row;
        }
        return $data;
    }

    public function getDetailListPegawai($bln, $thn, $idskpd, $status){
        if($status=='All'){
            $sql = "SELECT p.nip_baru, CONCAT(CASE WHEN p.gelar_depan = '' THEN '' ELSE CONCAT(p.gelar_depan, ' ') END,
                    nama, CASE WHEN p.gelar_belakang = '' THEN '' ELSE CONCAT(' ',p.gelar_belakang) END) AS nama, p.pangkat_gol,
                    CASE WHEN p.jenjab = 'Fungsional' THEN p.jabatan ELSE CASE WHEN p.id_j IS NULL THEN
                    (SELECT jm.nama_jfu AS jabatan
                     FROM jfu_pegawai jp, jfu_master jm
                     WHERE jp.kode_jabatan = jm.kode_jabatan AND jp.id_pegawai = p.id_pegawai LIMIT 1)
                    ELSE j.jabatan END END AS jabatan, a.jml_hari, a.hist_absensi,
                    a.C, a.DL, a.DI, a.I, a.S, a.TK, a.unit
                    FROM
                    (SELECT ra.id_pegawai, uk.nama_baru as unit, COUNT(ra.id) AS jml_hari,
                    GROUP_CONCAT(DATE_FORMAT(ra.tgl,  '%d/%m/%Y'),' (',ra.status,')' ORDER BY ra.tgl ASC SEPARATOR ', ') AS hist_absensi,
                    SUM(IF(ra.status = 'C', 1, 0)) AS 'C',
                    SUM(IF(ra.status = 'DL', 1, 0)) AS 'DL',
                    SUM(IF(ra.status = 'DI', 1, 0)) AS 'DI',
                    SUM(IF(ra.status = 'I', 1, 0)) AS 'I',
                    SUM(IF(ra.status = 'S', 1, 0)) AS 'S',
                    SUM(IF(ra.status = 'TK', 1, 0)) AS 'TK'
                    FROM report_absensi ra, unit_kerja uk, ref_status_absensi rsa
                    WHERE MONTH(ra.tgl) = ".$bln." AND YEAR(ra.tgl) = ".$thn." AND uk.id_skpd = ".$idskpd." AND ra.status <> 'TA' AND
                    ra.id_unit_kerja = uk.id_unit_kerja AND ra.status = rsa.idstatus
                    GROUP BY ra.id_pegawai) a, pegawai p LEFT JOIN jabatan j ON p.id_j = j.id_j
                    WHERE p.id_pegawai = a.id_pegawai AND p.flag_pensiun = 0 AND p.flag_mpp IS NULL ORDER BY a.jml_hari DESC, p.pangkat_gol DESC;";
        }else{
            $sql = "SELECT p.nip_baru, CONCAT(CASE WHEN p.gelar_depan = '' THEN '' ELSE CONCAT(p.gelar_depan, ' ') END,
                    nama, CASE WHEN p.gelar_belakang = '' THEN '' ELSE CONCAT(' ',p.gelar_belakang) END) AS nama, p.pangkat_gol,
                    CASE WHEN p.jenjab = 'Fungsional' THEN p.jabatan ELSE CASE WHEN p.id_j IS NULL THEN
                    (SELECT jm.nama_jfu AS jabatan
                     FROM jfu_pegawai jp, jfu_master jm
                     WHERE jp.kode_jabatan = jm.kode_jabatan AND jp.id_pegawai = p.id_pegawai LIMIT 1)
                    ELSE j.jabatan END END AS jabatan, a.jml_hari, a.hist_absensi, a.unit
                    FROM
                    (SELECT ra.id_pegawai, uk.nama_baru as unit, COUNT(ra.id) AS jml_hari,
                    GROUP_CONCAT(DISTINCT DATE_FORMAT(ra.tgl,  '%d/%m/%Y') ORDER BY ra.tgl ASC SEPARATOR ', ') AS hist_absensi
                    FROM report_absensi ra, unit_kerja uk, ref_status_absensi rsa
                    WHERE MONTH(ra.tgl) = ".$bln." AND YEAR(ra.tgl) = ".$thn." AND uk.id_skpd = ".$idskpd." /*AND ra.status <> 'TA'*/ AND
                    ra.id_unit_kerja = uk.id_unit_kerja AND rsa.idstatus = '".$status."' AND ra.status = rsa.idstatus
                    GROUP BY ra.id_pegawai) a, pegawai p LEFT JOIN jabatan j ON p.id_j = j.id_j
                    WHERE p.id_pegawai = a.id_pegawai AND p.flag_pensiun = 0 AND p.flag_mpp IS NULL ORDER BY a.jml_hari DESC, p.pangkat_gol DESC;";
        }
        $query =  $this->db->query($sql);
        $data = null;
        foreach ($query->result() as $row)
        {
            $data[] = $row;
        }
        return $data;
    }

    public function getDetailListPegawaiBulanan($tgl, $bln, $thn, $idskpd, $status){
        if($status=='All'){
            if($tgl=='TOTAL'){
                $strTgl = "MONTH(ra.tgl) = $bln AND YEAR(ra.tgl) = $thn";
            }else{
                $strTgl = "ra.tgl = '$thn-$bln-$tgl'";
            }
            $strStatus = "ra.status <> 'TA'";
        }else{
            if($tgl=='TOTAL'){
                $strTgl = "MONTH(ra.tgl) = $bln AND YEAR(ra.tgl) = $thn";
            }else{
                $strTgl = "ra.tgl = '$thn-$bln-$tgl'";
            }
            $strStatus = "ra.status = 'TA'";
        }

        $sql = "SELECT a.*, p.nip_baru, CONCAT(CASE WHEN p.gelar_depan = '' THEN '' ELSE CONCAT(p.gelar_depan, ' ') END,
        nama, CASE WHEN p.gelar_belakang = '' THEN '' ELSE CONCAT(' ',p.gelar_belakang) END) AS nama, p.pangkat_gol,
        CASE WHEN p.jenjab = 'Fungsional' THEN p.jabatan ELSE CASE WHEN p.id_j IS NULL THEN
        (SELECT jm.nama_jfu AS jabatan
         FROM jfu_pegawai jp, jfu_master jm
         WHERE jp.kode_jabatan = jm.kode_jabatan AND jp.id_pegawai = p.id_pegawai LIMIT 1)
        ELSE j.jabatan END END AS jabatan
        FROM
        (SELECT ra.id_pegawai, DATE_FORMAT(ra.tgl, '%d/%m/%Y') AS tgl, ra.status
        FROM report_absensi ra, unit_kerja uk
        WHERE ra.id_unit_kerja = uk.id_unit_kerja AND uk.id_skpd = $idskpd
        AND $strTgl AND $strStatus ORDER BY ra.tgl) a,
        pegawai p LEFT JOIN jabatan j ON p.id_j = j.id_j AND p.flag_mpp IS NULL
        WHERE a.id_pegawai = p.id_pegawai";

        $query =  $this->db->query($sql);
        $data = null;
        foreach ($query->result() as $row)
        {
            $data[] = $row;
        }
        return $data;
    }

}

?>