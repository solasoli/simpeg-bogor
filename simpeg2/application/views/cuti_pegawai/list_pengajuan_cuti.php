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
        font: bold .7em Arial, Helvetica, sans-serif;
        padding: 2px 6px 2px 6px;
        cursor: default;
        background: #000080;
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
    <strong>DAFTAR PENGAJUAN CUTI <?php echo strtoupper($list_title) ?></strong>

    <div class="grid">
        <div class="row" style="margin-bottom: -10px;">
            <div class="span13">
                <span class="span4">
                    <?php if (isset($list_skpd)): ?>
                        <div class="input-control select" style="width: 100%;">
                            <select id="ddFilterOpd" style="background-color: #e3c800;">
                                <option value="0">Semua OPD</option>
                                <?php foreach ($list_skpd as $ls): ?>
                                    <?php if ($ls->id_unit_kerja == $idskpd): ?>
                                        <option value="<?php echo $ls->id_unit_kerja; ?>"
                                                selected><?php echo $ls->nama_baru; ?></option>
                                    <?php else: ?>
                                        <option
                                            value="<?php echo $ls->id_unit_kerja; ?>"><?php echo $ls->nama_baru; ?></option>
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
                                <option value="0">Semua Jenis Cuti</option>
                                <?php foreach ($list_jenis as $ls): ?>
                                    <?php if ($ls->id_jenis_cuti == $jenis): ?>
                                        <option value="<?php echo $ls->id_jenis_cuti; ?>"
                                                selected><?php echo $ls->deskripsi; ?></option>
                                    <?php else: ?>
                                        <option
                                            value="<?php echo $ls->id_jenis_cuti; ?>"><?php echo $ls->deskripsi; ?></option>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    <?php endif; ?>
                </span>

                <?php if ($list_status != ''): ?>
                    <span class="span3">
                        <div class="input-control select" style="width: 100%;">
                            <select id="ddFilterStatus" style="background-color: #e3c800;">
                                <option value="0">Semua Status Cuti</option>
                                <?php foreach ($list_status as $ls): ?>
                                    <?php if ($ls->idstatus_cuti == $status): ?>
                                        <option value="<?php echo $ls->idstatus_cuti; ?>"
                                                selected><?php echo $ls->status_cuti; ?></option>
                                    <?php else: ?>
                                        <option
                                            value="<?php echo $ls->idstatus_cuti; ?>"><?php echo $ls->status_cuti; ?></option>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </span>
                <?php endif; ?>

                <?php if ($idproses == 3): ?>
                    <span class="span3">
                        <div class="input-control select" style="width: 100%;">
                            <select id="ddFilterCekSK" style="background-color: #e3c800;">
                                <option value="0">Semua Status SK</option>
                                <option value="1" <?php echo($cek_sk == 1 ? 'selected' : ''); ?>>Sudah Upload SK Cuti
                                </option>
                                <option value="2" <?php echo($cek_sk == 2 ? 'selected' : ''); ?>>Belum Upload SK Cuti
                                </option>
                            </select>
                        </div>
                    </span>
                <?php endif; ?>

                <span class="span3">
                    <div class="input-control text">
                        <input id="keywordCari" type="text" value="<?php echo $keywordCari; ?>" placeholder="Kata kunci"
                               style="background-color: #e3c800;"/>
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
                <?php if (isset($pgDisplay)): ?>
                    <?php if ($numpage > 0): ?>
                        Halaman ke <?php echo $curpage; ?> dari <?php echo $numpage; ?> | Jumlah Data : <?php echo $total_items; ?> | <?php echo $jumppage; ?> | <?php echo $item_perpage; ?>
                        | <span style="font-family: Arial, Helvetica, sans-serif;font-size: .7em;">*Kata Kunci: NIP, Nama, Alamat, Jabatan</span>
                        <br><?php echo $pgDisplay; ?>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
            <div class="span5" style="margin-left: -50px;text-align: right;font-size:small">
                <?php if ($idproses == 2): ?>
                    <?php if (isset($recStatusExpire)): ?>
                        <?php foreach ($recStatusExpire as $ls): ?>
                            Aktual: <a href="#" onclick="hrefExpire(1)"><span
                                    style="color: green; font-weight: bold"><?php echo $ls->aktual; ?></span></a> |
                                                                                                                  Hampir Kadaluarsa:
                            <a href="#" onclick="hrefExpire(2)"><span
                                    style="color: darkorange; font-weight: bold"><?php echo $ls->hampir_kadaluarsa; ?></span></a> |
                                                                                                                                  Kadaluarsa :
                            <a href="#" onclick="hrefExpire(3)"><span
                                    style="color: red; font-weight: bold"><?php echo $ls->kadaluarsa; ?></span></a> |
                            <a href="#" onclick="hrefExpire(0)">Semua</a>
                        <?php endforeach; ?>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <table class="table bordered striped" id="lst_cuti">

        <?php if (is_array($list_cuti) && sizeof($list_cuti) > 0): ?>
            <?php $i = 1; ?>
            <?php if ($list_cuti != ''): ?>
                <?php foreach ($list_cuti as $lsdata): ?>
                    <thead style="border-bottom: solid #a4c400 2px;border-top: solid #000000 1px;">
                    <tr>
                        <th>No</th>
                        <th>Periode</th>
                        <th>Jenis</th>
                        <th style="width: 140px;">Tgl. Pengajuan</th>
                        <th style="width: 100px;">TMT. Awal</th>
                        <th style="width: 100px;">TMT. Akhir</th>
                        <th>Lama</th>
                        <th>Keterangan</th>
                        <th>Status</th>
                    </tr>
                    </thead>
                    <tr>
                        <td style="border-bottom: solid #666666 1px;"><?php echo $lsdata->no_urut; ?></td>
                        <td style="border-bottom: solid #666666 1px;"><?php echo $lsdata->periode_thn ?></td>
                        <td style="border-bottom: solid #666666 1px; font-weight: bold; color: saddlebrown">
                            <?php echo $lsdata->deskripsi ?><span style="font-weight: bold; color: darkorange;"><?php echo($lsdata->is_cuti_mundur==1?' <br>(Cuti Mundur)':'');?></span>
                        </td>
                        <td style="border-bottom: solid #666666 1px;"><?php echo $lsdata->tgl_usulan_cuti2 ?></td>
                        <td style="border-bottom: solid #666666 1px;"><?php echo $lsdata->tmt_awal_cuti ?></td>
                        <td style="border-bottom: solid #666666 1px;"><?php echo $lsdata->tmt_akhir_cuti ?></td>
                        <td style="border-bottom: solid #666666 1px;">
                            <?php echo (int)($lsdata->lama_cuti)+(int)($lsdata->lama_cuti_n1).' Hari '.((int)($lsdata->lama_cuti_n1)>0?'('.(int)$lsdata->periode_thn.': '.$lsdata->lama_cuti.', '.((int)$lsdata->periode_thn+1).': '.(int)$lsdata->lama_cuti_n1.')':''); ?>
                        </td>
                        <td style="border-bottom: solid #666666 1px;"><?php echo $lsdata->keterangan ?></td>
                        <td style="border-bottom: solid #666666 1px;"><?php echo $lsdata->status_cuti ?></td>
                    </tr>
                    <?php if ($idproses == 2 or $idproses == 3) : ?>
                        <tr>
                            <td style="border-bottom: solid #666666 1px;" colspan="2"></td>
                            <td colspan="7" style="border-bottom: solid #666666 1px;">
                                <form style="margin-bottom: -5px;" action="" id="frmUbahJenisCuti<?php echo $lsdata->id_cuti_master?>" novalidate="novalidate" enctype="multipart/form-data">
                                    <input type="hidden" id="id_cm_ed<?php echo $lsdata->id_cuti_master; ?>" name="id_cm_ed<?php echo $lsdata->id_cuti_master; ?>" value="<?php echo $lsdata->id_cuti_master; ?>">
                                    <?php if (isset($list_jenis)): ?>
                                        Ubah Jenis Cuti :
                                        <div class="input-control select" style="width: 25%;">
                                            <select id="ddFilterJnsEd<?php echo $lsdata->id_cuti_master; ?>">
                                                <?php foreach ($list_jenis as $ls): ?>
                                                    <?php if ($ls->id_jenis_cuti == $lsdata->id_jenis_cuti): ?>
                                                        <option value="<?php echo $ls->id_jenis_cuti; ?>"
                                                                selected><?php echo $ls->deskripsi; ?></option>
                                                    <?php else: ?>
                                                        <option
                                                                value="<?php echo $ls->id_jenis_cuti; ?>">
                                                            <?php echo $ls->deskripsi; ?></option>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <button id="btnregisterCutiEd" name="new_register" type="submit"
                                                onclick="return confirm('Anda yakin akan mengubah jenis cuti ini?');">
                                            <span class="icon-floppy on-left" style="margin-left: 0px;"></span></button>
                                    <?php endif; ?>
                                </form>
                                <script>
                                    $(function(){
                                        $("#frmUbahJenisCuti<?php echo $lsdata->id_cuti_master?>").validate({
                                            ignore: "",
                                            rules: {},
                                            messages: {},
                                            errorPlacement: function(error, element) {},
                                            submitHandler: function(form) {
                                                var ddFilterJnsEd = $("#ddFilterJnsEd<?php echo $lsdata->id_cuti_master; ?>").val();
                                                var id_cm_ed = $('#id_cm_ed<?php echo $lsdata->id_cuti_master; ?>').val();
                                                var data = new FormData();
                                                data.append('ddFilterJnsEd', ddFilterJnsEd);
                                                data.append('id_cm_ed', id_cm_ed);
                                                jQuery.ajax({
                                                    url: "<?php echo base_url()?>index.php/cuti_pegawai/update_jenis_cuti",
                                                    data: data,
                                                    cache: false,
                                                    contentType: false,
                                                    processData: false,
                                                    type: 'POST',
                                                    success: function(data){
                                                        if(data == '1') {
                                                            alert('Data sukses tersimpan');
                                                            window.location.reload();
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
                        </tr>
                    <?php endif; ?>
                    <tr style="background-color: white">
                        <td></td>
                        <td colspan="8">
                            <h3 style="color: #002a80;"><?php echo $lsdata->nama; ?></h3>

                            <button class="button" id="tambahRole<?php echo $i; ?>">Riwayat Cuti</button>
	<?php
	$teks="";
	$h=1;
	$riwayatcuti= $this->cuti_pegawai_model->getriwayatcuti($lsdata->id_pegawai);
	foreach ($riwayatcuti as $rc)
	{
	$teks=$teks."$h $rc->deskripsi $rc->tmt_awal $rc->lama_cuti Hari <br>";

	$h++;
	}
    $ponsel = $this->cuti_pegawai_model->getPonsel($lsdata->id_pegawai);
	$nama_pengusul = $lsdata->nama;
	 ?>
	<script>
		$(function(){
			$("#tambahRole<?php echo $i; ?>").on('click', function(){
                            $.Dialog({
                                overlay: true,
                                shadow: true,
                                flat: true,
                                draggable: true,
                                //icon: '<img src="images/excel2013icon.png">',
                                //title: 'Flat window',
                                content: '',
                                padding: 10,
                                onShow: function(_dialog){
                                    var content = ' <?php echo $teks; ?> ';

                                    $.Dialog.title("Riwayat Cuti");
                                    $.Dialog.content(content);
                                }
                            });
                        });
			$("#editRole").on('click',function(e){
				var isi = document.getElementById();
			});
		});
		$(function(){
			$('#role_list').dataTable();
		});
	</script>
                    <br />

                            NIP : <?php echo $lsdata->nip_baru; ?> <strong>|</strong>
                            Pangkat : <?php echo $lsdata->pangkat . ', ' . $lsdata->last_gol; ?> <strong>|</strong>
                            Unit Kerja : <?php echo $lsdata->last_unit_kerja; ?> <strong>|</strong>
                            Ponsel : <?php echo $ponsel; ?> <br>
                            <?php //if($lsdata->id_status_cuti == 12): ?>
                            <strong>Keterangan : </strong><br>
                            <span style="color:saddlebrown;">Alasan Cuti :
                                <?php
                                    if($lsdata->is_kunjungan_luar_negeri==1){
                                        echo "Kunjungan ke Luar Negeri. Keterangan Lain: ";
                                    }

                                    if($lsdata->id_jenis_cuti=='C_SAKIT'){
                                        $sqlSkt = " SELECT cjs.jenis_cuti_sakit, CASE WHEN cs.idjenis_cuti_sakit = 1 THEN (CASE WHEN cs.flag_sakit_baru = 1 THEN 'Usulan Baru' ELSE 'Usulan Perpanjangan' END) ELSE NULL END AS flag
                                                    FROM cuti_sakit cs, cuti_jenis_sakit cjs
                                                    WHERE cs.id_cuti_master = ".$lsdata->id_cuti_master." AND cs.idjenis_cuti_sakit = cjs.idjenis_cuti_sakit";
                                        $qSkt = $this->db->query($sqlSkt);
                                        foreach ($qSkt->result() as $row){
                                            $jnsSkt = $row->jenis_cuti_sakit;
                                            $flag = $row->flag;
                                        }
                                        echo $jnsSkt.($flag==''?'':' ('.$flag.').').' Keterangan Lain : '.$lsdata->alasan_cuti;
                                    }elseif($lsdata->id_jenis_cuti=='C_BESAR' or $lsdata->id_jenis_cuti=='C_ALASAN_PENTING' or $lsdata->id_jenis_cuti=='CLTN') {
                                        $sqlNonSkt = "SELECT * FROM simpeg.cuti_jenis_non_sakit WHERE kode_sub_jenis_cuti_nonsakit = '" . $lsdata->sub_jenis_cuti . "'";
                                        //echo $sqlNonSkt;
                                        $qNSkt = $this->db->query($sqlNonSkt);
                                        foreach ($qNSkt->result() as $row) {
                                            $jnsNSkt = $row->jenis_cuti_nonsakit;
                                        }
                                        echo $jnsNSkt . '.'.' Keterangan Lain : '.$lsdata->alasan_cuti;
                                    }else{
                                        echo $lsdata->alasan_cuti.'. ';
                                    }
                                ?>
                                <br>Pertimbangan Atasan Langsung : <?php echo $lsdata->sts_keputusan_atsl.' ('.$lsdata->alasan_pertimbangan_atsl.').'.
                                    ' Keputusan Pejabat Berwenang : '.$lsdata->sts_keputusan_pjbt.' ('.$lsdata->alasan_keputusan_pjbt.')'; ?></span> <br>
                            <?php //endif; ?>
                            <strong>Atasan Langsung : </strong><br>
                            <?php echo $lsdata->last_atsl_nama . " (" . $lsdata->last_atsl_nip . ")"; ?> <br>
                            Gol. <?php echo $lsdata->last_atsl_gol; ?>. Jabatan
                            : <?php echo $lsdata->last_atsl_jabatan; ?>
                            <br>
                            <strong>Pejabat Berwenang : </strong><br>
                            <?php echo $lsdata->last_pjbt_nama . " (" . $lsdata->last_pjbt_nip . ")"; ?> <br>
                            Gol. <?php echo $lsdata->last_pjbt_gol; ?>. Jabatan
                            : <?php echo $lsdata->last_pjbt_jabatan; ?>
                            <br>
                            <strong>Tgl. Update Status : </strong><?php echo $lsdata->tgl_approve_status2; ?> | Oleh
                            : <?php echo $lsdata->nama_approved . " (" . $lsdata->nip_baru_approved . ")"; ?> | Catatan
                            Akhir : <?php echo($lsdata->approved_note == "" ? "-" : $lsdata->approved_note); ?><br/>
                            Runut Status Pengajuan : <br>
                            <?php $hist_cuti_byid = $this->cuti_pegawai_model->hist_cuti_byid($lsdata->id_cuti_master); ?>
                            <?php if (isset($hist_cuti_byid) and sizeof($hist_cuti_byid) > 0): ?>
                                <?php echo("<ul style='font-size: 10pt; margin-top: 0px;'>");
                                foreach ($hist_cuti_byid as $row) {
                                    echo("<li>Status : $row->status_cuti Diproses oleh $row->nama tanggal $row->tgl_approve_hist catatan: $row->approved_note_hist </li>");
                                }
                                echo("</ul>");
                                ?>
                            <?php else: ?>
                                <i>Tidak ada data</i>
                            <?php endif; ?>

                            <?php if ($lsdata->id_status_cuti == 2 or $lsdata->id_status_cuti == 3 or $lsdata->id_status_cuti == 5
                                or $lsdata->id_status_cuti == 6 or $lsdata->id_status_cuti == 10 or $lsdata->id_status_cuti == 12) : ?>
                                <table width="100%" border="0" align="center" style="border-radius:5px;"
                                       class="table table-bordered table-striped">
                                    <tr>
                                        <td width="25%">
                                            <?php
                                            if ($lsdata->idberkas_surat_cuti == 0) {
                                                echo "<div id='spnInfo' style='color: white; background-color: #b12318; font-weight: bold; padding: 3px; width: 100%; text-align: center;'>Belum ada surat permohonan cuti yang diupload</div>";
                                            } else {
                                                $cekBerkas = $this->cuti_pegawai_model->cekBerkas($lsdata->idberkas_surat_cuti);
                                                if (isset($cekBerkas)) {
                                                    foreach ($cekBerkas as $row) {
                                                        $fname = pathinfo($row->file_name);
                                                        ?>
                                                        <button type="button"
                                                               name="btnCetakSuratCutiUploaded<?php echo $lsdata->id_cuti_master; ?>"
                                                               id="btnCetakSuratCutiUploaded<?php echo $lsdata->id_cuti_master; ?>"
                                                               class="btn btn-primary btn-sm"
                                                               style="font-weight: bold;color: blue; width: 100%;"><span class="icon-download on-left"></span> Lihat Surat Permohonan</button>
                                                        <script type="text/javascript">
                                                            $("#btnCetakSuratCutiUploaded<?php echo $lsdata->id_cuti_master; ?>").click(function () {
                                                                window.open('http://103.14.229.15/simpeg/berkas/<?php echo $row->file_name ?>', '_blank');
                                                            });
                                                        </script><br>
                                                        Tgl.Upload: <?php echo $row->created_date; ?> <br>
                                                        Oleh : <?php echo $row->nama; ?>
                                                        <?php
                                                    }
                                                } else {
                                                    echo "<div id='spnInfo' style='color: white; background-color: #b12318; font-weight: bold; padding: 3px; width: 100%; text-align: center;'>Belum ada surat permohonan cuti yang diupload</div>";
                                                }
                                            }

                                            if(($lsdata->id_jenis_cuti=='C_SAKIT') or
                                            ($lsdata->id_jenis_cuti=='C_BESAR' and
                                                $lsdata->sub_jenis_cuti=='cut_besar_agama') or
                                            ($lsdata->id_jenis_cuti=='C_ALASAN_PENTING' and
                                                ($lsdata->sub_jenis_cuti=='cut_penting_keluarga' or
                                                    $lsdata->sub_jenis_cuti=='cut_penting_kelahiran' or
                                                    $lsdata->sub_jenis_cuti=='cut_penting_musibah' or
                                                    $lsdata->sub_jenis_cuti=='cut_penting_rawan')) or
                                            ($lsdata->id_jenis_cuti=='CLTN')) {
                                                if ($lsdata->id_berkas_lampiran == 0) {
                                                    echo "<div id='spnInfo' style='color: white; background-color: #b12318; font-weight: bold; padding: 3px; width: 100%; text-align: center;'>Belum ada lampiran lainnya yang diupload</div>";
                                                }else{
                                                    $cekBerkas = $this->cuti_pegawai_model->cekBerkas($lsdata->id_berkas_lampiran);
                                                    if (isset($cekBerkas)) {
                                                        foreach ($cekBerkas as $row) {
                                                            $fname = pathinfo($row->file_name);
                                                            ?>
                                                            <button type="button"
                                                                   name="btnCetakLampiranUploaded<?php echo $lsdata->id_cuti_master; ?>"
                                                                   id="btnCetakLampiranUploaded<?php echo $lsdata->id_cuti_master; ?>"
                                                                   class="btn btn-primary btn-sm"
                                                                    style="font-weight: bold;color: blue;width: 100%;"><span class="icon-download on-left"></span> Lihat Surat Lampiran</button>
                                                            <script type="text/javascript">
                                                                $("#btnCetakLampiranUploaded<?php echo $lsdata->id_cuti_master; ?>").click(function () {
                                                                    window.open('http://103.14.229.15/simpeg/berkas/<?php echo $row->file_name ?>', '_blank');
                                                                });
                                                            </script><br>
                                                            Tgl.Upload: <?php echo $row->created_date; ?> <br>
                                                            Oleh : <?php echo $row->nama; ?>
                                                            <?php
                                                        }
                                                    } else {
                                                        echo "<div id='spnInfo' style='color: white; background-color: #b12318; font-weight: bold; padding: 3px; width: 100%; text-align: center;'>Belum ada surat lampiran lainnya yang diupload</div>";
                                                    }
                                                }
                                            }

                                            ?>
                                        </td>
                                        <?php if ($lsdata->id_status_cuti == 3 or $lsdata->id_status_cuti == 5 or $lsdata->id_status_cuti == 6
                                        or $lsdata->id_status_cuti == 10 or $lsdata->id_status_cuti == 12) : ?>
                                        <td width="80%" colspan="2">
                                            <form action="" method="post"
                                                  id="frmAjukanCuti_<?php echo $lsdata->id_cuti_master; ?>"
                                                  novalidate="novalidate" style="margin-bottom: -5px;">
                                                <table>
                                                    <tr>
                                                        <td width="35%">
                                                            <div class="input-control text" style="margin: -10px;">
                                                                <table style="width: 100%;">
                                                                    <tr>
                                                                        <td><input
                                                                                id="nipPengesah<?php echo $lsdata->id_cuti_master; ?>"
                                                                                name="nipPengesah<?php echo $lsdata->id_cuti_master; ?>"
                                                                                type="text" value=""
                                                                                placeholder="NIP Pengesah"
                                                                                style="width: 105%;">
                                                                        </td>
                                                                        <td>
                                                                            <button id="btnCariNip" name="btnCariNip"
                                                                                    type="button" class="button info"
                                                                                    style="height: 29px;margin-right: -30px;"
                                                                                    onclick="getInfoPegawai(<?php echo $lsdata->id_cuti_master; ?>);">
                                                                                <span
                                                                                    class="icon-search on-left"></span>
                                                                                <strong>Cari</strong></button>
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                                <div
                                                                    id="divInfoPegawaiPengesah<?php echo $lsdata->id_cuti_master; ?>"
                                                                    style="margin-left: 10px;">
                                                                    <?php

                                                                    if ($lsdata->id_pegawai_pengesah == '') {
                                                                        $dataRowPengesah = $this->cuti_pegawai_model->getPengesah($lsdata->id_cuti_master);
                                                                    } else {
                                                                        $dataRowPengesah = $this->cuti_pegawai_model->getPengesahById($lsdata->id_pegawai_pengesah);
                                                                    }
                                                                    foreach ($dataRowPengesah as $data) {
                                                                        $idp_pengesah = $data->id_pegawai;
                                                                        $nip = $data->nip_baru;
                                                                        $nama = $data->nama;
                                                                        $jabatan = $data->jabatan;
                                                                    }
                                                                    echo '<strong>' . $nama . '</strong>' . '<br>' . $nip . '<br>' . $jabatan;
                                                                    ?>
                                                                    <input type="hidden"
                                                                           id="txtIdPegawaiPengesah_<?php echo $lsdata->id_cuti_master; ?>"
                                                                           name="txtIdPegawaiPengesah_<?php echo $lsdata->id_cuti_master; ?>"
                                                                           value="<?php echo $idp_pengesah; ?>">
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td width="45%">
                                                            <input type="hidden" name="formNameEdit"
                                                                   value="<?php echo $lsdata->id_cuti_master; ?>"/>
                                                            <?php if ($idproses == 2 or ($idproses == 3 and $lsdata->idberkas_sk_cuti > 0)) : ?>
                                                                <div class="input-control select">
                                                                    <select name="ddCatatan_<?php echo $lsdata->id_cuti_master; ?>" id="ddCatatan_<?php echo $lsdata->id_cuti_master; ?>">
                                                                        <?php if ($idproses == 2) : ?>
                                                                            <option value="Dalam proses penandatanganan">Dalam proses penandatanganan</option>
                                                                        <?php endif; ?>
                                                                        <?php if ($idproses == 3 and $lsdata->idberkas_sk_cuti > 0) : ?>
                                                                            <option value="Surat Cuti dapat diunduh">Surat Cuti dapat diunduh</option>
                                                                        <?php endif; ?>
                                                                        <option value="Lainnya">Lainnya</option>
                                                                    </select>
                                                                </div>
                                                            <?php endif; ?>
                                                            <input
                                                                name="txtCatatan_<?php echo $lsdata->id_cuti_master; ?>"
                                                                id="txtCatatan_<?php echo $lsdata->id_cuti_master; ?>"
                                                                type="text" style="width: 100%;margin-bottom: 5px;"
                                                                value="" placeholder="Catatan"/><br>
                                                            <?php if ($idproses == 2 or ($idproses == 3 and $lsdata->idberkas_sk_cuti > 0)) : ?>
                                                                <script>
                                                                    $('#txtCatatan_<?php echo $lsdata->id_cuti_master; ?>').attr("readonly", true);
                                                                    $("#ddCatatan_<?php echo $lsdata->id_cuti_master; ?>").on('change', function() {
                                                                        if ($(this).val() == 'Lainnya'){
                                                                            $('#txtCatatan_<?php echo $lsdata->id_cuti_master; ?>').attr("readonly", false);
                                                                            $('#txtCatatan_<?php echo $lsdata->id_cuti_master; ?>').val('');
                                                                        } else {
                                                                            $('#txtCatatan_<?php echo $lsdata->id_cuti_master; ?>').attr("readonly", true);
                                                                            $('#txtCatatan_<?php echo $lsdata->id_cuti_master; ?>').val('');
                                                                        }
                                                                    });
                                                                </script>
                                                            <?php endif; ?>
                                                            <button id="btn_revisi" name="revisi" class="button warning"
                                                                    style="height: 30px;margin-bottom: 5px;" type="button"
                                                                    onclick="revisi_cuti(<?php echo $lsdata->id_cuti_master; ?>, '<?php echo($ponsel);?>')"><span
                                                                    class="icon-arrow-left on-left"></span><strong>Revisi</strong>
                                                            </button>

                                                            <button id="btn_proses" name="sembunyi" class="button primary"
                                                                    style="height: 30px;margin-bottom: 5px;" type="submit"
                                                                    onclick="return confirm('Anda yakin akan menyembunyikan permohonan ini?');"><span
                                                                    class="icon-cancel on-left"></span><strong>Sembunyikan</strong>
                                                            </button>

                                                            <button id="btn_proses" name="proses" class="button primary"
                                                                    style="height: 30px; margin-bottom: 5px;" type="submit"
                                                                    onclick="return confirm('Anda yakin akan memproses permohonan ini?');"><span
                                                                    class="icon-busy on-left"></span><strong>Dalam
                                                                    Proses</strong>
                                                            </button>
                                                            <button id="btn_setuju" name="setuju" class="button success"
                                                                    style="height: 30px; margin-bottom: 5px;" type="submit"
                                                                    onclick="return confirm('Anda yakin akan menyetujui permohonan ini?');"><span
                                                                    class="icon-checkmark on-left"></span><strong>Disetujui</strong>
                                                            </button>
                                                            <button id="btn_tolak" name="tolak" class="button danger"
                                                                    style="height: 30px; margin-bottom: 5px;" type="submit"
                                                                    onclick="return confirm('Anda yakin akan menolak permohonan ini?');"><span
                                                                    class="icon-cancel on-left"></span><strong>Ditolak</strong>
                                                            </button>
                                                            <?php if ($lsdata->id_status_cuti == 6) { ?>
                                                                <button id="btn_hapus" name="hapus" class="button"
                                                                        style="height: 30px; background-color: #57169a; color: white;margin-bottom: 5px;"
                                                                        type="submit"
                                                                        onclick="return confirm('Anda yakin akan menghapus permohonan ini?');">
                                                                    <span class="icon-remove on-left"></span>
                                                                    <strong>Hapus</strong></button>
                                                            <?php } ?>
                                                            <?php if ($lsdata->idberkas_sk_cuti > 0) { ?>
                                                                <button id="btn_kirim_sk_cuti" name="kirim_sk"
                                                                        class="button"
                                                                        style="height: 30px; background-color: #8b5a98; color: white;margin-bottom: 5px;"
                                                                        type="submit"><span
                                                                        class="icon-arrow-right on-left"></span>
                                                                    <strong>Kirim SK Cuti</strong></button>
                                                            <?php } ?>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </form>
                                        </td>
                                    </tr>
                                    <?php if ($lsdata->id_status_cuti == 6 or $lsdata->id_status_cuti == 10) : ?>
                                    <tr>
                                        <td width="20%">
                                            <input type="button"
                                                   name="btnCetakSKCuti<?php echo $lsdata->id_cuti_master; ?>"
                                                   id="btnCetakSKCuti<?php echo $lsdata->id_cuti_master; ?>"
                                                   class="btn btn-success btn-sm"
                                                   value="Download SK Cuti" style="font-weight: bold;width: 100%;"/>
                                            <script type="text/javascript">
                                                $("#btnCetakSKCuti<?php echo $lsdata->id_cuti_master; ?>").click(function () {
                                                    window.open('/simpeg2/cuti_pegawai/cetak_sk_cuti/<?php echo $lsdata->id_cuti_master; ?>', '_blank');
                                                });
                                            </script>
                                            <input type="button"
                                                   name="btnCetakSKCutiTTE<?php echo $lsdata->id_cuti_master; ?>"
                                                   id="btnCetakSKCutiTTE<?php echo $lsdata->id_cuti_master; ?>"
                                                   class="button primary"
                                                   value="Download SK Cuti TTE" style="font-weight: bold;width: 100%;"/>
                                            <script type="text/javascript">
                                            $("#btnCetakSKCutiTTE<?php echo $lsdata->id_cuti_master; ?>").click(function () {

                                              $.Dialog({
                                                  overlay: true,
                                                  shadow: true,
                                                  flat: true,
                                                  draggable: true,
                                                          //icon: '<img src="images/excel2013icon.png">',
                                                                      //title: 'Flat window',
                                                  content: '',
                                                  padding: 10,
                                                  onShow: function(_dialog){
                                                      var content = '<form class="user-input span6" action="<?php echo base_url('cuti_pegawai/cetak_sk_cuti_tte')?>" method="post" >' +
                                                      '<div class="input-control text">'+
                                                      '<label>No SK :</label>'+
                                                      '<input  type="text" name="no_sk" id="no_sk" />'+
                                                      '<label>Tgl SK :</label>'+
                                                      '<input  type="text" name="tgl_sk" id="tgl_sk" />'+
                                                      '<input  type="hidden" name="id_cuti_master" id="id_cuti_master" value="<?php echo $lsdata->id_cuti_master; ?>"/>'+
                                                      '<div class="form-actions">' +
                                                      '<button class="button primary">Simpan</button>&nbsp;'+
                                                      '<button class="button" type="button" onclick="$.Dialog.close()">Cancel</button> '+
                                                      '</div>'+
                                                      '</form>';

                                                      $.Dialog.title("DATA SK");
                                                      $.Dialog.content(content);
                                                  }
                                              });


                                            });
                                             $.Dialog.close();
                                        </script>
                                        </td>
                                        <td width="30%">
                                            <?php
                                            if ($lsdata->idberkas_sk_cuti == 0) {
                                                echo "<div id='spnInfoSK' style='color: white; background-color: #b12318; font-weight: bold; padding: 3px; width: 100%; text-align: center;'>Belum ada SK Cuti yang diupload </div>";
                                            } else {
                                                $cekBerkas = $this->cuti_pegawai_model->cekBerkas($lsdata->idberkas_sk_cuti);
                                                if (isset($cekBerkas)) {
                                                    foreach ($cekBerkas as $row) {
                                                        $fname = pathinfo($row->file_name);
                                                        ?>
                                                        <input type="button"
                                                               name="btnCetakSKCutiUploaded<?php echo $lsdata->id_cuti_master; ?>"
                                                               id="btnCetakSKCutiUploaded<?php echo $lsdata->id_cuti_master; ?>"
                                                               class="btn btn-primary btn-sm"
                                                               value="Lihat SK Cuti Terupload"
                                                               style="font-weight: bold;width: 100%; background-color: #57a957;color: white;"/>
                                                        <script type="text/javascript">
                                                            $("#btnCetakSKCutiUploaded<?php echo $lsdata->id_cuti_master; ?>").click(function () {
                                                                window.open('https://arsipsimpeg.kotabogor.go.id/simpeg2/Berkas/<?php echo $row->file_name ?>', '_blank');
                                                            });
                                                        </script><br>
                                                        Tgl.Upload: <?php echo $row->created_date; ?> <br>
                                                        Oleh : <?php echo $row->nama; ?>
                                                        <button
                                                               name="btnWA<?php echo $lsdata->id_cuti_master; ?>"
                                                               id="btnWA<?php echo $lsdata->id_cuti_master; ?>"
                                                               class="btn btn-success btn-sm"
                                                               style="font-weight: bold;width: 100%; background-color: #57a957;color: white;"><span class="icon-mail-2 on-left"></span>Kirim Pesan Via <strong>WhatsApp ChatAPI</strong></button>
                                                        <script type="text/javascript">
                                                            $("#btnWA<?php echo $lsdata->id_cuti_master; ?>").click(function () {
                                                                //window.open("https://wa.me/<?php //echo($ponsel);?>?text=Yth.%20Bpk/Ibu%20Pegawai%20Pemkot%20Bogor%20Surat%20Cuti%20a.n.%20<?php //echo stripslashes($nama_pengusul);?>%20sudah%20tersedia,%20anda%20dapat%20mengunduhnya%20di%20akun simpeg%20anda atau Klik tautan http://arsipsimpeg.kotabogor.go.id/simpeg2/Berkas/<?php //echo $row->file_name ?> untuk mengunduh. Terimakasih", '_blank');

                                                                $.post('https://eu14.chat-api.com/instance25721/message?token=32r2xt8sm5oxb5nx',
                                                                {
                                                                    "phone": '<?php echo($ponsel);?>',
                                                                    "body": "Yth. Bpk/Ibu Pegawai Pemkot Bogor Surat cuti a.n. <?php echo stripslashes($nama_pengusul);?> sudah tersedia, anda dapat mengunduhnya di akun simpeg anda atau Klik tautan http://arsipsimpeg.kotabogor.go.id/simpeg2/Berkas/<?php echo $row->file_name ?> untuk mengunduh. Terimakasih"
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
                                                                name="btnWA2<?php echo $lsdata->id_cuti_master; ?>"
                                                                id="btnWA2<?php echo $lsdata->id_cuti_master; ?>"
                                                                class="btn btn-success btn-sm"
                                                                style="font-weight: bold;width: 100%; background-color: #57a957;color: white; margin-top: 5px;"><span class="icon-mail-2 on-left"></span>Kirim Pesan Via <strong>WhatsAppWeb Official</strong></button>
                                                        <script type="text/javascript">
                                                            $("#btnWA2<?php echo $lsdata->id_cuti_master; ?>").click(function () {
                                                                window.open("https://wa.me/<?php echo($ponsel);?>?text=Yth.%20Bpk/Ibu%20Pegawai%20Pemkot%20Bogor%20Surat%20Cuti%20a.n.%20<?php echo stripslashes($nama_pengusul);?>%20sudah%20tersedia,%20anda%20dapat%20mengunduhnya%20di%20akun simpeg%20anda atau Klik tautan http://arsipsimpeg.kotabogor.go.id/simpeg2/Berkas/<?php echo $row->file_name ?> untuk mengunduh. Terimakasih", '_blank');
                                                            });
                                                        </script>
                                                        <?php
                                                    }
                                                } else {
                                                    echo "<div id='spnInfoSK' style='color: white; background-color: #b12318; font-weight: bold; padding: 3px; width: 100%; text-align: center;'>Belum ada SK Cuti yang diupload</div>";
                                                }
                                            }

                                            // sk cuti tte
                                            $cekBerkasTTE = $this->cuti_pegawai_model->cekBerkas($lsdata->idberkas_sk_cuti_tte);
                                            if(isset($cekBerkasTTE)){
                                              foreach ($cekBerkasTTE as $rowtte) {
                                              ?>
                                                <input type="button"
                                                       name="btnCetakSKCutiUploadedTte<?php echo $lsdata->id_cuti_master; ?>"
                                                       id="btnCetakSKCutiUploadedTte<?php echo $lsdata->id_cuti_master; ?>"
                                                       class="btn btn-primary btn-sm"
                                                       value="Lihat SK Cuti TTE"
                                                       style="font-weight: bold;width: 100%; background-color: #57a957;color: white;"/>
                                                <script type="text/javascript">
                                                    $("#btnCetakSKCutiUploadedTte<?php echo $lsdata->id_cuti_master; ?>").click(function () {
                                                        window.open('https://arsipsimpeg.kotabogor.go.id/simpeg2/berkas_tte/<?php echo $rowtte->file_name ?>', '_blank');
                                                    });
                                                </script>
                                              <?php
                                              }
                                            }

                                            ?>
                                        </td>
                                        <td width="50%">
                                            <?php
                                            if ($lsdata->idberkas_sk_cuti == 0){
                                            ?>
                                            <span>
                                        <i class="icon-plus"></i>
                                        <span>Upload Baru SK Cuti (format file harus pdf)</span>
                                                <!-- The file input field used as target for the file upload widget -->
                                        <div class="input-control file">
                                            <input id="file_cuti_<?php echo $lsdata->id_cuti_master; ?>"
                                                   type="file" name="files[]" multiple/>
                                            <button class="btn-file"></button>
                                        </div>
                                        <input type="hidden"
                                               name="surat_sk_cuti<?php echo $lsdata->id_cuti_master; ?>"
                                               id="surat_sk_cuti<?php echo $lsdata->id_cuti_master; ?>"/>
                                        </span>

                                            <div id="<?php echo 'progress_' . $lsdata->id_cuti_master; ?>"
                                                 class="progress-bar primary" style="margin-top: -5px;">
                                                <div class="progress-bar progress-bar-primary">
                                                    <script type="text/javascript">
                                                        $(function () {
                                                            var pbCuti = $('#<?php echo 'progress_' . $lsdata->id_cuti_master; ?>').progressbar();
                                                            var progress = 0;
                                                            var <?php echo 'url_'.$lsdata->id_cuti_master; ?> =
                                                            window.location.hostname === 'blueimp.github.io' ?
                                                                '//jquery-file-upload.appspot.com/' : '/simpeg2/cuti_pegawai/upload_berkas/?idkat=38&nm_berkas=SK Cuti&ket_berkas=<?php echo $lsdata->id_cuti_master; ?>&idp_uploader=<?php echo $user_cur; ?>&idp_cutier=<?php echo($lsdata->id_pegawai); ?>';

                                                            $('#<?php echo 'file_cuti_'.$lsdata->id_cuti_master; ?>').fileupload({
                                                                    url: <?php echo 'url_'.$lsdata->id_cuti_master; ?>,
                                                                    dataType: 'json',
                                                                    paramName: 'files[]',
                                                                    done: function (e, data) {
                                                                        $.each(data.result.files, function (index, file) {
                                                                            $('<p/>').text(file.name).appendTo('#files');
                                                                            location.reload();
                                                                        });
                                                                    },
                                                                    progressall: function (e, data) {
                                                                        var a = parseInt(data.loaded / data.total * 100, 10);
                                                                        pbCuti.progressbar('value', (a));
                                                                    }
                                                                })
                                                                .prop('disabled', !$.support.fileInput)
                                                                .parent().addClass($.support.fileInput ? undefined : 'disabled');
                                                        });
                                                    </script>
                                                    <?php
                                                    }else { ?>
                                                    <span>
                                        <i class="icon-loop"></i>
                                        <span>Upload Ulang SK Cuti (format file harus pdf)</span>
                                                        <!-- The file input field used as target for the file upload widget -->
                                        <div class="input-control file">
                                            <input id="file_cuti_<?php echo $lsdata->id_cuti_master; ?>"
                                                   type="file" name="files[]" multiple/>
                                            <button class="btn-file"></button>
                                        </div>
                                        <input type="hidden"
                                               name="surat_sk_cuti<?php echo $lsdata->id_cuti_master; ?>"
                                               id="surat_sk_cuti<?php echo $lsdata->id_cuti_master; ?>"/>
                                        </span>

                                                    <div id="<?php echo 'progress_' . $lsdata->id_cuti_master; ?>"
                                                         class="progress-bar primary" style="margin-top: -5px;">
                                                        <div class="progress-bar progress-bar-primary">
                                                            <script type="text/javascript">
                                                                $(function () {
                                                                    var pbCuti = $('#<?php echo 'progress_' . $lsdata->id_cuti_master; ?>').progressbar();
                                                                    var progress = 0;
                                                                    var <?php echo 'url_'.$lsdata->id_cuti_master; ?> =
                                                                    window.location.hostname === 'blueimp.github.io' ?
                                                                        '//jquery-file-upload.appspot.com/' : '/simpeg2/cuti_pegawai/upload_berkas/?idkat=38&nm_berkas=SK Cuti&ket_berkas=<?php echo $lsdata->id_cuti_master; ?>&idp_uploader=<?php echo $user_cur; ?>&idp_cutier=<?php echo($lsdata->id_pegawai); ?>&upload_ulang=1&id_berkas=<?php echo $lsdata->idberkas_sk_cuti;?>';

                                                                    $('#<?php echo 'file_cuti_'.$lsdata->id_cuti_master; ?>').fileupload({
                                                                            url: <?php echo 'url_'.$lsdata->id_cuti_master; ?>,
                                                                            dataType: 'json',
                                                                            paramName: 'files[]',
                                                                            done: function (e, data) {
                                                                                $.each(data.result.files, function (index, file) {
                                                                                    $('<p/>').text(file.name).appendTo('#files');
                                                                                    location.reload();
                                                                                });
                                                                            },
                                                                            progressall: function (e, data) {
                                                                                var a = parseInt(data.loaded / data.total * 100, 10);
                                                                                pbCuti.progressbar('value', (a));
                                                                            }
                                                                        })
                                                                        .prop('disabled', !$.support.fileInput)
                                                                        .parent().addClass($.support.fileInput ? undefined : 'disabled');
                                                                });
                                                            </script>
                                                            <?php }
                                                            ?>
                                        </td>
                                        <?php endif; ?>
                                    </tr>
                                    <?php endif; ?>
                                </table>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php
				$i++;
				endforeach; ?>
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
    <?php if (isset($pgDisplay)): ?>
        <?php if ($numpage > 0): ?>
            Halaman ke <?php echo $curpage; ?> dari <?php echo $numpage; ?> | Jumlah Data : <?php echo $total_items; ?> | <?php echo $jumppage; ?> | <?php echo $item_perpage; ?>
            <br>
            <?php echo $pgDisplay; ?>
        <?php endif; ?>
    <?php endif; ?>
</div>

<script type="text/javascript" src="<?php echo base_url() ?>js/jquery/jquery.ui.widget.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/jquery/jquery.iframe-transport.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/jquery/jquery.fileupload.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>assets/metro/js/metro-progressbar.js"></script>
<script type="text/javascript">

    $("#btn_tampilkan").click(function () {
        var opd = $('#ddFilterOpd').val();
        var jenis = $('#ddFilterJns').val();
        var status = $('#ddFilterStatus').val();
        var cek_sk = $('#ddFilterCekSK').val();
        var keywordCari = $("#keywordCari").val();
        loadDataListCuti(<?php echo $idproses?>, opd, jenis, status, cek_sk, keywordCari, '<?php echo isset($_GET['page'])?$_GET['page']:1; ?>', '<?php echo $stsExpire?>');
    });

    function loadDataListCuti(idproses, idskpd, jenis, status, cek_sk, keywordCari, page, sts) {
        if (status == undefined || status == null) {
            status = 0;
        }
        if (cek_sk == undefined || cek_sk == null) {
            cek_sk = 0;
        }
        var ipp = $("#selIpp").val();
        location.href = "<?php echo base_url()."cuti_pegawai/list_pengajuan_cuti/" ?>" + idproses + "?page=" + page + "&ipp=" + ipp + "&idskpd=" + idskpd + "&jenis=" + jenis + "&status=" + status + "&cek_sk=" + cek_sk + "&keywordCari=" + keywordCari + "&stsexpire=" + sts;
    }

    function hrefExpire(sts) {
        var ipp = $("#selIpp").val();
        location.href = "<?php echo base_url()."cuti_pegawai/list_pengajuan_cuti/".$idproses."?page=".(isset($_GET['page'])?$_GET['page']:1)."&ipp=" ?>" + ipp + "&stsexpire=" + sts;
    }

    function getInfoPegawai(idcuti) {
        var nipCari = $("#nipPengesah" + idcuti).val();
        if (nipCari == '') {
            alert('Tentukan NIP Pengesah');
        } else {
            $.ajax({
                method: "POST",
                url: "<?php echo base_url()?>index.php/cuti_pegawai/info_pegawai",
                data: {nipCari: nipCari, idcuti: idcuti},
                dataType: "html"
            }).done(function (data) {
                $("#divInfoPegawaiPengesah" + idcuti).html(data);
                $("#divInfoPegawaiPengesah" + idcuti).find("script").each(function (i) {
                    //eval($(this).text());
                });
            });
        }
    }

    function revisi_cuti(id, ponsel){
        var r = confirm("Anda yakin akan merevisi permohonan ini?");
        if (r == true) {
            var cttnRev = $("#txtCatatan_" + id).val();
            //window.open('https://wa.me/'+ponsel+'?text='+cttnRev, '_blank');
            $.post('https://eu14.chat-api.com/instance25721/message?token=32r2xt8sm5oxb5nx',
            {
                "phone": ponsel,
                "body": cttnRev
            },
            function(data){
                if(data.sent==true){
                    alert("Pesan WhatsApp terkirim");
                }else{
                    alert("Pesan WhatsApp tidak terkirim");
                }
            });
            var form = document.getElementById("frmAjukanCuti_"+id);
            var hiddenField = document.createElement("input");
            hiddenField.setAttribute("type", "hidden");
            hiddenField.setAttribute("name", "revisi");
            hiddenField.setAttribute("value", 1);
            form.appendChild(hiddenField);
            form.submit();
        }
    }

</script>
