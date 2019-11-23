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

<body-->
<?php
extract($_GET);
include("konek.php");
$q1=mysqli_query($mysqli,"select nama,pangkat_gol,jabatan from pegawai where id_pegawai=$idp ");
$name=mysqli_fetch_array($q1);


$qij=mysqli_query($mysqli,"select id from ijin_belajar where id_pegawai=$idp order by tingkat_pendidikan");
$ij=mysqli_fetch_array($qij);

$tp=array('tp',"S3","S2","S1","D3","D2","D1","SMA","SMP");
$qib=mysqli_query($mysqli,"select min(tingkat_pendidikan) from ijin_belajar where id_pegawai=$idp ");
$ibe=mysqli_fetch_array($qib);
$ket=$tp["$ibe[0]"];

$nama=strtoupper($name[0]);
?>
<form action="index3.php" method="post" enctype="multipart/form-data" name="form1" id="form1">
  <p align="center">FORM PENGAJUAN BERKAS PERSYARATAN SURAT IZIN BELAJAR  *)
    <input name="guru" type="hidden" id="guru" value="<?php
    
	echo("$name[2]");
	?>" />
  <br /><?php echo "$nama"; ?></p>
  <table width="95%" border="0" align="center" style="border-radius:5px;" class="table table-bordered table-hover table-striped">
    <tr   >
      <td align="center" style="padding:5px;">NO</td>
      <td>NAMA BERKAS</td>
      <td align="left">UPLOAD</td>
    </tr>
    <tr >
      <td align="center" >1</td>
      <td>Surat Pengantar dari Unit Kerja <i><small>( pdf / jpg )</small></i>
      <input name="idp" type="hidden" id="idp" value="<?php echo($idp); ?>" /></td>
      <td align="left" >
      <?php
	  
	  $qc2=mysqli_query($mysqli,"select count(*) from berkas where id_pegawai=$idp and id_kat=21 and ket_berkas like '$ket' ");
	  
	
	  $cek2=mysqli_fetch_array($qc2);
	  if($cek2[0]==0)
	  {
	  ?>
       	<span class="btn btn-primary btn-sm fileinput-button" >
            <i class="glyphicon glyphicon-plus"></i>
            <span>Pilih File</span>
            <!-- The file input field used as target for the file upload widget -->
            <input id="fileupload1" type="file" name="files[]" multiple />  </span>
              <input type="hidden" name="s1" id="s1" />
   	    <div id="progress1" class="progress primary">
        		<div class="progress-bar progress-bar-primary">
               <?php
	  }
	   else
	  {
		    
	  $qc22=mysqli_query($mysqli,"select id_berkas from berkas where id_pegawai=$idp and id_kat=21 and ket_berkas like '$ket' ");
	 
	  $cek22=mysqli_fetch_array($qc22);
	  	  mysqli_query($mysqli,"update ijin_belajar set spuk=$cek22[0] where id=$ij[0]");
	  echo("Syarat Sudah Tersedia");
	  echo("<input type=hidden name=s1 id=s1 value=1 />");
	  }
	  ?>
        
   
    
      
      
      </td>
    </tr>
    <tr>
      <td align="center" style="padding:5px;">2</td>
      <td>Surat Pernyataan yang Ditandatangani oleh Atasan Langsung <i><small>( pdf / jpg )</small></i></td>
      <td align="left">
      
   
            <?php
	  
	  $qc3=mysqli_query($mysqli,"select count(*) from berkas where id_pegawai=$idp and id_kat=22 and ket_berkas like '$ket' ");
	  
	
	  $cek3=mysqli_fetch_array($qc3);
	  if($cek3[0]==0)
	  {
	  ?>
      
         <span class="btn btn-primary btn-sm fileinput-button" >
            <i class="glyphicon glyphicon-plus"></i>
            <span>
            Pilih File</span>
            <!-- The file input field used as target for the file upload widget -->
            <input id="fileupload2" type="file" name="files[]" multiple />  </span>
              <input type="hidden" name="s2" id="s2" />
               <div id="progress2" class="progress primary">
        		<div class="progress-bar progress-bar-primary">
        	 <?php
	  }
	   else
	  {
		  
		   $qc33=mysqli_query($mysqli,"select id_berkas from berkas where id_pegawai=$idp and id_kat=22 and ket_berkas like '$ket' ");
	  $cek33=mysqli_fetch_array($qc33);
	  
	  mysqli_query($mysqli,"update ijin_belajar set spal=$cek33[0] where id=$ij[0]");
	  echo("Syarat Sudah Tersedia");
	  echo("<input type=hidden name=s2 id=s2 value=1 />");
	  }
	  ?>
        	
               
      
      </td>
    </tr>
    <tr >
      <td align="center" style="padding:5px;">3</td>
      <td>SK Pangkat Terakhir / SK Pengangkatan PNS <i><small>( pdf / jpg )</small></i> </td>
      <td align="left">
      <?php
	  $qc1=mysqli_query($mysqli,"select count(*) from sk where id_kategori_sk=5 and id_pegawai=$idp and keterangan like '$name[1]%' and id_berkas>0 ");
	  
	
	  $cek1=mysqli_fetch_array($qc1);
	  if($cek1[0]==0)
	  {
	  ?>
       <span class="btn btn-primary btn-sm fileinput-button" >
            <i class="glyphicon glyphicon-plus"></i>
            <span>Pilih File</span>
            <!-- The file input field used as target for the file upload widget -->
            <input id="fileupload3" type="file" name="files[]" multiple />  </span>
        <input type="hidden" name="s3" id="s3" />
   	    <div id="progress3" class="progress primary">
        		<div class="progress-bar progress-bar-primary">
               
      <?php
	  }
	  else
	  {
		   $qc11=mysqli_query($mysqli,"select id_berkas from sk where id_kategori_sk=5 and id_pegawai=$idp and keterangan like '$name[1]%' and id_berkas>0 ");
	  
	
	  $cek11=mysqli_fetch_array($qc11);
		  
		  mysqli_query($mysqli,"update ijin_belajar set skt=$cek11[0] where id=$ij[0]");
		
	  echo("Syarat Sudah Tersedia");
	  echo("<input type=hidden name=s3 id=s3 value=1 />");
	  }
	  ?>
      </td>
    </tr>
	
	
    <tr>
      <td align="center" style="padding:5px;">4</td>
      <td>DP3 / Penilaian Prestasi Kerja Tahun Terakhir  <i><small>( pdf / jpg )</small></i> </td>
      <td align="left">
      <?php
	  $last=date("Y")-1;
	  $qc4=mysqli_query($mysqli,"select count(*) from dp3 where id_pegawai=$idp and tahun=$last and id_berkas>0");
	  $cek4=mysqli_fetch_array($qc4);
	  if($cek4[0]==0)
	  {
	  ?>
      <span class="btn btn-primary btn-sm fileinput-button" >
            <i class="glyphicon glyphicon-plus"></i>
            <span>Pilih File  </span>
            <!-- The file input field used as target for the file upload widget -->
            <input id="fileupload4" type="file" name="files[]" multiple /> 
                  <input type="hidden" name="s4" id="s4" /> </span>
                  <div id="progress4" class="progress primary">
                    <div class="progress-bar progress-bar-primary">
           
      <?php
	  }
	   else
	  {
  $qc44=mysqli_query($mysqli,"select id_berkas from dp3 where id_pegawai=$idp and tahun=$last");
	  $cek44=mysqli_fetch_array($qc44);  
	  
	  	  
	  mysqli_query($mysqli,"update ijin_belajar set dp3=$cek44[0] where id=$ij[0]");
	  echo("Syarat Sudah Tersedia");
	  echo("<input type=hidden name=s4 id=s4 value=1 />");
	  }
	  ?>
    
      </td>
    </tr>
	
    <tr>
      <td align="center" style="padding:5px;">5</td>
      <td>Ijazah Pendidikan Terakhir <i><small>( pdf / jpg )</small></i> </td>
      <td align="left">
      
    
		<?php

			$curtp=$ibe[0]+1;
			//$qc5=mysqli_query($mysqli,"select count(*) from pendidikan where id_pegawai=$idp and id_berkas>0 and level_p=$curtp ");
			$qc5=mysqli_query($mysqli,"select count(*) from ijin_belajar where id_pegawai=$idp and ijazah > 0  ");
			//$qc5 = mysqli_query($mysqli,"select count(*) from ijin_belajar left join pendidikan on ijin_belajar.id_pegawai=pendidikan.id_pegawai  where ijin_belajar.id_pegawai=$idp and pendidikan.ijazah > 0  and  pendidikan.level_p=$curtp");
			$cek5=mysqli_fetch_array($qc5);
			if($cek5[0]==0)
			{
		?>
      
			<span class="btn btn-primary btn-sm fileinput-button" >
				<i class="glyphicon glyphicon-plus"></i>
				<span>   Pilih File</span>
				<!-- The file input field used as target for the file upload widget -->
				<input id="fileupload5" type="file" name="files[]" multiple /> 

				<input type="hidden" name="s5" id="s5" />
			</span>
			<div id="progress5" class="progress primary">
			<div class="progress-bar progress-bar-primary">
        	 <?php
	  }
	   else
	  {
		  
		   $qc55=mysqli_query($mysqli,"select id_berkas from pendidikan where id_pegawai=$idp and id_berkas>0 and level_p=$curtp ");
		  $cek55=mysqli_fetch_array($qc55);
				  
		  mysqli_query($mysqli,"update ijin_belajar set ijazah=$cek55[0] where id=$ij[0]");
		  echo("Syarat Sudah Tersedia");
		  echo("<input type=hidden name=s5 id=s5 value=1 />");
	  }
	  ?>
        	
      
      
      </td>
    </tr>
	
	
    <tr>
      <td align="center" style="padding:5px;">6</td>
      <td>Surat Keterangan Diterima / Masih Kuliah dari Perguruan Tinggi <i><small>( pdf / jpg )</small></i> </td>
      <td align="left">
      
     
            <?php
	 
	  
	   $qc6=mysqli_query($mysqli,"select count(*) from berkas where id_pegawai=$idp and id_kat=23 and ket_berkas like '$ket' ");
	  
	
	  $cek6=mysqli_fetch_array($qc6);
	  if($cek6[0]==0)
	  {
	  ?>
       <span class="btn btn-primary btn-sm fileinput-button" >
            <i class="glyphicon glyphicon-plus"></i>
            <span>
            Pilih File</span>
            <!-- The file input field used as target for the file upload widget -->
            <input id="fileupload6" type="file" name="files[]" multiple />
            
                  <input type="hidden" name="s6" id="s6" />
            </span>
              <div id="progress6" class="progress primary">
              <div class="progress-bar progress-bar-primary">
      <?php
	  }
	   else
	  {
		  
		  $qc66=mysqli_query($mysqli,"select id_berkas from berkas where id_pegawai=$idp and id_kat=23 and ket_berkas like '$ket' ");
	  $cek66=mysqli_fetch_array($qc66);
	  
	  mysqli_query($mysqli,"update ijin_belajar set kmpt=$cek66[0] where id=$ij[0]");
	  echo("Syarat Sudah Tersedia");
	  echo("<input type=hidden name=s6 id=s6 value=1 />");
	  }
	  ?>
    
      
      
      </td>
    </tr>
    <tr >
      <td align="center" style="padding:5px;">7</td>
      <td>Jadwal Perkuliahan Yang Masih Berlaku <i><small>( pdf / jpg )</small></i> </td>
      <td align="left">
      
    
            <?php
	 
	  
	   $qc7=mysqli_query($mysqli,"select count(*) from berkas where id_pegawai=$idp and id_kat=24 and ket_berkas like '$ket' ");
	  
	
	  $cek7=mysqli_fetch_array($qc7);
	  if($cek7[0]==0)
	  {
	  ?>
      
         <span class="btn btn-primary btn-sm fileinput-button" >
            <i class="glyphicon glyphicon-plus"></i>
            <span>
            Pilih File</span>
            <!-- The file input field used as target for the file upload widget -->
            <input id="fileupload7" type="file" name="files[]" multiple /> 
           <input type="hidden" name="s7" id="s7" />  </span>
        	 <div id="progress7" class="progress primary">
             <div class="progress-bar progress-bar-primary">
        	 <?php
	  }
	   else
	  {
		  $qc77=mysqli_query($mysqli,"select id_berkas from berkas where id_pegawai=$idp and id_kat=24 and ket_berkas like '$ket' ");
	  $cek77=mysqli_fetch_array($qc77);
	  
	  mysqli_query($mysqli,"update ijin_belajar set jk=$cek77[0] where id=$ij[0]");
	  echo("Syarat Sudah Tersedia");
	  echo("<input type=hidden name=s7 id=s7 value=1 />");
	  }
	  ?>
        		
      
      </td>
    </tr>
    <?php
	
	if($name[2]=='Guru')
	{
	
	?>
    <tr>
      <td align="center" style="padding:5px;">8</td>
      <td>Jadwal Mengajar di Sekolah yang Bersangkutan (Khusus Guru) <i><small>( pdf / jpg )</small></i> </td>
      <td align="left">
      
     
            <?php
	 
	  
	   $qc8=mysqli_query($mysqli,"select count(*) from berkas where id_pegawai=$idp and id_kat=25 and ket_berkas like '$ket' ");
	  
	
	  $cek8=mysqli_fetch_array($qc8);
	  if($cek8[0]==0)
	  {
	  ?>
         <span class="btn btn-primary btn-sm fileinput-button" >
            <i class="glyphicon glyphicon-plus"></i>
            <span>
            Pilih File</span>
            <!-- The file input field used as target for the file upload widget -->
            <input id="fileupload8" type="file" name="files[]" multiple />  </span>
           <input type="hidden" name="s8" id="s8" />
        	 <div id="progress8" class="progress primary">
             	<div class="progress-bar progress-bar-primary">
        <?php
	  }
	   else
	  {
		   $qc88=mysqli_query($mysqli,"select id_berkas from berkas where id_pegawai=$idp and id_kat=25 and ket_berkas like '$ket' ");
			$cek88=mysqli_fetch_array($qc88);
	  
		  mysqli_query($mysqli,"update ijin_belajar set jm=$cek88[0] where id=$ij[0]");
		  echo("Syarat Sudah Tersedia");
		  echo("<input type=hidden name=s8 id=s8 value=1 />");
	  }
	  ?>
        	
      </td>
    </tr>
	
	
	
    <tr >
      <td align="center" style="padding:5px;">9</td>
      <td>Kajian Kebutuhan Guru (untuk Guru S1 atau S2)
      <input name="x" type="hidden" id="x" value="syarat.php" /></td>
      <td align="left">
      
      
            <?php
	 
	  
	   $qc9=mysqli_query($mysqli,"select count(*) from berkas where id_pegawai=$idp and id_kat=26 and ket_berkas like '$ket' ");
	  
	
	  $cek9=mysqli_fetch_array($qc9);
	  if($cek9[0]==0)
	  {
	  ?>
        <span class="btn btn-primary btn-sm fileinput-button" >
            <i class="glyphicon glyphicon-plus"></i>
            <span>
            Pilih File</span>
            <!-- The file input field used as target for the file upload widget -->
            <input id="fileupload9" type="file" name="files[]" multiple /> 
           <input type="hidden" name="s9" id="s9" />  </span>
        	 <div id="progress9" class="progress primary">
             	<div class="progress-bar progress-bar-primary">
        	 <?php
	  }
	   else
	  {
		  $qc99=mysqli_query($mysqli,"select id_berkas from berkas where id_pegawai=$idp and id_kat=26 and ket_berkas like '$ket' ");
	  $cek99=mysqli_fetch_array($qc99);
	  
	  mysqli_query($mysqli,"update ijin_belajar set kkg=$cek99[0] where id=$ij[0]");
	  echo("Syarat Sudah Tersedia");
	  echo("<input type=hidden name=s9 id=s9 value=1 />");
	  }
	  ?></td>
    </tr>
    <?php
	}
	?>
	
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="left"><input type="button" name="button" id="button" value="Ajukan" onclick="validate();" /></td>
    </tr>
  </table>
</form>
<br/>
<b>*) Jika file / berkas lebih dari satu, sebaiknya disatukan menjadi file dengan format pdf. </b>
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
function validate() {

	var sy1 = document.getElementById("s1").value;
	var sy2 = document.getElementById("s2").value;
	var sy3 = document.getElementById("s3").value;
	var sy4 = document.getElementById("s4").value;
	var sy5 = document.getElementById("s5").value;
	var sy6 = document.getElementById("s6").value;
	var sy7 = document.getElementById("s7").value;
	
	var guru = document.getElementById("guru").value;
	
if(guru=='Guru')
{	
var sy8 = document.getElementById("s8").value;
	var sy9 = document.getElementById("s9").value;
if(sy1==1 && sy2==1 && sy3==1 && sy4==1 && sy5==1 && sy6==1 && sy7==1 && sy8==1 && sy9==1) 
	document.getElementById("form1").submit();
	else
{
	
if(sy1==0)
var m1 = 'Surat Pengantar dari Unit Kerja \n';
else
var m1 = '';
if(sy2==0)
var m2 = 'Surat Pernyataan yang Ditandatangani oleh Atasan Langsung \n';
else
var m2 ='';
if(sy3==0)
var m3 = 'SK Pangkat Terakhir / SK Pengangkatan PNS \n';
else
var m3 ='';
if(sy4==0)
var m4 = 'DP3 / Penilaian Prestasi Kerja Tahun Terakhir  \n';
else
var m4 ='';
if(sy5==0)
var m5 = 'Ijazah Pendidikan Terakhir \n';
else
var m5 ='';
if(sy6==0)
var m6 = 'Surat Keterangan Diterima / Masih Kuliah dari Perguruan Tinggi \n';
else
var m6 ='';
if(sy7==0)
var m7 = 'Jadwal Perkuliahan Yang Masih Berlaku \n';
else
var m7 ='';
if(sy8==0)
var m8 = 'Jadwal Mengajar di Sekolah yang Bersangkutan (Khusus Guru) \n';
else
var m8 ='';
if(sy9==0)
var m9 = 'Kajian Kebutuhan Guru (untuk Guru S1 atau S2)  \n';
else
var m9 ='';
			
	
	
	alert(m1+m2+m3+m4+m5+m6+m7+m8+m9+'Belum Diupload');	
	
	
}
}
else
{
	if(sy1==1 && sy2==1 && sy3==1 && sy4==1 && sy5==1 && sy6==1 && sy7==1) 
	document.getElementById("form1").submit();
	else
{
	
if(sy1==0)
var m1 = 'Surat Pengantar dari Unit Kerja \n';
else
var m1 = '';
if(sy2==0)
var m2 = 'Surat Pernyataan yang Ditandatangani oleh Atasan Langsung \n';
else
var m2 ='';
if(sy3==0)
var m3 = 'SK Pangkat Terakhir / SK Pengangkatan PNS \n';
else
var m3 ='';
if(sy4==0)
var m4 = 'DP3 / Penilaian Prestasi Kerja Tahun Terakhir  \n';
else
var m4 ='';
if(sy5==0)
var m5 = 'Ijazah Pendidikan Terakhir \n';
else
var m5 ='';
if(sy6==0)
var m6 = 'Surat Keterangan Diterima / Masih Kuliah dari Perguruan Tinggi \n';
else
var m6 ='';
if(sy7==0)
var m7 = 'Jadwal Perkuliahan Yang Masih Berlaku \n';
else
var m7 ='';

			
	
	
	alert(m1+m2+m3+m4+m5+m6+m7+	'Belum Diupload');
}
	}

}

$(function () {
	
	
	
	
    'use strict';
    // Change this to the location of your server-side upload handler:
    var url = window.location.hostname === 'blueimp.github.io' ?
                '//jquery-file-upload.appspot.com/' : 'uploader.php?idkat=21&tp=<?php echo($tp["$ibe[0]"]); ?>&idp=<?php echo($idp); ?>';
    $('#fileupload1').fileupload({
        url: url,
		paramName: 'files[]',
        dataType: 'json',
        done: function (e, data) {
            $.each(data.result.files, function (index, file) {
                $('<p/>').text(file.name).appendTo('#files');
				$('#s1').val(1);
				
            });
        },
        progressall: function (e, data) {
            var progress = parseInt(data.loaded / data.total * 100, 10);
            $('#progress1 .progress-bar').css(
                'width',
                progress + '%'
            );
        }
    })
	
	//surat atasan langsung
 var url2 = window.location.hostname === 'blueimp.github.io' ?
                '//jquery-file-upload.appspot.com/' : 'uploader.php?idkat=22&tp=<?php echo($tp["$ibe[0]"]); ?>&idp=<?php echo($idp); ?>';
    $('#fileupload2').fileupload({
        url: url2,
        dataType: 'json',
		paramName: 'files[]',
        done: function (e, data) {
            $.each(data.result.files, function (index, file) {
                $('<p/>').text(file.name).appendTo('#files');
				$('#s2').val(1);
            });
        },
        progressall: function (e, data) {
            var progress = parseInt(data.loaded / data.total * 100, 10);
            $('#progress2 .progress-bar').css(
                'width',
                progress + '%'
            );
        }
    })

//

//SK pangkat terakhir
 var url3 = window.location.hostname === 'blueimp.github.io' ?
                '//jquery-file-upload.appspot.com/' : 'uploader.php?idkat=2&tp=<?php echo($tp["$ibe[0]"]); ?>&idp=<?php echo($idp); ?>';
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

//dp3
 var url4 = window.location.hostname === 'blueimp.github.io' ?
                '//jquery-file-upload.appspot.com/' : 'uploader.php?idkat=20&tp=<?php echo($tp["$ibe[0]"]); ?>&idp=<?php echo($idp); ?>';
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

//ijasah terakhir
 var url5 = window.location.hostname === 'blueimp.github.io' ?
                '//jquery-file-upload.appspot.com/' : 'uploader.php?idkat=3&tp=<?php echo($tp["$ibe[0]"]); ?>&idp=<?php echo($idp); ?>';
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


//terima mahasiswa
 var url6 = window.location.hostname === 'blueimp.github.io' ?
                '//jquery-file-upload.appspot.com/' : 'uploader.php?idkat=23&tp=<?php echo($tp["$ibe[0]"]); ?>&idp=<?php echo($idp); ?>';
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

//jadwal kuliah
 var url7 = window.location.hostname === 'blueimp.github.io' ?
                '//jquery-file-upload.appspot.com/' : 'uploader.php?idkat=24&tp=<?php echo($tp["$ibe[0]"]); ?>&idp=<?php echo($idp); ?>';
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

//

//jadwal mengajar
 var url8 = window.location.hostname === 'blueimp.github.io' ?
                '//jquery-file-upload.appspot.com/' : 'uploader.php?idkat=25&tp=<?php echo($tp["$ibe[0]"]); ?>&idp=<?php echo($idp); ?>';
    $('#fileupload8').fileupload({
        url: url8,
        dataType: 'json',
        done: function (e, data) {
            $.each(data.result.files, function (index, file) {
                $('<p/>').text(file.name).appendTo('#files');
				$('#s8').val(1);
            });
        },
        progressall: function (e, data) {
            var progress = parseInt(data.loaded / data.total * 100, 10);
            $('#progress8 .progress-bar').css(
                'width',
                progress + '%'
            );
        }
    })

//


//jadwal mengajar
 var url9 = window.location.hostname === 'blueimp.github.io' ?
                '//jquery-file-upload.appspot.com/' : 'uploader.php?idkat=26&tp=<?php echo($tp["$ibe[0]"]); ?>&idp=<?php echo($idp); ?>';
    $('#fileupload9').fileupload({
        url: url9,
        dataType: 'json',
        done: function (e, data) {
            $.each(data.result.files, function (index, file) {
                $('<p/>').text(file.name).appendTo('#files');
				$('#s9').val(1);
            });
        },
        progressall: function (e, data) {
            var progress = parseInt(data.loaded / data.total * 100, 10);
            $('#progress9 .progress-bar').css(
                'width',
                progress + '%'
            );
        }
    })

//
	
	.prop('disabled', !$.support.fileInput)
        .parent().addClass($.support.fileInput ? undefined : 'disabled');
});
</script>
