<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<link rel="stylesheet" href="<?php echo base_url()?>assets/jquery/dist/jquery-ui.css">
<script src="<?php echo base_url()?>assets/jquery/dist/jquery.validate.js"></script>
<script src="<?php echo base_url()?>assets/jquery/dist/jquery-ui.min.js"></script>
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
    <?php elseif($tx_result == 'existing' and $tx_result!=''):?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Maaf</strong> Data tidak tersimpan karena sudah ada.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>

    <h4>Tambah Pengguna Baru</h4>
    <p>Menambah data pengguna aplikasi dokumentasi SIMPEG RestAPI.</p>

    <form action="" method="post" id="frmTambahUser" novalidate="novalidate" enctype="multipart/form-data">
        <input id="submitok" name="submitok" type="hidden" value="1">
        <div class="row">
            <div class="col-sm-6">
                <div class="row">
                    <div class="col-sm-4">Pegawai</div>
                    <div class="col-sm-7">
                        <div class="ui-widget">
                            <input type="text" class="form-control" id="txtCariPegawai" name="txtCariPegawai">
                        </div>
                        <input type="hidden" class="form-control" id="txtIdPegawai" name="txtIdPegawai">
                    </div>
                </div><br>
                <div class="row">
                    <div class="col-sm-4">User Name (Generate)</div>
                    <div class="col-sm-7">
                        <input type="text" class="form-control" id="txtUName" name="txtUName" readonly>
                    </div>
                </div><br>
                <div class="row">
                    <div class="col-sm-4">Password</div>
                    <div class="col-sm-7">
                        <input type="password" class="form-control" id="txtPwd" name="txtPwd">
                    </div>
                </div><br>
                <div class="row">
                    <div class="col-sm-4">Status Pengguna</div>
                    <div class="col-sm-7">
                        <select id="ddStatusUser" name="ddStatusUser" class="custom-select">
                            <option value="Administrator">Administrator</option>
                            <option value="User">User</option>
                        </select>
                    </div>
                </div><br>
                <div class="row">
                    <div class="col-sm-4">Status Aktif</div>
                    <div class="col-sm-7">
                        <select id="ddStatusAktif" name="ddStatusAktif" class="custom-select">
                            <option value="1">Aktif</option>
                            <option value="0">Tidak Aktif</option>
                        </select>
                    </div>
                </div><br>
                <div class="row">
                    <div class="col-sm-4"></div>
                    <div class="col-sm-7">
                        <button id="btnregister" name="new_register" type="submit" class="btn btn-success btn-sm"><span data-feather="save"></span> Simpan</button>
                        <button onclick="daftar_pengguna()" type="button" class="btn btn-primary btn-sm"><span data-feather="arrow-left-circle"></span> Lihat Daftar</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script>

    $(function() {
        $("#txtCariPegawai").autocomplete({
            source: function (request, response) {
                $.getJSON("<?php echo base_url()."Administrator/cari_pegawai?term=" ?>" + request.term, function (data) {
                    response($.map(data, function (value, key) {
                        return {
                            label: value.nama,
                            value: value.id,
                            nip: value.nip
                        };
                    }));
                });
            },
            select: function( event, ui ) {
                event.preventDefault();
                $("#txtCariPegawai").val(ui.item.label);
                $("#txtIdPegawai").val(ui.item.value);
                $("#txtUName").val(ui.item.nip);
            }
        });

    });

    function daftar_pengguna(){
        location.href = "<?php echo base_url()."Administrator/admin_list" ?>";
    }

    $(function(){
        $("#frmTambahUser").validate({
            errorClass: 'errors',
            ignore: "",
            rules: {
                txtUName: {
                    required: true
                },
                txtPwd: {
                    required: true
                }
            },
            messages: {
                txtUName: {
                    required: "Anda belum mengisi User Name"
                },
                txtPwd: {
                    required: "Anda belum mengisi Password"
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