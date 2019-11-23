<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<nav class="breadcrumbs small">
    <ul>
        <li><a href="<?php echo base_url() ?>">Home</a></li>
        <li><a href="<?php echo base_url('unit_kerja/daftar') ?>">Daftar Unit Kerja</a></li>
        <li class="active"><a href="#">Daftar Pegawai <?php echo $nama_opd ?></a></li>
    </ul>
</nav>
<div class="grid fluid">
	<div class="row">
		
		<div class="span12">
			<h1>Daftar Pegawai <br><small><?php echo $nama_opd ?></small></h1>
			<table class="table bordered hovered striped" id="daftar_pegawai">
				<thead>
					<tr>
						<th>No</th>	
						<th>Jabatan</th>	
                        <th>Fungsi</th>			
						<th>Nama Pejabat</th>
						<th>NIP</th>
						<th>Pendidikan</th>
						
						<th>Pelatihan</th>
                        <th>Pengalaman</th>
                        <th>Adminsitrasi</th>
                        <th>*Penilaian Objektif</th>
					</tr>
				</thead>
				<tbody>
					
					<?php $x=1;foreach($list as $peg) {?>
					<?php 
					if($peg->id_pegawai!=NULL)
					{
						$pegawai = $this->pegawai->get_by_id($peg->id_pegawai);
						if(!$pegawai){
							//$pegawai->id_pegawai = $peg->id_pegawai;
							$pegawai->nama_lengkap ="DATA ERROR";
							$pegawai->nip_baru = "DATA ERROR";
							$pegawai->pangkat = "DATA ERROR";
							
						}
					}
					
					?>
                 
					<tr>
						<td>
						
						 <form class="form-inline" action="<?php echo site_url('ipasn/save') ?>" name="form<?php echo $x; ?>" id="form<?php echo $x; ?>" method="post" enctype="multipart/form-data">
						   <a name="a<?php echo ($x-1); ?>" id="a<?php echo ($x-1); ?>"></a>	
                           
                            <input type="hidden" name="no" id="no" value="<?php echo $x; ?>" />
                           					<?php echo $x++ ?></td>	
						<td><?php echo $peg->jabatan; ?>
						  <input type="hidden" name="jabatan" id="jabatan" value="<?php echo $peg->jabatan; ?>" />
						  <input type="hidden" name="skpd" id="skpd" value="<?php echo $id_skpd; ?>" />
                          
                         
                          </td>		
                        	<td><?php $fung = $this->pegawai->get_tupoksi_by_idj($peg->id_j);
							echo("<ul>");
							$ltupoksi="";
							foreach($fung as $tusi)
							{
							echo ("<li> $tusi->tugas </li>");
							$ltupoksi=$ltupoksi."<li> $tusi->tugas </li>";
							}
							echo("</ul>");
							 ?> 
                             
                                 <input type="hidden" name="tupoksi" id="tupoksi" value="<?php echo $ltupoksi; ?>" />                             </td>
						<td>
						
						<?php if($peg->id_pegawai!=NULL)
					{echo $pegawai->nama_lengkap; } 
					
					
					?>
                      <input type="hidden" name="nama" id="nama" value="<?php echo $pegawai->nama_lengkap; ?>" />                    </td>
						<td><?php if($peg->id_pegawai!=NULL)
					{echo $pegawai->nip_baru; } ?>
                    
                          <input type="hidden" name="nip" id="nip" value="<?php echo $pegawai->nip_baru; ?>" />                    </td>
						<td>
						<?php $cekin=$this->jabatan_model->get_ipasn($peg->id_j);
						
								?>
					      <input type="radio" class="form-control" <?php if($cekin) {if($cekin->flag_pendidikan==0) echo " checked=checked "; } ?> name="pendidikan"   value="0" id="pendidikan" />                          
                          Sesuai
                       <br />
                       <input type="radio" class="form-control" name="pendidikan" <?php if($cekin) { if($cekin->flag_pendidikan==1) echo " checked=checked "; } ?> value="1" id="pendidikan" /> Tidak Sesuai
						<?php if($peg->id_pegawai!=NULL)
					{
					$pend = $this->pegawai->get_pendidikan($peg->id_pegawai);
							echo("<ul>");
							$lpendidikan="";
							foreach($pend as $dikan)
							{
							echo ("<li> $dikan->tingkat_pendidikan $dikan->jurusan_pendidikan </li>");
							$lpendidikan=$lpendidikan."<li> $dikan->tingkat_pendidikan $dikan->jurusan_pendidikan </li>";
							}
							echo("</ul>");
					
					 } ?>
                    
                     
                       
                       <input type="hidden" name="lpendidikan" id="lpendidikan" value="<?php echo $lpendidikan; ?>" />                     </td>
						
						<td>
                          <input type="radio" class="form-control" <?php if($cekin) { if($cekin->flag_pelatihan==0) echo " checked=checked "; }?> name="pelatihan" value="0" id="pelatihan" /> Sesuai
                       <br />
                       <input type="radio" class="form-control" <?php if($cekin) { if($cekin->flag_pelatihan==1) echo " checked=checked "; }?> name="pelatihan" value="1" id="pelatihan" /> Tidak Sesuai		
						
						<?php if($peg->id_pegawai!=NULL)
					{
					$dik = $this->pegawai->get_diklat_list($peg->id_pegawai);
							echo("<ul>");
							$lpelatihan="";
							foreach($dik as $lat)
							{
							echo ("<li> $lat->nama_diklat </li>");
							$lpelatihan=$lpelatihan."<li> $lat->nama_diklat </li>";
							}
							echo("</ul>");
					
					 } ?>                  
                       <input type="hidden" name="lpelatihan" id="lpelatihan" value="<?php echo $lpelatihan; ?>" />   
                       				</td>
                        	<td>
                          
                              <input type="radio" class="form-control" <?php if($cekin) { if($cekin->flag_pengalaman==0) echo " checked=checked "; } ?> name="pengalaman" value="0" id="pengalaman" /> Sesuai
                       <br />
                       <input type="radio" class="form-control" <?php if($cekin) { if($cekin->flag_pengalaman==1) echo " checked=checked "; }?> name="pengalaman" value="1" id="pengalaman" /> Tidak Sesuai				
						
						<?php if($peg->id_pegawai!=NULL)
					{
					$peng = $this->pegawai->get_jab($peg->id_pegawai);
							echo("<ul>");
							$ljabatan="";
							foreach($peng as $jab)
							{
							echo ("<li> $jab->jabatan </li>");
							$ljabatan=$ljabatan."<li> $jab->jabatan </li>";
							}
							echo("</ul>");
					
					 } ?>                       <input type="hidden" name="lpengalaman" id="lpengalaman" value="<?php echo $ljabatan; ?>" />   		</td>
                        	<td>
						 <input type="radio" class="form-control" <?php if($cekin) { if($cekin->flag_administrasi==0) echo " checked=checked "; }?> name="administrasi" value="0" id="administrasi" /> Sesuai
                       <br />
                       <input type="radio" class="form-control"  <?php if($cekin) { if($cekin->flag_administrasi==1) echo " checked=checked "; }?> name="administrasi" value="1" id="administrasi" /> Tidak Sesuai			
						<?php if($peg->id_pegawai!=NULL)
					{
					$dik2 = $this->pegawai->get_pim($peg->id_pegawai);
							echo("<ul>");
							$ladministrasi="";
							foreach($dik2 as $lat2)
							{
							echo ("<li> $lat2->nama_diklat </li>");
							$ladministrasi=$ladministrasi."<li> $lat2->nama_diklat </li>";
							}
							echo("</ul>");
					
					 } ?>               	
                     
                         <input type="hidden" name="ladministrasi" id="ladministrasi" value="<?php echo $ladministrasi; ?>" />   	
                   		   </td>
                        <td>
                          
                    <input class="form-control" type="hidden" name="idj" id="idj" value="<?php echo $peg->id_j; ?>" />
                    
                    <?php if($cekin) { echo ("$cekin->skor <br>"); } ?>
                        <input type="submit" class="form-control" value="Simpan" />
                          </form>
                        </td>
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
