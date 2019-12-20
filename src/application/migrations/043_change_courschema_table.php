<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Migration_Change_courschema_table extends CI_Migration{

	public function up(){

		$this->db->query('ALTER TABLE `cm_courschemas` 
        DROP COLUMN `graph_json_cn`,
        DROP COLUMN `pdf_url_cn`,
        DROP COLUMN `list_json_en`,
        CHANGE COLUMN `en_name` `type` VARCHAR(45) NOT NULL ,
        CHANGE COLUMN `list_json_cn` `list_json` TEXT NULL DEFAULT NULL ,
        CHANGE COLUMN `pdf_url_en` `pdf_url` VARCHAR(256) NULL DEFAULT NULL ,
        CHANGE COLUMN `graph_json_en` `graph_json` TEXT NULL DEFAULT NULL ,
        ADD COLUMN `source_code` TEXT NULL AFTER `graph_json`;
        ');

	}

	public function down(){
		$this->db->query('ALTER TABLE `cm_courschemas` 
        DROP COLUMN `source_code`,
        CHANGE COLUMN `type` `en_name` VARCHAR(45) NOT NULL ,
        CHANGE COLUMN `list_json` `list_json_en` TEXT NULL DEFAULT NULL ,
        CHANGE COLUMN `pdf_url` `pdf_url_en` VARCHAR(256) NULL DEFAULT NULL ,
        CHANGE COLUMN `graph_json` `graph_json_en` TEXT NULL DEFAULT NULL ,
        ADD COLUMN `list_json_cn` TEXT NULL AFTER `graph_json_en`,
        ADD COLUMN `pdf_url_cn` VARCHAR(45) NULL AFTER `list_json_cn`,
        ADD COLUMN `graph_json_cn` TEXT NULL AFTER `pdf_url_cn`;
        ');
	}

}
?>
