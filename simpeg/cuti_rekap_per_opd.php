<?php
    session_start();
    include 'class/cls_cuti.php';
    $oCuti = new Cuti();
    $thn = $_POST['thn'];
    $query = $oCuti->rekap_cuti_pada_opd($thn, $_SESSION['id_skpd']);
    $i = 0;
?>

<?php if ($query->num_rows > 0): ?>
    <table width="100%" border="0" align="center" style="border-radius:5px; border-bottom: double 2px rgba(71,71,72,0.35);"
           class="table table-bordered table-hover table-striped">
        <thead style="border-bottom: solid 3px rgba(71,71,72,0.35)">
            <td>No</td>
            <td>Status Cuti</td>
            <td>CLTN</td>
            <td>Penting</td>
            <td>Bersalin</td>
            <td>Besar</td>
            <td>Sakit</td>
            <td>Tahunan</td>
            <td>Total</td>
        </thead>
        <?php while ($row_data = $query->fetch_array(MYSQLI_BOTH)) {
        $i++; ?>
            <?php if($row_data['status_cuti']=='Total'): ?>
                <tr style="background-color: rgba(67,135,131,0.1);">
                    <td></td>
                    <td><?php echo $row_data['status_cuti']?></td>
                    <td><?php echo $row_data['CLTN']?></td>
                    <td><?php echo $row_data['C_ALASAN_PENTING']?></td>
                    <td><?php echo $row_data['C_BERSALIN']?></td>
                    <td><?php echo $row_data['C_BESAR']?></td>
                    <td><?php echo $row_data['C_SAKIT']?></td>
                    <td><?php echo $row_data['C_TAHUNAN']?></td>
                    <td><?php echo $row_data['Total']?></td>
                </tr>
            <?php else: ?>
                <tr>
                    <td><?php echo $i; ?></td>
                    <td><?php echo $row_data['status_cuti']?></td>
                    <td><?php echo $row_data['CLTN']?></td>
                    <td><?php echo $row_data['C_ALASAN_PENTING']?></td>
                    <td><?php echo $row_data['C_BERSALIN']?></td>
                    <td><?php echo $row_data['C_BESAR']?></td>
                    <td><?php echo $row_data['C_SAKIT']?></td>
                    <td><?php echo $row_data['C_TAHUNAN']?></td>
                    <td><?php echo ($row_data['Total']>0?'<a href="javascript:void(0)" style="text-decoration: none">'.$row_data['Total'].'</a>':$row_data['Total'])?></td>
                </tr>
            <?php endif; ?>
        <?php } ?>
    </table>
<?php else: ?>
    Data tidak dapat ditemukan
<?php endif; ?>
