<div class="container-fluid">
    <h4>Log Akses Methode</h4>
    <p>Riwayat perubahan pemberian akses methode untuk aplikasi.</p>
    <div class="row">
    <table class="table table-striped table-sm" id="tblLog">
        <thead>
        <tr>
            <th>No</th>
            <th>Tgl.Input</th>
            <th>Oleh</th>
            <th>Aplikasi</th>
            <th>Methode</th>
            <th>Status</th>
            <th>Transaksi</th>
        </tr>
        </thead>
        <tbody>
        <?php if (isset($log_list) and sizeof($log_list) > 0): ?>
            <?php $i = 1; ?>
            <?php if ($log_list != ''): ?>
                <?php foreach ($log_list as $lsdata): ?>
                    <tr>
                        <td><?php echo $i; ?>.</td>
                        <td><?php echo $lsdata->tgl_create; ?></td>
                        <td><?php echo $lsdata->oleh; ?></td>
                        <td><?php echo $lsdata->nama_apps; ?></td>
                        <td>
                            <a href="<?php echo base_url('Docs/detail_methode_by_id/'.$lsdata->id_methode) ?>">
                                <?php echo $lsdata->judul.' (ID : '.$lsdata->id_methode.')'; ?></a>
                        </td>
                        <td><?php echo $lsdata->status_aktif; ?></td>
                        <td><?php echo $lsdata->transaction; ?></td>
                    </tr>
                    <?php
                    $i++;
                endforeach; ?>
            <?php else: ?>
                <tr class="error">
                    <td colspan="7"><i>Tidak ada data</i></td>
                </tr>
            <?php endif; ?>
        <?php else: ?>
            <tr class="error">
                <td colspan="7"><i>Tidak ada data</i></td>
            </tr>
        <?php endif; ?>
        </tbody>
    </table>
    </div>
</div>

<script>
    $(document).ready( function () {
        $('#tblLog').DataTable({
            "bSort" : false
        });
    } );
</script>