UPDATE {PRE}settings SET value = '2.0.2' where var = 'version';
ALTER TABLE {PRE}artist CHANGE id idspotify VARCHAR(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;
ALTER TABLE {PRE}artist ADD idmusixmatch INT NOT NULL AFTER idspotify;
UPDATE {PRE}settings SET options = 'Youtube (Andio/Video):youtube|SoundCloud:soundcloud|VK.com (Experimental - Required Bandwidth Server):vk' WHERE var = 'streaming_engine';
UPDATE {PRE}settings SET options = 'Local:local|Musixmatch:musixmatch|iTunes:itunes' WHERE var = 'trending_tracks_source';
INSERT IGNORE INTO {PRE}translation (id, code, translation, code_lang) VALUES (NULL, 'label_track_similar_name', 'Tracks with similar name', 'en');
INSERT IGNORE INTO {PRE}translation (id, code, translation, code_lang) VALUES (NULL, 'label_dashboard', 'Dashboard', 'en');
UPDATE {PRE}settings SET class = '' WHERE var = 'keywords';
UPDATE {PRE}admin_menus SET title = 'Appearance' WHERE idmenu = 4;
INSERT IGNORE INTO `{PRE}settings` (`var`, `value`, `label`, `helper`, `type`, `options`, `attr`, `class`, `module`, `order`) VALUES ('trending_tabs', 'tracks', 'Extra Tabs Trending', '', 'select-multiple', 'Tracks (Required):tracks|Artist:artist|Albums:albums|Stations:stations', '', 'select2', 'website', '5');
INSERT IGNORE INTO {PRE}translation (id, code, translation, code_lang) VALUES (NULL, 'label_pages', 'Pages', 'en');
ALTER TABLE {PRE}artist DROP `slug`;
ALTER TABLE {PRE}tracks CHANGE `id` `idspotify` VARCHAR(150) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;
ALTER TABLE {PRE}tracks ADD idmusixmatch INT NOT NULL AFTER idspotify;
ALTER TABLE {PRE}artist DROP INDEX id;
ALTER TABLE {PRE}tracks DROP INDEX id;
ALTER TABLE {PRE}tracks DROP INDEX tracks_unique;
ALTER TABLE music_tracks DROP INDEX artist;
ALTER TABLE music_tracks DROP INDEX artist_2;
ALTER TABLE music_tracks DROP INDEX artist_3;
ALTER TABLE music_tracks DROP INDEX track;
ALTER TABLE {PRE}tracks ADD FULLTEXT KEY tracks_search (track(10),artist(10),album(10));
ALTER TABLE {PRE}tracks ADD FULLTEXT KEY tracks_search_2 (artist(10),track(10));
ALTER TABLE {PRE}artist DROP INDEX artist;
ALTER IGNORE TABLE {PRE}artist ADD UNIQUE  artist_unique (`artist`(50));
ALTER TABLE {PRE}albums CHANGE `id` `idspotify` VARCHAR(150) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;
ALTER TABLE {PRE}albums ADD idmusixmatch INT NOT NULL AFTER idspotify;
ALTER TABLE {PRE}albums DROP INDEX id;
ALTER TABLE {PRE}artist ADD FULLTEXT KEY artist_search (artist);
ALTER TABLE {PRE}artist ADD country VARCHAR(4) NOT NULL AFTER `mbid`;
ALTER TABLE {PRE}albums ADD mbid VARCHAR(100) NOT NULL AFTER `idspotify`;
ALTER TABLE {PRE}albums CHANGE `album` `album` VARCHAR(250) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;
ALTER IGNORE TABLE {PRE}albums ADD UNIQUE albums_unique (`idmusixmatch`);
ALTER TABLE {PRE}albums ADD `updated` TIMESTAMP on update CURRENT_TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ;
ALTER TABLE {PRE}artist ADD `rating` INT NOT NULL ;
INSERT IGNORE INTO {PRE}settings (`var`, `value`,  `module`) VALUES ('color_theme', 'Default', 'apperance');
DELETE FROM {PRE}settings WHERE  var = 'color_scheme';
CREATE TABLE IF NOT EXISTS `{PRE}themes` (
  `name_theme` varchar(50) NOT NULL,
  `main_color` varchar(7) NOT NULL,
  `secondary_color` varchar(7) NOT NULL,
  `default_color` varchar(7) NOT NULL,
  `text_color` varchar(7) NOT NULL,
  `text_color_hover` varchar(7) NOT NULL,
  `color_success` varchar(7) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
ALTER TABLE `{PRE}themes` ADD UNIQUE KEY `name_theme` (`name_theme`);
INSERT IGNORE INTO {PRE}themes (`name_theme`, `main_color`, `secondary_color`, `default_color`, `text_color`, `text_color_hover`, `color_success`) VALUES ('Default', '#212121', '#080808', '#2B2B2B', '#EBEBEB', '#FFFFFF', '#23b71c');
INSERT IGNORE INTO `{PRE}settings` (`var`, `value`, `label`, `helper`, `type`, `options`, `attr`, `class`, `module`, `order`) VALUES ('search_engine', 'remote', 'Search Engine', '', 'select', 'Local MySQL Search:local|Remote (Max 120  Request x Minute):remote', '', 'select2', 'website', '20');
INSERT INTO `{PRE}admin_menus` (`idmenu`, `title`, `idunique`, `target`, `icon`, `idparent`) VALUES (NULL, 'Pages', 'pages', 'admin/pages', 'fa fa-th', '');
CREATE TABLE IF NOT EXISTS `{PRE}pages` (
`idpage` int(11) NOT NULL,
  `title` varchar(250) NOT NULL,
  `text` text NOT NULL,
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
ALTER TABLE `{PRE}pages` ADD PRIMARY KEY (`idpage`);
ALTER TABLE `{PRE}pages` MODIFY `idpage` int(11) NOT NULL AUTO_INCREMENT;
INSERT INTO `{PRE}settings` VALUES('slug_pages', 'news', 'Pages', '', 'text', '', 'required="required"', '', 'slug', 0);
ALTER TABLE {PRE}tracks DROP INDEX track;
ALTER IGNORE TABLE {PRE}tracks ADD UNIQUE INDEX track_idx (artist(10),album(10),track(10));
ALTER TABLE {PRE}tracks_lyrics DROP INDEX artist;
ALTER IGNORE TABLE {PRE}tracks_lyrics ADD UNIQUE INDEX lyric_idx (artist(10),track(10));
ALTER TABLE {PRE}albums DROP INDEX album_2;
ALTER IGNORE TABLE {PRE}albums ADD UNIQUE INDEX album_idx (artist(10),album(10));
INSERT IGNORE INTO `{PRE}settings` (`var`, `value`, `label`, `helper`, `type`, `options`, `attr`, `class`, `module`, `order`) VALUES ('footer_code', '', 'Custom footer code', '', 'textarea', '', '', '', 'website', '40');