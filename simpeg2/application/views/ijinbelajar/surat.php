<html>
	<head>
		<style type="text/css">
		.kecil {
			font-size: 12px;
			margin-left: 0px;
			margin-top: 0px;
			margin-right: 0px;
			margin-bottom: 0px;
		}
		.sedang{
			font-size: 14px;
		}
		body {
			font-size: 12px;
			margin-left: 0px;
			margin-top: 0px;
			margin-right: 0px;
			margin-bottom: 0px;		

		}
		ol, li {
			margin: 0;
			margin-left: 8px;
			margin-right: 0px;
			padding: 0;
		}
		</style>
	</head>
	<body >
<style type="text/css">

</style>
<table width="95%" border="0" align="center" cellpadding="0" cellspacing="0" class="kecil">
	
  <tr>
    <td colspan="5" align="center" >
      <table width="100%" border="0" cellspacing="0" cellpadding="0" margin="0">  
        <tr>
          <td align="center"><img src="<?php echo base_url()."images/Logo_Kota_BW.jpg" ?>" width="90" /></td>
          <td align="center" >
				<span style="font-size:20px; font-weight:bold;">PEMERINTAH KOTA BOGOR</span><br>
				<span style="font-size:32px; font-weight:bold;">SEKRETARIAT DAERAH</span> <br>
				Jl. Ir. H. Juanda No. 10 Telp. (0251) 8321075 Fax. (0251) 8326530<br>
				B O G O R  - 16121</td>
        </tr>
      </table>
      <hr style="border:solid 2px black;">
   </td>
  </tr> 
	<tr>
		<td colspan="6">&nbsp;<br/>&nbsp;<br></td>
	</tr>
	<tr>
		<td width="5%">&nbsp;</td><!-- border kiri -->
		<td width="88%" align="center" colspan="4" >
			<span style="text-decoration:underline; "><strong>S U R A T &nbsp;&nbsp;I Z I N</strong><br> 
			</span>
				<div style="padding-top:5px;"> 
					Nomor : 890/&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-BKPP
				</div>
				<div style="padding-top:5px;"> 
					TENTANG
				</div>
				<div style="padding-top:5px;">
					<B>IZIN MENGIKUTI PENDIDIKAN</B>
				</div>		<br>
		</td>
			
		<td width="7%">&nbsp;</td><!-- border kanan -->
	</tr>   
    <tr>
		<td align="left" width="5%">&nbsp;</td>
		<td width="7%" valign="top">Dasar</td>
		<td width="1px" valign="top">&nbsp;:&nbsp;</td>		
		<td colspan="2" style="text-align:justify" cellpadding="0" cellspacing="0">
			<ol>
				<li>
					Surat Edaran Menteri Pendayagunaan Aparatur Negara dan Reformasi Birokrasi Nomor 04 Tahun 2013 tentang Pemberian Tugas Belajar dan Izin Belajar Bagi Pegawai Negeri Sipil;
				</li>			
				<li>
					Peraturan Walikota Bogor Nomor 2 Tahun 2012 tentang Pemberian Izin Belajar, Tugas Belajar dan Kenaikan Pangkat Penyesuaian Ijazah Bagi Pegawai Negeri Sipil di Lingkungan Pemerintah Kota Bogor;				
				</li>
				<li>
					Surat Edaran Walikota Bogor Nomor 890/1994 - BKPP tentang Pemberian Tugas Belajar dan Izin Belajar Bagi Pegawai Negeri Sipil di Lingkungan Pemerintah Kota Bogor;
				</li>
				<li>
					Surat  <?php echo $no; ?> 
				</li>
			</ol>
		</td>
    </tr>  
       
    
  <tr>
    <td>&nbsp;</td>
    <td align="center" colspan="4" class="sedang"><strong><br>MEMBERI IZIN :<br></strong></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>   
    <tr>
		  <td>&nbsp;</td>
		<td>&nbsp;</td>
		<td></td>
        <td>Kepada</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
		<td>&nbsp;</td>
		<td></td>
        <td>Nama</td>        
        <td>
			<table class="kecil" ><tr><td valign="top">:</td><td valign="top">
			<?php echo "<span style='font-weight:bold;'>".trim($detail->gelar_depan." ".strtoupper($detail->nama)." ".$detail->gelar_belakang)."</span>"; ?>
			</td></tr></table>
		</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
		<td>&nbsp;</td>
		<td></td>
        <td>NIP</td>        
        <td colspan="2">
			<table class="kecil" ><tr><td valign="top">:</td><td valign="top">
				<?php echo $detail->nip_baru; ?>
			</td></tr></table>
		</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
		<td>&nbsp;</td>
		<td></td>
        <td nowrap="nowrap">Pangkat/Gol. Ruang</td>        
        <td colspan="2">
			<table class="kecil"><tr><td valign="top">:</td><td valign="top">
			<?php echo $detail->pangkat.", ";echo $detail->golongan." "; ?>
			</td></tr></table>
		</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
		<td>&nbsp;</td>
		<td></td>
        <td>Jabatan</td>        
        <td colspan="2">
			<table class="kecil"><tr><td valign="top">:</td><td valign="top">
			<?php if(is_null($detail->id_j)) echo $detail->nama_jfu." "; else echo $detail->jabatan." ";?>
			</td></tr></table>
		</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
		<td>&nbsp;</td>
		<td></td>
        <td valign="top">Untuk</td>        
        <td colspan="2"> 
			
			<table class="kecil"><tr><td valign="top">:</td><td valign="top">
			Mengikuti Pendidikan Program 
			
			<?php
			$tingkat = array("tingkat","S3","S2","S1","D3","D2","D1","SMA","SMP");
			$program = array("tingkat","Doktoral","Pascasarjana","Sarjana","Diploma","Diploma","Diploma","SMA","SMP");
					echo $program[$detail->tingkat_pendidikan];
					echo " ("; 
					echo $tingkat[$detail->tingkat_pendidikan];
					echo ") $detail->jurusan pada $detail->institusi_lanjutan";
			?>
			</td></tr></table>
        </td>
      </tr>
      <tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td></td>
		<td></td>		
		<td colspan="2"><br>Dengan Ketentuan :<br></td>
      </tr>
      <tr>        
        <td>&nbsp;</td>
		<td>&nbsp;</td>
		<td></td>
        <td>&nbsp;</td>
        <td >
        <div align="justify">        
			<ol>
			<li>Izin Mengikuti pendidikan diberikan di luar jam kerja; </li>
			<li>Tidak mengganggu tugas kedinasan; </li>
			<li>Biaya ditanggung sepenuhnya oleh yang bersangkutan; </li>
			<li>Tidak akan menuntut penyesuaian ijazah, kecuali formasi mengizinkan; </li>
			<li>Wajib membuat laporan kemajuan pendidikan paling kurang 1 (satu) kali setiap tahunnya dan setelah menyelesaikan wajib melaporkan hasilnya 
				kepada Sekretaris Daerah Kota Bogor melalui Badan Kepegawaian, Pendidikan dan Pelatihan Kota Bogor 
				dengan menunjukkan Ijazah/Surat Tanda Tamat Belajar dari <?php echo " $detail->institusi_lanjutan"; ?>. 
			</li>
			</ol>
        </div>
        </td>
        <td>&nbsp;</td>
     </tr>    
	<tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td></td>
		<td>&nbsp;</td>
		<td align="right" valign="top" ><br>
		<table width="300" border="0" cellspacing="0" cellpadding="0" class="kecil">
		  <tr>
			<td >Ditetapkan di Bogor</td>
		  </tr>
		  <tr>
			<td >pada tanggal :</td>
		  </tr>
		  <tr>
			<td align="center" >SEKRETARIS DAERAH,</td>
		  </tr>
		  <tr>
			<td height="70" align="center">
				<!--img src="<?php //echo base_url()."images/ttd-sekda.jpg" ?>" width="150" /-->
			</td>
		  </tr>
		  <tr>
			<td align="center">
				<span style="text-decoration:underline;" >
					<strong>Drs. H. ADE SARIP HIDAYAT, M.Pd</strong>
				</span>
			</td>
		  </tr>
		  <tr>
			<td align="center">Pembina Utama Muda</td>
		  </tr>
		  <tr>
			<td align="center">NIP. 196009101980031003</td>
		  </tr>
		</table>
		</td>    	
	</tr>
	<tr>
		<td></td>
		<td colspan="6" style=" font-size:11px;" >Tembusan :</td>		
	</tr>
	<tr>
		<td></td>
		<td colspan="6" style=" font-size:11px;">
			<ol style="padding:0px;">
				<li> Yth. Bapak Walikota Bogor (Sebagai Laporan);</li>
				<li> Yth. <?php echo $bos; ?></li>
				<li> Yth. Direktur Program <?php echo $program[$detail->tingkat_pendidikan]." ".$detail->institusi_lanjutan; ?></li>
			</ol> 
		</td>
	</tr>
</table>
</body>
</html>
