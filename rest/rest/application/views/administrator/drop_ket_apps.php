<div class="row">
    <div class="col-sm-3">Keterangan</div>
    <div class="col-sm-9">
        <?php if (isset($apps_ket) and sizeof($apps_ket) > 0): ?>
            <?php $i = 1; ?>
            <?php if ($apps_ket != ''): ?>
                <?php
                foreach ($apps_ket as $lsdata) {
                    echo 'Key : '.$lsdata->api_key.'<br>';
                    echo 'Platform : '.$lsdata->platform.'<br>';
                    echo 'Owner : '.$lsdata->owner.'<br>';
                    if($lsdata->available_url!=''){
                        echo 'Available URL : <a href="'.$lsdata->available_url.'" target="_blank">'.$lsdata->available_url.'</a>';
                    }else{
                        echo 'Available URL : -';
                    }
                }
                ?>
            <?php else: ?>
                <span class="error">Tidak ada data</span>
            <?php endif; ?>
        <?php else: ?>
            <span class="error">Tidak ada data</span>
        <?php endif; ?>
    </div>
</div><br>
<div class="row">
    <div class="col-sm-3">Methode yang diijinkan</div>
    <div class="col-sm-8">
        <div style="border:1px solid #c0c2bb; overflow:scroll;height: 365px;width: 100%;">
            <table class="table table-striped table-sm" id="tbl_methode_list_apps" width="100%">
                <thead>
                <tr>
                    <th><input type="checkbox" id="checkAllListMethodeApps"></th>
                    <th>Judul</th>
                    <th>Entitas</th>
                </tr>
                </thead>
                <tbody>
                <?php if (isset($methode_list) and sizeof($methode_list) > 0): ?>
                    <?php $i = 1; ?>
                    <?php if ($methode_list != ''): ?>
                        <?php foreach ($methode_list as $lsdata): ?>
                            <tr id="rowTblPilih<?php echo $lsdata->id_methode; ?>">
                                <td><?php echo $i; ?>.
                                    <input type="checkbox" id="chkMethodeGrand<?php echo $lsdata->id_methode; ?>" name="chkMethodeGrand<?php echo $lsdata->id_methode; ?>" value="<?php echo $lsdata->id_methode;?>" checked>
                                </td>
                                <td><a href="<?php echo base_url('Docs/detail_methode_by_id/'.$lsdata->id_methode) ?>" target="_blank">
                                        <?php echo $lsdata->judul.' (ID: '.$lsdata->id_methode.')'; ?></a> |
                                    <?php echo $lsdata->methode; ?></td>
                                <td><?php echo $lsdata->entitas; ?></td>
                            </tr>
                            <?php
                            $dataArrPilih[] = $lsdata->id_methode;
                            $i++;
                        endforeach; ?>
                        <script>
                            arrPilih = <?php echo json_encode( $dataArrPilih ) ?>;
                        </script>
                    <?php else: ?>
                        <tr>
                            <td colspan="3"><i>Belum ada data methode yang diijinkan tersimpan</i></td>
                        </tr>
                    <?php endif; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="3"><i>Belum ada data methode yang diijinkan tersimpan</i></td>
                    </tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
        Methode yang dipilih berjumlah :
        <span id="jmlMethodePlih" style="font-weight: bold"><?php echo sizeof($methode_list); ?></span><br>
        <button id="btn_hapus" class="btn btn-danger btn-sm" type="button"
                style="margin-top: 5px;"><span data-feather="trash-2"></span> Hapus yang dipilih</button>
        <button id="btnregister" name="btnregister" type="submit" class="btn btn-success btn-sm" style="margin-top: 5px;">
            <span data-feather="save"></span> Simpan</button>
        <button id="btn_gen_manual" class="btn btn-info btn-sm" type="button"
                style="margin-top: 5px;" onclick="cetakManualRest(<?php echo $idapps;?>);"><span data-feather="book"></span> Generate Manual</button>
    </div>
</div>
<br>
<script>
    $(function(){
        feather.replace();
    });

    $("#checkAllListMethodeApps").change(function () {
        $("#dvInfoApps input:checkbox").prop('checked', $(this).prop("checked"));
    });

    $("#btn_hapus").click(function () {
        var checkboxes = $("#dvInfoApps input:checkbox");
        var idMethode = 0;
        for (var i = 1; i < checkboxes.length; i++) {
            if (checkboxes[i].checked == true) {
                var str = checkboxes[i].value;
                var res = str.split("#");
                idMethode = res[0].trim();
                var a = arrPilih.indexOf(idMethode);
                arrPilih.splice(a, 1);
                document.getElementById("jmlMethodePlih").innerHTML = parseInt(document.getElementById('jmlMethodePlih').innerHTML) - 1;
                $('#rowTblPilih' + idMethode).remove();
                $("#checkAllListMethodeApps").prop("checked", false);
            }
        }
    });

    function cetakManualRest(idapps){
        window.open('<?php echo base_url()."Administrator/cetak_manual_rest_by_apps/"; ?>'+idapps+'/Manual WebService SIMPEG', '_blank');
    }

</script>