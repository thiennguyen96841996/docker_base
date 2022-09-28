# ************************************************************
# Sequel Ace SQL dump
# バージョン 20033
#
# https://sequel-ace.com/
# https://github.com/Sequel-Ace/Sequel-Ace
#
# ホスト: 127.0.0.1 (MySQL 8.0.30)
# データベース: speedy
# 生成時間: 2022-09-27 11:12:13 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
SET NAMES utf8mb4;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE='NO_AUTO_VALUE_ON_ZERO', SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# テーブルのダンプ agencies
# ------------------------------------------------------------

DROP TABLE IF EXISTS `agencies`;

CREATE TABLE `agencies` (
                            `id` bigint unsigned NOT NULL AUTO_INCREMENT,
                            `name` varchar(50) COLLATE utf8mb4_bin NOT NULL,
                            `tel` varchar(50) COLLATE utf8mb4_bin NOT NULL,
                            `address` varchar(50) COLLATE utf8mb4_bin NOT NULL,
                            `created_at` timestamp NULL DEFAULT NULL,
                            `updated_at` timestamp NULL DEFAULT NULL,
                            `deleted_at` timestamp NULL DEFAULT NULL,
                            PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin ROW_FORMAT=DYNAMIC;

LOCK TABLES `agencies` WRITE;
/*!40000 ALTER TABLE `agencies` DISABLE KEYS */;

INSERT INTO `agencies` (`id`, `name`, `tel`, `address`, `created_at`, `updated_at`, `deleted_at`)
VALUES
    (1,X'746869656E3132333233',X'313233343536373839',X'68756E672079656E',NULL,'2022-09-27 20:06:36',NULL),
    (2,X'3231333366736466',X'31343231343134',X'73616661666164','2022-09-27 19:46:03','2022-09-27 20:09:54','2022-09-27 20:09:54');

/*!40000 ALTER TABLE `agencies` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
