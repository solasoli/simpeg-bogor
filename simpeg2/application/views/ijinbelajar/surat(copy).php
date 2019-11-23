<html>
	<head>
		<style type="text/css">
		.kecil {
			font-size: 12px;
		}
		.sedang{
			font-size: 14px;
		}
		body {
			margin-left: 0px;
			margin-top: 0px;
			margin-right: 0px;
			margin-bottom: 0px;		

		}
		</style>
	</head>
	<body >
<style type="text/css">

</style>
<table width="95%" border="0" align="center" cellpadding="5" cellspacing="0">
  <tr>
    <td colspan="3" align="center" >
      <table width="100%" border="0" cellspacing="0" cellpadding="0" margin="0">  
        <tr>
          <td align="center"><img src="<?php echo base_url()."images/Logo_Kota_BW.jpg" ?>" width="90" /></td>
          <td align="center"><span style="font-size:20px; font-weight:bold;">PEMERINTAH KOTA BOGOR</span><br>
            <span style="font-size:35px; font-weight:bold;">SEKRETARIAT DAERAH</span> <br>
			Jl. Ir. H. Juanda No. 10 Telp. (0251) 8321075 Fax. (0251) 8326530<br>
			B O G O R  - 16121</td>
        </tr>
      </table>
      <hr style="border:solid 2px black;">
   </td>
  </tr>  
  <tr>
    <td width="5%">&nbsp;</td>
    <td width="88%" align="center" style="font-family:arial, Helvetica, sans-serif;" >
			<span style="text-decoration:underline; font-family:Arial, Helvetica, sans-serif">S U R A T &nbsp;&nbsp;I Z I N <br> 
			</span><div style="font-family:Arial, Helvetica, sans-serif; padding-top:5px;"> 
				Nomor : 890/&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-BKPP</div><div style="padding-top:5px;"> 
					TENTANG
				</div><div style="padding-top:5px;"> <B>IZIN MENGIKUTI PENDIDIKAN</B></div>
    <div>
    <table width="100%" class="kecil">
    <tr>
      <td align="left" valign="top">&nbsp;</td>
      <td align="center" valign="top">&nbsp;</td>
      <td align="left" valign="top">&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
    <td width="8%" align="left" valign="top"> Dasar</td>
    <td width="1%" align="center" valign="top"> :</td>
    <td width="2%" align="left" valign="top"> 1.</td>
    <td width="89%"><div align="justify">Surat Edaran Menteri Pendayagunaan Aparatur Negara dan Reformasi Birokrasi Nomor 04 Tahun 2013 tentang Pemberian Tugas Belajar dan Izin Belajar Bagi Pegawai Negeri Sipil;</div></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="left" valign="top">2.</td>
      <td align="left" valign="top"><div align="justify"> Peraturan Walikota Bogor Nomor 2 Tahun 2012 tentang Pemberian Izin Belajar, Tugas Belajar dan Kenaikan Pangkat Penyesuaian Ijazah Bagi Pegawai Negeri Sipildi Lingkungan Pemerintah Kota Bogor;</div></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="left" valign="top">3.</td>
      <td><div align="justify"> Surat Edaran Walikota Bogor Nomor 890/1994 - BKPP tentang Pemberian Tugas Belajar dan Izin Belajar Bagi Pegawai Negeri Sipil di Lingkungan Pemerintah Kota Bogor;</div></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="left" valign="top">4.</td>
      <td><div align="justify">Surat  <?php echo $no; ?> </div></td>
    </tr>
    
    </table>
    </div></td>
    <td width="7%">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="center" style="font-family:Arial, Helvetica, sans-serif; font-weight:bold" >MEMBERI IZIN</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    
    <td align="center" style="font-family:Arial, Helvetica, sans-serif; font-weight:bold" >
		<table width="100%" border="0" cellpadding="0" cellspacing="0" class="kecil">
      <tr>
        <td width="19%">Kepada</td>
        <td width="2%">&nbsp;</td>
        <td width="79%">&nbsp;</td>
      </tr>
      <tr>
        <td>Nama</td>
        <td>:</td>
        <td style="font-weight:bold;"><?php echo trim($detail->gelar_depan." ".strtoupper($detail->nama)." ".$detail->gelar_belakang); ?></td>
      </tr>
      <tr>
        <td>NIP</td>
        <td>:</td>
        <td><?php echo $detail->nip_baru; ?></td>
      </tr>
      <tr>
        <td nowrap="nowrap">Pangkat/Gol. Ruang</td>
        <td>:</td>
        <td><?php echo $detail->pangkat.", ";echo $detail->golongan." "; ?></td>
      </tr>
      <tr>
        <td>Jabatan</td>
        <td>:</td>
        <td><?php if($detail->id_j==0) echo $detail->nama_jfu." "; else echo $detail->jabatan." "; ?></td>
      </tr>
      <tr>
        <td valign="top">Untuk</td>
        <td valign="top">:</td>
        <td >Mengikuti Pendidikan Program 
        
        <?php
		$tingkat = array("tingkat","S3","S2","S1","D3","D2","D1","SMA","SMP");
		$program = array("tingkat","Doktoral","Pascasarjana","Sarjana","Diploma","Diploma","Diploma","SMA","SMP");
				echo $program[$detail->tingkat_pendidikan];
				echo " ("; 
				echo $tingkat[$detail->tingkat_pendidikan];
				echo ") $detail->jurusan pada $detail->institusi_lanjutan";
		?>
        </td>
      </tr>
      <tr>
		<td></td>
		<td></td>
		<td><br>Dengan Ketentuan :<br></td>
      </tr>
      <tr>        
        <td>&nbsp;</td>
        <td colspan="2">
        <div align="justify">        
			<ol>
			<li>Izin Mengikuti pendidikan diberikan di luar jam kerja; </li>
			<li>Tidak mengganggu tugas kedinasan; </li>
			<li>Biaya ditanggung sepenuhnya oleh yang bersangkutan; </li>
			<li>Tidak akan menuntut penyesuaian ijazah, kecuali formasi mengizinkan; </li>
			<li>Wajib membuat laporan kemajuan pendidikan paling kurang 1 (satu) kali setiap tahunnya dan setelah menyelesaikan wajib melaporkan hasilnya 
				kepada Sekretaris Daerah Kota Bogor melalui Badan Kepegawaian, Pendidikan dan Pelatihan Kota Bogor 
				dengan menunjukkan Ijazah/Surat Tanda Tamat Belajar dari <?php echo " $detail->institusi_lanjutan"; ?>. </li>
			</ol>
        </div>
        </td>
      </tr>
    </table></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="right" valign="top" style="font-family:Arial, Helvetica, sans-serif; " >
		<table width="300" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td class="kecil">Ditetapkan di Bogor</td>
      </tr>
      <tr>
        <td class="kecil">pada tanggal</td>
      </tr>
      <tr>
        <td align="center" class="sedang">SEKRETARIS DAERAH,</td>
      </tr>
      <tr>
        <td height="70" align="center">&nbsp;</td>
      </tr>
      <tr>
        <td align="center">
			<span style="text-decoration:underline; font-weight:bold;" class="sedang">Drs. H. ADE SARIP HIDAYAT, M.Pd</span></td>
      </tr>
      <tr>
        <td align="center" class="sedang">Pembina Utama Muda</td>
      </tr>
      <tr>
        <td align="center" class="sedang">NIP. 196009101980031003</td>
      </tr>
    </table>
     </td>
    	
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="left" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:11px; " ><div style="padding-bottom:0px;">Tembusan</div>
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
