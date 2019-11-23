<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<script src="<?php echo base_url()?>js/jquery/jquery.validate.js"></script>

<h3>Rekapitulasi Usulan PTK Berds. Periode Pengajuan</h3>
<strong>Keterangan:</strong>
<ul>
    <li><strong>A)</strong> Dalam proses yang bersangkutan,
        <strong>B)</strong> Dalam proses BKPSDA,
        <strong>C)</strong> Disetujui BKPSDA,
        <strong>D)</strong> Ditolak BKPSDA,
        <strong>E)</strong> Dibatalkan BKPSDA,
        <strong>F)</strong> Surat ke BPKAD Terbit,
        <strong>G)</strong> Dalam Proses BPKAD,
        <strong>H)</strong> Ditolak BPKAD,
        <strong>I)</strong> Tunjangan sudah diubah
    </li>
</ul>
<?php if(isset($pgDisplay)): ?>
    <?php if($numpage > 0): ?>
        Halaman ke <?php echo $curpage; ?> dari <?php echo $numpage; ?> | Jumlah Data : <?php echo $jmlData; ?> | <?php echo $jumppage; ?><br>
        <?php echo $pgDisplay; ?>
    <?php endif; ?>
<?php endif; ?>

<?php if(isset($drop_data_pengantar)): ?>
    <table class="table bordered">
        <thead style="border-bottom: solid #a4c400 2px;">
            <tr>
                <th>No</th>
                <th>Bln</th>
                <th>Thn</th>
                <th>A</th>
                <th>B</th>
                <th>C</th>
                <th>D</th>
                <th>E</th>
                <th>F</th>
                <th>G</th>
                <th>H</th>
                <th>I</th>
                <th>&Sigma;</th>
                <th style="width:5%">Pengantar</th>
                <th style="width:15%">Aksi</th>
            </tr>
        </thead>
        <tbody>
        <?php if (sizeof($drop_data_pengantar) > 0): ?>
            <?php foreach($drop_data_pengantar as $rp) { ?>
                <tr style="text-align: center;">
                    <td <?php echo($rp->pengantar>0?'rowspan=2':''); ?>><?php echo $rp->no_urut ?></td>
                    <td <?php echo($rp->pengantar>0?'rowspan=2':''); ?>><?php echo $rp->bln ?></td>
                    <td <?php echo($rp->pengantar>0?'rowspan=2':''); ?>><?php echo $rp->thn ?></td>
                    <td><?php echo $rp->dlm_proses_ybs ?></td>
                    <td><?php echo $rp->dlm_proses_bkpsda ?></td>
                    <td><?php echo $rp->disetujui_bkpsda ?></td>
                    <td><?php echo $rp->ditolak_bkpsda ?></td>
                    <td><?php echo $rp->dibatalkan_bkpsda ?></td>
                    <td><?php echo $rp->surat_bpkad_terbit ?></td>
                    <td><?php echo $rp->dlm_proses_bpkad ?></td>
                    <td><?php echo $rp->ditolak_bpkad ?></td>
                    <td><?php echo $rp->tunjangan_berubah ?></td>
                    <td><?php echo $rp->semua ?></td>
                    <td><?php echo $rp->pengantar ?></td>
                    <td><button class="button small-button" style="background-color: #b68255" onclick="lihat_nominatif_ptk(<?php echo $rp->bln ?>,<?php echo $rp->thn ?>);">
                            <span class="mif-plus"></span><span style="font-weight: bold;color: white;">Lihat Nominatif</span></button>
                    </td>
                </tr>
                <?php if($rp->pengantar>0): ?>
                <tr>
                    <td colspan="12">
                        <strong>Pengantar :</strong><br>
                        <?php
                            $pengantar = $this->ptk->viewPengantarPTKByPeriode($rp->bln, $rp->thn);
                            if(isset($pengantar)) {
                                $y = 1;
                                foreach ($pengantar as $ptr) {
                                    echo "$y) Tanggal : $ptr->tgl_pembuatan.
                                    <span style='color: darkred;font-weight: bold;'>Nomor : $ptr->nomor</span>. Pengesah :
                                    $ptr->nama_kepala Jumlah Usulan : <strong>$ptr->jumlah_usulan orang</strong>";
                                    echo "<br>";
                                    echo "<a onclick=\"ubah_data_pengantar($ptr->id_pengantar, ".($ptr->id_berkas==''?'0':$ptr->id_berkas).", $curpage, $ipp);\"
                                        class=\"button link\"><span style=\"font-weight: bold;\">Lihat Detail & Ubah</span></a>";
                                    echo "|";
                                    echo "<a onclick=\"hapus_data_pengantar($ptr->id_pengantar)\" class=\"button link\"><span style=\"font-weight: bold;\">Hapus</span></a>";
                                    echo "|";
                                    if ($ptr->id_berkas == '') {
                                        echo '&nbsp;&nbsp;&nbsp;&nbsp;Belum ada File Surat Pengantar yang diupload';
                                    }else{
                                        $filePtr = $this->ptk->cekBerkas($ptr->id_berkas);
                                        if (isset($filePtr)) {
                                            if(sizeof($filePtr) > 0){
                                                foreach ($filePtr as $row) {
                                                    $asli = basename($row->file_name);
                                                    $getcwd = substr(getcwd(),0,strlen(getcwd())-1);
                                                    if(file_exists(str_replace("\\","/",$getcwd).'/Berkas/'.trim($asli))){
                                                        echo "<a href='/simpeg/Berkas/$asli' target='_blank' class=\"button link\"><span style=\"font-weight: bold;\">Berkas Pengantar PTK ke BPKAD Terupload</span></a>";
                                                        echo '<span class="form-text text-muted" style="margin-top: 10px;font-size: small;">
                                                            ('.$row->created_date.', Oleh: '.$row->nama.')</span>';
                                                    }else{
                                                        echo 'Belum ada File Surat Pengantar yang diupload (Data berkas sudah ada tapi file tidak ada).';
                                                    }
                                                }
                                            }
                                        }
                                    }
                                    echo '<br><br>';
                                    $y++;
                                }
                            }
                        ?>
                    </td>
                </tr>
                <?php endif; ?>
            <?php } ?>
        <?php else: ?>
            <tr class="error">
                <td colspan="15"><i>Tidak ada data</i></td>
            </tr>
        <?php endif; ?>
        </tbody>
    </table>

    <div style="margin-top: -18px; margin-bottom: 10px;">
        <?php if(isset($pgDisplay)): ?>
            <?php if($numpage > 0): ?>
                Halaman ke <?php echo $curpage; ?> dari <?php echo $numpage; ?> | Jumlah Data : <?php echo $jmlData; ?> | <?php echo $jumppage; ?><br>
                <?php echo $pgDisplay; ?>
            <?php endif; ?>
        <?php endif; ?>
    </div>
<?php else: ?>
    Data tidak ditemukan.
<?php endif; ?>


<script>
    function lihat_nominatif_ptk(bln, thn){
        $.ajax({
            method: "POST",
            url: "<?php echo base_url()?>index.php/ptk/window_nominatif_ptk",
            data: { bln: bln, thn: thn},
            dataType: "html"
        }).done(function( data ) {
            $("#nominatif_ptk").html(data);
            $("#nominatif_ptk").find("script").each(function(i) {
                eval($(this).text());
            });
        });

        $.Dialog({
            shadow: true,
            overlay: false,
            icon: '<span class="icon-rocket"></span>',
            title: 'Daftar Nominatif Usulan Pengubahan Tunjangan Keluarga',
            width: 1100,
            height: 550,
            padding: 10,
            content: "<div id='nominatif_ptk' style='height:450px;overflow: auto;overflow-x: hidden; '>Loading...</div>"
        });
    }

    function ubah_data_pengantar(id_pengantar, id_berkas, curpage, ipp){
        $.ajax({
            method: "POST",
            url: "<?php echo base_url()?>index.php/ptk/window_ubah_data_pengantar",
            data: { id_pengantar: id_pengantar, id_berkas: id_berkas,  curpage: curpage, ipp:ipp},
            dataType: "html"
        }).done(function( data ) {
            $("#ubah_pengantar").html(data);
            $("#ubah_pengantar").find("script").each(function(i) {
                eval($(this).text());
            });
        });

        $.Dialog({
            shadow: true,
            overlay: false,
            icon: '<span class="icon-rocket"></span>',
            title: 'Informasi Surat Pengantar ke BPKAD',
            width: 1280,
            height: 550,
            padding: 10,
            content: "<div id='ubah_pengantar' style='height:450px;overflow: auto;overflow-x: hidden; '>Loading...</div>"
        });
    }

    function hapus_data_pengantar(id_pengantar){
        var r = confirm("Anda yakin ingin menghapus pengantar ini?");
        if (r == true) {
            var dataSts = new FormData();
            dataSts.append('id_pengantar', id_pengantar);
            jQuery.ajax({
                url: "<?php echo base_url()?>index.php/ptk/hapus_pengantar_ptk",
                data: dataSts,
                cache: false,
                contentType: false,
                processData: false,
                type: 'POST',
                success: function (data) {
                    if (data == '1') {
                        alert('Data sukses terhapus');
                        //window.location.reload();
                    } else {
                        alert(data);
                    }
                    pagingViewListLoad(<?php echo ($curpage==''?'0':$curpage);?>,<?php echo $ipp?>);
                }
            });
        }
    }

    function loadDataPengantar(bln,thn,page,ipp){
        /*$("#btn_tampilkan").css("pointer-events", "none");
        $("#btn_tampilkan").css("opacity", "0.4");
        $("#divPengantar").css("pointer-events", "none");
        $("#divPengantar").css("opacity", "0.4");*/
        $.post('<?php echo base_url()."index.php/ptk/drop_data_pengantar_bpkad"; ?>',
            {
                bln: bln,
                thn: thn,
                page: page,
                ipp: ipp
            }, function(data){
                $("#divPengantar").html(data);
                $("#divPengantar").find("script").each(function(i) {
                    eval($(this).text());
                });
                /*$("#btn_tampilkan").css("pointer-events", "auto");
                $("#btn_tampilkan").css("opacity", "1");
                $("#divPengantar").css("pointer-events", "auto");
                $("#divPengantar").css("opacity", "1");*/
            });
    }

    function pagingViewListLoad(parm,parm2){
        var bln = $('#ddBulan').val();
        var thn = $('#ddTahun').val();
        loadDataPengantar(bln,thn,parm,parm2);
    }

</script>
