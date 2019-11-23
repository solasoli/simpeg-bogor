<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>

<ul class="nav nav-tabs" id="tab_container">
    <li class="active">
        <a href="#tab_semua" data-toggle="tab">Semua</a>
    </li>
    <li >
        <a href="#tab_k1" data-toggle="tab">Khusus K1 (TKK)</a>
    </li>
    <li >
        <a href="#tab_k2" data-toggle="tab">Khusus K2</a>
    </li>
</ul>

<div id="myTabContent" class="tab-content">
    <div class="tab-pane fade in active" id="tab_semua">
        <br><br>
        <div id="opd" align="center"></div>
        <script type="text/javascript">
            $(function () {
                $('#opd').highcharts({
                    chart: {
                        plotBackgroundColor: null,
                        plotBorderWidth: 1,//null,
                        plotShadow: false,
                        width: 1500,
                        height: 900

                    },
                    title: {
                        <?php
                        $where = "where flag_pensiun=0 ";
                        $opd = "Pemerintah Kota Bogor";
                        $q = mysqli_query($mysqli,"select count(*) from tkk2");
                        $itung = mysqli_fetch_array($q);

                        ?>
                        text: 'Sebaran Pegawai Non PNS Per Perangkat Daerah di Lingkungan Pemerintah Kota Bogor <?php echo("($itung[0] pegawai)"); ?>'
                    },
                    tooltip: {
                        pointFormat: '{series.name}: <b>{point.y}  </b>'
                    },
                    plotOptions: {
                        pie: {
                            size:'55%',
                            allowPointSelect: true,
                            cursor: 'pointer',
                            startAngle: 90,
                            dataLabels: {
                                enabled: true,
                                padding: 0,

                                format: '<b>{point.name}</b>: {point.percentage:.2f} % ({point.y})',
                                style: {
                                    color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black',fontSize: '10px'
                                }
                            }
                        }
                    },
                    <?php
                    $qg=mysqli_query($mysqli,"select count(*), tkk2.id_unit_kerja, uk.nama_baru
                        from tkk2
                        inner join unit_kerja uk on uk.id_unit_kerja = tkk2.id_unit_kerja
                        group by tkk2.id_unit_kerja
                        ORDER BY count(*) ASC");
                    ?>
                    series: [{
                        type: 'pie',
                        name: 'Jumlah Pegawai',
                        data: [

                            <?php
                            $i=1;
                            while($data=mysqli_fetch_array($qg))
                            {

                                $qunit=mysqli_query($mysqli,"select nama_baru from unit_kerja where id_unit_kerja=$data[1]");
                                $unit=mysqli_fetch_array($qunit);
                                if($i==1)
                                    echo("['".$unit[0]."', $data[0] ]");
                                else
                                    echo(",['".$unit[0]."', $data[0] ]");

                                $i++;
                            }

                            ?>
                        ],
                        point:{
                            events:{

                            }
                        }
                    }]
                });
            });
        </script>
    </div>

    <?php
        function getJumlahNonPNS($status){
            $mysqli = new mysqli("simpeg.db.kotabogor.net","simpeg","Madangkara2017","simpeg");
            $sql = "select count(id_tkk) as jumlah from tkk where status = $status";
            $q = mysqli_query($mysqli,$sql);
            $itung=mysqli_fetch_array($q);
            return $itung[0];
        }

        function getRekapNonPNS($status){
            $mysqli = new mysqli("simpeg.db.kotabogor.net","simpeg","Madangkara2017","simpeg");
            $sql = "SET @row_number := 0";
            mysqli_query($mysqli,$sql);
            $sqldata = "select FCN_ROW_NUMBER() as no_urut, c.id_skpd, uk.nama_baru as opd, c.jumlah from
                    (select b.id_skpd, sum(b.jumlah) as jumlah from
                    (select a.*, uk.id_skpd from
                    (select id_unit_kerja, count(id_tkk) as jumlah
                    from tkk where status = $status
                    group by id_unit_kerja) a inner join unit_kerja uk on a.id_unit_kerja = uk.id_unit_kerja) b
                    group by b.id_skpd) c inner join unit_kerja uk on c.id_skpd = uk.id_unit_kerja
                    order by c.jumlah desc";
            $q = mysqli_query($mysqli,$sqldata);
            return $q;
        }
    ?>

    <div class="tab-pane fade in" id="tab_k1">
        <br><br>
        <?php
        $dataseries = '';
        $q1 = getRekapNonPNS(2);
        while($data=mysqli_fetch_array($q1))
        {
            $dataseries .= "{
                            no: '".$data[0]."',
                            id_skpd: '".$data[1]."',
                            name: '".$data[2]."',
                            opd: '".$data[2]."',
                            y: ".$data[3]."
                        },";
        }
        $dataseries = substr($dataseries,0,strlen($dataseries)-1);
        ?>
        <div id="container_1" align="center"></div>
        <script>
            $(function () {
                $('#container_1').highcharts({
                    chart: {
                        plotBackgroundColor: null,
                        plotBorderWidth: null,
                        plotShadow: false,
                        width: 900,
                        height: 900,
                        type: 'pie'
                    },
                    title: {
                        text: 'Sebaran Pegawai Non PNS K1 (TKK) Per Perangkat Daerah <br>di Lingkungan Pemerintah Kota Bogor <?php echo("(".getJumlahNonPNS(2)." pegawai)"); ?>'
                    },
                    tooltip: {
                        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
                    },
                    plotOptions: {
                        pie: {
                            size:'70%',
                            allowPointSelect: true,
                            cursor: 'pointer',
                            dataLabels: {
                                enabled: true,
                                padding: 0,
                                format: '<b>{point.no}</b>: {point.percentage:.2f} % ({point.y})',
                                style: {
                                    color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black',fontSize: '10px'
                                }
                            },
                            showInLegend: true
                        }
                    },
                    series: [{
                        name: 'OPD',
                        colorByPoint: true,
                        data: [<?php echo $dataseries;?>],
                        point: {
                            events: {
                                click: function (event) {
                                    var x = this.opd;
                                    jQuery.noConflict();
                                    $.ajax({
                                        type:"POST",
                                        url:"statistiknonpns_daftar.php",
                                        data: { idskpd: this.id_skpd, status: 2},
                                        success: function (data)
                                        {
                                            $('#judul').html('Data Pegawai Non PNS K1 (TKK) pada OPD '+ x);
                                            $('#contentnya').html(data);
                                        }
                                    });
                                    $("#daftar_pegawai").modal("show");
                                }
                            }
                        }
                    }]
                }, function(chart) {
                    <?php
                    $q1 = getRekapNonPNS(2);
                    while($data=mysqli_fetch_array($q1))
                    {
                        echo "chart.legend.allItems[".($data[0]-1)."].update({name:'".$data[0].'. '.$data[2]."'});";
                    }
                    ?>
                });
            });
        </script>
    </div>
    <div class="tab-pane fade in" id="tab_k2">
        <br><br>
        <?php
            $dataseries = '';
            $q2 = getRekapNonPNS(1);
            while($data=mysqli_fetch_array($q2))
            {
                $dataseries .= "{
                            no: '".$data[0]."',
                            id_skpd: '".$data[1]."',
                            name: '".$data[2]."',
                            opd: '".$data[2]."',
                            y: ".$data[3]."
                        },";
            }
            $dataseries = substr($dataseries,0,strlen($dataseries)-1);
        ?>
        <div id="container" align="center"></div>
        <script>
            $(function () {
                $('#container').highcharts({
                    chart: {
                        plotBackgroundColor: null,
                        plotBorderWidth: null,
                        plotShadow: false,
                        width: 900,
                        height: 900,
                        type: 'pie'
                    },
                    title: {
                        text: 'Sebaran Pegawai Non PNS K2 Per Perangkat Daerah <br>di Lingkungan Pemerintah Kota Bogor <?php echo("(".getJumlahNonPNS(1)." pegawai)"); ?>'
                    },
                    tooltip: {
                        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
                    },
                    plotOptions: {
                        pie: {
                            size:'70%',
                            allowPointSelect: true,
                            cursor: 'pointer',
                            dataLabels: {
                                enabled: true,
                                padding: 0,
                                format: '<b>{point.no}</b>: {point.percentage:.2f} % ({point.y})',
                                style: {
                                    color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black',fontSize: '10px'
                                }
                            },
                            showInLegend: true
                        }
                    },
                    series: [{
                        name: 'OPD',
                        colorByPoint: true,
                        data: [<?php echo $dataseries;?>],
                        point: {
                            events: {
                                click: function (event) {
                                    var x = this.opd;
                                    jQuery.noConflict();
                                    $.ajax({
                                        type:"POST",
                                        url:"statistiknonpns_daftar.php",
                                        data: { idskpd: this.id_skpd, status: 1},
                                        success: function (data)
                                        {
                                            $('#judul').html('Data Pegawai Non PNS K2 pada OPD '+ x);
                                            $('#contentnya').html(data);
                                        }
                                    });
                                    $("#daftar_pegawai").modal("show");
                                }
                            }
                        }
                    }]
                }, function(chart) {
                    <?php
                        $q2 = getRekapNonPNS(1);
                        while($data=mysqli_fetch_array($q2))
                        {
                            echo "chart.legend.allItems[".($data[0]-1)."].update({name:'".$data[0].'. '.$data[2]."'});";
                        }
                    ?>
                });
            });
        </script>
    </div>
</div>

<script src="./assets/chart/js/highcharts.js"></script>
<div class="modal fade" id="daftar_pegawai" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header text-primary">
                <span id="judul"></span>
                <a class="btn btn-danger pull-right" data-dismiss="modal">Tutup</a>
            </div>
            <div class="modal-body">
                <div id="contentnya"></div>
            </div>
            <div class="modal-footer">
                <a class="btn btn-danger" data-dismiss="modal">Tutup</a>
            </div>
        </div>
    </div>
</div>
