<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


	/**
	*
	*
	*/
class Card extends CI_Controller{

	function __construct(){

		parent::__construct();

		$this->load->model('user_model','user');
		$this->load->model('pegawai_model','pegawai');
		$this->load->model('jabatan_model','jabatan');
		$this->load->library('format');

	}

    function index(){

        $this->load->view('layout/header', array( 'title' => 'ID Card'));
		$this->load->view('card/header');
		$this->load->view('card/index');
		$this->load->view('layout/footer');
    }

    function cetak($id_pegawai=null){

        $this->load->view('layout/header', array( 'title' => 'ID Card'));

        $this->pegawai->id_pegawai = $id_pegawai;
		$data['pegawai'] = $this->pegawai->get_by_id($this->uri->segment(3));
		$data['id_pegawai'] = $id_pegawai;
		$data['today'] = $this->format->tanggal_indo(date("Y-m-d"));
			$this->load->view('card/header',$data);
		$this->load->view('card/cetak',$data);
		$this->load->view('layout/footer');

    }

	function barcode($nip){

		$this->load->library('zend');
		$this->zend->load('Zend/Barcode');
		//Zend_Barcode::render('code25', 'image', array('text'=>$nip), array());
		//Zend_Barcode::factory('code39', 'image', $barcodeOPT, $renderOPT)->render();

		$barcodeOptions = array(
			'text' => $nip,
			'drawText'=> False,
			'barHeight'=> 15,
			'barThickWidth'=>2,
			'factor'=>3.98,
		);

		$rendererOptions = array();
		Zend_Barcode::factory('code25', 'image', $barcodeOptions, $rendererOptions)->render();


	}




}
