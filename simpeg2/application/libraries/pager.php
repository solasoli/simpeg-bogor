<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once APPPATH.'/third_party/paginator.class.php';
class pager extends Paginator
{
    public function __construct()
    {
        parent::__construct();
    }

}
?>