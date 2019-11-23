<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Stat extends CI_Controller{	
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
	
	public function pendidikan(){
		$this->load->model('Pendidikan_model','pendidikan');	
		$query = $this->pendidikan->get_stat();
		$data = $query->result();	
		$data = array(	'code'=>200,
						'status'=>'success',
						'title'=>'Statistik Berdasarkan Tingkat Pendidikan',
						'data'=>$data,
						'rel'=>'self'
						);			
		echo json_encode($data);
	}

	public function pendidikanPerOPD(){
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
					$this->load->model('Pendidikan_model','pendidikan');
					$query = $this->pendidikan->getPendidikanPerOPD($id_unit_kerja);
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
				'title'=>'Statistik Berdasarkan Pendidikan Per Unit Kerja',
				'data'=>$data,
				'rel'=>'self'
		);
		echo json_encode($data);
	}
	
	public function golongan(){
		$this->load->model('Golongan_model','golongan');
		$query = $this->golongan->get_stat();
		$data = $query->result();
		$data = array(	'code'=>200,
						'status'=>'success',
						'title'=>'Statistik Berdasarkan Golongan',
						'data'=>$data,
						'rel'=>'self'
						);							
		echo json_encode($data);
	}
	
	public function usia(){
		$this->load->model('Pegawai_model','pegawai');
		$query = $this->pegawai->get_stat_usia();
		$data = $query->result();
		$data = array(	'code'=>200,
						'status'=>'success',
						'title'=>'Statistik Berdasarkan Usia',
						'data'=>$data,
						'rel'=>'self'
						);
													
		echo json_encode($data);
		
	}
	
	public function usiaPerOpd(){
		$this->load->model('Pegawai_model','pegawai');
		$query = $this->pegawai->get_stat_usia_per_opd();
		$data = $query->result();
		$data = array(	'code'=>200,
						'status'=>'success',
						'title'=>'Rekapitulasi Pegawai Berdasarkan Usia Per OPD',
						'data'=>$data,
						'rel'=>'self'
						);						
		echo json_encode($data);
	}
	
	public function jk(){
		$this->load->model('Pegawai_model','pegawai');
		$query = $this->pegawai->get_stat_jk();
		$data = $query->result();
		$data = array(	'code'=>200,
						'status'=>'success',
						'title'=>'Statistik Berdasarkan Jenis Kelamin',
						'data'=>$data,
						'rel'=>'self'
						);					
		echo json_encode($data);
	}
	
	public function rekapPerOpd(){
		$this->load->model('Unit_kerja_model','unit_kerja');
		$query = $this->unit_kerja->get_stat();
		$data = $query->result();
		$data = array(	'code'=>200,
						'status'=>'success',
						'title'=>'Rekap Pegawai per OPD',
						'data'=>$data,
						'rel'=>'self'
						);				
		echo json_encode($data);
	}

	public function rekapPerOpdUnitKerja(){
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
					$this->load->model('Unit_kerja_model','unit_kerja');
					$query = $this->unit_kerja->get_stat_per_unit($id_unit_kerja);
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
				'title'=>'Rekap Pegawai per Unit Kerja',
				'data'=>$data,
				'rel'=>'self'
		);
		echo json_encode($data);
	}

	public function RekapByJenjab(){
		$this->load->model('Jabatan_model','Jabatan');
		$query = $this->Jabatan->getRekapByJenjab();
		$data = $query->result();
		$data = array(	'code'=>200,
				'status'=>'success',
				'title'=>'Rekap Pegawai per Jenjang Jabatan',
				'data'=>$data,
				'rel'=>'self'
		);
		echo json_encode($data);
	}

	public function RekapByJenjabPerOPD(){
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
					$this->load->model('Jabatan_model','Jabatan');
					$query = $this->Jabatan->getRekapByJenjabPerOPD($id_unit_kerja);
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
				'title'=>'Rekap Berdasarkan Jenjang Jabatan per Unit Kerja',
				'data'=>$data,
				'rel'=>'self'
		);
		echo json_encode($data);
	}

	public function RekapByFungsional(){
		$this->load->model('Jabatan_model','Jabatan');
		$query = $this->Jabatan->getRekapByFungsional();
		$data = $query->result();
		$data = array(	'code'=>200,
				'status'=>'success',
				'title'=>'Rekap Pegawai per Jabatan Fungsional',
				'data'=>$data,
				'rel'=>'self'
		);
		echo json_encode($data);
	}

	public function RekapByFungsionalPerOPD(){
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
				if($valid==true) {
					$this->load->model('Jabatan_model', 'Jabatan');
					$query = $this->Jabatan->getRekapByFungsionalPerOPD($id_unit_kerja);
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
				'title'=>'Rekap Berdasarkan Fungsional per Unit Kerja',
				'data'=>$data,
				'rel'=>'self'
		);
		echo json_encode($data);
	}

	public function RekapByStruktural(){
		$this->load->model('Jabatan_model','Jabatan');
		$query = $this->Jabatan->getRekapByStruktural();
		$data = $query->result();
		$data = array(	'code'=>200,
				'status'=>'success',
				'title'=>'Rekap Pegawai per Jabatan Struktural',
				'data'=>$data,
				'rel'=>'self'
		);
		echo json_encode($data);
	}

	public function RekapByStrukturalPerOPD(){
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
				if($valid==true) {
					$this->load->model('Jabatan_model', 'Jabatan');
					$query = $this->Jabatan->getRekapByStrukturalPerOPD($id_unit_kerja);
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
				'title'=>'Rekap Berdasarkan Jabatan Struktural per OPD',
				'data'=>$data,
				'rel'=>'self'
		);
		echo json_encode($data);
	}

	public function RekapBySmartphone(){
		$this->load->model('Pegawai_model','Pegawai');
		$query = $this->Pegawai->getRekapBySmartphone();
		$data = $query->result();
		$data = array(	'code'=>200,
				'status'=>'success',
				'title'=>'Rekap per Survey Smartphone',
				'data'=>$data,
				'rel'=>'self'
		);
		echo json_encode($data);
	}

	public function RekapBySmartphonePerOPD(){
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
				if($valid==true) {
					$this->load->model('Pegawai_model', 'Pegawai');
					$query = $this->Pegawai->getRekapBySmartphonePerOPD($id_unit_kerja);
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
				'title'=>'Rekap Berds. Survey Smartphone Per Unit Kerja',
				'data'=>$data,
				'rel'=>'self'
		);
		echo json_encode($data);
	}

	public function RekapPerBidangPendidikan(){
		$this->load->model('Pendidikan_model','Pendidikan');
		$query = $this->Pendidikan->getRekapPerBidangPendidikan();
		$data = $query->result();
		$data = array(	'code'=>200,
				'status'=>'success',
				'title'=>'Rekap per Bidang Pendidikan',
				'data'=>$data,
				'rel'=>'self'
		);
		echo json_encode($data);
	}

	public function RekapPerBidangPendidikanPerOPD(){
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
					$this->load->model('Pendidikan_model','Pendidikan');
					$query = $this->Pendidikan->getRekapPerBidangPendidikanPerOPD($id_unit_kerja);
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
				'title'=>'Rekap Berds. Bidang Pendidikan Per Unit Kerja',
				'data'=>$data,
				'rel'=>'self'
		);
		echo json_encode($data);
	}

	public function RekapPerDiklatPIM(){
		$this->load->model('Pegawai_model','pegawai');
		$query = $this->pegawai->getRekapDiklatPIM();
		$data = $query->result();
		$data = array(	'code'=>200,
				'status'=>'success',
				'title'=>'Rekap per Diklat PIM',
				'data'=>$data,
				'rel'=>'self'
		);
		echo json_encode($data);
	}

	public function RekapPerDiklatPIMPerOPD(){
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
					$this->load->model('Pegawai_model','Pegawai');
					$query = $this->Pegawai->getRekapDiklatPIMPerOPD($id_unit_kerja);
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
				'title'=>'Rekap Diklat PIM Per OPD',
				'data'=>$data,
				'rel'=>'self'
		);
		echo json_encode($data);
	}

	public function RekapNonPNS(){
        $this->load->model('Pegawai_model','Pegawai');
        $query = $this->Pegawai->getRekapNonPNS();
        $data = $query->result();
        $data = array(	'code'=>200,
            'status'=>'success',
            'title'=>'Rekap Pegawai Non PNS',
            'data'=>$data,
            'rel'=>'self'
        );
        echo json_encode($data);
    }

    public function RekapNonPNSK1(){
        $this->load->model('Pegawai_model','Pegawai');
        $query = $this->Pegawai->getRekapNonPNSByStatus(2);
        $data = $query->result();
        $data = array(	'code'=>200,
            'status'=>'success',
            'title'=>'Rekap Pegawai Non PNS K1',
            'data'=>$data,
            'rel'=>'self'
        );
        echo json_encode($data);
    }

    public function RekapNonPNSK2(){
        $this->load->model('Pegawai_model','Pegawai');
        $query = $this->Pegawai->getRekapNonPNSByStatus(1);
        $data = $query->result();
        $data = array(	'code'=>200,
            'status'=>'success',
            'title'=>'Rekap Pegawai Non PNS K2',
            'data'=>$data,
            'rel'=>'self'
        );
        echo json_encode($data);
    }

    public function RekapAbsensiPegawaiAllOPD(){
        $bln = $this->input->post('bln');
        $thn = $this->input->post('thn');
        $this->load->model('Pegawai_model','Pegawai');
        if($bln <> '' and $thn <> ''){
            $query = $this->Pegawai->getRekapAbsensi_UntukSemuaOPD($bln,$thn);
            $data = $query->result();
        }else{
            $data = null;
        }
        $data = array(	'code'=>200,
            'status'=>'success',
            'title'=>'Informasi Rekapitulasi Absensi Pegawai untuk Semua OPD',
            'data'=>$data,
            'rel'=>'self'
        );
        echo json_encode($data);
    }

    public function RekapAbsensiPegawaiPerOPD(){
        $bln = $this->input->post('bln');
        $thn = $this->input->post('thn');
        $idopd = $this->input->post('idopd');
        $this->load->model('Pegawai_model','Pegawai');
        if($bln <> '' and $thn <> '' and $idopd <> ''){
            $query = $this->Pegawai->getRekapAbsensi_UntukPerOPD($bln,$thn,$idopd);
            $data = $query->result();
        }else{
            $data = null;
        }
        $data = array(	'code'=>200,
            'status'=>'success',
            'title'=>'Informasi Rekapitulasi Absensi Pegawai untuk OPD tertentu',
            'data'=>$data,
            'rel'=>'self'
        );
        echo json_encode($data);
    }

    public function ListDetailPegawaiAbsensiByStatus(){
        $bln = $this->input->post('bln');
        $thn = $this->input->post('thn');
        $idopd = $this->input->post('idopd');
        $status = $this->input->post('status');
        $this->load->model('Pegawai_model','Pegawai');
        if($bln <> '' and $thn <> '' and $idopd <> '' and $status <> ''){
            $query = $this->Pegawai->getListDetailPegawai_Absensi_ByStatus($bln,$thn,$idopd,$status);
            $data = $query->result();
        }else{
            $data = null;
        }
        $data = array(	'code'=>200,
            'status'=>'success',
            'title'=>'Informasi Daftar Pegawai Absensi untuk OPD tertentu',
            'data'=>$data,
            'rel'=>'self'
        );
        echo json_encode($data);
    }

    public function RekapWaktuKehadiranAbsensi(){
        $idopd = $this->input->post('idopd');
        $bln = $this->input->post('bln');
        $thn = $this->input->post('thn');
        $this->load->model('Pegawai_model','Pegawai');
        if($idopd <> '' and $bln <> '' and $thn<>''){
            $query = $this->Pegawai->getRekapWaktu_Kehadiran_Absensi($idopd,$bln,$thn);
            $data = $query->result();
        }else{
            $data = null;
        }
        $data = array(	'code'=>200,
            'status'=>'success',
            'title'=>'Informasi Rekapitulasi Waktu Kehadiran Pegawai',
            'data'=>$data,
            'rel'=>'self'
        );
        echo json_encode($data);
    }

	
}
