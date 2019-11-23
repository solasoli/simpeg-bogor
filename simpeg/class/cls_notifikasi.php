<?php
define ('WEB_ROOT','http://localhost/');
define ('APP_DIR',str_replace("\\","/",getcwd()));
define ('SYSTEM_DIR',APP_DIR.'/');
include(SYSTEM_DIR."class/cls_koncil.php");

class Notifikasi
{
    public function __construct()
    {
        $this->db = Database::getInstance();
        $this->mysqli = $this->db->getConnection();
    }

    public function getMsgNotifikasi($idp){
        $sql = "SELECT a.*, CONCAT(CASE WHEN p.gelar_depan = '' THEN '' ELSE CONCAT(p.gelar_depan, ' ') END,
                    nama, CASE WHEN p.gelar_belakang = '' THEN '' ELSE CONCAT(' ',p.gelar_belakang) END) AS nama
                    FROM pegawai p,
                    (SELECT n.id_notif, nj.jenis_notifikasi, DATE_FORMAT(n.tgl_notif,  '%d/%m/%Y %H:%i:%s') AS tgl_notif, nsr.sen_rec_name, n.id_pegawai_from, n.additional_data,
                    n.additional_data2, nsr.url_type_app, nsr.file_app, n.status_read
                    FROM notifikasi n, notifikasi_jenis nj, notifikasi_sender_recipient nsr
                    WHERE n.id_jenis_notif = nj.id_jenis_notifikasi AND n.id_sender = nsr.id_sen_rec
                    AND n.id_pegawai_to = ".$idp." and n.deleted = 0
                    ORDER BY n.tgl_notif DESC) a WHERE p.id_pegawai = a.id_pegawai_from AND p.flag_pensiun = 0 LIMIT 0,10";
        $result = $this->mysqli->query($sql);
        return $result;
    }

    public function getParentPost($idpost){
        $sql = "SELECT id_post, msg, id_pegawai, DATE_FORMAT(kapan,  '%d/%m/%Y %H:%i:%s') AS kapan, parent_id
                FROM post po WHERE po.id_post = ".$idpost." ORDER BY po.kapan";
        $result = $this->mysqli->query($sql);
        return $result;
    }

    public function getUserType(){
        $sql = "select * from user_roles where role_id = 2";
        $result = $this->mysqli->query($sql);
        return $result;
    }
}
?>