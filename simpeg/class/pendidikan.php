<?php

class Pendidikan{
	
	
	
	function get_riwayat_pendidikan($id_pegawai){
		
		$sql = "select * from pendidikan where id_pegawai=$id_pegawai order by level_p";
		
		$result = mysql_query($sql);
		while($r = mysql_fetch_object($result)){
			$pendidikan[] = $r;
		}
		return $pendidikan;
	}
	
}