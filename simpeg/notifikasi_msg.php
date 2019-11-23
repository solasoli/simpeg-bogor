<style>
    #list_foto {
        padding-top:5px;
        padding-bottom:15px;
        padding-left:0px;
        padding-right:5px;
        margin-left: -5px;
    }
    #list_msg {
        padding-top:5px;
        padding-bottom:5px;
        padding-left:10px;
        padding-right:5px;
        margin-left: -15px;
    }
    #separator {
        border-bottom: 1px solid rgba(46, 46, 46, 0.5);
    }
</style>
<?php
include 'class/cls_notifikasi.php';
$oNotif = new Notifikasi();
$idp = $_GET['idp'];

$is_tim = false; // tim opd flag
$oDataU = $oNotif->getUserType();
while ($oto = $oDataU->fetch_array(MYSQLI_NUM)) {
    $tim[] = $oto[0];
}
if(in_array(@$_SESSION['id_pegawai'],$tim)){

    $is_tim = TRUE;
}

$oData = $oNotif->getMsgNotifikasi($idp,0);
$i = 1;
if ($oData->num_rows > 0) {
    while ($oto = $oData->fetch_array(MYSQLI_NUM)) {
        if($oto[9]==1){
            $bgc = 'rgba(192, 192, 192, 0.3)';
        }else{
            $bgc = 'rgba(255, 255, 255, 1)';
        }
    ?>
        <div class="row" style="width: 108%">
            <div class="col-sm-2" style="background-color: <?php echo $bgc ?>;border-bottom: 1px solid rgba(46, 46, 46, 0.5)">
                <div id="list_foto">
                    <img src="<?php echo "foto/".$oto[4].".jpg"; ?>" class="rounded" width="45">
                </div>
            </div>
            <div class="col-sm-10" style="background-color: <?php echo $bgc ?>;border-bottom: 1px solid rgba(46, 46, 46, 0.5)">
                <div id="list_msg">
                    <strong><?php echo $i++; ?>. <?php echo $oto[10]; ?></strong><br>
                    <span style="color: blue;"><?php echo $oto[1]; ?> Data <?php echo $oto[3]; ?></span><br>
                    <span style="color: black;"><?php echo substr($oto[6],0,35).'...'; ?></span><br>
                    <span style="color: grey;"><?php echo $oto[2]; ?> &nbsp;
                        <input type="button" name="btnCekNotif<?php echo $oto[0]; ?>" id="btnCekNotif<?php echo $oto[0]; ?>"
                               class="btn btn-primary btn-xs" value="Lihat" style="height: 19px;" />
                    </span>
                </div>
            </div>
        </div>
        <!--<div id="separator"></div>-->
        <?php
            if($oto[7]=='home') {
                $url = "/simpeg";
            }elseif($oto[7]=='include'){
                if($oto[3]=='Cuti'){
                    if($is_tim){
                        $url = "/simpeg/index3.php?x=cuti_admin.php";
                    }else{
                        $url = "/simpeg/index3.php?x=".$oto[8].".php&idpost=".$oto[5];
                    }
                }else{
                    $url = "/simpeg/index3.php?x=".$oto[8].".php&idpost=".$oto[5];
                }
            }elseif($oto[7]=='modul'){
                $url = "/simpeg/".$oto[8];
            }
        ?>
        <script type="text/javascript">
            $("#btnCekNotif<?php echo $oto[0]; ?>").click(function () {
                $.ajax({
                    type: "GET",
                    dataType: "json",
                    url: "class/cls_ajax_data.php?filter=update_notif_read&idnotif="+ <?php echo $oto[0]; ?>,
                    success: function (results) {
                        var hasil, status = '';
                        $.each(results, function(k, v){
                            hasil = v.hasil;
                            status = v.status;
                        });
                        if(hasil == 1){
                            window.open('<?php echo $url; ?>','_self');
                        }else{
                            alert('Query gagal');
                        }
                    }
                });
            });
        </script>
<?php
    }
}else{ ?>
    <span style="color: black;">Tidak ada pemberitahuan baru</span>
<?php }

?>