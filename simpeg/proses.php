<?php 
require_once("konek.php");
$sql = "SELECT pegawai.id_pegawai as id, nip_baru as value, 
		IF(LENGTH(pegawai.gelar_belakang) > 1,
        CONCAT(pegawai.gelar_depan,
                ' ',
                pegawai.nama,
                CONCAT(', ', pegawai.gelar_belakang)),
        CONCAT(pegawai.gelar_depan, ' ', pegawai.nama)) AS nama, 
		concat(golongan.pangkat,' - ',vpt.golongan) as golongan,
		vpt.tmt,
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
		END AS jabatan,
		uk.nama_baru as opd,
		pt.tingkat_pendidikan,
		pt.jurusan_pendidikan as jurusan,
		pt.lembaga_pendidikan as institusi		
		from pegawai
		inner join view_pangkat_terakhir vpt on vpt.id_pegawai = pegawai.id_pegawai
		inner join golongan on golongan.golongan = vpt.golongan
		inner join current_lokasi_kerja clk on clk.id_pegawai = pegawai.id_pegawai
		inner join unit_kerja uk on uk.id_unit_kerja = clk.id_unit_kerja
		inner join pendidikan_terakhir pt on pt.id_pegawai = pegawai.id_pegawai
		LEFT JOIN
			jabatan j ON j.id_j = pegawai.id_j
		LEFT JOIN
			jfu_pegawai ON jfu_pegawai.id_pegawai = pegawai.id_pegawai
		LEFT JOIN
			jfu_master jm ON jm.kode_jabatan = jfu_pegawai.kode_jabatan
		where (nip_baru = '".$_POST['nip']."')
		and flag_pensiun = 0 and uk.id_skpd = '".$_POST['id_skpd']."'
		"	
		;		
	
if($result = mysqli_query($mysqli,$sql)){
	
	if($hasil = mysqli_fetch_object($result)){
		echo json_encode($hasil);
	}else{
		echo json_encode(array('id'=>0));
	}
	
}else{
	echo $sql;//json_encode(array('id'=>0));
}		
		
/*
include("konek.php");

$k=mysqli_query($mysqli,"select nama,
			nip_baru,
			pangkat_gol,
			jabatan,nama_baru,
			pegawai.id_pegawai 
		from pegawai 
		inner join current_lokasi_kerja on current_lokasi_kerja.id_pegawai=pegawai.id_pegawai 
		inner join unit_kerja on unit_kerja.id_unit_kerja=current_lokasi_kerja.id_unit_kerja 
		where flag_pensiun=0 and nip = '"$_POST['nip']"' and  unit_kerja.id_skpd= '".$_POST['skpd']."'");
//echo "id_skpd".$skpd;
while($ata=mysqli_fetch_array($k))
{
	
$qsk=mysqli_query($mysqli,"select max(tmt) from sk where id_pegawai=$ata[5] and id_kategori_sk=5  ");
$sk=mysqli_fetch_array($qsk);
$t1=substr($sk[0],8,2);
$b1=substr($sk[0],5,2);
$th1=substr($sk[0],0,4);

$qp=mysqli_query($mysqli,"select * from pendidikan where id_pegawai=$ata[5] order by level_p");
$pen=mysqli_fetch_array($qp);
	
$data[] = array(
'label' => $ata[0], 
'value' =>$ata[0],
'nama' => $ata[0],
'nip' => $ata[1],
'pg' => $ata[2],
'jab' => $ata[3],
'opd' => $ata[4],
'tmt' => "$t1-$b1-$th1",
'pen' => $pen[3],
'jur' => $pen[4],
'idp' => $ata[5],
'ip' => $pen[2]

);

}
echo json_encode($data);
*/
?>

