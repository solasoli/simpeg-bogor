<div class="row mb-2">
    <div class="cell-sm-7">
        <?php if (isset($data_unit_jadwal) and sizeof($data_unit_jadwal) > 0 and $data_unit_jadwal != ''){ ?>
            <div style="height: 295px;overflow-x: auto; ">
                <table id="tblUkJadwalKhusus" class="table row-hover row-border compact"
                       style="margin-bottom: 0px;border-bottom: 1px solid rgba(71,71,72,0.35);">
                    <thead>
                    <tr>
                        <th>No</th>
                        <th>Uraian</th>
                    </tr>
                    </thead>
                    <?php $i = 1; ?>
                    <?php foreach ($data_unit_jadwal as $lsdata): ?>
                        <tr>
                            <td style="vertical-align: top;"><?php echo $i; ?>)</td>
                            <td>
                                <span class="mif-map2 icon"></span> <?php echo $lsdata->nama_unit; ?>
                                <?php echo ' ('.$lsdata->tipe_lokasi.')<br><small>'.$lsdata->alamat.'<br>'; ?>
                                <?php echo 'Koordinat Dalam: ('.$lsdata->in_lat.', '.$lsdata->in_long.') <br>Koordinat Luar: ('.$lsdata->out_lat.', '.$lsdata->out_long.') ' ?>
                                <?php if(sizeof($data_unit_jadwal) > 1): ?>
                                    <br><a href="javascript:void(0)" onclick="hapus_unit_kerja_jadwal('<?php echo $lsdata->id_ukjdwl_enc; ?>','<?php echo $lsdata->id_trans_jdwal_enc; ?>')" style="color: darkred;"><span class="mif-bin icon"></span> Hapus</a> &nbsp;
                                    <a href="javascript:void(0)" onclick="lihatPetaJadwalKhusus(<?php echo $lsdata->in_lat;?>,<?php echo $lsdata->in_long;?>,<?php echo $lsdata->out_lat;?>,<?php echo $lsdata->out_long;?>,'dvMapPreview');" style="color: dodgerblue;"><span class="mif-map2 icon"></span> Lihat Peta</a>
                                <?php endif;?>
                            </td>
                        </tr>
                        <?php
                        if($i==1){
                            echo "<script>lihatPetaJadwalKhusus(".$lsdata->in_lat.",".$lsdata->in_long.",".$lsdata->out_lat.",".$lsdata->out_long.", 'dvMapPreview');</script>";
                        }
                        $i++;
                        ?>
                    <?php endforeach; ?>
                </table>
            </div>
        <?php }else{
            echo 'Data tidak ditemukan';
        } ?>
    </div>
    <div class="cell-sm-5" style="padding-top: 10px;">
        <span style="margin-left: -10px;">Pratinjau Peta:</span>
        <div id="dvMapPreview" style="width: 100%;
                                    border: 1px solid rgba(71,71,72,0.35); margin-left: -10px;
                                    margin-top:0px;margin-right: 10px; margin-bottom: 10px; height: 250px;">

        </div>
    </div>
</div>