<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Pemeriksaan extends CI_Controller {
	function __construct() {
		parent::__construct();
		$this->load->library('session');

		if(!$this->session->userdata('user')){
			redirect('login');
		}
		$this->load->model('Hukuman_model','hukuman');
    $this->load->library('format');
  }

	/* daftar pemeriksaan */
  function dafrik(){
    $data['title']  = 'Sipohanpinter::Pemeriksaan';
    $data['page']   = 'pemeriksaan/pemeriksaan_list';
    $data['panggilans'] = $this->db->get('hukuman_pemeriksaan')->result();
		$this->db->select('tingkat_hukuman');
		$this->db->group_by('tingkat_hukuman');
		$data['tingkat'] = $this->db->get('jenis_hukuman')->result();
		//print_r($data['tingkat']);exit;
		$data['jenis_hukdis'] = $this->db->get('jenis_hukuman')->result();
		$data['tab_panggilan'] = $this->load->view('Sipohan/tab_panggilan',NULL,TRUE);
		//$data['berwenang'] = $this->sipohan->getPengesah('11301');

    $this->load->view('layout',$data);
  }

	function panggilan(){
		$data['title']  = 'Sipohanpinter::Pemeriksaan';
		$data['page']   = 'pemeriksaan/panggilan';
		$data['pelanggaran'] = $this->hukuman->get_pemeriksaan();

		$this->load->view('layout',$data);

	}

	function search_nip(){

		$nip = $this->input->post('nip');
	/*	$sql = "select * from pegawai p
						inner join current_lokasi_kerja clk on clk.id_pegawai = p.id_pegawai
						inner join unit_kerja uk on uk.id_unit_kerja = clk.id_unit_kerja
						where nip_baru = ".$nip;
*/
		if($query = $this->hukuman->get_pegawai_by_nip($nip)){
			$row = $query;
			$data['id_pegawai'] = $row->id_pegawai;
			$data['nama'] = $row->nama;
			$data['nip'] = $row->nip;
			$data['pangkat'] = $row->pangkat_gol;
			$data['jabatan'] = $row->jabatan;
			$data['unit_kerja'] = $row->nama_baru;
			$data['id_unit_kerja'] = $row->id_unit_kerja;
			$json['status'] = 'SUCCESS';
			$json['data'] = $data;

		}else{
			$json['status'] = 'FAILED';
			$json['data'] = '-';
		}

		echo json_encode($json);
	}



	public function simpan_baru(){
		//print_r($this->input->post());exit;
		$pemeriksaan = array('id_pegawai'=>$this->input->post('id_pegawai'),
										'nip_pegawai'=>$this->input->post('nip_pegawai'),
										'nama_pegawai'=>$this->input->post('nama_pegawai'),
										'gol_pegawai'=>$this->input->post('gol_pegawai'),
										'id_j_pegawai'=>$this->input->post('id_j_pegawai'),
										'jabatan_pegawai'=>$this->input->post('jabatan_pegawai'),
										'id_unit_kerja_pegawai'=>$this->input->post('id_unit_kerja_pegawai'),
										'unit_kerja_pegawai'=>$this->input->post('unit_kerja_pegawai'),
										'idp_atasan'=>$this->input->post('id_atasan'),
										'nip_atasan'=>$this->input->post('nip_atasan'),
										'nama_atasan'=>$this->input->post('nama_atasan'),
										'gol_atasan'=>$this->input->post('gol_atasan'),
										'id_j_atasan'=>$this->input->post('id_j_atasan'),
										'jabatan_atasan'=>$this->input->post('jabatan_atasan'),
										'id_unit_kerja_atasan'=>$this->input->post('id_unit_kerja_atasan'),
										'unit_kerja_atasan'=>$this->input->post('unit_kerja_atasan'),
										'tingkat_pelanggaran'=>$this->input->post('tingkat_pelanggaran'),
										'pelanggaran'=>$this->input->post('pelanggaran')
										);

			if($this->db->insert('hukuman_pemeriksaan',$pemeriksaan)){
				$json = array('status'=>'SUCCESS', 'data'=>'-');
				echo json_encode($json);
			}else{
				$json = array('status'=>'FAILED','data'=>'-');
				echo json_encode($json);
			}

	}

	public function simpan_panggilan(){
		$idhukuman_pemeriksaan = $this->input->post('idhukuman_pemeriksaan');
		$panggilanke = $this->input->post('panggilanKe');

		$dataUpdate = array('tgl_panggilan_'.$panggilanke => $this->input->post('kolom_tanggal'),
										'tempat_panggilan_'.$panggilanke => $this->input->post('tempat_panggilan'),
										'no_surat_panggilan_'.$panggilanke => $this->input->post('no_surat_panggilan'),
										'tgl_surat_panggilan_'.$panggilanke => $this->input->post('tgl_surat_panggilan'),
									);
		$this->db->where('idhukuman_pemeriksaan',$idhukuman_pemeriksaan);
		if($this->db->update('hukuman_pemeriksaan',$dataUpdate)){
			$json = array('status'=>'SUCCESS', 'data'=>'-');
			echo json_encode($json);
		}else{
			$json = array('status'=>'FAILED','data'=>'-');
			echo json_encode($json);
		}
	}

	public function get_json_hukuman_pemeriksaan(){

		$idhukuman_pemeriksaan =  $this->db->get_where('hukuman_pemeriksaan',array('idhukuman_pemeriksaan'=>$this->input->post('idhukuman_pemeriksaan')))->row();
		echo json_encode($idhukuman_pemeriksaan);
	}

	function simpan_tim(){

			$tim = array('idhukuman_pemeriksaan'=>$this->input->post('idhukuman_pemeriksaan'),
										'unsur'=>$this->input->post('unsur_tim'),
										'id_pegawai'=>$this->input->post('id_tim'),
										'nip'=>$this->input->post('nip_tim'),
										'nama'=>$this->input->post('nama_tim'),
										'id_j'=>$this->input->post('id_j_tim'),
										'jabatan'=>$this->input->post('jabatan_tim'),
										'golongan'=>$this->input->post('pangkat_tim'),
										'id_unit_kerja'=>$this->input->post('id_unit_kerja_tim'),
										'nama_unit_kerja'=>$this->input->post('unit_kerja_tim')
									);
				if($this->db->insert('hukuman_tim',$tim)){
					$json = array('status'=>'SUCCESS', 'data'=>$this->db->last_query());
					echo json_encode($json);
				}else{
					$json = array('status'=>'FAILED','data'=>'-');
					echo json_encode($json);
				}
	}

	public function delete_tim(){
		if($this->db->delete('hukuman_tim',array('idhukuman_tim'=>$this->input->post('id')))){
			$json = array('status'=>'SUCCESS', 'data'=>'data berhasil dihapus');
			echo json_encode($json);
		}else{
			$json = array('status'=>'FAILED', 'data'=>$this->db->last_query());
			echo json_encode($json);
		}
	}

	public function cetak_surat_pembentukan_tim($idhukuman_pemeriksaan){
		$data['pegawai'] = $this->db->get_where('hukuman_pemeriksaan', array('idhukuman_pemeriksaan' => $idhukuman_pemeriksaan ))->row();
		$data['tim_pemeriksa'] = $this->db->get_where('hukuman_tim',array('idhukuman_pemeriksaan'=> $idhukuman_pemeriksaan))->result();
		/*echo "<pre>";
		print_r($data);
		echo "</pre>";
		*/
		$this->load->view('pemeriksaan/surat_pembentukan_tim',$data);
	}

	public function cetak_sprint_pemeriksaan($idhukuman_pemeriksaan){
		$data['pegawai'] = $this->db->get_where('hukuman_pemeriksaan', array('idhukuman_pemeriksaan' => $idhukuman_pemeriksaan ))->row();
		$data['tim_pemeriksa'] = $this->db->get_where('hukuman_tim',array('idhukuman_pemeriksaan'=> $idhukuman_pemeriksaan))->result();
		print_r($data['pegawai']);
		$this->load->view('pemeriksaan/surat_perintah_pemeriksaan',$data);
	}

	public function cetak_surat_panggilan($idhukuman_pemeriksaan){
		$data['title']  = 'Sipohanpinter::Cetak Panggilan';
		$data['page']   = 'pemeriksaan/panggilan';
		$data['pegawai'] = $this->db->get_where('hukuman_pemeriksaan', array('idhukuman_pemeriksaan' => $idhukuman_pemeriksaan ))->row();
		$data['panggilanke'] = $this->uri->segment(4);
		/*
		echo "<pre>";
		print_r($data['pegawai']);
		echo "</pre>";
		*/
		$this->load->view('pemeriksaan/surat_panggilan',$data);
	}

	function get_tim(){

		$idhukuman_pemeriksaan = $this->input->post('idhukuman_pemeriksaan');

		$tims = $this->db->get_where('hukuman_tim',array('idhukuman_pemeriksaan'=>$idhukuman_pemeriksaan))->result();
		//echo $this->db->last_query();
		echo json_encode($tims);
	}

	function pemeriksaan_delete(){
		if($this->db->delete('hukuman_pemeriksaan',array('idhukuman_pemeriksaan'=>$this->input->post('id')))){
			$json = array('status'=>'SUCCESS', 'data'=>'data berhasil dihapus');
			echo json_encode($json);
		}else{
			$json = array('status'=>'FAILED', 'data'=>$this->db->last_query());
			echo json_encode($json);
		}
	}

}
