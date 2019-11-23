<div class="row">
    <div class="col-lg-12" style="border-bottom: 1px solid #969696;">
        <div style="font-weight: bold;"><?php echo $nama_baru_skpd; ?></div>
        <div><?php echo $jabatan; ?>. Eselon : <?php echo $jbtn_eselon; ?></div>
    </div> <br>
    Anda akan mengunduh data rekomendasi pegawai untuk jabatan eselon ini.
    Harap tentukan jumlah data yang akan diambil :
    <div>
        <select id = 'ddBanyakData'>
            <option value="10">10</option>
            <option value="25">25</option>
            <option value="50">50</option>
            <option value="100">100</option>
        </select> <div id="btn_download" class="button" onclick="downloadExcelDataRekomendasi(
        <?php echo $idskpd; ?>, '<?php echo $jbtn_eselon; ?>', '<?php echo $tipe_rekomendasi; ?>'
        );">Download</div>
    </div>
</div>

<script type="text/javascript">
    function downloadExcelDataRekomendasi(idskpd_tujuan, jbtn_eselon,  tipe_rekomendasi){
        var e = document.getElementById("ddBanyakData");
        var limit_banyaknya = e.options[e.selectedIndex].value;

        window.open('<?php echo base_url()."index.php/phpexcel/excel_rekomendasi_eselon/index/"; ?>'+idskpd_tujuan+
            '/'+jbtn_eselon+'/'+limit_banyaknya+'/'+tipe_rekomendasi,'_blank');

        /*var a;
        a = $.get('<?php //echo base_url()."index.php/jabatan_struktural/export_to_excel/"; ?>' +
        "?idskpd_tujuan=" + idskpd_tujuan + "&jbtn_eselon=" + jbtn_eselon +
        "&limit_banyaknya=" + limit_banyaknya + "&tipe_rekomendasi=" + tipe_rekomendasi);*/

    }
</script>
<!--<iframe id="secretIFrame"></iframe>-->