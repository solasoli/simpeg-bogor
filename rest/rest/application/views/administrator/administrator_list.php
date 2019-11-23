<div class="container-fluid">
    <h4>Pengguna</h4>
    <div class="row">
        <div class="col-sm-6">
            <p>Daftar pengguna dengan hak otorisasi sebagai Administrator atau User biasa.</p>
        </div>
        <div class="col-sm-6" style="text-align: right;">
            <button onclick="tambah_admin()" type="button" class="btn btn-success btn-sm"><span data-feather="plus-square"></span> Tambah</button>
        </div>
    </div>
    <table class="table table-striped table-sm">
        <thead>
        <tr>
            <th>No</th>
            <th>Tgl.Input</th>
            <th>User Name</th>
            <th style="text-align: center">Nama Pengguna</th>
            <th>Otorisasi</th>
            <th>Status Aktif</th>
            <th style="width: 16%;text-align: center;">Aksi</th>
        </tr>
        </thead>
        <tbody>
        <?php if (isset($admin_list) and sizeof($admin_list) > 0): ?>
            <?php $i = 1; ?>
            <?php if ($admin_list != ''): ?>
                <?php foreach ($admin_list as $lsdata): ?>
                    <tr>
                        <td><?php echo $i; ?>.</td>
                        <td><?php echo $lsdata->tgl_create; ?></td>
                        <td><?php echo $lsdata->user_name; ?></td>
                        <td><?php echo $lsdata->nama.' ('.$lsdata->nip_baru.')'; ?></td>
                        <td><?php echo $lsdata->status_pengguna; ?></td>
                        <td><?php echo $lsdata->status_aktif; ?></td>
                        <td>
                            <button onclick="ubah_admin(<?php echo $lsdata->idrest_admin?>)" type="button" class="btn btn-primary btn-sm"><span data-feather="edit-2"></span> Ubah</button>
                            <button onclick="hapus_admin(<?php echo $lsdata->idrest_admin?>)" type="button" class="btn btn-danger btn-sm"><span data-feather="trash-2"></span> Hapus</button>
                        </td>
                    </tr>
                    <?php
                    $i++;
                endforeach; ?>
            <?php else: ?>
                <tr class="error">
                    <td colspan="8"><i>Tidak ada data</i></td>
                </tr>
            <?php endif; ?>
        <?php else: ?>
            <tr class="error">
                <td colspan="8"><i>Tidak ada data</i></td>
            </tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>

<script>
    function tambah_admin(){
        location.href = "<?php echo base_url()."Administrator/add_new_admin" ?>";
    }

    function ubah_admin(id){
        location.href = "<?php echo base_url()."Administrator/ubah_admin/" ?>" + id;
    }

    function hapus_admin(id){
        var r = confirm("Hapus data pengguna ini?");
        if (r == true) {
            var data = new FormData();
            data.append('idrest_admin', id);
            jQuery.ajax({
                url: '<?php echo base_url("Administrator/hapus_admin")?>',
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