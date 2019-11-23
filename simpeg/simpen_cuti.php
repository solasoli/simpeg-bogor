<?PHP
	//koneksi ke database
session_start();
extract($_POST);

	/*

	//ambil variabel yang dikirim dari form
	$jenis_cuti = $_POST['cboJenisCuti'];
	$tmt_awal = $_POST['txtTmtAwal'];
	$tmt_akhir = $_POST['txtTmtSelesai'];
	$ket = $_POST['txtKeterangan'];
	$id_pegawai = $_SESSION['id_pegawai'];


	$tgl_awal = substr($tmt_awal,0,2);
	$bln_awal = substr($tmt_awal,3,2);
	$thn_awal = substr($tmt_awal,6,4);

	$tmt_awal = $thn_awal."-".$bln_awal."-".$tgl_awal;
	$tmt_awal_2 = $tgl_awal . "-" . $bln_awal . "-" . $thn_awal;

	$tgl_akhir = substr($tmt_akhir,0,2);
	$bln_akhir = substr($tmt_akhir,3,2);
	$thn_akhir = substr($tmt_akhir,6,4);

	$tmt_akhir = $thn_akhir."-".$bln_akhir."-".$tgl_akhir;	
	$tmt_akhir_2 = $tgl_akhir . "-" . $bln_akhir . "-" . $thn_akhir;
	
	

		if($jenis_cuti == "C_TAHUNAN"){	
			//ngambil jumlah hari kerja
			$sql_s = "SELECT sum( is_workday ) AS jumlah
			FROM oasys_workday
			WHERE workday_date
			BETWEEN '$tmt_awal'
			AND '$tmt_akhir'";

			$query_s = mysql_query($sql_s);
			$hari =	mysql_fetch_array($query_s);
			
			$jumlah=0;
			$cti = "Cuti Tahunan";
			
		//echo $hari[0];
		//echo $jumlah;
		}
		//ngambil kuota
		$kuota = "SELECT kuota_cuti FROM pegawai where id_pegawai=".$id_pegawai;
		
		//echo $_SESSION['id_pegawai'];
		
		$k_c = mysql_query($kuota);
		$h=	mysql_fetch_array($k_c);
		//echo $h[0];
		//jika jumlah hari kerja kurang dari kuota
		if ($hari[0] <= $h[0]) {
			# code...
			$input = "INSERT INTO cuti_pegawai(id_cuti_pegawai,id_pegawai,id_jenis_cuti,tmt_awal,tmt_selesai,keterangan)
			  VALUES('',".$id_pegawai.",'$jenis_cuti','$tmt_awal','$tmt_akhir','$ket')";
			$hasil = mysql_query($input);
			//header('Location: surat_pengajuan.php?id_pegawai='.$id_pegawai);
			
			header('Location: surat_pengajuan.php?id_pegawai='.$id_pegawai.'&tmt_awal='.$tmt_awal_2.'&tmt_akhir='.$tmt_akhir_2.'&jenis_cuti='.$cti);
		}else 		
		{
			echo "kuota anda tidak mencukupi";				
		}
			
		
		


	*/
	echo("proses pengajuan cuti");

?>
