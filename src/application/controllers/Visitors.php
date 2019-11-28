<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Visitors extends CI_Controller{
    public function __construct(){
        parent::__construct();
        $this->load->library('session');
    }

    public function index(){
        $this->all_courschemas();
    }

    public function all_courschemas(){

        $view = array();
        load_header_data($view);

        $this->load->view("general/header", $view);
        $this->load->view("visitors/all_courschemas");
        $this->load->view("general/footer");
    }
}

?>