<div class="col-md-12">
<div class="card">
  <div class="card-body">
    <h5 class="card-title">Filter Kegiatan</h5>
    <form method="post" action="<?php echo site_url('kegiatan/short') ?>">
      <div class="row">
      <!--input type="text" placeholder="Tanggal mulai" name="tgl1" class="form-control" id="dp2" data-date-format="yyyy-mm-dd"-->
        <div class="form-inline">
					<input type="txt" name="tgl1" id="dp2" class="form-control tanggalan"  data-format='DD-MM-YYYY' data-template='DD MMM YYYY'>
      	</div>
        <span>&nbsp;&nbsp; s/d &nbsp;&nbsp;</span>
        <div class="form-inline">
					<input type="txt" name="tgl2" id="dp3" class="form-control tanggalan"  data-format='DD-MM-YYYY' data-template='DD MMM YYYY'>
      	</div>
        &nbsp;&nbsp;
        <div>
          <button type="submit" class="btn btn-flat btn-primary">Filter</button>
        </div>
      </div>

    </form>
  </div>
</div>
</div>
<br><br><br><br><br><br>
<div class="col-md-12">
<div class="card primary">
<div class="card-body">
	<div class="card-title">
    <h5>Daftar Kegiatan
        <?php
        if($tgl1) {
            echo "Tanggal ".$tgl1." sampai ".$tgl2;
        }
        ?>
    </h5>
    <div class="toolbar">


        <a href="<?php echo site_url('laporan/exporttoexcel?tglmulai='.$tgl1.'&tglakhir='.$tgl2)?>" class="btn btn-success btn-sm"><i class="icon-download"> Download excel</i></a>
    </div>
  </div>
    <div class="body" id="tabel_kegiatan">
        <div class="table-responsive">
            <?php echo $this->session->flashdata('v')?>
            <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                <thead>
                    <tr>
                        <th>No</th>
                        <th width="150px">Waktu</th>
                        <!-- <th>Kategori Pekerjaan</th> -->
                        <th>Detail Pekerjaan</th>
                        <th>Keterangan</th>
                        <th>Pengaturan</th>
                         <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no=1;foreach($query as $que):?>
                    <tr class="odd gradeX">
                        <td><?php echo $no?></td>
                        <td>
                            <?php
                                $bul = explode("-", $que['kegiatan_tanggal']);
                                //echo $que['kegiatan_hari'].', '.substr($que['kegiatan_tanggal'],8,2).' '.konbul($bul[1]).' '.substr($que['kegiatan_tanggal'],0,4).' '.substr($que['kegiatan_tanggal'],11,12);
                                echo $que['kegiatan_tanggal'];
                            ?>
                        </td>
                        <!-- <td><?php //echo $que['kategori_nama']?></td> -->
                        <td><?php echo $que['kegiatan_rincian']?></td>
                        <td><?php echo $que['kegiatan_keterangan']?></td>
                        <td align="center">
                            <div class="tooltip-demo">
      <?php
	  if($que['url']!=NULL)
	  {
	  ?>
                             <a target="_blank" href="<?php echo base_url('uploads/dokumen/'.$que['url'])?>" class="btn btn-xs btn-success"data-toggle="tooltip" data-placement="left" title="Edit"><i class="icon-download"></i></a>
                             <?php
							 }
							 ?>


                            <a href="<?php echo site_url('kegiatan/index/'.$que['kegiatan_id'].'/edit')?>#pager" class="btn btn-xs btn-warning"data-toggle="tooltip" data-placement="left" title="Edit"><i class="icon-edit"></i></a>
                            <a onclick="return confirm('Apakah yakin menghapus <?php echo $que['kegiatan_rincian']?> ?')" href="<?php echo site_url('kegiatan/delete/'.$que['kegiatan_id'].'/hapus')?>" data-toggle="tooltip" data-placement="left" title="Hapus" class="btn btn-xs btn-danger"><i class="icon-remove"></i></a>
                            </div>
                        </td>
                        <td>
                        <?php
						if($que['approved']==1)
						echo("Disetujui");
						else if($que['approved']==2)
						echo("Ditolak");

						?>
                        </td>
                    </tr>
                    <?php $no++;endforeach;?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<hr />
<div class="box success">
	<?php $this->load->view('form_isian'); ?>
</div>
</div>
<style type="text/css">
	.wakwaw option{
}
</style>
<!-- PAGE LEVEL SCRIPTS -->
<script type="text/javascript">

/*
	var smb = document.getElementById("sembunyi").value;
	if(smb == ""){
		$('#hasil').load("<?php echo site_url('kegiatan/blank')?>");
	}else {
		$('#hasil').load("<?php echo site_url('kegiatan/getkategori?kode=')?>" + smb);
	}
*/
	$('#combodinamis').change(function(){

		var selected = $('#combodinamis').val();
		$('#hasil').load("<?php echo site_url('kegiatan/getkategori?kode=')?>" + selected);
	});

</script>
