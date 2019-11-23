
<?php
include "konek.php";
extract($_POST);
extract($_GET);

?>
<div class="well">
	<a class="btn btn-small" target="_blank" href="duk_print.php?id=<?php echo $_POST[id_unit_kerja]; ?>"><i class="icon-print"></i> Cetak</a>
	<a class="btn btn-small" target="_blank" href="eksporduk.php?id_unit_kerja=<?php echo $id_unit_kerja; ?>"><i class="icon-download-alt"></i> Download Ke Exel</a>
</div>
<?php


if($id_unit_kerja)
{
$result = $mysqli->query("CALL PRC_VIEW_DUK($id_unit_kerja)");
$i = 1;
if($result):?>
    
	<table border="1" class="table table-striped table-bordered">
		
	<thead class="thead-small">					
			<tr >
				<th rowspan="2">No Urut</th>
				<th rowspan="2">Nama</th>
				<th rowspan="2">NIP</th>
				<th colspan="2">Pangkat</th>
				<th colspan="2">Jabatan</th>
				<th colspan="2">Masa Kerja Keseluruhan</th>
				<th colspan="3">Latihan Jabatan</th>
				<th colspan="3">Pendidikan</th>
				<th rowspan="2">Tanggal Lahir</th>
				<th rowspan="2">Keterangan</th>
			</tr>
			<tr>
				<th>Gol Ruang</th>
				<th>TMT</th>
				
				<th>Nama</th>
				<th>TMT</th>
				
				<th>Tahun</th>
				<th>Bulan</th>
				
				<th>Nama</th>
				<th>Bulan dan Tahun</th>
				<th>Jumlah Jam</th>
				
				<th>Nama</th>
				<th>Lulus Tahun</th>
				<th>Tingkat Ijazah</th>
						
			</tr>
	</thead>
	<tbody>
    <?php while ($row = $result->fetch_array()): ?>
		<tr class="table-small">
			<td><?php echo $i++; ?></td>
			<td><?php echo $row[nama]; ?></td>
			<td style="min-width:140px"><?php echo substr($row[nip],0,8)." ".substr($row[nip],8,6)." ".substr($row[nip],14,1)." ".substr($row[nip],15,3);
			
			$nip=$row[nip];
			$qpaksa=mysql_query("select jenjab,jabatan,id_pegawai,id_j,pangkat_gol from pegawai where nip_lama='$nip' or nip_baru='$nip'");
			$paksa=mysql_fetch_array($qpaksa);
			$qsk=mysql_query("select * from sk where id_pegawai=$paksa[2] and id_kategori_sk=6");
			
			if($qsk){
				$cpns=mysql_fetch_array($qsk);
				$potong=explode(",",$cpns[7]);					
			}
			
			 ?></td>
			
			<td><?php echo $paksa[4]; ?></td>
			<td><?php 
			
			$qkp=mysql_query("select date_format(tmt, '%d-%m-%Y') from sk where id_pegawai=$paksa[2] and id_kategori_sk=5 and keterangan like '$row[golongan]%'");
			
			$kp=mysql_fetch_array($qkp);			
			
			/*$t1=substr($kp[0],0,4);
			$b1=substr($kp[0],5,2);
			$th1=substr($kp[0],8,2);
			*/
			
			
			if($kp){
				echo($kp[0]); 
			}
			else{
				$qpns = mysql_query("select date_format(tmt, '%d-%m-%Y') from sk where id_pegawai=$paksa[2] and (id_kategori_sk=6)  and keterangan like '$row[golongan]%' order by tmt desc");
				$pns = mysql_fetch_array($qpns);
				echo $pns[0];
			} 
			
			?></td>
			
			<td><?php //echo $row[jabatan]; 
			echo("$paksa[1]");
			?></td>
			<td><?php 	$qj=mysql_query("select tmt from sk where id_pegawai=$paksa[2] and id_kategori_sk=10 and id_j=$paksa[3]");
			
			if($qj){
				$kj=mysql_fetch_array($qj);
				$t2=substr($qj[0],0,4);
				$b2=substr($qj[0],5,2);
				$th2=substr($qj[0],8,2);
			}
			if($t2>0){
				echo("$t2-$b2-$th2"); 
			}
			else{
				$jabTahun = substr($row['tmt_jabatan'], 0,4);
				$jabBulan = substr($row['tmt_jabatan'], 5,2);
				$jabTanggal = substr($row['tmt_jabatan'], 8,2);
				echo "$jabTanggal-$jabBulan-$jabTahun";
				
			} ?></td>
			
			<td><?php 
			
			if(($potong[2]=="00" or $potong[2]=="0") and ($potong[1]=="00" or $potong[1]=="0") ) 
			{
				$tahunsk = substr($cpns[8],0,4);			
				$row[masa_kerja_seluruh_tahun] = 2013 - $tahunsk;
				echo (" $row[masa_kerja_seluruh_tahun] "); 
			}
			else
			{
				
				if(substr($potong[1],0,1)==0)
					$tahun = substr($potong[1],1,1);
				else
					$tahun = $potong[1]; 
											
				if(substr($potong[2],0,1)==0)
					$bulan = substr($potong[2],1,1);
				else
					$bulan = $potong[2]; 
									
				//echo "$row[masa_kerja_seluruh_bulan] + $bulan ";								
				$totalbulan = $row[masa_kerja_seluruh_bulan] + $bulan;								
				if($totalbulan < 12)
				{
					$bulankerja = $totalbulan;
					$tambahantahun = 0;
				}
				else
				{
					$bulankerja = $totalbulan % 12;
					$tambahantahun = floor($totalbulan/12);
				}							
				$tahunkerja = $row[masa_kerja_seluruh_tahun] + $tambahantahun + $tahun;
				echo("$tahunkerja");
			}
			?></td>
			<td><?php 
				if(($potong[2]=="00" or $potong[2]="0") and ($potong[1]=="00" or $potong[1]="0") ) 
				{				
					$bulansk=substr($cpns[8],5,2);
					if(substr($bulansk,0,1)==0)
						$bulansk=substr($bulansk,1,1);
					else
						$bulansk=$bulansk; 
					
					$row[masa_kerja_seluruh_bulan] = (12 - $bulansk) + 1;					
					echo $row[masa_kerja_seluruh_bulan]; 
				
				}
				else
					echo($bulankerja);
			
			?></td>
			
			<td><?php echo $row[diklat]; ?></td>
			<td><?php 
					$dTahun = substr($row[tanggal_diklat], 0, 4);
					$dBulan = substr($row[tanggal_diklat], 5, 2);
					$dTanggal = substr($row[tanggal_diklat], 8, 2);
					echo "$dTanggal-$dBulan-$dTahun" ?></td>
			<td><?php echo $row[jumlah_jam_diklat]; ?></td>
			
			<td><?php 
			$qpen=mysql_query("select * from pendidikan where id_pegawai=$paksa[2] order by level_p"); 
			$pen=mysql_fetch_array($qpen);
			echo $pen['jurusan_pendidikan']; ?></td>
			<td><?php echo $pen['tahun_lulus']; ?></td>
			<td>
				<?php 
					//if($pen['jenjang_pendidikan'])
						echo $pen['tingkat_pendidikan'];
					//else 
						//echo $row['jenjang_pendidikan'];					
				?>
			</td>
			
			<td><?php 				
				$ppTahun = substr($row[tgl_lahir], 0, 4);
				$ppBulan = substr($row[tgl_lahir], 5, 2);
				$ppTanggal = substr($row[tgl_lahir], 8, 2);
				echo "$ppTanggal-$ppBulan-$ppTahun"  ?></td>
			<td>&nbsp;</td>
		</tr>
	<?php endwhile; ?>
	</tbody>
	</table>

<?php endif; 
} else
{?>

<table border="1" class="table table-striped table-bordered">
	<thead class="thead-small">					
			<tr >
				<th rowspan="2">No Urut</th>
				<th rowspan="2">Nama</th>
				<th rowspan="2">NIP</th>
				<th colspan="2">Pangkat</th>
				<th colspan="2">Jabatan</th>
				<th colspan="2">Masa Kerja Keseluruhan</th>
				<th colspan="3">Latihan Jabatan</th>
				<th colspan="3">Pendidikan</th>
				<th rowspan="2">Tanggal Lahir</th>
				<th rowspan="2">Keterangan</th>
			</tr>
			<tr>
				<th>Gol Ruang</th>
				<th>TMT</th>
				
				<th>Nama</th>
				<th>TMT</th>
				
				<th>Tahun</th>
				<th>Bulan</th>
				
				<th>Nama</th>
				<th>Bulan dan Tahun</th>
				<th>Jumlah Jam</th>
				
				<th>Nama</th>
				<th>Lulus Tahun</th>
				<th>Tingkat Ijazah</th>
						
			</tr>
	</thead>
	<tbody>
		<?php for($x=0; $x<20; $x++): ?>
			<tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
		<?php endfor; ?>
	</tbody>
<?php 
}
?>
    
