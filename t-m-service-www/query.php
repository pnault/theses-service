<?php
/*
-Programme pour interroger la BD thesememoire
-Retourne un réponse en format JSON
-Créer le 20150803
-Auteur : Pierre Nault
*/

$reqCour = $_GET['c'] . "@uqam.ca";

if (isset($_GET['a'])) {
	$a = $_GET['a'];
}
	
$servername = "localhost";
$username = "thesememoireuser";
$password = "5EHAtCfhqJ";
$dbname = "thesememoire";

// info de connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// connexion
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$sql = "SELECT auteur, diplome, seqentiel, titre, annee, archipel, courrielDir, docutype from thesememoire.listinfo where courrielDir = '$reqCour' order by annee desc";
$result = mysqli_query($conn, $sql);
$rows = array();

if (mysqli_num_rows($result) > 0) {
	while($r = mysqli_fetch_assoc($result)) {

		// type = Travail
		if ($r['docutype'] == 0) {

		// libellé = contenu du champs
		$lastArray['auteurthese'] = preg_replace('/\*/', ', ', $r["auteur"]);
		$lastArray['annee'] = substr($r["annee"], 0, 4);
		$lastArray['titrethese'] = $r['titre'];
		// .20161017.pn ajout:
		$lastArray['type'] = $r['docutype'];
        $dip = "Travail";
		$lastArray['diplome'] = $dip;
		
		if ($r['archipel'] == "pasdansarchipel") {
			$lastArray['dansarchipel'] = "non";
			} else {
			$lastArray['dansarchipel'] = "http://www.archipel.uqam.ca/" . str_replace("\r", "", $r['archipel']);
			}
		
		// on met tous les ligne dans un dernier tableau
		$travail[] = $lastArray;
		
		} elseif($r['docutype'] == 1) {

		// libellé = contenu du champs
		$lastArray['auteurthese'] = preg_replace('/\*/', ', ', $r["auteur"]);
		$lastArray['annee'] = substr($r["annee"], 0, 4);
		$lastArray['titrethese'] = $r['titre'];
		// .20161017.pn ajout:
		$lastArray['type'] = $r['docutype'];
        $dip = "Rapport (de recherches)";
		$lastArray['diplome'] = $dip;
		
		if ($r['archipel'] == "pasdansarchipel") {
			$lastArray['dansarchipel'] = "non";
			} else {
			$lastArray['dansarchipel'] = "http://www.archipel.uqam.ca/" . str_replace("\r", "", $r['archipel']);
			}
		
		// on met tous les ligne dans un dernier tableau
		$rapportRech[] = $lastArray;
		
		} elseif($r['docutype'] == 2) {

		// libellé = contenu du champs
		$lastArray['auteurthese'] = preg_replace('/\*/', ', ', $r["auteur"]);
		$lastArray['annee'] = substr($r["annee"], 0, 4);
		$lastArray['titrethese'] = $r['titre'];
		// .20161017.pn ajout:
		$lastArray['type'] = $r['docutype'];
        $dip = "Rapport (de stage)";
		$lastArray['diplome'] = $dip;
		
		if ($r['archipel'] == "pasdansarchipel") {
			$lastArray['dansarchipel'] = "non";
			} else {
			$lastArray['dansarchipel'] = "http://www.archipel.uqam.ca/" . str_replace("\r", "", $r['archipel']);
			}
		
		// on met tous les ligne dans un dernier tableau
		$rapportSta[] = $lastArray;
		
		} elseif($r['docutype'] == 3) {

		// libellé = contenu du champs
		$lastArray['auteurthese'] = preg_replace('/\*/', ', ', $r["auteur"]);
		$lastArray['annee'] = substr($r["annee"], 0, 4);
		$lastArray['titrethese'] = $r['titre'];
		// .20161017.pn ajout:
		$lastArray['type'] = $r['docutype'];
        $dip = "Oeuvre";
		$lastArray['diplome'] = $dip;
		
		if ($r['archipel'] == "pasdansarchipel") {
			$lastArray['dansarchipel'] = "non";
			} else {
			$lastArray['dansarchipel'] = "http://www.archipel.uqam.ca/" . str_replace("\r", "", $r['archipel']);
			}
		
		// on met tous les ligne dans un dernier tableau
		$oeuvre[] = $lastArray;
		
		} elseif($r['docutype'] == 4) {

		// libellé = contenu du champs
		$lastArray['auteurthese'] = preg_replace('/\*/', ', ', $r["auteur"]);
		$lastArray['annee'] = substr($r["annee"], 0, 4);
		$lastArray['titrethese'] = $r['titre'];
		// .20161017.pn ajout:
		$lastArray['type'] = $r['docutype'];
        $dip = "Mémoire";
		$lastArray['diplome'] = $dip;
		
		if ($r['archipel'] == "pasdansarchipel") {
			$lastArray['dansarchipel'] = "non";
			} else {
			$lastArray['dansarchipel'] = "http://www.archipel.uqam.ca/" . str_replace("\r", "", $r['archipel']);
			}
		
		// on met tous les ligne dans un dernier tableau
		$mem[] = $lastArray;
		
		} elseif($r['docutype'] == 5) {

		// libellé = contenu du champs
		$lastArray['auteurthese'] = preg_replace('/\*/', ', ', $r["auteur"]);
		$lastArray['annee'] = substr($r["annee"], 0, 4);
		$lastArray['titrethese'] = $r['titre'];
		// .20161017.pn ajout:
		$lastArray['type'] = $r['docutype'];
        $dip = "Thèse";
		$lastArray['diplome'] = $dip;
		
		if ($r['archipel'] == "pasdansarchipel") {
			$lastArray['dansarchipel'] = "non";
			} else {
			$lastArray['dansarchipel'] = "http://www.archipel.uqam.ca/" . str_replace("\r", "", $r['archipel']);
			}
		
		// on met tous les ligne dans un dernier tableau
		$these[] = $lastArray;
		
		} elseif($r['docutype'] == 6) {

		// libellé = contenu du champs
		$lastArray['auteurthese'] = preg_replace('/\*/', ', ', $r["auteur"]);
		$lastArray['annee'] = substr($r["annee"], 0, 4);
		$lastArray['titrethese'] = $r['titre'];
		// .20161017.pn ajout:
		$lastArray['type'] = $r['docutype'];
        $dip = "Travaux dirigés";
		$lastArray['diplome'] = $dip;
		
		if ($r['archipel'] == "pasdansarchipel") {
			$lastArray['dansarchipel'] = "non";
			} else {
			$lastArray['dansarchipel'] = "http://www.archipel.uqam.ca/" . str_replace("\r", "", $r['archipel']);
			}
		
		// on met tous les ligne dans un dernier tableau
		$travauxDir[] = $lastArray;
		
		} elseif($r['docutype'] == 7) {

		// libellé = contenu du champs
		$lastArray['auteurthese'] = preg_replace('/\*/', ', ', $r["auteur"]);
		$lastArray['annee'] = substr($r["annee"], 0, 4);
		$lastArray['titrethese'] = $r['titre'];
		// .20161017.pn ajout:
		$lastArray['type'] = $r['docutype'];
        $dip = "Rapport d'activités et projet d'intervention";
		$lastArray['diplome'] = $dip;
		
		if ($r['archipel'] == "pasdansarchipel") {
			$lastArray['dansarchipel'] = "non";
			} else {
			$lastArray['dansarchipel'] = "http://www.archipel.uqam.ca/" . str_replace("\r", "", $r['archipel']);
			}
		
		// on met tous les ligne dans un dernier tableau
		$rapportActi[] = $lastArray;
		
		} elseif($r['docutype'] == 8) {

		// libellé = contenu du champs
		$lastArray['auteurthese'] = preg_replace('/\*/', ', ', $r["auteur"]);
		$lastArray['annee'] = substr($r["annee"], 0, 4);
		$lastArray['titrethese'] = $r['titre'];
		// .20161017.pn ajout:
		$lastArray['type'] = $r['docutype'];
        $dip = "Essai";
		$lastArray['diplome'] = $dip;
		
		if ($r['archipel'] == "pasdansarchipel") {
			$lastArray['dansarchipel'] = "non";
			} else {
			$lastArray['dansarchipel'] = "http://www.archipel.uqam.ca/" . str_replace("\r", "", $r['archipel']);
			}
		
		// on met tous les ligne dans un dernier tableau
		$essai[] = $lastArray;
		
		} elseif($r['docutype'] == 9) {

		// libellé = contenu du champs
		$lastArray['auteurthese'] = preg_replace('/\*/', ', ', $r["auteur"]);
		$lastArray['annee'] = substr($r["annee"], 0, 4);
		$lastArray['titrethese'] = $r['titre'];
		// .20161017.pn ajout:
		$lastArray['type'] = $r['docutype'];
        $dip = "Texte de création";
		$lastArray['diplome'] = $dip;
		
		if ($r['archipel'] == "pasdansarchipel") {
			$lastArray['dansarchipel'] = "non";
			} else {
			$lastArray['dansarchipel'] = "http://www.archipel.uqam.ca/" . str_replace("\r", "", $r['archipel']);
			}
		
		// on met tous les ligne dans un dernier tableau
		$texteCrea[] = $lastArray;
		
		}
 		
	}
	
	$atrier = array($these, $mem, $travail, $rapportRech, $rapportSta, $oeuvre, $travauxDir, $rapportActi, $essai, $texteCrea);
	
	$merge['listeTheseMemoireAutres'] = array();
	
	foreach($atrier as $trie) {
		if(is_array($trie)){
			$merge['listeTheseMemoireAutres'] = array_merge($merge['listeTheseMemoireAutres'], $trie);
		}
		
	}
	
	
	$json = json_encode($merge);
	print $json;
	
	if (isset($a)) {
	
		echo "<br /><br />";
		// var_dump(json_decode($json, true));
		$jsondecode = json_decode($json, true, 100);
			foreach($jsondecode['listeTheseMemoireAutres'] as $item) {
			echo "<br />Auteur : " . $item['auteurthese'];
			echo "<br />Année : " . $item['annee'];
			echo "<br />Titre : " . $item['titrethese'];
			echo "<br />Diplôme (selon le code): " . $item['diplome'];
			if ($item['dansarchipel'] == "non") {
				echo "<br />Archipel : " . "NON";
				} else {
				echo "<br />Archipel : " . "<a href=\"" . $item['dansarchipel'] . "\">" . $item['dansarchipel'] . "</a>";
			} 	
		echo "<br /><br />";
		}
	}

} else {
	
	// pas de résultat au niveau de la requête
	echo "Pas de résultats";

}

mysqli_close($conn);

?>