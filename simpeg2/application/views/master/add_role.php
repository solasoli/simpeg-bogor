<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

<div class='container'>
	<form action="<?php echo base_url('master/add_roles')?>" method="post">
	<div class="row">
		<div class="col-mid-8 well">
			<span>Role :</span>
			<!--nput type="text" name="txtRole" value="<?php //echo $role ? $role : '' ?>"/>
			<input type="submit" value="simpan"/-->
			<div class="input-control text">
				<input type="text" name="txtRole" value="<?php //echo $role ? $role : '' ?>"/>
				<input type="button" class="btn-clear"></input>
			</div>
		</div>
	</div>
	</form>
</div>