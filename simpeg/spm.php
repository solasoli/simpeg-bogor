
<link href="js/bootstrap-datetimepicker-master/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css" />
<script src="js/moment.js"></script>
<script src="assets/js/moment_langs.js"></script>
	<script src="assets/js/combodate.js"></script>
<script src="js/bootstrap-datetimepicker-master/bootstrap-datetimepicker.min.js"></script>
<script src="./assets/chart/js/highcharts.js"></script>
<style>
#container {
    display: block;
    position:relative
}

.ui-autocomplete {
	position: absolute !important;
    margin-top: 0px !important;
    top: 0px !important;
	left: 0;
    z-index: 1000;
    float: left;
    display: none;
    min-width: 160px;
    width: 400px;
    max-height: 300px;
	overflow-y: auto;
	/* prevent horizontal scrollbar */
	overflow-x: auto;
}

.ui-menu-item > a.ui-corner-all {
        display: inline;
        padding: 3px 15px;
        clear: both;
        font-weight: normal;
        line-height: 18px;
        color: #555555;
        white-space: nowrap;
}
</style>
<?php

include('library/format.php');
include('class/pegawai.php');
date_default_timezone_set("Asia/Jakarta");
$format = new Format;

//$pegawai = new Pegawai;
$obj_pegawai = new Pegawai;
$pegawai = $obj_pegawai->get_obj(@$od);

// Turn off all error reporting
//error_reporting(0);
extract($_POST);
extract($_GET);


if(@$issubmit=='true'){
    $qspm=mysqli_query($mysqli,"select * from kuesioner_master order by id");
    while($spm =mysqli_fetch_array($qspm))
    {
        $nilai=$_POST["radio".$spm[0]];
        $idlayanan = $_POST['rdbKue'];
        $sql = "insert into kuesioner_detail (id_kuesioner,id_pegawai,nilai,id_layanan)
        values ($spm[0],$_SESSION[id_pegawai],$nilai,$idlayanan)";
        mysqli_query($mysqli,$sql);
    }
    echo("<div align=center style='background-color: #83c868;font-weight: bold;color: #ffffff; padding-top: 5px;padding-bottom: 5px;'>
        Terimakasih telah mengisi kuesioner ini. Partisipasi anda sangat mendukung dalam meningkatkan pelayanan.</div>");
}

echo("<div align=center style='font-size: 18px;font-weight: bold;margin-bottom: 15px;margin-top: 25px;'>
Kuesioner Pelayanan Kepegawaian Aparatur Sipil Negara</div>");
?>

<div role="tabpanel">
    <ul class="nav nav-tabs" role="tablist" id="myTab_PTK">
        <li role="presentation"><a href="#form_kue" aria-controls="form_kue" role="tab" data-toggle="tab">Form Kuesioner</a></li>
        <li role="presentation" class="active"><a href="#stat_kue" aria-controls="stat_kue" role="tab" data-toggle="tab">Hasil Kuesioner</a></li>
    </ul>
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane" id="form_kue">
            <br>
            <form action="index3.php" method="post" enctype="multipart/form-data" name="form1" class="form-horizontal" role="form" id="form1">
                <input type="hidden" id="x" name="x" value="spm.php" />
                <input id="issubmit" name="issubmit" type="hidden" value="true" />
                <strong>Pilih Layanan :</strong> &nbsp;&nbsp;&nbsp;
                <?php
                $qspm=mysqli_query($mysqli,"select * from kuesioner_layanan");
                $x=1;
                while($spm =mysqli_fetch_array($qspm))
                {
                    echo ("<label style='font-weight: normal;'><input type=\"radio\" name=\"rdbKue\" value=\"$spm[0]\" id=\"rdbKue\" ".($spm[0]==1?'checked':'')." /> <span style=\"color: #9b6f48; font-weight: bold;\">$x) $spm[1]</span></label> &nbsp;&nbsp;&nbsp;");
                    $x++;
                }
                ?>
                <br><br>
                <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-striped">
                    <thead>
                    <tr style="border-top: 1px solid #747571;">
                        <th>No</th>
                        <th>Pertanyaan</th>
                        <th>Jawaban</th>
                    </tr>
                    </thead>
                    <?php
                    $qspm=mysqli_query($mysqli,"select * from kuesioner_master order by id");
                    $a=1;
                    while($spm =mysqli_fetch_array($qspm))
                    {
                        ?>
                        <tr>
                            <td><?php echo $a; ?></td>
                            <td><?php echo($spm[1]);  ?></td>
                            <td>
                                <?php for($i=2;$i<=5;$i++)
                                {
                                    $j=$i-1;
                                    ?>
                                    <label>
                                        <input type="radio" name="radio<?php echo($spm[0]); ?>" value="<?php echo $j; ?>"
                                            <?php echo ($i==4?'checked':''); ?> id="radio<?php echo($spm[0]); ?>" />
                                        <?php echo $spm[$i]; ?></label>

                                    <?php
                                }
                                ?>           </td>
                        </tr>

                        <?php
                        $a++;
                    }
                    ?>
                    <tr>
                        <td>&nbsp;</td>
                        <td><label style="margin-top: 10px;">
                                <input type="submit" name="button" id="button" value="Simpan" class="btn-primary" />
                            </label></td>
                        <td>&nbsp;</td>
                    </tr>
                </table>
            </form>
        </div>
        <div role="tabpanel" class="tab-pane active" id="stat_kue">
            <div style="margin-bottom: 10px; margin-top: 10px; padding: 10px; font-weight: bold; font-size: 16px;">
                Rekapitulasi Hasil Kuesioner</div>
            <?php
                $sql = "SELECT d.id, CASE WHEN d.id IS NULL THEN 'Jumlah' ELSE d.layanan END AS layanan,
                        d.jml_pegawai, d.jml_pengisian, ROUND(d.rataan,2)  FROM
                        (SELECT c.id, c.layanan, c.id_layanan, c.rataan,
                        SUM(c.jml_pegawai) AS jml_pegawai, SUM(c.jml_pengisian) AS jml_pengisian FROM
                        (SELECT kl.*, b.* FROM kuesioner_layanan kl LEFT JOIN
                        (SELECT a.id_layanan, COUNT(a.id_pegawai) AS jml_pegawai, SUM(a.jml_pengisian) AS jml_pengisian, AVG(a.nilai) as rataan FROM
                        (SELECT kd.id_layanan, kd.id_pegawai, ROUND((COUNT(kd.id)/15),0) AS jml_pengisian, kd.nilai
                        FROM kuesioner_detail kd
                        GROUP BY kd.id_layanan, kd.id_pegawai) a GROUP BY a.id_layanan) b
                        ON kl.id = b.id_layanan) c GROUP BY c.id ) d";
                $rekap = mysqli_query($mysqli,$sql);
            ?>
            <table class="table table-striped" style="width: 600px;border-top: 1px solid #c0c2bb;
            border-bottom: 1px solid #c0c2bb; border-left: 1px solid #c0c2bb; border-right: 1px solid #c0c2bb;">
                <thead>
                <tr>
                    <th>No</th>
                    <th>Layanan</th>
                    <th>Jumlah Pegawai</th>
                    <th>Jumlah Pengisian</th>
                    <th>Nilai Rata2</th>                    
					
                </tr>
                </thead>
                <tbody>
                <?php
				$x=0;
                while($rek =mysqli_fetch_array($rekap)){ ?>
					
                    <tr>
                        <td><?php echo $rek[0];?></td>
                        <td><?php echo $rek[1];?></td>
                        <td style="text-align: center;"><?php echo $rek[2];?> orang</td>
                        <td style="text-align: center;"><?php echo $rek[3];?> kali</td>
						<td><?php echo $rek[4]; $jumlahrata2[$x] = $rek[4] ?></td>				
						
                    </tr>
                <?php $x++; } ?>
					<tr>
						<td></td>
                        <td colspan="3">RATA-RATA</td>                       
						<td><?php echo round(array_sum($jumlahrata2)/count($jumlahrata2),2);?></td>				
						
                    </tr>
                </tbody>
            </table>
            <div class="row">
                <div class="col-sm-2" style="margin-top: 5px;"><span style="font-size: medium;">Jenis Layanan</span></div>
                <div class="col-sm-3" style="margin-left: -40px;">
                    <select class="form-control" id="ddJenis" name="ddJenis" style="font-size: medium;">
                        <option value="0">Semua Layanan</option>
                        <?php
                        $qb = mysqli_query($mysqli,"select * from kuesioner_layanan order by id ASC");
                        while ($sts = mysqli_fetch_array($qb)) {
                            echo("<option value=$sts[0]> $sts[1]</option>");
                        }
                        ?>
                    </select>
                </div>
                <div class="col-md-1"><button id="btnTampilkanKueStat" type="button"
                         class="btn btn-primary" style="margin-left: -20px;" onclick="viewStatistikKuesioner();">
                        &nbsp;&nbsp;<span class="glyphicon glyphicon-search"></span> Tampilkan &nbsp;&nbsp;</button>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-11">
                    <div id="divStatKue" style="margin-left: 15px;margin-top: 20px;"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(function () {
        viewStatistikKuesioner();
    });
    function viewStatistikKuesioner(){
        $("#btnTampilkanKueStat").css("pointer-events", "none");
        $("#btnTampilkanKueStat").css("opacity", "0.4");
        $("#divStatKue").css("pointer-events", "none");
        $("#divStatKue").css("opacity", "0.4");
        var idJnsLayanan = $("#ddJenis").val();
        var JnsLayanan = $("#ddJenis option:selected").text();
        $.ajax({
            type: "POST",
            dataType: "html",
            url: "spm_statistik.php",
            data: {idJnsLayanan: idJnsLayanan, JnsLayanan: JnsLayanan}
        }).done(function(data){
            $("#divStatKue").html(data);
            $("#divStatKue").find("script").each(function(i) {
                //eval($(this).text());
            });
            $("#btnTampilkanKueStat").css("pointer-events", "auto");
            $("#btnTampilkanKueStat").css("opacity", "1");
            $("#divStatKue").css("pointer-events", "auto");
            $("#divStatKue").css("opacity", "1");
        });
    };
</script>

