<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script src="jquery-1.4.js"></script>
<script>    
$(document).ready(function(){
 $('#nama').keypress(function(e) {
 if(e.keyCode == 13) {

   var nama = $('#nama').val(); 
   $.ajax({
    type:"POST",
    url:"nongol.php",    
    data: 'nama=' + nama,        
    success: function(html){                 
      $('#tampilkan').html(html);
	  $('#nama').val("");
    }  
   });
 }
  });
});
</script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<table width="200" border="0" cellspacing="0" cellpadding="5">
  <tr>
    <td><div id="tampilkan"> </div></td>
  </tr>
  <tr>
    <td>
      <label for="nama"></label>
      <label for="nama2"></label>
      <textarea name="nama" id="nama" cols="30" rows="2"></textarea></td>
  </tr>
</table>
</body>
</html>