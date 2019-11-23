<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

<div class="grid fluid">
	<div class="row">
		
		<div class="span12">
			<h1>Daftar Kenaikan Pangkat <?php $bul=date("m");
$taon=date("Y");
if($bul<10)	
$lan=substr($bul,1,1);
else
$lan=$bul;
if($lan>4 and $lan<=10)
$periode="$taon-10-01";
else
{
if($lan>10)
$taon++;	
$periode="$taon-04-01";
} echo $periode; ?>  </h1>
			<table class="table bordered hovered striped" id="daftar_pegawai">
				<thead>
					<tr>
						<th>No</th>	
						<th>Nama</th>
						<th>NIP</th>
						<th>Gol</th>
                        <th>Periode</th>
						<th>Aksi</th>
						<th>Status</th>
					</tr>
				</thead>
				<tbody>
					
					<?php $x=1;foreach($list as $pegawai) {?>
					<?php 
						/*$pegawai = $this->pegawai->get_by_id($peg->id_pegawai);
						if(!$pegawai){
							//$pegawai->id_pegawai = $peg->id_pegawai;
							$pegawai->nama_lengkap ="DATA ERROR";
							$pegawai->nip_baru = "DATA ERROR";
							$pegawai->pangkat = "DATA ERROR";
							
						}*/
										
					?>
					<tr>
						<td><?php echo $x++; ?></td>	
						
						<td><?php echo $pegawai->nama; ?></td>
						<td><?php echo "'".$pegawai->nip_baru; ?></td>
						<td><?php echo $pegawai->pangkat_gol; ?></td>
                        <td><?php echo $pegawai->periode; ?></td>
						<td nowrap="nowrap">
                        <form id="form<?php echo $pegawai->id_kp_draft; ?>" name="form<?php echo $pegawai->id_kp_draft; ?>" method="post" action="<?php echo base_url('unit_kerja/simpan_kp') ?>" >
                        <input type="hidden" name="idp" id="idp" value="<?php echo $pegawai->id_kp_draft; ?>" />
   <input type="radio" name="radio" id="radio" value="1" />
 Proses
 <input type="radio" name="radio" id="radio" value="2" />
  BTL
 <input type="radio" name="radio" id="radio" value="3" />
  TMS
  <input type="radio" name="radio" id="radio" value="4" />
  Selesai
  <input type="Submit" value="Simpan" />
</form>

                        
                        </td>
						<td><?php  if(@$pegawai->setatus!=NULL)
						echo @$pegawai->setatus; ?></td>
						
					</tr>						
					<?php } ?>
				</tbody>
			</table>
		</div>
	</div>
</div>
<script>
	$(function(){
			$('#daftar_pegawai').dataTable();
		});
</script>

<!-- End of file daftar_pegawai.php -->
<!-- Location ./application/views/daftar_pegawai.php -->
