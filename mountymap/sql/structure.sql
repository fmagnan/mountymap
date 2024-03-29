SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

DROP TABLE IF EXISTS `champignon`;
CREATE TABLE IF NOT EXISTS `champignon` (
  `id` int(11) NOT NULL,
  `mise_a_jour` datetime NOT NULL,
  `nom` varchar(100) NOT NULL,
  `position_x` int(11) NOT NULL,
  `position_y` int(11) NOT NULL,
  `position_n` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `diplomacy`;
CREATE TABLE IF NOT EXISTS `diplomacy` (
  `id` int(11) NOT NULL,
  `target_type` char(1) NOT NULL,
  `target_id` int(11) NOT NULL,
  `mise_a_jour` datetime NOT NULL,
  `name` varchar(100) NOT NULL,
  `side` varchar(20) NOT NULL,
  PRIMARY KEY  (`id`, `target_type`, `target_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `guilde`;
CREATE TABLE IF NOT EXISTS `guilde` (
  `id` int(11) NOT NULL,
  `mise_a_jour` datetime NOT NULL,
  `nom` varchar(100) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `lieu`;
CREATE TABLE IF NOT EXISTS `lieu` (
  `id` int(11) NOT NULL,
  `mise_a_jour` datetime NOT NULL,
  `nom` varchar(100) NOT NULL,
  `type` varchar(100) NOT NULL,
  `position_x` int(11) NOT NULL,
  `position_y` int(11) NOT NULL,
  `position_n` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `membre`;
CREATE TABLE IF NOT EXISTS `membre` (
  `id` int(11) NOT NULL,
  `mise_a_jour` datetime NOT NULL,
  `password` varchar(32) character set latin1 NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `monstre`;
CREATE TABLE IF NOT EXISTS `monstre` (
  `id` int(11) NOT NULL,
  `mise_a_jour` datetime NOT NULL,
  `nom` varchar(100) NOT NULL,
  `template` varchar(100) NOT NULL,
  `taille` varchar(100) NOT NULL,
  `age` varchar(100) NOT NULL,
  `marquage` varchar(100) NOT NULL,
  `famille` varchar(100) NOT NULL,
  `niveau` int(11) NOT NULL,
  `position_x` int(11) NOT NULL,
  `position_y` int(11) NOT NULL,
  `position_n` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `tresor`;
CREATE TABLE IF NOT EXISTS `tresor` (
  `id` int(11) NOT NULL,
  `mise_a_jour` datetime NOT NULL,
  `nom` varchar(100) NOT NULL,
  `position_x` int(11) NOT NULL,
  `position_y` int(11) NOT NULL,
  `position_n` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `troll_identity`;
CREATE TABLE IF NOT EXISTS `troll_identity` (
  `id` int(11) NOT NULL,
  `mise_a_jour` datetime NOT NULL,
  `nom` varchar(100) NOT NULL,
  `race` varchar(100) NOT NULL,
  `niveau` int(11) NOT NULL,
  `id_guilde` int(11) NOT NULL,
  `nombre_mouches` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `troll_position`;
CREATE TABLE IF NOT EXISTS `troll_position` (
  `id` int(11) NOT NULL,
  `mise_a_jour` datetime NOT NULL,
  `position_x` int(11) NOT NULL,
  `position_y` int(11) NOT NULL,
  `position_n` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(10) NOT NULL,
  `password` varchar(32) NOT NULL,
  `email` varchar(50) NOT NULL,
  `activation_code` varchar(8) NOT NULL,
  `is_active` int(1) NOT NULL default '0',
  `is_admin` int(1) NOT NULL default '0',
  `diplomacy_id` int(11) NOT NULL default '1',
  `position_x` int(11) NOT NULL,
  `position_y` int(11) NOT NULL,
  `position_n` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;