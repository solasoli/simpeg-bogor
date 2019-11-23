<style>
    #foto_main {
        padding-top:5px;
        padding-bottom:5px;
        padding-left:5px;
        padding-right:5px;
    }
    #post_msg{
        padding-top:5px;
        margin-left: -30px;
    }
</style>
<?php
include 'class/cls_notifikasi.php';
$oNotif = new Notifikasi();
$idpost = $_GET['idpost'];

$oData = $oNotif->getParentPost($idpost);
?>
<body>
    <div class="row">
        <div class="col-md-11"><h2>Pesan Beranda</h2></div>
    </div>
    <?php
    if ($oData->num_rows > 0) {
        while ($oto = $oData->fetch_array(MYSQLI_NUM)) {
            ?>
            <div class="row">
                <div class="col-md-1">
                    <div id="foto_main">
                        <img src="<?php echo "foto/" . $oto[2] . ".jpg"; ?>" class="rounded" width="45">
                    </div>
                </div>
                <div class="col-md-9">
                    <div id="post_msg">
                        <span style="color: black"><?php echo $oto[1]; ?></span><br>
                        <span style="color: grey"><?php echo $oto[3]; ?></span>
                    </div>
                </div>
            </div>
            <?php
            $idp = $oto[2];
        }?>
    <div class="row">
        <div class="col-md-1"></div>
        <div class="col-md-10">
        <div id="list_child_post">
            <table id="table_child_lst" class="row-border" style="margin-left: -30px;">
            </table></div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-1"></div>
        <div class="col-md-10">
            <div class = "form-group" style="margin-left: -30px;">
                <label for = "name">Komentari</label>
                <textarea id="txtPesan" class = "form-control" rows = "3"></textarea>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-1"></div>
        <div class="col-md-10">
            <input type="button" class="btn btn-primary" value="Kirim" onclick="kirim_posting();"
                   style="margin-left: -30px;margin-top: -10px;margin-bottom: 20px;"/></div>
    </div>
    <?php }else{ ?>
        <span style="color: black;">Data tidak ditemukan atau telah terhapus</span>
    <?php }
    ?>

</body>

<script language="JavaScript">
    var table_child;
    $(document).ready(function() {
        table_child = $('#table_child_lst').DataTable( {
            "DisplayLength": 5,
            "ordering": false,
            "ajax": "class/cls_ajax_data.php?filter=post_list_child&idparent=<?php echo $idpost; ?>",
            "autoWidth": false,
            "columnDefs": [
                { "width": "5%", "targets": 0 },
                { "width": "95%", "targets": 1 }
            ],
            "columns": [
                {"data":"id_pegawai",
                    "className":"left",
                    "render":function(data, type, full){
                        return "<img src='foto/"+full.id_pegawai+".jpg' class='rounded' width='45'></div>";
                    }
                },
                {"data":"msg",
                    "className":"left",
                    "render":function(data, type, full){
                        return "<span style='font-weight: bold'>"+full.nama+"</span><br>" +
                            "<span>"+ full.msg +"</span><br>" +
                            "<span style='color: grey;'>" +full.kapan+"</span>";
                    }
                }
            ]
        } );
        setInterval( function () {
            table_child.ajax.reload( null, false ); // user paging is not reset on reload
        }, 7000 );
    } );

    function kirim_posting(){
        var pesan = document.getElementById('txtPesan').value
        $.ajax({
            type: "GET",
            dataType: "json",
            url: "class/cls_ajax_data.php?filter=insert_post_beranda&pesan="+ pesan + "&id_pegawai=<?php echo $idp; ?>&parent_id=<?php echo $idpost; ?>",
            success: function (results) {
                var hasil, status = '';
                $.each(results, function(k, v){
                    hasil = v.hasil;
                    status = v.status;
                });
                if(hasil == 1){
                    $('#txtPesan').val('');
                    table_child.ajax.reload( null, false );
                }else{
                    alert('Query gagal');
                }
            }
        });
    }
</script>


