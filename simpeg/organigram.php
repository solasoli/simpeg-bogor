<?php
if(!($id_unit_kerja = $_POST[id_unit_kerja]))
	$id_unit_kerja = 0;

require_once("konek.php");
//echo $_POST[id_unit_kerja];
$qJabatan = "SELECT j.id_j, j.jabatan, p.nama, p.nip_baru, j.id_bos, p.id_pegawai,p.pangkat_gol as pg
FROM jabatan j
LEFT JOIN (
    select * from pegawai where flag_pensiun != 1
    ) as p ON j.id_j = p.id_j
WHERE id_unit_kerja =$id_unit_kerja
order by level asc";

// Prepare Data Array with format,
// [{v:'id_jabatan', f:'jabatan - nama'}, 'id_bos', 'tooltip']
$rsJabatan = mysqli_query($mysqli,$qJabatan);
array($data);
while($rJabatan = mysqli_fetch_array($rsJabatan)){
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
	
	if($rJabatan['nama']){
		$nam = $rJabatan['nama']." ".$rJabatan['nip_baru'];
	}else{
		$nam = '(KOSONG)';
	}
	
	$qcek=mysqli_query($mysqli,"select eselon from jabatan where id_j=$rJabatan[id_j]");
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
                        ON pegawai.id_pegawai = riwayat_mutasi_kerja.id_pegawai
                    WHERE flag_pensiun != 1
                    AND id_j_bos = $rJabatan[id_j] and pegawai.id_j is null 
                    GROUP BY riwayat_mutasi_kerja.id_pegawai";
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
		'f' => $trimed_jabatan."<br><img src='".BASE_URL."/foto/".$rJabatan['id_pegawai'].".jpg' width='50' /><br><i>".$nam.''."</i><br>$rJabatan[pg] $t1-$b1-$th1"
	), $rJabatan['id_bos'], "$bawah");
}
else
{
$header = array(array(
		'v' => $rJabatan['id_j'],
		'f' => $trimed_jabatan."<br><i>".$nam.''."</i>"
	), $rJabatan['id_bos'], "$bawah");	
	
}	
	
	$data[] = $header;
}

?>

<html>
  <head>
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
		$q = mysqli_query($mysqli,"select jabatan.id_unit_kerja,nama_baru 
						from jabatan inner join unit_kerja on unit_kerja.id_unit_kerja=jabatan.id_unit_kerja 
						where nama_baru not like 'sma%' and  nama_baru not like 'smp%' and  nama_baru not like 'smk%' 
						 and nama_baru not like 'UPTD%' 
						and jabatan.tahun=(select max(tahun) tahun from unit_kerja) group by nama_baru");
	?>
	<form action="organigram.php" method="post">
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
  </body>
</html>
