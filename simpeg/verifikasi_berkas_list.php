<?php
     $roleBKPP = 0;
    $oUnitKerja = new Unit_kerja;
    foreach ($_SESSION['role'] as $r) {
        if($r==1){ //ROLE BKPP
            $roleBKPP = 1;
        }
    }
?>

<head>
    <style>
        td.details-control {
            background: url('images/details_open.png') no-repeat center center;
            cursor: pointer;
        }

        tr.shown td.details-control {
            background: url('images/details_close.png') no-repeat center center;
        }

        .loading-progress{
            width:100%;
        }
    </style>
    <script src="js/jquery-progressTimer/js/jquery.progresstimer.js"></script>
</head>

<body>
<div class="container" style="width: 103%; margin-left: -40px;">
    <div class="row">
        <div class="col-md-12"><h2>Verifikasi Berkas Pegawai</h2></div>
    </div>
    <?php
        if($roleBKPP==1){ ?>
        <div class="row" style=" margin-bottom: 25px;">
            <div class="col-md-1" style="margin-top: 5px;">
                Unit Kerja</div>
            <div class="col-md-5">
                <?php
                    $result = $oUnitKerja->get_skpd_list();
                ?>
                <select class="form-control" id="selectUnitKerja">
                    <?php
                        foreach ($result as $r) {
                            if($r->id_unit_kerja == $_SESSION['id_skpd']){
                                $sel = 'selected';
                            }else{
                                $sel = '';
                            }
                            echo "<option value='".$r->id_unit_kerja."' $sel>$r->nama_baru</option>";
                        }
                    ?>
                </select>
            </div>
            <div class="col-md-1"><button id="btnFilterUnit" type="button" class="btn btn-primary" style="margin-left: -20px;">
                    &nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-search"></span>&nbsp;&nbsp;&nbsp;</button></div>
            <script>
                $("#btnFilterUnit").click(function () {
                    RefreshTable('#table_verif');
                });
            </script>
        </div>
    <?php } ?>
    <div class="row">
        <div class="col-md-12">
            <div id="notes" class="loading-progress"></div>
            <div id="walltable">
                <table id="table_verif" class="display" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th></th>
                            <th>No</th>
                            <th>NIP</th>
                            <th>Nama</th>
                            <th>Gol</th>
                            <th>Jabatan</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>
</body>

<script language="JavaScript">
    function RefreshTable(tableId)
    {
        $("#walltable").css("pointer-events", "none");
        $("#walltable").css("opacity", "0.4");
        $idskpd = $( "#selectUnitKerja option:selected" ).val();
        $.getJSON("class/cls_ajax_data.php?filter=verif_berkas&idskpd="+$idskpd, null, function( json )
        {
            table = $(tableId).dataTable();
            oSettings = table.fnSettings();

            table.fnClearTable(this);

            for (var i=0; i<json.data.length; i++)
            {
                table.oApi._fnAddData(oSettings, json.data[i]);
            }

            oSettings.aiDisplay = oSettings.aiDisplayMaster.slice();
            table.fnDraw();
            $("#walltable").css("pointer-events", "auto");
            $("#walltable").css("opacity", "1");
        });
    }

    /* Formatting function for row details - modify as you need */
    function format ( d ) {
        var progress = $(".loading-progress").progressTimer({
            timeLimit: 10,
            onFinish: function () {
                $("#notes").fadeOut();
                //alert('completed!');
            }
        });

        // `d` is the original data object for the row
        $("#notes").fadeIn();
        $("#walltable").css("pointer-events", "none");
        $("#walltable").css("opacity", "0.4");
        $idskpd = $( "#selectUnitKerja option:selected" ).val();
        $.ajax({
            type: "GET",
            url: "verifikasi_berkas_detail.php?idp="+ d.id_pegawai+"&idskpd="+ $idskpd,
            success: function (data) {
                $("#divInformasiBerkas"+d.id_pegawai).html(data);
                $("#walltable").css("pointer-events", "auto");
                $("#walltable").css("opacity", "1");
            }
        }).done(function(){
            progress.progressTimer('complete');
        });
        return '<div id="divInformasiBerkas'+d.id_pegawai+'"></div>';
    }

    $(document).ready(function() {
        var table = $('#table_verif').DataTable( {
            "ajax": "class/cls_ajax_data.php?filter=verif_berkas&idskpd=<?php echo $_SESSION['id_skpd']; ?>",
            "autoWidth": false,
            "columnDefs": [
                { "width": "5%", "targets": 1 },
                { "width": "15%", "targets": 2 },
                { "width": "25%", "targets": 3 },
                { "width": "5%", "targets": 4 },
                { "width": "60%", "targets": 5 }
            ],
            "columns": [
                {
                    "className":      'details-control',
                    "orderable":      false,
                    "data":           null,
                    "defaultContent": ''
                },
                { "data": "no" },
                { "data": "nip_baru" },
                { "data": "nama" },
                { "data": "pangkat_gol" },
                { "data": "jabatan" }
            ],
            "order": [[1, 'asc']]
        } );

        // Add event listener for opening and closing details
        $('#table_verif tbody').on('click', 'td.details-control', function () {
            var tr = $(this).closest('tr');
            var row = table.row( tr );

            if ( row.child.isShown() ) {
                // This row is already open - close it
                row.child.hide();
                tr.removeClass('shown');
            } else {
                // Open this row
                row.child( format(row.data()) ).show();
                tr.addClass('shown');
            }
        } );
    } );
</script>