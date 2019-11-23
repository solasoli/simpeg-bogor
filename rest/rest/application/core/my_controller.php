<?php
class my_controller extends CI_Controller {

    public function __construct()
    {

        parent::__construct();

        if ($this->session->userdata['login_status'] != '') {
        } else {
            redirect('home');
        }

    }
}
?>