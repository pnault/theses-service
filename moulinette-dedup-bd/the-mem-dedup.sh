#!/bin/sh
###############################################################################
# Pierre Nault - .20150612.
#
# Déduplication des entrées entre les thèses et mémoires présents dans Archipel
# et les entrées dans le dossier étudiants
#
# Utiliser comme :
#
# ./the-mem-dedup.sh t-m-1990-2015.csv ToadTextFile_2015-06-11T09_32_46.txt
#
#  À utiliser avec une connection automatique pour mysql dans le shell 
#
###############################################################################

moment=`date +"%Y%m%d"`

mkdir $moment

exec > $moment/logfile-the-mem-dup.txt

if [ "$1" != "" ] && [ "$2" != "" ]; then
    printf "\n Fichier du dossier etudiant : $1\n Fichier venant d'Archipel : $2"
else
    echo "J'ai besoin de 2 noms de fichiers comme t-m-1990... ToadText...."
	exit
fi

# ce n'est qu'à la fin qu'il faut enlever les courriels !!!!
#egrep '@uqam.ca' t-m-1990-2015.csv > dossier-etudiant-directeurs$moment

printf "\n\nPre-traitement du fichier $1"

# on retire les sans SEQ qu'on recombinera par la suite
egrep -v '\|[MD]-[0-9]+' $1 > $moment/dossier-etudiant-directeurs-sans-seq

# création du fichier qu'on va comparer plus loin
egrep '\|[MD]-[0-9]+' $1 > $moment/dossier-etudiant-directeurs-avec-seq


printf "\n\nResultats :\n Les sans SEQ : `wc -l $moment/dossier-etudiant-directeurs-sans-seq`\n Avec SEQ : `wc -l $moment/dossier-etudiant-directeurs-avec-seq`"


printf "\n\nNormalisation du fichier $moment/dossier-etudiant-directeurs-avec-seq$moment"

printf "\n Nombre d'entrees dans le fichier : `wc -l $moment/dossier-etudiant-directeurs-avec-seq`"

egrep '\|[MD]-[0-9]+' $moment/dossier-etudiant-directeurs-avec-seq | sed 's/\([MD]\)-0*/\1/g' > $moment/dossier-etudiant-directeurs-seq-acomparer

printf "\n Nombre normalise (devrait etre le meme) : `wc -l $moment/dossier-etudiant-directeurs-seq-acomparer`"



printf "\n\nNormalisation du fichier $2\n"

printf " Nombre d'entrees dans le fichier : `wc -l < $2`"

sed 's/-[0-9]\.pdf//g' $2 | sed 's/\.pdf//g' | egrep '@uqam.ca' > $moment/archipel-seq-acomparer

printf "\n Nombre normalise (devrait etre le meme) : `wc -l < $moment/archipel-seq-acomparer` (moins un pour la ligne des intitules de colonne)"

cd $moment

printf "\n\nCreation du fichier qui ne sont pas dans Archipel"

awk -F '|' 'NR==FNR{c[$4]++;next};c[$7] == 0' archipel-seq-acomparer dossier-etudiant-directeurs-seq-acomparer > dossier-etudiant-pas-dans-archipel

printf "\n Nombre qui ne sont pas dans Archipel : `wc -l dossier-etudiant-pas-dans-archipel`"

# On donne un chiffre de comparaison entre la réalité et ce qui devrait être (marge d'erreur)

nbDossieretudiant=`wc -l < dossier-etudiant-directeurs-seq-acomparer`

nbArchipel=`wc -l < archipel-seq-acomparer`

printf "\n Chiffre qui devrait : $(($nbDossieretudiant-$nbArchipel))"

printf "\n Creation d'un seul fichier"

cat dossier-etudiant-pas-dans-archipel dossier-etudiant-directeurs-sans-seq >> tous-dossier-pas-dans-archipel

#printf "\n\nOn ne prends que ceux qui ont un courriel de directeur ()"

egrep '@uqam.ca' tous-dossier-pas-dans-archipel > tous-dossier-pas-dans-archipel-avec-cour

nbSansCourriel=`egrep -cv '@uqam.ca' tous-dossier-pas-dans-archipel`

printf "\n\nOn ne prends que ceux qui ont un courriel de directeur ($nbSansCourriel n'en n'ont pas)"

printf "\n Il en reste `wc -l tous-dossier-pas-dans-archipel-avec-cour` pour integration dans le repertoire des professeurs"

printf "\n\nModification du fichier dossier etudiant pour le fitter a l'unificateur"

# on doit enelver les guillemets autrement ça fuck les donnees

sed 's/"//g' tous-dossier-pas-dans-archipel-avec-cour > tous-dossier-pas-dans-archipel-avec-cour-guill

# creation du fichier uni

cat tous-dossier-pas-dans-archipel-avec-cour-guill | cut -d'|' -f2,6,7,9,12,14 > tous-dos-pas-ds-archi-a-cour-fituni

# on rajoute un pipe pour avoir 7 champs dans le fichier

sed 's/$/|pasdansarchipel/' tous-dos-pas-ds-archi-a-cour-fituni > tous-dos-pas-ds-archi-a-cour-fituni-2

printf "\n\nOn a `wc -l < tous-dos-pas-ds-archi-a-cour-fituni-2` entrees dans le dossier etudiant"

# on reprend le fichier d'archipel pour le faire fitter avec l'autre

printf "\n\nModification du fichier archipel pour le fitter a l'autre"

cat archipel-seq-acomparer | cut -d'|' -f2,3,4,5,6,7,8 > archipel-fituni

printf "\n\nOn a `wc -l < archipel-fituni` entrees dans le fichier archipel"

# on fusionne les deux en vue de l'importation dans la BD

cat archipel-fituni tous-dos-pas-ds-archi-a-cour-fituni-2 > fichier-import-bd

printf "\n\nOn va importer `wc -l < fichier-import-bd` entrees dans la BD"

cp -p fichier-import-bd /tmp

printf "\n\nTraitement termine\n"

printf "\n\nLe reste se passe dans import-bd.sh\n\n"

../import-bd.sh

exit 0
