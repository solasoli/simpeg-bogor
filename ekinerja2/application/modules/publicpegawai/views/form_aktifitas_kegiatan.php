<?php

if (isset($data_dasar) and $data_dasar!=NULL and sizeof($data_dasar) > 0 and $data_dasar != ''){
    $id_atasan_list = array();
    $unitsama = false;
    foreach ($data_dasar as $lsdata){
        //  echo "<pre>";
        //  print_r($lsdata);
        //  echo "</pre>";
        if(isset($lsdata->id_unit_kerja_atsl) and isset($lsdata->id_skpd_me)){
            if($lsdata->id_unit_kerja_atsl == $this->session->userdata('id_unit_kerja') or $lsdata->id_unit_kerja_atsl == $lsdata->id_skpd_me){
                $id_pegawai = $lsdata->id_pegawai;
                $nip_baru = $lsdata->nip_baru;
                $nama = $lsdata->nama;
                $pangkat_gol = $lsdata->pangkat_gol;
                $jenjab = $lsdata->jenjab;
                $status_pegawai = $lsdata->status_pegawai;
                $kode_jabatan = $lsdata->kode_jabatan;
                $kelas_jabatan = $lsdata->kelas_jabatan;
                $nilai_jabatan = $lsdata->nilai_jabatan;
                $tunjangan = $lsdata->tunjangan;
                $jabatan = $lsdata->jabatan;
                $eselon = $lsdata->eselon;
                $id_unit_kerja_me = $lsdata->id_unit_kerja_me;
                $unit_kerja_me = $lsdata->unit_kerja_me;

                /* Atasan Langsung */
                $id_bos_atsl = $lsdata->id_bos_atsl;
                $id_pegawai_atsl = $lsdata->id_pegawai_atsl;
                $nip_baru_atsl = $lsdata->nip_baru_atsl;
                $nama_atsl = $lsdata->nama_atsl;
                $gol_atsl = $lsdata->gol_atsl;
                $jabatan_atsl = $lsdata->jabatan_atsl;

                /* Plh. Atasan Langsung */
                $id_bos_atsl_plh = $lsdata->id_bos_atsl_plh;
                $id_pegawai_atsl_plh = $lsdata->idp_plh_atsl;
                $nip_baru_atsl_plh = $lsdata->nip_baru_atsl_plh;
                $nama_atsl_plh = $lsdata->nama_atsl_plh;
                $gol_atsl_plh = $lsdata->gol_atsl_plh;
                $jabatan_atsl_plh = $lsdata->jabatan_atsl_plh;

                /* Pejabat Berwenang */
                $id_bos_pjbt = $lsdata->id_bos_pjbt;
                $id_pegawai_pjbt = $lsdata->id_pegawai_pjbt;
                $nip_baru_pjbt = $lsdata->nip_baru_pjbt;
                $nama_pjbt = $lsdata->nama_pjbt;
                $gol_pjbt = $lsdata->gol_pjbt;
                $jabatan_pjbt = $lsdata->jabatan_pjbt;

                /* Plh. Pejabat Berwenang */
                $id_bos_pjbt_plh = $lsdata->id_bos_pjbt_plh;
                $id_pegawai_pjbt_plh = $lsdata->idp_plh_pjbt;
                $nip_baru_pjbt_plh = $lsdata->nip_baru_pjbt_plh;
                $nama_pjbt_plh = $lsdata->nama_pjbt_plh;
                $gol_pjbt_plh = $lsdata->gol_pjbt_plh;
                $jabatan_pjbt_plh = $lsdata->jabatan_pjbt_plh;

                $unitsama = true;
            }else{
                if(sizeof($data_dasar) == 1){
                    $id_pegawai = $lsdata->id_pegawai;
                    $nip_baru = $lsdata->nip_baru;
                    $nama = $lsdata->nama;
                    $pangkat_gol = $lsdata->pangkat_gol;
                    $jenjab = $lsdata->jenjab;
                    $status_pegawai = $lsdata->status_pegawai;
                    $kode_jabatan = $lsdata->kode_jabatan;
                    $kelas_jabatan = $lsdata->kelas_jabatan;
                    $nilai_jabatan = $lsdata->nilai_jabatan;
                    $tunjangan = $lsdata->tunjangan;
                    $jabatan = $lsdata->jabatan;
                    $eselon = $lsdata->eselon;
                    $id_unit_kerja_me = $lsdata->id_unit_kerja_me;
                    $unit_kerja_me = $lsdata->unit_kerja_me;

                    /* Atasan Langsung */
                    $id_bos_atsl = $lsdata->id_bos_atsl;
                    $id_pegawai_atsl = $lsdata->id_pegawai_atsl;
                    $nip_baru_atsl = $lsdata->nip_baru_atsl;
                    $nama_atsl = $lsdata->nama_atsl;
                    $gol_atsl = $lsdata->gol_atsl;
                    $jabatan_atsl = $lsdata->jabatan_atsl;

                    /* Plh. Atasan Langsung */
                    $id_bos_atsl_plh = $lsdata->id_bos_atsl_plh;
                    $id_pegawai_atsl_plh = $lsdata->idp_plh_atsl;
                    $nip_baru_atsl_plh = $lsdata->nip_baru_atsl_plh;
                    $nama_atsl_plh = $lsdata->nama_atsl_plh;
                    $gol_atsl_plh = $lsdata->gol_atsl_plh;
                    $jabatan_atsl_plh = $lsdata->jabatan_atsl_plh;

                    /* Pejabat Berwenang */
                    $id_bos_pjbt = $lsdata->id_bos_pjbt;
                    $id_pegawai_pjbt = $lsdata->id_pegawai_pjbt;
                    $nip_baru_pjbt = $lsdata->nip_baru_pjbt;
                    $nama_pjbt = $lsdata->nama_pjbt;
                    $gol_pjbt = $lsdata->gol_pjbt;
                    $jabatan_pjbt = $lsdata->jabatan_pjbt;

                    /* Plh. Pejabat Berwenang */
                    $id_bos_pjbt_plh = $lsdata->id_bos_pjbt_plh;
                    $id_pegawai_pjbt_plh = $lsdata->idp_plh_pjbt;
                    $nip_baru_pjbt_plh = $lsdata->nip_baru_pjbt_plh;
                    $nama_pjbt_plh = $lsdata->nama_pjbt_plh;
                    $gol_pjbt_plh = $lsdata->gol_pjbt_plh;
                    $jabatan_pjbt_plh = $lsdata->jabatan_pjbt_plh;
                }else{
                    if($unitsama==false){
                        $id_pegawai = $lsdata->id_pegawai;
                        $nip_baru = $lsdata->nip_baru;
                        $nama = $lsdata->nama;
                        $pangkat_gol = $lsdata->pangkat_gol;
                        $jenjab = $lsdata->jenjab;
                        $status_pegawai = $lsdata->status_pegawai;
                        $kode_jabatan = $lsdata->kode_jabatan;
                        $kelas_jabatan = $lsdata->kelas_jabatan;
                        $nilai_jabatan = $lsdata->nilai_jabatan;
                        $tunjangan = $lsdata->tunjangan;
                        $jabatan = $lsdata->jabatan;
                        $eselon = $lsdata->eselon;
                        $id_unit_kerja_me = $lsdata->id_unit_kerja_me;
                        $unit_kerja_me = $lsdata->unit_kerja_me;

                        /* Atasan Langsung */
                        $id_bos_atsl = $lsdata->id_bos_atsl;
                        $id_pegawai_atsl = $lsdata->id_pegawai_atsl;
                        $nip_baru_atsl = $lsdata->nip_baru_atsl;
                        $nama_atsl = $lsdata->nama_atsl;
                        $gol_atsl = $lsdata->gol_atsl;
                        $jabatan_atsl = $lsdata->jabatan_atsl;

                        /* Plh. Atasan Langsung */
                        $id_bos_atsl_plh = $lsdata->id_bos_atsl_plh;
                        $id_pegawai_atsl_plh = $lsdata->idp_plh_atsl;
                        $nip_baru_atsl_plh = $lsdata->nip_baru_atsl_plh;
                        $nama_atsl_plh = $lsdata->nama_atsl_plh;
                        $gol_atsl_plh = $lsdata->gol_atsl_plh;
                        $jabatan_atsl_plh = $lsdata->jabatan_atsl_plh;

                        /* Pejabat Berwenang */
                        $id_bos_pjbt = $lsdata->id_bos_pjbt;
                        $id_pegawai_pjbt = $lsdata->id_pegawai_pjbt;
                        $nip_baru_pjbt = $lsdata->nip_baru_pjbt;
                        $nama_pjbt = $lsdata->nama_pjbt;
                        $gol_pjbt = $lsdata->gol_pjbt;
                        $jabatan_pjbt = $lsdata->jabatan_pjbt;

                        /* Plh. Pejabat Berwenang */
                        $id_bos_pjbt_plh = $lsdata->id_bos_pjbt_plh;
                        $id_pegawai_pjbt_plh = $lsdata->idp_plh_pjbt;
                        $nip_baru_pjbt_plh = $lsdata->nip_baru_pjbt_plh;
                        $nama_pjbt_plh = $lsdata->nama_pjbt_plh;
                        $gol_pjbt_plh = $lsdata->gol_pjbt_plh;
                        $jabatan_pjbt_plh = $lsdata->jabatan_pjbt_plh;
                    }
                }
            }
        }else{
            $id_pegawai = $lsdata->id_pegawai;
            $nip_baru = $lsdata->nip_baru;
            $nama = $lsdata->nama;
            $pangkat_gol = $lsdata->pangkat_gol;
            $jenjab = $lsdata->jenjab;
            $status_pegawai = $lsdata->status_pegawai;
            $kode_jabatan = $lsdata->kode_jabatan;
            $kelas_jabatan = $lsdata->kelas_jabatan;
            $nilai_jabatan = $lsdata->nilai_jabatan;
            $tunjangan = $lsdata->tunjangan;
            $jabatan = $lsdata->jabatan;
            $eselon = $lsdata->eselon;
            $id_unit_kerja_me = $lsdata->id_unit_kerja_me;
            $unit_kerja_me = $lsdata->unit_kerja_me;

            /* Atasan Langsung */
            $id_bos_atsl = $lsdata->id_bos_atsl;
            $id_pegawai_atsl = $lsdata->id_pegawai_atsl;
            $nip_baru_atsl = $lsdata->nip_baru_atsl;
            $nama_atsl = $lsdata->nama_atsl;
            $gol_atsl = $lsdata->gol_atsl;
            $jabatan_atsl = $lsdata->jabatan_atsl;

            /* Plh. Atasan Langsung */
            $id_bos_atsl_plh = $lsdata->id_bos_atsl_plh;
            $id_pegawai_atsl_plh = $lsdata->idp_plh_atsl;
            $nip_baru_atsl_plh = $lsdata->nip_baru_atsl_plh;
            $nama_atsl_plh = $lsdata->nama_atsl_plh;
            $gol_atsl_plh = $lsdata->gol_atsl_plh;
            $jabatan_atsl_plh = $lsdata->jabatan_atsl_plh;

            /* Pejabat Berwenang */
            $id_bos_pjbt = $lsdata->id_bos_pjbt;
            $id_pegawai_pjbt = $lsdata->id_pegawai_pjbt;
            $nip_baru_pjbt = $lsdata->nip_baru_pjbt;
            $nama_pjbt = $lsdata->nama_pjbt;
            $gol_pjbt = $lsdata->gol_pjbt;
            $jabatan_pjbt = $lsdata->jabatan_pjbt;

            /* Plh. Pejabat Berwenang */
            $id_bos_pjbt_plh = $lsdata->id_bos_pjbt_plh;
            $id_pegawai_pjbt_plh = $lsdata->idp_plh_pjbt;
            $nip_baru_pjbt_plh = $lsdata->nip_baru_pjbt_plh;
            $nama_pjbt_plh = $lsdata->nama_pjbt_plh;
            $gol_pjbt_plh = $lsdata->gol_pjbt_plh;
            $jabatan_pjbt_plh = $lsdata->jabatan_pjbt_plh;
        }

        $kegiatan_kategori_id = ((isset($kegiatan_kategori_id) and $kegiatan_kategori_id!=NULL and $kegiatan_kategori_id!='')?$kegiatan_kategori_id:0);
        $rdbHistAlihTugasUbah = '';
        array_push($id_atasan_list, $lsdata->id_pegawai_atsl);
        array_push($id_atasan_list, $lsdata->id_pegawai_pjbt);
    }

    if(isset($data_dasar) and sizeof($data_dasar)==0){
        echo "Data dasar aktual belum tersedia";
        die;
    }
}else{
    if (isset($data_dasar_keg) and $data_dasar_keg!=NULL and isset($data_dasar_keg) and sizeof($data_dasar_keg) > 0 and $data_dasar_keg != ''){
        $id_atasan_list = array();
        foreach ($data_dasar_keg as $lsdata) {
            $id_pegawai = $lsdata->id_pegawai_pelapor;
            $nip_baru = $lsdata->nip_baru;
            $nama = $lsdata->nama;
            $pangkat_gol = $lsdata->last_gol;
            $jenjab = $lsdata->last_jenjab;
            $status_pegawai = $lsdata->status_pegawai;
            $kode_jabatan = $lsdata->last_kode_jabatan;
            $kelas_jabatan = $lsdata->kelas_jabatan;
            $nilai_jabatan = $lsdata->nilai_jabatan;
            $tunjangan = $lsdata->tunjangan;
            $jabatan = $lsdata->last_jabatan;
            $eselon = $lsdata->last_eselon;
            $id_unit_kerja_me = $lsdata->last_id_unit_kerja;
            $unit_kerja_me = $lsdata->last_unit_kerja;

            /* Atasan Langsung */
            $id_bos_atsl = $lsdata->last_atsl_id_j;
            $id_pegawai_atsl = $lsdata->last_atsl_idp;
            $nip_baru_atsl = $lsdata->last_atsl_nip;
            $nama_atsl = $lsdata->last_atsl_nama;
            $gol_atsl = $lsdata->last_atsl_gol;
            $jabatan_atsl = $lsdata->last_atsl_jabatan;

            /* Plh. Atasan Langsung */
            $id_bos_atsl_plh = $lsdata->id_bos_atsl_plh;
            $id_pegawai_atsl_plh = $lsdata->idp_plh_atsl;
            $nip_baru_atsl_plh = $lsdata->nip_baru_atsl_plh;
            $nama_atsl_plh = $lsdata->nama_atsl_plh;
            $gol_atsl_plh = $lsdata->gol_atsl_plh;
            $jabatan_atsl_plh = $lsdata->jabatan_atsl_plh;

            /* Pejabat Berwenang */
            $id_bos_pjbt = $lsdata->last_pjbt_id_j;
            $id_pegawai_pjbt = $lsdata->last_pjbt_idp;
            $nip_baru_pjbt = $lsdata->last_pjbt_nip;
            $nama_pjbt = $lsdata->last_pjbt_nama;
            $gol_pjbt = $lsdata->last_pjbt_gol;
            $jabatan_pjbt = $lsdata->last_pjbt_jabatan;

            /* Plh. Pejabat Berwenang */
            $id_bos_pjbt_plh = $lsdata->id_bos_pjbt_plh;
            $id_pegawai_pjbt_plh = $lsdata->idp_plh_pjbt;
            $nip_baru_pjbt_plh = $lsdata->nip_baru_pjbt_plh;
            $nama_pjbt_plh = $lsdata->nama_pjbt_plh;
            $gol_pjbt_plh = $lsdata->gol_pjbt_plh;
            $jabatan_pjbt_plh = $lsdata->jabatan_pjbt_plh;

            array_push($id_atasan_list, $id_pegawai_atsl);
        }
    }
    $kegiatan_kategori_id = ((isset($kegiatan_kategori_id) and $kegiatan_kategori_id!=NULL and $kegiatan_kategori_id!='')?$kegiatan_kategori_id:0);
    $idknj_satuan_output = 0;

    if (isset($data_kegiatan) and $data_kegiatan!=NULL and sizeof($data_kegiatan) > 0 and $data_kegiatan != ''){
        foreach ($data_kegiatan as $lsdata) {
            $id_knj_kegiatan = $lsdata->id_knj_kegiatan;
            $kegiatan_kategori_id = $lsdata->kegiatan_kategori_id;
            $tgl_kegiatan = $lsdata->tgl_kegiatan;
            $jam_kegiatan = $lsdata->jam_kegiatan;
            $jam_kegiatan = explode(':',$jam_kegiatan);
            $jam = $jam_kegiatan[0];
            $menit = $jam_kegiatan[1];
            $kegiatan_rincian = $lsdata->kegiatan_rincian;
            $kegiatan_keterangan = $lsdata->kegiatan_keterangan;
            $durasi_menit = $lsdata->durasi_menit;
            $kuantitas = $lsdata->kuantitas;
            $idknj_satuan_output = $lsdata->satuan;
            $tgl_create = $lsdata->tgl_create;
            $rdbHistAlihTugasUbah = $lsdata->idknj_hist_alih_tugas;
            $idSkp = $lsdata->id_skp;
        }
    }

    if(isset($data_dasar_keg) and sizeof($data_kegiatan)==0){
        echo "Data dasar aktual belum tersedia";
        die;
    }else{
        if(isset($data_dasar_keg) and sizeof($data_kegiatan)>0){
        }else{
            echo "Data dasar aktual belum tersedia";
            die;
        }
    }
}


// Jika atsl walikota
if(isset($nip_baru_atsl) and $nip_baru_atsl!='' and !is_numeric($nip_baru_atsl)){
    $id_pegawai_pjbt = 1;
}

?>
<?php //print_r($tx_result); ?>
<?php if($tx_result == 'true' and $tx_result!=''): ?>
    <div class="container bg-emerald fg-white" style="margin-bottom: 10px;">
        <div class="cell-12 text-center" style="font-size: small;"><strong>Selamat</strong> Data sukses tersimpan. <?php echo $title_result.' '.($upload_kode!=0?$upload_status:''); ?></div>
    </div>
<?php elseif($tx_result == 'false' and $tx_result!=''): ?>
    <div class="container bg-red fg-white" style="margin-bottom: 10px;">
        <div class="cell-12 text-center" style="font-size: small;"><strong>Maaf</strong> Data tidak tersimpan. <?php echo $title_result.' '.($upload_kode!=0?$upload_status:''); ?></div>
    </div>
<?php endif; ?>

<ul class="tabs-expand-md" data-role="tabs" style="font-size: small;font-weight: bold;">
    <li id="tbForm" class="active"><a href="#tab1">Formulir</a></li>
    <li id="tbDataDasar"><a href="#tab2">Data Dasar Aktual</a></li>
</ul>
<div class="border bd-default no-border-top p-2">
    <div id="tab1">
        <form action="" method="post" id="frmAddKinerja" novalidate="novalidate" enctype="multipart/form-data" class="custom-validation need-validation">
            <div class="row mb-2">
                <div class="cell-sm-6">
                    <input id="id_knj_kegiatan" name="id_knj_kegiatan" type="hidden" value="<?php echo ((isset($id_knj_kegiatan) and $id_knj_kegiatan!=NULL and $id_knj_kegiatan!='')?$id_knj_kegiatan:''); ?>">
                    <input id="submitok" name="submitok" type="hidden" value="1">
                    <input id="input_type" name="input_type" type="hidden" value="<?php echo (isset($input_type) and $input_type!=NULL and $input_type!='')?$input_type:''; ?>">
                    <input id="id_pegawai" name="id_pegawai" type="hidden" value="<?php echo (isset($id_pegawai) and $id_pegawai!=NULL and $id_pegawai!='')?$id_pegawai:''; ?>" />
                    <input id="last_jenjab" name="last_jenjab" type="hidden" value="<?php echo (isset($jenjab) and $jenjab!=NULL and $jenjab!='')?$jenjab:''; ?>" />
                    <input id="last_kode_jabatan" name="last_kode_jabatan" type="hidden" value="<?php echo (isset($kode_jabatan) and $kode_jabatan!=NULL and $kode_jabatan!='')?$kode_jabatan:''; ?>" />
                    <input id="last_jabatan" name="last_jabatan" type="hidden" value="<?php echo (isset($jabatan) and $jabatan!=NULL and $jabatan!='')?$jabatan:''; ?>" />
                    <input id="last_eselon" name="last_eselon" type="hidden" value="<?php echo (isset($eselon) and $eselon!=NULL and $eselon!='')?$eselon:''; ?>" />
                    <input id="last_gol" name="last_gol" type="hidden" value="<?php echo (isset($pangkat_gol) and $pangkat_gol!=NULL and $pangkat_gol!='')?$pangkat_gol:''; ?>" />
                    <input id="last_id_unit_kerja" name="last_id_unit_kerja" type="hidden" value="<?php echo (isset($id_unit_kerja_me) and $id_unit_kerja_me!=NULL and $id_unit_kerja_me!='')?$id_unit_kerja_me:''; ?>" />
                    <input id="last_unit_kerja" name="last_unit_kerja" type="hidden" value="<?php echo (isset($unit_kerja_me) and $unit_kerja_me!=NULL and $unit_kerja_me!='')?$unit_kerja_me:''; ?>" />
                    <input id="last_atsl_idp" name="last_atsl_idp" type="hidden" value="<?php echo (isset($id_pegawai_atsl) and $id_pegawai_atsl!=NULL and $id_pegawai_atsl!='')?$id_pegawai_atsl:''; ?>" />
                    <input id="last_atsl_nip" name="last_atsl_nip" type="hidden" value="<?php echo (isset($nip_baru_atsl) and $nip_baru_atsl!=NULL and $nip_baru_atsl!='')?$nip_baru_atsl:''; ?>" />
                    <input id="last_atsl_nama" name="last_atsl_nama" type="hidden" value="<?php echo (isset($nama_atsl) and $nama_atsl!=NULL and $nama_atsl!='')?$nama_atsl:''; ?>" />
                    <input id="last_atsl_gol" name="last_atsl_gol" type="hidden" value="<?php echo (isset($gol_atsl) and $gol_atsl!=NULL and $gol_atsl!='')?$gol_atsl:''; ?>" />
                    <input id="last_atsl_jabatan" name="last_atsl_jabatan" type="hidden" value="<?php echo (isset($jabatan_atsl) and $jabatan_atsl!=NULL and $jabatan_atsl!='')?$jabatan_atsl:''; ?>" />
                    <input id="last_atsl_id_j" name="last_atsl_id_j" type="hidden" value="<?php echo (isset($id_bos_atsl) and $id_bos_atsl!=NULL and $id_bos_atsl!='')?$id_bos_atsl:''; ?>" />
                    <input id="last_pjbt_idp" name="last_pjbt_idp" type="hidden" value="<?php echo (isset($id_pegawai_pjbt) and $id_pegawai_pjbt!=NULL and $id_pegawai_pjbt!='')?$id_pegawai_pjbt:''; ?>" />
                    <input id="last_pjbt_nip" name="last_pjbt_nip" type="hidden" value="<?php echo (isset($nip_baru_pjbt) and $nip_baru_pjbt!=NULL and $nip_baru_pjbt!='')?$nip_baru_pjbt:''; ?>" />
                    <input id="last_pjbt_nama" name="last_pjbt_nama" type="hidden" value="<?php echo (isset($nama_pjbt) and $nama_pjbt!=NULL and $nama_pjbt!='')?$nama_pjbt:''; ?>" />
                    <input id="last_pjbt_gol" name="last_pjbt_gol" type="hidden" value="<?php echo (isset($gol_pjbt) and $gol_pjbt!=NULL and $gol_pjbt!='')?$gol_pjbt:''; ?>" />
                    <input id="last_pjbt_jabatan" name="last_pjbt_jabatan" type="hidden" value="<?php echo (isset($jabatan_pjbt) and $jabatan_pjbt!=NULL and $jabatan_pjbt!='')?$jabatan_pjbt:''; ?>" />
                    <input id="last_pjbt_id_j" name="last_pjbt_id_j" type="hidden" value="<?php echo (isset($id_bos_pjbt) and $id_bos_pjbt!=NULL and $id_bos_pjbt!='')?$id_bos_pjbt:''; ?>" />
                    <input id="last_status_pegawai" name="last_status_pegawai" type="hidden" value="<?php echo (isset($status_pegawai) and $status_pegawai!=NULL and $status_pegawai!='')?$status_pegawai:''; ?>" />

                    <input id="last_atsl_idp_plh" name="last_atsl_idp_plh" type="hidden" value="<?php echo (isset($id_pegawai_atsl_plh) and $id_pegawai_atsl_plh!=NULL and $id_pegawai_atsl_plh!='')?$id_pegawai_atsl_plh:''; ?>" />
                    <input id="last_atsl_nip_plh" name="last_atsl_nip_plh" type="hidden" value="<?php echo (isset($nip_baru_atsl_plh) and $nip_baru_atsl_plh!=NULL and $nip_baru_atsl_plh!='')?$nip_baru_atsl_plh:''; ?>" />
                    <input id="last_atsl_nama_plh" name="last_atsl_nama_plh" type="hidden" value="<?php echo (isset($nama_atsl_plh) and $nama_atsl_plh!=NULL and $nama_atsl_plh!='')?$nama_atsl_plh:''; ?>" />
                    <input id="last_atsl_gol_plh" name="last_atsl_gol_plh" type="hidden" value="<?php echo (isset($gol_atsl_plh) and $gol_atsl_plh!=NULL and $gol_atsl_plh!='')?$gol_atsl_plh:''; ?>" />
                    <input id="last_atsl_jabatan_plh" name="last_atsl_jabatan_plh" type="hidden" value="<?php echo (isset($jabatan_atsl_plh) and $jabatan_atsl_plh!=NULL and $jabatan_atsl_plh!='')?$jabatan_atsl_plh:''; ?>" />
                    <input id="last_atsl_id_j_plh" name="last_atsl_id_j_plh" type="hidden" value="<?php echo (isset($id_bos_atsl_plh) and $id_bos_atsl_plh!=NULL and $id_bos_atsl_plh!='')?$id_bos_atsl_plh:''; ?>" />

                    <input id="last_pjbt_idp_plh" name="last_pjbt_idp_plh" type="hidden" value="<?php echo (isset($id_pegawai_pjbt_plh) and $id_pegawai_pjbt_plh!=NULL and $id_pegawai_pjbt_plh!='')?$id_pegawai_pjbt_plh:''; ?>" />
                    <input id="last_pjbt_nip_plh" name="last_pjbt_nip_plh" type="hidden" value="<?php echo (isset($nip_baru_pjbt_plh) and $nip_baru_pjbt_plh!=NULL and $nip_baru_pjbt_plh!='')?$nip_baru_pjbt_plh:''; ?>" />
                    <input id="last_pjbt_nama_plh" name="last_pjbt_nama_plh" type="hidden" value="<?php echo (isset($nama_pjbt_plh) and $nama_pjbt_plh!=NULL and $nama_pjbt_plh!='')?$nama_pjbt_plh:''; ?>" />
                    <input id="last_pjbt_gol_plh" name="last_pjbt_gol_plh" type="hidden" value="<?php echo (isset($gol_pjbt_plh) and $gol_pjbt_plh!=NULL and $gol_pjbt_plh!='')?$gol_pjbt_plh:''; ?>" />
                    <input id="last_pjbt_jabatan_plh" name="last_pjbt_jabatan_plh" type="hidden" value="<?php echo (isset($jabatan_pjbt_plh) and $jabatan_pjbt_plh!=NULL and $jabatan_pjbt_plh!='')?$jabatan_pjbt_plh:''; ?>" />
                    <input id="last_pjbt_id_j_plh" name="last_pjbt_id_j_plh" type="hidden" value="<?php echo (isset($id_bos_pjbt_plh) and $id_bos_pjbt_plh!=NULL and $id_bos_pjbt_plh!='')?$id_bos_pjbt_plh:''; ?>" />

                    <div class="row mb-2">
                        <div class="cell-sm-11">
                            <fieldset>
                                <?php
                                echo 'Periode : '.$this->umum->monthName(date("m")).' '.date("Y").'<br>';
                                $jmlHistAt = $this->ekinerja->get_jml_hist_alih_tugas();
                                //echo $this->session->userdata('id_pegawai_enc');

                                if($jmlHistAt==0) {
                                    echo 'Belum pernah melakukan input aktifitas. Pastikan data dasar aktual yang mencakup informasi jabatan dan atasan sudah sesuai.';
                                    $lastTimeKegiatan = $this->ekinerja->get_wkt_selesai_kegiatan_terakhir($this->session->userdata('id_pegawai_enc'), (date("m")==12?1:date("m")-1), (date("m")==12?date("Y")-1:date("Y")));
                                    if ($lastTimeKegiatan!=NULL and sizeof($lastTimeKegiatan) > 0 and $lastTimeKegiatan != ''){
                                        foreach ($lastTimeKegiatan as $ltk){
                                            $wkt_kegiatan = $ltk->kegiatan_durasi;
                                        }
                                        echo '<br><small>Kegiatan terakhir selesai pada '.$wkt_kegiatan.'</small>';
                                    }
                                }elseif($jmlHistAt==1){
                                    echo 'Sudah pernah melakukan input aktifitas.';
                                    if ($lastTimeKegiatan!=NULL and sizeof($lastTimeKegiatan) > 0 and $lastTimeKegiatan != ''){
                                        foreach ($lastTimeKegiatan as $ltk){
                                            $wkt_kegiatan = $ltk->kegiatan_durasi;
                                        }
                                        echo '<br><small>Kegiatan terakhir selesai pada '.$wkt_kegiatan.'</small>';
                                    }
                                }elseif($jmlHistAt > 1){
                                    echo 'Sudah pernah melakukan input aktifitas.';
                                    if ($lastTimeKegiatan!=NULL and sizeof($lastTimeKegiatan) > 0 and $lastTimeKegiatan != ''){
                                        foreach ($lastTimeKegiatan as $ltk){
                                            $wkt_kegiatan = $ltk->kegiatan_durasi;
                                        }
                                        echo '<br><small>Kegiatan terakhir selesai pada '.$wkt_kegiatan.'</small>';
                                    }
                                    echo '<br>Jika atasan langsung berbeda dengan Data Dasar Aktual, silahkan pilih dari daftar berikut ini : <br><span style="text-decoration: underline;font-weight: bold; font-size: small">Riwayat Atasan Langsung</span><br>';
                                    $dataHist = $this->ekinerja->data_ref_list_hist_alih_tugas_by_idpeg();
                                    $p = 1;
                                    foreach ($dataHist as $lsdataHist){
                                        echo "<small><label><input ".($lsdataHist->idknj_hist_alih_tugas==$rdbHistAlihTugas?'checked':(isset($rdbHistAlihTugasUbah) and $rdbHistAlihTugasUbah!=NULL and $rdbHistAlihTugasUbah!='')?($lsdataHist->idknj_hist_alih_tugas==$rdbHistAlihTugasUbah?'checked':''):'')." type=\"radio\" data-role=\"radio\" name=\"rdbHistAlihTugas\" id=\"rdbHistAlihTugas\" value=\"$lsdataHist->idknj_hist_alih_tugas#$lsdataHist->id_skp\" onclick=\"getSKPInfoById()\">";
                                        echo "<strong>$lsdataHist->atsl_nama</strong></label><br>$lsdataHist->atsl_jabatan<br>TMT SKP ($lsdataHist->id_skp): $lsdataHist->tmt2</small>";
                                        if($lsdataHist->atsl_nama_plh<>''){
                                            echo "<small>";
                                            echo "<span style='color: saddlebrown;'><br>PLH. Atasan Langsung :</span> <br>";
                                            echo '<strong>'.$lsdataHist->atsl_nama_plh.'</strong> <br>('.$lsdataHist->atsl_jabatan_plh.')';
                                            echo '</small>';
                                        }
                                        echo "<br><small>TMT e-Kinerja: ".$lsdataHist->tgl_update2."</small><br>";
                                        $p++;
                                    }
                                    //echo 'atau <a href="javascript:void(0);" onclick="getInfoBoxDataDasar()">Klik di sini</a> untuk mengubah data dasar.';
                                };
                                ?>
                                <hr style="border: 1px solid rgba(71,71,72,0.35);">
                                Tanggal Kegiatan :<br>
                                <?php if($input_type=='ubah'): ?>
                                    <label><input id="chkUbahWktKegiatan" name="chkUbahWktKegiatan" type="checkbox" data-role="checkbox" data-style="2">Ubah Waktu Kegiatan dan Durasi</label>
                                <?php endif; ?>
                                <input id="tglKegiatanOri" value="<?php echo((@$tgl_kegiatan!=NULL and @$tgl_kegiatan!='')?$tgl_kegiatan:''); ?>" name="tglKegiatanOri" type="hidden">
                                <div id="dvCalendar" class=""><input id="tglKegiatan" value="<?php echo((isset($tgl_kegiatan) and $tgl_kegiatan!=NULL and $tgl_kegiatan!='')?$tgl_kegiatan:date("Y/m/d")); ?>" name="tglKegiatan" type="text" data-role="calendarpicker" class="cell-sm-12" required ></div>
                                <small class="text-muted">Tanggal dilaksanakannya kegiatan.</small><br>
                                Waktu Kegiatan : <br>
                                <div id="dvTime" class="">
                                    <div class="row" style="border: 1px solid rgba(71,71,72,0.35); margin-left: 0px;margin-right: 0px;">
                                        <div class="cell-2" style="margin-top: 5px;">Jam</div>
                                        <div class="cell-4">
                                            <select id="ddJam" name="ddJam">
                                                <?php for($i=0;$i<=sizeof($listJam)-1;$i++){ ?>
                                                    <?php if ($listJam[$i] == ((isset($jam) and $jam!=NULL and $jam != '')?$jam:date("H"))): ?>
                                                        <option value="<?php echo $listJam[$i]; ?>" selected><?php echo $listJam[$i]; ?></option>
                                                    <?php else: ?>
                                                        <option value="<?php echo $listJam[$i]; ?>"><?php echo $listJam[$i]; ?></option>
                                                    <?php endif; ?>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="cell-2" style="margin-top: 5px;">Menit</div>
                                        <div class="cell-4">
                                            <select id="ddMenit" name="ddMenit" style="margin-right: 0px;">
                                                <?php for($i=0;$i<=sizeof($listMenit)-1;$i++){ ?>
                                                    <?php if ($listMenit[$i] == ((isset($menit) and $menit!=NULL and $menit != '')?$menit:date("i"))): ?>
                                                        <option value="<?php echo $listMenit[$i]; ?>" selected><?php echo $listMenit[$i]; ?></option>
                                                    <?php else: ?>
                                                        <option value="<?php echo $listMenit[$i]; ?>"><?php echo $listMenit[$i]; ?></option>
                                                    <?php endif; ?>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <small class="text-muted">Jam dilaksanakannya kegiatan.</small><br>
                                Durasi (menit) :<br>
                                <div id="dvDurasi"><input value="<?php echo((isset($durasi_menit) and $durasi_menit!=NULL and $durasi_menit!='')?$durasi_menit:''); ?>" type="text" id="txtDurasi" name="txtDurasi" class="cell-sm-12"></div>
                                <small class="text-muted">Waktu penyelesaian aktifitas dalam menit.</small><br>
                                <label>Tanggal Laporan Aktifitas</label>
                                <input value="<?php echo((isset($tgl_create) and $tgl_create!='')?$tgl_create:date('d-m-Y'));  ?>" type="text" id="tglPengajuan" name="tglPengajuan" class="cell-sm-12" readonly>
                                <small class="text-muted">Waktu dibuatnya usulan aktifitas kegiatan.</small>

                            </fieldset>
                        </div>
                    </div>
                </div>
                <div class="cell-sm-6">
                    <div id="dvInformasiSKP">
                        <div style="font-size: small; margin-bottom: -15px;"><span style="text-decoration: underline; font-weight: bold;">Informasi SKP</span><br>
                            <?php
                            if(@$jenjab!='' and @$kode_jabatan!=0 and @$kode_jabatan!='' and @$nilai_jabatan!=''){
                                //$list_stk_skp = Modules::run('publicpegawai/call_stk_skp', $jenjab,$eselon,$kode_jabatan);
                                if(isset($rdbHistAlihTugasUbah) and $rdbHistAlihTugasUbah!=NULL and $rdbHistAlihTugasUbah!=''){
                                    $list_stk_skp = Modules::run('publicpegawai/call_skp_by_id', $idSkp);
                                }else{
                                    $list_stk_skp = Modules::run('publicpegawai/call_skp');
                                }
                                if (is_array($list_stk_skp) && sizeof($list_stk_skp) > 0 and $list_stk_skp != ''){
                                    $existStkSkp = 1;
                                }else{
                                    $existStkSkp = 0;
                                }
                                $jabatanAda = true;

                            }else{
                                $existStkSkp = 0;
                                $jabatanAda = false;
                            }

                            if(@$rdbHistAlihTugasUbah!=NULL and @$rdbHistAlihTugasUbah!=''){
                                $info_skp = Modules::run('publicpegawai/call_info_last_skp_by_id', $idSkp);
                            }else{
                                $info_skp = Modules::run('publicpegawai/call_info_last_skp');
                            }

                            if (is_array($info_skp) && sizeof($info_skp) > 0 and $info_skp != ''){
                                $idpenilai = '';
                                foreach ($info_skp as $lsk){
                                    echo 'ID: '.$lsk->id_skp.' ('.$lsk->status.'). TMT: '.$lsk->periode_awal.'<br>';
                                    echo 'Atasan: '.$lsk->nama.'<br>';
                                    echo 'Unit Kerja: '.$lsk->unit_kerja;
                                    echo "<input type=\"hidden\" id=\"txtIdSkp\" name=\"txtIdSkp\" value='$lsk->id_skp'>";
                                    echo "<input type=\"hidden\" id=\"txtTmtSkp\" name=\"txtTmtSkp\" value='$lsk->tmt'>";
                                    $idpenilai = $lsk->id_penilai;
                                    $id_unit_kerja = $lsk->id_unit_kerja;
                                }
                            }else{
                                $idpenilai = '';
                                echo "<input type=\"hidden\" id=\"txtIdSkp\" name=\"txtIdSkp\" value=''>";
                                echo 'Tidak ada informasi SKP';
                            }

                            if($jmlHistAt==1){
                                if($id_pegawai_atsl==$idpenilai){
                                    $cekFirstSKP = 1;
                                }else{
                                    if (in_array($idpenilai, $id_atasan_list)){
                                        $cekFirstSKP = 1;
                                    }else {
                                        $cekFirstSKP = 0;
                                    }
                                }
                            }else{
                                if($jmlHistAt==0){
                                    if($id_pegawai_atsl==$idpenilai){
                                        $cekFirstSKP = 1;
                                    }else{
                                        if (in_array($idpenilai, $id_atasan_list)){
                                            $cekFirstSKP = 1;
                                        }else {
                                            if($input_lampau==false){
                                                $cekFirstSKP = 0;
                                            }else{
                                                $cekFirstSKP = 1;
                                            }
                                        }
                                    }
                                }else {
                                    $cekFirstSKP = 1;
                                }
                            }

                            ?></div><br>
                        <?php if($input_type=='ubah'):  ?>
                            <strong>Ubah Data Aktifitas</strong><br>
                        <?php endif; ?>

                        Kegiatan Tugas Jabatan :<br>
                        <?php
                        if(@$eselon!=''){
                            $checkJbtn = $this->ekinerja->get_result_check_admin_pratama_admin($kode_jabatan);
                        }
                        ?>
                        <select id="ddKatKegiatan" name="ddKatKegiatan" style="color: black" class="cell-sm-<?php echo($existStkSkp==0?'12':'12'); ?>"> <!--data-role="select" -->
                            <option value="0">Pilih Target Kegiatan</option>
                            <?php if(isset($rdbHistAlihTugasUbah) and $rdbHistAlihTugasUbah!=''): ?>
                                <?php $cekFirstSKP = 1; ?>
                                <?php if ($list_stk_skp!=NULL and sizeof($list_stk_skp) > 0 and $list_stk_skp != ''): ?>
                                    <?php foreach ($list_stk_skp as $ls): ?>
                                        <?php if ($ls->id == $kegiatan_kategori_id): ?>
                                            <option value="<?php echo $ls->id; ?>" selected><?php echo $ls->kegiatan; ?></option>
                                        <?php else: ?>
                                            <option value="<?php echo $ls->id; ?>"><?php echo $ls->kegiatan; ?></option>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                    <?php if($checkJbtn==1): ?>
                                        <option value="-2" <?php echo($kegiatan_kategori_id==-2?'selected':''); ?>>Instruksi Khusus Pimpinan (IKP) khusus JPT</option>
                                    <?php endif; ?>
                                    <option value="-1" <?php echo($kegiatan_kategori_id==-1?'selected':''); ?>>Tugas Tambahan</option>
                                    <option value="-4" <?php echo($kegiatan_kategori_id==-4?'selected':''); ?>>Tugas Tambahan Khusus</option>
                                    <option value="-3" <?php echo($kegiatan_kategori_id==-3?'selected':''); ?>>Penyesuaian Target Baru</option>
                                <?php endif; ?>
                            <?php else: ?>
                                <?php if($id_pegawai_atsl==$idpenilai): ?>
                                    <?php if ($list_stk_skp!=NULL and sizeof($list_stk_skp) > 0 and $list_stk_skp != ''): ?>
                                        <?php foreach ($list_stk_skp as $ls): ?>
                                            <?php if ($ls->id == $kegiatan_kategori_id): ?>
                                                <option value="<?php echo $ls->id; ?>" selected><?php echo $ls->kegiatan; ?></option>
                                            <?php else: ?>
                                                <option value="<?php echo $ls->id; ?>"><?php echo $ls->kegiatan; ?></option>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                        <?php if($checkJbtn==1): ?>
                                            <option value="-2" <?php echo($kegiatan_kategori_id==-2?'selected':''); ?>>Instruksi Khusus Pimpinan (IKP) khusus JPT</option>
                                        <?php endif; ?>
                                        <option value="-1" <?php echo($kegiatan_kategori_id==-1?'selected':''); ?>>Tugas Tambahan</option>
                                        <option value="-4" <?php echo($kegiatan_kategori_id==-4?'selected':''); ?>>Tugas Tambahan Khusus</option>
                                        <option value="-3" <?php echo($kegiatan_kategori_id==-3?'selected':''); ?>>Penyesuaian Target Baru</option>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <?php
                                    if(($id_unit_kerja_me == $id_unit_kerja) and (strpos($jabatan_atsl, 'Plt.')!==false?1:0)>0){
                                        $cekFirstSKP = 1; ?>
                                        <?php if ($list_stk_skp!=NULL and sizeof($list_stk_skp) > 0 and $list_stk_skp != ''): ?>
                                            <?php foreach ($list_stk_skp as $ls): ?>
                                                <?php if ($ls->id == $kegiatan_kategori_id): ?>
                                                    <option value="<?php echo $ls->id; ?>" selected><?php echo $ls->kegiatan; ?></option>
                                                <?php else: ?>
                                                    <option value="<?php echo $ls->id; ?>"><?php echo $ls->kegiatan; ?></option>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                            <?php if(isset($checkJbtn)==1): ?>
                                                <option value="-2" <?php echo($kegiatan_kategori_id==-2?'selected':''); ?>>Instruksi Khusus Pimpinan (IKP) khusus JPT</option>
                                            <?php endif; ?>
                                            <option value="-1" <?php echo($kegiatan_kategori_id==-1?'selected':''); ?>>Tugas Tambahan</option>
                                            <option value="-4" <?php echo($kegiatan_kategori_id==-4?'selected':''); ?>>Tugas Tambahan Khusus</option>
                                            <option value="-3" <?php echo($kegiatan_kategori_id==-3?'selected':''); ?>>Penyesuaian Target Baru</option>
                                        <?php endif; ?>
                                    <?php }else{
                                        if($id_pegawai==$id_pegawai_atsl){
                                            $cekFirstSKP = 1;
                                            ?>
                                            <?php if ($list_stk_skp!=NULL and sizeof($list_stk_skp) > 0 and $list_stk_skp != ''): ?>
                                                <?php foreach ($list_stk_skp as $ls): ?>
                                                    <?php if ($ls->id == $kegiatan_kategori_id): ?>
                                                        <option value="<?php echo $ls->id; ?>" selected><?php echo $ls->kegiatan; ?></option>
                                                    <?php else: ?>
                                                        <option value="<?php echo $ls->id; ?>"><?php echo $ls->kegiatan; ?></option>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                                <?php if(isset($checkJbtn)==1): ?>
                                                    <option value="-2" <?php echo($kegiatan_kategori_id==-2?'selected':''); ?>>Instruksi Khusus Pimpinan (IKP) khusus JPT</option>
                                                <?php endif; ?>
                                                <option value="-1" <?php echo($kegiatan_kategori_id==-1?'selected':''); ?>>Tugas Tambahan</option>
                                                <option value="-4" <?php echo($kegiatan_kategori_id==-4?'selected':''); ?>>Tugas Tambahan Khusus</option>
                                                <option value="-3" <?php echo($kegiatan_kategori_id==-3?'selected':''); ?>>Penyesuaian Target Baru</option>
                                            <?php endif; ?>
                                        <?php }else{
                                            if (in_array($idpenilai, $id_atasan_list)){
                                                $cekFirstSKP = 1;
                                                ?>
                                                <?php if ($list_stk_skp!=NULL and sizeof($list_stk_skp) > 0 and $list_stk_skp != ''): ?>
                                                    <?php foreach ($list_stk_skp as $ls): ?>
                                                        <?php if ($ls->id == $kegiatan_kategori_id): ?>
                                                            <option value="<?php echo $ls->id; ?>" selected><?php echo $ls->kegiatan; ?></option>
                                                        <?php else: ?>
                                                            <option value="<?php echo $ls->id; ?>"><?php echo $ls->kegiatan; ?></option>
                                                        <?php endif; ?>
                                                    <?php endforeach; ?>
                                                    <?php if(isset($checkJbtn)==1): ?>
                                                        <option value="-2" <?php echo($kegiatan_kategori_id==-2?'selected':''); ?>>Instruksi Khusus Pimpinan (IKP) khusus JPT</option>
                                                    <?php endif; ?>
                                                    <option value="-1" <?php echo($kegiatan_kategori_id==-1?'selected':''); ?>>Tugas Tambahan</option>
                                                    <option value="-4" <?php echo($kegiatan_kategori_id==-4?'selected':''); ?>>Tugas Tambahan Khusus</option>
                                                    <option value="-3" <?php echo($kegiatan_kategori_id==-3?'selected':''); ?>>Penyesuaian Target Baru</option>
                                                <?php endif; ?>
                                            <?php }else{
                                                if($input_lampau==false){
                                                    $cekFirstSKP = 0;
                                                }else{
                                                    $cekFirstSKP = 1;
                                                }
                                            }
                                        }
                                    }

                                    ?>
                                <?php endif; ?>
                            <?php endif; ?>
                        </select>

                    </div>

                    <?php
                    //echo $id_unit_kerja_me.'-'.$id_unit_kerja.'-'.$jabatan_atsl.'-'.$cekFirstSKP.'-'.(strpos($jabatan_atsl, 'Plt.')!==false?1:0);

                    if($existStkSkp==0){
                        if($jabatanAda == false){
                            echo '<span style="color: red;font-size: small;">Data jabatan (kelas dan nilai) belum ada</span><br>';
                        }else{
                            echo '<span style="color: red;font-size: small;">SKP beserta Daftar Kegiatan Tugas Jabatan yang sudah pernah diproses atasan belum ada</span><br>';
                        }
                    }else{
                        if($cekFirstSKP==0){
                            echo '<span style="color: red;font-size: small;">Atasan langsung aktual tidak sama dengan atasan langsung pada SKP terakhir, harap disesuaikan dahulu</span><br>';
                        }
                    }
                    ?>
                    <span id="jqv_msg"></span> <small class="text-muted">Induk Kegiatan pada SKP.</small><br>
                    Rincian Kegiatan :<br>
                    <textarea id="txtRincian" name="txtRincian" class="mb-1" title="" rows="3" style="resize: none;
                    text-align: left;"><?php echo((isset($kegiatan_rincian) and $kegiatan_rincian!='')?$kegiatan_rincian:''); ?></textarea>
                    <small class="text-muted">Detail penjelasan aktifitas kegiatan.</small><br>
                    Keterangan Tambahan :<br>
                    <textarea id="txtKet" name="txtKet" class="mb-1" title="" rows="3" style="resize: none;text-align: left;"><?php echo((isset($kegiatan_keterangan) and $kegiatan_keterangan!=NULL and $kegiatan_keterangan!='')?$kegiatan_keterangan:''); ?></textarea>
                    <small class="text-muted">Keterangan tambahan kegiatan.</small><br>
                    Kuantitas :<br>
                    <input value="<?php echo((isset($kuantitas) and $kuantitas!=NULL and $kuantitas!='')?$kuantitas:''); ?>" type="text" id="txtKuantitas" name="txtKuantitas" class="cell-sm-12">
                    <small class="text-muted">Jumlah hasil output yang dihasilkan.</small><br>
                    <?php $dataSatuan = $this->ekinerja->get_satuan_output(); ?>
                    Satuan :<br>
                    <select id="ddSatuan" name="ddSatuan" style="color: black" class="cell-sm-12"> <!-- data-role="select" -->
                        <option value="0">Pilih Satuan</option>
                        <?php if ($dataSatuan!=NULL and sizeof($dataSatuan) > 0 and $dataSatuan != ''): ?>
                            <?php foreach ($dataSatuan as $lsd): ?>
                                <?php if ($lsd->satuan_output == $idknj_satuan_output): ?>
                                    <option value="<?php echo $lsd->satuan_output; ?>" selected><?php echo $lsd->satuan_output; ?></option>
                                <?php else: ?>
                                    <option value="<?php echo $lsd->satuan_output; ?>"><?php echo $lsd->satuan_output; ?></option>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                    <span id="jqv_msg2"></span> <small class="text-muted">Satuan hasil output.</small><br>
                    Berkas Pendukung :<br>
                    <input class="cell-sm-12" type="file" id="fileEviden" name="fileEviden" style="font-size: small; padding-left: 0px;">
                    <small class="text-muted">Berkas pendukung dari aktifitas terkait.</small><br>
                    <a href="javascript:void(0)" onclick="resetFile()" style="font-size: small;"><span class="mif-cancel icon"></span> Kosongkan Berkas</a><br>
                    <div class="row" style="margin-top: 10px;margin-bottom: 25px;">
                        <div class="cell" style="margin-bottom: 10px;">
                            <button type="submit" class="button primary bg-green drop-shadow <?php echo((@$id_pegawai_atsl==0 or @$id_pegawai_pjbt==0)?'disabled':'') ?>"><span class="mif-floppy-disk icon"></span> Simpan</button>
                            <?php echo((@$id_pegawai_atsl==0 or @$id_pegawai_pjbt==0)?'<span style="color: red">&nbsp;&nbsp;Data dasar belum lengkap</span>':'') ?>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div id="tab2">
        <div data-role="panel">
            Pegawai yang melapor :
            <ul data-role="listview"
                data-view="table"
                data-select-node="true"
                data-structure='{"kolom": true, "nilai": true}'>
                <li data-caption="1" data-kolom="NIP" data-nilai="<?php echo '<strong>'.@$nip_baru.'</strong>';?>"></li>
                <li data-caption="2" data-kolom="Nama" data-nilai="<?php echo '<strong>'.@$nama.'</strong>';?>"></li>
                <li data-caption="3" data-kolom="Golongan" data-nilai="<?php echo @$pangkat_gol;?>"></li>
                <li data-caption="4" data-kolom="Jenjang" data-nilai="<?php echo @$jenjab;?>"></li>
                <li data-caption="5" data-kolom="Status" data-nilai="<?php echo @$status_pegawai;?>"></li>
                <li data-caption="6" data-kolom="Jabatan" data-nilai="<?php echo '('.@$kode_jabatan.') '.@$jabatan;?>"></li>
                <?php if (@$data_dasar_keg!=NULL and sizeof(@$data_dasar_keg) > 0 and @$data_dasar_keg != ''): ?>
                    <?php
                        if(strpos($unit_kerja_me, 'Badan Pendapatan Daerah') !== false
                            or strpos($unit_kerja_me, 'Puskesmas') !== false
                            or strpos(@$jabatan, 'Guru') !== false):
                        ?>
                        <li data-caption="7" data-kolom="Kelas &nbsp;" data-nilai="<?php echo $kelas_jabatan;?>"></li>
                    <?php else: ?>
                        <li data-caption="7" data-kolom="Kelas &nbsp;" data-nilai="<?php echo $kelas_jabatan.' Nilai: '.number_format($nilai_jabatan,0,",",".").' Tunjangan: Rp. '.number_format($tunjangan,0,",",".").(@$status_pegawai=='CPNS'?' (80%: '.number_format($tunjangan*0.8,0,",",".").')':'');?>"></li>
                    <?php endif; ?>
                    <li data-caption="8" data-kolom="Unit Kerja &nbsp;" data-nilai="<?php echo $unit_kerja_me;?>"></li>
                <?php else: ?>
                    <?php
                        if(strpos($unit_kerja_me, 'Badan Pendapatan Daerah') !== false
                            or strpos($unit_kerja_me, 'Puskesmas') !== false
                            or strpos(@$jabatan, 'Guru') !== false):
                        ?>
                            <li data-caption="7" data-kolom="Kelas &nbsp;" data-nilai="<?php echo @$kelas_jabatan;?>"></li>
                    <?php else: ?>
                            <li data-caption="7" data-kolom="Kelas &nbsp;" data-nilai="<?php echo @$kelas_jabatan.' Nilai: '.number_format(@$nilai_jabatan,0,",",".").' Tunjangan: Rp. '.number_format(@$tunjangan,0,",",".").(@$status_pegawai=='CPNS'?' (80%: '.number_format($tunjangan*0.8,0,",",".").')':'');?>"></li>
                    <?php endif; ?>

                    <li data-caption="8" data-kolom="Unit Kerja &nbsp; &nbsp; &nbsp; &nbsp;" data-nilai="<?php echo $unit_kerja_me;?>"></li>
                <?php endif; ?>
            </ul><br>
            <span style="text-decoration: underline;">Data atasan langsung dan pejabat berwenang <?php echo((isset($rdbHistAlihTugasUbah) and @$rdbHistAlihTugasUbah!='' and $data_dasar_keg!=NULL and sizeof($data_dasar_keg) > 0 and $data_dasar_keg != '')?'terakhir pada Laporan Kinerja periode':'aktual pada Laporan Kinerja'); ?> saat ini :</span><br>
            <br>Atasan Langsung :
            <ul data-role="listview"
                data-view="table"
                data-select-node="true"
                data-structure='{"kolom": true, "nilai": true}'>
                <li data-caption="1" data-kolom="NIP" data-nilai="<?php echo '<strong>'.(is_numeric($nip_baru_atsl)?$nip_baru_atsl:'-').'</strong>';?>"></li>
                <li data-caption="2" data-kolom="Nama" data-nilai="<?php echo '<strong>'.@$nama_atsl.'</strong>';?>"></li>
                <li data-caption="3" data-kolom="Golongan&nbsp;" data-nilai="<?php echo (is_numeric(@$nip_baru_atsl)?@$gol_atsl:'-');?>"></li>
                <li data-caption="4" data-kolom="Jabatan" data-nilai="<?php echo @$jabatan_atsl;?>"></li>
            </ul>

            <?php if($id_pegawai_atsl_plh<>'' and $id_pegawai_atsl_plh<>'0'): ?>
                <ul data-role="listview"
                    data-view="table"
                    data-select-node="false"
                    data-structure='{"kolom": true}'>
                    <li data-caption="" data-kolom="PLH. Atasan Langsung"></li>
                </ul>

                <ul data-role="listview"
                    data-view="table"
                    data-select-node="true"
                    data-structure='{"kolom": true, "nilai": true}'>
                    <li data-caption="1" data-kolom="NIP" data-nilai="<?php echo '<strong>'.(is_numeric($nip_baru_atsl_plh)?$nip_baru_atsl_plh:'-').'</strong>';?>"></li>
                    <li data-caption="2" data-kolom="Nama" data-nilai="<?php echo '<strong>'.@$nama_atsl_plh.'</strong>';?>"></li>
                    <li data-caption="3" data-kolom="Golongan&nbsp;" data-nilai="<?php echo (is_numeric(@$nip_baru_atsl_plh)?@$gol_atsl_plh:'-');?>"></li>
                    <li data-caption="4" data-kolom="Jabatan" data-nilai="<?php echo @$jabatan_atsl_plh;?>"></li>
                </ul>
            <?php endif; ?>

            <br>Pejabat Berwenang :
            <ul data-role="listview"
                data-view="table"
                data-select-node="true"
                data-structure='{"kolom": true, "nilai": true}'>
                <li data-caption="1" data-kolom="NIP" data-nilai="<?php echo '<strong>'.(is_numeric(@$nip_baru_atsl)?$nip_baru_pjbt:'-').'</strong>';?>"></li>
                <li data-caption="2" data-kolom="Nama" data-nilai="<?php echo '<strong>'.(is_numeric(@$nip_baru_atsl)?$nama_pjbt:'-').'</strong>';?>"></li>
                <li data-caption="3" data-kolom="Golongan&nbsp;" data-nilai="<?php echo (is_numeric(@$nip_baru_atsl)?$gol_pjbt:'-');?>"></li>
                <li data-caption="4" data-kolom="Jabatan" data-nilai="<?php echo (is_numeric(@$nip_baru_atsl)?$jabatan_pjbt:'-');?>"></li>
            </ul>

            <?php if($id_pegawai_pjbt_plh<>'' and $id_pegawai_pjbt_plh<>'0'): ?>
                <ul data-role="listview"
                    data-view="table"
                    data-select-node="false"
                    data-structure='{"kolom": true}'>
                    <li data-caption="" data-kolom="PLH. Pejabat Berwenang"></li>
                </ul>

                <ul data-role="listview"
                    data-view="table"
                    data-select-node="true"
                    data-structure='{"kolom": true, "nilai": true}'>
                    <li data-caption="1" data-kolom="NIP" data-nilai="<?php echo '<strong>'.(is_numeric(@$nip_baru_pjbt_plh)?$nip_baru_pjbt_plh:'-').'</strong>';?>"></li>
                    <li data-caption="2" data-kolom="Nama" data-nilai="<?php echo '<strong>'.(is_numeric(@$nip_baru_pjbt_plh)?$nama_pjbt_plh:'-').'</strong>';?>"></li>
                    <li data-caption="3" data-kolom="Golongan&nbsp;" data-nilai="<?php echo (is_numeric(@$nip_baru_pjbt_plh)?$gol_pjbt_plh:'-');?>"></li>
                    <li data-caption="4" data-kolom="Jabatan" data-nilai="<?php echo (is_numeric(@$nip_baru_pjbt_plh)?$jabatan_pjbt_plh:'-');?>"></li>
                </ul>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
    jQuery.validator.addMethod(
        "selectComboJenis",
        function (value, element)
        {
            if (element.value === "0") {
                return false;
            }else {
                return true;
            }
        },
        "*"
    );

    $( "#ddKatKegiatan" ).addClass( "selectComboJenis" );
    $( "#ddSatuan" ).addClass( "selectComboJenis" );

    $(function(){

        <?php if($input_type=='ubah'): ?>
        $("#dvCalendar").addClass("disabled");
        $("#dvTime").addClass("disabled");
        $("#dvDurasi").addClass("disabled");
        <?php endif; ?>

        var fileEvidenAdd = 0;
        $('#fileEviden').bind('change', function() {
            fileEvidenAdd = this.files[0].size;
        });

        $("#frmAddKinerja").validate({
            errorClass: 'errors',
            ignore: "",
            rules: {
                tglKegiatan: {
                    required: true
                },
                jamKegiatan: {
                    required: true
                },
                txtRincian: {
                    required: true
                },
                txtKet: {
                    required: true
                },
                txtDurasi: {
                    required: true,
                    number:true
                },
                txtKuantitas: {
                    required: true,
                    number:true
                }
            },
            messages: {
                tglKegiatan: {
                    required: "*"
                },
                jamKegiatan: {
                    required: "*"
                },
                txtRincian: {
                    required: "*"
                },
                txtKet: {
                    required: "*"
                },
                txtDurasi: {
                    required: "*",
                    number: "Harus format angka"
                },
                txtKuantitas: {
                    required: "*",
                    number: "Harus format angka"
                }
            },
            errorPlacement: function(error, element) {
                switch (element.attr("name")) {
                    case 'ddKatKegiatan':
                        error.insertAfter($("#jqv_msg"));
                        break;
                    case 'ddSatuan':
                        error.insertAfter($("#jqv_msg2"));
                        break;
                    default:
                        error.insertAfter(element);
                }
            },
            submitHandler: function(form) {
                if (parseFloat(fileEvidenAdd) > 2138471) {
                    alert('Ukuran file terlalu besar');
                } else {
                    var myVar = $('input[name=rdbHistAlihTugas]:checked', '#frmAddKinerja').val();
                    var jmlAtasan = <?php echo $jmlHistAt; ?>;
                    if (typeof myVar !== 'undefined'){
                        form.submit();
                    }else{
                        if(jmlAtasan > 1){
                            alert('Pilih dahulu atasan langsung');
                        }else{
                            form.submit();
                        }
                    }
                }
            }
        });
    });

    function getSKPInfoById(){
        var rdbHistAlihTugas = $("input[name='rdbHistAlihTugas']:checked").val();
        var id_skp = rdbHistAlihTugas.split("#");
        id_skp = id_skp[1];
        $("#dvInformasiSKP").html('Loading...');
        var jc = $.confirm({
            title: '',
            closeIconClass: 'fa fa-close',
            closeIcon: null,
            closeIconClass: false,
            boxWidth: '200px',
            useBootstrap: false,
            content: function () {
                var data = new FormData();
                data.append('id_skp', id_skp);
                data.append('jenjab', '<?php echo $jenjab; ?>');
                data.append('kode_jabatan', <?php echo $kode_jabatan; ?>);
                data.append('eselon', '<?php echo @$eselon; ?>');
                return $.ajax({
                    url: "<?php echo base_url($usr)."/get_info_skp/";?>",
                    data: data,
                    cache: false,
                    contentType: false,
                    processData: false,
                    method: 'POST',
                }).done(function (data) {
                    $("#dvInformasiSKP").html(data);
                    $("#dvInformasiSKP").find("script").each(function(i) {
                        eval($(this).text());
                    });
                    $('#frmAddKinerja').valid();
                }).fail(function(){
                    $("#dvInformasiSKP").html('Error...telah terjadi kesalahan');
                });
            },
            onContentReady: function () {
                jc.close();
            },
            buttons: {
                refreshList: {
                    text: '.',
                    action: function () {}
                }
            }
        });
    }

    function getInfoBoxDataDasar(){
        var el = Metro.infobox.create(
            "Memuat data...",
            "",
            {
                closeButton: false,
                height: 500,
                width: 1000,
                onOpen: function () {
                    var idbox;
                    var ib = $(this).data("infobox");
                    $.ajax({
                        method: "GET",
                        url: "<?php echo base_url($usr)."/open_datadasar_infobox/";?>",
                        dataType: "html"
                    }).done(function( data ) {
                        $("#contentInfo").html(data);
                        $("#contentInfo").find("script").each(function(i) {
                            eval($(this).text());
                        });
                    });
                    idbox =$(this)[0].id;
                    ib.setContent("<div class=\"grid\"><div class=\"row\"><div class=\"cell-12\" style=\"max-height: 500px; overflow-y: scroll; height: 425px;\"><div id=\"contentInfo\"></div></div></div><div class=\"row\" style='background-color: lightgrey;padding: 5px;'><div class=\"cell-12\" style='text-align: right;'><button class=\"button success drop-shadow\"><span class=\"mif-checkmark\"></span> Pilih</button> <button class=\"button drop-shadow\" onclick=\"$('#"+idbox+"').data('infobox').close()\" style='margin-right: -10px;'><span class=\"mif-cross\"></span> Tutup</button></div></div></div>");
                }
            }
        );

    }

    function resetFile(){
        var el = $('#fileEviden');
        el.wrap('<form>').closest('form').get(0).reset();
        el.unwrap();
    }

    $("#chkUbahWktKegiatan").change(function () {
        if ($('#chkUbahWktKegiatan').is(":checked") == true){
            $("#dvCalendar").removeClass("disabled");
            $("#dvTime").removeClass("disabled");
            $("#dvDurasi").removeClass("disabled");
            //document.getElementById("tglKegiatan").disabled = false;
            //$("#dvCalendar *").prop('disabled',false);
            //$("#tglKegiatan").calendarpicker;
        }else{
            $("#dvCalendar").addClass("disabled");
            $("#dvTime").addClass("disabled");
            $("#dvDurasi").addClass("disabled");
            //$("#tglKegiatan").addClass("disabled");
            //$("#tglKegiatan").css("color", "black");
        }
    });

</script>
