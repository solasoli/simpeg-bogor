<?php defined('BASEPATH') OR exit('No direct script access allowed');

Class Statistikpegawai extends MY_Controller
{
    public $data;
    public $layout;

    public function __construct(){
        parent::__construct();
        $this->load->library('pager');
        $this->layout = 'home';
        $this->load->model('Umum_model','umum');
        $this->load->model('Publicpegawai_model','public');
    }

    public function index(){
        $this->sidebar_header();
        $modul = 'statistik';
        $this->data['title'] = 'Statistik Kinerja';
        $this->data['page'] = $modul;
        $this->data['main_view'] = $modul;
        $this->open_data_statistik_by_tab();
        $this->load->view($this->layout, $this->data);
    }

    public function sidebar_header(){
        $this->data['ses_nama'] = $this->session->userdata('nama');
        $this->data['ses_nip'] = $this->session->userdata('nip');
        $this->data['ses_unit'] = $this->session->userdata('unit_kerja');
        $this->data['ses_lvl_name'] = $this->session->userdata('user_level_name');
    }

    public function open_data_statistik_by_tab(){
        $curr_addr = substr($this->public->curr_addr,0,(strpos($this->public->curr_addr,'&click')==''?strlen($this->public->curr_addr):strpos($this->public->curr_addr,'&click')));
        $this->data['curr_addr'] = $curr_addr;
        $this->data['isclicked'] = (isset($_GET['click'])?$_GET['click']:'true');
        if(isset($_GET['tab'])) {
            switch ($_GET['tab']) {
                case "tbStatBulanan":
                    $this->data['listThn'] = $this->umum->listTahun();
                    $this->data['view_stat_bulanan'] = 'statistik_bulanan';
                    $this->data['cur_link_addr'] = $curr_addr;
                    break;
                case "tbStatHarian":
                    $this->data['listBln'] = $this->umum->listBulan();
                    $this->data['listThn'] = $this->umum->listTahun();
                    $this->data['view_stat_harian'] = 'statistik_harian';
                    $this->data['cur_link_addr'] = $curr_addr;
                    break;
            }
        }else{
            $this->data['listThn'] = $this->umum->listTahun();
            $this->data['cur_link_addr'] = $curr_addr;
            $this->data['view_stat_bulanan'] = 'statistik_bulanan';
        }
        $this->data['tab'] = (isset($_GET['tab'])?$_GET['tab']:'');
        return true;
    }

    public function exec_stat_kinerja_bulanan(){
        $id_pegawai = $this->session->userdata('id_pegawai_enc');
        $thn = $this->input->post('thn');
        $this->data['data_stat_1'] = $this->public->get_data_stat_kinerja_bulanan($id_pegawai, $thn);
        $this->load->view('load_stat_kinerja_bulanan', $this->data);
    }

    public function vw_statistik(){
        $this->open_data_statistik_by_tab();
        $this->load->view('statistik', $this->data);

    }

    public function cari_pegawai_by_nama_by_opd(){
        $q = $this->input->post('phrase');
        $result = $this->public->data_ref_pegawai_by_term_by_opd($q, $this->session->userdata('id_skpd'));
        $result2 = $this->public->safeDecode($result);
        if($result2->code == 200) {
            echo(json_encode($result2->data));
        }else{
            echo '';
        }
    }

    public function drop_data_statistik_bulanan(){
        $idPegawai = $this->input->post('idPegawai');
        $ddTahun = $this->input->post('ddTahun');
        $this->load->view('load_statistik_bulanan', array(
            'thn'=> $ddTahun,
            'data_stat_1'=> $this->public->get_data_stat_kinerja_bulanan($idPegawai, $ddTahun),
            'data_stat_2' => $this->public->get_data_stat_absensi_bulanan($idPegawai, $ddTahun),
            'data_stat_3' => $this->public->get_data_stat_persen_kinerja_absensi_bulanan($idPegawai, $ddTahun)
        ));
    }

    public function drop_data_statistik_harian(){
        $idPegawai = $this->input->post('idPegawai');
        $ddBln = $this->input->post('ddBln');
        $ddTahun = $this->input->post('ddTahun');
        $statHarian = $this->public->get_data_statistik_harian_kinerja_absen($idPegawai, $ddBln, $ddTahun);
        $this->load->view('load_statistik_harian', array(
            'bln'=> $this->umum->monthName($ddBln),
            'thn'=> $ddTahun,
            'data_stat_4'=> $this->public->safeDecode($statHarian[0]['data'])->data,
            'data_stat_5' => $this->public->safeDecode($statHarian[1]['data'])->data
        ));
    }

}