<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Tao extends CI_Controller{

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

    public function all_courschemas(){
        if( ! $this->has_privileges('mentor', PRIV_TAO)){
            return;
        }
        $view['ci'] = &$this;
        $view['active_sidebar'] = PRIV_TAO_ALL_COURSCHEMAS;
        $this->load_comb_views($view, "general/cmDisplay/all_courschemas");
    }

    public function collection(){
        if( ! $this->has_privileges('teaching_affairs_department', PRIV_TAO)){
            return;
        }
        $view['active_sidebar'] = PRIV_TAO_COLLECTION;
        $this->load_comb_views($view, "general/cmDisplay/collection");
    }

    public function student_info(){
        if( ! $this->has_privileges('teaching_affairs_department', PRIV_TAO)){
            return;
        }
        $view['active_sidebar'] = PRIV_TAO_STUDENT_INFO;
        $this->load_comb_views($view, "general/cmDisplay/student_info");
    }

    public function course_management(){
        if( ! $this->has_privileges('teaching_affairs_department', PRIV_TAO)){
            return;
        }
        $view['active_sidebar'] = PRIV_TAO_COURSE_MANAGEMENT;
        $this->load_comb_views($view, "general/cmManagement/course_management");
    }

    public function courschema_management(){
        if( ! $this->has_privileges('teaching_affairs_department', PRIV_TAO)){
            return;
        }
        $view['active_sidebar'] = PRIV_TAO_COURSCHEMA_MANAGEMENT;
        $this->load_comb_views($view, "general/cmManagement/courschema_management");
    }

    public function review(){
        if( ! $this->has_privileges('teaching_affairs_department', PRIV_TAO)){
            return;
        }
        $view['active_sidebar'] = PRIV_TAO_REVIEW;
        $this->load_comb_views($view, "general/cmManagement/review");
    }

    public function load_sidebar_data(&$view){
        $view['sidebar'] = array(
            'g0' => array(
                array(
                    'name' => lang('all_courschemas'),
                    'icon' => 'layer-group',
                    'url'  => site_url('tao/all_courschemas'),
                    'mark' => PRIV_TAO_ALL_COURSCHEMAS
                ),
                array(
                    'name' => lang('collection'),
                    'icon' => 'layer-group',
                    'url'  => site_url('tao/collection'),
                    'mark' => PRIV_TAO_COLLECTION
                )
            ),
            'g1' => array(
                array(
                    'name' => lang('student_info'),
                    'icon' => 'layer-group',
                    'url'  => site_url('tao/student_info'),
                    'mark' => PRIV_TAO_STUDENT_INFO
                )
            ),
            'g2' => array(
                array(
                    'name' => lang('course_management'),
                    'icon' => 'layer-group',
                    'url'  =>  site_url('tao/course_management'),
                    'mark' => PRIV_TAO_COURSE_MANAGEMENT
                ),
                array(
                    'name' => lang('courschema_management'),
                    'icon' => 'layer-group',
                    'url'  =>  site_url('tao/courschema_management'),
                    'mark' => PRIV_TAO_COURSCHEMA_MANAGEMENT
                ),
                array(
                    'name' => lang('review'),
                    'icon' => 'layer-group',
                    'url'  => site_url('tao/review'),
                    'mark' => PRIV_TAO_REVIEW
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