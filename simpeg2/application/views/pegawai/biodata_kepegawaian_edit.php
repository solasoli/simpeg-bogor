<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<div class="container">
<fieldset>
<?php  echo form_open('pegawai/profile_kepegawaian_edit/'.$this->uri->segment(4), array('id'=>'formEditKepegawaian')); ?>
<?php //print_r ($this->session->userdata('user')) ?>
<legend><h2>Data Kepegawaian <small><?php echo $this->pegawai->get_by_id($this->uri->segment(4))->nama ?></small></h2></legend>
	<table class='table hovered' >
		<tr>
			<td class="span4">Nomor Induk Kepegawaian</td>
			<td>
				<div class="input-control text span4">
				<input type="text" name="nip"  value="<?php echo $this->pegawai->get_by_id($this->uri->segment(4))->nip_baru ?>" />
				</div>
			</td>
			<td align="right"><a href="#"><i class="icon-pencil"></i></a></td>
		</tr>
		<tr>
			<td class="span4">Pangkat, Golongan/ruang</td>
			<td>
				<div class="input-control text span4">
				<input type="text" value="<?php echo $this->pegawai->get_by_id($this->uri->segment(4))->pangkat_gol ?>" />
				</div>
			</td>
			<td></td>
		</tr>
		<tr>
			<td class="span4">Rumpun Jabatan</td>
			<td>
				<div class="input-control text span4">
				<input type="text" value="<?php echo $this->pegawai->get_by_id($this->uri->segment(4))->jenjab ?>" />
				</div>
			</td>
			<td></td>
		</tr>
		<tr>
			<td class="span4">Jabatan</td>
			<td>
				<div class="input-control text span6"  tabindex="1">					
					<input type='text' name='jfu' id='jfu' 
						<?php echo $this->jabatan->get_jfu($this->uri->segment(4))  ? 'value="'.$this->jabatan->get_jfu($this->uri->segment(4))->nama_jfu.'"' :  'placeholder="Cari JFU"' ?>>
					
					<input type="hidden" name="kode_jabatan" id="kode_jabatan">
					<input type="hidden" name="unit_kerja" value="<?php echo $this->pegawai->get_by_id($this->uri->segment(4))->id_skpd ?>" id="unit_kerja">
				</div>			
			</td>
			<td><div id="kj"></div></td>
		</tr>
		<tr>
			<td class="span4">Jabatan Atasan</td>
			<td><?php // echo $this->pegawai->get_by_id($this->uri->segment(3))->nip_baru ?></td>
			<td></td>
		</tr>
		<tr>
			<td class="span4">Eseloneering</td>
			<td><?php // echo $this->pegawai->get_by_id($this->uri->segment(3))->nip_baru ?></td>
			<td></td>
		</tr>
		<tr>
			<td>
				<button class="button default" id="btnSimpan" >Simpan</button>
				<a href="<?php echo base_url('inpassing/jfu/'.$this->pegawai->get_by_id($this->uri->segment(4))->id_skpd)?>" class="button warning">Batal</a>
			</td>
			<td></td>
			<td></td>
		</tr>
	</table>
<?php  echo form_close(); ?>
</fieldset>
</div>
<script src="<?php echo base_url()?>js/jquery/jquery.autocomplete.js"></script>
<script src="<?php echo base_url()?>js/jquery/jquery.validate.js"></script>
<script>
	//$('.chosen-select').chosen();
$(function(){
    $('#jfu').devbridgeAutocomplete({
		source: function (request, response) {
			$.ajax({
				//url: '<?php // echo base_url('pegawai/jabatan_search'); ?>',
				type: 'GET',
				cache: false,
				contentType: "application/json; charset=utf-8",
				data: request,
				dataType: 'json',
				success: function (json) {
					
					response($.map(json, function () {
						return json;
						
					}));
					
				},
				error: function (XMLHttpRequest, textStatus, errorThrown) {
					//alert('error - ' + textStatus);
					console.log('error', textStatus, errorThrown);
				}
			});
		},
		minLength: 2,		
		onSelect: function (suggestion) {
			//alert('You selected: ' + suggestion.value + ', ' + suggestion.data);
			$('#kode_jabatan').val(suggestion.data);
			$('#kj').html('<label>'+suggestion.data+'</label>');
		}		

	});
	$("#formEditKepegawaian").validate({
        ignore: "",
		rules: {
            kode_jabatan: {
				required: true,
				minlength : 3, 
				maxlength : 9
            },
        },
        messages: {
            kode_jabatan: {
                required: "Anda Belum memilih jabatan, pastikan sampai muncul kode jabatan di sebelah kanan",
                minlength: "kode jabatan yang dipilih salah",
				maxlength: "kode jabatan yang dipilih salah"
		    },
        }   
    });
});


	
</script>
