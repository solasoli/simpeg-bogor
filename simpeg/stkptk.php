
<div align="center"><h2>Laporan Rekapitulasi Perubahan Tunjangan Keluarga</h2></div>
<table class="table table-bordered" cellpadding="5" cellspacing="0" border="0" align="center">
<tr>
<td> No</td>
<td>Pegawai </td>
<td> NIP</td>
<td> Tgl Kirim OPD</td>
<td> Tgl Disetujui</td>
<td> Status </td>
<td> Durasi (jam)</td>
<td> ISO (1 hari)</td>
</tr>
<?php

$sql = "SELECT a.*, cha1.tgl_approve_hist AS tgl_kirim_opd, cha2.tgl_approve_hist AS tgl_setuju,
        CASE WHEN (a.id_status_ptk = 5 OR a.id_status_ptk = 8) THEN TIME_TO_SEC(TIMEDIFF(cha2.tgl_approve_hist, cha1.tgl_approve_hist))/3600  ELSE NULL END as durasi,
        CASE WHEN (a.id_status_ptk = 5 OR a.id_status_ptk = 8) THEN CASE WHEN (TIME_TO_SEC(timediff(cha2.tgl_approve_hist, cha1.tgl_approve_hist))/3600)>48 THEN 'Tidak Standar' ELSE 'Standar' END ELSE 'Belum Selesai' END as iso_status
        FROM
        (SELECT pm.id_ptk, CONCAT(CASE WHEN p.gelar_depan = '' THEN '' ELSE CONCAT(p.gelar_depan, ' ') END,
        p.nama, CASE WHEN p.gelar_belakang = '' THEN '' ELSE CONCAT(', ',p.gelar_belakang) END) AS nama,
        CONCAT(\"'\",p.nip_baru) AS nip, pm.tgl_input_pengajuan, pm.tgl_approve, rsc.id_status_ptk, status_ptk,
        MAX(CASE WHEN (cha.id_status_ptk = 2) THEN cha.id_ptk_historis ELSE NULL END) AS id_usulan,
        MAX(CASE WHEN (cha.id_status_ptk = 5) THEN cha.id_ptk_historis ELSE NULL END) AS id_disetujui
        FROM ptk_master pm LEFT JOIN pegawai p ON pm.id_pegawai_pemohon = p.id_pegawai
        LEFT JOIN ref_status_ptk rsc ON pm.idstatus_ptk = rsc.id_status_ptk
        LEFT JOIN ptk_historis_approve cha ON pm.id_ptk = cha.id_ptk
        WHERE YEAR(pm.tgl_input_pengajuan) = 2019 AND MONTH(pm.tgl_input_pengajuan) IN (1,2,3,4,5,6,7,8,9,10,11)
        AND pm.idstatus_ptk IN (2,5,8)
        GROUP BY pm.id_ptk)a
        LEFT JOIN ptk_historis_approve cha1 ON a.id_usulan = cha1.id_ptk_historis
        LEFT JOIN ptk_historis_approve cha2 ON a.id_disetujui = cha2.id_ptk_historis;";

$q = mysqli_query($mysqli,$sql);
$standar = 0;
$nonstandar = 0;
$belum_selesai = 0;
$total_durasi = 0;
$i=0;
while($data=mysqli_fetch_array($q)){
    $i = $i+1;
    echo "<tr><td>$i</td><td>$data[1]</td><td>$data[2]</td><td>$data[9]</td><td>$data[10]</td> <td>$data[6]</td><td>$data[11]</td><td>$data[12]</td></tr>";
    if($data[12]=='Standar'){
        $standar = $standar+1;
    }elseif($data[12]=='Tidak Standar'){
        $nonstandar = $nonstandar+1;
    }else{
        $belum_selesai = $belum_selesai+1;
    }
    $total_durasi = $total_durasi+$data[11];
}

?>
</table>
<div align="center">Rata rata durasi pelayanan : <?php echo ($i==0?0:round($total_durasi/$i, 2)); ?> jam</div>
<div>
    Jumlah Pemohon = <?php echo ($i); ?><br>
    Jumlah memenuhi standard = <?php echo $standar;?><br>
    Jumlah tidak memenuhi standard (>24 jam) = <?php echo $nonstandar;?><br>
    Sasaran Mutu : (Jumlah capaian memenuhi standard/Jumlah Pemohon) * 100 = <?php echo ($i==0?0:round(($standar/($i))*100,5)); ?>
</div>
