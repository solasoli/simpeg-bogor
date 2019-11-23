<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Security extends CI_Controller {
	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/formasi
	 *	- or -  
	 * 		http://example.com/index.php/formasi/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	 
	public function unauthorized()
	{				
		$this->load->view('layout/header.php', $data = array("title" => "Unauthorized"));
		$this->load->view('security/unauthorized.php');		
		$this->load->view('layout/footer.php');
	}
	
	
}
/* End of file formasi.php */
/* Location: ./application/controllers/formasi.php */