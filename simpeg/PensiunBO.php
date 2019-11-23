<?
	require_once "util.php";
	
	class PensiunBO
	{
		// Periode masa kerja untuk setiap jenjab dalam satuan tahun.
		var $masaKerjaStruktural = 56;
		var $masaKerjaFungsional = 60;
		var $masaPensiunDini = 50;
		var $tanggalLahir;
		var $jenjab;
		
		// Default Constructor
		// Format $tanggalLahir yaitu YYYY-MM-DD
		// $jenjab diisi dengan string Struktural atau Fungsional.
		function PensiunBO($tanggalLahir, $jenjab)
		{
			// Format $tanggalLahir adalah YYY-MM-DD
			$this->tanggalLahir = $tanggalLahir;
			$this->jenjab = $jenjab;
		}
		
		// Method untuk menghitung waktu pensiun berdasarkan Tanggal Lahir Pegawai. Return value berupa tanggal pensiun
		// dengan format YYYY-MM-DD.
		function getTanggalPensiun()
		{
			if($this->tanggalLahir == "")
			{
				echo "Application ERROR! (Message:) Tanggal Lahir Pegawai Tidak Boleh Kosong (Class:) PensiunBO";
			}
			else
			{
				$tanggal = getDay($this->tanggalLahir);
				$bulan   = getMonth($this->tanggalLahir);
				$tahun 	 = getYear($this->tanggalLahir);
				
				if($this->jenjab == "Struktural")
				{
					$tahunPensiun = $tahun + 56;
					
				}
				else if($this->jenjab == "Fungsional")
				{
					$tahunPensiun = $tahun + 60;
				}
				else
				{
					echo "Application ERROR! (Message:) Jenjab Harus diisi Struktural atau Fungsional (Class:) PensiunBO";
					return null;
				}
				
				if($bulan == 12)
					$bulanPensiun = 1;
				else
					$bulanPensiun = $bulan + 1;
				
				$tanggalPensiun = 1;
				
				return date("Y-m-d", mktime(0, 0, 0, $bulanPensiun, $tangalPensiun, $tahunPensiun));
			}
		}
	
		// Method untuk memastikan apakah sudah saatnya pegawai untuk diberi  peringatan
		// bahwa pegawai tersebut dalam x bulan lagi akan pensiun. x = $limit = dalam bulan
		// Terdapat dua overload method:
		function warnPensiun($limit)
		{
			$todayYear  = date("Y");
			$todayMonth = date("m");
			$todayDat   = date("d");
			
			$tanggalPensiun = $this->getTanggalPensiun();
			$bulanPensiun = getMonth($tanggalPensiun);
			$tahunPensiun = getYear($tanggalPensiun);
			
			
			if($todayMonth >= ($bulanPensiun - $limit) &&
				$todayMonth <= $bulanPensiun && 
				$todayYear == $tahunPensiun)
			{
				return true;
			}
			return false;
		}
	
		// Method untuk memastikan bahwa pegawai sudah dapat mengajukan pensiun dini.
		// Return value: boolean
		function isCanPensiunDini()
		{
			$tahunLahir = getYear($this->tanggalLahir);
			$tahunSekarang = date("Y");
			$selisih = $tahunSekarang - $tahunLahir;
			
			if($selisih >= $this->masaPensiunDini)
				return true;
			
			return false;
		}
	}
	
	/* Class Test 
	$po = new PensiunBO("1953-08-01", "Struktural");
	$po->getTanggalPensiun();
	
	if($po->warnPensiun(6))
	{
		echo "warn";
	} */
?>