<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require '/etc/php/7.2/apache2/vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;

class excel_ipp_asn extends CI_Controller
{
    public function __construct(){
        parent::__construct();
    }

    public function index($idopd){
        $this->export_data_excel($idopd);
    }

    public function export_data_excel($idopd){
        // Create new Spreadsheet object
        $spreadsheet = new Spreadsheet();

        // Set document properties
        $spreadsheet->getProperties()->setCreator('SIMPEG Kota Bogor')
            ->setLastModifiedBy("SIMPEG Kota Bogor")
            ->setTitle("Laporan Indeks Profesional Pegawai")
            ->setSubject("Laporan Indeks Profesional Pegawai")
            ->setDescription("Laporan Indeks Profesional Pegawai, created by SIMPEG")
            ->setKeywords("laporan Indeks Profesional Pegawai")
            ->setCategory("Laporan Indeks Profesional Pegawai");

        // Create the worksheet
        $spreadsheet->setActiveSheetIndex(0);
        $spreadsheet->getActiveSheet()->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
        $spreadsheet->getActiveSheet()->getPageSetup()->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_LEGAL);
        $spreadsheet->getActiveSheet()->getPageSetup()->setFitToPage(true);
        $spreadsheet->getActiveSheet()->getPageSetup()->setFitToWidth(1);
        $spreadsheet->getActiveSheet()->getPageSetup()->setFitToHeight(0);

        // Load Model
        $this->load->model('ipp_asn_model');
        $nama_skpd = $this->ipp_asn_model->getNamaSKPD($idopd);
        $list_pjbt = $this->ipp_asn_model->getListPejabat($idopd);

        $styleArray = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
        ];

        $styleArrayHeader = [
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'color' => ['argb' => '4F81BD'],
            ],
            'font' => [
                'bold' => true,
                'color' => ['argb' => 'FFFFFF'],
                'size' => 11,
            ],
        ];

        $styleArrayBackColorMerah = [
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'color' => ['argb' => 'C00000'],
            ],
            'font' => [
                'bold' => true,
                'color' => ['argb' => 'FFFFFF'],
                'size' => 11,
            ],
        ];

        $styleArrayBackColorMerahMuda1 = [
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'color' => ['argb' => 'E6B8B7'],
            ]
        ];

        $styleArrayBackColorMerahMuda2 = [
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'color' => ['argb' => 'F2DCDB'],
            ]
        ];

        $styleArrayBackColorKuning = [
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'color' => ['argb' => 'F8F800'],
            ],
            'font' => [
                'bold' => true,
                'size' => 11,
            ],
        ];

        $styleArrayBackColorCellData = [
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'color' => ['argb' => 'E9EDF4'],
            ]
        ];

        $styleArrayBiruMuda = [
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'color' => ['argb' => 'C5D9F1'],
            ]
        ];

        $styleArrayBiruTua = [
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'color' => ['argb' => '538DD5'],
            ]
        ];

        // Rename sheet 1
        $spreadsheet->setActiveSheetIndex(0)->setTitle('1. Kompetensi');
        $spreadsheet->getActiveSheet()->mergeCells('A1:N1');
        $spreadsheet->getActiveSheet()->getStyle('A1:N1')->getFont()->setBold(true);
        $spreadsheet->getActiveSheet()->getStyle('A1:N1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $spreadsheet->getActiveSheet()->getStyle('A1:N1')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $spreadsheet->getActiveSheet()->setCellValue('A1', 'Metode Perhitungan Kompetensi');
        $spreadsheet->getActiveSheet()->setCellValue('A2', 'Unit : '.$nama_skpd);
        $spreadsheet->getActiveSheet()->setCellValue('A4', 'No');
        $spreadsheet->getActiveSheet()->mergeCells('A4:A5');
        $spreadsheet->getActiveSheet()->setCellValue('B4', 'Jabatan');
        $spreadsheet->getActiveSheet()->mergeCells('B4:B5');
        $spreadsheet->getActiveSheet()->setCellValue('C4', 'Fungsi');
        $spreadsheet->getActiveSheet()->mergeCells('C4:C5');
        $spreadsheet->getActiveSheet()->setCellValue('D4', 'Nama Pejabat');
        $spreadsheet->getActiveSheet()->mergeCells('D4:D5');
        $spreadsheet->getActiveSheet()->setCellValue('E4', 'NIP');
        $spreadsheet->getActiveSheet()->mergeCells('E4:E5');
        $spreadsheet->getActiveSheet()->setCellValue('F4', 'Pendidikan');
        $spreadsheet->getActiveSheet()->mergeCells('F4:G4');
        $spreadsheet->getActiveSheet()->setCellValue('G5', 'Y/N');
        $spreadsheet->getActiveSheet()->setCellValue('H4', 'Pelatihan');
        $spreadsheet->getActiveSheet()->mergeCells('H4:I4');
        $spreadsheet->getActiveSheet()->setCellValue('I5', 'Y/N');
        $spreadsheet->getActiveSheet()->setCellValue('J4', 'Pengalaman');
        $spreadsheet->getActiveSheet()->mergeCells('J4:K4');
        $spreadsheet->getActiveSheet()->setCellValue('K5', 'Y/N');
        $spreadsheet->getActiveSheet()->setCellValue('L4', 'Administrasi');
        $spreadsheet->getActiveSheet()->mergeCells('L4:M4');
        $spreadsheet->getActiveSheet()->setCellValue('M5', 'Y/N');
        $spreadsheet->getActiveSheet()->setCellValue('N4', '*Penilaian Objektif');
        $spreadsheet->getActiveSheet()->setCellValue('N5', 'Gaps');
        $spreadsheet->getActiveSheet()->getStyle('A4:N5')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $spreadsheet->getActiveSheet()->getStyle('A4:N5')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $spreadsheet->getActiveSheet()->getStyle('A4:N5')->applyFromArray($styleArrayHeader);
        $spreadsheet->getActiveSheet()->getStyle('N5:N5')->applyFromArray($styleArrayBackColorMerah);
        $spreadsheet->getActiveSheet()->getRowDimension('5')->setRowHeight(21);

        $spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(5); // No
        $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(15); // Jabatan
        $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(30); // Fungsi
        $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(20); // Nama Pejabat
        $spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(20); // NIP
        $spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(15); // Pendidikan
        $spreadsheet->getActiveSheet()->getColumnDimension('G')->setWidth(5); //
        $spreadsheet->getActiveSheet()->getColumnDimension('H')->setWidth(15); // Pelatihan
        $spreadsheet->getActiveSheet()->getColumnDimension('I')->setWidth(5); //
        $spreadsheet->getActiveSheet()->getColumnDimension('J')->setWidth(15); // Pengalaman
        $spreadsheet->getActiveSheet()->getColumnDimension('K')->setWidth(5); //
        $spreadsheet->getActiveSheet()->getColumnDimension('L')->setWidth(15); // Administrasi
        $spreadsheet->getActiveSheet()->getColumnDimension('M')->setWidth(5); //
        $spreadsheet->getActiveSheet()->getColumnDimension('N')->setWidth(15); // Penilaian
        $spreadsheet->getActiveSheet()->getStyle('N4:N4'.$spreadsheet->getActiveSheet()->getHighestRow())->getAlignment()->setWrapText(true);
        $i = 0;
        $dataArray = null;
        $dataArrayKinerja = null;
        $jmlFlgPendidikan = 0;
        $jmlFlgPelatihan = 0;
        $jmlFlgPengalaman = 0;
        $jmlFlgAdministrasi = 0;
        $jmlSkorGapAsn = 0;
        $jmlNilaiSKP = 0;

        foreach ($list_pjbt as $row){
            $dataKompetensi = $this->ipp_asn_model->getKompetensiKinerja($idopd,$row->id_j,$row->id_pegawai);
            $dataArray[$i] = array($i+1, $dataKompetensi['jabatan'], $dataKompetensi['tugas'], $dataKompetensi['nama'],
                $dataKompetensi['nip_baru'],$dataKompetensi['pendidikan'],$dataKompetensi['flag_pendidikan'],$dataKompetensi['pelatihan'],
                $dataKompetensi['flag_pelatihan'],$dataKompetensi['pengalaman'],$dataKompetensi['flag_pengalaman'],$dataKompetensi['administrasi'],
                $dataKompetensi['flag_administrasi'],$dataKompetensi['skor_gap_asn']);
            $dataArrayKinerja[$i] = array('','','','','','','',
                $i+1,$dataKompetensi['jabatan'],$dataKompetensi['nama'],$dataKompetensi['nilai_skp']);
            $i++;
            $spreadsheet->getActiveSheet()->getStyle('A'.(5+$i).':'.'N'.(5+$i))->applyFromArray($styleArrayBackColorCellData);
            if($dataKompetensi['flag_pendidikan']=='Y'){
                $jmlFlgPendidikan++;
                $spreadsheet->getActiveSheet()->getStyle('G'.(5+$i).':'.'G'.(5+$i))->applyFromArray($styleArrayBackColorMerahMuda2);
            }
            if($dataKompetensi['flag_pelatihan']=='Y'){
                $jmlFlgPelatihan++;
                $spreadsheet->getActiveSheet()->getStyle('I'.(5+$i).':'.'I'.(5+$i))->applyFromArray($styleArrayBackColorMerahMuda2);
            }
            if($dataKompetensi['flag_pengalaman']=='Y'){
                $jmlFlgPengalaman++;
                $spreadsheet->getActiveSheet()->getStyle('K'.(5+$i).':'.'K'.(5+$i))->applyFromArray($styleArrayBackColorMerahMuda2);
            }
            if($dataKompetensi['flag_administrasi']=='Y'){
                $jmlFlgAdministrasi++;
                $spreadsheet->getActiveSheet()->getStyle('M'.(5+$i).':'.'M'.(5+$i))->applyFromArray($styleArrayBackColorMerahMuda2);
            }
            if($dataKompetensi['skor_gap_asn'] > 0){
                $jmlSkorGapAsn += $dataKompetensi['skor_gap_asn'];
                $spreadsheet->getActiveSheet()->getStyle('N'.(5+$i).':'.'N'.(5+$i))->applyFromArray($styleArrayBackColorMerahMuda1);
            }
            $jmlNilaiSKP += $dataKompetensi['nilai_skp'];
        }

        $jml_pejabat=$i;
        $rataRataSKP = ($jmlNilaiSKP/$i);
        $spreadsheet->getActiveSheet()->getStyle('A6:A'.(5+$i))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $spreadsheet->getActiveSheet()->getStyle('B6:F'.(5+$i))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        $spreadsheet->getActiveSheet()->getStyle('G6:G'.(5+$i))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $spreadsheet->getActiveSheet()->getStyle('I6:I'.(5+$i))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $spreadsheet->getActiveSheet()->getStyle('K6:K'.(5+$i))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $spreadsheet->getActiveSheet()->getStyle('M6:M'.(5+$i))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $spreadsheet->getActiveSheet()->getStyle('N6:N'.(5+$i))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $spreadsheet->getActiveSheet()->getStyle('A6:N'.(5+$i))->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP);
        $spreadsheet->getActiveSheet()->getStyle('A6:N'.(5+$i).$spreadsheet->getActiveSheet()->getHighestRow())->getAlignment()->setWrapText(true);

        $spreadsheet->getActiveSheet()->setCellValue('L'.(5+$i+1), 'Jumlah');
        $spreadsheet->getActiveSheet()->mergeCells('L'.(5+$i+1).':M'.(5+$i+1));
        $spreadsheet->getActiveSheet()->setCellValue('L'.(5+$i+2), 'Gaps');
        $spreadsheet->getActiveSheet()->mergeCells('L'.(5+$i+2).':M'.(5+$i+2));
        $spreadsheet->getActiveSheet()->setCellValue('N'.(5+$i+1), round($jmlSkorGapAsn,2));
        $spreadsheet->getActiveSheet()->setCellValue('N'.(5+$i+2), round(($jmlSkorGapAsn/$i),2));
        $spreadsheet->getActiveSheet()->getStyle('A'.(5+$i+1).':'.'N'.(5+$i+4))->applyFromArray($styleArrayBackColorCellData);
        $spreadsheet->getActiveSheet()->getStyle('N'.(5+$i+2).':'.'N'.(5+$i+2))->applyFromArray($styleArrayBackColorKuning);
        $gap1=round(($jmlSkorGapAsn/$i),2);

        $spreadsheet->getActiveSheet()->setCellValue('F'.(5+$i+3), 'Y');
        $spreadsheet->getActiveSheet()->setCellValue('F'.(5+$i+4), 'N');
        $spreadsheet->getActiveSheet()->setCellValue('G'.(5+$i+3), $jmlFlgPendidikan);
        $spreadsheet->getActiveSheet()->setCellValue('G'.(5+$i+4), ($i-$jmlFlgPendidikan));

        $spreadsheet->getActiveSheet()->setCellValue('H'.(5+$i+3), 'Y');
        $spreadsheet->getActiveSheet()->setCellValue('H'.(5+$i+4), 'N');
        $spreadsheet->getActiveSheet()->setCellValue('I'.(5+$i+3), $jmlFlgPelatihan);
        $spreadsheet->getActiveSheet()->setCellValue('I'.(5+$i+4), ($i-$jmlFlgPelatihan));

        $spreadsheet->getActiveSheet()->setCellValue('J'.(5+$i+3), 'Y');
        $spreadsheet->getActiveSheet()->setCellValue('J'.(5+$i+4), 'N');
        $spreadsheet->getActiveSheet()->setCellValue('K'.(5+$i+3), $jmlFlgPengalaman);
        $spreadsheet->getActiveSheet()->setCellValue('K'.(5+$i+4), ($i-$jmlFlgPengalaman));

        $spreadsheet->getActiveSheet()->setCellValue('L'.(5+$i+3), 'Y');
        $spreadsheet->getActiveSheet()->setCellValue('L'.(5+$i+4), 'N');
        $spreadsheet->getActiveSheet()->setCellValue('M'.(5+$i+3), $jmlFlgAdministrasi);
        $spreadsheet->getActiveSheet()->setCellValue('M'.(5+$i+4), ($i-$jmlFlgAdministrasi));

        $spreadsheet->getActiveSheet()->getStyle('A4:N'.(5+$i+4))->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->freezePane('A6');
        $spreadsheet->getActiveSheet()->getSheetView()->setZoomScale(85);

        // Add some data
        $spreadsheet->getActiveSheet()->fromArray($dataArray, NULL, 'A6');
        $dataArray = null;
        //----------------------------------------------

        // Add new sheet 2
        $objWorkSheet = $spreadsheet->createSheet(1); //Setting index when creating
        // Rename sheet
        $objWorkSheet->setTitle('2. Kompensasi');
        $objWorkSheet->mergeCells('A1:G1');
        $objWorkSheet->getStyle('A1:G1')->getFont()->setBold(true);
        $objWorkSheet->getStyle('A1:G1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $objWorkSheet->getStyle('A1:G1')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $objWorkSheet->setCellValue('A1', 'Metode Perhitungan Kompensasi');
        $objWorkSheet->setCellValue('A2', 'Unit : '.$nama_skpd);
        $objWorkSheet->setCellValue('A4', 'No');
        $objWorkSheet->setCellValue('B4', 'Eselon');
        $objWorkSheet->setCellValue('C4', 'Jumlah Pejabat');
        $objWorkSheet->setCellValue('D4', 'Tertinggi');
        $objWorkSheet->setCellValue('E4', 'Terrendah');
        $objWorkSheet->setCellValue('F4', 'Selisih');
        $objWorkSheet->setCellValue('G4', 'Selisih terhadap Terrendah');
        $objWorkSheet->getStyle('A4:G4')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $objWorkSheet->getStyle('A4:G4')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $objWorkSheet->getStyle('A4:G4')->applyFromArray($styleArrayHeader);
        $objWorkSheet->getColumnDimension('A')->setWidth(5); // No
        $objWorkSheet->getColumnDimension('B')->setWidth(10); // Eselon
        $objWorkSheet->getColumnDimension('C')->setWidth(15); // Jumlah Pejabat
        $objWorkSheet->getColumnDimension('D')->setWidth(20); // Tertinggi
        $objWorkSheet->getColumnDimension('E')->setWidth(20); // Terrendah
        $objWorkSheet->getColumnDimension('F')->setWidth(20); // Selisih
        $objWorkSheet->getColumnDimension('G')->setWidth(20); // Selisih terhadap Terrendah
        $objWorkSheet->getStyle('A4:G4'.$spreadsheet->getActiveSheet()->getHighestRow())->getAlignment()->setWrapText(true);
        $i = 0;
        $data = null;
        $jmlPersenSelisih = 0;
        $list_kompensasi = $this->ipp_asn_model->getKompensasi($idopd);
        foreach ($list_kompensasi as $row){
            $data[$i] = $row;
            $dataArray[$i] = array($i+1, $data[$i]->eselon, $data[$i]->jml_pegawai, $data[$i]->tertinggi,
                $data[$i]->terendah, $data[$i]->selisih, $data[$i]->persentase);
            $jmlPersenSelisih += $data[$i]->persentase;
            $i++;
        }

        $objWorkSheet->getStyle('A5:A'.($i+4))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $objWorkSheet->getStyle('B5:B'.($i+4))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $objWorkSheet->getStyle('C5:C'.($i+4))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $objWorkSheet->getStyle('D5:F'.($i+4))->getNumberFormat()->setFormatCode('#,##0.00');
        $objWorkSheet->setCellValue('B'.($i+4+1), 'Total');
        $objWorkSheet->getStyle('B'.($i+4+1).':'.'B'.($i+4+1))->getFont()->setBold(true);
        $objWorkSheet->setCellValue('G'.($i+4+1), $jmlPersenSelisih);
        $objWorkSheet->getStyle('A4:G'.($i+4+1))->applyFromArray($styleArray);
        $objWorkSheet->getStyle('A5:G'.($i+4+1))->applyFromArray($styleArrayBackColorCellData);
        $gap2=round($jmlPersenSelisih,2);

        // Add some data
        $objWorkSheet->fromArray($dataArray, NULL, 'A5');
        $dataArray = null;
        //----------------------------------------------

        // Add new sheet 3
        $objWorkSheet = $spreadsheet->createSheet(2); //Setting index when creating
        // Rename sheet
        $objWorkSheet->setTitle('3. Kinerja');
        $objWorkSheet->mergeCells('A1:K1');
        $objWorkSheet->getStyle('A1:K1')->getFont()->setBold(true);
        $objWorkSheet->getStyle('A1:K1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $objWorkSheet->getStyle('A1:K1')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $objWorkSheet->setCellValue('A1', 'Metode Perhitungan Kinerja');
        $objWorkSheet->setCellValue('A2', 'Unit : '.$nama_skpd);
        $objWorkSheet->mergeCells('A4:C4');
        $objWorkSheet->setCellValue('A4', 'Rata-rata Kinerja (SKP)');
        $objWorkSheet->mergeCells('D4:F4');
        $objWorkSheet->getStyle('A4:D4')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $objWorkSheet->getStyle('A4:D4')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $objWorkSheet->getStyle('A4:F4')->applyFromArray($styleArray);

        $objWorkSheet->setCellValue('H4', 'No');
        $objWorkSheet->setCellValue('I4', 'Jabatan');
        $objWorkSheet->setCellValue('J4', 'Nama');
        $objWorkSheet->setCellValue('K4', 'Nilai SKP');
        $objWorkSheet->getStyle('H4:K4')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $objWorkSheet->getStyle('H4:K4')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $objWorkSheet->getStyle('H4:K4')->applyFromArray($styleArrayHeader);
        $objWorkSheet->getColumnDimension('H')->setWidth(5); // No
        $objWorkSheet->getColumnDimension('I')->setWidth(50); // Jabatan
        $objWorkSheet->getColumnDimension('J')->setWidth(30); // Nama
        $objWorkSheet->getColumnDimension('K')->setWidth(15); // Nilai SKP
        $objWorkSheet->getRowDimension('4')->setRowHeight(25);
        $objWorkSheet->getStyle('H5:H'.(count($dataArrayKinerja)+4))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $objWorkSheet->getStyle('H5:K'.(count($dataArrayKinerja)+4))->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP);
        $objWorkSheet->getStyle('I5:J'.(count($dataArrayKinerja)+4).$spreadsheet->getActiveSheet()->getHighestRow())->getAlignment()->setWrapText(true);
        $objWorkSheet->freezePane('A5');
        $objWorkSheet->setCellValue('I'.(count($dataArrayKinerja)+4+1), 'Jumlah');
        $objWorkSheet->setCellValue('I'.(count($dataArrayKinerja)+4+2), 'Rata-rata');
        $objWorkSheet->setCellValue('K'.(count($dataArrayKinerja)+4+1), round($jmlNilaiSKP,2));
        $objWorkSheet->setCellValue('K'.(count($dataArrayKinerja)+4+2), round($rataRataSKP,2));
        $objWorkSheet->getStyle('H4:K'.(count($dataArrayKinerja)+4+2))->applyFromArray($styleArray);
        $objWorkSheet->getStyle('I'.(count($dataArrayKinerja)+4+1).':'.'K'.(count($dataArrayKinerja)+4+2))->getFont()->setBold(true);
        $objWorkSheet->setCellValue('D4', round($rataRataSKP,2));
        $objWorkSheet->getStyle('A4:D4')->getFont()->setBold(true);
        $objWorkSheet->getStyle('A4:A4')->applyFromArray($styleArrayBiruMuda);
        $objWorkSheet->getStyle('D4:D4')->applyFromArray($styleArrayBiruTua);

        $gap3=round($rataRataSKP,2);

        // Add some data
        $objWorkSheet->fromArray($dataArrayKinerja, NULL, 'A5');
        $dataArrayKinerja = null;

        //----------------------------------------------

        // Add new sheet 4
        $objWorkSheet = $spreadsheet->createSheet(3); //Setting index when creating
        // Rename sheet
        $objWorkSheet->setTitle('4. Disiplin');
        $objWorkSheet->mergeCells('A1:D1');
        $objWorkSheet->getStyle('A1:D1')->getFont()->setBold(true);
        $objWorkSheet->getStyle('A1:D1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $objWorkSheet->getStyle('A1:D1')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $objWorkSheet->setCellValue('A1', 'Metode Perhitungan Disiplin');
        $objWorkSheet->setCellValue('A2', 'Unit : '.$nama_skpd);
        $objWorkSheet->setCellValue('A4', 'No');
        $objWorkSheet->setCellValue('B4', 'Jenis Pelanggaran');
        $objWorkSheet->setCellValue('C4', 'Jumlah');
        $objWorkSheet->setCellValue('D4', 'Total');
        $objWorkSheet->getStyle('A4:D4')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $objWorkSheet->getStyle('A4:D4')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $objWorkSheet->getStyle('A4:D4')->applyFromArray($styleArrayHeader);
        $objWorkSheet->getColumnDimension('A')->setWidth(5); // No
        $objWorkSheet->getColumnDimension('B')->setWidth(40); // Jenis Pelanggaran
        $objWorkSheet->getColumnDimension('C')->setWidth(15); // Jumlah
        $objWorkSheet->getColumnDimension('D')->setWidth(20); // Total
        $objWorkSheet->getStyle('A4:D5'.$spreadsheet->getActiveSheet()->getHighestRow())->getAlignment()->setWrapText(true);
        $objWorkSheet->setCellValue('A5', '1');
        $objWorkSheet->setCellValue('A6', '2');
        $objWorkSheet->setCellValue('A7', '3');
        $objWorkSheet->setCellValue('A8', '');
        $objWorkSheet->setCellValue('A9', '');
        $objWorkSheet->setCellValue('B5', 'Ringan');
        $objWorkSheet->setCellValue('B6', 'Sedang');
        $objWorkSheet->setCellValue('B7', 'Berat');
        $objWorkSheet->setCellValue('B8', 'Total Karyawan');
        $objWorkSheet->setCellValue('B9', '');
        $hukdis = $this->ipp_asn_model->getHukuman($idopd);

        if (@$hukdis->ringan!=NULL) {
            $ringan = $hukdis->ringan;
        }else {
            $ringan = 0;
        }
        if (@$hukdis->sedang!=NULL) {
            $sedang = $hukdis->sedang;
        }else {
            $sedang = 0;
        }
        if (@$hukdis->berat!=NULL) {
            $berat = $hukdis->berat;
        }else {
            $berat = 0;
        }
        $objWorkSheet->setCellValue('C6', $sedang);
        $objWorkSheet->setCellValue('C7', $berat);
        $objWorkSheet->setCellValue('C8', $jml_pejabat);


        $objWorkSheet->setCellValue('D5', $ringan);
        $objWorkSheet->setCellValue('D6', $sedang*2);
        $objWorkSheet->setCellValue('D7', $berat*3);
        $objWorkSheet->setCellValue('D8', $ringan+($sedang*2)+($berat*3));

        $thukdis=($ringan+($sedang*2)+($berat*3))/$jml_pejabat;

        $objWorkSheet->setCellValue('C9', 'Pelanggaran');
        $objWorkSheet->setCellValue('D9', round($thukdis,2));
        $gap4=round($thukdis,2);
        $objWorkSheet->getStyle('A4:D9')->applyFromArray($styleArray);
        $objWorkSheet->getStyle('A5:D9')->applyFromArray($styleArrayBackColorCellData);
        $objWorkSheet->getRowDimension('4')->setRowHeight(21);
        //----------------------------------------------

        // Add new sheet 5
        $objWorkSheet = $spreadsheet->createSheet(4); //Setting index when creating
        // Rename sheet
        $objWorkSheet->setTitle('Cetak IPP');
        $objWorkSheet->mergeCells('A1:C1');
        $objWorkSheet->getStyle('A1:C1')->getFont()->setBold(true);
        $objWorkSheet->getStyle('A1:C1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $objWorkSheet->getStyle('A1:C1')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $objWorkSheet->setCellValue('A1', ' Indeks Profesional Pegawai (IPP)');
        $objWorkSheet->mergeCells('A2:C2');
        $objWorkSheet->getStyle('A2:C2')->getFont()->setBold(true);
        $objWorkSheet->getStyle('A2:C2')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $objWorkSheet->getStyle('A2:C2')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $objWorkSheet->setCellValue('A2', 'PEMERINTAH KOTA BOGOR');
        $objWorkSheet->setCellValue('A3', 'Unit : '.$nama_skpd);
        $objWorkSheet->getColumnDimension('A')->setWidth(5);
        $objWorkSheet->getColumnDimension('B')->setWidth(40);
        $objWorkSheet->getColumnDimension('C')->setWidth(27);
        $objWorkSheet->setCellValue('A5', 'No');
        $objWorkSheet->setCellValue('B5', 'Unsur Penilaian');
        $objWorkSheet->setCellValue('C5', 'Nilai');
        $objWorkSheet->getStyle('A5:C5')->applyFromArray($styleArrayHeader);
        $objWorkSheet->getStyle('A5:C5')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $objWorkSheet->getStyle('A5:C5')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $objWorkSheet->getRowDimension('5')->setRowHeight(21);

        $objWorkSheet->setCellValue('A6', 'A');
        $objWorkSheet->setCellValue('B6', 'Gap Kompetensi');
        $objWorkSheet->setCellValue('C6', $gap1);

        $objWorkSheet->setCellValue('A7', 'B');
        $objWorkSheet->setCellValue('B7', 'Gap Kompensasi');
        $objWorkSheet->setCellValue('C7', $gap2);

        $objWorkSheet->setCellValue('A8', 'C');
        $objWorkSheet->setCellValue('B8', 'Kinerja');
        $objWorkSheet->setCellValue('C8', $gap3);

        $objWorkSheet->setCellValue('A9', 'D');
        $objWorkSheet->setCellValue('B9', 'Indisipliner');
        $objWorkSheet->setCellValue('C9', $gap4);

        $ippasn=round((25*(1-$gap1))+(25*(1-$gap2))+((25*$gap3)/100)+(25*(1-$gap4)),2);
        $objWorkSheet->setCellValue('A10', 'Indeks Profesional Pegawai (IPP) :');
        $objWorkSheet->setCellValue('C10', $ippasn);
        $objWorkSheet->getStyle('C10:C10')->getFont()->setBold(true);
        $objWorkSheet->getStyle('A5:C10')->applyFromArray($styleArray);
        $objWorkSheet->mergeCells('A10:B10');
        $objWorkSheet->getStyle('A10:A10')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $objWorkSheet->getStyle('A10:C10')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $objWorkSheet->getRowDimension('10')->setRowHeight(28);
        $objWorkSheet->setCellValue('B12', 'Rumus IPP:');
        $objWorkSheet->setCellValue('B13', "(25 x (1 - A)) + (25 x (1 -B)) + ((25 x C)/100) + (25 x (1 - D))");

        $jabKosong = $this->ipp_asn_model->getJabatanKosong($idopd);
        if(isset($jabKosong->jml) and $jabKosong->jml!=''){
            $jabKosong = $jabKosong->jml;
        }else{
            $jabKosong = 0;
        }

        $objWorkSheet->setCellValue('B15', 'Catatan:');
        $objWorkSheet->getStyle('B15:B15')->getFont()->setBold(true);
        $objWorkSheet->setCellValue('B16', '1. Gap Pendidikan = '.$jmlFlgPendidikan.' pegawai');
        $objWorkSheet->setCellValue('B17', '2. Gap Pelatihan = '.$jmlFlgPelatihan.' pegawai');
        $objWorkSheet->setCellValue('B18', '3. Gap Pengalaman = '.$jmlFlgPengalaman.' pegawai');
        $objWorkSheet->setCellValue('B19', '4. Gap Administrasi = '.$jmlFlgAdministrasi.' pegawai');
        $objWorkSheet->setCellValue('B20', '5. Jabatan Kosong = '.$jabKosong);
        $objWorkSheet->setCellValue('C22', 'Bogor,           '.$this->ipp_asn_model->getNamaBulan(date("m")).' '.date("Y"));
        $objWorkSheet->setCellValue('C23', 'Kepala');
        $pjbt = $this->ipp_asn_model->getNamaPejabat($idopd);
        $objWorkSheet->setCellValue('C28', $pjbt['nama']);
        $objWorkSheet->getStyle('C28:C28')->getFont()->setBold(true);
        $objWorkSheet->setCellValue('C29', 'NIP. '.$pjbt['nip']);
        //----------------------------------------------

        $writer = new Xlsx($spreadsheet);
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="Laporan_IPPASN_'.$nama_skpd.'.xlsx"');
        header('Cache-Control: max-age=0');
        $writer->save("php://output");

    }
}
?>