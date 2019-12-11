<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Visitors extends CI_Controller{
    public function __construct(){
        parent::__construct();
        $this->load->library('session');
		
        // Set user's selected language.
        if ($this->session->userdata('language')){
            $this->config->set_item('language', $this->session->userdata('language'));
            $this->lang->load('translations', $this->session->userdata('language'));
        }
        else{
            $this->lang->load('translations', $this->config->item('language')); // default
        }
    }

    public function index(){
        $this->all_courschemas();
    }

    public function all_courschemas(){

        $view = array();
        load_header_data($view);
        $view['ci'] = &$this;
        $this->load->view("general/BasicComponents/header", $view);
        $this->load->view("general/cmDisplay/all_courschemas", $view);
        $this->load->view("general/BasicComponents/footer", $view);
    }
}

?>