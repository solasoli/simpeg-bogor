<?php 
class Riwayat_jabatan_model extends CI_Model{
	var $id_riwayat_kerja = '';
	var $id_pegawai = '';
	var $Jabatan = '';
	var $unit_kerja = '';
	var $no_sk = '';	
	var $tgl_masuk = '';
	var $tgl_keluar = '';
		
	public function __construct(){
	}
	
	public function get($id_pegawai){
		$query = $this->db->query("SELECT * 
			FROM  `riwayat_kerja` 
			WHERE id_pegawai = $id_pegawai
			ORDER BY tgl_masuk DESC");

		$data = null;
		foreach ($query->result() as $row)
		{
			$data[] = $row;
		}
		return $data;
	}
	
	
	
	public function get_by_id_pegawai($id_pegawai){
	
		//$data = new Array();
		$query = $this->db->query("select * from
							(select j.jabatan as Jabatan,  uk.nama_baru as unit_kerja, sk.no_sk, sk.tmt as tgl_masuk
												from sk 
												inner join jabatan j on j.id_j = sk.id_j
												inner join unit_kerja uk on uk.id_unit_kerja = j.id_unit_kerja
												where id_kategori_sk = 10 and sk.id_pegawai = '".$id_pegawai."'
							union (SELECT jabatan as Jabatan, unit_kerja, no_sk, tgl_masuk 
										FROM  `riwayat_kerja` 
										WHERE id_pegawai = '".$id_pegawai."'
										ORDER BY tgl_masuk DESC)) as z order by tgl_masuk DESC");

		$data = null;
		foreach($query->result() as $row ){
			
			$data[] = $row;
		}
		
		
		
		return $data;
	
	}

    public function get_by_id_pegawai_by_eselon_count($id_pegawai, $eselon){
        //$data = new Array();
        $query = $this->db->query("select count(*) AS jumlah from
							(select j.jabatan as Jabatan,  uk.nama_baru as unit_kerja, sk.no_sk, sk.tmt as tgl_masuk, j.eselon
												from sk 
												inner join jabatan j on j.id_j = sk.id_j
												inner join unit_kerja uk on uk.id_unit_kerja = j.id_unit_kerja
												where id_kategori_sk = 10 and sk.id_pegawai = '".$id_pegawai."'
							union (SELECT jabatan as Jabatan, unit_kerja, no_sk, tgl_masuk, NULL as eselon 
										FROM  `riwayat_kerja` 
										WHERE id_pegawai = '".$id_pegawai."'
										ORDER BY tgl_masuk DESC)) as z where z.eselon = '$eselon' order by tgl_masuk DESC");

        $rowcount = $query->num_rows();
        if($rowcount > 0) {
            foreach ($query->result() as $data) {
                $jmlData = $data->jumlah;
            }
        }else{
            $jmlData = 0;
        }
        return $jmlData;
    }
	
}
