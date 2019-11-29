<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Api_test extends CI_Controller{

    public function __construct(){
        parent::__construct();
    }

    public function index(){
        
    }

    public function test_log_operation(){
        $operation = 'test';
        $user_id = 1;
        $input_arr = array('id' => 1, 'op' => 'test op'); 
        $output_arr = array('status' => 'success');
        $result = log_operation($operation, $user_id, $input_arr, $output_arr) ? 1 : 0;
        echo $result;
    }

    public function test_post_question(){
        $this->load->model('qa_model');
        $labels = array(1, 2); 
        $title = '为什么我天天熬夜没假放，是不是培养方案出现了问题？'; 
        $description = 'rt'; 
        $user_id = 1;  
        $autentication = 0;
        $result = $this->qa_model->post_question($labels, $title, $description, $user_id,  $autentication);
        echo $result ? 1 : 0;
    }

    public function test_is_admin(){
        $this->load->model('qa_model');
        $result = $this->qa_model->_is_admin(1);
        echo $result ? 1 : 0;
    }

    public function test_post_answer(){
        $this->load->model('qa_model');
        $question_id = 1;
        $content = '这个问题其实没有多大意义，就算是改培养方案，也不会轮到你';
        $user_id = 1;
        $result = $this->qa_model->post_answer($question_id, $content, $user_id);
        echo $result ? 1 : 0;
    }

    public function test_is_already_voted(){
        $this->load->model('qa_model');
        $result = $this->qa_model->is_already_voted(1, 1);
        echo $result ? 1 : 0;
    }

    public function test_vote_answer(){
        $this->load->model('qa_model');
        $answer_id = 1; 
        $user_id = 1;
        $is_good = TRUE;
        $result = $this->qa_model->vote_answer($answer_id, $user_id, $is_good);
        echo $result ? 1 : 0;
    }

    
}

?>