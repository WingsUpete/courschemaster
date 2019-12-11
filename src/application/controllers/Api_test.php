<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Api_test extends CI_Controller{

    public function __construct(){
        parent::__construct();
        $this->load->model('qa_model');
        $this->load->model('courschemas_model');
        $this->load->library('session');
    }

    public function index(){
        $this->test_get_my_questionIds();
    }

    public function test_get_my_questionIds(){
        $user_id = 1;
        $result = $this->qa_model->get_my_questionIds($user_id);
        foreach($result AS $row){
            foreach($row AS $k => $v){
                echo $k . ' ' . $v . '<br />';
            }
            echo '<br />';
        }
    }

    public function test_embedded_view(){
        $data = array();
        $data['ci'] = $this;
        $this->load->view('test/p1', $data);
    }

    public function test_get_pdf(){
        $courschema_id = 1;
        $result = $this->courschemas_model->get_pdf($courschema_id);
        echo asset_url('data/courschema_pdf/'.$result);
    }

    public function test_get_ccBasic(){
        $user_id = 1;
        $language = $this->session->userdata('language');
        $result = $this->courschemas_model->get_ccBasic($language, $user_id);
        foreach($result AS $k => $v){
            echo $k . ' ' . $v . '<br />';
        }
        echo '<br />';
    }

    public function test_get_all_labels(){
        $language = 'english';
        $result = $this->qa_model->get_all_labels($language);
        foreach($result AS $row){
            foreach($row AS $k => $v){
                echo $k . ' ' . $v . '<br />';
            }
            echo '<br />';
        }
    }

    public function test_get_cm(){
        $language = 'english';
        $user_id = 1;
        $maj_id = 1;
        $result = $this->courschemas_model->get_cm($language, $user_id, $maj_id);
        foreach($result AS $row){
            foreach($row AS $k => $v){
                echo $k . ' ' . $v . '<br />';
            }
            echo '<br />';
        }
    }

    public function test_get_maj(){
        $language = 'english'; 
        $dep_id = 1;
        $result = $this->courschemas_model->get_maj($language, $dep_id);
        foreach($result AS $row){
            foreach($row AS $k => $v){
                echo $k . ' ' . $v . '<br />';
            }
            echo '<br />';
        }
    }

    public function test_get_dep(){
        $result = $this->courschemas_model->get_dep('english');
        foreach($result AS $row){
            foreach($row AS $k => $v){
                echo $k . ' ' . $v . '<br />';
            }
            echo '<br />';
        }
    }

    public function test_pdf(){
        $this->load->library('courschemapdf');
        $this->courschemapdf->init('english');
        $this->courschemapdf->add_page();
        $this->courschemapdf->set_courschema_header($name="Courschema of Computer Science Major", $department="Department of Computer Science and Engineering", $version="2019120601");
        $this->courschemapdf->set_courschema_intro('
        Computer Science is as a great developing potential major, seeing an acute shortage 
        of advanced talents. With the rapid development of computer techonology and the modernization 
        enterprises, the phenomenon will become more and more serious. The society urgently needs 
        high-quality talents due to the intensive, permeability, interdisciplinary integration 
        , technology innovation, and the fierce competition in the market in current and future 
        period of time.
        ');

        $this->courschemapdf->set_courschema_objectives('
        This major is aiming at cultivating talents who possess firm professional theory knowledge, 
        mastering the frontier computer system design principle, corresponding research and exploitation 
        ability, and capable of utilizing English and computer technology. After graduation, students 
        can not only engage in research, exploitation, management, or teaching in computer science and 
        technology field in corporations, scientific research institutes, universities, but also continue 
        their postgraduate studies in Computer Science and Technology and related or interdisciplinary fields.
        ');

        $this->courschemapdf->set_courschema_program_length("Four years");

        $this->courschemapdf->set_courschema_degree('Bachelor of Engineering');

        $this->courschemapdf->append_raw_html('<h3>Compulsory Courses before Enrolled in CSE</h3>');
        $this->courschemapdf->append_table(
            array('coursche ID', 'name', 'prerequrestites'), 
            array(
                array('CS101', 'Introducation to CS', ' '),
                array('CS102', 'NB class', ' '),
                array('CS201', 'Fly a Jet fighter', 'CS101 & CS102'),
                array('CS202', 'Blow up F35C with RPG', 'CS301'),
                array('CS203', 'Digital Logic', 'CS506'),
                array('CS204', 'Computer Organization', ''),
                array('CS205', 'Discrete Mathematics', 'CS101 || (CS201 & CS302)'),
                array('CS206', 'Super NB class', 'CS909'),
                array('CS303A', 'Artificial Intelligence', ' '),
                array('CS309', 'OOAD', 'CS201')
            )
        );

        $this->courschemapdf->test_html();
    }

    public function test_admin_change_faq_mark(){
        $question_id = 3;
        $mark = 0;
        $user_id = 1;
        $result = $this->qa_model->admin_change_faq_mark($question_id, $mark, $user_id);
        echo $result ? 1 : 0;
    }

    public function test_admin_change_answer_authen(){
        $answer_id = 3;
        $authentication = 0;
        $user_id = 1;
        $result = $this->qa_model->admin_change_answer_authen($answer_id, $authentication, $user_id);
        echo $result ? 1 : 0;
    }

    public function test_admin_change_question_authen(){
        $question_id = 3;
        $authentication = 0;
        $user_id = 1;
        $result = $this->qa_model->admin_change_question_authen($question_id, $authentication, $user_id);
        echo $result ? 1 : 0;
    }

    public function test_latest_question_id(){
        $num_limit = 10;
        $result = $this->qa_model->get_latest_question_id($num_limit);
        foreach($result AS $row){
            echo $row['id'] . '<br />';
        }
    }

    public function test_get_faqs_id(){
        $result = $this->qa_model->get_faqs_id();
        foreach($result AS $row){
            echo $row['id'] . '<br />';
        }
    }

    public function test_get_question_details(){
        $id = 3;
        $result =  $this->qa_model->get_question_details($id);
        echo 'info <br />';
        foreach($result['info'] AS $k => $v){
            echo $k .' => '. $v . '<br />';
        }
        echo '<br />';
        echo 'labels <br />';
        foreach($result['labels'] AS $row){
            foreach($row AS $k => $v){
                echo $k .' => '. $v . '<br />';
            }
        }
        echo '<br />';
        echo 'answers <br />';
        foreach($result['answers'] AS $row){
            foreach($row AS $k => $v){
                echo $k .' => '. $v . '<br />';
            }
        }
        echo '<br />';
    }

    public function test_get_question_brief(){
        $id_arr = array(3, 4);
        $result = $this->qa_model->get_question_brief($id_arr);
        foreach($result AS $row){
            foreach($row AS $k => $v){
                echo $k . ': ' . $v . '<br />';
            }
        }
    }

    public function test_delete_question(){
        $question_id = 1;
        $user_id = 1;
        $result = $this->qa_model->delete_question($question_id, $user_id);
        echo $result ? 1 : 0;
    }

    public function test_delete_answer(){
        $answer_id = 1;
        $user_id = 1;
        $result = $this->qa_model->delete_answer($answer_id, $user_id);
        echo $result ? 1 : 0;
    }

    public function test_search_questions(){
        $input = 'CSE 培养方案';
        $result = $this->qa_model->search_questions($input);
        foreach($result AS $id){
            echo $id . '<br />';   
        }
    }

    public function test_question_can_be_deleted(){
        $question_id = 1;
        $user_id = 1;
        $result = $this->qa_model->question_can_be_deleted($question_id, $user_id);
        echo $result ? 1 : 0;
    }

    public function test_answer_can_be_deleted(){
        $answer_id = 1;
        $user_id = 1;
        $result = $this->qa_model->answer_can_be_deleted($answer_id, $user_id);
        echo $result ? 1 : 0;
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
        $question_id = 3;
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