ALTER TABLE `log_detrans`
	ADD COLUMN `origem` VARCHAR(100) NULL DEFAULT NULL AFTER `order_courses_id`;
