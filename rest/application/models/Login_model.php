<?php
class Login_model extends CI_Model
{
    public function login($login){
        $login = (object)$login;
        if($login->txtUserName=='anonymous' and $login->txtPassword=='anonymous'){
            $data = array(
                'user_level' => 'anonymous',
                'login_status' => true
            );
            $this->session->set_userdata($data);
            return false;
        }else{
            $sql = "SELECT a.*, g.pangkat FROM 
                (SELECT p.id_pegawai, p.nip_baru, p.nama, p.pangkat_gol, clk.id_unit_kerja, 
                uk.nama_baru as unit_kerja, ra.idrest_admin, ra.status_pengguna 
                FROM pegawai p INNER JOIN current_lokasi_kerja clk ON p.id_pegawai = clk.id_pegawai
                  INNER JOIN unit_kerja uk ON clk.id_unit_kerja = uk.id_unit_kerja
                INNER JOIN rest_admin ra ON p.id_pegawai = ra.id_pegawai
                WHERE ra.user_name = '".$login->txtUserName."' AND ra.password = '".$login->txtPassword."' AND ra.status_aktif = 1) a
                INNER JOIN golongan g ON a.pangkat_gol = g.golongan";
            $query = $this->db->query($sql);
            $data = null;
            $rowcount = $query->num_rows();
            if($rowcount > 0) {
                foreach ($query->result() as $user) {
                    $data = array(
                        'id_pegawai' => $user->id_pegawai,
                        'nip' => $user->nip_baru,
                        'nama' => $user->nama,
                        'gol' => $user->pangkat_gol,
                        'pangkat' => $user->pangkat,
                        'id_unit_kerja' => $user->id_unit_kerja,
                        'unit_kerja' => $user->unit_kerja,
                        'user_level' => $user->status_pengguna,
                        'login_status' => true,
                        'idrest_admin' => $user->idrest_admin
                    );
                }
                $this->session->set_userdata($data);
                return true;
            }
        }
        return false;
    }

    public function logout(){
        $this->session->unset_userdata(
            array('username' => '', 'login_status' => false, 'user_level' => '')
        );
        $this->session->sess_destroy();
    }

}
?>