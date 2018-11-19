ALTER TABLE `carts`
  ADD COLUMN `renach` VARCHAR(11) NULL AFTER `modified`,
  ADD COLUMN `cnh_category` VARCHAR(2) NULL AFTER `renach`;

ALTER TABLE `users`
  ADD COLUMN `facebook_id` VARCHAR(255) NULL AFTER `status`;

