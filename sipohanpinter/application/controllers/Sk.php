<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Sk extends CI_Controller {
	function __construct() {
		parent::__construct();
		$this->load->library('session');

		if(!$this->session->userdata('user')){
			redirect('login');
		}
		$this->load->model('Hukuman_model','hukuman');
    $this->load->library('format');
  }

  function sk_list(){
    $data['title']  = 'Sipohanpinter::Daftar Penjatuhan Hukuman Disiplin';
    $data['page']   = 'sk/sk_list';
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

  public function sk_ringan($idhukuman_pemeriksaan){

    $data['pemeriksaan'] = $this->db->get_where('hukuman_pemeriksaan',array('idhukuman_pemeriksaan'=>$idhukuman_pemeriksaan))->row();
    $data['tim_pemeriksa'] = $this->db->get_where('hukuman_tim',array('idhukuman_pemeriksaan'=>$idhukuman_pemeriksaan))->result();
  //	echo $this->db->last_query();
    /*echo "<pre>";
    print_r($data['tim_pemeriksa']);
    echo "</pre>";
    */
    $this->load->view('sk/sk_ringan',$data);
  }
}
