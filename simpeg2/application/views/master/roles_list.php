<div class="container">
	<p><h2>Roles</h2></p>
	<table class="table bordered hovered" id="role_list">
	<thead>
		<tr>			
			<th >Role ID</th>			
			<th >Role</th>
			<th>Aksi</th>
		</tr>		
	</thead>
	<tbody>	
		<?php if(sizeof($roles)>0): ?>
		<?php foreach($roles as $r): ?>
		<tr>
			<td><?php echo $r->role_id ?></td>
			<td><?php echo anchor('master/assign_function_to_role/'.$r->role_id,$r->role) ?></td>	
			<td width='20%'>
				<?php // echo anchor('master/edit_role/'.$r->role_id,'Ubah') ?>
				<button class="button info" id="ubahRole">Edit</button>
				<a href="<?php echo base_url().'master/delete_role/'.$r->role_id?>" class="button warning" onclick="return confirm('yakin akan dihapus?')">Delete</a>
				<?php //echo anchor('master/delete_role/'.$r->role_id,'Hapus',array('onclick'=>'"return confirm(\'Yakin menghapus\')"','class'=>'button')) ?>
			</td>
		</tr>
		<?php endforeach; ?>
		<?php else:?>
		<tr>
			<td colspan="2">Tidak ada data yang dapat disajikan</td>
		</tr>
		<?php endif; ?>		
	</tbody>
	</table>
	<button class="button" id="tambahRole">Tambah</button>
	<?php //echo anchor('master/add_roles','Tambah') ?>
	<script>
		$(function(){
			$("#tambahRole").on('click', function(){
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
                                    var content = '<form class="user-input" action="<?php echo base_url('master/add_roles')?>" method="post">' +
                                            '<label>Role Baru</label>' +
                                            '<div class="input-control text"><input type="text" name="txtRole"></div>' +                                            
                                            '<div class="form-actions">' +
                                            '<button class="button primary">Simpan</button>&nbsp;'+
                                            '<button class="button" type="button" onclick="$.Dialog.close()">Batal</button> '+
                                            '</div>'+
                                            '</form>';

                                    $.Dialog.title("Tambah role");
                                    $.Dialog.content(content);
                                }
                            });
                        });
			$("#editRole").on('click',function(e){
				var isi = document.getElementById();
			});
		});
		$(function(){
			$('#role_list').dataTable();
		});
	</script>
</div>
<!--  End of file index.php -->
<!--  Location: ./application/views/cuti/index.php  -->
