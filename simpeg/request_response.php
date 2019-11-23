<?php
define ('APP_DIR',str_replace("\\","/",getcwd()));
define ('SYSTEM_DIR',APP_DIR.'/');

$filter = $_GET['filter'];
switch ($filter){
    case 'get_delete_msg_uploadfile':
        include (APP_DIR.'/class/cls_berkas.php');
        $oBerkas = new Berkas();
        switch($_GET['jenisVerif']){
            case 'SK':
                $oData = $oBerkas->view_berkas_sk_pegawai($_GET['idPegawainya'], $_GET['idAwalVerif']);
                if ($oData->num_rows > 0) {
                    while ($oto = $oData->fetch_array(MYSQLI_NUM)) {
                        $jmlBerkas = $oto[13];
                        $listfile = explode(",",$oto[12]);
                        foreach ($listfile as $s) {
                            if(file_exists(str_replace("\\","/",getcwd()).'/Berkas/'.trim($s))){
                                $file .= trim($s).', ';
                            }else{
                                $jmlBerkas = $jmlBerkas - 1;
                            }
                        }
                        $file = substr($file, 0, strlen($file) - 2);
                    }
                } else {
                    $jmlBerkas = 0;
                }
                break;
            case 'Ijazah':
                $oData = $oBerkas->view_berkas_pendidikan_pegawai($_GET['idPegawainya'], $_GET['idAwalVerif']);
                if ($oData->num_rows > 0) {
                    while ($oto = $oData->fetch_array(MYSQLI_NUM)) {
                        $jmlBerkas = $oto[9];
                        $listfile = explode(",",$oto[8]);
                        foreach ($listfile as $s) {
                            if(file_exists(str_replace("\\","/",getcwd()).'/Berkas/'.trim($s))){
                                $file .= trim($s).', ';
                            }else{
                                $jmlBerkas = $jmlBerkas - 1;
                            }
                        }
                        $file = substr($file, 0, strlen($file) - 2);
                    }
                } else {
                    $jmlBerkas = 0;
                }
                break;
            case 'Pendukung':
                $oData = $oBerkas->view_berkas_pendukung_pegawai($_GET['idPegawainya'], $_GET['idAwalVerif']);
                if ($oData->num_rows > 0) {
                    while ($oto = $oData->fetch_array(MYSQLI_NUM)) {
                        $jmlBerkas = $oto[6];
                        $listfile = explode(",",$oto[5]);
                        foreach ($listfile as $s) {
                            if(file_exists(str_replace("\\","/",getcwd()).'/Berkas/'.trim($s))){
                                $file .= trim($s).', ';
                            }else{
                                $jmlBerkas = $jmlBerkas - 1;
                            }
                        }
                        $file = substr($file, 0, strlen($file) - 2);
                    }
                } else {
                    $jmlBerkas = 0;
                }
                break;
            case 'Jabatan':
                $oData = $oBerkas->view_berkas_jabatan_pegawai($_GET['idPegawainya'], $_GET['idAwalVerif']);
                if ($oData->num_rows > 0) {
                    while ($oto = $oData->fetch_array(MYSQLI_NUM)) {
                        $jmlBerkas = $oto[14];
                        $listfile = explode(",",$oto[13]);
                        foreach ($listfile as $s) {
                            if(file_exists(str_replace("\\","/",getcwd()).'/Berkas/'.trim($s))){
                                $file .= trim($s).', ';
                            }else{
                                $jmlBerkas = $jmlBerkas - 1;
                            }
                        }
                        $file = substr($file, 0, strlen($file) - 2);
                    }
                } else {
                    $jmlBerkas = 0;
                }
                break;
        }

        echo "{\"jmlberkas_skrg\":".$jmlBerkas.",\"idBerkasnya\":".$_GET['idBerkasnya'].",\"idAwalVerif\":".$_GET['idAwalVerif'].",\"jenisVerif\":\"".$_GET['jenisVerif']."\",\"filenya\":\"".$file."\"}";
        break;
}

?>