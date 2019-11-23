<?php
	class QR extends CI_Controller
	{
		
		public function index()
		{
			$this->load->view('cetak_v');
		}
		public function encode()
		{
			include('assets/phpqrcode/qrlib.php');
			$alamat = $this->uri->segment(3);
			QRcode::png($alamat);
		}
		
		public function pdf()
		{
			$this->load->view('laporan_v');
			$content = ob_get_clean();
			require_once('assets/pdf/html2pdf.class.php');
			try
			{
				$html2pdf = new HTML2PDF('P', 'A4', 'fr', true, 'UTF-8', 0);
				$html2pdf->writeHTML($content, isset($_GET['vuehtml']));
				$html2pdf->Output('ceria.pdf','I');
			}
				catch(HTML2PDF_exception $e) {
				echo $e;
				exit;
			}
		}
	}
?>