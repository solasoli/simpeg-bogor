<?php
include("../../konek.php");

$query = "update pegawai set status_aktif = 'Aktif' where id_pegawai = ".$_POST['id_pegawai'];

if(mysqli_query($mysqli, $query)){
  echo "UPDATE_SUCCESS";
}else{
  echo "UPDATE_GAGAL";
}
