<?php require_once("class/pegawai.php");
$pegawai = new Pegawai ?>
<div class="entry">

    <div class="col-md-8 post">
        <div class="panel">
            <div class="panel-body">
                <h1>BERANDA</h1>
              <?php include "post.php"; ?>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="panel">
            <div class="panel-body ">
                <h2><?php echo $pegawai->get_total_pegawai() ?><br>
                    <small>PNS Kota Bogor</small>
                </h2>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="panel">
            <div class="panel-body">
                <span style="font-weight: bold; color: limegreen;font-size: medium;">PENGUMUMAN</span><br></br>
                <div>
              <a href="https://arsipsimpeg.kotabogor.go.id/simpeg/downloads/Absensi Sosialisasi.ppt" target="_blank">
              <span style="font-weight: bold; font-size: 15px;">Sosialisasi Absensi<span>
              </div><br>
                <div>
              <a href="https://arsipsimpeg.kotabogor.go.id/simpeg/downloads/Standar_Kompetensi_Manajerial_BKPP.zip" target="_blank">
				      <span style="font-weight: bold; font-size: 15px;">Standar Kompetensi Manajerial<span>
              </div><br>
              <div>
              <a href="https://arsipsimpeg.kotabogor.go.id/simpeg/downloads/Standar_Kompetensi_Manajerial_BKPP.zip" target="_blank">
              <span style="font-weight: bold; font-size: 15px;">Standar Kompetensi Teknis<span>
              </div><br>
              <div>
              <a href="https://arsipsimpeg.kotabogor.go.id/simpeg/downloads/Standar_Kompetensi_Manajerial_BKPP.zip" target="_blank">
              <span style="font-weight: bold; font-size: 15px;">Standar Kompetensi Sosiokurtural<span>
              </div><br>

                <!--div class="row default">
                    <a href="http://103.14.229.15/simpeg/downloads/PETA_JABATAN_DAN_LAMPIRAN_di_LINGKUNGAN_PEMERINTAH_KOTA_BOGOR.zip" target="_blank">
                        <strong>Peta Jabatan di Lingkungan Pemerintah Kota Bogor</strong></a>
                </div><br>
                <div class="row default">
                    <a href="http://103.14.229.15/simpeg/downloads/Standar_Kompetensi_Manajerial_BKPP.zip" target="_blank">
                        <strong>Standar Kompetensi Manajerial</strong></a>
                </div><br>
                <div class="row default">
                    <a href="./downloads/Standar Operasional Prosedur BKPSDA.zip" target="_blank">
                        <strong>Standar Operasional Prosedur BKPSDA</strong></a>
                </div><br>

                <div class="row default">
                    <a href="./downloads/Undangan_Sosialisasi_Roadmap_Kepegawaian.pdf" target="_blank">
                        <strong>Surat Undangan Sosialisasi Roadmap Kepegawaian</strong></a>
                </div><br>
                <div class="row default">
                    <a href="./downloads/kebutuhan pengembangan kompetensi.pdf" target="_blank">
                        <strong>Surat Kebutuhan Pengembangan Kompetensi</strong></a>
                </div><br>
                <div class="row default">
                    <a href="./downloads/Renstra_BKPSDA_Kota_Bogor_2015_2019.pdf" target="_blank">
                        <strong>Rencana Strategis BKPSDA Kota Bogor Thn. 2015 - 2019</strong></a>
                </div><br>
                <div class="row default">
                    <a href="./downloads/PERJANJIAN_KINERJA_2018.pdf" target="_blank">
                        <strong>Perjanjian Kinerja BKPSDA Kota Bogor Thn. 2018</strong></a>
                </div><br>
                <div class="row default">
                    <a href="./downloads/Kepwal_No_130_45_266_Tahun_2015.pdf" target="_blank">
                        <strong>Perwali Penetapan Indikator Kinerja Utama OPD di Lingkungan Pemerintah Kota Bogor Thn. 2015</strong></a>
                </div><br>
                <div class="row default">
                    <a href="./downloads/Perwali_Nomor_87_Tahun_2017_Tupoksi_BKPSDA.pdf" target="_blank">
                        <strong>Perwali Uraian Tugas dan Fungsi serta Tata Kerja Jabatan Struktural BKPSDA Thn. 2017</strong></a>
                </div><br>
                <div class="row default">
                    <a href="./downloads/Perwal_Bogor_No_34_th_2016_IKU.pdf" target="_blank">
                        <strong>Perwali Penetapan Indikator Kinerja Utama OPD di Lingkungan Pemerintah Kota Bogor Thn. 2016</strong></a>
                </div><br>
                <div class="row default">
                    <a href="./downloads/IKU.pdf" target="_blank">
                        <strong>Indikator Kinerja Utama BKPSDA</strong></a>
                </div><br>
                <div class="row default">
                    <a href="./downloads/Rencana_Aksi_2018.pdf" target="_blank">
                        <strong>Rencana Aksi Kinerja BKPSDA Thn. 2018</strong></a>
                </div><br>
                <div class="row default">
                    <a href="./downloads/LAKIP_BKPSDA_2017.doc" target="_blank">
                        <strong>Laporan Kinerja Instansi Pemerintah (LKIP) Thn. 2017</strong></a>
                </div><br>

                <div class="row default">
                    <strong>Undangan Konferensi Nasional Temu Jafung Perencana dan dan Temu Alumni Pusbindiklatren</strong>
                    <object data="<?php //echo BASE_URL ?>/downloads/CCF06092018.pdf" type="application/pdf" width="100%" height="390px" style="border: 1px solid #cdcfc7;" ></object>
                </div>
                <!--
              <div class="row default">
                  <a href="<?php //echo BASE_URL ?>file_preview.php?file=pengumuman_mei_juni_karisu.docx" target="_blank">
                      <span style="font-weight: bold; font-size: 16px; color: red;">
                          Penerbitan Karis, Karsu dan KARPEG Periode Mei - Juni 2018</span>
                  </a>
              </div><br>

              <div class="row default">
                  <a href="<?php //echo BASE_URL ?>file_preview.php?file=Pengumuman_April_Karis_Karsu_NIP.docx" target="_blank">
                      <span style="font-weight: bold; font-size: 16px; color: red;">
                          Penerbitan Karis, Karsu dan Konversi NIP Periode April 2018</span>
                  </a>
              </div><br>

              <div class="row default">
                  <a href="<?php //echo BASE_URL ?>file_preview.php?file=pengumuman_karisu_maret.docx" target="_blank">
                      <span style="font-weight: bold; font-size: 16px; color: red;">
                          Penerbitan Karis, Karsu dan Karpeg Periode Maret 2018</span>
                  </a>
              </div><br>-->
                <!--
			<div class="row default">
				<strong>Tawaran Beasiswa KOICA</strong>
				<object data="<?php //echo BASE_URL ?>/downloads/tawaran_beasiswa_KOICA.pdf" type="application/pdf" width="100%" height="390px" style="border: 1px solid #cdcfc7;" ></object>
			</div>

			<div class="row default">
				<strong>Tawaran Beasiswa KOMINFO</strong>
				<object data="<?php //echo BASE_URL ?>/downloads/tawaran_beasiswa_kominfo.pdf" type="application/pdf" width="100%" height="390px" style="border: 1px solid #cdcfc7;" ></object>
			</div>

			<div class="row default">
				<strong>Tawaran Beasiswa Pemerintah Australia</strong>
				<object data="<?php //echo BASE_URL ?>/downloads/tawaran_beasiswa_australia.pdf" type="application/pdf" width="100%" height="390px" style="border: 1px solid #cdcfc7;" ></object>
			</div>


			<a href="downloads/Hasil_eformasi_2017">
				<span style="font-weight: bold; font-size: 20px;">Hasil Input e-Formasi 2017<span>
			</a>
			<hr>>
                <a id="linkKuesioner" href="index3.php?x=spm.php">
				<span style="font-weight: bold; font-size: 20px;">Kuesioner Pelayanan Kepegawaian Aparatur<span>
                </a>

                <video width="100%" height="560" controls>
                    <source src="downloads/tutorial.mp4" type="video/mp4">
                    Your browser does not support the video tag.
                </video-->

                <div class="row default">
                </div>
                <span style="font-weight: bold; color: limegreen;font-size: medium;">Informasi</span> <br><br>
                Bagi rekan-rekan jika ada yang belum dapat menggunakan fitur absensi pada SIMPEG MOBILE.
                Berikut cara menggunakan absensi online secara mobile berbasis Smartphone Android.
                Panduan singkat: <br>
                <ol style="margin-left: -20px;">
                    <li>Tekan Menu Absensi </li>
                    <li>Tekan tombol bergambar icon "+" untuk melakukan absensi </li>
                    <li>Tunggu sampai menemukan koordinat lokasi unit kerja yang sesuai </li>
                    <li>Kemudian, tekan sekali lagi tombol bergambar icon "+". Jika berhasil maka data waktu absensi akan tercatat pada database server SIMPEG.</li>
                </ol>
                Untuk melakukan pengecekan sudah masuk atau belum, bisa diakses pada akun tim pengelola SIMPEG di OPD
                melalui menu Absensi - Rekapitulasi Waktu Kehadiran. <br> <br>

                Terima kasih

            </div>
        </div>
    </div>

</div>
