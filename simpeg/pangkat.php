<?php include "kp_navbar.php"; ?> 
<?php
	$currentFile = $_SERVER["REQUEST_URI"];
    $parts = Explode('/', $currentFile);
    $fallback_url = $parts[count($parts) - 1];
	$isComplete = "true";
?>
<style type="text/css">
<!--
.style2 {color: #FFFFFF}
-->
</style>

<!--
<div class="alert alert-error">
	<strong>Perhatian!</strong> 
	Halaman ini masih dalam proses pembangunan. Semua aktivitas yang anda lakukan dalam halaman ini bukan menjadi tanggung jawab tim SIMPEG Kota Bogor.
</div>
-->

<div>
<?

//cek naik pangkat terakhir menggunakan SK Pangkat terakhir
$qKP = "SELECT 
			tmt AS tmt_pangkat_terakhir, 
			DATE_ADD( tmt, INTERVAL 4 YEAR ) AS tmt_pangkat_berikutnya, 
			DATE_SUB( DATE_ADD( tmt, INTERVAL 4 YEAR ) , INTERVAL 5 MONTH ) AS tanggal_notifikasi
		FROM sk s
		WHERE s.id_pegawai = $_SESSION[id_pegawai]
		AND id_kategori_sk =5
		ORDER BY tmt DESC 
		LIMIT 0 , 1";

$rsKp = mysqli_query($mysqli,$qKP);


//------------------> CARI TMT KENAIKAN PANGKAT BERIKUTNYA
$tmt_pangkat_berikutnya;
$tanggal_notifikasi;
if($rkp = mysqli_fetch_array($rsKp))
{
	
	$tmt_pangkat_berikutnya = $rkp[tmt_pangkat_berikutnya];
	$tanggal_notifikasi = $rkp[tanggal_notifikasi]; 
}
else //-------------> Kalau tidak ada SK kenaikan pangkat gunakan SK CPNS kemungkinan KP untk pertama kali
{
	$qCpns = "SELECT 
				tmt AS tmt, 
				DATE_ADD( tmt, INTERVAL 4 YEAR ) AS tmt_pangkat_berikutnya, 
				DATE_SUB( DATE_ADD( tmt, INTERVAL 4 YEAR ) , INTERVAL 5 MONTH ) AS tanggal_notifikasi
			 FROM sk s
			 WHERE s.id_pegawai = $_SESSION[id_pegawai]
			 AND id_kategori_sk = 6
			 ORDER BY tmt DESC 
			 LIMIT 0 , 1";
	
	$rsCpns = mysqli_query($mysqli,$qCpns);
	if($rCpns = mysqli_fetch_array($rsCpns))
	{
				
		$tmt_pangkat_berikutnya = $rCpns[tmt_pangkat_berikutnya];
		$tanggal_notifikasi = $rCpns[tanggal_notifikasi]; 
	}
	else 
	{
	//--------------> Kalau tidak ada SK CPNS gunakan NIP baru
		if(strlen($_SESSION[nip_baru]) > 10)
		{
			$tmt_pangkat_berikutnya = (substr($_SESSION[nip_baru], 8,4)+4)."-".substr($_SESSION[nip_baru], 9,2)."-01";
			$tanggal_notifikasi = (substr($_SESSION[nip_baru], 8,4)+4)."-".(substr($_SESSION[nip_baru], 9,2)-4)."-01";		
		}
		else 
		{
			//--------------> Kalau tidak ada nip baru, tampilkan notifikasi error, harus melengkapi berkas melalui tim SIMPEG
			?>
			<script type="text/javascript">alert('Data SK CPNS, SK Kenaikan Pangkat Terakhir dan NIP v Baru tidak ditemukan')</script>
			<?php	
		}	
	}// 	End of menggunakan NIP baru
}
//------------------> END OF CARI TMT KENAIKAN PANGKAT BERIKUTNYA

$dapatMengajukan = false;
$tanggal_notifikasi = date_create_from_format("Y-m-d", $tanggal_notifikasi);
$tanggal_sekarang = date_create_from_format("Y-m-d", date("Y-m-d"));
?>
<!-- MENULIS NOTIFIKASI TENTANG KENAIKAN PANGKAT -->
<div class='alert alert-warning'>
	Anda berhak memperoleh kenaikan pangkat berikutnya pada periode <strong><?php echo $tmt_pangkat_berikutnya; ?></strong>. 	
	<?php if($tanggal_sekarang >= $tanggal_notifikasi): ?>
		<?php 
		// --------------> CEK APAKAH SUDAH MENGAJUKAN
		$qPengajuan = "SELECT * FROM pengajuan WHERE id_pegawai = $_SESSION[id_pegawai] AND id_proses = 1";
		$rsPengajuan = mysqli_query($mysqli,$qPengajuan);
		?>
		<?php if($pengajuan = mysqli_fetch_array($rsPengajuan)): ?>
		
			Pengajuan kenaikan pangkat anda telah kami terima pada tanggal <?php echo $pengajuan[tgl_pengajuan] ?>. Kami akan melakukan verifikasi terhadap berkas pengajuan anda kemudian menghubungi anda setelah SK Kenaikan pangkat anda kami cetak. Terimakasih.
		
		<?php else: ?> 
		
			Anda sudah dapat mengajukan proses Kenaikan Pangkat. Silahkan klik tombol proses.		
			<br/>
			<form action="process_add_pengajuan.php"  method="post">
				<input type="hidden" name="id_proses" value="1"/>
				<input type="hidden" name="tmt_proses" value="<?php echo $tmt_pangkat_berikutnya; ?>"/>	
				<input type="hidden" name="fallback_url" value="<?php echo "http://".$_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"]; ?>" />	
				<input id="btn_process" type="submit" class='btn btn-success btn-large' value="Proses">
			</form>
		
		<?php endif; ?>		
	<?php else: ?>	
		Anda baru dapat mengajukan kenaikan pangkat secepat-cepatnya lima bulan sebelum periode tersebut.
	<?php endif; ?>
</div>

</div>

<table width="500" border="0" align="center" cellpadding="5" cellspacing="0">
  
 
  <tr>
    <td nowrap="nowrap">
  
    	<div class="well">
          <div align="center" class="content_header">PERSYARATAN PENGAJUAN KENAIKAN PANGKAT</div>
    <ol>
    <li>
     <?php
      	// CEK CPNS	
		$rsCpns = mysqli_query($mysqli,"SELECT s.id_sk, id_berkas, p.nip_baru,pangkat_gol,p.id_j
							   FROM sk s 
							   INNER JOIN pegawai p ON s.id_pegawai = p.id_pegawai
							   WHERE s.id_pegawai = $ata[id_pegawai] 
							   	AND s.id_kategori_sk = 6
							   LIMIT 0,1");
							 
							 
		$rCpns = mysqli_fetch_array($rsCpns);
		if(mysqli_num_rows($rsCpns) > 0)
		{					
			$fileName = "Berkas/".$_SESSION[nip_baru]."-".$rCpns[id_berkas]."-*.jpg";					
			$files = glob($fileName);
				
			$cpns = "";
			
			if(count($files) > 0)
			{		
			?>
				<div align="justify">Photo Copy SK CPNS <span class="label label-success">Lengkap</span>
			<?php
			}
			else
			{
				$isComplete = "false";
				?> 
				<div align="justify" style="color:orange">Photo Copy SK CPNS <scpan class="label label-warning">Belum lengkap</scpan> <br/>				
				<a class="btn btn-mini" href="index2.php?x=add_sk.php&id_sk=<?php echo $rCpns[id_sk]; ?>&upload_only=true&id_kategori_sk=6&id_kategori_berkas=2&nm_berkas=SK CPNS&fallback_url=<?php echo $fallback_url; ?>">Upload</a>
				<?php
			}
		}		
		else 
		{
			$isComplete = "false";
			?>
			<div align="justify" style="color:red">Photo Copy SK CPNS <span class="label label-important">Tidak ada</span> 
			<br/>
			<a class="btn btn-warning btn-mini" href="index2.php?x=add_sk.php&id_kategori_sk=6&id_kategori_berkas=2&nm_berkas=SK CPNS&fallback_url=<?php echo $fallback_url; ?>">Entri</a>
			<?php
		}		
		?>
</li>
<li>
  <?
	   //cek berkas naik pangkat
	   $qsk = mysqli_query($mysqli,"select sk.keterangan, sk.id_berkas, sk.id_sk, pegawai.pangkat_gol 
	   					   from sk 
	   					   inner join pegawai on pegawai.id_pegawai = sk.id_pegawai
	   					   where sk.id_pegawai=$_SESSION[id_pegawai] and sk.id_kategori_sk = 5 order by tmt desc ");
						   		
	   $sk=mysqli_fetch_array($qsk);	   
	   $banding=explode(",",$sk[0]);
	   //print_r($banding);	   
	   if($banding[0]==$sk[pangkat_gol])
	   {
	   if($sk[1]>0)
	   {
	   ?>
       	<div align="justify">Photo Copy SK kenaikan pangkat terakhir <span class="label label-success">Lengkap</span></li>
        <?
	   }
	   else
	   {
	   	$isComplete = "false";
		?>
    	<div align="justify" style="color:orange">Photo Copy SK kenaikan pangkat terakhir <scpan class="label label-warning">Belum lengkap</scpan> <br/>				
				<a class="btn btn-mini" href="index2.php?x=add_sk.php&id_sk=<?php echo($sk[2]); ?>&upload_only=true&id_kategori_sk=6&id_kategori_berkas=2&nm_berkas=SK CPNS&fallback_url=<?php echo $fallback_url; ?>">Upload</a>                         
        <?php
	   }
		}
		else
		{
			$isComplete = "false";
		?>
        
        <div align="justify" style="color:red">Photo Copy SK kenaikan pangkat terakhir  <span class="label label-important">Tidak ada</span> 
			<br/>
			<a class="btn btn-warning btn-mini" href="index2.php?x=add_sk.php&id_kategori_sk=5&id_kategori_berkas=2&nm_berkas=SK kenaikan pangkat&fallback_url=<?php echo $fallback_url; ?>">Entri</a>        
        <?
		}
		?>
		</li>
        <?php
        // ----------- END OF KENAIKAN PANGKAT -----------------
        
		//cek karpeg
		$qck=mysqli_query($mysqli,"select count(*) from berkas where id_pegawai=$_SESSION[id_pegawai] and id_kat=10");
		//echo "select count(*) from berkas where id_pegawai=$_SESSION[id_pegawai] and id_kat=10";
		$ceka=mysqli_fetch_array($qck);
		
		if($ceka[0]>0)
		  {
	   ?>
       	<li><div align="justify">Photo Copy Kartu Pegawai <span class="label label-success">Lengkap</span></li>
        <?
		}
		else
		{
			$isComplete = "false";
		?>         
      	<li>
      		<div align="justify" style="color:orange">Photo Copy Kartu Pegawai <scpan class="label label-warning">Belum lengkap</scpan> <br/>				
			<a class="btn btn-mini" href="index2.php?x=add_karpeg.php&id_sk=<?php echo($sk2[2]); ?>&upload_only=true&id_kategori_berkas=10&nm_berkas=Kartu pegawai&fallback_url=<?php echo $fallback_url; ?>">Upload</a>   
        </li>
        <?
		}
		?>
       
      


	  <li>
        <?php
      	// CEK DP3	      
		$qDp3 = "SELECT d.id_berkas, d.id
				 FROM dp3 d				 
				 WHERE d.id_pegawai = $ata[id_pegawai] AND
				 d.tahun = (LEFT(CURDATE(),4)-1)
				 LIMIT 0,1";		 
						 
		$rsDp3 = mysqli_query($mysqli,$qDp3);
		if(mysqli_num_rows($rsDp3)>0)
		{
			$rDp3 = mysqli_fetch_array($rsDp3);
						
			$fileName = "Berkas/".$_SESSION[nip_baru]."-".$rDp3[id_berkas]."-*.jpg";		
			
			$files = glob($fileName);
				
			$kgb = "";
			
			if(count($files) > 0)
			{		
			?>
				<div align="justify">Photo Copy DP3 Tahun <?php echo (date("Y")-1); ?> <span class="label label-success">Lengkap</span>
			<?php
			}
			else
			{
				?> 
				<div align="justify" style="color:orange">Photo Copy DP3 Tahun <?php echo (date("Y")-1); ?> <scpan class="label label-warning">Belum lengkap</scpan> <br/>				
				<a class="btn btn-mini" href="index2.php?x=add_dp3.php&id_dp3=<?php echo $rDp3[id]; ?>&upload_only=true&id_kategori_berkas=20&nm_berkas=DP3&fallback_url=<?php echo $fallback_url; ?>">Upload</a>
				<?php
			}
		}		
		else 
		{
			?>
			<div align="justify" style="color:red">Photo Copy DP3 Tahun <?php echo (date("Y")-1); ?> <span class="label label-important">Tidak ada</span> 
			<br/>
			<a class="btn btn-warning btn-mini" href="index2.php?x=add_dp3.php&id_kategori_berkas=20&nm_berkas=DP3&tahun=<?php echo date('Y')-1; ?>&fallback_url=<?php echo $fallback_url; ?>">Entri</a>
			<?php
		}				
		?>      	      
      </div>      
	  </li>


	  <li>
        <?php
      	// CEK DP3 2 TAHUN YANG LALU    
		$qDp3 = "SELECT d.id_berkas, d.id
				 FROM dp3 d				 
				 WHERE d.id_pegawai = $ata[id_pegawai] AND
				 d.tahun = (LEFT(CURDATE(),4)-2)
				 LIMIT 0,1";		 
						 
		$rsDp3 = mysqli_query($mysqli,$qDp3);
		if(mysqli_num_rows($rsDp3)>0)
		{
			$rDp3 = mysqli_fetch_array($rsDp3);
						
			$fileName = "Berkas/".$_SESSION[nip_baru]."-".$rDp3[id_berkas]."-*.jpg";		
			
			$files = glob($fileName);
				
			$kgb = "";
			
			if(count($files) > 0)
			{		
			?>
				<div align="justify">Photo Copy DP3 Tahun <?php echo (date("Y")-2); ?> <span class="label label-success">Lengkap</span>
			<?php
			}
			else
			{
				?> 
				<div align="justify" style="color:orange">Photo Copy DP3 Tahun <?php echo (date("Y")-2); ?> <scpan class="label label-warning">Belum lengkap</scpan> <br/>				
				<a class="btn btn-mini" href="index2.php?x=add_dp3.php&id_dp3=<?php echo $rDp3[id]; ?>&upload_only=true&id_kategori_berkas=20&nm_berkas=DP3&fallback_url=<?php echo $fallback_url; ?>">Upload</a>
				<?php
			}
		}		
		else 
		{
			?>
			<div align="justify" style="color:red">Photo Copy DP3 Tahun <?php echo (date("Y")-2); ?> <span class="label label-important">Tidak ada</span> 
			<br/>
			<a class="btn btn-warning btn-mini" href="index2.php?x=add_dp3.php&id_kategori_berkas=20&nm_berkas=DP3&tahun=<?php echo date('Y')-2; ?>&fallback_url=<?php echo $fallback_url; ?>">Entri</a>
			<?php
		}				
		?>      	      
      </div>      
	  </li>





       
       
       <li>STTPL (* untuk kenaikan pangkat pertama kali atau Penyesuaian Ijazah)      </li>
       
     
     
      <li>
        <div align="justify">Photo Copy Ijazah Berlegalisir Cap Basah (* untuk Penyesuaian Ijazah atau Penyesuaian Pendidikan)      </div>
      </li>
      
      <li>
        <div align="justify">Photo Copy SK Alih Tugas Terakhir (* Jika Ada)</div>
      </li>
       <li>
        <div align="justify">Photo Copy Uraian Tugas (* Untuk Penyesuaian Ijazah)</div>
      </li>
    
       <?
	   //cek berkas mutasi jabatan
	   if($rCpns[4]>0)
	   {
	   $qsk2=mysqli_query($mysqli,"select keterangan,id_berkas,sk.id_sk,id_j from sk where id_pegawai=$ata[id_pegawai] and id_kategori_sk=10 order by tmt desc");
	      $sk2=mysqli_fetch_array($qsk2);
	   
	   if($rCpns[4]==$sk2[3])
	   {
	   if($sk2[1]>0)
	  {
	  ?>
	  	<li><div align="justify">Photo Copy SK Jabatan terakhir  <span class="label label-success">Lengkap</span></li>
	  <?
	  }
	   else
	   {
	  ?>
      
      <li> <div align="justify" style="color:orange">Photo Copy SK Jabatan terakhir <scpan class="label label-warning">Belum lengkap</scpan> <br/>				
				<a class="btn btn-mini" href="index2.php?x=add_sk.php&id_sk=<?php echo($sk2[2]); ?>&upload_only=true&id_kategori_sk=6&id_kategori_berkas=2&nm_berkas=SK CPNS&fallback_url=<?php echo "http://".$_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"]; ?>">Upload</a>   
                </li>
      <?
	   }	   
	   }
	   }	   
	   ?>
     
    </ol>
    </div>
    </div>
    </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>

<script type="text/javascript">
	$("#btn_process").click(function(date){
		if(!<?php echo $isComplete; ?>)
		{
			alert('Silahkan lengkapi persyaratan anda terlebih dahulu.');
			return false;
		}
	});
</script>