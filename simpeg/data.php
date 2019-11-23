
  <?
  include "konek.php";
$q=mysqli_query($mysqli,"SELECT * FROM 
(
  SELECT * FROM 
  (
    SELECT pegawai.id_pegawai AS 'id_pegawai',
             pegawai.nip_lama AS 'nip_lama',
             pegawai.nip_baru AS 'nip_baru',
             pegawai.nama AS 'nama',
             pegawai.nama_pendek AS 'nama_pendek',
             pegawai.Jenis_kelamin AS 'jenis_kelamin',
             pegawai.npwp AS 'npwp',
             pegawai.agama AS 'agama',
             pegawai.tempat_lahir AS 'tempat_lahir',
             pegawai.tgl_lahir AS 'tgl_lahir',
             pegawai.status_pegawai AS 'status_pegawai',
             pegawai.pangkat_gol AS 'pangkat_gol',
             pegawai.status_aktif AS 'status_aktif',
             pegawai.flag_pensiun AS 'flag_pensiun',
             unit_kerja.id_unit_kerja AS 'id_unit_kerja' 
    FROM pegawai 
    LEFT OUTER JOIN riwayat_mutasi_kerja ON pegawai.id_pegawai = riwayat_mutasi_kerja.id_pegawai 
    LEFT OUTER JOIN unit_kerja ON riwayat_mutasi_kerja.id_unit_kerja = unit_kerja.id_unit_kerja 
    LEFT OUTER JOIN sk ON riwayat_mutasi_kerja.id_sk=sk.id_sk 
    ORDER BY sk.tgl_sk desc
  ) AS x 
  GROUP BY id_pegawai
) AS y WHERE flag_pensiun = 0 and id_unit_kerja =3595
ORDER BY pangkat_gol DESC, nama");


?>
</p>
<table width="600" border="1" align="center" cellpadding="5" cellspacing="0" bordercolor="#000000">
  <tr>
    <td>NO</td>
    <td>Nama</td>
    <td>NIP</td>
    <td nowrap="nowrap">Jenis Kelamin </td>
    <td nowrap="nowrap">Pendidikan Terakhir </td>
    <td nowrap="nowrap">Lembaga/ Institusi </td>
    <td nowrap="nowrap">Jurusan</td>
    <td nowrap="nowrap">Tahun Lulus </td>
  </tr>
  <?
  $i=1;
  while($data=mysqli_fetch_array($q))
  {
  $q1=mysqli_query($mysqli,"Select * from pendidikan where id_pegawai=$data[0] order by level_p");
  $ata=mysqli_fetch_array($q1);
  
  echo("<tr>
    <td>$i</td>
    <td>$data[3]</td>
    <td>$data[2]</td>
    <td nowrap=>$data[5]</td>
    <td nowrap=>$ata[3]</td>
    <td nowrap=>$ata[2] </td>
    <td nowrap=>$ata[4]</td>
    <td nowrap=>$ata[5]</td>
  </tr>
  
  ");
  
  $i++;
  }
  
  ?>

