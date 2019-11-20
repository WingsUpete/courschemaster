<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Test extends CI_Controller{
    public function __construct(){
        parent::__construct();
    }

    public function index(){
        $this->load->library('session');
        echo $this->session->userdata('user_sid') . '<br />';
        echo $this->session->userdata('user_name') . '<br />';
        echo $this->session->userdata('user_email') . '<br />';

        $arr = array(
            'Command 0',
            'Command 1',
            'include 2',
            'Command 3'
        );
        $include_result = array(
            'Command A',
            'Command B'
        );
        for($i = 0; $i < 4; $i++){
            if($arr[$i] == 'include 2'){
                array_splice($arr, $i, 1, $include_result);
            }
        }
        foreach($arr AS $command){
            echo $command . '<br />';
        }
    }
}

?>