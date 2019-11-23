<!DOCTYPE html>
<html lang="en">
<head>	
	<link rel="shortcut icon" href="images/favicon.ico" />
	<meta charset="utf-8" />		
	<title>SIMPEG 2013 Kota Bogor</title>
	<link href="<?php echo base_url(); ?>css/modern.css" rel="stylesheet">	
</head>
<body class="metrouicss">
<div class="page secondary">	
	<div class="page-region border-color-white bg-color-white">
		<div class="page-region-content">
			<h2>SIMPEG 2013</h2>
			<?php echo form_open('home/login'); ?>
			<div class="span5">
				NIP:
				<div class="input-control text">
					<input name="txtNip" type="text" />					
				</div>
				Password:
				<div class="input-control password">
					<input name="txtPassword" type="password" />
					<button class="btn-reveal"></button>
				</div>
				<div class="input-control">
					<input type="submit" value="LOGIN" />					
				</div>
			</div>			
			<?php form_close(); ?>
		</div>
	</div>
</div>
</body>
</html>