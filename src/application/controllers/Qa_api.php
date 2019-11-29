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

    // Basic interactive function : search question, post question, post answer, vote

    public function ajax_post_question(){
        try{
            // Get Input
            $labels           = json_decode($this->input->post('labels'));
            $title            = json_decode($this->input->post('title'));
            $description      = json_decode($this->input->post('description'));
            $user_id          = json_decode($this->input->post('user_id'));
            
            // Process data (logic part) data -> logic -> database
            $result = $this->qa_model->post_question($labels, $title, $description, $user_id);  
            
            // Send output back to the front-end 
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($result ? AJAX_SUCCESS : AJAX_FAIL));

        }catch (Exception $exc){
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(['exceptions' => [exceptionToJavaScript($exc)]]));
        }
    }

    public function ajax_post_answer(){
        try{

            

        }catch(Exception $exc){
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(['exceptions' => [exceptionToJavaScript($exc)]]));
        }
    }

    public function ajax_vote_good_answer(){
        try{

            

        }catch(Exception $exc){
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(['exceptions' => [exceptionToJavaScript($exc)]]));
        }
    }

    public function ajax_vote_bad_answer(){
        try{

            

        }catch(Exception $exc){
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(['exceptions' => [exceptionToJavaScript($exc)]]));
        }
    }

    public function ajax_search_questions(){
        try{

            

        }catch(Exception $exc){
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(['exceptions' => [exceptionToJavaScript($exc)]]));
        }
    }

    public function ajax_delete_answer(){

    }

    public function ajax_delete_question(){

    }


    // Basic view function

    public function ajax_get_faqs(){

    }

    public function ajax_get_latest_question(){

    }

    public function ajax_get_question_details(){

    }

    // Admin function

    public function ajax_admin_delete_question(){

    }

    public function ajax_admin_delete_answer(){

    }

    public function ajax_admin_change_question_authen(){

    }

    public function ajax_admin_change_answer_authen(){

    }





    
    
}