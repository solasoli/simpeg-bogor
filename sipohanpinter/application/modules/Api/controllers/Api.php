<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Api extends MX_Controller {
	function __construct() {
		parent::__construct();

  }

  public function login(){

    $json = file_get_content('php://input');

    $obj = json_decode($json);

    $nip = $obj['nip'];
    $password = $obj['password'];

    $query = ("select * from pegawai where nip_baru = ".$nip." and password = ".$password);

    $check = $this->db->query($query)->row();

    if(isset($check)){
      echo json_encode("SUCCESS");
    }else{
      echo json_encode("FAILED");
    }
  }


}
