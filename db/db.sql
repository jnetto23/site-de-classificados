DROP DATABASE IF EXISTS ads;
CREATE DATABASE IF NOT EXISTS ads
DEFAULT CHARSET = utf8
DEFAULT COLLATE = utf8_general_ci;

USE ads;

DROP TABLE IF EXISTS users;
CREATE TABLE IF NOT EXISTS 	users (
	id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    pwd VARCHAR(32) NOT NULL,
    stt TINYINT(1) NOT NULL DEFAULT 0,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP(),
    updated_at DATETIME,
    CONSTRAINT PK_users PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS categories;
CREATE TABLE IF NOT EXISTS categories (
	id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
	created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP(),
    updated_at DATETIME,
    CONSTRAINT PK_categories PRIMARY KEY (id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;
INSERT INTO categories (name) VALUES ('Vestuário'), ('Eletrônicos'), ('Eletrodomésticos');

DROP TABLE IF EXISTS ads;
CREATE TABLE IF NOT EXISTS ads (
	id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    id_user INT(11) UNSIGNED NOT NULL,
    id_category INT(11) UNSIGNED NOT NULL,
    title VARCHAR(100) NOT NULL,
    description TEXT,
    value DEC(10,2),
    state ENUM('N','U') NOT NULL,
	created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP(),
    updated_at DATETIME,
    CONSTRAINT PK_ads PRIMARY KEY (id),
    CONSTRAINT FK_ads_users FOREIGN KEY (id_user)
		REFERENCES users (id),
	CONSTRAINT FK_ads_categories FOREIGN KEY (id_category)
		REFERENCES categories (id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

DELIMITER $$
DROP PROCEDURE IF EXISTS sp_user_signup $$
CREATE PROCEDURE sp_user_signup (
	pname VARCHAR(100),
    pemail VARCHAR(100),
    ppwd VARCHAR(32)
)
BEGIN
	DECLARE viduser INT;
	START TRANSACTION;
    IF EXISTS (SELECT id FROM users WHERE email = pemail) THEN
		SELECT "Email já cadastrado" AS 'error';
        ROLLBACK;
	ELSE
        INSERT INTO users (name, email, pwd) VALUES (pname, pemail, ppwd);
        SET viduser = LAST_INSERT_ID();
		COMMIT;
		SELECT * FROM users WHERE id = viduser;	
    END IF;
END $$
DELIMITER ;

call sp_user_signup('João Marques da Silva Netto', 'jnetto@fyyb.com.br', MD5('123456'));

DROP TABLE IF EXISTS ads_imgs;
CREATE TABLE IF NOT EXISTS ads_imgs (
	id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    id_ads INT(11) UNSIGNED NOT NULL,
    url VARCHAR(200) NOT NULL,
    ckd TINYINT(1) DEFAULT 0,
    CONSTRAINT PK_ads_imgs PRIMARY KEY (id),
    CONSTRAINT FK_ads_imgs_ads FOREIGN KEY (id_ads)
		REFERENCES ads (id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;