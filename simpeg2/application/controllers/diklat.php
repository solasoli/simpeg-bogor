<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Diklat extends CI_Controller{

	public function __construct(){
		parent::__construct();
		$this->load->model('diklat_model','diklat');
		$this->load->model('unit_kerja_model','unit_kerja');
		$this->load->model('pegawai_model','pegawai');
		$this->load->library('format');
		$this->load->library('pagerv2');
	}

	public function index($status = NULL){
		$this->load->view('layout/header', array( 'title' => 'Manajemen Diklat dan Pengembangan SDA', 'idproses' => 0));
		$this->load->view('diklat/header');
		$this->dashboard_diklat();
		$this->load->view('layout/footer');
	}

	public function dashboard_diklat(){
		$rekap_jenis = $this->diklat->getReportJenis();
		$rekap_periode = $this->diklat->getReportPeriode();
		$rekap_pim = $this->diklat->getReportPIM();
		$rekap_jab_kosong = $this->diklat->getReportJabatanKosong();
		$i=0;
		foreach ($rekap_jenis as $lsdata){
			$data1[$i] = array(
					'name' => $lsdata->jenis_diklat,
					'y' => $lsdata->jumlah
			);
			$i++;
		}
		$this->load->view('diklat/dashboard_diklat',
				array(
						'rekap_jenis' => $rekap_jenis,
						'rekap_periode' => $rekap_periode,
						'rekap_pim' => $rekap_pim,
						'rekap_jab_kosong' => $rekap_jab_kosong,
						'chart' => json_encode($data1, JSON_NUMERIC_CHECK)
				));
	}


public function list_proper(){
$this->load->view('layout/header', array( 'title' => 'Penyusunan Sprint oleh BKPSDA', 'idproses' => 6));
		$this->load->view('diklat/header');
		$proper = $this->diklat->getproper();
		$this->load->view('diklat/daftar_proper',array('proper'=>$proper));
			$this->load->view('layout/footer');

}

public function approve($idproper){
$this->load->view('layout/header', array( 'title' => 'Manajemen Diklat dan Pengembangan SDA', 'idproses' => 1));
		$this->load->view('diklat/header');
		$proper = $this->diklat->approval($idproper);
			$proper = $this->diklat->getproper();
		$this->load->view('diklat/daftar_proper',array('proper'=>$proper));
			$this->load->view('layout/footer');

}

	public function list_data_diklat(){
		$this->load->view('layout/header', array( 'title' => 'Manajemen Diklat dan Pengembangan SDA', 'idproses' => 1));
		$this->load->view('diklat/header');
		$jenisDiklat = $this->diklat->getJenisDiklat();
		$idjenis = $this->input->get('idjenis');
		$tgldari = $this->input->get('tgldari');
		$tgldari2 = $tgldari;
		if(isset($tgldari) and $tgldari != NULL and $tgldari != 0){
			$tgldari = explode(".", $tgldari);
			$tgldari = $tgldari[2].'-'.$tgldari[1].'-'.$tgldari[0];
		}
		$tglsampai = $this->input->get('tglsampai');
		$tglsampai2 = $tglsampai;
		if(isset($tglsampai) and $tglsampai != NULL and $tglsampai != 0){
			$tglsampai = explode(".", $tglsampai);
			$tglsampai = $tglsampai[2].'-'.$tglsampai[1].'-'.$tglsampai[0];
		}
		$chkWaktu = $this->input->get('chkWaktu');
		$jenjab = $this->input->get('jenjab');
		$keywordCari = $this->input->get('keywordCari');
		$filter = $this->input->get('filter');
		if($filter==''){
			$filter = 'Diklat';
		}
		$num_rows = $this->diklat->get_count_list_data_diklat($idjenis,$tgldari,$tglsampai,$chkWaktu,$jenjab,$keywordCari,$filter);
		if($num_rows>0){
			$pages = new Paginator($num_rows,9,array(10,3,6,9,15,25,50,100,'All'));
			$pgDisplay = $pages->display_pages();
			$curpage = $pages->current_page;
			$numpage = $pages->num_pages;
			$total_items = $pages->total_items;
			$jumppage = $pages->display_jump_menu();
			$item_perpage = $pages->display_items_per_page();
			$list_data = $this->diklat->get_list_data_diklat($pages->limit_start,$pages->limit_end,$idjenis,$tgldari,$tglsampai,$chkWaktu,$jenjab,$keywordCari,$filter);
		}else{
			$pgDisplay = '';
			$curpage = '';
			$numpage = '';
			$total_items = '';
			$jumppage = '';
			$item_perpage = '';
			$list_data = '';
		}

		$this->load->view('diklat/daftar_kegiatan',
				array(
						'list_data' => $list_data,
						'pgDisplay' => $pgDisplay,
						'curpage' => $curpage,
						'numpage' => $numpage,
						'total_items' => $total_items,
						'jumppage' => $jumppage,
						'item_perpage' => $item_perpage,
						'list_jenis'=>$jenisDiklat,
						'keywordCari' => $keywordCari,
						'idjenis' => $idjenis,
						'tgldari2' => $tgldari2,
						'tglsampai2' => $tglsampai2,
						'chkWaktu' => $chkWaktu,
						'jenjab' => $jenjab,
						'filter' => $filter));
		$this->load->view('layout/footer');
	}

	public function status_diklat_pejabat(){
		$this->load->view('layout/header', array( 'title' => 'Manajemen Diklat dan Pengembangan SDA', 'idproses' => 2));
		$this->load->view('diklat/header');
		$list_skpd = $this->diklat->getSKPD();
		$list_gol = $this->diklat->getGolongan();
		$list_status = $this->diklat->getStatusDiklat();
		$list_eselon = $this->diklat->getEselon();

		$status_diklat = $this->input->get('status_diklat');
		$idskpd = $this->input->get('idskpd');
		$eselon = $this->input->get('eselon');
		$gol = $this->input->get('gol');
		$keywordCari = $this->input->get('keywordCari');
		$operator = $this->input->get('operator');
		$umur = $this->input->get('umur');

		$a = $this->input->get('a');
		$b = $this->input->get('b');
		$c = $this->input->get('c');
		$d = $this->input->get('d');
		$e = $this->input->get('e');

		$num_rows = $this->diklat->getCountListStatusDiklatPejabat($status_diklat,$idskpd,$eselon,$gol,$keywordCari,$operator,$umur);

		if($num_rows>0){
			$pages = new Paginator($num_rows,9,array(10,3,6,9,15,25,50,100,'All'));
			$pgDisplay = $pages->display_pages();
			$curpage = $pages->current_page;
			$numpage = $pages->num_pages;
			$total_items = $pages->total_items;
			$jumppage = $pages->display_jump_menu();
			$item_perpage = $pages->display_items_per_page();
			$list_data = $this->diklat->getListStatusDiklatPejabat($pages->limit_start,$pages->limit_end,$status_diklat,$idskpd,$eselon,$gol,$keywordCari,$operator,$umur,$a,$b,$c,$d,$e);
		}else{
			$pgDisplay = '';
			$curpage = '';
			$numpage = '';
			$total_items = '';
			$jumppage = '';
			$item_perpage = '';
			$list_data = '';
		}

		$this->load->view('diklat/daftar_diklat_pejabat',
				array(
						'list_data' => $list_data,
						'pgDisplay' => $pgDisplay,
						'curpage' => $curpage,
						'numpage' => $numpage,
						'total_items' => $total_items,
						'jumppage' => $jumppage,
						'item_perpage' => $item_perpage,
						'list_skpd'=>$list_skpd,
						'list_gol'=>$list_gol,
						'list_status'=>$list_status,
						'list_eselon'=>$list_eselon,
						'keywordCari' => $keywordCari,
						'operator' => $operator,
						'umur' => $umur,
						'status_diklat' => $status_diklat,
						'idskpd' => $idskpd,
						'eselon' => $eselon,
						'gol' => $gol,
						'a' => ($a=='skpd-asc' or $a=='nama2-asc' or $a=='eselon-asc' or $a=='umur-desc' or $a=='usia_jabatan-desc')?$a:'',
						'b' => ($b=='skpd-asc' or $b=='nama2-asc' or $b=='eselon-asc' or $b=='umur-desc' or $b=='usia_jabatan-desc')?$b:'',
						'c' => ($c=='skpd-asc' or $c=='nama2-asc' or $c=='eselon-asc' or $c=='umur-desc' or $c=='usia_jabatan-desc')?$c:'',
						'd' => ($d=='skpd-asc' or $d=='nama2-asc' or $d=='eselon-asc' or $d=='umur-desc' or $d=='usia_jabatan-desc')?$d:'',
						'e' => ($e=='skpd-asc' or $e=='nama2-asc' or $e=='eselon-asc' or $e=='umur-desc' or $e=='usia_jabatan-desc')?$e:''));

		$this->load->view('layout/footer');
	}

	public function detail_diklat_pejabat(){
		$idp = $this->input->post('idp');
		$nip = $this->input->post('nip');
		$nama = $this->input->post('nama');
		$gol = $this->input->post('gol');
		$jab = $this->input->post('jab');
		$skpd = $this->input->post('skpd');
		$status = $this->input->post('status');
		$eselon = $this->input->post('eselon');
		$listdata = $this->diklat->getDetailDiklatPejabat($idp);
		$this->load->view('diklat/detail_diklat_pejabat',
				array(
						'list_data' => $listdata,
						'idp' => $idp,
						'nip' => $nip,
						'nama' => $nama,
						'gol' => $gol,
						'jab' => $jab,
						'skpd' => $skpd,
						'status' => $status,
						'eselon' => $eselon
				));
	}

	public function tambah_data_diklat(){
		$this->load->view('layout/header', array( 'title' => 'Manajemen Diklat dan Pengembangan SDA', 'idproses' => 1));
		$this->load->view('diklat/header');
		$jenisDiklat = $this->diklat->getJenisDiklat();
		$submitok = $this->input->post('submitok');
		if($submitok==1){
			$data = array(
					'idjenis' => $this->input->post('ddFilterJenis'),
					'judul' => $this->input->post('judul'),
					'jdl_makalah' => $this->input->post('jdl_makalah'),
					'tglpelaksanaan' => $this->input->post('tglpelaksanaan'),
					'jumlah_jam' => $this->input->post('jam'),
					'penyelenggara' => $this->input->post('penyelenggara'),
					'nosttpl' => $this->input->post('sttpl'),
					'id_pegawai' => $this->input->post('txtIdPegawai')
			);
			$insert = $this->diklat->tambah_data_diklat($data);
			$tx_result = $insert['query'];
			if($tx_result == 1){
				if(isset($_FILES["fileSerti"])){
					if($_FILES["fileSerti"]['name'] <> "" ){
						if($_FILES["fileSerti"]['type']=='binary/octet-stream' or $_FILES["fileSerti"]['type'] == "application/pdf" or $_FILES["fileSerti"]['type'] == "image/jpeg" or $_FILES["fileSerti"]['type'] == "image/jpg" or $_FILES["fileSerti"]['type'] == "image/png" ){
							if($_FILES["fileSerti"]['size'] > 20097152) {
								$upload_status = 'File tidak terupload. Ukuran file terlalu besar';
								$upload_kode = 1;
							}else{
								//$uploaddir = dirname($_SERVER['SCRIPT_FILENAME']).'/Berkas/';
								$uploaddir = '../simpeg/Berkas/';
								$uploadfile = $uploaddir . basename($_FILES["fileSerti"]['name']);
								if (move_uploaded_file($_FILES["fileSerti"]['tmp_name'], $uploadfile)) {
									$this->db->trans_begin();
									$sqlInsert = "insert into berkas (id_pegawai,id_kat,nm_berkas,tgl_upload,created_by,created_date,ket_berkas) ".
											"values (".$this->input->post('txtIdPegawai').", 6,'Sertifikat', DATE(NOW()), '".$this->session->userdata('user')->id_pegawai."', NOW(), '')";
									$this->db->query($sqlInsert);
									if ($this->db->trans_status() === FALSE){
										$this->db->trans_rollback();
									}else{
										$idberkas = $this->db->insert_id();
										$sqlUpdate = "update diklat set id_berkas = $idberkas where id_diklat=".$insert['iddiklat'];
										$this->db->query($sqlUpdate);
										if ($this->db->trans_status() === FALSE){
											$this->db->trans_rollback();
										}else{
											$sqlInsert = "insert into isi_berkas (id_berkas, ket) values ($idberkas, 'Sertifikat')";
											$this->db->query($sqlInsert);
											$idisi = $this->db->insert_id();
											if($_FILES["fileSerti"]['type'] == "application/pdf")
												$ext=".pdf";
											elseif($_FILES["fileSerti"]['type'] == "image/jpeg" or $_FILES["filediklat"]['type'] == "image/jpg")
												$ext=".jpg";
											elseif($_FILES["fileSerti"]['type'] == "image/png")
												$ext=".png";

											$nf=$this->input->post('txtNip')."-".$idberkas."-".$idisi."$ext";
											$sqlUpdate = "update isi_berkas set file_name='$nf' where id_isi_berkas=$idisi";
											$this->db->query($sqlUpdate);
											if ($this->db->trans_status() === FALSE) {
												$this->db->trans_rollback();
											}else{
												$this->db->trans_commit();
												rename($uploadfile,"../simpeg/Berkas/".$nf);
											}
										}
									}
									$upload_status = 'Data sukses terupload';
									$upload_kode = 2;
								}else{
									$upload_status = 'File tidak terupload. Ada permasalahan ketika mengakses jaringan.';
									$upload_kode = 1;
								}
							}
						}else{
							$upload_status = 'File tidak terupload. Tipe file belum sesuai';
							$upload_kode = 1;
						}
					}else{
						$upload_status = '';
						$upload_kode = 0;
					}
				}
			}
		}else{
			$tx_result = '';
			$upload_kode = '';
			$upload_status = '';
		}

		$this->load->view('diklat/tambah_data_diklat',
				array(
						'list_jenis'=>$jenisDiklat,
						'tx_result' => $tx_result,
						'upload_kode' => $upload_kode,
						'upload_status' => $upload_status
				));
		$this->load->view('layout/footer');
	}

	public function ubah_data_diklat(){
		$jenisDiklat = $this->diklat->getJenisDiklat();
		$id_diklat = $this->input->post('id_diklat');
		$listdata = $this->diklat->getUbahDiklat($id_diklat);
		$this->load->view('diklat/ubah_data_diklat',
				array(
						'list_data' => $listdata,
						'list_jenis'=>$jenisDiklat
				));
	}

	public function update_data_diklat(){
		$id_diklat = $this->input->post('id_diklat');
		$data = array(
				'idjenis' => $this->input->post('idjenis'),
				'judul' => $this->input->post('judul'),
				'jdl_makalah' => $this->input->post('jdl_makalah'),
				'tglpelaksanaan' => $this->input->post('tglpelaksanaan'),
				'jumlah_jam' => $this->input->post('jam'),
				'penyelenggara' => $this->input->post('penyelenggara'),
				'nosttpl' => $this->input->post('sttpl'),
				'id_pegawai' => $this->input->post('id_pegawai'),
				'id_diklat' => $id_diklat
		);

		//print_r($data);

		$update = $this->diklat->update_data_diklat($data);
		if($update){
			if(isset($_FILES["fileSertiEd"])){
				if($_FILES["fileSertiEd"]['name'] <> "" ){
					if($_FILES["fileSertiEd"]['type']=='binary/octet-stream' or $_FILES["fileSertiEd"]['type'] == "application/pdf" or $_FILES["fileSertiEd"]['type'] == "image/jpeg" or $_FILES["fileSertiEd"]['type'] == "image/jpg" or $_FILES["fileSertiEd"]['type'] == "image/png" ){
						if($_FILES["fileSertiEd"]['size'] > 20097152) {
							//Data sukses tersimpan
							//File tidak terupload. Ukuran file terlalu besar;
							echo 2;
						}else{
							//$uploaddir = dirname($_SERVER['SCRIPT_FILENAME']).'/Berkas/';
							$uploaddir = '../simpeg/Berkas/';
							$uploadfile = $uploaddir . basename($_FILES["fileSertiEd"]['name']);
							if (move_uploaded_file($_FILES["fileSertiEd"]['tmp_name'], $uploadfile)) {
								$this->db->trans_begin();
								$sqlInsert = "insert into berkas (id_pegawai,id_kat,nm_berkas,tgl_upload,created_by,created_date,ket_berkas) ".
										"values (".$this->input->post('id_pegawai').", 6,'Sertifikat', DATE(NOW()), '".$this->session->userdata('user')->id_pegawai."', NOW(), '')";
								$this->db->query($sqlInsert);
								if ($this->db->trans_status() === FALSE){
									$this->db->trans_rollback();
								}else{
									$idberkas = $this->db->insert_id();
									$sqlUpdate = "update diklat set id_berkas = $idberkas where id_diklat=".$id_diklat;
									$this->db->query($sqlUpdate);
									if ($this->db->trans_status() === FALSE){
										$this->db->trans_rollback();
									}else{
										$sqlInsert = "insert into isi_berkas (id_berkas, ket) values ($idberkas, 'Sertifikat')";
										$this->db->query($sqlInsert);
										$idisi = $this->db->insert_id();
										if($_FILES["fileSertiEd"]['type'] == "application/pdf")
											$ext=".pdf";
										elseif($_FILES["fileSertiEd"]['type'] == "image/jpeg" or $_FILES["filediklat"]['type'] == "image/jpg")
											$ext=".jpg";
										elseif($_FILES["fileSertiEd"]['type'] == "image/png")
											$ext=".png";

										$nf=$this->input->post('nip')."-".$idberkas."-".$idisi."$ext";
										$sqlUpdate = "update isi_berkas set file_name='$nf' where id_isi_berkas=$idisi";
										$this->db->query($sqlUpdate);
										if ($this->db->trans_status() === FALSE) {
											$this->db->trans_rollback();
										}else{
											$this->db->trans_commit();
											rename($uploadfile,"../simpeg/Berkas/".$nf);
										}
									}
								}
								//Data sukses tersimpan
								//File sukses terupload
								echo 3;
							}else{
								//Data sukses tersimpan
								//File tidak terupload. Ada permasalahan ketika mengakses jaringan
								echo 4;
							}
						}
					}else{
						//Data sukses tersimpan
						//File tidak terupload. Tipe file belum sesuai;
						echo 5;
					}
				}else{
					// Data sukses tersimpan
					echo 1;
				}
			}else{
				// Data sukses tersimpan
				echo 1;
			}
		}else{
			$error = $this->db->error();
			echo "ERROR : ".$error['message'];
		}
	}

	public function info_pegawai_add(){
		$nip = $this->input->post('nipCari');
		$listdata = $this->diklat->getInfoPegawai($nip);
		$this->load->view('diklat/info_pegawai',
				array(
					'list_data' => $listdata,
					'status' => 'add'
				));
	}

	public function info_pegawai_edit(){
		$nip = $this->input->post('nipCari');
		$listdata = $this->diklat->getInfoPegawai($nip);
		$this->load->view('diklat/info_pegawai',
				array(
					'list_data' => $listdata,
					'status' => 'edit'
				));
	}

	public function hapus_data_diklat(){
		$id = $this->input->post('id_diklat');
		if($this->diklat->hapus_data_diklat($id)){
			echo "BERHASIL";
		}else{
			$error = $this->db->error();
			echo "ERROR : ".$error['message'];
		}
	}

	public function view_detail_pejabat_by_rekap(){
		$status = $this->input->post('status');
		$eselon = $this->input->post('eselon');
		$listdata = $this->diklat->getDetailListPejabat($status, $eselon);
		$this->load->view('diklat/detail_list_pejabat',
				array(
						'list_data' => $listdata,
						'status' => $status,
						'eselon' => $eselon
				));
	}

	/* ===================================================================================== */
	/////////////////////// KEBUTUHAN DIKLAT /////////////////////

	public function list_kebutuhan_diklat(){
		$this->load->view('layout/header', array( 'title' => 'Manajemen Diklat dan Pengembangan SDA', 'idproses' => 3));
		$this->load->view('diklat/header');
		$list_bidang = $this->diklat->getBidangPendidikan();
		$status = $this->input->get('status');
		$jenis = $this->input->get('jenis');
		$bidang = $this->input->get('bidang');
		/*if(!$status){
			$status = 1;
		}*/
		$data['diklats'] = $this->diklat->get_pengajuan($status,$jenis,$bidang);
		$jenisDiklat = $this->diklat->getJenisDiklat();
		/*$x=0;
		foreach($data['diklats'] as $diklat){
			$data['diklats'][$x++]->detail = $this->diklat->get_detail_pengajuan($diklat->id);
		}*/
		$data['list_bidang'] = $list_bidang;
		$data['id_status'] = $status;
		$data['id_jenis'] = $jenis;
		$data['id_bidang'] = $bidang;
		$data['list_jenis'] = $jenisDiklat;
		$this->load->view('diklat/pengajuan',$data);
		$this->load->view('layout/footer');
	}

	public function detail($id){
		//$data['diklat'] = $this->diklat->get_pengajuan_by_id($id);
		$data['diklat'] = $this->diklat->get_kebutuhan_diklat_by_id($id);
		$data['rekap_peserta'] = $this->diklat->get_rekap_keikutsertaan_peserta($id);
		$data['details'] = $this->diklat->get_detail_pengajuan($id);
		$this->load->view('layout/header', array( 'title' => 'Administrasi Perencanaan Diklat'));

		$this->load->view('diklat/detail',$data);
	}

	public function download_pengajuan($id){

		$data['diklats'] = $this->diklat->get_pengajuan_by_id($id);
		$data['details'] = $this->diklat->get_detail_pengajuan($id);

		//echo "idnya ".$id;
		$this->load->view('diklat/download',$data);
	}

	public function hapus(){

		$id = $this->input->post('id');
		if($this->diklat->hapus($id)){
			echo "BERHASIL";
		}else{
			$error = $this->db->error();
			echo "ERROR : ".$error['message'];
		}
	}

	public function get_list_detail(){


		$data['diklats'] = $this->diklat->get_detail_pengajuan($this->input->post('id'));

		$html = "<table class='table'><thead><tr><th>No</th><th>Nama</th><th>NIP</th><th>Jabatan</th><th>Unit Kerja</th></tr></thead>" ;
		$html .= "<tbody>";
		$x=1;

		foreach($data['diklats'] as $diklat){
			$html .="<tr><td>".$x++."</td><td>".$diklat->nama_lengkap."</td><td>".$diklat->nip_baru
					."</td><td>".$diklat->jabatan."</td><td>".$diklat->nama_baru."</td></tr>";

		}
		$html .= "</tbody></table>";
		$html .="<br>";
		//echo $html;
		echo json_encode($data['diklats']);
	}

	public function ubah_status(){

		if($this->diklat->ubah_status($this->input->post('id'), $this->input->post('status'))){
			echo "BERHASIL";
		}else{
			echo "GAGAL";
		}
	}

	public function simpan_tgl_pelaksanaan(){

		if($this->diklat->ubah_tanggal_pelaksanaan($this->input->post('id'), $this->input->post('tgl_pelaksanaan'))){
			echo "BERHASIL";
		}else{
			echo "GAGAL";
		}
	}

	public function ubah_keikutpesertaan_diklat(){

	}

	public function list_penyusunan_diklat(){
		$this->load->view('layout/header', array( 'title' => 'Manajemen Diklat dan Pengembangan SDA', 'idproses' => 4));
		$this->load->view('diklat/header');

		$jenisDiklat = $this->diklat->getJenisDiklat();
		$idjenis = $this->input->get('idjenis');
		$tgldari = $this->input->get('tgldari');
		$tgldari2 = $tgldari;
		if(isset($tgldari) and $tgldari != NULL and $tgldari != 0){
			$tgldari = explode(".", $tgldari);
			$tgldari = $tgldari[2].'-'.$tgldari[1].'-'.$tgldari[0];
		}
		$tglsampai = $this->input->get('tglsampai');
		$tglsampai2 = $tglsampai;
		if(isset($tglsampai) and $tglsampai != NULL and $tglsampai != 0){
			$tglsampai = explode(".", $tglsampai);
			$tglsampai = $tglsampai[2].'-'.$tglsampai[1].'-'.$tglsampai[0];
		}
		$chkWaktu = $this->input->get('chkWaktu');
		$jenjab = $this->input->get('jenjab');
		$keywordCari = $this->input->get('keywordCari');
		$filter = $this->input->get('filter');
		if($filter==''){
			$filter = 'Diklat';
		}
		$num_rows = $this->diklat->get_count_list_data_diklat($idjenis,$tgldari,$tglsampai,$chkWaktu,$jenjab,$keywordCari,$filter);
		if($num_rows>0){
			$pages = new Paginator($num_rows,9,array(10,3,6,9,15,25,50,100,'All'));
			$pgDisplay = $pages->display_pages();
			$curpage = $pages->current_page;
			$numpage = $pages->num_pages;
			$total_items = $pages->total_items;
			$jumppage = $pages->display_jump_menu();
			$item_perpage = $pages->display_items_per_page();
			$list_data = $this->diklat->get_list_diklat_sprint($pages->limit_start,$pages->limit_end,$idjenis,$tgldari,$tglsampai,$chkWaktu,$jenjab,$keywordCari,$filter);
		}else{
			$pgDisplay = '';
			$curpage = '';
			$numpage = '';
			$total_items = '';
			$jumppage = '';
			$item_perpage = '';
			$list_data = '';
		}

		$this->load->view('diklat/sprint_diklat',
		array(
				'list_data' => $list_data,
				'pgDisplay' => $pgDisplay,
				'curpage' => $curpage,
				'numpage' => $numpage,
				'total_items' => $total_items,
				'jumppage' => $jumppage,
				'item_perpage' => $item_perpage,
				'list_jenis'=>$jenisDiklat,
				'keywordCari' => $keywordCari,
				'idjenis' => $idjenis,
				'tgldari2' => $tgldari2,
				'tglsampai2' => $tglsampai2,
				'chkWaktu' => $chkWaktu,
				'jenjab' => $jenjab,
				'filter' => $filter)
		);
	}

	public function sprint_detail($iddiklat_sprint){

		$this->load->view('layout/header', array( 'title' => 'Manajemen Diklat dan Pengembangan SDA', 'idproses' => 4));
		$this->load->view('diklat/header');
		$list_data = $this->diklat->get_sprint_detail($iddiklat_sprint);
		echo $this->db->last_query();
		$this->load->view('diklat/sprint_detail',
			array(
				'list_data'=>$list_data
			)
		);

	}

	public function penyusunan_kompetensi(){
        $this->load->view('layout/header', array( 'title' => 'Manajemen Diklat dan Pengembangan SDA', 'idproses' => 5));
        $this->load->view('diklat/header');
        $id_skpd = $this->input->get('id_skpd');
        $jenjab = $this->input->get('jenjab');
        $keywordCari = $this->input->get('keywordCari');
        $num_rows = $this->diklat->jml_pengembangan_kompetensi($id_skpd,$jenjab,$keywordCari);
        if($num_rows>0){
            if($this->input->get('page')==''){
                $start = 1;
            }else{
                $start = ($this->input->get('page')*$this->input->get('ipp'))-($this->input->get('ipp')-1);
            }
            $pages = new Paginator($num_rows,9,array(10,15,25,50,100,'All'));
            $pgDisplay = $pages->display_pages();
            $curpage = $pages->current_page;
            $numpage = $pages->num_pages;
            $total_items = $pages->total_items;
            $jumppage = $pages->display_jump_menu();
            $item_perpage = $pages->display_items_per_page();
            $list_data = $this->diklat->pengembangan_kompetensi($pages->limit_start,$pages->limit_end,$id_skpd,$jenjab,$keywordCari);
        }else{
            $pgDisplay = '';
            $curpage = '';
            $numpage = '';
            $total_items = '';
            $jumppage = '';
            $item_perpage = '';
            $list_data = '';
        }

        $getSKPD = $this->diklat->getSKPD();

        $this->load->view('diklat/penyusunan_kompetensi',
            array(
                'start' => $start,
                'list_data' => $list_data,
                'pgDisplay' => $pgDisplay,
                'curpage' => $curpage,
                'numpage' => $numpage,
                'list_skpd' => $getSKPD,
                'total_items' => $total_items,
                'jumppage' => $jumppage,
                'item_perpage' => $item_perpage,
                'id_skpd'=> $id_skpd,
                'jenjab' => $jenjab,
                'keywordCari' => $keywordCari
            ));
        $this->load->view('layout/footer');
    }

}
