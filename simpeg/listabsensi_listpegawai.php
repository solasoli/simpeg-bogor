<?php
    include 'konek.php';
    extract($_GET);
    if($tipe == 'skpd'){
        $strtipe = 'uk.id_skpd';
    }else{
        $strtipe = 'uk.id_unit_kerja';
    }

    $sql = "SELECT p.nip_baru, CONCAT(CASE WHEN p.gelar_depan = '' THEN '' ELSE CONCAT(p.gelar_depan, ' ') END,
            nama, CASE WHEN p.gelar_belakang = '' THEN '' ELSE CONCAT(' ',p.gelar_belakang) END) AS nama, p.pangkat_gol,
            CASE WHEN p.jenjab = 'Fungsional' THEN p.jabatan ELSE CASE WHEN p.id_j IS NULL THEN
            (SELECT jm.nama_jfu AS jabatan
             FROM jfu_pegawai jp, jfu_master jm
             WHERE jp.kode_jabatan = jm.kode_jabatan AND jp.id_pegawai = p.id_pegawai LIMIT 1)
            ELSE j.jabatan END END AS jabatan, a.jml_hari, a.hist_absensi, a.unit
            FROM
            (SELECT ra.id_pegawai, uk.nama_baru as unit, COUNT(ra.id) AS jml_hari,
            GROUP_CONCAT(DISTINCT DATE_FORMAT(ra.tgl,  '%d/%m/%Y') ORDER BY ra.tgl ASC SEPARATOR ', ') AS hist_absensi
            FROM report_absensi ra, unit_kerja uk, ref_status_absensi rsa
            WHERE MONTH(ra.tgl) = ".$bln." AND YEAR(ra.tgl) = ".$thn." AND $strtipe = ".$idlokasi." /*AND ra.status <> 'TA'*/ AND
            ra.id_unit_kerja = uk.id_unit_kerja AND rsa.nama_status = '".$status."' AND ra.status = rsa.idstatus
            GROUP BY ra.id_pegawai) a, pegawai p LEFT JOIN jabatan j ON p.id_j = j.id_j
            WHERE p.id_pegawai = a.id_pegawai AND p.flag_pensiun = 0 ORDER BY a.jml_hari DESC, p.pangkat_gol DESC";

    $query_row = mysqli_query($mysqli,$sql);
    $i = 1;
?>

<table width="100%" border="0" align="center" style="border-radius:5px;"
       class="table table-bordered table-hover table-striped" id="tblList">
    <thead>
    <tr>
        <th width="5%">No</th>
        <th width="10%">NIP</th>
        <th width="30%">Nama</th>
        <th width="10%">Gol.</th>
        <th width="45%">Jabatan</th>
    </tr>
    </thead>
    <tbody>
    <?php while($row = mysqli_fetch_array($query_row)){ ?>
        <tr>
            <td><?php echo $i;?></td>
            <td><span style="color: darkblue"><?php echo $row['nip_baru']; ?></span></td>
            <td><span style="color: darkgreen"><?php echo $row['nama']; ?></span></td>
            <td><?php echo $row['pangkat_gol']; ?></td>
            <td><?php echo $row['jabatan']; ?></td>
        </tr>
        <tr>
            <td></td>
            <td colspan="6">Jumlah: <span style="font-weight: bold;"><?php echo $row['jml_hari']; ?> Hari</span> |
                Waktu: <span style="font-style: italic"><?php echo $row['hist_absensi']; ?></span>
                <?php if($tipe=='skpd' and $auth=='1'): ?>
                    <br>Unit: <?php echo $row['unit']; ?>
                <?php endif; ?>
            </td>
        </tr>
        <?php
        $i++;
    } ?>
    </tbody>
</table>
