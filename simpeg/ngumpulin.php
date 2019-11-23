<table width="700" border="1" cellspacing="0" cellpadding="5">
  <tr>
    <td>Unit Kerja </td>
    <td>Jumlah Seharusnya </td>
    <td>yang sudah mengumpulkan </td>
  </tr>

<?
include("konek.php"); 
$q=mysqli_query($mysqli,"SELECT count(*),crot
FROM (

SELECT nama, y.id_pegawai, min( level_p ),id_unit_kerja AS crot
FROM (

SELECT nama, id_unit_kerja, x.id_pegawai, max( id_riwayat )
FROM (

SELECT nama, id_unit_kerja, id_riwayat, pegawai.id_pegawai
FROM `pegawai`
INNER JOIN riwayat_mutasi_kerja ON pegawai.id_pegawai = riwayat_mutasi_kerja.id_pegawai where flag_pensiun=0
ORDER BY id_riwayat DESC
) AS x
GROUP BY nama
) AS y
INNER JOIN pendidikan ON y.id_pegawai = pendidikan.id_pegawai
WHERE id_unit_kerja=1 or id_unit_kerja>=3543 or id_unit_kerja between 40 and 353 or id_unit_kerja between 375 and 501 or id_unit_kerja between 579 and 608 or id_unit_kerja between 611 and 622
GROUP BY y.id_pegawai
ORDER BY min( level_p )
) AS w group by crot limit 390,30");

while($data=mysqli_fetch_array($q))
{
$q1=mysqli_query($mysqli,"select nama_baru from unit_kerja where id_unit_kerja=$data[1]");
$unit=mysqli_fetch_array($q1);

$q2=mysqli_query($mysqli,"SELECT count(*),crot
FROM (

SELECT nama, y.id_pegawai, min( level_p ),id_unit_kerja AS crot
FROM (

SELECT nama, id_unit_kerja, x.id_pegawai, max( id_riwayat )
FROM (

SELECT nama, id_unit_kerja, id_riwayat, pegawai.id_pegawai
FROM `pegawai`
INNER JOIN riwayat_mutasi_kerja ON pegawai.id_pegawai = riwayat_mutasi_kerja.id_pegawai where flag_pensiun=0
ORDER BY id_riwayat DESC
) AS x
GROUP BY nama
) AS y
INNER JOIN pendidikan ON y.id_pegawai = pendidikan.id_pegawai inner join sk on sk.id_pegawai=y.id_pegawai
WHERE id_unit_kerja=1 or id_unit_kerja>=3543 or id_unit_kerja between 40 and 353 or id_unit_kerja between 375 and 501 or id_unit_kerja between 579 and 608 or id_unit_kerja between 611 and 622
GROUP BY y.id_pegawai
ORDER BY min( level_p )
) AS w where crot=$data[1] group by crot ");

$udah=mysqli_fetch_array($q2);

echo(" <tr>
    <td>$unit[0] </td>
    <td>$data[0]</td>
    <td>$udah[0]</td>
  </tr>");

}
?>
</table>