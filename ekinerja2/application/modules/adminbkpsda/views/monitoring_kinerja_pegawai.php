
<div class="panel-content" data-role="panel"
     data-title-caption=""
     data-title-icon=""
     data-cls-title="bg-steel fg-white">
    <?php
        //echo $this->session->userdata('id_pegawai_enc');
        //echo $this->session->userdata('id_skpd_enc');
    ?>
  
    <div id="divListMonitoringOpd">
      <table id="tableMonitoringOpd" class="table">
          <thead>
            <tr>

              <th>Nama OPD</th>
              <th>Alamat</th>
            </tr>
          </thead>
      </table>
    </div>
</div>

<!--script type="text/javascript">
  $(document).ready(function(){
    $.ajax({
    url: "http://simpeg.kotabogor.go.id/rest/Unit_kerja/getAll",
    dataType: "json",
    type : "GET",
    success : function(r) {
      console.log(r);
    }
  });
  });
</script-->
<script type="text/javascript">
$(document).ready(function() {
  $('#tableMonitoringOpd').DataTable( {
      "ajax": "http://simpeg.kotabogor.go.id/rest/Unit_kerja/getAll",
      "columns": [
          { "data": "nama_skpd" },
          { "data": "alamat" },
      ]
  } );
} );
</script>
