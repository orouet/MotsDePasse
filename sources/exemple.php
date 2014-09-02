<?PHP

/* MODELE */

// Chargement de la bibliothèques
require_once('motsdepasse.php');

// Définition des valeurs par défaut
$etape = 1;
$donnees = array();
$longueur = 8;
$majuscules = 2;
$minuscules = 2;
$chiffres = 2;
$speciaux = 2;
$melanges = 3;
$nombre = 1;
$mdps = array();


// Lecture des données transmises
if (isset($_REQUEST['etape'])) {
	if ($_REQUEST['etape'] != '') {
		$etape = (integer) $_REQUEST['etape'];
	}
}

if (isset($_REQUEST['longueur'])) {
	if ($_REQUEST['longueur'] != '') {
		$longueur = (integer) $_REQUEST['longueur'];
	}
}

if (isset($_REQUEST['majuscules'])) {
	if ($_REQUEST['majuscules'] != '') {
		$majuscules = (integer) $_REQUEST['majuscules'];
	}
}

if (isset($_REQUEST['minuscules'])) {
	if ($_REQUEST['minuscules'] != '') {
		$minuscules = (integer) $_REQUEST['minuscules'];
	}
}

if (isset($_REQUEST['chiffres'])) {
	if ($_REQUEST['chiffres'] != '') {
		$chiffres = (integer) $_REQUEST['chiffres'];
	}
}

if (isset($_REQUEST['speciaux'])) {
	if ($_REQUEST['speciaux'] != '') {
		$speciaux = (integer) $_REQUEST['speciaux'];
	}
}

if (isset($_REQUEST['melanges'])) {
	if ($_REQUEST['melanges'] != '') {
		$melanges = (integer) $_REQUEST['melanges'];
	}
}

if (isset($_REQUEST['nombre'])) {
	if ($_REQUEST['nombre'] != '') {
		$nombre = (integer) $_REQUEST['nombre'];
	}
}

// Etape 1


// Etape 2
if ($etape == 2) {
	$etape = 1;
	if ($nombre > 0) {
		if (($majuscules + $minuscules + $chiffres + $speciaux) <= $longueur) {
			$etape = 2;
			for ($i = 0; $i < $nombre; $i ++) {
				$password = (string) mdp_generer($longueur, $majuscules, $minuscules, $chiffres, $speciaux, $melanges);
				$mdps[] = $password;
			}
		}
	}
}

// Mise en forme du résultat
$donnees = array(
	'etape' => $etape,
	'longueur' => $longueur,
	'majuscules' => $majuscules,
	'minuscules' => $minuscules,
	'chiffres' => $chiffres,
	'speciaux' => $speciaux,
	'melanges' => $melanges,
	'nombre' => $nombre,
	'mdps' => $mdps,
);



/* VUE */

// Définition des valeurs par défaut
$url = 'exemple.php';
$sortie = '';

// Composition de la vue
$sortie .= '<!doctype html>' . "\n";
$sortie .= '<html lang="fr">' . "\n";

$sortie .= '<head>' . "\n";
$sortie .= '<meta charset="utf-8" />' . "\n";
$sortie .= '<title>Générateur de mot de passe</title>' . "\n";
$sortie .= '</head>' . "\n";

$sortie .= '<body>' . "\n";

$sortie .= '<h1>Générateur de mots de passe</h1>' . "\n";

// Etape 1
if ($donnees['etape'] == 1) {

	$sortie .= '<h2>Paramètres</h2>' . "\n";
	
	$sortie .= '<form action="' . $url . '" method="post">' . "\n";
	
	$sortie .= '<table>' . "\n";
	
	$sortie .= '<tr>' . "\n";
	$sortie .= '<td>Longueur :</td>' . "\n";
	$sortie .= '<td><input type="text" name="longueur" value="' . $donnees['longueur'] . '" /></td>' . "\n";
	$sortie .= '</tr>' . "\n";
	
	$sortie .= '<tr>' . "\n";
	$sortie .= '<td>Majuscules :</td>' . "\n";
	$sortie .= '<td><input type="text" name="majuscules" value="' . $donnees['majuscules'] . '" /></td>' . "\n";
	$sortie .= '</tr>' . "\n";
	
	$sortie .= '<tr>' . "\n";
	$sortie .= '<td>Minuscules :</td>' . "\n";
	$sortie .= '<td><input type="text" name="minuscules" value="' . $donnees['minuscules'] . '" /></td>' . "\n";
	$sortie .= '</tr>' . "\n";
	
	$sortie .= '<tr>' . "\n";
	$sortie .= '<td>Chiffres :</td>' . "\n";
	$sortie .= '<td><input type="text" name="chiffres" value="' . $donnees['chiffres'] . '" /></td>' . "\n";
	$sortie .= '</tr>' . "\n";
	
	$sortie .= '<tr>' . "\n";
	$sortie .= '<td>Spéciaux :</td>' . "\n";
	$sortie .= '<td><input type="text" name="speciaux" value="' . $donnees['speciaux'] . '" /></td>' . "\n";
	$sortie .= '</tr>' . "\n";
	
	$sortie .= '<tr>' . "\n";
	$sortie .= '<td>Mélanges :</td>' . "\n";
	$sortie .= '<td><input type="text" name="melanges" value="' . $donnees['melanges'] . '" /></td>' . "\n";
	$sortie .= '</tr>' . "\n";
	
	$sortie .= '<tr>' . "\n";
	$sortie .= '<td>Nombre de mot de passe :</td>' . "\n";
	$sortie .= '<td><input type="text" name="nombre" value="' . $donnees['nombre'] . '" /></td>' . "\n";
	$sortie .= '</tr>' . "\n";
	
	$sortie .= '</table>' . "\n";
	
	$sortie .= '<p>' . "\n";
	$sortie .= '<input type="hidden" name="etape" value="2" />' . "\n";
	$sortie .= '<input type="submit" value="Valider" />' . "\n";
	$sortie .= '</p>' . "\n";
	
	$sortie .= '</form>' . "\n";

}


// Etape 2
if ($donnees['etape'] == 2) {

	$sortie .= '<h2>Résultat</h2>' . "\n";
	
	$sortie .= '<table>' . "\n";
	
	$sortie .= '<tr>' . "\n";
	$sortie .= '<th>N°</th>' . "\n";
	$sortie .= '<th>Mot de passe</th>' . "\n";
	$sortie .= '</tr>' . "\n";
	
	foreach ($donnees['mdps'] as $i => $password ) {
	
		$sortie .= '<tr>' . "\n";
		$sortie .= '<td>' . $i . '</td>' . "\n";
		$sortie .= '<td>' . htmlspecialchars($password) . '</td>' . "\n";
		$sortie .= '</tr>' . "\n";
	
	}
	
	$sortie .= '</table>' . "\n";
	
	$sortie .= '<p>' . "\n";
	$sortie .= '<a href="' . $url . '"><button>Changer les paramètres</button></a>' . "\n";
	$sortie .= '</p>' . "\n";

}

$sortie .= '</body>' . "\n";

$sortie .= '</html>';

echo $sortie;

?>