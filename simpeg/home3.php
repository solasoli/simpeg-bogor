<?php  
require_once('class/pegawai.php');
$s=$_REQUEST['s'];
?>
		<div class="post">
			<h2 class="title"><a href="index3.php?x=search.php&&s=<?php echo($s); ?>" class="btn btn-primary hidden-print">Kembali Ke Pencarian</a></h2>
			<div class="entry">
				<?php
				$id=$_REQUEST['id'];
				
				
				$obj_pegawai = new Pegawai;
				$pegawai = $obj_pegawai->get_obj($id);
				
				
				$q2=mysqli_query($mysqli,"select * from pegawai where id_pegawai=$id ");
$data=mysqli_fetch_array($q2);



				$t1=substr($data["tgl_pensiun_dini"],8,2);
				$b1=substr($data["tgl_pensiun_dini"],5,2);
				$th1=substr($data["tgl_pensiun_dini"],0,4);


				$tgl=substr($data["tgl_lahir"],8,2);
				$bln=substr($data["tgl_lahir"],5,2);
				$thn=substr($data["tgl_lahir"],0,4);
				
				$pot=strpos($data["tempat_lahir"],',');
				$born=substr($data["tempat_lahir"],0,$pot);
				
				$k=mysqli_query($mysqli,"select nama_baru from riwayat_mutasi_kerja inner join unit_kerja on riwayat_mutasi_kerja.id_unit_kerja=unit_kerja.id_unit_kerja where riwayat_mutasi_kerja.id_pegawai=$data[0] order by id_riwayat desc");
//				echo("select nama_baru from riwayat_mutasi_kerja inner join unit_kerja on riwayat_mutasi_kerja.id_unit_kerja=unit_kerja.id_unit_kerja where riwayat_mutasi_kerja.id_pegawai=$data[0] order by tgl_sk desc");
				
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
				<?php
					if(file_exists("foto/$data[id_pegawai].jpg"))
					{
						echo "
							<div style='text-align:center;'>
								&nbsp;&nbsp;&nbsp;&nbsp;<img src='foto/$data[id_pegawai].jpg' width='150px' />
							</div>";
					}
				?>
				
				<?php
				// Algoritma Tahun Pensiun BY CUNDA DWI SESPANDANA
				// Berdasarkan tahun lahir dari NIP_baru jika ada, atau dari Tgl Lahi jika tidak ada NIP BARU
				
				// JIKA Punya NIP BARU
				$thn_lahir = $bln_lahir = 0;
				if(strlen($data['nip_baru']) > 10 )
				{
					$thn_lahir = substr($data['nip_baru'],0,4);
					$bln_lahir = substr($data['nip_baru'], 4, 2);
				}
				else
				{
					$thn_lahir = substr($data['tgl_lahir'], 0, 4);
					$bln_lahir = substr($data['nip_baru'], 5, 2);
				}
				
				
				
				
				// priksa jenjab. Bedakan antara fungsional dan struktural.
				// UNTUK STRUKTURAL
				if($data['jenjab'] == "Struktural")
				{
					$tglp = $thn_lahir + 58;
				}
				else // UNTUK SELAIN STRUKTURAL - (fungsioanl dll)
				{
					$tglp = @$tgn_lahir + 60;
				}
				
				$bln_lahir++;
				$tglp = "01-$bln_lahir-$tglp";
				
				$nama_full = $data['gelar_depan'] ? $data['gelar_depan'].' '.$data['nama'] : $data['nama'];
				$nama_full .= $data['gelar_belakang'] ? ', '.$data['gelar_belakang'] : '' ;
			
				
				?>
				<table width="600" border="0" cellspacing="0" cellpadding="5" class='table'>
				<tr bgcolor="#f0f0f0">
					<td>Nama</td>
					<td>:</td>
					<td><?php echo($nama_full); ?></td>
				</tr>
				<tr ><td>Tempat Lahir</td><td>:</td><td><?php echo($data["tempat_lahir"]); ?></td></tr>
				<tr bgcolor="#f0f0f0"><td>Tanggal Lahir</td><td>:</td><td><?php echo("$tgl-$bln-$thn"); ?></td></tr>
				<tr ><td>NIP Lama</td><td>:</td><td><?php echo($data["nip_lama"]); ?></td></tr>
				<tr ><td>NIP Baru</td><td>:</td><td><?php echo($data["nip_baru"]); ?></td></tr>
				<tr bgcolor="#f0f0f0"><td>Unit Kerja</td><td>:</td><td><?php echo($unit[0]); ?></td>
				</tr>
				<tr nowrap="nowrap"><td >Jabatan</td><td>:</td><td><?php 
				//$qd=mysqli_query($mysqli,"select id_j from sk where  id_pegawai=$data[0] and id_kategori_sk=10 order by tmt desc");
				$qd=mysqli_query($mysqli,"select id_j, jenjab, jabatan from pegawai where  id_pegawai=$data[0]");
				$dwo=mysqli_fetch_array($qd);
				
				if($dwo[0] !=NULL && $dwo['jenjab'] == 'Struktural')
				{ 
					$qjo=mysqli_query($mysqli,"select jabatan from jabatan where id_j=$dwo[0]");
					//echo("select jabatan from jabatan where id_j=$data[id_j]");
					$ahab=mysqli_fetch_array($qjo)[0];
				}elseif($dwo['id_j'] == NULL && $dwo[1] == 'Fungsional'){
					
					$ahab = $dwo['jabatan'];
								
				}else{
					$sql = "select jfu_pegawai.*, jfu_master.* 
							from jfu_pegawai, jfu_master
							where jfu_pegawai.id_pegawai = '".$data['id_pegawai']."'
							and jfu_master.kode_jabatan = jfu_pegawai.kode_jabatan";
					
					$qjo=mysqli_query($mysqli,$sql);
					//echo("select jabatan from jabatan where id_j=$data[id_j]");
					$ahab=mysqli_fetch_array($qjo)['nama_jfu'];
				
				}
				echo($ahab); ?></td></tr>
				<tr ><td>Pangkat Golongan</td><td>:</td>
					<td><?php echo $pegawai->pangkat.", ".$pegawai->golongan ?></td>
				</tr>
				<tr bgcolor="#f0f0f0"><td>Tanggal Pensiun</td><td>:</td><td><?php echo("$t1-$b1-$th1"); ?></td>
				</tr>
				<tr ><td>Jenjang Jabatan</td><td>:</td><td><?php echo($data["jenjab"]); ?></td></tr>
				<tr  bgcolor="#f0f0f0"><td>Jenis Kelamin</td><td>:</td><td>
							<?php
								if($data["jenis_kelamin"] == 1)
									echo "Laki-laki";
								else
									echo "Perempuan";
							?>
					</td></tr>
                    <?php
					
						if($dwo[0]!=NULL)
						{
							
							$qw=mysqli_query($mysqli,"select jabatan,tmt from sk inner join jabatan on jabatan.id_j=sk.id_j where id_kategori_sk=10 and sk.id_pegawai=$data[0] order by tmt desc ");
							
							//echo("select jabatan,tmt from sk inner join jabatan on jabatan.id_j=sk.id_j where id_kategori_sk=10 and id_pegawai=$data[0] order by tmt desc ");
							echo("<tr>
								<td> Riwayat Jabatan </td>
								<td>: </td>
								<td></td>
								</tr>");
							while($tar=mysqli_fetch_array($qw))
							{
								echo("
								
								<tr>
								<td> </td>
								<td> </td>
								<td nowrap> $tar[0] tmt : $tar[1]</td>
								</tr>
								");


							}
						}
					?>
				</table>
			</div>	
		</div>
		
