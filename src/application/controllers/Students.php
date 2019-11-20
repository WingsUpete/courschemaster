<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Students extends CI_Controller{

    public function __construct(){
        parent::__construct();
    }

    public function index(){
        $this->my_courschema();
    }

    public function my_courschema(){
        $this->load->view("general/header");
        $this->load->view("students/sidebar");
        $this->load->view("students/my_courschema");
        $this->load->view("general/footer");
    }

    public function all_courschemas(){
        $this->load->view("general/header");
        $this->load->view("students/sidebar");
        $this->load->view("students/all_courschemas");
        $this->load->view("general/footer");
    }

    public function collection(){
        $this->load->view("general/header");
        $this->load->view("students/sidebar");
        $this->load->view("students/collection");
        $this->load->view("general/footer");
    }

    public function my_plan(){
        $this->load->view("general/header");
        $this->load->view("students/sidebar");
        $this->load->view("students/my_plan");
        $this->load->view("general/footer");
    }

    public function learned(){
        $this->load->view("general/header");
        $this->load->view("students/sidebar");
        $this->load->view("students/learned");
        $this->load->view("general/footer");
    }
}



?>