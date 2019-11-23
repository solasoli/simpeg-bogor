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
<script src="<?php echo base_url()?>js/jquery/jquery.validate.js"></script>

<br>
<div class="container">
    <?php if ($tx_result <> ""): ?>
        <div class="row">
            <div class="span13">
                <div class="notice" style="background-color: #00a300;">
                    <div class="fg-white">Data sukses <?php echo $tx_result ?></div>
                </div>
            </div>
        </div>
    <?php endif; ?>
    <strong>DAFTAR PENGAJUAN PTK STATUS : <?php echo strtoupper($list_title) ?></strong>
    <div class="grid">
        <div class="row" style="margin-bottom: -10px;">
            <div class="span13">
                <span class="span4">
                    <?php if (isset($list_skpd)): ?>
                        <div class="input-control select" style="width: 100%;">
                            <select id="ddFilterOpd" style="background-color: #e3c800;">
                                <option value="0">Semua OPD</option>
                                <?php foreach ($list_skpd as $ls): ?>
                                    <?php if($ls->id_unit_kerja == $idskpd): ?>
                                        <option value="<?php echo $ls->id_unit_kerja; ?>" selected><?php echo $ls->nama_baru; ?></option>
                                    <?php else: ?>
                                        <option value="<?php echo $ls->id_unit_kerja; ?>"><?php echo $ls->nama_baru; ?></option>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    <?php endif; ?>
                </span>
                <span class="span3">
                    <?php if (isset($list_jenis)): ?>
                        <div class="input-control select" style="width: 100%;">
                            <select id="ddFilterJns" style="background-color: #e3c800;">
                                <option value="0">Semua Jenis Pengajuan</option>
                                <?php foreach ($list_jenis as $ls): ?>
                                    <?php if($ls->id_jenis_pengajuan == $jenis): ?>
                                        <option value="<?php echo $ls->id_jenis_pengajuan; ?>" selected><?php echo $ls->jenis_pengajuan; ?></option>
                                    <?php else: ?>
                                        <option value="<?php echo $ls->id_jenis_pengajuan; ?>"><?php echo $ls->jenis_pengajuan; ?></option>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    <?php endif; ?>
                </span>
                <?php if ($list_status!=''): ?>
                <span class="span3">
                    <div class="input-control select" style="width: 100%;">
                        <select id="ddFilterStatus" style="background-color: #e3c800;">
                            <option value="0">Semua Status Pengajuan</option>
                            <?php foreach ($list_status as $ls): ?>
                                <?php if($ls->id_status_ptk == $status): ?>
                                    <option value="<?php echo $ls->id_status_ptk; ?>" selected><?php echo $ls->status_ptk; ?></option>
                                <?php else: ?>
                                    <option value="<?php echo $ls->id_status_ptk; ?>"><?php echo $ls->status_ptk; ?></option>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </span>
                <?php endif; ?>
                <span class="span3">
                    <div class="input-control text">
                        <input id="keywordCari"type="text" value="<?php echo $keywordCari; ?>" placeholder="Kata kunci" style="background-color: #e3c800;" />
                    </div>
                </span>
                <span class="span1">
                    <button id="btn_tampilkan" class="button primary" style="height: 35px;">
                        <strong>Tampilkan</strong></button>
                </span>
            </div>
        </div>
    </div>
    <div class="grid">
        <div class="row">
            <div class="span10">
                <?php if(isset($pgDisplay)): ?>
                    <?php if($numpage > 0): ?>
                        Halaman ke <?php echo $curpage; ?> dari <?php echo $numpage; ?> | Jumlah Data : <?php echo $total_items; ?> | <?php echo $jumppage; ?> | <?php echo $item_perpage; ?>
                        | <span style="font-family: Arial, Helvetica, sans-serif;font-size: .7em;">*Kata Kunci: NIP, Nama, Jabatan</span><br><?php echo $pgDisplay; ?>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
            <div class="span5" style="margin-left: -50px;text-align: right;font-size:small">

            </div>
        </div>
    </div>
    <table class="table bordered striped" id="lst_ptk">

        <?php if (is_array($list_ptk) && sizeof($list_ptk) > 0): ?>
            <?php
                $connection = ssh2_connect('103.14.229.15');
                ssh2_auth_password($connection, 'rommonz', 'mony3Tmony3T');
                $sftp = ssh2_sftp($connection);
            ?>
            <?php $i = 1; ?>
            <?php if($list_ptk!=''): ?>
                <?php foreach ($list_ptk as $lsdata): ?>
                    <?php
                        $pegawai_pemohon = $lsdata->id_pegawai;
                        $ponsel = $this->ptk->getPonsel($lsdata->id_pegawai);
                        $nama_pengusul = $lsdata->nama;
                    ?>
                    <thead style="border-bottom: solid #a4c400 2px;border-top: solid 1px #cdcfc7;">
                    <tr>
                        <th>No</th>
                        <th style="width: 15%;">Waktu Permohonan</th>
                        <th style="width: 20%;">Nomor</th>
                        <th>Sifat</th>
                        <th>Lampiran</th>
                        <th style="width: 25%;">Jenis Pengajuan</th>
                        <th style="width: 15%;">Jml. Akhir Pasangan</th>
                        <th style="width: 15%;">Jml. Akhir Anak</th>
                    </tr>
                    </thead>
                    <?php if ($lsdata->idstatus_ptk==5): ?>
                        <tr>
                            <td style="border-bottom: solid #666666 1px;"><?php echo $lsdata->no_urut;?></td>
                            <td style="border-bottom: solid #666666 1px;"><?php echo $lsdata->tgl_input_pengajuan ?></td>
                            <td style="border-bottom: solid #666666 1px; font-weight: bold; color: saddlebrown">
                                <form style="margin-bottom: 0px;" action="" id="frmUbahNomorPtk<?php echo $lsdata->id_ptk?>" novalidate="novalidate" enctype="multipart/form-data">
                                    <input type="hidden" id="id_ptk2<?php echo $lsdata->id_ptk; ?>" name="id_ptk2<?php echo $lsdata->id_ptk; ?>" value="<?php echo $lsdata->id_ptk; ?>">
                                    <input type="text" id="txtNomorPtk<?php echo $lsdata->id_ptk ?>" name="txtNomorPtk<?php echo $lsdata->id_ptk ?>"
                                           value="<?php echo $lsdata->nomor ?>" required style="width:77%">
                                    <button id="btnregister" name="new_register" type="submit" style="width: 10%;" onclick="return confirm('Anda yakin akan mengubah nomor permohonan ini?');">
                                        <span class="icon-floppy on-left" style="margin-left: -7px;"></span></button>
                                </form>
                                <script>
                                    $(function(){
                                        $("#frmUbahNomorPtk<?php echo $lsdata->id_ptk?>").validate({
                                            ignore: "",
                                            rules: {
                                                txtNomorPtk<?php echo $lsdata->id_ptk; ?>: {
                                                    required: true
                                                }
                                            },
                                            messages: {
                                                txtNomorPtk<?php echo $lsdata->id_ptk; ?>: {
                                                    required: ""
                                                }
                                            },
                                            errorPlacement: function(error, element) {
                                                /*switch (element.attr("name")) {
                                                    default:
                                                        error.insertAfter(element);
                                                }*/
                                            },
                                            submitHandler: function(form) {
                                                var txtNomorPtk = $("#txtNomorPtk<?php echo $lsdata->id_ptk; ?>").val();
                                                var id_ptk = $('#id_ptk2<?php echo $lsdata->id_ptk; ?>').val();
                                                var data = new FormData();
                                                data.append('txtNomorPtk', txtNomorPtk);
                                                data.append('id_ptk', id_ptk);
                                                jQuery.ajax({
                                                    url: "<?php echo base_url()?>index.php/ptk/update_nomor_usulan_ptk",
                                                    data: data,
                                                    cache: false,
                                                    contentType: false,
                                                    processData: false,
                                                    type: 'POST',
                                                    success: function(data){
                                                        if(data == '1') {
                                                            alert('Data sukses tersimpan');
                                                            //window.location.reload();
                                                        }else{
                                                            alert("Gagal mengubah data \n "+data);
                                                        }
                                                    }
                                                });
                                            }
                                        });
                                    });
                                </script>
                            </td>
                            <td style="border-bottom: solid #666666 1px;"><?php echo $lsdata->sifat ?></td>
                            <td style="border-bottom: solid #666666 1px;"><?php echo $lsdata->lampiran ?></td>
                            <td style="border-bottom: solid #666666 1px;"><?php echo $lsdata->jenis_pengajuan ?></td>
                            <td style="border-bottom: solid #666666 1px;text-align: center;"><?php echo $lsdata->last_jml_pasangan ?></td>
                            <td style="border-bottom: solid #666666 1px;text-align: center;"><?php echo $lsdata->last_jml_anak ?></td>
                        </tr>
                    <?php else: ?>
                        <tr>
                            <td style="border-bottom: solid #666666 1px;"><?php echo $lsdata->no_urut; ?></td>
                            <td style="border-bottom: solid #666666 1px;"><?php echo $lsdata->tgl_input_pengajuan ?></td>
                            <td style="border-bottom: solid #666666 1px; font-weight: bold; color: saddlebrown"><?php echo $lsdata->nomor ?></td>
                            <td style="border-bottom: solid #666666 1px;"><?php echo $lsdata->sifat ?></td>
                            <td style="border-bottom: solid #666666 1px;"><?php echo $lsdata->lampiran ?></td>
                            <td style="border-bottom: solid #666666 1px;"><?php echo $lsdata->jenis_pengajuan ?></td>
                            <td style="border-bottom: solid #666666 1px;text-align: center;"><?php echo $lsdata->last_jml_pasangan ?></td>
                            <td style="border-bottom: solid #666666 1px;text-align: center;"><?php echo $lsdata->last_jml_anak ?></td>
                        </tr>
                    <?php endif; ?>
                    <tr>
                        <td></td>
                        <td colspan="7">
                            <h3 style="color: #002a80;"><?php echo $lsdata->nama; ?></h3>
                            NIP : <?php echo $lsdata->nip_baru; ?> <strong>|</strong>
                            Pangkat : <?php echo $lsdata->pangkat . ', ' . $lsdata->last_gol; ?> <strong>|</strong>
                            Unit Kerja : <?php echo $lsdata->last_unit_kerja; ?> <br>
                            Jabatan : <?php echo $lsdata->last_jabatan; ?> <strong>|</strong> Ponsel : <?php echo $ponsel; ?> <br>
                            <a href="javascript:void(0);" onclick="lihat_data_keluarga(<?php echo $lsdata->id_pegawai_pemohon?>)"
                               ><span style="font-weight: bold;">Lihat Data Keluarga</span></a> <strong>|</strong>
                            <a href="/simpeg2/pdf/skum_pdf/index/<?php echo $lsdata->id_pegawai_pemohon; ?>" target="_blank">
                                <span style="font-weight: bold;">Lihat SKUM PTK Terakhir</span></a>
                            <h5>Status Pengajuan : <?php echo $lsdata->status_ptk; ?></h5>
                            <?php if($lsdata->tgl_approve!=''): ?>
                            Tanggal : <?php echo $lsdata->tgl_approve; ?> Oleh : <?php echo $lsdata->nama_approved; ?> (<?php echo $lsdata->nip_approved; ?>).
                            Catatan : <?php echo $lsdata->approved_note; ?><?php endif; ?>
                            <?php if ($lsdata->idstatus_ptk == 9 or $lsdata->idstatus_ptk == 10 or $lsdata->idstatus_ptk == 11) : ?>
                                <br>
                                <?php if ($lsdata->id_berkas_ptk == 0 and $lsdata->id_berkas_ptk == '') {
                                    echo 'Belum ada File Surat Pengajuan PTK yang diupload : ';
                                }else{
                                    $syaratBerkasLainnya = $this->ptk->cekBerkas($lsdata->id_berkas_ptk);
                                    if (isset($syaratBerkasLainnya)) {
                                        $x = 1;
                                        if(sizeof($syaratBerkasLainnya) > 0){
                                            foreach ($syaratBerkasLainnya as $row4) {
                                                $asli = basename($row4->file_name);
                                                //$getcwd = substr(getcwd(),0,strlen(getcwd())-1);
                                                error_reporting(0);
                                                if (file_exists('ssh2.sftp://' . $sftp . '/var/www/html/simpeg/berkas/'.trim($asli))) {
                                                //if(file_exists(str_replace("\\","/",$getcwd).'/berkas/'.trim($asli))){
                                                    $ext[] = explode(".",$asli);
                                                    $linkBerkasPtk = "<a href='http://103.14.229.15/simpeg/berkas/$asli' target='_blank' style='font-weight: bold;'>Berkas Pengajuan PTK ke BPKAD Terupload</a>";
                                                    $tglUploadPtk = $row4->created_date;
                                                    unset($ext);
                                                    echo "$linkBerkasPtk";
                                                    echo "<small class=\"form-text text-muted\">";
                                                    echo "<br>Upload : ".$tglUploadPtk." oleh: ".$row4->nama."</small>";
                                                }else{
                                                    echo 'Belum ada File Surat Pengajuan PTK yang diupload (Data berkas sudah ada tapi file tidak ada).';
                                                }
                                                error_reporting(1);
                                            }
                                        }
                                    }
                                }?>
                            <?php endif; ?>
                            <div class="grid" style="background-color: white;">
                                <div class="row">
                                    <div class="tab-control" data-role="tab-control" data-effect="fade">
                                        <ul class="tabs">
                                            <li class="active"><a href="#_page_1<?php echo $lsdata->id_ptk?>">Peninjauan Usulan</a></li>
                                            <?php if ($lsdata->idstatus_ptk == 5 or $lsdata->idstatus_ptk == 8) : ?>
                                            <li><a href="#_page_2<?php echo $lsdata->id_ptk?>">Penerbitan Surat PTK ke BPKAD</a></li>
                                            <?php endif; ?>
                                        </ul>
                                        <div class="frames">
                                            <div class="frame" id="_page_1<?php echo $lsdata->id_ptk?>">
                                                <div class="grid" style="margin-bottom: -20px;margin-top: -20px;">
                                                    <div class="row">
                                                        <div class="span7">
                                                            <table class="table bordered">
                                                                <tr style='border-bottom: solid 2px #d29d4e;background-color: white; border-top: solid 1px #cdcfc7;'>
                                                                    <td style="width: 5%;">No</td>
                                                                    <td style="border-left: 0px;width: 65%;">Pengubahan Keluarga</td>
                                                                    <td style="width: 30%;border-left: 0px;">Status Tunjangan</td>
                                                                </tr>
                                                                <?php
                                                                $lstKeluarga = $this->ptk->get_list_keluarga_ptk($lsdata->id_ptk);
                                                                $pnsFamCount = $this->ptk->get_jml_keluarga_pns($lsdata->id_pegawai);
                                                                if (isset($pnsFamCount)) {
                                                                    foreach ($pnsFamCount as $rowPns) {
                                                                        $jmlPasanganPNS = $rowPns->jumlah;
                                                                    }
                                                                }

                                                                if (isset($lstKeluarga)) {
                                                                    $x = 1;
                                                                    foreach ($lstKeluarga as $row) {
                                                                        ?>
                                                                        <tr style="background-color: white;">
                                                                            <td style="border-top: solid 1px #dbdcd3;border-bottom: solid 1px #dbdcd3;"><?php echo $x;?></td>
                                                                            <td style="border-top: solid 1px #dbdcd3;border-left: 0px;border-bottom: solid 1px #dbdcd3;color: darkgreen;font-weight: bold;"><?php echo $row->kategori_pengubahan.' krn '.$row->tipe_pengubahan_tunjangan;?></td>
                                                                            <td style="border-top: solid 1px #dbdcd3;border-left: 0px;border-bottom: solid 1px #dbdcd3;"><?php echo $row->last_status_tunjangan ?></td></tr>
                                                                        <tr style="background-color: white;">
                                                                            <td></td>
                                                                            <td style="border-left: 0px;">
                                                                                <?php
                                                                                    echo "$row->status_keluarga : <strong>$row->last_nama</strong> <br> Jenis Kelamin : $row->last_jk<br>
                                                                                    Kelahiran : $row->last_tempat_lahir, $row->last_tgl_lahir<br>Pekerjaan : $row->last_pekerjaan";
                                                                                    if($row->status_keluarga=='Istri/Suami'){
                                                                                        $pekerjaan_pasangan = str_replace(' ', '', strtolower($row->last_pekerjaan));
                                                                                    }
                                                                                ?>
                                                                            </td>
                                                                            <td style="border-left: 0px;">
                                                                                <?php
                                                                                if ($row->id_berkas_syarat <> '' and $row->id_berkas_syarat <> '0') {
                                                                                    $cekBerkas = $this->ptk->cekBerkas($row->id_berkas_syarat);
                                                                                    if (isset($cekBerkas)) {
                                                                                        foreach ($cekBerkas as $row2) {
                                                                                            $fname = pathinfo($row2->file_name);
                                                                                            ?>
                                                                                            <input type="button"
                                                                                                   name="btnCetakSuratPtkUploaded<?php echo $lsdata->id_ptk.$row->id_berkas_syarat; ?>"
                                                                                                   id="btnCetakSuratPtkUploaded<?php echo $lsdata->id_ptk.$row->id_berkas_syarat; ?>"
                                                                                                   class="btn btn-primary btn-sm"
                                                                                                   value="Berkas Syarat Terupload"
                                                                                                   style="font-weight: bold;"/>
                                                                                            <script type="text/javascript">
                                                                                                $("#btnCetakSuratPtkUploaded<?php echo $lsdata->id_ptk.$row->id_berkas_syarat; ?>").click(function () {
                                                                                                    window.open('http://103.14.229.15/simpeg/berkas/<?php echo $row2->file_name ?>', '_blank');
                                                                                                });
                                                                                            </script><br>
                                                                                        <?php $tglUpload = $row2->created_date. "<br>$row->nama_berkas_syarat<br>$row->last_tgl_references".($row->last_keterangan_reference==''?'':' ('.$row->last_keterangan_reference.')'); ?>
                                                                                            Oleh : <?php echo $row2->nama; ?> <br>
                                                                                            Upload: <?php echo $tglUpload; ?>
                                                                                            <?php if ($lsdata->idstatus_ptk == 5) : ?><br>
                                                                                            <a onclick="ubah_data_syarat_ptk(<?php echo $row->id_syarat?>,'<?php echo $row->nama_berkas_syarat?>')"
                                                                                               class="button link"><span style="font-weight: bold;">Lihat Detail & Ubah</span></a>
                                                                                            <?php endif; ?>
                                                                                    <?php
                                                                                        }
                                                                                    } else {
                                                                                        echo "<div id='spnInfo' style='color: white; background-color: #b12318; font-weight: bold; padding: 3px; width: 100%; text-align: center;'>Belum ada surat permohonan yang diupload</div>";
                                                                                    }
                                                                                }
                                                                                ?>
                                                                            </td>
                                                                        </tr>
                                                                        <?php
                                                                        $x++;}
                                                                }
                                                                ?>
                                                            </table>
                                                        </div>
                                                        <div class="span6">
                                                            <table class="table bordered">
                                                                <tr style='border-bottom: solid 2px #d25e52;background-color: white; border-top: solid 1px #cdcfc7;'>
                                                                    <td style="width:5%">No</td>
                                                                    <td colspan="2" style="border-left: 0px;width: 95%">Persyaratan Lainnya</td>
                                                                </tr>
                                                                <?php
                                                                $idberkas1 = ($lsdata->id_berkas_pengajuan==''?-1:$lsdata->id_berkas_pengajuan);
                                                                $idberkas2 = ($lsdata->id_berkas_skum==''?-1:$lsdata->id_berkas_skum);
                                                                $idberkas3 = ($lsdata->id_berkas_sk_pangkat_last==''?-1:$lsdata->id_berkas_sk_pangkat_last);
                                                                $idberkas4 = ($lsdata->id_berkas_daftar_gaji_last==''?-1:$lsdata->id_berkas_daftar_gaji_last);
                                                                $idberkas5 = ($lsdata->id_berkas_kk_last==''?-1:$lsdata->id_berkas_kk_last);
                                                                $idberkas6 = ($lsdata->id_berkas_daftar_gaji_pasangan_pns==''?-1:$lsdata->id_berkas_daftar_gaji_pasangan_pns);
                                                                $syaratBerkasLainnya = $this->ptk->cekBerkasSyaratLain($idberkas1, $idberkas2, $idberkas3, $idberkas4, $idberkas5, $idberkas6);
                                                                if (isset($syaratBerkasLainnya)) {
                                                                    $x = 1;
                                                                    if(sizeof($syaratBerkasLainnya) > 0){
                                                                        foreach ($syaratBerkasLainnya as $row3) {
                                                                            $asli = basename($row3->file_name);
                                                                            $getcwd = substr(getcwd(),0,strlen(getcwd())-1);

                                                                            //if(file_exists(str_replace("\\","/",$getcwd).'/berkas/'.trim($asli))){
                                                                            //echo 'http://simpeg.kotabogor.go.id/simpeg/berkas/'.trim($asli);
                                                                          //  if(file_exists('http://simpeg.kotabogor.go.id/simpeg/berkas/'.trim($asli))){
                                                                                $ext[] = explode(".",$asli);
                                                                                switch($row3->id_kat){
                                                                                    case 40: //Surat Pengantar dari OPD
                                                                                        $linkBerkasUsulan1 = "<a href='http://103.14.229.15/simpeg/berkas/$asli' target='_blank'>Berkas Syarat Terupload</a>";
                                                                                        $tglUpload1 = $row3->created_date;
                                                                                        break;
                                                                                    case 45: //SKUM
                                                                                        $linkBerkasUsulan2 = "<a href='http://103.14.229.15/simpeg/berkas/$asli' target='_blank'>Berkas Syarat Terupload</a>";
                                                                                        $tglUpload2 = $row3->created_date;
                                                                                        break;
                                                                                    case 2: //SK Pangkat Terakhir
                                                                                        $linkBerkasUsulan3 = "<a href='http://103.14.229.15/simpeg/berkas/$asli' target='_blank'>Berkas Syarat Terupload</a>";
                                                                                        $tglUpload3 = $row3->created_date;
                                                                                        break;
                                                                                    case 46: //Daftar Gaji
                                                                                        $linkBerkasUsulan4 = "<a href='http://103.14.229.15/simpeg/berkas/$asli' target='_blank'>Berkas Syarat Terupload</a>";
                                                                                        $tglUpload4 = $row3->created_date;
                                                                                        break;
                                                                                    case 14: //Kartu Keluarga
                                                                                        $linkBerkasUsulan5 = "<a href='http://103.14.229.15/simpeg/berkas/$asli' target='_blank'>Berkas Syarat Terupload</a>";
                                                                                        $tglUpload5 = $row3->created_date;
                                                                                        break;
                                                                                    case 52: //Daftar Gaji Pasangan PNS
                                                                                        $linkBerkasUsulan6 = "<a href='http://103.14.229.15/simpeg/berkas/$asli' target='_blank'>Berkas Syarat Terupload</a>";
                                                                                        $tglUpload6 = $row3->created_date;
                                                                                        break;
                                                                                }
                                                                                unset($ext);
                                                                            //}
                                                                        }
                                                                    }
                                                                }
                                                                ?>
                                                                <tr style="background-color: white;">
                                                                    <td style="width: 5%">1.</td>
                                                                    <td style="width: 50%;">Usulan / Pengantar OPD </td>
                                                                    <td style="width: 45%;">
                                                                        <?php if($idberkas1<>"" and $idberkas1<>"" and $idberkas1 <> -1 and isset($linkBerkasUsulan1)){
                                                                            echo "$linkBerkasUsulan1";
                                                                            echo "<small class=\"form-text text-muted\">";
                                                                            echo "<br>Upload : ".$tglUpload1."</small>";
                                                                        }else{
                                                                            echo 'Belum ada berkas';
                                                                        } ?>
                                                                    </td>
                                                                </tr>
                                                                <tr style="background-color: white;">
                                                                    <td>2.</td>
                                                                    <td>SKUM </td>
                                                                    <td>
                                                                        <?php if($idberkas2<>"" and $idberkas2<>"" and $idberkas2 <> -1 and isset($linkBerkasUsulan2)){
                                                                            echo "$linkBerkasUsulan2";
                                                                            echo "<small class=\"form-text text-muted\">";
                                                                            echo "<br>Upload : ".$tglUpload2."</small>";
                                                                        }else{
                                                                            echo 'Belum ada berkas';
                                                                        } ?>
                                                                    </td>
                                                                </tr>
                                                                <tr style="background-color: white;">
                                                                    <td>3.</td>
                                                                    <td>SK. Kenaikan Pangkat Terakhir </td>
                                                                    <td>
                                                                        <?php if($idberkas3<>"" and $idberkas3<>"" and $idberkas3 <> -1 and isset($linkBerkasUsulan3)){
                                                                            echo "$linkBerkasUsulan3";
                                                                            echo "<small class=\"form-text text-muted\">";
                                                                            echo "<br>Upload : ".$tglUpload3."</small>";
                                                                        }else{
                                                                            echo 'Belum ada berkas';
                                                                        } ?>
                                                                    </td>
                                                                </tr>
                                                                <tr style="background-color: white;">
                                                                    <td>4.</td>
                                                                    <td>Daftar Gaji Pegawai</td>
                                                                    <td>
                                                                        <?php if($idberkas4<>"" and $idberkas4<>"" and $idberkas4 <> -1 and isset($linkBerkasUsulan4)){
                                                                            echo "$linkBerkasUsulan4";
                                                                            echo "<small class=\"form-text text-muted\">";
                                                                            echo "<br>Upload : ".$tglUpload4."</small>";
                                                                        }else{
                                                                            echo 'Belum ada berkas';
                                                                        } ?>
                                                                    </td>
                                                                </tr>
                                                                <?php if((isset($pekerjaan_pasangan) and ($pekerjaan_pasangan=='pns' or $pekerjaan_pasangan=='pegawainegerisipil' or $pekerjaan_pasangan=='tni' or $pekerjaan_pasangan=='polri' or $pekerjaan_pasangan=='p n s')) or $jmlPasanganPNS > 0): ?>
                                                                    <tr style="background-color: white;">
                                                                        <td></td>
                                                                        <td>Daftar Gaji Pasangan / <br>Surat Keterangan Gaji (PNS / TNI / POLRI)</td>
                                                                        <td>
                                                                            <?php if($idberkas6<>"" and $idberkas6<>"" and $idberkas6 <> -1 and isset($linkBerkasUsulan6)){
                                                                                echo "$linkBerkasUsulan6";
                                                                                echo "<small class=\"form-text text-muted\">";
                                                                                echo "<br>Upload : ".$tglUpload6."</small>";
                                                                            }else{
                                                                                echo 'Belum ada berkas';
                                                                            } ?>
                                                                        </td>
                                                                    </tr>
                                                                <?php endif; ?>

                                                                <tr style="background-color: white;">
                                                                    <td>5.</td>
                                                                    <td>Kartu Keluarga </td>
                                                                    <td>
                                                                        <?php if($idberkas5<>"" and $idberkas5<>"" and $idberkas5 <> -1 and isset($linkBerkasUsulan5)){
                                                                            echo "$linkBerkasUsulan5";
                                                                            echo "<small class=\"form-text text-muted\">";
                                                                            echo "<br>Upload : ".$tglUpload5."</small>";
                                                                        }else{
                                                                            echo 'Belum ada berkas';
                                                                        } ?>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                            <?php if ($lsdata->idstatus_ptk == 2 or $lsdata->idstatus_ptk == 4 or $lsdata->idstatus_ptk == 5) : ?>
                                                                <form action="" method="post"
                                                                      id="frmAjukanPtk_<?php echo $lsdata->id_ptk; ?>"
                                                                      novalidate="novalidate">
                                                                    <input type="hidden" name="formNameEdit"
                                                                           value="<?php echo $lsdata->id_ptk; ?>"/>
                                                                    Catatan <textarea name="txtCatatan_<?php echo $lsdata->id_ptk; ?>"
                                                                                   id="txtCatatan_<?php echo $lsdata->id_ptk; ?>"
                                                                                   style="width: 100%;margin-bottom: 10px;resize: none"></textarea><br>
                                                                    <button id="btn_revisi" name="revisi" class="button warning"
                                                                            style="height: 30px;" type="submit" onclick="return confirm('Anda yakin akan merevisi permohonan ini?');"><span
                                                                            class="icon-arrow-left on-left"></span><strong>Revisi</strong>
                                                                    </button>
                                                                    <button id="btn_proses" name="proses" class="button primary"
                                                                            style="height: 30px;" type="submit" onclick="return confirm('Anda yakin akan memproses permohonan ini?');"><span
                                                                            class="icon-busy on-left"></span><strong>Dalam Proses</strong>
                                                                    </button>
                                                                    <button id="btn_setuju" name="setuju" class="button success"
                                                                            style="height: 30px;" type="submit" onclick="return confirm('Anda yakin akan menyetujui permohonan ini?');"><span
                                                                            class="icon-checkmark on-left"></span><strong>Disetujui</strong>
                                                                    </button>
                                                                    <button id="btn_tolak" name="tolak" class="button danger"
                                                                            style="height: 30px;" type="submit" onclick="return confirm('Anda yakin akan menolak permohonan ini?');"><span
                                                                            class="icon-cancel on-left"></span><strong>Ditolak</strong></button>
                                                                    <button id="btn_hanya_info" name="informasi" class="button info"
                                                                            style="height: 30px; margin-top: 5px;" type="submit" onclick="return confirm('Anda yakin akan memasukkan permohonan ini sebagai informasi saja?');"><span
                                                                                class="icon-checkmark on-left"></span><strong>Hanya Informasi</strong></button>
                                                                </form>
                                                                <div style="color: #8a8a8a; margin-bottom: 8px;"><strong>Note</strong>: Revisi hanya diperkenankan ubah berkas syarat yang terupload yaitu berkas Keluarga, SK pangkat terakhir, Daftar Gaji dan Kartu Keluarga</div>
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php if ($lsdata->idstatus_ptk == 5 or $lsdata->idstatus_ptk == 8) : ?>
                                        <div class="frames">
                                            <div class="frame" id="_page_2<?php echo $lsdata->id_ptk?>">
                                                <div class="grid" style="margin-top: -40px;margin-bottom: -25px;">
                                                    <div class="row">
                                                        <div class="span7">
                                                            <form action="" id="frmUbahPtk<?php echo $lsdata->id_ptk?>" novalidate="novalidate" enctype="multipart/form-data">
                                                                <div class="row" style="margin-top: 0px;padding-bottom: 15px;">
                                                                    <div class="span3">
                                                                        <input id="submitok" name="submitok" type="hidden" value="1">
                                                                        <input type="hidden" id="id_ptk<?php echo $lsdata->id_ptk; ?>" name="id_ptk<?php echo $lsdata->id_ptk; ?>" value="<?php echo $lsdata->id_ptk; ?>">
                                                                        <div class="input-control text" style="margin-top: 10px;">
                                                                            <label>Data Waktu Penerbitan</label>
                                                                            <input id="tglSkPtk<?php echo $lsdata->id_ptk; ?>" name="tglSkPtk<?php echo $lsdata->id_ptk; ?>" type="text" value="<?php echo ($lsdata->tgl_update_sk_ptk==''?'Belum ada':$lsdata->tgl_update_sk_ptk); ?>" readonly>
                                                                        </div>
                                                                        <div class="input-control text" style="margin-top: 10px;">
                                                                            <label>Nomor</label>
                                                                            <input id="nomorSkPtk<?php echo $lsdata->id_ptk; ?>" name="nomorSkPtk<?php echo $lsdata->id_ptk; ?>" type="text" value="<?php echo $lsdata->nomor_sk_ptk; ?>" required>
                                                                        </div>
                                                                        <div class="input-control text" style="margin-top: 12px;">
                                                                            <label>Sifat</label>
                                                                            <input id="sifatSkPtk<?php echo $lsdata->id_ptk; ?>" name="sifatSkPtk<?php echo $lsdata->id_ptk; ?>" type="text" value="<?php echo ($lsdata->sifat_sk_ptk==''?' Segera':$lsdata->sifat_sk_ptk); ?>" required>
                                                                        </div>
                                                                        <div class="input-control text" style="margin-top: 12px;">
                                                                            <label>Lampiran</label>
                                                                            <input id="lampPtk<?php echo $lsdata->id_ptk; ?>" name="lampPtk<?php echo $lsdata->id_ptk; ?>" type="text" value="<?php echo $lsdata->lampiran_sk_ptk; ?>" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="span4">
                                                                        <div class="input-control text" style="margin-top: 10px;margin-bottom: 40px;">
                                                                            <label>Pengesah</label>
                                                                            <table style="width: 100%; background-color: white;">
                                                                                <tr>
                                                                                    <td><input id="nipPengesah<?php echo $lsdata->id_ptk; ?>" name="nipPengesah<?php echo $lsdata->id_ptk; ?>"
                                                                                           type="text" value="" placeholder="Masukkan NIP"></td>
                                                                                <td><button id="btnCariNip" name="btnCariNip" type="button" class="button info" style="height: 33px; width: 105%" onclick="getInfoPegawai(<?php echo $lsdata->id_ptk; ?>);">
                                                                                        <span class="icon-search on-left"></span><strong>Cari</strong></button></td>
                                                                                </tr>
                                                                            </table>
                                                                        </div>
                                                                        <div id="divInfoPegawai<?php echo $lsdata->id_ptk; ?>">
                                                                                <?php if($lsdata->nip_pengesah!=''): ?><br>
                                                                                    <?php echo $lsdata->nama_pengesah; ?><br>
                                                                                    <?php echo $lsdata->nip_pengesah; ?><br>
                                                                                    <?php echo $lsdata->jabatan; ?><br>
                                                                                    Status : <?php echo $lsdata->flag_pensiun==0?'Aktif Bekerja':'Pensiun/Pindah'; ?>
                                                                                <?php else: ?>
                                                                                    <i>Belum ada data pengesah</i>
                                                                                <?php endif; ?>
                                                                            <input type="hidden" id="txtIdPegawaiPengesah<?php echo $lsdata->id_ptk; ?>"
                                                                                   name="txtIdPegawaiPengesah<?php echo $lsdata->id_ptk; ?>" value="<?php echo $lsdata->id_pegawai_pengesah; ?>">
                                                                        </div>
                                                                        <button id="btnregister" name="new_register" type="submit" class="button success" style="height: 34px; margin-top: 20px;">
                                                                            <span class="icon-floppy on-left"></span><strong>Simpan</strong></button>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                            <script>
                                                                $(function(){
                                                                    $("#frmUbahPtk<?php echo $lsdata->id_ptk?>").validate({
                                                                        ignore: "",
                                                                        rules: {
                                                                            nomorSkPtk<?php echo $lsdata->id_ptk; ?>: {
                                                                                required: true
                                                                            },
                                                                            sifatSkPtk<?php echo $lsdata->id_ptk; ?>: {
                                                                                required: true
                                                                            },
                                                                            lampPtk<?php echo $lsdata->id_ptk; ?>:{
                                                                                required: true
                                                                            },
                                                                            txtIdPegawaiPengesah<?php echo $lsdata->id_ptk; ?>: {
                                                                                required: true
                                                                            }
                                                                        },
                                                                        messages: {
                                                                            nomorSkPtk<?php echo $lsdata->id_ptk; ?>: {
                                                                                required: "Anda belum mengisi Nomor"
                                                                            },
                                                                            sifatSkPtk<?php echo $lsdata->id_ptk; ?>: {
                                                                                required: "Anda belum mengisi Sifat"
                                                                            },
                                                                            lampPtk<?php echo $lsdata->id_ptk; ?>: {
                                                                                required: "Anda belum mengisi Lampiran"
                                                                            },
                                                                            txtIdPegawaiPengesah<?php echo $lsdata->id_ptk; ?>: {
                                                                                required: "Anda belum menentukan pengesah"
                                                                            }
                                                                        },
                                                                        errorPlacement: function(error, element) {
                                                                            switch (element.attr("name")) {
                                                                                default:
                                                                                    error.insertAfter(element);
                                                                            }
                                                                        },
                                                                        submitHandler: function(form) {
                                                                            var nomorSkPtk = $("#nomorSkPtk<?php echo $lsdata->id_ptk; ?>").val();
                                                                            var sifatSkPtk = $("#sifatSkPtk<?php echo $lsdata->id_ptk; ?>").val();
                                                                            var lampPtk = $("#lampPtk<?php echo $lsdata->id_ptk; ?>").val();
                                                                            var id_ptk = $('#id_ptk<?php echo $lsdata->id_ptk; ?>').val();
                                                                            var idp_pengesah = $('#txtIdPegawaiPengesah<?php echo $lsdata->id_ptk; ?>').val();
                                                                            var data = new FormData();
                                                                            data.append('nomorSkPtk', nomorSkPtk);
                                                                            data.append('sifatSkPtk', sifatSkPtk);
                                                                            data.append('lampPtk', lampPtk);
                                                                            data.append('id_ptk', id_ptk);
                                                                            data.append('idp_pengesah', idp_pengesah);
                                                                            jQuery.ajax({
                                                                                url: "<?php echo base_url()?>index.php/ptk/update_data_ptk",
                                                                                data: data,
                                                                                cache: false,
                                                                                contentType: false,
                                                                                processData: false,
                                                                                type: 'POST',
                                                                                success: function(data){
                                                                                    if(data == '1') {
                                                                                        alert('Data sukses tersimpan');
                                                                                        //window.location.reload();
                                                                                    }else{
                                                                                        alert("Gagal mengubah data \n "+data);
                                                                                    }
                                                                                }
                                                                            });
                                                                        }
                                                                    });
                                                                });
                                                            </script>
                                                        </div>
                                                        <div class="span1" style="margin-left: -30px;"></div>
                                                        <div class="span4" style="margin-top: 10px;border-left: 1px solid #cdcfc7;padding-left: 20px;">
                                                            <div>
                                                                <?php if ($lsdata->idstatus_ptk == 5 or $lsdata->idstatus_ptk == 8) : ?>
                                                                    <div class="row">
                                                                        <div class="span6" style="vertical-align: top;">
                                                                            <?php if ($lsdata->id_berkas_ptk == 0 and $lsdata->id_berkas_ptk == '') {
                                                                                echo 'Belum ada File Surat Pengajuan PTK yang diupload : ';
                                                                            }else{
                                                                                $syaratBerkasLainnya = $this->ptk->cekBerkas($lsdata->id_berkas_ptk);
                                                                                if (isset($syaratBerkasLainnya)) {
                                                                                    $x = 1;
                                                                                    if(sizeof($syaratBerkasLainnya) > 0){
                                                                                        foreach ($syaratBerkasLainnya as $row4) {
                                                                                            $asli = basename($row4->file_name);
                                                                                            //$getcwd = substr(getcwd(),0,strlen(getcwd())-1);
                                                                                            error_reporting(0);
                                                                                            if (file_exists('ssh2.sftp://' . $sftp . '/var/www/html/simpeg/berkas/'.trim($asli))) {
                                                                                            //if(file_exists(str_replace("\\","/",$getcwd).'/berkas/'.trim($asli))){
                                                                                                $ext[] = explode(".",$asli);
                                                                                                $linkBerkasPtk = "<a href='http://103.14.229.15/simpeg/berkas/$asli' target='_blank' style='font-weight: bold;font-size: medium'>
                                                                                                Berkas Pengajuan PTK ke BPKAD Terupload</a>";
                                                                                                $tglUploadPtk = $row4->created_date;
                                                                                                unset($ext);
                                                                                                echo "$linkBerkasPtk";
                                                                                                echo "<small class=\"form-text text-muted\">";
                                                                                                echo "<br>Upload : ".$tglUploadPtk." oleh: ".$row4->nama."</small><br>";
                                                                                                echo "-----------------------------------------------------------------------------";
                                                                                            }else{
                                                                                                echo 'Belum ada File Surat Pengajuan PTK yang diupload (Data berkas sudah ada tapi file tidak ada).';
                                                                                            }
                                                                                            error_reporting(1);
                                                                                        }
                                                                                    }
                                                                                }
                                                                            }?>
                                                                            <br><a href='/simpeg2/ptk/cetak_sk_ptk/<?php echo $lsdata->id_ptk; ?>' target='_blank' class="button" style="background-color: #a47e3c; font-weight: bold; color: white;">Download Format Surat Pengajuan PTK ke BPKAD</a>
                                                                            <br><br><div class="panel-content"> Upload File Baru (Tipe PDF maks. 2 MB):
                                                                                <form action="" id="frmUploadPtk<?php echo $lsdata->id_ptk?>" novalidate="novalidate" enctype="multipart/form-data">
                                                                                    <input type="hidden" id="id_pegawai<?php echo $lsdata->id_ptk?>" name="id_pegawai<?php echo $lsdata->id_ptk?>" value="<?php echo $pegawai_pemohon; ?>"/>
                                                                                    <input type="hidden" id="nip<?php echo $lsdata->id_ptk?>" name="nip<?php echo $lsdata->id_ptk?>" value="<?php echo $lsdata->nip_baru; ?>"/>
                                                                                    <input type="hidden" id="id_ptk2<?php echo $lsdata->id_ptk; ?>" name="id_ptk2<?php echo $lsdata->id_ptk; ?>" value="<?php echo $lsdata->id_ptk; ?>">
                                                                                    <input type="file" id="fileSkPtk<?php echo $lsdata->id_ptk; ?>" name="fileSkPtk<?php echo $lsdata->id_ptk; ?>" accept=".pdf" /><br>
                                                                                    <div class="input-control text" style="margin-top: 5px;width: 75%;">
                                                                                    <input id="catatanPtk<?php echo $lsdata->id_ptk; ?>" name="catatanPtk<?php echo $lsdata->id_ptk; ?>" type="text" placeholder="Catatan" value="<?php echo $lsdata->approved_note; ?>"></div>
                                                                                    <br><button id="btnbtnupload" name="new_upload" type="submit" class="button info" style="height: 34px; margin-top: 0px;">
                                                                                        <span class="icon-upload on-left"></span><strong>Upload</strong></button>
                                                                                </form>
                                                                                <?php if($lsdata->idstatus_ptk == 8): ?>
                                                                                <button
                                                                                        name="btnWA<?php echo $lsdata->id_ptk; ?>"
                                                                                        id="btnWA<?php echo $lsdata->id_ptk; ?>"
                                                                                        class="btn btn-success btn-sm"
                                                                                        style="font-weight: bold; background-color: #57a957;color: white;height: 34px; margin-top: 0px;"><span class="icon-mail-2 on-left"></span>Kirim Pesan Via <strong>WhatsApp ChatAPI</strong></button>
                                                                                <script type="text/javascript">
                                                                                    $("#btnWA<?php echo $lsdata->id_ptk; ?>").click(function () {
                                                                                        //window.open('https://wa.me/<?php //echo($ponsel);?>?text=Yth.%20Bpk/Ibu%20Pegawai%20Pemkot%20Bogor%20Surat%20pengubahan%20tunjangan%20a.n%20<?php //echo $nama_pengusul; ?>%20ke%20BPKAD%20sudah%20tersedia,%20anda%20dapat%20mengunduhnya%20di%20akun simpeg%20anda atau Klik tautan http://arsipsimpeg.kotabogor.go.id/simpeg/berkas/<?php //echo $asli ?> untuk mengunduh. Terimakasih', '_blank');

                                                                                        $.post('https://eu14.chat-api.com/instance25721/message?token=32r2xt8sm5oxb5nx',
                                                                                        {
                                                                                            "phone": '<?php echo($ponsel);?>',
                                                                                            "body": "Yth. Bpk/Ibu Pegawai Pemkot Bogor Surat pengubahan tunjangan a.n <?php echo $nama_pengusul; ?> ke BPKAD sudah tersedia, anda dapat mengunduhnya di akun simpeg anda atau Klik tautan http://arsipsimpeg.kotabogor.go.id/simpeg/berkas/<?php echo $asli; ?> untuk mengunduh. Terimakasih"
                                                                                        },
                                                                                        function(data){
                                                                                            if(data.sent==true){
                                                                                                alert("Pesan WhatsApp terkirim");
                                                                                            }else{
                                                                                                alert("Pesan WhatsApp tidak terkirim");
                                                                                            }
                                                                                        });
                                                                                    });
                                                                                </script>

                                                                                    <button
                                                                                            name="btnWA2<?php echo $lsdata->id_ptk; ?>"
                                                                                            id="btnWA2<?php echo $lsdata->id_ptk; ?>"
                                                                                            class="btn btn-success btn-sm"
                                                                                            style="font-weight: bold; background-color: #57a957;color: white;height: 34px; margin-top: 5px;"><span class="icon-mail-2 on-left"></span>Kirim Pesan Via <strong>WhatsAppWeb Official</strong></button>
                                                                                    <script type="text/javascript">
                                                                                        $("#btnWA2<?php echo $lsdata->id_ptk; ?>").click(function () {
                                                                                            window.open('https://wa.me/<?php echo($ponsel);?>?text=Yth.%20Bpk/Ibu%20Pegawai%20Pemkot%20Bogor%20Surat%20pengubahan%20tunjangan%20a.n%20<?php echo $nama_pengusul; ?>%20ke%20BPKAD%20sudah%20tersedia,%20anda%20dapat%20mengunduhnya%20di%20akun simpeg%20anda atau Klik tautan http://arsipsimpeg.kotabogor.go.id/simpeg/berkas/<?php echo $asli ?> untuk mengunduh. Terimakasih', '_blank');

                                                                                        });
                                                                                    </script>
                                                                                <?php endif; ?>
                                                                                <script>
                                                                                    $(function(){
                                                                                        var filePtkSize<?php echo $lsdata->id_ptk?> = 0;
                                                                                        $('#fileSkPtk<?php echo $lsdata->id_ptk?>').bind('change', function() {
                                                                                            filePtkSize<?php echo $lsdata->id_ptk?> = this.files[0].size;
                                                                                        });
                                                                                        $("#frmUploadPtk<?php echo $lsdata->id_ptk?>").validate({
                                                                                            ignore: "",
                                                                                            submitHandler: function(form) {
                                                                                                var data2 = new FormData();
                                                                                                var id_ptk2 = $('#id_ptk2<?php echo $lsdata->id_ptk; ?>').val();
                                                                                                var id_pegawai = $('#id_pegawai<?php echo $lsdata->id_ptk; ?>').val();
                                                                                                var nip2 = '<?php echo $lsdata->nip_baru; ?>';
                                                                                                var catatan = $('#catatanPtk<?php echo $lsdata->id_ptk; ?>').val();

                                                                                                if(parseFloat(filePtkSize<?php echo $lsdata->id_ptk?>) > 2138471){
                                                                                                    alert('Ukuran file terlalu besar');
                                                                                                }else{
                                                                                                    if(parseFloat(filePtkSize<?php echo $lsdata->id_ptk?>) > 0) {
                                                                                                        jQuery.each(jQuery('#fileSkPtk<?php echo $lsdata->id_ptk?>')[0].files, function (i, file) {
                                                                                                            data2.append('fileSkPtk<?php echo $lsdata->id_ptk?>', file);
                                                                                                        });
                                                                                                    }
                                                                                                    data2.append('id_ptk', id_ptk2);
                                                                                                    data2.append('id_pegawai', id_pegawai);
                                                                                                    data2.append('nip', nip2);
                                                                                                    data2.append('catatan', catatan);
                                                                                                    jQuery.ajax({
                                                                                                        url: "<?php echo base_url()?>index.php/ptk/upload_sk_ptk",
                                                                                                        data: data2,
                                                                                                        cache: false,
                                                                                                        contentType: false,
                                                                                                        processData: false,
                                                                                                        type: 'POST',
                                                                                                        success: function(data) {
                                                                                                            if(data == '1') {
                                                                                                                alert('File sudah terupload dan SK Pengajuan ke BPKAD diterbitkan');
                                                                                                                window.location.reload();
                                                                                                            }else{
                                                                                                                alert(data);
                                                                                                            }
                                                                                                        }
                                                                                                    });
                                                                                                }
                                                                                            }
                                                                                        });
                                                                                    });
                                                                                </script>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                <?php endif; ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                Riwayat Status Pengajuan : <br>
                                <?php $hist_ptk_byid = $this->ptk->hist_ptk_byid($lsdata->id_ptk); ?>
                                <?php if (is_array($hist_ptk_byid) and sizeof($hist_ptk_byid) > 0): ?>
                                    <?php echo("<ul style='font-size: 10pt; margin-top: 0px;'>");
                                    foreach ($hist_ptk_byid as $row) {
                                        echo("<li>Status : $row->status_ptk Diproses oleh $row->nama tanggal $row->tgl_approve_hist catatan: $row->approved_note_hist </li>");
                                    }
                                    echo("</ul>");
                                    ?>
                                <?php else: ?>
                                    <i>Tidak ada data</i>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
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
    <?php if(isset($pgDisplay)): ?>
        <?php if($numpage > 0): ?>
            Halaman ke <?php echo $curpage; ?> dari <?php echo $numpage; ?> | Jumlah Data : <?php echo $total_items; ?> | <?php echo $jumppage; ?> | <?php echo $item_perpage; ?><br>
            <?php echo $pgDisplay; ?>
        <?php endif; ?>
    <?php endif; ?>
</div>

<script>

    $("#btn_tampilkan").click(function(){
        var opd = $('#ddFilterOpd').val();
        var jenis = $('#ddFilterJns').val();
        var status = $('#ddFilterStatus').val();
        var keywordCari = $("#keywordCari").val();
        if( typeof status == 'undefined' ) {
            status = 0;
        }
        loadDataListPtk(<?php echo $idproses?>,opd,jenis,status,keywordCari,'<?php echo isset($_GET['page'])?$_GET['page']:1; ?>');
    });

    function loadDataListPtk(idproses,idskpd,jenis,status,keywordCari,page){
        var ipp = $("#selIpp").val();
        location.href="<?php echo base_url()."ptk/list_pengajuan_ptk/" ?>"+idproses+"?page="+page+"&ipp="+ipp+"&idskpd="+idskpd+"&jenis="+jenis+"&status="+status+"&keywordCari="+keywordCari;
    }

    function getInfoPegawai(id_ptk){
        var nipCari = $("#nipPengesah"+id_ptk).val();
        $.ajax({
            method: "POST",
            url: "<?php echo base_url()?>index.php/ptk/info_pegawai",
            data: { nipCari: nipCari, id_ptk: id_ptk},
            dataType: "html"
        }).done(function( data ) {
            $("#divInfoPegawai"+id_ptk).html(data);
            $("#divInfoPegawai"+id_ptk).find("script").each(function(i) {
                //eval($(this).text());
            });
        });
    }

    function ubah_data_syarat_ptk(id_syarat, nama_berkas){
        $.ajax({
            method: "POST",
            url: "<?php echo base_url()?>index.php/ptk/window_ubah_data_ptk_syarat",
            data: { id_syarat: id_syarat, nama_berkas: nama_berkas },
            dataType: "html"
        }).done(function( data ) {
            $("#ubah_ptk_syarat").html(data);
            $("#ubah_ptk_syarat").find("script").each(function(i) {
                eval($(this).text());
            });
        });

        $.Dialog({
            shadow: true,
            overlay: false,
            icon: '<span class="icon-rocket"></span>',
            title: 'Informasi Syarat',
            width: 930,
            height: 550,
            padding: 10,
            content: "<div id='ubah_ptk_syarat' style='height:450px;overflow: auto;overflow-x: hidden; '>Loading...</div>"
        });
    }

    function lihat_data_keluarga(idp){
        $.ajax({
            method: "POST",
            url: "<?php echo base_url()?>index.php/ptk/list_data_keluarga",
            data: { idp: idp },
            dataType: "html"
        }).done(function( data ) {
            $("#list_data_keluarga").html(data);
            $("#list_data_keluarga").find("script").each(function(i) {
                eval($(this).text());
            });
        });

        $.Dialog({
            shadow: true,
            overlay: false,
            icon: '<span class="icon-rocket"></span>',
            title: 'Daftar Keluarga',
            width: 900,
            height: 550,
            padding: 10,
            content: "<div id='list_data_keluarga' style='height:450px;overflow: auto;overflow-x: hidden; '>Loading...</div>"
        });
    }
</script>
