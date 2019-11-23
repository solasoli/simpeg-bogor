<div class="box success">
	<header><h5>Form Isian Kegiatan</h5></header>
    <div class="body">
    	<form method="post" action="<?php echo base_url('kegiatan/add') ?>" enctype="multipart/form-data" name="isian" id="isian">
        	<a name="pager" id="pager"></a>
   	    <input type="hidden" name="idid" value="<?php echo $row['kegiatan_id']?>" />


            <?php echo form_error('hari',' ');?>

            <div class="form-group">
            	<label>Tanggal</label>
                <div class="row">
                	<div class="col-md-6">
                    	<div class="input-group input-append date" id="dp4" data-date="<?php echo substr($row['kegiatan_tanggal'],0,10)?>" data-date-format="yyyy-mm-dd">
                            <input class="form-control add-on" name="tanggal" type="text" value="<?php echo substr($row['kegiatan_tanggal'],0,10)?>">
                            <span class="input-group-addon"><i class="icon-calendar"></i></span>
                        </div>
                    </div>

                    <div class="col-md-6">
                    	<div class="input-group bootstrap-timepicker">
                            <input class="timepicker-24 form-control" name="jam" type="text" value="<?php echo substr($row['kegiatan_tanggal'],10,8)?>" />
                            <span class="input-group-addon"><i class="icon-time"></i></span>
                        </div>
                    </div>
                </div>
            </div>

            <?php echo form_error('tanggal')?>

            <div class="form-group">
                <label>Kegiatan Rincian

                <?php  //print_r($skp[0]); ?>
                </label>
                <input type="hidden" name="kategori" class="form-control" value="12">
                <select name="kategorix" id="kategorix" class="form-control">
                <option value="0">Pilih Rincian Kegiatan</option>
                <?php foreach($skp as $sk) {
					if($row['kegiatan_rincian']!=$sk['kegiatan'])
					echo("<option value='".$sk['kegiatan']."' >$sk[kegiatan]</option>");
					else
					echo("<option value='".$sk['kegiatan']."' selected=selected >$sk[kegiatan]</option>");

				}?>
                <option value="Tugas tambahan">Tugas tambahan </option></select>

               <!---
                <input type="text" name="kategorix" class="form-control" value="<?php// echo $row['kegiatan_rincian']; ?>">

                --->
            </div>


            <?php echo form_error('kategori',' ');?>

            <?php
				$kegi['rincian'] = $row['kegiatan_rincian'];
				$this->session->set_userdata($kegi);
			?>
            <div class="form-group">
            	<label>Keterangan Kegiatan</label>
                <textarea id="autosize" name="keterangan" class="form-control"><?php if($row['kegiatan_keterangan']==""){echo $this->input->post('keterangan');}else{echo $row['kegiatan_keterangan'];};?></textarea>

            </div>

             <div class="form-group">
            	<label>Durasi Pengerjaan Dalam Satuan Jam:Menit </label>
                <!-- <input type="text" id="autosize"  name="durasi" class="form-control" value="<?php // if($row['kegiatan_durasi']==""){echo $this->input->post('durasi');}else{echo $row['kegiatan_durasi'];};?>"> -->

                <div class="form-inline">
                  <?php
                    if(isset($row['durasi'])){
                        $kegiatan_durasi = explode(".",$row['durasi']);
                    };
                    ?>
                  <select class="jam form-control" name="durasi_jam" id="durasi_jam" style="width:auto;">

                        <?php $x=0; while($x <=12){ ?>

                            <option value="<?php echo $x ?>" ><?php echo $x ?></option>

                        <?php $x++; } ?>

                  </select> :
                  <select class="menit form-control" style="width:auto;" name="durasi_menit" id="durasi_menit">

                        <?php $y=0; while($y <=60){ ?>
                          <? if($kegiatan_durasi[1] == $y){ ?>

                            <option value="<?php echo $y ?>" ><?php echo $y ?></option>

                        <?php $y += 5; } ?>
                  </select>
                </div>
            </div>

            <?php echo form_error('keterangan', '<div class="alert alert-danger">Keterangan Kegiatan belum di isi.</div>');?>
            <div class="form-group">
            	<label>Dokumen Pendukung</label>
                <input type="file"  id="upload" name="upload" class="form-control">

            </div>
            <div class="form-group">
            	<a type="button" name="simpan" id="simpan" class="btn btn-primary">Simpan</a>
                <button type="reset" class="btn btn-primary">Reset</button>
            </div>

        </form>
    </div>
</div>
