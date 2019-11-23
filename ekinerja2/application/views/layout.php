<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>SIMPEG e-Kinerja Bogor</title>
    <!-- Metro core CSS -->
    <link href="<?php echo base_url('assets/metro4/css/metro-all.css'); ?>" rel="stylesheet">
    <style>
        .login-form {
            width: 350px;
            height: auto;
            top: 20%;
            /*margin-top: -160px;*/
        }
    </style>
</head>


<body class="h-vh-100 bg-brandColor2">
<?php //echo site_url(); ?>
<form class="login-form bg-white p-6 mx-auto border bd-default win-shadow"
      data-role="validator"
      action="<?php echo site_url('Login'); ?>"
      data-clear-invalid="2000"
      data-on-error-form="invalidForm"
      data-on-validate-form="validateForm" method="post">
    <img src="<?php echo base_url('assets/images/logokotabogor.gif'); ?>" alt="" width="62" height="80">
    <span class="mif-vpn-lock mif-4x place-right" style="margin-top: -10px;"></span>
    <h2 class="text-light"><a href="<?php echo base_url() ?>" style="text-decoration: none">Login e-Kinerja</a></h2> <span style="font-size: large;">SIMPEG Pemerintah Kota Bogor</span>
    <hr class="thin mt-4 mb-4 bg-white">
    <div class="form-group">
        <input id="txtUserName" name="txtUserName" type="text" data-role="input" data-prepend="<span class='mif-user'>" placeholder="Masukkan Username..." data-validate="required">
        <input id="idknjm" name="idknjm" type="hidden" value="<?php echo (isset($_GET['idknjm'])?$_GET['idknjm']:''); ?>">
    </div>
    <div class="form-group">
        <input id="txtPassword" name="txtPassword" type="password" data-role="input" data-prepend="<span class='mif-key'>" placeholder="Masukkan Password..." data-validate="required">
    </div>
    <div class="form-group mt-10">
        <button class="button secondary drop-shadow"><span class="mif-enter icon"></span>&nbsp;&nbsp;Masuk</button>
    </div>
    <?php $this->load->view($main_view); ?>
</form>

<script src="<?php echo base_url('assets/jquery/dist/jquery-3.3.1.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/metro4/js/metro.js'); ?>"></script>

<script>
    function invalidForm(){
        var form  = $(this);
        form.addClass("ani-ring");
        setTimeout(function(){
            form.removeClass("ani-ring");
        }, 1000);
    }

    function validateForm(){
        $(".login-form").animate({
            opacity: 0
        });
    }
</script>

</body>
</html>
