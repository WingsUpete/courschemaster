<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require("MatryonaLib/MatConstants.php");

const C_INCLUDE        = 'include';
const C_LB             = '(';
const C_RB             = ')';
const C_AND            = '&&';
const C_OR             = '||';
const C_FEED           = ';';
const C_ASSIGN         = '=';

const C_VERSION        = 'version';
const C_OBJECTIVES     = 'objectives';
const C_PROGRAM_LENGTH = 'program_length';
const C_DEGREE         = 'degree';
const C_INTRO          = 'intro';
const C_EVENT          = 'event';
const C_NAME           = 'name';
CONST C_DEPARTMENT     = 'department';
const C_GROUP          = 'group';

const C_ComEvent       = 'ComEvent';
const C_CourseEvent    = 'CourseEvent';
const C_VariableEvent  = 'VariableEvent';
const C_ScoreEvent     = 'ScoreEvent';
const C_GRADUATION     = 'GRADUATION';

const C_COMMA          = ',';


class Cminterpreter{
    /**
     * CodeIgniter Instance
     *
     * @var CodeIgniter
     */
    protected $CI;

    public function __construct(){
        $this->CI =& get_instance();
        $this->CI->load->model('course_model');
    }

    public function verify_cmh($content){

        $msg = 'success';
        $status = TRUE;

        // If there is any INCLUDE in cmh
        if( ! (stripos($content, C_INCLUDE) === FALSE)){
            $statis = FALSE;
            $msg = 'INCLUDE is not allowed in cmh file.';
        }

        // Brackets number
        $num_l_b = substr_count($content, C_LB);
        $num_r_b = substr_count($content, C_RB);
        if($num_l_b != $num_r_b){
            $statis = FALSE;
            $msg = 'Brackets missing.';
        }

        // Operators
        
        return array('status' => $status, 'msg'=> $msg);
    }


    public function compile_to_pdf($language, $content){
        
        if($language == 'english'){
            $header = array('Course', 'Code', 'Department', 'Total Credit', 'Exp Credit', 'Weekly period', 'Semester', 'Prerequisite');
        }else{
            $header = array('课程', '代码', '开课院系', '学分', '实验学分', '周学时', '开课学期', '先修要求');
        }

        $command_arr = $this->_files_to_command_arr('/', $content);
        if( ! $command_arr['status']){
            return $command_arr;
        }else{
            $command_arr = $command_arr['msg'];
        }
        $process_arr = $this->_process_assign($command_arr);
        if( ! $process_arr['status']){
            return $process_arr;
        }

        if( ! $process_arr['status']){
            return $process_arr;
        }

        $basic_info = $process_arr['basic_info'];
        $events     = $process_arr['events'];

        if( ! isset($events[C_GRADUATION])){
            return array('status' => FALSE, 'msg' => 'Fatal error : Missing GRADUATION event.');
        }

        $second_events = array();
        
        // Parse GRADUATION event
        $r_type = $this->_get_event_type($events[C_GRADUATION]);
        if( ! $r_type['status']){
            return $r_type;
        }else{
            $r_type = $r_type['msg'];
        }

        if($r_type == C_ComEvent){
            $l_pos = strpos($events[C_GRADUATION], C_LB);
            $r_pos = strpos($events[C_GRADUATION], C_RB);
            $expression =  substr($events[C_GRADUATION], $l_pos + 1, $r_pos - $l_pos - 1);
            $arr = explode(C_AND, $expression);
            foreach($arr AS $_name){
                $name = trim($_name);
                if( ! isset($events[$name])){
                    return array('status' => FALSE, 'msg' => "Fatal error : Cannot find event \"$name\".");
                }
                $second_events[$name] = $events[$name];
            }
        }else{
            $second_events[C_GRADUATION] = $events[C_GRADUATION];
        }

        

        // Deal with second events
        $tables = array();
        foreach($second_events AS $name => $expression){
            $tmp_arr['title'] = $name;
            $tmp_arr['header'] = $header;
            $_table_r = $this->_expression_to_table($expression, $events, $language);
            if( ! $_table_r['status']){
                return $_table_r;
            }else{
                $_table = $_table_r['msg'];
            }
            $tmp_arr['content'] = $_table['content'];
            $tmp_arr['comment'] = $_table['comment'];
            $tables[] = $tmp_arr;
        }
        
        $file_name = $basic_info[C_NAME] . '.pdf';

        print_r($basic_info);
        echo '<br />';
        echo '<br />';
        echo '<br />';
        foreach($tables AS $row){
            print_r($row);
            echo '<br />';
            echo '<br />';
            echo '<br />';
            echo '<br />';
        }
        echo '<br />';

        $this->_to_pdf($language, PDF_PATH . $file_name, $basic_info, $tables);

        return array('status' => TRUE, 'pdf_url' => $file_name);
    }

    public function _expression_to_table($expression, &$events, $language){
        
        $content = array();
        $comment = array();
        
        $type_r = $this->_get_event_type($expression);
        if( ! $type_r['status']){
            return $type_r;
        }else{
            $type = $type_r['msg'];
        }

        $l_pos = strpos($expression, C_LB);
        $r_pos = strpos($expression, C_RB);
        $exp =  substr($expression, $l_pos + 1, $r_pos - $l_pos - 1);
        if($type == C_ComEvent){
            
            $arr = array();
            $_arr = explode(C_AND, $exp);
            foreach($_arr AS $name){
                $_tmp = explode(C_OR, $name);
                $arr = array_merge($arr, $_tmp);
            }

            foreach($arr AS $name){
                $name = trim($name);
                $_r = $this->_expression_to_table($events[$name], $events, $language);
                if( ! $_r['status']){
                    return $_r;
                }else{
                    $_r = $_r['msg'];
                }
                $content = array_merge($content, $_r['content']);
                $comment = array_merge($comment, $_r['comment']);
            }
        }elseif($type == C_CourseEvent){

            $arr = array();
            $exp = str_replace('(', ' ', $exp);
            $exp = str_replace(')', ' ', $exp);
            $_arr = explode(C_AND, $exp);
            foreach($_arr AS $name){
                $_tmp = explode(C_OR, $name);
                $arr = array_merge($arr, $_tmp);
            }

            foreach($arr AS $code){
                $code = trim($code);
                $result = $this->CI->course_model->query_course_by_code($code);
                if(!$result){
                    return array('status' => FALSE, 'msg' => 'Fatal Error near '. $expression . ': No such course: ' . $code . '.');
                }
                $_item[0] = $language == 'english' ? $result['course_en_name'] : $result['course_cn_name'];
                $_item[1] = $result['course_code'];
                $_item[2] = $language == 'english' ? $result['department_en_name'] : $result['department_cn_name'];
                $_item[3] = $result['total_credit'];
                $_item[4] = $result['exp_credit'];
                $_item[5] = $result['weekly_period'];
                $_item[6] = $result['semester'];
                $_item[7] = $result['pre_logic'];
                $content = array_merge($content, $_item);
            }

        }elseif($type == C_ScoreEvent){

            $parts = explode(C_COMMA, $exp);
            if(sizeof($parts) != 2){
                return array('status' => FALSE, 'msg' => 'Syntax error near ' . $expression);
            }
            if($language == 'english'){
                $comment[] = 'Total Credit of courses with label' . $parts[0] . ' must larger or equal than ' . $parts[1] . '.';
            }else{
                $comment[] = '带有' . $parts[0] . ' 标签的课程的学分总和至少为' . $parts[1] . '学分。';
            }
            
        }else{ // VariableEvent
            $comment[] = $expression;
        }

        return array(
            'status' => TRUE,
            'msg' => array('content' => $content, 'comment' => $comment)
        );
    }

    public function _to_pdf($language, $save_path, $basic_info, $tables){

        $this->CI->load->library('courschemapdf');
        $this->CI->courschemapdf->init($language);
        $this->CI->courschemapdf->add_page();
        $this->CI->courschemapdf->set_courschema_header($name=$basic_info[C_NAME], $department=$basic_info[C_DEPARTMENT], $version=$basic_info[C_VERSION]);
        $this->CI->courschemapdf->set_courschema_intro($basic_info[C_INTRO]);
        $this->CI->courschemapdf->set_courschema_objectives($basic_info[C_OBJECTIVES]);
        $this->CI->courschemapdf->set_courschema_program_length($basic_info[C_PROGRAM_LENGTH]);
        $this->CI->courschemapdf->set_courschema_degree($basic_info[C_DEGREE]);

        foreach($tables AS $table){
            $this->CI->courschemapdf->add_page();
            $this->CI->courschemapdf->append_raw_html('<h3>' . $table['title'] . '</h3>');
            $this->CI->courschemapdf->append_table(
                $table['header'], 
                $table['content']
            );
            $this->CI->courschemapdf->append_raw_html('<h6>' . $table['comment'] . '</h6>');
            $this->CI->courschemapdf->append_raw_html('<br /><br />');
        }

        $this->CI->courschemapdf->output($save_path);
    }

    public function _get_event_type($expression){
        if( ! (strpos($expression, C_ComEvent) === FALSE)){
            $msg = C_ComEvent;
        }elseif(( ! (strpos($expression, C_VariableEvent) === FALSE))){
            $msg = C_VariableEvent;
        }elseif(( ! (strpos($expression, C_CourseEvent) === FALSE))){
            $msg = C_CourseEvent;
        }elseif(( ! (strpos($expression, C_ScoreEvent) === FALSE))){
            $msg = C_ScoreEvent;
        }else{
            return array('status' => FALSE, 'msg' => 'Unknow event type. near '.$expression);
        }
        return array('status' => TRUE, 'msg' => $msg);
    }

    public function _process_assign($command_arr){
        $basic_info = array();
        $events = array();
        foreach($command_arr AS $command){
            if(stripos($command, C_ASSIGN) === FALSE){
                continue;
            }

            $parts = explode(C_ASSIGN, $command);
            $left_part  = trim($parts[0]);
            $right_part = trim($parts[1]);

            $lower_left_part = strtolower($left_part);

            if($lower_left_part == C_INTRO 
            || $lower_left_part == C_OBJECTIVES
            || $lower_left_part == C_VERSION
            || $lower_left_part == C_PROGRAM_LENGTH
            || $lower_left_part == C_DEGREE
            || $lower_left_part == C_NAME
            || $lower_left_part == C_GROUP
            || $lower_left_part == C_DEPARTMENT)
            {
                $basic_info[$lower_left_part] = $right_part;
            }else{
                if(stripos($lower_left_part, C_EVENT) === FALSE){
                    return array('status' => FALSE, 'msg' => 'Syntax error near ' . $command);
                }
                $_i = stripos($left_part, C_EVENT);
                $event_name = substr($left_part, strlen(C_EVENT));
                $events[trim($event_name)] = $right_part;
            }
        }

        return array(
            'status' => TRUE,
            'basic_info' => $basic_info,
            'events' => $events
        );
    }

    public function _files_to_command_arr($file_name, $content=NULL){

        if( ! $content){
            $content = $this->_get_cm_content($file_name);
            if( ! $content){
                return array(
                    'status' => FALSE,
                    'msg' => "No such file $file_name."
                );
            }
        }

        // variables
        $set = array();
        $command_arr = explode(C_FEED, $content);

        for($i = 0; $i < count($command_arr); $i++){
            $command = $command_arr[$i];

            // INCLUDE FILES
            
            $parts = explode(C_ASSIGN, $command);
            
            if(sizeof($parts) == 1){
                continue;
            }elseif(sizeof($parts) != 2){
                return array('status' => FALSE, 'msg' => 'Syntax error near ' . $command);
            }

            $left_part  = trim($parts[0]);
            
            if (strtolower($left_part) == C_INCLUDE){
                
                $right_part = trim($parts[1]);

                if( ! isset($set[$right_part])){ // It is ok to include.
                    $result = $this->_files_to_command_arr($right_part);
                    if($result['status'] == FALSE){ // If there is any error in this file?
                        return $result;
                    }else{
                        array_splice($command_arr, $i, 1, $result['msg']);
                        $set[$right_part] = TRUE;
                    }
                }else{ // repeated include, error
                    return array(
                        'status' => FALSE,
                        'msg' => "IncludeError: Repeated INCLUDE of \"$right_part\" "
                    );
                }
            }

            // ~ END OF INCLUDE FILES
        }
        return array('status' => TRUE, 'msg' => $command_arr);
    }    

    public function _get_cm_content($file_name){
        return $this->CI->db->select('
                cm_courschemas.source_code AS content
            ')
            ->from('cm_courschemas')
            ->where('cm_courschemas.name', $file_name)
            ->get()
            ->row_array()['content'];
    }
}
