<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en" style="height:100% "> <!--<![endif]-->

<!-- BEGIN HEAD-->
<head>
  <meta charset="UTF-8" />
  <title><?php echo $title ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
  <meta content="" name="description" />
  <meta content="" name="author" />
  <!--[if IE]>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <![endif]-->
  <!-- GLOBAL STYLES -->
  <!-- GLOBAL STYLES -->
<link href="//cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css" rel="stylesheet"/>
<link href="<?php echo base_url('assets/metro/css/metro-all.css?ver=@@b-version') ?>" rel="stylesheet">
<script src="<?php echo base_url('vendor/components/jquery/jquery.min.js'); ?>"></script>
<script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
</head>
<body >
  <div data-role="appbar" class="info">
    <a href="<?php echo site_url("Welcome") ?>" class="brand no-hover">
    SIPOHAN PINTER</a>
  </div>
  <br/><br/>
  <div data-role="navview" data-compact="md" data-expanded="lg" data-toggle="#pane-toggle" class="h-200">
      <?php $this->load->view('Layout/menu') ?>
      <div class="navview-content pl-4-md pr-4-md h-100" >
          <h1>
              <button id="pane-toggle" class="button square d-none-md"><span class="mif-menu" ></span></button>
              <?php
                if(isset($title)){
                  echo strtoupper($title);
                }else{
                  echo 'DASHBOARD';
                }
              ?>
          </h1>
          <hr class="bg-red">
          <div class="container-fluid h-100" style="min-height:1000px" >
            <!-- content -->
          <?php
            if(isset($konten)){
              $this->load->view($konten);
            }else{
              $this->load->view('blank');
            }
          ?>
            <div id="isi_kosong"></div>
            <!-- end content -->asdasdasd
            </div>
        </div>
    </div>



<script src="<?php echo base_url('assets/metro/js/metro.js') ?>"></script>

</body>
</html>
