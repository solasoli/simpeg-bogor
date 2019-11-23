<?php

if (isset($data_dasar) and sizeof($data_dasar) > 0 and $data_dasar != ''){
    foreach ($data_dasar as $lsdata) {
        $nip_baru = $lsdata->nip_baru;
        $nama = $lsdata->nama;
        $unit = $lsdata->unit;
    }
?>
<div style="background-color: rgba(205,205,208,0.35);padding: 5px;
    border: 1px solid rgba(82,91,135,0.35); font-size: 11pt; margin-bottom: 10px;">
    <strong><?php echo $nama; ?></strong><br>
    NIP: <?php echo $nip_baru; ?><br>
    Unit: <?php echo $unit; ?>
</div>
<?php } ?>

Daftar Laporan Kinerja Staf PLH berds. Periode :

<?php if (isset($riwayat_ekinerja_staf_plh) and sizeof($riwayat_ekinerja_staf_plh) > 0 and $riwayat_ekinerja_staf_plh != ''){ ?>
    <?php $j = 1; ?>
    <table class="table table-border cell-border compact">
        <tbody>
        <?php foreach ($riwayat_ekinerja_staf_plh as $lsdata): ?>
            <tr style="background-color: rgba(205,205,208,0.35)">
                <th>#</th>
                <th>Periode</th>
                <th>Tgl.Input</th>
                <th>Status</th>
                <th>Kegiatan</th>
            </tr>
            <tr>
                <td><?php echo $j; ?>.</td>
                <td style="text-align: center"><?php echo $lsdata->periode_bln.' '.$lsdata->periode_thn; ?></td>
                <td style="text-align: center;"><?php echo $lsdata->tgl_input_kinerja; ?></td>
                <td>
                    <?php
                        echo $lsdata->status_knj;
                        if($lsdata->flag_kalkulasi==1){
                            echo '<br>Sudah dikalkulasi pada '.$lsdata->tgl_update_kalkulasi;
                        }
                        ?>
                </td>
                <td style="text-align: center;">
                    <button onclick="peninjauan_aktifitas_staf_plh('<?php echo $lsdata->id_knj_master; ?>');" type="button"
                            class="button primary bg-darkOrange small drop-shadow" style="margin-bottom: 5px;"><span class="mif-file-text icon"></span> <?php echo $lsdata->jumlah_kegiatan.' item'; ?></button>
                </td>
            </tr>
            <?php $j++;
        endforeach; ?>
        </tbody>
    </table>
<?php }else{ ?>
    <br> Belum ada data
<?php } ?>


<script>
    function peninjauan_aktifitas_staf_plh(id_knj_master){
        //alert(id_knj_master + ', ' + idp_atsl_plh);
        location.href = "<?php echo base_url().$usr."/peninjauan_staf_detail_kegiatan_plh?idknjm=" ?>" + id_knj_master;
    }
</script>