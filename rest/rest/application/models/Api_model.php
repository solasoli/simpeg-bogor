<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Api_model extends CI_Model{

	var $DBSIMPEG;
	var $DBAPI;

	public function __construct(){

		parent::__construct();
		//$DBSIMPEG 	= $this->load->database('simpeg', true);
		//$DBAPI 		= $this->load->database('api', true);
	}
	
	public function get_api_key(){
		//$DBAPI 		= $this->load->database('api', true);
		//$this->db->db_select('simpeg_api');
		//return $this->db->get('aplikasi');
	}

    public function verify_api_key($api_key){
	    $sql = "SELECT * FROM rest_apps WHERE api_key = '".$api_key."'";
        $query = $this->db->query($sql);
        $rowcount = $query->num_rows();
        if($rowcount > 0) {
            foreach ($query->result() as $apps) {
                $data = array('idrest_apps' => $apps->idrest_apps);
            }
        }else{
            $data = null;
        }
        return $data;
    }

    public function get_rest_methode($id_methode, $idrest_apps){
        $sql = "SELECT rm.* FROM
                (SELECT * FROM rest_access WHERE idrest_apps = $idrest_apps AND id_methode = $id_methode) a
                INNER JOIN rest_master rm ON a.id_methode = rm.id_methode";
        $query = $this->db->query($sql);
        $rowcount = $query->num_rows();
        if($rowcount > 0) {
            foreach ($query->result() as $apps) {
                $data = array(
                    'id_methode' => $apps->id_methode,
                    'judul' => $apps->judul,
                    'entitas' => $apps->entitas,
                    'function' => $apps->function
                );
            }
        }else{
            $data = null;
        }
        return $data;
    }

    public function get_rest_master($entitas){
        $sql = "SELECT rm.id_methode, rm.judul, rm.uraian, rm.entitas, rm.function, rm.url, rm.methode,
                  DATE_FORMAT(rm.tgl_create, '%d-%m-%Y %H:%m:%s') as tgl_create, p.nip_baru,
                  CONCAT(CASE WHEN p.gelar_depan = '' THEN '' ELSE CONCAT(p.gelar_depan, ' ') END,
                         nama, CASE WHEN p.gelar_belakang = '' THEN '' ELSE CONCAT(' ',p.gelar_belakang) END) AS nama,
                  COUNT(rp.idrest_params) as jml_params, COUNT(rr.idrest_response) as jml_respons
                FROM rest_master rm
                LEFT JOIN rest_admin ra ON rm.idrest_admin = ra.idrest_admin
                LEFT JOIN pegawai p ON ra.id_pegawai = p.id_pegawai
                LEFT JOIN rest_request_params rp ON rm.id_methode = rp.id_methode
                LEFT JOIN rest_response rr ON rm.id_methode = rr.id_methode
                WHERE rm.entitas = '$entitas' 
                GROUP BY rm.id_methode";
        return $this->db->query($sql);
    }

    public function get_jml_methode_by_entitas($entitas){
        $sql = "SELECT COUNT(*) as jumlah FROM rest_master WHERE entitas = '$entitas'";
        $query = $this->db->query($sql);
        $rowcount = $query->num_rows();
        if($rowcount > 0) {
            foreach ($query->result() as $data) {
                $jmlData = $data->jumlah;
            }
        }else{
            $jmlData = 0;
        }
        return $jmlData;
    }

    public function get_jml_all_methode(){
        $sql = "SELECT COUNT(*) as jumlah FROM rest_master";
        $query = $this->db->query($sql);
        $rowcount = $query->num_rows();
        if($rowcount > 0) {
            foreach ($query->result() as $data) {
                $jmlData = $data->jumlah;
            }
        }else{
            $jmlData = 0;
        }
        return $jmlData;
    }

    public function get_detail_methode_by_id($idmethode){
        $sql = "SELECT rm.*, DAY(rm.tgl_create) as tgl, MONTH(rm.tgl_create) as bln, YEAR(rm.tgl_create) as thn, TIME(rm.tgl_create) as jam,
                CONCAT(CASE WHEN p.gelar_depan = '' THEN '' ELSE CONCAT(p.gelar_depan, ' ') END,
                nama, CASE WHEN p.gelar_belakang = '' THEN '' ELSE CONCAT(' ',p.gelar_belakang) END) AS inputer
                FROM rest_master rm LEFT JOIN rest_admin ra ON rm.idrest_admin = ra.idrest_admin
                LEFT JOIN pegawai p ON ra.id_pegawai = p.id_pegawai
                WHERE rm.id_methode = $idmethode";
        return $this->db->query($sql);
    }

    public function get_params_methode_by_id($idmethode){
        $sql = "SELECT * FROM rest_request_params WHERE id_methode = $idmethode";
        return $this->db->query($sql);
    }

    public function get_response_methode_by_id($idmethode){
        $sql = "SELECT * FROM rest_response WHERE id_methode = $idmethode";
        return $this->db->query($sql);
    }

	
}
