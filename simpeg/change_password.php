<h2>Ganti Password</h2>
<?php
	extract($_POST);
	$isSuccess = 0;

	$sql = "update pegawai
			set password = '$password_baru'
			where id_pegawai = $ata[0]";


	if($password_lama == $ata['password'])
	{
		if($password_baru == $konfirmasi_password)
		{
			$result = mysqli_query($mysqli,$sql);
			if($result = 1)
			{
				$isSuccess = 1;
				if($is_tim){
					$query = "update knj_admin set password = '".$password_baru."' where id_pegawai = ".$ata[0];
					$result_knj = mysqli_query($mysqli,$query);
				}
			}
			else
			{
				echo "<font color='red'>Koneksi ke database gagal. <br />Silahkan hubungi BKPSDA Kota Bogor untuk mendapatkan bantuan</font>";
			}
		}
		else
		{
			echo "Konfirmasi password anda salah. ";
		}
	}
	else
	{
		echo "Password lama yang anda masukkan salah. ";
	}

	if($isSuccess == 1)
	{
		echo "Password anda berhasil diganti.";
	}
	else
	{
		echo "<br /><a href='".BASE_URL."index3.php?x=ganti_password.php'>Ulang</a>";
	}
?>
