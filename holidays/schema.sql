# A listing of public holidays, and the attribution for them.
CREATE TABLE `public_holidays` (
  `ph_id` int(11) unsigned NOT NULL auto_increment,
  `ph_date` int(10) default NULL,
  `ph_name` varchar(100) default NULL,
  `ph_timezone` varchar(100) default NULL,
  `source_uri` varchar(200),
  PRIMARY KEY  (`ph_id`)
);

# An area, defined by a list of points
CREATE TABLE `areas` (
  `area_id` int(11) unsigned NOT NULL auto_increment,
  `area_name` varchar(100) default NULL,
  `polygon_coordinates` varchar(100) default NULL,
  `same_as_uri` varchar(200) NOT NULL,
  PRIMARY KEY  (`area_id`)
);

# Typically states, but sometimes smaller points
# Same as URI = dbpedia / wikipedia / geonames URI?
CREATE TABLE `areas_public_holidays` (
  `aph_id` INT(11) unsigned NOT NULL auto_increment,
  `area_id` int(11) unsigned NOT NULL,
  `pg_id` int(11) unsigned NOT NULL,
  PRIMARY KEY  (`aph_id`)
);

# Data
