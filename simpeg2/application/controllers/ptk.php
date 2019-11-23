<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ptk extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('ptk_model','ptk');
        $this->load->library('format');
    }

    public function index($status = NULL){
        $this->load->view('layout/header', array( 'title' => 'Pengajuan PTK', 'idproses' => 0));
        $this->load->view('ptk/header');
        $this->dashboard_ptk();
        $this->load->view('layout/footer');
    }

    public function dashboard_ptk(){
        $rekap_jenis_status = $this->ptk->getReportJenisStatus();
        $rekap_jenis = $this->ptk->getReportJenis();
        $rekap_status = $this->ptk->getReportStatus();
        $i=0;
        foreach ($rekap_jenis as $lsdata){
            if($lsdata->jenis_pengajuan!='Jumlah'){
                $data1[$i] = array(
                    'name' => $lsdata->jenis_pengajuan,
                    'y' => $lsdata->jumlah
                );
                $i++;
            }
        }
        $this->load->model('umum_model');
        $listBln = $this->umum_model->listBulan();
        $listThn = $this->umum_model->listTahun();
        $submitok = $this->input->post('submitok');
        if(isset($submitok) and $submitok==1){
            $data = array(
                'bln' => $this->input->post('ddBln'),
                'thn' => $this->input->post('ddThn'),
                'nomor' => $this->input->post('nomor'),
                'idp_pengesah' => $this->input->post('txtIdPegawaiPengesah'),
                'chkIdPTKPilih' => $this->input->post('chkIdPTKPilih')
            );
            $insert = $this->ptk->tambah_data_pengantar($data);
            $tx_result = $insert['query'];
            if($tx_result == 1){
            }else{
                $tx_result = 2;
            }
        }

        $this->load->view('ptk/dashboard_ptk',
            array(
                'rekap_jenis_status' => $rekap_jenis_status,
                'rekap_jenis' => $rekap_jenis,
                'rekap_status' => $rekap_status,
                'chart' => json_encode($data1, JSON_NUMERIC_CHECK),
                'listBln' => $listBln,
                'listThn' => $listThn,
                'tx_result' => (isset($tx_result)?$tx_result:'0')
            ));
    }

    public function list_pengajuan_ptk($idproses=0){
        if (isset($_POST['revisi'])) {
            $id_status_ptk = 3;
        }elseif (isset($_POST['proses'])) {
            $id_status_ptk = 4;
        }elseif (isset($_POST['setuju'])) {
            $id_status_ptk = 5;
        }elseif (isset($_POST['tolak'])) {
            $id_status_ptk = 6;
        }elseif (isset($_POST['kirim_sk'])) {
            $id_status_ptk = 8;
        }elseif (isset($_POST['informasi'])) {
            $id_status_ptk = 12;
        }
        if(isset($_POST['revisi']) or isset($_POST['proses']) or isset($_POST['setuju']) or isset($_POST['tolak']) or isset($_POST['kirim_sk']) or isset($_POST['informasi'])){
            $idptk = $this->input->post('formNameEdit');
            $catatan = $this->input->post('txtCatatan_'.$idptk);
            $approvedBy = $this->session->userdata('user')->id_pegawai;
            $idptk = $this->ptk->updatePtkMaster($id_status_ptk,$approvedBy,$catatan,$idptk);
            if(isset($idptk) > 0){
                $idptk = 'tersimpan';
            }
        }
        $this->load->view('layout/header', array( 'title' => 'Pengajuan PTK', 'idproses' => $idproses));
        $this->load->view('ptk/header');
        $list_title = $this->ptk->getTitleList($idproses);
        $getSKPD = $this->ptk->getSKPD();
        $getJenis = $this->ptk->getJenisPTK();
        if($idproses==1 or $idproses==2 or $idproses==6){
            $getStatus = $this->ptk->getStatusPTK($idproses);
        }
        $idskpd = $this->input->get('idskpd');
        $jenis = $this->input->get('jenis');
        $status = $this->input->get('status');
        $keywordCari = $this->input->get('keywordCari');
        $num_rows = $this->ptk->get_countall_list_data_ptk($idproses,$idskpd,$jenis,$status,$keywordCari);
        if($num_rows>0){
            $this->load->library('pagerv2');
            $pages = new Paginator($num_rows,9,array(3,6,9,10,15,25,50,100,'All'));
            $pgDisplay = $pages->display_pages();
            $curpage = $pages->current_page;
            $numpage = $pages->num_pages;
            $total_items = $pages->total_items;
            $jumppage = $pages->display_jump_menu();
            $item_perpage = $pages->display_items_per_page();
            $list_ptk = $this->ptk->get_list_data_ptk($idproses,$pages->limit_start,$pages->limit_end,$idskpd,$jenis,$status,$keywordCari);
        }else{
            $pgDisplay = '';
            $curpage = '';
            $numpage = '';
            $total_items = '';
            $jumppage = '';
            $item_perpage = '';
            $list_ptk = '';
        }

        $this->load->view('ptk/list_pengajuan_ptk',
            array(
                'list_title' => $list_title,
                'list_ptk' => $list_ptk,
                'tx_result' => (isset($idptk) ? $idptk : ''),
                'user_cur' => $this->session->userdata('user')->id_pegawai,
                'list_skpd' => $getSKPD,
                'list_jenis' => $getJenis,
                'keywordCari' => $keywordCari,
                'pgDisplay' => $pgDisplay,
                'curpage' => $curpage,
                'numpage' => $numpage,
                'total_items' => $total_items,
                'jumppage' => $jumppage,
                'item_perpage' => $item_perpage,
                'idskpd' => $idskpd,
                'jenis' => $jenis,
                'status' => $status,
                'keywordCari' => $keywordCari,
                'list_status' => (isset($getStatus) ? $getStatus : '')
            ));
        $this->load->view('layout/footer');
    }

    public function cetak_sk_ptk($id_ptk){
        $row_sk_ptk = $this->ptk->cetakSKPtk($id_ptk);
        $row_sk_ptk_keluarga = $this->ptk->cetakSKPtkKeluarga($id_ptk);
        $this->load->model('umum_model');
        $this->load->view('ptk/cetak_sk_ptk',
            array(
                'dataRow' => $row_sk_ptk,
                'dataRowKeluarga' => $row_sk_ptk_keluarga,
                'jmlRowKeluarga' => sizeof($row_sk_ptk_keluarga)
            ));
    }

    public function update_data_ptk(){
        $data = array(
            'nomorSkPtk' => $this->input->post('nomorSkPtk'),
            'sifatSkPtk' => $this->input->post('sifatSkPtk'),
            'lampPtk' => $this->input->post('lampPtk'),
            'id_ptk' => $this->input->post('id_ptk'),
            'idp_pengesah' => $this->input->post('idp_pengesah')
        );
        $update = $this->ptk->updateDataPtk($data);
        if($update){
            echo 1;
        }else{
            $error = $this->db->error();
            echo "ERROR : ".$error['message'];
        }
    }

    public function update_nomor_usulan_ptk(){
        $data = array(
            'txtNomorPtk' => $this->input->post('txtNomorPtk'),
            'id_ptk' => $this->input->post('id_ptk'),
        );
        $update = $this->ptk->updateNomorUsulanPtk($data);
        if($update){
            echo 1;
        }else{
            $error = $this->db->error();
            echo "ERROR : ".$error['message'];
        }
    }

    public function upload_sk_ptk(){
        $id_ptk = $this->input->post('id_ptk');
        $catatan = $this->input->post('catatan');
        if(isset($_FILES["fileSkPtk".$id_ptk])) {
            if($_FILES["fileSkPtk".$id_ptk] <> "" ){
                if($_FILES["fileSkPtk".$id_ptk]['type']=='binary/octet-stream' or $_FILES["fileSkPtk".$id_ptk]['type'] == "application/pdf" ){
                    if($_FILES["fileSkPtk".$id_ptk]['size'] > 20097152) {
                        echo('File tidak terupload. Ukuran file terlalu besar');
                    }else{
                        //$uploaddir = '../simpeg/Berkas/';
                        $uploaddir = '/var/www/html/simpeg/berkas/';
                        $uploadfile = $uploaddir . basename($_FILES["fileSkPtk".$id_ptk]['name']);

                        $connection = ssh2_connect('103.14.229.15');
                        ssh2_auth_password($connection, 'rommonz', 'mony3Tmony3T');
                        $sftp = ssh2_sftp($connection);

                        if(ssh2_scp_send($connection, $_FILES["fileSkPtk".$id_ptk]['tmp_name'], $uploadfile, 0644)){
                        //if (move_uploaded_file($_FILES["fileSkPtk".$id_ptk]['tmp_name'], $uploadfile)) {
                            $this->db->trans_begin();
                            $sqlInsert = "insert into berkas (id_pegawai,id_kat,nm_berkas,tgl_upload,created_by,created_date,ket_berkas) ".
                                "values (".$this->input->post('id_pegawai').", 47,'Surat Pengajuan PTK ke BPKAD', DATE(NOW()), '".$this->session->userdata('user')->id_pegawai."', NOW(), $id_ptk)";
                            $this->db->query($sqlInsert);
                            if ($this->db->trans_status() === FALSE){
                                $this->db->trans_rollback();
                            }else{
                                $idberkas = $this->db->insert_id();
                                $sqlUpdate = "update ptk_master set id_berkas_ptk = $idberkas, idstatus_ptk = 8,
                                tgl_update_sk_ptk = NOW(), tgl_approve = NOW(), approved_by = ".$this->session->userdata('user')->id_pegawai.",
                                approved_note = '$catatan' where id_ptk=".$id_ptk;
                                $this->db->query($sqlUpdate);
                                if ($this->db->trans_status() === FALSE){
                                    $this->db->trans_rollback();
                                }else{
                                    $sqlInsert = "insert into isi_berkas (id_berkas, ket) values ($idberkas, 'Surat Pengajuan PTK ke BPKAD')";
                                    $this->db->query($sqlInsert);
                                    $idisi = $this->db->insert_id();
                                    $nf=$this->input->post('nip')."-".$idberkas."-".$idisi.".pdf";
                                    $sqlUpdate = "update isi_berkas set file_name='$nf' where id_isi_berkas=$idisi";
                                    $this->db->query($sqlUpdate);
                                    if ($this->db->trans_status() === FALSE) {
                                        $this->db->trans_rollback();
                                    }else{
                                        $sqlInsert_Approved_Hist = "INSERT INTO ptk_historis_approve(tgl_approve_hist, approved_by_hist, id_status_ptk, approved_note_hist, id_ptk)
                                        VALUES (NOW(),".$this->session->userdata('user')->id_pegawai.",8,'$catatan',".$id_ptk.")";
                                        $this->db->query($sqlInsert_Approved_Hist);
                                        if ($this->db->trans_status() === FALSE) {
                                            $this->db->trans_rollback();
                                        }else{
                                            $this->db->trans_commit();
                                            //rename($uploadfile,"../simpeg/Berkas/".$nf);
                                            ssh2_sftp_rename($sftp, $uploadfile,$uploaddir.$nf);
                                            echo '1';
                                        }
                                    }
                                }
                            }
                        }else{
                            echo('File tidak terupload. Ada permasalahan ketika mengakses jaringan');
                        }
                    }
                }else{
                    echo('File tidak terupload. Tipe file belum sesuai');
                }
            }else{
                echo('File tidak ditemukan');
            }
        }else{
            echo('File tidak ditemukan');
        }
    }

    public function info_pegawai(){
        $nip = $this->input->post('nipCari');
        $id_ptk = $this->input->post('id_ptk');
        $listdata = $this->ptk->getInfoPegawai($nip);
        $this->load->view('ptk/info_pegawai',
            array(
                'list_data' => $listdata,
                'id_ptk' => $id_ptk
            ));
    }

    public function window_ubah_data_ptk_syarat(){
        $id_syarat = $this->input->post('id_syarat');
        $nama_berkas = $this->input->post('nama_berkas');
        $listdata = $this->ptk->getUbahPtkSyarat($id_syarat);
        $this->load->view('ptk/ubah_ptk_syarat',
            array(
                'list_data' => $listdata,
                'nama_berkas'=>$nama_berkas
            ));
    }

    public function update_data_syarat_ptk(){
        $data = array(
            'tglRef' => $this->input->post('tglRef'),
            'ketRef' => $this->input->post('ketRef'),
            'tglBerkas' => $this->input->post('tglBerkas'),
            'ketPengesah' => $this->input->post('ketPengesah'),
            'id_syarat' => $this->input->post('id_syarat'),
            'ketInstitusi' => $this->input->post('ketInstitusi')
        );
        $update = $this->ptk->updateDataSyaratPtk($data);
        if($update){
            echo 1;
        }else{
            $error = $this->db->error();
            echo "ERROR : ".$error['message'];
        }
    }

    public function list_data_keluarga(){
        $listdata = $this->ptk->infoKeluargaPegawai($this->input->post('idp'));
        $this->load->view('ptk/list_data_keluarga',
            array(
                'list_data' => $listdata
            ));
    }

    public function drop_data_pengantar_bpkad(){
        $this->load->library('pager');
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
        $jmlData = $this->ptk->getCountAllPengantarBPKADList($bln,$thn);

        if($jmlData>0){
            $pages->items_total = $jmlData;
            $pages->paginate();
            $pgDisplay = $pages->display_pages();
            $itemPerPage = $pages->display_items_per_page();
            $curpage = $pages->current_page;
            $numpage = $pages->num_pages;
            $jumppage = $pages->display_jump_menu();
        }else{
            $pgDisplay = '';
            $itemPerPage = '';
            $curpage = '';
            $numpage = '';
            $jumppage = '';
        }
        $ipp = explode("&&", $ipp);
        $ipp = $ipp[0];
        if($pagePaging == 1){
            $start_number = 0;
        }else{
            $start_number = ($pagePaging * $ipp) - $ipp;
        }

        $drop_data_pengantar = $this->ptk->getDropDataPengantarBPKADList($start_number,$bln,$thn,$pages->limit);
        $this->load->view('ptk/drop_data_pengantar', array(
            'drop_data_pengantar'=> $drop_data_pengantar,
            'bln' => $bln,
            'thn'=> $thn,
            'pgDisplay' => $pgDisplay,
            'curpage' => $curpage,
            'ipp' => $ipp,
            'numpage' => $numpage,
            'jumppage' => $jumppage,
            'jmlData' => $jmlData
        ));

    }

    public function window_ubah_data_pengantar(){
        $id_pengantar = $this->input->post('id_pengantar');
        $id_berkas = $this->input->post('id_berkas');
        $curpage = $this->input->post('curpage');
        $ipp = $this->input->post('ipp');
        $this->load->model('umum_model');
        $listBln = $this->umum_model->listBulan();
        $listThn = $this->umum_model->listTahun();
        $listdata = $this->ptk->getUbahPengantar($id_pengantar);
        $this->load->view('ptk/ubah_pengantar',
            array(
                'listdata' => $listdata,
                'id_pengantar' => $id_pengantar,
                'id_berkas'=>$id_berkas,
                'curpage' => $curpage,
                'ipp' => $ipp,
                'listBln'=>$listBln,
                'listThn' => $listThn
            ));
    }

    public function update_pengantar(){
        $data = array(
            'id_ptr' => $this->input->post('id_ptr'),
            'nomorPtr' => $this->input->post('nomorPtr'),
            'txtIdPegawaiPengesah' => $this->input->post('txtIdPegawaiPengesah'),
            'strIdPtk' => $this->input->post('strIdPtk')
        );
        $update = $this->ptk->updateDataPengantarPTK($data);
        if($update){
            echo 1;
        }else{
            $error = $this->db->error();
            echo "ERROR : ".$error['message'];
        }
    }

    public function hapus_pengantar_ptk(){
        $update = $this->ptk->hapusDataPengantarPTK($this->input->post('id_pengantar'));
        if($update){
            echo 1;
        }else{
            $error = $this->db->error();
            echo "ERROR : ".$error['message'];
        }
    }

    public function upload_surat_ptr_ptk(){
        $id_ptr = $this->input->post('id_ptr');
        if(isset($_FILES["fileSkPtr"])) {
            if($_FILES["fileSkPtr"] <> "" ){
                if($_FILES["fileSkPtr"]['type']=='binary/octet-stream' or $_FILES["fileSkPtr"]['type'] == "application/pdf" ){
                    if($_FILES["fileSkPtr"]['size'] > 20097152) {
                        echo('File tidak terupload. Ukuran file terlalu besar');
                    }else{
                        //$uploaddir = '../simpeg/Berkas/';
                        $uploaddir = '/var/www/html/simpeg/berkas/';
                        $uploadfile = $uploaddir . basename($_FILES["fileSkPtr"]['name']);

                        $connection = ssh2_connect('103.14.229.15');
                        ssh2_auth_password($connection, 'rommonz', 'mony3Tmony3T');
                        $sftp = ssh2_sftp($connection);

                        if(ssh2_scp_send($connection, $_FILES["fileSkPtr"]['tmp_name'], $uploadfile, 0644)){
                        //if (move_uploaded_file($_FILES["fileSkPtr"]['tmp_name'], $uploadfile)) {
                            $this->db->trans_begin();
                            $sqlInsert = "insert into berkas (id_pegawai,id_kat,nm_berkas,tgl_upload,created_by,created_date,ket_berkas) ".
                                "values (".$this->session->userdata('user')->id_pegawai.", 50,'Surat Pengantar PTK ke BPKAD', DATE(NOW()), '".$this->session->userdata('user')->id_pegawai."', NOW(), $id_ptr)";
                            $this->db->query($sqlInsert);
                            if ($this->db->trans_status() === FALSE){
                                $this->db->trans_rollback();
                            }else{
                                $idberkas = $this->db->insert_id();
                                $sqlUpdate = "update pengantar set id_berkas = $idberkas where id_pengantar=".$id_ptr;
                                $this->db->query($sqlUpdate);
                                if ($this->db->trans_status() === FALSE){
                                    $this->db->trans_rollback();
                                }else{
                                    $sqlInsert = "insert into isi_berkas (id_berkas, ket) values ($idberkas, 'Surat Pengantar PTK ke BPKAD')";
                                    $this->db->query($sqlInsert);
                                    $idisi = $this->db->insert_id();
                                    $nf=$this->session->userdata('user')->nip_baru."-".$idberkas."-".$idisi.".pdf";
                                    $sqlUpdate = "update isi_berkas set file_name='$nf' where id_isi_berkas=$idisi";
                                    $this->db->query($sqlUpdate);
                                    if ($this->db->trans_status() === FALSE) {
                                        $this->db->trans_rollback();
                                    }else{
                                        $this->db->trans_commit();
                                        //rename($uploadfile,"../simpeg/Berkas/".$nf);
                                        ssh2_sftp_rename($sftp, $uploadfile,$uploaddir.$nf);
                                        echo '1';
                                    }
                                }
                            }
                        }else{
                            echo('File tidak terupload. Ada permasalahan ketika mengakses jaringan');
                        }
                    }
                }else{
                    echo('File tidak terupload. Tipe file belum sesuai');
                }
            }else{
                echo('File tidak ditemukan');
            }
        }else{
            echo('File tidak ditemukan');
        }
    }

    public function cetak_pengantar_ptk($idptr){
        $row_sk_ptr = $this->ptk->cetakPengantarPtk($idptr);
        $row_bln_data_pengantar = $this->ptk->getBulanDataPengantar($idptr);
        $this->load->model('umum_model');
        $this->load->view('ptk/cetak_pengantar_ptk',
            array(
                'idptr' => $idptr,
                'dataRow' => $row_sk_ptr,
                'jmlRow' => sizeof($row_sk_ptr),
                'dataRowBlnDataP' => $row_bln_data_pengantar,
            ));
    }

    public function window_nominatif_ptk(){
        $bln = $this->input->post('bln');
        $thn = $this->input->post('thn');
        $this->load->model('umum_model');
        $listdata = $this->ptk->nominatifRekapPTK_ByAktual($bln,$thn,'','all');
        $this->load->view('ptk/nominatif_rekap',
            array(
                'listdata' => $listdata,
                'bln' => $bln,
                'thn'=>$thn
            ));
    }

    public function tambah_pengantar(){
        $this->load->view('layout/header', array( 'title' => 'Pengajuan PTK', 'idproses' => 0));
        $this->load->view('ptk/header');
        $this->load->model('umum_model');
        $listBln = $this->umum_model->listBulan();
        $listThn = $this->umum_model->listTahun();
        $lstPengesah = $this->ptk->getPengesah();
        $this->load->view('ptk/tambah_pengantar',
            array(
                'listBln'=>$listBln,
                'listThn' => $listThn,
                'listdata' => $lstPengesah
            ));
        $this->load->view('layout/footer');
    }

    public function nominatif_ptk_pengantar(){
        $bln = $this->input->post('bln');
        $thn = $this->input->post('thn');
        $keyword = $this->input->post('keyword');
        $this->load->model('umum_model');
        $listdata = $this->ptk->nominatifRekapPTK_ByAktual($bln,$thn,$keyword,'for_bpkad');
        $this->load->view('ptk/nominatif_ptk_pengantar',
            array(
                'listdata' => $listdata,
                'bln' => $bln,
                'thn'=>$thn
            ));
    }

};

?>