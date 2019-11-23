<?php if (isset($drop_data_list) and sizeof($drop_data_list) > 0 and $drop_data_list != ''){ ?>
    <?php if(isset($pgDisplay)): ?>
        <?php if($numpage > 0): ?>
            <div class="row" style="margin-top: 20px;">
                <div class="cell-sm-4">
                    Halaman ke <?php echo $curpage; ?> dari <?php echo $numpage; ?> | Jumlah : <?php echo $jmlData; ?>
                </div>
            </div>
            <?php echo $pgDisplay; ?>
        <?php endif; ?>
    <?php endif; ?>

    <div id="dvAllListAktifitasPlh">
        <table id="tblAktifitasPlh" class="table row-hover row-border compact"
               style="margin-bottom: 0px;border-bottom: 1px solid rgba(71,71,72,0.35); margin-top: 10px;">
            <thead>
            <tr>
                <th style="text-align: center;">Uraian Aktifitas</th>
            </tr>
            </thead>
            <tbody>
            <?php $i = 1; ?>
            <?php foreach ($drop_data_list as $lsdata): ?>
                <?php //print_r($lsdata); ?>
                <tr>
                    <td>
                        <div id="dvListActPlh<?php echo $lsdata->id_knj_kegiatan;?>">
                            <?php if($id_status_knj==1 or $id_status_knj==2 or $id_status_knj==5): ?>
                                <input id="chkAktifitasPlh<?php echo $lsdata->id_knj_kegiatan;?>" name="chkAktifitasPlh[]" type="checkbox" class="css-checkbox lrg"
                                       value="<?php echo $lsdata->id_knj_kegiatan_enc;?>">
                                <label for="chkAktifitasPlh<?php echo $lsdata->id_knj_kegiatan;?>" name="chkAktifitas_lbl_plh" class="css-label lrg vlad"></label>
                            <?php endif; ?>
                            <span style="color: saddlebrown; font-weight: bold;">
                                        <?php echo $lsdata->no_urut.') '.$lsdata->kegiatan_rincian; ?>
                                </span>
                            <br>
                            <?php //echo 'TES '.$this->session->userdata('nip').'-'.$lsdata->atsl_nip; ?>
                            <?php echo 'Keterangan: ' . $lsdata->kegiatan_keterangan; ?><br>
                            <span style="color: rosybrown"><?php echo 'SKP: ' . $lsdata->uraian_tugas; ?></span>
                            <br>
                            <?php echo 'Waktu: '.$lsdata->tgl_kegiatan; ?>.
                            Durasi: <?php echo $lsdata->durasi_menit; ?> menit <br>Output:
                            <?php echo $lsdata->kuantitas.' '.$lsdata->satuan; ?><br>
                            <?php if ($lsdata->approved == '') { ?>
                                <span class="rounded_box_default">Belum diproses</span>
                            <?php } elseif ($lsdata->approved == 1) { ?>
                                <span class="rounded_box_green">Disetujui</span>
                            <?php } elseif ($lsdata->approved == 2) { ?>
                                <span class="rounded_box_orange">Revisi</span>
                            <?php } else { ?>
                                <span class="rounded_box_red">Ditolak</span>
                            <?php } ?>

                            <?php
                            if($lsdata->approved == ''){
                            }elseif ($lsdata->approved == 1 or $lsdata->approved == 2 or $lsdata->approved == 3){
                                echo '<br>Catatan Atasan: '.($lsdata->catatan_approved==''?'-':$lsdata->catatan_approved).' (Oleh: '.$lsdata->nama.' pada '.$lsdata->tgl_approved2.')';
                            }
                            ?>

                            <?php if($id_status_knj==1 or $id_status_knj==2 or $id_status_knj==5): ?>
                                <br>
                                <?php if($lsdata->approved == '' or $lsdata->approved == '0'): ?>
                                    <input value="" type="text" id="txtApprovalPlh<?php echo $lsdata->id_knj_kegiatan;?>" name="txtApprovalPlh<?php echo $lsdata->id_knj_kegiatan;?>" class="cell-sm-11" placeholder="Catatan" style="margin-bottom: -10px;"><br>
                                <?php endif; ?>
                                <?php if($lsdata->approved == ''): ?>
                                    <a href="javascript:void(0);" onclick="proses_persetujuan_aktifitas_plh(1, <?php echo $lsdata->id_knj_kegiatan;?>, '<?php echo $lsdata->id_knj_kegiatan_enc;?>', <?php echo $lsdata->no_urut; ?>);"><span class="mif-checkmark icon"></span> Disetujui</a> &nbsp;
                                    <a href="javascript:void(0);" onclick="proses_persetujuan_aktifitas_plh(2, <?php echo $lsdata->id_knj_kegiatan;?>, '<?php echo $lsdata->id_knj_kegiatan_enc;?>', <?php echo $lsdata->no_urut; ?>);"><span class="mif-pencil icon"></span> Revisi</a> &nbsp;
                                    <a href="javascript:void(0);" onclick="proses_persetujuan_aktifitas_plh(3, <?php echo $lsdata->id_knj_kegiatan;?>, '<?php echo $lsdata->id_knj_kegiatan_enc;?>', <?php echo $lsdata->no_urut; ?>);"><span class="mif-cross icon"></span> Ditolak</a>
                                <?php else: ?>
                                    <a href="javascript:void(0);" onclick="proses_persetujuan_aktifitas_plh(0, <?php echo $lsdata->id_knj_kegiatan;?>, '<?php echo $lsdata->id_knj_kegiatan_enc;?>', <?php echo $lsdata->no_urut; ?>);"><span class="mif-cancel icon"></span> Batalkan Pemrosesan</a>
                                <?php endif; ?>
                            <?php endif; ?>

                            <?php if($lsdata->url_berkas_eviden!=''){ ?>
                                &nbsp;<a href="javascript:void(0)" onclick="get_berkas_plh('<?php echo $lsdata->url_berkas_eviden; ?>')"><span class="mif-download icon"></span> Download</a>
                            <?php } ?>
                        </div>
                    </td>
                </tr>
                <?php $i++; ?>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>


<?php }else{
    echo 'Data tidak ditemukan';
} ?>

<script>
    function get_berkas_plh(berkas){
        window.open('/ekinerja2/berkas/'+berkas, '_blank');
    }

    $("#chkCheckAllPlh").change(function () {
        $("#dvAllListAktifitasPlh input:checkbox").prop('checked', $(this).prop("checked"));
    });

    function refresh_table(){
        var table = $('#tblAktifitasPlh').data('table');
        table.draw(true);
    }

    function proses_persetujuan_aktifitas_plh(idstatus, id_knj_kegiatan, id_knj_kegiatan_enc, no_urut){
        $.confirm({
            title: 'Informasi',
            closeIconClass: 'fa fa-close',
            closeIcon: null,
            closeIconClass: false,
            useBootstrap: false,
            content: 'Anda yakin akan mengubah status aktifitas ini?',
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
                        $.alert({
                            closeIconClass: 'fa fa-close',
                            closeIcon: null,
                            closeIconClass: false,
                            useBootstrap: false,
                            content: function () {
                                var self = this;
                                var data = new FormData();
                                var ket_approval = $('#txtApprovalPlh'+id_knj_kegiatan).val();
                                data.append('id_knj_kegiatan', id_knj_kegiatan);
                                data.append('idstatus', idstatus);
                                data.append('ket_approval', ket_approval);
                                data.append('id_knj_kegiatan_enc', id_knj_kegiatan_enc);
                                data.append('id_pegawai_enc', '<?php echo $this->session->userdata('id_pegawai_enc'); ?>');
                                return $.ajax({
                                    url: "<?php echo base_url($usr)."/proses_persetujuan_aktifitas/";?>",
                                    data: data,
                                    cache: false,
                                    contentType: false,
                                    processData: false,
                                    method: 'POST',
                                }).done(function (data) {
                                    self.setTitle('Informasi');
                                    if(data==1){
                                        self.setType('green');
                                        self.setContent('Berhasil memproses aktifitas');
                                    }else{
                                        self.setType('red');
                                        self.setContent('Maaf tidak Berhasil memproses aktifitas');
                                    }
                                }).fail(function(){
                                    self.setContent('Error...telah terjadi kesalahan');
                                });
                            },
                            onContentReady: function () {},
                            buttons: {
                                refreshList: {
                                    text: 'OK',
                                    btnClass: 'btn-blue',
                                    action: function () {
                                        var data2 = new FormData();
                                        data2.append('id_knj_kegiatan_enc', id_knj_kegiatan_enc);
                                        data2.append('no_urut', no_urut);
                                        return $.ajax({
                                            url: "<?php echo base_url($usr)."/get_aktifitas_by_id_plh/";?>",
                                            data: data2,
                                            cache: false,
                                            contentType: false,
                                            processData: false,
                                            method: 'POST',
                                        }).done(function (data) {
                                            $("#dvListActPlh" + id_knj_kegiatan).html(data);
                                            $("#dvListActPlh" + id_knj_kegiatan).css("pointer-events", "auto");
                                            $("#dvListActPlh" + id_knj_kegiatan).css("opacity", "1");
                                            $("#dvListActPlh" + id_knj_kegiatan).find("script").each(function(i) {
                                                eval($(this).text());
                                            });
                                        }).fail(function(){
                                            self.setContent('Error...telah terjadi kesalahan');
                                        });
                                    }
                                },
                            }
                        });
                    }
                }
            }
        });
    }

</script>