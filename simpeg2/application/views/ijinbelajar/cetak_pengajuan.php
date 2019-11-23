<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<style type="text/css">
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
	font-family: "Segoe UI Light_","Open Sans Light",Verdana,Arial,Helvetica,sans-serif;
font-size: 14px;
}
</style>
</head>

<body onload="window.print(),window.close();">

  <table width="90%" border="0" align="center" cellpadding="5" cellspacing="0">
    <tr>
      <td align="center"><B>REKAPITULASI PENGAJUAN SURAT IZIN BELAJAR PEGAWAI NEGERI SIPIL<BR />
      DI LINGKUNGAN PEMERINTAH KOTA BOGOR DARI TANGGAL  <?php
	  $th1=substr($dari,0,4);
	  $b1=substr($dari,5,2);
	  $t1=substr($dari,8,2);
	  
	  echo("$t1-$b1-$th1");
	    ?> TANGGAL HINGGA <?php
	  $th2=substr($sampai,0,4);
	  $b2=substr($sampai,5,2);
	  $t2=substr($sampai,8,2);
		
		echo("$t2-$b2-$th2");
		 ?>
		 </B>
		 </td>
    </tr>
   
    <tr>
      <td>
      <?php
	  if(!empty($daftar))
	  {
		  ?>
	 
     
      <form name="form2" id="form2" method="post" action="cetak_daftar" target="_blank" >
    <table width="98%" border="1" bordercolor="black" align="center" cellpadding="5" cellspacing="0" class="table table-bordered table-hover table-striped">
  <tr>
    <td rowspan="2" align="center">No</td>
    <td rowspan="2">Nama</td>
    <td rowspan="2">NIP</td>
    <td rowspan="2" align="center">Golongan</td>
    <td rowspan="2" align="center">Tgl Pengajuan</td>
    <td rowspan="2">Jabatan</td>
    <td rowspan="2">OPD</td>
    <td colspan="2" align="center">Pendidikan Terakhir</td>
    <td colspan="2" align="center">Pendidikan Lanjutan</td>
    <td rowspan="2" align="center">Akreditasi</td>
    <td rowspan="2" align="center">Status</td>
    
  </tr>
  <tr>
    <td>Program</td>
    <td>Jurusan</td>
    <td>Program</td>
    <td>Jurusan</td>
    </tr>
  <?php
  $i=1;
  foreach($daftar as $d)
  {
	  
	$tgl=substr($d->tgl_pengajuan,8,2);
	$bln=substr($d->tgl_pengajuan,5,2);
	$thn=substr($d->tgl_pengajuan,0,4);
	  
echo("<tr>  <td> $i</td>
	  <td> $d->nama</td>
	  <td> $d->nip_baru</td>
	  <td align=center> $d->pangkat_gol</td>
	  <td> $tgl-$bln-$thn</td>
	  <td> $d->jfu</td>
	  <td> $d->nama_baru</td>
	  <td align=center> $d->tp</td>
	  <td> $d->jp</td>
	  <td align=center> $d->tp2</td>
	  <td> $d->jp2</td>
	  <td align=center> $d->ip2 ($d->akre)</td>
	  <td> $d->status
	  <input type=hidden name=surat$i id=surat$i value='$d->nosurat' >
	  
	  </td></tr>");
	 
         
	  
		 
	  
	  $i++;
	  
  }
  ?>
</table>
	
      <br />
   
      </form>
       
      <?
	  }
	  ?>
      
      </td>
    </tr>
   <tr>
    <tr>
   <td align="right">
   
   <table width="300" border="0" cellspacing="0" cellpadding="5">
     <tr>
       <td align="center" nowrap="nowrap">KEPALA BIDANG <br />
         MUTASI PEGAWAI
   <br />
   <br />
   <br />
   <br />
   <?php
   
   echo " $kabid->gelar_depan ".strtoupper($kabid->nama)." $kabid->gelar_belakang  ";
   
   ?></td>
     </tr>
   </table>
 
   
   </td>
   </tr>
  </table>



</body>
</html>
<script>
$("input[name='txtTmtAwal']").datepicker({
	  onSelect: function() {
		alert('');
	  }
	});
	
	$("input[name='txtTmtAkhir']").datepicker({
	  onSelect: function() {
		alert('');
	  }
	});
	</script>