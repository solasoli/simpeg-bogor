<?php 
$dbLast = mysqli_connect('localhost', 'root', '51mp36');
mysqli_select_db('simpeg_31des10', $dbLast);

$dbCurrent = mysqli_connect('localhost', 'simpeg_root', '51mp36');
mysqli_select_db("simpeg", $dbCurrent);
?>
<?php
	function countAllPegawai($connection){
		$q = mysqli_query($mysqli,"SELECT COUNT(*) FROM pegawai WHERE flag_pensiun = 0", $connection);
		$r = mysqli_fetch_array($q);
		$total = $r[0];
		return $total;
	}
	
	function countPegawaiByGolongan($golongan, $connection){
		$q = mysqli_query($mysqli,"SELECT COUNT(*) FROM pegawai WHERE flag_pensiun = 0 AND pangkat_gol LIKE '$golongan/%'", $connection);
		$r = mysqli_fetch_array($q);
		$total = $r[0];
		return $total;
	}
	
	function countAllPejabatStruktural($tahun, $connection){
		$q = "SELECT COUNT(*)
				FROM
				(
					SELECT j.* 
					FROM jabatan j 
					INNER JOIN sk s 
						ON s.id_j = j.id_j 
						WHERE j.tahun = '$tahun' AND s.id_kategori_sk = 10 
					GROUP BY j.id_j
				) as t";		

		$q = mysqli_query($mysqli,$q, $connection);
						
		$r = mysqli_fetch_array($q);
		$total = $r[0];
		return $total;
	}
	
	function countPejabatStruktural($eselon, $tahun, $connection){
		if($eselon != 'V')
		{
			$q = "SELECT COUNT(*)
					FROM
					(
						SELECT j.* 
						FROM jabatan j 
						INNER JOIN sk s 
							ON s.id_j = j.id_j 
							WHERE j.tahun = '$tahun' AND s.id_kategori_sk = 10
							 
											 
						GROUP BY j.id_j		
					) as j
					WHERE 							
						(j.eselon LIKE '".$eselon."A"."') OR
						(j.eselon LIKE '".$eselon."B"."')";									
		}
		else{
			$q = "SELECT COUNT(*)
					FROM
					(
						SELECT j.* 
						FROM jabatan j 
						INNER JOIN sk s 
							ON s.id_j = j.id_j 
							WHERE j.tahun = '$tahun' AND s.id_kategori_sk = 10 
								AND j.eselon LIKE 'V'
						GROUP BY j.id_j
					) as j";
								
		}
		
		$q = mysqli_query($mysqli,$q, $connection);
		$r = mysqli_fetch_array($q);
		$total = $r[0];
		return $total;
	}
	
	function countAllPejabatFungsional($connection){
		$q = mysqli_query($mysqli,"SELECT COUNT(*) 
						  FROM pegawai p
						  WHERE jenjab LIKE '%fungsional%'", $connection);
		$r = mysqli_fetch_array($q);
		$total = $r[0];
		return $total;
	}
	
	function countAllPensiunan($connection){
		$q = mysqli_query($mysqli,"SELECT COUNT(*) 
						  FROM pegawai p
						  WHERE DATE_FORMAT(DATE_ADD(DATE_ADD(tgl_lahir, INTERVAL 56 YEAR), INTERVAL 1 MONTH), '%Y') < 2010", $connection);
	
		$r = mysqli_fetch_array($q);
		$total = $r[0];
		return $total;
	}
	
	function countPensiunanByEselon($eselon, $connection){
		if($eselon != 'V')
		{
			$q = "SELECT COUNT(*) 
				  FROM pegawai p				  
				  WHERE DATE_FORMAT(DATE_ADD(DATE_ADD(tgl_lahir, INTERVAL 56 YEAR), INTERVAL 1 MONTH), '%Y') < 2010											
					AND (
						(p.eselonering LIKE '".$eselon."A"."') OR
						(p.eselonering LIKE '".$eselon."B"."') OR
						(p.eselonering LIKE '".$eselon."C"."')
					)";
		}
		else{
			$q = "SELECT COUNT(*) 
				  FROM pegawai p
				  WHERE DATE_FORMAT(DATE_ADD(DATE_ADD(tgl_lahir, INTERVAL 56 YEAR), INTERVAL 1 MONTH), '%Y') < 2010												
					AND p.eselonering LIKE 'V'";
		}
		$q = mysqli_query($mysqli,$q, $connection);
		$r = mysqli_fetch_array($q);
		$total = $r[0];
		return $total;
	}
?>


<table border="1" width="100%" style="border-collapse: collapse">
	<tr>
		<td align="center">No</td>
		<td align="center">Jenis Data</td>
		<td align="center">
			<!--<select name="tahun" id="cmbTahun">
				<option value="2010">2010</option>
			</select>-->
			2010
		</td align="center">
		<td align="center">Satuan</td>
	</tr>
	<tr>
		<td>1</td>
		<td>Jumlah PNS</td>
		<td align="right"><?php echo countAllPegawai($dbLast); ?></td>
		<td>orang</td>
	</tr>
	<tr>
		<td>2</td>
		<td>Golongan I</td>
		<td align="right"><?php echo countPegawaiByGolongan('I',$dbLast); ?></td>
		<td>orang</td>
	</tr>
	<tr>
		<td>3</td>
		<td>Golongan II</td>
		<td align="right"><?php echo countPegawaiByGolongan('II',$dbLast); ?></td>
		<td>orang</td>
	</tr>
	<tr>
		<td>4</td>
		<td>Golongan III</td>
		<td align="right"><?php echo countPegawaiByGolongan('III',$dbLast); ?></td>
		<td>orang</td>
	</tr>
	<tr>
		<td>5</td>
		<td>Golongan IV</td>
		<td align="right"><?php echo countPegawaiByGolongan('IV',$dbLast); ?></td>
		<td>orang</td>
	</tr>
	<tr>
		<td></td>
		<td></td>
		<td align="right"></td>
		<td></td>
	</tr>
	<tr>
		<td>6</td>
		<td>Jumlah Pejabat Struktural</td>
		<td align="right"><?php echo countAllPejabatStruktural(2010, $dbLast); ?></td>
		<td>orang</td>
	</tr>
	<tr>
		<td>7</td>
		<td>Eselon I</td>
		<td align="right"><?php echo countPejabatStruktural('I', 2010, $dbLast); ?></td>
		<td>orang</td>
	</tr>
	<tr>
		<td>8</td>
		<td>Eselon II</td>
		<td align="right"><?php echo countPejabatStruktural('II', 2010, $dbLast); ?></td>
		<td>orang</td>
	</tr>
	<tr>
		<td>9</td>
		<td>Eselon III</td>
		<td align="right"><?php echo countPejabatStruktural('III', 2010, $dbLast); ?></td>
		<td>orang</td>
	</tr>
	<tr>
		<td>10</td>
		<td>Eselon IV</td>
		<td align="right"><?php echo countPejabatStruktural('IV', 2010, $dbLast); ?></td>
		<td>orang</td>
	</tr>
	<tr>
		<td></td>
		<td></td>
		<td align="right"></td>
		<td></td>
	</tr>
	<tr>
		<td>11</td>
		<td>Jumlah Pejabat Fungsional</td>
		<td align="right"><?php echo countAllPejabatFungsional($dbLast); ?></td>
		<td>orang</td>
	</tr>
	<tr>
		<td>12</td>
		<td>Jumlah Pensiunan PNS</td>
		<td align="right"><?php echo countAllPensiunan($dbLast); ?></td>
		<td>orang</td>
	</tr>
	<tr>
		<td>13</td>
		<td>Eselon I</td>
		<td align="right"><?php echo countPensiunanByEselon('I',$dbLast); ?></td>
		<td>orang</td>
	</tr>
	<tr>
		<td>14</td>
		<td>Eselon II</td>
		<td align="right"><?php echo countPensiunanByEselon('II', $dbLast); ?></td>
		<td>orang</td>
	</tr>
	<tr>
		<td>15</td>
		<td>Eselon III</td>
		<td align="right"><?php echo countPensiunanByEselon('III',$dbLast); ?></td>
		<td>orang</td>
	</tr>
	<tr>
		<td>16</td>
		<td>Eselon IV</td>
		<td align="right"><?php echo countPensiunanByEselon('IV',$dbLast); ?></td>
		<td>orang</td>
	</tr>
	<tr>
		<td></td>
		<td><strong>PNS</strong></td>
		<td align="right"></td>
		<td></td>
	</tr>
	<tr>
		<td>17</td>
		<td>PNS Pusat</td>
		<td align="right"></td>
		<td>orang</td>
	</tr>
	<tr>
		<td>18</td>
		<td>PNS Daerah</td>
		<td align="right"><?php echo countAllPegawai($dbLast); ?></td>
		<td>orang</td>
	</tr>
</table>