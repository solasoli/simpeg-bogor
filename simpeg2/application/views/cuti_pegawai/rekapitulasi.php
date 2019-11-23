

<div class="container">
	<div class="grid">
		<br>
		<div class="tab-control" data-role="tab-control" data-effect="fade">
			<ul class="tabs">
				<li class="active"><a href="#_page_1">Rekapitulasi Keseluruhan</a></li>
				<li><a href="#_page_2">Rekapitulasi Per Periode</a></li>
			</ul>
			<div class="frames">
				<div class="frame" id="_page_1">
					<h1>Rekapitulasi <small>Cuti</small> <?php echo $tahun ?></h1>
					<div  class="input-control select span2">
						<label for="pilihTahun">Pilih Tahun :</label>
						<select id="ubahTahun">
							<option selected="selected">--Pilih--</option>
							<option value="<?php echo date('Y')?>"><?php echo date('Y') ?></option>
							<option value="<?php echo date('Y')-1?>"><?php echo date('Y')-1?></option>
							<option value="<?php echo date('Y')-2?>"><?php echo date('Y')-2?></option>
						</select>
					</div>
					<div  class="input-control select span3">
						<label for="pilihUsulan">Pilih Metode Pengajuan :</label>
						<select id="ddMetodeUsulan">
							<option value="0" selected="selected">--Pilih--</option>
							<option value="1">Online</option>
							<option value="2">Offline</option>
						</select>
					</div>

					<span class="span2">
						<button id="btn_tampilkan" class="button primary" style="height: 35px; width: 130px;">
						<span class="icon-zoom-in"></span> <strong>Tampilkan</strong></button>
					</span>

					<table class="table">
						<thead>
						<tr>
							<th>Jenis Cuti</th>
							<th>Januari</th>
							<th>Februari</th>
							<th>Maret</th>
							<th>April</th>
							<th>Mei</th>
							<th>Juni</th>
							<th>Juli</th>
							<th>Agustus</th>
							<th>September</th>
							<th>Oktober</th>
							<th>November</th>
							<th>Desember</th>
							<th>Total</th>
						</tr>
						</thead>
						<tbody>
						<?php if($jenis_cutis){ ?>
							<?php foreach($jenis_cutis as $jc) { ?>
								<tr>
									<td><?php echo $jc->deskripsi ?></td>
									<td class="text-center"><?php echo $jc->Januari ?></td>
									<td class="text-center"><?php echo $jc->Februari ?></td>
									<td class="text-center"><?php echo $jc->Maret ?></td>
									<td class="text-center"><?php echo $jc->April ?></td>
									<td class="text-center"><?php echo $jc->Mei ?></td>
									<td class="text-center"><?php echo $jc->Juni ?></td>
									<td class="text-center"><?php echo $jc->Juli ?></td>
									<td class="text-center"><?php echo $jc->Agustus ?></td>
									<td class="text-center"><?php echo $jc->September ?></td>
									<td class="text-center"><?php echo $jc->Oktober ?></td>
									<td class="text-center"><?php echo $jc->November ?></td>
									<td class="text-center"><?php echo $jc->Desember ?></td>
									<td class="text-center"><?php echo $jc->Total ?></td>
								</tr>
							<?php } ?>
						<?php }else{ ?>
							<tr>
								<td colspan="13" class="warning text-center">Tidak Ada Data</td>
							</tr>
						<?php } ?>
						</tbody>
					</table>
				</div>
				<div class="frame" id="_page_2">
					<div class="grid">
						<div class="row">
							<div class="span12">
								<div class="span2">
									<div class="input-control select" style="width: 100%;">
										<select id="ddBln" style="background-color: #e3c800;">
											<option value="0" <?php echo $bln_periode==0?'selected':'' ?>>Semua Bulan</option>
											<option value="1" <?php echo $bln_periode==1?'selected':'' ?>>Januari</option>
											<option value="2" <?php echo $bln_periode==2?'selected':'' ?>>Februari</option>
											<option value="3" <?php echo $bln_periode==3?'selected':'' ?>>Maret</option>
											<option value="4" <?php echo $bln_periode==4?'selected':'' ?>>April</option>
											<option value="5" <?php echo $bln_periode==5?'selected':'' ?>>Mei</option>
											<option value="6" <?php echo $bln_periode==6?'selected':'' ?>>Juni</option>
											<option value="7" <?php echo $bln_periode==7?'selected':'' ?>>Juli</option>
											<option value="8" <?php echo $bln_periode==8?'selected':'' ?>>Agustus</option>
											<option value="9" <?php echo $bln_periode==9?'selected':'' ?>>September</option>
											<option value="10" <?php echo $bln_periode==10?'selected':'' ?>>Oktober</option>
											<option value="11" <?php echo $bln_periode==11?'selected':'' ?>>November</option>
											<option value="12" <?php echo $bln_periode==12?'selected':'' ?>>Desember</option>
										</select>
									</div>
								</div>
								<div class="span2">
									<div class="input-control select" style="width: 100%;">
										<select id="ddThn" style="background-color: #e3c800;">
											<option value="2016" <?php echo $thn_periode==2016?'selected':'' ?>>2016</option>
											<option value="2017" <?php echo $thn_periode==2017?'selected':'' ?>>2017</option>
											<option value="2018" <?php echo $thn_periode==2018?'selected':'' ?>>2018</option>
											<option value="2019" <?php echo $thn_periode==2019?'selected':'' ?>>2019</option>
											<option value="2020" <?php echo $thn_periode==2020?'selected':'' ?>>2020</option>
											<option value="2021" <?php echo $thn_periode==2021?'selected':'' ?>>2021</option>
										</select>
									</div>
								</div>
								<span class="span3">
									<div class="input-control select" style="width: 100%;">
										<select id="ddFilterCekMetode" style="background-color: #e3c800;">
											<option value="0">Semua Metode Pengajuan</option>
											<option value="1" <?php echo ($metode_pengajuan==1?'selected':''); ?>>Online</option>
											<option value="2" <?php echo ($metode_pengajuan==2?'selected':''); ?>>Offline</option>
										</select>
									</div>
								</span>
								<span class="span2">
									<button id="btn_tampilkan" class="button primary" style="height: 35px; width: 130px;">
										<span class="icon-zoom-in"></span> <strong>Tampilkan</strong></button>
								</span>
								<span class="span1">
									<button id="btn_download" class="button danger" style="height: 35px; width: 170px; margin-left: -20px;">
										<span class="icon-file"></span> <strong>Download Daftar</strong>
									</button>
								</span>
							</div>
						</div>
						<div class="row">
							<div>
								<div class="panel">
									<div class="panel-header">Berdasarkan Jenis dan Status</div>
									<div class="panel-content">
										<table class="table bordered striped" id="lst_data">
											<thead style="border-bottom: solid #a4c400 2px;">
											<tr>
												<th style="width: 20px;border-top: 1px solid rgba(111, 111, 111, 0.79);border-left: 1px solid rgba(111, 111, 111, 0.79)">No</th>
												<th style="border-right: 1px solid rgba(111, 111, 111, 0.79);border-top: 1px solid rgba(111, 111, 111, 0.79)">Status Cuti</th>
												<th style="border-right: 1px solid rgba(111, 111, 111, 0.79);border-top: 1px solid rgba(111, 111, 111, 0.79)">CLTN</th>
												<th style="border-right: 1px solid rgba(111, 111, 111, 0.79);border-top: 1px solid rgba(111, 111, 111, 0.79)">ALASAN_PENTING</th>
												<th style="border-right: 1px solid rgba(111, 111, 111, 0.79);border-top: 1px solid rgba(111, 111, 111, 0.79)">BERSALIN</th>
												<th style="border-right: 1px solid rgba(111, 111, 111, 0.79);border-top: 1px solid rgba(111, 111, 111, 0.79)">BESAR</th>
												<th style="border-right: 1px solid rgba(111, 111, 111, 0.79);border-top: 1px solid rgba(111, 111, 111, 0.79)">SAKIT</th>
												<th style="border-right: 1px solid rgba(111, 111, 111, 0.79);border-top: 1px solid rgba(111, 111, 111, 0.79)">TAHUNAN</th>
												<th style="border-right: 1px solid rgba(111, 111, 111, 0.79);border-top: 1px solid rgba(111, 111, 111, 0.79)">TOTAL</th>
											</tr>
											</thead>
											<?php if (sizeof($rptCutiJenisStatus) > 0): ?>
												<?php $i = 1; ?>
												<?php if($rptCutiJenisStatus!=''): ?>
													<?php foreach ($rptCutiJenisStatus as $lsdata): ?>
														<tr>
															<td style="border-bottom: solid #666666 1px;text-align: center;"><?php echo $i; ?></td>
															<td style="border-right: 1px solid rgba(111, 111, 111, 0.79);border-bottom: solid #666666 1px;text-align: center; text-align: left;"><?php echo $lsdata->status_cuti ?></td>
															<td style="border-right: 1px solid rgba(111, 111, 111, 0.79);border-bottom: solid #666666 1px;text-align: center"><?php echo $lsdata->CLTN ?></td>
															<td style="border-right: 1px solid rgba(111, 111, 111, 0.79);border-bottom: solid #666666 1px;text-align: center"><?php echo $lsdata->C_ALASAN_PENTING ?></td>
															<td style="border-right: 1px solid rgba(111, 111, 111, 0.79);border-bottom: solid #666666 1px;text-align: center"><?php echo $lsdata->C_BERSALIN ?></td>
															<td style="border-right: 1px solid rgba(111, 111, 111, 0.79);border-bottom: solid #666666 1px;text-align: center"><?php echo $lsdata->C_BESAR ?></td>
															<td style="border-right: 1px solid rgba(111, 111, 111, 0.79);border-bottom: solid #666666 1px;text-align: center"><?php echo $lsdata->C_SAKIT ?></td>
															<td style="border-right: 1px solid rgba(111, 111, 111, 0.79);border-bottom: solid #666666 1px;text-align: center"><?php echo $lsdata->C_TAHUNAN ?></td>
															<td style="border-right: 1px solid rgba(111, 111, 111, 0.79);border-bottom: solid #666666 1px;text-align: center"><?php echo $lsdata->TOTAL ?></td>
														</tr>
														<?php $i++; ?>
													<?php endforeach; ?>
												<?php else: ?>
													<tr class="error">
														<td colspan="8"><i>Tidak ada data</i></td>
													</tr>
												<?php endif; ?>
											<?php else: ?>
												<tr class="error">
													<td colspan="8"><i>Tidak ada data</i></td>
												</tr>
											<?php endif; ?>
										</table>
									</div>
								</div>
								<div class="panel">
									<div class="panel-header">Berdasarkan OPD</div>
									<div class="panel-content">
										<table class="table bordered striped" id="lst_data">
											<thead style="border-bottom: solid #a4c400 2px;">
											<tr>
												<th style="width: 20px;border-top: 1px solid rgba(111, 111, 111, 0.79);border-left: 1px solid rgba(111, 111, 111, 0.79)">No</th>
												<th style="border-right: 1px solid rgba(111, 111, 111, 0.79);border-top: 1px solid rgba(111, 111, 111, 0.79)">OPD</th>
												<th style="border-right: 1px solid rgba(111, 111, 111, 0.79);border-top: 1px solid rgba(111, 111, 111, 0.79)">CLTN</th>
												<th style="border-right: 1px solid rgba(111, 111, 111, 0.79);border-top: 1px solid rgba(111, 111, 111, 0.79)">ALASAN_PENTING</th>
												<th style="border-right: 1px solid rgba(111, 111, 111, 0.79);border-top: 1px solid rgba(111, 111, 111, 0.79)">BERSALIN</th>
												<th style="border-right: 1px solid rgba(111, 111, 111, 0.79);border-top: 1px solid rgba(111, 111, 111, 0.79)">BESAR</th>
												<th style="border-right: 1px solid rgba(111, 111, 111, 0.79);border-top: 1px solid rgba(111, 111, 111, 0.79)">SAKIT</th>
												<th style="border-right: 1px solid rgba(111, 111, 111, 0.79);border-top: 1px solid rgba(111, 111, 111, 0.79)">TAHUNAN</th>
											</tr>
											</thead>
											<?php if (sizeof($rptCutiPerOPD) > 0): ?>
												<?php $i = 1; ?>
												<?php if($rptCutiPerOPD!=''): ?>
													<?php foreach ($rptCutiPerOPD as $lsdata): ?>
														<tr>
															<td style="border-bottom: solid #666666 1px;text-align: center;"><?php echo $i; ?></td>
															<td style="border-right: 1px solid rgba(111, 111, 111, 0.79);border-bottom: solid #666666 1px;text-align: center; text-align: left;"><?php echo $lsdata->opd ?></td>
															<td style="border-right: 1px solid rgba(111, 111, 111, 0.79);border-bottom: solid #666666 1px;text-align: center"><?php echo $lsdata->CLTN ?></td>
															<td style="border-right: 1px solid rgba(111, 111, 111, 0.79);border-bottom: solid #666666 1px;text-align: center"><?php echo $lsdata->C_ALASAN_PENTING ?></td>
															<td style="border-right: 1px solid rgba(111, 111, 111, 0.79);border-bottom: solid #666666 1px;text-align: center"><?php echo $lsdata->C_BERSALIN ?></td>
															<td style="border-right: 1px solid rgba(111, 111, 111, 0.79);border-bottom: solid #666666 1px;text-align: center"><?php echo $lsdata->C_BESAR ?></td>
															<td style="border-right: 1px solid rgba(111, 111, 111, 0.79);border-bottom: solid #666666 1px;text-align: center"><?php echo $lsdata->C_SAKIT ?></td>
															<td style="border-right: 1px solid rgba(111, 111, 111, 0.79);border-bottom: solid #666666 1px;text-align: center"><?php echo $lsdata->C_TAHUNAN ?></td>
														</tr>
														<?php $i++; ?>
													<?php endforeach; ?>
												<?php else: ?>
													<tr class="error">
														<td colspan="8"><i>Tidak ada data</i></td>
													</tr>
												<?php endif; ?>
											<?php else: ?>
												<tr class="error">
													<td colspan="8"><i>Tidak ada data</i></td>
												</tr>
											<?php endif; ?>
										</table>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	$('#ubahTahun').on('change', function() {
	  //alert( this.value ); // or $(this).val()
	   window.location.href = "<?php echo base_url("cuti_pegawai/rekap/") ?>/" + $(this).val();
	});
</script>
