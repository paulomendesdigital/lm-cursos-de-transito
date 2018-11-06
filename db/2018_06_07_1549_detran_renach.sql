ALTER TABLE `order_courses`
  ADD COLUMN `cnh_category` VARCHAR(10) NULL AFTER `error_count_detran`,
  ADD COLUMN `renach` VARCHAR(11) NULL AFTER `cnh_category`;
