<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

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

        $user_data['base_url'] = $this->config->item('base_url');
        $this->load_basic_view_data($user_data);

        $this->load->view('general/header', $user_data);
        $this->load->view('welcome/welcome_message');	
        $this->load->view('general/footer');
    }

    protected function load_basic_view_data(&$view){
        $view['base_url'] = $this->config->item('base_url');

        if($this->session->userdata('user_sid')){
            $view['user_sid'] = $this->session->userdata('user_sid');
            $view['user_name'] = $this->session->userdata('user_name');
            $view['logged_in'] = 'true';
        }else{
            $view['logged_in'] = 'false';
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
