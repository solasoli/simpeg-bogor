
		<div class="post">
			<h2 class="title"><a href="#">Data &nbsp; Pribadi</a></h2>
			<div class="entry">
				<?php
				
				$tgl=substr($ata["tgl_lahir"],8,2);
				$bln=substr($ata["tgl_lahir"],5,2);
				$thn=substr($ata["tgl_lahir"],0,4);
				
				$t1=substr($ata["tgl_pensiun_dini"],8,2);
				$b1=substr($ata["tgl_pensiun_dini"],5,2);
				$th1=substr($ata["tgl_pensiun_dini"],0,4);

				
				$pot=strpos($ata["tempat_lahir"],',');
				$born=substr($ata["tempat_lahir"],0,$pot);
				
				$sql = "SELECT nama_baru from riwayat_mutasi_kerja inner join unit_kerja on riwayat_mutasi_kerja.id_unit_kerja
				=unit_kerja.id_unit_kerja where id_pegawai=$ata[id_pegawai] order by id_riwayat desc";
				
				$result = mysqli_query($mysqli,$sql);
				$r = mysqli_fetch_array($result);
				$unit = $r[0];
							
				if($dta[13]!='-')
				{$nip1=substr($ata[13],0,3);
				$nip2=substr($ata[13],3,3);
				$nip3=substr($ata[13],6,3);
				$nip="$nip1 $nip2 $nip3";
				}
				else
				$nip=$data[14];
				//untuk struktural
				
				$bln2=substr($bln,0,1);
				if($ata["id_pegawai"]<4379)
				{
				$tp=$thn+58;
				
				
				if($bln2!=0)
				{
				if($bln<12)
				$bp=$bln+1;
				else
				{$bp="01";
				$tp=$thn+59;
				
				}
				}
				else
				{
				$bln2=substr($bln,1,1);
				$bp=$bln2+1;
				if($bp!=10)
				$bp="0".$bp;
				else
				$bp=$bp;
				}
				$tglp="01-$bp-$tp";
				
				}
				//untuk fungsional
				else
				{
				$tp=$thn+60;
				if($bln>10)
				{
				if($bln<12)
				$bp=$bln+1;
				else
				{$bp="01";
				$tp=$thn+61;
				
				}
				}
				else
				{
				$bln2=substr($bln,1,1);
				$bp=$bln2+1;
				$bp="0".$bp;
				}
				$tglp="01-$bp-$tp";
				
				}
				
				?>
				
				<table width="500" border="0" cellspacing="0" cellpadding="5">
				<tr bgcolor="#f0f0f0"><td>Nama</td><td>:</td><td><?php echo($ata["nama"]); ?></td></tr>
				<tr ><td>Tempat Lahir</td><td>:</td><td><?php echo($ata["tempat_lahir"]); ?></td></tr>
				<tr bgcolor="#f0f0f0"><td>Tanggal Lahir</td><td>:</td><td><?php echo("$tgl-$bln-$thn"); ?></td></tr>
				<tr ><td>NIP Lama</td><td>:</td><td><?php echo($ata["nip_lama"]); ?></td></tr>
				<tr ><td>NIP Baru</td><td>:</td><td><?php echo($ata["nip_baru"]); ?></td></tr>
				<tr bgcolor="#f0f0f0"><td>Unit Kerja</td><td>:</td><td><?php echo($unit); ?></td>
				</tr>
				<tr ><td>Pangkat Golongan</td><td>:</td><td><?php echo($ata["pangkat"]." - ".$ata["pangkat_gol"]); ?></td></tr>
				<tr bgcolor="#f0f0f0"><td>Tanggal Pensiun</td><td>:</td><td><?php echo("$t1-$b1-$th1"); ?></td>
				</tr>
				<tr ><td>Jenjang Jabatan</td><td>:</td><td><?php echo($ata["jenjab"]); ?></td></tr>
				<?php
					if($ata["jenjab"] == 'Struktural'){
						if(isset($ata["id_j"])){
							$sql_jab = "select jabatan from jabatan where id_j=".$ata["id_j"];
							$jabatan =mysqli_fetch_array(mysqli_query($mysqli,$sql_jab))['jabatan'];	
						}else{
							$sql_jab = "select jfu_pegawai.*, jfu_master.* 
								from jfu_pegawai, jfu_master
								where jfu_pegawai.id_pegawai = '".$ata['id_pegawai']."'
								and jfu_master.kode_jabatan = jfu_pegawai.kode_jabatan";
							$jabatan =mysqli_fetch_array(mysqli_query($mysqli,$sql_jab))['nama_jfu'];							
						}
					}
				
				?>
				<tr ><td>Jabatan</td><td>:</td><td><?php echo $jabatan; ?></td></tr>
				<tr  bgcolor="#f0f0f0"><td>Jenis Kelamin</td><td>:</td><td>
							<?php
								if($ata["jenis_kelamin"] == 'L')
									echo "Laki-laki";
								else
									echo "Perempuan";
							?>
					</td></tr>
				</table>
			</div>	
		</div>
		Silahkan hubungi kami melalui menu hubungi kami yang terdapat pada bagian atas halaman ini bila terjadi kesalahan dalam penyajian data anda.
