<?php defined('BASEPATH') OR exit('No direct script access allowed');

Class Adminbpkad extends MX_Controller
{
    public $data;
    public $layout;

    public function __construct(){
        parent::__construct();
        $this->layout = 'home';
    }

    public function index(){
        $this->sidebar_header();
        $modul = 'dashboard';
        $this->data['page'] = $modul;
        $this->data['main_view'] = $modul;
        $this->load->view($this->layout, $this->data);
    }

    public function sidebar_header(){
        $this->data['ses_nama'] = $this->session->userdata('nama');
        $this->data['ses_nip'] = $this->session->userdata('nip');
        $this->data['ses_unit'] = $this->session->userdata('unit_kerja');
        $this->data['ses_lvl_name'] = $this->session->userdata('user_level_name');
    }

}