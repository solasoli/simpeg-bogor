<table class="table bordered striped" id="lst_cuti">
    <thead style="border-bottom: solid #a4c400 2px;">
    <tr>
        <th>No</th>
        <th>Jenis</th>
        <th>Nama Diklat</th>
        <th>Penyelenggara</th>
        <th>Lokasi Diklat</th>
        <th>Tanggal Diklat</th>
        <th width="13%">Aksi</th>
    </tr>
    </thead>
    <?php if (sizeof($list_data) > 0): ?>
        <?php $i = 1; ?>
        <?php if($list_data!=''): ?>
            <?php foreach ($list_data as $lsdata): ?>
                <tr>
                    <td><?php "" ?></td>
                    <td ><?php echo $lsdata->jenis_diklat?></td>
                    <td><?php echo $lsdata->nama_diklat?></td>
                    <td><?php echo $lsdata->penyelenggara_diklat?></td>
                    <td><?php echo $lsdata->lokasi_diklat?></td>
                    <td><?php echo $lsdata->tanggal_diklat?></td>

                    <td>
                        <a onclick="ubah_data_diklat(<?php echo $lsdata->iddiklat_sprint?>)" class="button default">Ubah</a>
                        <a onclick="hapus_diklat(<?php echo $lsdata->iddiklat_sprint.",'".$lsdata->nama_diklat."'"?>)"  class="button danger">Hapus</a>
                        <a href="<?php echo base_url('diklat/sprint_detail/'.$list_data->iddiklat_sprint) ?>" class="button info">detail</a>
                    </td>
                </tr> 
                <?php $i++; ?>
            <?php endforeach; ?>
        <?php else: ?>
            <tr class="error">
                <td colspan="11"><i>Tidak ada data</i></td>
            </tr>
        <?php endif; ?>
    <?php else: ?>
    <tr class="error">
        <td colspan="11"><i>Tidak ada data</i></td>
    </tr>
    <?php endif; ?>
</table>
