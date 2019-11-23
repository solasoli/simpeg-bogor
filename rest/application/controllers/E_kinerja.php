<?php defined('BASEPATH') OR exit('No direct script access allowed');

class E_kinerja extends CI_Controller{
    var $api_key;
    var $keyApps;

    public function __construct(){
        parent::__construct();
        date_default_timezone_set("Asia/Bangkok");
        $this->load->model('Ekinerja_model','ekinerja');
        $this->load->model('Umum_model','umum');
    }

    public function index(){

    }

    public function exec_running_methode($id_methode, $key=null, $param1=null, $param2=null){
        $this->load->model('Api_model','Api');
        $data = null;
        //$key=null;
        if($key==null){
            $key = $this->input->post('key');
        }
        if($key!=null){
            //echo $key;
            $verif = $this->Api->verify_api_key($key);
            if($verif!=null){
                $methode = $this->Api->get_rest_methode($id_methode, $verif['idrest_apps']);
                if($methode!=null){
                    $data = 1;
                    $this->api_key = $key;
                    $this->keyApps = $this->ekinerja->get_key_apps($key);
                    $func = $methode['entitas'].'::'.$methode['function'];
                    call_user_func($func, $param1, $param2);
                }
            }
        }
        if($data==null){
            $data = array('code'=>203,
                'status'=>'success',
                'title'=>'Anda tidak memiliki akses data',
                'data'=>$data,
                'rel'=>'self'
            );
            echo json_encode($data);
        }
    }

    public function get_data_dasar(){
        $id_pegawai = $this->input->get('id_pegawai');
        $query = $this->ekinerja->getDataDasar($id_pegawai);
        $data = $query->result();

        if (isset($data) and sizeof($data) > 0) {
            foreach ($data as $lsdata) {
                if($lsdata->id_unit_kerja_me <> $lsdata->id_skpd_me){
                    if($lsdata->opd = 'Dinas Kesehatan Kota Bogor'){
                        $dataPkm = $this->ekinerja->getKepalaPuskesmas($lsdata->id_unit_kerja_me)->result();
                        if (isset($dataPkm) and sizeof($dataPkm) > 0) {
                            foreach ($dataPkm as $lsdataPkm) {
                                $nip_kapus = $lsdataPkm->nip_baru;
                                $nama_kapus = $lsdataPkm->nama;
                                $gol_kapus = $lsdataPkm->pangkat_gol;
                                $idp_kapus = $lsdataPkm->id_pegawai;
                                $idj_kapus = $lsdataPkm->id_j;
                            }
                            if($lsdata->nip_baru==$nip_kapus){ //jika ia juga sebagai kapus
                                $dataKepala = $this->ekinerja->getNamaPejabatEselon($lsdata->id_j_kepala)->result();
                                if (isset($dataKepala) and sizeof($dataKepala) > 0) {
                                    foreach ($dataKepala as $lsdataKpl) {
                                        $lsdata->nip_baru_atsl = $lsdataKpl->nip_baru;
                                        $lsdata->nama_atsl = $lsdataKpl->nama;
                                        $lsdata->gol_atsl = $lsdataKpl->golongan;
                                        $lsdata->jabatan_atsl = $lsdata->jabatan_kepala;
                                        $lsdata->id_bos_atsl = $lsdata->id_j_kepala;
                                        $lsdata->id_pegawai_atsl = $lsdataKpl->id_pegawai;
                                    }
                                }
                                $dataSekda = $this->ekinerja->getNamaSekda()->result();
                                if (isset($dataSekda) and sizeof($dataSekda) > 0) {
                                    foreach ($dataSekda as $lsdataSekda) {
                                        $lsdata->nip_baru_pjbt = $lsdataSekda->nip_baru;
                                        $lsdata->nama_pjbt = $lsdataSekda->nama;
                                        $lsdata->gol_pjbt = $lsdataSekda->golongan;
                                        $lsdata->jabatan_pjbt = $lsdataSekda->jabatan;
                                        $lsdata->id_bos_pjbt = $lsdataSekda->id_j;
                                        $lsdata->id_pegawai_pjbt = $lsdataSekda->id_pegawai;
                                    }
                                }
                            }else{
                                $lsdata->nip_baru_atsl = $nip_kapus;
                                $lsdata->nama_atsl = $nama_kapus;
                                $lsdata->gol_atsl = $gol_kapus;
                                if($lsdata->nip_baru_atsl!=''){
                                    $lsdata->jabatan_atsl = 'Kepala Puskesmasnya '.$lsdata->unit_kerja_me;
                                }else{
                                    $lsdata->jabatan_atsl = '';
                                }
                                $lsdata->id_bos_atsl = $idj_kapus;
                                $lsdata->id_pegawai_atsl = $idp_kapus;
                                $dataKepala = $this->ekinerja->getNamaPejabatEselon($lsdata->id_j_kepala)->result();
                                if (isset($dataKepala) and sizeof($dataKepala) > 0) {
                                    foreach ($dataKepala as $lsdataKpl) {
                                        $lsdata->nip_baru_pjbt = $lsdataKpl->nip_baru;
                                        $lsdata->nama_pjbt = $lsdataKpl->nama;
                                        $lsdata->gol_pjbt = $lsdataKpl->golongan;
                                        $lsdata->jabatan_pjbt = $lsdata->jabatan_kepala;
                                        $lsdata->id_bos_pjbt = $lsdata->id_j_kepala;
                                        $lsdata->id_pegawai_pjbt = $lsdataKpl->id_pegawai;
                                    }
                                }
                            }
                        }
                    }

                    if($lsdata->opd = 'Dinas Pendidikan Kota Bogor'){
                        $dataPkm = $this->ekinerja->getKepalaSekolah($lsdata->id_unit_kerja_me)->result();
                        if (isset($dataPkm) and sizeof($dataPkm) > 0) {
                            foreach ($dataPkm as $lsdataPkm) {
                                $nip_kapus = $lsdataPkm->nip_baru;
                                $nama_kapus = $lsdataPkm->nama;
                                $gol_kapus = $lsdataPkm->pangkat_gol;
                                $idp_kapus = $lsdataPkm->id_pegawai;
                                $idj_kapus = $lsdataPkm->id_j;
                            }
                            if($lsdata->nip_baru==$nip_kapus) { //jika ia juga sebagai kepsek
                                $dataKepala = $this->ekinerja->getNamaPejabatEselon($lsdata->id_j_kepala)->result();
                                if (isset($dataKepala) and sizeof($dataKepala) > 0) {
                                    foreach ($dataKepala as $lsdataKpl) {
                                        $lsdata->nip_baru_atsl = $lsdataKpl->nip_baru;
                                        $lsdata->nama_atsl = $lsdataKpl->nama;
                                        $lsdata->gol_atsl = $lsdataKpl->golongan;
                                        $lsdata->jabatan_atsl = $lsdata->jabatan_kepala;
                                        $lsdata->id_bos_atsl = $lsdata->id_j_kepala;
                                        $lsdata->id_pegawai_atsl = $lsdataKpl->id_pegawai;
                                    }
                                }
                                $dataSekda = $this->ekinerja->getNamaSekda()->result();
                                if (isset($dataSekda) and sizeof($dataSekda) > 0) {
                                    foreach ($dataSekda as $lsdataSekda) {
                                        $lsdata->nip_baru_pjbt = $lsdataSekda->nip_baru;
                                        $lsdata->nama_pjbt = $lsdataSekda->nama;
                                        $lsdata->gol_pjbt = $lsdataSekda->golongan;
                                        $lsdata->jabatan_pjbt = $lsdataSekda->jabatan;
                                        $lsdata->id_bos_pjbt = $lsdataSekda->id_j;
                                        $lsdata->id_pegawai_pjbt = $lsdataSekda->id_pegawai;
                                    }
                                }
                            }else{
                                if($lsdata->jenjab=='Fungsional' and $lsdata->jabatan=='Guru'){
                                    $lsdata->nip_baru_atsl = $nip_kapus;
                                    $lsdata->nama_atsl = $nama_kapus;
                                    $lsdata->gol_atsl = $gol_kapus;
                                    if($lsdata->nip_baru_atsl!=''){
                                        $lsdata->jabatan_atsl = 'Kepala Sekolah '.$lsdata->unit_kerja_me;
                                    }else{
                                        $lsdata->jabatan_atsl = '';
                                    }
                                    $lsdata->id_bos_atsl = $idj_kapus;
                                    $lsdata->id_pegawai_atsl = $idp_kapus;
                                    $dataKepala = $this->ekinerja->getPejabatBidangDisdik($lsdata->id_unit_kerja_me)->result();
                                    if (isset($dataKepala) and sizeof($dataKepala) > 0) {
                                        foreach ($dataKepala as $lsdataKpl) {
                                            $lsdata->nip_baru_pjbt = $lsdataKpl->nip_baru;
                                            $lsdata->nama_pjbt = $lsdataKpl->nama;
                                            $lsdata->gol_pjbt = $lsdataKpl->golongan;
                                            $lsdata->jabatan_pjbt = $lsdataKpl->jabatan;
                                            $lsdata->id_bos_pjbt = $lsdataKpl->id_j;
                                            $lsdata->id_pegawai_pjbt = $lsdataKpl->id_pegawai;
                                        }
                                    }
                                }else{
                                    $dataKepala = $this->ekinerja->getKasubagUmumKepegDinas($lsdata->id_skpd_me)->result();
                                    if (isset($dataKepala) and sizeof($dataKepala) > 0) {
                                        foreach ($dataKepala as $lsdataKpl) {
                                            $lsdata->nip_baru_atsl = $lsdataKpl->nip_baru;
                                            $lsdata->nama_atsl = $lsdataKpl->nama;
                                            $lsdata->gol_atsl = $lsdataKpl->golongan;
                                            $lsdata->jabatan_atsl = $lsdataKpl->jabatan;
                                            $lsdata->id_bos_atsl = $lsdataKpl->id_j;
                                            $lsdata->id_pegawai_atsl = $lsdataKpl->id_pegawai;
                                        }
                                    }
                                    $dataKepala = $this->ekinerja->getSekretarisDinas($lsdata->id_skpd_me)->result();
                                    if (isset($dataKepala) and sizeof($dataKepala) > 0) {
                                        foreach ($dataKepala as $lsdataKpl) {
                                            $lsdata->nip_baru_pjbt = $lsdataKpl->nip_baru;
                                            $lsdata->nama_pjbt = $lsdataKpl->nama;
                                            $lsdata->gol_pjbt = $lsdataKpl->golongan;
                                            $lsdata->jabatan_pjbt = $lsdataKpl->jabatan;
                                            $lsdata->id_bos_pjbt = $lsdataKpl->id_j;
                                            $lsdata->id_pegawai_pjbt = $lsdataKpl->id_pegawai;
                                        }
                                    }
                                }
                            }
                        }
                    }
                }

                if($lsdata->idp_plt_atsl!=''){
                    if($lsdata->jabatan_atsl == 'Walikota Bogor') {

                    }else{
                        if($lsdata->id_pegawai_atsl!='' and $lsdata->idp_plt_atsl=='') {

                        }elseif($lsdata->id_pegawai_atsl!='' and $lsdata->idp_plt_atsl==$lsdata->id_pegawai){

                        }else {
                            $dataKepala = $this->ekinerja->getPltAtasanLangsung($lsdata->idp_plt_atsl)->result();
                            if (isset($dataKepala) and sizeof($dataKepala) > 0) {
                                foreach ($dataKepala as $lsdataKpl) {
                                    $lsdata->nip_baru_atsl = $lsdataKpl->nip_baru;
                                    $lsdata->nama_atsl = $lsdataKpl->nama;
                                    $lsdata->gol_atsl = $lsdataKpl->golongan;
                                    $lsdata->jabatan_atsl = 'Plt. ' . $lsdataKpl->jabatan;
                                    $lsdata->id_bos_atsl = $lsdataKpl->id_j;
                                    $lsdata->id_pegawai_atsl = $lsdataKpl->id_pegawai;
                                }
                            }
                        }
                    }
                }

                if($lsdata->idp_plt_pjbt!=''){
                    $dataKepala = $this->ekinerja->getPltPejabatBerwenang($lsdata->idp_plt_pjbt)->result();
                    if (isset($dataKepala) and sizeof($dataKepala) > 0) {
                        foreach ($dataKepala as $lsdataKpl) {
                            if(is_numeric($lsdataKpl->nip_baru)){
                                $lsdata->nip_baru_pjbt = $lsdataKpl->nip_baru;
                                $lsdata->gol_pjbt = $lsdataKpl->golongan;
                            }else{
                                $lsdata->nip_baru_pjbt = '-';
                                $lsdata->gol_pjbt = '-';
                            }
                            $lsdata->nama_pjbt = $lsdataKpl->nama;
                            $lsdata->jabatan_pjbt = 'Plt. '.$lsdataKpl->jabatan;
                            $lsdata->id_bos_pjbt = $lsdataKpl->id_j;
                            $lsdata->id_pegawai_pjbt = $lsdataKpl->id_pegawai;
                            $lsdata->id_skpd = $lsdataKpl->id_skpd;
                        }
                    }
                }
                if($lsdata->idp_plt_atsl<>'' AND $lsdata->idp_plt_pjbt<>'') {
                    if ($lsdata->idp_plt_atsl == $lsdata->idp_plt_pjbt) {
                        if($lsdata->jabatan_plt_ybs == 'Walikota Bogor'){

                        }else{
                            $dataKepala = $this->ekinerja->getPegawaiEselon3A($lsdata->id_skpd_me)->result();
                            if (isset($dataKepala) and sizeof($dataKepala) > 0) {
                                foreach ($dataKepala as $lsdataKpl) {
                                    $lsdata->nip_baru_pjbt = $lsdataKpl->nip_baru;
                                    $lsdata->nama_pjbt = $lsdataKpl->nama;
                                    $lsdata->gol_pjbt = $lsdataKpl->golongan;
                                    $lsdata->jabatan_pjbt = $lsdataKpl->jabatan;
                                    $lsdata->id_bos_pjbt = $lsdataKpl->id_j;
                                    $lsdata->id_pegawai_pjbt = $lsdataKpl->id_pegawai;
                                }
                            }
                        }
                    }
                }
            }
        }

        $data = array(	'code'=>200,
            'status'=>'success',
            'title'=>'Data Dasar Pegawai',
            'data'=>$data,
            'rel'=>'self'
        );
        echo json_encode($data);
    }

    public function insert_kinerja_master(){
        $curdate = new DateTime(date("Y-m-d"));
        $datecek = new DateTime($this->input->post('tglKegiatan'));
        $intervalHari = date_diff($curdate, $datecek);
        $intervalHari = $intervalHari->format('%a');
        $hariIni = date("Y-m-d");
        $juniPeriode = '2019-07-31';
        $actPeriode = explode('-',$this->input->post('tglKegiatan'));
        if($hariIni <= $juniPeriode){
            $batasAkhirEntri = 31;
        }else{
            if($actPeriode[0].'-'.(Int)$actPeriode[1]=='2019-7'){
                if(date("Y-m-d H:i:s") <= '2019-08-02 23:59:00'){
                    $batasAkhirEntri = 60;
                }else{
                    $batasAkhirEntri = 7;
                }
            }else{
                $batasAkhirEntri = 7;
            }
        }

        if($intervalHari > $batasAkhirEntri){
            $result = $this->waktu_aktivitas_not_valid($batasAkhirEntri);
        }else{
            $curPeriode = date("Y-m");
            $actPeriode = explode('-',$this->input->post('tglKegiatan'));
            if(($curPeriode==$actPeriode[0].'-'.$actPeriode[1]) or ($actPeriode[0].'-'.(Int)$actPeriode[1]=='2019-7')){
                $rsAbsenTdkHadir = $this->ekinerja->getDataReportNoAbsensi_ByIdpTgl($this->input->post('id_pegawai'), $this->input->post('tglKegiatan'));
                $rsAbsenTdkHadir = $rsAbsenTdkHadir->result();
                if (isset($rsAbsenTdkHadir) and sizeof($rsAbsenTdkHadir) > 0){
                    foreach ($rsAbsenTdkHadir as $lsdata){
                        $status = $lsdata->nama_status;
                    }
                    if($status=='Dinas Luar'){
                        $result = $this->status_belum_absensi($status);
                    }else{
                        $result = $this->status_belum_absensi($status);
                    }
                }else {
                    $rsAbsenTime = $this->ekinerja->getDataReportLogAbsensi_ByIdpTgl($this->input->post('id_pegawai'), $this->input->post('tglKegiatan'), $this->input->post('jamKegiatan'));
                    $rsAbsenTime = $rsAbsenTime['query']->result();
                    if ((isset($rsAbsenTime) and sizeof($rsAbsenTime) > 0)){
                        foreach ($rsAbsenTime as $lsdata){
                            $waktu_keg_valid = $lsdata->waktu_aktivitas_valid;
                            $wkt_absen = $lsdata->date_time;
                        }
                        if($waktu_keg_valid==0){
                            $result = $this->jam_kegiatan_belum_valid($wkt_absen);
                        }else{
                            $cek_exist = $this->ekinerja->is_exist_reportkinerja_by_periode($this->input->post('id_pegawai'),$this->input->post('ddBln'),$this->input->post('ddThn'));

                            if($cek_exist['jmlExist'] > 0){
                                $rsLastKeg = $this->ekinerja->getLastKegiatanByDateTime($this->input->post('id_pegawai'), $this->input->post('tglKegiatan'), $this->input->post('jamKegiatan'), $this->input->post('txtDurasi'), 'add', $this->input->post('tglKegiatanOri'), $cek_exist['id_knj']);
                                $rsLastKeg = $rsLastKeg->result();
                                if (isset($rsLastKeg) and sizeof($rsLastKeg) > 0){
                                    foreach ($rsLastKeg as $lsdata){
                                        $flag_status = $lsdata->flag_status;
                                        if($flag_status==0){
                                            $keg_terakhir = $lsdata->kegiatan_durasi_sebelum;
                                            if($keg_terakhir == ''){
                                                $keg_terakhir = $lsdata->kegiatan_durasi_setelah;
                                                if($keg_terakhir == ''){
                                                    $keg_terakhir = $lsdata->kegiatan_baru_exist;
                                                }
                                            }
                                        }
                                    }
                                }else{
                                    $flag_status = 1;
                                }

                                if($flag_status==1){
                                    $data = array(
                                        'ddKatKegiatan' => $this->input->post('ddKatKegiatan'),
                                        'tglKegiatan' => $this->input->post('tglKegiatan'),
                                        'jamKegiatan' => $this->input->post('jamKegiatan'),
                                        'txtRincian' => $this->input->post('txtRincian'),
                                        'txtKet' => $this->input->post('txtKet'),
                                        'txtKuantitas' => $this->input->post('txtKuantitas'),
                                        'ddSatuan' => $this->input->post('ddSatuan'),
                                        'txtDurasi' => $this->input->post('txtDurasi')
                                    );
                                    //print_r($this->input->post('last_atsl_idp').'-'.$this->input->post('last_pjbt_idp'));
                                    //Deteksi periode input kegiatan dengan bulan current

                                    if($this->input->post('ddBln').$this->input->post('ddThn') == date('m').date('Y')){

                                        $idknj_hist_alih_tugas = $this->ekinerja->cek_knj_kinerja_historis_alih_tugas($cek_exist['id_knj'],$this->input->post('last_atsl_idp'),$this->input->post('last_pjbt_idp'),$this->input->post('last_atsl_idp_plh'));
                                        if($idknj_hist_alih_tugas > 0){
                                            $rdbHistAlihTugas = $this->input->post('rdbHistAlihTugas');
                                            if($rdbHistAlihTugas<>''){
                                                $idknj_hist_alih_tugas = $rdbHistAlihTugas;
                                            }
                                            $query = $this->ekinerja->insertKinerjaKegiatan($data, $idknj_hist_alih_tugas);
                                            if ($query['query'] > 0) {
                                                $result = $this->transaksi_sukses($query['id_knj_kegiatan'],$rdbHistAlihTugas);
                                            } else {
                                                $result = $this->transaksi_gagal();
                                            }
                                        }else{
                                            $attrJabatan = $this->ekinerja->ref_get_kelas_jabatan("'".$this->input->post('last_jenjab')."'", $this->input->post('last_kode_jabatan'), "'".$this->input->post('last_eselon')."'");
                                            if (isset($attrJabatan)){
                                                $rowcount = $attrJabatan->num_rows();
                                                if($rowcount>0){
                                                    foreach ($attrJabatan->result() as $data_kelas) {
                                                        $kelas_jabatan = $data_kelas->kelas_jabatan;
                                                        $nilai_jabatan = $data_kelas->nilai_jabatan;
                                                    }
                                                }else{
                                                    $kelas_jabatan = 0;
                                                    $nilai_jabatan = 0;
                                                }
                                            }else{
                                                $kelas_jabatan = 0;
                                                $nilai_jabatan = 0;
                                            }

                                            $nilai_rp_tkd = $this->ekinerja->ref_get_nilai_rupiah_tkd();
                                            if (isset($nilai_rp_tkd)){
                                                $rowcount = $nilai_rp_tkd->num_rows();
                                                if($rowcount>0){
                                                    foreach ($nilai_rp_tkd->result() as $data_nilai) {
                                                        $nilai_rupiah_tkd = $data_nilai->nilai;
                                                    }
                                                }else{
                                                    $nilai_rupiah_tkd = 0;
                                                }
                                            }else{
                                                $nilai_rupiah_tkd = 0;
                                            }

                                            if($this->input->post('last_status_pegawai') == "PNS") {
                                                $rupiah_awal_tkd = ($nilai_jabatan * $nilai_rupiah_tkd);
                                            }else{
                                                $rupiah_awal_tkd = ($nilai_jabatan * $nilai_rupiah_tkd)*0.8;
                                            }

                                            if(strpos($this->input->post('last_unit_kerja'), 'Badan Pendapatan Daerah') !== false
                                                or strpos($this->input->post('last_unit_kerja'), 'Puskesmas') !== false
                                                or strpos($this->input->post('last_jabatan'), 'Guru') !== false){
                                                $nilai_jabatan = 0;
                                                $rupiah_awal_tkd = 0;
                                            }

                                            $efektif_hari_kerja = $this->ekinerja->ref_get_jml_menit_efektif_kerja($this->input->post('id_pegawai'),$this->input->post('ddBln'),$this->input->post('ddThn'));
                                            if (isset($efektif_hari_kerja)){
                                                $rowcount = $efektif_hari_kerja->num_rows();
                                                if($rowcount>0){
                                                    foreach ($efektif_hari_kerja->result() as $data_efektif) {
                                                        $jml_menit_efektif_kerja = $data_efektif->jml_menit_efektif_kerja;
                                                        $jml_hari_kerja_efektif = $data_efektif->jml_hari_kerja_efektif;
                                                    }
                                                }else{
                                                    $jml_menit_efektif_kerja = 0;
                                                    $jml_hari_kerja_efektif = 0;
                                                }
                                            }else{
                                                $jml_menit_efektif_kerja = 0;
                                                $jml_hari_kerja_efektif = 0;
                                            }

                                            $data_atasan = array(
                                                'last_id_unit_kerja' => $this->input->post('last_id_unit_kerja'),
                                                'last_unit_kerja' => "'".$this->input->post('last_unit_kerja')."'",
                                                'jenjab' => "'".$this->input->post('last_jenjab')."'",
                                                'kode_jabatan' => $this->input->post('last_kode_jabatan'),
                                                'jabatan' => "'".$this->input->post('last_jabatan')."'",
                                                'eselon' => "'".$this->input->post('last_eselon')."'",
                                                'kelas_jabatan' => $kelas_jabatan,
                                                'nilai_jabatan' => $nilai_jabatan,
                                                'nilai_rupiah_tkd' => $nilai_rupiah_tkd,
                                                'rupiah_awal_tkd' => $rupiah_awal_tkd,
                                                'last_atsl_idp' => $this->input->post('last_atsl_idp'),
                                                'last_atsl_nip' => "'".$this->input->post('last_atsl_nip')."'",
                                                'last_atsl_nama' => "'".$this->input->post('last_atsl_nama')."'",
                                                'last_atsl_gol' => "'".$this->input->post('last_atsl_gol')."'",
                                                'last_atsl_jabatan' => "'".$this->input->post('last_atsl_jabatan')."'",
                                                'last_atsl_id_j' => $this->input->post('last_atsl_id_j'),
                                                'last_pjbt_idp' => $this->input->post('last_pjbt_idp'),
                                                'last_pjbt_nip' => "'".$this->input->post('last_pjbt_nip')."'",
                                                'last_pjbt_nama' => "'".$this->input->post('last_pjbt_nama')."'",
                                                'last_pjbt_gol' => "'".$this->input->post('last_pjbt_gol')."'",
                                                'last_pjbt_jabatan' => "'".$this->input->post('last_pjbt_jabatan')."'",
                                                'last_pjbt_id_j' => $this->input->post('last_pjbt_id_j'),
                                                'id_skp' => $this->input->post('txtIdSkp'),
                                                'tmt_skp' => $this->input->post('txtTmtSkp'),
                                                'jml_menit_efektif_kerja' => $jml_menit_efektif_kerja,
                                                'jml_hari_kerja_efektif' => $jml_hari_kerja_efektif,

                                                'last_atsl_idp_plh' => $this->input->post('last_atsl_idp_plh'),
                                                'last_atsl_nip_plh' => "'".$this->input->post('last_atsl_nip_plh')."'",
                                                'last_atsl_nama_plh' => "'".$this->input->post('last_atsl_nama_plh')."'",
                                                'last_atsl_gol_plh' => "'".$this->input->post('last_atsl_gol_plh')."'",
                                                'last_atsl_jabatan_plh' => "'".$this->input->post('last_atsl_jabatan_plh')."'",
                                                'last_atsl_id_j_plh' => $this->input->post('last_atsl_id_j_plh'),
                                                'last_pjbt_idp_plh' => $this->input->post('last_pjbt_idp_plh'),
                                                'last_pjbt_nip_plh' => "'".$this->input->post('last_pjbt_nip_plh')."'",
                                                'last_pjbt_nama_plh' => "'".$this->input->post('last_pjbt_nama_plh')."'",
                                                'last_pjbt_gol_plh' => "'".$this->input->post('last_pjbt_gol_plh')."'",
                                                'last_pjbt_jabatan_plh' => "'".$this->input->post('last_pjbt_jabatan_plh')."'",
                                                'last_pjbt_id_j_plh' => $this->input->post('last_pjbt_id_j_plh')
                                            );

                                            $tglKegiatan = "'".$data['tglKegiatan'].' '.$data['jamKegiatan']."'";
                                            $query = $this->ekinerja->insert_kinerja_historis_alih_tugas($data_atasan, $cek_exist['id_knj'], $tglKegiatan);
                                            if ($query['query'] > 0) {
                                                $query = $this->ekinerja->insertKinerjaKegiatan($data, $query['idknj_hist_alih_tugas']);
                                                if ($query['query'] > 0) {
                                                    $result = $this->transaksi_sukses($query['id_knj_kegiatan']);
                                                } else {
                                                    $result = $this->transaksi_gagal();
                                                }
                                            }else{
                                                $result = $this->transaksi_gagal();
                                            }
                                        }
                                    }else{
                                        if($cek_exist['idknj_hist_alih_tugas'] > 0){
                                            $rdbHistAlihTugas = $this->input->post('rdbHistAlihTugas');
                                            if($rdbHistAlihTugas<>''){
                                                $idknj_hist_alih_tugas = $rdbHistAlihTugas;
                                            }else{
                                                $idknj_hist_alih_tugas = $cek_exist['idknj_hist_alih_tugas'];
                                            }
                                            $query = $this->ekinerja->insertKinerjaKegiatan($data, $idknj_hist_alih_tugas);
                                            if ($query['query'] > 0) {
                                                $result = $this->transaksi_sukses($query['id_knj_kegiatan'],$rdbHistAlihTugas);
                                            } else {
                                                $result = $this->transaksi_gagal();
                                            }
                                        }else{
                                            $result = $this->transaksi_gagal_not_exist_hist_alihtugas();
                                        }
                                    }
                                }else{
                                    $result = $this->jam_kegiatan_blm_diatas_keg_terakhir($keg_terakhir);
                                }
                            }else{
                                $data = array(
                                    'ddBln' => $this->input->post('ddBln'),
                                    'ddThn' => $this->input->post('ddThn'),
                                    'id_pegawai' => $this->input->post('id_pegawai'),
                                    'last_jenjab' => $this->input->post('last_jenjab'),
                                    'last_kode_jabatan' => $this->input->post('last_kode_jabatan'),
                                    'last_jabatan' => $this->input->post('last_jabatan'),
                                    'last_eselon' => $this->input->post('last_eselon'),
                                    'last_gol' => $this->input->post('last_gol'),
                                    'last_id_unit_kerja' => $this->input->post('last_id_unit_kerja'),
                                    'last_unit_kerja' => $this->input->post('last_unit_kerja'),
                                    'last_atsl_idp' => $this->input->post('last_atsl_idp'),
                                    'last_atsl_nip' => $this->input->post('last_atsl_nip'),
                                    'last_atsl_nama' => $this->input->post('last_atsl_nama'),
                                    'last_atsl_gol' => $this->input->post('last_atsl_gol'),
                                    'last_atsl_jabatan' => $this->input->post('last_atsl_jabatan'),
                                    'last_atsl_id_j' => $this->input->post('last_atsl_id_j'),
                                    'last_pjbt_idp' => $this->input->post('last_pjbt_idp'),
                                    'last_pjbt_nip' => $this->input->post('last_pjbt_nip'),
                                    'last_pjbt_nama' => $this->input->post('last_pjbt_nama'),
                                    'last_pjbt_gol' => $this->input->post('last_pjbt_gol'),
                                    'last_pjbt_jabatan' => $this->input->post('last_pjbt_jabatan'),
                                    'last_pjbt_id_j' => $this->input->post('last_pjbt_id_j'),
                                    'id_skp' => $this->input->post('txtIdSkp'),
                                    'tmt_skp' => $this->input->post('txtTmtSkp'),
                                    'ddKatKegiatan' => $this->input->post('ddKatKegiatan'),
                                    'tglKegiatan' => $this->input->post('tglKegiatan'),
                                    'jamKegiatan' => $this->input->post('jamKegiatan'),
                                    'txtRincian' => $this->input->post('txtRincian'),
                                    'txtKet' => $this->input->post('txtKet'),
                                    'txtKuantitas' => $this->input->post('txtKuantitas'),
                                    'ddSatuan' => $this->input->post('ddSatuan'),
                                    'txtDurasi' => $this->input->post('txtDurasi'),
                                    'last_status_pegawai' => $this->input->post('last_status_pegawai'),

                                    'last_atsl_idp_plh' => $this->input->post('last_atsl_idp_plh'),
                                    'last_atsl_nip_plh' => $this->input->post('last_atsl_nip_plh'),
                                    'last_atsl_nama_plh' => $this->input->post('last_atsl_nama_plh'),
                                    'last_atsl_gol_plh' => $this->input->post('last_atsl_gol_plh'),
                                    'last_atsl_jabatan_plh' => $this->input->post('last_atsl_jabatan_plh'),
                                    'last_atsl_id_j_plh' => $this->input->post('last_atsl_id_j_plh'),
                                    'last_pjbt_idp_plh' => $this->input->post('last_pjbt_idp_plh'),
                                    'last_pjbt_nip_plh' => $this->input->post('last_pjbt_nip_plh'),
                                    'last_pjbt_nama_plh' => $this->input->post('last_pjbt_nama_plh'),
                                    'last_pjbt_gol_plh' => $this->input->post('last_pjbt_gol_plh'),
                                    'last_pjbt_jabatan_plh' => $this->input->post('last_pjbt_jabatan_plh'),
                                    'last_pjbt_id_j_plh' => $this->input->post('last_pjbt_id_j_plh')
                                );

                                $query = $this->ekinerja->insertKinerjaMaster($data);
                                if ($query['query'] > 0) {
                                    $result = $this->transaksi_sukses($query['id_knj_kegiatan']);
                                } else {
                                    $result = $this->transaksi_gagal($query['id_knj_kegiatan']);
                                }
                            }
                        }
                    }else{
                        $result = $this->status_belum_absensi('Tidak ada keterangan');
                    }
                }
            }else{
                $result = $this->periode_aktivitas_not_valid($actPeriode[1], $actPeriode[0]);
            }

        }
        echo json_encode($result);
    }

    public function update_url_berkas_kegiatan(){
        $uploadfile = $this->input->get('uploadfile');
        $nf_baru = $this->input->get('nf_baru');
        $id_knj_keg = $this->input->get('idknjkeg');
        $status = $this->input->get('status');
        if($status==1){
            $query = $this->ekinerja->update_url_berkas_kegiatan($nf_baru, $id_knj_keg);
            if ($query['query'] == 1) {
                /*if(file_exists($_SERVER['DOCUMENT_ROOT']."/ekinerja2/berkas/".$nf_baru)){
                    unlink($_SERVER['DOCUMENT_ROOT']."/ekinerja2/berkas/".$nf_baru);
                }
                rename($_SERVER['DOCUMENT_ROOT'].'/ekinerja2/'.$uploadfile, $_SERVER['DOCUMENT_ROOT']."/ekinerja2/berkas/".$nf_baru);*/
                $uploaddir = '/var/www/html/ekinerja2/berkas/';
                $connection = ssh2_connect('103.14.229.15');
                ssh2_auth_password($connection, 'rommonz', 'mony3Tmony3T');
                $sftp = ssh2_sftp($connection);
                if (file_exists('ssh2.sftp://' . $sftp . '/var/www/html/ekinerja2/berkas/'.$nf_baru)) {
                    ssh2_sftp_unlink($sftp, '/var/www/html/ekinerja2/berkas/'.$nf_baru);
                }
                ssh2_sftp_rename($sftp, $uploadfile,$uploaddir.$nf_baru);
                $result = $this->transaksi_sukses();
            } else {
                $result = $this->transaksi_gagal();
            }
            echo json_encode($result);
        }
    }

    public function update_aktifitas_kegiatan(){
        $curdate = new DateTime(date("Y-m-d"));
        $datecek = new DateTime($this->input->post('tglKegiatan'));
        $intervalHari = date_diff($curdate, $datecek);
        $intervalHari = $intervalHari->format('%a');
        $hariIni = date("Y-m-d");
        $juniPeriode = '2019-07-31';
        $actPeriode = explode('-',$this->input->post('tglKegiatan'));
        if($hariIni <= $juniPeriode){
            $batasAkhirEntri = 31;
        }else{
            if($actPeriode[0].'-'.(Int)$actPeriode[1]=='2019-7'){
                if(date("Y-m-d H:i:s") <= '2019-08-02 23:59:00'){
                    $batasAkhirEntri = 60;
                }else{
                    $batasAkhirEntri = 7;
                }
            }else{
                $batasAkhirEntri = 7;
            }
        }

        if($intervalHari > $batasAkhirEntri){
            $result = $this->waktu_aktivitas_not_valid($batasAkhirEntri);
        }else {
            $curPeriode = date("Y-m");
            $actPeriode = explode('-',$this->input->post('tglKegiatan'));
            if(($curPeriode==$actPeriode[0].'-'.$actPeriode[1]) or ($actPeriode[0].'-'.(Int)$actPeriode[1]=='2019-7')){
                $rsAbsenTdkHadir = $this->ekinerja->getDataReportNoAbsensi_ByIdpTgl($this->input->post('id_pegawai'), $this->input->post('tglKegiatan'));
                $rsAbsenTdkHadir = $rsAbsenTdkHadir->result();
                if (isset($rsAbsenTdkHadir) and sizeof($rsAbsenTdkHadir) > 0) {
                    foreach ($rsAbsenTdkHadir as $lsdata) {
                        $status = $lsdata->nama_status;
                    }
                    $result = $this->status_belum_absensi($status);
                } else {
                    $rsAbsenTime = $this->ekinerja->getDataReportLogAbsensi_ByIdpTgl($this->input->post('id_pegawai'), $this->input->post('tglKegiatan'), $this->input->post('jamKegiatan'));
                    $rsAbsenTime = $rsAbsenTime['query']->result();
                    if (isset($rsAbsenTime) and sizeof($rsAbsenTime) > 0) {
                        foreach ($rsAbsenTime as $lsdata) {
                            $waktu_keg_valid = $lsdata->waktu_aktivitas_valid;
                            $wkt_absen = $lsdata->date_time;
                        }

                        if ($waktu_keg_valid == 0) {
                            $result = $this->jam_kegiatan_belum_valid($wkt_absen);
                        } else {
                            $cek_exist = $this->ekinerja->is_exist_reportkinerja_by_periode($this->input->post('id_pegawai'), $this->input->post('ddBln'), $this->input->post('ddThn'));
                            if ($cek_exist['jmlExist'] > 0) {
                                $rsLastKeg = $this->ekinerja->getLastKegiatanByDateTime($this->input->post('id_pegawai'), $this->input->post('tglKegiatan'), $this->input->post('jamKegiatan'), $this->input->post('txtDurasi'), 'edit', $this->input->post('tglKegiatanOri'), $cek_exist['id_knj']);
                                $rsLastKeg = $rsLastKeg->result();
                                if (isset($rsLastKeg) and sizeof($rsLastKeg) > 0) {
                                    foreach ($rsLastKeg as $lsdata) {
                                        $flag_status = $lsdata->flag_status;
                                        if ($flag_status == 0) {
                                            $keg_terakhir = $lsdata->kegiatan_durasi_sebelum;
                                            if ($keg_terakhir == '') {
                                                $keg_terakhir = $lsdata->kegiatan_durasi_setelah;
                                                if ($keg_terakhir == '') {
                                                    $keg_terakhir = $lsdata->kegiatan_baru_exist;
                                                }
                                            }
                                        }
                                    }
                                } else {
                                    $flag_status = 1;
                                }

                                if ($this->input->post('chkUbahWktKegiatan') == 1) {
                                    $cekUbahWkt = 1;
                                } else {
                                    $cekUbahWkt = 0;
                                }

                                if ($flag_status == 0) {
                                    if ($cekUbahWkt == 1) {
                                        $inputOk = 0;
                                    } else {
                                        $inputOk = 1;
                                    }
                                } else {
                                    $inputOk = 1;
                                }

                                if ($inputOk == 1) {
                                    $data = array(
                                        'ddKatKegiatan' => $this->input->post('ddKatKegiatan'),
                                        'tglKegiatan' => $this->input->post('tglKegiatan'),
                                        'jamKegiatan' => $this->input->post('jamKegiatan'),
                                        'txtRincian' => $this->input->post('txtRincian'),
                                        'txtKet' => $this->input->post('txtKet'),
                                        'txtKuantitas' => $this->input->post('txtKuantitas'),
                                        'ddSatuan' => $this->input->post('ddSatuan'),
                                        'txtDurasi' => $this->input->post('txtDurasi'),
                                        'id_knj_kegiatan' => $this->input->post('id_knj_kegiatan'),
                                        'chkUbahWktKegiatan' => $this->input->post('chkUbahWktKegiatan')
                                    );
                                    $idknj_hist_alih_tugas = $this->ekinerja->cek_knj_kinerja_historis_alih_tugas($cek_exist['id_knj'], $this->input->post('last_atsl_idp'), $this->input->post('last_pjbt_idp'), $this->input->post('last_atsl_idp_plh'));
                                    if ($idknj_hist_alih_tugas > 0) {
                                        $rdbHistAlihTugas = $this->input->post('rdbHistAlihTugas');
                                        if ($rdbHistAlihTugas <> '') {
                                            $idknj_hist_alih_tugas = $rdbHistAlihTugas;
                                        }
                                        $query = $this->ekinerja->updateKinerjaKegiatan($data, $idknj_hist_alih_tugas);

                                        if ($query['query'] > 0) {
                                            $result = $this->transaksi_sukses($query['id_knj_kegiatan'], $rdbHistAlihTugas);
                                        } else {
                                            $result = $this->transaksi_gagal();
                                        }
                                    } else {
                                        $attrJabatan = $this->ekinerja->ref_get_kelas_jabatan($this->input->post('last_jenjab'), $this->input->post('last_kode_jabatan'), $this->input->post('last_eselon'));
                                        if (isset($attrJabatan)) {
                                            $rowcount = $attrJabatan->num_rows();
                                            if ($rowcount > 0) {
                                                foreach ($attrJabatan->result() as $data_kelas) {
                                                    $kelas_jabatan = $data_kelas->kelas_jabatan;
                                                    $nilai_jabatan = $data_kelas->nilai_jabatan;
                                                }
                                            } else {
                                                $kelas_jabatan = 0;
                                                $nilai_jabatan = 0;
                                            }
                                        } else {
                                            $kelas_jabatan = 0;
                                            $nilai_jabatan = 0;
                                        }

                                        $nilai_rp_tkd = $this->ekinerja->ref_get_nilai_rupiah_tkd();
                                        if (isset($nilai_rp_tkd)) {
                                            $rowcount = $nilai_rp_tkd->num_rows();
                                            if ($rowcount > 0) {
                                                foreach ($nilai_rp_tkd->result() as $data_nilai) {
                                                    $nilai_rupiah_tkd = $data_nilai->nilai;
                                                }
                                            } else {
                                                $nilai_rupiah_tkd = 0;
                                            }
                                        } else {
                                            $nilai_rupiah_tkd = 0;
                                        }

                                        if($this->input->post('last_status_pegawai') == "PNS") {
                                            $rupiah_awal_tkd = ($nilai_jabatan * $nilai_rupiah_tkd);
                                        }else{
                                            $rupiah_awal_tkd = ($nilai_jabatan * $nilai_rupiah_tkd)*0.8;
                                        }

                                        if(strpos($this->input->post('last_unit_kerja'), 'Badan Pendapatan Daerah') !== false
                                            or strpos($this->input->post('last_unit_kerja'), 'Puskesmas') !== false
                                            or strpos($this->input->post('last_jabatan'), 'Guru') !== false) {
                                            $nilai_jabatan = 0;
                                            $rupiah_awal_tkd = 0;
                                        }

                                        $efektif_hari_kerja = $this->ekinerja->ref_get_jml_menit_efektif_kerja($this->input->post('id_pegawai'), $this->input->post('ddBln'), $this->input->post('ddThn'));
                                        if (isset($efektif_hari_kerja)) {
                                            $rowcount = $efektif_hari_kerja->num_rows();
                                            if ($rowcount > 0) {
                                                foreach ($efektif_hari_kerja->result() as $data) {
                                                    $jml_menit_efektif_kerja = $data->jml_menit_efektif_kerja;
                                                    $jml_hari_kerja_efektif = $data->jml_hari_kerja_efektif;
                                                }
                                            } else {
                                                $jml_menit_efektif_kerja = 0;
                                                $jml_hari_kerja_efektif = 0;
                                            }
                                        } else {
                                            $jml_menit_efektif_kerja = 0;
                                            $jml_hari_kerja_efektif = 0;
                                        }

                                        $data_atasan = array(
                                            'last_id_unit_kerja' => $this->input->post('last_id_unit_kerja'),
                                            'last_unit_kerja' => "'" . $this->input->post('last_unit_kerja') . "'",
                                            'jenjab' => "'" . $this->input->post('last_jenjab') . "'",
                                            'kode_jabatan' => $this->input->post('last_kode_jabatan'),
                                            'jabatan' => "'" . $this->input->post('last_jabatan') . "'",
                                            'eselon' => "'" . $this->input->post('last_eselon') . "'",
                                            'kelas_jabatan' => $kelas_jabatan,
                                            'nilai_jabatan' => $nilai_jabatan,
                                            'nilai_rupiah_tkd' => $nilai_rupiah_tkd,
                                            'rupiah_awal_tkd' => $rupiah_awal_tkd,
                                            'last_atsl_idp' => $this->input->post('last_atsl_idp'),
                                            'last_atsl_nip' => "'" . $this->input->post('last_atsl_nip') . "'",
                                            'last_atsl_nama' => "'" . $this->input->post('last_atsl_nama') . "'",
                                            'last_atsl_gol' => "'" . $this->input->post('last_atsl_gol') . "'",
                                            'last_atsl_jabatan' => "'" . $this->input->post('last_atsl_jabatan') . "'",
                                            'last_atsl_id_j' => $this->input->post('last_atsl_id_j'),
                                            'last_pjbt_idp' => $this->input->post('last_pjbt_idp'),
                                            'last_pjbt_nip' => "'" . $this->input->post('last_pjbt_nip') . "'",
                                            'last_pjbt_nama' => "'" . $this->input->post('last_pjbt_nama') . "'",
                                            'last_pjbt_gol' => "'" . $this->input->post('last_pjbt_gol') . "'",
                                            'last_pjbt_jabatan' => "'" . $this->input->post('last_pjbt_jabatan') . "'",
                                            'last_pjbt_id_j' => $this->input->post('last_pjbt_id_j'),
                                            'id_skp' => $this->input->post('txtIdSkp'),
                                            'tmt_skp' => $this->input->post('txtTmtSkp'),
                                            'jml_menit_efektif_kerja' => $jml_menit_efektif_kerja,
                                            'jml_hari_kerja_efektif' => $jml_hari_kerja_efektif,

                                            'last_atsl_idp_plh' => $this->input->post('last_atsl_idp_plh'),
                                            'last_atsl_nip_plh' => "'".$this->input->post('last_atsl_nip_plh')."'",
                                            'last_atsl_nama_plh' => "'".$this->input->post('last_atsl_nama_plh')."'",
                                            'last_atsl_gol_plh' => "'".$this->input->post('last_atsl_gol_plh')."'",
                                            'last_atsl_jabatan_plh' => "'".$this->input->post('last_atsl_jabatan_plh')."'",
                                            'last_atsl_id_j_plh' => $this->input->post('last_atsl_id_j_plh'),
                                            'last_pjbt_idp_plh' => $this->input->post('last_pjbt_idp_plh'),
                                            'last_pjbt_nip_plh' => "'".$this->input->post('last_pjbt_nip_plh')."'",
                                            'last_pjbt_nama_plh' => "'".$this->input->post('last_pjbt_nama_plh')."'",
                                            'last_pjbt_gol_plh' => "'".$this->input->post('last_pjbt_gol_plh')."'",
                                            'last_pjbt_jabatan_plh' => "'".$this->input->post('last_pjbt_jabatan_plh')."'",
                                            'last_pjbt_id_j_plh' => $this->input->post('last_pjbt_id_j_plh')
                                        );
                                        $tglKegiatan = "'" . $data['tglKegiatan'] . ' ' . $data['jamKegiatan'] . "'";
                                        $query = $this->ekinerja->insert_kinerja_historis_alih_tugas($data_atasan, $cek_exist['id_knj'], $tglKegiatan);
                                        if ($query['query'] > 0) {
                                            $query = $this->ekinerja->insertKinerjaKegiatan($data, $query['idknj_hist_alih_tugas']);
                                            if ($query['query'] > 0) {
                                                $result = $this->transaksi_sukses($query['id_knj_kegiatan']);
                                            } else {
                                                $result = $this->transaksi_gagal();
                                            }
                                        } else {
                                            $result = $this->transaksi_gagal();
                                        }
                                    }
                                } else {
                                    $result = $this->jam_kegiatan_blm_diatas_keg_terakhir($keg_terakhir);
                                }
                            } else {
                                $data = array(
                                    'ddBln' => $this->input->post('ddBln'),
                                    'ddThn' => $this->input->post('ddThn'),
                                    'id_pegawai' => $this->input->post('id_pegawai'),
                                    'last_jenjab' => $this->input->post('last_jenjab'),
                                    'last_kode_jabatan' => $this->input->post('last_kode_jabatan'),
                                    'last_jabatan' => $this->input->post('last_jabatan'),
                                    'last_eselon' => $this->input->post('last_eselon'),
                                    'last_gol' => $this->input->post('last_gol'),
                                    'last_id_unit_kerja' => $this->input->post('last_id_unit_kerja'),
                                    'last_unit_kerja' => $this->input->post('last_unit_kerja'),
                                    'last_atsl_idp' => $this->input->post('last_atsl_idp'),
                                    'last_atsl_nip' => $this->input->post('last_atsl_nip'),
                                    'last_atsl_nama' => $this->input->post('last_atsl_nama'),
                                    'last_atsl_gol' => $this->input->post('last_atsl_gol'),
                                    'last_atsl_jabatan' => $this->input->post('last_atsl_jabatan'),
                                    'last_atsl_id_j' => $this->input->post('last_atsl_id_j'),
                                    'last_pjbt_idp' => $this->input->post('last_pjbt_idp'),
                                    'last_pjbt_nip' => $this->input->post('last_pjbt_nip'),
                                    'last_pjbt_nama' => $this->input->post('last_pjbt_nama'),
                                    'last_pjbt_gol' => $this->input->post('last_pjbt_gol'),
                                    'last_pjbt_jabatan' => $this->input->post('last_pjbt_jabatan'),
                                    'last_pjbt_id_j' => $this->input->post('last_pjbt_id_j'),
                                    'id_skp' => $this->input->post('txtIdSkp'),
                                    'tmt_skp' => $this->input->post('txtTmtSkp'),
                                    'ddKatKegiatan' => $this->input->post('ddKatKegiatan'),
                                    'tglKegiatan' => $this->input->post('tglKegiatan'),
                                    'jamKegiatan' => $this->input->post('jamKegiatan'),
                                    'txtRincian' => $this->input->post('txtRincian'),
                                    'txtKet' => $this->input->post('txtKet'),
                                    'txtKuantitas' => $this->input->post('txtKuantitas'),
                                    'ddSatuan' => $this->input->post('ddSatuan'),
                                    'txtDurasi' => $this->input->post('txtDurasi'),
                                    'last_status_pegawai' => $this->input->post('last_status_pegawai'),

                                    'last_atsl_idp_plh' => $this->input->post('last_atsl_idp_plh'),
                                    'last_atsl_nip_plh' => "'".$this->input->post('last_atsl_nip_plh')."'",
                                    'last_atsl_nama_plh' => "'".$this->input->post('last_atsl_nama_plh')."'",
                                    'last_atsl_gol_plh' => "'".$this->input->post('last_atsl_gol_plh')."'",
                                    'last_atsl_jabatan_plh' => "'".$this->input->post('last_atsl_jabatan_plh')."'",
                                    'last_atsl_id_j_plh' => $this->input->post('last_atsl_id_j_plh'),
                                    'last_pjbt_idp_plh' => $this->input->post('last_pjbt_idp_plh'),
                                    'last_pjbt_nip_plh' => "'".$this->input->post('last_pjbt_nip_plh')."'",
                                    'last_pjbt_nama_plh' => "'".$this->input->post('last_pjbt_nama_plh')."'",
                                    'last_pjbt_gol_plh' => "'".$this->input->post('last_pjbt_gol_plh')."'",
                                    'last_pjbt_jabatan_plh' => "'".$this->input->post('last_pjbt_jabatan_plh')."'",
                                    'last_pjbt_id_j_plh' => $this->input->post('last_pjbt_id_j_plh')

                                );
                                $query = $this->ekinerja->insertKinerjaMaster($data);
                                if ($query['query'] > 0) {
                                    $result = $this->transaksi_sukses($query['id_knj_kegiatan']);
                                } else {
                                    $result = $this->transaksi_gagal($query['id_knj_kegiatan']);
                                }
                            }
                        }
                    } else {
                        $result = $this->status_belum_absensi('Tidak ada keterangan');
                    }
                }
            }else{
                $result = $this->periode_aktivitas_not_valid($actPeriode[1], $actPeriode[0]);
            }
        }
        echo json_encode($result);
    }

    public function daftar_kinerja_master(){
        $id_pegawai = $this->input->get('id_pegawai');
        $query = $this->ekinerja->listof_kinerja_master($id_pegawai, $this->keyApps);
        $data = $query->result();
        $data = array(	'code'=>200,
            'status'=>'success',
            'title'=>'Data List Kinerja Master',
            'data'=>$data,
            'rel'=>'self'
        );
        echo json_encode($data);
    }

    public function daftar_kinerja_hist_alih_tugas_by_idp(){
        $id_pegawai = $this->input->get('id_pegawai');
        $query = $this->ekinerja->listof_knj_hist_alih_tugas_by_idpegawai($id_pegawai);
        $data = $query->result();
        $data = array(	'code'=>200,
            'status'=>'success',
            'title'=>'Data List Kinerja Historis Alih Tugas',
            'data'=>$data,
            'rel'=>'self'
        );
        echo json_encode($data);
    }

    public function daftar_kinerja_hist_alih_tugas_by_idknj(){
        $id_knj_master = $this->input->get('id_knj_master');
        $query = $this->ekinerja->listof_knj_hist_alih_tugas_by_id_knj($id_knj_master, $this->keyApps);
        $data = $query->result();
        $data = array(	'code'=>200,
            'status'=>'success',
            'title'=>'Data List Kinerja Historis Alih Tugas',
            'data'=>$data,
            'rel'=>'self'
        );
        echo json_encode($data);
    }

    public function hapus_kinerja_master(){
        header("Access-Control-Allow-Origin: *");
        $id_knj = $this->input->post('id_knj_master');
        $query = $this->ekinerja->deleteKinerjaMaster($id_knj, $this->keyApps);
        if($query > 0){
            $result = $this->hapus_sukses();
        }else{
            $result=$this->hapus_gagal();
        }
        echo json_encode($result);
    }

    public function detail_laporan_kinerja(){
        $id_knj_master = $this->input->get('id_knj_master');
        $query = $this->ekinerja->detailLaporanKinerjaById($id_knj_master, $this->keyApps);
        $data = $query->result();
        $data = array(	'code'=>200,
            'status'=>'success',
            'title'=>'Data Detail Laporan Kinerja Master',
            'data'=>$data,
            'rel'=>'self'
        );
        echo json_encode($data);
    }

    public function get_stk_skp(){
        $jenjab = $this->input->get('jenjab');
        $eselon = $this->input->get('eselon');
        $kode_jabatan = $this->input->get('kode_jabatan');
        $query = $this->ekinerja->listStkSkp($jenjab,$eselon,$kode_jabatan);
        $data = $query->result();
        $data = array('code'=>200,
            'status'=>'success',
            'title'=>'Data List STK SKP',
            'data'=>$data,
            'rel'=>'self'
        );
        echo json_encode($data);
    }

    public function get_skp(){
        $id_pegawai = $this->input->get('id_pegawai');
        $query = $this->ekinerja->listSkpByPeriodeAndIdPeg($id_pegawai);
        $data = $query->result();
        $data = array('code'=>200,
            'status'=>'success',
            'title'=>'Data List SKP Pegawai pada Periode Tahun terakhir',
            'data'=>$data,
            'rel'=>'self'
        );
        echo json_encode($data);
    }

    public function get_info_last_skp(){
        $id_pegawai = $this->input->get('id_pegawai');
        $query = $this->ekinerja->infoLastSKP($id_pegawai);
        $data = $query->result();
        $data = array('code'=>200,
            'status'=>'success',
            'title'=>'Data Info SKP Terakhir',
            'data'=>$data,
            'rel'=>'self'
        );
        echo json_encode($data);
    }

    public function get_skp_by_id(){
        $id_skp = $this->input->get('id_skp');
        $query = $this->ekinerja->listSkpById($id_skp);
        $data = $query->result();
        $data = array('code'=>200,
            'status'=>'success',
            'title'=>'Data List Kegiatan by Id SKP',
            'data'=>$data,
            'rel'=>'self'
        );
        echo json_encode($data);
    }

    public function get_info_last_skp_byid(){
        $id_skp = $this->input->get('id_skp');
        $query = $this->ekinerja->infoLastSKPById($id_skp);
        $data = $query->result();
        $data = array('code'=>200,
            'status'=>'success',
            'title'=>'Data Info SKP berdasarkan ID tertentu',
            'data'=>$data,
            'rel'=>'self'
        );
        echo json_encode($data);
    }

    public function list_aktifitas_kegiatan_by_id(){
        $id_knj_master = $this->input->get('id_knj_master');
        if($id_knj_master!='' or $id_knj_master!=0){
            $query = $this->ekinerja->getAktivitasKegiatan($id_knj_master, $this->keyApps);
            $data = $query->result();
        }else{
            $data = '';
        }
        $data = array(	'code'=>200,
            'status'=>'success',
            'title'=>'Data List Aktifitas Kegiatan Pegawai',
            'data'=>$data,
            'rel'=>'self'
        );
        echo json_encode($data);
    }

    public function get_idknj_master(){
        $id_pegawai = $this->input->get('id_pegawai');
        $data = $this->ekinerja->getIdKnjMaster($id_pegawai, $this->keyApps);
        $data = array(	'code'=>200,
            'status'=>'success',
            'title'=>'ID Master Kinerja',
            'data'=>$data,
            'rel'=>'self'
        );
        echo json_encode($data);
    }

    public function get_jml_knj_hist_alih_tugas(){
        $id_pegawai = $this->input->get('id_pegawai');
        $data = $this->ekinerja->getJmlHistAlihTugas($id_pegawai);
        $data = array(	'code'=>200,
            'status'=>'success',
            'title'=>'Jumlah Historis Alih Tugas',
            'data'=>$data,
            'rel'=>'self'
        );
        echo json_encode($data);
    }

    public function get_info_pegawai_by_nip(){
        $nip = $this->input->get('nip');
        $query = $this->ekinerja->getInformasiPegawai($nip);
        $data = $query->result();
        $data = array('code'=>200,
            'status'=>'success',
            'title'=>'Data Informasi Pegawai berdasarkan NIP',
            'data'=>$data,
            'rel'=>'self'
        );
        echo json_encode($data);
    }

    public function ubah_aktifitas_kegiatan(){
        $id_knj = $this->input->get('id_knj_keg');
        $query = $this->ekinerja->ubahAktifitasKegiatanById($id_knj, $this->keyApps);
        $data = $query->result();
        $data = array(	'code'=>200,
            'status'=>'success',
            'title'=>'Ubah Aktifitas Kegiatan',
            'data'=>$data,
            'rel'=>'self'
        );
        echo json_encode($data);
    }

    public function hapus_aktifitas_kegiatan(){
        header("Access-Control-Allow-Origin: *");
        $id_knj = $this->input->post('id_knj_kegiatan');
        $query = $this->ekinerja->hapusAktifitasKegiatanById($id_knj, $this->keyApps);
        if($query > 0){
            $result = $this->hapus_sukses();
        }else{
            $result=$this->hapus_gagal();
        }
        echo json_encode($result);
    }

    public function hapus_berkas_kegiatan(){
        header("Access-Control-Allow-Origin: *");
        $id_knj = $this->input->post('id_knj_kegiatan');
        $query = $this->ekinerja->hapusBerkasKegiatanById($id_knj, $this->keyApps);
        if($query > 0){
            $result = $this->hapus_sukses();
        }else{
            $result=$this->hapus_gagal();
        }
        echo json_encode($result);
    }

    public function hapus_kinerja_hist_alih_tugas(){
        header("Access-Control-Allow-Origin: *");
        $id_knj = $this->input->post('id_knj_master');
        $idknj_hist_alih_tugas = $this->input->post('idknj_hist_alih_tugas');
        $query = $this->ekinerja->hapusHistAlihTugas($id_knj, $idknj_hist_alih_tugas, $this->keyApps);
        if($query > 0){
            $result = $this->hapus_sukses();
        }else{
            $result=$this->hapus_gagal();
        }
        echo json_encode($result);
    }

    function get_satuan_output(){
        $query = $this->ekinerja->getSatuanHasilOutput();
        $data = $query->result();
        $data = array('code'=>200,
            'status'=>'success',
            'title'=>'Satuan Output Hasil Aktifitas Kegiatan',
            'data'=>$data,
            'rel'=>'self'
        );
        echo json_encode($data);
    }

    public function get_absensi_kehadiran_apel(){
        $id_knj_master = $this->input->get('id_knj_master');
        $id_pegawai = $this->input->get('id_pegawai');
        $filter_tgl = $this->input->get('filter_tgl');
        $query = $this->ekinerja->listof_knj_hist_absensi_kehadiran_apel($id_knj_master, $id_pegawai, $filter_tgl, $this->keyApps);
        $data = $query->result();
        $data = array(	'code'=>200,
            'status'=>'success',
            'title'=>'Data List Absensi Kehadiran dan Apel Kinerja',
            'data'=>$data,
            'rel'=>'self'
        );
        echo json_encode($data);
    }

    public function exec_kalkulasi_nilai_tunjangan_kinerja(){
        $id_pegawai = $this->input->get('id_pegawai');
        $id_knj_master = $this->input->get('id_knj_master');
        $bln = $this->input->get('bln');
        $thn = $this->input->get('thn');
        $query = $this->ekinerja->execute_sp_kalkulasi_kinerja($id_pegawai,$bln,$thn,$id_knj_master,$this->keyApps);
        if ($query > 0) {
            $result = $this->kalkulasi_sukses();
        }else{
            $result = $this->kalkulasi_gagal();
        }
        echo json_encode($result);
    }

    public function exec_laporan_kinerja_selesai(){
        $id_knj_master = $this->input->get('id_knj_master');
        $idpegawai_approved = $this->input->get('idpegawai_approved');
        $status_laporan = $this->input->get('status_laporan');
        $query = $this->ekinerja->execute_sp_kinerja_selesai($id_knj_master, $idpegawai_approved, $status_laporan, $this->keyApps);
        if ($query > 0) {
            $result = $this->transaksi_sukses();
        }else{
            $result = $this->transaksi_gagal();
        }
        echo json_encode($result);
    }

    public function daftar_staf_aktual_kinerja(){
        $id_pegawai_enc = $this->input->get('id_pegawai_enc');
        $id_skpd_enc = $this->input->get('id_skpd_enc');
        $query = $this->ekinerja->list_staf_aktual_kinerja($id_pegawai_enc, $id_skpd_enc, $this->keyApps);
        $data = $query->result();
        $data = array(	'code'=>200,
            'status'=>'success',
            'title'=>'Data List Pegawai Staf Aktual dan Kinerjanya',
            'data'=>$data,
            'rel'=>'self'
        );
        echo json_encode($data);
    }

    public function jumlah_peninjauan_kegiatan_staf(){
        $idstatus = $this->input->get('idstatus');
        $keyword = $this->input->get('keyword');
        $id_knj_master = $this->input->get('id_knj_master');
        $id_pegawai_atsl_enc = $this->input->get('id_pegawai_atasan_enc');
        $query = $this->ekinerja->jumlah_peninjauan_kegiatan_staf($idstatus, $keyword, $id_knj_master, $id_pegawai_atsl_enc, $this->keyApps);
        $data = $query->result();
        $data = array(	'code'=>200,
            'status'=>'success',
            'title'=>'Jumlah List Kegiatan Staf',
            'data'=>$data,
            'rel'=>'self'
        );
        echo json_encode($data);
    }

    public function daftar_peninjauan_kegiatan_staf(){
        $row_number_start = $this->input->get('row_number_start');
        $idstatus = $this->input->get('idstatus');
        $keyword = $this->input->get('keyword');
        $id_knj_master = $this->input->get('id_knj_master');
        $id_pegawai_atsl_enc = $this->input->get('id_pegawai_atasan_enc');
        $limit = $this->input->get('limit');
        $query = $this->ekinerja->list_peninjauan_kegiatan_staf($row_number_start, $idstatus, $keyword, $id_knj_master, $id_pegawai_atsl_enc, $limit, $this->keyApps);
        $data = $query->result();
        $data = array(	'code'=>200,
            'status'=>'success',
            'title'=>'Data List Kegiatan Staf',
            'data'=>$data,
            'rel'=>'self'
        );
        echo json_encode($data);
    }

    public function get_jml_aktifitas_byperiode(){
        $bln = $this->input->get('bln');
        $thn = $this->input->get('thn');
        $keyword = $this->input->get('keyword');
        $id_pegawai_enc = $this->input->get('id_pegawai_enc');
        $query = $this->ekinerja->jumlah_aktifitas_by_periode($bln, $thn, $keyword, $id_pegawai_enc);
        $data = $query->result();
        $data = array(	'code'=>200,
            'status'=>'success',
            'title'=>'Jumlah Aktifitas Per Periode',
            'data'=>$data,
            'rel'=>'self'
        );
        echo json_encode($data);
    }

    public function daftar_aktifitas_by_periode(){
        $row_number_start = $this->input->get('row_number_start');
        $bln = $this->input->get('bln');
        $thn = $this->input->get('thn');
        $keyword = $this->input->get('keyword');
        $id_pegawai_enc = $this->input->get('id_pegawai_enc');
        $limit = $this->input->get('limit');
        $query = $this->ekinerja->list_aktifitas_by_periode($row_number_start, $bln, $thn, $keyword, $id_pegawai_enc, $limit);
        $data = $query->result();
        $data = array(	'code'=>200,
            'status'=>'success',
            'title'=>'Daftar Aktifitas Per Periode',
            'data'=>$data,
            'rel'=>'self'
        );
        echo json_encode($data);
    }

    public function proses_aktifitas_kegiatan_by_id(){
        $data = array(
            'id_knj_kegiatan' => $this->input->post('id_knj_kegiatan'),
            'idstatus' => $this->input->post('idstatus'),
            'ket_approval' => $this->input->post('ket_approval'),
            'id_pegawai' => $this->input->post('id_pegawai')
        );
        $query = $this->ekinerja->updateAktifitasKegiatanById($data, $this->keyApps);
        if ($query > 0) {
            $result = $this->transaksi_sukses();
        } else {
            $result = $this->transaksi_gagal();
        }
        echo json_encode($result);
    }

    public function get_kegiatan_staf_by_id(){
        $id_knj_kegiatan = $this->input->get('id_knj_kegiatan');
        $query = $this->ekinerja->kegiatan_staf_by_id($id_knj_kegiatan, $this->keyApps);
        $data = $query->result();
        $data = array(	'code'=>200,
            'status'=>'success',
            'title'=>'Aktifitas Kegiatan berds. ID tertentu',
            'data'=>$data,
            'rel'=>'self'
        );
        echo json_encode($data);
    }

    public function proses_peninjauan_aktifitas_by_check(){
        $data = array(
            'idstatus' => $this->input->post('ddStsProses'),
            'chkAktifitas' => $this->input->post('chkAktifitas'),
            'id_pegawai_enc' => $this->input->post('id_pegawai_enc')
        );
        $query = $this->ekinerja->prosesPeninjauanAktifitasByChecklist($data, $this->keyApps);
        if ($query > 0) {
            $result = $this->transaksi_sukses();
        } else {
            $result = $this->transaksi_gagal();
        }
        echo json_encode($result);
    }

    public function cek_jabatan_tinggi_pratama_admin_kepala(){
        $id_j = $this->input->get('id_j');
        $data = $this->ekinerja->deteksiJabatanTinggiPratamaAdminKepala($id_j);
        $data = array(	'code'=>200,
            'status'=>'success',
            'title'=>'Cek suatu jabatan apakah termasuk jabatan pimpinan tinggi pratama dan administrator sebagai kepala perangkat daerah',
            'data'=>$data,
            'rel'=>'self'
        );
        echo json_encode($data);
    }

    public function lastTimeKegiatanByPeriode(){
        $id_pegawai = $this->input->get('id_pegawai');
        $bln = $this->input->get('bln');
        $thn = $this->input->get('thn');
        $query = $this->ekinerja->getLastTimeKegiatanByPeriode($id_pegawai, $bln, $thn);
        $data = $query->result();
        $data = array(	'code'=>200,
            'status'=>'success',
            'title'=>'Waktu selesai kegiatan terakhir pada periode tertentu',
            'data'=>$data,
            'rel'=>'self'
        );
        echo json_encode($data);
    }

    public function get_nomor_ponsel(){
        $id_pegawai_enc = $this->input->post('id_pegawai_enc');
        $data = $this->ekinerja->getNomorPonsel($id_pegawai_enc);
        $data = array(	'code'=>200,
            'status'=>'success',
            'title'=>'Nomor Ponsel',
            'data'=>$data,
            'rel'=>'self'
        );
        echo json_encode($data);
    }

    public function getKegiatanSendInfoWhatsApp(){
        $id_knj_kegiatan = $this->input->post('id_knj_kegiatan');
        $query = $this->ekinerja->get_kegiatan_tosend_info_whatsapp($id_knj_kegiatan, $this->keyApps);
        $data = $query->result();
        $data = array('code'=>200,
            'status'=>'success',
            'title'=>'Info Kegiatan dan Ponsel Atasan',
            'data'=>$data,
            'rel'=>'self'
        );
        echo json_encode($data);
    }

    public function getJmlListPegawaiInfoTipeUnit(){
        $id_skpd = $this->input->get('id_skpd_enc');
        $keyword = $this->input->get('keyword');
        $query = $this->ekinerja->jumlah_pegawai_info_tipe_unit($id_skpd, $keyword);
        $data = $query->result();
        $data = array(	'code'=>200,
            'status'=>'success',
            'title'=>'Jumlah List Pegawai dan Tipe Unit Kerjanya',
            'data'=>$data,
            'rel'=>'self'
        );
        echo json_encode($data);
    }

    public function getListPegawaiInfoTipeUnit(){
        $row_number_start = $this->input->get('row_number_start');
        $id_skpd = $this->input->get('id_skpd_enc');
        $keyword = $this->input->get('keyword');
        $limit = $this->input->get('limit');
        $query = $this->ekinerja->list_pegawai_info_tipe_unit($row_number_start, $id_skpd, $keyword, $limit);
        $data = $query->result();
        $data = array(	'code'=>200,
            'status'=>'success',
            'title'=>'Daftar List Pegawai dan Tipe Unit Kerjanya',
            'data'=>$data,
            'rel'=>'self'
        );
        echo json_encode($data);
    }

    public function daftar_kinerja_hist_alih_tugas_detail_calc_by_idknj(){
        $id_knj_master = $this->input->get('id_knj_master');
        $query = $this->ekinerja->listof_knj_hist_alih_tugas_detail_calc_by_id_knj($id_knj_master, $this->keyApps);
        $data = $query->result();
        $data = array(	'code'=>200,
            'status'=>'success',
            'title'=>'Data List Kinerja Historis Alih Tugas untuk Detail Nilai Hasil Kalkulasi',
            'data'=>$data,
            'rel'=>'self'
        );
        echo json_encode($data);
    }

    public function detailNilaiTunjangan_by_hist_alihtugas(){
        $idknj_hist_alih_tugas = $this->input->get('idknj_hist_alih_tugas');
        $query = $this->ekinerja->detail_nilai_tunjangan_by_hist_alihtugas($idknj_hist_alih_tugas, $this->keyApps);
        $data = $query->result();
        $data = array(	'code'=>200,
            'status'=>'success',
            'title'=>'Data List Nilai Tunjangan berds. Alih Tugas',
            'data'=>$data,
            'rel'=>'self'
        );
        echo json_encode($data);
    }

    public function getUnitKerjaUtamaPegawai(){
        $id_pegawai_enc = $this->input->get('id_pegawai_enc');
        $query = $this->ekinerja->get_unit_kerja_utama($id_pegawai_enc, $this->keyApps);
        $data = $query->result();
        $data = array(	'code'=>200,
            'status'=>'success',
            'title'=>'Data Unit Kerja Utama Pegawai',
            'data'=>$data,
            'rel'=>'self'
        );
        echo json_encode($data);
    }

    public function getUnitKerjaSekunderPegawai(){
        $id_pegawai_enc = $this->input->get('id_pegawai_enc');
        $query = $this->ekinerja->get_unit_kerja_sekunder($id_pegawai_enc, $this->keyApps);
        $data = $query->result();
        $data = array(	'code'=>200,
            'status'=>'success',
            'title'=>'Data Unit Kerja Sekunder Pegawai',
            'data'=>$data,
            'rel'=>'self'
        );
        echo json_encode($data);
    }

    public function ubah_tipe_lokasi_pegawai_by_idclk(){
        $data = array(
            'isMulti' => $this->input->post('isMulti'),
            'idClk' => $this->input->post('idClk'),
            'idp_updater' => $this->input->post('idp_updater')
        );
        $query = $this->ekinerja->updateTipeLokasiPegawai($data, $this->keyApps);
        if ($query > 0) {
            $result = $this->transaksi_sukses();
        } else {
            $result = $this->transaksi_gagal();
        }
        echo json_encode($result);
    }

    public function getUnitKerjaSekunderByTerm(){
        $q = $this->input->get('q');
        $tipe_unit = $this->input->get('tipe_unit');
        if($tipe_unit=='utama'){
            $opd = $this->input->get('opd');
        }else{
            $opd = '';
        }
        $query = $this->ekinerja->get_lokasi_unit_sekunder_by_term($q, $tipe_unit, $opd, $this->keyApps);
        $data = $query->result();
        $data = array(	'code'=>200,
            'status'=>'success',
            'title'=>'Data Unit Kerja Sekunder Berds. Nama atau Alamat',
            'data'=>$data,
            'rel'=>'self'
        );
        echo json_encode($data);
    }

    public function getInfoUnitSekunderById(){
        $idUnitSekunder = $this->input->get('idUnitSekunder');
        $tipeUnit = $this->input->get('tipeUnit');
        $query = $this->ekinerja->get_info_lokasi_sekunder_by_id($idUnitSekunder, $tipeUnit, $this->keyApps);
        $data = $query->result();
        $data = array(	'code'=>200,
            'status'=>'success',
            'title'=>'Data Unit Kerja Sekunder Berds. ID tertentu',
            'data'=>$data,
            'rel'=>'self'
        );
        echo json_encode($data);
    }

    public function insertUnitSekunderPegawai(){
        $iduk_sekunder = $this->input->post('idLokasiSekunder');
        $idp = $this->input->post('idp');

        $eksisting = $this->ekinerja->cek_eksisting_unit_sekunder_by_idpegawai($iduk_sekunder, $idp, $this->keyApps);
        if($eksisting==1){
            $result = $this->data_exist();
        }else{
            $data = array(
                'idLokasiSekunder' => $iduk_sekunder,
                'idp' => $idp,
                'tipe_lokasi' => $this->input->post('tipe_lokasi'),
                'txtNoSPMT' => $this->input->post('txtNoSPMT'),
                'tmtSpmt' => $this->input->post('tmtSpmt'),
                'inputer' => $this->input->post('inputer')
            );
            $query = $this->ekinerja->insert_unit_sekunder_pegawai($data, $this->keyApps);
            if ($query['query'] > 0) {
                $result = $this->transaksi_sukses($query['id_clkl']);
            } else {
                $result = $this->transaksi_gagal();
            }
        }
        echo json_encode($result);
    }

    public function update_url_berkas_spmt_clkl(){
        $uploadfile = $this->input->get('uploadfile');
        $nf_baru = $this->input->get('nf_baru');
        $idclkl = $this->input->get('idclkl');
        $status = $this->input->get('status');
        if($status==1){
            $query = $this->ekinerja->update_url_berkas_spmt_clkl($nf_baru, $idclkl);
            if ($query['query'] == 1) {
                /*if(file_exists($_SERVER['DOCUMENT_ROOT']."/ekinerja2/berkas/".$nf_baru)){
                    unlink($_SERVER['DOCUMENT_ROOT']."/ekinerja2/berkas/".$nf_baru);
                }
                rename($_SERVER['DOCUMENT_ROOT'].'/ekinerja2/'.$uploadfile, $_SERVER['DOCUMENT_ROOT']."/ekinerja2/berkas/".$nf_baru);*/
                $uploaddir = '/var/www/html/ekinerja2/berkas/';
                $connection = ssh2_connect('103.14.229.15');
                ssh2_auth_password($connection, 'rommonz', 'mony3Tmony3T');
                $sftp = ssh2_sftp($connection);
                if (file_exists('ssh2.sftp://' . $sftp . '/var/www/html/ekinerja2/berkas/'.$nf_baru)) {
                    ssh2_sftp_unlink($sftp, '/var/www/html/ekinerja2/berkas/'.$nf_baru);
                }
                ssh2_sftp_rename($sftp, $uploadfile,$uploaddir.$nf_baru);
                $result = $this->transaksi_sukses();
            } else {
                $result = $this->transaksi_gagal();
            }
            echo json_encode($result);
        }
    }

    public function hapusUnitSekunderPegawai(){
        header("Access-Control-Allow-Origin: *");
        $id_unit_sekunder_pegawai = $this->input->post('id_unit_sekunder_pegawai_enc');
        $query = $this->ekinerja->hapus_unit_sekunder_pegawai($id_unit_sekunder_pegawai, $this->keyApps);
        if($query['query'] > 0){
            $result = $this->hapus_sukses();
        }else{
            $result=$this->hapus_gagal();
        }
        echo json_encode($result);
    }

    public function insertUnitSekunderBaruPegawai(){
        $data = array(
            'coordinat_y_in' => $this->input->post('coordinat_y_in'),
            'coordinat_x_in' => $this->input->post('coordinat_x_in'),
            'coordinat_y_out' => $this->input->post('coordinat_y_out'),
            'coordinat_x_out' => $this->input->post('coordinat_x_out'),
            'ddTipeWilayah' => $this->input->post('ddTipeWilayah'),
            'idIndukLokasiSekunder' => $this->input->post('idIndukLokasiSekunder'),
            'idUnitKerjaUtama' => $this->input->post('idUnitKerjaUtama'),
            'namaLokasi' => $this->input->post('namaLokasi'),
            'txtAlamat' => $this->input->post('txtAlamat'),
            'txtTelepon' => $this->input->post('txtTelepon'),
            'txtEmail' => $this->input->post('txtEmail'),
            'idp' => $this->input->post('idp'),
            'txtNoSPMT' => $this->input->post('txtNoSPMT'),
            'tmtSpmt' => $this->input->post('tmtSpmt'),
            'inputer' => $this->input->post('inputer')
        );
        $query = $this->ekinerja->insert_unit_sekunder_baru_pegawai($data, $this->keyApps);
        if ($query['query'] > 0) {
            $result = $this->transaksi_sukses($query['id_clkl']);
        } else {
            $result = $this->transaksi_gagal();
        }
        echo json_encode($result);
    }

    public function daftar_unit_kerja_sekunder_by_opd(){
        $opd = $this->input->get('opd');
        $query = $this->ekinerja->listof_unit_kerja_sekunder_by_opd($opd, $this->keyApps);
        $data = $query->result();
        $data = array(	'code'=>200,
            'status'=>'success',
            'title'=>'Data List Unit Kerja Sekunder berds. OPD tertentu',
            'data'=>$data,
            'rel'=>'self'
        );
        echo json_encode($data);
    }

    public function jml_daftar_unit_kerja_sekunder_by_opd_paged(){
        $opd = $this->input->get('opd');
        $keyword = $this->input->get('keyword');
        $query = $this->ekinerja->jml_daftar_unit_kerja_sekunder_by_opd_paged($opd, $keyword);
        $data = $query->result();
        $data = array(	'code'=>200,
            'status'=>'success',
            'title'=>'Jumlah List Unit Kerja Sekunder berds. OPD tertentu ter-paging',
            'data'=>$data,
            'rel'=>'self'
        );
        echo json_encode($data);
    }

    public function list_daftar_unit_kerja_sekunder_by_opd_paged(){
        $row_number_start = $this->input->get('row_number_start');
        $opd = $this->input->get('opd');
        $keyword = $this->input->get('keyword');
        $limit = $this->input->get('limit');
        $query = $this->ekinerja->list_daftar_unit_kerja_sekunder_by_opd_paged($row_number_start, $opd, $keyword, $limit, $this->keyApps);
        $data = $query->result();
        $data = array(	'code'=>200,
            'status'=>'success',
            'title'=>'Daftar List Unit Kerja Sekunder berds. OPD tertentu ter-paging',
            'data'=>$data,
            'rel'=>'self'
        );
        echo json_encode($data);
    }

    public function insertUnitSekunderBaruLokasi(){
        $data = array(
            'coordinat_y_in' => $this->input->post('coordinat_y_in'),
            'coordinat_x_in' => $this->input->post('coordinat_x_in'),
            'coordinat_y_out' => $this->input->post('coordinat_y_out'),
            'coordinat_x_out' => $this->input->post('coordinat_x_out'),
            'ddTipeWilayah' => $this->input->post('ddTipeWilayah'),
            'idIndukLokasiSekunder' => $this->input->post('idIndukLokasiSekunder'),
            'idUnitKerjaUtama' => $this->input->post('idUnitKerjaUtama'),
            'namaLokasi' => $this->input->post('namaLokasi'),
            'txtAlamat' => $this->input->post('txtAlamat'),
            'txtTelepon' => $this->input->post('txtTelepon'),
            'txtEmail' => $this->input->post('txtEmail'),
            'inputer' => $this->input->post('inputer')
        );
        $query = $this->ekinerja->insert_unit_sekunder_baru_lokasi($data, $this->keyApps);
        if ($query > 0) {
            $result = $this->transaksi_sukses();
        } else {
            $result = $this->transaksi_gagal();
        }
        echo json_encode($result);
    }

    public function hapusUnitSekunderLokasi(){
        header("Access-Control-Allow-Origin: *");
        $id_unit_sekunder = $this->input->post('id_unit_sekunder_enc');
        $query = $this->ekinerja->hapus_unit_sekunder_lokasi($id_unit_sekunder, $this->keyApps);
        if($query > 0){
            $result = $this->hapus_sukses();
        }else{
            $result=$this->hapus_gagal();
        }
        echo json_encode($result);
    }

    public function ubah_unit_sekunder(){
        $id_uk_sekunder = $this->input->get('id_uk_sekunder');
        $query = $this->ekinerja->ubahUnitSekunder($id_uk_sekunder, $this->keyApps);
        $data = $query->result();
        $data = array(	'code'=>200,
            'status'=>'success',
            'title'=>'Ubah Unit Kerja Sekunder',
            'data'=>$data,
            'rel'=>'self'
        );
        echo json_encode($data);
    }

    public function update_unit_sekunder(){
        $data = array(
            'coordinat_y_in' => $this->input->post('coordinat_y_in'),
            'coordinat_x_in' => $this->input->post('coordinat_x_in'),
            'coordinat_y_out' => $this->input->post('coordinat_y_out'),
            'coordinat_x_out' => $this->input->post('coordinat_x_out'),
            'ddTipeWilayah' => $this->input->post('ddTipeWilayah'),
            'idIndukLokasiSekunder' => $this->input->post('idIndukLokasiSekunder'),
            'idUnitKerjaUtama' => $this->input->post('idUnitKerjaUtama'),
            'namaLokasi' => $this->input->post('namaLokasi'),
            'txtAlamat' => $this->input->post('txtAlamat'),
            'txtTelepon' => $this->input->post('txtTelepon'),
            'txtEmail' => $this->input->post('txtEmail'),
            'id_uk_sekunder' => $this->input->post('id_uk_sekunder')
        );
        $query = $this->ekinerja->updateUnitSekunder($data, $this->keyApps);
        if ($query > 0) {
            $result = $this->transaksi_sukses();
        } else {
            $result = $this->transaksi_gagal();
        }
        echo json_encode($result);
    }

    function jumlah_jadwal_khusus_by_opd(){
        $opd = $this->input->get('opd');
        $bln = $this->input->get('bln');
        $thn = $this->input->get('thn');
        $id_jenis_jadwal = $this->input->get('id_jenis_jadwal');
        $idp = $this->input->get('idp');
        $tglMulaiAcara = $this->input->get('tglMulaiAcara');
        $tglSelesaiAcara = $this->input->get('tglSelesaiAcara');
        $keyword = $this->input->get('keyword');
        $query = $this->ekinerja->jml_jadwal_khusus_by_opd($opd, $bln, $thn, $id_jenis_jadwal, $idp, $tglMulaiAcara, $tglSelesaiAcara, $keyword, $this->keyApps);
        $data = $query->result();
        $data = array(	'code'=>200,
            'status'=>'success',
            'title'=>'Jumlah List Jadwal Transaksi Detail berds. OPD tertentu',
            'data'=>$data,
            'rel'=>'self'
        );
        echo json_encode($data);
    }

    function daftar_jadwal_khusus_by_opd(){
        $row_number_start = $this->input->get('row_number_start');
        $opd = $this->input->get('opd');
        $bln = $this->input->get('bln');
        $thn = $this->input->get('thn');
        $id_jenis_jadwal = $this->input->get('id_jenis_jadwal');
        $idp = $this->input->get('idp');
        $tglMulaiAcara = $this->input->get('tglMulaiAcara');
        $tglSelesaiAcara = $this->input->get('tglSelesaiAcara');
        $keyword = $this->input->get('keyword');
        $limit = $this->input->get('limit');
        $query = $this->ekinerja->listof_jadwal_khusus_by_opd($row_number_start, $opd, $bln, $thn, $id_jenis_jadwal, $idp, $tglMulaiAcara, $tglSelesaiAcara, $keyword, $limit, $this->keyApps);
        $data = $query->result();
        $data = array(	'code'=>200,
            'status'=>'success',
            'title'=>'Data List Jadwal Transaksi Detail berds. OPD tertentu',
            'data'=>$data,
            'rel'=>'self'
        );
        echo json_encode($data);
    }

    public function refJadwalJenis(){
        $query = $this->ekinerja->ref_jadwal_jenis();
        $data = $query->result();
        $data = array(	'code'=>200,
            'status'=>'success',
            'title'=>'Data List Jenis Jadwal',
            'data'=>$data,
            'rel'=>'self'
        );
        echo json_encode($data);
    }

    public function insertJadwalKhusus(){
        $data = array(
            'periode_bln' => $this->input->post('periode_bln'),
            'periode_thn' => $this->input->post('periode_thn'),
            'txtKeterangan' => $this->input->post('txtKeterangan'),
            'txtNoSPMT' => $this->input->post('txtNoSPMT'),
            'tmtJadwal' => $this->input->post('tmtJadwal'),
            'inputer' => $this->input->post('inputer'),
            'id_skpd_enc' => $this->input->post('id_skpd_enc')
        );
        $query = $this->ekinerja->insert_jadwal_khusus($data, $this->keyApps);
        if ($query['query'] > 0) {
            $result = $this->transaksi_sukses($query['idjadwal_spmt_enc'], $query['idjadwal_spmt']);
        } else {
            $result = $this->transaksi_gagal();
        }
        echo json_encode($result);
    }

    public function ubah_jadwal_khusus(){
        $idspmt_jadwal = $this->input->get('idspmt_jadwal');
        $query = $this->ekinerja->ubahJadwalKhusus($idspmt_jadwal, $this->keyApps);
        $data = $query->result();
        $data = array('code'=>200,
            'status'=>'success',
            'title'=>'Ubah Jadwal Khusus',
            'data'=>$data,
            'rel'=>'self'
        );
        echo json_encode($data);
    }

    public function jmlPegawaiByIdOPD(){
        $id_skpd = $this->input->get('id_skpd_enc');
        $keyword = $this->input->get('keyword');
        $query = $this->ekinerja->jml_pegawai_by_id_opd($id_skpd, $keyword);
        $data = $query->result();
        $data = array(	'code'=>200,
            'status'=>'success',
            'title'=>'Jumlah Pegawai pada OPD tertentu',
            'data'=>$data,
            'rel'=>'self'
        );
        echo json_encode($data);
    }

    public function listPegawaiByIdOPD(){
        $row_number_start = $this->input->get('row_number_start');
        $id_skpd = $this->input->get('id_skpd_enc');
        $keyword = $this->input->get('keyword');
        $limit = $this->input->get('limit');
        $query = $this->ekinerja->list_pegawai_by_id_opd($row_number_start, $id_skpd, $keyword, $limit, $this->keyApps);
        $data = $query->result();
        $data = array(	'code'=>200,
            'status'=>'success',
            'title'=>'Daftar Pegawai pada OPD tertentu',
            'data'=>$data,
            'rel'=>'self'
        );
        echo json_encode($data);
    }

    public function update_url_berkas_spmt_jdwl_khusus(){
        $uploadfile = $this->input->get('uploadfile');
        $nf_baru = $this->input->get('nf_baru');
        $idjdwl_spmt = $this->input->get('idjdwl_spmt');
        $status = $this->input->get('status');
        if($status==1){
            $query = $this->ekinerja->update_url_berkas_spmt_jdwl_khusus($nf_baru, $idjdwl_spmt, $this->keyApps);
            if ($query['query'] == 1) {
                /*if(file_exists($_SERVER['DOCUMENT_ROOT']."/ekinerja2/berkas/".$nf_baru)){
                    unlink($_SERVER['DOCUMENT_ROOT']."/ekinerja2/berkas/".$nf_baru);
                }
                rename($_SERVER['DOCUMENT_ROOT'].'/ekinerja2/'.$uploadfile, $_SERVER['DOCUMENT_ROOT']."/ekinerja2/berkas/".$nf_baru);*/
                $uploaddir = '/var/www/html/ekinerja2/berkas/';
                $connection = ssh2_connect('103.14.229.15');
                ssh2_auth_password($connection, 'rommonz', 'mony3Tmony3T');
                $sftp = ssh2_sftp($connection);
                if (file_exists('ssh2.sftp://' . $sftp . '/var/www/html/ekinerja2/berkas/'.$nf_baru)) {
                    ssh2_sftp_unlink($sftp, '/var/www/html/ekinerja2/berkas/'.$nf_baru);
                }
                ssh2_sftp_rename($sftp, $uploadfile,$uploaddir.$nf_baru);
                $result = $this->transaksi_sukses();
            } else {
                $result = $this->transaksi_gagal();
            }
            echo json_encode($result);
        }
    }

    public function updateJadwalKhusus(){
        $data = array(
            'ddBln' => $this->input->post('ddBln'),
            'ddThn' => $this->input->post('ddThn'),
            'txtKeterangan' => $this->input->post('txtKeterangan'),
            'txtNoSPMT' => $this->input->post('txtNoSPMT'),
            'idspmt_jadwal' => $this->input->post('idspmt_jadwal'),
            'idspmt_jadwal_enc' => $this->input->post('idspmt_jadwal_enc')
        );
        $query = $this->ekinerja->update_jadwal_khusus($data, $this->keyApps);
        if ($query['query'] > 0) {
            $result = $this->transaksi_sukses($this->input->post('idspmt_jadwal_enc'), $this->input->post('idspmt_jadwal'));
        } else {
            $result = $this->transaksi_gagal();
        }
        echo json_encode($result);
    }

    public function detail_laporan_kinerja_by_hist(){
        $id_knj_master = $this->input->get('id_knj_master');
        $idknj_hist_alih_tugas = $this->input->get('idknj_hist_alih_tugas');
        $query = $this->ekinerja->detailLaporanKinerjaByIdHistAlihTugas($id_knj_master, $idknj_hist_alih_tugas, $this->keyApps);
        $data = $query->result();
        $data = array(	'code'=>200,
            'status'=>'success',
            'title'=>'Data Detail Laporan Kinerja Master Berds. Historis Alih Tugas',
            'data'=>$data,
            'rel'=>'self'
        );
        echo json_encode($data);
    }

    public function get_info_pegawai_by_idpegawai(){
        $idp = $this->input->get('idp');
        $query = $this->ekinerja->getInformasiPegawaiByIdp($idp);
        $data = $query->result();
        $data = array('code'=>200,
            'status'=>'success',
            'title'=>'Data Informasi Pegawai berdasarkan IdPegawai',
            'data'=>$data,
            'rel'=>'self'
        );
        echo json_encode($data);
    }

    function jumlahJadwalSpmtByInputer(){
        $bln = $this->input->get('bln');
        $thn = $this->input->get('thn');
        $keyword = $this->input->get('keyword');
        $idp = $this->input->get('idp');
        $idskpd = $this->input->get('idskpd');
        $query = $this->ekinerja->jumlah_jadwal_spmt_by_inputer($bln, $thn, $keyword, $idp, $idskpd);
        $data = $query->result();
        $data = array(	'code'=>200,
            'status'=>'success',
            'title'=>'Jumlah List Jadwal Khusus',
            'data'=>$data,
            'rel'=>'self'
        );
        echo json_encode($data);
    }

    function daftarJadwalSPmtByInputer(){
        $row_number_start = $this->input->get('row_number_start');
        $bln = $this->input->get('bln');
        $thn = $this->input->get('thn');
        $keyword = $this->input->get('keyword');
        $idp = $this->input->get('idp');
        $idskpd = $this->input->get('idskpd');
        $limit = $this->input->get('limit');
        $query = $this->ekinerja->list_jadwal_spmt_by_inputer($row_number_start, $bln, $thn, $keyword, $idp, $idskpd, $limit, $this->keyApps);
        $data = $query->result();
        $data = array(	'code'=>200,
            'status'=>'success',
            'title'=>'Data List Jadwal Khusus',
            'data'=>$data,
            'rel'=>'self'
        );
        echo json_encode($data);
    }

    function hapusJadwalSPmtByInputer(){
        header("Access-Control-Allow-Origin: *");
        $idjadwal_khusus_enc = $this->input->post('idjadwal_khusus_enc');
        $query = $this->ekinerja->hapus_jadwal_spmt_by_inputer($idjadwal_khusus_enc, $this->keyApps);
        if($query > 0){
            $result = $this->hapus_sukses();
        }else{
            $result=$this->hapus_gagal();
        }
        echo json_encode($result);
    }

    function insertJadwalKhususTrans(){
        $data = $this->input->post('data_jadwal');
        $query = $this->ekinerja->insert_jadwal_khusus_trans($data, $this->keyApps);
        if ($query['query'] > 0) {
            $result = $this->transaksi_sukses();
        } else {
            $result = $this->transaksi_gagal();
        }
        echo json_encode($result);
    }

    function daftarJadwalTransaksiKalender(){
        $bln = $this->input->get('bln');
        $thn = $this->input->get('thn');
        $opd = $this->input->get('opd');
        $query = $this->ekinerja->listof_jadwalTrans_Kalender_by_opd($bln, $thn, $opd);
        $data = $query->result();
        echo json_encode($data);
    }

    function daftarUnitJadwalTransaksi(){
        $id_trans_jadwal = $this->input->get('id_trans_jadwal');
        $query = $this->ekinerja->listof_unit_jadwal_transaksi($id_trans_jadwal, $this->keyApps);
        $data = $query->result();
        $data = array(	'code'=>200,
            'status'=>'success',
            'title'=>'Daftar Unit Kerja Jadwal Transaksi',
            'data'=>$data,
            'rel'=>'self'
        );
        echo json_encode($data);
    }

    function ubahJadwalTransaksi(){
        $id_trans_jadwal = $this->input->get('id_trans_jadwal');
        $query = $this->ekinerja->ubah_jadwal_transkasi($id_trans_jadwal, $this->keyApps);
        $data = $query->result();
        $data = array('code'=>200,
            'status'=>'success',
            'title'=>'Ubah Jadwal Transaksi',
            'data'=>$data,
            'rel'=>'self'
        );
        echo json_encode($data);
    }

    function updateJadwalKhususDetailTrans(){
        $data = array(
            'id_jenis_jadwal' => $this->input->post('id_jenis_jadwal'),
            'tgl_mulai' => $this->input->post('tgl_mulai'),
            'tgl_selesai' => $this->input->post('tgl_selesai'),
            'jam_mulai' => $this->input->post('jam_mulai'),
            'menit_mulai' => $this->input->post('menit_mulai'),
            'jam_selesai' => $this->input->post('jam_selesai'),
            'menit_selesai' => $this->input->post('menit_selesai'),
            'peran' => $this->input->post('peran'),
            'idLokasiSekunder' => $this->input->post('idLokasiSekunder'),
            'tipe_lokasi' => $this->input->post('tipe_lokasi'),
            'idjadwal_trans_enc' => $this->input->post('idjadwal_trans_enc')
        );
        $query = $this->ekinerja->update_jadwal_khusus_detail_trans($data, $this->keyApps);
        if ($query['query'] > 0) {
            $result = $this->transaksi_sukses();
        } else {
            $result = $this->transaksi_gagal();
        }
        echo json_encode($result);
    }

    function daftarInputerJadwalByOPD(){
        $id_skpd_enc = $this->input->get('id_skpd_enc');
        $query = $this->ekinerja->getInputerJadwalByOPD($id_skpd_enc);
        $data = $query->result();
        $data = array('code'=>200,
            'status'=>'success',
            'title'=>'Data Inputer Jadwal pada OPD tertentu',
            'data'=>$data,
            'rel'=>'self'
        );
        echo json_encode($data);
    }

    function jumlah_item_lainnya(){
        $ulevel = $this->input->get('user_level');
        $id_pegawai = $this->input->get('id_pegawai');
        $id_skpd = $this->input->get('id_skpd');
        $id_status_item = $this->input->get('id_status_item');
        $keyword = $this->input->get('keyword');
        $query = $this->ekinerja->jml_item_lainnya($ulevel, $id_pegawai, $id_skpd, $id_status_item, $keyword);
        $data = $query->result();
        $data = array(	'code'=>200,
            'status'=>'success',
            'title'=>'Jumlah List Item Lainnya Kinerja',
            'data'=>$data,
            'rel'=>'self'
        );
        echo json_encode($data);
    }

    function daftar_item_lainnya(){
        $row_number_start = $this->input->get('row_number_start');
        $ulevel = $this->input->get('user_level');
        $id_pegawai = $this->input->get('id_pegawai');
        $id_skpd = $this->input->get('id_skpd');
        $id_status_item = $this->input->get('id_status_item');
        $keyword = $this->input->get('keyword');
        $limit = $this->input->get('limit');
        $query = $this->ekinerja->listof_item_lainnya($row_number_start, $ulevel, $id_pegawai, $id_skpd, $id_status_item, $keyword, $limit, $this->keyApps);
        $data = $query->result();
        $data = array(	'code'=>200,
            'status'=>'success',
            'title'=>'Data List Item Lainnya Kinerja',
            'data'=>$data,
            'rel'=>'self'
        );
        echo json_encode($data);
    }

    public function refJenisItemLainnya(){
        $query = $this->ekinerja->ref_jenis_item_lainnya();
        $data = $query->result();
        $data = array(	'code'=>200,
            'status'=>'success',
            'title'=>'Data List Jenis Item Lainnya',
            'data'=>$data,
            'rel'=>'self'
        );
        echo json_encode($data);
    }

    function hapusUnitKerjaJadwalById(){
        header("Access-Control-Allow-Origin: *");
        $id_ukjdwl_enc = $this->input->post('id_ukjdwl_enc');
        $query = $this->ekinerja->hapus_unit_kerja_jadwal($id_ukjdwl_enc, $this->keyApps);
        if($query > 0){
            $result = $this->hapus_sukses();
        }else{
            $result=$this->hapus_gagal();
        }
        echo json_encode($result);
    }

    public function refStatusItemLainnya(){
        $query = $this->ekinerja->ref_status_item_lainnya();
        $data = $query->result();
        $data = array(	'code'=>200,
            'status'=>'success',
            'title'=>'Data List Status Item Lainnya',
            'data'=>$data,
            'rel'=>'self'
        );
        echo json_encode($data);
    }

    public function insertItemLainnya(){
        $data = array(
            'ddItemLainnya' => $this->input->post('ddItemLainnya'),
            'tglMulaiBerlaku' => $this->input->post('tglMulaiBerlaku'),
            'tglSelesaiBerlaku' => $this->input->post('tglSelesaiBerlaku'),
            'txtNoSk' => $this->input->post('txtNoSk'),
            'txtKeterangan' => $this->input->post('txtKeterangan'),
            'id_pegawai' => $this->input->post('id_pegawai'),
            'id_unit_kerja' => $this->input->post('id_unit_kerja'),
            'inputer' => $this->input->post('inputer')
        );
        $query = $this->ekinerja->insert_item_lainnya($data, $this->keyApps);
        if ($query['query'] > 0) {
            $result = $this->transaksi_sukses($query['id_item_lainnya']);
        } else {
            $result = $this->transaksi_gagal();
        }
        echo json_encode($result);
    }

    public function update_url_berkas_sk_item_lainnya(){
        $uploadfile = $this->input->get('uploadfile');
        $nf_baru = $this->input->get('nf_baru');
        $iditem_lainnya = $this->input->get('iditem_lainnya');
        $status = $this->input->get('status');
        if($status==1){
            $query = $this->ekinerja->update_url_berkas_sk_item_lainnya($nf_baru, $iditem_lainnya, $this->keyApps);
            if ($query['query'] == 1) {
                /*if(file_exists($_SERVER['DOCUMENT_ROOT']."/ekinerja2/berkas/".$nf_baru)){
                    unlink($_SERVER['DOCUMENT_ROOT']."/ekinerja2/berkas/".$nf_baru);
                }
                rename($_SERVER['DOCUMENT_ROOT'].'/ekinerja2/'.$uploadfile, $_SERVER['DOCUMENT_ROOT']."/ekinerja2/berkas/".$nf_baru);*/
                $uploaddir = '/var/www/html/ekinerja2/berkas/';
                $connection = ssh2_connect('103.14.229.15');
                ssh2_auth_password($connection, 'rommonz', 'mony3Tmony3T');
                $sftp = ssh2_sftp($connection);
                if (file_exists('ssh2.sftp://' . $sftp . '/var/www/html/ekinerja2/berkas/'.$nf_baru)) {
                    ssh2_sftp_unlink($sftp, '/var/www/html/ekinerja2/berkas/'.$nf_baru);
                }
                ssh2_sftp_rename($sftp, $uploadfile,$uploaddir.$nf_baru);
                $result = $this->transaksi_sukses();
            } else {
                $result = $this->transaksi_gagal();
            }
            echo json_encode($result);
        }
    }

    public function ubah_item_lainnya(){
        $iditem_lainnya_enc = $this->input->get('iditem_lainnya_enc');
        $query = $this->ekinerja->ubahItemLainnya($iditem_lainnya_enc, $this->keyApps);
        $data = $query->result();
        $data = array('code'=>200,
            'status'=>'success',
            'title'=>'Ubah Item Lainnya',
            'data'=>$data,
            'rel'=>'self'
        );
        echo json_encode($data);
    }

    public function updateItemLainnya(){
        $data = array(
            'ddItemLainnya' => $this->input->post('ddItemLainnya'),
            'tglMulaiBerlaku' => $this->input->post('tglMulaiBerlaku'),
            'tglSelesaiBerlaku' => $this->input->post('tglSelesaiBerlaku'),
            'txtNoSk' => $this->input->post('txtNoSk'),
            'txtKeterangan' => $this->input->post('txtKeterangan'),
            'id_pegawai' => $this->input->post('id_pegawai'),
            'id_unit_kerja' => $this->input->post('id_unit_kerja'),
            'id_item_lainnya_enc' => $this->input->post('id_item_lainnya_enc')
        );
        $query = $this->ekinerja->update_item_lainnya($data, $this->keyApps);
        if ($query['query'] > 0) {
            $result = $this->transaksi_sukses();
        } else {
            $result = $this->transaksi_gagal();
        }
        echo json_encode($result);
    }

    public function hapusItemLainnya(){
        header("Access-Control-Allow-Origin: *");
        $id_item_lainnya_enc = $this->input->post('id_item_lainnya_enc');
        $query = $this->ekinerja->hapus_kinerja_item_lainnya($id_item_lainnya_enc, $this->keyApps);
        if($query > 0){
            $result = $this->hapus_sukses();
        }else{
            $result=$this->hapus_gagal();
        }
        echo json_encode($result);
    }

    public function riwayatSKPByIdPegawai(){
        $id_pegawai_enc = $this->input->get('id_pegawai_enc');
        $query = $this->ekinerja->riwayat_skp_by_idpegawai($id_pegawai_enc, $this->keyApps);
        $data = $query->result();
        $data = array(	'code'=>200,
            'status'=>'success',
            'title'=>'Data List Riwayat SKP Pegawai',
            'data'=>$data,
            'rel'=>'self'
        );
        echo json_encode($data);
    }

    public function skpHeaderById(){
        $id_skp_enc = $this->input->get('id_skp_enc');
        $query = $this->ekinerja->skp_header_byid($id_skp_enc, $this->keyApps);
        $data = $query->result();
        $data = array(	'code'=>200,
            'status'=>'success',
            'title'=>'Data SKP Pegawai',
            'data'=>$data,
            'rel'=>'self'
        );
        echo json_encode($data);
    }

    public function skpTargetById(){
        $id_skp_enc = $this->input->get('id_skp_enc');
        $query = $this->ekinerja->skp_target_byid($id_skp_enc, $this->keyApps);
        $data = $query->result();
        $data = array(	'code'=>200,
            'status'=>'success',
            'title'=>'Data Target SKP Pegawai',
            'data'=>$data,
            'rel'=>'self'
        );
        echo json_encode($data);
    }

    public function skpTambahanById(){
        $id_skp_enc = $this->input->get('id_skp_enc');
        $query = $this->ekinerja->skp_tambahan_byid($id_skp_enc, $this->keyApps);
        $data = $query->result();
        $data = array(	'code'=>200,
            'status'=>'success',
            'title'=>'Data Tambahan SKP Pegawai',
            'data'=>$data,
            'rel'=>'self'
        );
        echo json_encode($data);
    }

    public function getHistStafEkinerja(){
        $id_pegawai_enc = $this->input->get('id_pegawai_enc');
        $query = $this->ekinerja->get_hist_staf_ekinerja($id_pegawai_enc);
        $data = $query->result();
        $data = array(	'code'=>200,
            'status'=>'success',
            'title'=>'Daftar Riwayat Staf eKinerja',
            'data'=>$data,
            'rel'=>'self'
        );
        echo json_encode($data);
    }

    public function getJmlListPegawaiInfoKinerja(){
        $id_skpd = $this->input->get('id_skpd_enc');
        $last_periode = $this->input->get('last_periode');
        $keyword = $this->input->get('keyword');
        $query = $this->ekinerja->jumlah_pegawai_info_kinerja($id_skpd, $last_periode, $keyword);
        $data = $query->result();
        $data = array(	'code'=>200,
            'status'=>'success',
            'title'=>'Jumlah List Pegawai dan Info Laporan Kinerja',
            'data'=>$data,
            'rel'=>'self'
        );
        echo json_encode($data);
    }

    public function getListPegawaiInfoKinerja(){
        $row_number_start = $this->input->get('row_number_start');
        $id_skpd = $this->input->get('id_skpd_enc');
        $last_periode = $this->input->get('last_periode');
        $keyword = $this->input->get('keyword');
        $limit = $this->input->get('limit');
        $query = $this->ekinerja->list_pegawai_info_kinerja($row_number_start, $id_skpd, $last_periode, $keyword, $limit);
        $data = $query->result();
        $data = array(	'code'=>200,
            'status'=>'success',
            'title'=>'Daftar List Pegawai dan Info Laporan Kinerja',
            'data'=>$data,
            'rel'=>'self'
        );
        echo json_encode($data);
    }

    function daftar_item_lainnya_by_idp(){
        $id_pegawai_enc = $this->input->get('id_pegawai_enc');
        $bln = $this->input->get('bln');
        $thn = $this->input->get('thn');
        $query = $this->ekinerja->list_item_kinerja_lainnya_by_idpegawai($id_pegawai_enc, $bln, $thn);
        $data = $query->result();
        $data = array(	'code'=>200,
            'status'=>'success',
            'title'=>'Data List Unsur Kinerja Lainnya',
            'data'=>$data,
            'rel'=>'self'
        );
        echo json_encode($data);
    }

    function jumlah_laporan_kinerja_per_opd(){
        $id_skpd_enc = $this->input->get('id_skpd_enc');
        $id_sts_laporan = $this->input->get('id_sts_laporan');
        $jenjab = $this->input->get('jenjab');
        $eselon = $this->input->get('eselon');
        $bln = $this->input->get('bln');
        $thn = $this->input->get('thn');
        $keyword = $this->input->get('keyword');
        $query = $this->ekinerja->jumlah_laporan_kinerja_by_opd($id_skpd_enc, $id_sts_laporan, $jenjab, $eselon, $bln, $thn, $keyword);
        $data = $query->result();
        $data = array(	'code'=>200,
            'status'=>'success',
            'title'=>'Jumlah List Laporan Kinerja berds. OPD tertentu',
            'data'=>$data,
            'rel'=>'self'
        );
        echo json_encode($data);
    }

    function daftar_laporan_kinerja_per_opd(){
        $row_number_start = $this->input->get('row_number_start');
        $id_skpd_enc = $this->input->get('id_skpd_enc');
        $id_sts_laporan = $this->input->get('id_sts_laporan');
        $jenjab = $this->input->get('jenjab');
        $eselon = $this->input->get('eselon');
        $bln = $this->input->get('bln');
        $thn = $this->input->get('thn');
        $keyword = $this->input->get('keyword');
        $limit = $this->input->get('limit');
        $query = $this->ekinerja->list_laporan_kinerja_by_opd($row_number_start, $id_skpd_enc, $id_sts_laporan, $jenjab, $eselon, $bln, $thn, $keyword, $limit, $this->keyApps);
        $data = $query->result();
        $data = array(	'code'=>200,
            'status'=>'success',
            'title'=>'Data List Laporan Kinerja berds. OPD tertentu',
            'data'=>$data,
            'rel'=>'self'
        );
        echo json_encode($data);
    }

    function cetak_laporan_kinerja_by_opd(){
        $id_skpd_enc = $this->input->get('id_skpd_enc');
        $bln = $this->input->get('bln');
        $thn = $this->input->get('thn');
        $query = $this->ekinerja->cetak_laporan_kinerja_by_opd($id_skpd_enc, $bln, $thn, $this->keyApps);
        $data = $query->result();
        $data = array(	'code'=>200,
            'status'=>'success',
            'title'=>'Cetak Laporan Kinerja berds. OPD tertentu',
            'data'=>$data,
            'rel'=>'self'
        );
        echo json_encode($data);
    }

    function insertLogAbsenByIdpegawaiWkt(){
        $id_pegawai = $this->input->post('id_pegawai');
        $wkt = $this->input->post('wkt');
        $ket = $this->input->post('ket');
        $eksisting = $this->ekinerja->cek_eksisting_logabsen_byidpegawai_wkt($id_pegawai, $wkt);
        if($eksisting == 0){
            $query = $this->ekinerja->insert_logabsen_byidpegawai_wkt($id_pegawai, $wkt, $ket);
            if ($query['query'] > 0) {
                $result = $this->transaksi_sukses();
            } else {
                $result = $this->transaksi_gagal();
            }
        }else{
            $result = $this->data_exist();
        }
        echo json_encode($result);
    }

    public function hapusLogAbsenByIdpegawaiWkt(){
        header("Access-Control-Allow-Origin: *");
        $id_pegawai = $this->input->post('id_pegawai');
        $wkt = $this->input->post('wkt');
        $query = $this->ekinerja->hapus_logabsen_byidpegawai_wkt($id_pegawai, $wkt);
        if($query > 0){
            $result = $this->hapus_sukses();
        }else{
            $result=$this->hapus_gagal();
        }
        echo json_encode($result);
    }

    public function pencapaian_kinerja_current(){
        $id_pegawai = $this->input->get('id_pegawai');
        $query = $this->ekinerja->pencapaianKinerjaCurrent($id_pegawai, $this->keyApps);
        $data = $query->result();
        $data = array(	'code'=>200,
            'status'=>'success',
            'title'=>'Data Pencapaian Kinerja terakhir',
            'data'=>$data,
            'rel'=>'self'
        );
        echo json_encode($data);
    }

    public function status_aktifitas_current(){
        $id_pegawai = $this->input->get('id_pegawai');
        $query = $this->ekinerja->statusAktifitasCurrent($id_pegawai);
        $data = $query->result();
        $data = array(	'code'=>200,
            'status'=>'success',
            'title'=>'Data Status Aktifitas Kinerja terakhir',
            'data'=>$data,
            'rel'=>'self'
        );
        echo json_encode($data);
    }

    public function status_aktifitas_staf(){
        $id_pegawai_enc = $this->input->get('id_pegawai_enc');
        $id_skpd_enc = $this->input->get('id_skpd_enc');
        $query = $this->ekinerja->statusAktifitasStaf($id_pegawai_enc, $id_skpd_enc, $this->keyApps);
        $data = $query->result();
        $data = array(	'code'=>200,
            'status'=>'success',
            'title'=>'Data Status Aktifitas Kinerja terakhir Stafnya',
            'data'=>$data,
            'rel'=>'self'
        );
        echo json_encode($data);
    }

    function jumlah_laporan_kinerja_pegawai(){
        $id_skpd_enc = $this->input->get('id_skpd_enc');
        $bln = $this->input->get('bln');
        $thn = $this->input->get('thn');
        $idp_enc = $this->input->get('idp_enc');
        $query = $this->ekinerja->jumlah_laporan_kinerja_by_pegawai($id_skpd_enc, $bln, $thn, $idp_enc);
        $data = $query->result();
        $data = array(	'code'=>200,
            'status'=>'success',
            'title'=>'Jumlah List Laporan Kinerja Pegawai',
            'data'=>$data,
            'rel'=>'self'
        );
        echo json_encode($data);
    }

    function daftar_laporan_kinerja_pegawai(){
        $row_number_start = $this->input->get('row_number_start');
        $id_skpd_enc = $this->input->get('id_skpd_enc');
        $bln = $this->input->get('bln');
        $thn = $this->input->get('thn');
        $idp_enc = $this->input->get('idp_enc');
        $limit = $this->input->get('limit');
        $query = $this->ekinerja->list_laporan_kinerja_by_pegawai($row_number_start, $id_skpd_enc, $bln, $thn, $idp_enc, $limit, $this->keyApps);
        $data = $query->result();
        $data = array(	'code'=>200,
            'status'=>'success',
            'title'=>'Data List Laporan Kinerja Pegawai',
            'data'=>$data,
            'rel'=>'self'
        );
        echo json_encode($data);
    }

    function statKinerjaBulanan(){
        $id_pegawai_enc = $this->input->get('id_pegawai_enc');
        $thn = $this->input->get('thn');
        $query = $this->ekinerja->statistik_kinerja_bulanan($id_pegawai_enc, $thn);
        $data = $query->result();
        $data = array(	'code'=>200,
            'status'=>'success',
            'title'=>'Statistik Kinerja Bulanan',
            'data'=>$data,
            'rel'=>'self'
        );
        echo json_encode($data);
    }

    function statAbsensiBulanan(){
        $id_pegawai_enc = $this->input->get('id_pegawai_enc');
        $thn = $this->input->get('thn');
        $query = $this->ekinerja->statistik_absensi_bulanan($id_pegawai_enc, $thn);
        $data = $query->result();
        $data = array(	'code'=>200,
            'status'=>'success',
            'title'=>'Statistik Absensi Bulanan',
            'data'=>$data,
            'rel'=>'self'
        );
        echo json_encode($data);
    }

    function statPersenKinerjaAbsensiBulanan(){
        $id_pegawai_enc = $this->input->get('id_pegawai_enc');
        $thn = $this->input->get('thn');
        $query = $this->ekinerja->statistik_persen_kinerja_absensi_bulanan($id_pegawai_enc, $thn);
        $data = $query->result();
        $data = array(	'code'=>200,
            'status'=>'success',
            'title'=>'Statistik Persentase Kinerja dan Absensi Bulanan',
            'data'=>$data,
            'rel'=>'self'
        );
        echo json_encode($data);
    }

    function statKinerjaHarian(){
        $id_pegawai_enc = $this->input->get('id_pegawai_enc');
        $bln = $this->input->get('bln');
        $thn = $this->input->get('thn');
        $query = $this->ekinerja->statistik_kinerja_harian($id_pegawai_enc, $bln, $thn);
        $data = $query->result();
        $data = array(	'code'=>200,
            'status'=>'success',
            'title'=>'Statistik Kinerja Harian',
            'data'=>$data,
            'rel'=>'self'
        );
        echo json_encode($data);
    }

    function statAbsensiHarian(){
        $id_pegawai_enc = $this->input->get('id_pegawai_enc');
        $bln = $this->input->get('bln');
        $thn = $this->input->get('thn');
        $query = $this->ekinerja->statistik_absensi_harian($id_pegawai_enc, $bln, $thn);
        $data = $query->result();
        $data = array(	'code'=>200,
            'status'=>'success',
            'title'=>'Statistik Absensi Harian',
            'data'=>$data,
            'rel'=>'self'
        );
        echo json_encode($data);
    }

    function drhBiodata(){
        $id_pegawai_enc = $this->input->get('id_pegawai_enc');
        $query = $this->ekinerja->drh_biodata($id_pegawai_enc);
        $data = $query->result();
        $data = array(	'code'=>200,
            'status'=>'success',
            'title'=>'DRH Biodata',
            'data'=>$data,
            'rel'=>'self'
        );
        echo json_encode($data);
    }

    function drhPendidikan(){
        $id_pegawai_enc = $this->input->get('id_pegawai_enc');
        $query = $this->ekinerja->drh_pendidikan($id_pegawai_enc);
        $data = $query->result();
        $data = array(	'code'=>200,
            'status'=>'success',
            'title'=>'DRH Pendidikan',
            'data'=>$data,
            'rel'=>'self'
        );
        echo json_encode($data);
    }

    function drhDiklat(){
        $id_pegawai_enc = $this->input->get('id_pegawai_enc');
        $query = $this->ekinerja->drh_diklat($id_pegawai_enc);
        $data = $query->result();
        $data = array(	'code'=>200,
            'status'=>'success',
            'title'=>'DRH Diklat',
            'data'=>$data,
            'rel'=>'self'
        );
        echo json_encode($data);
    }

    function drhGolongan(){
        $id_pegawai_enc = $this->input->get('id_pegawai_enc');
        $query = $this->ekinerja->drh_golongan($id_pegawai_enc);
        $data = $query->result();
        $data = array(	'code'=>200,
            'status'=>'success',
            'title'=>'DRH Golongan',
            'data'=>$data,
            'rel'=>'self'
        );
        echo json_encode($data);
    }

    function drhJabatan(){
        $id_pegawai_enc = $this->input->get('id_pegawai_enc');
        $query = $this->ekinerja->drh_jabatan($id_pegawai_enc);
        $data = $query->result();
        $data = array(	'code'=>200,
            'status'=>'success',
            'title'=>'DRH Jabatan',
            'data'=>$data,
            'rel'=>'self'
        );
        echo json_encode($data);
    }

    function drhKeluargaIstriSuami(){
        $id_pegawai_enc = $this->input->get('id_pegawai_enc');
        $query = $this->ekinerja->drh_keluarga_istri_suami($id_pegawai_enc);
        $data = $query->result();
        $data = array(	'code'=>200,
            'status'=>'success',
            'title'=>'DRH Keluarga - Istri/Suami',
            'data'=>$data,
            'rel'=>'self'
        );
        echo json_encode($data);
    }

    function drhKeluargaAnak(){
        $id_pegawai_enc = $this->input->get('id_pegawai_enc');
        $query = $this->ekinerja->drh_keluarga_anak($id_pegawai_enc);
        $data = $query->result();
        $data = array(	'code'=>200,
            'status'=>'success',
            'title'=>'DRH Keluarga - Anak',
            'data'=>$data,
            'rel'=>'self'
        );
        echo json_encode($data);
    }

    function drhAlihTugas(){
        $id_pegawai_enc = $this->input->get('id_pegawai_enc');
        $query = $this->ekinerja->drh_alih_tugas($id_pegawai_enc);
        $data = $query->result();
        $data = array(	'code'=>200,
            'status'=>'success',
            'title'=>'DRH Alih Tugas',
            'data'=>$data,
            'rel'=>'self'
        );
        echo json_encode($data);
    }

    function get_jml_aktifitas_byid_paged(){
        $tgl = $this->input->get('tgl');
        $status = $this->input->get('status');
        $target = $this->input->get('target');
        $keyword = $this->input->get('keyword');
        $id_knj_master = $this->input->get('id_knj_master');
        $query = $this->ekinerja->jumlah_aktifitas_by_id_paged($tgl, $status, $target, $keyword, $id_knj_master, $this->keyApps);
        $data = $query->result();
        $data = array(	'code'=>200,
            'status'=>'success',
            'title'=>'Jumlah Aktifitas Kegiatan Pegawai By Id ter-paging',
            'data'=>$data,
            'rel'=>'self'
        );
        echo json_encode($data);
    }

    function list_aktifitas_kegiatan_by_id_paged(){
        $row_number_start = $this->input->get('row_number_start');
        $tgl = $this->input->get('tgl');
        $status = $this->input->get('status');
        $target = $this->input->get('target');
        $keyword = $this->input->get('keyword');
        $id_knj_master = $this->input->get('id_knj_master');
        $limit = $this->input->get('limit');
        $query = $this->ekinerja->list_aktifitas_kegiatan_by_id_paged($row_number_start, $tgl, $status, $target, $keyword, $id_knj_master, $limit, $this->keyApps);
        $data = $query->result();
        $data = array(	'code'=>200,
            'status'=>'success',
            'title'=>'Daftar Aktifitas By Id ter-paging',
            'data'=>$data,
            'rel'=>'self'
        );
        echo json_encode($data);
    }

    public function getHistStafPlh(){
        $id_pegawai_enc = $this->input->get('id_pegawai_enc');
        $query = $this->ekinerja->get_hist_staf_plh($id_pegawai_enc);
        $data = $query->result();
        $data = array(	'code'=>200,
            'status'=>'success',
            'title'=>'Daftar Riwayat Staf PLH',
            'data'=>$data,
            'rel'=>'self'
        );
        echo json_encode($data);
    }

    public function daftar_kinerja_master_staf_plh(){
        $id_pegawai = $this->input->get('id_pegawai');
        $idp_atsl_plh = $this->input->get('idp_atsl_plh');
        $query = $this->ekinerja->listof_kinerja_master_staf_plh($id_pegawai, $idp_atsl_plh, $this->keyApps);
        $data = $query->result();
        $data = array(	'code'=>200,
            'status'=>'success',
            'title'=>'Data List Kinerja Master Staf PLH',
            'data'=>$data,
            'rel'=>'self'
        );
        echo json_encode($data);
    }

    public function jumlah_peninjauan_kegiatan_staf_plh(){
        $idstatus = $this->input->get('idstatus');
        $keyword = $this->input->get('keyword');
        $id_knj_master = $this->input->get('id_knj_master');
        $id_pegawai_atsl_enc = $this->input->get('id_pegawai_atasan_enc');
        $query = $this->ekinerja->jumlah_peninjauan_kegiatan_staf_plh($idstatus, $keyword, $id_knj_master, $id_pegawai_atsl_enc, $this->keyApps);
        $data = $query->result();
        $data = array(	'code'=>200,
            'status'=>'success',
            'title'=>'Jumlah List Kegiatan Staf PLH',
            'data'=>$data,
            'rel'=>'self'
        );
        echo json_encode($data);
    }

    public function daftar_peninjauan_kegiatan_staf_plh(){
        $row_number_start = $this->input->get('row_number_start');
        $idstatus = $this->input->get('idstatus');
        $keyword = $this->input->get('keyword');
        $id_knj_master = $this->input->get('id_knj_master');
        $id_pegawai_atsl_enc = $this->input->get('id_pegawai_atasan_enc');
        $limit = $this->input->get('limit');

        $query = $this->ekinerja->list_peninjauan_kegiatan_staf_plh($row_number_start, $idstatus, $keyword, $id_knj_master, $id_pegawai_atsl_enc, $limit, $this->keyApps);
        $data = $query->result();
        $data = array(	'code'=>200,
            'status'=>'success',
            'title'=>'Data List Kegiatan Staf PLH',
            'data'=>$data,
            'rel'=>'self'
        );
        echo json_encode($data);
    }

    public function hist_alih_tugas_by_id(){
        $id_knj_master = $this->input->get('id_knj_master');
        $idknj_hist_alih_tugas = $this->input->get('idknj_hist_alih_tugas');
        $query = $this->ekinerja->kinerjaHistAlihTugasById($id_knj_master, $idknj_hist_alih_tugas, $this->keyApps);
        $data = $query->result();
        $data = array(	'code'=>200,
            'status'=>'success',
            'title'=>'Data Historis Alih Tugas Kinerja Berds. ID tertentu',
            'data'=>$data,
            'rel'=>'self'
        );
        echo json_encode($data);
    }

    function transaksi_sukses($id=null, $id2=null, $msg=null){
        $data = array('code'=>200,
            'status'=>'success',
            'title'=>'Data sukses tersimpan',
            'id'=>$id,
            'id2'=>$id2,
            'msg'=>$msg,
            'rel'=>'self'
        );
        return $data;
    }

    function transaksi_gagal($ket=null){
        $data = array('code'=>201,
            'status'=>'not success',
            'title'=>'Data tidak sukses tersimpan'.$ket,
            'rel'=>'self'
        );
        return $data;
    }

    function transaksi_gagal_not_exist_hist_alihtugas($ket=null){
        $data = array('code'=>201,
            'status'=>'not success',
            'title'=>'Data tidak sukses tersimpan karena tidak ada Riwayat Alih Tugas pada Laporan Ekinerja. Hapus laporan periode tersebut dan ulangi pengisian Laporan Kinerja'.$ket,
            'rel'=>'self'
        );
        return $data;
    }

    function waktu_aktivitas_not_valid($batasAkhirEntri){
        $data = array('code'=>203,
            'status'=>'not success',
            'title'=>'Waktu aktifitas sudah lebih dari '.$batasAkhirEntri.' hari',
            'rel'=>'self'
        );
        return $data;
    }

    function hapusJadwalTrans(){
        header("Access-Control-Allow-Origin: *");
        $idjadwal_trans_enc = $this->input->post('idjadwal_trans_enc');
        $query = $this->ekinerja->hapus_jadwal_trans($idjadwal_trans_enc, $this->keyApps);
        if($query['query'] > 0){
            $result = $this->hapus_sukses();
        }else{
            $result = $this->hapus_gagal();
        }
        echo json_encode($result);
    }

    function status_belum_absensi($status){
        $data = array('code'=>205,
            'status'=>'not success',
            'title'=>'Tidak ada catatan waktu absensi pada tanggal tersebut <br>karena '.$status,
            'rel'=>'self'
        );
        return $data;
    }

    function jam_kegiatan_belum_valid($jam_absen){
        $data = array('code'=>206,
            'status'=>'not success',
            'title'=>'Waktu kegiatan harus di atas waktu absensi '.$jam_absen,
            'rel'=>'self'
        );
        return $data;
    }

    function jam_kegiatan_blm_diatas_keg_terakhir($wkt_kegiatan){
        $data = array('code'=>206,
            'status'=>'not success',
            'title'=>'Kegiatan terakhir selesai pada waktu '.$wkt_kegiatan,
            'rel'=>'self'
        );
        return $data;
    }

    function data_exist(){
        $data = array('code'=>202,
            'status'=>'not success',
            'title'=>'Data sudah ada',
            'rel'=>'self'
        );
        return $data;
    }

    function hapus_sukses($ket=null){
        $data = array('code'=>200,
            'status'=>'success',
            'title'=>"Data sukses terhapus".$ket,
            'rel'=>'self'
        );
        return $data;
    }

    function hapus_gagal($ket=null){
        $data = array('code'=>201,
            'status'=>'not success',
            'title'=>'Data tidak sukses terhapus '.$ket,
            'rel'=>'self'
        );
        return $data;
    }

    function kalkulasi_sukses(){
        $data = array('code'=>200,
            'status'=>'success',
            'title'=>'Selamat kalkulasi nilai tunjangan sukses',
            'rel'=>'self'
        );
        return $data;
    }

    function kalkulasi_gagal(){
        $data = array('code'=>201,
            'status'=>'not success',
            'title'=>'Maaf kalkulasi nilai tunjangan gagal',
            'rel'=>'self'
        );
        return $data;
    }

    function periode_aktivitas_not_valid($bln_periode_kegiatan, $thn_periode_kegiatan){
        $data = array('code'=>201,
            'status'=>'not success',
            'title'=>'Input aktifitas kegiatan untuk periode '.$this->umum->monthName($bln_periode_kegiatan).' '.$thn_periode_kegiatan.' sudah tidak bisa dilakukan',
            'rel'=>'self'
        );
        return $data;
    }

}

?>
