<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Jabatan_model extends CI_Model{

	public function __Construct(){
	
		parent::__Construct();
		
	}

    public function getRekapByJenjab(){
        $sql = "SELECT p.jenjab, COUNT(p.id_pegawai) AS jumlah
                FROM pegawai p WHERE p.flag_pensiun = 0 GROUP BY p.jenjab";
        return $this->db->query($sql);
    }

    public function getRekapByJenjabPerOPD($opd){
        $sql = "SELECT p.jenjab, uk.id_unit_kerja, uk.nama_baru as unit_kerja,
                COUNT(p.id_pegawai) AS jumlah
                FROM pegawai p, current_lokasi_kerja clk, unit_kerja uk
                WHERE p.flag_pensiun = 0 AND p.id_pegawai = clk.id_pegawai AND
                  clk.id_unit_kerja = uk.id_unit_kerja AND uk.id_skpd = $opd
                GROUP BY p.jenjab, uk.id_unit_kerja, uk.nama_baru";
        return $this->db->query($sql);
    }

    public function getRekapByFungsional(){
        $sql = "SELECT p.jabatan, COUNT(p.id_pegawai) AS jumlah
                FROM pegawai p WHERE p.flag_pensiun = 0 AND p.jenjab = 'Fungsional' GROUP BY p.jabatan";
        return $this->db->query($sql);
    }

    public function getRekapByFungsionalPerOPD($opd){
        $sql = "SELECT p.jabatan, COUNT(p.id_pegawai) AS jumlah
                FROM pegawai p, current_lokasi_kerja clk, unit_kerja uk
                WHERE p.flag_pensiun = 0 AND p.jenjab = 'Fungsional' AND p.id_pegawai = clk.id_pegawai AND
                  clk.id_unit_kerja = uk.id_unit_kerja AND uk.id_skpd = $opd
                GROUP BY p.jabatan, uk.id_unit_kerja, uk.nama_baru";
        return $this->db->query($sql);
    }

    public function getRekapByStruktural(){
        $sql = "SELECT eselon,COUNT(eselon) AS jumlah FROM pegawai
                INNER JOIN jabatan ON jabatan.id_j = pegawai.id_j and flag_pensiun = 0
                GROUP BY eselon UNION
                SELECT 'Staf', COUNT(p.id_pegawai) as jumlah FROM pegawai p
                WHERE flag_pensiun = 0  AND p.jenjab = 'Struktural' AND ( p.id_j=0 or p.id_j IS NULL)";
        return $this->db->query($sql);
    }

    public function getRekapByStrukturalPerOPD($opd){
        $sql = "SELECT a.* FROM
                (SELECT j.eselon, uk.id_unit_kerja, uk.nama_baru as unit_kerja,
                COUNT(j.eselon) AS jumlah
                FROM pegawai p
                INNER JOIN jabatan j ON j.id_j = p.id_j, current_lokasi_kerja clk, unit_kerja uk
                WHERE p.flag_pensiun = 0 AND p.id_pegawai = clk.id_pegawai AND
                clk.id_unit_kerja = uk.id_unit_kerja AND uk.id_skpd = $opd
                GROUP BY j.eselon, uk.id_unit_kerja, uk.nama_baru
                UNION
                SELECT 'Staf', uk.id_unit_kerja, uk.nama_baru as unit_kerja,
                COUNT(p.id_pegawai) as jumlah
                FROM pegawai p, current_lokasi_kerja clk, unit_kerja uk
                WHERE flag_pensiun = 0  AND p.jenjab = 'Struktural' AND ( p.id_j=0 or p.id_j IS NULL)
                AND p.id_pegawai = clk.id_pegawai AND
                clk.id_unit_kerja = uk.id_unit_kerja AND uk.id_skpd = $opd) a
                ORDER BY a.unit_kerja, a.eselon";
        return $this->db->query($sql);
    }

    public function getAll(){
        $sql = "SELECT id_j, jabatan, id_unit_kerja, id_bos, eselon, tahun
                FROM jabatan ORDER BY Tahun, id_j;";
        return $this->db->query($sql);
    }

    public function idkel(){
        $sql = "SELECT   id_unit_kerja,nama_baru FROM unit_kerja 
        where nama_baru like 'kelurahan%' and tahun = (SELECT MAX(tahun) FROM unit_kerja)";
        return $this->db->query($sql);
    }

    public function jkel($idkel){
        $sql = "SELECT   concat(gelar_depan,' ',nama,' ',gelar_belakang) as nama ,jabatan.jabatan 
        FROM jabatan inner join pegawai on pegawai.id_j=jabatan.id_j 
        where id_unit_kerja=$idkel and jabatan.tahun=(SELECT MAX(tahun) FROM jabatan) order by eselon";
        return $this->db->query($sql);
    }

    public function esurat_jabatan(){
        $sql = "select jabatan.id_unit_kerja as 'ID OPD Baru',id_old as 'ID OPD Lama',nama_baru as 'Nama OPD' ,id_skpd as 'ID OPD Induk',id_j 'ID Jabatan',jabatan as 'Nomenklatur' 
                from jabatan inner join unit_kerja on unit_kerja.id_unit_kerja = jabatan.id_unit_kerja 
                where jabatan.tahun=(select max(jabatan.tahun) from jabatan)";
        return $this->db->query($sql);
    }

    public function getByTahun($thn){
        $sql = "SELECT id_j, jabatan, id_unit_kerja, id_bos, eselon, tahun
                FROM jabatan WHERE tahun = $thn ORDER BY Tahun, id_j;";
        return $this->db->query($sql);
    }

    public function getByOPD($id_skpd){
        $sql = "SELECT j.id_j as id_j, j.jabatan as jabatan, p.id_pegawai,
					trim(IF(LENGTH(p.gelar_belakang) > 1,
						CONCAT(p.gelar_depan,
								' ',
								p.nama,
								CONCAT(', ', p.gelar_belakang)),
						CONCAT(p.gelar_depan, ' ', p.nama))) AS nama,
					nip_baru as nip, 
					eselon, p.id_pegawai 
                FROM jabatan j
				inner join unit_kerja uk on uk.id_unit_kerja = j.id_unit_kerja
				left join pegawai p on p.id_j = j.id_j
				where uk.id_skpd= $id_skpd order by eselon;";
        return $this->db->query($sql);
    }
	
    public function getByUnitKerja($id_skpd){
        $sql = "SELECT jabatan.id_j, jabatan.jabatan as jabatan, pegawai.id_j,
					concat(gelar_depan,' ',nama,' ',gelar_belakang) as nama,
					nip_baru as nip, 
					eselon 
                FROM jabatan 
				left join pegawai on pegawai.id_j=jabatan.id_j 
				where id_unit_kerja=$id_skpd order by eselon";
        return $this->db->query($sql);

    }

	
}
