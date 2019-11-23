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
    <h4>Ubah Aplikasi</h4>
    <p>Mengubah data aplikasi yang mengintegrasikan data dan informasi SIMPEG.</p>

    <?php if (isset($apps) and sizeof($apps) > 0): ?>
        <?php $i = 1; ?>
        <?php if ($apps != ''): ?>
            <?php foreach ($apps as $lsdata): ?>
                <form action="" method="post" id="frmUbahApps" novalidate="novalidate" enctype="multipart/form-data">
                    <input id="submitok" name="submitok" type="hidden" value="1">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="row">
                                <div class="col-sm-4">Nama Aplikasi</div>
                                <div class="col-sm-8">
                                    <input type="hidden" class="form-control" id="txtIdApps" name="txtIdApps"
                                           value="<?php echo $lsdata->idrest_apps; ?>">
                                    <input type="text" class="form-control" id="txtApps" name="txtApps"
                                value="<?php echo $lsdata->nama_apps; ?>">
                                </div>
                            </div><br>
                            <div class="row">
                                <div class="col-sm-4">Platform</div>
                                <div class="col-sm-8">
                                    <?php if (isset($platform_list)): ?>
                                        <select id="ddPlatform" name="ddPlatform" class="custom-select">
                                            <?php foreach ($platform_list as $ls): ?>
                                                <?php if ($ls->platform == $lsdata->platform): ?>
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
                                <div class="col-sm-8"><input type="text" class="form-control" id="txtOwner" name="txtOwner" value="<?php echo $lsdata->owner; ?>"></div>
                            </div><br>
                            <div class="row">
                                <div class="col-sm-4">Word Key</div>
                                <div class="col-sm-8"><input type="text" class="form-control" id="txtWordKey" name="txtWordKey" onkeyup="generateAPIKey()" value="<?php echo $lsdata->word_key; ?>"></div>
                            </div><br>
                            <div class="row">
                                <div class="col-sm-4">API Key Generated</div>
                                <div class="col-sm-8"><input type="text" class="form-control" id="txtApiKey" name="txtApiKey" readonly value="<?php echo $lsdata->api_key; ?>"></div>
                            </div><br>
                            <div class="row">
                                <div class="col-sm-4">Available URL</div>
                                <div class="col-sm-8"><input type="text" class="form-control" id="txtUrl" name="txtUrl" value="<?php echo $lsdata->available_url; ?>"></div>
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
                                    <input type="text" class="form-control" id="txtP" name="txtP" value="<?php echo $lsdata->rsa_prime_p; ?>">
                                </div>
                            </div><br>
                            <div class="row">
                                <div class="col-sm-4">Nilai Prima Q<br>
                                    <small>Bilangan Prima lebih besar dari 9990450271</small>
                                </div>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="txtQ" name="txtQ" value="<?php echo $lsdata->rsa_prime_q; ?>">
                                </div>
                            </div><br>
                            <div class="row">
                                <div class="col-sm-4">Modulo</div>
                                <div class="col-sm-8"><input type="text" class="form-control" id="txtModulo" name="txtModulo" value="<?php echo ($lsdata->rsa_modulo==''?'Otomatis muncul setelah data tersimpan':$lsdata->rsa_modulo); ?>" readonly></div>
                            </div><br>
                            <div class="row">
                                <div class="col-sm-4">Private Key</div>
                                <div class="col-sm-8"><input type="text" class="form-control" id="txtPrivateKey" name="txtPrivateKey" value="<?php echo ($lsdata->rsa_private_key==''?'Otomatis muncul setelah data tersimpan':$lsdata->rsa_private_key); ?>" readonly></div>
                            </div><br>
                            <div class="row">
                                <div class="col-sm-4">Public Key</div>
                                <div class="col-sm-8"><input type="text" class="form-control" id="txtPublicKey" name="txtPublicKey" value="<?php echo ($lsdata->rsa_public_key==''?'Otomatis muncul setelah data tersimpan':$lsdata->rsa_public_key); ?>" readonly></div>
                            </div><br>
                            <div class="row">
                                <div class="col-sm-4">Key Apps</div>
                                <div class="col-sm-8">CONCAT(Modulo, Private Key, Public Key)</div>
                            </div><br>
                            <div class="row">
                                <div class="col-sm-4">Update Nilai Prima</div>
                                <div class="col-sm-8">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="chkUpdatePrime" name="chkUpdatePrime" value="true">
                                        <label class="form-check-label" for="chkUpdatePrime"></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <?php
                $i++;
            endforeach; ?>
        <?php else: ?>
            Tidak Ada Data
        <?php endif; ?>
    <?php else: ?>
        Tidak Ada Data
    <?php endif; ?>
</div><br>

<script>
    function daftar_apps(){
        location.href = "<?php echo base_url()."Administrator/application_list" ?>";
    }

    $(function(){
        $("#frmUbahApps").validate({
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