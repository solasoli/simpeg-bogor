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

Daftar Laporan Kinerja berds. Periode :
<?php if (isset($riwayat_ekinerja_staf) and sizeof($riwayat_ekinerja_staf) > 0 and $riwayat_ekinerja_staf != ''){ ?>
    <?php $j = 1; ?>
    <table class="table table-border cell-border compact">
        <tbody>
        <?php foreach ($riwayat_ekinerja_staf as $lsdata): ?>
            <?php $data_at = $this->ekinerja->data_ref_list_hist_alih_tugas_by_idknj($lsdata->id_knj_master); ?>
            <tr style="background-color: rgba(205,205,208,0.35)">
                <th>#</th>
                <th>Periode</th>
                <th>Tgl.Input</th>
                <th>Status</th>
            </tr>
            <tr>
                <td><?php echo $j; ?>.</td>
                <td style="text-align: center"><?php echo $this->umum->monthName($lsdata->periode_bln).' '.$lsdata->periode_thn; ?></td>
                <td style="text-align: center;"><?php echo $lsdata->tgl_input_kinerja; ?></td>
                <td><?php echo $lsdata->status_knj; ?></td>
            </tr>
            <tr>
                <td></td>
                <td colspan="5">
                    <strong>Unit Kerja Terakhir:</strong><br>
                    <span style="font-size: small"><?php echo $lsdata->last_unit_kerja; ?><br>
                        Atasan : <?php echo $lsdata->last_atsl_nama; ?><br>
                        <span><?php echo $lsdata->last_atsl_jabatan; ?></span><br>
                        Pejabat : <?php echo ($lsdata->last_pjbt_nama==''?'-':$lsdata->last_pjbt_nama); ?><br>
                        <span><?php echo $lsdata->last_pjbt_jabatan; ?></span></span><br>
                    <?php if (isset($data_at) and sizeof($data_at) > 0 and $data_at != ''): ?>
                    <button onclick="rekapitulasi_staf('<?php echo $lsdata->id_knj_master; ?>')" type="button" class="button primary bg-darkBlue small drop-shadow"><span class="mif-file-text icon"></span> Rekapitulasi</button><br>
                    <?php endif; ?>
                    <strong>Riwayat Alih Tugas:</strong> <br>
                    <?php
                    if (isset($data_at) and sizeof($data_at) > 0 and $data_at != ''){
                        $b = 1;
                        foreach ($data_at as $lsdata2){ ?>
                            <div class="row">
                                <div class="cell-11" style="font-size: small">
                                    <span style="color: mediumblue"> <?php echo $b.') '; ?>
                                        Jabatan : (<?php echo $lsdata2->kode_jabatan;?>) <?php echo $lsdata2->jabatan; ?><br>
                                        Kelas : <?php echo $lsdata2->kelas_jabatan.' ('.$lsdata2->nilai_jabatan.')';?>. Tunjangan: Rp. <?php echo number_format($lsdata2->rupiah_awal_tkd,0,",",".") ?><br>
                                        Unit Kerja : <?php echo $lsdata2->unit_kerja;?><br>
                                        TMT. Kinerja : <?php echo $lsdata2->tmt;?>. Tgl. Input : <?php echo $lsdata2->tgl_input;?>
                                    </span><br>
                                    Atasan : <?php echo $lsdata2->atsl_nama.' ('.$lsdata2->atsl_jabatan.')';?><br>
                                    Pejabat : <?php echo ($lsdata2->pjbt_nama==''?'-':$lsdata2->pjbt_nama).($lsdata2->pjbt_nama==''?'':' ('.$lsdata2->pjbt_jabatan.')');?><br>
                                    <span style="color: indianred;">Jumlah Kegiatan : <?php echo $lsdata2->jml_aktifitas;?> aktifitas</span><br>
                                    <button onclick="peninjauan_aktifitas_staf('<?php echo $lsdata->id_knj_master; ?>', '<?php echo $lsdata2->idp_atsl_enc; ?>','<?php echo $lsdata2->idknj_hist_alih_tugas; ?>');" type="button" class="button primary bg-darkOrange small drop-shadow" style="margin-bottom: 5px;"><span class="mif-file-text icon"></span> Lihat Aktifitas</button>
                                </div>
                            </div>
                            <?php
                            $b++;
                        }
                    }else{
                        echo "Belum ada data";
                    }
                    ?>
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
    function peninjauan_aktifitas_staf(id_knj_master, idp_atsl, idknj_alih_tgs){
        location.href = "<?php echo base_url().$usr."/peninjauan_staf_detail_kegiatan?idknjm=" ?>" + id_knj_master + "&idpatsl=" + idp_atsl + "&idknjalhtgs=" + idknj_alih_tgs;
    }

    function rekapitulasi_staf(id_knj_master){
        location.href = "<?php echo base_url().$usr."/detail_laporan_kinerja_staf?idknjm=" ?>" + id_knj_master;
    }
</script>