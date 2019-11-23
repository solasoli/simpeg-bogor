<ul class="tabs-expand-md" data-role="tabs" style="font-size: small;font-weight: bold;">
    <li id="tbStafAktual" class="active"><a href="#tab1">Daftar Staf Aktual</a></li>
    <li id="tbHistStaf"><a href="#tab2">Riwayat Staf eKinerja</a></li>
    <li id="tbHistPlh"><a href="#tab3">Riwayat Staf PLH</a></li>
</ul>

<?php //echo $this->session->userdata('id_pegawai_enc'); ?>

<div class="border bd-default no-border-top p-2">
    <div id="tab1">
        <div style="overflow-x: auto;">
        <?php if (isset($staf_aktual) and sizeof($staf_aktual) > 0 and $staf_aktual != ''): ?>
            <?php $i = 1; ?>
            <table class="table table-border row-hover cell-border compact">
                <thead>
                <tr>
                    <th>No</th>
                    <th>Uraian</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach($staf_aktual as $lsdata){ ?>
                    <tr>
                        <td style="vertical-align: top; text-align: center;"><?php echo $i; ?></td>
                        <td><?php echo '<span style="color: saddlebrown; font-weight: bold;">'.$lsdata->nama.'</span><br>'.$lsdata->nip_baru.'<br>Golongan '.$lsdata->pangkat_gol;?><br>
                            <?php echo $lsdata->jabatan.' ('.$lsdata->jenjab.')'; ?>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><span style="color: blue">eKinerja bulan ini:
                            <?php if($lsdata->ekinerja_current=='Belum'): ?>
                                Belum Ada<br>
                                <button onclick="riwayat_ekinerja_staf('<?php echo $lsdata->id_pegawai_enc; ?>')" type="button" class="button primary bg-grayBlue small drop-shadow" style="margin-bottom: 5px;"><span class="mif-file-text icon"></span> Riwayat eKinerja</button>
                            <?php else: ?>
                                <?php echo $lsdata->ekinerja_current; ?> </span><br>Status : <?php echo $lsdata->status_knj;?> <br>Kalkulasi Nilai : <?php echo ($lsdata->kalkulasi==''?'Belum pernah':$lsdata->kalkulasi); ?><br>
                                <button onclick="rekapitulasi_staf('<?php echo $lsdata->id_knj_master_enc; ?>');" type="button" class="button primary bg-darkBlue small drop-shadow" style="margin-bottom: 5px;"><span class="mif-file-text icon"></span> Rekapitulasi</button>
                                <button onclick="peninjauan_aktifitas_staf('<?php echo $lsdata->id_knj_master_enc; ?>');" type="button" class="button primary bg-darkOrange small drop-shadow" style="margin-bottom: 5px;"><span class="mif-file-text icon"></span> Lihat Aktifitas</button>
                                <button onclick="riwayat_ekinerja_staf('<?php echo $lsdata->id_pegawai_enc; ?>')" type="button" class="button primary bg-grayBlue small drop-shadow" style="margin-bottom: 5px;"><span class="mif-file-text icon"></span> Riwayat eKinerja</button>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php
                    $i++;
                } ?>
                </tbody>
            </table>
        <?php else: ?>
        Data tidak ditemukan
        <?php endif; ?>
        </div>
    </div>
    <div id="tab2">
        <?php if (isset($staf_ekinerja) and sizeof($staf_ekinerja) > 0 and $staf_ekinerja != ''): ?>
        <?php $i = 1; ?>
        <table class="table table-border row-hover cell-border compact">
            <thead>
            <tr>
                <th>No</th>
                <th>Uraian</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach($staf_ekinerja as $lsdata2){ ?>
            <tr>
                <td style="vertical-align: top; text-align: center;"><?php echo $i; ?></td>
                <td>
                    <?php echo '<span style="color: saddlebrown; font-weight: bold;">'.$lsdata2->nama.'</span><br>'.$lsdata2->nip_baru.'<br>Golongan '.$lsdata2->pangkat_gol;?><br>
                    <?php echo $lsdata2->jabatan.' ('.$lsdata2->jenjab.')'; ?>
                </td>
            </tr>
                <tr>
                    <td></td>
                    <td>
                            <span style="color: blue">Laporan eKinerja terakhir : </span><br>
                        <?php if($lsdata2->periode==''): ?>Belum Ada
                        <?php else: ?>
                        Periode <?php echo $this->umum->monthName($lsdata2->periode_bln).' ',$lsdata2->periode_thn; ?>. Status
                        <?php echo $lsdata2->status_knj; ?>. <br><?php echo ($lsdata2->flag_kalkulasi==0?'Belum kalkulasi nilai':'Sudah kalkulasi nilai pada '.$lsdata2->tgl_update_kalkulasi); ?>.<br>
                            <button onclick="riwayat_ekinerja_staf('<?php echo $lsdata2->id_pegawai_enc; ?>')" type="button" class="button primary bg-grayBlue small drop-shadow" style="margin-bottom: 5px;"><span class="mif-file-text icon"></span> Riwayat eKinerja</button>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php
                    $i++;
                } ?>
            </tbody>
        </table>
        <?php else: ?>
            Data tidak ditemukan
        <?php endif; ?>
    </div>
    <div id="tab3">
        <?php if (isset($staf_plh) and sizeof($staf_plh) > 0 and $staf_plh != ''): ?>
        <?php $i = 1; ?>
        <table class="table table-border row-hover cell-border compact">
            <thead>
            <tr>
                <th>No</th>
                <th>Uraian</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach($staf_plh as $lsdata3){ ?>
                <tr>
                    <td style="vertical-align: top; text-align: center;"><?php echo $i; ?></td>
                    <td>
                        <?php echo '<span style="color: saddlebrown; font-weight: bold;">'.$lsdata3->nama.'</span><br>'.$lsdata3->nip_baru.'<br>Golongan '.$lsdata3->pangkat_gol;?><br>
                        <?php echo $lsdata3->jabatan.' ('.$lsdata3->jenjab.')'; ?>
                    </td>
                </tr>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <span style="color: blue">Laporan eKinerja terakhir sesuai atasan Plh: </span><br>
                        <?php if($lsdata3->periode_bln==''): ?>Belum Ada
                        <?php else: ?>
                            Periode <?php echo $lsdata3->periode_bln.' ',$lsdata3->periode_thn; ?>. Status
                            <?php echo $lsdata3->status_knj; ?>. <br><?php echo ($lsdata3->flag_kalkulasi==0?'Belum kalkulasi nilai':'Sudah kalkulasi nilai pada '.$lsdata3->tgl_update_kalkulasi); ?>.<br>
                            <button onclick="riwayat_ekinerja_staf_plh('<?php echo $lsdata3->id_pegawai_enc; ?>')" type="button" class="button primary bg-grayBlue small drop-shadow" style="margin-bottom: 5px;"><span class="mif-file-text icon"></span> Riwayat eKinerja sesuai atasan Plh</button>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php
                $i++;
            } ?>
            </tbody>
        </table>
        <?php else: ?>
            Data tidak ditemukan
        <?php endif; ?>
    </div>
</div>

<script>
    function peninjauan_aktifitas_staf(id_knj_master){
        location.href = "<?php echo base_url().$usr."/peninjauan_staf_detail_kegiatan?idknjm=" ?>" + id_knj_master;
    }

    function riwayat_ekinerja_staf(id_pegawai){
        location.href = "<?php echo base_url().$usr."/riwayat_ekinerja_staf?idp=" ?>" + id_pegawai;
    }

    function rekapitulasi_staf(id_knj_master){
        location.href = "<?php echo base_url().$usr."/detail_laporan_kinerja_staf?idknjm=" ?>" + id_knj_master;
    }

    function riwayat_ekinerja_staf_plh(id_pegawai){
        location.href = "<?php echo base_url().$usr."/riwayat_ekinerja_staf_plh?idp=" ?>" + id_pegawai;
    }
</script>