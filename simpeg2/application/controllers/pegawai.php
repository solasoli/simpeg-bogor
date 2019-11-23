<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pegawai extends CI_Controller {

	public function __construct(){

		parent::__construct();

		//authenticate($this->session->userdata('user'), "PEGAWAI_VIEW");
		$this->load->model('pegawai_model','pegawai');
		$this->load->model('jabatan_model','jabatan');

		$this->load->library('format');
	}


	public function index()
	{
		//$this->load->view('welcome_message');
	}

	public function instant_search(){
		$landing = $_GET['landing'];
		//if(isset($this->input->post('txtKeyword')))
		$keyword = $this->input->post('txtKeyword');
		if($keyword==NULL)
		$keyword = $_GET['keyword'];
		//else
		//$keyword = $this->input->get('txtKeyword');


		$this->load->model('pegawai_model');
		$pegawai = $this->pegawai_model->instan_search($keyword);


		$this->load->view('layout/header');
		$this->load->view('pegawai/instant-search', array(
			'landing' => $landing,
			'pegawai' => $pegawai,
			'keyword'=>$keyword,
		));
		$this->load->view('layout/footer');
	}

	public function json_find(){
		$this->load->model('pegawai_model');
		$pegawai = $this->pegawai_model->get_by_nama($this->input->get('q'));

		foreach($pegawai as $p)
			$data[] = array(
				'label' => $p->nama,
				'value' => $p->id_pegawai,
				'nip'	=> $p->nip_baru,
				'gol'	=> $p->pangkat_gol,
				'uker'  => $p->nama_baru,
				'tmt'  => $p->tmt,
				'jabatan'  => $p->jabatan,
				'id_j' => $p->id_j,
				'eselon'  => $p->eselon,
				'tmt_jabatan'  => $p->tmt_jabatan,
				'pendidikan' => $p->tingkat_pendidikan." ".$p->jurusan_pendidikan." - ".$p->lembaga_pendidikan." (".$p->tahun_lulus.")",
			);
		echo json_encode($data);
	}

	function drh(){
        $this->load->model('skpd_model','skpd');
        $this->load->model('rest_data_model','rest');

		$this->pegawai->id_pegawai = $this->uri->segment(3);
        $pegawai = $this->pegawai->get_by_id($this->uri->segment(3));
		$data['pegawai'] = $pegawai;
        $data['atasan'] = $this->rest->data_ref_data_dasar($this->uri->segment(3));

		$this->load->model('pendidikan_model','pendidikan');
		$this->pendidikan->id_pegawai;
		$data['pendidikan'] = $this->pendidikan->get_by_id_pegawai($this->uri->segment(3));

		$this->load->model('diklat_model','diklat');
		$this->diklat->id_pegawai = $this->uri->segment(3);
		$data['diklat'] = $this->diklat->get_by_id_pegawai();

		/*$data['riwayat_pangkat'] = $this->pegawai->get_riwayat_pangkat();

		$sql_riwayat_jabatan = "select * from sk
								inner join jabatan j on j.id_j = sk.id_j
								where id_kategori_sk = 10 and sk.id_pegawai = ".$this->uri->segment(3)." order by sk.tmt DESC";
		$data['riwayat_mutasi'] = $this->db->query($sql_riwayat_jabatan)->result();*/

        $this->load->model('sk_model','sk');
        $data['riwayat_pangkat'] = $this->sk->drh_golongan($this->uri->segment(3));
        $data['riwayat_mutasi'] = $this->jabatan->drh_jabatan($this->uri->segment(3));


		$this->load->model('keluarga_model','keluarga');
		$this->keluarga->id_pegawai = $this->uri->segment(3);
		$data['istri_suami'] = $this->keluarga->get_istri_suami();


		$data['anak'] = $this->keluarga->get_anak();
        $data['skp'] = $this->pegawai->riwayat_skp($this->uri->segment(3));

        $eselon = '';
        $lvl = 0;
        if($pegawai->id_j!='' and $pegawai->id_j>0){
            $eselon = $this->jabatan->get_jabatan($pegawai->id_j)->eselon;
        }

        if($eselon == ''){
            if($pegawai->jenjab=='Struktural'){
                $lvl = 1;
                $kat_jabatan = 'Jabatan Pelaksana';
            }else{
                $kat_jabatan = 'Jabatan Fungsional';
            }
        }else{
            if($eselon=='IVA' or $eselon=='IVB') {
                $lvl = 2;
                $kat_jabatan = 'Jabatan Pengawas';
            }elseif($eselon=='IIIA' or $eselon=='IIIB') {
                $lvl = 3;
                $kat_jabatan = 'Jabatan Administrator';
            }elseif($eselon=='IIA' or $eselon=='IIB'){
                $lvl = 4;
                $kat_jabatan = 'Jabatan Pimpinan Tinggi Pratama';
            }
        }
        if($lvl > 0){
            $std_kompetensi = $this->pegawai->std_kompetensi_by_level($lvl);
            $lvl_kompetensi = $this->pegawai->level_kompetensi($lvl);
        }else{
            $std_kompetensi = '';
            $lvl_kompetensi = '';
        }

        $data['std_kompetensi'] = $std_kompetensi;
        $data['lvl_kompetensi'] = $lvl_kompetensi;
        $data['kat_jabatan'] = $kat_jabatan;

		$this->load->view('drh/drh',$data);
	}


	public function profile($id_pegawai){

		$this->load->model('skpd_model','skpd');
		$this->load->model('pendidikan_model','pendidikan');
		$this->load->model('keluarga_model','keluarga');
		$this->load->model('sk_model','sk');
        $this->load->model('rest_data_model','rest');

        $pegawai = $this->pegawai->get_by_id($this->uri->segment(3));
		$data['pegawai'] = $pegawai;
		$data['atasan'] = $this->rest->data_ref_data_dasar($this->uri->segment(3));
		$data['pendidikans'] = $this->pendidikan->get_by_id_pegawai($this->uri->segment(3));
		$data['istri_'] = $this->keluarga->get_istri_suami($this->uri->segment(3));
		$data['anaks'] = $this->keluarga->get_anak($this->uri->segment(3));

		/*$sk_kenaikan_pangkat = $this->sk->get_sk_pegawai_by_kategori($this->uri->segment(3),5);
		$sk_cpns = $this->sk->get_sk_pegawai_by_kategori($this->uri->segment(3),6);
		$sk_pns = $this->sk->get_sk_pegawai_by_kategori($this->uri->segment(3),7);
		$data['sk_pangkats'] = array_merge($sk_kenaikan_pangkat, $sk_pns, $sk_cpns);*/

        $data['sk_pangkats'] = $this->sk->drh_golongan($this->uri->segment(3));
        $data['jabatan'] = $this->jabatan->drh_jabatan($this->uri->segment(3));
        $data['diklats'] = $this->pegawai->drh_diklat($this->uri->segment(3));
        $data['skp'] = $this->pegawai->riwayat_skp($this->uri->segment(3));

        $eselon = '';
        $lvl = 0;
        if($pegawai->id_j!='' and $pegawai->id_j>0){
            $eselon = $this->jabatan->get_jabatan($pegawai->id_j)->eselon;
        }

        if($eselon == ''){
            if($pegawai->jenjab=='Struktural'){
                $lvl = 1;
                $kat_jabatan = 'Jabatan Pelaksana';
            }else{
                $kat_jabatan = 'Jabatan Fungsional';
            }
        }else{
            if($eselon=='IVA' or $eselon=='IVB') {
                $lvl = 2;
                $kat_jabatan = 'Jabatan Pengawas';
            }elseif($eselon=='IIIA' or $eselon=='IIIB') {
                $lvl = 3;
                $kat_jabatan = 'Jabatan Administrator';
            }elseif($eselon=='IIA' or $eselon=='IIB'){
                $lvl = 4;
                $kat_jabatan = 'Jabatan Pimpinan Tinggi Pratama';
            }
        }
        if($lvl > 0){
            $std_kompetensi = $this->pegawai->std_kompetensi_by_level($lvl);
            $lvl_kompetensi = $this->pegawai->level_kompetensi($lvl);
        }else{
            $std_kompetensi = '';
            $lvl_kompetensi = '';
        }

        $data['std_kompetensi'] = $std_kompetensi;
        $data['lvl_kompetensi'] = $lvl_kompetensi;
        $data['kat_jabatan'] = $kat_jabatan;

		$this->load->view('layout/header',$data);
		$this->load->view('pegawai/profile');
		$this->load->view('layout/footer');

	}

	public function edit($edit){

		if($edit == 1 ){
			echo $edit;
		}elseif($edit == 2){
			//echo $edit;
			if($term = $this->input->get('query',TRUE)){
				//$term = $this->input->get('query',TRUE);
				$jabatan = $this->jabatan->jfu_search($term);
				$jabatan_array = array();
				foreach($jabatan as $jab){
					$jabatan_array[] = array('value'=>$jab->nama_jfu.' ('.$jab->kode_jabatan.')','data'=>$jab->kode_jabatan);
				}
				$response_jab = array(
					"suggestions"=>$jabatan_array
				);

				echo json_encode($response_jab);
			}else{
				$this->profile_kepegawaian_edit($this->uri->segment(4));
			}

		}elseif($edit == 3){
			echo $edit;
		}else{
			return FALSE;
		}

	}

	function profile_biodata_edit($id_pegawai){

		echo "edit biodata";
	}

	function profile_kepegawaian_edit($id_pegawai){
		authenticate($this->session->userdata('user'), "PEGAWAI_EDIT");

		if($nip = $this->input->post('nip')){
			//echo $this->input->post('unit_kerja');
			echo 'redirecting....';
			//print_r($this->input->post());

			if($this->jabatan->get_jfu($id_pegawai)){

				$this->jabatan->update_jfu_pegawai($id_pegawai, $this->input->post('kode_jabatan'));
				redirect('inpassing/jfu/'.$this->input->post('unit_kerja'),'refresh');
			}else{
				$this->jabatan->insert_jfu_pegawai($id_pegawai,$this->input->post('kode_jabatan'));
				redirect('inpassing/jfu/'.$this->input->post('unit_kerja'),'refresh');
			}


		}else{
			$data = array('jabatan'=>$this->jabatan->get_list_jfu());
			//print_r($this->input->post());
			$this->load->view('layout/header');
			$this->load->view('pegawai/biodata_kepegawaian_edit',$data);
			$this->load->view('layout/footer');

		}


	}

		public function uploader($id_pegawai,$keyword){
		$this->load->view('layout/header');
		$this->load->view('layout/uploader',array('idp'=>$id_pegawai,'keyword'=>$keyword));
		$this->load->view('layout/footer');
		}

		public function uploadpoto(){
		$idp=$this->input->post('idp');
		$keyword=$this->input->post('keyword');

		function resize_image($file, $w, $h, $crop=false) {
    list($width, $height) = getimagesize($file);
    $r = $width / $height;
    if ($crop) {
        if ($width > $height) {
            $width = ceil($width-($width*abs($r-$w/$h)));
        } else {
            $height = ceil($height-($height*abs($r-$w/$h)));
        }
        $newwidth = $w;
        $newheight = $h;
    } else {
        if ($w/$h > $r) {
            $newwidth = $h*$r;
            $newheight = $h;
        } else {
            $newheight = $w/$r;
            $newwidth = $w;
        }
    }

    //Get file extension
    $exploding = explode(".",$file);
    $ext = end($exploding);

    switch($ext){
        case "png":
            $src = imagecreatefrompng($file);
        break;
        case "jpeg":
        case "jpg":
            $src = imagecreatefromjpeg($file);
        break;
        case "gif":
            $src = imagecreatefromgif($file);
        break;
        default:
            $src = imagecreatefromjpeg($file);
        break;
    }

    $dst = imagecreatetruecolor($newwidth, $newheight);
    imagecopyresampled($dst, $src, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

    return $dst;
}

function compress($source, $destination, $quality) {
    //Get file extension
    $exploding = explode(".",$source);
    $ext = end($exploding);

    switch($ext){
        case "png":
            $src = imagecreatefrompng($source);
        break;
        case "jpeg":
        case "jpg":
            $src = imagecreatefromjpeg($source);
        break;
        case "gif":
            $src = imagecreatefromgif($source);
        break;
        default:
            $src = imagecreatefromjpeg($source);
        break;
    }

    switch($ext){
        case "png":
            imagepng($src, $destination, $quality);
        break;
        case "jpeg":
        case "jpg":
            imagejpeg($src, $destination, $quality);
        break;
        case "gif":
            imagegif($src, $destination, $quality);
        break;
        default:
            imagejpeg($src, $destination, $quality);
        break;
    }

    return $destination;
}
		if($_FILES['poto']['size']>0)
		{
		move_uploaded_file($_FILES['poto']['tmp_name'],"../simpeg/foto/$idp.jpg");

		$filename = "../simpeg/foto/$idp.jpg";
		$resizedFilename = "../simpeg/foto/$idp.jpg";


		$imgData = resize_image($filename, 150, 200);
		imagejpeg($imgData, $resizedFilename);



		//echo("<img src=../../../../simpeg/foto/$idp.jpg?".time()." />");
		}




		redirect(site_url()."pegawai/instant_search?landing=card/cetak&keyword=$keyword");
		}

	function profile_lain_edit($id_pegawai){

		echo "edit biodata";
	}

	function json_profil(){


		$profil = $this->pegawai->get_profil_by_id($this->input->post('idpegawai'));

		echo json_encode($profil);

	}

	function delete_riwayat_jabatan(){
		$this->load->model("sk_model");
		$jenjang = $this->input->post('jenjang');
		$id = $this->input->post('id');
		switch ($jenjang) {
			case 'Pelaksana':
				if($this->db->delete('jfu_pegawai', array('id'=>$id))){
				
					if($msg = $this->sk_model->delete($this->input->post('id_sk'))){
						echo 1;
					}else{
						echo $msg;
					}
				}else{
					echo $msg;
				}
				break;
			case 'Fungsional':
				if($this->db->delete('jafung_pegawai', array('id'=>$id))){

					//ambil id berkas
					//$id_berkas = $this->db->get_where('sk',array('id_sk'=>$this->input->post('id_sk')))->row()->id_berkas;
					//if($id_berkas != null || $id_berkas != 0){


					if($msg = $this->sk_model->delete($this->input->post('id_sk'))){
						echo 1;
					}else{
						echo $msg;
					}
				}else{
					echo 0;
				}
				break;
			default:
				echo 0;
				break;
		}
	}



	function report_jumlah_transit(){
		$this->load->model('pegawai_model');
		$pegawai = $this->pegawai_model->get_all();
		$this->load->view('pegawai/report_jumlah_transit', array('pegawai' => $pegawai));
	}

	/*
	function jabatan_search(){

		$term = $this->input->get('query',TRUE);
		$jabatan = $this->jabatan->jfu_search($term);
		echo json_encode($jabatan);
	}*/

}

/* End of file pegawai.php */
/* Location: ./application/controllers/pegawai.php */
