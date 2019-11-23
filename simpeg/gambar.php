<style type="text/css">
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
</style>
<?
extract($_GET);
include("konek.php");
	   if($sk==1)
	  {
		  $q=mysqli_query($mysqli,"select URL from isi_berkas where URL like '%-$kp%'");
		 // echo("select URL from isi_berkas where URL like '%-$kp%' ");
	  }
		  
	  else
	  {
	  $q=mysqli_query($mysqli,"select URL from isi_berkas where URL like '%-$kp-%'");
	 // echo("select URL from isi_berkas where URL like '%-$kp-%' ");
	  }
	  $im=mysqli_fetch_array($q);
	  echo("<img src=./$im[0] width=800 align=center />");

?>