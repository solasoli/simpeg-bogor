
<?php
if (isset($data_stat_4) and sizeof($data_stat_4) > 0 and $data_stat_4 != ''){
    $val1 = 0;
    $val2 = 0;
    $val3 = 0;
    $val4 = 0;
    $val5 = 0;
    $arrSt = array();
    $x = 0;
    $a = 0;
    $b = 0;
    $c = 0;
    $d = 0;
    $e = 0;
    $f = 0;
    $g = 0;
    $h = 0;
    $i = 0;
    $j = 0;
    $k = 0;
    $l = 0;
    $m = 0;
    $n = 0;
    ?>

    <div class="row mt-2">
        <div class="cell-md-12"><div id="container1" style="margin: 0 auto; height: 400px;"></div></div>
    </div>
    <div class="row mt-2">
        <div class="cell-md-12">
            <?php foreach ($data_stat_4 as $lsdata): ?>
                <?php
                $val1 .= $lsdata->utama.",";
                $val2 .= $lsdata->khusus.",";
                $val3 .= $lsdata->tambahan.",";
                $val4 .= $lsdata->penyesuaian.",";
                $val5 .= $lsdata->ikp.",";
                $arrSt[$x] = $lsdata->status_hari;
                $x++;
                if($lsdata->status_hari=='Jadwal Normal'){
                    $a++;
                }elseif($lsdata->status_hari=='Cuti' or $lsdata->status_hari=='SK Cuti Sudah Terbit' or $lsdata->status_hari=='Cuti Disetujui BKPSDA'){
                    $b++;
                }elseif($lsdata->status_hari=='Jadwal Khusus DL'){
                    $c++;
                }elseif($lsdata->status_hari=='Jadwal Khusus Shift'){
                    $d++;
                }elseif($lsdata->status_hari=='Jadwal Khusus Piket'){
                    $e++;
                }elseif($lsdata->status_hari=='Jadwal Khusus Jam Kerja Beda'){
                    $f++;
                }elseif($lsdata->status_hari=='Jadwal Khusus Praktek Medis'){
                    $g++;
                }elseif($lsdata->status_hari=='Jadwal Khusus Libur'){
                    $h++;
                }elseif($lsdata->status_hari=='Libur'){
                    $i++;
                }elseif($lsdata->status_hari=='Libur Nasional'){
                    $j++;
                }elseif($lsdata->status_hari=='Cuti Bersama'){
                    $k++;
                }elseif($lsdata->status_hari=='Sakit'){
                    $l++;
                }elseif($lsdata->status_hari=='Lepas Piket'){
                    $m++;
                }elseif($lsdata->status_hari=='Tanpa Keterangan'){
                    $n++;
                }
                ?>
            <?php endforeach; ?>
        </div>
    </div>
    <script type="text/javascript">
        var jArraySt = <?php echo json_encode($arrSt ); ?>;
    </script>

    <script>

        Highcharts.chart('container1', {
            title: {
                text: 'Profil Harian Kinerja Bulan <?php echo $bln.' '.$thn; ?>'
            },
            subtitle: {
                text: 'Durasi berds. Kategori Kegiatan'
            },
            yAxis: {
                title: {
                    text: 'Durasi (menit)'
                }
            },
            tooltip: {
                formatter: function () {
                    // The first returned item is the header, subsequent items are the
                    // points
                    return ['<b>' + this.x + ' (' + jArraySt[this.x-1] + ')' + '</b>'].concat(
                        this.points.map(function (point) {
                            return point.series.name + ': ' + point.y + 'm';
                        })
                    );
                },
                split: true
            },
            legend: {
                layout: 'horizontal',
                align: 'center',
                verticalAlign: 'bottom',
                x: 0,
                y: 0

            },
            plotOptions: {
                series: {
                    label: {
                        connectorAllowed: false
                    },
                    pointStart: 1,
                    dataLabels: {
                        enabled: true
                    }
                }
            },
            series: [{
                name: 'Tugas Utama',
                data: [<?php echo $val1; ?>]
            }, {
                name: 'Tugas Khusus',
                data: [<?php echo $val2; ?>]
            }, {
                name: 'Tugas Tambahan',
                data: [<?php echo $val3; ?>]
            }, {
                name: 'Penyesuaian SKP',
                data: [<?php echo $val4; ?>]
            }, {
                name: 'IKP',
                data: [<?php echo $val5; ?>]
            }],
            responsive: {
                rules: [{
                    condition: {
                        maxWidth: 500
                    },
                    chartOptions: {
                        legend: {
                            layout: 'horizontal',
                            align: 'center',
                            verticalAlign: 'bottom'
                        }
                    }
                }]
            }

        });
    </script>
    <?php
}else{
    echo 'Data tidak ditemukan mungkin belum mengkalkulasi nilai atau belum ada laporan ekinerja';
}
?>


<?php
if (isset($data_stat_5) and sizeof($data_stat_5) > 0 and $data_stat_5 != ''){
    $val1 = 0;
    $val2 = 0;
    $arrSt = array();
    $y = 0;
    ?>
    <div class="row mt-2">
        <div class="cell-md-12"><div id="container2" style="margin: 0 auto; height: 400px;"></div></div>
    </div>
    <div class="row mt-2">
        <div class="cell-md-12">
            <?php foreach ($data_stat_5 as $lsdata): ?>
                <?php
                $val1 .= $lsdata->terlambat.",";
                $val2 .= $lsdata->pulang_cepat.",";
                $arrSt[$y] = $lsdata->status_hari;
                $y++;
                ?>
            <?php endforeach; ?>
        </div>
    </div>
    <script type="text/javascript">
        var jArraySt = <?php echo json_encode($arrSt ); ?>;
    </script>

    <script>

        Highcharts.chart('container2', {
            title: {
                text: 'Profil Harian Kehadiran Bulan <?php echo $bln.' '.$thn; ?>'
            },
            subtitle: {
                text: 'Absensi Mobile'
            },
            yAxis: {
                title: {
                    text: 'Durasi (menit)'
                }
            },
            tooltip: {
                formatter: function () {
                    // The first returned item is the header, subsequent items are the
                    // points
                    return ['<b>' + this.x + ' (' + jArraySt[this.x-1] + ')' + '</b>'].concat(
                        this.points.map(function (point) {
                            return point.series.name + ': ' + point.y + 'm';
                        })
                    );
                },
                split: true
            },
            legend: {
                layout: 'horizontal',
                align: 'center',
                verticalAlign: 'bottom',
                x: 0,
                y: 0

            },
            plotOptions: {
                series: {
                    label: {
                        connectorAllowed: false
                    },
                    pointStart: 1,
                    dataLabels: {
                        enabled: true
                    }
                }
            },
            series: [{
                name: 'Keterlambatan',
                data: [<?php echo $val1; ?>]
            }, {
                name: 'Plg. Cepat',
                data: [<?php echo $val2; ?>]
            }],
            responsive: {
                rules: [{
                    condition: {
                        maxWidth: 500
                    },
                    chartOptions: {
                        legend: {
                            layout: 'horizontal',
                            align: 'center',
                            verticalAlign: 'bottom'
                        }
                    }
                }]
            }

        });
    </script>

    <strong>Rekapitulasi Kehadiran <?php echo $bln.' '.$thn; ?></strong>
    <table class="table compact row-border" style="border-bottom: 1px solid rgba(71,71,72,0.35);">
        <thead>
        <tr>
            <td style="text-align: center">Uraian</td>
            <td style="text-align: center">Jumlah</td>
        </tr>
        </thead>
        <tbody>
        <tr style="text-align: center;">
            <td style="text-align: left">1) Jadwal Normal</td><td><?php echo $a; ?></td>
        </tr>
        <tr style="text-align: center;">
            <td style="text-align: left">2) Cuti</td><td><?php echo $b; ?></td>
        </tr>
        <tr style="text-align: center;">
            <td style="text-align: left">3) Jadwal Khusus Dinas Luar</td><td><?php echo $c; ?></td>
        </tr>
        <tr style="text-align: center;">
            <td style="text-align: left">4) Jadwal Khusus Shift</td><td><?php echo $d; ?></td>
        </tr>
        <tr style="text-align: center;">
            <td style="text-align: left">5) Jadwal Khusus Piket</td><td><?php echo $e; ?></td>
        </tr>
        <tr style="text-align: center;">
            <td style="text-align: left">6) Jadwal Khusus Jam Kerja Beda</td><td><?php echo $f; ?></td>
        </tr>
        <tr style="text-align: center;">
            <td style="text-align: left">7) Jadwal Khusus Praktek Medis</td><td><?php echo $g; ?></td>
        </tr>
        <tr style="text-align: center;">
            <td style="text-align: left">8) Jadwal Khusus Libur</td><td><?php echo $h; ?></td>
        </tr>
        <tr style="text-align: center;">
            <td style="text-align: left">9) Libur Normal</td><td><?php echo $i; ?></td>
        </tr>
        <tr style="text-align: center;">
            <td style="text-align: left">10) Libur Nasional</td><td><?php echo $j; ?></td><td>
        </tr>
        <tr style="text-align: center;">
            <td style="text-align: left">11) Cuti Bersama</td><td><?php echo $k; ?></td>
        </tr>
        <tr style="text-align: center;">
            <td style="text-align: left">12) Sakit</td><td><?php echo $l; ?></td>
        </tr>
        <tr style="text-align: center;">
            <td style="text-align: left">13) Lepas Piket</td><td><?php echo $m; ?></td>
        </tr>
        <tr style="text-align: center;">
            <td style="text-align: left">14) Tanpa Keterangan</td><td><?php echo $n; ?></td>
        </tr>
        <tr style="text-align: center;">
            <td style="text-align: left"><strong>Total</strong></td><td><strong><?php echo ($a+$b+$c+$d+$e+$f+$g+$h+$i+$j+$k+$l+$m+$n); ?></strong></td>
        </tr>
        </tbody>
    </table>
    <?php
}
?>
