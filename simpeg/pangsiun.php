<?php
$idp=$_SESSION['id_pegawai'];
extract($_POST);

if($jenis=='bup')
{
?>
<form action="index3.php" method="post" enctype="multipart/form-data" name="form1" id="form1">
  <table width="80%" border="0" align="center" id="pensiun" class="row-border" >
    <tr>
      <td colspan="3" align="center">PENSIUN REGULER</td>
    </tr>
    <tr>
      <td width="74%">SK CPNS</td>
      <td width="2%">:</td>
      <td width="24%"><label for="cpns"></label>
      
      <?php
		
		$uploaddir = '/var/www/html/simpeg/berkas/';
                $connection = ssh2_connect('103.14.229.15');
                ssh2_auth_password($connection, 'rommonz', 'mony3Tmony3T');
                $sftp = ssh2_sftp($connection);
				
	  $qcpns=mysqli_query($mysqli,"select id_berkas from sk where id_kategori_sk=6 and id_pegawai=$idp");
	  $cpns=mysqli_fetch_array($qcpns);
	  if(is_numeric($cpns[0]) && $cpns[0]>0 )
	  {
		  
		$qbcpns=mysqli_query($mysqli,"select file_name from isi_berkas where id_berkas=$cpns[0]");
		$bcpns=mysqli_fetch_array($qbcpns);
	
                if (file_exists('ssh2.sftp://' . $sftp . '/var/www/html/simpeg/berkas/'.$bcpns[0])) {
                    echo("File sudah tersedia <a target=_blank href=https://arsipsimpeg.kotabogor.go.id/simpeg/berkas/$bcpns[0] >[Preview] </a>");
					
                }
				else
					echo(" <input type=file name=cpns id=cpns >");
                 
	  }
	  else
	  {
	  
	  ?>
      <input type="file" name="cpns" id="cpns" />
      <?php
	  }
	  ?>
      </td>
    </tr>
    <tr>
      <td>SK PNS</td>
      <td>:</td>
      <td>
      
        <?php
	
	  $qpns=mysqli_query($mysqli,"select id_berkas from sk where id_kategori_sk=7 and id_pegawai=$idp");
	  $pns=mysqli_fetch_array($qpns);
	  if(is_numeric($pns[0]) && $pns[0]>0 )
	  {
		  
		$qbpns=mysqli_query($mysqli,"select file_name from isi_berkas where id_berkas=$pns[0]");
		$bpns=mysqli_fetch_array($qbpns);
		
	
                if (file_exists('ssh2.sftp://' . $sftp . '/var/www/html/simpeg/berkas/'.$bpns[0])) {
                    echo("File sudah tersedia <a target=_blank href=https://arsipsimpeg.kotabogor.go.id/simpeg/berkas/$bpns[0] >[Preview] </a>");
					
                }
				else
					echo(" <input type=file name=pns id=pns >");
                 
	  }
	  else
	  {
	  
	  ?>
      <input type="file" name="pns" id="pns" />
      <?php } ?></td>
    </tr>
    <tr>
      <td>SK Kenaikan Pangkat Terakhir</td>
      <td>:</td>
      <td>
      
         <?php
	
	  $qpang=mysqli_query($mysqli,"select id_berkas,gol from sk where id_kategori_sk=5 and id_pegawai=$idp order by tmt desc");
	  $qgol=mysqli_query($mysqli,"select pangkat_gol from pegawai where id_pegawai=$idp");
	  $gol=mysqli_fetch_array($qgol);
	  $pang=mysqli_fetch_array($qpang);
	  if(is_numeric($pang[0]) && $pang[0]>0 && $pang[1]==$gol[0] )
	  {
		  
		$qbpang=mysqli_query($mysqli,"select file_name from isi_berkas where id_berkas=$pang[0]");
		$bpang=mysqli_fetch_array($qbpang);
		
		
                if (file_exists('ssh2.sftp://' . $sftp . '/var/www/html/simpeg/berkas/'.$bpang[0])) {
                    echo("File sudah tersedia <a target=_blank href=https://arsipsimpeg.kotabogor.go.id/simpeg/berkas/$bpang[0] >[Preview] </a>");
					
                }
				else
					echo(" <input type=file name=kp id=kp >");
                 
	  }
	  else
	  {
	  
	  ?>
      <input type="file" name="kp" id="kp" />
      <?php
	  }
	  ?>
      </td>
    </tr>
    <tr>
      <td>SK Kenaikan Gaji Berkala Terakhir</td>
      <td>:</td>
      <td>
      
            <?php
	
	  $qkgb=mysqli_query($mysqli,"select id_berkas from sk where id_kategori_sk=9 and id_pegawai=$idp order by tmt desc");
	  $kgb=mysqli_fetch_array($qkgb);
	  if(is_numeric($kgb[0]) && $kgb[0]>0 )
	  {
		  
		$qbkgb=mysqli_query($mysqli,"select file_name from isi_berkas where id_berkas=$kgb[0]");
		$bkgb=mysqli_fetch_array($qbkgb);
		
	
                if (file_exists('ssh2.sftp://' . $sftp . '/var/www/html/simpeg/berkas/'.$bkgb[0])) {
                    echo("File sudah tersedia <a target=_blank href=https://arsipsimpeg.kotabogor.go.id/simpeg/berkas/$bkgb[0] >[Preview] </a>");
					
                }
				else
					echo(" <input type=file name=kgb id=kgb >");
                 
	  }
	  else
	  {
	  
	  ?>
      <input type="file" name="kgb" id="kgb" />
      <?php
	  }
	  ?>
      </td>
    </tr>
    <tr>
      <td>SKP Tahun Terakhir</td>
      <td>:</td>
      <td><input type="file" name="skp" id="skp" /></td>
    </tr>
    <tr>
      <td>SKP 2 Tahun Terakhir</td>
      <td>:</td>
      <td><input type="file" name="skp2" id="skp2" /></td>
    </tr>
    <tr>
      <td>KTP</td>
      <td>:</td>
      <td><input type="file" name="ktp" id="ktp" /></td>
    </tr>
    <tr>
      <td>SKUM - PTK</td>
      <td>:</td>
      <td><input type="file" name="skumptk" id="skumptk" /></td>
    </tr>
    <tr>
      <td>KK</td>
      <td>:</td>
      <td><input type="file" name="kk" id="kk" /></td>
    </tr>
    <tr>
      <td>Pas Photo (3x4)</td>
      <td>:</td>
      <td><input type="file" name="pasfoto" id="pasfoto" /></td>
    </tr>
    <tr>
      <td>Daftar Susunan Keluarga (dari camat)</td>
      <td>:</td>
      <td><input type="file" name="dsk" id="dsk" /></td>
    </tr>
    <tr>
      <td>Akta Nikah</td>
      <td>:</td>
      <td><input type="file" name="aktanikah" id="aktanikah" /></td>
    </tr>
    <tr>
      <td>Akta Kelahiran Anak &lt;25 Tahun yang belum bekerja dan belum </td>
      <td>:</td>
      <td><input type="file" name="aktakelahiran" id="aktakelahiran" /></td>
    </tr>
    <tr>
      <td>Peninjauan Masa Kerja </td>
      <td>:</td>
      <td><input type="file" name="pmk" id="pmk" /></td>
    </tr>
    <tr>
      <td>SK Jabatan Terakhir</td>
      <td>:</td>
      <td>
       <?php
	
	  $qjab=mysqli_query($mysqli,"select id_berkas from sk where id_kategori_sk=10 and id_pegawai=$idp order by tmt desc");
	  $jab=mysqli_fetch_array($qjab);
	  if(is_numeric($jab[0]) && $jab[0]>0 )
	  {
		  
		$qbjab=mysqli_query($mysqli,"select file_name from isi_berkas where id_berkas=$jab[0]");
		$bjab=mysqli_fetch_array($qbjab);
		
	
                if (file_exists('ssh2.sftp://' . $sftp . '/var/www/html/simpeg/berkas/'.$bjab[0])) {
                    echo("File sudah tersedia <a target=_blank href=https://arsipsimpeg.kotabogor.go.id/simpeg/berkas/$bjab[0] >[Preview] </a>");
					
                }
				else
					echo(" <input type=file name=jabatan id=jabatan >");
                 
	  }
	  else
	  {
	  
	  ?>
      
      <input type="file" name="jabatan" id="jabatan" />
      <?php
	  
	  }
	  ?>
      </td>
    </tr>
    <tr>
      <td>Daftar Riwayat Pekerjaan</td>
      <td>:</td>
      <td><input type="file" name="riwayat" id="riwayat" /></td>
    </tr>
    <tr>
      <td>Surat tidak pernah dijatuhi hukuman disiplin dan surat tidak sedang dipidana (ttd Eselon II)</td>
      <td>:</td>
      <td><input type="file" name="hd" id="hd" /></td>
    </tr>
    <tr>
      <td>Konversi NIP</td>
      <td>:</td>
      <td><input type="file" name="konversi" id="konversi" /></td>
    </tr>
    <tr>
      <td>Kartu Pegawai</td>
      <td>:</td>
      <td>
        <?php
	
	  $qkarpeg=mysqli_query($mysqli,"select id_berkas from berkas where id_kat=10 and id_pegawai=$idp");
	  $karpeg=mysqli_fetch_array($qkarpeg);
	  if(is_numeric($karpeg[0]) && $karpeg[0]>0 )
	  {
		  
		$qbkarpeg=mysqli_query($mysqli,"select file_name from isi_berkas where id_berkas=$karpeg[0]");
		$bkarpeg=mysqli_fetch_array($qbkarpeg);
		
	
                if (file_exists('ssh2.sftp://' . $sftp . '/var/www/html/simpeg/berkas/'.$bkarpeg[0])) {
                    echo("File sudah tersedia <a target=_blank href=https://arsipsimpeg.kotabogor.go.id/simpeg/berkas/$bkarpeg[0] >[Preview] </a>");
					
                }
				else
					echo(" <input type=file name=karpeg id=karpeg >");
                 
	  }
	  else
	  {
	  
	  ?>
      
      <input type="file" name="karpeg" id="karpeg" />
      <?php
	  }
	  ?>
      </td>
    </tr>
    <tr>
      <td><input name="x" type="hidden" id="x" value="ajukan.php" /></td>
      <td>&nbsp;</td>
      <td><input type="submit" name="button" id="button" value="Ajukan" /></td>
    </tr>
  </table>
</form>
<?php
}
elseif($jenis=='mati')
{
?>
<p>&nbsp;</p>
<form id="form2" name="form2" method="post" action="index3.php">
  <table width="80%" border="0" align="center" cellpadding="5" cellspacing="0" id="pensiun" class="row-border">
    <tr>
      <td colspan="3" align="center">PENSIUN MENINGGAL DUNIA</td>
    </tr>
    <tr>
      <td>Surat Permohonan dari instansi ditandatangani oleh kepala</td>
      <td>:</td>
      <td><input type="file" name="permohonan" id="permohonan" /></td>
    </tr>
    <tr>
      <td>Surat Kematian dari kelurahan setempat / Akta Kematian / Visum RS</td>
      <td>:</td>
      <td><input type="file" name="mati" id="mati" /></td>
    </tr>
    <tr>
      <td>Surat Keterangan Duda / Janda dari kelurahan setempat</td>
      <td>:</td>
      <td><input type="file" name="janda" id="janda" /></td>
    </tr>
    <tr>
      <td width="74%">SK CPNS</td>
      <td width="2%">:</td>
      <td width="24%"><label for="cpns2"></label>
        <input type="file" name="cpns2" id="cpns2" /></td>
    </tr>
    <tr>
      <td>SK PNS</td>
      <td>:</td>
      <td><input type="file" name="pns2" id="pns2" /></td>
    </tr>
    <tr>
      <td>SK Kenaikan Pangkat Terakhir</td>
      <td>:</td>
      <td><input type="file" name="kp2" id="kp2" /></td>
    </tr>
    <tr>
      <td>SK Kenaikan Gaji Berkala Terakhir</td>
      <td>:</td>
      <td><input type="file" name="kgb2" id="kgb2" /></td>
    </tr>
    <tr>
      <td>SKP Tahun Terakhir</td>
      <td>:</td>
      <td><input type="file" name="skp3" id="skp3" /></td>
    </tr>
    <tr>
      <td>SKP 2 Tahun Terakhir</td>
      <td>:</td>
      <td><input type="file" name="skp3" id="skp4" /></td>
    </tr>
    <tr>
      <td>KTP</td>
      <td>:</td>
      <td><input type="file" name="ktp2" id="ktp2" /></td>
    </tr>
    <tr>
      <td>SKUM - PTK</td>
      <td>:</td>
      <td><input type="file" name="skumptk2" id="skumptk2" /></td>
    </tr>
    <tr>
      <td>KK</td>
      <td>:</td>
      <td><input type="file" name="kk2" id="kk2" /></td>
    </tr>
    <tr>
      <td>Pas Photo janda / duda almarhum / alamarhumah (4x6)</td>
      <td>:</td>
      <td><input type="file" name="pasfoto2" id="pasfoto2" /></td>
    </tr>
    <tr>
      <td>Daftar Susunan Keluarga (dari camat)</td>
      <td>:</td>
      <td><input type="file" name="dsk2" id="dsk2" /></td>
    </tr>
    <tr>
      <td>Akta Nikah</td>
      <td>:</td>
      <td><input type="file" name="aktanikah2" id="aktanikah2" /></td>
    </tr>
    <tr>
      <td>Akta Kelahiran Anak &lt;25 Tahun yang belum bekerja dan belum </td>
      <td>:</td>
      <td><input type="file" name="aktakelahiran2" id="aktakelahiran2" /></td>
    </tr>
    <tr>
      <td>Peninjauan Masa Kerja </td>
      <td>:</td>
      <td><input type="file" name="pmk2" id="pmk2" /></td>
    </tr>
    <tr>
      <td>SK Jabatan Terakhir</td>
      <td>:</td>
      <td><input type="file" name="jabatan2" id="jabatan2" /></td>
    </tr>
    <tr>
      <td>Daftar Riwayat Pekerjaan</td>
      <td>:</td>
      <td><input type="file" name="riwayat2" id="riwayat2" /></td>
    </tr>
    <tr>
      <td>Surat tidak pernah dijatuhi hukuman disiplin dan surat tidak sedang dipidana (ttd Eselon II)</td>
      <td>:</td>
      <td><input type="file" name="hd2" id="hd2" /></td>
    </tr>
    <tr>
      <td>Konversi NIP</td>
      <td>:</td>
      <td><input type="file" name="konversi2" id="konversi2" /></td>
    </tr>
    <tr>
      <td>Kartu Pegawai</td>
      <td>:</td>
      <td><input type="file" name="karpeg" id="karpeg" /></td>
    </tr>
    <tr>
      <td><input name="x2" type="hidden" id="x2" value="ajukan.php" /></td>
      <td>&nbsp;</td>
      <td><input type="submit" name="button2" id="button2" value="Ajukan" /></td>
    </tr>
  </table>
</form>
<?php
}
else
{
	?>
<p>&nbsp;</p>
<form id="form3" name="form3" method="post" action="index3.php">
  <table width="80%" border="0" align="center" cellpadding="5" cellspacing="0" id="pensiun" class="row-border">
    <tr>
      <td colspan="3" align="center">PENSIUN ATAS PERMINTAAN SENDIRI / PENSIUN DINI</td>
    </tr>
    <tr>
      <td>Surat Permohonan pribadi dan dari kepala Instansi</td>
      <td>:</td>
      <td><input type="file" name="permohonan2" id="permohonan2" /></td>
    </tr>
    <tr>
      <td width="74%">SK CPNS</td>
      <td width="2%">:</td>
      <td width="24%"><label for="cpns3"></label>
        <input type="file" name="cpns3" id="cpns3" /></td>
    </tr>
    <tr>
      <td>SK PNS</td>
      <td>:</td>
      <td><input type="file" name="pns3" id="pns3" /></td>
    </tr>
    <tr>
      <td>SK Kenaikan Pangkat Terakhir</td>
      <td>:</td>
      <td><input type="file" name="kp3" id="kp3" /></td>
    </tr>
    <tr>
      <td>SK Kenaikan Gaji Berkala Terakhir</td>
      <td>:</td>
      <td><input type="file" name="kgb3" id="kgb3" /></td>
    </tr>
    <tr>
      <td>SKP Tahun Terakhir</td>
      <td>:</td>
      <td><input type="file" name="skp4" id="skp5" /></td>
    </tr>
    <tr>
      <td>SKP 2 Tahun Terakhir</td>
      <td>:</td>
      <td><input type="file" name="skp4" id="skp6" /></td>
    </tr>
    <tr>
      <td>KTP</td>
      <td>:</td>
      <td><input type="file" name="ktp3" id="ktp3" /></td>
    </tr>
    <tr>
      <td>SKUM - PTK</td>
      <td>:</td>
      <td><input type="file" name="skumptk3" id="skumptk3" /></td>
    </tr>
    <tr>
      <td>KK</td>
      <td>:</td>
      <td><input type="file" name="kk3" id="kk3" /></td>
    </tr>
    <tr>
      <td>Pas Photo (3x4)</td>
      <td>:</td>
      <td><input type="file" name="pasfoto3" id="pasfoto3" /></td>
    </tr>
    <tr>
      <td>Daftar Susunan Keluarga (dari camat)</td>
      <td>:</td>
      <td><input type="file" name="dsk3" id="dsk3" /></td>
    </tr>
    <tr>
      <td>Akta Nikah</td>
      <td>:</td>
      <td><input type="file" name="aktanikah3" id="aktanikah3" /></td>
    </tr>
    <tr>
      <td>Akta Kelahiran Anak &lt;25 Tahun yang belum bekerja dan belum </td>
      <td>:</td>
      <td><input type="file" name="aktakelahiran3" id="aktakelahiran3" /></td>
    </tr>
    <tr>
      <td>Peninjauan Masa Kerja </td>
      <td>:</td>
      <td><input type="file" name="pmk3" id="pmk3" /></td>
    </tr>
    <tr>
      <td>SK Jabatan Terakhir</td>
      <td>:</td>
      <td><input type="file" name="jabatan3" id="jabatan3" /></td>
    </tr>
    <tr>
      <td>Daftar Riwayat Pekerjaan</td>
      <td>:</td>
      <td><input type="file" name="riwayat3" id="riwayat3" /></td>
    </tr>
    <tr>
      <td>Surat tidak pernah dijatuhi hukuman disiplin dan surat tidak sedang dipidana (ttd Eselon II)</td>
      <td>:</td>
      <td><input type="file" name="hd3" id="hd3" /></td>
    </tr>
    <tr>
      <td>Konversi NIP</td>
      <td>:</td>
      <td><input type="file" name="konversi3" id="konversi3" /></td>
    </tr>
    <tr>
      <td>Kartu Pegawai</td>
      <td>:</td>
      <td><input type="file" name="karpeg2" id="karpeg2" /></td>
    </tr>
    <tr>
      <td><input name="x3" type="hidden" id="x3" value="ajukan.php" /></td>
      <td>&nbsp;</td>
      <td><input type="submit" name="button3" id="button3" value="Ajukan" /></td>
    </tr>
  </table>
</form>
<?php
}
?>
<script>
$(document).ready(function() {
	$('#pensiun').dataTable({
       "dom": 'T<"clear">lfrtip',
        "tableTools": {
            "sSwfPath": "assets/DataTables/extensions/TableTools/swf/copy_csv_xls_pdf.swf"
        }
    });



});
</script>