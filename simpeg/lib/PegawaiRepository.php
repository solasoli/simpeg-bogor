<?php

if(file_exists("konek.php"))
	include_once "konek.php";

function getSkPangkatTerakhir($id_pegawai){
	$q = "SELECT * 
		  FROM sk s
		  WHERE s.id_kategori_sk = 5
		  	AND s.id_pegawai = $id_pegawai
		  ORDER BY MAX(s.tmt)";
		  
	$q = mysql_query($q);
	if(mysql_num_rows($q) > 0)
	{
		return mysql_fetch_array($q);
	}
	else
	{
		return '';	
	}
}

function countPegawaiBySkpdAndGolongan($id_unit_kerja, $golongan){
  $q = "SELECT COUNT(*)
        FROM current_lokasi_kerja c
        INNER JOIN pegawai p 
          ON c.id_pegawai = p.id_pegawai
        WHERE c.id_unit_kerja = '$id_unit_kerja'
          AND p.pangkat_gol = '$golongan'";
  //echo $q;
  $q = mysql_query($q);
  $q = mysql_fetch_array($q);
  return $q[0];
}





function countPegawaiBySkpdAndUsiaBelow($id_unit_kerja, $usia)
{
  $q = "SELECT COUNT(*)
        FROM current_lokasi_kerja c
        INNER JOIN pegawai p 
          ON c.id_pegawai = p.id_pegawai
        WHERE c.id_unit_kerja = '$id_unit_kerja'
          AND FLOOR((DATEDIFF(CURDATE(), p.tgl_lahir)/365)) < $usia";
  //echo $q;
  $q = mysql_query($q);
  $q = mysql_fetch_array($q);
  return $q[0];
}

function countPegawaiBySkpdAndUsiaGreater($id_unit_kerja, $usia)
{
  $q = "SELECT COUNT(*)
        FROM current_lokasi_kerja c
        INNER JOIN pegawai p 
          ON c.id_pegawai = p.id_pegawai
        WHERE c.id_unit_kerja = '$id_unit_kerja'
          AND FLOOR((DATEDIFF(CURDATE(), p.tgl_lahir)/365)) > $usia";
  //echo $q;
  $q = mysql_query($q);
  $q = mysql_fetch_array($q);
  return $q[0];
}

function countPegawaiBySkpdAndUsiaBetween($id_unit_kerja, $start, $end)
{
  $q = "SELECT COUNT(*)
        FROM current_lokasi_kerja c
        INNER JOIN pegawai p 
          ON c.id_pegawai = p.id_pegawai
        WHERE c.id_unit_kerja = '$id_unit_kerja'
          AND FLOOR((DATEDIFF(CURDATE(), p.tgl_lahir)/365)) BETWEEN $start AND $end";
  //echo $q;
  $q = mysql_query($q);
  $q = mysql_fetch_array($q);
  return $q[0];
}

function countPegawaiBySkpdAndGender($id_unit_kerja, $gender){
	$q = "SELECT COUNT(*)
		  FROM current_lokasi_kerja c 
		  INNER JOIN pegawai p 
			ON c.id_pegawai = p.id_pegawai		  
		  WHERE c.id_unit_kerja = '$id_unit_kerja'
			AND p.jenis_kelamin = '$gender'";
	$q = mysql_query($q);
	if(mysql_num_rows($q) > 0)
	{
		$r = mysql_fetch_array($q);
		return $r[0];
	}
	else
	{
		return '';	
	}
}

function getKenaikanPangkatBerikutnya($idPegawai){

}

function getNamaPegawaiLike($nama){
	$q = "SELECT nama 
		  FROM pegawai 
		  WHERE nama LIKE '%$nama%'";
	
	$q = mysql_query($q);
	
	if(mysql_num_rows($q) > 0){
		return $q;	
	}
	else{
		return '';
	}
}

?>