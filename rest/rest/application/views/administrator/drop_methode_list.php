
    <table class="table table-striped table-sm" id="tbl_methode_list" width="100%">
        <thead>
        <tr>
            <th>
                <input type="checkbox" id="checkAllListMethode">
            </th>
            <th>Judul</th>
            <th>Entitas</th>
        </tr>
        </thead>
        <tbody>
        <?php if (isset($methode_list) and sizeof($methode_list) > 0): ?>
            <?php $i = 1; ?>
            <?php if ($methode_list != ''): ?>
                <?php foreach ($methode_list as $lsdata): ?>
                    <tr>
                        <td><?php echo $i; ?>.
                          <input type="checkbox" value="<?php echo $lsdata->id_methode.'#'.$lsdata->judul.'#'.$lsdata->entitas.'#'.$lsdata->methode;?>"
                                 id="chkMethode<?php echo $lsdata->id_methode;?>">
                        </td>
                        <td><a href="<?php echo base_url('Docs/detail_methode_by_id/'.$lsdata->id_methode) ?>" target="_blank">
                            <?php echo $lsdata->judul.' (ID: '.$lsdata->id_methode.')'; ?></a> |
                            <?php echo $lsdata->methode; ?></td>
                        <td><?php echo $lsdata->entitas; ?></td>
                    </tr>
                    <?php
                        $i++;
                endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="3"><i>Tidak ada data</i></td>
                </tr>
            <?php endif; ?>
        <?php else: ?>
            <tr>
                <td colspan="3"><i>Tidak ada data</i></td>
            </tr>
        <?php endif; ?>
        </tbody>
    </table><br>

<script>
    $("#checkAllListMethode").change(function () {
        $("#dvMethodeList input:checkbox").prop('checked', $(this).prop("checked"));
    });
</script>
