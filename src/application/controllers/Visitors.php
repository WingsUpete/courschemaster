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
        $this->load_basic_view_data($view);

        $this->load->view("general/header", $view);
        $this->load->view("visitors/all_courschemas");
        $this->load->view("general/footer");
    }

    protected function load_basic_view_data(&$view){
        $view['base_url'] = $this->config->item('base_url');

        if($this->session->userdata('user_sid')){
            $view['user_sid'] = $this->session->userdata('user_sid');
            $view['user_name'] = $this->session->userdata('user_name');
        }else{
            $view['user_sid'] = ' ';
            $view['user_name'] = ' ';
        }
        // Set user's selected language.
        if ($this->session->userdata('language')){
            $view['language'] = $this->session->userdata('language');
        }
        else{
            $view['language'] = $this->config->item('language');
        }
    }
}

?>