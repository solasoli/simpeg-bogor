<?

class GolonganPangkatBO

{

	// Konstanta untuk kenaikan golongan pangkat pegawai. dalam tahun.

	var $struktural = 4;

	var $fungsional = 2; // Dengan syarat sudah memenuhi angka kredit (AK)

	

	var $nip_baru;

	

	

	function GolonganPangkatBO($nip_baru)

	{

		$this->nip_baru= $nip_baru;

	}

	

	// Method untuk memberikan notifikasi berupa string. Memastikan mengenai kenaikan Golongan Pangkat

	function notifyKenaikanPangkat()

	{

		$sql = "SELECT nip_baru, nama, MID(nip_baru,13,2) as bulan_naik_pangkat

				FROM pegawai

				WHERE ((LEFT(CURRENT_DATE(),4) - MID(nip_baru,9, 4)) % 4 =  0

				AND MID(nip_baru,13,2) >= MID(CURRENT_DATE(),6,2) AND jenjab = 'Struktural') OR

				((LEFT(CURRENT_DATE(),4) - MID(nip_baru,9, 4)) % 2 =  0

				AND MID(nip_baru,13,2) >= MID(CURRENT_DATE(),6,2) AND jenjab = 'Fungsional');

				AND WHERE nip_baru = '".$this->nip_baru."'";

				

		$result = mysqli_query($mysqli,$sql);

		if($result != null)

		{	

			$r = mysqli_fetch_array($result);

			if($r[bulan_naik_pangkat] <= 4)

			{

				$bulan = "April";

				$tahun = date("Y");

			}

			else if($r[bulan_naik_pangkat] > 10)

			{

				$bulan = "April";

				$tahun = date("Y") + 1;

			}

			else

			{

				$bulan = "Oktober";

			}

			

			return "Golongan/ Pangkat anda akan naik pada bulan $bulan tahun $tahun";

		}

		return "";

	}

}

?>