<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Administrator_model extends CI_Model
{
    public function __construct()
    {

    }

    public function listof_entitas(){
        $sql = "SELECT * FROM rest_entitas;";
        return $this->db->query($sql);
    }

    public function insert_entitas($data){
        $this->db->trans_begin();
        $sql = "insert into rest_entitas(entitas, keterangan) ".
            "values ('".$data['txtEntitas']."','".$data['txtKet']."')";
        $this->db->query($sql);
        if ($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            $query = 'false';
            $identitas = 0;
        }else{
            $identitas = $this->db->insert_id();
            $this->db->trans_commit();
            $query = 'true';
        }
        return array(
            'query' => $query,
            'identitas' => $identitas
        );
    }

    public function update_entitas($data){
        $this->db->trans_begin();
        $sql = "update rest_entitas set entitas = '".$data['txtEntitas']."', keterangan = '".$data['txtKet']."'
                where entitas = '".$data['txtIdEntitas']."'";
        $this->db->query($sql);
        if ($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            $query = 'false';
        }else{
            $this->db->trans_commit();
            $query = 'true';
        }
        return $query;
    }

    public function delete_entitas($identitas){
        return $this->db->delete('rest_entitas',array('entitas'=>$identitas));
    }

    public function get_entitas_by_id($id){
        $sql = "SELECT * FROM rest_entitas WHERE entitas = '$id';";
        return $this->db->query($sql);
    }

    public function listof_rest_master($entitas=null,$keyword=null){
        $andKlause = "";
        if($entitas!="" and $entitas!="All"){
            $andKlause .= " AND rm.entitas = '".$entitas."'";
        }
        if($keyword!=""){
            $andKlause .= " AND (rm.judul LIKE '%$keyword%' OR rm.uraian LIKE '%$keyword%')";
        }

        $sql = "SELECT rm.id_methode, rm.judul, rm.uraian, rm.entitas, rm.function, rm.url, rm.methode,
                  DATE_FORMAT(rm.tgl_create, '%d-%m-%Y %H:%m:%s') as tgl_create, p.nip_baru,
                  CONCAT(CASE WHEN p.gelar_depan = '' THEN '' ELSE CONCAT(p.gelar_depan, ' ') END,
                         nama, CASE WHEN p.gelar_belakang = '' THEN '' ELSE CONCAT(' ',p.gelar_belakang) END) AS nama,
                  COUNT( DISTINCT rp.idrest_params) as jml_params, COUNT(DISTINCT rr.idrest_response) as jml_respons
                FROM rest_master rm
                LEFT JOIN rest_admin ra ON rm.idrest_admin = ra.idrest_admin
                LEFT JOIN pegawai p ON ra.id_pegawai = p.id_pegawai
                LEFT JOIN rest_request_params rp ON rm.id_methode = rp.id_methode
                LEFT JOIN rest_response rr ON rm.id_methode = rr.id_methode
                WHERE rm.id_methode IS NOT NULL ".$andKlause."
                GROUP BY rm.id_methode";
        return $this->db->query($sql);
    }

    public function get_params_methode_by_id($idmethode){
        $sql = "SELECT * FROM rest_request_params WHERE id_methode = $idmethode";
        return $this->db->query($sql);
    }

    public function get_response_methode_by_id($idmethode){
        $sql = "SELECT * FROM rest_response WHERE id_methode = $idmethode";
        return $this->db->query($sql);
    }

    public function get_detail_methode_by_id($idmethode){
        $sql = "SELECT rm.*, DAY(rm.tgl_create) as tgl, MONTH(rm.tgl_create) as bln, YEAR(rm.tgl_create) as thn, TIME(rm.tgl_create) as jam,
                DATE_FORMAT(rm.tgl_update, '%d-%m-%Y %H:%i:%s') as tgl_update2,
                CONCAT(CASE WHEN p.gelar_depan = '' THEN '' ELSE CONCAT(p.gelar_depan, ' ') END,
                nama, CASE WHEN p.gelar_belakang = '' THEN '' ELSE CONCAT(' ',p.gelar_belakang) END) AS inputer
                FROM rest_master rm LEFT JOIN rest_admin ra ON rm.idrest_admin = ra.idrest_admin
                LEFT JOIN pegawai p ON ra.id_pegawai = p.id_pegawai
                WHERE rm.id_methode = $idmethode";
        return $this->db->query($sql);
    }

    public function insert_methode($data){
        $this->db->trans_begin();
        $sql = "insert into rest_master(tgl_create, tgl_update, idrest_admin, judul, uraian, entitas, function,
				url, methode, sample_call, keterangan, flag_param_enkrip) ".
            "values (".'NOW(),NOW(),'.$data['idrest_admin'].",'".$data['txtJudul'].
            "','".$data['txtUraian']."','".$data['ddEntitas']."','".$data['txtFungsi']."','".$data['txtUrl'].
            "','".$data['ddMethode']."','".$data['txtSampleCall']."','".$data['txtKet']."',".$data['chkParamEnkrip'].")";

        $this->db->query($sql);
        if ($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            $query = 'false';
            $idmethode = 0;
        }else{
            $idmethode = $this->db->insert_id();
            $this->db->trans_commit();
            $query = 'true';
        }
        return array(
            'query' => $query,
            'idmethode' => $idmethode
        );
    }

    public function update_methode($data){
        $this->db->trans_begin();
        $sql = "update rest_master set tgl_update = NOW(), judul = '".$data['txtJudul']."', uraian = '".$data['txtUraian']."', entitas = '".$data['ddEntitas']."',
                function = '".$data['txtFungsi']."', url = '".$data['txtUrl']."', methode = '".$data['ddMethode']."', 
                sample_call = '".$data['txtSampleCall']."', keterangan = '".$data['txtKet']."', flag_param_enkrip = ".$data['chkParamEnkrip']." 
                where id_methode = ".$data['txtIdMethode'];
        //echo $sql;
        $this->db->query($sql);
        if ($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            $query = 'false';
        }else{
            $this->db->trans_commit();
            $query = 'true';
        }
        return $query;
    }

    public function delete_methode($id_methode){
        return $this->db->delete('rest_master',array('id_methode'=>$id_methode));
    }

    public function insert_params_methode($data){
        $this->db->trans_begin();
        $sql = "insert into rest_request_params (params_name, params_type, `values`, is_required, id_methode) ".
               "values ('".$data['params_name']."','".$data['methode_type']."','".$data['values']."',".$data['chkRequired'].",".$data['id_methode'].")";
        $this->db->query($sql);
        if ($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            $query = 'false';
        }else{
            $this->db->trans_commit();
            $query = 'true';
        }
        return $query;
    }

    public function update_params_methode($data){
        $this->db->trans_begin();
        $sql = "update rest_request_params set params_name = '".$data['params_name']."', params_type = '".$data['methode_type']."',
                `values` = '".$data['values']."', is_required = '".$data['chkRequired']."'
                where idrest_params = ".$data['idrest_params'];
        $this->db->query($sql);
        if ($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            $query = 'false';
        }else{
            $this->db->trans_commit();
            $query = 'true';
        }
        return $query;
    }

    public function delete_params_methode($idrest_params){
        return $this->db->delete('rest_request_params',array('idrest_params'=>$idrest_params));
    }

    public function insert_respons_methode($data){
        $this->db->trans_begin();
        $sql = "insert into rest_response (status_code, content, id_methode) ".
               "values ('".$data['status_code']."','".$data['content']."',".$data['id_methode'].")";
        $this->db->query($sql);
        if ($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            $query = 'false';
        }else{
            $this->db->trans_commit();
            $query = 'true';
        }
        return $query;
    }

    public function update_respons_methode($data){
        $this->db->trans_begin();
        $sql = "update rest_response set status_code = '".$data['status_code']."', content = '".$data['content']."' 
                where idrest_response = ".$data['idrest_response'];
        $this->db->query($sql);
        if ($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            $query = 'false';
        }else{
            $this->db->trans_commit();
            $query = 'true';
        }
        return $query;
    }

    public function delete_respons_methode($idrest_response){
        return $this->db->delete('rest_response',array('idrest_response'=>$idrest_response));
    }

    public function listof_rest_apps(){
        $sql = "SELECT a.idrest_apps, a.nama_apps, a.platform, a.owner, a.api_key, a.word_key, a.available_url,
                GROUP_CONCAT(CONCAT(a.entitas,' (',a.jml_methode,')')) as entitas_use,
                SUM(a.jml_methode) as jml_methode FROM
                (SELECT ra.*, rm.entitas, COUNT(rm.id_methode) as jml_methode
                FROM rest_apps ra LEFT JOIN rest_access rc ON ra.idrest_apps = rc.idrest_apps
                  LEFT JOIN rest_master rm ON rm.id_methode = rc.id_methode
                GROUP BY ra.idrest_apps, entitas) a
                GROUP BY a.idrest_apps";
        return $this->db->query($sql);
    }

    public function get_detail_apps_by_id($id_apps){
        $sql = "SELECT * FROM rest_apps WHERE idrest_apps = $id_apps";
        return $this->db->query($sql);
    }

    public function insert_apps($data){
        $this->db->trans_begin();
        $sql = "insert into rest_apps(nama_apps, platform, owner, api_key, word_key, available_url, rsa_private_key, rsa_public_key, rsa_modulo, rsa_prime_p, rsa_prime_q) ".
                "values ('".$data['txtApps']."','".$data['ddPlatform']."','".$data['txtOwner']."','".$data['txtApiKey']."','".$data['txtWordKey']."','".$data['txtUrl']."','".$data['txtPrivateKey']."','".$data['txtPublicKey']."','".$data['txtModulo']."','".$data['txtP']."','".$data['txtQ']."' )";
        $this->db->query($sql);
        if ($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            $query = 'false';
            $idapps = 0;
        }else{
            $idapps = $this->db->insert_id();
            $this->db->trans_commit();
            $query = 'true';
        }
        return array(
            'query' => $query,
            'idapps' => $idapps
        );
    }

    public function cek_nilai_prime_eksisting($p, $q){
        if($p==$q){
            $jmlExist = 1;
        }else{
            $sql = "SELECT COUNT(*) as jumlah FROM rest_apps ra 
        WHERE ra.rsa_prime_p = $p OR ra.rsa_prime_q = $q";
            $prime_eksisting = $this->db->query($sql);
            $rowcount = $prime_eksisting->num_rows();
            if($rowcount>0){
                foreach ($prime_eksisting->result() as $data) {
                    $jmlExist = $data->jumlah;
                }
            }else{
                $jmlExist = 0;
            }
        }
        return $jmlExist;
    }

    public function update_apps($data){
        $this->db->trans_begin();
        if($data['updatePrime']=='true'){
            $sql = "update rest_apps set nama_apps = '".$data['txtApps']."', platform = '".$data['ddPlatform']."', owner = '".$data['txtOwner']."',
                api_key = '".$data['txtApiKey']."', word_key = '".$data['txtWordKey']."', available_url = '".$data['txtUrl']."'
                , rsa_private_key = '".$data['txtPrivateKey']."', rsa_public_key = '".$data['txtPublicKey']."', rsa_modulo = '".$data['txtModulo']."'
                , rsa_prime_p = '".$data['txtP']."', rsa_prime_q = '".$data['txtQ']."' 
                where idrest_apps = ".$data['txtIdApps'];
        }else{
            $sql = "update rest_apps set nama_apps = '".$data['txtApps']."', platform = '".$data['ddPlatform']."', owner = '".$data['txtOwner']."',
                api_key = '".$data['txtApiKey']."', word_key = '".$data['txtWordKey']."', available_url = '".$data['txtUrl']."' 
                where idrest_apps = ".$data['txtIdApps'];
        }

        $this->db->query($sql);
        if ($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            $query = 'false';
        }else{
            $this->db->trans_commit();
            $query = 'true';
        }
        return $query;
    }

    public function delete_apps($idapps){
        return $this->db->delete('rest_apps',array('idrest_apps'=>$idapps));
    }

    public function listof_access_methode($id_apps){
        $sql = "SELECT ra.idrest_access, ra.idrest_apps, ra.id_methode, rm.judul, rm.entitas, DATE_FORMAT(ra.tgl_create, '%d-%m-%Y %H:%m:%s') as tgl_create,
                DATE_FORMAT(ra.tgl_update, '%d-%m-%Y %H:%m:%s') as tgl_update,
                CASE WHEN ra.status_aktif = 1 THEN 'Aktif' ELSE 'Tidak Aktif' END AS status_aktif,
                rm.methode, rm.entitas 
                FROM rest_access ra INNER JOIN rest_master rm ON ra.id_methode = rm.id_methode
                WHERE ra.idrest_apps = $id_apps ORDER BY ra.tgl_create DESC";
        return $this->db->query($sql);
    }

    public function access_methode_by_id($idakses_methode){
        $sql = "SELECT ra.idrest_access, ra.idrest_apps, ra.id_methode, rm.judul, rm.entitas, DATE_FORMAT(ra.tgl_create, '%d-%m-%Y %H:%m:%s') as tgl_create,
                DATE_FORMAT(ra.tgl_update, '%d-%m-%Y %H:%m:%s') as tgl_update,
                CASE WHEN ra.status_aktif = 1 THEN 'Aktif' ELSE 'Tidak Aktif' END AS status_aktif,
                ra.status_aktif, rm.methode, rm.entitas 
                FROM rest_access ra INNER JOIN rest_master rm ON ra.id_methode = rm.id_methode
                WHERE ra.idrest_access = $idakses_methode ORDER BY ra.tgl_create DESC";
        return $this->db->query($sql);
    }

    public function insert_access_methode($data){
        $this->db->trans_begin();
        if(isset($data['chkIdMethodePilih']) and sizeof($data['chkIdMethodePilih']) > 0){
            foreach( $data['chkIdMethodePilih'] as $key => $n ) {
                $sql = "insert into rest_access(idrest_apps, id_methode, tgl_create, idrest_admin, tgl_update, status_aktif) ".
                    "values (".$data['idapps'].",".$data['chkIdMethodePilih'][$key].",NOW(),".$data['idrest_admin'].",NOW(),1)";
                $this->db->query($sql);
            }
            if ($this->db->trans_status() === FALSE){
                $this->db->trans_rollback();
                $query = 'false';
            }else{
                $this->db->trans_commit();
                $query = 'true';
            }
        }else{
            $this->db->trans_rollback();
            $query = 'false';
        }

        return $query;
    }

    public function update_access_methode($data){
        $this->db->trans_begin();
        $sql = "update rest_access set status_aktif = ".$data['ddStatus'].", tgl_update = NOW(), idrest_admin = ".$data['idrest_admin']." 
                where idrest_access = ".$data['txtIdrest_access'];
        $this->db->query($sql);
        if ($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            $query = 'false';
        }else{
            $this->db->trans_commit();
            $query = 'true';
        }
        return $query;
    }

    public function delete_access_methode($idrest_access){
        return $this->db->delete('rest_access',array('idrest_access'=>$idrest_access));
    }

    public function delete_all_access_methode_by_apps($idapps){
        $sql = "delete from rest_access where idrest_apps = $idapps";
        $query = $this->db->query($sql);
        return $query;
    }

    public function listof_admin(){
        $sql = "SELECT ra.idrest_admin, DATE_FORMAT(ra.tgl_create, '%d-%m-%Y') as tgl_create, ra.user_name, ra.password,
                CASE WHEN ra.status_aktif = 1 THEN 'Aktif' ELSE 'Tidak Aktif' END AS status_aktif,
                p.nip_baru, CONCAT(CASE WHEN p.gelar_depan = '' THEN '' ELSE CONCAT(p.gelar_depan, ' ') END,
                nama, CASE WHEN p.gelar_belakang = '' THEN '' ELSE CONCAT(' ',p.gelar_belakang) END) AS nama, ra.status_pengguna
                FROM rest_admin ra LEFT JOIN pegawai p ON ra.id_pegawai = p.id_pegawai
                ORDER BY p.nama ASC";
        return $this->db->query($sql);
    }

    public function get_admin_by_id($idrest_admin){
        $sql = "SELECT a.*, p.nama FROM
                (SELECT * FROM rest_admin ra WHERE ra.idrest_admin = $idrest_admin) a
                LEFT JOIN pegawai p ON a.id_pegawai = p.id_pegawai";
        return $this->db->query($sql);
    }

    public function get_admin_by_uname($nip){
        $sql = "SELECT * FROM rest_admin ra WHERE ra.user_name = '$nip'";
        return $this->db->query($sql);
    }

    public function insert_admin($data){
        $this->db->trans_begin();
        $sql = "insert into rest_admin(tgl_create, user_name, password, id_pegawai, status_aktif, status_pengguna) ".
            "values (NOW(), '".$data['txtUName']."','".$data['txtPwd']."',".$data['txtIdPegawai'].",".$data['ddStatusAktif'].",'".$data['ddStatusUser']."')";
        $this->db->query($sql);
        if ($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            $query = 'false';
            $idrest_admin = 0;
        }else{
            $idrest_admin = $this->db->insert_id();
            $this->db->trans_commit();
            $query = 'true';
        }
        return array(
            'query' => $query,
            'idrest_admin' => $idrest_admin
        );
    }

    public function update_admin($data){
        $this->db->trans_begin();
        if($data['txtPwd']==''){
            $sql = "update rest_admin set status_aktif = ".$data['ddStatusAktif'].",
                    status_pengguna = '".$data['ddStatusUser']."'
                    where idrest_admin = ".$data['txtIdRestAdmin'];
        }else{
            $sql = "update rest_admin set password = '".$data['txtPwd']."', status_aktif = ".$data['ddStatusAktif'].",
                    status_pengguna = '".$data['ddStatusUser']."'
                    where idrest_admin = ".$data['txtIdRestAdmin'];
        }
        $this->db->query($sql);
        if ($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            $query = 'false';
        }else{
            $this->db->trans_commit();
            $query = 'true';
        }
        return $query;
    }

    public function delete_admin($idrest_admin){
        return $this->db->delete('rest_admin',array('idrest_admin'=>$idrest_admin));
    }

    public function listof_log_access(){
        $sql = "SELECT ra.idrest_log, ra.id_methode, rs.nama_apps, rm.judul, DATE_FORMAT(ra.tgl_create, '%d-%m-%Y %H:%m:%s') as tgl_create,
                CASE WHEN ra.status_aktif = 1 THEN 'Aktif' ELSE 'Tidak Aktif' END AS status_aktif,
                CONCAT(CASE WHEN p.gelar_depan = '' THEN '' ELSE CONCAT(p.gelar_depan, ' ') END,
                nama, CASE WHEN p.gelar_belakang = '' THEN '' ELSE CONCAT(' ',p.gelar_belakang) END) AS oleh, ra.`transaction`
                FROM rest_log ra INNER JOIN rest_master rm ON ra.id_methode = rm.id_methode
                INNER JOIN rest_apps rs ON ra.idrest_apps = rs.idrest_apps
                INNER JOIN rest_admin rn ON ra.idrest_admin = rn.idrest_admin
                LEFT JOIN pegawai p ON rn.id_pegawai = p.id_pegawai
                ORDER BY ra.tgl_create DESC";
        return $this->db->query($sql);
    }

    public function get_methode_type(){
        $sql = "SELECT * FROM rest_methode_type";
        return $this->db->query($sql);
    }

    public function get_platform(){
        $sql = "SELECT * FROM rest_platform";
        return $this->db->query($sql);
    }

    public function get_apps(){
        $sql = "SELECT * FROM rest_apps";
        return $this->db->query($sql);
    }

    public function get_methode_by_entitas($entitas){
        $sql = "SELECT * FROM rest_master WHERE entitas = '".$entitas."'";
        return $this->db->query($sql);
    }

    public function cari_pegawai_by_nip($data){
        $sql = "SELECT p.id_pegawai, p.nip_baru, p.nama, uk.nama_baru as unit
                    FROM pegawai p
                    LEFT JOIN current_lokasi_kerja clk ON p.id_pegawai = clk.id_pegawai
                    LEFT JOIN unit_kerja uk ON clk.id_unit_kerja = uk.id_unit_kerja
                    WHERE p.nip_baru LIKE '%".$data."%' OR p.nip_lama LIKE '%".$data."%'
                    ORDER BY p.nama LIMIT 50";
        $query = $this->db->query($sql);
        return $query->result();
    }

    public function cari_pegawai_by_word($data){
        $sql = "SELECT p.id_pegawai, p.nip_baru, p.nama, uk.nama_baru as unit
                    FROM pegawai p
                    LEFT JOIN current_lokasi_kerja clk ON p.id_pegawai = clk.id_pegawai
                    LEFT JOIN unit_kerja uk ON clk.id_unit_kerja = uk.id_unit_kerja
                    WHERE p.nama LIKE '%".$data."%' 
                    ORDER BY p.nama LIMIT 50";
        $query = $this->db->query($sql);
        return $query->result();
    }

    public function cetakManualRest_by_apps($idapps){
        $sql = "SELECT ra.id_methode, rm.judul, rm.uraian, CASE WHEN ra.status_aktif = 1 THEN 'Aktif' ELSE 'Tidak Aktif' END AS status_aktif,
                rm.methode, rm.entitas, rm.sample_call
                FROM rest_access ra INNER JOIN rest_master rm ON ra.id_methode = rm.id_methode
                WHERE ra.idrest_apps = $idapps ORDER BY ra.id_methode ASC";
        return $this->db->query($sql);
    }

}