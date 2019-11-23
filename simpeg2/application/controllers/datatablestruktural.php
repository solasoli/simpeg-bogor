<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Datatablestruktural extends CI_Controller {



	public function __construct(){
		
		parent::__construct();
		$this->load->model('struktural_model');
		
	}
	
	
	
	// unit kerja -------
	function index(){
		//$data['pejabat'] = $this->struktural_model->get_all_pejabat();
		$this->load->view('master/datatablestruktural2');
	}
	
	public function ajax_list()
	{
		$list = $this->struktural_model->get_datatables();
		
		
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $pejabat) {
			//print_r($pejabat);
			//echo $this->db->last_query();
			$no++;
			$row = array();
			$row[] = $no;
			$row[] = $pejabat->nama;
			$row[] = $pejabat->jabatan;
			$row[] = $pejabat->eselon;
			//
			
			$pend = $this->struktural_model->get_pendidikan($pejabat->id_pegawai);
				$po=1;
				$pt=false;
				$edu = "";
				foreach($pend as $pe)
				{
				
					if($pe->level_p<=6)
					{
						if($pe->level_p<=6 and $pe->idb>0)
							$edu .= "$pe->tingkat_pendidikan $pe->jurusan_pendidikan [$pe->bidang]<br>";
							//$row[] = $pejabat->id_pegawai;
						$pt=true;
					}			
					else
					{
						if($pt==false){
							if($pe->idb>0)
								$edu .= "$pe->tingkat_pendidikan $pe->jurusan_pendidikan [$pe->bidang]<br>";
							else
								$edu .= "$pe->tingkat_pendidikan $pe->jurusan_pendidikan <br>";
						}
					}
					 $po++;
				 }
			$row[] = $edu;				 
			$row[] = $pejabat->pangkat_gol;
			$row[] = $pejabat->umur;
			

			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->struktural_model->count_all(),
						"recordsFiltered" => $this->struktural_model->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}
	

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
