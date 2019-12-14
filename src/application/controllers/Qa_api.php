<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Qa_api extends CI_Controller{
    public function __construct(){
        parent::__construct();

        if (strtoupper($_SERVER['REQUEST_METHOD']) !== 'POST')
        {
            $this->security->csrf_show_error();
        }

        $this->load->library('session');
        $this->load->model('qa_model');
    }

    // Basic interactive function : search question, post question, post answer, vote

    public function ajax_answer_can_be_deleted(){
        try{

            $answer_id = json_decode($this->input->post('answer_id'));
            $user_id   = $this->session->userdata('user_id');

            $result = $this->qa_model->answer_can_be_deleted($answer_id, $user_id);

            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($result ? AJAX_TRUE : AJAX_FALSE));

        }catch(Exception $exc){
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(['exceptions' => [exceptionToJavaScript($exc)]]));
        }
    }

    public function ajax_question_can_be_deleted(){
        try{

            $question_id = json_decode($this->input->post('question_id'));
            $user_id     = $this->session->userdata('');

            $result = $this->qa_model->question_can_be_deleted($question_id, $user_id);

            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($result ? AJAX_TRUE : AJAX_FALSE));

        }catch(Exception $exc){
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(['exceptions' => [exceptionToJavaScript($exc)]]));
        }
    }

    public function ajax_post_question(){
        try{

            $labels           = json_decode($this->input->post('labels'));
            $title            = json_decode($this->input->post('title'));
            $description      = json_decode($this->input->post('description'));
            $user_id          = $this->session->userdata('user_id');

            $result = AJAX_FALSE;

            if($user_id){
                $result = $this->qa_model->post_question($labels, $title, $description, $user_id); 
            }
            
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

            $question_id = json_decode($this->input->post('question_id'));
            $content     = json_decode($this->input->post('content'));
            $user_id     = $this->session->userdata('user_id');

            $result = AJAX_FALSE;

            if($user_id){
                $result = $this->qa_model->post_answer($question_id, $content, $user_id);
            }
            
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($result ?AJAX_SUCCESS : AJAX_FAIL));

        }catch(Exception $exc){
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(['exceptions' => [exceptionToJavaScript($exc)]]));
        }
    }

    public function ajax_post_reply(){
        try{
            $receiver_id = json_decode($this->input->post('receiver_id')); 
            $content     = json_decode($this->input->post('content'));;
            $answer_id   = json_decode($this->input->post('answer_id'));;
            $sender_id   = $this->session->userdata('user_id');
        
            if($sender_id){
                $result = post_reply($answer_id, $sender_id, $receiver_id, $content);
            }
            
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($result ?AJAX_SUCCESS : AJAX_FAIL));

        }catch(Exception $exc){
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(['exceptions' => [exceptionToJavaScript($exc)]]));
        }
    }

    public function ajax_is_already_voted(){
        try{

            $answer_id = json_decode($this->input->post('answer_id'));
            $user_id   = $this->session->userdata('user_id');

            $result = $this->qa_model->is_already_voted($answer_id, $user_id);

            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($result ? AJAX_TRUE : AJAX_FALSE));

        }catch(Exception $exc){
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(['exceptions' => [exceptionToJavaScript($exc)]]));
        }
    }

    public function ajax_vote_answer(){
        try{

            $answer_id = json_decode($this->input->post('answer_id'));
            $is_good   = json_decode($this->input->post('is_good'));
            $user_id   = $this->session->userdata('user_id');

            $result = AJAX_FALSE;

            if($user_id){
                $result = $this->qa_model->vote_answer($answer_id, $user_id, $is_good==1);
            }

            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($result ? AJAX_SUCCESS : AJAX_FAIL));

        }catch(Exception $exc){
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(['exceptions' => [exceptionToJavaScript($exc)]]));
        }
    }

    public function ajax_search_questions(){
        try{

            $input = json_decode($this->input->post('input'));

            $result = $this->qa_model->search_questions($input);

            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($result));

        }catch(Exception $exc){
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(['exceptions' => [exceptionToJavaScript($exc)]]));
        }
    }

    public function ajax_delete_answer(){
        try{

            $answer_id = json_decode($this->input->post('answer_id'));
            $user_id   = $this->session->userdata('user_id');


            $result = AJAX_FALSE;

            if($user_id){
                $result = $this->qa_model->delete_answer($answer_id, $user_id);
            }

            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($result ? AJAX_SUCCESS : AJAX_FAIL));

        }catch(Exception $exc){
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(['exceptions' => [exceptionToJavaScript($exc)]]));
        }
    }

    public function ajax_delete_question(){
        try{

            $question_id = json_decode($this->input->post('question_id'));
            $user_id     = $this->session->userdata('user_id');

            $result = AJAX_FALSE;

            if($user_id){
                $result = $this->qa_model->delete_question($question_id, $user_id);
            }

            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($result ? AJAX_SUCCESS : AJAX_FAIL));

        }catch(Exception $exc){
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(['exceptions' => [exceptionToJavaScript($exc)]]));
        }
    }

    public function ajax_delete_reply(){
        try{

            $reply_id = json_decode($this->input->post('reply_id'));
            $user_id     = $this->session->userdata('user_id');

            $result = AJAX_FALSE;

            if($user_id){
                $result = $this->qa_model->delete_reply($user_id, $reply_id);
            }

            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($result ? AJAX_SUCCESS : AJAX_FAIL));

        }catch(Exception $exc){
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(['exceptions' => [exceptionToJavaScript($exc)]]));
        }
    }

    // Basic view function

    public function ajax_get_question_brief(){
        try{

            $question_id_arr = json_decode($this->input->post('question_id_arr'));
            
            $result = $this->qa_model->get_question_brief($question_id_arr);
            
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($result));

        }catch(Exception $exc){
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(['exceptions' => [exceptionToJavaScript($exc)]]));
        }
    }

    public function ajax_get_question_details(){
        try{
            $question_id = json_decode($this->input->post('question_id'));
            $language = $this->session->userdata('language');
            $user_id = $this->session->userdata('user_id');

            $result = $this->qa_model->get_question_details($user_id, $language, $question_id);

            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($result));
            

        }catch(Exception $exc){
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(['exceptions' => [exceptionToJavaScript($exc)]]));
        }
    }

    public function ajax_get_all_labels(){
        try{

            $language = $this->session->userdata('language');

            $result = $this->qa_model->get_all_labels($language);

            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($result));

        }catch(Exception $exc){
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(['exceptions' => [exceptionToJavaScript($exc)]]));
        }
    }

    public function ajax_get_faqs(){
        try{

            $result = $this->qa_model->get_faqs();

            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($result));

        }catch(Exception $exc){
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(['exceptions' => [exceptionToJavaScript($exc)]]));
        }
    }

    public function ajax_get_latest_questions(){
        try{

            $num_limit = json_decode($this->input->post('num_limit'));

            $result = $this->qa_model->get_latest_questions($num_limit);

            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($result));

        }catch(Exception $exc){
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(['exceptions' => [exceptionToJavaScript($exc)]]));
        }
    }

    public function ajax_get_my_questions(){
        try{

            $user_id = $this->session->userdata('user_id');

            $result = $this->qa_model->get_my_questions($user_id);

            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($result));

        }catch(Exception $exc){
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(['exceptions' => [exceptionToJavaScript($exc)]]));
        }
    }

    public function ajax_get_my_answers(){
        try{

            $user_id = $this->session->userdata('user_id');

            $result = $this->qa_model->ajax_get_my_answers($user_id);

            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($result));

        }catch(Exception $exc){
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(['exceptions' => [exceptionToJavaScript($exc)]]));
        }
    }

    // Admin function


    public function ajax_admin_change_question_authen(){
        try{

            $question_id = json_decode($this->input->post('question_id'));
            $authentication = json_decode($this->input->post('authentication'));
            $user_id = $this->session->userdata('user_id');

            $result = AJAX_FALSE;

            if($user_id){
                $result = admin_change_question_authen($question_id, $authentication, $user_id);
            }
            
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($result ? AJAX_SUCCESS : AJAX_FAIL)); 

        }catch(Exception $exc){
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(['exceptions' => [exceptionToJavaScript($exc)]]));
        }
    }

    public function ajax_admin_change_answer_authen(){
        try{

            $answer_id = json_decode($this->input->post('answer_id'));
            $authentication = json_decode($this->input->post('authentication'));
            $user_id = $this->session->userdata('user_id');

            $result = AJAX_FALSE;

            if($user_id){
                $result = admin_change_answer_authen($answer_id, $authentication, $user_id);
            }
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($result ? AJAX_SUCCESS : AJAX_FAIL)); 

        }catch(Exception $exc){
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(['exceptions' => [exceptionToJavaScript($exc)]]));
        }
    }

    public function ajax_admin_change_faq_mark(){
        try{

            
            $question_id = json_decode($this->input->post('question_id'));
            $mark = json_decode($this->input->post('mark'));
            $user_id = $this->session->userdata('user_id');
            $result = AJAX_FALSE;

            if($user_id){
                $result = admin_change_faq_mark($question_id, $mark, $user_id);
            }
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