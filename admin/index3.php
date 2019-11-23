<?
	session_start();
if($_SESSION['user']=='xxx')
{

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Admin</title>
<link rel="stylesheet" type="text/css" href="css/style.css" />
<style>
    div				{margin: 10px; font-family: Arial, Helvetica, sans-serif; font-size:12px; }
	.ausu-suggest	{width: 280px;}
    #wrapper 		{margin-left: auto; position: relative; margin-right: auto; margin-top:10px ;width:  600px;}
    h3 				{font-size: 11px; text-align: center;}
	span 			{font-size: 11px; font-weight: bold}

	a:link			{color: #F06;text-decoration: none;}
	a:visited 		{text-decoration: none;color: #F06;}
	a:hover 		{text-decoration: underline;color: #09F;}
	a:active		{text-decoration: none;color: #09F;}
</style>
<script type="text/javascript" src="jquery.js"></script>
<script type="text/javascript" src="js/jquery.ausu-autosuggest.min.js"></script>
<script>
$(document).ready(function() {
    $.fn.autosugguest({  
           className: 'ausu-suggest',
          methodType: 'POST',
            minChars: 2,
              rtnIDs: true,
            dataFile: 'data.php'
    });
});
</script>
</head>
<body>

    <div id="wrapper">
       <form action="index3.php" method="POST">
	   <table>
	   <tr>
	   <td nowrap>
           <div class="ausu-suggest">
             <label> Nama / NIP Baru / NIP Lama / Unit Kerja:  </label>
             <input type="text" size="45" value="" name="countries" id="countries" autocomplete="off" /> 
              <input type="hidden" size="4" value="" name="countriesid" id="countriesid" autocomplete="off"  />
			    <input name="submit" type="submit" value="Cari" style="width:100px;height:35px" />
			   <A href="out.php"> [LOGOUT] </A>
             
           </div>
		   <td>
		   </tr>
           </table>
		   
             
    	
        
       </form>
       <div style="clear:both">
      
       </div>
    </div>
	<div align="center" style="clear:both">
	<?
	extract($_POST);
	if(isset($countriesid))
{
echo("<iframe name=bebas width=100% height=520 src=dock.php?id=$countriesid frameborder=0 scrolling=auto /> </iframe> ");
}
	?>
	</div>
</body>
</html>
<?

}
else
echo("<div align=center>Restricted Access</div>");
?>