<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Keluarga_model extends CI_Model{

	public $nama_istri;
	public $id_pegawai;



	public function __construct(){

		parent::__construct();

	}


	public function is_kawin($id_pegawai){

		//
	}

	public function get_istri_suami($id_pegawai = null){

		//id status keluarga = 9

		if($id_pegawai == NULL) $id_pegawai = $this->id_pegawai;

		//echo "bla bla..".$id_pegawai; exit;

		//$this->db->where('id_pegawai',$id_pegawai);
		//$this->db->where('id_status',9);

		//$this->db->where('tgl_cerai IS NULL',null, false);
		//$this->db->where('status IS NULL',NULL, FALSE);
		//$this->db->or_where('status','Menikah',NULL);

		//$this->db->get('keluarga')->result();

		$sql = "select * from keluarga where id_pegawai = ".$id_pegawai." and id_status = 9 and (status not like '%Cerai%' and status not like '%Meninggal%'  or status is NULL)";
		//echo $sql;exit;
		return $this->db->query($sql)->result();
		//echo $this->db->last_query();exit;
	}

	public function get_anak($id_pegawai=null){

		//status_kel = 10

		if($id_pegawai == NULL) $id_pegawai = $this->id_pegawai;

		$this->db->where('id_pegawai',$id_pegawai);
		$this->db->where('id_status',10);
		$this->db->where('tgl_meninggal IS NULL');
		$this->db->order_by('tgl_lahir','ASC');
		return $this->db->get('keluarga')->result();
		//echo $this->db->last_query();exit;
	}

}
