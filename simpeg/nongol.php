<style type="text/css">
body,td,th {
	font-family: Verdana, Geneva, sans-serif;
	font-size: 18px;
}
.satu {
	font-family: Verdana, Geneva, sans-serif;
	font-size: 14px;
	color: #00C;
}

.dua {
	font-family: Verdana, Geneva, sans-serif;
	font-size: 14px;
	color: green;
}
</style>
<?
include("konek.php");
extract($_POST);
$qgw=mysqli_query($mysqli,"select id_pegawai,nama from pegawai where id_pegawai=$gw");
$saya=mysqli_fetch_array($qgw);

$qlo=mysqli_query($mysqli,"select id_pegawai,nama from pegawai where id_pegawai=$chat");
$kamu=mysqli_fetch_array($qlo);

$qu = mysqli_query($mysqli,"select id_pegawai,nama from pegawai where nip_lama='$user' or nip_baru='$user'");
		$ata = mysqli_fetch_array($qu);
		
	


$qcek=mysqli_query($mysqli,"select count(*) from chat where id_ngajak=$gw and id_diajak=$chat");
$cek=mysqli_fetch_array($qcek);

$skr=date("Y-m-d H:i:s");
$potong=substr($skr,0,10);

if($cek[0]==0)


{
	
	if (file_exists("./foto/$ata[0].jpg")) 
				$kupret="<img src=./foto/$ata[0].jpg width=25 hspace=10 />";
	$obrol="<span class=satu>$kupret: $nama </span><br>";
mysqli_query($mysqli,"insert into chat (id_ngajak,id_diajak,start_chat,obroloi) values ($gw,$chat,'$skr','$obrol')");


}
else
{
	$qc=mysqli_query($mysqli,"Select obroloi,id_chat from chat where id_ngajak=$gw and id_diajak=$chat and left(start_chat,10)='$potong'");

$coi=mysqli_fetch_array($qc);
	if (file_exists("./foto/$ata[0].jpg")) 
				$kupret="<img src=./foto/$ata[0].jpg width=25 hspace=10 />";
	$obrol="$coi[0] <span class=satu>$kupret: $nama </span><br>";
mysqli_query($mysqli,"update chat set obroloi='$obrol' where id_chat=$coi[1] ");	
	
	
}
/*

$qc=mysqli_query($mysqli,"Select obroloi from chat where id_ngajak=$gw and id_diajak=$chat and left(start_chat,10)='$skr'");

$coi=mysqli_fetch_array($qc);
echo($coi[0]);
*/

?>