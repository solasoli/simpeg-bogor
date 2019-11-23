<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once APPPATH.'/third_party/apc.caching.php';
class cache extends CacheAPC
{
    public function __construct()
    {
        parent::__construct();
    }

}
?>