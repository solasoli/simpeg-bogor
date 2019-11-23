<style>
	#msg-icon{width:45px; height: 36px;  margin:auto; cursor: pointer;}
	.counter{display: inline; color: #fff; font-size: 12px;  padding:0px 3px;
		float: right; margin-top: 7px; margin-right: 8px; font-weight: bold;}
	#notificationContainer {
		background-color: #fff;
		border: 1px solid #9a9a9a;
		overflow: visible;
		position: absolute;
		top: 45px;
		margin-left: 0px;
		width: 340px;
		z-index: 100;
		display: none;
	}
	#notificationContainer:before {
		content: '';
		display: block;
		position: absolute;
		width: 0;
		height: 0;
		color: transparent;
		border: 10px solid black;
		border-color: transparent transparent white;
		margin-top: -20px;
		margin-left: 15px;
	}
	#notificationTitle {
		z-index: 1000;
		font-weight: bold;
		color: black;
		padding: 8px;
		font-family: "Segoe UI Light", "Open Sans", sans-serif, sans;
		font-size: 13px;
		background-color: #ffffff;
		width: 333px;
		border-bottom: 1px solid #dddddd;
	}
	#notificationsBody {
		font-family: "Segoe UI Light", "Open Sans", sans-serif, sans;
		font-size: 12px;
		color: #000;
		padding: 10px 10px 10px 10px !important;
		max-height:300px;
		overflow:auto;
	}
	#divInformasiNotifikasi{
		padding-bottom: 20px;
	}
	#notificationFooter {
		background-color: #e9eaed;
		color: black;
		text-align: center;
		font-weight: bold;
		padding: 8px;
		font-size: 12px;
		border-top: 1px solid #dddddd;
	}
</style>

<?php
$is_tim = false; // tim opd flag 
$is_administrator = false; //admin flag
if($_SESSION['user'] == NULL && $_SESSION['id_pegawai'] == NULL)
{
	header('location:'.BASE_URL.'index.php');
}

$q = mysql_query("SELECT * FROM pegawai WHERE nip_lama = '$_SESSION[user]' OR nip_baru = '$_SESSION[user]'");
if($ata = $qu = $r = mysql_fetch_array($q)){

	$user = $r[0] ;
}

$tim_opd = mysql_query("select * from user_roles where role_id = 2");

while($row = mysql_fetch_array($tim_opd)){
	$tim[] = $row[0];
}

if(in_array($_SESSION['id_pegawai'],$tim)){

	$is_tim = TRUE;
}

$admin_bkpp = mysql_query("select * from user_roles where role_id = 0");

while($row = mysql_fetch_array($admin_bkpp)){
	$tim_admin[] = $row[0];
}

if(in_array($_SESSION['id_pegawai'],$tim_admin)){

	$is_administrator = TRUE;	//ini
}

$qu=mysql_query("select current_lokasi_kerja.id_unit_kerja, unit_kerja.nama_baru, unit_kerja.id_skpd
					from current_lokasi_kerja
					inner join unit_kerja on unit_kerja.id_unit_kerja = current_lokasi_kerja.id_unit_kerja
					where id_pegawai=$ata[id_pegawai]");
$unit = mysql_fetch_array($qu);


?>




<div class="row">
	<div class="col-lg-12">
		<nav class="navbar  navbar-default navbar-fixed-top" role="navigation">
			<!--div class="navbar-inner"-->
			<!--div class="container-fluid">
              <!-- Brand and toggle get grouped for better mobile display -->
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="<?php echo BASE_URL ?>index3.php" style="color: orangered;"><span  class="glyphicon glyphicon-home"></span></a>				
			</div>

			<!-- Collect the nav links, forms, and other content for toggling -->
			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				<ul class="nav navbar-nav">
					<!--li><a href="#">Link</a></li-->
                    <li><a onclick="openNav()"> Menu</a></li>					
					<li class="dropdown">						
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
							<span class="glyphicon glyphicon-folder-close"></span>
							<span class="hidden-sm">Master</span><b class="caret"></b>
						</a>
						<ul class="dropdown-menu">
							<li><a href="index.php?page=masterrumpun"><span class="glyphicon glyphicon-pencil"></span> Rumpun JFT</a></li>
							<li class="divider"></li>							
						</ul>
					</li>
					<li class="dropdown">						
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
							<span class="glyphicon glyphicon-folder-close"></span>
							<span class="hidden-sm">PAK</span><b class="caret"></b>
						</a>
						<ul class="dropdown-menu">
							<li><a href="index.php?page=riwayatpak"><span class="glyphicon glyphicon-pencil"></span> PAK</a></li>
							<li class="divider"></li>							
						</ul>
					</li>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
							<span class="glyphicon glyphicon-check"></span>
							<span class="hidden-sm">Pengukuran</span><b class="caret"></b>						
						</a>
						<ul class="dropdown-menu">
							<li><a href="index.php?page=listofsubordinate&t=review"><span class="glyphicon glyphicon-user"></span> Review Target</a></li>
							<li class="divider"></li>
							<li><a href="index.php?page=listofsubordinate&t=reviewrealisasi"><span class="glyphicon glyphicon-user"></span> Review Realisasi</a></li>
							<li class="divider"></li>
							<li><a href="index.php?page=listofsubordinate&t=perilaku"><span class="glyphicon glyphicon-user"></span> Penilaian Perilaku</a></li>
							<li class="divider"></li>							
						</ul>
					</li>
				</ul>

				<form class="navbar-form navbar-right " role="search" action="<?php echo BASE_URL ?>index3.php?x=search.php" method="post" name="searchform" id="searchform">
					<div class="form-group">
						<input name="s" type="text" id="s"  size="15" class="form-control" placeholder="Cari Pegawai">
					</div>
					<!--button name="submit" type="submit" class="btn btn-default">
                        <span class="glyphicon glyphicon-search"></span> Cari
                    </button-->
				</form>
				<ul class="nav navbar-nav navbar-right">
					<li>
						<div>
						<a class="navbar-brand" href="#">
							<span id="msg-icon" class="glyphicon glyphicon-envelope">
								<div id="load_notif" class="counter" style="display:none">0</div>
								</span>
							</a>
							<div id="notificationContainer">
								<div id="notificationTitle">Notifikasi</div>
								<div id="notificationsBody"><div id="divInformasiNotifikasi"></div></div>
								<div id="notificationFooter"><span onclick="goto_notif_list();" style="cursor: pointer;">Lihat Semua</span></div>
							</div>
						</div>
					</li>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
							<span class="hidden-sm"><?php echo $ata['nama'] ?></span>
							<span class="glyphicon glyphicon-cog">
						<span/>
						</a>

						<ul class="dropdown-menu">
							<li><a href="<?php echo BASE_URL ?>index3.php?x=box.php&od=<?php echo $_SESSION[id_pegawai] ?>"><span class="glyphicon glyphicon-pencil"></span>  Edit Data </a></li>
							<li><a href="<?php echo BASE_URL ?>index3.php?x=ganti_password.php"><span class="glyphicon glyphicon-lock"></span>  Ubah Password</a></li>
							<li class="divider"></li>
							<li><a href="<?php echo BASE_URL ?>logout.php?id=<?php echo $_SESSION['id_pegawai'] ?>"><span class="glyphicon glyphicon-log-out"></span>  Log out</a></li>
						</ul>
					</li>
				</ul>
			</div><!-- /.navbar-collapse -->
			<!--/div><!-- /.container-fluid -->
			<!--/div-->
		</nav>
	</div>
</div>

<br>
<script>
	$(document).ready(function()
	{
	$(document).click(function()
	{
		$("#notificationContainer").hide();
	});

	$("#notificationContainer").click(function()
	{
		return false
	});

	$(function() {
		var thetitle = $('title').text();
		var countNotif = parseInt($('.counter').text());
		var newcountNotif = 0; //++countNotif
		var hasil, jml = '';
		$.ajax({
			type: "GET",
			dataType: "json",
			url: "<?php echo BASE_URL ?>class/cls_ajax_data.php?filter=load_notifikasi&idp=" + <?php echo $user;?>,
			success: function (results) {
				countNotif = parseInt($('.counter').text());
				$.each(results, function(k, v){
					hasil = v.hasil;
					jml = v.jumlah;
				});
			}
		}).done(function(){
			newcountNotif = parseInt(countNotif)+parseInt(jml);
			$('.counter').text(newcountNotif).show();
			$('title').text('(' + newcountNotif + ') ' + thetitle);
		});
		var auto_refresh = setInterval(
				function()
				{
					$.ajax({
						type: "GET",
						dataType: "json",
						url: "<?php echo BASE_URL ?>class/cls_ajax_data.php?filter=load_notifikasi&idp=" + <?php echo $user;?>,
						success: function (results) {
							countNotif = parseInt($('.counter').text());
							var hasil, jml = '';
							$.each(results, function(k, v){
								hasil = v.hasil;
								jml = v.jumlah;
							});
							if(parseInt(countNotif)!=parseInt(jml)){
								if((parseInt(jml) - parseInt(countNotif)) > 0){
									newcountNotif = parseInt(countNotif)+(parseInt(jml) - parseInt(countNotif));
									$.notiny({ text: "Ada pemberitahuan baru", position: 'right-top', theme: 'mytheme'});
								}else{
									newcountNotif = parseInt(countNotif)-(parseInt(countNotif)-parseInt(jml));
								}
							}
							$('.counter').text(newcountNotif).show();
							$('title').text('(' + newcountNotif + ') ' + thetitle);
						}
						}).done(function(){
					});
				}, 7000);
		$('#msg-icon').click(function () {
			$('#msg-icon').removeClass('glyphicon glyphicon-envelope').addClass('glyphicon glyphicon-envelope');
			$('.counter').hide();
			$('title').text(thetitle);
			$("#notificationContainer").fadeToggle(300);
			$("#notification_count").fadeOut("slow");
			$("#divInformasiNotifikasi").html('Loading...');
			$.ajax({
				type: "GET",
				url: "<?php echo BASE_URL ?>notifikasi_msg.php?idp="+ <?php echo $user;?>,
				success: function (data) {
					$("#divInformasiNotifikasi").html(data);
				}
			}).done(function(){

			});
			return false;
		})
	});
	});

	function goto_notif_list(){
		var url = "<?php echo BASE_URL ?>index3.php?x=notifikasi_list_all.php";
		location.href = url;
	}
</script>
<style>
	@keyframes notiny-animation-show-wtf {
		0% {
			opacity: 0;
			filter: blur(4px);
		}
		15% {
			opacity: 1;
		}
		50% {
		}
		90% {
			filter: blur(0px);
		}
		100% {
		}
	}
</style>

<script>
	/*$('.notif').click(function () {
		var countNotif = parseInt($('.counter').text());
		var newcountNotif = ++countNotif;
		$('.counter').text(newcountNotif).show();
		$('title').text('(' + newcountNotif + ') ' + thetitle);
	});*/
</script>
<!--<div class="notif">Insert Notif</div>-->
<script src="<?php echo BASE_URL ?>js/notify/notiny.js"></script>
<link rel="stylesheet" href="<?php echo BASE_URL ?>js/notify/notiny.css">