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

        if($this->session->user_id){
            $user_data['user_id'] = $this->session->user_id;
            $user_data['user_sid'] = $this->session->user_sid;
            $user_data['user_email'] = $this->session->user_email;
            $user_data['msg'] = 'go to '. '<a href = '.site_url('user/logout') . '>'. 'Logout' . '</a>';
        }else{
            $user_data['user_id'] = 'go to '. '<a href = '.site_url('user/login') . '>'. 'Login' . '</a>';
            $user_data['user_sid'] = 'You didn\'t login in.';
            $user_data['user_email'] = 'Courschematser-nb'; 
            $user_data['msg'] = 'test CAS';
        }
		$this->load->view('welcome_message', $user_data);
		
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
            ->get_where('cm_priviledges', ['name' => $role])
            ->row_array();
            
        if ($role_priv[$page] < $priviledge){ // User does not have the permission to view the page.
            
            header('Location: ' . site_url('user/no_privileges'));
            
            return FALSE;
        }

        return TRUE;
    }
}
