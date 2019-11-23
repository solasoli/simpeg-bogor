

<?php if($this->session->flashdata('k')): ?>
	<div  class="bg-red padding10 text-center">
		<strong><?php echo $this->session->flashdata('k') ; ?></strong>
	</div>

	<?php endif; ?>

<div class="container fluid">


	<?php // echo form_close(); ?>

	<div class="container fluid" id="div_inbox">
	<table class="table bordered hovered" id="table_inbox">
		<thead>
			<tr>
				<th>No</th>
				<th>Pengolah</th>
				<th>Kategori Berkas</th>
				<th width="20%" >Dokumen</th>
			<tr>
		</thead>
		<tbody>
			<?php $x=1; foreach($inbox as $inb): ?>
			<tr>
				<td height="10px"><?php echo $x++; ?></td>
				<td><?php echo $this->pegawai->get_by_id($inb->idp_pengolah)->nama_lengkap ?></td>
				<td><?php echo $inb->id_kat_berkas ?></td>
				<td rowspan="2"><object data="<?php echo "../simpeg/Berkas_dev/".$inb->filename; ?>" type="application/pdf" width="200" height="300">
					alt : <a href="<?php echo "../simpeg/Berkas_dev/".$inb->filename; ?>"><?php echo $inb->filename ?></a>
				</object>
				<br/>
				<a href="<?php echo "../simpeg/Berkas_dev/".$inb->filename; ?>" target="_blank">Buka di Tab Baru</a>
				</td>
			</tr>
			<tr>
					<td colspan="3">
						<label>Uraian :</label>
						<div><?php echo $inb->uraian ?></div>
						<label><strong>di Paraf oleh :</strong></label>
						<div class="form">
							<?php if($inb->idj_pemaraf1): ?>
							<div class="input-control checkbox">
							    <label>
							        <input type="checkbox" <?php echo $inb->idp_pemaraf1 ? "checked" : "" ?> disabled/>
							        <span class="check"></span>
							        <?php echo 	$this->jabatan->get_jabatan($inb->idj_pemaraf1)->jabatan ?><br/>
											(<?php echo $inb->idp_pemaraf1 ? $this->pegawai->get_by_id($inb->idp_pemaraf1)->nama_lengkap : "UNSIGNED" ?>)
							    </label>
							</div>
						<?php endif ?>

						<?php if($inb->idj_pemaraf2): ?>
						<div class="input-control checkbox">
								<label>
										<input type="checkbox" <?php echo $inb->idp_pemaraf2  ? "checked" : "" ?> disabled/>
										<span class="check"></span>
										<?php echo 	$this->jabatan->get_jabatan($inb->idj_pemaraf2)->jabatan ?><br/>
										(<?php echo $inb->idp_pemaraf2 ? $this->pegawai->get_by_id($inb->idp_pemaraf2)->nama_lengkap : "UNSIGNED" ?>)
								</label>
						</div>
					<?php endif ?>

					<?php if($inb->idj_pemaraf3): ?>
					<div class="input-control checkbox">
							<label>
									<input type="checkbox" <?php echo $inb->idp_pemaraf3 ? "checked" : "" ?> disabled/>
									<span class="check"></span>
									<?php echo 	$this->jabatan->get_jabatan($inb->idj_pemaraf3)->jabatan ?>
							</label>
					</div>
				<?php endif ?>

				<?php if($inb->idj_pemaraf4): ?>
					<div class="input-control checkbox">
							<label>
									<input type="checkbox" <?php echo $inb->idp_pemaraf4 ? "checked" : "" ?> disabled/>
									<span class="check"></span>
									<?php echo 	$this->jabatan->get_jabatan($inb->idj_pemaraf4)->jabatan ?>
							</label>
					</div>
				<?php endif ?>
				<label><strong>di tandatangan oleh :</strong></label>
				<div class="input-control checkbox">
						<label>
								<input type="checkbox" <?php echo $inb->idp_penandatangan ? "checked" : "" ?> disabled/>
								<span class="check"></span>
								<?php echo 	$this->jabatan->get_jabatan($inb->idj_penandatangan)->jabatan ?><br/>
								(<?php echo $inb->idp_penandatangan ? $this->pegawai->get_by_id($inb->idp_penandatangan)->nama_lengkap : "UNSIGNED" ?>)
						</label>
				</div>
				</div>
				<div id="actionBar">
                <p class="bg-lighterBlue padding20 fg-white">
                <?php

				if(isset($this->session->userdata('user')->id_j)){
							$idj = $this->session->userdata('user')->id_j;
							if($inb->idj_pemaraf1 == $idj) {
								$kolom=1;

								if($inb->idp_pemaraf1 != null && ($inb->idp_pemaraf2 == null || $inb->idp_pemaraf3 == null || $inb->idp_pemaraf4 == null) && $inb->idp_penandatangan == null){
										echo("<a href='signer/cancel_paraf/$inb->id/$kolom' class='button warning'>Batalkan Paraf</a>");
								}elseif($inb->idp_pemaraf1 == null){
										echo("<a href='signer/paraf/$inb->id/$kolom' class='button success'>Paraf</a>");
								}

							}elseif($idj == $inb->idj_pemaraf2){
								$kolom=2;
								if($inb->idp_pemaraf2 != null && $inb->idp_pemaraf3 == null && $inb->idp_pemaraf4 == null && $inb->idp_penandatangan == null){
										echo("<a href='signer/cancel_paraf/$inb->id/$kolom' class='button warning'>Batalkan Paraf</a>");
								}else{
										echo("<a href='signer/paraf/$inb->id/$kolom' class='button success'>Paraf</a>");
								}


							}elseif($idj == $inb->idj_pemaraf3){
								$kolom=3;
								if($inb->idp_pemaraf3 != null && $inb->idp_pemaraf4 == null && $inb->idp_penandatangan == null){
										echo("<a href='signer/cancel_paraf/$inb->id/$kolom' class='button warning'>Batalkan Paraf</a>");
								}else{
									echo("<a href='signer/paraf/$inb->id/$kolom' class='button success'>Paraf</a>");
								}

							}elseif ($idj == $inb->idj_pemaraf4){
								$kolom=4;
								if($inb->idp_pemaraf4 != null && $inb->idp_penandatangan == null){
										echo("<a href='signer/cancel_paraf/$inb->id/$kolom' class='button warning'>Batalkan Paraf</a>");
								}else{
									echo("<a href='signer/paraf/$inb->id/$kolom' class='button success'>Paraf</a>");
								}

							}elseif( $idj == $inb->idj_penandatangan){

								if($inb->idp_penandatangan != null){
									// echo("<a href='signer/cancel_sign/$inb->id' class='button warning'>Batalkan Tandatangan</a>");

								}else{
									echo("<button class='button default' id=btnSign onclick='sign(".$inb->id.")'>Tanda Tangan</button>");
								}
							};

						}




				/*
				if($inb->idj_pemaraf4==$this->session->userdata('user')->id_j or $inb->idj_pemaraf3==$this->session->userdata('user')->id_j or $inb->idj_pemaraf2==$this->session->userdata('user')->id_j or $inb->idj_pemaraf1==$this->session->userdata('user')->id_j)
				{
					if($inb->idj_pemaraf4==$this->session->userdata('user')->id_j)
					$kolom=4;
					elseif($inb->idj_pemaraf3==$this->session->userdata('user')->id_j)
					$kolom=3;
					elseif($inb->idj_pemaraf2==$this->session->userdata('user')->id_j)
					$kolom=2;
					elseif($inb->idj_pemaraf1==$this->session->userdata('user')->id_j)
					$kolom=1;



					echo("<a href='signer/paraf/$inb->id/$kolom' class='button success'>
						Paraf</a>");
				 }
				else
				{
				$tulisan='Tanda Tangan';
				$idbutton='btnSign';

				echo("<button class='button default' id=btnSign>Tanda Tangan</button>");
				}

				*/

				?>



					</p>
				</div>
				</td>

			</tr>
			<?php endforeach; ?>

		</tbody>
		</table>

	</div>

</div>

<script src="<?php echo base_url()?>js/jquery/chosen.jquery.js"></script>
<script>
	$('.chosen-select').chosen();

	function sign(id){
        $.Dialog({
            overlay: true,
            shadow: true,
            flat: true,
            draggable: true,
                    //icon: '<img src="images/excel2013icon.png">',
                                //title: 'Flat window',
            content: '',
            padding: 10,
            onShow: function(_dialog){
                var content = '<form class="user-input span6" action="<?php echo base_url('signer/sign')?>" method="post" >' +
          			'<div class="input-control text">'+
        				'<input class="password"  type="password" name="pin" id="pin" />'+
        				'<input type="hidden" name="id_tte" id="id_tte" value="'+id+'"/> </div>'+
                '<div class="form-actions">' +
                '<button class="button primary">Sign</button>&nbsp;'+
                '<button class="button" type="button" onclick="$.Dialog.close()">Cancel</button> '+
                '</div>'+
                '</form>';

                $.Dialog.title("Passphrase");
                $.Dialog.content(content);
            }
        });
    };
	$.Dialog.close();

</script>
