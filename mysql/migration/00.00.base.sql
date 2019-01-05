DROP TABLE IF EXISTS user;

CREATE TABLE user (
    user_id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    login VARCHAR(50) NOT NULL,
    pass_hash TEXT NOT NULL,
    email VARCHAR(50),
    refresh_token VARCHAR(50),
    refresh_token_expires_in INT
) ENGINE=INNODB;