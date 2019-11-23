<?php defined('BASEPATH') OR exit('No direct script access allowed');

Class Docs extends MY_Controller {
    public $data;
    public $layout;

    public function __construct()
    {
        parent::__construct();
        $this->layout = 'docs/home';
        $this->data['judul'] = 'Dokumentasi';
        $this->load->model('Api_model','api');
        $jml_methode = $this->api->get_jml_methode_by_entitas('Android');
        $this->data['jmlMthAndro'] = $jml_methode;
        $jml_methode = $this->api->get_jml_methode_by_entitas('Jabatan');
        $this->data['jmlMthJabatan'] = $jml_methode;
        $jml_methode = $this->api->get_jml_methode_by_entitas('Pegawai');
        $this->data['jmlMthPegawai'] = $jml_methode;
        $jml_methode = $this->api->get_jml_methode_by_entitas('Unit_kerja');
        $this->data['jmlMthUnit'] = $jml_methode;
        $jml_methode = $this->api->get_jml_methode_by_entitas('Stat');
        $this->data['jmlMthStat'] = $jml_methode;
        $jml_methode = $this->api->get_jml_methode_by_entitas('E_kinerja');
        $this->data['jmlMthEkinerja'] = $jml_methode;
    }
	
	public function index(){
        $jml_methode = $this->api->get_jml_all_methode();
        $this->data['jmlAll'] = $jml_methode;
        $this->data['main_view'] = 'docs/dashboard';
        $this->load->view($this->layout, $this->data);
	}

	public function doc_android(){
	    $entitas = 'Android';
        $this->data['entitas'] = $entitas;
        $this->data['keterangan'] = 'Daftar methode berikut ini banyak digunakan pada aplikasi berbasis android :';
        $rest_list = $this->api->get_rest_master($entitas);
        $this->data['rest_list'] = $rest_list->result();
        $this->data['main_view'] = 'docs/rest_documentation';
        $this->load->view($this->layout, $this->data);
    }

    public function doc_jabatan(){
        $entitas = 'Jabatan';
        $this->data['entitas'] = $entitas;
        $this->data['keterangan'] = 'Daftar methode berikut ini berkaitan dengan jabatan :';
        $rest_list = $this->api->get_rest_master($entitas);
        $this->data['rest_list'] = $rest_list->result();
        $this->data['main_view'] = 'docs/rest_documentation';
        $this->load->view($this->layout, $this->data);
    }

    public function doc_pegawai(){
        $entitas = 'Pegawai';
        $this->data['entitas'] = $entitas;
        $this->data['keterangan'] = 'Daftar methode berikut ini berkaitan dengan informasi pegawai :';
        $rest_list = $this->api->get_rest_master($entitas);
        $this->data['rest_list'] = $rest_list->result();
        $this->data['main_view'] = 'docs/rest_documentation';
        $this->load->view($this->layout, $this->data);
    }

    public function doc_unit_kerja(){
        $entitas = 'Unit Kerja';
        $this->data['entitas'] = $entitas;
        $this->data['keterangan'] = 'Daftar methode berikut ini berkaitan dengan informasi unit kerja :';
        $rest_list = $this->api->get_rest_master('Unit_kerja');
        $this->data['rest_list'] = $rest_list->result();
        $this->data['main_view'] = 'docs/rest_documentation';
        $this->load->view($this->layout, $this->data);
    }

    public function doc_statistik(){
        $entitas = 'Statistik';
        $this->data['entitas'] = $entitas;
        $this->data['keterangan'] = 'Daftar methode berikut ini berisi rekapitulasi data kepegawaian :';
        $rest_list = $this->api->get_rest_master('Stat');
        $this->data['rest_list'] = $rest_list->result();
        $this->data['main_view'] = 'docs/rest_documentation';
        $this->load->view($this->layout, $this->data);
    }

    public function doc_ekinerja(){
        $entitas = 'E-Kinerja';
        $this->data['entitas'] = $entitas;
        $this->data['keterangan'] = 'Daftar methode berikut ini berkaitan dengan informasi e-kinerja :';
        $rest_list = $this->api->get_rest_master('E_kinerja');
        $this->data['rest_list'] = $rest_list->result();
        $this->data['main_view'] = 'docs/rest_documentation';
        $this->load->view($this->layout, $this->data);
    }

    public function detail_methode_by_id($idmethode){
        $this->load->model('Umum_model','umum');
        $methode = $this->api->get_detail_methode_by_id($idmethode);
        $params = $this->api->get_params_methode_by_id($idmethode);
        $response = $this->api->get_response_methode_by_id($idmethode);
        $this->data['methode'] = $methode->result();
        $this->data['params'] = $params->result();
        $this->data['response'] = $response->result();
        $this->data['main_view'] = 'docs/methode_information';
        $this->load->view($this->layout, $this->data);
    }

    public function how_to_share(){
        $this->data['main_view'] = 'docs/howto_share_data';
        $this->load->view($this->layout, $this->data);
    }
}
