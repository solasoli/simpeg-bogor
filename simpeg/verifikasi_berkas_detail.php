<?php
    session_start();
    include 'class/cls_berkas.php';
    $oBerkas = new Berkas();
    $idp = $_GET['idp'];
    $idskpd = $_GET['idskpd'];
    $roleBKPP = 0;
    foreach ($_SESSION['role'] as $r) {
        if($r==1){ //ROLE BKPP
            $roleBKPP = 1;
        }
    }
?>

<head>
    <style>
        /*Change the size here of ToolTip*/
        div.tooltip-inner {
            max-width: 250px;
            max-height: 350px;
        }
    </style>
    <link href="js/bootstrap3-dialog/css/bootstrap-dialog.min.css" rel="stylesheet" type="text/css" />
</head>

<div class="container" style="width: 100%;">
    <div class="row">
        <div id="tabmenu<?php echo $idp; ?>" class="col-md-12">
            <ul class="nav nav-pills">
                <li class="active"><a data-toggle="tab" href="#tabsk<?php echo $idp; ?>">Dokumen SK</a></li>
                <li><a data-toggle="tab" href="#tabijazah<?php echo $idp; ?>">Dokumen Ijazah</a></li>
                <li><a data-toggle="tab" href="#tabpendukung<?php echo $idp; ?>">Dokumen Pendukung</a></li>
                <li><a data-toggle="tab" href="#tabjabatan<?php echo $idp; ?>">Dokumen Jabatan</a></li>
            </ul>
            <div id="tabcon<?php echo $idp; ?>" class="tab-content" style="border: 1px solid rgba(46, 46, 46, 0.8)">
                <div id="tabsk<?php echo $idp; ?>" class="tab-pane fade in active">
                    <table id="table_sk" class="display compact" width="100%" cellspacing="0">
                        <thead>
                        <tr>
                            <th>No.</th>
                            <th>Nama SK</th>
                            <th>No.SK</th>
                            <th>Tgl.SK</th>
                            <th>TMT</th>
                            <th>Gol.</th>
                            <th>Masa Kerja</th>
                            <th>Jml.Berkas</th>
                            <th>Verifikasi</th>
                            <th>Aksi</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $oData = $oBerkas->view_berkas_sk_pegawai($idp,0);
                        $i = 1;
                        if ($oData->num_rows > 0) {
                            while ($oto = $oData->fetch_array(MYSQLI_NUM)) {
                                ?>
                                <tr>
                                    <td><?php echo $i++; ?></td>
                                    <td><?php echo $oto[2]; ?></td>
                                    <td><?php echo $oto[3]; ?></td>
                                    <td><?php echo $oto[4]; ?></td>
                                    <td><?php echo $oto[5]; ?></td>
                                    <td><?php echo $oto[6]; ?></td>
                                    <td><?php
                                        if ($oto[7] == '' and $oto[8] == '') {
                                            echo '-';
                                        } else {
                                            echo $oto[7] . ' Thn ' . $oto[8] . ' Bln';
                                        }
                                        ?>
                                    </td>
                                    <td style="text-align: center">
                                        <?php
                                            $file = '';
                                            $jml = $oto[13];
                                            $listfile = explode(",",$oto[12]);
                                            foreach ($listfile as $s) {
                                                if(file_exists(str_replace("\\","/",getcwd()).'/Berkas/'.trim($s))){
                                                    $file .= trim($s).', ';
                                                }else{
                                                    $jml = $jml - 1;
                                                }
                                            }
                                            $file = substr($file, 0, strlen($file) - 2);
                                        ?>
                                        <a id="jmlToolTipSK<?php echo $oto[0] . $oto[9]; ?>" data-toggle="tooltip"
                                           data-placement="bottom"
                                           title="<?php echo $file; ?>">
                                            <?php echo $jml; ?></a>
                                    </td>
                                    <td>
                                        <?php
                                        if($jml == 0) {
                                            echo '<span id="labelVerifSK' . $oto[0] . $oto[9] . '" class="label label-danger">No Berkas</span>';
                                        }else{
                                            if ($oto[10] == 1) {
                                                echo '<span id="labelVerifSK'.$oto[0].$oto[9].'" class="label label-danger">' . $oto[11] . '</span>';
                                            } elseif ($oto[10] == 2) {
                                                echo '<span id="labelVerifSK'.$oto[0].$oto[9].'" class="label label-warning">' . $oto[11] . '</span>';
                                            } elseif ($oto[10] == 3) {
                                                echo '<span id="labelVerifSK'.$oto[0].$oto[9].'" class="label label-success">' . $oto[11] . '</span>';
                                            } elseif ($oto[10] == 4) {
                                                echo '<span id="labelVerifSK' . $oto[0] . $oto[9] . '" class="label label-default">' . $oto[11] . '</span>';
                                            }
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <button id="btnSkCek<?php echo $oto[0].$oto[9]; ?>" type="button" class="btn btn-primary btn-xs <?php echo $jml==0?'disabled':'active'; ?>" data-toggle="tooltip"
                                                data-placement="bottom" title="Cek Berkas">
                                            <span class="glyphicon glyphicon-search"></span></button>
                                            <?php
                                                if($jml>0){
                                            ?>
                                            <script type="text/javascript">
                                                $("#btnSkCek<?php echo $oto[0].$oto[9]; ?>").click(function () {
                                                    openWindowCekBerkas(<?php echo($oto[9]); ?>);
                                                });
                                            </script>
                                            <?php }?>

                                        <!--<span data-toggle="modal" data-target="#modSKUpload<?php //echo $oto[9]; ?>"> -->
                                        <button id="btnSkUpload<?php echo $oto[0].$oto[9]; ?>" type="button" class="btn btn-primary btn-xs" data-toggle="tooltip"
                                                data-placement="bottom" title="Upload File" <?php echo $roleBKPP==0?($oto[10]==3?'disabled':''):'' ?>>
                                            <span class="glyphicon glyphicon-upload"></span></button><!--</span>-->
                                        <script type="text/javascript">
                                            $("#btnSkUpload<?php echo $oto[0].$oto[9]; ?>").click(function () {
                                                loadUploadFileWindow('modSKUpload<?php echo $oto[0].$oto[9]; ?>','divUploadWin<?php echo $oto[0].$oto[9]; ?>','<?php echo $oto[0]; ?>','<?php echo $oto[9]; ?>','<?php echo $file; ?>','SK','SK <?php echo $oto[2]; ?>','<?php echo $oto[3]; ?>');
                                            });
                                        </script>

                                        <!-- MODAL UPLOAD SK -->
                                        <!-- Modal -->
                                        <div class="modal fade" id="modSKUpload<?php echo $oto[0].$oto[9]; ?>" role="dialog">
                                            <div class="modal-dialog modal-lg" style="max-height: 350px;">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                        <h4 class="modal-title">Upload Berkas Pegawai</h4>
                                                    </div>
                                                    <div class="modal-body" style="height: 200px; width: 100%; overflow-y: scroll;">
                                                        <div id="divUploadWin<?php echo $oto[0].$oto[9]; ?>" style="margin-top: -10px;"></div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <input type="hidden" id="jmlBerkasHid<?php echo $oto[0].$oto[9]; ?>" value="<?php echo $jml.'-'.$oto[0].'-'.$oto[9];?>">
                                                        <button id="btnClose<?php echo $oto[0].$oto[9]; ?>" type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <script>
                                            $("#modSKUpload<?php echo $oto[0].$oto[9]; ?>").on('hidden.bs.modal', function(){
                                                //var jmlBerkas = $("#jmlBerkasHid<?php //echo $oto[0].$oto[9]; ?>").val();
                                                //var jmlBerkas = $("#jmlToolTip<?php //echo $oto[0].$oto[9]; ?>").text();
                                                //alert(jmlBerkas);
                                            });
                                        </script>

                                        <span id="spnVerifSK<?php echo $oto[0].$oto[9]; ?>" <?php echo ($jml==0?'data-toggle=""': ($roleBKPP==1?($idskpd==4198?'data-toggle="modal"':($oto[10] == 1?'data-toggle=""':'data-toggle="modal"')):($oto[10]==3?'data-toggle=""':'data-toggle="modal"'))); ?> data-target="#modSKVerif<?php echo $oto[0].$oto[9]; ?>">
                                        <button id="btnSkVerif<?php echo $oto[0].$oto[9]; ?>" type="button" class="btn btn-primary btn-xs <?php echo ($jml==0?'disabled': ($roleBKPP==1?($idskpd==4198?'active':($oto[10] == 1?'disabled':'active')):($oto[10]==3?'disabled':'active'))); ?>" data-toggle="tooltip"
                                                data-placement="bottom" title="Ubah Verifikasi">
                                            <span class="glyphicon glyphicon-edit"></span></button></span>

                                        <!-- MODAL VERIF SK -->
                                        <!-- Modal -->
                                        <div class="modal fade" id="modSKVerif<?php echo $oto[0].$oto[9]; ?>" role="dialog">
                                            <div class="modal-dialog modal-sm">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                        <h4 class="modal-title">Informasi</h4>
                                                    </div>
                                                    <div class="modal-body" style="height: 50px;">
                                                        <p>Anda yakin ingin mengubah status verifikasi berkas?</p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-success" id="btnSave<?php echo $oto[0].$oto[9]; ?>">Ya</button>
                                                        <button type="button" class="btn btn-default" data-dismiss="modal">Tidak</button>
                                                        <script>
                                                            $("#btnSave<?php echo $oto[0].$oto[9]; ?>").click(function () {
                                                                updateStatusVerif('modSKVerif<?php echo $oto[0].$oto[9]; ?>',<?php echo $jml==0?0:$oto[9]; ?>,'labelVerifSK<?php echo $oto[0].$oto[9]; ?>',document.getElementById('labelVerifSK<?php echo $oto[0].$oto[9]; ?>').innerHTML);
                                                            });
                                                        </script>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <?php
                            }
                        } else {
                            ?>
                            <tr>
                                <td></td>
                                <td>No record</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                        <?php } ?>

                        </tbody>
                    </table>
                </div>
                <div id="tabijazah<?php echo $idp; ?>" class="tab-pane fade">
                    <table id="table_ijazah" class="display" width="100%" cellspacing="0">
                        <thead>
                        <tr>
                            <th>No.</th>
                            <th>Pendidikan</th>
                            <th>Lembaga</th>
                            <th>Jurusan</th>
                            <th>Tahun Lulus</th>
                            <th>Jml.Berkas</th>
                            <th>Verifikasi</th>
                            <th>Aksi</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $oData = $oBerkas->view_berkas_pendidikan_pegawai($idp,0);
                        $i = 1;
                        if ($oData->num_rows > 0) {
                            while ($oto = $oData->fetch_array(MYSQLI_NUM)) {
                                ?>
                                <tr>
                                    <td><?php echo $i++; ?></td>
                                    <td><?php echo $oto[1]; ?></td>
                                    <td><?php echo $oto[2]; ?></td>
                                    <td><?php echo $oto[3]; ?></td>
                                    <td><?php echo $oto[4]; ?></td>
                                    <td style="text-align: center">
                                        <?php
                                        $file = '';
                                        $jml = $oto[9];
                                        $listfile = explode(",",$oto[8]);
                                        foreach ($listfile as $s) {
                                            if(file_exists(str_replace("\\","/",getcwd()).'/Berkas/'.trim($s))){
                                                $file .= trim($s).', ';
                                            }else{
                                                $jml = $jml - 1;
                                            }
                                        }
                                        $file = substr($file, 0, strlen($file) - 2);
                                        ?>

                                        <a id="jmlToolTipPend<?php echo $oto[0] . $oto[5]; ?>" data-toggle="tooltip"
                                           data-placement="bottom"
                                           title="<?php echo $file; ?>">
                                            <?php echo $jml; ?></a>
                                    </td>
                                    <td><?php
                                        if($jml == 0){
                                            echo '<span id="labelVerifPend' . $oto[0] . $oto[5] . '" class="label label-danger">No Berkas</span>';
                                        }else{
                                            if ($oto[6] == 1) {
                                                echo '<span id="labelVerifPend'.$oto[0].$oto[5].'" class="label label-danger">' . $oto[7] . '</span>';
                                            } elseif ($oto[6] == 2) {
                                                echo '<span id="labelVerifPend'.$oto[0].$oto[5].'" class="label label-warning">' . $oto[7] . '</span>';
                                            } elseif ($oto[6] == 3) {
                                                echo '<span id="labelVerifPend'.$oto[0].$oto[5].'" class="label label-success">' . $oto[7] . '</span>';
                                            } elseif ($oto[6] == 4) {
                                                echo '<span id="labelVerifPend' . $oto[0] . $oto[5] . '" class="label label-default">' . $oto[7] . '</span>';
                                            }
                                        }
                                        ?></td>
                                    <td>
                                        <button id="btnPendCek<?php echo $oto[0].$oto[5]; ?>" type="button" class="btn btn-primary btn-xs <?php echo $jml==0?'disabled':'active'; ?>" data-toggle="tooltip"
                                                data-placement="bottom" title="Cek Berkas">
                                            <span class="glyphicon glyphicon-search"></span></button>
                                        <?php
                                        if($jml>0){
                                            ?>
                                            <script type="text/javascript">
                                                $("#btnPendCek<?php echo $oto[0].$oto[5]; ?>").click(function () {
                                                    openWindowCekBerkas(<?php echo($oto[5]); ?>);
                                                });
                                            </script>
                                        <?php }?>

                                        <!--<span data-toggle="modal" data-target="#modSKUpload<?php //echo $oto[9]; ?>"> -->
                                        <button id="btnPendUpload<?php echo $oto[0].$oto[5]; ?>" type="button" class="btn btn-primary btn-xs" data-toggle="tooltip"
                                                data-placement="bottom" title="Upload File" <?php echo $roleBKPP==0?($oto[6]==3?'disabled':''):'' ?>>
                                            <span class="glyphicon glyphicon-upload"></span></button><!--</span>-->

                                        <script type="text/javascript">
                                            $("#btnPendUpload<?php echo $oto[0].$oto[5]; ?>").click(function () {
                                                loadUploadFileWindow('modPendUpload<?php echo $oto[0].$oto[5]; ?>','divUploadWinPend<?php echo $oto[0].$oto[5]; ?>','<?php echo $oto[0]; ?>','<?php echo $oto[5]; ?>','<?php echo $file; ?>','Ijazah','Ijazah','<?php echo $oto[1]; ?>');
                                            });
                                        </script>

                                        <!-- MODAL UPLOAD PENDIDIKAN -->
                                        <!-- Modal -->
                                        <div class="modal fade" id="modPendUpload<?php echo $oto[0].$oto[5]; ?>" role="dialog">
                                            <div class="modal-dialog modal-lg" style="max-height: 350px;">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                        <h4 class="modal-title">Upload Berkas Pegawai</h4>
                                                    </div>
                                                    <div class="modal-body" style="height: 200px; width: 100%; overflow-y: scroll;">
                                                        <div id="divUploadWinPend<?php echo $oto[0].$oto[5]; ?>" style="margin-top: -10px;"></div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button id="btnClosePend<?php echo $oto[0].$oto[5]; ?>" type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <span id="spnVerifPend<?php echo $oto[0].$oto[5]; ?>" <?php echo ($jml==0?'data-toggle=""': ($roleBKPP==1?($idskpd==4198?'data-toggle="modal"':($oto[6] == 1?'data-toggle=""':'data-toggle="modal"')):($oto[6]==3?'data-toggle=""':'data-toggle="modal"'))); ?> data-target="#modPendVerif<?php echo $oto[0].$oto[5]; ?>">
                                        <button id="btnPendVerif<?php echo $oto[0].$oto[5]; ?>" type="button" class="btn btn-primary btn-xs <?php echo ($jml==0?'disabled': ($roleBKPP==1?($idskpd==4198?'active':($oto[6] == 1?'disabled':'active')):($oto[6]==3?'disabled':'active'))); ?>" data-toggle="tooltip"
                                                data-placement="bottom" title="Ubah Verifikasi">
                                            <span class="glyphicon glyphicon-edit"></span></button></span>

                                        <!-- MODAL VERIF PENDIDIKAN -->
                                        <!-- Modal -->
                                        <div class="modal fade" id="modPendVerif<?php echo $oto[0].$oto[5]; ?>" role="dialog">
                                            <div class="modal-dialog modal-sm">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                        <h4 class="modal-title">Informasi</h4>
                                                    </div>
                                                    <div class="modal-body" style="height: 50px;">
                                                        <p>Anda yakin ingin mengubah status verifikasi berkas?</p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-success" id="btnSavePend<?php echo $oto[0].$oto[5]; ?>">Ya</button>
                                                        <button type="button" class="btn btn-default" data-dismiss="modal">Tidak</button>
                                                        <script>
                                                            $("#btnSavePend<?php echo $oto[0].$oto[5]; ?>").click(function () {
                                                                    updateStatusVerif('modPendVerif<?php echo $oto[0].$oto[5]; ?>',<?php echo $jml==0?0:$oto[5]; ?>,'labelVerifPend<?php echo $oto[0].$oto[5]; ?>',document.getElementById('labelVerifPend<?php echo $oto[0].$oto[5]; ?>').innerHTML);
                                                            });
                                                        </script>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </td>
                                </tr>
                                <?php
                            }
                        } else {
                            ?>
                            <tr>
                                <td></td>
                                <td>No record</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
                <div id="tabpendukung<?php echo $idp; ?>" class="tab-pane fade">
                    <table id="table_pendukung" class="display" width="100%" cellspacing="0">
                        <thead>
                        <tr>
                            <th style="width: 5%;">No.</th>
                            <th style="width: 15%;">Nama</th>
                            <th style="width: 15%;">Nomor</th>
                            <th style="width: 5%;">Jml.Berkas</th>
                            <th style="width: 5%;">Verifikasi</th>
                            <th style="width: 55%;">Aksi</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $oData = $oBerkas->view_berkas_pendukung_pegawai($idp,0);
                        $i = 1;
                        if ($oData->num_rows > 0) {
                            while ($oto = $oData->fetch_array(MYSQLI_NUM)) {
                                ?>
                                <tr>
                                    <td><?php echo $i++; ?></td>
                                    <td><?php echo $oto[1]; ?></td>
                                    <td><?php echo $oto[2]; ?></td>
                                    <td style="text-align: center">
                                        <?php
                                        $file = '';
                                        $jml = $oto[6];
                                        $listfile = explode(",",$oto[5]);
                                        foreach ($listfile as $s) {
                                            if(file_exists(str_replace("\\","/",getcwd()).'/Berkas/'.trim($s))){
                                                $file .= trim($s).', ';
                                            }else{
                                                $jml = $jml - 1;
                                            }
                                        }
                                        $file = substr($file, 0, strlen($file) - 2);
                                        ?>

                                        <a id="jmlToolTipSupp<?php echo $oto[0]; ?>" data-toggle="tooltip"
                                           data-placement="bottom"
                                           title="<?php echo $file; ?>">
                                            <?php echo $jml; ?></a>
                                    </td>
                                    <td><?php
                                        if($jml == 0){
                                            echo '<span id="labelVerifSupp' . $oto[0]. '" class="label label-danger">No Berkas</span>';
                                        }else{
                                            if ($oto[3] == 1) {
                                                echo '<span id="labelVerifSupp'.$oto[0].'" class="label label-danger">' . $oto[4] . '</span>';
                                            } elseif ($oto[3] == 2) {
                                                echo '<span id="labelVerifSupp'.$oto[0].'" class="label label-warning">' . $oto[4] . '</span>';
                                            } elseif ($oto[3] == 3) {
                                                echo '<span id="labelVerifSupp'.$oto[0].'" class="label label-success">' . $oto[4] . '</span>';
                                            } elseif ($oto[3] == 4) {
                                                echo '<span id="labelVerifSupp' . $oto[0]. '" class="label label-default">' . $oto[4] . '</span>';
                                            }
                                        }
                                        ?></td>
                                    <td>
                                        <button id="btnSuppCek<?php echo $oto[0]; ?>" type="button" class="btn btn-primary btn-xs <?php echo $jml==0?'disabled':'active'; ?>" data-toggle="tooltip"
                                                data-placement="bottom" title="Cek Berkas">
                                            <span class="glyphicon glyphicon-search"></span></button>
                                        <?php
                                        if($jml>0){
                                            ?>
                                            <script type="text/javascript">
                                                $("#btnSuppCek<?php echo $oto[0]; ?>").click(function () {
                                                    openWindowCekBerkas(<?php echo($oto[0]); ?>);
                                                });
                                            </script>
                                        <?php }?>

                                        <!--<span data-toggle="modal" data-target="#modSKUpload<?php //echo $oto[9]; ?>"> -->
                                        <button id="btnSuppUpload<?php echo $oto[0]; ?>" type="button" class="btn btn-primary btn-xs" data-toggle="tooltip"
                                                data-placement="bottom" title="Upload File" <?php echo $roleBKPP==0?($oto[3]==3?'disabled':''):'' ?>>
                                            <span class="glyphicon glyphicon-upload"></span></button><!--</span>-->

                                        <script type="text/javascript">
                                            $("#btnSuppUpload<?php echo $oto[0]; ?>").click(function () {
                                                loadUploadFileWindow('modSuppUpload<?php echo $oto[0]; ?>','divUploadWinSupp<?php echo $oto[0]; ?>','<?php echo $oto[0]; ?>','<?php echo $oto[0]; ?>','<?php echo $file; ?>','Pendukung','<?php echo $oto[1]; ?>','<?php echo $oto[2]; ?>');
                                            });
                                        </script>

                                        <!-- MODAL UPLOAD PENDUKUNG -->
                                        <!-- Modal -->
                                        <div class="modal fade" id="modSuppUpload<?php echo $oto[0]; ?>" role="dialog">
                                            <div class="modal-dialog modal-lg" style="max-height: 350px;">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                        <h4 class="modal-title">Upload Berkas Pegawai</h4>
                                                    </div>
                                                    <div class="modal-body" style="height: 200px; width: 100%; overflow-y: scroll;">
                                                        <div id="divUploadWinSupp<?php echo $oto[0]; ?>" style="margin-top: -10px;"></div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button id="btnClosePend<?php echo $oto[0]; ?>" type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <span id="spnVerifSupp<?php echo $oto[0]; ?>" <?php echo ($jml==0?'data-toggle=""': ($roleBKPP==1?($idskpd==4198?'data-toggle="modal"':($oto[3] == 1?'data-toggle=""':'data-toggle="modal"')):($oto[3]==3?'data-toggle=""':'data-toggle="modal"'))); ?> data-target="#modSuppVerif<?php echo $oto[0]; ?>">
                                        <button id="btnSuppVerif<?php echo $oto[0]; ?>" type="button" class="btn btn-primary btn-xs <?php echo ($jml==0?'disabled': ($roleBKPP==1?($idskpd==4198?'active':($oto[3] == 1?'disabled':'active')):($oto[3]==3?'disabled':'active'))); ?>" data-toggle="tooltip"
                                                data-placement="bottom" title="Ubah Verifikasi">
                                            <span class="glyphicon glyphicon-edit"></span></button></span>

                                        <!-- MODAL VERIF PENDUKUNG -->
                                        <!-- Modal -->
                                        <div class="modal fade" id="modSuppVerif<?php echo $oto[0]; ?>" role="dialog">
                                            <div class="modal-dialog modal-sm">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                        <h4 class="modal-title">Informasi</h4>
                                                    </div>
                                                    <div class="modal-body" style="height: 50px;">
                                                        <p>Anda yakin ingin mengubah status verifikasi berkas?</p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-success" id="btnSaveSupp<?php echo $oto[0]; ?>">Ya</button>
                                                        <button type="button" class="btn btn-default" data-dismiss="modal">Tidak</button>
                                                        <script>
                                                            $("#btnSaveSupp<?php echo $oto[0]; ?>").click(function () {
                                                                    updateStatusVerif('modSuppVerif<?php echo $oto[0]; ?>',<?php echo $jml==0?0:$oto[0]; ?>,'labelVerifSupp<?php echo $oto[0]; ?>',document.getElementById('labelVerifSupp<?php echo $oto[0]; ?>').innerHTML);
                                                            });
                                                        </script>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <?php
                            }
                        } else {
                            ?>
                            <tr>
                                <td></td>
                                <td>No record</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
                <div id="tabjabatan<?php echo $idp; ?>" class="tab-pane fade">
                    <table id="table_jabatan" class="display" width="100%" cellspacing="0">
                        <thead>
                        <tr>
                            <th>No.</th>
                            <th>No.SK</th>
                            <th>Tgl.SK</th>
                            <th>TMT</th>
                            <th>Gol.</th>
                            <th>M.K.</th>
                            <th>Jabatan</th>
                            <th>Jml.Berkas</th>
                            <th>Verifikasi</th>
                            <th style="width: 10%;">Aksi</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $oData = $oBerkas->view_berkas_jabatan_pegawai($idp,0);
                        $i = 1;
                        if ($oData->num_rows > 0) {
                            while ($oto = $oData->fetch_array(MYSQLI_NUM)) {
                                ?>
                                <tr>
                                    <td><?php echo $i++; ?></td>
                                    <td><?php echo $oto[1]; ?></td>
                                    <td><?php echo $oto[2]; ?></td>
                                    <td><?php echo $oto[3]; ?></td>
                                    <td><?php echo $oto[4]; ?></td>
                                    <td><?php
                                        if ($oto[5] == '' and $oto[6] == '') {
                                            echo '-';
                                        } else {
                                            echo $oto[5] . ' Thn ' . $oto[6] . ' Bln';
                                        }
                                        ?></td>
                                    <td><?php echo $oto[9].'<br>Eselon: '.$oto[10]; ?></td>
                                    <td style="text-align: center">
                                        <?php
                                        $file = '';
                                        $jml = $oto[14];
                                        $listfile = explode(",",$oto[13]);
                                        foreach ($listfile as $s) {
                                            if(file_exists(str_replace("\\","/",getcwd()).'/Berkas/'.trim($s))){
                                                $file .= trim($s).', ';
                                            }else{
                                                $jml = $jml - 1;
                                            }
                                        }
                                        $file = substr($file, 0, strlen($file) - 2);
                                        ?>

                                        <a id="jmlToolTipJab<?php echo $oto[0] . $oto[7]; ?>" data-toggle="tooltip"
                                                                      data-placement="bottom"
                                                                      title="<?php echo $file; ?>">
                                            <?php echo $jml; ?></a></td>
                                    <td><?php
                                        if($jml == 0) {
                                            echo '<span id="labelVerifJab' . $oto[0] . $oto[7] . '" class="label label-danger">No Berkas</span>';
                                        }else{
                                            if ($oto[11] == 1) {
                                                echo '<span id="labelVerifJab'.$oto[0].$oto[7].'" class="label label-danger">' . $oto[12] . '</span>';
                                            } elseif ($oto[11] == 2) {
                                                echo '<span id="labelVerifJab'.$oto[0].$oto[7].'" class="label label-warning">' . $oto[12] . '</span>';
                                            } elseif ($oto[11] == 3) {
                                                echo '<span id="labelVerifJab'.$oto[0].$oto[7].'" class="label label-success">' . $oto[12] . '</span>';
                                            } elseif ($oto[11] == 4) {
                                                echo '<span id="labelVerifJab' . $oto[0] . $oto[7] . '" class="label label-default">' . $oto[12] . '</span>';
                                            }
                                        }
                                        ?></td>
                                    <td>
                                        <button id="btnJabCek<?php echo $oto[0].$oto[7]; ?>" type="button" class="btn btn-primary btn-xs <?php echo $jml==0?'disabled':'active'; ?>" data-toggle="tooltip"
                                                data-placement="bottom" title="Cek Berkas">
                                            <span class="glyphicon glyphicon-search"></span></button>
                                        <?php
                                        if($jml>0){
                                            ?>
                                            <script type="text/javascript">
                                                $("#btnJabCek<?php echo $oto[0].$oto[7]; ?>").click(function () {
                                                    openWindowCekBerkas(<?php echo($oto[7]); ?>);
                                                });
                                            </script>
                                        <?php }?>

                                        <!--<span data-toggle="modal" data-target="#modSKUpload<?php //echo $oto[9]; ?>"> -->
                                        <button id="btnJabUpload<?php echo $oto[0].$oto[7]; ?>" type="button" class="btn btn-primary btn-xs" data-toggle="tooltip"
                                                data-placement="bottom" title="Upload File" <?php echo $roleBKPP==0?($oto[11]==3?'disabled':''):'' ?>
                                                onclick="loadUploadFileWindow('modJabUpload<?php echo $oto[0].$oto[7]; ?>','divUploadWin<?php echo $oto[0].$oto[7]; ?>','<?php echo $oto[0]; ?>','<?php echo $oto[7]; ?>','<?php echo $file; ?>','Jabatan','SK Jabatan','<?php echo $oto[1]; ?>' );">
                                            <span class="glyphicon glyphicon-upload"></span></button><!--</span>-->

                                        <!-- MODAL UPLOAD JABATAN -->
                                        <!-- Modal -->
                                        <div class="modal fade" id="modJabUpload<?php echo $oto[0].$oto[7]; ?>" role="dialog">
                                            <div class="modal-dialog modal-lg" style="max-height: 350px;">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                        <h4 class="modal-title">Upload Berkas Pegawai</h4>
                                                    </div>
                                                    <div class="modal-body" style="height: 200px; width: 100%; overflow-y: scroll;">
                                                        <div id="divUploadWin<?php echo $oto[0].$oto[7]; ?>" style="margin-top: -10px;"></div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button id="btnClose<?php echo $oto[0].$oto[7]; ?>" type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <span id="spnVerifJab<?php echo $oto[0].$oto[7]; ?>" <?php echo ($jml==0?'data-toggle=""': ($roleBKPP==1?($idskpd==4198?'data-toggle="modal"':($oto[11] == 1?'data-toggle=""':'data-toggle="modal"')):($oto[11]==3?'data-toggle=""':'data-toggle="modal"'))); ?> data-target="#modJabVerif<?php echo $oto[0].$oto[7]; ?>">
                                        <button id="btnJabVerif<?php echo $oto[0].$oto[7]; ?>" type="button" class="btn btn-primary btn-xs <?php echo ($jml==0?'disabled':($roleBKPP==1?($idskpd==4198?'active':($oto[11] == 1?'disabled':'active')):($oto[11]==3?'disabled':'active'))); ?>" data-toggle="tooltip"
                                                data-placement="bottom" title="Ubah Verifikasi">
                                            <span class="glyphicon glyphicon-edit"></span></button></span>

                                        <!-- MODAL VERIF JABATAN -->
                                        <!-- Modal -->
                                        <div class="modal fade" id="modJabVerif<?php echo $oto[0].$oto[7]; ?>" role="dialog">
                                            <div class="modal-dialog modal-sm">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                        <h4 class="modal-title">Informasi</h4>
                                                    </div>
                                                    <div class="modal-body" style="height: 50px;">
                                                        <p>Anda yakin ingin mengubah status verifikasi berkas?</p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-success" id="btnSaveJab<?php echo $oto[0].$oto[7]; ?>">Ya</button>
                                                        <button type="button" class="btn btn-default" data-dismiss="modal">Tidak</button>
                                                        <script>
                                                            $("#btnSaveJab<?php echo $oto[0].$oto[7]; ?>").click(function () {
                                                                    updateStatusVerif('modJabVerif<?php echo $oto[0].$oto[7]; ?>',<?php echo $jml==0?0:$oto[7]; ?>,'labelVerifJab<?php echo $oto[0].$oto[7]; ?>',document.getElementById('labelVerifJab<?php echo $oto[0].$oto[7]; ?>').innerHTML);
                                                            });
                                                        </script>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </td>
                                </tr>
                                <?php
                            }
                        } else {
                            ?>
                            <tr>
                                <td></td>
                                <td>No record</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script id="FormDialog" type="text/placeholder">
    <form role="form">
        <label class="radio-inline"><input type="radio" name="optKonfirm" value="3" checked>Setuju</label>
        <label class="radio-inline"><input type="radio" name="optKonfirm" value="4">Perbaiki Berkas</label>
        <label class="radio-inline"><input type="radio" name="optKonfirm" value="0">Batalkan</label>
    </form>
</script>

<script language="javascript">
    $(document).ready(function () {
        $('[data-toggle="tooltip"]').tooltip();
    });


    function openWindowCekBerkas($idberkas){
        window.open("verifikasi_cek_berkas.php?idberkas="+$idberkas,'_blank');
    }

    function OpenDialogVerification(title, content, callback) {
        var dlg = new BootstrapDialog({
            title: title,
            message: content,
            closable: true,
            closeByBackdrop: false,
            closeByKeyboard: false,
            buttons: [{
                label: 'Simpan',
                cssClass: 'btn-primary',
                id: 'btnSave',
                action: function (dialog) {
                    if (callback !== "") { callback(); }
                    dialog.close();
                }
            },{
                label: 'Tutup',
                cssClass: 'btn',
                id: 'btnClose',
                action: function (dialog) {
                    dialog.close();
                }
            }]
        });
        dlg.open();
    }

    function updateStatusVerif($modal,$idberkas,$label,$idstatus){
        <?php
            if($roleBKPP==1){ ?>
                $("#"+$modal).modal('hide');
                var content = $($("#FormDialog").html());
                OpenDialogVerification('Konfirmasi BKPP', content, function() {
                    $idstatus = $('input:radio[name=optKonfirm]:checked').val();
                    $.ajax({
                        type: "GET",
                        dataType: "json",
                        url: "class/cls_ajax_data.php?filter=update_verif_bkpp&idberkas="+ $idberkas + '&idstatus=' + $idstatus + '&idp=' + <?php echo $idp;?>,
                        success: function (results) {
                            //$("#divInformasiBerkas"+d.id_pegawai).html(data);
                            var hasil, status = '';
                            $.each(results, function(k, v){
                                hasil = v.hasil;
                                status = v.status;
                            });
                            if(hasil == 1){
                                document.getElementById($label).innerHTML = status;
                                $('#'+$label).removeClass('label-danger');
                                $('#'+$label).removeClass('label-warning');
                                $('#'+$label).removeClass('label-default');
                                $('#'+$label).removeClass('label-success');
                                if(status == 'Perbaiki'){
                                    $('#'+$label).addClass('label-default');
                                }else if(status == 'BKPP') {
                                    $('#' + $label).addClass('label-success');
                                }else if(status == 'SKPD'){
                                    $('#' + $label).addClass('label-warning');
                                }else if(status == 'Belum'){
                                    $('#' + $label).addClass('label-danger');
                                }
                            }else{
                                alert('Query gagal');
                            }
                            $("#"+$modal).modal('hide');
                        }
                    });
                });
            <?php }else{ ?>
                $.ajax({
                    type: "GET",
                    dataType: "json",
                    url: "class/cls_ajax_data.php?filter=update_verif&idberkas="+ $idberkas + '&idstatus=' + $idstatus,
                    success: function (results) {
                        //$("#divInformasiBerkas"+d.id_pegawai).html(data);
                        var hasil, status = '';
                        $.each(results, function(k, v){
                            hasil = v.hasil;
                            status = v.status;
                        });
                        if(hasil == 1){
                            document.getElementById($label).innerHTML = status;
                            if(status == 'Belum'){
                                $('#'+$label).removeClass('label-warning').addClass('label-danger');
                            }else{
                                $('#'+$label).removeClass('label-danger').addClass('label-warning');
                            }
                        }else{
                            alert('Query gagal');
                        }
                        $("#"+$modal).modal('hide');
                    }
                });
        <?php } ?>
    }

    function loadUploadFileWindow($modal, $winupload, $idawal, $idberkas, $file, $jenis, $nm_berkas, $ket_berkas){
        var request = $.get("verifikasi_upload_berkas.php?idberkas="+$idberkas+"&filelist="+$file+'&idawal='+$idawal+'&jenis='+$jenis+'&nm_berkas='+$nm_berkas+'&ket_berkas='+$ket_berkas+'&idpeg='+<?php echo $idp; ?>);
        request.pipe(
            function( response ){
                if (response.success){
                    return( response );
                }else{
                    return(
                        $.Deferred().reject( response )
                    );
                }
            },
            function( response ){
                return({
                    success: false,
                    data: null,
                    errors: [ "Unexpected error: " + response.status + " " + response.statusText ]
                });
            }
        );
        request.then(
            function( response ){
                $("#"+$winupload).html(response);
            }
        );
        $("#"+$modal).modal('show');
    }

</script>

<!-- The template to display files available for upload -->
<script id="template-upload" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
    <tr class="template-upload fade">
        <td>
            <span class="preview"></span>
        </td>
        <td>
            <p class="name">{%=file.name%}</p>
            <strong class="error text-danger"></strong>
        </td>
        <td>
            <p class="size">Processing...</p>
            <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0"><div class="progress-bar progress-bar-success" style="width:0%;"></div></div>
        </td>
        <td>
            {% if (!i && !o.options.autoUpload) { %}
                <button class="btn btn-primary start" disabled>
                    <i class="glyphicon glyphicon-upload"></i>
                    <span>Start</span>
                </button>
            {% } %}
            {% if (!i) { %}
                <button class="btn btn-warning cancel">
                    <i class="glyphicon glyphicon-ban-circle"></i>
                    <span>Cancel</span>
                </button>
            {% } %}
        </td>
    </tr>
{% } %}
</script>
<!-- The template to display files available for download -->
<script id="template-download" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
    <tr class="template-download fade">
        <td>
            <span class="preview">
                {% if (file.thumbnailUrl) { %}
                    <a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" data-gallery><img src="{%=file.thumbnailUrl%}"></a>
                {% } %}
            </span>
        </td>
        <td>
            <p class="name">
                {% if (file.url) { %}
                    <a href="{%=file.url%}" title="{%=file.name%}" {%=file.thumbnailUrl?'data-gallery':''%} target = "_blank">{%=file.name%}</a>
                {% } else { %}
                    <span>{%=file.name%}</span>
                {% } %}
            </p>
            {% if (file.error) { %}
                <div><span class="label label-danger">Error</span> {%=file.error%}</div>
            {% } %}
        </td>
        <td>
            <span class="size">{%=o.formatFileSize(file.size)%}</span>
        </td>
        <td>
            {% if (file.deleteUrl) { %}
                <button class="btn btn-danger delete" data-type="{%=file.deleteType%}" data-url="{%=file.deleteUrl%}"{% if (file.deleteWithCredentials) { %} data-xhr-fields='{"withCredentials":true}'{% } %}>
                    <i class="glyphicon glyphicon-trash"></i>
                    <span>Delete</span>
                </button>
                <input type="checkbox" name="delete" value="1" class="toggle">
            {% } else { %}
                <button class="btn btn-warning cancel">
                    <i class="glyphicon glyphicon-ban-circle"></i>
                    <span>Cancel</span>
                </button>
            {% } %}
        </td>
    </tr>
{% } %}
</script>

<!-- The jQuery UI widget factory, can be omitted if jQuery UI is already included -->
<script src="js/jQuery-File-Upload-9.12.3/js/vendor/jquery.ui.widget.js"></script>
<!-- The Templates plugin is included to render the upload/download listings -->
<script src="js/jQuery-File-Upload-9.12.3/js/tmpl.min.js"></script>
<!-- The Load Image plugin is included for the preview images and image resizing functionality -->
<script src="js/jQuery-File-Upload-9.12.3/js/load-image.all.min.js"></script>
<!-- The Canvas to Blob plugin is included for image resizing functionality -->
<script src="js/jQuery-File-Upload-9.12.3/js/canvas-to-blob.min.js"></script>
<!-- blueimp Gallery script -->
<script src="js/jQuery-File-Upload-9.12.3/js/jquery.blueimp-gallery.min.js"></script>
<!-- The Iframe Transport is required for browsers without support for XHR file uploads -->
<script src="js/jQuery-File-Upload-9.12.3/js/jquery.iframe-transport.js"></script>
<!-- The basic File Upload plugin -->
<script src="js/jQuery-File-Upload-9.12.3/js/jquery.fileupload.js"></script>
<!-- The File Upload processing plugin -->
<script src="js/jQuery-File-Upload-9.12.3/js/jquery.fileupload-process.js"></script>
<!-- The File Upload image preview & resize plugin -->
<script src="js/jQuery-File-Upload-9.12.3/js/jquery.fileupload-image.js"></script>
<!-- The File Upload validation plugin -->
<script src="js/jQuery-File-Upload-9.12.3/js/jquery.fileupload-validate.js"></script>
<!-- The File Upload user interface plugin -->
<script src="js/jQuery-File-Upload-9.12.3/js/jquery.fileupload-ui.js"></script>
<!-- The main application script -->
<!-- <script src="js/jQuery-File-Upload-9.12.3/js/main.js"></script> -->
<!-- The XDomainRequest Transport is included for cross-domain file deletion for IE 8 and IE 9 -->
<!--[if (gte IE 8)&(lt IE 10)]>
<script src="js/cors/jquery.xdr-transport.js"></script> -->

<script src="js/bootstrap3-dialog/js/bootstrap-dialog.min.js"></script>