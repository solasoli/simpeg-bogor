<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
<style type="text/css">
<!--
body,td,th {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	color: #000099;
}
-->
</style>

<script type="text/javascript" src="jquery.js">
</script>

<script type="text/javascript">
$(document).ready(function(){
	$("#u").change(function(){
		$("#content").html("<div align=center style='background-color:white'>Loading...</div>");
		$.post('analisis_process.php', { id:$("#u").val() }, function(data){
			$("#content").html(data);
		});
	});
});
</script>


</head>

<body>


<?


include("konek.php"); 
$q=mysql_query("select jabatan.id_unit_kerja,nama_baru from jabatan inner join unit_kerja on unit_kerja.id_unit_kerja=jabatan.id_unit_kerja where nama_baru not like 'sma%' and  nama_baru not like 'smp%' and  nama_baru not like 'smk%' and nama_baru not like 'UPTD%'  group by nama_baru");
?>
<form id="form1" name="form1" method="post" action="struktur.php">
  <label>
  <div align="center">
    <select name="u" id="u">
      <?
  while($data=mysql_fetch_array($q))
  {
  
  if($u==$data[0])
    echo("<option value=$data[0] selected>$data[1]</option>");
	else
	echo("<option value=$data[0]>$data[1]</option>");
	
	
	
	}
  ?>
      
    </select>
    <input type="submit" name="Submit" value="Tampilkan" />
  </div>
  </label>
  <label></label>
</form>
<div id="content" >
</div>
</body>
</html>
