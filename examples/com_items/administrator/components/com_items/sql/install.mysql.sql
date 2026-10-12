CREATE TABLE IF NOT EXISTS `#__items` (
	`id` INT NOT NULL AUTO_INCREMENT,
	`title` VARCHAR(255) NOT NULL DEFAULT '',
	`description` TEXT NOT NULL,
	`state` TINYINT NOT NULL DEFAULT 1,
	PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 DEFAULT COLLATE=utf8mb4_unicode_ci;

INSERT INTO `#__items` (`title`, `description`, `state`) VALUES
('First item', 'Sample description for the first item.', 1),
('Second item', 'Sample description for the second item.', 1);
