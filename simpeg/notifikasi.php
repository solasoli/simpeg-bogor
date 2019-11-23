<?
session_start();
//include("konek.php");
$nip=$_SESSION['user'];
$qjo=mysqli_query($mysqli,"select nip_baru from pegawai where nip_lama='$_SESSION[user]' or nip_baru='$_SESSION[user]'");
$jo=mysqli_fetch_array($qjo);
	require_once "PensiunBO.php";

	require_once "GolonganPangkatBO.php";

	$isAnyNotifikasi = false;

	

	$pensiunBO = new PensiunBO($ata[7], $ata[18]);

	$golPangkatBO = new GolonganPangkatBO($ata[14]);

	

	$note = $golPangkatBO->notifyKenaikanPangkat();

	if($note != "")

	{

		echo "$note<br/>";

	}

	

	if($pensiunBO->warnPensiun(6))

	{

		$tanggalPensiun = $pensiunBO->getTanggalPensiun();

		$estimasi = getMonth($tanggalPensiun) - date("m");

		

		echo "<font color='red'>Anda akan memasuki masa pensiun $estimasi bulan lagi.<br/></font>";

		

		$isAnyNotifikasi = true;

	}

	else if($pensiunBO->isCanPensiunDini())

	{

		echo "<font color='red'>Anda sudah dapat mengajukan pensiun dini.<br/></font>";

		

		$isAnyNotifikasi = true;

	}

	

	

	

	if($isAnyNotifikasi != true)

	{

		echo "Tidak ada notifikasi";

	}

?>