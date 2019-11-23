<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

<div class="container-fluid">
    <h4>Kategori API &laquo; Entitas &raquo;</h4>
    <div class="row">
        <div class="col-sm-10">
            <p>Daftar Entitas / Kategori API yang merupakan kelas dari kumpulan methode yang berkaitan.</p>
        </div>
        <div class="col-sm-2" style="text-align: right;">
            <button onclick="tambah_entitas()" type="button" class="btn btn-success btn-sm"><span data-feather="plus-square"></span> Tambah</button>
        </div>
    </div>
    <table class="table table-striped table-sm" id="tblListEntitas">
        <thead>
        <tr>
            <th>No</th>
            <th>Entitas</th>
            <th>Keterangan</th>
            <th style="width: 16%;text-align: center;">Aksi</th>
        </tr>
        </thead>
        <tbody>
        <?php if (isset($entitas_list) and sizeof($entitas_list) > 0): ?>
            <?php $i = 1; ?>
            <?php if ($entitas_list != ''): ?>
                <?php foreach ($entitas_list as $lsdata): ?>
                    <tr>
                        <td><?php echo $i; ?>.</td>
                        <td><?php echo $lsdata->entitas; ?></td>
                        <td><?php echo $lsdata->keterangan; ?></td>
                        <td>
                            <button onclick="ubah_entitas('<?php echo $lsdata->entitas?>')" type="button" class="btn btn-primary btn-sm"><span data-feather="edit-2"></span> Ubah</button>
                            <button onclick="hapus_entitas('<?php echo $lsdata->entitas?>')" type="button" class="btn btn-danger btn-sm"><span data-feather="trash-2"></span> Hapus</button>
                        </td>
                    </tr>
                    <?php
                    $i++;
                endforeach; ?>
            <?php else: ?>
                <tr class="error">
                    <td colspan="4"><i>Tidak ada data</i></td>
                </tr>
            <?php endif; ?>
        <?php else: ?>
            <tr class="error">
                <td colspan="4"><i>Tidak ada data</i></td>
            </tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>

<script>
    function tambah_entitas(){
        location.href = "<?php echo base_url()."Administrator/add_new_entitas" ?>";
    }

    function ubah_entitas(id){
        location.href = "<?php echo base_url()."Administrator/ubah_entitas/" ?>" + id;
    }

    function hapus_entitas(id){
        var r = confirm("Hapus data entitas ini?");
        if (r == true) {
            var data = new FormData();
            data.append('entitas', id);
            jQuery.ajax({
                url: '<?php echo base_url("Administrator/hapus_entitas")?>',
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                type: 'POST',
                success: function (data) {
                    if(data == 'BERHASIL'){
                        window.location.reload();
                    }else{
                        alert("Gagal menghapus \n "+data);
                    }
                }
            });
        }
    }
</script>