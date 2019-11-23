<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<style type="text/css">

.satu {
	font-family: Verdana, Geneva, sans-serif;
	font-size: 14px;
	color: #00C;
}
</style>
<?
$jawab=0;
extract($_POST);
extract($_GET);
$chat=$_REQUEST['chat'];
$gw=$_REQUEST['gw'];
include("konek.php");
$skr=date("Y-m-d");
if($jawab==1)
mysqli_query($mysqli,"update chat set dijawab=1 where id_ngajak=$gw and id_diajak=$chat and start_chat like '$skr%'");


?>
<script src="jquery-1.4.js"></script>

<script>
  $(document).ready(function() {
    setInterval(function() {
	     $('#tampilkan').load('conversation.php?gw=<? echo($gw); ?>&chat=<? echo($chat); ?>&acak='+ Math.random());
    }, 1000);
  });
</script>

<script>    
$(document).ready(function(){
 $('#nama').keypress(function(e) {
 if(e.keyCode == 13) {

   var nama = $('#nama').val(); 
   $.ajax({
    type:"POST",
    url:"nongol.php",    
    data: 'nama=' + nama+"&gw=<? echo($gw); ?>&chat=<? echo($chat); ?>&user=<? echo($_SESSION['user']); ?>",        
    success: function(html){                 
      //$('#tampilkan').html(html);
	  $('#nama').val("");
    }  
   });
 }
  });
});
</script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<style type="text/css">
.lwbar {
	position:absolute;
	width: 600;
}
a:link {
	text-decoration: none;
}
a:visited {
	text-decoration: none;
}
a:hover {
	text-decoration: none;
}
a:active {
	text-decoration: none;
}
</style>
</head>

<body>

<table width="100%" border="0" cellspacing="0" cellpadding="5">
<?
/*
$qklik=mysqli_query($mysqli,"select id_diajak,id_ngajak from chat where (id_diajak!=$chat and id_ngajak!=$chat) and (id_diajak=$gw or id_ngajak=$gw) and start_chat like '$skr%' and dijawab=1" ); 


$qu = mysqli_query($mysqli,"select id_pegawai,nama from pegawai where nip_lama='$_SESSION[user]' or nip_baru='$_SESSION[user]'");
		$ata = mysqli_fetch_array($qu);
		
		while($otoy=mysqli_fetch_array($qklik))
		{
			
		if($ata[0]==$otoy[0])
		$conv=$otoy[1];
		else
		$conv=$otoy[0];
		
		$qcon = mysqli_query($mysqli,"select id_pegawai,nama from pegawai where id_pegawai=$conv");
		$at = mysqli_fetch_array($qcon);
	if(file_exists("./foto/$at[0].jpg")) 
				$kupret="<img src=./foto/$at[0].jpg width=25 hspace=5 border =0/>";	
	echo("  <tr >
    <td align=center valign=middle><div id=menu_bg> <a href=index2.php?x=modchat.php&chat=$ata[0]&gw=$at[0] > <strong> $kupret lanjutkan percakapan dengan $at[1] </strong></a></div> </td>
  </tr>");
			
			
		}*/
?>
  <tr>
    <td><div id="tampilkan"> </div></td>
  </tr>
  <tr>
    <td>
      <label for="nama"></label>
      <label for="nama2"></label>
      <textarea name="nama" rows="2" class="lwbar" id="nama" ></textarea></td>
  </tr>
</table>

 
</p>
</body>
</html>