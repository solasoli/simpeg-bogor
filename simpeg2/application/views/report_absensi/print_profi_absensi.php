<div class="panel">
    <div class="panel-header">Rekap Absensi Semua OPD</div>
    <div class="panel-content">
        <table class="table bordered striped" id="lst_data">
            <thead style="border-bottom: solid #a4c400 2px;">
            <tr>
                <th style="width: 20px;border-top: 1px solid rgba(111, 111, 111, 0.79);border-left: 1px solid rgba(111, 111, 111, 0.79);" td rowspan="2">No</th>
                <th style="border-top: 1px solid rgba(111, 111, 111, 0.79);border-right: 1px solid rgba(111, 111, 111, 0.79);" rowspan="2">OPD</th>
                <th style="border-top: 1px solid rgba(111, 111, 111, 0.79);" rowspan="2">Jumlah Pegawai</th>
                <th style="border-top: 1px solid rgba(111, 111, 111, 0.79);border-right: 1px solid rgba(111, 111, 111, 0.79)" rowspan="2">Jumlah Hari Kerja</th>
                <th style="border-top: 1px solid rgba(111, 111, 111, 0.79);border-right: 1px solid rgba(111, 111, 111, 0.79);border-bottom: 1px solid rgba(111, 111, 111, 0.79)" colspan="4">Ketidakhadiran</th>
                <th style="border-top: 1px solid rgba(111, 111, 111, 0.79);border-right: 1px solid rgba(111, 111, 111, 0.79);border-bottom: 1px solid rgba(111, 111, 111, 0.79)" colspan="4">Kehadiran</th>
                <th style="border-top: 1px solid rgba(111, 111, 111, 0.79);border-right: 1px solid rgba(111, 111, 111, 0.79);border-bottom: 1px solid rgba(111, 111, 111, 0.79)" colspan="2">C</th>
                <th style="border-top: 1px solid rgba(111, 111, 111, 0.79);border-right: 1px solid rgba(111, 111, 111, 0.79);border-bottom: 1px solid rgba(111, 111, 111, 0.79)" colspan="2">DL</th>
                <th style="border-top: 1px solid rgba(111, 111, 111, 0.79);border-right: 1px solid rgba(111, 111, 111, 0.79);border-bottom: 1px solid rgba(111, 111, 111, 0.79)" colspan="2">DI</th>
                <th style="border-top: 1px solid rgba(111, 111, 111, 0.79);border-right: 1px solid rgba(111, 111, 111, 0.79);border-bottom: 1px solid rgba(111, 111, 111, 0.79)" colspan="2">I</th>
                <th style="border-top: 1px solid rgba(111, 111, 111, 0.79);border-right: 1px solid rgba(111, 111, 111, 0.79);border-bottom: 1px solid rgba(111, 111, 111, 0.79)" colspan="2">S</th>
                <th style="border-top: 1px solid rgba(111, 111, 111, 0.79);border-right: 1px solid rgba(111, 111, 111, 0.79);border-bottom: 1px solid rgba(111, 111, 111, 0.79)" colspan="2">TK</th>
            </tr>
            <tr>
                <th>Pegawai</th>
                <th>Persentase</th>
                <th>Hari</th>
                <th style="border-right: 1px solid rgba(111, 111, 111, 0.79)">Persentase</th>
                <th>Pegawai</th>
                <th>Persentase</th>
                <th>Hari</th>
                <th style="border-right: 1px solid rgba(111, 111, 111, 0.79);">Persentase</th>
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
                            <td style="border-bottom: solid #666666 1px;text-align: center"><?php echo $lsdata->jml_pegawai_absen ?></td>
                            <td style="border-bottom: solid #666666 1px;text-align: center"><?php echo $lsdata->persen_jml_pegawai_absen ?> %</td>
                            <td style="border-bottom: solid #666666 1px;text-align: center"><?php echo $lsdata->jml_hari_absen; ?></td>
                            <td style="border-bottom: solid #666666 1px;text-align: center;border-right: 1px solid rgba(111, 111, 111, 0.79)"><?php echo $lsdata->persen_jml_hari_absen ?> %</td>
                            <td style="border-bottom: solid #666666 1px;text-align: center"><?php echo $lsdata->jml_pegawai_hadir ?></td>
                            <td style="border-bottom: solid #666666 1px;text-align: center"><?php echo $lsdata->persen_jml_pegawai_hadir ?> %</td>
                            <td style="border-bottom: solid #666666 1px;text-align: center"><?php echo $lsdata->jml_hari_hadir ?></td>
                            <td style="border-bottom: solid #666666 1px;text-align: center;border-right: 1px solid rgba(111, 111, 111, 0.79);"><?php echo $lsdata->persen_jml_hari_hadir ?> %</td>
                            <td style="border-bottom: solid #666666 1px;text-align: center"><?php echo $lsdata->org_C ?></td>
                            <td style="border-bottom: solid #666666 1px;text-align: center;border-right: 1px solid rgba(111, 111, 111, 0.79);"><?php echo $lsdata->hari_C ?></td>
                            <td style="border-bottom: solid #666666 1px;text-align: center"><?php echo $lsdata->org_DL ?></td>
                            <td style="border-bottom: solid #666666 1px;text-align: center;border-right: 1px solid rgba(111, 111, 111, 0.79);"><?php echo $lsdata->hari_DL ?></td>
                            <td style="border-bottom: solid #666666 1px;text-align: center"><?php echo $lsdata->org_DI ?></td>
                            <td style="border-bottom: solid #666666 1px;text-align: center;border-right: 1px solid rgba(111, 111, 111, 0.79);"><?php echo $lsdata->hari_DI ?></td>
                            <td style="border-bottom: solid #666666 1px;text-align: center"><?php echo $lsdata->org_I ?></td>
                            <td style="border-bottom: solid #666666 1px;text-align: center;border-right: 1px solid rgba(111, 111, 111, 0.79);"><?php echo $lsdata->hari_I ?></td>
                            <td style="border-bottom: solid #666666 1px;text-align: center"><?php echo $lsdata->org_S ?></td>
                            <td style="border-bottom: solid #666666 1px;text-align: center;border-right: 1px solid rgba(111, 111, 111, 0.79);"><?php echo $lsdata->hari_S ?></td>
                            <td style="border-bottom: solid #666666 1px;text-align: center"><?php echo $lsdata->org_TK ?></td>
                            <td style="border-bottom: solid #666666 1px;text-align: center;border-right: 1px solid rgba(111, 111, 111, 0.79);"><?php echo $lsdata->hari_TK ?></td>
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