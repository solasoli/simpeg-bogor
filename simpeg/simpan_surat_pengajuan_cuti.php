<?PHP
	//koneksi ke database
session_start();
	mysqli_connect("simpeg.db.kotabogor.net","simpeg","Madangkara2017");
	
	mysqli_select_db("simpeg"); //-->2	

	//ambil variabel yang dikirim dari form
	$jenis_cuti = $_GET['cboJenisCuti'];
	$nomor_surat = $_GET['txtNomorsurat'];
	$tgl_surat = $_GET['txtTmtTanggalsurat'];
	$tmt_awal = $_GET['txtTmtAwal'];
	$tmt_akhir = $_GET['txtTmtSelesai'];
	$nama_atasan = $_GET['txtNamaAtasan'];
	$nip_atasan = $_GET['txtNipAtasan'];
	$nama_camat = $_GET['txtNamaCamat'];
	$nip_camat = $_GET['txtNipCamat'];
	$ket = $_GET['txtKeterangan'];

	$tgl_tgl = substr($tgl_surat,0,2);
	$bln_tgl = substr($tgl_surat,3,2);
	$thn_tgl = substr($tgl_surat,6,4);

	$tgl_surat = $thn_tgl."-".$bln_tgl."-".$tgl_tgl;
	
	$tgl_awal = substr($tmt_awal,0,2);
	$bln_awal = substr($tmt_awal,3,2);
	$thn_awal = substr($tmt_awal,6,4);

	$tmt_awal = $thn_awal."-".$bln_awal."-".$tgl_awal;

	$tgl_akhir = substr($tmt_akhir,0,2);
	$bln_akhir = substr($tmt_akhir,3,2);
	$thn_akhir = substr($tmt_akhir,6,4);

	$tmt_akhir = $thn_akhir."-".$bln_akhir."-".$tgl_akhir;	

		if($jenis_cuti == "C_TAHUNAN"){	
			//ngambil jumlah hari kerja
			$sql_s = "SELECT sum( is_workday ) AS jumlah
			FROM oasys_workday
			WHERE workday_date
			BETWEEN '$tmt_awal'
			AND '$tmt_akhir'";

			$query_s = mysqli_query($mysqli,$sql_s);
			$hari =	mysqli_fetch_array($query_s);
			
			$jumlah=0;
			
		//echo $hari[0];
		//echo $jumlah;
		}
		//ngambil kuota
		$kuota = "SELECT kuota_cuti FROM pegawai where id_pegawai='".$_SESSION['id_pegawai']."'";
		
		$k_c = mysqli_query($mysqli,$kuota);
		$h=	mysqli_fetch_array($k_c);
		//echo $h[0];
		//jika jumlah hari kerja kurang dari kuota
		if ($hari[0] <= $h[0]) {
			# code...
			$input = "INSERT INTO cuti_pegawai(id_cuti_pegawai,id_pegawai,id_jenis_cuti,tmt_awal,tmt_selesai,nama_atasan,nip_atasan,nama_camat,nip_camat,keterangan)
			  VALUES('','".$_SESSION['id_pegawai']."','$jenis_cuti','$tmt_awal','$tmt_akhir','$nama_atasan','$nip_atasan','nama_camat','nip_camat','$ket')";
			$hasil = mysqli_query($mysqli,$input);
		
			
			header('Location: surat_pengajuan.php?id_pegawai='.$_SESSION['id_pegawai']);
		}else 		
		{
			echo "kuota anda tidak mencukupi";
		}
			
		
		


	//cek query
	/*if($hasil){
		echo "berhasil";
	}else{
		echo "gagal";
	}*/

?>
