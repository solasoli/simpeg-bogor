<html>
<?php $pegawai = $this->pegawai->get_by_id($this->uri->segment(3)); ?>
I. KETERANGAN PERORANGAN
	<table border=1>
		<tr>
			<td>1.</td>
			<td colspan=2>Nama Lengkap</td>
			<td><?php echo $pegawai->nama?></td>
		</tr>
		<tr>
			<td>2.</td>
			<td colspan=2>NIP</td>
			<td><?php echo $pegawai->nip_baru?></td>
		</tr>		
		<tr>
			<td>3.</td>
			<td colspan=2>Pangkat dan Golongan Ruang</td>
			<td><?php echo $pegawai->pangkat_gol ?></td>
		</tr>
		<tr>
			<td>4.</td>
			<td colspan=2>Tempat Lahir / Tanggal Lahir</td>
			<td><?php echo $pegawai->tempat_lahir.'/ '.$pegawai->tgl_lahir  ?></td>
		</tr>		
		<tr>
			<td>5.</td>
			<td colspan=2>Jenis Kelamin</td>
			<td><?php echo $pegawai->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' ?></td>
		</tr>
		<tr>
			<td>6.</td>
			<td colspan=2>A g a m a</td>
			<td><?php echo $pegawai->agama ?></td>
		</tr>		
		<tr>
			<td>8.</td>
			<td rowspan=5>Alamat Rumah</td>			
		</tr>
		<tr>
			<td>9.</td>
			<td>a. Jalan</td>
			<td><?php echo $pegawai->alamat ?></td>
		</tr>
		<tr>
			<td>9.</td>
			<td>kelurahan / Desa</td>
			<td><?php echo $pegawai->alamat ?></td>
		</tr>
		<tr>
			<td>10.</td>
			<td>Kecamatan</td>
			<td>-</td>
		</tr>
		<tr>
			<td>11.</td>
			<td>Kabupaten / Kota</td>
			<td>-</td>
		</tr>
		<tr>
			<td>12.</td>
			<td>Propinsi</td>
			<td>-</td>
		</tr>
		<tr>
			<td>13.</td>
			<td>Keterangan badan</td>
			<td>-</td>
		</tr>
		<tr>
			<td>14.</td>
			<td>Berat badan (Kg)</td>
			<td>-</td>
		</tr>
		<tr>
			<td>15.</td>
			<td>Rambut</td>
			<td>-</td>
		</tr>
		<tr>
			<td>16.</td>
			<td>Bentuk Muka</td>
			<td>-</td>
		</tr>
		<tr>
			<td>17.</td>
			<td>Warna Kulit</td>
			<td>-</td>
		</tr>
		<tr>
			<td>18.</td>
			<td>Ciri-ciri khas</td>
			<td>-</td>
		</tr>
		<tr>
			<td>19.</td>
			<td>Cacat tubuh</td>
			<td>-</td>
		</tr>
		<tr>
			<td colspan=2>20</td>
			<td>Kegemaran (Hobby )</td>
			<td>-</td>
		</tr>
	</table>
	
<p>	
II. PENDIDIKAN </br>
1. Pendidikan di Dalam dan di Luar Negeri
<table border=1>
	<tr>
		<td>No.</td>
		<td>Tingkat</td>
		<td>Nama Pendidikan</td>
		<td>Jurusan</td>
		<td>STTB/Tanda Lulus/Ijasah Tahun</td>
		<td>Tempat</td>
		<td>Nama Kepala Sekolah/Direktur/Dekan/Promotor</td>
	</tr>
	<tr>
		<td>1</td>
		<td>2</td>
		<td>3</td>
		<td>4</td>
		<td>5</td>
		<td>6</td>
		<td>7</td>
	</tr>	
</table>

</br>
2. Kursus/Latihan di Dalam dan di Luar Negeri
<table border=1>
	<tr>
		<td>No.</td>
		<td>Nama/Kursus/Latihan</td>
		<td>Lamanya Tgl/Bln/Thn s/d Tgl/Bln/Thn</td>
		<td>Ijasah/Tanda Lulus/Surat Keterangan Tahun</td>
		<td>Tempat</td>
		<td>Keterangan</td>		
	</tr>
	<tr>
		<td>1</td>
		<td>2</td>
		<td>3</td>
		<td>4</td>
		<td>5</td>
		<td>6</td>		
	</tr>	
</table>

<p>	
III. RIWAYAT PEKERJAAN </br>
1. Riwayat Kepangkatan golongan ruang penggajian
<table border=1>	
	
	<tr>
		<td rowspan='2'>No.</td>
		<td rowspan='2'>Pangkat</td>
		<td rowspan='2'>Gol. ruang Penggajian</td>
		<td rowspan='2'>Berlaku terhitung mulai tgl.</td>
		<td rowspan='2'>Gaji Pokok</td>
		<td colspan='3'>Surat Keputusan</td>
		<td rowspan='2'>Peraturan yang dijadikan dasar</td>
	</tr>
	<tr>
		<td>Pejabat</td>
		<td>Nomor</td>
		<td>Tanggal</td>
	</tr>
	<tr>
		<td>1</td>
		<td>2</td>
		<td>3</td>
		<td>4</td>
		<td>5</td>
		<td>6</td>
		<td>7</td>
		<td>8</td>
		<td>9</td>
	</tr>	
</table>

2. Pengalaman Jabatan / Pekerjaan
<table border=1>	
	
	<tr>
		<td rowspan='2'>No.</td>
		<td rowspan='2'>Jabatan / Pekerjaan</td>
		<td rowspan='2'>Mulai dan Sampai</td>
		<td rowspan='2'>Golongan Ruang Penggajian</td>
		<td rowspan='2'>Gaji Pokok</td>
		<td colspan='3'>Surat Keputusan</td>		
	</tr>
	<tr>
		<td>Pejabat</td>
		<td>Nomor</td>
		<td>Tanggal</td>
	</tr>
	<tr>
		<td>1</td>
		<td>2</td>
		<td>3</td>
		<td>4</td>
		<td>5</td>
		<td>6</td>
		<td>7</td>
		<td>8</td>		
	</tr>	
	<tr>		
		<td>{data}</td>
		<td>{data}</td>
		<td>{data}</td>
		<td>{data}</td>
		<td>{data}</td>
		<td>{data}</td>
		<td>{data}</td>
		<td>{data}</td>
	</tr>	
</table>
IV. TANDA JASA / PENGHARGAAN
<table>
	<tr>
		<td>No.</td>
		<td>Nama Bintang / Satya Lencana / Penghargaan</td>
		<td>Tahun Perolehan</td>
		<td>Nama Negara / Instansi yang memberi</td>
	</tr>
	<tr>
		<td>1</td>
		<td>2</td>
		<td>3</td>
		<td>4</td>
	</tr>
</table>

V. PENGALAMAN</br>
1. Kunjungan ke Luar Negeri
<table border=1>
	<tr>
		<td>No.</td>
		<td>Negara</td>
		<td>Tujuan Kunjungan</td>
		<td>Lamanya</td>
		<td>Yang membiayayi</td>
	</tr>
	<tr>
		<td>1</td>
		<td>2</td>
		<td>3</td>
		<td>4</td>
	</tr>
</table>

VI. KETERANGAN KELUARGA
<table border="1">
	<tr>
		<td colspan="7">1. Istri/Suami</td>
	</tr>
	<tr>
		<td>NO.</td>
		<td>NAMA</td>
		<td>TEMPAT LAHIR</td>
		<td>TANGGAL LAHIR</td>
		<td>TANGGAL MENIKAH</td>
		<td>PEKERJAAN</td>
		<td>KETERANGAN</td>
	</tr>
	<tr>
		<td>1</td>
		<td>2</td>
		<td>3</td>
		<td>4</td>
		<td>5</td>
		<td>6</td>
		<td>7</td>
	</tr>
	<tr>
		<td>{{data}}</td>
		<td>{{data}}</td>
		<td>{{data}}</td>
		<td>{{data}}</td>
		<td>{{data}}</td>
		<td>{{data}}</td>
		<td>{{data}}</td>		
	</tr>
	
	<tr>
		<td colspan="7">2. Anak</td>
	</tr>
	<tr>
		<td>NO.</td>
		<td>NAMA</td>
		<td>JENIS KELAMIN</td>
		<td>TEMPAT LAHIR</td>
		<td>TANGGAL LAHIR</td>
		<td>PEKERJAAN</td>
		<td>KETERANGAN</td>
	</tr>
	<tr>
		<td>1</td>
		<td>2</td>
		<td>3</td>
		<td>4</td>
		<td>5</td>
		<td>6</td>
		<td>7</td>
	</tr>
	<tr>
		<td>{{data}}</td>
		<td>{{data}}</td>
		<td>{{data}}</td>
		<td>{{data}}</td>
		<td>{{data}}</td>
		<td>{{data}}</td>
		<td>{{data}}</td>		
	</tr>
	
	<tr>
		<td colspan="7">3. Bapak dan Ibu Kandung</td>
	</tr>
	<tr>
		<td>NO.</td>
		<td>NAMA</td>
		<td colspan="2">TGL. LAHIR/UMUR</td>
		<td colspan="2">PEKERJAAN</td>
		<td>KETERANGAN</td>		
	</tr>
	<tr>
		<td>1</td>
		<td>2</td>
		<td colspan="2">3</td>
		<td colspan="2">4</td>
		<td>5</td>
	</tr>
	<tr>
		<td>{{data}}</td>
		<td>{{data}}</td>
		<td colspan="2">{{data}}</td>
		<td colspan="2">{{data}}</td>			
		<td>{{data}}</td>			
	</tr>
	
	<tr>
		<td colspan="7">4. Bapak dan Ibu Mertua</td>
	</tr>
	<tr>
		<td>NO.</td>
		<td>NAMA</td>
		<td colspan="2">TGL. LAHIR/UMUR</td>
		<td colspan="2">PEKERJAAN</td>
		<td>KETERANGAN</td>		
	</tr>
	<tr>
		<td>1</td>
		<td>2</td>
		<td colspan="2">3</td>
		<td colspan="2">4</td>
		<td>5</td>
	</tr>
	<tr>
		<td>{{data}}</td>
		<td>{{data}}</td>
		<td colspan="2">{{data}}</td>
		<td colspan="2">{{data}}</td>			
		<td>{{data}}</td>			
	</tr>
	
	<tr>
		<td colspan="7">5. Saudara Kandung</td>
	</tr>
	<tr>
		<td>NO.</td>
		<td colspan="2">NAMA</td>
		<td>JENIS KELAMIN</td>
		<td>TANGGAL LAHIR/UMUR</td>
		<td>PEKERJAAN</td>		
		<td>KETERANGAN</td>		
	</tr>
	<tr>
		<td>1</td>
		<td>2</td>
		<td>3</td>
		<td colspan="2">4</td>
		<td colspan="2">5</td>		
	</tr>
	<tr>
		<td>{{data}}</td>
		<td>{{data}}</td>
		<td>{{data}}</td>
		<td colspan="2">{{data}}</td>			
		<td colspan="2">{{data}}</td>						
	</tr>
</table>

VII. KETERANGAN ORGANISASI
<table border="1">
	<tr>
		<td colspan="7">1. Semua mengikuti pendidikan pada SLTA ke bawah</td>
	</tr>
	<tr>
		<td>NO.</td>
		<td>NAMA ORGANISASI</td>
		<td>KEDUDUKAN DALAM ORGANISASI</td>
		<td>DALAM TH. S.D TH</td>
		<td>TEMPAT</td>
		<td>NAMA PIMPINAN ORGANISASI</td>		
	</tr>
	<tr>
		<td>1</td>
		<td>2</td>
		<td>3</td>
		<td>4</td>
		<td>5</td>
		<td>6</td>
	</tr>
	<tr>		
		<td>{{data}}</td>
		<td>{{data}}</td>
		<td>{{data}}</td>
		<td>{{data}}</td>
		<td>{{data}}</td>
		<td>{{data}}</td>		
	</tr>
	
	<tr>
		<td colspan="7">2. Semasa mengikuti pendidikan pada perguruan tinggi</td>
	</tr>
	<tr>
		<td>NO.</td>
		<td>NAMA ORGANISASI</td>
		<td>KEDUDUKAN DALAM ORGANISASI</td>
		<td>DALAM TH. S.D TH</td>
		<td>TEMPAT</td>
		<td>NAMA PIMPINAN ORGANISASI</td>		
	</tr>
	<tr>
		<td>1</td>
		<td>2</td>
		<td>3</td>
		<td>4</td>
		<td>5</td>
		<td>6</td>
	</tr>
	<tr>		
		<td>{{data}}</td>
		<td>{{data}}</td>
		<td>{{data}}</td>
		<td>{{data}}</td>
		<td>{{data}}</td>
		<td>{{data}}</td>		
	</tr>
	
	<tr>
		<td colspan="7">3. Sesudah selesai pendidikan dan atau selama menjadi pegawai</td>
	</tr>
	<tr>
		<td>NO.</td>
		<td>NAMA ORGANISASI</td>
		<td>KEDUDUKAN DALAM ORGANISASI</td>
		<td>DALAM TH. S.D TH</td>
		<td>TEMPAT</td>
		<td>NAMA PIMPINAN ORGANISASI</td>		
	</tr>
	<tr>
		<td>1</td>
		<td>2</td>
		<td>3</td>
		<td>4</td>
		<td>5</td>
		<td>6</td>
	</tr>
	<tr>		
		<td>{{data}}</td>
		<td>{{data}}</td>
		<td>{{data}}</td>
		<td>{{data}}</td>
		<td>{{data}}</td>
		<td>{{data}}</td>		
	</tr>
</table>

VIII. KETERANGAN LAIN-LAIN
<table border="1">
	<tr>
		<td rowspan="2">NO.</td>
		<td rowspan="2">NAMA KETERANGAN</td>
		<td colspan="2">SURAT KETERANGAN</td>
		<td rowspan="2">TANGGAL</td>		
	</tr>
	<tr>
		<td>PEJABAT</td>
		<td>NOMOR</td>
	</tr>
	<tr>
		<td>1</td>
		<td>2</td>
		<td>3</td>
		<td>4</td>
		<td>5</td>	
	</tr>
	<tr>		
		<td>{{data}}</td>
		<td>{{data}}</td>
		<td>{{data}}</td>
		<td>{{data}}</td>
		<td>{{data}}</td>		
	</tr>
	
	<tr>
		<td colspan="5">3. Keterangan lain yang dianggap perlu</td>
	</tr>
	
</table>
</html>