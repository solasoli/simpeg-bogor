<?php
function authenticate($user, $app_function_name)
{
	$CI =& get_instance();

	if(!$CI->session->userdata('user')){
		redirect('');
	} 
		
	
    	$CI->load->model('user_model');	

	$roles = $CI->user_model->get_roles($user->id_pegawai);
	foreach($roles as $r){
		if($r->function_name == $app_function_name) 
		{
			return;
		}
	}
	redirect("security/unauthorized");
}
?>
