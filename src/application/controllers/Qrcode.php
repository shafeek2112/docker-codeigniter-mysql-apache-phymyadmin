<?php
class Qrcode extends CI_Controller
{
    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
    }

    function index($id = "") {
       echo $id;
    }
}
?>