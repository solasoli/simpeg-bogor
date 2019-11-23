<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Sipohan extends MX_Controller {
	function __construct() {
		parent::__construct();

		$this->load->library('format');
		$this->load->model('sipohan_model','sipohan');

		$this->load->library('form_validation');
		Modules::Run('Dashboard/ceklog');
	}


	function lizt(){
		$data['title'] = "Daftar Pelanggaran Disiplin";
		$data['konten'] = 'list';
		$data['pelanggaran'] = $this->db->get('hukuman')->result();
		$this->load->view('Layout/_layout',$data);
	}

	function panggilan(){

		$data['title'] = 'Dugaan Pelanggaran Disiplin';
		$data['konten'] = 'list_panggilan';

		$this->db->order_by('id','DESC');
		$data['panggilans'] = $this->db->get('hukuman_pemeriksaan')->result();

		$this->db->select('tingkat_hukuman');
		$this->db->group_by('tingkat_hukuman');
		$data['tingkat'] = $this->db->get('jenis_hukuman')->result();
		//print_r($data['tingkat']);exit;
		$data['jenis_hukdis'] = $this->db->get('jenis_hukuman')->result();
		$data['tab_panggilan'] = $this->load->view('Sipohan/tab_panggilan',NULL,TRUE);
		$data['berwenang'] = $this->sipohan->getPengesah('11301');
		$this->load->view('Layout/_layout',$data);
		//print_r($this->session->userdata('nama'));
	}

	function panggilan_add(){

		$data['title'] = 'Panggilan Pemeriksaan Baru';
		$data['konten'] = 'panggilan_add';

		$this->load->view('Layout/_layout',$data);
	}

	function detail($id_pemeriksaan){


		$data['panggilan'] = $this->db->get_where('hukuman_pemeriksaan',array('id'=>$id_pemeriksaan))->row();
		$data['pegawai'] = json_decode($data['panggilan']->data_pegawai);
		$data['atasan'] = json_decode($data['panggilan']->data_atasan);


		$data['title'] = 'Pelanggaran Disiplin '.$data['pegawai']->nama;
		$data['konten'] = 'panggilan_detail';
		$data['pemeriksaan'] = json_decode($data['panggilan']->data_pemeriksaan);

		if(isset($data['pemeriksaan']->id_penandatangan)){
			$data['penandatangan'] = $this->sipohan->get_pegawai($data['pemeriksaan']->id_penandatangan);

		}

		$data['jenis_hukdis'] = $this->db->get('jenis_hukuman')->result();

		$data['berwenang'] = $this->sipohan->getPengesah($data['panggilan']->id_pegawai);

		$data['pelanggaran'] = json_decode($data['panggilan']->data_pelanggaran);

		$this->load->view('Layout/_layout',$data);

	}

	function search_nip(){

		$nip = $this->input->post('nip');
	/*	$sql = "select * from pegawai p
						inner join current_lokasi_kerja clk on clk.id_pegawai = p.id_pegawai
						inner join unit_kerja uk on uk.id_unit_kerja = clk.id_unit_kerja
						where nip_baru = ".$nip;
*/
		if($query = $this->sipohan->get_pegawai_by_nip($nip)){
			$row = $query;
			$data['id_pegawai'] = $row->id_pegawai;
			$data['nama'] = $row->nama;
			$data['nip'] = $row->nip;
			$data['pangkat'] = $row->pangkat_gol;
			$data['jabatan'] = $row->jabatan;
			$data['unit_kerja'] = $row->nama_baru;

			$json['status'] = 'SUCCESS';
			$json['data'] = $data;

		}else{
			$json['status'] = 'FAILED';
			$json['data'] = '-';
		}

		echo json_encode($json);
	}

	function panggilan_save(){

		$data['id_pegawai'] = $this->input->post('id_pegawai');

		$pegawai = array('nip'=>$this->input->post('nip_pegawai'),
										'nama'=>$this->input->post('nama_pegawai'),
										'pangkat'=>$this->input->post('pangkat_pegawai'),
										'jabatan'=>$this->input->post('jabatan_pegawai'),
										'unit_kerja'=>$this->input->post('unit_kerja_pegawai')
										);
		$data['data_pegawai'] = json_encode($pegawai);
		//atasan langsung
		$pemeriksa = array('id_pegawai'=>$this->input->post('id_pemeriksa'),
											'nip'=>$this->input->post('nip_pemeriksa'),
										'nama'=>$this->input->post('nama_pemeriksa'),
										'pangkat'=>$this->input->post('pangkat_pemeriksa'),
										'jabatan'=>$this->input->post('jabatan_pemeriksa'),
										'unit_kerja'=>$this->input->post('unit_kerja')
										);
		$data['data_atasan'] = json_encode($pemeriksa);

		$pelanggaran = array('pelanggaran'=>$this->input->post('dugaan'),
												'hari_pemeriksaan'=>'',
												'tanggal_pemeriksaan' => $this->input->post('tanggal'),
												'waktu_pemeriksaan' => $this->input->post('waktu'),
												'tempat_pemeriksaan' => $this->input->post('tempat'));
		$data['data_pelanggaran'] = json_encode($pelanggaran);
		$data['log'] = "dibuat oleh : ".$this->session->userdata('user_id')." ".date("Y-m-d H:i:s");


		if($this->db->insert('hukuman_pemeriksaan',$data)){
			$json = array('status'=>'SUCCESS', 'data'=>'-');
			echo json_encode($json);
		}else{
			$json = array('status'=>'FAILED','data'=>'-');
			echo json_encode($json);
		}

	}

	function panggilan_update(){

		$id = $this->input->post('id_pemeriksaan');
		$pelanggaran = array('pelanggaran'=>trim($this->input->post('dugaan')));

		$panggilan = array('hari_panggilan'=>$this->input->post('hari'),
												'tanggal_panggilan' => $this->input->post('tanggal'),
												'waktu_panggilan' => $this->input->post('waktu'),
												'tempat_panggilan' => $this->input->post('tempat'),
												'id_pemanggil'=>$this->input->post('id_pemanggil'),
												'id_penandatangan'=>$this->input->post('id_penandatangan'),
												'tanggal_surat'=>$this->input->post('tanggal_surat'));
		$data['status_pemeriksaan'] = $this->input->post('status_pemeriksaan');
		$data['data_panggilan'] = json_encode($panggilan);
		$data['data_pelanggaran'] = json_encode($pelanggaran);
		//print_r($this->input->post());exit;
		//print_r($data['data_pelanggaran']);exit;
		$this->db->where('id',$id);
		if($this->db->update('hukuman_pemeriksaan',$data)){
			$json = array('status'=>'SUCCESS', 'data'=>$this->db->last_query());
			echo json_encode($json);
		}else{
			$json = array('status'=>'FAILED','data'=>'-');
			echo json_encode($json);
		}
	}

	function panggilan_delete(){


		if($this->db->delete('hukuman_pemeriksaan',array('id'=>$this->input->post('id')))){
			$json = array('status'=>'SUCCESS', 'data'=>'data berhasil dihapus');
			echo json_encode($json);
		}else{
			$json = array('status'=>'FAILED', 'data'=>$this->db->last_query());
			echo json_encode($json);
		}

	}

	function panggilan_cetak($id){
		$data['panggilan'] = $this->db->get_where('hukuman_pemeriksaan',array('id'=>$id))->row();

		//$data['kepala'] = $this->sipohan->get_kepala_peg($data['panggilan']->id_pegawai);
		$data['data_panggilan'] = json_decode($data['panggilan']->data_panggilan);
		//print_r($data['data_panggilan']);exit;
		//echo $data['data_panggilan']->id_pemanggil;exit;
		$data['pemanggil'] = $this->sipohan->get_pegawai($data['data_panggilan']->id_pemanggil);
		$data['penandatangan'] = $this->sipohan->get_pegawai($data['data_panggilan']->id_penandatangan);
		$this->load->view('cetak_panggilan',$data);
	}

	function tim_pemeriksa_add($id_pemeriksaan){
		$data['title'] = 'Tim Pemeriksa';
		$data['konten'] = 'tim_pemeriksa_add';

		$this->load->view('Layout/_layout',$data);

	}

	function sprint_pemeriksa_cetak($id_pemeriksaan){
		$pemeriksaan = $this->db->get_where('hukuman_pemeriksaan',array('id'=>$id_pemeriksaan))->row();
		$data['ancaman'] = $pemeriksaan->ancaman_hukuman;
		$data['pegawai'] = json_decode($pemeriksaan->data_pegawai);
		$data['atasan'] = json_decode($pemeriksaan->data_atasan);
		$data['pelanggaran'] = json_decode($pemeriksaan->data_pelanggaran);
		$data['pemeriksaan'] = json_decode($pemeriksaan->data_pemeriksaan);
		$this->db->order_by('unsur','ASC');
		$data['tim'] = $this->db->get_where('hukuman_tim',array('id_hukuman_pemeriksaan'=>$id_pemeriksaan))->result();

		$this->load->view('cetak_sprint_pemeriksaan',$data);
	}

	function tim_pemeriksa_cetak($id_pemeriksaan){
		$pemeriksaan = $this->db->get_where('hukuman_pemeriksaan',array('id'=>$id_pemeriksaan))->row();
		$data['ancaman'] = $pemeriksaan->ancaman_hukuman;
		$data['pegawai'] = json_decode($pemeriksaan->data_pegawai);
		$data['atasan'] = json_decode($pemeriksaan->data_atasan);

		$data['tim_pengawasan'] = $this->db->get_where('hukuman_tim',array('id_hukuman_pemeriksaan'=>$id_pemeriksaan,'unsur'=>'PENGAWASAN'))->result();
		$data['tim_kepegawaian'] =$this->db->get_where('hukuman_tim',array('id_hukuman_pemeriksaan'=>$id_pemeriksaan,'unsur'=>'KEPEGAWAIAN'))->result();
		$data['tim_pejabat'] =$this->db->get_where('hukuman_tim',array('id_hukuman_pemeriksaan'=>$id_pemeriksaan,'unsur'=>'PEJABATLAIN'))->result();
		$data['pemeriksaan'] = json_decode($pemeriksaan->data_pemeriksaan);
		$this->load->view('pembentukan_tim_pemeriksa',$data);
	}

	function tim_pemeriksa_simpan(){

		$pemeriksa = array(
										'nip'=>$this->input->post('nip_pegawai'),
										'nama'=>$this->input->post('nama_pegawai'),
										'pangkat'=>$this->input->post('pangkat_pegawai'),
										'jabatan'=>$this->input->post('jabatan_pegawai'),
										'unit_kerja'=>$this->input->post('unit_kerja_pegawai')
										);
		$json = json_encode($pemeriksa);

		$data['id_hukuman_pemeriksaan'] = $this->input->post('id_hukuman_pemeriksaan');
		$data['unsur'] = $this->input->post('unsur_pemeriksa');
		$data['id_pegawai'] = $this->input->post('id_pegawai');
		$data['data_tim'] = $json;
		$data['log'] = "Dibuat oleh ".$this->session->userdata('id');


		if($this->db->insert('hukuman_tim',$data)){
			$json = array('status'=>'SUCCESS', 'data'=>$this->db->insert_id());
			echo json_encode($json);
		}else{
			$json = array('status'=>'FAILED', 'data'=>'-');
			echo json_encode($json);
		}

	}

	function pemeriksaan_update(){

		$pemeriksaan = array(
									'id_penandatangan'=>$this->input->post('id_sprint'),
									'hari_pemeriksaan'=>'-',
									'tanggal_pemeriksaan'=>$this->input->post('tanggal_sprint'),
									'waktu_pemeriksaan'=>$this->input->post('waktu_sprint'),
									'tempat_pemeriksaan'=>$this->input->post('tempat_sprint'),
									'tanggal_surat_pemeriksaan'=>$this->input->post('tanggal_surat_sprint'));

			$data['data_pemeriksaan'] = json_encode($pemeriksaan);
			$this->db->where('id',$this->input->post('id'));
			if($this->db->update('hukuman_pemeriksaan',$data)){
				$json = array('status'=>'SUCCESS', 'data'=>$this->db->last_query());
				echo json_encode($json);
			}else{
				$json = array('status'=>'FAILED','data'=>'-');
				echo json_encode($json);
			}
	}

	function pemeriksa_delete(){
		if($this->db->delete('hukuman_tim',array('id'=>$this->input->post('id')))){
			$json = array('status'=>'SUCCESS', 'data'=>'data berhasil dihapus');
			echo json_encode($json);
		}else{
			$json = array('status'=>'FAILED', 'data'=>'Data gagal dihapus');
			echo json_encode($json);
		}
	}

	function data_penjatuhan(){
		$this->load->model('Sipohan_model','sipohan');

		$data['title'] = 'Form Penjatuhan';
		$data['konten'] = 'form_penjatuhan';
		$data['id_pemeriksaan'] = $this->uri->segment(3);
		$pemeriksaan = $this->db->get_where('hukuman_pemeriksaan',array('id'=>$this->uri->segment(3)))->row();
		$data['id_pegawai'] = $pemeriksaan->id_pegawai;
		$data['pegawai'] = json_decode($pemeriksaan->data_pegawai);
		$data['jenis_hukdis'] = $this->db->get('jenis_hukuman')->result();

		$data['berwenang'] = $this->sipohan->getPengesah($pemeriksaan->id_pegawai);
		//print_r($data['berwenang']);exit;
		$this->load->view('Layout/_layout',$data);
	}

	function ubahPenjatuhan(){
		$this->load->model('Sipohan_model','sipohan');

		$data['title'] = 'Form Ubah Penjatuhan';
		$data['konten'] = 'form_ubah_penjatuhan';
		$data['id_hukuman'] = $this->uri->segment(3);
		$pemeriksaan = $this->db->get_where('hukuman_pemeriksaan',array('id'=>$this->uri->segment(3)))->row();
		$data['id_pegawai'] = $pemeriksaan->id_pegawai;
		$data['pegawai'] = json_decode($pemeriksaan->data_pegawai);
		$data['jenis_hukdis'] = $this->db->get('jenis_hukuman')->result();

		$data['berwenang'] = $this->sipohan->getPengesah($pemeriksaan->id_pegawai);

		$this->load->view('Layout/_layout',$data);
	}

	function penjatuhan($id_hukuman){

		$hukuman = $this->db->get_where('hukuman',array('id_hukuman'=>$id_hukuman))->row();
		$data['hukuman'] = $hukuman;
		$data['berwenang'] = $this->sipohan->get_pegawai($hukuman->id_pemberi_hukuman);
		$pemeriksaan = $this->db->get_where('hukuman_pemeriksaan',array('id'=>$hukuman->id_hukuman_pemeriksaan))->row();
		$data['ancaman'] = $pemeriksaan->ancaman_hukuman;

		$data['jenis'] = $this->db->get_where('jenis_hukuman',array('id_jenis_hukuman'=>$hukuman->id_jenis_hukuman))->row();
		$data['pegawai'] = json_decode($pemeriksaan->data_pegawai);
		$data['atasan'] = json_decode($pemeriksaan->data_atasan);

		$this->load->view($data['jenis']->template,$data);
	}

	function penjatuhan_simpan(){

		//print_r($this->input->post());exit;

		$nama_hukuman = $this->db->get_where('jenis_hukuman',
										array('id_jenis_hukuman'=>$this->input->post('jenis_hukdis')))->row()->deskripsi;
		$data = array(
						'id_pegawai'=>$this->input->post('id_pegawai_penjatuhan'),
						'id_jenis_hukuman'=>$this->input->post('jenis_hukdis'),
						'nama_hukuman'=>$nama_hukuman,
						'no_keputusan'=>"",//$this->input->post('no_sk'),
						'tgl_hukuman'=>$this->input->post('tmt'),
						'tmt'=>$this->input->post('tmt'),
						'pejabat_pemberi_hukuman'=>$this->input->post('nama_penjatuhan'),
						'jabatan_pemberi_hukuman'=>$this->input->post('jabatan_penjatuhan'),
						'data_pelanggaran'=>$this->input->post('pelanggaran'),
						'id_hukuman_pemeriksaan'=>$this->input->post('id_hukuman_pemeriksaan'),
						'pasal'=>$this->input->post('pasal'),
						'ayat'=>$this->input->post('ayat'),
						'id_pemberi_hukuman'=>$this->input->post('id_pemberi_hukuman')


						);

			//print_r($data);exit;
	 		//echo $this->db->insert('hukuman',$data);exit;
			if($this->db->insert('hukuman',$data)){

				$json = array('status'=>'SUCCESS', 'data'=>$this->db->insert_id());
				echo json_encode($json);
			}else{
				$json = array('status'=>'FAILED', 'data'=>'-');
				echo json_encode($json);
			}

	}

	function get_pangkat($gol){

		return $this->db->get_where("golongan",array("golongan"=>$gol))->row()->pangkat;
	}



	function get_pejabat_berwenang($id_pegawai){

		switch ($tingkat) {
			case 'Ringan':
				// code...
				break;
			case 'Sedang':
				break;
			case 'Berat':
				break;
			default:
				// code...
				break;
		}
	}


}
