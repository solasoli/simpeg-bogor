<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<script src="<?php echo base_url()?>js/jquery/jquery.validate.js"></script>
<script>
    jQuery.validator.addMethod(
        "selectComboJenis",
        function (value, element)
        {
            if (element.value === "0") {
                return false;
            }else {
                return true;
            }
        },
        "Anda belum memilih Jenis Diklat"
    );

    $(function(){
        var fileSertiSizeAdd = 0;
        $('#fileSerti').bind('change', function() {
            fileSertiSizeAdd = this.files[0].size;
        });

        $("#frmTambahDiklat").validate({
            ignore: "",
            rules: {
                txtIdPegawai: {
                    required: true
                },
                judul: {
                    required: true
                },
                jdl_makalah: {
                    required: true
                },
                tglpelaksanaan:{
                    required: true
                },
                jam:{
                    number:true,
                    required: true
                },
                penyelenggara:{
                    required: true
                },
                sttpl:{
                    required: true
                }
            },
            messages: {
                txtIdPegawai: {
                    required: "Anda belum menentukan Data pegawai"
                },
                judul: {
                    required: "Anda belum mengisi Judul Diklat"
                },
                jdl_makalah: {
                    required: "Anda belum mengisi Judul Makalah"
                },
                tglpelaksanaan: {
                    required: "Tanggal pelaksanaan harus diisi"
                },
                jam: {
                    required: "Jumlah jam harus diisi",
                    number: "Harus format angka"
                },
                penyelenggara: {
                    required: "Penyelenggara harus diisi"
                },
                sttpl: {
                    required: "Nomor STTPL harus diisi"
                }
            },
            errorPlacement: function(error, element) {
                switch (element.attr("name")) {
                    case 'ddFilterJenis':
                        error.insertAfter($("#jqv_msg"));
                        break;
                    default:
                        error.insertAfter(element);
                }
            },
            submitHandler: function(form) {
                if (parseFloat(fileSertiSizeAdd) > 2138471) {
                    alert('Ukuran file terlalu besar');
                } else {
                    form.submit();
                }
            }
        });
    });

</script>

<script>
    function ganti_jenis_diklat(jenis) {
        var s = '';
        if (jenis == '2') {
            s = "<div class=\"input-control select\" style=\"width: 100%;\">";
            s += "<select id=\"judul\" name=\"judul\" onchange=\"show_jdl_makalah(this.value)\">";
            s += "<option value='Diklat Prajabatan Gol I'>Diklat Prajabatan Gol I</option> ";
            s += "<option value='Diklat Prajabatan Gol II'>Diklat Prajabatan Gol II</option>";
            s += "<option value='Diklat Prajabatan Gol III'>Diklat Prajabatan Gol III</option> ";
            s += "<option value='Diklat Kepemimpinan Tk.II'>Diklat Kepemimpinan Tk.II</option> ";
            s += "<option value='Diklat Kepemimpinan Tk.III'>Diklat Kepemimpinan Tk.III</option> ";
            s += "<option value='Diklat Kepemimpinan Tk.IV'>Diklat Kepemimpinan Tk.IV</option></select>";
            s += "</div>";
        } else {
            s = "<div class=\"input-control textarea\" data-role=\"input\" data-text-auto-resize=\"true\">" +
                "<textarea id=\"judul\" name=\"judul\"></textarea></div>";
            document.getElementById('div_jdl_makalah').innerHTML = '';
        }
        document.getElementById('dklt').innerHTML = s;
    }

    function show_jdl_makalah(val){
        var s = '';
        var str = val;
        var n = str.search("Kepemimpinan");
        if(n>0){
            s = "<div class=\"input-control text\" style=\"margin-top: 10px;height: 100%; margin-bottom: -10px;\">";
            s += "<label>Makalah</label><input id=\"jdl_makalah\" name=\"jdl_makalah\" type=\"text\" value=\"\" required>";
            s += "</div></div>";
            document.getElementById('div_jdl_makalah').innerHTML = s;
        }else{
            document.getElementById('div_jdl_makalah').innerHTML = '';
        }
    }

</script>

<div class="container">
    <div class="grid">
        <?php if($tx_result == 1): ?>
            <div class="row">
                <div class="span12">
                    <div class="notice" style="background-color: #00a300;">
                        <div class="fg-white">Data sukses tersimpan <?php echo $upload_kode==2?' dan file sertifikasi terupload':'';?> </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
        <?php if($upload_kode == 1): ?>
            <div class="row">
                <div class="span12">
                    <div class="notice" style="background-color: #942a25;">
                        <div class="fg-white"><?php echo $upload_status?></div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
        <div class="row">
            <span style="font-weight: bold; margin-top: 50px;">TAMBAH DATA BARU DIKLAT PEGAWAI</span>
        </div>
        <div class="row">
            <form action="" method="post" id="frmTambahDiklat" novalidate="novalidate" enctype="multipart/form-data">
                <input id="submitok" name="submitok" type="hidden" value="1">
                <div class="span5">
                    <div class="panel">
                        <div class="panel-header">Informasi Pegawai</div>
                        <div class="panel-content">
                            <div class="input-control text" style="margin-bottom: 40px;">
                                <label>NIP (Silahkan ketik untuk mencari)</label>
                                <table style="width: 100%">
                                    <th><input id="nipCari" name="nipCari" type="text" value=""></th>
                                    <th><button id="btnCariNip" name="btnCariNip" type="button" class="button info" style="height: 33px; width: 100%" onclick="getInfoPegawai();">
                                            <span class="icon-search on-left"></span><strong>Cari</strong></button></th>
                                </table>
                            </div>
                            <div id="divInfoPegawai">
                                <input type="hidden" id="txtIdPegawai" name="txtIdPegawai" value="">
                            </div>
                        </div>
                    </div>

                    <div class="panel" style="margin-top: 20px;">
                        <div class="panel-header">Sertifikat</div>
                        <div class="panel-content">
                            <input type="file" id="fileSerti" name="fileSerti" />
                        </div>
                    </div>
                </div>

                <div class="span5">
                    <div class="panel">
                        <div class="panel-header">Data Diklat</div>
                        <div class="panel-content">
                            <div class="input-control text">
                                <label>Jenis</label>
                                <?php if (isset($list_jenis)): ?>
                                    <div class="input-control select" style="width: 100%;">
                                        <select id="ddFilterJenis" name="ddFilterJenis"
                                                onchange="ganti_jenis_diklat(this.value)">
                                            <option value="0">Pilih Jenis</option>
                                            <?php foreach ($list_jenis as $ls): ?>
                                                <option value="<?php echo $ls->id_jenis_diklat; ?>"><?php echo $ls->jenis_diklat; ?></option>
                                            <?php endforeach; ?>
                                        </select> <span id="jqv_msg"></span>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <div class="input-control text" style="margin-top: 10px;height: 100%; margin-bottom: -10px;">
                                <label>Judul</label>
                                <div id="dklt">
                                    <div class="input-control textarea"
                                         data-role="input" data-text-auto-resize="true">
                                        <textarea id="judul" name="judul"></textarea>
                                    </div>
                                </div>
                            </div>

                            <div id="div_jdl_makalah"></div>

                            <div class="input-control text" id="datepicTglpelaksanaan" data-week-start="1" style="margin-top: 10px;">
                                <label>Tanggal Pelaksanaan</label>
                                <input type="text" id="tglpelaksanaan" name="tglpelaksanaan" value="">
                            </div>
                            <div class="input-control text" style="margin-top: 10px;">
                                <label>Jumlah Jam</label>
                                <input id="jam" name="jam" type="text" value="" required>
                            </div>
                            <div class="input-control text" style="margin-top: 10px;">
                                <label>Penyelenggara</label>
                                <input id="penyelenggara" name="penyelenggara" type="text" value="" required>
                            </div>
                            <div class="input-control text" style="margin-top: 10px;">
                                <label>No. STTPL</label>
                                <input id="sttpl" name="sttpl" type="text" value="" required>
                            </div>
                            <button id="btnregister" name="new_register" type="submit" class="button success" style="height: 34px; margin-top: 20px;">
                                <span class="icon-floppy on-left"></span><strong>Simpan</strong></button>
                            <!-- </div> -->
                        </div>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>
</div>

<script>
    function getInfoPegawai(){
        var nipCari = $("#nipCari").val();
        $.ajax({
            method: "POST",
            url: "<?php echo base_url()?>index.php/diklat/info_pegawai_add",
            data: { nipCari: nipCari },
            dataType: "html"
        }).done(function( data ) {
            $("#divInfoPegawai").html(data);
            $("#divInfoPegawai").find("script").each(function(i) {
                //eval($(this).text());
            });
        });
    }
    $( "#ddFilterJenis" ).addClass( "selectComboJenis" );
    $(function(){
        $("#datepicTglpelaksanaan").datepicker();
    });

</script>