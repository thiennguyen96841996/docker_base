--
-- glc Project
--
CREATE SCHEMA glc CHARACTER SET utf8mb4 COLLATE utf8mb4_bin;

CREATE USER 'glc_admin'@'%' IDENTIFIED BY 'mysql_admin';
GRANT ALL PRIVILEGES ON glc.* TO 'glc_admin'@'%';

CREATE USER 'glc_admin'@'localhost' IDENTIFIED BY 'mysql_admin';
GRANT ALL ON glc.* TO 'glc_admin'@'localhost';

CREATE USER 'glc_write'@'%' IDENTIFIED BY 'mysql_write';
GRANT SELECT, INSERT, UPDATE, DELETE ON glc.* TO 'glc_write'@'%';

CREATE USER 'glc_read'@'%' IDENTIFIED BY 'mysql_read';
GRANT SELECT ON glc.* TO 'glc_read'@'%';

FLUSH PRIVILEGES;
