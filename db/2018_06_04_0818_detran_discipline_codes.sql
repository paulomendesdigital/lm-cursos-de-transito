CREATE TABLE `course_codes` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`course_type_id` INT NOT NULL,
	`code` VARCHAR(2) NOT NULL,
	`name` VARCHAR(70) NOT NULL,
	PRIMARY KEY (`id`),
	UNIQUE INDEX `course_codes_unique` (`code`),
	CONSTRAINT `FK_course_codes_course_type_id` FOREIGN KEY (`course_type_id`) REFERENCES `course_types` (`id`)
)
COLLATE='utf8_unicode_ci'
ENGINE=InnoDB
;

INSERT INTO `course_codes` (`id`, `course_type_id`, `code`, `name`) VALUES (1,  2, '01', 'Cargas Perigosas');
INSERT INTO `course_codes` (`id`, `course_type_id`, `code`, `name`) VALUES (2,  2, '02', 'Transporte de Escolares');
INSERT INTO `course_codes` (`id`, `course_type_id`, `code`, `name`) VALUES (3,  2, '03', 'Transporte Coletivo de Passageiros');
INSERT INTO `course_codes` (`id`, `course_type_id`, `code`, `name`) VALUES (4,  2, '04', 'Capacitação Transporte de Veículos de Emergência');
INSERT INTO `course_codes` (`id`, `course_type_id`, `code`, `name`) VALUES (5,  2, '07', 'Capacitação Transporte de Carga Indivisível');
INSERT INTO `course_codes` (`id`, `course_type_id`, `code`, `name`) VALUES (6,  2, '08', 'Mototaxista');
INSERT INTO `course_codes` (`id`, `course_type_id`, `code`, `name`) VALUES (7,  2, '09', 'Motofretista');
INSERT INTO `course_codes` (`id`, `course_type_id`, `code`, `name`) VALUES (8,  2, '11', 'Atualização Transporte de Produtos Perigosos');
INSERT INTO `course_codes` (`id`, `course_type_id`, `code`, `name`) VALUES (9,  2, '12', 'Atualização Transporte Escolar');
INSERT INTO `course_codes` (`id`, `course_type_id`, `code`, `name`) VALUES (10, 2, '13', 'Atualização Transporte Coletivo de Passageiros');
INSERT INTO `course_codes` (`id`, `course_type_id`, `code`, `name`) VALUES (11, 2, '14', 'Atualização Transporte de Veículos Emergência');
INSERT INTO `course_codes` (`id`, `course_type_id`, `code`, `name`) VALUES (12, 2, '17', 'Atualização Capacitação Transporte de Carga Indivisível');
INSERT INTO `course_codes` (`id`, `course_type_id`, `code`, `name`) VALUES (13, 2, '18', 'Atualização Mototaxista');
INSERT INTO `course_codes` (`id`, `course_type_id`, `code`, `name`) VALUES (14, 2, '19', 'Atualização Motofretista');
INSERT INTO `course_codes` (`id`, `course_type_id`, `code`, `name`) VALUES (15, 3, 'R',  'Reciclagem');
INSERT INTO `course_codes` (`id`, `course_type_id`, `code`, `name`) VALUES (16, 4, 'A',  'Atualização');


CREATE TABLE `discipline_codes` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`code` VARCHAR(2) NOT NULL,
	`name` VARCHAR(200) NOT NULL,
	`course_code_id` INT(11) NOT NULL,
	`hours` INT(2) NOT NULL DEFAULT '0',
	`is_exam` TINYINT(1) NOT NULL DEFAULT '0',
	PRIMARY KEY (`id`),
	UNIQUE INDEX `discipline_codes_unique` (`code`, `course_code_id`),
	INDEX `FK_discipline_codes_course_code_id` (`course_code_id`),
	CONSTRAINT `FK_discipline_codes_course_code_id` FOREIGN KEY (`course_code_id`) REFERENCES `course_codes` (`id`)
)
COLLATE='utf8_unicode_ci'
ENGINE=InnoDB
;

INSERT INTO `discipline_codes` (`id`, `code`, `name`, `course_code_id`, `hours`, `is_exam`) VALUES (1, 'L', 'Legislação de Trânsito', 15, 12, 0);
INSERT INTO `discipline_codes` (`id`, `code`, `name`, `course_code_id`, `hours`, `is_exam`) VALUES (2, 'D', 'Direção Defensiva', 15, 8, 0);
INSERT INTO `discipline_codes` (`id`, `code`, `name`, `course_code_id`, `hours`, `is_exam`) VALUES (3, 'S', 'Noções de Primeiros Socorros', 15, 4, 0);
INSERT INTO `discipline_codes` (`id`, `code`, `name`, `course_code_id`, `hours`, `is_exam`) VALUES (4, 'R', 'Relacionamento Interpessoal', 15, 6, 0);
INSERT INTO `discipline_codes` (`id`, `code`, `name`, `course_code_id`, `hours`, `is_exam`) VALUES (5, 'L', 'Direção Defensiva', 16, 8, 0);
INSERT INTO `discipline_codes` (`id`, `code`, `name`, `course_code_id`, `hours`, `is_exam`) VALUES (6, 'S', 'Primeiros Socorros', 16, 4, 0);
INSERT INTO `discipline_codes` (`id`, `code`, `name`, `course_code_id`, `hours`, `is_exam`) VALUES (7, 'L1', 'Legislação de Trânsito - 01', 1, 5, 0);
INSERT INTO `discipline_codes` (`id`, `code`, `name`, `course_code_id`, `hours`, `is_exam`) VALUES (8, 'L3', 'Legislação de Trânsito para o Curso 01', 1, 4, 0);
INSERT INTO `discipline_codes` (`id`, `code`, `name`, `course_code_id`, `hours`, `is_exam`) VALUES (9, 'P1', 'Prova de Legislação de Trânsito para o Curso 01', 1, 1, 1);
INSERT INTO `discipline_codes` (`id`, `code`, `name`, `course_code_id`, `hours`, `is_exam`) VALUES (11, 'D1', 'Direção Defensiva - 01', 1, 12, 0);
INSERT INTO `discipline_codes` (`id`, `code`, `name`, `course_code_id`, `hours`, `is_exam`) VALUES (13, 'D3', 'Direção Defensiva para o Curso 01', 1, 2, 0);
INSERT INTO `discipline_codes` (`id`, `code`, `name`, `course_code_id`, `hours`, `is_exam`) VALUES (14, 'P2', 'Prova de Direção Defensiva para o Curso 01', 1, 1, 1);
INSERT INTO `discipline_codes` (`id`, `code`, `name`, `course_code_id`, `hours`, `is_exam`) VALUES (15, 'N1', 'Noções de Primeiros Socorros, Respeito ao Meio Ambiente e Convívio Social no Trânsito - 01', 1, 5, 0);
INSERT INTO `discipline_codes` (`id`, `code`, `name`, `course_code_id`, `hours`, `is_exam`) VALUES (18, 'N3', 'Noções de Primeiros Socorros, Respeito ao Meio Ambiente e Prevenção de Incêndio', 1, 4, 0);
INSERT INTO `discipline_codes` (`id`, `code`, `name`, `course_code_id`, `hours`, `is_exam`) VALUES (19, 'P3', 'Prova de Noções de Primeiros Socorros, Respeito ao Meio Ambiente e Prevenção de Incêndio para o Curso 01', 1, 1, 1);
INSERT INTO `discipline_codes` (`id`, `code`, `name`, `course_code_id`, `hours`, `is_exam`) VALUES (20, 'M1', 'Movimentação de Produtos Perigosos para o Curso 01', 1, 14, 0);
INSERT INTO `discipline_codes` (`id`, `code`, `name`, `course_code_id`, `hours`, `is_exam`) VALUES (21, 'P4', 'Prova de Movimentação de Produtos Perigosos para o Curso 01', 1, 1, 1);
INSERT INTO `discipline_codes` (`id`, `code`, `name`, `course_code_id`, `hours`, `is_exam`) VALUES (22, 'L1', 'Legislação de Trânsito - 01', 2, 5, 0);
INSERT INTO `discipline_codes` (`id`, `code`, `name`, `course_code_id`, `hours`, `is_exam`) VALUES (23, 'L4', 'Legislação de Trânsito para o Curso 02', 2, 4, 0);
INSERT INTO `discipline_codes` (`id`, `code`, `name`, `course_code_id`, `hours`, `is_exam`) VALUES (24, 'P5', 'Prova de Legislação de Trânsito para o Curso 02', 2, 1, 1);
INSERT INTO `discipline_codes` (`id`, `code`, `name`, `course_code_id`, `hours`, `is_exam`) VALUES (25, 'D1', 'Direção Defensiva - 01', 2, 12, 0);
INSERT INTO `discipline_codes` (`id`, `code`, `name`, `course_code_id`, `hours`, `is_exam`) VALUES (26, 'D2', 'Direção Defensiva - 02', 2, 2, 0);
INSERT INTO `discipline_codes` (`id`, `code`, `name`, `course_code_id`, `hours`, `is_exam`) VALUES (27, 'P6', 'Prova de Direção Defensiva para o Curso 02', 2, 1, 1);
INSERT INTO `discipline_codes` (`id`, `code`, `name`, `course_code_id`, `hours`, `is_exam`) VALUES (28, 'N1', 'Noções de Primeiros Socorros, Respeito ao Meio Ambiente e Convívio Social no Trânsito - 01', 2, 5, 0);
INSERT INTO `discipline_codes` (`id`, `code`, `name`, `course_code_id`, `hours`, `is_exam`) VALUES (29, 'N2', 'Noções de Primeiros Socorros, Respeito ao Meio Ambiente e Convívio Social no Trânsito - 02', 2, 4, 0);
INSERT INTO `discipline_codes` (`id`, `code`, `name`, `course_code_id`, `hours`, `is_exam`) VALUES (30, 'P7', 'Prova de Noções de Primeiros Socorros, Respeito ao Meio Ambiente e Convívio Social no Trânsito para o Curso 02', 2, 1, 1);
INSERT INTO `discipline_codes` (`id`, `code`, `name`, `course_code_id`, `hours`, `is_exam`) VALUES (31, 'R1', 'Relacionamento Interpessoal 01', 2, 5, 0);
INSERT INTO `discipline_codes` (`id`, `code`, `name`, `course_code_id`, `hours`, `is_exam`) VALUES (32, 'R2', 'Relacionamento Interpessoal para o Curso 02', 2, 9, 0);
INSERT INTO `discipline_codes` (`id`, `code`, `name`, `course_code_id`, `hours`, `is_exam`) VALUES (33, 'P8', 'Prova de Relacionamento Interpessoal para o Curso 02', 2, 1, 1);
INSERT INTO `discipline_codes` (`id`, `code`, `name`, `course_code_id`, `hours`, `is_exam`) VALUES (34, 'L1', 'Legislação de Trânsito - 01', 3, 5, 0);
INSERT INTO `discipline_codes` (`id`, `code`, `name`, `course_code_id`, `hours`, `is_exam`) VALUES (35, 'L5', 'Legislação de Trânsito para o Curso 03', 3, 4, 0);
INSERT INTO `discipline_codes` (`id`, `code`, `name`, `course_code_id`, `hours`, `is_exam`) VALUES (36, 'P9', 'Prova de Legislação de Trânsito para o Curso 03', 3, 1, 1);
INSERT INTO `discipline_codes` (`id`, `code`, `name`, `course_code_id`, `hours`, `is_exam`) VALUES (37, 'D1', 'Direção Defensiva - 01', 3, 12, 0);
INSERT INTO `discipline_codes` (`id`, `code`, `name`, `course_code_id`, `hours`, `is_exam`) VALUES (38, 'D2', 'Direção Defensiva - 02', 3, 2, 0);
INSERT INTO `discipline_codes` (`id`, `code`, `name`, `course_code_id`, `hours`, `is_exam`) VALUES (39, 'PA', 'Prova de Direção Defensiva para o Curso 03', 3, 1, 1);
INSERT INTO `discipline_codes` (`id`, `code`, `name`, `course_code_id`, `hours`, `is_exam`) VALUES (41, 'N1', 'Noções de Primeiros Socorros, Respeito ao Meio Ambiente e Convívio Social no Trânsito - 01', 3, 5, 0);
INSERT INTO `discipline_codes` (`id`, `code`, `name`, `course_code_id`, `hours`, `is_exam`) VALUES (42, 'N2', 'Noções de Primeiros Socorros, Respeito ao Meio Ambiente e Convívio Social no Trânsito - 02', 3, 4, 0);
INSERT INTO `discipline_codes` (`id`, `code`, `name`, `course_code_id`, `hours`, `is_exam`) VALUES (43, 'PB', 'Prova de Noções de Primeiros Socorros, Respeito ao Meio Ambiente e Convívio Social no Trânsito para o Curso 03', 3, 1, 1);
INSERT INTO `discipline_codes` (`id`, `code`, `name`, `course_code_id`, `hours`, `is_exam`) VALUES (44, 'R1', 'Relacionamento Interpessoal 01', 3, 5, 0);
INSERT INTO `discipline_codes` (`id`, `code`, `name`, `course_code_id`, `hours`, `is_exam`) VALUES (45, 'R3', 'Relacionamento Interpessoal para o Curso 03', 3, 9, 0);
INSERT INTO `discipline_codes` (`id`, `code`, `name`, `course_code_id`, `hours`, `is_exam`) VALUES (46, 'PC', 'Prova de Relacionamento Interpessoal para o Curso 03', 3, 1, 1);
INSERT INTO `discipline_codes` (`id`, `code`, `name`, `course_code_id`, `hours`, `is_exam`) VALUES (47, 'L1', 'Legislação de Trânsito - 01', 4, 5, 0);
INSERT INTO `discipline_codes` (`id`, `code`, `name`, `course_code_id`, `hours`, `is_exam`) VALUES (48, 'L6', 'Legislação de Trânsito para o Curso 04', 4, 4, 0);
INSERT INTO `discipline_codes` (`id`, `code`, `name`, `course_code_id`, `hours`, `is_exam`) VALUES (49, 'PD', 'Prova de Legislação de Trânsito para o Curso 04', 4, 1, 1);
INSERT INTO `discipline_codes` (`id`, `code`, `name`, `course_code_id`, `hours`, `is_exam`) VALUES (50, 'D1', 'Direção Defensiva - 01', 4, 12, 0);
INSERT INTO `discipline_codes` (`id`, `code`, `name`, `course_code_id`, `hours`, `is_exam`) VALUES (51, 'D2', 'Direção Defensiva - 02', 4, 2, 0);
INSERT INTO `discipline_codes` (`id`, `code`, `name`, `course_code_id`, `hours`, `is_exam`) VALUES (52, 'PE', 'Prova de Direção Defensiva para o Curso 04', 4, 1, 1);
INSERT INTO `discipline_codes` (`id`, `code`, `name`, `course_code_id`, `hours`, `is_exam`) VALUES (53, 'N1', 'Noções de Primeiros Socorros, Respeito ao Meio Ambiente e Convívio Social no Trânsito - 01', 4, 5, 0);
INSERT INTO `discipline_codes` (`id`, `code`, `name`, `course_code_id`, `hours`, `is_exam`) VALUES (54, 'N2', 'Noções de Primeiros Socorros, Respeito ao Meio Ambiente e Convívio Social no Trânsito - 02', 4, 4, 0);
INSERT INTO `discipline_codes` (`id`, `code`, `name`, `course_code_id`, `hours`, `is_exam`) VALUES (55, 'PF', 'Prova de Noções de Primeiros Socorros, Respeito ao Meio Ambiente e Convívio Social no Trânsito para o Curso 04', 4, 1, 1);
INSERT INTO `discipline_codes` (`id`, `code`, `name`, `course_code_id`, `hours`, `is_exam`) VALUES (56, 'R1', 'Relacionamento Interpessoal 01', 4, 5, 0);
INSERT INTO `discipline_codes` (`id`, `code`, `name`, `course_code_id`, `hours`, `is_exam`) VALUES (57, 'R4', 'Relacionamento Interpessoal para o Curso 04', 4, 9, 0);
INSERT INTO `discipline_codes` (`id`, `code`, `name`, `course_code_id`, `hours`, `is_exam`) VALUES (58, 'PG', 'Prova de Relacionamento Interpessoal para o Curso 04', 4, 1, 1);
INSERT INTO `discipline_codes` (`id`, `code`, `name`, `course_code_id`, `hours`, `is_exam`) VALUES (59, 'L1', 'Legislação de Trânsito - 01', 5, 5, 0);
INSERT INTO `discipline_codes` (`id`, `code`, `name`, `course_code_id`, `hours`, `is_exam`) VALUES (60, 'L7', 'Legislação de Trânsito para o Curso 07', 5, 4, 0);
INSERT INTO `discipline_codes` (`id`, `code`, `name`, `course_code_id`, `hours`, `is_exam`) VALUES (61, 'PH', 'Prova de Legislação de Trânsito para o Curso 07', 5, 1, 1);
INSERT INTO `discipline_codes` (`id`, `code`, `name`, `course_code_id`, `hours`, `is_exam`) VALUES (62, 'D1', 'Direção Defensiva - 01', 5, 12, 0);
INSERT INTO `discipline_codes` (`id`, `code`, `name`, `course_code_id`, `hours`, `is_exam`) VALUES (63, 'D4', 'Direção Defensiva para o Curso 07', 5, 2, 0);
INSERT INTO `discipline_codes` (`id`, `code`, `name`, `course_code_id`, `hours`, `is_exam`) VALUES (64, 'PI', 'Prova de Direção Defensiva para o Curso 07', 5, 1, 1);
INSERT INTO `discipline_codes` (`id`, `code`, `name`, `course_code_id`, `hours`, `is_exam`) VALUES (65, 'N1', 'Noções de Primeiros Socorros, Respeito ao Meio Ambiente e Convívio Social no Trânsito - 01', 5, 5, 0);
INSERT INTO `discipline_codes` (`id`, `code`, `name`, `course_code_id`, `hours`, `is_exam`) VALUES (66, 'N3', 'Noções de Primeiros Socorros, Respeito ao Meio Ambiente e Prevenção de Incêndio', 5, 4, 0);
INSERT INTO `discipline_codes` (`id`, `code`, `name`, `course_code_id`, `hours`, `is_exam`) VALUES (67, 'PJ', 'Prova de Noções de Primeiros Socorros, Respeito ao Meio', 5, 1, 1);
INSERT INTO `discipline_codes` (`id`, `code`, `name`, `course_code_id`, `hours`, `is_exam`) VALUES (68, 'M2', 'Movimentação de Carga para o Curso 07', 5, 14, 0);
INSERT INTO `discipline_codes` (`id`, `code`, `name`, `course_code_id`, `hours`, `is_exam`) VALUES (69, 'PK', 'Prova de Movimentação de Carga para o Curso 07', 5, 1, 1);
INSERT INTO `discipline_codes` (`id`, `code`, `name`, `course_code_id`, `hours`, `is_exam`) VALUES (70, 'E1', 'Ética e cidadania na atividade profissional', 6, 3, 0);
INSERT INTO `discipline_codes` (`id`, `code`, `name`, `course_code_id`, `hours`, `is_exam`) VALUES (71, 'L2', 'Noções básicas de Legislação', 6, 7, 0);
INSERT INTO `discipline_codes` (`id`, `code`, `name`, `course_code_id`, `hours`, `is_exam`) VALUES (72, 'G1', 'Gestão do risco sobre duas rodas', 6, 7, 0);
INSERT INTO `discipline_codes` (`id`, `code`, `name`, `course_code_id`, `hours`, `is_exam`) VALUES (73, 'S1', 'Segurança e saúde', 6, 3, 0);
INSERT INTO `discipline_codes` (`id`, `code`, `name`, `course_code_id`, `hours`, `is_exam`) VALUES (74, 'T1', 'Transporte de pessoas para o Curso 08', 6, 5, 0);
INSERT INTO `discipline_codes` (`id`, `code`, `name`, `course_code_id`, `hours`, `is_exam`) VALUES (75, 'V1', 'Prática veicular individual específica – Pessoas para o Curso 08', 6, 5, 0);
INSERT INTO `discipline_codes` (`id`, `code`, `name`, `course_code_id`, `hours`, `is_exam`) VALUES (76, 'PL', 'Prova do Curso de Mototaxista', 6, 1, 1);
INSERT INTO `discipline_codes` (`id`, `code`, `name`, `course_code_id`, `hours`, `is_exam`) VALUES (77, 'E1', 'Ética e cidadania na atividade profissional', 7, 3, 0);
INSERT INTO `discipline_codes` (`id`, `code`, `name`, `course_code_id`, `hours`, `is_exam`) VALUES (78, 'L2', 'Noções básicas de Legislação', 7, 7, 0);
INSERT INTO `discipline_codes` (`id`, `code`, `name`, `course_code_id`, `hours`, `is_exam`) VALUES (79, 'G1', 'Gestão do risco sobre duas rodas', 7, 7, 0);
INSERT INTO `discipline_codes` (`id`, `code`, `name`, `course_code_id`, `hours`, `is_exam`) VALUES (80, 'S1', 'Segurança e saúde', 7, 3, 0);
INSERT INTO `discipline_codes` (`id`, `code`, `name`, `course_code_id`, `hours`, `is_exam`) VALUES (81, 'T2', 'Transporte de cargas para o Curso 09', 7, 5, 0);
INSERT INTO `discipline_codes` (`id`, `code`, `name`, `course_code_id`, `hours`, `is_exam`) VALUES (82, 'V2', 'Prática veicular individual específica – Cargas para o Curso 09', 7, 5, 0);
INSERT INTO `discipline_codes` (`id`, `code`, `name`, `course_code_id`, `hours`, `is_exam`) VALUES (83, 'PM', 'Prova do Curso de Motofretista', 7, 1, 1);
INSERT INTO `discipline_codes` (`id`, `code`, `name`, `course_code_id`, `hours`, `is_exam`) VALUES (84, 'L8', 'Legislação de trânsito para o Curso 11', 8, 3, 0);
INSERT INTO `discipline_codes` (`id`, `code`, `name`, `course_code_id`, `hours`, `is_exam`) VALUES (85, 'D5', 'Direção defensiva para o Curso 11', 8, 5, 0);
INSERT INTO `discipline_codes` (`id`, `code`, `name`, `course_code_id`, `hours`, `is_exam`) VALUES (86, 'N4', 'Noções de Primeiros Socorros, Respeito ao meio ambiente e Convívio Social no Trânsito para o Curso 11', 8, 3, 0);
INSERT INTO `discipline_codes` (`id`, `code`, `name`, `course_code_id`, `hours`, `is_exam`) VALUES (87, 'I1', 'Prevenção de Incêndio, Movimentação de Produtos Perigosos para o Curso 11', 8, 5, 0);
INSERT INTO `discipline_codes` (`id`, `code`, `name`, `course_code_id`, `hours`, `is_exam`) VALUES (88, 'L9', 'Legislação de Trânsito para o Curso 12', 9, 3, 0);
INSERT INTO `discipline_codes` (`id`, `code`, `name`, `course_code_id`, `hours`, `is_exam`) VALUES (89, 'D6', 'Direção Defensiva para o Curso 12', 9, 5, 0);
INSERT INTO `discipline_codes` (`id`, `code`, `name`, `course_code_id`, `hours`, `is_exam`) VALUES (90, 'N5', 'Noções de Primeiros Socorros, Respeito ao meio ambiente e Convívio Social no Trânsito para o Curso 12', 9, 3, 0);
INSERT INTO `discipline_codes` (`id`, `code`, `name`, `course_code_id`, `hours`, `is_exam`) VALUES (91, 'R5', 'Relacionamento Interpessoal para o Curso 12', 9, 5, 0);
INSERT INTO `discipline_codes` (`id`, `code`, `name`, `course_code_id`, `hours`, `is_exam`) VALUES (92, 'LA', 'Legislação de Trânsito para o Curso 13', 10, 3, 0);
INSERT INTO `discipline_codes` (`id`, `code`, `name`, `course_code_id`, `hours`, `is_exam`) VALUES (93, 'D7', 'Direção Defensiva para o Curso 13', 10, 5, 0);
INSERT INTO `discipline_codes` (`id`, `code`, `name`, `course_code_id`, `hours`, `is_exam`) VALUES (94, 'N6', 'Noções de Primeiros Socorros, Respeito ao meio ambiente e Convívio Social no Trânsito para o Curso 13', 10, 3, 0);
INSERT INTO `discipline_codes` (`id`, `code`, `name`, `course_code_id`, `hours`, `is_exam`) VALUES (95, 'R6', 'Relacionamento Interpessoal para o Curso 13', 10, 5, 0);
INSERT INTO `discipline_codes` (`id`, `code`, `name`, `course_code_id`, `hours`, `is_exam`) VALUES (96, 'LB', 'Legislação de Trânsito para o Curso 14', 11, 3, 0);
INSERT INTO `discipline_codes` (`id`, `code`, `name`, `course_code_id`, `hours`, `is_exam`) VALUES (97, 'D8', 'Direção Defensiva para o Curso 14', 11, 5, 0);
INSERT INTO `discipline_codes` (`id`, `code`, `name`, `course_code_id`, `hours`, `is_exam`) VALUES (98, 'N7', 'Noções de Primeiros Socorros, Respeito ao meio ambiente e Convívio Social no Trânsito para o Curso 14', 11, 3, 0);
INSERT INTO `discipline_codes` (`id`, `code`, `name`, `course_code_id`, `hours`, `is_exam`) VALUES (99, 'R7', 'Relacionamento Interpessoal para o Curso 14', 11, 5, 0);
INSERT INTO `discipline_codes` (`id`, `code`, `name`, `course_code_id`, `hours`, `is_exam`) VALUES (100, 'LC', 'Legislação de Trânsito para o Curso 17', 12, 3, 0);
INSERT INTO `discipline_codes` (`id`, `code`, `name`, `course_code_id`, `hours`, `is_exam`) VALUES (101, 'D9', 'Direção Defensiva para o Curso 17', 12, 5, 0);
INSERT INTO `discipline_codes` (`id`, `code`, `name`, `course_code_id`, `hours`, `is_exam`) VALUES (102, 'N8', 'Noções de Primeiros Socorros, Respeito ao meio ambiente e Convívio Social no Trânsito para o Curso 17', 12, 3, 0);
INSERT INTO `discipline_codes` (`id`, `code`, `name`, `course_code_id`, `hours`, `is_exam`) VALUES (103, 'R8', 'Relacionamento Interpessoal para o Curso 17', 12, 5, 0);
INSERT INTO `discipline_codes` (`id`, `code`, `name`, `course_code_id`, `hours`, `is_exam`) VALUES (104, 'T4', 'Transporte de pessoas para o Curso 18', 12, 7, 0);
INSERT INTO `discipline_codes` (`id`, `code`, `name`, `course_code_id`, `hours`, `is_exam`) VALUES (105, 'V4', 'Prática veicular individual para o transporte de pessoas para o Curso 18', 13, 3, 0);
INSERT INTO `discipline_codes` (`id`, `code`, `name`, `course_code_id`, `hours`, `is_exam`) VALUES (106, 'T3', 'Transporte de cargas para o Curso 19', 14, 7, 0);
INSERT INTO `discipline_codes` (`id`, `code`, `name`, `course_code_id`, `hours`, `is_exam`) VALUES (107, 'V3', 'Prática veicular individual para o transporte de carga para o Curso 19', 14, 3, 0);


ALTER TABLE `courses`
	ADD COLUMN `course_code_id` INT(11) NULL AFTER `detran_validation`,
	ADD CONSTRAINT `FK_couses_course_code_id` FOREIGN KEY (`course_code_id`) REFERENCES `course_codes` (`id`);

ALTER TABLE `modules`
	DROP COLUMN `module_code`,
	ADD COLUMN `exam_discipline_code_id` INT(11) NULL AFTER `status`,
	ADD CONSTRAINT `FK_modules_exam_discipline_code_id` FOREIGN KEY (`exam_discipline_code_id`) REFERENCES `discipline_codes` (`id`);

ALTER TABLE `module_disciplines`
	ADD COLUMN `discipline_code_id` INT(11) NULL DEFAULT NULL AFTER `module_discipline_player_count`,
	ADD CONSTRAINT `FK_module_disciplines_discipline_code_id` FOREIGN KEY (`discipline_code_id`) REFERENCES `discipline_codes` (`id`) ON UPDATE RESTRICT;

ALTER TABLE `user_questions`
	ADD COLUMN `sent_to_detran` TINYINT(1) NOT NULL DEFAULT '0' AFTER `modified`;
