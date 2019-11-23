<?php
		include_once "db.php";
		include_once "IndoDateTime.php";
		include_once "pegawai.php";
		
		$q = mysql_query("SELECT p.id_pegawai, p.nama, p.nip_baru, p.tempat_lahir, p.tgl_lahir, p.pangkat_gol
			FROM pegawai p
			ORDER BY p.tgl_lahir ASC, p.pangkat_gol DESC, p.nama ASC"); 
		
		$no = 1;
		$result = '';
		while($r = mysql_fetch_array($q)){
			$result[$no]["no"] = $no;
			$result[$no]["nama"] = $r["nama"];
			$result[$no]["nip"] = $r["nip_baru"];
			
			$tl = new IndoDateTime($r["tgl_lahir"]);
			$result[$no]["ttl"] = $r["tempat_lahir"].", ".$tl->format("F");
			
			// PERHITUNGAN TMT Pensiun
			$tmt_pensiun = "1-".($tl->getMonth() + 1)."-".($tl->getYear() + 56);
			$result[$no]["tmt_pensiun"] = $tmt_pensiun;
			
			$result[$no]["pangkat"] = $r["pangkat_gol"];
			
			
			$result[$no]["jabatan"] = jabatan_terakhir($r["id_pegawai"]);
			
			$no++;
		}
		
?>