<div class="container">
    <div class="grid">
        <div class="row">
            <div class="span12">
                <div class="span2">
                    <div class="input-control select" style="width: 100%;">
                        <select id="ddBln" style="background-color: #e3c800;">
                            <option value="01" <?php echo $bln==1?'selected':'' ?>>Januari</option>
                            <option value="02" <?php echo $bln==2?'selected':'' ?>>Februari</option>
                            <option value="03" <?php echo $bln==3?'selected':'' ?>>Maret</option>
                            <option value="04" <?php echo $bln==4?'selected':'' ?>>April</option>
                            <option value="05" <?php echo $bln==5?'selected':'' ?>>Mei</option>
                            <option value="06" <?php echo $bln==6?'selected':'' ?>>Juni</option>
                            <option value="07" <?php echo $bln==7?'selected':'' ?>>Juli</option>
                            <option value="08" <?php echo $bln==8?'selected':'' ?>>Agustus</option>
                            <option value="09" <?php echo $bln==9?'selected':'' ?>>September</option>
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
                <span class="span3">
                    <?php if (isset($list_skpd)): ?>
                        <div class="input-control select" style="width: 100%;">
                            <select id="ddFilterOpd" style="background-color: #e3c800;" onchange="getListUnitKerja()">
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
                <span class="span3">
                    <div class="input-control select" style="width: 100%;">
                        <div id="dvCboUk">
                            <select id="ddFilterUk" style="background-color: #e3c800;">
                                <?php foreach ($list_uk as $ls): ?>
                                    <?php if($ls->id_unit_kerja == $idunit): ?>
                                        <option value="<?php echo $ls->id_unit_kerja; ?>" selected><?php echo $ls->unit; ?></option>
                                    <?php else: ?>
                                        <option value="<?php echo $ls->id_unit_kerja; ?>"><?php echo $ls->unit; ?></option>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </span>
            </div>
        </div>

        <div class="row" style="margin-top: -20px;">
            <div class="span12">
                <span class="span4">
                    <button id="btn_tampilkan" class="button primary" style="height: 35px;">
                        <span class="icon-zoom-in"></span> <strong>Tampilkan</strong>
                    </button>
                    <button id="btn_download" class="button primary" style="height: 35px;">
                      <span class="icon-printer"></span> <strong>Cetak Laporan</strong>
                    </button>
                </span>
            </div>
        </div>

        <div class="row">
            <?php if (is_array($rekap_jumlah) && sizeof($rekap_jumlah) > 0): ?>
                <?php $x=1;?>
                <?php foreach ($rekap_jumlah as $lsdata): ?>
                    <table class="table bordered" id="lst_rekap_jumlah">
                        <tr style='border-bottom: solid 2px #d29d4e;background-color: lightgrey; border-top: solid 1px #cdcfc7;'>
                            <td style="width: 150px;">Uraian</td><td>OPD</td></tr>
                        <tr><td>Unit Kerja</td><td><strong><?php echo ($lsdata->opd==$lsdata->unit?$lsdata->opd:$lsdata->unit); ?></strong></td></tr>
                        <tr><td>Jumlah Pegawai</td><td><?php echo $lsdata->jml_pegawai; ?> orang</td></tr>
                        <tr><td>Jumlah Hari Kerja</td><td><?php echo $lsdata->jml_hari_kerja; ?> hari
                            (Minggu: <?php echo $lsdata->jml_minggu; ?>, Sabtu: <?php echo $lsdata->jml_sabtu; ?>, CB Sabtu: <?php echo $lsdata->jml_cb_sabtu; ?>,
                                CB Hari Kerja: <?php echo $lsdata->jml_cb_harikerja; ?>, LN Sabtu: <?php echo $lsdata->jml_ln_sabtu; ?>,
                                LN Hari Kerja: <?php echo $lsdata->jml_ln_harikerja; ?>)
                            </td></tr>
                        <tr><td colspan="2">
                                <table class="table bordered">
                                    <tr style='border-bottom: solid 2px rgba(71,71,72,0.5);background-color: white; border-top: solid 1px #cdcfc7;text-align: center;'>
                                        <td>Tanggal</td><td>Hadir</td><td>Dinas Luar</td><td>Cuti</td><td>Sakit</td><td>Tanpa Keterangan</td><td>Lepas Piket</td><td>Libur</td><td>Jumlah</td><td>Aksi</td>
                                    </tr>

                                    <?php for ($x = 1; $x <= $maxday; $x++): ?>
                                    <?php
                                    $varHdr = "jml_hdr_$x";
                                    $varDL = "jml_DL_$x";
                                    $varC = "jml_C_$x";
                                    $varS = "jml_S_$x";
                                    $varTK = "jml_TK_$x";
                                    $varLP = "jml_LP_$x";
                                    $varLbr = "jml_Lbr_$x";
                                    ?>
                                    <tr style="background-color: white;border-bottom: solid 1px rgba(205,205,208,0.35);text-align: center;">
                                        <td><?php echo $x;?></td>
                                        <td><?php echo ($lsdata->$varHdr==0?0:"<a href=\"javascript:void(0);\" onclick=\"loadListPegawai($x,$bln,$thn,$lsdata->id_skpd,$lsdata->id_unit_kerja,'Hadir');\">".$lsdata->$varHdr."</a>"); ?></td>
                                        <td><?php echo ($lsdata->$varDL==0?0:"<a href=\"javascript:void(0);\" onclick=\"loadListPegawai($x,$bln, $thn, $lsdata->id_skpd, $lsdata->id_unit_kerja, 'DL');\">".$lsdata->$varDL."</a>"); ?></td>
                                        <td><?php echo ($lsdata->$varC==0?0:"<a href=\"javascript:void(0);\" onclick=\"loadListPegawai($x,$bln, $thn, $lsdata->id_skpd, $lsdata->id_unit_kerja, 'C');\">".$lsdata->$varC."</a>"); ?></td>
                                        <td><?php echo ($lsdata->$varS==0?0:"<a href=\"javascript:void(0);\" onclick=\"loadListPegawai($x,$bln, $thn, $lsdata->id_skpd, $lsdata->id_unit_kerja, 'S');\">".$lsdata->$varS."</a>"); ?></td>
                                        <td><?php echo ($lsdata->$varTK==0?0:"<a href=\"javascript:void(0);\" onclick=\"loadListPegawai($x,$bln, $thn, $lsdata->id_skpd, $lsdata->id_unit_kerja, 'TK');\">".$lsdata->$varTK."</a>"); ?></td>
                                        <td><?php echo ($lsdata->$varLP==0?0:"<a href=\"javascript:void(0);\" onclick=\"loadListPegawai($x,$bln, $thn, $lsdata->id_skpd, $lsdata->id_unit_kerja, 'LP');\">".$lsdata->$varLP."</a>"); ?></td>
                                        <td><?php echo ($lsdata->$varLbr==0?0:"<a href=\"javascript:void(0);\" onclick=\"loadListPegawai($x,$bln, $thn, $lsdata->id_skpd, $lsdata->id_unit_kerja, 'Libur');\">".$lsdata->$varLbr."</a>"); ?></td>
                                        <td><?php echo($lsdata->$varHdr+$lsdata->$varDL+$lsdata->$varC+$lsdata->$varS+$lsdata->$varTK+$lsdata->$varLP+$lsdata->$varLbr); ?></td>
                                        <td><button id="btnCetakAbsenByHari<?php echo $x; ?>" class="button small-button" onclick="cetak_absen_by_hari(<?php echo $x; ?>);"><span class="icon-printer"></span> Cetak</button></td>
                                    </tr>
                                    <?php endfor; ?>
                                    <tr style="background-color: white;border-top: solid 2px rgba(205,205,208,0.35);text-align: center;">
                                        <td>Jumlah</td>
                                        <td><?php echo ($lsdata->jml_hadir==0?0:"<a href=\"javascript:void(0);\" onclick=\"loadListPegawai(0,$bln, $thn, $lsdata->id_skpd, $lsdata->id_unit_kerja, 'Hadir');\">".$lsdata->jml_hadir."</a>");?></td>
                                        <td><?php echo ($lsdata->jml_dinas_luar==0?0:"<a href=\"javascript:void(0);\" onclick=\"loadListPegawai(0,$bln, $thn, $lsdata->id_skpd, $lsdata->id_unit_kerja, 'DL');\">".$lsdata->jml_dinas_luar."</a>");?></td>
                                        <td><?php echo ($lsdata->jml_cuti==0?0:"<a href=\"javascript:void(0);\" onclick=\"loadListPegawai(0,$bln, $thn, $lsdata->id_skpd, $lsdata->id_unit_kerja, 'C');\">".$lsdata->jml_cuti."</a>");?></td>
                                        <td><?php echo ($lsdata->jml_sakit==0?0:"<a href=\"javascript:void(0);\" onclick=\"loadListPegawai(0,$bln, $thn, $lsdata->id_skpd, $lsdata->id_unit_kerja, 'S');\">".$lsdata->jml_sakit."</a>");?></td>
                                        <td><?php echo ($lsdata->jml_tanpa_ket==0?0:"<a href=\"javascript:void(0);\" onclick=\"loadListPegawai(0,$bln, $thn, $lsdata->id_skpd, $lsdata->id_unit_kerja, 'TK');\">".$lsdata->jml_tanpa_ket."</a>");?></td>
                                        <td><?php echo ($lsdata->jml_lps_piket==0?0:"<a href=\"javascript:void(0);\" onclick=\"loadListPegawai(0,$bln, $thn, $lsdata->id_skpd, $lsdata->id_unit_kerja, 'LP');\">".$lsdata->jml_lps_piket."</a>");?></td>
                                        <td><?php echo ($lsdata->jml_libur==0?0:"<a href=\"javascript:void(0);\" onclick=\"loadListPegawai(0,$bln, $thn, $lsdata->id_skpd, $lsdata->id_unit_kerja, 'libur');\">".$lsdata->jml_libur."</a>");?></td>
                                        <td></td><td></td>
                                    </tr>
                                    <tr style="background-color: white;border-bottom: solid 1px rgba(205,205,208,0.35);text-align: center;">
                                        <td>Persentase</td>
                                        <td>( <?php echo round(($lsdata->jml_hadir/$lsdata->jml_hari_kerja)*100,2);?>% )</td>
                                        <td>( <?php echo round(($lsdata->jml_dinas_luar/$lsdata->jml_hari_kerja)*100,2);?>% )</td>
                                        <td>( <?php echo round(($lsdata->jml_cuti/$lsdata->jml_hari_kerja)*100,2);?>% )</td>
                                        <td>( <?php echo round(($lsdata->jml_sakit/$lsdata->jml_hari_kerja)*100,2);?>% )</td>
                                        <td>( <?php echo round(($lsdata->jml_tanpa_ket/$lsdata->jml_hari_kerja)*100,2);?>% )</td>
                                        <td>( <?php echo round(($lsdata->jml_lps_piket/$lsdata->jml_hari_kerja)*100,2);?>% )</td>
                                        <td>( <?php echo round(($lsdata->jml_libur/$lsdata->jml_hari_kerja)*100,2);?>% )</td>
                                        <td></td><td></td>
                                    </tr>
                                </table>
                            </td></tr>
                    </table>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</div>

<script type="text/javascript">

    $("#btn_tampilkan").click(function(){
        var bln = $('#ddBln').val();
        var thn = $('#ddThn').val();
        var idskpd = $('#ddFilterOpd').val();
        var idunit = $('#ddFilterUk').val();
        location.href="<?php echo base_url()."report_absensi/rekap_jumlah_opd" ?>"+"?bln="+bln+"&thn="+thn+"&idskpd="+idskpd+"&idunit="+idunit;
    });

    function getListUnitKerja(){
        var idskpd = $("#ddFilterOpd").val();
        $.ajax({
            method: "POST",
            url: "<?php echo base_url()?>index.php/report_absensi/getListUnitKerja",
            data: { idskpd: idskpd},
            dataType: "html"
        }).done(function( data ) {
            $("#dvCboUk").html(data);
            $("#dvCboUk").find("script").each(function(i) {
                //eval($(this).text());
            });
        });
    }

    function loadListPegawai(tgl,bln,thn,idskpd,idunit,status){
        //alert(tgl+','+bln+','+thn+','+idskpd+','+idunit+','+status);
        $.ajax({
            method: "POST",
            url: "<?php echo base_url()?>index.php/report_absensi/detail_list_pegawai_by_periode",
            data: { tgl: tgl, bln: bln, thn: thn, idskpd : idskpd, idunit: idunit, status: status },
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

    $("#btn_download").click(function () {
        var bln = $('#ddBln').val();
        var thn = $('#ddThn').val();
        var idskpd = $('#ddFilterOpd').val();
        var idunit = $('#ddFilterUk').val();
        window.open("<?php echo base_url()."report_absensi/cetak_rekap_jumlah" ?>"+"?bln="+bln+"&thn="+thn+"&idskpd="+idskpd+"&idunit="+idunit, '_blank');
    });

    function cetak_absen_by_hari(hari){
        var bln = $('#ddBln').val();
        var thn = $('#ddThn').val();
        var idskpd = $('#ddFilterOpd').val();
        var idunit = $('#ddFilterUk').val();
        window.open("<?php echo base_url()."report_absensi/cetak_absen_by_hari" ?>"+"?hari="+hari+"&bln="+bln+"&thn="+thn+"&idskpd="+idskpd+"&idunit="+idunit, '_blank');
    }

</script>