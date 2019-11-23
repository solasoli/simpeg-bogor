<?php
    define ('WEB_ROOT','http://localhost/');
    define ('APP_DIR',str_replace("\\","/",getcwd()));
    define ('SYSTEM_DIR',APP_DIR.'/');
    include(SYSTEM_DIR."cls_koncil.php");

    class AjaxData{
        public $id_pegawai;
        public $id_skpd;
        private $db;
        public $mysqli;

        public function __construct()
        {
            $this->db = Database::getInstance();
            $this->mysqli = $this->db->getConnection();
        }

        public function get_list_pegawai($id_skpd){
            if($id_skpd!='') {
                $sql = "SELECT p.id_pegawai, p.nip_baru, CONCAT(CASE WHEN p.gelar_depan = '' THEN '' ELSE CONCAT(p.gelar_depan, ' ') END,
                        nama, CASE WHEN p.gelar_belakang = '' THEN '' ELSE CONCAT(' ',p.gelar_belakang) END) AS nama, p.pangkat_gol,
                        CASE WHEN p.jenjab = 'Fungsional' THEN p.jabatan ELSE CASE WHEN p.id_j IS NULL THEN
                        (SELECT jm.nama_jfu AS jabatan
                         FROM jfu_pegawai jp, jfu_master jm
                         WHERE jp.kode_jabatan = jm.kode_jabatan AND jp.id_pegawai = p.id_pegawai LIMIT 1)
                        ELSE j.jabatan END END AS jabatan, CASE WHEN j.eselon IS NULL THEN 'Z' ELSE j.eselon END AS eselon
                        FROM pegawai p LEFT JOIN jabatan j ON p.id_j = j.id_j, current_lokasi_kerja clk, unit_kerja uk
                        WHERE p.id_pegawai = clk.id_pegawai AND clk.id_unit_kerja = uk.id_unit_kerja AND uk.id_skpd = $id_skpd AND p.flag_pensiun = 0
                        ORDER BY eselon ASC, p.pangkat_gol DESC, p.nama";
                $result = $this->mysqli->query($sql);
                $dataList = "{\"data\": [";
                $i = 1;
                while ($ot = $result->fetch_array(MYSQLI_NUM)) {
                    $dataList .= "{\"no\" : \"$i\",\"id_pegawai\" : \"$ot[0]\", \"nip_baru\" : \"$ot[1]\", \"nama\" : \"$ot[2]\", \"pangkat_gol\" : \"$ot[3]\",
                     \"jabatan\" : \"$ot[4]\"},";
                    $i++;
                }
                $dataList = substr($dataList, 0, strlen($dataList) - 1);
                $dataList .= ']}';
                if ($dataList == '{"data": ]}') {
                    $dataList = '{"data":[]}';
                }
            }else{
                $dataList = '{"data":[]}';
            }
            return $dataList;
        }

        public function update_verifikasi_berkas($idberkas,$idstatus){
            if($idstatus=='Belum'){
                $idstatus = 2;
            }else{
                $idstatus = 1;
            }
            $sql = "UPDATE berkas SET status = $idstatus WHERE id_berkas = $idberkas";
            $this->mysqli->autocommit(FALSE);
            if($result = $this->mysqli->query($sql)){
                $this->mysqli->commit();
                $sql = "SELECT `status_berkas` FROM status_berkas WHERE idstatus_berkas = $idstatus";
                $rsts = $this->mysqli->query($sql);
                while ($ot = $rsts->fetch_array(MYSQLI_NUM)) {
                    $sts = $ot[0];
                }
                $results = '[{"hasil":1,"status":"'.$sts.'"}]';
            }else{
                $this->mysqli->rollback();
                $results = '[{"hasil":0,"status":""}]';
            }
            return $results;
        }

        public function update_verifikasi_berkas_bkpp($idberkas,$idstatus,$idp){
            if($idstatus==0){
                $sql = "SELECT uk.id_skpd FROM
                        (SELECT clk.id_unit_kerja FROM current_lokasi_kerja clk
                        WHERE clk.id_pegawai = $idp) a, unit_kerja uk
                        WHERE a.id_unit_kerja = uk.id_unit_kerja";
                $result = $this->mysqli->query($sql);
                while ($ot = $result->fetch_array(MYSQLI_NUM)) {
                    $idskpd = $ot[0];
                }
                if($idskpd==4198){
                    $idstatus = 1;
                }else{
                    $idstatus = 2;
                }
            }
            $sql = "UPDATE berkas SET status = $idstatus WHERE id_berkas = $idberkas";
            $this->mysqli->autocommit(FALSE);
            if($result = $this->mysqli->query($sql)){
                $this->mysqli->commit();
                $sql = "SELECT `status_berkas` FROM status_berkas WHERE idstatus_berkas = $idstatus";
                $rsts = $this->mysqli->query($sql);
                while ($ot = $rsts->fetch_array(MYSQLI_NUM)) {
                    $sts = $ot[0];
                }
                $results = '[{"hasil":1,"status":"'.$sts.'"}]';
            }else{
                $this->mysqli->rollback();
                $results = '[{"hasil":0,"status":""}]';
            }
            return $results;
        }

        public function getJumlahNotifikasi($idp){
            $sql = "SELECT COUNT(n.id_notif) AS jumlah
                    FROM notifikasi n
                    WHERE n.id_pegawai_to = ".$idp." AND n.status_read = 0 AND n.deleted = 0";
            if($result = $this->mysqli->query($sql)){
                $this->mysqli->commit();
                while ($ot = $result->fetch_array(MYSQLI_NUM)) {
                    $jumlah = $ot[0];
                }
                $results = '[{"hasil":1,"jumlah":"'.$jumlah.'"}]';
            }else{
                $this->mysqli->rollback();
                $results = '[{"hasil":0,"jumlah":"0"}]';
            }
            return $results;
        }

        public function updateNotifikasiRead($idnotif){
            $sql = "update notifikasi set status_read = 1 where id_notif=$idnotif";
            $this->mysqli->autocommit(FALSE);
            if($result = $this->mysqli->query($sql)){
                $this->mysqli->commit();
                $results = '[{"hasil":1,"status":"1"}]';
            }else{
                $this->mysqli->rollback();
                $results = '[{"hasil":0,"status":"0"}]';
            }
            return $results;
        }

        public function getNotifikasiList($idp){
            if($idp!='') {
                $sql = "SELECT b.*, CASE WHEN b.jenjab = 'Fungsional' THEN b.jabatan ELSE CASE WHEN b.id_j IS NULL THEN
                        (SELECT jm.nama_jfu AS jabatan
                         FROM jfu_pegawai jp, jfu_master jm
                         WHERE jp.kode_jabatan = jm.kode_jabatan AND jp.id_pegawai = b.id_pegawai_from LIMIT 1)
                        ELSE j.jabatan END END AS jabatan_get, uk.nama_baru as unit_kerja, DATE_FORMAT(b.tgl_notif,  '%d/%m/%Y %H:%i') AS tgl_notif_2
                        FROM
                        (SELECT a.*, p.nip_baru, CONCAT(CASE WHEN p.gelar_depan = '' THEN '' ELSE CONCAT(p.gelar_depan, ' ') END,
                        nama, CASE WHEN p.gelar_belakang = '' THEN '' ELSE CONCAT(' ',p.gelar_belakang) END) AS nama, p.jenjab, p.id_j, p.jabatan
                        FROM pegawai p,
                        (SELECT n.id_notif, nj.jenis_notifikasi, n.tgl_notif, nsr.sen_rec_name, n.id_pegawai_from,
                        REPLACE(TRIM(TRAILING '\n' FROM  n.additional_data),'\"','') as additional_data,
                        REPLACE(REPLACE(TRIM(TRAILING '\n' FROM  n.additional_data2),'\"',''),'\n','') as additional_data2,
                        nsr.url_type_app, nsr.file_app, n.status_read
                        FROM notifikasi n, notifikasi_jenis nj, notifikasi_sender_recipient nsr
                        WHERE n.id_jenis_notif = nj.id_jenis_notifikasi AND n.id_sender = nsr.id_sen_rec
                        AND n.id_pegawai_to = ".$idp." and n.deleted = 0
                        ORDER BY n.tgl_notif DESC) a WHERE p.id_pegawai = a.id_pegawai_from AND p.flag_pensiun = 0) b
                        LEFT JOIN jabatan j ON b.id_j = j.id_j, current_lokasi_kerja clk, unit_kerja uk
                        WHERE b.id_pegawai_from = clk.id_pegawai AND clk.id_unit_kerja = uk.id_unit_kerja ORDER BY b.tgl_notif DESC";
                $result = $this->mysqli->query($sql);
                $dataList = "{\"data\": [";
                $i = 1;
                while ($ot = $result->fetch_array(MYSQLI_NUM)) {
                    $dataList .= "{\"no\" : \"$i\",\"id_notif\" : \"$ot[0]\", \"jenis_notifikasi\" : \"$ot[1]\", \"tgl_notif\" : \"$ot[17]\", \"sen_rec_name\" : \"$ot[3]\",
                     \"additional_data\" : \"$ot[5]\", \"additional_data2\" : \"$ot[6]\",\"url_type_app\" : \"$ot[7]\", \"file_app\" : \"$ot[8]\", \"status_read\" : \"$ot[9]\",
                     \"nip_baru\" : \"$ot[10]\", \"nama\" : \"$ot[11]\", \"jabatan\" : \"$ot[15]\", \"unit_kerja\" : \"$ot[16]\", \"id_pegawai_from\" : \"$ot[4]\"},";
                    $i++;
                }
                $dataList = substr($dataList, 0, strlen($dataList) - 1);
                $dataList .= ']}';
                if ($dataList == '{"data": ]}') {
                    $dataList = '{"data":[]}';
                }
            }else{
                $dataList = '{"data":[]}';
            }
            return $dataList;
        }

        public function deleteNotifikasi($idnotif){
            $sql = $sql = "update notifikasi set deleted = 1 where id_notif=$idnotif";
            $this->mysqli->autocommit(FALSE);
            if($result = $this->mysqli->query($sql)){
                $this->mysqli->commit();
                $results = '[{"hasil":1,"status":"1"}]';
            }else{
                $this->mysqli->rollback();
                $results = '[{"hasil":0,"status":"0"}]';
            }
            return $results;
        }

        public function getChildPost($idparent){
            if($idparent!='') {
                $sql = "SELECT po.id_post, po.msg, po.id_pegawai, DATE_FORMAT(po.kapan,  '%d/%m/%Y %H:%i:%s') AS kapan, po.parent_id,
                        CONCAT(CASE WHEN p.gelar_depan = '' THEN '' ELSE CONCAT(p.gelar_depan, ' ') END,
                        nama, CASE WHEN p.gelar_belakang = '' THEN '' ELSE CONCAT(' ',p.gelar_belakang) END) AS nama
                        FROM post po, pegawai p
                        WHERE p.id_pegawai = po.id_pegawai AND po.parent_id = ".$idparent." AND p.flag_pensiun = 0
                        ORDER BY po.kapan DESC";
                $result = $this->mysqli->query($sql);
                $dataList = "{\"data\": [";
                $i = 1;
                while ($ot = $result->fetch_array(MYSQLI_NUM)) {
                    $dataList .= "{\"no\" : \"$i\",\"msg\" : \"".trim(preg_replace('/\s\s+/', ' ', $ot[1]))."\", \"id_pegawai\" : \"$ot[2]\", \"kapan\" : \"$ot[3]\", \"nama\" : \"$ot[5]\"},";
                    $i++;
                }
                $dataList = substr($dataList, 0, strlen($dataList) - 1);
                $dataList .= ']}';
                if ($dataList == '{"data": ]}') {
                    $dataList = '{"data":[]}';
                }
            }else {
                $dataList = '{"data":[]}';
            }
            return $dataList;
        }

        public function insertPostBeranda($pesan,$id_pegawai,$parent_id){
            $sql = "insert into post (msg, id_pegawai, kapan, parent_id) values ('".$pesan."',".$id_pegawai.",NOW(),".$parent_id.")";
            $this->mysqli->autocommit(FALSE);
            if($result = $this->mysqli->query($sql)){
                $this->mysqli->commit();
                $results = '[{"hasil":1,"status":"1"}]';
            }else{
                $this->mysqli->rollback();
                $results = '[{"hasil":0,"status":"0"}]';
            }
            return $results;
        }

        public function list_absensi($id_unit_kerja, $tgl_cur, $id_skpd,$status){
            if($id_unit_kerja!='') {
                $whereKlausa = "";
                if($status!='0'){
                    $whereKlausa = " WHERE absen.status = '".$status."'";
                }

                $sql = "SELECT MAX(uk.id_unit_kerja) AS id_unit_kerja FROM unit_kerja uk
                            WHERE uk.nama_baru LIKE '%Sekretariat Daerah%' AND uk.tahun = (SELECT MAX(tahun) FROM unit_kerja uk1)";
                $result = $this->mysqli->query($sql);

                while ($ot = $result->fetch_array(MYSQLI_NUM)) {
                    $dataSekret = $ot[0];
                }
                if($id_skpd == $dataSekret){
                    $str = "uk.id_skpd = $id_skpd";
                }else{
                    $str = "uk.id_unit_kerja = $id_unit_kerja";
                }

                $tgl_cur = explode("/",$tgl_cur);
                $sql = "SELECT * FROM (SELECT p.*, ra.status FROM
                        (SELECT p.id_pegawai, p.nip_baru, CONCAT(CASE WHEN p.gelar_depan = '' THEN '' ELSE CONCAT(p.gelar_depan, ' ') END,
                        nama, CASE WHEN p.gelar_belakang = '' THEN '' ELSE CONCAT(' ',p.gelar_belakang) END) AS nama, p.pangkat_gol,
                        CASE WHEN p.jenjab = 'Fungsional' THEN p.jabatan ELSE CASE WHEN p.id_j IS NULL THEN
                        (SELECT jm.nama_jfu AS jabatan
                         FROM jfu_pegawai jp, jfu_master jm
                         WHERE jp.kode_jabatan = jm.kode_jabatan AND jp.id_pegawai = p.id_pegawai LIMIT 1)
                        ELSE j.jabatan END END AS jabatan, CASE WHEN j.eselon IS NULL THEN 'Z' ELSE j.eselon END AS eselon, uk.id_unit_kerja
                        FROM pegawai p LEFT JOIN jabatan j ON p.id_j = j.id_j, current_lokasi_kerja clk, unit_kerja uk
                        WHERE p.id_pegawai = clk.id_pegawai AND clk.id_unit_kerja = uk.id_unit_kerja AND ".$str." AND p.flag_pensiun = 0 AND flag_mpp IS NULL
                        ORDER BY eselon ASC, p.pangkat_gol DESC, p.nama) p LEFT JOIN report_absensi ra
                        ON p.id_pegawai = ra.id_pegawai AND p.id_unit_kerja = ra.id_unit_kerja AND ra.tgl = '".$tgl_cur[2]."-".$tgl_cur[0]."-".$tgl_cur[1]."'
                        ORDER BY p.eselon ASC, p.pangkat_gol DESC, p.nama) absen".$whereKlausa;
                
                $result = $this->mysqli->query($sql);
                $dataList = "{\"data\": [";
                $i = 1;
                while ($ot = $result->fetch_array(MYSQLI_NUM)) {
                    $dataList .= "{\"no\" : \"$i\",\"id_pegawai\" : \"$ot[0]\", \"nip_baru\" : \"$ot[1]\", \"nama\" : \"$ot[2]\", \"status\" : \"$ot[7]\"},";
                    $i++;
                }
                $dataList = substr($dataList, 0, strlen($dataList) - 1);
                $dataList .= ']}';
                if ($dataList == '{"data": ]}') {
                    $dataList = '{"data":[]}';
                }
            }else{
                $dataList = '{"data":[]}';
            }
            return $dataList;
        }

        public function updateAbsensi($id_pegawai,$status,$tglcur,$id_unit_kerja){
            $tgl_cur = explode("/",$tglcur);
            if($status=='R'){
                $sql = "delete from report_absensi where id_pegawai = ".$id_pegawai." and tgl = '".$tgl_cur[2]."-".$tgl_cur[0]."-".$tgl_cur[1]."'";
                $this->mysqli->autocommit(FALSE);
                if($result = $this->mysqli->query($sql)){
                    $sql2 = "delete from oasys_attendance_log where id_pegawai =".$id_pegawai." and tgl = '".$tgl_cur[2]."-".$tgl_cur[0]."-".$tgl_cur[1]."' and status in ('DL PAGI','DL PULANG', 'DINAS LUAR PULANG')";
                    
                    $this->mysqli->query($sql2);
                    $this->mysqli->commit();
                    $results = '[{"hasil":1,"status":"1"}]';
                }else{
                    echo $sql;
                    echo $sql2;
                    $this->mysqli->rollback();
                    $results = '[{"hasil":0,"status":"0"}]';
                }
            }else if($status=='DLPG'){
            $tgl_entri = $tgl_cur[2]."-".$tgl_cur[0]."-".$tgl_cur[1];
            if($tgl_entri <= date('Y-m-d')){
                $sql = "insert into oasys_attendance_log (`id_pegawai`, `date_time`, `status`, `id`, `longitude`, `latitude`) values('".$id_pegawai."','".$tgl_cur[2]."-".$tgl_cur[0]."-".$tgl_cur[1]." 07:30:00','DL PAGI',NULL,'0','0')";
                $sql_dlp = "insert into report_absensi(id_pegawai, id_unit_kerja, tgl, status) values ($id_pegawai,$id_unit_kerja,'".$tgl_cur[2]."-".$tgl_cur[0]."-".$tgl_cur[1]."','$status')";
                $this->mysqli->autocommit(FALSE);
                if($result = $this->mysqli->query($sql) && $this->mysqli->query($sql_dlp)){
                    $this->mysqli->commit();
                    $results = '[{"hasil":1,"status":"1"}]';
                }else{
                    $this->mysqli->rollback();
                    $results = '[{"hasil":0,"status":"0"}]';
                }
              }else{
                $results = '[{"hasil":0,"status":"0"}]';
              }
            }else if($status=='DLP'){
              $tgl_entri = $tgl_cur[2]."-".$tgl_cur[0]."-".$tgl_cur[1];
              if($tgl_entri <= date('Y-m-d')){
                $sql = "insert into oasys_attendance_log (`id_pegawai`, `date_time`, `status`, `id`, `longitude`, `latitude`) values('".$id_pegawai."','".$tgl_cur[2]."-".$tgl_cur[0]."-".$tgl_cur[1]." 17:00:00','DL PULANG',NULL,'0','0')";
                $sql_dlp = "insert into report_absensi(id_pegawai, id_unit_kerja, tgl, status) values ($id_pegawai,$id_unit_kerja,'".$tgl_cur[2]."-".$tgl_cur[0]."-".$tgl_cur[1]."','$status')";
                $this->mysqli->autocommit(FALSE);
                if($result = $this->mysqli->query($sql) && $this->mysqli->query($sql_dlp)){
                    $this->mysqli->commit();
                    $results = '[{"hasil":1,"status":"1"}]';
                }else{
                    $this->mysqli->rollback();
                    $results = '[{"hasil":0,"status":"0"}]';
                }
              }else{
                $results = '[{"hasil":0,"status":"0"}]';
              }
            }else{
                $sqlJml = "select count(*) as jumlah from report_absensi where id_pegawai = ".$id_pegawai." and tgl = '".$tgl_cur[2]."-".$tgl_cur[0]."-".$tgl_cur[1]."'";
                $result = $this->mysqli->query($sqlJml);
                $ot = $result->fetch_array(MYSQLI_NUM);
                if($ot[0]==0){
                    $sql = "insert into report_absensi(id_pegawai, id_unit_kerja, tgl, status) values ($id_pegawai,$id_unit_kerja,'".$tgl_cur[2]."-".$tgl_cur[0]."-".$tgl_cur[1]."','$status')";
                    $this->mysqli->autocommit(FALSE);
                    if($result = $this->mysqli->query($sql)){
                        $this->mysqli->commit();
                        $results = '[{"hasil":1,"status":"1"}]';
                    }else{
                        $this->mysqli->rollback();
                        $results = '[{"hasil":0,"status":"0"}]';
                    }
                }else{
                    $sql = "update report_absensi set status = '$status' where id_pegawai = $id_pegawai and id_unit_kerja = $id_unit_kerja and tgl = '".$tgl_cur[2]."-".$tgl_cur[0]."-".$tgl_cur[1]."'";
                    $this->mysqli->autocommit(FALSE);
                    if($result = $this->mysqli->query($sql)){
                        $this->mysqli->commit();
                        $results = '[{"hasil":1,"status":"1"}]';
                    }else{
                        $this->mysqli->rollback();
                        $results = '[{"hasil":0,"status":"0"}]';
                    }
                }
            }
            return $results;
        }

        public function kirimAbsensi($id_pegawai,$tglcur,$id_unit_kerja){
            $tgl_cur = explode("/",$tglcur);
            $sqlJml = "select count(*) as jumlah from report_absensi_master where id_pegawai = ".$id_pegawai."
                        and tgl_absen = ".(Int)$tgl_cur[1]." and bln_absen = ".(Int)$tgl_cur[0]." and thn_absen = ".(Int)$tgl_cur[2]."
                        and id_unit_kerja = ".$id_unit_kerja;
            $result = $this->mysqli->query($sqlJml);
            $ot = $result->fetch_array(MYSQLI_NUM);
            if($ot[0]==0){
                $sql = "insert into report_absensi_master(tgl_input, tgl_update, id_pegawai, id_unit_kerja, tgl_absen, bln_absen, thn_absen, status)
                values (NOW(), NOW(),".$id_pegawai.",".$id_unit_kerja.",".$tgl_cur[1].",".$tgl_cur[0].",".$tgl_cur[2].",'Sudah terkirim')";
                $this->mysqli->autocommit(FALSE);

                if($result = $this->mysqli->query($sql)){
                    $this->mysqli->commit();
                    $results = '[{"hasil":1,"status":"1"}]';
                }else{
                    $this->mysqli->rollback();
                    $results = '[{"hasil":0,"status":"0"}]';
                }
            }else{
                $sql = "update report_absensi_master set status = 'Sudah terkirim dan diperbarui', tgl_update = NOW()
                        where id_pegawai = $id_pegawai and id_unit_kerja = $id_unit_kerja
                        and tgl_absen = $tgl_cur[1] and bln_absen = $tgl_cur[0] and thn_absen = $tgl_cur[2]";
                $this->mysqli->autocommit(FALSE);
                if($result = $this->mysqli->query($sql)){
                    $this->mysqli->commit();
                    $results = '[{"hasil":1,"status":"1"}]';
                }else{
                    $this->mysqli->rollback();
                    $results = '[{"hasil":0,"status":"0"}]';
                }
            }
            return $results;
        }

        public function listRiwayatAbsensi($id_unit_kerja,$bln_absen,$thn_absen){

            $sql = "SELECT ram.tgl_absen, ram.tgl_input, ram.tgl_update,
                    p.nip_baru, CONCAT(CASE WHEN p.gelar_depan = '' THEN '' ELSE CONCAT(p.gelar_depan, ' ') END,
                    nama, CASE WHEN p.gelar_belakang = '' THEN '' ELSE CONCAT(' ',p.gelar_belakang) END) AS nama,
                    CASE WHEN p.jenjab = 'Fungsional' THEN p.jabatan ELSE CASE WHEN p.id_j IS NULL THEN
                    (SELECT jm.nama_jfu AS jabatan
                     FROM jfu_pegawai jp, jfu_master jm
                     WHERE jp.kode_jabatan = jm.kode_jabatan AND jp.id_pegawai = p.id_pegawai LIMIT 1)
                    ELSE j.jabatan END END AS jabatan, ram.status
                    FROM report_absensi_master ram, pegawai p LEFT JOIN jabatan j ON p.id_j = j.id_j
                    WHERE ram.id_pegawai = p.id_pegawai AND ram.id_unit_kerja = $id_unit_kerja
                    AND ram.bln_absen = $bln_absen AND ram.thn_absen = $thn_absen ORDER BY ram.tgl_absen";

            $result = $this->mysqli->query($sql);
            $dataList = "{\"data\": [";
            $i = 1;
            while ($ot = $result->fetch_array(MYSQLI_NUM)) {
                $dataList .= "{\"no\" : \"$i\",\"tgl_absen\" : \"$ot[0]\", \"tgl_input\" : \"$ot[1]\", \"tgl_update\" : \"$ot[2]\", \"nip_baru\" : \"$ot[3]\",
                     \"nama\" : \"$ot[4]\", \"jabatan\" : \"$ot[5]\", \"status\" : \"$ot[6]\"},";
                $i++;
            }
            $dataList = substr($dataList, 0, strlen($dataList) - 1);
            $dataList .= ']}';
            if ($dataList == '{"data": ]}') {
                $dataList = '{"data":[]}';
            }
            return $dataList;
        }

    }

    $objData = new AjaxData();
    if(isset($_GET['filter'])){
        $filter = $_GET['filter'];
    }else{
        $filter = '';
    }
    if(isset($_GET['idskpd'])){
        $id_skpd = $_GET['idskpd'];
    }else{
        $id_skpd = '';
    }

    switch ($filter){
        case 'verif_berkas':
            echo $objData->get_list_pegawai($id_skpd);
            break;
        case 'update_verif':
            $idberkas = $_GET['idberkas'];
            $idstatus = $_GET['idstatus'];
            echo $objData->update_verifikasi_berkas($idberkas,$idstatus);
            break;
        case 'update_verif_bkpp':
            $idberkas = $_GET['idberkas'];
            $idstatus = $_GET['idstatus'];
            $idp = $_GET['idp'];
            echo $objData->update_verifikasi_berkas_bkpp($idberkas,$idstatus,$idp);
            break;
        case 'load_notifikasi':
            $idp = $_GET['idp'];
            echo $objData->getJumlahNotifikasi($idp);
            break;
        case 'update_notif_read':
            $idnotif = $_GET['idnotif'];
            echo $objData->updateNotifikasiRead($idnotif);
            break;
        case 'notifikasi_list_all':
            $idp = $_GET['idp'];
            echo $objData->getNotifikasiList($idp);
            break;
        case 'delete_notif':
            $idnotif = $_GET['idnotif'];
            echo $objData->deleteNotifikasi($idnotif);
            break;
        case 'post_list_child':
            $idparent = $_GET['idparent'];
            echo $objData->getChildPost($idparent);
            break;
        case 'insert_post_beranda':
            $pesan = $_GET['pesan'];
            $id_pegawai = $_GET['id_pegawai'];
            $parent_id = $_GET['parent_id'];
            echo $objData->insertPostBeranda($pesan,$id_pegawai,$parent_id);
            break;
        case 'listabsensi':
            $id_unit_kerja = $_GET['id_unit_kerja'];
            $tgl_cur = $_GET['tglcur'];
            $status = $_GET['status'];
            echo $objData->list_absensi($id_unit_kerja, $tgl_cur, $id_skpd, $status);
            break;
        case 'update_absensi':
            $id_unit_kerja = $_GET['id_unit_kerja'];
            $id_pegawai = $_GET['id_pegawai'];
            $status = $_GET['status'];
            $tglcur = $_GET['tglcur'];
            echo $objData->updateAbsensi($id_pegawai,$status,$tglcur,$id_unit_kerja);
            break;
        case 'kirimabsensi':
            $id_unit_kerja = $_GET['id_unit_kerja'];
            $tglcur = $_GET['tglcur'];
            $id_pegawai = $_GET['id_pegawai'];
            echo $objData->kirimAbsensi($id_pegawai,$tglcur,$id_unit_kerja);
            break;
        case 'listriwayat_absensi':
            $id_unit_kerja = $_GET['id_unit_kerja'];
            $bln_absen = $_GET['bln_absen'];
            $thn_absen = $_GET['thn_absen'];
            echo $objData->listRiwayatAbsensi($id_unit_kerja,$bln_absen,$thn_absen);
            break;
    }

?>
