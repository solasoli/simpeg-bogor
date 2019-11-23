<?php
    if (isset($knjmaster) and sizeof($knjmaster) > 0 and $knjmaster != '') {
        foreach ($knjmaster as $lsdata) {
            $jml_bawahan_aktual = $lsdata->jml_bawahan_aktual;
            $jml_bawahan_kinerja = $lsdata->jml_bawahan_kinerja;
            $persen_kinerja_accu_bawahan = $lsdata->persen_kinerja_accu_bawahan;
            $persen_kinerja_bawahan_aktual = $lsdata->persen_kinerja_bawahan_aktual;
            $persen_kinerja_aktual = $lsdata->persen_kinerja_aktual;
            $tunjangan_kinerja_aktual = number_format($lsdata->rupiah_kinerja_aktual,0,",",".");
            $last_rupiah_kinerja_final = number_format($lsdata->last_rupiah_kinerja_final,0,",",".");
        }
    }
?>

<div style="font-size: 11pt;">
<strong>Rincian Nilai Laporan Kinerja</strong>
<?php if (isset($nilai_hist_alih_tugas) and sizeof($nilai_hist_alih_tugas) > 0 and $nilai_hist_alih_tugas != ''): ?>
    <?php if(sizeof($nilai_hist_alih_tugas)==1): ?>
        <br>
        <?php foreach ($nilai_hist_alih_tugas as $lsdata): ?>
            <span style="color: saddlebrown; font-weight: bold;">Atasan Langsung : <?php echo $lsdata->atsl_nama; ?></span><br>
            <span style="color: blue">Periode : <?php echo $this->umum->monthName($lsdata->periode_bln).' '.$lsdata->periode_thn; ?></span><br>
            Tgl.Pembuatan : <?php echo $lsdata->tmt; ?><br>
            Jabatan : <?php echo $lsdata->jabatan.' ('.$lsdata->kode_jabatan.')'; ?><br>
            Kelas Jabatan : <?php echo $lsdata->kelas_jabatan.' ('.$lsdata->nilai_jabatan.')'; ?><br>
            Nilai Tunjangan : Rp. <?php echo number_format($lsdata->rupiah_awal_tkd,0,",",".").
            '<br>Komposisi : Kinerja (60%): Rp. '.number_format($lsdata->rupiah_awal_kinerja,0,",",".").
            ' Kedisiplinan (40%): Rp. '.number_format($lsdata->rupiah_awal_disiplin,0,",","."); ?> <br>
            <strong>Pencapaian:</strong><br>
            Kinerja : <?php echo $lsdata->persen_kinerja_final.'% (Rp. '.number_format($lsdata->rupiah_kinerja,0,",",".").')'; ?><br>
            Kedisiplinan : <?php echo $lsdata->persen_disiplin_final.'% (Rp. '.number_format($lsdata->rupiah_disiplin,0,",",".").')'; ?><br>
            Jumlah Akhir : Rp. <?php echo number_format($lsdata->rupiah_kinerja_final,0,",","."); ?>
            <?php
                if($lsdata->eselon!='' or strpos($lsdata->jabatan, 'Plt')!==false){
                    //if($lsdata->persen_kinerja_final>80){
                        echo '<br>Unsur Kinerja (80%) : '.'Rp. '.number_format((0.8*$lsdata->rupiah_kinerja),0,",",".");
                        echo '<br>Jumlah Staf Aktual: '.$jml_bawahan_aktual.' orang';
                        echo '<br>Jumlah Staf eKinerja: '.$jml_bawahan_kinerja.' orang';
                        echo '<br>Persentase Kinerja Staf: '.$persen_kinerja_accu_bawahan.'%';
                        echo '<br>Persentase Kinerja Staf Aktual: '.$persen_kinerja_bawahan_aktual.'%';
                        echo '<br>Persentase Kinerja Aktual: '.$persen_kinerja_aktual.'%';
                        echo '<br>Tunjangan Kinerja Aktual: Rp. '.$tunjangan_kinerja_aktual.',-';
                        echo '<br>Tunjangan Hasil Akhir Kinerja: Rp. '.$last_rupiah_kinerja_final.',-';
                    //}
                }
            ?>
            <?php $detail_tunjangan = $this->ekinerja->data_ref_detail_nilai_tunjangan_by_hist_alih_tugas($lsdata->idknj_hist_alih_tugas_enc); ?>
            <?php if (isset($detail_tunjangan) and sizeof($detail_tunjangan) > 0 and $detail_tunjangan != ''):?>
                <br><strong>Uraian:</strong><br>
                <div style="overflow-x: auto; border: 1px solid rgba(71,71,72,0.35);">
                    <table class="table row-hover row-border compact" style="margin-bottom: 0px;">
                        <tr style="border-bottom: 3px solid yellowgreen">
                            <th>Tanggal</th>
                            <th>Tugas Utama</th>
                            <th>Tugas Tambahan</th>
                            <th>Tugas Tambahan Khusus</th>
                            <th>Penyesuaian Target Baru</th>
                            <th>IKP</th>
                            <th>Durasi Kinerja</th>
                            <th>Persen Kinerja (%)</th>
                            <th>Jam Masuk</th>
                            <th>Jam Pulang</th>
                            <th>Status&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                            <th>Tdk Hadir (%)</th>
                            <th>Terlambat Msk</th>
                            <th>Plg Cepat</th>
                            <th>Trlmbt/Plg Cpt (%)</th>
                            <th>Tdk Apel (%)</th>
                        </tr>
                        <tbody>
                        <?php foreach ($detail_tunjangan as $lsdata2): ?>
                            <tr>
                                <td style="text-align: center"><?php echo $lsdata2->tanggal; ?></td>
                                <td><?php echo $lsdata2->jumlah_waktu_tugas_utama; ?></td>
                                <td><?php echo $lsdata2->jumlah_waktu_tugas_tambahan; ?></td>
                                <td><?php echo $lsdata2->jumlah_waktu_tugas_tambahan_khusus; ?></td>
                                <td><?php echo $lsdata2->jumlah_waktu_penyesuaian_target; ?></td>
                                <td><?php echo $lsdata2->jumlah_waktu_ikp; ?></td>
                                <td><?php echo $lsdata2->jml_waktu_kinerja; ?></td>
                                <td>
                                    <?php echo $lsdata2->persen_kinerja; ?>
                                    <?php
                                        if($lsdata2->persen_kinerja_penyesuaian!='') {
                                            echo ' (' . $lsdata2->persen_kinerja_penyesuaian . ')';
                                        }
                                    ?>
                                </td>
                                <td style="text-align: center;"><?php echo ($lsdata2->jam_masuk==''?'-':$lsdata2->jam_masuk); ?></td>
                                <td style="text-align: center;"><?php echo ($lsdata2->jam_pulang==''?'-':$lsdata2->jam_pulang); ?></td>
                                <td><?php echo $lsdata2->status_hari; ?></td>
                                <td><?php echo $lsdata2->persen_minus_tidak_hadir; ?></td>
                                <td><?php echo $lsdata2->menit_terlambat_masuk; ?></td>
                                <td><?php echo $lsdata2->menit_pulang_lebih_cepat; ?></td>
                                <td><?php echo $lsdata2->persen_minus_terlambat_plg_cpt; ?></td>
                                <td><?php echo $lsdata2->persen_minus_tidak_apel; ?></td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>
    <?php else: ?>
        <ul class="tabs-expand-md" data-role="tabs" style="font-size: small;font-weight: bold;">
            <?php
                $a = 1;
                foreach ($nilai_hist_alih_tugas as $lsdata){?>
                    <li id="tdHistAlihTugas_<?php echo $a; ?>" style="color: darkblue;" class="active"><a href="#_tbTarget_<?php echo $a; ?>">Alih Tugas #<?php echo $a; ?></a></li>
            <?php
                    $a++;
                }?>
        </ul>
        <div class="border bd-default no-border-top p-2">
            <?php
            $a = 1;
            foreach ($nilai_hist_alih_tugas as $lsdata){?>
                <div id="_tbTarget_<?php echo $a; ?>">
                    <span style="color: saddlebrown; font-weight: bold;">Atasan Langsung : <?php echo $lsdata->atsl_nama; ?></span><br>
                    <span style="color: blue">Periode : <?php echo $this->umum->monthName($lsdata->periode_bln).' '.$lsdata->periode_thn; ?></span><br>
                    Tgl.Pembuatan : <?php echo $lsdata->tmt; ?><br>
                    Jabatan : <?php echo $lsdata->jabatan.' ('.$lsdata->kode_jabatan.')'; ?><br>
                    Kelas Jabatan : <?php echo $lsdata->kelas_jabatan.' ('.$lsdata->nilai_jabatan.')'; ?><br>
                    Nilai Tunjangan : Rp. <?php echo number_format($lsdata->rupiah_awal_tkd,0,",",".").
                        '<br>Komposisi : Kinerja (60%): Rp. '.number_format($lsdata->rupiah_awal_kinerja,0,",",".").
                        ' Kedisiplinan (40%): Rp. '.number_format($lsdata->rupiah_awal_disiplin,0,",","."); ?> <br>
                    <strong>Pencapaian:</strong><br>
                    Kinerja : <?php echo $lsdata->persen_kinerja_final.'% (Rp. '.number_format($lsdata->rupiah_kinerja,0,",",".").')'; ?><br>
                    Kedisiplinan : <?php echo $lsdata->persen_disiplin_final.'% (Rp. '.number_format($lsdata->rupiah_disiplin,0,",",".").')'; ?><br>
                    Jumlah Akhir : Rp. <?php echo number_format($lsdata->rupiah_kinerja_final,0,",","."); ?>
                    <?php $detail_tunjangan = $this->ekinerja->data_ref_detail_nilai_tunjangan_by_hist_alih_tugas($lsdata->idknj_hist_alih_tugas_enc); ?>
                    <?php if (isset($detail_tunjangan) and sizeof($detail_tunjangan) > 0 and $detail_tunjangan != ''):?>
                        <br><strong>Uraian:</strong><br>
                        <div style="overflow-x: auto; border: 1px solid rgba(71,71,72,0.35);">
                            <table class="table row-hover row-border compact" style="margin-bottom: 0px;">
                                <tr style="border-bottom: 3px solid yellowgreen">
                                    <th>Tanggal</th>
                                    <th>Tugas Utama</th>
                                    <th>Tugas Tambahan</th>
                                    <th>Tugas Tambahan Khusus</th>
                                    <th>Penyesuaian Target Baru</th>
                                    <th>IKP</th>
                                    <th>Durasi Kinerja</th>
                                    <th>Persen Kinerja (%)</th>
                                    <th>Jam Masuk</th>
                                    <th>Jam Pulang</th>
                                    <th>Status&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                                    <th>Tdk Hadir (%)</th>
                                    <th>Terlambat Msk</th>
                                    <th>Plg Cepat</th>
                                    <th>Trlmbt/Plg Cpt (%)</th>
                                    <th>Tdk Apel (%)</th>
                                </tr>
                                <tbody>
                                <?php foreach ($detail_tunjangan as $lsdata2): ?>
                                    <tr>
                                        <td style="text-align: center"><?php echo $lsdata2->tanggal; ?></td>
                                        <td><?php echo $lsdata2->jumlah_waktu_tugas_utama; ?></td>
                                        <td><?php echo $lsdata2->jumlah_waktu_tugas_tambahan; ?></td>
                                        <td><?php echo $lsdata2->jumlah_waktu_tugas_tambahan_khusus; ?></td>
                                        <td><?php echo $lsdata2->jumlah_waktu_penyesuaian_target; ?></td>
                                        <td><?php echo $lsdata2->jumlah_waktu_ikp; ?></td>
                                        <td><?php echo $lsdata2->jml_waktu_kinerja; ?></td>
                                        <td>
                                            <?php echo $lsdata2->persen_kinerja; ?>
                                            <?php
                                                if($lsdata2->persen_kinerja_penyesuaian!='') {
                                                    echo ' (' . $lsdata2->persen_kinerja_penyesuaian . ')';
                                                }
                                            ?>
                                        </td>
                                        <td style="text-align: center;"><?php echo ($lsdata2->jam_masuk==''?'-':$lsdata2->jam_masuk); ?></td>
                                        <td style="text-align: center;"><?php echo ($lsdata2->jam_pulang==''?'-':$lsdata2->jam_pulang); ?></td>
                                        <td><?php echo $lsdata2->status_hari; ?></td>
                                        <td><?php echo $lsdata2->persen_minus_tidak_hadir; ?></td>
                                        <td><?php echo $lsdata2->menit_terlambat_masuk; ?></td>
                                        <td><?php echo $lsdata2->menit_pulang_lebih_cepat; ?></td>
                                        <td><?php echo $lsdata2->persen_minus_terlambat_plg_cpt; ?></td>
                                        <td><?php echo $lsdata2->persen_minus_tidak_apel; ?></td>
                                    </tr>
                                <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
                <?php
                $a++;
            }?>
        </div>
    <?php endif; ?>
Keterangan: <br>
1) Tugas Utama (100%),<br>
2) Tugas Tambahan (Maksimal 20% dari Standar),<br>
3) Instruksi Khusus Pimpinan (Maksimal 10% dari Standar),<br>
4) Tugas Tambahan Khusus (100%), <br>
5) Penyesuaian Target Baru (100%)
<?php else: ?>
    Data tidak dapat ditemukan
<?php endif; ?>
</div>
<button id="btnKembali" onclick="" type="button" class="button primary bg-darkSteel drop-shadow" style="margin-bottom: 5px; margin-top: 5px;">
    <span class="mif-arrow-left icon"></span> Kembali</button>

<script>
    $("#btnKembali").click(function(){
        location.href = '<?php echo base_url($usr);?>/detail_laporan_kinerja?idknjm=<?php echo $idknjm; ?>&click=true&tab=tbRekap';
    });
</script>