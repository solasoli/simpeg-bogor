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
.judul {
	font-weight: bold;
}
</style>
</head>

<body onload="window.print(),window.close();">

  <table width="90%" border="0" align="center" cellpadding="5" cellspacing="0">
   
    <tr>
      <td align="center" class="judul">REKAPITULASI PENERBITAN SURAT IZIN BELAJAR PEGAWAI NEGERI SIPIL<BR />
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
		 </td>
    <tr>
      <td>
      <?php
	  if(!empty($list))
	  {
		  ?>
	 
     
      <form name="form2" id="form2" method="post" action="cetak_daftar" >
      <table width="100%" border="1" cellspacing="0" cellpadding="5" bordercolor="#000">
        <tr>
          <td align="center">No</td>
          <td align="center">NAMA</td>
          <td align="center">NIP</td>
          <td align="center">PANGKAT / GOL RUANG</td>
          <td align="center">UNIT KERJA</td>
          <td align="center">PROGRAM STUDI</td>
        </tr>
        <?php
		$i=1;
		 foreach($list as $l)
	  {
		  ?>
        <tr>
          <td><?=$i ?></td>
          <td><?php echo strtoupper($l->nama); ?></td>
          <td><?=$l->nip_baru ?></td>
          <td><?=$l->pangkat_gol ?></td>
          <td><?=$l->nama_baru ?></td>
          <td>Program <?php echo("  $l->program ($l->tp2) Program Studi $l->jp2 $l->ip2 ");?></td>
        </tr>
        <?php
	  }
	  $i++;
	  ?>
      
      </table>
      
       
      <?
	  }
	  ?>
      
      </td>
    </tr>
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
   
   echo "<span style='text-decoration:underline'>".$kabid->nama_lengkap."</span><br>".$kabid->nip_baru ;
   
   
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