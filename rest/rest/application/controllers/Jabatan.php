<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Jabatan extends CI_Controller{
	

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
	
	public function getAll(){
        $this->load->model('jabatan_model', 'jabatan');
        $result = $this->jabatan->getAll()->result();

        $data = array(	'code'=>200,
            'status'=>'success',
            'title'=>'Daftar Nama Jabatan',
            'data'=>$result,
            'rel'=>'self'
        );

        echo json_encode($data);

	}
	
	
	public function idkel(){
        $this->load->model('jabatan_model', 'jabatan');
        $result = $this->jabatan->idkel()->result();

        $data = array(	'code'=>200,
            'status'=>'success',
            'title'=>'Daftar Nama Kelurahan',
            'data'=>$result,
            'rel'=>'self'
        );

        echo json_encode($data);

	}

    public function jkel($idkel){
        $this->load->model('jabatan_model', 'jabatan');
        $result = $this->jabatan->jkel($idkel)->result();
        $data = array(	'code'=>200,
            'status'=>'success',
            'title'=>'Daftar Nama Jabatan',
            'data'=>$result,
            'rel'=>'self'
        );
        echo json_encode($data);

    }

    public function esurat_jabatan(){
        $this->load->model('jabatan_model', 'jabatan');
        $result = $this->jabatan->esurat_jabatan()->result();
        $data = array(	'code'=>200,
            'status'=>'success',
            'title'=>'Daftar Nama Jabatan',
            'data'=>$result,
            'rel'=>'self'
        );
        echo json_encode($data);
    }

    public function getByTahun($thn=0){
        $this->load->model('jabatan_model', 'jabatan');
        $result = $this->jabatan->getByTahun($thn)->result();
        $data = array(	'code'=>200,
            'status'=>'success',
            'title'=>'Daftar Nama Jabatan',
            'data'=>$result,
            'rel'=>'self'
        );

        echo json_encode($data);

    }

    public function getByOpd($id_skpd){
        $this->load->model('jabatan_model', 'jabatan');
        $result = $this->jabatan->getByOpd($id_skpd)->result();
        $data = array(	'code'=>200,
            'status'=>'success',
            'title'=>'Daftar Nama Jabatan Per Perangkat Daerah',
            'data'=>$result,
            'rel'=>'self'
        );

        echo json_encode($data);
    }

    public function getByUnitKerja($id_unit_kerja){
        $this->load->model('jabatan_model', 'jabatan');
        $result = $this->jabatan->getByUnitKerja($id_unit_kerja)->result();
        $data = array(	'code'=>200,
            'status'=>'success',
            'title'=>'Daftar Nama Jabatan Per Unit Kerja',
            'data'=>$result,
            'rel'=>'self'
        );

        echo json_encode($data);
    }
	
}
