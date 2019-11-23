<div class="container">
	<p><h2><a href="<?php echo base_url('master/user_roles')?>"><i class="icon-arrow-left-3 fg-darker larger"></i></a> <?php echo "Edit <small>".$this->pegawai->get_by_id($this->uri->segment(3))->nama."</small>" ?></h2></p>
	<div class="grid">
		<div class="row">
			<div class="span2 offset1">
				<label>NAMA</label>
			</div>
			<div class="span6">
				<div class="input-control text">
					<input type="text" value="<?php echo $this->pegawai->get_by_id($this->uri->segment(3))->nama ?>"/>
				</div>
			</div>
		</div>
		<div class="divider"></div>
		<div class="row">		
			<div class="span10 offset1">
				
				<?php $x=1; if(sizeof($roles)> 0): 
						foreach($roles as $r){ ?>
						<div class="input-control checkbox">
							<label class="span3">								
								<input type="checkbox" name="role_user" id="role_user<?php echo $x-1?>" value="<?php echo $r->role_id?>"								
								<?php echo $this->master->check_user_role($this->uri->segment(3),$r->role_id) ? "checked='checked'" : "" ;?>/>
								<span class="check"></span>
								<?php echo anchor('master/function_list/'.$r->role_id.'/'.$this->uri->segment(3),$r->role); $x++;?>
							</label>
						</div>
						<?php } ?>
				<?php	else:
						echo "error";
					//<!--label>role tidak tersedia</label-->
					endif; ?>
				
			</div>
		</div>
	</div>
</div>
<script>

	checkboxes = document.getElementsByName('role_user');
	for(var i=0, n=checkboxes.length;i<=n;i++){
		$("#role_user"+i).on("click", function(){
			var id = parseInt($(this).val(), 10);
			if($(this).is(":checked")) {
				//alert("checked "+ id );
				$.ajax({
					type: "POST",
					dataType: "json",
					url: "<?php echo base_url('master/save_assign_role_to_user')?>",
					data: "id_pegawai=<?php echo $this->uri->segment(3)?>&role_id=" + id,
					success: function(json) {						
						alert(json);
					}
				}); 
			} else {				
				//alert('unceked'+id);
				$.ajax({
					type: "POST",
					dataType: "json",
					url: "<?php echo base_url('master/delete_assign_role_to_user')?>",
					data: "id_pegawai=<?php echo $this->uri->segment(3)?>&role_id=" + id,
					success: function(json) {						
						alert(json);
					}
				}); 
			}
		});
	}
</script>