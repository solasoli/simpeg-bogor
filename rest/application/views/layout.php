<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>SIMPEG REST API</title>
    <!-- Bootstrap core CSS -->
    <link href="<?php echo base_url('assets/bootstrap4/css/bootstrap.css'); ?>" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="<?php echo base_url('assets/build/signin.css'); ?>" rel="stylesheet">
</head>

<body class="text-center">
    <div class="card-deck mb-3 text-center">
        <div class="card mb-4 box-shadow">
            <div class="card-header">
                <a class="h4 my-0 font-weight-normal" href="<?php echo base_url() ?>" style="text-decoration: none;">SIMPEG Rest API</a>
            </div>
            <div class="card-body">
                <form class="form-signin" method="post" action="<?php echo site_url('login'); ?>">

                    <img class="mb-4" src="<?php echo base_url('assets/images/logokotabogor.gif'); ?>" alt="" width="72" height="90">
                    <label for="inputEmail" class="sr-only">Nama Pengguna</label>
                    <input type="text" id="txtUserName" name="txtUserName" class="form-control" placeholder="NIP" required autofocus>
                    <label for="inputPassword" class="sr-only">Password</label>
                    <input type="password" id="txtPassword" name="txtPassword" class="form-control" placeholder="Password" required>
                    <!--<div class="checkbox mb-3">
                        <label>
                            <input id="chkGuest" name="chkGuest" type="checkbox" value="guest"> Masuk sebagai Tamu
                        </label>
                    </div>-->
                    <button id="btnMasuk" class="btn btn-primary btn-block" type="submit">Masuk</button>
                    <?php $this->load->view($main_view); ?>
                    <p class="mt-5 mb-3 text-muted">Badan Kepegawaian dan Pengembangan Sumber Daya Aparatur Kota Bogor
                    <br>Copyright &copy; 2018-2019
                    </p>
                </form>
            </div>
        </div>
    </div>
</body>
</html>

<script src="<?php echo base_url('assets/jquery/dist/jquery-3.3.1.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/bootstrap4/js/bootstrap.js'); ?>"></script>
<script>
    $('#chkGuest').change(function() {
        if(this.checked) {
            $('#txtUserName').attr("readonly", true);
            $('#txtPassword').attr("readonly", true);
            $('#txtUserName').val('anonymous');
            $('#txtPassword').val('anonymous');
        }else{
            $('#txtUserName').attr("readonly", false);
            $('#txtPassword').attr("readonly", false);
            $('#txtUserName').val('');
            $('#txtPassword').val('');
        }
    });
</script>
