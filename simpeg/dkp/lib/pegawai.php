<?php
include_once "IndoDateTime.php";

function tmt_kgb($tahun, $nip_baru) {
	$cpns = substr($nip_baru, 8, 4);
	
	$tmt = ($tahun - $cpns)%2;
	if($tmt){
		return "-";	
	}
	else {
		return "1-".substr($nip_baru, 12, 2)."-".$tahun;
	}	
	
}	

function pangkat($golongan){	
	switch ($golongan) {
            case "I/a":
                return "Juru Muda";
            case "I/b":
                return "Juru Muda Tk.I";
            case "I/c":
                return "Juru";
            case "I/d":
                return "Juru Tk.I";
            case "II/a":
                return "Pengatur Muda";
            case "II/b":
                return "Pengatur Muda Tk.I";
            case "II/c":
                return "Pengatur";
            case "II/d":
                return "Pengatur Tk.I";
            case "III/a":
                return "Penata Muda";
            case "III/b":
                return "Penata Muda Tk.I";
            case "III/c":
                return "Penata";
            case "III/d":
                return "Penata Tk.I";
            case "IV/a":
                return "Pembina";
            case "IV/b":
                return "Pembina Tk.I";
            case "IV/c":
                return "Pembina Utama Muda";
            case "IV/d":
                return "Pembina Utama Madya";
            default:
                return "Pembina Utama";
        }
}

function kenaikan_pangkat($tahun, $bulan, $id_pegawai){
	$tmt = tmt_pangkat_terakhir($id_pegawai);
	$th = substr($tmt, 6, 4);
	$bl = substr($tmt, 3, 2);


		
	
	while($th <= $tahun){
		$th += 4;
		if($th == $tahun){
			/*if($bulan == 4 && $bl < 4)
				return  "01-04-$th";
			elseif($bulan == 4 && ($bl >= 4 && $bl < 10))
				return "01-10-$th";
			elseif($bulan == 10 && (($bl >=4) && ($bl < 10))){
				return "01-10-$th";
			}
			elseif(($bulan == 10) && ($bl <= 4)){
				return "-";
			}
			else{
				$th+=1;
				return "<strong>01-04-$th</strong>";		
			}*/
			if($bulan == 4 && ($bl <=4))
				return "01-04-$th";
			elseif($bulan == 10 && ($bl > 4 && $bl <= 10))
				return "01-10-$th";
			elseif($bulan == 10 && $bl >10 ){
				$th+=1;
				return "<strong>01-04-$th</strong>";			
			}
			else 
				return "-";
		}
		
	}
	return "-";
}

function tmt_pangkat_terakhir($id_pegawai){

	$q  = "SELECT p.nip_baru, p.nama, s.tmt
			FROM pegawai p
			INNER JOIN sk s ON p.id_pegawai = s.id_pegawai 
			WHERE p.id_pegawai = '$id_pegawai' AND s.id_kategori_sk = '5'
			ORDER BY s.tmt DESC
			LIMIT 0,1"
			;
   
   $q = mysql_query($q);
	$r = mysql_fetch_array($q);
	$d = new IndoDateTime($r["tmt"]);
	if($d->getDay() != '')
	{
		return $d->getDay()."-".$d->getMonth()."-".$d->getYear();
	}	
	else {
		$q = mysql_query("SELECT nip_baru FROM pegawai p 
								WHERE p.id_pegawai = $id_pegawai");	
		$r = mysql_fetch_array($q);
		if(strlen($r["nip_baru"] > 10)){
			$tmt = substr($r["nip_baru"], 8, 4);
			$tmb = substr($r["nip_baru"], 12, 2);

			while($tmt < date("Y")){
				$tmt += 4;
			}
			if($tmt > date("Y"))
					$tmt -= 4;
			if($tmb < 4)
				$tmb = "04";
			elseif($tmb >= 10 )	
			{
				$tmb = "04";
				$tmt += 1;		
			}
			else
				$tmb = "10";
			return "01-".$tmb."-".$tmt;
		}	
		else
			return "-";
	}
}

function pendidikan_terakhir($id_pegawai){
	$q = "SELECT p.id_pegawai, p2.tingkat_pendidikan
			FROM pegawai p INNER JOIN pendidikan p2 ON p.id_pegawai = p2.id_pegawai
			WHERE p.id_pegawai = $id_pegawai
			ORDER BY p2.level_p ASC
			LIMIT 0,1";
			
	$q = mysql_query($q);
	$r = mysql_fetch_array($q);
	return $r["tingkat_pendidikan"];
}

function jabatan_terakhir($id_pegawai){
	$q = "SELECT j.jabatan 
			FROM riwayat_mutasi_kerja r
			INNER JOIN jabatan j ON j.id_j = r.id_j
			INNER JOIN sk s ON r.id_pegawai = s.id_pegawai
			WHERE r.id_pegawai = $id_pegawai
			ORDER BY r.id_riwayat DESC
			LIMIT 0,1";
	$q = mysql_query($q);
	$r = mysql_fetch_array($q);	
	
	return $r["jabatan"];
}
?>