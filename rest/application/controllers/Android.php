<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Android extends CI_Controller{
	public function index(){

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


	public function rekap_bidangpendidikan(){
		$this->load->model('Android_model','android');
		$query = $this->android->getRekapBidangPendidikan();
		$data = $query->result();
		$data = array(	'code'=>200,
						'status'=>'success',
						'title'=>'Rekap Bidang Pendidikan',
						'data'=>$data,
						'rel'=>'self'
						);
		echo json_encode($data);
	}

	public function rekap_fungsional(){
		$this->load->model('Android_model','android');
		$query = $this->android->getRekapFungsional();
		$data = $query->result();
		$data = array(	'code'=>200,
						'status'=>'success',
						'title'=>'Rekap Fungsional',
						'data'=>$data,
						'rel'=>'self'
						);
		echo json_encode($data);
	}

	public function rekap_golongan(){
		$this->load->model('Android_model','android');
		$query = $this->android->getRekapGolongan();
		$data = $query->result();
		$data = array(	'code'=>200,
						'status'=>'success',
						'title'=>'Rekap Golongan',
						'data'=>$data,
						'rel'=>'self'
						);
		echo json_encode($data);
	}

	public function rekap_jenjab(){
		$this->load->model('Android_model','android');
		$query = $this->android->getRekapJenjab();
		$data = $query->result();
		$data = array(	'code'=>200,
						'status'=>'success',
						'title'=>'Rekap Per Jenjang Jabatan',
						'data'=>$data,
						'rel'=>'self'
						);
		echo json_encode($data);
	}

	public function rekap_jenkel(){
		$this->load->model('Android_model','android');
		$query = $this->android->getRekapJenkel();
		$data = $query->result();
		$data = array(	'code'=>200,
						'status'=>'success',
						'title'=>'Rekap Per Jenis Kelamin',
						'data'=>$data,
						'rel'=>'self'
						);
		echo json_encode($data);
	}

	public function rekap_jenkel_per_opd(){
		$key = $this->input->post('key');
		$this->load->model('Unit_kerja_model','Unit');
		if(isset($key) and $key <> ''){
			$opd = $this->Unit->get_unit();
			$rowcount = $opd->num_rows();
			if($rowcount>0){
				$recOpd = $opd->result();
				foreach ($recOpd as $lsdata){
					if(md5($lsdata->id_unit_kerja.$lsdata->unit_kerja.$lsdata->tahun)==$key){
						$id_unit_kerja = $lsdata->id_unit_kerja;
						$valid = true;
						break;
					}else{
						$valid = false;
					}
				}
				if($valid==true){
					$this->load->model('Android_model','android');
					$query = $this->android->getRekapJenkelPerOPD($id_unit_kerja);
					$data = $query->result();
				}else{
					$data = null;
				}
			}else{
				$data = null;
			}
		}else{
			$data = null;
		}

		$data = array(	'code'=>200,
				'status'=>'success',
				'title'=>'Rekap Berds. Jenis Kelamin Per Unit Kerja',
				'data'=>$data,
				'rel'=>'self'
		);
		echo json_encode($data);
	}

	public function rekap_lulusanpt(){
		$this->load->model('Android_model','android');
		$query = $this->android->getRekapLulusanPt();
		$data = $query->result();
		$data = array(	'code'=>200,
						'status'=>'success',
						'title'=>'Rekap Per Lulusan Perguruan Tinggi',
						'data'=>$data,
						'rel'=>'self'
						);
		echo json_encode($data);
	}

	public function rekap_lulusanpt_per_opd(){
		$key = $this->input->post('key');
		$this->load->model('Unit_kerja_model','Unit');
		if(isset($key) and $key <> ''){
			$opd = $this->Unit->get_unit();
			$rowcount = $opd->num_rows();
			if($rowcount>0){
				$recOpd = $opd->result();
				foreach ($recOpd as $lsdata){
					if(md5($lsdata->id_unit_kerja.$lsdata->unit_kerja.$lsdata->tahun)==$key){
						$id_unit_kerja = $lsdata->id_unit_kerja;
						$valid = true;
						break;
					}else{
						$valid = false;
					}
				}
				if($valid==true){
					$this->load->model('Android_model','android');
					$query = $this->android->getRekapLulusanPtPerOPD($id_unit_kerja);
					$data = $query->result();
				}else{
					$data = null;
				}
			}else{
				$data = null;
			}
		}else{
			$data = null;
		}
		$data = array(	'code'=>200,
				'status'=>'success',
				'title'=>'Rekap Berds. Lulusan Perguruan Tinggi Per Unit Kerja',
				'data'=>$data,
				'rel'=>'self'
		);
		echo json_encode($data);
	}

	public function rekap_pendidikan(){
		$this->load->model('Android_model','android');
		$query = $this->android->getRekapPendidikan();
		$data = $query->result();
		$data = array(	'code'=>200,
						'status'=>'success',
						'title'=>'Rekap Per Pendidikan',
						'data'=>$data,
						'rel'=>'self'
						);
		echo json_encode($data);
	}

	public function rekap_strukturaleselon(){
		$this->load->model('Android_model','android');
		$query = $this->android->getRekapStrukturalEselon();
		$data = $query->result();
		$data = array(	'code'=>200,
						'status'=>'success',
						'title'=>'Rekap Per Struktural',
						'data'=>$data,
						'rel'=>'self'
						);
		echo json_encode($data);
	}

	public function rekap_umur(){
		$this->load->model('Android_model','android');
		$query = $this->android->getRekapUmur();
		$data = $query->result();
		$data = array(	'code'=>200,
						'status'=>'success',
						'title'=>'Rekap Per Umur',
						'data'=>$data,
						'rel'=>'self'
						);
		echo json_encode($data);
	}

	public function getattendance(){
		/*$this->load->model('Android_model','android');

		if(!$this->input->post('id_pegawai')){
			echo json_encode(array());
			die;
		}else{
			$id_pegawai = $this->input->post('id_pegawai');
		}
		$query = $this->android->get_attendance($id_pegawai);
		$data = $query->result();
		$rs = array();
		foreach($data as $d){
			$d->request_status = 100;
			$rs[] = $d;
		}*/

		$rs = Array();
                $r = new \stdClass;
                $r->id = '0';
                $r->id_pegawai = '0';
                $r->date_time = '0000-00-00 00:00:00';
                $r->status = "TOLONG UPDATA APLIKASI";
                $r->longitude = '0';
                $r->latitude ='0';
                $r->request_status = '100';
                $rs[] = $r;
                echo json_encode($rs);
	}

	public function getcomments(){
		$this->load->model('Android_model','android');
		if(!$this->input->post('parent_id')){
			$parent_id = NULL;
		}else{
			$parent_id = $this->input->post('parent_id');
		}
		$query = $this->android->get_comments($parent_id);
		$data = $query->result();

		echo json_encode($data);
	}

	public function count_komentar($parent_id){
		$this->load->model('Android_model','android');
		//$parent_id = $this->input->post('parent_id');
		$query = $this->android->get_jumlah_komentar($parent_id);
		$data = $query->result();
		return $data[0]->jumlah_komentar;
	}

	public function login(){
		$this->load->model('Android_model','android');
		$imei = $this->input->post('imei');
		$nip = $this->input->post('nip');
		$password = $this->input->post('password');

		if($imei !='')
		{

			$qvar = $this->android->is_exist_imei($password, $nip);
			foreach($qvar->result() as $data);
			$dataimeidb = $data->imei;

			if($dataimeidb =='')
			{
				//update imei
				$umi = $this->android->set_imei($imei,$nip);
				if($umi)
				{
					$res = $this->android->get_pegawai($nip,$imei)->result();
				}
				else
				{
					$res = array("request_status"=>"111");
				}
			}
			else
			{
				if($imei == $dataimeidb)
				{
					//valid
					$res = $this->android->get_pegawai($nip,$imei)->result();
				}
				else
				{
					//tidak valid
					$res = array();
				}
			}

		}
		else
		{
			$res = array();
		}

		echo json_encode($res);

	}

	public function postkehadiran(){
		/*$nip = $this->input->post("nip");
		$password = $this->input->post("password");
		$id_pegawai = $this->input->post("id_pegawai");
		$imei = $this->input->post("imei");
		$longitude = $this->input->post("longitude");
		$latitude = $this->input->post("latitude");
		$api_key = $this->input->post("api_key");

		//validate nip
		if(!$this->validate_nip($nip)){
			echo json_encode(array(array( 'request_status' => 102 )));
			return;
		}

		//validate password

		if(!$this->validate_password($nip, $password)){
			echo json_encode(array(array( 'request_status' => 103 )));
			return;
		}

		//validate imei
		if(!$this->validate_imei($nip, $imei)){
			echo json_encode(array(array( 'request_status' => 106 )));
			return;
		}

		//load today attendant log
		if($r = $this->load_today_attendance($id_pegawai)){
			// sudah pernah absen hari ini.
			//echo json_encode(array(array( 'request_status' => 109 )));
			$s_jam_absen = date("Y-m-d h:i:s");
			$status = "TERCATAT";
			//$this->load->model('Android_model', 'android');
			$affected_rows = $this->android->add_attendance($id_pegawai, $s_jam_absen, $status, $latitude, $longitude);
			echo json_encode(array(array( 'request_status' => 100 )));
			return;
		}
		else{
			//date_default_timezone_set('Asia/Jakarta');
			$s_jam_masuk = date("Y-m-d ").$this->config->item('jam_masuk_non_shift');
			$s_jam_absen = date("Y-m-d h:i:s");
			$jam_masuk = strtotime($s_jam_masuk);
			$jam_absen = strtotime($s_jam_absen);

			$delta = round(($jam_masuk - $jam_absen) / 60);
			$status = "";

			if($delta >= 0){
				$status = "PRESENT";
			}
			else{
				$status = "LATE";
			}
			$status = "TERCATAT";

			$this->load->model('Android_model', 'android');
			$affected_rows = $this->android->add_attendance($id_pegawai, $s_jam_absen, $status, $latitude, $longitude);

			if($affected_rows > 0){
				if($status == 'PRESENT')
					echo json_encode(array(array( 'request_status' => 100 ))); // On time
				else
					echo json_encode(array(array( 'request_status' => 100 ))); // 107 Terlambat
				return;
			}
			else{
				print_r("INSERT to oasys_attendance_log failed!");
				return;
			}
		}*/
	}

	private function load_today_attendance($id_pegawai){
		$this->load->model('Android_model', 'android');
		$rs = $this->android->get_today_attendance($id_pegawai);
		return $rs;
	}

	private function validate_imei($nip, $imei){
		$this->load->model('Pegawai_model', 'pegawai');
		$rs = $this->pegawai->get_profil($nip);

		$r = $rs->result();
		$r = $r[0];

		if($r->imei == null){
			$this->db->where('nip_baru',$nip);
			$this->db->update('pegawai',array('imei'=>$imei));
			return 1;
		}else if($r->imei == $imei){
			return 1;
		}
		else{
			return 0;
		}
	}

	private function validate_password($nip, $password){
		$this->load->model('Pegawai_model', 'pegawai');
		$rs = $this->pegawai->get_profil($nip);

		$r = $rs->result();
		$r = $r[0];
		if($r->password == $password){
			return 1;
		}
		else{
			return 0;
		}
	}

	private function validate_nip($nip){
		$this->load->model('Pegawai_model', 'pegawai');
		$rs = $this->pegawai->get_profil($nip);
		if(sizeof($rs->result()) > 0){
			return 1;
		}
		else{
			return 0;
		}
	}

	public function getlocationuk(){
		/*$this->load->model('Android_model','android');

		$id_pegawai = $this->input->post('id_pegawai');
		$api_key = $this->input->post('api_key');
		$query = $this->android->get_location_uk($id_pegawai);
		$data = $query->result();
		$data[0]->request_status = 100;
		echo json_encode($data);*/
	}

	public function gettimeline(){
		$this->load->model('Android_model','android');
		$query = $this->android->get_timeline();
		$data = $query->result();
		/*$data = array(	'code'=>200,
						'status'=>'success',
						'title'=>'Lokasi Unit Kerja',
						'data'=>$data,
						'rel'=>'self'
						);*/
		//$data = array($data);
		$res = array();
		foreach($data as $d){
			$d->jml_komentar = $this->count_komentar($d->id_post);
			$res[] = $d;
		}
		echo json_encode($res);
	}

	public function addcomments(){
		$this->load->model('Android_model','android');
		$msg = $this->input->post('msg');
		$id_pegawai = $this->input->post('id_pegawai');
		$parent_id = $this->input->post('parent_id');
		$query = $this->android->add_comments($msg, $id_pegawai, $parent_id);
		if($query){
			$data = array(array( 'request_status' => '100' ));
		}
		echo json_encode($data);
	}

	public function loginarchive(){
		$this->load->model('Android_model','android');
		$nip = $this->input->post('nip');
		$password = $this->input->post('password');
		$query = $this->android->login_archive($nip, $password);
		if($query != FALSE){
			$login = FALSE;
			foreach($query->result() as $users){
					$response["error"] = FALSE;
					$response["user"]["idp"] = $users->id_pegawai;
					$response["user"]["nip"] = $users->nip_baru;
					$response["user"]["nama"] = $users->nama;
					$response["user"]["unit_kerja"] = $users->unit_kerja;
					$login = TRUE;
			}
			if($login==TRUE){
					echo json_encode($response);
			}else{
					$response["error"] = TRUE;
					$response["error_msg"] = "Login gagal. NIP atau Password salah!";
					echo json_encode($response);
			}
		}else{
			$response["error"] = TRUE;
			$response["error_msg"] = "Login gagal. Silahkan coba lagi!";
			echo json_encode($response);
		}
	}

	public function getinfopegawaiByNip(){
		$this->load->model('Android_model','android');
		$nip = $this->input->post('nip');
		//$nip   = urldecode($_POST['nip']);
		$query = $this->android->get_infopegawai_bynip($nip);
		if($query != FALSE){
			$i = 0;
			foreach($query->result() as $p){
				$nama = $p->nama;
				$gol = $p->pangkat_gol;
				$jabatan = $p->jabatan;
				$unit = $p->unit;
				$i++;
			}
			if($i>0){
				echo "<font size='13px' color='#4169e1'><strong>".$nama.'</strong></font>'.'<br> Pangkat: '.
				$gol.'<br>'.$jabatan.'<br>'.$unit;
			}else{
				echo 'Data tidak ditemukan';
			}
		}else{
			echo 'Ada kesalahan saat request data pada server';
		}
	}

    public function getinfopegawaiByNip2(){
        $nip = $this->input->post('nip');
        $this->load->model('android_model','android');
        if($nip <> ''){
            $query = $this->android->get_infopegawai_bynip_2($nip);
            $rowcount = $query->num_rows();
            if($rowcount > 0) {
                $data = $query->result();
            }else{
                $data = null;
            }
        }else{
            $data = null;
        }
        $data = array(	'code'=>200,
            'status'=>'success',
            'title'=>'Informasi Pegawai',
            'data'=>$data,
            'rel'=>'self'
        );
        echo json_encode($data);
    }

    public function getinfopegawaiByEmail(){
        $email = $this->input->post('email');
        $this->load->model('android_model','android');
        if($email <> ''){
            $query = $this->android->get_infopegawai_by_email($email);
            $rowcount = $query->num_rows();
            if($rowcount > 0) {
                $data = $query->result();
            }else{
                $data = null;
            }
        }else{
            $data = null;
        }
        $data = array(	'code'=>200,
            'status'=>'success',
            'title'=>'Informasi Pegawai',
            'data'=>$data,
            'rel'=>'self'
        );
        echo json_encode($data);
    }

    /*public function hadir(){
		$this->load->model('Android_model','android');
		$id_pegawai = $this->input->post('id_pegawai');
		$nip = $this->input->post('nip');
		$password = $this->input->post('password');
		$latitude = $this->input->post('latitude');
		$longitude = $this->input->post('longitude');
		$imei = $this->input->post('imei');
		$api_key = $this->input->post('api_key');

		if($this->android->get_absensi_riwayat_today($id_pegawai)){
			$data = array();
		}else{
			$data = $this->android->insert_absensi($id_pegawai, $longitude, $latitude);
		}

		echo json_encode($data);
	}*/

    /*public function getjmlkomentar(){
		$this->load->model('Android_model','android');
		$parent_id = $this->input->post('parent_id');
		$query = $this->android->get_jumlah_komentar($parent_id);
		$data = $query->result();
		echo json_encode($data);
	}*/

    /*public function addmessage(){
		$this->load->model('Android_model','android');
		$msg = $this->input->post('msg');
		$id_pegawai = $this->input->post('id_pegawai');
		$query = $this->android->add_message($msg, $id_pegawai);
	}*/

    /*public function viewunitkerja(){
        $this->load->model('Android_model','android');
        $query = $this->android->view_unit_kerja();
        $data = $query->result();

        echo json_encode($data);
    }*/


}
