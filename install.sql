ALTER TABLE `prefix_topic` ADD COLUMN `lat` DECIMAL (10,7) NOT NULL DEFAULT '0';
ALTER TABLE `prefix_topic` ADD COLUMN `long` DECIMAL (10,7) NOT NULL DEFAULT '0';

ALTER TABLE `prefix_topic` ADD KEY `long` (`long`);
ALTER TABLE `prefix_topic` ADD KEY `lat` (`lat`);