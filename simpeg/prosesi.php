<?php 
include("konek.php");

$term = $_GET['term'];


$sql = "select id as id, concat(institusi,' (',tingkat,'-',jurusan,')') as value, akreditasi, tgl_daluwarsa, status_daluwarsa 
			from akreditasi 
			where institusi like '%$term%'
			and tingkat like '%".trim($_GET['pl'])."%'
			and jurusan like '%".trim($_GET['jurusan'])."%'
			and tgl_daluwarsa is not null
			 ";

$result = mysqli_query($mysqli,$sql);
//echo $sql;

while($row = mysqli_fetch_array($result)){

	$row_set[] = $row;

}

echo json_encode($row_set);

