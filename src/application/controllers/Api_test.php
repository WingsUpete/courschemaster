<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Api_test extends CI_Controller{

    public function __construct(){
        parent::__construct();
    }

    public function index(){
        
    }

    public function test_sidebar_data(){
        $sidebar = array(
            'g0' => array(
                array(
                    'name' => lang('my_courschema'),
                    'icon' => 'book',
                    'url'  => site_url('students'),
                    'mark' => PRIV_STUDENTS_MY_COURSCHEMA
                ),
                array(
                    'name' => lang('all_courschemas'),
                    'icon' => 'layer-group',
                    'url'  => site_url('students/all_courschemas'),
                    'mark' => PRIV_STUDENTS_ALL_COURSCHEMAS
                ),
                array(
                    'name' => lang('collection'),
                    'icon' => 'star',
                    'url'  => site_url('students/collection'),
                    'mark' => PRIV_STUDENTS_COLLECTION
                )
            ),
            'g1' => array(
                array(
                    'name' => lang('my_plan'),
                    'icon' => 'trophy',
                    'url'  => site_url('students/my_plan'),
                    'mark' => PRIV_STUDENTS_MY_PLAN
                )
            ),
            'g2' => array(
                array(
                    'name' => lang('learned'),
                    'icon' => 'graduation-cap',
                    'url'  =>  site_url('students/learned'),
                    'mark' => PRIV_STUDENTS_LEARNED
                )
            )
        );
        echo '$view = array(); <br />';
        echo '$view[\'sidebar\'] = xxxx; <br />';
        echo '<br />';
        echo 'frontend: <br /><br />';
        echo 'foreach($sidebar AS $group){<br />';
        echo '&nbsp;&nbsp;&nbsp;&nbsp;foreach($group AS $item){<br />';
        echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;foreach($item AS $k => $v){<br />';
        echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;echo $k . \' => \' . $v ;<br />';
        echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;}<br />';
        echo '&nbsp;&nbsp;&nbsp;&nbsp;}<br />';
        echo '&nbsp;&nbsp;&nbsp;&nbsp;echo \'------------------------ \';<br />';
        echo '}<br /><br />';
        echo 'result :<br /><br />';
        foreach($sidebar AS $group){
            foreach($group AS $item){
                foreach($item AS $k => $v){
                    echo $k . ' => ' . $v . '<br />';
                }
            }
            echo '------------------------ <br />';
        }
        

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