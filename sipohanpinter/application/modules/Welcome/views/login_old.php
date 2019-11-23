<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>E-Kinerja Kota Bogor</title>
    <!-- Bootstrap core CSS -->
    <link href="<?php echo base_url('vendor/twbs/bootstrap/dist/css/bootstrap.css'); ?>" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="<?php  echo base_url('assets/css/signin.css'); ?>" rel="stylesheet">
</head>

<body class="text-center">
    <div class="card-deck mb-3 text-center">
        <div class="card mb-4 box-shadow">
            <div class="card-header">
                <a class="h4 my-0 font-weight-normal" href="<?php echo base_url() ?>" style="text-decoration: none;">E-Kinerja Kota Bogor</a>
            </div>
            <div class="card-body">
                <form class="form-signin" method="post" action="<?php echo site_url('Welcome/masuq'); ?>">

                    <img class="mb-4" src="<?php  echo base_url('assets/images/logokotabogor.gif'); ?>" alt="" width="72" height="90">
                    <label for="userx" class="sr-only">NIP</label>
                    <input type="text" id="userx" name="userx" class="form-control" placeholder="NIP" required autofocus>
                    <label for="passx" class="sr-only">Password</label>
                    <input type="password" id="passx" name="passx" class="form-control" placeholder="Password" required>

                    <button id="btnMasuk" class="btn btn-primary btn-block" type="submit">Masuk</button>
                    <?php // $this->load->view($main_view); ?>
                    <p class="mt-5 mb-3 text-muted">Badan Kepegawaian dan Pengembangan Sumber Daya Aparatur Kota Bogor
                    <br>Copyright &copy; 2018
                    </p>
                </form>
            </div>
        </div>
    </div>
</body>
</html>

<script src="<?php echo base_url('vendor/components/jquery/jquery.min.js'); ?>"></script>
<script src="<?php echo base_url('vendor/twbs/bootstrap/dist/js/bootstrap.js'); ?>"></script>
<script>

</script>
