<strong>DAFTAR PEGAWAI RANGKAP JABATAN</strong>

<table class="table bordered striped" id="daftar_pegawai_rangkap_jabatan">
    <thead>
    <tr>
        <th>No</th>
        <th>Jabatan</th>
        <th>Eselon</th>
        <th>Pegawai</th>
        <th>Aksi</th>
    </tr>
    </thead>
    <?php if(sizeof($pegawai_rangkap) > 0): ?>
        <?php $i=1;?>
        <?php foreach($pegawai_rangkap as $jabkos): ?>
            <tr>
                <td><?php echo $i++;?></td>
                <td><?php echo $jabkos->jabatan ?></td>
                <td><?php echo $jabkos->eselon ?></td>
                <td><?php echo $jabkos->nama ?></td>
                <td><?php echo anchor('jabatan_struktural/isi_draft_jabatan/'.$id_draft.'/'.$jabkos->id_j, "Ganti", array("class" => "button bg-green fg-white")); ?></td>
            </tr>
        <?php endforeach; ?>
    <?php else: ?>
        <tr class="error">
            <td colspan="5"><i>Tidak ada data</i></td>
        </tr>
    <?php endif; ?>
</table>

<?php if(sizeof($pegawai_rangkap) > 0): ?>
<script>
    $(function(){
        $('#daftar_pegawai_rangkap_jabatan').dataTable();
    });
</script>
<?php endif; ?>