<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Migration_add_qa_replies_table extends CI_Migration{

	public function up(){

        $this->db->query('CREATE TABLE `qa_replies` (
            `id` INT NOT NULL,
            `id_users_sender` INT NULL,
            `id_users_receiver` INT NULL,
            `content` VARCHAR(256) NULL,
            `timestamp` DATETIME NULL,
            PRIMARY KEY (`id`),
            INDEX `fk_replies_sender_users_idx` (`id_users_sender` ASC),
            INDEX `fk_replies_receiver_users_idx` (`id_users_receiver` ASC),
            CONSTRAINT `fk_replies_sender_users`
              FOREIGN KEY (`id_users_sender`)
              REFERENCES `cm_users` (`id`)
              ON DELETE NO ACTION
              ON UPDATE NO ACTION,
            CONSTRAINT `fk_replies_receiver_users`
              FOREIGN KEY (`id_users_receiver`)
              REFERENCES `cm_users` (`id`)
              ON DELETE NO ACTION
              ON UPDATE NO ACTION);
        ');


	}

	public function down(){

        $this->db->query('DROP TABLE qa_replies');

	}
}
?>
