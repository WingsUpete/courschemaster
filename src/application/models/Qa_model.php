<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Qa_model extends CI_Model{
    
    public function _is_admin($user_id){

        $result = $this->db
        ->select('cm_privileges.name AS name')
        ->from('cm_users')
        ->join('cm_privileges', 'cm_privileges.id = cm_users.id_privileges', 'inner')
        ->where('cm_users.id', $user_id)
        ->get()->row_array()['name'];

        return $result == 'admin_8c6fc01';
    }

    public function _get_timestamp(){
        $timestamp_datetime = new DateTime('NOW');
        return $timestamp_datetime->format('Y-m-d H:i:s');
    }

    public function post_question($labels, $title, $description, $user_id){

        $autentication = $this->_is_admin($user_id) ? 1 : 0;

        $timestamp_datetime = new DateTime('NOW');
        $timestamp          = $timestamp_datetime->format('Y-m-d H:i:s');
        $default_view_cnt   = 0;

        // insert question
        $data_inserted = array(
            'title' => $title,
            'description' => $description,
            'id_users_questioner' => $user_id,
            'timestamp' => $timestamp,
            'authentication' => $autentication,
            'num_of_views' => $default_view_cnt
        );

        $insert_id = -1;

        $this->db->trans_begin();

        if($this->db->insert('qa_questions', $data_inserted)){
            $insert_id = $this->db->insert_id();
        }else{
            log_operation('qa/post_question', $user_id, $data_inserted, 'database fails on insert into questions');
            $this->db->trans_rollback();
            $this->db->trans_complete();
            return false;
        }

        // build relation between question and labels
        $is_ok = true;
        foreach($labels AS $label_id){
            $data = array(
                'id_questions' => $insert_id,
                'id_labels' => $label_id
            );
            if( ! $this->db->insert('qa_labels_questions', $data)){
                $is_ok = false;
                break;
            }
        }
        if( ! $is_ok){
            log_operation('qa/post_question', $user_id, $data_inserted, 'database fails on insert into labels_questions');
            $this->db->trans_rollback();
            $this->db->trans_complete();
            return false;
        }

        // Finished. 
        log_operation('qa/post_question', $user_id, $data_inserted, 'success');
        $this->db->trans_commit();
        $this->db->trans_complete();
        return true;
    }

    public function post_answer($question_id, $content, $user_id){
        $autentication = $this->_is_admin($user_id) ? 1 : 0;
        $data_inserted = array(
            'id_questions' => $question_id,
            'content' => $content,
            'id_users_provider' => $user_id,
            'timestamp' => $this->_get_timestamp(),
            'authentication' => $autentication,
            'vote' => 0
        );

        if( ! $this->db->insert('qa_answers', $data_inserted)){
            log_operation('qa/post_answer', $user_id, $data_inserted, 'fail');
            return false;
        }else{
            log_operation('qa/post_answer', $user_id, $data_inserted, 'success');
            return true;
        }
    }

    public function is_already_voted($answer_id, $user_id){
        $result = $this->db
            ->select('COUNT(*) AS cnt')
            ->from('qa_user_vote_answer')
            ->where('id_answers', $answer_id)
            ->where('id_users', $user_id)
            ->get()
            ->row_array()['cnt'];

        return $result == 1;
    }

    public function vote_answer($answer_id, $user_id, $is_good){
        if($this->is_already_voted($answer_id, $user_id)){
            return false;
        }

        $this->db->trans_begin();

        if($is_good){
            $this->db->set('vote', 'vote + 1', FALSE);
        }else{
            $this->db->set('vote', 'vote - 1', FALSE);
        }

        // change the vote number
        $this->db->where('id', $answer_id);
        if( ! $this->db->update('qa_answers')){
            $this->db->rollback();
            $this->db->trans_complete();
            return FALSE;
        }

        // update user vote answer to make sure every user can only vote once
        if( ! $this->db->insert('qa_user_vote_answer', array('id_answers' => $answer_id, 'id_users' => $user_id))){
            $this->db->rollback();
            $this->db->trans_complete();
            return FALSE;
        }

        $this->db->trans_commit();
        $this->db->trans_complete();
        return TRUE;
    }


    public function search_questions(){
        
    }

    public function delete_answer(){

    }

    public function delete_question(){

    }


    // Basic view function

    public function get_faqs(){

    }

    public function get_latest_question(){

    }

    public function get_question_details(){

    }

    // Admin function

    public function admin_delete_question(){

    }

    public function admin_delete_answer(){

    }

    public function admin_change_question_authen(){

    }

    public function admin_change_answer_authen(){

    }

}