<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Jabatan_struktural extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	 
	 
	public function __construct(){
	
		parent::__construct();
		$this->load->library('pdf');
        $this->load->library('pager');
	}
	
	public function index(){
		$rekap='';
		$jabatan_kosong = '';
		
		$this->load->model('jabatan_model');
		$jabatan_kosong = $this->jabatan_model->get_jabatan_struktural_kosong();
		$rekap = $this->jabatan_model->rekap_jabatan_struktural();
		//$rekap = $this->hukuman_model->recap_tingkat_hukuman_per_tahun();				
		
		$this->load->view('layout/header', array( 'title' => 'Jabatan Struktural'));		
		//$this->load->view('jabatan_struktural/header');
		$this->load->view('jabatan_struktural/index', 
			array(
				'rekap' => $rekap,
				'jabatan_kosong' => $jabatan_kosong
			));
		$this->load->view('layout/footer');
	}	
	
	private function load_header_draft_pelantikan($id_draft){
		$this->load->model('draft_pelantikan_model');
		$jab_kosong = $this->draft_pelantikan_model->get_kosong($id_draft);
		$draft_pelantikan = $this->draft_pelantikan_model->get_draft_by_id($id_draft);
		$lepas_jabatan = $this->draft_pelantikan_model->get_lepas_jabatan($id_draft);
		
		$this->load->view('jabatan_struktural/header');
		$this->load->view('jabatan_struktural/header_draft_pelantikan', array(
			'jab_kosong' => $jab_kosong,
			'draft_pelantikan' => $draft_pelantikan,
			'lepas_jabatan' => $lepas_jabatan,
		));
	}
	
	public function riwayat_jabatan_html_list(){
		$id_pegawai = $this->input->post('id_pegawai');
		
		$this->load->model('riwayat_jabatan_model');
		$riwayat_jabatan = $this->riwayat_jabatan_model->get_by_id_pegawai($id_pegawai);
		
		$this->load->view('jabatan_struktural/riwayat_jabatan_li', array(
			'riwayat_jabatan' => $riwayat_jabatan,
		));
	}

	public function riwayat_hukuman_list(){
		$id_pegawai = $this->input->post('id_pegawai');

		$this->load->model('hukuman_model');
		$riwayat_hukuman = $this->hukuman_model->get_by_id_riwayat_hukuman($id_pegawai);

		$this->load->view('jabatan_struktural/riwayat_hukuman', array(
				'riwayat_hukuman' => $riwayat_hukuman,
		));
	}

	public function riwayat_kompetensi_list(){
		$id_pegawai = $this->input->post('id_pegawai');

		$this->load->model('draft_pelantikan_model');
		$riwayat_kompetensi = $this->draft_pelantikan_model->get_by_id_kompetensi($id_pegawai);

		$this->load->view('jabatan_struktural/riwayat_kompetensi', array(
				'riwayat_kompetensi' => $riwayat_kompetensi,
		));
	}
	
	private function draft_pelantikan_with_id($id_draft){
		$this->load->model('draft_pelantikan_model');
		$jabatan = $this->draft_pelantikan_model->get_by_id($id_draft);
		
		$this->load_header_draft_pelantikan($id_draft);
		
		$this->load->view('jabatan_struktural/draft_pelantikan_worksheet', 
			array(				
				'jabatan' => $jabatan
			));	
		$this->load->view('jabatan_struktural/footer_draft_pelantikan');
	}
	
	public function draft_pelantikan_partial(){		
		$draft_pelantikan = '';
		
		$this->load->model('draft_pelantikan_model');
		$draft_pelantikan = $this->draft_pelantikan_model->get_all();		
		
		$this->load->view('jabatan_struktural/header');
		$this->load->view('jabatan_struktural/draft_pelantikan', 
			array(				
				'draft_pelantikan' => $draft_pelantikan
			));		
	}
	
	function login_draft()
	{	$idd=$this->input->post('idd');
		$pass=$this->input->post('kunci');
		$this->load->model('draft_pelantikan_model');
		
		$passwordya = $this->draft_pelantikan_model->get_pass($idd)->password;
		$this->load->view('jabatan_struktural/header');
		
		if($pass==$passwordnya)
		$this->draft_pelantikan_with_id($id_draft);
		else
		{
			echo("<h3>Password Salah </h3>");
		$this->load->view('jabatan_struktural/login_draft');
		}
		
		
		$this->load->view('layout/footer');
		
	}
	
	public function draft_pelantikan($id_draft=0){
		
		$this->load->view('layout/header', array( 'title' => 'Jabatan Struktural'));				
		
		if($id_draft){
			
		$data =array('idd'=> $id_draft);
				$this->load->view('jabatan_struktural/login_draft', $data);
			//$this->draft_pelantikan_with_id($id_draft);
		}	
		else
			$this->draft_pelantikan_partial();
		
		
		
		$this->load->view('layout/footer');
	}
	
	public function draft_pelantikan_baru(){		
		if($this->input->post()){
			$this->load->model('draft_pelantikan_model');
			$new_id = $this->draft_pelantikan_model->save(
				$this->input->post('nama_draft'),
				$this->input->post('pass'),
				$this->session->userdata('user')->id_pegawai);
						
			redirect("/jabatan_struktural/draft_pelantikan/".$new_id);
		}			
		
		$this->load->view('layout/header', array( 'title' => 'Jabatan Struktural'));				
		$this->draft_pelantikan_partial();
		$this->load->view('jabatan_struktural/create_draft_pelantikan', 
			array(
				
			));
		$this->load->view('layout/footer');
	}
	
	public function json_find_in_draft(){
		$this->load->model('draft_pelantikan_model');
		$pegawai = $this->draft_pelantikan_model->get_by_nama($this->input->get('q'), $this->input->get('id_draft'), $this->input->get('type'));

		foreach($pegawai as $p) {
			//echo $p->id_pegawai.'-'.$p->eselon;
			$pengalaman_eselon_cur = $this->draft_pelantikan_model->pengalaman_eselon_pegawai($p->id_pegawai, $p->eselon);
			//$eselonbawahnya = $this->draft_pelantikan_model->getEselonDibawahnya($p->eselon);
			//$pengalaman_eselon_down = $this->draft_pelantikan_model->pengalaman_eselon_pegawai($p->id_pegawai, $eselonbawahnya->eselon);
			$data[] = array(
					'label' => $p->nama,
					'value' => $p->id_pegawai,
					'nip' => $p->nip_baru,
					'gol' => $p->pangkat_gol,
					'uker' => $p->nama_baru,
					'tmt' => $p->tmt,
					'jabatan' => $p->jabatan,
					'id_j' => $p->id_j,
					'eselon' => $p->eselon,
					'pengalaman_eselon' => $pengalaman_eselon_cur->pengalaman_eselon,
				//'eselonbawahnya' => $eselonbawahnya->eselon,
				//'pengalaman_eselon_down' => $pengalaman_eselon_down->pengalaman_eselon,
					'tmt_jabatan' => $p->tmt_jabatan,
					'pendidikan' => $p->tingkat_pendidikan . " " . $p->jurusan_pendidikan . " - " . $p->lembaga_pendidikan . " (" . $p->tahun_lulus . ")",
			);
		}
		echo json_encode($data);
	}
	
	public function ganti_isi_draft(){
		$data = array(
			'id_draft' => $this->input->post('id_draft'),
			'id_pegawai_sebelumnya' => $this->input->post('id_pegawai_sebelumnya'),
			'id_pegawai_baru' => $this->input->post('id_pegawai_baru'),
			'id_j_dituju' => $this->input->post('id_j_dituju'),
			'id_j_ditinggal' => $this->input->post('id_j_ditinggal'),
			'created_by' => 4357
		);
	
		$this->load->model('draft_pelantikan_model');
		$tx_result = $this->draft_pelantikan_model->ganti($data);
	}

	public function isi_draft_jabatan($id_draft, $id_j){
		$jabatan = '';
		$bos_jabatan = '';
		$pejabat_sekarang = '';
		$riwayat_jabatan = '';
		
		$this->load->model('jabatan_model');
		$jabatan = $this->jabatan_model->get_jabatan($id_j);
		$bos_jabatan = $this->jabatan_model->get_bos_jabatan($id_j,$id_draft);
		$jabatan_bawahan = $this->jabatan_model->get_jabatan_bawahan($id_j);
		
		$this->load->model('draft_pelantikan_model');
		$pejabat_sekarang = $this->draft_pelantikan_model->get_pejabat_sekarang($id_draft, $id_j);
		
		if($pejabat_sekarang){
			$this->load->model('riwayat_jabatan_model');
			$riwayat_jabatan = $this->riwayat_jabatan_model->get_by_id_pegawai($pejabat_sekarang->idpegawai);
            $eselonering = $this->draft_pelantikan_model->pengalaman_eselon_pegawai($pejabat_sekarang->idpegawai, $pejabat_sekarang->eselon);
        }
        $rekomendasi_pejabat = $this->draft_pelantikan_model->getRekomendasiPejabat($id_j);
        $getIdSkpdTujuan = $this->draft_pelantikan_model->getIdSkpdTujuan();
		$getBidangPendidikan = $this->draft_pelantikan_model->getBidangPendidikan();

		$this->load->view('layout/header', array( 'title' => 'Jabatan Struktural'));				
		$this->load_header_draft_pelantikan($id_draft);
		$this->load->view('jabatan_struktural/isi_draft_jabatan', array(
			'jabatan' => $jabatan,
			'pejabat_sekarang' => $pejabat_sekarang,
            'eselonering' => (isset($eselonering) ? $eselonering : ''),
			'riwayat_jabatan' => $riwayat_jabatan,
			'bos_jabatan' => $bos_jabatan,
			'jabatan_bawahan' => $jabatan_bawahan,	
			'id_draft' => $id_draft,
            'rekomendasi_pejabat' => $rekomendasi_pejabat,
            'idskpd_tujuan' => $getIdSkpdTujuan,
			'bidang_pendidikan' => $getBidangPendidikan
		));
		$this->load->view('jabatan_struktural/footer_draft_pelantikan');
		$this->load->view('layout/footer');				
	}
	
	private function cek_kesesuaian_jabatan($id_draft, $id_j, $id_pegawai){
		$notes = '';
		$this->load->model('jabatan_model');
		$jabatan = $this->jabatan_model->get_jabatan($id_j);
		$bos_jabatan = $this->jabatan_model->get_bos_jabatan($id_j,$id_draft);
		$jabatan_bawahan = $this->jabatan_model->get_jabatan_bawahan($id_j);
		
		$this->load->model('draft_pelantikan_model');
		$pejabat_sekarang = $this->draft_pelantikan_model->get_pejabat_sekarang($id_draft, $id_j);
		$pegawai = $this->draft_pelantikan_model->get_pegawai($id_pegawai, $id_draft);
		
		if($pejabat_sekarang){
			$this->load->model('riwayat_jabatan_model');
			$riwayat_jabatan = $this->riwayat_jabatan_model->get_by_id_pegawai($pejabat_sekarang->idpegawai);

        }

        if($pegawai->eselon == ''){
            if($jabatan->eselon <> 'IVA' and $jabatan->eselon <> 'IVB'){
                $notes[] = array("Jabatan Eselon yang dituju tidak dapat diisi oleh pegawai ini",1);
            }
        }else{
            $eselonbawahnya = $this->draft_pelantikan_model->getEselonDibawahnya($jabatan->eselon);
            if($pegawai->eselon ==  (isset($eselonbawahnya->eselon) ? $eselonbawahnya->eselon : '')){
                $pengalaman_eselon_cur = $this->draft_pelantikan_model->pengalaman_eselon_pegawai($pegawai->id_pegawai, $pegawai->eselon);
                if($pengalaman_eselon_cur->pengalaman_eselon < 2){
                    $notes[] = array("Masa kerja Eselon pegawai kurang dari 2 tahun",1);
                }
            }else{
                if($pegawai->eselon <> $jabatan->eselon){
                    $eselonbawahnya = (isset($eselonbawahnya->eselon) ? $eselonbawahnya->eselon : '');
                    if($eselonbawahnya == ''){
                        $notes[] = array("Jabatan Eselon pegawai lebih tinggi dari jabatan eselon yang dituju", 1);
                    }else {
                        if ($pegawai->eselon > $eselonbawahnya) {
                            $notes[] = array("Pengisian jabatan Eselon harus berjenjang", 1);
                        } elseif ($pegawai->eselon < $eselonbawahnya) {
                            $notes[] = array("Jabatan Eselon pegawai lebih tinggi dari jabatan eselon yang dituju", 1);
                        }
                    }
                }
            }
        }
		
		// Test pangkat minimal jabatan
		if($jabatan->gol_minimal > $pegawai->pangkat_gol) {
            $notes[] = array("Golongan pegawai yang akan dicalonkan tidak memenuhi syarat.
			Golongan satu tingkat dibawah syarat minimal adalah " . $jabatan->gol_minimal,1);
        }

        if($jabatan->gol_minimal == $pegawai->pangkat_gol) {
            $notes[] = array("Golongan pegawai yang akan dicalonkan sama dengan
			golongan satu tingkat dibawah syarat minimal yaitu " . $jabatan->gol_minimal,2);
        }

		// Test kepangkatan dengan calon atasan
		if(strtolower($bos_jabatan->jabatan_bos) != 'walikota bogor'){
			// Pastikan golongan tidak melebihi atasan
			if($pegawai->pangkat_gol > $bos_jabatan->pangkat_gol){
				$notes[] = array("Golongan pegawai yang dicalonkan melebihi golongan atasannya.",3);
			}
		}
		
		// Test kepangkatan dengan bawahan
		if(isset($jabatan_bawahan)){
			foreach($jabatan_bawahan as $bawah){				
				// Pastikan golongan tidak lebih rendah dari bawahan
				if($pegawai->pangkat_gol < $bawah->pangkat_gol){
    					$notes[] = array("Golongan pegawai yang dicalonkan lebih rendah (atau sama dengan) golongan bawahannya.",1); //4
					break;
				}
			}
		}		
		
		return $notes;
	}
	
	public function json_cek_kesesuaian_jabatans(){
		$id_j = $this->input->post('id_jabatan');
		$id_pegawai = $this->input->post('id_pegawai');
		$id_draft = $this->input->post('id_draft');
        echo 'TES';
        echo($id_draft.",". $id_j.",". $id_pegawai);

		//$notes = $this->cek_kesesuaian_jabatan($id_draft, $id_j, $id_pegawai);
		
		/*if(sizeof($notes))
			echo json_encode($notes);
		else
			echo '';*/
	}
	
	public function nominatif_draft_pelantikan($id_draft=0){
		//$this->load->view('layout/header', array( 'title' => 'Nominatif Pelantikan'));				
		if($id_draft){
			$this->load->model('draft_pelantikan_model');
			$eselons = $this->draft_pelantikan_model->get_eselon_pelantikan($id_draft);
			$this->load->view('layout/header', array( 'title' => 'Jabatan Struktural'));
			$this->load->view("jabatan_struktural/nominatif_draft_pelantikan", array(
								'eselons' => $eselons
							));
			$this->load->view('layout/footer');
		}	
		else;
			//$this->draft_pelantikan_partial();
		//$this->load->view('layout/footer');
	}

    public function batal_pelantikan_pegawai(){
        $data = array(
            'id_draft' => $this->input->post('id_draft'),
            'id_pegawai_baru' => $this->input->post('id_pegawai_baru'),
            'id_pegawai_awal' => $this->input->post('id_pegawai_awal')
        );

        $this->load->model('draft_pelantikan_model');
        $notes = $this->draft_pelantikan_model->batal_pelantikan($data);

        if(sizeof($notes))
            echo json_encode($notes);
        else
            echo '';
    }
	
	public function nominatif_riwayat(){
		$this->load->model('jabatan_model');
		$nom = $this->jabatan_model->get_nominatif_riwayat_js();				
		
		$this->load->view('layout/header', array( 'title' => 'Nominatif Riwayat Jabatan'));
		//$this->load->view('jabatan_struktural/header');
		$this->load->view('jabatan_struktural/nominatif_riwayat', array('rekap' => $nom));
		$this->load->view('layout/footer');
	}
	
	public function daftar_pegawai(){
		$this->load->model('hukuman_model');
		$hukuman = $this->hukuman_model->get_terhukum();
		
		$this->load->view('layout/header');
		$this->load->view('hukuman_disiplin/header');
		$this->load->view('hukuman_disiplin/daftar_pegawai', array('hukuman' => $hukuman));
		$this->load->view('layout/footer');
	}
	
	public function save(){
		authenticate($this->session->userdata('user'), "HUKDIS_SAVE");
		if($this->input->post('idPegawai')){
			/*$id_pegawai					= $this->input->post('idPegawai');
			$jenis_hukuman 				= $this->input->post('cboJenisHukuman');
			$no_keputusan 				= $this->input->post('txtNoKeputusan');
			$tanggal_penetapan 			= $this->input->post('txtNoKeputusan');
			$tmt 						= $this->input->post('txtTmt');
			$pejabat_pemberi_hukuman 	= $this->input->post('txtPejabatPemberiHukuman');
			$jabatan				 	= $this->input->post('txtJabatan');
			$keterangan				 	= $this->input->post('txtKeterangan');*/
			
			switch($this->input->post('cboJenisHukuman')){
				case 1	:
					//$pegawai = '';
					//$this->load->library('hukuman_disiplin/hukuman', array($pegawai));
					
					break;	
				case 2	:
					break;	
				case 3	:
					break;	
				case 4	:
					break;
				case 5	:
					break;	
				case 6	:
					break;	
				case 7	:
					break;
				case 8	:
					break;	
				case 9	:
					break;	
				case 10 :
					break;	
				case 11 :					
					break;				
			}
			//$this->load->library('hukuman', array($pegawai));
			
			$this->load->model('hukuman_model');
			$this->hukuman_model->insert();
			$this->penjatuhan($this->input->post('idPegawai'));
		}
		else{
			$this->penjatuhan();
		}
	}

	public function hapus($id_draft){
		//authenticate($this->session->userdata('user'), "HUKDIS_DELETE");
		$this->load->model('draft_pelantikan_model');		
		$this->draft_pelantikan_model->delete($id_draft);
	
		redirect('jabatan_struktural/draft_pelantikan/'.$this->input->get('idp'));		
	}
	
	public function json_get_by_tingkat(){
		authenticate($this->session->userdata('user'), 'HUKDIS_VIEW_JENIS');
		$this->load->model("jenis_hukuman_model");
		$data = $this->jenis_hukuman_model->get_by_tingkat($this->input->post('tingkat'));
			
		echo json_encode($data);
	}

    public function detail_pegawai(){
        $no_reg = $this->input->post('no_reg');
        $nm_jabatan = $this->input->post('nm_jabatan');
        $jbtn_eselon = $this->input->post('jbtn_eselon');
        $skpd_tujuan = $this->input->post('skpd_tujuan');
        $type = $this->input->post('type');

        $this->load->model('draft_pelantikan_model');
        $detail_pegawai = $this->draft_pelantikan_model->getDetailPegawai($no_reg, $jbtn_eselon, $type);

        $this->load->view('jabatan_struktural/detail_pegawai', array(
            'detail_pegawai' => $detail_pegawai,
            'nm_jabatan' => $nm_jabatan,
            'jbtn_eselon' => $jbtn_eselon,
            'skpd_tujuan'=> $skpd_tujuan
        ));
    }

    public function drop_data_other_rekomendasi(){
        $limit_mulai = $this->input->post('limit_mulai');
        $limit_banyaknya = $this->input->post('limit_banyaknya');
        $idskpd = $this->input->post('idskpd');
        $jbtn_eselon = $this->input->post('jbtn_eselon');
        $tipe_rekomendasi = $this->input->post('tipe_rekomendasi');
        $jabatan = $this->input->post('jabatan');
        $nama_baru_skpd = $this->input->post('nama_baru_skpd');
        $id_draft = $this->input->post('id_draft');
        $keywordSuggest = $this->input->post('keywordSuggest');
        $this->load->model('draft_pelantikan_model');
        $drop_other_data_rekomendasi = $this->draft_pelantikan_model->dropDataOtherRekomendasi($limit_mulai, $limit_banyaknya, $idskpd, $jbtn_eselon, $tipe_rekomendasi, $keywordSuggest);

        $this->load->view('jabatan_struktural/drop_data_rekomendasi', array(
            'drop_other_data_rekomendasi'=> $drop_other_data_rekomendasi,
            'jbtn_eselon' => $jbtn_eselon,
            'jabatan'=> $jabatan,
            'nama_baru_skpd'=> $nama_baru_skpd,
            'id_draft'=> $id_draft
        ));
    }

	public function drop_data_sort_manual_rekomendasi(){
		$pages = new Paginator;
		$pagePaging = $_POST['page'];
		$ipp = $_POST['ipp'];
		if($pagePaging==0 or $pagePaging==""){
			$pagePaging = 1;
		}
		if($ipp==0 or $ipp==""){
			$ipp = $pages->default_ipp;
		}
		$_SESSION['ippPager'] = $ipp;
		$_SESSION['pagePager'] = $pagePaging;
		$this->load->model('draft_pelantikan_model');

		$idskpd = $this->input->post('idskpd');
		$jbtn_eselon = $this->input->post('jbtn_eselon');
		$jabatan = $this->input->post('jabatan');
		$nama_baru_skpd = $this->input->post('nama_baru_skpd');
		$id_draft = $this->input->post('id_draft');
		$a = $this->input->post('a');
		$b = $this->input->post('b');
		$c = $this->input->post('c');
		$d = $this->input->post('d');
		$e = $this->input->post('e');
		$f = $this->input->post('f');
		$g = $this->input->post('g');
		$filter = $this->input->post('filter');
		$pend = $this->input->post('pend');
		$txtKeyword = $this->input->post('txtKeyword');
		$jmlData = $this->draft_pelantikan_model->getCountAlldropDataSortManualRekomendasi($idskpd, $jbtn_eselon, $a,$b,$c,$d,$e,$f,$g,$filter,$pend,$txtKeyword);

		if($jmlData>0){
			$pages->items_total = $jmlData;
			$pages->paginate();
			$pgDisplay = $pages->display_pages();
			$itemPerPage = $pages->display_items_per_page();
			$curpage = $pages->current_page;
			$numpage = $pages->num_pages;
			$jumppage = $pages->display_jump_menu();
		}else{
			$pgDisplay = '';
			$itemPerPage = '';
			$curpage = '';
			$numpage = '';
			$jumppage = '';
		}
		if($pagePaging == 1){
			$start_number = 0;
		}else{
			$start_number = ($pagePaging * $ipp) - $ipp;
		}
		$drop_data_sort_manual_rekomendasi = $this->draft_pelantikan_model->getDropDataSortManualRekomendasi($start_number,$idskpd,$jbtn_eselon,$a,$b,$c,$d,$e,$f,$g,$filter,$pend,$txtKeyword,$pages->limit,$pages->posisi);
		$this->load->view('jabatan_struktural/drop_data_sort_manual', array(
				'drop_other_data_rekomendasi'=> $drop_data_sort_manual_rekomendasi,
				'jbtn_eselon' => $jbtn_eselon,
				'jabatan'=> $jabatan,
				'nama_baru_skpd'=> $nama_baru_skpd,
				'id_draft'=> $id_draft,
				'pgDisplay' => $pgDisplay,
				'curpage' => $curpage,
				'numpage' => $numpage,
				'jumppage' => $jumppage,
				'jmlData' => $jmlData
		));
	}

    public function download_data_excel_rekomendasi(){
        $idskpd = $this->input->post('idskpd');
        $tipe_rekomendasi = $this->input->post('tipe_rekomendasi');
        $jbtn_eselon = $this->input->post('jbtn_eselon');
        $jabatan = $this->input->post('jabatan');
        $nama_baru_skpd = $this->input->post('nama_baru_skpd');

        $this->load->view('jabatan_struktural/download_excel_rekomendasi', array(
            'jbtn_eselon' => $jbtn_eselon,
            'jabatan'=> $jabatan,
            'nama_baru_skpd'=> $nama_baru_skpd,
            'idskpd'=> $idskpd,
            'tipe_rekomendasi'=> $tipe_rekomendasi
        ));
    }

    public function export_to_excel(){
        parse_str($_SERVER['QUERY_STRING'],$_GET);
        $this->load->model('draft_pelantikan_model');
        $export_excel = $this->draft_pelantikan_model->exportDataToExcel($_GET['idskpd_tujuan'],
            $_GET['jbtn_eselon'], $_GET['limit_banyaknya'], $_GET['tipe_rekomendasi']);
    }

    public function setting_pengesahan($id_draft){
        $this->load->model('draft_pelantikan_model');
        $this->load->model("Baperjakat_model");
        $baperjakat = $this->Baperjakat_model->get_all();
        $submitok = $this->input->post('submitok');

        if($submitok==1){
            $id_draft_exixting = (isset($this->draft_pelantikan_model->getdraft_pelantikan_pengesahan_by_iddraft($id_draft)->id_draft) ? $this->draft_pelantikan_model->getdraft_pelantikan_pengesahan_by_iddraft($id_draft)->id_draft : 0);
            $data = array(
                'id_draft' => $id_draft,
                'idbaperjakat' => $this->input->post('idbaperjakat'),
                'nosk' => $this->input->post('nosk'),
                'tglpengesahan' => $this->input->post('tglpengesahan'),
                'wktpengesahan' => $this->input->post('wktpengesahan'),
                'ruang_pengesahan' => $this->input->post('ruang_pengesahan')
            );
            $tx_result = $this->draft_pelantikan_model->updatePengesahanPelantikan($data, $id_draft_exixting);
        }

        $dp_pengesahan = $this->draft_pelantikan_model->getdraft_pelantikan_pengesahan_by_iddraft($id_draft);
        if(isset($dp_pengesahan->id_baperjakat)) {
            $info_baperjakat = $this->Baperjakat_model->getInfoBaperjakat($dp_pengesahan->id_baperjakat);
            $detail_baperjakat = $this->Baperjakat_model->getDetailBaperjakat($dp_pengesahan->id_baperjakat);
            $arrData = array(
                'baperjakat' => $baperjakat,
                'dp_pengesahan' => $dp_pengesahan,
                'info_baperjakat' => $info_baperjakat,
                'detail_baperjakat' => $detail_baperjakat,
                'tx_result' => (isset($tx_result) ? $tx_result : '')
            );
        }else{
            $arrData = array(
                'baperjakat' => $baperjakat,
                'dp_pengesahan' => $dp_pengesahan,
                'tx_result' => ''
            );
        }
        $this->load->view('layout/header', array( 'title' => 'Pengaturan Pengesahan'));
        $this->load_header_draft_pelantikan($id_draft);
        $this->load->view('jabatan_struktural/setting_pengesahan', $arrData);
        $this->load->view('jabatan_struktural/footer_draft_pelantikan');
    }

    public function pengaturan(){
        $rekap='';
        $jabatan_kosong = '';

        //$this->load->model('jabatan_model');
        //$jabatan_kosong = $this->jabatan_model->get_jabatan_struktural_kosong();
        //$rekap = $this->jabatan_model->rekap_jabatan_struktural();
        //$rekap = $this->hukuman_model->recap_tingkat_hukuman_per_tahun();

        $this->load->model('Baperjakat_model');

        if (isset($_POST['save_update'])) {
            $formNameEdit = $this->input->post('formNameEdit');
            $formNameEdit = explode("_", $formNameEdit);
            $nosk_tim = $this->input->post('no_sk_'.$formNameEdit[2]);
            $pengesah = $this->input->post('pengesah_'.$formNameEdit[2]);
            $pejabat = $this->input->post('pejabat_'.$formNameEdit[2]);
            $id_baperjakat = $this->Baperjakat_model->updateBaperjakat($nosk_tim, $pengesah, $pejabat, $formNameEdit[2]);
            if(isset($id_baperjakat)){
                for ($x = 1; $x <= 7; $x++) {
                    $idDetBaper = $_POST['txtIdDetBaper_'.$x.'_'.$formNameEdit[2]];
                    $data = array(
                        'idpegawai' => $this->input->post('txtTim_'.$x.'_'.$formNameEdit[2]),
                        'id_j' => $this->input->post('txtIdj_'.$x.'_'.$formNameEdit[2]),
                        'id_detbaperjakat' => $idDetBaper
                    );
                    $this->Baperjakat_model->updateBaperjakatDetail($data);
                }
            }
            if(isset($id_baperjakat) > 0){
                $id_baperjakat = 'tersimpan';
            }
        }elseif (isset($_POST['delete'])) {
            $formNameEdit = $this->input->post('formNameEdit');
            $formNameEdit = explode("_", $formNameEdit);
            $id_baperjakat = $this->Baperjakat_model->deleteBaperjakat($formNameEdit[2]);
            if(isset($id_baperjakat) > 0){
                $id_baperjakat = 'terhapus';
            }
        }elseif (isset($_POST['new_register'])) {
            $nosk_tim = $this->input->post('nosk_tim');
            $pengesah = $this->input->post('pengesah');
            $pejabat = $this->input->post('pejabat');
            $id_baperjakat = $this->Baperjakat_model->insertBaperjakat($nosk_tim, $pengesah, $pejabat);
            if(isset($id_baperjakat)){
                for ($x = 1; $x <= 7; $x++) {
                    $tim_baper[$x] = $_POST['txtTim'.$x];
                    $data = array(
                        'idpegawai' => $this->input->post('txtTim'.$x),
                        'id_j' => $this->input->post('txtIdj'.$x),
                        'idstatus_keanggotaan' => $x,
                        'id_baperjakat' => $id_baperjakat
                    );
                    $this->Baperjakat_model->insertBaperjakatDetail($data);
                }
            }
            if(isset($id_baperjakat) > 0){
                $id_baperjakat = 'tersimpan';
            }
        }

        $baperjakat_list = $this->Baperjakat_model->get_all();
        $listPangkat = $this->Baperjakat_model->getPangkat();
        $listJabatan = $this->Baperjakat_model->getJabatan();
        $listUnit = $this->Baperjakat_model->getUnitKerja();

        $this->load->view('layout/header', array( 'title' => 'Pengaturan Jabatan Struktural'));
        //$this->load->view('jabatan_struktural/header');
        $this->load->view('jabatan_struktural/pengaturan',
            array(
                'listPangkat' => $listPangkat,
                'listJabatan' => $listJabatan,
                'listUnit' => $listUnit,
                'baperjakat_list' => $baperjakat_list,
                'tx_result' => (isset($id_baperjakat) ? $id_baperjakat : '')
            ));
        $this->load->view('layout/footer');
    }

    public function informasi_baperjakat(){
        $idbaperjakat = $this->input->post('idbaperjakat');

        $this->load->model('Baperjakat_model');
        $info_baperjakat = $this->Baperjakat_model->getInfoBaperjakat($idbaperjakat);
        $detail_baperjakat = $this->Baperjakat_model->getDetailBaperjakat($idbaperjakat);

        $this->load->view('jabatan_struktural/detail_baperjakat', array(
            'info_baperjakat' => $info_baperjakat,
            'detail_baperjakat' => $detail_baperjakat
        ));
    }

    public function cari_pegawai(){
        $pages = new Paginator;
        $pagePaging = $_POST['page'];
        $ipp = $_POST['ipp'];
        if($pagePaging==0 or $pagePaging==""){
            $pagePaging = 1;
        }
        if($ipp==0 or $ipp==""){
            $ipp = $pages->default_ipp;
        }
        $_SESSION['ippPager'] = $ipp;
        $_SESSION['pagePager'] = $pagePaging;
        $this->load->model('Baperjakat_model');

        $cboPangkat = $_POST['cboPangkat'];
        $cboJabatan = $_POST['cboJabatan'];
        $cboUnit = $_POST['cboUnit'];
        $txtKeyword = $_POST['txtKeyword'];

        $jmlData = $this->Baperjakat_model->getCountAllFindPegawai($cboPangkat, $txtKeyword, $cboJabatan, $cboUnit);
        if($jmlData>0){
            $pages->items_total = $jmlData;
            $pages->paginate();
            $pgDisplay = $pages->display_pages();
            $itemPerPage = $pages->display_items_per_page();
            $curpage = $pages->current_page;
            $numpage = $pages->num_pages;
            $jumppage = $pages->display_jump_menu();
        }else{
            $pgDisplay = '';
            $itemPerPage = '';
            $curpage = '';
            $numpage = '';
            $jumppage = '';
        }
        if($pagePaging == 1){
            $start_number = 0;
        }else{
            $start_number = ($pagePaging * $ipp) - $ipp;
        }

        $data_cari_pegawai = $this->Baperjakat_model->getFindPegawai($start_number, $cboPangkat, $txtKeyword, $cboJabatan, $cboUnit, $pages->limit, $pages->posisi);
        $this->load->view('jabatan_struktural/cari_pegawai', array(
            'cari_pegawai' => $data_cari_pegawai,
            'pgDisplay' => $pgDisplay,
            'curpage' => $curpage,
            'numpage' => $numpage,
            'jumppage' => $jumppage,
            'jmlData' => $jmlData
        ));
    }

    public function info_pegawai(){
        $this->load->model('Baperjakat_model');
        $idpegawai = $_POST['idpegawai'];
        $info_pegawai = $this->Baperjakat_model->infoPegawai($idpegawai);
        foreach($info_pegawai as $ip) {
            $data[] = array(
                'id_pegawai' => $ip->id_pegawai,
                'nama' => $ip->nama,
                'nip_baru' => $ip->nip_baru,
                'pangkat_gol' => $ip->pangkat_gol,
                'id_j' => $ip->id_j,
                'jabatan' => $ip->jabatan,
                'unit_kerja' => $ip->unit_kerja
            );
        }
        echo json_encode($data);
    }

}

/* End of file jabatan_struktural.php */
/* Location: ./application/controllers/jabatan_struktural.php */
