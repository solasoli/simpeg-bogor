<?php if(isset($drop_data_list)): ?>
    <?php if(isset($pgDisplay)): ?>
        <?php if($numpage > 0): ?>
            <div class="row">
                <div class="cell-sm-12">
                    Halaman ke <?php echo $curpage; ?> dari <?php echo $numpage; ?> | Jumlah : <?php echo $jmlData; ?>
                </div>
            </div>
            <?php echo $pgDisplay; ?>
        <?php endif; ?>
    <?php endif; ?>
    <div id="dvAllListPegawai" style="overflow-x: hidden; border: 1px solid rgba(71,71,72,0.35); margin-top: 5px; height: 495px;">
        <table id="tblPegawai" class="table row-hover row-border compact" style="width: 100%;">
            <thead style="border-bottom: 3px solid yellowgreen;">
            <tr>
                <th style="text-align: center;">
                    <div class="row">
                        <div class="cell-12" style="margin-top: 5px;margin-bottom: 5px;">Personil</div>
                    </div>
                </th>
            </tr>
            </thead>
            <tbody>
            <?php
            $i = 1;
            $halaman = $start_number;
            foreach($drop_data_list as $lsdata) {
                ?>
                <tr>
                    <td style="white-space:nowrap;">
                        <div class="row">
                            <div class="cell-2">
                                <?php if(($halaman+$i)==1): ?>
                                    <input id="rdbPegawai" name="rdbPegawai" type="radio" data-role="radio" value="<?php echo $lsdata->id_pegawai;?>#<?php echo $lsdata->id_unit_kerja;?>" checked>
                                <?php else: ?>
                                <input id="rdbPegawai" name="rdbPegawai" type="radio" data-role="radio" value="<?php echo $lsdata->id_pegawai;?>#<?php echo $lsdata->id_unit_kerja;?>">
                                <?php endif; ?>
                            </div>
                            <div class="cell-10" style="margin-left: -25px;">
                                <?php echo "<span class=\"fg-darkBlue text-bold\">".($halaman+$i).") ".$lsdata->nama."</span><br>".$lsdata->nip_baru; ?>
                            </div>
                        </div>
                    </td>
                </tr>
                <?php
                $i++;
            } ?>
            </tbody>
        </table>
    </div>
<?php else: ?>
    Data tidak ditemukan.
<?php endif; ?>

<script>
    $("#chkCheckAll").change(function () {
        $("#dvAllListPegawai input:checkbox").prop('checked', $(this).prop("checked"));
    });
</script>
