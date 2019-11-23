<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Report_absensi extends CI_Controller {
    function __construct(){
        parent::__construct();
        $this->load->model("report_absensi_model");
        $this->load->model("umum_model", "umum");
        $this->load->library('format');
        $this->load->library('pagerv2');
    }

    public function index(){
        $this->list_report_absensi();
    }

    public function list_report_absensi(){
        $this->load->view('layout/header', array( 'title' => 'Report Absensi Pegawai Negeri Sipil', 'idproses' => 0));
        $getSKPD = $this->report_absensi_model->getSKPD();
        $getStatus = $this->report_absensi_model->getStatusAbsen(0);
        $idskpd = $this->input->get('idskpd');
        if(isset($idskpd) and $idskpd==''){
            $idskpd = 4789;
        }
        $status = $this->input->get('status');
        $tgl = $this->input->get('tgl');
        $jenjab = $this->input->get('jenjab');
        $keywordCari = $this->input->get('keywordCari');
        $start = 0;

        $num_rows = $this->report_absensi_model->countListDataAbsensi($idskpd, $tgl, $status, $jenjab, $keywordCari);
        if($num_rows>0){
            if($this->input->get('page')==''){
                $start = 1;
            }else{
                $start = ($this->input->get('page')*$this->input->get('ipp'))-($this->input->get('ipp')-1);
            }
            $pages = new Paginator($num_rows,9,array(15,25,50,100,'All'));
            $pgDisplay = $pages->display_pages();
            $curpage = $pages->current_page;
            $numpage = $pages->num_pages;
            $total_items = $pages->total_items;
            $jumppage = $pages->display_jump_menu();
            $item_perpage = $pages->display_items_per_page();
            $list_data = $this->report_absensi_model->listDataAbsensi($pages->limit_start,$idskpd,$tgl,$status,$jenjab,$keywordCari,$pages->limit_end);
        }else{
            $pgDisplay = '';
            $curpage = '';
            $numpage = '';
            $total_items = '';
            $jumppage = '';
            $item_perpage = '';
            $list_data = '';
        }

        $this->load->view('report_absensi/header');
        $this->load->view('report_absensi/list_report_absensi',
            array(
                'list_skpd' => $getSKPD,
                'list_status' => $getStatus,
                'list_data' => $list_data,
                'idskpd' => $idskpd,
                'idstatus' => $status,
                'tgl' => $tgl,
                'start' => $start,
                'pgDisplay' => $pgDisplay,
                'curpage' => $curpage,
                'numpage' => $numpage,
                'total_items' => $total_items,
                'jumppage' => $jumppage,
                'item_perpage' => $item_perpage,
                'jenjab' => $jenjab,
                'keywordCari' => $keywordCari
            ));
        $this->load->view('layout/footer');
    }

    public function rekap_jumlah_opd(){
        $this->load->view('layout/header', array( 'title' => 'Rekapitulasi Jumlah Per OPD', 'idproses' => 1));
        $this->load->view('report_absensi/header');
        $getSKPD = $this->report_absensi_model->getSKPD();
        $idunit = $this->input->get('idunit');
        $idskpd = $this->input->get('idskpd');
        $bln = $this->input->get('bln');
        $thn = $this->input->get('thn');

        if(isset($idunit) and $idunit==''){
            $idunit = 4789;
        }
        if(isset($idskpd) and $idskpd==''){
            $idskpd = 4789;
        }
        if(isset($bln) and $bln==''){
            $bln = date("m");
        }
        if(isset($thn) and $thn==''){
            $thn = date("Y");
        }

        $a_date = "$thn-$bln-01";
        $maxday = date("t", strtotime($a_date));

        $getUnit = $this->umum->getUnitKerjaByIdSKPD($idskpd);
        $rekap_jumlah = $this->report_absensi_model->rekapJumlahOPD('', $bln, $thn, $idskpd, $idunit);

        $this->load->view('report_absensi/rekap_jumlah_opd',
        array(
            'list_skpd' => $getSKPD,
            'list_uk' => $getUnit,
            'idskpd' => $idskpd,
            'idunit' => $idunit,
            'bln' => $bln,
            'thn' => $thn,
            'rekap_jumlah' => $rekap_jumlah,
            'maxday' => $maxday
        ));
        $this->load->view('layout/footer');

    }

    public function rekap_list_opd(){
        $this->load->view('layout/header', array( 'title' => 'Rekapitulasi Jumlah Per OPD', 'idproses' => 2));
        $this->load->view('report_absensi/header');
        $getSKPD = $this->report_absensi_model->getSKPD();
        $bln = $this->input->get('bln');
        $thn = $this->input->get('thn');
        $idskpd = $this->input->get('idskpd');
        $idunit = $this->input->get('idunit');

        if(isset($idunit) and $idunit==''){
            $idunit = 4789;
        }
        if(isset($idskpd) and $idskpd==''){
            $idskpd = 4789;
        }
        if(isset($bln) and $bln==''){
            $bln = date("m");
        }
        if(isset($thn) and $thn==''){
            $thn = date("Y");
        }

        $a_date = "$thn-$bln-01";
        $maxday = date("t", strtotime($a_date));

        $getUnit = $this->umum->getUnitKerjaByIdSKPD($idskpd);
        $rekap_list = $this->report_absensi_model->rekapListOPD($bln, $thn, $idskpd, $idunit, '');

        $this->load->view('report_absensi/rekap_list_opd',
        array(
            'list_skpd' => $getSKPD,
            'list_uk' => $getUnit,
            'idskpd' => $idskpd,
            'idunit' => $idunit,
            'bln' => $bln,
            'thn' => $thn,
            'rekap_list' => $rekap_list,
            'maxday' => $maxday
        ));
        $this->load->view('layout/footer');
    }

    public function getListUnitKerja(){
        $idskpd = $this->input->post('idskpd');
        $getUnit = $this->umum->getUnitKerjaByIdSKPD($idskpd);
        $idunit = $this->input->get('idunit');
        if(isset($idunit) and $idunit==''){
            $idunit = 4789;
        }
        $this->load->view('report_absensi/load_uk_byskpd',
        array(
            'list_uk' => $getUnit,
            'idunit' => $idunit
        ));
    }


    public function detail_list_pegawai_by_periode(){

    }

    public function cetak_rekap_jumlah(){
        $bln = $this->input->get('bln');
        $thn = $this->input->get('thn');
        $idskpd = $this->input->get('idskpd');
        $idunit = $this->input->get('idunit');
        $a_date = "$thn-$bln-01";
        $maxday = date("t", strtotime($a_date));

        $rekap_jumlah = $this->report_absensi_model->rekapJumlahOPD('', $bln, $thn, $idskpd, $idunit);

        $this->load->view('report_absensi/cetak_rekap_jumlah',
        array(
            'bln' => $bln,
            'thn' => $thn,
            'rekap_jumlah' => $rekap_jumlah,
            'maxday' => $maxday,
            'idskpd' => $idskpd
        ));
    }

    public function cetak_absen_by_hari(){
        $hari = $this->input->get('hari');
        $bln = $this->input->get('bln');
        $thn = $this->input->get('thn');
        $idskpd = $this->input->get('idskpd');
        $idunit = $this->input->get('idunit');
        $a_date = "$thn-$bln-01";
        $maxday = date("t", strtotime($a_date));
        $rekap_list = $this->report_absensi_model->rekapListOPD($bln, $thn, $idskpd, $idunit,'');
        $unit_kerja = $this->umum->getUnitKerjaByIdUnitKerja($idunit);

        $this->load->view('report_absensi/cetak_absen_by_hari',
        array(
            'hari' => $hari,
            'bln' => $bln,
            'thn' => $thn,
            'rekap_list' => $rekap_list,
            'maxday' => $maxday,
            'idskpd' => $idskpd,
            'unit_kerja' => $unit_kerja
        ));
    }

    public function cetak_list_daftar(){
        $bln = $this->input->get('bln');
        $thn = $this->input->get('thn');
        $idskpd = $this->input->get('idskpd');
        $idunit = $this->input->get('idunit');
        $a_date = "$thn-$bln-01";
        $maxday = date("t", strtotime($a_date));
        $rekap_list = $this->report_absensi_model->rekapListOPD($bln, $thn, $idskpd, $idunit, '');
        $unit_kerja = $this->umum->getUnitKerjaByIdUnitKerja($idunit);
        $this->load->view('report_absensi/cetak_list_daftar',
            array(
                'bln' => $bln,
                'thn' => $thn,
                'rekap_list' => $rekap_list,
                'maxday' => $maxday,
                'idskpd' => $idskpd,
                'unit_kerja' => $unit_kerja
            ));
    }

    public function cetak_list_jumlah(){
        $bln = $this->input->get('bln');
        $thn = $this->input->get('thn');
        $idskpd = $this->input->get('idskpd');
        $idunit = $this->input->get('idunit');
        $a_date = "$thn-$bln-01";
        $maxday = date("t", strtotime($a_date));
        $getUnit = $this->umum->getUnitKerjaByIdUnitKerja($idunit);
        $rekap_list = $this->report_absensi_model->rekapListOPD($bln, $thn, $idskpd, $idunit, '');
        $this->load->view('report_absensi/cetak_list_jumlah',
            array(
                'bln' => $bln,
                'thn' => $thn,
                'rekap_list' => $rekap_list,
                'maxday' => $maxday,
                'idskpd' => $idskpd,
                'unit_kerja' => $getUnit
            ));
    }

    public function cetak_absen_by_pegawai(){
        $nip = $this->input->get('nip');
        $bln = $this->input->get('bln');
        $thn = $this->input->get('thn');
        $idskpd = $this->input->get('idskpd');
        $idunit = $this->input->get('idunit');
        $a_date = "$thn-$bln-01";
        $maxday = date("t", strtotime($a_date));
        $getUnit = $this->umum->getUnitKerjaByIdSKPD($idskpd);
        $rekap_list = $this->report_absensi_model->rekapListOPD($bln, $thn, $idskpd, $idunit, $nip);
        $infoPegawai = $this->umum->infoPegawai($nip);
        $this->load->view('report_absensi/cetak_absen_by_pegawai',
            array(
                'bln' => $bln,
                'thn' => $thn,
                'rekap_list' => $rekap_list,
                'infoPegawai' => $infoPegawai,
                'maxday' => $maxday,
                'idskpd' => $idskpd,
                'unit_kerja' => $getUnit
            ));
    }

    //================================================================================================================//
    //================================================================================================================//

    public function profil_absensi(){
        $this->load->view('layout/header', array( 'title' => 'Profil Absensi Pegawai Negeri Sipil', 'idproses' => 1));
        $this->load->view('report_absensi/header');
        $getSKPD = $this->report_absensi_model->getSKPD();
        $idskpd = $this->input->get('idskpd');
        $bln = $this->input->get('bln');
        $thn = $this->input->get('thn');
        if(isset($idskpd) and $idskpd==''){
            $idskpd = 4789;
        }
        if(isset($bln) and $bln==''){
            $bln = date("m");
        }
        if(isset($thn) and $thn==''){
            $thn = date("Y");
        }
        //echo $idskpd.' '.(int)$bln.' '.(int)$thn;
        $profil1 = $this->report_absensi_model->getProfilAbsensi1($bln, $thn, $idskpd);
        $profil2 = $this->report_absensi_model->getProfilAbsensi2($bln, $thn, $idskpd);
        $profil3 = $this->report_absensi_model->getProfilAbsensi3($bln, $thn);

        foreach($profil2 as $pro) {
            $data1[0] = array(
                'name' => 'Tidak Hadir',
                'y' => $pro->absen_persen_jml_hari
            );
            $data1[1] = array(
                'name' => 'Hadir',
                'y' => $pro->persen_hadir_jml_hari
            );
            $data2[0] = array(
                'name' => 'Tidak Hadir',
                'y' => $pro->absen_persen_jml_org
            );
            $data2[1] = array(
                'name' => 'Hadir',
                'y' => $pro->hadir_persen_jml_org
            );
            $data3[0] = $pro->total_harikerja;
            $data3[1] = $pro->hadir_jml_hari;
            $data3[2] = $pro->absen_jml_hari;

            $data4[0] = $pro->total_pegawai;
            $data4[1] = $pro->hadir_jml_org;
            $data4[2] = $pro->absen_jml_org;
        }

        $this->load->view('report_absensi/profil_absensi',
            array(
                'list_skpd' => $getSKPD,
                'profil1' => $profil1,
                'profil3' => $profil3,
                'idskpd' => $idskpd,
                'bln' => $bln,
                'thn' => $thn,
                'chart1' => json_encode($data1, JSON_NUMERIC_CHECK),
                'chart2' => json_encode($data2, JSON_NUMERIC_CHECK),
                'chart3' => json_encode($data3, JSON_NUMERIC_CHECK),
                'chart4' => json_encode($data4, JSON_NUMERIC_CHECK)
            ));
        $this->load->view('layout/footer');
    }

    public function print_profil_absensi(){
        $bln = $this->input->get('bln');
        $thn = $this->input->get('thn');
        if(isset($bln) and $bln==''){
            $bln = date("m");
        }
        if(isset($thn) and $thn==''){
            $thn = date("Y");
        }
        $profil3 = $this->report_absensi_model->getProfilAbsensi3($bln, $thn);
        $this->load->view('report_absensi/print_profil_absensi',
            array(
                'profil3' => $profil3,
                'bln' => $bln,
                'thn' => $thn
            ));
    }
	
	public function print_rekap_bulanan(){
        $idskpd = $this->input->get('idskpd');
        $bln = $this->input->get('bln');
        $thn = $this->input->get('thn');
        if(isset($idskpd) and $idskpd==''){
            $idskpd = 4789;
        }
        if(isset($bln) and $bln==''){
            $bln = date("m");
        }
        if(isset($thn) and $thn==''){
            $thn = date("Y");
        }
        $rekap1 = $this->report_absensi_model->getRekapAbsensiBulanan($bln, $thn, $idskpd);
		$uk = $this->report_absensi_model->getNamaUnitKerja($idskpd);
        $this->load->view('report_absensi/print_bulanan',
            array(
               
                'rekap1' => $rekap1,
                'idskpd' => $idskpd,
                'bln' => $bln,
                'thn' => $thn,
				'uk' => $uk[0]->opd,
				'bos' => $uk[0]->nama,
				'jabatan' => $uk[0]->jabatan,
				'nip'=> $uk[0]->nip_baru
            ));
		
	}

    public function print_rekap_pegawai($bln,$thn,$idskpd){
        $idskpd = $this->input->get('idskpd');
        $bln = $this->input->get('bln');
        $thn = $this->input->get('thn');
        if(isset($idskpd) and $idskpd==''){
            $idskpd = 4789;
        }
        if(isset($bln) and $bln==''){
            $bln = date("m");
        }
        if(isset($thn) and $thn==''){
            $thn = date("Y");
        }
        $rekap1 = $this->report_absensi_model->getRekapAbsensiPegawai($bln, $thn, $idskpd);
        $uk = $this->report_absensi_model->getNamaUnitKerja($idskpd);
        $this->load->view('report_absensi/print_rekap_pegawai',
            array(

                'rekap2' => $rekap1,
                'idskpd' => $idskpd,
                'bln' => $bln,
                'thn' => $thn,
                'uk' => $uk[0]->opd,
                'bos' => $uk[0]->nama,
                'jabatan' => $uk[0]->jabatan,
                'nip'=> $uk[0]->nip_baru
            ));

    }

    public function rekapitulasi_bulanan(){
        $this->load->view('layout/header', array( 'title' => 'Rekapitulasi Bulanan Absensi Pegawai Negeri Sipil', 'idproses' => 2));
        $this->load->view('report_absensi/header');
        $getSKPD = $this->report_absensi_model->getSKPD();
        $idskpd = $this->input->get('idskpd');
        $bln = $this->input->get('bln');
        $thn = $this->input->get('thn');
        if(isset($idskpd) and $idskpd==''){
            $idskpd = 4789;
        }
        if(isset($bln) and $bln==''){
            $bln = date("m");
        }
        if(isset($thn) and $thn==''){
            $thn = date("Y");
        }
        $rekap1 = $this->report_absensi_model->getRekapAbsensiBulanan($bln, $thn, $idskpd);
        $this->load->view('report_absensi/rekapitulasi_bulanan',
            array(
                'list_skpd' => $getSKPD,
                'rekap1' => $rekap1,
                'idskpd' => $idskpd,
                'bln' => $bln,
                'thn' => $thn
            ));
        $this->load->view('layout/footer');
    }

    public function rekapitulasi_pegawai(){
        $this->load->view('layout/header', array( 'title' => 'Rekapitulasi Absensi Pegawai Negeri Sipil', 'idproses' => 3));
        $this->load->view('report_absensi/header');
        $getSKPD = $this->report_absensi_model->getSKPD();
        $idskpd = $this->input->get('idskpd');
        $bln = $this->input->get('bln');
        $thn = $this->input->get('thn');
        if(isset($idskpd) and $idskpd==''){
            $idskpd = 4789;
        }
        if(isset($bln) and $bln==''){
            $bln = date("m");
        }
        if(isset($thn) and $thn==''){
            $thn = date("Y");
        }
        $rekap2 = $this->report_absensi_model->getRekapAbsensiPegawai($bln, $thn, $idskpd);
        $this->load->view('report_absensi/rekapitulasi_pegawai',
            array(
                'list_skpd' => $getSKPD,
                'rekap2' => $rekap2,
                'idskpd' => $idskpd,
                'bln' => $bln,
                'thn' => $thn
            ));
        $this->load->view('layout/footer');

    }

    public function detail_list_pegawai(){
        $bln = $this->input->post('bln');
        $thn = $this->input->post('thn');
        $idskpd = $this->input->post('idskpd');
        $auth = $this->input->post('auth');
        $status = $this->input->post('status');
        $listdata = $this->report_absensi_model->getDetailListPegawai($bln, $thn, $idskpd, $status);
        $nama_unit = $this->report_absensi_model->getNamaUnitKerja2($idskpd);
        $statusName = $this->report_absensi_model->getStatusAbsen($status);
        $this->load->view('report_absensi/detail_list_pegawai',
            array(
                'list_data' => $listdata,
                'auth' => $auth,
                'status' => $status,
                'nama_unit' => $nama_unit,
                'statusName' => $statusName
            ));
    }

    public function detail_list_pegawai_rekap_bulanan()
    {
        $tgl = $this->input->post('tgl');
        $bln = $this->input->post('bln');
        $thn = $this->input->post('thn');
        $idskpd = $this->input->post('idskpd');
        $status = $this->input->post('status');
        $listdata = $this->report_absensi_model->getDetailListPegawaiBulanan($tgl, $bln, $thn, $idskpd, $status);
        $nama_unit = $this->report_absensi_model->getNamaUnitKerja2($idskpd);
        $this->load->view('report_absensi/detail_list_pegawai_bulanan',
            array(
                'list_data' => $listdata,
                'judul' => ($status=='TA'?'TIDAK APEL':'TIDAK HADIR'),
                'nama_unit' => $nama_unit,
                'status' => $status,
                'tgl' => ($tgl=='TOTAL'?'':'TANGGAL '.$tgl)
            ));
    }
}