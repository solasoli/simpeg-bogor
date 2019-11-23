<link href="js/bootstrap-datetimepicker-master/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="css/bootstrap.vertical-tabs.min.css">
<script src="js/moment.js"></script>
<script src="js/bootstrap-datetimepicker-master/bootstrap-datetimepicker.min.js"></script>
<script src="./assets/chart/js/highcharts.js"></script>
<head>
	<style>
		/* bootstrap hack: fix content width inside hidden tabs */
		.tab-content > .tab-pane:not(.active),
		.pill-content > .pill-pane:not(.active) {
			display: block;
			height: 0;
			overflow-y: hidden;
		}
		/* bootstrap hack end */
		.modal-dialog {
			width: 353px;
		}
	</style>
	<link href="js/bootstrap3-dialog/css/bootstrap-dialog.min.css" rel="stylesheet" type="text/css" />
</head>
<?php
$unit_kerja = new Unit_kerja;
$sql = "SELECT MAX(uk.id_unit_kerja) AS id_unit_kerja FROM unit_kerja uk
			WHERE uk.nama_baru LIKE '%Sekretariat Daerah%' AND uk.tahun = (SELECT MAX(tahun) FROM unit_kerja uk1)";
$query = mysqli_query($mysqli,$sql);
$dataSekret = mysqli_fetch_array($query);
if($unit['id_skpd'] == $dataSekret[0]){
	$idunit = $unit['id_skpd'];
}else{
	$idunit = $_SESSION['id_unit'];
}
?>
<h2>Input Absensi Harian</h2>
<h3 style="margin-top: -15px;margin-bottom: 20px;"><?php echo $unit_kerja->get_unit_kerja($idunit)->nama_baru ?><!--<a href="#" class="btn btn-primary  hidden-print pull-right" onclick="window.print()">cetak</a>--></h3>

<div role="tabpanel">
	<ul class="nav nav-tabs" role="tablist" id="myTabAbsen">
		<li role="presentation" class="active"><a href="#form_absen" aria-controls="form_absen" role="tab" data-toggle="tab">Form Absensi</a></li>
		<!--<li role="presentation"><a href="#rekap_absensi" aria-controls="rekap_absensi" role="tab" data-toggle="tab">Laporan Profil</a></li>-->
		<li role="presentation"><a href="#kirim_absensi" aria-controls="kirim_absensi" role="tab" data-toggle="tab">Riwayat Kirim Data Absensi</a></li>
	</ul>
	<div class="tab-content">
		<br>
		<div role="tabpanel" class="tab-pane active" id="form_absen">
			<div class="row" style="margin-bottom: 30px;">
				<div class="col-sm-1"><span style="font-size: large; margin-top: 20px;">Tanggal</span></div>
				<div class="col-sm-3">
					<div class="input-group date">
						<input type="text" class="form-control" value="<?php echo date("m/d/Y"); ?>" id="datepicker" style="font-size: large;" >
						<div class="input-group-addon">
							<span class="glyphicon glyphicon-th"></span>
						</div>
					</div>
				</div>
				<div class="col-sm-2">
					<select class="form-control" id="ddStatus" name="ddStatus" style="font-size: large;">
						<option value="0">All Status</option>
						<?php
                            $qb = mysqli_query($mysqli,"select * from ref_status_absensi 
                            where (idstatus <> 'C' and idstatus <> 'DI' and idstatus <> 'DL' and idstatus <> 'I')
                            order by idstatus ASC");
                            while ($sts = mysqli_fetch_array($qb)){
                                echo("<option value=$sts[0]> $sts[1]</option>");
                            }
						?>
					</select>
				</div>

				<?php
				$id_skpd = $unit['id_skpd'];
				if($unit['id_skpd'] == $dataSekret[0]){
					$auth = 0;
				}else {
					if (in_array(2, $_SESSION['role'])) {
						$sqlCountUnit = "SELECT COUNT(uk.id_unit_kerja) AS jmlUnit
							FROM unit_kerja uk WHERE uk.id_skpd = " . $id_skpd . " AND uk.id_unit_kerja <> uk.id_skpd AND
							uk.tahun = (SELECT MAX(tahun) FROM unit_kerja uk1)";
						$query = mysqli_query($mysqli,$sqlCountUnit);
						$data = mysqli_fetch_array($query);
						if ((int)$data[0] > 0) {
							echo "<div class=\"col-sm-3\">";
							echo "<select class=\"form-control\" id=\"ddUnitKerja\" name=\"ddUnitKerja\" style=\"font-size: 14px;font-weight: bold;\">";
							$sqlUnit = "SELECT uk.id_unit_kerja, uk.nama_baru AS jmlUnit
							FROM unit_kerja uk WHERE uk.id_skpd = " . $id_skpd . " AND uk.tahun = (SELECT MAX(tahun) FROM unit_kerja uk1)";
							$qb = mysqli_query($mysqli,$sqlUnit);
							while ($unit = mysqli_fetch_array($qb)) {
								if ($_SESSION['id_unit'] == $unit[0]) {
									echo("<option value=$unit[0] selected> $unit[1]</option>");
								} else {
									echo("<option value=$unit[0] > $unit[1]</option>");
								}
							}
							echo "</select>";
							echo "</div>";
							$auth = 1;
						} else {
							$auth = 0;
						}
					}else if (in_array(7, @$_SESSION['role'])) {
						$auth = 1;
					} else {
						$auth = 0;
					}
				}
					$bln = @$_GET['bln'];
					$thn = @$_GET['thn'];
					if(isset($bln) and $bln!='' and $bln!='0'){

					}else{
						$bln = date("m");
					}
					if(isset($thn) and $thn!='' and $thn!='0'){

					}else{
						$thn = date("Y");
					}
				?>

				<div class="col-md-1"><button id="btnFilterTgl" type="button" class="btn btn-primary" style="margin-left: -20px;">
						&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-search"></span> Tampilkan &nbsp;&nbsp;&nbsp;</button></div>
				<div class="col-md-1" style="margin-left: 10px;"><button id="btnKirimAbsen" type="button" class="btn btn-primary" style="margin-left: 30px;">
						&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-send"></span> Kirim &nbsp;&nbsp;&nbsp;</button></div>
				<script>
					$("#btnFilterTgl").click(function () {
						RefreshTable('#list_pegawai');
					});

					$("#btnKirimAbsen").click(function () {
						KirimAbsensi();
					});
				</script>
			</div>
			<div id="walltable">
				<table id="list_pegawai" class="display" cellspacing="0" width="100%">
					<thead>
					<tr>
						<th style="width: 5%;">No</th>
						<th style="width: 15%;">Nama</th>
						<th style="width: 15%;">NIP</th>
						<!--th class="hidden-print">New Gol<span style="color:red">*</span></th-->
						<th style="width: 3%;">Status</th>
						<th style="width: 62%;" class="hidden-print">Aksi</th>
					</tr>
					</thead>
				</table>
			</div>
			<p>
				<span style="color:red">*</span> Golongan berdasarkan data riwayat pangkat/sk yang sudah di input
			</p>
		</div>
		<div role="tabpanel" class="tab-pane fade" id="rekap_absensi">
			<div class="row" style="margin-bottom: 30px;">
				<div class="col-sm-2">
					<select class="form-control" id="ddBulan" name="ddBulan" style="font-size: large;">
						<option value="1" <?php echo $bln==1?'selected':''; ?>>Januari</option>
						<option value="2" <?php echo $bln==2?'selected':''; ?>>Februari</option>
						<option value="3" <?php echo $bln==3?'selected':''; ?>>Maret</option>
						<option value="4" <?php echo $bln==4?'selected':''; ?>>April</option>
						<option value="5" <?php echo $bln==5?'selected':''; ?>>Mei</option>
						<option value="6" <?php echo $bln==6?'selected':''; ?>>Juni</option>
						<option value="7" <?php echo $bln==7?'selected':''; ?>>Juli</option>
						<option value="8" <?php echo $bln==8?'selected':''; ?>>Agustus</option>
						<option value="9" <?php echo $bln==9?'selected':''; ?>>September</option>
						<option value="10" <?php echo $bln==10?'selected':''; ?>>Oktober</option>
						<option value="11" <?php echo $bln==11?'selected':''; ?>>November</option>
						<option value="12" <?php echo $bln==12?'selected':''; ?>>Desember</option>
					</select>
				</div>
				<div class="col-sm-2">
					<select class="form-control" id="ddTahun" name="ddTahun" style="font-size: large;margin-left: -10px;">
						<option value="2016" <?php echo $thn==2016?'selected':''; ?>>2016</option>
						<option value="2017" <?php echo $thn==2017?'selected':''; ?>>2017</option>
						<option value="2018" <?php echo $thn==2018?'selected':''; ?>>2018</option>
						<option value="2019" <?php echo $thn==2019?'selected':''; ?>>2019</option>
						<option value="2020" <?php echo $thn==2020?'selected':''; ?>>2020</option>
						<option value="2021" <?php echo $thn==2021?'selected':''; ?>>2021</option>
					</select>
				</div>
				<div class="col-md-2"><button id="btnFilterReport" type="button" class="btn btn-primary" style="margin-left: -20px;">
						&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-search"></span> Tampilkan &nbsp;&nbsp;&nbsp;</button></div>
			</div>
			<div class="row" style="margin-top: -10px;">
				<div class="col-md-12"><button id="btnCetakRptBulanan" type="button" class="btn btn-success" style="margin-left: 0px;">
						<span class="glyphicon glyphicon-floppy-disk"></span> Report Bulanan OPD</button>
					<button id="btnCetakRptPegawai" type="button" class="btn btn-success" style="margin-left: 0px;">
						<span class="glyphicon glyphicon-floppy-disk"></span> Report Pegawai OPD</button>
					<?php if ($auth==1): ?>
					<button id="btnCetakRptBulananUnit" type="button" class="btn btn-success" style="margin-left: 0px;">
						<span class="glyphicon glyphicon-floppy-disk"></span> Report Bulanan Unit</button>
					<button id="btnCetakRptPegawaiUnit" type="button" class="btn btn-success" style="margin-left: 0px;">
						<span class="glyphicon glyphicon-floppy-disk"></span> Report Pegawai Unit</button>
					<?php endif; ?>
				</div>
			</div>
			<script>
				$("#btnFilterReport").click(function(){
					var bln = $('#ddBulan').val();
					var thn = $('#ddTahun').val();
					location.href="index3.php?x=listabsensi.php&bln="+bln+"&thn="+thn;
				});

				$("#btnCetakRptBulanan").click(function(){
					var bln = $('#ddBulan').val();
					var thn = $('#ddTahun').val();
					window.open('/simpeg/cetak_absensi_bulanan.php?bln='+bln+'&thn='+thn+'&skpd=<?php echo $id_skpd?>','_blank');
				});

				$("#btnCetakRptPegawai").click(function(){
					var bln = $('#ddBulan').val();
					var thn = $('#ddTahun').val();
					window.open('/simpeg/cetak_absensi_pegawai.php?bln='+bln+'&thn='+thn+'&skpd=<?php echo $id_skpd?>','_blank');
				});

				$("#btnCetakRptBulananUnit").click(function(){
					var bln = $('#ddBulan').val();
					var thn = $('#ddTahun').val();
					window.open('/simpeg/cetak_absensi_bulanan_unit.php?bln='+bln+'&thn='+thn+'&idunit=<?php echo $_SESSION['id_unit'];?>','_blank');
				});

				$("#btnCetakRptPegawaiUnit").click(function(){
					var bln = $('#ddBulan').val();
					var thn = $('#ddTahun').val();
					window.open('/simpeg/cetak_absensi_pegawai_unit.php?bln='+bln+'&thn='+thn+'&idunit=<?php echo $_SESSION['id_unit'];?>','_blank');
				});
			</script>
			<?php
			$sql = "CALL PRCD_ABSENSI_HARIAN_PROFIL2(".$bln.", ".$thn.", ".$id_skpd.")";
			$result = $mysqli->query($sql);
			while ($row = $result->fetch_object()){
				$data1[0] = array(
						'name' => 'Tidak Hadir',
						'y' => $row->absen_persen_jml_hari
				);
				$data1[1] = array(
						'name' => 'Hadir',
						'y' => $row->persen_hadir_jml_hari
				);
				$data2[0] = array(
						'name' => 'Tidak Hadir',
						'y' => $row->absen_persen_jml_org
				);
				$data2[1] = array(
						'name' => 'Hadir',
						'y' => $row->hadir_persen_jml_org
				);
				$data3[0] = $row->total_harikerja;
				$data3[1] = $row->hadir_jml_hari;
				$data3[2] = $row->absen_jml_hari;

				$data4[0] = $row->total_pegawai;
				$data4[1] = $row->hadir_jml_org;
				$data4[2] = $row->absen_jml_org;
			}
			$data1 = json_encode($data1, JSON_NUMERIC_CHECK);
			$data2 = json_encode($data2, JSON_NUMERIC_CHECK);
			$data3 = json_encode($data3, JSON_NUMERIC_CHECK);
			$data4 = json_encode($data4, JSON_NUMERIC_CHECK);
			$result->close();
			$mysqli->next_result();


			$sql = "CALL PRCD_ABSENSI_HARIAN_PROFIL2_UNIT(".$bln.", ".$thn.", ".$_SESSION['id_unit'].")";
			$result = $mysqli->query($sql);
			while ($row = $result->fetch_object()){
				$data5[0] = array(
						'name' => 'Tidak Hadir',
						'y' => $row->absen_persen_jml_hari
				);
				$data5[1] = array(
						'name' => 'Hadir',
						'y' => $row->persen_hadir_jml_hari
				);
				$data6[0] = array(
						'name' => 'Tidak Hadir',
						'y' => $row->absen_persen_jml_org
				);
				$data6[1] = array(
						'name' => 'Hadir',
						'y' => $row->hadir_persen_jml_org
				);
				$data7[0] = $row->total_harikerja;
				$data7[1] = $row->hadir_jml_hari;
				$data7[2] = $row->absen_jml_hari;

				$data8[0] = $row->total_pegawai;
				$data8[1] = $row->hadir_jml_org;
				$data8[2] = $row->absen_jml_org;
			}
			$data5 = json_encode($data5, JSON_NUMERIC_CHECK);
			$data6 = json_encode($data6, JSON_NUMERIC_CHECK);
			$data7 = json_encode($data7, JSON_NUMERIC_CHECK);
			$data8 = json_encode($data8, JSON_NUMERIC_CHECK);
			$result->close();
			$mysqli->next_result();


			$sql = "CALL PRCD_ABSENSI_HARIAN_PROFIL1(".$bln.", ".$thn.", ".$id_skpd.")";
			$result = $mysqli->query($sql);
			?>
			<div class="row" style="margin-top: -10px;">
				<div class="col-xs-1" style="margin-left: -10px;margin-top: 30px;"> <!-- required for floating -->
					<!-- Nav tabs -->
					<ul class="nav nav-tabs tabs-left sideways">
						<?php if ($auth==1 or $auth==0): ?>
							<li class="active"><a href="#home" data-toggle="tab">OPD</a></li>
						<?php endif; ?>
						<?php if ($auth==1): ?>
							<li><a href="#profile" data-toggle="tab">Unit</a></li>
						<?php endif; ?>

					</ul>
				</div>
				<div class="col-xs-11" style="margin-left: -30px;">
					<div class="tab-content">
						<?php if ($auth==1 or $auth==0): ?>
						<div class="tab-pane active" id="home">
							<div class="row" style="margin-bottom: 20px;margin-top: 0px;">
								<div class="col-sm-6">
									<h4><span class="label label-default">Tingkat Kehadiran OPD</span></h4>
									<div class="row">
										<div class="col-sm-6">
											Berdasarkan Hari
											<div id="container1" style="margin: 0 auto; height: 150px;"></div>
										</div>
										<div class="col-sm-6">
											Berdasarkan Orang
											<div id="container2" style="margin: 0 auto; height: 150px;"></div>
										</div>
									</div>
									<div class="row">
										<div class="col-sm-12">
											<br>
											Detail Per Status
											<table class="table" id="lst_data">
												<thead>
												<tr>
													<th>No</th>
													<th>Status</th>
													<th>Orang</th>
													<th>%</th>
													<th>Hari</th>
													<th>%</th>
												</tr>
												</thead>
												<?php
												$i = 1;
												while ($row = $result->fetch_object()){
													?>
													<tr>
														<td><?php echo $i; ?></td>
														<td><?php echo $row->status ?></td>
														<td><a href="javascript:void(0);" onclick="detailListPegawai('<?php echo $bln; ?>','<?php echo $thn; ?>','<?php echo $id_skpd; ?>','<?php echo $row->status; ?>','skpd');"><?php echo $row->jml_orang ?></a></td>
														<td><?php echo $row->persen_jml_pegawai ?> %</td>
														<td><?php echo $row->jml_hari ?></td>
														<td><?php echo $row->persen_jml_hari_absen ?> %</td>
													</tr>
													<?php
													$i++;
												}
												$result->close();
												$mysqli->next_result();
												?>
											</table>
										</div>
									</div>
								</div>
								<div class="col-sm-6">
									<h4><span class="label label-default">Rekapitulasi Absensi OPD</span></h4>
									<div class="row">
										<div class="col-sm-12">
											Berdasarkan Hari
											<div id="container3" style="margin: 0 auto; height: 200px;"></div>
										</div>
									</div>
									<div class="row">
										<div class="col-sm-12">
											Berdasarkan Orang <span style="color:darkblue;">(Klik pada Kolom Tidak Hadir)</span>
											<div id="container4" style="margin: 0 auto; height: 200px;"></div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<?php endif; ?>
						<?php if ($auth==1): ?>
						<div class="tab-pane" id="profile">
							<div class="row" style="margin-bottom: 20px;margin-top: 0px;">
								<div class="col-sm-6">
									<h4><span class="label label-default">Tingkat Kehadiran Unit</span></h4>
									<div class="row">
										<div class="col-sm-6">
											Berdasarkan Hari
											<div id="container5" style="margin: 0 auto; height: 150px;"></div>
										</div>
										<div class="col-sm-6">
											Berdasarkan Orang
											<div id="container6" style="margin: 0 auto; height: 150px;"></div>
										</div>
									</div>
									<?php
										$sql = "CALL PRCD_ABSENSI_HARIAN_PROFIL1_UNIT(".$bln.", ".$thn.", ".$_SESSION['id_unit'].")";
										$result2 = $mysqli->query($sql);
									?>
									<div class="row">
										<div class="col-sm-12">
											<br>
											Detail Per Status
											<table class="table" id="lst_data2">
												<thead>
												<tr>
													<th>No</th>
													<th>Status</th>
													<th>Orang</th>
													<th>%</th>
													<th>Hari</th>
													<th>%</th>
												</tr>
												</thead>
												<?php
												$i = 1;
												while ($row = $result2->fetch_object()){
													?>
													<tr>
														<td><?php echo $i; ?></td>
														<td><?php echo $row->status ?></td>
														<td><a href="javascript:void(0);" onclick="detailListPegawai('<?php echo $bln; ?>','<?php echo $thn; ?>','<?php echo $_SESSION['id_unit']; ?>','<?php echo $row->status; ?>','unit');"><?php echo $row->jml_orang ?></a></td>
														<td><?php echo $row->persen_jml_pegawai ?> %</td>
														<td><?php echo $row->jml_hari ?></td>
														<td><?php echo $row->persen_jml_hari_absen ?> %</td>
													</tr>
													<?php
													$i++;
												}
												$result2->close();
												$mysqli->next_result();
												?>
											</table>
										</div>
									</div>
								</div>
								<div class="col-sm-6">
									<h4><span class="label label-default">Rekapitulasi Absensi Unit</span></h4>
									<div class="row">
										<div class="col-sm-12">
											Berdasarkan Hari
											<div id="container7" style="margin: 0 auto; height: 200px;"></div>
										</div>
									</div>
									<div class="row">
										<div class="col-sm-12">
											Berdasarkan Orang <span style="color:darkblue;">(Klik pada Kolom Tidak Hadir)</span>
											<div id="container8" style="margin: 0 auto; height: 200px;"></div>
										</div>
									</div>
								</div>

							</div>
						</div>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>
		<div role="tabpanel" class="tab-pane fade" id="kirim_absensi">
			<div class="row" style="margin-bottom: 30px;">
				<div class="col-sm-2">
					<select class="form-control" id="ddBulanHist" name="ddBulanHist" style="font-size: large;">
						<option value="1" <?php echo $bln==1?'selected':''; ?>>Januari</option>
						<option value="2" <?php echo $bln==2?'selected':''; ?>>Februari</option>
						<option value="3" <?php echo $bln==3?'selected':''; ?>>Maret</option>
						<option value="4" <?php echo $bln==4?'selected':''; ?>>April</option>
						<option value="5" <?php echo $bln==5?'selected':''; ?>>Mei</option>
						<option value="6" <?php echo $bln==6?'selected':''; ?>>Juni</option>
						<option value="7" <?php echo $bln==7?'selected':''; ?>>Juli</option>
						<option value="8" <?php echo $bln==8?'selected':''; ?>>Agustus</option>
						<option value="9" <?php echo $bln==9?'selected':''; ?>>September</option>
						<option value="10" <?php echo $bln==10?'selected':''; ?>>Oktober</option>
						<option value="11" <?php echo $bln==11?'selected':''; ?>>November</option>
						<option value="12" <?php echo $bln==12?'selected':''; ?>>Desember</option>
					</select>
				</div>
				<div class="col-sm-2">
					<select class="form-control" id="ddTahunHist" name="ddTahunHist" style="font-size: large;margin-left: -10px;">
						<option value="2016" <?php echo $thn==2016?'selected':''; ?>>2016</option>
						<option value="2017" <?php echo $thn==2017?'selected':''; ?>>2017</option>
						<option value="2018" <?php echo $thn==2018?'selected':''; ?>>2018</option>
						<option value="2019" <?php echo $thn==2019?'selected':''; ?>>2019</option>
						<option value="2020" <?php echo $thn==2020?'selected':''; ?>>2020</option>
						<option value="2021" <?php echo $thn==2021?'selected':''; ?>>2021</option>
					</select>
				</div>
				<?php
					if ($auth == 1 and in_array(2, $_SESSION['role'])){
						echo "<div class=\"col-sm-3\" style=\"margin-left: -20px;\">";
						echo "<select class=\"form-control\" id=\"ddUnitKerjaHist\" name=\"ddUnitKerjaHist\" style=\"font-size: 14px;font-weight: bold;\">";
						$qb = mysqli_query($mysqli,$sqlUnit);
						while ($unit = mysqli_fetch_array($qb)) {
							if($_SESSION['id_unit']==$unit[0]){
								echo("<option value=$unit[0] selected> $unit[1]</option>");
							}else{
								echo("<option value=$unit[0] > $unit[1]</option>");
							}
						}
						echo "</select>";
						echo "</div>";
					}
				?>
				<div class="col-md-2"><button id="btnFilterRiwayat" type="button" class="btn btn-primary" style="margin-left: -20px;">
						&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-search"></span> Tampilkan &nbsp;&nbsp;&nbsp;</button></div>
			</div>
			<div class="row">
				<div class="col-sm-12">
					<div id="walltable2">
						<table id="list_riwayat" class="display" cellspacing="0" width="100%">
							<thead>
							<tr>
								<th style="width: 5%;">No</th>
								<th style="width: 5%;">Tgl.Absensi</th>
								<th style="width: 5%;">Tgl.Input</th>
								<th style="width: 15%;">Tgl.Update</th>
								<th style="width: 15%;">Oleh</th>
								<!--th class="hidden-print">New Gol<span style="color:red">*</span></th-->
								<th style="width: 3%;">Status</th>
							</tr>
							</thead>
						</table>
					</div>
				</div>
			</div>
			<script>
				$("#btnFilterRiwayat").click(function () {
					RefreshTableRiwayat('#list_riwayat');
				});
			</script>
		</div>
	</div>
</div>

<div class="modal fade" id="modalDetLstPeg" role="dialog">
	<div class="modal-dialog modal-lg" style="max-height: 300px; width: 800px;"><div class="modal-content">
			<div class="modal-header" style="border-bottom: 2px solid darkred">
				<button type="button" class="close" data-dismiss="modal">&times;</button><h4 class="modal-title" style="border: 0px;">Daftar Pegawai <span id="spnTitle"></span></h4>
			</div>
			<div class="modal-body" style="height: 300px; width: 100%; overflow-y: scroll;">
				<div id="divDetLstPeg" style="margin-top: -10px;"></div>
			</div>
			<div class="modal-footer">
				<button id="btnClose" type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>

<script>
	$(document).ready(function() {
		var tgl = $('#datepicker').val();
		var table = $('#list_pegawai').DataTable( {
			"ordering": false,
			"ajax": "class/cls_ajax_data.php?filter=listabsensi&id_unit_kerja=<?php echo $_SESSION['id_unit']; ?>&idskpd=<?php echo $id_skpd?>&tglcur="+tgl+ "&status=0",
			"autoWidth": false,
			"columnDefs": [
				{ "width": "5%", "targets": 0 },
				{ "width": "15%", "targets": 1 },
				{ "width": "15%", "targets": 2 },
				{ "width": "3%", "targets": 3 },
				{ "width": "62%"}
			],
			"columns": [
				{ "data": "no" },
				{ "data": "nama" },
				{ "data": "nip_baru" },
				{ "data": "status",
					"className":"center",
					"render":function(data, type, full){
						if(full.status == ''){
							return '<span id="spnStatus'+full.id_pegawai+'">-</span>'
						}else if(full.status == 'S'){
							return '<span id="spnStatus'+full.id_pegawai+'" class="label label-primary label-as-badge">'+full.status+'</span>'
						}else if(full.status == 'I'){
							return '<span id="spnStatus'+full.id_pegawai+'" class="label label-warning label-as-badge">'+full.status+'</span>'
						}else if(full.status == 'TK'){
							return '<span id="spnStatus'+full.id_pegawai+'" class="label label-danger label-as-badge">'+full.status+'</span>'
						}else if(full.status == 'DL'){
							return '<span id="spnStatus'+full.id_pegawai+'" class="label label-success label-as-badge">'+full.status+'</span>'
						}else if(full.status == 'C'){
							return '<span id="spnStatus'+full.id_pegawai+'" class="label label-success label-as-badge">'+full.status+'</span>'
						}else if(full.status == 'DI'){
							return '<span id="spnStatus'+full.id_pegawai+'" class="label label-success label-as-badge">'+full.status+'</span>'
                        }else if(full.status == 'LP'){
                            return '<span id="spnStatus'+full.id_pegawai+'" class="label label-success label-as-badge">'+full.status+'</span>'
						}else if(full.status == 'TA'){
							return '<span id="spnStatus'+full.id_pegawai+'" class="label label-info label-as-badge">'+full.status+'</span>'
						}else if(full.status == 'DLPG'){ //dinas luar pulang
							return '<span id="spnStatus'+full.id_pegawai+'" class="label label-info label-as-badge">'+full.status+'</span>'
						}else if(full.status == 'DLP'){ //dinas luar pulang
							return '<span id="spnStatus'+full.id_pegawai+'" class="label label-info label-as-badge">'+full.status+'</span>'
						}
					}
				},
				{
					"orderable":      false,
					"data":           null,
					"render":function(data, type, full){
					    /*'<button id="btnDL" type="button" class="btn btn-xs btn-success" data-placement="bottom" title="Dinas Luar" onclick="changeRptAbsensi('+full.id_pegawai+',\'DL\',\'lstTbl'+full.id_pegawai+'\',\'spnStatus'+full.id_pegawai+'\')">Dinas Luar</button>&nbsp;' +*/
						/* '<button id="btnI" type="button" class="btn btn-xs btn-warning" data-placement="bottom" title="Ijin" onclick="changeRptAbsensi('+full.id_pegawai+',\'I\',\'lstTbl'+full.id_pegawai+'\',\'spnStatus'+full.id_pegawai+'\')">Ijin</button>&nbsp;' +*/
                        /*'<button id="btnCuti" type="button" class="btn btn-xs btn-success" data-placement="bottom" title="Cuti" onclick="changeRptAbsensi('+full.id_pegawai+',\'C\',\'lstTbl'+full.id_pegawai+'\',\'spnStatus'+full.id_pegawai+'\')">Cuti</button>&nbsp;' +*/
						/*'<button id="btnDisp" type="button" class="btn btn-xs btn-success" data-placement="bottom" title="Dispensasi" onclick="changeRptAbsensi('+full.id_pegawai+',\'DI\',\'lstTbl'+full.id_pegawai+'\',\'spnStatus'+full.id_pegawai+'\')">Dispen</button>&nbsp;' +*/

                        return '<div id="lstTbl'+full.id_pegawai+'"><button id="btnS" type="button" class="btn btn-xs btn-primary" data-placement="bottom" title="Sakit" onclick="changeRptAbsensi('+full.id_pegawai+',\'S\',\'lstTbl'+full.id_pegawai+'\',\'spnStatus'+full.id_pegawai+'\')">Sakit</button>&nbsp' +
								'<button id="btnTK" type="button" class="btn btn-xs btn-danger" data-placement="bottom" title="Tanpa Keterangan" onclick="changeRptAbsensi('+full.id_pegawai+',\'TK\',\'lstTbl'+full.id_pegawai+'\',\'spnStatus'+full.id_pegawai+'\')">Tanpa Ket.</button>&nbsp;' +
								'<button id="btnDLPG" type="button" class="btn btn-xs btn-success" data-placement="bottom" title="Dinas Luar Pagi" onclick="changeRptAbsensi('+full.id_pegawai+',\'DLPG\',\'lstTbl'+full.id_pegawai+'\',\'spnStatus'+full.id_pegawai+'\')">Dinas Luar Pagi</button>&nbsp;' +
								'<button id="btnDLP" type="button" class="btn btn-xs btn-success" data-placement="bottom" title="Dinas Luar Pulang" onclick="changeRptAbsensi('+full.id_pegawai+',\'DLP\',\'lstTbl'+full.id_pegawai+'\',\'spnStatus'+full.id_pegawai+'\')">Dinas Luar Pulang</button>&nbsp;' +
                '<button id="btnLp" type="button" class="btn btn-xs btn-success" data-placement="bottom" title="Lepas Piket" onclick="changeRptAbsensi('+full.id_pegawai+',\'LP\',\'lstTbl'+full.id_pegawai+'\',\'spnStatus'+full.id_pegawai+'\')">Lepas Piket</button>&nbsp;' +
								'<button id="btnTA" type="button" class="btn btn-xs btn-info" data-placement="bottom" title="Tidak Apel" onclick="changeRptAbsensi('+full.id_pegawai+',\'TA\',\'lstTbl'+full.id_pegawai+'\',\'spnStatus'+full.id_pegawai+'\')">Tidak Apel</button>&nbsp;' +
								'<button id="btnCek" type="button" class="btn btn-xs btn-default" data-placement="bottom" title="Reset" onclick="changeRptAbsensi('+full.id_pegawai+',\'R\',\'lstTbl'+full.id_pegawai+'\',\'spnStatus'+full.id_pegawai+'\')">' +
								'Reset</button>&nbsp;' +
								'<button id="btnReset" type="button" class="btn btn-xs btn-default" data-placement="bottom" title="Riwayat Absen" onclick="histAbsensi(\'modHistWindow'+full.id_pegawai+'\',\'divHistWin'+full.id_pegawai+'\','+full.id_pegawai+')">' +
								'Riwayat</button><div class="modal fade" id="modHistWindow'+full.id_pegawai+'" role="dialog">' +
								'<div class="modal-dialog modal-lg" style="max-height: 300px; width: 400px;"><div class="modal-content"><div class="modal-header">' +
								'<button type="button" class="close" data-dismiss="modal">&times;</button><h4 class="modal-title" style="border: 0px;">Daftar Riwayat Absensi<br><span style="font-size: medium;color: blue">'+full.nama+'</span></h4>' +
								'</div><div class="modal-body" style="height: 300px; width: 100%; overflow-y: scroll;"><div id="divHistWin'+full.id_pegawai+'" style="margin-top: -10px;"></div>' +
								'</div><div class="modal-footer"><button id="btnClose"'+full.id_pegawai+' type="button" class="btn btn-default" data-dismiss="modal">Close</button>' +
								'</div></div></div></div></div>'
					}
				}
			],
			"order": [[0, 'asc']]
		} );

		var bln_absen = $('#ddBulanHist').val();
		var thn_absen = $('#ddTahunHist').val();
		var table = $('#list_riwayat').DataTable( {
			"ajax": "class/cls_ajax_data.php?filter=listriwayat_absensi&id_unit_kerja=<?php echo $_SESSION['id_unit']; ?>&bln_absen="+bln_absen+ "&thn_absen="+thn_absen,
			"autoWidth": false,
			"columnDefs": [
				{ "width": "5%", "targets": 0 },
				{ "width": "10%", "targets": 1 },
				{ "width": "10%", "targets": 2 },
				{ "width": "10%", "targets": 3 },
				{ "width": "45%", "targets": 4 },
				{ "width": "20%", "targets": 5 }
			],
			"columns": [
				{ "data": "no" },
				{ "data": "tgl_absen", "className":"center"},
				{ "data": "tgl_input" },
				{ "data": "tgl_update" },
				{"data":"nip_baru",
					"className":"left",
					"render":function(data, type, full){
						return "<div class='row' style='width: 100%'>" +
								"<span style='color: saddlebrown;'>"+full.nama + " (" + full.nip_baru + ") <br>" + "</span><span style='color: steelblue;font-size: small;'> (" +full.jabatan+")</span></div>";
					}
				},
				{"data": "status"}
			]
		});
	});
</script>
<script language="JavaScript">
	$(function () {
		$('#datepicker').datetimepicker({
			format: 'L'
		});
	});
	var inputs = document.getElementById('datepicker');

	function RefreshTable(tableId)
	{
		var tgl = $('#datepicker').val();
		var status = $('#ddStatus').val();
		<?php if($auth==1){?>
			<?php if (in_array(7, $_SESSION['role'])): ?>
				var idunit = <?php echo $_SESSION['id_unit'] ?>;
			<?php else: ?>
				var idunit = $('#ddUnitKerja').val();
			<?php endif; ?>
		<?php }else{?>
			var idunit = <?php echo $_SESSION['id_unit'] ?>;
		<?php }
    ?>
		$("#walltable").css("pointer-events", "none");
		$("#walltable").css("opacity", "0.4");
		$.getJSON("class/cls_ajax_data.php?filter=listabsensi&id_unit_kerja="+idunit+"&idskpd=<?php echo $id_skpd;?>&tglcur="+tgl+"&status="+status, null, function( json )
		{
			table = $('#list_pegawai').dataTable();
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

	function RefreshTableRiwayat(tableId)
	{
		var bln_absen = $('#ddBulanHist').val();
		var thn_absen = $('#ddTahunHist').val();
		<?php
            if($auth==1){?>
			<?php if (in_array(7, $_SESSION['role'])): ?>
				var idunit2 = <?php echo $_SESSION['id_unit'] ?>;
			<?php else: ?>
				var idunit2 = $('#ddUnitKerjaHist').val();
			<?php endif; ?>
		<?php }else{?>
			var idunit2 = <?php echo $_SESSION['id_unit'] ?>;
		<?php }
    ?>
		$("#walltable2").css("pointer-events", "none");
		$("#walltable2").css("opacity", "0.4");
		$.getJSON("class/cls_ajax_data.php?filter=listriwayat_absensi&id_unit_kerja="+idunit2+"&bln_absen="+bln_absen+ "&thn_absen="+thn_absen, null, function( json )
		{
			table = $('#list_riwayat').dataTable();
			oSettings = table.fnSettings();

			table.fnClearTable(this);

			for (var i=0; i<json.data.length; i++)
			{
				table.oApi._fnAddData(oSettings, json.data[i]);
			}

			oSettings.aiDisplay = oSettings.aiDisplayMaster.slice();
			table.fnDraw();
			$("#walltable2").css("pointer-events", "auto");
			$("#walltable2").css("opacity", "1");
		});
	}

	function KirimAbsensi(){
		var tgl = $('#datepicker').val();
		var idunit = <?php echo $_SESSION['id_unit'] ?>;
		BootstrapDialog.confirm('Anda yakin akan mengirim data absensi?', function(result){
			if(result) {
				$.ajax({
					type: "GET",
					dataType: "json",
					url: "class/cls_ajax_data.php?filter=kirimabsensi&id_unit_kerja="+idunit+"&tglcur="+tgl+"&id_pegawai=" + <?php echo $_SESSION['id_pegawai'] ?>,
					success: function (results) {
						var hasil, status = '';
						$.each(results, function(k, v){
							hasil = v.hasil;
							status = v.status;
						});
						if(hasil == 1){
							BootstrapDialog.alert({
								title: 'Informasi',
								message: 'Data sukses tersimpan',
								type: BootstrapDialog.TYPE_SUCCESS
							});
						}else{
							BootstrapDialog.alert({
								title: 'Perhatian',
								message: 'Data tidak tersimpan',
								type: BootstrapDialog.TYPE_WARNING
							});
						}
					}
				});
			}
		});
	}
	function changeRptAbsensi(id_pegawai, statusAbs, divlst, spnSts){
		var tgl = $('#datepicker').val();
		$("#"+divlst).css("pointer-events", "none");
		$("#"+divlst).css("opacity", "0.4");
		<?php
            if($auth==1){?>
				<?php if (in_array(7, $_SESSION['role'])): ?>
					var idunit = <?php echo $_SESSION['id_unit'] ?>;
				<?php else: ?>
					var idunit = $('#ddUnitKerja').val();
				<?php endif; ?>
		<?php }else{?>
			var idunit = <?php echo $_SESSION['id_unit'] ?>;
		<?php }
    ?>
		$.ajax({
			type: "GET",
			dataType: "json",
			url: "class/cls_ajax_data.php?filter=update_absensi&id_pegawai=" + id_pegawai + "&status=" + statusAbs + "&tglcur=" + tgl + "&id_unit_kerja="+idunit,
			success: function (results) {
				var hasil, status = '';
				$.each(results, function(k, v){
					hasil = v.hasil;
					status = v.status;
				});
				if(hasil == 1){
					$('#'+spnSts).removeClass('label');
					$('#'+spnSts).removeClass('label-as-badge');
					$('#'+spnSts).removeClass('label-primary');
					$('#'+spnSts).removeClass('label-warning');
					$('#'+spnSts).removeClass('label-danger');
					$('#'+spnSts).removeClass('label-success');
					$('#'+spnSts).removeClass('label-info');
					if(statusAbs=='R'){
						$("#"+spnSts).html('-');
					}else{
						if(statusAbs == 'S'){
							$('#'+spnSts).addClass("label label-primary label-as-badge");
						}else if(statusAbs == 'I'){
							$('#'+spnSts).addClass("label label-warning label-as-badge");
						}else if(statusAbs == 'TK'){
							$('#'+spnSts).addClass("label label-danger label-as-badge");
						}else if(statusAbs == 'DL'){
							$('#'+spnSts).addClass("label label-success label-as-badge");
						}else if(statusAbs == 'C'){
							$('#'+spnSts).addClass("label label-success label-as-badge");
						}else if(statusAbs == 'DI'){
							$('#'+spnSts).addClass("label label-success label-as-badge");
                        }else if(statusAbs == 'LP'){
                            $('#'+spnSts).addClass("label label-success label-as-badge");
						}else if(statusAbs == 'TA'){
							$('#'+spnSts).addClass("label label-info label-as-badge");
						}
						$("#"+spnSts).html(statusAbs);
					}
				}else{
					alert('Query gagal');
				}
				$("#"+divlst).css("pointer-events", "auto");
				$("#"+divlst).css("opacity", "1");
			}
		}).done(function(){

		});
	}

	function histAbsensi($modal, $winupload, $idpeg){
		var request = $.get("listabsensi_historis.php?id="+$idpeg);
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

	$(function () {
		$('#container1').highcharts({
			chart: {
				plotBackgroundColor: null,
				plotBorderWidth: null,
				plotShadow: false,
				type: 'pie'
			},
			title: {
				text: ''
			},
			tooltip: {
				pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
			},
			plotOptions: {
				pie: {
					allowPointSelect: true,
					cursor: 'pointer',
					dataLabels: {
						enabled: true,
						distance: 0,
						format: '<b>{point.percentage:.1f} %</b>',
						style: {
							color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
						}
					},
					showInLegend: true
				}
			},
			series: [{
				name: 'Persentase',
				colorByPoint: true,
				data: <?php echo $data1; ?>
			}]
		});
	});

	$(function () {
		$('#container2').highcharts({
			chart: {
				plotBackgroundColor: null,
				plotBorderWidth: null,
				plotShadow: false,
				type: 'pie'
			},
			title: {
				text: ''
			},
			tooltip: {
				pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
			},
			plotOptions: {
				pie: {
					allowPointSelect: true,
					cursor: 'pointer',
					dataLabels: {
						enabled: true,
						distance: 0,
						format: '<b>{point.percentage:.1f} %</b>',
						style: {
							color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
						}
					},
					showInLegend: true
				}
			},
			series: [{
				name: 'Persentase',
				colorByPoint: true,
				data: <?php echo $data2; ?>
			}]
		});
	});

	$(function () {
		$('#container3').highcharts({
			chart: {
				type: 'column'
			},
			title: {
				text: ''
			},
			subtitle: {
				text: ''
			},
			xAxis: {
				categories: [
					'Total',
					'Hadir',
					'Tidak Hadir'
				],
				crosshair: true
			},
			yAxis: {
				min: 0,
				title: {
					text: 'Jumlah'
				}
			},
			tooltip: {
				headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
				pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
				'<td style="padding:0"><b>{point.y:.1f}</b></td></tr>',
				footerFormat: '</table>',
				shared: true,
				useHTML: true
			},
			plotOptions: {
				column: {
					pointPadding: 0.2,
				},
				series: {
					borderWidth: 1,
					borderColor: 'grey'
				}
			},
			series: [{
				name: 'Hari Kerja',
				data: <?php echo $data3;?>,
				dataLabels: {
					enabled: true,
					rotation: -90,
					color: '#FFFFFF',
					align: 'right',
					format: '{point.y}', // one decimal
					y: 10, // 10 pixels down from the top
					style: {
						fontSize: '13px',
						fontFamily: 'Verdana, sans-serif'
					}
				}
			}]
		});
	});

	$(function () {
		$('#container4').highcharts({
			chart: {
				type: 'column'
			},
			title: {
				text: ''
			},
			subtitle: {
				text: ''
			},
			xAxis: {
				categories: [
					'Total',
					'Hadir',
					'Tidak Hadir'
				],
				crosshair: true
			},
			yAxis: {
				min: 0,
				title: {
					text: 'Jumlah'
				}
			},
			tooltip: {
				headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
				pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
				'<td style="padding:0"><b>{point.y:.1f}</b></td></tr>',
				footerFormat: '</table>',
				shared: true,
				useHTML: true
			},
			plotOptions: {
				column: {
					pointPadding: 0.2
				},
				series: {
					borderWidth: 1,
					borderColor: 'grey',
					cursor: 'pointer',
					point: {
						events: {
							click: function () {
								if(this.category == 'Tidak Hadir'){
									detailListPegawaiTdkHadir('<?php echo $bln; ?>','<?php echo $thn; ?>','<?php echo $id_skpd; ?>','skpd');
								}
							}
						}
					}
				}
			},
			series: [{
				name: 'Orang/Pegawai',
				data: <?php echo $data4;?>,
				dataLabels: {
					enabled: true,
					rotation: -90,
					color: '#FFFFFF',
					align: 'right',
					format: '{point.y}', // one decimal
					y: 10, // 10 pixels down from the top
					style: {
						fontSize: '13px',
						fontFamily: 'Verdana, sans-serif'
					}
				}
			}]
		});
	});

	$(function () {
		$('#container5').highcharts({
			chart: {
				plotBackgroundColor: null,
				plotBorderWidth: null,
				plotShadow: false,
				type: 'pie'
			},
			title: {
				text: ''
			},
			tooltip: {
				pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
			},
			plotOptions: {
				pie: {
					allowPointSelect: true,
					cursor: 'pointer',
					dataLabels: {
						enabled: true,
						distance: 0,
						format: '<b>{point.percentage:.1f} %</b>',
						style: {
							color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
						}
					},
					showInLegend: true
				}
			},
			series: [{
				name: 'Persentase',
				colorByPoint: true,
				data: <?php echo $data5; ?>
			}]
		});
	});

	$(function () {
		$('#container6').highcharts({
			chart: {
				plotBackgroundColor: null,
				plotBorderWidth: null,
				plotShadow: false,
				type: 'pie'
			},
			title: {
				text: ''
			},
			tooltip: {
				pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
			},
			plotOptions: {
				pie: {
					allowPointSelect: true,
					cursor: 'pointer',
					dataLabels: {
						enabled: true,
						distance: 0,
						format: '<b>{point.percentage:.1f} %</b>',
						style: {
							color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
						}
					},
					showInLegend: true
				}
			},
			series: [{
				name: 'Persentase',
				colorByPoint: true,
				data: <?php echo $data6; ?>
			}]
		});
	});

	$(function () {
		$('#container7').highcharts({
			chart: {
				type: 'column'
			},
			title: {
				text: ''
			},
			subtitle: {
				text: ''
			},
			xAxis: {
				categories: [
					'Total',
					'Hadir',
					'Tidak Hadir'
				],
				crosshair: true
			},
			yAxis: {
				min: 0,
				title: {
					text: 'Jumlah'
				}
			},
			tooltip: {
				headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
				pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
				'<td style="padding:0"><b>{point.y:.1f}</b></td></tr>',
				footerFormat: '</table>',
				shared: true,
				useHTML: true
			},
			plotOptions: {
				column: {
					pointPadding: 0.2,
				},
				series: {
					borderWidth: 1,
					borderColor: 'grey'
				}
			},
			series: [{
				name: 'Hari Kerja',
				data: <?php echo $data7;?>,
				dataLabels: {
					enabled: true,
					rotation: -90,
					color: '#FFFFFF',
					align: 'right',
					format: '{point.y}', // one decimal
					y: 10, // 10 pixels down from the top
					style: {
						fontSize: '13px',
						fontFamily: 'Verdana, sans-serif'
					}
				}
			}]
		});
	});

	$(function () {
		$('#container8').highcharts({
			chart: {
				type: 'column'
			},
			title: {
				text: ''
			},
			subtitle: {
				text: ''
			},
			xAxis: {
				categories: [
					'Total',
					'Hadir',
					'Tidak Hadir'
				],
				crosshair: true
			},
			yAxis: {
				min: 0,
				title: {
					text: 'Jumlah'
				}
			},
			tooltip: {
				headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
				pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
				'<td style="padding:0"><b>{point.y:.1f}</b></td></tr>',
				footerFormat: '</table>',
				shared: true,
				useHTML: true
			},
			plotOptions: {
				column: {
					pointPadding: 0.2
				},
				series: {
					borderWidth: 1,
					borderColor: 'grey',
					cursor: 'pointer',
					point: {
						events: {
							click: function () {
								if(this.category == 'Tidak Hadir'){
									detailListPegawaiTdkHadir('<?php echo $bln; ?>','<?php echo $thn; ?>','<?php echo $_SESSION['id_unit']; ?>','unit');
								}
							}
						}
					}
				}
			},
			series: [{
				name: 'Orang/Pegawai',
				data: <?php echo $data8;?>,
				dataLabels: {
					enabled: true,
					rotation: -90,
					color: '#FFFFFF',
					align: 'right',
					format: '{point.y}', // one decimal
					y: 10, // 10 pixels down from the top
					style: {
						fontSize: '13px',
						fontFamily: 'Verdana, sans-serif'
					}
				}
			}]
		});
	});

	function detailListPegawai(bln, thn, idlokasi, status, tipe){
		$("#divDetLstPeg").html('');
		var request = $.get("listabsensi_listpegawai.php?bln="+bln+"&thn="+thn+"&idlokasi="+idlokasi+"&status="+status+"&tipe="+tipe+"&auth="+<?php echo $auth?>);
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
				function( response ){listabsensi_listpegawai
					return({
						success: false,
						data: null,
						errors: [ "Unexpected error: " + response.status + " " + response.statusText ]
					});
				}
		);
		request.then(
				function( response ){
					$("#divDetLstPeg").html(response);
				}
		);
		$("#spnTitle").html(status);
		$("#modalDetLstPeg").modal('show');
	}

	function detailListPegawaiTdkHadir(bln, thn, idlokasi, tipe){
		$("#divDetLstPeg").html('');
		var request = $.get("listabsensi_listpegawai_tdkhadir.php?bln="+bln+"&thn="+thn+"&idlokasi="+idlokasi+"&tipe="+tipe+"&auth="+<?php echo $auth?>);
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
				function( response ){listabsensi_listpegawai
					return({
						success: false,
						data: null,
						errors: [ "Unexpected error: " + response.status + " " + response.statusText ]
					});
				}
		);
		request.then(
				function( response ){
					$("#divDetLstPeg").html(response);
				}
		);
		$("#spnTitle").html('Tidak Hadir');
		$("#modalDetLstPeg").modal('show');
	}

</script>
<script src="js/bootstrap3-dialog/js/bootstrap-dialog.min.js"></script>
