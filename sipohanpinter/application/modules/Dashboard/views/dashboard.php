
<p>
  Selamat Datang <?php echo $this->session->userdata('nama'); ?>
</p>

<div data-role="carousel"
     data-height="21/9"

     data-cls-bullet="bullet-big"
     data-cls-bullet-on="bg-red drop-shadow"
     data-cls-slides="rounded"
     data-control-next="<span class='mif-chevron-right'></span>"
     data-control-prev="<span class='mif-chevron-left'></span>"
     data-auto-start="true"
     data-period="3000"
     data-duration="1000">
     <?php   for($x=1;$x<=25;$x++){ ?>
       <div class="slide" data-cover="<?php echo base_url('assets/upload/protap_hukdis/Slide'.$x.'.jpg') ?>"></div>

  <?php
      }
      ?>

    <div class="slide" data-cover="images/bg-2.jpg"></div>
    <div class="slide" data-cover="images/bg-3.jpg"></div>
    <div class="slide" data-cover="images/bg-4.jpg"></div>
</div>
