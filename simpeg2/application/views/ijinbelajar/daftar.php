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
      <td align="center">Daftar Pengajuan Ijin Belajar</td>
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
	  if(!empty($list))
	  {
		  ?>
	 
     
      <form name="form2" id="form2" method="post" action="cetak_daftar" target="_blank" >
      <table width="100%" border="1" cellspacing="0" cellpadding="5" bordercolor="#000">
        <tr>
          <td>No</td>
          <td>NAMA</td>
          <td>NIP</td>
          <td>PANGKAT / GOL RUANG</td>
          <td>UNIT KERJA</td>
          <td>PROGRAM STUDI</td>
        </tr>
        <?php
		$i=1;
		 foreach($list as $l)
	  {
		  ?>
        <tr>
          <td><?=$i ?></td>
          <td><?=$l->nama; ?></td>
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