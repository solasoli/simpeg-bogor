<?php if(isset($pgDisplay)): ?>
    <?php if($numpage > 0): ?>
        Halaman ke <?php echo $curpage; ?> dari <?php echo $numpage; ?> | Jumlah Data : <?php echo $jmlData; ?> | <?php echo $jumppage; ?><br>
        <?php echo $pgDisplay; ?>
    <?php endif; ?>
<?php endif; ?>

<?php if(isset($cari_pegawai)): ?>
        <table class="table bordered striped" id="daftar_pejabat">
            <thead style="border-bottom: solid #a4c400 2px;">
            <tr>
                <th width="5%">NO.</th>
                <th width="7%">PHOTO</th>
                <th width="20%">NIP</th>
                <th width="20%">NAMA</th>
                <th width="5%">GOL.</th>
                <th width="23%">JABATAN</th>
                <th width="20%">UNIT KERJA</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach($cari_pegawai as $pegawai) { ?>
            <tr>
                <td><?php echo $pegawai->no_urut ?></td>
                <td><img src='http://103.14.229.15/simpeg/foto/<?php echo $pegawai->id_pegawai?>.jpg' width='50' /></td>
                <td>
                    <input type="radio" name="id_result_pegawai" value="<?php echo $pegawai->id_pegawai ?>">
                    <?php echo $pegawai->nip_baru ?>
                </td>
                <td><?php echo $pegawai->nama ?></td>
                <td><?php echo $pegawai->pangkat_gol ?></td>
                <td><?php echo $pegawai->jabatan ?></td>
                <td><?php echo $pegawai->unit_kerja ?></td>
            </tr>
            <?php } ?>
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
<script src="<?php echo base_url()?>js/jquery/chosen.jquery.js"></script>
<script>
    $('.chosen-select').chosen();
    function pagingViewListLoad(parm,parm2){
        var cboPangkat = document.getElementById("idpangkat");
        var cboPangkat = cboPangkat.options[cboPangkat.selectedIndex].value;
        var cboJabatan = document.getElementById("idjabatan");
        var cboJabatan = cboJabatan.options[cboJabatan.selectedIndex].value;
        var cboUnit = document.getElementById("idunit");
        var cboUnit = cboUnit.options[cboUnit.selectedIndex].value;
        var txtKeyword = $("#txtKeyword").val();

        $("#cari_pegawai").css("pointer-events", "none");
        $("#cari_pegawai").css("opacity", "0.4");
        $.ajax({
            url: "<?php echo base_url()."index.php/jabatan_struktural/cari_pegawai" ?>",
            method: "POST",
            data: {
                page: parm,
                ipp: parm2,
                cboPangkat: cboPangkat,
                cboJabatan: cboJabatan,
                cboUnit: cboUnit,
                txtKeyword: txtKeyword
            },
            success: function( data ) {
                $("#cari_pegawai").css("pointer-events", "auto");
                $("#cari_pegawai").css("opacity", "1");
                $("#cari_pegawai").html(data);
            },
            error: function(a,b,c){
                console.log(b);
                console.log(a.responseText);
            }
        });
    }

    function filterPegawai(){
        var cboPangkat = document.getElementById("idpangkat");
        var cboPangkat = cboPangkat.options[cboPangkat.selectedIndex].value;
        var cboJabatan = document.getElementById("idjabatan");
        var cboJabatan = cboJabatan.options[cboJabatan.selectedIndex].value;
        var cboUnit = document.getElementById("idunit");
        var cboUnit = cboUnit.options[cboUnit.selectedIndex].value;
        var txtKeyword = $("#txtKeyword").val();

        $("#cari_pegawai").css("pointer-events", "none");
        $("#cari_pegawai").css("opacity", "0.4");
        $.ajax({
            url: "<?php echo base_url()."index.php/jabatan_struktural/cari_pegawai" ?>",
            method: "POST",
            data: {
                page: '',
                ipp: '',
                cboPangkat: cboPangkat,
                cboJabatan: cboJabatan,
                cboUnit: cboUnit,
                txtKeyword: txtKeyword
            },
            success: function( data ) {
                $("#cari_pegawai").css("pointer-events", "auto");
                $("#cari_pegawai").css("opacity", "1");
                $("#cari_pegawai").html(data);
            },
            error: function(a,b,c){
                console.log(b);
                console.log(a.responseText);
            }
        });
    }

    function pilihPegawai(lblInfo, idelement, idjab, lblJab){
        $.Dialog.close();
        var activationRdb = 0;
        var inputs = document.getElementsByTagName ('input');
        if (inputs) {
            for (var i = 0; i < inputs.length; ++i) {
                if (inputs[i].type ==	 'radio' && inputs[i].name == 'id_result_pegawai'){
                    if (inputs[i].checked){
                        activationRdb = inputs[i].value;
                    }
                }
            }
        }
        if(activationRdb==0){
            alert('Tidak ada data yang terpilih');
        }else{
            releasePegawai(activationRdb, lblInfo, idelement, idjab, lblJab);
        }
    }

    function releasePegawai(activationRdb, lblInfo, idelement, idjab, lblJab){
        var temp = lblJab;
        var count_ = (temp.match(/_/g) || []).length;
        $('#'+lblInfo).html('Loading...');
        $.ajax({
            dataType: 'json',
            url: "<?php echo base_url()."index.php/jabatan_struktural/info_pegawai" ?>",
            method: "POST",
            data: {
                idpegawai: activationRdb
            },
            success: function( data ) {
                var lblJabUnit = "";
                if(count_ == 0){
                    lblJabUnit = data[0].jabatan + '<br>' + data[0].unit_kerja;
                }else{
                    lblJabUnit = "";
                    $('#'+lblJab).html(data[0].jabatan);
                }
                var content = '<table><tr><td>' +
                    '<img src=\'http://103.14.229.15/simpeg/foto/' + data[0].id_pegawai + '.jpg\' width=\'50\' />' +
                    '</td><td>' +
                    '<strong>' + data[0].nama + '</strong><br>' +
                    '<span style="color: #00356a; font-weight: bold;">' + data[0].nip_baru + '</span>' +
                    ' (' + data[0].pangkat_gol + ')' + '<br>' + lblJabUnit +
                    '</td></tr></table>';

                $('#'+idelement).val(activationRdb);
                $('#'+idjab).val(data[0].id_j);
                $('#'+lblInfo).html(content);
            },
            error: function(a,b,c){
                console.log(b);
                console.log(a.responseText);
            }
        });
    }

</script>