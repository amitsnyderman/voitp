CREATE TABLE `experts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `phone_number` varchar(10) NOT NULL,
  `first_name` varchar(30) CHARACTER SET latin1 DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `created_on` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unq_phone_number` (`phone_number`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

CREATE TABLE `availability` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `expert_id` int(11) DEFAULT NULL,
  `day` int(1) NOT NULL,
  `from` time DEFAULT NULL,
  `through` time DEFAULT NULL,
  `allday` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `expert_id` (`expert_id`),
  CONSTRAINT `availability_ibfk_1` FOREIGN KEY (`expert_id`) REFERENCES `experts` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

CREATE TABLE `topics` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

CREATE TABLE `specialties` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `topic_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `context` varchar(50) NOT NULL,
  `extension` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `topic_id` (`topic_id`),
  CONSTRAINT `specialties_ibfk_1` FOREIGN KEY (`topic_id`) REFERENCES `topics` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

CREATE TABLE `experts_specialties` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `expert_id` int(11) NOT NULL,
  `specialty_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `expert_specialty_id` (`expert_id`,`specialty_id`),
  CONSTRAINT `experts_specialties_ibfk_1` FOREIGN KEY (`expert_id`) REFERENCES `experts` (`id`),
  CONSTRAINT `experts_specialties_ibfk_2` FOREIGN KEY (`specialty_id`) REFERENCES `specialties` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

CREATE TABLE `calls` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `expert_id` int(11) NOT NULL,
  `phone_number` int(10) NOT NULL,
  `call_duration` int(11) DEFAULT NULL,
  `created_on` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `expert_id` (`expert_id`),
  CONSTRAINT `calls_ibfk_1` FOREIGN KEY (`expert_id`) REFERENCES `experts` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

-- Sample Data

INSERT INTO `experts` (`id`,`phone_number`,`first_name`,`last_name`,`created_on`)
VALUES
	(1,'6466443604','Amit','Snyderman','2011-02-28 18:00:00'),
	(2,'2069471415','Aaron','Uhrmacher','2011-02-28 18:00:00');

INSERT INTO `availability` (`id`,`expert_id`,`day`,`from`,`through`,`allday`)
VALUES
	(1,1,1,'09:00:00','17:00:00',0),
	(2,1,3,'09:00:00','17:00:00',0),
	(3,1,5,'09:00:00','17:00:00',0),
	(4,1,6,NULL,NULL,1),
	(5,2,2,'11:00:00','20:00:00',0),
	(6,2,3,'11:00:00','20:00:00',0),
	(7,2,4,'11:00:00','20:00:00',0);

INSERT INTO `topics` (`id`,`name`)
VALUES
	(1,'Physical Computing'),
	(2,'Programming'),
	(3,'Thesis');

INSERT INTO `specialties` (`id`,`topic_id`,`name`,`context`,`extension`)
VALUES
	(1,2,'Python','as860_voitp_code',3),
	(2,2,'JavaScript','as860_voitp_code',2),
	(3,2,'Ruby','as860_voitp_code',3),
	(4,2,'Processing','as860_voitp_code',1),
	(5,2,'HTML/CSS','as860_voitp_code',2),
	(6,1,'Arduino','as860_voitp_pcomp',1),
	(7,1,'Soldering','as860_voitp_pcomp',1),
	(8,3,'Thesis','as860_voitp_thesis',1);

INSERT INTO `experts_specialties` (`id`,`expert_id`,`specialty_id`)
VALUES
	(1,1,2),
	(2,1,3),
	(3,1,5),
	(4,1,8),
	(5,2,1),
	(6,2,4);