<?php
$qcuti=mysqli_query($mysqli,"select nama,nip_baru,deskripsi,tmt_awal,tmt_selesai,berkas,id_unit_kerja from cuti_pegawai inner join pegawai on pegawai.id_pegawai=cuti_pegawai.id_pegawai inner join current_lokasi_kerja on current_lokasi_kerja.id_pegawai = pegawai.id_pegawai inner join cuti_jenis on cuti_jenis.id_jenis_cuti=cuti_pegawai.id_jenis_cuti left join berkas on berkas.id_berkas=cuti_pegawai.berkas where id_unit_kerja=$_SESSION[id_unit] and jml_tmpt=2 group by pegawai.id_pegawai");

 
  ?>
<table width="98%" border="0" cellspacing="0" class="table table-bordered">
<thead>
  <tr >
    <th width="9%" rowspan="2" valign="top" style="text-align:center; vertical-align:top;">No</th>
    <th width="9%" rowspan="2" style="text-align:center; vertical-align:top;">NIP</th>
    <th width="4%" rowspan="2" style="text-align:center; vertical-align:top;">Nama</th>
    <th width="4%" rowspan="2" style="text-align:center; vertical-align:top;">Jenis Cuti</th>
    <th colspan="2" style="text-align:center; vertical-align:top;">Masa Cuti</th>
    <th width="19%" rowspan="2" style="text-align:center; vertical-align:top;">Berkas</th>
    <th width="22%" rowspan="2" style="text-align:center; vertical-align:top;">Validasi</th>
	 <th width="22%" rowspan="2" style="text-align:center; vertical-align:top;">Tolak</th>
  </tr>

 
  <tr>
    <th width="14%" style="text-align:center; vertical-align:top;">Awal</th>
    <th width="19%" style="text-align:center; vertical-align:top;">Selesai</th>
  </tr>
   </thead>
   <tbody>
  <?php
  $i=1;
   while($ata=mysqli_fetch_array($qcuti))
  {
	  
	  ?>
  <tr>
    <td align="center" nowrap="nowrap"><?php
    echo ($i);
	
	?></td>
    <td align="center" nowrap="nowrap"><?php echo ($ata[1]); ?></td>
    <td align="center" nowrap="nowrap"><?php  echo ($ata[0]); ?></td>
    <td align="center" nowrap="nowrap"><?php echo ($ata[2]);  ?></td>
    <td align="center" nowrap="nowrap"><?php echo ($ata[3]);  ?></td>
    <td align="center" nowrap="nowrap"><?php echo ($ata[4]); ?></td>
    <td align="center" nowrap="nowrap"> <button type="button" class="btn btn-primary">Ungggah</button> </td>
    <td align="center" nowrap="nowrap"> <button type="button" class="btn btn-primary">Unduh</button></td>
	 <td align="center" nowrap="nowrap"> <button type="button" class="btn btn-primary">Tolak</button></td>
  </tr>
  <?php
  
  $i++;
  }
  ?>
  </tbody>
</table>

