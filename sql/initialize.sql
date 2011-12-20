/*************************************************/
/**Setup the Authentication system for Kohana**/
/*************************************************/

CREATE TABLE IF NOT EXISTS `roles` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL,
  `description` varchar(255) NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `uniq_name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

INSERT INTO `roles` (`id`, `name`, `description`) VALUES(1, 'login', 'Login privileges, granted after account confirmation');
INSERT INTO `roles` (`id`, `name`, `description`) VALUES(2, 'admin', 'Administrative user, has access to everything.');

CREATE TABLE IF NOT EXISTS `roles_users` (
  `user_id` int(10) UNSIGNED NOT NULL,
  `role_id` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY  (`user_id`,`role_id`),
  KEY `fk_role_id` (`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `email` varchar(254) NOT NULL,
  `username` varchar(32) NOT NULL DEFAULT '',
  `password` varchar(64) NOT NULL,
  `logins` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `last_login` int(10) UNSIGNED,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `uniq_username` (`username`),
  UNIQUE KEY `uniq_email` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `user_tokens` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int(11) UNSIGNED NOT NULL,
  `user_agent` varchar(40) NOT NULL,
  `token` varchar(40) NOT NULL,
  `type` varchar(100) NOT NULL,
  `created` int(10) UNSIGNED NOT NULL,
  `expires` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `uniq_token` (`token`),
  KEY `fk_user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

ALTER TABLE `roles_users`
  ADD CONSTRAINT `roles_users_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `roles_users_ibfk_2` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

ALTER TABLE `user_tokens`
  ADD CONSTRAINT `user_tokens_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;


/****Add last and first names to the users****/

ALTER TABLE  `users` ADD  `first_name` VARCHAR( 255 ) NULL DEFAULT NULL ,
ADD  `last_name` VARCHAR( 255 ) NULL DEFAULT NULL;

/***Add date_passed to users so we know if they are living or not and if so, when they passed***/
ALTER TABLE  `users` ADD  `date_passed` DATETIME NULL DEFAULT NULL;


/***Create the table that stores the wishes***/
CREATE TABLE IF NOT EXISTS `wishes` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int(11) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `html` LONGTEXT NOT NULL,
  `date_created` datetime NOT NULL,
  `date_modified` datetime NOT NULL,
  `is_live` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY  (`id`),
  KEY `is_live` (`is_live`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

ALTER TABLE `wishes`
ADD CONSTRAINT `users_wishes_fk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

/** use CHAR instead of VARCHAR because it's faster. Even though it takes up more space**/
ALTER TABLE  `wishes` CHANGE  `title`  `title` CHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;

/*** so we can have friendships ***/
CREATE TABLE IF NOT EXISTS `friends` (
  `user_id` int(11) unsigned NOT NULL,
  `friend_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`user_id`,`friend_id` )
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ;

ALTER TABLE `friends` ADD CONSTRAINT `friends_user_id_FK_1` FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE;
ALTER TABLE `friends` ADD CONSTRAINT `friends_user_id_FK_2` FOREIGN KEY (`friend_id`) REFERENCES `users`(`id`);

/*** create table so we can map wishes to users ***/
CREATE TABLE IF NOT EXISTS `friends_wishes` (
  `friend_id` int(11) unsigned NOT NULL,
  `wish_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`friend_id`,`wish_id` )  
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ;

ALTER TABLE `friends_wishes`
  ADD CONSTRAINT `friends_wishes_fk_1` FOREIGN KEY (`friend_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
ALTER TABLE `friends_wishes`
  ADD CONSTRAINT `friends_wishes_fk_2` FOREIGN KEY (`wish_id`) REFERENCES `wishes` (`id`) ON DELETE CASCADE;


/*** create table for messages to users ***/
CREATE TABLE IF NOT EXISTS `updates` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int(11) UNSIGNED NOT NULL,
  `date_created` datetime NOT NULL,
  `html` TINYTEXT NOT NULL,
  PRIMARY KEY (`id`)  
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ;
ALTER TABLE `updates`
ADD CONSTRAINT `updates_users_fk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;


/*****************************************************************************************************************/
/** Version 0.1 **/
/*****************************************************************************************************************/

/*** create table for pictures in wishes ***/
CREATE TABLE IF NOT EXISTS `wpics` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `wish_id` int(11) UNSIGNED NOT NULL,
  `date_created` datetime NOT NULL,
  `file_name` CHAR(255) NOT NULL,
  `title` CHAR(255) NOT NULL,
  PRIMARY KEY (`id`)  
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ;
ALTER TABLE `wpics`
ADD CONSTRAINT `wpics_wish_fk_1` FOREIGN KEY (`wish_id`) REFERENCES `wishes` (`id`) ON DELETE CASCADE;



