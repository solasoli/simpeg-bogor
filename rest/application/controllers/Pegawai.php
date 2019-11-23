<?php defined('BASEPATH') OR exit('No direct script access allowed');


class Pegawai extends CI_Controller{
    var $api_key;
    var $keyApps;

	public function __construct(){
		parent::__construct();
		$this->load->model('Api_model', 'api');
		$this->load->model('pegawai_model', 'pegawai');
	}

	public function index(){
		//echo json_encode(array(array('request_status'=>'No method is found')));
	}

    public function exec_running_methode($id_methode, $key=null, $param1=null, $param2=null){
        $this->load->model('Api_model','Api');
        $data = null;
        //$key=null;
        if($key==null){
            $key = $this->input->post('key');
        }
        if($key!=null){
            $verif = $this->Api->verify_api_key($key);
            if($verif!=null){
                $methode = $this->Api->get_rest_methode($id_methode, $verif['idrest_apps']);
                if($methode!=null){
                    $data = 1;
                    $this->api_key = $key;
                    $this->keyApps = $this->pegawai->get_key_apps($key);
                    $func = $methode['entitas'].'::'.$methode['function'];
                    call_user_func($func, $param1, $param2);
                }
            }
        }
        if($data==null){
            $data = array('code'=>203,
                'status'=>'success',
                'title'=>'Anda tidak memiliki akses data',
                'data'=>$data,
                'rel'=>'self'
            );
            echo json_encode($data);
        }
    }

	public function get($param=NULL){
		if(! $param || strlen($param) < 3){
			$this->failed();
			exit;
		}
		//$param = urldecode($param);
		$query = $this->pegawai->get($param);
		if($query->result()){
			echo json_encode($query->result());
		}else{
			$this->failed();
		}
	}

    public function getByNip($nip){
        if(! $nip || strlen($nip) != 18){
            $this->failed();
            exit;
        }
        //$param = urldecode($param);
        $query = $this->pegawai->get($nip)->result();
        if($query){
            $data = array(	'code'=>200,
                'status'=>'success',
                'title'=>'Pegawai By NIP',
                'data'=>$query,
                'rel'=>'self',
                'href'=>'http://simpeg.kotabogor.go.id/rest/pegawai/'.$nip
            );
            echo json_encode($data);
        }else{
            $this->failed();
        }

    }

    function profil($nip=NULL){
        if(!$nip){
            //$this->failed();
            exit;
        }
        $this->load->model('Pegawai_model','pegawai');
        $query = $this->pegawai->get_profil($nip);
        $data = $query->result();
        $data = array(	'code'=>200,
            'status'=>'success',
            'title'=>'Profil Pegawai '.$nip,
            'data'=>$data,
            'rel'=>'self',
            'links'=>array(
                'riwayatGolongan'=>base_url('pegawai/riwayatGolongan/'.$nip)
            )

        );
        echo json_encode($data);
    }

    function riwayatGolongan($nip){
        if(!$nip){
            //$this->failed();
            exit;
        }
        $this->load->model('Pegawai_model','pegawai');
        $query = $this->pegawai->get_riwayat_golongan($nip);
        $data = $query->result();
        $data = array(	'code'=>200,
            'status'=>'success',
            'title'=>'Riwayat Golongan',
            'data'=>$data,
            'rel'=>'child',
            'links'=>array(
                'profil'=>base_url('pegawai/profil/'.$nip),
            )
        );
        echo json_encode($data);
    }

    function syncronizeEmpAppESurat(){
        $this->load->model('Pegawai_model','pegawai');
        $query = $this->pegawai->get_sync_esurat();
        $data = $query->result();
        $data = array(	'code'=>200,
            'status'=>'success',
            'title'=>'Sinkronisasi E-Surat',
            'data'=>$data,
            'rel'=>'child'
        );
        echo json_encode($data);
    }

    function find_all(){
        $this->load->model('Pegawai_model','pegawai');
        $query = $this->pegawai->find_all();
        $data = $query->result();
        $data = array(	'code'=>200,
            'status'=>'success',
            'title'=>'Tampilkan Semua Pegawai',
            'data'=>$data,
            'rel'=>'child'
        );
        echo json_encode($data);
    }

    function esurat_pejabat(){
        $this->load->model('Pegawai_model','pegawai');
        $query = $this->pegawai->esurat_pejabat();
        $data = $query->result();
        $data = array(	'code'=>200,
            'status'=>'success',
            'title'=>'Tampilkan Semua Pegawai',
            'data'=>$data,
            'rel'=>'child'
        );
        echo json_encode($data);
    }

    function find_by_nama($nama){
	    if(isset($nama) and $nama != ''){

        }else{
	        $nama =$this->input->get('nama');
        }
        $this->load->model('Pegawai_model','pegawai');
        $query = $this->pegawai->find_by_nama($nama);
        $data = $query->result();
        $data = array(	'code'=>200,
            'status'=>'success',
            'title'=>'Tampilkan Pegawai Berdasarkan Nama Tertentu',
            'data'=>$data,
            'rel'=>'child'
        );

        echo json_encode($data);
    }

    function find_by_nama_and_opd($nama, $idopd){
        if(isset($nama) and $nama != ''){

        }else{
            $nama =$this->input->get('nama');
        }

        if(isset($idopd) and $idopd != ''){

        }else{
            $idopd =$this->input->get('idopd');
        }

        $this->load->model('Pegawai_model','pegawai');
        $query = $this->pegawai->find_by_nama_and_opd($nama, $idopd);
        $data = $query->result();
        $data = array(	'code'=>200,
            'status'=>'success',
            'title'=>'Tampilkan Pegawai Berdasarkan Nama Tertentu dan OPD tertentu',
            'data'=>$data,
            'rel'=>'child'
        );

        echo json_encode($data);
    }

    function find_by_nip($nip){
        $this->load->model('Pegawai_model','pegawai');
        $query = $this->pegawai->find_by_nip($nip);
        $data = $query->result();
        $data = array(	'code'=>200,
            'status'=>'success',
            'title'=>'Tampilkan Pegawai Berdasarkan NIP Tertentu',
            'data'=>$data,
            'rel'=>'child'
        );

        echo json_encode($data);
    }

    function find_by_unit_kerja($unit){
        $this->load->model('Pegawai_model','pegawai');
        $query = $this->pegawai->find_by_unit_kerja($unit);
        $data = $query->result();
        $data = array(	'code'=>200,
            'status'=>'success',
            'title'=>'Tampilkan List Pegawai Berdasarkan Unit Kerja Tertentu',
            'data'=>$data,
            'rel'=>'child'
        );

        echo json_encode($data);
    }

    function ListPerPangkat(){
        $gol = $this->input->post('golongan');
        $this->load->model('Pegawai_model','pegawai');
        $query = $this->pegawai->getListPerPangkat($gol);
        $data = $query->result();
        $data = array(	'code'=>200,
            'status'=>'success',
            'title'=>'Tampilkan List Pegawai Berdasarkan Pangkat Tertentu',
            'data'=>$data,
            'rel'=>'child'
        );

        echo json_encode($data);
    }

    function ListPerStruktural(){
        $eselon = $this->input->post('eselon');
        $this->load->model('Pegawai_model','pegawai');
        $query = $this->pegawai->getListPerStruktural($eselon);
        $data = $query->result();
        $data = array(	'code'=>200,
            'status'=>'success',
            'title'=>'Tampilkan List Pegawai Berdasarkan Jenjang Struktural Tertentu',
            'data'=>$data,
            'rel'=>'child'
        );

        echo json_encode($data);
    }

    function ListPerBidangPendidikan(){
        $idbidang = $this->input->post('idbidang');
        $this->load->model('Pegawai_model','pegawai');
        $query = $this->pegawai->getListPerBidangPendidikan($idbidang);
        $data = $query->result();
        $data = array(	'code'=>200,
            'status'=>'success',
            'title'=>'Tampilkan List Pegawai Berdasarkan Jenjang Struktural Tertentu',
            'data'=>$data,
            'rel'=>'child'
        );

        echo json_encode($data);
    }

    function ListPerLevelPendidikan(){
        $level = $this->input->post('level');
        $this->load->model('Pegawai_model','pegawai');
        $query = $this->pegawai->getListPerLevelPendidikan($level);
        $data = $query->result();
        $data = array(	'code'=>200,
            'status'=>'success',
            'title'=>'Tampilkan List Pegawai Berdasarkan Jenjang Struktural Tertentu',
            'data'=>$data,
            'rel'=>'child'
        );

        echo json_encode($data);
    }

    function ListPegawaiByOPD($opd){
        $this->load->model('Pegawai_model','pegawai');
        $query = $this->pegawai->getListPegawaiOPD($opd);
        $data = $query->result();
        $data = array(	'code'=>200,
            'status'=>'success',
            'title'=>'Menampilkan List Pegawai Berdasarkan OPD tertentu',
            'data'=>$data,
            'rel'=>'child'
        );

        echo json_encode($data);
    }

    function ListPegawaiTanahSareal(){
        $this->load->model('Pegawai_model','pegawai');
        $query = $this->pegawai->getListPegawaiOPD(5172);
        $data = $query->result();
        $data = array(	'code'=>200,
            'status'=>'success',
            'title'=>'Tampilan List Pegawai Kecamatan Tanah Sareal',
            'data'=>$data,
            'rel'=>'child'
        );
        echo json_encode($data);
    }

    function get_ref_golongan(){
        $query = $this->pegawai->getGolongan();
        $data = $query->result();
        $data = array('code'=>200,
            'status'=>'success',
            'title'=>'Data List Nama Golongan',
            'data'=>$data,
            'rel'=>'self'
        );
        echo json_encode($data);
    }

    function get_jumlah_pegawai(){
        $query = $this->pegawai->getJumlahPegawai();
        $data = $query->result();
        $data = array('code'=>200,
            'status'=>'success',
            'title'=>'Jumlah Pegawai',
            'data'=>$data,
            'rel'=>'self'
        );
        echo json_encode($data);
    }

    function get_list_pegawai_apps_bisa($limit_awal, $limit_akhir){
	    if(isset($limit_awal) and $limit_awal!=''){
            $limit_awal = $limit_awal;
        }else{
            $limit_awal = $this->input->get('limit_awal');
        }

        if(isset($limit_akhir) and $limit_akhir!=''){
            $limit_akhir = $limit_akhir;
        }else{
            $limit_akhir = $this->input->get('limit_akhir');
        }

        $query = $this->pegawai->listPegawaiAppsBisa($limit_awal, $limit_akhir, $this->keyApps);
        $data = $query->result();
        $data = array(	'code'=>200,
            'status'=>'success',
            'title'=>'Daftar List Pegawai',
            'data'=>$data,
            'rel'=>'self'
        );
        echo json_encode($data);
    }

    function update_ponsel_email_pegawai(){
        $data = array(
            'ponsel' => $this->input->post('ponsel'),
            'email' => $this->input->post('email'),
            'nip' => $this->input->post('nip_enc')
        );
        $query = $this->pegawai->updatePonselEmailPegawai($data, $this->keyApps);
        if ($query > 0) {
            $result = $this->transaksi_sukses();
        } else {
            $result = $this->transaksi_gagal();
        }
        echo json_encode($result);
    }

    function get_pegawai_spesifik_kominfo(){
        $query = $this->pegawai->daftar_pegawai_spesifik_kominfo();
        $data = $query->result();
        $data = array(	'code'=>200,
            'status'=>'success',
            'title'=>'Daftar List Pegawai Spesifik Kominfo',
            'data'=>$data,
            'rel'=>'self'
        );
        echo json_encode($data);
    }

    function get_pegawai_spesifik_organisasi(){
        $query = $this->pegawai->daftar_pegawai_spesifik_organisasi();
        $data = $query->result();
        $data = array(	'code'=>200,
            'status'=>'success',
            'title'=>'Daftar List Pegawai Spesifik Organisasi',
            'data'=>$data,
            'rel'=>'self'
        );
        echo json_encode($data);
    }

	function failed(){
		$fail = array(array('nama'=>NULL,
					'nip'=>NULL,
					'password'=>NULL,
					'id_jabatan'=>NULL,
					'jabatan'=>NULL,
					'eselonering'=>NULL,
					'id_unit_kerja'=>NULL,
					'unit_kerja'=>NULL,
					'request_status'=>'102'
				));
			echo json_encode($fail);
	}

    function transaksi_sukses($id=null, $id2=null, $msg=null){
        $data = array('code'=>200,
            'status'=>'success',
            'title'=>'Data sukses tersimpan',
            'id'=>$id,
            'id2'=>$id2,
            'msg'=>$msg,
            'rel'=>'self'
        );
        return $data;
    }

    function transaksi_gagal($ket=null){
        $data = array('code'=>201,
            'status'=>'not success',
            'title'=>'Data tidak sukses tersimpan'.$ket,
            'rel'=>'self'
        );
        return $data;
    }

    function get_masa_kerja($id_pegawai){
	    if($id_pegawai==''){
            $id_pegawai = $this->input->get('id_pegawai');
        }
      $this->load->library('format');
      //$id_pegawai = $this->input->post('id_pegawai');

      if($this->pegawai->get_cpns($id_pegawai)){
  			$baris = $this->pegawai->get_cpns($id_pegawai);

  		}elseif($this->pegawai->get_pns($id_pegawai)){
  			$baris = $this->pegawai->get_pns($id_pegawai);
  		}else{
  			echo "<div class='error'>DATA CPNS/PNS TIDAK DITEMUKAN ..<div>";
  			exit;
  		}
      $gol_cpns = $baris->gol;

     list($tmt_thn,$tmt_bln,$tmt_tgl) = explode("-",$baris->tmt);

     $timestamp = mktime(0,0,0,$tmt_bln - $baris->mk_bulan,$tmt_tgl,$tmt_thn - $baris->mk_tahun);
     $masakerja = $this->format->datediff(date('Y-m-d'),date('Y-m-d',$timestamp));

     if(! preg_match("*/*",$gol_cpns)){
    echo "Gagal menghitung masa kerja golongan, harap periksa riwayat golongan cpns";
    exit;
  }

     list($gol_awal,$ruang_awal) = explode('/',$gol_cpns);
      $gol_sekarang = $this->db->get_where('pegawai',array('id_pegawai'=>$id_pegawai))->row()->pangkat_gol;
      list($gol,$ruang) = explode('/',$gol_sekarang);

      if($gol_awal == 'II' && $gol == 'IV'){
        $tahun_gol = $masakerja['years'] - 5;
      }elseif($gol_awal == 'II' && $gol == 'III'){
        $tahun_gol = $masakerja['years'] - 5;

      }elseif($gol_awal == 'I' && $gol == 'III'){
        $tahun_gol = $masakerja['years'] - 11;
      }elseif($gol_awal == 'I' && $gol == 'II'){
        $tahun = $masakerja['years'] - 6;
      }else{
        $tahun_gol = $masakerja['years'];
      }

      $data = array('code'=>200,
          'status'=>'success',
          'mk_tahun'=>$masakerja['years'],
          'mk_bulan'=>$masakerja['months'],
          'mkg_tahun'=>$tahun_gol,
          'mkg_bulan'=>$masakerja['months'],
          'rel'=>'self'
      );
      echo json_encode($data);

    }



    /*public function import($json){
        $this->load->model('Pegawai_model','pegawai');
        //$json = json_decode($json);

        /*$json = json_encode(
            array(
                0 => array(
                    'English' => array('One', 'January'),
                    'French' => array('Une', 'Janvier')
                )
            )
        );

        $a = json_decode($json, true);
        for($i=0;$i<sizeof($a);$i++){
            print_r($a).'<br>';
        }
    }*/


}
