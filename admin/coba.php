<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<script language="javascript" src="jquery.js"> </script>
<script language="javascript" src="jquery-ui.js"> </script>
<link rel="stylesheet" href="jquery-ui.custom.css" />
</head>

<body>
<form id="form1" name="form1" method="post" action="">

<input type="text" name="peg" id="peg" value="" class="employeeAutocomplete" />
<input type="hidden" name="id" id="id" />
</form>

</body>
</html>
<script language="javascript">
$(document).ready(function(){

$('input.employeeAutocomplete').each(function() {
	var autoCompelteElement = this;
	var formElementName = $(this).attr('name');
	var hiddenElementID  = formElementName + '_autocomplete_hidden';
	/* change name of orig input */
	$(this).attr('name', formElementName + '_autocomplete_label');
	/* create new hidden input with name of orig input */
	$(this).after("<input type=\"hidden\" name=\"" + formElementName + "\" id=\"" + hiddenElementID + "\" />");
	$(this).autocomplete({source:'data.txt',
		select: function(event, ui) {
			var selectedObj = ui.item;
			$(autoCompelteElement).val(selectedObj.label);
			$('#'+hiddenElementID).val(selectedObj.value);
			return false;
		}
	});
});

});
</script>
