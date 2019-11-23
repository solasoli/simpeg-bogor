<html>
<head>
<title>Add site</title>

</head>
<body onload="setFocus()">

<form action="add_site.php" method="post" name="add_site">
<input type=text name=add_url size=50 value="http://">
<input type=submit value=" add ">
<input type="reset" value=" reset " name="Reset">
</form>

<script language="javascript">

function setFocus()
{
var field = document.add_site.add_url;
field.focus();
field.value = field.value;
field.focus();
}

</script>

</body>
</html>