
<?php
if (isset($data_stat_1) and sizeof($data_stat_1) > 0 and $data_stat_1 != ''){
    $val1 = 0;
    $val2 = 0;
    $val3 = 0;
    $val4 = 0;
    $val5 = 0;
    ?>
    <div class="row mt-2">
        <div class="cell-md-7">
            <div id="container" style="margin: 0 auto; height: 400px;"></div>
        </div>
        <div class="cell-md-5">
            <div style="overflow-x: auto; border: 0px solid rgba(71,71,72,0.35);width: 100%;">
                <table class="table compact row-border" style="border-bottom: 1px solid rgba(71,71,72,0.35);">
                    <thead>
                    <tr>
                        <td>Periode</td>
                        <td style="text-align: center">Utama</td>
                        <td style="text-align: center">Khus</td>
                        <td style="text-align: center">Tamb.</td>
                        <td style="text-align: center">Peny.</td>
                        <td style="text-align: center">IKP</td>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($data_stat_1 as $lsdata): ?>
                        <?php
                        $val1 .= $lsdata->utama.",";
                        $val2 .= $lsdata->khusus.",";
                        $val3 .= $lsdata->tambahan.",";
                        $val4 .= $lsdata->penyesuaian.",";
                        $val5 .= $lsdata->ikp.",";
                        ?>
                        <tr style="text-align: center;">
                            <td style="text-align: left"><?php echo $this->umum->monthName($lsdata->bln); ?></td>
                            <td><?php echo $lsdata->utama; ?></td>
                            <td><?php echo $lsdata->khusus; ?></td>
                            <td><?php echo $lsdata->tambahan; ?></td>
                            <td><?php echo $lsdata->penyesuaian; ?></td>
                            <td><?php echo $lsdata->ikp; ?></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script>
        Highcharts.chart('container', {
            chart: {
                type: 'column'
            },
            title: {
                text: 'Statistik Kinerja Tahun <?php echo $thn; ?>'
            },
            subtitle: {
                text: 'Durasi berds. Kategori Kegiatan'
            },
            xAxis: {
                categories: [
                    'Jan',
                    'Feb',
                    'Mar',
                    'Apr',
                    'Mei',
                    'Jun',
                    'Jul',
                    'Ags',
                    'Sep',
                    'Okt',
                    'Nov',
                    'Des'
                ],
                crosshair: true
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Durasi (menit)'
                }
            },
            tooltip: {
                headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                    '<td style="padding:0"><b>{point.y:.1f} menit</b></td></tr>',
                footerFormat: '</table>',
                shared: true,
                useHTML: true
            },
            plotOptions: {
                column: {
                    pointPadding: 0.2,
                    borderWidth: 0
                }
            },
            series: [{
                name: 'Utama (A)',
                data: [ <?php echo $val1; ?>]
            }, {
                name: 'Khusus (B)',
                data: [<?php echo $val2; ?>]
            }, {
                name: 'Tambahan (C)',
                data: [<?php echo $val3; ?>]
            }, {
                name: 'Penyesuaian (D)',
                data: [<?php echo $val4; ?>]
            }, {
                name: 'IKP (E)',
                data: [<?php echo $val5; ?>]
            }]
        });
    </script>
    <?php
}else{
    echo 'Data tidak ditemukan mungkin belum mengkalkulasi nilai atau belum ada laporan ekinerja';
}
?>

<?php
if (isset($data_stat_2) and sizeof($data_stat_2) > 0 and $data_stat_2 != ''){
    $val1 = 0;
    $val2 = 0;
    $val3 = 0;
    $val4 = 0;
    $val5 = 0;
    ?>
    <div class="row mt-2">
        <div class="cell-md-7">
            <div id="container2" style="margin: 0 auto; height: 400px;"></div>
        </div>
        <div class="cell-md-5">
            <div style="overflow-x: auto; border: 0px solid rgba(71,71,72,0.35);width: 100%;">
                <table class="table compact row-border" style="border-bottom: 1px solid rgba(71,71,72,0.35);">
                    <thead>
                    <tr>
                        <td>Periode</td>
                        <td style="text-align: center">Terlambat</td>
                        <td style="text-align: center">Plg.Cpt</td>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($data_stat_2 as $lsdata): ?>
                        <?php
                        $val1 .= $lsdata->terlambat.",";
                        $val2 .= $lsdata->pulang_cepat.",";
                        ?>
                        <tr style="text-align: center;">
                            <td style="text-align: left"><?php echo $this->umum->monthName($lsdata->bln); ?></td>
                            <td><?php echo $lsdata->terlambat; ?> <?php echo ($lsdata->terlambat==0?'':'('.$lsdata->terlambat_jm.')'); ?></td>
                            <td><?php echo $lsdata->pulang_cepat; ?> <?php echo ($lsdata->pulang_cepat_jm==0?'':'('.$lsdata->pulang_cepat_jm.')'); ?></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script>
        Highcharts.chart('container2', {
            chart: {
                type: 'column'
            },
            title: {
                text: 'Statistik Absensi Tahun <?php echo $thn; ?>'
            },
            subtitle: {
                text: 'Keterlambatan / Plg.Cepat'
            },
            xAxis: {
                categories: [
                    'Jan',
                    'Feb',
                    'Mar',
                    'Apr',
                    'Mei',
                    'Jun',
                    'Jul',
                    'Ags',
                    'Sep',
                    'Okt',
                    'Nov',
                    'Des'
                ],
                crosshair: true
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Durasi (menit)'
                }
            },
            tooltip: {
                headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                    '<td style="padding:0"><b>{point.y:.1f} menit</b></td></tr>',
                footerFormat: '</table>',
                shared: true,
                useHTML: true
            },
            plotOptions: {
                column: {
                    pointPadding: 0.2,
                    borderWidth: 0
                }
            },
            series: [{
                name: 'Keterlambatan',
                data: [ <?php echo $val1; ?>]
            }, {
                name: 'Plg.Cepat',
                data: [<?php echo $val2; ?>]
            }]
        });
    </script>
    <?php
}
?>

<?php

if (isset($data_stat_3) and sizeof($data_stat_3) > 0 and $data_stat_3 != ''){
    $val1 = 0;
    $val2 = 0;
    $val3 = 0;
    $val4 = 0;
    ?>
    <strong>Persentase Kinerja dan Kehadiran</strong>
    <div class="cell-md-12">
        <div style="overflow-x: auto; border: 0px solid rgba(71,71,72,0.35);width: 100%;">
            <table class="table compact row-border" style="border-bottom: 1px solid rgba(71,71,72,0.35);">
                <thead>
                <tr>
                    <td>Periode</td>
                    <td style="text-align: center">Pencapaian Kinerja</td>
                    <td style="text-align: center">Kinerja Hilang</td>
                    <td style="text-align: center">Terlambat/Plg.Cepat</td>
                    <td style="text-align: center">Tidak Hadir</td>
                    <td style="text-align: center">Tidak Apel</td>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($data_stat_3 as $lsdata): ?>
                    <?php
                    $val1 .= $lsdata->persen_kinerja.",";
                    $val2 .= $lsdata->persen_minus_terlambat_plg_cpt.",";
                    $val3 .= $lsdata->persen_minus_tidak_hadir.",";
                    $val4 .= $lsdata->persen_minus_tidak_apel.",";
                    ?>
                    <tr style="text-align: center;">
                        <td style="text-align: left"><?php echo $this->umum->monthName($lsdata->bln); ?></td>
                        <td><?php echo $lsdata->persen_kinerja; ?> <?php echo ($lsdata->persen_kinerja==0?'':'(Rp. '.number_format($lsdata->rupiah_kinerja,0,",",".").')'); ?></td>
                        <td><?php echo $lsdata->persen_kinerja_lost; ?> <?php echo ($lsdata->persen_kinerja==0?'':'(Rp. '.number_format($lsdata->rupiah_kinerja_lost,0,",",".").')'); ?></td>
                        <td><?php echo $lsdata->persen_minus_terlambat_plg_cpt; ?> <?php echo ($lsdata->persen_minus_terlambat_plg_cpt==0?'':'(Rp. '.number_format($lsdata->rupiah_terlambat_plg_cpt,0,",",".").')'); ?></td>
                        <td><?php echo $lsdata->persen_minus_tidak_hadir; ?> <?php echo ($lsdata->persen_minus_tidak_hadir==0?'':'(Rp. '.number_format($lsdata->rupiah_tdk_hadir,0,",",".").')'); ?></td>
                        <td><?php echo $lsdata->persen_minus_tidak_apel; ?> <?php echo ($lsdata->persen_minus_tidak_apel==0?'':'(Rp. '.number_format($lsdata->rupiah_tidak_apel,0,",",".").')'); ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
                </tbody>
            </table>
        </div>
    </div>

    <?php
}
?>
