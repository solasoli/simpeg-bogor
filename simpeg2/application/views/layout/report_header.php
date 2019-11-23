<?php
if(!$this->session->userdata('user')){
	redirect('');
} 
?>
<!DOCTYPE html>
<html lang="en">
<head>	
	<title>[SIMPEG] Laporan Kepegawaian</title>
	<style>
		body{
			font-family: arial;
			font-size: 10pt;
		}
		
		table, td, th, tr{
			border: 1pt solid black;
			border-collapse: collapse;			
			padding: 5px;
		}
	</style>
</head>
<body>
