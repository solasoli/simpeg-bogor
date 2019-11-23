
<div align="center"><h2>Laporan Rekapitulasi Cuti Online</h2></div>
<table class="table" id="stkcuti" cellpadding="5" cellspacing="0" border="0" align="center">
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
        CASE WHEN (a.idstatus_cuti = 10 OR a.idstatus_cuti = 6) THEN TIME_TO_SEC(TIMEDIFF(cha2.tgl_approve_hist, cha1.tgl_approve_hist))/3600  ELSE NULL END as durasi,
        CASE WHEN (a.idstatus_cuti = 10 OR a.idstatus_cuti = 6) THEN CASE WHEN (TIME_TO_SEC(timediff(cha2.tgl_approve_hist, cha1.tgl_approve_hist))/3600)>48 THEN 'Tidak Standar' ELSE 'Standar' END ELSE 'Belum Selesai' END as iso_status
        FROM
        (SELECT cm.id_cuti_master, CONCAT(CASE WHEN p.gelar_depan = '' THEN '' ELSE CONCAT(p.gelar_depan, ' ') END,
        p.nama, CASE WHEN p.gelar_belakang = '' THEN '' ELSE CONCAT(', ',p.gelar_belakang) END) AS nama,
        CONCAT(\"'\",p.nip_baru) AS nip, cm.tgl_usulan_cuti, cm.tgl_approve_status, rsc.idstatus_cuti, status_cuti,
        MAX(CASE WHEN (cha.idstatus_cuti_hist = 3 or cha.idstatus_cuti_hist = 12) THEN cha.id_cuti_historis_approve ELSE NULL END) AS id_setuju,
        MIN(CASE WHEN (cha.idstatus_cuti_hist = 6) THEN cha.id_cuti_historis_approve ELSE NULL END) AS id_sk_cuti_terbit
        FROM cuti_master cm LEFT JOIN pegawai p ON cm.id_pegawai = p.id_pegawai
        LEFT JOIN ref_status_cuti rsc ON cm.id_status_cuti = rsc.idstatus_cuti
        LEFT JOIN cuti_historis_approve cha ON cm.id_cuti_master = cha.id_cuti_master
        WHERE YEAR(cm.tgl_usulan_cuti) = 2019 AND MONTH(cm.tgl_usulan_cuti) IN (1,2,3,4,5,6,7,8,9,10,11)
        AND cm.id_status_cuti IN (3,6,10,12)
        GROUP BY cm.id_cuti_master)a
        LEFT JOIN cuti_historis_approve cha1 ON a.id_setuju = cha1.id_cuti_historis_approve
        LEFT JOIN cuti_historis_approve cha2 ON a.id_sk_cuti_terbit = cha2.id_cuti_historis_approve";

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
<div align="center">Rata rata durasi pelayanan : <?php echo round($total_durasi/$i, 2); ?> jam</div>
<div>
    Jumlah Pemohon = <?php echo ($i); ?><br>
    Jumlah memenuhi standard = <?php echo $standar;?><br>
    Jumlah tidak memenuhi standard (>24 jam) = <?php echo $nonstandar;?><br>
    Sasaran Mutu : (Jumlah capaian memenuhi standard/Jumlah Pemohon) * 100 = <?php echo round(($standar/($i))*100,5); ?>
</div>
<script>
$(document).ready(function() {
	$('#stkcuti').dataTable({
       "dom": 'T<"clear">lfrtip',
        "tableTools": {
            "sSwfPath": "assets/DataTables/extensions/TableTools/swf/copy_csv_xls_pdf.swf" 
        }
    });
    
    
  
});
</script>
