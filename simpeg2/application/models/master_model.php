<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Master_model extends CI_Model{

	public function __construct(){
	
		parent::__construct();
		$this->load->database();
	}
	
	function get_roles($role_id = NULL){
	
		if($role_id == NULL){
			return $this->db->get('roles')->result();
		}else{
			$this->db->where('role_id',$role_id);
			return $this->db->get('roles')->row();
		}
		//return FALSE;
	}
			
	function add_roles($role){
		
		return $this->db->insert('roles',array('role'=>$role));
				
	}
	
	function delete_role($id){
	
		return $this->db->delete('roles',array('role_id'=>$id));
	}
	
	function get_user_roles(){
	
		return $this->db->get('user_roles')->result();
	}
	
	/**
	 * will return false if pegawai haven't role
	 */
	function check_user_role($id_pegawai,$role_id){
		
		$this->db->where('id_pegawai',$id_pegawai);
		$this->db->where('role_id',$role_id);
		return $this->db->get('user_roles')->result();
	}
	
	function get_function_list($role_id = NULL){
		
		//$this->db->distinct();
		if($role_id){
			$this->db->where('role_id',$role_id);			
			return $this->db->get('role_functions')->result();				
		}else{
			return $this->db->get('app_functions')->result();				
		}				
	}
		
	function get_function_name($function_id){
		$this->db->where('id_app_function',$function_id);
		return $this->db->get('app_functions')->row();
	}
	
	function add_function($function_name){
		return $this->db->insert('app_functions',array('function_name'=>$function_name));
	}
	
	function check_role_function($role_id,$function_id){
		
		$this->db->where('role_id',$role_id);
		$this->db->where('function_id',$function_id);
		return $this->db->get('role_functions')->result();
	}
	
	function add_role_function($role_id,$function_id){
	
		if($this->check_role_function($role_id,$function_id)){
			//return FALSE;
			echo "errroooooo";
		}else{
			return $this->db->insert('role_functions',array('role_id'=>$role_id,'function_id'=>$function_id));
		}
	}
	
	function del_role_function($role_id,$function_id){
	
		return $this->db->delete('role_functions',array('role_id'=>$role_id,'function_id'=>$function_id));
	}
	
	function add_user_role($id_pegawai,$role_id){
	
		return $this->db->insert('user_roles',array('id_pegawai'=>$id_pegawai,'role_id'=>$role_id));
	}
	
	function del_user_role($id_pegawai,$role_id){
		
		return $this->db->delete('user_roles',array('id_pegawai'=>$id_pegawai,'role_id'=>$role_id));
	}
	
}