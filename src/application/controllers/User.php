<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * User Controller
 *
 * @package Controllers
 */
class User extends CI_Controller {

    /**
     * Class Constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->library('cas');

        // Set user's selected language.
        if ($this->session->userdata('language'))
        {
            $this->config->set_item('language', $this->session->userdata('language'));
            $this->lang->load('translations', $this->session->userdata('language'));
        }
        else
        {
            $this->lang->load('translations', $this->config->item('language')); // default
        }
    }

    /**
     * Default Method
     *
     * The default method will redirect the browser to the user/login URL.
     */
    public function index()
    {
        header('Location: ' . site_url('user/login'));
    }

    /**
     * Redirect to CAS page
     */
    public function login(){

        $this->load->model('cas_model');

        $this->cas->forceAuthentication();
        if (isset($_REQUEST['logout'])) {
            phpCAS::logout();
        }
        $user = $this->cas->getAttributes();
        
        if($user){
            $user_data = $this->cas_model->get_user_data($user);
            
            $this->session->set_userdata($user_data);
            if($this->session->userdata('dest_url')){
                header('Location: ' . $this->session->userdata('dest_url'));
            }else{
                header('Location: ' . site_url(''));
            }
        }
    }

    /**
     * Display the logout page.
     */
    public function logout(){

        $this->session->unset_userdata('user_id');
        $this->session->unset_userdata('user_email');
        $this->session->unset_userdata('user_sid');

        $view['base_url'] = $this->config->item('base_url');

        $this->cas->logout(site_url(''));

        $this->load->view('user/logout', $view);
    }

    /**
     * Display the "forgot password" page.
     */
    public function forgot_password()
    {
        $this->load->model('settings_model');
        $view['base_url'] = $this->config->item('base_url');
        $view['company_name'] = $this->settings_model->get_setting('company_name');
        $this->load->view('user/forgot_password', $view);
    }

    public function no_privileges(){
        $this->load->view('user/no_privileges', $view);
    }

    public function ajax_check_login()
    {
        try
        {
            if ( ! $this->input->post('username') || ! $this->input->post('password'))
            {
                throw new Exception('Invalid credentials given!');
            }

            $this->load->model('user_model');
            $user_data = $this->user_model->check_login($this->input->post('username'), $this->input->post('password'));

            if ($user_data)
            {
                $user_data['role_slug'] = 'admin';
                $user_data['user_id'] = $this->session->userdata('user_id');
                $user_data['user_sid'] = $this->session->userdata('user_sid');

                $this->session->set_userdata($user_data); // Save data on user's session.
                // user_id, user_email, role sulg, username
                $this->output
                    ->set_content_type('application/json')
                    ->set_output(json_encode(AJAX_SUCCESS));
            }
            else
            {
                $this->output
                    ->set_content_type('application/json')
                    ->set_output(json_encode(AJAX_FAILURE));
            }

        }
        catch (Exception $exc)
        {
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(['exceptions' => [exceptionToJavaScript($exc)]]));
        }
    }
}
