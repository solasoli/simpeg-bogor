<!--DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
<!-- Generic page styles >
<link rel="stylesheet" href="assets/css/style.css">
<!-- CSS to style the file input field as button and adjust the Bootstrap progress bars >
<link rel="stylesheet" href="assets/css/jquery.fileupload.css">
</head>

<body> -->
<body onLoad="loadUploadLib();">
<?php
extract($_GET);
include("konek.php");
$q1 = mysqli_query($mysqli,"select nama,pangkat_gol,jabatan,jenjab from pegawai where id_pegawai=$idp ");
$name = mysqli_fetch_array($q1);



$nama = strtoupper($name[0]);

$qtnp=mysqli_query($mysqli,"select max(tmt) from sk where id_pegawai=$idp and id_kategori_sk=5");
$tnp=mysqli_fetch_array($qtnp);
$d1=date("Y-m-d");
$d2=$tnp[0];
$date_diff=strtotime($d1)-strtotime($d2);
$selisih=($date_diff)/(60*60*24*365);

if(($name[3]=="Struktural" and $selisih<4) or ($name[3]=="Fungsional" and $selisih<2) )
{
if($selisih<3.7535388127854)
{
$bulan=ceil((3.7535388127854-$selisih)*12);	
echo("<div align=center>Anda Belum dapat mengajukan kenaikan pangkat sekarang,silakan kembali ke menu ini $bulan bulan lagi </div>");

}
else
echo("<div align=center>Silakan Upload persyaratan file yang diperlukan lalu klik ajukan setelah selesai upload </div>");
?>
<form action="index3.php" method="post" enctype="multipart/form-data" name="form1" id="form1">
<p align="center">FORM PENGAJUAN BERKAS PERSYARATAN KENAIKAN PANGKAT *)
    <input name="guru" type="hidden" id="guru" value="<?php

    echo("$name[2]");
    ?>"/>
    <br/><?php echo "$nama"; ?></p>
<table width="95%" border="0" align="center" style="border-radius:5px;"
       class="table table-bordered table-hover table-striped">
<tr>
    <td align="center" style="padding:5px;">NO</td>
    <td>NAMA BERKAS</td>
    <td align="left">UPLOAD</td>
</tr>
<tr>
  <td align="center" style="padding:5px;">1</td>
  <td>Surat Pengantar Dari Unit Kerja</td>
  <td align="left"><?php


        $qc6 = mysqli_query($mysqli,"select count(*) from berkas where id_pegawai=$idp and id_kat=23 and ket_berkas like '$ket' ");


        $cek6 = mysqli_fetch_array($qc6);
        if ($cek6[0] == 0)
        {
        ?>
    <span class="btn btn-primary btn-sm fileinput-button"> <i class="glyphicon glyphicon-plus"></i> <span> Pilih File</span>
    <!-- The file input field used as target for the file upload widget -->
    <input id="fileupload2" type="file" name="fileupload2" multiple/>
    
    </span>
    <div id="progress6" class="progress primary">
    <div class="progress-bar progress-bar-primary">
    <?php
                }
                else {

                    $qc66 = mysqli_query($mysqli,"select b.id_berkas, ib.file_name from berkas b, isi_berkas ib where b.id_berkas = ib.id_berkas and b.id_pegawai=$idp and b.id_kat=23 and b.ket_berkas like '$ket' ");

                    $cek66 = mysqli_fetch_array($qc66);

                    mysqli_query($mysqli,"update ijin_belajar set kmpt=$cek66[0] where id=$ij[0]");
                    echo("<a href='/Simpeg/Berkas/".basename($cek66[1])."' target='_blank' >Syarat Sudah Tersedia</a>");
                    echo("<input type=hidden name=s6 id=s6 value=1 />");
                echo("  <input type=\"button\" name=\"button\" id=\"btnReupload6\" value=\"Upload Ulang\" onclick=\"toggle_fileReupload('fileReupload6', 'btnReupload6');\" />");
                ?>
    <div id="fileReupload6">
    <span class="btn btn-primary btn-sm fileinput-button"> <i class="glyphicon glyphicon-plus"></i> <span> Pilih File</span>
    <!-- The file input field used as target for the file upload widget -->
    <input id="fileupload2" type="file" name="fileupload2" multiple/>
  
    </span>
    <div id="progress6" class="progress primary">
    <div class="progress-bar progress-bar-primary"></div>
    <?php
                        }
                        ?></td>
</tr>
<tr>
  <td align="center" style="padding:5px;">2</td>
  <td>SK Pangkat Terakhir / SK Pengangkatan PNS <i>
    <small>( pdf / jpg )</small>
    </i></td>
  <td align="left">
    <?php
        $qc1 = mysqli_query($mysqli,"select count(*) from sk where id_kategori_sk=5 and id_pegawai=$idp and keterangan like '$name[1]%' and id_berkas>0 ");


        $cek1 = mysqli_fetch_array($qc1);
        if ($cek1[0] == 0)
        {
        ?>
    <span class="btn btn-primary btn-sm fileinput-button">
      <i class="glyphicon glyphicon-plus"></i>
      <span>Pilih File</span>
      <!-- The file input field used as target for the file upload widget -->
      <input id="fileupload3" type="file" name="files[]" multiple/>  </span>
   
    
    <div id="progress3" class="progress primary">
    <div class="progress-bar progress-bar-primary">
    
    <?php
                }
                else {

                    $qc11 = mysqli_query($mysqli,"select b.id_berkas, ib.file_name from sk b, isi_berkas ib where b.id_berkas = ib.id_berkas AND b.id_pegawai=$idp and b.id_kategori_sk=5 and b.keterangan like '$name[1]%' and b.id_berkas>0 ");
                    $cek11 = mysqli_fetch_array($qc11);

                    mysqli_query($mysqli,"update ijin_belajar set skt=$cek11[0] where id=$ij[0]");

                    echo("<a href='/Simpeg/Berkas/".basename($cek11[1])."' target='_blank' >Syarat Sudah Tersedia</a>");
                    echo("<input type=hidden name=s3 id=s3 value=1 />");
                echo("  <input type=\"button\" name=\"button\" id=\"btnReupload3\" value=\"Upload Ulang\" onclick=\"toggle_fileReupload('fileReupload3', 'btnReupload3');\" />");
                ?>
    <div id="fileReupload3">
    <span class="btn btn-primary btn-sm fileinput-button">
      <i class="glyphicon glyphicon-plus"></i>
      <span>Pilih File</span>
      <!-- The file input field used as target for the file upload widget -->
      <input id="fileupload3" type="file" name="files[]" multiple/>  </span>

    
    <div id="progress3" class="progress primary">
    <div class="progress-bar progress-bar-primary">
      </div>
    <?php
                        }
                        ?>
    </td>
</tr>


<tr>
    <td align="center" style="padding:5px;">3</td>
    <td>SKP / Penilaian Prestasi Kerja Tahun <?php
    echo substr($tnp[0],0,4)+3;
	?><i>
            <small>( pdf / jpg )</small>
        </i></td>
    <td align="left">
        <?php
        $last = date("Y") +3;
        $qc4 = mysqli_query($mysqli,"select count(*) from dp3 where id_pegawai=$idp and tahun=$last and id_berkas>0");
        $cek4 = mysqli_fetch_array($qc4);
        if ($cek4[0] == 0)
        {
        ?>
        <span class="btn btn-primary btn-sm fileinput-button">
            <i class="glyphicon glyphicon-plus"></i>
            <span>Pilih File  </span>
            <!-- The file input field used as target for the file upload widget -->
            <input id="fileupload4" type="file" name="files[]" multiple/></span>

        <div id="progress4" class="progress primary">
            <div class="progress-bar progress-bar-primary">

                <?php
                }
                else {

                    $qc44 = mysqli_query($mysqli,"select d.id_berkas, ib.file_name from dp3 d, isi_berkas ib where d.id_berkas = ib.id_berkas AND d.id_pegawai=$idp and d.tahun=$last");

                    $cek44 = mysqli_fetch_array($qc44);

                    mysqli_query($mysqli,"update ijin_belajar set dp3=$cek44[0] where id=$ij[0]");
                    echo("<a href='/Simpeg/Berkas/".basename($cek44[1])."' target='_blank' >Syarat Sudah Tersedia</a>");
                    echo("<input type=hidden name=s4 id=s4 value=1 />");
                echo("  <input type=\"button\" name=\"button\" id=\"btnReupload4\" value=\"Upload Ulang\" onclick=\"toggle_fileReupload('fileReupload4', 'btnReupload4');\" />");
                ?>
                <div id="fileReupload4">
              <span class="btn btn-primary btn-sm fileinput-button">
            <i class="glyphicon glyphicon-plus"></i>
            <span>Pilih File  </span>
            <!-- The file input field used as target for the file upload widget -->
            <input id="fileupload4" type="file" name="files[]" multiple/></span>

                    <div id="progress4" class="progress primary">
                        <div class="progress-bar progress-bar-primary">
                        </div>
                        <?php
                        }
                        ?>

    </td>
</tr>

<tr>
    <td align="center" style="padding:5px;">4</td>
    <td>SKP / Penilaian Prestasi Kerja Tahun <?php
    echo substr($tnp[0],0,4)+2;
	?><i> <small>( pdf / jpg )</small></i></td>
    <td align="left">


        <?php

        $curtp = $ibe[0] + 1;
        //$qc5=mysqli_query($mysqli,"select count(*) from pendidikan where id_pegawai=$idp and id_berkas>0 and level_p=$curtp ");
        $qc5 = mysqli_query($mysqli,"select count(*) from ijin_belajar where id_pegawai=$idp and ijazah > 0  ");
        //$qc5 = mysqli_query($mysqli,"select count(*) from ijin_belajar left join pendidikan on ijin_belajar.id_pegawai=pendidikan.id_pegawai  where ijin_belajar.id_pegawai=$idp and pendidikan.ijazah > 0  and  pendidikan.level_p=$curtp");
        $cek5 = mysqli_fetch_array($qc5);
        if ($cek5[0] == 0)
        {
        ?>

        <span class="btn btn-primary btn-sm fileinput-button">
				<i class="glyphicon glyphicon-plus"></i>
				<span>   Pilih File</span>
				<!-- The file input field used as target for the file upload widget -->
				<input id="fileupload5" type="file" name="files[]" multiple/>
        </span>

        <div id="progress5" class="progress primary">
            <div class="progress-bar progress-bar-primary">
                <?php
                }
                else {

                    $qc55 = mysqli_query($mysqli,"select p.id_berkas, ib.file_name from pendidikan p, isi_berkas ib where p.id_berkas = ib.id_berkas AND p.id_pegawai=$idp and p.id_berkas>0 and p.level_p=$curtp ");

                    $cek55 = mysqli_fetch_array($qc55);

                    mysqli_query($mysqli,"update ijin_belajar set ijazah=$cek55[0] where id=$ij[0]");
                    echo("<a href='/Simpeg/Berkas/".basename($cek55[1])."' target='_blank' >Syarat Sudah Tersedia</a>");
                    echo("<input type=hidden name=s5 id=s5 value=1 />");
                echo("  <input type=\"button\" name=\"button\" id=\"btnReupload5\" value=\"Upload Ulang\" onclick=\"toggle_fileReupload('fileReupload5', 'btnReupload5');\" />");
                ?>
                <div id="fileReupload5">
              <span class="btn btn-primary btn-sm fileinput-button">
				<i class="glyphicon glyphicon-plus"></i>
				<span>   Pilih File</span>
				<!-- The file input field used as target for the file upload widget -->
				<input id="fileupload5" type="file" name="files[]" multiple/>
            </span>

                    <div id="progress5" class="progress primary">
                        <div class="progress-bar progress-bar-primary">
                        </div>
                        <?php
                        }
                        ?>
    </td>
</tr>


<tr>
  <td align="center" style="padding:5px;">5</td>
  <td>Surat Tanda Lulus Ujian Dinas  Untuk Penyesuaian Ijasah <i> <small>( pdf / jpg </small></i></td>
  <td align="left"><?php


        $qc6 = mysqli_query($mysqli,"select count(*) from berkas where id_pegawai=$idp and id_kat=23 and ket_berkas like '$ket' ");


        $cek6 = mysqli_fetch_array($qc6);
        if ($cek6[0] == 0)
        {
        ?>
    <span class="btn btn-primary btn-sm fileinput-button"> <i class="glyphicon glyphicon-plus"></i> <span> Pilih File</span>
    <!-- The file input field used as target for the file upload widget -->
    <input id="fileupload8" type="file" name="fileupload8" multiple/>
    </span>
    <div id="progress6" class="progress primary">
    <div class="progress-bar progress-bar-primary">
    <?php
                }
                else {

                    $qc66 = mysqli_query($mysqli,"select b.id_berkas, ib.file_name from berkas b, isi_berkas ib where b.id_berkas = ib.id_berkas and b.id_pegawai=$idp and b.id_kat=23 and b.ket_berkas like '$ket' ");

                    $cek66 = mysqli_fetch_array($qc66);

                    mysqli_query($mysqli,"update ijin_belajar set kmpt=$cek66[0] where id=$ij[0]");
                    echo("<a href='/Simpeg/Berkas/".basename($cek66[1])."' target='_blank' >Syarat Sudah Tersedia</a>");
                    echo("<input type=hidden name=s6 id=s6 value=1 />");
                echo("  <input type=\"button\" name=\"button\" id=\"btnReupload6\" value=\"Upload Ulang\" onclick=\"toggle_fileReupload('fileReupload6', 'btnReupload6');\" />");
                ?>
    <div id="fileReupload6">
    <span class="btn btn-primary btn-sm fileinput-button"> <i class="glyphicon glyphicon-plus"></i> <span> Pilih File</span>
    <!-- The file input field used as target for the file upload widget -->
    <input id="fileupload8" type="file" name="fileupload8" multiple/>
    </span>
    <div id="progress6" class="progress primary">
    <div class="progress-bar progress-bar-primary"></div>
    <?php
                        }
                        ?></td>
</tr>
<tr>
    <td align="center" style="padding:5px;">6</td>
    <td>Ijazah Pendidikan Terakhir Untuk Penyesuaian Ijasah <i> <small>( pdf / jpg </small></i></td>
    <td align="left">


        <?php


        $qc6 = mysqli_query($mysqli,"select count(*) from berkas where id_pegawai=$idp and id_kat=23 and ket_berkas like '$ket' ");


        $cek6 = mysqli_fetch_array($qc6);
        if ($cek6[0] == 0)
        {
        ?>
        <span class="btn btn-primary btn-sm fileinput-button">
            <i class="glyphicon glyphicon-plus"></i>
            <span>
            Pilih File</span>
            <!-- The file input field used as target for the file upload widget -->
            <input id="fileupload6" type="file" name="files[]" multiple/>
        </span>

        <div id="progress6" class="progress primary">
            <div class="progress-bar progress-bar-primary">
                <?php
                }
                else {

                    $qc66 = mysqli_query($mysqli,"select b.id_berkas, ib.file_name from berkas b, isi_berkas ib where b.id_berkas = ib.id_berkas and b.id_pegawai=$idp and b.id_kat=23 and b.ket_berkas like '$ket' ");

                    $cek66 = mysqli_fetch_array($qc66);

                    mysqli_query($mysqli,"update ijin_belajar set kmpt=$cek66[0] where id=$ij[0]");
                    echo("<a href='/Simpeg/Berkas/".basename($cek66[1])."' target='_blank' >Syarat Sudah Tersedia</a>");
                    echo("<input type=hidden name=s6 id=s6 value=1 />");
                echo("  <input type=\"button\" name=\"button\" id=\"btnReupload6\" value=\"Upload Ulang\" onclick=\"toggle_fileReupload('fileReupload6', 'btnReupload6');\" />");
                ?>
                <div id="fileReupload6">
              <span class="btn btn-primary btn-sm fileinput-button">
            <i class="glyphicon glyphicon-plus"></i>
            <span>
            Pilih File</span>
            <!-- The file input field used as target for the file upload widget -->
            <input id="fileupload6" type="file" name="files[]" multiple/>
            </span>

                    <div id="progress6" class="progress primary">
                        <div class="progress-bar progress-bar-primary">
                        </div>
                        <?php
                        }
                        ?>
    </td>
</tr>
<tr>
    <td align="center" style="padding:5px;">7</td>
    <td>SK Mutasi Jabatan Terakhir Untuk Kenaikan Pangkat Istimewa<i> <small>( pdf / jpg )</small></i></td>
    <td align="left">


        <?php


        $qc7 = mysqli_query($mysqli,"select count(*) from berkas where id_pegawai=$idp and id_kat=24 and ket_berkas like '$ket' ");


        $cek7 = mysqli_fetch_array($qc7);
        if ($cek7[0] == 0)
        {
        ?>

        <span class="btn btn-primary btn-sm fileinput-button">
            <i class="glyphicon glyphicon-plus"></i>
            <span>
            Pilih File</span>
            <!-- The file input field used as target for the file upload widget -->
            <input id="fileupload7" type="file" name="files[]" multiple/></span>

        <div id="progress7" class="progress primary">
            <div class="progress-bar progress-bar-primary">
                <?php
                }
                else {
                    $qc77 = mysqli_query($mysqli,"select b.id_berkas, ib.file_name from berkas b, isi_berkas ib where b.id_berkas = ib.id_berkas and b.id_pegawai=$idp and b.id_kat=24 and b.ket_berkas like '$ket' ");

                    $cek77 = mysqli_fetch_array($qc77);

                    mysqli_query($mysqli,"update ijin_belajar set jk=$cek77[0] where id=$ij[0]");
                    echo("<a href='/Simpeg/Berkas/".basename($cek77[1])."' target='_blank' >Syarat Sudah Tersedia</a>");
                    echo("<input type=hidden name=s7 id=s7 value=1 />");
                echo("  <input type=\"button\" name=\"button\" id=\"btnReupload7\" value=\"Upload Ulang\" onclick=\"toggle_fileReupload('fileReupload7', 'btnReupload7');\" />");
                ?>
                <div id="fileReupload7">
              <span class="btn btn-primary btn-sm fileinput-button">
            <i class="glyphicon glyphicon-plus"></i>
            <span>
            Pilih File</span>
            <!-- The file input field used as target for the file upload widget -->
            <input id="fileupload7" type="file" name="files[]" multiple/></span>

                    <div id="progress7" class="progress primary">
                        <div class="progress-bar progress-bar-primary">
                        </div>
                        <?php
                        }
                        ?>

    </td>
</tr>
<?php

if ($name[2] == 'Guru') {

    ?>
<?php
}
?>

<tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td align="left">
    
    <input type="button" name="button" id="button" value="Ajukan" <?php if($selisih<3.7535388127854) echo "disabled "; ?>onClick="validate();" /></td>
</tr>
</table>
</form>
<br/>
<b>*) Jika file / berkas lebih dari satu, sebaiknya disatukan menjadi file dengan format pdf. </b>
<?php
}
else
{
	
echo("<div align=center>SK Kenaikan Pangkat Terakhir Anda Belum Diupdate Silahkan Update Terlebih Dahulu</div>");	
}
?>

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<!-- The jQuery UI widget factory, can be omitted if jQuery UI is already included -->
<script src="assets/js/vendor/jquery.ui.widget.js"></script>
<!-- The Iframe Transport is required for browsers without support for XHR file uploads -->
<script src="assets/js/jquery.iframe-transport.js"></script>
<!-- The basic File Upload plugin -->
<script src="assets/js/jquery.fileupload.js"></script>
<!-- Bootstrap JS is not required, but included for the responsive demo navigation -->
<!--script src="//netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script-->
<script>
/*jslint unparam: true */
/*global window, $ */

function loadUploadLib() {
    $("#fileReupload3").hide();
    $("#fileReupload4").hide();
    $("#fileReupload5").hide();
    $("#fileReupload6").hide();
    $("#fileReupload7").hide();
}

function toggle_fileReupload(fileReupload, btnReupload) {
    //alert(fileReupload + "-" + btnReupload)
    $("#"+fileReupload).fadeToggle();
    var x = document.getElementById(btnReupload);
    if (x.value == "Upload Ulang")
        x.value = "Batal Upload Ulang";
    else
        x.value = "Upload Ulang";
}



$(function () {


    'use strict';
//SK pangkat terakhir
    var url3 = window.location.hostname === 'blueimp.github.io' ?
        '//jquery-file-upload.appspot.com/' : 'uploaderkp.php?idkat=2&js=skp2&idp=<?php echo($idp); ?>';
    $('#fileupload3').fileupload({
        url: url3,
        dataType: 'json',
        done: function (e, data) {
            $.each(data.result.files, function (index, file) {
                $('<p/>').text(file.name).appendTo('#files');
                $('#s3').val(1);
            });
        },
        progressall: function (e, data) {
            var progress = parseInt(data.loaded / data.total * 100, 10);
            $('#progress3 .progress-bar').css(
                'width',
                progress + '%'
            );
        }
    })

//

//skp1
    var url4 = window.location.hostname === 'blueimp.github.io' ?
        '//jquery-file-upload.appspot.com/' : 'uploaderkp.php?idkat=20&js=skp2&idp=<?php echo($idp); ?>';
    $('#fileupload4').fileupload({
        url: url4,
        dataType: 'json',
        done: function (e, data) {
            $.each(data.result.files, function (index, file) {
                $('<p/>').text(file.name).appendTo('#files');
                $('#s4').val(1);
            });
        },
        progressall: function (e, data) {
            var progress = parseInt(data.loaded / data.total * 100, 10);
            $('#progress4 .progress-bar').css(
                'width',
                progress + '%'
            );
        }
    })

//

//skp2
    var url5 = window.location.hostname === 'blueimp.github.io' ?
        '//jquery-file-upload.appspot.com/' : 'uploaderkp.php?idkat=20&js=skp2&idp=<?php echo($idp); ?>';
    $('#fileupload5').fileupload({
        url: url5,
        dataType: 'json',
        done: function (e, data) {
            $.each(data.result.files, function (index, file) {
                $('<p/>').text(file.name).appendTo('#files');
                $('#s5').val(1);
            });
        },
        progressall: function (e, data) {
            var progress = parseInt(data.loaded / data.total * 100, 10);
            $('#progress5 .progress-bar').css(
                'width',
                progress + '%'
            );
        }
    })

//


//ijasah
    var url6 = window.location.hostname === 'blueimp.github.io' ?
        '//jquery-file-upload.appspot.com/' : 'uploaderkp.php?idkat=3&js=ij&idp=<?php echo($idp); ?>';
    $('#fileupload6').fileupload({
        url: url6,
        dataType: 'json',
        done: function (e, data) {
            $.each(data.result.files, function (index, file) {
                $('<p/>').text(file.name).appendTo('#files');
                $('#s6').val(1);
            });
        },
        progressall: function (e, data) {
            var progress = parseInt(data.loaded / data.total * 100, 10);
            $('#progress6 .progress-bar').css(
                'width',
                progress + '%'
            );
        }
    })

//

//mutasijabatan
    var url7 = window.location.hostname === 'blueimp.github.io' ?
        '//jquery-file-upload.appspot.com/' : 'uploaderkp.php?idkat=2&js=mj&idp=<?php echo($idp); ?>';
    $('#fileupload7').fileupload({
        url: url7,
        dataType: 'json',
        done: function (e, data) {
            $.each(data.result.files, function (index, file) {
                $('<p/>').text(file.name).appendTo('#files');
                $('#s7').val(1);
            });
        },
        progressall: function (e, data) {
            var progress = parseInt(data.loaded / data.total * 100, 10);
            $('#progress7 .progress-bar').css(
                'width',
                progress + '%'
            );
        }
    })




        .prop('disabled', !$.support.fileInput)
        .parent().addClass($.support.fileInput ? undefined : 'disabled');
});
</script>
</body>