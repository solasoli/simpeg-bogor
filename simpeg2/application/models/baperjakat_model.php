<?php
class Baperjakat_model extends CI_Model{
    public function __construct()
    {

    }

    public function get_all(){
        $this->db->query("SET @row_number := 0");
        $query = $this->db->query("SELECT FCN_ROW_NUMBER() as no_urut, id_baperjakat, no_sk,
              pengesah_sk, nama_pengesah_sk FROM baperjakat");

        $data = null;
        foreach ($query->result() as $row)
        {
            $data[] = $row;
        }
        return $data;
    }

    public function get_baperjakat_detail($id_baperjakat){
        $this->db->query("SET @row_number := 0");
        $query = $this->db->query("SELECT FCN_ROW_NUMBER() as no_urut, def_baperjakat.id_baperjakat, def_baperjakat.status_keanggotaan,
                def_baperjakat.idstatus_keanggotaan, bd.idpegawai, p.gelar_depan, IFNULL(p.nama,'Belum Ada') AS nama, p.gelar_belakang,
                p.nip_baru, p.pangkat_gol, bd.id_j, IFNULL(j.jabatan,'Belum Ada') AS jabatan, bd.iddetail_baperjakat
                FROM
                (SELECT b.id_baperjakat, rsk.idstatus_keanggotaan, rsk.status_keanggotaan
                FROM baperjakat b, ref_status_keanggotaan rsk
                ORDER BY b.id_baperjakat, rsk.idstatus_keanggotaan) def_baperjakat
                LEFT JOIN baperjakat_detail bd ON def_baperjakat.id_baperjakat = bd.id_baperjakat AND
                def_baperjakat.idstatus_keanggotaan = bd.idstatus_keanggotaan
                LEFT JOIN pegawai p ON bd.idpegawai = p.id_pegawai
                LEFT JOIN jabatan j ON bd.id_j = j.id_j
                WHERE def_baperjakat.id_baperjakat = $id_baperjakat");

        $data = null;
        foreach ($query->result() as $row)
        {
            $data[] = $row;
        }
        return $data;
    }

    public function get_by_id($id_baperjakat){
        $this->db->where('id_baperjakat', $id_baperjakat);
        return $this->db->get('baperjakat')->row();
    }

    public function getInfoBaperjakat($idbaperjakat){
        $sql ="SELECT * FROM baperjakat WHERE id_baperjakat = $idbaperjakat";
        $query = $this->db->query($sql);
        $data = null;
        foreach ($query->result() as $row)
        {
            $data[] = $row;
        }
        return $data;
    }

    public function getDetailBaperjakat($idbaperjakat){
        $sql ="SELECT bd.idpegawai, p.nip_baru, p.gelar_depan, p.nama, p.gelar_belakang, j.jabatan, rsk.status_keanggotaan
                FROM baperjakat_detail bd, pegawai p, jabatan j, ref_status_keanggotaan rsk
                WHERE bd.idpegawai = p.id_pegawai and bd.id_j = j.id_j AND bd.idstatus_keanggotaan = rsk.idstatus_keanggotaan
                AND bd.id_baperjakat = $idbaperjakat;";
        $query = $this->db->query($sql);
        $data = null;
        foreach ($query->result() as $row)
        {
            $data[] = $row;
        }
        return $data;
    }

    public function getStatusKeanggotaan(){
        $sql ="SELECT * FROM ref_status_keanggotaan";
        $query = $this->db->query($sql);
        $data = null;
        foreach ($query->result() as $row)
        {
            $data[] = $row;
        }
        return $data;
    }
    public function getCountAllFindPegawai($cboPangkat,$txtKeyword,$cboJab,$cboUnit){
        $andklausa = '';
        if (!($cboPangkat=="0") && !($cboPangkat=="")){
            $andklausa = " AND (p.pangkat_gol = '".$cboPangkat."')".$andklausa;
        }
        if (!($cboJab=="0") && !($cboJab=="")){
            $andklausa = " AND (p.id_j = '".$cboJab."')".$andklausa;
        }
        if (!($cboUnit=="0") && !($cboUnit=="")){
            $andklausa = " AND (uk.id_skpd = '".$cboUnit."')".$andklausa;
        }
        if (!(trim($txtKeyword)== "") && !(trim($txtKeyword)== "0")){
            $andklausa = " AND (p.nip_baru LIKE '%".$txtKeyword."%'
								OR p.nama LIKE '%".$txtKeyword."%'
								OR uk.nama_baru LIKE '%".$txtKeyword."%'
								OR j.jabatan LIKE '%".$txtKeyword."%')".$andklausa;
        }
        $sql ="SELECT COUNT(p.id_pegawai) as jumlah_all
                FROM
                (SELECT p.id_pegawai, p.nama, p.gelar_depan, p.gelar_belakang, p.nip_baru, p.pangkat_gol, p.id_j, uk.id_skpd
                FROM pegawai p, current_lokasi_kerja clk, unit_kerja uk
                WHERE p.id_pegawai = clk.id_pegawai AND clk.id_unit_kerja = uk.id_unit_kerja AND
                p.flag_pensiun = 0  AND p.id_j IS NOT NULL) AS p, jabatan j, unit_kerja uk
                WHERE p.id_j = j.id_j AND p.id_skpd = uk.id_unit_kerja AND j.Tahun = (SELECT MAX(tahun) FROM jabatan)".$andklausa.
                " ORDER BY p.pangkat_gol DESC, p.nama";
        $query = $this->db->query($sql);
        foreach ($query->result() as $row){
            $count = $row->jumlah_all;
        }
        return $count;
    }

    public function getFindPegawai($row_number_start, $cboPangkat,$txtKeyword,$cboJab,$cboUnit,$limit,$posisi){
        $andklausa = '';
        if (!($cboPangkat=="0") && !($cboPangkat=="")){
            $andklausa = " AND (p.pangkat_gol = '".$cboPangkat."')".$andklausa;
        }
        if (!($cboJab=="0") && !($cboJab=="")){
            $andklausa = " AND (p.id_j = '".$cboJab."')".$andklausa;
        }
        if (!($cboUnit=="0") && !($cboUnit=="")){
            $andklausa = " AND (uk.id_skpd = '".$cboUnit."')".$andklausa;
        }
        if (!(trim($txtKeyword)== "") && !(trim($txtKeyword)== "0")){
            $andklausa = " AND (p.nip_baru LIKE '%".$txtKeyword."%'
								OR p.nama LIKE '%".$txtKeyword."%'
								OR uk.nama_baru LIKE '%".$txtKeyword."%'
								OR j.jabatan LIKE '%".$txtKeyword."%')".$andklausa;
        }
        $this->db->query("SET @row_number := $row_number_start");
        $sql ="SELECT FCN_ROW_NUMBER() as no_urut, p.id_pegawai, p.nip_baru, CONCAT(CASE WHEN p.gelar_depan = '' THEN '' ELSE CONCAT(p.gelar_depan, ' ') END,
                nama, CASE WHEN p.gelar_belakang = '' THEN '' ELSE CONCAT(' ',p.gelar_belakang) END) AS nama, p.pangkat_gol,
                j.jabatan, uk.nama_baru AS unit_kerja
                FROM
                (SELECT p.id_pegawai, p.nama, p.gelar_depan, p.gelar_belakang, p.nip_baru, p.pangkat_gol, p.id_j, uk.id_skpd
                FROM pegawai p, current_lokasi_kerja clk, unit_kerja uk
                WHERE p.id_pegawai = clk.id_pegawai AND clk.id_unit_kerja = uk.id_unit_kerja AND
                p.flag_pensiun = 0  AND p.id_j IS NOT NULL) AS p, jabatan j, unit_kerja uk
                WHERE p.id_j = j.id_j AND p.id_skpd = uk.id_unit_kerja AND j.Tahun = (SELECT MAX(tahun) FROM jabatan)".$andklausa.
                " ORDER BY p.pangkat_gol DESC, p.nama ".$limit;
        $query = $this->db->query($sql);
        $data = null;
        foreach ( $query->result() as $row)
        {
            $data[] = $row;
        }
        return $data;
    }

    public function getPangkat(){
        $sql = "SELECT DISTINCT g.golongan, CONCAT(g.golongan, ' (', g.pangkat, ')') AS gol_pangkat
                FROM pegawai p, golongan g
                WHERE p.pangkat_gol = g.golongan AND p.flag_pensiun = 0 AND p.id_j IS NOT NULL
                ORDER BY g.id_golongan ASC;";
        $query = $this->db->query($sql);
        $data = null;
        foreach ( $query->result() as $row)
        {
            $data[] = $row;
        }
        return $data;
    }

    public function getJabatan(){
        $sql = "SELECT j.id_j, j.jabatan
                FROM pegawai p, jabatan j
                WHERE p.id_j = j.id_j AND p.flag_pensiun = 0 AND p.id_j IS NOT NULL
                AND j.Tahun = (SELECT MAX(tahun) FROM jabatan)
                ORDER BY j.eselon ASC, j.jabatan DESC;";
        $query = $this->db->query($sql);
        $data = null;
        foreach ( $query->result() as $row)
        {
            $data[] = $row;
        }
        return $data;
    }

    public function getUnitKerja(){
        $sql = "SELECT uk.id_unit_kerja, uk.nama_baru
                FROM
                (SELECT DISTINCT uk.id_skpd
                FROM pegawai p, current_lokasi_kerja clk, unit_kerja uk
                WHERE p.id_pegawai = clk.id_pegawai AND clk.id_unit_kerja = uk.id_unit_kerja AND
                p.flag_pensiun = 0 AND p.id_j IS NOT NULL AND uk.tahun = (SELECT MAX(tahun) FROM unit_kerja)
                ORDER BY uk.id_skpd ASC) AS uk_jab, unit_kerja uk
                WHERE uk_jab.id_skpd = uk.id_unit_kerja
                ORDER BY uk.nama_baru;";
        $query = $this->db->query($sql);
        $data = null;
        foreach ( $query->result() as $row)
        {
            $data[] = $row;
        }
        return $data;
    }

    public function infoPegawai($idpegawai){
        $andklausa = " AND p.id_pegawai = ".$idpegawai;
        $sql ="SELECT p.id_pegawai, p.nip_baru, CONCAT(CASE WHEN p.gelar_depan = '' THEN '' ELSE CONCAT(p.gelar_depan, ' ') END,
                nama, CASE WHEN p.gelar_belakang = '' THEN '' ELSE CONCAT(' ',p.gelar_belakang) END) AS nama, p.pangkat_gol,
                j.jabatan, uk.nama_baru AS unit_kerja, p.id_j
                FROM
                (SELECT p.id_pegawai, p.nama, p.gelar_depan, p.gelar_belakang, p.nip_baru, p.pangkat_gol, p.id_j, uk.id_skpd
                FROM pegawai p, current_lokasi_kerja clk, unit_kerja uk
                WHERE p.id_pegawai = clk.id_pegawai AND clk.id_unit_kerja = uk.id_unit_kerja AND
                p.flag_pensiun = 0  AND p.id_j IS NOT NULL) AS p, jabatan j, unit_kerja uk
                WHERE p.id_j = j.id_j AND p.id_skpd = uk.id_unit_kerja AND j.Tahun = (SELECT MAX(tahun) FROM jabatan)".$andklausa.
            " ORDER BY p.pangkat_gol DESC, p.nama ";
        $query = $this->db->query($sql);
        $data = null;
        foreach ( $query->result() as $row)
        {
            $data[] = $row;
        }
        return $data;
    }

    public function insertBaperjakat($nosk_tim, $pengesah, $pejabat){
        $this->db->trans_begin();
        $this->no_sk = $nosk_tim;
        $this->pengesah_sk = $pengesah;
        $this->nama_pengesah_sk = $pejabat;
        $this->db->insert('baperjakat', $this);
        if ($this->db->trans_status() === FALSE)
        {
            $this->db->trans_rollback();
        }else{
            $insert_id = $this->db->insert_id();
            $this->db->trans_commit();
        }
        return  $insert_id;
    }

    public function insertBaperjakatDetail($data){
        $this->db->trans_begin();
        $sql = "insert into baperjakat_detail(idpegawai, id_j, idstatus_keanggotaan, id_baperjakat) ".
            "values (".$data['idpegawai'].','.$data['id_j'].",'".$data['idstatus_keanggotaan'].
            "','".$data['id_baperjakat']."')";
        $this->db->query($sql);
        if ($this->db->trans_status() === FALSE)
        {
            $this->db->trans_rollback();
            $query = false;
        }else{
            $this->db->trans_commit();
            $query = true;
        }
        return $query;
    }

    public function updateBaperjakat($nosk_tim, $pengesah, $pejabat, $id_baperjakat){
        $this->db->trans_begin();
        $sql = "update baperjakat set " .
            "no_sk =  '" . $nosk_tim .
            "', pengesah_sk =  '" . $pengesah . "', nama_pengesah_sk =  '" . $pejabat .
            "' where id_baperjakat = " . $id_baperjakat;
        $this->db->query($sql);
        if ($this->db->trans_status() === FALSE)
        {
            $this->db->trans_rollback();
            $query = false;
        }else{
            $this->db->trans_commit();
            $query = true;
        }
        return $query;
    }

    public function updateBaperjakatDetail($data){
        $this->db->trans_begin();
        $sql = "update baperjakat_detail set " .
            "idpegawai =  '" . $data['idpegawai'] .
            "', id_j =  '" . $data['id_j'] .
            "' where iddetail_baperjakat = " . $data['id_detbaperjakat'];

        echo $sql;
        $this->db->query($sql);
        if ($this->db->trans_status() === FALSE)
        {
            $this->db->trans_rollback();
            $query = false;
        }else{
            //$this->db->trans_commit();
            $query = true;
        }
        return $query;
    }

    public function deleteBaperjakat($id_baperjakat){
        $sql = "delete from baperjakat where id_baperjakat = ".$id_baperjakat;
        $this->db->query($sql);
        if ($this->db->trans_status() === FALSE)
        {
            $this->db->trans_rollback();
            $query = false;
        }else{
            $this->db->trans_commit();
            $query = true;
        }
        return $query;
    }

}