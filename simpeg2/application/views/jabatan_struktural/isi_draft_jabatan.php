<style>
    .spannew{
        width: 90px !important;
    }
    .spannew2{
        width: 140px !important;
    }
</style>
<div class="panel">
    <div class="panel-header bg-cyan fg-white"><?php echo "<strong>".$jabatan->jabatan."</strong><br/> Eselon ".$jabatan->eselon; ?>
        <br/> Golongan terendah <span id='gol_min'><?php echo $jabatan->gol_minimal; ?></span>
        <div style="font-size: x-small">
            Syarat Jabatan :
            <?php if($jabatan->eselon=='IIIA'): ?>
            <ol style="font-size: x-small; margin-top: -5px; color: white">
                <li>tingkat pendidikan paling rendah Sarjana (S.1)</li>
                <li>memiliki integritas dan moral yang baik</li>
                <li>memiliki pangkat paling rendah Penata Tingkat I golongan ruang III/d dengan masa golongan paling sedikit 3 (tiga) tahun untuk yang akan diangkat (promosi) dari jabatan struktural</li>
                <li>memiliki pangkat paling rendah Pembina golongan ruang IV/a dengan masa golongan paling sedikit 2 (dua) tahun untuk yang akan diangkat (promosi) dari jabatan Fungsional</li>
                <!--<li>pernah menduduki pada 2 (dua) jabatan struktural eselon III.b yang berbeda dengan masa jabatan (kumulatif) paling kurang selama 2 (dua) tahun untuk yang akan diangkat (promosi) dari jabatan struktural</li>-->
                <li>memiliki sertifikasi Pengadaan Barang dan Jasa</li>
                <li>tidak sedang menjalani Hukuman Disiplin Pegawai baik tingkat sedang maupun berat</li>
            </ol>
            <?php elseif($jabatan->eselon=='IIIB'): ?>
            <ol style="font-size: x-small; margin-top: -5px; color: white">
                <li>tingkat pendidikan paling rendah Sarjana (S.1) atau Diploma IV (D.IV)</li>
                <li>memiliki pangkat paling rendah Penata golongan ruang III/c paling sedikit 3 (tiga) tahun untuk yang akan diangkat (promosi) dari jabatan struktural</li>
                <li>memiliki pangkat paling rendah Penata Tingkat I golongan ruang III/d dengan masa golongan paling sedikit 2 (dua) tahun untuk yang akan diangkat (promosi) dari jabatan Fungsional</li>
                <!--<li>pernah menduduki pada 2 (dua) jabatan struktural eselon IV.a dan/atau eselon IV.b paling sedikit 4 (empat) tahun (kumulatif) untuk yang akan diangkat (promosi) dari jabatan struktural</li>-->
                <li>telah mengikuti dan lulus Pendidikan dan Pelatihan Kepemimpinan Tingkat IV</li>
                <li>memiliki sertifikasi Pengadaan Barang dan Jasa</li>
                <li>tidak sedang menjalani Hukuman Disiplin Pegawai baik Tingkat sedang maupun berat</li>
            </ol>
            <?php elseif($jabatan->eselon=='IVA'): ?>
            <ol style="font-size: x-small; margin-top: -5px; color: white">
                <li>tingkat pendidikan paling rendah Diploma III (D.III)</li>
                <li>memiliki pangkat paling rendah Penata Muda Tingkat I golongan ruang III/b dengan masa golongan 2 (dua) tahun untuk yang akan diangkat (promosi) dari jabatan eselon IV.b</li>
                <li>memiliki pangkat paling rendah Penata Muda Tingkat I golongan ruang III/b dengan masa golongan 3 (tiga) tahun untuk yang akan diangkat (promosi) dari jabatan pelaksana</li>
                <li>memiliki pangkat paling rendah Penata golongan ruang III/c dengan masa golongan 2 (dua) tahun untuk yang akan diangkat (promosi) dari Jabatan Fungsional</li>
                <li>untuk jabatan Lurah pangkat Penata golongan ruang III/c dengan masa kerja minimal 10 (sepuluh) tahun</li>
                <li>memiliki pengalaman pada jabatan eselon IV.b paling kurang selama 2 (dua) tahun untuk yang promosi dari struktural</li>
                <li>memiliki pengalaman pada jabatan pelaksana paling sedikit 4 (empat) tahun untuk yang promosi dari jabatan pelaksana atau dalam Jabatan Fungsional Ahli Muda paling sedikit selama 2 (dua) tahun</li>
                <li>tidak sedang menjalani Hukuman Disiplin Pegawai baik Tingkat sedang maupun berat</li>
            </ol>
            <?php elseif($jabatan->eselon=='IVB'): ?>
            <ol style="font-size: x-small; margin-top: -5px; color: white">
                <li>tingkat pendidikan paling rendah Diploma III (D.III)</li>
                <li>memiliki pangkat paling rendah Penata Muda golongan ruang III/a selama 3 (tiga) tahun</li>
                <li>memiliki pengalaman pada jabatan pelaksana paling sedikit 4 (empat) tahun atau dalam Jabatan Fungsional Ahli Muda paling sedikit 1 (satu) tahun</li>
                <li>tidak sedang menjalani Hukuman Disiplin Pegawai baik Tingkat Ringan, Sedang maupun Berat</li>
            </ol>
            <?php else: ?>
                <br/> Golongan terendah <span id='gol_min'><?php echo $jabatan->gol_minimal; ?></span>
            <?php endif; ?>
        </div>
            <!--"<br/> Golongan terendah <span id='gol_min'>".$jabatan->gol_minimal."</span>" ?>-->
    </div>
</div>
<div class="grid">
    <div class="row">
        <div class="span6">
            <div class="panel">
                <div class="panel-header">Pejabat Saat Ini</div>
                <div class="panel-content">
                    <div class="tab-control" data-role="tab-control">
                        <Gul class="tabs">
                            <li class="active"><a href="#_page_1">Profil</a></li>
                            <li><a href="#_page_2"><i class="icon-list"></i> Riwayat Jabatan</a></li>
                            <li><a href="#_page_3"><i class="icon-tree-view"></i> Struktur</a></li>
                        </Gul>

                        <div class="frames">
                            <div class="frame" id="_page_1">
                                <?php if(isset($pejabat_sekarang)): ?>
                                    <div class="text-center">
                                        <img src="<?php echo "http://103.14.229.15/simpeg/foto/".($pejabat_sekarang->idpegawai==''?(isset($pejabat_sekarang->idpegawai_plt)?$pejabat_sekarang->idpegawai_plt:''):$pejabat_sekarang->idpegawai).".jpg"; ?>" class="rounded" width="100">
                                    </div>
                                    <div class="listview-outlook">
                                        <div class="list">
                                            <div class="list-content"><strong><?php echo $pejabat_sekarang->nama_gelar; ?></strong></div>
                                        </div>
                                        <div class="list">
                                            <div class="list-content"><?php echo $pejabat_sekarang->nip_baru; ?></div>
                                        </div>
                                        <div class="list">
                                            <div class="list-content"><?php echo $pejabat_sekarang->pangkat_gol." (".$pejabat_sekarang->tmt.")"; ?></div>
                                        </div>
                                        <div class="list">
                                            <div class="list-content"><?php echo "Eselon ".$pejabat_sekarang->eselon." (".$pejabat_sekarang->tmt_jabatan.") (".$eselonering->pengalaman_eselon." Thn.)<br/>".$pejabat_sekarang->jabatan; ?></div>
                                        </div>
                                        <div class="list">
                                            <div class="list-content"><?php echo $pejabat_sekarang->tingkat_pendidikan." ".$pejabat_sekarang->jurusan_pendidikan." - ".$pejabat_sekarang->lembaga_pendidikan." (".$pejabat_sekarang->tahun_lulus.")"; ?></div>
                                        </div>
                                        <div class="list">
                                            <div class="list-content"><?php echo $pejabat_sekarang->alamat." ".$pejabat_sekarang->kota; ?></div>
                                        </div>
                                        <div class="list">
                                            <div class="list-content"><a href='<?php echo base_url() ?>pegawai/drh/<?php echo ($pejabat_sekarang->idpegawai==''?(isset($pejabat_sekarang->idpegawai_plt)?$pejabat_sekarang->idpegawai_plt:''):$pejabat_sekarang->idpegawai); ?>' target='_blank'>Lihat daftar riwayat hidup</a></div>
                                        </div>
                                    </div>
                                <?php else: ?>
                                    Jabatan ini kosong.
                                <?php endif;?>
                            </div>
                            <div class="frame" id="_page_2">
                                <?php if(isset($pejabat_sekarang)): ?>
                                    <ul>
                                        <?php if(isset($riwayat_jabatan)): ?>
                                            <?php foreach($riwayat_jabatan as $rj): ?>
                                                <li>
                                                    <div><strong><?php echo $rj->Jabatan; ?> (<?php echo substr($rj->tgl_masuk,0,4); ?>)</strong></div>
                                                    <div><?php echo $rj->unit_kerja; ?></div>
                                                </li>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <td colspan="3">Tidak ada data riwayat jabatan yang dapat ditampilkan.</td>
                                        <?php endif; ?>
                                    </ul>
                                <?php else: ?>
                                    Tidak ada data riwayat jabatan yang dapat ditampilkan.
                                <?php endif; ?>
                            </div>
                            <div class="frame" id="_page_3">
                                <fieldset>
                                    <legend>Jabatan Atasan</legend>
                                    <div class="panel">
                                        <div class="listview-outlook">
                                            <div class="list">
                                                <div class="list-content">
                                                    <?php if(isset($bos_jabatan)): ?>
                                                        <strong><?php echo $bos_jabatan->jabatan_bos; ?></strong></br>
                                                        <?php echo "Eselon ".$bos_jabatan->eselon_bos." (".$bos_jabatan->tmt_jabatan.")"; ?><br/>
                                                        <?php echo $bos_jabatan->pangkat_gol." (".$bos_jabatan->tmt_pangkat.")"; ?>
                                                    <?php else: ?>
                                                        Tidak ada data jabatan atasan yang dapat ditampilkan.
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>

                                <?php if(isset($jabatan_bawahan)): ?>
                                    <fieldset>
                                        <legend>Jabatan Bawahan</legend>
                                        <div class="panel">
                                            <div class="listview-outlook">
                                                <?php foreach($jabatan_bawahan as $bawah): ?>
                                                    <?php if(isset($bawah->jabatan_bawahan) and isset($bawah->eselon_bawahan)): ?>
                                                    <div class="list">
                                                        <div class="list-content">
                                                            <strong><?php echo $bawah->jabatan_bawahan; ?></strong><br/>
                                                            <?php echo "Eselon ".$bawah->eselon_bawahan." (".$bawah->tmt_jabatan.")"; ?><br/>
                                                            <?php echo $bawah->pangkat_gol." (".$bawah->tmt_pangkat.")"; ?>
                                                        </div>
                                                    </div>
                                                    <?php endif;?>
                                                <?php endforeach; ?>
                                            </div>
                                        </div>
                                    </fieldset>
                                <?php endif; ?>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="span6">
            <div class="panel">
                <div class="panel-header">Pengganti</div>
                <div class="panel-content">
                    <div class="tab-control" data-role="tab-control">
                        <ul class="tabs" style="font-size: 14px;">
                            <li class="active"><a href="#summary_pengganti">Profil</a></li>
                            <li><a href="#riwayat_jabatan_pengganti"><i class="icon-list"></i> Riwayat Jabatan</a></li>
                            <li><a href="#riwayat_kompetensi"><i class="icon-list"></i> Kompetensi</a></li>
                            <li><a href="#riwayat_hukuman_dis"><i class="icon-list"></i> Disiplin</a></li>
                        </ul>
                        <div class="frames">
                            <div class="frame" id="summary_pengganti">
                                <div class="text-center">
                                    <img id="foto_pengganti" src="http://103.14.229.15/simpeg/foto/no_photo.jpg" class="rounded" width="100">
                                </div>
                                <div class="listview-outlook">
                                    <div class="list">
                                        <div class="list-content"><strong><span id="lbl_nama_pengganti"></span></strong></div>
                                    </div>
                                    <div class="list">
                                        <div class="list-content"><span id="lbl_nip"></span></div>
                                    </div>
                                    <div class="list">
                                        <div class="list-content"><span id="lbl_golongan"></span></div>
                                    </div>
                                    <div class="list">
                                        <div class="list-content"><span id="lbl_jabatan"></span></div>
                                        <input type="hidden" id="lbl_id_j_pengganti" />
                                    </div>
                                    <div class="list">
                                        <div class="list-content"><span id="lbl_pendidikan"></span></div>
                                        <input type="hidden" id="lbl_id_pengganti" />
                                    </div>
                                    <div class="list">
                                        <div class="list-content"><strong><span id="lbl_alamat"></span></strong></div>
                                    </div>
                                    <div class="list">
                                        <div class="list-content"><span id="link_drh"></span></div>
                                    </div>
                                </div>
                            </div>
                            <div class="frame" id="riwayat_jabatan_pengganti">
                            </div>
                            <div class="frame" id="riwayat_kompetensi">
                            </div>
                            <div class="frame" id="riwayat_hukuman_dis">
                            </div>
                        </div>
                    </div>
                    <div id="btn_ganti" class="button">Ganti</div>
                    <?php echo anchor('jabatan_struktural/draft_pelantikan/'.$id_draft, '<span class=icon-home></span> Kembali', array('class' => 'button')); ?>
                    <input id="cekvalidasi" type="hidden" value=""/>
                    <div class="input-control text">
                        <input id="nama_pengganti"type="text" value="" placeholder="Cari Nama / NIP"/>
                        <button class="btn-search"></button>
                    </div>
                </div>
            </div>

            <div class="panel"  data-role="panel">
                <div id="pnl_catatan" class="panel-header">Catatan</div>
                <div class="panel-content"><ul><div id="notes">Tidak ada catatan.</div><ul></div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="span12">
            <div class="panel" data-role="panel">
                <div class="panel-header">SIMPEG Menyarankan:</div>

                <div class="row">
                    <div class="tab-control" data-role="tab-control">
                        <ul class="tabs">
                            <li class="active"><a href="#frame_1">Machine Learning Base</a></li>
                            <li><a href="#frame_2">Manual Sort Base</a></li>
                        </ul>
                        <div class="frames">
                            <div class="frame" id="frame_1">
                                <div class="row">
                                    <span class="span10" style="margin-top: -20px;"">Rekomendasi data di bawah ini bukan keputusan akhir. Teknik yang dipakai adalah
                                    <?php if($jabatan->eselon=='IIB' or $jabatan->eselon=='IVB' or $jabatan->eselon=='V') {
                                        echo '<strong > Bayes Net Rule </strong >';
                                    }else {
                                        echo '<strong > Cruise Rule </strong >';
                                    }
                                    ?></span>
                                </div>

                                <div class="row" style="border-bottom: 1px solid rgba(192, 192, 192, 0.8)">
                                        <span class="span11">
                                            <div class="input-control text">
                                                <input id="keywordSuggest"type="text" value="" placeholder="Kata kunci Nama/NIP/Unit/Jabatan" />
                                                <button class="btn-search"></button>
                                            </div>
                                        </span>
                                </div>

                                <?php if($jabatan->eselon=='IIB' or $jabatan->eselon=='IVB' or $jabatan->eselon=='V') {
                                    $tipe_rekomendasi = 'bayesnet';
                                }else {
                                    $tipe_rekomendasi = 'cruise';
                                }
                                ?>
                                <?php if(isset($rekomendasi_pejabat)): ?>
                                    <div class="panel-content" style="height:700px; overflow:auto;">
                                        <ol id="items_rekomendasi">
                                            <?php if(isset($rekomendasi_pejabat)): ?>
                                                <?php foreach($rekomendasi_pejabat as $rp): ?>
                                                    <li>
                                                        <table style="border-bottom: 1px solid rgba(192, 192, 192, 0.8);margin-bottom: 5px;">
                                                            <tr>
                                                                <td width="7%" rowspan="2" style="vertical-align: top;"><img src='http://103.14.229.15/simpeg/foto/<?php echo $rp->idpegawai?>.jpg' width='50px' />
                                                                    <div id="btn_up_emp" class="button" onclick="up_informasi_pegawai('<?php echo $rp->nip; ?>', <?php echo $id_draft ?>)"
                                                                         style="width: 50px;"><span class=icon-arrow-up style="color: red;"></span></div>
                                                                    <div id="btn_detail" class="button" onclick="loadDetailPegawai(<?php echo $rp->no_reg; ?>, '<?php echo $jabatan->jabatan; ?>',
                                                                            '<?php echo $jabatan->eselon; ?>', '<?php echo $jabatan->nama_baru_skpd; ?>', 'top_type');"
                                                                         style="width: 50px;border-top: 1px solid rgba(71,71,72,0.78)"><strong>...</strong></div>
                                                                </td>
                                                                <td width="20%" style="vertical-align: top;"><span style="color: #0000cc"><?php echo $rp->nip; ?></span></td>
                                                                <td width="20%" style="vertical-align: top;"><strong><?php echo $rp->nama; ?></strong></td>
                                                                <td width="53%" style="vertical-align: top;"><?php echo $rp->pangkat; ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="3">
                                                                    Jabatan: <?php echo $rp->jabatan; ?><br>
                                                                    Eselon: <?php echo $rp->eselonering ?> (Lamanya <?php echo $rp->pengalaman_eselon_current ?> Thn) | Umur: <?php echo $rp->umur ?> Thn |
                                                                    Masa Kerja Keseluruhan: <?php echo $rp->masa_kerja ?> Thn <br>
                                                                    Pengalaman pada unit kerja tujuan : <?php echo $rp->pengalaman_uk ?> Thn |
                                                                    PIM II : <?php echo $rp->jml_diklat_pim_2 ?> | PIM III : <?php echo $rp->jml_diklat_pim_3 ?> | PIM IV : <?php echo $rp->jml_diklat_pim_4 ?>
                                                                    <?php if($jabatan->eselon=='IIB' or $jabatan->eselon=='IVB' or $jabatan->eselon=='V'): ?>
                                                                        <?php echo ' | Total Skor : ';?><span style="color:#cd0a0a"><?php echo $rp->bayes_val_total; ?></span>
                                                                    <?php endif; ?>
                                                                    <br>Sertifikasi Barang dan Jasa : <?php echo ($rp->tgl_diklat_barjas==''?'-':$rp->tgl_diklat_barjas) ?><br>
                                                                    <span style="font-weight: bold;">SKP 2 Tahun Terakhir</span> : <?php echo ($rp->skp==''?'-':'<br>'.$rp->skp) ?>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </li>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <td colspan="3">Tidak ada data rekomendasi yang dapat ditampilkan.</td>
                                            <?php endif; ?>
                                        </ol>
                                    </div>
                                    <div id="btn_drop_data_rekomendasi" class="button" style="width: 100%; border-bottom: 1px solid;"
                                         onclick="loadDataRekomendasiLainnya(<?php echo $idskpd_tujuan; ?>,
                                             '<?php echo $jabatan->eselon; ?>', '<?php echo $tipe_rekomendasi; ?>',
                                             '<?php echo $jabatan->jabatan; ?>', '<?php echo $jabatan->nama_baru_skpd; ?>', <?php echo $id_draft ?>, '')">
                                        Lihat Data Lainnya</div>
                                    <div id="btn_get_data_excel" class="button" style="width: 100%"
                                         onclick="downloadDataRekomendasiLainnya(<?php echo $idskpd_tujuan; ?>,
                                             '<?php echo $jabatan->eselon; ?>', '<?php echo $tipe_rekomendasi; ?>',
                                             '<?php echo $jabatan->jabatan; ?>', '<?php echo $jabatan->nama_baru_skpd; ?>')">Download Data (Format Ms.Excel)</div>
                                <?php endif; ?>
                            </div>




                            <script>
                                function checkSelectVal(a){
                                    return $( "#ddFilterParam"+(a-1).toString()).val();
                                }
                            </script>
                            <div class="frame" id="frame_2">
                                <div class="row">
                                    <span class="spannew" style="margin-top: -20px;">Urutkan : </span>
                                    <?php
                                    for($i=1;$i<=7;$i++){
                                        if($i==1){
                                            echo "<span class=\"span1\" style=\"margin-top: -20px;\">";
                                        }else{
                                            echo "<span class=\"span1\" style=\"margin-left: 50px; margin-top: -20px;\">";
                                        }
                                        ?>
                                            <div class="input-control select" style="width: 100px;">
                                                <select id="ddFilterParam<?php echo $i;?>" onchange="">
                                                    <option value="0">Level <?php echo $i;?></option>
                                                    <?php if($i==1): ?>
                                                    <option value="pangkat_gol" selected>Pangkat</option>
                                                    <?php else: ?>
                                                    <option value="pangkat_gol">Pangkat</option>
                                                    <?php endif;?>
                                                    <option value="masa_kerja">Masa Kerja Keseluruhan</option>
                                                    <option value="umur">Umur</option>
                                                    <option value="tk_pendidikan">Tingkat Pendidikan</option>
                                                    <option value="jml_diklat_pim_2">Diklat PIM II</option>
                                                    <option value="jml_diklat_pim_3">Diklat PIM III</option>
                                                    <option value="jml_diklat_pim_4">Diklat PIM IV</option>
                                                    <option value="pengalaman_uk">Pengalaman pada Unit Kerja yang dituju</option>
                                                    <option value="pengalaman_eselon_current">Pengalaman di Eselon</option>
                                                </select>
                                            </div>
                                        </span>
                                        <?php
                                            if($i>1){
                                        ?>
                                        <script>
                                            $('#ddFilterParam<?php echo $i;?>').on('change', function() {
                                                if(this.value == 0){ // or $(this).val()
                                                    for (i = <?php echo $i+1;?>; i <= 7; i++) {
                                                        $('select#ddFilterParam'+i+" option").each(function() { this.selected = (this.text == 0); });
                                                    }
                                                }else{
                                                    if(checkSelectVal(<?php echo $i;?>)=='0'){
                                                        //alert('Pilih dahulu Level <?php //echo $i-1;?>');
                                                        $(this).val('0');
                                                    }
                                                }
                                            });
                                        </script>
                                        <?php
                                         }else{
                                         ?>
                                            <script>
                                            $('#ddFilterParam<?php echo $i;?>').on('change', function() {
                                                if(this.value == 0){ // or $(this).val()
                                                    for (i = <?php echo $i;?>; i <= 7; i++) {
                                                        $('select#ddFilterParam'+i+" option").each(function() { this.selected = (this.text == 0); });
                                                    }
                                                }
                                            });
                                        </script>
                                         <?php
                                         }
                                    }
                                    ?>
                                </div>
                                <div class="row">
                                    <span class="span1" style="margin-top: -15px;">Filter</span>
                                            <span class="span3" style="margin-top: -20px;">
                                                <label class="input-control radio small-check">
                                                    <input type="radio" name="rdbCekPromo" checked value="Rotasi">
                                                    <span class="check"></span>
                                                    <span class="caption">Rotasi</span>
                                                </label>
                                                <label class="input-control radio small-check">
                                                    <input type="radio" name="rdbCekPromo" value="Promosi">
                                                    <span class="check"></span>
                                                    <span class="caption">Promosi</span>
                                                </label>
                                            </span>
                                    <span class="span3" style="margin-top: -20px;margin-left: -10px;">
                                        <?php if(isset($bidang_pendidikan)): ?>
                                            <div class="input-control select" style="width: 100%;">
                                                <select id="ddFilterBidPend">
                                                    <option value="0">Semua Bidang Pendidikan</option>
                                                    <?php foreach($bidang_pendidikan as $bp): ?>
                                                        <option value="<?php echo $bp->id; ?>"><?php echo $bp->bidang; ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        <?php endif; ?>
                                    </span>
                                    <span class="span3" style="margin-top: -20px;">
                                        <div class="input-control text">
                                            <input id="keywordCari"type="text" value="" placeholder="Kata kunci Nama / NIP" /></div>
                                    </span>
                                </div>
                                <div class="row" style="border-bottom: 1px solid rgba(192, 192, 192, 0.8)">
                                    <?php if($jabatan->eselon!='IIIA' and $jabatan->eselon!='IIIB'): ?>
                                    <span class="span2" style="margin-top: -15px;">Status Sertifikat Barjas</span>
                                    <span class="spannew" style="margin-top: -20px;margin-left: -10px;">
                                        <div class="input-control select" style="width: 100%;">
                                            <select id="ddFilterBarjas">
                                                <option value="0">Semua</option>
                                                <option value="1">Ada</option>
                                                <option value="2">Tidak Ada</option>
                                            </select>
                                        </div>
                                    </span>
                                    <?php endif; ?>
                                    <span class="spannew2" style="margin-top: -15px;">Masa Kerja</span>
                                    <span class="span1" style="margin-top: -15px;"> >= </span>
                                    <span class="spannew" style="margin-top: -20px; margin-left: 0px;">
                                        <div class="input-control text">
                                            <input id="txtMKJabatan"type="text" value="0" placeholder="" />
                                        </div>
                                    </span>
                                    <span class="span3" style="margin-top: -20px;">
                                        <button id="btn_tampilkan" class="button primary" style="height: 35px;">
                                            <strong>Tampilkan</strong></button>
                                    </span>
                                    <?php if($jabatan->eselon=='IIIA' or $jabatan->eselon=='IIIB'): ?>
                                    <span class="span3" style="margin-top: -20px;">
                                        <div class="input-control text">
                                            <input id="ddFilterBarjas"type="hidden" value="1" placeholder="" />
                                        </div>
                                    </span>
                                    <?php endif; ?>
                                </div>
                                <div class="panel-content" style="height:700px; overflow:auto;">
                                    <div id="divSortManual"></div>
                                </div>
                                <div id="btn_get_data_excel2" class="button" style="width: 100%" onclick="downloadDataSortManual()">Download Data (Format Ms.Excel)</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        loadDefaultSortManual();
        $("#btn_ganti").click(function(){
            //alert($("#cekvalidasi").val());
            if($("#cekvalidasi").val() == 'true') {
                $.post('<?php echo base_url()."index.php/jabatan_struktural/ganti_isi_draft"; ?>', {
                    id_draft: <?php echo $id_draft ?>,
                    <?php
                        if(isset($pejabat_sekarang))
                            echo "id_pegawai_sebelumnya :  ".(isset($pejabat_sekarang->idpegawai)?$pejabat_sekarang->idpegawai:"''").",";
                    ?>
                    id_pegawai_baru: $("#lbl_id_pengganti").val(),
                    id_j_dituju: <?php echo $jabatan->id_j ?>,
                    id_j_ditinggal: $("#lbl_id_j_pengganti").val()
                }, function (data) {
                    //alert('Sukses');
                    location.reload();
                });
            }else{
                alert_validasi();
            }
        });

        function alert_validasi(){
            $.Dialog({
                shadow: true,
                overlay: false,
                icon: '<span class="icon-rocket"></span>',
                title: 'Informasi',
                width: 250,
                height: 100,
                padding: 10,
                content: "<div style='width:400px;'><img src='<?php echo base_url().'images/Warning.png'; ?>' width='64'> Maaf pegawai ini tidak dapat diusulkan</div>"
            });
        }

        function loadDetailPegawai(no_reg, nm_jabatan, jbtn_eselon, skpd_tujuan, type){
            $.post('<?php echo base_url()."index.php/jabatan_struktural/detail_pegawai"; ?>',
                { no_reg : no_reg,
                    nm_jabatan: nm_jabatan,
                    jbtn_eselon: jbtn_eselon,
                    skpd_tujuan: skpd_tujuan, type: type }, function(data){
                    $("#detail_pegawai").html(data);
                });

            $.Dialog({
                shadow: true,
                overlay: false,
                icon: '<span class="icon-rocket"></span>',
                title: 'Detail Pegawai',
                width: 750,
                height: 550,
                padding: 10,
                content: "<div id='detail_pegawai' style='height:450px; overflow:auto;'></div>"
            });
        }

        var last_start_limit = 15;
        function loadDataRekomendasiLainnya(idskpd, jbtn_eselon, tipe_rekomendasi, jabatan, nama_baru_skpd, id_draft, keywordSuggest){
            $("#btn_drop_data_rekomendasi").css("pointer-events", "none");
            $("#btn_drop_data_rekomendasi").css("opacity", "0.4");
            var limit_banyaknya = 15;
            if($("#btn_drop_data_rekomendasi").text() == "Reset"){
                last_start_limit = 0;
                $("#items_rekomendasi").empty();
                $( "#btn_drop_data_rekomendasi" ).text("Lihat Data Lainnya");
            }
            $.post('<?php echo base_url()."index.php/jabatan_struktural/drop_data_other_rekomendasi"; ?>',
                {
                    limit_mulai: last_start_limit,
                    limit_banyaknya: limit_banyaknya,
                    idskpd: idskpd,
                    jbtn_eselon: jbtn_eselon,
                    tipe_rekomendasi: tipe_rekomendasi,
                    jabatan: jabatan, nama_baru_skpd: nama_baru_skpd,
                    keywordSuggest: keywordSuggest, id_draft: id_draft}, function(data){
                    if(keywordSuggest == "") {
                        $("#items_rekomendasi").append(data);
                        last_start_limit = last_start_limit + limit_banyaknya;
                    }else{
                        $("#items_rekomendasi").empty();
                        $("#items_rekomendasi").append(data);
                        $( "#btn_drop_data_rekomendasi" ).text("Reset");
                    }
                    $("#btn_drop_data_rekomendasi").css("pointer-events", "auto");
                    $("#btn_drop_data_rekomendasi").css("opacity", "1");
                });
        }

        function downloadDataRekomendasiLainnya(idskpd, jbtn_eselon, tipe_rekomendasi, jabatan, nama_baru_skpd){
            $.post('<?php echo base_url()."index.php/jabatan_struktural/download_data_excel_rekomendasi"; ?>',
                {
                    idskpd: idskpd,
                    jbtn_eselon: jbtn_eselon,
                    tipe_rekomendasi: tipe_rekomendasi,
                    jabatan: jabatan, nama_baru_skpd: nama_baru_skpd}, function(data){
                    $("#download_data_excel").html(data);
                });
            $.Dialog({
                shadow: true,
                overlay: false,
                icon: '<span class="icon-rocket"></span>',
                title: 'Download Data Format Excel',
                width: 450,
                padding: 10,
                content: "<div id='download_data_excel' style='height:250px; overflow:auto;'></div>"
            });
        }

        function up_informasi_pegawai(nama, id_draft){
            $('html, body').animate({scrollTop:0}, 'slow');
            $.ajax({
                url: "<?php echo base_url()."index.php/jabatan_struktural/json_find_in_draft" ?>",
                dataType: "json",
                data: {
                    q: nama,
                    id_draft: id_draft
                },
                success: function( data ) {
                    $("#btn_ganti").css("pointer-events", "none");
                    $("#btn_ganti").css("opacity", "0.4");
                    $( "#nama_pengganti" ).val( data[0].label);
                    $( "#lbl_nama_pengganti" ).html( "" + data[0].label );
                    document.getElementById("lbl_nama_pengganti").style.fontWeight = "bold";
                    $( "#lbl_golongan" ).html( data[0].gol + " ("+ data[0].tmt +")" );
                    $( "#lbl_nip" ).html( data[0].nip );
                    $( "#lbl_jabatan" ).html( "Eselon " + data[0].eselon + " (" + data[0].tmt_jabatan + ") (" + data[0].pengalaman_eselon + " Thn.) <br/>" + data[0].jabatan);
                    //+ "<br/> Pengalaman Eselon " + data[0].eselonbawahnya + " (" +data[0].pengalaman_eselon_down+ " Thn.)"
                    $( "#lbl_pendidikan" ).html( data[0].pendidikan );
                    $( "#foto_pengganti" ).attr( 'src', 'http://103.14.229.15/simpeg/foto/' + data[0].value + '.jpg');
                    $( "#lbl_id_pengganti" ).val( data[0].value );
                    $( "#lbl_id_j_pengganti" ).val( data[0].id_j );
                    $( "#lbl_alamat" ).html( "" + data[0].alamat );
                    $("#link_drh").html("<a href='<?php echo base_url() ?>pegawai/drh/"+data[0].value+"' target='_blank'>Lihat daftar riwayat hidup</a>");
                    get_riwayat_jabatan_pengganti( data[0].value );
                    get_riwayat_hukuman_pengganti( data[0].value );
                    get_riwayat_kompetensi(data[0].value);
                    $( "#nama_pengganti" ).val("");
                    $("#notes").html("analysing . . .");

                    $.ajax({
                        url: "<?php echo base_url() . "index.php/jabatan_struktural/json_cek_kesesuaian_jabatan/" ?>",
                        dataType: "json",
                        type: 'post',
                        data: {
                            id_jabatan: <?php echo $jabatan->id_j ?>,
                            id_pegawai: data[0].value,
                            id_draft: <?php echo $id_draft ?>
                        },
                        success: function (data) {
                            $("#notes").html("");
                            var items = [];
                            var sel_color = '';
                            var cek_validasi = false;
                            $.each(data, function(i, item) {
                                if( item[i,1] == 1){
                                    sel_color = 'bg-red';
                                    cek_validasi = false;
                                }else if(item[i,1] == 2){
                                    if(sel_color != 'bg-red') {
                                        sel_color = 'bg-yellow';
                                        cek_validasi = true;
                                    }
                                }else{
                                    if(sel_color != 'bg-red') {
                                        sel_color = 'bg-yellow';
                                        cek_validasi = true;
                                    }
                                }
                                items.push('<li style=\"color: '+item[i,2]+'\">' + item[i,0] + '</li>');
                            });  // close each()
                            $("#notes").html( items );

                            //$('#notes').append( items.join('') );
                            $("#pnl_catatan").removeClass('bg-red');
                            $("#pnl_catatan").removeClass('bg-yellow');
                            $("#pnl_catatan").removeClass('bg-green');

                            if($("#notes").html() != '' ) {
                                $("#pnl_catatan").addClass(sel_color);
                            }else{
                                $("#pnl_catatan").addClass('bg-green');
                                $("#notes").html("Tidak ada catatan.");
                                cek_validasi = true;
                            }
                            $( "#cekvalidasi" ).val( cek_validasi);
                            $("#btn_ganti").css("pointer-events", "auto");
                            $("#btn_ganti").css("opacity", "1");
                        },
                        error: function(a,b,c){
                            console.log(b);
                            console.log(a.responseText);
                        }
                    });


                },
                error: function(a,b,c){
                    console.log(b);
                    console.log(a.responseText);
                }
            });
        }

        function int_value(string){
            s = 0;

            for( var i = 0; i < string.length; i++ )
            {
                s += string.charCodeAt(i);
            }

            return s;
        }

        function get_riwayat_jabatan_pengganti(id_pegawai){
            $.post('<?php echo base_url()."index.php/jabatan_struktural/riwayat_jabatan_html_list/"; ?>',
                { id_pegawai : id_pegawai }, function(data){
                    $("#riwayat_jabatan_pengganti").html(data);
                });
        }

        function get_riwayat_hukuman_pengganti(id_pegawai){
            $.post('<?php echo base_url()."index.php/jabatan_struktural/riwayat_hukuman_list/"; ?>',
                { id_pegawai : id_pegawai }, function(data){
                    $("#riwayat_hukuman_dis").html(data);
                });
        }

        function get_riwayat_kompetensi(id_pegawai){
            $.post('<?php echo base_url()."index.php/jabatan_struktural/riwayat_kompetensi_list/"; ?>',
                { id_pegawai : id_pegawai }, function(data){
                    $("#riwayat_kompetensi").html(data);
                });
        }

        $( "#nama_pengganti" ).autocomplete({
                minLength: 3,
                source: function( request, response ) {
                    $.ajax({
                        url: "<?php echo base_url()."index.php/jabatan_struktural/json_find_in_draft" ?>",
                        dataType: "json",
                        data: {
                            q: request.term,
                            id_draft: <?php echo $id_draft; ?>,
                            type: 'autocomplete'
                        },
                        success: function( data ) {
                            response( data );
                        },
                        error: function(a,b,c){
                            console.log(b);
                            console.log(a.responseText);
                        }
                    });
                },
                focus: function( event, ui ) {
                    //$( "#nama_pengganti" ).val( ui.item.label );
                    return false;
                },
                select: function( event, ui ) {
                    $("#btn_ganti").css("pointer-events", "none");
                    $("#btn_ganti").css("opacity", "0.4");
                    $("#btn_ganti").addClass("disabledbutton");
                    $( "#nama_pengganti" ).val( ui.item.label);
                    $( "#lbl_nama_pengganti" ).html( "" + ui.item.label );
                    document.getElementById("lbl_nama_pengganti").style.fontWeight = "bold";
                    $( "#lbl_golongan" ).html( ui.item.gol + " ("+ ui.item.tmt +")" );
                    $( "#lbl_nip" ).html( ui.item.nip );
                    $( "#lbl_jabatan" ).html( "Eselon " + ui.item.eselon + " (" + ui.item.tmt_jabatan + ") (" + ui.item.pengalaman_eselon + " Thn.) <br/>" + ui.item.jabatan);
                    //+ "<br/> Pengalaman Eselon " + ui.item.eselonbawahnya + " (" + ui.item.pengalaman_eselon_down+ " Thn.)"
                    $( "#lbl_pendidikan" ).html( ui.item.pendidikan );
                    $( "#foto_pengganti" ).attr( 'src', 'http://103.14.229.15/simpeg/foto/' + ui.item.value + '.jpg');

                    $( "#lbl_id_pengganti" ).val( ui.item.value );
                    $( "#lbl_id_j_pengganti" ).val( ui.item.id_j );
                    $( "#lbl_alamat" ).html( "" + ui.item.alamat );
                    $("#link_drh").html("<a href='<?php echo base_url() ?>pegawai/drh/"+ui.item.value+"' target='_blank'>Lihat daftar riwayat hidup</a>");
                    get_riwayat_jabatan_pengganti( ui.item.value );
                    get_riwayat_hukuman_pengganti( ui.item.value );
                    get_riwayat_kompetensi(ui.item.value);
                    $( "#nama_pengganti" ).val("");

                    $("#notes").html("analysing . . .");

                    // Cek Persyaratan Jabatan
                    $.ajax({
                        url: "<?php echo base_url() . "index.php/jabatan_struktural/json_cek_kesesuaian_jabatan" ?>",
                        dataType: "json",
                        type: 'post',
                        data: {
                            id_jabatan: <?php echo $jabatan->id_j ?>,
                            id_pegawai: ui.item.value,
                            id_draft: <?php echo $id_draft ?>
                        },
                        success: function (data) {
                            $("#notes").html("");
                            var items = [];
                            var sel_color = '';
                            var cek_validasi = false;
                            $.each(data, function(i, item) {
                                if( item[i,1] == 1){
                                    sel_color = 'bg-red';
                                    cek_validasi = false;
                                }else if(item[i,1] == 2){
                                    if(sel_color != 'bg-red') {
                                        sel_color = 'bg-yellow';
                                        cek_validasi = true;
                                    }
                                }else{
                                    if(sel_color != 'bg-red') {
                                        sel_color = 'bg-yellow';
                                        cek_validasi = true;
                                    }
                                }
                                items.push('<li style=\"color: '+item[i,2]+'\">' + item[i,0] + '</li>');
                            });  // close each()
                            $("#notes").html( items );
                            //$('#notes').append( items.join('') );
                            $("#pnl_catatan").removeClass('bg-red');
                            $("#pnl_catatan").removeClass('bg-yellow');
                            $("#pnl_catatan").removeClass('bg-green');

                            if($("#notes").html() != '' ) {
                                $("#pnl_catatan").addClass(sel_color);
                            }else{
                                $("#pnl_catatan").addClass('bg-green');
                                $("#notes").html("Tidak ada catatan.");
                                cek_validasi = true;
                            }
                            $("#cekvalidasi" ).val( cek_validasi);
                            $("#btn_ganti").css("pointer-events", "auto");
                            $("#btn_ganti").css("opacity", "1");
                        },
                        error: function(a,b,c){
                            console.log(b);
                            console.log(a.responseText);
                        }
                    });

                    return false;
                }
            })
            .autocomplete( "instance" )._renderItem = function( ul, item ) {
            return $( "<li>" )
                .append( "<img src='http://103.14.229.15/simpeg/foto/"+ item.value +".jpg' width='50' /><a><strong>" + item.label + "</strong> ("+ item.gol +")<br>" + item.uker + "</a>" )
                .appendTo( ul );
        };
        $('#keywordSuggest').bind("enterKey",function(e){
            if($('#keywordSuggest').val() != "") {
                loadDataRekomendasiLainnya(<?php echo $idskpd_tujuan; ?>,
                    '<?php echo $jabatan->eselon; ?>', '<?php echo $tipe_rekomendasi; ?>',
                    '<?php echo $jabatan->jabatan; ?>', '<?php echo $jabatan->nama_baru_skpd; ?>', <?php echo $id_draft ?>, $('#keywordSuggest').val());
            }
        });
        $('#keywordSuggest').keyup(function(e){
            if(e.keyCode == 13)
            {
                $(this).trigger("enterKey");
            }
        });

        $("#btn_tampilkan").click(function(){
            if($('#ddFilterParam1').val()==0){
                alert('Tentukan dahulu kolom minimal pada Level 1');
            }else{
                var a = $('#ddFilterParam1').val();
                var b = $('#ddFilterParam2').val();
                var c = $('#ddFilterParam3').val();
                var d = $('#ddFilterParam4').val();
                var e = $('#ddFilterParam5').val();
                var f = $('#ddFilterParam6').val();
                var g = $('#ddFilterParam7').val();
                var filter = $("input[name='rdbCekPromo']:checked").val();
                var pend = $('#ddFilterBidPend').val();
                var keywordCari = $("#keywordCari").val();
                var barjas = $("#ddFilterBarjas").val();
                var mkjabatan = $("#txtMKJabatan").val();
                if(mkjabatan==''){
                    mkjabatan = 0;
                }
                loadDataSortManual(<?php echo $idskpd_tujuan; ?>,
                    '<?php echo $jabatan->eselon; ?>', '<?php echo $tipe_rekomendasi; ?>',
                    '<?php echo $jabatan->jabatan; ?>', '<?php echo $jabatan->nama_baru_skpd; ?>', <?php echo $id_draft ?>,
                a,b,c,d,e,f,g,filter,pend,keywordCari,barjas,mkjabatan,'','');
            }
        });

        function loadDataSortManual(idskpd, jbtn_eselon, tipe_rekomendasi, jabatan, nama_baru_skpd, id_draft, a,b,c,d,e,f,g,filter,pend,keywordCari,barjas,mkjabatan,page,ipp){
            $("#btn_drop_data_rekomendasi").css("pointer-events", "none");
            $("#btn_drop_data_rekomendasi").css("opacity", "0.4");
            $("#btn_tampilkan").css("pointer-events", "none");
            $("#btn_tampilkan").css("opacity", "0.4");
            $("#divSortManual").css("pointer-events", "none");
            $("#divSortManual").css("opacity", "0.4");

            $.post('<?php echo base_url()."index.php/jabatan_struktural/drop_data_sort_manual_rekomendasi"; ?>',
                {
                    idskpd: idskpd,
                    jbtn_eselon: jbtn_eselon,
                    tipe_rekomendasi: tipe_rekomendasi,
                    jabatan: jabatan,
                    nama_baru_skpd: nama_baru_skpd,
                    id_draft: id_draft, a: a ,b: b, c: c, d: d, e: e, f: f, g: g,
                    filter: filter, pend: pend,
                    page: page,
                    ipp: ipp,
                    txtKeyword: keywordCari,
                    barjas: barjas,
                    mkjabatan: mkjabatan
                }, function(data){
                    $("#divSortManual").html(data);
                    $("#btn_drop_data_rekomendasi").css("pointer-events", "auto");
                    $("#btn_drop_data_rekomendasi").css("opacity", "1");
                    $("#btn_tampilkan").css("pointer-events", "auto");
                    $("#btn_tampilkan").css("opacity", "1");
                    $("#divSortManual").css("pointer-events", "auto");
                    $("#divSortManual").css("opacity", "1");
                });

        }

        function pagingViewListLoad(parm,parm2){
            var a = $('#ddFilterParam1').val();
            var b = $('#ddFilterParam2').val();
            var c = $('#ddFilterParam3').val();
            var d = $('#ddFilterParam4').val();
            var e = $('#ddFilterParam5').val();
            var f = $('#ddFilterParam6').val();
            var g = $('#ddFilterParam7').val();
            var filter = $("input[name='rdbCekPromo']:checked").val();
            var pend = $('#ddFilterBidPend').val();
            var keywordCari = $("#keywordCari").val();
            var barjas = $("#ddFilterBarjas").val();
            var mkjabatan = $("#txtMKJabatan").val();
            loadDataSortManual(<?php echo $idskpd_tujuan; ?>,
                '<?php echo $jabatan->eselon; ?>', '<?php echo $tipe_rekomendasi; ?>',
                '<?php echo $jabatan->jabatan; ?>', '<?php echo $jabatan->nama_baru_skpd; ?>', <?php echo $id_draft ?>,
                a,b,c,d,e,f,g,filter,pend,keywordCari,barjas,mkjabatan,parm,parm2);
        }

        function loadDefaultSortManual(){
            for (i = 2; i <= 7; i++) {
                $('select#ddFilterParam'+i+" option").each(function() { this.selected = (this.text == 0); });
            }
            $('select#ddFilterParam'+i+" option").each(function() { this.selected = (this.text == 0); });
            $("select#ddFilterBidPend option").each(function() { this.selected = (this.text == 0); });
            var $radios = $('input:radio[name=rdbCekPromo]');
            $radios.filter('[value=Rotasi]').prop('checked', true);
            $('#keywordCari').val("");
            loadDataSortManual(<?php echo $idskpd_tujuan; ?>,
                '<?php echo $jabatan->eselon; ?>', '<?php echo $tipe_rekomendasi; ?>',
                '<?php echo $jabatan->jabatan; ?>', '<?php echo $jabatan->nama_baru_skpd; ?>', <?php echo $id_draft ?>,
                'pangkat_gol','0','0','0','0','0','0','Rotasi','0','',<?php echo (($jabatan->eselon!='IIIA' and $jabatan->eselon!='IIIB')?'0':'1'); ?>,'0','','');
        }

        function downloadDataSortManual(){
            var a = $('#ddFilterParam1').val();
            var b = $('#ddFilterParam2').val();
            var c = $('#ddFilterParam3').val();
            var d = $('#ddFilterParam4').val();
            var e = $('#ddFilterParam5').val();
            var f = $('#ddFilterParam6').val();
            var g = $('#ddFilterParam7').val();
            var filter = $("input[name='rdbCekPromo']:checked").val();
            var pend = $('#ddFilterBidPend').val();
            var keywordCari = $("#keywordCari").val();
            if(keywordCari==''){
                keywordCari = '-';
            }
            window.open('<?php echo base_url()."index.php/phpexcel/excel_manual_sort/index/".$idskpd_tujuan.'/'.$jabatan->eselon.'/'; ?>'+
                a+'/'+b+'/'+c+'/'+d+'/'+e+'/'+f+'/'+g+'/'+filter+'/'+pend+'/'+keywordCari,'_blank');
        }

    </script>
