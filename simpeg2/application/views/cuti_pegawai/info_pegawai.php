<?php if (sizeof($list_data) > 0): ?>
    <?php if($list_data!=''): ?>
        <?php foreach ($list_data as $lsdata): ?>
            <strong><?php echo $lsdata->nama; ?></strong><br>
            <?php echo $lsdata->nip_baru; ?><br>
            <?php echo $lsdata->jabatan; ?><br>
            <input type="hidden" id="txtIdPegawaiPengesah_<?php echo $idcuti;?>" name="txtIdPegawaiPengesah_<?php echo $idcuti;?>" value="<?php echo $lsdata->id_pegawai;?>">
        <?php endforeach; ?>
    <?php else: ?>
        <i style="color: red">Tidak ada data</i>
        <input type="hidden" id="txtIdPegawaiPengesah_<?php echo $idcuti;?>" name="txtIdPegawaiPengesah_<?php echo $idcuti;?>" value="">
    <?php endif; ?>
<?php else: ?>
    <i style="color: red">Tidak ada data</i>
    <input type="hidden" id="txtIdPegawaiPengesah_<?php echo $idcuti;?>" name="txtIdPegawaiPengesah_<?php echo $idcuti;?>" value="">
<?php endif; ?>
