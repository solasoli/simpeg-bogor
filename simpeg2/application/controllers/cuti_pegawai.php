<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cuti_pegawai extends CI_Controller {

    function __construct(){
        parent::__construct();
        $this->load->model("cuti_pegawai_model");
        $this->load->library('format');
        $this->load->library('pagerv2');
    }

    public function index(){
        //$this->load->view('layout/header', array( 'title' => 'Cuti Pegawai Negeri Sipil'));
        //$this->load->view('cuti_pegawai/header',array( 'title' => 'Cuti Pegawai Negeri Sipil', 'idproses' => 0));
        $this->list_pengajuan_cuti();
        $this->load->view('layout/footer');
    }

    public function list_pengajuan_cuti($idproses=0){
        if (isset($_POST['revisi'])) {
            $id_status_cuti = 4;
        }elseif (isset($_POST['proses'])) {
            $id_status_cuti = 5;
        }elseif (isset($_POST['setuju'])) {
            $id_status_cuti = 6;
        }elseif (isset($_POST['tolak'])) {
            $id_status_cuti = 8;
        }elseif (isset($_POST['kirim_sk'])) {
            $id_status_cuti = 10;
        }elseif (isset($_POST['sembunyi'])) {
            $id_status_cuti = 11;
        }

        if(isset($_POST['revisi']) or isset($_POST['proses']) or isset($_POST['setuju']) or isset($_POST['tolak']) or isset($_POST['kirim_sk']) or isset($_POST['sembunyi'])){
            $idcuti_master = $this->input->post('formNameEdit');
            $pilihan = $this->input->post('ddCatatan_'.$idcuti_master);
            if($pilihan=='Lainnya' or $pilihan==''){
                $catatan = $this->input->post('txtCatatan_'.$idcuti_master);
            }else{
                $catatan = $this->input->post('ddCatatan_'.$idcuti_master);
            }
            $approvedBy = $this->session->userdata('user')->id_pegawai;
            if(isset($_POST['setuju'])){
                $idp_pengesah = $this->input->post('txtIdPegawaiPengesah_'.$idcuti_master);
                if($idp_pengesah==''){
                    $idp_pengesah = 'NULL';
                }
            }else{
                $idp_pengesah = 'NULL';
            }
            $id_cuti_master = $this->cuti_pegawai_model->updateCutiMaster($id_status_cuti,$approvedBy,$catatan,$idcuti_master,$idp_pengesah);
            if(isset($id_cuti_master) > 0){
                $id_cuti_master = 'tersimpan';
            }
        }else if(isset($_POST['hapus'])){
            $idcuti_master = $this->input->post('formNameEdit');
            $id_cuti_master = $this->cuti_pegawai_model->deleteCutiMaster($idcuti_master);
            if(isset($id_cuti_master) > 0){
                $id_cuti_master = 'terhapus';
            }
        }

        $this->load->view('layout/header', array( 'title' => 'Cuti Pegawai Negeri Sipil', 'idproses' => $idproses));
        $this->load->view('cuti_pegawai/header');
        $list_title = $this->cuti_pegawai_model->getTitleList($idproses);

        $idskpd = $this->input->get('idskpd');
        $jenis = $this->input->get('jenis');
        $status = $this->input->get('status');
        $cek_sk = $this->input->get('cek_sk');
        $keywordCari = $this->input->get('keywordCari');
        $stsExpire = $this->input->get('stsexpire');

        $num_rows = $this->cuti_pegawai_model->getCountAllListCutiByProses($idproses,$idskpd,$jenis,$status,$cek_sk,$keywordCari,$stsExpire);

        if($num_rows>0){
            $pages = new Paginator($num_rows,9,array(3,6,9,10,15,25,50,100,'All'));
            $pgDisplay = $pages->display_pages();
            $curpage = $pages->current_page;
            $numpage = $pages->num_pages;
            $total_items = $pages->total_items;
            $jumppage = $pages->display_jump_menu();
            $item_perpage = $pages->display_items_per_page();
            $list_cuti = $this->cuti_pegawai_model->getListCutiByProses($idproses,$pages->limit_start,$pages->limit_end,$idskpd,$jenis,$status,$cek_sk,$keywordCari,$stsExpire);
            //print_r($list_cuti);
        }else{
            $pgDisplay = '';
            $curpage = '';
            $numpage = '';
            $total_items = '';
            $jumppage = '';
            $item_perpage = '';
            $list_cuti = '';
        }
        $getSKPD = $this->cuti_pegawai_model->getSKPD();
        $getJenis = $this->cuti_pegawai_model->getJenisCuti();
        if($idproses==0 or $idproses==1 or $idproses==2 or $idproses==3 or $idproses==4){
            $getStatus = $this->cuti_pegawai_model->getStatusCuti($idproses);
        }
        $this->load->view('cuti_pegawai/list_pengajuan_cuti',
            array(
                'list_title' => $list_title,
                'list_cuti' => $list_cuti,
                'tx_result' => (isset($id_cuti_master) ? $id_cuti_master : ''),
                'user_cur' => $this->session->userdata('user')->id_pegawai,
                'list_skpd' => $getSKPD,
                'list_jenis' => $getJenis,
                'list_status' => (isset($getStatus) ? $getStatus : ''),
                'idproses' => $idproses,
                'pgDisplay' => $pgDisplay,
                'curpage' => $curpage,
                'numpage' => $numpage,
                'total_items' => $total_items,
                'jumppage' => $jumppage,
                'item_perpage' => $item_perpage,
                'idskpd' => $idskpd,
                'jenis' => $jenis,
                'status' => $status,
                'cek_sk' => $cek_sk,
                'keywordCari' => $keywordCari,
                'recStatusExpire' => $this->cuti_pegawai_model->getRekapStatusExpire(),
                'stsExpire' => $stsExpire
            ));
        $this->load->view('layout/footer');
    }

    public function cetak_sk_cuti($id_cuti_master){
        $row_sk_cuti = $this->cuti_pegawai_model->cetakSKcuti($id_cuti_master);
        $rowIdPengesah = $this->cuti_pegawai_model->getIdPengesahByCuti($id_cuti_master);
        foreach ($rowIdPengesah as $row){
            $idp_pengesah = $row->id_pegawai_pengesah;
        }

        if($idp_pengesah==''){
            $row_pengesah = $this->cuti_pegawai_model->getPengesah($id_cuti_master);
        }else{
            $row_pengesah = $this->cuti_pegawai_model->getPengesahById($idp_pengesah);
        }

        $this->load->model('umum_model');
        $this->load->view('cuti_pegawai/cetak_sk_cuti',
            array(
                'dataRow' => $row_sk_cuti,
                'dataRowPengesah' => $row_pengesah
            ));
    }

    public function cetak_sk_cuti_tte(){

      $id_cuti_master = $this->input->post('id_cuti_master');
      $url = 'https://arsipsimpeg.kotabogor.go.id/simpeg2/cuti_pegawai/cetak_sk_cuti_tte';
      $data = array('id_cuti_master'=>$id_cuti_master, 'idp_pengolah'=>$this->session->userdata('user')->id_pegawai);

      //update nosk dan tnggal sk
      $no_sk = $this->input->post('no_sk');
      $tgl_sk = $this->input->post('tgl_sk');

      $query = "update cuti_master set no_sk_cuti = '".$no_sk."', tgl_sk_cuti = '".$tgl_sk."' where id_cuti_master = ".$id_cuti_master;
      $this->db->query($query);

      $curl = curl_init();
      curl_setopt($curl, CURLOPT_POST, 1);
      curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
      curl_setopt($curl, CURLOPT_URL, $url);
      curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($curl, CURLOPT_CONNECTTIMEOUT ,0);
      curl_setopt($curl, CURLOPT_TIMEOUT, 400);
      set_time_limit(0);

      try {
          $result = curl_exec($curl);

          if (curl_error($curl)) {
              $error_msg = curl_error($curl);
          }
          curl_close($curl);
          if (isset($error_msg)) {
              print_r($error_msg);
              die;
          }
          //var_dump($result);
          redirect('cuti_pegawai/list_pengajuan_cuti/3');
      }catch(Exception $e) {
          echo 'Message: ' .$e->getMessage();
      }

    }

    public function upload_berkas(){
        session_start();
        //echo $_GET['idkat'].'-'.$_GET['idp_uploader'].'-'.$_GET['idp_cutier'].'-'.$_GET['nm_berkas'].'-'.$_GET['ket_berkas'];
        $_SESSION['katberkas']=$_GET['idkat'];
        $_SESSION['idpegawai_uploader']=$_GET['idp_uploader'];
        $_SESSION['idpegawai_cutier']=$_GET['idp_cutier'];
        $_SESSION['nmberkas']=$_GET['nm_berkas'];
        $_SESSION['ket_berkas']=$_GET['ket_berkas'];

        if(isset($_GET['upload_ulang'])){
            $_SESSION['reupload']=$_GET['upload_ulang'];
            $_SESSION['idberkas']=$_GET['id_berkas'];
        }else{
            $_SESSION['reupload']=0;
            $_SESSION['idberkas']=0;
        }
        error_reporting(E_ALL | E_STRICT);
        $this->load->library('uploadhandlerer');
        //$upload_handler = new UploadHandler();
    }

     public function pengaturan(){

		$this->load->view('layout/header', array( 'title' => 'Cuti Pegawai Negeri Sipil', 'idproses' => 8));
        $this->load->view('cuti_pegawai/header');

        $data['libur_nasionals'] = $this->cuti_pegawai_model->getLiburNasionalList()->result();
        $data['cuti_bersamas'] = $this->cuti_pegawai_model->getCutiBersamaList()->result();

        $this->load->view('cuti_pegawai/pengaturan',$data);

        $this->load->view('layout/footer');
	}

    public function cek_historis(){
        $this->load->view('layout/header', array( 'title' => 'Cuti Pegawai Negeri Sipil', 'idproses' => 7));
        $this->load->view('cuti_pegawai/header');
        $this->load->view('layout/footer');
    }

	public function saveLiburNasional(){

		setlocale (LC_TIME, 'INDONESIA');

		$tglLN = $this->format->date_Ymd($this->input->post('tglLN'));

		$strdate = explode("-",$tglLN);
		$year = $strdate[0];
		$month = $strdate[1];
		$day = $strdate[2];

		$hari = strftime( "%A", mktime(0,0,0,$month,$day,$year));

		$ket = $this->input->post('ketLN');

		if($this->cuti_pegawai_model->saveLiburNasional($tglLN,$hari,$ket)){
			echo true;
		}else{

			echo false;
		}
	}

	public function delLiburNasional(){

		$no = $this->input->post('no');
		if($this->cuti_pegawai_model->delLiburNasional($no)){
			echo true;
		}else{
			echo false;
		}
	}

	public function rekap($year=NULL,$bln=NULL,$thn=NULL,$metode=NULL){

		if(!$year) $year = date("Y");
        if(!$bln) $bln = date("m");
        if(!$thn) $thn = date("Y");

		$this->load->view('layout/header', array( 'title' => 'Cuti Pegawai Negeri Sipil', 'idproses' => 6));
        $this->load->view('cuti_pegawai/header');

        $data['jenis_cutis'] = $this->cuti_pegawai_model->getRekapCuti($year)->result();
        $data['tahun'] = $year;
        $data['bln_periode'] = $bln;
        $data['thn_periode'] = $thn;
        $data['rptCutiJenisStatus'] = $this->cuti_pegawai_model->reportPerPeriodeJenisStatus($bln, $year);
        $data['rptCutiPerOPD'] = $this->cuti_pegawai_model->reportCutiPerOPD($bln, $year);
        $data['metode_pengajuan'] = $metode;

        $this->load->view('cuti_pegawai/rekapitulasi',$data);

        $this->load->view('layout/footer');
	}

    public function entry_konvensional(){
        $this->load->view('layout/header', array( 'title' => 'Cuti Pegawai Negeri Sipil', 'idproses' => 9));
        $this->load->view('cuti_pegawai/header');
        $this->load->model("umum_model");
        $data['golongan'] = $this->umum_model->getGolongan();
        $data['listUnit'] = $this->umum_model->getUnitKerja();
        $this->load->view('cuti_pegawai/entry_konvensional',$data);
        $this->load->view('layout/footer');
    }

    public function info_pegawai(){
        $nip = $this->input->post('nipCari');
        $idcuti = $this->input->post('idcuti');
        $listdata = $this->cuti_pegawai_model->getInfoPegawai($nip);
        $this->load->view('cuti_pegawai/info_pegawai',
            array(
                'list_data' => $listdata,
                'idcuti' => $idcuti
            ));
    }

    public function update_jenis_cuti(){
        $data = array(
            'ddFilterJnsEd' => $this->input->post('ddFilterJnsEd'),
            'id_cm_ed' => $this->input->post('id_cm_ed'),
        );
        $update = $this->cuti_pegawai_model->updateJenisCuti($data);
        if($update){
            echo 1;
        }else{
            $error = $this->db->error();
            echo "ERROR : ".$error['message'];
        }
    }

}
