<?php

class Stat_class{
	
	public function getByGolongan(){
		
		$stat = array();
		$sql = "SELECT count( * ) as jumlah, golongan  as pangkat_gol
				FROM pegawai
				inner join view_pangkat_terakhir vpt on vpt.id_pegawai = pegawai.id_pegawai
				where flag_pensiun = 0				
				GROUP BY golongan";
				
		$results = mysql_query($sql);
		
		while($result =  mysql_fetch_object($results)){
			$stat[] = $result;	
		}
		
		return $stat;
	}
}
