<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Dashboard extends MX_Controller {
	function __construct() {
		parent::__construct();
		//$this->load->model('supermodel');
		$this->load->model('fungsional');
		$this->load->library('form_validation');
		$this->fungsional->cek_log();
	}

	function cek_log(){
		$this->fungsional->cek_log();
	}

	function index() {

		$merge = $this->fungsional->get_profile();
		$data['title'] = "Dashboard";
		$data['konten'] = "Dashboard/dashboard";
		// $data['konten'] = "";

	//	$data['query'] = $this->db->query('select SQL_CALC_FOUND_ROWS * from knj_kategori where dinas_id="'.$merge['member_dinas_id'].'" order by kategori_nama asc limit 2')->result_array();

		$ex = array_merge($data, $merge);
		//$this->load->vars($ex);
		$this->load->view('Layout/_layout',$data);
	}

	function allkategori() {
		$merge = $this->fungsional->get_profile();
		//$requested_page = $_POST['page_num'];
		//$set_limit = (($requested_page - 1) * 7) . ",7";
		$offset = is_numeric($_POST['offset']) ? $_POST['offset'] : die();
		$postnumbers = is_numeric($_POST['number']) ? $_POST['number'] : die();

		$ktg = $this->db->query("select SQL_CALC_FOUND_ROWS * from knj_kategori where kategori_parent = 0 and dinas_id='".$merge['member_dinas_id']."' order by kategori_nama asc limit $postnumbers offset $offset")->result_array();

		$no=$_POST['offset']+1;

		foreach($ktg as $ket){
			echo '<div style="font-size:14px;font-weight:bold;padding:5px">'.$no.'. '.$ket['kategori_nama'].'</div>';
			$son = $this->db->query('select SQL_CALC_FOUND_ROWS * from knj_kategori where kategori_parent = '.$ket['kategori_id'].' order by kategori_nama asc')->result_array();
			$noo=1;
			foreach($son as $kat){
				echo '<h5 style="padding:5px;margin:0px 20px;">'.$noo.'. '.$kat['kategori_nama'].'<h5>';
			$noo++;
			}
		$no++;
		}
	}

	function editp() {
		$merge = $this->fungsional->get_profile();
		$data['title'] = "Edit Profil";
		$data['konten'] = "editp";
		$ex = array_merge($data, $merge);
		$this->load->vars($ex);
		$this->load->view('backend/template');
	}

	function editpp() {
		$nip = $this->input->post('nip');
		$nama = $this->input->post('nama');
		$email = $this->input->post('email');
		$tlp = $this->input->post('tlp');
		$foto = $_FILES['foto']['name'];
		$pass = $this->input->post('pass');
		$pissx = $this->input->post('passx');
		$passx = md5($pissx);
		$ext = end(explode(".", $foto));

		if(!empty($pissx) && empty($foto)):
			$array1 = array('password'=>$passx);
			$this->supermodel->updateData('user', 'username', $this->uri->segment(3), $array1);

			$array2 = array('member_nama'=>$nama, 'member_email'=>$email, 'member_tlp'=>$tlp);
			$this->supermodel->updateData('member', 'member_nip', $this->uri->segment(3), $array2);
			inputLast('Edit Profil');
			$this->session->set_flashdata('validasi', '<div class="alert alert-success">Akun anda telah diperbaharui.</div>');
			redirect('admain/editp/'.$this->uri->segment(3));
		elseif(empty($pissx) && empty($foto)):
			$array = array('member_nama'=>$nama, 'member_email'=>$email, 'member_tlp'=>$tlp);
			$this->supermodel->updateData('member', 'member_nip', $this->uri->segment(3), $array);
			inputLast('Edit Profil');
			$this->session->set_flashdata('validasi', '<div class="alert alert-success">Akun anda telah diperbaharui.</div>');
			redirect('admain/editp/'.$this->uri->segment(3));
		elseif(!empty($pissx) && !empty($foto)):
			if($ext == "jpg" || $ext=="png" || $ext=="gif"):
				$ff = $this->db->query('select * from knj_member where member_nip="'.$this->uri->segment(3).' "')->result();
				foreach($ff as $img):
					if($img->member_foto == "default-male.jpg" || $img->member_foto == "default-female.jpg"):
						echo "";
					else:
						@unlink("./uploads/images/".$img->member_foto);
					endif;
				endforeach;
				$array1 = array('password'=>$passx);
				$this->supermodel->updateData('user', 'username', $this->uri->segment(3), $array1);
				$this->fungsional->uploads('./uploads/images/','jpg|png',1024,$nip.'.'.$ext, 'foto');
				//$this->upload->do_upload('foto');
				$array = array('member_nama'=>$nama, 'member_email'=>$email, 'member_tlp'=>$tlp, 'member_foto'=>$nip.'.'.$ext);
				inputLast('Edit Profil');
				$this->supermodel->updateData('member', 'member_nip', $this->uri->segment(3), $array);
				$this->session->set_flashdata('validasi', '<div class="alert alert-success">Akun anda telah diperbaharui.</div>');
				redirect('admain/editp/'.$this->uri->segment(3));
			else:
				$this->session->set_flashdata('validasi', '<div class="alert alert-danger">Foto gagal upload.</div>');
				redirect('admain/editp/'.$this->uri->segment(3));
			endif;
		elseif($foto!="" && empty($pissx)):
			if($ext == "jpg" || $ext=="png" || $ext=="gif"):
				$ff = $this->db->query('select*from knj_member where member_nip="'.$this->uri->segment(3).'"')->result();
				foreach($ff as $img):
					if($img->member_foto == "default-male.jpg" || $img->member_foto == "default-female.jpg"):
						echo "";
					else:
						@unlink("./uploads/images/".$img->member_foto);
					endif;
				endforeach;
				$ups = $this->fungsional->uploads('./uploads/images/','jpg|png',1024,$nip.'.'.$ext, 'foto');
				//$this->upload->do_upload('foto');
				$array = array('member_nama'=>$nama, 'member_email'=>$email, 'member_tlp'=>$tlp, 'member_foto'=>$nip.'.'.$ext);
				$this->supermodel->updateData('member', 'member_nip', $this->uri->segment(3), $array);
				inputLast('Edit Profil');
				$this->session->set_flashdata('validasi', '<div class="alert alert-success">Akun anda telah diperbaharui.</div>');
				redirect('admain/editp/'.$this->uri->segment(3));
			else:
				$this->session->set_flashdata('validasi', '<div class="alert alert-danger">Foto gagal upload.</div>');
				redirect('admain/editp/'.$this->uri->segment(3));
			endif;
		endif;
	}

	function loghapus() {
		$this->db->query('truncate knj_log_aktivitas');
		inputLast('Menghapus Log Aktivitas');
		redirect('admain');
	}

	function out() {
		$arraya = array('islogin'=>0);
		$this->supermodel->updateData('user', 'user_id', $this->session->userdata('user_id'), $arraya);
		//inputLast('Logout');
		$this->input->set_cookie('true','',time()-10000);
		$this->input->set_cookie('890','',time()-10000);
		$this->input->set_cookie('412','',time()-10000);
		$this->session->sess_destroy();
		redirect('welcome');
		session_destroy();
	}
}

?>
