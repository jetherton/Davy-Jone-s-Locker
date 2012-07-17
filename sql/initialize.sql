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

/*** create table for files in wishes ***/
CREATE TABLE IF NOT EXISTS `wfiles` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `wish_id` int(11) UNSIGNED NOT NULL,
  `date_created` datetime NOT NULL,
  `file_name` CHAR(255) NOT NULL,
  `title` CHAR(255) NOT NULL,
  PRIMARY KEY (`id`)  
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ;
ALTER TABLE `wfiles`
ADD CONSTRAINT `wfiles_wish_fk_1` FOREIGN KEY (`wish_id`) REFERENCES `wishes` (`id`) ON DELETE CASCADE;

/*** create table for locations in wishes ***/
CREATE TABLE IF NOT EXISTS `locations` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `wish_id` int(11) UNSIGNED NOT NULL,
  `zoom` tinyint(4) UNSIGNED NOT NULL,
  `map_type` CHAR(255) NOT NULL,
  `lat` double NOT NULL,
  `lon` double NOT NULL,
  PRIMARY KEY (`id`)  
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ;
ALTER TABLE `locations`
ADD CONSTRAINT `locations_wish_fk_1` FOREIGN KEY (`wish_id`) REFERENCES `wishes` (`id`) ON DELETE CASCADE;

/****************************************************************************************************/
/*   VERSION 0.2   */
/****************************************************************************************************/

/*** create table for categories ***/
CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` CHAR(255) NOT NULL,
  `description` CHAR(255) NOT NULL,
  PRIMARY KEY (`id`)  
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ;
ALTER TABLE  `categories` ADD  `order` INT( 11 ) UNSIGNED NOT NULL;


/*** create table for forms ***/
CREATE TABLE IF NOT EXISTS `forms` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `category_id` int(11) UNSIGNED,
  `title` CHAR(255) NOT NULL,
  `description` CHAR(255) NOT NULL,
  PRIMARY KEY (`id`)  
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ;
ALTER TABLE `forms`
ADD CONSTRAINT `forms_category_fk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`);
ALTER TABLE  `forms` ADD  `order` INT( 11 ) UNSIGNED NOT NULL;


/*** create table form fields ***/
CREATE TABLE IF NOT EXISTS `formfields` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `form_id` int(11) UNSIGNED NOT NULL,
  `title` CHAR(255) NOT NULL,
  `description` CHAR(255) NOT NULL,
  `order` INT( 11 ) UNSIGNED NOT NULL DEFAULT '0',
  `required` tinyint(4) UNSIGNED NOT NULL DEFAULT '0',
  `type` tinyint(4) UNSIGNED NOT NULL,
  `default_value` CHAR(255) NULL,
  PRIMARY KEY (`id`)  
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ;
ALTER TABLE `formfields`
ADD CONSTRAINT `formfields_form_id_fk_1` FOREIGN KEY (`form_id`) REFERENCES `forms` (`id`) ON DELETE CASCADE;


/*** create table form fields ***/
CREATE TABLE IF NOT EXISTS `formfieldoptions` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `formfield_id` int(11) UNSIGNED NOT NULL,
  `title` CHAR(255) NOT NULL,
  `description` CHAR(255) NOT NULL,
  `order` INT( 11 ) UNSIGNED NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)  
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ;
ALTER TABLE `formfieldoptions`
ADD CONSTRAINT `formfieldoptions_formfields_id_fk_1` FOREIGN KEY (`formfield_id`) REFERENCES `formfields` (`id`) ON DELETE CASCADE;

/** add forms to wishes **/
ALTER TABLE  `wishes` ADD  `form_id` INT( 11 ) UNSIGNED NOT NULL AFTER  `user_id`;
ALTER TABLE `wishes` ADD CONSTRAINT `form_wishes_id_fk_1` FOREIGN KEY (`form_id`) REFERENCES `forms` (`id`) ON DELETE CASCADE;

/** add table to hold answers to forms in wishes **/
CREATE TABLE IF NOT EXISTS `formfieldresponses` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `formfield_id` int(11) UNSIGNED NOT NULL,
  `wish_id` int (11) UNSIGNED NOT NULL,
  `response` CHAR(255) NOT NULL,
  PRIMARY KEY (`id`)  
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ;
ALTER TABLE `formfieldresponses`
ADD CONSTRAINT `formfieldresponses_formfields_id_fk_1` FOREIGN KEY (`formfield_id`) REFERENCES `formfields` (`id`) ON DELETE CASCADE;
ALTER TABLE `formfieldresponses`
ADD CONSTRAINT `formfieldresponses_wish_id_fk_1` FOREIGN KEY (`wish_id`) REFERENCES `wishes` (`id`) ON DELETE CASCADE;


CREATE TABLE IF NOT EXISTS `settings` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `db_version` CHAR(255) NOT NULL,
  PRIMARY KEY (`id`)  
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ;

INSERT INTO  `settings` (`id` ,`db_version`)
VALUES (NULL ,  '3');


/****************************************************************************************************/
/*   VERSION 0.3   */
/****************************************************************************************************/

/** Make description fields for forms longer*/
ALTER TABLE  `forms` CHANGE  `description`  `description` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;
ALTER TABLE  `categories` CHANGE  `description`  `description` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;
ALTER TABLE  `formfields` CHANGE  `description`  `description` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;

/**Add in middle name*/
ALTER TABLE  `users` ADD  `middle_name` CHAR( 255 ) NULL DEFAULT NULL AFTER  `first_name`;

/** Add other data for users*/
ALTER TABLE  `users` ADD  `gender` TINYINT NOT NULL ,
ADD  `address1` CHAR( 255 ) NOT NULL ,
ADD  `address2` CHAR( 255 ) NOT NULL ,
ADD  `city` CHAR( 255 ) NOT NULL ,
ADD  `state` CHAR( 100 ) NOT NULL ,
ADD  `zip` CHAR( 20 ) NOT NULL ,
ADD  `dob` DATETIME NOT NULL ,
ADD  `citizenship` CHAR( 255 ) NOT NULL;

/** Add this is lockable field to questions, so we can lock them at some point later down the road*/
ALTER TABLE  `formfields` ADD  `islockable` TINYINT( 4 ) NOT NULL DEFAULT  '0';

/** now add a table that maps fields to friends**/
CREATE TABLE IF NOT EXISTS `friends_fields` (
  `friend_id` int(11) unsigned NOT NULL,
  `wish_id` int(11) unsigned NOT NULL,
  `formfield_id` int(11) UNSIGNED NOT NULL,
  PRIMARY KEY (`friend_id`,`wish_id`,`formfield_id` )  
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ;

ALTER TABLE `friends_fields`
  ADD CONSTRAINT `friends_fields_fk_1` FOREIGN KEY (`friend_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
ALTER TABLE `friends_fields`
  ADD CONSTRAINT `friends_fields_fk_2` FOREIGN KEY (`wish_id`) REFERENCES `wishes` (`id`) ON DELETE CASCADE;
ALTER TABLE `friends_fields`
ADD CONSTRAINT `friends_fields_fk_3` FOREIGN KEY (`formfield_id`) REFERENCES `formfields` (`id`) ON DELETE CASCADE;



/****************************************************************************************************/
/*   VERSION 0.4   */
/****************************************************************************************************/

/** add a table for passing setters and passers*/
/** now add a table that maps fields to friends**/
CREATE TABLE IF NOT EXISTS `passingsettings` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `min_passers` int(11) unsigned NOT NULL,
  `timeframe` int(11) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`)  
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ;

ALTER TABLE `passingsettings`
  ADD CONSTRAINT `passing_settings_fk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

/** now add a table for mapping friends as passers*/
CREATE TABLE IF NOT EXISTS `userpassers` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `passer_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`)  
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ;

ALTER TABLE `userpassers`
  ADD CONSTRAINT `user_passer_fk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
ALTER TABLE `userpassers`
  ADD CONSTRAINT `user_passer_fk_2` FOREIGN KEY (`passer_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

/** setup a table to keep track of who has said who has passed*/
CREATE TABLE IF NOT EXISTS `userpassed` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `passer_id` int(11) unsigned NOT NULL,
  `passed_id` int(11) unsigned NOT NULL,
  `time` DATETIME NOT NULL,
  `note` TEXT NULL,
  `confirm` tinyint(4) NOT NULL DEFAULT '0',
  `initiator` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)  
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ;

/** updates are about to get long, so make them out of text*/
ALTER TABLE  `updates` CHANGE  `html`  `html` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;


