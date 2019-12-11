<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Qa extends CI_Controller{

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
        $this->main();
    }

    public function main(){
        // if( ! $this->has_privileges()){
        //     return; 
        // }
        $view_data = array();
        $this->load_comb_views($view_data, 'qa/main');
    }

    public function question(){
        // if( ! $this->has_privileges()){
        //     return; 
        // }
        $view_data = array();
        $this->load_comb_views($view_data, 'qa/question');
    }

    protected function load_comb_views($view_data, $main_view){
        load_header_data($view_data);
        $this->load->view("general/BasicComponents/header", $view_data);
        $this->load->view($main_view, $view_data);
        $this->load->view("general/BasicComponents/footer", $view_data);
    }

    protected function has_privileges(){
        // Check if user is logged in.
        $user_id = $this->session->userdata('user_id');
        if ($user_id == FALSE){
            header('Location: ' . site_url('user/login'));
            return FALSE;
        }
        return TRUE;
    }
}
?>