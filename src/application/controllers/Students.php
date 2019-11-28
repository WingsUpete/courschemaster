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
        load_header_data($view);

        $this->load->view("general/header", $view);
        $this->load->view("students/sidebar", $view);
        $this->load->view("students/my_courschema", $view);
        $this->load->view("general/footer", $view);
    }

    public function all_courschemas(){

        if( ! $this->has_privileges('student', PRIV_STUDENTS)){
            return;
        }

        $view['active_sidebar'] = PRIV_STUDENTS_ALL_COURSCHEMAS;
        load_header_data($view);

        $this->load->view("general/header", $view);
        $this->load->view("students/sidebar", $view);
        $this->load->view("students/all_courschemas", $view);
        $this->load->view("general/footer", $view);
    }

    public function collection(){

        if( ! $this->has_privileges('student', PRIV_STUDENTS)){
            return;
        }

        $view['active_sidebar'] = PRIV_STUDENTS_COLLECTION;
        load_header_data($view);

        $this->load->view("general/header", $view);
        $this->load->view("students/sidebar", $view);
        $this->load->view("students/collection", $view);
        $this->load->view("general/footer", $view);
    }

    public function my_plan(){
        
        if( ! $this->has_privileges('student', PRIV_STUDENTS)){
            return;
        }

        $view['active_sidebar'] = PRIV_STUDENTS_MY_PLAN;
        load_header_data($view);

        $this->load->view("general/header", $view);
        $this->load->view("students/sidebar", $view);
        $this->load->view("students/my_plan", $view);
        $this->load->view("general/footer", $view);
    }

    public function learned(){

        if( ! $this->has_privileges('student', PRIV_STUDENTS)){
            return; 
        }

        $view['active_sidebar'] = PRIV_STUDENTS_LEARNED;
        load_header_data($view);

        $this->load->view("general/header", $view);
        $this->load->view("students/sidebar", $view);
        $this->load->view("students/learned", $view);
        $this->load->view("general/footer", $view);
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