

<?php if($this->session->flashdata('k')): ?>
	<div  class="bg-red padding10 text-center">
		<strong><?php echo $this->session->flashdata('k') ; ?></strong>
	</div>

	<?php endif; ?>
	<?php if($this->session->flashdata('s')): ?>
		<div  class="bg-green padding10 text-center">
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
				<th>Uraian</th>
				<th>Kategori Berkas</th>
				<th width="20%" >Dokumen</th>
			</tr>
		</thead>
		<tbody>

			<?php if(sizeof($inbox) < 1): ?>
				<tr>
					<td colspan="4">Tidak Ada Dokumen</td>
				</tr>
			<?php else: ?>
			<?php $x=1; foreach($inbox as $inb): ?>
			<tr>
				<td><?php echo $x++; ?></td>
				<td>
					<?php echo $this->pegawai->get_by_id($inb->idp_pengolah)->nama_lengkap ?>
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
										echo("<button class='button default' id=btnSign name=btnSign onclick='sign(".$inb->id.")'>Tanda Tangan</button>");
									}
								};

							}

								echo("<button class='button warning' id=btnSign2 name=btnSign2 onclick='deleteberkas(".$inb->id.")'>Delete</button>");

					?>
					</p>
					</div>
				</td>
				<td><?php echo $inb->id_kat_berkas ?></td>
				<td>
					<object data="<?php echo "https://arsipsimpeg.kotabogor.go.id/simpeg2/berkas_tte/".$inb->filename; ?>" type="application/pdf" width="200" height="300">
					alt : <a href="<?php echo "https://arsipsimpeg.kotabogor.go.id/simpeg2/berkas_tte/".$inb->filename; ?>"><?php echo $inb->filename ?></a>
					</object>
					<br/>
					<a href="<?php echo "https://arsipsimpeg.kotabogor.go.id/simpeg2/berkas_tte/".$inb->filename; ?>" target="_blank">Buka di Tab Baru</a>
				</td>
			</tr>

			<?php endforeach; ?>
		<?php endif ?>
		</tbody>
		</table>

	</div>

</div>

<script src="<?php echo base_url()?>js/jquery/chosen.jquery.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
<script>
	$('.chosen-select').chosen();

	$(function(){
		$("#table_inbox").dataTable();
	});

	function deleteberkas(id){
		var r = confirm("hapus berkas ? "+id);
		if (r == true) {
		  $.post('<?php echo base_url('signer/deleteberkas') ?>',{id_tte : id})
			.done(function(data){
				if(data == 'SUCCESS'){
					window.location.reload(true);
				}else{
					alert('OPERATION FAILED');
				}
			})
		}
	}

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
                var content = '<form class="user-input span6" id="formtte">' +
          			'<div class="input-control text">'+
        				'<input class="password"  type="password" name="pin" id="pin" />'+
        				'<input type="hidden" name="id_tte" id="id_tte" value="'+id+'"/> </div>'+
						'<input type="hidden" name="ponsel" id="ponsel" value="<?php echo '62'.$inb->ponsel;?>"/> </div>'+
						'<input type="hidden" name="uraian" id="uraian" value="<?php echo stripslashes($inb->uraian); ?>"/> </div>'+
						'<input type="hidden" name="file_name" id="file_name" value="<?php echo $inb->filename; ?>"/> </div>'+
                '<div class="form-actions">' +
                '<a class="button primary" onclick="signing('+id+')">Sign</a>&nbsp;'+
                '<a class="button" type="button" onclick="$.Dialog.close()">Cancel</a> '+
                '</div>'+
                '</form>';

                $.Dialog.title("Passphrase");
                $.Dialog.content(content);
            }
        });
    };
	$.Dialog.close();

	function signing(id){

		$.post('<?php echo base_url('signer/sign') ?>',$('#formtte').serialize())
		.done(function(data){
			j = JSON.parse(data);
			console.log(j.status);

			if(j.status == 'SUCCESS'){
				//alert('Tandatangan Berhasil');
				var ponsel;
				var uraian;
				var filename;

				ponsel = $('#ponsel').val();
				uraian = $('#uraian').val();
				filename = $('#file_name').val();


				 $.post('https://eu14.chat-api.com/instance25721/message?token=32r2xt8sm5oxb5nx',
               {
                   "phone": ponsel,
                    "body": "Yth. Bpk/Ibu Pegawai Pemkot Bogor, " + uraian + " sudah tersedia, anda dapat mengunduhnya dengan klik tautan http://arsipsimpeg.kotabogor.go.id/simpeg2/berkas_tte/" + filename + " untuk mengunduh. Berkas tidak perlu diambil ke Kantor BKPSDA Kota Bogor cukup dicetak secara mandiri, Terimakasih."
                 },
                        function(data){
                         if(data.sent==true){
								alert("Pesan WhatsApp terkirim");
								Swal.fire({
								  position: 'top-end',
								  type: 'success',
								  title: 'tandatangan berhasil!!',
								  showConfirmButton: false,
								  timer: 5000
								})
								$.Dialog.close();
								window.location.reload('true');
							}else{
								alert("Pesan WhatsApp tidak terkirim");
							}
						});

			}else{
				//$.Notify.show("Tandatangan gagal");
				Swal.fire({
				  position: 'top-end',
				  type: 'error',
				  title: 'gagal!!',
					text: 'Tandatangan gagal, Passphrase salah',
				  showConfirmButton: false,
				  timer: 5000
				})
				//alert('Tandatangan Gagal');
			}

			/*
			if(data == 'SUCCESS'){
				window.location.reload(true);
			}else{
				alert('OPERATION FAILED');
			}
			*/
		})


		/* $.post('https://eu14.chat-api.com/instance25721/message?token=32r2xt8sm5oxb5nx',
                                                                {
                                                                    "phone": '<?php //echo '62'.(substr($inb->ponsel,1,strlen($ponsel)-1));?>',
                                                                    "body": "Yth. Bpk/Ibu Pegawai Pemkot Bogor, <?php //echo stripslashes($inb->uraian);?> sudah tersedia, anda dapat mengunduhnya dengan klik tautan http://arsipsimpeg.kotabogor.go.id/simpeg2/berkas_tte/<?php //echo $inb->filename; ?> untuk mengunduh. Berkas tidak perlu diambil ke Kantor BKPSDA Kota Bogor cukup dicetak secara mandiri, Terimakasih."
                                                                },
                                                                function(data){
                                                                    if(data.sent==true){
                                                                        alert("Pesan WhatsApp terkirim");
                                                                    }else{
                                                                        alert("Pesan WhatsApp tidak terkirim");
                                                                    }
                                                                }); */

	}

</script>
