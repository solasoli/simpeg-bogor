<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Golongan_model extends CI_Model{
	
		
	public function __Construct(){
	
		parent::__Construct();
		
	}
	
	function get_stat(){
		$query = "select pangkat_gol as golongan, count(*) as jumlah
				from pegawai 
				where flag_pensiun = 0
				group by pangkat_gol
				order by pangkat_gol ASC";
		return $this->db->query($query);
	}
	
	
	
}
