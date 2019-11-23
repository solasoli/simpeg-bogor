<div class="container">
    <div class="grid">
        <br>
        <div class="tab-control" data-role="tab-control" data-effect="fade">
            <ul class="tabs">
                <li class="active"><a href="#_page_1">Rekapitulasi Per Jenis dan Status</a></li>
                <li><a href="#_page_2">Rekapitulasi Per Periode</a></li>
                <li><a href="#_page_3">Rekapitulasi Jabatan Kosong</a></li>
            </ul>
            <div class="frames">
                <div class="frame" id="_page_1">
                    <div class="row">
                        <div class="span6">
                            <div class="panel">
                                <div class="panel-header">Berds. Jenis</div>
                                <div class="panel-content">
                                    <table class="table bordered striped" id="lst_data">
                                        <div id="container1" style="margin: 30px ;"></div>
                                        <thead style="border-bottom: solid #a4c400 2px;">
                                        <tr>
                                            <th style="width: 20px;border-top: 1px solid rgba(111, 111, 111, 0.79);border-left: 1px solid rgba(111, 111, 111, 0.79)">No</th>
                                            <th style="border-right: 1px solid rgba(111, 111, 111, 0.79);border-top: 1px solid rgba(111, 111, 111, 0.79)">Jenis</th>
                                            <th style="border-top: 1px solid rgba(111, 111, 111, 0.79);border-right: 1px solid rgba(111, 111, 111, 0.79)">Jumlah</th>
                                        </tr>
                                        </thead>
                                        <?php if (sizeof($rekap_jenis) > 0): ?>
                                            <?php $i = 1; ?>
                                            <?php if($rekap_jenis!=''): ?>
                                                <?php foreach ($rekap_jenis as $lsdata): ?>
                                                    <tr>
                                                        <td style="border-bottom: solid #666666 1px;text-align: center;"><?php echo $i; ?></td>
                                                        <td style="border-right: 1px solid rgba(111, 111, 111, 0.79);border-bottom: solid #666666 1px;text-align: center; text-align: left;"><?php echo $lsdata->jenis_diklat ?></td>
                                                        <td style="border-bottom: solid #666666 1px;text-align: center"><?php echo $lsdata->jumlah ?></td>
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
                            <div class="panel" style="width: 120%">
                                <div class="panel-header">Berds. Status Diklat PIM Pejabat Eksisting</div>
                                <div class="panel-content">
                                    <table class="table bordered striped" id="lst_data2">
                                        <thead style="border-bottom: solid #a4c400 2px;">
                                        <tr>
                                            <th style="width: 20px;border-top: 1px solid rgba(111, 111, 111, 0.79);border-left: 1px solid rgba(111, 111, 111, 0.79)">No</th>
                                            <th style="border-right: 1px solid rgba(111, 111, 111, 0.79);border-top: 1px solid rgba(111, 111, 111, 0.79)">Eselon</th>
                                            <th style="border-right: 1px solid rgba(111, 111, 111, 0.79);border-top: 1px solid rgba(111, 111, 111, 0.79)">Status</th>
                                            <th style="border-top: 1px solid rgba(111, 111, 111, 0.79);border-right: 1px solid rgba(111, 111, 111, 0.79)">Jumlah</th>
                                        </tr>
                                        </thead>
                                        <?php if (sizeof($rekap_pim) > 0): ?>
                                            <?php $i = 1; ?>
                                            <?php if($rekap_pim!=''): ?>
                                                <?php
                                                    $jml_es2 = 0;
                                                    $jml_es3 = 0;
                                                    $jml_es4 = 0;
                                                    $jml_es2_sdh = 0;
                                                    $jml_es3_sdh = 0;
                                                    $jml_es4_sdh = 0;
                                                    $jml_es2_blm = 0;
                                                    $jml_es3_blm = 0;
                                                    $jml_es4_blm = 0;
                                                ?>
                                                <?php foreach ($rekap_pim as $lsdata): ?>
                                                    <tr>
                                                        <td style="border-bottom: solid #666666 <?php echo $lsdata->status_diklat=='Jumlah'?'2px':'1px'; ?>;text-align: center;"><?php echo $lsdata->eselon==''?'':$i; ?></td>
                                                        <td style="border-right: 1px solid rgba(111, 111, 111, 0.79);border-bottom: solid #666666 <?php echo $lsdata->status_diklat=='Jumlah'?'2px':'1px'; ?>;text-align: center; text-align: left;"><?php echo $lsdata->eselon ?></td>
                                                        <td style="border-right: 1px solid rgba(111, 111, 111, 0.79);border-bottom: solid #666666 <?php echo $lsdata->status_diklat=='Jumlah'?'2px':'1px'; ?>;text-align: center; text-align: left;">
                                                            <?php
                                                            if (strpos($lsdata->status_diklat, 'Jumlah') !== false) {
                                                                echo substr($lsdata->status_diklat, 0, 6);
                                                            }else{
                                                                echo $lsdata->status_diklat;
                                                            }

                                                            if($lsdata->status_diklat=='Jumlah IIA' or $lsdata->status_diklat=='Jumlah IIB'){
                                                                $jml_es2 = $jml_es2 + $lsdata->jumlah;
                                                            }
                                                            if($lsdata->status_diklat=='Jumlah IIIA' or $lsdata->status_diklat=='Jumlah IIIB'){
                                                                $jml_es3 = $jml_es3 + $lsdata->jumlah;
                                                            }
                                                            if($lsdata->status_diklat=='Jumlah IVA' or $lsdata->status_diklat=='Jumlah IVB'){
                                                                $jml_es4 = $jml_es4 + $lsdata->jumlah;
                                                            }

                                                            if($lsdata->status_diklat=='Sudah Diklat PIM II'){
                                                                $jml_es2_sdh = $jml_es2_sdh + $lsdata->jumlah;
                                                            }
                                                            if($lsdata->status_diklat=='Sudah Diklat PIM III'){
                                                                $jml_es3_sdh = $jml_es3_sdh + $lsdata->jumlah;
                                                            }
                                                            if($lsdata->status_diklat=='Sudah Diklat PIM IV'){
                                                                $jml_es4_sdh = $jml_es4_sdh + $lsdata->jumlah;
                                                            }

                                                            if($lsdata->status_diklat=='Belum Diklat PIM II'){
                                                                $jml_es2_blm = $jml_es2_blm + $lsdata->jumlah;
                                                            }
                                                            if($lsdata->status_diklat=='Belum Diklat PIM III'){
                                                                $jml_es3_blm = $jml_es3_blm + $lsdata->jumlah;
                                                            }
                                                            if($lsdata->status_diklat=='Belum Diklat PIM IV'){
                                                                $jml_es4_blm = $jml_es4_blm + $lsdata->jumlah;
                                                            }
                                                            ?>
                                                        </td>
                                                        <td style="border-bottom: solid #666666 <?php echo $lsdata->status_diklat=='Jumlah'?'2px':'1px'; ?>;text-align: center; ">
                                                            <?php echo "<a href=\"javascript:void(0);\" onclick=\"loadListPejabatDiklat('$lsdata->status_diklat','$lsdata->eselon_view');\">$lsdata->jumlah</a>"; ?>
                                                        </td>
                                                    </tr>
                                                    <?php
                                                    if($lsdata->eselon!=''){
                                                        $i++;
                                                    }
                                                    ?>
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
                                    <span style="margin-top: 10px; font-weight: bold;">Persentase Diklat Manajerial</span>
                                    <table class="table bordered striped">
                                        <thead style="border-bottom: solid #a4c400 2px;">
                                        <tr>
                                            <td rowspan="2" style="text-align: center; vertical-align: middle">Uraian</td>
                                            <td rowspan="2" style="text-align: center; vertical-align: middle;width: 20%;">Jumlah Pegawai</td>
                                            <td colspan="2" style="text-align: center;">Sudah</td>
                                            <td colspan="2" style="text-align: center;">Belum</td>
                                        </tr>
                                        <tr>
                                            <td style="text-align: center;">Jml</td><td style="text-align: center;">%</td>
                                            <td style="text-align: center;">Jml</td><td style="text-align: center;">%</td>
                                        </tr>
                                        </thead>
                                        <tr style="text-align: center;">
                                            <td>Eselon II</td>
                                            <td><?php echo $jml_es2;?></td>
                                            <td><?php echo $jml_es2_sdh;?></td>
                                            <td><?php echo round(($jml_es2_sdh/$jml_es2)*100,2);?> %</td>
                                            <td><?php echo $jml_es2_blm;?></td>
                                            <td><?php echo round(($jml_es2_blm/$jml_es2)*100,2);?> %</td>
                                        </tr>
                                        <tr style="text-align: center;">
                                            <td>Eselon III</td>
                                            <td><?php echo $jml_es3;?></td>
                                            <td><?php echo $jml_es3_sdh;?></td>
                                            <td><?php echo round(($jml_es3_sdh/$jml_es3)*100,2);?> %</td>
                                            <td><?php echo $jml_es3_blm;?></td>
                                            <td><?php echo round(($jml_es3_blm/$jml_es3)*100,2);?> %</td>
                                        </tr>
                                        <tr style="text-align: center;">
                                            <td>Eselon IV</td>
                                            <td><?php echo $jml_es4;?></td>
                                            <td><?php echo $jml_es4_sdh;?></td>
                                            <td><?php echo round(($jml_es4_sdh/$jml_es4)*100,2);?> %</td>
                                            <td><?php echo $jml_es4_blm;?></td>
                                            <td><?php echo round(($jml_es4_blm/$jml_es4)*100,2);?> %</td>
                                        </tr>
                                        <?php
                                            $totA = $jml_es2+$jml_es3+$jml_es4;
                                            $totB = $jml_es2_sdh+$jml_es3_sdh+$jml_es4_sdh;
                                            $totC = $jml_es2_blm+$jml_es3_blm+$jml_es4_blm;
                                        ?>
                                        <tr style="text-align: center;">
                                            <td>Total</td>
                                            <td><?php echo ($totA);?></td>
                                            <td><?php echo ($totB);?></td>
                                            <td><?php echo round(($totB/$totA)*100,2);?> %</td>
                                            <td><?php echo ($totC);?></td>
                                            <td><?php echo round(($totC/$totA)*100,2);?> %</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="frame" id="_page_2">
                    <div class="row">
                        <div class="span12">
                            <div class="panel" style="width: 110%">
                                <div class="panel-header"> Berds. Periode Pelaksanaan dan Jenis (Data OPD pegawai ada)</div>
                                <div class="panel-content">

                                            <table class="table bordered striped" id="lst_data3">
                                                <thead style="border-bottom: solid #a4c400 2px;">
                                                <tr>
                                                    <th style="width: 20px;border-top: 1px solid rgba(111, 111, 111, 0.79);border-left: 1px solid rgba(111, 111, 111, 0.79)">No</th>
                                                    <th style="border-right: 1px solid rgba(111, 111, 111, 0.79);border-top: 1px solid rgba(111, 111, 111, 0.79)">Thn</th>
                                                    <th style="border-right: 1px solid rgba(111, 111, 111, 0.79);border-top: 1px solid rgba(111, 111, 111, 0.79)">Periode</th>
                                                    <th style="border-right: 1px solid rgba(111, 111, 111, 0.79);border-top: 1px solid rgba(111, 111, 111, 0.79)">Fungsional</th>
                                                    <th style="border-right: 1px solid rgba(111, 111, 111, 0.79);border-top: 1px solid rgba(111, 111, 111, 0.79)">Kepemimpinan</th>
                                                    <th style="border-right: 1px solid rgba(111, 111, 111, 0.79);border-top: 1px solid rgba(111, 111, 111, 0.79)">Teknis</th>
                                                    <th style="border-right: 1px solid rgba(111, 111, 111, 0.79);border-top: 1px solid rgba(111, 111, 111, 0.79)">Prajabatan</th>
                                                    <th style="border-right: 1px solid rgba(111, 111, 111, 0.79);border-top: 1px solid rgba(111, 111, 111, 0.79)">Bintek</th>
                                                    <th style="border-right: 1px solid rgba(111, 111, 111, 0.79);border-top: 1px solid rgba(111, 111, 111, 0.79)">Workshop</th>
                                                    <th style="border-right: 1px solid rgba(111, 111, 111, 0.79);border-top: 1px solid rgba(111, 111, 111, 0.79)">Sosialisai</th>
                                                    <th style="border-right: 1px solid rgba(111, 111, 111, 0.79);border-top: 1px solid rgba(111, 111, 111, 0.79)">Lokakarya</th>
                                                    <th style="border-top: 1px solid rgba(111, 111, 111, 0.79);border-right: 1px solid rgba(111, 111, 111, 0.79)">Jumlah</th>
                                                </tr>
                                                </thead>
                                                <?php if (sizeof($rekap_periode) > 0): ?>
                                                    <?php $i = 1; ?>
                                                    <?php if($rekap_periode!=''): ?>
                                                        <?php foreach ($rekap_periode as $lsdata): ?>
                                                            <tr>
                                                                <td style="border-bottom: solid #666666 1px;text-align: center;"><?php echo $i; ?></td>
                                                                <td style="border-right: 1px solid rgba(111, 111, 111, 0.79);border-bottom: solid #666666 1px;text-align: center; text-align: left;"><?php echo $lsdata->thn_periode ?></td>
                                                                <td style="border-right: 1px solid rgba(111, 111, 111, 0.79);border-bottom: solid #666666 1px;text-align: center"><?php echo $lsdata->bln_periode ?></td>
                                                                <td style="border-right: 1px solid rgba(111, 111, 111, 0.79);border-bottom: solid #666666 1px;text-align: center"><?php echo $lsdata->Fungsional ?></td>
                                                                <td style="border-right: 1px solid rgba(111, 111, 111, 0.79);border-bottom: solid #666666 1px;text-align: center"><?php echo $lsdata->Kepemimpinan ?></td>
                                                                <td style="border-right: 1px solid rgba(111, 111, 111, 0.79);border-bottom: solid #666666 1px;text-align: center"><?php echo $lsdata->Teknis ?></td>
                                                                <td style="border-right: 1px solid rgba(111, 111, 111, 0.79);border-bottom: solid #666666 1px;text-align: center"><?php echo $lsdata->Prajabatan ?></td>
                                                                <td style="border-right: 1px solid rgba(111, 111, 111, 0.79);border-bottom: solid #666666 1px;text-align: center"><?php echo $lsdata->Bintek ?></td>
                                                                <td style="border-right: 1px solid rgba(111, 111, 111, 0.79);border-bottom: solid #666666 1px;text-align: center"><?php echo $lsdata->Workshop ?></td>
                                                                <td style="border-right: 1px solid rgba(111, 111, 111, 0.79);border-bottom: solid #666666 1px;text-align: center"><?php echo $lsdata->Sosialisasi ?></td>
                                                                <td style="border-right: 1px solid rgba(111, 111, 111, 0.79);border-bottom: solid #666666 1px;text-align: center"><?php echo $lsdata->Lokakarya ?></td>
                                                                <td style="border-bottom: solid #666666 1px;text-align: center"><?php echo ($lsdata->Fungsional + $lsdata->Kepemimpinan + $lsdata->Teknis +
                                                                        $lsdata->Prajabatan + $lsdata->Bintek + $lsdata->Workshop + $lsdata->Sosialisasi + $lsdata->Lokakarya) ?></td>
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
                    </div>
                </div>
                <div class="frame" id="_page_3">

                            <table class="table bordered striped" id="lst_data3">
                                <thead style="border-bottom: solid #a4c400 2px;">
                                <tr>
                                    <th style="width: 20px;border-top: 1px solid rgba(111, 111, 111, 0.79);border-left: 1px solid rgba(111, 111, 111, 0.79)">No</th>
                                    <th style="border-right: 1px solid rgba(111, 111, 111, 0.79);border-top: 1px solid rgba(111, 111, 111, 0.79)">OPD</th>
                                    <th style="border-right: 1px solid rgba(111, 111, 111, 0.79);border-top: 1px solid rgba(111, 111, 111, 0.79)">Eselon II</th>
                                    <th style="border-right: 1px solid rgba(111, 111, 111, 0.79);border-top: 1px solid rgba(111, 111, 111, 0.79)">Eselon III</th>
                                    <th style="border-right: 1px solid rgba(111, 111, 111, 0.79);border-top: 1px solid rgba(111, 111, 111, 0.79)">Eselon IV</th>
                                    <th style="border-top: 1px solid rgba(111, 111, 111, 0.79);border-right: 1px solid rgba(111, 111, 111, 0.79)">Jumlah</th>
                                </tr>
                                </thead>
                                <?php if (sizeof($rekap_jab_kosong) > 0): ?>
                                    <?php
                                        $i = 1;
                                        $jmlEs2 = 0;
                                        $jmlEs3 = 0;
                                        $jmlEs4 = 0;
                                        $jmlTot = 0;
                                    ?>
                                    <?php if($rekap_jab_kosong!=''): ?>
                                        <?php foreach ($rekap_jab_kosong as $lsdata): ?>
                                            <tr>
                                                <td style="border-bottom: solid #666666 1px;text-align: center;"><?php echo $i; ?></td>
                                                <td style="border-right: 1px solid rgba(111, 111, 111, 0.79);border-bottom: solid #666666 1px;text-align: center; text-align: left;"><?php echo $lsdata->nama_baru;?></td>
                                                <td style="border-right: 1px solid rgba(111, 111, 111, 0.79);border-bottom: solid #666666 1px;text-align: center"><?php echo $lsdata->eselon_2; $jmlEs2+= $lsdata->eselon_2; ?></td>
                                                <td style="border-right: 1px solid rgba(111, 111, 111, 0.79);border-bottom: solid #666666 1px;text-align: center"><?php echo $lsdata->eselon_3; $jmlEs3+= $lsdata->eselon_3; ?></td>
                                                <td style="border-right: 1px solid rgba(111, 111, 111, 0.79);border-bottom: solid #666666 1px;text-align: center"><?php echo $lsdata->eselon_4; $jmlEs4+= $lsdata->eselon_4; ?></td>
                                                <td style="border-right: 1px solid rgba(111, 111, 111, 0.79);border-bottom: solid #666666 1px;text-align: center"><?php echo $lsdata->jml; $jmlTot+= $lsdata->jml; ?></td>
                                            </tr>
                                            <?php $i++; ?>
                                        <?php endforeach; ?>
                                        <tr style="border-bottom: solid 1px rgba(54, 54, 54, 0.95)">
                                            <td></td>
                                            <td style="font-weight: bold;">Total</td>
                                            <td style="text-align: center; font-weight: bold;"><?php echo $jmlEs2; ?></td>
                                            <td style="text-align: center; font-weight: bold;"><?php echo $jmlEs3; ?></td>
                                            <td style="text-align: center; font-weight: bold;"><?php echo $jmlEs4; ?></td>
                                            <td style="text-align: center; font-weight: bold;"><?php echo $jmlTot; ?></td>
                                        </tr>
                                    <?php else: ?>
                                        <tr class="error">
                                            <td colspan="6"><i>Tidak ada data</i></td>
                                        </tr>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <tr class="error">
                                        <td colspan="6"><i>Tidak ada data</i></td>
                                    </tr>
                                <?php endif; ?>
                            </table>
                        
                </div>
            </div>
        </div>
    </div>
</div>
<script src="../js/highcharts.js"></script>
<script type="text/javascript">

    $(function () {
        $('#container1').highcharts({
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                type: 'pie'
            },
            title: {
                text: 'Grafik Rekapitulasi Jenis Diklat'
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
                        distance: 2,
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
                data: <?php echo $chart; ?>
            }]
        });
    });

    function loadListPejabatDiklat(status, eselon){
        $.ajax({
            method: "POST",
            url: "<?php echo base_url()?>index.php/diklat/view_detail_pejabat_by_rekap",
            data: { status: status, eselon: eselon },
            dataType: "html"
        }).done(function( data ) {
            $("#detail_list_pejabat").html(data);
            $("#detail_list_pejabat").find("script").each(function(i) {
                //eval($(this).text());
            });
        });

        $.Dialog({
            shadow: true,
            overlay: false,
            icon: '<span class="icon-rocket"></span>',
            title: 'Daftar Pejabat Struktural',
            width: 850,
            height: 550,
            padding: 10,
            content: "<div id='detail_list_pejabat' style='height:450px; overflow:auto;'>Loading...</div>"
        });
    }

</script>