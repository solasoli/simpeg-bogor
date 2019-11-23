<link rel="stylesheet" type="text/css" href="tcal.css"/>
<script type="text/javascript" src="jquery.js"></script>
<script type="text/javascript" src="tcal.js"></script>
<link rel="stylesheet" href="css/jquery-ui.css">
<script type="text/javascript" src="jquery.js"></script>
<script type="text/javascript" src="jquery-ui.js"></script>
<link href="css/style.css" rel="stylesheet" type="text/css"/>
<script src="SpryAssets/SpryTabbedPanels.js" type="text/javascript"></script>
<link href="SpryAssets/SpryTabbedPanels.css" rel="stylesheet" type="text/css"/>

<script>
    function ganti_jenis_diklat(jenis) {

        if (jenis == '2') {
            s = "<select name='nama_diklat' id='nama_diklat' style=\"width: 150px;\" >";
            s += "	<option value='-'>- PILIH - </option> ";
            s += "		<option value='Diklat Prajabatan Gol I'>Diklat Prajabatan Gol I</option> ";
            s += "		<option value='Diklat Prajabatan Gol II'>Diklat Prajabatan Gol II</option>";
            s += "		<option value='Diklat Prajabatan Gol III'>Diklat Prajabatan Gol III</option> ";
            s += "		<option value='Diklat Kepemimpinan Tk.II'>Diklat Kepemimpinan Tk.II</option> ";
            s += "		<option value='Diklat Kepemimpinan Tk.III'>Diklat Kepemimpinan Tk.III</option> ";
            s += "		<option value='Diklat Kepemimpinan Tk.IV'>Diklat Kepemimpinan Tk.IV</option>";
            s += "		<option value='Diklat Kepemimpinan Pemdagri'>Diklat Kepemimpinan Pemdagri</option>";
            s += "		<option value='Diklat Pelatihan Dasar'>Diklat Pelatihan Dasar</option>";
            s += "		<option value='Pelatihan Kepemimpinan Nasional Tk.II'>Pelatihan Kepemimpinan Nasional Tk.II</option>";
            s += "		<option value='Pelatihan Kepemimpinan Administrator Tk.III'>Pelatihan Kepemimpinan Administrator Tk.III</option>";
            s += "		<option value='Pelatihan Kepemimpinan Pengawas Tk.IV'>Pelatihan Kepemimpinan Pengawas Tk.IV</option></select>";

        } else
            s = "<input type='text' name='nama_diklat' value=''>";

        document.getElementById('dklt').innerHTML = s;
    }
</script>
<?php

include("koncil.php");
include('library/format.php');
include 'pegawai.php';

$obj_pegawai = new Pegawai();
$format = new Format;


extract($_POST);
extract($_GET);

//echo "jsk ..".$jsk;

if (isset($id)) {

    $pegawai = $obj_pegawai->get_obj($id);
}


/* ambil pegawai */
$q = mysqli_query($con,"select * from pegawai where id_pegawai=$id");
$ata = mysqli_fetch_array($q);


////////// hapus sk
if (isset($do) && $do == 'hapus_sk') {
    if (mysqli_query($con,"delete from sk where id_sk =$idsk ")) {
        echo "berhasil menghapus SK dan RMK";
    } else {
        echo "gagal hapus SK";
    }
}
//// end hapus sk

//insert nik
if($nik!=NULL and $nik!="" and $nik!=" ")
{


mysqli_query($con,"update pegawai set no_ktp='$nik' where id_pegawai=$id");
			  }


//hapus berkas
if (isset($delete) and $delete > 0) {

    $qha = mysqli_query($con,"select file_name from isi_berkas where id_berkas=$delete");
    while ($hata = mysqli_fetch_array($qha)) {
        $nf = basename($hata[0]);
        //unlink("../simpeg/berkas/$nf");
        error_reporting(E_ALL);
        ssh2_sftp_unlink($sftp, $uploaddir.$nf);
    }
    mysqli_query($con,"delete from berkas where id_berkas=$delete");
    mysqli_query($con,"delete from isi_berkas where id_berkas=$delete");
}
if ($ha == 1) {

    mysqli_query($con,"delete from pegawai where id_pegawai=$id");
    mysqli_query($con,"delete from pendidikan where id_pegawai=$id");
    mysqli_query($con,"delete from sk where id_pegawai=$id");
    mysqli_query($con,"delete from riwayat_mutasi_kerja where id_pegawai=$id");
    mysqli_query($con,"delete from anak where id_pegawai=$id");
    echo("<div align=center> data pegawai sudah dihapus!</div>");
}
if ($id2 != NULL) {
    $skr = date("d-m-Y H:i:s");
    $t0 = substr($tglwin, 0, 2);
    $b0 = substr($tglwin, 3, 2);
    $th0 = substr($tglwin, 6, 4);

    $tx = substr($tgl, 0, 2);
    $bx = substr($tgl, 3, 2);
    $thx = substr($tgl, 6, 4);


    // Check if tgl lahir istri is not defined
    if ($th0 && $b0 && $t0)
        $tgl_lhr_istri = "$th0-$b0-$t0";
    else
        $tgl_lhr_istri = '1900-01-01';


    $t_menikah = substr($tgl_menikah, 0, 2);
    $b_menikah = substr($tgl_menikah, 3, 2);
    $th_menikah = substr($tgl_menikah, 6, 4);

    if (strlen($win) > 1) {
        $qcek = mysqli_query($con,"select count(*) from keluarga where id_status=9 and id_pegawai=$id2");
        $cek = mysqli_fetch_array($qcek);
        if ($cek[0] == 0) {
            $strQ = "insert into keluarga (id_pegawai,id_status,nama,tempat_lahir,tgl_lahir,tgl_menikah,status_konfirmasi,pekerjaan,dapat_tunjangan,no_karsus)
                      values ($id2,9,'$win','$twin','$tgl_lhr_istri','$th_menikah-$b_menikah-$t_menikah',0,'$pekerjaan_istri','$tun_istri','$nokarisu')";
            //echo $strQ;
            mysqli_query($con,$strQ);
        }
    }

    if(isset($idwin)){
        $sql = "update pegawai set status_kawin = '$kawin', no_karisu = '$nokarisu' where id_pegawai = $id";
        mysqli_query($con,$sql);
        $tglwin = explode('-', $tglwin);
        $tglwin = $tglwin[2] . '-' . $tglwin[1] . '-' . $tglwin[0];
        $tgl_menikah = explode('-', $tgl_menikah);
        $tgl_menikah = $tgl_menikah[2] . '-' . $tgl_menikah[1] . '-' . $tgl_menikah[0];
        $sql2 = "update keluarga set nama = '$win', tempat_lahir = '$twin', tgl_lahir = '$tglwin', tgl_menikah = '$tgl_menikah',
                dapat_tunjangan = $tun_istri, pekerjaan = '$pekerjaan_istri', no_karsus = '$nokarisu'
                where id_keluarga = $idwin";
        mysqli_query($con,$sql2);
    }

    if (isset($anyar) and strlen($anyar) > 0)
        $adapass = " password='$anyar' ,";
    else
        $adapass = " ";
    if ($darah == NULL)
        $darah = '-';
    $update_pegawai = 'update pegawai set nama="' . $n . '",
			gelar_depan="' . $gelar_depan . '",
			gelar_belakang="' . $gelar_belakang . '",
			nip_lama="' . $nl . '",
			nip_baru="' . $nb . '",
			pangkat_gol="' . $gol . '",
			email="' . $email . '",
			alamat="' . $al . '",
			agama="' . $a . '",
			tempat_lahir="' . $tl . '",
			no_karpeg="' . $karpeg . '",
			NPWP="' . $npwp . '",
			pangkat_gol="' . $gol . '",
			ponsel="' . $hp . '",
			telepon="' . $telp . '",
			jenjab="' . $jenjab . '",
			kota="' . $kota . '",
			gol_darah="' . $darah . '",
			status_kawin="' . $kawin . '",
			jenis_kelamin="' . $jk . '",
			nama_istri="' . $win . '",
			tempat_lahir_istri="' . $twin . '",
			tgl_lahir_istri="' . $tgl_lhr_istri . '",
			keterangan="' . $keterangan . '",
			status_map="' . $berkas . '",
			 ' . $adapass . '
			os="' . $os . '",
			jumlah_transit="' . $jumlah_transit . '",
			tgl_lahir="' . $thx . '-' . $bx . '-' . $tx . '"';
	/*
    if (isset($tgl_menikah)) {
        $update_pegawai .= ",tgl_menikah='$th_menikah-$b_menikah-$t_menikah',
						tunjangan_istri='$tun_istri',
						pekerjaan_istri='$pekerjaan_istri'";
    }
	*/
    $update_pegawai .= 'where id_pegawai="' . $id2 . '"';

//upload arsip
    $connection = ssh2_connect('103.14.229.15');
    ssh2_auth_password($connection, 'rommonz', 'mony3Tmony3T');
    $sftp = ssh2_sftp($connection);
    $uploaddir = '/var/www/html/simpeg/berkas/';
    if (isset($arsip) and $arsip > 0) {
        $tu = date("Y-m-d");
        $tc = date("Y-m-d h:i:s");

        if ($arsip == 1) {
            $fktp = $_FILES['filektp'];
            $tmp = $_FILES['filektp']['tmp_name'];
            mysqli_query($con,"insert into berkas (id_pegawai,id_kat,tgl_upload,byk_hal,tgl_berkas,created_date,nm_berkas,ket_berkas) values ($ata[0],1,'$tu',1,'$tu','$tc','KTP','$isiktp')");
            $idarsip = mysqli_insert_id($con);
            mysqli_query($con,"insert into isi_berkas (id_berkas,hal_ke,file_name) values ($idarsip,1,'')");
            $idisi = mysqli_insert_id($con);
            $namafile = $ata['nip_baru']."-".$idarsip."-".$idisi.".pdf";
            mysqli_query($con,"update isi_berkas set file_name='$namafile' where id_isi_berkas=$idisi");
            //move_uploaded_file($tmp, "../simpeg/berkas/$namafile");
            ssh2_scp_send($connection, $tmp, $uploaddir.$namafile, 0644);

        }else if ($arsip == 11) { // Karis/Karsu
            if(isset($inpKarisu)){
                if($inpKarisu=='insKarisBaru'){
                    if($nmkarisu!='' and $tmptlhr_ris!='' and $tgllahir_ris!='' and $tglnikah_ris!='' and $tunjangan!='' and $pekerjaan!='' and $nokarisu!=''){
                        if($ata['jenis_kelamin']==1) {
                            $stsjk = 2;
                        }else{
                            $stsjk = 1;
                        }
                        $tgllahir_ris = explode('-', $tgllahir_ris);
                        $tgllahir_ris = $tgllahir_ris[2] . '-' . $tgllahir_ris[1] . '-' . $tgllahir_ris[0];

                        $tglnikah_ris = explode('-', $tglnikah_ris);
                        $tglnikah_ris = $tglnikah_ris[2] . '-' . $tglnikah_ris[1] . '-' . $tglnikah_ris[0];

                        $sql = "insert into keluarga(id_pegawai,id_status,nama,tempat_lahir,tgl_lahir,tgl_menikah,akte_menikah,
                        tgl_meninggal,akte_meninggal,tgl_cerai,akte_cerai,no_karsus,pekerjaan,jk,dapat_tunjangan,keterangan,
                        timestamp,status_konfirmasi,tgl_perubahan,keterangan_penolakan) values ($id,9,'$nmkarisu','$tmptlhr_ris',
                        '$tgllahir_ris','$tglnikah_ris','',NULL,'',NULL,'','$nokarisu','$pekerjaan',$stsjk,'$tunjangan','',NULL,0,NULL,NULL);";
                        mysqli_query($con,$sql);
                        $idkeluarga = mysqli_insert_id($con);
                        $sql = "update pegawai set no_karisu = '$nokarisu' where id_pegawai = $id";
                        mysqli_query($con,$sql);
                    }
                }else if($inpKarisu=='updNoKarsus'){
                    if($nokarisu!=''){
                        $sql = "select id_keluarga from keluarga where id_pegawai=$id and id_status = 9";
                        $idkeluarga = mysqli_fetch_array(mysqli_query($con,$sql));
                        $idkeluarga = $idkeluarga[0];
                        if($idkeluarga > 0){
                            $sql = "update keluarga set no_karsus = '$nokarisu' where id_keluarga = $idkeluarga;";
                            mysqli_query($con,$sql);
                            $sql = "update pegawai set no_karisu = '$nokarisu' where id_pegawai = $id";
                            mysqli_query($con,$sql);
                        }
                    }
                }

                $fkarisu = $_FILES["fkarisu"];
                if ($fkarisu['size'] > 0) {
                    $sql = "insert into berkas (id_pegawai,id_kat,tgl_upload,byk_hal,tgl_berkas,created_date,nm_berkas,ket_berkas) values ($ata[0],11,DATE(NOW()),1,DATE(NOW()),DATE(NOW()),'Karis/Karsu','$nokarisu')";
                    mysqli_query($con,$sql);

                    if ($fkarisu['type'] == 'image/jpeg' or $fkarisu['type'] == 'image/jpg' or $fkarisu['type'] == 'image/png') {
                        $tipe = "jpg";
                    } else {
                        $tipe = "pdf";
                    }
                    $idarsip = mysqli_insert_id($con);
                    mysqli_query($con,"update keluarga set idberkas_karisu=$idarsip, no_karsus='$nokarisu' where id_keluarga=$idkeluarga");
                    mysqli_query($con,"insert into isi_berkas (id_berkas,hal_ke,file_name) values ($idarsip,1,'')");
                    $idisi = mysqli_insert_id($con);
                    $namafile = "$ata[nip_baru]-$idarsip-$idisi.$tipe";
                    mysqli_query($con,"update isi_berkas set file_name='$namafile' where id_isi_berkas=$idisi");
                    ssh2_scp_send($connection, $fkarisu['tmp_name'], $uploaddir.$namafile, 0644);
                    //move_uploaded_file($fkarisu['tmp_name'], "../simpeg/berkas/$namafile");
                    $sql = "update pegawai set no_karisu = '$nokarisu' where id_pegawai = $ata[0]";
                    mysqli_query($con,$sql);
                }
            }

        } elseif ($arsip == 14) {
            $fktp = $_FILES['filekk'];
            $tmp = $_FILES['filekk']['tmp_name'];
            mysqli_query($con,"insert into berkas (id_pegawai,id_kat,tgl_upload,byk_hal,tgl_berkas,created_date,nm_berkas,ket_berkas) values ($ata[0],14,'$tu',1,'$tu','$tc','KK','$isikk')");
            $idarsip = mysqli_insert_id($con);
            mysqli_query($con,"insert into isi_berkas (id_berkas,hal_ke,file_name) values ($idarsip,1,'')");
            $idisi = mysqli_insert_id($con);
            $namafile = "$ata[nip_baru]-$idarsip-$idisi.pdf";
            mysqli_query($con,"update isi_berkas set file_name='$namafile' where id_isi_berkas=$idisi");
            //move_uploaded_file($tmp, "../simpeg/berkas/$namafile");
            ssh2_scp_send($connection, $tmp, $uploaddir.$namafile, 0644);

        }

		elseif ($arsip == 39) {
            $fktp = $_FILES['pupns'];
            $tmp = $_FILES['pupns']['tmp_name'];
            mysqli_query($con,"insert into berkas (id_pegawai,id_kat,tgl_upload,byk_hal,tgl_berkas,created_date,nm_berkas) values ($ata[0],39,'$tu',1,'$tu','$tc','pupns')");
            $idarsip = mysqli_insert_id($con);
            mysqli_query($con,"insert into isi_berkas (id_berkas,hal_ke,file_name) values ($idarsip,1,'')");
            $idisi = mysqli_insert_id($con);
            $namafile = "$ata[nip_baru]-$idarsip-$idisi.pdf";
            mysqli_query($con,"update isi_berkas set file_name='$namafile' where id_isi_berkas=$idisi");
            //move_uploaded_file($tmp, "../simpeg/berkas/$namafile");
            ssh2_scp_send($connection, $tmp, $uploaddir.$namafile, 0644);

        }


		elseif ($arsip == 15) {
            $fktp = $_FILES['filenikah'];
            $tmp = $_FILES['filenikah']['tmp_name'];
            mysqli_query($con,"insert into berkas (id_pegawai,id_kat,tgl_upload,byk_hal,tgl_berkas,created_date,nm_berkas,ket_berkas) values ($ata[0],15,'$tu',1,'$tu','$tc','Buku Nikah','$namaisu')");
            $idarsip = mysqli_insert_id($con);
            mysqli_query($con,"insert into isi_berkas (id_berkas,hal_ke,file_name) values ($idarsip,1,'')");
            $idisi = mysqli_insert_id($con);
            $namafile = "$ata[nip_baru]-$idarsip-$idisi.pdf";
            mysqli_query($con,"update isi_berkas set file_name='$namafile' where id_isi_berkas=$idisi");
            //move_uploaded_file($tmp, "../simpeg/berkas/$namafile");
            ssh2_scp_send($connection, $tmp, $uploaddir.$namafile, 0644);

        } elseif ($arsip == 16) {
            $fktp = $_FILES['fileakta'];
            $tmp = $_FILES['fileakta']['tmp_name'];
            mysqli_query($con,"insert into berkas (id_pegawai,id_kat,tgl_upload,byk_hal,tgl_berkas,created_date,nm_berkas,ket_berkas) values ($ata[0],16,'$tu',1,'$tu','$tc','Akta Kelahiran','$tglahir')");
            $idarsip = mysqli_insert_id($con);
            mysqli_query($con,"insert into isi_berkas (id_berkas,hal_ke,file_name) values ($idarsip,1,'')");
            $idisi = mysqli_insert_id($con);
            $namafile = "$ata[nip_baru]-$idarsip-$idisi.pdf";
            mysqli_query($con,"update isi_berkas set file_name='$namafile' where id_isi_berkas=$idisi");
            //move_uploaded_file($tmp, "../simpeg/berkas/$namafile");
            ssh2_scp_send($connection, $tmp, $uploaddir.$namafile, 0644);

        } elseif ($arsip == 13) {
            $fktp = $_FILES['filenpwp'];
            $tmp = $_FILES['filenpwp']['tmp_name'];
            mysqli_query($con,"insert into berkas (id_pegawai,id_kat,tgl_upload,byk_hal,tgl_berkas,created_date,nm_berkas,ket_berkas) values ($ata[0],13,'$tu',1,'$tu','$tc','NPWP','$isinpwp')");
            $idarsip = mysqli_insert_id($con);
            mysqli_query($con,"insert into isi_berkas (id_berkas,hal_ke,file_name) values ($idarsip,1,'')");
            $idisi = mysqli_insert_id($con);
            mysqli_query($con,"update pegawai set npwp='$isinpwp' where id_pegawai=$ata[0]");
            $namafile = "$ata[nip_baru]-$idarsip-$idisi.pdf";
            mysqli_query($con,"update isi_berkas set file_name='$namafile' where id_isi_berkas=$idisi");
            //move_uploaded_file($tmp, "../simpeg/berkas/$namafile");
            ssh2_scp_send($connection, $tmp, $uploaddir.$namafile, 0644);

        } else if ($arsip == 2) {
            $tmp = $_FILES['filesk']['tmp_name'];

            $info = pathinfo($tmp);

            if ($_FILES['filesk']['type'] == 'image/jpeg' or $_FILES['filesk']['type'] == 'image/jpg') {
                $tipe = "jpg";
            } else {
                $tipe = "pdf";
            }

            $t1 = substr($tglsk, 0, 2);
            $b1 = substr($tglsk, 3, 2);
            $th1 = substr($tglsk, 6, 4);
            $t2 = substr($tmtsk, 0, 2);
            $b2 = substr($tmtsk, 3, 2);
            $th2 = substr($tmtsk, 6, 4);

            if ($thn_mkg == "") {
                $thn_mkg = 0;
            }
            if ($bln_mkg == "") {
                $bln_mkg = 0;
            }

            if ($jsk == 1) {
                $sqlCek = "SELECT (CASE WHEN MAX(tmt) IS NULL THEN
			  (SELECT MAX(tmt) FROM sk WHERE id_pegawai = " . $ata[0] . " AND id_kategori_sk = 5)
			  ELSE MAX(tmt) END) AS tglsk_terakhir,
			  CASE WHEN (CASE WHEN MAX(tmt) IS NULL THEN
			  (SELECT MAX(tmt) FROM sk WHERE id_pegawai = " . $ata[0] . " AND id_kategori_sk = 5)
			  ELSE MAX(tmt) END) < '" . $th2 . "-" . $b2 . "-" . $t2 . "' THEN 1 ELSE 0 END AS cek
			  FROM sk WHERE id_pegawai = " . $ata[0] . " AND id_kategori_sk = 1";
                $qryCek = mysqli_query($con,$sqlCek);
                while ($row = mysqli_fetch_array($qryCek)) {
                    $arrCekCur[] = $row;
                }
                $hasilCekTMT = $arrCekCur[0]['cek'];
            }

            $ketera = $gol_sk . ',' . $thn_mkg . ',' . $bln_mkg;
            $query_insert_sk = ("insert into sk (id_pegawai,id_kategori_sk,no_sk,tgl_sk,pemberi_sk,pengesah_sk,keterangan,tmt, gol, mk_tahun, mk_bulan)
		    values ($ata[0],$jsk,'$nosk','$th1-$b1-$t1','$berisk','$sahsk','$ketera','$th2-$b2-$t2','$gol_sk','$thn_mkg','$bln_mkg')");

            mysqli_query($con,$query_insert_sk);
            $idsk = mysqli_insert_id($con);

            if ($_FILES["filesk"]["error"] == 0) {
                mysqli_query($con,"insert into berkas (id_pegawai,id_kat,tgl_upload,byk_hal,tgl_berkas,created_date,nm_berkas) values ($ata[0],2,'$tu',1,'$tu','$tc','SK')");
                $idarsip = mysqli_insert_id($con);
                mysqli_query($con,"insert into isi_berkas (id_berkas,hal_ke,file_name) values ($idarsip,1,'')");
                $idisi = mysqli_insert_id($con);
                $namafile = $ata['nip_baru'] . "-" . $idarsip . "-" . $idisi . "." . $info['extension'];
                $namafile = $ata['nip_baru'] . "-" . $idarsip . "-" . $idisi . "." . $tipe;

                mysqli_query($con,"update isi_berkas set file_name='$namafile' where id_isi_berkas=$idisi");
                mysqli_query($con,"update sk set id_berkas=$idarsip where id_sk=$idsk");
                //move_uploaded_file($tmp, "../simpeg/berkas/$namafile");
                ssh2_scp_send($connection, $tmp, $uploaddir.$namafile, 0644);
            }

            if ($jsk == 1 or $jsk == 55 ) {
                mysqli_query($con,"insert into riwayat_mutasi_kerja
                (id_pegawai,id_sk,id_unit_kerja,id_j,jabatan,keterangan,pangkat_gol,jenjab,id_detail,eselonering,id_j_bos,jabatan_atasan,nama_atasan)
        values ($ata[0],$idsk,$idskpd,0,'-','-','','',0,'',0,'-','-')");
                $idrmk = mysqli_insert_id($con);
                $qryCurrUnit = mysqli_query($con,"select count(*) as jumlah from current_lokasi_kerja where id_pegawai = $ata[0]");
                $array_rec = array();
                while ($row = mysqli_fetch_array($qryCurrUnit)) {
                    $array_rec[] = $row;
                }
                if ($array_rec[0]['jumlah'] == 0) {
                    mysqli_query($con,"insert into current_lokasi_kerja (id_pegawai, id_unit_kerja)
            values ($ata[0], $idskpd)");
                    $idcurlokasi = mysqli_insert_id($con);
                } else {
                    if($hasilCekTMT==1) {
                        mysqli_query($con,"update current_lokasi_kerja set id_unit_kerja = $idskpd where id_pegawai = $ata[0]");
                        echo "berhasil update clk";
                    }
                }
            } else if($jsk == 23 || $jsk == 32){
              $sqlJafung = "insert into jafung_pegawai
                      (id_pegawai, id_jafung, id_sk, id_unit_kerja, angka_kredit, pangkat_gol, jabatan)
                      values($ata[0], $id_jafung, $idsk, $idskpd, $nilai_ak, '$gol_sk', '$nama_jafung')";
            mysqli_query($con,$sqlJafung);
          }else if($jsk == 52){
            //print_r($_POST);
              $sqlJfu = "insert into jfu_pegawai
                      (id_pegawai, id_jfu, kode_jabatan, id_sk, id_unit_kerja, pangkat_gol, jabatan, tmt)
                      values($ata[0], $id_jfu, '$kode_jabatan' , $idsk, $idskpd, '$gol_sk', '$nama_jfu', '".$format->date_Ymd($tmtsk)."')";
            mysqli_query($con,$sqlJfu);
          }
        } else if ($arsip == 3) {
            $tmp = $_FILES['fileij']['tmp_name'];
            if ($tp == 1)
                $tip = "S3";
            elseif ($tp == 2)
                $tip = "S2";
            elseif ($tp == 3)
                $tip = "S1";
            elseif ($tp == 4)
                $tip = "D3";
            elseif ($tp == 5)
                $tip = "D2";
            elseif ($tp == 6)
                $tip = "D1";
            elseif ($tp == 7)
                $tip = "SMU/SMK/MA/SEDERAJAT";
            elseif ($tp == 8)
                $tip = "SMP/SEDERAJAT";
            elseif ($tp == 9)
                $tip = "SD/SEDERAJAT";

            $qin = mysqli_query($con,"select count(*) from institusi_pendidikan where institusi like '$lp%'");
            $cekin = mysqli_fetch_array($qin);
            if ($cekin[0] == 1) {
                $qins = mysqli_query($con,"select id from institusi_pendidikan where institusi like '$lp%'");
                $institusi = mysqli_fetch_array($qins);
                $ins = $institusi[0];
            } else
                $ins = 0;

            if ($_FILES['fileij']['type'] == 'image/jpeg' or $_FILES['fija']['type'] == 'image/jpg') {
                $tipe = "jpg";
            } else {
                $tipe = "pdf";
            }

            mysqli_query($con,"insert into pendidikan (id_pegawai,lembaga_pendidikan,tingkat_pendidikan,jurusan_pendidikan,tahun_lulus,level_p,id_bidang,id_institusi) values ($ata[0],'$lp','$tip','$jur',$tahun,$tp,$bp,$ins) ");
            $idsk = mysqli_insert_id($con);
            mysqli_query($con,"insert into berkas (id_pegawai,id_kat,tgl_upload,byk_hal,tgl_berkas,created_date,nm_berkas) values ($ata[0],3,'$tu',1,'$tu','$tc','Ijazah')");
            $idarsip = mysqli_insert_id($con);
            mysqli_query($con,"insert into isi_berkas (id_berkas,hal_ke,file_name) values ($idarsip,1,'')");
            $idisi = mysqli_insert_id($con);

            $namafile = "$ata[nip_baru]-$idarsip-$idisi.$tipe";
            mysqli_query($con,"update isi_berkas set file_name='$namafile' where id_isi_berkas=$idisi");
            mysqli_query($con,"update pendidikan set id_berkas=$idarsip where id_pendidikan=$idsk");
            //move_uploaded_file($tmp, "../simpeg/berkas/$namafile");
            ssh2_scp_send($connection, $tmp, $uploaddir.$namafile, 0644);
        } else if ($arsip == 10) {
            $tmp = $_FILES['fkarpeg']['tmp_name'];
            if ($_FILES['fkarpeg']['type'] == 'image/jpeg' or $_FILES['fkarpeg']['type'] == 'image/jpg') {
                $tipe = "jpg";
            } else {
                $tipe = "pdf";
            }

            mysqli_query($con,"insert into berkas (id_pegawai,id_kat,tgl_upload,byk_hal,tgl_berkas,created_date,nm_berkas) values ($ata[0],10,'$tu',1,'$tu','$tc','Kartu Pegawai')");
            $idarsip = mysqli_insert_id($con);
            mysqli_query($con,"update pegawai set no_karpeg='$karpeg' where id_pegawai=$ata[0]");
            mysqli_query($con,"insert into isi_berkas (id_berkas,hal_ke,file_name) values ($idarsip,1,'')");
            $idisi = mysqli_insert_id($con);
            $namafile = "$ata[nip_baru]-$idarsip-$idisi." . $tipe;
            mysqli_query($con,"update isi_berkas set file_name='$namafile' where id_isi_berkas=$idisi");
            //move_uploaded_file($tmp, "../simpeg/berkas/$namafile");
            ssh2_scp_send($connection, $tmp, $uploaddir.$namafile, 0644);
        }


    }

	//echo "updated<br>";

    mysqli_query($con,$update_pegawai);
    if ($jenjab == 'Fungsional') {
        mysqli_query($con,"update pegawai set jabatan ='$jafung' where id_pegawai=$id2");
    }
    if ($aktif == 'Aktif' or $aktif == 'Aktif Bekerja') {
        $t1 = substr($pensiun, 0, 2);
        $b1 = substr($pensiun, 3, 2);
        $th1 = substr($pensiun, 6, 4);
        if ($aktif == "Pindah Ke Instansi Lain")
            $flag = ",flag_pensiun=1 ";
        elseif ($aktif == "Aktif" or $aktif == "Aktif Bekerja")
            $flag = ",flag_pensiun=0 ";
        else
            $flag = " ";
        //$eksekusi = mysqli_query($con,"update pegawai set status_aktif='$aktif',tgl_pensiun_dini='$th1-$b1-$t1' $flag where id_pegawai=$id2");
		//echo "update pegawai set status_aktif='$aktif',tgl_pensiun_dini='$th1-$b1-$t1' $flag where id_pegawai=$id2";
        if($eksekusi){
			$query = "insert into log_pensiun(id_yang_pensiun,id_admin,tgl_pensiun,tgl_dipensiunkan)
			values($id2,".$_SESSION['id_pegawai'].",'$th1-$b1-$t1',curdate())";
			mysqli_query($con,$query);
		}

    } elseif ($aktif == 'Tugas Belajar')
      //  mysqli_query($con,"update pegawai set status_aktif='$aktif',id_j=NULL where id_pegawai=$id2");
    //echo $jsk;
    if ($jsk == 34) {
        mysqli_query($con,"insert into dpk (id_pegawai,id_instansi,tgl_dpk,id_sk)
                values ($ata[0], $idskpd, '$th2-$b2-$t2', $idsk)");
        //mysqli_query($con,"update pegawai set status_aktif = 'Dipekerjakan' where id_pegawai = $ata[0]");
    }

    if ($jsk == 35 or $jsk== 11) {
        mysqli_query($con,"insert into pindah_instansi (id_pegawai,id_instansi,tgl_pindah,id_sk)
                values ($ata[0], $idskpd, '$th2-$b2-$t2', $idsk)");
        //echo ("update pegawai set status_aktif = 'Pindah Ke Instansi Lain', flag_pensiun = 1 where id_pegawai = $ata[0]");
        //mysqli_query($con,"update pegawai set status_aktif = 'Pindah Ke Instansi Lain', flag_pensiun = 1 where id_pegawai = $ata[0]");
    }

    if($jsk == 26){
        //mysqli_query($con,"update pegawai set status_aktif = 'Cuti Diluar Tanggungan Negara (CLTN)' where id_pegawai = $ata[0]");
    }

    for ($g = 1; $g <= $ja; $g++) {
        $ngaran = $_POST["anak" . "$g"];
        $dmn = $_POST["la" . "$g"];
        $ta = $_POST["tg" . "$g"];
        $budak = $_POST["king" . "$g"];

        $t6 = substr($ta, 0, 2);
        $b6 = substr($ta, 3, 2);
        $th6 = substr($ta, 6, 4);
        mysqli_query($con,"update anak set nama_anak='$ngaran',tempat_lahir='$dmn',tgl_lahir='$th6-$b6-$t6' where id_pegawai=$id and id_anak=$budak");
    }

// UPDATE DIKLAT
    for ($z = 1; $z <= $total_diklat; $z++) {
        $jenis_diklat = $_POST["jenis_diklat" . "$z"];
        $tgl_diklat = explode('-', $_POST["tgl_diklat" . "$z"]);
        $tgl_diklat = $tgl_diklat[2] . '-' . $tgl_diklat[1] . '-' . $tgl_diklat[0];
        $jml_jam_diklat = $_POST["jml_jam_diklat" . "$z"];
        $nama_diklat = $_POST["nama_diklat" . "$z"];
        $penyelenggara_diklat = $_POST["penyelenggara_diklat" . "$z"];
        $no_sttpl = $_POST["no_sttpl" . "$z"];
        $id_diklat = $_POST["id_diklat" . "$z"];
        $fdiklat = $_FILES["filediklat" . "$z"];

        $tu = date("Y-m-d");
        $tc = date("Y-m-d h:i:s");

        $qUpdateDiklat = "UPDATE diklat SET
						id_jenis_diklat 			= '$jenis_diklat',
						tgl_diklat	 			= '$tgl_diklat',
						jml_jam_diklat 			= '$jml_jam_diklat',
						nama_diklat				= '$nama_diklat',
						penyelenggara_diklat	= '$penyelenggara_diklat',
						no_sttpl				= '$no_sttpl'
					 WHERE id_diklat = '$id_diklat'";

        if ($jenis_diklat == '2') {
            $kat_berkas = 17;
            $nb = 'STTPL';
        } else if ($jenis_diklat == '1' or $jenis_diklat == '3' or $jenis_diklat == '4' or $jenis_diklat == '5') {
            $kat_berkas = 6;
            $nb = 'Sertifikat';
        } else if ($jenis_diklat == '6' or $jenis_diklat == '7' or $jenis_diklat == '8') {
            $kat_berkas = 6;
            $nb = 'Sertifikat';
        }
        if ($fdiklat['size'] > 0) {
            mysqli_query($con,"insert into berkas (id_pegawai,id_kat,tgl_upload,byk_hal,tgl_berkas,created_date,nm_berkas) values ($ata[0],$kat_berkas,'$tu',1,'$tu','$tc','$nb')");

            if ($fdiklat['type'] == 'image/jpeg' or $fdiklat['type'] == 'image/jpg' or $fdiklat['type'] == 'image/png') {
                $tipe = "jpg";
            } else {
                $tipe = "pdf";
            }
            $idarsip = mysqli_insert_id($con);
            mysqli_query($con,"update diklat set id_berkas=$idarsip where id_diklat=$id_diklat");
            mysqli_query($con,"insert into isi_berkas (id_berkas,hal_ke,file_name) values ($idarsip,1,'')");
            $idisi = mysqli_insert_id($con);
            $namafile = "$ata[nip_baru]-$idarsip-$idisi.$tipe";
            mysqli_query($con,"update isi_berkas set file_name='$namafile' where id_isi_berkas=$idisi");
            //move_uploaded_file($fdiklat['tmp_name'], "../simpeg/berkas/$namafile");
            ssh2_scp_send($connection, $tmp, $uploaddir.$namafile, 0644);
        }
        mysqli_query($con,$qUpdateDiklat);
    }
// END OF UPDATE DIKLAT

//******************************update riwayat jabatan
    $sqlcountrj = "select count(*) from riwayat_kerja where id_pegawai = '$id'";
    $jum = mysqli_fetch_array(mysqli_query($con,$sqlcountrj));
//echo "jumlah=>".$jum[0];
    for ($z = 1; $z <= $jum[0]; $z++) {

        $id_riwayat_kerja = $_POST['id_riwayat_kerja' . '$z'];

        if ($_POST['id_riwayat_kerja' . '$z']) {
            echo "haloooo " . $id_riwayat_kerja;
        }

        $sqlupdaterj = "update riwayat_kerja SET
				jabatan = '" . $_POST['nama_jabatan' . $z] . "',
				unit_kerja = '" . $_POST['unit_kerja' . $z] . "',
				no_sk = '" . $_POST['no_sk' . $z] . "',
				tgl_masuk = '" . $format->date_Ymd($_POST['tahun_masuk' . $z]) . "',
				tgl_keluar = '" . $format->date_Ymd($_POST['tahun_keluar' . $z]) . "'
			WHERE id_riwayat_kerja = '" . $_POST['id_riwayat_kerja' . $z] . "'";


        if (mysqli_query($con,$sqlupdaterj)) {
            echo "";

        } else {
            echo("<div align=center>riwayat jabatan gagal diupdate! </div> ");
        }

    }


//update sk

    for ($z = 1; $z <= $jsk; $z++) {
        $id_kategori = $_POST["a" . $z];
        $nona = $_POST["nosk" . "$z"];
        $tmtna = $_POST["tmsk" . "$z"];
        $tglna = $_POST["tgsk" . "$z"];
        $sahna = $_POST["sah" . "$z"];
        $idna = $_POST["idsk" . "$z"];
        $berina = $_POST["beri" . "$z"];
//$keke=$_POST["keket"."$z"];
        $fileu = $_FILES["fupdate" . "$z"];
        $cboGol = $_POST["gol_sk" . "$z"];
        $thnMkg = $_POST["thn_mkg" . "$z"];
        $blnMkg = $_POST["bln_mkg" . "$z"];
		$catatan= @$_POST["sttpl" . "$z"];
		$jabatansk= @$_POST["dokter" . "$z"];

        if ($thnMkg == "") {
            $thnMkg = 0;
        }
        if ($blnMkg == "") {
            $blnMkg = 0;
        }

        $keke = $cboGol . ',' . $thnMkg . ',' . $blnMkg;

        $t8 = substr($tglna, 0, 2);
        $b8 = substr($tglna, 3, 2);
        $th8 = substr($tglna, 6, 4);

        $t9 = substr($tmtna, 0, 2);
        $b9 = substr($tmtna, 3, 2);
        $th9 = substr($tmtna, 6, 4);


        $query_sk = ("update sk set id_kategori_sk='$id_kategori',
	no_sk='$nona',
	tgl_sk='$th8-$b8-$t8',
	tmt='$th9-$b9-$t9',pengesah_sk='$sahna',
	pemberi_sk='$berina',
	keterangan='$keke', gol='$cboGol', mk_tahun = '$thnMkg', mk_bulan = '$blnMkg',catatan='$catatan',keterangan='$jabatansk' where id_pegawai=$id and id_sk=$idna");
	//if($z==14)
	//echo $query_sk."<br/>";
        mysqli_query($con,$query_sk);

        //echo "<pre>";
        //print_r($_FILES);
        //echo "</pre>";
        //echo "test ".$fileu['size'];exit;

        //print_r($fileu);exit;
        if ($fileu['size'] > 0 and $fileu['size'] <= 5000000) {
            if ($fileu['type'] == 'image/jpeg' or $fileu['type'] == 'image/jpg')
                $tipe = "jpg";
            else if ($fileu['type'] == 'binary/octet-stream' or $fileu['type'] == 'application/pdf')
                $tipe = "pdf";



            $tu = date("Y-m-d");
            $tc = date("Y-m-d h:i:s");


            $qisi = mysqli_query($con,"select id_berkas from sk where id_sk=$idna");
            $isi = mysqli_fetch_array($qisi);

            if ($isi[0] == 0 or $isi[0] == NULL) {
                $sql = "insert into berkas (id_pegawai,id_kat,tgl_upload,byk_hal,tgl_berkas,created_date,nm_berkas) values ($ata[0],2,'$tu',1,'$tu','$tc','SK')";
                mysqli_query($con,$sql);
                $idarsip = mysqli_insert_id($con);
                $sql = "update sk set id_berkas=$idarsip where id_sk=$idna";
                mysqli_query($con,$sql);
                $sql = "insert into isi_berkas (id_berkas,hal_ke,file_name) values ($idarsip,1,'')";
                mysqli_query($con,$sql);
                $idisi = mysqli_insert_id($con);
                $namafile = $ata['nip_baru']."-".$idarsip."-".$idisi.".".$tipe;

                ssh2_scp_send($connection, $fileu['tmp_name'], $uploaddir.$namafile, 0644);
                $sql = "update isi_berkas set file_name='$namafile' where id_isi_berkas=$idisi";
                mysqli_query($con,$sql);
                //error_reporting(E_ALL);

                //move_uploaded_file($fileu['tmp_name'], "../simpeg/berkas/$namafile");

            }

        }

    }

    for ($v = 1; $v <= $totalpen; $v++) {
        $tingpen = $_POST["tp" . "$v"];
        $lempen = $_POST["lem" . "$v"];
        $jurpen = $_POST["jur" . "$v"];
        $luspen = $_POST["lus" . "$v"];
        $idna = $_POST["pendi" . "$v"];
        $bidangnya = $_POST["bp" . "$v"];

        $qlp = mysqli_query($con,"select level_p from pendidikan where tingkat_pendidikan='$tingpen'");
        $lepel = mysqli_fetch_array($qlp);


        mysqli_query($con,"update pendidikan set lembaga_pendidikan='$lempen',tingkat_pendidikan='$tingpen',jurusan_pendidikan='$jurpen',tahun_lulus=$luspen,level_p=$lepel[0],id_bidang=$bidangnya where id_pendidikan=$idna");


    }

    $t2 = substr($tlanak, 0, 2);
    $b2 = substr($tlanak, 3, 2);
    $th2 = substr($tlanak, 6, 4);
    $t1 = substr($pensiun, 0, 2);
    $b1 = substr($pensiun, 3, 2);
    $th1 = substr($pensiun, 6, 4);

    if ($aktif == 'Mengundurkan Diri' or
        $aktif == 'Diberhentikan' or
        $aktif == 'Pensiun Dini' or
        $aktif == 'Pensiun Meninggal Dunia' or
        $aktif == 'Pensiun Reguler' or
        $aktif == 'Pindah Ke Instansi Lain'
    ) {
        //mysqli_query($con,"update pegawai set flag_pensiun=1,status_aktif='$aktif',tgl_pensiun_dini='$th1-$b1-$t1',id_j=null where id_pegawai=$id2 ");


    }
    if ($anak != '' and $ttl != '' and $tlanak != '') {
        $t3 = substr($tlanak, 0, 2);
        $b3 = substr($tlanak, 3, 2);
        $th3 = substr($tlanak, 6, 4);
        $sql = "insert into keluarga (id_pegawai,id_status,nama,tempat_lahir,tgl_lahir,status_konfirmasi) values ($id2,10,'$anak','$ttl','$th3-$b3-$t3',0)";
        mysqli_query($con,$sql);
    }

    if ($lembaga != NULL and $jurusan != NULL and $lulusan != NULL) {

        $qlem = mysqli_query($con,"select id from institusi_pendidikan where institusi like
			'$lembaga%'");
        $lem = mysqli_fetch_array($qlem);
        if (!is_numeric($lem[0]))
            $lem[0] = 0;

        if ($tingkat == "S3")
            $lp = 1;
        elseif ($tingkat == "S2")
            $lp = 2;
        elseif ($tingkat == "S1")
            $lp = 3;
        elseif ($tingkat == "D4")
            $lp = 3;
        elseif ($tingkat == "D3")
            $lp = 4;
        elseif ($tingkat == "D2")
            $lp = 5;
        elseif ($tingkat == "D1")
            $lp = 6;
        elseif ($tingkat == "SMU/SMK/MA/SEDERAJAT" or $tingkat == "SMA/SEDERAJAT")
            $lp = 7;
        elseif ($tingkat == "SMP/MTs/SEDERAJAT" or $tingkat == "SMP/SEDERAJAT")
            $lp = 8;
        elseif ($tingkat == "SD/SEDERAJAT")
            $lp = 9;

        if (!is_numeric($lulusan))
            $lulusan = 0;
        mysqli_query($con,"insert into pendidikan (id_pegawai,lembaga_pendidikan,tingkat_pendidikan,jurusan_pendidikan,tahun_lulus,level_p,id_bidang,id_institusi) values ($id,'$lembaga','$tingkat','$jurusan',$lulusan,$lp,$bidang,$lem[0])");


    }

// INSERT NEW DIKLAT

    if (isset($_POST['jenis_diklat']) && strlen($_POST['nama_diklat']) > 5) {
        $fudiklat = $_FILES['fupdiklat'];

        $tu = date("Y-m-d");
        $tc = date("Y-m-d h:i:s");
        $tgl_diklat = explode('-', $_POST['tgl_diklat']);
        $tgl_diklat = $tgl_diklat[2] . '-' . $tgl_diklat[1] . '-' . $tgl_diklat[0];
        $qInsertDiklat = "INSERT INTO diklat(id_pegawai, id_jenis_diklat, tgl_diklat, jml_jam_diklat, nama_diklat, penyelenggara_diklat, no_sttpl)
					  VALUES ('$id', '$_POST[jenis_diklat]', '$tgl_diklat', '$_POST[jml_jam_diklat]', '$_POST[nama_diklat]', '$_POST[penyelenggara_diklat]', '$_POST[no_sttpl]')";
        if (mysqli_query($con,$qInsertDiklat)) {
            $id_diklat = mysqli_insert_id($con);
            echo("<div align=center> data diklat sudah disimpan! </div> ");
        } else {
            echo("<div align=center> Gagal menyimpan! </div> " . $qInsertDiklat);
        }

        if ($jenis_diklat == '2') {
            $kat_berkas = 17;
            $nb = 'STTPL';
        } else if ($jenis_diklat == '1' or $jenis_diklat == '3' or $jenis_diklat == '4' or $jenis_diklat == '5') {
            $kat_berkas = 6;
            $nb = 'Sertifikat';
        } else if ($jenis_diklat == '6' or $jenis_diklat == '7' or $jenis_diklat == '8') {
            $kat_berkas = 6;
            $nb = 'Sertifikat';
        }

        if ($fudiklat['size'] > 0) {
            //$uploaddir = "../simpeg/berkas/";
            $uploadfile = $uploaddir . basename($fudiklat['name']);

            if ($fudiklat['type'] == 'binary/octet-stream' or $fudiklat['type'] == "application/pdf") {
                //if (move_uploaded_file($fudiklat['tmp_name'], $uploadfile)) {
                if(ssh2_scp_send($connection, $fudiklat['tmp_name'], $uploadfile, 0644)) {
                    //echo "File terupload";
                    mysqli_query($con,"insert into berkas (id_pegawai,id_kat,tgl_upload,byk_hal,tgl_berkas,created_date,nm_berkas) values ($id,$kat_berkas,'$tu',1,'$tu','$tc','$nb')");
                    if ($fdiklat['type'] == 'image/jpeg' or $fdiklat['type'] == 'image/jpg' or $fdiklat['type'] == 'image/png') {
                        $tipe = "jpg";
                    } else {
                        $tipe = "pdf";
                    }
                    $idarsip = mysqli_insert_id($con);
                    mysqli_query($con,"update diklat set id_berkas=$idarsip where id_diklat=$id_diklat");
                    mysqli_query($con,"insert into isi_berkas (id_berkas,hal_ke,file_name) values ($idarsip,1,'')");
                    $idisi = mysqli_insert_id($con);
                    $namafile = $ata['nip_baru']."-".$idarsip."-".$idisi.".".$tipe;
                    mysqli_query($con,"update isi_berkas set file_name='$namafile' where id_isi_berkas=$idisi");
                    //echo "<br>$uploadfile<br>$namafile";
                    //rename($uploadfile, "../simpeg/berkas/" . $namafile);
                    ssh2_sftp_rename($sftp, $uploadfile,$uploaddir.$namafile);
                }else{
                    echo "File tidak terupload";
                }
            }else{
                echo "Tipe file harus PDF";
            }
        }
    }

// END OF INSERT NEW DIKLAT
    /******************************insert riwayat jabatan************************/

}
if ($_POST['nama_jabatan'] != NULL) {


    $jabatan = $_POST['nama_jabatan'];
    $unit_kerja = $_POST['unit_kerja'];
    $no_sk = $_POST['no_sk'];
    $tahun_masuk = $format->date_Ymd($_POST['tahun_masuk']);
    $tahun_keluar = $format->date_Ymd($_POST['tahun_keluar']);

    $sql = "INSERT INTO riwayat_kerja(id_pegawai,Jabatan, unit_kerja, no_sk, tgl_masuk, tgl_keluar)
					VALUES('$id','$jabatan','$unit_kerja', '$no_sk', '$tahun_masuk','$tahun_keluar')";
    //echo $sql;
    if (mysqli_query($con,$sql)) {
        echo("<div align=center>riwayat jabatan sudah disimpan! </div> ");
    } else {
        echo("<div align=center>riwayat jabatan GAGAL disimpan! </div> ");
    }
}
?>
<h2><?php echo($ata[1]); ?></h2>
<form action="dock2.php" method="post" name="form1" class="hurup" id="form1" enctype="multipart/form-data">
    <div id="TabbedPanels1" class="TabbedPanels">
        <ul class="TabbedPanelsTabGroup">
            <li class="TabbedPanelsTab style2" tabindex="0">Biodata</li>
            <li class="TabbedPanelsTab style2" tabindex="0">Keluarga</li>
            <li class="TabbedPanelsTab style2" tabindex="0">Pendidikan</li>
            <li class="TabbedPanelsTab style2" tabindex="0">Berkas Pegawai</li>
            <li class="TabbedPanelsTab style2" tabindex="0">Diklat</li>
            <!--li class="TabbedPanelsTab style2" tabindex="0">Riwayat Jabatan</li-->
            <li class="TabbedPanelsTab style2" tabindex="0">Riwayat Jabatan</li>
            <li class="TabbedPanelsTab style2" tabindex="0">Riwayat SKP</li>
            <li class="TabbedPanelsTab style2" tabindex="0">Riwayat Ekinerja</li>
            <div align="right"><?php // <a href="dock2.php?id=<?php echo($id); &ha=1">[ hapus pegawai ]</a> || ?> <a
                    href="tambah.php">[ Tambah pegawai ]</a> |
				<a href="#" onclick="resetImei(<?php echo $id ?>)" id="btnResetImei">[ Reset Imei ]</a> |
                <a href="../simpeg2/pdf/skum_pdf/index/<?php echo($ata['id_pegawai']); ?>" target="_blank">[ Lihat SKUM ]</a> |
                <input type="submit" name="button" id="button" value="Simpan"/></div>

        </ul>
        <div class="TabbedPanelsContentGroup">
            <div class="TabbedPanelsContent">

                <?php include ("biodata.php") ?>
            </div>

            <div class="TabbedPanelsContent">
                <?php include ("riwayat_keluarga.php"); ?>

            </div>
            <div class="TabbedPanelsContent">
                <?php include("riwayat_pendidikan.php"); ?>
            </div>
            <div class="TabbedPanelsContent">
                <?php include("riwayat_sk.php") ?>

            </div>

            <!-- Tab Content of DIKLAT -->
            <div class="TabbedPanelsContent">
                <?php include("riwayat_diklat.php") ?>
            </div>
            <!-- End fo Tab Content of DIKLAT -->

            <!-- Tab Riwayat Jabatan2 -->
            <div class="TabbedPanelsContent">
                <fieldset>
                    <legend> Riwayat Jabatan</legend>
                    <?php include("riwayat_jabatan2.php"); ?>
                </fieldset>
            </div>


             <div class="TabbedPanelsContent">

                     Riwayat SKP
                    <?php include("riwayat_skp.php"); ?>

            </div>
            <div class="TabbedPanelsContent">

                    Riwayat Ekinerja
                   <?php include("riwayat_ekinerja.php"); ?>

           </div>

        </div>
    </div>
</form>
<script type="text/javascript">


</script>
<script type="text/javascript">


    var TabbedPanels1 = new Spry.Widget.TabbedPanels("TabbedPanels1");

    $(document).ready(function () {
        $('#aktif').change(function () {
            var optionSelectedAktif = $(this).find("option:selected");
            var textSelectedAktif = optionSelectedAktif.text();
            var tgl_dpk;
            var instansi;
            if(textSelectedAktif=='Dipekerjakan' || textSelectedAktif=='Pindah Ke Instansi Lain'){
                $.ajax({
                    type: 'POST',
                    url: 'get_dpk_pindah.php',
                    data: { id_pegawai: <?php echo $id ?>, txtSelectedAktif: textSelectedAktif},
                    dataType: 'json',
                    success: function (data) {
                        $.each(data, function(k, v){
                            tgl_dpk = v.tgl_dpk;
                            instansi = v.instansi;
                        });
                        if (tgl_dpk === undefined || tgl_dpk === null) {
                            tgl_dpk = 'Belum ada data';
                            instansi = 'Belum ada data';
                        }
                        $("#jdlTmt").html('TMT. Terakhir: ' + tgl_dpk);
                        $("#jdlUnit").html(' . Instansi Tujuan: ' + instansi);
                    }
                });
            }else{
                $("#jdlTmt").html('');
                $("#jdlUnit").html('');
            }
        });

        $("#nama_diklat").change(function () {
            switch ($(this).val()) {
                case "Diklat Prajabatan Gol I":
                    $("#jml_jam_diklat").val('174');
                    break;
                case "Diklat Prajabatan Gol II":
                    $("#jml_jam_diklat").val('174');
                    break;
                case "Diklat Prajabatan Gol III":
                    $("#jml_jam_diklat").val('216');
                    break;
                case "Diklat Kepemimpinan Tk.II":
                    $("#jml_jam_diklat").val('405');
                    break;
                case "Diklat Kepemimpinan Tk.III":
                    $("#jml_jam_diklat").val('360');
                    break;
                case "Diklat Kepemimpinan Tk.IV":
                    $("#jml_jam_diklat").val('285');
                    break;
            }
        });

        $("select[name^=id_skpd]").change(function () {
            var selected = $(this).attr('number');
            if ($(this).val() == -1) {
                $("input[name^=jabatan]").each(function () {
                    if ($(this).attr('number') == selected) $(this).show();
                });
            }
            else {
                $("input[name^=jabatan]").each(function () {
                    if ($(this).attr('number') == selected) $(this).hide();
                });
            }
        });
    });


    function update_kepsek(id_pegawai) {

        $.post("update_kepsek.php", {"id_pegawai": id_pegawai}, function (data) {
            alert(data);
        });

    }

	function resetImei(id_pegawai){
		$.post("reset_imei.php", {"id_pegawai": id_pegawai}, function (data) {
            if(data == '1'){
				$("#divreset").html("-");
				alert("Berhasil");
			}else{
				alert(Gagal);
			}
        });
	}

</script>
