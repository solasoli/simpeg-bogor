<?php
include("konek.php");
$isi = scandir("berkas_sk_uploader/",1);
//print_r($isi);
echo "Ukuran: ".sizeof($isi).'<br>';
// JANGAN SAMPAI LUPA DIEDIT DAN DIUPLOAD =========================================
$nosk = '823/Kep.484-BKD/2011';
$tmt = '2011-04-01';
$tglsk = '2011-03-28';
$pemberi = 'Gubernur Jawa Barat';
$pengesah = 'Kepala Badan Kepegawaian Daerah';
// ===========================================================

echo 'NO.SK : '.$nosk.'<br>TMT : '.$tmt.'<br>TGL.SK : '.$tglsk.'<br>PEMBERI : '.$pemberi.'<br>PENGESAH : '.$pengesah.'<br>';
echo '=====================================================================================================================<br>';

for($i=0; $i<=sizeof($isi); $i++)
{
    $text =  basename($isi[$i], ".pdf");
    $arrText = explode('-',$text);
    //$arrText = explode(' ',$text); // space delimiter
    if(strlen($arrText[0]) > 10){
        //$arrText2 = explode('-',$arrText[1]); // space delimiter
        $x = $i+1;
        $gol = strtolower($arrText[1]);
        //$gol = strtolower($arrText2[0]); // space delimiter
        switch (substr($gol,0,1)) {
            case '1':
                $gol_ = 'I';
                break;
            case '2':
                $gol_ = 'II';
                break;
            case '3':
                $gol_ = 'III';
                break;
            case '4':
                $gol_ = 'IV';
                break;
        }
        $nip = $arrText[0];
        $gol = $gol_.'/'.substr($gol,1,1);
        $thnMk = $arrText[2];
        $blnMk = $arrText[3];
        //$thnMk = $arrText2[1]; // space delimiter
        //$blnMk = $arrText2[2]; // space delimiter

        $qid=mysqli_query($mysqli,"select id_pegawai from pegawai where nip_baru='$arrText[0]'");
        $idp=mysqli_fetch_array($qid);
        $existSK = "select max(id_sk) from sk where id_pegawai = $idp[0] and id_kategori_sk = 5 and tmt = '$tmt'";
        $qexistSK = mysqli_query($mysqli,$existSK);
        $dSK=mysqli_fetch_array($qexistSK);
        if($dSK[0]==''){
            echo $x.'. NIP '.$arrText[0].' belum ada data sk. ';
            $sqlInsertSK = "insert into sk(id_pegawai,id_kategori_sk,no_sk,tgl_sk,pemberi_sk,pengesah_sk,keterangan,tmt,
                            catatan,gol,mk_tahun,mk_bulan) values ($idp[0],5,'$nosk','$tglsk',
                            '$pemberi','$pengesah','$gol,$thnMk,$blnMk','$tmt','$gol,$thnMk,$blnMk',
                            '$gol',".(int)$thnMk.",".(int)$blnMk.")";
            $qInsSK = mysqli_query($mysqli,$sqlInsertSK);
            $idSK = mysqli_insert_id();
            $sqlInsBerkas = "insert into berkas (id_pegawai,id_kat,nm_berkas,tgl_upload,byk_hal,tgl_berkas,created_date)
                        values ($idp[0],2,'SK',CURDATE(),1,CURDATE(),CURDATE())";
            //echo $sqlInsBerkas.'<br>';
            mysqli_query($mysqli,$sqlInsBerkas);
            $idarsip = mysqli_insert_id();
            mysqli_query($mysqli,"insert into isi_berkas (id_berkas,hal_ke,file_name) values ($idarsip,1,'')");
            $idisi = mysqli_insert_id();
            $namafile = "$nip-$idarsip-$idisi.pdf";
            mysqli_query($mysqli,"update isi_berkas set file_name='$namafile' where id_isi_berkas=$idisi");
            copy("berkas_sk_uploader/$isi[$i]","Berkas/$namafile");
            mysqli_query($mysqli,"update sk set id_berkas = $idarsip where id_sk = $idSK");
            echo "Berhasil input data sk dan berkas $namafile<br>";
            $qGol=mysqli_query($mysqli,"select gol from sk where id_sk = $idSK");
            $dGol=mysqli_fetch_array($qGol);
            //mysqli_query($mysqli,"update pegawai set pangkat_gol = '$dGol[0]' where id_pegawai = $idp[0]");
        }else{
            echo $x.'. NIP '.$arrText[0].' sdh ada data sk. ';
            $qIdBerkas=mysqli_query($mysqli,"select id_berkas from sk where id_sk = $dSK[0]");
            $dBerkasSK=mysqli_fetch_array($qIdBerkas);
            if($dBerkasSK[0]==''){
                $cek[0] = 0;
            }else {
                $qCekBerkas = mysqli_query($mysqli,"select count(*) from berkas where id_berkas = $dBerkasSK[0]");
                $cek = mysqli_fetch_array($qCekBerkas);
            }
            if($cek[0]==0){
                echo 'Belum ada berkas<br>';
                $sqlInsBerkas = "insert into berkas (id_pegawai,id_kat,nm_berkas,tgl_upload,byk_hal,tgl_berkas,created_date)
                        values ($idp[0],2,'SK',CURDATE(),1,CURDATE(),CURDATE())";
                //echo $sqlInsBerkas.'<br>';
                mysqli_query($mysqli,$sqlInsBerkas);
                $idarsip = mysqli_insert_id();
                mysqli_query($mysqli,"insert into isi_berkas (id_berkas,hal_ke,file_name) values ($idarsip,1,'')");
                $idisi = mysqli_insert_id();
                $namafile = "$nip-$idarsip-$idisi.pdf";
                mysqli_query($mysqli,"update isi_berkas set file_name='$namafile' where id_isi_berkas=$idisi");
                copy("berkas_sk_uploader/$isi[$i]","Berkas/$namafile");
                mysqli_query($mysqli,"update sk set id_berkas = $idarsip where id_sk = $dSK[0]");
                echo "Berhasil input data berkas $namafile<br>";
                $qGol=mysqli_query($mysqli,"select gol from sk where id_sk = $dSK[0]");
                $dGol=mysqli_fetch_array($qGol);
                //mysqli_query($mysqli,"update pegawai set pangkat_gol = '$dGol[0]' where id_pegawai = $idp[0]");
            }else{
                echo 'Sudah ada berkas.<br>';
                $qGol=mysqli_query($mysqli,"select gol from sk where id_sk = $dSK[0]");
                $dGol=mysqli_fetch_array($qGol);
                //mysqli_query($mysqli,"update pegawai set pangkat_gol = '$dGol[0]' where id_pegawai = $idp[0]");
            }
        }
    }else{
        echo ($i+1).'. Bukan file SK atau tidak memenuhi kriteria penamaan file<br>';
    }
}

?>