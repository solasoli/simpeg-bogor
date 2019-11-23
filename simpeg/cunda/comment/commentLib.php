<?php
require_once("../../konek.php");

function getImage($id_pegawai, $childComment)
{	
	if(file_exists("../../foto/$id_pegawai.jpg"))
	{
		if(!$childComment){			
			return "<img width='75' src='foto/$id_pegawai.jpg' />";
		}
		else
			return "<img width='50' src='foto/$id_pegawai.jpg' />";
	}
	else
	{
		$result = mysqli_query($mysqli, "SELECT jenis_kelamin FROM pegawai WHERE id_pegawai = '".$id_pegawai."'");
		$r = mysqli_fetch_array($result);
		
		if($r[0] == '1')
			if($childComment)
				return "<img width='50' src='images/male.jpg' />";
			else
				return "<img width='75' src='images/male.jpg' />";
		else
			if($childComment)
				return "<img width='50' src='images/female.jpg' />";
			else
				return "<img width='75' src='images/female.jpg' />";
	}
}

function displayDate($postedDate)
{	
	date_default_timezone_set('Asia/Jakarta');
	$currentTime = Date("Y-m-d H:i:s");
	
	//return $currentTime;
	//exit;
	// Jika diposting hari ini.
	if(substr($currentTime, 0, 10) == substr($postedDate, 0, 10))
	{		
		//echo $currentDate->format("H")."---".$postedDate->format("H");
		
		$a = substr($currentTime, 11, 2);
		$b = substr($postedDate, 11, 2);
		
		$hour = $a - $b;
				
		
		$a = substr($currentTime, 14, 2);
		$b = substr($postedDate, 14, 2);
		
		$minute = $a - $b;

		$returnedVal = "";

		if($hour != 0)
			$returnedVal = $hour." jam yang lalu.";
		else if($minute != 0)
			$returnedVal = $minute." menit yang lalu.";
		else
			$returnedVal = "Kurang dari satu menit yang lalu";
			
		return $returnedVal;
	}
	else
	{
		return substr($postedDate, 0, 16);
	}
}

function _displayDate($postedDate2)
{	
	echo Date("Y-m-d H:i:s")."<br/>";
	$currentDate = new DateTime();
	$postedDate = new DateTime($postedDate2);
		
	$interval = $currentDate->diff($postedDate);
	
	$currentDate = new DateTime();
	$postedDate = new DateTime($postedDate2);
	
	$displayDate = $currentDate->sub($interval);
	
	$currentDate = new DateTime();
	$postedDate = new DateTime($postedDate2);
	//return $displayDate->format('Y-m-d');
	// Jika diposting hari ini.
	if($currentDate->format("Y-m-d") == $postedDate->format("Y-m-d"))
	{		
		//echo $currentDate->format("H")."---".$postedDate->format("H");
		$a = $currentDate->format("H");
		$b = $postedDate->format("H");
		
		$hour = $a - $b;

		
		$a = $currentDate->format("i");
		$b = $postedDate->format("i");
		
		$minute = $a - $b;

		$returnedVal = "";
		//echo "$hour jam $minute minit";
		if($hour != 0)
			$returnedVal = $hour." jam yang lalu.";
		else if($minute != 0)
			$returnedVal = $minute." menit yang lalu.";
		else
			$returnedVal = "Kurang dari satu menit yang lalu";
			
		return $returnedVal;
	}
	else
	{
		return $postedDate->format('d/m/y h:i');
	}
}
?>
