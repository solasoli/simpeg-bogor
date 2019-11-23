<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="robots" content="noindex">

    <title>Administrator SIMPEG BKPSDA</title>
    <!-- Metro core CSS -->
    <!-- link href="<?php // echo base_url('../ekinerja2/assets/metro4/css/metro-all.css'); ?>" rel="stylesheet" -->
    <link rel="stylesheet" href="https://cdn.metroui.org.ua/v4/css/metro-all.min.css">
    <style>
        .login-form {
            width: 350px;
            height: auto;
            top: 20%;
            /*margin-top: -160px;*/
        }
    </style>
</head>


<body class="h-vh-100 bg-blue">

<form class="login-form bg-white p-6 mx-auto border bd-blue win-shadow"
      data-role="validator"
      action="<?php echo site_url('home/login'); ?>"
      data-clear-invalid="2000"
      data-on-error-form="invalidForm"
      data-on-validate-form="validateForm" method="post">
    <img src="<?php echo base_url('images/logokotabogor.gif'); ?>" alt="" width="50"  class="place-right">

    <!-- span class="mif-vpn-lock mif-4x place-right" ></span -->
    <h2 class="text-light"><a href="<?php echo base_url() ?>" style="text-decoration: none">Log in Administrator SIMPEG</a></h2>

    <div class="form-group">
        <input id="txtNip" name="txtNip" type="text" data-role="input" data-prepend="<span class='mif-user'>" placeholder="Masukkan Username..." data-validate="required">
    </div>
    <div class="form-group">
        <input id="txtPassword" name="txtPassword" type="password" data-role="input" data-prepend="<span class='mif-key'>" placeholder="Masukkan Password..." data-validate="required">
    </div>
    <div class="form-group mt-10">
        <button class="button success drop-shadow"><span class="mif-enter icon"></span>&nbsp;&nbsp;Masuk</button>
    </div>
    <hr class="thin mt-4 mb-4 bg-black">
    <div class="text-center">
      <p class="text-small">Powered by</p>
      <img src="<?php echo base_url('images/logo-bsre-1.png') ?>" width="100">
  </div>
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
