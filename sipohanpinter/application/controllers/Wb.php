<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Wb extends CI_Controller {
	function __construct() {
		parent::__construct();
		$this->load->library('session');
		$this->load->model('Hukuman_model','hukuman');
    $this->load->library('format');
  }

  public function nu(){
    $data['title']  = 'Sipohanpinter::Pemeriksaan';
    $data['page']   = 'wb/depan';

    $this->load->view('layout',$data);
  }

  function lizt(){
      $data['title'] = "Wishtle Blower System";
  		$data['page'] = 'wb/list';

      $data['pengaduan'] = $this->db->get('hukuman_pengaduan')->result();
      $this->load->view('layout',$data);
  }

  function simpan(){

    //print_r($this->input->post());exit;
    if($this->input->post() !== null){

      $data = array("nama_pelapor"=>$this->input->post('nama_pelapor'),
        "telp_pelapor"=>$this->input->post('telp_pelapor'),
        "email_pelapor"=>$this->input->post('email_pelapor'),
        "uraian_pengaduan"=>$this->input->post('uraian'),
        "nama_terlapor"=>$this->input->post('nama_terlapor'),
        "jabatan_terlapor"=>$this->input->post('jabatan_terlapor'),
        "unit_kerja_terlapor"=>$this->input->post('unit_kerja_terlapor'),
        "lampiran"=>"-"
      );

    }

    try{

      $this->db->insert("hukuman_pengaduan",$data);

      $json = array('status'=>'SUCCESS', 'data'=>'-');
			echo json_encode($json);
    }catch(Exception $e){
      $json = array('status'=>'FAILED','data'=>$this->db->_error_message());
      echo json_encode($json);
    }

  }

  function hapus(){

    if($this->db->delete('hukuman_pengaduan',array('id'=>$this->input->post('id')))){
			$json = array('status'=>'SUCCESS', 'data'=>'data berhasil dihapus');
			echo json_encode($json);
		}else{
			$json = array('status'=>'FAILED', 'data'=>$this->db->last_query());
			echo json_encode($json);
		}
  }


}
