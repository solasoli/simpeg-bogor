<?php if (isset($drop_data_list) and sizeof($drop_data_list) > 0 and $drop_data_list != ''){ ?>
    <?php if(isset($pgDisplay)): ?>
        <?php if($numpage > 0): ?>
            <div class="row" style="margin-top: 20px;">
                <div class="cell-sm-4">
                    Halaman ke <?php echo $curpage; ?> dari <?php echo $numpage; ?> | Jumlah : <?php echo $jmlData; ?>
                </div>
            </div>
            <?php echo $pgDisplay; ?>
        <?php endif; ?>
    <?php endif; ?>

    <div id="dvAllListAktifitas">
        <table id="tblAktifitas" class="table row-hover row-border compact"
               style="margin-bottom: 0px;border-bottom: 1px solid rgba(71,71,72,0.35); margin-top: 10px;">
            <thead>
            <tr>
                <th style="text-align: center;">Uraian Aktifitas</th>
            </tr>
            </thead>
            <tbody>
                <?php $i = 1; ?>
                <?php foreach ($drop_data_list as $lsdata): ?>
                    <tr>
                        <td>
                            <div id="dvListAct<?php echo $lsdata->id_knj_kegiatan;?>">
                                <span style="color: saddlebrown; font-weight: bold;">
                                        <?php echo $lsdata->no_urut.') '.$lsdata->kegiatan_rincian; ?>
                                </span>
                                <br>
                                <?php echo 'Keterangan: ' . $lsdata->kegiatan_keterangan; ?><br>
                                <span style="color: rosybrown"><?php echo 'SKP: ' . $lsdata->uraian_tugas; ?></span>
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
                                    echo '<br>Catatan Atasan: '.($lsdata->catatan_approved==''?'-':$lsdata->catatan_approved).' (Oleh: '.$lsdata->nama.' pada '.$lsdata->tgl_approved2.')';
                                }
                                ?>
                                <?php if($lsdata->url_berkas_eviden!=''){ ?>
                                    &nbsp;<a href="javascript:void(0)" onclick="get_berkas('<?php echo $lsdata->url_berkas_eviden; ?>')"><span class="mif-download icon"></span> Download</a>
                                <?php } ?>
                            </div>
                        </td>
                    </tr>
                    <?php $i++; ?>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <script>
        function get_berkas(berkas){
            window.open('/ekinerja2/berkas/'+berkas, '_blank');
        }
    </script>
<?php }else{
    echo 'Data tidak ditemukan';
} ?>
