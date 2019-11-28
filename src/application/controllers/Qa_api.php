<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Qa_api extends CI_Controller{
    public function __construct(){
        parent::__construct();

        if (strtoupper($_SERVER['REQUEST_METHOD']) !== 'POST')
        {
            $this->security->csrf_show_error();
        }
        
        $this->load->model('qa_model');
    }

    public function ajax_post_question(){
        try{
            // Get Input
            $labels           = json_decode($this->input->post('labels'));
            $title            = json_decode($this->input->post('title'));
            $description      = json_decode($this->input->post('description'));
            $user_id          = json_decode($this->input->post('user_id'));
            
            $autentication    = json_decode($this->input->post('autentication'));
            
            // Process data (logic part) data -> logic -> database
            $result = $this->qa_model->post_question($labels, $title, $description, $user_id,  $autentication);  
            
            // Send output back to the front-end 
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($result));

        }catch (Exception $exc){
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(['exceptions' => [exceptionToJavaScript($exc)]]));
        }
    }
}