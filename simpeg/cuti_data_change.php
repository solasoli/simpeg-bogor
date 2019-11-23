<?php
session_start();
include 'class/cls_cuti.php';
$oCuti = new Cuti();
$dc = $_POST['data_change'];

switch($dc) {
    case 'hapusCuti':
        $data = array('idcm' => $_POST['idcm']);
        $change = $oCuti->hapusDataCuti($data);
        echo $change;
        break;
    case 'batalCuti':
        $data = array(
            'idcm' => $_POST['idcm'],
            'keterangan' => $_POST['keterangan'],
            'idpApprover' => $_POST['idpApprover']
        );
        $change = $oCuti->batalUsulanCuti($data);
        echo $change;
        break;
    case 'kirimCuti':
        $idKepAtsl = $_POST['idKepAtsl'];
        $idKepPjbt = $_POST['idKepPjbt'];
        $isLampiranLainnya = $_POST['isLampiranLainnya'];
        $data = array(
            'idKepAtsl' => $idKepAtsl,
            'cttn_atsl' => $_POST['cttn_atsl'],
            'tmtMulaiPenangguhanAtsl' => ($idKepAtsl==3?$_POST['tmtMulaiPenangguhanAtsl']:'NULL'),
            'lamaPengguhanAtsl' => ($idKepAtsl==3?$_POST['lamaPengguhanAtsl']:'NULL'),
            'tmtSelesaiPenangguhanAtsl' => ($idKepAtsl==3?$_POST['tmtSelesaiPenangguhanAtsl']:'NULL'),

            'idKepPjbt' => $idKepPjbt,
            'cttn_pjbt' => $_POST['cttn_pjbt'],
            'tmtMulaiPenangguhanPjbt' => ($idKepPjbt==3?$_POST['tmtMulaiPenangguhanPjbt']:'NULL'),
            'lamaPengguhanPjbt' => ($idKepPjbt==3?$_POST['lamaPengguhanPjbt']:'NULL'),
            'tmtSelesaiPenangguhanPjbt' => ($idKepPjbt==3?$_POST['tmtSelesaiPenangguhanPjbt']:'NULL'),

            'txtKeterangan' => $_POST['txtKeterangan'],
            'isLampiranLainnya' => $isLampiranLainnya,
            'idcm' => $_POST['idcm'],
            'idp_pemohon' => $_POST['idp_pemohon'],
            'idpApprover' => $_POST['idpApprover'],
            'flag_uk_atasan_sama' => $_POST['flag_uk_atasan_sama'],
            'istim' => $_POST['istim']
        );

        /*
          'uploadFileSuratCuti' => $_POST['uploadFileSuratCuti'],
            'uploadFileLainnya' => $_POST['uploadFileLainnya'],
         */
         $connection = ssh2_connect('103.14.229.15');
         ssh2_auth_password($connection, 'rommonz', 'mony3Tmony3T');
         $sftp = ssh2_sftp($connection);
        if($isLampiranLainnya==0){
            if(isset($_FILES["uploadFileSuratCuti"])) {
                if ($_FILES["uploadFileSuratCuti"]['name'] <> "") {
                    if ($_FILES["uploadFileSuratCuti"]['type'] == 'binary/octet-stream' or $_FILES["uploadFileSuratCuti"]['type'] == "application/pdf") {
                      $uploaddir = '/var/www/html/simpeg/berkas/';
                      $uploadfile = $uploaddir . basename($_FILES["uploadFileSuratCuti"]['name']);
                        //  if (move_uploaded_file($_FILES["uploadFileSuratCuti"]['tmp_name'], $uploadfile)) {
                        //echo $uploadfile;
                        error_reporting(0);

                        ssh2_scp_send($connection, $_FILES["uploadFileSuratCuti"]['tmp_name'], $uploadfile, 0644);

                        error_reporting(0);

                            $oCuti->mysqli->autocommit(FALSE);
                            $sql = "";
                            $sqlInsert = "insert into berkas (id_pegawai,id_kat,nm_berkas,tgl_upload,created_by,created_date,ket_berkas) ".
                                "values (".$_POST['idp_pemohon'].", 37,'Surat Permohonan Cuti', DATE(NOW()), '".$_POST['idpApprover']."', NOW(), '')";
                            if ($oCuti->mysqli->query($sqlInsert) === FALSE){
                                $oCuti->mysqli->rollback();
                                echo 3; //Data berkas tidak tersimpan
                            }else{
                                $idberkas = $oCuti->mysqli->insert_id;
                                $sqlInsert = "insert into isi_berkas (id_berkas, ket) values ($idberkas, 'Surat Permohonan Cuti')";
                                if ($oCuti->mysqli->query($sqlInsert) === FALSE) {
                                    $oCuti->mysqli->rollback();
                                    echo 3; //Data berkas tidak tersimpan
                                }else{
                                    $idisi = $oCuti->mysqli->insert_id;
                                    $nf=$_POST['nip']."-".$idberkas."-".$idisi.".pdf";
                                    $sqlUpdate = "update isi_berkas set file_name='$nf' where id_isi_berkas=$idisi";
                                    if ($oCuti->mysqli->query($sqlUpdate) === FALSE) {
                                        $oCuti->mysqli->rollback();
                                        echo 3; //Data berkas tidak tersimpan
                                    }else{
                                        $sqlUpdate = "update cuti_master set idberkas_surat_cuti = $idberkas where id_cuti_master=".$_POST['idcm'];
                                        if ($oCuti->mysqli->query($sqlUpdate) === FALSE) {
                                            $oCuti->mysqli->rollback();
                                            echo 3; //Data berkas tidak tersimpan
                                        }else{
                                            $oCuti->mysqli->commit();
                                            ssh2_sftp_rename($sftp, $uploadfile,$uploaddir.$nf);
                                            $update = $oCuti->kirimDataCuti($data);
                                            if($update==1){
                                                echo 5; //Pengubahan status data cuti tersimpan
                                            }else{
                                                echo 4; //Pengubahan status data cuti tidak tersimpan
                                            }
                                        }
                                    }
                                }
                            }
                        }else{
                            echo 2; //File tidak terupload. Ada permasalahan ketika mengakses jaringan
                        }
                    }else{
                        echo 1; //Tipe file bukan pdf
                    }
                }

        }else{  // break 173
            if(isset($_FILES["uploadFileSuratCuti"])) { //169
                if ($_FILES["uploadFileSuratCuti"]['name'] <> "") {
                    if ($_FILES["uploadFileSuratCuti"]['type'] == 'binary/octet-stream' or $_FILES["uploadFileSuratCuti"]['type'] == "application/pdf") {
                        $uploaddir = '/var/www/html/simpeg/berkas/';
                        $uploadfile = $uploaddir . basename($_FILES["uploadFileSuratCuti"]['name']);

                        if(ssh2_scp_send($connection, $_FILES["uploadFileSuratCuti"]['tmp_name'], $uploadfile, 0644)){
                      //  if (move_uploaded_file($_FILES["uploadFileSuratCuti"]['tmp_name'], $uploadfile)) {
                            $oCuti->mysqli->autocommit(FALSE);
                            $sqlInsert = "insert into berkas (id_pegawai,id_kat,nm_berkas,tgl_upload,created_by,created_date,ket_berkas) ".
                                "values (".$_POST['idp_pemohon'].", 37,'Surat Permohonan Cuti', DATE(NOW()), '".$_POST['idpApprover']."', NOW(), '')";
                            if ($oCuti->mysqli->query($sqlInsert) === FALSE){
                                $oCuti->mysqli->rollback();
                                $qryBerkas = 0;
                                $upBerkas = 1;
                            }else{
                                $idberkas = $oCuti->mysqli->insert_id;
                                $sqlInsert = "insert into isi_berkas (id_berkas, ket) values ($idberkas, 'Surat Permohonan Cuti')";
                                if ($oCuti->mysqli->query($sqlInsert) === FALSE) {
                                    $oCuti->mysqli->rollback();
                                    $qryBerkas = 0;
                                    $upBerkas = 1;
                                }else{
                                    $idisi = $oCuti->mysqli->insert_id;
                                    $nf=$_POST['nip']."-".$idberkas."-".$idisi.".pdf";
                                    $sqlUpdate = "update isi_berkas set file_name='$nf' where id_isi_berkas=$idisi";
                                    if ($oCuti->mysqli->query($sqlUpdate) === FALSE) {
                                        $oCuti->mysqli->rollback();
                                        $qryBerkas = 0;
                                        $upBerkas = 1;
                                    }else{
                                        $sqlUpdate = "update cuti_master set idberkas_surat_cuti = $idberkas where id_cuti_master=".$_POST['idcm'];
                                        if ($oCuti->mysqli->query($sqlUpdate) === FALSE) {
                                            $oCuti->mysqli->rollback();
                                            $qryBerkas = 0;
                                            $upBerkas = 1;
                                        }else{
                                            $oCuti->mysqli->commit();
                                            //rename($uploadfile,"berkas/".$nf);
                                            ssh2_sftp_rename($sftp, $uploadfile,$uploaddir.$nf);
                                            $qryBerkas = 1;
                                            $upBerkas = 1;
                                        }
                                    }
                                }
                            }
                        }else{
                            $qryBerkas = 0;
                            $upBerkas = 0;
                        }
                    } else {
                        $qryBerkas = 0;
                        $upBerkas = 0;
                    }
                }else{
                    $qryBerkas = 0;
                    $upBerkas = 0;
                }
            }else{
                $qryBerkas = 0;
                $upBerkas = 0;
            }

            if(isset($_FILES["uploadFileLainnya"])) {
                if ($_FILES["uploadFileLainnya"]['name'] <> "") {
                    if ($_FILES["uploadFileLainnya"]['type'] == 'binary/octet-stream' or $_FILES["uploadFileLainnya"]['type'] == "application/pdf") {
                        $uploaddir = '/var/www/html/simpeg/berkas/';
                        $uploadfile = $uploaddir . basename($_FILES["uploadFileLainnya"]['name']);
                        //if (move_uploaded_file($_FILES["uploadFileLainnya"]['tmp_name'], $uploadfile)) {
                        if(ssh2_scp_send($connection, $_FILES["uploadFileLainnya"]['tmp_name'], $uploadfile, 0644)){
                            $oCuti->mysqli->autocommit(FALSE);
                            $sqlInsert = "insert into berkas (id_pegawai,id_kat,nm_berkas,tgl_upload,created_by,created_date,ket_berkas) ".
                                "values (".$_POST['idp_pemohon'].", 54,'Lampiran Cuti Lainnya', DATE(NOW()), '".$_POST['idpApprover']."', NOW(), '')";
                            if ($oCuti->mysqli->query($sqlInsert) === FALSE){
                                $oCuti->mysqli->rollback();
                                $qryBerkas2 = 0;
                                $upBerkas2 = 1;
                            }else{
                                $idberkas = $oCuti->mysqli->insert_id;
                                $sqlInsert = "insert into isi_berkas (id_berkas, ket) values ($idberkas, 'Lampiran Cuti Lainnya')";
                                if ($oCuti->mysqli->query($sqlInsert) === FALSE) {
                                    $oCuti->mysqli->rollback();
                                    $qryBerkas2 = 0;
                                    $upBerkas2 = 1;
                                }else{
                                    $idisi = $oCuti->mysqli->insert_id;
                                    $nf=$_POST['nip']."-".$idberkas."-".$idisi.".pdf";
                                    $sqlUpdate = "update isi_berkas set file_name='$nf' where id_isi_berkas=$idisi";
                                    if ($oCuti->mysqli->query($sqlUpdate) === FALSE) {
                                        $oCuti->mysqli->rollback();
                                        $qryBerkas2 = 0;
                                        $upBerkas2 = 1;
                                    }else{
                                        $sqlUpdate = "update cuti_master set id_berkas_lampiran = $idberkas where id_cuti_master=".$_POST['idcm'];
                                        if ($oCuti->mysqli->query($sqlUpdate) === FALSE) {
                                            $oCuti->mysqli->rollback();
                                            $qryBerkas2 = 0;
                                            $upBerkas2 = 1;
                                        }else{
                                            $oCuti->mysqli->commit();
                                            //rename($uploadfile,"berkas/".$nf);
                                            ssh2_sftp_rename($sftp, $uploadfile,$uploaddir.$nf);
                                            $qryBerkas2 = 1;
                                            $upBerkas2 = 1;
                                        }
                                    }
                                }
                            }
                        }else{
                            $qryBerkas2 = 0;
                            $upBerkas2 = 0;
                        }
                    } else {
                        $qryBerkas2 = 0;
                        $upBerkas2 = 0;
                    }
                }else{
                    $qryBerkas2 = 0;
                    $upBerkas2 = 0;
                }
            }else{
                $qryBerkas2 = 0;
                $upBerkas2 = 0;
            }

            $oCuti->mysqli->autocommit(FALSE);
            if ($upBerkas == 1 and $upBerkas2 == 1){
                if ($qryBerkas == 1 and $qryBerkas2 == 1){
                    $update = $oCuti->kirimDataCuti($data);
                    if($update==1){
                        echo 5; //Pengubahan status data cuti tersimpan
                    }else{
                        echo 4; //Pengubahan status data cuti tidak tersimpan
                    }
                }else{
                    echo 7; //Terdapat data yang tidak tersimpan atau ada persyaratan yang tidak terupload.
                }
            }else{
                echo 6; //Lengkapi dahulu berkas persyaratan
            }
        }
        break;
}

?>
