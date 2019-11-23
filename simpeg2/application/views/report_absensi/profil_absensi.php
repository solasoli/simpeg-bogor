<div class="container">
    <div class="grid">
        <div class="row">
            <div class="span12">
                <div class="span2">
                    <div class="input-control select" style="width: 100%;">
                        <select id="ddBln" style="background-color: #e3c800;">
                            <option value="1" <?php echo $bln==1?'selected':'' ?>>Januari</option>
                            <option value="2" <?php echo $bln==2?'selected':'' ?>>Februari</option>
                            <option value="3" <?php echo $bln==3?'selected':'' ?>>Maret</option>
                            <option value="4" <?php echo $bln==4?'selected':'' ?>>April</option>
                            <option value="5" <?php echo $bln==5?'selected':'' ?>>Mei</option>
                            <option value="6" <?php echo $bln==6?'selected':'' ?>>Juni</option>
                            <option value="7" <?php echo $bln==7?'selected':'' ?>>Juli</option>
                            <option value="8" <?php echo $bln==8?'selected':'' ?>>Agustus</option>
                            <option value="9" <?php echo $bln==9?'selected':'' ?>>September</option>
                            <option value="10" <?php echo $bln==10?'selected':'' ?>>Oktober</option>
                            <option value="11" <?php echo $bln==11?'selected':'' ?>>November</option>
                            <option value="12" <?php echo $bln==12?'selected':'' ?>>Desember</option>
                        </select>
                    </div> 
                </div>
                <div class="span2">
                    <div class="input-control select" style="width: 100%;">
                        <select id="ddThn" style="background-color: #e3c800;">
                            <option value="2016" <?php echo $thn==2016?'selected':'' ?>>2016</option>
                            <option value="2017" <?php echo $thn==2017?'selected':'' ?>>2017</option>
                            <option value="2018" <?php echo $thn==2018?'selected':'' ?>>2018</option>
                            <option value="2019" <?php echo $thn==2019?'selected':'' ?>>2019</option>
                            <option value="2020" <?php echo $thn==2020?'selected':'' ?>>2020</option>
                            <option value="2021" <?php echo $thn==2021?'selected':'' ?>>2021</option>
                        </select>
                    </div>
                </div>
                <span class="span4">
                    <?php if (isset($list_skpd)): ?>
                        <div class="input-control select" style="width: 100%;">
                            <select id="ddFilterOpd" style="background-color: #e3c800;">
                                <?php foreach ($list_skpd as $ls): ?>
                                    <?php if($ls->id_unit_kerja == $idskpd): ?>
                                        <option value="<?php echo $ls->id_unit_kerja; ?>" selected><?php echo $ls->nama_baru; ?></option>
                                    <?php else: ?>
                                        <option value="<?php echo $ls->id_unit_kerja; ?>"><?php echo $ls->nama_baru; ?></option>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    <?php endif; ?>
                </span>
                <span class="span2">
                    <button id="btn_tampilkan" class="button primary" style="height: 35px; width: 130px;">
                        <span class="icon-zoom-in"></span> <strong>Tampilkan</strong></button>
                </span>
                <span class="span1">
                    <button id="btn_download" class="button danger" style="height: 35px; width: 170px; margin-left: -20px;">
                      <span class="icon-file"></span> <strong>Download Report</strong>
                    </button>
                </span>
            </div>
        </div>

        <div class="row">
            <div class="span8">
                <div class="panel">
                    <div class="panel-header">Tingkat Kehadiran</div>
                    <div class="panel-content">
                        <div class="grid">
                            <div class="row">
                                <div class="span4">
                                    Berdasarkan Hari
                                    <div id="container1" style="margin: 0 auto; height: 150px;"></div>
                                </div>
                                <div class="span3">
                                    Berdasarkan Orang
                                    <div id="container2" style="margin: 0 auto; height: 150px;"></div>
                                </div>
                            </div>

                        </div>
                        Detail Per Status
                        <table class="table bordered striped" id="lst_data">
                            <thead style="border-bottom: solid #a4c400 2px;">
                            <tr>
                                <th style="width: 20px;border-top: 1px solid rgba(111, 111, 111, 0.79);border-left: 1px solid rgba(111, 111, 111, 0.79)">No</th>
                                <th style="border-right: 1px solid rgba(111, 111, 111, 0.79);border-top: 1px solid rgba(111, 111, 111, 0.79)">Status</th>
                                <th style="border-top: 1px solid rgba(111, 111, 111, 0.79)">Orang</th>
                                <th style="border-right: 1px solid rgba(111, 111, 111, 0.79);border-top: 1px solid rgba(111, 111, 111, 0.79)">Persentase</th>
                                <th style="border-top: 1px solid rgba(111, 111, 111, 0.79)">Hari</th>
                                <th style="border-top: 1px solid rgba(111, 111, 111, 0.79);border-right: 1px solid rgba(111, 111, 111, 0.79)">Persentase</th>
                            </tr>
                            </thead>
                            <?php if (sizeof($profil1) > 0): ?>
                                <?php $i = 1; ?>
                                <?php if($profil1!=''): ?>
                                    <?php foreach ($profil1 as $lsdata): ?>
                                        <tr>
                                            <td style="border-bottom: solid #666666 1px;text-align: center;"><?php echo $i; ?></td>
                                            <td style="border-right: 1px solid rgba(111, 111, 111, 0.79);border-bottom: solid #666666 1px;text-align: center; text-align: left;"><?php echo $lsdata->status ?></td>
                                            <td style="border-bottom: solid #666666 1px;text-align: center"><?php echo $lsdata->jml_orang ?></td>
                                            <td style="border-right: 1px solid rgba(111, 111, 111, 0.79);border-bottom: solid #666666 1px;text-align: center"><?php echo $lsdata->persen_jml_pegawai ?> %</td>
                                            <td style="border-bottom: solid #666666 1px;text-align: center"><?php echo $lsdata->jml_hari ?></td>
                                                <td style="border-bottom: solid #666666 1px;text-align: center"><?php echo $lsdata->persen_jml_hari_absen ?> %</td>
                                        </tr>
                                        <?php $i++; ?>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr class="error">
                                        <td colspan="9"><i>Tidak ada data</i></td>
                                    </tr>
                                <?php endif; ?>
                            <?php else: ?>
                                <tr class="error">
                                    <td colspan="9"><i>Tidak ada data</i></td>
                                </tr>
                            <?php endif; ?>
                        </table>
                    </div>
                </div>
            </div>
            <div class="span6">
                <div class="panel">
                    <div class="panel-header">Rekapitulasi Absensi</div>
                    <div class="panel-content">
                        Berdasarkan Hari
                        <div id="container3" style="margin: 0 auto; height: 220px;"></div>
                        Berdasarkan Orang
                        <div id="container4" style="margin: 0 auto; height: 220px;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="panel" style="width: 150%">
    <div class="panel-header">Rekap Absensi Semua OPD</div>
    <div class="panel-content">
        <table class="table bordered striped" id="lst_data">
            <thead style="border-bottom: solid #a4c400 2px;">
            <tr>
                <th style="width: 20px;border-top: 1px solid rgba(111, 111, 111, 0.79);border-left: 1px solid rgba(111, 111, 111, 0.79);" td rowspan="2">No</th>
                <th style="border-top: 1px solid rgba(111, 111, 111, 0.79);border-right: 1px solid rgba(111, 111, 111, 0.79);" rowspan="2">OPD</th>
                <th style="border-top: 1px solid rgba(111, 111, 111, 0.79);" rowspan="2">Jumlah <br> Pegawai</th>
                <th style="border-top: 1px solid rgba(111, 111, 111, 0.79);border-right: 1px solid rgba(111, 111, 111, 0.79)" rowspan="2">Jumlah <br> Hari Kerja</th>
                <th style="border-top: 1px solid rgba(111, 111, 111, 0.79);border-right: 1px solid rgba(111, 111, 111, 0.79);border-bottom: 1px solid rgba(111, 111, 111, 0.79)" colspan="4">Kehadiran</th>
                <th style="border-top: 1px solid rgba(111, 111, 111, 0.79);border-right: 1px solid rgba(111, 111, 111, 0.79);border-bottom: 1px solid rgba(111, 111, 111, 0.79)" colspan="4">Ketidakhadiran</th>
                <th style="border-top: 1px solid rgba(111, 111, 111, 0.79);border-right: 1px solid rgba(111, 111, 111, 0.79);border-bottom: 1px solid rgba(111, 111, 111, 0.79)" colspan="2">C</th>
                <th style="border-top: 1px solid rgba(111, 111, 111, 0.79);border-right: 1px solid rgba(111, 111, 111, 0.79);border-bottom: 1px solid rgba(111, 111, 111, 0.79)" colspan="2">DL</th>
                <th style="border-top: 1px solid rgba(111, 111, 111, 0.79);border-right: 1px solid rgba(111, 111, 111, 0.79);border-bottom: 1px solid rgba(111, 111, 111, 0.79)" colspan="2">DI</th>
                <th style="border-top: 1px solid rgba(111, 111, 111, 0.79);border-right: 1px solid rgba(111, 111, 111, 0.79);border-bottom: 1px solid rgba(111, 111, 111, 0.79)" colspan="2">I</th>
                <th style="border-top: 1px solid rgba(111, 111, 111, 0.79);border-right: 1px solid rgba(111, 111, 111, 0.79);border-bottom: 1px solid rgba(111, 111, 111, 0.79)" colspan="2">S</th>
                <th style="border-top: 1px solid rgba(111, 111, 111, 0.79);border-right: 1px solid rgba(111, 111, 111, 0.79);border-bottom: 1px solid rgba(111, 111, 111, 0.79)" colspan="2">TK</th>
                <th style="border-top: 1px solid rgba(111, 111, 111, 0.79);border-right: 1px solid rgba(111, 111, 111, 0.79);border-bottom: 1px solid rgba(111, 111, 111, 0.79)" colspan="2">TA</th>
            </tr>
            <tr>
                <th>Pegawai</th>
                <th style="width: 75px;">%</th>
                <th>Hari</th>
                <th style="border-right: 1px solid rgba(111, 111, 111, 0.79); width: 75px;">%</th>
                <th>Pegawai</th>
                <th style="width: 75px;">%</th>
                <th>Hari</th>
                <th style="border-right: 1px solid rgba(111, 111, 111, 0.79);width: 75px;">%</th>
                <th>Pegawai</th>
                <th style="border-right: 1px solid rgba(111, 111, 111, 0.79);">Hari</th>
                <th>Pegawai</th>
                <th style="border-right: 1px solid rgba(111, 111, 111, 0.79);">Hari</th>
                <th>Pegawai</th>
                <th style="border-right: 1px solid rgba(111, 111, 111, 0.79);">Hari</th>
                <th>Pegawai</th>
                <th style="border-right: 1px solid rgba(111, 111, 111, 0.79);">Hari</th>
                <th>Pegawai</th>
                <th style="border-right: 1px solid rgba(111, 111, 111, 0.79);">Hari</th>
                <th>Pegawai</th>
                <th style="border-right: 1px solid rgba(111, 111, 111, 0.79);">Hari</th>
                <th>Pegawai</th>
                <th style="border-right: 1px solid rgba(111, 111, 111, 0.79);">Hari</th>
            </tr>
            </thead>
            <?php if (sizeof($profil3) > 0): ?>
                <?php $i = 1; ?>
                <?php if($profil3!=''): ?>
                    <?php foreach ($profil3 as $lsdata): ?>
                        <tr>
                            <td style="border-bottom: solid #666666 1px;"><?php echo $i; ?></td>
                            <td style="border-bottom: solid #666666 1px;border-right: 1px solid rgba(111, 111, 111, 0.79);"><?php echo $lsdata->nama_baru ?></td>
                            <td style="border-bottom: solid #666666 1px;text-align: center"><?php echo $lsdata->jmlPegawai ?></td>
                            <td style="border-bottom: solid #666666 1px;text-align: center;border-right: 1px solid rgba(111, 111, 111, 0.79)"><?php echo $lsdata->jmlHariKerja ?></td>
                            <td style="border-bottom: solid #666666 1px;text-align: center"><?php echo $lsdata->jml_pegawai_hadir ?></td>
                            <td style="border-bottom: solid #666666 1px;text-align: center"><?php echo $lsdata->persen_jml_pegawai_hadir ?> %</td>
                            <td style="border-bottom: solid #666666 1px;text-align: center"><?php echo $lsdata->jml_hari_hadir ?></td>
                            <td style="border-bottom: solid #666666 1px;text-align: center;border-right: 1px solid rgba(111, 111, 111, 0.79);"><?php echo $lsdata->persen_jml_hari_hadir ?> %</td>
                            <td style="border-bottom: solid #666666 1px;text-align: center"><?php echo $lsdata->jml_pegawai_absen=='0'?$lsdata->jml_pegawai_absen: "<a href=\"javascript:void(0);\" onclick=\"loadListPegawai($bln,$thn,$lsdata->id_skpd,($lsdata->jmlUnit>0?1:0),'All');\">$lsdata->jml_pegawai_absen</a>" ?></td>
                            <td style="border-bottom: solid #666666 1px;text-align: center"><?php echo $lsdata->persen_jml_pegawai_absen ?> %</td>
                            <td style="border-bottom: solid #666666 1px;text-align: center"><?php echo $lsdata->jml_hari_absen; ?></td>
                            <td style="border-bottom: solid #666666 1px;text-align: center;border-right: 1px solid rgba(111, 111, 111, 0.79)"><?php echo $lsdata->persen_jml_hari_absen ?> %</td>
                            <td style="border-bottom: solid #666666 1px;text-align: center"><?php echo $lsdata->org_C=='-'?$lsdata->org_C: "<a href=\"javascript:void(0);\" onclick=\"loadListPegawai($bln,$thn,$lsdata->id_skpd,($lsdata->jmlUnit>0?1:0),'C');\">$lsdata->org_C</a>" ?></a></td>
                            <td style="border-bottom: solid #666666 1px;text-align: center;border-right: 1px solid rgba(111, 111, 111, 0.79);"><?php echo $lsdata->hari_C ?></td>
                            <td style="border-bottom: solid #666666 1px;text-align: center"><?php echo $lsdata->org_DL=='-'?$lsdata->org_DL: "<a href=\"javascript:void(0);\" onclick=\"loadListPegawai($bln,$thn,$lsdata->id_skpd,($lsdata->jmlUnit>0?1:0),'DL');\">$lsdata->org_DL</a>" ?></td>
                            <td style="border-bottom: solid #666666 1px;text-align: center;border-right: 1px solid rgba(111, 111, 111, 0.79);"><?php echo $lsdata->hari_DL ?></td>
                            <td style="border-bottom: solid #666666 1px;text-align: center"><?php echo $lsdata->org_DI=='-'?$lsdata->org_DI: "<a href=\"javascript:void(0);\" onclick=\"loadListPegawai($bln,$thn,$lsdata->id_skpd,($lsdata->jmlUnit>0?1:0),'DI');\">$lsdata->org_DI</a>" ?></a></td>
                            <td style="border-bottom: solid #666666 1px;text-align: center;border-right: 1px solid rgba(111, 111, 111, 0.79);"><?php echo $lsdata->hari_DI ?></td>
                            <td style="border-bottom: solid #666666 1px;text-align: center"><?php echo $lsdata->org_I=='-'?$lsdata->org_I: "<a href=\"javascript:void(0);\" onclick=\"loadListPegawai($bln,$thn,$lsdata->id_skpd,($lsdata->jmlUnit>0?1:0),'I');\">$lsdata->org_I</a>" ?></td>
                            <td style="border-bottom: solid #666666 1px;text-align: center;border-right: 1px solid rgba(111, 111, 111, 0.79);"><?php echo $lsdata->hari_I ?></td>
                            <td style="border-bottom: solid #666666 1px;text-align: center"><?php echo $lsdata->org_S=='-'?$lsdata->org_S: "<a href=\"javascript:void(0);\" onclick=\"loadListPegawai($bln,$thn,$lsdata->id_skpd,($lsdata->jmlUnit>0?1:0),'S');\">$lsdata->org_S</a>" ?></a></td>
                            <td style="border-bottom: solid #666666 1px;text-align: center;border-right: 1px solid rgba(111, 111, 111, 0.79);"><?php echo $lsdata->hari_S ?></td>
                            <td style="border-bottom: solid #666666 1px;text-align: center"><?php echo $lsdata->org_TK=='-'?$lsdata->org_TK: "<a href=\"javascript:void(0);\" onclick=\"loadListPegawai($bln,$thn,$lsdata->id_skpd,($lsdata->jmlUnit>0?1:0),'TK');\">$lsdata->org_TK</a>" ?></td>
                            <td style="border-bottom: solid #666666 1px;text-align: center;border-right: 1px solid rgba(111, 111, 111, 0.79);"><?php echo $lsdata->hari_TK ?></td>
                            <td style="border-bottom: solid #666666 1px;text-align: center"><?php echo $lsdata->org_TA=='-'?$lsdata->org_TA: "<a href=\"javascript:void(0);\" onclick=\"loadListPegawai($bln,$thn,$lsdata->id_skpd,($lsdata->jmlUnit>0?1:0),'TA');\">$lsdata->org_TA</a>" ?></td>
                            <td style="border-bottom: solid #666666 1px;text-align: center;border-right: 1px solid rgba(111, 111, 111, 0.79);"><?php echo $lsdata->hari_TA ?></td>
                        </tr>
                        <?php $i++; ?>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr class="error">
                        <td colspan="9"><i>Tidak ada data</i></td>
                    </tr>
                <?php endif; ?>
            <?php else: ?>
                <tr class="error">
                    <td colspan="9"><i>Tidak ada data</i></td>
                </tr>
            <?php endif; ?>
        </table>
    </div>
</div>
<script src="../js/highcharts.js"></script>
<script type="text/javascript">
    $("#btn_tampilkan").click(function(){
        var bln = $('#ddBln').val();
        var thn = $('#ddThn').val();
        var idskpd = $('#ddFilterOpd').val();
        location.href="<?php echo base_url()."report_absensi/profil_absensi" ?>"+"?bln="+bln+"&thn="+thn+"&idskpd="+idskpd;
    });

    $("#btn_download").click(function(){
        var bln = $('#ddBln').val();
        var thn = $('#ddThn').val();
        window.open('/simpeg2/report_absensi/print_profil_absensi/'+"?bln="+bln+'&thn='+thn,'_blank');
    });

    $(function () {
        $('#container1').highcharts({
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                type: 'pie'
            },
            title: {
                text: ''
            },
            tooltip: {
                pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: true,
                        distance: 0,
                        format: '<b>{point.percentage:.1f} %</b>',
                        style: {
                            color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                        }
                    },
                    showInLegend: true
                }
            },
            series: [{
                name: 'Persentase',
                colorByPoint: true,
                data: <?php echo $chart1; ?>
            }]
        });
    });

    $(function () {
        $('#container2').highcharts({
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                type: 'pie'
            },
            title: {
                text: ''
            },
            tooltip: {
                pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: true,
                        distance: 0,
                        format: '<b>{point.percentage:.1f} %</b>',
                        style: {
                            color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                        }
                    },
                    showInLegend: true
                }
            },
            series: [{
                name: 'Brands',
                colorByPoint: true,
                data: <?php echo $chart2; ?>
            }]
        });
    });

    $(function () {
        $('#container3').highcharts({
            chart: {
                type: 'column'
            },
            title: {
                text: ''
            },
            subtitle: {
                text: ''
            },
            xAxis: {
                categories: [
                    'Total',
                    'Hadir',
                    'Tidak Hadir'
                ],
                crosshair: true
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Jumlah'
                }
            },
            tooltip: {
                headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                '<td style="padding:0"><b>{point.y:.1f}</b></td></tr>',
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
                name: 'Hari Kerja',
                data: <?php echo $chart3;?>,
                dataLabels: {
                    enabled: true,
                    rotation: -90,
                    color: '#FFFFFF',
                    align: 'right',
                    format: '{point.y}', // one decimal
                    y: 10, // 10 pixels down from the top
                    style: {
                        fontSize: '13px',
                        fontFamily: 'Verdana, sans-serif'
                    }
                }
            }]
        });
    });

    $(function () {
        $('#container4').highcharts({
            chart: {
                type: 'column'
            },
            title: {
                text: ''
            },
            subtitle: {
                text: ''
            },
            xAxis: {
                categories: [
                    'Total',
                    'Hadir',
                    'Tidak Hadir'
                ],
                crosshair: true
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Jumlah'
                }
            },
            tooltip: {
                headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                '<td style="padding:0"><b>{point.y:.1f}</b></td></tr>',
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
                name: 'Orang/Pegawai',
                data: <?php echo $chart4;?>,
                dataLabels: {
                    enabled: true,
                    rotation: -90,
                    color: '#FFFFFF',
                    align: 'right',
                    format: '{point.y}', // one decimal
                    y: 10, // 10 pixels down from the top
                    style: {
                        fontSize: '13px',
                        fontFamily: 'Verdana, sans-serif'
                    }
                }
            }]
        });
    });

    function loadListPegawai(bln,thn,idskpd,auth,status){
        $.ajax({
            method: "POST",
            url: "<?php echo base_url()?>index.php/report_absensi/detail_list_pegawai",
            data: { bln: bln, thn: thn, idskpd : idskpd, auth: auth, status: status },
            dataType: "html"
        }).done(function( data ) {
            $("#detail_list_pegawai").html(data);
            $("#detail_list_pegawai").find("script").each(function(i) {
                //eval($(this).text());
            });
        });

        $.Dialog({
            shadow: true,
            overlay: false,
            icon: '<span class="icon-rocket"></span>',
            title: 'Daftar Pegawai',
            width: 850,
            height: 550,
            padding: 10,
            content: "<div id='detail_list_pegawai' style='height:450px; overflow:auto;'></div>"
        });
    }
</script>