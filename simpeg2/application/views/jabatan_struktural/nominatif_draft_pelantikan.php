

<div class="container">
    <h2>Nominatif Daftar Calon Pejabat Struktural</h2>
    <!--<a href="<?php //echo base_url('pdf/jabatan_struktural_nominatif/index/').'/'.$this->uri->segment(3) ?>" class="button bg-green fg-white" target="_blank">Cetak PDF</a> -->
    <?php
    $i=1;
    foreach($eselons as $eselon) {
        ?>
        <div class="grid">
            <div class="row">
                <div class="span7">
                    <h4 style="text-align: right;text-decoration: underline">Eselon <?php echo $eselon->eselon ?></h4>
                </div>
                <div class="span7"  style="text-align: right">
                    <button id="btn_download_excel_<?php echo $eselon->eselon; ?>" class="button bg-darkRed fg-white" style="height: 30px;">
                        <span class="icon-file-excel"></span> Download Format <strong>Ms.Excel</strong>
                    </button>
                    <button id="btn_download_pdf_<?php echo $eselon->eselon; ?>" class="button bg-darkRed fg-white" style="height: 30px;">
                        <span class="icon-file-pdf"></span> Download Format <strong>PDF</strong>
                    </button>

                    <script>
                        $("#btn_download_excel_<?php echo $eselon->eselon; ?>").click(function () {
                            window.open("<?php echo base_url('index.php/phpexcel/excel_draft_pelantikan/index/').'/'.$this->uri->segment(3).'/'.$eselon->eselon; ?>");
                        });

                        $("#btn_download_pdf_<?php echo $eselon->eselon; ?>").click(function () {
                            window.open('<?php echo base_url()."jabatan_struktural/cetak_nominatif_draft/".$this->uri->segment(3).'/'.$eselon->eselon; ?>');
                        });
                    </script>

                </div>
            </div>
        </div>

        <table class="table bordered" id="daftar_pejabat<?php echo $i; ?>">
            <thead style="border-bottom: solid #a4c400 2px;">
            <tr>
                <th width="5%">NO.</th>
                <th width="20%">NAMA<br>NIP<br>TANGGAL LAHIR</th>
                <th width="15%">PANGKAT<br>GOL.RUANG</th>
                <th width="20%">JABATAN LAMA</th>
                <th width="20%">JABATAN BARU</th>
                <th width="10%">ESELON</th>
                <th width="20%">PEJABAT AWAL</th>
                <th width="10%">KET</th>
                <th width="10%">AKSI</th>
            </tr>
            </thead>
            <tbody>
            <?php $jabatan = $this->draft_pelantikan_model->nominatif_by_id($this->uri->segment(3), $eselon->eselon);
            foreach($jabatan as $pejabat) { ?>
                <tr>
                    <td><?php echo $pejabat->no_urut ?></td>
                    <td><?php echo $pejabat->gelar_depan.' '.$pejabat->nama.' '.$pejabat->gelar_belakang."<br>".$pejabat->nip."<br>".$pejabat->tgl_lahir; ?></td>
                    <td><?php echo $pejabat->pangkat."<br>".$pejabat->pangkat_gol; ?></td>
                    <td><?php echo $pejabat->jabatan_lama ?></td>
                    <td><?php echo $pejabat->jabatan_baru ?></td>
                    <td style="text-align: center"><?php echo $pejabat->eselon_baru ?></td>
                    <td><?php echo $pejabat->gelar_depan_pejabat_awal.' '.$pejabat->nama_pejabat_awal.' '.$pejabat->gelar_belakang_pejabat_awal."<br>".$pejabat->nip_pejabat_awal."<br>".$pejabat->tgl_lahir_pejabat_awal; ?></td>
                    <td style="text-align: center"><?php echo $pejabat->keterangan ?></td>
                    <td>
                        <div id="btn_detail" class="button bg-green fg-white"
                             onclick="alertConfirmBatal('<?php echo isset($pejabat->id_pegawai_awal)?$pejabat->id_pegawai_awal:0 ?>',
                                     '<?php echo $pejabat->id_pegawai ?>', '<?php echo $pejabat->id_draft ?>');">Batalkan</div> <br>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
        <?php
        $i++;
    } ?>
</div>

<script type="text/javascript">
    var varResult;
    function alertConfirmBatal(idpegawai_awal, idpegawai, iddraft){
        $.Dialog({
            shadow: true,
            overlay: false,
            icon: '<span class="icon-rocket"></span>',
            title: 'Informasi',
            width: 250,
            height: 100,
            padding: 10,
            content: "<div style='width:400px;'><table width='95%' border='0'><tr><td width='20%'><img src='<?php echo base_url().'images/Warning.png'; ?>' width='64'></td><td width='80%'>Anda yakin mau membatalkan pelantikan pegawai ini?</td></tr><tr><td></td><td style='text-align: center'><div id='btn_ok_cancel' class='button' onclick='batalPelantikan("+idpegawai_awal+','+idpegawai+','+iddraft+")'>Ya</div> <div id='btn_ok_cancel' class='button' onclick='$.Dialog.close()'>Tidak</div></td></tr></table></div>"
        });
    }

    function batalPelantikan(idpegawai_awal, idpegawai, iddraft){
        $.Dialog.close();
        $.post('<?php echo base_url()."index.php/jabatan_struktural/batal_pelantikan_pegawai"; ?>', {
            id_draft:iddraft,
            id_pegawai_baru: idpegawai,
            id_pegawai_awal: idpegawai_awal
        }, function (data) {
            var dataArray = jQuery.parseJSON(data);
            $("#msgbox_batal").html(dataArray[0]);
            $("#icon_alert").html(dataArray[1]);
            varResult = dataArray[2];
        });
        $.Dialog({
            id: '1',
            shadow: true,
            overlay: false,
            icon: '<span class="icon-rocket"></span>',
            title: 'Informasi',
            width: 250,
            height: 225,
            padding: 10,
            content: "<div style='width:400px;'><table width='95%' border='0'><tr><td width='20%'><div id='icon_alert'></div></td><td width='80%'><div id='msgbox_batal'></div></td></tr><tr><td></td><td style='text-align: center'><div id='btn_ok_cancel' class='button' onclick='resultCheck();'>OK</div></td></tr></table></div>"
        });
    }

    function resultCheck(){
        $.Dialog.close();
        if(varResult == 1){
            location.reload();
        }
    }

</script>

<script>
    $(document).ready(function(){
        for(k=1;k<7;k++)
            $('#daftar_pejabat'+k).dataTable();
    });
</script>