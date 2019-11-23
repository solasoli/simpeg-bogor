<?php
class MY_Controller extends MX_Controller {

    public function __construct()
    {

        parent::__construct();

        if ($this->session->userdata('login_status_ekinerja') != '') {
        } else {
            if(isset($_SESSION['hideHeader']) and $_SESSION['hideHeader']!=''){

            }else{
                redirect('Home');
            }
        }

    }
}
?>
