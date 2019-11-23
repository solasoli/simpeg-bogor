
<strong>Jabatan Berbeda dengan Kondisi Eksisting (Pensiun/Tidak Terisi)</strong>
<br><br>
<?php if($tx_result == 'true' and $tx_result!=''): ?>
    <div class="row">
        <div class="span13">
            <div class="notice bg-darkGreen">
            <div class="fg-white"><strong>Selamat</strong> Data sukses tersimpan.</div>
        </div>
        </span>
    </div>
<?php elseif($tx_result == 'false' and $tx_result!=''): ?>
    <div class="row">
        <div class="span13">
            <div class="notice bg-darkRed">
            <div class="fg-white"><strong>Perhatian</strong> Data tidak sukses tersimpan.</div>
        </div>
    </div><br>
<?php endif; ?>
<?php  if (isset($hasil_kompare) and sizeof($hasil_kompare) > 0): ?>
    <form action="" method="post" id="frmUpdateJabatanKosong" novalidate="novalidate" enctype="multipart/form-data">
        <input id="submitok" name="submitok" type="hidden" value="1">
        <table class="table bordered striped" id="tbl_jabatan_kosong_baru" style="width: 100%;">
            <thead><th>No</th>
            <th>Jabatan</th>
            <th>Eselon</th>
            <th>Pegawai</th>
            </thead>
            <?php if(sizeof($hasil_kompare) > 0): ?>
                <?php $i=1;?>
                <?php foreach($hasil_kompare as $jab): ?>
                    <tr>
                        <td><?php echo $i++;?><input type="hidden" name="txtIdJab[]" value="<?php echo $jab->id_j; ?>"/></td>
                        <td><?php echo $jab->jabatan;?></td>
                        <td><?php echo $jab->eselon; ?></td>
                        <td><?php echo $jab->nama.' ('.($jab->nip_baru==''?'-':$jab->nip_baru).')';?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr class="error">
                    <td colspan="7"><i>Tidak ada data</i></td>
                </tr>
            <?php endif; ?>
        </table>
        <div class="row">
            <button id="btnregister" name="new_register" type="submit" class="button success"
                    style="height: 34px; margin-top: 0px;" onclick="return confirm('Anda yakin akan mengupdate data jabatan kosong?');">
                <span class="icon-floppy on-left"></span><strong>Update Jabatan Kososng</strong></button>
        </div>
    </form>
<?php else: ?>
    Tidak ada data
<?php endif; ?>