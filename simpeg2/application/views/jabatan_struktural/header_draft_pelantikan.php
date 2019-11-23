<style>
    .metro .span1,
    .metro .size1 {
        width: 30px !important;
    }
    .metro .span2,
    .metro .size2 {
        width: 200px !important;
    }
</style>
<div class="grid">
	<div class="row">
		<div class="span4">
			<nav class="sidebar (light)">
				<ul>
					<li class="title"><div>Draft Pelantikan</div>
						<small><i><?php echo $draft_pelantikan->nama; ?></i></small>
					</li>
					<li><?php echo anchor("jabatan_struktural/draft_pelantikan/".$draft_pelantikan->id_draft,"<i class='icon-home'></i> Dashboard</a>");?></li>
					<li><?php echo anchor("jabatan_struktural/nominatif_draft_pelantikan/".$draft_pelantikan->id_draft,"<i class='icon-copy'></i> Nominatif</a>", array( 'target' => '_blank'));?></li>
					<!--<li>--><?php //echo anchor("jabatan_struktural/cetak_sk/".$draft_pelantikan->id_draft,"<i class='icon-layers'></i> Surat Keputusan</a>", array( 'target' => '_blank'));?><!--</li>-->

                    	<li class="stick bg-yellow">
						<a class="dropdown-toggle" href="#"><i class="icon-tree-view"></i>Prediksi Jabatan > 5 Tahun (<?php echo sizeof($jab_lima);?>)</a>
						<ul class="dropdown-menu" data-role="dropdown">
							<?php if($jab_lima): ?>
                                <?php $f=1;?>
								<?php foreach($jab_lima as $k2): ?>
									<li>
                                        <?php //echo anchor('jabatan_struktural/isi_draft_jabatan/'.$k2->id_draft.'/'.$k2->id_j,  "<small>".$k2->jabatan." : $k2->masa tahun</small>", array("class" => "list")); ?>
                                        <?php echo anchor('jabatan_struktural/isi_draft_jabatan/'.$k2->id_draft.'/'.$k2->id_j_new,  "<small><strong>".$f++.')</strong> '.$k2->jabatan." : $k2->pengalaman_eselon_new tahun</small>", array("class" => "list")); ?>
                                    </li>
								<?php endforeach; ?>
							<?php endif; ?>
						</ul>
					</li>



					<li class="stick bg-yellow">
						<a class="dropdown-toggle" href="#">
                            <div class="row" style="margin-top: 0px">
                                <div class="span1"><i class="icon-tree-view"></i></div>
                                <div class="span2" style="padding: 0px;margin: 0px;">Jabatan Kosong <br>(Eksisting: <?php echo sizeof($jab_kosong);?> Baru: <?php echo sizeof($jab_kosong_baru);?> <br>PLT: <?php echo sizeof($jab_kosong_plt);?>)</div>
                            </div>
                        </a>

						<ul class="dropdown-menu" data-role="dropdown">
							<?php if($jab_kosong): ?>
                                <?php $f=1;?>
								<?php foreach($jab_kosong as $k): ?>
									<li><?php echo anchor('jabatan_struktural/isi_draft_jabatan/'.$k->id_draft.'/'.$k->id_j,  "<small><strong>".$f++.')</strong> '.$k->jabatan." (".$k->eselon.")"."</small>", array("class" => "list")); ?></li>
								<?php endforeach; ?>
							<?php endif; ?>
                            <li><hr style="border: 1px solid black;"></li>
                            <li><a href="javascript:void(0);"><strong>Jabatan Kosong Baru</strong></a href="javascript:void(0)"></li>
                            <?php if($jab_kosong_baru): ?>
                            <?php $f=1;?>
                                <?php foreach($jab_kosong_baru as $k): ?>
                                    <li><?php echo anchor('jabatan_struktural/isi_draft_jabatan/'.$k->id_draft.'/'.$k->id_j,  "<small><strong>".$f++.')</strong> '.$k->jabatan." (".$k->eselon.")"."</small>", array("class" => "list")); ?></li>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <!--<a href="#" class="list"><div class="list-content">...</div></a>-->
                            <?php endif; ?>
                            <li><hr style="border: 1px solid black;"></li>
                            <li><a href="javascript:void(0);"><strong>Jabatan Kosong Ada PLT</strong></a href="javascript:void(0)">
                            <?php if($jab_kosong_plt): ?>
                                <?php $f=1;?>
                                <?php foreach($jab_kosong_plt as $k): ?>
                                    <li><?php echo anchor('jabatan_struktural/isi_draft_jabatan/'.$k->id_draft.'/'.$k->id_j,  "<small><strong>".$f++.')</strong> '.$k->jabatan." (".$k->eselon.")"."</small>", array("class" => "list")); ?></li>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <!--<a href="#" class="list"><div class="list-content">...</div></a>-->
                            <?php endif; ?>
						</ul>
					</li>
                    <!--<li class="stick bg-yellow">
                        <a class="dropdown-toggle" href="#"><i class="icon-tree-view"></i>Jabatan Kosong Baru (<?php //echo sizeof($jab_kosong_baru);?>)</a>
                        <ul class="dropdown-menu" data-role="dropdown">
                            <?php //if($jab_kosong_baru): ?>
                                <?php //foreach($jab_kosong_baru as $k): ?>
                                    <li><?php //echo anchor('jabatan_struktural/isi_draft_jabatan/'.$k->id_draft.'/'.$k->id_j,  "<small>".$k->jabatan."</small>", array("class" => "list")); ?></li>
                                <?php //endforeach; ?>
                            <?php //else: ?>
                                <a href="#" class="list"><div class="list-content">...</div></a>
                            <?php //endif; ?>
                        </ul>
                    </li><!-->
                    <li><?php echo anchor("jabatan_struktural/refresh_jabatan_kosong/".$draft_pelantikan->id_draft,"<i class='icon-copy'></i> Update Jabatan Kosong</a>");?></li>
					<li>
						<a class="dropdown-toggle" href="#"><i class="icon-tree-view"></i>Lepas Jabatan <?php echo " (".(is_array(@$lepas_jabatan) && sizeof(@$lepas_jabatan) > 0?sizeof(@$lepas_jabatan):0).")" ?></a>
						<ul class="dropdown-menu" data-role="dropdown">
						<?php if(isset($lepas_jabatan)): ?>
							<?php foreach($lepas_jabatan as $lepas): ?>
                                <li><a><?php echo $lepas->nama_pegawai."<br/>".$lepas->nip_baru.($lepas->flag_pensiun<>0?'<br>('.$lepas->status_aktif.' '.$lepas->tgl_pensiun_dini.')':''); ?></a></li>
							<?php endforeach; ; ?>
						<?php endif; ?>
						</ul>
					</li>
					<li><?php echo anchor("jabatan_struktural/pegawai_rangkap_jabatan/".$draft_pelantikan->id_draft,"<i class='icon-copy'></i> Pegawai Rangkap Jabatan</a>");?></li>
					<li><?php echo anchor("jabatan_struktural/riwayat_pengubahan_jabatan/".$draft_pelantikan->id_draft,"<i class='icon-copy'></i> Riwayat Pengubahan Jabatan</a>");?></li>
					<li><?php echo anchor("jabatan_struktural/potensi_kosong/".$draft_pelantikan->id_draft,"<i class='icon-copy'></i> Jabatan Berpotensi Kosong</a>");?></li>
					<li><?php echo anchor("jabatan_struktural/log_aktifitas/".$draft_pelantikan->id_draft,"<i class='icon-copy'></i> Log Aktifitas</a>");?></li>
					<li><?php echo anchor("jabatan_struktural/setting_pengesahan/".$draft_pelantikan->id_draft,"<i class='icon-cog'></i>Pengaturan Pengesahan</a>");?></li>
                    <!--<li><?php //echo anchor("/phpexcel/excel_draft_pelantikan/index/".$draft_pelantikan->id_draft,
                            //"<i class='icon-download'></i>Download Draft</a>"//,array( 'target' => '_blank'));?></li>-->
					<!--<li><?php //echo anchor("jabatan_struktural/selesai/".$draft_pelantikan->id_draft,"<i class='icon-checkmark'></i>Selesai (Update Organigram)</a>");?></li>-->
					<li><?php echo anchor("jabatan_struktural/hapus/".$draft_pelantikan->id_draft,"<i class='icon-remove'></i>Hapus Draft Pelantikan Ini</a>",array('flag'=>'confirm'));?></li>
					<li><?php echo anchor("jabatan_struktural/logout/".$draft_pelantikan->id_draft,"<i class='icon-user'></i>Logout</a>");?></li>
				</ul>
			</nav>
		</div>

		<div class="span12">

			<script type="text/javascript">
				$("a[flag=confirm]").click(function(){
					if(!confirm('Lanjutkan menghapus draft?'))
						return false;
				});
			</script>
