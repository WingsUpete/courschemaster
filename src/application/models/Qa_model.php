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

    public function answer_can_be_deleted($answer_id, $user_id){
        if($this->_is_admin($user_id)){
            return TRUE;
        }

        $result = $this->db
            ->select('qa_answers.id_users_provider AS id')
            ->from('qa_answers')
            ->where('qa_answers.id', $answer_id)
            ->get()->row_array()['id'];

        return $result == $user_id;
    }

    public function question_can_be_deleted($question_id, $user_id){
        if($this->_is_admin($user_id)){
            return TRUE;
        }

        $result = $this->db
            ->select('qa_questions.id_users_questioner AS id')
            ->from('qa_questions')
            ->where('qa_questions.id', $question_id)
            ->get()->row_array()['id'];

        return $result == $user_id;
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

    public function post_reply($answer_id, $sender_id, $receiver_id, $content){

        $data_inserted = array(
            'id_answers' => $answer_id,
            'id_users_sender' => $sender_id,
            'id_users_receiver' =>$receiver_id,
            'content' => $content,
            'timestamp' => $this->_get_timestamp() 
        ); 

        if( ! $this->db->insert('qa_replies', $data_inserted)){
            log_operation('qa/post_reply', $sender_id, $data_inserted, 'fail');
            return false;
        }else{
            log_operation('qa/post_reply', $sender_id, $data_inserted, 'success');
            return true;
        }

    }

    public function delete_reply(){

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

    public function search_questions($input){
        $key_arr = explode(' ', $input);

        // Search labels - exact
        $this->db
            ->select('qa_labels_questions.id_questions AS question_id')
            ->from('qa_labels_questions')
            ->join('qa_labels', 'qa_labels.id = qa_labels_questions.id_labels', 'inner');
        
        foreach($key_arr AS $key){
            $this->db
                ->or_like('qa_labels.cn_name', $key)
                ->or_like('qa_labels.en_name', $key);
        }

        $result_label = $this->db
            ->order_by('question_id')
            ->get()->result_array();

        // Search questions title, description - exact
        $this->db
            ->select('qa_questions.id AS question_id')
            ->from('qa_questions');
        
        foreach($key_arr AS $key){
            $this->db
                ->or_like('qa_questions.title', $key)
                ->or_like('qa_questions.description', $key);
        }

        $result_title = $this->db
            ->order_by('question_id')
            ->get()->result_array();

        $l_ptr = 0;
        $t_ptr = 0;
        $max = max(sizeof($result_label), sizeof($result_title));
        $rtn_arr = array();
        $rtn_ptr = 0;
        //
        while($l_ptr < sizeof($result_label) && $t_ptr < sizeof($result_title)){
            $cur_result_label = $result_label[$l_ptr]['question_id'];
            $cur_result_title = $result_title[$t_ptr]['question_id'];
            if($cur_result_label == $cur_result_title){
                $rtn_arr[$rtn_ptr++] = $cur_result_label;
                $l_ptr++;
                $t_ptr++;
            }else if($cur_result_label < $cur_result_title){
                $l_ptr++;
            }else{
                $t_ptr++;
            }
        }

        return $rtn_arr;
    }

    public function delete_answer($answer_id, $user_id){
        if( ! $this->answer_can_be_deleted($answer_id, $user_id)){
            return FALSE;
        }
        // Delete votes
        $this->db->trans_begin();
        $ok = TRUE;
    

        $this->db->where('qa_user_vote_answer.id_answers', $answer_id);
        $ok &= $this->db->delete('qa_user_vote_answer');

        $this->db->where('qa_answers.id', $answer_id);
        $ok &= $this->db->delete('qa_answers');

        if( ! $ok){
            $this->db->trans_rollback();
        }else{
            $this->db->trans_commit();
        }

        $this->db->trans_complete();

        log_operation('qa/delete_answer', $user_id, array('answer_id' => $answer_id), array('result' => $ok ? 'success' : 'fail'));

        return $ok;
    }

    public function delete_question($question_id, $user_id){
        if( ! $this->question_can_be_deleted($question_id, $user_id)){
            return FALSE;
        }

        $this->db->trans_begin();
        $ok = TRUE;

        // :: Delete relative answers

        // Delete relative answers - get id of answers
        $result_answers = $this->db
            ->select('qa_answers.id AS id')
            ->from('qa_answers')
            ->where('qa_answers.id_questions', $question_id)
            ->get()->result_array();
        
        // Delete relative answers - delete votes
        foreach($result_answers AS $row){
            $this->db->where('id_answers', $row['id']);
            $ok &= $this->db->delete('qa_user_vote_answer');
        }
        // Delete relative answers - answers
        $this->db->where('qa_answers.id_questions', $question_id);
        $ok &= $this->db->delete('qa_answers');

        // :: Delete questions

        // Delete questions - relative labels
        $this->db->where('qa_labels_questions.id_questions');
        $ok &= $this->db->delete('qa_labels_questions');

        // Delete questions - questions
        $this->db->where('id', $question_id);
        $ok &= $this->db->delete('qa_questions');

        if( ! $ok){
            $this->db->trans_rollback();
        }else{
            $this->db->trans_commit();
        }

        $this->db->trans_complete();

        log_operation('qa/delete_question', $user_id, array('question_id' => $question_id), array('result' => $ok ? 'success' : 'fail'));

        return $ok;
    }


    // Basic view function
    public function get_question_brief($id_arr){

        $this->db
            ->select('
                qa_questions.id             AS id,
                qa_questions.title          AS title,
                qa_questions.timestamp      AS time,
                qa_questions.authentication AS authentication
            ')
            ->from('qa_questions');

        foreach($id_arr AS $id){
            $this->db->or_where('qa_questions.id', $id);
        }
        $rtn_array = $this->db
            ->order_by('qa_questions.id')
            ->get()
            ->result_array();

        $this->db->select('
            qa_answers.id_questions AS id,
            COUNT(qa_answers.id)    AS number_of_answers
        ')
        ->from('qa_answers');

        foreach($id_arr AS $id){
            $this->db->or_where('qa_answers.id_questions', $id);
        }
        $cnt_arr = $this->db
            ->group_by('qa_answers.id_questions')
            ->order_by('qa_answers.id_questions')
            ->get()
            ->result_array();
        
        $r_ptr = 0;
        $c_ptr = 0;
        $number_of_all = sizeof($rtn_array);
        $number_of_cnt = sizeof($cnt_arr);
        while($r_ptr < $number_of_all){
            if($c_ptr < $number_of_cnt && $cnt_arr[$c_ptr]['id'] == $rtn_array[$r_ptr]['id']){
                $rtn_array[$r_ptr]['number_of_answers'] = $cnt_arr[$c_ptr]['number_of_answers'];
                $r_ptr++;
                $c_ptr++;
            }else{
                $rtn_array[$r_ptr]['number_of_answers'] = 0;
                $r_ptr++;
            }
        }

        return $rtn_array;
    }

    public function get_question_details($id){
        
        $rtn_array = array();

        // Get question info
        $rtn_array['info'] = $this->db
            ->select('
                qa_questions.id             AS id,
                qa_questions.title          AS title,
                qa_questions.description    AS description,
                qa_questions.timestamp      AS time,
                qa_questions.authentication AS authentication,
                cm_users.name               AS provider_name,
                cm_users.email              AS provider_email,
                cm_majors.name              AS provider_major_cn,
                cm_majors.en_name           AS provider_major_en,
                cm_privileges.name          AS role
            ')
            ->from('qa_questions')
            ->join('cm_users', 'cm_users.id = qa_questions.id_users_questioner', 'inner')
            ->join('cm_privileges', 'cm_privileges.id = cm_users.id_privileges', 'inner')
            ->join('cm_majors', 'cm_majors.id = cm_users.id_majors', 'inner')
            ->where('qa_questions.id', $id)
            ->get()
            ->row_array();
        
        // Get question labels
        $rtn_array['labels'] = $this->db
            ->select('
                qa_labels.cn_name AS cn_name,
                qa_labels.en_name AS en_name
            ')
            ->from('qa_labels_questions')
            ->join('qa_labels', 'qa_labels.id = qa_labels_questions.id_labels', 'inner')
            ->where('qa_labels_questions.id_questions', $id)
            ->get()
            ->result_array();

        // Get answers
        $rtn_array['answers'] = $this->db
            ->select('
                qa_answers.id               AS id,
                qa_answers.vote             AS vote,
                qa_answers.content          AS content,
                qa_answers.timestamp        AS time,
                qa_answers.authentication   AS authentication,
                cm_users.name               AS provider_name,
                cm_users.email              AS provider_email,
                cm_majors.name              AS provider_major_cn,
                cm_majors.en_name           AS provider_major_en,
                cm_privileges.name          AS role
            ')
            ->from('qa_answers')
            ->join('cm_users', 'cm_users.id = qa_answers.id_users_provider', 'inner')
            ->join('cm_privileges', 'cm_privileges.id = cm_users.id_privileges', 'inner')
            ->join('cm_majors', 'cm_majors.id = cm_users.id_majors', 'inner')
            ->where('qa_answers.id_questions', $id)
            ->order_by('qa_answers.vote', 'DESC')
            ->get()
            ->result_array();

        // Get replies of answers
        for($i = 0; $i < sizeof($rtn_array['answers']); $i++){
            $rtn_array['answers'][$i]['replies'] = $this->db->select('
                qa_replies.id        AS id,
                sender.id            AS sender_id,
                sender.name          AS sender_name,
                receiver.id          AS receiver_id,
                receiver.name        AS receiver_name,
                qa_replies.content   AS content,
                qa_replies.timestamp AS timestamp
            ')
            ->from('qa_replies')
            ->join('cm_users AS sender', 'sender.id = qa_replies.id_users_sender', 'inner')
            ->join('cm_users AS receiver', 'receiver.id = qa_replies.id_users_receiver', 'inner')
            ->where('qa_replies.id_answers', $rtn_array['answers'][$i]['id'])
            ->order_by('qa_replies.timestamp')
            ->get()
            ->result_array();
        }
        
        return $rtn_array;
    }

    public function get_answers_replies($id_arr){
        foreach($id_arr AS $id){

        }
    }

    public function get_faqs_id(){
        return $this->db
            ->select('
                qa_questions.id AS id
            ')
            ->from('qa_questions')
            ->where('qa_questions.faq_mark', 1)
            ->get()
            ->result_array();
    }

    public function get_latest_question_id($num_limit){
        return $this->db
            ->select(
                'qa_questions.id AS id'
            )
            ->from('qa_questions')
            ->order_by('qa_questions.timestamp')
            ->limit($num_limit)
            ->get()
            ->result_array();
    }

    public function get_all_labels($language){
        if($language == 'english'){
            $this->db
            ->select('
                qa_labels.id      AS id,
                qa_labels.cn_name AS name
            ');
        }else{
            $this->db
            ->select('
                qa_labels.id      AS id,
                qa_labels.en_name AS name
            ');
        }

        return $this->db->from('qa_labels')
            ->get()
            ->result_array();        
    }

    public function get_my_questionIds($user_id){
        if( ! $user_id){
            return array();
        }

        return $this->db->select('
                qa_questions.id AS id
            ')
            ->from('qa_questions')
            ->where('qa_questions.id_users_questioner', $user_id)
            ->get()
            ->result_array();
    }

    public function get_my_answerIds($user_id){
        if( ! $user_id){
            return array();
        }

        return $this->db->select('
                qa_answers.id_questions AS id
            ')
            ->from('qa_answers')
            ->where('qa_answers.id_users_provider', $user_id)
            ->get()
            ->result_array();
    }

    // Admin function
    public function _admin_change_field($where_field, $where_value, $table, $field, $value, $user_id){
        if( ! $this->_is_admin($user_id)){
            return FALSE;
        }
        $this->db->where($where_field, $where_value);
        $ok = $this->db->update($table, [$field => $value]);
        log_operation('qa/' . $table .'/'.$field, $user_id, [$where_field => $where_value, $field => $value], ['result' => $ok ? 'success' : 'fail']);
        return $ok;
    }

    public function admin_change_question_authen($question_id, $authentication, $user_id){
        return $this->_admin_change_field(
            'qa_questions.id', $question_id, 'qa_questions', 'qa_questions.authentication', $authentication, $user_id
        );
    }

    public function admin_change_answer_authen($answer_id, $authentication, $user_id){
        return $this->_admin_change_field(
            'qa_answers.id', $answer_id, 'qa_answers', 'qa_answers.authentication', $authentication, $user_id
        );
    }

    public function admin_change_faq_mark($question_id, $mark, $user_id){
        return $this->_admin_change_field(
            'qa_questions.id', $question_id, 'qa_questions', 'qa_questions.faq_mark', $mark, $user_id
        );
    }

}