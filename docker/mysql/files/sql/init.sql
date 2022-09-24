--
-- Speedy Project
--
CREATE SCHEMA speedy CHARACTER SET utf8mb4 COLLATE utf8mb4_bin;

CREATE USER 'speedy_admin'@'%' IDENTIFIED BY 'mysql_admin';
GRANT ALL PRIVILEGES ON speedy.* TO 'speedy_admin'@'%';

CREATE USER 'speedy_admin'@'localhost' IDENTIFIED BY 'mysql_admin';
GRANT ALL ON speedy.* TO 'speedy_admin'@'localhost';

CREATE USER 'speedy_write'@'%' IDENTIFIED BY 'mysql_write';
GRANT SELECT, INSERT, UPDATE, DELETE ON speedy.* TO 'speedy_write'@'%';

CREATE USER 'speedy_read'@'%' IDENTIFIED BY 'mysql_read';
GRANT SELECT ON speedy.* TO 'speedy_read'@'%';

FLUSH PRIVILEGES;
