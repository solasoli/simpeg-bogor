<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<script src="<?php echo base_url()?>js/jquery/jquery.validate.js"></script>
<script>
    jQuery.validator.addMethod(
        "selectComboJenisEd",
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

        var fileSertiSize = 0;

        $('#fileSertiEd').bind('change', function() {
            fileSertiSize = this.files[0].size;
        });

        $("#frmUbahDiklat").validate({
            ignore: "",
            rules: {
                txtIdPegawaiEd: {
                    required: true
                },
                judulEd: {
                    required: true
                },
                jdl_makalah_ed: {
                    required: true
                },
                tglpelaksanaanEd:{
                    required: true
                },
                jamEd:{
                    number:true,
                    required: true
                },
                penyelenggaraEd:{
                    required: true
                },
                sttplEd:{
                    required: true
                }
            },
            messages: {
                txtIdPegawaiEd: {
                    required: "Anda belum menentukan Data pegawai"
                },
                judulEd: {
                    required: "Anda belum mengisi Judul Diklat"
                },
                jdl_makalah_ed: {
                    required: "Anda belum mengisi Judul Makalah"
                },
                tglpelaksanaanEd: {
                    required: "Tanggal pelaksanaan harus diisi"
                },
                jamEd: {
                    required: "Jumlah jam harus diisi",
                    number: "Harus format angka"
                },
                penyelenggaraEd: {
                    required: "Penyelenggara harus diisi"
                },
                sttplEd: {
                    required: "Nomor STTPL harus diisi"
                }
            },
            errorPlacement: function(error, element) {
                switch (element.attr("name")) {
                    case 'ddFilterJenisEd':
                        error.insertAfter($("#jqv_msg_ed"));
                        break;
                    default:
                        error.insertAfter(element);
                }
            },
            submitHandler: function(form) {
                var idjenis = $('#ddFilterJenisEd').val();
                var judul = $('#judulEd').val();
                var jdl_makalah = $('#jdl_makalah_ed').val();
                var tglpelaksanaan = $('#tglpelaksanaanEd').val();
                var jam = $('#jamEd').val();
                var penyelenggara = $("#penyelenggaraEd").val();
                var sttpl = $('#sttplEd').val();
                var id_pegawai = $('#txtIdPegawaiEd').val();
                var nip = $('#txtNipEd').val();
                var id_diklat = $('#id_diklat').val();
                var data = new FormData();

                if(parseFloat(fileSertiSize) > 2138471){
                    alert('Ukuran file terlalu besar');
                }else{
                    if(parseFloat(fileSertiSize) > 0) {
                        jQuery.each(jQuery('#fileSertiEd')[0].files, function (i, file) {
                            data.append('fileSertiEd', file);
                        });
                    }
                    data.append('idjenis', idjenis);
                    data.append('judul', judul);
                    data.append('jdl_makalah', jdl_makalah);
                    data.append('tglpelaksanaan', tglpelaksanaan);
                    data.append('jam', jam);
                    data.append('penyelenggara', penyelenggara);
                    data.append('sttpl', sttpl);
                    data.append('id_pegawai', id_pegawai);
                    data.append('nip', nip);
                    data.append('id_diklat', id_diklat);

                    jQuery.ajax({
                        url: "<?php echo base_url()?>index.php/diklat/update_data_diklat",
                        data: data,
                        cache: false,
                        contentType: false,
                        processData: false,
                        type: 'POST',
                        success: function(data){
                            if(data == '1') {
                                alert('Data sukses tersimpan');
                                window.location.reload();
                            }else if(data == '2'){
                                alert('Data sukses tersimpan' + '\n' +
                                    'File tidak terupload. Ukuran file terlalu besar');
                                window.location.reload();
                            }else if(data == '3'){
                                alert('Data sukses tersimpan' + '\n' +
                                    'File sukses terupload');
                                window.location.reload();
                            }else if(data == '4'){
                                alert('Data sukses tersimpan' + '\n' +
                                    'File tidak terupload. Ada permasalahan ketika mengakses jaringan');
                                window.location.reload();
                            }else if(data == '5'){
                                alert('Data sukses tersimpan' + '\n' +
                                    'File tidak terupload. Tipe file belum sesuai');
                                window.location.reload();
                            }else{
                                alert("Gagal mengubah data \n "+data);
                            }
                        }
                    });
                }
            }
        });
    });
</script>

<script>
    function ganti_jenis_diklatEd(jenis, judul) {
        var s = '';
        if (jenis == '2') {
            var jdl1 = '';
            var jdl2 = '';
            var jdl3 = '';
            var jdl4 = '';
            var jdl5 = '';
            var jdl6 = '';

            if(judul=='Diklat Prajabatan Gol I'){
                jdl1 = 'selected';
            }else if(judul=='Diklat Prajabatan Gol II') {
                jdl2 = 'selected';
            }else if(judul=='Diklat Prajabatan Gol III') {
                jdl3 = 'selected';
            }else if(judul=='Diklat Kepemimpinan Tk.II'){
                jdl4 = 'selected';
            }else if(judul=='Diklat Kepemimpinan Tk.III'){
                jdl5 = 'selected';
            }else if(judul=='Diklat Kepemimpinan Tk.IV'){
                jdl6 = 'selected';
            }

            s = "<div class=\"input-control select\" style=\"width: 100%;\">";
            s += "<select id=\"judulEd\" name=\"judulEd\" onchange=\"show_jdl_makalah_ed(this.value)\">";
            s += "<option value='Diklat Prajabatan Gol I' "+ jdl1 +">Diklat Prajabatan Gol I</option> ";
            s += "<option value='Diklat Prajabatan Gol II' "+ jdl2 +">Diklat Prajabatan Gol II</option>";
            s += "<option value='Diklat Prajabatan Gol III' "+ jdl3 +">Diklat Prajabatan Gol III</option> ";
            s += "<option value='Diklat Kepemimpinan Tk.II' "+ jdl4 +">Diklat Kepemimpinan Tk.II</option> ";
            s += "<option value='Diklat Kepemimpinan Tk.III' "+ jdl5 +">Diklat Kepemimpinan Tk.III</option> ";
            s += "<option value='Diklat Kepemimpinan Tk.IV' "+ jdl6 +">Diklat Kepemimpinan Tk.IV</option></select>";
            s += "</div>";
        } else {
            s = "<div class=\"input-control textarea\" data-role=\"input\" data-text-auto-resize=\"true\">" +
                "<textarea id=\"judulEd\" name=\"judulEd\">"+judul+"</textarea></div>";
            document.getElementById('div_jdl_makalah_ed').innerHTML = '';
        }
        document.getElementById('dkltEd').innerHTML = s;
    }

    function show_jdl_makalah_ed(val){
        var s = '';
        var str = val;
        var n = str.search("Kepemimpinan");
        if(n>0){
            s = "<div class=\"input-control text\" style=\"margin-top: 10px;height: 100%; margin-bottom: -10px;\">";
            s += "<label>Makalah</label><input id=\"jdl_makalah_ed\" name=\"jdl_makalah_ed\" type=\"text\" value=\"\" required>";
            s += "</div></div>";
            document.getElementById('div_jdl_makalah_ed').innerHTML = s;
        }else{
            document.getElementById('div_jdl_makalah_ed').innerHTML = '';
        }
    }

</script>

<div class="container">
    <div class="grid">
        <div class="row">
            <?php if (sizeof($list_data) > 0): ?>
                <?php if($list_data!=''): ?>
                    <?php foreach ($list_data as $lsdata): ?>
                        <form action="" id="frmUbahDiklat" novalidate="novalidate" enctype="multipart/form-data">
                            <input id="submitok" name="submitok" type="hidden" value="1">
                            <div class="span5">
                                <div class="panel">
                                    <div class="panel-header">Informasi Pegawai</div>
                                    <div class="panel-content">
                                        <div class="input-control text" style="margin-bottom: 40px;">
                                            <label>NIP (Silahkan ketik untuk mencari)</label>
                                            <table style="width: 100%">
                                                <th><input id="nipCari" name="nipCari" type="text" value="<?php echo $lsdata->nip_baru; ?>" required="required"></th>
                                                <th><button id="btnCariNip" name="btnCariNip" type="button" class="button info" style="height: 33px; width: 100%" onclick="getInfoPegawai();">
                                                        <span class="icon-search on-left"></span><strong>Cari</strong></button></th>
                                            </table>
                                        </div>
                                        <div id="divInfoPegawai">
                                            <table style="font-size: small;">
                                                <tr>
                                                    <td></td>
                                                    <td colspan="3">
                                                        <strong>
                                                            <?php echo $lsdata->flag_pensiun==0?'Aktif Bekerja':'Pensiun/Pindah'; ?>
                                                        </strong></td>
                                                </tr>
                                                <tr>
                                                    <td rowspan="7" style="width: 30%;vertical-align: top;">
                                                        <img class="border-color-grey" width="100px" src="../../../../simpeg/foto/<?php echo $lsdata->id_pegawai; ?>.jpg" />
                                                    </td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td></td>
                                                    <td style="width: 17%">NIP</td>
                                                    <td style="width: 53%">: <?php echo $lsdata->nip_baru; ?>
                                                        <input type="hidden" id="txtIdPegawaiEd" name="txtIdPegawaiEd" value="<?php echo $lsdata->id_pegawai; ?>">
                                                        <input type="hidden" id="txtNipEd" name="txtNipEd" value="<?php echo $lsdata->nip_baru; ?>">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td></td>
                                                    <td>Nama</td>
                                                    <td>: <?php echo $lsdata->nama; ?></td>
                                                </tr>
                                                <tr>
                                                    <td></td>
                                                    <td>Jenjab</td>
                                                    <td>: <?php echo $lsdata->jenjab; ?></td>
                                                </tr>
                                                <tr>
                                                    <td></td>
                                                    <td>Gol</td>
                                                    <td>: <?php echo $lsdata->pangkat_gol; ?></td>
                                                </tr>
                                                <tr>
                                                    <td></td>
                                                    <td style="vertical-align: top">Jabatan</td>
                                                    <td>: <?php echo $lsdata->jabatan; ?></td>
                                                </tr>
                                                <tr>
                                                    <td></td>
                                                    <td style="vertical-align: top">OPD</td>
                                                    <td>: <?php echo $lsdata->nama_baru; ?></td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <div class="panel" style="margin-top: 20px;padding: 10px;">
                                    <div class="panel-header">Sertifikat</div>
                                    <?php
                                    if ($lsdata->id_berkas <> '' and $lsdata->id_berkas <> '0') {
                                        $cekBerkas = $this->diklat->cekBerkas($lsdata->id_berkas);
                                        if (isset($cekBerkas)) {
                                            echo '<br />';
                                            foreach ($cekBerkas as $row) {
                                                $fName = $row->file_name;
                                                $created = $row->created_date;
                                                $oleh = $row->nama;
                                                ?>
                                                <input type="button"
                                                       name="btnCetakSerti<?php echo $lsdata->id_diklat; ?>"
                                                       id="btnCetakSerti<?php echo $lsdata->id_diklat; ?>"
                                                       class="button warning btn-sm"
                                                       value="Lihat Sertifikat"
                                                       style="font-weight: bold;" onclick="openSertifikat();"/>
                                                <script>
                                                    function openSertifikat(){
                                                        window.open('/simpeg/Berkas/<?php echo $fName ?>', '_blank');
                                                    };
                                                </script><br>
                                                <div style="font-size: small;">
                                                    Tgl.Upload: <?php echo $created ?> <br>
                                                    Oleh : <?php echo $oleh ?></div>
                                            <?php
                                            }
                                        }
                                    }
                                    ?>
                                    <div class="panel-content"> Upload File Baru:
                                        <input type="file" id="fileSertiEd" name="fileSertiEd" />
                                    </div>
                                </div>
                            </div>

                            <div class="span5">
                                <div class="panel">
                                    <div class="panel-header">Data Diklat
                                        <input type="hidden" id="id_diklat" name="id_diklat" value="<?php echo $lsdata->id_diklat; ?>">
                                    </div>
                                    <div class="panel-content">
                                        <div class="input-control text">
                                            <label>Jenis</label>
                                            <?php if (isset($list_jenis)): ?>
                                                <div class="input-control select" style="width: 100%;">
                                                    <select id="ddFilterJenisEd" name="ddFilterJenisEd"
                                                            onchange="ganti_jenis_diklatEd(this.value, '')">
                                                        <option value="0">Semua Jenis</option>
                                                        <?php foreach ($list_jenis as $ls): ?>
                                                            <?php if($ls->id_jenis_diklat == $lsdata->id_jenis_diklat): ?>
                                                                <option value="<?php echo $ls->id_jenis_diklat; ?>" selected><?php echo $ls->jenis_diklat; ?></option>
                                                            <?php else: ?>
                                                                <option value="<?php echo $ls->id_jenis_diklat; ?>"><?php echo $ls->jenis_diklat; ?></option>
                                                            <?php endif; ?>
                                                        <?php endforeach; ?>
                                                    </select> <span id="jqv_msg_ed"></span>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                        <script>
                                            ganti_jenis_diklatEd('<?php echo $lsdata->id_jenis_diklat; ?>', '<?php echo $lsdata->nama_diklat; ?>');
                                        </script>
                                        <div class="input-control text" style="margin-top: 10px;height: 100%;margin-bottom: -10px;">
                                            <label>Judul</label>
                                            <div id="dkltEd">
                                                <div class="input-control textarea"
                                                     data-role="input" data-text-auto-resize="true">
                                                    <textarea id="judulEd" name="judulEd"><?php echo $lsdata->nama_diklat; ?></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="div_jdl_makalah_ed">
                                        <?php if ($lsdata->id_jenis_diklat==2 and strpos($lsdata->nama_diklat, 'Kepemimpinan') !== false): ?>
                                            <div class="input-control text" style="margin-top: 10px;height: 100%; margin-bottom: -10px;">
                                                <label>Makalah</label>
                                                <input id="jdl_makalah_ed" name="jdl_makalah_ed" type="text" value="<?php echo $lsdata->judul_makalah; ?>" required>
                                            </div>
                                        <?php endif; ?>
                                        </div>

                                        <div class="input-control text" id="datepicTglpelaksanaan" data-week-start="1" style="margin-top: 10px;">
                                            <label>Tanggal Pelaksanaan</label>
                                            <input type="text" id="tglpelaksanaanEd" name="tglpelaksanaanEd" value="<?php if(isset($lsdata->tgl_diklat2)) echo $lsdata->tgl_diklat2 ?>">
                                        </div>
                                        <div class="input-control text" style="margin-top: 10px;">
                                            <label>Jumlah Jam</label>
                                            <input id="jamEd" name="jamEd" type="text" value="<?php echo $lsdata->jml_jam_diklat; ?>" required>
                                        </div>
                                        <div class="input-control text" style="margin-top: 10px;">
                                            <label>Penyelenggara</label>
                                            <input id="penyelenggaraEd" name="penyelenggaraEd" type="text" value="<?php echo $lsdata->penyelenggara_diklat; ?>" required>
                                        </div>
                                        <div class="input-control text" style="margin-top: 10px;">
                                            <label>No. STTPL</label>
                                            <input id="sttplEd" name="sttplEd" type="text" value="<?php echo $lsdata->no_sttpl; ?>" required>
                                        </div>
                                        <button id="btnregister" name="new_register" type="submit" class="button success" style="height: 34px; margin-top: 20px;">
                                            <span class="icon-floppy on-left"></span><strong>Simpan</strong></button>
                                        <!-- </div> -->
                                    </div>
                                </div>
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
</div>

<script>
    $(function(){
        $("#datepicTglpelaksanaan").datepicker();
    });

    function getInfoPegawai(){
        var nipCari = $("#nipCari").val();
        $.ajax({
            method: "POST",
            url: "<?php echo base_url()?>index.php/diklat/info_pegawai_edit",
            data: { nipCari: nipCari },
            dataType: "html"
        }).done(function( data ) {
            $("#divInfoPegawai").html(data);
            $("#divInfoPegawai").find("script").each(function(i) {
                //eval($(this).text());
            });
        });
    }

    $( "#ddFilterJenisEd" ).addClass( "selectComboJenisEd" );


</script>