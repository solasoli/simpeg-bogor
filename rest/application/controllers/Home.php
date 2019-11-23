<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php
class Home extends CI_Controller
{
    public $layout;

    public function __construct()
    {
        parent::__construct();
        $this->layout = 'layout';
    }

    public $data = array(
        'main_view' => 'home'
    );

    public function index()
    {
        $this->load->view($this->layout, $this->data);
    }
}
?>

