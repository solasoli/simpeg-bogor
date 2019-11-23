<?php
		include_once "db.php";
		include_once "pegawai.php";
		
		$q = mysql_query("SELECT p.id_pegawai, p.nama, p.nip_baru, p.pangkat_gol
			FROM pegawai p
			ORDER BY p.pangkat_gol DESC"); 
		
		$no = 1;
		$result = '';
		while($r = mysql_fetch_array($q)){
			$result[$no]["no"] = $no;
			$result[$no]["nama"] = $r["nama"];
			$result[$no]["nip"] = $r["nip_baru"];
			
			// TMT Pangkat Belum didefinisikan!!!!!!!!!
			$result[$no]["tmt_pangkat"] = tmt_pangkat_terakhir($r["id_pegawai"]);
			
			
			$result[$no]["golongan_ruang"] = $r["pangkat_gol"];
			$result[$no]["2011"] = tmt_kgb(2011, $r[nip_baru]);
			$result[$no]["2012"] = tmt_kgb(2012, $r[nip_baru]);
			$result[$no]["2013"] = tmt_kgb(2013, $r[nip_baru]);
			$result[$no]["2014"] = tmt_kgb(2014, $r[nip_baru]);
			$result[$no]["2015"] = tmt_kgb(2015, $r[nip_baru]);
			$result[$no]["2016"] = tmt_kgb(2016, $r[nip_baru]);
			$result[$no]["2017"] = tmt_kgb(2017, $r[nip_baru]);
			$no++;
		}
		//print_r($result);
?>