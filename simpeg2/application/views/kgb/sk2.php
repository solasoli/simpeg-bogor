<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once APPPATH.'/third_party/html2pdf.class.php';


?>
<page >
<html>
<head>
	<title>SK KGB Kota Bogor</title>
	<link rel="stylesheet" href="http://simpeg.kotabogor.go.id/sipohanpinter/assets/css/sheets-of-paper-f4-kop.css" type="text/css">
	<STYLE type="text/css">
    #divid{
        background-image: url(images/kop1.png);
		background-repeat: no-repeat;

  		width: 100%;
  		height:1224px;
     }
    </style>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<body>
  <div id="divid">

    <table width="90%"  style="margin-top:200px; margin-left:30px; margin-right:50px;">
	<tr>
		<td>Nomor</td>
		<td>:</td>
		<td width="45%"><?php echo $sk->no_sk ?></td>
		<td rowspan="4">
			&nbsp;&nbsp;Bogor, <?php echo $this->format->tanggal_indo($sk->tgl_sk);//echo strftime('%d %B %Y', strtotime($sk->tgl_sk)); ?><br/>
			&nbsp;&nbsp;Kepada<br/>
			&nbsp;&nbsp;Yth. Kepala Badan Pengelolaan Keuangan <br/>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;dan Aset Daerah Kota Bogor<br />
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;di<br/>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<u>B O G O R</u>
		</td>
	</tr>
	<tr>
		<td>Sifat</td>
		<td>:</td>
		<td>-</td>

	</tr>
	<tr>
		<td>Lampiran</td>
		<td>:</td>
		<td>-</td>

	</tr>
	<tr>
		<td>Perihal</td>
		<td>:</td>
		<td><u>Pemberitahuan Kenaikan Gaji Berkala</u></td>

	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td colspan="2" style="width:680px">
			<br/>
			<p>Dengan ini diberitahukan, bahwa berhubung dengan telah dipenuhinya masa kerja dan syarat-syarat lainnya kepada:</p>
			<p>
			<table>
				<tr>
					<td>Nama</td>
					<td>:</td>
					<?php
						$pegawai_full = $pegawai->gelar_depan ? $pegawai->gelar_depan.' '.$pegawai->nama : $pegawai->nama;
						$pegawai_full .= $pegawai->gelar_belakang ? ', '.$pegawai->gelar_belakang : '' ;
					?>
					<td><?php echo $pegawai_full ?></td>
				</tr>
				<tr>
					<td>Tanggal Lahir</td>
					<td>:</td>
					<td><?php echo $pegawai->tempat_lahir ?>, <?php echo $this->format->tanggal_indo($pegawai->tgl_lahir) //echo strftime('%d %B %Y', strtotime($pegawai->tgl_lahir)); ?></td>
				</tr>
				<tr>
					<td>N I P</td>
					<td>:</td>
					<td><?php echo $pegawai->nip_baru ?></td>
				</tr>
				<tr>
					<td>Pangkat-Gol/Ruang</td>
					<td>:</td>
					<td><?php echo $pegawai->status_pegawai == 'CPNS' ? ' - ' : $pegawai->pangkat ?> - <?php echo $pegawai->golongan ?></td>
				</tr>
				<tr>
					<td>Unit Kerja</td>
					<td>:</td>
					<td><?php echo (strpos($pegawai->nama_baru, "Staf") === FALSE) ? $pegawai->nama_baru : "Sekretariat Daerah" ?></td>
				</tr>
				<tr>
					<td>Gaji Pokok Lama</td>
					<td>:</td>
					<td><?php
							if($pegawai->status_pegawai == 'CPNS'){
								echo "80% x Rp. ".$this->format->currency($dasar_sk->gaji).",- = Rp. ".$this->format->currency($dasar_sk->gaji*0.8).",-";
							}else{
								echo $dasar_sk->gaji ? "Rp. ".number_format($dasar_sk->gaji, 0, ',','.').",-" : "kosong";
							} ?>
					</td>
				</tr>
			</table>
		</p>
			<p><strong>ATAS DASAR SKEP TERAKHIR TENTANG GAJI/PANGKAT YANG DITETAPKAN : </strong></p>
			<p>
			<table>
				<tr>
					<td>Oleh</td>
					<td>:</td>
					<td><?php echo $dasar_sk->pemberi_sk ?></td>
				</tr>
				<tr>
					<td>Tanggal dan Nomor</td>
					<td>:</td>
					<td><?php echo strftime('%d-%m-%Y', strtotime($dasar_sk->tgl_sk)); ?>; <?php echo $dasar_sk->no_sk ?></td>
				</tr>
				<tr>
					<td>Mulai Berlaku Tanggal</td>
					<td>:</td>
					<td><?php echo strftime('%d-%m-%Y', strtotime($dasar_sk->tmt)); //echo $this->format->tanggal_indo($dasar_sk->tmt);?></td>
				</tr>
				<tr>
					<td>Masa Kerja Golongan</td>
					<td>:</td>
					<td><?php echo explode(',',$dasar_sk->keterangan)[1]; ?> Tahun <?php echo explode(',',$dasar_sk->keterangan)[2]; ?> Bulan</td>
				</tr>
			</table>
		</p>
			<p><strong>DIBERIKAN KENAIKAN GAJI BERKALA HINGGA MEMPEROLEH :</strong></p>
			<p>
			<table>
				<tr>
					<td>Gaji Pokok Baru</td>
					<td>:</td>
					<td><?php
							if($pegawai->status_pegawai == 'CPNS'){
								echo "80% x Rp. ".$this->format->currency($sk->gaji).",- = Rp. ".$this->format->currency($sk->gaji*0.8).",-";
							}else{
								echo "Rp. ".number_format($sk->gaji, 0, ',','.').",-";
							} ?>
					</td>
				</tr>
				<tr>
					<td>Mulai Berlaku Tanggal</td>
					<td>:</td>
					<td><?php echo strftime('%d-%m-%Y', strtotime($sk->tmt)); //echo $this->format->tanggal_indo($sk->tmt);//?></td>
				</tr>
				<tr>
					<td>Masa Kerja Golongan</td>
					<td>:</td>
					<td><?php echo explode(',',$sk->keterangan)[1]; ?> Tahun <?php echo explode(',',$sk->keterangan)[2]; ?> Bulan</td>
				</tr>
			</table>
		</p>
			<p>Diharapkan agar sesuai dengan <?php echo $sk->peraturan ?> Tahun <?php echo $sk->tahun ?> tentang
			Perubahan <?php echo $sk->perubahan ?> atas PP Nomor 7 Tahun 1977 tentang Peraturan Gaji Pegawai Negeri Sipil,
			kepada pegawai tersebut dibayarkan penghasilan berdasarkan gaji pokok baru.</p>

			<p>
				Keterangan:<br/>
				a. Yang bersangkutan adalah Calon/Pegawai Negeri Sipil pada Pemerintah Kota Bogor<br/>
				b. Kenaikan Gaji Berkala yang akan datang jika memenuhi syarat-syarat yang
				diperlukan pada tanggal:
				<strong>
				<?php
					$tahun_kerja = explode(',',$sk->keterangan)[1];
					if(
						((
							$pegawai->golongan == 'I/a' ||
							$pegawai->golongan == 'I/b' ||
							$pegawai->golongan == 'I/c' ||
							$pegawai->golongan == 'I/d'
						) && $tahun_kerja >= 27) ||

						((
							$pegawai->golongan == 'II/a' ||
							$pegawai->golongan == 'II/b' ||
							$pegawai->golongan == 'II/c' ||
							$pegawai->golongan == 'II/d'
						) && $tahun_kerja >= 33) ||

						((
							$pegawai->golongan == 'III/a' ||
							$pegawai->golongan == 'III/b' ||
							$pegawai->golongan == 'III/c' ||
							$pegawai->golongan == 'III/d'
						) && $tahun_kerja >= 32) ||

						((
							$pegawai->golongan == 'IV/a' ||
							$pegawai->golongan == 'IV/b' ||
							$pegawai->golongan == 'IV/c' ||
							$pegawai->golongan == 'IV/d' ||
							$pegawai->golongan == 'IV/e'
						) && $tahun_kerja >= 32)
					)
						echo "MAKSIMAL";
					else
						echo date_format(date_add(date_create($sk->tmt),date_interval_create_from_date_string("2 years")), 'd-m-Y');
				?></strong><br/>
			</p>


		</td>
	</tr>
    <tr>
		<td></td>
		<td></td>
		<td>&nbsp;</td>
		<td style="width:200px"><strong><?php
						echo $atas_nama."<br/>";
						if(strpos(strtolower($pengesah->jabatan),'pada'))
							echo substr($pengesah->jabatan, 0, strpos(strtolower($pengesah->jabatan), 'pada'));
						else
							echo $pengesah->jabatan;
						?></strong><br/><br/><br/><br/>
						<?php
							$pengesah_full = $pengesah->gelar_depan ? $pengesah->gelar_depan.' '.strtoupper($pengesah->nama) : strtoupper($pengesah->nama);
							$pengesah_full .= $pengesah->gelar_belakang ? ', '.$pengesah->gelar_belakang : '' ;
						/*	if($pengesah->gelar_belakang){
								$pengesah_full = $pengesa
							}
						*/
						?>
						<strong>
						<?php if($pengesah->nip_baru): ?>
							<?php if($pengesah->flag_pensiun == 99 ) { ?>
								<?php echo $pengesah_full ?><br/>
							<?php }else{ ?>
								<u><?php echo $pengesah_full ?></u><br/>
							<?php } ?>

							<?php echo $pengesah->flag_pensiun == 99 ? "" : $pengesah->pangkat." - ".$pengesah->pangkat_gol; ?><br/>
							<?php echo $pengesah->flag_pensiun == 99 ? "" : "NIP. ".$pengesah->nip_baru ?>
						<?php else: ?>
							<?php echo $pengesah_full ?>
						<?php endif; ?>
						</strong><br/></td>
	</tr>
	<tr>
		<td>Tembusan</td>
		<td>:</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td colspan="4">
			1. Kepala Kantor Regional III BKN di Bandung;<br/>
			2. Kepala Kantor Cabang PT. TASPEN (Persero) di Bogor;<br/>
			3. Kepala Badan Kepegawaian dan Pengembangan Sumberdaya Aparatur Kota Bogor;<br/>
			4. Kepada yang bersangkutan;
		</td>
	</tr>
</table></div>
</body>
</html>
</page>
<?php
$content = ob_get_clean();
try
{
    $html2pdf = new HTML2PDF('P', 'Legal', 'en', true, 'UTF-8', 0);
    $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
    $html2pdf->Output('./ds_output/kgb.pdf','F');


		//$upload_data = $this->upload->data();
		//$fileName = $upload_data['file_name'];

		//$filename =

		//File path at local server
		$source = 'ds_output/kgb.pdf';

		//Load codeigniter FTP class
		$this->load->library('ftp');

		//FTP configuration
		$ftp_config['hostname'] = '103.14.229.15';
		$ftp_config['username'] = 'rommonz';
		$ftp_config['password'] = 'mony3Tmony3T';
		$ftp_config['debug']    = TRUE;

		//Connect to the remote server
		$this->ftp->connect($ftp_config);

		//File upload path of remote server
		$destination = '/var/www/html/simpeg2/ds_output/kgb.pdf';

		//Upload file to the remote server
		$this->ftp->upload($source, ".".$destination);

		//Close FTP connection
		$this->ftp->close();

		//Delete file from local server
		@unlink($source);
		
}catch(HTML2PDF_exception $e) {
    echo $e;
    exit;
}
?>
