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
								<input type="checkbox" <?php echo $this->master->check_user_role($this->uri->segment(3),$r->role_id) ? "checked='checked'" : "" ;?>/>
								<span class="check"></span>
								<?php echo anchor('master/function_list/'.$r->role_id.'/'.$this->uri->segment(3),$r->role); ?>
							</label>
						</div>
						<?php } ?>
				<?php	else:
						echo "bangsad";
					//<!--label>role tidak tersedia</label-->
					endif; ?>
				
			</div>
		</div>
	</div>
</div>