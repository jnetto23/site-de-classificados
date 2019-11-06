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

DROP PROCEDURE IF EXISTS sp_ads_del;
DELIMITER $$
CREATE PROCEDURE sp_ads_del (
	pid INT(11)
)
BEGIN
	DECLARE imgs TEXT;
	SET imgs = (SELECT GROUP_CONCAT(url) as imgs FROM ads_imgs WHERE id_ads = pid);
	DELETE FROM ads_imgs WHERE id_ads = pid;
	DELETE FROM ads WHERE id = pid;  
    SELECT imgs;
END $$
DELIMITER ;

DROP PROCEDURE IF EXISTS sp_ads_findById;
DELIMITER $$
CREATE PROCEDURE sp_ads_findById(
	pid INT(11)
)
BEGIN
	SELECT 
		a.id as id, a.title as title, a.description as description, a.value as value, a.state as state, 
		b.id as category,
		GROUP_CONCAT( c.url) as imgs,
        (SELECT url FROM ads_imgs WHERE id_ads = a.id AND ckd = 1) as imgckd
	FROM ads a 
		INNER JOIN categories b ON a.id_category = b.id
		LEFT JOIN ads_imgs c ON a.id = c.id_ads
	WHERE a.id = pid LIMIT 1;
END$$
DELIMITER ;

DROP PROCEDURE IF EXISTS sp_ads_save;
DELIMITER $$
CREATE PROCEDURE sp_ads_save(
	pid_user INT(11),
    pid_category INT(11),
    ptitle VARCHAR(100),
    pdescription TEXT,
    pvalue DEC(10,2),
    pstate ENUM('N','U'),
    padd_imgs TEXT,
    pimg_ckd TEXT
)
BEGIN
	DECLARE vid INT;	
    INSERT INTO ads (id_user, id_category, title, description, value, state) VALUES ( 
		pid_user,
        pid_category, 
		ptitle, 
		pdescription,
		pvalue,
		pstate
	);
    SET vid = LAST_INSERT_ID();
    IF LENGTH(TRIM(pimg_ckd)) > 0 AND LENGTH(TRIM(padd_imgs)) > 0 THEN
        CALL sp_ads_imgs_add(vid, padd_imgs, pimg_ckd);
    ELSEIF LENGTH(TRIM(pimg_ckd)) = 0 AND LENGTH(TRIM(padd_imgs)) > 0 THEN
		CALL sp_ads_imgs_add(vid, padd_imgs, '');
    END IF;
END $$
DELIMITER ;

DROP PROCEDURE IF EXISTS sp_ads_edit;
DELIMITER $$
CREATE PROCEDURE sp_ads_edit(
	pid INT(11),
    pid_category INT(11),
    ptitle VARCHAR(100),
    pdescription TEXT,
    pvalue DEC(10,2),
    pstate ENUM('N','U'),
    pdel_imgs TEXT,
    padd_imgs TEXT,
    pimg_ckd TEXT
)
BEGIN
	IF LENGTH(TRIM(pdel_imgs)) > 0 OR pdel_imgs IS NOT NULL THEN
		CALL sp_ads_imgs_del(pid, pdel_imgs);
	END IF;
    IF LENGTH(TRIM(pimg_ckd)) > 0 AND LENGTH(TRIM(padd_imgs)) > 0 THEN
		UPDATE ads_imgs SET ckd = 0 WHERE id_ads = pid;
        CALL sp_ads_imgs_add(pid, padd_imgs, pimg_ckd);
    ELSEIF LENGTH(TRIM(pimg_ckd)) = 0 AND LENGTH(TRIM(padd_imgs)) > 0 THEN
		CALL sp_ads_imgs_add(pid, padd_imgs, '');
    ELSEIF LENGTH(TRIM(pimg_ckd)) > 0 AND LENGTH(TRIM(padd_imgs)) = 0 THEN
		UPDATE ads_imgs SET ckd = 0 WHERE id_ads = pid;
        UPDATE ads_imgs SET ckd = 1 WHERE id_ads = pid AND url = pimg_ckd;
    END IF;
	
    UPDATE ads SET 
		id_category = pid_category, 
		title = ptitle, 
		description = pdescription,
		value = pvalue,
		state = pstate,
		updated_at = CURRENT_TIMESTAMP()
	WHERE
		id = pid;
END $$
DELIMITER ;

DROP PROCEDURE IF EXISTS sp_ads_imgs_del;
DELIMITER $$
CREATE PROCEDURE sp_ads_imgs_del(
	pid_ads INT(11),
    pimgs TEXT
)
BEGIN
	DECLARE front TEXT DEFAULT NULL;
    DECLARE frontlen INT DEFAULT NULL;
    DECLARE img TEXT DEFAULT NULL;
    
    ITERATOR:
	LOOP  
		IF LENGTH(TRIM(pimgs)) = 0 OR pimgs IS NULL THEN
			LEAVE iterator;
		END IF;
		
        SET front = SUBSTRING_INDEX(pimgs,',',1);
		SET frontlen = LENGTH(front);
		SET img = TRIM(front);
        
		DELETE FROM ads_imgs WHERE url = img AND id_ads = pid_ads;
		SET pimgs = INSERT (pimgs, 1, frontlen + 1,'');
	END LOOP;
END $$
DELIMITER ;

DROP PROCEDURE IF EXISTS sp_ads_imgs_add;
DELIMITER $$
CREATE PROCEDURE sp_ads_imgs_add(
	pid_ads INT(11),
    pimgs TEXT,
    pimgckd TEXT
)
BEGIN
	DECLARE front TEXT DEFAULT NULL;
    DECLARE frontlen INT DEFAULT NULL;
    DECLARE img TEXT DEFAULT NULL;
    
    ITERATOR:
	LOOP  
		IF LENGTH(TRIM(pimgs)) = 0 OR pimgs IS NULL THEN
			LEAVE iterator;
		END IF;
		
        SET front = SUBSTRING_INDEX(pimgs,',',1);
		SET frontlen = LENGTH(front);
		SET img = TRIM(front);
        
        IF img = pimgckd THEN
			INSERT INTO ads_imgs (id_ads, url, ckd) VALUES (pid_ads, img, 1);
        ELSE 
			INSERT INTO ads_imgs (id_ads, url, ckd) VALUES (pid_ads, img, 0);
        END IF;
		SET pimgs = INSERT (pimgs, 1, frontlen + 1,'');
	END LOOP;
END $$
DELIMITER ;

DROP PROCEDURE IF EXISTS sp_ads_findAllById;
DELIMITER $$
CREATE PROCEDURE sp_ads_findAllById(
	pid INT(11)
)
BEGIN
	SELECT 
a.id as id, a.title as title, a.description as description, a.value as value, a.state as state, 
		b.id as id_category,
        b.name as name_category,
		GROUP_CONCAT( c.url) as imgs,
        (SELECT url FROM ads_imgs WHERE id_ads = a.id AND ckd = 1) as imgckd,
        d.id as id_user,
        d.name as name_user,
        d.email as email_user
	FROM ads a 
		INNER JOIN categories b ON a.id_category = b.id
		LEFT JOIN ads_imgs c ON a.id = c.id_ads
        LEFT JOIN users d ON a.id_user = d.id
	WHERE a.id = pid LIMIT 1;
END$$
DELIMITER ;

INSERT INTO categories (name) VALUES ('Vestuário'), ('Eletrônicos'), ('Eletrodomésticos');

CALL sp_user_signup('João Marques da Silva Netto', 'jnetto@fyyb.com.br', MD5('123456'));
CALL sp_user_signup('Testador 1', 'teste1@teste.com.br', MD5('123456'));
CALL sp_user_signup('Testador 2', 'teste2@teste.com.br', MD5('123456'));
CALL sp_user_signup('Testador 3', 'teste3@teste.com.br', MD5('123456'));

INSERT INTO ads  
	(id_user, id_category, title, description, value, state) 
VALUES 
	(1, 1, 'Ads Teste 1', 'Description Ads Teste 1', 111.11, 'N'),
    (1, 2, 'Ads Teste 2', 'Description Ads Teste 2', 222.22, 'N'),
    (1, 3, 'Ads Teste 3', 'Description Ads Teste 3', 333.33, 'N'),
    (1, 1, 'Ads Teste 4', 'Description Ads Teste 4', 444.44, 'N'),
    (1, 2, 'Ads Teste 5', 'Description Ads Teste 5', 555.55, 'N'),
    (1, 3, 'Ads Teste 6', 'Description Ads Teste 6', 666.66, 'N'),
    (1, 1, 'Ads Teste 7', 'Description Ads Teste 7', 777.77, 'N'),
    (1, 2, 'Ads Teste 8', 'Description Ads Teste 8', 888.88, 'N'),
    (1, 3, 'Ads Teste 9', 'Description Ads Teste 9', 999.99, 'N');