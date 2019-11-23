<style>
body{
  font-family: arial;
}

td{
  padding: 2px 2px 2px 2px; 
}

.grid{
border-collapse: collapse;
}

h1{
font-size: 14pt;
text-align: center;
}

.content{
  width: 800px;
  margin: auto;
}

.numeric{
  text-align: right;
}
</style>
<?php
include_once "konek.php";
?>

<div class="content">
	<form action="hasil_update.php" method="GET" name="form2">
<h1>HASIL UPDATE DATABASE SIMPEG<BR/>
    BULAN     
	<select name="bulan" >
		<option value="01" <?php if($_GET[bulan] == '01') echo 'selected'; ?>>Januari</option>
		<option value="02" <?php if($_GET[bulan] == '02') echo 'selected'; ?>>Februari</option>
		<option value="03" <?php if($_GET[bulan] == '03') echo 'selected'; ?>>Maret</option>
		<option value="04" <?php if($_GET[bulan] == '04') echo 'selected'; ?>>April</option>
		<option value="05" <?php if($_GET[bulan] == '05') echo 'selected'; ?>>Mei</option>
		<option value="06" <?php if($_GET[bulan] == '06') echo 'selected'; ?>>Juni</option>
		<option value="07" <?php if($_GET[bulan] == '07') echo 'selected'; ?>>Juli</option>
		<option value="08" <?php if($_GET[bulan] == '08') echo 'selected'; ?>>Agustus</option>
		<option value="09" <?php if($_GET[bulan] == '09') echo 'selected'; ?>>September</option>
		<option value="10" <?php if($_GET[bulan] == '10') echo 'selected'; ?>>Oktober</option>
		<option value="11" <?php if($_GET[bulan] == '11') echo 'selected'; ?>>November</option>
		<option value="12" <?php if($_GET[bulan] == '12') echo 'selected'; ?>>Desember</option>
	</select> TAHUN 
	<select name="tahun">
		<?php for($i=date('Y'); $i >= date('Y')-1; $i--): ?>
		<option value="<?php echo  $i; ?>"><?php echo $i; ?></option>
		<?php endfor; ?>
	</select>
	<input type="submit" value="submit" />
	</form>
</h1>
<?php
if(isset($_GET[bulan]))
{

$q = "SELECT u.nama_baru AS 'SKPD', COUNT(*) as 'JUMLAH'
      FROM current_lokasi_kerja c      
      INNER JOIN unit_kerja u ON u.id_unit_kerja = c.id_unit_kerja
	  INNER JOIN berkas b ON b.id_pegawai = c.id_pegawai
      WHERE LEFT(b.created_date, 7) = CONCAT('$_GET[tahun]','-','$_GET[bulan]')      
      GROUP BY u.nama_baru
      ORDER BY u.nama_baru";
	  
$q = mysqli_query($mysqli,$q);
$i = 1;
$total = 0;
?>
<table border=1 class="grid">
<tr>
  <th>No</th>
  <th>SKPD</th>
  <th class="numeric">Jumlah</th>
</tr>
<?php while($r = mysqli_fetch_array($q)): ?>
<tr>
  <td class="numeric"><?php echo $i?></td>
  <td><?php echo $r[SKPD]; ?></td>
  <td class="numeric"><?php echo $r[JUMLAH]; ?></td>
</tr>
<?php 
  $total += $r[JUMLAH];
  $i++; 
?>
<?php endwhile; ?>
<tr>
  <th colspan="2">JUMLAH</th>  
  <td class="numeric"><?php echo $total; ?></th>    
</tr>
</table>
<?php
}
?>
</div>