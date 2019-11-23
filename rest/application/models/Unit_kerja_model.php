<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Unit_kerja_model extends CI_Model{

	public function __Construct(){
		parent::__Construct();
		
	}

    public function get($param=NULL){

        $query = "select uk.id_unit_kerja, 
					uk.nama_baru as unit_kerja,
					uk.id_skpd as id_opd,
					opd.nama_baru as opd,
					uk.tahun
				from unit_kerja	uk
				inner join unit_kerja opd on opd.id_unit_kerja = uk.id_skpd				
				where uk.tahun = (select max(tahun) from unit_kerja)";

        if(isset($param)){
            $param = urldecode($param);
            $query .= "AND (uk.nama_baru like '%".$param."%' OR uk.id_unit_kerja = '".$param."')";
        }
        return $this->db->query($query);
    }

    public function get_unit($param=NULL){

        $query = "select uk.id_unit_kerja,
					uk.nama_baru as unit_kerja,
					uk.id_skpd as id_opd,
					opd.nama_baru as opd,
					uk.tahun
				from unit_kerja	uk
				inner join unit_kerja opd on opd.id_unit_kerja = uk.id_skpd
				where uk.tahun = (select max(tahun) from unit_kerja) /*and uk.nama_baru = '$param'*/";

        return $this->db->query($query);
    }

    public function get_stat(){

        /*$query = "SELECT u.id_skpd, nama_skpd, nama_baru, COUNT(nama_baru) AS jumlah
                    FROM pegawai p
                    INNER JOIN current_lokasi_kerja c ON p.id_pegawai = c.id_pegawai
                    INNER JOIN unit_kerja u ON u.id_unit_kerja = c.id_unit_kerja
                    INNER JOIN skpd on skpd.id_unit_kerja = u.id_skpd
                    where flag_pensiun = 0
                    GROUP BY u.id_skpd
                    ORDER BY nama_skpd ASC";*/

        $sql = "SELECT uk.id_unit_kerja as id_skpd, uk.nama_baru as nama_skpd, uk.nama_baru, COUNT(a.id_pegawai) AS jumlah
				FROM unit_kerja uk,
				(SELECT p.id_pegawai, c.id_unit_kerja, u.id_skpd, u.tahun
				FROM pegawai p
				INNER JOIN current_lokasi_kerja c ON p.id_pegawai = c.id_pegawai
				INNER JOIN unit_kerja u ON u.id_unit_kerja = c.id_unit_kerja
				WHERE flag_pensiun = 0) a
				WHERE uk.id_unit_kerja = a.id_skpd AND uk.tahun = (SELECT MAX(tahun) FROM unit_kerja uk1)
				GROUP BY uk.id_unit_kerja, uk.nama_baru ORDER BY nama_skpd ASC";

        return $this->db->query($sql);
    }

    public function get_stat_per_unit($opd){
        $sql = "SELECT uk.id_unit_kerja, uk.nama_baru as nama_skpd, COUNT(a.id_pegawai) AS jumlah
				FROM unit_kerja uk,
				(SELECT p.id_pegawai, c.id_unit_kerja, u.id_skpd, u.tahun
				FROM pegawai p
				INNER JOIN current_lokasi_kerja c ON p.id_pegawai = c.id_pegawai
				INNER JOIN unit_kerja u ON u.id_unit_kerja = c.id_unit_kerja
				WHERE flag_pensiun = 0 AND u.id_skpd = $opd) a
				WHERE uk.id_unit_kerja = a.id_unit_kerja AND uk.tahun =
				(SELECT MAX(tahun) FROM unit_kerja uk1)
				GROUP BY uk.id_unit_kerja, uk.nama_baru ORDER BY nama_skpd ASC";
        return $this->db->query($sql);
    }

    public function getAll(){
        $query = "select distinct
						id_unit_kerja as id_skpd,						
						nama_baru as nama_skpd,
						singkatan,
						alamat,
						telp,
						email_opd as email,
						CONCAT('".base_url('unit_kerja/daftarPegawai/')."/',id_unit_kerja) as daftarPegawai						
					from unit_kerja uk1 					
					where 					
					tahun = (select max(tahun) from unit_kerja)
					and id_unit_kerja = id_skpd order by nama_baru
					";
        return $this->db->query($query);
    }

    public function getByTahun($thn){
        $sql = "select distinct
						id_unit_kerja as id_skpd,
						nama_baru as nama_skpd,
						singkatan,
						alamat,
						telp,
						email_opd as email,
						CONCAT('".base_url('unit_kerja/daftarPegawai/')."/',id_unit_kerja) as daftarPegawai
					from unit_kerja uk1
					where
					tahun = ".$thn." and id_unit_kerja = id_skpd";
        return $this->db->query($sql);
    }

    public function get_opd($param=NULL){
        $query = "select uk.id_unit_kerja, 
					uk.nama_baru as unit_kerja,
					uk.id_skpd as id_opd,
					opd.nama_baru as opd					
				from unit_kerja	uk
				inner join unit_kerja opd on opd.id_unit_kerja = uk.id_skpd				
				where uk.tahun = (select max(tahun) from unit_kerja)
				and opd.id_unit_kerja = uk.id_unit_kerja
				";
        if(isset($param)){
            $param = urldecode($param);
            $query .= "AND (uk.nama_baru like '%".$param."%' OR uk.id_unit_kerja = '".$param."')";
        }
        return $this->db->query($query);
    }

    public function getDaftarPegawaiByIdSkpd($id_skpd){
        $query = "select * from
					(select p.id_pegawai,
					TRIM(IF(LENGTH(p.gelar_belakang) > 1,
							CONCAT(p.gelar_depan,
									' ',
									p.nama,
									CONCAT(', ', p.gelar_belakang)),
							CONCAT(p.gelar_depan, ' ', p.nama))) AS nama, 
							p.nip_baru as nip,
							IF(p.id_j is not NULL, p.jabatan, IF(p.id_j is null and p.jenjab = 'Struktural','Pelaksana',p.jabatan)) as jabatan,
							IF(j.eselon is NULL, 'NS', j.eselon) as eselon,
							p.tempat_lahir as tempat_lahir, date_format(p.tgl_lahir,'%d-%m-%Y') as tgl_lahir,
							
							g.pangkat,
							p.pangkat_gol as golongan,        
							uk.nama_baru as unit_kerja               
					from pegawai p
					inner join current_lokasi_kerja clk on clk.id_pegawai = p.id_pegawai
					inner join unit_kerja uk on uk.id_unit_kerja = clk.id_unit_kerja
					left join golongan g on g.golongan = p.pangkat_gol
					left join jabatan j on j.id_j = p.id_j
					where uk.id_skpd = ".$id_skpd." and p.flag_pensiun = 0
					and uk.tahun = (select max(tahun) from unit_kerja)) t
					order by unit_kerja ASC, eselon, golongan DESC ";

        return $this->db->query($query);
    }

    public function getUnitKerjaAll(){
        $sql = "select * from unit_kerja where tahun = 
        (select max(tahun) from unit_kerja)";
        return $this->db->query($sql);
    }

    function listUnitKerjaAppsBisa($tahun, $is_skpd_only){
        if($tahun!='0' and $tahun!=''){
            $filter = $tahun;
        }else{
            $filter = "(SELECT MAX(tahun) FROM unit_kerja)";
        }

        if($is_skpd_only=='true'){
            $andKlausa = ' and uk.id_unit_kerja = uk.id_skpd';
        }else{
            $andKlausa = '';
        }
        $sql = "SELECT uk.id_unit_kerja, uk.nama_baru as unit_kerja, uk.id_old, uk.tahun, uk.id_skpd
                FROM unit_kerja uk WHERE uk.tahun = $filter $andKlausa";
        return $this->db->query($sql);
    }

	/*public function get_all($rec_per_page=10, $start=0){
		$query = "select 
					id_unit_kerja, 
					nama_baru as nama_unit_kerja,
					alamat,
					telp,
					email_opd,
					id_skpd
				from unit_kerja
				where tahun = (select max(tahun) from unit_kerja)
				";
		return $this->db->query($query);
	}*/
	



}
