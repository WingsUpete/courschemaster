<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Visitors extends CI_Controller{
    public function __contruct(){
        parent::__construct();

    }

    public function index(){
        $this->all_courschemas();
    }

    public function all_courschemas(){
        $this->load->view("general/header");
        $this->load->view("visitors/all_courschemas");
        $this->load->view("general/footer");
    }  
}

?>