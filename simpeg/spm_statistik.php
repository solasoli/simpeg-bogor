
<div id="container" style="margin: 0 auto; height: 500px; border: 1px solid #747571;"></div>
<?php
    include("konek.php");
    $idlayanan = $_POST['idJnsLayanan'];
    $JnsLayanan = $_POST['JnsLayanan'];
    $whereKlause = "";
    $legend = "";
    $kategori = "";
    $val1 = "";
    $val2 = "";
    $val3 = "";
    $val4 = "";

    if($idlayanan!='0'){
        $whereKlause = " WHERE kd.id_layanan = $idlayanan ";
    }
    $sql = "SELECT km.*,
            SUM(a.jml_a) AS jml_a, SUM(a.jml_b) AS jml_b, SUM(a.jml_c) AS jml_c, SUM(a.jml_d) AS jml_d, round(rata2,2) as rata2
            FROM kuesioner_master km LEFT JOIN
            (SELECT kd.id_kuesioner,
            SUM(CASE WHEN kd.nilai = 1 THEN 1 ELSE 0 END) AS jml_a,
            SUM(CASE WHEN kd.nilai = 2 THEN 1 ELSE 0 END) AS jml_b,
            SUM(CASE WHEN kd.nilai = 3 THEN 1 ELSE 0 END) AS jml_c,
            SUM(CASE WHEN kd.nilai = 4 THEN 1 ELSE 0 END) AS jml_d,
			AVG(kd.nilai) as rata2
            FROM kuesioner_detail kd $whereKlause
            GROUP BY kd.id_kuesioner) a ON km.id = a.id_kuesioner
            GROUP BY km.id ORDER BY km.id";
    $rekap = mysqli_query($mysqli,$sql);
    $i = 1;
    while($rek =mysqli_fetch_array($rekap)){
        $legend .= $i.') '.$rek[1]." <strong>Rata-rata : ".$rek[10]." </strong> <br>&nbsp;&nbsp;&nbsp;&nbsp;
        <strong>A:</strong>$rek[2] <strong>B:</strong>$rek[3] <strong>C:</strong>$rek[4] <strong>D:</strong>$rek[5]<br>";
        $kategori .= "'".$i."',";
        $val1 .= $rek[6].",";
        $val2 .= $rek[7].",";
        $val3 .= $rek[8].",";
        $val4 .= $rek[9].",";
        $i++;
    }
    echo '<br> <strong>Keterangan :</strong><br>';
    echo $legend;
    echo '<br><br>';
?>

<script>
    $('#container').highcharts({
        chart: {
            type: 'column'
        },
        title: {
            text: 'Hasil Kuesioner <?php echo $JnsLayanan; ?>'
        },
        subtitle: {
            text: 'Sumber : Pendataan melalui aplikasi web simpeg'
        },
        xAxis: {
            categories: [
                <?php echo $kategori;?>
            ],
            crosshair: true
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Jumlah'
            },
            label: {
                overflow: 'justify'
            }
        },
        tooltip: {
            headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
            pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
            '<td style="padding:0"><b>{point.y}</b></td></tr>',
            footerFormat: '</table>',
            shared: true,
            useHTML: true
        },
        plotOptions: {
            column: {
                pointPadding: 0.2,
                borderWidth: 0,
                dataLabels: {
                    enabled: false
                }
            },
        },
        series: [{
            name: 'Nilai A',
            data: [ <?php echo $val1; ?>]
        }, {
            name: 'Nilai B',
            data: [<?php echo $val2; ?>]
        }, {
            name: 'Nilai C',
            data: [<?php echo $val3; ?>]
        }, {
            name: 'Nilai D',
            data: [<?php echo $val4; ?>]
        }]
    });
</script>
