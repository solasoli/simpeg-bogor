<div class="row mb-2">
    <div class="cell-md-8 my-search-wrapper"></div>
    <div class="cell-md-4 my-rows-wrapper"></div>
</div>

<?php if (isset($absensi) and sizeof($absensi) > 0 and $absensi != ''){ ?>
    <table id="tblAbsensi" class="table row-hover row-border compact"
           style="margin-bottom: 0px;border-bottom: 1px solid rgba(71,71,72,0.35);"
           data-role="table"
           data-rows-steps="10, 15, 20, 30"
           data-rows="10"
           data-info-wrapper=".my-info-wrapper2"
           data-pagination-wrapper=".my-pagination-wrapper"
           data-search-wrapper=".my-search-wrapper"
           data-rows-wrapper=".my-rows-wrapper">
        <thead>
        <tr>
            <th>Tanggal</th>
            <th>Uraian Absensi</th>
            <th>Durasi Kinerja</th>
        </tr>
        </thead>
        <tbody>
            <?php foreach ($absensi as $lsdata): ?>
            <tr>
                <td style="vertical-align: top;"><?php echo $lsdata->tgl.') '.$this->umum->dayName($lsdata->nama_hari); ?></td>
                <td style="vertical-align: top">
                    <?php if($lsdata->status_hari=='Libur' or $lsdata->status_hari=='Libur Nasional' or $lsdata->status_hari=='Cuti Bersama'): ?>
                        <span class="text-bold text-small fg-red"><?php echo $lsdata->status_hari;?></span><br>
                    <?php else: ?>
                        <span class="text-bold text-small"><?php echo $lsdata->status_hari;?></span><br>
                    <?php endif; ?>
                    <?php
                        if($lsdata->status_hari=='Libur') {
                            echo 'Hari libur normal';
                        }elseif($lsdata->status_hari=='Libur Nasional'){
                            echo $lsdata->ket_libur_nas;
                        }elseif($lsdata->status_hari=='Cuti Bersama'){
                            echo $lsdata->ket_cuti_bersama;
                        }elseif($lsdata->status_hari=='Cuti' or $lsdata->status_hari=='SK Cuti Sudah Terbit' or $lsdata->status_hari=='Disetujui BKPSDA'){
                        }elseif($lsdata->status_hari=='Jadwal Khusus'){
                            if($lsdata->jenis=='Libur') {
                            }else{
                                echo 'Standard : masuk '.$lsdata->std_jam_msk.' | keluar '.$lsdata->std_jam_plg.'<br>';
                            }
                        }else{
                            echo 'Standard : masuk '.$lsdata->std_jam_msk.' | keluar '.$lsdata->std_jam_plg.'<br>';
                        }
                    ?>
                    <?php echo($lsdata->status_hari=='Jadwal Khusus'?'<span class="fg-green">'.$lsdata->jenis.'</span>':''); ?>
                    <?php
                        if($lsdata->status_hari=='Jadwal Khusus'){
                            switch ($lsdata->jenis) {
                                case 'Piket':
                                    echo '<br>Lokasi: '.$lsdata->unit_kerja.' ('.($lsdata->flag_lokasi_sekunder==1?'sekunder':'primer').')';
                                    break;
                                case 'Praktek Medis':
                                    echo ' (mulai: '.$lsdata->jdwl_jam_mulai.' selesai: '.$lsdata->jdwl_jam_selesai.')';
                                    echo '<br>Lokasi: '.$lsdata->unit_kerja.' ('.($lsdata->flag_lokasi_sekunder==1?'sekunder':'primer').')';
                                    break;
                                case 'Libur':
                                    echo '';
                                    break;
                                default:
                                    echo ' (mulai: '.$lsdata->jdwl_jam_mulai.' selesai: '.$lsdata->jdwl_jam_selesai.')';
                                    echo '<br>Lokasi: '.$lsdata->unit_kerja.' ('.($lsdata->flag_lokasi_sekunder==1?'sekunder':'primer').')';
                                    break;
                            }
                            if($lsdata->jenis=='Piket' or $lsdata->jenis=='Praktek Medis'){
                                echo '<br>Absen: '.($lsdata->jam_absen_awal==''?'-':$lsdata->jam_absen_awal);
                                echo($lsdata->tgl_apel==''?'':' | '.$lsdata->status_apel);
                            }else{
                                if($lsdata->jenis=='Libur'){
                                    echo '';
                                }else{
                                    echo '<br>Absen: awal '.($lsdata->jam_absen_awal==''?'-':$lsdata->jam_absen_awal).' akhir '.($lsdata->jam_absen_akhir==''?'-':$lsdata->jam_absen_akhir);
                                    echo($lsdata->tgl_apel==''?'':' | '.$lsdata->status_apel);
                                }
                            }
                        }else{
                            if($lsdata->status_hari=='SK Cuti Sudah Terbit' or $lsdata->status_hari=='Disetujui BKPSDA') {
                                echo $lsdata->cm_deskripsi . ' (Waktu: ' . $lsdata->cm_tmt_awal . ' s/d ' . $lsdata->cm_tmt_akhir . ')';
                                echo($lsdata->tgl_apel==''?'':' | '.$lsdata->status_apel);
                            }elseif($lsdata->status_hari=='Cuti'){
                                echo '';
                            }else{
                                if($lsdata->status_hari=='Libur' or $lsdata->status_hari == 'Cuti' or $lsdata->status_hari=='Libur Nasional' or $lsdata->status_hari=='Cuti Bersama'){
                                    echo '';
                                }else{
                                    echo 'Absen: awal '.($lsdata->jam_absen_awal==''?'-':$lsdata->jam_absen_awal).' akhir '.($lsdata->jam_absen_akhir==''?'-':$lsdata->jam_absen_akhir);
                                    echo($lsdata->tgl_apel==''?'':' | '.$lsdata->status_apel);
                                }
                            }
                        }
                    ?>
                </td>
                <td>
                    <?php if($lsdata->status_hari!='Libur' and $lsdata->status_hari!='Libur Nasional' and $lsdata->status_hari!='Cuti Bersama'): ?>
                        <?php if($lsdata->jumlah_durasi=='' or $lsdata->jumlah_durasi==0): ?>
                            <span class="text-bold text-small fg-darkGray">Total: <?php echo ($lsdata->jumlah_durasi==''?0:$lsdata->jumlah_durasi); ?> menit</span>
                        <?php else: ?>
                            <span class="text-bold text-small fg-lightBlue">Total: <?php echo ($lsdata->jumlah_durasi==''?0:$lsdata->jumlah_durasi); ?> menit</span><br>
                            <span class="text-small fg-darkOrange">
                                Utama: <?php echo ($lsdata->tugas_utama==''?0:$lsdata->tugas_utama); ?>,
                                Khusus: <?php echo ($lsdata->tugas_tambahan_khusus==''?0:$lsdata->tugas_tambahan_khusus); ?>,
                                Penyesuaian Target: <?php echo ($lsdata->penyesuaian_target==''?0:$lsdata->penyesuaian_target); ?>,<br>
                                IKP: <?php echo ($lsdata->ikp==''?0:$lsdata->ikp); ?>,
                                Tambahan: <?php echo ($lsdata->tugas_tambahan==''?0:$lsdata->tugas_tambahan); ?>
                            </span>
                        <?php endif;?>
                    <?php endif;?>
                </td>
            <?php endforeach; ?>
        </tbody>
    </table>
    <p class="text-center my-info-wrapper" style="font-size: small"></p>
    <div class="d-flex flex-justify-center my-pagination-wrapper pagination size-small"></div>
<?php }else{
    echo 'Data tidak ditemukan';
} ?>
