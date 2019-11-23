<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

    <meta name="author" content="Vicky Vitriandi">


    <link href="<?php echo base_url('assets/metro/css/metro-all.css?ver=@@b-version') ?>" rel="stylesheet">

    <title>SIPOHAN PINTER</title>

    <style>
        .login-form {
            width: 350px;
            height: auto;
            top: 50%;
            margin-top: -160px;
        }
    </style>
</head>
<body class="h-vh-100 bg-brandColor2" id="bodi">

    <form class="login-form bg-white p-6 mx-auto border bd-default win-shadow"
          data-role="validator"
          action="javascript:"
          data-clear-invalid="2000"
          data-on-error-form="invalidForm"
          data-on-validate-form="validateForm"
          name="formLogin" id="formLogin">
        <span class="mif-vpn-lock mif-4x place-right" style="margin-top: -10px;"></span>
        <h2 class="text-light">Sipohan Pinter</h2>
        <hr class="thin mt-4 mb-4 bg-white">
        <div class="form-group">
            <input type="text" data-role="input" name="userx" id="userx" data-prepend="<span class='mif-user-secret'>" placeholder="NIP" data-validate="required minlength=18 number">
        </div>
        <div class="form-group">
            <input type="password" data-role="input" name="passx" id="passx" data-prepend="<span class='mif-key'>" placeholder="password" data-validate="required">
        </div>
        <div class="form-group mt-10">
            <button class="button info">LOGIN</button>

        </div>
    </form>

    <script src="<?php echo base_url('vendor/components/jquery/jquery.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/metro/js/metro.js') ?>"></script>
    <script>
        function invalidForm(){
            var form  = $(this);
            form.addClass("ani-ring");
            setTimeout(function(){
                form.removeClass("ani-ring");
            }, 1000);
        }

        function validateForm(){
          $.post("<?php echo base_url('Welcome/masuq')?>", $("#formLogin").serialize())
            .done(function(obj){
                //console.log(obj);
                data = JSON.parse(obj);
                if(data.status == 'SUCCESS'){
                  var activity = Metro.activity.open({
                      type: 'metro',
                      overlayColor: '#fff',
                      overlayAlpha: 1
                  });
                  window.location.href = "<?php echo site_url('Dashboard') ?>";

                  setTimeout(function(){
                      Metro.activity.close(activity);

                  }, 3000)


                }else{
                  Metro.infobox.create("<h4>PERINGATAN!</h4><p>Login Gagal, NIP atau password salah </p>", "alert");
                }
              });
        }
    </script>

</body>
</html>
