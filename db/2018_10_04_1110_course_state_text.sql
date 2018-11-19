ALTER TABLE `course_states`
  ADD COLUMN `description` TEXT NULL AFTER `course_city_count`,
  ADD COLUMN `text` TEXT NULL AFTER `description`;
