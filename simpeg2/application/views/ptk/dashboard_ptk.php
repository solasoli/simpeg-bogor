<div class="container">
    <div class="grid">
        <?php if($tx_result == 1): ?>
            <div class="row">
                <div class="span12">
                    <div class="notice" style="background-color: #00a300;">
                        <div class="fg-white">Data sukses tersimpan</div>
                    </div>
                </div>
            </div>
        <?php elseif($tx_result == 2): ?>
            <div class="row">
                <div class="span12">
                    <div class="notice" style="background-color: #9a1616;">
                        <div class="fg-white">Data tidak tersimpan</div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
        <br>
        <div class="tab-control" data-role="tab-control" data-effect="fade">
            <ul class="tabs">
                <li class="active"><a href="#_page_1">Rekapitulasi Per Jenis dan Status</a></li>
                <li><a href="#_page_2">Rekapitulasi Per OPD</a></li>
                <li><a href="#_page_3">Pengantar untuk BPKAD</a></li>
            </ul>
            <div class="frames">
                <div class="frame" id="_page_1">
                    <div class="row">
                        <div>
                            <div class="panel">
                                <div class="panel-header">Berdasarkan Jenis Pengajuan</div>
                                <div class="panel-content">
                                    <div class="row">
                                        <div class="span6">
                                            <div id="container_ptk" style="margin: 0 auto; height: 250px;"></div>
                                        </div>
                                        <div class="span6">
                                            <table class="table bordered striped" id="lst_data">
                                                <div id="container1" style="margin: 30px ;"></div>
                                                <thead style="border-bottom: solid #a4c400 2px;">
                                                <tr>
                                                    <th style="width: 20px;">No</th>
                                                    <th>Jenis Pengajuan PTK</th>
                                                    <th>Jumlah</th>
                                                </tr>
                                                </thead>
                                                <?php if (sizeof($rekap_jenis) > 0): ?>
                                                    <?php $i = 1; ?>
                                                    <?php if($rekap_jenis!=''): ?>
                                                        <?php foreach ($rekap_jenis as $lsdata): ?>
                                                            <tr>
                                                                <td style="text-align: center;"><?php echo ($lsdata->jenis_pengajuan=='Jumlah'?'':$i); ?></td>
                                                                <td style="text-align: center; text-align: left;"><?php echo $lsdata->jenis_pengajuan ?></td>
                                                                <td style="text-align: center"><?php echo $lsdata->jumlah ?></td>
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
                    </div>
                    <div class="row">
                        <div>
                            <div class="panel">
                                <div class="panel-header">Berdasarkan Status Approval</div>
                                <div class="panel-content">
                                    <table class="table bordered striped" id="lst_data3">
                                        <thead style="border-bottom: solid #a4c400 2px;">
                                        <tr>
                                            <th style="width: 20px;vertical-align: middle;border: 1px solid #747571;">No</th>
                                            <th style="vertical-align: middle;border: 1px solid #747571;">Jenis</th>
                                            <th style="vertical-align: middle;border: 1px solid #747571;">Permohonan Baru</th>
                                            <th style="vertical-align: middle;border: 1px solid #747571;">Sudah Upload Persyaratan</th>
                                            <th style="vertical-align: middle;border: 1px solid #747571;">Revisi Permohonan</th>
                                            <th style="vertical-align: middle;border: 1px solid #747571;">Dalam Proses BKPSDA</th>
                                            <th style="vertical-align: middle;border: 1px solid #747571;">Disetujui BKPSDA</th>
                                            <th style="vertical-align: middle;border: 1px solid #747571;">Ditolak BKPSDA</th>
                                            <th style="vertical-align: middle;border: 1px solid #747571;">Dibatalkan BKPSDA</th>
                                            <th style="vertical-align: middle;border: 1px solid #747571;">Surat BPKAD Terbit</th>
                                            <th style="vertical-align: middle;border: 1px solid #747571;">Dalam Proses BPKAD</th>
                                            <th style="vertical-align: middle;border: 1px solid #747571;">Tunjangan sudah diubah</th>
                                            <th style="vertical-align: middle;border: 1px solid #747571;">Ditolak BPKAD</th>
                                        </tr>
                                        </thead>
                                        <?php if (sizeof($rekap_status) > 0): ?>
                                            <?php $i = 1; ?>
                                            <?php if($rekap_status!=''): ?>
                                                <?php foreach ($rekap_status as $lsdata): ?>
                                                    <tr>
                                                        <td style="text-align: center;border: 1px solid #747571;"><?php echo ($lsdata->jenis_pengajuan=='Jumlah'?'':$i); ?></td>
                                                        <td style="text-align: center; text-align: left;border: 1px solid #747571;"><?php echo $lsdata->jenis_pengajuan ?></td>
                                                        <td style="text-align: center;border: 1px solid #747571;"><?php echo $lsdata->Permohonan_Baru ?></td>
                                                        <td style="text-align: center;border: 1px solid #747571;"><?php echo $lsdata->Sudah_Upload_Syarat ?></td>
                                                        <td style="text-align: center;border: 1px solid #747571;"><?php echo $lsdata->Revisi_Permohonan ?></td>
                                                        <td style="text-align: center;border: 1px solid #747571;"><?php echo $lsdata->Sedang_Proses_BKPSDA ?></td>
                                                        <td style="text-align: center;border: 1px solid #747571;"><?php echo $lsdata->Disetujui_BKPSDA ?></td>
                                                        <td style="text-align: center;border: 1px solid #747571;"><?php echo $lsdata->Ditolak_BKPSDA ?></td>
                                                        <td style="text-align: center;border: 1px solid #747571;"><?php echo $lsdata->Dibatalkan_BKPSDA ?></td>
                                                        <td style="text-align: center;border: 1px solid #747571;"><?php echo $lsdata->Surat_Terbit ?></td>
                                                        <td style="text-align: center;border: 1px solid #747571;"><?php echo $lsdata->Proses_BPKAD ?></td>
                                                        <td style="text-align: center;border: 1px solid #747571;"><?php echo $lsdata->Tunjangan_Berubah ?></td>
                                                        <td style="text-align: center;border: 1px solid #747571;"><?php echo $lsdata->Tolak_BPKAD ?></td>
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
            </div>
            <div class="frames">
                <div class="frame" id="_page_2">
                    <strong>Keterangan:</strong>
                    <ul>
                        <li><strong>A)</strong> Dalam proses yang bersangkutan,
                            <strong>B)</strong> Dalam proses BKPSDA,
                            <strong>C)</strong> Disetujui BKPSDA,
                            <strong>D)</strong> Ditolak BKPSDA,
                            <strong>E)</strong> Dibatalkan BKPSDA,
                            <strong>F)</strong> Surat ke BPKAD Terbit,
                            <strong>G)</strong> Dalam Proses BPKAD,
                            <strong>H)</strong> Ditolak BPKAD,
                            <strong>I)</strong> Tunjangan sudah diubah
                        </li>
                    </ul>
                    <br>
                    <table class="table bordered striped" id="lst_data3">
                        <thead style="border-bottom: solid #a4c400 2px;">
                        <tr>
                            <th style="width: 20px;border-top: 1px solid rgba(111, 111, 111, 0.79);border-left: 1px solid rgba(111, 111, 111, 0.79); vertical-align:middle;" rowspan="2">No</th>
                            <th style="width: 20px;border-top: 1px solid rgba(111, 111, 111, 0.79);border-left: 1px solid rgba(111, 111, 111, 0.79); width: 25%;vertical-align:middle;" rowspan="2">OPD</th>
                            <th style="width: 20px;border-top: 1px solid rgba(111, 111, 111, 0.79);border-bottom: 1px solid rgba(111, 111, 111, 0.79);border-left: 2px solid rgba(111, 111, 111, 0.79);vertical-align:middle;" colspan="10">Penambahan Jiwa</th>
                            <th style="width: 20px;border-top: 1px solid rgba(111, 111, 111, 0.79);border-bottom: 1px solid rgba(111, 111, 111, 0.79);border-left: 2px solid rgba(111, 111, 111, 0.79);vertical-align:middle;" colspan="10">Pengurangan Jiwa</th>
                            <th style="width: 20px;border-top: 1px solid rgba(111, 111, 111, 0.79);border-bottom: 1px solid rgba(111, 111, 111, 0.79);border-left: 2px solid rgba(111, 111, 111, 0.79);" colspan="10">Penambahan dan <br>Pengurangan Jiwa</th>
                            <th style="width: 20px;border-top: 1px solid rgba(111, 111, 111, 0.79);border-left: 2px solid rgba(111, 111, 111, 0.79); vertical-align:middle;border-right: 1px solid rgba(111, 111, 111, 0.79);" rowspan="2">&Sigma;</th>
                        </tr>
                        <tr>
                            <th style="border-left: 2px solid rgba(111, 111, 111, 0.79);border-right: 1px solid rgba(111, 111, 111, 0.79);border-top: 1px solid rgba(111, 111, 111, 0.79)">A</th>
                            <th style="border-right: 1px solid rgba(111, 111, 111, 0.79);border-top: 1px solid rgba(111, 111, 111, 0.79)">B</th>
                            <th style="border-right: 1px solid rgba(111, 111, 111, 0.79);border-top: 1px solid rgba(111, 111, 111, 0.79)">C</th>
                            <th style="border-right: 1px solid rgba(111, 111, 111, 0.79);border-top: 1px solid rgba(111, 111, 111, 0.79)">D</th>
                            <th style="border-right: 1px solid rgba(111, 111, 111, 0.79);border-top: 1px solid rgba(111, 111, 111, 0.79)">E</th>
                            <th style="border-right: 1px solid rgba(111, 111, 111, 0.79);border-top: 1px solid rgba(111, 111, 111, 0.79)">F</th>
                            <th style="border-right: 1px solid rgba(111, 111, 111, 0.79);border-top: 1px solid rgba(111, 111, 111, 0.79)">G</th>
                            <th style="border-right: 1px solid rgba(111, 111, 111, 0.79);border-top: 1px solid rgba(111, 111, 111, 0.79)">H</th>
                            <th style="border-right: 1px solid rgba(111, 111, 111, 0.79);border-top: 1px solid rgba(111, 111, 111, 0.79)">I</th>
                            <th style="border-right: 2px solid rgba(111, 111, 111, 0.79);border-top: 1px solid rgba(111, 111, 111, 0.79);background-color:lightblue;">&Sigma;</th>
                            <th style="border-right: 1px solid rgba(111, 111, 111, 0.79);border-top: 1px solid rgba(111, 111, 111, 0.79)">A</th>
                            <th style="border-right: 1px solid rgba(111, 111, 111, 0.79);border-top: 1px solid rgba(111, 111, 111, 0.79)">B</th>
                            <th style="border-right: 1px solid rgba(111, 111, 111, 0.79);border-top: 1px solid rgba(111, 111, 111, 0.79)">C</th>
                            <th style="border-right: 1px solid rgba(111, 111, 111, 0.79);border-top: 1px solid rgba(111, 111, 111, 0.79)">D</th>
                            <th style="border-right: 1px solid rgba(111, 111, 111, 0.79);border-top: 1px solid rgba(111, 111, 111, 0.79)">E</th>
                            <th style="border-right: 1px solid rgba(111, 111, 111, 0.79);border-top: 1px solid rgba(111, 111, 111, 0.79)">F</th>
                            <th style="border-right: 1px solid rgba(111, 111, 111, 0.79);border-top: 1px solid rgba(111, 111, 111, 0.79)">G</th>
                            <th style="border-right: 1px solid rgba(111, 111, 111, 0.79);border-top: 1px solid rgba(111, 111, 111, 0.79)">H</th>
                            <th style="border-right: 1px solid rgba(111, 111, 111, 0.79);border-top: 1px solid rgba(111, 111, 111, 0.79)">I</th>
                            <th style="border-right: 2px solid rgba(111, 111, 111, 0.79);border-top: 1px solid rgba(111, 111, 111, 0.79);background-color:lightblue;">&Sigma;</th>
                            <th style="border-right: 1px solid rgba(111, 111, 111, 0.79);border-top: 1px solid rgba(111, 111, 111, 0.79)">A</th>
                            <th style="border-right: 1px solid rgba(111, 111, 111, 0.79);border-top: 1px solid rgba(111, 111, 111, 0.79)">B</th>
                            <th style="border-right: 1px solid rgba(111, 111, 111, 0.79);border-top: 1px solid rgba(111, 111, 111, 0.79)">C</th>
                            <th style="border-right: 1px solid rgba(111, 111, 111, 0.79);border-top: 1px solid rgba(111, 111, 111, 0.79)">D</th>
                            <th style="border-right: 1px solid rgba(111, 111, 111, 0.79);border-top: 1px solid rgba(111, 111, 111, 0.79)">E</th>
                            <th style="border-right: 1px solid rgba(111, 111, 111, 0.79);border-top: 1px solid rgba(111, 111, 111, 0.79)">F</th>
                            <th style="border-right: 1px solid rgba(111, 111, 111, 0.79);border-top: 1px solid rgba(111, 111, 111, 0.79)">G</th>
                            <th style="border-right: 1px solid rgba(111, 111, 111, 0.79);border-top: 1px solid rgba(111, 111, 111, 0.79)">H</th>
                            <th style="border-right: 1px solid rgba(111, 111, 111, 0.79);border-top: 1px solid rgba(111, 111, 111, 0.79)">I</th>
                            <th style="border-right: 2px solid rgba(111, 111, 111, 0.79);border-top: 1px solid rgba(111, 111, 111, 0.79);background-color:lightblue;">&Sigma;</th>
                        </tr>
                        </thead>
                        <?php if (sizeof($rekap_jenis_status) > 0): ?>
                            <?php $i = 1; ?>
                            <?php if($rekap_jenis_status!=''): ?>
                                <?php foreach ($rekap_jenis_status as $lsdata): ?>
                                    <tr>
                                        <td style="border-bottom: solid #666666 1px;text-align: center;border-left: 1px solid rgba(111, 111, 111, 0.79);"><?php echo $i; ?></td>
                                        <td style="border-right: 2px solid rgba(111, 111, 111, 0.79);border-bottom: solid #666666 1px;text-align: center; text-align: left;border-left: 1px solid rgba(111, 111, 111, 0.79);"><?php echo $lsdata->opd ?></td>
                                        <td style="border-right: 1px solid rgba(111, 111, 111, 0.79);border-bottom: solid #666666 1px;text-align: center; text-align: left;"><?php echo $lsdata->plus_Proses_Ybs ?></td>
                                        <td style="border-right: 1px solid rgba(111, 111, 111, 0.79);border-bottom: solid #666666 1px;text-align: center; text-align: left;"><?php echo $lsdata->plus_Proses_BKPSDA ?></td>
                                        <td style="border-right: 1px solid rgba(111, 111, 111, 0.79);border-bottom: solid #666666 1px;text-align: center; text-align: left;"><?php echo $lsdata->plus_Disetujui ?></td>
                                        <td style="border-right: 1px solid rgba(111, 111, 111, 0.79);border-bottom: solid #666666 1px;text-align: center; text-align: left;"><?php echo $lsdata->plus_Ditolak ?></td>
                                        <td style="border-right: 1px solid rgba(111, 111, 111, 0.79);border-bottom: solid #666666 1px;text-align: center; text-align: left;"><?php echo $lsdata->plus_Dibatalkan ?></td>
                                        <td style="border-right: 1px solid rgba(111, 111, 111, 0.79);border-bottom: solid #666666 1px;text-align: center; text-align: left;"><?php echo $lsdata->plus_Surat_Terbit ?></td>
                                        <td style="border-right: 1px solid rgba(111, 111, 111, 0.79);border-bottom: solid #666666 1px;text-align: center; text-align: left;"><?php echo $lsdata->plus_Proses_Bpkad ?></td>
                                        <td style="border-right: 1px solid rgba(111, 111, 111, 0.79);border-bottom: solid #666666 1px;text-align: center; text-align: left;"><?php echo $lsdata->plus_Tolak_Bpkad ?></td>
                                        <td style="border-right: 1px solid rgba(111, 111, 111, 0.79);border-bottom: solid #666666 1px;text-align: center; text-align: left;"><?php echo $lsdata->plus_Tunjangan_Berubah ?></td>
                                        <td style="border-right: 2px solid rgba(111, 111, 111, 0.79);border-bottom: solid #666666 1px;text-align: center; text-align: left;"><?php echo $lsdata->total_plus ?></td>
                                        <td style="border-right: 1px solid rgba(111, 111, 111, 0.79);border-bottom: solid #666666 1px;text-align: center; text-align: left;"><?php echo $lsdata->min_Proses_Ybs ?></td>
                                        <td style="border-right: 1px solid rgba(111, 111, 111, 0.79);border-bottom: solid #666666 1px;text-align: center; text-align: left;"><?php echo $lsdata->min_Proses_BKPSDA ?></td>
                                        <td style="border-right: 1px solid rgba(111, 111, 111, 0.79);border-bottom: solid #666666 1px;text-align: center; text-align: left;"><?php echo $lsdata->min_Disetujui ?></td>
                                        <td style="border-right: 1px solid rgba(111, 111, 111, 0.79);border-bottom: solid #666666 1px;text-align: center; text-align: left;"><?php echo $lsdata->min_Ditolak ?></td>
                                        <td style="border-right: 1px solid rgba(111, 111, 111, 0.79);border-bottom: solid #666666 1px;text-align: center; text-align: left;"><?php echo $lsdata->min_Dibatalkan ?></td>
                                        <td style="border-right: 1px solid rgba(111, 111, 111, 0.79);border-bottom: solid #666666 1px;text-align: center; text-align: left;"><?php echo $lsdata->min_Surat_Terbit ?></td>
                                        <td style="border-right: 1px solid rgba(111, 111, 111, 0.79);border-bottom: solid #666666 1px;text-align: center; text-align: left;"><?php echo $lsdata->min_Proses_Bpkad ?></td>
                                        <td style="border-right: 1px solid rgba(111, 111, 111, 0.79);border-bottom: solid #666666 1px;text-align: center; text-align: left;"><?php echo $lsdata->min_Tolak_Bpkad ?></td>
                                        <td style="border-right: 1px solid rgba(111, 111, 111, 0.79);border-bottom: solid #666666 1px;text-align: center; text-align: left;"><?php echo $lsdata->min_Tunjangan_Berubah ?></td>
                                        <td style="border-right: 2px solid rgba(111, 111, 111, 0.79);border-bottom: solid #666666 1px;text-align: center; text-align: left;"><?php echo $lsdata->total_min ?></td>
                                        <td style="border-right: 1px solid rgba(111, 111, 111, 0.79);border-bottom: solid #666666 1px;text-align: center; text-align: left;"><?php echo $lsdata->plusmin_Proses_Ybs ?></td>
                                        <td style="border-right: 1px solid rgba(111, 111, 111, 0.79);border-bottom: solid #666666 1px;text-align: center; text-align: left;"><?php echo $lsdata->plusmin_Proses_BKPSDA ?></td>
                                        <td style="border-right: 1px solid rgba(111, 111, 111, 0.79);border-bottom: solid #666666 1px;text-align: center; text-align: left;"><?php echo $lsdata->plusmin_Disetujui ?></td>
                                        <td style="border-right: 1px solid rgba(111, 111, 111, 0.79);border-bottom: solid #666666 1px;text-align: center; text-align: left;"><?php echo $lsdata->plusmin_Ditolak ?></td>
                                        <td style="border-right: 1px solid rgba(111, 111, 111, 0.79);border-bottom: solid #666666 1px;text-align: center; text-align: left;"><?php echo $lsdata->plusmin_Dibatalkan ?></td>
                                        <td style="border-right: 1px solid rgba(111, 111, 111, 0.79);border-bottom: solid #666666 1px;text-align: center; text-align: left;"><?php echo $lsdata->plusmin_Surat_Terbit ?></td>
                                        <td style="border-right: 1px solid rgba(111, 111, 111, 0.79);border-bottom: solid #666666 1px;text-align: center; text-align: left;"><?php echo $lsdata->plusmin_Proses_Bpkad ?></td>
                                        <td style="border-right: 1px solid rgba(111, 111, 111, 0.79);border-bottom: solid #666666 1px;text-align: center; text-align: left;"><?php echo $lsdata->plusmin_Tolak_Bpkad ?></td>
                                        <td style="border-right: 1px solid rgba(111, 111, 111, 0.79);border-bottom: solid #666666 1px;text-align: center; text-align: left;"><?php echo $lsdata->plusmin_Tunjangan_Berubah ?></td>
                                        <td style="border-right: 2px solid rgba(111, 111, 111, 0.79);border-bottom: solid #666666 1px;text-align: center; text-align: left;"><?php echo $lsdata->total_plus_min ?></td>
                                        <td style="border-right: 1px solid rgba(111, 111, 111, 0.79);border-bottom: solid #666666 1px;text-align: center; text-align: left;"><?php echo $lsdata->grand_total ?></td>
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
            <div class="frames">
                <div class="frame" id="_page_3">
                    <div class="grid">
                        <div class="row">
                            <span class="span2" style="margin-top: -15px;">Periode Pengajuan </span>
                            <span class="span2" style="margin-top: -20px;">
                                <div class="input-control select" >
                                    <select id="ddBulan">
                                        <option value="0">Semua Bulan</option>
                                        <?php
                                        $i = 0;
                                        for ($x = 0; $x <= 11; $x++) {
                                            echo "<option value=".$listBln[$i][0].">".$listBln[$i][1]."</option>";
                                            $i++;
                                        }
                                        ?>
                                    </select>
                                </div>
                            </span>
                            <span class="span2" style="margin-top: -20px;">
                                <div class="input-control select" >
                                    <select id="ddTahun">
                                        <option value="0">Semua Tahun</option>
                                        <?php
                                        $i = 0;
                                        for ($x = 0; $x < sizeof($listThn); $x++) {
                                            echo "<option value=".$listThn[$i].">".$listThn[$i]."</option>";
                                            $i++;
                                        }
                                        ?>
                                    </select>
                                </div>
                            </span>
                            <span class="span4" style="margin-top: -20px;">
                                <button id="btn_tampilkan" class="button primary" style="height: 35px;">
                                    <strong>Tampilkan</strong></button>
                                <a href="<?php echo base_url('ptk/tambah_pengantar/')?>" class="button success"
                                   style="height: 35px;padding-top: 8px;"><strong>Tambah Baru</strong></a>
                            </span>
                        </div>
                        <div class="row">
                            <div id="divPengantar"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="../simpeg2/js/highcharts.js"></script>
<script type="text/javascript">

    $(function () {
        loadDefaultPengantarBPKAD();
        $('#container_ptk').highcharts({
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                type: 'pie'
            },
            title: {
                text: 'Grafik Rekapitulasi Jenis Pengajuan'
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

        $("#btn_tampilkan").click(function(){
            var bln = $('#ddBulan').val();
            var thn = $('#ddTahun').val();
            loadDataPengantar(bln,thn,'','');
        });

        function loadDataPengantar(bln,thn,page,ipp){
            $("#btn_tampilkan").css("pointer-events", "none");
            $("#btn_tampilkan").css("opacity", "0.4");
            $("#divPengantar").css("pointer-events", "none");
            $("#divPengantar").css("opacity", "0.4");
            $.post('<?php echo base_url()."index.php/ptk/drop_data_pengantar_bpkad"; ?>',
            {
                bln: bln,
                thn: thn,
                page: page,
                ipp: ipp
            }, function(data){
                $("#divPengantar").html(data);
                $("#divPengantar").find("script").each(function(i) {
                     eval($(this).text());
                });
                    $("#btn_tampilkan").css("pointer-events", "auto");
                    $("#btn_tampilkan").css("opacity", "1");
                    $("#divPengantar").css("pointer-events", "auto");
                    $("#divPengantar").css("opacity", "1");
            });
        }

        function pagingViewListLoad(parm,parm2){
            var bln = $('#ddBulan').val();
            var thn = $('#ddTahun').val();
            loadDataPengantar(bln,thn,parm,parm2);
        }

        function loadDefaultPengantarBPKAD(){
            loadDataPengantar('0','0','','');
        }

    });
</script>