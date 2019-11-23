<?php

require_once "../../class/duk.php";

$duk = new Duk;

if(isset($_POST['id_skpd']) || $_POST['id_skpd'] > 0){
	
	if(isset($_POST['id_unit_kerja'])){
		
		if($duk->regenerate($_POST['id_skpd'],$_POST['id_unit_kerja'])){
			echo "berhasil menghitung ulang DUK unit kerja : ".$_POST['id_unit_kerja'];
		}else{
			echo "gagal menghitung ulang DUK unit kerja : ".$_POST['id_unit_kerja'];
		}
	}else{
		
		if($duk->regenerate($_POST['id_skpd'])){
			echo "berhasil menghitung ulang DUK skpd : ".$_POST['id_skpd'];
		}else{
			echo "gagal menghitung ulang DUK skpd : ".$_POST['id_skpd'];
		}
				
	}
}else{
	
	if($duk->regenerate()){
		echo "berhasil menghitung ulang DUK Kota Bogor";
	}else{
		echo "gagal menghitung ulang DUK Kota Bogor";
	}
}

