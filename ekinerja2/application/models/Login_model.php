<?php
class Login_model extends CI_Model{

    public function login_access($login){
        $login = (object)$login;

        $sql = "SELECT p.id_pegawai, p.nip_baru, p.nama, p.status_aktif, p.jenjab, jaf.nama_jafung as jabatan
                FROM pegawai p 
                LEFT JOIN jafung_pegawai jafp ON p.id_pegawai = jafp.id_pegawai
                LEFT JOIN jafung jaf ON jafp.id_jafung = jaf.id_jafung
                LEFT JOIN current_lokasi_kerja clk ON p.id_pegawai = clk.id_pegawai
                LEFT JOIN unit_kerja uk ON clk.id_unit_kerja = uk.id_unit_kerja
                WHERE p.nip_baru = '".$login->txtUserName."' AND p.jenjab = 'Fungsional' AND p.flag_pensiun = 0 AND uk.id_skpd = 
                (SELECT id_unit_kerja FROM unit_kerja WHERE nama_baru LIKE 'Dinas Pendidikan %' AND tahun = (SELECT MAX(tahun) FROM unit_kerja))
                AND (jaf.nama_jafung NOT LIKE '%Pamong Belajar%' AND jaf.nama_jafung NOT LIKE '%Penilik%') 
                /* 2. Yang mendapat insentif pajak daerah (tetap mengisi) */
                /* 3. Yang mendapat jasa pelayanan kesehatan (tetap mengisi) */
                /* 4. Yang ditugaskan pada Instansi di luar Pemerintah Kota Bogor */
                UNION ALL
                SELECT p.id_pegawai, p.nip_baru, p.nama, p.status_aktif, p.jenjab, '' as jabatan
                FROM pegawai p WHERE p.nip_baru = '".$login->txtUserName."' AND p.status_aktif = 'Dipekerjakan' AND p.flag_pensiun = 0
                /* 5. Yang berstatus tersangka dan ditahan oleh pihak berwajib selama menjalani masa penahanan (blm ada flagingnya) */
                /* 6. Yang mengikuti tugas belajar */
                UNION ALL
                SELECT p.id_pegawai, p.nip_baru, p.nama, p.status_aktif, p.jenjab, '' as jabatan 
                FROM pegawai p WHERE p.nip_baru = '".$login->txtUserName."' AND p.status_aktif = 'Tugas Belajar' AND p.flag_pensiun = 0
                /* 7. Yang sedang menjalankan cuti di luar tanggungan negara (CLTN). */
                UNION ALL
                SELECT p.id_pegawai, p.nip_baru, p.nama, p.status_aktif, p.jenjab, '' as jabatan 
                FROM pegawai p WHERE p.nip_baru = '".$login->txtUserName."' AND p.status_aktif = 'Cuti Diluar Tanggungan Negara (CLTN)' AND p.flag_pensiun = 0
                /* 8. Yang melaksanakan cuti lebih dari jumlah hari kerja dalam1 (satu) bulan */
                /* 9. Yang tidak masuk kerja tanpa keterangan yang sah secara terus menerus selama 1 (satu) bulan penuh */
                /* 10. Yang Pegawai yang sedang melaksanakan Masa Persiapan Pensiun (MPP). */
                UNION ALL
                SELECT p.id_pegawai, p.nip_baru, p.nama, p.status_aktif, p.jenjab, '' as jabatan 
                FROM pegawai p WHERE p.nip_baru = '".$login->txtUserName."' AND p.status_aktif = 'Masa Persiapan Pensiun (MPP)' AND p.flag_pensiun = 0;";
        $query = $this->db->query($sql);
        $data = null;
        $rowcount = $query->num_rows();
        if($rowcount > 0) {
            foreach ($query->result() as $user) {
                $data = array(
                    'status_aktif' => $user->status_aktif,
                    'jenjab' => $user->jenjab,
                    'jabatan' => $user->jabatan);
            }
            return array(
                'query' => false,
                'data' => $data
            );
        }else{
            $sql = "SELECT b.*, uk.nama_baru as opd FROM 
                  (SELECT a.*, g.pangkat, HEX(AES_ENCRYPT(a.id_pegawai,SHA2('keyloginekinerja',512))) as id_pegawai_enc FROM
                  (SELECT p.id_pegawai, p.nip_baru, p.nama, p.pangkat_gol, p.id_j, clk.id_unit_kerja,
                     uk.nama_baru as unit_kerja, ra.idknj_admin, su.status_user_knj, su.alias, uk.id_skpd,
                     HEX(AES_ENCRYPT(uk.id_skpd,SHA2('keyloginekinerja',512))) as id_skpd_enc 
                   FROM pegawai p INNER JOIN current_lokasi_kerja clk ON p.id_pegawai = clk.id_pegawai
                     INNER JOIN unit_kerja uk ON clk.id_unit_kerja = uk.id_unit_kerja
                     INNER JOIN knj_admin ra ON p.id_pegawai = ra.id_pegawai
                     INNER JOIN knj_status_user su ON ra.idstatus_user_knj = su.idstatus_user_knj
                   WHERE ra.user_name = ".$this->db->escape($login->txtUserName)." AND ra.password = ".$this->db->escape($login->txtPassword)." AND ra.status_aktif = 1 
                   AND p.flag_pensiun = 0) a
                  INNER JOIN golongan g ON a.pangkat_gol = g.golongan) b LEFT JOIN unit_kerja uk ON b.id_skpd = uk.id_unit_kerja";
            $query = $this->db->query($sql);
            $data = null;
            $rowcount = $query->num_rows();
            if($rowcount > 0) {
                foreach ($query->result() as $user){
                    $data = array(
                        'id_pegawai' => $user->id_pegawai,
                        'id_pegawai_enc' => $user->id_pegawai_enc,
                        'nip' => $user->nip_baru,
                        'nama' => $user->nama,
                        'gol' => $user->pangkat_gol,
                        'pangkat' => $user->pangkat,
                        'id_unit_kerja' => $user->id_unit_kerja,
                        'unit_kerja' => $user->unit_kerja,
                        'id_skpd' => $user->id_skpd,
                        'id_skpd_enc' => $user->id_skpd_enc,
                        'user_level' => $user->alias,
                        'user_level_name' => $user->status_user_knj,
                        'login_status_ekinerja' => true,
                        'idknj_admin' => $user->idknj_admin,
                        'id_j' => $user->id_j,
                        'opd' => $user->opd
                    );
                }
                $this->session->set_userdata($data);
                return array(
                    'query' => true,
                    'data' => ''
                );
            }else{
                $sql = "SELECT b.*, uk.nama_baru as opd FROM 
                    (SELECT a.*, g.pangkat, su.status_user_knj, su.alias, HEX(AES_ENCRYPT(a.id_pegawai,SHA2('keyloginekinerja',512))) as id_pegawai_enc FROM
                    (SELECT p.id_pegawai, p.nip_baru, p.nama, p.pangkat_gol, p.id_j, clk.id_unit_kerja,
                      uk.nama_baru as unit_kerja, 6 as idstatus_user_knj, uk.id_skpd, HEX(AES_ENCRYPT(uk.id_skpd,SHA2('keyloginekinerja',512))) as id_skpd_enc
                    FROM pegawai p INNER JOIN current_lokasi_kerja clk ON p.id_pegawai = clk.id_pegawai
                      INNER JOIN unit_kerja uk ON clk.id_unit_kerja = uk.id_unit_kerja
                    WHERE p.nip_baru = ".$this->db->escape($login->txtUserName)." AND p.password = ".$this->db->escape($login->txtPassword)." AND p.flag_pensiun = 0) a
                    INNER JOIN knj_status_user su ON a.idstatus_user_knj = su.idstatus_user_knj
                    INNER JOIN golongan g ON a.pangkat_gol = g.golongan) b LEFT JOIN unit_kerja uk ON b.id_skpd = uk.id_unit_kerja";
                $query = $this->db->query($sql);
                $data = null;
                $rowcount = $query->num_rows();
                if($rowcount > 0) {
                    foreach ($query->result() as $user) {
                        $data = array(
                            'id_pegawai' => $user->id_pegawai,
                            'id_pegawai_enc' => $user->id_pegawai_enc,
                            'nip' => $user->nip_baru,
                            'nama' => $user->nama,
                            'gol' => $user->pangkat_gol,
                            'pangkat' => $user->pangkat,
                            'id_unit_kerja' => $user->id_unit_kerja,
                            'unit_kerja' => $user->unit_kerja,
                            'id_skpd' => $user->id_skpd,
                            'id_skpd_enc' => $user->id_skpd_enc,
                            'user_level' => $user->alias,
                            'user_level_name' => $user->status_user_knj,
                            'login_status_ekinerja' => true,
                            'id_j' => $user->id_j,
                            'opd' => $user->opd
                        );
                    }
                    $this->session->set_userdata($data);
                    return array(
                        'query' => true,
                        'data' => ''
                    );
                }
            }
        }
        return array(
            'query' => false,
            'data' => ''
        );
    }

    public function logout(){
        $this->session->unset_userdata(
            array('username' => '', 'login_status_ekinerja' => false, 'user_level' => '')
        );
        $this->session->sess_destroy();
    }

}
?>
