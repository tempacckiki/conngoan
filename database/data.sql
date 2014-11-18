tao folder
	/alobuy0862779988/bannerads/adspopup (2 folders)




---------------------------------------------------------------- 20141116
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


ALTER TABLE  `shop_product` ADD  `spbanchay` TINYINT( 1 ) UNSIGNED NULL DEFAULT  '0' AFTER  `spkhuyenmai`;
ALTER TABLE  `contact_row` ADD  `address` VARCHAR( 254 ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL AFTER  `fullname`


create folder: 
	/home/ihanux/public_html/conngoan/data/img_rotare_tmpl
	/home/ihanux/public_html/conngoan/alobuy0862779988/0862779988product/{5 folder}
	/Volumes/Data/trankinhly/works/younet/tech_sharing/vagrant/projects/vagrant-lamp-master/public/local.dev/alobuyvn/alobuy0862779988/news {3 folders}

empty table: 
	news_detail
	subscriptions
	contact_row
	
update config: 
	front-end/config.php
	back-end/config.php