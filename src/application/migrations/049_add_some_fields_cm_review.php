<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Migration_Add_some_fields_cm_review extends CI_Migration{

	public function up(){

        $this->db->query('ALTER TABLE `cm_review` 
            ADD COLUMN `id_users_poster` INT NULL AFTER `comment`,
            ADD COLUMN `post_timestamp` DATETIME NULL AFTER `id_users_poster`,
            ADD COLUMN `id_users_reviewer` INT NULL AFTER `post_timestamp`,
            ADD COLUMN `review_timestamp` DATETIME NULL AFTER `id_users_reviewer`,
            ADD INDEX `fk_review_users_poster_idx` (`id_users_poster` ASC),
            ADD INDEX `fk_review_users_reviewer_idx` (`id_users_reviewer` ASC);');

        $this->db->query('ALTER TABLE `cm_review` 
            ADD CONSTRAINT `fk_review_users_poster`
            FOREIGN KEY (`id_users_poster`)
            REFERENCES `cm_users` (`id`)
            ON DELETE NO ACTION
            ON UPDATE NO ACTION,
            ADD CONSTRAINT `fk_review_users_reviewer`
            FOREIGN KEY (`id_users_reviewer`)
            REFERENCES `cm_users` (`id`)
            ON DELETE NO ACTION
            ON UPDATE NO ACTION;');
	}

	public function down(){
        $this->db->query('ALTER TABLE `cm_review` 
            DROP FOREIGN KEY `fk_review_users_reviewer`,
            DROP FOREIGN KEY `fk_review_users_poster`;');

        $this->db->query('ALTER TABLE `cm_review` 
            DROP COLUMN `review_timestamp`,
            DROP COLUMN `id_users_reviewer`,
            DROP COLUMN `post_timestamp`,
            DROP COLUMN `id_users_poster`,
            DROP INDEX `fk_review_users_reviewer_idx` ,
            DROP INDEX `fk_review_users_poster_idx` ;');
    }
    

}
?>
