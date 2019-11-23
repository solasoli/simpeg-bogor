<strong>DAFTAR PELAKSANAAN KEGIATAN DIKLAT</strong>
<table class="table bordered striped" id="daftar_diklat">
    <thead>
    <tr>
        <th>No</th>
        <th>Jenis</th>
        <th>Tgl. Diklat</th>
        <th>Jml.Jam</th>
        <th>Nama Diklat</th>
        <th>Penyelenggara</th>
        <th>Peserta</th>
        <th>Jabatan</th>
    </tr>
    </thead>
    <?php if(sizeof($dataLstDiklat) > 0): ?>
        <?php $i=1;?>
        <?php foreach($dataLstDiklat as $dataDiklat): ?>
            <tr>
                <td><?php echo $i++;?></td>
                <td><?php echo $dataDiklat->jenis_diklat ?></td>
                <td><?php echo $dataDiklat->tgl_diklat ?></td>
                <td><?php echo $dataDiklat->jml_jam_diklat ?></td>
                <td><?php echo $dataDiklat->nama_diklat ?></td>
                <td><?php echo $dataDiklat->penyelenggara_diklat ?></td>
                <td><?php echo $dataDiklat->nama ?></td>
                <td><?php echo $dataDiklat->jabatan ?></td>
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
        $('#daftar_diklat').dataTable();
    });
</script>