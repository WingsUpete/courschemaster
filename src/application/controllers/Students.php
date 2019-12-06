<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Students extends CI_Controller{

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
        $this->my_courschema();
    }

    public function my_courschema(){
        

        if( ! $this->has_privileges('student', PRIV_STUDENTS)){
            return;
        }

        $view['active_sidebar'] = PRIV_STUDENTS_MY_COURSCHEMA;
        $this->load_comb_views($view, "students/my_courschema" );

    }

    public function all_courschemas(){

        if( ! $this->has_privileges('student', PRIV_STUDENTS)){
            return;
        }

        $view['active_sidebar'] = PRIV_STUDENTS_ALL_COURSCHEMAS;
        $this->load_comb_views($view, "general/cmDisplay/all_courschemas");
    }

    public function collection(){

        if( ! $this->has_privileges('student', PRIV_STUDENTS)){
            return;
        }

        $view['active_sidebar'] = PRIV_STUDENTS_COLLECTION;
        $this->load_comb_views($view, "students/collection");
    }

    public function my_plan(){
        
        if( ! $this->has_privileges('student', PRIV_STUDENTS)){
            return;
        }

        $view['active_sidebar'] = PRIV_STUDENTS_MY_PLAN;
        $this->load_comb_views($view, "students/my_plan");
    }

    public function learned(){

        if( ! $this->has_privileges('student', PRIV_STUDENTS)){
            return; 
        }

        $view['active_sidebar'] = PRIV_STUDENTS_LEARNED;
        $this->load_comb_views($view, "students/learned");
    }

    protected function load_comb_views($view_data, $main_view){
        load_header_data($view_data);
		$this->load_sidebar_data($view_data);
        $this->load->view("general/header", $view_data);
        $this->load->view("general/sidebar", $view_data);
        $this->load->view($main_view, $view_data);
        $this->load->view("general/footer", $view_data);
    }

    public function load_sidebar_data(&$view){
        $view['sidebar'] = array(
            'g0' => array(
                array(
                    'name' => lang('my_courschema'),
                    'icon' => 'book',
                    'url'  => site_url('students'),
                    'mark' => PRIV_STUDENTS_MY_COURSCHEMA
                ),
                array(
                    'name' => lang('all_courschemas'),
                    'icon' => 'layer-group',
                    'url'  => site_url('students/all_courschemas'),
                    'mark' => PRIV_STUDENTS_ALL_COURSCHEMAS
                ),
                array(
                    'name' => lang('collection'),
                    'icon' => 'star',
                    'url'  => site_url('students/collection'),
                    'mark' => PRIV_STUDENTS_COLLECTION
                )
            ),
            'g1' => array(
                array(
                    'name' => lang('my_plan'),
                    'icon' => 'trophy',
                    'url'  => site_url('students/my_plan'),
                    'mark' => PRIV_STUDENTS_MY_PLAN
                )
            ),
            'g2' => array(
                array(
                    'name' => lang('learned'),
                    'icon' => 'graduation-cap',
                    'url'  =>  site_url('students/learned'),
                    'mark' => PRIV_STUDENTS_LEARNED
                )
            )
        );
    }

    protected function has_privileges($page, $priviledge){
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



?>