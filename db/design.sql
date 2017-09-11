--  ██████╗ ██████╗ ██████╗ ███████╗███╗   ███╗ █████╗ ███╗   ██╗
-- ██╔════╝██╔═══██╗██╔══██╗██╔════╝████╗ ████║██╔══██╗████╗  ██║
-- ██║     ██║   ██║██║  ██║█████╗  ██╔████╔██║███████║██╔██╗ ██║
-- ██║     ██║   ██║██║  ██║██╔══╝  ██║╚██╔╝██║██╔══██║██║╚██╗██║
-- ╚██████╗╚██████╔╝██████╔╝███████╗██║ ╚═╝ ██║██║  ██║██║ ╚████║
--  ╚═════╝ ╚═════╝ ╚═════╝ ╚══════╝╚═╝     ╚═╝╚═╝  ╚═╝╚═╝  ╚═══╝

DROP TABLE IF EXISTS schema.wp_contacts;
CREATE TABLE schema.wp_contacts(
	id_contact INT UNSIGNED NOT NULL AUTO_INCREMENT,
	name VARCHAR( 100 ) NOT NULL,
	tel VARCHAR( 32 ) NOT NULL,
	email VARCHAR( 60 ) NOT NULL,
	subject VARCHAR( 100 ) NOT NULL,
	message TEXT NOT NULL,
	ip VARCHAR( 16 ) NOT NULL,
	status BOOLEAN NOT NULL DEFAULT TRUE COMMENT 'TRUE -> Active, FALSE -> Inactive',
	info TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

	UNIQUE( email ),

	PRIMARY KEY( id_contact )
)
ENGINE = INNODB
CHARACTER SET utf8 COLLATE utf8_unicode_ci;

-- 

DROP TABLE IF EXISTS schema.wp_mailing;
CREATE TABLE schema.wp_mailing(
	id_mailing INT UNSIGNED NOT NULL AUTO_INCREMENT,
	name VARCHAR( 100 ) NOT NULL,
	email VARCHAR( 60 ) NOT NULL,
	ip VARCHAR( 16 ) NOT NULL,
	status BOOLEAN NOT NULL DEFAULT TRUE COMMENT 'TRUE -> Active, FALSE -> Inactive',
	info TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

	UNIQUE( email ),

	PRIMARY KEY( id_mailing )
)
ENGINE = INNODB
CHARACTER SET utf8 COLLATE utf8_unicode_ci;