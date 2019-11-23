<?
class GajiBO
{
	var $idPegawai;
	var $intervalGajiBerkala = 2;
	
	function GajiBO($idPegawai)
	{
		$this->idPegawai = $idPegawai;
	}
	
	// Method yang digunakan memberikan notifikasi berkaitan dengan Gaji berjkala.
	function notifyGajiBerkala()
	{
		
	}
}
?>