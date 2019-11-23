<?php

/* File inilah yang akan menghasilkan suggestion berdasarkan huruf2 yang udah diketik */





// mendapatkan parameter q dari URL q adalah huruf2 yang udah diketik dan bakalan disuggest

$q = $_GET["q"];



mysqli_connect("simpeg.db.kotabogor.net", "simpeg", "Madangkara2017");

mysqli_select_db("simpeg");



$query = mysqli_query($mysqli,"select nama,nama_baru,pegawai.id_pegawai,nip_lama,nip_baru,tgl_lahir from pegawai inner join riwayat_mutasi_kerja on pegawai.id_pegawai=riwayat_mutasi_kerja.id_pegawai inner join unit_kerja on riwayat_mutasi_kerja.id_unit_kerja=unit_kerja.id_unit_kerja where nama like '%$q%' or nama_baru like '%$q%' group by id_pegawai,nip_lama,nip_baru  order by nama");



while($i = mysqli_fetch_array($query))

{

	$a[] = $i;

}



// mulai lakukan pencarian dari array jika q > 0

if (strlen($q) > 0)

{

	$hint = "<table width=200 border=0 align=center cellpadding=5 cellspacing=0>

  <tr>

    <td nowrap=nowrap bgcolor=#f0f0f0><div align=center>Nama</div></td>

	<td nowrap=nowrap bgcolor=#f0f0f0><div align=center>Tgl Lahir</div></td>

	<td nowrap=nowrap bgcolor=#f0f0f0><div align=center>NIP</div></td>

<td nowrap=nowrap bgcolor=#f0f0f0><div align=center>NIP Baru</div></td>

    <td bgcolor=#f0f0f0><div align=center>Unit Kerja </div></td>

  </tr>";

	for($i = 0; $i < count($a); $i++)

	{

		//if (strtolower($q) == strtolower(substr($a[$i],0,strlen($q))))

		//{

		

		$ro=$a[$i];

		$k=mysqli_query($mysqli,"select nama_baru from riwayat_mutasi_kerja inner join pegawai on riwayat_mutasi_kerja.id_pegawai=pegawai.id_pegawai inner join unit_kerja on riwayat_mutasi_kerja.id_unit_kerja=unit_kerja.id_unit_kerja where riwayat_mutasi_kerja.id_pegawai=$ro[2] order by id_riwayat desc");

				//echo("select nama_baru from riwayat_mutasi_kerja inner join pegawai on riwayat_mutasi_kerja.id_pegawai=pegawai.id_pegawai inner join unit_kerja on riwayat_mutasi_kerja.id_unit_kerja=unit_kerja.id_unit_kerja where riwayat_mutasi_kerja.id_pegawai=$ro[2] order by id_riwayat desc");



				$unit=mysqli_fetch_array($k);

	

	

	

	if($ro[3]=='-')

	$nip=$ro[4];

	else

	$nip=$ro[3];

	

$tgl=substr($ro[5],8,2);

$bln=substr($ro[5],5,2);

$thn=substr($ro[5],0,4);



	$hint = $hint."<tr><td nowrap><a href=index2.php?x=home3.php&&id=$ro[2]&&s=$s>$ro[0]</a></td>

<td nowrap>$tgl/$bln/$thn </td>



	 <td nowrap>$nip </td>

<td nowrap>$ro[4] </td>

    <td nowrap>$unit[0] </td>

  </tr>";

				

		

				//$hint = $hint."<option value='$a[$i]'>$a[$i]</option>";

			

		//}

	}

	$hint = $hint."</select>";

}



// atur output menjadi "tida ada suggestion" jika tidak ditemukan di array

if ($hint == "")

{

	$response = "tidak ada suggestion";

}

else

{

	$response = $hint;

}



//tampilkan output

echo $response;



?>