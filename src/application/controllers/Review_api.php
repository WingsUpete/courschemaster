<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Review_api extends CI_Controller{
    public function __construct(){
        parent::__construct();

        if (strtoupper($_SERVER['REQUEST_METHOD']) !== 'POST')
        {
            $this->security->csrf_show_error();
        }

        $this->load->library('session');
        $this->load->model('review_model');
        if( ! $this->session->userdata('language')){
            $this->session->set_userdata('language', Config::LANGUAGE);
        }
    }

    public function ajax_get_review_status(){
        try{

            $user_id   = $this->session->userdata('user_id');
            $language = $this->session->userdata('language');

            $result = $this->review_model->get_review_status($language, $user_id);

            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($result));

        }catch(Exception $exc){
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(['exceptions' => [exceptionToJavaScript($exc)]]));
        }
    }

    public function ajax_get_tao_review_list(){
        try{

            $user_id = $this->session->userdata('user_id');
            $language = $this->session->userdata('language');

            $result = $this->review_model->get_tao_review_list($language, $user_id);

            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($result));

        }catch(Exception $exc){
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(['exceptions' => [exceptionToJavaScript($exc)]]));
        }
    }

    public function ajax_review_reject_courschema(){
        try{

            $review_id = json_decode($this->input->post('review_id'));
            $comment   = json_deocde($this->input->post('comment'));

            $result = $this->review_model->review_reject_courschema($review_id, $comment);

            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($result ? AJAX_SUCCESS : AJAX_FAIL));

        }catch(Exception $exc){
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(['exceptions' => [exceptionToJavaScript($exc)]]));
        }
    }

    public function ajax_review_accept_courschema(){
        try{

            $review_id = json_decode($this->input->post('review_id'));
            $comment   = json_deocde($this->input->post('comment'));

            $result = $this->review_model->review_accept_courschema($review_id, $comment);

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