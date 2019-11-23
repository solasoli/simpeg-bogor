<?php defined('BASEPATH') OR exit('No direct script access allowed');

Class Publicpegawai extends MY_Controller
{
    public $data;
    public $layout;

    public function __construct(){
        date_default_timezone_set('Asia/Jakarta');
        parent::__construct();
        $this->load->library('pager');
        $this->layout = 'home';
        $this->load->model('Ekinerja_model','ekinerja');
        $this->load->model('Umum_model','umum');
        $this->load->model('Publicpegawai_model','public');
    }

    public function index(){
        $this->sidebar_header();
        $modul = 'dashboard';
        $this->data['title'] = 'Dashboard';
        $this->data['page'] = $modul;
        $this->data['main_view'] = $modul;
        $this->data['usr'] = 'publicpegawai';
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
        $this->data['main_view'] = $modul;
        $this->open_data_input_laporan_by_tab('publicpegawai');
        $this->load->view($this->layout, $this->data);
    }

    function vw_input_laporan_kinerja($usr){
        $this->open_data_input_laporan_by_tab($usr);
        $this->load->view('input_laporan_kinerja', $this->data);
    }

    function vw_ubah_laporan_kinerja($usr, $id_knj_master, $id_aktifitas){
        $this->open_data_input_laporan_by_tab($usr, 'ubah', $id_knj_master, $id_aktifitas);
        $this->load->view('input_laporan_kinerja', $this->data);
    }

    function data_ref_data_dasar(){
        $data_ref = $this->ekinerja->CallAPI('GET', $this->ekinerja->url_data_dasar, array("id_pegawai" => $this->session->userdata('id_pegawai')));
        $data_ref = $this->ekinerja->safeDecode($data_ref);
        $data_ref = $data_ref->data;
        return $data_ref;
    }

    function data_ref_data_dasar_by_idknjm($idknjm){
        $data_ref = $this->ekinerja->CallAPI('GET', $this->ekinerja->url_detail_laporan_kinerja, array("id_knj_master" => $idknjm));
        $data_ref = $this->ekinerja->safeDecode($data_ref);
        $data_ref = $data_ref->data;
        return $data_ref;
    }

    function data_ref_list_kinerja_master(){
        $data_ref = $this->ekinerja->CallAPI('GET', $this->ekinerja->url_list_kinerja_master, array("id_pegawai" => $this->session->userdata('id_pegawai_enc')));
        $data_ref = $this->ekinerja->safeDecode($data_ref);
        $data_ref = $data_ref->data;
        return $data_ref;
    }

    function insert_data_kinerja_master(){
        $tglKegiatan = $this->input->post('tglKegiatan');
        $tglKegiatan = explode('/',$tglKegiatan);
        $tglKegiatan2 = $tglKegiatan[0].'-'.$tglKegiatan[1].'-'.$tglKegiatan[2];
        $jam = $this->input->post('ddJam');
        $menit = $this->input->post('ddMenit');
        if($this->input->post('tglKegiatanOri') != ''){
            $tglKegiatanOri = $this->input->post('tglKegiatanOri');
            $tglKegiatanOri = explode('/',$tglKegiatanOri);
            $tglKegiatanOri = $tglKegiatanOri[0].'-'.$tglKegiatanOri[1].'-'.$tglKegiatanOri[2];
        }else{
            $tglKegiatanOri = '';
        }

        $rdbHistAlihTugas = explode('#',$this->input->post('rdbHistAlihTugas'));
        $rdbHistAlihTugas = $rdbHistAlihTugas[0];

        $data = array(
            'ddBln' => $tglKegiatan[1],
            'ddThn' => $tglKegiatan[0],
            'id_pegawai' => $this->input->post('id_pegawai'),
            'last_jenjab' => $this->input->post('last_jenjab'),
            'last_kode_jabatan' => $this->input->post('last_kode_jabatan'),
            'last_jabatan' => $this->input->post('last_jabatan'),
            'last_eselon' => $this->input->post('last_eselon'),
            'last_gol' => $this->input->post('last_gol'),
            'last_id_unit_kerja' => $this->input->post('last_id_unit_kerja'),
            'last_unit_kerja' => $this->input->post('last_unit_kerja'),
            'last_atsl_idp' => $this->input->post('last_atsl_idp'),
            'last_atsl_nip' => $this->input->post('last_atsl_nip'),
            'last_atsl_nama' => addslashes($this->input->post('last_atsl_nama')),
            'last_atsl_gol' => $this->input->post('last_atsl_gol'),
            'last_atsl_jabatan' => $this->input->post('last_atsl_jabatan'),
            'last_atsl_id_j' => ($this->input->post('last_atsl_id_j')==''?'0':$this->input->post('last_atsl_id_j')),
            'last_pjbt_idp' => $this->input->post('last_pjbt_idp'),
            'last_pjbt_nip' => $this->input->post('last_pjbt_nip'),
            'last_pjbt_nama' => addslashes($this->input->post('last_pjbt_nama')),
            'last_pjbt_gol' => $this->input->post('last_pjbt_gol'),
            'last_pjbt_jabatan' => $this->input->post('last_pjbt_jabatan'),
            'last_pjbt_id_j' => $this->input->post('last_pjbt_id_j'),
            'txtIdSkp' => $this->input->post('txtIdSkp'),
            'txtTmtSkp' => $this->input->post('txtTmtSkp'),
            'ddKatKegiatan' => $this->input->post('ddKatKegiatan'),
            'tglKegiatan' => $tglKegiatan2,
            'jamKegiatan' => $jam.':'.$menit.':00',
            'txtRincian' => addslashes($this->input->post('txtRincian')),
            'txtKet' => addslashes($this->input->post('txtKet')),
            'txtKuantitas' => $this->input->post('txtKuantitas'),
            'ddSatuan' => $this->input->post('ddSatuan'),
            'txtDurasi' => $this->input->post('txtDurasi'),
            'rdbHistAlihTugas' => $rdbHistAlihTugas,
            'tglKegiatanOri' => $tglKegiatanOri,
            'last_status_pegawai' => $this->input->post('last_status_pegawai'),

            'last_atsl_idp_plh' => $this->input->post('last_atsl_idp_plh'),
            'last_atsl_nip_plh' => $this->input->post('last_atsl_nip_plh'),
            'last_atsl_nama_plh' => addslashes($this->input->post('last_atsl_nama_plh')),
            'last_atsl_gol_plh' => $this->input->post('last_atsl_gol_plh'),
            'last_atsl_jabatan_plh' => $this->input->post('last_atsl_jabatan_plh'),
            'last_atsl_id_j_plh' => $this->input->post('last_atsl_id_j_plh'),
            'last_pjbt_idp_plh' => $this->input->post('last_pjbt_idp_plh'),
            'last_pjbt_nip_plh' => $this->input->post('last_pjbt_nip_plh'),
            'last_pjbt_nama_plh' => addslashes($this->input->post('last_pjbt_nama_plh')),
            'last_pjbt_gol_plh' => $this->input->post('last_pjbt_gol_plh'),
            'last_pjbt_jabatan_plh' => $this->input->post('last_pjbt_jabatan_plh'),
            'last_pjbt_id_j_plh' => $this->input->post('last_pjbt_id_j_plh')
        );

        $data_ref = $this->ekinerja->CallAPI('POST', $this->ekinerja->url_insert_aktifitas, $data);
        return $data_ref;
    }

    function update_nama_file_kegiatan($uploadfile, $nf_baru, $idknj, $status){
        $data_ref = $this->ekinerja->CallAPI('GET', $this->ekinerja->url_update_nama_file_kegiatan, array('uploadfile' => $uploadfile, "nf_baru" => $nf_baru, "idknjkeg" => $idknj, 'status' => $status));
        return $data_ref;
    }

    function ubah_aktifitas_kegiatan($id_knj_master, $id_aktifitas){
        $this->sidebar_header();
        $modul = 'input_laporan_kinerja';
        $this->data['title'] = 'Laporan Kinerja';
        $this->data['page'] = $modul;
        $this->data['main_view'] = $modul;
        $this->open_data_input_laporan_by_tab('publicpegawai', 'ubah', $id_knj_master, $id_aktifitas);
        $this->load->view($this->layout, $this->data);
    }

    public function update_data_aktifitas_kegiatan(){
        $id_knj_kegiatan = $this->input->post('id_knj_kegiatan');
        $tglKegiatan = $this->input->post('tglKegiatan');
        $tglKegiatan = explode('/',$tglKegiatan);
        $tglKegiatan2 = $tglKegiatan[0].'-'.$tglKegiatan[1].'-'.$tglKegiatan[2];
        $jam = $this->input->post('ddJam');
        $menit = $this->input->post('ddMenit');
        $tglKegiatanOri = $this->input->post('tglKegiatanOri');
        $tglKegiatanOri = explode('/',$tglKegiatanOri);
        $tglKegiatanOri = $tglKegiatanOri[0].'-'.$tglKegiatanOri[1].'-'.$tglKegiatanOri[2];
        $chkUbahWktKegiatan = ($this->input->post('chkUbahWktKegiatan')=='on'?1:0);

        $rdbHistAlihTugas = explode('#',$this->input->post('rdbHistAlihTugas'));
        $rdbHistAlihTugas = $rdbHistAlihTugas[0];

        $data = array(
            'ddBln' => $tglKegiatan[1],
            'ddThn' => $tglKegiatan[0],
            'id_pegawai' => $this->input->post('id_pegawai'),
            'last_atsl_idp' => $this->input->post('last_atsl_idp'),
            'last_pjbt_idp' => $this->input->post('last_pjbt_idp'),
            'ddKatKegiatan' => $this->input->post('ddKatKegiatan'),
            'tglKegiatan' => $tglKegiatan2,
            'jamKegiatan' => $jam.':'.$menit.':00',
            'txtRincian' => $this->input->post('txtRincian'),
            'txtKet' => $this->input->post('txtKet'),
            'txtKuantitas' => $this->input->post('txtKuantitas'),
            'ddSatuan' => $this->input->post('ddSatuan'),
            'txtDurasi' => $this->input->post('txtDurasi'),
            'rdbHistAlihTugas' => $rdbHistAlihTugas,
            'id_knj_kegiatan' => $id_knj_kegiatan,
            'tglKegiatanOri' => $tglKegiatanOri,
            'chkUbahWktKegiatan' => $chkUbahWktKegiatan
        );
        $data_ref = $this->ekinerja->CallAPI('POST', $this->ekinerja->url_update_aktifitas, $data);
        return $data_ref;
    }

    function data_dasar_by_kinerja_master($id_knj_master){
        $data_ref = $this->ekinerja->CallAPI('GET', $this->ekinerja->url_detail_laporan_kinerja, array("id_knj_master" => $id_knj_master));
        $data_ref = $this->ekinerja->safeDecode($data_ref);
        $data_ref = $data_ref->data;
        return $data_ref;
    }

    function data_aktifitas_by_id($id_aktifitas){
        $data_ref = $this->ekinerja->CallAPI('GET', $this->ekinerja->url_ubah_aktifitas, array("id_knj_keg" => $id_aktifitas));
        $data_ref = $this->ekinerja->safeDecode($data_ref);
        $data_ref = $data_ref->data;
        return $data_ref;
    }

    function detail_laporan_kinerja(){
        $this->sidebar_header();
        $modul = 'detail_laporan_kinerja';
        $this->data['title'] = 'Detail Laporan Kinerja';
        $this->data['page'] = $modul;
        $this->data['main_view'] = $modul;
        $this->open_data_detail_laporan_by_tab('publicpegawai');
        $this->load->view($this->layout, $this->data);
    }

    function vw_detail_laporan_kinerja($usr){
        $this->open_data_detail_laporan_by_tab($usr);
        $this->load->view('detail_laporan_kinerja', $this->data);
    }

    function call_detail_laporan_kinerja($idknjm=null){
        if($idknjm==null){
            $idknjm = $_GET['idknjm'];
        }
        $data_ref = $this->ekinerja->CallAPI('GET', $this->ekinerja->url_detail_laporan_kinerja, array("id_knj_master" => $idknjm));
        $data_ref = $this->ekinerja->safeDecode($data_ref);
        $data_ref = $data_ref->data;
        return $data_ref;
    }

    function call_stk_skp($jenjab,$eselon,$kode_jabatan){
        $data_ref = $this->ekinerja->CallAPI('GET', $this->ekinerja->url_stk_skp_by_kode_jabatan, array("jenjab" => $jenjab, "eselon" => $eselon, "kode_jabatan" => $kode_jabatan));
        $data_ref = $this->ekinerja->safeDecode($data_ref);
        $data_ref = $data_ref->data;
        return $data_ref;
    }

    function call_skp(){
        $data_ref = $this->ekinerja->CallAPI('GET', $this->ekinerja->url_skp_pegawai_last, array("id_pegawai" => $this->session->userdata('id_pegawai_enc')));
        $data_ref = $this->ekinerja->safeDecode($data_ref);
        $data_ref = $data_ref->data;
        return $data_ref;
    }

    function call_skp_by_id($id_skp){
        $data_ref = $this->ekinerja->CallAPI('GET', $this->ekinerja->url_skp_by_id, array("id_skp" => $id_skp));
        $data_ref = $this->ekinerja->safeDecode($data_ref);
        $data_ref = $data_ref->data;
        return $data_ref;
    }

    function call_info_last_skp(){
        $data_ref = $this->ekinerja->CallAPI('GET', $this->ekinerja->url_info_last_skp, array("id_pegawai" => $this->session->userdata('id_pegawai_enc')));
        $data_ref = $this->ekinerja->safeDecode($data_ref);
        $data_ref = $data_ref->data;
        return $data_ref;
    }

    function call_info_last_skp_by_id($id_skp){
        $data_ref = $this->ekinerja->CallAPI('GET', $this->ekinerja->url_info_last_skp_by_id, array("id_skp" => $id_skp));
        $data_ref = $this->ekinerja->safeDecode($data_ref);
        $data_ref = $data_ref->data;
        return $data_ref;
    }

    function call_list_aktifitas_by_id(){
        $data_ref = $this->ekinerja->CallAPI('GET', $this->ekinerja->url_list_aktifitas_by_id, array("id_knj_master" => $_GET['idknjm']));
        $data_ref = $this->ekinerja->safeDecode($data_ref);
        $data_ref = $data_ref->data;
        return $data_ref;
    }

    function call_list_aktifitas_by_idpegawai(){
        $idknjm = $this->ekinerja->CallAPI('GET', $this->ekinerja->url_get_idknj_master_by_idp, array("id_pegawai" => $this->session->userdata('id_pegawai_enc')));
        $idknjm = $this->ekinerja->safeDecode($idknjm);
        $idknjm = $idknjm->data;
        $data_ref = $this->ekinerja->CallAPI('GET', $this->ekinerja->url_list_aktifitas_by_id, array("id_knj_master" => $idknjm));
        $data_ref = $this->ekinerja->safeDecode($data_ref);
        $data_ref = $data_ref->data;
        return $data_ref;
    }

    function call_list_hist_absensi_kehadiran_apel(){
        $data_ref = $this->ekinerja->CallAPI('GET', $this->ekinerja->url_hist_absen_kehadiran_apel, array("id_knj_master" => $_GET['idknjm'], "id_pegawai" => $this->session->userdata('id_pegawai_enc'), "filter_tgl" => false));
        $data_ref = $this->ekinerja->safeDecode($data_ref);
        $data_ref = $data_ref->data;
        return $data_ref;
    }

    function call_list_hist_absensi_kehadiran_apel_today(){
        $data_ref = $this->ekinerja->CallAPI('GET', $this->ekinerja->url_hist_absen_kehadiran_apel, array("id_knj_master" => "", "id_pegawai" => $this->session->userdata('id_pegawai_enc'), "filter_tgl" => true));
        $data_ref = $this->ekinerja->safeDecode($data_ref);
        $data_ref = $data_ref->data;
        return $data_ref;
    }

    function open_data_detail_laporan_by_tab($usr){
        $this->data['usr'] = $usr;
        $curr_addr = substr($this->ekinerja->curr_addr,0,(strpos($this->ekinerja->curr_addr,'&click')==''?strlen($this->ekinerja->curr_addr):strpos($this->ekinerja->curr_addr,'&click')));
        $this->data['curr_addr'] = $curr_addr;
        $this->data['isclicked'] = (isset($_GET['click'])?$_GET['click']:'true');
        if(isset($_GET['tab'])){
            switch ($_GET['tab']) {
                case "tbRekap":
                    $this->data['usr'] = $usr;
                    $this->data['knjmaster'] = $this->call_detail_laporan_kinerja();
                    $this->data['view_list_detail'] = 'list_detail_laporan_kinerja';
                    $this->data['cur_link_addr'] = $curr_addr;
                    if(isset($_GET['detail'])){
                        if($_GET['detail']=='true'){
                            $this->data['knjmaster'] = $this->call_detail_laporan_kinerja();
                            $this->data['nilai_hist_alih_tugas'] = $this->ekinerja->data_ref_list_hist_alih_tugas_detail_calc_by_idknj($_GET['idknjm']);
                            $this->data['idknjm'] = $_GET['idknjm'];
                            $this->data['view_detail_nilai'] = 'detail_nilai_kinerja';
                        }
                    }
                    break;
                case "tbAktivitas":
                    //$this->data['aktifitas'] = $this->call_list_aktifitas_by_id();
                    $this->data['api_hapus_berkas'] = $this->ekinerja->url_hapus_berkas_aktifitas;
                    $this->data['url_get_info_kegiatan_send_whatsapp'] = $this->ekinerja->url_get_info_kegiatan_send_whatsapp;
                    $this->data['url_reload'] = base_url($usr.'/detail_laporan_kinerja/?idknjm='.$_GET['idknjm'].'&click=true&tab=tbAktivitas');
                    $this->data['listTgl'] = $this->umum->listTanggal();
                    $this->data['usrsrc'] = 'publicpegawai';
                    $this->data['view_list_aktifitas'] = 'list_aktifitas_kegiatan';
                    break;
                case "tbAbsHadir":
                    $this->data['absensi'] = $this->call_list_hist_absensi_kehadiran_apel();
                    $this->data['view_list_absensi'] = 'list_absensi_kehadiran_apel';
                    break;
                case "tbItemLain":

                    break;
            }
        }else{
            $this->data['cur_link_addr'] = $curr_addr;
            $this->data['usr'] = $usr;
            $this->data['knjmaster'] = $this->call_detail_laporan_kinerja();
            $this->data['view_list_detail'] = 'list_detail_laporan_kinerja';
        }
        $this->data['tab'] = (isset($_GET['tab'])?$_GET['tab']:'');
        return true;
    }

    function open_data_input_laporan_by_tab($usr, $input_type=null, $id_knj_master=null, $id_aktifitas=null){
        $this->data['usr'] = $usr;
        $this->data['curr_addr'] = substr($this->ekinerja->curr_addr,0,(strpos($this->ekinerja->curr_addr,'?click')==''?strlen($this->ekinerja->curr_addr):strpos($this->ekinerja->curr_addr,'?click')));
        $this->data['isclicked'] = (isset($_GET['click'])?$_GET['click']:'true');
        if(isset($_GET['tab'])){
            switch ($_GET['tab']) {
                case "tbFormAktifitas":
                    $submitok = $this->input->post('submitok');
                    if($submitok==1) {
                        $result = $this->insert_data_kinerja_master();
                        $result = $this->ekinerja->safeDecode($result);
                        if($result->code == 200) {
                            $tx_result = 'true';
                            $title_result = '';
                            $rdbHistAlihTugas = explode('#',$this->input->post('rdbHistAlihTugas'));
                            $rdbHistAlihTugas = $rdbHistAlihTugas[0];
                            $upload = $this->upload_file_eviden_kegiatan($result->id);
                            $upload_status = $upload['upload_status'];
                            $upload_kode = $upload['upload_kode'];
                        }else{
                            $tx_result = 'false';
                            $title_result = $result->title;
                            $upload_status = '';
                            $upload_kode = 0;
                            $rdbHistAlihTugas = '';
                        }
                    }else{
                        $tx_result = '';
                        $title_result = '';
                        $upload_status = '';
                        $upload_kode = 0;
                        $rdbHistAlihTugas = '';
                    }

                    // Re-Input data kegiatan to form
                    if($tx_result=='false' or $tx_result==''){
                        $this->data['kegiatan_kategori_id'] = $this->input->post('ddKatKegiatan');
                        $this->data['kegiatan_rincian'] = $this->input->post('txtRincian');
                        $this->data['tgl_kegiatan'] = $this->input->post('tglKegiatan');
                        $this->data['jam'] = $this->input->post('ddJam');
                        $this->data['menit'] = $this->input->post('ddMenit');
                        $this->data['durasi_menit'] = $this->input->post('txtDurasi');
                        $this->data['kegiatan_keterangan'] = $this->input->post('txtKet');
                        $this->data['kuantitas'] = $this->input->post('txtKuantitas');
                        $this->data['idknj_satuan_output'] = $this->input->post('ddSatuan');
                    }

                    $this->data['input_type'] = '';
                    if(isset($_GET['idknjm'])){
                        $this->data['data_dasar'] = $this->data_ref_data_dasar_by_idknjm($_GET['idknjm']);
                        $this->data['input_lampau'] = true;
                    }else{
                        $this->data['data_dasar'] = $this->data_ref_data_dasar();
                        $this->data['input_lampau'] = false;
                    }
                    $this->data['listJam'] = $this->umum->listJam();
                    $this->data['listMenit'] = $this->umum->listMenit();
                    $this->data['lastTimeKegiatan'] = $this->ekinerja->get_wkt_selesai_kegiatan_terakhir($this->session->userdata('id_pegawai_enc'), date("m"), date("Y"));
                    $this->data['tx_result'] = $tx_result;
                    $this->data['title_result'] = $title_result;
                    $this->data['rdbHistAlihTugas'] = $rdbHistAlihTugas;
                    $this->data['upload_kode'] = $upload_kode;
                    $this->data['upload_status'] = $upload_status;
                    $this->data['view_form'] = 'form_aktifitas_kegiatan';
                    break;
                case "tbDaftarAktifitas":
                    $this->data['url_reload'] = base_url($usr.'/input_laporan_kinerja?click=true&tab=tbDaftarAktifitas');
                    $this->data['api_hapus_berkas'] = $this->ekinerja->url_hapus_berkas_aktifitas;
                    $this->data['url_get_info_kegiatan_send_whatsapp'] = $this->ekinerja->url_get_info_kegiatan_send_whatsapp;
                    //$this->data['aktifitas'] = $this->call_list_aktifitas_by_idpegawai();
                    $this->data['listTgl'] = $this->umum->listTanggal();
                    $this->data['usrsrc'] = 'publicpegawai';
                    $this->data['view_list'] = 'list_aktifitas_kegiatan';
                    break;
                case "tbDaftarLaporan":
                    $this->data['url_reload'] = base_url($usr.'/input_laporan_kinerja?click=true&tab=tbDaftarLaporan');
                    $this->data['api_hapus'] = $this->ekinerja->url_hapus_kinerja_master;
                    $this->data['data_list'] = $this->data_ref_list_kinerja_master();
                    $this->data['view_list_kinerja'] = 'list_laporan_kinerja';
                    $this->data['api_hapus_alih_tugas'] = $this->ekinerja->url_hapus_hist_alih_tugas;
                    break;
            }
        }else{
            //cek dari sini
            $submitok = $this->input->post('submitok');
            if($submitok==1) {
                $input_type = $this->input->post('input_type');
                if($input_type=='ubah'){
                    $result = $this->update_data_aktifitas_kegiatan();
                }else{
                    $result = $this->insert_data_kinerja_master();
                }

                $result = $this->ekinerja->safeDecode($result);

                if($result->code == 200) {
                    $tx_result = 'true';
                    $title_result = '';
                    $rdbHistAlihTugas = explode('#',$this->input->post('rdbHistAlihTugas'));
                    $rdbHistAlihTugas = $rdbHistAlihTugas[0];
                    $upload = $this->upload_file_eviden_kegiatan($result->id);
                    $upload_status = $upload['upload_status'];
                    $upload_kode = $upload['upload_kode'];
                }else{
                    $tx_result = 'false';
                    $title_result = $result->title;
                    $upload_status = '';
                    $upload_kode = 0;
                    $rdbHistAlihTugas = '';
                }
            }else{
                $tx_result = '';
                $title_result = '';
                $upload_status = '';
                $upload_kode = 0;
                $rdbHistAlihTugas = '';
            }

            // Re-Input data kegiatan to form
            if($tx_result=='false' or $tx_result==''){
                $this->data['kegiatan_kategori_id'] = $this->input->post('ddKatKegiatan');
                $this->data['kegiatan_rincian'] = $this->input->post('txtRincian');
                $this->data['tgl_kegiatan'] = $this->input->post('tglKegiatan');
                $this->data['jam'] = $this->input->post('ddJam');
                $this->data['menit'] = $this->input->post('ddMenit');
                $this->data['durasi_menit'] = $this->input->post('txtDurasi');
                $this->data['kegiatan_keterangan'] = $this->input->post('txtKet');
                $this->data['kuantitas'] = $this->input->post('txtKuantitas');
                $this->data['idknj_satuan_output'] = $this->input->post('ddSatuan');
            }

            if($input_type=='ubah'){
                $this->data['data_dasar_keg'] = $this->data_dasar_by_kinerja_master($id_knj_master);
                $this->data['data_kegiatan'] = $this->data_aktifitas_by_id($id_aktifitas);
                $this->data['input_type'] = $input_type;
            }else{
                if(isset($_GET['idknjm'])){
                    $this->data['data_dasar'] = $this->data_ref_data_dasar_by_idknjm($_GET['idknjm']);
                    $this->data['input_lampau'] = true;
                }else{
                    $this->data['data_dasar'] = $this->data_ref_data_dasar();
                    $this->data['input_lampau'] = false;
                }
                $this->data['input_type'] = '';
            }

            $this->data['listJam'] = $this->umum->listJam();
            $this->data['listMenit'] = $this->umum->listMenit();
            $this->data['lastTimeKegiatan'] = $this->ekinerja->get_wkt_selesai_kegiatan_terakhir($this->session->userdata('id_pegawai_enc'), date("m"), date("Y"));
            $this->data['tx_result'] = $tx_result;
            $this->data['title_result'] = $title_result;
            $this->data['rdbHistAlihTugas'] = $rdbHistAlihTugas;
            $this->data['upload_kode'] = $upload_kode;
            $this->data['upload_status'] = $upload_status;
            $this->data['view_form'] = 'form_aktifitas_kegiatan';

        }
        $this->data['tab'] = (isset($_GET['tab'])?$_GET['tab']:'');
        return true;
    }

    function upload_file_eviden_kegiatan($id_knj_keg){
        if(isset($_FILES["fileEviden"])) {
            if ($_FILES["fileEviden"]['name'] <> "") {
                if ($_FILES["fileEviden"]['type'] == 'binary/octet-stream' or $_FILES["fileEviden"]['type'] == "application/pdf" or $_FILES["fileEviden"]['type'] == "image/jpeg" or $_FILES["fileEviden"]['type'] == "image/jpg" or $_FILES["fileEviden"]['type'] == "image/png"
                    or $_FILES["fileEviden"]['type'] == "application/msword" or $_FILES["fileEviden"]['type'] == "application/vnd.openxmlformats-officedocument.wordprocessingml.document"
                    or $_FILES["fileEviden"]['type'] == "application/vnd.ms-excel" or $_FILES["fileEviden"]['type'] == "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"
                    or $_FILES["fileEviden"]['type'] == "application/vnd.ms-powerpoint" or $_FILES["fileEviden"]['type'] == "application/vnd.openxmlformats-officedocument.presentationml.presentation") {
                    if ($_FILES["fileEviden"]['size'] > 20097152) {
                        $upload_status = 'File tidak terupload. Ukuran file terlalu besar';
                        $upload_kode = 1;
                    }else{
                        error_reporting(0);
                        $connection = ssh2_connect('103.14.229.15');
                        ssh2_auth_password($connection, 'rommonz', 'mony3Tmony3T');
                        $uploaddir = '/var/www/html/ekinerja2/berkas/';
                        $uploadfile = $uploaddir . basename($_FILES["fileEviden"]['name']);
                        ssh2_scp_send($connection, $_FILES["fileEviden"]['tmp_name'], $uploadfile, 0644);
                        error_reporting(1);
                        /*$uploaddir = 'berkas/';
                        $uploadfile = $uploaddir . basename($_FILES["fileEviden"]['name']);*/
                        //if (move_uploaded_file($_FILES["fileEviden"]['tmp_name'], $uploadfile)) {
                            if($_FILES["fileEviden"]['type'] == "application/pdf")
                                $ext=".pdf";
                            elseif($_FILES["fileEviden"]['type'] == "image/jpeg" or $_FILES["fileEviden"]['type'] == "image/jpg")
                                $ext=".jpg";
                            elseif($_FILES["fileEviden"]['type'] == "image/png")
                                $ext=".png";
                            elseif($_FILES["fileEviden"]['type'] == "application/msword")
                                $ext=".doc";
                            elseif($_FILES["fileEviden"]['type'] == "application/vnd.openxmlformats-officedocument.wordprocessingml.document")
                                $ext=".docx";
                            elseif($_FILES["fileEviden"]['type'] == "application/vnd.ms-excel")
                                $ext=".xls";
                            elseif($_FILES["fileEviden"]['type'] == "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet")
                                $ext=".xlsx";
                            elseif($_FILES["fileEviden"]['type'] == "application/vnd.ms-powerpoint")
                                $ext=".ppt";
                            elseif($_FILES["fileEviden"]['type'] == "application/vnd.openxmlformats-officedocument.presentationml.presentation")
                                $ext=".pptx";
~
                            $nf_baru = $this->session->userdata('nip').'-'.date('dmY').'-'.$id_knj_keg.$ext;
                            //echo "$uploadfile, $nf_baru, $id_knj_keg";
                            $result_upload = $this->update_nama_file_kegiatan($uploadfile, $nf_baru, $id_knj_keg, 1);

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

    function get_info_skp(){
        $id_skp = $this->input->post('id_skp');
        $jenjab = $this->input->post('jenjab');
        $kode_jabatan = $this->input->post('kode_jabatan');
        $eselon = $this->input->post('eselon');
        if($jenjab!='' and $kode_jabatan!=0 and $kode_jabatan!=''){
            $list_stk_skp = $this->call_skp_by_id($id_skp);
            if (isset($list_stk_skp) and sizeof($list_stk_skp) > 0 and $list_stk_skp != ''){
                $existStkSkp = 1;
            }else{
                $existStkSkp = 0;
                $list_stk_skp = '';
            }
        }else{
            $existStkSkp = 0;
            $list_stk_skp = '';
        }
        $info_skp = $this->call_info_last_skp_by_id($id_skp);
        $this->data['info_skp'] = $info_skp;
        $this->data['list_stk_skp'] = $list_stk_skp;
        $this->data['existStkSkp'] = $existStkSkp;
        $this->data['eselon'] = $eselon;
        $this->data['kode_jabatan'] = $kode_jabatan;
        $this->load->view('load_info_skp', $this->data);
    }

    function open_datadasar_infobox(){
        $data['ref_golongan'] = $this->ekinerja->get_golongan();
        $data['ref_unit_kerja'] = $this->ekinerja->get_unit_kerja();
        $this->load->view('infobox_datadasar', $this->data);
    }

    function list_riwayat_kinerja(){
        $this->sidebar_header();
        $modul = 'list_riwayat_kinerja';
        $this->data['title'] = 'Riwayat Aktifitas Kegiatan';
        $this->data['page'] = $modul;
        $this->data['usr'] = 'publicpegawai';
        $this->data['listBln'] = $this->umum->listBulan();
        $this->data['listThn'] = $this->umum->listTahun();
        $this->data['main_view'] = $modul;
        $this->load->view($this->layout, $this->data);
    }

    function vw_list_riwayat_kinerja($usr){
        $this->data['usr'] = $usr;
        $this->data['listBln'] = $this->umum->listBulan();
        $this->data['listThn'] = $this->umum->listTahun();
        $this->load->view('list_riwayat_kinerja', $this->data);
    }

    function drop_data_riwayat_aktifitas(){
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

        $bln = $this->input->post('ddBln');
        $thn = $this->input->post('ddThn');
        $keyword = $this->input->post('keywordCari');
        $jmlData = $this->ekinerja->get_jml_aktifitas_per_periode($bln, $thn, $keyword, $this->session->userdata('id_pegawai_enc'));
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

        $drop_data = $this->ekinerja->daftar_aktifitas_per_periode($start_number,$bln, $thn, $keyword, $this->session->userdata('id_pegawai_enc'),$pages->limit);
        $this->load->view('load_list_riwayat_aktifitas', array(
            'drop_data_list'=> $drop_data,
            'pgDisplay' => $pgDisplay,
            'curpage' => $curpage,
            'numpage' => $numpage,
            'jmlData' => $jmlData,
            'start_number' => $start_number
        ));
    }

    public function exec_kalkulasi_nilai_kinerja(){
        $id_pegawai = $this->input->post('id_pegawai');
        $id_knj_master = $this->input->post('id_knj_master');
        $bln = $this->input->post('bln');
        $thn = $this->input->post('thn');
        $usr = $this->input->post('usr');
        $link_cur = $this->input->post('link_cur');
        $result = $this->ekinerja->get_exec_kalkulasi_nilai_result($id_pegawai, $id_knj_master, $bln, $thn);
        $result = $this->ekinerja->safeDecode($result);
        if($result->code == 200) {
            $this->data['cur_link_addr'] = $link_cur;
            $this->data['usr'] = $usr;
            $this->data['knjmaster'] = $this->call_detail_laporan_kinerja($id_knj_master);
            $this->load->view('list_detail_laporan_kinerja', $this->data);
        }else{
            echo 0;
        }
    }

    public function vw_exec_kalkulasi_nilai_kinerja($id_pegawai, $id_knj_master, $bln, $thn, $usr, $link_cur){
        $result = $this->ekinerja->get_exec_kalkulasi_nilai_result($id_pegawai, $id_knj_master, $bln, $thn);
        $result = $this->ekinerja->safeDecode($result);
        if($result->code == 200) {
            $this->data['cur_link_addr'] = $link_cur;
            $this->data['usr'] = $usr;
            $this->data['knjmaster'] = $this->call_detail_laporan_kinerja($id_knj_master);
            $this->load->view('list_detail_laporan_kinerja', $this->data);
        }else{
            echo 0;
        }
    }

    public function exec_laporan_kinerja_selesai(){
        $id_knj_master = $this->input->post('id_knj_master');
        $status_laporan = $this->input->post('status_laporan');
        $usr = $this->input->post('usr');
        $link_cur = $this->input->post('link_cur');
        $result = $this->ekinerja->get_exec_laporan_kinerja_selesai($id_knj_master, $this->session->userdata('id_pegawai_enc'), $status_laporan);
        $result = $this->ekinerja->safeDecode($result);
        if($result->code == 200) {
            $this->data['cur_link_addr'] = $link_cur;
            $this->data['usr'] = $usr;
            $this->data['knjmaster'] = $this->call_detail_laporan_kinerja($id_knj_master);
            $this->load->view('list_detail_laporan_kinerja', $this->data);
        }else{
            echo 0;
        }
    }

    public function vw_exec_laporan_kinerja_selesai($id_knj_master, $idpegawai_approved, $status_laporan, $usr, $link_cur){
        $result = $this->ekinerja->get_exec_laporan_kinerja_selesai($id_knj_master, $idpegawai_approved, $status_laporan);
        $result = $this->ekinerja->safeDecode($result);
        if($result->code == 200) {
            $this->data['cur_link_addr'] = $link_cur;
            $this->data['usr'] = $usr;
            $this->data['knjmaster'] = $this->call_detail_laporan_kinerja($id_knj_master);
            $this->load->view('list_detail_laporan_kinerja', $this->data);
        }else{
            echo 0;
        }
    }

    public function exec_hapus_kegiatan(){
        $id_knj_kegiatan = $this->input->post('id_knj_kegiatan');
        $result_ori = $this->ekinerja->get_exec_hapus_kegiatan($id_knj_kegiatan);
        $result = $this->ekinerja->safeDecode($result_ori);
        if($result->code == 200) {
            echo 1;
        }else{
            echo 0;
        }
    }

    public function vw_exec_hapus_kegiatan($id_knj_kegiatan){
        $result_ori = $this->ekinerja->get_exec_hapus_kegiatan($id_knj_kegiatan);
        $result = $this->ekinerja->safeDecode($result_ori);
        if($result->code == 200) {
            echo 1;
        }else{
            echo 0;
        }
    }

    public function exec_hapus_berkas_kegiatan(){
        $id_knj_kegiatan = $this->input->post('id_knj_kegiatan');
        $result_ori = $this->ekinerja->get_exec_hapus_berkas_kegiatan($id_knj_kegiatan);
        $result = $this->ekinerja->safeDecode($result_ori);
        if($result->code == 200) {
            echo 1;
        }else{
            echo 0;
        }
    }

    public function vw_exec_hapus_berkas_kegiatan($id_knj_kegiatan){
        $result_ori = $this->ekinerja->get_exec_hapus_berkas_kegiatan($id_knj_kegiatan);
        $result = $this->ekinerja->safeDecode($result_ori);
        if($result->code == 200) {
            echo 1;
        }else{
            echo 0;
        }
    }

    public function peninjauan_kinerja_staf(){
        $this->sidebar_header();
        $modul = 'peninjauan_kinerja_staf';
        $this->data['title'] = 'Peninjauan Kinerja Staf';
        $this->data['page'] = $modul;
        $this->data['main_view'] = $modul;
        $this->data['usr'] = 'publicpegawai';
        $this->data['staf_aktual'] = $this->ekinerja->get_daftar_staf_aktual_kinerja($this->session->userdata('id_pegawai_enc'), $this->session->userdata('id_skpd_enc'));
        $this->data['staf_ekinerja'] = $this->ekinerja->get_daftar_riwayat_staf_kinerja($this->session->userdata('id_pegawai_enc'));
        $this->data['staf_plh'] = $this->ekinerja->get_daftar_riwayat_staf_plh($this->session->userdata('id_pegawai_enc'));
        $this->load->view($this->layout, $this->data);
    }

    public function peninjauan_staf_detail_kegiatan(){
        $this->sidebar_header();
        $modul = 'peninjauan_staf_detail';
        $this->data['title'] = 'Daftar Aktifitas Staf';
        $this->data['usr'] = 'publicpegawai';
        $this->data['idknjm'] = $_GET['idknjm'];
        if(isset($_GET['idpatsl'])){
            $this->data['idpatsl'] = $_GET['idpatsl'];
        }else{
            $this->data['idpatsl'] = $this->session->userdata('id_pegawai_enc');
        }

        $this->data['page'] = $modul;
        $this->data['main_view'] = $modul;

        if(isset($_GET['idknjalhtgs'])){
            $this->data['data_dasar'] = $this->data_dasar_kinerja_by_hist_alih_tugas($_GET['idknjm'], $_GET['idknjalhtgs']);
        }else{
            $this->data['data_dasar'] = $this->data_dasar_by_kinerja_master($_GET['idknjm']);
        }

        $submitok = $this->input->post('submitok');
        if(isset($submitok) and $submitok==1){
            $data = array(
                'ddStsProses' => $this->input->post('ddStsProses'),
                'chkAktifitas' => $this->input->post('chkAktifitas'),
                'id_pegawai_enc' => $this->session->userdata('id_pegawai_enc')
            );

            $result = $this->ekinerja->CallAPI('POST', $this->ekinerja->url_insert_peninjauan_aktifitas_check_all, $data);
            $result = $this->ekinerja->safeDecode($result);
            if($result->code == 200) {
                $tx_result = 'true';
                $title_result = '';
            }else{
                $tx_result = 'false';
                $title_result = $result->title;
            }
        }else{
            $tx_result = '';
            $title_result = '';
        }
        $this->data['tx_result'] = $tx_result;
        $this->data['title_result'] = $title_result;
        $this->load->view($this->layout, $this->data);
    }

    public function vw_peninjauan_staf_detail_kegiatan($idknjm, $idpatsl, $idknjalhtgs, $usr){
        $this->data['usr'] = $usr;
        $this->data['idknjm'] = $_GET['idknjm'];

        if(isset($idpatsl)){
            $this->data['idpatsl'] = $idpatsl;
        }else{
            $this->data['idpatsl'] = $this->session->userdata('id_pegawai_enc');
        }

        if(isset($idknjalhtgs)){
            $this->data['data_dasar'] = $this->data_dasar_kinerja_by_hist_alih_tugas($idknjm, $idknjalhtgs);
        }else{
            $this->data['data_dasar'] = $this->data_dasar_by_kinerja_master($idknjm);
        }

        $this->load->view('peninjauan_staf_detail_vw', $this->data);
    }

    public function drop_data_peninjauan_staf_detail(){
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
        $this->load->view('load_list_peninjauan_aktifitas', array(
            'id_status_knj' => $id_status_knj,
            'usr' => 'publicpegawai',
            'drop_data_list'=> $drop_data,
            'pgDisplay' => $pgDisplay,
            'curpage' => $curpage,
            'numpage' => $numpage,
            'jmlData' => $jmlData
        ));
    }

    public function proses_persetujuan_aktifitas(){
        $idstatus = $this->input->post('idstatus');
        $ket_approval = $this->input->post('ket_approval');
        $id_knj_kegiatan_enc = $this->input->post('id_knj_kegiatan_enc');
        $id_pegawai_enc = $this->input->post('id_pegawai_enc');
        $result = $this->ekinerja->proses_aktifitas_kegiatan_by_id($id_knj_kegiatan_enc, $idstatus, $ket_approval, $id_pegawai_enc);
        $result = $this->ekinerja->safeDecode($result);
        if($result->code == 200) {
            echo 1;
        }else{
            echo 0;
        }
    }

    public function get_aktifitas_by_id(){
        $id_knj_kegiatan_enc = $this->input->post('id_knj_kegiatan_enc');
        $no_urut = $this->input->post('no_urut');
        $this->data['aktifitas_staf'] = $this->ekinerja->get_aktifitas_kegiatan_by_id($id_knj_kegiatan_enc);
        $this->data['no_urut'] = $no_urut;
        $this->load->view('peninjauan_aktifitas_by_id', $this->data);
    }

    public function exec_send_msg_whatsapp(){
        $id_knj_kegiatan = $this->input->post('id_knj_kegiatan');
        $result_ori = $this->ekinerja->get_exec_send_msg_whatsapp($id_knj_kegiatan);
        $result = $this->ekinerja->safeDecode($result_ori);
        if($result->code == 200) {
            echo $result_ori;
        }else{
            echo 0;
        }
    }

    public function vw_exec_send_msg_whatsapp($id_knj_kegiatan){
        $result_ori = $this->ekinerja->get_exec_send_msg_whatsapp($id_knj_kegiatan);
        $result = $this->ekinerja->safeDecode($result_ori);
        if($result->code == 200) {
            echo $result_ori;
        }else{
            echo 0;
        }
    }

    public function riwayat_ekinerja_staf(){
        $this->sidebar_header();
        $modul = 'peninjauan_riwayat_staf';
        $this->data['title'] = 'Daftar Riwayat eKinerja Staf';
        $this->data['usr'] = 'publicpegawai';
        $this->data['idp'] = $_GET['idp'];
        $this->data['page'] = $modul;
        $this->data['main_view'] = $modul;
        $this->data['data_dasar'] = $this->ekinerja->get_informasi_pegawai_byidp($_GET['idp']);
        $this->data['riwayat_ekinerja_staf'] = $this->ekinerja->get_daftar_hist_ekinerja_staf($_GET['idp']);
        $this->load->view($this->layout, $this->data);
    }

    function data_dasar_kinerja_by_hist_alih_tugas($id_knj_master, $idknj_alih_tugas){
        $data_ref = $this->ekinerja->CallAPI('GET', $this->ekinerja->url_detail_laporan_kinerja_by_hist_alih_tugas, array("id_knj_master" => $id_knj_master, "idknj_hist_alih_tugas" => $idknj_alih_tugas));
        $data_ref = $this->ekinerja->safeDecode($data_ref);
        $data_ref = $data_ref->data;
        return $data_ref;
    }

    function detail_laporan_kinerja_staf(){
        $this->sidebar_header();
        $modul = 'list_detail_laporan_kinerja_staf';
        $this->data['title'] = 'Rekapitulasi Laporan Kinerja';
        $this->data['page'] = $modul;
        $this->data['main_view'] = $modul;
        $this->data['usr'] = 'publicpegawai';
        $idknjm = $_GET['idknjm'];
        $data_ref = $this->ekinerja->CallAPI('GET', $this->ekinerja->url_detail_laporan_kinerja, array("id_knj_master" => $idknjm));
        $data_ref = $this->ekinerja->safeDecode($data_ref);
        $data_ref = $data_ref->data;
        $this->data['knjmaster'] =  $data_ref;
        $this->data['idknjm'] = $idknjm;
        $this->load->view($this->layout, $this->data);
    }

    function vw_detail_laporan_kinerja_pegawai($idknjm, $usr){
        $this->data['usr'] = $usr;
        $data_ref = $this->ekinerja->CallAPI('GET', $this->ekinerja->url_detail_laporan_kinerja, array("id_knj_master" => $idknjm));
        $data_ref = $this->ekinerja->safeDecode($data_ref);
        $data_ref = $data_ref->data;
        $this->data['knjmaster'] =  $data_ref;
        $this->data['idknjm'] = $idknjm;
        $this->load->view('list_detail_laporan_kinerja_staf', $this->data);
    }

    function uraian_rekap_kinerja_staf(){
        $this->sidebar_header();
        $modul = 'detail_nilai_kinerja_staf';
        $this->data['title'] = 'Rekapitulasi Laporan Kinerja';
        $this->data['page'] = $modul;
        $this->data['main_view'] = $modul;
        $this->data['knjmaster'] = $this->call_detail_laporan_kinerja($_GET['idknjm']);
        $this->data['nilai_hist_alih_tugas'] = $this->ekinerja->data_ref_list_hist_alih_tugas_detail_calc_by_idknj($_GET['idknjm']);
        $this->load->view($this->layout, $this->data);
    }

    function vw_uraian_rekap_kinerja_staf($idknjm, $usr){
        $this->data['usr'] = $usr;
        $this->data['knjmaster'] = $this->call_detail_laporan_kinerja($idknjm);
        $this->data['nilai_hist_alih_tugas'] = $this->ekinerja->data_ref_list_hist_alih_tugas_detail_calc_by_idknj($idknjm);
        $this->load->view('detail_nilai_kinerja_staf', $this->data);
    }

    public function stk_skp(){
        $this->sidebar_header();
        $modul = 'stk_skp';
        $this->data['title'] = 'Riwayat SKP';
        $this->data['page'] = $modul;
        $this->data['main_view'] = $modul;
        $this->data['usr'] = 'publicpegawai';
        $this->data['riwayat_skp'] = $this->ekinerja->riwayat_skp_pegawai($this->session->userdata('id_pegawai_enc'));
        $this->load->view($this->layout, $this->data);
    }

    public function vw_stk_skp($id_pegawai_enc, $usr){
        $this->data['usr'] = $usr;
        $this->data['riwayat_skp'] = $this->ekinerja->riwayat_skp_pegawai($id_pegawai_enc);
        $this->load->view('stk_skp', $this->data);
    }

    public function detail_stk_skp(){
        $this->sidebar_header();
        $modul = 'stk_skp_detail';
        $this->data['title'] = 'Detail SKP';
        $this->data['page'] = $modul;
        $this->data['main_view'] = $modul;
        $infoSKP = $this->ekinerja->detail_skp_pegawai($_GET['id_skp']);
        $headerSKP = $this->ekinerja->safeDecode($infoSKP[0]['data'])->data;
        $targetSKP = $this->ekinerja->safeDecode($infoSKP[1]['data'])->data;
        $tambahanSKP = $this->ekinerja->safeDecode($infoSKP[2]['data'])->data;
        $this->data['headerSKP'] = $headerSKP;
        $this->data['targetSKP'] = $targetSKP;
        $this->data['tambahanSKP'] = $tambahanSKP;
        $this->load->view($this->layout, $this->data);
    }

    public function vw_detail_stk_skp($id_skp){
        $infoSKP = $this->ekinerja->detail_skp_pegawai($id_skp);
        $headerSKP = $this->ekinerja->safeDecode($infoSKP[0]['data'])->data;
        $targetSKP = $this->ekinerja->safeDecode($infoSKP[1]['data'])->data;
        $tambahanSKP = $this->ekinerja->safeDecode($infoSKP[2]['data'])->data;
        $this->data['headerSKP'] = $headerSKP;
        $this->data['targetSKP'] = $targetSKP;
        $this->data['tambahanSKP'] = $tambahanSKP;
        $this->load->view('stk_skp_detail', $this->data);
    }

    public function download_data(){
        $this->sidebar_header();
        $modul = 'download_data';
        $this->data['title'] = 'Download Data';
        $this->data['page'] = $modul;
        $this->data['main_view'] = $modul;
        $this->load->view($this->layout, $this->data);
    }

    public function get_aktivitas_by_idknj($id_knj_master_enc){
        $data_ref = $this->ekinerja->CallAPI('GET', $this->ekinerja->url_list_aktifitas_by_id, array("id_knj_master" => $id_knj_master_enc));
        $data_ref = $this->ekinerja->safeDecode($data_ref);
        $data_ref = $data_ref->data;
        return $data_ref;
    }

    public function cetak_laporan_kinerja_pegawai($id_knj_master_enc, $id_hist_alih_tugas_enc=0){
        $knjmasterData = $this->call_detail_laporan_kinerja($id_knj_master_enc);
        $nilai_hist_alih_tugas = $this->ekinerja->data_ref_list_hist_alih_tugas_detail_calc_by_idknj($id_knj_master_enc);
        if($id_hist_alih_tugas_enc!=0){
            $ttd = $this->ekinerja->hist_alih_tugas_kinerja_by_id($id_knj_master_enc, $id_hist_alih_tugas_enc);
        }else{
            $ttd = array();
        }
        $this->load->view('cetak_laporan_kinerja_pegawai',
            array(
                'knjmaster' => $knjmasterData,
                'nilai_hist_alih_tugas' => $nilai_hist_alih_tugas,
                'ttd' => $ttd
            ));
    }

    public function cetak_laporan_kinerja_pegawai_aktifitas($id_knj_master_enc, $id_hist_alih_tugas_enc=0){
        $knjmasterData = $this->call_detail_laporan_kinerja($id_knj_master_enc);
        $list_kegiatan = $this->get_aktivitas_by_idknj($id_knj_master_enc);
        if($id_hist_alih_tugas_enc!=0) {
            $ttd = $this->ekinerja->hist_alih_tugas_kinerja_by_id($id_knj_master_enc, $id_hist_alih_tugas_enc);
        }else{
            $ttd = array();
        }
        $this->load->view('cetak_laporan_kinerja_pegawai_aktifitas',
            array(
                'knjmaster' => $knjmasterData,
                'list_kegiatan' => $list_kegiatan,
                'ttd' => $ttd
            ));
    }

    function vw_list_riwayat_kinerja_pegawai($id_pegawai_enc, $usr){
        $this->data['usr'] = $usr;
        $this->data['data_dasar'] = $this->ekinerja->get_informasi_pegawai_byidp($id_pegawai_enc);
        $this->data['riwayat_ekinerja_staf'] = $this->ekinerja->get_daftar_hist_ekinerja_staf($id_pegawai_enc);
        $this->load->view('peninjauan_riwayat_staf', $this->data);
    }

    function drop_data_laporan_kinerja_pegawai(){
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

        $ddBln = $this->input->post('ddBln');
        $ddTahun = $this->input->post('ddTahun');
        $id_pegawai_enc = $this->session->userdata('id_pegawai_enc');
        $jmlData = $this->ekinerja->get_jml_laporan_kinerja_pegawai($this->session->userdata('id_skpd_enc'), $ddBln, $ddTahun, $id_pegawai_enc);
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

        $drop_data = $this->ekinerja->get_daftar_laporan_kinerja_pegawai($start_number,$this->session->userdata('id_skpd_enc'), $ddBln, $ddTahun, $id_pegawai_enc, $pages->limit);
        $this->load->view('load_list_laporan_kinerja_pegawai', array(
            'drop_data_list'=> $drop_data,
            'pgDisplay' => $pgDisplay,
            'curpage' => $curpage,
            'numpage' => $numpage,
            'jmlData' => $jmlData,
            'start_number' => $start_number
        ));
    }

    function daftar_riwayat_hidup(){
        $this->sidebar_header();
        $modul = 'daftar_riwayat_hidup';
        $this->data['title'] = 'Daftar Riwayat Hidup';
        $this->data['page'] = $modul;
        $this->data['main_view'] = $modul;
        $this->data['usr'] = 'publicpegawai';
        $drh = $this->public->daftar_riwayat_hidup($this->session->userdata('id_pegawai_enc'));
        $this->data['biodata'] = $this->public->safeDecode($drh[0]['data'])->data;
        $this->data['pendidikan'] = $this->public->safeDecode($drh[1]['data'])->data;
        $this->data['diklat'] = $this->public->safeDecode($drh[2]['data'])->data;
        $this->data['golongan'] = $this->public->safeDecode($drh[3]['data'])->data;
        $this->data['jabatan'] = $this->public->safeDecode($drh[4]['data'])->data;
        $this->data['istri_suami'] = $this->public->safeDecode($drh[5]['data'])->data;
        $this->data['anak'] = $this->public->safeDecode($drh[6]['data'])->data;
        $this->data['alih_tugas'] = $this->public->safeDecode($drh[7]['data'])->data;
        $this->load->view($this->layout, $this->data);
    }

    function hukuman_disiplin(){
        $this->sidebar_header();
        $modul = 'hukuman_disiplin';
        $this->data['title'] = 'Riwayat Hukuman Disiplin';
        $this->data['page'] = $modul;
        $this->data['main_view'] = $modul;
        $this->data['usr'] = 'publicpegawai';
        $this->data['rhd'] = $this->public->riwayat_hukuman_disiplin($this->session->userdata('id_pegawai_enc'));
        $this->load->view($this->layout, $this->data);
    }

    function ubah_password(){
        $this->sidebar_header();
        $modul = 'ubah_password';
        $this->data['title'] = 'Ubah Password';
        $this->data['page'] = $modul;
        $this->data['main_view'] = $modul;
        $this->data['usr'] = 'publicpegawai';
        $this->load->view($this->layout, $this->data);
    }

    function vw_daftar_riwayat_hidup($id_pegawai){
        $drh = $this->public->daftar_riwayat_hidup($id_pegawai);
        $this->data['biodata'] = $this->public->safeDecode($drh[0]['data'])->data;
        $this->data['pendidikan'] = $this->public->safeDecode($drh[1]['data'])->data;
        $this->data['diklat'] = $this->public->safeDecode($drh[2]['data'])->data;
        $this->data['golongan'] = $this->public->safeDecode($drh[3]['data'])->data;
        $this->data['jabatan'] = $this->public->safeDecode($drh[4]['data'])->data;
        $this->data['istri_suami'] = $this->public->safeDecode($drh[5]['data'])->data;
        $this->data['anak'] = $this->public->safeDecode($drh[6]['data'])->data;
        $this->data['alih_tugas'] = $this->public->safeDecode($drh[7]['data'])->data;
        $this->load->view('daftar_riwayat_hidup', $this->data);
    }

    function vw_hukuman_disiplin($id_pegawai){
        $this->data['rhd'] = $this->public->riwayat_hukuman_disiplin($id_pegawai);
        $this->load->view('hukuman_disiplin', $this->data);
    }

    function vw_ubah_password($id_pegawai){
        $this->data['password_lama'] = '';
        $this->load->view('ubah_password', $this->data);
    }

    function drop_data_aktifitas_by_id(){
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

        $idknjm = $this->input->post('idknjm');
        $tgl = $this->input->post('ddTgl');
        $status = $this->input->post('ddStsProses');
        $target = $this->input->post('ddKatKegiatan');
        $keyword = $this->input->post('keywordCari');

        if($idknjm=='') {
            $idknjm = $this->ekinerja->CallAPI('GET', $this->ekinerja->url_get_idknj_master_by_idp, array("id_pegawai" => $this->session->userdata('id_pegawai_enc')));
            $idknjm = $this->ekinerja->safeDecode($idknjm);
            $idknjm = $idknjm->data;
        }

        $jmlData = $this->ekinerja->get_jml_aktifitas_by_id($tgl, $status, $target, $keyword, $idknjm);
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

        $drop_data = $this->ekinerja->daftar_aktifitas_by_id($start_number, $tgl, $status, $target, $keyword, $idknjm, $pages->limit);
        $this->load->view('load_list_aktifitas_by_id', array(
            'drop_data_list'=> $drop_data,
            'pgDisplay' => $pgDisplay,
            'curpage' => $curpage,
            'numpage' => $numpage,
            'jmlData' => $jmlData,
            'start_number' => $start_number
        ));
    }

    public function riwayat_ekinerja_staf_plh(){
        $this->sidebar_header();
        $modul = 'peninjauan_riwayat_staf_plh';
        $this->data['title'] = 'Daftar Riwayat eKinerja Staf Plh';
        $this->data['usr'] = 'publicpegawai';
        $this->data['idp'] = $_GET['idp'];
        $this->data['page'] = $modul;
        $this->data['main_view'] = $modul;
        $this->data['data_dasar'] = $this->ekinerja->get_informasi_pegawai_byidp($_GET['idp']);
        $this->data['riwayat_ekinerja_staf_plh'] = $this->ekinerja->get_daftar_hist_ekinerja_staf_plh($_GET['idp'], $this->session->userdata('id_pegawai_enc'));
        $this->load->view($this->layout, $this->data);
    }

    public function peninjauan_staf_detail_kegiatan_plh(){
        $this->sidebar_header();
        $modul = 'peninjauan_staf_detail_plh';
        $this->data['title'] = 'Daftar Aktifitas Staf PLH';
        $this->data['usr'] = 'publicpegawai';
        $this->data['idknjm'] = $_GET['idknjm'];
        $this->data['idpatsl_plh'] = $this->session->userdata('id_pegawai_enc');
        $this->data['page'] = $modul;
        $this->data['main_view'] = $modul;
        $this->data['data_dasar'] = $this->data_dasar_by_kinerja_master($_GET['idknjm']);
        $submitok = $this->input->post('submitok');
        if(isset($submitok) and $submitok==1){
            $data = array(
                'ddStsProses' => $this->input->post('ddStsProsesPlh'),
                'chkAktifitas' => $this->input->post('chkAktifitasPlh'),
                'id_pegawai_enc' => $this->session->userdata('id_pegawai_enc')
            );

            $result = $this->ekinerja->CallAPI('POST', $this->ekinerja->url_insert_peninjauan_aktifitas_check_all, $data);
            $result = $this->ekinerja->safeDecode($result);
            if($result->code == 200) {
                $tx_result = 'true';
                $title_result = '';
            }else{
                $tx_result = 'false';
                $title_result = $result->title;
            }
        }else{
            $tx_result = '';
            $title_result = '';
        }
        $this->data['tx_result'] = $tx_result;
        $this->data['title_result'] = $title_result;
        $this->load->view($this->layout, $this->data);
    }

    public function drop_data_peninjauan_staf_detail_plh(){
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
        $idpatsl_plh = $this->input->post('idpatsl_plh');
        $jmlData = $this->ekinerja->get_jumlah_peninjauan_aktifitas_staf_plh($ddStsProses, $keyword, $idknjm, $idpatsl_plh);
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

        $drop_data = $this->data['aktifitas_staf'] = $this->ekinerja->get_daftar_peninjauan_aktifitas_staf_plh($start_number, $ddStsProses, $keyword, $idknjm, $idpatsl_plh, $pages->limit);
        $this->load->view('load_list_peninjauan_aktifitas_plh', array(
            'id_status_knj' => $id_status_knj,
            'usr' => 'publicpegawai',
            'drop_data_list'=> $drop_data,
            'pgDisplay' => $pgDisplay,
            'curpage' => $curpage,
            'numpage' => $numpage,
            'jmlData' => $jmlData
        ));
    }

    public function get_aktifitas_by_id_plh(){
        $id_knj_kegiatan_enc = $this->input->post('id_knj_kegiatan_enc');
        $no_urut = $this->input->post('no_urut');
        $this->data['aktifitas_staf'] = $this->ekinerja->get_aktifitas_kegiatan_by_id($id_knj_kegiatan_enc);
        $this->data['no_urut'] = $no_urut;
        $this->load->view('peninjauan_aktifitas_by_id_plh', $this->data);
    }

    public function list_riwayat_cuti_jdwl_khusus(){
        $this->sidebar_header();
        $modul = 'list_riwayat_cuti_jdwl_khusus';
        $this->data['title'] = 'Riwayat Cuti dan Jadwal Khusus';
        $this->data['page'] = $modul;
        $this->data['main_view'] = $modul;
        $this->load->view($this->layout, $this->data);
    }

}
