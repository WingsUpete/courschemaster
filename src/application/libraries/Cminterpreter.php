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
                $content = array_merge($content, array($_item));
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
            $comment[] = $language == 'english' ? 'Choose courses according to your level in entrance events.' : '根据入学考试选择课程，详情见教工部官网';
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
            // $this->CI->courschemapdf->add_page();
            $this->CI->courschemapdf->append_raw_html('<h3>' . $table['title'] . '</h3>');
            if($table['content']){
                $this->CI->courschemapdf->append_table(
                    $table['header'], 
                    $table['content']
                );
            }
            foreach($table['comment'] AS $line){
                $this->CI->courschemapdf->append_raw_html('<h6>' . $line . '</h6>');
            }
            
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
                $basic_info[$lower_left_part] = str_replace('"','',$right_part);
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
            
            $parts = explode(C_ASSIGN, $command, 2);
            
            if(sizeof($parts) == 1){
                continue;
            }elseif(sizeof($parts) != 2){
                return array('status' => FALSE, 'msg' => 'Syntax error near ' . $command . '. Check files included.');
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
        $file_name = str_replace('"', '',$file_name);
        return $this->CI->db->select('
                cm_courschemas.source_code AS content
            ')
            ->from('cm_courschemas')
            ->where('cm_courschemas.name', $file_name)
            ->get()
            ->row_array()['content'];
    }

    public function compile_to_graph($content){
        $command_arr = $this->_files_to_command_arr('/', $content);
        return $this->_compile_to_graph($command_arr['msg']);
    }

	public function _compile_to_graph($command_arr)
	{
		/**
		 * test data area: start -------------------------------------------------------------------------------------------
		 */
//		$command_arr = array();
//		$command_arr[0] = ' NAME = "计算机科学与技术2018级 (1+3) 培养方案"';
//		$command_arr[1] = ' VERSION = 201801';
//		$command_arr[2] = ' INTRO = "计算机科学是一门极具发展潜力的专业，高级人才严重短缺。随着计算机技术和现代化企业的迅速发展， 这一现象将越来越严重。当前和未来一段时间，由于市场的集约化、渗透性、跨学科融合、技术创新、激烈竞争， 社会急需高素质的人才。"';
//		$command_arr[3] = ' OBJECTIVES = "本专业培养具有扎实的专业理论知识，掌握前沿计算机系统设计原理，具有相应的研究开发能力， 能熟练运用英语和计算机技术的人才。学生毕业后不仅可以在企业、科研机构、大学从事计算机科学与技术领域的研究、 开发、管理或教学，还可以继续从事计算机科学与技术及相关或交叉学科领域的研究生学习。"';
//		$command_arr[4] = ' PROGRAM_LENGTH = 4';
//		$command_arr[5] = ' DEGREE = "工程学学士"';
//		$command_arr[6] = ' Event GRADUATION = ComEvent(English_requirements && 专业先修课 && 通识必修课 && 通识选修课 && 专业基础课 && 专业核心课 && 专业选修课 && 实践课程)';
//		$command_arr[7] = ' Event 通识必修课 = ComEvent(理工通识基础 && 思想政治品德 && 军训体育 && 中文写作与交流)';
//		$command_arr[8] = ' Event 专业先修课 = ComEvent(其他先修课 && 数学基础)';
//		$command_arr[9] = ' Event 其他先修课 = CourseEvent(MA103A && PHY103B && PHY105B && CS102A && PHY104B)';
//		$command_arr[10] = ' Event 数学基础 = CourseEvent((MA101B && MA102B)||(MA101A && MA102A))';
//		$command_arr[11] = ' Event 理工通识基础 = ComEvent(其它理工通识基础 && 数学基础)';
//		$command_arr[12] = ' Event 其它理工通识基础 = CourseEvent(MA103A && PHY103B && PHY105B && CS102A && PHY104B)';
//		$command_arr[13] = ' Event 思想政治品德 = 思想政治品德课程';
//		$command_arr[14] = ' Event 军训体育 = 军训体育课程';
//		$command_arr[15] = ' Event 中文写作与交流 = CourseEvent(HUM012)';
//		$command_arr[16] = ' Event 通识选修课 = ComEvent(人文课程, 社科课程, 艺术课程)';
//		$command_arr[17] = ' Event 人文课程 = ScoreEvent("HUM", 4)';
//		$command_arr[18] = ' Event 社科课程 = ScoreEvent("SS" || "GE" || "GEJ" || "HEC", 4)';
//		$command_arr[19] = ' Event 艺术课程 = ScoreEvent("GEM" || "DHSSS", 2)';
//		$command_arr[20] = ' Event 专业基础课 = CourseEvent(CS203 && CS207 && CS201 && CS202 && CS208 && CS307 && MA212)';
//		$command_arr[21] = ' Event 专业核心课 = CourseEvent(CS301 && CS309 && CS321 && CS317 && CS302 && CS304 && CS326 && CS318 && CS413 && CS415 && CS470 && CS490)';
//		$command_arr[22] = ' Event 专业选修课 = ScoreEvent("CS_elective", 19)';
//		$command_arr[23] = ' Event 实践课程 = CourseEvent(CS470 && CS490)';
		/**
		 * test data area: end ---------------------------------------------------------------------------------------------
		 */

		$NAME = '';
		$EN_NAME = '';
		$GROUP = array();
		$VERSION = '';
		$PROGRAM_LENGTH = '';
		$INTRO = '';
		$EN_INTRO = '';
		$OBJECTIVES = '';
		$EN_OBJECTIVES = '';
		$DEGREE = '';
		$EN_DEGREE = '';

		$node_id_counter = 0;
		$node_list = array();
		$temp_list = array();

		$list = array();
		$status_list = array();
		$course_status = array();

		foreach ($command_arr as $command) {
			$command = trim($command);

			// NAME
			if (strcmp(substr($command, 0, 4), 'NAME') == 0) {
				$eq_pos = strpos($command, '=');
				$command = substr($command, $eq_pos + 1);
				$command = trim($command);
				$command = trim($command, '"');
				$NAME = $command;
				continue;
			}

			// EN_NAME
			if (strcmp(substr($command, 0, 7), 'EN_NAME') == 0) {
				$eq_pos = strpos($command, '=');
				$command = substr($command, $eq_pos + 1);
				$command = trim($command);
				$command = trim($command, '"');
				$EN_NAME = $command;
				continue;
			}

			// GROUP
			if (strcmp(substr($command, 0, 5), 'GROUP') == 0) {
				$eq_pos = strpos($command, '=');
				$command = substr($command, $eq_pos + 1);
				$command = trim($command);
				$command = trim($command, '"');
				$command = trim($command, '()');
				$command = explode('&&', $command);
				$GROUP[0] = trim($command[0]);
				$GROUP[1] = trim($command[0]);
				continue;
			}

			// VERSION
			if (strcmp(substr($command, 0, 7), 'VERSION') == 0) {
				$eq_pos = strpos($command, '=');
				$command = substr($command, $eq_pos + 1);
				$command = trim($command);
				$command = trim($command, '"');
				$VERSION = $command;
				continue;
			}

			// PROGRAM_LENGTH
			if (strcmp(substr($command, 0, 14), 'PROGRAM_LENGTH') == 0) {
				$eq_pos = strpos($command, '=');
				$command = substr($command, $eq_pos + 1);
				$command = trim($command);
				$command = trim($command, '"');
				$PROGRAM_LENGTH = $command;
				continue;
			}


			// INTRO
			if (strcmp(substr($command, 0, 5), 'INTRO') == 0) {
				$eq_pos = strpos($command, '=');
				$command = substr($command, $eq_pos + 1);
				$command = trim($command);
				$command = trim($command, '"');
				$INTRO = $command;
				continue;
			}

			// EN_INTRO
			if (strcmp(substr($command, 0, 8), 'EN_INTRO') == 0) {
				$eq_pos = strpos($command, '=');
				$command = substr($command, $eq_pos + 1);
				$command = trim($command);
				$command = trim($command, '"');
				$EN_INTRO = $command;
				continue;
			}

			// OBJECTIVES
			if (strcmp(substr($command, 0, 10), 'OBJECTIVES') == 0) {
				$eq_pos = strpos($command, '=');
				$command = substr($command, $eq_pos + 1);
				$command = trim($command);
				$command = trim($command, '"');
				$OBJECTIVES = $command;
				continue;
			}

			// EN_OBJECTIVES
			if (strcmp(substr($command, 0, 13), 'EN_OBJECTIVES') == 0) {
				$eq_pos = strpos($command, '=');
				$command = substr($command, $eq_pos + 1);
				$command = trim($command);
				$command = trim($command, '"');
				$EN_OBJECTIVES = $command;
				continue;
			}

			// DEGREE
			if (strcmp(substr($command, 0, 6), 'DEGREE') == 0) {
				$eq_pos = strpos($command, '=');
				$command = substr($command, $eq_pos + 1);
				$command = trim($command);
				$command = trim($command, '"');
				$DEGREE = $command;
				continue;
			}

			// EN_DEGREE
			if (strcmp(substr($command, 0, 9), 'EN_DEGREE') == 0) {
				$eq_pos = strpos($command, '=');
				$command = substr($command, $eq_pos + 1);
				$command = trim($command);
				$command = trim($command, '"');
				$EN_DEGREE = $command;
				continue;
			}

			// Event
			if (strcmp(substr($command, 0, 5), 'Event') == 0) {
				$node_id = $node_id_counter;
				$node_id_counter += 1;
				$command = trim(substr($command, 6));
				$eq_pos = strpos($command, '=');

				$node_name = substr($command, 0, $eq_pos);
				$node_name = trim($node_name);
				$node_value = substr($command, $eq_pos + 1);
				$node_value = trim($node_value);

				if (strcmp($node_name, 'GRADUATION') == 0) {
					$node_type = 2;
				} else {
					$node_type = 0;
				}

				$node = array(
					'node_id' => $node_id,
					'node_name' => $node_name,
					'node_type' => $node_type,
				);

				$node_list[$node_id] = $node;
				$temp_list[$node_id] = $node_value;

				continue;
			}
		}

		$description = array(
			'name' => $NAME,
			'en_name' => $EN_NAME,
			'group' => $GROUP,
			'version' => $VERSION,
			'program_length' => $PROGRAM_LENGTH,
			'intro' => $INTRO,
			'en_intro' => $EN_INTRO,
			'objectives' => $OBJECTIVES,
			'en_objectives' => $EN_OBJECTIVES,
			'degree' => $DEGREE,
			'en_degree' => $EN_DEGREE,
		);

		$list[] = $description;

		for ($i = 0; $i < sizeof($temp_list); $i++) {
			$value = $temp_list[$i];
			$left_pos = strpos($value, '(');
			$event_type = substr($value, 0, $left_pos);
			$event_type = trim($event_type);
			$value = substr($value, $left_pos);
			$value = trim($value);

			// ComEvent
			if (strcmp($event_type, 'ComEvent') == 0) {

				// &&
				if (strpos($value, '&&') != FALSE) {
					$value = trim($value, '()');
					$value = explode('&&', $value);

					$son_list = array();

					for ($j = 0; $j < sizeof($value); $j++) {
						$item = $value[$j];
						$item = trim($item);
						$k = 0;
						for (; $k < sizeof($temp_list); $k++) {
							if (strcmp($node_list[$k]['node_name'], $item) == 0) {
								break;
							}
						}
						if ($k < sizeof($temp_list)) {
							$son_list[] = array(
								'node_id' => $node_list[$k]['node_id'],
								'node_name' => $item,
							);
						}
					}

					$nest_node = array(
						'node_id' => $node_list[$i]['node_id'],
						'node_name' => $node_list[$i]['node_name'],
						'node_type' => $node_list[$i]['node_type'],
						'node_son' => $son_list,
					);

					if (!array_key_exists($nest_node['node_name'], $status_list)) {
						$list[] = $nest_node;
						$status_list[$nest_node['node_name']] = 1;
					}

					continue;
				}

				// ||
				if (strpos($value, '||') != FALSE) {
					$value = trim($value, '()');
					$value = explode('||', $value);

					$son_list = array();

					for ($j = 0; $j < sizeof($value); $j++) {
						$item = $value[$j];
						$item = trim($item);
						$k = 0;
						for (; $k < sizeof($temp_list); $k++) {
							if (strcmp($node_list[$k]['node_name'], $item) == 0) {
								break;
							}
						}
						$son_list[] = array(
							'node_id' => $node_list[$k]['node_id'],
							'node_name' => $item,
						);
					}

					$nest_node = array(
						'node_id' => $node_list[$i]['node_id'],
						'node_name' => $node_list[$i]['node_name'],
						'node_type' => $node_list[$i]['node_type'],
						'node_son' => $son_list,
					);

					if (!array_key_exists($nest_node['node_name'], $status_list)) {
						$list[] = $nest_node;
						$status_list[$nest_node['node_name']] = 1;
					}

					continue;
				}

			}

			// CourseEvent
			if (strcmp($event_type, 'CourseEvent') == 0) {
//			if (false){
				// without ||
				if (strpos($value, '||') == FALSE) {

					$value = trim($value, '()');
					$value = explode('&&', $value);

					$son_list = array();

					for ($j = 0; $j < sizeof($value); $j++) {
						$item = $value[$j];
						$item = trim($item);

						if (array_key_exists($item, $course_status)) {
							$k = 0;
							for (; $k < sizeof($node_list); $k++) {
								if (strcmp($node_list[$k]['node_name'], $item) == 0) {
									break;
								}
							}
							$son_list[] = array(
								'node_id' => $node_list[$k]['node_id'],
								'node_name' => $item,
							);
						} else {
							$node_id = $node_id_counter;
							$node_id_counter++;
							$node_name = $item;
							$node_type = 4;

							$node = array(
								'node_id' => $node_id,
								'node_name' => $node_name,
								'node_type' => $node_type,
							);

							$node_list[$node_id] = $node;
							$course_status[$item] = 1;

							$nest_node = array(
								'node_id' => $node_id,
								'node_name' => $node_name,
								'node_type' => $node_type
							);

							if (!array_key_exists($node_name, $status_list)) {
								$list[] = $nest_node;
								$status_list[$nest_node['node_name']] = 1;
							}

							$son_list[] = array(
								'node_id' => $node_id,
								'node_name' => $item,
							);
						}
					}

					$nest_node = array(
						'node_id' => $node_list[$i]['node_id'],
						'node_name' => $node_list[$i]['node_name'],
						'node_type' => $node_list[$i]['node_type'],
						'node_son' => $son_list,
					);

					if (!array_key_exists($nest_node['node_name'], $status_list)) {
						$list[] = $nest_node;
						$status_list[$nest_node['node_name']] = 1;
					}
					continue;

				}

				// with ||
//				if(strpos($value, '||') != FALSE){
				if (FALSE) {

					if (array_key_exists($node_list[$i]['node_name'], $status_list)) {
						continue;
					}

					$sp_temp = str_split($value);

					$para_temp = array();
					$pos_temp = array();
					$pos_temp_counter = 0;

					for ($j = 0; $j < sizeof($sp_temp); $j++) {
						if ($sp_temp == '(') {
							$pos_temp[$pos_temp_counter] = $j;
							$pos_temp_counter++;
						}
						if ($sp_temp == ')') {
							$pos_temp_counter--;
							$para_temp[$pos_temp[$pos_temp_counter]] = $j;
						}
					}

					$son_list = array();
					$flag = 1;

					$little_temp = array();

					for ($j = 1; $j < sizeof($sp_temp); $j++) {
						if ($sp_temp[$j] == '(') {
							echo '<br>';
//							print_r($j + 1);
//							echo '<br>';
//							print_r($para_temp[$j] - $j - 1);
//							echo '<br>';
							$little_name = substr($value,
								$j + 1,
								$para_temp[$j] - $j - 1);
							$little_name = trim($little_name);

							if (array_key_exists($little_name, $course_status)) {
								$k = 0;
								for (; $k < sizeof($node_list); $k++) {
									if (strcmp($node_list[$k]['node_name'], $little_name) == 0) {
										break;
									}
								}
								$son_list[] = array(
									'node_id' => $node_list[$k]['node_id'],
									'node_name' => $little_name,
								);
							} else {
								$little_id = $node_id_counter;
								$node_id_counter++;
								$little_type = 1;

								$node = array(
									'node_id' => $little_id,
									'node_name' => $little_name,
									'node_type' => $little_type,
								);

								$node_list[$little_id] = $node;
								$course_status[$little_name] = 1;

								$nest_node = array(
									'node_id' => $little_id,
									'node_name' => $little_name,
									'node_type' => $little_type
								);

								if (!array_key_exists($little_name, $status_list)) {
									$list[] = $nest_node;
									$status_list[$nest_node['node_name']] = 1;
								}

								$son_list[] = array(
									'node_id' => $little_id,
									'node_name' => $little_name,
								);

								// do something
								$little_temp[] = array(
									'id' => $little_id,
									'left' => $j,
								);
							}
							$j = $para_temp[$j];
							$flag = $j + 1;
						}

						if ($sp_temp[$j] == '&'
							or $sp_temp[$j] == ')') {
							if ($j - $flag < 5) {
								$j = $j + 1;
								$flag = $j + 2;
							} else {
								$little_name = substr($value, $flag, $j - $flag);
								$little_name = trim($little_name);

								if (array_key_exists($little_name, $course_status)) {
									$k = 0;
									for (; $k < sizeof($node_list); $k++) {
										if (strcmp($node_list[$k]['node_name'], $little_name) == 0) {
											break;
										}
									}
									$son_list[] = array(
										'node_id' => $node_list[$k]['node_id'],
										'node_name' => $little_name,
									);
								} else {
									$little_id = $node_id_counter;
									$node_id_counter++;
									$little_type = 3;

									$node = array(
										'node_id' => $little_id,
										'node_name' => $little_name,
										'node_type' => $little_type,
									);

									$node_list[$little_id] = $node;
									$course_status[$little_name] = 1;

									$nest_node = array(
										'node_id' => $little_id,
										'node_name' => $little_name,
										'node_type' => $little_type
									);

									if (!array_key_exists($little_name, $status_list)) {
										$list[] = $nest_node;
										$status_list[$nest_node['node_name']] = 1;
									}

									$son_list[] = array(
										'node_id' => $little_id,
										'node_name' => $little_name,
									);
								}
							}
						}


					}

					$nest_node = array(
						'node_id' => $node_list[$i]['node_id'],
						'node_name' => $node_list[$i]['node_name'],
						'node_type' => $node_list[$i]['node_type'],
						'node_son' => $son_list,
					);

					$list[] = $nest_node;
					$status_list[$nest_node['node_name']] = 1;


					$big_temp = array();
					foreach ($little_temp as $little_little_temp) {

						if (array_key_exists($node_list[$little_little_temp['id']]['node_name'], $status_list)) {
							continue;
						}

						$son_list = array();

						for ($j = $little_little_temp['left'] + 1;
							 $j <= $para_temp[$little_little_temp['left']];
							 $j++) {

							if ($sp_temp[$j] == '(') {
								$little_name = substr($value,
									$j + 1,
									$para_temp[$j] - $j - 1);
								$little_name = trim($little_name);

								if (array_key_exists($little_name, $course_status)) {
									$k = 0;
									for (; $k < sizeof($node_list); $k++) {
										if (strcmp($node_list[$k]['node_name'], $little_name) == 0) {
											break;
										}
									}
									$son_list[] = array(
										'node_id' => $node_list[$k]['node_id'],
										'node_name' => $little_name,
									);
								} else {
									$little_id = $node_id_counter;
									$node_id_counter++;
									$little_type = 0;

									$node = array(
										'node_id' => $little_id,
										'node_name' => $little_name,
										'node_type' => $little_type,
									);

									$node_list[$little_id] = $node;
									$course_status[$little_name] = 1;

									$nest_node = array(
										'node_id' => $little_id,
										'node_name' => $little_name,
										'node_type' => $little_type
									);

									if (!array_key_exists($little_name, $status_list)) {
										$list[] = $nest_node;
										$status_list[$nest_node['node_name']] = 1;
									}

									$son_list[] = array(
										'node_id' => $little_id,
										'node_name' => $little_name,
									);

									// do something
									$big_temp[] = array(
										'id' => $little_id,
										'left' => $j,
									);
								}
								$j = $para_temp[$j];
								$flag = $j + 1;
							}

							if ($sp_temp[$j] == '&'
								or $sp_temp[$j] == ')') {
								if ($j - $flag < 5) {
									$j = $j + 1;
									$flag = $j + 2;
								} else {
									$little_name = substr($value, $flag, $j - $flag);
									$little_name = trim($little_name);

									if (array_key_exists($little_name, $course_status)) {
										$k = 0;
										for (; $k < sizeof($node_list); $k++) {
											if (strcmp($node_list[$k]['node_name'], $little_name) == 0) {
												break;
											}
										}
										$son_list[] = array(
											'node_id' => $node_list[$k]['node_id'],
											'node_name' => $little_name,
										);
									} else {
										$little_id = $node_id_counter;
										$node_id_counter++;
										$little_type = 3;

										$node = array(
											'node_id' => $little_id,
											'node_name' => $little_name,
											'node_type' => $little_type,
										);

										$node_list[$little_id] = $node;
										$course_status[$little_name] = 1;

										$nest_node = array(
											'node_id' => $little_id,
											'node_name' => $little_name,
											'node_type' => $little_type
										);

										if (!array_key_exists($little_name, $status_list)) {
											$list[] = $nest_node;
											$status_list[$nest_node['node_name']] = 1;
										}

										$son_list[] = array(
											'node_id' => $little_id,
											'node_name' => $little_name,
										);
									}
								}
							}

						}

						$nest_node = array(
							'node_id' => $node_list[$little_little_temp['id']]['node_id'],
							'node_name' => $node_list[$little_little_temp['id']]['node_name'],
							'node_type' => $node_list[$little_little_temp['id']]['node_type'],
							'node_son' => $son_list,
						);

						$list[] = $nest_node;
						$status_list[$nest_node['node_name']] = 1;
					}

					foreach ($big_temp as $little_little_temp) {

						if (array_key_exists($node_list[$little_little_temp['id']]['node_name'], $status_list)) {
							continue;
						}

						$node_name = $node_list[$little_little_temp['id']]['node_name'];
						$son_list = array();

						$node_name = trim($node_name, '()');
						$node_name = trim($node_name);

						$sb_value = explode('&&', $node_name);

						for ($j = 0; $j < sizeof($sb_value); $j++) {
							$item = $sb_value[$j];
							$item = trim($item);

							if (array_key_exists($item, $course_status)) {
								$k = 0;
								for (; $k < sizeof($node_list); $k++) {
									if (strcmp($node_list[$k]['node_name'], $item) == 0) {
										break;
									}
								}
								$son_list[] = array(
									'node_id' => $node_list[$k]['node_id'],
									'node_name' => $item,
								);
							} else {
								$node_id = $node_id_counter;
								$node_id_counter++;
								$node_name = $item;
								$node_type = 3;

								$node = array(
									'node_id' => $node_id,
									'node_name' => $node_name,
									'node_type' => $node_type,
								);

								$node_list[$node_id] = $node;
								$course_status[$item] = 1;

								$nest_node = array(
									'node_id' => $little_id,
									'node_name' => $little_name,
									'node_type' => $little_type
								);

								if (!array_key_exists($little_name, $status_list)) {
									$list[] = $nest_node;
									$status_list[$nest_node['node_name']] = 1;
								}

								$son_list[] = array(
									'node_id' => $node_id,
									'node_name' => $item,
								);
							}
						}

						$nest_node = array(
							'node_id' => $node_list[$little_little_temp['id']]['node_id'],
							'node_name' => $node_list[$little_little_temp['id']]['node_name'],
							'node_type' => $node_list[$little_little_temp['id']]['node_type'],
							'node_son' => $son_list,
						);

						$list[] = $nest_node;
						$status_list[$nest_node['node_name']] = 1;
					}

					continue;
				}

			}

			// ScoreEvent
			if (strcmp($event_type, 'ScoreEvent') == 0) {
				$node_id = $node_id_counter;
				$node_id_counter++;

				$node_name = $value;
				$node_type = 3;

				$node = array(
					'node_id' => $node_id,
					'node_name' => $node_name,
					'node_type' => $node_type,
				);

				$son_list = array();
				$son_list[0] = array(
					'node_id' => $node_id,
					'node_name' => $node_name
				);

				$node_list[$node_id] = $node;

				$nest_node = array(
					'node_id' => $node_list[$i]['node_id'],
					'node_name' => $node_list[$i]['node_name'],
					'node_type' => $node_list[$i]['node_type'],
					'node_son' => $son_list,
				);

				if (!array_key_exists($nest_node['node_name'], $status_list)) {
					$list[] = $nest_node;
					$status_list[$nest_node['node_name']] = 1;
				}

				continue;
			}

			// VariableEvent
			if (strcmp($event_type, 'VariableEvent') == 0) {
				$value = trim($value, '()');
				$value = explode(',', $value);
				$value[0] = trim($value[0], '"');
				$value[1] = trim($value[1]);

				$son_list = array();

				// son 1
				$node_id = $node_id_counter;
				$node_id_counter++;
				$node_name = $value[0];
				$node_type = 3;

				$node = array(
					'node_id' => $node_id,
					'node_name' => $node_name,
					'node_type' => $node_type,
				);

				$son_list[0] = array(
					'node_id' => $node_id,
					'node_name' => $node_name
				);

				$node_list[$node_id] = $node;

				// son 2
				$j = 0;
				for (; $j < sizeof($temp_list); $j++) {
					if (strcmp($node_list[$j]['node_name'], $value[1]) == 0) {
						break;
					}
				}
				$son_list[1] = array(
					'node_id' => $node_list[$j]['node_id'],
					'node_name' => $value[1],
				);

				$nest_node = array(
					'node_id' => $node_list[$i]['node_id'],
					'node_name' => $node_list[$i]['node_name'],
					'node_type' => $node_list[$i]['node_type'],
					'node_son' => $son_list,
				);

				if (!array_key_exists($nest_node['node_name'], $status_list)) {
					$list[] = $nest_node;
					$status_list[$nest_node['node_name']] = 1;
				}

				continue;
			}

		}

		return json_encode($list);

	}
}
