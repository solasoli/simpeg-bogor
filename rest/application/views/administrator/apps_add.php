<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<script src="<?php echo base_url()?>assets/jquery/dist/jquery.validate.js"></script>
<script src="<?php echo base_url()?>assets/jquery/jquery.md5.js"></script>
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
    <?php elseif($tx_result == 'pq_exist' and $tx_result!=''): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Maaf</strong> Data tidak tersimpan, Nilai P atau Q sudah ada.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php elseif($tx_result == 'pq_error' and $tx_result!=''): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Maaf</strong> Data tidak tersimpan, Nilai P atau Nilai Q belum valid.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>
    <h4>Tambah Aplikasi Baru</h4>
    <p>Menambah data aplikasi yang akan mengintegrasikan data dan informasi SIMPEG.</p>
    <form action="" method="post" id="frmTambahApps" novalidate="novalidate" enctype="multipart/form-data">
        <input id="submitok" name="submitok" type="hidden" value="1">
        <div class="row">
            <div class="col-sm-6">
                <div class="row">
                    <div class="col-sm-4">Nama Aplikasi</div>
                    <div class="col-sm-8"><input type="text" class="form-control" id="txtApps" name="txtApps"></div>
                </div><br>
                <div class="row">
                    <div class="col-sm-4">Platform</div>
                    <div class="col-sm-8">
                        <?php if (isset($platform_list)): ?>
                            <select id="ddPlatform" name="ddPlatform" class="custom-select">
                                <?php foreach ($platform_list as $ls): ?>
                                    <?php if ($ls->platform == $platform): ?>
                                        <option value="<?php echo $ls->platform; ?>" selected><?php echo $ls->platform.' ('.$ls->keterangan.')'; ?></option>
                                    <?php else: ?>
                                        <option value="<?php echo $ls->platform; ?>"><?php echo $ls->platform.' ('.$ls->keterangan.')'; ?></option>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </select>
                        <?php endif; ?>
                    </div>
                </div><br>
                <div class="row">
                    <div class="col-sm-4">Owner</div>
                    <div class="col-sm-8"><input type="text" class="form-control" id="txtOwner" name="txtOwner"></div>
                </div><br>
                <div class="row">
                    <div class="col-sm-4">Word Key</div>
                    <div class="col-sm-8"><input type="text" class="form-control" id="txtWordKey" name="txtWordKey" onkeyup="generateAPIKey()"></div>
                </div><br>
                <div class="row">
                    <div class="col-sm-4">API Key Generated</div>
                    <div class="col-sm-8"><input type="text" class="form-control" id="txtApiKey" name="txtApiKey" readonly></div>
                </div><br>
                <div class="row">
                    <div class="col-sm-4">Available URL</div>
                    <div class="col-sm-8"><input type="text" class="form-control" id="txtUrl" name="txtUrl"></div>
                </div><br>
                <div class="row">
                    <div class="col-sm-4"></div>
                    <div class="col-sm-8">
                        <button id="btnregister" name="new_register" type="submit" class="btn btn-success btn-sm"><span data-feather="save"></span> Simpan</button>
                        <button onclick="daftar_apps()" type="button" class="btn btn-primary btn-sm"><span data-feather="arrow-left-circle"></span> Lihat Daftar</button>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <strong>RSA Enkripsi Parameter</strong><br>
                <small>Digunakan jika ada methode yang memerlukan enkripsi parameter</small>
                <br><br>
                <div class="row">
                    <div class="col-sm-4">Nilai Prima P<br>
                        <small>Bilangan Prima lebih besar dari 9990450271</small></div>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="txtP" name="txtP" value="">
                    </div>
                </div><br>
                <div class="row">
                    <div class="col-sm-4">Nilai Prima Q<br>
                        <small>Bilangan Prima lebih besar dari 9990450271</small>
                    </div>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="txtQ" name="txtQ" value="">
                    </div>
                </div><br>
                <div class="row">
                    <div class="col-sm-4">Modulo</div>
                    <div class="col-sm-8"><input type="text" class="form-control" id="txtModulo" name="txtModulo" value="Otomatis muncul setelah data tersimpan" readonly></div>
                </div><br>
                <div class="row">
                    <div class="col-sm-4">Private Key</div>
                    <div class="col-sm-8"><input type="text" class="form-control" id="txtPrivateKey" name="txtPrivateKey" value="Otomatis muncul setelah data tersimpan" readonly></div>
                </div><br>
                <div class="row">
                    <div class="col-sm-4">Public Key</div>
                    <div class="col-sm-8"><input type="text" class="form-control" id="txtPublicKey" name="txtPublicKey" value="Otomatis muncul setelah data tersimpan" readonly></div>
                </div><br>
            </div>
        </div>
    </form>
</div><br>

<script>
    function daftar_apps(){
        location.href = "<?php echo base_url()."Administrator/application_list" ?>";
    }

    $(function(){
        $("#frmTambahApps").validate({
            errorClass: 'errors',
            ignore: "",
            rules: {
                txtApps: {
                    required: true
                },
                txtOwner: {
                    required: true
                },
                txtWordKey: {
                    required: true
                },
                txtApiKey:{
                    required: true
                },
                txtUrl:{
                    required: true
                },
                txtP:{
                    required: true,
                    min: 9990450271
                },
                txtQ:{
                    required: true,
                    min: 9990450271
                }
            },
            messages: {
                txtApps: {
                    required: "Anda belum mengisi nama aplikasi"
                },
                txtOwner: {
                    required: "Anda belum mengisi owner"
                },
                txtWordKey: {
                    required: "Anda belum mengisi word key"
                },
                txtApiKey: {
                    required: "Anda belum mengisi API key"
                },
                txtUrl: {
                    required: "Anda belum mengisi URL"
                },
                txtP: {
                    required: "Anda belum mengisi nilai prima P",
                    min: "Nilai belum memenuhi kriteria"
                },
                txtQ: {
                    required: "Anda belum mengisi nilai prima Q",
                    min: "Nilai belum memenuhi kriteria"
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

    function generateAPIKey(){
        var wordKey = document.getElementById('txtWordKey').value;
        if(wordKey==''){
            $('#txtApiKey').val('');
        }else{
            var md5WordKey = $.md5(wordKey);
            $('#txtApiKey').val(md5WordKey);
        }
    }

</script>