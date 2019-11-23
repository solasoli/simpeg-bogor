<?php if (sizeof($list_data) > 0): ?>
    <?php if($list_data!=''): ?>
        <?php foreach ($list_data as $lsdata): ?>
            <br>
            <?php echo $lsdata->nama; ?><br>
            <?php echo $lsdata->nip_baru; ?><br>
            <?php echo $lsdata->jabatan; ?><br>
            Status : <?php echo $lsdata->flag_pensiun==0?'Aktif Bekerja':'Pensiun/Pindah'; ?>
            <input type="hidden" id="txtIdPegawaiPengesah<?php echo $id_ptk;?>" name="txtIdPegawaiPengesah<?php echo $id_ptk;?>" value="<?php echo $lsdata->id_pegawai;?>">
        <?php endforeach; ?>
    <?php else: ?>
        <i style="color: red">Tidak ada data</i>
        <input type="hidden" id="txtIdPegawaiPengesah<?php echo $id_ptk;?>" name="txtIdPegawaiPengesah<?php echo $id_ptk;?>" value="">
    <?php endif; ?>
<?php else: ?>
    <i style="color: red">Tidak ada data</i>
    <input type="hidden" id="txtIdPegawaiPengesah<?php echo $id_ptk;?>" name="txtIdPegawaiPengesah<?php echo $id_ptk;?>" value="">
<?php endif; ?>
