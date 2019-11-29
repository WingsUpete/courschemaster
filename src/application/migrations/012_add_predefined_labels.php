<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Migration_Add_predefined_labels extends CI_Migration{
    
	public function up(){
        $data = array(
            ['cn_name'=> '计系',
             'en_name' => 'CSE']
            ,
            ['cn_name'=> '湿乎乎的话题',
             'en_name' => 'wet topic']
            ,
            ['cn_name'=> '建议/意见',
             'en_name' => 'advice']
            ,
            ['cn_name'=> '电子系',
             'en_name' => 'EE']
            ,
            ['cn_name'=> '数学系',
             'en_name' => 'MA Department']
            ,
            ['cn_name'=> '金融系',
             'en_name' => 'Department of Finance']
            ,
            ['cn_name'=> '学籍',
             'en_name' => 'Student Status']
            ,
            ['cn_name'=> '教工部',
             'en_name' => 'TAO']
            ,
            ['cn_name'=> '系统反馈',
             'en_name' => 'Feedback of System']
        );

        $this->db->insert_batch('qa_labels', $data);
        
	}

	public function down(){
		//
	}
}
?>