<?php defined('BASEPATH') OR exit('No direct script access allowed');

class All_courschemas_api extends CI_Controller{
    public function __construct(){
        parent::__construct();

        if (strtoupper($_SERVER['REQUEST_METHOD']) !== 'POST')
        {
            $this->security->csrf_show_error();
        }
        $this->load->library('session');
        $this->load->model('courschemas_model');
    }

    public function ajax_get_dep(){
        try{
            $language = $this->session->userdata('language');

            $result = $this->courschemas_model->get_dep($language);

            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($result));
        }catch(Exception $exc){
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(['exceptions' => [exceptionToJavaScript($exc)]]));
        }
    }

    public function ajax_get_maj(){
        try{

            $dep_id = json_decode($this->input->post('dep_id'));
            $language = $this->session->userdata('language');

            $result = $this->courschemas_model->get_maj($language, $dep_id);

            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($result)); 

        }catch(Exception $exc){
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(['exceptions' => [exceptionToJavaScript($exc)]]));
        }
    }

    public function ajax_get_cm(){
        try{

            $maj_id = json_decode($this->input->post('maj_id'));
            $user_id  = $this->session->userdata('user_id');
            $language = $this->session->userdata('language');

            $result = $this->courschemas_model->get_maj($language, $user_id, $maj_id);

            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($result)); 

        }catch(Exception $exc){
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(['exceptions' => [exceptionToJavaScript($exc)]]));
        }
    }

    public function ajax_get_courschema_matryona(){
        try{

            $courschema_id = json_decode($this->input->post('courschema_id'));

            $result = $this->courschemas_model->get_courschema_matryona($courschema_id);

            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($result)); 

        }catch(Exception $exc){
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(['exceptions' => [exceptionToJavaScript($exc)]]));
        } 
    }

    public function ajax_submit_courschema(){
        try{

            $user_id = $this->session->userdata('user_id');
            $pdf_json        = json_decode($this->input->post('pdf_json'));
            $graph_json      = json_decode($this->input->post('graph_json'));
            $list_json       = json_decode($this->input->post('list_json'));
            $courschema_name = json_decode($this->input->post('courschema_name'));
            $type            = json_decode($this->input->post('type'));
            $major_id        = json_decode($this->input->post('major_id'));
            $source_code     = json_decode($this->input->post('source_code'));

            $result = $this->courschemas_model->submit_courschema($user_id, $pdf_json, $graph_json, 
                                                                $list_json, $courschema_name, 
                                                                $type, $major_id, $source_code);

            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($result)); 

        }catch(Exception $exc){
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(['exceptions' => [exceptionToJavaScript($exc)]]));
        } 
    }

    public function ajax_get_visible_courschema(){
        try{

            $user_id  = $this->session->userdata('user_id');
            $language = $this->session->userdata('language');

            $result = $this->courschemas_model->get_visible_courschema($language, $user_id);

            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($result)); 

        }catch(Exception $exc){
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(['exceptions' => [exceptionToJavaScript($exc)]]));
        } 
    }
}