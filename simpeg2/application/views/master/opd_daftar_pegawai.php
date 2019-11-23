<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<style>
    table{
        margin: 0 auto;
        clear: both;
        border-collapse: collapse;
        /*width: 100%;
        table-layout: fixed;
        word-wrap:break-word;*/
    }
    

</style>
<nav class="breadcrumbs small">
    <ul>
        <li><a href="<?php echo base_url() ?>">Home</a></li>
        <li><a href="<?php echo base_url('unit_kerja/daftar') ?>">Daftar Unit Kerja</a></li>
        <li class="active"><a href="#">Daftar Pegawai <?php echo $nama_opd ?></a></li>
    </ul>
</nav>
<div class="grid fluid">
	<div class="row">
		<div class="span12">
			<h1>Daftar Pegawai <br><small><?php echo $nama_opd ?></small></h1>
			<table class="table bordered hovered striped" id="daftar_pegawai">
				<thead>
					<tr style="border-bottom: 2px solid rgba(149,199,100,0.78);">
						<td>No</td>
						<td>Id</td>
						<td>Nama</td>
						<td>NIP</td>
						<td>Pangkat/Gol</td>
						<td>Eselon</td>
                        <td>Jabatan</td>
                        <td>Rata-rata Capaian SKP</td>
                        <td>Rata-rata Perilaku</td>
                        <td>Orientasi Pelayanan</td>
                        <td>Integritas</td>
                        <td>Komitmen</td>
                        <td>Disiplin</td>
                        <td>Kerja Sama</td>
                        <td>Kepemimpinan</td>
                        <td>60% Capaian</td>
                        <td>40% Perilaku</td>
                        <td>Nilai SKP</td>
						<td>Aksi</td>
					</tr>
				</thead>
				<tbody>
					<?php $x=1;foreach($list as $peg) {?>
					<?php //$pegawai = $this->pegawai->get_by_id($peg->id_pegawai) ;?>
					<tr>
						<td><?php echo $x++ ?></td>
						<td><?php echo $peg->id_pegawai ?></td>
						<td><?php echo $peg->nama_lengkap ?></td>
						<td><?php echo "'".$peg->nip_baru ?></td>
						<td><?php echo $peg->pangkat." - ".$peg->golongan ?></td>
                        <td><?php echo $peg->eselon ?></td>
						<td><?php echo $peg->jabatan;
						//echo $this->jabatan_model->get_jabatan_pegawai($pegawai->id_pegawai); ?></td>
                        <td>
                            <?php
                                echo $peg->nilai_rata2_capaian_skp;
                                /*$last_skp = ($this->pegawai->get_last_skp($pegawai->id_pegawai));
                                foreach ($last_skp->result() as $data) {
                                    $a = $data->periode_awal;
                                    $b = $data->orientasi_pelayanan;
                                    $c = $data->integritas;
                                    $d = $data->komitmen;
                                    $e = $data->disiplin;
                                    $f = $data->kerjasama;
                                    $g = ($data->kepemimpinan==''?0:$data->kepemimpinan);
                                    $thn = $data->thn_skp;
                                }
                                echo 'Periode: '.$a;
                                echo '| Orientasi Pelayanan: '.$b;
                                echo '| Integritas: '.$c;
                                echo '| Komitmen: '.$d;
                                echo '| Disiplin: '.$e;
                                echo '| Kerjasama: '.$f;
                                echo '| Kepemimpinan: '.$g;
                                if($thn>0){
                                    $nilai = $this->pegawai->get_nilai_capaian_rata2($pegawai->id_pegawai, $thn);
                                    echo ' | Nilai Rata-rata: '.$nilai;
                                }*/
                            ?>
                        </td>
                        <td><?php echo $peg->avg_perilaku; ?></td>
                        <td><?php echo $peg->orientasi_pelayanan; ?></td>
                        <td><?php echo $peg->integritas; ?></td>
                        <td><?php echo $peg->komitmen; ?></td>
                        <td><?php echo $peg->disiplin; ?></td>
                        <td><?php echo $peg->kerjasama; ?></td>
                        <td><?php echo $peg->kepemimpinan; ?></td>
                        <td><?php echo $peg->_60_capaian; ?></td>
                        <td><?php echo $peg->_40_perilaku; ?></td>
                        <td><?php echo $peg->nilai_skp; ?></td>
						<td>
							<a href="<?php echo base_url('pegawai/profile').'/'.$peg->id_pegawai; ?>" class="button primary small" data-hint="Detail" target="_blank">
								<span class="icon-pencil"></span>
							</a>
						</td>
					</tr>						
					<?php } ?>
				</tbody>
			</table>
		</div>
	</div>
</div>
<script>
	$(function(){
			$('#daftar_pegawai').dataTable();
		});
</script>

<!-- End of file daftar_pegawai.php -->
<!-- Location ./application/views/daftar_pegawai.php -->
