ALTER TABLE `carts`
  ADD COLUMN `cnh` VARCHAR(11) NULL AFTER `renach`;

ALTER TABLE `order_courses`
  ADD COLUMN `cnh` VARCHAR(11) NULL DEFAULT NULL AFTER `last_exec_detran`;
