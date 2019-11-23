<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<div class="container">
<h2>Daftar Jabatan Fungsional Umum</h2>

	<table class="table bordered hovered" id="jfuList">
		<thead>
			<tr>
				<th>No</th>
				<th>Kode Jabatan</th>
				<th>Nama Jabatan</th>
			</tr>
		</thead>
		<tbody>
			<?php $x=1; foreach($lists as $list) { ?>
			<tr>
				<td><?php echo $x++ ?></td>
				<td><?php echo $list->kode_jabatan ?></td>
				<td><?php echo $list->nama_jfu ?></td>
			</tr>
			<?php } ?>
		</tbody>
	</table>
	<a href="#" id="tambahJfu" class="button primary">tambah</a>
</div>
<script>
	$(function(){
			$("#tambahJfu").on('click', function(){
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
                                    var content = '<form class="user-input" action="<?php echo base_url('jabatan/add_jfu')?>" method="post">' +
                                            '<label>Kode Jabatan</label>' +
                                            '<div class="input-control text"><input type="text" name="kode_jfu"></div>' +
											'<div class="input-control text"><input type="text" name="nama_jfu"></div>' + 
                                            '<div class="form-actions">' +
                                            '<button class="button primary">Simpan</button>&nbsp;'+
                                            '<button class="button warning" type="button" onclick="$.Dialog.close()">Batal</button> '+
                                            '</div>'+
                                            '</form>';

                                    $.Dialog.title("Tambah Jabatan Fungsional Umum");
                                    $.Dialog.content(content);
                                }
                            });
                        });
			$("#editRole").on('click',function(e){
				var isi = document.getElementById();
			});
			$('#jfuList').dataTable();
		});
</script>