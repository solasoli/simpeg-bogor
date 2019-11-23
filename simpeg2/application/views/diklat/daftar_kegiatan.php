<style>
    .paginate {
        font-family: Arial, Helvetica, sans-serif;
        font-size: .7em;
    }

    a.paginate {
        border: 1px solid #000080;
        padding: 2px 6px 2px 6px;
        text-decoration: none;
        color: #000080;
    }

    a.paginate:hover {
        background-color: #000080;
        color: #FFF;
        text-decoration: underline;
    }

    a.current {
        border: 1px solid #000080;
        font: bold .7em Arial,Helvetica,sans-serif;
        padding: 2px 6px 2px 6px;
        cursor: default;
        background:#000080;
        color: #FFF;
        text-decoration: none;
    }

    span.inactive {
        border: 1px solid #999;
        font-family: Arial, Helvetica, sans-serif;
        font-size: .7em;
        padding: 2px 6px 2px 6px;
        color: #999;
        cursor: default;
    }
</style>

<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<br>
<div class="container">
    <strong>DAFTAR KEGIATAN DIKLAT PEGAWAI</strong>
    <div class="grid">
        <div class="row" style="margin-bottom: -10px;">
            <div class="span13" style="margin-top: -10px;">
                <table class="table bordered striped" >
                    <tr>
                        <th>
                            Kata Kunci :
                            <label class="input-control radio small-check">
                                <input type="radio" name="rdbCekKey" <?php echo $filter=='Diklat'?'checked':''?> value="Diklat">
                                <span class="check"></span>
                                <span class="caption">Nama Diklat</span>
                            </label>
                            <label class="input-control radio small-check">
                                <input type="radio" name="rdbCekKey" <?php echo $filter=='Pegawai'?'checked':''?> value="Pegawai">
                                <span class="check"></span>
                                <span class="caption">NIP / Nama Pegawai</span>
                            </label>

                        </th>
                        <th>
                            <div class="input-control text">
                                <input id="keywordCari"type="text" value="<?php echo $keywordCari; ?>" placeholder="Masukkan Kata kunci" style="background-color: #e3c800;" />
                            </div>
                        </th>
                    </tr>
                </table>
                <table class="table" style="margin-top: -10px;" >
                    <tr>
                        <th><?php if (isset($list_jenis)): ?>
                                <div class="input-control select" style="width: 100%;">
                                    <select id="ddFilterJenis" style="background-color: #e3c800;">
                                        <option value="0">Semua Jenis</option>
                                        <?php foreach ($list_jenis as $ls): ?>
                                            <?php if($ls->id_jenis_diklat == $idjenis): ?>
                                                <option value="<?php echo $ls->id_jenis_diklat; ?>" selected><?php echo $ls->jenis_diklat; ?></option>
                                            <?php else: ?>
                                                <option value="<?php echo $ls->id_jenis_diklat; ?>"><?php echo $ls->jenis_diklat; ?></option>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            <?php endif; ?>
                        </th>

                        <th>
                            <div class="input-control text" data-role="datepicker" data-week-start="1">
                                <input type="text" id="tgldari" name="tgldari" value="<?php echo (isset($tgldari2)&&$tgldari2 != null)?$tgldari2:date('d').'.'.date('m').'.'.date('Y'); ?>" style="background-color: #e3c800; width: 100px;">
                            </div>
                        </th>
                        <th style="vertical-align: middle">s/d</th>
                        <th>
                            <div class="input-control text" data-role="datepicker" data-week-start="1">
                                <input type="text" id="tglsampai" name="tglsampai" value="<?php echo (isset($tglsampai2)&&$tglsampai2 != null)?$tglsampai2:date('d').'.'.date('m').'.'.date('Y'); ?>" style="background-color: #e3c800; width: 100px;">
                            </div>
                        </th>
                        <th>
                            <label class="input-control checkbox small-check">
                                <input type="checkbox" <?php echo $chkWaktu=="0"?'':'checked' ?> id="chkWaktu" name="chkWaktu">
                                <span class="check"></span>
                                <span class="caption">Filter Waktu</span>
                            </label>
                        </th>
                        <th>
                            <div class="input-control select" style="width: 100%;">
                                <select id="ddFilterJenjab" style="background-color: #e3c800;">
                                    <option value="0">Semua Jenjang</option>
                                    <option value="Struktural" <?php echo $jenjab=='Struktural'?'selected':''?>>Struktural</option>
                                    <option value="Fungsional" <?php echo $jenjab=='Fungsional'?'selected':''?>>Fungsional</option>
                                </select>
                            </div>
                        </th>
                        <th>
                            <button id="btn_tampilkan" class="button primary" style="height: 30px;">
                                <strong>Tampilkan</strong></button>
                        </th>
                        <th>
                            <a href="<?php echo base_url('diklat/tambah_data_diklat/')?>" class="button success" style="height: 30px;">Tambah Baru</a>
                        </th>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    <div class="grid">
        <div class="row" style="margin-top: -30px;">
            <div class="span12">
                <?php if(isset($pgDisplay)): ?>
                    <?php if($numpage > 0): ?>
                        Halaman ke <?php echo $curpage; ?> dari <?php echo $numpage; ?> | Jumlah Data : <?php echo $total_items; ?> | <?php echo $jumppage; ?> | <?php echo $item_perpage; ?>
                        | <span style="font-family: Arial, Helvetica, sans-serif;font-size: .7em;">*Kata Kunci: Nama Diklat, NIP, Nama</span><br><?php echo $pgDisplay; ?>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <table class="table bordered striped" id="lst_cuti">
        <thead style="border-bottom: solid #a4c400 2px;">
        <tr>
            <th>No</th>
            <th>Jenis</th>
            <th>Waktu</th>
            <th>Judul</th>
            <th>Jam</th>
            <th>Penyelenggara</th>
            <th>NIP</th>
            <th>Nama</th>
            <th>Gol</th>
            <th>Status</th>
            <th width="13%">Aksi</th>
        </tr>
        </thead>
        <?php if (sizeof($list_data) > 0): ?>
            <?php $i = 1; ?>
            <?php if($list_data!=''): ?>
                <?php foreach ($list_data as $lsdata): ?>
                    <tr>
                        <td><?php echo $lsdata->no_urut; ?></td>
                        <td><?php echo $lsdata->jenis_diklat?></td>
                        <td><?php echo $lsdata->tgl_diklat2?></td>
                        <td><?php echo $lsdata->nama_diklat?></td>
                        <td><?php echo $lsdata->jml_jam_diklat?></td>
                        <td><?php echo $lsdata->penyelenggara_diklat?></td>
                        <td><?php echo $lsdata->nip_baru?></td>
                        <td><?php echo $lsdata->nama?></td>
                        <td><?php echo $lsdata->pangkat_gol?></td>
                        <td><?php echo $lsdata->flag_pensiun==0?'Aktif Bekerja':'Pensiun/Pindah'?></td>
                        <td>
                            <a onclick="ubah_data_diklat(<?php echo $lsdata->id_diklat?>)" class="button default">Ubah</a>
                            <a onclick="hapus_diklat(<?php echo $lsdata->id_diklat.",'".$lsdata->nama_diklat."'"?>)"  class="button danger">Hapus</a>
                        </td>
                    </tr>
                    <?php $i++; ?>
                <?php endforeach; ?>
            <?php else: ?>
                <tr class="error">
                    <td colspan="11"><i>Tidak ada data</i></td>
                </tr>
            <?php endif; ?>
        <?php else: ?>
        <tr class="error">
            <td colspan="11"><i>Tidak ada data</i></td>
        </tr>
        <?php endif; ?>
    </table>
    <?php if(isset($pgDisplay)): ?>
        <?php if($numpage > 0): ?>
            Halaman ke <?php echo $curpage; ?> dari <?php echo $numpage; ?> | Jumlah Data : <?php echo $total_items; ?> | <?php echo $jumppage; ?> | <?php echo $item_perpage; ?><br>
            <?php echo $pgDisplay; ?>
        <?php endif; ?>
    <?php endif; ?>
</div>

<script>

    function ubah_data_diklat(id_diklat){
        $.ajax({
            method: "POST",
            url: "<?php echo base_url()?>index.php/diklat/ubah_data_diklat",
            data: { id_diklat: id_diklat },
            dataType: "html"
        }).done(function( data ) {
            $("#ubah_diklat").html(data);
            $("#ubah_diklat").find("script").each(function(i) {
                eval($(this).text());
            });
        });

        $.Dialog({
            shadow: true,
            overlay: false,
            icon: '<span class="icon-rocket"></span>',
            title: 'Ubah Data Diklat',
            width: 850,
            height: 550,
            padding: 10,
            content: "<div id='ubah_diklat' style='height:450px;overflow: auto;overflow-x: hidden; '></div>"
        });
    }

    function hapus_diklat(id, namaDiklat){
        var r = confirm("Hapus data diklat \n "+namaDiklat+" ?");
        if (r == true) {
            $.post('<?php echo base_url("diklat/hapus_data_diklat")?>',{id_diklat:id},function(data){
                if(data == 'BERHASIL'){
                    window.location.reload();
                }else{
                    alert("gagal menghapus \n "+data);
                }
            });

        }
    }

    $("#btn_tampilkan").click(function(){
        var jenis = $('#ddFilterJenis').val();
        var tgldari = $('#tgldari').val();
        var tglsampai = $('#tglsampai').val();
        var jenjab = $('#ddFilterJenjab').val();
        var chkWaktu = 0;
        if ($('#chkWaktu').is(":checked")){
            chkWaktu = 1;
        }else{
            chkWaktu = 0;
        }
        var keywordCari = $("#keywordCari").val();
        var filter = $("input[name='rdbCekKey']:checked").val();
        loadDataListDiklat(jenis,tgldari,tglsampai,chkWaktu,jenjab,keywordCari,filter,'<?php echo isset($_GET['page'])?1:1; ?>');//$_GET['page']
    });

    function loadDataListDiklat(jenis,tgldari,tglsampai,chkWaktu,jenjab,keywordCari,filter,page){
        var ipp = $("#selIpp").val();
        location.href="<?php echo base_url()."diklat/list_data_diklat/" ?>"+"?page="+page+"&ipp="+ipp+"&idjenis="+jenis+"&tgldari="+tgldari+"&tglsampai="+tglsampai+"&chkWaktu="+chkWaktu+"&jenjab="+jenjab+"&keywordCari="+keywordCari+"&filter="+filter;
    }

</script>