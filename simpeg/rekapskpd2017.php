<?php
$link = mysqli_connect("simpeg.db.kotabogor.net","simpeg", "Madangkara2017");
	//mysqli_connect("localhost","simpeg2","koplak123!");
  if (!mysqli_select_db('simpeg_20171231', $link)) {
      echo 'Could not select database';
      exit;
  }
$query = "select
    nama_baru AS 'unit_kerja',
    sum( IF((eselon LIKE 'IIA' OR eselon like 'IIB') and jenis_kelamin = '1', jumlah, 0) ) AS 'IIM',
	sum( IF((eselon LIKE 'IIA' OR eselon like 'IIB') and jenis_kelamin = '2', jumlah, 0) ) AS 'IIF',
    sum( IF((eselon LIKE 'IIIA' OR eselon like 'IIIB') and jenis_kelamin = '1', jumlah, 0) ) AS 'IIIM',
	sum( IF((eselon LIKE 'IIIA' OR eselon like 'IIIB') and jenis_kelamin = '2', jumlah, 0) ) AS 'IIIF',
	sum( IF((eselon LIKE 'IVA' OR eselon like 'IVB') and jenis_kelamin = '1', jumlah, 0) ) AS 'IVM',
	sum( IF((eselon LIKE 'IVA' OR eselon like 'IVB') and jenis_kelamin = '2', jumlah, 0) ) AS 'IVF',
  sum( IF(eselon is NULL and jenjab = 'Fungsional' and jenis_kelamin = '1', jumlah, 0) ) AS 'JFTM',
	sum( IF(eselon is NULL and jenjab = 'Fungsional' and jenis_kelamin = '2' , jumlah, 0) ) AS 'JFTF',
    sum( IF(eselon is NULL and jenjab = 'Struktural' and jenis_kelamin = '1', jumlah, 0) ) AS 'NSM',
	sum( IF(eselon is NULL and jenjab = 'Struktural' and jenis_kelamin = '2' , jumlah, 0) ) AS 'NSF',


    sum( jumlah ) as total
from
(
    select uk2.nama_baru, p.pangkat_gol as golongan, jenis_kelamin, eselon, p.jenjab as jenjab, count(*) as jumlah
    from current_lokasi_kerja c
    inner join unit_kerja u on u.id_unit_kerja = c.id_unit_kerja
	inner join (select * from unit_kerja where id_unit_kerja = id_skpd) uk2 on uk2.id_unit_kerja = u.id_skpd
    inner join pegawai p on p.id_pegawai = c.id_pegawai
	left join jabatan j on j.id_j = p.id_j
    where p.flag_pensiun = 0
    group by u.nama_baru, j.eselon, p.jenis_kelamin, p.jenjab
    order by u.nama_baru, p.pangkat_gol
) as T
group by T.nama_baru
with rollup
";

$result =  mysqli_query($mysqli,$query);
?>
<h3>
  REKAP PEGAWAI BERDASARKAN ESELON DAN JENIS KELAMIN
  <br> PER 31 Desember 2017
</h3>
<table border="1">
  <thead>
    <tr>
      <th rowspan="2" style="text-align:center">No.</th>
      <th rowspan="2" style="text-align:center">Nama Unit Kerja</th>
      <th colspan="2" style="text-align:center">II</th>
      <th colspan="2" style="text-align:center">III</th>
      <th colspan="2" style="text-align:center">IV</th>
      <th colspan="2" style="text-align:center">JFT</th>
      <th colspan="2" style="text-align:center">Pelaksana</th>
      <th rowspan="2" style="text-align:center">JUMLAH</th>
    </tr>
    <tr >
      <th style="text-align:center">L</th>
      <th style="text-align:center">P</th>
      <th style="text-align:center">L</th>
      <th style="text-align:center">P</th>
      <th style="text-align:center">L</th>
      <th style="text-align:center">P</th>
      <th style="text-align:center">L</th>
      <th style="text-align:center">P</th>
      <th style="text-align:center">L</th>
      <th style="text-align:center">P</th>
    </tr>
  </thead>
  <tbody>
    <?php
    $x=1;
    $total = 0;
    while($r = mysqli_fetch_object($result)){

      if($r->unit_kerja == NULL){
        $x = "";
        $r->unit_kerja = "TOTAL";

      }


    ?>
      <tr>
        <td><?php echo $x++ ?></td>
        <td><?php echo $r->unit_kerja; ?></td>
        <td><?php echo $r->IIM; ?></td>
        <td><?php echo $r->IIF; ?></td>
        <td><?php echo $r->IIIM; ?></td>
        <td><?php echo $r->IIIF; ?></td>
        <td><?php echo $r->IVM; ?></td>
        <td><?php echo $r->IVF; ?></td>
        <td><?php echo $r->JFTM; ?></td>
        <td><?php echo $r->JFTF; ?></td>
        <td><?php echo $r->NSM; ?></td>
        <td><?php echo $r->NSF; ?></td>

        <td><?php echo $r->total; ?></td>
      </tr>

    <?php
    }
    ?>

  </tbody>
</table>
