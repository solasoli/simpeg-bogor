<?php if(isset($riwayat_jabatan)): ?>
<ul>	
	<?php foreach($riwayat_jabatan as $r): ?>																								
	<li>		
		<div><strong><?php echo $r->Jabatan ?> (<?php echo substr($r->tgl_masuk,0,4) ?>)</strong></div>
		<div><?php echo $r->unit_kerja ?></div>
	</li>	
	<?php endforeach; ?>
</ul>
<?php else: ?>
	Tidak ada data riwayat jabatan.
<?php endif;