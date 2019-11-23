<small><span style="text-decoration: underline; font-weight: bold;">Informasi SKP</span><br>
<?php
    if (isset($info_skp) and sizeof($info_skp) > 0 and $info_skp != ''){
        foreach ($info_skp as $lsk){
            echo 'ID: '.$lsk->id_skp.' ('.$lsk->status.'). TMT: '.$lsk->periode_awal.'<br>';
            echo 'Atasan: '.$lsk->nama.'<br>';
            echo 'Unit Kerja: '.$lsk->unit_kerja;
            echo "<input type=\"hidden\" id=\"txtIdSkp\" name=\"txtIdSkp\" value='$lsk->id_skp'>";
            echo "<input type=\"hidden\" id=\"txtTmtSkp\" name=\"txtTmtSkp\" value='$lsk->tmt'>";
            $idpenilai = $lsk->id_penilai;
        }
    }else{
        echo "<input type=\"hidden\" id=\"txtIdSkp\" name=\"txtIdSkp\" value=''>";
        echo 'Tidak ada informasi SKP';
    }
    $cekFirstSKP = 1;
?></small>
<?php
    if(@$eselon!=''){
        $checkJbtn = $this->ekinerja->get_result_check_admin_pratama_admin($kode_jabatan);
    }
?>
<br><select id="ddKatKegiatan" name="ddKatKegiatan" style="color: black" class="cell-sm-<?php echo($existStkSkp==0?'12':'12'); ?>"> <!-- data-role="select" -->
    <option value="0">Pilih Target Kegiatan</option>
    <?php if (isset($list_stk_skp) and sizeof($list_stk_skp) > 0 and $list_stk_skp != ''): ?>
        <?php foreach ($list_stk_skp as $ls): ?>
            <option value="<?php echo $ls->id; ?>"><?php echo $ls->kegiatan; ?></option>
        <?php endforeach; ?>
        <?php if($checkJbtn==1): ?>
            <option value="-2">Instruksi Khusus Pimpinan (IKP) khusus JPT</option>
        <?php endif; ?>
        <option value="-1">Tugas Tambahan</option>
        <option value="-4">Tugas Tambahan Khusus</option>
        <option value="-3">Penyesuaian Target Baru</option>
    <?php endif; ?>
</select>
<?php echo($cekFirstSKP==0?'<span style="color: red;font-size: small;">Atasan langsung aktual tidak sama dengan atasan langsung pada SKP terakhir, harap disesuaikan dahulu</span><br>':''); ?>
<?php echo($existStkSkp==0?'<span style="color: red;font-size: small;">SKP Belum Ada</span><br>':''); ?>

<script>
    jQuery.validator.addMethod(
        "selectComboJenis",
        function (value, element)
        {
            if (element.value === "0") {
                return false;
            }else {
                return true;
            }
        },
        "*"
    );

    $( "#ddKatKegiatan" ).addClass( "selectComboJenis" );
</script>
