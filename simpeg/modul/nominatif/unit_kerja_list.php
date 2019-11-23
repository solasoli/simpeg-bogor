<?php
require_once("../../konek.php");
require_once "../../class/unit_kerja.php";

$unit_kerja = new Unit_kerja;

$id_skpd = $_POST['id_skpd'];


$uks = $unit_kerja->get_unit_kerja_by_skpd($id_skpd);

//print_r($uks);


foreach($uks as $uk){
	
	echo "<option value='".$uk->id_unit_kerja."'>".$uk->nama_baru."</option>";
}

