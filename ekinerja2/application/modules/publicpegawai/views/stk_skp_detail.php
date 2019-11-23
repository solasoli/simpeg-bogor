<div class="panel-content" data-role="panel"
     data-title-caption=""
     data-title-icon=""
     data-cls-title="bg-steel fg-white">
<?php if (isset($headerSKP) and sizeof($headerSKP) > 0 and $headerSKP != ''){?>
    <table class="table row-hover row-border compact" style="margin-bottom: 10px;">
        <thead>
        <tr>
            <th style="width: 25%">Uraian</th>
            <th></th>
            <th style="width: 75%">Deskripsi</th>
        </tr>
        </thead>
        <tbody>
            <?php foreach ($headerSKP as $lsdata): ?>
                <tr>
                    <td>Periode SKP</td>
                    <td>:</td>
                    <td>
                        <?php
                            $periode_awal = explode('-',$lsdata->periode_awal);
                            $periode_awal = $periode_awal[2].' '.$this->umum->monthName($periode_awal[1]).' '.$periode_awal[0];
                            $periode_akhir = explode('-',$lsdata->periode_akhir);
                            $periode_akhir = $periode_akhir[2].' '.$this->umum->monthName($periode_akhir[1]).' '.$periode_akhir[0];
                            echo $periode_awal.' s.d '.$periode_akhir;
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>Status</td>
                    <td>:</td>
                    <td><?php echo $lsdata->status; ?></td>
                </tr>
                <tr>
                    <td>Jabatan</td>
                    <td>:</td>
                    <td><?php echo $lsdata->jabatan_pegawai; ?></td>
                </tr>
                <tr>
                    <td>Unit Kerja</td>
                    <td>:</td>
                    <td><?php echo $lsdata->unit_kerja; ?></td>
                </tr>
                <tr>
                    <td>Penilai</td>
                    <td>:</td>
                    <td><strong><?php echo $lsdata->nama_penilai; ?></strong> <?php echo $lsdata->nip_penilai; ?><br>
                        <?php echo $lsdata->jabatan_penilai; ?> (<?php echo $lsdata->gol_penilai; ?>)
                    </td>
                </tr>
                <tr>
                    <td>Atasan Penilai</td>
                    <td>:</td>
                    <td><strong><?php echo $lsdata->nama_atasan_penilai; ?></strong> <?php echo $lsdata->nip_atasan_penilai; ?><br>
                        <?php echo $lsdata->jabatan_atasan_penilai; ?> (<?php echo $lsdata->gol_atasan_penilai; ?>)
                    </td>
                </tr>
                <tr>
                    <td colspan="3"><span style="text-decoration: underline; color: blue;">Penilaian Perilaku</span></td>
                </tr>
                <tr>
                    <td>1) Orientasi Pelayanan</td>
                    <td>:</td>
                    <td><?php echo ($lsdata->orientasi_pelayanan==''?0:$lsdata->orientasi_pelayanan).
                            ' ('.$this->public->sebutan_capaian(($lsdata->orientasi_pelayanan==''?0:$lsdata->orientasi_pelayanan)).')'; ?>
                    </td>
                </tr>
                <tr>
                    <td>2) Integritas</td>
                    <td>:</td>
                    <td><?php echo ($lsdata->integritas==''?0:$lsdata->integritas).
                            ' ('.$this->public->sebutan_capaian(($lsdata->integritas==''?0:$lsdata->integritas)).')'; ?>

                    </td>
                </tr>
                <tr>
                    <td>3) Komitmen</td>
                    <td>:</td>
                    <td><?php echo ($lsdata->komitmen==''?0:$lsdata->komitmen).
                            ' ('.$this->public->sebutan_capaian(($lsdata->komitmen==''?0:$lsdata->komitmen)).')'; ?>
                    </td>
                </tr>
                <tr>
                    <td>4) Disiplin</td>
                    <td>:</td>
                    <td><?php echo ($lsdata->disiplin==''?0:$lsdata->disiplin).
                            ' ('.$this->public->sebutan_capaian(($lsdata->disiplin==''?0:$lsdata->disiplin)).')'; ?>
                    </td>
                </tr>
                <tr>
                    <td>5) Kerjasama</td>
                    <td>:</td>
                    <td><?php echo ($lsdata->kerjasama==''?0:$lsdata->kerjasama).
                            ' ('.$this->public->sebutan_capaian(($lsdata->kerjasama==''?0:$lsdata->kerjasama)).')'; ?>
                    </td>
                </tr>
                <?php if(isset($lsdata->kepemimpinan) and $lsdata->kepemimpinan != ''){?>
                    <tr>
                        <td>6) Kepemimpinan</td>
                        <td>:</td>
                        <td><?php echo ($lsdata->kepemimpinan==''?0:$lsdata->kepemimpinan);?></td>
                    </tr>
                <?php } ?>
            <?php endforeach; ?>
            <?php
                $arrPerilaku = array(
                    ($lsdata->orientasi_pelayanan==''?0:$lsdata->orientasi_pelayanan),
                    ($lsdata->integritas==''?0:$lsdata->integritas),
                    ($lsdata->komitmen==''?0:$lsdata->komitmen),
                    ($lsdata->disiplin==''?0:$lsdata->disiplin),
                    ($lsdata->kerjasama==''?0:$lsdata->kerjasama),
                    ((isset($lsdata->kepemimpinan) and $lsdata->kepemimpinan != '')?($lsdata->kepemimpinan==''?0:$lsdata->kepemimpinan):0)
                );
            ?>
            <tr>
                <td>&nbsp; &nbsp; &nbsp;Jumlah</td>
                <td>:</td>
                <td>
                    <?php echo array_sum($arrPerilaku); ?>
                </td>
            </tr>
            <tr>
                <td>&nbsp; &nbsp; &nbsp;Rata-rata</td>
                <td>:</td>
                <td>
                    <?php
                        echo(round(array_sum($arrPerilaku) / ((isset($lsdata->kepemimpinan) and $lsdata->kepemimpinan != '')?6:5),2).
                            ' ('.$this->public->sebutan_capaian(round(array_sum($arrPerilaku) / ((isset($lsdata->kepemimpinan)  and $lsdata->kepemimpinan != '')?6:5),2)).')'
                        );
                    ?>
                </td>
            </tr>
            <tr>
                <td>&nbsp; &nbsp; &nbsp;<strong>Nilai Perilaku Kerja</strong></td>
                <td>:</td>
                <td><strong>
                    40% x <?php
                        $nilaiPerilaku = (round(array_sum($arrPerilaku) / ((isset($lsdata->kepemimpinan)  and $lsdata->kepemimpinan != '')?6:5),2));
                        echo $nilaiPerilaku;?>
                    = <?php echo(0.4*$nilaiPerilaku);?>
                    </strong>
                </td>
            </tr>
        </tbody>
    </table>
<?php } ?>
        <?php if (isset($targetSKP) and sizeof($targetSKP) > 0 and $targetSKP != ''){?>
            <?php
                $i = 1;
                $arrNilaiCapaian = array();
            ?>
            <span style="font-size:11pt;text-decoration: underline; color: blue;">Penilaian Sasaran Kerja Pegawai</span>
            <div style="overflow-x: auto; margin-top: 10px;">
                <table class="table row-hover row-border compact" style="margin-bottom: 20px; width: 150%;">
                    <thead>
                    <tr style="border-top: 1px solid rgba(71,71,72,0.35);">
                        <th rowspan="2">No</th>
                        <th rowspan="2" style="text-align: center; vertical-align: center;">Uraian Tugas</th>
                        <th rowspan="2">AK</th>
                        <th colspan="4" style="text-align: center;">Target</th>
                        <th rowspan="2">AK</th>
                        <th colspan="4" style="text-align: center;">Realisasi</th>
                        <th rowspan="2">Penghitungan</th>
                        <th rowspan="2">Nilai Capaian</th>
                    </tr>
                    <tr>
                        <th>Kuantitas</th>
                        <th>Kualitas</th>
                        <th>Waktu</th>
                        <th>Biaya</th>
                        <th>Kuantitas</th>
                        <th>Kualitas</th>
                        <th>Waktu</th>
                        <th>Biaya</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($targetSKP as $lsdata): ?>
                        <tr>
                            <td><?php echo $i; ?>.</td>
                            <td><?php echo $lsdata->uraian_tugas;?></td>
                            <td><?php echo $lsdata->angka_kredit;?></td>

                            <td style="text-align: center"><?php echo $lsdata->kuantitas.' '.$lsdata->kuantitas_satuan;?></td>
                            <td style="text-align: center"><?php echo $lsdata->kualitas;?></td>
                            <td style="text-align: center"><?php echo $lsdata->waktu.' '.$lsdata->waktu_satuan;?></td>
                            <td style="text-align: center"><?php echo ($lsdata->biaya==''?0:$lsdata->biaya);?></td>

                            <td><?php echo $lsdata->real_angka_kredit;?></td>

                            <td style="text-align: center"><?php echo ($lsdata->real_kuantitas==''?0:$lsdata->real_kuantitas.' '.$lsdata->kuantitas_satuan);?></td>
                            <td style="text-align: center"><?php echo ($lsdata->real_kualitas==''?0:$lsdata->real_kualitas);?></td>
                            <td style="text-align: center"><?php echo ($lsdata->real_waktu==''?0:$lsdata->real_waktu.' '.$lsdata->waktu_satuan);?></td>
                            <td style="text-align: center"><?php echo ($lsdata->real_biaya==''?0:$lsdata->real_biaya);?></td>
                            <td style="text-align: center"><?php echo ($lsdata->hitung_nilai==''?0:$lsdata->hitung_nilai);?></td>
                            <td style="text-align: center"><?php echo ($lsdata->nilai_capaian==''?0:$lsdata->nilai_capaian);?></td>
                        </tr>
                        <?php
                            $i++;
                            if($lsdata->nilai_capaian!=''){
                                $arrNilaiCapaian[] = $lsdata->nilai_capaian;
                            }
                            /*if(($lsdata->nilai_capaian==''?0:$lsdata->nilai_capaian)>=0) {
                                $arrNilaiCapaian[] = ($lsdata->nilai_capaian == '' ? 0 : $lsdata->nilai_capaian);
                            }*/
                        ?>
                    <?php endforeach; ?>
                    <tr>
                        <td></td>
                        <td colspan="13">
                            <?php
                                if(array_sum($arrNilaiCapaian)==0){
                                    $nilaiSkp = 0;
                                }else{
                                    $nilaiSkp = round(array_sum($arrNilaiCapaian)/count($arrNilaiCapaian),2);
                                }
                                echo 'Nilai Capaian SKP : '.$nilaiSkp;
                                //echo '<br>'.array_sum($arrNilaiCapaian).'<br>'.count($arrNilaiCapaian);
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td colspan="13">
                            <strong>Sasaran Kerja Pegawai : 60% x
                                <?php
                                    echo $nilaiSkp; ?> =
                                <?php echo round(0.6*$nilaiSkp,2); ?>
                            </strong>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td colspan="13">
                            <strong>Nilai Prestasi Kerja :
                                <?php echo ((0.4*$nilaiPerilaku)+round(0.6*$nilaiSkp,2))?>
                                (<?php echo $this->public->sebutan_capaian(((0.4*$nilaiPerilaku)+round(0.6*$nilaiSkp,2)));?>)
                            </strong>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        <?php
        }else{
            echo 'Belum ada data';
        } ?>
</div>

<?php
//echo '<pre>';
//print_r($headerSKP);
//echo '<br><br>';
//print_r($targetSKP);
//echo '</pre>';
?>
