<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Development extends CI_Controller{

    public function index(){
        if ( ! $this->_has_privileges('system_configs', PRVI_SYSTEM_CONFIGS, TRUE)){
            redirect('user/no_privileges');
        }
    }

    public function update(){
        try{
            if ( ! $this->_has_privileges('system_configs', PRVI_SYSTEM_CONFIGS, TRUE)){
                throw new Exception('You do not have the required privileges for this task!');
            }

            $this->load->library('migration');

            if ( ! $this->migration->current()){
                throw new Exception($this->migration->error_string());
            }

            $view = ['success' => TRUE];
        }catch (Exception $exc){
            $view = ['success' => FALSE, 'exception' => $exc->getMessage()];
        }

        $this->load->view('general/update', $view);
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
            ->get_where('cm_privileges', ['name' => $role])
            ->row_array();
            
        if ($role_priv[$page] < $priviledge){ // User does not have the permission to view the page.
            
            header('Location: ' . site_url('user/no_privileges'));
            
            return FALSE;
        }

        return TRUE;
    }
}

?>