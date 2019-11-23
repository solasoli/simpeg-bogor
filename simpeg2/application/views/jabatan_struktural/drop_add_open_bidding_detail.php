<?php if (is_array($list_data) && sizeof($list_data) > 0): ?>
    <?php if ($list_data != ''): ?>
        <?php foreach ($list_data as $lsdata): ?>
            <table style="width: 100%" id="lst_add_opbd">
                <tr>
                    <td style="width: 20%">Keterangan</td>
                    <td style="width: 5%">:</td>
                    <td style="width: 75%"><?php echo $lsdata->keterangan; ?></td>
                </tr>
                <tr>
                    <td>TMT</td>
                    <td>:</td>
                    <td><?php echo $lsdata->tmt_open_bidding; ?></td>
                </tr>
                <tr>
                    <td>Status Aktif</td>
                    <td>:</td>
                    <td><?php echo($lsdata->status_aktif == 1 ? 'Aktif' : 'Tidak Aktif'); ?></td>
                </tr>
                <tr>
                    <td>Jumlah Pegawai</td>
                    <td>:</td>
                    <td><?php echo $lsdata->jml_pegawai; ?> orang</td>
                </tr>
            </table>
        <?php endforeach; ?>
        <div class="container">
            <div class="grid">
                <div class="row">
                    <div class="span4">
                        <strong>Informasi Pegawai</strong><br>
                        <div class="input-control text" style="margin-top: 10px;">
                            <div id="appendToHere">
                                <input id="nama_pegawai_opbd" type="text" value="" placeholder="Cari Nama / NIP"/>
                                <button type="button" class="btn-search"></button>
                            </div>
                            <button id="btn_pilih" class="button" style="background-color: rgba(236,177,72,0.78)"><span class="icon-checkmark on-left"></span> Pilih</button>
                            <button id="btn_save" class="button success" style="background-color: rgba(236,177,72,0.78)"><span class="icon-floppy on-left"></span> Simpan</button>
                            <div class="listview-outlook">
                                <div class="list">
                                    <div class="list-content"><strong><span id="lbl_nama"></span></strong></div>
                                </div>
                                <div class="list">
                                    <div class="list-content"><span id="lbl_nip"></span></div>
                                </div>
                                <div class="list">
                                    <div class="list-content"><span id="lbl_gol"></span></div>
                                </div>
                                <div class="list">
                                    <div class="list-content"><span id="lbl_jab"></span></div>
                                </div>
                                <div class="list">
                                    <div class="list-content"><span id="lbl_uker"></span></div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="span12"></div>
                        </div>
                    </div>
                    <div class="span8">
                        <div style="color: blue;background-color: #EEEEEE;border: 1px solid #747571;
                                width: 90%;font-size: small;padding: 3px;margin-bottom: 0px;text-align: center;">
                            Daftar Pegawai yang dipilih</div>
                        <div id="divListGetPegOpbd" style="border:1px solid #c0c2bb; overflow: scroll;height: 285px;
                                width: 90%;padding: 5px;margin-bottom: 0px;"></div>
                        Pegawai yang dipilih berjumlah :
                        <span id="jmlPegawaiPilih" style="font-weight: bold">0</span> Pegawai
                        <button id="btnHapus" class="button danger" style="height: 33px;" type="button">
                            <span class="icon-remove on-left"></span><strong>Hapus yang diceklis</strong></button>
                    </div>
                </div>
            </div>
        </div>
    <?php else: ?>
        Data tidak ditemukan
    <?php endif; ?>
<?php else: ?>
    Data tidak ditemukan
<?php endif; ?>

<script type="text/javascript">

    $( "#nama_pegawai_opbd" ).autocomplete({
        appendTo: "#appendToHere",
        minLength: 3,
        source: function( request, response ) {
            $.ajax({
                url: "<?php echo base_url()."index.php/jabatan_struktural/json_find_pegawai" ?>",
                dataType: "json",
                data: {
                    q: request.term
                },
                success: function( data ) {
                    response( data );
                },
                error: function(a,b,c){
                    console.log(b);
                    console.log(a.responseText);
                }
            });
        },
        focus: function( event, ui ) {
            //$( "#nama_pengganti" ).val( ui.item.label );
            return false;
        },
        select: function( event, ui ) {
            if(ui.item.label=='Pegawai tidak ditemukan'){
            }else{
                $( "#lbl_nama" ).html( "" + ui.item.label );
                $( "#lbl_nip" ).html( "" + ui.item.nip );
                $( "#lbl_gol" ).html( "Golongan " + ui.item.gol );
                $( "#lbl_jab" ).html( "" + ui.item.jabatan + " " + ui.item.jenjab);
                $( "#lbl_uker" ).html( "" + ui.item.uker );
            }
            return false;
        }
    }).autocomplete( "instance" )._renderItem = function( ul, item ) {
        $("ul[id*='ui-id-']").css('z-index','1100');
        return $( "<li>" )
            .append( "<a><strong>" + item.label + "</strong> ("+ item.gol +")<br>" + item.uker + "</a>" )
            .appendTo( ul );
    };

    $("#add_open_bidding_detail").on("autocompleteselect", function(event,ui) {
        event.stopPropagation();
    });

</script>
