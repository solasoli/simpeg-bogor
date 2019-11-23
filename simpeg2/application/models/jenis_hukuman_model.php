<?php 
class Jenis_hukuman_model extends CI_Model{
		
	public function __construct()
	{}

	public function insert(){
		$this->kode_lamaran 			= $this->input->post('txtKodeLamaran');
		$this->tahun 					= $this->input->post('txtTahun');
		$this->jenis_jabatan_id			= $this->input->post('cboJenjab');
		$this->nama_jabatan 			= $this->input->post('txtNamaJabatan');
		$this->kualifikasi_pendidikan 	= $this->input->post('cboKualifikasiPendidikan')." ".$this->input->post('txtJurusan');
		$this->jumlah					= $this->input->post('txtJumlah');
		
		$this->db->insert('formasi', $this);
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
}
/* End of file jenis_hukuman_model.php */
/* Location: ./application/models/jenis_hukuman_model.php */
?>
