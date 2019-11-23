<?php
extract($_GET);

?>
<form id="form1" name="form1" method="post" action="./modul/skp/index.php?page=los2">
  <table width="500" border="0" align="center" cellpadding="5" cellspacing="0" class="table">
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td width="25%">Tanggal diterima Pegawai</td>
      <td width="2%">:</td>
      <td align="left">
      <input type="text" class="form-control datepicker" name="t1" id="t1" /></td>
    </tr>
    <tr>
      <td width="25%">Tanggal diterima Atasan Pejabat yang Menilai</td>
      <td width="2%">:</td>
      <td align="left"><input class="form-control datepicker" type="text" name="t2" id="t2" /></td>
    </tr>
    <tr>
      <td><input name="idp" type="hidden" id="idp" value="<?php echo $idp; ?>" />
      <input name="tahun" type="hidden" id="tahun" value="<?php echo $tahun; ?>" /></td>
      <td>&nbsp;</td>
      <td><input type="submit" name="button" id="button" value="simpan" /></td>
    </tr>
  </table>
</form>

<script>
	
	$(document).ready(function(){
	
		$('.datepicker').datepicker({
			 format: 'yyyy-mm-dd'
		});
	}	
		</script>