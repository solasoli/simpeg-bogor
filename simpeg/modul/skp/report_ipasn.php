<?php
header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment;Filename=ipasn.xls");

session_start();
extract($_GET);
require_once("../../konek.php");
require_once "../../class/pegawai.php"; //nanti pindahkan ke global header ye..
require_once("../../class/unit_kerja.php");
require_once("../../library/format.php");
require "skp.php";

$skp = new Skp;
$qo = mysql_query ("select DISTINCT
                p.id_pegawai,
                p.nip_baru,
                p.jenjab,
                p.nama,
                p.nip_baru,
                p.pangkat_gol,
                p.id_j,
                p.jabatan, u.nama_baru, u.id_skpd, x.* from pegawai p
            left join current_lokasi_kerja c on c.id_pegawai = p.id_pegawai
             inner join unit_kerja u on u.id_unit_kerja = c.id_unit_kerja
             inner join
             (select b.id_pegawai, b.nama, b.kualifikasi,
              	(CASE
              		WHEN (b.eselon in ('IVB','IVA') && struktural in ('Diklat Kepemimpinan Tk.IV','ADUM')) then 1
                      WHEN (b.eselon in ('IIIA','IVB') && struktural in ('Diklat Kepemimpinan Tk.III','SPAMA')) then 1
                      WHEN (b.eselon in ('IIB','IIA') && struktural in ('Diklat Kepemimpinan Tk.II')) then 1
                      ELSE 0
              	END) as diklat_struktural,
                 IF(diklat_fung.nama_diklat is null || b.jenjab = 'Struktural', 0, 1) as fungsional,
                 IF(diklat20jp.nama_diklat is null, 0, 1) as diklat20,
                 IF(seminar.nama_diklat is null, 0, 1) as seminar
              from
              (select a.id_pegawai, a.nama, a.eselon, a.kualifikasi, a.jenjab,
              	(case
              		when (a.eselon = 'IVA' || a.eselon = 'IVB') then nama_diklat
                      when (a.eselon = 'IIIA' || a.eselon = 'IIIB') then nama_diklat
                      when (a.eselon = 'IIA' || a.eselon = 'IIB') then nama_diklat
                      else '0'
              	end) as struktural
               from
              (select
              	 p.id_pegawai, nama,
                              p.nip_baru as nip,
              				(CASE
              					when pt.level_p = 1 then 5
                                  when pt.level_p = 2 then 4
                                  when pt.level_p = 3 then 3
                                  when pt.level_p = 4 then 2
                                  when (pt.level_p = 5 || pt.level_p = 6 || pt.level_p = 7) then 1
                                  else 0
              				end
                              ) as kualifikasi,
                              j.eselon,
                              p.jenjab
              from pegawai p
              inner join current_lokasi_kerja clk on clk.id_pegawai = p.id_pegawai
              inner join unit_kerja uk on uk.id_unit_kerja = clk.id_unit_kerja
              inner join pendidikan_terakhir pt on pt.id_pegawai = p.id_pegawai
              left join jabatan j on j.id_j = p.id_j
              where p.flag_pensiun = 0
              order by uk.id_skpd ASC, p.pangkat_gol DESC) a
              left join  view_last_diklat_pim diklat on diklat.id_pegawai = a.id_pegawai) b
              left join
              (select peg.id_pegawai, nama_diklat, flag_lulus from diklat
              inner join pegawai peg on peg.id_pegawai = diklat.id_pegawai
              where peg.flag_pensiun = 0 and peg.jenjab = 'Fungsional' and diklat.id_jenis_diklat = 1
              group by peg.id_pegawai) diklat_fung on diklat_fung.id_pegawai = b.id_pegawai
              left join
              (select p2.id_pegawai, nama_diklat, jml_jam_diklat from diklat d2
              inner join pegawai p2 on p2.id_pegawai = d2.id_pegawai
              where p2.flag_pensiun = 0 and d2.id_jenis_diklat = 3 and jml_jam_diklat >= 20
              and tgl_diklat >  '2017-01-01'
              group by p2.id_pegawai) diklat20jp on diklat20jp.id_pegawai = b.id_pegawai
              left join
              (select p3.id_pegawai, d3.nama_diklat from diklat d3
              inner join pegawai p3 on p3.id_pegawai = d3.id_pegawai
              where p3.flag_pensiun = 0 and d3.id_jenis_diklat in( 5,6,7,8)
              and tgl_diklat >  '2016-01-01'
              group by p3.id_pegawai) seminar on seminar.id_pegawai = b.id_pegawai) x on x.id_pegawai = p.id_pegawai
              where flag_pensiun = 0
               order by u.id_skpd asc
               ");

?>


<table border="1" id="rekap_skp" class="table table-bordered display" cellspacing="0" width="100%">
	<thead>
		<tr>
			<th>Id Pegawai</th>
			<th>Nama</th>
      <th>NIP</th>
			<th>KUALIFIKASI</th>
			<th>STRUKTURAL</th>
			<th>FUNGSIONAL</th>
			<th>DIKLAT20JP</th>
      <th>SEMINAR</th>
      <th>SKP</th>
      <th>HUKDIS</th>
      <th>Unit Kerja</th>
		</tr>
	</thead>
	<tbody>
<?php
while($bata=mysql_fetch_array($qo)){
  $lastSkp = $skp->get_akhir_periode($bata["id_pegawai"], 2017);
  ?>
    <tr>
      <td>'<?php echo $bata["id_pegawai"] ?></td>
			<td>'<?php echo $bata['nama'] ?></td>
      <td>'<?php echo $bata['nip_baru'] ?></td>
      <td>'<?php echo $bata['kualifikasi'] ?></td>
			<td>'<?php echo $bata["diklat_struktural"] ?></td>
			<td>'<?php echo $bata["fungsional"] ?></td>
      <td>'<?php echo $bata['diklat20'] ?></td>
      <td>'<?php echo $bata['seminar'] ?></td>
      <?php  $nilai_skp = round($skp->get_nilai_capaian_rata2($bata["id_pegawai"], 2017),2) ?>
      <?php $rata2_perilaku = number_format($lastSkp->rata2_perilaku,2) ?>
      <td>'<?php echo $nilai_skp == 0 || $rata2_perilaku  == 0 ? "BELUM ADA NILAI" : round(($nilai_skp * 0.6) + ($rata2_perilaku * 0.4),0)?></td>
      <td></td>
      <td><?php echo $bata["nama_baru"] ?></td>
    </tr>
  <?php } ?>
  </tbody>
</table>
