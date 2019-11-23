<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once APPPATH.'/third_party/paginatorv2.class.php';
class pagerv2 extends Paginator
{
    public function __construct()
    {
        parent::__construct();
    }

}
?>