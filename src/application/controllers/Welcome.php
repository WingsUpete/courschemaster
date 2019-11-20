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

        $this->load->view('general/header');
        $this->load->view('welcome/welcome_message', $user_data);	
        $this->load->view('general/footer');
    }

    protected function load_basic_view_data(&$view){
        $view['base_url'] = $this->config->item('base_url');
        $view['user_sid'] = $this->session->userdata('user_sid');
        $view['user_name'] = $this->session->userdata('user_name');
        // Set user's selected language.
        if ($this->session->userdata('language')){
            $view['language'] = $this->session->userdata('language');
        }
        else{
            $view['language'] = $this->config->item('language');
        }
    }
    
    protected function _has_privileges($page, $priviledge){
        // Check if user is logged in.
        $user_id = $this->session->userdata('user_id');
        if ($user_id == FALSE){
            
            header('Location: ' . site_url('user/login'));
            return FALSE;
        }

        // Check privilege
        $role_slug = $this->session->userdata('role');
        $role_priv = $this->db
            ->get_where('cm_privileges', ['name' => $role_slug])
            ->row_array();
            
        if ($role_priv[$page] < $priviledge){ // User does not have the permission to view the page.
            
            header('Location: ' . site_url('user/no_privileges'));
            
            return FALSE;
        }

        return TRUE;
    }
}
