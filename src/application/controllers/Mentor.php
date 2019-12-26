<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Mentor extends CI_Controller{

    public function __construct(){
        parent::__construct();
        $this->load->library("session");

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

    public function all_courschemas($id=NULL){
        if( ! $this->has_privileges('mentor', PRIV_MENTOR)){
            return;
        }
        $this->load->helper('courschemas');
        get_redirect_info($id, $this->session->userdata('user_id'), $view);
        $view['active_sidebar'] = PRIV_MENTOR_ALL_COURSCHEMAS;
		$view['template_status'] = lang('current_courschema');
        $view['ci'] = &$this;
        $this->load_comb_views($view, "general/cmDisplay/all_courschemas");
    }

    public function collection(){
        if( ! $this->has_privileges('mentor', PRIV_MENTOR)){
            return;
        }
        $view['active_sidebar'] = PRIV_MENTOR_COLLECTION;
        $this->load_comb_views($view, "general/cmDisplay/collection");
    }

    public function student_info(){
        if( ! $this->has_privileges('mentor', PRIV_MENTOR)){
            return;
        }
        $view['active_sidebar'] = PRIV_MENTOR_STUDENT_INFO;
        $this->load_comb_views($view, "general/cmDisplay/student_info");
    }

    public function load_sidebar_data(&$view){
        $view['sidebar'] = array(
            'g0' => array(
                array(
                    'name' => lang('all_courschemas'),
                    'icon' => 'layer-group',
                    'url'  => site_url('all_courschemas'),
                    'mark' => PRIV_MENTOR_ALL_COURSCHEMAS
                ),
                array(
                    'name' => lang('collection'),
                    'icon' => 'star',
                    'url'  => site_url('mentor/collection'),
                    'mark' => PRIV_MENTOR_COLLECTION
                )
            ),
            'g1' => array(
                array(
                    'name' => lang('student_info'),
                    'icon' => 'graduation-cap',
                    'url'  => site_url('mentor/student_info'),
                    'mark' => PRIV_MENTOR_STUDENT_INFO
                )
            )
        );
    }

    protected function load_comb_views($view_data, $main_view){
        load_header_data($view_data);
		$this->load_sidebar_data($view_data);
        $this->load->view("general/BasicComponents/header", $view_data);
        $this->load->view("general/BasicComponents/sidebar", $view_data);
        $this->load->view($main_view, $view_data);
        $this->load->view("general/BasicComponents/footer", $view_data);
    }

    protected function has_privileges($page, $priviledge){
        // Check if user is logged in.
        $user_id = $this->session->userdata('user_id');
        if ($user_id == FALSE){
            $this->session->set_userdata('dest_url', 'mentor');
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
?>