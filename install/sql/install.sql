CREATE TABLE IF NOT EXISTS {prefix}admin_menus (
idmenu int(11) NOT NULL,
  title varchar(150) NOT NULL,
  idunique varchar(25) NOT NULL,
  target varchar(150) NOT NULL,
  icon varchar(100) NOT NULL,
  idparent varchar(15) NOT NULL DEFAULT ''
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS {prefix}albums (
idalbum int(11) NOT NULL,
  id varchar(100) CHARACTER SET latin1 NOT NULL,
  album varchar(150) NOT NULL,
  artist varchar(50) NOT NULL,
  lenght int(11) NOT NULL,
  playing_time bigint(20) NOT NULL,
  release_date varchar(12) CHARACTER SET latin1 NOT NULL,
  picture_small varchar(250) NOT NULL,
  picture_medium varchar(250) NOT NULL,
  picture_extra varchar(250) NOT NULL,
  likes int(11) NOT NULL,
  album_type varchar(20) CHARACTER SET latin1 NOT NULL,
  crawled int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS {prefix}artist (
idartist int(11) NOT NULL,
  slug varchar(50) NOT NULL,
  id varchar(100) NOT NULL,
  artist varchar(150) NOT NULL,
  picture_small varchar(250) NOT NULL,
  picture_medium varchar(250) NOT NULL,
  picture_extra varchar(250) NOT NULL,
  genre_1 varchar(15) DEFAULT NULL,
  genre_2 varchar(50) DEFAULT NULL,
  plays int(11) NOT NULL DEFAULT '0',
  mbid varchar(100) NOT NULL,
  updated timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  crawled tinyint(1) NOT NULL DEFAULT '0',
  likes int(11) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS {prefix}artist_bio (
idartistbio int(11) NOT NULL,
  lang char(3) CHARACTER SET latin1 NOT NULL,
  artist varchar(100) CHARACTER SET latin1 NOT NULL,
  bio text NOT NULL,
  updated timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS {prefix}langs (
id int(11) NOT NULL,
  `code` varchar(5) NOT NULL,
  `name` varchar(20) NOT NULL,
  flag varchar(150) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS {prefix}languages (
id int(10) unsigned NOT NULL,
  `name` char(49) DEFAULT NULL,
  `code` char(2) DEFAULT NULL
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS {prefix}likes (
idlike int(11) NOT NULL,
  created timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  iduser int(11) NOT NULL,
  idtarget varchar(50) NOT NULL,
  `type` int(11) NOT NULL COMMENT '1=> Artist, 2=> Album, 3=> Track, 4=> Playlist, 5=> station, 6=> User'
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS {prefix}playlists (
idplaylist int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  public tinyint(1) NOT NULL DEFAULT '0',
  created timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  iduser int(11) NOT NULL,
  image varchar(250) NOT NULL,
  likes int(11) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS {prefix}playlists_tracks (
idplaylisttracks int(11) NOT NULL,
  idplaylist int(11) NOT NULL,
  id varchar(100) NOT NULL,
  artist varchar(100) NOT NULL,
  track varchar(100) NOT NULL,
  album varchar(100) NOT NULL,
  image varchar(250) NOT NULL,
  created timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS {prefix}sessions (
  id varchar(40) NOT NULL,
  ip_address varchar(45) NOT NULL,
  `timestamp` int(10) unsigned NOT NULL DEFAULT '0',
  `data` blob NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS {prefix}settings (
  var varchar(50) NOT NULL,
  `value` text NOT NULL,
  label varchar(150) NOT NULL,
  helper text NOT NULL,
  `type` enum('text','numeric','select','textarea','select-multiple','password') NOT NULL,
  `options` varchar(200) NOT NULL,
  attr varchar(250) NOT NULL,
  class varchar(150) NOT NULL,
  module varchar(50) NOT NULL,
  `order` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS {prefix}stations (
idstation int(11) NOT NULL,
  url varchar(250) NOT NULL,
  title varchar(150) NOT NULL,
  cover text NOT NULL,
  description text NOT NULL,
  `type` varchar(30) NOT NULL,
  mount varchar(150) NOT NULL,
  guid varchar(150) NOT NULL COMMENT 'guid radionomy',
  genre text NOT NULL,
  likes int(11) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=76 DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS {prefix}stations_genres (
id int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  image text NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `type` enum('channel','category','','') NOT NULL DEFAULT 'category'
) ENGINE=MyISAM AUTO_INCREMENT=36 DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS {prefix}stations_tracks (
id int(11) NOT NULL,
  artist varchar(100) NOT NULL,
  track varchar(100) NOT NULL,
  image varchar(250) NOT NULL,
  idstation int(11) NOT NULL,
  updated timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS {prefix}tracks (
idtracks int(11) NOT NULL,
  id varchar(150) NOT NULL,
  artist varchar(150) NOT NULL,
  mbid varchar(150) NOT NULL,
  picture_small varchar(150) NOT NULL,
  picture_medium varchar(250) NOT NULL,
  picture_extra varchar(250) NOT NULL,
  track varchar(150) NOT NULL,
  album varchar(150) NOT NULL,
  track_number int(11) NOT NULL,
  duration int(11) NOT NULL,
  updated timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  plays int(11) NOT NULL,
  popularity int(11) NOT NULL,
  youtube_id varchar(15) NOT NULL,
  streaming_url text NOT NULL,
  soundcloud_id bigint(20) NOT NULL,
  likes int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS {prefix}tracks_lyrics (
idlyric int(11) NOT NULL,
  artist varchar(100) NOT NULL,
  track varchar(150) NOT NULL,
  lyric text NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS {prefix}translation (
id int(11) NOT NULL,
  `code` varchar(100) NOT NULL,
  translation varchar(250) NOT NULL,
  code_lang varchar(4) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=563 DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS {prefix}users (
id int(11) NOT NULL,
  username varchar(250) NOT NULL,
  email varchar(150) NOT NULL,
  `names` varchar(250) NOT NULL,
  avatar varchar(250) NOT NULL,
  is_admin int(11) NOT NULL DEFAULT '0',
  registered timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `password` varchar(250) NOT NULL,
  lang char(2) NOT NULL DEFAULT 'en',
  likes int(11) NOT NULL,
  facebook_url varchar(250) NOT NULL,
  twitter_url varchar(250) NOT NULL,
  google_plus_url varchar(250) NOT NULL,
  spotify_url varchar(250) NOT NULL,
  website_url varchar(250) NOT NULL,
  idfacebook varchar(100) NOT NULL,
  idgoogle varchar(100) NOT NULL,
  idvk varchar(100) NOT NULL,
  idspotify varchar(50) NOT NULL,
  recovery varchar(250) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS {prefix}users_history (
idhistory int(11) NOT NULL,
  iduser int(11) NOT NULL,
  artist varchar(100) NOT NULL,
  track varchar(100) NOT NULL,
  album varchar(100) NOT NULL,
  id varchar(50) NOT NULL,
  created timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  image varchar(200) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
ALTER TABLE {prefix}admin_menus ADD PRIMARY KEY (idmenu), ADD UNIQUE KEY idunique (idunique);
ALTER TABLE {prefix}albums ADD PRIMARY KEY (idalbum), ADD UNIQUE KEY id (id), ADD UNIQUE KEY album_idx (artist(10),album(10)), ADD FULLTEXT KEY album (artist(10),album(10));
ALTER TABLE {prefix}artist ADD PRIMARY KEY (idartist), ADD UNIQUE KEY id (id), ADD KEY genre_1 (genre_1,genre_2), ADD KEY artist (artist(40));
ALTER TABLE {prefix}artist_bio ADD PRIMARY KEY (idartistbio), ADD UNIQUE KEY artist (artist,lang);
ALTER TABLE {prefix}langs ADD PRIMARY KEY (id);
ALTER TABLE {prefix}languages ADD PRIMARY KEY (id);
ALTER TABLE {prefix}likes ADD PRIMARY KEY (idlike), ADD UNIQUE KEY iduser (iduser,idtarget,`type`);
ALTER TABLE {prefix}playlists ADD PRIMARY KEY (idplaylist), ADD FULLTEXT KEY `name` (`name`);
ALTER TABLE {prefix}playlists_tracks ADD PRIMARY KEY (idplaylisttracks), ADD UNIQUE KEY idplaylist (idplaylist,artist,track,album), ADD FULLTEXT KEY artist (artist), ADD FULLTEXT KEY track (track);
ALTER TABLE {prefix}sessions ADD UNIQUE KEY id (id), ADD KEY ci_sessions_timestamp (`timestamp`);
ALTER TABLE {prefix}settings ADD PRIMARY KEY (var), ADD UNIQUE KEY var (var), ADD KEY var_2 (var);
ALTER TABLE {prefix}stations ADD PRIMARY KEY (idstation), ADD UNIQUE KEY idstation (idstation), ADD UNIQUE KEY url (url(150),mount(100)), ADD FULLTEXT KEY title (title), ADD FULLTEXT KEY description (description), ADD FULLTEXT KEY genre (genre);
ALTER TABLE {prefix}stations_genres ADD PRIMARY KEY (id), ADD UNIQUE KEY `name` (`name`);
ALTER TABLE {prefix}stations_tracks ADD PRIMARY KEY (id), ADD UNIQUE KEY artist (artist,track,idstation), ADD FULLTEXT KEY artist_2 (artist), ADD FULLTEXT KEY track (track);
ALTER TABLE {prefix}tracks ADD PRIMARY KEY (idtracks), ADD UNIQUE KEY id (id), ADD FULLTEXT KEY artist (artist(10),album(10),track(10));
ALTER TABLE {prefix}tracks_lyrics ADD PRIMARY KEY (idlyric), ADD UNIQUE KEY artist (artist,track), ADD FULLTEXT KEY lyric (lyric);
ALTER TABLE {prefix}translation ADD PRIMARY KEY (id), ADD UNIQUE KEY `code` (`code`,code_lang);
ALTER TABLE {prefix}users ADD PRIMARY KEY (id), ADD UNIQUE KEY username (username), ADD KEY username_2 (username), ADD KEY `password` (`password`);
ALTER TABLE {prefix}users_history ADD PRIMARY KEY (idhistory), ADD UNIQUE KEY id (id,created);
ALTER TABLE {prefix}admin_menus MODIFY idmenu int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=19;
ALTER TABLE {prefix}albums MODIFY idalbum int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;
ALTER TABLE {prefix}artist MODIFY idartist int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;
ALTER TABLE {prefix}artist_bio MODIFY idartistbio int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;
ALTER TABLE {prefix}langs MODIFY id int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE {prefix}languages MODIFY id int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;
ALTER TABLE {prefix}likes MODIFY idlike int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;
ALTER TABLE {prefix}playlists MODIFY idplaylist int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;
ALTER TABLE {prefix}playlists_tracks MODIFY idplaylisttracks int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;
ALTER TABLE {prefix}stations MODIFY idstation int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=76;
ALTER TABLE {prefix}stations_genres MODIFY id int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=36;
ALTER TABLE {prefix}stations_tracks MODIFY id int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;
ALTER TABLE {prefix}tracks MODIFY idtracks int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;
ALTER TABLE {prefix}tracks_lyrics MODIFY idlyric int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;
ALTER TABLE {prefix}translation MODIFY id int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=563;
ALTER TABLE {prefix}users MODIFY id int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;
ALTER TABLE {prefix}users_history MODIFY idhistory int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;