#ALTER TABLE `prefix_topic` DROP COLUMN `lat` ;
#ALTER TABLE `prefix_topic` DROP COLUMN `long` ;

ALTER TABLE `prefix_topic` ADD COLUMN `lat` DECIMAL (16,13) NOT NULL DEFAULT '0';
ALTER TABLE `prefix_topic` ADD COLUMN `long` DECIMAL (16,13) NOT NULL DEFAULT '0';

ALTER TABLE `prefix_topic` ADD KEY `long` (`long`);
ALTER TABLE `prefix_topic` ADD KEY `lat` (`lat`);