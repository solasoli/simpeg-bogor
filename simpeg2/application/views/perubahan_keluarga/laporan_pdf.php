<?php
	date_default_timezone_set("Asia/Jakarta");
	ob_start();
?>
<div style="margin-left:50px;margin-top:50px;margin-right:20px;">
<h2 align="center">Rekapitulasi Perubahan Keluarga Bulan
	<?php 
		$bulan = $this->uri->segment(3);
		
		switch($bulan)
		{
			case 1: echo "Januari";
					break;
			case 2: echo "Februari";
				    break;
			case 3: echo "Maret";
					break;
			case 4: echo "April";
					break;
			case 5: echo "Mei";
					break;
			case 6: echo "Juni";
					break;
			case 7: echo "Juli";
					break;
			case 8: echo "Agustus";
					break;
			case 9: echo "September";
					break;
			case 10: echo "Oktober";
					break;
			case 11: echo "November";
					break;
			case 12: echo "Desember";
					break;
		}
	?>
	
	<?php echo $this->uri->segment(4);?>
</h2>
<br/><br/>
<table border="1">
			<tr>
				<th rowspan="2"><p align="center">No</p></th>
				<th rowspan="2"><p align="center">Nama/NIP</p></th>
				<th rowspan="2">GOL/<br/>RUANG</th>
				<th rowspan="2"><p align="center">Unit Kerja</p></th>
				<th colspan="4" align="center">Pengurangan</th>
				<th colspan="4" align="center">Penambahan</th>
				<th rowspan="2">Keterangan <br/>Menjadi</th>
			</tr>
			<tr>
				<td colspan="2" align="center">SUAMI/ISTRI</td>
				<td colspan="2" align="center">Anak</td>
				<td colspan="2" align="center">SUAMI/ISTRI</td>
				<td colspan="2" align="center">Anak</td>
			</tr>
			<?php 
				$i = 1;
				$indek_ak_t 	= 0;
				$indek_si_t 	= 0;
				$indek_ak_k		= 0;
				$indek_si_k 	= 0;
				$indek_jk_si_t 	= 0;
				if($data_pegawai->num_rows() > 0)
				{
					foreach($data_pegawai->result() as $r)
					{
			?>
			<tr>
				<td><?php echo $i++; ?></td>
				<td> <?php echo $r->nama?>/ <?php echo $r->nip_baru?>
				</td>
				<td><?php echo $r->pangkat_gol ;?></td>
				<td width="300px;"><?php echo $r->nama_baru?></td>
				<td><?php echo $data_kurang_suami_istri[$indek_si_k++]?></td>
				<td>SUAMI/ISTRI</td>
				<td><?php echo $data_kurang_anak[$indek_ak_k++]?></td>
				<td>Anak</td>
				<td><?php echo $data_tambah_suami_istri[$indek_si_t++];?></td>
				<td>SUAMI/ISTRI</td>
				<td><?php echo $data_tambah_anak[$indek_ak_t++]?></td>
				<td>Anak</td>
				<td></td>
			</tr>
			<?php 
				}
			}
			?>
	</table>
	
</div>