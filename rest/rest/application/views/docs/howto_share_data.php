<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

<div class="container-fluid">
    <h4>Berbagi Data dan Informasi SIMPEG</h4>
    <div class="row">
        <div class="col-sm-12">
            <p>Layanan berbagi data SIMPEG menggunakan konsep implementasi <strong>Web Service</strong> Rest API. Aplikasi dokumentasi ini digunakan untuk mengelola data atau informasi yang berkaitan dengan kelas dan methode-methode yang dibuat untuk dipakai pada aplikasi-aplikasi yang membutuhkan konsumsi data kepegawaian dari database SIMPEG Kota Bogor.</p>
            <p>Cara memperoleh akses web service agar dapat diintegrasikan sebagai berikut :</p>
            <ul>
                <li>Mendaftarkan aplikasi pada RestAPI SIMPEG untuk memperoleh API Key. <a href="<?php echo base_url('Administrator/application_list') ?>">Klik disini</a></li>
                <li>Memberikan akses methode tertentu untuk aplikasi tersebut. <a href="<?php echo base_url('Administrator/methode_access_list') ?>">Klik disini</a></li>
                <li>
                    Format URL untuk mengakses data ada dalam dua bentuk :<br><br>
                    <strong>GET</strong> : <code>http://simpeg.kotabogor.go.id/rest/{entitas}/exec_running_methode/{ID Methode}/{API Key}/{param1}/{param2}</code> <br>
                    Contoh Keluaran :<br><br>
                    <img src="<?php echo base_url('assets/images/SS_API.png'); ?>"
                         style="width: 50%;border-radius: 8px; border: 1px solid grey;"><br>
                    <br><strong>POST</strong> : <code>http://simpeg.kotabogor.go.id/rest/{entitas}/exec_running_methode/{ID Methode}</code> <br>
                    &#8594; Parameter Form-encoded : key (required) = *********, param1 (optional) = xxxx, param2 (optional) = xxxx, param3 (optional) = xxxx <br>
                    Contoh Keluaran :<br><br>
                    <img src="<?php echo base_url('assets/images/SS_API2.png'); ?>"
                         style="width: 50%;border-radius: 8px; border: 1px solid grey;">
                </li>
            </ul>
        </div>
    </div>