<?php 
class Gapok_model extends CI_Model{
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
	
	public function get_tahun(){
		$query = $this->db->query("SELECT DISTINCT tahun
									FROM  `gaji_pokok` 
									ORDER BY tahun DESC");

		$data = null;
		foreach ($query->result() as $row)
		{
			$data[] = $row;
		}
		return $data;
	}
	
	public function get_gapok($golongan, $masa_kerja, $tahun){
		$query = $this->db->query("SELECT id_gaji_pokok, gaji
								FROM gaji_pokok
								WHERE pangkat_gol =  '$golongan'
								AND masa_kerja = '$masa_kerja'
								AND tahun = '$tahun'");

		$data = null;
		foreach ($query->result() as $row)
		{
			return $row;
		}
		return null;
	}
	
	public function get_last_gapok($golongan, $masa_kerja){
	
		
		//$this->db->select_max('tahun');
		//$tahun = $this->db->get('gaji_pokok')->tahun;
		$tahun = $this->db->query('select MAX(tahun) as tahun from gaji_pokok')->row()->tahun;
		$this->db->where('pangkat_gol',$golongan);
		$this->db->where('masa_kerja', $masa_kerja);
		$this->db->where('tahun',$tahun);
		
		return $this->db->get('gaji_pokok');
		
		
	}
}
