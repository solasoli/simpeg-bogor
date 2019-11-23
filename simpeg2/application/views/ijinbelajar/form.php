<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<style type="text/css">
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
	font-family: "Segoe UI Light_","Open Sans Light",Verdana,Arial,Helvetica,sans-serif;
font-size: 14px;
}
</style>
<link rel="shortcut icon" href="images/favicon.ico">
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>SIMPEG 2013 Kota Bogor</title>
	
	<script src="<?php echo base_url()?>js/jquery/jquery.autocomplete.js"></script>
<script src="<?php echo base_url()?>js/jquery/jquery.validate.js"></script>
<script>
	//$('.chosen-select').chosen();
$(function(){
    $('#nama').devbridgeAutocomplete({
		source: function (request, response) {
			$.ajax({
				type: 'GET',
				cache: false,
				contentType: "application/json; charset=utf-8",
				data: request,
				dataType: 'json',
				success: function (json) {
					
					response($.map(json, function () {
						return json;
						
					}));
					
				},
				error: function (XMLHttpRequest, textStatus, errorThrown) {
					//alert('error - ' + textStatus);
					console.log('error', textStatus, errorThrown);
				}
			});
		},
		minLength: 2,		
		onSelect: function (suggestion) {
			//alert('You selected: ' + suggestion.value + ', ' + suggestion.data);
			$('#nama').val(suggestion.data);
			//$('#kj').html('<label>'+suggestion.data+'</label>');
		}		

	});
	
});


	
</script>
</head>

<body class="metro">
<form id="form1" name="form1" method="get" action="<?php echo base_url()?>ib">
  <table width="500" border="0" align="center" cellpadding="5" cellspacing="0">
    <tr>
      <td nowrap="nowrap">Nama</td>
      <td>:</td>
      <td><label for="nama"></label>
      <input name="nama" type="text" id="nama" size="50" /></td>
    </tr>
    <tr>
      <td nowrap="nowrap">Tingkat Pendidikan Lanjutan</td>
      <td>:</td>
      <td><label for="select"></label>
        <select name="select" id="select">
          <option value="6">D1</option>
          <option value="5">D2</option>
          <option value="4">D3</option>
          <option value="3">S1</option>
          <option value="2">S2</option>
          <option value="1">S3</option>
      </select></td>
    </tr>
    <tr>
      <td nowrap="nowrap">Institusi Pendidikan</td>
      <td>:</td>
      <td><label for="textfield2"></label>
      <input name="textfield2" type="text" id="textfield2" size="50" /></td>
    </tr>
    <tr>
      <td nowrap="nowrap">Akreditas Perguruan Tinggi</td>
      <td>:</td>
      <td><label for="select2"></label>
        <select name="select2" id="select2">
          <option value="A">A</option>
          <option value="B">B</option>
          <option value="C">C</option>
      </select></td>
    </tr>
    <tr>
      <td nowrap="nowrap">&nbsp;</td>
      <td>&nbsp;</td>
      <td><input type="submit" name="button" id="button" value="Ajukan" /></td>
    </tr>
  </table>
</form>
</body>
</html>