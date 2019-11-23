<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<style type="text/css">
body,td,th {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 14px;
}
</style>
<script language="JavaScript" src="./calendar/calendar_eu.js"></script>

<link rel="stylesheet" href="./calendar/calendar.css">
<script src="jquery.js" type="text/javascript"></script>
<script type="text/javascript">
function addInput() {

var nok = document.getElementById('tk').value;
 $.ajax({
   type:"POST",
   url:"tambah.php",
   data: "nok="+nok,
   success: function (html)
   {
   
          
		
  $("#kimap"+nok).html(html);

   
  }
   
   }); 
   
var x = document.getElementById('tk');
document.getElementById('tk').value = parseInt(x.value) + 1;

}


function jp (nok){
	 var k = $('#k'+nok).val();
	$('#p'+nok).hide();
	 $.ajax({
   type:"POST",
   url:"jenisproduk.php",
   data: "nok="+nok+"&k="+k,
   success: function (html)
   {
   
          
		
  $("#jenisproduk"+nok).html(html);

   
  }
   
   }); 


}


function pilprod (nok){
	 var jp = $('#j'+nok).val(),k = $('#k'+nok).val() ;
	
	 $.ajax({
   type:"POST",
   url:"pilihproduk.php",
   data: "nok="+nok+"&jp="+jp+"&k="+k,
   success: function (html)
   {
   
          
		
  $("#produk"+nok).html(html);

   
  }
   
   }); 


}


</script>
</head>

<body>
<?php
extract($_POST);


?>
<link rel="stylesheet" href="star.css" />
<form id="form1" name="form1" method="post" action="admin.php">
  <table width="700" border="0" align="center" cellpadding="5" cellspacing="0">
    <tr>
      <td colspan="3"><strong>I. Gambaran Umum</strong><span id="tambahan"> </span></td>
    </tr>
    <tr>
      <td width="176" nowrap="nowrap">Nama Perusahaan</td>
      <td width="7">:</td>
      <td width="487"><label for="np"></label>
      <input name="np" type="text" id="np" size="50" /></td>
    </tr>
    <tr>
      <td colspan="3"><strong>Kantor Pusat</strong></td>
    </tr>
    <tr>
      <td nowrap="nowrap">Alamat</td>
      <td>:</td>
      <td><label for="alpusat"></label>
      <textarea name="alpusat" id="alpusat" cols="45" rows="5"></textarea></td>
    </tr>
    <tr>
      <td nowrap="nowrap">No. Telepon</td>
      <td>:</td>
      <td><input type="text" name="telpusat" id="telpusat" /></td>
    </tr>
    <tr>
      <td nowrap="nowrap">No. Fax</td>
      <td>:</td>
      <td><input type="text" name="faxpusat" id="faxpusat" /></td>
    </tr>
    <tr>
      <td nowrap="nowrap">E - Mail</td>
      <td>:</td>
      <td><input type="text" name="mailpusat" id="mailpusat" /></td>
    </tr>
    <tr>
      <td nowrap="nowrap">Website</td>
      <td>:</td>
      <td><input type="text" name="webpusat" id="webpusat" /></td>
    </tr>
    <tr>
      <td nowrap="nowrap">Pimpinan</td>
      <td>:</td>
      <td><input type="text" name="pimpinanpusat" id="pimpinanpusat" /></td>
    </tr>
    <tr>
      <td nowrap="nowrap">Contact Person</td>
      <td>:</td>
      <td><input type="text" name="cpusat" id="cpusat" /></td>
    </tr>
    <tr>
      <td nowrap="nowrap">NPWP</td>
      <td>:</td>
      <td><input type="text" name="npwpusat" id="npwpusat" /></td>
    </tr>
    <tr>
      <td colspan="3" nowrap="nowrap"><strong>Pabrik/Workshop/lainnya sesuai karakteristik perusahaan</strong></td>
    </tr>
    <tr>
      <td nowrap="nowrap">Alamat</td>
      <td>:</td>
      <td><label for="alworkshop">
        <textarea name="alworkshop" id="alworkshop" cols="45" rows="5"></textarea>
      </label></td>
    </tr>
    <tr>
      <td nowrap="nowrap">No. Telepon</td>
      <td>:</td>
      <td><input type="text" name="telworkshop" id="telworkshop" /></td>
    </tr>
    <tr>
      <td nowrap="nowrap">No. Fax</td>
      <td>:</td>
      <td><input type="text" name="faxworkshop" id="faxworkshop" /></td>
    </tr>
    <tr>
      <td nowrap="nowrap">E - Mail</td>
      <td>:</td>
      <td><input type="text" name="mailworkshop" id="mailworkshop" /></td>
    </tr>
    <tr>
      <td nowrap="nowrap">Website</td>
      <td>:</td>
      <td><input type="text" name="webworkshop" id="webworkshop" /></td>
    </tr>
    <tr>
      <td nowrap="nowrap">Contact Person</td>
      <td>:</td>
      <td><input type="text" name="cpworkshop" id="cpworkshop" /></td>
    </tr>
    <tr>
      <td colspan="3" nowrap="nowrap"><strong>II. IJIN USAHA, SURAT KETERANGAN, DAN SURAT KEMAMPUAN</strong></td>
    </tr>
    <tr>
      <td nowrap="nowrap">Status Usaha</td>
      <td>:</td>
      <td><label for="statususaha"></label>
        <select name="statususaha" id="statususaha">
          <option value="pma">PMA</option>
          <option value="pmdn">PMDN</option>
          <option value="bumn">BUMN</option>
          <option value="dll">Lainnya</option>
      </select></td>
    </tr>
    <tr>
      <td colspan="3" nowrap="nowrap"><strong>Akte Pendirian</strong></td>
    </tr>
    <tr>
      <td nowrap="nowrap">No Akte Pendirian</td>
      <td>:</td>
      <td><label for="akteawal"></label>
      <input type="text" name="akteawal" id="akteawal" /></td>
    </tr>
    <tr>
      <td nowrap="nowrap">Tanggal</td>
      <td>:</td>
      <td><label for="tawal"></label>
      <input type="text" name="tawal" id="tawal" />
      <script language="JavaScript">
	new tcal ({
		// form name
		'formname': 'form1',
		// input name
		'controlname': 'tawal'
	});
	</script>     
      
      </td>
    </tr>
    <tr>
      <td nowrap="nowrap">Nama Notaris</td>
      <td>:</td>
      <td><input type="text" name="notarisawal" id="notarisawal" /></td>
    </tr>
    <tr>
      <td colspan="3" nowrap="nowrap"><strong>Akte Perubahan Terakhir</strong></td>
    </tr>
    <tr>
      <td nowrap="nowrap">No Akte Pendirian</td>
      <td>:</td>
      <td><input type="text" name="akteakhir" id="akteakhir" /></td>
    </tr>
    <tr>
      <td nowrap="nowrap">Tanggal</td>
      <td>:</td>
      <td><input type="text" name="takhir" id="takhir" />
      <script language="JavaScript">
	new tcal ({
		// form name
		'formname': 'form1',
		// input name
		'controlname': 'takhir'
	});
	</script> 
      
      </td>
    </tr>
    <tr>
      <td nowrap="nowrap">Nama Notaris</td>
      <td>:</td>
      <td><input type="text" name="notarisakhir" id="notarisakhir" /></td>
    </tr>
    <tr>
      <td colspan="3" nowrap="nowrap"><strong>Ijin Usaha</strong></td>
    </tr>
    <tr>
      <td nowrap="nowrap">No Surat </td>
      <td>:</td>
      <td><input type="text" name="ijinusaha" id="ijinusaha" /></td>
    </tr>
    <tr>
      <td nowrap="nowrap">Masa Berlaku</td>
      <td>:</td>
      <td><input type="text" name="berlaku" id="berlaku" />
       <script language="JavaScript">
	new tcal ({
		// form name
		'formname': 'form1',
		// input name
		'controlname': 'berlaku'
	});
	</script>  
      
      </td>
    </tr>
    <tr>
      <td nowrap="nowrap">Instansi pemberi Ijin</td>
      <td>:</td>
      <td><input type="text" name="pemberiijin" id="pemberiijin" /></td>
    </tr>
    <tr>
      <td nowrap="nowrap">Kegiatan Usaha</td>
      <td>:</td>
      <td><input type="text" name="kegusaha" id="kegusaha" /></td>
    </tr>
    <tr>
      <td colspan="3" nowrap="nowrap"><strong>Surat Keterangan Terdaftar (SKT)</strong></td>
    </tr>
    <tr>
      <td nowrap="nowrap">No Surat </td>
      <td>:</td>
      <td><label for="noskt"></label>
      <input type="text" name="noskt" id="noskt" /></td>
    </tr>
    <tr>
      <td nowrap="nowrap">Masa Berlaku</td>
      <td>:</td>
      <td><input type="text" name="tglskt" id="tglskt" />
       <script language="JavaScript">
	new tcal ({
		// form name
		'formname': 'form1',
		// input name
		'controlname': 'tglskt'
	});
	</script> 
      
      </td>
    </tr>
    <tr>
      <td nowrap="nowrap">Instansi pemberi</td>
      <td>:</td>
      <td><input type="text" name="pemberiskt" id="pemberiskt" /></td>
    </tr>
    <tr>
      <td colspan="3" nowrap="nowrap"><strong>Surat Kemampuan Usaha Penunjang (SKUP)</strong></td>
    </tr>
    <tr>
      <td nowrap="nowrap">No Surat </td>
      <td>:</td>
      <td><label for="skup"></label>
      <input type="text" name="skup" id="skup" /></td>
    </tr>
    <tr>
      <td nowrap="nowrap">Masa Berlaku</td>
      <td>:</td>
      <td><label for="berlakuskup"></label>
      <input type="text" name="berlakuskup" id="berlakuskup" />
      <script language="JavaScript">
	new tcal ({
		// form name
		'formname': 'form1',
		// input name
		'controlname': 'berlakuskup'
	});
	</script> 
      </td>
    </tr>
    <tr>
      <td nowrap="nowrap">Instansi pemberi</td>
      <td>:</td>
      <td><label for="pemberiskup"></label>
      <input type="text" name="pemberiskup" id="pemberiskup" /></td>
    </tr>
    <tr>
      <td colspan="3" nowrap="nowrap"><strong>III. Sertifikat Manajemen Mutu, Lingkungan dan Keselamatan Kerja</strong></td>
    </tr>
    <tr>
      <td colspan="3" nowrap="nowrap"><strong>Sertifikat Manajemen Mutu</strong></td>
    </tr>
    <tr>
      <td nowrap="nowrap">Standar</td>
      <td>:</td>
      <td><label for="standarmutu"></label>
      <input type="text" name="standarmutu" id="standarmutu" /></td>
    </tr>
    <tr>
      <td nowrap="nowrap">No. Sertifikat</td>
      <td>:</td>
      <td><input type="text" name="nosermutu" id="nosermutu" /></td>
    </tr>
    <tr>
      <td nowrap="nowrap">Berlaku s/d</td>
      <td>:</td>
      <td><input type="text" name="tglmutu" id="tglmutu" />
      <script language="JavaScript">
	new tcal ({
		// form name
		'formname': 'form1',
		// input name
		'controlname': 'tglmutu'
	});
	</script> 
      </td>
    </tr>
    <tr>
      <td nowrap="nowrap">Badan Sertifikasi</td>
      <td>:</td>
      <td><input type="text" name="basermutu" id="basermutu" /></td>
    </tr>
    <tr>
      <td colspan="3" nowrap="nowrap"><strong>Sertifikat Manajemen Lingkungan</strong></td>
    </tr>
    <tr>
      <td nowrap="nowrap">Standar</td>
      <td>:</td>
      <td><input type="text" name="standarling" id="standarling" /></td>
    </tr>
    <tr>
      <td nowrap="nowrap">No. Sertifikat</td>
      <td>:</td>
      <td><input type="text" name="noserling" id="noserling" /></td>
    </tr>
    <tr>
      <td nowrap="nowrap">Berlaku s/d</td>
      <td>:</td>
      <td><input type="text" name="tglling" id="tglling" />
       <script language="JavaScript">
	new tcal ({
		// form name
		'formname': 'form1',
		// input name
		'controlname': 'tglling'
	});
	</script> 
      </td>
    </tr>
    <tr>
      <td nowrap="nowrap">Badan Sertifikasi</td>
      <td>:</td>
      <td><input type="text" name="baserling" id="baserling" /></td>
    </tr>
    <tr>
      <td colspan="3" nowrap="nowrap"><strong>Sertifikat Manajemen Keselamatan Kerja</strong></td>
    </tr>
    <tr>
      <td nowrap="nowrap">Standar</td>
      <td>:</td>
      <td><input type="text" name="standark3lh" id="standark3lh" /></td>
    </tr>
    <tr>
      <td nowrap="nowrap">No. Sertifikat</td>
      <td>:</td>
      <td><input type="text" name="noserk3lh" id="noserk3lh" /></td>
    </tr>
    <tr>
      <td nowrap="nowrap">Berlaku s/d</td>
      <td>:</td>
      <td><input type="text" name="tglk3lh" id="tglk3lh" /></td>
    </tr>
    <tr>
      <td nowrap="nowrap">Badan Sertifikasi</td>
      <td>:</td>
      <td><input type="text" name="baserk3lh" id="baserk3lh" /></td>
    </tr>
    <tr>
      <td nowrap="nowrap"><strong>Rating Perusahaan</strong></td>
      <td>:</td>
      <td align="left" valign="middle"><div class="stars" align="left">
		<input name="star" type="radio" class="star-1" id="star-1" value="1" />
		<label class="star-1" for="star-1">1</label>
		<input name="star" type="radio" class="star-2" id="star-2" value="2" />
		<label class="star-2" for="star-2">2</label>
		<input name="star" type="radio" class="star-3" id="star-3" value="3" />
		<label class="star-3" for="star-3">3</label>
		<input name="star" type="radio" class="star-4" id="star-4" value="4" />
		<label class="star-4" for="star-4">4</label>
		<input name="star" type="radio" class="star-5" id="star-5" value="5" />
		<label class="star-5" for="star-5">5</label>
		<span></span>
	</div></td>
    </tr>
    <tr>
      <td align="left" valign="top" nowrap="nowrap"><strong>Produk Perusahaan</strong></td>
      <td align="center" valign="top">:</td>
      <td nowrap="nowrap">
        KIMAP
        <label for="k1"></label>
        <select name="k1" id="k1" onChange="javascript:jp(1)" style="width:150px;">
         <option value="0"> Pilih Kode KIMAP</option>
         <?php
		 include("koneksi.php");
		 extract($_POST);
		 $qk=mysql_query("select * from kimap");
		 while($dk=mysql_fetch_array($qk))
		 {
		  if($dk[0]==$k1)	 
		 echo("<option value=$dk[0] selected> $dk[1]</option>");
		 else
		 echo("<option value=$dk[0]> $dk[1]</option>");
		 
		 }
		 ?>
      </select>
        
      
      <span id="jenisproduk1"> </span><span id="produk1">
      <input name="tk" type="hidden" id="tk" value="2" />
      </span>
      
     
      <div id="kimap2">

</div>
      
      </td>
    </tr>
    <tr>
      <td><input name="x" type="hidden" id="x" value="insvki.php" /></td>
      <td>&nbsp;</td>
      <td><input type="button" onclick="addInput()" name="add" value="Tambah Produk" /></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td><input type="submit" name="button2" id="button2" value="Simpan" /></td>
    </tr>
  </table>
</form>
</body>
</html>