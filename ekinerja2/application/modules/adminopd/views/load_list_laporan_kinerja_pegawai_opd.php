<?php if(isset($drop_data_list)): ?>
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
    <div style="overflow-x: auto; border: 1px solid rgba(71,71,72,0.35); margin-top: 5px;">
        <table id="tblListLaporanKinerjaPegawaiOpd" class="table row-hover row-border compact">
            <tr style="border-bottom: 3px solid yellowgreen">
                <th>Personil</th>
                <th style="width: 50%;">Pencapaian Kinerja</th>
            </tr>
            <tbody>
            <?php if(sizeof($drop_data_list)==0):?>
                <tr><td colspan="2">Data tidak ditemukan</td></tr>
            <?php else: ?>
                <?php
                $i = 1;
                $halaman = $start_number;
                foreach($drop_data_list as $lsdata) {?>
                    <tr>
                        <td style="vertical-align: top;">
                            <strong><?php echo $halaman+$i.') '.$lsdata->nama; ?></strong><br>
                            <?php echo $lsdata->nip_baru; ?><br>
                            Golongan : <?php echo $lsdata->pangkat_gol; ?><br>
                            <?php echo substr($lsdata->last_jabatan,0,(strpos($lsdata->last_jabatan,'pada')==0?strlen($lsdata->last_jabatan):strpos($lsdata->last_jabatan,'pada'))).' ('.$lsdata->last_kode_jabatan.')'; ?><br>
                            <?php echo $lsdata->last_jenjab.($lsdata->last_eselon!='Staf'?' ('.$lsdata->last_eselon.')':''); ?><br>
                            <small>
                                Atasan Langsung : <?php echo $lsdata->last_atsl_nama; ?><br><br>
                                <span style="font-weight: bold;">Rekap Nilai Akhir :</span><br>
                                Target Kinerja (60%) : Rp. <?php echo number_format($lsdata->rupiah_awal_kinerja,0,",","."); ?><br>
                                Target Kedisiplinan (40%) : Rp. <?php echo number_format($lsdata->rupiah_awal_disiplin,0,",","."); ?><br>
                                Pencapaian Kedisiplinan : <?php echo number_format($lsdata->last_persen_disiplin,2,".","."); ?>% =
                                Rp. <?php echo number_format($lsdata->last_rupiah_disiplin,0,",","."); ?><br>
                                Pencapaian Kinerja : <?php echo $lsdata->persen_kinerja_final; ?>% =
                                Rp. <?php echo number_format($lsdata->rupiah_kinerja_aktual,0,",","."); ?><br>
                                Tunjangan Perolehan Total : Rp. <?php echo number_format($lsdata->rupiah_kinerja_final,0,",","."); ?>
                                <br><br><span style="font-weight: bold;color: darkgreen;">Tunjangan Akhir : Rp. <?php echo number_format($lsdata->last_rupiah_kinerja_final,0,",","."); ?></span>
                            </small><br><br>
                            <button id="btnCetakLaporan" onclick="fnCetakLaporan('<?php echo $lsdata->id_knj_master_enc; ?>');"
                                    type="button" class="button rounded primary bg-grayBlue small drop-shadow" style="margin-bottom: 5px;">
                                <span class="mif-printer icon"></span> Cetak Laporan</button>
                            <button id="btnCetakAktifitas" onclick="fnCetakAktifitas('<?php echo $lsdata->id_knj_master_enc; ?>');"
                                    type="button" class="button rounded primary fg-white bg-taupe small drop-shadow" style="margin-bottom: 5px;">
                                <span class="mif-printer icon"></span> Cetak Aktifitas</button>
                        </td>
                        <td style="vertical-align: top;">
                            <span style="color: blue; font-weight: bold;">Periode : <?php echo $this->umum->monthName($lsdata->periode_bln) . ' ' . $lsdata->periode_thn; ?></span>
                            <br>Status : <?php echo $lsdata->status_knj; ?>
                            <br>Kalkulasi nilai : <?php echo($lsdata->flag_kalkulasi==0?'Belum':'Sudah pada '.$lsdata->tgl_update_kalkulasi); ?>
                            <br><small>
                                <span style="font-weight: bold;">Detail :</span><br>
                                Tgl.Input : <?php echo $lsdata->tgl_input_kinerja; ?><br>
                                Jml waktu efektif kerja : <?php echo $lsdata->jml_menit_efektif_kerja; ?> menit <br>
                                Jml waktu kinerja : <?php echo $lsdata->jml_waktu_kinerja_accu; ?> menit (<?php echo $lsdata->persen_kinerja_accu; ?>%) =
                                Rp. <?php echo number_format($lsdata->rupiah_kinerja,0,",","."); ?>
                                <?php if($lsdata->last_eselon!='Staf'): ?>
                                <br>Jml staf aktual : <?php echo $lsdata->jml_bawahan_aktual; ?> orang
                                <br>Jml staf eKinerja : <?php echo $lsdata->jml_bawahan_kinerja; ?> orang. Kinerja <?php echo number_format($lsdata->persen_kinerja_accu_bawahan, 0,",","."); ?> %
                                <br>Kinerja staf aktual : <?php echo number_format($lsdata->persen_kinerja_bawahan_aktual,0,",","."); ?>%
                                <br>Kinerja aktual : <?php echo number_format($lsdata->persen_kinerja_aktual,0,",","."); ?>% =
                                    Rp. <?php echo number_format($lsdata->rupiah_kinerja_aktual,0,",","."); ?>
                                <?php endif; ?>
                                <br>Jml hari efektif kerja : <?php echo $lsdata->jml_hari_efektif_kerja; ?> |
                                Jml kehadiran : <?php echo $lsdata->jml_kehadiran_accu; ?> (<?php echo $lsdata->persen_kehadiran_accu; ?>%)
                                <br>Jml tidak hadir : <?php echo $lsdata->jml_tidak_hadir_accu; ?> (<?php echo $lsdata->persen_minus_tidak_hadir_accu; ?>%)
                                <br>Terlambat / pulang cepat : <?php echo $lsdata->persen_minus_terlambat_plg_cpt_accu; ?>%
                                <br>Jml hari efektif apel : <?php echo $lsdata->jml_hari_efektif_apel; ?> |
                                Jml tidak apel : <?php echo $lsdata->jml_tidak_apel_accu; ?> (<?php echo $lsdata->persen_minus_tidak_apel_accu; ?>%)
                                <br>Nilai Kedisiplinan : <?php echo number_format($lsdata->persen_disiplin_final,2,".","."); ?>% = Rp. <?php echo number_format($lsdata->rupiah_disiplin,0,",","."); ?>
                                <br><span style="font-weight: bold;">Unsur lainnya :</span>
                                <br>Penambahan : <?php echo $lsdata->jumlah_penambahan_item_lain; ?> (<?php echo $lsdata->persen_penambahan_item_lain; ?>%)
                                <br>Pengurangan disiplin : <?php echo $lsdata->jumlah_pengurangan_item_lain; ?> (<?php echo number_format($lsdata->persen_pengurangan_item_lain,0,".","."); ?>%) =
                                Rp. <?php echo number_format((($lsdata->persen_pengurangan_item_lain/100)*$lsdata->last_rupiah_disiplin),0,",","."); ?>
                                <br>Pengurangan dari total : <?php echo number_format($lsdata->jumlah_pengurangan_item_lain_maks,0,".","."); ?> (<?php echo number_format($lsdata->persen_pengurangan_item_lain_maks,0,".","."); ?>%) =
                                Rp. <?php echo number_format((($lsdata->persen_pengurangan_item_lain_maks/100)*$lsdata->rupiah_kinerja_final),0,",","."); ?>
                            </small>
                        </td>
                    </tr>
                    <?php
                    $i++;
                } ?>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
<?php else: ?>
    Data tidak ditemukan.
<?php endif; ?>

<script>
    function fnCetakLaporan(id_knj_master_enc){
        window.open('/ekinerja2/adminopd/cetak_laporan_kinerja_pegawai/' + id_knj_master_enc, '_blank');
    }

    function fnCetakAktifitas(id_knj_master_enc){
        window.open('/ekinerja2/adminopd/cetak_laporan_kinerja_pegawai_aktifitas/' + id_knj_master_enc, '_blank');
    }
</script>