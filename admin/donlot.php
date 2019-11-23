<?php
include("koncil.php");
extract($_GET);

	$qb=mysqli_query($con,"select file_name from isi_berkas where id_berkas=$idb");
    $qsk=mysqli_query($con,"select id_kategori_sk,gol,nip_baru from sk inner join pegawai on pegawai.id_pegawai=sk.id_pegawai where id_berkas=$idb");
    $qc=mysqli_query($con,"select created_date from berkas where id_berkas=$idb");
    $cek=mysqli_fetch_array($qc);
    $sk=mysqli_fetch_array($qsk);
    $alay=mysqli_fetch_array($qb);
	$do=strstr($alay[0], 'Berkas');
	$asli=basename($do);
	$nf=basename($alay[0]);
	//print_r($sk);
	$pecah = explode("/", $sk[1]);

	if($pecah[0]=='I')
	$gol=1;
	else if($pecah[0]=='II')
	$gol=2;
	else if($pecah[0]=='III')
	$gol=3;
	else if($pecah[0]=='IV')
	$gol=4;

	if($pecah[1]=='a')
	$ongan=1;
	else if($pecah[1]=='b')
	$ongan=2;
	else if($pecah[1]=='c')
	$ongan=3;
	else if($pecah[1]=='d')
	$ongan=4;


	if($sk[0]==5) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/pdf');
        header("Content-Disposition: attachment; filename=SK_KP_" . $gol . $ongan . "_" . trim($sk[2]) . ".pdf");
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
    }else if($sk[0]==6) {
        header('Content-Type: application/pdf');
        header("Content-Disposition: attachment; filename=SK_CPNS_" . $sk[2] . ".pdf");
    }else if($sk[0]==7) {
        header('Content-Type: application/pdf');
        header("Content-Disposition: attachment; filename=SK_PNS_" . $sk[2] . ".pdf");
    }

	$uploaddir = '/var/www/html/simpeg/berkas/';
    $connection = ssh2_connect('103.14.229.15');
    ssh2_auth_password($connection, 'rommonz', 'mony3Tmony3T');
    $sftp = ssh2_sftp($connection);
    echo file_get_contents('ssh2.sftp://' . $sftp . '/var/www/html/simpeg/berkas/'.$nf);

    //echo file_get_contents("https://arsipsimpeg.kotabogor.go.id/simpeg/berkas/$nf");


