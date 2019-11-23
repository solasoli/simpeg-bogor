<strong>DAFTAR JABATAN BERPOTENSI KOSONG</strong>
<table class="table bordered striped" id="daftar_jabatan_kosong">
    <thead>
    <tr>
        <th>No</th>
        <th>Jabatan</th>
        <th>Eselon</th>
        <th>Pegawai</th>
        <th>TMT.BUP</th>
        <th>&nbsp;</th>
    </tr>
    </thead>
    <?php if(sizeof($jabatan_kosong) > 0): ?>
        <?php $i=1;?>
        <?php foreach($jabatan_kosong as $jabkos): ?>
            <tr>
            <td><?php echo $i++;?></td>
            <td><?php echo $jabkos->jabatan ?></td>
            <td><?php echo $jabkos->eselon ?></td>
            <td><?php echo $jabkos->nama ?></td>
            <td><?php echo $jabkos->tgl_bup ?></td>
            <td><?php echo anchor('jabatan_struktural/isi_draft_jabatan/'.$id_draft.'/'.$jabkos->id_j, "Ganti", array("class" => "button bg-green fg-white")); ?></td>
            </tr>
        <?php endforeach; ?>
    <?php else: ?>
        <tr class="error">
            <td colspan="5"><i>Tidak ada data</i></td>
        </tr>
    <?php endif; ?>
</table>

<script>
    $(function(){
        $('#daftar_jabatan_kosong').dataTable();
    });
</script>