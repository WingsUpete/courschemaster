<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require("MatryonaLib/MatConstants.php");

const C_INCLUDE        = 'include';
const C_LB             = '(';
const C_RB             = ')';
const C_AND            = '&&';
const C_FEED           = ';';
const C_ASSIGN         = '=';
const C_VERSION        = 'version';
const C_OBJECTIVES     = 'objectives';
const C_PROGRAM_LENGTH = 'program_length';
const C_DEGREE         = 'degree';
const C_INTRO          = 'intro';


class Cminterpreter{
    /**
     * CodeIgniter Instance
     *
     * @var CodeIgniter
     */
    protected $CI;

    public function __construct(){
        $this->CI =& get_instance();
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

    

    public function compile_to_pdf($content){

    }

    public function complie_to_graph($command_arr){
        // INCLUDE
        
    }

    public function _get_basic_info($command_arr){
        $rtn = arrya();
        foreach($command_arr AS $command){
            $parts = explode(C_ASSIGN, $command);
            $left_part  = trim($parts[0]);
            $right_part = trim($parts[1]);

            if(strtolower($left_part) == C_INTRO 
            || strtolower($left_part) == C_OBJECTIVES
            || strtolower($left_part) == C_VERSION
            || strtolower($left_part) == C_PROGRAM_LENGTH
            || strtolower($left_part) == C_DEGREE)
            {
                $rtn[strtolower($left_part)] = $right_part;
            }
        }
        $rtn;
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
