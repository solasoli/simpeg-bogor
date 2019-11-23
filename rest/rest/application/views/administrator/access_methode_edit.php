<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<div class="container-fluid">
<p>Mengubah data akses methode untuk aplikasi.</p>
<?php if (isset($akses_methode) and sizeof($akses_methode) > 0): ?>
    <?php $i = 1; ?>
    <?php if ($akses_methode != ''): ?>
        <?php foreach ($akses_methode as $lsdata): ?>
        <form action="" method="post" id="frmUbahAksesMethode" novalidate="novalidate" enctype="multipart/form-data">
            <input id="submitok" name="submitok" type="hidden" value="1">
            <div class="row">
                <div class="col-sm-4">Entitas</div>
                <div class="col-sm-8">
                    <input type="hidden" class="form-control" id="txtIdrest_access" name="txtIdrest_access"
                           value="<?php echo $lsdata->idrest_access; ?>">
                    <?php echo $lsdata->entitas; ?>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4">Methode</div>
                <div class="col-sm-8">
                    <?php echo $lsdata->judul; ?> (<?php echo $lsdata->methode; ?>)
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4">Status</div>
                <div class="col-sm-6">
                    <select id="ddStatus" name="ddStatus" class="custom-select">
                        <option value="1" <?php echo ($lsdata->status_aktif==1?'selected':'');?>>Aktif</option>
                        <option value="0" <?php echo ($lsdata->status_aktif==0?'selected':'');?>>Tidak Aktif</option>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4"></div>
                <div class="col-sm-6">
                    <button id="btnregister" name="new_register" type="submit"
                            class="btn btn-success btn-sm" style="margin-top: 10px;">
                        <span data-feather="save"></span> Simpan</button>
                </div>
            </div>
        </form>
        <?php endforeach; ?>
    <?php else: ?>
        Tidak Ada Data
    <?php endif; ?>
<?php else: ?>
    Tidak Ada Data
<?php endif; ?>
</div>