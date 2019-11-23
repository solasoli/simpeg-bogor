<?php if (isset($knjmaster) and sizeof($knjmaster) > 0 and $knjmaster != ''){?>
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
                $curThnPeriode = (Int)date("Y");
                $curBlnPeriode = (Int)date("m");
                $curTglPeriode = (Int)date("d");
                if($curThnPeriode.'-'.$curBlnPeriode==$lsdata->periode_thn.'-'.$lsdata->periode_bln){
                    $disableCalc = false;
                }else{
                    if($curBlnPeriode==1){
                        if($lsdata->periode_bln==12 and $lsdata->periode_thn==($curThnPeriode-1)){
                            if($curTglPeriode<=10){
                                $disableCalc = false;
                            }else{
                                $disableCalc = true;
                            }
                        }else{
                            $disableCalc = true;
                        }
                    }else{
                        if($lsdata->periode_bln==($curBlnPeriode-1)){
                            if($curTglPeriode<=10){
                                $disableCalc = false;
                            }else{
                                $disableCalc = true;
                            }
                        }else{
                            $disableCalc = true;
                        }
                    }
                }
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
                            echo '<br>Atasan: '.$lsdata2->atsl_nama.' ('.$lsdata2->atsl_jabatan.')';
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
                <td>Tunjangan Kedisiplinan</td>
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
                    <?php if(strpos($lsdata->last_unit_kerja, 'Satuan Polisi Pamong')!==false): ?>
                        <button id="btnKalkulasi" type="button" class="button primary bg-green drop-shadow" style="margin-bottom: 5px;"
                            <?php echo($disableCalc==true?' disabled':''); ?>>
                            <span class="mif-calculator2 icon"></span> Kalkulasi Nilai </button>
                    <?php else: ?>
                        <?php if((time() >= strtotime('16:00:00',time()) and time() <= strtotime('23:59:59',time())) or
                            (time() >= strtotime('00:00:01',time()) and time() <= strtotime('07:00:00',time()))): ?>
                        <!--<button id="btnKalkulasi" type="button" class="button primary bg-green drop-shadow" style="margin-bottom: 5px;"
                            <?php //echo($disableCalc==true?' disabled':''); ?>>
                            <span class="mif-calculator2 icon"></span> Kalkulasi Nilai </button>-->
                        <?php else: ?>
                        <!--<button id="btnKalkulasi" type="button" class="button primary bg-green drop-shadow" style="margin-bottom: 5px;" disabled>
                                <span class="mif-calculator2 icon"></span> Kalkulasi Nilai </button>-->
                        <?php endif; ?>
                        <button id="btnKalkulasi" type="button" class="button primary bg-green drop-shadow" style="margin-bottom: 5px;">
                            <span class="mif-calculator2 icon"></span> Kalkulasi Nilai </button>
                    <?php endif; ?>
                    <?php if($id_status_knj==3): ?>
                        <button id="btnCancelLaporan" type="button" class="button yellow drop-shadow" style="margin-bottom: 5px;">
                            <span class="mif-cancel icon"></span> Batalkan Laporan</button>
                    <?php else: ?>
                        <button id="btnLaporanSelesai" type="button" class="button primary bg-orange drop-shadow" style="margin-bottom: 5px;">
                            <span class="mif-paper-plane icon"></span> Laporan Selesai </button>
                    <?php endif; ?>
                    <button id="btnDetailNilai" onclick="" type="button" class="button primary bg-darkBlue drop-shadow" style="margin-bottom: 5px;">
                        <span class="mif-file-text icon"></span> Detail Nilai</button>
                    <button id="btnCetakLaporan" type="button" class="button info drop-shadow" style="margin-bottom: 5px;">
                        <span class="mif-printer icon"></span> Cetak Laporan</button>
                    <button id="btnCetakAktifitas" type="button" class="button fg-white bg-taupe drop-shadow" style="margin-bottom: 5px;">
                        <span class="mif-printer icon"></span> Cetak Aktifitas</button>
                    <button id="btnKembali" onclick="" type="button" class="button primary bg-darkSteel drop-shadow" style="margin-bottom: 5px;">
                        <span class="mif-arrow-left icon"></span> Kembali</button>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php }else{
    //echo 'Data tidak ditemukan';
} ?>

<script>
    $("#btnKalkulasi").click(function(){
        <?php if($id_status_knj==3): ?>
        $.alert({
            title: 'Informasi',
            type: 'green',
            closeIconClass: 'fa fa-close',
            closeIcon: null,
            closeIconClass: false,
            useBootstrap: false,
            content: 'Kalkulasi tidak dapat dilakukan karena laporan sudah selesai'
        });
        <?php else: ?>
            running_kalkulasi_nilai_tunjangan_kinerja();
        <?php endif;?>
    });

    function running_kalkulasi_nilai_tunjangan_kinerja(){
        var jc = $.confirm({
            title: '',
            closeIconClass: 'fa fa-close',
            closeIcon: null,
            closeIconClass: false,
            boxWidth: '200px',
            useBootstrap: false,
            content: function () {
                var data = new FormData();
                data.append('id_pegawai', '<?php echo $this->session->userdata('id_pegawai_enc');?>');
                data.append('id_knj_master', '<?php echo $id_knj_master_enc; ?>');
                data.append('bln', <?php echo $bln;?>);
                data.append('thn', <?php echo $thn;?>);
                data.append('usr', '<?php echo $usr;?>');
                data.append('link_cur', '<?php echo $cur_link_addr;?>');
                return $.ajax({
                    url: "<?php echo base_url($usr)."/exec_kalkulasi_nilai_kinerja/";?>",
                    data: data,
                    cache: false,
                    contentType: false,
                    processData: false,
                    method: 'POST',
                }).done(function (data) {
                    if(data==0){
                        $.confirm({
                            title: 'Informasi',
                            type: 'red',
                            closeIconClass: 'fa fa-close',
                            closeIcon: null,
                            closeIconClass: false,
                            useBootstrap: false,
                            content: 'Maaf kalkulasi nilai tunjangan kinerja gagal',
                            buttons: {
                                tryAgain: {
                                    text: 'Coba Lagi',
                                    btnClass: 'btn-blue',
                                    action: function(){
                                        running_kalkulasi_nilai_tunjangan_kinerja();
                                    }
                                },
                                tutup: function () {
                                }
                            }
                        });
                    }else{
                        $("#_target_1").html(data);
                        $("#btnKalkulasi").css("pointer-events", "auto");
                        $("#btnKalkulasi").css("opacity", "1");
                        $("#_target_1").css("pointer-events", "auto");
                        $("#_target_1").css("opacity", "1");

                        $.alert({
                            title: 'Informasi',
                            type: 'green',
                            closeIconClass: 'fa fa-close',
                            closeIcon: null,
                            closeIconClass: false,
                            useBootstrap: false,
                            content: 'Kalkulasi nilai tunjangan kinerja sukses'
                        });
                    }
                }).fail(function(){
                    $("#_target_1").html('Error...telah terjadi kesalahan');
                });
            },
            onContentReady: function () {
                jc.close();
            },
            buttons: {
                refreshList: {
                    text: '.',
                    action: function () {}
                }
            }
        });
    }

    $("#btnLaporanSelesai").click(function(){
        running_update_laporan_kinerja('ajukan');
    });

    function running_update_laporan_kinerja(status_laporan){
        var jc = $.confirm({
            title: '',
            closeIconClass: 'fa fa-close',
            closeIcon: null,
            closeIconClass: false,
            boxWidth: '200px',
            useBootstrap: false,
            content: function () {
                var data = new FormData();
                data.append('id_knj_master', '<?php echo $id_knj_master_enc; ?>');
                data.append('status_laporan', status_laporan);
                data.append('usr', '<?php echo $usr;?>');
                data.append('link_cur', '<?php echo $cur_link_addr;?>');
                return $.ajax({
                    url: "<?php echo base_url($usr)."/exec_laporan_kinerja_selesai/";?>",
                    data: data,
                    cache: false,
                    contentType: false,
                    processData: false,
                    method: 'POST',
                }).done(function (data) {
                    if(data==0){
                        $.confirm({
                            title: 'Informasi',
                            type: 'red',
                            closeIconClass: 'fa fa-close',
                            closeIcon: null,
                            closeIconClass: false,
                            useBootstrap: false,
                            content: 'Maaf update laporan kinerja gagal',
                            buttons: {
                                tryAgain: {
                                    text: 'Coba Lagi',
                                    btnClass: 'btn-blue',
                                    action: function(){
                                        running_update_laporan_kinerja(status_laporan);
                                    }
                                },
                                tutup: function () {
                                }
                            }
                        });
                    }else{
                        $("#_target_1").html(data);
                        $("#btnLaporanSelesai").css("pointer-events", "auto");
                        $("#btnLaporanSelesai").css("opacity", "1");
                        $("#_target_1").css("pointer-events", "auto");
                        $("#_target_1").css("opacity", "1");

                        $.alert({
                            title: 'Informasi',
                            type: 'green',
                            closeIconClass: 'fa fa-close',
                            closeIcon: null,
                            closeIconClass: false,
                            useBootstrap: false,
                            content: 'Update laporan kinerja sukses'
                        });
                    }
                }).fail(function(){
                    $("#_target_1").html('Error...telah terjadi kesalahan');
                });
            },
            onContentReady: function () {
                jc.close();
            },
            buttons: {
                refreshList: {
                    text: '.',
                    action: function () {}
                }
            }
        });
    }

    $("#btnCancelLaporan").click(function(){
        running_update_laporan_kinerja('batalkan');
    });

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

    $("#btnKembali").click(function(){
        location.href = '<?php echo base_url($usr);?>/input_laporan_kinerja?click=true&tab=tbDaftarLaporan';
    });

    $("#btnDetailNilai").click(function(){
        location.href = '<?php echo $this->ekinerja->const_http; ?>://<?php echo $cur_link_addr;?>&click=true&tab=tbRekap&detail=true';
    });
</script>


