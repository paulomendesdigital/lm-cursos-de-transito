ALTER TABLE `students` ADD COLUMN `renach` VARCHAR(11) NULL AFTER `cnh_category`;

CREATE TABLE `status_detrans` (
	`id` INT NOT NULL AUTO_INCREMENT,
	`nome` VARCHAR(50) NOT NULL DEFAULT '0',
	PRIMARY KEY (`id`)
)
COLLATE='utf8_unicode_ci',
ENGINE=InnoDB;

INSERT INTO `status_detrans` (`id`, `nome`) VALUES (1, 'Erro');
INSERT INTO `status_detrans` (`id`, `nome`) VALUES (2, 'Não Matriculado');
INSERT INTO `status_detrans` (`id`, `nome`) VALUES (3, 'Matriculado');
INSERT INTO `status_detrans` (`id`, `nome`) VALUES (4, 'Concluído');


ALTER TABLE `order_courses`
	ADD COLUMN `status_detran_id` INT(11) NULL DEFAULT NULL AFTER `state_id`,
	ADD COLUMN `codigo_retorno_detran` VARCHAR(5) NULL AFTER `status_detran_id`,
	ADD COLUMN `mensagem_retorno_detran` VARCHAR(255) NULL AFTER `codigo_retorno_detran`,
	ADD COLUMN `data_status_detran` DATETIME NULL AFTER `mensagem_retorno_detran`,
	ADD CONSTRAINT `FK_order_courses_status_detran_id` FOREIGN KEY (`status_detran_id`) REFERENCES `status_detrans` (`id`) ON UPDATE CASCADE;

CREATE TABLE `log_detrans` (
	`id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
	`data_log` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
	`integracao` VARCHAR(100) NOT NULL,
	`rotina` VARCHAR(100) NOT NULL,
	`codigo_retorno` VARCHAR(10) NULL,
	`mensagem_retorno` VARCHAR(255) NULL,
	`parametros` TEXT NULL,
	`dados_enviados` TEXT NULL,
	`dados_retornados` TEXT NULL,
	`cpf` VARCHAR(30) NULL,
	`renach` VARCHAR(30) NULL,
	`cnh` VARCHAR(30) NULL,
	`user_id` INT(11) NULL,
	PRIMARY KEY (`id`),
	INDEX `data_log` (`data_log`),
	INDEX `integracao` (`integracao`),
	INDEX `cpf` (`cpf`),
	CONSTRAINT `FK_log_detran_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE ON DELETE SET NULL
)
COLLATE='utf8_unicode_ci'
ENGINE=InnoDB;
