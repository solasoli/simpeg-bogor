<div class="container-fluid">
    <h4>Aplikasi</h4>
    <div class="row">
        <div class="col-sm-6">
            <p>Daftar Aplikasi yang menggunakan hasil keluaran data SIMPEG.</p>
        </div>
        <div class="col-sm-6" style="text-align: right;">
            <button onclick="tambah_apps()" type="button" class="btn btn-success btn-sm"><span data-feather="plus-square"></span> Tambah</button>
        </div>
    </div>
    <?php //print_r($apps_list); ?>
    <table class="table table-striped table-sm">
        <thead>
        <tr>
            <th>No</th>
            <th>Nama Apps</th>
            <th>Platform</th>
            <th>Owner</th>
            <th>Word Key</th>
            <th>API Key</th>
            <th style="width: 16%;text-align: center;">Aksi</th>
        </tr>
        </thead>
        <tbody>
        <?php if (isset($apps_list) and sizeof($apps_list) > 0): ?>
            <?php $i = 1; ?>
            <?php if ($apps_list != ''): ?>
                <?php foreach ($apps_list as $lsdata): ?>
                    <tr>
                        <td><?php echo $i; ?>.</td>
                        <td><strong>
                            <?php if($lsdata->available_url!=''): ?>
                                <a href="<?php echo $lsdata->available_url; ?>" target="_blank"><?php echo $lsdata->nama_apps; ?></a>
                            <?php else: ?>
                                <?php echo $lsdata->nama_apps; ?>
                            <?php endif; ?>
                            </strong></td>
                        <td><?php echo $lsdata->platform; ?></td>
                        <td><?php echo $lsdata->owner; ?></td>
                        <td><?php echo $lsdata->word_key; ?></td>
                        <td><code><?php echo $lsdata->api_key; ?></code></td>
                        <td>
                            <button onclick="ubah_apps(<?php echo $lsdata->idrest_apps?>)" type="button" class="btn btn-primary btn-sm"><span data-feather="edit-2"></span> Ubah</button>
                            <button onclick="hapus_apps(<?php echo $lsdata->idrest_apps?>)" type="button" class="btn btn-danger btn-sm"><span data-feather="trash-2"></span> Hapus</button>
                        </td>
                    </tr>
                    <?php
                    $i++;
                endforeach; ?>
            <?php else: ?>
                <tr class="error">
                    <td colspan="7"><i>Tidak ada data</i></td>
                </tr>
            <?php endif; ?>
        <?php else: ?>
            <tr class="error">
                <td colspan="7"><i>Tidak ada data</i></td>
            </tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>

<script>
    function tambah_apps(){
        location.href = "<?php echo base_url()."Administrator/add_new_application" ?>";
    }

    function ubah_apps(id){
        location.href = "<?php echo base_url()."Administrator/ubah_application/" ?>" + id;
    }

    function hapus_apps(id){
        var r = confirm("Hapus data aplikasi ini?");
        if (r == true) {
            var data = new FormData();
            data.append('id_apps', id);
            jQuery.ajax({
                url: '<?php echo base_url("Administrator/hapus_application")?>',
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