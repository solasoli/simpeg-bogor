<?php
if(!($id_unit_kerja = @$_POST[id_unit_kerja]))
	$id_unit_kerja = 0;

require_once("konek.php");
//echo $_POST[id_unit_kerja];

if($id_unit_kerja==5266){
		$qJabatan = "SELECT a.id_j, a.jabatan, p.nama, p.nip_baru, a.id_bos, p.id_pegawai,p.pangkat_gol as pg,
		IF(LENGTH(p.gelar_belakang) > 1,
	CONCAT(p.gelar_depan,
	' ',
	p.nama,
	CONCAT(', ', p.gelar_belakang)),
	CONCAT(p.gelar_depan, ' ', p.nama)) AS nama_lengkap
		FROM
			(SELECT j.* FROM jabatan j INNER JOIN unit_kerja uk ON j.id_unit_kerja = uk.id_unit_kerja WHERE
			j.Tahun = 2017 AND uk.id_skpd = $id_unit_kerja) a LEFT JOIN
			pegawai p ON a.id_j = p.id_j and p.flag_pensiun != 1 ORDER BY a.id_j";
}else {
		$qJabatan = "SELECT a.id_j, a.jabatan, p.nama, p.nip_baru, a.id_bos, p.id_pegawai,p.pangkat_gol as pg,
		IF(LENGTH(p.gelar_belakang) > 1,
	CONCAT(p.gelar_depan,
	' ',
	p.nama,
	CONCAT(', ', p.gelar_belakang)),
	CONCAT(p.gelar_depan, ' ', p.nama)) AS nama_lengkap
		 FROM
			(SELECT j.* FROM jabatan j WHERE j.Tahun = 2017 AND j.id_unit_kerja = $id_unit_kerja) a LEFT JOIN
			pegawai p ON a.id_j = p.id_j and p.flag_pensiun != 1 ORDER BY a.id_j";
}

//echo $qJabatan;
//exit;
// Prepare Data Array with format,
// [{v:'id_jabatan', f:'jabatan - nama'}, 'id_bos', 'tooltip']
$rsJabatan = mysqli_query($mysqli,$qJabatan);
array(@$data);
while($rJabatan = mysqli_fetch_array($rsJabatan)){
	//echo $qJabatan.'<br>';
	//print_r($rJabatan);
	if($rJabatan['id_bos'] == '1960'){
		$header = array(array(
			'v' => '1960',
			'f' => 'WALIKOTA'
		), $rJabatan['id_bos'], 'tooltip');
		$data[] = $header;
	}

	if(strpos(strtolower($rJabatan['jabatan']), 'pada'))
	{
		$trimed_jabatan = trim(
			substr($rJabatan['jabatan'], 0, strpos(strtolower($rJabatan['jabatan']), 'pada'))
		);
	}
	else
	{
		$trimed_jabatan = $rJabatan['jabatan'];
	}

	//echo $rJabatan['jabatan'].'<br>';

	$plt_q = mysqli_query($mysqli,"select jplt.*,p.*,
					IF(LENGTH(p.gelar_belakang) > 1,
				CONCAT(p.gelar_depan,
				' ',
				p.nama,
				CONCAT(', ', p.gelar_belakang)),
				CONCAT(p.gelar_depan, ' ', p.nama)) AS nama_lengkap

					from jabatan_plt jplt
					inner join pegawai p on p.id_pegawai = jplt.id_pegawai
					where jplt.id_j = ".@$rJabatan[id_j]);

	$plt = mysqli_fetch_object($plt_q);

	if($rJabatan['nama']){
		$nam = $rJabatan['nama_lengkap']." ".$rJabatan['nip_baru'];
	}elseif(isset($plt->nama)){
		$nam = $plt->nama_lengkap." ".$plt->nip_baru;
	}else{
		$nam = '(KOSONG)';
	}

	$qcek=mysqli_query($mysqli,"select eselon from jabatan where id_j=$rJabatan[id_j] and tahun = '2017'");
	$cek=mysqli_fetch_array($qcek);

	if($cek[0]=='IVA' or $cek[0]=='IVB' or $cek[0]=='V')
	{
        $bawah="";
        //$qbawahan=mysqli_query($mysqli,"select nama,max(tmt) from riwayat_mutasi_kerja inner join sk on sk.id_sk= riwayat_mutasi_kerja.id_sk inner join pegawai on pegawai.id_pegawai=riwayat_mutasi_kerja.id_pegawai where flag_pensiun=0 and id_j_bos=$rJabatan[id_j] group by riwayat_mutasi_kerja.id_pegawai");
        $sql = "SELECT
                      nama,
                      tmt
                    FROM riwayat_mutasi_kerja
                      INNER JOIN sk
                        ON sk.id_sk = riwayat_mutasi_kerja.id_sk
                      INNER JOIN pegawai
                        ON pegawai.id_pegawai = riwayat_mutasi_kerja.id_pegawai and flag_pensiun = 0
                    WHERE flag_pensiun != 1
                    AND id_j_bos = $rJabatan[id_j] AND sk.id_kategori_sk = 1 AND sk.tmt =
                      (SELECT MAX(tmt) FROM sk s WHERE pegawai.id_pegawai = s.id_pegawai AND s.id_kategori_sk = 1)
                    GROUP BY riwayat_mutasi_kerja.id_pegawai";
		//echo $sql;
        $qbawahan=mysqli_query($mysqli,$sql);

        while($han=mysqli_fetch_array($qbawahan))
        $bawah.="$han[0] \n";
	}
	else
	$bawah="";
if($rJabatan['id_pegawai']!=NULL)
{
	$qmkg=mysqli_query($mysqli,"select mk_tahun,mk_bulan,tmt from sk where id_pegawai=$rJabatan[id_pegawai] and gol='$rJabatan[pg]' and (id_kategori_sk=5) order by tmt desc");
     $mkg=mysqli_fetch_array($qmkg);
	 $t1=substr($mkg[2],8,2);
	 $b1=substr($mkg[2],5,2);
	 $th1=substr($mkg[2],0,4);
		$header = array(array(
		'v' => $rJabatan['id_j'],
		'f' => $trimed_jabatan." (".$rJabatan['id_j'].")<br><img src='".BASE_URL."/foto/".$rJabatan['id_pegawai'].".jpg' width='50' /><br><i>".$nam.''."</i><br>$rJabatan[pg] $t1-$b1-$th1<br>"
	), $rJabatan['id_bos'], "$bawah");
}else if(isset($plt->nama)){
	$header = array(array(
			'v' => $rJabatan['id_j'],
			'f' => "Plt. ".$trimed_jabatan." (".$rJabatan['id_j'].")<br><img src='".BASE_URL."/foto/".$plt->id_pegawai.".jpg' width='50' /><br><i>".$nam.''."</i>"
		), $rJabatan['id_bos'], "$bawah");
}else
{
$header = array(array(
		'v' => $rJabatan['id_j'],
		'f' => $trimed_jabatan." (".$rJabatan['id_j'].")<br>$rJabatan[id_j]<br><i>".$nam.''."</i>"
	), $rJabatan['id_bos'], "$bawah");

}

	$data[] = $header;
}

?>

<html>
  <head>
	  <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.css" >
	  <script src="js/jquery.min.js"></script>
	  <script src="assets/bootstrap/js/bootstrap.js"></script>
	  <script language="javascript" src="js/jquery-ui-1.8.18.custom.min.js"></script>
	  <script type='text/javascript' src='https://www.google.com/jsapi'></script>
    <script type='text/javascript'>
      google.load('visualization', '1', {packages:['orgchart']});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Name');
        data.addColumn('string', 'Manager');
        data.addColumn('string', 'ToolTip');
        data.addRows(<?php print_r(json_encode($data)); ?>);
        var chart = new google.visualization.OrgChart(document.getElementById('chart_div'));
        chart.draw(data, {allowHtml:true, allowCollapse:true});
      }
    </script>
  </head>

  <body>
	<div align="center">
	<h1>STRUKTUR ORGANISASI SKPD</h1>
	<?php
		$q = mysqli_query($mysqli,"select id_unit_kerja,nama_baru
						from unit_kerja
						where tahun = '2017' and nama_baru not like 'sma%' and nama_baru not like 'sdn%' and nama_baru not like 'tk %'
						and nama_baru not like 'MAN %' and nama_baru not like 'Mts %' and nama_baru not like 'TKN %'
						and nama_baru not like 'SDS%'   and  nama_baru not like 'smp%' and  nama_baru not like 'smk%'
						and nama_baru not like 'UPTD%' and nama_baru not like 'Asisten%' and nama_baru not like 'Bagian%'
						and nama_baru not like 'Staf Ahli%'
						group by nama_baru");
	?>
	<form action="organigram2.php" method="post">
	Unit Kerja
	<select id="skpd" name="id_unit_kerja">
	<?php while($s = mysqli_fetch_array($q))
	{

	?>
		<option value="<?php echo $s['id_unit_kerja']; ?>"
			<?php if($id_unit_kerja==$s['id_unit_kerja']) echo(" selected"); ?>><?php echo $s['nama_baru']; ?></option>
	<?php
	}
	 ?>
		<option value="4086">Walikota</option>
	</select>
	<input type="submit" value="Pilih" />
	</form>
	</div>
	<div id='chart_div'></div>
	<?php
	if(@$_POST[id_unit_kerja]!=NULL){ ?>
		<div id="link_daftar" style='width: 100%; text-align: center;'>
			<span style="font-size: large;">
				<a href="javascript:void(0);" onClick="viewPegawaiStaf(<?php echo $_POST['id_unit_kerja']; ?>);" style="text-decoration: none" >Lihat Daftar Staf</a>
			</span>
		</div>
		<div class="modal fade" id="modalOpd" role="dialog">
			<div class="modal-dialog modal-lg" style="max-height: 350px;">
				<div class="modal-content">
					<div class="modal-header" style="border-bottom: 2px solid darkred">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 id="jdlTabel" class="modal-title" style="border: 0px;">Daftar Pegawai</h4>
					</div>
					<div class="modal-body" style="height: 350px; width: 100%; overflow-y: scroll;">
						<div id="winInfoOPD" style="margin-top: -10px;"></div>
					</div>
					<div class="modal-footer">
						<button id="btnClose" type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					</div>
				</div>
			</div>
		</div>
	<?php } ?>
  </body>
</html>

<script>
	function viewPegawaiStaf(idopd){
		$("#winInfoOPD").html("Loading...");
		var t = document.getElementById("skpd");
		var selectedText = t.options[t.selectedIndex].text;
		$("#jdlTabel").html('Staf '+selectedText);
		var request = $.get("daftar_pegawai_organigram.php?idopd="+idopd);
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
					$("#winInfoOPD").html(response);
				}
		);
		$("#modalOpd").modal('show');
	}
</script>
