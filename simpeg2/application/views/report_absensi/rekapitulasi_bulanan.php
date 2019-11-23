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
                        <span class="icon-file"></span> <strong>Download Report</strong></button>
                </span>
            </div>
        </div>
    </div>
    <div class="panel">
        <div class="panel-header">Rekapitulasi Absensi Bulanan (Berds. Hari)</div>
        <div class="panel-content">
            <table class="table bordered striped" id="lst_data">
                <thead style="border-bottom: solid #a4c400 2px;">
                <tr>
                    <th rowspan="2" style="border-right: 1px solid rgba(111, 111, 111, 0.79);border-top: 1px solid rgba(111, 111, 111, 0.79);border-left: 1px solid rgba(111, 111, 111, 0.79);">Tanggal</th>
                    <th colspan="7" style="border-right: 1px solid rgba(111, 111, 111, 0.79);border-top: 1px solid rgba(111, 111, 111, 0.79);border-bottom: 1px solid rgba(111, 111, 111, 0.79)">Ketidakhadiran</th>
                    <th rowspan="2" style="border-right: 1px solid rgba(111, 111, 111, 0.79);border-top: 1px solid rgba(111, 111, 111, 0.79);">Tidak Apel</th>
                    <th colspan="2" style="border-top: 1px solid rgba(111, 111, 111, 0.79);border-right: 1px solid rgba(111, 111, 111, 0.79);border-bottom: 1px solid rgba(111, 111, 111, 0.79)">Persentase</th>
                </tr>
                <tr>
                    <th>Cuti</th>
                    <th>Dinas Luar</th>
                    <th>Dispensasi</th>
                    <th>Ijin</th>
                    <th>Sakit</th>
                    <th style="border-right: 1px solid rgba(111, 111, 111, 0.79)">Tanpa Keterangan</th>
                    <th style="border-right: 1px solid rgba(111, 111, 111, 0.79)">Total</th>
                    <th>Kehadiran</th>
                    <th style="border-right: 1px solid rgba(111, 111, 111, 0.79);">Apel</th>
                </tr>
                </thead>
                <?php if (sizeof($rekap1) > 0): ?>
                    <?php if($rekap1!=''): ?>
                        <?php foreach ($rekap1 as $lsdata): ?>
                            <tr>
                                <td style="border-right: 1px solid rgba(111, 111, 111, 0.79);border-bottom: solid #666666 1px;text-align: center"><?php echo $lsdata->TANGGAL ?></td>
                                <td style="border-bottom: solid #666666 1px;text-align: center"><?php echo $lsdata->C ?></td>
                                <td style="border-bottom: solid #666666 1px;text-align: center"><?php echo $lsdata->DL ?></td>
                                <td style="border-bottom: solid #666666 1px;text-align: center"><?php echo $lsdata->DI ?></td>
                                <td style="border-bottom: solid #666666 1px;text-align: center"><?php echo $lsdata->I ?></td>
                                <td style="border-bottom: solid #666666 1px;text-align: center"><?php echo $lsdata->S ?></td>
                                <td style="border-right: 1px solid rgba(111, 111, 111, 0.79);border-bottom: solid #666666 1px;text-align: center"><?php echo $lsdata->TK ?></td>
                                <td style="border-right: 1px solid rgba(111, 111, 111, 0.79);border-bottom: solid #666666 1px;text-align: center"><?php echo $lsdata->TDK_HADIR=='0'?$lsdata->TDK_HADIR: "<a href=\"javascript:void(0);\" onclick=\"loadListPegawaiRekapBulanan('$lsdata->TANGGAL',$bln,$thn,$idskpd,'All');\">$lsdata->TDK_HADIR</a>" ?></td>
                                <td style="border-right: 1px solid rgba(111, 111, 111, 0.79);border-bottom: solid #666666 1px;text-align: center"><?php echo $lsdata->TDK_APEL=='0'?$lsdata->TDK_APEL: "<a href=\"javascript:void(0);\" onclick=\"loadListPegawaiRekapBulanan('$lsdata->TANGGAL',$bln,$thn,$idskpd,'TA');\">$lsdata->TDK_APEL</a>" ?></td>
                                <td style="border-bottom: solid #666666 1px;text-align: center"><?php echo $lsdata->PERSEN_KEHADIRAN?>%</td>
                                <td style="border-bottom: solid #666666 1px;text-align: center"><?php echo $lsdata->PERSEN_APEL?> %</td>
                            </tr>
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
<script type="text/javascript">
    $("#btn_tampilkan").click(function(){
        var bln = $('#ddBln').val();
        var thn = $('#ddThn').val();
        var idskpd = $('#ddFilterOpd').val();
        location.href="<?php echo base_url()."report_absensi/rekapitulasi_bulanan" ?>"+"?bln="+bln+"&thn="+thn+"&idskpd="+idskpd;
    });

    $("#btn_download").click(function(){
        var bln = $('#ddBln').val();
        var thn = $('#ddThn').val();
        var idskpd = $('#ddFilterOpd').val();
        window.open('/simpeg2/report_absensi/print_rekap_bulanan/'+"?bln="+bln+'&thn='+thn+'&idskpd='+idskpd,'_blank');
    });

    function loadListPegawaiRekapBulanan(tgl,bln,thn,idskpd,status){
        var bln = $('#ddBln').val();
        var thn = $('#ddThn').val();
        var idskpd = $('#ddFilterOpd').val();
        $.ajax({
            method: "POST",
            url: "<?php echo base_url()?>index.php/report_absensi/detail_list_pegawai_rekap_bulanan",
            data: { tgl: tgl, bln: bln, thn: thn, idskpd : idskpd, status: status },
            dataType: "html"
        }).done(function( data ) {
            $("#detail_list_pegawai_rb").html(data);
            $("#detail_list_pegawai_rb").find("script").each(function(i) {
                eval($(this).text());
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
            content: "<div id='detail_list_pegawai_rb' style='height:450px; overflow:auto;'></div>"
        });
    }
</script>