<?php
	class Perubahan_Keluarga extends CI_Controller
	{
		public function index()
		{
			$this->perubahan_keluarga_admin();
			
		}
		
//REKAPITULASI
		public function rekapitulasi()
		{
			$jan_t 	 	= $this->perubahan_keluarga_m->rekap_penambahan_januari();
			$januari_t 	= $jan_t->row();
			
			
			
			$feb_t	 	= $this->perubahan_keluarga_m->rekap_penambahan_februari();
			$februari_t = $feb_t->row();
		
			
			
			$mar_t	 	= $this->perubahan_keluarga_m->rekap_penambahan_maret();
			$maret_t 	= $mar_t->row();
			
			
			$apr_t	 	= $this->perubahan_keluarga_m->rekap_penambahan_april();
			$april_t 	= $apr_t->row();
			
			
			$mei_tm	 	= $this->perubahan_keluarga_m->rekap_penambahan_mei();
			$mei_t 		= $mei_tm->row();
			
			$jun_t	 	= $this->perubahan_keluarga_m->rekap_penambahan_juni();
			$juni_t 	= $jun_t->row();
			
			$jul_t	 	= $this->perubahan_keluarga_m->rekap_penambahan_juli();
			$juli_t 	= $jul_t->row();

			
			$agu_t	 	= $this->perubahan_keluarga_m->rekap_penambahan_agustus();
			$agustus_t 	= $agu_t->row();
			
			$sep_t	 	= $this->perubahan_keluarga_m->rekap_penambahan_september();
			$september_t = $sep_t->row();
			
			$okt_t	 	= $this->perubahan_keluarga_m->rekap_penambahan_oktober();
			$oktober_t 	= $okt_t->row();
			
			$nov_t	 	= $this->perubahan_keluarga_m->rekap_penambahan_november();
			$november_t = $nov_t->row();
			
			$des_t	 	= $this->perubahan_keluarga_m->rekap_penambahan_desember();
			$desember_t = $des_t->row();
			
			$jan_k 	 	= $this->perubahan_keluarga_m->rekap_pengurangan_januari();
			$januari_k 	= $jan_k->row();
			
			$feb_k 	 	= $this->perubahan_keluarga_m->rekap_pengurangan_februari();
			$februari_k = $feb_k->row();
			
			$mar_k 	 	= $this->perubahan_keluarga_m->rekap_pengurangan_maret();
			$maret_k 	= $mar_k->row();
			
			$apr_k	 	= $this->perubahan_keluarga_m->rekap_pengurangan_april();
			$april_k 	= $apr_k->row();
			
			$mei_kg	 	= $this->perubahan_keluarga_m->rekap_pengurangan_mei();
			$mei_k 		= $mei_kg->row();
			
			$jun_k	 	= $this->perubahan_keluarga_m->rekap_pengurangan_juni();
			$juni_k 	= $jun_k->row();
			
			$jul_k	 	= $this->perubahan_keluarga_m->rekap_pengurangan_juli();
			$juli_k 	= $jul_k->row();
			
			$agu_k	 	= $this->perubahan_keluarga_m->rekap_pengurangan_agustus();
			$agustus_k 	= $agu_k->row();
			
			$sep_k	 	= $this->perubahan_keluarga_m->rekap_pengurangan_september();
			$september_k = $sep_k->row();
			
			$okt_k	 	= $this->perubahan_keluarga_m->rekap_pengurangan_oktober();
			$oktober_k 	= $okt_k->row();
			
			$nov_k	 	= $this->perubahan_keluarga_m->rekap_pengurangan_november();
			$november_k = $nov_k->row();
			
			$des_k	 	= $this->perubahan_keluarga_m->rekap_pengurangan_desember();
			$desember_k = $des_k->row();
			
			$jum_t		= $this->perubahan_keluarga_m->jumlah_rekap_penambahan();
			$jumlah_t	= $jum_t->row();
			
			$jum_k		= $this->perubahan_keluarga_m->jumlah_rekap_pengurangan();
			$jumlah_k	= $jum_k->row();
			
			$this->load->view('perubahan_keluarga/rekapitulasi_perubahan_keluarga_v',
			                  array('januari_t'=>$januari_t,
							        'februari_t'=>$februari_t,
									'maret_t'=>$maret_t,
									'april_t'=>$april_t,
									'mei_t'=>$mei_t,
									'juni_t'=>$juni_t,
									'juli_t'=>$juli_t,
									'agustus_t'=>$agustus_t,
									'september_t'=>$september_t,
									'oktober_t'=>$oktober_t,
									'november_t'=>$november_t,
									'desember_t'=>$desember_t,
									'januari_k'=>$januari_k,
									'februari_k'=>$februari_k,
									'maret_k'=>$maret_k,
									'april_k'=>$april_k,
									'mei_k'=>$mei_k,
									'juni_k'=>$juni_k,
									'juli_k'=>$juli_k,
									'agustus_k'=>$agustus_k,
									'september_k'=>$september_k,
									'oktober_k'=>$oktober_k,
									'november_k'=>$november_k,
									'desember_k'=>$desember_k,
									'jumlah_t'=>$jumlah_t,
									'jumlah_k'=>$jumlah_k));
									
			$this->load->view('layout/footer');
		}
//END REKAPITULASI

//DAFTAR PENGAJUAN
		public function daftar_pengajuan_perubahan()
		{
			$this->load->model('perubahan_keluarga_m');
			$this->load->view('layout/header', array( 'title' => 'KGB Pegawai Negeri Sipil'));
			$this->notifikasi();
			
			$daftar_pengajuan = $this->perubahan_keluarga_m->daftar_pengajuan();
			
			$this->load->view('perubahan_keluarga/daftar_pengajuan_perubahan_v', array('daftar_pengajuan'=>$daftar_pengajuan));
			$this->load->view('layout/footer');
		}
		
		public function notifikasi()
		{
			$this->load->model('perubahan_keluarga_m');
			
			$jumlah = $this->perubahan_keluarga_m->get_notifikasi_jumlah_pengajuan();
			$jumlah_notifikasi = $jumlah->num_rows();
			// $jum 	= $jumlah->row();
			// $jumlah_notifikasi = $jum->jumlah_pengajuan;
			
			$this->load->view('perubahan_keluarga/header', array('jumlah_notifikasi'=>$jumlah_notifikasi));
		}
		
		public function lihat_detail()
		{
			$this->load->model('perubahan_keluarga_m');
			
			$this->load->helper("directory");
			
			$this->load->view('layout/header', array( 'title' => 'KGB Pegawai Negeri Sipil'));
			$this->notifikasi();
			
			$id_peg = $this->uri->segment(4);
			$tgl 	= $this->uri->segment(3);
			$st 	= $this->uri->segment(5);
			
			
			$detail 		= $this->perubahan_keluarga_m->get_keluarga_by_status_tgl($tgl, $id_peg, $st);
			$berkas_dasar 	= $this->perubahan_keluarga_m->get_berkas_dasar_pegawai($id_peg);
			
			$bd = $berkas_dasar->row();
			
			//lihat berkas dasar
			$surat_uk 		  = substr($bd->surat_pengantar_dari_unit_kerja, 53);
			$sk_terakhir 	  = substr($bd->sk_terakhir,53);
			$skumptk		  = substr($bd->skumptk,53);
			$gaji_terakhir	  = substr($bd->gaji_bulan_terakhir,53);
			
			
			$files_surat_uk 			= directory_map($surat_uk);
			$files_sk_terakhir 			= directory_map($sk_terakhir);
			$files_skumptk				= directory_map($skumptk);
			$files_gaji_terakhir		= directory_map($gaji_terakhir);
			
			$surat_nikah 	= NULL;
			$kelahiran_anak = NULL;
			$ket_kuliah 	= NULL;
			$surat_mati_ak 	= NULL;
			$surat_mati_si 	= NULL;
			$surat_cerai 	= NULL;
			$ket_kerja 		= NULL;
			$ket_kerja 		= NULL;
						
						
			//lihat berkas perubahan
			foreach($detail->result() as $d)
			{
				if(($d->dapat_tunjangan == 1 || $d->dapat_tunjangan == 2) && $d->id_status == 9)
				{
					if($d->fc_surat_nikah != NULL)
					{
						$surat_nikah 	= substr($d->fc_surat_nikah,43);
						$f_surat_nikah 	= directory_map($surat_nikah);
					}
				}
				else if(($d->dapat_tunjangan == 1 || $d->dapat_tunjangan == 2)&& $d->id_status == 10)
				{
					if($d->fc_kelahiran_anak != NULL)
					{
						$kelahiran_anak 	= substr($d->fc_kelahiran_anak,43);
						$f_kelahiran_anak	= directory_map($kelahiran_anak);
						
					}
					if($d->fc_keterangan_kuliah != NULL)
					{
						$ket_kuliah			= substr($d->fc_keterangan_kuliah,43);
						$f_ket_kuliah		= directory_map($ket_kuliah);
					}
				}
				else if(($d->dapat_tunjangan == -2 or $d->dapat_tunjangan == -1) && $d->id_status == 9)
				{
					if($d->fc_surat_kematian != NULL)
					{
						$surat_mati_si			= substr($d->fc_surat_kematian,44);
						$f_surat_mati_si		= directory_map($surat_mati_si);
						
						
					}
					
					if($d->fc_surat_cerai != NULL)
					{
						$surat_cerai 	= substr($d->fc_surat_cerai,44);
						$f_surat_cerai	= directory_map($surat_cerai);
					}
					
				}
				else if(($d->dapat_tunjangan == -1 OR $d->dapat_tunjangan == -2) && $d->id_status == 10)
				{
					if($d->fc_surat_kematian != NULL)
					{
						$surat_mati_ak			= substr($d->fc_surat_kematian,44);
						$f_surat_mati_ak		= directory_map($surat_mati_ak);
						
					}
					
					if($d->fc_keterangan_kerja != NULL)
					{
						$ket_kerja 		= substr($d->fc_keterangan_kerja,44);
						$f_ket_kerja 	= directory_map($ket_kerja);
					}
				}
			}
			
			$this->load->view('perubahan_keluarga/lihat_detail_v',array('detail'=>$detail, 'berkas_dasar'=>$berkas_dasar,
																		'surat_uk'=>$surat_uk, 'sk_terakhir'=>$sk_terakhir,
																		'skumptk'=>$skumptk, 'gaji_terakhir'=>$gaji_terakhir,
																		'surat_nikah'=>$surat_nikah, 'kelahiran_anak'=>$kelahiran_anak,
																		'ket_kuliah'=>$ket_kuliah, 'surat_mati_si'=>$surat_mati_si,
																		'surat_mati_ak'=>$surat_mati_ak,'ket_kerja'=>$ket_kerja, 'surat_cerai'=>$surat_cerai));
			$this->load->view('layout/footer');
		}
		
		public function update_keterangan()
		{
			$this->load->model('perubahan_keluarga_m');
			
			$st 	= $this->uri->segment(3);
			$tgl 	= $this->uri->segment(4);
			$id_peg	= $this->uri->segment(5);
			
			$ket_tolak = $this->input->post('ket');
			
			if($st == 1 OR $st == 2)
			{
				$flag 	= 2;
				$st_kon = -3;
			}
			else if($st == -1 OR $st == -2)
			{	$flag 	= -2;
				$st_kon = -3;
			}
			
			
			
			$this->perubahan_keluarga_m->tidak_setuju($tgl, $flag, $st, $st_kon, $ket_tolak, $id_peg);
			
			redirect('perubahan_keluarga/daftar_pengajuan_perubahan');
			
		}
		
		
		public function show_data()
		{
			$id			 = $this->uri->segment(3);
			$path_parts  = pathinfo($id);
			$ext = strtolower($path_parts["extension"]);
			
			switch($ext){
				case "gif": $ctype="image/gif"; break;
				case "png": $ctype="image/png"; break;
				case "jpeg":
				case "jpg": $ctype="image/jpg"; break;
				default: $ctype="application/force-download";
			}
			echo header("Content-type: $ctype");
			ob_clean();
			flush();
			readfile("http://localhost/simpeg/assets/berkas_perubahan_keluarga/berkas_dasar_pegawai/".$id);
		}
		
		public function show_data_pengurangan()
		{
			$id			 = $this->uri->segment(3);
			$path_parts  = pathinfo($id);
			$ext = strtolower($path_parts["extension"]);
			
			switch($ext){
				case "gif": $ctype="image/gif"; break;
				case "png": $ctype="image/png"; break;
				case "jpeg":
				case "jpg": $ctype="image/jpg"; break;
				default: $ctype="application/force-download";
			}
			echo header("Content-type: $ctype");
			ob_clean();
			flush();
			readfile("http://localhost/simpeg/assets/berkas_perubahan_keluarga/pengurangan/".$id);
		}
		
		public function show_data_penambahan()
		{
			$id			 = $this->uri->segment(3);
			$path_parts  = pathinfo($id);
			$ext = strtolower($path_parts["extension"]);
			
			switch($ext){
				case "gif": $ctype="image/gif"; break;
				case "png": $ctype="image/png"; break;
				case "jpeg":
				case "jpg": $ctype="image/jpg"; break;
				default: $ctype="application/force-download";
			}
			echo header("Content-type: $ctype");
			ob_clean();
			flush();
			readfile("http://localhost/simpeg/assets/berkas_perubahan_keluarga/penambahan/".$id);
		}
		
		public function setuju()
		{
			$this->load->model('perubahan_keluarga_m');
			
			$st 	= $this->uri->segment(3);
			$tgl 	= $this->uri->segment(4);
			$id_peg = $this->uri->segment(5);
			
			if($st == -2)
			{
				$flag = -1;
				$this->perubahan_keluarga_m->setuju($tgl, $st, $flag, $id_peg);
			}
			else if($st == 2)
			{
				$flag = 1;
				$this->perubahan_keluarga_m->setuju($tgl, $st, $flag, $id_peg);
			}
			
			redirect('perubahan_keluarga/daftar_pengajuan_perubahan');
		}
		
	
//END DAFTAR PENGAJUAN

//CONTROLLER LAPORAN
		public function laporan()
		{
			$this->load->model('perubahan_keluarga_m');
			$this->load->view('layout/header', array( 'title' => 'KGB Pegawai Negeri Sipil'));
			$this->notifikasi();
			
			$tahun_ts = $this->perubahan_keluarga_m->get_tahun_tgl_perubahan();
			
			$bulan = $this->input->get('bulan');
			$tahun = $this->input->get('tahun');
			
			$this->load->view('perubahan_keluarga/laporan_v', array('tahun_ts'=>$tahun_ts));
			
			if($bulan != NULL && $tahun != NULL)
			{
				$bulan = $this->input->get('bulan');
				$tahun = $this->input->get('tahun');
				
				$this->perubahan_keluarga_m->set_bulan_ts($bulan);
				$this->perubahan_keluarga_m->set_tahun_ts($tahun);
				
				$data_pegawai 	 = $this->perubahan_keluarga_m->get_laporan_by_bulan_tahun();
			
				$data_unit_kerja = array();
				$data_tambah_anak 		 = array();
				$data_tambah_suami_istri = array();
				$data_status_proses		 = array();
				$data_kurang_anak		 = array();
				$data_kurang_suami_istri = array();
				$data_jk_si_t			 = array();
				$jk_t					 = array();			
				$i					 	 = 0;
				$i_t					 = 0;
				foreach($data_pegawai->result() as $r)
				{
					$this->perubahan_keluarga_m->set_id_pegawai($r->id_pegawai);
					
					// penambahan Anak
					$rw_t_ak = $this->perubahan_keluarga_m->count_penambahan_anak();
					if($rw_t_ak->num_rows() > 0 )
					{
						$row_t_ak = $rw_t_ak->row();
						$data_tambah_anak[] = $row_t_ak->jumlah_penambahan_anak;
					}
					
					//penambahan Suami/Istri
					$rw_t_si = $this->perubahan_keluarga_m->count_penambahan_suami_istri();
					if($rw_t_si->num_rows() > 0)
					{
						$row_t_si = $rw_t_si->row();
						$data_tambah_suami_istri[] = $row_t_si->jumlah_penambahan_suami_istri;
					}
				
					//Pengurangan anak
					$rw_k_ak = $this->perubahan_keluarga_m->count_pengurangan_anak();
					$row_k_ak = $rw_k_ak->row();
					$data_kurang_anak[] = $row_k_ak->jumlah_pengurangan_anak;
					
					//pengurangan suami atau istri
					$rw_k_si = $this->perubahan_keluarga_m->count_pengurangan_suami_istri();
					$row_k_si = $rw_k_si->row();
					$data_kurang_suami_istri[] = $row_k_si->jumlah_pengurangan_suami_istri;
				
					//menentukan suami/istri pada penambahan
					$jk_t[$i] = $row_t_si->jk;
					if($jk_t[$i]==1)
					{
						$data_jk_si_t[$i]="Suami";
						$i++;
					}
					else if($jk_t[$i]==2)
					{
						$data_jk_si_t[$i]="Istri";
						$i++;
					}
				
					
			}
			$this->load->view('perubahan_keluarga/laporan_hasil_v',array('data_pegawai'=>$data_pegawai,
			                                                             'data_tambah_anak'=>$data_tambah_anak,
																		 'data_tambah_suami_istri'=>$data_tambah_suami_istri,
																		 'data_kurang_anak'=>$data_kurang_anak,
																		 'data_kurang_suami_istri'=>$data_kurang_suami_istri,
																		 'data_jk_si_t'=>$data_jk_si_t
																		));
			}
			
			
			$this->load->view('layout/footer');
		}
		
		
		public function get_laporan_by_bulan_tahun()
		{
			$this->load->model('perubahan_keluarga_m');
			
			//mengambil nilai dari uri segment
			$this->perubahan_keluarga_m->set_bulan_ts($this->uri->segment(3));
			$this->perubahan_keluarga_m->set_tahun_ts($this->uri->segment(4));
			
			//$laporan 	= $this->perubahan_keluarga_m->;get_data_pegawai_in_keluarga();
			$data_pegawai 	 = $this->perubahan_keluarga_m->get_laporan_by_bulan_tahun();
			
			$data_unit_kerja = array();
			$data_tambah_anak 		 = array();
			$data_tambah_suami_istri = array();
			$data_status_proses		 = array();
			$data_kurang_anak		 = array();
			$data_kurang_suami_istri = array();
			$data_jk_si_t			 = array();
			$jk_t					 = array();			
			$i					 	 = 0;
			$i_t					 = 0;
			foreach($data_pegawai->result() as $r)
			{
				$this->perubahan_keluarga_m->set_id_pegawai($r->id_pegawai);
				
				// penambahan Anak
				$rw_t_ak = $this->perubahan_keluarga_m->count_penambahan_anak();
				if($rw_t_ak->num_rows() > 0 )
				{
					$row_t_ak = $rw_t_ak->row();
					$data_tambah_anak[] = $row_t_ak->jumlah_penambahan_anak;
				}
				
				//penambahan Suami/Istri
				$rw_t_si = $this->perubahan_keluarga_m->count_penambahan_suami_istri();
				if($rw_t_si->num_rows() > 0)
				{
					$row_t_si = $rw_t_si->row();
					$data_tambah_suami_istri[] = $row_t_si->jumlah_penambahan_suami_istri;
				}
				
				//Pengurangan anak
				$rw_k_ak = $this->perubahan_keluarga_m->count_pengurangan_anak();
				$row_k_ak = $rw_k_ak->row();
				$data_kurang_anak[] = $row_k_ak->jumlah_pengurangan_anak;
				
				//pengurangan suami atau istri
				$rw_k_si = $this->perubahan_keluarga_m->count_pengurangan_suami_istri();
				$row_k_si = $rw_k_si->row();
				$data_kurang_suami_istri[] = $row_k_si->jumlah_pengurangan_suami_istri;
				
				//menentukan suami/istri pada penambahan
				$jk_t[$i] = $row_t_si->jk;
				if($jk_t[$i]==1)
				{
					$data_jk_si_t[$i]="Suami";
					$i++;
				}
				else if($jk_t[$i]==2)
				{
					$data_jk_si_t[$i]="Istri";
					$i++;
				}
				
					
			}
			
			$this->load->view('perubahan_keluarga/laporan_pdf',array('data_pegawai'=>$data_pegawai,
			                                                             'data_tambah_anak'=>$data_tambah_anak,
																		 'data_tambah_suami_istri'=>$data_tambah_suami_istri,
																		 'data_kurang_anak'=>$data_kurang_anak,
																		 'data_kurang_suami_istri'=>$data_kurang_suami_istri,
																		 'data_jk_si_t'=>$data_jk_si_t
																		));
			
			$content = ob_get_clean();
			require_once('assets/pdf/html2pdf.class.php');
			try
			{
				$html2pdf = new HTML2PDF('L', 'F4', 'fr', true, 'UTF-8', 0);
				$html2pdf->writeHTML($content, isset($_GET['vuehtml']));
				$html2pdf->Output('surat_perubahan_keluarga.pdf','H');
				//$html2pdf->Output('assets/surat_perubahan_keluarga/'.$id,'F');
				
			}
			
			catch(HTML2PDF_exception $e) {
				echo $e;
				exit;
			}
			
		}
//END LAPORAN
		
		// public function view_tunjangan_anak()
		// {
			// $tunjangan_anak = $this->perubahan_keluarga_m->get_tunjangan_anak();
			// $this->load->view('perubahan_keluarga/rekapitulasi_perubahan_keluarga_v', 
							   // array('tunjangan_anak' => $tunjangan_anak));
			// $this->load->view('layout/footer');
		// }
		
		
		public function perubahan_keluarga_admin()
		{
			$this->load->model('perubahan_keluarga_m');
			$this->load->view('layout/header', array( 'title' => 'KGB Pegawai Negeri Sipil'));
			$this->notifikasi();
			
			$keyword = $this->input->post('pencarian');
			
			$this->load->view('perubahan_keluarga/pencarian_perubahan_keluarga_v');
			
			if($keyword != NULL)
			{
				$keyword = $this->input->post('pencarian');
				
				$kw = $this->perubahan_keluarga_m->find_by_nama($keyword);
				
				$this->load->view('perubahan_keluarga/hasil_pencarian_v', array('keyword' => $kw));
			}
			$this->load->view('layout/footer');
			
		}
		
		public function cari()
		{
			$this->load->model('perubahan_keluarga_m');
			
			$kw = $this->perubahan_keluarga_m->find_by_nama($keyword);
		}
		
		public function hasil_pencarian()
		{
			$this->load->model('perubahan_keluarga_m');
			$this->load->view('layout/header', array( 'title' => 'KGB Pegawai Negeri Sipil'));
			$this->notifikasi();
			$this->perubahan_keluarga_m->set_keyword_nama($this->input->post('pencarian'));
			$this->perubahan_keluarga_m->set_keyword_nip($this->input->post('pencarian'));
			
			$kw = $this->perubahan_keluarga_m->find_by_nama();
			$this->load->view('perubahan_keluarga/hasil_pencarian_v', array('keyword' => $kw));
		}
		
		
		public function data_pegawai_by_id()
		{
			$this->load->view('layout/header', array( 'title' => 'KGB Pegawai Negeri Sipil'));
			$this->notifikasi();
			$this->load->model('perubahan_keluarga_m');
			
			$this->perubahan_keluarga_m->set_id_pegawai($this->uri->segment(3));
			$pegawai = $this->perubahan_keluarga_m->get_pegawai_by_id();
			$rs 	 = $pegawai->row();
			
			//untuk menampilkan suami atau istri
			$keluarga_suami_istri = $this->perubahan_keluarga_m->get_suami_istri_by_id_pegawai();
			$keluarga_anak 		  = $this->perubahan_keluarga_m->get_anak_by_id_pegawai();
			$keluarga_lainnya 	  = $this->perubahan_keluarga_m->get_keluarga_lainnya();
			
			$status_si = array();
			$status_ak = array();
			
			$id_si = array();
			$id_ak = array();
			
			
			//mengambil id berkas suami atau istri
			// foreach($keluarga_suami_istri->result() as $r)
			// {
				// //$id_si[] = $r->id_keluarga;
				// $id_si = $this->perubahan_keluarga_m->cek_berkas_si($r->id_keluarga);
				// $rw   = $id_si->row();
				
				// if($id_si->num_rows() > 0 && $rw->fc_surat_nikah != NULL ){
					// $status_si[] = 1;
				// }else{
					// $status_si[] = 0;
				// }
					
			// }
			
			//mengambil id berkas anak
			foreach($keluarga_anak->result() as $r)
			{
				$id_keluarga = $r->id_keluarga;
				$id_ak 		= $this->perubahan_keluarga_m->cek_berkas_ak($id_keluarga);
				
				
				//mengecek umur
				$cek_upload = $this->perubahan_keluarga_m->cek_umur_for_berkas($id_keluarga);
				$ck 		= $cek_upload->row();
				$cu			= $ck->umur;
				
				if($id_ak->num_rows() > 0)
				{
					$ra    		= $id_ak->row();
					if(($ra->fc_keterangan_kuliah == NULL && $cu < 21) || $ra->fc_keterangan_kuliah != NULL && $cu > 21) 
							{
								$status_ak[] = 1;
							}else{
								$status_ak[] = 0;
							}
				}
				else 
					$status_ak[] = 2;
					
			}
			
			$berkas_tl_si[] = array();
			$berkas_tl_ak[] =  array();
			
			
			
			$this->load->view('perubahan_keluarga/data_pegawai_v',array('data_pegawai'=> $pegawai,
																		'r'=> $rs,
																		'keluarga_suami_istri'=>$keluarga_suami_istri,
																		'keluarga_anak'=>$keluarga_anak,
																		'keluarga_lainnya'=>$keluarga_lainnya,
																		'status_si'=>$status_si,
																		'status_ak'=>$status_ak));	
			$this->load->view('layout/footer');
		}
		
		
		
		function get_file_type($input)
		{
			switch($input)
			{
				case  "image/png" :
					 return ".png";
				case  "image/jpg" :
					return ".jpg";
				case  "image/jpeg" :
					return ".jpeg";
				case  "image/gif" :
					return ".gif";
				case  "application/pdf" :
					return ".pdf";
			}	
		}	
		
		public function upload_edit_penambahan($id_pegawai, $id_keluarga)
		{
			$this->load->model('perubahan_keluarga_m');
			
			
			$status = $this->input->post('id_status');
			
			
			$p1 = NULL;
			$p2 = NULL;
			$p3 = NULL;
			
			if($status == 9)
			{
				$nama_file_4 =  $id_keluarga."_surat_nikah";
				
				$nama_file_4 .= $this->get_file_type($_FILES['ufile_si']['type'][0] );
				
				$_FILES['ufile_si']['name'][0] = $nama_file_4;
				
				$path1= "assets/upload_berkas/penambahan/".$_FILES['ufile_si']['name'][0];
		

				//copy file to where you want to store file
				copy($_FILES['ufile_si']['tmp_name'][0], $path1);
				
				//alamat untuk menyimpan path pada database
				$p1 = base_url().$path1;
				
				$this->perubahan_keluarga_m->insert_berkas_penambahan($id_keluarga,$p1,$p2,$p3);
			}
			else if($status==10)
			{
				
				$nama_file_4 =  $id_keluarga."_surat_kelahiran_anak";
				
				$nama_file_4 .= $this->get_file_type($_FILES['ufile_ak']['type'][0] );
				
				$_FILES['ufile_ak']['name'][0] = $nama_file_4;
				
				
				$path2 = "assets/upload_berkas/penambahan/".$_FILES['ufile_ak']['name'][0];
				
				//copy file to where you want to store file
				copy($_FILES['ufile_ak']['tmp_name'][0], $path2);
				
				//alamat untuk menyimpan path pada database
				$p2 = base_url().$path2;
				
				$this->perubahan_keluarga_m->insert_berkas_penambahan($id_keluarga,$p1, $p2, $p3);
				
			}
			
		}
		
		public function upload_penambahan()
		{
			$this->load->model('perubahan_keluarga_m');
			
			$status	= $this->input->post('pilih_hubungan');
			
			$id_pegawai = $this->uri->segment(3);
			
			$max_id_kel = $this->perubahan_keluarga_m->get_max_id_keluarga();
			
			$maks = $max_id_kel->row();
			$id_k = $maks->max_ik;
			
			
			$p1 = NULL;
			$p2 = NULL;
			$p3 = NULL;
			
			if($status == 9)
			{
				$nama_file_4 = $id_k."_surat_nikah";
				
				$nama_file_4 .= $this->get_file_type($_FILES['ufile_si']['type'][0] );
				
				$_FILES['ufile_si']['name'][0] = $nama_file_4;
				
				$path1= "assets/upload_berkas/penambahan/".$_FILES['ufile_si']['name'][0];
		

				//copy file to where you want to store file
				copy($_FILES['ufile_si']['tmp_name'][0], $path1);
				
				//alamat untuk menyimpan path pada database
				$p1 = base_url().$path1;
				
				$this->perubahan_keluarga_m->insert_berkas_penambahan($id_k,$p1,$p2,$p3);
			}
			else if($status==10)
			{
				
				$nama_file_4 = $id_k."_surat_kelahiran_anak";
				
				$nama_file_4 .= $this->get_file_type($_FILES['ufile_ak']['type'][0] );
				
				$_FILES['ufile_ak']['name'][0] = $nama_file_4;
				
				
				$path2 = "assets/upload_berkas/penambahan/".$_FILES['ufile_ak']['name'][0];
				
				//copy file to where you want to store file
				copy($_FILES['ufile_ak']['tmp_name'][0], $path2);
				
				//alamat untuk menyimpan path pada database
				$p2 = base_url().$path2;
				
				$this->perubahan_keluarga_m->insert_berkas_penambahan($id_k,$p1, $p2, $p3);
				
			}
			
		}
		
		
		public function penambahan_jiwa()
		{
			$this->load->view('layout/header', array( 'title' => 'KGB Pegawai Negeri Sipil'));
			$this->notifikasi();
			$this->load->view('perubahan_keluarga/penambahan_jiwa_v');
			$this->load->model('perubahan_keluarga_m');
			
			if($this->input->post('pilih_hubungan') != NULL)
			{
				$tj = $this->input->post('pilih_tunjangan');
				$hubungan = $this->input->post('pilih_hubungan');
				
				$this->perubahan_keluarga_m->set_id_pegawai($this->input->post('id_pegawai'));
			
				
				if($hubungan == 9)
				{
					$this->perubahan_keluarga_m->set_id_status($hubungan);
					$this->perubahan_keluarga_m->set_nama($this->input->post('nama_si'));
					$this->perubahan_keluarga_m->set_tempat_lahir($this->input->post('tempat_lahir_si'));
					$this->perubahan_keluarga_m->set_tanggal_lahir($this->input->post('tanggal_lahir_si'));
					$this->perubahan_keluarga_m->set_tanggal_menikah($this->input->post('tanggal_menikah_si'));
					$this->perubahan_keluarga_m->set_akte_menikah($this->input->post('akte_menikah_si'));
					$this->perubahan_keluarga_m->set_pekerjaan($this->input->post('pekerjaan_si'));
					$this->perubahan_keluarga_m->set_jenis_kelamin($this->input->post('pilih_jk_si'));
					$this->perubahan_keluarga_m->set_dapat_tunjangan($this->input->post('pilih_tunjangan'));
					$this->perubahan_keluarga_m->set_status_konfirmasi($this->input->post('status_konfirmasi'));
					$this->perubahan_keluarga_m->set_keterangan($this->input->post('keterangan_si'));
				
					
				//query insert suami/istri
				$this->perubahan_keluarga_m->insert_data_suami_istri();
				
				//melakukan upload berkas dan insert alamat berkas
				if($tj == 1)
					$this->upload_penambahan();
					
				}
				else if($hubungan == 10)
				{
					$this->perubahan_keluarga_m->set_id_status($this->input->post('pilih_hubungan'));
					$this->perubahan_keluarga_m->set_nama($this->input->post('nama_ak'));
					$this->perubahan_keluarga_m->set_tempat_lahir($this->input->post('tempat_lahir_ak'));
					$this->perubahan_keluarga_m->set_tanggal_lahir($this->input->post('tanggal_lahir_ak'));
					$this->perubahan_keluarga_m->set_jenis_kelamin($this->input->post('pilih_jk_ak'));
					$this->perubahan_keluarga_m->set_dapat_tunjangan($this->input->post('pilih_tunjangan'));
					$this->perubahan_keluarga_m->set_status_konfirmasi($this->input->post('status_konfirmasi'));
					$this->perubahan_keluarga_m->set_keterangan($this->input->post('keterangan_ak'));
					
					//query insert anak
					$this->perubahan_keluarga_m->insert_data_anak();
					
					//melakukan upload berkas dan insert alamat berkas
					if($tj == 1)
						$this->upload_penambahan();
				}
				
			}
			$this->load->view('layout/footer');
		}
		
		public function load_data_penambahan()
		{
			$hub = $this->input->get('hubungan');
			$this->load->model('perubahan_keluarga_m');
			
			$this->perubahan_keluarga_m->set_id_pegawai($_GET['id_pegawai']);
			
			$tunjangan = $_GET['tunjangan'];
			
			$jsi = $this->perubahan_keluarga_m->get_si_dapat_tunjangan();
			$jak = $this->perubahan_keluarga_m->get_ak_dapat_tunjangan();
			
			$jumlah_si = $jsi->num_rows();
			$jumlah_ak = $jak->num_rows();
		
			$jekel 	= $this->perubahan_keluarga_m->get_pegawai_by_id();
			$r 		= $jekel->row();
			$jk 	= $r->jenis_kelamin;
		
			
			$this->load->view('perubahan_keluarga/hubungan_penambahan_v', array(
							  'hub'=>$hub,
							  'jumlah_si'=>$jumlah_si,
							  'jumlah_ak'=>$jumlah_ak,
							  'tunjangan'=>$tunjangan,
							  'jk'=>$jk
							  ));
		}
		
		public function berkas_penambahan()
		{
			$this->load->model('perubahan_keluarga_m');
			
			$hub = $this->input->get('hubungan');
			$tj  = $this->input->get('tunjangan');
			
			$this->perubahan_keluarga_m->set_id_pegawai($_GET['id_pegawai']);
			
			$jsi = $this->perubahan_keluarga_m->get_si_dapat_tunjangan();
			$jak = $this->perubahan_keluarga_m->get_ak_dapat_tunjangan();
			
			$jumlah_si = $jsi->num_rows();
			$jumlah_ak = $jak->num_rows();
			
			$this->load->view('perubahan_keluarga/berkas_penambahan_v', array(
							  'hub'=>$hub, 'tj'=>$tj, 'jumlah_si'=>$jumlah_si,
							  'jumlah_ak'=>$jumlah_ak
			));
		}
		
		public function pengurangan_jiwa()
		{
			$this->load->model('perubahan_keluarga_m');
			
			$this->load->view('layout/header', array( 'title' => 'KGB Pegawai Negeri Sipil'));
			$this->notifikasi();
			
			//set nilai untuk batasan 
			$id_keluarga = $this->uri->segment(3);
			$id_status   = $this->uri->segment(4);
			$pilihan_ket = $this->input->post('pilih_keterangan');	
			
			$this->perubahan_keluarga_m->set_id_keluarga($id_keluarga);
			$this->perubahan_keluarga_m->set_id_status($id_status);
			
			
			$keluarga_by_id = $this->perubahan_keluarga_m->get_keluarga_by_id_keluarga();
			$this->load->view('perubahan_keluarga/pengurangan_jiwa_v', array('keluarga_by_id'=>$keluarga_by_id));
				
			
			   
			$this->load->view('layout/footer');
			
		}
		
		public function load_keterangan_pengurangan()
		{
			$ket = $_POST['ket'];
			
			$this->load->view('perubahan_keluarga/keterangan_pengurangan_jiwa_v', array('ket'=>$ket));
		}
		
		public function load_berkas_pengurangan()
		{
			$ket = $_POST['ket'];
			$this->load->view('perubahan_keluarga/berkas_pengurangan_jiwa_v', array('ket'=>$ket));
		}
		
		
		public function update_pengurangan_jiwa()
		{
			$this->load->model('perubahan_keluarga_m');
			
			//set hubungan
			$id_status   = $this->uri->segment(4);
			$id_keluarga = $this->uri->segment(3);
			$ip 		 = $this->uri->segment(5);

			
			$this->perubahan_keluarga_m->set_id_keluarga($id_keluarga);
			
			//set keterangan
			$pilihan_ket = $this->input->post('pilih_keterangan');	
			$this->perubahan_keluarga_m->set_keterangan($pilihan_ket);
		
			if($id_status==9)
			{
				if($pilihan_ket == "meninggal")
				{
					$this->perubahan_keluarga_m->set_dapat_tunjangan($this->input->post('pilih_status'));
					$this->perubahan_keluarga_m->set_keterangan($this->input->post('pilih_keterangan'));
					$this->perubahan_keluarga_m->set_id_keluarga($id_keluarga);
					
					//set nilai keterangan
					$this->perubahan_keluarga_m->set_tanggal_meninggal($this->input->post('tanggal_meninggal'));
					$this->perubahan_keluarga_m->set_akte_meninggal($this->input->post('akte_meninggal'));
					
					//mengubah flag
					$this->perubahan_keluarga_m->update_pengurangan_jiwa();
					
					//mengubah keterangan
					$this->perubahan_keluarga_m->update_keterangan_meninggal();
					
					$this->upload_pengurangan();
					
				}
					
				else if($pilihan_ket == "cerai")
				{
						
					//update status perubahan menjadi 0			  
					$this->perubahan_keluarga_m->set_dapat_tunjangan($this->input->post('pilih_status'));
					$this->perubahan_keluarga_m->update_pengurangan_jiwa();		  
						
					//set keterangan
					$this->perubahan_keluarga_m->set_tanggal_cerai($this->input->post('tanggal_cerai'));
					$this->perubahan_keluarga_m->set_akte_cerai($this->input->post('akte_cerai'));
						
					//mengubah flag
					$this->perubahan_keluarga_m->update_pengurangan_jiwa();
					
					$this->perubahan_keluarga_m->update_keterangan_cerai();
					
					$this->upload_pengurangan();
				}
			}
			
			else if($id_status == 10)
			{
				if($pilihan_ket == 'meninggal')		
				{
					$this->perubahan_keluarga_m->set_dapat_tunjangan($this->input->post('pilih_status'));
					$this->perubahan_keluarga_m->set_keterangan($this->input->post('pilih_keterangan'));
					$this->perubahan_keluarga_m->set_id_keluarga($id_keluarga);
					
					//set nilai keterangan
					$this->perubahan_keluarga_m->set_tanggal_meninggal($this->input->post('tanggal_meninggal'));
					$this->perubahan_keluarga_m->set_akte_meninggal($this->input->post('akte_meninggal'));
					
					$this->perubahan_keluarga_m->update_pengurangan_jiwa();
					
					$this->perubahan_keluarga_m->update_keterangan_meninggal();
					
					$this->upload_pengurangan();
					
				}					
				
				else if($pilihan_ket == 'lulus')
				{
					//update perubahan keluarga
					$this->perubahan_keluarga_m->set_dapat_tunjangan($this->input->post('pilih_status'));
					$this->perubahan_keluarga_m->update_pengurangan_jiwa();
					
					$this->perubahan_keluarga_m->set_keterangan($this->input->post('pilih_keterangan'));
					
					$this->perubahan_keluarga_m->update_keterangan();
					
					$this->upload_pengurangan();
					
				}
			}
			
			redirect('perubahan_keluarga/data_pegawai_by_id/'. $ip);
				
		}
		
		public function upload_pengurangan()
		{
			$keterangan = $this->input->post('pilih_keterangan');
			$id_k   	= $this->uri->segment(3);
			
			
			if($keterangan == 'meninggal')
			{
				$nama_file_0 = $id_k."_surat_kematian";
				
				$nama_file_0 .= $this->get_file_type($_FILES['ufile_mati']['type'][0] );
				
				$_FILES['ufile_mati']['name'][0] = $nama_file_0;
				
				
				$path0= "assets/upload_berkas/pengurangan/".$_FILES['ufile_mati']['name'][0];

				
				//copy file to where you want to store file
				copy($_FILES['ufile_mati']['tmp_name'][0], $path0);
			
				
				//alamat untuk menyimpan path pada database
				$p0 = base_url().$path0;
			
				$this->perubahan_keluarga_m->update_berkas_kematian($id_k,$p0);
				
			}
			
			else if($keterangan == 'lulus')
			{
				$nama_file_0 = $id_k."_surat_keterangan_telah_bekerja";
				
				$nama_file_0 .= $this->get_file_type($_FILES['ufile_kerja']['type'][0] );
				
				$_FILES['ufile_kerja']['name'][0] = $nama_file_0;
				
				
				$path0= "assets/upload_berkas/pengurangan/".$_FILES['ufile_kerja']['name'][0];

				
				//copy file to where you want to store file
				copy($_FILES['ufile_kerja']['tmp_name'][0], $path0);
			
				
				//alamat untuk menyimpan path pada database
				$p0 = base_url().$path0;
			
				$this->perubahan_keluarga_m->update_berkas_kerja($id_k,$p0);
			}
			
			else if($keterangan == 'cerai')
			{
				$nama_file_0 = $id_k."_surat_keterangan_cerai";
				
				$nama_file_0 .= $this->get_file_type($_FILES['ufile_cerai']['type'][0] );
				
				$_FILES['ufile_cerai']['name'][0] = $nama_file_0;
				
				
				$path0= "assets/upload_berkas/pengurangan/".$_FILES['ufile_cerai']['name'][0];

				
				//copy file to where you want to store file
				copy($_FILES['ufile_cerai']['tmp_name'][0], $path0);
			
				
				//alamat untuk menyimpan path pada database
				$p0 = base_url().$path0;
			
				$this->perubahan_keluarga_m->update_berkas_cerai($id_k,$p0);
			}
			
		}
		
		// public function insert_data_keluarga()
		// {
			// $this->load->model('perubahan_keluarga_m');
			
			// $hubungan = $this->input->post('pilih_hubungan');
			// $ip 	= $this->uri->segment(3);
			
			// $this->perubahan_keluarga_m->set_id_pegawai($ip);
			// //echo $this->input->get('nama_si');
			// //mengambil nilai dan validasi hubungan
			// if($hubungan == 9)
			// {	
			// //echo "masuk sini";
				// // //set nilai ke model
				// // $this->perubahan_keluarga_m->set_id_status($hubungan);
				// // $this->perubahan_keluarga_m->set_nama($this->input->post('nama_si'));
				// // $this->perubahan_keluarga_m->set_tempat_lahir($this->input->post('tempat_lahir_si'));
				// // $this->perubahan_keluarga_m->set_tanggal_lahir($this->input->post('tanggal_lahir_si'));
				// // $this->perubahan_keluarga_m->set_tanggal_menikah($this->input->post('tanggal_menikah_si'));
				// // $this->perubahan_keluarga_m->set_akte_menikah($this->input->post('akte_menikah_si'));
				// // $this->perubahan_keluarga_m->set_pekerjaan($this->input->post('pekerjaan_si'));
				// // $this->perubahan_keluarga_m->set_jenis_kelamin($this->input->post('pilih_jk_si'));
				// // $this->perubahan_keluarga_m->set_dapat_tunjangan($this->input->post('pilih_tunjangan_si'));
				// // $this->perubahan_keluarga_m->set_status_konfirmasi($this->input->post('status_konfirmasi'));
				// // $this->perubahan_keluarga_m->set_keterangan($this->input->post('keterangan_si'));
				
				
				// // //query insert suami/istri
				// // $this->perubahan_keluarga_m->insert_data_suami_istri();
				
				// // //melakukan upload
				// // $this->upload_penambahan();
				
			// }
			// else if($hubungan==10)
			// {	
				// $this->perubahan_keluarga_m->set_id_status($this->input->post('pilih_hubungan'));
				// $this->perubahan_keluarga_m->set_nama($this->input->post('nama_ak'));
				// $this->perubahan_keluarga_m->set_tempat_lahir($this->input->post('tempat_lahir_ak'));
				// $this->perubahan_keluarga_m->set_tanggal_lahir($this->input->post('tanggal_lahir_ak'));
				// $this->perubahan_keluarga_m->set_jenis_kelamin($this->input->post('pilih_jk_ak'));
				// $this->perubahan_keluarga_m->set_dapat_tunjangan($this->input->post('pilih_tunjangan_ak'));
				// $this->perubahan_keluarga_m->set_status_konfirmasi($this->input->post('status_konfirmasi'));
				// $this->perubahan_keluarga_m->set_keterangan($this->input->post('keterangan_ak'));
				
				// //query insert anak
				// $this->perubahan_keluarga_m->insert_data_anak();
				
				// //melakukan upload berkas dan insert alamat berkas
				// $this->upload_penambahan();
				
				
			// }
			
			//$this->perubahan_keluarga_m->insert_berkas();
			
			//redirect('perubahan_keluarga/data_pegawai_by_id/'. $ip);
			
		//}
		public function delete_data_keluarga()
		{
			$this->load->model('perubahan_keluarga_m');
			$this->perubahan_keluarga_m->set_id_keluarga($this->uri->segment(3));
			$ip = $this->uri->segment(4);
			$ik	= $this->uri->segment(3);
				
				//delete data keluarga
			$this->perubahan_keluarga_m->delete_data_keluarga();
				
			$this->perubahan_keluarga_m->delete_berkas($ik);
				
			redirect('perubahan_keluarga/data_pegawai_by_id/'. $ip);
				
		}
		
		public function edit_data_keluarga()
		{
			$this->load->model('perubahan_keluarga_m');
			
			$this->perubahan_keluarga_m->set_id_keluarga($this->uri->segment(3));
			
			$kel_all = $this->perubahan_keluarga_m->get_all_keluarga();
			$this->load->view('layout/header', array( 'title' => 'KGB Pegawai Negeri Sipil'));
			$this->notifikasi();
			$this->load->view('perubahan_keluarga/ubah_data_keluarga_v', array('kel_all'=>$kel_all));
			
			$this->load->view('layout/footer');
			
		}
		
		//update data keluarga semua
		public function update_data_keluarga()
		{
			$this->load->model('perubahan_keluarga_m');
			
			$id_peg = $this->uri->segment(4);
			$id_kel = $this->uri->segment(3);

			$dt 	= $this->input->post('dapat_tunjangan');
			
			$this->perubahan_keluarga_m->set_id_keluarga($this->uri->segment(3));
			$this->perubahan_keluarga_m->set_nama($this->input->post('nama'));
			$this->perubahan_keluarga_m->set_tempat_lahir($this->input->post('tempat_lahir'));
			$this->perubahan_keluarga_m->set_tanggal_lahir($this->input->post('tanggal_lahir'));
			$this->perubahan_keluarga_m->set_pekerjaan($this->input->post('pekerjaan'));
			$this->perubahan_keluarga_m->set_jenis_kelamin($this->input->post('jenis_kelamin'));
			
			if($dt == 0)
			{
				$this->perubahan_keluarga_m->set_dapat_tunjangan($this->input->post('dapat_tunjangan_1'));
				
				$this->perubahan_keluarga_m->update_data_keluarga_tunjangan();
				
				$this->upload_edit_penambahan($id_peg, $id_kel);
			}
			else if($dt == 1)
			{
				$this->perubahan_keluarga_m->update_data_keluarga();
			}
			
			
			redirect('perubahan_keluarga/data_pegawai_by_id/'.$id_peg);
		}
		
		
		public function pilih_surat_terbaru()
		{
			$this->load->view('layout/header', array( 'title' => 'KGB Pegawai Negeri Sipil'));
			$this->notifikasi();
			$this->load->view('perubahan_keluarga/pilih_surat_v');
			$this->load->view('layout/footer');
			
		}
		
		public function surat_pengurangan()
		{
			$this->load->model('perubahan_keluarga_m');
			
			$id_pegawai = $this->uri->segment(3);
			$js = -1;
			
			$this->perubahan_keluarga_m->set_id_pegawai($id_pegawai);
			
			$max        = $this->perubahan_keluarga_m->tanggal_max();
			$tgl        = $max->row();
			$tgl_max    = $tgl->tgl_perubahan;
			
			$hsl = $this->get_bulan($tgl_max);
			
			//mengambil data suami atau istri
			$si 		= $this->perubahan_keluarga_m->get_keluarga_by_id_pegawai_si($tgl_max,$js);
			
			//mengambil data anak
			$ak			= $this->perubahan_keluarga_m->get_keluarga_by_id_pegawai_ak($tgl_max,$js);
			$jum_anak 	= $ak->num_rows();
			
			$anak1 = $ak->row(0);
			$anak2 = $ak->row(1);
				
			$this->surat($anak1, $anak2, $si, $jum_anak,$hsl,$js);
			
			
		}
		
		public function surat_penambahan()
		{
			$this->load->model('perubahan_keluarga_m');
			
			$id_pegawai = $this->uri->segment(3);
			$js = 1;
			
			$this->perubahan_keluarga_m->set_id_pegawai($id_pegawai);
			
			$max        = $this->perubahan_keluarga_m->tanggal_max();
			if($max->num_rows())
			{
				$tgl        = $max->row();
				$tgl_max    = $tgl->tgl_perubahan;
			}
			else
				$tgl_max	= NULL;
			
			$hsl = $this->get_bulan($tgl_max);
			
			//mengambil data suami atau istri
			$si 		= $this->perubahan_keluarga_m->get_keluarga_by_id_pegawai_si($tgl_max,$js);
			
			//mengambil data anak
			$ak			= $this->perubahan_keluarga_m->get_keluarga_by_id_pegawai_ak($tgl_max,$js);
			$jum_anak 	= $ak->num_rows();
			
			$anak1 = $ak->row(0);
			$anak2 = $ak->row(1);
			
			$this->surat($anak1, $anak2, $si, $jum_anak,$hsl,$js);
		}
		
		public function surat_pengajuan()
		{
			$this->load->model('perubahan_keluarga_m');
			
			$this->perubahan_keluarga_m->set_id_pegawai($this->uri->segment(3));
			
			$pegawai 		= $this->perubahan_keluarga_m->get_pegawai_by_id();
			$data_pegawai	= $pegawai->row();
			
			$uk         = $this->perubahan_keluarga_m->get_unit_kerja();
			$unit_kerja = $uk->row();
			
			$max        = $this->perubahan_keluarga_m->tanggal_max();
			$tgl        = $max->row();
			$tgl_max    = $tgl->tgl_perubahan;
			$js			= $this->uri->segment(4);
			
			$kel		= $this->perubahan_keluarga_m->get_keluarga_si_ak($tgl_max,$js);
			
			//mengambil data suami atau istri
			$si 		= $this->perubahan_keluarga_m->get_keluarga_by_id_pegawai_si($tgl_max,$js);
			$jum_si = $si->num_rows();
			
			//mengambil data anak
			$ak			= $this->perubahan_keluarga_m->get_keluarga_by_id_pegawai_ak($tgl_max,$js);
			$jum_anak 	= $ak->num_rows();
			
			$date 	= $this->get_bulan($tgl_max);
			$bln_sp = $date['bulan'];
			$thn_sp = $date['tahun'];
			$tgl_sp = $date['tanggal'];
			
			$this->load->view('perubahan_keluarga/surat_pengajuan_v', array(
			                  'data_pegawai'=>$data_pegawai,
							  'unit_kerja'=>$unit_kerja,
							  'kel'=>$kel,
							  'jum_si'=>$jum_si,
							  'jum_ak'=>$jum_anak,
							  'bln_sp'=>$bln_sp,
							  'thn_sp'=>$thn_sp,
							  'tgl_sp'=>$tgl_sp
							  ));
			
			$content = ob_get_clean();
			require_once('assets/pdf/html2pdf.class.php');
			try
			{
				$html2pdf = new HTML2PDF('P', 'F4', 'fr', true, 'UTF-8', 0);
				$html2pdf->writeHTML($content, isset($_GET['vuehtml']));
				$html2pdf->Output('surat_perubahan_keluarga.pdf','H');
				//$html2pdf->Output('assets/surat_perubahan_keluarga/'.$id,'F');
				
			}
			catch(HTML2PDF_exception $e) {
				echo $e;
				exit;
			}
		}
		
		
		public function surat($anak1,$anak2,$si,$jum_anak, $hsl,$js)
		{
			$this->load->model('perubahan_keluarga_m');
			
			$tahun 		= $hsl['tahun'];
			$bulan 		= $hsl['bulan'];
			$tanggal	= $hsl['tanggal'];
			
			$pegawai 		= $this->perubahan_keluarga_m->get_pegawai_by_id();
			$data_pegawai	= $pegawai->row();
			
			$pangkat_gol = $data_pegawai->pangkat_gol;
			
			//mengambil data unit kerja
			$uk         = $this->perubahan_keluarga_m->get_unit_kerja();
			if($uk->num_rows() > 0)
				$unit_kerja = $uk->row();
			else
				$unit_kerja = NULL;
			
			//mengambil data pengesah berdasarkan golongan
			if($pangkat_gol == 'I/a' || $pangkat_gol== 'I/b' || 
			   $pangkat_gol== 'I/c' || $pangkat_gol== 'I/d' || 
			   $pangkat_gol == 'II/a' || $pangkat_gol=='II/b' ||
			   $pangkat_gol=='II/c' || $pangkat_gol=='II/d')
			{
				$jabatan = 'Kepala Bidang Informasi, Administrasi';
				$pgs = 'Kepala Bidang,';
			}
			else if($pangkat_gol == 'III/a' || $pangkat_gol == 'III/b' || $pangkat_gol == 'III/c' || $pangkat_gol == 'III/d'
			       || $pangkat_gol == 'IV/a' || $pangkat_gol == 'IV/b' || $pangkat_gol == 'IV/c' || $pangkat_gol == 'IV/d')
			{
				$jabatan = 'Kepala Badan Kepegawaian';
				$pgs = 'Kepala Badan,';
			}
			
			$pengesah = $this->perubahan_keluarga_m->get_pengesah_by_golongan($jabatan);
			
			$this->load->view('perubahan_keluarga/surat_perubahan_keluarga_v',array(
																					 'data_pegawai'=>$data_pegawai,
																					 'unit_kerja'=>$unit_kerja,
																					 'si'=>$si,
																					 'anak1'=>$anak1,
																					 'anak2'=>$anak2,
																					 'jum_anak'=>$jum_anak,
																					 'pengesah'=>$pengesah,
																					 'tanggal'=>$tanggal,
																					 'bulan'=>$bulan,
																					 'tahun'=>$tahun,
																					 'pgs'=>$pgs,
																					 'js'=>$js));
			
			
			$content = ob_get_clean();
			require_once('assets/pdf/html2pdf.class.php');
			try
			{
				$html2pdf = new HTML2PDF('P', 'F4', 'fr', true, 'UTF-8', 0);
				$html2pdf->writeHTML($content, isset($_GET['vuehtml']));
				$html2pdf->Output('surat_perubahan_keluarga.pdf','H');
				//$html2pdf->Output('assets/surat_perubahan_keluarga/'.$id,'F');
				
			}
			catch(HTML2PDF_exception $e) {
				echo $e;
				exit;
			}
		}
		
		
		
		public function get_bulan($tgl)
		{
			$this->load->model('perubahan_keluarga_m');
			
			$bulan 	= $this->perubahan_keluarga_m->get_bulan($tgl);
			
			$r 		= $bulan->row();
			$bln 	= $r->bulan;
			$tahun	= $r->tahun;
			
			switch($bln)
			{
				case 1 : $bln ="Januari";
						 break;
				case 2 :$bln = "Februari";
						break;
				case 3 :$bln = "Maret";
						break;
				case 4 : $bln = "April";
						break;
				case 5 : $bln = "Mei";
						break;
				case 6 : $bln = "Juni";
						break;
				case 7 : $bln = "Juli";
						break;
				case 8 : $bln = "Agustus";
						break;
				case 9 : $bln = "September";
						break;
				case 10 : $bln = "Oktober";
						break;
				case 11 : $bln = "November";
						break;
				case 12 : $bln = "Desember";
						break;
			}
			
			$tanggal = substr($tgl,8,2);
			
			return array('bulan'=>$bln,
			             'tahun'=>$tahun,
						 'tanggal'=>$tanggal);
		}
		
		public function riwayat_surat()
		{
			$this->load->model('perubahan_keluarga_m');
			$this->load->view('layout/header', array( 'title' => 'KGB Pegawai Negeri Sipil'));
			$this->notifikasi();
			$this->load->view('perubahan_keluarga/riwayat_surat_v');
			
			$tgl = $this->input->post('tanggal_surat');
			$js  = $this->input->post('jenis_surat');
			$id_p = $this->uri->segment(3);
			
			if($tgl != NULL)
			{
				$tgl = $this->input->post('tanggal_surat');
				redirect('perubahan_keluarga/riwayat_surat_by_tanggal/'.$tgl.'/'.$js.'/'.$id_p);
			}
			
			$this->load->view('layout/footer');
		}
		
		public function riwayat_surat_by_tanggal()
		{
			$this->load->model('perubahan_keluarga_m');
			
			 $jenis_surat = $this->uri->segment(4);
			 $tgl_surat	  = $this->uri->segment(3);
			 
			 $this->perubahan_keluarga_m->set_id_pegawai($this->uri->segment(5));
						 
			if($jenis_surat == 1)
			{	
				//mengambil data suami atau istri
				$si 		= $this->perubahan_keluarga_m->get_keluarga_by_id_pegawai_si($tgl_surat,$jenis_surat);
				$r 			= $si->row();
				$hsl = $this->get_bulan($tgl_surat);
				
				//mengambil data anak
				$ak			= $this->perubahan_keluarga_m->get_keluarga_by_id_pegawai_ak($tgl_surat,$jenis_surat);
				$jum_anak 	= $ak->num_rows();
				
				$anak1 = $ak->row(0);
				$anak2 = $ak->row(1);
			
				$this->surat($anak1, $anak2, $si, $jum_anak, $hsl, $jenis_surat);
				
			}
			else if($jenis_surat == -1)
			{
				//mengambil data suami atau istri
				$si 		= $this->perubahan_keluarga_m->get_keluarga_by_id_pegawai_si($tgl_surat,$jenis_surat);
				$r 			= $si->row();
				$hsl = $this->get_bulan($tgl_surat);
				
				//mengambil data anak
				$ak			= $this->perubahan_keluarga_m->get_keluarga_by_id_pegawai_ak($tgl_surat,$jenis_surat);
				$jum_anak 	= $ak->num_rows();
				
				$anak1 = $ak->row(0);
				$anak2 = $ak->row(1);
			
				$this->surat($anak1, $anak2, $si, $jum_anak, $hsl, $jenis_surat);
			}
			
		}
		
		public function get_tanggal_by_jenis_surat()
		{
			$this->load->model('perubahan_keluarga_m');
			
			$jenis_surat = $this->input->post('jenis_surat');
			$idp         = $this->input->post('id_pegawai');
			
			
			$tgl = $this->perubahan_keluarga_m->get_tanggal_riwayat_surat_by_jenis_surat($jenis_surat, $idp);
			
			
			$this->load->view('perubahan_keluarga/tanggal_by_jenis_surat_v', array('tgl'=>$tgl));
			
			
		}
		
		public function berkas_dasar()
		{
			$this->load->model('perubahan_keluarga_m');
			$this->load->view('layout/header', array( 'title' => 'KGB Pegawai Negeri Sipil'));
			$this->notifikasi();
			
			$id_peg 		= $this->uri->segment(3);
			$bd 			= $this->perubahan_keluarga_m->get_berkas_dasar_pegawai($id_peg);
			
			
			$this->load->view('perubahan_keluarga/berkas_dasar_v', array('berkas_dasar'=>$bd));
			
			$this->load->view('layout/footer');
		}
		
		public function upload_berkas_dasar()
		{
			$this->load->model('perubahan_keluarga_m');
			
			$id_peg = $this->uri->segment(3);
			
			$nama_file_0 = $id_peg."_surat_pengatar_dari_unit_kerja";
			$nama_file_1 = $id_peg."_sk_pangkat_terakhir"; 
			$nama_file_2 = $id_peg."_skumptk";
			$nama_file_3 = $id_peg."_daftar_gaji";
				
			$nama_file_0 .= $this->get_file_type($_FILES['ufile']['type'][0] );
			$nama_file_1 .= $this->get_file_type($_FILES['ufile']['type'][1] );
			$nama_file_2 .= $this->get_file_type($_FILES['ufile']['type'][2] );
			$nama_file_3 .= $this->get_file_type($_FILES['ufile']['type'][3] );
				
			$_FILES['ufile']['name'][0] = $nama_file_0;
			$_FILES['ufile']['name'][1] = $nama_file_1;
			$_FILES['ufile']['name'][2] = $nama_file_2;
			$_FILES['ufile']['name'][3] = $nama_file_3;
				
			$path0 = $_SERVER['DOCUMENT_ROOT'] . "/simpeg/assets/berkas_perubahan_keluarga/berkas_dasar_pegawai/".$_FILES['ufile']['name'][0];
			$path1 = $_SERVER['DOCUMENT_ROOT'] . "/simpeg/assets/berkas_perubahan_keluarga/berkas_dasar_pegawai/".$_FILES['ufile']['name'][1];
			$path2 = $_SERVER['DOCUMENT_ROOT'] . "/simpeg/assets/berkas_perubahan_keluarga/berkas_dasar_pegawai/".$_FILES['ufile']['name'][2];
			$path3 = $_SERVER['DOCUMENT_ROOT'] . "/simpeg/assets/berkas_perubahan_keluarga/berkas_dasar_pegawai/".$_FILES['ufile']['name'][3];
		
			//copy file to where you want to store file
			copy($_FILES['ufile']['tmp_name'][0], $path0);
			copy($_FILES['ufile']['tmp_name'][1], $path1);
			copy($_FILES['ufile']['tmp_name'][2], $path2);
			copy($_FILES['ufile']['tmp_name'][3], $path3);
				
			
			
			$bd = $this->perubahan_keluarga_m->get_berkas_dasar_pegawai($id_peg);
			
			if($bd->num_rows($bd) > 0)
			{
				$this->perubahan_keluarga_m->update_berkas_dasar_pegawai($id_peg, $path0, $path1, $path2, $path3);
			}
			else
			{
				$this->perubahan_keluarga_m->insert_berkas_dasar_pegawai($id_peg, $path0, $path1, $path2, $path3);
			}
			
			redirect('perubahan_keluarga/data_pegawai_by_id/'.$id_peg);
		}
		
		public function lengkapi_berkas_anak()
		{
			$this->load->model('perubahan_keluarga_m');
			
			$this->load->view('layout/header', array( 'title' => 'KGB Pegawai Negeri Sipil'));
			$this->notifikasi();
			
			//untuk mengecek suda ada upload atau belum
			$id_kel		= $this->uri->segment(3);
			$cek_upload = $this->perubahan_keluarga_m->get_berkas_by_id_keluarga($id_kel);
			
			//mengecek tanggal lahir anak lebih dari 21 tahun
			$cek_umur 	= $this->perubahan_keluarga_m->cek_umur_for_berkas($id_kel);
			
			
			
			$this->load->view('perubahan_keluarga/lengkapi_berkas_anak_v',array('cek_upload'=>$cek_upload,
																				'cek_umur'=>$cek_umur));
			$this->load->view('layout/footer');
		}
		
		public function upload_lengkapi_berkas_anak()
		{
			$this->load->model('perubahan_keluarga_m');
			
			$id_kel = $this->uri->segment(3);
			$id_peg = $this->uri->segment(4);
			
			//mengambil data berkas berdasarkan id keluarga
			$cek_berkas 	= $this->perubahan_keluarga_m->get_berkas_by_id_keluarga($id_kel);

			$nama_file_5 = $id_kel."_surat_keterangan_kuliah"; 
				
			$nama_file_5 .= $this->get_file_type($_FILES['ufile_ak']['type'][0] );
				
			$_FILES['ufile_ak']['name'][0] = $nama_file_5;
				
				
			$path5= "assets/upload_berkas/penambahan/".$_FILES['ufile_ak']['name'][0];
				
			//copy file to where you want to store file
			copy($_FILES['ufile_ak']['tmp_name'][0], $path5);
				
			//alamat untuk menyimpan path pada database
			$p5 = base_url().$path5;
			
			$this->perubahan_keluarga_m->update_berkas_anak($id_kel, $p5);
			
			redirect('perubahan_keluarga/data_pegawai_by_id/'.$id_peg);
			
		}
		
		public function lengkapi_berkas_suami_istri()
		{
			$this->load->view('layout/header', array( 'title' => 'KGB Pegawai Negeri Sipil'));
			$this->notifikasi();
			$this->load->view('perubahan_keluarga/lengkapi_berkas_suami_istri_v');
			$this->load->view('layout/footer');
		}
		
		public function upload_lengkapi_berkas_suami_istri()
		{
			$this->load->model('perubahan_keluarga_m');
			$id_kel = $this->uri->segment(3);
			
			//mengambil data berkas berdasarkan id keluarga
			$cek_berkas 	= $this->perubahan_keluarga_m->get_berkas_by_id_keluarga($id_kel);

			$nama_file_4 = $id_kel."_surat_nikah";
				
			$nama_file_4 .= $this->get_file_type($_FILES['ufile_si']['type'][0] );
				
			$_FILES['ufile_si']['name'][0] = $nama_file_0;
				
			$path0= "assets/upload_berkas/penambahan/".$_FILES['ufile_si']['name'][0];
				
			//copy file to where you want to store file
			copy($_FILES['ufile_si']['tmp_name'][0], $path0);
				
			//alamat untuk menyimpan path pada database
			$p0 = base_url().$path0;
			$p1 = NULL;
			$p2 = NULL;
			$p3 = NULL;
			$p4 = NULL;
			
			if($cek_berkas->num_rows() > 0)
			{
				$this->perubahan_keluarga_m->update_berkas_suami_istri($id_kel,$p0);
			}
			else
			{
				$this->perubahan_keluarga_m->insert_berkas_si($id_kel,$p0,$p1,$p2,$p3,$p4);
			}
		}
		
		public function batas_umur_tunjangan_anak()
		{
			$this->load->model('perubahan_keluarga_m');
			$this->load->view('layout/header', array( 'title' => 'KGB Pegawai Negeri Sipil'));
			$this->notifikasi();
			
			$batas = $this->perubahan_keluarga_m->get_umur_anak();
			
			$this->load->view('perubahan_keluarga/batas_umur_tunjangan_anak_v', array('batas'=>$batas));
			
			$this->load->view('layout/footer');
		}
			
			// public function coba_insert_satu()
			// {
				// $this->load->model('perubahan_keluarga_m');
				// //echo "cek";
				// $data = $this->perubahan_keluarga_m->memilih_data();
				
				// foreach($data->result() as $r)
				// {
					// $this->perubahan_keluarga_m->set_id_pegawai($r->id_pegawai);
					// $this->perubahan_keluarga_m->set_id_keluarga($r->id_keluarga);
					// $this->perubahan_keluarga_m->set_dapat_tunjangan($r->dapat_tunjangan);
					// $this->perubahan_keluarga_m->set_timestamp($r->timestamp);
					
					// $this->perubahan_keluarga_m->coba_insert_dua();
				// }
				
			// }
			
			// public function update_status_proses()
			// {
				// $this->load->model('perubahan_keluarga_m');
				
				// $this->perubahan_keluarga_m->update_status_proses();
			// }
			
		/*public function update_status_perubahan()
		{
			$this->load->model('perubahan_keluarga_m');
			$this->perubahan_keluarga_m->update_status_perubahan();
					  
		}
		*/
			
	}
?>