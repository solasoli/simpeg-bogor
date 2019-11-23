<?php defined('BASEPATH') OR exit('No direct script access allowed');

Class Adminopd extends MY_Controller {
    public $data;
    public $layout;

    public function __construct(){
        parent::__construct();
        $this->load->library('pager');
        $this->layout = 'home';
        $this->load->model('Ekinerja_model','ekinerja');
        $this->load->model('Umum_model','umum');
        $this->load->model('Event_model','event');
    }

    public function index(){
        $this->sidebar_header();
        $modul = 'dashboard';
        $this->data['title'] = 'Dashboard';
        $this->data['page'] = $modul;
        $this->data['main_view'] = $modul;
        $this->data['usr'] = 'adminopd';
        $this->data['today'] = $this->call_list_hist_absensi_kehadiran_apel_today();
        $this->data['kinerja_curr'] = $this->ekinerja->get_pencapaian_kinerja_curr($this->session->userdata('id_pegawai_enc'));
        $this->data['aktifitas_curr'] = $this->ekinerja->get_status_aktifitas_current($this->session->userdata('id_pegawai_enc'));
        $this->load->view($this->layout, $this->data);
    }

    public function sidebar_header(){
        $this->data['ses_nama'] = $this->session->userdata('nama');
        $this->data['ses_nip'] = $this->session->userdata('nip');
        $this->data['ses_unit'] = $this->session->userdata('unit_kerja');
        $this->data['ses_lvl_name'] = $this->session->userdata('user_level_name');
    }

    public function input_laporan_kinerja(){
        $this->sidebar_header();
        $modul = 'input_laporan_kinerja';
        $this->data['title'] = 'Laporan Kinerja';
        $this->data['page'] = $modul;
        $this->data['view_type'] = 'hmvc';
        $this->data['main_view'] = Modules::run('publicpegawai/vw_input_laporan_kinerja', 'adminopd');
        $this->load->view($this->layout, $this->data);
    }

    function ubah_aktifitas_kegiatan($id_knj_master, $id_aktifitas){
        $this->sidebar_header();
        $modul = 'input_laporan_kinerja';
        $this->data['title'] = 'Laporan Kinerja';
        $this->data['page'] = $modul;
        $this->data['view_type'] = 'hmvc';
        $this->data['main_view'] = Modules::run('publicpegawai/vw_ubah_laporan_kinerja', 'adminopd', $id_knj_master, $id_aktifitas);
        $this->load->view($this->layout, $this->data);
    }

    function get_info_skp(){
        echo Modules::run('publicpegawai/get_info_skp');
    }

    function open_datadasar_infobox(){
        echo Modules::run('publicpegawai/open_datadasar_infobox');
    }

    function drop_data_riwayat_aktifitas(){
        echo Modules::run('publicpegawai/drop_data_riwayat_aktifitas');
    }

    function detail_laporan_kinerja(){
        $this->sidebar_header();
        $modul = 'detail_laporan_kinerja';
        $this->data['title'] = 'Detail Laporan Kinerja';
        $this->data['page'] = $modul;
        $this->data['view_type'] = 'hmvc';
        $this->data['main_view'] = Modules::run('publicpegawai/vw_detail_laporan_kinerja','adminopd');
        $this->load->view($this->layout, $this->data);
    }

    public function list_riwayat_kinerja(){
        $this->sidebar_header();
        $modul = 'list_riwayat_kinerja';
        $this->data['title'] = 'Daftar Riwayat Aktifitas';
        $this->data['page'] = $modul;
        $this->data['view_type'] = 'hmvc';
        $this->data['main_view'] = Modules::run('publicpegawai/vw_list_riwayat_kinerja','adminopd');
        $this->load->view($this->layout, $this->data);
    }

    public function tipe_lokasi_kerja(){
        $this->sidebar_header();
        $modul = 'tipe_lokasi_kerja';
        $this->data['title'] = 'Tipe dan Lokasi Unit Kerja';
        $this->data['page'] = $modul;
        $this->data['usr'] = 'adminopd';
        $this->data['main_view'] = $modul;
        $this->load->view($this->layout, $this->data);
    }

    public function unit_kerja_sekunder($id_uk_sekunder=null){
        $submitUnitSekunderNew = $this->input->post('submitUnitSekunderNew');
        if(isset($submitUnitSekunderNew) and $submitUnitSekunderNew==1) {
            $input_type = $this->input->post('input_type');
            if($input_type=='ubah'){
                $result = $this->update_unit_kerja_sekunder_baru_lokasi();
            }else{
                $result = $this->insert_unit_kerja_sekunder_baru_lokasi();
            }
            $result = $this->ekinerja->safeDecode($result);
            if($result->code == 200){
                $tx_result = 'true';
                $title_result = '';
            }else{
                $tx_result = 'false';
                $title_result = $result->title.'.';
            }
        }else{
            $tx_result = '';
            $title_result = '';
        }

        if(isset($id_uk_sekunder) and $id_uk_sekunder!=''){
            $this->data['input_type'] = 'ubah';
            $this->data['data_uk_sekunder'] = $this->data_unit_sekunder_by_id($id_uk_sekunder);
            $this->data['id_uk_sekunder'] = $id_uk_sekunder;
        }else{
            $this->data['input_type'] = '';
        }

        $this->sidebar_header();
        $modul = 'unit_kerja_sekunder';
        $this->data['title'] = 'Unit Kerja Sekunder';
        $this->data['page'] = $modul;
        $this->data['usr'] = 'adminopd';
        $this->data['url_reload'] = base_url('adminopd/unit_kerja_sekunder');
        $this->data['main_view'] = $modul;
        $this->data['tx_result'] = $tx_result;
        $this->data['title_result'] = $title_result;
        //$this->data['list_uk_sekunder'] = $this->call_list_unit_kerja_sekunder();
        $this->data['list_opd'] = $this->ekinerja->daftar_opd();
        $this->load->view($this->layout, $this->data);
    }

    public function jadwal_kerja(){
        $this->sidebar_header();
        $modul = 'jadwal_kerja';
        $this->data['title'] = 'Jadwal Kerja Khusus';
        $this->data['page'] = $modul;
        $this->data['main_view'] = $modul;
        $this->open_data_jadwal_by_tab();
        $this->load->view($this->layout, $this->data);
    }

    public function ubah_jadwal_kerja($idjdwl=null){
        $this->sidebar_header();
        $modul = 'jadwal_kerja';
        $this->data['title'] = 'Jadwal Kerja Khusus';
        $this->data['page'] = $modul;
        $this->data['main_view'] = $modul;
        $this->open_data_jadwal_by_tab('ubah', $idjdwl);
        $this->load->view($this->layout, $this->data);
    }

    public function absensi_khusus(){
        $this->sidebar_header();
        $modul = 'absensi_khusus';
        $this->data['title'] = 'Absensi Khusus';
        $this->data['page'] = $modul;
        $this->data['main_view'] = $modul;
        $this->open_data_absensi_khusus_by_tab();
        $this->load->view($this->layout, $this->data);
    }

    function open_data_absensi_khusus_by_tab($input_type=null, $idspmt_jadwal=null){
        $this->data['curr_addr'] = substr($this->ekinerja->curr_addr,0,(strpos($this->ekinerja->curr_addr,'?click')==''?strlen($this->ekinerja->curr_addr):strpos($this->ekinerja->curr_addr,'?click')));
        $this->data['isclicked'] = (isset($_GET['click'])?$_GET['click']:'true');
        if(isset($_GET['tab'])){

        }else{

        }
        $this->data['tab'] = (isset($_GET['tab'])?$_GET['tab']:'');
        return true;
    }

    public function stk_skp(){
        $this->sidebar_header();
        $modul = 'stk_skp';
        $this->data['title'] = 'Riwayat SKP';
        $this->data['page'] = $modul;
        $this->data['view_type'] = 'hmvc';
        $this->data['main_view'] = Modules::run('publicpegawai/vw_stk_skp',$this->session->userdata('id_pegawai_enc'), 'adminopd');
        $this->load->view($this->layout, $this->data);
    }

    public function detail_stk_skp(){
        $this->sidebar_header();
        $modul = 'stk_skp_detail';
        $this->data['title'] = 'Detail SKP';
        $this->data['page'] = $modul;
        $this->data['view_type'] = 'hmvc';
        $this->data['main_view'] = Modules::run('publicpegawai/vw_detail_stk_skp', $_GET['id_skp']);
        $this->load->view($this->layout, $this->data);
    }

    public function kinerja_pegawai(){
        $this->sidebar_header();
        $modul = 'kinerja_pegawai';
        $this->data['title'] = 'Info Kinerja Pegawai';
        $this->data['page'] = $modul;
        $this->data['usr'] = 'adminopd';
        $this->data['main_view'] = $modul;
        $this->load->view($this->layout, $this->data);
    }

    public function download_data(){
        $this->sidebar_header();
        $modul = 'download_data';
        $this->data['title'] = 'Download Data';
        $this->data['page'] = $modul;
        $this->data['usr'] = 'adminopd';
        $this->data['id_skpd_enc'] = $this->session->userdata('id_skpd_enc');
        $this->data['main_view'] = $modul;
        $this->load->view($this->layout, $this->data);
    }

    public function exec_kalkulasi_nilai_kinerja(){
        $id_pegawai = $this->input->post('id_pegawai');
        $id_knj_master = $this->input->post('id_knj_master');
        $bln = $this->input->post('bln');
        $thn = $this->input->post('thn');
        $usr = $this->input->post('usr');
        $link_cur = $this->input->post('link_cur');
        echo Modules::run('publicpegawai/vw_exec_kalkulasi_nilai_kinerja', $id_pegawai, $id_knj_master, $bln, $thn, $usr, $link_cur);
    }
    
    public function exec_laporan_kinerja_selesai(){
        $id_knj_master = $this->input->post('id_knj_master');
        $status_laporan = $this->input->post('status_laporan');
        $usr = $this->input->post('usr');
        $link_cur = $this->input->post('link_cur');
        echo Modules::run('publicpegawai/vw_exec_laporan_kinerja_selesai', $id_knj_master, $this->session->userdata('id_pegawai_enc'), $status_laporan, $usr, $link_cur);
    }

    public function exec_hapus_kegiatan(){
        $id_knj_kegiatan = $this->input->post('id_knj_kegiatan');
        echo Modules::run('publicpegawai/vw_exec_hapus_kegiatan', $id_knj_kegiatan);
    }

    public function exec_hapus_berkas_kegiatan(){
        $id_knj_kegiatan = $this->input->post('id_knj_kegiatan');
        echo Modules::run('publicpegawai/vw_exec_hapus_berkas_kegiatan', $id_knj_kegiatan);
    }

    public function exec_send_msg_whatsapp(){
        $id_knj_kegiatan = $this->input->post('id_knj_kegiatan');
        echo Modules::run('publicpegawai/vw_exec_send_msg_whatsapp', $id_knj_kegiatan);
    }

    public function drop_data_info_kinerja_pegawai(){
        $pages = new Paginator;
        $pagePaging = $_POST['page'];
        $ipp = $_POST['ipp'];

        if($pagePaging==0 or $pagePaging==""){
            $pagePaging = 1;
        }
        if($ipp==0 or $ipp==""){
            $ipp = $pages->default_ipp;
        }

        $_SESSION['ippPager'] = $ipp;
        $_SESSION['pagePager'] = $pagePaging;
        $ddStsLastPeriode = $this->input->post('ddStsLastPeriode');
        $keyword = $this->input->post('keywordCari');
        $jmlData = $this->ekinerja->get_jml_pegawai_info_kinerja($this->session->userdata('id_skpd_enc'), $keyword, $ddStsLastPeriode);
        $jmlData = $jmlData[0]->jumlah;

        if($jmlData>0){
            $pages->items_total = $jmlData;
            $pages->paginate();
            $pgDisplay = $pages->display_pages();
            $curpage = ($pages->current_page==0?1:$pages->current_page);
            $numpage = $pages->num_pages;
        }else{
            $pgDisplay = '';
            $curpage = '';
            $numpage = '';
        }

        if($pagePaging == 1){
            $start_number = 0;
        }else{
            $ipp = explode("&&", $ipp);
            $ipp = $ipp[0];
            $start_number = ($pagePaging * $ipp) - $ipp;
        }
        if($pages->current_page==0){
            $pages->limit = 'LIMIT 0,10';
        }

        $drop_data = $this->ekinerja->daftar_pegawai_info_kinerja($start_number,$this->session->userdata('id_skpd_enc'), $keyword, $ddStsLastPeriode, $pages->limit);
        $this->load->view('load_list_kinerja_pegawai', array(
            'drop_data_list'=> $drop_data,
            'pgDisplay' => $pgDisplay,
            'curpage' => $curpage,
            'numpage' => $numpage,
            'jmlData' => $jmlData,
            'start_number' => $start_number,
            'usr' => 'adminopd'
        ));
    }

    function drop_data_tipe_lokasi_kerja_pegawai(){
        $pages = new Paginator;
        $pagePaging = $_POST['page'];
        $ipp = $_POST['ipp'];

        if($pagePaging==0 or $pagePaging==""){
            $pagePaging = 1;
        }
        if($ipp==0 or $ipp==""){
            $ipp = $pages->default_ipp;
        }
        $_SESSION['ippPager'] = $ipp;
        $_SESSION['pagePager'] = $pagePaging;
        $keyword = $this->input->post('keywordCari');
        $jmlData = $this->ekinerja->get_jml_pegawai_tipe_lokasi($this->session->userdata('id_skpd_enc'), $keyword);
        $jmlData = $jmlData[0]->jumlah;
        if($jmlData>0){
            $pages->items_total = $jmlData;
            $pages->paginate();
            $pgDisplay = $pages->display_pages();
            $curpage = ($pages->current_page==0?1:$pages->current_page);
            $numpage = $pages->num_pages;
        }else{
            $pgDisplay = '';
            $curpage = '';
            $numpage = '';
        }

        if($pagePaging == 1){
            $start_number = 0;
        }else{
            $ipp = explode("&&", $ipp);
            $ipp = $ipp[0];
            $start_number = ($pagePaging * $ipp) - $ipp;
        }
        if($pages->current_page==0){
            $pages->limit = 'LIMIT 0,10';
        }

        $drop_data = $this->ekinerja->daftar_pegawai_tipe_lokasi($start_number,$this->session->userdata('id_skpd_enc'), $keyword, $pages->limit);
        $this->load->view('load_list_tipe_lokasi_pegawai', array(
            'drop_data_list'=> $drop_data,
            'pgDisplay' => $pgDisplay,
            'curpage' => $curpage,
            'numpage' => $numpage,
            'jmlData' => $jmlData,
            'start_number' => $start_number,
            'usr' => 'adminopd'
        ));
    }

    public function input_tipe_lokasi_kerja(){
        $submitUnitSekunderEksisting = $this->input->post('submitUnitSekunderEksisting');
        if(isset($submitUnitSekunderEksisting) and $submitUnitSekunderEksisting==1) {
            $result = $this->insert_unit_kerja_sekunder_pegawai();
            $result = $this->ekinerja->safeDecode($result);
            if($result->code == 200) {
                $tx_result = 'true';
                $title_result = '';
                $upload = $this->upload_file_spmt($result->id, 'fileSpmtExisting', 'clk_lainnya');
                $upload_status = $upload['upload_status'];
                $upload_kode = $upload['upload_kode'];
            }else{
                $tx_result = 'false';
                $title_result = $result->title.'.';
                $upload_status = '';
                $upload_kode = 0;
            }
        }else{
            $tx_result = '';
            $title_result = '';
            $upload_status = '';
            $upload_kode = 0;
        }

        $submitUnitSekunderNew = $this->input->post('submitUnitSekunderNew');
        if(isset($submitUnitSekunderNew) and $submitUnitSekunderNew==1) {
            $result = $this->insert_unit_kerja_sekunder_baru_pegawai();
            $result = $this->ekinerja->safeDecode($result);
            if($result->code == 200) {
                $tx_result = 'true';
                $title_result = '';
                $upload = $this->upload_file_spmt($result->id, 'fileSpmtBaru', 'clk_lainnya');
                $upload_status = $upload['upload_status'];
                $upload_kode = $upload['upload_kode'];
            }else{
                $tx_result = 'false';
                $title_result = $result->title.'.';
                $upload_status = '';
                $upload_kode = 0;
            }
        }else{
            $tx_result = '';
            $title_result = '';
            $upload_status = '';
            $upload_kode = 0;
        }

        $this->sidebar_header();
        $modul = 'input_tipe_lokasi_kerja_pegawai';
        $this->data['title'] = 'Ubah Tipe Lokasi Kerja';
        $this->data['page'] = $modul;
        $this->data['usr'] = 'adminopd';
        $this->data['unit_utama'] = $this->ekinerja->data_ref_unit_kerja_utama_pegawai($_GET['idp']);
        $this->data['unit_sekunder'] = $this->ekinerja->data_ref_unit_kerja_sekunder_pegawai($_GET['idp']);
        $this->data['idp'] = $_GET['idp'];
        $this->data['url_reload'] = base_url('adminopd/input_tipe_lokasi_kerja?idp='.$_GET['idp']);
        $this->data['main_view'] = $modul;
        $this->data['tx_result'] = $tx_result;
        $this->data['title_result'] = $title_result;
        $this->data['upload_kode'] = $upload_kode;
        $this->data['upload_status'] = $upload_status;
        $this->data['view_form'] = 'form_input_tipe_lokasi_kerja';
        $this->load->view($this->layout, $this->data);
    }

    function insert_unit_kerja_sekunder_pegawai(){
        $tmtSpmt = $this->input->post('tmtSpmt');
        $tmtSpmt = explode('/',$tmtSpmt);
        $tmtSpmt = $tmtSpmt[0].'-'.$tmtSpmt[1].'-'.$tmtSpmt[2];
        $data = array(
            'idLokasiSekunder' => $this->input->post('idLokasiSekunder'),
            'idp' => $this->input->post('idp'),
            'tipe_lokasi' => $this->input->post('tipe_lokasi'),
            'txtNoSPMT' => $this->input->post('txtNoSPMT'),
            'tmtSpmt' => $tmtSpmt,
            'inputer' => $this->session->userdata('id_pegawai_enc'));
        $data_ref = $this->ekinerja->CallAPI('POST', $this->ekinerja->url_insert_unit_sekunder_pegawai, $data);
        return $data_ref;
    }

    public function ubah_tipe_lokasi_pegawai(){
        $isMulti = $this->input->post('isMulti');
        $idClk = $this->input->post('idClk');
        $idp_updater = $this->input->post('idp_updater');
        $result = $this->ekinerja->get_exec_ubah_tipe_lokasi_pegawai($isMulti, $idClk, $idp_updater);
        $result = $this->ekinerja->safeDecode($result);
        if($result->code == 200) {
            echo 1;
        }else{
            echo 0;
        }
    }

    public function cari_lokasi_sekunder(){
        $q = $this->input->post('phrase');
        $tipe_unit = $this->input->post('tipe_unit');
        $opd = $this->input->post('opd');
        $result = $this->ekinerja->data_ref_unit_sekunder_by_term($q, $tipe_unit, $opd);
        $result2 = $this->ekinerja->safeDecode($result);
        if($result2->code == 200) {
            echo(json_encode($result2->data));
        }else{
            echo '';
        }
    }

    public function get_info_unit_Sekunder(){
        $idUnitSekunder = $this->input->post('idUnitSekunder');
        $tipeUnit = $this->input->post('tipeUnit');
        $opd = $this->input->post('opd');
        $this->data['unit_sekunder'] = $this->ekinerja->data_ref_unit_sekunder_by_id($idUnitSekunder, $tipeUnit, $opd);
        $this->data['tipeUnit'] = $tipeUnit;
        $this->load->view('load_info_unit_sekunder', $this->data);
    }

    public function get_info_unit_Sekunder2(){
        $idUnitSekunder = $this->input->post('idUnitSekunder');
        $tipeUnit = $this->input->post('tipeUnit');
        $opd = $this->input->post('opd');
        $this->data['unit_sekunder'] = $this->ekinerja->data_ref_unit_sekunder_by_id($idUnitSekunder, $tipeUnit, $opd);
        $this->data['tipeUnit'] = $tipeUnit;
        $this->load->view('load_info_unit_sekunder_2', $this->data);
    }

    public function exec_hapus_unit_sekunder_pegawai(){
        $id_unit_sekunder_pegawai_enc = $this->input->post('id_unit_sekunder_pegawai_enc');
        $result_ori = $this->ekinerja->get_exec_hapus_unit_kerja_sekunder_pegawai($id_unit_sekunder_pegawai_enc);
        $result = $this->ekinerja->safeDecode($result_ori);
        if($result->code == 200) {
            echo 1;
        }else{
            echo 0;
        }
    }

    function upload_file_spmt($id, $inputFileComp, $modul=null){
        if(isset($_FILES["$inputFileComp"])) {
            if ($_FILES["$inputFileComp"]['name'] <> "") {
                if ($_FILES["$inputFileComp"]['type'] == 'binary/octet-stream' or $_FILES["$inputFileComp"]['type'] == "application/pdf" or $_FILES["$inputFileComp"]['type'] == "image/jpeg" or $_FILES["$inputFileComp"]['type'] == "image/jpg" or $_FILES["$inputFileComp"]['type'] == "image/png") {
                    if ($_FILES["$inputFileComp"]['size'] > 20097152) {
                        $upload_status = 'File tidak terupload. Ukuran file terlalu besar';
                        $upload_kode = 1;
                    }else{
                        error_reporting(0);
                        $connection = ssh2_connect('103.14.229.15');
                        ssh2_auth_password($connection, 'rommonz', 'mony3Tmony3T');
                        $uploaddir = '/var/www/html/ekinerja2/berkas/';
                        $uploadfile = $uploaddir . basename($_FILES["$inputFileComp"]['name']);
                        ssh2_scp_send($connection, $_FILES["$inputFileComp"]['tmp_name'], $uploadfile, 0644);
                        error_reporting(1);
                        /*$uploaddir = 'berkas/';
                        $uploadfile = $uploaddir . basename($_FILES["$inputFileComp"]['name']);
                        if (move_uploaded_file($_FILES["$inputFileComp"]['tmp_name'], $uploadfile)) {*/
                            if($_FILES["$inputFileComp"]['type'] == "application/pdf")
                                $ext=".pdf";
                            elseif($_FILES["$inputFileComp"]['type'] == "image/jpeg" or $_FILES["$inputFileComp"]['type'] == "image/jpg")
                                $ext=".jpg";
                            elseif($_FILES["$inputFileComp"]['type'] == "image/png")
                                $ext=".png";
                            if($modul == 'clk_lainnya') {
                                $nf_baru = $this->session->userdata('nip') . '-' . date('dmY') . '-CLKL-' . $id . $ext;
                                $result_upload = $this->update_nama_file_spmt_clkl($uploadfile, $nf_baru, $id, 1);
                            }elseif($modul == 'jadwal_khusus'){
                                $nf_baru = $this->session->userdata('nip') . '-' . date('dmY') . '-JDWL-' . $id . $ext;
                                $result_upload = $this->update_nama_file_spmt_jdwl_spmt($uploadfile, $nf_baru, $id, 1);
                            }elseif($modul == 'item_lainnya'){
                                $nf_baru = $this->session->userdata('nip') . '-' . date('dmY') . '-ITMLAIN-' . $id . $ext;
                                $result_upload = $this->update_nama_file_sk_item_lainnya($uploadfile, $nf_baru, $id, 1);
                            }
                            $result_upload = $this->ekinerja->safeDecode($result_upload);
                            if($result_upload->code == 200) {
                                $upload_status = 'Berkas sukses terupload.'.$result_upload->id;
                                $upload_kode = 2;
                            }else{
                                $upload_status = 'Ada permasalahan ketika mengupdate data nama berkas kegiatan.';
                                $upload_kode = 1;
                            }
                        /*}else{
                            $upload_status = 'File tidak terupload. Ada permasalahan ketika mengupload berkas.';
                            $upload_kode = 1;
                        }*/
                    }
                }else{
                    $upload_status = 'File tidak terupload. Tipe file belum sesuai';
                    $upload_kode = 1;
                }
            }else{
                $upload_status = '';
                $upload_kode = 0;
            }
        }else{
            $upload_status = '';
            $upload_kode = 0;
        }
        return array(
            'upload_status' => $upload_status,
            'upload_kode' => $upload_kode
        );
    }

    function update_nama_file_spmt_clkl($uploadfile, $nf_baru, $idclkl, $status){
        $data_ref = $this->ekinerja->CallAPI('GET', $this->ekinerja->url_update_nama_file_spmt_clkl, array('uploadfile' => $uploadfile, "nf_baru" => $nf_baru, "idclkl" => $idclkl, 'status' => $status));
        return $data_ref;
    }

    function insert_unit_kerja_sekunder_baru_pegawai(){
        $tmtSpmt = $this->input->post('tmtSpmt');
        $tmtSpmt = explode('/',$tmtSpmt);
        $tmtSpmt = $tmtSpmt[0].'-'.$tmtSpmt[1].'-'.$tmtSpmt[2];
        $data = array(
            'coordinat_y_in' => $this->input->post('coordinat_y_in'),
            'coordinat_x_in' => $this->input->post('coordinat_x_in'),
            'coordinat_y_out' => $this->input->post('coordinat_y_out'),
            'coordinat_x_out' => $this->input->post('coordinat_x_out'),
            'ddTipeWilayah' => $this->input->post('ddTipeWilayah'),
            'idIndukLokasiSekunder' => $this->input->post('idIndukLokasiSekunder'),
            'idUnitKerjaUtama' => $this->input->post('idUnitKerjaUtama'),
            'namaLokasi' => $this->input->post('namaLokasi'),
            'txtAlamat' => $this->input->post('txtAlamat'),
            'txtTelepon' => $this->input->post('txtTelepon'),
            'txtEmail' => $this->input->post('txtEmail'),
            'idp' => $this->input->post('idp'),
            'txtNoSPMT' => $this->input->post('txtNoSPMT'),
            'tmtSpmt' => $tmtSpmt,
            'inputer' => $this->session->userdata('id_pegawai_enc'));
        $data_ref = $this->ekinerja->CallAPI('POST', $this->ekinerja->url_insert_unit_sekunder_baru_pegawai, $data);
        return $data_ref;
    }

    function call_list_unit_kerja_sekunder(){
        $data_ref = $this->ekinerja->CallAPI('GET', $this->ekinerja->url_list_unit_kerja_sekunder, array("opd" => $this->session->userdata('id_skpd_enc')));
        $data_ref = $this->ekinerja->safeDecode($data_ref);
        $data_ref = $data_ref->data;
        return $data_ref;
    }

    function insert_unit_kerja_sekunder_baru_lokasi(){
        $data = array(
            'coordinat_y_in' => $this->input->post('coordinat_y_in'),
            'coordinat_x_in' => $this->input->post('coordinat_x_in'),
            'coordinat_y_out' => $this->input->post('coordinat_y_out'),
            'coordinat_x_out' => $this->input->post('coordinat_x_out'),
            'ddTipeWilayah' => $this->input->post('ddTipeWilayah'),
            'idIndukLokasiSekunder' => $this->input->post('idIndukLokasiSekunder'),
            'idUnitKerjaUtama' => $this->input->post('idUnitKerjaUtama'),
            'namaLokasi' => $this->input->post('namaLokasi'),
            'txtAlamat' => $this->input->post('txtAlamat'),
            'txtTelepon' => $this->input->post('txtTelepon'),
            'txtEmail' => $this->input->post('txtEmail'),
            'inputer' => $this->session->userdata('id_pegawai_enc'));
        $data_ref = $this->ekinerja->CallAPI('POST', $this->ekinerja->url_insert_unit_sekunder_baru_lokasi, $data);
        return $data_ref;
    }

    public function exec_hapus_unit_sekunder_lokasi(){
        $id_unit_sekunder_enc = $this->input->post('id_unit_sekunder_enc');
        $result_ori = $this->ekinerja->get_exec_hapus_unit_kerja_sekunder_lokasi($id_unit_sekunder_enc);
        $result = $this->ekinerja->safeDecode($result_ori);
        if($result->code == 200) {
            echo 1;
        }else{
            echo 0;
        }
    }

    public function data_unit_sekunder_by_id($id_uk_sekunder){
        $data_ref = $this->ekinerja->CallAPI('GET', $this->ekinerja->url_ubah_uk_sekunder, array("id_uk_sekunder" => $id_uk_sekunder));
        $data_ref = $this->ekinerja->safeDecode($data_ref);
        $data_ref = $data_ref->data;
        return $data_ref;
    }

    public function update_unit_kerja_sekunder_baru_lokasi(){
        $data = array(
            'coordinat_y_in' => $this->input->post('coordinat_y_in'),
            'coordinat_x_in' => $this->input->post('coordinat_x_in'),
            'coordinat_y_out' => $this->input->post('coordinat_y_out'),
            'coordinat_x_out' => $this->input->post('coordinat_x_out'),
            'ddTipeWilayah' => $this->input->post('ddTipeWilayah'),
            'idIndukLokasiSekunder' => $this->input->post('idIndukLokasiSekunder'),
            'idUnitKerjaUtama' => $this->input->post('idUnitKerjaUtama'),
            'namaLokasi' => $this->input->post('namaLokasi'),
            'txtAlamat' => $this->input->post('txtAlamat'),
            'txtTelepon' => $this->input->post('txtTelepon'),
            'txtEmail' => $this->input->post('txtEmail'),
            'id_uk_sekunder' => $this->input->post('id_uk_sekunder'));
        $data_ref = $this->ekinerja->CallAPI('POST', $this->ekinerja->url_update_unit_kerja_sekunder, $data);
        return $data_ref;
    }

    function call_list_jadwal_khusus(){
        $data_ref = $this->ekinerja->CallAPI('GET', $this->ekinerja->url_list_jadwal_khusus, array("opd" => $this->session->userdata('id_skpd_enc')));
        $data_ref = $this->ekinerja->safeDecode($data_ref);
        $data_ref = $data_ref->data;
        return $data_ref;
    }

    function open_data_jadwal_by_tab($input_type=null, $idspmt_jadwal=null){
        $this->data['curr_addr'] = substr($this->ekinerja->curr_addr,0,(strpos($this->ekinerja->curr_addr,'?click')==''?strlen($this->ekinerja->curr_addr):strpos($this->ekinerja->curr_addr,'?click')));
        $this->data['isclicked'] = (isset($_GET['click'])?$_GET['click']:'true');
        if(isset($_GET['tab'])){
            switch ($_GET['tab']) {
                case 'tbInputJadwal':
                    $submitok = $this->input->post('submitok');
                    if($submitok==1) {
                        $result = $this->insert_jadwal_khusus();
                        $result = $this->ekinerja->safeDecode($result);
                        if($result->code == 200) {
                            $tx_result = 'true';
                            $title_result = '';
                            $upload = $this->upload_file_spmt($result->id2, 'fileSpmt', 'jadwal_khusus');
                            $upload_status = $upload['upload_status'];
                            $upload_kode = $upload['upload_kode'];
                            redirect(base_url('adminopd/ubah_jadwal_kerja/'.$result->id.'?add=true'), 'location');
                        }else{
                            $tx_result = 'false';
                            $title_result = $result->title;
                            $upload_status = '';
                            $upload_kode = 0;
                        }
                    }else{
                        $tx_result = '';
                        $title_result = '';
                        $upload_status = '';
                        $upload_kode = 0;
                    }

                    $this->data['input_type'] = '';
                    $this->data['tx_result'] = $tx_result;
                    $this->data['title_result'] = $title_result;
                    $this->data['upload_kode'] = $upload_kode;
                    $this->data['upload_status'] = $upload_status;
                    $this->data['ref_jenis_jadwal'] = $this->ekinerja->get_jenis_jadwal();
                    $this->data['listBln'] = $this->umum->listBulan();
                    $this->data['listThn'] = $this->umum->listTahun();
                    $this->data['view_form'] = 'jadwal_input';
                    break;
                case 'tbListJadwal':
                    $this->data['listBln'] = $this->umum->listBulan();
                    $this->data['listThn'] = $this->umum->listTahun();
                    $this->data['list_inputer_jadwal'] = $this->ekinerja->get_daftar_inputer_jadwal();
                    $this->data['view_list'] = 'jadwal_list';
                    break;
                case 'tbDetailJadwal':
                    $this->data['ref_jenis_jadwal'] = $this->ekinerja->get_jenis_jadwal();
                    $this->data['listBln'] = $this->umum->listBulan();
                    $this->data['listThn'] = $this->umum->listTahun();
                    $this->data['list_inputer_jadwal'] = $this->ekinerja->get_daftar_inputer_jadwal();
                    $this->data['view_detail'] = 'jadwal_detail';
                    break;
            }
        }else{
            $submitok = $this->input->post('submitok');
            if($submitok==1) {
                $input_type = $this->input->post('input_type');
                if($input_type=='ubah'){
                    $result = $this->update_jadwal_khusus();
                }else{
                    $result = $this->insert_jadwal_khusus();
                }
                $result = $this->ekinerja->safeDecode($result);
                if($result->code == 200) {
                    $tx_result = 'true';
                    $title_result = '';
                    if($input_type=='ubah'){
                        if($this->input->post('chkUbahBerkasSPMT')=='on') {
                            $upload = $this->upload_file_spmt($result->id2, 'fileSpmt', 'jadwal_khusus');
                            $upload_status = $upload['upload_status'];
                            $upload_kode = $upload['upload_kode'];
                        }else{
                            $upload_status = '';
                            $upload_kode = 0;
                        }
                    }else{
                        $upload = $this->upload_file_spmt($result->id2, 'fileSpmt', 'jadwal_khusus');
                        $upload_status = $upload['upload_status'];
                        $upload_kode = $upload['upload_kode'];
                    }
                    redirect(base_url('adminopd/ubah_jadwal_kerja/'.$result->id.'?add=true'), 'location');
                }else{
                    $tx_result = 'false';
                    $title_result = $result->title;
                    $upload_status = '';
                    $upload_kode = 0;
                }
            }else{
                $tx_result = '';
                $title_result = '';
                $upload_status = '';
                $upload_kode = 0;
            }

            if($input_type=='ubah'){
                $this->data['data_jadwal'] = $this->data_jadwal_khusus_by_id($idspmt_jadwal);
                $this->data['idspmt_jadwal_enc'] = $idspmt_jadwal;
                $this->data['ref_jenis_jadwal'] = $this->ekinerja->get_jenis_jadwal();
                $this->data['listJam'] = $this->umum->listJam();
                $this->data['listMenit'] = $this->umum->listMenit();
                $this->data['input_type'] = $input_type;
            }else{
                $this->data['input_type'] = '';
            }

            $this->data['tx_result'] = $tx_result;
            $this->data['title_result'] = $title_result;
            $this->data['upload_kode'] = $upload_kode;
            $this->data['upload_status'] = $upload_status;
            $this->data['listBln'] = $this->umum->listBulan();
            $this->data['listThn'] = $this->umum->listTahun();
            $this->data['view_form'] = 'jadwal_input';
        }
        $this->data['tab'] = (isset($_GET['tab'])?$_GET['tab']:'');
        return true;
    }

    function insert_jadwal_khusus(){
        //$tmtSpmt = $this->input->post('tmtJadwal');
        $tmtSpmt = date('Y/m/d');
        $tmtSpmtOri = explode('/',$tmtSpmt);
        $tmtSpmt = $tmtSpmtOri[0].'-'.$tmtSpmtOri[1].'-'.$tmtSpmtOri[2];
        //$periode_bln = $tmtSpmtOri[1];
        //$periode_thn = $tmtSpmtOri[0];
        $periode_bln = $this->input->post('ddBln');
        $periode_thn = $this->input->post('ddThn');

        $data = array(
            'periode_bln' => $periode_bln,
            'periode_thn' => $periode_thn,
            'txtKeterangan' => $this->input->post('txtKeterangan'),
            'txtNoSPMT' => $this->input->post('txtNoSPMT'),
            'tmtJadwal' => $tmtSpmt,
            'inputer' => $this->session->userdata('id_pegawai_enc'),
            'id_skpd_enc' => $this->session->userdata('id_skpd_enc')
        );

        $data_ref = $this->ekinerja->CallAPI('POST', $this->ekinerja->url_insert_jadwal_khusus, $data);
        return $data_ref;
    }

    function data_jadwal_khusus_by_id($idspmt_jadwal){
        $data_ref = $this->ekinerja->CallAPI('GET', $this->ekinerja->url_ubah_jadwal_khusus, array("idspmt_jadwal" => $idspmt_jadwal));
        $data_ref = $this->ekinerja->safeDecode($data_ref);
        $data_ref = $data_ref->data;
        return $data_ref;
    }

    function update_jadwal_khusus(){
        $data = array(
            'ddBln' => $this->input->post('ddBln'),
            'ddThn' => $this->input->post('ddThn'),
            'txtKeterangan' => $this->input->post('txtKeterangan'),
            'txtNoSPMT' => $this->input->post('txtNoSPMT'),
            'idspmt_jadwal' => $this->input->post('idspmt_jadwal'),
            'idspmt_jadwal_enc' => $this->input->post('idspmt_jadwal_enc')
            );
        $data_ref = $this->ekinerja->CallAPI('POST', $this->ekinerja->url_update_jadwal_khusus, $data);
        return $data_ref;
    }

    function drop_data_list_pegawai($tipe=null){
        $pages = new Paginator;
        $pagePaging = $_POST['page'];
        $ipp = $_POST['ipp'];

        if($pagePaging==0 or $pagePaging==""){
            $pagePaging = 1;
        }
        if($ipp==0 or $ipp==""){
            $ipp = $pages->default_ipp;
        }
        $_SESSION['ippPager'] = $ipp;
        $_SESSION['pagePager'] = $pagePaging;
        $keyword = $this->input->post('keywordCari');
        $id_skpd = $this->input->post('id_skpd');
        $jmlData = $this->ekinerja->get_jml_pegawai($this->session->userdata('id_skpd_enc'), $keyword);
        $jmlData = $jmlData[0]->jumlah;
        if($jmlData>0){
            $pages->items_total = $jmlData;
            $pages->paginate();
            $pgDisplay = $pages->display_pages();
            $curpage = ($pages->current_page==0?1:$pages->current_page);
            $numpage = $pages->num_pages;
        }else{
            $pgDisplay = '';
            $curpage = '';
            $numpage = '';
        }

        if($pagePaging == 1){
            $start_number = 0;
        }else{
            $ipp = explode("&&", $ipp);
            $ipp = $ipp[0];
            $start_number = ($pagePaging * $ipp) - $ipp;
        }
        if($pages->current_page==0){
            $pages->limit = 'LIMIT 0,10';
        }

        $drop_data = $this->ekinerja->get_list_pegawai($start_number, $id_skpd, $keyword, $pages->limit);

        if($tipe=='item_lainnya'){
            $vw_drop = 'load_list_pegawai_2';
        }else{
            $vw_drop = 'load_list_pegawai';
        }

        $this->load->view($vw_drop, array(
            'drop_data_list'=> $drop_data,
            'pgDisplay' => $pgDisplay,
            'curpage' => $curpage,
            'numpage' => $numpage,
            'jmlData' => $jmlData,
            'start_number' => $start_number
        ));
    }

    function update_nama_file_spmt_jdwl_spmt($uploadfile, $nf_baru, $idjdwl_spmt, $status){
        $data_ref = $this->ekinerja->CallAPI('GET', $this->ekinerja->url_update_nama_file_spmt_jdwl_spmt, array('uploadfile' => $uploadfile, "nf_baru" => $nf_baru, "idjdwl_spmt" => $idjdwl_spmt, 'status' => $status));
        return $data_ref;
    }

    function drop_data_list_jadwal_khusus_spmt(){
        $pages = new Paginator;
        $pagePaging = $_POST['page'];
        $ipp = $_POST['ipp'];

        if($pagePaging==0 or $pagePaging==""){
            $pagePaging = 1;
        }
        if($ipp==0 or $ipp==""){
            $ipp = $pages->default_ipp;
        }
        $_SESSION['ippPager'] = $ipp;
        $_SESSION['pagePager'] = $pagePaging;

        $bln = $this->input->post('bln');
        $thn = $this->input->post('thn');
        $keyword = $this->input->post('keyword');
        $chkCekBerkasRil = $this->input->post('chkCekBerkasRil');
        $idp = $this->input->post('idp');
        $jmlData = $this->ekinerja->get_jml_jadwal_khusus_spmt($bln, $thn, $keyword, $idp, $this->session->userdata('id_skpd_enc'));
        $jmlData = $jmlData[0]->jumlah;
        if($jmlData>0){
            $pages->items_total = $jmlData;
            $pages->paginate();
            $pgDisplay = $pages->display_pages();
            $curpage = ($pages->current_page==0?1:$pages->current_page);
            $numpage = $pages->num_pages;
        }else{
            $pgDisplay = '';
            $curpage = '';
            $numpage = '';
        }

        if($pagePaging == 1){
            $start_number = 0;
            $ipp = explode("&&", $ipp);
            $ipp = $ipp[0];
        }else{
            $ipp = explode("&&", $ipp);
            $ipp = $ipp[0];
            $start_number = ($pagePaging * $ipp) - $ipp;
        }

        if($pages->current_page==0){
            $pages->limit = 'LIMIT 0,10';
        }

        $drop_data = $this->ekinerja->daftar_jadwal_khusus_spmt($start_number, $bln, $thn, $keyword, $idp, $this->session->userdata('id_skpd_enc'), $pages->limit);
        $this->load->view('load_list_jadwal_khusus_spmt', array(
            'chkCekBerkasRil' => $chkCekBerkasRil,
            'drop_data_list'=> $drop_data,
            'pgDisplay' => $pgDisplay,
            'curpage' => $curpage,
            'numpage' => $numpage,
            'jmlData' => $jmlData,
            'start_number' => $start_number,
            'curpage' => $curpage,
            'ipp' => $ipp
        ));
    }

    public function exec_hapus_jadwal_khusus(){
        $idjadwal_khusus_enc = $this->input->post('idjadwal_khusus_enc');
        $result_ori = $this->ekinerja->get_exec_hapus_jadwal_khusus($idjadwal_khusus_enc);
        $result = $this->ekinerja->safeDecode($result_ori);
        if($result->code == 200){
            echo 1;
        }else{
            echo 0;
        }
    }

    public function insert_detail_jadwal_khusus(){
        $tglPelaksanaanTipe = $this->input->post('tglPelaksanaanTipe');
        if($tglPelaksanaanTipe=='rentang_hari'){
            $tglMulaiRentang = $this->input->post('tglMulaiRentang');
            $tglMulaiRentang = explode('/',$tglMulaiRentang);
            $tglMulaiRentang = $tglMulaiRentang[2].'-'.$tglMulaiRentang[0].'-'.$tglMulaiRentang[1];
            $tglSelesaiRentang = $this->input->post('tglSelesaiRentang');
            $tglSelesaiRentang = explode('/',$tglSelesaiRentang);
            $tglSelesaiRentang = $tglSelesaiRentang[2].'-'.$tglSelesaiRentang[0].'-'.$tglSelesaiRentang[1];
            $pegawaiPilih = $this->input->post('pegawaiPilih');
            $arrPegawaiPilih = explode(',',$pegawaiPilih);
            foreach ($arrPegawaiPilih as $key => $value) {
                $data[$key] = array(
                    'periode_bln' => $this->input->post('periode_bln'),
                    'periode_thn' => $this->input->post('periode_thn'),
                    'txtSebagai' => $this->input->post('txtSebagai'),
                    'ddJenisJadwal' => $this->input->post('ddJenisJadwal'),
                    'idLokasiSekunder' => $this->input->post('idLokasiSekunder'),
                    'tipe_lokasi' => $this->input->post('tipe_lokasi'),
                    'ddJamMulai' => $this->input->post('ddJamMulai'),
                    'ddMenitMulai' => $this->input->post('ddMenitMulai'),
                    'ddJamSelesai' => $this->input->post('ddJamSelesai'),
                    'ddMenitSelesai' => $this->input->post('ddMenitSelesai'),
                    'idPegawai' => $value, 'tglMulaiRentang' => $tglMulaiRentang, 'tglSelesaiRentang' => $tglSelesaiRentang,
                    'idspmt_jadwal' => $this->input->post('idspmt_jadwal')
                );
            }
        }else{
            $pegawaiPilih = $this->input->post('pegawaiPilih');
            $arrPegawaiPilih = explode(',',$pegawaiPilih);
            $tglpelaksanaanPilih = $this->input->post('tglpelaksanaanPilih');
            $arrtglpelaksanaanPilih = explode(',',$tglpelaksanaanPilih);
            $a = 0;
            foreach ($arrPegawaiPilih as $key => $value) {
                foreach ($arrtglpelaksanaanPilih as $key2 => $value2) {
                    $tglMulaiRentang = $value2;
                    $tglMulaiRentang = explode('/',$tglMulaiRentang);
                    $tglMulaiRentang = $tglMulaiRentang[2].'-'.$tglMulaiRentang[0].'-'.$tglMulaiRentang[1];
                    $tglSelesaiRentang = $value2;
                    $tglSelesaiRentang = explode('/',$tglSelesaiRentang);
                    $tglSelesaiRentang = $tglSelesaiRentang[2].'-'.$tglSelesaiRentang[0].'-'.$tglSelesaiRentang[1];
                    $data[$key2] = array(
                        'periode_bln' => $this->input->post('periode_bln'),
                        'periode_thn' => $this->input->post('periode_thn'),
                        'txtSebagai' => $this->input->post('txtSebagai'),
                        'ddJenisJadwal' => $this->input->post('ddJenisJadwal'),
                        'idLokasiSekunder' => $this->input->post('idLokasiSekunder'),
                        'tipe_lokasi' => $this->input->post('tipe_lokasi'),
                        'ddJamMulai' => $this->input->post('ddJamMulai'),
                        'ddMenitMulai' => $this->input->post('ddMenitMulai'),
                        'ddJamSelesai' => $this->input->post('ddJamSelesai'),
                        'ddMenitSelesai' => $this->input->post('ddMenitSelesai'),
                        'idPegawai' => $value,
                        'tglMulaiRentang' => $tglMulaiRentang,
                        'tglSelesaiRentang' => $tglSelesaiRentang,
                        'idspmt_jadwal' => $this->input->post('idspmt_jadwal')
                    );
                    $data2[$a] = $data[$key2];
                    $a++;
                }
            }
            $data = $data2;
        }
        $data = array('data_jadwal' => $data);
        $data_ref = $this->ekinerja->CallAPI('POST', $this->ekinerja->url_insert_jadwal_khusus_trans, $data);
        $result = $this->ekinerja->safeDecode($data_ref);
        echo($result->code);
    }

    public function drop_data_list_jadwal_trans_kalender(){
        $bln = $this->input->get('bln');
        $thn = $this->input->get('thn');

        // Short-circuit if the client did not give us a date range.
        if (!isset($_GET['start']) || !isset($_GET['end'])) {
            die("Please provide a date range.");
        }

        // Parse the start/end parameters.
        // These are assumed to be ISO8601 strings with no time nor timezone, like "2013-12-29".
        // Since no timezone will be present, they will parsed as UTC.
        $range_start = $this->event->parseDateTime($_GET['start']);
        $range_end = $this->event->parseDateTime($_GET['end']);

        // Parse the timezone parameter if it is present.
        $timezone = null;
        if (isset($_GET['timezone'])) {
            $timezone = new DateTimeZone($_GET['timezone']);
        }

        // Read and parse our events JSON file into an array of event data arrays.
        $input_arrays = $this->ekinerja->daftar_jadwal_tran_kalender_by_opd($bln,$thn,$this->session->userdata('id_skpd_enc'));
        // Accumulate an output array of event data arrays.
        $output_arrays = array();
        foreach ($input_arrays as $array) {
            // Convert the input array into a useful Event object
            $event = $this->event->__construct($array, $timezone);

            // If the event is in-bounds, add it to the output
            if ($this->event->isWithinDayRange($range_start, $range_end)) {
                $output_arrays[] = $this->event->toArray();
            }
        }

        // Send JSON to the client.
        echo json_encode($output_arrays);
    }

    function drop_data_list_jadwal_khusus_detail(){
        $pages = new Paginator;
        $pagePaging = $_POST['page'];
        $ipp = $_POST['ipp'];

        if($pagePaging==0 or $pagePaging==""){
            $pagePaging = 1;
        }
        if($ipp==0 or $ipp==""){
            $ipp = $pages->default_ipp;
        }
        $_SESSION['ippPager'] = $ipp;
        $_SESSION['pagePager'] = $pagePaging;

        $bln = $this->input->post('bln');
        $thn = $this->input->post('thn');
        $idjadwal = $this->input->post('idjadwal');
        $idp = $this->input->post('idp');
        $tglMulaiAcara = $this->input->post('tglMulaiAcara');
        if($tglMulaiAcara!='') {
            $tglMulaiAcara = explode("/", $tglMulaiAcara);
            $tglMulaiAcara = $tglMulaiAcara[2] . '-' . $tglMulaiAcara[0] . '-' . $tglMulaiAcara[1];
        }
        $tglSelesaiAcara = $this->input->post('tglSelesaiAcara');
        if($tglSelesaiAcara!=''){
            $tglSelesaiAcara = explode("/", $tglSelesaiAcara);
            $tglSelesaiAcara = $tglSelesaiAcara[2].'-'.$tglSelesaiAcara[0].'-'.$tglSelesaiAcara[1];
        }
        $keyword = $this->input->post('keyword');
        $chkCekBerkasRil = $this->input->post('chkCekBerkasRil');
        $jmlData = $this->ekinerja->get_jml_jadwal_detail($bln, $thn, $idjadwal, $idp, $tglMulaiAcara, $tglSelesaiAcara, $keyword, $this->session->userdata('id_skpd_enc'));
        $jmlData = $jmlData[0]->jumlah;
        if($jmlData>0){
            $pages->items_total = $jmlData;
            $pages->paginate();
            $pgDisplay = $pages->display_pages();
            $curpage = ($pages->current_page==0?1:$pages->current_page);
            $numpage = $pages->num_pages;
        }else{
            $pgDisplay = '';
            $curpage = '';
            $numpage = '';
        }

        if($pagePaging == 1){
            $start_number = 0;
            $ipp = explode("&&", $ipp);
            $ipp = $ipp[0];
        }else{
            $ipp = explode("&&", $ipp);
            $ipp = $ipp[0];
            $start_number = ($pagePaging * $ipp) - $ipp;
        }

        if($pages->current_page==0){
            $pages->limit = 'LIMIT 0,10';
        }

        $drop_data = $this->ekinerja->daftar_jadwal_detail($start_number, $bln, $thn, $idjadwal, $idp, $tglMulaiAcara, $tglSelesaiAcara, $keyword, $this->session->userdata('id_skpd_enc'), $pages->limit);
        $this->load->view('load_list_jadwal_khusus_detail', array(
            'chkCekBerkasRil' => $chkCekBerkasRil,
            'drop_data_list'=> $drop_data,
            'pgDisplay' => $pgDisplay,
            'curpage' => $curpage,
            'numpage' => $numpage,
            'jmlData' => $jmlData,
            'start_number' => $start_number,
            'curpage' => $curpage,
            'ipp' => $ipp,
            'usr' => 'adminopd'
        ));
    }

    public function exec_hapus_jadwal_trans(){
        $idjadwal_trans_enc = $this->input->post('idjadwal_trans_enc');
        $result_ori = $this->ekinerja->get_exec_hapus_jadwal_trans($idjadwal_trans_enc);
        $result = $this->ekinerja->safeDecode($result_ori);
        if($result->code == 200){
            echo 1;
        }else{
            echo 0;
        }
    }

    public function drop_lokasi_unit_by_idjadwal_trans(){
        $idjadwal_trans_enc = $this->input->post('idjadwal_trans_enc');
        $this->data['data_unit_jadwal'] = $this->ekinerja->daftar_unit_kerja_jadwal_trans($idjadwal_trans_enc);
        $this->load->view('load_lokasi_jadwal_trans', $this->data);
    }

    public function drop_ubah_jadwal_detail_by_id(){
        $idjadwal_trans_enc = $this->input->post('idjadwal_trans_enc');
        $this->data['data_jadwal_trans'] = $this->ekinerja->ubah_jadwal_transaksi_by_id($idjadwal_trans_enc);
        $this->data['data_unit_jadwal'] = $this->ekinerja->daftar_unit_kerja_jadwal_trans($idjadwal_trans_enc);
        $this->data['ref_jenis_jadwal'] = $this->ekinerja->get_jenis_jadwal();
        $this->data['listJam'] = $this->umum->listJam();
        $this->data['listMenit'] = $this->umum->listMenit();
        $this->data['curpage'] = $this->input->post('curpage');
        $this->data['ipp'] = $this->input->post('ipp');
        $this->load->view('load_jadwal_trans_ubah', $this->data);
    }

    public function update_detail_jadwal_khusus(){
        $tgl_mulai = explode('/', $this->input->post('tgl_mulai'));
        $tgl_mulai = $tgl_mulai[2].'-'.$tgl_mulai[0].'-'.$tgl_mulai[1];

        $tgl_selesai = explode('/',$this->input->post('tgl_selesai'));
        $tgl_selesai = $tgl_selesai[2].'-'.$tgl_selesai[0].'-'.$tgl_selesai[1];

        $data = array(
            'id_jenis_jadwal' => $this->input->post('id_jenis_jadwal'),
            'tgl_mulai' => $tgl_mulai,
            'tgl_selesai' => $tgl_selesai,
            'jam_mulai' => $this->input->post('jam_mulai'),
            'menit_mulai' => $this->input->post('menit_mulai'),
            'jam_selesai' => $this->input->post('jam_selesai'),
            'menit_selesai' => $this->input->post('menit_selesai'),
            'peran' => $this->input->post('peran'),
            'idLokasiSekunder' => $this->input->post('idLokasiSekunder'),
            'tipe_lokasi' => $this->input->post('tipe_lokasi'),
            'idjadwal_trans_enc' => $this->input->post('idjadwal_trans_enc'));

        $data_ref = $this->ekinerja->CallAPI('POST', $this->ekinerja->url_update_detail_jadwal_khusus, $data);
        $result = $this->ekinerja->safeDecode($data_ref);
        echo($result->code);
    }

    public function item_kinerja_lainnya(){
        $this->sidebar_header();
        $modul = 'item_kinerja_lainnya';
        $this->data['title'] = 'Unsur Kinerja Lainnya';
        $this->data['page'] = $modul;
        $this->data['main_view'] = $modul;
        $this->open_data_item_lainnya_by_tab();
        $this->load->view($this->layout, $this->data);
    }

    function open_data_item_lainnya_by_tab($input_type=null, $iditem_lainnya=null){
        $this->data['curr_addr'] = substr($this->ekinerja->curr_addr,0,(strpos($this->ekinerja->curr_addr,'?click')==''?strlen($this->ekinerja->curr_addr):strpos($this->ekinerja->curr_addr,'?click')));
        $this->data['isclicked'] = (isset($_GET['click'])?$_GET['click']:'true');
        if(isset($_GET['tab'])) {
            switch ($_GET['tab']) {
                case 'tbInputItemLainnya':
                    $submitok = $this->input->post('submitok');
                    if($submitok==1) {
                        $result = $this->insert_item_lainnya();
                        $result = $this->ekinerja->safeDecode($result);
                        if($result->code == 200) {
                            $tx_result = 'true';
                            $title_result = '';
                            $upload = $this->upload_file_spmt($result->id, 'fileSk', 'item_lainnya');
                            $upload_status = $upload['upload_status'];
                            $upload_kode = $upload['upload_kode'];
                        }else{
                            $tx_result = 'false';
                            $title_result = $result->title;
                            $upload_status = '';
                            $upload_kode = 0;
                        }
                    }else{
                        $tx_result = '';
                        $title_result = '';
                        $upload_status = '';
                        $upload_kode = 0;
                    }
                    $this->data['input_type'] = '';
                    $this->data['tx_result'] = $tx_result;
                    $this->data['title_result'] = $title_result;
                    $this->data['upload_kode'] = $upload_kode;
                    $this->data['upload_status'] = $upload_status;
                    $this->data['ref_jenis_item_lain'] = $this->ekinerja->get_jenis_item_lain();
                    $this->data['view_form'] = 'item_lainnya_input';
                    break;
                case 'tbListItemLainnya':
                    $this->data['ref_jenis_item_lain'] = $this->ekinerja->get_jenis_item_lain();
                    $this->data['ref_status_item_lain'] = $this->ekinerja->get_status_item_lain();
                    $this->data['view_list'] = 'item_lainnya_list';
                    break;
            }
        }else{
            $submitok = $this->input->post('submitok');
            if($submitok==1) {
                $input_type = $this->input->post('input_type');
                if($input_type=='ubah'){
                    $result = $this->update_item_lainnya();
                }else{
                    $result = $this->insert_item_lainnya();
                }
                $result = $this->ekinerja->safeDecode($result);
                if($result->code == 200) {
                    if($input_type=='ubah'){
                        if($this->input->post('chkUbahBerkasSk')=='on') {
                            $tx_result = 'true';
                            $title_result = '';
                            $upload = $this->upload_file_spmt($result->id, 'fileSk', 'item_lainnya');
                            $upload_status = $upload['upload_status'];
                            $upload_kode = $upload['upload_kode'];
                        }else{
                            $tx_result = 'true';
                            $title_result = '';
                            $upload_status = '';
                            $upload_kode = 0;
                        }
                    }else{
                        $tx_result = 'true';
                        $title_result = '';
                        $upload = $this->upload_file_spmt($result->id, 'fileSk', 'item_lainnya');
                        $upload_status = $upload['upload_status'];
                        $upload_kode = $upload['upload_kode'];
                    }
                }else{
                    $tx_result = 'false';
                    $title_result = $result->title;
                    $upload_status = '';
                    $upload_kode = 0;
                }
            }else{
                $tx_result = '';
                $title_result = '';
                $upload_status = '';
                $upload_kode = 0;
            }

            if($input_type=='ubah'){
                $this->data['input_type'] = $input_type;
                $this->data['data_item_lainnya'] = $this->data_item_lainnya_by_id($iditem_lainnya);
                $this->data['iditem_lainnya_enc'] = $iditem_lainnya;
            }else{
                $this->data['input_type'] = '';
            }

            $this->data['tx_result'] = $tx_result;
            $this->data['title_result'] = $title_result;
            $this->data['upload_kode'] = $upload_kode;
            $this->data['upload_status'] = $upload_status;
            $this->data['ref_jenis_item_lain'] = $this->ekinerja->get_jenis_item_lain();
            $this->data['view_form'] = 'item_lainnya_input';
        }
        $this->data['tab'] = (isset($_GET['tab'])?$_GET['tab']:'');
        return true;
    }

    function insert_item_lainnya(){
        $tglMulaiBerlaku = $this->input->post('tglMulaiBerlaku');
        $tglMulaiBerlaku = explode('/',$tglMulaiBerlaku);
        $tglMulaiBerlaku = $tglMulaiBerlaku[2].'-'.$tglMulaiBerlaku[0].'-'.$tglMulaiBerlaku[1];
        $tglSelesaiBerlaku = $this->input->post('tglSelesaiBerlaku');
        $tglSelesaiBerlaku = explode('/',$tglSelesaiBerlaku);
        $tglSelesaiBerlaku = $tglSelesaiBerlaku[2].'-'.$tglSelesaiBerlaku[0].'-'.$tglSelesaiBerlaku[1];
        $rdbPegawai = $this->input->post('rdbPegawai');
        $rdbPegawai = explode('#',$rdbPegawai);
        $id_pegawai = $rdbPegawai[0];
        $id_unit_kerja = $rdbPegawai[1];
        $data = array(
            'ddItemLainnya' => $this->input->post('ddItemLainnya'),
            'tglMulaiBerlaku' => $tglMulaiBerlaku,
            'tglSelesaiBerlaku' => $tglSelesaiBerlaku,
            'txtNoSk' => $this->input->post('txtNoSk'),
            'txtKeterangan' => $this->input->post('txtKeterangan'),
            'id_pegawai' => $id_pegawai,
            'id_unit_kerja' => $id_unit_kerja,
            'inputer' => $this->session->userdata('id_pegawai_enc')
        );

        $data_ref = $this->ekinerja->CallAPI('POST', $this->ekinerja->url_insert_item_lainnya, $data);
        return $data_ref;
    }

    function data_item_lainnya_by_id($iditem_lainnya){
        $data_ref = $this->ekinerja->CallAPI('GET', $this->ekinerja->url_ubah_item_lainnya, array("iditem_lainnya_enc" => $iditem_lainnya));
        $data_ref = $this->ekinerja->safeDecode($data_ref);
        $data_ref = $data_ref->data;
        return $data_ref;
    }

    public function ubah_item_lainnya($id_item_lainnya_enc=null){
        $this->sidebar_header();
        $modul = 'item_kinerja_lainnya';
        $this->data['title'] = 'Item Kinerja Lainnya';
        $this->data['page'] = $modul;
        $this->data['main_view'] = $modul;
        $this->open_data_item_lainnya_by_tab('ubah', $id_item_lainnya_enc);
        $this->load->view($this->layout, $this->data);
    }

    public function update_item_lainnya(){
        $tglMulaiBerlaku = $this->input->post('tglMulaiBerlaku');
        $tglMulaiBerlaku = explode('/',$tglMulaiBerlaku);
        $tglMulaiBerlaku = $tglMulaiBerlaku[2].'-'.$tglMulaiBerlaku[0].'-'.$tglMulaiBerlaku[1];
        $tglSelesaiBerlaku = $this->input->post('tglSelesaiBerlaku');
        $tglSelesaiBerlaku = explode('/',$tglSelesaiBerlaku);
        $tglSelesaiBerlaku = $tglSelesaiBerlaku[2].'-'.$tglSelesaiBerlaku[0].'-'.$tglSelesaiBerlaku[1];
        $rdbPegawai = $this->input->post('rdbPegawai');
        $rdbPegawai = explode('#',$rdbPegawai);
        $id_pegawai = $rdbPegawai[0];
        $id_unit_kerja = $rdbPegawai[1];
        $data = array(
            'ddItemLainnya' => $this->input->post('ddItemLainnya'),
            'tglMulaiBerlaku' => $tglMulaiBerlaku,
            'tglSelesaiBerlaku' => $tglSelesaiBerlaku,
            'txtNoSk' => $this->input->post('txtNoSk'),
            'txtKeterangan' => $this->input->post('txtKeterangan'),
            'id_pegawai' => $id_pegawai,
            'id_unit_kerja' => $id_unit_kerja,
            'id_item_lainnya_enc' => $this->input->post('id_item_lainnya_enc')
        );
        $data_ref = $this->ekinerja->CallAPI('POST', $this->ekinerja->url_update_item_lainnya, $data);
        return $data_ref;
    }

    public function exec_hapus_unit_kerja_jadwal(){
        $id_ukjdwl_enc = $this->input->post('id_ukjdwl_enc');
        $result_ori = $this->ekinerja->get_exec_hapus_unit_kerja_jadwal($id_ukjdwl_enc);
        $result = $this->ekinerja->safeDecode($result_ori);
        if($result->code == 200){
            echo 1;
        }else{
            echo 0;
        }
    }

    public function list_unit_kerja_jadwal(){
        $id_trans_jdwal_enc = $this->input->post('id_trans_jdwal_enc');
        $this->data['data_unit_jadwal'] = $this->ekinerja->daftar_unit_kerja_jadwal_trans($id_trans_jdwal_enc);
        $this->load->view('load_list_unit_kerja_jadwal', $this->data);
    }

    function drop_data_list_item_lainnya(){
        $pages = new Paginator;
        $pagePaging = $_POST['page'];
        $ipp = $_POST['ipp'];

        if($pagePaging==0 or $pagePaging==""){
            $pagePaging = 1;
        }
        if($ipp==0 or $ipp==""){
            $ipp = $pages->default_ipp;
        }
        $_SESSION['ippPager'] = $ipp;
        $_SESSION['pagePager'] = $pagePaging;

        $user_level = $this->input->post('user_level');
        $id_pegawai = $this->input->post('id_pegawai');
        $id_skpd = $this->input->post('id_skpd');

        $ddItemLainnya = $this->input->post('ddItemLainnya');
        $ddStsItemLainnya = $this->input->post('ddStsItemLainnya');
        $keyword = $this->input->post('keyword');
        $jmlData = $this->ekinerja->get_jml_item_lainnya($user_level, $id_pegawai, $id_skpd, $ddItemLainnya, $ddStsItemLainnya, $keyword, $this->session->userdata('id_skpd_enc'));
        $jmlData = $jmlData[0]->jumlah;

        if($jmlData>0){
            $pages->items_total = $jmlData;
            $pages->paginate();
            $pgDisplay = $pages->display_pages();
            $curpage = ($pages->current_page==0?1:$pages->current_page);
            $numpage = $pages->num_pages;
        }else{
            $pgDisplay = '';
            $curpage = '';
            $numpage = '';
        }

        if($pagePaging == 1){
            $start_number = 0;
            $ipp = explode("&&", $ipp);
            $ipp = $ipp[0];
        }else{
            $ipp = explode("&&", $ipp);
            $ipp = $ipp[0];
            $start_number = ($pagePaging * $ipp) - $ipp;
        }

        if($pages->current_page==0){
            $pages->limit = 'LIMIT 0,10';
        }

        $drop_data = $this->ekinerja->daftar_item_lainnya($start_number, $user_level, $id_pegawai, $id_skpd, $ddItemLainnya, $ddStsItemLainnya, $keyword, $pages->limit);
        $this->load->view('load_list_item_lainnya', array(
            'drop_data_list'=> $drop_data,
            'pgDisplay' => $pgDisplay,
            'curpage' => $curpage,
            'numpage' => $numpage,
            'jmlData' => $jmlData,
            'start_number' => $start_number,
            'curpage' => $curpage,
            'ipp' => $ipp,
            'usr' => 'adminopd'
        ));
    }

    function update_nama_file_sk_item_lainnya($uploadfile, $nf_baru, $iditem_lainnya, $status){
        $data_ref = $this->ekinerja->CallAPI('GET', $this->ekinerja->url_update_nama_file_sk_item_lainnya, array('uploadfile' => $uploadfile, "nf_baru" => $nf_baru, "iditem_lainnya" => $iditem_lainnya, 'status' => $status));
        return $data_ref;
    }

    public function exec_hapus_item_lainnya(){
        $id_item_lainnya_enc = $this->input->post('id_item_lainnya_enc');
        $result_ori = $this->ekinerja->get_exec_hapus_unit_lainnya($id_item_lainnya_enc);
        $result = $this->ekinerja->safeDecode($result_ori);
        if($result->code == 200) {
            echo 1;
        }else{
            echo 0;
        }
    }

    public function cetak_laporan_kinerja_pegawai($id_knj_master_enc){
        echo Modules::run('publicpegawai/cetak_laporan_kinerja_pegawai',$id_knj_master_enc);
    }

    public function cetak_laporan_kinerja_pegawai_aktifitas($id_knj_master_enc){
        echo Modules::run('publicpegawai/cetak_laporan_kinerja_pegawai_aktifitas',$id_knj_master_enc);
    }

    public function cetak_jadwal_khusus($id_knj_master_enc){
        $this->load->view('cetak_jadwal_khusus',
            array(
                
            ));
    }

    public function riwayat_ekinerja_pegawai(){
        $this->sidebar_header();
        $modul = 'riwayat_ekinerja_pegawai';
        $this->data['title'] = 'Daftar Riwayat eKinerja Pegawai';
        $this->data['page'] = $modul;
        $this->data['view_type'] = 'hmvc';
        $this->data['main_view'] = Modules::run('publicpegawai/vw_list_riwayat_kinerja_pegawai', $_GET['idp'], 'adminopd');
        $this->load->view($this->layout, $this->data);
    }

    public function detail_laporan_kinerja_staf(){
        $this->sidebar_header();
        $modul = 'rekap_ekinerja_pegawai';
        $this->data['title'] = 'Rekapitulasi Laporan Kinerja Pegawai';
        $this->data['page'] = $modul;
        $this->data['view_type'] = 'hmvc';
        $this->data['main_view'] = Modules::run('publicpegawai/vw_detail_laporan_kinerja_pegawai', $_GET['idknjm'], 'adminopd');
        $this->load->view($this->layout, $this->data);
    }

    public function uraian_rekap_kinerja_staf(){
        $this->sidebar_header();
        $modul = 'detail_laporan_ekinerja_staf';
        $this->data['title'] = 'Detail Laporan Kinerja Pegawai';
        $this->data['page'] = $modul;
        $this->data['view_type'] = 'hmvc';
        $this->data['main_view'] = Modules::run('publicpegawai/vw_uraian_rekap_kinerja_staf', $_GET['idknjm'], 'adminopd');
        $this->load->view($this->layout, $this->data);
    }

    public function peninjauan_staf_detail_kegiatan(){
        $this->sidebar_header();
        $modul = 'aktifitas_kinerja_staf';
        $this->data['title'] = 'Daftar Aktifitas Pegawai';
        $this->data['usr'] = 'adminopd';
        $this->data['page'] = $modul;
        $this->data['view_type'] = 'hmvc';
        $this->data['main_view'] = Modules::run('publicpegawai/vw_peninjauan_staf_detail_kegiatan', $_GET['idknjm'], $_GET['idpatsl'], $_GET['idknjalhtgs'], 'adminopd');
        $this->load->view($this->layout, $this->data);
    }

    public function vw_drop_data_peninjauan_staf_detail(){
        $pages = new Paginator;
        $pagePaging = $_POST['page'];
        $ipp = $_POST['ipp'];
        if($pagePaging==0 or $pagePaging==""){
            $pagePaging = 1;
        }
        if($ipp==0 or $ipp==""){
            $ipp = $pages->default_ipp;
        }
        $_SESSION['ippPager'] = $ipp;
        $_SESSION['pagePager'] = $pagePaging;

        $id_status_knj = $this->input->post('id_status_knj');
        $ddStsProses = $this->input->post('ddStsProses');
        $keyword = $this->input->post('keywordCari');
        $idknjm = $this->input->post('idknjm');
        $idpatsl = $this->input->post('idpatsl');
        $jmlData = $this->ekinerja->get_jumlah_peninjauan_aktifitas_staf($ddStsProses, $keyword, $idknjm, $idpatsl);
        $jmlData = $jmlData[0]->jumlah;
        if($jmlData>0){
            $pages->items_total = $jmlData;
            $pages->paginate();
            $pgDisplay = $pages->display_pages();
            //$itemPerPage = $pages->display_items_per_page();
            $curpage = ($pages->current_page==0?1:$pages->current_page);
            $numpage = $pages->num_pages;
            //$jumppage = $pages->display_jump_menu();
        }else{
            $pgDisplay = '';
            //$itemPerPage = '';
            $curpage = '';
            $numpage = '';
            //$jumppage = '';
        }
        if($pagePaging == 1){
            $start_number = 0;
        }else{
            $ipp = explode("&&", $ipp);
            $ipp = $ipp[0];
            $start_number = ($pagePaging * $ipp) - $ipp;
        }

        if($pages->current_page==0){
            $pages->limit = 'LIMIT 0,10';
        }
        $drop_data = $this->data['aktifitas_staf'] = $this->ekinerja->get_daftar_peninjauan_aktifitas_staf($start_number, $ddStsProses, $keyword, $idknjm, $idpatsl, $pages->limit);
        
        $this->load->view('load_list_kinerja_pegawai_aktifitas', array(
            'id_status_knj' => $id_status_knj,
            'drop_data_list'=> $drop_data,
            'pgDisplay' => $pgDisplay,
            'curpage' => $curpage,
            'numpage' => $numpage,
            'jmlData' => $jmlData
        ));
    }

    public function drop_data_laporan_kinerja_pegawai_opd(){
        $pages = new Paginator;
        $pagePaging = $_POST['page'];
        $ipp = $_POST['ipp'];

        if($pagePaging==0 or $pagePaging==""){
            $pagePaging = 1;
        }
        if($ipp==0 or $ipp==""){
            $ipp = $pages->default_ipp;
        }

        $_SESSION['ippPager'] = $ipp;
        $_SESSION['pagePager'] = $pagePaging;

        $ddStatusLaporan = $this->input->post('ddStatusLaporan');
        $ddJenjab = $this->input->post('ddJenjab');
        $ddEselon = $this->input->post('ddEselon');
        $keyword = $this->input->post('keywordCari');
        $ddBln = $this->input->post('ddBln');
        $ddTahun = $this->input->post('ddTahun');
        $jmlData = $this->ekinerja->get_jml_laporan_kinerja_pegawai_opd($this->session->userdata('id_skpd_enc'), $ddStatusLaporan, $ddJenjab, $ddEselon, $ddBln, $ddTahun, $keyword);
        $jmlData = $jmlData[0]->jumlah;
        if($jmlData>0){
            $pages->items_total = $jmlData;
            $pages->paginate();
            $pgDisplay = $pages->display_pages();
            $curpage = ($pages->current_page==0?1:$pages->current_page);
            $numpage = $pages->num_pages;
        }else{
            $pgDisplay = '';
            $curpage = '';
            $numpage = '';
        }

        if($pagePaging == 1){
            $start_number = 0;
        }else{
            $ipp = explode("&&", $ipp);
            $ipp = $ipp[0];
            $start_number = ($pagePaging * $ipp) - $ipp;
        }

        if($pages->current_page==0){
            $pages->limit = 'LIMIT 0,10';
        }

        $drop_data = $this->ekinerja->get_daftar_laporan_kinerja_pegawai_opd($start_number,$this->session->userdata('id_skpd_enc'), $ddStatusLaporan, $ddJenjab, $ddEselon, $ddBln, $ddTahun, $keyword, $pages->limit);
        $this->load->view('load_list_laporan_kinerja_pegawai_opd', array(
            'drop_data_list'=> $drop_data,
            'pgDisplay' => $pgDisplay,
            'curpage' => $curpage,
            'numpage' => $numpage,
            'jmlData' => $jmlData,
            'start_number' => $start_number
        ));
    }

    public function cetak_laporan_nominatif_opd($ddBln=0, $ddTahun=0, $idPegKepala=0, $ddIsWakilKepala=0, $idPegBendahara=0, $ddIsWakilBendahara=0){
        $drop_data = $this->ekinerja->get_cetak_laporan_kinerja_pegawai_opd($this->session->userdata('id_skpd_enc'), $ddBln, $ddTahun);
        $kepala = $this->ekinerja->get_informasi_pegawai_byidp($idPegKepala);
        $bendahara = $this->ekinerja->get_informasi_pegawai_byidp($idPegBendahara);
        $this->load->view('cetak_laporan_nominatif_opd', array(
            'drop_data' => $drop_data,
            'bln' => $ddBln, 'thn' => $ddTahun,
            'unit_kerja' => $this->session->userdata('unit_kerja'),
            'kepala' => $kepala, 'bendahara' => $bendahara,
            'isWakilKepala' => $ddIsWakilKepala, 'isWakilBendahara' => $ddIsWakilBendahara));
    }

    public function cari_pegawai_by_nama(){
        $q = $this->input->post('phrase');
        $result = $this->ekinerja->data_ref_pegawai_by_term($q);
        $result2 = $this->ekinerja->safeDecode($result);
        if($result2->code == 200) {
            echo(json_encode($result2->data));
        }else{
            echo '';
        }
    }

    public function input_jadwal_pulang_sesuai_jadwal(){
        $id_pegawai = $this->input->post('id_pegawai');
        $wkt = $this->input->post('wkt');
        $ket = $this->input->post('ket');
        $result = $this->ekinerja->get_exec_input_jadwal_pulang_sesuai_jadwal($id_pegawai, $wkt, $ket);
        $result = $this->ekinerja->safeDecode($result);

        if($result->code == 200) {
            echo 200;
        }elseif($result->code == 202) {
            echo 202;
        }else{
            echo 0;
        }
    }

    public function hapus_jadwal_pulang_sesuai_jadwal(){
        $id_pegawai = $this->input->post('id_pegawai');
        $wkt = $this->input->post('wkt');
        $result_ori = $this->ekinerja->get_exec_hapus_jadwal_pulang_sesuai_jadwal($id_pegawai, $wkt);
        $result = $this->ekinerja->safeDecode($result_ori);
        if($result->code == 200){
            echo 1;
        }else{
            echo 0;
        }
    }

    function call_list_hist_absensi_kehadiran_apel_today(){
        $data_ref = $this->ekinerja->CallAPI('GET', $this->ekinerja->url_hist_absen_kehadiran_apel, array("id_knj_master" => "", "id_pegawai" => $this->session->userdata('id_pegawai_enc'), "filter_tgl" => true));
        $data_ref = $this->ekinerja->safeDecode($data_ref);
        $data_ref = $data_ref->data;
        return $data_ref;
    }

    function statistikpegawai(){
        $this->sidebar_header();
        $modul = 'statistik';
        $this->data['title'] = 'Statistik Kinerja';
        $this->data['page'] = $modul;
        $this->data['view_type'] = 'hmvc';
        $this->data['main_view'] = Modules::run('publicpegawai/Statistikpegawai/vw_statistik');
        $this->load->view($this->layout, $this->data);
    }

    function daftar_riwayat_hidup(){
        $this->sidebar_header();
        $modul = 'daftar_riwayat_hidup';
        $this->data['title'] = 'Daftar Riwayat Hidup';
        $this->data['page'] = $modul;
        $this->data['view_type'] = 'hmvc';
        $this->data['main_view'] = Modules::run('publicpegawai/vw_daftar_riwayat_hidup', $this->session->userdata('id_pegawai_enc'));
        $this->load->view($this->layout, $this->data);
    }

    function hukuman_disiplin(){
        $this->sidebar_header();
        $modul = 'hukuman_disiplin';
        $this->data['title'] = 'Riwayat Hukuman Disiplin';
        $this->data['page'] = $modul;
        $this->data['view_type'] = 'hmvc';
        $this->data['main_view'] = Modules::run('publicpegawai/vw_hukuman_disiplin', $this->session->userdata('id_pegawai_enc'));
        $this->load->view($this->layout, $this->data);
    }

    function ubah_password(){
        $this->sidebar_header();
        $modul = 'ubah_password';
        $this->data['title'] = 'Ubah Password';
        $this->data['page'] = $modul;
        $this->data['view_type'] = 'hmvc';
        $this->data['main_view'] = Modules::run('publicpegawai/vw_ubah_password', $this->session->userdata('id_pegawai_enc'));
        $this->load->view($this->layout, $this->data);
    }

    public function drop_data_unit_kerja_sekunder(){
        $pages = new Paginator;
        $pagePaging = $_POST['page'];
        $ipp = $_POST['ipp'];

        if($pagePaging==0 or $pagePaging==""){
            $pagePaging = 1;
        }
        if($ipp==0 or $ipp==""){
            $ipp = $pages->default_ipp;
        }
        $_SESSION['ippPager'] = $ipp;
        $_SESSION['pagePager'] = $pagePaging;

        $opd = $this->input->post('opd');
        $keyword = $this->input->post('keywordCari');

        $jmlData = $this->ekinerja->jml_daftar_unit_kerja_sekunder_by_opd($opd, $keyword);
        $jmlData = $jmlData[0]->jumlah;
        if($jmlData>0){
            $pages->items_total = $jmlData;
            $pages->paginate();
            $pgDisplay = $pages->display_pages();
            //$itemPerPage = $pages->display_items_per_page();
            $curpage = ($pages->current_page==0?1:$pages->current_page);
            $numpage = $pages->num_pages;
            //$jumppage = $pages->display_jump_menu();
        }else{
            $pgDisplay = '';
            //$itemPerPage = '';
            $curpage = '';
            $numpage = '';
            //$jumppage = '';
        }

        if($pagePaging == 1){
            $start_number = 0;
        }else{
            $ipp = explode("&&", $ipp);
            $ipp = $ipp[0];
            $start_number = ($pagePaging * $ipp) - $ipp;
        }

        if($pages->current_page==0){
            $pages->limit = 'LIMIT 0,10';
        }

        $drop_data = $this->ekinerja->list_daftar_unit_kerja_sekunder_by_opd($start_number, $opd, $keyword, $pages->limit);
        $this->load->view('load_list_unit_kerja_sekunder', array(
            'drop_data_list'=> $drop_data,
            'pgDisplay' => $pgDisplay,
            'curpage' => $curpage,
            'numpage' => $numpage,
            'jmlData' => $jmlData,
            'start_number' => $start_number
        ));

    }

}