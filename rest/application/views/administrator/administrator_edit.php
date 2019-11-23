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

    <h4>Ubah Pengguna</h4>
    <p>Mengubah data pengguna aplikasi dokumentasi SIMPEG RestAPI.</p>
    <?php if (isset($admin) and sizeof($admin) > 0): ?>
        <?php $i = 1; ?>
        <?php if ($admin != ''): ?>
            <?php foreach ($admin as $lsdata): ?>
                <form action="" method="post" id="frmUbahUser" novalidate="novalidate" enctype="multipart/form-data">
                    <input id="submitok" name="submitok" type="hidden" value="1">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="row">
                                <div class="col-sm-4">Pegawai</div>
                                <div class="col-sm-7">
                                    <div class="ui-widget">
                                        <input type="text" class="form-control" id="txtNama" name="txtNama" value="<?php echo $lsdata->nama; ?>" readonly>
                                    </div>
                                    <input type="hidden" class="form-control" id="txtIdRestAdmin" name="txtIdRestAdmin" value="<?php echo $lsdata->idrest_admin; ?>">
                                </div>
                            </div><br>
                            <div class="row">
                                <div class="col-sm-4">User Name</div>
                                <div class="col-sm-7">
                                    <div class="ui-widget">
                                        <input type="text" class="form-control" id="txtUName" name="txtUName" value="<?php echo $lsdata->user_name; ?>" readonly>
                                    </div>
                                </div>
                            </div><br>
                            <div class="row">
                                <div class="col-sm-4">Password Lama</div>
                                <div class="col-sm-7">
                                    <input type="password" class="form-control" id="txtPwdLama" name="txtPwdLama" value="<?php echo $lsdata->password; ?>" readonly>
                                </div>
                            </div><br>
                            <div class="row">
                                <div class="col-sm-4">Password Baru</div>
                                <div class="col-sm-7">
                                    <input type="password" class="form-control" id="txtPwd" name="txtPwd">
                                </div>
                            </div><br>
                            <div class="row">
                                <div class="col-sm-4">Status Pengguna</div>
                                <div class="col-sm-7">
                                    <select id="ddStatusUser" name="ddStatusUser" class="custom-select">
                                        <option value="Administrator" <?php echo ($lsdata->status_pengguna=='Administrator'?'selected':'');?>>Administrator</option>
                                        <option value="User" <?php echo ($lsdata->status_pengguna=='User'?'selected':'');?>>User</option>
                                    </select>
                                </div>
                            </div><br>
                            <div class="row">
                                <div class="col-sm-4">Status Aktif</div>
                                <div class="col-sm-7">
                                    <select id="ddStatusAktif" name="ddStatusAktif" class="custom-select">
                                        <option value="1" <?php echo ($lsdata->status_aktif==1?'selected':'');?>>Aktif</option>
                                        <option value="0" <?php echo ($lsdata->status_aktif==0?'selected':'');?>>Tidak Aktif</option>
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
                <?php
                $i++;
            endforeach; ?>
        <?php else: ?>
            Tidak Ada Data
        <?php endif; ?>
    <?php else: ?>
        Tidak Ada Data
    <?php endif; ?>
</div>

<script>
    function daftar_pengguna(){
        location.href = "<?php echo base_url()."Administrator/admin_list" ?>";
    }
</script>