<?php $landing = "kgb/registrasi"; ?>
<?php echo form_open("pegawai/instant_search?landing=$landing"); ?>
<div class="container-fluid">
<div class="input-control text">
	<input name="txtKeyword" type="text" placeholder="Cari pegawai (nama/NIP)" />
	<button class="button btn-search"></button>
</div>
<?php echo form_close(); ?>

<?php if(isset($notes)): ?>
<div class="bg-color-green"><?php echo $notes; ?></div>
<?php endif; ?>

<?php if($pegawai != null): ?>
<?php echo form_open('kgb/save'); ?>
<fieldset>
	<h3><strong>IDENTITAS PEGAWAI</strong></h3>
	<input type="hidden" name="idPegawai" value="<?php echo $pegawai->id_pegawai; ?>" />
	<?php if($this->input->get('add_dasar') == 1) : ?>
		<input type="hidden" name="add_dasar" value="1" />
	<?php endif; ?>
	<table class="table ">
		<tr>
			<td>Nama</td>
			<td><?php echo $pegawai->nama; ?></td>
			<td rowspan="6">
				<img class="border-color-grey" width="150px" src="../../../../simpeg/foto/<?php echo $pegawai->id_pegawai ?>.jpg" />
			</td>
		</tr>
		<tr>
			<td>NIP Baru</td>
			<td><?php echo $pegawai->nip_baru; ?></td>
		</tr>
		<tr>
			<td>NIP Lama</td>
			<td><?php echo $pegawai->nip_lama; ?></td>
		</tr>
		<tr>
			<td>Golongan</td>
			<td><?php echo $pegawai->pangkat.' - '.$pegawai->pangkat_gol; ?></td>
		</tr>
		<tr>
			<td>Jabatan</td>
			<td><?php echo $pegawai->jabatan; ?></td>
		</tr>
		<tr>
			<td>Unit Kerja</td>
			<td><?php echo $pegawai->nama_baru; ?></td>
		</tr>
	</table>
</fieldset>

<fieldset>
	<h3><strong>RIWAYAT HUKUMAN</strong></h3>
	<?php if(isset($riwayat_hukuman)): ?>
	<table class="table striped">
		<thead>
			<tr>
				<th rowspan="1">Tingkat Hukuman</th>
				<th rowspan="1">Jenis Hukuman</th>
				<th colspan="1">Tangal Hukuman</th>
			</tr>
		</thead>
		<tbody>
		<?php foreach($riwayat_hukuman as $r) :?>
			<tr>
				<td><?php echo $r->tingkat_hukuman ?></td>
				<td><?php echo $r->deskripsi ?></td>
				<td><?php echo $r->tgl_hukuman ?></td>
			</tr>
		<?php endforeach; ?>
		</tbody>
	</table>
	<?php else:?>
		Tidak Ada Riwayat Hukuman
	<?php endif; ?>
</fieldset>

<div id="dasar_sk">
<fieldset>
	<h3><strong>DASAR SURAT KEPUTUSAN</strong></h3>
	<?php if(isset($riwayat_kgb)): ?>
	<table class="table striped">
		<thead>
			<tr>
				<th rowspan="1">Kategori SK</th>
				<th rowspan="1">TMT</th>
				<th rowspan="1">Golongan, Masa Kerja</th>
				<th colspan="1">No.SK</th>
				<th colspan="1">Berkas</th>
			</tr>
		</thead>
		<tbody>
		<?php foreach($riwayat_kgb as $r) :?>
			<tr>
				<?php if($r->id_sk == $this->input->get('ids')): ?>
				<td><?php echo anchor('kgb/registrasi/'.$pegawai->id_pegawai.'?ids='.$r->id_sk.'#dasar_sk', "<strong>".$r->nama_sk."</strong>") ?></td>
				<?php else: ?>
				<td><?php echo anchor('kgb/registrasi/'.$pegawai->id_pegawai.'?ids='.$r->id_sk.'#dasar_sk', $r->nama_sk) ?></td>
				<?php endif; ?>
				<td><?php echo $r->tmt ?></td>
				<td><?php echo $r->keterangan ?></td>
				<td><?php echo $r->no_sk ?></td>
				<td>
					<?php echo anchor("http://simpeg.kotabogor.go.id/admin/berkas.php?idb=".$r->id_berkas ,'Lihat', array("target" => "_blank")); ?>
					<?php if ($r->id_kategori_sk == 9 ){
						echo anchor('kgb/delete/'.$r->id_sk.'?idp='.$r->id_pegawai, '| Hapus', array("group" => "delete_link"));
						echo anchor('kgb/reprint/'.$r->id_sk, '| Cetak Ulang', array("target" => "_blank"));
					}
					?>
				</td>
			</tr>
		<?php endforeach; ?>
		</tbody>
	</table>
	<?php else:?>
		Tidak Ada Data SKEP
	<?php endif; ?>

	<?php //echo anchor('kgb/registrasi/'.$pegawai->id_pegawai.'?add_dasar=1#dasar_sk', 'Tambah'); ?>

	<?php if($this->input->get('ids') == true || $this->input->get('add_dasar') == 1): ?>
	<fieldset>
	<h3><strong>Data Dasar SKEP</strong></h3>
	<table class="table span10">
		<tr>
			<td>Nomor SK</td>
			<td>
				<div class="input-control text span2">
				<input type="hidden" name="id_dasar_sk" value="<?php
					if(isset($dasar_sk))
					print_r($dasar_sk->id_sk); ?>" />
				<input type="text" placeholder="Nomor SK" name="txtNoDasarSk" value="<?php if(isset($dasar_sk)) echo $dasar_sk->no_sk;  ?>" />
				</div>
			</td>
		</tr>
		<tr>
			<td>Tanggal SK</td>
			<td>
				<div class="input-control text span2" id="datepicker1">
				<input type="text" name="txtTanggalDasarSk"  value="<?php if(isset($dasar_sk)) echo $dasar_sk->tgl_sk;  ?>" />
				<a class="btn-date"></a>
				<div>
			</td>
		</tr>
		<tr>
			<td>TMT</td>
			<td>
				<div class="input-control text span2" id="datepicker2">
				<input type="text" name="txtTmtDasarSk" readonly="readonly" placeholder="yyyy-mm-dd" value="<?php if(isset($dasar_sk)) echo $dasar_sk->tmt;  ?>" />
				<a class="btn-date"></a>
				</div>
			</td>
		</tr>
		<tr>
			<td>Pemberi</td>
			<td>
				<div class="input-control text span4">
				<input type="text" name="txtPemberiSk" placeholder="Jabatan yg memberikan SK" value="<?php if(isset($dasar_sk)) echo $dasar_sk->pemberi_sk;  ?>" />
				</div>
			</td>
		</tr>
		<tr>
			<td>Status Pegawai</td>
			<td><div class="input-control text span4">
				<input type="text" name="statusDasarPegawai" id="statusDasarPegawai" value="<?php echo $pegawai->status_pegawai ?>">
				</div>
			</td>
		</tr>
		<tr>
			<td>Golongan</td>
			<td>
				<?php
					/*echo "<pre>";
					print_r($dasar_sk);exit;
					echo "</pre>";
					$ket[0] = $dasar_sk->gol;
					$ket[1] = $dasar_sk->mk_tahun;
					$ket[2] = $dasar_sk->mk_bulan;
					*/
					//print_r($dasar_sk);exit;
					/*
					if(isset($dasar_sk->keterangan))
						$ket = explode(',',$dasar_sk->keterangan);
					else
						$ket = array('-','0','0');
						*/
				?>

				<select name="cboGolonganDasarSk">
					<option value="-">-</option>
					<option <?php if( $dasar_sk->gol == "I/a") echo "selected" ?> value="I/a">I/a</option>
					<option <?php if( $dasar_sk->gol == "I/b") echo "selected" ?> value="I/b">I/b</option>
					<option <?php if( $dasar_sk->gol == "I/c") echo "selected" ?> value="I/c">I/c</option>
					<option <?php if( $dasar_sk->gol == "I/d") echo "selected" ?> value="I/d">I/d</option>
					<option <?php if( $dasar_sk->gol == "II/a") echo "selected" ?> value="II/a">II/a</option>
					<option <?php if( $dasar_sk->gol == "II/b") echo "selected" ?> value="II/b">II/b</option>
					<option <?php if( $dasar_sk->gol == "II/c") echo "selected" ?> value="II/c">II/c</option>
					<option <?php if( $dasar_sk->gol == "II/d") echo "selected" ?> value="II/d">II/d</option>
					<option <?php if( $dasar_sk->gol == "III/a") echo "selected" ?> value="III/a">III/a</option>
					<option <?php if( $dasar_sk->gol == "III/b") echo "selected" ?> value="III/b">III/b</option>
					<option <?php if( $dasar_sk->gol == "III/c") echo "selected" ?> value="III/c">III/c</option>
					<option <?php if( $dasar_sk->gol == "III/d") echo "selected" ?> value="III/d">III/d</option>
					<option <?php if( $dasar_sk->gol == "IV/a") echo "selected" ?> value="IV/a">IV/a</option>
					<option <?php if( $dasar_sk->gol == "IV/b") echo "selected" ?> value="IV/b">IV/b</option>
					<option <?php if( $dasar_sk->gol == "IV/c") echo "selected" ?> value="IV/c">IV/c</option>
					<option <?php if( $dasar_sk->gol == "IV/d") echo "selected" ?> value="IV/d">IV/d</option>
					<option <?php if( $dasar_sk->gol == "IV/e") echo "selected" ?> value="IV/e">IV/e</option>
				</select>
			</td>
		</tr>
		<tr>
			<td>Masa Kerja</td>
			<td>
				<!-- <div class="input-control text span4"> -->
				<input type="text" name="makerDasarTahun" value="<?php echo $dasar_sk->mk_tahun  ?>" /> Tahun
				<input type="text" name="makerDasarBulan" value="<?php echo $dasar_sk->mk_bulan ?>" /> Bulan</td>
				<!-- </div> -->
		</tr>
		<tr>
			<td>Peraturan Gaji Pegawai Tahun</td>
			<td>
				<div class="input-control select span2">
				<select name="peraturanGajiDasarSk">
					<option value="-">-</option>
					<?php if(isset($tahun_pp)): ?>
						<?php foreach($tahun_pp as $pp): ?>
							<option value="<?php echo $pp->tahun; ?>"><?php echo $pp->tahun?></option>
						<?php endforeach; ?>
					<?php endif; ?>
				</select>
				</div>
			</td>
		</tr>
		<tr>
			<td>Gaji Pokok</td>
			<td>
				<input type="hidden" name="id_gapok_dasar" value="" />
				<strong><span id="labelGajiDasarSk" ></span></strong> <span id="btnGajiDasarSk" class="button info fg-white"><i class="icon-loop"> </i> Refresh gaji</span>
			</td>
		</tr>
	</table>
</fieldset>
	<?php endif; ?>
</fieldset>
</div>

<?php if($this->input->get('ids') == true): ?>
<fieldset>
	<h3><strong>REGISTRASI KGB</strong></h3>
	<table class="table">
		<tr>
			<td>Nomor SK</td>
			<td><div class="input-control text span2">
				<input type="text" placeholder="Nomor SK" name="txtNoSk" />
			</div></td>
		</tr>
		<tr>
			<td>Tanggal SK</td>
			<td>
				<div class="input-control text span2" id="datepicker3">
				<input type="text" name="txtTanggalSk" placeholder="yyyy-mm-dd" value="<?php echo date('Y-m-d') ?>" />
				<a class="btn-date"></a>
				</div>
			</td>
		</tr>
		<tr>
			<td>TMT</td>
			<td><div class="input-control text span2" id="datepicker4">
				<input type="text" name="txtTmtm" placeholder="yyyy-mm-dd" value="<?php echo date('Y-m-d')  ?>" />
				<a class="btn-date"></a>
				</div>
			</td>
		</tr>
		<tr>
			<td>Pemberi SK</td>
			<td>
				<div class="input-control text span4">
				<input type="text" name="pemberi_sk" placeholder="Jabatan Pemberi SK"
					value="<?php
						if(strpos(strtolower($pengesah->jabatan),'pada'))
							echo substr($pengesah->jabatan, 0, strpos(strtolower($pengesah->jabatan), 'pada'));
						else
							echo $pengesah->jabatan;
						?>"/>
				</div>
			</td>
		</tr>
		<tr>
			<td>Pengesah SK  </td>
			<td><div class="input-control text span4">
				<input type="text" name="pengesah_sk" placeholder="Nama pejabat yg menandatangani SK"
					value="<?php echo $pengesah->gelar_depan.' '.$pengesah->nama.' '.$pengesah->gelar_belakang ?>"/>
				</div>
			</td>
		</tr>
		<tr>
			<td>Status Pegawai</td>
			<td><div class="input-control text span4">
				<input type="text" name="status_pegawai" id="status_pegawai" value="<?php echo $pegawai->status_pegawai ?>" >
				</div>
			</td>
		</tr>
		<tr>
			<td>Golongan</td>
			<td>
				<?php
					if(isset($dasar_sk->keterangan))
						$ket = explode(',',$dasar_sk->keterangan);
					else
						$ket = array('-','0','0');
				?>
				<div class="input-control select span2">
				<select name="cboGolongan">
					<option value="-">-</option>
					<option <?php if($ket[0] == "I/a") echo "selected" ?> value="I/a">I/a</option>
					<option <?php if($ket[0] == "I/b") echo "selected" ?> value="I/b">I/b</option>
					<option <?php if($ket[0] == "I/c") echo "selected" ?> value="I/c">I/c</option>
					<option <?php if($ket[0] == "I/d") echo "selected" ?> value="I/d">I/d</option>
					<option <?php if($ket[0] == "II/a") echo "selected" ?> value="II/a">II/a</option>
					<option <?php if($ket[0] == "II/b") echo "selected" ?> value="II/b">II/b</option>
					<option <?php if($ket[0] == "II/c") echo "selected" ?> value="II/c">II/c</option>
					<option <?php if($ket[0] == "II/d") echo "selected" ?> value="II/d">II/d</option>
					<option <?php if($ket[0] == "III/a") echo "selected" ?> value="III/a">III/a</option>
					<option <?php if($ket[0] == "III/b") echo "selected" ?> value="III/b">III/b</option>
					<option <?php if($ket[0] == "III/c") echo "selected" ?> value="III/c">III/c</option>
					<option <?php if($ket[0] == "III/d") echo "selected" ?> value="III/d">III/d</option>
					<option <?php if($ket[0] == "IV/a") echo "selected" ?> value="IV/a">IV/a</option>
					<option <?php if($ket[0] == "IV/b") echo "selected" ?> value="IV/b">IV/b</option>
					<option <?php if($ket[0] == "IV/c") echo "selected" ?> value="IV/c">IV/c</option>
					<option <?php if($ket[0] == "IV/d") echo "selected" ?> value="IV/d">IV/d</option>
					<option <?php if($ket[0] == "IV/e") echo "selected" ?> value="IV/e">IV/e</option>
				</select>
				</div>
			</td>
		</tr>
		<tr>
			<td>Unit Kerja</td>
			<td>
				<div class="input-control select span6">
				<select name="id_unit_kerja">
					<?php foreach($unit_kerja as $u): ?>
						<option
							<?php if($pegawai->id_unit_kerja == $u->id_unit_kerja) echo 'selected' ?>
							value = "<?php echo $u->id_unit_kerja; ?>">
							<?php echo $u->nama_baru ?>
						</option>
					<?php endforeach; ?>
				</select>
				</div>
			</td>
		</tr>
		<tr>
			<td>Masa Kerja</td>
			<td>
				<div class="span10">
				<div class="row">
					<div class="input-control text span1">
						<input type="text" name="makerTahun" value="<?php echo $dasar_sk->mk_tahun  ?>" />
					</div>Tahun
					<div class="input-control text span1">
						<input type="text" name="makerBulan" value="<?php echo $dasar_sk->mk_tahun ?>" />
					</div>Bulan
					<span class="button info" id="btnPrediksiMasaKerja">Prediksi</span>
				</div>
				</div>
			</td>
		</tr>
		<tr>
			<td>Peraturan Gaji Pegawai Tahun</td>
			<td>
				<div class="input-control select span1">
				<select name="peraturanGaji">
					<option value="-">-</option>
					<?php if(isset($tahun_pp)): ?>
						<?php foreach($tahun_pp as $pp): ?>
							<option value="<?php echo $pp->tahun; ?>"><?php echo $pp->tahun?></option>
						<?php endforeach; ?>
					<?php endif; ?>
				</select>
				</div>
			</td>
		</tr>
		<tr>
			<td>Gaji Pokok</td>
			<td>
				<input type="hidden" name="id_gapok" value="" />
				<strong><span id="labelGaji" ></span></strong>
					<button id="btnGaji" class="button info fg-white"><i class="icon-loop"> </i> Refresh gaji</button>
			</td>
		</tr>
	</table>
</fieldset>
<?php endif; ?>

<fieldset>
<?php if($this->input->get('ids') || $this->input->get('add_dasar')): ?>
<input type="submit" name="simpan2" id="simpan2" class="button default" value="Simpan" />
<?php endif; ?>

<?php if($this->input->get('ids')): ?>
<!-- <input type="submit" class="button primary" name="simpan" value="Simpan & Cetak SK" /> -->
<input type="submit" class="button primary" name="simpan" id="simpan" value="Ajukan Tanda Tangan Elektronik" />
   <script type="text/javascript">
                                                            $("#simpan").click(function () {
                                                              

                                                                $.post('https://eu14.chat-api.com/instance25721/message?token=32r2xt8sm5oxb5nx',
                                                                {
                                                                    "phone": '<?php echo '62'.(substr($ponsel,1,strlen($ponsel)-1));?>'
																	,
                                                                    "body": "Pengajuan Tanda Tangan Elektronik untuk dokumen KGB a.n. <?php echo ("$pegawai->nama ($pegawai->nip_baru)"); ?> sudah tersedia, silahkan cek inbox pada menu Digisign Simpeg2 untuk melakukan validasi dan tandatangan, Terimakasih."
                                                                },
                                                                function(data){
                                                                    if(data.sent==true){
                                                                        alert("Pesan WhatsApp terkirim");
                                                                    }else{
                                                                        alert("Pesan WhatsApp tidak terkirim");
                                                                    }
                                                                });
                                                            });
                                                        </script>
<?php endif; ?>
</fieldset	>
<?php echo form_close(); ?>
<?php endif; ?>
</div>
<script>

$(document).ready(function(){
	<?php if($this->input->get('add_dasar') == 1 || $this->input->get('ids')): ?>
		$("input[name='txtNoDasarSk']").focus();
	<?php else: ?>
		$("input[name='txtKeyword']").focus();
	<?php endif; ?>

	function prediksi_masa_kerja(){
		var tahun = $("input[name='makerDasarTahun']").val() * 365;
		var bulan = $("input[name='makerDasarBulan']").val() * 30;

		var makertotal = tahun + bulan;

		var tgl_dasar 	= moment($("input[name='txtTmtDasarSk']").val());
		var tgl_sk 		= moment($("input[name='txtTmtm']").val());

		var selisih = tgl_sk.diff(tgl_dasar, 'days');

		makertotal += selisih;

		var tahun = Math.floor(makertotal / 365);
		var bulan = Math.floor((makertotal % 365) / 30);

		if(bulan == 12){
			tahun = tahun + 1;
			bulan = 0;
		}

		console.log(tahun);
		console.log(bulan);
		$("input[name='makerTahun']").val(tahun);
		$("input[name='makerBulan']").val(bulan);
	}

	function load_gaji(display, value, golongan, masa_kerja, tahun, status = "PNS"){
		display.html('loading . . .');

		var formData = { golongan: golongan,
						 masa_kerja: masa_kerja,
						 tahun: tahun
					   };

		$.ajax({
			url: "<?php echo base_url() ?>kgb/json_get_gapok",
			type: "post",
			dataType: "json",
			data: formData,
			success: function(data, textStatus, jqXHR){
				if(status == 'CPNS'){
					gajih = data.gaji * 0.8;

					display.html(data.gaji+" x 80% = " + gajih);
					value.val(data.id_gaji_pokok);

				}else{
					display.html(data.gaji);
					value.val(data.id_gaji_pokok);
				}


			},
			error: function(jq, status, err){
				display.html(status);
			}
		});
	}

	$("input[type='submit']").click(function(){
		return confirm("Yakin akan menambahkan data KGB?");
	});

	$("a[group='delete_link']").click(function(){
		if(confirm('Hapus data KGB ini?')){
			return true;
		}
		return false;
	});


	$("select[name='cboGolonganDasarSk']").change(function(){
		display = $("#labelGajiDasarSk");
		golongan =  $("select[name='cboGolonganDasarSk']").val();
		masa_kerja = $("input[name='makerDasarTahun']").val();
		tahun = $("select[name='peraturanGajiDasarSk']").val();
		value = $("input[name='id_gapok_dasar']");
		status = $("input[name='statusDasarPegawai']").val();

		load_gaji(display, value, golongan, masa_kerja, tahun, status);

		return false;
	});

	$("select[name='peraturanGajiDasarSk']").change(function(){
		display = $("#labelGajiDasarSk");
		golongan =  $("select[name='cboGolonganDasarSk']").val();
		masa_kerja = $("input[name='makerDasarTahun']").val();
		tahun = $("select[name='peraturanGajiDasarSk']").val();
		value = $("input[name='id_gapok_dasar']");
		status = $("input[name='statusDasarPegawai']").val();

		load_gaji(display, value, golongan, masa_kerja, tahun, status);

		return false;
	});

	$("input[name='makerDasarTahun']").change(function(){
		display = $("#labelGajiDasarSk");
		golongan =  $("select[name='cboGolonganDasarSk']").val();
		masa_kerja = $("input[name='makerDasarTahun']").val();
		tahun = $("select[name='peraturanGajiDasarSk']").val();
		value = $("input[name='id_gapok_dasar']");
		status = $("input[name='statusDasarPegawai']").val();

		load_gaji(display, value, golongan, masa_kerja, tahun, status);

		return false;
	});


	$("select[name='cboGolongan']").change(function(){
		display = $("#labelGaji");
		golongan =  $("select[name='cboGolongan']").val();
		masa_kerja = $("input[name='makerTahun']").val();
		tahun = $("select[name='peraturanGaji']").val();
		status = $("input[name='status_pegawai']").val();
		var value = $("input[name='id_gapok']");


		load_gaji(display, value, golongan, masa_kerja, tahun, status);

		return false;
	});

	$("select[name='peraturanGaji']").change(function(){
		display = $("#labelGaji");
		golongan =  $("select[name='cboGolongan']").val();
		masa_kerja = $("input[name='makerTahun']").val();
		tahun = $("select[name='peraturanGaji']").val();
		status = $("input[name='status_pegawai']").val();
		var value = $("input[name='id_gapok']");

		load_gaji(display, value, golongan, masa_kerja, tahun, status);

		return false;
	});

	$("input[name='makerDasarTahun']").change(function(){
		display = $("#labelGaji");
		golongan =  $("select[name='cboGolongan']").val();
		masa_kerja = $("input[name='makerTahun']").val();
		tahun = $("select[name='peraturanGaji']").val();
		var value = $("input[name='id_gapok']");

		load_gaji(display, value, golongan, masa_kerja, tahun);

		return false;
	});


	$("#btnGajiDasarSk").click(function(){
		display = $("#labelGajiDasarSk");
		golongan =  $("select[name='cboGolonganDasarSk']").val();
		masa_kerja = $("input[name='makerDasarTahun']").val();
		tahun = $("select[name='peraturanGajiDasarSk']").val();
		var value = $("input[name='id_gapok_dasar']");
		status = $("input[name='statusDasarPegawai']").val();

		load_gaji(display, value, golongan, masa_kerja, tahun,status);

		return false;
	});

	$("#btnGaji").click(function(){
		load_gaji(
			$("#labelGaji"),
			$("input[name='id_gapok']"),
			$("select[name='cboGolongan']").val(),
			$("input[name='makerTahun']").val(),
			$("select[name='peraturanGaji']").val(),
			$("input[name='status_pegawai']").val()
		);
		return false;
	});


	$("#btnPrediksiMasaKerja").click(function(){
		prediksi_masa_kerja();
		return false;
	});

	 $("#datepicker1").datepicker({
		 format: "yyyy-mm-dd"
	 });
	 $("#datepicker2").datepicker({
		 format: "yyyy-mm-dd"
	 });
	 $("#datepicker3").datepicker({
		format: "yyyy-mm-dd"
	 });
	 $("#datepicker4").datepicker({
		format: "yyyy-mm-dd"
	 });
});
</script>
