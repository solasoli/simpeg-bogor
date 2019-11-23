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
                <span class="span8">
                    <button id="btn_tampilkan" class="button primary" style="height: 35px;">
                        <span class="icon-zoom-in"></span> <strong>Tampilkan</strong>
                    </button>
                    <button id="btn_cetak_list" class="button primary" style="height: 35px;">
                      <span class="icon-printer"></span> <strong>Cetak Laporan Daftar</strong>
                    </button>
                    <button id="btn_cetak_rekap" class="button primary" style="height: 35px;">
                      <span class="icon-printer"></span> <strong>Cetak Laporan Rekapitulasi</strong>
                    </button>
                </span>
            </div>
        </div>

        <div class="row">
            <?php $x = 1; ?>
            <div class="panel" style="width: 320%">
            <table class="table bordered striped" id="lst_rekap_list">
                <thead style="border-bottom: solid #a4c400 2px;">
                <tr>
                    <th style="width: 70px;border-top: 1px solid rgba(111, 111, 111, 0.79);border-left: 1px solid rgba(111, 111, 111, 0.79)">No</th>
                    <th style="border-top: 1px solid rgba(111, 111, 111, 0.79)">NIP</th>
                    <th style="border-top: 1px solid rgba(111, 111, 111, 0.79)">Nama</th>
                    <!-- th style="border-top: 1px solid rgba(111, 111, 111, 0.79)">Eselon</th>
                    <th style="border-top: 1px solid rgba(111, 111, 111, 0.79)">Aksi</th>
                    <th style="border-top: 1px solid rgba(111, 111, 111, 0.79)">Std.Kerja</th>
                    <th style="border-top: 1px solid rgba(111, 111, 111, 0.79)">Minggu</th>
                    <th style="border-top: 1px solid rgba(111, 111, 111, 0.79)">Sabtu</th>
                    <th style="border-top: 1px solid rgba(111, 111, 111, 0.79)">CB Sabtu</th>
                    <th style="border-top: 1px solid rgba(111, 111, 111, 0.79)">CB Hari Kerja</th>
                    <th style="border-top: 1px solid rgba(111, 111, 111, 0.79)">LN Sabtu</th>
                    <th style="border-top: 1px solid rgba(111, 111, 111, 0.79)">LN Hari Kerja</th>
                    <th style="border-top: 1px solid rgba(111, 111, 111, 0.79)">Hari Kerja</th -->
                    <?php for ($x = 1; $x <= $maxday; $x++): ?>
                    <th style="border-top: 1px solid rgba(111, 111, 111, 0.79)"><?php echo $x; ?></th>
                    <?php endfor; ?>
                    <th style="border-top: 1px solid rgba(111, 111, 111, 0.79)">Hadir</th>
                    <th style="border-top: 1px solid rgba(111, 111, 111, 0.79)">Dinas Luar</th>
                    <th style="border-top: 1px solid rgba(111, 111, 111, 0.79)">Cuti</th>
                    <th style="border-top: 1px solid rgba(111, 111, 111, 0.79)">Sakit</th>
                    <th style="border-top: 1px solid rgba(111, 111, 111, 0.79)">Tanpa Ket.</th>
                    <th style="border-top: 1px solid rgba(111, 111, 111, 0.79)">Lepas Piket</th>
                    <th style="border-top: 1px solid rgba(111, 111, 111, 0.79)">Libur</th>
                </tr>
                </thead>
                <?php if (is_array($rekap_list) && sizeof($rekap_list) > 0): ?>
                    <?php if($rekap_list!=''): ?>
                        <?php $i=1;?>
                        <?php foreach ($rekap_list as $lsdata): ?>
                            <tr>
                                <td style="border-bottom: solid #666666 1px;text-align: center;"><?php echo $i; ?></td>
                                <td style="border-bottom: solid #666666 1px;"><?php echo "'".$lsdata->nip_baru; ?></td>
                                <td style="border-bottom: solid #666666 1px;"><?php echo $lsdata->nama; ?></td>
                                <!--td style="border-bottom: solid #666666 1px;text-align: center;"><?php // echo $lsdata->eselon; ?></td>
                                <td style="border-bottom: solid #666666 1px;text-align: center;"><button id="btnCetakAbsenByPegawai<?php echo $i; ?>" class="button small-button" onclick="cetak_absen_by_pegawai('<?php // echo $lsdata->nip_baru; ?>');"><span class="icon-printer"></span> Cetak</button></td>
                                <td style="border-bottom: solid #666666 1px;text-align: center;"><?php // echo $lsdata->jml_std_kerja; ?></td>
                                <td style="border-bottom: solid #666666 1px;text-align: center;"><?php // echo $lsdata->jml_minggu; ?></td>
                                <td style="border-bottom: solid #666666 1px;text-align: center;"><?php // echo $lsdata->jml_sabtu; ?></td>
                                <td style="border-bottom: solid #666666 1px;text-align: center;"><?php // echo $lsdata->jml_cb_sabtu; ?></td>
                                <td style="border-bottom: solid #666666 1px;text-align: center;"><?php // echo $lsdata->jml_cb_harikerja; ?></td>
                                <td style="border-bottom: solid #666666 1px;"><?php // echo $lsdata->jml_ln_sabtu; ?></td>
                                <td style="border-bottom: solid #666666 1px;text-align: center;"><?php // echo $lsdata->jml_ln_harikerja; ?></td>
                                <td style="border-bottom: solid #666666 1px;text-align: center;"><?php // echo $lsdata->jml_hari_kerja; ?></td -->
                                <?php
                                    $x=1;
                                    $jmlHdr=0;
                                    $jmlDl=0;
                                    $jmlC=0;
                                    $jmlS=0;
                                    $jmlTK=0;
                                    $jmlLpsP=0;
                                    $jmlL=0;
                                ?>
                                <?php for ($x = 1; $x <= $maxday; $x++): ?>
                                    <?php
                                        $varmin = "min_$x";
                                        $varmax = "max_$x";
                                    ?>
                                <td style="border-bottom: solid #666666 1px;text-align: center;"><?php echo (($lsdata->$varmin=='LSA' or $lsdata->$varmin=='LMI' or $lsdata->$varmin=='CB' or $lsdata->$varmin=='LN')?"<span style='color: darkred'>".$lsdata->$varmin."</span>":$lsdata->$varmin).(strlen($lsdata->$varmax)<8?'':'<br>'.$lsdata->$varmax); ?></td>
                                    <?php
                                        if(strlen($lsdata->$varmax)==8){
                                            $jmlHdr = $jmlHdr+1;
                                        }else{
                                            if($lsdata->$varmax=='DL'){
                                                $jmlDl = $jmlDl+1;
                                            }elseif($lsdata->$varmax=='C'){
                                                $jmlC = $jmlC+1;
                                            }elseif($lsdata->$varmax=='S'){
                                                $jmlS = $jmlS+1;
                                            }elseif($lsdata->$varmax=='-'){
                                                $jmlTK = $jmlTK+1;
                                            }elseif($lsdata->$varmax=='LP'){
                                                $jmlLpsP = $jmlLpsP+1;
                                            }elseif($lsdata->$varmax=='Libur'){
                                                $jmlL = $jmlL+1;
                                            }
                                        }
                                    ?>
                                <?php endfor; ?>
                                <td style="border-bottom: solid #666666 1px;text-align: center;"><?php echo $jmlHdr; ?></td>
                                <td style="border-bottom: solid #666666 1px;text-align: center;"><?php echo $jmlDl; ?></td>
                                <td style="border-bottom: solid #666666 1px;text-align: center;"><?php echo $jmlC; ?></td>
                                <td style="border-bottom: solid #666666 1px;text-align: center;"><?php echo $jmlS; ?></td>
                                <td style="border-bottom: solid #666666 1px;text-align: center;"><?php echo $jmlTK; ?></td>
                                <td style="border-bottom: solid #666666 1px;text-align: center;"><?php echo $jmlLpsP; ?></td>
                                <td style="border-bottom: solid #666666 1px;text-align: center;"><?php echo $jmlL; ?></td>
                            </tr>
                            <?php $i++; ?>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr class="error">
                            <td colspan="3"><i>Tidak ada data</i></td>
                        </tr>
                    <?php endif; ?>
                <?php else: ?>
                    <tr class="error">
                        <td colspan="3"><i>Tidak ada data</i></td>
                    </tr>
                <?php endif; ?>
            </table>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $("#btn_tampilkan").click(function(){
        var bln = $('#ddBln').val();
        var thn = $('#ddThn').val();
        var idskpd = $('#ddFilterOpd').val();
        var idunit = $('#ddFilterUk').val();
        location.href="<?php echo base_url()."report_absensi/rekap_list_opd" ?>"+"?bln="+bln+"&thn="+thn+"&idskpd="+idskpd+"&idunit="+idunit;
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

    $("#btn_cetak_list").click(function () {
        var bln = $('#ddBln').val();
        var thn = $('#ddThn').val();
        var idskpd = $('#ddFilterOpd').val();
        var idunit = $('#ddFilterUk').val();
        window.open("<?php echo base_url()."report_absensi/cetak_list_daftar" ?>"+"?bln="+bln+"&thn="+thn+"&idskpd="+idskpd+"&idunit="+idunit, '_blank');
    });

    $("#btn_cetak_rekap").click(function () {
        var bln = $('#ddBln').val();
        var thn = $('#ddThn').val();
        var idskpd = $('#ddFilterOpd').val();
        var idunit = $('#ddFilterUk').val();
        window.open("<?php echo base_url()."report_absensi/cetak_list_jumlah" ?>"+"?bln="+bln+"&thn="+thn+"&idskpd="+idskpd+"&idunit="+idunit, '_blank');
    });

    function cetak_absen_by_pegawai(nip){
        var nip = nip;
        var bln = $('#ddBln').val();
        var thn = $('#ddThn').val();
        var idskpd = $('#ddFilterOpd').val();
        var idunit = $('#ddFilterUk').val();
        window.open("<?php echo base_url()."report_absensi/cetak_absen_by_pegawai" ?>"+"?nip="+nip+"&bln="+bln+"&thn="+thn+"&idskpd="+idskpd+"&idunit="+idunit, '_blank');
    }

</script>
