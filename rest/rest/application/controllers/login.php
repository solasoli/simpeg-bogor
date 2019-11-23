<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Login extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Login_model','login');
        $this->layout = 'layout';
    }

    public function index()
    {
        $login = $this->input->post(null, true);
        if (! $this->login->login($login)) {
            $this->session->set_flashdata('pesan_error', 'NIP atau Password salah');
            redirect('login-error');
        }
        $login_status = $this->session->userdata('login_status');
        $user_level = $this->session->userdata('user_level');
        if ($login_status == true && ($user_level == 'Administrator' or $user_level == 'User')) {
            redirect('Docs');
        }
    }

    public function error()
    {
        $this->data['main_view'] = 'error';
        $this->data['title'] = 'Login Error';
        $this->load->view($this->layout, $this->data);
    }

    public function logout()
    {
        $this->login->logout();
        redirect(base_url());
    }

}

?>