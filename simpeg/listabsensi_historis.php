<?php
    include 'konek.php';
    $idpeg = $_GET['id'];
    $sql = "SELECT DATE_FORMAT(ra.tgl, '%d/%m/%Y') AS tgl, rsa.nama_status
            FROM report_absensi ra, ref_status_absensi rsa
            WHERE ra.status = rsa.idstatus AND ra.id_pegawai = ".$idpeg."
            ORDER BY ra.tgl DESC";
    $query_row = mysqli_query($mysqli,$sql);
    $i = 1;
?>

<table width="100%" border="0" align="center" style="border-radius:5px;"
       class="table table-bordered table-hover table-striped" id="tblList">
    <thead>
    <tr>
        <th width="5%">No</th>
        <th width="30%">Tanggal</th>
        <th width="65%">Keterangan</th>
    </tr>
    </thead>
    <tbody>
    <?php while($row = mysqli_fetch_array($query_row)){ ?>
        <tr>
            <td><?php echo $i;?></td>
            <td><?php echo $row['tgl']; ?></td>
            <td><?php echo $row['nama_status']; ?></td>
        </tr>
        <?php
        $i++;
    } ?>
    </tbody>
</table>
