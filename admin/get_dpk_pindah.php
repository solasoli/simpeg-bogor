<?php
    require "koncil.php";
    $idpeg = $_POST['id_pegawai'];
    $tipe = $_POST['txtSelectedAktif'];
    if($tipe=='Dipekerjakan') {
        $sql = "SELECT a.*, i.instansi from
                (SELECT d.id_instansi, DATE_FORMAT(d.tgl_dpk, '%d-%m-%Y') AS tgl_dpk
                 FROM dpk d WHERE d.id_pegawai = $idpeg AND d.id =
                (SELECT MAX(id) AS id FROM dpk d2 WHERE d2.id_pegawai = $idpeg)) a, instansi i
                WHERE a.id_instansi = i.id";
    }elseif($tipe=='Pindah Ke Instansi Lain'){
        $sql = "SELECT a.*, i.instansi from
                (SELECT d.id_instansi, DATE_FORMAT(d.tgl_pindah, '%d-%m-%Y') AS tgl_dpk
                FROM pindah_instansi d WHERE d.id_pegawai = $idpeg AND d.id =
                (SELECT MAX(id) AS id FROM pindah_instansi d2 WHERE d2.id_pegawai = $idpeg)) a, instansi i
                WHERE a.id_instansi = i.id";
    }
    $qreUnit = mysql_query($sql);
    $reUnit = mysql_fetch_array($qreUnit);
    $json = json_encode($reUnit);
    echo "[".$json."]";
?>