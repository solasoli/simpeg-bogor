<html>
<head>
	<script src="<?php echo base_url()?>js/jquery/jquery.min.js"></script>
	<script src="<?php echo base_url()?>js/jquery/jquery.autocomplete.js"></script>	
	<script src="<?php echo base_url()?>js/jquery/jquery-ui.js"></script>
</head>

<body>
	Country :<input type="text" name="country" id="autocomplete"/>
	<div class="ui-widget">
	  <label for="tags">Tags: </label>
	  <input id="tags">
	</div>
	<img scr='http://simpeg.kotabogor.go.id/simpeg/foto/4357.jpg' width='50' />
	<script>
		$(function() {
		var availableTags = [
		  "ActionScript",
		  "AppleScript",
		  "Asp",
		  "BASIC",
		  "C",
		  "C++",
		  "Clojure",
		  "COBOL",
		  "ColdFusion",
		  "Erlang",
		  "Fortran",
		  "Groovy",
		  "Haskell",
		  "Java",
		  "JavaScript",
		  "Lisp",
		  "Perl",
		  "PHP",
		  "Python",
		  "Ruby",
		  "Scala",
		  "Scheme"
		];
		
		$( "#tags" ).autocomplete({
			  source: availableTags
			});
		});
	</script>
	<div> footer </div>
</body>
</html>