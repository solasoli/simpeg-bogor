<html>
	<head>
		<title>Batch Upload</title>
		
		<!-- Le styles -->
	    <link href="http://twitter.github.com/bootstrap/assets/css/bootstrap.css" rel="stylesheet">
	    <link href="http://twitter.github.com/bootstrap/assets/css/bootstrap-responsive.css" rel="stylesheet">
	    <!-- <link href="http://twitter.github.com/bootstrap/assets/css/docs.css" rel="stylesheet"> -->
	    <link href="http://twitter.github.com/bootstrap/assets/js/google-code-prettify/prettify.css" rel="stylesheet"> 
	
	    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
	    <!--[if lt IE 9]>
	      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	    <![endif]-->
	
	    <!-- Le fav and touch icons -->
	    <link rel="shortcut icon" href="http://twitter.github.com/bootstrap/assets/ico/favicon.ico">
	    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="http://twitter.github.com/bootstrap/assets/ico/apple-touch-icon-144-precomposed.png">
	    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="http://twitter.github.com/bootstrap/assets/ico/apple-touch-icon-114-precomposed.png">
	    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="http://twitter.github.com/bootstrap/assets/ico/apple-touch-icon-72-precomposed.png">
	    <link rel="apple-touch-icon-precomposed" href="http://twitter.github.com/bootstrap/assets/ico/apple-touch-icon-57-precomposed.png">
	    
	    <script type="text/javascript" src="../jquery-1.4.js"></script>
	</head>
	
	<body>
		<div class="container">
			<div class="page-header">
			<h2>Digitized SK Batch Uploader</h2>
			</div>
			<div class="well">
				<p>File-file yang akan diupload harus disimpan di direktori <strong>c:/xampp/htdocs/simpeg/cunda/batch/</strong></p>
				<p>Klik tombol LOAD di bawah untuk load file yang ada dalam direktori</p> 				
				<input type="button" value="LOAD" class="btn btn-success" onclick="process()" />
				<div>
				<textarea cols="800" rows="20" id="dirList">
				
				</textarea>
				</div>
			</div>
		</div><!-- class container -->
	</body>
</html>

<script type="text/javascript" >
	function process(){		
		$.post('batch_load.php', {}, function(data){
			$('#dirList').html(data);
		});
		
	}
</script>