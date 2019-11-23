<style>
    .rounded_box_red {
        background-color: rgba(135,23,23,0.35);
        color: black;
        font-size: small;
        font-weight: normal;
        padding-left: 4px;
        padding-right: 4px;
        padding-top: 3px;
        padding-bottom: 3px;
        -moz-border-radius: 3px;
        -webkit-border-radius: 3px;
    }
    .rounded_box_orange {
        background-color: orange;
        color: black;
        font-size: small;
        font-weight: normal;
        padding-left: 4px;
        padding-right: 4px;
        padding-top: 3px;
        padding-bottom: 3px;
        -moz-border-radius: 3px;
        -webkit-border-radius: 3px;
    }
    .rounded_box_green {
        background-color: rgba(97,135,68,0.35);
        color: black;
        font-size: small;
        font-weight: normal;
        padding-left: 4px;
        padding-right: 4px;
        padding-top: 3px;
        padding-bottom: 3px;
        -moz-border-radius: 3px;
        -webkit-border-radius: 3px;
    }
    .rounded_box_default {
        background-color: rgba(82,91,135,0.35);
        color: black;
        font-size: small;
        font-weight: normal;
        padding-left: 4px;
        padding-right: 4px;
        padding-top: 3px;
        padding-bottom: 3px;
        -moz-border-radius: 3px;
        -webkit-border-radius: 3px;
    }
</style>

<?php if (isset($drop_data_list) and sizeof($drop_data_list) > 0 and $drop_data_list != ''):?>

    <?php if(isset($pgDisplay)): ?>
        <?php if($numpage > 0): ?>
            <div class="row" style="margin-top: 20px;">
                <div class="cell-sm-12">
                    Halaman ke <?php echo $curpage; ?> dari <?php echo $numpage; ?> | Jumlah : <?php echo $jmlData; ?>
                </div>
            </div>
            <?php echo $pgDisplay; ?>
        <?php endif; ?>
    <?php endif; ?>

<table id="tblAktifitas" class="table row-hover row-border compact">
    <thead>
    <tr>
        <th>No</th>
        <th>Uraian Aktifitas</th>
    </tr>
    </thead>
    <tbody>
        <?php
        $i = 1;
        $halaman = $start_number;
        foreach($drop_data_list as $lsdata) { ?>
            <tr>
                <td style="vertical-align: top;">
                    <?php echo $halaman+$i; ?>)
                </td>
                <td style="vertical-align: top;">
                    <span style="color: saddlebrown; font-weight: bold;">
                        <?php echo $lsdata->kegiatan_rincian; ?>
                    </span>
                    <br>
                    <?php echo 'Keterangan: ' . $lsdata->kegiatan_keterangan; ?><br>
                    <span style="color: rosybrown"><?php echo 'SKP: ' . $lsdata->uraian_tugas; ?></span>
                    <br>
                    <?php echo 'Waktu: '.$lsdata->tgl_kegiatan; ?>
                    Durasi: <?php echo $lsdata->durasi_menit; ?> menit
                    <br>Output:
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
                        if($lsdata->url_berkas_eviden!=''){
                            echo '<br><a href="javascript:void(0)" onclick="get_berkas(\''.$lsdata->url_berkas_eviden.'\')"><span class="mif-download icon"></span> Download</a>';
                        }
                    ?>
                </td>
            </tr>
        <?php
            $i++;
            } ?>
    </tbody>
</table>
<?php else: ?>
    <br>Data tidak ditemukan.
<?php endif; ?>

<script>
    function get_berkas(berkas){
        window.open('/ekinerja2/berkas/'+berkas, '_blank');
    }
</script>
