<?php defined('BASEPATH') OR exit('No direct script access allowed');


class Unit_kerja extends CI_Controller{
	
	public function __construct(){
		
		parent::__construct();
		$this->load->model('Api_model', 'api');
		$this->load->model('unit_kerja_model', 'unit_kerja');
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
	
	public function get($param=NULL){
		$param = urldecode($param);
		$query = $this->unit_kerja->get($param);
		if($query->result()){
		
			echo json_encode($query->result());
		}else{
			$this->failed();
		}
		//echo "<p>".$this->db->last_query()."</p>";
	}

    public function getAll(){
        $this->load->model('unit_kerja_model','uk');
        $result = $this->uk->getAll()->result();
        $data = array(	'code'=>200,
            'status'=>'success',
            'title'=>'Daftar Unit Kerja',
            'data'=>$result,
            'rel'=>'self',
            'links'=>array(
                'Daftar Pegawai'=>"",
            )
        );
        echo json_encode($data);

    }

    public function getByTahun($thn=0){
        $this->load->model('unit_kerja_model','uk');
        $result = $this->uk->getByTahun($thn)->result();
        $data = array(	'code'=>200,
            'status'=>'success',
            'title'=>'Daftar Unit Kerja',
            'data'=>$result,
            'rel'=>'self'
        );
        echo json_encode($data);
    }

    public function get_opd($param=NULL){
        $param = urldecode($param);
        $query = $this->unit_kerja->get_opd($param);
        if($query->result()){
            echo json_encode($query->result());
        }else{
            $this->failed();
        }
        //echo "<p>".$this->db->last_query()."</p>";

    }

    function daftarPegawai($id_skpd){
        $this->load->model('unit_kerja_model','unit_kerja');
        $query = $this->unit_kerja->getDaftarPegawaiByIdSkpd($id_skpd);
        $data = $query->result();
        $data = array(	'code'=>200,
            'status'=>'success',
            'title'=>'Daftar Pegawai Perangkat Daerah '.$this->unit_kerja->get_opd($id_skpd)->row()->opd,
            'data'=>$data,
            'rel'=>'child'
        );

        echo json_encode($data);
    }

    function get_list_unit_kerja_terakhir(){
        $query = $this->unit_kerja->getUnitKerjaAll();
        $data = $query->result();
        $data = array('code'=>200,
            'status'=>'success',
            'title'=>'Data List Unit Kerja tahun terakhir',
            'data'=>$data,
            'rel'=>'self'
        );
        echo json_encode($data);
    }

    function get_list_unit_kerja_apps_bisa($tahun, $is_skpd_only){
        if(isset($tahun) and $tahun!='' and $tahun!='0'){
            $tahun = $tahun;
        }else{
            $tahun = $this->input->get('tahun');
        }
        if(isset($is_skpd_only) and $is_skpd_only!='' and $is_skpd_only!='0'){
            $is_skpd_only = $is_skpd_only;
        }else{
            $is_skpd_only = $this->input->get('is_skpd_only');
        }
        $query = $this->unit_kerja->listUnitKerjaAppsBisa($tahun, $is_skpd_only);
        $data = $query->result();
        $data = array(	'code'=>200,
            'status'=>'success',
            'title'=>'Daftar List Unit Kerja',
            'data'=>$data,
            'rel'=>'self'
        );
        echo json_encode($data);
    }
	
	function failed(){
		
		$fail = array(array('id_pegawai'=>NULL,
					'id_unit_kerja'=>NULL,
					'unit_kerja'=>NULL,
					'id_opd'=>NULL,
					'opd'=>NULL,					
					'request_status'=>'102'			
				));
			echo json_encode($fail);
	}
	

}
