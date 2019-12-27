<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Courschemas_api extends CI_Controller{
    public function __construct(){
        parent::__construct();

        if (strtoupper($_SERVER['REQUEST_METHOD']) !== 'POST')
        {
            $this->security->csrf_show_error();
        }
		$this->load->library('session');
        $this->load->model('courschemas_model');
        if( ! $this->session->userdata('language')){
            $this->session->set_userdata('language', Config::LANGUAGE);
        }
    }

    public function ajax_upload_cmhfiles(){
        try{

            $target_files = $_FILES['target_files'];
            $user_id = $this->session->userdata('user_id');

            $result = $this->courschemas_model->upload_courschemas($user_id, $target_files);

            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($result ? array('status' => 'false') : array('status' => 'true')));

        }catch(Exception $exc){
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(['exceptions' => [exceptionToJavaScript($exc)]]));
        }
    }

    public function ajax_upload_courschemas(){
        try{

            $major_id = json_decode($this->input->post('major_id'));

            $target_files = $_FILES['target_files'];
            $user_id = $this->session->userdata('user_id');
        
            $language = $this->session->userdata('language');

            $result = $this->courschemas_model->upload_courschemas($language, $user_id, $target_files, $major_id);

            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($result));

        }catch(Exception $exc){
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(['exceptions' => [exceptionToJavaScript($exc)]]));
        }
    }

    public function ajax_compile_courschema(){
        try{

            $content = json_decode($this->input->post('content'));

            $this->load->library('cminterpreter');
            $result_json = $this->cminterpreter->compile_to_graph($content);

            $this->output
                ->set_content_type('application/json')
                ->set_output($result_json);

        }catch(Exception $exc){
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(['exceptions' => [exceptionToJavaScript($exc)]]));
        }
    }

    public function ajax_assign_courschema(){
        try{

            $courschem_id = json_decode($this->input->post('courschema_id'));
            $user_id = json_decode($this->input->post('user_id'));

            $result = $this->courschemas_model->assign_courschema($user_id, $courschem_id);

            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($result ? AJAX_SUCCESS : AJAX_FAIL));

        }catch(Exception $exc){
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(['exceptions' => [exceptionToJavaScript($exc)]]));
        }
    }
}