<?php
$s=$_REQUEST['s'];
?>
		<div class="post">
			<h2 class="title"><a href="index2.php?x=search.php&&s=<?php echo($s); ?>">Kembali &nbsp; Ke&nbsp;  Pencarian</a></h2>
			<div class="entry">
				<?php
				$id=$_REQUEST['id'];
				
				$q2=mysqli_query($mysqli,"select * from pegawai where id_pegawai=$id ");
$data=mysqli_fetch_array($q2);
				$tgl=substr($data["tgl_lahir"],8,2);
				$bln=substr($data["tgl_lahir"],5,2);
				$thn=substr($data["tgl_lahir"],0,4);
				
				$pot=strpos($data["tempat_lahir"],',');
				$born=substr($data["tempat_lahir"],0,$pot);
				
				$k=mysqli_query($mysqli,"select nama_baru from riwayat_mutasi_kerja inner join pegawai on riwayat_mutasi_kerja.id_pegawai=pegawai.id_pegawai inner join unit_kerja on riwayat_mutasi_kerja.id_unit_kerja=unit_kerja.id_unit_kerja inner join sk on riwayat_mutasi_kerja.id_sk = sk.id_sk where riwayat_mutasi_kerja.id_pegawai=$data[0] order by tgl_sk desc");
				
				$unit=mysqli_fetch_array($k);
							
				if($data["nip_lama"]!='-')
				{$nip1=substr($data["nip_lama"],0,3);
				$nip2=substr($data["nip_lama"],3,3);
				$nip3=substr($data["nip_lama"],6,3);
				$nip="$nip1 $nip2 $nip3";
				}
				else
				$nip=$data["nip_baru"];
				//untuk struktural
				$bln2=substr($bln,0,1);
				if($data["id_pegawai"]<4379)
				{
				$tp=$thn+56;
				
				
				if($bln2!=0)
				{
				if($bln<12)
				$bp=$bln+1;
				else
				{$bp="01";
				$tp=$thn+57;
				
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
				<?
					if(file_exists("foto/$data[id_pegawai].jpg"))
					{
						echo "
							<div style='text-align:center;'>
								&nbsp;&nbsp;&nbsp;&nbsp;<img src='foto/$data[id_pegawai].jpg' width='150px' />
							</div>";
					}
				?>
				<table width="600" border="0" cellspacing="0" cellpadding="5">
				<tr bgcolor="#f0f0f0"><td>Nama</td><td>:</td><td><?php echo($data["nama"]); ?></td></tr>
				<tr ><td>Tempat Lahir</td><td>:</td><td><?php echo($data["tempat_lahir"]); ?></td></tr>
				<tr bgcolor="#f0f0f0"><td>Tanggal Lahir</td><td>:</td><td><?php echo("$tgl-$bln-$thn"); ?></td></tr>
				<tr ><td>NIP Lama</td><td>:</td><td><?php echo($data["nip_lama"]); ?></td></tr>
				<tr ><td>NIP Baru</td><td>:</td><td><?php echo($data["nip_baru"]); ?></td></tr>
				<tr bgcolor="#f0f0f0"><td>Unit Kerja</td><td>:</td><td><?php echo($unit[0]); ?></td>
				</tr>
				<tr nowrap="nowrap"><td >Jabatan</td><td>:</td><td><?php 
				
				$qjo=mysqli_query($mysqli,"select jabatan from jabatan where id_j=$data[id_j]");
				//echo("select jabatan from jabatan where id_j=$data[id_j]");
				$ahab=mysqli_fetch_array($qjo);
				
				echo($ahab[0]); ?></td></tr>
				<tr ><td>Pangkat Golongan</td><td>:</td><td><?php echo($data["pangkat_gol"]); ?></td></tr>
				<tr bgcolor="#f0f0f0"><td>Tanggal Pensiun</td><td>:</td><td><?php echo($tglp); ?></td>
				</tr>
				<tr ><td>Jenjang Jabatan</td><td>:</td><td><?php echo($data["jenjab"]); ?></td></tr>
				<tr  bgcolor="#f0f0f0"><td>Jenis Kelamin</td><td>:</td><td>
							<?php
								if($data["jenis_kelamin"] == "L")
									echo "Laki-laki";
								else
									echo "Perempuan";
							?>
					</td></tr>
				</table>
			</div>	
		</div>
		