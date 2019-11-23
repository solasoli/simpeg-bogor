<?php
class Ekinerja_model extends CI_Model{

    var $api_key = 'edcfb2bc7bd4e16ccb19a40dda2af709';
    var $websimpeg_url = "http://simpeg.kotabogor.go.id";
    var $const_http = 'http';
    var $serverName;
    var $curr_addr;
    var $url_data_dasar;
    var $url_insert_aktifitas;
    var $url_list_kinerja_master;
    var $url_hapus_kinerja_master;
    var $url_detail_laporan_kinerja;
    var $url_stk_skp_by_kode_jabatan;
    var $url_update_nama_file_kegiatan;
    var $url_list_aktifitas_by_id;
    var $url_ubah_aktifitas;
    var $url_hapus_aktifitas;
    var $url_get_idknj_master_by_idp;
    var $url_skp_pegawai_last;
    var $url_list_hist_alih_tugas_by_id_pegawai;
    var $url_jml_hist_alih_tugas;
    var $url_list_hist_alih_tugas_by_id_knj;
    var $url_list_golongan;
    var $url_list_unit_kerja;
    var $url_update_aktifitas;
    var $url_info_last_skp;
    var $url_skp_by_id;
    var $url_info_last_skp_by_id;
    var $url_hapus_hist_alih_tugas;
    var $url_satuan_output;
    var $url_hist_absen_kehadiran_apel;
    var $url_kalkulasi_nilai_kinerja;
    var $url_daftar_staf_aktual_kinerja;
    var $url_jml_peninjauan_aktifitas_staf;
    var $url_daftar_peninjauan_aktifitas_staf;
    var $url_jml_aktifitas_per_periode;
    var $url_daftar_aktifitas_per_periode;
    var $url_proses_aktifitas_kegiatan_by_id;
    var $url_aktifitas_kegiatan_by_id;
    var $url_insert_peninjauan_aktifitas_check_all;
    var $url_hapus_berkas_aktifitas;
    var $url_cek_jab_tgi_pratama_admin;
    var $url_wkt_selesai_kegiatan_terakhir;
    var $url_get_nomor_ponsel;
    var $url_get_info_kegiatan_send_whatsapp;
    var $url_daftar_pegawai_tipe_lokasi;
    var $url_jml_pegawai_tipe_lokasi;
    var $url_list_hist_alih_tugas_detail_calc_by_id_knj;
    var $url_detail_nilai_tunjangan_by_hist_alih_tugas;
    var $url_info_unit_kerja_utama_pegawai;
    var $url_info_unit_kerja_sekunder_pegawai;
    var $url_ubah_tipe_lokasi_pegawai;
    var $url_get_unit_sekunder_by_term;
    var $url_info_unit_sekunder_by_id;
    var $url_insert_unit_sekunder_pegawai;
    var $url_hapus_unit_sekunder_pegawai;
    var $url_update_nama_file_spmt_clkl;
    var $url_insert_unit_sekunder_baru_pegawai;
    var $url_list_unit_kerja_sekunder;
    var $url_insert_unit_sekunder_baru_lokasi;
    var $url_hapus_unit_sekunder_lokasi;
    var $url_ubah_uk_sekunder;
    var $url_update_unit_kerja_sekunder;
    var $url_list_jadwal_khusus;
    var $url_jenis_jadwal;
    var $url_insert_jadwal_khusus;
    var $url_ubah_jadwal_khusus;
    var $url_jml_pegawai_opd;
    var $url_list_pegawai_opd;
    var $url_jml_jadwal_khusus;
    var $url_update_nama_file_spmt_jdwl_spmt;
    var $url_update_jadwal_khusus;
    var $url_detail_laporan_kinerja_by_hist_alih_tugas;
    var $url_info_pegawai_byidp;
    var $url_jml_jadwal_khusus_spmt;
    var $url_list_jadwal_khusus_spmt;
    var $url_hapus_jadwal_khusus;
    var $url_insert_jadwal_khusus_trans;
    var $url_daftar_jadwaltrans_kalender_by_opd;
    var $url_hapus_jadwal_trans;
    var $url_unit_kerja_jadwal_transaksi;
    var $url_ubah_jadwal_transaksi;
    var $url_update_detail_jadwal_khusus;
    var $url_jml_item_lainnya_kinerja;
    var $url_daftar_item_lainnya_kinerja;
    var $url_jenis_item_lainnya;
    var $url_hapus_unit_kerja_jadwal;
    var $url_status_item_lainnya;
    var $url_insert_item_lainnya;
    var $url_update_nama_file_sk_item_lainnya;
    var $url_ubah_item_lainnya;
    var $url_update_item_lainnya;
    var $url_hapus_item_lainnya;
    var $url_riwayat_skp;
    var $url_skp_header;
    var $url_skp_target;
    var $url_skp_tambahan;
    var $url_laporan_kinerja_selesai;
    var $url_riwayat_staf_ekinerja;
    var $url_daftar_pegawai_info_kinerja;
    var $url_jml_pegawai_info_kinerja;
    var $url_daftar_item_lainnya_kinerja_by_idp;
    var $url_jml_laporan_kinerja_pegawai_opd;
    var $url_daftar_laporan_kinerja_pegawai_opd;
    var $url_daftar_inputer_jadwal;
    var $url_cetak_laporan_kinerja_pegawai_opd;
    var $url_get_pegawai_by_term;
    var $url_insert_logabsen_byidpegawai_wkt;
    var $url_hapus_logabsen_byidpegawai_wkt;
    var $url_pencapaian_kinerja_curr;
    var $url_status_aktifitas_curr;
    var $url_aktifitas_curr_stafnya;
    var $url_jml_laporan_kinerja_pegawai;
    var $url_daftar_laporan_kinerja_pegawai;
    var $url_jml_aktifitas_by_id;
    var $url_daftar_aktifitas_by_id;
    var $url_daftar_opd;
    var $url_jml_daftar_unit_kerja_sekunder_by_opd;
    var $url_list_daftar_unit_kerja_sekunder_by_opd;
    var $url_riwayat_staf_plh;
    var $url_list_kinerja_master_plh;
    var $url_jml_peninjauan_aktifitas_staf_plh;
    var $url_daftar_peninjauan_aktifitas_staf_plh;
    var $url_hist_alih_tugas_kinerja_by_id;

    public function __Construct(){
        parent::__Construct();
        date_default_timezone_set("Asia/Bangkok");
        $this->serverName = $_SERVER['SERVER_NAME'];
        $this->curr_addr = $_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
        $this->url_data_dasar = "$this->websimpeg_url/rest/E_kinerja/exec_running_methode/85/".$this->api_key;
        $this->url_insert_aktifitas = "$this->websimpeg_url/rest/E_kinerja/exec_running_methode/86/".$this->api_key;
        $this->url_list_kinerja_master = "$this->websimpeg_url/rest/E_kinerja/exec_running_methode/87/".$this->api_key;
        $this->url_hapus_kinerja_master = "$this->websimpeg_url/rest/E_kinerja/exec_running_methode/88/".$this->api_key;
        $this->url_detail_laporan_kinerja = "$this->websimpeg_url/rest/E_kinerja/exec_running_methode/91/".$this->api_key;
        $this->url_stk_skp_by_kode_jabatan = "$this->websimpeg_url/rest/E_kinerja/exec_running_methode/92/".$this->api_key;
        $this->url_update_nama_file_kegiatan = "$this->websimpeg_url/rest/E_kinerja/exec_running_methode/93/".$this->api_key;
        $this->url_list_aktifitas_by_id = "$this->websimpeg_url/rest/E_kinerja/exec_running_methode/94/".$this->api_key;
        $this->url_ubah_aktifitas = "$this->websimpeg_url/rest/E_kinerja/exec_running_methode/95/".$this->api_key;
        $this->url_hapus_aktifitas = "$this->websimpeg_url/rest/E_kinerja/exec_running_methode/96/".$this->api_key;
        $this->url_get_idknj_master_by_idp = "$this->websimpeg_url/rest/E_kinerja/exec_running_methode/97/".$this->api_key;
        $this->url_skp_pegawai_last = "$this->websimpeg_url/rest/E_kinerja/exec_running_methode/98/".$this->api_key;
        $this->url_list_hist_alih_tugas_by_id_pegawai = "$this->websimpeg_url/rest/E_kinerja/exec_running_methode/99/".$this->api_key;
        $this->url_jml_hist_alih_tugas = "$this->websimpeg_url/rest/E_kinerja/exec_running_methode/100/".$this->api_key;
        $this->url_list_hist_alih_tugas_by_id_knj = "$this->websimpeg_url/rest/E_kinerja/exec_running_methode/101/".$this->api_key;
        $this->url_list_golongan = "$this->websimpeg_url/rest/pegawai/exec_running_methode/103/".$this->api_key;
        $this->url_list_unit_kerja = "$this->websimpeg_url/rest/unit_kerja/exec_running_methode/102/".$this->api_key;
        $this->url_update_aktifitas = "$this->websimpeg_url/rest/E_kinerja/exec_running_methode/105/".$this->api_key;
        $this->url_info_last_skp = "$this->websimpeg_url/rest/E_kinerja/exec_running_methode/106/".$this->api_key;
        $this->url_skp_by_id = "$this->websimpeg_url/rest/E_kinerja/exec_running_methode/107/".$this->api_key;
        $this->url_info_last_skp_by_id = "$this->websimpeg_url/rest/E_kinerja/exec_running_methode/108/".$this->api_key;
        $this->url_hapus_hist_alih_tugas = "$this->websimpeg_url/rest/E_kinerja/exec_running_methode/109/".$this->api_key;
        $this->url_satuan_output = "$this->websimpeg_url/rest/E_kinerja/exec_running_methode/110/".$this->api_key;
        $this->url_hist_absen_kehadiran_apel = "$this->websimpeg_url/rest/E_kinerja/exec_running_methode/111/".$this->api_key;
        $this->url_kalkulasi_nilai_kinerja = "$this->websimpeg_url/rest/E_kinerja/exec_running_methode/112/".$this->api_key;
        $this->url_daftar_staf_aktual_kinerja = "$this->websimpeg_url/rest/E_kinerja/exec_running_methode/113/".$this->api_key;
        $this->url_jml_peninjauan_aktifitas_staf = "$this->websimpeg_url/rest/E_kinerja/exec_running_methode/119/".$this->api_key;
        $this->url_daftar_peninjauan_aktifitas_staf = "$this->websimpeg_url/rest/E_kinerja/exec_running_methode/114/".$this->api_key;
        $this->url_jml_aktifitas_per_periode = "$this->websimpeg_url/rest/E_kinerja/exec_running_methode/115/".$this->api_key;
        $this->url_daftar_aktifitas_per_periode = "$this->websimpeg_url/rest/E_kinerja/exec_running_methode/116/".$this->api_key;
        $this->url_proses_aktifitas_kegiatan_by_id = "$this->websimpeg_url/rest/E_kinerja/exec_running_methode/117/".$this->api_key;
        $this->url_aktifitas_kegiatan_by_id = "$this->websimpeg_url/rest/E_kinerja/exec_running_methode/118/".$this->api_key;
        $this->url_insert_peninjauan_aktifitas_check_all = "$this->websimpeg_url/rest/E_kinerja/exec_running_methode/120/".$this->api_key;
        $this->url_hapus_berkas_aktifitas = "$this->websimpeg_url/rest/E_kinerja/exec_running_methode/121/".$this->api_key;
        $this->url_cek_jab_tgi_pratama_admin = "$this->websimpeg_url/rest/E_kinerja/exec_running_methode/122/".$this->api_key;
        $this->url_wkt_selesai_kegiatan_terakhir = "$this->websimpeg_url/rest/E_kinerja/exec_running_methode/123/".$this->api_key;
        $this->url_get_nomor_ponsel = "$this->websimpeg_url/rest/E_kinerja/exec_running_methode/124/".$this->api_key;
        $this->url_get_info_kegiatan_send_whatsapp = "$this->websimpeg_url/rest/E_kinerja/exec_running_methode/126/".$this->api_key;
        $this->url_daftar_pegawai_tipe_lokasi = "$this->websimpeg_url/rest/E_kinerja/exec_running_methode/125/".$this->api_key;
        $this->url_jml_pegawai_tipe_lokasi = "$this->websimpeg_url/rest/E_kinerja/exec_running_methode/127/".$this->api_key;
        $this->url_list_hist_alih_tugas_detail_calc_by_id_knj = "$this->websimpeg_url/rest/E_kinerja/exec_running_methode/128/".$this->api_key;
        $this->url_detail_nilai_tunjangan_by_hist_alih_tugas = "$this->websimpeg_url/rest/E_kinerja/exec_running_methode/129/".$this->api_key;
        $this->url_info_unit_kerja_utama_pegawai = "$this->websimpeg_url/rest/E_kinerja/exec_running_methode/130/".$this->api_key;
        $this->url_info_unit_kerja_sekunder_pegawai = "$this->websimpeg_url/rest/E_kinerja/exec_running_methode/131/".$this->api_key;
        $this->url_ubah_tipe_lokasi_pegawai = "$this->websimpeg_url/rest/E_kinerja/exec_running_methode/132/".$this->api_key;
        $this->url_get_unit_sekunder_by_term = "$this->websimpeg_url/rest/E_kinerja/exec_running_methode/133/".$this->api_key;
        $this->url_info_unit_sekunder_by_id = "$this->websimpeg_url/rest/E_kinerja/exec_running_methode/134/".$this->api_key;
        $this->url_insert_unit_sekunder_pegawai = "$this->websimpeg_url/rest/E_kinerja/exec_running_methode/135/".$this->api_key;
        $this->url_hapus_unit_sekunder_pegawai = "$this->websimpeg_url/rest/E_kinerja/exec_running_methode/136/".$this->api_key;
        $this->url_update_nama_file_spmt_clkl = "$this->websimpeg_url/rest/E_kinerja/exec_running_methode/137/".$this->api_key;
        $this->url_insert_unit_sekunder_baru_pegawai = "$this->websimpeg_url/rest/E_kinerja/exec_running_methode/138/".$this->api_key;
        $this->url_list_unit_kerja_sekunder = "$this->websimpeg_url/rest/E_kinerja/exec_running_methode/139/".$this->api_key;
        $this->url_insert_unit_sekunder_baru_lokasi = "$this->websimpeg_url/rest/E_kinerja/exec_running_methode/140/".$this->api_key;
        $this->url_hapus_unit_sekunder_lokasi = "$this->websimpeg_url/rest/E_kinerja/exec_running_methode/141/".$this->api_key;
        $this->url_ubah_uk_sekunder = "$this->websimpeg_url/rest/E_kinerja/exec_running_methode/142/".$this->api_key;
        $this->url_update_unit_kerja_sekunder = "$this->websimpeg_url/rest/E_kinerja/exec_running_methode/143/".$this->api_key;
        $this->url_list_jadwal_khusus = "$this->websimpeg_url/rest/E_kinerja/exec_running_methode/144/".$this->api_key;
        $this->url_jenis_jadwal = "$this->websimpeg_url/rest/E_kinerja/exec_running_methode/145/".$this->api_key;
        $this->url_insert_jadwal_khusus = "$this->websimpeg_url/rest/E_kinerja/exec_running_methode/146/".$this->api_key;
        $this->url_ubah_jadwal_khusus = "$this->websimpeg_url/rest/E_kinerja/exec_running_methode/147/".$this->api_key;
        $this->url_jml_pegawai_opd = "$this->websimpeg_url/rest/E_kinerja/exec_running_methode/148/".$this->api_key;
        $this->url_list_pegawai_opd = "$this->websimpeg_url/rest/E_kinerja/exec_running_methode/149/".$this->api_key;
        $this->url_jml_jadwal_khusus = "$this->websimpeg_url/rest/E_kinerja/exec_running_methode/150/".$this->api_key;
        $this->url_update_nama_file_spmt_jdwl_spmt = "$this->websimpeg_url/rest/E_kinerja/exec_running_methode/151/".$this->api_key;
        $this->url_update_jadwal_khusus = "$this->websimpeg_url/rest/E_kinerja/exec_running_methode/152/".$this->api_key;
        $this->url_detail_laporan_kinerja_by_hist_alih_tugas = "$this->websimpeg_url/rest/E_kinerja/exec_running_methode/153/".$this->api_key;
        $this->url_info_pegawai_byidp = "$this->websimpeg_url/rest/E_kinerja/exec_running_methode/154/".$this->api_key;
        $this->url_jml_jadwal_khusus_spmt = "$this->websimpeg_url/rest/E_kinerja/exec_running_methode/155/".$this->api_key;
        $this->url_list_jadwal_khusus_spmt = "$this->websimpeg_url/rest/E_kinerja/exec_running_methode/156/".$this->api_key;
        $this->url_hapus_jadwal_khusus = "$this->websimpeg_url/rest/E_kinerja/exec_running_methode/161/".$this->api_key;
        $this->url_insert_jadwal_khusus_trans = "$this->websimpeg_url/rest/E_kinerja/exec_running_methode/162/".$this->api_key;
        $this->url_daftar_jadwaltrans_kalender_by_opd = "$this->websimpeg_url/rest/E_kinerja/exec_running_methode/163/".$this->api_key;
        $this->url_hapus_jadwal_trans = "$this->websimpeg_url/rest/E_kinerja/exec_running_methode/164/".$this->api_key;
        $this->url_unit_kerja_jadwal_transaksi = "$this->websimpeg_url/rest/E_kinerja/exec_running_methode/165/".$this->api_key;
        $this->url_ubah_jadwal_transaksi = "$this->websimpeg_url/rest/E_kinerja/exec_running_methode/166/".$this->api_key;
        $this->url_update_detail_jadwal_khusus = "$this->websimpeg_url/rest/E_kinerja/exec_running_methode/167/".$this->api_key;
        $this->url_jml_item_lainnya_kinerja = "$this->websimpeg_url/rest/E_kinerja/exec_running_methode/168/".$this->api_key;
        $this->url_daftar_item_lainnya_kinerja = "$this->websimpeg_url/rest/E_kinerja/exec_running_methode/169/".$this->api_key;
        $this->url_jenis_item_lainnya = "$this->websimpeg_url/rest/E_kinerja/exec_running_methode/170/".$this->api_key;
        $this->url_hapus_unit_kerja_jadwal = "$this->websimpeg_url/rest/E_kinerja/exec_running_methode/172/".$this->api_key;
        $this->url_status_item_lainnya = "$this->websimpeg_url/rest/E_kinerja/exec_running_methode/173/".$this->api_key;
        $this->url_insert_item_lainnya = "$this->websimpeg_url/rest/E_kinerja/exec_running_methode/174/".$this->api_key;
        $this->url_update_nama_file_sk_item_lainnya = "$this->websimpeg_url/rest/E_kinerja/exec_running_methode/175/".$this->api_key;
        $this->url_ubah_item_lainnya = "$this->websimpeg_url/rest/E_kinerja/exec_running_methode/176/".$this->api_key;
        $this->url_update_item_lainnya = "$this->websimpeg_url/rest/E_kinerja/exec_running_methode/177/".$this->api_key;
        $this->url_hapus_item_lainnya = "$this->websimpeg_url/rest/E_kinerja/exec_running_methode/178/".$this->api_key;
        $this->url_riwayat_skp = "$this->websimpeg_url/rest/E_kinerja/exec_running_methode/179/".$this->api_key;
        $this->url_skp_header = "$this->websimpeg_url/rest/E_kinerja/exec_running_methode/180/".$this->api_key;
        $this->url_skp_target = "$this->websimpeg_url/rest/E_kinerja/exec_running_methode/181/".$this->api_key;
        $this->url_skp_tambahan = "$this->websimpeg_url/rest/E_kinerja/exec_running_methode/182/".$this->api_key;
        $this->url_laporan_kinerja_selesai = "$this->websimpeg_url/rest/E_kinerja/exec_running_methode/183/".$this->api_key;
        $this->url_riwayat_staf_ekinerja = "$this->websimpeg_url/rest/E_kinerja/exec_running_methode/184/".$this->api_key;
        $this->url_jml_pegawai_info_kinerja = "$this->websimpeg_url/rest/E_kinerja/exec_running_methode/185/".$this->api_key;
        $this->url_daftar_pegawai_info_kinerja = "$this->websimpeg_url/rest/E_kinerja/exec_running_methode/186/".$this->api_key;
        $this->url_daftar_item_lainnya_kinerja_by_idp = "$this->websimpeg_url/rest/E_kinerja/exec_running_methode/187/".$this->api_key;
        $this->url_jml_laporan_kinerja_pegawai_opd = "$this->websimpeg_url/rest/E_kinerja/exec_running_methode/189/".$this->api_key;
        $this->url_daftar_laporan_kinerja_pegawai_opd = "$this->websimpeg_url/rest/E_kinerja/exec_running_methode/190/".$this->api_key;
        $this->url_daftar_inputer_jadwal = "$this->websimpeg_url/rest/E_kinerja/exec_running_methode/192/".$this->api_key;
        $this->url_cetak_laporan_kinerja_pegawai_opd = "$this->websimpeg_url/rest/E_kinerja/exec_running_methode/193/".$this->api_key;
        $this->url_get_pegawai_by_term = "$this->websimpeg_url/rest/Pegawai/exec_running_methode/71/".$this->api_key;
        $this->url_insert_logabsen_byidpegawai_wkt = "$this->websimpeg_url/rest/E_kinerja/exec_running_methode/194/".$this->api_key;
        $this->url_hapus_logabsen_byidpegawai_wkt = "$this->websimpeg_url/rest/E_kinerja/exec_running_methode/195/".$this->api_key;
        $this->url_pencapaian_kinerja_curr = "$this->websimpeg_url/rest/E_kinerja/exec_running_methode/196/".$this->api_key;
        $this->url_status_aktifitas_curr = "$this->websimpeg_url/rest/E_kinerja/exec_running_methode/197/".$this->api_key;
        $this->url_aktifitas_curr_stafnya = "$this->websimpeg_url/rest/E_kinerja/exec_running_methode/198/".$this->api_key;
        $this->url_jml_laporan_kinerja_pegawai = "$this->websimpeg_url/rest/E_kinerja/exec_running_methode/199/".$this->api_key;
        $this->url_daftar_laporan_kinerja_pegawai = "$this->websimpeg_url/rest/E_kinerja/exec_running_methode/200/".$this->api_key;
        $this->url_jml_aktifitas_by_id = "$this->websimpeg_url/rest/E_kinerja/exec_running_methode/216/".$this->api_key;
        $this->url_daftar_aktifitas_by_id = "$this->websimpeg_url/rest/E_kinerja/exec_running_methode/217/".$this->api_key;
        $this->url_daftar_opd = "$this->websimpeg_url/rest/Unit_kerja/exec_running_methode/80/".$this->api_key;
        $this->url_jml_daftar_unit_kerja_sekunder_by_opd = "$this->websimpeg_url/rest/E_kinerja/exec_running_methode/218/".$this->api_key;
        $this->url_list_daftar_unit_kerja_sekunder_by_opd = "$this->websimpeg_url/rest/E_kinerja/exec_running_methode/219/".$this->api_key;
        $this->url_riwayat_staf_plh = "$this->websimpeg_url/rest/E_kinerja/exec_running_methode/220/".$this->api_key;
        $this->url_list_kinerja_master_plh = "$this->websimpeg_url/rest/E_kinerja/exec_running_methode/221/".$this->api_key;
        $this->url_jml_peninjauan_aktifitas_staf_plh = "$this->websimpeg_url/rest/E_kinerja/exec_running_methode/222/".$this->api_key;
        $this->url_daftar_peninjauan_aktifitas_staf_plh = "$this->websimpeg_url/rest/E_kinerja/exec_running_methode/223/".$this->api_key;
        $this->url_hist_alih_tugas_kinerja_by_id = "$this->websimpeg_url/rest/E_kinerja/exec_running_methode/224/".$this->api_key;
    }

    function multiRequestAPI(array $requests, $opts = array()){
        $chs = array();
        $opts += array(CURLOPT_CONNECTTIMEOUT => 3, CURLOPT_TIMEOUT => 3, CURLOPT_RETURNTRANSFER => 1);
        $responses = array();
        $mh = curl_multi_init();
        $running = null;

        foreach ($requests as $key => $request) {
            $chs[$key] = curl_init();
            $url = $request['url'];
            if (isset($request['post_data']) and sizeof($request['post_data']) > 0 and $request['post_data']!='') {
                curl_setopt($chs[$key], CURLOPT_POST, 1);
                curl_setopt($chs[$key], CURLOPT_POSTFIELDS, $request['post_array']);
            }
            if(isset($request['get_data']) and sizeof($request['get_data']) and $request['get_data']!=''){
                $url = sprintf("%s?%s", $url, http_build_query($request['get_data']['get_array']));
            }
            curl_setopt($chs[$key], CURLOPT_URL, $url);
            curl_setopt_array($chs[$key], (isset($request['opts']) ? $request['opts'] + $opts : $opts));
            curl_multi_add_handle($mh, $chs[$key]);
        }

        do {
            curl_multi_exec($mh, $running);
            curl_multi_select($mh);
        } while($running > 0);

        foreach ($chs as $key => $ch) {
            if (curl_errno($ch)) {
                $responses[$key] = array('data'=>null, 'info'=>null, 'error'=>curl_error($ch));
            } else {
                $responses[$key] = array('data'=>curl_multi_getcontent($ch), 'info' => curl_getinfo($ch), 'error' => null);
            }
            curl_multi_remove_handle($mh, $ch);
        }

        curl_multi_close($mh);
        return $responses;
    }

    function CallAPI($method, $url, $data = false){
        $curl = curl_init();
        switch ($method) {
            case "POST":
                curl_setopt($curl, CURLOPT_POST, 1);
                if ($data)
                    curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
                break;
            case "PUT":
                curl_setopt($curl, CURLOPT_PUT, 1);
                break;
            default:
                if ($data)
                    $url = sprintf("%s?%s", $url, http_build_query($data));
        }
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT ,0);
        curl_setopt($curl, CURLOPT_TIMEOUT, 400);
        set_time_limit(0);

        try {
            $result = curl_exec($curl);

            if (curl_error($curl)) {
                $error_msg = curl_error($curl);
            }
            curl_close($curl);
            if (isset($error_msg)) {
                print_r($error_msg);
                die;
            }
            //var_dump($result);
            return $result;
        }catch(Exception $e) {
            echo 'Message: ' .$e->getMessage();
        }
    }

    public static function safeDecode($data_ref){
        $data_ref = json_decode($data_ref);
        if ($data_ref === null
            && json_last_error() !== JSON_ERROR_NONE) {
            echo "incorrect data";
            switch (json_last_error()) {
                case JSON_ERROR_NONE:
                    //echo ' - No errors';
                    break;
                case JSON_ERROR_DEPTH:
                    echo ' - Maximum stack depth exceeded';
                    die;
                    break;
                case JSON_ERROR_STATE_MISMATCH:
                    echo ' - Underflow or the modes mismatch';
                    die;
                    break;
                case JSON_ERROR_CTRL_CHAR:
                    echo ' - Unexpected control character found';
                    die;
                    break;
                case JSON_ERROR_SYNTAX:
                    $data_ref = self::clean($data_ref);
                    $data_ref = json_decode($data_ref, TRUE, 512, JSON_BIGINT_AS_STRING);
                    if(self::isJSON($data_ref)){
                        $data_ref = $data_ref;
                    }else{
                        echo " - Syntax error, malformed JSON. Can't get data from server";
                        die;
                        break;
                    }
                    break;
                case JSON_ERROR_UTF8:
                    echo ' - Malformed UTF-8 characters, possibly incorrectly encoded';
                    die;
                    break;
                default:
                    echo ' - Unknown error';
                    die;
                    break;
            }
        }
        return $data_ref;
    }

    public static function isJSON($string){
        return is_string($string) && is_array(json_decode($string, true)) ? true : false;
    }

    public static function clean($jsonString){
        if (!is_string($jsonString) || !$jsonString) return '';

        // Remove unsupported characters
        // Check http://www.php.net/chr for details
        for ($i = 0; $i <= 31; ++$i)
            $jsonString = str_replace(chr($i), "", $jsonString);

        $jsonString = str_replace(chr(127), "", $jsonString);

        // Remove the BOM (Byte Order Mark)
        // It the most common that some file begins with 'efbbbf' to mark the beginning of the file. (binary level)
        // Here we detect it and we remove it, basically it the first 3 characters.
        if (0 === strpos(bin2hex($jsonString), 'efbbbf')) $jsonString = substr($jsonString, 3);

        return $jsonString;
    }

    public function data_ref_list_hist_alih_tugas_by_idknj($idknj_m){
        $data_ref = $this->CallAPI('GET', $this->url_list_hist_alih_tugas_by_id_knj, array("id_knj_master" => $idknj_m));
        $data_ref = self::safeDecode($data_ref);
        $data_ref = $data_ref->data;
        return $data_ref;
    }

    public function data_ref_list_hist_alih_tugas_by_idpeg(){
        $data_ref = $this->CallAPI('GET', $this->url_list_hist_alih_tugas_by_id_pegawai, array("id_pegawai" => $this->session->userdata('id_pegawai_enc')));
        $data_ref = self::safeDecode($data_ref);
        $data_ref = $data_ref->data;
        return $data_ref;
    }

    public function get_jml_hist_alih_tugas(){
        $data_ref = $this->CallAPI('GET', $this->url_jml_hist_alih_tugas, array("id_pegawai" => $this->session->userdata('id_pegawai_enc')));
        $data_ref = self::safeDecode($data_ref);
        $data_ref = $data_ref->data;
        return $data_ref;
    }

    public function get_golongan(){
        $data_ref = $this->CallAPI('GET', $this->url_list_golongan);
        $data_ref = self::safeDecode($data_ref);
        $data_ref = $data_ref->data;
        return $data_ref;
    }

    public function get_unit_kerja(){
        $data_ref = $this->CallAPI('GET', $this->url_list_unit_kerja);
        $data_ref = self::safeDecode($data_ref);
        $data_ref = $data_ref->data;
        return $data_ref;
    }

    public function get_satuan_output(){
        $data_ref = $this->CallAPI('GET', $this->url_satuan_output);
        $data_ref = self::safeDecode($data_ref);
        $data_ref = $data_ref->data;
        return $data_ref;
    }

    public function get_exec_kalkulasi_nilai_result($id_pegawai, $id_knj_master, $bln, $thn){
        $data_ref = $this->CallAPI('GET', $this->url_kalkulasi_nilai_kinerja, array('id_pegawai' => $id_pegawai, "id_knj_master" => $id_knj_master, "bln" => $bln, 'thn' => $thn));
        return $data_ref;
    }

    public function get_exec_laporan_kinerja_selesai($id_knj_master, $idpegawai_approved, $status_laporan){
        $data_ref = $this->CallAPI('GET', $this->url_laporan_kinerja_selesai, array("id_knj_master" => $id_knj_master, "idpegawai_approved" => $idpegawai_approved, "status_laporan" => $status_laporan));
        return $data_ref;
    }

    public function get_exec_hapus_kegiatan($id_knj_kegiatan){
        $data = array('id_knj_kegiatan' => $id_knj_kegiatan);
        $data_ref = $this->CallAPI('POST', $this->url_hapus_aktifitas, $data);
        return $data_ref;
    }

    public function get_exec_hapus_berkas_kegiatan($id_knj_kegiatan){
        $data = array('id_knj_kegiatan' => $id_knj_kegiatan);
        $data_ref = $this->CallAPI('POST', $this->url_hapus_berkas_aktifitas, $data);
        return $data_ref;
    }

    public function get_daftar_staf_aktual_kinerja($id_pegawai_enc, $id_skpd_enc){
        $data_ref = $this->CallAPI('GET', $this->url_daftar_staf_aktual_kinerja, array('id_pegawai_enc' => $id_pegawai_enc, "id_skpd_enc" => $id_skpd_enc));
        $data_ref = self::safeDecode($data_ref);
        $data_ref = $data_ref->data;
        return $data_ref;
    }

    public function get_jumlah_peninjauan_aktifitas_staf($ddStsProses, $keyword, $id_knj_master, $id_pegawai_atasan_enc){
        $data_ref = $this->CallAPI('GET', $this->url_jml_peninjauan_aktifitas_staf, array('idstatus' => $ddStsProses, 'keyword' => $keyword, 'id_knj_master' => $id_knj_master, "id_pegawai_atasan_enc" => $id_pegawai_atasan_enc));
        $data_ref = self::safeDecode($data_ref);
        $data_ref = $data_ref->data;
        return $data_ref;
    }

    public function get_daftar_peninjauan_aktifitas_staf($row_number_start, $ddStsProses, $keyword, $id_knj_master, $id_pegawai_atasan_enc, $limit){
        $data_ref = $this->CallAPI('GET', $this->url_daftar_peninjauan_aktifitas_staf, array('row_number_start' => $row_number_start, 'idstatus' => $ddStsProses, 'keyword' => $keyword, 'id_knj_master' => $id_knj_master, "id_pegawai_atasan_enc" => $id_pegawai_atasan_enc, 'limit' => $limit));
        $data_ref = self::safeDecode($data_ref);
        $data_ref = $data_ref->data;
        return $data_ref;
    }

    public function get_jml_aktifitas_per_periode($bln, $thn, $keyword, $id_pegawai_enc){
        $data_ref = $this->CallAPI('GET', $this->url_jml_aktifitas_per_periode, array('bln' => $bln, 'thn' => $thn, 'keyword' => $keyword, "id_pegawai_enc" => $id_pegawai_enc));
        $data_ref = self::safeDecode($data_ref);
        $data_ref = $data_ref->data;
        return $data_ref;
    }

    public function daftar_aktifitas_per_periode($row_number_start, $bln, $thn, $keyword, $id_pegawai_enc, $limit){
        $data_ref = $this->CallAPI('GET', $this->url_daftar_aktifitas_per_periode, array('row_number_start' => $row_number_start, 'bln' => $bln, 'thn' => $thn, 'keyword' => $keyword, "id_pegawai_enc" => $id_pegawai_enc, 'limit' => $limit));
        $data_ref = self::safeDecode($data_ref);
        $data_ref = $data_ref->data;
        return $data_ref;
    }

    public function proses_aktifitas_kegiatan_by_id($id_knj_kegiatan_enc, $idstatus, $ket_approval, $id_pegawai_enc){
        $data_ref = $this->CallAPI('POST', $this->url_proses_aktifitas_kegiatan_by_id, array('id_knj_kegiatan' => $id_knj_kegiatan_enc, "idstatus" => $idstatus, "ket_approval" => $ket_approval, 'id_pegawai' => $id_pegawai_enc));
        return $data_ref;
    }

    public function get_aktifitas_kegiatan_by_id($id_knj_kegiatan_enc){
        $data_ref = $this->CallAPI('GET', $this->url_aktifitas_kegiatan_by_id, array('id_knj_kegiatan' => $id_knj_kegiatan_enc));
        $data_ref = self::safeDecode($data_ref);
        $data_ref = $data_ref->data;
        return $data_ref;
    }

    public function get_result_check_admin_pratama_admin($id_j){
        $data_ref = $this->CallAPI('GET', $this->url_cek_jab_tgi_pratama_admin, array('id_j' => $id_j));
        $data_ref = self::safeDecode($data_ref);
        $data_ref = $data_ref->data;
        return $data_ref;
    }

    public function get_wkt_selesai_kegiatan_terakhir($id_pegawai_enc, $bln, $thn){
        $data_ref = $this->CallAPI('GET', $this->url_wkt_selesai_kegiatan_terakhir, array('id_pegawai' => $id_pegawai_enc, 'bln' => $bln, 'thn' => $thn));
        $data_ref = self::safeDecode($data_ref);
        $data_ref = $data_ref->data;
        return $data_ref;
    }

    public function get_exec_send_msg_whatsapp($id_knj_kegiatan){
        $data_ref = $this->CallAPI('POST', $this->url_get_info_kegiatan_send_whatsapp, array('id_knj_kegiatan' => $id_knj_kegiatan));
        return $data_ref;
    }

    public function get_jml_pegawai_tipe_lokasi($id_skpd_enc, $keyword){
        $data_ref = $this->CallAPI('GET', $this->url_jml_pegawai_tipe_lokasi, array('id_skpd_enc' => $id_skpd_enc, 'keyword' => $keyword));
        $data_ref = self::safeDecode($data_ref);
        $data_ref = $data_ref->data;
        return $data_ref;
    }

    public function daftar_pegawai_tipe_lokasi($row_number_start, $id_skpd_enc, $keyword, $limit){
        $data_ref = $this->CallAPI('GET', $this->url_daftar_pegawai_tipe_lokasi, array('row_number_start' => $row_number_start, 'id_skpd_enc' => $id_skpd_enc, 'keyword' => $keyword, 'limit' => $limit));
        $data_ref = self::safeDecode($data_ref);
        $data_ref = $data_ref->data;
        return $data_ref;
    }

    public function data_ref_list_hist_alih_tugas_detail_calc_by_idknj($idknj_m){
        $data_ref = $this->CallAPI('GET', $this->url_list_hist_alih_tugas_detail_calc_by_id_knj, array("id_knj_master" => $idknj_m));
        $data_ref = self::safeDecode($data_ref);
        $data_ref = $data_ref->data;
        return $data_ref;
    }

    public function data_ref_detail_nilai_tunjangan_by_hist_alih_tugas($idknj_hist_alih_tugas){
        $data_ref = $this->CallAPI('GET', $this->url_detail_nilai_tunjangan_by_hist_alih_tugas, array("idknj_hist_alih_tugas" => $idknj_hist_alih_tugas));
        $data_ref = self::safeDecode($data_ref);
        $data_ref = $data_ref->data;
        return $data_ref;
    }

    public function data_ref_unit_kerja_utama_pegawai($id_pegawai_enc){
        $data_ref = $this->CallAPI('GET', $this->url_info_unit_kerja_utama_pegawai, array("id_pegawai_enc" => $id_pegawai_enc));
        $data_ref = self::safeDecode($data_ref);
        $data_ref = $data_ref->data;
        return $data_ref;
    }

    public function data_ref_unit_kerja_sekunder_pegawai($id_pegawai_enc){
        $data_ref = $this->CallAPI('GET', $this->url_info_unit_kerja_sekunder_pegawai, array("id_pegawai_enc" => $id_pegawai_enc));
        $data_ref = self::safeDecode($data_ref);
        $data_ref = $data_ref->data;
        return $data_ref;
    }

    public function get_exec_ubah_tipe_lokasi_pegawai($isMulti, $idClk, $idp_updater){
        $data_ref = $this->CallAPI('POST', $this->url_ubah_tipe_lokasi_pegawai, array('isMulti' => $isMulti, "idClk" => $idClk, "idp_updater" => $idp_updater));
        return $data_ref;
    }

    public function data_ref_unit_sekunder_by_term($q, $tipe_unit, $opd){
        $data_ref = $this->CallAPI('GET', $this->url_get_unit_sekunder_by_term, array("q" => $q, "tipe_unit" => $tipe_unit, "opd" => $opd));
        return $data_ref;
    }

    public function data_ref_unit_sekunder_by_id($idUnitSekunder, $tipeUnit){
        $data_ref = $this->CallAPI('GET', $this->url_info_unit_sekunder_by_id, array("idUnitSekunder" => $idUnitSekunder, "tipeUnit" =>$tipeUnit));
        $data_ref = self::safeDecode($data_ref);
        $data_ref = $data_ref->data;
        return $data_ref;
    }

    public function get_exec_hapus_unit_kerja_sekunder_pegawai($id_unit_sekunder_pegawai_enc){
        $data = array('id_unit_sekunder_pegawai_enc' => $id_unit_sekunder_pegawai_enc);
        $data_ref = $this->CallAPI('POST', $this->url_hapus_unit_sekunder_pegawai, $data);
        return $data_ref;
    }

    public function get_exec_hapus_unit_kerja_sekunder_lokasi($id_unit_sekunder_enc){
        $data = array('id_unit_sekunder_enc' => $id_unit_sekunder_enc);
        $data_ref = $this->CallAPI('POST', $this->url_hapus_unit_sekunder_lokasi, $data);
        return $data_ref;
    }

    public function get_jenis_jadwal(){
        $data_ref = $this->CallAPI('GET', $this->url_jenis_jadwal);
        $data_ref = self::safeDecode($data_ref);
        $data_ref = $data_ref->data;
        return $data_ref;
    }

    public function get_jml_pegawai($id_skpd_enc, $keyword){
        $data_ref = $this->CallAPI('GET', $this->url_jml_pegawai_opd, array('id_skpd_enc' => $id_skpd_enc, 'keyword' => $keyword));
        $data_ref = self::safeDecode($data_ref);
        $data_ref = $data_ref->data;
        return $data_ref;
    }

    public function get_list_pegawai($row_number_start, $id_skpd_enc, $keyword, $limit){
        $data_ref = $this->CallAPI('GET', $this->url_list_pegawai_opd, array('row_number_start' => $row_number_start, 'id_skpd_enc' => $id_skpd_enc, 'keyword' => $keyword, 'limit' => $limit));
        $data_ref = self::safeDecode($data_ref);
        $data_ref = $data_ref->data;
        return $data_ref;
    }

    public function get_daftar_hist_ekinerja_staf($idp){
        $data_ref = $this->ekinerja->CallAPI('GET', $this->ekinerja->url_list_kinerja_master, array("id_pegawai" => $idp));
        $data_ref = self::safeDecode($data_ref);
        $data_ref = $data_ref->data;
        return $data_ref;
    }

    public function get_informasi_pegawai_byidp($idp){
        $data_ref = $this->ekinerja->CallAPI('GET', $this->ekinerja->url_info_pegawai_byidp, array("idp" => $idp));
        $data_ref = self::safeDecode($data_ref);
        $data_ref = $data_ref->data;
        return $data_ref;
    }

    public function get_jml_jadwal_khusus_spmt($bln, $thn, $keyword, $idp, $idskpd){
        $data_ref = $this->CallAPI('GET', $this->url_jml_jadwal_khusus_spmt, array('bln' => $bln, 'thn' => $thn, 'keyword' => $keyword, 'idp' => $idp, 'idskpd' => $idskpd));
        $data_ref = self::safeDecode($data_ref);
        $data_ref = $data_ref->data;
        return $data_ref;
    }

    public function daftar_jadwal_khusus_spmt($row_number_start, $bln, $thn, $keyword, $idp, $idskpd, $limit){
        $data_ref = $this->CallAPI('GET', $this->url_list_jadwal_khusus_spmt, array('row_number_start' => $row_number_start, 'bln' => $bln, 'thn' => $thn, 'keyword' => $keyword, 'idp' => $idp, 'idskpd' => $idskpd, 'limit' => $limit));
        $data_ref = self::safeDecode($data_ref);
        $data_ref = $data_ref->data;
        return $data_ref;
    }

    public function get_exec_hapus_jadwal_khusus($idjadwal_khusus_enc){
        $data = array('idjadwal_khusus_enc' => $idjadwal_khusus_enc);
        $data_ref = $this->CallAPI('POST', $this->url_hapus_jadwal_khusus, $data);
        return $data_ref;
    }

    public function daftar_jadwal_tran_kalender_by_opd($bln=null, $thn=null, $opd){
        if($bln==null){
            $bln = date("m");
        }
        if($thn==null){
            $thn = date("Y");
        }
        $data_ref = $this->ekinerja->CallAPI('GET', $this->ekinerja->url_daftar_jadwaltrans_kalender_by_opd, array("bln" => $bln, "thn" => $thn, "opd" => $opd));
        $data_ref = json_decode($data_ref, true);
        return $data_ref;
    }

    public function get_jml_jadwal_detail($bln, $thn, $idjadwal, $idp, $tglMulaiAcara, $tglSelesaiAcara, $keyword, $opd){
        $data_ref = $this->CallAPI('GET', $this->url_jml_jadwal_khusus, array('bln' => $bln, 'thn' => $thn, 'id_jenis_jadwal' => $idjadwal, 'idp' => $idp, 'tglMulaiAcara' => $tglMulaiAcara, 'tglSelesaiAcara' => $tglSelesaiAcara, 'keyword' => $keyword, 'opd' => $opd));
        $data_ref = self::safeDecode($data_ref);
        $data_ref = $data_ref->data;
        return $data_ref;
    }

    public function daftar_jadwal_detail($row_number_start, $bln, $thn, $idjadwal, $idp, $tglMulaiAcara, $tglSelesaiAcara, $keyword, $opd, $limit){
        $data_ref = $this->CallAPI('GET', $this->url_list_jadwal_khusus, array('row_number_start' => $row_number_start, 'bln' => $bln, 'thn' => $thn, 'id_jenis_jadwal' => $idjadwal, 'idp' => $idp, 'tglMulaiAcara' => $tglMulaiAcara, 'tglSelesaiAcara' => $tglSelesaiAcara, 'keyword' => $keyword, 'opd' => $opd, 'limit' => $limit));
        $data_ref = self::safeDecode($data_ref);
        $data_ref = $data_ref->data;
        return $data_ref;
    }

    public function get_exec_hapus_jadwal_trans($idjadwal_trans_enc){
        $data = array('idjadwal_trans_enc' => $idjadwal_trans_enc);
        $data_ref = $this->CallAPI('POST', $this->url_hapus_jadwal_trans, $data);
        return $data_ref;
    }

    public function daftar_unit_kerja_jadwal_trans($idjadwal_trans_enc){
        $data_ref = $this->CallAPI('GET', $this->url_unit_kerja_jadwal_transaksi, array("id_trans_jadwal" => $idjadwal_trans_enc));
        $data_ref = self::safeDecode($data_ref);
        $data_ref = $data_ref->data;
        return $data_ref;
    }

    public function ubah_jadwal_transaksi_by_id($idjadwal_trans_enc){
        $data_ref = $this->CallAPI('GET', $this->url_ubah_jadwal_transaksi, array('id_trans_jadwal' => $idjadwal_trans_enc));
        $data_ref = self::safeDecode($data_ref);
        $data_ref = $data_ref->data;
        return $data_ref;
    }

    public function get_jenis_item_lain(){
        $data_ref = $this->CallAPI('GET', $this->url_jenis_item_lainnya);
        $data_ref = self::safeDecode($data_ref);
        $data_ref = $data_ref->data;
        return $data_ref;
    }

    public function get_exec_hapus_unit_kerja_jadwal($id_ukjdwl_enc){
        $data = array('id_ukjdwl_enc' => $id_ukjdwl_enc);
        $data_ref = $this->CallAPI('POST', $this->url_hapus_unit_kerja_jadwal, $data);
        return $data_ref;
    }

    public function get_status_item_lain(){
        $data_ref = $this->CallAPI('GET', $this->url_status_item_lainnya);
        $data_ref = self::safeDecode($data_ref);
        $data_ref = $data_ref->data;
        return $data_ref;
    }

    public function get_jml_item_lainnya($user_level, $id_pegawai, $id_skpd, $ddItemLainnya, $ddStsItemLainnya, $keyword){
        $data_ref = $this->CallAPI('GET', $this->url_jml_item_lainnya_kinerja, array('user_level' => $user_level, 'id_pegawai' => $id_pegawai, 'id_skpd' => $id_skpd, 'id_jenis_item' => $ddItemLainnya, 'id_status_item' => $ddStsItemLainnya, 'keyword' => $keyword));
        $data_ref = self::safeDecode($data_ref);
        $data_ref = $data_ref->data;
        return $data_ref;
    }

    public function daftar_item_lainnya($row_number_start, $user_level, $id_pegawai, $id_skpd, $ddItemLainnya, $ddStsItemLainnya, $keyword, $limit){
        $data_ref = $this->CallAPI('GET', $this->url_daftar_item_lainnya_kinerja, array('row_number_start' => $row_number_start, 'user_level' => $user_level, 'id_pegawai' => $id_pegawai, 'id_skpd' => $id_skpd, 'id_jenis_item' => $ddItemLainnya, 'id_status_item' => $ddStsItemLainnya, 'keyword' => $keyword, 'limit' => $limit));
        $data_ref = self::safeDecode($data_ref);
        $data_ref = $data_ref->data;
        return $data_ref;
    }

    public function get_exec_hapus_unit_lainnya($id_item_lainnya_enc){
        $data = array('id_item_lainnya_enc' => $id_item_lainnya_enc);
        $data_ref = $this->CallAPI('POST', $this->url_hapus_item_lainnya, $data);
        return $data_ref;
    }

    public function riwayat_skp_pegawai($idpegawai_enc){
        $data_ref = $this->CallAPI('GET', $this->url_riwayat_skp, array("id_pegawai_enc" => $idpegawai_enc));
        $data_ref = self::safeDecode($data_ref);
        $data_ref = $data_ref->data;
        return $data_ref;
    }

    public function detail_skp_pegawai($id_skp_enc){
        $dataReq = array(
            array('url'=>$this->url_skp_header, 'get_data'=> array('get_array'=>array('id_skp_enc'=>$id_skp_enc))),
            array('url'=>$this->url_skp_target, 'get_data'=> array('get_array'=>array('id_skp_enc'=>$id_skp_enc))),
            array('url'=>$this->url_skp_tambahan, 'get_data'=> array('get_array'=>array('id_skp_enc'=>$id_skp_enc)))
        );
        $data_ref = $this->multiRequestAPI($dataReq);
        return $data_ref;
        /*echo '<pre>';
        print_r($data_ref[0]['data']);
        echo '</pre>';*/
    }

    public function get_daftar_riwayat_staf_kinerja($id_pegawai_enc){
        $data_ref = $this->CallAPI('GET', $this->url_riwayat_staf_ekinerja, array('id_pegawai_enc' => $id_pegawai_enc));
        $data_ref = self::safeDecode($data_ref);
        $data_ref = $data_ref->data;
        return $data_ref;
    }

    public function get_jml_pegawai_info_kinerja($id_skpd_enc, $keyword, $last_periode){
        $data_ref = $this->CallAPI('GET', $this->url_jml_pegawai_info_kinerja, array('id_skpd_enc' => $id_skpd_enc, 'keyword' => $keyword, 'last_periode' => $last_periode));
        $data_ref = self::safeDecode($data_ref);
        $data_ref = $data_ref->data;
        return $data_ref;
    }

    public function daftar_pegawai_info_kinerja($row_number_start, $id_skpd_enc, $keyword, $last_periode, $limit){
        $data_ref = $this->CallAPI('GET', $this->url_daftar_pegawai_info_kinerja, array('row_number_start' => $row_number_start, 'id_skpd_enc' => $id_skpd_enc, 'keyword' => $keyword, 'last_periode' => $last_periode, 'limit' => $limit));
        $data_ref = self::safeDecode($data_ref);
        $data_ref = $data_ref->data;
        return $data_ref;
    }

    public function daftar_item_lainnya_by_idpegawai($id_pegawai_enc, $bln, $thn){
        $data_ref = $this->CallAPI('GET', $this->url_daftar_item_lainnya_kinerja_by_idp, array('id_pegawai_enc' => $id_pegawai_enc, 'bln' => $bln, 'thn' => $thn));
        $data_ref = self::safeDecode($data_ref);
        $data_ref = $data_ref->data;
        return $data_ref;
    }



    public function get_jml_laporan_kinerja_pegawai_opd($id_skpd_enc, $id_sts_laporan, $jenjab, $eselon, $bln, $thn, $keyword){
        $data_ref = $this->CallAPI('GET', $this->url_jml_laporan_kinerja_pegawai_opd, array('id_skpd_enc' => $id_skpd_enc, 'id_sts_laporan' => $id_sts_laporan, 'jenjab' => $jenjab, 'eselon' => $eselon, 'bln' => $bln, 'thn' => $thn, 'keyword' => $keyword));
        $data_ref = self::safeDecode($data_ref);
        $data_ref = $data_ref->data;
        return $data_ref;
    }

    public function get_daftar_laporan_kinerja_pegawai_opd($row_number_start, $id_skpd_enc, $id_sts_laporan, $jenjab, $eselon, $bln, $thn, $keyword, $limit){
        $data_ref = $this->CallAPI('GET', $this->url_daftar_laporan_kinerja_pegawai_opd, array('row_number_start' => $row_number_start, 'id_skpd_enc' => $id_skpd_enc, 'id_sts_laporan' => $id_sts_laporan, 'jenjab' => $jenjab, 'eselon' => $eselon, 'bln' => $bln, 'thn' => $thn, 'keyword' => $keyword, 'limit' => $limit));
        $data_ref = self::safeDecode($data_ref);
        $data_ref = $data_ref->data;
        return $data_ref;
    }

    public function get_daftar_inputer_jadwal(){
        $data_ref = $this->ekinerja->CallAPI('GET', $this->ekinerja->url_daftar_inputer_jadwal, array("id_skpd_enc" => $this->session->userdata('id_skpd_enc')));
        $data_ref = self::safeDecode($data_ref);
        $data_ref = $data_ref->data;
        return $data_ref;
    }

    public function get_cetak_laporan_kinerja_pegawai_opd($id_skpd_enc, $bln, $thn){
        $data_ref = $this->CallAPI('GET', $this->url_cetak_laporan_kinerja_pegawai_opd, array('id_skpd_enc' => $id_skpd_enc, 'bln' => $bln, 'thn' => $thn));
        $data_ref = self::safeDecode($data_ref);
        $data_ref = $data_ref->data;
        return $data_ref;
    }

    public function data_ref_pegawai_by_term($q){
        $data_ref = $this->CallAPI('GET', $this->url_get_pegawai_by_term, array("nama" => $q));
        return $data_ref;
    }

    public function get_exec_input_jadwal_pulang_sesuai_jadwal($id_pegawai, $wkt, $ket){
        $data_ref = $this->CallAPI('POST', $this->url_insert_logabsen_byidpegawai_wkt, array("id_pegawai" => $id_pegawai, "wkt" => $wkt, "ket" => $ket));
        return $data_ref;
    }

    public function get_exec_hapus_jadwal_pulang_sesuai_jadwal($id_pegawai, $wkt){
        $data = array('id_pegawai' => $id_pegawai, 'wkt' => $wkt);
        $data_ref = $this->CallAPI('POST', $this->url_hapus_logabsen_byidpegawai_wkt, $data);
        return $data_ref;
    }

    public function get_pencapaian_kinerja_curr($id_pegawai){
        $data_ref = $this->CallAPI('GET', $this->url_pencapaian_kinerja_curr, array('id_pegawai' => $id_pegawai));
        $data_ref = self::safeDecode($data_ref);
        $data_ref = $data_ref->data;
        return $data_ref;
    }

    public function get_status_aktifitas_current($id_pegawai){
        $data_ref = $this->CallAPI('GET', $this->url_status_aktifitas_curr, array('id_pegawai' => $id_pegawai));
        $data_ref = self::safeDecode($data_ref);
        $data_ref = $data_ref->data;
        return $data_ref;
    }

    public function get_status_aktifitas_current_stafnya($id_pegawai, $id_skpd){
        $data_ref = $this->CallAPI('GET', $this->url_aktifitas_curr_stafnya, array('id_pegawai_enc' => $id_pegawai, 'id_skpd_enc' => $id_skpd));
        $data_ref = self::safeDecode($data_ref);
        $data_ref = $data_ref->data;
        return $data_ref;
    }

    public function get_jml_laporan_kinerja_pegawai($id_skpd_enc, $bln, $thn, $idp_enc){
        $data_ref = $this->CallAPI('GET', $this->url_jml_laporan_kinerja_pegawai, array('id_skpd_enc' => $id_skpd_enc, 'bln' => $bln, 'thn' => $thn, 'idp_enc' => $idp_enc));
        $data_ref = self::safeDecode($data_ref);
        $data_ref = $data_ref->data;
        return $data_ref;
    }

    public function get_daftar_laporan_kinerja_pegawai($row_number_start, $id_skpd_enc, $bln, $thn, $idp_enc, $limit){
        $data_ref = $this->CallAPI('GET', $this->url_daftar_laporan_kinerja_pegawai, array('row_number_start' => $row_number_start, 'id_skpd_enc' => $id_skpd_enc, 'bln' => $bln, 'thn' => $thn, 'idp_enc' => $idp_enc, 'limit' => $limit));
        $data_ref = self::safeDecode($data_ref);
        $data_ref = $data_ref->data;
        return $data_ref;
    }

    public function get_jml_aktifitas_by_id($tgl, $status, $target, $keyword, $idknjm){
        $data_ref = $this->CallAPI('GET', $this->url_jml_aktifitas_by_id, array('tgl' => $tgl, 'status' => $status, 'target' => $target, 'keyword' => $keyword, "id_knj_master" => $idknjm));
        $data_ref = self::safeDecode($data_ref);
        $data_ref = $data_ref->data;
        return $data_ref;
    }

    public function daftar_aktifitas_by_id($row_number_start, $tgl, $status, $target, $keyword, $idknjm, $limit){
        $data_ref = $this->CallAPI('GET', $this->url_daftar_aktifitas_by_id, array('row_number_start' => $row_number_start, 'tgl' => $tgl, 'status' => $status, 'target' => $target, 'keyword' => $keyword, "id_knj_master" => $idknjm, 'limit' => $limit));
        $data_ref = self::safeDecode($data_ref);
        $data_ref = $data_ref->data;
        return $data_ref;
    }

    public function daftar_opd(){
        $data_ref = $this->CallAPI('GET', $this->url_daftar_opd, array());
        $data_ref = self::safeDecode($data_ref);
        $data_ref = $data_ref->data;
        return $data_ref;
    }

    public function jml_daftar_unit_kerja_sekunder_by_opd($opd, $keyword){
        $data_ref = $this->CallAPI('GET', $this->url_jml_daftar_unit_kerja_sekunder_by_opd, array('opd' => $opd, 'keyword' => $keyword));
        $data_ref = self::safeDecode($data_ref);
        $data_ref = $data_ref->data;
        return $data_ref;
    }

    public function list_daftar_unit_kerja_sekunder_by_opd($row_number_start, $opd, $keyword, $limit){
        $data_ref = $this->CallAPI('GET', $this->url_list_daftar_unit_kerja_sekunder_by_opd, array('row_number_start' => $row_number_start, 'opd' => $opd, 'keyword' => $keyword, 'limit' => $limit));
        $data_ref = self::safeDecode($data_ref);
        $data_ref = $data_ref->data;
        return $data_ref;
    }

    public function get_daftar_riwayat_staf_plh($id_pegawai_enc){
        $data_ref = $this->CallAPI('GET', $this->url_riwayat_staf_plh, array('id_pegawai_enc' => $id_pegawai_enc));
        $data_ref = self::safeDecode($data_ref);
        $data_ref = $data_ref->data;
        return $data_ref;
    }

    public function get_daftar_hist_ekinerja_staf_plh($idp, $idp_atsl_plh){
        $data_ref = $this->ekinerja->CallAPI('GET', $this->ekinerja->url_list_kinerja_master_plh, array("id_pegawai" => $idp, "idp_atsl_plh" => $idp_atsl_plh));
        $data_ref = self::safeDecode($data_ref);
        $data_ref = $data_ref->data;
        return $data_ref;
    }

    public function get_jumlah_peninjauan_aktifitas_staf_plh($ddStsProses, $keyword, $id_knj_master, $id_pegawai_atasan_enc){
        $data_ref = $this->CallAPI('GET', $this->url_jml_peninjauan_aktifitas_staf_plh, array('idstatus' => $ddStsProses, 'keyword' => $keyword, 'id_knj_master' => $id_knj_master, "id_pegawai_atasan_enc" => $id_pegawai_atasan_enc));
        $data_ref = self::safeDecode($data_ref);
        $data_ref = $data_ref->data;
        return $data_ref;
    }

    public function get_daftar_peninjauan_aktifitas_staf_plh($row_number_start, $ddStsProses, $keyword, $id_knj_master, $id_pegawai_atasan_enc, $limit){
        $data_ref = $this->CallAPI('GET', $this->url_daftar_peninjauan_aktifitas_staf_plh, array('row_number_start' => $row_number_start, 'idstatus' => $ddStsProses, 'keyword' => $keyword, 'id_knj_master' => $id_knj_master, "id_pegawai_atasan_enc" => $id_pegawai_atasan_enc, 'limit' => $limit));
        $data_ref = self::safeDecode($data_ref);
        $data_ref = $data_ref->data;
        return $data_ref;
    }

    function hist_alih_tugas_kinerja_by_id($id_knj_master, $idknj_alih_tugas){
        $data_ref = $this->ekinerja->CallAPI('GET', $this->ekinerja->url_hist_alih_tugas_kinerja_by_id, array("id_knj_master" => $id_knj_master, "idknj_hist_alih_tugas" => $idknj_alih_tugas));
        $data_ref = $this->ekinerja->safeDecode($data_ref);
        $data_ref = $data_ref->data;
        return $data_ref;
    }

}
?>
