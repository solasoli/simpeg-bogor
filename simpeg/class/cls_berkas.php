<?php
    define ('WEB_ROOT','http://localhost/');
    define ('APP_DIR',str_replace("\\","/",getcwd()));
    define ('SYSTEM_DIR',APP_DIR.'/');
    include(SYSTEM_DIR."class/cls_koncil.php");

    class Berkas{
        public $id_pegawai;
        private $db;
        public $mysqli;
        public $nip;
        public $newFileName;
        public $jmlBerkasFile;

        public function __construct()
        {
            $this->db = Database::getInstance();
            $this->mysqli = $this->db->getConnection();
        }

        public function view_berkas_sk_pegawai($id_pegawai,$idawal){
            if($idawal==0 or $idawal==''){
                $whereKlause = "";
            }else{
                $whereKlause = " AND s.id_sk = ".$idawal;
            }
            $sql = "SELECT c.*, CASE WHEN c.id_berkas = 0 THEN NULL ELSE (GROUP_CONCAT(' ',CASE WHEN LOCATE('\\\\19', ib.file_name) = 2 THEN
                      SUBSTRING(ib.file_name, LOCATE('19', ib.file_name, 33),50) ELSE
                     SUBSTRING(ib.file_name, LOCATE('19', ib.file_name),50) END)) END as file_name,
                    IF(file_name IS NULL,0,(CASE WHEN c.id_berkas = 0 THEN 0 ELSE COUNT(ib.id_isi_berkas) END)) AS jml_berkas
                     FROM (SELECT a.*, b.status, sb.status_berkas FROM
                      (SELECT s.id_sk, s.id_kategori_sk, ks.nama_sk, s.no_sk, DATE_FORMAT(s.tgl_sk,'%d/%m/%Y') as tgl_sk,
                       DATE_FORMAT(s.tmt,'%d/%m/%Y') as tmt, s.gol, s.mk_tahun,
                        s.mk_bulan, s.id_berkas FROM sk s, kategori_sk ks WHERE s.id_kategori_sk = ks.id_kategori_sk
                        AND s.id_pegawai = $id_pegawai AND s.id_kategori_sk <> 10 $whereKlause) a LEFT JOIN berkas b ON a.id_berkas = b.id_berkas
                      LEFT JOIN status_berkas sb ON sb.idstatus_berkas = b.status) c
                      LEFT JOIN isi_berkas ib ON c.id_berkas = ib.id_berkas
                     GROUP BY id_sk,id_kategori_sk,id_berkas ORDER BY c.nama_sk DESC";
            $result = $this->mysqli->query($sql);
            return $result;
        }

        public function view_berkas_pendidikan_pegawai($id_pegawai,$idawal){
            if($idawal==0 or $idawal==''){
                $whereKlause = "";
            }else{
                $whereKlause = " AND pnd.id_pendidikan = ".$idawal;
            }
            $sql = "SELECT c.*, CASE WHEN c.id_berkas = 0 THEN NULL ELSE GROUP_CONCAT(' ',CASE WHEN LOCATE('\\\\19', ib.file_name) = 2 THEN SUBSTRING(ib.file_name,LOCATE('19', ib.file_name, 33),50) ELSE
                     SUBSTRING(ib.file_name, LOCATE('19', ib.file_name),50) END) END as file_name,
                    IF(file_name IS NULL,0, CASE WHEN c.id_berkas = 0 THEN 0 ELSE COUNT(ib.id_isi_berkas) END) AS jml_berkas
                    FROM
                    (SELECT a.*, b.status, sb.status_berkas
                    FROM
                    (SELECT pnd.id_pendidikan, kp.nama_pendidikan, pnd.lembaga_pendidikan, pnd.jurusan_pendidikan,
                    pnd.tahun_lulus, pnd.id_berkas
                    FROM pendidikan pnd, kategori_pendidikan kp
                    WHERE pnd.id_pegawai = $id_pegawai AND pnd.level_p = kp.level_p $whereKlause) a
                    LEFT JOIN berkas b ON a.id_berkas = b.id_berkas LEFT JOIN status_berkas sb ON sb.idstatus_berkas = b.status) c
                    LEFT JOIN isi_berkas ib ON c.id_berkas = ib.id_berkas
                    GROUP BY id_pendidikan, id_berkas";
            $result = $this->mysqli->query($sql);
            return $result;
        }

        public function view_berkas_pendukung_pegawai($id_pegawai,$idawal){
            if($idawal==0 or $idawal==''){
                $whereKlause = "";
            }else{
                $whereKlause = " AND b.id_berkas = ".$idawal;
            }

            $sql = "SELECT a.*, CASE WHEN a.id_berkas = 0 THEN NULL ELSE GROUP_CONCAT(' ',CASE WHEN LOCATE('\\\\19', ib.file_name) = 2 THEN SUBSTRING(ib.file_name,LOCATE('19', ib.file_name, 33),50) ELSE
                     SUBSTRING(ib.file_name, LOCATE('19', ib.file_name),50) END) END as file_name,
                    IF(file_name IS NULL,0, CASE WHEN a.id_berkas = 0 THEN NULL ELSE COUNT(ib.id_isi_berkas) END) AS jml_berkas
                    FROM
                    (SELECT b.id_berkas, kb.nm_kat AS nm_kat, b.ket_berkas, b.status, sb.status_berkas
                    FROM berkas b, kat_berkas kb, status_berkas sb
                    WHERE b.id_pegawai = $id_pegawai $whereKlause AND (b.id_kat = 1 OR b.id_kat = 13 OR b.id_kat = 14
                    OR b.id_kat = 15 OR b.id_kat = 10) AND b.id_kat = kb.id_kat_berkas AND sb.idstatus_berkas = b.status) a LEFT JOIN isi_berkas ib
                    ON a.id_berkas = ib.id_berkas
                    GROUP BY id_berkas";
            $result = $this->mysqli->query($sql);
            return $result;
        }

        public function view_berkas_jabatan_pegawai($id_pegawai,$idawal){
            if($idawal==0 or $idawal==''){
                $whereKlause = "";
            }else{
                $whereKlause = " AND s.id_sk = ".$idawal;
            }
            $sql = "SELECT c.*, CASE WHEN c.id_berkas = 0 THEN NULL ELSE GROUP_CONCAT(' ',CASE WHEN LOCATE('\\\\19', ib.file_name) = 2 THEN SUBSTRING(ib.file_name,LOCATE('19', ib.file_name, 33),50) ELSE
                     SUBSTRING(ib.file_name, LOCATE('19', ib.file_name),50) END) END as file_name,
                    IF(file_name IS NULL,0, CASE WHEN c.id_berkas = 0 THEN 0 ELSE COUNT(ib.id_isi_berkas) END) AS jml_berkas
                    FROM
                    (SELECT a.*, b.status, sb.status_berkas
                    FROM
                    (SELECT s.id_sk, s.no_sk, DATE_FORMAT(s.tgl_sk,'%d/%m/%Y') AS tgl_sk, DATE_FORMAT(s.tmt,'%d/%m/%Y') AS tmt, s.gol, s.mk_tahun, s.mk_bulan, s.id_berkas,
                    s.id_j, CASE WHEN j.jabatan IS NULL THEN '-' ELSE j.jabatan END AS jabatan, CASE WHEN j.eselon IS NULL THEN '-' ELSE j.eselon END AS eselon
                    FROM sk s LEFT JOIN jabatan j ON s.id_j = j.id_j
                    WHERE s.id_pegawai = $id_pegawai AND s.id_kategori_sk = 10 $whereKlause) a
                    LEFT JOIN berkas b ON a.id_berkas = b.id_berkas LEFT JOIN status_berkas sb
                    ON sb.idstatus_berkas = b.status) c
                    LEFT JOIN isi_berkas ib ON c.id_berkas = ib.id_berkas
                    GROUP BY id_sk, id_berkas";
            $result = $this->mysqli->query($sql);
            return $result;
        }

        public function cek_berkas($id_berkas){
            $sql = "SELECT * FROM isi_berkas ib WHERE ib.id_berkas = $id_berkas";
            $result = $this->mysqli->query($sql);
            return $result;
        }

        public function setNIP($idp){
            $sql = "select nip_baru from pegawai where id_pegawai = ".$idp.' AND flag_pensiun = 0 LIMIT 1';
            $result = $this->mysqli->query($sql);
            while ($data = $result->fetch_array(MYSQLI_NUM)) {
                $this->nip = $data[0];
            }
        }

        public function insertBerkas($id_pegawai,$id_kat,$nm_berkas,$ket_berkas,$file_name,$idawal,$file_path){
            $this->mysqli->autocommit(FALSE);
            $sql = "insert into berkas (id_pegawai,id_kat,nm_berkas,ket_berkas,tgl_upload,created_by,created_date,status) ".
            "values (".$id_pegawai.", ".$id_kat.",'".$nm_berkas."','".$ket_berkas."',DATE(NOW()), '".$id_pegawai."', NOW(),1)";
            if($result = $this->mysqli->query($sql)){
                $idb = $this->mysqli->insert_id;
                $sql = "insert into isi_berkas (id_berkas, ket) values ($idb, '".$nm_berkas."')";
                if($result = $this->mysqli->query($sql)){
                    $idib = $this->mysqli->insert_id;
                    $type = strtolower(substr(strrchr($file_name, '.'), 1));
                    $nf = $this->nip."-".$idb."-".$idib.".".$type;
                    //echo 'Berkas'.$nf;
                    $sql = "update isi_berkas set file_name='$nf' where id_isi_berkas=$idib";
                    if($result = $this->mysqli->query($sql)){
                        switch ($id_kat){
                            case 2:
                                $sql = "update sk set id_berkas = $idb where id_sk = $idawal";
                                break;
                            case 3:
                                $sql = "update pendidikan set id_berkas = $idb where id_pendidikan = $idawal";
                                break;
                        }
                        if($id_kat == 2 or $id_kat == 3){
                            //echo $sql;
                            if($result = $this->mysqli->query($sql)){
                                $this->mysqli->commit();
                                $type = strtolower(substr(strrchr($file_name, '.'), 1));
                                $nf = $this->nip."-".$idb."-".$idib.".".$type;
                                rename($file_path,"./Berkas/".$nf);
                                $this->setNewFileName($nf);
                                return '1';
                            }else{
                                $this->mysqli->rollback();
                                return '0';
                            }
                        }else{
                            $this->mysqli->commit();
                            $type = strtolower(substr(strrchr($file_name, '.'), 1));
                            $nf = $this->nip."-".$idb."-".$idib.".".$type;
                            rename($file_path,"./Berkas/".$nf);
                            $this->setNewFileName($nf);
                            return '1';
                        }
                    }else{
                        $this->mysqli->rollback();
                        return '0';
                    }
                }else{
                    $this->mysqli->rollback();
                    return '0';
                }
            }else{
                $this->mysqli->rollback();
                return '0';
            }
        }

        public function insertIsiBerkas($idb, $nm_berkas, $file_name, $file_path){
            $this->mysqli->autocommit(FALSE);
            $sql = "insert into isi_berkas (id_berkas, ket) values ($idb, '".$nm_berkas."')";
            if($result = $this->mysqli->query($sql)){
                $idib = $this->mysqli->insert_id;
                $type = strtolower(substr(strrchr($file_name, '.'), 1));
                $nf = $this->nip."-".$idb."-".$idib.".".$type;
                //echo 'Isi Berkas'.$nf;
                $sql = "update isi_berkas set file_name='$nf' where id_isi_berkas=$idib";
                if($result = $this->mysqli->query($sql)){
                    $this->mysqli->commit();
                    $type = strtolower(substr(strrchr($file_name, '.'), 1));
                    $nf = $this->nip."-".$idb."-".$idib.".".$type;
                    rename($file_path,"./Berkas/".$nf);
                    $this->setNewFileName($nf);
                    return '1';
                }else{
                    $this->mysqli->rollback();
                    return '0';
                }
            }else{
                $this->mysqli->rollback();
                return '0';
            }
        }

        public function deleteBerkas($idIsiBerkas, $idBerkas, $jmlBerkas, $jenisVerif, $idawal){
            $this->mysqli->autocommit(FALSE);
            if($jmlBerkas==1){
                $sql = "delete from isi_berkas where id_isi_berkas=$idIsiBerkas";
                //echo $jmlBerkas.$sql;
                if($result = $this->mysqli->query($sql)){
                    if($jenisVerif=='SK' or $jenisVerif=='Ijazah' or $jenisVerif=='Jabatan'){
                        $sql = "delete from berkas where id_berkas=$idBerkas";
                        //echo $jmlBerkas.$sql;
                        if($result = $this->mysqli->query($sql)){
                            switch ($jenisVerif){
                                case 'SK':
                                    $sql = "update sk set id_berkas = 0 where id_sk = $idawal";
                                    break;
                                case 'Ijazah':
                                    $sql = "update pendidikan set id_berkas = 0 where id_pendidikan = $idawal";
                                    break;
                                case 'Jabatan':
                                    $sql = "update sk set id_berkas = 0 where id_sk = $idawal";
                                    break;
                            }
                            if($jenisVerif == 'SK' or $jenisVerif == 'Ijazah' or $jenisVerif=='Jabatan'){
                                //echo $jmlBerkas.$sql;
                                if($result = $this->mysqli->query($sql)){
                                    $this->mysqli->commit();
                                    return '1';
                                }else{
                                    $this->mysqli->rollback();
                                    return '0';
                                }
                            }else{
                                $this->mysqli->commit();
                                return '1';
                            }
                        }else{
                            $this->mysqli->rollback();
                            return '0';
                        }
                    }else{
                        $this->mysqli->commit();
                        return '1';
                    }
                }else{
                    $this->mysqli->rollback();
                    return '0';
                }
            }else{
                $sql = "delete from isi_berkas where id_isi_berkas=$idIsiBerkas";
                //echo $jmlBerkas.$sql;
                if($result = $this->mysqli->query($sql)){
                    $this->mysqli->commit();
                    return '1';
                }else{
                    $this->mysqli->rollback();
                    return '0';
                }
            }
        }

        public function setNewFileName($nf){
            $this->newFileName = $nf;
        }

        public function getNewFileName(){
            return $this->newFileName;
        }

        public function setJmlFileBerkas($jml){
            $this->jmlBerkasFile = $jml;
        }

        public function getJmlFileBerkas(){
            return $this->jmlBerkasFile;
        }
    }