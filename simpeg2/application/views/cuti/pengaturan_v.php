<div class="container">
<h2>Cuti Bersama</h2>
<br/>
<div style="margin-left:71%"><button id="tambah" class=" icon-plus button info"> &nbsp;Tambah </button></div>
<div style="margin-left:5%;margin-right:20%">
<table class="table striped">
	<thead>
		<!--<th class="text-left">Tahun</th>-->
		<th class="text-left">No</th>
		<th class="text-left">Tanggal</th>
		<th class="text-left">Hari</th> 
		<th class="text-left">Keterangan</th>
		<!--<th class="text-left">Jumlah</th>-->
		<th class="text-left">Modifikasi</th>
	</thead>
	<tbody>
	<?php 
		foreach($cuti_bersama->result() as $r) :
	?>
	<tr>
		<!--<td><?php echo $r->tahun?></td>
		<input type="hidden" id="tahun_<?php echo $r->tahun?>" value="<?php echo $r->tahun?>"/>-->
		
		<!--<td><?php echo $r->jumlah?></td>
		<input type="hidden" id="jumlah_<?php echo $r->tahun?>"value="<?php echo $r->jumlah?>"/>-->
		
		<td><?php echo $r->no?></td>
		<input type="hidden" id="no_<?php echo $r->tanggal?>"value="<?php echo $r->no?>"/>
		
		
		
		<td><?php echo $r->tanggal?></td>
		<input type="hidden" id="tanggal_<?php echo $r->tanggal?>"value="<?php echo $r->tanggal?>"/>
		
		<td><?php echo $r->hari?></td>
		<input type="hidden" id="hari_<?php echo $r->tanggal?>"value="<?php echo $r->hari?>"/>
		
		<td><?php echo $r->ket?></td>
		<input type="hidden" id="ket_<?php echo $r->tanggal?>"value="<?php echo $r->ket?>"/>

		<td>
			<form action="delete_by_tanggal/<?php echo $r->tanggal;?>"/>
			<a class="icon-pencil info button edit" id="edit_<?php echo $r->tanggal; ?>">&nbsp;Edit</a>&nbsp;
			<a class="icon-remove small danger button " href="delete_cuti_bersama/<?php echo $r->tanggal; ?>">&nbsp;Hapus</a>
			
			</form>

		</td>
			
		<!--<td><a href="<?php echo base_url();?>pengaturan/delete_cuti_bersama/<?php echo $r->no?>" class="button info" class="hapus">Hapus</a></td>-->
	</tr>
	<?php
		endforeach;
	?>
	</tbody>
</table>
<p id="hasil"></p>
</div>
</div>
</br>

<!--libur nasional-->
<div class="container">
<h2>Libur Nasional</h2>
<br/>
<!--<div style="margin-left:73%"><button id="tambah2" class="button danger">Tambah</button></div>-->
<div style="margin-left:71%"><button id="tambah2" class="icon-plus button info">&nbsp;Tambah</button></div>
<div style="margin-left:5%;margin-right:20%">
<table class="table striped">
	<thead>
		<!--<th class="text-left">Tahun</th>-->
		<th class="text-left">No</th>
		<th class="text-left">Tanggal</th>
		<th class="text-left">Hari</th>
		<th class="text-left">Keterangan</th>
		<!--<th class="text-left">Jumlah</th>-->
		<th class="text-left">Modifikasi</th>
	</thead>
	<tbody>
	<?php 
		foreach($libur_nasional->result() as $n) :
	?>
	<tr>		
		<td><?php echo $n->no?></td>
		<input type="hidden" id="no2_<?php echo $n->tanggal?>"value="<?php echo $n->no?>"/>
		
		<td><?php echo $n->tanggal?></td>
		<input type="hidden" id="tanggal2_<?php echo $n->tanggal?>"value="<?php echo $n->tanggal?>"/>
		
		<td><?php echo $n->hari?></td>
		<input type="hidden" id="hari2_<?php echo $n->tanggal?>"value="<?php echo $n->hari?>"/>
		
		<td><?php echo $n->ket2?></td>
		<input type="hidden" id="ket2_<?php echo $n->tanggal?>"value="<?php echo $n->ket2?>"/>			
		<!--<td><a href="<?php echo base_url();?>pengaturan/delete_libur_nasional/<?php echo $n->no?>" class="button info" class="hapus">Hapus</a></td>-->
	
		<td>
			<a class="icon-pencil info button edit2" id="edit2_<?php echo $n->tanggal; ?>">&nbsp;Edit</a>&nbsp;
			<a class="icon-remove small danger button" href="delete_libur_nasional/<?php echo $n->tanggal?>">&nbsp;Hapus</a>
		</td>

	</tr>
	<?php
		endforeach;
	?>
	</tbody>
</table>
<p id="hasil"></p>
</div>
</div>

<script>                  
 $("#tambah").on('click', function(){
      $.Dialog({
      overlay: true,
      shadow: true,
      flat: true,
      title: 'Form Cuti Bersama',
      content: '',
	  width:500,
      padding: 10,
      onShow: function(_dialog){
      var content = '<form class="user-input" method="post" action="<?php echo base_url();?>pengaturan/insert_cuti_bersama">' +
                    '<label>Tanggal</label>' +
                    '<div class="input-control text" id="datepicker"><input type="text" name="tanggal"><a class="btn-date"></a></div>' +
                    '<label>Hari</label>'+
                    '<div class="input-control text" id="hari"><input type="text" name="hari"></div>' +
					'<label>Keterangan</label>'+
                    '<div class="input-control text" id="ket"><input type="text" name="ket"></div>' +
                    '<button class="button primary">OK</button>&nbsp;'+
                    '<button class="button" type="button" onclick="$.Dialog.close()">Cancel</button> '+
                    '</form>';
					$.Dialog.title("Form Cuti Bersama");
                    $.Dialog.content(content);

                                }
                            });
					$("#datepicker").datepicker({
						format: "yyyy-mm-dd"});

                        }); 

$("#tambah2").on('click', function(){
      $.Dialog({
      overlay: true,
      shadow: true,
      flat: true,
      title: 'Form Cuti Bersama',
      content: '',
	  width:500,
      padding: 10,
      onShow: function(_dialog){
      var content = '<form class="user-input"  method="post" action="<?php echo base_url();?>pengaturan/insert_libur_nasional">' +
                    '<label>Tanggal</label>' +
                    '<div class="input-control text" id="datepicker"><input type="text" name="tanggal"><a class="btn-date"></a></div>' +
                    '<label>Hari</label>'+
                    '<div class="input-control text" id="hari"><input type="text" name="hari"></div>' +
					'<label>Keterangan</label>'+
                    '<div class="input-control text" id="ket2"><input type="text" name="ket2"></div>' +
                    '<button class="button primary">OK</button>&nbsp;'+
                    '<button class="button" type="button" onclick="$.Dialog.close()">Cancel</button> '+
                    '</form>';
					$.Dialog.title("Form Cuti Bersama");
                    $.Dialog.content(content);
                                }
                            });

						$("#datepicker").datepicker({
						format: "yyyy-mm-dd"});

                        }); 


$(".edit").on('click', function(){
      $.Dialog({
      overlay: true,
      shadow: true,
      flat: true,
      title: 'Form Cuti Bersama',
      content: '',
	  width:500,
      padding: 10,
      onShow: function(_dialog){
      var content = '<form class="user-input" method="post" action="<?php echo base_url();?>cuti/update_cuti_bersama">' +
                    '<label>Tanggal</label>' +
                    '<div class="input-control text" id="tahun_editx"><input type="text" readonly="readonly" id="tanggal_edit" name="tanggal_edit"></div>' +
                    '<label>Hari</label>'+
                    '<div class="input-control text"><input type="text" id="hari_edit" name="hari_edit"></div>'+
					'<label>Keterangan</label>'+
                    '<div class="input-control text"><input type="text" id="ket_edit" name="ket_edit"></div>'+
                    '<button class="button primary">OK</button>&nbsp;'+
                    '<button class="button" type="button" onclick="$.Dialog.close()">Cancel</button> '+
                    '</form>';
					$.Dialog.title("Form Cuti Bersama");
                    $.Dialog.content(content);
                 }
			});
			var tgl = this.id.substr(5);
			$("#tanggal_edit").val(tgl);
			$("#hari_edit").val($("#hari_"+ tgl).val() );
			$("#ket_edit").val($("#ket_"+ tgl).val() );
         });  	

$(".edit2").on('click', function(){
      $.Dialog({
      overlay: true,
      shadow: true,
      flat: true,
      title: 'Form Libur Nasional',
      content: '',
	  width:500,
      padding: 10,
      onShow: function(_dialog){
      var content = '<form class="user-input" method="post" action="<?php echo base_url();?>cuti/update_libur_nasional">' +
                    '<label>Tanggal</label>' +
                    '<div class="input-control text" id="tahun_editx"><input type="text" readonly="readonly" id="tanggal2_edit2" name="tanggal2_edit2"></div>' +
                    '<label>Hari</label>'+
                    '<div class="input-control text"><input type="text" id="hari2_edit2" name="hari2_edit2"></div>'+
					'<label>Keterangan</label>'+
                    '<div class="input-control text"><input type="text" id="ket2_edit2" name="ket2_edit2"></div>'+
                    '<button class="button primary">OK</button>&nbsp;'+
                    '<button class="button" type="button" onclick="$.Dialog.close()">Cancel</button> '+
                    '</form>';
					$.Dialog.title("Form Libur Nasional");
                    $.Dialog.content(content);
                 }
			});
			var tgl = this.id.substr(6);
			$("#tanggal2_edit2").val(tgl);
			$("#hari2_edit2").val($("#hari2_"+ tgl).val() );
			$("#ket2_edit2").val($("#ket2_"+ tgl).val() );
         }); </script>

