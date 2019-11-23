Daftar Laporan Kinerja berds. Periode :
<?php if (isset($data_list) and sizeof($data_list) > 0 and $data_list != ''){ ?>
    <?php $j = 1; ?>
    <table class="table table-border cell-border compact">
        <tbody>
        <?php foreach ($data_list as $lsdata): ?>

            <tr style="background-color: rgba(205,205,208,0.35)">
                <th>#</th>
                <th>Periode</th>
                <th>Tgl.Input</th>
                <th>Status</th>
            </tr>
            <tr>
                <td><?php echo $j; ?>.</td>
                <td style="text-align: center"><?php echo $this->umum->monthName($lsdata->periode_bln).' '.$lsdata->periode_thn; ?></td>
                <td><?php echo $lsdata->tgl_input_kinerja; ?></td>
                <td><?php echo $lsdata->status_knj; ?></td>
            </tr>
            <tr>
                <td></td>
                <td colspan="5">
                    <strong>Unit Kerja Terakhir:</strong><br>
                    <span style="font-size: small"><?php echo $lsdata->last_unit_kerja; ?><br>
                    Atasan : <?php echo $lsdata->last_atsl_nama; ?><br>
                    <span><?php echo $lsdata->last_atsl_jabatan; ?></span><br>
                    Pejabat : <?php echo ($lsdata->last_pjbt_nama==''?'-':$lsdata->last_pjbt_nama); ?><br>
                        <span><?php echo $lsdata->last_pjbt_jabatan; ?></span></span><br>
                    <?php //echo '<br>'.$lsdata->id_knj_master; ?>
                    <button onclick="detail_laporan_kinerja('<?php echo $lsdata->id_knj_master; ?>')" type="button" class="button primary bg-darkBlue drop-shadow small"><span class="mif-file-text icon"></span> Detail</button>
                    <button onclick="hapus_kinerja_master('<?php echo $lsdata->id_knj_master; ?>')" type="button" class="button alert bg-darkRed drop-shadow small"><span class="mif-bin icon"></span> Hapus</button>
                    <?php if($this->umum->monthName($lsdata->periode_bln).' '.$lsdata->periode_thn == 'Juli 2019'): ?>
                        <button onclick="input_aktifitas_lampau('<?php echo $lsdata->id_knj_master; ?>')" type="button" class="button alert bg-darkBrown drop-shadow small"><span class="mif-bin icon"></span> Input Aktifitas</button>
                    <?php endif; ?>
                    <br><div style="font-weight: bold; margin-top: 10px;">Riwayat Atasan Langsung:</div>
                    <?php
                    $data_at = $this->ekinerja->data_ref_list_hist_alih_tugas_by_idknj($lsdata->id_knj_master);
                    if (isset($data_at) and sizeof($data_at) > 0 and $data_at != ''){
                        $b = 1;
                        foreach ($data_at as $lsdata2){ ?>
                            <?php //print_r($lsdata2); ?>
                            <div class="row">
                                <div class="cell-11" style="font-size: small">
                                    <span style="color: mediumblue"> <?php echo $b.') '; ?>
                                        Jabatan : (<?php echo $lsdata2->kode_jabatan;?>) <?php echo $lsdata2->jabatan; ?><br>
                                        Kelas : <?php echo $lsdata2->kelas_jabatan.' ('.$lsdata2->nilai_jabatan.')';?>. Tunjangan <?php echo($lsdata->status_pegawai=='CPNS'?' 80%':''); ?>: Rp. <?php echo number_format($lsdata2->rupiah_awal_tkd,0,",",".") ?><br>
                                        Unit Kerja : <?php echo $lsdata2->unit_kerja;?><br>
                                        TMT. Kinerja : <?php echo $lsdata2->tmt;?>. Tgl. Input : <?php echo $lsdata2->tgl_input;?>
                                        <button onclick="hapus_alih_tugas('<?php echo $lsdata2->id_knj_master; ?>','<?php echo $lsdata2->idknj_hist_alih_tugas; ?>')" type="button" class="button alert bg-darkRed drop-shadow mini rounded">
                                            <span class="mif-bin icon"></span>Hapus</button>
                                    </span><br>
                                    Atasan : <?php echo $lsdata2->atsl_nama.' ('.$lsdata2->atsl_jabatan.')';?><br>
                                    <?php
                                        if($lsdata2->atsl_nama_plh<>''){
                                           echo 'Plh. Atasan Langsung : '.$lsdata2->atsl_nama_plh.' ('.$lsdata2->atsl_jabatan_plh.')<br>';
                                        }
                                    ?>
                                    Pejabat : <?php echo ($lsdata2->pjbt_nama==''?'-':$lsdata2->pjbt_nama).($lsdata2->pjbt_nama==''?'':' ('.$lsdata2->pjbt_jabatan.')');?><br>
                                    <span style="color: indianred;">Jumlah Kegiatan : <?php echo $lsdata2->jml_aktifitas;?> aktifitas</span>
                                </div>
                            </div>
                            <?php
                            $b++;
                        }
                    }else{
                        echo "Belum ada data";
                    }
                    ?>
                </td>
            </tr>
            <?php
            $j++;
        endforeach; ?>
        </tbody>
    </table>
<?php }else{ ?>
    <br> Belum ada data
<?php } ?>

<script>

    function hapus_kinerja_master(id){
        $.confirm({
            title: 'Informasi',
            closeIconClass: 'fa fa-close',
            closeIcon: null,
            closeIconClass: false,
            useBootstrap: false,
            content: 'Anda yakin akan menghapus data laporan ekinerja ini?',
            buttons: {
                cancel: {
                    text: 'Tidak',
                    action: function () {
                        return true;
                    }
                },
                somethingElse: {
                    text: 'Ya',
                    btnClass: 'btn-blue',
                    keys: ['enter', 'shift'],
                    action: function(){
                        $.confirm({
                            title: 'Peringatan',
                            closeIconClass: 'fa fa-close',
                            closeIcon: null,
                            closeIconClass: false,
                            useBootstrap: false,
                            content: 'Menghapus data laporan, berarti menghapus semua data riwayat alih tugas beserta data aktifitas kegiatannya, yakin akan melanjutkan?',
                            type: 'orange',
                            icon: 'mif-warning icon',
                            buttons: {
                                cancel: {
                                    text: 'Tidak',
                                    action: function () {
                                        return true;
                                    }
                                },
                                somethingElse: {
                                    text: 'Ya',
                                    btnClass: 'btn-red',
                                    keys: ['enter', 'shift'],
                                    action: function(){
                                        var result;
                                        $.post('<?php echo $api_hapus; ?>', { id_knj_master:id }, function(data){
                                            $(JSON.parse(data)).each(function() {
                                                result = this.code;
                                            });
                                            if(result == 200){
                                                $.alert({
                                                    title: 'Informasi',
                                                    type: 'green',
                                                    closeIconClass: 'fa fa-close',
                                                    closeIcon: null,
                                                    closeIconClass: false,
                                                    useBootstrap: false,
                                                    content: 'Sukses menghapus data'
                                                });
                                                location.href = "<?php echo $url_reload ?>";
                                            }else{
                                                $.alert({
                                                    closeIconClass: 'fa fa-close',
                                                    closeIcon: null,
                                                    closeIconClass: false,
                                                    useBootstrap: false,
                                                    content: 'Gagal menghapus data',
                                                    type: 'red'
                                                });
                                            }
                                        });
                                    }
                                }
                            }
                        });
                    }
                }
            }
        });
    }

    function detail_laporan_kinerja(id){
        location.href = "<?php echo base_url().$usr."/detail_laporan_kinerja?idknjm=" ?>" + id;
    }

    function hapus_alih_tugas(id_knj_master, idknj_hist_alih_tugas){
        $.confirm({
            title: 'Informasi',
            closeIconClass: 'fa fa-close',
            closeIcon: null,
            closeIconClass: false,
            useBootstrap: false,
            content: 'Anda yakin akan menghapus data riwayat alih tugas ini?',
            buttons: {
                cancel: {
                    text: 'Tidak',
                    action: function () {
                        return true;
                    }
                },
                somethingElse: {
                    text: 'Ya',
                    btnClass: 'btn-blue',
                    keys: ['enter', 'shift'],
                    action: function(){
                        $.confirm({
                            title: 'Peringatan',
                            closeIconClass: 'fa fa-close',
                            closeIcon: null,
                            closeIconClass: false,
                            useBootstrap: false,
                            content: 'Menghapus data riwayat alih tugas, berarti menghapus semua data aktifitas kegiatannya, yakin akan melanjutkan?',
                            type: 'orange',
                            icon: 'mif-warning icon',
                            buttons: {
                                cancel: {
                                    text: 'Tidak',
                                    action: function () {
                                        return true;
                                    }
                                },
                                somethingElse: {
                                    text: 'Ya',
                                    btnClass: 'btn-red',
                                    keys: ['enter', 'shift'],
                                    action: function(){
                                        var result;
                                        $.post('<?php echo $api_hapus_alih_tugas; ?>', { id_knj_master:id_knj_master, idknj_hist_alih_tugas:idknj_hist_alih_tugas }, function(data){
                                            $(JSON.parse(data)).each(function() {
                                                result = this.code;
                                            });
                                            if(result == 200){
                                                $.alert({
                                                    title: 'Informasi',
                                                    type: 'green',
                                                    closeIconClass: 'fa fa-close',
                                                    closeIcon: null,
                                                    closeIconClass: false,
                                                    useBootstrap: false,
                                                    content: 'Sukses menghapus data'
                                                });
                                                location.href = "<?php echo $url_reload ?>";
                                            }else{
                                                $.alert({
                                                    closeIconClass: 'fa fa-close',
                                                    closeIcon: null,
                                                    closeIconClass: false,
                                                    useBootstrap: false,
                                                    content: 'Gagal menghapus data',
                                                    type: 'red'
                                                });
                                            }
                                        });
                                    }
                                }
                            }
                        });
                    }
                }
            }
        });
    }

    function input_aktifitas_lampau(id){
        location.href = "<?php echo base_url().$usr."/input_laporan_kinerja?idknjm=" ?>" + id;
    }

</script>
