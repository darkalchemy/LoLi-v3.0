CREATE TABLE IF NOT EXISTS `torrents_scrape` (
  `tid` mediumint(7) unsigned NOT NULL DEFAULT '0',
  `info_hash` varbinary(40) NOT NULL DEFAULT '',
  `url` varchar(200) NOT NULL DEFAULT '',
  `seeders` smallint(5) unsigned NOT NULL DEFAULT '0',
  `leechers` smallint(5) unsigned NOT NULL DEFAULT '0',
  `completed` mediumint(7) unsigned NOT NULL DEFAULT '0',
  `last_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `state` enum('ok','error') NOT NULL DEFAULT 'ok',
  `error` varchar(100) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

ALTER TABLE `torrents_scrape`
  ADD PRIMARY KEY (`info_hash`,`url`),
  ADD KEY `index1` (`seeders`,`leechers`) USING BTREE,
  ADD KEY `index2` (`tid`,`url`,`seeders`,`leechers`,`last_update`,`state`,`error`) USING BTREE,
  ADD KEY `index3` (`tid`,`info_hash`,`url`) USING BTREE,
  ADD KEY `index4` (`tid`,`url`,`state`,`error`,`seeders`,`leechers`) USING BTREE,
  ADD KEY `index5` (`tid`,`seeders`,`leechers`) USING BTREE;
