<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//$_ci =& get_instance();
//print_r($this->session->all_userdata());
//die;
class Login extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Login_model','login');
        $this->layout = 'layout';
    }

    public function index(){
        $loginOri = $this->input->post(null, true);
        $login = $this->login->login_access($loginOri);
        if (!$login['query']) {
            if($login['data']==''){
                $this->session->set_flashdata('pesan_error', 'NIP atau Password salah');
                redirect('login-error');
            }else{
                if($login['data']['status_aktif']=='Aktif' or $login['data']['status_aktif']=='Aktif Bekerja'){
                    $this->session->set_flashdata('pesan_error', 'Jabatan anda adalah '.$login['data']['jenjab'].' '.$login['data']['jabatan']);
                    redirect('login-error');
                }else{
                    $this->session->set_flashdata('pesan_error', 'Anda sedang '.$login['data']['status_aktif']);
                    redirect('login-error');
                }
            }
        }
        $login_status = $this->session->userdata('login_status_ekinerja');
        $user_level = $this->session->userdata('user_level');
        if ($login_status == true) {
            if($user_level == 'admin_opd'){
                redirect('adminopd');
            }elseif($user_level == 'admin_bkpsda') {
                redirect('adminbkpsda');
            }elseif($user_level == 'admin_bpkad'){
                redirect('adminbpkad');
            }elseif($user_level == 'sekda'){
                redirect('sekda');
            }elseif($user_level == 'walikota') {
                redirect('walikota');
            }else{
                $login = (object)$loginOri;
                $idknjm = $login->idknjm;
                if($idknjm != ''){
                    redirect('publicpegawai/peninjauan_staf_detail_kegiatan?idknjm='.$idknjm);
                }else{
                    redirect('publicpegawai');
                }
            }
        }
    }

    public function logout()
    {
        $this->login->logout();
        redirect(base_url());
    }

}

?>
