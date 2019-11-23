<?php
		include_once "db.php";
		include_once "pegawai.php";
		include_once "IndoDateTime.php";
		
		$q = mysql_query("SELECT p.id_pegawai, p.nama, p.nip_baru, p.pangkat_gol, p.tempat_lahir, p.tgl_lahir
			FROM pegawai p
			ORDER BY p.pangkat_gol DESC"); 
	
		$no = 1;
		$result = '';
		while($r = mysql_fetch_array($q)){
					
			$result[$no]["no"] = $no;
			$result[$no]["nama"] = $r["nama"];
			$result[$no]["nip"] = $r["nip_baru"];
			
			$tgl_lahir = new IndoDateTime($r["tgl_lahir"]);
			$result[$no]["ttl"] = $r["tempat_lahir"].", ".$tgl_lahir->format("F");

			$result[$no]["pangkat"] = pangkat($r["pangkat_gol"]);									
			$result[$no]["gol"] = $r["pangkat_gol"];
			
			$result[$no]["pendidikan"] = pendidikan_terakhir($r["id_pegawai"]);
			
			$result[$no]["tmt_pangkat"] = tmt_pangkat_terakhir($r["id_pegawai"]);
						
			// Jabatan Pangkat Belum didefinisikan!!!!!!!!!
			$result[$no]["jabatan"] = jabatan_terakhir($r["id_pegawai"]);
			
			$result[$no]["201104"] = kenaikan_pangkat(2011, 4, $r[id_pegawai]);
			$result[$no]["201110"] = kenaikan_pangkat(2011, 10, $r[id_pegawai]);
			$result[$no]["201204"] = kenaikan_pangkat(2012, 4, $r[id_pegawai]);
			$result[$no]["201210"] = kenaikan_pangkat(2012, 10, $r[id_pegawai]);
			$result[$no]["201304"] = kenaikan_pangkat(2013, 4, $r[id_pegawai]);
			$result[$no]["201310"] = kenaikan_pangkat(2013, 10, $r[id_pegawai]);
			$result[$no]["201404"] = kenaikan_pangkat(2014, 4, $r[id_pegawai]);
			$result[$no]["201410"] = kenaikan_pangkat(2014, 10, $r[id_pegawai]);
			$result[$no]["201504"] = kenaikan_pangkat(2015, 4, $r[id_pegawai]);
			$result[$no]["201510"] = kenaikan_pangkat(2015, 10, $r[id_pegawai]);
			$result[$no]["201604"] = kenaikan_pangkat(2016, 4, $r[id_pegawai]);
			$result[$no]["201610"] = kenaikan_pangkat(2016, 10, $r[id_pegawai]);
			$result[$no]["201704"] = kenaikan_pangkat(2017, 4, $r[id_pegawai]);
			$result[$no]["201710"] = kenaikan_pangkat(2017, 10, $r[id_pegawai]);
			
			$no++;
		}
		//print_r($result);
?>