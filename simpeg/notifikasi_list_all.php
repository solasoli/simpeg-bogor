<body>
    <div class="row">
        <div class="col-md-11"><h2>Action Center</h2></div>
    </div>
    <div class="row">
        <div class="col-md-11">
            <div id="walltable">
                <table id="table_notif_lst" class="row-border">
                    <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Pesan</th>
                        <th>Aksi</th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</body>

<script language="JavaScript">
    var table_notif;
    $(document).ready(function() {
        table_notif = $('#table_notif_lst').DataTable( {
            "DisplayLength": 100,
            "ordering": false,
            "ajax": "class/cls_ajax_data.php?filter=notifikasi_list_all&idp=<?php echo $_SESSION['id_pegawai']; ?>",
            "autoWidth": false,
            "columnDefs": [
                { "width": "5%", "targets": 0 },
                { "width": "10%", "targets": 1 },
                { "width": "70%", "targets": 2 },
                { "width": "20%", "targets": 3 },
                { "width": "0%", "targets": 4, "visible": false }
            ],
            "columns": [
                { "data": "no" },
                { "data": "tgl_notif" },
                {"data":"sen_rec_name",
                    "className":"left",
                    "render":function(data, type, full){
                        return "<div class='row' style='width: 100%'>" +
                            "<div class='col-sm-1'><img src='foto/"+full.id_pegawai_from+".jpg' class='rounded' width='45'></div>" +
                            "<div class='col-sm-11'>" +
                            "<span style='font-weight: bold'>"+full.jenis_notifikasi + ' Data ' + full.sen_rec_name+"</span><br>" +
                            "<span>"+ full.additional_data2 +"</span><br>" +
                            "<span style='color: saddlebrown;'>Pengirim: "+full.nama +"</span><span style='color: steelblue;font-size: small;'> (" +full.jabatan+")</span></div></div>";
                    }
                },
                {
                    "data": "id_notif",
                    "render": function(data, type, full) {
                        return '<input type="button" class="btn btn-info btn-sm" value="Lihat" onclick="goto_page('+data+','+"\'"+full.url_type_app+"\'"+','+"\'"+full.file_app+"\'"+','+"\'"+full.additional_data+"\'"+');" />' + '&nbsp;' +
                            '<input type="button" class="btn btn-danger btn-sm" value="Hapus" onclick="remove_notifikasi('+data+');"/>';
                    }
                },
                {"data": "status_read"}
            ],
            "createdRow": function ( row, data, index ) {
                if ( data["status_read"] == "1" ) {
                    $('td', row).css('background-color', 'rgba(192, 192, 192, 0.2)');
                }else if ( data["status_read"] == "0" ){
                    $('td', row).css('background-color', 'rgba(255, 255, 255, 1)');
                }
            }
        } );
        setInterval( function () {
            table_notif.ajax.reload( null, false ); // user paging is not reset on reload
        }, 7000 );
    } );

    function goto_page(idnotif, url, file, additional_data){
        var new_url;
        if(url=='home') {
            new_url = "/simpeg";
        }else if(url=='include'){
            new_url = "/simpeg/index3.php?x="+file+".php&idpost="+additional_data;
        }else if(url=='modul'){
            new_url = "/simpeg/"+file;
        }
        $.ajax({
            type: "GET",
            dataType: "json",
            url: "class/cls_ajax_data.php?filter=update_notif_read&idnotif="+ idnotif,
            success: function (results) {
                var hasil, status = '';
                $.each(results, function(k, v){
                    hasil = v.hasil;
                    status = v.status;
                });
                if(hasil == 1){
                    window.open(new_url,'_self');
                }else{
                    alert('Query gagal');
                }
            }
        });
    }

    function remove_notifikasi(idnotif){
        $.ajax({
            type: "GET",
            dataType: "json",
            url: "class/cls_ajax_data.php?filter=delete_notif&idnotif="+ idnotif,
            success: function (results) {
                var hasil, status = '';
                $.each(results, function(k, v){
                    hasil = v.hasil;
                    status = v.status;
                });
                if(hasil == 1){
                    table_notif.ajax.reload( null, false );
                }else{
                    alert('Query gagal');
                }
            }
        });
    }

</script>
