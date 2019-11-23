<div class="container">
  <p>
    <h2>User Roles List		<span class="place-right">
      <button class="button" id="tambahRole">Tambah</button></span>	</h2>	</p>
      <table class="table bordered hovered"  id="roleList">
        <thead>
          <tr>
            <th>id pegawai</th>
            <th>Nama</th>
            <th>NIP</th>
            <th>Unit kerja</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php if(sizeof($user_roles)>0): ?>
            <?php foreach($user_roles as $r): ?>
              <?php $peg = $this->pegawai->get_by_id($r->id_pegawai); ?>
              <tr>			<td><?php echo $r->id_pegawai ?></td>
                <td><?php echo anchor("master/assign_role_to_user/".$r->id_pegawai,$peg->nama) ?></td>
                <td><?php echo $peg->nip_baru ?></td>
                <td><?php echo $this->pegawai->get_by_id($r->id_pegawai)->nama_baru?></td>
                <td width='20%'>				<?php // echo anchor('master/edit_role/'.$r->role_id,'Ubah') ?>
                  <button class="button info" id="ubahRole">Edit</button>
                  <a href="<?php echo base_url().'master/delete_user_role/'?>" class="button warning" onclick="return confirm('yakin akan dihapus?')">Delete</a>
                  <?php //echo anchor('master/delete_role/'.$r->role_id,'Hapus',array('onclick'=>'"return confirm(\'Yakin menghapus\')"','class'=>'button')) ?>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php else:?>
            <tr>
              <td colspan="2">Tidak ada data yang dapat disajikan</td>
            </tr>		<?php endif; ?>
          </tbody>
        </table>
        <?php //echo anchor('master/add_roles','Tambah') ?>
        <script>
          $(function(){
            $("#tambahRole").on('click', function(){
              $.Dialog({
                overlay: true,
                shadow: true,
                flat: true,
                draggable: true,
                //icon: '<img src="images/excel2013icon.png">',
                //title: 'Flat window',
                content: '',
                padding: 10,
                onShow: function(_dialog){
                  var content = '<form class="user-input" action="<?php echo base_url('pegawai/instant_search?landing=master/assign_role_to_user')?>" method="post">' +
                  //'<label>Role Baru</label>' +
                  '<div class="input-control text"><input type="text" name="txtKeyword" placeholder="Cari pegawai (nama/NIP)"></div>' +
                  '<div class="form-actions">' +
                  '<button class="button primary">Cari</button>&nbsp;'+
                  '<button class="button" type="button" onclick="$.Dialog.close()">Batal</button> '+
                  '</div>'+
                  '</form>';
                  $.Dialog.title("Tambah User");
                  $.Dialog.content(content);
                }
              });
            });
            $("#editRole").on('click',function(e){
              var isi = document.getElementById();
            });
          });
          $('#roleList').dataTable();
        </script>
      </div>
      <!--  End of file index.php --><!--  Location: ./application/views/cuti/index.php  -->
