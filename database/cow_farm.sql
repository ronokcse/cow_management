-- গরু খামার ম্যানেজমেন্ট — Laragon/MySQL এ ইম্পোর্ট করুন
-- ডাটাবেজ তৈরি: CREATE DATABASE cow_farm CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

DROP TABLE IF EXISTS `daily_feeding`;
DROP TABLE IF EXISTS `food_purchases`;
DROP TABLE IF EXISTS `investments`;
DROP TABLE IF EXISTS `incomes`;
DROP TABLE IF EXISTS `other_expenses`;
DROP TABLE IF EXISTS `food_types`;

SET FOREIGN_KEY_CHECKS = 1;

CREATE TABLE `food_types` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(120) NOT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `investments` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `amount` decimal(14,2) NOT NULL,
  `investment_date` date NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `investment_date` (`investment_date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `food_purchases` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `food_type_id` int(11) UNSIGNED NOT NULL,
  `quantity_kg` decimal(12,2) NOT NULL,
  `total_amount` decimal(14,2) NOT NULL,
  `purchase_date` date NOT NULL,
  `notes` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `food_type_id` (`food_type_id`),
  KEY `purchase_date` (`purchase_date`),
  CONSTRAINT `fk_fp_food_type` FOREIGN KEY (`food_type_id`) REFERENCES `food_types` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `daily_feeding` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `food_type_id` int(11) UNSIGNED NOT NULL,
  `feeding_date` date NOT NULL,
  `quantity_kg` decimal(12,2) NOT NULL,
  `notes` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `food_type_id` (`food_type_id`),
  KEY `feeding_date` (`feeding_date`),
  CONSTRAINT `fk_df_food_type` FOREIGN KEY (`food_type_id`) REFERENCES `food_types` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `incomes` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `amount` decimal(14,2) NOT NULL,
  `income_date` date NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `income_date` (`income_date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `other_expenses` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `amount` decimal(14,2) NOT NULL,
  `expense_date` date NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `expense_date` (`expense_date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `food_types` (`name`, `sort_order`) VALUES
('ঘাস / সবুজ খাদ্য', 1),
('খড়', 2),
('দানাদার (ভুসি/খৈল)', 3),
('খড়ি / ভুসি', 4),
('অন্যান্য', 99);

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT IGNORE INTO `users` (`name`, `username`, `password`) VALUES
('Admin', 'admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi');
