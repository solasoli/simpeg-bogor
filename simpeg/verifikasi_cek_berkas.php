<?php
    include 'class/cls_berkas.php';
    $oBerkas = new Berkas();
    $idb = $_GET['idberkas'];
    $db = Database::getInstance();
    $mysqli = $db->getConnection();
    $oData = $oBerkas->cek_berkas($idb);
    if ($oData->num_rows > 0) {
        while ($oto = $oData->fetch_array(MYSQLI_NUM)) {
            $asli = basename($oto[4]);
            if(file_exists(str_replace("\\","/",getcwd()).'/Berkas/'.trim($asli))){
                $ext[] = explode(".",$asli);
                if($ext[0][1] == 'jpg'){
                    echo("<img src=./Berkas/$asli  height=100% />");
                }else{
                    echo "<a href='./Berkas/$asli'>Download</a>";
                    $link = "<script>window.open('./Berkas/$asli','_blank')</script>";
                    echo $link;
                }
                unset($ext);
            }
        }
    }
?>


