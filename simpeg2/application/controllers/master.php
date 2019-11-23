<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


	/**
	* 
	* 
	*/
class Master extends CI_Controller{

	function __construct(){
	
		parent::__construct();
		
		$this->load->model('user_model','user');
		$this->load->model('master_model','master');
		$this->load->model('pegawai_model','pegawai');
	}
	
	public function index(){
	
		$this->load->view('layout/header', array( 'title' => 'Master Data'));
		$this->load->view('master/header');		
		$this->load->view('layout/footer');
	}
		
	public function roles(){
	
		$data = array('roles'=>$this->master->get_roles());
		$this->load->view('layout/header', array( 'title' => 'Master Data'));
		//$this->load->view('master/header');
		$this->load->view('master/roles_list',$data);
		$this->load->view('layout/footer');
	
	}
	
	public function role_function(){
		
		$data = array('roles'=>$this->master->get_roles());
		$this->load->view('layout/header', array( 'title' => 'Master Data'));
		$this->load->view('master/header');
		$this->load->view('master/roles_list',$data);
		$this->load->view('layout/footer');
	}
	
	public function add_roles(){
		
		$this->load->view('layout/header', array( 'title' => 'Master Data'));
		$this->load->view('master/header');
		$this->load->view('master/add_role');
		$this->load->view('layout/footer');
		
		if($this->input->post()){
			//print_r($this->input->post());
			if($this->master->add_roles($this->input->post('txtRole'))){
				//echo "success";
				redirect('master/roles','refresh');
			}else{
				echo "gagal";
			}
		}
		
	}
	
	public function edit_roles(){
	
	
	}
	
	public function delete_role(){
		$hapus = $this->master->delete_role($this->uri->segment(3));
		if($hapus){
			//echo "<script>alert('gagal menghapus')</script>";
			redirect('master/roles');
		}else{
			echo "<script>alert('gagal menghapus')</script>";
		}
	}
	
	public function user_roles(){
		
		//$this->load->model('jabatan_model','jabatan');
		$data = array('user_roles'=>$this->user->get_user());
		$this->load->view('layout/header', array( 'title' => 'User\'s Roles'));
		$this->load->view('master/header');
		$this->load->view('master/user_role_list',$data);
		$this->load->view('layout/footer');
		
	}
	
	public function edit_user_role(){
	
		$data = array('roles'=>$this->master->get_roles());
		$this->load->view('layout/header', array( 'title' => 'Edit user'));
		$this->load->view('master/header');
		$this->load->view('master/user_role',$data);
		$this->load->view('layout/footer');
	}
	
	function assign_role_to_user(){
		
		$data = array('roles'=>$this->master->get_roles());
		$this->load->view('layout/header', array( 'title' => 'Edit user'));
		$this->load->view('master/header');
		$this->load->view('master/assign_role2user',$data);
		$this->load->view('layout/footer');
	}
	
	function save_assign_role_to_user(){
	
		$role_id = $this->input->post('role_id');
		$id_pegawai = $this->input->post('id_pegawai');
		
		if ($this->master->add_user_role($id_pegawai,$role_id)){
			echo json_encode($id_pegawai." ditambah ".$role_id." berhasil disimpan");
		}else{
			echo json_encode('gagal');
		}
		
	}
	
	function delete_assign_role_to_user(){
	
		$id_pegawai = $this->input->post('id_pegawai');
		$role_id = $this->input->post('role_id');
		
		if ($this->master->del_user_role($id_pegawai,$role_id)){
			echo json_encode($id_pegawai." ditambah ".$role_id." berhasil dihapus");
		}else{
			echo json_encode('gagal');
		}		
	}
	
	public function function_list(){
			
		$data = array('functions'=>$this->master->get_function_list());
		$this->load->view('layout/header', array( 'title' => 'Function list'));
		//$this->load->view('master/header');
		$this->load->view('master/app_function_list',$data);
		$this->load->view('layout/footer');
		
	}
	
	public function add_function(){
	
		if($this->input->post()){
			//print_r($this->input->post());
			if($this->master->add_function($this->input->post('txtAppFunction'))){
				//echo "success";
				redirect('master/function_list','refresh');
			}else{
				echo "gagal";
			}
		}
	}
	
	function assign_function_to_role($role_id){
	
		$data = array('functions'=>$this->master->get_function_list());
		
		$this->load->view('layout/header',array('title=>assigning function'));
		$this->load->view('master/header');
		$this->load->view('master/assign_funct2role',$data);
		$this->load->view('layout/footer');
		
	}
	
	function save_assign_function_to_role(){
	
		$function_id = $this->input->post('function_id');
		$role_id = $this->input->post('role_id');
		
		if ($this->master->add_role_function($role_id,$function_id)){
			echo json_encode($function_id." ditambah ".$role_id." berhasil disimpan");
		}else{
			echo json_encode('gagal');
		}
		
	}
	
	function delete_assign_function_to_role(){
	
		$function_id = $this->input->post('function_id');
		$role_id = $this->input->post('role_id');
		
		if ($this->master->del_role_function($role_id,$function_id)){
			echo json_encode($function_id." ditambah ".$role_id." berhasil dihapus");
		}else{
			echo json_encode('gagal');
		}
		
	}
	
	
	
}
