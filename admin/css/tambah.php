	<link rel="stylesheet" type="text/css" href="tcal.css" />
	<script type="text/javascript" src="tcal.js"></script> 
<link rel="stylesheet" href="css/jquery-ui.css">
	<script type="text/javascript" src="jquery.js"></script>
	<script type="text/javascript" src="jquery-ui.js"></script>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<script src="SpryAssets/SpryTabbedPanels.js" type="text/javascript"></script>
<link href="SpryAssets/SpryTabbedPanels.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.style2 {font-size: 10pt}
.style4 {font-size: 10px}
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
}
-->
</style>
<?
include("koncil.php");

?>
<form action="nambah.php" method="post" name="form1" class="hurup" id="form1">
<div id="TabbedPanels1" class="TabbedPanels">
  <ul class="TabbedPanelsTabGroup">
    <li class="TabbedPanelsTab style2" tabindex="0">Biodata</li>
    <li class="TabbedPanelsTab style2" tabindex="0">Keluarga</li>
    <li class="TabbedPanelsTab style2" tabindex="0">Pendidikan</li>

   <div align="right">
     <input type="submit" name="button" id="button" value="Simpan" /> </div>
  </ul>
  <div class="TabbedPanelsContentGroup">
    <div class="TabbedPanelsContent">
    <?



?>
      
        <table width="100%" border="0" cellpadding="3" cellspacing="0" class="hurup">
          <tr>
            <td width="21%" align="left" valign="top">Nama </td>
            <td width="3%" align="left" valign="top">:</td>
            <td width="28%"><label for="n"></label>
            <input name="n" type="text" id="n"  /></td>
            <td width="42" colspan="3" rowspan="4" align="left" valign="bottom"></td>
          </tr>
		   <tr>
			<td align="left" valign="top">Gelar Depan</td>
            <td align="left" valign="top">:</td>
            <td><input name="gelar_depan" type="text" id="gelar_depan" value="<?php echo($ata['gelar_depan']); ?>" /></td>
		  </tr>
		  <tr>
			<td align="left" valign="top">Gelar Belakang</td>
            <td align="left" valign="top">:</td>
            <td><input name="gelar_belakang" type="text" id="gelar_belakang" value="<?php echo($ata['gelar_belakang']); ?>" /></td>
		  </tr>
          <tr>
            <td align="left" valign="top">NIP Lama</td>
            <td align="left" valign="top">:</td>
            <td><input name="nl" type="text" id="nl"  /></td>
          </tr>
          <tr>
            <td align="left" valign="top" nowrap="nowrap">Agama</td>
            <td align="left" valign="top">:</td>
            <td><select name="a" id="a">
              <?
			  $qjo=mysqli_query($con,"SELECT agama FROM `pegawai` where flag_pensiun=0 group by agama ");
                while($otoi=mysqli_fetch_array($qjo))
				echo("<option value=$otoi[0]>$otoi[0]</option>");
							
				?>
            </select></td>
          </tr>
          <tr>
            <td align="left" valign="top" nowrap="nowrap">Tempat Lahir</td>
            <td align="left" valign="top">:</td>
            <td><input name="tl" type="text" id="tl"  /></td>
          </tr>
          <tr>
            <td align="left" valign="top" nowrap="nowrap">Tanggal Lahir</td>
            <td align="left" valign="top">:</td>
            <td><label for="tgl"></label>
            <input name="tgl" type="text" class="tcal"  id="tgl" /></td>
            <td width="11" rowspan="2" align="left" valign="top">Alamat</td>
            <td width="10" rowspan="2" align="left" valign="top">:</td>
            <td width="21" rowspan="2" align="left" valign="top"><textarea class="hurup" name="al" id="al" cols="45" rows="3"></textarea></td>
          </tr>
          <tr>
            <td align="left" valign="top" nowrap="nowrap" class="selected">NIP Baru</td>
            <td align="left" valign="top">:</td>
            <td><input name="nb" type="text" id="nb"  size="22" /></td>
          </tr>
          <tr>
            <td align="left" valign="top" nowrap="nowrap">Jenis Kelamin</td>
            <td align="left" valign="top">:</td>
            <td><select name="jk" id="jk">
              <?
			  $qp=mysqli_query($con,"SELECT jenis_kelamin FROM `pegawai` where flag_pensiun=0 group by jenis_kelamin ");
                while($oto=mysqli_fetch_array($qp))
				echo("<option value=$oto[0]>$oto[0]</option>");
						
				?>
            </select></td>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top">&nbsp;</td>
          </tr>
          <tr>
            <td align="left" valign="top" nowrap="nowrap">Kartu Pegawai</td>
            <td align="left" valign="top">:</td>
            <td><input name="karpeg" type="text" id="karpeg"  /></td>
            <td align="left" valign="top">Kota</td>
            <td width="10" align="left" valign="top">:</td>
            <td width="21" align="left" valign="top"><input name="kota" type="text" id="kota"  /></td>
          </tr>
          <tr>
            <td align="left" valign="top" nowrap="nowrap">NPWP</td>
            <td align="left" valign="top">:</td>
            <td><input name="npwp" type="text" id="npwp"  /></td>
            <td width="11" align="left" valign="bottom">Golongan Darah</td>
            <td width="10" align="left" valign="bottom">:</td>
            <td width="21" align="left" valign="bottom"><select name="darah" id="darah">
              <?
			  $qd=mysqli_query($con,"SELECT gol_darah FROM `pegawai` where flag_pensiun=0 group by gol_darah order by gol_darah ");
                while($da=mysqli_fetch_array($qd))
				echo("<option value=$da[0]>$da[0]</option>");
			
				
				?>
            </select></td>
          </tr>
          <tr>
            <td align="left" valign="top" nowrap="nowrap">Gol / Ruang</td>
            <td align="left" valign="top">:</td>
            <td><select name="gol" id="gol">
              <?
			  $qp=mysqli_query($con,"SELECT pangkat_gol FROM `pegawai` where flag_pensiun=0 group by pangkat_gol ");
                while($oto=mysqli_fetch_array($qp))
				echo("<option value=$oto[0]>$oto[0]</option>");
			
				
				?>
            </select></td>
            <td align="left" valign="top">Status Aktif</td>
            <td align="left" valign="top">:</td>
            <td align="left" valign="top"><select name="aktif" id="aktif">
              <?
			  $qot=mysqli_query($con,"SELECT status_aktif FROM `pegawai`  group by status_aktif ");
                while($ot=mysqli_fetch_array($qot))
				echo("<option value='$ot[0]' >$ot[0]</option>");
				
				
				?>
            </select></td>
          </tr>
          <tr>
            <td align="left" valign="top" nowrap="nowrap">Unit Kerja</td>
            <td align="left" valign="top">:</td>
            <td></td>
            <td align="left" valign="top">Tgl Pensiun Reguler</td>
            <td align="left" valign="top">:</td>
            <td align="left" valign="top"><input name="pensiun" type="text" class="tcal"  id="pensiun"  /></td>
          </tr>
          <tr>
            <td align="left" valign="top" nowrap="nowrap">Jenjang Jabatan</td>
            <td align="left" valign="top">:</td>
            <td><label for="jenjab"></label>
              <select name="jenjab" id="jenjab">
              <?
			  $qjo=mysqli_query($con,"SELECT jenjab FROM `pegawai` where flag_pensiun=0 group by jenjab ");
                while($oto=mysqli_fetch_array($qjo))
				echo("<option value=$oto[0]>$oto[0]</option>");
			
				?>
            </select></td>
            <td align="left" valign="top">Password
            <input name="id2" type="hidden" id="id2" value="<?php echo($id);  ?>" />
            <input name="id" type="hidden" id="id" value="<?php echo($id);  ?>" /></td>
            <td align="left" valign="top">:</td>
            <td align="left" valign="top"></td>
          </tr>
          <tr>
            <td align="left" valign="top" nowrap="nowrap">Telepon</td>
            <td align="left" valign="top">:</td>
            <td><input name="telp" type="text" id="telp"  /></td>
            <td align="left" valign="top">Jabatan</td>
            <td align="left" valign="top">:</td>
            <td align="left" valign="top"></td>
          </tr>
          <tr>
            <td align="left" valign="top" nowrap="nowrap">Ponsel</td>
            <td align="left" valign="top">:</td>
            <td><input name="hp" type="text" id="hp"  /></td>
            <td align="left" valign="top">Eselonering</td>
            <td align="left" valign="top">:</td>
            <td align="left" valign="top"></td>
          </tr>
          <tr>
            <td align="left" valign="top" nowrap="nowrap">Email</td>
            <td align="left" valign="top">:</td>
            <td><input name="email" type="text" id="email" /></td>
            <td align="left" valign="top">id pegawai</td>
            <td align="left" valign="top">:</td>
            <td align="left" valign="top"><input name="hp3" type="text" id="hp3"  readonly="readonly" /></td>
          </tr>
        </table>
 
    </div>
    <div class="TabbedPanelsContent">
      <table width="100%" border="0" cellpadding="3" cellspacing="0" class="hurup">
        <tr>
          <td>Status Nikah</td>
          <td>:</td>
          <td><select name="kawin" id="kawin">
            <?
			  $qjo=mysqli_query($con,"SELECT status_kawin FROM `pegawai` where flag_pensiun=0 group by status_kawin ");
                while($otoi=mysqli_fetch_array($qjo))
				echo("<option value=$otoi[0]>$otoi[0]</option>");
			
				?>
          </select></td>
          <td colspan="3" rowspan="4" align="center" valign="top">
		  
		  <table width="400" border="0" align="center" cellpadding="3" cellspacing="0" class="hurup">
            <tr>
              <td colspan="4" align="left">Data Anak</td>
              </tr>
            <tr>
              <td>No</td>
              <td>Nama</td>
              <td>Tempat Lahir</td>
              <td>Tanggal Lahir</td>
            </tr>
          
                       
              <tr>
              <td><input name="ja" type="hidden" id="ja" value="<?php echo($totanak);  ?>" />
                +</td>
              <td><label for="anak"></label>
                <input type="text" name="anak" id="anak" size="25"/></td>
              <td><label for="ttl"></label>
                <input type="text" name="ttl" id="ttl"  size="15"/></td>
              <td><input name="tlanak" type="text" class="tcal"  id="tlanak"  size="20"/></td>
            </tr>
            </table></td>
          </tr>
        <tr>
          <td>Nama istri / Suami</td>
          <td>:</td>
          <td><label for="win"></label>
            <input name="win" type="text" id="win"  size="30" /></td>
          </tr>
        <tr>
          <td nowrap="nowrap">Tempat lahir istri/suami</td>
          <td>:</td>
          <td><input name="twin" type="text" id="twin" size="30" /></td>
          </tr>
        <tr>
          <td nowrap="nowrap">Tanggal Lahir istri/suami</td>
          <td>:</td>
          <td><input name="tglwin" type="text" class="tcal"  id="tglwin"  /></td>
          </tr>
         
      </table>
   
    </div>
    <div class="TabbedPanelsContent">
      <table width="100%" border="0" cellpadding="3" cellspacing="0" class="hurup">
        <tr>
          <td>No</td>
          <td>Tingkat Pendidikan</td>
          <td>Lembaga Pendidikan</td>
          <td>Jurusan</td>
          <td>Bidang Pendidikan</td>
          <td>Tahun Lulus</td>
        </tr>
        
       
        <tr>
          <td>+</td>
          <td> <select name="tingkat" id="tingkat">
            <?
			  $qjo2=mysqli_query($con,"SELECT tingkat_pendidikan FROM `pendidikan` where tingkat_pendidikan!=' '   group by tingkat_pendidikan ");
                while($otoi2=mysqli_fetch_array($qjo2))
				echo("<option value=$otoi2[0]>$otoi2[0]</option>");
							
				?>
          </select>
          </td>
          <td><label for="lembaga"></label>
            <input type="text" name="lembaga" id="lembaga" />
              <script type="text/javascript">
	$(document).ready(function(){
		$( "#jurusan" ).autocomplete({
			source: function( request, response ) {
				$.ajax({
					  url: "prosesj.php",
					  dataType: "json",
					  data: {
					    q: request.term,
						ins: document.getElementById('lembaga').value,
					    kategori: $("#lembaga").val()
					  },
					  success: function( data,ui ) {
					    response( data );
						
					  }
				});
			},
			
			minLength: 1,
			select: function(event, ui) {
        var origEvent = event;
        while (origEvent.originalEvent !== undefined)
            origEvent = origEvent.originalEvent;
        if (origEvent.type == 'keydown')
            { $("#jurusan").click();
			
			
			
			}
    }

		});
		
		
		$( "#lembaga" ).autocomplete({
			source: function( request, response ) {
				$.ajax({
					  url: "prosesi.php",
					  dataType: "json",
					  data: {
					    q: request.term
					  },
					  success: function( data ) {
					    response( data );
					  }
				});
			},
			
			minLength: 1,
			select: function(event, ui) {
        var origEvent = event;
        while (origEvent.originalEvent !== undefined)
            origEvent = origEvent.originalEvent;
        if (origEvent.type == 'keydown')
            { $("#lembaga").click();
			
			
			}
    }

		});
		
	});
	</script>
            
            </td>
          <td><input type="text" name="jurusan" id="jurusan" /></td>
          <td> <select name="bidang" id="bidang" ">
            <?php
			$qbid=mysqli_query($con,"select * from bidang_pendidikan order by bidang");
			while($bid=mysqli_fetch_array($qbid))
			echo ("<option value=$bid[0]>$bid[1]</option>");
			
			?>
            </select></td>
          <td><input type="text" name="lulusan" id="lulusan" /></td>
        </tr>
      </table>
  </div>
      
  </div>
</div>
     </form>
<script type="text/javascript">
var TabbedPanels1 = new Spry.Widget.TabbedPanels("TabbedPanels1");
</script>
