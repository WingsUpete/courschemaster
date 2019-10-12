<?php

class Installation extends CI_Controller{
    public function __construct(){
        parent::__construct();
        $this->load->helper('development');
        $this->load->database();
    }

    public function index(){
        if(check_installation_status()){
            $view['msg'] = 'The database is already installed.';
        }else{
            $view['msg'] = $this->install();
        }

        $this->load->view('general/installation', $view);
    }

    protected function install(){
        try{
            if (check_installation_status()){
                return;
            }

            $structure_sql = file_get_contents(dirname(BASEPATH) . '/assets/sql/structure.sql');
            $sql_statements_arr = explode(';', $structure_sql);

            // Delete the last element of the statements
            array_pop($sql_statements_arr);
            foreach ($sql_statements_arr as $statement){
                $this->db->query($statement);
            }

            return 'Successfully install database';

        }catch (Exception $exc){
            return $exc;
        }
    }
}

?>