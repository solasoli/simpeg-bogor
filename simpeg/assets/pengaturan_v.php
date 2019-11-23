<div class="container">
<h2>Cuti Bersama</h2>
<br/>
<div style="margin-left:73%"><button id="tambah" class="button danger">Tambah</button></div>
<div style="margin-left:5%;margin-right:20%">
<table class="table striped">
	<thead>
		<th class="text-left">Tahun</th>
		<th class="text-left">Jumlah</th>
		<th class="text-left">Modifikasi</th>
	</thead>
	<tbody>
	<?php 
		foreach($cuti_bersama->result() as $r) :
	?>
	<tr>
		<td><?php echo $r->tahun?></td>
		<td><?php echo $r->jumlah?></td>
		<td width="200px"><a class="button info">Edit</a> <a class="button info">Hapus</a></td>
	</tr>
	<?php
		endforeach;
	?>
	</tbody>
</table>
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
      var content = '<form class="user-input" method="post" action="insert_cuti_bersama">' +
                    '<label>Tahun</label>' +
                    '<div class="input-control text"><input type="text" name="tahun"></div>' +
                    '<label>Jumlah</label>'+
                    '<div class="input-control text"><input type="text" name="jumlah"></div>' +
                    '<button class="button primary">OK</button>&nbsp;'+
                    '<button class="button" type="button" onclick="$.Dialog.close()">Cancel</button> '+
                    '</form>';
					$.Dialog.title("Form Cuti Bersama");
                    $.Dialog.content(content);
                                }
                            });
                        });                    
</script>