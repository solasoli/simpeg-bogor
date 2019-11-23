<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once APPPATH.'/third_party/UploadHandlerCuti.php';
class uploadhandlerer extends UploadHandler
{
    public function __construct()
    {
        parent::__construct();
    }

}
?>