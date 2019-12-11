ALTER TABLE `#__alumnidirectory` DROP COLUMN `Religion`;
ALTER TABLE `#__alumnidirectory` ADD COLUMN `Nickname` VARCHAR(255) NOT NULL AFTER `Last_Name`;
ALTER TABLE `#__alumnidirectory` ADD COLUMN `Deceased` VARCHAR(255) NOT NULL;