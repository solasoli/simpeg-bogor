<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<style type="text/css">
<!--
body,td,th {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 12px;
}
-->
</style></head>

<body>
<?php

	$sql = "select concat(gelar_depan,' ',nama,' ',gelar_belakang) as nama,tgl from id_card inner join pegawai on pegawai.id_pegawai=id_card.id_pegawai order by nama";
	


?>
<table class="table bordered hovered" id="uklist" width="300px" cellpadding="5" cellspacing="0" border="0" align="center">
<tr><td width="200">Nama</td><td width="100">Tanggal Cetak </td></tr>
<?php

		$var = $this->db->query($sql);
		
		foreach ($var->result() as $label)
		{
		
		$t1=substr($label->tgl,8,2);
		$b1=substr($label->tgl,5,2);
		$th1=substr($label->tgl,0,4);
		
	echo("<tr><td>$label->nama </td> <td>$t1-$b1-$th1</td> </tr>");
		}
		
?>
</table>
<script>

	$(document).ready(function(){
		
		$('#uklist').dataTable();
	});
</script>
</body>
</html>
