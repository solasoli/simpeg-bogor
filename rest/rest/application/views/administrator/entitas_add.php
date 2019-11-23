<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<script src="<?php echo base_url()?>assets/jquery/dist/jquery.validate.js"></script>
<style>
    .error {
        color: red;
    };
</style>
<div class="container-fluid">
    <?php if($tx_result == 'true' and $tx_result!=''): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Selamat</strong> Data sukses tersimpan.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php elseif($tx_result == 'false' and $tx_result!=''): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Maaf</strong> Data tidak tersimpan.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>
    <h4>Tambah Entitas Baru</h4>
    <p>Menambah data entitas baru.</p>
    <form action="" method="post" id="frmTambahEntitas" novalidate="novalidate" enctype="multipart/form-data">
        <input id="submitok" name="submitok" type="hidden" value="1">
        <div class="row">
            <div class="col-sm-6">
                <div class="row">
                    <div class="col-sm-3">Nama Entitas</div>
                    <div class="col-sm-8"><input type="text" class="form-control" id="txtEntitas" name="txtEntitas"></div>
                </div><br>
                <div class="row">
                    <div class="col-sm-3">Keterangan</div>
                    <div class="col-sm-8"><textarea class="form-control" rows="5" id="txtKet" name="txtKet" style="resize: none"></textarea></div>
                </div><br>
                <div class="row">
                    <div class="col-sm-3"></div>
                    <div class="col-sm-8">
                        <button id="btnregister" name="new_register" type="submit" class="btn btn-success btn-sm"><span data-feather="save"></span> Simpan</button>
                        <button onclick="daftar_entitas()" type="button" class="btn btn-primary btn-sm"><span data-feather="arrow-left-circle"></span> Lihat Daftar</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
    function daftar_entitas(){
        location.href = "<?php echo base_url()."Administrator/entitas_list" ?>";
    }

    $(function(){
        $("#frmTambahEntitas").validate({
            errorClass: 'errors',
            ignore: "",
            rules: {
                txtEntitas: {
                    required: true
                },
                txtKet: {
                    required: true
                }
            },
            messages: {
                txtEntitas: {
                    required: "Anda belum mengisi nama entitas"
                },
                txtKet: {
                    required: "Anda belum mengisi keterangan"
                }
            },
            highlight: function (element) {
                $(element).parent().addClass('error')
            },
            submitHandler: function(form) {
                form.submit();
            }
        });
    });
</script>