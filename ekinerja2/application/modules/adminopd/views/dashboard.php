

<div data-role="carousel"
     data-cls-bullet="bullet-big"
     data-auto-start="true"
     data-cls-controls="fg-white"
     data-bullets-position="center"
     data-control-next="<span class='mif-chevron-right fg-cyan'></span>"
     data-control-prev="<span class='mif-chevron-left fg-cyan'></span>"
     data-height = "@(max-width: 992px),400" style="height: 200px;">
    <div class="slide p-2 pl-10 pr-10" data-cover="<?php echo base_url('assets/images/hijau.jpg'); ?>">
        <div class="row flex-align-center h-100">
            <div class="cell-md-4 text-center">
                <div class="img-container rounded drop-shadow">
                    <img src="<?php echo base_url('assets/images/report.jpg'); ?>"
                         style="width: auto;height: auto;display: block">
                </div>
            </div>
            <div class="cell-md-8">
                <h2 class="text-light">Input E-Kinerja</h2>
                <p class="mt-4 mb-4">E-Kinerja mulai periode Juli 2019 batas akhir pengisian aktifitas kegiatan 7
                    hari ke belakang dari hari berjalan, batas akhir kalkulasi tanggal 10 pada bulan berikutnya & tidak dapat menginput
                    utk periode sebelumnya</p>
            </div>
        </div>
    </div>

    <div class="slide p-2 pl-10 pr-10" data-cover="<?php echo base_url('assets/images/silver2.jpg'); ?>">
        <div class="row flex-align-center h-100">
            <div class="cell-md-8">
                <p class="indent-letter">SIMPEG Mobile Kota Bogor. Aplikasi berbasis android yang digunakan untuk mencatat waktu kehadiran (absensi),
                    berdasarkan lokasi unit kerja. Download aplikasinya melalui Google PlayStore</p>
            </div>
            <div class="cell-md-4 text-center">
                <div class="img-container rounded drop-shadow">
                    <img src="<?php echo base_url('assets/images/apps-mobile.jpg'); ?>">
                </div>
            </div>
        </div>
    </div>

    <div class="slide p-2 pl-10 pr-10" data-cover="<?php echo base_url('assets/images/grey1.jpg'); ?>">
        <div class="row flex-align-center h-100">
            <div class="cell-md-4 text-center">
                <div class="img-container rounded drop-shadow">
                    <img src="<?php echo base_url('assets/images/statistics2.jpg'); ?>"
                         style="width: auto;height: auto;display: block">
                </div>
            </div>
            <div class="cell-md-8">
                <h2 class="text-light">Statistik Data </h2>
                <p class="mt-4 mb-4">Akses menu statistik untuk meninjau informasi kinerja dan kedisiplinan (kehadiran) pada periode tertentu</p>
            </div>
        </div>
    </div>

    <div class="slide p-2 pl-10 pr-10" data-cover="<?php echo base_url('assets/images/back1.jpg'); ?>">
        <div class="row flex-align-center h-100">
            <div class="cell-md-4 text-center">
                <div class="img-container rounded drop-shadow">
                    <img src="<?php echo base_url('assets/images/employee3.jpg'); ?>"
                         style="width: auto;height: auto;display: block">
                </div>
            </div>
            <div class="cell-md-8">
                <h2 class="text-light">DRH</h2>
                <p class="mt-4 mb-4">Riwayat Hidup sebagai informasi kelengkapan data di database.
                    BKPSDA akan mengetahui potensi seseorang dan mengkaji apakah orang tersebut sesuai kriteria pegawai yang dibutuhkan.</p>
            </div>
        </div>
    </div>
    <!--<div class="slide" data-cover="<?php //echo base_url('assets/images/abstract2.jpg'); ?>"></div>-->
</div>

<div class="panel-content" data-role="panel"
     data-title-caption=""
     data-title-icon=""
     data-cls-title="bg-steel fg-white">

    <div class="row mt-2">
        <div class="cell-md-6">

            <div class="card">
                <div class="card-header"
                     style="background-image: url(<?php echo base_url('assets/images/grey1.jpg'); ?>)">Pengumuman
                </div>
                <div class="card-content p-2">
                    <p>
                        Input ekinerja periode Juli 2019 terakhir s.d hari Jumat, 2 Agustus 2019, dengan mengakses menu: <br>
                        Input Laporan Kinerja | <a href="javascript:void(0)" onclick="daftar_list_laporan();">Daftar Laporan Per Periode</a><br>
                        Klik Tombol <strong>Input Aktifitas</strong> dari Daftar Laporan Kinerja berds. Periode

                    </p>
                    <script>
                        function daftar_list_laporan(){
                            location.href = "<?php echo base_url().$usr."/input_laporan_kinerja?click=true&tab=tbDaftarLaporan" ?>";
                        }
                    </script>
                </div>
            </div>

            <div class="card">
                <div class="card-header"
                     style="background-image: url(<?php echo base_url('assets/images/grey1.jpg'); ?>)">Kinerja Hari ini
                </div>
                <div class="card-content p-2">
                    <?php if (isset($today) and sizeof($today) > 0 and $today != ''): ?>
                        <?php foreach ($today as $lsdata): ?>
                            <strong><?php echo $lsdata->status_hari; ?></strong><br>

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
                                    echo 'Standard: '.$lsdata->std_jam_msk.' s.d '.$lsdata->std_jam_plg.'<br>';
                                }
                            }else{
                                echo 'Standard: '.$lsdata->std_jam_msk.' s.d '.$lsdata->std_jam_plg.'<br>';
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
                                        echo 'Absen: awal '.($lsdata->jam_absen_awal==''?'-':$lsdata->jam_absen_awal).', akhir '.($lsdata->jam_absen_akhir==''?'-':$lsdata->jam_absen_akhir);
                                        echo($lsdata->tgl_apel==''?'':' | '.$lsdata->status_apel);
                                    }
                                }
                            }
                            ?><br>
                            <?php if($lsdata->status_hari!='Libur' and $lsdata->status_hari!='Libur Nasional' and $lsdata->status_hari!='Cuti Bersama'): ?>
                                Total Durasi: <?php echo ($lsdata->jumlah_durasi==''?0:$lsdata->jumlah_durasi); ?> menit
                                (Utama: <?php echo ($lsdata->tugas_utama==''?0:$lsdata->tugas_utama); ?>,
                                Khusus: <?php echo ($lsdata->tugas_tambahan_khusus==''?0:$lsdata->tugas_tambahan_khusus); ?>,
                                Penyesuaian Target: <?php echo ($lsdata->penyesuaian_target==''?0:$lsdata->penyesuaian_target); ?>,
                                IKP: <?php echo ($lsdata->ikp==''?0:$lsdata->ikp); ?>,
                                Tambahan: <?php echo ($lsdata->tugas_tambahan==''?0:$lsdata->tugas_tambahan); ?>)
                            <?php endif;?>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>


            <div class="card">
                <div class="card-header" style="background-image: url(<?php echo base_url('assets/images/grey1.jpg'); ?>)">Kinerja Bulan Ini</div>
                <div class="card-content p-2">
                    <?php if (isset($kinerja_curr) and sizeof($kinerja_curr) > 0 and $kinerja_curr != ''){?>
                        <?php foreach ($kinerja_curr as $lsdata): ?>
                            Kalkulasi terakhir : <?php echo $lsdata->tgl_update_kalkulasi; ?><br>
                            Index harga : Rp. <?php echo number_format($lsdata->nilai_rupiah_tkd,0,",","."); ?>,-<br>
                            Nilai Jabatan : <?php echo $lsdata->nilai_jabatan; ?><br>
                            Nilai Tunjangan : Rp. <?php echo number_format($lsdata->nilai,0,",","."); ?>,-<br>
                            Komp. Kinerja (60%) : Rp. <?php echo number_format($lsdata->rupiah_awal_kinerja,0,",","."); ?>,-<br>
                            Komp. Disiplin (40%) : Rp. <?php echo number_format($lsdata->rupiah_awal_disiplin,0,",","."); ?>,-<br>
                            Jml bawahan aktual : <?php echo $lsdata->jml_bawahan_aktual; ?> orang<br>
                            Jml bawahan kinerja : <?php echo $lsdata->jml_bawahan_kinerja; ?> orang<br>
                            % Kinerja bawahan : <?php echo $lsdata->persen_kinerja_accu_bawahan; ?>%<br>
                            % Kinerja bawahan aktual : <?php echo $lsdata->persen_kinerja_bawahan_aktual; ?>%<br>
                            % Kinerja aktual : <?php echo $lsdata->persen_kinerja_aktual; ?>%<br>
                            Tunjangan Kinerja : Rp. <?php echo number_format($lsdata->rupiah_kinerja_aktual,0,",","."); ?>,-<br>
                            % Kedisiplinan : <?php echo $lsdata->last_persen_disiplin; ?>%<br>
                            Tunjangan Kedisiplinan : Rp. <?php echo number_format($lsdata->last_rupiah_disiplin,0,",","."); ?>,-<br>
                            Tunjangan Akhir : Rp. <?php echo number_format($lsdata->last_rupiah_kinerja_final,0,",","."); ?>,-
                        <?php endforeach; ?>
                    <?php }else{
                        echo 'Laporan bulan '.$this->umum->monthName(date('m')).' '.date('Y').' tidak ditemukan';
                    } ?>
                </div>
                <?php if(isset($lsdata->id_knj_master) and $lsdata->id_knj_master!=''): ?>
                <div class="card-footer"><button onclick="detail_laporan_kinerja('<?php echo $lsdata->id_knj_master; ?>')" class="button primary bg-darkSteel small rounded">
                        <span class="mif-note icon"></span> Detail</button></div>
                <?php endif;?>
            </div>
        </div>
        <div class="cell-md-6">
            <div class="card">
                <div class="card-header" style="background-image: url(<?php echo base_url('assets/images/grey1.jpg'); ?>)">Status Aktifitas</div>
                <div class="card-content p-2">
                    <?php if (isset($aktifitas_curr) and sizeof($aktifitas_curr) > 0 and $aktifitas_curr != ''){?>
                        <table class="table compact" style="border-bottom: 1px solid rgba(71,71,72,0.35);">
                            <thead>
                            <tr>
                                <td>Kategori</td>
                                <td>A</td>
                                <td>B</td>
                                <td>C</td>
                                <td>D</td>
                                <td>Jml</td>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($aktifitas_curr as $lsdata2): ?>
                                <tr style="text-align: center;">
                                    <td style="text-align: left"><?php echo $lsdata2->nama_tugas; ?></td>
                                    <td><?php echo $lsdata2->blm_diproses; ?></td>
                                    <td><?php echo $lsdata2->disetujui; ?></td>
                                    <td><?php echo $lsdata2->revisi; ?></td>
                                    <td><?php echo $lsdata2->ditolak; ?></td>
                                    <td><?php echo $lsdata2->total; ?></td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                        <strong>Keterangan:</strong><br>
                        A) Belum diproses<br>
                        B) Disetujui<br>
                        C) Revisi<br>
                        D) Ditolak
                    <?php }else{
                        echo 'Laporan bulan '.$this->umum->monthName(date('m')).' '.date('Y').' tidak ditemukan';
                    } ?>
                </div>
                <!--<div class="card-footer"></div>-->
            </div>
        </div>
    </div>
</div>

<script>
    function detail_laporan_kinerja(id){
        location.href = "<?php echo base_url().$usr."/detail_laporan_kinerja?idknjm=" ?>" + id;
    }
</script>