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

<body>
<form name="form1" action="" method="post">
  <table width="90%" border="0" align="center" cellpadding="5" cellspacing="0">
    <tr>
      <td align="center">Daftar Ijin Belajar Yang Disetujui</td>
    </tr>
    <tr>
      <td align="center">Dari Tanggal
			<span class="span2">
				<span class="input-control text span2" id="datepickerTmtAwal" data-role="datepicker" data-format="yyyy-mm-dd">
					<input type="text" name="txtTmtAwal"
                    <?php
					if(isset($dari))
					echo (" value=$dari ");
					
					?>
                     >
					<span class="btn-date"/></span>
				</span>
			</span>		
				Hingga
			<span class="span2">
				<span class="input-control text span2" id="datepickerTmtAkhir" data-role="datepicker" data-format="yyyy-mm-dd">
					<input type="text" name="txtTmtSelesai"
                                        <?php
					if(isset($sampai))
					echo (" value=$sampai ");
					
					?>

                    
                     >
					<span class="btn-date"/></span>
				</span>
			</span>	<input type="submit" name="button" id="button" value="Tampilkan" />
            
            </form>
            
            </td>
    </tr>
    <tr>
      <td>
      <?php
	  if(!empty($daftar))
	  {
		  ?>
	 
     
      <form name="form2" id="form2" method="post" action="cetak_setuju" target="_blank" >
    <table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" class="table table-bordered table-hover table-striped">
  <tr>
    <td rowspan="2" align="center">No</td>
    <td rowspan="2">Nama</td>
    <td rowspan="2">NIP</td>
    <td rowspan="2" align="center">Golongan</td>
    <td rowspan="2" align="center">Tgl Disetujui</td>
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
	  
	$tgl=substr($d->tgl_approve,8,2);
	$bln=substr($d->tgl_approve,5,2);
	$thn=substr($d->tgl_approve,0,4);
	  
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
	  <td> 
	  <input type=hidden name=surat$i id=surat$i value='$d->nosurat' >
	  
	  </td></tr>");
	 
         
	  
		 
	  
	  $i++;
	  
  }
  ?>
</table>
	
      <br />
       <div align="center">
         <input name="dari" type="hidden" id="dari" value="<?php echo $dari; ?>" />
         <input name="sampai" type="hidden" id="sampai" value="<?php echo $sampai; ?>" />
        <input type="submit" name="button" id="button" value="Cetak" /></div>
      </form>
       
      <?
	  }
	  ?>
      
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