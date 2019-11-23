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
            <strong>Selamat</strong> Data sukses tersimpan. <a href="<?php echo base_url()."Administrator/ubah_methode/$idmethode"?>">Lanjut input parameter atau respons.</a>
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
    <h4>Tambah Methode Baru</h4>
    <p>Menambah data methode baru yang sudah diimplementasikan dalam bentuk fungsi pada entitas class (kategori API) tertentu.</p>
    <form action="" method="post" id="frmTambahMethode" novalidate="novalidate" enctype="multipart/form-data">
        <input id="submitok" name="submitok" type="hidden" value="1">
        <div class="row">
            <div class="col-sm-6">
                <div class="row">
                    <div class="col-sm-3">Judul</div>
                    <div class="col-sm-8"><input type="text" class="form-control" id="txtJudul" name="txtJudul"></div>
                </div><br>
                <div class="row">
                    <div class="col-sm-3">Uraian</div>
                    <div class="col-sm-8"><textarea class="form-control" rows="3" id="txtUraian" name="txtUraian" style="resize: none"></textarea></div>
                </div><br>
                <div class="row">
                    <div class="col-sm-3">Entitas</div>
                    <div class="col-sm-8">
                        <?php if (isset($entitas_list)): ?>
                            <select id="ddEntitas" name="ddEntitas" class="custom-select">
                                <?php foreach ($entitas_list as $ls): ?>
                                    <?php if ($ls->entitas == $entitas): ?>
                                        <option value="<?php echo $ls->entitas; ?>" selected><?php echo $ls->entitas.' ('.$ls->keterangan.')'; ?></option>
                                    <?php else: ?>
                                        <option value="<?php echo $ls->entitas; ?>"><?php echo $ls->entitas.' ('.$ls->keterangan.')'; ?></option>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </select>
                        <?php endif; ?>
                    </div>
                </div><br>
                <div class="row">
                    <div class="col-sm-3">Function</div>
                    <div class="col-sm-8"><input type="text" class="form-control" id="txtFungsi" name="txtFungsi"></div>
                </div><br>
                <div class="row">
                    <div class="col-sm-3">URL</div>
                    <div class="col-sm-8">
                        <textarea class="form-control" rows="2" id="txtUrl" name="txtUrl" style="resize: none"></textarea>
                    </div>
                </div><br>
                <div class="row">
                    <div class="col-sm-3">Methode</div>
                    <div class="col-sm-8">
                        <?php if (isset($methode_type_list)): ?>
                            <select id="ddMethode" name="ddMethode" class="custom-select">
                                <?php foreach ($methode_type_list as $ls): ?>
                                    <?php if ($ls->methode_type == $methode_type): ?>
                                        <option value="<?php echo $ls->methode_type; ?>" selected><?php echo $ls->methode_type; ?></option>
                                    <?php else: ?>
                                        <option value="<?php echo $ls->methode_type; ?>"><?php echo $ls->methode_type; ?></option>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </select>
                        <?php endif; ?>
                    </div>
                </div><br>
                <div class="row">
                    <div class="col-sm-3"></div>
                    <div class="col-sm-9">
                        <button id="btnregister" name="new_register" type="submit" class="btn btn-success btn-sm"><span data-feather="save"></span> Simpan</button>
                        <button onclick="daftar_methode()" type="button" class="btn btn-primary btn-sm"><span data-feather="arrow-left-circle"></span> Lihat Daftar</button>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="row">
                    <div class="col-sm-4">Sample Call</div>
                    <div class="col-sm-8"><textarea class="form-control" rows="9" id="txtSampleCall" name="txtSampleCall" style="resize: none"></textarea></div>
                </div><br>
                <div class="row">
                    <div class="col-sm-4">Keterangan</div>
                    <div class="col-sm-8"><textarea class="form-control" rows="3" id="txtKet" name="txtKet" style="resize: none"></textarea></div>
                </div><br>
                <div class="row">
                    <div class="col-sm-4">Parameter Terenkripsi</div>
                    <div class="col-sm-8">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="chkParamEnkrip" name="chkParamEnkrip" value="true">
                            <label class="form-check-label" for="chkParamEnkrip"></label>
                        </div>
                    </div>
                </div><br>
            </div>
        </div>
    </form>
</div>

<script>

    function daftar_methode(){
        location.href = "<?php echo base_url()."Administrator/methode_all_list" ?>";
    }

    $(function(){
        $("#frmTambahMethode").validate({
            errorClass: 'errors',
            ignore: "",
            rules: {
                txtJudul: {
                    required: true
                },
                txtUraian: {
                    required: true
                },
                txtFungsi: {
                    required: true
                },
                txtUrl:{
                    required: true
                },
                txtSampleCall:{
                    required: true
                },
                txtKet:{
                    required: true
                }
            },
            messages: {
                txtJudul: {
                    required: "Anda belum mengisi Judul"
                },
                txtUraian: {
                    required: "Anda belum mengisi Uraian"
                },
                txtFungsi: {
                    required: "Anda belum mengisi Nama Fungsi"
                },
                txtUrl: {
                    required: "Anda belum mengisi URL"
                },
                txtSampleCall: {
                    required: "Anda belum mengisi Sample Call"
                },
                txtKet: {
                    required: "Anda belum mengisi Keterangan"
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