<?php 
class User_model extends CI_Model{
		
	public function __construct()
	{}

	public function get_roles($id_pegawai){
		$query = $this->db->query("select * from user_roles u 
								inner join role_functions f on f.role_id = u.role_id  inner join app_functions aps on aps.id_app_function = f.function_id 
								where u.id_pegawai = $id_pegawai");
		
		foreach ($query->result() as $row)
		{
			$data[] = $row;
		}
		return $data;
	}
	
	/** user yang punya hak akses */
	public function get_user(){
	
		$query = "select distinct id_pegawai from user_roles";
		return $this->db->query($query)->result();
	}
}
/* End of file user_model.php */
/* Location: ./application/models/user_model.php */
?>
