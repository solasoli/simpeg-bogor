<?php if(isset($info_baperjakat)): ?>
    <?php foreach($info_baperjakat as $inba): ?>
        <?php echo '<strong>No. SK. '. $inba->no_sk.'</strong>' ?>
        <?php echo '<br> Disahkan Oleh '. $inba->pengesah_sk.' ('.$inba->nama_pengesah_sk.')' ?>
    <?php endforeach; ?>
    <?php echo '<br> Terdiri dari : <br>' ?>
    <?php if(isset($detail_baperjakat)): ?>
        <table>
            <?php foreach($detail_baperjakat as $deba): ?>
                <tr>
                    <td style="vertical-align: top;"><?php echo $deba->status_keanggotaan ?></td>
                    <td style="width: 20px; text-align: center; vertical-align: top;">:</td>
                    <td><?php echo $deba->gelar_depan.' '.$deba->nama.' '.$deba->gelar_belakang.'<br>'.$deba->nip_baru.'<br>'.$deba->jabatan ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
<?php endif; ?>