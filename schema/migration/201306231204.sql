ALTER TABLE  `comment` ADD  `status` ENUM(  'new',  'active', 'trash' ) NOT NULL DEFAULT  'new';

ALTER TABLE  `comment` ADD  `date_activate` DATETIME NULL ,
ADD  `date_trash` DATETIME NULL ;