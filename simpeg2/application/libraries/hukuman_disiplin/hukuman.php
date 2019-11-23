<?php 
class Hukuman{
	var $pegawai = '';
	var $CI = '';
	
	public function __construct($pegawai)
	{
		$this->pegawai = $pegawai;
		$this->CI = & get_instance();			
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
/* End of file hukuman.php */
/* Location: ./application/libraries/hukuman.php */
?>
