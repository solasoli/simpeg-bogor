<?php if (isset($aktifitas_staf) and sizeof($aktifitas_staf) > 0 and $aktifitas_staf != ''){ ?>
    <?php foreach ($aktifitas_staf as $lsdata): ?>
        <label>
            <input id="chkAktifitas<?php echo $lsdata->id_knj_kegiatan;?>" name="chkAktifitas[]" type="checkbox" class="css-checkbox lrg"
                   value="<?php echo $lsdata->id_knj_kegiatan_enc;?>">
            <label for="chkAktifitas<?php echo $lsdata->id_knj_kegiatan;?>" name="chkAktifitas_lbl" class="css-label lrg vlad"></label>
            <span style="color: saddlebrown; font-weight: bold;">
                <?php echo $no_urut.') '.$lsdata->kegiatan_rincian; ?>
            </span>
        </label>
        <br>
        <?php echo 'Keterangan: ' . $lsdata->kegiatan_keterangan; ?><br>
        <?php echo 'SKP: ' . $lsdata->uraian_tugas; ?>
        <br>
        <?php echo 'Waktu: '.$lsdata->tgl_kegiatan; ?>.
        Durasi: <?php echo $lsdata->durasi_menit; ?> menit <br>Output:
        <?php echo $lsdata->kuantitas.' '.$lsdata->satuan; ?><br>
        <?php if ($lsdata->approved == '') { ?>
            <span class="rounded_box_default">Belum diproses</span>
        <?php } elseif ($lsdata->approved == 1) { ?>
            <span class="rounded_box_green">Disetujui</span>
        <?php } elseif ($lsdata->approved == 2) { ?>
            <span class="rounded_box_orange">Revisi</span>
        <?php } else { ?>
            <span class="rounded_box_red">Ditolak</span>
        <?php } ?>

        <?php
        if($lsdata->approved == ''){
        }elseif ($lsdata->approved == 1 or $lsdata->approved == 2 or $lsdata->approved == 3){
            echo '<br>Catatan Atasan: '.($lsdata->catatan_approved==''?'-':$lsdata->catatan_approved).' ('.$lsdata->tgl_approved2.')';
        }
        ?><br>
        <?php if($lsdata->approved == '' or $lsdata->approved == '0'): ?>
            <input value="" type="text" id="txtApproval<?php echo $lsdata->id_knj_kegiatan;?>" name="txtApproval<?php echo $lsdata->id_knj_kegiatan;?>" class="cell-sm-11" placeholder="Catatan" style="margin-bottom: -10px;"><br>
        <?php endif; ?>
        <?php if($lsdata->approved == ''): ?>
            <a href="javascript:void(0);" onclick="proses_persetujuan_aktifitas(1, <?php echo $lsdata->id_knj_kegiatan;?>, '<?php echo $lsdata->id_knj_kegiatan_enc;?>', <?php echo $no_urut; ?>);"><span class="mif-checkmark icon"></span> Disetujui</a> &nbsp;
            <a href="javascript:void(0);" onclick="proses_persetujuan_aktifitas(2, <?php echo $lsdata->id_knj_kegiatan;?>, '<?php echo $lsdata->id_knj_kegiatan_enc;?>', <?php echo $no_urut; ?>);"><span class="mif-pencil icon"></span> Revisi</a> &nbsp;
            <a href="javascript:void(0);" onclick="proses_persetujuan_aktifitas(3, <?php echo $lsdata->id_knj_kegiatan;?>, '<?php echo $lsdata->id_knj_kegiatan_enc;?>', <?php echo $no_urut; ?>);"><span class="mif-cross icon"></span> Ditolak</a>
        <?php else: ?>
            <a href="javascript:void(0);" onclick="proses_persetujuan_aktifitas(0, <?php echo $lsdata->id_knj_kegiatan;?>, '<?php echo $lsdata->id_knj_kegiatan_enc;?>', <?php echo $no_urut; ?>);"><span class="mif-cancel icon"></span> Batalkan Pemrosesan</a>
        <?php endif; ?>
        <?php
            if($lsdata->url_berkas_eviden!=''){
                echo '&nbsp;<a href="javascript:void(0)" onclick="get_berkas(\''.$lsdata->url_berkas_eviden.'\')"><span class="mif-download icon"></span> Unduh</a>';
            }
        ?>
    <?php endforeach; ?>
<?php }else{
    echo 'Data tidak ditemukan';
} ?>