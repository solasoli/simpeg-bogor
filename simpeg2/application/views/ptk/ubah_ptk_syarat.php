<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<script src="<?php echo base_url()?>js/jquery/jquery.validate.js"></script>
<script>
    $(function(){
        $("#frmUbahPtkSyarat").validate({
            ignore: "",
            rules: {
                tglRef: {
                    required: true
                },
                ketRef: {
                    required: true
                },
                tglBerkas:{
                    required: true
                },
                ketPengesah:{
                    required: true
                },
                ketInstitusi:{
                    required: true
                }
            },
            messages: {
                tglRef: {
                    required: "Anda belum mengisi Tanggalnya"
                },
                ketRef: {
                    required: "Anda belum mengisi Nomornya"
                },
                tglBerkas: {
                    required: "Anda belum mengisi Tanggalnya"
                },
                ketPengesah: {
                    required: "Anda belum mengisi Namanya"
                },
                ketInstitusi: {
                    required: "Anda belum mengisi Institusinya"
                }
            },
            errorPlacement: function(error, element) {
                switch (element.attr("name")) {
                    default:
                        error.insertAfter(element);
                }
            },
            submitHandler: function(form) {
                var data = new FormData();
                var tglRef = $('#tglRef').val();
                var ketRef = $('#ketRef').val();
                var tglBerkas = $('#tglBerkas').val();
                var ketPengesah = $("#ketPengesah").val();
                var id_syarat = $('#id_syarat').val();
                var ketInstitusi = $('#ketInstitusi').val();

                data.append('tglRef', tglRef);
                data.append('ketRef', ketRef);
                data.append('tglBerkas', tglBerkas);
                data.append('ketPengesah', ketPengesah);
                data.append('id_syarat', id_syarat);
                data.append('ketInstitusi', ketInstitusi);

                jQuery.ajax({
                    url: "<?php echo base_url()?>index.php/ptk/update_data_syarat_ptk",
                    data: data,
                    cache: false,
                    contentType: false,
                    processData: false,
                    type: 'POST',
                    success: function(data){
                        if(data == '1') {
                            alert('Data sukses tersimpan');
                        }else{
                            alert("Gagal mengubah data \n "+data);
                        }
                    }
                });
            }
        });
    });
</script>

<div class="container">
    <div class="grid">
        <div class="row" style="margin-top: -5px;">
            <?php if (sizeof($list_data) > 0): ?>
                <?php if($list_data!=''): ?>
                    <?php foreach ($list_data as $lsdata): ?>
                        <form action="" id="frmUbahPtkSyarat" novalidate="novalidate" enctype="multipart/form-data">
                            <input id="submitok" name="submitok" type="hidden" value="1">
                            <input type="hidden" id="id_syarat" name="id_syarat" value="<?php echo $lsdata->id_syarat; ?>">
                            <div class="span4">
                                <h4>Informasi Berkas <?php echo $nama_berkas ?></h4>
                                <div class="input-control text" id="datepicTglRef" data-week-start="1" style="margin-top: 10px;">
                                    <label>TMT. Berkas Syarat
                                        <?php
                                            /*if($lsdata->id_tipe_pengubahan_tunjangan==5 or $lsdata->id_tipe_pengubahan_tunjangan==8 or $lsdata->id_tipe_pengubahan_tunjangan==9){
                                                echo 'Kelahiran';
                                            }else {
                                                echo $lsdata->tipe_pengubahan_tunjangan;
                                            }*/
                                        ?>
                                    </label>
                                    <input type="text" id="tglRef" name="tglRef" value="<?php if(isset($lsdata->tgl_ref)) echo $lsdata->tgl_ref ?>">
                                </div>
                                <div class="input-control text" style="margin-top: 10px;">
                                    <label>Nomor Dokumen Berkas</label>
                                    <input id="ketRef" name="ketRef" type="text" value="<?php echo $lsdata->last_keterangan_reference; ?>" required>
                                </div>
                                <div class="input-control text" id="datepicTglBerkas" data-week-start="1" style="margin-top: 10px;">
                                    <label>Tanggal Pengesahan</label>
                                    <input type="text" id="tglBerkas" name="tglBerkas" value="<?php if(isset($lsdata->tgl_akte)) echo $lsdata->tgl_akte ?>">
                                </div>
                                <div class="input-control text" style="margin-top: 10px;">
                                    <label>Nama Pengesah</label>
                                    <input id="ketPengesah" name="ketPengesah" type="text" value="<?php echo $lsdata->pengesah_akte; ?>" required>
                                </div>
                                <?php if($lsdata->id_kat_berkas==3 or $lsdata->id_kat_berkas==44 or $lsdata->id_kat_berkas==48): ?>
                                    <div class="input-control text" style="margin-top: 10px;">
                                        <label>Institusi/Perusahaan</label>
                                        <input id="ketInstitusi" name="ketInstitusi" type="text" value="<?php echo $lsdata->nama_sekolah; ?>" required>
                                    </div>
                                <?php else: ?>
                                    <input type="hidden" id="ketInstitusi" name="ketInstitusi" value="-">
                                <?php endif; ?>
                                <button id="btnregister" name="new_register" type="submit" class="button success" style="height: 34px; margin-top: 20px;">
                                    <span class="icon-floppy on-left"></span><strong>Simpan</strong></button>
                            </div>
                            <div class="span7">
                                <div style="margin-top: 20px;">Pratinjau Arsip Digital</div>
                                <?php
                                if ($lsdata->id_berkas_syarat <> '' and $lsdata->id_berkas_syarat <> '0') {
                                    $cekBerkas = $this->ptk->cekBerkas($lsdata->id_berkas_syarat);
                                    if (isset($cekBerkas)) {
                                        foreach ($cekBerkas as $row) {
                                            $fName = $row->file_name;
                                        }
                                    }
                                }
                                ?>

                                <object data="https://arsipsimpeg.kotabogor.go.id/simpeg/berkas/<?php echo $fName ?>" type="application/pdf"
                                        width="100%" height="390px" style="border: 1px solid #cdcfc7;"></object>
                            </div>
                        </form>
                    <?php endforeach; ?>
                <?php else: ?>
                    <i>Tidak ada data</i>
                <?php endif; ?>
            <?php else: ?>
                <i>Tidak ada data</i>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
    $(function(){
        $("#datepicTglRef").datepicker();
        $("#datepicTglBerkas").datepicker();
    });
</script>