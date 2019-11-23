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
    <?php
        $d=cal_days_in_month(CAL_GREGORIAN,date("m"),date("Y"));
    ?>
    <div class="panel">
        <div class="panel-header">Rekapitulasi Absensi Pegawai</div>
        <div class="panel-content">
            <table class="table bordered striped" id="lst_data">
                <thead style="border-bottom: solid #a4c400 2px;">
                <tr>
                    <th rowspan="2" style="width: 20px;border-top: 1px solid rgba(111, 111, 111, 0.79);border-left: 1px solid rgba(111, 111, 111, 0.79)">No</th>
                    <th rowspan="2" style="border-right: 1px solid rgba(111, 111, 111, 0.79);border-top: 1px solid rgba(111, 111, 111, 0.79)">NAMA</th>
                    <th colspan="<?php echo $d ?>" style="border-right: 1px solid rgba(111, 111, 111, 0.79);border-top: 1px solid rgba(111, 111, 111, 0.79);border-bottom: 1px solid rgba(111, 111, 111, 0.79)">Tanggal</th>
                    <th colspan="8" style="border-right: 1px solid rgba(111, 111, 111, 0.79);border-top: 1px solid rgba(111, 111, 111, 0.79);border-bottom: 1px solid rgba(111, 111, 111, 0.79)">Rekap Per Status</th>
                </tr>
                <tr>
                    <th>1</th><th>2</th><th>3</th><th>4</th><th>5</th><th>6</th>
                    <th>7</th><th>8</th><th>9</th><th>10</th><th>11</th><th>12</th>
                    <th>13</th><th>14</th><th>15</th><th>16</th><th>17</th><th>18</th>
                    <th>19</th><th>20</th><th>21</th><th>22</th><th>23</th><th>24</th>
                    <th>25</th><th>26</th><th>27</th><th>28</th>
                    <?php if($d==29): ?>
                        <th style="border-right: 1px solid rgba(111, 111, 111, 0.79)">29</th>
                    <?php endif; ?>
                    <?php if($d==30): ?>
                        <th>29</th>
                        <th style="border-right: 1px solid rgba(111, 111, 111, 0.79)">30</th>
                    <?php endif; ?>
                    <?php if($d==31): ?>
                        <th>29</th>
                        <th>30</th>
                        <th style="border-right: 1px solid rgba(111, 111, 111, 0.79)">31</th>
                    <?php endif; ?>
                    <th>JML</th><th>C</th><th>DL</th><th>DI</th><th>I</th><th>S</th><th>TK</th><th>TA</th>
                </tr>
                </thead>
                <?php if (sizeof($rekap2) > 0): ?>
                    <?php $i = 1; ?>
                    <?php if($rekap2!=''): ?>
                        <?php foreach ($rekap2 as $lsdata): ?>
                            <tr>
                                <td style="border-bottom: solid #666666 1px;"><?php echo $i; ?></td>
                                <td style="border-right: 1px solid rgba(111, 111, 111, 0.79);border-bottom: solid #666666 1px;"><?php echo $lsdata->nama ?><br><?php echo $lsdata->nip_baru ?></td>
                                <td style="border-bottom: solid #666666 1px;text-align: center"><?php echo $lsdata->_1 ?></td>
                                <td style="border-bottom: solid #666666 1px;text-align: center"><?php echo $lsdata->_2 ?></td>
                                <td style="border-bottom: solid #666666 1px;text-align: center"><?php echo $lsdata->_3 ?></td>
                                <td style="border-bottom: solid #666666 1px;text-align: center"><?php echo $lsdata->_4 ?></td>
                                <td style="border-bottom: solid #666666 1px;text-align: center"><?php echo $lsdata->_5 ?></td>
                                <td style="border-bottom: solid #666666 1px;text-align: center"><?php echo $lsdata->_6 ?></td>
                                <td style="border-bottom: solid #666666 1px;text-align: center"><?php echo $lsdata->_7 ?></td>
                                <td style="border-bottom: solid #666666 1px;text-align: center"><?php echo $lsdata->_8 ?></td>
                                <td style="border-bottom: solid #666666 1px;text-align: center"><?php echo $lsdata->_9 ?></td>
                                <td style="border-bottom: solid #666666 1px;text-align: center"><?php echo $lsdata->_10 ?></td>
                                <td style="border-bottom: solid #666666 1px;text-align: center"><?php echo $lsdata->_11 ?></td>
                                <td style="border-bottom: solid #666666 1px;text-align: center"><?php echo $lsdata->_12 ?></td>
                                <td style="border-bottom: solid #666666 1px;text-align: center"><?php echo $lsdata->_13 ?></td>
                                <td style="border-bottom: solid #666666 1px;text-align: center"><?php echo $lsdata->_14 ?></td>
                                <td style="border-bottom: solid #666666 1px;text-align: center"><?php echo $lsdata->_15 ?></td>
                                <td style="border-bottom: solid #666666 1px;text-align: center"><?php echo $lsdata->_16 ?></td>
                                <td style="border-bottom: solid #666666 1px;text-align: center"><?php echo $lsdata->_17 ?></td>
                                <td style="border-bottom: solid #666666 1px;text-align: center"><?php echo $lsdata->_18 ?></td>
                                <td style="border-bottom: solid #666666 1px;text-align: center"><?php echo $lsdata->_19 ?></td>
                                <td style="border-bottom: solid #666666 1px;text-align: center"><?php echo $lsdata->_20 ?></td>
                                <td style="border-bottom: solid #666666 1px;text-align: center"><?php echo $lsdata->_21 ?></td>
                                <td style="border-bottom: solid #666666 1px;text-align: center"><?php echo $lsdata->_22 ?></td>
                                <td style="border-bottom: solid #666666 1px;text-align: center"><?php echo $lsdata->_23 ?></td>
                                <td style="border-bottom: solid #666666 1px;text-align: center"><?php echo $lsdata->_24 ?></td>
                                <td style="border-bottom: solid #666666 1px;text-align: center"><?php echo $lsdata->_25 ?></td>
                                <td style="border-bottom: solid #666666 1px;text-align: center"><?php echo $lsdata->_26 ?></td>
                                <td style="border-bottom: solid #666666 1px;text-align: center"><?php echo $lsdata->_27 ?></td>
                                <td style="border-bottom: solid #666666 1px;text-align: center"><?php echo $lsdata->_28 ?></td>
                                <?php if(isset($lsdata->_29)): ?>
                                    <td style="border-bottom: solid #666666 1px;text-align: center;">
                                        <?php echo $lsdata->_29 ?>
                                    </td>
                                <?php endif; ?>
                                <?php if(isset($lsdata->_30)): ?>
                                    <td style="border-bottom: solid #666666 1px;text-align: center;">
                                        <?php echo $lsdata->_30 ?>
                                    </td>
                                <?php endif; ?>
                                <?php if(isset($lsdata->_31)): ?>
                                    <td style="border-bottom: solid #666666 1px;text-align: center;">
                                        <?php echo $lsdata->_31 ?>
                                    </td>
                                <?php endif; ?>
                                <td style="border-bottom: solid #666666 1px;text-align: center;border-left: 1px solid rgba(111, 111, 111, 0.79);"><?php echo $lsdata->jml_hari ?></td>
                                <td style="border-bottom: solid #666666 1px;text-align: center"><?php echo $lsdata->C ?></td>
                                <td style="border-bottom: solid #666666 1px;text-align: center"><?php echo $lsdata->DL ?></td>
                                <td style="border-bottom: solid #666666 1px;text-align: center"><?php echo $lsdata->DI ?></td>
                                <td style="border-bottom: solid #666666 1px;text-align: center"><?php echo $lsdata->I ?></td>
                                <td style="border-bottom: solid #666666 1px;text-align: center"><?php echo $lsdata->S ?></td>
                                <td style="border-bottom: solid #666666 1px;text-align: center"><?php echo $lsdata->TK ?></td>
                                <td style="border-bottom: solid #666666 1px;text-align: center"><?php echo $lsdata->TA ?></td>
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

    <script type="text/javascript">
        $("#btn_tampilkan").click(function(){
            var bln = $('#ddBln').val();
            var thn = $('#ddThn').val();
            var idskpd = $('#ddFilterOpd').val();
            location.href="<?php echo base_url()."report_absensi/rekapitulasi_pegawai" ?>"+"?bln="+bln+"&thn="+thn+"&idskpd="+idskpd;
        });

        $("#btn_download").click(function(){
            var bln = $('#ddBln').val();
            var thn = $('#ddThn').val();
            var idskpd = $('#ddFilterOpd').val();
            window.open('/simpeg2/report_absensi/print_rekap_pegawai/'+"?bln="+bln+'&thn='+thn+'&idskpd='+idskpd,'_blank');
        });
    </script>
