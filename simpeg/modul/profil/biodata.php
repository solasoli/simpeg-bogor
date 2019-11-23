<div class="container form-horizontal">

	<div class="row">
		<div class="col-md-8">
			<div class="form-group">
				<label for="" class="col-sm-4 control-label">Nama</label>
				<div class="col-sm-8">
					<input class="form-control" name="n" class="form-control" type="text" id="n" <?php echo $is_tim ? '': 'disabled="disabled"'?> value="<?php echo($kuta[1]); ?>" size="35" />
				</div>
			</div>
			<div class="form-group">
				<label for="" class="col-sm-4 control-label">Gelar Depan</label>
				<div class="col-sm-8">
					<input class="form-control" name="gelar_depan" type="text" id="gelar_depan" value="<?php echo($kuta['gelar_depan']); ?>" <?php echo $is_tim ? '': 'disabled="disabled"'?>/>
				</div>
			</div>
			<div class="form-group">
				<label for="" class="col-sm-4 control-label">Gelar Belakang</label>
				<div class="col-sm-8">
					<input class="form-control" name="gelar_belakang" type="text" id="gelar_belakang" value="<?php echo($kuta['gelar_belakang']); ?>" <?php echo $is_tim ? '': 'disabled="disabled"'?>/>
				</div>
			</div>
			<div class="form-group">
				<label for="" class="col-sm-4 control-label">NIP Lama</label>
				<div class="col-sm-8">
					<input class="form-control" name="nl" type="text" id="nl" value="<?php echo($kuta['nip_lama']); ?>" <?php echo $is_tim ? '': 'disabled="disabled"'?> />
				</div>
			</div>
			<div class="form-group">
				<label for="" class="col-sm-4 control-label">NIP Baru</label>
				<div class="col-sm-8">
					<input class="form-control" name="nb" type="text" id="nb" value="<?php echo($kuta['nip_baru']); ?>" size="22" <?php echo $is_tim ? '': 'disabled="disabled"'?> />
				</div>
			</div>
			<div class="form-group">
				<label for="" class="col-sm-4 control-label">Agama</label>
				<div class="col-sm-8">
							<select class="form-control" name="a" id="a" <?php echo $is_tim ? '': 'disabled="disabled"'?> >
					  <?php
					  $qjo=mysql_query("SELECT agama FROM `pegawai` where flag_pensiun=0 group by agama ");
						while($otoi=mysql_fetch_array($qjo))
						{
							if($kuta['agama']==$otoi[0])
						echo("<option value=$otoi[0] selected>$otoi[0]</option>");
						else
						echo("<option value=$otoi[0]>$otoi[0]</option>");
						}

						?>
					</select>
				</div>
			</div>
			<div class="form-group">
				<label for="" class="col-sm-4 control-label">Jenis Kelamin</label>
				<div class="col-sm-8">
					<select name="jk" class="form-control" id="jk" <?php echo $is_tim ? '': 'disabled="disabled"'?> >
              <?php
			  $qp=mysql_query("SELECT jenis_kelamin FROM `pegawai` where flag_pensiun=0 group by jenis_kelamin ");
                while($oto=mysql_fetch_array($qp))
				{
					if($kuta['jenis_kelamin']==$oto[0]){
						echo("<option value=$oto[0] selected>");
						if($oto[0]==1){
							echo('Laki-laki');
						}else if($oto[0]==2){
							echo('Perempuan');
						}else{
							echo($oto[0]);
						}
						echo("</option>");
					}else{
						echo("<option value=$oto[0]>");
						if($oto[0]==1){
							echo('Laki-laki');
						}else if($oto[0]==2){
							echo('Perempuan');
						}else{
							echo($oto[0]);
						}
						echo("</option>");
					}
				}

				?>
            </select>
				</div>
			</div>
			<div class="form-group">
				<label for="" class="col-sm-4 control-label">Tempat Lahir</label>
				<div class="col-sm-8">
					<input class="form-control" name="tl" type="text" id="tl" value="<?php echo($kuta['tempat_lahir']); ?>" />
				</div>
			</div>
			<div class="form-group">
				<label for="" class="col-sm-4 control-label">Tgl Lahir</label>
				<div class="col-sm-8">
					<input class="form-control" name="tgl" type="text" class="tcal"  id="tgl" value="<?php
						$tgl=substr($kuta['tgl_lahir'],8,2);
						$bln=substr($kuta['tgl_lahir'],5,2);
						$thn=substr($kuta['tgl_lahir'],0,4);
						echo("$tgl-$bln-$thn");
						 ?>" />
				</div>
			</div>
			<div class="form-group">
				<label for="" class="col-sm-4 control-label">Kartu Pegawai</label>
				<div class="col-sm-8">
					<input  name="karpeg" type="text" id="karpeg" value="<?php echo($kuta['no_karpeg']); ?>" />

                 <?php
			$qn=mysql_query("select id_berkas from berkas where id_pegawai=$kuta[0] and id_kat=10");
			$n=mysql_fetch_array($qn);
			if($n[0]!=null)
			echo(" <a href=lihat_berkas.php?id=$n[0] target=_blank> Lihat </a>");
			?>

			    <label> <input  type="file" name="fkarpeg" id="fkarpeg" /> </label>
				</div>
			</div>
			<div class="form-group">
				<label for="" class="col-sm-4 control-label">Karis/Karsu</label>
				<div class="col-sm-8">
					<input name="karisu" type="text" id="karisu" value="<?php echo($kuta['no_karisu']); ?>" />

                 <?php
			$qn=mysql_query("select id_berkas from berkas where id_pegawai=$kuta[0] and id_kat=11");
			$n=mysql_fetch_array($qn);
			if($n[0]!=null)
			echo(" <a href=lihat_berkas.php?id=$n[0] target=_blank> Lihat </a>");
			?>

			    <label> <input type="file" name="fkarisu" id="fkarisu" />
				</div>
			</div>
			<div class="form-group">
				<label for="" class="col-sm-4 control-label">NPWP</label>
				<div class="col-sm-8">
					<input name="npwp" type="text" id="npwp" value="<?php echo($kuta['NPWP']); ?>" />
            <?php
			$qn=mysql_query("select id_berkas from berkas where id_pegawai=$kuta[0] and id_kat=13");
			$n=mysql_fetch_array($qn);
			if($n[0]!=null)
			echo(" <a href=lihat_berkas.php?id=$n[0] target=_blank> Lihat </a>");
			?>
          			    <label>  <input type="file" name="fnpwp" id="fnpwp" />			    </label>
				</div>
			</div>
			<div class="form-group">
				<label for="" class="col-sm-4 control-label">No. KTP</label>
				<div class="col-sm-8">

            <?php
			$qn=mysql_query("select id_berkas,ket_berkas from berkas where id_pegawai=$kuta[0] and id_kat=1 and nm_berkas='KTP'");

			$n=mysql_fetch_array($qn);//$kuta['no_ktp']
			 ?>
            <input name="ktp" type="text" id="ktp" value="<?php echo($kuta['no_ktp']==''?$n[1]:$kuta['no_ktp']); ?>" />  	  <?php

			if($n[0]!=null)
			echo(" <a href=lihat_berkas.php?id=$n[0] target=_blank> Lihat </a>");
			?>       		    <label><input type="file" name="fktp" id="fktp" />			    </label>
				</div>
			</div>
			<div class="form-group">
				<label for="" class="col-sm-4 control-label">Pangkat Gol/Ruang</label>
				<div class="col-sm-8">
					<?php echo $pegawai->pangkat.", ".$pegawai->golongan ?>
				</div>
			</div>
			<div class="form-group">
				<label for="" class="col-sm-4 control-label">Unit Kerja</label>
				<div class="col-sm-8">

					<input type="text" class="form-control" disabled="disabled" value="<?php echo $pegawai->nama_baru ?>" >
				</div>
			</div>
			<div class="form-group">
				<label for="" class="col-sm-4 control-label">Jenjang Jabatan</label>
				<div class="col-sm-8">
					 <select class="form-control" name="jenjab" id="jenjab">
					  <?php
					  $qjo=mysql_query("SELECT jenjab FROM `pegawai` where flag_pensiun=0 group by jenjab ");
						while($oto=mysql_fetch_array($qjo))
						{
							if($kuta['jenjab']==$oto[0])
						echo("<option value=$oto[0] selected>$oto[0]</option>");
						else
						echo("<option value=$oto[0]>$oto[0]</option>");
						}
						?>
					</select>
				</div>
			</div>
			<div class="form-group">
				<label for="" class="col-sm-4 control-label">Jabatan ..</label>
				<div class="col-sm-8">
					<?php
					if(is_null($pegawai->id_j) && $pegawai->jenjab == 'Struktural' ){ ?>
					<!--input type="text" name="nama_jfu" id="nama_jfu" class="form-control" value=""-->
					<input class="form-control" id="nama_jfu_auto" name="nama_jfu_auto" type="text" size="50" disabled="disabled" value="<?php echo $obj_pegawai->get_jabatan($pegawai) ?>"  />
					<input id="id_jfu_p" name="id_jfu_p" type="hidden" value="<?php echo $obj_pegawai->get_idjfu() ?>" />
					<input id="nama_jfu" name="nama_jfu" type="hidden" value="<?php echo $obj_pegawai->get_kode_jab() ?>" /><div id="container"></div>
				<?php }else{
						echo $obj_pegawai->get_jabatan($pegawai);
						// edited eko
					}

				?>
				</div>
			</div>
			<div class="form-group">
				<label for="" class="col-sm-4 control-label">Status Pegawai</label>
				<div class="col-sm-8">
					<?php	echo $pegawai->status_pegawai; ?>
						</div>
					</div>
					<div class="form-group">
						<label for="" class="col-sm-4 control-label">Jabatan Atasan</label>
						<div class="col-sm-8">
							<?php
					$qrk=("select id_j_bos,
							id_riwayat from riwayat_mutasi_kerja
							inner join sk on sk.id_sk=riwayat_mutasi_kerja.id_sk where sk.id_pegawai=$od order by tmt desc");

					$qrk = mysql_query($qrk);
					$rk=mysql_fetch_array($qrk);
					//echo $unit[0];
					$qbener=mysql_query("select id_skpd,nama_baru from unit_kerja where id_unit_kerja=$unit[0]");
					$bener=mysql_fetch_array($qbener);
					$qjob=mysql_query("select id_j,jabatan from jabatan inner join unit_kerja on unit_kerja.id_unit_kerja=jabatan.id_unit_kerja
									where id_skpd=$bener[0] and unit_kerja.tahun = 2015");

					//echo "id_unit : ". $unit[1];//"id_skpd :".$bener[0];
					?>
					<select class="form-control" name="jx" id="jx">
						<option>pilih</option>
					<?php
					if($kuta['jenjab']=='Fungsional' and (strpos($bener[1],'SMA') !== false or strpos($bener[1],'SMP') !== false or strpos($bener[1],'SD') !== false or strpos($bener[1],'TK') !== false))
					{

					if(strpos($bener[1],'SMP') !== false)
					$tingkat="SMP";
					elseif(strpos($bener[1],'SMA') !== false)
					$tingkat="SMA";
					elseif(strpos($bener[1],'SD') !== false)
					$tingkat="SD";
					elseif(strpos($bener[1],'TK') !== false)
					$tingkat="TK";

					$qbos=mysql_query("select nama,
									nama_baru,pegawai.id_pegawai
									from pegawai
									inner join current_lokasi_kerja on current_lokasi_kerja.id_pegawai=pegawai.id_pegawai
									inner join unit_kerja on unit_kerja.id_unit_kerja =current_lokasi_kerja.id_unit_kerja
									where nama_baru like '%$tingkat%'
									and unit_kerja.tahun=(select max(tahun) from unit_kerja) and is_kepsek=1 order by nama_baru ASC");

					while($bos=mysql_fetch_array($qbos))
					{
					if($rk[0]==$bos[2])
					echo("<option value=$bos[2] selected=selected>Kepala Sekolah $bos[1] | $bos[0] </option>");
					else
					echo("<option value=$bos[2] >Kepala Sekolah $bos[1] | $bos[0] </option>");

					}
					}
					else
					{

					while($job=mysql_fetch_array($qjob))
					{
					if($rk[0]==$job[0])
					echo("<option value=$job[0] selected>$job[1]</option>");
					else
					echo("<option value=$job[0]> $job[1]</option>");
					}
					}
					?>
					</select>
				</div>
			</div>
			<div class="form-group">
				<label for="" class="col-sm-4 control-label">Telepon</label>
				<div class="col-sm-8">
					<input name="telp" class="form-control" type="text" id="telp" value="<? echo($kuta['telepon']); ?>" />
				</div>
			</div>
			<div class="form-group">
				<label for="" class="col-sm-4 control-label">Ponsel</label>
				<div class="col-sm-8">
					<input name="hp" class="form-control" type="text" id="hp" value="<? echo($kuta['ponsel']); ?>" />
				</div>
			</div>
			<div class="form-group">
				<label for="" class="col-sm-4 control-label">Email</label>
				<div class="col-sm-8">
					<input name="email" class="form-control" type="text" id="email" value="<?php echo($kuta['email']); ?>" />
				</div>
			</div>
			<div class="form-group">
				<label for="" class="col-sm-4 control-label">Alamat</label>
				<div class="col-sm-8">
					<input name="id2" type="hidden" id="id2" value="<?php echo($od);  ?>" />
					<input name="id" type="hidden" id="id" value="<?php echo($od);  ?>" />
					<input name="x" type="hidden" id="x" value="box.php" />
					<input name="od" type="hidden" id="od" value="<?php echo("$od");  ?>" />
					<!-- riwayat_mutasi_kerja-->
					<input name="rmk" type="hidden" id="rmk" value="<?php echo("$rk[1]");  ?>" /></td>
					<textarea class="form-control" name="al" id="al" cols="45" rows="3"><?php echo($kuta['alamat']); ?></textarea>
				</div>
			</div>
			<div class="form-group">
				<label for="" class="col-sm-4 control-label">Kota</label>
				<div class="col-sm-8">
					<input class="form-control" name="kota" type="text" id="kota" value="<?php echo($kuta['kota']); ?>" />
				</div>
			</div>
			<div class="form-group">
				<label for="" class="col-sm-4 control-label">Gol. Darah</label>
				<div class="col-sm-8">
					<select class="form-control" name="darah" id="darah">
              <?php
			  $qd=mysql_query("SELECT gol_darah FROM `pegawai` where flag_pensiun=0 group by gol_darah order by gol_darah ");
                //echo "<option>-PILIH-</option>";
				while($da=mysql_fetch_array($qd))
				{
					if($kuta['gol_darah']==$da[0])
						echo("<option value=$da[0] selected>$da[0]</option>");
					else
						echo("<option value=$da[0]>$da[0]</option>");
				}

				?>
            </select>
				</div>
			</div>
			<div class="form-group">
				<label for="" class="col-sm-4 control-label">Tgl Pensiun</label>
				<div class="col-sm-8">
					<input class="form-control" name="pensiun" type="text" class="tcal"  id="pensiun" value="<?
					$tgl=substr($kuta['tgl_pensiun_dini'],8,2);
					$bln=substr($kuta['tgl_pensiun_dini'],5,2);
					$thn=substr($kuta['tgl_pensiun_dini'],0,4);
					echo("$tgl-$bln-$thn");
					 ?>" <?php echo $is_tim ? '': 'disabled="disabled"'?> />
				</div>
			</div>
		</div>
	</div>
</div>
