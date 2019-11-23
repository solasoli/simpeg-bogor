<div class="container">
	<p><h2><a href="<?php echo base_url('master/role_function')?>"><i class="icon-arrow-left-3 fg-darker larger"></i></a> <?php echo "Edit <small>".$this->master->get_roles($this->uri->segment(3))->role."</small>" ?></h2></p>
	<div class="grid">
		<div class="row">
			<div class="span2 offset1">
				<label>ROLE</label>
			</div>
			<div class="span4">
				<div class="input-control text">
					<input type="text" value="<?php echo $this->master->get_roles($this->uri->segment(3))->role ?>"/>
					
				</div>
			</div>
			
		</div>
		<div class="element-divider"></div>
		<div class="row">
			<!--div class="span10 offset1">
				<input type="checkbox" onClick="toggle(this)" data-transform="input-control"/> <span id="toggle">CHECK ALL</span>
			</div-->
		</div>
		<div class="row">		
			
			<div class="span10 offset1">
				
				<?php $x=1; if(sizeof($functions)> 0): 
						foreach($functions as $f){ ?>
						<div class="input-control checkbox">
							<label class="span3">								
								<input name="appf" type="checkbox" id="appf<?php echo $f->id_app_function ?>"							<?php echo $this->master->check_role_function($this->uri->segment(3),$f->id_app_function) ? "checked='checked'" : "" ;?> value="<?php echo $f->id_app_function ?>" data-transform="input-control"/>
								<!--span class="check"></span-->
								<?php echo $this->master->get_function_name($f->id_app_function)->function_name;$x++; ?>
							</label>
						</div>
						<?php } ?>
				<?php	else:
						
					echo "<label>role tidak tersedia</label>";
					endif; ?>
				
			</div>
		</div>
	</div>
</div>
<script>
	/*function toggle(source) {
		checkboxes = document.getElementsByName('appf');
		for(var i=0, n=checkboxes.length;i<n;i++) {
			checkboxes[i].checked = source.checked;
		};
		
		//$("#toggle").replaceWith("Uncheck All");
	}
	*/
	checkboxes = document.getElementsByName('appf');
	for(var i=1, n=checkboxes.length;i<=n;i++){
		$("#appf"+i).on("click", function(){
			var id = parseInt($(this).val(), 10);
			if($(this).is(":checked")) {
				//alert("checked "+id);
				$.ajax({
					type: "POST",
					dataType: "json",
					url: "<?php echo base_url('master/save_assign_function_to_role')?>",
					data: "role_id=<?php echo $this->uri->segment(3)?>&function_id=" + id,
					success: function(json) {						
						//alert(json);
					}
				});
			} else {				
				//alert('unceked'+id);
				$.ajax({
					type: "POST",
					dataType: "json",
					url: "<?php echo base_url('master/delete_assign_function_to_role')?>",
					data: "role_id=<?php echo $this->uri->segment(3)?>&function_id=" + id,
					success: function(json) {						
						//alert(json);
					}
				});
			}
		});
	}
</script>