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
<h5>Unggah Berkas</h5>
<?php
	if($ket == 'meninggal')
	{
?>
<label id="lb_sk">1. Fotokopi Surat Kematian</label>
	<div class="input-control file" id="in_sk">
		<input type="file" name="ufile_mati[]"/>
		<button class="btn-file"></button>
	</div>
<?php
	}
	else if($ket == 'cerai')
	{
?>
<label id="lb_sc">1. Fotokopi Surat Cerai</label>
	<div class="input-control file" id="in_sc">
		<input type="file" name="ufile_cerai[]"/>
		<button class="btn-file"></button>
	</div>
<?php
	}
	else
	{
?>

<label id="fc_ij">1. Fotokopi Ijazah Terakhir atau Surat Keterangan telah bekerja</label><br/>
						<div class="input-control file" id="up_ij">
							<input type="file" name="ufile_kerja[]" />
							<button class="btn-file"></button>
						</div>
<?php
	}
?>