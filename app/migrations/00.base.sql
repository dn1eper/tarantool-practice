DROP DATABASE IF EXISTS test;
CREATE DATABASE test;
USE test;

DROP TABLE IF EXISTS user;

CREATE TABLE user (
    user_id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    login VARCHAR(50) NOT NULL,
    pass_hash TEXT
) ENGINE=INNODB;

#--MIGRATION HISTORY--
CREATE TABLE migration_history (
    migration_id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    version VARCHAR(2) NOT NULL,
    sub_version VARCHAR(2),
    commentary VARCHAR(255),
    date_applied DATETIME DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY(migration_id)
) ENGINE=INNODB;

INSERT INTO migration_history(version, sub_version, file_num, commentary, date_applied) VALUES('00', '00', 'base');