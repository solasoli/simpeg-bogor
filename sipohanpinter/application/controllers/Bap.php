<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Bap extends CI_Controller {
	function __construct() {
		parent::__construct();
		$this->load->library('session');

		if(!$this->session->userdata('user')){
			redirect('login');
		}
		$this->load->model('Hukuman_model','hukuman');
    $this->load->library('format');
  }

function list(){
  $data['title']  = 'Sipohanpinter::Berita Acara Pemeriksaan';
  $data['page']   = 'bap/bap_list';
  $data['panggilans'] = $this->db->get('hukuman_pemeriksaan')->result();
  $this->db->select('tingkat_hukuman');
  $this->db->group_by('tingkat_hukuman');
  $data['tingkat'] = $this->db->get('jenis_hukuman')->result();
  //print_r($data['tingkat']);exit;
  $data['jenis_hukdis'] = $this->db->get('jenis_hukuman')->result();
  $data['tab_panggilan'] = $this->load->view('Sipohan/tab_panggilan',NULL,TRUE);
  //$data['berwenang'] = $this->sipohan->getPengesah('11301');

  $this->load->view('layout',$data);
}


	function proses(){
	  $data['title']  = 'Sipohanpinter::Berita Acara Pemeriksaan';
	  $data['page']   = 'bap/bap_list';
	  $data['panggilans'] = $this->db->get('hukuman_pemeriksaan')->result();
	  $this->db->select('tingkat_hukuman');
	  $this->db->group_by('tingkat_hukuman');
	  $data['tingkat'] = $this->db->get('jenis_hukuman')->result();
	  //print_r($data['tingkat']);exit;
	  $data['jenis_hukdis'] = $this->db->get('jenis_hukuman')->result();
	  $data['tab_panggilan'] = $this->load->view('Sipohan/tab_panggilan',NULL,TRUE);
	  //$data['berwenang'] = $this->sipohan->getPengesah('11301');

	  $this->load->view('layout',$data);

	}

	public function result($idhukuman_pemeriksaan){

		$data['pemeriksaan'] = $this->db->get_where('hukuman_pemeriksaan',array('idhukuman_pemeriksaan'=>$idhukuman_pemeriksaan))->row();
		$data['tim_pemeriksa'] = $this->db->get_where('hukuman_tim',array('idhukuman_pemeriksaan'=>$idhukuman_pemeriksaan))->result();
	//	echo $this->db->last_query();
		/*echo "<pre>";
		print_r($data['tim_pemeriksa']);
		echo "</pre>";
		*/
		$this->load->view('bap/bap_result',$data);
	}
	public function uncooperated_report($idhukuman_pemeriksaan){

		$data['pemeriksaan'] = $this->db->get_where('hukuman_pemeriksaan',array('idhukuman_pemeriksaan'=>$idhukuman_pemeriksaan))->row();
		$data['tim_pemeriksa'] = $this->db->get_where('hukuman_tim',array('idhukuman_pemeriksaan'=>$idhukuman_pemeriksaan))->result();
	//	echo $this->db->last_query();
		/*echo "<pre>";
		print_r($data['tim_pemeriksa']);
		echo "</pre>";
		*/
		$this->load->view('bap/bap_laporan_uncooperated',$data);
	}

	public function cooperated_report($idhukuman_pemeriksaan){

		$data['pemeriksaan'] = $this->db->get_where('hukuman_pemeriksaan',array('idhukuman_pemeriksaan'=>$idhukuman_pemeriksaan))->row();
		$data['tim_pemeriksa'] = $this->db->get_where('hukuman_tim',array('idhukuman_pemeriksaan'=>$idhukuman_pemeriksaan))->result();
	//	echo $this->db->last_query();
		/*echo "<pre>";
		print_r($data['tim_pemeriksa']);
		echo "</pre>";
		*/
		$this->load->view('bap/bap_laporan_cooperated',$data);
	}
}
