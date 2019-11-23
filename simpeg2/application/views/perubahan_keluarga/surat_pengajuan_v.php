<?php
	date_default_timezone_set("Asia/Jakarta");
	ob_start();
?>
<div style="margin-top:200px;margin-left:60px;">
		<div style="margin-left:427px">Bogor, <u><?php echo $tgl_sp?> <?php echo $bln_sp;?> <?php echo $thn_sp?></u></div>
		<br/>
		<table>
			<tr>
				<td>Nomor</td>
				<td> :</td>
				<td></td>
				<td width="100"></td>
				<td><div style="margin-left:48px;">Kepada</div></td>
			</tr>
			<tr>
				<td>Sifat</td>
				<td> :</td>
				<td></td>
				<td width="100"></td>
				<td>Yth. <div style="margin-left:25px;">Kepala Badan Kepegawaian</div></td>
			</tr>
			<tr>
				<td>Lampiran</td>
				<td> :</td>
				<td></td>
				<td width="100"></td>
				<td><div style="margin-left:48px;">Pendidikan dan Pelatihan Kota Bogor</div></td>
			</tr>
			<tr>
				<td>Perihal</td>
				<td> :</td>
				<td><b>Pengajuan Perubahan Keluarga</b></td>
				<td width="100"></td>
				<td><div style="margin-left:48px;">Di -</div></td>
			</tr>
			<tr>
				<td></td>
				<td></td>
				<td><u><b>Jiwa Dalam Tunjangan Keluarga</b></u></td>
				<td width="100"></td>
				<td><div style="margin-left:85px;">B O G O R</div></td>
			</tr>
		</table>
	
		<div style="margin-left:45px;">
			<p>Dengan ini kami diberitahukan bahwa Pegawai Negeri Sipil yang namanya tersebut di bawah ini :
			</p>
			<div style="margin-left:30px;">
				<table>
					<tr>
						<td>Nama</td>
						<td>:</td>
						<td><?php echo $data_pegawai->nama;?></td>
					</tr>
					<tr>
						<td>NIP</td>
						<td>:</td>
						<td><?php echo $data_pegawai->nip_baru;?></td>
					</tr>
					<tr>
						<td>Pangkat/Gol</td>
						<td>:</td>
						<td><?php echo $data_pegawai->pangkat_gol;?></td>
					</tr>
					<tr>
						<td>Jabatan</td>
						<td>:</td>
						<td><?php echo $data_pegawai->jabatan;?></td>
					</tr>
					<tr>
						<td>Unit Kerja</td>
						<td>:</td>
						<td><?php echo $unit_kerja->nama_baru;?></td>
					</tr>
				</table>
			</div>
			<?php 
					$tj = $this->uri->segment(4);
					if($tj == 1)
					{
			?>
					<p>Telah diadakan perubahan keluarga dengan jenis penambahan jiwa :<br/>
					</p>
			<?php
					}
					else if($tj == 0)
					{
			?>
					<p>Telah diadakan perubahan keluarga dengan jenis Pengurangan jiwa :<br/>
					</p>
			<?php 
					}
					$i = 1;
				foreach($kel->result() as $r)
			    {
			?>
			<table>
				<tr>
					<td><?php echo $i++;?>. </td>
					<td width="200">Nama</td>
					<td>:</td>
					<td><b><?php echo $r->nama;?></b></td>
				</tr>
				<tr>
					<td></td>
					<td width="200">Tempat Tanggal Lahir</td>
					<td>:</td>
					<td><?php echo $r->tempat_lahir;?>, <?php echo $r->tgl_lahir?></td>
				</tr>
			</table>
			<?php
				}
			?>
			<br/><br/>
			Sehingga Menjadi :
			<div style="margin-left:100px;">
			<table>
						<tr>
							<td></td>
							<td>
										1
							</td>
							<td>
										Orang Pegawai
							</td>
							<td width="500px"> &nbsp;</td>
							<td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
							<td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
							<td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
							<td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
							<td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
							<td></td><td></td><td></td><td></td><td></td><td></td>
						</tr>
				<tr>
					<td></td>
					<td><?php echo $jum_si?></td>
					<td>Orang Istri/Suami</td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
				<tr>
					<td></td>
					<td><?php echo $jum_ak?></td>
					<td>Orang Anak</td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
				<tr>
					<td colspan="50" ><hr /></td>
				</tr>
				
				<tr>
					<td>Jumlah</td>
					<td>
					</td>
					<td>Orang</td>
					<td width="250px"></td>
					<td></td>
				</tr>
			</table>
			</div>
			<br/><p>Demikian untuk ditindak lanjuti, atas perkenannya kami ucapkan terima kasih.</p>
			<div>
				<p align="center">
					a.n <b>CAMAT BOGOR UTARA</b><br/>
					Sekertaris,
					<br/><br/><br/><br/>
					<b><u>DANNY SUHENDAR, SH</u></b><br/>
					Pembina<BR/>
					NIP.19678877765
				</p>
			</div>
		</div>
	</div>