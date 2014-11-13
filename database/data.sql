CREATE TABLE IF NOT EXISTS `bannerads` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `link` varchar(254) DEFAULT NULL,
  `images` varchar(254) DEFAULT NULL,
  `position` tinyint(1) DEFAULT '1',
  `published` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ;

CREATE TABLE IF NOT EXISTS `globalsettings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `data` text NOT NULL,
  PRIMARY KEY (`id`)
) ;