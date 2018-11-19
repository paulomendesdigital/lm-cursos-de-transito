ALTER TABLE `log_detrans`
	DROP FOREIGN KEY `FK_log_detran_user_id`;
ALTER TABLE `log_detrans`
	ADD CONSTRAINT `FK_log_detran_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE ON DELETE RESTRICT;


ALTER TABLE `log_detrans`
	ADD COLUMN `order_id` INT(11) NULL DEFAULT NULL AFTER `user_id`,
	ADD COLUMN `order_courses_id` INT(11) NULL DEFAULT NULL AFTER `order_id`,
	ADD CONSTRAINT `FK_log_detran_order_id` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON UPDATE CASCADE,
	ADD CONSTRAINT `FK_log_detran_order_courses_id` FOREIGN KEY (`order_courses_id`) REFERENCES `order_courses` (`id`) ON UPDATE CASCADE;

ALTER TABLE `order_courses`
	ADD COLUMN `data_matricula_detran` DATETIME NULL AFTER `data_status_detran`,
	ADD COLUMN `error_count_detran` INT(11) NULL AFTER `data_matricula_detran`;
