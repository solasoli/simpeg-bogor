<div class="container-fluid">
    <h4>Web Service Entitas <?php echo $entitas;?></h4>
    <p><?php echo $keterangan; ?></p>
    <div class="row">
    <table class="table table-striped table-sm" id="tblListMethode">
        <thead>
        <tr>
            <th>No</th>
            <th>Judul</th>
            <th>Uraian</th>
            <th>Methode</th>
            <th>URL</th>
            <th>Parameter</th>
            <th>Respons</th>
        </tr>
        </thead>
        <tbody>
        <?php if (isset($rest_list) and sizeof($rest_list) > 0): ?>
            <?php $i = 1; ?>
                <?php if ($rest_list != ''): ?>
                    <?php foreach ($rest_list as $lsdata): ?>
                    <tr>
                        <td><?php echo $i; ?>.</td>
                        <td><a href="<?php echo base_url('Docs/detail_methode_by_id/'.$lsdata->id_methode) ?>"><?php echo $lsdata->judul; ?> (ID: <?php echo $lsdata->id_methode; ?>)</a></td>
                        <td><?php echo $lsdata->uraian; ?></td>
                        <td><?php echo $lsdata->methode; ?></td>
                        <td><code style="color: black"><?php echo $lsdata->url; ?></code></td>
                        <td style="text-align: center;"><?php echo $lsdata->jml_params; ?></td>
                        <td style="text-align: center;"><?php echo $lsdata->jml_respons; ?></td>
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
        $('#tblListMethode').DataTable({
            "bSort" : false
        });
    } );
</script>