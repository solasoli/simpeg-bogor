<?php
include("konek.php");

extract($_POST);
echo "id_pegawainya ".$id_pegawai;
$q1 = mysqli_query($mysqli,"select pangkat_gol,pegawai.id_pegawai,jabatan,nama,nip_baru,nip_lama,pegawai.id_j from pegawai where pegawai.id_pegawai = $id_pegawai");

$ata=mysqli_fetch_array($q1);
//print_r($ata);
$tgl=substr($ata[3],8,2);
$bln=substr($ata[3],5,2);
$thn=substr($ata[3],0,4);


$q2=mysqli_query($mysqli,"select jabatan,eselon,nama_baru from jabatan inner join unit_kerja on jabatan.id_unit_kerja=unit_kerja.id_unit_kerja where id_j=$ata[6] ");

if($q2)
{
$job=mysqli_fetch_array($q2);
}

if($job[0]==NULL)
{
$job[0]='Staf pelaksana';
$job[1]='-';
$q3=mysqli_query($mysqli,"select nama_baru from riwayat_mutasi_kerja inner join sk on sk.id_sk=riwayat_mutasi_kerja.id_sk inner join unit_kerja on unit_kerja.id_unit_kerja=riwayat_mutasi_kerja.id_unit_kerja where sk.id_pegawai=$ata[1] order by tgl_sk desc ");
$st=mysqli_fetch_array($q3);
$job[2]=$st[0];

}

echo $ata[1];

if (file_exists("./foto/$ata[1].jpg"))
				$ada= "<img src=./foto/$ata[1].jpg width=75 hspace=10 id='photobox'/>";
			else
			$ada="Foto Belum Tersedia";

		//	echo 	"select pangkat_gol,pegawai.id_pegawai,jabatan,tmt from pegawai inner join sk on pegawai.id_pegawai=sk.id_pegawai where nama LIKE '%$negara%' and id_kategori_sk=5";

echo "<table width=100%>
<tr>
<td nowrap>Foto</td>
<td>:</td>
<td align=left valign=top>$ada</td>
</tr>
<td nowrap>Pangkat Golongan</td>
<td>:</td>
<td>$ata[0] tmt : $tgl-$bln-$thn</td>
</tr>

<tr>
<td align=left valign=top>NIP Baru</td>
<td align=left valign=top>:</td>
<td>$ata[4]</td>
</tr>

<tr>
<td align=left valign=top>NIP lama</td>
<td align=left valign=top>:</td>
<td>$ata[5]</td>
</tr>

<tr>
<td align=left valign=top>Jabatan</td>
<td align=left valign=top>:</td>
<td>$job[0]</td>
</tr>
<tr>
<td align=left valign=top>Eselonering</td>
<td align=left valign=top>:</td>
<td>$job[1]</td>
</tr>
<tr>
<td align=left valign=top>Unit Kerja</td>
<td align=left valign=top>:</td>
<td>$job[2]</td>
</tr>
</table>";

?>
