<?php if (sizeof($list_data) > 0): ?>
    <?php if($list_data!=''): ?>
        <?php foreach ($list_data as $lsdata): ?>
            <table style="font-size: small;">
                <tr>
                    <td></td>
                    <td colspan="3">
                        <strong>
                            <?php echo $lsdata->flag_pensiun==0?'Aktif Bekerja':'Pensiun/Pindah'; ?>
                        </strong></td>
                </tr>
                <tr>
                    <td rowspan="7" style="width: 30%;vertical-align: top;">
                        <img class="border-color-grey" width="100px" src="../../../../simpeg/foto/<?php echo $lsdata->id_pegawai; ?>.jpg" />
                    </td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td></td>
                    <td style="width: 17%">NIP</td>
                    <td style="width: 53%">: <?php echo $lsdata->nip_baru; ?>
                    <?php if($status=='add'): ?>
                        <input type="hidden" id="txtIdPegawai" name="txtIdPegawai" value="<?php echo $lsdata->id_pegawai; ?>">
                        <input type="hidden" id="txtNip" name="txtNip" value="<?php echo $lsdata->nip_baru; ?>">
                    <?php else: ?>
                        <input type="hidden" id="txtIdPegawaiEd" name="txtIdPegawaiEd" value="<?php echo $lsdata->id_pegawai; ?>">
                        <input type="hidden" id="txtNipEd" name="txtNipEd" value="<?php echo $lsdata->nip_baru; ?>">
                    <?php endif; ?>

                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td>Nama</td>
                    <td>: <?php echo $lsdata->nama; ?></td>
                </tr>
                <tr>
                    <td></td>
                    <td>Jenjab</td>
                    <td>: <?php echo $lsdata->jenjab; ?></td>
                </tr>
                <tr>
                    <td></td>
                    <td>Gol</td>
                    <td>: <?php echo $lsdata->pangkat_gol; ?></td>
                </tr>
                <tr>
                    <td></td>
                    <td style="vertical-align: top">Jabatan</td>
                    <td>: <?php echo $lsdata->jabatan; ?></td>
                </tr>
                <tr>
                    <td></td>
                    <td style="vertical-align: top">OPD</td>
                    <td>: <?php echo $lsdata->nama_baru; ?></td>
                </tr>
            </table>
        <?php endforeach; ?>
    <?php else: ?>
        <i style="color: red">Tidak ada data</i>
        <?php if($status=='add'): ?>
            <input type="hidden" id="txtIdPegawai" name="txtIdPegawai" value="">
        <?php else: ?>
            <input type="hidden" id="txtIdPegawaiEd" name="txtIdPegawaiEd" value="">
        <?php endif; ?>
    <?php endif; ?>
<?php else: ?>
    <i style="color: red">Tidak ada data</i>
    <?php if($status=='add'): ?>
        <input type="hidden" id="txtIdPegawai" name="txtIdPegawai" value="">
    <?php else: ?>
        <input type="hidden" id="txtIdPegawaiEd" name="txtIdPegawaiEd" value="">
    <?php endif; ?>
<?php endif; ?>
