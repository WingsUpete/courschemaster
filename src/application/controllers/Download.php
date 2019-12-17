<?php

class Download extends CI_Controller{

    public function __construct(){
        parent::__construct();
        $this->load->helper('download');
    }

    public function index(){
        echo '<h1>It\'s your lucky day</h1>https://www.bilibili.com/video/av53851218?from=search&seid=12257749514853350569';
    }

    public function pdf($url){
        force_download($url, file_get_contents(PDF_PATH . $url));
    }

    public function excel($url){
        force_download($url, file_get_contents(EXCEL_PATH. $url));
    }
}
?>