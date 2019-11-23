<strong>DAFTAR RIWAYAT PENGUBAHAN JABATAN</strong>
<table class="table bordered striped" id="daftar_jabatan_rangkap_pegawai">
    <thead>
    <tr>
        <th>No</th>
        <th>Tgl.Update</th>
        <th>Jabatan</th>
        <th>Pegawai</th>
        <th>Status</th>
    </tr>
    </thead>
    <?php if(sizeof($jabatan_rangkap) > 0): ?>
        <?php $i=1;?>
        <?php foreach($jabatan_rangkap as $jab): ?>
            <tr>
                <td><?php echo $i++;?></td>
                <td><?php echo $jab->update_time;?></td>
                <td><?php echo $jab->jabatan ?></td>
                <td><?php echo $jab->nama==''?'Tidak diketahui':$jab->nama.'<br>'.$jab->nip_baru; ?></td>
                <td><?php
                        echo $jab->status_data;
                        if($jab->status_data=='Sdh dicalonkan'){
                            echo "<br>(".$jab->jabatan_tujuan.")";
                        }
                    ?></td>
            </tr>
        <?php endforeach; ?>
    <?php else: ?>
        <tr class="error">
            <td colspan="5"><i>Tidak ada data</i></td>
        </tr>
    <?php endif; ?>
</table>

<?php if(sizeof($jabatan_rangkap) > 0): ?>
    <script>
        $(function(){
            $('#daftar_jabatan_rangkap_pegawai').dataTable();
        });
    </script>
<?php endif; ?>