#!/bin/sh
###############################################################################
# Pierre Nault - .20150716.
#
# Pour importer les données sur thèse et mémoires
#
#
###############################################################################


moment=`date +"%Y%m%d"`

#Pour que le script fonctionne au premier départ il faut:

#1) Une BD thesememoire:
#mysql>create database thesememoire;

#2) Un user :
#mysql>CREATE USER 'thesememoireuser'@'localhost' IDENTIFIED BY '5EHAtCfhqJ';
#pour voir les users : select user from user;

#3) Avec droits de lecture :
#GRANT SELECT ON thesememoire.* TO 'thesememoireuser'@'localhost';
# pour voir les droits d'un user : show grants for 'thesememoireuser'@'localhost';


# suis les exécutions dans le shell mysql

mysql << EOF

drop database thesememoire;

create database thesememoire;

use thesememoire;

status;

CREATE TABLE listinfo
(
auteur varchar(255),
diplome varchar(255),
seqentiel varchar(255),
courrielDir varchar(255),
titre varchar(500),
annee varchar(255),
archipel varchar(255)
);

LOAD DATA INFILE '/tmp/fichier-import-bd' 
INTO TABLE listinfo 
FIELDS TERMINATED BY '|' 
ENCLOSED BY ''
LINES TERMINATED BY '\n';

EOF
 
exit 0
