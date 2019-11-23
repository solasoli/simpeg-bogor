<?php if (isset($knjmaster) and sizeof($knjmaster) > 0 and $knjmaster != ''){?>
<div class="panel-content" data-role="panel"
     data-title-caption=""
     data-title-icon=""
     data-cls-title="bg-steel fg-white">

    <table class="table row-hover row-border compact" style="margin-bottom: 0px;">
        <thead>
        <tr>
            <th style="width: 25%">Uraian</th>
            <th></th>
            <th style="width: 75%">Deskripsi</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($knjmaster as $lsdata): ?>
            <?php
            $id_knj_master_enc = $lsdata->id_knj_master_enc;
            $bln = $lsdata->periode_bln;
            $thn = $lsdata->periode_thn;
            $id_status_knj = $lsdata->id_status_knj;
            $status_pegawai = $lsdata->status_pegawai;
            ?>
            <tr>
                <td>Periode</td>
                <td>:</td>
                <td><?php echo $this->umum->monthName($lsdata->periode_bln).' ',$lsdata->periode_thn; ?></td>
            </tr>
            <tr>
                <td>Waktu Pembuatan</td>
                <td>:</td>
                <td><?php echo $lsdata->tgl_input_kinerja; ?></td>
            </tr>
            <tr>
                <td>Status Laporan</td>
                <td>:</td>
                <td><?php echo $lsdata->status_knj; ?></td>
            </tr>
            <tr>
                <td style="vertical-align: top">Pemrosesan Laporan</td>
                <td>:</td>
                <td><?php echo ($lsdata->tgl_approved==''?'Belum pernah diproses':'Terakhir diproses pada '.$lsdata->tgl_approved.' oleh '.$lsdata->nama_approver.' ('.$lsdata->nip_approver.')'); ?></td>
            </tr>
            <tr>
                <td>Status Kalkulasi Nilai</td>
                <td>:</td>
                <td><?php echo ($lsdata->flag_kalkulasi==0?'Belum pernah dikalkulasi':'Terakhir dikalkulasi pada '.$lsdata->tgl_update_kalkulasi); ?></td>
            </tr>
            <tr>
                <td colspan="3"><span style="text-decoration: underline; color: blue;">Biodata Pegawai</span></td>
            </tr>
            <tr>
                <td>Nama</td>
                <td>:</td>
                <td><span style="font-weight: bold; color: saddlebrown;"><?php echo $lsdata->nama; ?></span></td>
            </tr>
            <tr>
                <td>NIP</td>
                <td>:</td>
                <td><?php echo $lsdata->nip_baru; ?></td>
            </tr>
            <tr>
                <td>Jenjang Jabatan</td>
                <td>:</td>
                <td><?php echo $lsdata->last_jenjab; ?></td>
            </tr>
            <tr>
                <td>Status Pegawai</td>
                <td>:</td>
                <td><?php echo $lsdata->status_pegawai; ?></td>
            </tr>
            <tr>
                <td style="vertical-align: top">Jabatan</td>
                <td style="vertical-align: top">:</td>
                <td><?php echo '('.$lsdata->last_kode_jabatan.') '.$lsdata->last_jabatan.($lsdata->last_eselon==''?'':'. <br>Eselon : '.$lsdata->last_eselon); ?></td>
            </tr>
            <tr>
                <td>Golongan</td>
                <td>:</td>
                <td><?php echo $lsdata->last_gol; ?></td>
            </tr>
            <tr>
                <td>Unit Kerja</td>
                <td>:</td>
                <td><?php echo $lsdata->last_unit_kerja; ?></td>
            </tr>
            <tr>
                <td style="vertical-align: top">Atasan Langsung</td>
                <td style="vertical-align: top">:</td>
                <td>
                    <?php echo '<strong>'.$lsdata->last_atsl_nama.'</strong> '.(is_numeric($lsdata->last_atsl_nip)?$lsdata->last_atsl_nip:''); ?>
                    <?php echo '<br><span style="font-size: small;">'.$lsdata->last_atsl_jabatan.(is_numeric($lsdata->last_atsl_nip)?' ('.$lsdata->last_atsl_gol:'').')</span>';?>
                </td>
            </tr>
            <tr>
                <td style="vertical-align: top">Pejabat Berwenang</td>
                <td style="vertical-align: top">:</td>
                <td style="vertical-align: top">
                    <?php if(is_numeric($lsdata->last_atsl_nip)): ?>
                        <?php echo '<strong>'.$lsdata->last_pjbt_nama.'</strong> '.$lsdata->last_pjbt_nip; ?>
                        <?php echo '<br><span style="font-size: small;">'.$lsdata->last_pjbt_jabatan.' ('.$lsdata->last_pjbt_gol.')</span>';?>
                    <?php else: ?>
                        -
                    <?php endif; ?>
                </td>
            </tr>
            <tr>
                <td colspan="3"><span style="text-decoration: underline; color: blue;">Riwayat Atasan Langsung</span></td>
            </tr>
            <tr>
                <td colspan="3">
                    <?php
                    $data_at = $this->ekinerja->data_ref_list_hist_alih_tugas_by_idknj($lsdata->id_knj_master_enc);
                    if (isset($data_at) and sizeof($data_at) > 0 and $data_at != '') {
                        $jmlAtasan = 0;
                        $chkTtd = '<form action="" method="" id="frmTtd" novalidate="novalidate">';
                        foreach ($data_at as $lsdata2){
                            echo '<ul>';
                            echo '<li>';
                            echo '<strong>Jabatan: ('.$lsdata2->kode_jabatan.') '.$lsdata2->jabatan.($lsdata2->eselon==''?'':'. Eselon : '.$lsdata2->eselon).'</strong>';
                            echo '<br>Kelas: '.$lsdata2->kelas_jabatan.' ('.$lsdata2->nilai_jabatan.'). Tunjangan '.($status_pegawai=='CPNS'?'80%':'').' : Rp. '. number_format($lsdata2->rupiah_awal_tkd,0,",",".").',-';
                            echo '<br>Atasan: '.$lsdata2->atsl_nama.' '.$lsdata2->atsl_jabatan;
                            if($lsdata2->atsl_nama_plh <> ''){
                                echo '<br>Plh. Atasan Langsung : '.$lsdata2->atsl_nama_plh.' ('.$lsdata2->atsl_jabatan_plh.')';
                            }
                            echo '<br>Unit Kerja: '.$lsdata2->unit_kerja.'<br>TMT. Kinerja: '.$lsdata2->tmt;
                            echo '</li>';
                            echo '</ul>';
                            $jmlAtasan++;
                            $chkTtd .= "<label><input ".($jmlAtasan==1?'checked':'')." type=\"radio\" data-role=\"radio\" name=\"rdbTtd\" id=\"rdbTtd\" value=\"$lsdata2->idknj_hist_alih_tugas\">".
                                ($lsdata2->atsl_nama_plh==''?$lsdata2->atsl_nama.' ('.$lsdata2->atsl_nip.')<br>'.$lsdata2->atsl_jabatan:$lsdata2->atsl_nama_plh.' ('.$lsdata2->atsl_nip_plh.')<br>'.$lsdata2->atsl_jabatan_plh.'<br>sebagai PLH Atasan Langsung').'<br>';
                        }
                        $chkTtd .= '</form>';
                    }else{
                        echo "Belum ada data";
                    }
                    ?>
                </td>
            </tr>
            <!--<tr>
                                <td colspan="3"><strong>Tunjangan Tambahan Penghasilan (TTP)</strong></td>
                            </tr>
                            <tr>
                                <td>Persentase Awal</td>
                                <td>:</td>
                                <td><?php //echo $lsdata->persen_total_tpp; ?>%</td>
                            </tr>
                            <tr>
                                <td>Persentase Akhir</td>
                                <td>:</td>
                                <td><?php //echo $lsdata->persen_tpp_akhir; ?>%</td>
                            </tr>-->
            <tr>
                <td colspan="3"><strong>Tunjangan Kinerja Daerah (TKD)</strong></td>
            </tr>
            <!--<tr>
                <td>Kelas Jabatan</td>
                <td>:</td>
                <td><?php //echo $lsdata->kelas_jabatan; ?></td>
            </tr>
            <tr>
                <td>Nilai Jabatan</td>
                <td>:</td>
                <td><?php //echo $lsdata->nilai_jabatan; ?></td>
            </tr>
            <tr>
                <td>Nilai Rupiah TKD</td>
                <td>:</td>
                <td>Rp. <?php //echo $lsdata->nilai_rupiah_tkd; ?></td>
            </tr>
            <tr>
                <td>Tunjangan Awal TKD</td>
                <td>:</td>
                <td>Rp. <?php //echo $lsdata->rupiah_awal_tkd; ?></td>
            </tr>-->
            <!--<tr>
                <td colspan="3"><span style="text-decoration: underline; color: blue;">Pengurangan Awal</span></td>
            </tr>
            <tr>
                <td>Hukuman Disiplin</td>
                <td>:</td>
                <td><?php //echo $lsdata->persen_minus_tpp_hukdis; ?> %</td>
            </tr>
            <tr>
                <td>Tugas Belajar</td>
                <td>:</td>
                <td><?php //echo $lsdata->persen_minus_tpp_tubel; ?> %</td>
            </tr>-->
            <tr>
                <td colspan="3"><span style="text-decoration: underline; color: blue;">Target Awal Tunjangan</span></td>
            </tr>
            <tr>
                <td>Kinerja (60%)</td>
                <td>:</td>
                <td>Rp. <?php echo number_format($lsdata->rupiah_awal_kinerja,0,",","."); ?>,-</td>
            </tr>
            <tr>
                <td>Kedisiplinan (40%)</td>
                <td>:</td>
                <td>Rp. <?php echo number_format($lsdata->rupiah_awal_disiplin,0,",","."); ?>,-</td>
            </tr>
            <tr>
                <td colspan="3"><span style="text-decoration: underline; color: blue;">Aktivitas Kegiatan</span></td>
            </tr>
            <tr>
                <td>Jumlah Menit Efektif Kerja</td>
                <td>:</td>
                <td><?php echo $lsdata->jml_menit_efektif_kerja; ?> menit</td>
            </tr>
            <tr>
                <td>Jumlah Waktu Kinerja</td>
                <td>:</td>
                <td><?php echo $lsdata->jml_waktu_kinerja_accu; ?> menit</td>
            </tr>
            <tr>
                <td>Persentase Kinerja</td>
                <td>:</td>
                <td><?php echo $lsdata->persen_kinerja_accu; ?> %</td>
            </tr>
            <tr style="background-color:  rgba(205,205,208,0.35)">
                <td>Tunjangan Hasil Kinerja (A)</td>
                <td>:</td>
                <td>Rp. <?php echo number_format($lsdata->rupiah_kinerja,0,",","."); ?>,-</td>
            </tr>
            <?php if($lsdata->last_eselon!='' or strpos($lsdata->last_jabatan, 'Plt')!==false or $lsdata->jml_bawahan_aktual>0): ?>
                <tr>
                    <td colspan="3" style="border-top: 2px solid rgba(71,71,72,0.35)"><span style="text-decoration: underline; color: blue;">Kinerja Staf</span></td>
                </tr>
                <tr>
                    <td>Jumlah Staf Aktual</td>
                    <td>:</td>
                    <td><?php echo $lsdata->jml_bawahan_aktual; ?> orang</td>
                </tr>
                <tr>
                    <td>Jumlah Staf eKinerja</td>
                    <td>:</td>
                    <td><?php echo $lsdata->jml_bawahan_kinerja; ?> orang</td>
                </tr>
                <tr>
                    <td>Jumlah Waktu Kinerja Staf</td>
                    <td>:</td>
                    <td><?php echo $lsdata->jml_waktu_kinerja_accu_bawahan; ?> menit</td>
                </tr>
                <tr>
                    <td>Persentase Kinerja Staf</td>
                    <td>:</td>
                    <td><?php echo $lsdata->persen_kinerja_accu_bawahan; ?> %</td>
                </tr>
                <tr>
                    <td>Persentase Kinerja Staf Aktual</td>
                    <td>:</td>
                    <td><?php echo $lsdata->persen_kinerja_bawahan_aktual; ?> %</td>
                </tr>
                <tr>
                    <td style="border-top: 2px solid rgba(71,71,72,0.35)">Persentase Kinerja Aktual</td>
                    <td style="border-top: 2px solid rgba(71,71,72,0.35)">:</td>
                    <td style="border-top: 2px solid rgba(71,71,72,0.35)"><?php echo $lsdata->persen_kinerja_aktual; ?> %</td>
                </tr>
                <tr style="background-color:  rgba(205,205,208,0.35)">
                    <td>Tunjangan Hasil Kinerja</td>
                    <td>:</td>
                    <td>Rp. <?php echo number_format($lsdata->rupiah_kinerja_aktual,0,",","."); ?>,-</td>
                </tr>
            <?php endif; ?>
            <tr>
                <td colspan="3"><span style="text-decoration: underline; color: blue;">Absensi Kehadiran</span></td>
            </tr>
            <tr>
                <td>Jumlah Hari Efektif Kerja</td>
                <td>:</td>
                <td><?php echo $lsdata->jml_hari_efektif_kerja; ?></td>
            </tr>
            <tr>
                <td>Jumlah Kehadiran</td>
                <td>:</td>
                <td><?php echo $lsdata->jml_kehadiran_accu; ?></td>
            </tr>
            <tr>
                <td>Persentase Kehadiran</td>
                <td>:</td>
                <td><?php echo $lsdata->persen_kehadiran_accu; ?> %</td>
            </tr>
            <tr>
                <td>Jumlah Ketidakhadiran</td>
                <td>:</td>
                <td><?php echo $lsdata->jml_tidak_hadir_accu; ?></td>
            </tr>
            <tr>
                <td>Persentase Ketidakhadiran</td>
                <td>:</td>
                <td><?php echo $lsdata->persen_minus_tidak_hadir_accu; ?> %</td>
            </tr>
            <tr>
                <td>Persentase Terlambat / Pulang lebih cepat</td>
                <td style="vertical-align: top">:</td>
                <td style="vertical-align: top"><?php echo $lsdata->persen_minus_terlambat_plg_cpt_accu; ?> %</td>
            </tr>
            <tr>
                <td>Persentase Kedisiplinan</td>
                <td style="vertical-align: top">:</td>
                <td style="vertical-align: top"><?php echo $lsdata->persen_disiplin_final; ?> %</td>
            </tr>
            <tr style="background-color:  rgba(205,205,208,0.35)">
                <td>Tunjangan Kedisiplinan (B)</td>
                <td>:</td>
                <td>Rp. <?php echo number_format($lsdata->rupiah_disiplin,0,",","."); ?>,-</td>
            </tr>
            <tr>
                <td colspan="3"><span style="text-decoration: underline; color: blue;">Absensi Apel</span></td>
            </tr>
            <tr>
                <td>Jumlah Hari Efektif Apel</td>
                <td>:</td>
                <td><?php echo $lsdata->jml_hari_efektif_apel; ?></td>
            </tr>
            <tr>
                <td>Jumlah Hari Tidak Apel</td>
                <td>:</td>
                <td><?php echo $lsdata->jml_tidak_apel_accu; ?></td>
            </tr>
            <tr>
                <td>Persentase Tidak Apel</td>
                <td>:</td>
                <td><?php echo $lsdata->persen_minus_tidak_apel_accu; ?> %</td>
            </tr>
            <tr>
                <td colspan="3"><span style="text-decoration: underline; color: blue;">Item Kinerja Unsur Lainnya</span></td>
            </tr>
            <tr>
                <td colspan="3"><span style="font-style: italic;">Penambahan Prestasi</span></td>
            </tr>
            <tr>
                <td>Jumlah</td>
                <td>:</td>
                <td><?php echo $lsdata->jumlah_penambahan_item_lain; ?></td>
            </tr>
            <tr>
                <td>Persentase</td>
                <td>:</td>
                <td><?php echo $lsdata->persen_penambahan_item_lain; ?> %</td>
            </tr>
            <tr>
                <td colspan="3"><span style="font-style: italic;">Pengurangan Unsur Disiplin</span></td>
            </tr>
            <tr>
                <td>Jumlah</td>
                <td>:</td>
                <td><?php echo $lsdata->jumlah_pengurangan_item_lain; ?></td>
            </tr>
            <tr>
                <td>Persentase</td>
                <td>:</td>
                <td><?php echo $lsdata->persen_pengurangan_item_lain; ?> %</td>
            </tr>
            <tr>
                <td>Rupiah</td>
                <td>:</td>
                <td>Rp. <?php echo number_format((($lsdata->persen_pengurangan_item_lain/100)*$lsdata->last_rupiah_disiplin),0,",","."); ?>,-</td>
            </tr>
            <tr>
                <td colspan="3"><span style="font-style: italic;">Pengurangan Hasil Akhir</span></td>
            </tr>
            <tr>
                <td>Jumlah</td>
                <td>:</td>
                <td><?php echo $lsdata->jumlah_pengurangan_item_lain_maks; ?></td>
            </tr>
            <tr>
                <td>Persentase</td>
                <td>:</td>
                <td><?php echo $lsdata->persen_pengurangan_item_lain_maks; ?> %</td>
            </tr>
            <tr>
                <td colspan="3"><span style="text-decoration: underline; color: blue;">Hasil Akhir Kinerja</span></td>
            </tr>
            <tr style="background-color:  rgba(205,205,208,0.35)">
                <td>Total Tunjangan (A+B)</td>
                <td>:</td>
                <td>Rp. <?php echo number_format(($lsdata->rupiah_kinerja_aktual+$lsdata->rupiah_disiplin),0,",","."); ?>,-</td>
            </tr>
            <tr>
                <td colspan="3"><span style="font-style: italic;">Penyesuaian Unsur Lainnya</span></td>
            </tr>
            <tr>
                <td>Persentase Kedisiplinan</td>
                <td style="vertical-align: top">:</td>
                <td style="vertical-align: top"><?php echo $lsdata->last_persen_disiplin; ?> %</td>
            </tr>
            <tr>
                <td>Tunjangan Kedisiplinan (B)</td>
                <td>:</td>
                <td>Rp. <?php echo number_format($lsdata->last_rupiah_disiplin,0,",","."); ?>,-</td>
            </tr>
            <tr>
                <td>Tunjangan Perolehan</td>
                <td>:</td>
                <td>Rp. <?php echo number_format($lsdata->rupiah_kinerja_final,0,",","."); ?>,-</td>
            </tr>
            <tr>
                <td>Pengurangan Akhir <?php echo number_format($lsdata->persen_pengurangan_item_lain_maks,0); ?>%</td>
                <td>:</td>
                <td>Rp. <?php echo number_format((($lsdata->persen_pengurangan_item_lain_maks/100)*$lsdata->rupiah_kinerja_final),0,",","."); ?>,-</td>
            </tr>
            <tr style="background-color:  rgba(205,205,208,0.35)">
                <td><strong>Tunjangan Akhir</strong></td>
                <td>:</td>
                <td>
                    <strong>Rp. <?php echo number_format($lsdata->last_rupiah_kinerja_final,0,",","."); ?>,-</strong>
                </td>
            </tr>
            <tr>
                <td>Status Kalkulasi Nilai</td>
                <td>:</td>
                <td><?php echo ($lsdata->flag_kalkulasi==0?'Belum pernah dikalkulasi':'Terakhir dikalkulasi pada '.$lsdata->tgl_update_kalkulasi); ?></td>
            </tr>
            <tr>
                <td style="vertical-align: top">Pemrosesan Laporan</td>
                <td style="vertical-align: top">:</td>
                <td><?php echo ($lsdata->tgl_approved==''?'Belum pernah diproses':'Terakhir diproses pada '.$lsdata->tgl_approved.'<br>oleh '.$lsdata->nama_approver/*.'<br>'.$lsdata->nip_approver*/); ?></td>
            </tr>
            <?php if($jmlAtasan>1): ?>
                <tr>
                    <td style="vertical-align: top">Pilih Penandatangan</td>
                    <td style="vertical-align: top">:</td>
                    <td><?php echo $chkTtd; ?></td>
                </tr>
            <?php endif; ?>
            <tr>
                <td colspan="3" style="padding-top: 10px;">
                    <button id="btnDetailNilai" onclick="uraian_rekap_kinerja_staf('<?php echo $idknjm;?>')" type="button" class="button primary bg-darkBlue drop-shadow" style="margin-bottom: 5px;">
                        <span class="mif-file-text icon"></span> Detail Nilai</button>
                    <button id="btnCetakLaporan" type="button" class="button info drop-shadow" style="margin-bottom: 5px;">
                        <span class="mif-printer icon"></span> Cetak Laporan</button>
                    <button id="btnCetakAktifitas" type="button" class="button fg-white bg-taupe drop-shadow" style="margin-bottom: 5px;">
                        <span class="mif-printer icon"></span> Cetak Aktifitas</button>
                    <button id="btnKembali" type="button" class="button primary bg-darkSteel drop-shadow" style="margin-bottom: 5px;">
                        <span class="mif-arrow-left icon"></span> Kembali</button>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php }else{
    //echo 'Data tidak ditemukan';
} ?>

<script>
    $("#btnKembali").click(function(){
        window.history.back();
    });

    function uraian_rekap_kinerja_staf(id_knj_master){
        location.href = "<?php echo base_url().$usr."/uraian_rekap_kinerja_staf?idknjm=" ?>" + id_knj_master;
    };

    $("#btnCetakLaporan").click(function(){
        var jmlAtasan = <?php echo $jmlAtasan; ?>;
        if(jmlAtasan>1){
            var myVarTtd = $('input[name=rdbTtd]:checked', '#frmTtd').val();
            window.open('/ekinerja2/<?php echo $usr;?>/cetak_laporan_kinerja_pegawai/<?php echo $id_knj_master_enc; ?>/' + myVarTtd, '_blank');
        }else{
            window.open('/ekinerja2/<?php echo $usr;?>/cetak_laporan_kinerja_pegawai/<?php echo $id_knj_master_enc; ?>', '_blank');
        }
    });

    $("#btnCetakAktifitas").click(function(){
        var jmlAtasan = <?php echo $jmlAtasan; ?>;
        if(jmlAtasan>1){
            var myVarTtd = $('input[name=rdbTtd]:checked', '#frmTtd').val();
            window.open('/ekinerja2/<?php echo $usr;?>/cetak_laporan_kinerja_pegawai_aktifitas/<?php echo $id_knj_master_enc; ?>/' + myVarTtd, '_blank');
        }else{
            window.open('/ekinerja2/<?php echo $usr;?>/cetak_laporan_kinerja_pegawai_aktifitas/<?php echo $id_knj_master_enc; ?>', '_blank');
        }
    });

</script>


