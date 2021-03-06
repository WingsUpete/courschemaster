<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Api_test extends CI_Controller{

    public function __construct(){
        parent::__construct();
        $this->load->model('qa_model');
        $this->load->model('collections_model');
        $this->load->model('courschemas_model');
        $this->load->model('students_model');
        $this->load->model('review_model');
        $this->load->model('majors_model');
        $this->load->model('course_model');
        $this->load->library('session');
    }


    public function test__get_cm_content($file_name){
        $this->_get_cm_content('SUSTech_english_requirement');
    }

    public function index(){
        $this->test_interpreter();
    }

    public function test_query_course_by_code(){
        $result = $this->course_model->query_course_by_code('CS201');
        var_dump($result);
    }

    public function test_interpreter(){
        
        $content = '
        INCLUDE = "SUSTech_english_requirement";
        INCLUDE = "思想政治品德课程";
        INCLUDE = "军训体育课程";
        INCLUDE = "中文写作与交流";
        INCLUDE = "公选课";
        
        NAME = "计算机科学与技术2018级 (1+3) 培养方案";
        
        DEPARTMENT = "计算机科学与工程系";
        
        VERSION = 201801;
        
        GROUP = (2018 && CSE);
        
        INTRO = "计算机科学是一门极具发展潜力的专业，当前和未来一段时间，由于市场的技术创新与激烈竞争，社会急需高素质的计算机人才。";
        
        OBJECTIVES = "本专业培养具有扎实的专业理论知识，掌握前沿计算机系统设计原理，具有相应的研究开发能力的计算机技术人才。";
        
        PROGRAM_LENGTH = 4;
        
        DEGREE = "工程学学士";
        
        Event GRADUATION = ComEvent( English_requirements && 通识必修课 && 专业先修课 && 公选课 && 专业基础课 && 专业核心课 && 专业选修课 && 实践课程 );
        
        Event 通识必修课 = ComEvent( 理工通识基础 && 思想政治品德课程 && 军训体育课程 && 中文写作与交流 );
        
        Event 理工通识基础 = CourseEvent( MA103A && PHY103B && PHY105B && CS102A && PHY104B && (( MA101B && MA102B ) || ( MA101A && MA102A )));
        
        Event 专业先修课 = CourseEvent((( MA101B && MA102B ) || ( MA101A && MA102A )) && MA103A && PHY103B && PHY105B && CS102A && PHY104B );
        
        Event 专业基础课 = CourseEvent( CS203 && CS207 && CS201 && CS202 && CS208 && CS307 && MA212 );
        
        Event 专业核心课 = CourseEvent( CS301 && CS309 && CS321 && CS317 && CS302 && CS304 && CS326 && CS318 && CS413 && CS415 && CS470 && CS490 );
        
        Event 专业选修课 = ScoreEvent( "CS_elective", 19 );
        
        Event 实践课程 = CourseEvent(CS317 && CS322 && CS417 && CS470 && CS490 );
        
        
        
        ';

        

        $language = '简体中文';
        $this->load->library('Cminterpreter');
        $result = $this->cminterpreter->compile_to_pdf($language, $content);
        
        $result = $this->cminterpreter->compile_to_pdf($language, $content);

        if( ! $result['status']){
            echo $result['msg'];
        }else{
            echo $result['pdf_url'];
        }

        $result = $this->cminterpreter->compile_to_graph($content);
        print_r($result);

        
    }

    public function test_delete_cmh(){
        $cmh_name_list = array('');
        $this->courschemas_model->delete_cmh($cmh_name_list);
    }

    public function test_assign_courschema(){
        $user_id = 10;
        $courschem_id = 1;
        $result = $this->courschemas_model->assign_courschema($user_id, $courschem_id);
        echo $result ? 1 : 0;
    }

    public function test_get_visible_students_info(){
        $language = $this->session->userdata('user_id');
        $user_id = 1;
        $result = $this->students_model->get_visible_students_info($language, $user_id);
        foreach($result AS $row){
            foreach($row AS $k => $v){
                echo $k . ' ' . $v . '<br />';
            }
            echo '<br />';
        }
    }

    public function test_graph(){
        $this->load->view('test/graph');
    }

    public function test_review_reject(){
        $user_id = 1;
        $review_id = 1;
        $comment = 'Testing comment.';
        $result = $this->review_model->review_reject_courschema($user_id, $review_id, $comment);
        echo $result ? 1 : 0;
    }

    public function test_review_accept(){
        $user_id = 1;
        $review_id = 1;
        $comment = 'Testing comment.';
        $result = $this->review_model->review_accept_courschema($user_id, $review_id, $comment);
        echo $result ? 1 : 0;
    }

    public function test_upload_courschemas(){
        $user_id = 1;
        $target_files = array(
            'name' => array('upload_test10', 'upload_test11'),
            'tmp_name' => array('C:\\Users\\ASUS\\desktop\\计算机科学与技术2+2(2018).cmc', 'C:\\Users\\ASUS\\desktop\\test2.txt')
        );
        $data_pack = array(
            'maj' => 1,
            'upload_test10' => array(
                'ext' => 'cmc',
                'pdf' => 'nb',
                'list' => 'list nb',
                'graph' => 'graph nb'
            ),
            'upload_test11' => array(
                'ext' => 'cmh',
                'pdf' => 'nb',
                'list' => 'list nb',
                'graph' => 'graph nb'
            )
        );
        $language = '简体中文';
        $result = $this->courschemas_model->upload_courschemas($language, $user_id, $target_files, $data_pack);
        echo $result ? 1 : 0;
    }

    public function test_get_visible_majors(){
        $user_id = $this->session->userdata('user_id');
        $language = $this->session->userdata('language');

        $result = $this->majors_model->get_visible_majors($user_id, $language);
        foreach($result AS $row){
            foreach($row AS $k => $v){
                echo $k . ' ' . $v . '<br />';
            }
            echo '<br />';
        }
    }

    public function test_find_cmh(){
        $cmh_name_list = array('nb_courschema');
        $result = $this->courschemas_model->find_cmh($cmh_name_list);
        echo $result['status'] . '<br />';
        echo $result['query_result'];
        foreach($result['query_result'] AS $row){
            foreach($row AS $k => $v){
                echo $k . ' ' . $v . '<br />';
            }
            echo '<br />';
        }
    }

    public function test_get_tao_review_list(){
        $user_id = 1;
        $language = $this->session->userdata('language');
        $result = $this->review_model->get_tao_review_list($language, $user_id);
        foreach($result AS $row){
            foreach($row AS $k => $v){
                echo $k . ' ' . $v . '<br />';
            }
            echo '<br />';
        }
    }

    public function test_get_review_status(){
        $user_id = 1;
        $language = $this->session->userdata('language');
        $result = $this->review_model->get_review_status($language, $user_id);
        foreach($result AS $row){
            foreach($row AS $k => $v){
                echo $k . ' ' . $v . '<br />';
            }
            echo '<br />';
        }
    }

    public function test_get_visible_courschema(){
        $user_id = 1;
        $language = $this->session->userdata('language');
        $result = $this->courschemas_model->get_visible_courschema($language, $user_id);
        foreach($result AS $row){
            foreach($row AS $k => $v){
                echo $k . ' ' . $v . '<br />';
            }
            echo '<br />';
        }
    }

    public function test_get_courschema_matryona(){
        $courschema_id = 1;
        $result = $this->courschemas_model->get_courschema_matryona($courschema_id);
        foreach($result AS $k => $v){
            echo $k . '=>' . $v . '<br />';
        }
    }

    public function test_submit_courschema(){
        $user_id = 1;
        $pdf_json = 'test';
        $graph_json = 'test_json';
        $list_json = 'test_json';
        $courschema_name = 'test_courschema';
        $type = 'cmh';
        $major_id = 1;
        $source_code = 'Event GRADUATION = CourseEvent(CS101);';
        $result = $this->courschemas_model->submit_courschema($user_id, $pdf_json, $graph_json, $list_json, $courschema_name, $type, $major_id, $source_code);
        echo $result ? 1 : 0;
    }

    public function test_get_pdf_by_user_id(){
        $language = 'english';
        $user_id = $this->session->userdata('user_id');
        $result = $this->courschemas_model->get_pdf_by_user_id($language, $user_id);
        foreach($result AS $k => $v){
            echo $k . ' => ' . $v . '<br />';
        }
    }

    public function test_get_pdf_by_id(){
        $language = 'english';
        $courschema_id = 1;
        $result = $this->courschemas_model-> get_pdf_by_id($language, $courschema_id);
        foreach($result AS $k => $v){
            echo $k . ' => ' . $v . '<br />';
        }
    }

    public function test_get_my_learned(){
        $language = $this->session->userdata('language');
        $user_id  = 1;
        $result = $this->students_model->get_my_learned($language, $user_id);
        foreach($result AS $row){
            foreach($row AS $k => $v){
                echo $k . ' ' . $v . '<br />';
            }
            echo '<br />';
        }
    }

    public function test_get_my_collections(){
        $language = 'english';
        $user_id = 1;
        $result = $this->collections_model->get_my_collections($language, $user_id);
        foreach($result AS $row){
            foreach($row AS $k => $v){
                echo $k . ' ' . $v . '<br />';
            }
            echo '<br />';
        }
    }

    public function test_uncollect_courschema(){
        $courschema_id = 1;
        $user_id = 1;
        $result = $this->collections_model->uncollect_courschema($courschema_id, $user_id);
        echo $result ? 1 : 0;
    }

    public function test_collect_courschema(){
        $courschema_id = 1;
        $user_id = 1;
        $result = $this->collections_model->collect_courschema($courschema_id, $user_id);
        echo $result ? 1 : 0;
    }

    public function test_delete_reply(){
        $reply_id = 1;
        $user_id = 1;
        $result = $this->qa_model->delete_reply($user_id, $reply_id);
        echo $result ? 1 : 0;
    }

    public function test_post_reply(){
        $answer_id = 3;
        $sender_id = 1;
        $receiver_id = 1;
        $content = 'test content';
        $result = $this->qa_model->post_reply($answer_id, $sender_id, $receiver_id, $content);
        echo $result ? 1 : 0;
    }

    public function test_get_my_answers(){
        $user_id = 1;
        $result = $this->qa_model->get_my_answers($user_id);
        foreach($result AS $row){
            foreach($row AS $k => $v){
                echo $k . ' ' . $v . '<br />';
            }
            echo '<br />';
        }
    }

    public function test_get_my_questions(){
        $user_id = 1;
        $result = $this->qa_model->get_my_questions($user_id);
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

        $list_json = '';

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

    public function test_get_latest_questions(){
        $num_limit = 10;
        $result = $this->qa_model->get_latest_questions($num_limit);
        foreach($result AS $row){
            foreach($row AS $k => $v){
                echo $k .' => '. $v . '<br />';
            }
        }
    }

    public function test_get_faqs(){
        $result = $this->qa_model->get_faqs();
        foreach($result AS $row){
            foreach($row AS $k => $v){
                echo $k .' => '. $v . '<br />';
            }
        }
    }

    public function test_get_question_details(){
        $id = 4;
        $user_id = 1;
        $language = $this->session->userdata('language');
        $result =  $this->qa_model->get_question_details($user_id, $language, $id);

        echo 'info <br />';
        echo 'size:'.sizeof($result['info']).'<br />';

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
                if($k == 'replies'){
                    echo '<br />';
                    echo 'replies <br />';
                    foreach($v AS $rrow){
                        foreach($rrow AS $rk => $rv){
                            echo $rk . '=>' . $rv . '<br />';
                        }
                    }
                    
                }else{
                    echo $k .' => '. $v . '<br />';
                }
                
            }
        }
        echo '<br />';
    }

    public function test_get_question_brief(){
        $id_arr = array(3, 4, 5, 6);
        $result = $this->qa_model->get_question_brief($id_arr);
        foreach($result AS $row){
            foreach($row AS $k => $v){
                echo $k . ': ' . $v . '<br />';
            }
        }
    }

    public function test_delete_question(){
        $question_id = 3;
        $user_id = 1;
        $result = $this->qa_model->delete_question($question_id, $user_id);
        echo $result ? 1 : 0;
    }

    public function test_delete_answer(){
        $answer_id = 6;
        $user_id = 1;
        $result = $this->qa_model->delete_answer($answer_id, $user_id);
        echo $result ? 1 : 0;
    }

    public function test_search_questions(){
        $input = '熬夜';
        $result = $this->qa_model->search_questions($input);
        foreach($result AS $row){
            foreach($row AS $k => $v){
                echo $k . '=>' .$v . '<br />';
            }
            echo '<br />';
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