<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Signer extends CI_Controller {

    function __construct(){
      parent::__construct();
      $this->load->library('format');
      $this->load->model('signer_model','signer');
      $this->load->model('pegawai_model','pegawai');
      $this->load->model('jabatan_model','jabatan');
      $this->load->helper(array('form', 'url'));
    }

    function index(){

      $this->load->view('layout/header', array( 'title' => 'Digital Signer'));
      $this->load->view('signer/header_signer');
      $data['kat_berkas'] = $this->signer->get_kategori_berkas();

      if(!isset($this->session->userdata('user')->id_j) || $this->session->userdata('user')->id_j === "" ){
        $data['inbox'] = $this->signer->get_inbox_pengolah($this->session->userdata('user')->id_pegawai);
      }else{

        $data['inbox'] = $this->signer->get_inbox($this->session->userdata('user')->id_j);
      }


      $this->load->view('signer/inbox',$data);
      $this->load->view('signer/footer_signer',$data);
      $this->load->view('layout/footer');
    }

    function doc_baru(){
      $this->load->view('layout/header', array( 'title' => 'Digital Signer::Dokumen Baru'));
      $this->load->view('signer/header_signer');
      $data['kat_berkas'] = $this->signer->get_kategori_berkas();
      $data['penandatangan'] = $this->signer->get_penandatangan_berkas();
      $this->load->view('signer/doc_baru',$data);
      $this->load->view('layout/footer');
    }



    function upload_doc(){

        $data['idp_pengolah']       = $this->input->post('idp_pengolah');
        $data['id_kat_berkas']      = $this->input->post('kat_berkas');
        $data['uraian']             = $this->input->post('uraian');
        $data['nomor']              = $this->input->post('nomor');
        $data['tgl']                = $this->input->post('tanggal');

        if($this->input->post('pemaraf1')){
          $data['idj_pemaraf1']       = $this->input->post('pemaraf1');
        }

        if($this->input->post('pemaraf2')){
          $data['idj_pemaraf2']       = $this->input->post('pemaraf2');

        }

        if($this->input->post('pemaraf3')){
          $data['idj_pemaraf3']       = $this->input->post('pemaraf3');

        }

        if($this->input->post('pemaraf4')){
          $data['idj_pemaraf4']       = $this->input->post('pemaraf4');

        }

        if($this->input->post('penandatangan')){
          $data['idj_penandatangan']  = $this->input->post('penandatangan');

        }
        $data['status']             = 1;
        $data['history']            = "diupload pada tanggal : ".DATE('Y-m-d h:m:s')." _END";
        $doc_name                   =  $data['idp_pengolah']."_".$data['id_kat_berkas']."_".DATE('Ymdhms').rand(10,1000).".pdf";
        $data['filename']           = $doc_name;

        /*
        $config =  array(
                  'upload_path'     => "../simpeg/Berkas_dev/",
                  'allowed_types'   => "pdf",
                  'overwrite'       => TRUE,
                  'max_size'        => "20097152",
                  'file_name'       => $doc_name

                );

      $this->load->library('upload', $config);

      */


      $connection = ssh2_connect('103.14.229.15');

      ssh2_auth_password($connection, 'rommonz', 'mony3Tmony3T');
      $sftp = ssh2_sftp($connection);

      $uploaddir = '/var/www/html/simpeg2/berkas_tte/';
      $uploadfile = $uploaddir . $doc_name;
      //print_r($_FILES);exit;
      /* --- */
      if(ssh2_scp_send($connection, $_FILES["upload_dok"]['tmp_name'], $uploadfile, 0644))
      //if($this->upload->do_upload("upload_dok"))
      {

          //ssh2_sftp_rename($sftp, $uploadfile, $doc_name);

          if($this->db->insert('tte_inbox',$data)){
              $this->session->set_flashdata('s',"Berkas Tersimpan");
              redirect("signer");
          }else{
            $this->db->_error_message();
          }

      }
      else
      {
         echo "file upload failed "; //.$this->upload->display_errors();
      }

    }

    function paraf($id_doc,$kolom){


	  $sqlUpdateInbox = "update tte_inbox set idp_pemaraf".$kolom." = ".$this->session->userdata('user')->id_pegawai." where id = $id_doc";

    $this->db->query($sqlUpdateInbox);
		redirect('signer');

	}

  function cancel_paraf($id_doc, $kolom){
    $sqlUpdateInbox = "update tte_inbox set idp_pemaraf".$kolom." = NULL where id = $id_doc";
    $this->db->query($sqlUpdateInbox);
		redirect('signer');
  }

  function sign(){
    $curl = curl_init();
    $id_penandatangan = $this->session->userdata('user')->id_pegawai;
    $pin               = $this->input->post('pin');
    $id_tte           = $this->input->post('id_tte');

    $data = array('id_penandatangan' => $id_penandatangan, 'pin' => $pin, 'id_tte'=>$id_tte );

    $url = 'https://arsipsimpeg.kotabogor.go.id/simpeg2/signer/sign_API';

    curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_CONNECTTIMEOUT ,0);
    curl_setopt($curl, CURLOPT_TIMEOUT, 400);
    set_time_limit(0);

    try {
        $result = curl_exec($curl);

        if (curl_error($curl)) {
            $error_msg = curl_error($curl);
        }
        curl_close($curl);
        if (isset($error_msg)) {
            print_r($error_msg);
            die;
        }
        //$this->session->set_flashdata('s',"Tandatangan Berhasil");
        //redirect('signer');
        echo $result;
        //echo "bla...".$result;
        //echo "Berhasil";
    }catch(Exception $e) {
        echo 'Message: ' .$e->getMessage();
    }


  }

    function setting(){
      $this->load->view('layout/header', array( 'title' => 'Digital Signer::Setting'));

      $data['settings'] = $this->signer->get_setting($this->session->userdata('user')->id_pegawai);

      $this->load->view('signer/header_signer');
      //$this->load->view('signer/setting_menu');
      $this->load->view('signer/setting');


    }

    function upload_setting(){
      //upload sertifikat
      $a;
      $b;
      $data['id_pegawai'] = $this->session->userdata('user')->id_pegawai;

      /*
      $config_sertifikat =  array(
                'upload_path'     => "./assets/tte/sertifikat/",
                'allowed_types'   => "png|p12",
                'overwrite'       => TRUE,
                'max_size'        => "20097152",
                'file_name'       => $this->session->userdata('user')->id_pegawai.".p12"

              );
      */
      $connection = ssh2_connect('103.14.229.15');

      ssh2_auth_password($connection, 'rommonz', 'mony3Tmony3T');
      $sftp = ssh2_sftp($connection);

      //$uploaddir = '/var/www/html/simpeg2/assets/tte/sertifikat/';
      $uploaddir = '/var/www/html/simpeg2/application/cert/';
      $uploadfile = $uploaddir . $data['id_pegawai'].".p12";

      //$this->load->library('upload', $config_sertifikat);
      //if($a = $this->upload->do_upload("upload_sertifikat"))  {
      if(ssh2_scp_send($connection, $_FILES["upload_sertifikat"]['tmp_name'], $uploadfile, 0644)){
          $data['file_sertifikat'] = $data['id_pegawai'].".p12";

          if($this->db->insert('tte_setting',$data)){
            $this->session->set_flashdata('s',"Berkas Tersimpan");
            redirect("signer/setting");
          }else{
            $this->db->_error_message();
          }

      }else{
         echo "upload sertifikat failed ".$this->upload->display_errors();
      }

      /*
      $config_spesimen =  array(
                'upload_path'     => "./assets/tte/spesimen/",
                'allowed_types'   => "png",
                'overwrite'       => TRUE,
                'max_size'        => "20097152",
                'file_name'       => $this->session->userdata('user')->id_pegawai.".png"

              );

      $this->load->library('upload', $config_spesimen);
      if($b = $this->upload->do_upload("upload_spesimen"))  {
          $data['file_spesimen'] = $config_spesimen['file_name'];

      }else{
         echo "file upload spesimen failed ".$this->upload->display_errors();
      }
      */

      //insert setting
      // todo cek jika sudah ada data


    }

    public function signed(){
      /* yang sudah ditanda tangan */
      $this->load->view('layout/header', array( 'title' => 'Digital Signer'));
      $this->load->view('signer/header_signer');
      $data['kat_berkas'] = $this->signer->get_kategori_berkas();



      $data['inbox'] = $this->signer->get_signed($this->session->userdata('user')->id_j);


      $this->load->view('signer/inbox',$data);
      $this->load->view('signer/footer_signer',$data);
      $this->load->view('layout/footer');

    }

    function deleteberkas(){

        $id_tte = $this->input->post('id_tte');

        $connection = ssh2_connect('103.14.229.15','22');
        ssh2_auth_password($connection, 'rommonz', 'mony3Tmony3T');
        $sftp = ssh2_sftp($connection);

        $uploaddir = '/var/www/html/simpeg/Berkas_dev/';

        $filename = $this->signer->get_by_id($id_tte)->filename;

        $stream = ssh2_sftp_unlink($sftp, $uploaddir.$filename);
        if($stream){
          if($this->signer->delete_inbox($id_tte)){
            echo "SUCCESS";
          }else{
            echo "FAILED";
          }
        }
    }
}
