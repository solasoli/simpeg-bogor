<strong>LOG AKTIFITAS</strong>

<table class="table bordered striped" id="log_aktifitas">
    <thead>
    <tr>
        <th>No</th>
        <th>Waktu</th>
        <th>Pegawai</th>
        <th>Gol</th>
        <th>Status</th>
        <th>Pergantian Jabatan</th>
        <th>Pemroses</th>
    </tr>
    </thead>
    <?php if(sizeof($log_aktifitas) > 0): ?>
        <?php $i=1;?>
        <?php foreach($log_aktifitas as $jab): ?>
            <tr>
                <td><?php echo $i++;?></td>
                <td><?php echo $jab->waktu2;?></td>
                <td><?php echo $jab->nama==''?'Tidak diketahui':$jab->nama.'<br>'.$jab->nip_baru; ?></td>
                <td><?php echo $jab->pangkat_gol==''?'Tidak diketahui':$jab->pangkat_gol; ?></td>
                <td><?php echo $jab->transaksi;?></td>
                <td><?php echo "Dari ".($jab->eselon_awal==''?'<span style="color: #1c5ec7">Staf / Tidak Punya Jabatan</span>':"<span style=\"color: #1c5ec7\">".$jab->jabatan_awal." Eselon (".$jab->eselon_awal.")</span> ");?>
                    menjadi <br><?php echo ($jab->eselon_akhir==''?'<span style="color: #87794e">Staf / Tidak Punya Jabatan</span>':"<span style=\"color: #87794e\">".$jab->jabatan_akhir." Eselon (".$jab->eselon_akhir.")</span> ");?>
                </td>
                <td><?php echo $jab->oleh;?></td>
            </tr>
        <?php endforeach; ?>
    <?php else: ?>
        <tr class="error">
            <td colspan="7"><i>Tidak ada data</i></td>
        </tr>
    <?php endif; ?>
</table>

<?php if(sizeof($log_aktifitas) > 0): ?>
    <script>
        $(function(){
            $('#log_aktifitas').dataTable();
        });
    </script>
<?php endif; ?>