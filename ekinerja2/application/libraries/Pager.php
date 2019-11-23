<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
include APPPATH.'/third_party/paginator.class.php';
class Pager extends Paginator
{
    public function __construct()
    {
        parent::__construct();
    }

}
?>