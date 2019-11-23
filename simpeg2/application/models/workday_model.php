<?php 
class Workday_model extends CI_Model{
	var $id_pegawai = '';
	var $id_jenis_hukuman = '';
	var $nama_hukuman = '';
	var $no_keputusan = '';
	var $tgl_hukuman = '';
	var $tmt = '';
	var $pejabat_pemberi_hukuman = '';
	var $jabatan_pemberi_hukuman = '';
	var $keterangan = '';
	
	public function __construct()
	{}
	
	public function count_holiday($start_date, $end_date){
		$query = $this->db->query("SELECT COUNT( * ) as jumlah
								FROM  `oasys_workday` 
								WHERE is_workday =0
								AND workday_date
								BETWEEN  '$start_date'
								AND  '$end_date'");

		$data = null;
		foreach ($query->result() as $row)
		{
			return $row->jumlah;
		}
		
	}		
}
