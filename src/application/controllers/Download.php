<?php

class Download extends CI_Controller{

    public function __construct(){
        parent::__construct();
        $this->load->helper('download');
    }

    public function index(){
        echo 'WTF (Why This Face), mate. 1 param is required.';
    }

    public function pdf($url){
        // echo PDF_PATH . $url;
        force_download($url, file_get_contents(PDF_PATH . $url));
    }

    public function excel($url){
        force_download($url, file_get_contents(EXCEL_PATH. $url));
    }
}
?>