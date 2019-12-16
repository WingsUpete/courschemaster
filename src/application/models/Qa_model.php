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

    public function reply_can_be_deleted($reply_id, $user_id){
        if($this->_is_admin($user_id)){
            return TRUE;
        }

        $result = $this->db
            ->select('qa_replies.sender_id AS id')
            ->from('qa_replies')
            ->where('qa_replies.id', $reply_id)
            ->get()->row_array()['id'];

        return $result == $user_id;
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

        $rtn = array();

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
            'num_of_views' => $default_view_cnt,
            'answers_cnt' => 0
        );

        $insert_id = -1;

        $this->db->trans_begin();

        if($this->db->insert('qa_questions', $data_inserted)){
            $insert_id = $this->db->insert_id();
        }else{
            log_operation('qa/post_question', $user_id, $data_inserted, 'database fails on insert into questions');
            $this->db->trans_rollback();
            $this->db->trans_complete();
            $rtn['status'] = false;
            $rtn['id'] = -1; 
            return $rtn;
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

            $rtn['status'] = false;
            $rtn['id'] = -1; 
            return $rtn;
        }

        // Finished. 
        log_operation('qa/post_question', $user_id, $data_inserted, 'success');
        $this->db->trans_commit();
        $this->db->trans_complete();
        $rtn['status'] = true;
        $rtn['id'] = $insert_id ;
        return $rtn;
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
            $rtn['status'] = false;
            $rtn['id'] = -1;
            return $rtn;
        }else{
            $insert_id = $this->db->insert_id();
            log_operation('qa/post_answer', $user_id, $data_inserted, 'success');
            $rtn['status'] = true;
            $rtn['id'] = $insert_id;
            return $rtn;
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
            $rtn['status'] = false;
            $rtn['id'] = -1;
            return $rtn;
        }else{
            $insert_id = $this->db->insert_id();
            log_operation('qa/post_reply', $sender_id, $data_inserted, 'success');
            $rtn['status'] = true;
            $rtn['id'] = $insert_id;
            return $rtn;
        }

    }

    public function delete_reply($user_id, $reply_id){
        if( (! $user_id) || (! $this->reply_can_be_deleted($reply_id, $user_id))){
            return FALSE;
        }
        $this->db->where('qa_replies.id', $reply_id);
        return $this->db->delete('qa_replies');
    }

    /**
     * @deprecated This method is unused now. is_already_voted is integrated in get_question_details
     */
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
        if( ! $this->db->insert('qa_user_vote_answer', array('id_answers' => $answer_id, 'id_users' => $user_id, 'is_good' => $is_good ? 1 : -1))){
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
            ->select('
                qa_questions.id             AS id,
                qa_questions.title          AS title,
                qa_questions.timestamp      AS time,
                qa_questions.authentication AS authentication,
                qa_questions.answers_cnt    AS answers_cnt
            ')
            ->from('qa_labels_questions')
            ->join('qa_questions', 'qa_questions.id = qa_labels_questions.id_questions', 'inner')
            ->join('qa_labels', 'qa_labels.id = qa_labels_questions.id_labels', 'inner');
        
        foreach($key_arr AS $key){
            $this->db
                ->or_like('qa_labels.cn_name', $key)
                ->or_like('qa_labels.en_name', $key);
        }

        $result_label = $this->db
            ->order_by('qa_questions.id')
            ->get()->result_array();

        // Search questions title, description - exact
        $this->db
            ->select('
                qa_questions.id             AS id,
                qa_questions.title          AS title,
                qa_questions.timestamp      AS time,
                qa_questions.authentication AS authentication,
                qa_questions.answers_cnt    AS answers_cnt
            ')
            ->from('qa_questions');
        
        foreach($key_arr AS $key){
            $this->db
                ->or_like('qa_questions.title', $key)
                ->or_like('qa_questions.description', $key);
        }

        $result_title = $this->db
            ->order_by('qa_questions.id')
            ->get()->result_array();

        $l_ptr = 0;
        $t_ptr = 0;
        $rtn_arr = array();
        $rtn_ptr = 0;
        //
        while($l_ptr < sizeof($result_label) && $t_ptr < sizeof($result_title)){
            $cur_result_label = $result_label[$l_ptr];
            $cur_result_title = $result_title[$t_ptr];
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
        while($l_ptr < sizeof($result_label)){
            $rtn_arr[$rtn_ptr++] = $result_label[$l_ptr++];
        }
        while($t_ptr < sizeof($result_title)){
            $rtn_arr[$rtn_ptr++] = $result_title[$t_ptr++];
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

        $this->db->where('qa_replies.id_answers', $answer_id);
        $ok &= $this->db->delete('qa_replies');

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
        // Delete relative answers - delete replies
        foreach($result_answers AS $row){
            $this->db->where('id_answers', $row['id']);
            $ok &= $this->db->delete('qa_replies');
        }
        // Delete relative answers - answers
        $this->db->where('qa_answers.id_questions', $question_id);
        $ok &= $this->db->delete('qa_answers');

        // :: Delete questions

        // Delete questions - relative labels
        $this->db->where('qa_labels_questions.id_questions', $question_id);
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

    public function get_question_details($user_id, $language, $id){

        if( ! $id){
            return array();
        }
        
        $rtn_array = array();

        // Get question info
        if($language == 'english'){
            $this->db->select('cm_majors.en_name AS provider_major');
        }else{
            $this->db->select('cm_majors.name    AS provider_major');
        }
        $rtn_array['info'] = $this->db
            ->select('
                qa_questions.id             AS id,
                qa_questions.title          AS title,
                qa_questions.description    AS description,
                qa_questions.timestamp      AS time,
                qa_questions.authentication AS authentication,
                cm_users.id                 AS provider_id,
                cm_users.name               AS provider_name,
                cm_users.email              AS provider_email,
                cm_privileges.name          AS role
            ')
            ->from('qa_questions')
            ->join('cm_users', 'cm_users.id = qa_questions.id_users_questioner', 'inner')
            ->join('cm_privileges', 'cm_privileges.id = cm_users.id_privileges', 'inner')
            ->join('cm_majors', 'cm_majors.id = cm_users.id_majors', 'inner')
            ->where('qa_questions.id', $id)
            ->get()
            ->row_array();
        
        // Get question - can_be_deleted
        $rtn_array['info']['can_be_deleted'] = ($rtn_array['info']['provider_id'] == $user_id || $this->_is_admin($user_id)) ? 1 : 0;

        // Get question labels
        if($language == 'english'){
            $this->db->select('qa_labels.en_name AS name');
        }else{
            $this->db->select('qa_labels.cn_name AS name');
        }
        $rtn_array['labels'] = $this->db
            ->from('qa_labels_questions')
            ->join('qa_labels', 'qa_labels.id = qa_labels_questions.id_labels', 'inner')
            ->where('qa_labels_questions.id_questions', $id)
            ->get()
            ->result_array();

        // Get answers
        if($language == 'english'){
            $this->db->select('cm_majors.en_name AS provider_major');
        }else{
            $this->db->select('cm_majors.name    AS provider_major');
        }
        $rtn_array['answers'] = $this->db
            ->select('
                qa_answers.id               AS id,
                qa_answers.vote             AS vote,
                qa_answers.content          AS content,
                qa_answers.timestamp        AS time,
                qa_answers.authentication   AS authentication,
                cm_users.id                 AS provider_id,
                cm_users.name               AS provider_name,
                cm_users.email              AS provider_email,
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

        // Get answer - can_be_deleted
        if($this->_is_admin($user_id)){
            for($i = 0; $i < sizeof($rtn_array['answers']); $i++){
                $rtn_array['answers'][$i]['can_be_deleted'] = 1;
            }
        }else{
            for($i = 0; $i < sizeof($rtn_array['answers']); $i++){
                if($rtn_array['answers'][$i]['provider_id'] == $user_id){
                    $rtn_array['answers'][$i]['can_be_deleted'] = 1;
                }else{
                    $rtn_array['answers'][$i]['can_be_deleted'] = 0;
                }
            }
        }
        
        // Get replies of answers
        for($i = 0; $i < sizeof($rtn_array['answers']); $i++){
            $rtn_array['answers'][$i]['replies'] = $this->db->select('
                qa_replies.id        AS id,
                sender.id            AS sender_id,
                sender.name          AS sender_name,
                sender.email         AS sender_email,
                receiver.id          AS receiver_id,
                receiver.name        AS receiver_name,
                receiver.email       AS receiver_email,
                qa_replies.content   AS content,
                qa_replies.timestamp AS timestamp
            ')
            ->from('qa_replies')
            ->join('cm_users AS sender', 'sender.id = qa_replies.id_users_sender', 'inner')
            ->join('cm_users AS receiver', 'receiver.id = qa_replies.id_users_receiver', 'inner')
            ->where('qa_replies.id_answers', $rtn_array['answers'][$i]['id'])
            ->order_by('qa_replies.timestamp', 'DESC')
            ->get()
            ->result_array();
        }

        // Find which replies can be deleted
        for($i = 0; $i < sizeof($rtn_array['answers']); $i++){
            for($j = 0; $j < sizeof($rtn_array['answers'][$i]['replies']); $j++){
                $rtn_array['answers'][$i]['replies'][$j]['can_be_deleted'] = 
                $user_id
                    ? $this->_is_admin($user_id)
                        ? 1
                        : $rtn_array['answers'][$i]['replies']['sender_id'] == $user_id 
                            ? 1 
                            : 0
                    : 0;
            }
        }

        // Get if it is voted
        if($user_id){
            for($i = 0; $i < sizeof($rtn_array['answers']); $i++){
                $vote = $this->db->select('
                        qa_user_vote_answer.is_good AS user_vote_status
                    ')
                    ->from('qa_user_vote_answer')
                    ->where('qa_user_vote_answer.id_users', $user_id)
                    ->where('qa_user_vote_answer.id_answers', $rtn_array['answers'][$i]['id'])
                    ->get()
                    ->row_array()['user_vote_status'];

                $rtn_array['answers'][$i]['user_vote_status'] = $vote
                    ? $vote
                    : 0;
            }
        }else{
            for($i = 0; $i < sizeof($rtn_array['answers']); $i++){
                $rtn_array['answers'][$i]['user_vote_status'] = 0;
            }
        }
        
        
        return $rtn_array;
    }

    public function get_all_labels($language){
        $this->db->select('qa_labels.id AS id');
        if($language == 'english'){
            $this->db->select('qa_labels.en_name AS name');
        }else{
            $this->db->select('qa_labels.cn_name AS name');
        }
        return $this->db->from('qa_labels')
            ->get()
            ->result_array();        
    }

    public function get_faqs(){
        return $this->db
            ->select('
                qa_questions.id             AS id,
                qa_questions.title          AS title,
                qa_questions.timestamp      AS time,
                qa_questions.authentication AS authentication,
                qa_questions.answers_cnt    AS answers_cnt
            ')
            ->from('qa_questions')
            ->where('qa_questions.faq_mark', 1)
            ->order_by('qa_questions.timestamp', 'DESC')
            ->get()
            ->result_array();
    }

    public function get_latest_questions($num_limit){
        return $this->db
            ->select('
                qa_questions.id             AS id,
                qa_questions.title          AS title,
                qa_questions.timestamp      AS time,
                qa_questions.authentication AS authentication,
                qa_questions.answers_cnt    AS answers_cnt
            ')
            ->from('qa_questions')
            ->order_by('qa_questions.timestamp', 'DESC')
            ->limit($num_limit)
            ->get()
            ->result_array();
    }

    public function get_my_questions($user_id){
        if( ! $user_id){
            return array();
        }

        return $this->db->select('
                qa_questions.id             AS id,
                qa_questions.title          AS title,
                qa_questions.timestamp      AS time,
                qa_questions.authentication AS authentication,
                qa_questions.answers_cnt    AS answers_cnt
            ')
            ->from('qa_questions')
            ->where('qa_questions.id_users_questioner', $user_id)
            ->order_by('qa_questions.timestamp', 'DESC')
            ->get()
            ->result_array();
    }

    public function get_my_answers($user_id){
        if( ! $user_id){
            return array();
        }

        return $this->db->select('
                qa_questions.id             AS id,
                qa_questions.title          AS title,
                qa_questions.timestamp      AS time,
                qa_questions.authentication AS authentication,
                qa_questions.answers_cnt    AS answers_cnt
            ')
            ->from('qa_answers')
            ->join('qa_questions', 'qa_questions.id = qa_answers.id_questions', 'inner')
            ->where('qa_answers.id_users_provider', $user_id)
            ->group_by('qa_questions.id')
            ->order_by('qa_questions.timestamp', 'DESC')
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