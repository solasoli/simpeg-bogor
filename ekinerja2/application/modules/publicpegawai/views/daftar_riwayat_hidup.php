<div class="panel-content" data-role="panel"
     data-title-caption="<strong>I. KETERANGAN PERORANGAN</strong>"
     data-title-icon=""
     data-cls-title=" fg-black">
    <?php if (isset($biodata) and sizeof($biodata) > 0 and $biodata != ''):?>
        <?php foreach ($biodata as $biodata): ?>
            <table class="table row-hover row-border compact" style="margin-bottom: 0px;">
                <tr>
                    <td colspan="4" style="text-align: center;">
                        <?php
                            if (file_exists($_SERVER['DOCUMENT_ROOT']."/simpeg/foto/".$this->session->userdata('id_pegawai').'.jpg')) {
                                $nmfile = $this->session->userdata('id_pegawai');
                            }else{
                                $nmfile = 'nophoto';
                            }
                        ?>
                        <img src='../../../../simpeg/foto/<?php echo $nmfile;?>.jpg' style="width:135px;height: 175px;" /><br><br>
                    </td>
                </tr>
                <tr><td>1)</td><td> Nama Lengkap</td><td>:</td><td><?php echo $biodata->nama; ?></td></tr>
                <tr><td>2)</td><td> NIP</td><td>:</td><td><?php echo $biodata->nip_baru; ?></td></tr>
                <tr><td>3)</td><td> Pangkat/Gol</td><td>:</td><td><?php echo $biodata->pangkat; ?> - <?php echo $biodata->golongan; ?></td></tr>
                <tr><td>4)</td><td> Tempat/Tgl. Lahir</td><td>:</td><td><?php echo $biodata->tempat_lahir; ?> - <?php echo $biodata->tgl_lahir; ?></td></tr>
                <tr><td>5)</td><td> Jenis Kelamin</td><td>:</td><td><?php echo $biodata->jenis_kelamin; ?></td></tr>
                <tr><td>6)</td><td> Agama</td><td>:</td><td><?php echo $biodata->agama; ?></td></tr>
                <tr><td>7)</td><td> Alamat Rumah</td><td>:</td><td><?php echo $biodata->alamat; ?></td></tr>
                <tr><td>8)</td><td> Kota</td><td>:</td><td><?php echo $biodata->kota; ?></td></tr>
                <tr><td>9)</td><td> Jabatan</td><td>:</td><td><?php echo $biodata->jabatan; ?> (<?php echo $biodata->kode_jabatan; ?>)</td></tr>
                <tr><td>10)</td><td> Unit Kerja</td><td>:</td><td><?php echo $biodata->unit; ?></td></tr>
            </table>
        <?php endforeach; ?>
    <?php else: ?>
        Data tidak ditemukan
    <?php endif;?>
</div>
<br>
<div class="panel-content" data-role="panel"
     data-title-caption="<strong>II. PENDIDIKAN</strong>"
     data-title-icon=""
     data-cls-title=" fg-black">
    1) Pendidikan di Dalam dan di Luar Negeri <br>
    <?php if (isset($pendidikan) and sizeof($pendidikan) > 0 and $pendidikan != ''):?>
    <?php $i = 1; ?>
    <table class="table table-border row-hover row-border compact" style="margin-bottom: 0px;">
        <tr style="border-bottom: 1px solid rgba(71,71,72,0.35);">
            <th>No.</th>
            <th>Lembaga Pendidikan</th>
            <th>Jurusan Pendidikan</th>
            <th>Tahun Lulus</th>
            <th>Nama Pendidikan</th>
            <th>Bidang</th>
            <th>Ijazah</th>
        </tr>
        <tbody>
        <?php foreach ($pendidikan as $pendidikan): ?>
        <tr>
            <td><?php echo $i++; ?>)</td>
            <td><?php echo $pendidikan->lembaga_pendidikan; ?></td>
            <td><?php echo $pendidikan->jurusan_pendidikan; ?></td>
            <td><?php echo $pendidikan->tahun_lulus; ?></td>
            <td><?php echo $pendidikan->nama_pendidikan; ?></td>
            <td><?php echo $pendidikan->bidang; ?></td>
            <td><?php echo $pendidikan->no_ijazah; ?></td>
        </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <?php else: ?>
        Data tidak ditemukan
    <?php endif;?>
    <br>2) Kursus/Latihan di Dalam dan di Luar Negeri <br>
    <?php if (isset($diklat) and sizeof($diklat) > 0 and $diklat != ''):?>
        <?php $i = 1; ?>
        <table class="table table-border row-hover row-border compact" style="margin-bottom: 0px;">
            <tr style="border-bottom: 1px solid rgba(71,71,72,0.35);">
                <th>No.</th>
                <th>Jenis</th>
                <th>Tgl.Diklat</th>
                <th>Nama Diklat</th>
                <th>Jam</th>
                <th>Penyelenggara</th>
                <th>No.STTPL</th>
            </tr>
            <tbody>
            <?php foreach ($diklat as $diklat): ?>
                <tr>
                    <td><?php echo $i++; ?>)</td>
                    <td><?php echo $diklat->jenis_diklat; ?></td>
                    <td><?php echo $diklat->tgl_diklat; ?></td>
                    <td><?php echo $diklat->nama_diklat; ?></td>
                    <td><?php echo $diklat->jml_jam_diklat; ?></td>
                    <td><?php echo $diklat->penyelenggara_diklat; ?></td>
                    <td><?php echo $diklat->no_sttpl; ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        Data tidak ditemukan
    <?php endif;?>
</div>
<br>
<div class="panel-content" data-role="panel"
     data-title-caption="<strong>III. RIWAYAT PEKERJAAN</strong>"
     data-title-icon=""
     data-cls-title=" fg-black">
    1) Riwayat Kepangkatan golongan ruang penggajian <br>
    <?php if (isset($golongan) and sizeof($golongan) > 0 and $golongan != ''):?>
        <?php $i = 1; ?>
        <table class="table table-border row-hover row-border compact" style="margin-bottom: 0px;">
            <tr style="border-bottom: 1px solid rgba(71,71,72,0.35);">
                <th>No.</th>
                <th>SK</th>
                <th>Gol.</th>
                <th>Pangkat</th>
                <th>No.SK</th>
                <th>TMT</th>
                <th>Tgl.SK</th>
            </tr>
            <tbody>
            <?php foreach ($golongan as $golongan): ?>
                <tr>
                    <td><?php echo $i++; ?>)</td>
                    <td><?php echo $golongan->nama_sk; ?></td>
                    <td><?php echo $golongan->gol; ?></td>
                    <td><?php echo $golongan->pangkat; ?></td>
                    <td><?php echo $golongan->no_sk; ?></td>
                    <td><?php echo $golongan->tmt; ?></td>
                    <td><?php echo $golongan->tgl_sk; ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        Data tidak ditemukan
    <?php endif;?>
    <br>2) Pengalaman Jabatan / Pekerjaan <br>
    <?php if (isset($jabatan) and sizeof($jabatan) > 0 and $jabatan != ''):?>
        <?php $i = 1; ?>
        <table class="table table-border row-hover row-border compact" style="margin-bottom: 0px;">
            <tr style="border-bottom: 1px solid rgba(71,71,72,0.35);">
                <th>No.</th>
                <th>Jenis</th>
                <th>Jabatan</th>
                <th>No.SK</th>
                <th>TMT</th>
            </tr>
            <tbody>
            <?php foreach ($jabatan as $jabatan): ?>
                <tr>
                    <td><?php echo $i++; ?>)</td>
                    <td><?php echo $jabatan->jenis; ?></td>
                    <td><?php echo $jabatan->nama_jabatan; ?></td>
                    <td><?php echo $jabatan->no_sk; ?></td>
                    <td><?php echo $jabatan->tmt; ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        Data tidak ditemukan
    <?php endif;?>
</div>
<br>
<div class="panel-content" data-role="panel"
     data-title-caption="<strong>IV. KETERANGAN KELUARGA</strong>"
     data-title-icon=""
     data-cls-title=" fg-black">
    1) Istri/Suami <br>
    <?php if (isset($istri_suami) and sizeof($istri_suami) > 0 and $istri_suami != ''):?>
        <?php $i = 1; ?>
        <table class="table table-border row-hover row-border compact" style="margin-bottom: 0px;">
            <tr style="border-bottom: 1px solid rgba(71,71,72,0.35);">
                <th>No.</th>
                <th>Nama</th>
                <th>Tempat Lahir</th>
                <th>Tgl.Lahir</th>
                <th>Tgl.Menikah</th>
                <th>Pekerjaan</th>
            </tr>
            <tbody>
            <?php foreach ($istri_suami as $istri_suami): ?>
                <tr>
                    <td><?php echo $i++; ?>)</td>
                    <td><?php echo $istri_suami->nama; ?></td>
                    <td><?php echo $istri_suami->tempat_lahir; ?></td>
                    <td><?php echo $istri_suami->tgl_lahir; ?></td>
                    <td><?php echo $istri_suami->tgl_menikah; ?></td>
                    <td><?php echo $istri_suami->pekerjaan; ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        Data tidak ditemukan
    <?php endif;?>
    <br>2) Anak <br>
    <?php if (isset($anak) and sizeof($anak) > 0 and $anak != ''):?>
        <?php $i = 1; ?>
        <table class="table table-border row-hover row-border compact" style="margin-bottom: 0px;">
            <tr style="border-bottom: 1px solid rgba(71,71,72,0.35);">
                <th>No.</th>
                <th>Nama</th>
                <th>Jns.Kelamin</th>
                <th>Tempat Lahir</th>
                <th>Tgl.Lahir</th>
                <th>Pekerjaan</th>
            </tr>
            <tbody>
            <?php foreach ($anak as $anak): ?>
                <tr>
                    <td><?php echo $i++; ?>)</td>
                    <td><?php echo $anak->nama; ?></td>
                    <td><?php echo $anak->jk; ?></td>
                    <td><?php echo $anak->tempat_lahir; ?></td>
                    <td><?php echo $anak->tgl_lahir; ?></td>
                    <td><?php echo $anak->pekerjaan; ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        Data tidak ditemukan
    <?php endif;?>
</div>
<br>
<div class="panel-content" data-role="panel"
     data-title-caption="<strong>V. KETERANGAN ALIH TUGAS</strong>"
     data-title-icon=""
     data-cls-title=" fg-black">
    <?php if (isset($alih_tugas) and sizeof($alih_tugas) > 0 and $alih_tugas != ''):?>
        <?php $i = 1; ?>
        <table class="table table-border row-hover row-border compact" style="margin-bottom: 0px;">
            <tr style="border-bottom: 1px solid rgba(71,71,72,0.35);">
                <th>No.</th>
                <th>SK</th>
                <th>No.SK</th>
                <th>TMT</th>
                <th>Tgl.SK</th>
                <th>Unit</th>
            </tr>
            <tbody>
            <?php foreach ($alih_tugas as $alih_tugas): ?>
                <tr>
                    <td><?php echo $i++; ?>)</td>
                    <td><?php echo $alih_tugas->nama_sk; ?></td>
                    <td><?php echo $alih_tugas->no_sk; ?></td>
                    <td><?php echo $alih_tugas->tmt; ?></td>
                    <td><?php echo $alih_tugas->tgl_sk; ?></td>
                    <td><?php echo $alih_tugas->unit; ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        Data tidak ditemukan
    <?php endif;?>
</div>