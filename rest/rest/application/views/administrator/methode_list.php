<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

<div class="container-fluid">
    <h4>Methode</h4>
    <div class="row">
        <div class="col-sm-6">
            <p>Daftar Methode yang difungsikan untuk berjalan pada berbagai platform aplikasi.</p>
        </div>
        <div class="col-sm-6" style="text-align: right;">
            <button onclick="tambah_methode()" type="button" class="btn btn-success btn-sm"><span data-feather="plus-square"></span> Tambah</button>
        </div>
    </div>
    <div class="row">
    <table class="table table-striped table-sm" id="tblListMethode">
        <thead>
        <tr>
            <th>No</th>
            <th>Judul</th>
            <th>Uraian</th>
            <th>Methode</th>
            <th>URL</th>
            <th>Parameter|Respons</th>
            <th style="width: 16%;text-align: center;">Aksi</th>
        </tr>
        </thead>
        <tbody>
        <?php if (isset($methode_list) and sizeof($methode_list) > 0): ?>
            <?php $i = 1; ?>
            <?php if ($methode_list != ''): ?>
                <?php foreach ($methode_list as $lsdata): ?>
                    <tr>
                        <td><?php echo $i; ?>.</td>
                        <td><a href="<?php echo base_url('Docs/detail_methode_by_id/'.$lsdata->id_methode) ?>">
                                <?php echo $lsdata->judul.' (En: '.$lsdata->entitas.'. ID: '.$lsdata->id_methode.')'; ?></a>
                        </td>
                        <td><?php echo $lsdata->uraian; ?></td>
                        <td><?php echo $lsdata->methode; ?></td>
                        <td><code style="color: black"><?php echo $lsdata->url; ?></code></td>
                        <td style="text-align: center">
                            <?php if($lsdata->jml_params>0 or $lsdata->jml_respons>0): ?>
                                <a href="javascript:void(0);" onclick="getDetailInfoParamRespons(<?php echo $lsdata->id_methode; ?>);">
                                    <?php echo $lsdata->jml_params.'|'.$lsdata->jml_respons; ?>
                                </a>
                            <?php else: ?>
                                <?php echo $lsdata->jml_params.'|'.$lsdata->jml_respons; ?>
                            <?php endif; ?>
                        </td>
                        <td>
                            <button onclick="ubah_methode(<?php echo $lsdata->id_methode?>)" type="button" class="btn btn-primary btn-sm"><span data-feather="edit-2"></span> Ubah</button>
                            <button onclick="hapus_methode(<?php echo $lsdata->id_methode?>)" type="button" class="btn btn-danger btn-sm"><span data-feather="trash-2"></span> Hapus</button>
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
</div>

<!-- Modal -->
<div class="modal fade" id="myModalDetailMethode" role="dialog">
    <div class="modal-dialog modal-dialog-centered" style="height: 500px;">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Informasi</h4>
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
        $('#tblListMethode').DataTable({
            "bSort" : false
        });
        $("#myModalDetailMethode").on('show.bs.modal', function () {

        });
    } );

    function getDetailInfoParamRespons(idmethode){
        $.ajax({
            method: "GET",
            url: "<?php echo base_url()."Administrator/methode_detail/";?>"+idmethode,
            dataType: "html"
        }).done(function( data ) {
            $("#contentInfo").html(data);
            $("#contentInfo").find("script").each(function(i) {
                eval($(this).text());
            });
        });
        $("#myModalDetailMethode").modal("show");
    }

    function tambah_methode(){
        location.href = "<?php echo base_url()."Administrator/add_new_methode" ?>";
    }

    function ubah_methode(id){
        location.href = "<?php echo base_url()."Administrator/ubah_methode/" ?>" + id;
    }

    function hapus_methode(id){
        var r = confirm("Hapus data methode ini?");
        if (r == true) {
            var data = new FormData();
            data.append('id_methode', id);
            jQuery.ajax({
                url: '<?php echo base_url("Administrator/hapus_methode")?>',
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