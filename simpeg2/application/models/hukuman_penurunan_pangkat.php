<?php 
class Hukuman_penurunan_pangkat extends CI_Model{
	var $pegawai = '';
	
	public function __construct($pegawai)
	{
		$this->pegawai = $pegawai;
	}
	
	public function get_by_tingkat($tingkat){
		$query = $this->db->query("select *
                                   from jenis_hukuman j 
								   where tingkat_hukuman = '$tingkat'");
		
		foreach ($query->result() as $row)
		{
			$data[] = $row;
		}
		return $data;
	}		
	
	public function save(){
		$query = $this->db->query("select *
                                   from jenis_hukuman j 
								   where tingkat_hukuman = '$tingkat'");
		
		foreach ($query->result() as $row)
		{
			$data[] = $row;
		}
		return $data;
	}	

	public function get_tmt_hukuman(){
		$query = $this->db->query("select *
                                   from jenis_hukuman j 
								   where tingkat_hukuman = '$tingkat'");
		
		foreach ($query->result() as $row)
		{
			$data[] = $row;
		}
		return $data;
	}

	public function confirm(){
		$query = $this->db->query("select *
                                   from jenis_hukuman j 
								   where tingkat_hukuman = '$tingkat'");
		
		foreach ($query->result() as $row)
		{
			$data[] = $row;
		}
		return $data;
	}			

	
}
/* End of file hukuman_penurunan_pangkat.php */
/* Location: ./application/models/hukuman_penurunan_pangkat.php */
?>
