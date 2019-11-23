<?php defined('BASEPATH') OR exit('No direct script access allowed');

Class Administrator extends MY_Controller{
    public $data;
    public $layout;

    public function __construct()
    {
        parent::__construct();
        $this->layout = 'docs/home';
        $this->data['judul'] = 'Administrator';
        $this->load->model('Administrator_model','administrator');
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
        $this->methode_all_list();
    }

    public function entitas_list(){
        $entitas_list = $this->administrator->listof_entitas();
        $this->data['entitas_list'] = $entitas_list->result();
        $this->data['main_view'] = 'administrator/entitas_list';
        $this->load->view($this->layout, $this->data);
    }

    public function add_new_entitas(){
        $this->data['main_view'] = 'administrator/entitas_add';
        $submitok = $this->input->post('submitok');
        if($submitok==1) {
            $data = array(
                'txtEntitas' => $this->input->post('txtEntitas'),
                'txtKet' => $this->input->post('txtKet')
            );
            $insert = $this->administrator->insert_entitas($data);
            $tx_result = $insert['query'];
            $identitas = $insert['identitas'];
        }else{
            $tx_result = '';
            $identitas = '';
        }
        $this->data['tx_result'] = $tx_result;
        $this->data['identitas'] = $identitas;
        $this->load->view($this->layout, $this->data);
    }

    public function ubah_entitas($identitas){
        $submitok = $this->input->post('submitok');
        if($submitok==1){
            $data = array(
                'txtIdEntitas' => $this->input->post('txtIdEntitas'),
                'txtEntitas' => $this->input->post('txtEntitas'),
                'txtKet' => $this->input->post('txtKet')
            );
            $update = $this->administrator->update_entitas($data);
            $this->data['tx_result'] = $update;
        }else{
            $this->data['tx_result'] = '';
        }
        $entitas = $this->administrator->get_entitas_by_id($identitas);
        $this->data['entitas'] = $entitas->result();
        $this->data['main_view'] = 'administrator/entitas_edit';
        $this->load->view($this->layout, $this->data);
    }

    public function hapus_entitas(){
        $id = $this->input->post('entitas');
        if($this->administrator->delete_entitas($id)){
            echo "BERHASIL";
        }else{
            $error = $this->db->error();
            echo "ERROR : ".$error['message'];
        }
    }

    public function methode_all_list(){
        $methode_list = $this->administrator->listof_rest_master();
        $this->data['methode_list'] = $methode_list->result();
        $this->data['main_view'] = 'administrator/methode_list';
        $this->load->view($this->layout, $this->data);
    }

    public function methode_detail($idmethode){
        $params = $this->administrator->get_params_methode_by_id($idmethode);
        $response = $this->administrator->get_response_methode_by_id($idmethode);
        $this->data['params'] = $params->result();
        $this->data['response'] = $response->result();
        $this->load->view('administrator/methode_detail', $this->data);
    }

    public function add_new_methode(){
        $entitas_list = $this->administrator->listof_entitas();
        $this->data['entitas_list'] = $entitas_list->result();
        $methode_type_list = $this->administrator->get_methode_type();
        $this->data['methode_type_list'] = $methode_type_list->result();
        $this->data['entitas'] = '';
        $this->data['methode_type'] = '';
        $this->data['main_view'] = 'administrator/methode_add';

        $submitok = $this->input->post('submitok');
        if($submitok==1){
            $chkParamEnkrip = $this->input->post('chkParamEnkrip');
            $data = array(
                'txtJudul' => $this->input->post('txtJudul'),
                'txtUraian' => $this->input->post('txtUraian'),
                'ddEntitas' => $this->input->post('ddEntitas'),
                'txtFungsi' => $this->input->post('txtFungsi'),
                'txtUrl' => $this->input->post('txtUrl'),
                'ddMethode' => $this->input->post('ddMethode'),
                'txtSampleCall' => $this->input->post('txtSampleCall'),
                'txtKet' => $this->input->post('txtKet'),
                'idrest_admin' => $this->session->userdata('idrest_admin'),
                'chkParamEnkrip' => ((isset($chkParamEnkrip) and $chkParamEnkrip =='true')?1:0)
            );
            $insert = $this->administrator->insert_methode($data);
            $tx_result = $insert['query'];
            $idmethode = $insert['idmethode'];
        }else{
            $tx_result = '';
            $idmethode = '';
        }
        $this->data['tx_result'] = $tx_result;
        $this->data['idmethode'] = $idmethode;
        $this->load->view($this->layout, $this->data);
    }

    public function ubah_methode($idmethode){
        $submitok = $this->input->post('submitok');
        if($submitok==1){
            $chkParamEnkrip = $this->input->post('chkParamEnkrip');
            $data = array(
                'txtJudul' => $this->input->post('txtJudul'),
                'txtUraian' => $this->input->post('txtUraian'),
                'ddEntitas' => $this->input->post('ddEntitas'),
                'txtFungsi' => $this->input->post('txtFungsi'),
                'txtUrl' => $this->input->post('txtUrl'),
                'ddMethode' => $this->input->post('ddMethode'),
                'txtSampleCall' => $this->input->post('txtSampleCall'),
                'txtKet' => $this->input->post('txtKet'),
                'txtIdMethode' => $this->input->post('txtIdMethode'),
                'chkParamEnkrip' => ((isset($chkParamEnkrip) and $chkParamEnkrip =='true')?1:0)
            );
            $update = $this->administrator->update_methode($data);
            if($update=='true'){
                $jmlParam = 0;
                if($this->input->post('jmlParam')>0){
                    $jmlParam = $this->input->post('jmlParam');
                    for ($i = 1; $i <= $jmlParam; $i++) {
                        $data = array(
                            'params_name' => $this->input->post("params_name$i"),
                            'methode_type' => $this->input->post("methode_type$i"),
                            'values' => $this->input->post("values$i"),
                            'chkRequired' => ($this->input->post("chkRequired$i")==''?0:1),
                            'idrest_params' => $this->input->post("idparams$i")
                        );
                        $this->administrator->update_params_methode($data);
                    }
                }
                if ($this->input->post('params_name') != "" and $this->input->post('values') != "") {
                    $data = array(
                        'params_name' => $this->input->post('params_name'),
                        'methode_type' => $this->input->post('methode_type'),
                        'values' => $this->input->post('values'),
                        'chkRequired' => ($this->input->post('chkRequired')==''?0:1),
                        'id_methode' => $this->input->post('txtIdMethode')
                    );
                    $this->administrator->insert_params_methode($data);
                }

                $jmlRespon = 0;
                if($this->input->post('jmlRespon')>0){
                    $jmlRespon = $this->input->post('jmlRespon');
                    for ($i = 1; $i <= $jmlRespon; $i++) {
                        $data = array(
                            'status_code' => $this->input->post("status_code$i"),
                            'content' => $this->input->post("content$i"),
                            'idrest_response' => $this->input->post("idrespons$i")
                        );
                        $this->administrator->update_respons_methode($data);
                    }
                }
                if ($this->input->post('status_code') != "" and $this->input->post('content') != "") {
                    $data = array(
                        'status_code' => $this->input->post('status_code'),
                        'content' => $this->input->post('content'),
                        'id_methode' => $this->input->post('txtIdMethode')
                    );
                    $this->administrator->insert_respons_methode($data);
                }
                $tx_result = $update;
            }else{
                $tx_result = '';
            }
            $this->data['tx_result'] = $tx_result;
            $this->data['jmlParam'] = $jmlParam;
            $this->data['jmlRespon'] = $jmlRespon;
        }else{
            $this->data['tx_result'] = '';
            $this->data['jmlParam'] = '';
            $this->data['jmlRespon'] = '';
        }

        $this->load->model('Umum_model','umum');
        $entitas_list = $this->administrator->listof_entitas();
        $this->data['entitas_list'] = $entitas_list->result();
        $methode_type_list = $this->administrator->get_methode_type();
        $this->data['methode_type_list'] = $methode_type_list->result();
        $methode = $this->administrator->get_detail_methode_by_id($idmethode);
        $this->data['methode'] = $methode->result();
        $params = $this->administrator->get_params_methode_by_id($idmethode);
        $response = $this->administrator->get_response_methode_by_id($idmethode);
        $this->data['params'] = $params->result();
        $this->data['response'] = $response->result();
        $this->data['main_view'] = 'administrator/methode_edit';

        $this->load->view($this->layout, $this->data);
    }

    public function hapus_methode(){
        $id = $this->input->post('id_methode');
        if($this->administrator->delete_methode($id)){
            echo "BERHASIL";
        }else{
            $error = $this->db->error();
            echo "ERROR : ".$error['message'];
        }
    }

    public function hapus_parameter(){
        $id = $this->input->post('idrest_params');
        if($this->administrator->delete_params_methode($id)){
            echo "BERHASIL";
        }else{
            $error = $this->db->error();
            echo "ERROR : ".$error['message'];
        }
    }

    public function hapus_response(){
        $id = $this->input->post('idrest_response');
        if($this->administrator->delete_respons_methode($id)){
            echo "BERHASIL";
        }else{
            $error = $this->db->error();
            echo "ERROR : ".$error['message'];
        }
    }

    public function application_list(){
        $apps_list = $this->administrator->listof_rest_apps();
        $this->data['apps_list'] = $apps_list->result();
        $this->data['main_view'] = 'administrator/apps_list';
        $this->load->view($this->layout, $this->data);
    }

    public function add_new_application(){
        $platform_list = $this->administrator->get_platform();
        $this->data['platform_list'] = $platform_list->result();
        $this->data['platform'] = '';
        $this->data['main_view'] = 'administrator/apps_add';
        $submitok = $this->input->post('submitok');
        if($submitok==1) {
            $txtP = $this->input->post('txtP');
            $txtQ = $this->input->post('txtQ');
            $jml_prime_pq = $this->administrator->cek_nilai_prime_eksisting($txtP, $txtQ);
            if($jml_prime_pq==0) {
                $rsa = $this->try_encrypt_decrypt($txtP, $txtQ);
                if($rsa['res']=='true'){
                    $data = array(
                        'txtApps' => $this->input->post('txtApps'),
                        'ddPlatform' => $this->input->post('ddPlatform'),
                        'txtOwner' => $this->input->post('txtOwner'),
                        'txtWordKey' => $this->input->post('txtWordKey'),
                        'txtApiKey' => $this->input->post('txtApiKey'),
                        'txtUrl' => $this->input->post('txtUrl'),
                        'txtPrivateKey' => $rsa['prv'],
                        'txtPublicKey' => $rsa['pub'],
                        'txtModulo' => $rsa['modulo'],
                        'txtP' => $txtP,
                        'txtQ' => $txtQ
                    );
                    $insert = $this->administrator->insert_apps($data);
                    $tx_result = $insert['query'];
                    $idapps = $insert['idapps'];
                }else{
                    $tx_result = 'pq_error';
                    $idapps = '';
                }
            }else{
                $tx_result = 'pq_exist';
                $idapps = '';
            }
        }else{
            $tx_result = '';
            $idapps = '';
        }
        $this->data['tx_result'] = $tx_result;
        $this->data['idapps'] = $idapps;
        $this->load->view($this->layout, $this->data);
    }

    public function try_encrypt_decrypt($txtP, $txtQ){
        include 'application/models/Rsa_model.php';
        $RSA = new RSA();
        $keys = $RSA->generate_keys($txtP, $txtQ, 0);
        $modulo = $keys[0];
        $pub = $keys[1];
        $prv = $keys[2];
        $psn = "RSA Enkripsi BKPSDA";
        //echo ($modulo.'-'.$pub.'-'.$prv.'<br>');
        /*$encoded = $RSA->encrypt ($psn, $pub, $modulo, 5);
        $decoded = $RSA->decrypt ($encoded, $prv, $modulo);
        */
        //$encrypted_string = $this->encrypt->encode($psn, $modulo.$prv.$pub);
        //$decoded = $this->encrypt->decode($encrypted_string, $modulo.$prv.$pub);
        //if($decoded == $psn){
            $out['res'] = "true";
        //}else{
            //$out['res'] = "false";
        //}
        $out['modulo'] = $modulo;
        $out['pub'] = $pub;
        $out['prv'] = $prv;
        $out['prv'] = $prv;
        return $out;
    }

    public function ubah_application($idapps){
        $submitok = $this->input->post('submitok');
        if($submitok==1){
            $chkPrime = $this->input->post('chkUpdatePrime');
            if(isset($chkPrime) and $chkPrime == 'true'){
                $txtP = $this->input->post('txtP');
                $txtQ = $this->input->post('txtQ');
                $jml_prime_pq = $this->administrator->cek_nilai_prime_eksisting($txtP, $txtQ);
                if($jml_prime_pq==0) {
                    $rsa = $this->try_encrypt_decrypt($txtP, $txtQ);
                    if($rsa['res']=='true'){
                        $data = array(
                            'txtApps' => $this->input->post('txtApps'),
                            'ddPlatform' => $this->input->post('ddPlatform'),
                            'txtOwner' => $this->input->post('txtOwner'),
                            'txtWordKey' => $this->input->post('txtWordKey'),
                            'txtApiKey' => $this->input->post('txtApiKey'),
                            'txtUrl' => $this->input->post('txtUrl'),
                            'txtIdApps' => $this->input->post('txtIdApps'),
                            'txtPrivateKey' => $rsa['prv'],
                            'txtPublicKey' => $rsa['pub'],
                            'txtModulo' => $rsa['modulo'],
                            'txtP' => $txtP,
                            'txtQ' => $txtQ,
                            'updatePrime' => 'true'
                        );
                        $update = $this->administrator->update_apps($data);
                        $this->data['tx_result'] = $update;
                    }else{
                        $this->data['tx_result'] = 'pq_error';
                    }
                }else{
                    $this->data['tx_result'] = 'pq_exist';
                }
            }else{
                $data = array(
                    'txtApps' => $this->input->post('txtApps'),
                    'ddPlatform' => $this->input->post('ddPlatform'),
                    'txtOwner' => $this->input->post('txtOwner'),
                    'txtWordKey' => $this->input->post('txtWordKey'),
                    'txtApiKey' => $this->input->post('txtApiKey'),
                    'txtUrl' => $this->input->post('txtUrl'),
                    'txtIdApps' => $this->input->post('txtIdApps'),
                    'updatePrime' => 'false'
                );
                $update = $this->administrator->update_apps($data);
                $this->data['tx_result'] = $update;
            }
        }else{
            $this->data['tx_result'] = '';
        }
        $platform_list = $this->administrator->get_platform();
        $this->data['platform_list'] = $platform_list->result();
        $apps = $this->administrator->get_detail_apps_by_id($idapps);
        $this->data['apps'] = $apps->result();

        $this->data['main_view'] = 'administrator/apps_edit';
        $this->load->view($this->layout, $this->data);
    }

    public function hapus_application(){
        $id = $this->input->post('id_apps');
        if($this->administrator->delete_apps($id)){
            echo "BERHASIL";
        }else{
            $error = $this->db->error();
            echo "ERROR : ".$error['message'];
        }
    }

    public function methode_access_list(){
        $submitok = $this->input->post('submitok');
        if($submitok==1){
            $data = array(
                'ddStatus' => $this->input->post('ddStatus'),
                'txtIdrest_access' => $this->input->post('txtIdrest_access'),
                'idrest_admin' => $this->session->userdata('idrest_admin')
            );
            $update = $this->administrator->update_access_methode($data);
            $this->data['tx_result'] = $update;
        }else{
            $this->data['tx_result'] = '';
        }
        $apps_list = $this->administrator->listof_rest_apps();
        $this->data['apps_list'] = $apps_list->result();
        $this->data['main_view'] = 'administrator/access_methode_list';
        $this->load->view($this->layout, $this->data);
    }

    public function add_new_access_methode(){
        $apps_list = $this->administrator->get_apps();
        $this->data['apps_list'] = $apps_list->result();
        $this->data['apps_id'] = 1;
        $entitas_list = $this->administrator->listof_entitas();
        $this->data['entitas_list'] = $entitas_list->result();
        $this->data['main_view'] = 'administrator/access_methode_add';
        $submitok = $this->input->post('submitok');

        if(isset($submitok) and $submitok==1){
            $data = array(
                'idapps' => $this->input->post('ddApps'),
                'chkIdMethodePilih' => $this->input->post('chkIdMethodePilih'),
                'idrest_admin' => $this->session->userdata('idrest_admin')
            );
            $insert = $this->administrator->insert_access_methode($data);
            $tx_result = $insert;
        }else{
            $tx_result = '';
        }
        $this->data['tx_result'] = $tx_result;
        $this->load->view($this->layout, $this->data);
    }

    public function list_methode_available(){
        $entitas = $this->input->post('entitas');
        $keyword = $this->input->post('keyword');
        $methode_list = $this->administrator->listof_rest_master($entitas,$keyword);
        $this->data['methode_list'] = $methode_list->result();
        $this->load->view('administrator/drop_methode_list', $this->data);
    }

    public function keterangan_apps(){
        $idapps = $this->input->post('idapps');
        $this->data['idapps'] = $idapps;
        $apps_ket = $this->administrator->get_detail_apps_by_id($idapps);
        $this->data['apps_ket'] = $apps_ket->result();
        $methode_list = $this->administrator->listof_access_methode($idapps);
        $this->data['methode_list'] = $methode_list->result();
        $this->load->view('administrator/drop_ket_apps', $this->data);
    }

    public function ubah_akses_methode($idakses_methode){
        $akses_methode = $this->administrator->access_methode_by_id($idakses_methode);
        $this->data['akses_methode'] = $akses_methode->result();
        $this->load->view('administrator/access_methode_edit', $this->data);
    }

    public function hapus_akses_methode(){
        $id = $this->input->post('idrest_access');
        if($this->administrator->delete_access_methode($id)){
            echo "BERHASIL";
        }else{
            $error = $this->db->error();
            echo "ERROR : ".$error['message'];
        }
    }

    public function hapus_semua_methode_by_apps(){
        $id = $this->input->post('idapps');
        if($this->administrator->delete_all_access_methode_by_apps($id)){
            echo "BERHASIL";
        }else{
            $error = $this->db->error();
            echo "ERROR : ".$error['message'];
        }
    }

    public function admin_list(){
        $admin_list = $this->administrator->listof_admin();
        $this->data['admin_list'] = $admin_list->result();
        $this->data['main_view'] = 'administrator/administrator_list';
        $this->load->view($this->layout, $this->data);
    }

    public function add_new_admin(){
        $this->data['main_view'] = 'administrator/administrator_add';
        $submitok = $this->input->post('submitok');
        if($submitok==1) {
            $data = array(
                'txtUName' => $this->input->post('txtUName'),
                'txtPwd' => $this->input->post('txtPwd'),
                'txtIdPegawai' => $this->input->post('txtIdPegawai'),
                'ddStatusAktif' => $this->input->post('ddStatusAktif'),
                'ddStatusUser' => $this->input->post('ddStatusUser')
            );
            $cekExisting = $this->administrator->get_admin_by_uname($this->input->post('txtUName'))->result();
            if (isset($cekExisting) and sizeof($cekExisting) > 0){
                $tx_result = 'existing';
                $idrest_admin = '';
            }else{
                $insert = $this->administrator->insert_admin($data);
                $tx_result = $insert['query'];
                $idrest_admin = $insert['idrest_admin'];
            }
        }else{
            $tx_result = '';
            $idrest_admin = '';
        }
        $this->data['tx_result'] = $tx_result;
        $this->data['idrest_admin'] = $idrest_admin;
        $this->load->view($this->layout, $this->data);
    }

    public function ubah_admin($idadmin){
        $submitok = $this->input->post('submitok');
        if($submitok==1){
            $data = array(
                'txtPwd' => $this->input->post('txtPwd'),
                'ddStatusAktif' => $this->input->post('ddStatusAktif'),
                'ddStatusUser' => $this->input->post('ddStatusUser'),
                'txtIdRestAdmin' => $this->input->post('txtIdRestAdmin')
            );
            $update = $this->administrator->update_admin($data);
            $this->data['tx_result'] = $update;
        }else{
            $this->data['tx_result'] = '';
        }
        $admin = $this->administrator->get_admin_by_id($idadmin);
        $this->data['admin'] = $admin->result();

        $this->data['main_view'] = 'administrator/administrator_edit';
        $this->load->view($this->layout, $this->data);
    }

    public function hapus_admin(){
        $id = $this->input->post('idrest_admin');
        if($this->administrator->delete_admin($id)){
            echo "BERHASIL";
        }else{
            $error = $this->db->error();
            echo "ERROR : ".$error['message'];
        }
    }

    public function cari_pegawai(){
        $searchTerm = @$_GET['term'];
        if (is_numeric($searchTerm)){
            $dataResult = $this->administrator->cari_pegawai_by_nip($searchTerm);
        }else{
            $dataResult = $this->administrator->cari_pegawai_by_word($searchTerm);
        }
        $dataList = array();
        $datap = array();
        if (sizeof($dataResult) > 0){
            if($dataResult!=''){
                foreach ($dataResult as $data){
                    $datap['id'] = $data->id_pegawai;
                    $datap['nama'] = $data->nama;
                    $datap['nip'] = $data->nip_baru;
                    array_push($dataList, $datap);
                }
            }
        }
        echo json_encode($dataList);
    }

    public function log_access_list(){
        $log_list = $this->administrator->listof_log_access();
        $this->data['log_list'] = $log_list->result();
        $this->data['main_view'] = 'administrator/log_methode_list';
        $this->load->view($this->layout, $this->data);
    }

    public function cetak_manual_rest_by_apps($idapps){

        $appsInfo = $this->administrator->get_detail_apps_by_id($idapps);
        $row_manual = $this->administrator->cetakManualRest_by_apps($idapps);
        $this->load->view('administrator/cetak_manual_rest',
        array(
            'dataManual' => $row_manual->result(),
            'apps_list' => $appsInfo->result()
        ));
    }

}
