<?php

if(isset($_SESSION['id_pegawai']) ){
    header('location:index3.php');
    //print_r($_SESSION['id_pegawai']);
}

require_once "konek.php";
require_once("util.php");

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Sistem Informasi Kepegawaian Pemerintah Kota Bogor">
    <meta name="language" content="indonesia">
    <meta name="author" content="IT@BKPP Team">

    <title>::SIMPEG Kota Bogor</title>

    <link rel="shortcut icon" href="lib/img/pemkot_icon.jpg"/>
    <link href="assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/bootstrap/css/costums.css" rel="stylesheet">

    <!--[if lte IE 9]>
    <script src="//cdnjs.cloudflare.com/ajax/libs/html5shiv/3.6.2/html5shiv.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/respond.js/1.3.0/respond.js"></script>
    <![endif]-->


</head>

<body>
<div id="wrapper">

<div id="login-overlay" class="modal-dialog"  style="background-color:#ebd3f7">
    <div class="modal-content">
        <div class="modal-header" style="background-color: rgba(14,24,92,0.80)">
            <div class="container-fluid" style="color: white">
            <div class="row-fluid">
                <div class="col-md-1">
                    <img src='images/logobgr.png' width="50" height="50" style="margin-left: -10px;"/>
                </div>
                <div class="col-md-11">
                    <span class="text-right" id="myModalLabel" style="font-weight: bold; font-size: large">
                        <a href="index.php" style="text-decoration: none; color: white">SISTEM INFORMASI MANAJEMEN KEPEGAWAIAN</a></span><br>
                    <span style="font-weight: bold; font-size: medium; color: rgba(238,238,241,0.78)">
                    Pemerintah Kota Bogor
                    </span>
                </div>
            </div>
            </div>
        </div>
        <div class="modal-body" style="margin-bottom: -35px;">
            <div class="row">
                <div class="col-md-5">
                    <div class="well">
                        <form id="form1" name="form1" method="POST" action="cek.php" novalidate="novalidate">
                            <div class="form-group">
                                <label for="username" class="control-label">Username</label>
                                <input type="text" class="form-control" name="u" id="u" value="" required="" title="Silakan masukkan NIP baru anda" placeholder="Masukkan NIP">
                                <span class="help-block"></span>
                            </div>
                            <div class="form-group">
                                <label for="password" class="control-label">Password</label>
                                <input type="password" class="form-control" name="p" id="p" value="" required="" title="Silahkan masukkan password anda" placeholder="Masukkan Kata Sandi">
                                <span class="help-block"></span>
                            </div>
                            <?php
                            if(isset($_GET['login-error']) and $_GET['login-error']==true){
                                $login_err = 'Nama pengguna atau password salah';
                            }else{
                                $login_err = '';
                            }

                            ?>
                            <div id="loginErrorMsg" style="color: red; text-align: center">
                                <?php echo $login_err; ?>
                            </div>
                            <button type="submit" class="btn btn-success btn-block"><span class="glyphicon glyphicon-log-in"></span> Masuk</button>
                        </form>
                    </div>
                </div>
                <div class="col-md-7" style="height: 220px;margin-bottom: 3px;">
                    <!--<h4>SIMPEG Kota Bogor</h4>-->
                    <h5></h5>
                    <img src='assets/images/cepat_balaikota.jpg' height="100%" style="width: 110%; margin-left: -15px;"/>
                    <div id="Content">
                        <div class="boxed">
                            <div id="lipsum">

                            </div>
                            <div id="generated">

                            </div>
                        </div>

                        <div id="bannerL">
                            <div id="div-gpt-ad-1474537762122-2">

                            </div>
                        </div>
                        <div id="bannerR">
                            <div id="div-gpt-ad-1474537762122-3">

                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="modal-footer" style="background-color: rgba(14,24,92,0.80); color:rgba(238,238,241,0.78);">
            <p>&copy 2009 - <?php echo date('Y') ?>
                Badan Kepegawaian dan Pengembangan Sumber Daya Aparatur
            </p>
            <p style="font-size: smaller;">
                <span class="glyphicon glyphicon-tower "></span> Jl. Julang 1 No. 7A, Tanah Sareal, Kota Bogor<br>
                <span class="glyphicon glyphicon-phone-alt"></span> +62 251 8382027<br>
                <span class="glyphicon glyphicon-envelope "></span> bkpsda@kotabogor.go.id / simpeg.kotabogor@gmail.com<br>
                <span class="glyphicon glyphicon-globe "></span> http://bkpsda.kotabogor.go.id<br>
                <a href="https://twitter.com/bkppkotabogor" target="_blank"><span class="icomoon-icon-twitter "></span> @bkpsdakotabogor</a><br>
                <a href="https://fb.me/bkppkotabogor" target="_blank"><span class="icomoon-icon-facebook "></span> fb.me/BKPSDA Kota Bogor</a>
            </p>
        </div>
    </div>
</div>
</div>
</body>
<script src="js/jquery.min.js"></script>
<script src="js/jquery.validate.js"></script>
<script src="assets/bootstrap/js/bootstrap.js"></script>
<script language="javascript" src="js/jquery-ui-1.8.18.custom.min.js"></script>
<script src="assets/plugins/totop/easing.js" type="text/javascript"></script>
<script type="text/javascript" src="assets/plugins/totop/jquery.ui.totop.min.js"></script>
<script src="assets/chart/js/highcharts.js"></script>
<script src="assets/chart/js/highcharts-3d.js"></script>
<script src="assets/chart/js/modules/data.js"></script>
<script src="assets/chart/js/modules/exporting.js"></script>

<script>
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
        (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

    ga('create', 'UA-44687758-1', 'simpeg.kotabogor.go.id');
    ga('send', 'pageview');

</script>
<script type="text/javascript">
    $(window).bind('scroll', function() {
        if ($(window).scrollTop() > 50) {
            $('.navbar').addClass('navbar-fixed-top');
        }
        else {
            $('.navbar').removeClass('navbar-fixed-top');
        }
    });
    //$().UItoTop({ easingType: 'easeOutQuart' });
    $(document).ready(function(){
        $("#form1").validate({
            rules: {
                u: {
                    required: true,
                    /*digits : true,*/
                    minlength : 4,
                    maxlength : 18
                },
                p: {
                    required: true,
                    minlength: 3
                }
            },
            messages: {
                u: {
                    required: "NIP Harap di isi",
                    /*digits: "Format NIP salah",*/
                    minlength: "NIP salah",
                    maxlength: "NIP Salah"

                },
                p: {
                    required: "Harap di isi",
                    minlength: "Password kurang"
                }
            }
        });
    });

</script>

</html>
