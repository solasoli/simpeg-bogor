<ul class="nav nav-pills hidden-print">
  <li class="active" id="li_golongan">
    <a href="#" id="lnk_golongan">Golongan</a>
  </li>
  <li id="li_age"><a href="#" id="lnk_age">Usia</a></li>
  <li><a href="#">Pendidikan</a></li>
  <li><a href="#">Eselon</a></li>
  <li id="li_gender"><a href="#" id="lnk_gender">Jenis Kelamin</a></li>
</ul>

<div id="container" align="center">
</div>

<script type="text/javascript">
function show_loading()
{
	$("#container").html("LOADING..");
}

show_loading();
$.post("report_by_golongan.php", {}, function(data){
	$("#container").html(data);
});

$("#lnk_gender").click(function(){
	show_loading();
	$.post("report_by_gender.php", {}, function(data){
		$("#container").html(data);
	});
});

$("#lnk_golongan").click(function(){
	show_loading();
	$.post("report_by_golongan.php", {}, function(data){
		$("#container").html(data);
	});
});

$("#lnk_age").click(function(){
	show_loading();
	$.post("report_by_age.php", {}, function(data){
		$("#container").html(data);
	});
});

</script>
