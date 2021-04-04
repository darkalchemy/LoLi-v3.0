CREATE TABLE IF NOT EXISTS `shoutbox2` (
  `id` tinyint(3) unsigned NOT NULL,
  `userid` mediumint(7) NOT NULL DEFAULT '0',
  `date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `text` varchar(1000) NOT NULL,
  `class` tinyint(2) unsigned NOT NULL,
  `username` varchar(20) NOT NULL,
  `warned` varchar(3) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

ALTER TABLE `shoutbox2`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `index` (`userid`,`date`) USING BTREE;

ALTER TABLE `shoutbox2`
  MODIFY `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;
