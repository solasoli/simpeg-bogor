<!DOCTYPE html>
<html>
<head>
<meta charset='utf-8' />
<link href='./assets/css/fullcalendar.min.css' rel='stylesheet' />
<link href='./assets/css/fullcalendar.print.min.css' rel='stylesheet' media='print' />
<script src='./assets/js/moment.min.js'></script>
<script src='./assets/js/jquery.min.js'></script>
<script src='./assets/js/fullcalendar.min.js'></script>
<script>
<?php
extract($_POST);
extract($_GET);
include("konek.php");
if(isset($delete))
mysqli_query($mysqli,"delete from jadwal_transaksi where id=$delete");
$q=mysqli_query($mysqli,"select id_unit_kerja from current_lokasi_kerja where id_pegawai=$id");
$data=mysqli_fetch_array($q);

$q1=mysqli_query($mysqli,"select * from jadwal_transaksi where id_pegawai=$id and id_unit_kerja=$data[0]");


?>
  $(document).ready(function() {

    $('#calendar').fullCalendar({
      defaultDate: '<?php echo date("Y-m-d"); ?>',
      editable: true,
      eventLimit: true, // allow "more" link when too many events
      events: [
	  
	  <?php
	  $i=1;
	  while($ata=mysqli_fetch_array($q1))
	  {
	  
	  $q2=mysqli_query($mysqli,"select * from jadwal where id=$ata[2]");
	  $ta=mysqli_fetch_array($q2);
	  
	  
	  $mulai=substr($ata[4],0,10);
	  $akhir=substr($ata[5],0,10);
	  $masuk=substr($ata[4],11,8);
	  $pulang=substr($ata[5],11,8);
	  if($i==1)
	  echo("{title: '".$ta[1]." masuk : ".$masuk." pulang: ".$pulang." [Hapus Jadwal]', url: 'jadwal.php?id=$id&delete=$ata[0]', start: '".$mulai."',end: '".$akhir."'}");
	  else
	  echo(",{title: '".$ta[1]." masuk : ".$masuk." pulang: ".$pulang." [Hapus Jadwal]', url: 'jadwal.php?id=$id&delete=$ata[0]', start: '".$mulai."',end: '".$akhir."'}");
	  
	  $i++;
	  }
     
	 
	 ?>
	 /*
	    {
          title: 'All Day Event xxxx',
          start: '2018-03-01'
        },
        {
          title: 'Long Event',
          start: '2018-03-07',
          end: '2018-03-10'
        },
        {
          id: 999,
          title: 'Repeating Event',
          start: '2018-03-09T16:00:00'
        },
        {
          id: 999,
          title: 'Repeating Event',
          start: '2018-03-16T16:00:00'
        },
        {
          title: 'Conference',
          start: '2018-03-11',
          end: '2018-03-13'
        },
        {
          title: 'Meeting',
          start: '2018-03-12T10:30:00',
          end: '2018-03-12T12:30:00'
        },
        {
          title: 'Lunch',
          start: '2018-03-12T12:00:00'
        },
        {
          title: 'Meeting',
          start: '2018-03-12T14:30:00'
        },
        {
          title: 'Happy Hour',
          start: '2018-03-12T17:30:00'
        },
        {
          title: 'Dinner xxx',
          start: '2018-03-12T20:00:00'
        },
        {
          title: 'Birthday Party',
          start: '2018-03-13T07:00:00'
        },
        {
          title: 'Click for Google',
         
          start: '2018-03-28'
        }
		*/
      ]
    });

  });

</script>
<style>

  body {
    margin: 40px 10px;
    padding: 0;
    font-family: "Lucida Grande",Helvetica,Arial,Verdana,sans-serif;
    font-size: 14px;
  }

  #calendar {
    max-width: 900px;
    margin: 0 auto;
  }

</style>
</head>
<body>

  <div id='calendar'></div>

</body>
</html>
