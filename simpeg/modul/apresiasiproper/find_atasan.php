<?php

require_once("../../konek.php");


$term = $_POST['nip'];

$sql = "SELECT pegawai.id_pegawai as id, nip_baru as value,
		IF(LENGTH(pegawai.gelar_belakang) > 1,
        CONCAT(pegawai.gelar_depan,
                ' ',
                pegawai.nama,
                CONCAT(', ', pegawai.gelar_belakang)),
        CONCAT(pegawai.gelar_depan, ' ', pegawai.nama)) AS nama,
		concat(golongan.pangkat,' - ',vpt.golongan) as golongan,
		uk.id_unit_kerja as id_unit_kerja,
		uk.nama_baru as nama_unit_kerja,
		CASE
			WHEN
				(pegawai.jenjab = 'Struktural'
					AND pegawai.id_j IS NOT NULL)
			THEN
				j.jabatan
			WHEN (pegawai.jenjab = 'Fungsional') THEN pegawai.jabatan
			WHEN
				(pegawai.jenjab = 'Struktural'
					AND pegawai.id_j IS NULL)
			THEN
				jm.nama_jfu
		END AS jabatan
		from pegawai
		left join view_pangkat_terakhir vpt on vpt.id_pegawai = pegawai.id_pegawai
		left join golongan on golongan.golongan = vpt.golongan
		inner join current_lokasi_kerja clk on clk.id_pegawai = pegawai.id_pegawai
		inner join unit_kerja uk on uk.id_unit_kerja = clk.id_unit_kerja
		LEFT JOIN
			jabatan j ON j.id_j = pegawai.id_j
		LEFT JOIN
			jfu_pegawai ON jfu_pegawai.id_pegawai = pegawai.id_pegawai
		LEFT JOIN
			jfu_master jm ON jm.kode_jabatan = jfu_pegawai.kode_jabatan
		where (nip_baru = '$term')
		and flag_pensiun != 1
		"
		;


if($result = mysql_query($sql)){

	if($hasil = mysql_fetch_object($result)){
		echo json_encode($hasil);

	}else{
		echo json_encode(array('id'=>0));
	}

}else{
	echo "false";//json_encode(array('id'=>0));
}
/*
while($row = mysql_fetch_array($result)){

	$row_set[] = $row;

}

echo json_encode($row_set);
*/
