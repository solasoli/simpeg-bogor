<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

<div class="container-fluid">
    <h4>Akses Methode</h4>
    <div class="row">
        <div class="col-sm-6">
            <p>Daftar Methode yang digunakan oleh aplikasi yang ter-register.</p>
        </div>
        <div class="col-sm-6" style="text-align: right;">
            <button onclick="tambah_access_methode()" type="button" class="btn btn-success btn-sm"><span data-feather="plus-square"></span> Penambahan Akses</button>
        </div>
    </div>
    <div class="row">
    <table class="table table-sm" id="tblAccessMethodeList">
        <thead>
        <tr>
            <th>No</th>
            <th style="text-align: center">Aplikasi</th>
            <th style="text-align: center">Methode yang diijinkan</th>
        </tr>
        </thead>
        <tbody>
        <?php if (isset($apps_list) and sizeof($apps_list) > 0): ?>
            <?php $i = 1; ?>
            <?php if ($apps_list != ''): ?>
                <?php foreach ($apps_list as $lsdata): ?>
                    <tr>
                        <td><?php echo $i; ?>.</td>
                        <td>
                            <strong><a href="<?php echo base_url()."Administrator/ubah_application/".$lsdata->idrest_apps; ?>" target="_self"><?php echo $lsdata->nama_apps; ?></a></strong><br>
                            Key : <?php echo $lsdata->api_key; ?>

                        </td>
                        <td>
                            <?php
                                $access = $this->administrator->listof_access_methode($lsdata->idrest_apps);
                                $access = $access->result();
                            ?>
                            <?php if (isset($access) and sizeof($access) > 0): ?>
                                <?php $a = 1; ?>
                                <?php if ($access != ''): ?>
                                    <span style="font-weight: bold; color: darkred">Methode: <?php echo $lsdata->entitas_use.'. &Sigma; = '.$lsdata->jml_methode; ?></span> <br>
                                    <button onclick="hapus_semua_methode_by_apps(<?php echo $lsdata->idrest_apps?>)" type="button" class="btn btn-danger btn-sm" style="font-size: small;"><span data-feather="trash-2"></span> Hapus Semua</button>
                                       <button id="btn_gen_manual<?php echo $lsdata->idrest_apps; ?>" class="btn btn-info btn-sm" type="button">
                                        <span data-feather="book"></span> Generate Manual</button><br>
                                    <script type="text/javascript">
                                        $("#btn_gen_manual<?php echo $lsdata->idrest_apps; ?>").click(function () {
                                            window.open('<?php echo base_url()."Administrator/cetak_manual_rest_by_apps/".$lsdata->idrest_apps.'/Manual WebService SIMPEG'; ?>', '_blank');
                                        });
                                    </script>
                                    <table style="margin-top: 5px; " class="table table-striped table-sm" id="tblAccessMethodePerId<?php echo $lsdata->idrest_apps; ?>">
                                        <tbody>
                                        <?php foreach ($access as $lsdata2): ?>
                                            <tr>
                                                <td>
                                                    <a href="<?php echo base_url('Docs/detail_methode_by_id/'.$lsdata2->id_methode) ?>">
                                                        <?php echo $a.') '.$lsdata2->judul.' (En: '.$lsdata2->entitas.'. ID: '.$lsdata2->id_methode.')'; ?></a><br>
                                                    Tgl.Input: <?php echo $lsdata2->tgl_create; ?>. Status: <?php echo $lsdata2->status_aktif; ?>.
                                                    Tgl.Update: <?php echo $lsdata2->tgl_update; ?>.
                                                    <button onclick="ubah_akses_methode(<?php echo $lsdata2->idrest_access?>)" type="button" class="btn btn-primary btn-sm" style="font-size: small;"><span data-feather="edit-2"></span></button>
                                                    <button onclick="hapus_akses_methode(<?php echo $lsdata2->idrest_access?>)" type="button" class="btn btn-danger btn-sm" style="font-size: small;"><span data-feather="trash-2"></span></button>
                                                </td>
                                            </tr>
                                            <?php
                                            $a++;
                                        endforeach;
                                        ?>
                                        </tbody>
                                    </table>
                                <?php else: ?>
                                    <ul><li>Belum Ada Data</li></ul>
                                <?php endif; ?>
                            <?php else: ?>
                                <ul><li>Belum Ada Data</li></ul>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php
                    $i++;
                endforeach; ?>
            <?php else: ?>
                <tr class="error">
                    <td colspan="3"><i>Tidak ada data</i></td>
                </tr>
            <?php endif; ?>
        <?php else: ?>
            <tr class="error">
                <td colspan="3"><i>Tidak ada data</i></td>
            </tr>
        <?php endif; ?>
        </tbody>
    </table>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="myModalUbahAksesMethode" role="dialog">
    <div class="modal-dialog modal-dialog-centered" style="height: 500px;">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Ubah Akses Methode</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body" style="max-height: 500px; overflow: scroll;">
                <p><div id="contentInfo" style="margin-top: -15px;"></div></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
            </div>
        </div>

    </div>
</div>

<script>
    $(document).ready( function () {
        $('#tblAccessMethodeList').DataTable({
            "bSort" : false
        });
    } );

    function tambah_access_methode(){
        location.href = "<?php echo base_url()."Administrator/add_new_access_methode" ?>";
    }

    function ubah_akses_methode(id){
        $.ajax({
            method: "GET",
            url: "<?php echo base_url()."Administrator/ubah_akses_methode/";?>"+id,
            dataType: "html"
        }).done(function( data ) {
            $("#contentInfo").html(data);
            $("#contentInfo").find("script").each(function(i) {
                eval($(this).text());
            });
        });
        $("#myModalUbahAksesMethode").modal("show");
    }

    function hapus_akses_methode(id){
        var r = confirm("Hapus data akses methode ini?");
        if (r == true) {
            var data = new FormData();
            data.append('idrest_access', id);
            jQuery.ajax({
                url: '<?php echo base_url("Administrator/hapus_akses_methode")?>',
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                type: 'POST',
                success: function (data) {
                    if(data == 'BERHASIL'){
                        location.href = "<?php echo base_url()."Administrator/methode_access_list" ?>";
                    }else{
                        alert("Gagal menghapus \n "+data);
                    }
                }
            });
        }
    }

    function hapus_semua_methode_by_apps(idapps){
        var r = confirm("Hapus semua data akses methode pada aplikasi ini?");
        if (r == true) {
            var data = new FormData();
            data.append('idapps', idapps);
            jQuery.ajax({
                url: '<?php echo base_url("Administrator/hapus_semua_methode_by_apps")?>',
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                type: 'POST',
                success: function (data) {
                    if(data == 'BERHASIL'){
                        location.href = "<?php echo base_url()."Administrator/methode_access_list" ?>";
                    }else{
                        alert("Gagal menghapus \n "+data);
                    }
                }
            });
        }
    }

</script>