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
        load_header_data($user_data);

        $this->load->view('general/BasicComponents/header', $user_data);
        $this->load->view('welcome/welcome_message');	
        $this->load->view('general/BasicComponents/footer');
    }

}
