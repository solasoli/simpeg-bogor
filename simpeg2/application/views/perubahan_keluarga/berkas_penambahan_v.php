<head>	
	<link rel="shortcut icon" href="images/favicon.ico">
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>SIMPEG 2013 Kota Bogor</title>
	
	
	<link rel="stylesheet" href="<?php echo base_url()?>assets/metro/css/metro-bootstrap.css">
	<link rel="stylesheet" href="<?php echo base_url()?>assets/metro/css/metro-bootstrap-responsive.css" >
   
		
	<!-- JS Library -->
	<script src="<?php echo base_url()?>js/jquery/jquery.min.js"></script>
    <script src="<?php echo base_url()?>js/jquery/jquery.widget.min.js"></script>
	 <script src="<?php echo base_url()?>assets/metro/min/metro.min.js"></script>
	<!--script src="<?php //echo base_url()?>js/jquery/jquery.mousewheel.js"></script-->
	
	<!-- Metro UI CSS JavaScript plugins -->
    <!--script src="<?php //echo base_url()?>js/load-metro.js"></script-->	
    
</head>

<?php
	if($hub == 9 && $tj == 1)
	{
		if($jumlah_si > 0)
		{
			
		}
		else
		{
?>
						<h5>Unggah Berkas</h5>
						<label>1.Fotokopi Surat Nikah</label><br/>
						<div class="input-control file">
							<input type="file" name="ufile_si[]" required/>
							<button class="btn-file"></button>
						</div>
<?php
		}
	}
	else if($hub == 10 && $tj == 1)
	{
		if($jumlah_ak > 1)
		{
			echo "<input type='hidden' value=-1 id='status_full'>";
		}
		else 
		{
?>
		<h5>Unggah Berkas</h5>
		<label>1. Fotokopi Kelahhiran Anak</label><br/>
		<div class="input-control file">
			<input type="file" name="ufile_ak[]" required/>
			<button class="btn-file"></button>
		</div>
<?php	
		}
	}
	
?>