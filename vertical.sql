-- --------------------------------------------------------
-- Host:                         localhost
-- Versión del servidor:         5.7.19 - MySQL Community Server (GPL)
-- SO del servidor:              Win64
-- HeidiSQL Versión:             9.4.0.5125
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Volcando estructura de base de datos para vertical
CREATE DATABASE IF NOT EXISTS `vertical` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `vertical`;

-- Volcando estructura para tabla vertical.accounts
CREATE TABLE IF NOT EXISTS `accounts` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` date NOT NULL,
  `number` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amount` double(14,2) DEFAULT NULL,
  `current_amount` double(14,2) DEFAULT NULL,
  `cash_amount` double(14,2) DEFAULT NULL,
  `state` tinyint(1) NOT NULL DEFAULT '1',
  `note` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  FULLTEXT KEY `idx_full_title` (`title`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla vertical.accounts: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `accounts` DISABLE KEYS */;
INSERT INTO `accounts` (`id`, `title`, `date`, `number`, `amount`, `current_amount`, `cash_amount`, `state`, `note`, `deleted_at`, `created_at`, `updated_at`) VALUES
	(1, 'Banco ganadero', '2018-07-07', '123456789', 3053485.00, 242817.02, 242817.02, 1, NULL, NULL, '2020-04-24 16:42:33', '2020-06-22 11:34:48');
/*!40000 ALTER TABLE `accounts` ENABLE KEYS */;

-- Volcando estructura para tabla vertical.account_box
CREATE TABLE IF NOT EXISTS `account_box` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `box_id` int(10) unsigned NOT NULL,
  `account_id` int(10) unsigned NOT NULL,
  `income` double(14,2) NOT NULL,
  `expense` double(14,2) NOT NULL,
  `balance` double(14,2) NOT NULL,
  `cash` double(14,2) NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `account_box_box_id_foreign` (`box_id`),
  KEY `account_box_account_id_foreign` (`account_id`),
  CONSTRAINT `account_box_account_id_foreign` FOREIGN KEY (`account_id`) REFERENCES `accounts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `account_box_box_id_foreign` FOREIGN KEY (`box_id`) REFERENCES `boxes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla vertical.account_box: ~2 rows (aproximadamente)
/*!40000 ALTER TABLE `account_box` DISABLE KEYS */;
INSERT INTO `account_box` (`id`, `box_id`, `account_id`, `income`, `expense`, `balance`, `cash`, `deleted_at`, `created_at`, `updated_at`) VALUES
	(1, 1, 1, 3053485.00, 2795719.98, 257765.02, 257765.02, NULL, '2020-05-07 19:27:08', '2020-05-07 19:27:08'),
	(2, 2, 1, 7000.00, 21948.00, 242817.02, 239295.83, NULL, '2020-06-05 09:58:23', '2020-06-05 09:58:23');
/*!40000 ALTER TABLE `account_box` ENABLE KEYS */;

-- Volcando estructura para tabla vertical.actions
CREATE TABLE IF NOT EXISTS `actions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `method` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `order` int(11) NOT NULL,
  `title` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=72 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla vertical.actions: ~71 rows (aproximadamente)
/*!40000 ALTER TABLE `actions` DISABLE KEYS */;
INSERT INTO `actions` (`id`, `name`, `method`, `order`, `title`, `created_at`, `updated_at`) VALUES
	(1, 'Acesso total al sistema', '*', 1, 'Sistema', '2019-07-23 22:29:16', '2019-07-23 22:29:16'),
	(2, 'Ver Lista', 'material-types.index', 2, 'Tipos de Material', '2019-07-23 22:29:17', '2019-07-23 22:29:17'),
	(3, 'Registrar', 'material-types.create', 3, 'Tipos de Material', '2019-07-23 22:29:17', '2019-07-23 22:29:17'),
	(4, 'Ver Detalle', 'material-types.show', 4, 'Tipos de Material', '2019-07-23 22:29:17', '2019-07-23 22:29:17'),
	(5, 'Actualizar', 'material-types.update', 5, 'Tipos de Material', '2019-07-23 22:29:17', '2019-07-23 22:29:17'),
	(6, 'Eliminar', 'material-types.destroy', 6, 'Tipos de Material', '2019-07-23 22:29:17', '2019-07-23 22:29:17'),
	(7, 'Ver Lista', 'materials.index', 7, 'Materiales', '2019-07-23 22:29:18', '2019-07-23 22:29:18'),
	(8, 'Registrar', 'materials.create', 8, 'Materiales', '2019-07-23 22:29:18', '2019-07-23 22:29:18'),
	(9, 'Ver Detalle', 'materials.show', 9, 'Materiales', '2019-07-23 22:29:18', '2019-07-23 22:29:18'),
	(10, 'Actualizar', 'materials.update', 10, 'Materiales', '2019-07-23 22:29:18', '2019-07-23 22:29:18'),
	(11, 'Eliminar', 'materials.destroy', 11, 'Materiales', '2019-07-23 22:29:18', '2019-07-23 22:29:18'),
	(12, 'Ver Lista', 'project-types.index', 12, 'Tipos de Proyecto', '2019-07-23 22:29:18', '2019-07-23 22:29:18'),
	(13, 'Registrar', 'project-types.create', 13, 'Tipos de Proyecto', '2019-07-23 22:29:18', '2019-07-23 22:29:18'),
	(14, 'Ver Detalle', 'project-types.show', 14, 'Tipos de Proyecto', '2019-07-23 22:29:18', '2019-07-23 22:29:18'),
	(15, 'Actualizar', 'project-types.update', 15, 'Tipos de Proyecto', '2019-07-23 22:29:18', '2019-07-23 22:29:18'),
	(16, 'Eliminar', 'project-types.destroy', 16, 'Tipos de Proyecto', '2019-07-23 22:29:18', '2019-07-23 22:29:18'),
	(17, 'Ver Lista', 'projects.index', 17, 'Proyectos', '2019-07-23 22:29:18', '2019-07-23 22:29:18'),
	(18, 'Registrar', 'projects.create', 18, 'Proyectos', '2019-07-23 22:29:18', '2019-07-23 22:29:18'),
	(19, 'Ver Detalle', 'projects.show', 19, 'Proyectos', '2019-07-23 22:29:18', '2019-07-23 22:29:18'),
	(20, 'Actualizar', 'projects.update', 20, 'Proyectos', '2019-07-23 22:29:18', '2019-07-23 22:29:18'),
	(21, 'Eliminar', 'projects.destroy', 21, 'Proyectos', '2019-07-23 22:29:18', '2019-07-23 22:29:18'),
	(22, 'Ver Lista', 'expense-types.index', 22, 'Tipos de Egreso', '2019-07-23 22:29:18', '2019-07-23 22:29:18'),
	(23, 'Registrar', 'expense-types.create', 23, 'Tipos de Egreso', '2019-07-23 22:29:18', '2019-07-23 22:29:18'),
	(24, 'Ver Detalle', 'expense-types.show', 24, 'Tipos de Egreso', '2019-07-23 22:29:19', '2019-07-23 22:29:19'),
	(25, 'Actualizar', 'expense-types.update', 25, 'Tipos de Egreso', '2019-07-23 22:29:19', '2019-07-23 22:29:19'),
	(26, 'Eliminar', 'expense-types.destroy', 26, 'Tipos de Egreso', '2019-07-23 22:29:19', '2019-07-23 22:29:19'),
	(27, 'Ver Lista', 'expenses.index', 27, 'Egresos', '2019-07-23 22:29:19', '2019-07-23 22:29:19'),
	(28, 'Registrar', 'expenses.create', 28, 'Egresos', '2019-07-23 22:29:19', '2019-07-23 22:29:19'),
	(29, 'Ver Detalle', 'expenses.show', 29, 'Egresos', '2019-07-23 22:29:19', '2019-07-23 22:29:19'),
	(30, 'Actualizar', 'expenses.update', 30, 'Egresos', '2019-07-23 22:29:19', '2019-07-23 22:29:19'),
	(31, 'Eliminar', 'expenses.destroy', 31, 'Egresos', '2019-07-23 22:29:19', '2019-07-23 22:29:19'),
	(32, 'Ver Lista', 'income-types.index', 32, 'Tipos de Ingreso', '2019-07-23 22:29:19', '2019-07-23 22:29:19'),
	(33, 'Registrar', 'income-types.create', 33, 'Tipos de Ingreso', '2019-07-23 22:29:19', '2019-07-23 22:29:19'),
	(34, 'Ver Detalle', 'income-types.show', 34, 'Tipos de Ingreso', '2019-07-23 22:29:19', '2019-07-23 22:29:19'),
	(35, 'Actualizar', 'income-types.update', 35, 'Tipos de Ingreso', '2019-07-23 22:29:19', '2019-07-23 22:29:19'),
	(36, 'Eliminar', 'income-types.destroy', 36, 'Tipos de Ingreso', '2019-07-23 22:29:19', '2019-07-23 22:29:19'),
	(37, 'Ver Lista', 'incomes.index', 37, 'Ingresos', '2019-07-23 22:29:19', '2019-07-23 22:29:19'),
	(38, 'Registrar', 'incomes.create', 38, 'Ingresos', '2019-07-23 22:29:19', '2019-07-23 22:29:19'),
	(39, 'Ver Detalle', 'incomes.show', 39, 'Ingresos', '2019-07-23 22:29:19', '2019-07-23 22:29:19'),
	(40, 'Actualizar', 'incomes.update', 40, 'Ingresos', '2019-07-23 22:29:19', '2019-07-23 22:29:19'),
	(41, 'Eliminar', 'incomes.destroy', 41, 'Ingresos', '2019-07-23 22:29:20', '2019-07-23 22:29:20'),
	(42, 'Ver Lista', 'profiles.index', 42, 'Perfiles', '2019-07-23 22:29:20', '2019-07-23 22:29:20'),
	(43, 'Registrar', 'profiles.create', 43, 'Perfiles', '2019-07-23 22:29:20', '2019-07-23 22:29:20'),
	(44, 'Actualizar', 'profiles.show|profiles.update', 44, 'Perfiles', '2019-07-23 22:29:20', '2019-07-23 22:29:20'),
	(45, 'Eliminar', 'profiles.destroy', 45, 'Perfiles', '2019-07-23 22:29:20', '2019-07-23 22:29:20'),
	(46, 'Ver Lista', 'people.index', 46, 'Personas', '2019-07-23 22:29:20', '2019-07-23 22:29:20'),
	(47, 'Registrar', 'people.create', 47, 'Personas', '2019-07-23 22:29:20', '2019-07-23 22:29:20'),
	(48, 'Ver Detalle', 'people.show', 48, 'Personas', '2019-07-23 22:29:20', '2019-07-23 22:29:20'),
	(49, 'Actualizar', 'people.update', 49, 'Personas', '2019-07-23 22:29:20', '2019-07-23 22:29:20'),
	(50, 'Eliminar', 'people.destroy', 50, 'Personas', '2019-07-23 22:29:20', '2019-07-23 22:29:20'),
	(51, 'Ver Lista', 'users.index', 51, 'Usuarios', '2019-07-23 22:29:20', '2019-07-23 22:29:20'),
	(52, 'Registrar', 'users.create', 52, 'Usuarios', '2019-07-23 22:29:20', '2019-07-23 22:29:20'),
	(53, 'Ver Detalle', 'users.show', 53, 'Usuarios', '2019-07-23 22:29:20', '2019-07-23 22:29:20'),
	(54, 'Actualizar', 'users.update', 54, 'Usuarios', '2019-07-23 22:29:20', '2019-07-23 22:29:20'),
	(55, 'Eliminar', 'users.destroy', 55, 'Usuarios', '2019-07-23 22:29:20', '2019-07-23 22:29:20'),
	(56, 'Ver Lista', 'accounts.index', 56, 'Cuentas', '2019-07-23 22:29:20', '2019-07-23 22:29:20'),
	(57, 'Registrar', 'accounts.create', 57, 'Cuentas', '2019-08-29 15:42:27', '2019-08-29 15:42:27'),
	(58, 'Ver Detalle', 'accounts.show', 58, 'Cuentas', '2019-08-29 15:42:55', '2019-08-29 15:42:56'),
	(59, 'Actualizar', 'accounts.update', 59, 'Cuentas', '2019-08-29 15:43:20', '2019-08-29 15:43:21'),
	(60, 'Eliminar', 'accounts.destroy', 60, 'Cuentas', '2019-08-29 15:43:43', '2019-08-29 15:43:43'),
	(61, 'Ver Lista', 'boxes.index', 61, 'Caja General', '2019-08-29 15:44:39', '2019-08-29 15:44:39'),
	(62, 'Registrar', 'boxes.create', 62, 'Caja General', '2019-08-29 15:45:17', '2019-08-29 15:45:18'),
	(63, 'Ver Detalle', 'boxes.show', 63, 'Caja General', '2019-08-29 15:45:43', '2019-08-29 15:45:44'),
	(64, 'Actualizar', 'boxes.update', 64, 'Caja General', '2019-08-29 15:46:03', '2019-08-29 15:46:03'),
	(65, 'Eliminar', 'boxes.destroy', 65, 'Caja General', '2019-08-29 15:46:26', '2019-08-29 15:46:27'),
	(66, 'Ver Lista', 'small-boxes.index', 66, 'Caja Chica', '2019-08-29 15:46:49', '2019-08-29 15:46:49'),
	(67, 'Registrar', 'small-boxes.create', 67, 'Caja Chica', '2019-10-02 23:33:24', '2019-10-02 23:33:24'),
	(68, 'Ver Detalle', 'small-boxes.show', 68, 'Caja Chica', '2019-10-02 23:34:03', '2019-10-02 23:34:04'),
	(69, 'Actualizar', 'small-boxes.update', 69, 'Caja Chica', '2019-10-02 23:34:42', '2019-10-02 23:34:43'),
	(70, 'Eliminar', 'small-boxes.destroy', 70, 'Caja Chica', '2019-10-02 23:35:09', '2019-10-02 23:35:09'),
	(71, 'Ver Todos', 'reports.index', 71, 'Informes', '2019-10-02 23:35:55', '2019-10-02 23:35:58');
/*!40000 ALTER TABLE `actions` ENABLE KEYS */;

-- Volcando estructura para tabla vertical.action_profile
CREATE TABLE IF NOT EXISTS `action_profile` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `action_id` int(10) unsigned NOT NULL,
  `profile_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `action_profile_action_id_foreign` (`action_id`),
  KEY `action_profile_profile_id_foreign` (`profile_id`),
  CONSTRAINT `action_profile_action_id_foreign` FOREIGN KEY (`action_id`) REFERENCES `actions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `action_profile_profile_id_foreign` FOREIGN KEY (`profile_id`) REFERENCES `profiles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla vertical.action_profile: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `action_profile` DISABLE KEYS */;
INSERT INTO `action_profile` (`id`, `action_id`, `profile_id`, `created_at`, `updated_at`) VALUES
	(1, 1, 1, '2019-10-17 11:17:14', '2019-10-17 11:17:15');
/*!40000 ALTER TABLE `action_profile` ENABLE KEYS */;

-- Volcando estructura para tabla vertical.activity_log
CREATE TABLE IF NOT EXISTS `activity_log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `log_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `subject_id` int(11) DEFAULT NULL,
  `subject_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `causer_id` int(11) DEFAULT NULL,
  `causer_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `properties` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `activity_log_log_name_index` (`log_name`)
) ENGINE=InnoDB AUTO_INCREMENT=334 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla vertical.activity_log: ~322 rows (aproximadamente)
/*!40000 ALTER TABLE `activity_log` DISABLE KEYS */;
INSERT INTO `activity_log` (`id`, `log_name`, `description`, `subject_id`, `subject_type`, `causer_id`, `causer_type`, `properties`, `created_at`, `updated_at`) VALUES
	(1, 'default', 'created', 1, 'App\\ProjectType', 1, 'App\\User', '[]', '2020-04-24 16:28:34', '2020-04-24 16:28:34'),
	(2, 'default', 'updated', 1, 'App\\ProjectType', 1, 'App\\User', '[]', '2020-04-24 16:28:53', '2020-04-24 16:28:53'),
	(3, 'default', 'created', 2, 'App\\ProjectType', 1, 'App\\User', '[]', '2020-04-24 16:30:33', '2020-04-24 16:30:33'),
	(4, 'default', 'created', 3, 'App\\ProjectType', 1, 'App\\User', '[]', '2020-04-24 16:30:58', '2020-04-24 16:30:58'),
	(5, 'default', 'created', 4, 'App\\ProjectType', 1, 'App\\User', '[]', '2020-04-24 16:32:08', '2020-04-24 16:32:08'),
	(6, 'default', 'created', 1, 'App\\Project', 1, 'App\\User', '[]', '2020-04-24 16:36:02', '2020-04-24 16:36:02'),
	(7, 'default', 'created', 1, 'App\\IncomeType', 1, 'App\\User', '[]', '2020-04-24 16:37:27', '2020-04-24 16:37:27'),
	(8, 'default', 'created', 1, 'App\\Account', 1, 'App\\User', '[]', '2020-04-24 16:42:33', '2020-04-24 16:42:33'),
	(9, 'default', 'created', 1, 'App\\Income', 1, 'App\\User', '[]', '2020-04-24 16:43:58', '2020-04-24 16:43:58'),
	(10, 'default', 'updated', 1, 'App\\Income', 1, 'App\\User', '[]', '2020-04-24 16:45:05', '2020-04-24 16:45:05'),
	(11, 'default', 'created', 1, 'App\\ExpenseType', 1, 'App\\User', '[]', '2020-04-24 16:46:01', '2020-04-24 16:46:01'),
	(12, 'default', 'created', 1, 'App\\SmallBox', 1, 'App\\User', '[]', '2020-04-24 16:47:34', '2020-04-24 16:47:34'),
	(13, 'default', 'created', 1, 'App\\Expense', 1, 'App\\User', '[]', '2020-04-24 16:49:49', '2020-04-24 16:49:49'),
	(14, 'default', 'updated', 1, 'App\\Project', 1, 'App\\User', '[]', '2020-04-24 16:54:54', '2020-04-24 16:54:54'),
	(15, 'default', 'updated', 1, 'App\\Project', 1, 'App\\User', '[]', '2020-04-24 16:54:59', '2020-04-24 16:54:59'),
	(16, 'default', 'updated', 1, 'App\\Project', 1, 'App\\User', '[]', '2020-04-24 16:55:03', '2020-04-24 16:55:03'),
	(17, 'default', 'created', 2, 'App\\Project', 1, 'App\\User', '[]', '2020-04-27 11:28:41', '2020-04-27 11:28:41'),
	(18, 'default', 'created', 2, 'App\\Income', 1, 'App\\User', '[]', '2020-04-27 11:34:26', '2020-04-27 11:34:26'),
	(19, 'default', 'created', 5, 'App\\ProjectType', 1, 'App\\User', '[]', '2020-04-27 14:22:00', '2020-04-27 14:22:00'),
	(20, 'default', 'created', 3, 'App\\Project', 1, 'App\\User', '[]', '2020-04-27 14:24:35', '2020-04-27 14:24:35'),
	(21, 'default', 'created', 3, 'App\\Income', 1, 'App\\User', '[]', '2020-04-27 14:25:39', '2020-04-27 14:25:39'),
	(22, 'default', 'created', 6, 'App\\ProjectType', 1, 'App\\User', '[]', '2020-04-27 14:38:47', '2020-04-27 14:38:47'),
	(23, 'default', 'created', 4, 'App\\Project', 1, 'App\\User', '[]', '2020-04-27 14:40:15', '2020-04-27 14:40:15'),
	(24, 'default', 'created', 5, 'App\\Project', 1, 'App\\User', '[]', '2020-04-27 14:41:09', '2020-04-27 14:41:09'),
	(25, 'default', 'created', 6, 'App\\Project', 1, 'App\\User', '[]', '2020-04-27 14:41:49', '2020-04-27 14:41:49'),
	(26, 'default', 'created', 4, 'App\\Income', 1, 'App\\User', '[]', '2020-04-27 14:42:47', '2020-04-27 14:42:47'),
	(27, 'default', 'created', 5, 'App\\Income', 1, 'App\\User', '[]', '2020-04-27 14:43:23', '2020-04-27 14:43:23'),
	(28, 'default', 'created', 6, 'App\\Income', 1, 'App\\User', '[]', '2020-04-27 14:44:00', '2020-04-27 14:44:00'),
	(29, 'default', 'updated', 4, 'App\\Project', 1, 'App\\User', '[]', '2020-04-27 14:44:20', '2020-04-27 14:44:20'),
	(30, 'default', 'updated', 4, 'App\\Project', 1, 'App\\User', '[]', '2020-04-27 14:44:30', '2020-04-27 14:44:30'),
	(31, 'default', 'created', 7, 'App\\Project', 1, 'App\\User', '[]', '2020-04-27 14:48:01', '2020-04-27 14:48:01'),
	(32, 'default', 'updated', 6, 'App\\Project', 1, 'App\\User', '[]', '2020-04-27 14:49:59', '2020-04-27 14:49:59'),
	(33, 'default', 'updated', 5, 'App\\Project', 1, 'App\\User', '[]', '2020-04-27 14:50:18', '2020-04-27 14:50:18'),
	(34, 'default', 'updated', 4, 'App\\Project', 1, 'App\\User', '[]', '2020-04-27 14:51:14', '2020-04-27 14:51:14'),
	(35, 'default', 'created', 8, 'App\\Project', 1, 'App\\User', '[]', '2020-04-27 14:53:02', '2020-04-27 14:53:02'),
	(36, 'default', 'created', 7, 'App\\Income', 1, 'App\\User', '[]', '2020-04-27 14:55:42', '2020-04-27 14:55:42'),
	(37, 'default', 'created', 8, 'App\\Income', 1, 'App\\User', '[]', '2020-04-27 14:56:24', '2020-04-27 14:56:24'),
	(38, 'default', 'created', 9, 'App\\Project', 1, 'App\\User', '[]', '2020-04-27 14:57:58', '2020-04-27 14:57:58'),
	(39, 'default', 'created', 9, 'App\\Income', 1, 'App\\User', '[]', '2020-04-27 14:58:47', '2020-04-27 14:58:47'),
	(40, 'default', 'created', 10, 'App\\Project', 1, 'App\\User', '[]', '2020-04-29 10:26:43', '2020-04-29 10:26:43'),
	(41, 'default', 'created', 10, 'App\\Income', 1, 'App\\User', '[]', '2020-04-29 10:27:28', '2020-04-29 10:27:28'),
	(42, 'default', 'updated', 10, 'App\\Income', 1, 'App\\User', '[]', '2020-04-29 10:27:44', '2020-04-29 10:27:44'),
	(43, 'default', 'created', 11, 'App\\Project', 1, 'App\\User', '[]', '2020-04-29 10:29:30', '2020-04-29 10:29:30'),
	(44, 'default', 'created', 11, 'App\\Income', 1, 'App\\User', '[]', '2020-04-29 10:30:22', '2020-04-29 10:30:22'),
	(45, 'default', 'created', 12, 'App\\Project', 1, 'App\\User', '[]', '2020-04-29 10:38:32', '2020-04-29 10:38:32'),
	(46, 'default', 'created', 12, 'App\\Income', 1, 'App\\User', '[]', '2020-04-29 10:39:26', '2020-04-29 10:39:26'),
	(47, 'default', 'created', 13, 'App\\Project', 1, 'App\\User', '[]', '2020-04-29 10:42:16', '2020-04-29 10:42:16'),
	(48, 'default', 'created', 13, 'App\\Income', 1, 'App\\User', '[]', '2020-04-29 10:43:08', '2020-04-29 10:43:08'),
	(49, 'default', 'created', 7, 'App\\ProjectType', 1, 'App\\User', '[]', '2020-04-29 10:44:58', '2020-04-29 10:44:58'),
	(50, 'default', 'created', 14, 'App\\Project', 1, 'App\\User', '[]', '2020-04-29 10:46:31', '2020-04-29 10:46:31'),
	(51, 'default', 'created', 14, 'App\\Income', 1, 'App\\User', '[]', '2020-04-29 10:47:06', '2020-04-29 10:47:06'),
	(52, 'default', 'created', 15, 'App\\Project', 1, 'App\\User', '[]', '2020-04-29 10:50:37', '2020-04-29 10:50:37'),
	(53, 'default', 'created', 15, 'App\\Income', 1, 'App\\User', '[]', '2020-04-29 10:51:41', '2020-04-29 10:51:41'),
	(54, 'default', 'updated', 15, 'App\\Project', 1, 'App\\User', '[]', '2020-04-29 10:52:51', '2020-04-29 10:52:51'),
	(55, 'default', 'created', 16, 'App\\Project', 1, 'App\\User', '[]', '2020-04-29 10:56:03', '2020-04-29 10:56:03'),
	(56, 'default', 'created', 16, 'App\\Income', 1, 'App\\User', '[]', '2020-04-29 10:57:12', '2020-04-29 10:57:12'),
	(57, 'default', 'created', 17, 'App\\Project', 1, 'App\\User', '[]', '2020-04-29 11:00:32', '2020-04-29 11:00:32'),
	(58, 'default', 'created', 17, 'App\\Income', 1, 'App\\User', '[]', '2020-04-29 11:01:33', '2020-04-29 11:01:33'),
	(59, 'default', 'created', 8, 'App\\ProjectType', 1, 'App\\User', '[]', '2020-04-29 11:55:28', '2020-04-29 11:55:28'),
	(60, 'default', 'created', 18, 'App\\Project', 1, 'App\\User', '[]', '2020-04-29 11:56:08', '2020-04-29 11:56:08'),
	(61, 'default', 'created', 18, 'App\\Income', 1, 'App\\User', '[]', '2020-04-29 11:56:47', '2020-04-29 11:56:47'),
	(62, 'default', 'created', 19, 'App\\Project', 1, 'App\\User', '[]', '2020-04-29 14:36:35', '2020-04-29 14:36:35'),
	(63, 'default', 'created', 19, 'App\\Income', 1, 'App\\User', '[]', '2020-04-29 14:37:07', '2020-04-29 14:37:07'),
	(64, 'default', 'created', 20, 'App\\Project', 1, 'App\\User', '[]', '2020-04-29 14:38:53', '2020-04-29 14:38:53'),
	(65, 'default', 'created', 20, 'App\\Income', 1, 'App\\User', '[]', '2020-04-29 14:39:49', '2020-04-29 14:39:49'),
	(66, 'default', 'updated', 20, 'App\\Income', 1, 'App\\User', '[]', '2020-04-29 14:55:57', '2020-04-29 14:55:57'),
	(67, 'default', 'created', 9, 'App\\ProjectType', 1, 'App\\User', '[]', '2020-04-29 14:57:40', '2020-04-29 14:57:40'),
	(68, 'default', 'created', 21, 'App\\Project', 1, 'App\\User', '[]', '2020-04-29 14:58:19', '2020-04-29 14:58:19'),
	(69, 'default', 'created', 21, 'App\\Income', 1, 'App\\User', '[]', '2020-04-29 14:59:16', '2020-04-29 14:59:16'),
	(70, 'default', 'created', 22, 'App\\Project', 1, 'App\\User', '[]', '2020-04-29 15:15:56', '2020-04-29 15:15:56'),
	(71, 'default', 'created', 22, 'App\\Income', 1, 'App\\User', '[]', '2020-04-29 15:16:54', '2020-04-29 15:16:54'),
	(72, 'default', 'created', 23, 'App\\Project', 1, 'App\\User', '[]', '2020-04-29 15:18:45', '2020-04-29 15:18:45'),
	(73, 'default', 'created', 23, 'App\\Income', 1, 'App\\User', '[]', '2020-04-29 15:19:53', '2020-04-29 15:19:53'),
	(74, 'default', 'created', 24, 'App\\Project', 1, 'App\\User', '[]', '2020-04-29 15:21:52', '2020-04-29 15:21:52'),
	(75, 'default', 'created', 24, 'App\\Income', 1, 'App\\User', '[]', '2020-05-01 10:33:21', '2020-05-01 10:33:21'),
	(76, 'default', 'created', 25, 'App\\Project', 1, 'App\\User', '[]', '2020-05-01 10:35:09', '2020-05-01 10:35:09'),
	(77, 'default', 'created', 25, 'App\\Income', 1, 'App\\User', '[]', '2020-05-01 10:36:14', '2020-05-01 10:36:14'),
	(78, 'default', 'created', 26, 'App\\Project', 1, 'App\\User', '[]', '2020-05-01 10:39:49', '2020-05-01 10:39:49'),
	(79, 'default', 'created', 26, 'App\\Income', 1, 'App\\User', '[]', '2020-05-01 10:40:39', '2020-05-01 10:40:39'),
	(80, 'default', 'created', 27, 'App\\Project', 1, 'App\\User', '[]', '2020-05-01 10:44:47', '2020-05-01 10:44:47'),
	(81, 'default', 'created', 27, 'App\\Income', 1, 'App\\User', '[]', '2020-05-01 10:48:41', '2020-05-01 10:48:41'),
	(82, 'default', 'created', 28, 'App\\Project', 1, 'App\\User', '[]', '2020-05-01 10:51:51', '2020-05-01 10:51:51'),
	(83, 'default', 'created', 28, 'App\\Income', 1, 'App\\User', '[]', '2020-05-01 10:52:32', '2020-05-01 10:52:32'),
	(84, 'default', 'created', 29, 'App\\Project', 1, 'App\\User', '[]', '2020-05-01 10:54:21', '2020-05-01 10:54:21'),
	(85, 'default', 'created', 29, 'App\\Income', 1, 'App\\User', '[]', '2020-05-01 10:54:59', '2020-05-01 10:54:59'),
	(86, 'default', 'created', 30, 'App\\Project', 1, 'App\\User', '[]', '2020-05-01 10:56:15', '2020-05-01 10:56:15'),
	(87, 'default', 'created', 30, 'App\\Income', 1, 'App\\User', '[]', '2020-05-01 10:57:23', '2020-05-01 10:57:23'),
	(88, 'default', 'created', 31, 'App\\Project', 1, 'App\\User', '[]', '2020-05-01 10:58:58', '2020-05-01 10:58:58'),
	(89, 'default', 'updated', 31, 'App\\Project', 1, 'App\\User', '[]', '2020-05-01 11:00:32', '2020-05-01 11:00:32'),
	(90, 'default', 'created', 31, 'App\\Income', 1, 'App\\User', '[]', '2020-05-01 11:01:10', '2020-05-01 11:01:10'),
	(91, 'default', 'created', 32, 'App\\Project', 1, 'App\\User', '[]', '2020-05-01 11:03:08', '2020-05-01 11:03:08'),
	(92, 'default', 'created', 32, 'App\\Income', 1, 'App\\User', '[]', '2020-05-01 11:04:46', '2020-05-01 11:04:46'),
	(93, 'default', 'created', 33, 'App\\Project', 1, 'App\\User', '[]', '2020-05-01 11:06:19', '2020-05-01 11:06:19'),
	(94, 'default', 'created', 33, 'App\\Income', 1, 'App\\User', '[]', '2020-05-01 11:18:42', '2020-05-01 11:18:42'),
	(95, 'default', 'created', 34, 'App\\Project', 1, 'App\\User', '[]', '2020-05-01 11:21:14', '2020-05-01 11:21:14'),
	(96, 'default', 'created', 34, 'App\\Income', 1, 'App\\User', '[]', '2020-05-01 11:22:06', '2020-05-01 11:22:06'),
	(97, 'default', 'created', 10, 'App\\ProjectType', 1, 'App\\User', '[]', '2020-05-01 11:23:36', '2020-05-01 11:23:36'),
	(98, 'default', 'created', 35, 'App\\Project', 1, 'App\\User', '[]', '2020-05-01 11:24:22', '2020-05-01 11:24:22'),
	(99, 'default', 'updated', 35, 'App\\Project', 1, 'App\\User', '[]', '2020-05-01 11:25:55', '2020-05-01 11:25:55'),
	(100, 'default', 'created', 35, 'App\\Income', 1, 'App\\User', '[]', '2020-05-01 11:26:50', '2020-05-01 11:26:50'),
	(101, 'default', 'created', 36, 'App\\Project', 1, 'App\\User', '[]', '2020-05-01 11:28:43', '2020-05-01 11:28:43'),
	(102, 'default', 'created', 36, 'App\\Income', 1, 'App\\User', '[]', '2020-05-01 11:29:24', '2020-05-01 11:29:24'),
	(103, 'default', 'created', 37, 'App\\Project', 1, 'App\\User', '[]', '2020-05-01 11:31:47', '2020-05-01 11:31:47'),
	(104, 'default', 'created', 37, 'App\\Income', 1, 'App\\User', '[]', '2020-05-01 11:32:54', '2020-05-01 11:32:54'),
	(105, 'default', 'created', 38, 'App\\Project', 1, 'App\\User', '[]', '2020-05-01 11:35:11', '2020-05-01 11:35:11'),
	(106, 'default', 'created', 38, 'App\\Income', 1, 'App\\User', '[]', '2020-05-01 11:35:50', '2020-05-01 11:35:50'),
	(107, 'default', 'created', 39, 'App\\Project', 1, 'App\\User', '[]', '2020-05-04 09:21:42', '2020-05-04 09:21:42'),
	(108, 'default', 'created', 39, 'App\\Income', 1, 'App\\User', '[]', '2020-05-04 09:22:38', '2020-05-04 09:22:38'),
	(109, 'default', 'created', 40, 'App\\Project', 1, 'App\\User', '[]', '2020-05-04 09:41:12', '2020-05-04 09:41:12'),
	(110, 'default', 'created', 40, 'App\\Income', 1, 'App\\User', '[]', '2020-05-04 09:45:48', '2020-05-04 09:45:48'),
	(111, 'default', 'created', 41, 'App\\Project', 1, 'App\\User', '[]', '2020-05-04 09:46:59', '2020-05-04 09:46:59'),
	(112, 'default', 'created', 41, 'App\\Income', 1, 'App\\User', '[]', '2020-05-04 09:48:27', '2020-05-04 09:48:27'),
	(113, 'default', 'created', 42, 'App\\Project', 1, 'App\\User', '[]', '2020-05-04 09:50:46', '2020-05-04 09:50:46'),
	(114, 'default', 'deleted', 42, 'App\\Project', 1, 'App\\User', '[]', '2020-05-04 09:52:34', '2020-05-04 09:52:34'),
	(115, 'default', 'updated', 28, 'App\\Income', 1, 'App\\User', '[]', '2020-05-04 09:53:53', '2020-05-04 09:53:53'),
	(116, 'default', 'created', 43, 'App\\Project', 1, 'App\\User', '[]', '2020-05-04 09:56:14', '2020-05-04 09:56:14'),
	(117, 'default', 'created', 42, 'App\\Income', 1, 'App\\User', '[]', '2020-05-04 09:57:05', '2020-05-04 09:57:05'),
	(118, 'default', 'created', 44, 'App\\Project', 1, 'App\\User', '[]', '2020-05-04 09:58:45', '2020-05-04 09:58:45'),
	(119, 'default', 'created', 43, 'App\\Income', 1, 'App\\User', '[]', '2020-05-04 09:59:47', '2020-05-04 09:59:47'),
	(120, 'default', 'created', 45, 'App\\Project', 1, 'App\\User', '[]', '2020-05-04 10:01:41', '2020-05-04 10:01:41'),
	(121, 'default', 'created', 44, 'App\\Income', 1, 'App\\User', '[]', '2020-05-04 10:02:38', '2020-05-04 10:02:38'),
	(122, 'default', 'created', 46, 'App\\Project', 1, 'App\\User', '[]', '2020-05-04 10:09:20', '2020-05-04 10:09:20'),
	(123, 'default', 'created', 45, 'App\\Income', 1, 'App\\User', '[]', '2020-05-04 10:10:19', '2020-05-04 10:10:19'),
	(124, 'default', 'created', 47, 'App\\Project', 1, 'App\\User', '[]', '2020-05-04 10:21:24', '2020-05-04 10:21:24'),
	(125, 'default', 'created', 46, 'App\\Income', 1, 'App\\User', '[]', '2020-05-04 10:25:10', '2020-05-04 10:25:10'),
	(126, 'default', 'created', 48, 'App\\Project', 1, 'App\\User', '[]', '2020-05-04 10:27:36', '2020-05-04 10:27:36'),
	(127, 'default', 'created', 47, 'App\\Income', 1, 'App\\User', '[]', '2020-05-04 10:42:47', '2020-05-04 10:42:47'),
	(128, 'default', 'created', 49, 'App\\Project', 1, 'App\\User', '[]', '2020-05-04 10:47:07', '2020-05-04 10:47:07'),
	(129, 'default', 'created', 48, 'App\\Income', 1, 'App\\User', '[]', '2020-05-04 10:47:52', '2020-05-04 10:47:52'),
	(130, 'default', 'created', 50, 'App\\Project', 1, 'App\\User', '[]', '2020-05-04 10:49:00', '2020-05-04 10:49:00'),
	(131, 'default', 'created', 49, 'App\\Income', 1, 'App\\User', '[]', '2020-05-04 10:55:41', '2020-05-04 10:55:41'),
	(132, 'default', 'created', 51, 'App\\Project', 1, 'App\\User', '[]', '2020-05-04 10:58:21', '2020-05-04 10:58:21'),
	(133, 'default', 'created', 50, 'App\\Income', 1, 'App\\User', '[]', '2020-05-04 10:59:57', '2020-05-04 10:59:57'),
	(134, 'default', 'created', 52, 'App\\Project', 1, 'App\\User', '[]', '2020-05-04 11:05:03', '2020-05-04 11:05:03'),
	(135, 'default', 'created', 51, 'App\\Income', 1, 'App\\User', '[]', '2020-05-04 11:05:42', '2020-05-04 11:05:42'),
	(136, 'default', 'created', 53, 'App\\Project', 1, 'App\\User', '[]', '2020-05-04 11:08:44', '2020-05-04 11:08:44'),
	(137, 'default', 'created', 52, 'App\\Income', 1, 'App\\User', '[]', '2020-05-04 11:29:16', '2020-05-04 11:29:16'),
	(138, 'default', 'created', 54, 'App\\Project', 1, 'App\\User', '[]', '2020-05-04 11:30:00', '2020-05-04 11:30:00'),
	(139, 'default', 'created', 53, 'App\\Income', 1, 'App\\User', '[]', '2020-05-04 11:30:43', '2020-05-04 11:30:43'),
	(140, 'default', 'created', 55, 'App\\Project', 1, 'App\\User', '[]', '2020-05-04 11:35:03', '2020-05-04 11:35:03'),
	(141, 'default', 'created', 54, 'App\\Income', 1, 'App\\User', '[]', '2020-05-04 11:35:43', '2020-05-04 11:35:43'),
	(142, 'default', 'created', 55, 'App\\Income', 1, 'App\\User', '[]', '2020-05-04 11:55:50', '2020-05-04 11:55:50'),
	(143, 'default', 'created', 56, 'App\\Project', 1, 'App\\User', '[]', '2020-05-04 14:33:08', '2020-05-04 14:33:08'),
	(144, 'default', 'created', 56, 'App\\Income', 1, 'App\\User', '[]', '2020-05-04 14:34:00', '2020-05-04 14:34:00'),
	(145, 'default', 'created', 57, 'App\\Project', 1, 'App\\User', '[]', '2020-05-04 14:37:11', '2020-05-04 14:37:11'),
	(146, 'default', 'created', 57, 'App\\Income', 1, 'App\\User', '[]', '2020-05-04 14:37:51', '2020-05-04 14:37:51'),
	(147, 'default', 'updated', 41, 'App\\Income', 1, 'App\\User', '[]', '2020-05-04 14:52:56', '2020-05-04 14:52:56'),
	(148, 'default', 'updated', 41, 'App\\Income', 1, 'App\\User', '[]', '2020-05-04 14:53:32', '2020-05-04 14:53:32'),
	(149, 'default', 'updated', 2, 'App\\Income', 1, 'App\\User', '[]', '2020-05-04 15:01:21', '2020-05-04 15:01:21'),
	(150, 'default', 'deleted', 1, 'App\\Expense', 1, 'App\\User', '[]', '2020-05-04 15:04:33', '2020-05-04 15:04:33'),
	(151, 'default', 'updated', 1, 'App\\Account', 1, 'App\\User', '[]', '2020-05-04 15:32:32', '2020-05-04 15:32:32'),
	(152, 'default', 'deleted', 1, 'App\\SmallBox', 1, 'App\\User', '[]', '2020-05-04 15:33:55', '2020-05-04 15:33:55'),
	(153, 'default', 'created', 2, 'App\\SmallBox', 1, 'App\\User', '[]', '2020-05-04 15:34:16', '2020-05-04 15:34:16'),
	(154, 'default', 'updated', 30, 'App\\Income', 1, 'App\\User', '[]', '2020-05-04 15:44:09', '2020-05-04 15:44:09'),
	(155, 'default', 'created', 2, 'App\\Expense', 1, 'App\\User', '[]', '2020-05-04 16:26:58', '2020-05-04 16:26:58'),
	(156, 'default', 'deleted', 2, 'App\\Expense', 1, 'App\\User', '[]', '2020-05-04 16:28:23', '2020-05-04 16:28:23'),
	(157, 'default', 'updated', 1, 'App\\Project', 1, 'App\\User', '[]', '2020-05-04 16:57:39', '2020-05-04 16:57:39'),
	(158, 'default', 'created', 3, 'App\\Expense', 1, 'App\\User', '[]', '2020-05-04 16:59:13', '2020-05-04 16:59:13'),
	(159, 'default', 'created', 4, 'App\\Expense', 1, 'App\\User', '[]', '2020-05-04 17:20:23', '2020-05-04 17:20:23'),
	(160, 'default', 'updated', 4, 'App\\Expense', 1, 'App\\User', '[]', '2020-05-04 17:28:07', '2020-05-04 17:28:07'),
	(161, 'default', 'updated', 2, 'App\\Project', 1, 'App\\User', '[]', '2020-05-04 17:29:06', '2020-05-04 17:29:06'),
	(162, 'default', 'deleted', 4, 'App\\Expense', 1, 'App\\User', '[]', '2020-05-04 17:32:03', '2020-05-04 17:32:03'),
	(163, 'default', 'created', 5, 'App\\Expense', 1, 'App\\User', '[]', '2020-05-04 17:32:57', '2020-05-04 17:32:57'),
	(164, 'default', 'updated', 2, 'App\\Income', 1, 'App\\User', '[]', '2020-05-04 17:34:30', '2020-05-04 17:34:30'),
	(165, 'default', 'deleted', 5, 'App\\Expense', 1, 'App\\User', '[]', '2020-05-04 17:44:00', '2020-05-04 17:44:00'),
	(166, 'default', 'updated', 2, 'App\\Project', 1, 'App\\User', '[]', '2020-05-04 17:49:02', '2020-05-04 17:49:02'),
	(167, 'default', 'updated', 42, 'App\\Income', 1, 'App\\User', '[]', '2020-05-04 17:54:35', '2020-05-04 17:54:35'),
	(168, 'default', 'updated', 43, 'App\\Project', 1, 'App\\User', '[]', '2020-05-04 17:54:58', '2020-05-04 17:54:58'),
	(169, 'default', 'created', 6, 'App\\Expense', 1, 'App\\User', '[]', '2020-05-04 17:56:24', '2020-05-04 17:56:24'),
	(170, 'default', 'created', 7, 'App\\Expense', 1, 'App\\User', '[]', '2020-05-04 18:02:53', '2020-05-04 18:02:53'),
	(171, 'default', 'updated', 7, 'App\\Expense', 1, 'App\\User', '[]', '2020-05-04 18:05:30', '2020-05-04 18:05:30'),
	(172, 'default', 'created', 8, 'App\\Expense', 1, 'App\\User', '[]', '2020-05-04 18:09:16', '2020-05-04 18:09:16'),
	(173, 'default', 'deleted', 8, 'App\\Expense', 1, 'App\\User', '[]', '2020-05-04 18:10:07', '2020-05-04 18:10:07'),
	(174, 'default', 'updated', 7, 'App\\Expense', 1, 'App\\User', '[]', '2020-05-04 18:10:20', '2020-05-04 18:10:20'),
	(175, 'default', 'created', 9, 'App\\Expense', 1, 'App\\User', '[]', '2020-05-04 18:13:30', '2020-05-04 18:13:30'),
	(176, 'default', 'updated', 15, 'App\\Project', 1, 'App\\User', '[]', '2020-05-06 11:35:48', '2020-05-06 11:35:48'),
	(177, 'default', 'created', 10, 'App\\Expense', 1, 'App\\User', '[]', '2020-05-06 17:26:26', '2020-05-06 17:26:26'),
	(178, 'default', 'created', 11, 'App\\Expense', 1, 'App\\User', '[]', '2020-05-06 18:30:49', '2020-05-06 18:30:49'),
	(179, 'default', 'created', 12, 'App\\Expense', 1, 'App\\User', '[]', '2020-05-06 18:32:31', '2020-05-06 18:32:31'),
	(180, 'default', 'created', 13, 'App\\Expense', 1, 'App\\User', '[]', '2020-05-06 20:01:11', '2020-05-06 20:01:11'),
	(181, 'default', 'created', 14, 'App\\Expense', 1, 'App\\User', '[]', '2020-05-07 09:33:12', '2020-05-07 09:33:12'),
	(182, 'default', 'created', 15, 'App\\Expense', 1, 'App\\User', '[]', '2020-05-07 09:36:30', '2020-05-07 09:36:30'),
	(183, 'default', 'created', 16, 'App\\Expense', 1, 'App\\User', '[]', '2020-05-07 10:14:32', '2020-05-07 10:14:32'),
	(184, 'default', 'created', 17, 'App\\Expense', 1, 'App\\User', '[]', '2020-05-07 10:16:51', '2020-05-07 10:16:51'),
	(185, 'default', 'created', 18, 'App\\Expense', 1, 'App\\User', '[]', '2020-05-07 10:20:45', '2020-05-07 10:20:45'),
	(186, 'default', 'created', 19, 'App\\Expense', 1, 'App\\User', '[]', '2020-05-07 10:48:55', '2020-05-07 10:48:55'),
	(187, 'default', 'created', 20, 'App\\Expense', 1, 'App\\User', '[]', '2020-05-07 10:51:19', '2020-05-07 10:51:19'),
	(188, 'default', 'created', 21, 'App\\Expense', 1, 'App\\User', '[]', '2020-05-07 11:00:34', '2020-05-07 11:00:34'),
	(189, 'default', 'created', 22, 'App\\Expense', 1, 'App\\User', '[]', '2020-05-07 11:02:05', '2020-05-07 11:02:05'),
	(190, 'default', 'created', 58, 'App\\Project', 1, 'App\\User', '[]', '2020-05-07 11:06:31', '2020-05-07 11:06:31'),
	(191, 'default', 'created', 23, 'App\\Expense', 1, 'App\\User', '[]', '2020-05-07 11:07:28', '2020-05-07 11:07:28'),
	(192, 'default', 'created', 24, 'App\\Expense', 1, 'App\\User', '[]', '2020-05-07 11:10:50', '2020-05-07 11:10:50'),
	(193, 'default', 'created', 59, 'App\\Project', 1, 'App\\User', '[]', '2020-05-07 11:12:40', '2020-05-07 11:12:40'),
	(194, 'default', 'created', 25, 'App\\Expense', 1, 'App\\User', '[]', '2020-05-07 11:13:28', '2020-05-07 11:13:28'),
	(195, 'default', 'created', 26, 'App\\Expense', 1, 'App\\User', '[]', '2020-05-07 11:16:02', '2020-05-07 11:16:02'),
	(196, 'default', 'created', 60, 'App\\Project', 1, 'App\\User', '[]', '2020-05-07 11:17:49', '2020-05-07 11:17:49'),
	(197, 'default', 'created', 27, 'App\\Expense', 1, 'App\\User', '[]', '2020-05-07 11:18:25', '2020-05-07 11:18:25'),
	(198, 'default', 'updated', 23, 'App\\Expense', 1, 'App\\User', '[]', '2020-05-07 11:20:32', '2020-05-07 11:20:32'),
	(199, 'default', 'created', 28, 'App\\Expense', 1, 'App\\User', '[]', '2020-05-07 11:22:51', '2020-05-07 11:22:51'),
	(200, 'default', 'created', 29, 'App\\Expense', 1, 'App\\User', '[]', '2020-05-07 11:25:00', '2020-05-07 11:25:00'),
	(201, 'default', 'created', 30, 'App\\Expense', 1, 'App\\User', '[]', '2020-05-07 11:26:02', '2020-05-07 11:26:02'),
	(202, 'default', 'created', 31, 'App\\Expense', 1, 'App\\User', '[]', '2020-05-07 11:26:55', '2020-05-07 11:26:55'),
	(203, 'default', 'created', 61, 'App\\Project', 1, 'App\\User', '[]', '2020-05-07 11:27:54', '2020-05-07 11:27:54'),
	(204, 'default', 'created', 32, 'App\\Expense', 1, 'App\\User', '[]', '2020-05-07 11:28:29', '2020-05-07 11:28:29'),
	(205, 'default', 'created', 62, 'App\\Project', 1, 'App\\User', '[]', '2020-05-07 11:33:32', '2020-05-07 11:33:32'),
	(206, 'default', 'created', 33, 'App\\Expense', 1, 'App\\User', '[]', '2020-05-07 11:34:03', '2020-05-07 11:34:03'),
	(207, 'default', 'created', 34, 'App\\Expense', 1, 'App\\User', '[]', '2020-05-07 11:35:32', '2020-05-07 11:35:32'),
	(208, 'default', 'updated', 20, 'App\\Expense', 1, 'App\\User', '[]', '2020-05-07 12:14:58', '2020-05-07 12:14:58'),
	(209, 'default', 'updated', 16, 'App\\Expense', 1, 'App\\User', '[]', '2020-05-07 12:22:11', '2020-05-07 12:22:11'),
	(210, 'default', 'updated', 21, 'App\\Expense', 1, 'App\\User', '[]', '2020-05-07 12:26:11', '2020-05-07 12:26:11'),
	(211, 'default', 'created', 35, 'App\\Expense', 1, 'App\\User', '[]', '2020-05-07 15:40:59', '2020-05-07 15:40:59'),
	(212, 'default', 'created', 36, 'App\\Expense', 1, 'App\\User', '[]', '2020-05-07 15:43:16', '2020-05-07 15:43:16'),
	(213, 'default', 'updated', 15, 'App\\Expense', 1, 'App\\User', '[]', '2020-05-07 15:59:30', '2020-05-07 15:59:30'),
	(214, 'default', 'created', 63, 'App\\Project', 1, 'App\\User', '[]', '2020-05-07 16:29:26', '2020-05-07 16:29:26'),
	(215, 'default', 'created', 37, 'App\\Expense', 1, 'App\\User', '[]', '2020-05-07 16:30:30', '2020-05-07 16:30:30'),
	(216, 'default', 'created', 64, 'App\\Project', 1, 'App\\User', '[]', '2020-05-07 16:31:41', '2020-05-07 16:31:41'),
	(217, 'default', 'created', 38, 'App\\Expense', 1, 'App\\User', '[]', '2020-05-07 16:32:17', '2020-05-07 16:32:17'),
	(218, 'default', 'created', 11, 'App\\ProjectType', 1, 'App\\User', '[]', '2020-05-07 16:42:55', '2020-05-07 16:42:55'),
	(219, 'default', 'created', 12, 'App\\ProjectType', 1, 'App\\User', '[]', '2020-05-07 16:43:13', '2020-05-07 16:43:13'),
	(220, 'default', 'created', 65, 'App\\Project', 1, 'App\\User', '[]', '2020-05-07 16:43:54', '2020-05-07 16:43:54'),
	(221, 'default', 'created', 39, 'App\\Expense', 1, 'App\\User', '[]', '2020-05-07 16:44:34', '2020-05-07 16:44:34'),
	(222, 'default', 'updated', 39, 'App\\Expense', 1, 'App\\User', '[]', '2020-05-07 16:52:44', '2020-05-07 16:52:44'),
	(223, 'default', 'created', 66, 'App\\Project', 1, 'App\\User', '[]', '2020-05-07 17:18:23', '2020-05-07 17:18:23'),
	(224, 'default', 'created', 13, 'App\\ProjectType', 1, 'App\\User', '[]', '2020-05-07 17:18:56', '2020-05-07 17:18:56'),
	(225, 'default', 'created', 67, 'App\\Project', 1, 'App\\User', '[]', '2020-05-07 17:19:37', '2020-05-07 17:19:37'),
	(226, 'default', 'created', 40, 'App\\Expense', 1, 'App\\User', '[]', '2020-05-07 17:20:12', '2020-05-07 17:20:12'),
	(227, 'default', 'created', 41, 'App\\Expense', 1, 'App\\User', '[]', '2020-05-07 17:22:00', '2020-05-07 17:22:00'),
	(228, 'default', 'updated', 19, 'App\\Expense', 1, 'App\\User', '[]', '2020-05-07 17:41:56', '2020-05-07 17:41:56'),
	(229, 'default', 'created', 42, 'App\\Expense', 1, 'App\\User', '[]', '2020-05-07 17:42:56', '2020-05-07 17:42:56'),
	(230, 'default', 'created', 43, 'App\\Expense', 1, 'App\\User', '[]', '2020-05-07 17:52:34', '2020-05-07 17:52:34'),
	(231, 'default', 'created', 44, 'App\\Expense', 1, 'App\\User', '[]', '2020-05-07 17:55:03', '2020-05-07 17:55:03'),
	(232, 'default', 'updated', 37, 'App\\Expense', 1, 'App\\User', '[]', '2020-05-07 17:56:48', '2020-05-07 17:56:48'),
	(233, 'default', 'updated', 63, 'App\\Project', 1, 'App\\User', '[]', '2020-05-07 17:57:12', '2020-05-07 17:57:12'),
	(234, 'default', 'updated', 40, 'App\\Expense', 1, 'App\\User', '[]', '2020-05-07 18:17:24', '2020-05-07 18:17:24'),
	(235, 'default', 'updated', 42, 'App\\Expense', 1, 'App\\User', '[]', '2020-05-07 18:21:06', '2020-05-07 18:21:06'),
	(236, 'default', 'updated', 20, 'App\\Expense', 1, 'App\\User', '[]', '2020-05-07 18:22:21', '2020-05-07 18:22:21'),
	(237, 'default', 'updated', 20, 'App\\Expense', 1, 'App\\User', '[]', '2020-05-07 18:54:07', '2020-05-07 18:54:07'),
	(238, 'default', 'updated', 26, 'App\\Expense', 1, 'App\\User', '[]', '2020-05-07 18:54:48', '2020-05-07 18:54:48'),
	(239, 'default', 'created', 2, 'App\\ExpenseType', 1, 'App\\User', '[]', '2020-05-07 19:04:51', '2020-05-07 19:04:51'),
	(240, 'default', 'created', 14, 'App\\ProjectType', 1, 'App\\User', '[]', '2020-05-07 19:05:36', '2020-05-07 19:05:36'),
	(241, 'default', 'created', 68, 'App\\Project', 1, 'App\\User', '[]', '2020-05-07 19:06:25', '2020-05-07 19:06:25'),
	(242, 'default', 'created', 45, 'App\\Expense', 1, 'App\\User', '[]', '2020-05-07 19:07:27', '2020-05-07 19:07:27'),
	(243, 'default', 'created', 46, 'App\\Expense', 1, 'App\\User', '[]', '2020-05-07 19:08:41', '2020-05-07 19:08:41'),
	(244, 'default', 'created', 47, 'App\\Expense', 1, 'App\\User', '[]', '2020-05-07 19:09:31', '2020-05-07 19:09:31'),
	(245, 'default', 'updated', 47, 'App\\Expense', 1, 'App\\User', '[]', '2020-05-07 19:09:52', '2020-05-07 19:09:52'),
	(246, 'default', 'updated', 47, 'App\\Expense', 1, 'App\\User', '[]', '2020-05-07 19:10:09', '2020-05-07 19:10:09'),
	(247, 'default', 'created', 48, 'App\\Expense', 1, 'App\\User', '[]', '2020-05-07 19:10:45', '2020-05-07 19:10:45'),
	(248, 'default', 'updated', 42, 'App\\Expense', 1, 'App\\User', '[]', '2020-05-07 19:18:19', '2020-05-07 19:18:19'),
	(249, 'default', 'updated', 42, 'App\\Expense', 1, 'App\\User', '[]', '2020-05-07 19:19:57', '2020-05-07 19:19:57'),
	(250, 'default', 'created', 1, 'App\\Box', 1, 'App\\User', '[]', '2020-05-07 19:27:08', '2020-05-07 19:27:08'),
	(251, 'default', 'created', 3, 'App\\SmallBox', 1, 'App\\User', '[]', '2020-06-04 09:45:54', '2020-06-04 09:45:54'),
	(252, 'default', 'updated', 14, 'App\\ProjectType', 1, 'App\\User', '[]', '2020-06-04 09:55:05', '2020-06-04 09:55:05'),
	(253, 'default', 'created', 3, 'App\\ExpenseType', 1, 'App\\User', '[]', '2020-06-04 09:57:53', '2020-06-04 09:57:53'),
	(254, 'default', 'created', 49, 'App\\Expense', 1, 'App\\User', '[]', '2020-06-04 09:59:13', '2020-06-04 09:59:13'),
	(255, 'default', 'created', 4, 'App\\ExpenseType', 1, 'App\\User', '[]', '2020-06-04 10:06:54', '2020-06-04 10:06:54'),
	(256, 'default', 'created', 50, 'App\\Expense', 1, 'App\\User', '[]', '2020-06-04 10:12:02', '2020-06-04 10:12:02'),
	(257, 'default', 'created', 1, 'App\\MaterialType', 1, 'App\\User', '[]', '2020-06-04 10:12:52', '2020-06-04 10:12:52'),
	(258, 'default', 'created', 1, 'App\\Material', 1, 'App\\User', '[]', '2020-06-04 10:13:35', '2020-06-04 10:13:35'),
	(259, 'default', 'deleted', 1, 'App\\Material', 1, 'App\\User', '[]', '2020-06-04 10:15:51', '2020-06-04 10:15:51'),
	(260, 'default', 'deleted', 1, 'App\\MaterialType', 1, 'App\\User', '[]', '2020-06-04 10:15:58', '2020-06-04 10:15:58'),
	(261, 'default', 'created', 2, 'App\\MaterialType', 1, 'App\\User', '[]', '2020-06-04 10:17:19', '2020-06-04 10:17:19'),
	(262, 'default', 'created', 2, 'App\\Material', 1, 'App\\User', '[]', '2020-06-04 10:17:52', '2020-06-04 10:17:52'),
	(263, 'default', 'updated', 2, 'App\\MaterialType', 1, 'App\\User', '[]', '2020-06-04 10:19:26', '2020-06-04 10:19:26'),
	(264, 'default', 'created', 3, 'App\\MaterialType', 1, 'App\\User', '[]', '2020-06-04 10:19:42', '2020-06-04 10:19:42'),
	(265, 'default', 'created', 3, 'App\\Material', 1, 'App\\User', '[]', '2020-06-04 10:20:08', '2020-06-04 10:20:08'),
	(266, 'default', 'created', 51, 'App\\Expense', 1, 'App\\User', '[]', '2020-06-04 10:23:29', '2020-06-04 10:23:29'),
	(267, 'default', 'created', 5, 'App\\ExpenseType', 1, 'App\\User', '[]', '2020-06-04 10:30:36', '2020-06-04 10:30:36'),
	(268, 'default', 'created', 52, 'App\\Expense', 1, 'App\\User', '[]', '2020-06-04 10:31:32', '2020-06-04 10:31:32'),
	(269, 'default', 'created', 53, 'App\\Expense', 1, 'App\\User', '[]', '2020-06-04 10:55:31', '2020-06-04 10:55:31'),
	(270, 'default', 'created', 54, 'App\\Expense', 1, 'App\\User', '[]', '2020-06-04 10:57:19', '2020-06-04 10:57:19'),
	(271, 'default', 'created', 55, 'App\\Expense', 1, 'App\\User', '[]', '2020-06-04 10:58:23', '2020-06-04 10:58:23'),
	(272, 'default', 'created', 56, 'App\\Expense', 1, 'App\\User', '[]', '2020-06-04 11:05:53', '2020-06-04 11:05:53'),
	(273, 'default', 'created', 57, 'App\\Expense', 1, 'App\\User', '[]', '2020-06-04 11:07:13', '2020-06-04 11:07:13'),
	(274, 'default', 'created', 1, 'App\\Person', 1, 'App\\User', '[]', '2020-06-04 11:23:08', '2020-06-04 11:23:08'),
	(275, 'default', 'created', 6, 'App\\ExpenseType', 1, 'App\\User', '[]', '2020-06-04 11:27:58', '2020-06-04 11:27:58'),
	(276, 'default', 'created', 58, 'App\\Expense', 1, 'App\\User', '[]', '2020-06-04 11:30:08', '2020-06-04 11:30:08'),
	(277, 'default', 'created', 2, 'App\\Person', 1, 'App\\User', '[]', '2020-06-04 12:10:37', '2020-06-04 12:10:37'),
	(278, 'default', 'created', 59, 'App\\Expense', 1, 'App\\User', '[]', '2020-06-04 12:11:42', '2020-06-04 12:11:42'),
	(279, 'default', 'created', 4, 'App\\MaterialType', 1, 'App\\User', '[]', '2020-06-04 12:15:55', '2020-06-04 12:15:55'),
	(280, 'default', 'created', 4, 'App\\Material', 1, 'App\\User', '[]', '2020-06-04 12:26:23', '2020-06-04 12:26:23'),
	(281, 'default', 'created', 1, 'App\\Amount', 1, 'App\\User', '[]', '2020-06-04 12:31:36', '2020-06-04 12:31:36'),
	(282, 'default', 'created', 60, 'App\\Expense', 1, 'App\\User', '[]', '2020-06-04 12:32:43', '2020-06-04 12:32:43'),
	(283, 'default', 'created', 5, 'App\\Material', 1, 'App\\User', '[]', '2020-06-04 12:33:29', '2020-06-04 12:33:29'),
	(284, 'default', 'created', 61, 'App\\Expense', 1, 'App\\User', '[]', '2020-06-04 12:35:03', '2020-06-04 12:35:03'),
	(285, 'default', 'created', 5, 'App\\MaterialType', 1, 'App\\User', '[]', '2020-06-04 12:36:04', '2020-06-04 12:36:04'),
	(286, 'default', 'created', 6, 'App\\Material', 1, 'App\\User', '[]', '2020-06-04 12:37:00', '2020-06-04 12:37:00'),
	(287, 'default', 'updated', 5, 'App\\MaterialType', 1, 'App\\User', '[]', '2020-06-04 12:40:51', '2020-06-04 12:40:51'),
	(288, 'default', 'created', 6, 'App\\MaterialType', 1, 'App\\User', '[]', '2020-06-04 12:40:57', '2020-06-04 12:40:57'),
	(289, 'default', 'created', 7, 'App\\Material', 1, 'App\\User', '[]', '2020-06-04 12:46:33', '2020-06-04 12:46:33'),
	(290, 'default', 'created', 7, 'App\\MaterialType', 1, 'App\\User', '[]', '2020-06-04 12:49:00', '2020-06-04 12:49:00'),
	(291, 'default', 'created', 8, 'App\\Material', 1, 'App\\User', '[]', '2020-06-04 12:51:04', '2020-06-04 12:51:04'),
	(292, 'default', 'created', 8, 'App\\MaterialType', 1, 'App\\User', '[]', '2020-06-04 12:51:43', '2020-06-04 12:51:43'),
	(293, 'default', 'created', 9, 'App\\Material', 1, 'App\\User', '[]', '2020-06-04 12:52:22', '2020-06-04 12:52:22'),
	(294, 'default', 'created', 9, 'App\\MaterialType', 1, 'App\\User', '[]', '2020-06-04 12:54:09', '2020-06-04 12:54:09'),
	(295, 'default', 'created', 10, 'App\\Material', 1, 'App\\User', '[]', '2020-06-04 12:54:55', '2020-06-04 12:54:55'),
	(296, 'default', 'created', 10, 'App\\MaterialType', 1, 'App\\User', '[]', '2020-06-04 12:59:55', '2020-06-04 12:59:55'),
	(297, 'default', 'created', 11, 'App\\Material', 1, 'App\\User', '[]', '2020-06-04 13:03:59', '2020-06-04 13:03:59'),
	(298, 'default', 'created', 62, 'App\\Expense', 1, 'App\\User', '[]', '2020-06-04 13:12:39', '2020-06-04 13:12:39'),
	(299, 'default', 'created', 7, 'App\\ExpenseType', 1, 'App\\User', '[]', '2020-06-04 13:13:36', '2020-06-04 13:13:36'),
	(300, 'default', 'created', 63, 'App\\Expense', 1, 'App\\User', '[]', '2020-06-04 13:14:07', '2020-06-04 13:14:07'),
	(301, 'default', 'created', 3, 'App\\Person', 1, 'App\\User', '[]', '2020-06-04 13:26:53', '2020-06-04 13:26:53'),
	(302, 'default', 'created', 64, 'App\\Expense', 1, 'App\\User', '[]', '2020-06-04 13:28:57', '2020-06-04 13:28:57'),
	(303, 'default', 'created', 65, 'App\\Expense', 1, 'App\\User', '[]', '2020-06-04 13:33:15', '2020-06-04 13:33:15'),
	(304, 'default', 'created', 8, 'App\\ExpenseType', 1, 'App\\User', '[]', '2020-06-04 13:33:59', '2020-06-04 13:33:59'),
	(305, 'default', 'created', 66, 'App\\Expense', 1, 'App\\User', '[]', '2020-06-04 13:34:40', '2020-06-04 13:34:40'),
	(306, 'default', 'created', 11, 'App\\MaterialType', 1, 'App\\User', '[]', '2020-06-04 13:56:45', '2020-06-04 13:56:45'),
	(307, 'default', 'created', 12, 'App\\Material', 1, 'App\\User', '[]', '2020-06-04 13:57:12', '2020-06-04 13:57:12'),
	(308, 'default', 'created', 67, 'App\\Expense', 1, 'App\\User', '[]', '2020-06-04 14:00:03', '2020-06-04 14:00:03'),
	(309, 'default', 'created', 58, 'App\\Income', 1, 'App\\User', '[]', '2020-06-04 14:05:38', '2020-06-04 14:05:38'),
	(310, 'default', 'created', 2, 'App\\Amount', 1, 'App\\User', '[]', '2020-06-05 09:14:39', '2020-06-05 09:14:39'),
	(311, 'default', 'created', 3, 'App\\Amount', 1, 'App\\User', '[]', '2020-06-05 09:31:28', '2020-06-05 09:31:28'),
	(312, 'default', 'created', 2, 'App\\Box', 1, 'App\\User', '[]', '2020-06-05 09:58:22', '2020-06-05 09:58:22'),
	(313, 'default', 'updated', 1, 'App\\User', 1, 'App\\User', '[]', '2020-06-13 10:16:15', '2020-06-13 10:16:15'),
	(314, 'default', 'created', 59, 'App\\Income', 1, 'App\\User', '[]', '2020-06-19 14:35:41', '2020-06-19 14:35:41'),
	(315, 'default', 'created', 60, 'App\\Income', 1, 'App\\User', '[]', '2020-06-19 14:39:24', '2020-06-19 14:39:24'),
	(316, 'default', 'created', 5, 'App\\SmallBox', 1, 'App\\User', '[]', '2020-06-19 14:39:43', '2020-06-19 14:39:43'),
	(317, 'default', 'created', 68, 'App\\Expense', 1, 'App\\User', '[]', '2020-06-19 16:25:51', '2020-06-19 16:25:51'),
	(318, 'default', 'created', 3, 'App\\Box', 1, 'App\\User', '[]', '2020-06-19 16:27:12', '2020-06-19 16:27:12'),
	(320, 'default', 'created', 5, 'App\\Box', 1, 'App\\User', '[]', '2020-06-19 16:31:29', '2020-06-19 16:31:29'),
	(323, 'default', 'created', 8, 'App\\Box', 1, 'App\\User', '[]', '2020-06-19 16:36:14', '2020-06-19 16:36:14'),
	(324, 'default', 'created', 9, 'App\\Box', 1, 'App\\User', '[]', '2020-06-19 17:39:36', '2020-06-19 17:39:36'),
	(325, 'default', 'created', 6, 'App\\SmallBox', 1, 'App\\User', '[]', '2020-06-20 23:14:56', '2020-06-20 23:14:56'),
	(326, 'default', 'created', 61, 'App\\Income', 1, 'App\\User', '[]', '2020-06-21 12:06:09', '2020-06-21 12:06:09'),
	(327, 'default', 'created', 69, 'App\\Expense', 1, 'App\\User', '[]', '2020-06-21 12:08:28', '2020-06-21 12:08:28'),
	(328, 'default', 'created', 70, 'App\\Expense', 1, 'App\\User', '[]', '2020-06-21 12:12:36', '2020-06-21 12:12:36'),
	(329, 'default', 'created', 2, 'App\\User', 1, 'App\\User', '[]', '2020-06-21 18:14:31', '2020-06-21 18:14:31'),
	(330, 'default', 'created', 7, 'App\\SmallBox', 2, 'App\\User', '[]', '2020-06-21 18:15:14', '2020-06-21 18:15:14'),
	(331, 'default', 'created', 8, 'App\\SmallBox', 1, 'App\\User', '[]', '2020-06-21 18:15:47', '2020-06-21 18:15:47'),
	(332, 'default', 'created', 71, 'App\\Expense', 1, 'App\\User', '[]', '2020-06-22 11:33:18', '2020-06-22 11:33:18'),
	(333, 'default', 'created', 10, 'App\\Box', 1, 'App\\User', '[]', '2020-06-22 11:34:48', '2020-06-22 11:34:48');
/*!40000 ALTER TABLE `activity_log` ENABLE KEYS */;

-- Volcando estructura para tabla vertical.amounts
CREATE TABLE IF NOT EXISTS `amounts` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `amount` double(14,2) NOT NULL,
  `small_box_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `small_box_id` (`small_box_id`),
  CONSTRAINT `FK_amount_small_boxes` FOREIGN KEY (`small_box_id`) REFERENCES `small_boxes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla vertical.amounts: ~3 rows (aproximadamente)
/*!40000 ALTER TABLE `amounts` DISABLE KEYS */;
INSERT INTO `amounts` (`id`, `amount`, `small_box_id`, `created_at`, `updated_at`) VALUES
	(1, 10000.00, 3, '2020-06-04 12:31:36', '2020-06-04 12:31:36'),
	(2, 499.00, 3, '2020-06-05 09:14:39', '2020-06-05 09:14:39'),
	(3, 20.00, 3, '2020-06-05 09:31:28', '2020-06-05 09:31:28');
/*!40000 ALTER TABLE `amounts` ENABLE KEYS */;

-- Volcando estructura para tabla vertical.boxes
CREATE TABLE IF NOT EXISTS `boxes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `date_init` datetime NOT NULL,
  `date_end` datetime NOT NULL,
  `amount` double(14,2) NOT NULL,
  `note` mediumtext,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_date_init` (`date_init`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla vertical.boxes: ~3 rows (aproximadamente)
/*!40000 ALTER TABLE `boxes` DISABLE KEYS */;
INSERT INTO `boxes` (`id`, `date_init`, `date_end`, `amount`, `note`, `deleted_at`, `created_at`, `updated_at`) VALUES
	(1, '2020-04-24 16:43:58', '2020-05-07 19:21:01', 257765.02, 'Dinero en cuenta banco ganadero  84,996.67 bs + Dinero en cuenta banco mercantil 896.16 bs + Dinero en caja 171,872.5', NULL, '2020-05-07 19:27:08', '2020-05-07 19:27:08'),
	(2, '2020-05-07 19:27:08', '2020-06-05 09:49:50', 239295.83, 'Dinero en cuenta banco ganadero 84.977,67 bs + Dinero en cuenta banco mercantil 896.16 bs + Dinero en caja 153.422 bs', NULL, '2020-06-05 09:58:22', '2020-06-05 09:58:22');
/*!40000 ALTER TABLE `boxes` ENABLE KEYS */;

-- Volcando estructura para tabla vertical.box_small_box
CREATE TABLE IF NOT EXISTS `box_small_box` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `box_id` int(10) unsigned DEFAULT NULL,
  `small_box_id` int(10) unsigned DEFAULT NULL,
  `total_amount` double(14,2) DEFAULT NULL,
  `used_amount` double(14,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `box_id` (`box_id`),
  KEY `small_box_id` (`small_box_id`),
  CONSTRAINT `FK_detail_small_box_boxes` FOREIGN KEY (`box_id`) REFERENCES `boxes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_detail_small_box_small_boxes` FOREIGN KEY (`small_box_id`) REFERENCES `small_boxes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla vertical.box_small_box: ~2 rows (aproximadamente)
/*!40000 ALTER TABLE `box_small_box` DISABLE KEYS */;
INSERT INTO `box_small_box` (`id`, `box_id`, `small_box_id`, `total_amount`, `used_amount`) VALUES
	(1, 1, 2, 3053485.00, 2795719.98),
	(2, 2, 3, 25469.50, 21948.00);
/*!40000 ALTER TABLE `box_small_box` ENABLE KEYS */;

-- Volcando estructura para tabla vertical.expenses
CREATE TABLE IF NOT EXISTS `expenses` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payment` enum('Tarjeta','Efectivo','Cheque','Credito','Transferencia') COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` date NOT NULL,
  `note` mediumtext COLLATE utf8mb4_unicode_ci,
  `amount` double(14,2) NOT NULL,
  `expense_type_id` int(10) unsigned NOT NULL,
  `project_id` int(10) unsigned NOT NULL,
  `account_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `expenses_expense_type_id_foreign` (`expense_type_id`),
  KEY `expenses_project_id_foreign` (`project_id`),
  KEY `idx_date` (`date`,`amount`),
  KEY `expenses_account_id_foreign` (`account_id`),
  KEY `user_id` (`user_id`),
  KEY `idx_created` (`created_at`),
  FULLTEXT KEY `idx_full_title` (`title`),
  CONSTRAINT `expenses_account_id_foreign` FOREIGN KEY (`account_id`) REFERENCES `accounts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `expenses_expense_type_id_foreign` FOREIGN KEY (`expense_type_id`) REFERENCES `expense_types` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `expenses_project_id_foreign` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=72 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla vertical.expenses: ~62 rows (aproximadamente)
/*!40000 ALTER TABLE `expenses` DISABLE KEYS */;
INSERT INTO `expenses` (`id`, `title`, `payment`, `date`, `note`, `amount`, `expense_type_id`, `project_id`, `account_id`, `user_id`, `deleted_at`, `created_at`, `updated_at`) VALUES
	(3, 'Gastos generales de obra', 'Efectivo', '2018-07-07', NULL, 1665.50, 1, 1, 1, 1, NULL, '2020-05-04 16:59:13', '2020-05-04 16:59:13'),
	(6, 'Pago de refaciones apartamento villa fatima', 'Efectivo', '2018-07-07', NULL, 7249.92, 1, 2, 1, 1, NULL, '2020-05-04 17:56:24', '2020-05-04 17:56:24'),
	(7, 'Pago demolición villa fatima', 'Efectivo', '2018-07-07', NULL, 9434.30, 1, 3, 1, 1, NULL, '2020-05-04 18:02:53', '2020-05-04 18:10:20'),
	(9, 'Pago de aprobación  de proyecto', 'Efectivo', '2018-07-07', NULL, 6147.34, 1, 21, 1, 1, NULL, '2020-05-04 18:13:30', '2020-05-04 18:13:30'),
	(10, 'Pago de gastos generales', 'Efectivo', '2018-07-07', NULL, 580535.56, 1, 15, 1, 1, NULL, '2020-05-06 17:26:26', '2020-05-06 17:26:26'),
	(11, 'Pago de gastos generales', 'Efectivo', '2018-07-07', NULL, 38023.70, 1, 28, 1, 1, NULL, '2020-05-06 18:30:49', '2020-05-06 18:30:49'),
	(12, 'Pago de gastos generales', 'Efectivo', '2018-07-07', NULL, 179061.15, 1, 20, 1, 1, NULL, '2020-05-06 18:32:31', '2020-05-06 18:32:31'),
	(13, 'Pago gastos generales', 'Efectivo', '2018-07-07', NULL, 50315.67, 1, 30, 1, 1, NULL, '2020-05-06 20:01:11', '2020-05-06 20:01:11'),
	(14, 'Pago gastos generales de obra', 'Efectivo', '2018-07-07', NULL, 3522.50, 1, 45, 1, 1, NULL, '2020-05-07 09:33:11', '2020-05-07 09:33:11'),
	(15, 'Pago gastos generales', 'Efectivo', '2018-07-07', NULL, 189228.07, 1, 36, 1, 1, NULL, '2020-05-07 09:36:30', '2020-05-07 15:59:30'),
	(16, 'Pago de gastos generales', 'Efectivo', '2018-07-07', NULL, 341116.07, 1, 32, 1, 1, NULL, '2020-05-07 10:14:32', '2020-05-07 12:22:11'),
	(17, 'Pago gastos generales construcción', 'Efectivo', '2018-07-07', NULL, 95457.50, 1, 40, 1, 1, NULL, '2020-05-07 10:16:51', '2020-05-07 10:16:51'),
	(18, 'Pago gastos generales', 'Efectivo', '2018-07-07', NULL, 525798.33, 1, 33, 1, 1, NULL, '2020-05-07 10:20:45', '2020-05-07 10:20:45'),
	(19, 'Pago de gastos generales', 'Efectivo', '2018-07-07', NULL, 236211.81, 1, 41, 1, 1, NULL, '2020-05-07 10:48:55', '2020-05-07 17:41:56'),
	(20, 'Pago gastos generales', 'Efectivo', '2018-07-07', NULL, 130985.21, 1, 54, 1, 1, NULL, '2020-05-07 10:51:19', '2020-05-07 18:54:07'),
	(21, 'Pago gastos generales', 'Efectivo', '2018-07-07', NULL, 27648.00, 1, 50, 1, 1, NULL, '2020-05-07 11:00:34', '2020-05-07 12:26:11'),
	(22, 'Pago de ploter', 'Efectivo', '2018-07-07', NULL, 50.00, 1, 27, 1, 1, NULL, '2020-05-07 11:02:05', '2020-05-07 11:02:05'),
	(23, 'Pago de gastos generales', 'Efectivo', '2018-07-07', NULL, 2556.00, 1, 58, 1, 1, NULL, '2020-05-07 11:07:28', '2020-05-07 11:20:31'),
	(24, 'Pago gastos generales', 'Efectivo', '2018-07-07', NULL, 10888.00, 1, 44, 1, 1, NULL, '2020-05-07 11:10:50', '2020-05-07 11:10:50'),
	(25, 'Pago de gastos generales', 'Efectivo', '2018-07-07', NULL, 2488.00, 1, 59, 1, 1, NULL, '2020-05-07 11:13:28', '2020-05-07 11:13:28'),
	(26, 'Pago de gastos generales', 'Efectivo', '2018-07-07', NULL, 33062.00, 1, 55, 1, 1, NULL, '2020-05-07 11:16:02', '2020-05-07 18:54:48'),
	(27, 'Pago de gastos generales', 'Efectivo', '2018-07-07', NULL, 12247.40, 1, 60, 1, 1, NULL, '2020-05-07 11:18:25', '2020-05-07 11:18:25'),
	(28, 'Pago de gastos generales', 'Efectivo', '2018-07-07', NULL, 5160.00, 1, 31, 1, 1, NULL, '2020-05-07 11:22:51', '2020-05-07 11:22:51'),
	(29, 'Pago de gastos generales', 'Efectivo', '2018-07-07', NULL, 744.00, 1, 47, 1, 1, NULL, '2020-05-07 11:25:00', '2020-05-07 11:25:00'),
	(30, 'Pago de ploter', 'Efectivo', '2018-07-07', NULL, 35.00, 1, 48, 1, 1, NULL, '2020-05-07 11:26:02', '2020-05-07 11:26:02'),
	(31, 'Pago de gastos generales', 'Efectivo', '2018-07-07', NULL, 500.00, 1, 49, 1, 1, NULL, '2020-05-07 11:26:55', '2020-05-07 11:26:55'),
	(32, 'Pago de gastos generales', 'Efectivo', '2018-07-07', NULL, 365.00, 1, 61, 1, 1, NULL, '2020-05-07 11:28:29', '2020-05-07 11:28:29'),
	(33, 'Pago de gastos generales', 'Efectivo', '2018-07-07', NULL, 5634.00, 1, 62, 1, 1, NULL, '2020-05-07 11:34:03', '2020-05-07 11:34:03'),
	(34, 'Pago de gastos generales', 'Efectivo', '2018-07-07', NULL, 1074.00, 1, 53, 1, 1, NULL, '2020-05-07 11:35:32', '2020-05-07 11:35:32'),
	(35, 'Pago de gastos generales', 'Efectivo', '2018-07-07', NULL, 3558.00, 1, 43, 1, 1, NULL, '2020-05-07 15:40:59', '2020-05-07 15:40:59'),
	(36, 'Pago de gastos generales', 'Efectivo', '2018-07-07', NULL, 17110.00, 1, 23, 1, 1, NULL, '2020-05-07 15:43:16', '2020-05-07 15:43:16'),
	(37, 'Pago de gastos generales', 'Efectivo', '2018-07-07', NULL, 2917.40, 1, 63, 1, 1, NULL, '2020-05-07 16:30:30', '2020-05-07 17:56:48'),
	(38, 'Pago de gastos generales', 'Efectivo', '2018-07-07', NULL, 1890.00, 1, 64, 1, 1, NULL, '2020-05-07 16:32:17', '2020-05-07 16:32:17'),
	(39, 'Pago de gastos generales en oficina', 'Efectivo', '2018-07-07', NULL, 130255.39, 1, 65, 1, 1, NULL, '2020-05-07 16:44:34', '2020-05-07 16:52:44'),
	(40, 'Pagos de gastos generales', 'Efectivo', '2018-07-07', NULL, 35266.36, 1, 67, 1, 1, NULL, '2020-05-07 17:20:12', '2020-05-07 18:17:24'),
	(41, 'Pago de capacitación de personal', 'Efectivo', '2018-07-07', NULL, 425.00, 1, 66, 1, 1, NULL, '2020-05-07 17:22:00', '2020-05-07 17:22:00'),
	(42, 'Pago de muebles carpinte art', 'Efectivo', '2018-07-07', NULL, 54474.80, 1, 35, 1, 1, NULL, '2020-05-07 17:42:56', '2020-05-07 19:19:57'),
	(43, 'Pago de gastos generales', 'Efectivo', '2018-07-07', NULL, 500.00, 1, 46, 1, 1, NULL, '2020-05-07 17:52:34', '2020-05-07 17:52:34'),
	(44, 'Pago a cuenta de garantia', 'Efectivo', '2018-07-07', NULL, 1419.00, 1, 41, 1, 1, NULL, '2020-05-07 17:55:03', '2020-05-07 17:55:03'),
	(45, 'Dinero prestado a santos guido vega', 'Efectivo', '2018-07-07', NULL, 28200.00, 2, 68, 1, 1, NULL, '2020-05-07 19:07:27', '2020-05-07 19:07:27'),
	(46, 'Dinero prestado a Katherine castellon ribera', 'Efectivo', '2018-07-07', NULL, 7500.00, 2, 68, 1, 1, NULL, '2020-05-07 19:08:41', '2020-05-07 19:08:41'),
	(47, 'Dinero prestado a Jose saravia', 'Efectivo', '2018-07-07', NULL, 12000.00, 2, 68, 1, 1, NULL, '2020-05-07 19:09:31', '2020-05-07 19:10:09'),
	(48, 'Dinero prestado a Richard moron', 'Efectivo', '2018-07-07', NULL, 3000.00, 2, 68, 1, 1, NULL, '2020-05-07 19:10:45', '2020-05-07 19:10:45'),
	(49, 'Pago de factura mes febrero,marzo y abril', 'Efectivo', '2020-06-04', NULL, 450.00, 3, 65, 1, 1, NULL, '2020-06-04 09:59:13', '2020-06-04 09:59:13'),
	(50, 'Alcohol telchi y jabón', 'Efectivo', '2020-06-04', NULL, 30.50, 4, 54, 1, 1, NULL, '2020-06-04 10:12:02', '2020-06-04 10:12:02'),
	(51, 'Barbijo', 'Efectivo', '2020-06-04', NULL, 20.00, 4, 54, 1, 1, NULL, '2020-06-04 10:23:29', '2020-06-04 10:23:29'),
	(52, 'Pago de planilla 79', 'Efectivo', '2020-06-04', NULL, 870.00, 5, 55, 1, 1, NULL, '2020-06-04 10:31:32', '2020-06-04 10:31:32'),
	(53, 'Pago de planilla 79', 'Efectivo', '2020-06-04', NULL, 620.00, 5, 60, 1, 1, NULL, '2020-06-04 10:55:31', '2020-06-04 10:55:31'),
	(54, 'Pago de planilla 79', 'Efectivo', '2020-06-04', NULL, 770.00, 5, 50, 1, 1, NULL, '2020-06-04 10:57:19', '2020-06-04 10:57:19'),
	(55, 'Pago de planilla 79', 'Efectivo', '2020-06-04', NULL, 830.00, 5, 54, 1, 1, NULL, '2020-06-04 10:58:23', '2020-06-04 10:58:23'),
	(56, 'Pago de planilla 79', 'Efectivo', '2020-06-04', NULL, 362.50, 5, 50, 1, 1, NULL, '2020-06-04 11:05:53', '2020-06-04 11:05:53'),
	(57, 'Pago de planilla 80', 'Efectivo', '2020-06-04', NULL, 2060.00, 5, 54, 1, 1, NULL, '2020-06-04 11:07:13', '2020-06-04 11:07:13'),
	(58, 'Pago de planilla Javier tantani', 'Efectivo', '2020-06-04', NULL, 500.00, 6, 54, 1, 1, NULL, '2020-06-04 11:30:08', '2020-06-04 11:30:08'),
	(59, 'Anticipo adolfo carpintero', 'Efectivo', '2020-06-04', NULL, 1500.00, 6, 54, 1, 1, NULL, '2020-06-04 12:11:42', '2020-06-04 12:11:42'),
	(60, 'Madera tajibo para vigas', 'Efectivo', '2020-06-04', NULL, 8022.00, 1, 54, 1, 1, NULL, '2020-06-04 12:32:43', '2020-06-04 12:32:43'),
	(61, 'Liston para techado', 'Efectivo', '2020-06-04', NULL, 1500.00, 1, 54, 1, 1, NULL, '2020-06-04 12:35:03', '2020-06-04 12:35:03'),
	(62, 'Pago de materiales', 'Efectivo', '2020-06-04', NULL, 3198.00, 1, 54, 1, 1, NULL, '2020-06-04 13:12:39', '2020-06-04 13:12:39'),
	(63, 'Retiro de escombros', 'Efectivo', '2020-06-04', NULL, 300.00, 7, 54, 1, 1, NULL, '2020-06-04 13:14:07', '2020-06-04 13:14:07'),
	(64, 'Pago a electrico', 'Efectivo', '2020-06-04', NULL, 200.00, 6, 54, 1, 1, NULL, '2020-06-04 13:28:57', '2020-06-04 13:28:57'),
	(65, 'Compra de mascarilla de proteccion', 'Efectivo', '2020-06-04', NULL, 130.00, 4, 54, 1, 1, NULL, '2020-06-04 13:33:15', '2020-06-04 13:33:15'),
	(66, 'Traslado de madera a obra', 'Efectivo', '2020-06-04', NULL, 50.00, 8, 54, 1, 1, NULL, '2020-06-04 13:34:40', '2020-06-04 13:34:40'),
	(67, 'Compra de material de clarita', 'Efectivo', '2020-06-04', NULL, 535.00, 1, 54, 1, 1, NULL, '2020-06-04 14:00:03', '2020-06-04 14:00:03');
/*!40000 ALTER TABLE `expenses` ENABLE KEYS */;

-- Volcando estructura para tabla vertical.expense_material
CREATE TABLE IF NOT EXISTS `expense_material` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `expense_id` int(10) unsigned NOT NULL,
  `material_id` int(10) unsigned NOT NULL,
  `quantity` int(10) unsigned NOT NULL,
  `price` double(14,2) NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `expense_material_expense_id_foreign` (`expense_id`),
  KEY `expense_material_material_id_foreign` (`material_id`),
  CONSTRAINT `expense_material_expense_id_foreign` FOREIGN KEY (`expense_id`) REFERENCES `expenses` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `expense_material_material_id_foreign` FOREIGN KEY (`material_id`) REFERENCES `materials` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla vertical.expense_material: ~10 rows (aproximadamente)
/*!40000 ALTER TABLE `expense_material` DISABLE KEYS */;
INSERT INTO `expense_material` (`id`, `expense_id`, `material_id`, `quantity`, `price`, `deleted_at`, `created_at`, `updated_at`) VALUES
	(1, 51, 2, 10, 2.00, NULL, '2020-06-04 10:23:29', '2020-06-04 10:23:29'),
	(2, 60, 4, 573, 14.00, NULL, '2020-06-04 12:32:43', '2020-06-04 12:32:43'),
	(3, 61, 5, 200, 7.50, NULL, '2020-06-04 12:35:03', '2020-06-04 12:35:03'),
	(4, 62, 6, 3000, 0.55, NULL, '2020-06-04 13:12:39', '2020-06-04 13:12:56'),
	(5, 62, 11, 12, 75.00, NULL, '2020-06-04 13:12:39', '2020-06-04 13:12:56'),
	(6, 62, 7, 9, 12.00, NULL, '2020-06-04 13:12:39', '2020-06-04 13:12:56'),
	(7, 62, 8, 12, 7.50, NULL, '2020-06-04 13:12:39', '2020-06-04 13:12:56'),
	(8, 62, 10, 10, 12.00, NULL, '2020-06-04 13:12:39', '2020-06-04 13:12:56'),
	(9, 62, 9, 3, 110.00, NULL, '2020-06-04 13:12:39', '2020-06-04 13:12:56'),
	(10, 67, 12, 1, 535.00, NULL, '2020-06-04 14:00:03', '2020-06-04 14:00:03');
/*!40000 ALTER TABLE `expense_material` ENABLE KEYS */;

-- Volcando estructura para tabla vertical.expense_person
CREATE TABLE IF NOT EXISTS `expense_person` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `expense_id` int(10) unsigned NOT NULL,
  `person_id` int(10) unsigned NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `expense_person_expense_id_foreign` (`expense_id`),
  KEY `expense_person_person_id_foreign` (`person_id`),
  CONSTRAINT `expense_person_expense_id_foreign` FOREIGN KEY (`expense_id`) REFERENCES `expenses` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `expense_person_person_id_foreign` FOREIGN KEY (`person_id`) REFERENCES `people` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla vertical.expense_person: ~3 rows (aproximadamente)
/*!40000 ALTER TABLE `expense_person` DISABLE KEYS */;
INSERT INTO `expense_person` (`id`, `expense_id`, `person_id`, `deleted_at`, `created_at`, `updated_at`) VALUES
	(1, 58, 1, NULL, '2020-06-04 11:30:08', '2020-06-04 11:30:08'),
	(2, 59, 2, NULL, '2020-06-04 12:11:42', '2020-06-04 12:11:42'),
	(3, 64, 3, NULL, '2020-06-04 13:28:57', '2020-06-04 13:28:57');
/*!40000 ALTER TABLE `expense_person` ENABLE KEYS */;

-- Volcando estructura para tabla vertical.expense_types
CREATE TABLE IF NOT EXISTS `expense_types` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` mediumtext COLLATE utf8mb4_unicode_ci,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  FULLTEXT KEY `idx_full_text` (`name`,`description`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla vertical.expense_types: ~8 rows (aproximadamente)
/*!40000 ALTER TABLE `expense_types` DISABLE KEYS */;
INSERT INTO `expense_types` (`id`, `name`, `description`, `deleted_at`, `created_at`, `updated_at`) VALUES
	(1, 'Compra de materiales', NULL, NULL, '2020-04-24 16:46:01', '2020-04-24 16:46:01'),
	(2, 'Prestamos de dinero', NULL, NULL, '2020-05-07 19:04:51', '2020-05-07 19:04:51'),
	(3, 'Gastos generales', NULL, NULL, '2020-06-04 09:57:53', '2020-06-04 09:57:53'),
	(4, 'Compra de EPP', NULL, NULL, '2020-06-04 10:06:54', '2020-06-04 10:06:54'),
	(5, 'Pago de planillas', NULL, NULL, '2020-06-04 10:30:36', '2020-06-04 10:30:36'),
	(6, 'Pago de contratista', NULL, NULL, '2020-06-04 11:27:58', '2020-06-04 11:27:58'),
	(7, 'Escombros', NULL, NULL, '2020-06-04 13:13:36', '2020-06-04 13:13:36'),
	(8, 'TRANSPORTE', NULL, NULL, '2020-06-04 13:33:59', '2020-06-04 13:33:59');
/*!40000 ALTER TABLE `expense_types` ENABLE KEYS */;

-- Volcando estructura para procedimiento vertical.get_balance_account
DELIMITER //
CREATE DEFINER=`root`@`localhost` PROCEDURE `get_balance_account`(
	IN `id` int(10),
	OUT `valido` double

)
begin
   declare date_init varchar(40);
   declare t_income double;
   declare t_expense double;
   declare n_income double;
   declare n_expense double;
	     
   IF (EXISTS(select ab.created_at, ab.income, ab.expense
					from accounts as a
					inner join account_box as ab
					on a.id = ab.account_id
					inner join boxes as b
					on ab.box_id = b.id
					where a.id = id
					order by b.id desc limit 1)) then
		select ab.created_at, ab.income, ab.expense into date_init, t_income, t_expense
					from accounts as a
					inner join account_box as ab
					on a.id = ab.account_id
					inner join boxes as b
					on ab.box_id = b.id
					where a.id = id
					order by b.id desc limit 1;
    ELSE
        select ifnull(t1.amount, 0), ifnull(t2.amount, 0) into t_income, t_expense
			from accounts a
			inner join (
			  select account_id, COALESCE(sum(amount), 0) as amount
			  from incomes 
			  where account_id = id and deleted_at is null
			) t1 on a.id = t1.account_id
			left join (
			  select account_id, COALESCE(sum(amount), 0) as amount
			  from expenses 
			  where account_id = id and deleted_at is null
			) t2 on a.id = t2.account_id;

    end if;  
    
    if (date_init is null or date_init = ' ') then
      set valido = (t_income - t_expense);
    else
      set n_income = (select COALESCE(sum(amount), 0) from incomes where (account_id = id and deleted_at is null) and created_at >= date_init AND created_at <= now());
      set n_expense = (select COALESCE(sum(amount), 0) from expenses where (account_id = id and deleted_at is null) and created_at >= date_init AND created_at <= now());
      set valido = (t_income + n_income) - (t_expense + n_expense);
     end if;
   SELECT valido;
 end//
DELIMITER ;

-- Volcando estructura para tabla vertical.incomes
CREATE TABLE IF NOT EXISTS `incomes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payment` enum('Tarjeta','Efectivo','Cheque','Credito','Transferencia') COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` date NOT NULL,
  `note` mediumtext COLLATE utf8mb4_unicode_ci,
  `amount` double(14,2) NOT NULL,
  `income_type_id` int(10) unsigned NOT NULL,
  `project_id` int(10) unsigned NOT NULL,
  `account_id` int(10) unsigned NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `incomes_income_type_id_foreign` (`income_type_id`),
  KEY `incomes_project_id_foreign` (`project_id`),
  KEY `idx_date` (`date`,`amount`),
  KEY `incomes_account_id_foreign` (`account_id`),
  KEY `idx_created` (`created_at`),
  FULLTEXT KEY `idx_full_title` (`title`),
  CONSTRAINT `incomes_account_id_foreign` FOREIGN KEY (`account_id`) REFERENCES `accounts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `incomes_income_type_id_foreign` FOREIGN KEY (`income_type_id`) REFERENCES `income_types` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `incomes_project_id_foreign` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=62 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla vertical.incomes: ~58 rows (aproximadamente)
/*!40000 ALTER TABLE `incomes` DISABLE KEYS */;
INSERT INTO `incomes` (`id`, `title`, `payment`, `date`, `note`, `amount`, `income_type_id`, `project_id`, `account_id`, `deleted_at`, `created_at`, `updated_at`) VALUES
	(1, 'Pago vivienda 6to anillo', 'Efectivo', '2018-07-07', NULL, 2085.00, 1, 1, 1, NULL, '2020-04-24 16:43:58', '2020-04-24 16:45:05'),
	(2, 'Pago apartamento villa fatima refaccion', 'Efectivo', '2018-07-07', NULL, 9730.00, 1, 2, 1, NULL, '2020-04-27 11:34:26', '2020-05-04 17:34:30'),
	(3, 'Pago demolicion villa fatima', 'Efectivo', '2018-07-07', NULL, 17375.00, 1, 3, 1, NULL, '2020-04-27 14:25:39', '2020-04-27 14:25:39'),
	(4, 'Pago avalúo', 'Efectivo', '2018-07-07', NULL, 300.00, 1, 5, 1, NULL, '2020-04-27 14:42:47', '2020-04-27 14:42:47'),
	(5, 'Pago avaluo', 'Efectivo', '2018-07-07', NULL, 300.00, 1, 4, 1, NULL, '2020-04-27 14:43:23', '2020-04-27 14:43:23'),
	(6, 'Pago avaluo', 'Efectivo', '2018-07-08', NULL, 300.00, 1, 6, 1, NULL, '2020-04-27 14:44:00', '2020-04-27 14:44:00'),
	(7, 'Pago diseño arquitectonico', 'Efectivo', '2018-07-07', NULL, 700.00, 1, 7, 1, NULL, '2020-04-27 14:55:42', '2020-04-27 14:55:42'),
	(8, 'Pago diseño arquitectonico', 'Efectivo', '2018-07-07', NULL, 500.00, 1, 8, 1, NULL, '2020-04-27 14:56:24', '2020-04-27 14:56:24'),
	(9, 'Pago  diseño arquitectónico', 'Efectivo', '2018-07-06', NULL, 1000.00, 1, 9, 1, NULL, '2020-04-27 14:58:47', '2020-04-27 14:58:47'),
	(10, 'Pago  avaluo', 'Efectivo', '2018-07-07', NULL, 300.00, 1, 10, 1, NULL, '2020-04-29 10:27:28', '2020-04-29 10:27:44'),
	(11, 'Pago diseño arquitectónico', 'Efectivo', '2018-07-07', NULL, 1400.00, 1, 11, 1, NULL, '2020-04-29 10:30:22', '2020-04-29 10:30:22'),
	(12, 'Pago de supervision', 'Efectivo', '2018-07-07', NULL, 31000.00, 1, 12, 1, NULL, '2020-04-29 10:39:26', '2020-04-29 10:39:26'),
	(13, 'Pago de supervicion', 'Efectivo', '2018-07-07', NULL, 39513.00, 1, 13, 1, NULL, '2020-04-29 10:43:08', '2020-04-29 10:43:08'),
	(14, 'Pago de calamina', 'Efectivo', '2018-07-07', NULL, 400.00, 1, 14, 1, NULL, '2020-04-29 10:47:06', '2020-04-29 10:47:06'),
	(15, 'Pago de construccion', 'Efectivo', '2018-07-07', NULL, 625650.00, 1, 15, 1, NULL, '2020-04-29 10:51:41', '2020-04-29 10:51:41'),
	(16, 'Pago varios benjamin', 'Efectivo', '2018-07-07', NULL, 500.00, 1, 16, 1, NULL, '2020-04-29 10:57:12', '2020-04-29 10:57:12'),
	(17, 'Pago diseño arquitectónico', 'Efectivo', '2018-07-07', NULL, 2780.00, 1, 17, 1, NULL, '2020-04-29 11:01:33', '2020-04-29 11:01:33'),
	(18, 'Pago de factura', 'Efectivo', '2018-07-07', NULL, 14327.00, 1, 18, 1, NULL, '2020-04-29 11:56:47', '2020-04-29 11:56:47'),
	(19, 'Pago avaluo', 'Efectivo', '2018-07-07', NULL, 300.00, 1, 19, 1, NULL, '2020-04-29 14:37:06', '2020-04-29 14:37:06'),
	(20, 'Pago de ampliación  baños julio rojas', 'Efectivo', '2018-07-07', NULL, 208500.00, 1, 20, 1, NULL, '2020-04-29 14:39:49', '2020-04-29 14:55:57'),
	(21, 'Pago de legalización de proyecto', 'Efectivo', '2018-07-07', NULL, 6567.75, 1, 21, 1, NULL, '2020-04-29 14:59:16', '2020-04-29 14:59:16'),
	(22, 'Pago de colocado de chapas', 'Efectivo', '2018-07-07', NULL, 2224.00, 1, 22, 1, NULL, '2020-04-29 15:16:54', '2020-04-29 15:16:54'),
	(23, 'Pago de refacción de ventanas', 'Efectivo', '2018-07-07', NULL, 24672.50, 1, 23, 1, NULL, '2020-04-29 15:19:53', '2020-04-29 15:19:53'),
	(24, 'Pago de arreglo de porton y puerta de vidrio', 'Efectivo', '2018-07-07', NULL, 521.25, 1, 24, 1, NULL, '2020-05-01 10:33:20', '2020-05-01 10:33:20'),
	(25, 'Pago gas domiciliario villa fatima', 'Efectivo', '2018-07-07', NULL, 6395.00, 1, 25, 1, NULL, '2020-05-01 10:36:14', '2020-05-01 10:36:14'),
	(26, 'Pago avaluó Freddy Guevara', 'Efectivo', '2018-07-07', NULL, 700.00, 1, 26, 1, NULL, '2020-05-01 10:40:39', '2020-05-01 10:40:39'),
	(27, 'Pago diseño arquitectónico', 'Efectivo', '2018-07-07', NULL, 1000.00, 1, 27, 1, NULL, '2020-05-01 10:48:41', '2020-05-01 10:48:41'),
	(28, 'Pago de construcción sauna julio rojas', 'Efectivo', '2018-07-07', NULL, 59519.50, 1, 28, 1, NULL, '2020-05-01 10:52:32', '2020-05-04 09:53:53'),
	(29, 'Pago diseño arquitectonico', 'Efectivo', '2018-07-07', NULL, 1300.00, 1, 29, 1, NULL, '2020-05-01 10:54:59', '2020-05-01 10:54:59'),
	(30, 'Pago refacción apartamento', 'Efectivo', '2018-07-07', NULL, 69578.15, 1, 30, 1, NULL, '2020-05-01 10:57:23', '2020-05-04 15:44:09'),
	(31, 'Pago demolición vivienda loayza', 'Efectivo', '2018-07-07', NULL, 8700.00, 1, 31, 1, NULL, '2020-05-01 11:01:10', '2020-05-01 11:01:10'),
	(32, 'Pago vivienda moron', 'Efectivo', '2018-07-07', NULL, 320700.00, 1, 32, 1, NULL, '2020-05-01 11:04:46', '2020-05-01 11:04:46'),
	(33, 'Pago construcción vivienda loayza', 'Efectivo', '2018-07-07', NULL, 626350.00, 1, 33, 1, NULL, '2020-05-01 11:18:42', '2020-05-01 11:18:42'),
	(34, 'Pago diseño arquitectónico', 'Efectivo', '2018-07-07', NULL, 4869.00, 1, 34, 1, NULL, '2020-05-01 11:22:06', '2020-05-01 11:22:06'),
	(35, 'Pago amoblamiento villa fatima', 'Efectivo', '2018-07-07', NULL, 70493.85, 1, 35, 1, NULL, '2020-05-01 11:26:50', '2020-05-01 11:26:50'),
	(36, 'Pago de construcción churrasquera', 'Efectivo', '2018-07-07', NULL, 243250.00, 1, 36, 1, NULL, '2020-05-01 11:29:24', '2020-05-01 11:29:24'),
	(37, 'Pago diseño arquitectónico Marisol', 'Efectivo', '2018-07-07', NULL, 2790.00, 1, 37, 1, NULL, '2020-05-01 11:32:54', '2020-05-01 11:32:54'),
	(38, 'Pago de diseño arquitectónico', 'Efectivo', '2018-07-07', NULL, 3100.00, 1, 38, 1, NULL, '2020-05-01 11:35:50', '2020-05-01 11:35:50'),
	(39, 'Pago de intereses', 'Efectivo', '2018-07-07', NULL, 8864.00, 1, 39, 1, NULL, '2020-05-04 09:22:38', '2020-05-04 09:22:38'),
	(40, 'Pago de construcción vivienda Mary', 'Efectivo', '2018-07-07', NULL, 101620.00, 1, 40, 1, NULL, '2020-05-04 09:45:48', '2020-05-04 09:45:48'),
	(41, 'Pago de construccion', 'Efectivo', '2018-07-07', NULL, 257845.00, 1, 41, 1, NULL, '2020-05-04 09:48:27', '2020-05-04 14:53:32'),
	(42, 'Pago de refacción apartamento villa fatima', 'Efectivo', '2018-07-07', NULL, 4309.00, 1, 43, 1, NULL, '2020-05-04 09:57:05', '2020-05-04 17:54:35'),
	(43, 'Pago de cambio de cables vivienda sexto anillo', 'Efectivo', '2018-07-07', NULL, 13900.00, 1, 44, 1, NULL, '2020-05-04 09:59:47', '2020-05-04 09:59:47'),
	(44, 'Pago demolicion sexto anillo', 'Efectivo', '2018-07-07', NULL, 9313.00, 1, 45, 1, NULL, '2020-05-04 10:02:38', '2020-05-04 10:02:38'),
	(45, 'Pago de jardinería y blindex roto', 'Efectivo', '2018-07-07', NULL, 1668.00, 1, 46, 1, NULL, '2020-05-04 10:10:19', '2020-05-04 10:10:19'),
	(46, 'Pago de refacción acera', 'Efectivo', '2018-07-07', NULL, 1400.00, 1, 47, 1, NULL, '2020-05-04 10:25:10', '2020-05-04 10:25:10'),
	(47, 'Pago diseño arquitectonico', 'Efectivo', '2018-07-07', NULL, 2085.00, 1, 48, 1, NULL, '2020-05-04 10:42:47', '2020-05-04 10:42:47'),
	(48, 'Pago de supervision', 'Efectivo', '2018-07-07', NULL, 7500.00, 1, 49, 1, NULL, '2020-05-04 10:47:52', '2020-05-04 10:47:52'),
	(49, 'Pago de construcción vivienda bonilla', 'Efectivo', '2018-07-07', NULL, 31320.00, 1, 50, 1, NULL, '2020-05-04 10:55:41', '2020-05-04 10:55:41'),
	(50, 'Pago diseño arquitectonico', 'Efectivo', '2018-07-07', NULL, 2200.00, 1, 51, 1, NULL, '2020-05-04 10:59:57', '2020-05-04 10:59:57'),
	(51, 'Pago de avaluo marisol', 'Efectivo', '2018-07-07', NULL, 600.00, 1, 52, 1, NULL, '2020-05-04 11:05:42', '2020-05-04 11:05:42'),
	(52, 'Pago de pintado de apartamento tatiana', 'Efectivo', '2018-07-07', NULL, 2920.00, 1, 53, 1, NULL, '2020-05-04 11:29:16', '2020-05-04 11:29:16'),
	(53, 'Pago de construccion', 'Efectivo', '2018-07-07', NULL, 139000.00, 1, 54, 1, NULL, '2020-05-04 11:30:43', '2020-05-04 11:30:43'),
	(54, 'Pago de construccion', 'Efectivo', '2018-07-07', NULL, 35750.00, 1, 55, 1, NULL, '2020-05-04 11:35:43', '2020-05-04 11:35:43'),
	(55, 'pago vivienda moron barda', 'Efectivo', '2018-07-07', NULL, 21000.00, 1, 32, 1, NULL, '2020-05-04 11:55:50', '2020-05-04 11:55:50'),
	(56, 'Pago diseño arquitectónico', 'Efectivo', '2018-07-07', NULL, 500.00, 1, 56, 1, NULL, '2020-05-04 14:34:00', '2020-05-04 14:34:00'),
	(57, 'Pago de supervicion obra mediterraneo', 'Efectivo', '2018-07-07', NULL, 2000.00, 1, 57, 1, NULL, '2020-05-04 14:37:51', '2020-05-04 14:37:51'),
	(58, 'Pago anticipo de barda', 'Efectivo', '2020-06-04', NULL, 7000.00, 1, 32, 1, NULL, '2020-06-04 14:05:38', '2020-06-04 14:05:38');
/*!40000 ALTER TABLE `incomes` ENABLE KEYS */;

-- Volcando estructura para tabla vertical.income_types
CREATE TABLE IF NOT EXISTS `income_types` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` mediumtext COLLATE utf8mb4_unicode_ci,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  FULLTEXT KEY `idx_full_text` (`name`,`description`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla vertical.income_types: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `income_types` DISABLE KEYS */;
INSERT INTO `income_types` (`id`, `name`, `description`, `deleted_at`, `created_at`, `updated_at`) VALUES
	(1, 'Pago Final', NULL, NULL, '2020-04-24 16:37:27', '2020-04-24 16:37:27');
/*!40000 ALTER TABLE `income_types` ENABLE KEYS */;

-- Volcando estructura para tabla vertical.materials
CREATE TABLE IF NOT EXISTS `materials` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `unity` enum('amarro','barra','bolsa','caja','cajón','carga','dm³','fajo','fardo','g','galón','glb','ha','juego','kg','l','lata','lb','m','m²','m³','mm','perfil','pie','pie²','placa','plomo','pqte','pto','pza','resma','rollo','t','tubo','turril','unds') COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` mediumtext COLLATE utf8mb4_unicode_ci,
  `price` double(9,2) DEFAULT NULL,
  `material_type_id` int(10) unsigned NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `materials_category_id_foreign` (`material_type_id`),
  FULLTEXT KEY `idx_full_name` (`name`),
  CONSTRAINT `materials_category_id_foreign` FOREIGN KEY (`material_type_id`) REFERENCES `material_types` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla vertical.materials: ~12 rows (aproximadamente)
/*!40000 ALTER TABLE `materials` DISABLE KEYS */;
INSERT INTO `materials` (`id`, `name`, `unity`, `description`, `price`, `material_type_id`, `deleted_at`, `created_at`, `updated_at`) VALUES
	(1, 'Barbijo de tela lavable', 'pza', NULL, 2.00, 1, '2020-06-04 10:15:51', '2020-06-04 10:13:35', '2020-06-04 10:15:51'),
	(2, 'Barbijo lavable', 'pza', NULL, 2.00, 2, NULL, '2020-06-04 10:17:52', '2020-06-04 10:17:52'),
	(3, 'cemento warnes', 'bolsa', NULL, 44.00, 3, NULL, '2020-06-04 10:20:08', '2020-06-04 10:20:08'),
	(4, 'Madera tajibo', 'pie²', NULL, 14.00, 4, NULL, '2020-06-04 12:26:23', '2020-06-04 12:26:23'),
	(5, 'Liston palomaria', 'm', NULL, 7.50, 4, NULL, '2020-06-04 12:33:29', '2020-06-04 12:33:29'),
	(6, 'Ladrillo adobito', 'pza', NULL, 0.55, 5, NULL, '2020-06-04 12:37:00', '2020-06-04 12:37:00'),
	(7, 'Clavo de 3 1/2', 'kg', NULL, 12.00, 6, NULL, '2020-06-04 12:46:33', '2020-06-04 12:46:33'),
	(8, 'Guantes asatex', 'pza', NULL, 7.50, 7, NULL, '2020-06-04 12:51:04', '2020-06-04 12:51:04'),
	(9, 'Malla de gallinero 40 mts', 'rollo', NULL, 110.00, 8, NULL, '2020-06-04 12:52:22', '2020-06-04 12:52:22'),
	(10, 'paja para techado', 'bolsa', NULL, 12.00, 9, NULL, '2020-06-04 12:54:55', '2020-06-04 12:54:55'),
	(11, 'ARENILLA', 'm³', NULL, 75.00, 10, NULL, '2020-06-04 13:03:59', '2020-06-04 13:03:59'),
	(12, 'Material de clarita', 'glb', NULL, 0.00, 11, NULL, '2020-06-04 13:57:12', '2020-06-04 13:57:12');
/*!40000 ALTER TABLE `materials` ENABLE KEYS */;

-- Volcando estructura para tabla vertical.material_types
CREATE TABLE IF NOT EXISTS `material_types` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` mediumtext COLLATE utf8mb4_unicode_ci,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  FULLTEXT KEY `idx_full_text` (`name`,`description`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla vertical.material_types: ~11 rows (aproximadamente)
/*!40000 ALTER TABLE `material_types` DISABLE KEYS */;
INSERT INTO `material_types` (`id`, `name`, `description`, `deleted_at`, `created_at`, `updated_at`) VALUES
	(1, 'Limpieza e higiene', NULL, '2020-06-04 10:15:58', '2020-06-04 10:12:52', '2020-06-04 10:15:58'),
	(2, 'Higiene y limpieza', NULL, NULL, '2020-06-04 10:17:19', '2020-06-04 10:19:26'),
	(3, 'Cemento', NULL, NULL, '2020-06-04 10:19:42', '2020-06-04 10:19:42'),
	(4, 'MADERAS', NULL, NULL, '2020-06-04 12:15:55', '2020-06-04 12:15:55'),
	(5, 'LADRILLOS', NULL, NULL, '2020-06-04 12:36:04', '2020-06-04 12:40:51'),
	(6, 'CLAVOS', NULL, NULL, '2020-06-04 12:40:57', '2020-06-04 12:40:57'),
	(7, 'EPP', NULL, NULL, '2020-06-04 12:49:00', '2020-06-04 12:49:00'),
	(8, 'MALLAS', NULL, NULL, '2020-06-04 12:51:43', '2020-06-04 12:51:43'),
	(9, 'PAJA', NULL, NULL, '2020-06-04 12:54:09', '2020-06-04 12:54:09'),
	(10, 'ARIDOS', NULL, NULL, '2020-06-04 12:59:55', '2020-06-04 12:59:55'),
	(11, 'PLOMERIA', NULL, NULL, '2020-06-04 13:56:45', '2020-06-04 13:56:45');
/*!40000 ALTER TABLE `material_types` ENABLE KEYS */;

-- Volcando estructura para tabla vertical.migrations
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla vertical.migrations: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;

-- Volcando estructura para tabla vertical.oauth_access_tokens
CREATE TABLE IF NOT EXISTS `oauth_access_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `client_id` int(10) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_access_tokens_user_id_index` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla vertical.oauth_access_tokens: ~15 rows (aproximadamente)
/*!40000 ALTER TABLE `oauth_access_tokens` DISABLE KEYS */;
INSERT INTO `oauth_access_tokens` (`id`, `user_id`, `client_id`, `name`, `scopes`, `revoked`, `created_at`, `updated_at`, `expires_at`) VALUES
	('0724865791e459df7c1c293105b01cd4fea94b01efa496d011d5a30be5cda9b66e54e84162fbbb62', 1, 2, NULL, '[]', 0, '2020-06-21 18:15:24', '2020-06-21 18:15:24', '2020-12-21 18:15:24'),
	('164c782e2c606d4ab81844f16272e2e0bc1dc0842c5ef540dfb16f64837042628b97388a7fcba3ef', 2, 2, NULL, '[]', 1, '2020-06-21 18:14:42', '2020-06-21 18:14:42', '2020-12-21 18:14:42'),
	('16aecb2848776aa74af66949c18c83495855cbe734450f7be67f8f5a7d8e2bf4f04520b9b1fd7f9b', 1, 2, NULL, '[]', 0, '2019-12-11 17:32:12', '2019-12-11 17:32:12', '2020-06-11 17:32:10'),
	('1a8d3475d5f5fbb430220e4409db5377449dda37009ee3b7b0d6b81a2b00303ea3cb5b628061d0fd', 1, 2, NULL, '[]', 0, '2019-12-16 16:09:41', '2019-12-16 16:09:41', '2020-06-16 16:09:37'),
	('33db64d05cbb5709369ef5779a6242e533c2456016b3d67b33dec701aa5008d84cf8e424ebc4efc3', 1, 2, NULL, '[]', 1, '2020-06-19 09:41:33', '2020-06-19 09:41:33', '2020-12-19 09:41:31'),
	('58d5d051e0c4afccd22c5798ebf1190eaade7edae8e9465a783ca831b2cf9a5609e89caae36caa1e', 1, 2, NULL, '[]', 0, '2020-06-13 11:26:11', '2020-06-13 11:26:11', '2020-12-13 11:26:11'),
	('76d82ff1ff16a76f533e38f389b78e6a90c81e0703fed531f3b5d23d966c62728b182baad1000456', 1, 2, NULL, '[]', 0, '2019-10-17 14:54:34', '2019-10-17 14:54:34', '2020-04-17 14:54:33'),
	('832f88d77f6c29d914ab4e129b032cb3834acc633df86e9fa40d88ca5d8c76bc11e6ab1524312930', 1, 2, NULL, '[]', 1, '2020-06-13 10:13:50', '2020-06-13 10:13:50', '2020-12-13 10:13:49'),
	('8e4f7a2b9cf519f3ecb8d253f521917af662b7250d78e0f38ff5e5517f08e87eca6049876a6c79fb', 1, 2, NULL, '[]', 0, '2019-10-17 11:17:47', '2019-10-17 11:17:47', '2020-04-17 11:17:47'),
	('9a9a348bd8bc8a40ed553db6d205bc5d711fc9f1ee16b35e6c48d137c3011976eb854fcb708e6dfd', 1, 2, NULL, '[]', 1, '2020-01-28 09:32:17', '2020-01-28 09:32:17', '2020-07-28 09:32:13'),
	('a129afad0c238d4a7dc00329594e232d292c12d6a58438a41c7e10555d726bc1e29fe596722917de', 1, 2, NULL, '[]', 0, '2019-10-17 11:16:45', '2019-10-17 11:16:45', '2020-04-17 11:16:43'),
	('a286f4160b708cad4a9798fecf7f2b3a77fda7d06a5f46aca15afbd4872d7fc9bca681ab22f41446', 1, 2, NULL, '[]', 0, '2020-01-28 20:25:57', '2020-01-28 20:25:57', '2020-07-28 20:25:56'),
	('a7a0fe4f03abc31c66839f5fdec456d63b22cb75b502d69a7e0b62cd3edbfda188b43e13d81cd498', 1, 2, NULL, '[]', 0, '2020-01-28 18:26:05', '2020-01-28 18:26:05', '2020-07-28 18:26:04'),
	('d2d4e618157bd94242451e780569510aac094e8e221661dbb6cd78c17d6fe907f0b6bc8a5d91f0c9', 1, 2, NULL, '[]', 1, '2020-06-21 18:11:44', '2020-06-21 18:11:44', '2020-12-21 18:11:43'),
	('e32867d1a8046bc58b15b6a46255ebb398532bd4d690c0e3cf5614bc5fef51f157e42994780ac904', 1, 2, NULL, '[]', 0, '2020-06-13 10:16:22', '2020-06-13 10:16:22', '2020-12-13 10:16:22');
/*!40000 ALTER TABLE `oauth_access_tokens` ENABLE KEYS */;

-- Volcando estructura para tabla vertical.oauth_auth_codes
CREATE TABLE IF NOT EXISTS `oauth_auth_codes` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `client_id` int(10) unsigned NOT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla vertical.oauth_auth_codes: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `oauth_auth_codes` DISABLE KEYS */;
/*!40000 ALTER TABLE `oauth_auth_codes` ENABLE KEYS */;

-- Volcando estructura para tabla vertical.oauth_clients
CREATE TABLE IF NOT EXISTS `oauth_clients` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `secret` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `redirect` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `personal_access_client` tinyint(1) NOT NULL,
  `password_client` tinyint(1) NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_clients_user_id_index` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla vertical.oauth_clients: ~2 rows (aproximadamente)
/*!40000 ALTER TABLE `oauth_clients` DISABLE KEYS */;
INSERT INTO `oauth_clients` (`id`, `user_id`, `name`, `secret`, `redirect`, `personal_access_client`, `password_client`, `revoked`, `created_at`, `updated_at`) VALUES
	(1, NULL, 'Laravel Personal Access Client', '8BvErXJF8YYILVEK9qa8Lv5KDZ9w57T6qXcYEY9C', 'http://localhost', 1, 0, 0, '2019-06-07 18:17:17', '2019-06-07 18:17:17'),
	(2, NULL, 'Laravel Password Grant Client', 'MvNwKG07eIYAVJv3AODtU7Wh3q9kKGYiFmQAYrsr', 'http://localhost', 0, 1, 0, '2019-06-07 18:17:20', '2019-06-07 18:17:20');
/*!40000 ALTER TABLE `oauth_clients` ENABLE KEYS */;

-- Volcando estructura para tabla vertical.oauth_personal_access_clients
CREATE TABLE IF NOT EXISTS `oauth_personal_access_clients` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `client_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_personal_access_clients_client_id_index` (`client_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla vertical.oauth_personal_access_clients: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `oauth_personal_access_clients` DISABLE KEYS */;
INSERT INTO `oauth_personal_access_clients` (`id`, `client_id`, `created_at`, `updated_at`) VALUES
	(1, 1, '2019-06-07 18:17:20', '2019-06-07 18:17:20');
/*!40000 ALTER TABLE `oauth_personal_access_clients` ENABLE KEYS */;

-- Volcando estructura para tabla vertical.oauth_refresh_tokens
CREATE TABLE IF NOT EXISTS `oauth_refresh_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `access_token_id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_refresh_tokens_access_token_id_index` (`access_token_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla vertical.oauth_refresh_tokens: ~201 rows (aproximadamente)
/*!40000 ALTER TABLE `oauth_refresh_tokens` DISABLE KEYS */;
INSERT INTO `oauth_refresh_tokens` (`id`, `access_token_id`, `revoked`, `expires_at`) VALUES
	('00ec6aa4d2f1c96d136fdc0d1ee9e4e18477a577305a6aab1fafae1c92b83818729425b5f62c75e4', 'f0fb2bd6e14adc3727e3af68afbff608c06b894a6ac8642bb0f91da481c6c85f1d18090481fb968f', 1, '2020-01-31 03:28:14'),
	('01815702e5c7a47326b51bb56de29e59171d8b751b9373ef0387d80ddc72fecc88488d1e86a61320', 'c7a2001f3ef15d73cd8ca5901469c673d266dfe2a3c9efdfb18392fe3c4404ddc14bc019e9651935', 1, '2020-02-17 19:16:07'),
	('02b154933dadf8899f3df66d4bd51428a82f765cf7559dcae17188e9c153555b2723043513a950f4', 'a129afad0c238d4a7dc00329594e232d292c12d6a58438a41c7e10555d726bc1e29fe596722917de', 0, '2020-04-17 11:16:43'),
	('06976aa9813be1d4fe1e8d76a025325835072c56f7a1524f14ad29045f97906f82b34b010a451b9a', '6b8e010eec8745977471c4069021299aaafa4397dac64de372f087df1df9a69bfd8702388670cb5e', 1, '2020-01-31 15:13:07'),
	('06d6f56aadfaac3d58a559fd13497feb271abb65199d0416c53ef876a10947e4e4eafec505aa6352', '3af076bc63b9d43806f6d74a6deab1f728a1469c3065822b59cfcfbf30cb03b5bf62858db514173f', 1, '2020-02-02 19:33:46'),
	('079a32502158aecbfa411dffc4badb92c0f437e157a2ea63dcca1ae832801ad70b61841223b950dd', '570f21fbbb59cb5e87488fe7ef6552deab36689dc283ea59f55c9586a55ea2dcaec11f430e545aa0', 1, '2020-02-01 22:06:03'),
	('07c3090805a4ffa2562724bd6038365474fd647a6eb7fcb47fa5a9bea3b7a9a51d6628ab3457aa54', 'b6c262be6fbc6f0f3e9bd46b865918d144ba929d6ca4737718dd182c404b7cbb3710e97832e86bda', 0, '2020-01-30 18:46:25'),
	('0a075233813a87d4c1c532626e37ce6f0af480653a60bd289608b7ea69f09fdd407f531da41175eb', 'b4401cb89c42646461f2199f5e5e08e4a4833a1b1131282d8d4e55c00f4c8c358633985d84918cd2', 1, '2019-08-28 01:22:17'),
	('0b5b314e89ac033b1ab4abe57625c36c5f00ff36b4bbf81a5f43f315db5c2fa81e8ec75366345e6d', 'b4d28ff5e8e179f236f9f8c3e8670d38a9d557a951cefb3162a227535a2afdad1cafce5be72025c7', 1, '2020-02-01 19:15:23'),
	('0b7e45f4796150486c150edaf753e46f9d7c9f09b86a5f1c01072930e7b57736be8a5ceed2622907', '2a167478fe773b7d05fc825cb9b59e3a8235ee465a61316448e06c141d5d472523123ca8e34a9131', 0, '2020-04-09 23:07:58'),
	('0c3d3d5ef2c8816d72cc23aef8afa6eb159d0cc55441f20a7e4d59c41cc5b7129b809ebdc4fcf820', 'd0cf4f69528ed59915468fbcaaaabea9ce9397e907e79ceb03b5f59932cda245d13eff53934bd525', 1, '2020-02-19 20:05:39'),
	('0ed8697cbe2ef08face13502157eeffd5065e0a7616e46b1d6a8700c19b1626d2655fb6893a2f40c', 'c52c3cfb0ee7fe6b530ef243dfe5d5a82622bffaa445daf0600cbcfa5eb94c2bcf7b429d4007adbb', 1, '2020-02-01 22:03:49'),
	('11c14b6d18a3c31cac858d6ccb7a8ee39db787413f8d67835f97570cfc9a7518e0b4205b309f8e81', '76d82ff1ff16a76f533e38f389b78e6a90c81e0703fed531f3b5d23d966c62728b182baad1000456', 0, '2020-04-17 14:54:33'),
	('145e8cb75634a78e595b4843d0994682771352929c1e0d0e221f464ccee715ffc7e11effdcc6f6f1', '1d2bf18711ba11f00a0771975ff418ce6ac830876b6c2d07062d38640e564c450dc34f2fda7c0fd1', 1, '2020-04-09 16:37:16'),
	('1510a6369db1b3ad5b82317e21b981a62f749466690ef945ad5df8b543f16139fc80e55c0f20d237', '8e4f7a2b9cf519f3ecb8d253f521917af662b7250d78e0f38ff5e5517f08e87eca6049876a6c79fb', 0, '2020-04-17 11:17:47'),
	('15ff364489467ab41deeb18a550b07816bffd6ccb58f6c3ad8cc3e8e91deec7bc8dd9c499d7c0d56', 'b1e27f5946d2386675110437646d8ab68b37a7711bc2e4fb48d51f50bb6e3f0d3370b17920ddfd2a', 0, '2019-07-29 17:48:18'),
	('19a06323d8fd76b4f995202ce97325accd883f008a2d9028f81c66c2284eaed3bafa5fcbdcf1d6ec', '9c881611a4f75e91e8b5caeddd3c2f0b909eee67a918fe203a90d326e66f6d92e5b9049868a7e1e5', 1, '2020-02-01 02:10:13'),
	('1b234f0d8f60ccfbb615e0eb4b1d8a22484d58e8d78cc3fc865499ec8f02865b409b4c0e8a185efa', '5e633ee124e2870285a5999d83f3a42018054d435667afa45777a4933614de9e0c281fc66b1fc9c3', 0, '2019-07-30 04:04:17'),
	('1b9921172a99f9310540beefcec46f1b28e29eae341012068affccabbeb0b6ce37bef206fa83f0d5', '3e136703dde1b7098833142ee19d66ee88472329b2f6785dc1d65a2b3f7ed5e223f33612dd2e463c', 1, '2020-02-01 13:52:05'),
	('1bc3a26d1c7d8133f2a78f3c89b1cefe8569cbe7d8d9a1591123a167113ab14f0c57ae258d4e1da2', '5b8227bf5ef5f42b28bfe61339ad71947d74d2d3bbe522bee7823aebd43f387cd0d4bf3d849e4c86', 1, '2020-02-01 21:58:11'),
	('1c3488c7153a6b02a2c6d499aafd90f691e83be053df41495c7d558fcfca714fb8d1e212c04ae6df', '985839ef8d808f6345923132b5f4638b6ad5ffc0920504fc3aa86153af7057e4975f064a9ff3fc6d', 1, '2020-02-01 18:21:42'),
	('1cb3b247c31c2d7a6c10c0fdef794881658f8df437f9bc90987feed1da67f6f867c4f220caf08d9b', '5fda8e35307795ecb35f68871de5328d1974960aa21f51e3c8db792e0f7cfccdd0006f751ef3980b', 1, '2020-02-01 18:59:23'),
	('1df3f51921102d26a4257beb368baa960ec3a5e8d8597106dbfc178232ea59506cbbabe7ecd69d7f', 'fb3ef0cdbdbce7662d9c51379757d112c01fcb2ecd8573ab27e4c2dfc89eac18f7f11792c66f7793', 1, '2020-04-09 19:47:29'),
	('1df45b699c28b623b230d8e27de60de194a37d6a81c3f1dab9ff29ecefd80b23c1c0c7afcb65490d', 'b95e39402b47c562b913f7f8f033e9844105ee7be2be47f37f71962f385b00070ad048142f03bab8', 1, '2020-02-17 19:14:59'),
	('1f0efb284d60f5d69f19a436e3a7cbe815009551b68c59a053de60b454478ddd24b5850e4e3c4a4e', '4267ac86dbd4d45cd0fb755bf62977ed57e7a598eaa4aebb81aa0009c27cf51fea0d00283a3ca7bd', 1, '2020-02-07 19:37:29'),
	('1f1f5dded2db28ef8d9ab24ad51c09aa3990f734ea87dae952e48fc9a685f49a0f602c2c6e509b63', '51c1f27d86730e048c22362b329129b2e4b8b0dec2093107f96e073044b1adb9a50d38472af9f201', 1, '2020-01-31 15:08:10'),
	('1fef693da1c3c14215571de320aad93c1268c0c13afee9163960b077d3136d46f35728d350943715', 'e1bab45223bf62f0e99ec7e6a15e3db1bad005aedcd9cfea3051213b051ae2db17f9dfa1a7c41dd9', 1, '2020-02-01 22:31:23'),
	('20c1f2efdd450a5cff871652cc14f8840abfe39e596c52ec17bece0d389d8e8e3072fb9f1145fbc6', '21e825087e1ab8bc0f7865e715f565024ef0d781fabadf76713fdae7d86b66534991f6198e35ebc6', 1, '2020-02-01 19:40:17'),
	('20fa7931e17265e4e454b6ef45d4bcf2f9c2a85fd60700dfe0f9137313ecb720b9280df551899ac1', '933668b999ef34c884259143d2fa1fec6ed008a0894b0ab5053ca906c832ff3ae9eb4151d750bf74', 1, '2020-02-01 18:24:38'),
	('2166ffc5702322d02e8acbde4dff0b36b74461069f3f888c20b664e6236611afb8c3c6edbe6479ed', 'ebff359fce95decdf3c69b469ef7a3f6ed294e871c68eb15a31ba02a90b87ec24cf92e22abfbb870', 1, '2020-02-01 15:28:36'),
	('260d9c0ba0ee5e1a658f830ecabd514ec02548c80fee1d9c3ce4405a549773a32f0391fa99ceb396', 'c0fabd25edbf905486104bac11ea76aa9a764f04b2e9e976233b90e60b2fd054293da11736ae9ab2', 1, '2020-04-01 15:16:00'),
	('268540e77b6f33faecc7c0049aeed4dc7451f8304e761c9480f7436645efc3ebff4d3e663bec35d7', '4b1f0fcf2592d6bd05e3452c6b680f5a436503a42eafe50e48c82e96f57b7b3b9e4dc1a2d45d0d73', 1, '2020-02-01 01:24:57'),
	('27820b82223e8f02b38d6beb4f3a7297a0ff23b5c49b1e6f4e5b200a1607690e0e4a2e86951cf41d', 'bc33e945904baf7cac771591c04fba3f6aa1374bd48cd2f3b5fbd88452ec2f20ba3991d9055cf9b5', 0, '2019-08-27 23:37:39'),
	('2a8cc74e455ad3568c7482c21dfbedc100e565a277187fce696176d7b0527419b701c11750178b6c', '1a8d3475d5f5fbb430220e4409db5377449dda37009ee3b7b0d6b81a2b00303ea3cb5b628061d0fd', 0, '2020-06-16 16:09:37'),
	('2c935734db912284e4a572873a5412927754e6d4cad635b640206ed3cf63550b2b91dc40e1a2b759', '8952214a9753f701e8399941c184238ed8c43607e1c4b0a0904b3b699a195554d607b03fcca4d032', 1, '2020-01-31 21:10:52'),
	('2d64cf11a57258488a997df165d712da355f4afa7ce3ea2bd950d745ac43ceaf878d31a1f595dd52', 'dd9c801b9ca157abb21ffb065883c3bb3082f7ae6e58c6d66157a1dddd17c9451a8c9b0bf42434a6', 1, '2020-02-01 19:17:51'),
	('2da717c7656a03130a24acb1d409f0234e83f5de6d58f3484f2dbb8dee3df74b7ba2e5a2c4d2ff33', '33db64d05cbb5709369ef5779a6242e533c2456016b3d67b33dec701aa5008d84cf8e424ebc4efc3', 1, '2020-12-19 09:41:32'),
	('2de5520e65d7c92dfa7d9c459f8823e183071d8bd5aafba7a52c65aa2a0d9dfc36d41a681ddada17', '31e7dd7f03f8138f276d9d159b62859d23d1c032a0acaa13c8e9f25bf04ee33fc0a328e410126184', 1, '2020-04-02 21:45:14'),
	('2e2fbc498a4d5ffe577d7a1b9c8d4fd8fc62c428535995cc31de868a21cba7775a19ebb0e97aa1c5', '1670869c4b05434af1b52f73e03741cc77d8a93b2efd128f7da20442176389dc001ff3729ecf1698', 1, '2020-02-29 17:09:34'),
	('2fec193583ad2e85dcfee39606f55dd3793d9208d5a3922980733df6d07d2805c0efc1186a62ed60', 'e163adb33e8d87995618cbcb1d2deb3b6a274f9147db9ed9f48ec800bfaea7e8ab17b296a2092491', 0, '2019-07-30 17:11:41'),
	('30a778756a67473554dcf4ec8977f2da6318181934950792d4309793eda60aef1b3a84d9e2a5a0f3', '4f8167c79de744c121676e6c5e4ed995a6a0a398a7cf2e28dee7dc02a939a677a7a519c4d911882e', 1, '2020-02-19 20:01:28'),
	('30cd37fd3643bf28c906b6b5e2d07544e3f6c0488cfbeb29bd7939aceda167442766f7c2590b5b9f', 'd69a0cdd3db99406c6932320525e6440dd53afe323b01b1d55418d1a2a89d597cfdf87d7e751ec77', 1, '2019-08-28 01:45:49'),
	('31cd8892bb4a75734c33ba0dcd58b562f44828b28efa90446ec152a2451d73a2f1eba2aa3355e5b4', 'ef3de643f07fc270c77d21d1a7537295ac1abaf0bd53047962601dab273e8a3431c510b3324b240d', 0, '2019-07-30 16:36:52'),
	('33f535df850b1da0389d4625625d8b1ed6149f5a69a363746e4ba17d73a32230f96ef9fe5f7d64cb', '54109d398c435bc3f7564d3201fc70961648c5acf351188d5a7ebe7a33bbdb343d56584221a56fe7', 0, '2020-01-30 18:59:25'),
	('35ea278b6a84a58198536ffb05770e93a23f9805281e0591a0d950b56b1ca4be8bbbaca4fb979258', 'ef0ef8a197f18df34fa0cfa9d29228d8fb2fe0bd8cc5f65a7fdc1c4921a083ca354258eb1e9c4f20', 1, '2020-04-09 19:55:12'),
	('35f15ff0f5df8a23b5415e1b6f8b7e73e4fba5cc37ef87376ccfd5c3d29af678cdff85fca0c0da17', '4261a645237373830db4e8473804b702e0131156432099f0862de5f3ab19a8fc30b2acc49f733408', 1, '2020-02-01 01:48:00'),
	('37671602a5d44ec0073ef82779240163c69c17e6df2873c2d36bae30a4eeb79e48bbc7fb6c275156', '343563bab3d7a0b198bfbe6dbbcf3869cb844b3701af484b4319fa931183659de09e55984078b1a5', 1, '2020-02-01 01:35:07'),
	('37c1ff2b30441e6b69e291cd35db6d26b4da83d3207c8bb7ee47715e37e28438e9aaac440d2722da', 'af9de25cf080c6ef883ec1a7bdbe17c145d8cbfb016b2c6865648c9308d0364ee26303f92c8067f7', 1, '2020-02-21 20:43:11'),
	('38002080f42a649389d4e011c3cdaf32029fb7a5547e9fe0294cf3f03baba416b51bc32cd5b863cc', 'ea6dc0d6c908601e2b2120e1e28342a8785eb8764f087a24eeaa0f7ceb167966a5f0d308a2feb8d1', 0, '2019-08-27 23:39:29'),
	('38b0073252dc63a1a63de8cbe9f28e74e93eb9d6e4965b95482c1488a74ee017447ecdb466b05889', '90a7b69bc9ccc50d5433ef41a8c34286f109ac1cfee330fe09828c650e9593c40f59c37c2d568340', 1, '2020-02-17 19:04:39'),
	('38cb3ac8a7d4a9d47b2edebbe00866a02dd2bf552afe206ed067e12c6704ea98d2925725f44b1669', 'dcf48d99e66466ed1315abfda6ae318557f13c9793a91f56f981b4d4b57d722259c002c55ac5dba9', 1, '2020-04-09 16:32:25'),
	('39ac3b90edb5a59975a33230489170a8115dc0f7fa875b514ba65e1e20441d545dea2982704717e7', 'a728c59bd69b7713a6d2627c225787d32174197de71a356f6592062cfcb2c49e4068dc0165ebc82b', 0, '2019-08-28 00:17:30'),
	('3aca6426489130be7c9d1f17b5fc709142305e8b88e0db97e8feda6e2a708fdbe9f0f65c2f367918', 'd3c3a1e85dab7910a59995dabb67805c183159a84dc5cbee851cc839d7caa3a6f235efc988b57cf6', 1, '2020-02-01 22:33:22'),
	('40b699302a7faef533e9bcc05319825bb987a2aa58bba66b4bd93910d0f5436ee13122a43743fb23', '4ef8e8a3ad915b74829d1cfb1479b71df95ffe87a2aa8281d4981dbfe647dfb3758949bea6505d35', 1, '2020-02-21 20:46:35'),
	('4163f96c51280859b7fb35134f8410d642b8deaa95ba0466a3e7bf9fb2fd519e2cc74e197c0d9f00', 'ddcecffce486eb95447c99c3e162cdf729f3c433bf5a947a0b0147c7d7cc81b405504cfbdbd18cac', 1, '2020-02-01 19:29:43'),
	('427164716b5747f67fcd3ce3f64977b6622382d0bccf9b0e8c0094f48cf1c009df4e2195a0f5b864', '08e1628c5f423769468e571837d5e756cf77888ed890ce5e5468b25e0f2f9c6896447a079232f86d', 1, '2020-04-09 15:02:33'),
	('4334e0d865c4af3e14fa31bc48e868fe389cee5957bba40dcbff5a0a05576c2b4f1217ace20c3e20', '3bd058a971c2f7fc547f14b6cfe7e367d90628947ecc94f107a8e372ddc91e1a4b084f92ce66eeda', 1, '2020-02-29 17:08:14'),
	('4359554e17cc115ea2d7ca6bc8346247250102f2183ed62523b092416367e7c81f5f24d7125f60e4', '810b021ac8a21aefe34c14525b77b71129dda3dbaffa44c2971c3467efbf813318b64b816dc008bc', 1, '2020-02-29 15:51:42'),
	('43a160cdb41dc6765ed71501248edb254dfe53aeaf1a923ddbedcb0c96cab7cdb13335e564fd7088', 'e32867d1a8046bc58b15b6a46255ebb398532bd4d690c0e3cf5614bc5fef51f157e42994780ac904', 0, '2020-12-13 10:16:22'),
	('44a311c034abb16aa7ca37c26f9e25b8a9fb4a629e9bf356dcffe3e5724eda63ab33f5aa150df13a', '10f3282492cc5444777779192346fe9b49a05bee1c62461af1c464e3ce564f68a78792483d657bd2', 1, '2020-02-01 15:29:17'),
	('4526dc7f603ce18253b07c54428f3fe03f499fd957d2507399dcc7d4bbc5209380562b02ddd57b09', 'dfee012be55387b0c64a1894763aca63735d0a02ee78130e9cc828cfa72a35c21a2c574a94d0363f', 1, '2020-02-01 22:03:22'),
	('455ace0f127c9daca69211d3b4097595fa9a817bf01e37e0cc62bfc61b432d93b48da00206644fb8', '3b728d52d1a06ac25f22b165dac1ad4ea9b391a3a9f9ae3801035aef130f51529c4fa6803f4c54ac', 1, '2020-02-01 01:14:27'),
	('46c8123b6aa555ac8b3bdaed5da6ebbebed09f865672b25e5fc31c6f89710df0dc89177fcd8ecdaf', 'e80176e3bdbd94c01c677e26f32190be507b12a0ef48327b9601fb2dc2cdbbe0eb378daa7e34ea77', 0, '2019-08-02 14:16:53'),
	('476aa8df4b4ad576e982518774546a16d830a053c30082c05dc7a13b8a45f08df90e096168c0eebf', 'fb6765c7652aec1563b638215bf554adaf282c1fd3db89020edd58893db97b4298e3beefee89d62b', 1, '2020-02-01 15:05:51'),
	('4840bb9d9f55bdc0c22bddce56569d61ae112dbaaeb03b356b7abe400eca76f1da24df693674104e', '250426647cbcf226c6479ff057bbb5356f219233c3b83b94b56d874e83686cd1f2f9d93fc626ca6c', 1, '2020-02-01 18:23:58'),
	('484c5059584148b08858848cb590e26105fd9674d254ac74abd2f38ea63023e33d0422cd3ebbbaec', '164c782e2c606d4ab81844f16272e2e0bc1dc0842c5ef540dfb16f64837042628b97388a7fcba3ef', 1, '2020-12-21 18:14:42'),
	('489ee4a175d6e5772c04a59471c301827dbc0b51e1f044fabb5b9c5c44ddfa2b10399f2e4e8078ed', 'da175ad2b8363e307bb514cd62aa0d0c1f1aa182e8953b1a0f7c548164032e4ebef85edb42fb09b5', 1, '2020-02-01 14:10:23'),
	('48b92de83b8848541e2286cab1cccb05b9c599bc03e343ab873227141eebc870d418b724c4c6987f', '4e637021b8f2dc3e2c0a623dc978fddc050e23db58eeafd0d1113a83639a8fe45735fbc340aafe53', 1, '2020-04-02 10:36:54'),
	('49553b3b4d51fee363cee4617329d45bb78b6f04c6943c7f0a9d4794fe4ec1f53d928385a5451874', '042177d09e185bc8768b977180e5436ec6452e6ce43aec96f7271b4cb32740f0f934ab9af1e23737', 0, '2020-02-01 22:34:02'),
	('4a1c66df6efeb8e5846e1bae91bcb9d25c2f788c4796e627736d12cc661c19f921e207f17a994e93', '44f4cadc7722ef8da293b75878707c93ad253cb3b43ccce485a7b33e94a8d6714103605d0210a084', 0, '2019-08-28 13:44:19'),
	('4c6b66a95b6723fab7e80530c8c839f401f1c394db0f28955c510885ae3749d14ac317207b8e9102', 'a1140020b0c835224017c267b39c958ee303c41cfbc1f8706082de211870dd2f33ad145e250e8e23', 1, '2020-02-19 20:03:50'),
	('4ca04e41e6932cd94fc63c9b74215126eb0e9b064915fe0120e56af4b7475e89c37495c54f1d928c', '7556d4b7eba6c7c5961ef465b621127b27ff510e160f4d42358e87dd78f57f41bcf8ae61785c9bf9', 1, '2020-02-19 20:06:03'),
	('4e15be23453702b09e0add0879e502d46d56729fc0422477b60724f73015c2bf041aeccdea582df8', '9fc394e2069181e90c1785d1b7cb618c75393c9206af1764e5f3b46928a114cf9a6cdc8fc6499d73', 1, '2020-02-01 22:30:24'),
	('4fa88bef909bebcfb22d2713a1460c2c9ce4ba225dfafc05c116e7a0ee191dcb8e64ec63c245ac17', 'ea7486c1ad5343c25178701a14e9e012256c70dcab940e241dc8488521dd5ec51aabe7b530f8c8cb', 1, '2020-02-01 15:28:09'),
	('5216075a500bba5b737d699e7e3aaa3c127289d1b291cb445d51b275b648f7e06cfe1fb40f6c0bb9', '8ee8edab209a67955fafb867ad58e2cbad351f855471e9296174411bb3cf59572cb8f7b07f062f91', 1, '2020-02-01 19:49:05'),
	('555b92616a440bd19af90c389e6e7f79a775abf96ba9f0d2c4c721e89c658db1097452167ef0a9c3', '34ffb59137121b4d30dfa84e11a313b22ddd327ede39ad5ffbd53c1a521c5b1580e7c6eb8c8628c5', 1, '2020-02-19 20:02:09'),
	('55c12c1cdd66a3807011ee376272b2a22a585659760804be01542fa7cde03d58ad1daaa175388967', '7bf1a2c11720621c9b7b120f81dac4e17d759859abcd86e9c21df9790384b43c1a82e427f5fd9c70', 1, '2020-02-01 15:20:30'),
	('571224b15571740833ae2d9b1bae80a46766f7d9812cccd0ecf61e372efae372d8c7cc5f89060e9c', '15f0cad037fe9db26d5f9cf960f8bb300bfdd9e68592dafaab99b94066854c1c193a5a2e46fdb9c3', 1, '2020-01-31 21:34:53'),
	('57c6a0e3a52c7466f704df652496ae78afa5c9af9c51b48927445cc9154d5140bbdcec25446df3c3', 'f1693746ddc1f07dde7ca3dde1ee3adcc2ec4370214997186634bc0fcfdaba9ee328a89d6afad2c1', 0, '2019-08-27 23:43:41'),
	('585d92b0861439d299a39e69f96c9e57dc787ff18f64f5b8b4c7cb6c22f40a78a290f5f42625ec45', 'e76a60189d4e506c756b6162b3cc2f106ab77c6ab611cead0f5f02f8e48a8b079182e31bb9976219', 1, '2020-02-01 18:51:05'),
	('58ebb68efcbf6c9460204b0c2539bbe725015178af7f21526745a4e519abdda09108bbb92d859c8a', '3abcf5183b59c5294a16d1ab0a65a5e7d4cc083a66f4165c474123edadad3573afed60df61f839c9', 1, '2020-04-09 20:34:40'),
	('595dbbf53cfa8a40cb27374fcbb4ece002ada83305a6864c0f90f2d7cffa7ec3c0f09cec75bad9f6', '3585e7797643cb805050f95ab61ab78d4f12a588fd1fa3f40bd317a122759fdaa56c0f5b91c64c56', 0, '2019-08-28 01:47:41'),
	('5be94b571aa1185144eac3533f98c9f58162416fa240112f5f5ebef89adced915a33ce0828fd1b23', '581c6f0c5862df3c5d3241ced6a587c93e948bf87839f91bb2debcf1bf21c25d792eb26f33833899', 0, '2020-04-01 15:29:19'),
	('5c72eb2a3096e877cb69124db20d988daf2381915f0cabb20857bc9c31c16a5bfa4313b7d301b846', 'ff518346c1bce25e9d596eb15b100050285f4a6dd7b54f017fda3b667478ddd2729546b20a1f469c', 0, '2019-07-30 04:32:17'),
	('5e8a687bb37a5bc0c77edd500079c3700a0bc8ca3c524812ab3c6603eb39012e176c0a5c7f90377f', 'd635ea97a5f46d21b52e1d1597ca389ac920c6e2b36bfb5c87077e47c56e954d02d5be3d7faa6bb6', 1, '2020-02-08 03:53:53'),
	('5f540721fe8e0edd406c0c038f8936dcaf775a2f1959ecff204c796b49f520cce70a4d3e75de8798', 'a286f4160b708cad4a9798fecf7f2b3a77fda7d06a5f46aca15afbd4872d7fc9bca681ab22f41446', 0, '2020-07-28 20:25:56'),
	('5f89bb9ba58dfaaf4f49fcf456cf71026c9173fceb62fe7689a95ec85bf862c62f8d7227b1a4483d', '596de867d6fd34495b99e7be70bd9fa6a1916e66cd482c57398eeaa5a64246f7a52923f33111f818', 1, '2020-01-31 22:49:06'),
	('5fbcadff4533b6f7c021b324c2873c9d1a972a44cce241345b28ead886d28a96219d48a2c1024ddf', '152781d035065f0dfccfa428a5ead92309ed50bf256929fc72ee69b3531d564bf327403d2033c9d9', 1, '2020-02-01 22:30:03'),
	('6078d42bc1c890010f1352168a3b48fe3bee04c2c945fc3e05376787e4a25d8014e4e0105309756b', 'd14e5afca214b62fc5d25f42c3513cc993e39d64d15332f16f2199598cb998346e28dd2e9da62507', 0, '2019-08-28 14:32:29'),
	('6372f060380020c3b5ef3295a6fee3002a1e88054c80b11864d0c2e5857e26e2f275ba80239c78b6', 'c483428da0f3364eb61e0eab7b6e61448e570e191c822d5704b5875498a61af5b7e52e4a06866467', 1, '2020-02-01 18:33:23'),
	('6599d7eb03cf873ef5802e766b5f97d19e6a3f16a01b773ebe268834f6f2fb8bef1d86d35ec1887a', '5ff81f21738f11ee9565d0dc2b237c08f265b49ad5ac9040fc9d25a0c4eec67eed62456f764a04d7', 1, '2020-02-01 13:54:08'),
	('6628e5102dbcd0356bcc92f9c81acf8e9ddc4c723a4bd313fb8a122236d9463e65681ae78176d1d7', 'ad15036e6951e1b0664e07d08fefdf02d728d1e004ad6aaeb0cd77f983ba3c3fb1bf3fa094c2026c', 0, '2019-08-27 22:44:41'),
	('6715a2004bb344f6074e5ac847f07e862ba055701c3e4f8fd00549068f772542dd557b339cfe1eba', '9239c24212b4a7ea5e5569e30b91da31349fd55b84863a7a746c5be60a04e42bb6208f74351ca81d', 1, '2020-02-01 18:24:28'),
	('6791a2f97da2d42c2ffa344b2c5c565ea20003f92b1e3a568745a2f8024e0710a6b5158e2566dfd8', '0724865791e459df7c1c293105b01cd4fea94b01efa496d011d5a30be5cda9b66e54e84162fbbb62', 0, '2020-12-21 18:15:24'),
	('68d874402705034f248c61f9402d4ef27dadc18b2dc801cf52ac45c2459010c5c2d8c6b7ce2983bf', '0cc6c615db7a0269d78a469270af26eee5a427c924ef3f9b6c9e67bae171df60ef10724138aac2f6', 1, '2020-02-01 14:21:06'),
	('6a51e85119409fabde80de953332ce2994b6a94d8e3fe7018ad99e942ccb4464a33d08c35fa4cb92', 'b45b920b6ae9ae26b04bed104e9d952cb6d75e3b7c2d41e1fd57a1e045dc2baa922af583be9d4fb7', 1, '2020-03-25 22:53:14'),
	('6a7f80e60db6c5324f6fa4326344adcb8964b6ee16e5e157a48670ae4b81af2774dc66bb4cfd9776', '4dc902cb4b547806340e45b6e734594aa18cfb6db8ff76db476675070bdc46bbfb44e8988ae4615d', 1, '2020-04-09 16:42:49'),
	('6d2e2423e5c753db9de8b976c34c03c4da6383adcfee3e2ffe683ca1561f8658172e42ed2542c95a', '1f7460908f0d550d10a772fbf779304239d189ef24d120f517c15731a418484622b556bde500e859', 1, '2020-02-29 15:54:17'),
	('6f69d8a03a2e53051ef444af78edabe7b32019038cf9537afcbc5cd13b87ff1f3917a3901c093e11', '16aecb2848776aa74af66949c18c83495855cbe734450f7be67f8f5a7d8e2bf4f04520b9b1fd7f9b', 0, '2020-06-11 17:32:11'),
	('6f945cb29377bae840690af0d2e1621a08c8151a289cdbc941966bda886bf7ec9e9b819fe6502c4b', '6a339835eda359ba04681ad297a2a8895641dfbdb9ab98e13b37b32da496d9fe473bbc13969c4cc3', 1, '2020-02-01 00:53:15'),
	('707e7f3aeec70fe465bcf57dec18a15d6725b2305b0efbc1bb52cd52958108dbf34a0877be970773', '85cb0f2f1a4731cb5b98542d48528a5db6ad4c469cd12dfc7e00bb02214dcf6d708fa2fead52bb1b', 1, '2020-02-01 18:20:38'),
	('71161a92c7d8f933ee218470c3c2a22f4dd205f3721291ea0414426c8f572d88ed7946b29670f9b1', '07224b7353b1e1cfb70a769ac78149bc487559bf6921280d2393b1c46959600b8e80cc7f7bcb4c2f', 1, '2020-02-01 22:01:50'),
	('75465f59c1c21f8337a95f0939dcc96847be1bd1021bcc2d74c930577597d8248f61ac2158a4ba26', 'b5a49866b9ab95867c2c52c167ce3c7d84eba78f75adb7413bf87f703ce9b79b3f308784c26c9dd3', 1, '2020-02-01 19:38:42'),
	('784a36ecfa5f77305e39a0f1d9aefda5f8d089576b26f54b011bec8b2a82ea6f6f1a63d16c9623d3', 'ea0cfd3264f46d0f9c287743672803a90f9e5c84a4b06eaba50f4b1d589febb69fa66204920c9634', 0, '2020-02-01 18:34:20'),
	('79bfd2a21d764de64a6a7a0e59830b51ab7b2578144a3bd566a6f34e932e9b106ee7e5c38d59d435', '9a9a348bd8bc8a40ed553db6d205bc5d711fc9f1ee16b35e6c48d137c3011976eb854fcb708e6dfd', 1, '2020-07-28 09:32:13'),
	('7a1dd38164949a418d6257808209c4d7b98d21e013771543091cd3d573121ed4c5a8832f0fec6882', 'aa284ec1fc6c4b2d2eab0626fd4b3e272a579d5385153d2d89a2bf4eb7385bc43b726f7301eba04e', 0, '2020-03-01 16:26:11'),
	('7fa77e34f1581d8d812706e34f67aca57019ec96286fa942c9a03521f614828aa111cc28452ff887', 'c3c81265dc7496adadbbea1a50c474d009cec4296a04abf79459c67c2fd3a544aaaa11b3ab6a2e61', 0, '2019-07-10 19:19:13'),
	('806c357da2257d7ce8f664bfb6dcdaf7e113bd75fbdafbb04e02e1b0dd643c99af4c204bcd253728', '90ad42f4a3566223e42f52b84cbcc419097672c9f6a0a64d57bce4d16bfa992ae5e4552c717f23db', 1, '2020-02-01 22:18:07'),
	('81ec5eca845070371da1ebfd4d427084288ff523f8d19e59062bd942f6fac4f91d76a9a68dae98ed', '6aaa89912f309f6fd8beecedbfa52f51a0468657572a40f8d54441ee2ff5f3090beeb5678c110a36', 0, '2019-08-27 22:43:08'),
	('821681248c941646bc2d7bd6516e65135a00b815a5f7030c68632166ba1603bc04ae30f960bb2e70', '90a7fce5841027d16aebd8d45f6039a58f4cc5e99e648487ed527520fb3df50645732a9b8b7b58bf', 1, '2020-02-01 15:08:14'),
	('82da4fc99f76e0561b6244e05f44d58e8367915b3f29646830b97ccdfbc75ae1ea9f1df3d4816044', '4fe2f35b85fc79e776320b491c218b2618cc38ccf8373c0a685c97f5b2480408057973ad422f7066', 1, '2020-04-09 15:00:25'),
	('83fd2ec510a61f8082e455807f466a4d7634f7c0d4f4ffbcc8423b0c0813044203e1686c515718de', '16c987281a4695297c4077ac7679f5e03712ce57bb53a816ec79ccae4ef41978852d5ec3add1e123', 1, '2020-01-31 20:28:58'),
	('85cadc2d2b2d851add511bafcd679a8a70a3a92eafdb687df5c6aea85b6cc19282c11dbfe53d5501', '832f88d77f6c29d914ab4e129b032cb3834acc633df86e9fa40d88ca5d8c76bc11e6ab1524312930', 1, '2020-12-13 10:13:50'),
	('86334e12522f244030937e43425844fc2115e59341c19475976843b2829c22aa4fd8ce9d93c57582', '14a1b83b866a885cd5bbe9994a6bc86b3bb5b28767f903ef86caf854e9f6f08fe284c2607f83e23a', 1, '2020-02-01 22:24:27'),
	('8673c02435a1f768dd1b07f61879bb0fb06686acc610103668b541573dd384d06d842ccad9c27d40', 'd3373f41f0c9efabba08386ae174304d7f9a2d57b22663b7758e1972cdd391b201b9a8ad7f132c23', 1, '2020-02-01 01:26:06'),
	('8696deb84ceff3b5ce8c592efb7269c33b2cbc073d5d9dac8b3e0071b476340a9c5509a30dc655a2', '964a86bf40f0bdf8fda94cd277fcfdf6142338eca89e4b39eb6335d606a06109b648af2443ed067e', 1, '2020-02-17 19:27:27'),
	('8a2f2d62888bb8be6902a85d58a8420dbc12b04c0b1ea6e7911cce95dbfdad9e4446c024785ba840', 'a50cc614f2d7fe459dcdf21b351292da4296f4f641a7363aef39372408a4ff53244491455c0e549c', 1, '2020-02-01 22:26:45'),
	('8ddb27e24e15c024f77cb512e156e445172621fd3105c92eef20690884db5aba93ef2a87db919b5f', '3184c147a5c2310f18d1371d65f6e9dfe29779d7a59cd3873357b0eb54fd373c6a92b00747edb67b', 1, '2020-02-01 21:58:33'),
	('8df8500985cce5e7859e8062b476a42e0ad4953b426d1753370a4ab6fd0b4280c257191f1b14f9aa', 'd2d4e618157bd94242451e780569510aac094e8e221661dbb6cd78c17d6fe907f0b6bc8a5d91f0c9', 1, '2020-12-21 18:11:43'),
	('8e1db03f1e6d887921897ff783f2857f1ea18724e057c63db876f99d9cde188c7ed5e0ea92919bdf', 'a0b171216d60de61aa401ab8dda72c0980d16ebe611ba8c6b2a9a9bbfdb0215c0d3280c64c03085b', 1, '2019-07-29 17:07:16'),
	('8e6365b897e702095801885656bdfb8d6ced1324fe2c110622ffe126aa8e5118f6fcb4d295ae16ca', '29bb025814971984610e45a66089495c58b82d9f1f95fd02334758bde91d3dc64d296d64c5b458b7', 1, '2020-04-09 14:59:56'),
	('8fbd2a4136b5f38920a4018f649d1c3edb03cb1a3ee6ac24f5c14b676f9aa6c1d678d61d414a2c4a', '4196e40c8edf822b5aed9ecec91460cee4209511a6b6f59b39171ed430b6901d23e3819080d115f4', 1, '2020-02-01 19:00:50'),
	('922c10789ea266658d3e344a1614d7687df6ca5eea71a0897e57eabd4ff4a577e756656aba681f7a', '9112f5d99d0a15fd2a4b720ef72551e15697066da2fd4c5cc0bd4badd0ab73610e918c2d4d805366', 0, '2019-07-30 16:31:36'),
	('9294457821d726797f015afa6c3d91c7dd710c242c7cf955ed52718b1e39dde5ce5405a692b14962', 'f7bee82ffcf5cab74aa57fa1acfa78d45e988649a597d9b247b398b0ebb27ca9d621523f647554e3', 0, '2019-08-28 14:18:03'),
	('92af9cdf2456172e3def48d5e5ffaa9fd7629a0b00c6475746433b2ff62331ee423235140641a593', '56844394a1e644a3893919559b87fcca80f2db91d74f37c9a3dcd38195ef613a2057c9d49af928cf', 0, '2019-08-17 21:26:37'),
	('9512c7d5f39f56b5a2a643d9de56b7c39be10a255c87f448ddca2cd75b4b365320aa381cad576eb2', '2b892b9119f9cd7fa9bdcccbd82d4e010359be948a41f7e469c830a9692da8faffd47e7f744a4f3e', 1, '2020-02-01 15:29:47'),
	('98132e49d484aae12f8a340834505c458c5bafcbe9b49b7548fa87141823b367b374311e29ca3bb5', 'a7a0fe4f03abc31c66839f5fdec456d63b22cb75b502d69a7e0b62cd3edbfda188b43e13d81cd498', 0, '2020-07-28 18:26:05'),
	('9a4dfcc3ef88c8e2dfeb061941a078bd4a4ef9efd5378414a789888a630fd0a41f9cd40f0993d0ac', 'b87a087505715ecfe04355d1637b3ebb3c000a79a855de9766450dede3071630edc11ee3054bd96e', 1, '2020-02-01 21:54:03'),
	('9b6fa52265baade6e0f2c4af648db3b428b44c6697456903192b32ab6a5a8e64c27ef25da6a59d30', '8b28f772cc3d7a932959e440cf6ced32a4efc46a14aca300186df2097455471f6f2160a66d05bc9c', 0, '2020-01-30 18:54:24'),
	('9bad0672b8320c371b4f262dde53686ac10136026bd9d90f6ea203561b5c4a107879eecf30419286', '786605adffba80a9aa4f509b6dd49b52d1a7e78796454dfa0bdc7fc9d7569afe960da2dc54ff0735', 1, '2020-04-09 16:31:35'),
	('9d7267c45b0ff8eba6a7b11e3a0a00417d3a672f94dcb4c5559c9de66fc3ed9f4a928774990fda22', '2efa6c46fee497b15bb56ec431133593df61dfb9c16c3abedff97ad9802a163647ed6759a1cbe15c', 1, '2020-02-01 22:21:07'),
	('9deb372e2657833fc08baee7f2b980f956fd76d394825edff94eab0beaa2c4f908db316e058a4f95', '7fb533a86f0c7725789e029f01a0db34eb4de65dd3a12a29d8e1681187729f67e14c44a8fbc0f6d5', 1, '2020-02-01 18:10:17'),
	('9eaf8d47e55c72d853e8fbcb0f0aa97c921216d96e2e0b6dd564fe73f11f00868590b0f8b54ec366', '6f2a1aa8880d90983f9939735333cf2df0884f7f4f41c23b833b3e30749c18110699ee8a6f786f80', 1, '2020-02-01 01:46:54'),
	('9f145d539b924d50daf2c465d9daec8352c3e17d0731a6c9e7c81cb7ef4aeb4540148515e254e1d2', 'f09a970ba9f825038af9c62f7fc68fbb824d73cb33f3002a245599a91e12fa8a8132dfc12caa639c', 1, '2020-01-31 20:55:02'),
	('a030030d8f1d17e0deb3ebc38bddbb3ec3fee0e54db4d974372ed4db0d9d63da8c8f450b2be3fdd5', 'e0f063d05b1991dbca326843d374b1b56420bf473478b82a5b99e4b217907bb98e8a9a555106f114', 1, '2020-01-30 18:06:44'),
	('a251893a6a88d04512af10aff36659dd2d01bd4fc699978d6f2850ae07560249e31188589575f268', '41e34a8ea669fb355dd5224f26ddf164a79fd84952faed5cf45674a966396a578f303a9a68fc540a', 1, '2020-02-01 01:25:28'),
	('a67a3600fda1eef7be2e1d63d39f237f137cd26b67cb4d16446332cebf3c0494822ee032856ca0bd', 'c66ab6a4cc491f1df23aefdc507e894d890a7278c1d3064fcdded9c25c10fa802ee6f39aa9448f52', 1, '2020-01-31 23:51:47'),
	('a79189acdbf4e30f9f5b65370baff319299807f14b8415a7e9c705a99e140da829cd851f8bc329da', 'a2202348876034a7d1d57480eb233ac15115c00222aa9d92afb8878d4a6a883c0bd27e2716ef7f62', 1, '2019-08-28 01:23:39'),
	('a7e1c6e20cbc070aa919d545190195b0089c2b717a385a916f2dde5675abb93be0c3d6028798a1f4', '7570de59ff5b581a9cf2dc9a9f623775bf2ee40f4168f8af2c6cb2fa71b3839b44a3f438e9f9fc5c', 1, '2020-02-01 14:11:05'),
	('a85a98fdd0d26f9c33a401edfca314938436166f086336b21359fd4ab2bb70f4ab0bf9522b2dce9c', '20b1af321fa678ebcac858ce99e8a0bf28d0ded2afc5923ffccc02c3d789f2f0507cf3d2357ff74e', 0, '2019-08-27 23:41:35'),
	('a88b2d8498eef73f7a3bce15d83f140c8d159a68dd36ebb9d9155a407bc05b12f1f2c4dc6812db3f', '1109b366b73e97ca53c5b2e56b9ffbcda4b521181778fd8a054f785d3c4121e06aeaf542c64c9356', 1, '2020-02-17 19:18:59'),
	('ab01b30c660a643ddfb4f837c370e172cb9e0f8b4db69636e67076317f1d6b61dba03e635d521267', '1557263ca92c3113f4bc983b305cb1a113cde1c467a76bd908d1fa1f4ba692a8861560b4818da99c', 0, '2019-07-30 17:19:49'),
	('ad81c006271b7b776492e8c65427fdd87bd628011fca46ed95003d14ee6456b9f25d14bb0b492265', 'd77dcabf928ddad22ad34dd2ac1505bba2e9793c1157580014a2c5ede7290dc3a320d230423aa7dd', 1, '2020-04-09 16:33:29'),
	('add3cc3a25dbd53815d84887c3d4eb87148c723141b13b399d06f6b190a5acda2894ccd334d97a14', '25385dd043d021fc43b83edb48af0190d8571fc285f6499005ea1a8874efd20d138cd1b0844b3480', 1, '2020-02-16 21:08:36'),
	('ae325cdeac4bec858b4712a3f19d5e93ca1b606033e9ae93cc408d7b64621c11e7b91e639986fd72', '9d5581e96e46bc9e0db4f9551dcba407b9a9149d8bc1cce6142296126714ce909f1c236ac5ae97ae', 1, '2020-04-02 23:44:37'),
	('b0e0a1bbd8aa35a051f7d9c8b881f1e1501b2be4812d18d16e32d3f3f433cf123befd69a713643a3', 'ffc2df2d43008a8b50035e0cfd2ca45b3f9206f4e5a5a07d044d80af9b8f2617a78e3b5b1dd7367d', 1, '2020-02-01 18:51:21'),
	('b2a7a124401a24efacc999bfe4d660bce0da0094f7a788102356c65bdd1330c5587122ce7c830e39', '6228f2cf549287c225d1d92fee68911ec80517d985c5feb483cf1f081428cc077ba5df4587cb643c', 1, '2020-02-01 16:14:00'),
	('b33537e913cb6076df96b58021430678f30ee77cec8bfc1ab9083a90176673cbaf23b44496f97b19', 'ec591ae3bbe9b5032746f4396afdd49646d0697fa9eac1f0a24f3a140f5ff53a48408a8e3e5771d8', 1, '2020-02-01 01:13:32'),
	('b33ebab05cf15d12c37d75338fe7270d453f033d0aaf6bdcfa1a47f1abe7dc252dae2d06c9d5ed84', 'c47ac4727d86da3bb26667dc5a7986676e50c44ac3fcf57a145818c3b2b6eb15f9e066967fc19e76', 0, '2020-01-31 03:30:25'),
	('b39d49827494ea7aa41d114beae459f3fcf50694d6678556194c5d10b0ba64b99e2ed8ee528c9e6a', 'cecbacf00ce98c8d92bdb57ee3df4feb4bb451a55726df1658edb30b53b5383bc13ed44e00f58b55', 0, '2020-01-30 18:51:46'),
	('b489238e4586e33d682e658fba012fed058add9ff60a9093b8dbec3dc3c5443fa16d0e528d1437b2', '1ff6278006df1b2331f6b945087fbb973b14a7faa50c1d9ef750a993202d7930319835b733174bb1', 1, '2020-02-01 19:11:46'),
	('b55d1bd53e0b072678a95c7b3338ccc00b6773183c10f1891925cd7066009d9dd28ac6e504b10dc2', '0aaa1760cf095eb36c46519d2acaf9c3c496e86db199be1c64a7249a5a72bda48aad5eeaba43b0c5', 1, '2020-04-02 21:35:23'),
	('b5717453931f0a0e1676fa952f7a77864a2ca744b87015c9fbb2bfca6f3d0a00c295420c6408736b', '6a6a27069e948b520ef18a104659698ea5a9418093f209757594d339b4501d12e1f0991f56837b6a', 0, '2019-08-27 23:42:43'),
	('b7eaecd6f9940b4dab975fd83ea16823d90be59450dfcb002195612bcea6bbfb2d8e3d8ba144d1a8', 'c52d120d6ce34da16ff40b0815076367d454ca4c2c0ea1b844203c5125b11ff8a6ee6ea73f514046', 1, '2019-08-28 01:30:35'),
	('b8667be251db95a70584c553d1ace0ab50dd233b9555061ebf0ac920d2b8c18e3214a16f1642c23f', '5975541649441492c6d5ad59bc62f5bc5fd438c90009ac5c688ff95ac8fa5586102f6cc1409629b3', 1, '2020-02-01 15:21:22'),
	('b9cff6dffa39e098ad4b52f447684dd741134998598152d08a11eb40a3990ff5d9f331c4413aad03', 'c2877eba0c6c17d4d14a522f2ae41d2d8ac3ef772836ba2e4d7e7e391936bab52d4daaeee9805bf1', 1, '2020-02-01 14:01:31'),
	('bbe8c3169d9cff2a86c5fc0e93199d3cef0e1616b9c1e7b474163b462ade20d91c8880ea5c19dd20', 'c6d6937be7b77eac0e746c777be2e6f771cee8de5a5cb481baedfe8850f019b76e17e52975620c3d', 1, '2020-02-01 16:15:25'),
	('bd95a6a95426933ee53290cf2ddef9ab99cb36d58a5f45725eb1bf1f419b02e955586a900d8f85ba', '7a48d9a1508080bce4c2d9ea386a4f72623b58b0ff489e5982aaeded888246518990726cdc82daac', 1, '2020-02-01 22:24:06'),
	('bdb3179c921d8f069de312d20525b07e211f39853a75bce4529d35202ed50f8b3aae362fbff56577', 'e68106e6fad5ac80666c12a4590450d847c267e367d27b1ab5b9e4e7e48e81b49151df713be9ef63', 0, '2020-01-31 03:23:02'),
	('beb4fd538c1ba98792776162261f39774742d48c1de4736c028546484f44a04963b163851f2a6a89', '1f15022792880577a8b660f9a0184523783744fbb4800d7bbd93513ef8b7e20816ad8a56c43dd809', 1, '2020-02-01 21:05:16'),
	('bf87f0882fdf5bdec5e542ecaa425c5d4e61d697461cdd9b7cd28a565ae411eeece72dc4e71b5c2c', '2483dc61f7b582ef4bb35e06da32cd5dbe37998c1d63ecbbfa0d0fa709683a1e66076254348ced8c', 0, '2019-07-30 17:03:19'),
	('c0d67338c1be92d4bc7132a252b02ae8d5354da8dabc094e7c08c6d1c9ae533abef3d21388e1b957', '23b62d7c219df9c0e8de52db20b5503636f9d9f089aa05b2b635f6f20584f44fa8bf71db54242c19', 1, '2020-02-01 01:07:20'),
	('c25c87a4e74ba997298d2e2175af8dfdbf95429950c6a20071e7e518690545c59031d0e3ac2efe3c', '9a4845604c6ef4feba135bf6ba06b8d9bf91164bbc682d1168046342cfcb51d515d11146822cdac3', 1, '2020-02-01 22:20:25'),
	('c3669cb97ad868458a6746b3a61c1b656ac5020f47396a11b707aa6a024e750874f9cbacb956e0a5', 'd247f2019c4367eeb631143da4cfee372923c8a083fcbdda7dabb00b5439ad222f6818918476a0d0', 1, '2020-02-01 18:45:01'),
	('c54b206505691fb9a496691c0dd57c61a007b2bd98f26f3271c48dff2d27e6cf0220fe86a60bd727', 'dcc95432b917f3a7d9e5da84ddb291207193308496ea17d4c8e3cf86d45b12fba9da04a3f840fd65', 1, '2020-02-01 19:37:53'),
	('cb109d1463c35913ff5fca6c51e658e1448d2e8c23c07d0de11a0ca2e8e7047b9e74ffe50f3142bf', '515af0da51e5a0a5995bc723e588ec4b9816852c2da60606eeec42b5b3ccbb7348bf02af4fa6e54d', 0, '2019-07-29 15:34:38'),
	('ccba0be84c59601d6c007986fed871aa866eb16dcf45109b623dc847c3c1f8c47b30aa9bc9a59adb', '328827f2b6fc7010c706984f2869251ca2de7034e04d631a968622cd663be48df50f72bc86368a90', 1, '2020-02-19 18:03:17'),
	('cdf621fc0e436c2e3c031033eb9b1cc916dd54637c71fe82d7e83f9c0038bbd3dfdef13d03c767f2', 'acabd218fd75aa785aa3c983685b19cc66b4c40c84deb90b8d23864a670b08270c9cde8c48f9dc38', 1, '2020-02-01 14:12:16'),
	('d079b82af5d4e3cc52d4b5c35eb1f71bedeb57f8f4b949e33c79e46d31559bfe6c7545db5c1bac61', '77398c4b3962fec15955df4c4c9d830a12392dcfb9fab75e64bc3bdbc1a63cf98ab5402967357585', 1, '2020-01-31 21:27:39'),
	('d13d9c83061173213ba9230ecc3109f47489ad2e3b1d1006bf9d3cda05ce1dcbf0c30fa0e173d0f3', 'f1109a43037c63ebde8dc11c023bf5b108a5904301dbe04bdd9b52260c6ca1bb61fe9566acc0c501', 1, '2020-02-16 21:04:15'),
	('d25ff8d773aaedc956dc8259f22dd31ccc7cf0b2c9b3a1afb72be30ff5d47d57bd5c0fe93a565278', '886760f6f8756e9099b4ced20f2c98a3d18ff1657c54208f06bf08eed677d62427817d7390d58af9', 0, '2019-08-27 22:53:11'),
	('d2e7585825b564f196d1607cd9fc5b628bc159f82ca553c50c00b73fb7a9e2a8e409c4e6394971fa', '432330ae1d94b1bfd1448e5b752e1224a37bd2922e13b7cb7d7ab4a52a8d5db2f9b2522dfd4754a4', 1, '2020-02-01 00:09:52'),
	('d56934d3c51fae6001e555aa835a939d6bd71a660bed4a341b6ac502ab084293a224793db1450050', 'a5bc69e3c0562d46dd4a39c2c59fe71a9e6cde7a6314421128200d99ec9209cbfcd22fed23894e8f', 0, '2019-08-27 23:33:02'),
	('d6636359aa39f1f5ff5d6434693884ae75afa2d0e4ba268840ad50fe50d4fb79d98b99850d4b367e', '7faa0b3a8d2f94aa8b1f9887fe0fbbb28543c5c85c064683f927cf2924c55b4216373ada2789ae5f', 1, '2020-02-01 22:02:19'),
	('d860248fc93e46bc085a3ffe43e4bab6ba8f34d2b787649e8f98e401c8a5b8d2025a524c479f29c4', 'bbc10fab96ce5f9894cd359f56f4e40c6a282021c490b5436713306d94765944b3b26216b714fd4a', 0, '2019-08-27 22:55:59'),
	('d9ce00739c45fa9fa21c33c961f9a288f1ec40da717a5ea6c7264d9bc3524a2a1601cee292acbea7', 'ffc9ff71215743f3fe9ebcda7cf1c7c426483bea38c78e9d20714ba326cda80a78fb412023006fbd', 1, '2020-02-02 17:59:38'),
	('d9e796f7fbd4d9f1e7127493cca9236280ec8e960d3146376214b37f3ff3e500bd5b53b100531427', '439219c1d9e9a5c4733bcc91514f5acca522b4aae56c9fab011979e4d61d284aaf4ef11fca4f7418', 1, '2020-02-02 19:35:40'),
	('da2059762b0bd85c9e3d07d180c98d4b04aa6c61c59a6dcc1d415f9f035d3e1d01c9a9f94bdf9c39', '79acf9b75d710a561fc6f2c57cf4262c51f06835c8dfe326b16f2872e43f08c516b036656ea8daab', 0, '2019-07-30 16:54:04'),
	('dbf1aae73add2d2ea0dcd620e327d66a95e8720f90f20002f4a472d6d93ec9060d94e441cb21fb36', '58d5d051e0c4afccd22c5798ebf1190eaade7edae8e9465a783ca831b2cf9a5609e89caae36caa1e', 0, '2020-12-13 11:26:11'),
	('dc2ff18326d0446feb953f5317ed7a1a03300fb4264d6f4a8fa27d79cfc0219f8dfe0f3ade04a00f', '81471372511fcc0846c7636d5a489c8cd837993048bdde1c720df4c2c301223082dd19cd73d959f6', 1, '2020-02-01 02:19:10'),
	('dda80c3c8f2f45629edbce2041f3c59435bca59aa5d33013a92230cbdf40a471960568c86d4b9d53', 'fc83057ada754f408aac9e0805809a3ee5a941b8bea66ce587becd5f13baecbdda4647f7ef800289', 0, '2019-08-17 21:24:04'),
	('e24e20e9e5f26138c0077524d5e41a2e8bc441d22514df9248645ee055d29385d9d16aae4b281d82', '9cf2455629867103b02b8ee3900333398514bf473e6f89fe7ab68218f85bd426ca9d830d8cc4d08b', 1, '2020-02-01 01:45:51'),
	('e3f330bf10b09bf554d7d312c346192683ac45b7fb0c2cb67b6c5ce887350c05adb51ab0379d750d', '46db6e4f02f2775b9d645066fa00fe80160881ab670f0ef2ab8cdfcf7d2b9b0510b7effc9b3601ab', 0, '2019-07-07 18:20:33'),
	('e5229309275045b1e7cbff0c9918ad5c626abc249ed6a5883b395418f93fcc0ee2d54714f8e341a3', '10a69848f60fc041c17f4dc9982886ca97b9d26c305c33a5c56a4d4993873757068c1e3a04903344', 0, '2019-08-27 23:49:22'),
	('e5999f7dfba68916ea00225ea4ef60f0f277767ec9a5cca57b25fc93e4b77f454ad1c220ef84cb36', 'e3e1bbc191d678f3c865774013f5c5c6f7753b66192a03da8b8e21ff28c5bcdf7886c4263bd46e8e', 0, '2019-07-29 15:11:17'),
	('e6fb5ba81697577fb1b73744836419e2237db42ac5af2f61ea4405cc80458a3844be64b32701f7d2', 'fde308ad4be37e4a85b3535a0727bf7b55bc6c507b41b76e4322cbfe94bda17fc973fc87f4c3b58e', 1, '2020-02-01 01:59:58'),
	('e71a712d8db47fdf1b813bccb979e338dea53b2d8b625811cdcc3726b8bca46ed1d9a8002e90c4f0', '4e703aa7908b15c61d8f8ecc898b2bd1d6f8c64c2c251e9114e545f83572adf90a1a3ee9d496e11f', 1, '2020-02-17 03:30:02'),
	('e81acc975765b929a2c8c2318be6eaee3abce05eefe293c54a030264b1cbde0dd4c08e894db682f0', 'b52d8ea43de888ae928fb0596f8c3a5c0d8137585062fe961b7d81eabc76ee59cafdd035e89c37e3', 1, '2020-01-31 15:05:24'),
	('e9b73cb7ccd992a7820133b729546acb032debd3859d2254398e49c2e002bd3fbf39e4a10e759e0e', '8628bae0a53fdf585cdf321795a0ac964f906d345da3493c84ba7d0c7de021fb3313c0a0fdfe3d3e', 1, '2020-02-01 02:06:04'),
	('eaeaa11fca2dc5ca4fd09cf70a794421081e481a893543d78c0f2d0dd993d9742bf63548b0041bd5', 'e25b4656f93d31ced21d8b08565e5c873e5e7d86bcfa18862e6105839fade90bcc2dd751e831a6f3', 1, '2020-02-01 22:27:06'),
	('eaf64de87d24dc1ecdee8bc833823c80b183358b156bd46fc2c07d3e16f80d487c9b4ea1ad527147', '054e9b456c9ba2b11b2ac504a673956f248a4fa4bfd4733e5d8d5c3793683e1bae1d0bc51767661b', 1, '2019-08-27 23:50:57'),
	('eaffeb7f8d23e58e178843149a7e11ef920cd5a234ab503ac93e5dad164df85aa3baad5bcd3653a1', 'f70dba7652b0b050737068fc988c66a4150e9ca77b392df3d14e9cca732a9fdfa5bd0e40e2cf1f3f', 1, '2020-02-01 22:17:39'),
	('eb4179a2774fca666ba0733eb2d6da28edd207aa902ebcbf6f37ca53c286127450dab4e6d1fcf7df', '326ce677edf3db14a0bbfc33400668dc895dd205cf2cb7d7d5e9c69c5fe94b69e9d038226b54f504', 1, '2020-02-17 17:13:25'),
	('eb8b4f71bf44cfa303c96ea14a8aacc04bb08b5d9b2d8c045cd8081402617a8f6f9bfdbbb323e6ea', 'fefb5f7d6b25adf2d6c78c53a468ee014531a5d69c7c1f02c64232b762c429c5b85242d9065f4c61', 1, '2020-04-09 16:42:15'),
	('ecf74b96b6d22fc8b0539130201d25a75e363b94afc9fa0a2e5b6d8895eafc478db564436e3a4498', '5b03660d164ca6793bceedc50b8db7cb0b9cafefae9d8aa755286d85427714091dc0d90984c71b28', 1, '2019-08-04 14:38:04'),
	('ef1371c7c11114589930b8cf4c7cfb4de4e4d4fa2e4f3de3011f33874cbad73cf4a6ce15fa62b621', '983cdb2db7b56a61ab346a9fffc0f99b593e15e05d9c2542815ba9e65d9abf1e04c97abc2526a8e2', 1, '2020-02-01 18:44:20'),
	('f432a4a336922c1e071dfe4cd7c575b4d403012b588131024b3baa42b964185fa4ced8e083ec193f', '0e28f4d34cf286a80e4fc1f9f68a12afaab914e307255b0d90acea5c1ceaeba72c9538019b34cbf9', 0, '2019-08-27 22:36:04'),
	('f490206d9794261fdd15ddd79b89d41749170d6e147a45fbeb6a50b3e255da20c7144c4bfb804f1e', '1834e37b47f0448bc48645a4e684629e668310f7e53aa32cd2494efa97552d5a124bf2e0e50bc424', 1, '2020-02-01 16:17:03'),
	('faf36aecd0ba0fcbcf3a0ad28586be961bfea553ac76ce609b80274bd3134235a2af2a237534b16e', 'b7382544d86f09016f24274ac478f671c23848878102bb7da71ab6e7bfa98705c77c1572b777120d', 1, '2020-02-01 22:31:03'),
	('fb60c889d79913295c36d68071224f949def533a6a079b6add08aa0575150fcb1cd4f1596f1c5885', '0159924797e965037a11e683f04c6a147a7faa3c5e3c473029ada3c17bc0ef81d7c24a34b0c9ec59', 1, '2020-02-01 18:45:57'),
	('fdebc9bee213a3313b5ffd7b4c8584686c68196a89bd2cfc3e5aabe464a530ae370468e97ca4a61b', 'f7d9d395842e159734f7efbb9ca6f86764e38d99c15fd6b25a81eb907f98f4aa36cd78b384a71898', 1, '2020-04-09 16:40:42'),
	('ff922112c6ea44afe1b73209c6b1ef0dff261e8f37dc38943334a2a33889522615b8b1b62f1e68c4', '2255bd5a79c4729e0546c370456bd5764dbe15b12cdf2c53035a9b470d6741b755e6c4f48f56ee6c', 1, '2020-02-01 22:05:43');
/*!40000 ALTER TABLE `oauth_refresh_tokens` ENABLE KEYS */;

-- Volcando estructura para tabla vertical.password_resets
CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla vertical.password_resets: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;

-- Volcando estructura para tabla vertical.people
CREATE TABLE IF NOT EXISTS `people` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `surnames` varchar(128) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(128) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  FULLTEXT KEY `idx_full_text` (`name`,`surnames`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla vertical.people: ~3 rows (aproximadamente)
/*!40000 ALTER TABLE `people` DISABLE KEYS */;
INSERT INTO `people` (`id`, `name`, `surnames`, `phone`, `address`, `deleted_at`, `created_at`, `updated_at`) VALUES
	(1, 'Javier', 'Tantani', '76318910', NULL, NULL, '2020-06-04 11:23:08', '2020-06-04 11:23:08'),
	(2, 'Adolfo', 'Arancibia', 's/n', NULL, NULL, '2020-06-04 12:10:37', '2020-06-04 12:10:37'),
	(3, 'Jhonny', 'Serrano', '70251740', NULL, NULL, '2020-06-04 13:26:53', '2020-06-04 13:26:53');
/*!40000 ALTER TABLE `people` ENABLE KEYS */;

-- Volcando estructura para tabla vertical.profiles
CREATE TABLE IF NOT EXISTS `profiles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `description` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  FULLTEXT KEY `idx_full_description` (`description`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla vertical.profiles: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `profiles` DISABLE KEYS */;
INSERT INTO `profiles` (`id`, `description`, `deleted_at`, `created_at`, `updated_at`) VALUES
	(1, 'Administrador', NULL, '2019-10-17 11:08:53', '2019-10-17 11:08:54');
/*!40000 ALTER TABLE `profiles` ENABLE KEYS */;

-- Volcando estructura para tabla vertical.projects
CREATE TABLE IF NOT EXISTS `projects` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `location` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `comments` mediumtext COLLATE utf8mb4_unicode_ci,
  `start_date` date NOT NULL,
  `end_date` date DEFAULT NULL,
  `state` tinyint(1) NOT NULL DEFAULT '1',
  `project_type_id` int(10) unsigned NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `projects_project_types_id_foreign` (`project_type_id`),
  FULLTEXT KEY `idx_full_text` (`name`,`location`),
  CONSTRAINT `projects_project_types_id_foreign` FOREIGN KEY (`project_type_id`) REFERENCES `project_types` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=69 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla vertical.projects: ~68 rows (aproximadamente)
/*!40000 ALTER TABLE `projects` DISABLE KEYS */;
INSERT INTO `projects` (`id`, `name`, `location`, `comments`, `start_date`, `end_date`, `state`, `project_type_id`, `deleted_at`, `created_at`, `updated_at`) VALUES
	(1, 'Vivienda 6to anillo', 'radial 17 1/2  6to anillo', NULL, '2018-07-07', NULL, 1, 2, NULL, '2020-04-24 16:36:02', '2020-05-04 16:57:39'),
	(2, 'Apartamento Villa Fatima refacción antigua', 'Escuadron velasco tercer anillo', NULL, '2018-07-07', NULL, 1, 2, NULL, '2020-04-27 11:28:41', '2020-05-04 17:49:02'),
	(3, 'Demolicion villa fatima', 'Av. escuadron velasco tercer anillo', NULL, '2018-07-07', NULL, 1, 5, NULL, '2020-04-27 14:24:35', '2020-04-27 14:24:35'),
	(4, 'Irene', 'tercer anillo escuadrón velasco', NULL, '2018-07-07', NULL, 1, 6, NULL, '2020-04-27 14:40:15', '2020-04-27 14:51:14'),
	(5, 'Bismar', 'Tercer anillo av. escuadrón velasco', NULL, '2018-07-07', NULL, 1, 6, NULL, '2020-04-27 14:41:09', '2020-04-27 14:50:18'),
	(6, 'Mary', 'Robore', NULL, '2018-07-07', NULL, 1, 6, NULL, '2020-04-27 14:41:49', '2020-04-27 14:49:59'),
	(7, 'Abraham', 's/n..', NULL, '2018-07-07', NULL, 1, 1, NULL, '2020-04-27 14:48:01', '2020-04-27 14:48:01'),
	(8, 'Edelmira', 's/n..', NULL, '2018-07-07', NULL, 1, 1, NULL, '2020-04-27 14:53:02', '2020-04-27 14:53:02'),
	(9, 'Michael Morales', 'Mairana', NULL, '2018-07-07', NULL, 1, 1, NULL, '2020-04-27 14:57:58', '2020-04-27 14:57:58'),
	(10, 'Suboficial robore', 'robore', NULL, '2018-07-07', NULL, 1, 6, NULL, '2020-04-29 10:26:43', '2020-04-29 10:26:43'),
	(11, 'Mary Añez', 'Cotoca', NULL, '2018-07-07', NULL, 1, 1, NULL, '2020-04-29 10:29:30', '2020-04-29 10:29:30'),
	(12, 'Obra robore', 'Robore', NULL, '2018-07-07', NULL, 1, 3, NULL, '2020-04-29 10:38:32', '2020-04-29 10:38:32'),
	(13, 'Obra kinder camiri', 'Camiri', NULL, '2018-07-07', NULL, 1, 3, NULL, '2020-04-29 10:42:15', '2020-04-29 10:42:15'),
	(14, 'Vecino villa fatima', 'Villa fatima', NULL, '2018-07-07', NULL, 1, 7, NULL, '2020-04-29 10:46:31', '2020-04-29 10:46:31'),
	(15, 'Vivienda Julio Rojas villa fatima', 'Villa fatima', NULL, '2018-07-07', NULL, 1, 4, NULL, '2020-04-29 10:50:37', '2020-05-06 11:35:48'),
	(16, 'Diseño de mueble Benjamin', 's/n..', NULL, '2018-07-07', NULL, 1, 7, NULL, '2020-04-29 10:56:03', '2020-04-29 10:56:03'),
	(17, 'Sebastian lopez', 's/n..', NULL, '2018-07-07', NULL, 1, 1, NULL, '2020-04-29 11:00:32', '2020-04-29 11:00:32'),
	(18, 'Pago de factura', 's/n..', NULL, '2018-07-07', NULL, 1, 8, NULL, '2020-04-29 11:56:08', '2020-04-29 11:56:08'),
	(19, 'Ingrid ribera', 'Villa fatima', NULL, '2018-07-07', NULL, 1, 6, NULL, '2020-04-29 14:36:35', '2020-04-29 14:36:35'),
	(20, 'Ampliacion baños julio rojas', 'Radial 17 1/2 6to anillo', NULL, '2018-07-07', NULL, 1, 4, NULL, '2020-04-29 14:38:53', '2020-04-29 14:38:53'),
	(21, 'Legalizacion proyecto julio rojas', 'villa fatima', NULL, '2018-07-07', NULL, 1, 9, NULL, '2020-04-29 14:58:19', '2020-04-29 14:58:19'),
	(22, 'Colocado de chapas vivienda 6to anillo', 'Radial 17 1/2', NULL, '2018-07-07', NULL, 1, 7, NULL, '2020-04-29 15:15:56', '2020-04-29 15:15:56'),
	(23, 'Vivienda av brasil sra lenny', 'Av. brasil', NULL, '2018-07-07', NULL, 1, 2, NULL, '2020-04-29 15:18:45', '2020-04-29 15:18:45'),
	(24, 'Arreglo de portón y puerta de vidrio julio rojas', 'Radial 17 1/2', NULL, '2018-07-07', NULL, 1, 7, NULL, '2020-04-29 15:21:52', '2020-04-29 15:21:52'),
	(25, 'Pago de instalación de gas villa fatima', 'Villa fatima', NULL, '2018-07-07', NULL, 1, 7, NULL, '2020-05-01 10:35:09', '2020-05-01 10:35:09'),
	(26, 'Freddy Guevara', 'valle sanchez', NULL, '2018-07-07', NULL, 1, 6, NULL, '2020-05-01 10:39:49', '2020-05-01 10:39:49'),
	(27, 'Yenny ribera', 'Barrio españa', NULL, '2018-07-07', NULL, 1, 1, NULL, '2020-05-01 10:44:47', '2020-05-01 10:44:47'),
	(28, 'Sauna julio rojas', 'Radial 17 1/2', NULL, '2018-07-07', NULL, 1, 4, NULL, '2020-05-01 10:51:51', '2020-05-01 10:51:51'),
	(29, 'Ernesto', 'Av. bolivia', NULL, '2018-07-07', NULL, 1, 1, NULL, '2020-05-01 10:54:21', '2020-05-01 10:54:21'),
	(30, 'Apartamento 7 calles julio rojas', '7 calles', NULL, '2018-07-07', NULL, 1, 2, NULL, '2020-05-01 10:56:15', '2020-05-01 10:56:15'),
	(31, 'Demolición Vivienda loayza', 'Alto san pedro', NULL, '2018-07-07', NULL, 1, 5, NULL, '2020-05-01 10:58:58', '2020-05-01 11:00:32'),
	(32, 'Vivienda moron', 'Km 9 doble via la guardia', NULL, '2018-07-07', NULL, 1, 4, NULL, '2020-05-01 11:03:08', '2020-05-01 11:03:08'),
	(33, 'Vivienda loayza', 'Alto san pedro', NULL, '2018-07-07', NULL, 1, 4, NULL, '2020-05-01 11:06:19', '2020-05-01 11:06:19'),
	(34, 'Gutierrez abdias diseño arquitectónico', 'Barrio la morita', NULL, '2018-07-07', NULL, 1, 1, NULL, '2020-05-01 11:21:14', '2020-05-01 11:21:14'),
	(35, 'Vivienda rojas diseño interior', 'Villa fatima', NULL, '2018-07-07', NULL, 1, 10, NULL, '2020-05-01 11:24:22', '2020-05-01 11:25:55'),
	(36, 'Churrasquera julio rojas', 'Radial 17 1/2', NULL, '2018-07-07', NULL, 1, 4, NULL, '2020-05-01 11:28:43', '2020-05-01 11:28:43'),
	(37, 'Marisol', 'Abasto', NULL, '2018-07-07', NULL, 1, 1, NULL, '2020-05-01 11:31:47', '2020-05-01 11:31:47'),
	(38, 'Wilson zurita', 'S/N..', NULL, '2018-07-07', NULL, 1, 1, NULL, '2020-05-01 11:35:11', '2020-05-01 11:35:11'),
	(39, 'Interés de dinero prestado', 'S/N..', NULL, '2018-07-07', NULL, 1, 7, NULL, '2020-05-04 09:21:41', '2020-05-04 09:21:41'),
	(40, 'Vivienda mary', 'Urbanización tuparruete', NULL, '2018-07-07', NULL, 1, 4, NULL, '2020-05-04 09:41:12', '2020-05-04 09:41:12'),
	(41, 'Adicional vivienda julio villa fatima', 'Villa fatima', NULL, '2018-07-07', NULL, 1, 4, NULL, '2020-05-04 09:46:59', '2020-05-04 09:46:59'),
	(42, 'Sauna vivienda sexto anillo', 'Radial 17 1/2', NULL, '2018-07-07', NULL, 1, 4, '2020-05-04 09:52:34', '2020-05-04 09:50:46', '2020-05-04 09:52:34'),
	(43, 'Pintado apartamento villa fatima 2019', 'Villa fatima', NULL, '2018-07-07', NULL, 1, 2, NULL, '2020-05-04 09:56:14', '2020-05-04 17:54:58'),
	(44, 'Cambio de cables vivienda sexto anillo', 'Radial 17 1/2', NULL, '2018-07-07', NULL, 1, 2, NULL, '2020-05-04 09:58:45', '2020-05-04 09:58:45'),
	(45, 'Demolición garaje sexto anillo', 'Radial 17 1/2', NULL, '2018-07-07', NULL, 1, 5, NULL, '2020-05-04 10:01:41', '2020-05-04 10:01:41'),
	(46, 'Jardinería y vidrio', 'Villa fatima', NULL, '2018-07-07', NULL, 1, 7, NULL, '2020-05-04 10:09:20', '2020-05-04 10:09:20'),
	(47, 'Luis carlos acera', 'Av. brasil', NULL, '2018-07-07', NULL, 1, 2, NULL, '2020-05-04 10:21:24', '2020-05-04 10:21:24'),
	(48, 'Diseño de vivienda sra. Ana', 'S/N..', NULL, '2018-07-07', NULL, 1, 1, NULL, '2020-05-04 10:27:36', '2020-05-04 10:27:36'),
	(49, 'Pasillo los bosques', 'Canal isuto', NULL, '2018-07-07', NULL, 1, 3, NULL, '2020-05-04 10:47:07', '2020-05-04 10:47:07'),
	(50, 'Vivienda bonilla', 'Barrio jardín latino', NULL, '2018-07-07', NULL, 1, 4, NULL, '2020-05-04 10:49:00', '2020-05-04 10:49:00'),
	(51, 'Diseño de vivienda ronald', 'villa 1ro de mayo', NULL, '2018-07-07', NULL, 1, 1, NULL, '2020-05-04 10:58:21', '2020-05-04 10:58:21'),
	(52, 'Marisol avaluó para banco', 'Abasto', NULL, '2018-07-07', NULL, 1, 6, NULL, '2020-05-04 11:05:03', '2020-05-04 11:05:03'),
	(53, 'Pintado de apartamento tatiana', 'calla gualberto villarroel', NULL, '2018-07-07', NULL, 1, 2, NULL, '2020-05-04 11:08:44', '2020-05-04 11:08:44'),
	(54, 'Vivienda Gutierrez construccion', 'Barrio la morita', NULL, '2018-07-07', NULL, 1, 4, NULL, '2020-05-04 11:30:00', '2020-05-04 11:30:00'),
	(55, 'Propiedad portachuelo julio rojas', 'portachuelo', NULL, '2018-07-07', NULL, 1, 4, NULL, '2020-05-04 11:35:03', '2020-05-04 11:35:03'),
	(56, 'Diseño de vivienda guido', 'puente guapilo', NULL, '2018-07-07', NULL, 1, 1, NULL, '2020-05-04 14:33:08', '2020-05-04 14:33:08'),
	(57, 'obra mediterraneo', 's/n..', NULL, '2018-07-07', NULL, 1, 3, NULL, '2020-05-04 14:37:11', '2020-05-04 14:37:11'),
	(58, 'Trabajos varios casa kathe', 'Barrio flamingo', NULL, '2018-07-07', NULL, 1, 7, NULL, '2020-05-07 11:06:31', '2020-05-07 11:06:31'),
	(59, 'Construcción de deposito', 'radial 17 1/2', NULL, '2018-07-07', NULL, 1, 7, NULL, '2020-05-07 11:12:40', '2020-05-07 11:12:40'),
	(60, 'Propiedad montero julio rojas', 'montero', NULL, '2018-07-07', NULL, 1, 4, NULL, '2020-05-07 11:17:49', '2020-05-07 11:17:49'),
	(61, 'Plaza chochis', 'Robore', NULL, '2018-07-07', NULL, 1, 1, NULL, '2020-05-07 11:27:54', '2020-05-07 11:27:54'),
	(62, 'Taller mecánico roger', 'Radial 17 1/2', NULL, '2018-07-07', NULL, 1, 2, NULL, '2020-05-07 11:33:32', '2020-05-07 11:33:32'),
	(63, 'Arreglo de cocina radial y goteras en diferentes viviendas', 'Radial 17 1/2', NULL, '2018-07-07', NULL, 1, 7, NULL, '2020-05-07 16:29:26', '2020-05-07 17:57:12'),
	(64, 'Trabajos varios julio', 's/n..', NULL, '2018-07-07', NULL, 1, 7, NULL, '2020-05-07 16:31:41', '2020-05-07 16:31:41'),
	(65, 'Gastos generales', 'Oficina', NULL, '2018-07-07', NULL, 1, 11, NULL, '2020-05-07 16:43:54', '2020-05-07 16:43:54'),
	(66, 'Capacitacion de personal', 'Oficina', NULL, '2018-07-07', NULL, 1, 12, NULL, '2020-05-07 17:18:23', '2020-05-07 17:18:23'),
	(67, 'Herramientas de la empresa', 'Oficina', NULL, '2018-07-07', NULL, 1, 13, NULL, '2020-05-07 17:19:37', '2020-05-07 17:19:37'),
	(68, 'Préstamo de dinero', 'Oficina', NULL, '2018-07-07', NULL, 1, 14, NULL, '2020-05-07 19:06:25', '2020-05-07 19:06:25');
/*!40000 ALTER TABLE `projects` ENABLE KEYS */;

-- Volcando estructura para tabla vertical.project_types
CREATE TABLE IF NOT EXISTS `project_types` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` mediumtext COLLATE utf8mb4_unicode_ci,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  FULLTEXT KEY `idx_full_text` (`name`,`description`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla vertical.project_types: ~14 rows (aproximadamente)
/*!40000 ALTER TABLE `project_types` DISABLE KEYS */;
INSERT INTO `project_types` (`id`, `name`, `description`, `deleted_at`, `created_at`, `updated_at`) VALUES
	(1, 'Diseño Arquitectonico', NULL, NULL, '2020-04-24 16:28:34', '2020-04-24 16:28:53'),
	(2, 'Refacciones', NULL, NULL, '2020-04-24 16:30:33', '2020-04-24 16:30:33'),
	(3, 'Supervision De Obras', NULL, NULL, '2020-04-24 16:30:58', '2020-04-24 16:30:58'),
	(4, 'Construcción', NULL, NULL, '2020-04-24 16:32:08', '2020-04-24 16:32:08'),
	(5, 'Demolición', NULL, NULL, '2020-04-27 14:22:00', '2020-04-27 14:22:00'),
	(6, 'Avaluos', NULL, NULL, '2020-04-27 14:38:47', '2020-04-27 14:38:47'),
	(7, 'Varios', NULL, NULL, '2020-04-29 10:44:58', '2020-04-29 10:44:58'),
	(8, 'Pago de factura', NULL, NULL, '2020-04-29 11:55:28', '2020-04-29 11:55:28'),
	(9, 'Legalización de proyectos', NULL, NULL, '2020-04-29 14:57:40', '2020-04-29 14:57:40'),
	(10, 'Diseño interior', NULL, NULL, '2020-05-01 11:23:36', '2020-05-01 11:23:36'),
	(11, 'Gastos generales', NULL, NULL, '2020-05-07 16:42:55', '2020-05-07 16:42:55'),
	(12, 'Capacitacion', NULL, NULL, '2020-05-07 16:43:13', '2020-05-07 16:43:13'),
	(13, 'Herramientas de la empresa', NULL, NULL, '2020-05-07 17:18:56', '2020-05-07 17:18:56'),
	(14, 'Prestamo', NULL, NULL, '2020-05-07 19:05:36', '2020-06-04 09:55:05');
/*!40000 ALTER TABLE `project_types` ENABLE KEYS */;

-- Volcando estructura para tabla vertical.small_boxes
CREATE TABLE IF NOT EXISTS `small_boxes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `date_init` datetime NOT NULL,
  `date_end` datetime DEFAULT NULL,
  `start_amount` double(14,2) NOT NULL,
  `used_amount` double(14,2) DEFAULT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `account_id` int(10) unsigned NOT NULL,
  `state` tinyint(1) NOT NULL DEFAULT '1',
  `note` mediumtext,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `account_id` (`account_id`),
  CONSTRAINT `FK_small_boxes_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla vertical.small_boxes: ~2 rows (aproximadamente)
/*!40000 ALTER TABLE `small_boxes` DISABLE KEYS */;
INSERT INTO `small_boxes` (`id`, `date_init`, `date_end`, `start_amount`, `used_amount`, `user_id`, `account_id`, `state`, `note`, `deleted_at`, `created_at`, `updated_at`) VALUES
	(2, '2018-07-07 00:00:00', '2020-05-07 19:27:08', 3053485.00, 2795719.98, 1, 1, 0, NULL, NULL, '2020-05-04 15:34:16', '2020-05-07 19:27:08'),
	(3, '2020-06-04 00:00:00', '2020-06-05 09:58:22', 14950.50, 21948.00, 1, 1, 0, NULL, NULL, '2020-06-04 09:45:54', '2020-06-05 09:58:23');
/*!40000 ALTER TABLE `small_boxes` ENABLE KEYS */;

-- Volcando estructura para tabla vertical.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `state` tinyint(1) NOT NULL DEFAULT '1',
  `profile_id` int(10) unsigned NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  KEY `users_profile_id_foreign` (`profile_id`),
  FULLTEXT KEY `idx_full_text` (`name`,`email`),
  CONSTRAINT `users_profile_id_foreign` FOREIGN KEY (`profile_id`) REFERENCES `profiles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla vertical.users: ~1 rows (aproximadamente)
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `state`, `profile_id`, `deleted_at`, `created_at`, `updated_at`) VALUES
	(1, 'jose', 'saraviamendoza@gmail.com', NULL, '$2y$10$jXeIIHrcPYi0FbDOhwbRc.kxT.hbBhBcI1S4rvyhabPsShJBvPSUi', NULL, 1, 1, NULL, '2019-10-17 11:11:15', '2020-06-13 10:16:15'),
	(2, 'nano', 'fcb.dev@gmail.com', NULL, '$2y$10$krfn3GACKmC7kFIA9pMT0.IKIIhj2kwwyhlfivpNNLRj5dCtbw5.q', NULL, 1, 1, NULL, '2020-06-21 18:14:31', '2020-06-21 18:14:31');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;

-- Volcando estructura para disparador vertical.add_amount_to_account
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION';
DELIMITER //
CREATE TRIGGER `add_amount_to_account` AFTER INSERT ON `incomes` FOR EACH ROW BEGIN
  
  UPDATE accounts SET current_amount = current_amount + NEW.amount 
  WHERE id = NEW.account_id;

END//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

-- Volcando estructura para disparador vertical.tg_sum_amount_cr
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION';
DELIMITER //
CREATE TRIGGER `tg_sum_amount_cr` AFTER INSERT ON `expenses` FOR EACH ROW BEGIN
    DECLARE t_user_id integer;
    DECLARE t_amount_expense double;
    DECLARE t_small_box_id integer;
    DECLARE t_small_box_amount double;
    DECLARE t_total double;
    
    SET t_user_id = NEW.user_id;
    SET t_amount_expense = NEW.amount;
    
    SELECT id, used_amount into t_small_box_id, t_small_box_amount FROM small_boxes WHERE user_id = t_user_id and state = 1;
    
    SET t_total = t_small_box_amount + t_amount_expense;
    
    UPDATE small_boxes SET used_amount = t_total WHERE small_boxes.id = t_small_box_id;
    UPDATE accounts SET current_amount = current_amount - NEW.amount WHERE id = NEW.account_id;
END//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

-- Volcando estructura para disparador vertical.tg_sum_amount_de
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION';
DELIMITER //
CREATE TRIGGER `tg_sum_amount_de` AFTER DELETE ON `expenses` FOR EACH ROW BEGIN
    DECLARE t_user_id integer;
    DECLARE t_amount_expense double;
    DECLARE t_small_box_id integer;
    DECLARE t_small_box_amount double;
    DECLARE t_small_box_date_init double;
    DECLARE t_total double;
       
    SET t_user_id = OLD.user_id;
    SELECT id, date_init, used_amount into t_small_box_id, t_small_box_date_init, t_small_box_amount FROM small_boxes WHERE user_id = t_user_id and state = 1;
    
    IF OLD.created_at >=  t_small_box_date_init THEN
      SET t_total = t_small_box_amount - OLD.amount;
     
      UPDATE small_boxes SET used_amount = t_total WHERE small_boxes.id = t_small_box_id;
	 END IF;
END//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

-- Volcando estructura para disparador vertical.tg_sum_amount_up
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION';
DELIMITER //
CREATE TRIGGER `tg_sum_amount_up` AFTER UPDATE ON `expenses` FOR EACH ROW BEGIN
    DECLARE t_user_id integer;
    DECLARE t_amount_expense double;
    DECLARE t_small_box_id integer;
    DECLARE t_small_box_amount double;
    DECLARE t_small_box_date_init datetime;
    DECLARE t_total double;
       
    IF OLD.amount <> NEW.amount THEN
    
       SET t_user_id = OLD.user_id;
       SELECT id, date_init, used_amount into t_small_box_id, t_small_box_date_init, t_small_box_amount FROM small_boxes WHERE user_id = t_user_id and state = 1;
       
       IF OLD.created_at >=  t_small_box_date_init THEN
			 SET t_amount_expense = NEW.amount;
	       SET t_total = t_small_box_amount - OLD.amount;
	       SET t_total = t_total + t_amount_expense;
		     
	       UPDATE small_boxes SET used_amount = t_total WHERE small_boxes.id = t_small_box_id;
       END IF;
    END IF;
    
END//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
