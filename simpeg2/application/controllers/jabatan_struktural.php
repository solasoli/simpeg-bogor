<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Jabatan_struktural extends CI_Controller {

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     * 		http://example.com/index.php/welcome
     *	- or -
     * 		http://example.com/index.php/welcome/index
     *	- or -
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see http://codeigniter.com/user_guide/general/urls.html
     */


    public function __construct(){

        parent::__construct();
    }

    public function index(){
        $rekap='';
        $jabatan_kosong = '';

        $this->load->model('jabatan_model');
        $jabatan_kosong = $this->jabatan_model->get_jabatan_struktural_kosong();
        $rekap = $this->jabatan_model->rekap_jabatan_struktural();
        //$rekap = $this->hukuman_model->recap_tingkat_hukuman_per_tahun();

        $this->load->view('layout/header', array( 'title' => 'Jabatan Struktural'));
        //$this->load->view('jabatan_struktural/header');
        $this->load->view('jabatan_struktural/index',
            array(
                'rekap' => $rekap,
                'jabatan_kosong' => $jabatan_kosong
            ));
        $this->load->view('layout/footer');
    }

    private function load_header_draft_pelantikan($id_draft){
        $this->load->model('draft_pelantikan_model');
        $jab_kosong = $this->draft_pelantikan_model->get_kosong($id_draft);
        $jab_kosong_plt = $this->draft_pelantikan_model->get_kosong_plt($id_draft);
		$jab_lima = $this->draft_pelantikan_model->get_lima($id_draft);
        $jab_kosong_baru = $this->draft_pelantikan_model->get_jabatan_kosong_baru($id_draft);
        $draft_pelantikan = $this->draft_pelantikan_model->get_draft_by_id($id_draft);
        $lepas_jabatan = $this->draft_pelantikan_model->get_lepas_jabatan($id_draft);

        $this->load->view('jabatan_struktural/header');
        $this->load->view('jabatan_struktural/header_draft_pelantikan', array(
            'jab_kosong' => $jab_kosong,
            'jab_kosong_plt' => $jab_kosong_plt,
            'draft_pelantikan' => $draft_pelantikan,
            'lepas_jabatan' => $lepas_jabatan,
            'jab_kosong_baru' => $jab_kosong_baru,
			'jab_lima' => $jab_lima
        ));
    }

    public function riwayat_jabatan_html_list(){
        $id_pegawai = $this->input->post('id_pegawai');

        $this->load->model('riwayat_jabatan_model');
        $riwayat_jabatan = $this->riwayat_jabatan_model->get_by_id_pegawai($id_pegawai);

        $this->load->view('jabatan_struktural/riwayat_jabatan_li', array(
            'riwayat_jabatan' => $riwayat_jabatan,
        ));
    }

    public function riwayat_hukuman_list(){
        $id_pegawai = $this->input->post('id_pegawai');

        $this->load->model('hukuman_model');
        $riwayat_hukuman = $this->hukuman_model->get_by_id_riwayat_hukuman($id_pegawai);

        $this->load->view('jabatan_struktural/riwayat_hukuman', array(
            'riwayat_hukuman' => $riwayat_hukuman,
        ));
    }

    public function riwayat_kompetensi_list(){
        $id_pegawai = $this->input->post('id_pegawai');

        $this->load->model('draft_pelantikan_model');
        $riwayat_kompetensi = $this->draft_pelantikan_model->get_by_id_kompetensi($id_pegawai);

        $this->load->view('jabatan_struktural/riwayat_kompetensi', array(
            'riwayat_kompetensi' => $riwayat_kompetensi,
        ));
    }

    private function draft_pelantikan_with_id($id_draft){
        $this->load->model('draft_pelantikan_model');
        $jabatan = $this->draft_pelantikan_model->get_by_id($id_draft);

        $this->load_header_draft_pelantikan($id_draft);

        $this->load->view('jabatan_struktural/draft_pelantikan_worksheet',
            array(
                'jabatan' => $jabatan
            ));
        $this->load->view('jabatan_struktural/footer_draft_pelantikan');
    }

    public function draft_pelantikan_partial(){
        $draft_pelantikan = '';

        $this->load->model('draft_pelantikan_model');
        $draft_pelantikan = $this->draft_pelantikan_model->get_all();

        $this->load->view('jabatan_struktural/header');
        $this->load->view('jabatan_struktural/draft_pelantikan',
            array(
                'draft_pelantikan' => $draft_pelantikan
            ));
    }

    function login_draft()
    {	$idd=$this->input->post('idd');
        $pass=$this->input->post('kunci');
        $this->load->model('draft_pelantikan_model');
        $passwordya = $this->draft_pelantikan_model->get_pass($idd)->password;
        $this->load->view('layout/header', array( 'title' => 'Jabatan Struktural'));
        if($pass==$passwordya){
            $this->session->set_userdata('iddraftpwd', $idd.$passwordya);
            $this->draft_pelantikan_with_id($idd);
        }else
        {
            $this->load->view('jabatan_struktural/login_draft',array('idd' => $idd,'pwdsalah'=>'Password Salah'));
        }
        $this->load->view('layout/footer');

    }

    function logout($idd){
        $this->session->unset_userdata('iddraftpwd');
        redirect('jabatan_struktural/draft_pelantikan/');
    }

    public function draft_pelantikan($id_draft=0){
        $this->load->view('layout/header', array( 'title' => 'Jabatan Struktural'));
        if($id_draft){
            $this->load->model('draft_pelantikan_model');
            $iddraftpwd = $this->session->userdata('iddraftpwd');
            $passwordya = $this->draft_pelantikan_model->get_pass($id_draft)->password;
            if($iddraftpwd==$id_draft.$passwordya){
                $this->draft_pelantikan_with_id($id_draft);
            }else{
                $data =array('idd'=> $id_draft, 'pwdsalah'=>'');
                $this->load->view('jabatan_struktural/login_draft', $data);
            }
        }else {
            $this->draft_pelantikan_partial();
        }
        $this->load->view('layout/footer');
    }

    public function draft_pelantikan_baru(){
        if($this->input->post()){
            $this->load->model('draft_pelantikan_model');
            $new_id = $this->draft_pelantikan_model->save(
                $this->input->post('tglpelantikan'),
                $this->input->post('nama_draft'),
                $this->input->post('pass'),
                $this->session->userdata('user')->id_pegawai);

            redirect("/jabatan_struktural/draft_pelantikan/".$new_id);
        }

        $this->load->view('layout/header', array( 'title' => 'Jabatan Struktural'));
        $this->draft_pelantikan_partial();
        $this->load->view('jabatan_struktural/create_draft_pelantikan',
            array(

            ));
        $this->load->view('layout/footer');
    }

    public function json_find_in_draft(){
        $this->load->model('draft_pelantikan_model');
        $pegawai = $this->draft_pelantikan_model->get_by_nama($this->input->get('q'), $this->input->get('id_draft'), $this->input->get('type'));
        if($pegawai==''){
            $data[] = array(
                'label' => 'Pegawai ini sudah pensiun',
                'value' => '',
                'nip' => '',
                'gol' => '',
                'uker' => '',
                'tmt' => '',
                'jabatan' => '',
                'id_j' => '',
                'eselon' => '',
                'pengalaman_eselon' => '',
                'tmt_jabatan' => '',
                'pendidikan' => '',
            );
        }else{
            foreach($pegawai as $p) {
                $pengalaman_eselon_cur = $this->draft_pelantikan_model->pengalaman_eselon_pegawai($p->id_pegawai, $p->eselon);
                $data[] = array(
                    'label' => $p->nama_gelar,
                    'value' => $p->id_pegawai,
                    'nip' => $p->nip_baru,
                    'gol' => $p->pangkat_gol,
                    'uker' => $p->nama_baru,
                    'tmt' => $p->tmt,
                    'jabatan' => $p->jabatan,
                    'id_j' => $p->id_j,
                    'eselon' => $p->eselon,
                    'pengalaman_eselon' => $pengalaman_eselon_cur->pengalaman_eselon,
                    'tmt_jabatan' => $p->tmt_jabatan,
                    'pendidikan' => $p->tingkat_pendidikan . " " . $p->jurusan_pendidikan . " - " . $p->lembaga_pendidikan . " (" . $p->tahun_lulus . ")",
                    'alamat' => $p->alamat.' '.$p->kota
                );
            }
        }
        echo json_encode($data);
    }

    public function ganti_isi_draft(){
        $data = array(
            'id_draft' => $this->input->post('id_draft'),
            'id_pegawai_sebelumnya' => $this->input->post('id_pegawai_sebelumnya'),
            'id_pegawai_baru' => $this->input->post('id_pegawai_baru'),
            'id_j_dituju' => $this->input->post('id_j_dituju'),
            'id_j_ditinggal' => $this->input->post('id_j_ditinggal'),
            'created_by' => $this->session->userdata('user')->id_pegawai
        );

        $this->load->model('draft_pelantikan_model');
        $tx_result = $this->draft_pelantikan_model->ganti($data);
    }

    public function isi_draft_jabatan($id_draft, $id_j){
        $this->load->view('layout/header', array( 'title' => 'Jabatan Struktural'));
        $this->load->model('draft_pelantikan_model');
        $iddraftpwd = $this->session->userdata('iddraftpwd');
        $passwordya = $this->draft_pelantikan_model->get_pass($id_draft)->password;
        if($iddraftpwd==$id_draft.$passwordya){
            $riwayat_jabatan = '';

            $this->load->model('jabatan_model');
            $jabatan = $this->jabatan_model->get_jabatan($id_j);
            $bos_jabatan = $this->jabatan_model->get_bos_jabatan($id_j,$id_draft);


            if (strpos($jabatan->nama_baru_skpd, 'Kelurahan') !== false) {
                if($jabatan->eselon == 'IVA') {
                    $jabatan_bawahan = $this->jabatan_model->get_jabatan_bawahan($id_j, $id_draft);
                }else{
                    if($jabatan->eselon <> 'IVB') {
                        $jabatan_bawahan = $this->jabatan_model->get_jabatan_bawahan($id_j, $id_draft);
                    }else{
                        $jabatan_bawahan = $this->jabatan_model->get_jabatan_bawahan_staf($id_j);
                    }
                }
            }else{
                if($jabatan->eselon <> 'IVA' and $jabatan->eselon <> 'IVB') {
                    $jabatan_bawahan = $this->jabatan_model->get_jabatan_bawahan($id_j, $id_draft);
                }else{
                    $jabatan_bawahan = $this->jabatan_model->get_jabatan_bawahan_staf($id_j);
                }
            }

            $this->load->model('draft_pelantikan_model');
            $pejabat_sekarang = $this->draft_pelantikan_model->get_pejabat_sekarang($id_draft, $id_j);

            if($pejabat_sekarang) {
            }else{
                $pejabat_sekarang = $this->draft_pelantikan_model->get_pejabat_sekarang_plt($id_draft, $id_j);
            }

            if($pejabat_sekarang){
                $this->load->model('riwayat_jabatan_model');
                $riwayat_jabatan = $this->riwayat_jabatan_model->get_by_id_pegawai($pejabat_sekarang->idpegawai);
                $eselonering = $this->draft_pelantikan_model->pengalaman_eselon_pegawai($pejabat_sekarang->idpegawai, $pejabat_sekarang->eselon);
            }
            $rekomendasi_pejabat = $this->draft_pelantikan_model->getRekomendasiPejabat($id_j);
            $getIdSkpdTujuan = $this->draft_pelantikan_model->getIdSkpdTujuan();
            $getBidangPendidikan = $this->draft_pelantikan_model->getBidangPendidikan();

            $this->load_header_draft_pelantikan($id_draft);
            $this->load->view('jabatan_struktural/isi_draft_jabatan', array(
                'jabatan' => $jabatan,
                'pejabat_sekarang' => $pejabat_sekarang,
                'eselonering' => (isset($eselonering) ? $eselonering : ''),
                'riwayat_jabatan' => $riwayat_jabatan,
                'bos_jabatan' => $bos_jabatan,
                'jabatan_bawahan' => $jabatan_bawahan,
                'id_draft' => $id_draft,
                'rekomendasi_pejabat' => $rekomendasi_pejabat,
                'idskpd_tujuan' => $getIdSkpdTujuan,
                'bidang_pendidikan' => $getBidangPendidikan
            ));
            $this->load->view('jabatan_struktural/footer_draft_pelantikan');
        }else{
            $data =array('idd'=> $id_draft, 'pwdsalah'=>'');
            $this->load->view('jabatan_struktural/login_draft', $data);
        }
        $this->load->view('layout/footer');
    }

    private function cek_kesesuaian_jabatan($id_draft, $id_j, $id_pegawai){
        $notes = array();
        $this->load->model('jabatan_model');
        $this->load->model('draft_pelantikan_model');
        $this->load->model('hukuman_model');
        $jabatan = $this->jabatan_model->get_jabatan($id_j);
        $bos_jabatan = $this->jabatan_model->get_bos_jabatan($id_j,$id_draft);
        $draft = $this->draft_pelantikan_model->get_draft_pelantikan_by_id($id_draft);
        $masa_kerja = $this->draft_pelantikan_model->get_masa_kerja($id_pegawai, $draft->tgl_pelantikan);
        $masa_kerja = $masa_kerja[0];
        $gol_terakhir = $this->draft_pelantikan_model->get_usia_golongan_terakhir($id_pegawai, $draft->tgl_pelantikan);
        $gol_terakhir = $gol_terakhir[0];
        $riwayat_hukuman = $this->hukuman_model->get_by_id_riwayat_hukuman($id_pegawai);

        // Informasi Jabatan Bawahan
        if (strpos($jabatan->nama_baru_skpd, 'Kelurahan') !== false) {
            if($jabatan->eselon == 'IVA') {
                $jabatan_bawahan = $this->jabatan_model->get_jabatan_bawahan($id_j, $id_draft);
            }else{
                if($jabatan->eselon <> 'IVB') {
                    $jabatan_bawahan = $this->jabatan_model->get_jabatan_bawahan($id_j, $id_draft);
                }else{
                    $jabatan_bawahan = $this->jabatan_model->get_jabatan_bawahan_staf($id_j);
                }
            }
        }else{
            if($jabatan->eselon <> 'IVA' and $jabatan->eselon <> 'IVB') {
                $jabatan_bawahan = $this->jabatan_model->get_jabatan_bawahan($id_j, $id_draft);
            }else{
                $jabatan_bawahan = $this->jabatan_model->get_jabatan_bawahan_staf($id_j);
            }
        }

        //Informasi Pegawai yang akan diusulkan
        $pegawai = $this->draft_pelantikan_model->get_pegawai($id_pegawai, $id_draft);

        // Pengecekan Diklat Barjas
        $this->load->model('riwayat_jabatan_model');
        if($this->riwayat_jabatan_model->get_by_id_pegawai_by_eselon_count($pegawai->id_pegawai_ori, $jabatan->eselon) == 0 and
            ($jabatan->eselon == 'IIIA' or $jabatan->eselon == 'IIIB' /*or $jabatan->eselon == 'IVA'*/)){
            if($this->draft_pelantikan_model->get_diklat_barjas($pegawai->id_pegawai_ori) == 0){
                $notes[] = array("Pegawai belum menjalani Diklat Sertifikasi Pengadaan Barang dan Jasa ", 1,'red'); // Notes 14
            }
        }

        // Pengecekan golongan terakhir
        if($pegawai->eselon==''){
            $promote = 'Promosi';
        }else{
            if($pegawai->eselon > $jabatan->eselon){
                $promote = 'Promosi';
            }else{
                $promote = 'Rotasi';
            }
        }

        if($jabatan->eselon=='IIIA') {
            if($pegawai->jenjab == 'Struktural') {
                if($jabatan->gol_minimal > $pegawai->pangkat_gol) {
                    $notes[] = array("Golongan pegawai yang akan dicalonkan tidak memenuhi syarat kepangkatannya.",1,'red'); // Notes 5
                }else{
                    if($promote == 'Promosi'){
                        if(($pegawai->pangkat_gol == $jabatan->gol_minimal) and ($gol_terakhir->usia_golongan < 3)){
                            $notes[] = array("Golongan terakhir pegawai (".$gol_terakhir->gol.") belum mencapai 3 tahun, <br>no.sk " . $gol_terakhir->no_sk . ' (TMT: ' . $gol_terakhir->tgl_tmt . ') <br>Lama ' . $gol_terakhir->usia_golongan . ' thn', 1, 'red'); // Notes 15
                        }
                    }
                }
            }elseif($pegawai->jenjab == 'Fungsional') {
                if('IV/a' > $pegawai->pangkat_gol) {
                    $notes[] = array("Golongan pegawai yang akan dicalonkan tidak memenuhi syarat kepangkatannya.",1,'red'); // Notes 5
                }else{
                    if($promote == 'Promosi'){
                        if(($pegawai->pangkat_gol == 'IV/a') and ($gol_terakhir->usia_golongan < 2)){
                            $notes[] = array("Golongan terakhir pegawai (".$gol_terakhir->gol.") belum mencapai 2 tahun, <br>no.sk " . $gol_terakhir->no_sk . ' (TMT: ' . $gol_terakhir->tgl_tmt . ') <br>Lama ' . $gol_terakhir->usia_golongan . ' thn', 1, 'red'); // Notes 15
                        }
                    }
                }
            }else{
                $notes[] = array("Jenjang jabatan pegawai belum ada.",1,'red'); // Notes 5
            }
        }elseif($jabatan->eselon=='IIIB'){
            if($pegawai->jenjab == 'Struktural'){
                if($jabatan->gol_minimal > $pegawai->pangkat_gol) {
                    $notes[] = array("Golongan pegawai yang akan dicalonkan tidak memenuhi syarat kepangkatannya.",1,'red'); // Notes 5
                }else{
                    if($promote == 'Promosi') {
                        if (($pegawai->pangkat_gol == $jabatan->gol_minimal) and ($gol_terakhir->usia_golongan < 3)) {
                            $notes[] = array("Golongan terakhir pegawai (" . $gol_terakhir->gol . ") belum mencapai 3 tahun, <br>no.sk " . $gol_terakhir->no_sk . ' (TMT: ' . $gol_terakhir->tgl_tmt . ') <br>Lama ' . $gol_terakhir->usia_golongan . ' thn', 1, 'red'); // Notes 15
                        }
                    }
                }
            }elseif($pegawai->jenjab == 'Fungsional') {
                if('III/d' > $pegawai->pangkat_gol) {
                    $notes[] = array("Golongan pegawai yang akan dicalonkan tidak memenuhi syarat kepangkatannya.",1,'red'); // Notes 5
                }else{
                    if($promote == 'Promosi') {
                        if (($pegawai->pangkat_gol == 'III/d') and ($gol_terakhir->usia_golongan < 2)) {
                            $notes[] = array("Golongan terakhir pegawai (" . $gol_terakhir->gol . ") belum mencapai 2 tahun, <br>no.sk " . $gol_terakhir->no_sk . ' (TMT: ' . $gol_terakhir->tgl_tmt . ') <br>Lama ' . $gol_terakhir->usia_golongan . ' thn', 1, 'red'); // Notes 15
                        }
                    }
                }
            }else{
                $notes[] = array("Jenjang jabatan pegawai belum ada.",1,'red'); // Notes 5
            }
        }elseif($jabatan->eselon=='IVA'){
            if($pegawai->jenjab == 'Struktural') {
                if($pegawai->eselon=='IVB'){
                    if($jabatan->gol_minimal > $pegawai->pangkat_gol) {
                        $notes[] = array("Golongan pegawai yang akan dicalonkan tidak memenuhi syarat kepangkatannya.",1,'red'); // Notes 5
                    }else{
                        if($promote == 'Promosi') {
                            if (($pegawai->pangkat_gol == $jabatan->gol_minimal) and ($gol_terakhir->usia_golongan < 2)) {
                                $notes[] = array("Golongan terakhir pegawai (" . $gol_terakhir->gol . ") belum mencapai 2 tahun, <br>no.sk " . $gol_terakhir->no_sk . ' (TMT: ' . $gol_terakhir->tgl_tmt . ') <br>Lama ' . $gol_terakhir->usia_golongan . ' thn', 1, 'red'); // Notes 15
                            }
                        }
                    }
                }else{
                    if($jabatan->gol_minimal > $pegawai->pangkat_gol) {
                        $notes[] = array("Golongan pegawai yang akan dicalonkan tidak memenuhi syarat kepangkatannya.",1,'red'); // Notes 5
                    }else{
                        if($promote == 'Promosi') {
                            if (($pegawai->pangkat_gol == $jabatan->gol_minimal) and ($gol_terakhir->usia_golongan < 3)) {
                                $notes[] = array("Golongan terakhir pegawai (" . $gol_terakhir->gol . ") belum mencapai 3 tahun, <br>no.sk " . $gol_terakhir->no_sk . ' (TMT: ' . $gol_terakhir->tgl_tmt . ') <br>Lama ' . $gol_terakhir->usia_golongan . ' thn', 1, 'red'); // Notes 15
                            }
                        }
                    }
                }
            }elseif($pegawai->jenjab == 'Fungsional'){
                if('III/c' > $pegawai->pangkat_gol) {
                    $notes[] = array("Golongan pegawai yang akan dicalonkan tidak memenuhi syarat kepangkatannya.",1,'red'); // Notes 5
                }else{
                    if($promote == 'Promosi') {
                        if (($pegawai->pangkat_gol == 'III/c') and ($gol_terakhir->usia_golongan < 2)) {
                            $notes[] = array("Golongan terakhir pegawai (" . $gol_terakhir->gol . ") belum mencapai 2 tahun, <br>no.sk " . $gol_terakhir->no_sk . ' (TMT: ' . $gol_terakhir->tgl_tmt . ') <br>Lama ' . $gol_terakhir->usia_golongan . ' thn', 1, 'red'); // Notes 15
                        }
                    }
                }
            }else{
                $notes[] = array("Jenjang jabatan pegawai belum ada.",1,'red'); // Notes 5
            }

            if (strpos($jabatan->jabatan, 'Lurah') !== false) {
                if('III/c' > $pegawai->pangkat_gol) {
                    $notes[] = array("Golongan pegawai yang akan dicalonkan tidak memenuhi syarat kepangkatannya.",1,'red'); // Notes 5
                }else{
                    if($masa_kerja->usia_golongan < 10){
                        $notes[] = array("Masa kerja keseluruhan pegawai (".$masa_kerja->gol.") belum mencapai 10 tahun, <br>no.sk " . $masa_kerja->no_sk . ' (TMT: ' . $masa_kerja->tgl_tmt . ') <br>Lama ' . $masa_kerja->usia_golongan . ' thn', 1, 'red'); // Notes 15
                    }
                }
            }
        }elseif($jabatan->eselon=='IVB'){
            if($jabatan->gol_minimal > $pegawai->pangkat_gol){
                $notes[] = array("Golongan pegawai yang akan dicalonkan tidak memenuhi syarat kepangkatannya.",1,'red'); // Notes 5
            }else{
                if($promote == 'Promosi'){
                    if(($pegawai->pangkat_gol == $jabatan->gol_minimal) and ($gol_terakhir->usia_golongan < 3)){
                        $notes[] = array("Golongan terakhir pegawai (".$gol_terakhir->gol.") belum mencapai 3 tahun, <br>no.sk " . $gol_terakhir->no_sk . ' (TMT: ' . $gol_terakhir->tgl_tmt . ') <br>Lama ' . $gol_terakhir->usia_golongan . ' thn', 1, 'red'); // Notes 15
                    }
                }
            }
        }

        // Pengecekan jenjab fungsional
        if($pegawai->jenjab == 'Fungsional'){
            $notes[] = array("Jabatan pegawai tersebut Fungsional", 2,'darkorange'); // Notes 13
        }

        //Pengecekan eselon berjenjang
        if($pegawai->eselon == ''){
            if($jabatan->eselon <> 'IVA' and $jabatan->eselon <> 'IVB'){
                if($pegawai->jenjab == 'Fungsional'){
                    if($jabatan->gol_minimal > $pegawai->pangkat_gol) {
                        $notes[] = array("Golongan pegawai yang akan dicalonkan tidak memenuhi syarat kepangkatannya.", 1, 'red'); // Notes 5
                    }
                }else{
                    $notes[] = array("Jabatan Eselon yang dituju tidak dapat diisi oleh pegawai ini karena tidak berjenjang",1,'red'); // Notes 1
                }
            }else{
                if($pegawai->jenjab == 'Struktural' and $pegawai->masa_kerja < 4){
                    $notes[] = array("Masa kerja pegawai kurang dari 4 tahun", 1, 'red'); // Notes 2
                }elseif($pegawai->jenjab == 'Fungsional' and $pegawai->masa_kerja < 1) {
                    $notes[] = array("Masa kerja pegawai kurang dari 1 tahun", 1, 'red'); // Notes 2
                }
            }
        }else{
            //Pengecekan pengalaman eselon saat ini / masa jabatan
            $pengalaman_eselon = 0;
            $jml_jabatan = 0;
            if($jabatan->eselon=='IIIA') {
                if($pegawai->eselon > $jabatan->eselon){
                    if($pegawai->eselon == 'IIIB'){
                        $pengalaman_eselon_cur = $this->draft_pelantikan_model->pengalaman_eselon_pegawai($pegawai->id_pegawai_ori, $pegawai->eselon, "'".$draft->tgl_pelantikan."'");
                        if(isset($pengalaman_eselon_cur)) {
                            $pengalaman_eselon = $pengalaman_eselon_cur->pengalaman_eselon;
                            $jml_jabatan = $pengalaman_eselon_cur->jml_jabatan;
                        }
                        if($pengalaman_eselon < 2){
                            $notes[] = array("Masa kerja Eselon pegawai kurang dari 2 tahun", 1, 'red'); // Notes 2
                        }else{
                            if($jml_jabatan < 2){
                                //$notes[] = array("Belum pernah menduduki 2 jabatan struktural yang berbeda", 1, 'red'); // Notes 2
                            }
                        }
                    }else{
                        $notes[] = array("Jabatan Eselon yang dituju tidak dapat diisi oleh pegawai ini karena tidak berjenjang",1,'red'); // Notes 1
                    }
                }
            }elseif($jabatan->eselon=='IIIB'){
                if($pegawai->eselon > $jabatan->eselon){
                    if($pegawai->eselon == 'IVA'){
                        $pengalaman_eselon_cur = $this->draft_pelantikan_model->pengalaman_eselon_pegawai($pegawai->id_pegawai_ori, $pegawai->eselon, "'".$draft->tgl_pelantikan."'");
                        if(isset($pengalaman_eselon_cur)) {
                            $pengalaman_eselon = $pengalaman_eselon_cur->pengalaman_eselon;
                            $jml_jabatan = $pengalaman_eselon_cur->jml_jabatan;
                        }
                        $pengalaman_eselon_cur = $this->draft_pelantikan_model->pengalaman_eselon_pegawai($pegawai->id_pegawai_ori, 'IVB', "'".$draft->tgl_pelantikan."'");
                        if(isset($pengalaman_eselon_cur)) {
                            $pengalaman_eselon = $pengalaman_eselon + $pengalaman_eselon_cur->pengalaman_eselon;
                            $jml_jabatan = $jml_jabatan + $pengalaman_eselon_cur->jml_jabatan;
                        }
                        if($pengalaman_eselon < 2){
                            $notes[] = array("Masa kerja Eselon pegawai kurang dari 2 tahun", 1, 'red'); // Notes 2
                        }else{
                            if($jml_jabatan < 2){
                                //$notes[] = array("Belum pernah menduduki 2 jabatan struktural yang berbeda", 1, 'red'); // Notes 2
                            }
                        }
                    }else{
                        $notes[] = array("Jabatan Eselon yang dituju tidak dapat diisi oleh pegawai ini karena tidak berjenjang",1,'red'); // Notes 1
                    }
                }
            }elseif($jabatan->eselon=='IVA'){
                if($pegawai->eselon=='IVB'){
                    $pengalaman_eselon_cur = $this->draft_pelantikan_model->pengalaman_eselon_pegawai($pegawai->id_pegawai_ori, $pegawai->eselon, "'".$draft->tgl_pelantikan."'");
                    if(isset($pengalaman_eselon_cur)) {
                        $pengalaman_eselon = $pengalaman_eselon_cur->pengalaman_eselon;
                    }
                    if($pengalaman_eselon < 2){
                        $notes[] = array("Masa kerja Eselon pegawai kurang dari 2 tahun", 1, 'red'); // Notes 2
                    }
                }else{
                    if($pegawai->eselon==''){
                        if($pegawai->jenjab == 'Struktural' and $pegawai->masa_kerja < 4){
                            $notes[] = array("Masa kerja pegawai kurang dari 4 tahun", 1, 'red'); // Notes 2
                        }elseif($pegawai->jenjab == 'Fungsional' and $pegawai->masa_kerja < 2) {
                            $notes[] = array("Masa kerja pegawai kurang dari 2 tahun", 1, 'red'); // Notes 2
                        }
                    }
                }
            }elseif($jabatan->eselon=='IVB'){
                if($pegawai->eselon != 'IVB'){
                    if($riwayat_hukuman!=NULL) {
                        $notes[] = array("Jabatan Eselon yang dituju tidak berjenjang mungkin akan demosi karena ada penjatuhan hukuman disiplin", 2,'darkorange');
                    }else{
                        $notes[] = array("Jabatan Eselon yang dituju tidak dapat diisi oleh pegawai ini karena tidak berjenjang", 1, 'red'); // Notes 1
                    }
                }
            }

            // Pengecekan eselon di bawahnya
            $eselonbawahnya = $this->draft_pelantikan_model->getEselonDibawahnya($jabatan->eselon);
            if($pegawai->eselon <> $jabatan->eselon){
                $eselonbawahnya = (isset($eselonbawahnya->eselon) ? $eselonbawahnya->eselon : '');
                if($eselonbawahnya == ''){
                    $notes[] = array("Jabatan Eselon pegawai lebih tinggi dari jabatan eselon yang dituju", 1,'red'); // Notes 3
                }else {
                    if ($pegawai->eselon > $eselonbawahnya) {
                        $notes[] = array("Pengisian jabatan Eselon harus berjenjang", 2,'darkorange'); // Notes 4
                    } elseif ($pegawai->eselon < $eselonbawahnya) {
                        if($riwayat_hukuman!=NULL) {
                            $notes[] = array("Jabatan Eselon pegawai lebih tinggi dari jabatan eselon yang dituju mungkin akan demosi karena ada penjatuhan hukuman disiplin", 2,'darkorange');
                        }else{
                            $notes[] = array("Jabatan Eselon pegawai lebih tinggi dari jabatan eselon yang dituju", 1,'red'); // Notes 3
                        }
                    }
                }
            }
        }

        //Pengecekan pendidikan
        if($jabatan->eselon=='IIIA') {
            if($promote == 'Promosi') {
                if ($pegawai->level_p > 3) {
                    $notes[] = array("Pendidikan minimal S1", 1, 'red'); // Notes 3
                }
            }
        }elseif($jabatan->eselon=='IIIB'){
            if($promote == 'Promosi') {
                if ($pegawai->level_p > 3 and $pegawai->level_p < 10 and $pegawai->level_p > 0) {
                    $notes[] = array("Pendidikan minimal S1 atau D4", 1, 'red'); // Notes 3
                }
            }
        }elseif($jabatan->eselon=='IVA' or $jabatan->eselon=='IVB'){
            if($promote == 'Promosi'){
                if($pegawai->level_p > 4){
                    $notes[] = array("Pendidikan minimal D3", 1,'red'); // Notes 3
                }
            }
        }

        //pensiun 6 bulan ke depan
        $date1 = new DateTime(date("Y-m-d"));
        $date2 = new DateTime($pegawai->tgl_pensiun_dini);
        $interval = date_diff($date1, $date2);
        $jarak = $interval->m + ($interval->y * 12);

        if($jarak<=1) {
            $notes[] = array("Dalam waktu 1 bulan ke depan Pegawai Akan Pensiun tanggal ".$pegawai->tgl_pensiun_dini,1,'red'); // Notes 6
        }else{
            if($jarak<=6){
                $notes[] = array("Dalam waktu 6 bulan ke depan Pegawai Akan Pensiun tanggal ".$pegawai->tgl_pensiun_dini,1,'red'); // Notes 6
            }
        }

        //pernah hukdis
        if($riwayat_hukuman!=NULL){
            foreach($riwayat_hukuman as $data_huk) {
                if($data_huk->tingkat_hukuman=='RINGAN' and $data_huk->cek_ringan_curr=='1'){
                    if($jabatan->eselon=='IVB'){
                        if($pegawai->eselon < $eselonbawahnya){
                            $notes[] = array("Pegawai sedang dijatuhi Hukuman Disiplin Ringan pada tahun ini",2,'darkorange'); // Notes 7
                        }else{
                            $notes[] = array("Pegawai sedang dijatuhi Hukuman Disiplin Ringan pada tahun ini",1,'red'); // Notes 7
                        }
                    }
                }else{
                    if($data_huk->tingkat_hukuman=='SEDANG' and $data_huk->usia_hukuman < 4){
                        if($pegawai->eselon < $eselonbawahnya){
                            $notes[] = array("Pegawai sedang dijatuhi Hukuman Disiplin Sedang dan belum mencapai 4 tahun",2,'darkorange'); // Notes 7
                        }else{
                            $notes[] = array("Pegawai sedang dijatuhi Hukuman Disiplin Sedang dan belum mencapai 4 tahun",1,'red'); // Notes 7
                        }
                    }
                    if($data_huk->tingkat_hukuman=='BERAT' and $data_huk->usia_hukuman < 6){
                        if($pegawai->eselon < $eselonbawahnya){
                            $notes[] = array("Pegawai sedang dijatuhi Hukuman Disiplin Berat dan belum mencapai 6 tahun",2,'darkorange'); // Notes 7
                        }else{
                            $notes[] = array("Pegawai sedang dijatuhi Hukuman Disiplin Berat dan belum mencapai 6 tahun",1,'red'); // Notes 7
                        }
                    }
                }
            }
            //$notes[] = array("Pegawai Pernah Dijatuhi Hukuman Disiplin Pegawai ",2,'darkorange'); // Notes 7
        }

        if($jabatan->gol_minimal == $pegawai->pangkat_gol) {
            $notes[] = array("Golongan pegawai yang akan dicalonkan sama dengan
			golongan satu tingkat dibawah syarat minimal yaitu " . $jabatan->gol_minimal,2,'darkorange'); // Notes 8
        }

        // Test kepangkatan dengan calon atasan
        if(isset($bos_jabatan)){
            if(strtolower($bos_jabatan->jabatan_bos) != 'walikota bogor'){
                // Pastikan golongan tidak melebihi atasan
                if($pegawai->pangkat_gol > $bos_jabatan->pangkat_gol){
                    $jmlOpnBid = $this->draft_pelantikan_model->get_existin_openbidding($bos_jabatan->id_pegawai_bos);
                    if((int)$jmlOpnBid > 0){

                    }else{
                        $notes[] = array("Golongan pegawai yang dicalonkan melebihi golongan atasannya,
					    $bos_jabatan->nama Pangkat: $bos_jabatan->pangkat_gol",1,'red'); // Notes 9
                    }
                }elseif($pegawai->pangkat_gol == $bos_jabatan->pangkat_gol){
                    $date = explode("-",$pegawai->tmt);
                    $date1 = new DateTime($date[2].'-'.$date[1].'-'.$date[0]);
                    $date2 = new DateTime($bos_jabatan->tmt_pangkat);
                    if($date1 < $date2){
                        //Gol Tertinggi Pendidikan
                        if($pegawai->level_p=='1'){ //S3
                            $gol_tertinggi = 'IV/b';
                        }elseif($pegawai->level_p=='2' or (isset($pegawai->jabatan) and $pegawai->jabatan == 'Dokter') or (isset($pegawai->jabatan) and $pegawai->jabatan == 'Dokter Gigi')){ //S2
                            $gol_tertinggi = 'IV/a';
                        }elseif($pegawai->level_p=='3'){ //S1
                            $gol_tertinggi = 'III/d';
                        }elseif($pegawai->level_p=='4'){ //D3
                            $gol_tertinggi = 'III/c';
                        }elseif($pegawai->level_p=='5'){ //D2
                            $gol_tertinggi = 'III/b';
                        }elseif($pegawai->level_p=='6'){ //D1
                            $gol_tertinggi = 'III/b';
                        }elseif($pegawai->level_p=='7'){ //SMA
                            $gol_tertinggi = 'III/b';
                        }elseif($pegawai->level_p=='8'){ //SMP
                            $gol_tertinggi = 'II/d';
                        }elseif($pegawai->level_p=='9'){ //SD
                            $gol_tertinggi = 'II/a';
                        }
                        if($pegawai->pangkat_gol<>$gol_tertinggi){
                            if($pegawai->pangkat_gol < $gol_tertinggi){
                                $notes[] = array("Pegawai yang dicalonkan akan naik pangkat lebih dahulu dari atasannya,
								$bos_jabatan->nama TMT.Pangkat: $bos_jabatan->tmt_pangkat",2,'darkorange'); // Notes 10
                            }
                        }
                    }
                }
            }
        }

        // Test kepangkatan dengan bawahan
        if(isset($jabatan_bawahan)){
            foreach($jabatan_bawahan as $bawah){

                // Cek apakah sudah dimasukkan dalam draft usulan baru yg sblmnya kosong
                $jmlaAllBeforeNull = $this->draft_pelantikan_model->get_exists_reposition_in_draft($id_draft, $bawah->id_pegawai_bawahan);

                // Pastikan golongan tidak lebih rendah dari bawahan
                if($pegawai->pangkat_gol < $bawah->pangkat_gol){
                    $jmlInDraftExist = $this->jabatan_model->cek_in_draft_by_idp($id_draft, $bawah->id_pegawai_bawahan, $bawah->id_pegawai_bawahan);
                    foreach($jmlInDraftExist as $jumlah){
                        $jmla = $jumlah->jumlah;
                    }
                    if((int)$jmla == 0){
                        if((int)$jmlaAllBeforeNull > 0){
                        }else{
                            $jmlOpnBid = $this->draft_pelantikan_model->get_existin_openbidding($pegawai->id_pegawai_ori);
                            if((int)$jmlOpnBid > 0){
                            }else{
                                if($bawah->jenjab=='Fungsional'){

                                }else{
                                    $notes[] = array("Golongan pegawai yang dicalonkan lebih rendah (atau sama dengan) golongan bawahannya,
						            $bawah->nama Pangkat: $bawah->pangkat_gol",1,'red'); // Notes 11
                                }
                            }
                        }
                    }
                    //break;
                }elseif($pegawai->pangkat_gol == $bawah->pangkat_gol){
                    $date = explode("-",$pegawai->tmt);
                    $date1 = new DateTime($date[2].'-'.$date[1].'-'.$date[0]);
                    $date2 = new DateTime($bawah->tmt_pangkat);

                    $formattedDate1 = $date1->format('d M Y');
                    $formattedDate2 = $date2->format('d M Y');

                    if($date1 > $date2) {
                        //echo $formattedDate1 . '>' . $formattedDate2 . '<br>';
                        //Gol Tertinggi Pendidikan
                        if ($pegawai->level_p == '1') { //S3
                            $gol_tertinggi = 'IV/b';
                        } elseif ($pegawai->level_p == '2' or (isset($pegawai->jabatan) and $pegawai->jabatan == 'Dokter') or (isset($pegawai->jabatan) and $pegawai->jabatan == 'Dokter Gigi')) { //S2
                            $gol_tertinggi = 'IV/a';
                        } elseif ($pegawai->level_p == '3') { //S1
                            $gol_tertinggi = 'III/d';
                        } elseif ($pegawai->level_p == '4') { //D3
                            $gol_tertinggi = 'III/c';
                        } elseif ($pegawai->level_p == '5') { //D2
                            $gol_tertinggi = 'III/b';
                        } elseif ($pegawai->level_p == '6') { //D1
                            $gol_tertinggi = 'III/b';
                        } elseif ($pegawai->level_p == '7') { //SMA
                            $gol_tertinggi = 'III/b';
                        } elseif ($pegawai->level_p == '8') { //SMP
                            $gol_tertinggi = 'II/d';
                        } elseif ($pegawai->level_p == '9') { //SD
                            $gol_tertinggi = 'II/a';
                        }
                        if ($pegawai->pangkat_gol <> $gol_tertinggi) {

                            if ($pegawai->pangkat_gol < $gol_tertinggi) {
                                $jmlData = $this->draft_pelantikan_model->get_pegawai_exist_in_draft($id_draft, $bawah->id_pegawai_bawahan);
                                if ($jmlData > 0) {

                                    if($bawah->level_p=='1'){ //S3
                                        $gol_tertinggi = 'IV/b';
                                    }elseif($bawah->level_p=='2' or (isset($pegawai->jabatan) and $pegawai->jabatan == 'Dokter') or (isset($pegawai->jabatan) and $pegawai->jabatan == 'Dokter Gigi')){ //S2
                                        $gol_tertinggi = 'IV/a';
                                    }elseif($bawah->level_p=='3'){ //S1
                                        $gol_tertinggi = 'III/d';
                                    }elseif($bawah->level_p=='4'){ //D3
                                        $gol_tertinggi = 'III/c';
                                    }elseif($bawah->level_p=='5'){ //D2
                                        $gol_tertinggi = 'III/b';
                                    }elseif($bawah->level_p=='6'){ //D1
                                        $gol_tertinggi = 'III/b';
                                    }elseif($bawah->level_p=='7'){ //SMA
                                        $gol_tertinggi = 'III/b';
                                    }elseif($bawah->level_p=='8'){ //SMP
                                        $gol_tertinggi = 'II/d';
                                    }elseif($bawah->level_p=='9'){ //SD
                                        $gol_tertinggi = 'II/a';
                                    }

                                    if($bawah->pangkat_gol>=$gol_tertinggi){

                                    }else {
                                        if((int)$jmlaAllBeforeNull > 0){
                                        }else {
                                            $notes[] = array("Bawahannya akan naik pangkat lebih dulu dari pegawai yang dicalonkan,
									    $bawah->nama TMT.Pangkat: $bawah->tmt_pangkat", 1, 'red'); // Notes 12
                                        }
                                    }
                                }
                            }
                        }
                    }elseif($date1 < $date2){
                        //echo $formattedDate1.'<'.$formattedDate2.'<br>';
                    }
                }
            }
        }

        /* Cek Kabid/Kasie pada Dinas Kesehatan */
        if (strpos($jabatan->jabatan, 'Dinas Kesehatan') !== false) {
            if(($jabatan->eselon == 'IIIA')
                or (strpos($jabatan->jabatan, 'Kasubag Umum dan Kepegawaian')!== false)
                or (strpos($jabatan->jabatan, 'Kasubag Keuangan')!==false)
                or (strpos($jabatan->jabatan, 'Kasubag Perencanan dan Pelaporan')!==false)
                or (strpos($jabatan->jabatan, 'Kasubag Tata Usaha UPTD Puskesmas')!==false)
                or (strpos($jabatan->jabatan, 'Kasubag Tata Usaha Laboratorium Kesehatan Daerah')!==false)
            ){
                //
            }else{
                if($pegawai->bidang=='Kesehatan'){
                }else{
                    $notes[] = array("Pegawai bukan dari bidang kesehatan ", 1,'red'); // Notes 16
                }
            }
        }

        /* Cek MPP, Tubel, CLTN */
        $is_mpp_tubel_cltn = $this->draft_pelantikan_model->is_mpp_tubel_cltn($pegawai->id_pegawai_ori);
        if($is_mpp_tubel_cltn['jmlData'] > 0){
            $notes[] = array("Pegawai sedang menjalani ".$is_mpp_tubel_cltn['statusAktif'], 1,'red'); // Notes 14
        }

        return $notes;

    }

    public function json_cek_kesesuaian_jabatan(){
        $id_j = $this->input->post('id_jabatan');
        $id_pegawai = $this->input->post('id_pegawai');
        $id_draft = $this->input->post('id_draft');

        //echo($id_draft.",". $id_j.",". $id_pegawai);

        $notes = $this->cek_kesesuaian_jabatan($id_draft, $id_j, $id_pegawai);

        if(is_array($notes) && sizeof($notes))
            echo json_encode($notes);
        else
            echo '[]';
    }

    public function nominatif_draft_pelantikan($id_draft=0){
        if($id_draft){
            $this->load->view('layout/header', array( 'title' => 'Jabatan Struktural'));
            $this->load->model('draft_pelantikan_model');
            $iddraftpwd = $this->session->userdata('iddraftpwd');
            $passwordya = $this->draft_pelantikan_model->get_pass($id_draft)->password;
            if($iddraftpwd==$id_draft.$passwordya){
                $eselons = $this->draft_pelantikan_model->get_eselon_pelantikan($id_draft);
                $this->load->view("jabatan_struktural/nominatif_draft_pelantikan", array('eselons' => $eselons));
            }else{
                $data =array('idd'=> $id_draft, 'pwdsalah'=>'');
                $this->load->view('jabatan_struktural/login_draft', $data);
            }
            $this->load->view('layout/footer');
        }
        else;
        //$this->draft_pelantikan_partial();
        //$this->load->view('layout/footer');
    }

    public function batal_pelantikan_pegawai(){
        $data = array(
            'id_draft' => $this->input->post('id_draft'),
            'id_pegawai_baru' => $this->input->post('id_pegawai_baru'),
            'id_pegawai_awal' => $this->input->post('id_pegawai_awal')
        );
        //print_r($data);
        $this->load->model('draft_pelantikan_model');
        $notes = $this->draft_pelantikan_model->batal_pelantikan($data);

        if(is_array($notes) && sizeof($notes))
            echo json_encode($notes);
        else
            echo '[]';
    }

    public function nominatif_riwayat(){
        $this->load->model('jabatan_model');
        $nom = $this->jabatan_model->get_nominatif_riwayat_js();

        $this->load->view('layout/header', array( 'title' => 'Nominatif Riwayat Jabatan'));
        //$this->load->view('jabatan_struktural/header');
        $this->load->view('jabatan_struktural/nominatif_riwayat', array('rekap' => $nom));
        $this->load->view('layout/footer');
    }

    public function daftar_pegawai(){
        $this->load->model('hukuman_model');
        $hukuman = $this->hukuman_model->get_terhukum();

        $this->load->view('layout/header');
        $this->load->view('hukuman_disiplin/header');
        $this->load->view('hukuman_disiplin/daftar_pegawai', array('hukuman' => $hukuman));
        $this->load->view('layout/footer');
    }

    public function save(){
        authenticate($this->session->userdata('user'), "HUKDIS_SAVE");
        if($this->input->post('idPegawai')){
            /*$id_pegawai					= $this->input->post('idPegawai');
            $jenis_hukuman 				= $this->input->post('cboJenisHukuman');
            $no_keputusan 				= $this->input->post('txtNoKeputusan');
            $tanggal_penetapan 			= $this->input->post('txtNoKeputusan');
            $tmt 						= $this->input->post('txtTmt');
            $pejabat_pemberi_hukuman 	= $this->input->post('txtPejabatPemberiHukuman');
            $jabatan				 	= $this->input->post('txtJabatan');
            $keterangan				 	= $this->input->post('txtKeterangan');*/

            switch($this->input->post('cboJenisHukuman')){
                case 1	:
                    //$pegawai = '';
                    //$this->load->library('hukuman_disiplin/hukuman', array($pegawai));

                    break;
                case 2	:
                    break;
                case 3	:
                    break;
                case 4	:
                    break;
                case 5	:
                    break;
                case 6	:
                    break;
                case 7	:
                    break;
                case 8	:
                    break;
                case 9	:
                    break;
                case 10 :
                    break;
                case 11 :
                    break;
            }
            //$this->load->library('hukuman', array($pegawai));

            $this->load->model('hukuman_model');
            $this->hukuman_model->insert();
            $this->penjatuhan($this->input->post('idPegawai'));
        }
        else{
            $this->penjatuhan();
        }
    }

    public function hapus($id_draft){
        //authenticate($this->session->userdata('user'), "HUKDIS_DELETE");
        $this->load->model('draft_pelantikan_model');
        $this->draft_pelantikan_model->delete($id_draft);

        redirect('jabatan_struktural/draft_pelantikan/'.$this->input->get('idp'));
    }

    public function json_get_by_tingkat(){
        authenticate($this->session->userdata('user'), 'HUKDIS_VIEW_JENIS');
        $this->load->model("jenis_hukuman_model");
        $data = $this->jenis_hukuman_model->get_by_tingkat($this->input->post('tingkat'));

        echo json_encode($data);
    }

    public function detail_pegawai(){
        $no_reg = $this->input->post('no_reg');
        $nm_jabatan = $this->input->post('nm_jabatan');
        $jbtn_eselon = $this->input->post('jbtn_eselon');
        $skpd_tujuan = $this->input->post('skpd_tujuan');
        $type = $this->input->post('type');

        $this->load->model('draft_pelantikan_model');
        $detail_pegawai = $this->draft_pelantikan_model->getDetailPegawai($no_reg, $jbtn_eselon, $type);

        $this->load->view('jabatan_struktural/detail_pegawai', array(
            'detail_pegawai' => $detail_pegawai,
            'nm_jabatan' => $nm_jabatan,
            'jbtn_eselon' => $jbtn_eselon,
            'skpd_tujuan'=> $skpd_tujuan
        ));
    }

    public function drop_data_other_rekomendasi(){
        $limit_mulai = $this->input->post('limit_mulai');
        $limit_banyaknya = $this->input->post('limit_banyaknya');
        $idskpd = $this->input->post('idskpd');
        $jbtn_eselon = $this->input->post('jbtn_eselon');
        $tipe_rekomendasi = $this->input->post('tipe_rekomendasi');
        $jabatan = $this->input->post('jabatan');
        $nama_baru_skpd = $this->input->post('nama_baru_skpd');
        $id_draft = $this->input->post('id_draft');
        $keywordSuggest = $this->input->post('keywordSuggest');
        $this->load->model('draft_pelantikan_model');
        $drop_other_data_rekomendasi = $this->draft_pelantikan_model->dropDataOtherRekomendasi($limit_mulai, $limit_banyaknya, $idskpd, $jbtn_eselon, $tipe_rekomendasi, $keywordSuggest);

        $this->load->view('jabatan_struktural/drop_data_rekomendasi', array(
            'drop_other_data_rekomendasi'=> $drop_other_data_rekomendasi,
            'jbtn_eselon' => $jbtn_eselon,
            'jabatan'=> $jabatan,
            'nama_baru_skpd'=> $nama_baru_skpd,
            'id_draft'=> $id_draft
        ));
    }

    public function drop_data_sort_manual_rekomendasi(){
        $this->load->library('pager');
        $pages = new Paginator;
        $pagePaging = $_POST['page'];
        $ipp = $_POST['ipp'];

        if($pagePaging==0 or $pagePaging==""){
            $pagePaging = 1;
        }
        if($ipp==0 or $ipp==""){
            $ipp = $pages->default_ipp;
        }
        $_SESSION['ippPager'] = $ipp;
        $_SESSION['pagePager'] = $pagePaging;
        $this->load->model('draft_pelantikan_model');

        $idskpd = $this->input->post('idskpd');
        $jbtn_eselon = $this->input->post('jbtn_eselon');
        $jabatan = $this->input->post('jabatan');
        $nama_baru_skpd = $this->input->post('nama_baru_skpd');
        $id_draft = $this->input->post('id_draft');
        $a = $this->input->post('a');
        $b = $this->input->post('b');
        $c = $this->input->post('c');
        $d = $this->input->post('d');
        $e = $this->input->post('e');
        $f = $this->input->post('f');
        $g = $this->input->post('g');
        $filter = $this->input->post('filter');
        $pend = $this->input->post('pend');
        $txtKeyword = $this->input->post('txtKeyword');
        $barjas = $this->input->post('barjas');
        $mkjabatan = $this->input->post('mkjabatan');
        $jmlData = $this->draft_pelantikan_model->getCountAlldropDataSortManualRekomendasi($idskpd, $jbtn_eselon, $a,$b,$c,$d,$e,$f,$g,$filter,$pend,$txtKeyword,$barjas,$mkjabatan);

        if($jmlData>0){
            $pages->items_total = $jmlData;
            $pages->paginate();
            $pgDisplay = $pages->display_pages();
            $itemPerPage = $pages->display_items_per_page();
            $curpage = $pages->current_page;
            $numpage = $pages->num_pages;
            $jumppage = $pages->display_jump_menu();
        }else{
            $pgDisplay = '';
            $itemPerPage = '';
            $curpage = '';
            $numpage = '';
            $jumppage = '';
        }

        $ipp = explode("&&", $ipp);
        $ipp = $ipp[0];
        if($pagePaging == 1){
            $start_number = 0;
        }else{
            $start_number = ($pagePaging * $ipp) - $ipp;
        }

        if($pages->current_page==0){
            $pages->limit = 'LIMIT 0,10';
        }

        $drop_data_sort_manual_rekomendasi = $this->draft_pelantikan_model->getDropDataSortManualRekomendasi($start_number,$idskpd,$jbtn_eselon,$a,$b,$c,$d,$e,$f,$g,$filter,$pend,$txtKeyword,$barjas,$mkjabatan,$pages->limit,$pages->posisi);
        $this->load->view('jabatan_struktural/drop_data_sort_manual', array(
            'drop_other_data_rekomendasi'=> $drop_data_sort_manual_rekomendasi,
            'jbtn_eselon' => $jbtn_eselon,
            'jabatan'=> $jabatan,
            'nama_baru_skpd'=> $nama_baru_skpd,
            'id_draft'=> $id_draft,
            'pgDisplay' => $pgDisplay,
            'curpage' => $curpage,
            'numpage' => $numpage,
            'jumppage' => $jumppage,
            'jmlData' => $jmlData
        ));
    }

    public function download_data_excel_rekomendasi(){
        $idskpd = $this->input->post('idskpd');
        $tipe_rekomendasi = $this->input->post('tipe_rekomendasi');
        $jbtn_eselon = $this->input->post('jbtn_eselon');
        $jabatan = $this->input->post('jabatan');
        $nama_baru_skpd = $this->input->post('nama_baru_skpd');

        $this->load->view('jabatan_struktural/download_excel_rekomendasi', array(
            'jbtn_eselon' => $jbtn_eselon,
            'jabatan'=> $jabatan,
            'nama_baru_skpd'=> $nama_baru_skpd,
            'idskpd'=> $idskpd,
            'tipe_rekomendasi'=> $tipe_rekomendasi
        ));
    }

    public function export_to_excel(){
        parse_str($_SERVER['QUERY_STRING'],$_GET);
        $this->load->model('draft_pelantikan_model');
        $export_excel = $this->draft_pelantikan_model->exportDataToExcel($_GET['idskpd_tujuan'],
            $_GET['jbtn_eselon'], $_GET['limit_banyaknya'], $_GET['tipe_rekomendasi']);
    }

    public function setting_pengesahan($id_draft){
        $this->load->model('draft_pelantikan_model');
        $iddraftpwd = $this->session->userdata('iddraftpwd');
        $passwordya = $this->draft_pelantikan_model->get_pass($id_draft)->password;
        if($iddraftpwd==$id_draft.$passwordya){
            $this->load->model("Baperjakat_model");
            $baperjakat = $this->Baperjakat_model->get_all();
            $submitok = $this->input->post('submitok');
            if($submitok==1){
                $id_draft_exixting = (isset($this->draft_pelantikan_model->getdraft_pelantikan_pengesahan_by_iddraft($id_draft)->id_draft) ? $this->draft_pelantikan_model->getdraft_pelantikan_pengesahan_by_iddraft($id_draft)->id_draft : 0);
                $data = array(
                    'id_draft' => $id_draft,
                    'idbaperjakat' => $this->input->post('idbaperjakat'),
                    'nosk' => $this->input->post('nosk'),
                    'tglpengesahan' => $this->input->post('tglpengesahan'),
                    'wktpengesahan' => $this->input->post('wktpengesahan'),
                    'ruang_pengesahan' => $this->input->post('ruang_pengesahan')
                );
                $tx_result = $this->draft_pelantikan_model->updatePengesahanPelantikan($data, $id_draft_exixting);
            }

            $dp_pengesahan = $this->draft_pelantikan_model->getdraft_pelantikan_pengesahan_by_iddraft($id_draft);
            if(isset($dp_pengesahan->id_baperjakat)) {
                $info_baperjakat = $this->Baperjakat_model->getInfoBaperjakat($dp_pengesahan->id_baperjakat);
                $detail_baperjakat = $this->Baperjakat_model->getDetailBaperjakat($dp_pengesahan->id_baperjakat);
                $arrData = array(
                    'baperjakat' => $baperjakat,
                    'dp_pengesahan' => $dp_pengesahan,
                    'info_baperjakat' => $info_baperjakat,
                    'detail_baperjakat' => $detail_baperjakat,
                    'tx_result' => (isset($tx_result) ? $tx_result : '')
                );
            }else{
                $arrData = array(
                    'baperjakat' => $baperjakat,
                    'dp_pengesahan' => $dp_pengesahan,
                    'tx_result' => ''
                );
            }
            $this->load->view('layout/header', array( 'title' => 'Pengaturan Pengesahan'));
            $this->load_header_draft_pelantikan($id_draft);
            $this->load->view('jabatan_struktural/setting_pengesahan', $arrData);
            $this->load->view('jabatan_struktural/footer_draft_pelantikan');
        }else{
            $this->load->view('layout/header', array( 'title' => 'Jabatan Struktural'));
            $data =array('idd'=> $id_draft, 'pwdsalah'=>'');
            $this->load->view('jabatan_struktural/login_draft', $data);
            $this->load->view('layout/footer');
        }
    }

    public function pengaturan(){
        $rekap='';
        $jabatan_kosong = '';

        //$this->load->model('jabatan_model');
        //$jabatan_kosong = $this->jabatan_model->get_jabatan_struktural_kosong();
        //$rekap = $this->jabatan_model->rekap_jabatan_struktural();
        //$rekap = $this->hukuman_model->recap_tingkat_hukuman_per_tahun();

        $this->load->model('Baperjakat_model');

        if (isset($_POST['save_update'])) {
            $formNameEdit = $this->input->post('formNameEdit');
            $formNameEdit = explode("_", $formNameEdit);
            $nosk_tim = $this->input->post('no_sk_'.$formNameEdit[2]);
            $pengesah = $this->input->post('pengesah_'.$formNameEdit[2]);
            $pejabat = $this->input->post('pejabat_'.$formNameEdit[2]);
            $id_baperjakat = $this->Baperjakat_model->updateBaperjakat($nosk_tim, $pengesah, $pejabat, $formNameEdit[2]);
            if(isset($id_baperjakat)){
                for ($x = 1; $x <= 7; $x++) {
                    $idDetBaper = $_POST['txtIdDetBaper_'.$x.'_'.$formNameEdit[2]];
                    $data = array(
                        'idpegawai' => $this->input->post('txtTim_'.$x.'_'.$formNameEdit[2]),
                        'id_j' => $this->input->post('txtIdj_'.$x.'_'.$formNameEdit[2]),
                        'id_detbaperjakat' => $idDetBaper
                    );
                    $this->Baperjakat_model->updateBaperjakatDetail($data);
                }
            }
            if(isset($id_baperjakat) > 0){
                $id_baperjakat = 'tersimpan';
            }
        }elseif (isset($_POST['delete'])) {
            $formNameEdit = $this->input->post('formNameEdit');
            $formNameEdit = explode("_", $formNameEdit);
            $id_baperjakat = $this->Baperjakat_model->deleteBaperjakat($formNameEdit[2]);
            if(isset($id_baperjakat) > 0){
                $id_baperjakat = 'terhapus';
            }
        }elseif (isset($_POST['new_register'])) {
            $nosk_tim = $this->input->post('nosk_tim');
            $pengesah = $this->input->post('pengesah');
            $pejabat = $this->input->post('pejabat');
            $id_baperjakat = $this->Baperjakat_model->insertBaperjakat($nosk_tim, $pengesah, $pejabat);
            if(isset($id_baperjakat)){
                for ($x = 1; $x <= 7; $x++) {
                    $tim_baper[$x] = $_POST['txtTim'.$x];
                    $data = array(
                        'idpegawai' => $this->input->post('txtTim'.$x),
                        'id_j' => $this->input->post('txtIdj'.$x),
                        'idstatus_keanggotaan' => $x,
                        'id_baperjakat' => $id_baperjakat
                    );
                    $this->Baperjakat_model->insertBaperjakatDetail($data);
                }
            }
            if(isset($id_baperjakat) > 0){
                $id_baperjakat = 'tersimpan';
            }
        }

        $baperjakat_list = $this->Baperjakat_model->get_all();
        $listPangkat = $this->Baperjakat_model->getPangkat();
        $listJabatan = $this->Baperjakat_model->getJabatan();
        $listUnit = $this->Baperjakat_model->getUnitKerja();

        $this->load->view('layout/header', array( 'title' => 'Pengaturan Jabatan Struktural'));
        //$this->load->view('jabatan_struktural/header');
        $this->load->view('jabatan_struktural/pengaturan',
            array(
                'listPangkat' => $listPangkat,
                'listJabatan' => $listJabatan,
                'listUnit' => $listUnit,
                'baperjakat_list' => $baperjakat_list,
                'tx_result' => (isset($id_baperjakat) ? $id_baperjakat : '')
            ));
        $this->load->view('layout/footer');
    }

    public function informasi_baperjakat(){
        $idbaperjakat = $this->input->post('idbaperjakat');

        $this->load->model('Baperjakat_model');
        $info_baperjakat = $this->Baperjakat_model->getInfoBaperjakat($idbaperjakat);
        $detail_baperjakat = $this->Baperjakat_model->getDetailBaperjakat($idbaperjakat);

        $this->load->view('jabatan_struktural/detail_baperjakat', array(
            'info_baperjakat' => $info_baperjakat,
            'detail_baperjakat' => $detail_baperjakat
        ));
    }

    public function cari_pegawai(){
        $this->load->library('pager');
        $pages = new Paginator;
        $pagePaging = $_POST['page'];
        $ipp = $_POST['ipp'];
        if($pagePaging==0 or $pagePaging==""){
            $pagePaging = 1;
        }
        if($ipp==0 or $ipp==""){
            $ipp = $pages->default_ipp;
        }
        $_SESSION['ippPager'] = $ipp;
        $_SESSION['pagePager'] = $pagePaging;
        $this->load->model('Baperjakat_model');

        $cboPangkat = $_POST['cboPangkat'];
        $cboJabatan = $_POST['cboJabatan'];
        $cboUnit = $_POST['cboUnit'];
        $txtKeyword = $_POST['txtKeyword'];

        $jmlData = $this->Baperjakat_model->getCountAllFindPegawai($cboPangkat, $txtKeyword, $cboJabatan, $cboUnit);
        if($jmlData>0){
            $pages->items_total = $jmlData;
            $pages->paginate();
            $pgDisplay = $pages->display_pages();
            $itemPerPage = $pages->display_items_per_page();
            $curpage = $pages->current_page;
            $numpage = $pages->num_pages;
            $jumppage = $pages->display_jump_menu();
        }else{
            $pgDisplay = '';
            $itemPerPage = '';
            $curpage = '';
            $numpage = '';
            $jumppage = '';
        }

        if($pagePaging == 1){
            $start_number = 0;
        }else{
            $ipp = explode("&&", $ipp);
            $ipp = $ipp[0];
            $start_number = ($pagePaging * $ipp) - $ipp;
        }

        if($pages->current_page==0){
            $pages->limit = 'LIMIT 0,10';
        }

        $data_cari_pegawai = $this->Baperjakat_model->getFindPegawai($start_number, $cboPangkat, $txtKeyword, $cboJabatan, $cboUnit, $pages->limit, $pages->posisi);
        $this->load->view('jabatan_struktural/cari_pegawai', array(
            'cari_pegawai' => $data_cari_pegawai,
            'pgDisplay' => $pgDisplay,
            'curpage' => $curpage,
            'numpage' => $numpage,
            'jumppage' => $jumppage,
            'jmlData' => $jmlData
        ));
    }

    public function info_pegawai(){
        $this->load->model('Baperjakat_model');
        $idpegawai = $_POST['idpegawai'];
        $info_pegawai = $this->Baperjakat_model->infoPegawai($idpegawai);
        foreach($info_pegawai as $ip) {
            $data[] = array(
                'id_pegawai' => $ip->id_pegawai,
                'nama' => $ip->nama,
                'nip_baru' => $ip->nip_baru,
                'pangkat_gol' => $ip->pangkat_gol,
                'id_j' => $ip->id_j,
                'jabatan' => $ip->jabatan,
                'unit_kerja' => $ip->unit_kerja
            );
        }
        echo json_encode($data);
    }

    public function potensi_kosong($id_draft){
        $this->load->view('layout/header', array( 'title' => 'Jabatan Struktural Kosong'));
        $this->load_header_draft_pelantikan($id_draft);
        $this->load->model('draft_pelantikan_model');
        $jabatan_kosong = $this->draft_pelantikan_model->get_jabatan_potensi_kosong();
        $this->load->view('jabatan_struktural/jabatan_potensi_kosong',
            array(
                'id_draft' => $id_draft,
                'jabatan_kosong' => $jabatan_kosong
            ));
        $this->load->view('layout/footer');
    }

    public function pegawai_rangkap_jabatan($id_draft){
        $this->load->view('layout/header', array( 'title' => 'Jabatan Struktural Kosong'));
        $this->load_header_draft_pelantikan($id_draft);
        $this->load->model('draft_pelantikan_model');
        $pegawai_rangkap = $this->draft_pelantikan_model->get_pegawai_rangkap_jabatan($id_draft);
        $this->load->view('jabatan_struktural/pegawai_rangkap_jabatan',
            array(
                'id_draft' => $id_draft,
                'pegawai_rangkap' => $pegawai_rangkap
            ));
        $this->load->view('layout/footer');
    }

    public function riwayat_pengubahan_jabatan($id_draft){
        $this->load->view('layout/header', array( 'title' => 'Jabatan Struktural Kosong'));
        $this->load_header_draft_pelantikan($id_draft);
        $this->load->model('draft_pelantikan_model');
        $jabatan_rangkap = $this->draft_pelantikan_model->getdraft_pelantikan_temporary($id_draft);
        $this->load->view('jabatan_struktural/jabatan_rangkap_pegawai',
            array(
                'id_draft' => $id_draft,
                'jabatan_rangkap' => $jabatan_rangkap
            ));
        $this->load->view('layout/footer');
    }

    public function log_aktifitas($id_draft){
        $this->load->view('layout/header', array( 'title' => 'Log Aktifitas'));
        $this->load_header_draft_pelantikan($id_draft);
        $this->load->model('draft_pelantikan_model');
        $log_aktifitas = $this->draft_pelantikan_model->get_log_aktifitas($id_draft);
        $this->load->view('jabatan_struktural/log_aktifitas',
            array(
                'id_draft' => $id_draft,
                'log_aktifitas' => $log_aktifitas
            ));
        $this->load->view('layout/footer');
    }

    public function selesai($id_draft){
        $this->load->view('layout/header', array( 'title' => 'Selesai Pelantikan'));
        $this->load_header_draft_pelantikan($id_draft);
        $this->load->view('jabatan_struktural/selesai_pelantikan',null);
        $this->load->view('jabatan_struktural/footer_draft_pelantikan');
    }

    public function refresh_jabatan_kosong($id_draft){
        $this->load->view('layout/header', array( 'title' => 'Jabatan Kosong Baru'));
        $this->load->model('draft_pelantikan_model');
        $submitok = $this->input->post('submitok');
        if(isset($submitok) and $submitok==1){
            $data = array(
                'id_jab' => $this->input->post('txtIdJab')
            );
            $update = $this->draft_pelantikan_model->update_jabatan_kosong_baru($data, $id_draft);
            $tx_result = $update;
        }else{
            $tx_result = '';
        }
        $this->load_header_draft_pelantikan($id_draft);
        $hasil_kompare = $this->draft_pelantikan_model->compare_draft_with_existing($id_draft);

        $this->load->view('jabatan_struktural/compare_draft_with_existing',
            array(
                'id_draft' => $id_draft,
                'hasil_kompare' => $hasil_kompare,
                'tx_result' => $tx_result
            ));
        $this->load->view('jabatan_struktural/footer_draft_pelantikan');
    }

    public function cetak_nominatif_draft($id_draft, $eselon){
        $this->load->model('Terbilang_model', 'terbilang');
        $this->load->view('jabatan_struktural/cetak_nominatif_draft', array(
            'id_draft' => $id_draft,
            'eselon' => $eselon
        ));
    }

    public function list_jabatan_plt(){
        $this->load->view('layout/header', array( 'title' => 'Manajemen Data Jabatan PLT', 'idproses' => 1));
        $this->load->view('jabatan_struktural/header_plt_plh');
        $this->load->model('jabatan_model');

        $stsAktif = $this->input->get('stsAktif');
        $eselon = $this->input->get('eselon');
        $keywordCari = $this->input->get('keywordCari');
        $num_rows = $this->jabatan_model->get_count_jabatan_plt($stsAktif,$eselon,$keywordCari);
        if($num_rows>0){
            $this->load->library('pagerv2');
            $pages = new Paginator($num_rows,9,array(10,3,6,9,15,25,50,100,'All'));
            $pgDisplay = $pages->display_pages();
            $curpage = $pages->current_page;
            $numpage = $pages->num_pages;
            $total_items = $pages->total_items;
            $jumppage = $pages->display_jump_menu();
            $item_perpage = $pages->display_items_per_page();
            $list_data = $this->jabatan_model->get_jabatan_plt($pages->limit_start,$pages->limit_end,$stsAktif,$eselon,$keywordCari);
        }else{
            $pgDisplay = '';
            $curpage = '';
            $numpage = '';
            $total_items = '';
            $jumppage = '';
            $item_perpage = '';
            $list_data = '';
        }


        $this->load->view('jabatan_struktural/jabatan_plt',
            array(
                'list_data' => $list_data,
                'pgDisplay' => $pgDisplay,
                'curpage' => $curpage,
                'numpage' => $numpage,
                'total_items' => $total_items,
                'jumppage' => $jumppage,
                'item_perpage' => $item_perpage,
                'stsAktif' => $stsAktif,
                'eselon' => $eselon,
                'keywordCari' => $keywordCari
            ));
        $this->load->view('layout/footer');
    }

    public function list_jabatan_plh(){
        $this->load->view('layout/header', array( 'title' => 'Manajemen Data Jabatan PLH', 'idproses' => 2));
        $this->load->view('jabatan_struktural/header_plt_plh');
        $this->load->model('jabatan_model');

        $stsAktif = $this->input->get('stsAktif');
        $eselon = $this->input->get('eselon');
        $keywordCari = $this->input->get('keywordCari');
        $num_rows = $this->jabatan_model->get_count_jabatan_plh($stsAktif,$eselon,$keywordCari);
        if($num_rows>0){
            $this->load->library('pagerv2');
            $pages = new Paginator($num_rows,9,array(10,3,6,9,15,25,50,100,'All'));
            $pgDisplay = $pages->display_pages();
            $curpage = $pages->current_page;
            $numpage = $pages->num_pages;
            $total_items = $pages->total_items;
            $jumppage = $pages->display_jump_menu();
            $item_perpage = $pages->display_items_per_page();
            $list_data = $this->jabatan_model->get_jabatan_plh($pages->limit_start,$pages->limit_end,$stsAktif,$eselon,$keywordCari);
        }else{
            $pgDisplay = '';
            $curpage = '';
            $numpage = '';
            $total_items = '';
            $jumppage = '';
            $item_perpage = '';
            $list_data = '';
        }


        $this->load->view('jabatan_struktural/jabatan_plh',
            array(
                'list_data' => $list_data,
                'pgDisplay' => $pgDisplay,
                'curpage' => $curpage,
                'numpage' => $numpage,
                'total_items' => $total_items,
                'jumppage' => $jumppage,
                'item_perpage' => $item_perpage,
                'stsAktif' => $stsAktif,
                'eselon' => $eselon,
                'keywordCari' => $keywordCari
            ));
        $this->load->view('layout/footer');
    }

    public function tambah_jabatan_plt(){
        $this->load->view('layout/header', array( 'title' => 'Manajemen Data Jabatan PLT', 'idproses' => 1));
        $this->load->view('jabatan_struktural/header_plt_plh');
        $this->load->model('jabatan_model');
        $judulPltPlh = 'Pelaksana Tugas (PLT)';
        $this->load->view('jabatan_struktural/tambah_data_jabatan_plt',
            array(
                'judul' => 'PLT',
                'judulPltPlh' => $judulPltPlh
            ));
        $this->load->view('layout/footer');
    }

    public function cetak_nominatif_jabatan_plt($stsAktif, $eselon, $keywordCari){

    }

    public function ubah_data_jabatan_plt(){
        $this->load->model('jabatan_model');
        $idj_plt = $this->input->post('id_jabatan_plt');
        $listdata = $this->jabatan_model->get_jabatan_plt_by_id($idj_plt);
        $this->load->view('jabatan_struktural/ubah_jabatan_plt',
            array(
                'list_data' => $listdata
            ));
    }

    public function hapus_data_jabatan_plt(){
        $this->load->model('jabatan_model');
        $id = $this->input->post('id_diklat');
        if($this->jabatan_model->hapus_data_jabatan_plt($id)){
            echo "BERHASIL";
        }else{
            $error = $this->db->error();
            echo "ERROR : ".$error['message'];
        }
    }

    public function tambah_jabatan_plh(){
        $this->load->view('layout/header', array( 'title' => 'Manajemen Data Jabatan PLH', 'idproses' => 2));
        $this->load->view('jabatan_struktural/header_plt_plh');
        $this->load->model('jabatan_model');
        $judulPltPlh = 'Pelaksana Harian (PLH)';
        $this->load->view('jabatan_struktural/tambah_data_jabatan_plt',
            array(
                'judul' => 'PLH',
                'judulPltPlh' => $judulPltPlh
            ));
        $this->load->view('layout/footer');
    }

    public function cetak_nominatif_jabatan_plh($stsAktif, $eselon, $keywordCari){

    }

    public function list_open_bidding(){
        $this->load->view('layout/header', array( 'title' => 'Manajemen Data Open Bidding', 'idproses' => 1));
        $this->load->view('jabatan_struktural/header_open_bidding');
        $this->load->model('jabatan_model');
        $list_data = $this->jabatan_model->get_open_bidding();
        $this->load->view('jabatan_struktural/open_bidding',
            array(
                'list_data' => $list_data
            ));
        $this->load->view('layout/footer');
    }

    public function add_open_bidding(){
        $this->load->view('layout/header', array( 'title' => 'Manajemen Data Open Bidding', 'idproses' => 2));
        $this->load->view('jabatan_struktural/header_open_bidding');
        $this->load->model('jabatan_model');

        $submitok = $this->input->post('submitok');
        if(isset($submitok) and $submitok==1){
            $data = array(
                'keterangan' => $this->input->post('txtKeterangan'),
                'tmt_berlaku' => $this->input->post('tmt_berlaku'),
                'ddStatusAktif' => $this->input->post('ddStatusAktif'),
                'chkIdPegawaiPilih' => $this->input->post('chkIdPegawaiPilih')
            );
            $insert = $this->jabatan_model->tambah_open_bidding($data);
            $tx_result = $insert['query'];
            if($tx_result == 1){
                if(isset($_FILES["fileSkOpenBid"])) {
                    if($_FILES["fileSkOpenBid"] <> "" ){
                        if($_FILES["fileSkOpenBid"]['type']=='binary/octet-stream' or $_FILES["fileSkOpenBid"]['type'] == "application/pdf" ){
                            if ($_FILES["fileSkOpenBid"]['size'] > 20097152) {
                                $upload_status = 'File tidak terupload. Ukuran file terlalu besar';
                                $upload_kode = 1;
                            }else{
                                $uploaddir = '/var/www/html/simpeg2/Berkas/';
                                $uploadfile = $uploaddir . basename($_FILES["fileSkOpenBid"]['name']);

                                $connection = ssh2_connect('103.14.229.15');
                                ssh2_auth_password($connection, 'rommonz', 'mony3Tmony3T');
                                $sftp = ssh2_sftp($connection);

                                if(ssh2_scp_send($connection, $_FILES["fileSkOpenBid"]['tmp_name'], $uploadfile, 0644)){
                                    $sqlUpdate = "update draft_pelantikan_open_bidding set berkas = 'OPNBID-".$insert['idopenbd'].".pdf' where id_open_bidding=".$insert['idopenbd'];
                                    $this->db->query($sqlUpdate);
                                    if ($this->db->trans_status() === FALSE){
                                        $this->db->trans_rollback();
                                    }else{
                                        $this->db->trans_commit();
                                        ssh2_sftp_rename($sftp, $uploadfile,$uploaddir.'OPNBID-'.$insert['idopenbd'].'.pdf');
                                        $upload_status = 'Data sukses terupload';
                                        $upload_kode = 2;
                                    }
                                }else{
                                    $upload_status = 'File tidak terupload. Ada permasalahan ketika mengakses jaringan.';
                                    $upload_kode = 1;
                                }
                            }
                        }else{
                            $upload_status = 'File tidak terupload. Tipe file belum sesuai.';
                            $upload_kode = 1;
                        }
                    }else{
                        $upload_kode = '';
                        $upload_status = '';
                    }
                }else{
                    $upload_kode = '';
                    $upload_status = '';
                }
            }else{
                $tx_result = 2;
                $upload_kode = '';
                $upload_status = '';
            }
        }else{
            $tx_result = '';
            $upload_kode = '';
            $upload_status = '';
        }

        $this->load->view('jabatan_struktural/open_bidding_add',
            array(
                'tx_result' => $tx_result,
                'upload_kode' => $upload_kode,
                'upload_status' => $upload_status
            ));
        $this->load->view('layout/footer');
    }

    public function cari_pegawai_calon_open_bidding(){
        $this->load->library('pager');
        $pages = new Paginator;
        $pagePaging = $_POST['page'];
        $ipp = $_POST['ipp'];
        if($pagePaging==0 or $pagePaging==""){
            $pagePaging = 1;
        }
        if($ipp==0 or $ipp==""){
            $ipp = $pages->default_ipp;
        }
        $_SESSION['ippPager'] = $ipp;
        $_SESSION['pagePager'] = $pagePaging;
        $this->load->model('jabatan_model');
        $jenjab = $_POST['jenjab'];
        $gol = $_POST['gol'];
        $keyword = $_POST['keyword'];

        $jmlData = $this->jabatan_model->count_list_pegawai_for_open_bidding($jenjab, $gol, $keyword);
        if($jmlData>0){
            $pages->items_total = $jmlData;
            $pages->paginate();
            $pgDisplay = $pages->display_pages();
            $itemPerPage = $pages->display_items_per_page();
            $curpage = $pages->current_page;
            $numpage = $pages->num_pages;
            $jumppage = $pages->display_jump_menu();
        }else{
            $pgDisplay = '';
            $itemPerPage = '';
            $curpage = '';
            $numpage = '';
            $jumppage = '';
        }

        if($pagePaging == 1){
            $start_number = 0;
        }else{
            $ipp = explode("&&", $ipp);
            $ipp = $ipp[0];
            $start_number = ($pagePaging * $ipp) - $ipp;
        }

        if($pages->current_page==0){
            $pages->limit = 'LIMIT 0,10';
        }

        $data_cari_pegawai = $this->jabatan_model->list_pegawai_for_open_bidding($start_number, $jenjab, $gol, $keyword, $pages->limit);
        $this->load->view('jabatan_struktural/cari_pegawai_open_bidding', array(
            'cari_pegawai' => $data_cari_pegawai,
            'pgDisplay' => $pgDisplay,
            'curpage' => $curpage,
            'numpage' => $numpage,
            'jumppage' => $jumppage,
            'jmlData' => $jmlData
        ));

    }

    public function ubah_data_open_bidding(){
        $id_open_bidding = $this->input->post('id_open_bidding');

    }

    public function add_open_bidding_detail(){
        $this->load->model('jabatan_model');
        $id_open_bidding = $this->input->post('id_open_bidding');
        $list_data = $this->jabatan_model->get_open_bidding($id_open_bidding);
        $this->load->view('jabatan_struktural/drop_add_open_bidding_detail', array(
            'list_data' => $list_data
        ));
    }

    public function json_find_pegawai(){
        $this->load->model('jabatan_model');
        $pegawai = $this->jabatan_model->get_by_nama_pegawai($this->input->get('q'));
        if($pegawai==''){
            $data[] = array(
                'label' => 'Pegawai tidak ditemukan',
                'value' => '',
                'nip' => '',
                'gol' => '',
                'jenjab' => '',
                'uker' => '',
                'jabatan' => ''
            );
        }else{
            foreach($pegawai as $p) {
                $data[] = array(
                    'label' => $p->nama_gelar,
                    'value' => $p->id_pegawai,
                    'nip' => $p->nip_baru,
                    'gol' => $p->pangkat_gol,
                    'jenjab' => $p->jenjab,
                    'uker' => $p->unit,
                    'jabatan' => $p->jabatan_peg
                );
            }
        }
        echo json_encode($data);
    }

    public function hapus_data_detail_open_bidding(){
        $this->load->model('jabatan_model');
        $id_open_bidding_detail = $_POST['id_open_bidding_detail'];
        $update = $this->jabatan_model->hapus_detail_open_bidding($id_open_bidding_detail);
        if($update){
            echo 1;
        }else{
            $error = $this->db->error();
            echo "ERROR : ".$error['message'];
        }
    }

    public function load_openbidding_by_id_on_list(){
        $this->load->model('jabatan_model');
        $id_open_bidding = $_POST['id_open_bidding'];
        $no_urut = $_POST['no_urut'];
        $list_data = $this->jabatan_model->get_open_bidding($id_open_bidding);
        $this->load->view('jabatan_struktural/drop_openbidding_by_id', array(
            'list_data' => $list_data,
            'no_urut' => $no_urut
        ));
    }

    public function hapus_data_open_bidding(){
        $this->load->model('jabatan_model');
        $id_open_bidding = $_POST['id_open_bidding'];
        $update = $this->jabatan_model->hapus_open_bidding($id_open_bidding);
        if($update){
            echo 1;
        }else{
            $error = $this->db->error();
            echo "ERROR : ".$error['message'];
        }
    }

}

/* End of file jabatan_struktural.php */
/* Location: ./application/controllers/jabatan_struktural.php */
