<?PHP

/*

Copyright Olivier ROUET, 23/09/2012

olivier.rouet@gmail.com

Ce logiciel est un programme informatique servant à générer des mots de passe.

Ce logiciel est régi par la licence CeCILL-C soumise au droit français et
respectant les principes de diffusion des logiciels libres. Vous pouvez
utiliser, modifier et/ou redistribuer ce programme sous les conditions
de la licence CeCILL-C telle que diffusée par le CEA, le CNRS et l'INRIA 
sur le site "http://www.cecill.info".

En contrepartie de l'accessibilité au code source et des droits de copie,
de modification et de redistribution accordés par cette licence, il n'est
offert aux utilisateurs qu'une garantie limitée.  Pour les mêmes raisons,
seule une responsabilité restreinte pèse sur l'auteur du programme,  le
titulaire des droits patrimoniaux et les concédants successifs.

A cet égard  l'attention de l'utilisateur est attirée sur les risques
associés au chargement,  à l'utilisation,  à la modification et/ou au
développement et à la reproduction du logiciel par l'utilisateur étant 
donné sa spécificité de logiciel libre, qui peut le rendre complexe à 
manipuler et qui le réserve donc à des développeurs et des professionnels
avertis possédant  des  connaissances  informatiques approfondies.  Les
utilisateurs sont donc invités à charger  et  tester  l'adéquation  du
logiciel à leurs besoins dans des conditions permettant d'assurer la
sécurité de leurs systèmes et ou de leurs données et, plus généralement, 
à l'utiliser et l'exploiter dans les mêmes conditions de sécurité. 

Le fait que vous puissiez accéder à cet en-tête signifie que vous avez 
pris connaissance de la licence CeCILL-C, et que vous en avez accepté les
termes.

*/


// Constantes
define('MDP_DEBUG', false);


// fonction de debugging
function mdp_debug($variable, $message = false)
{

	// Initialisation des variables
	$sortie = false;
	
	// Traitement
	if (MDP_DEBUG === true) {
	
		if ($message !== false) {
		
			echo $message . print_r($variable, true);
		
		} else {
		
			echo print_r($variable, true);
		
		}
		
		$sortie = true;
	
	}
	
	// Sortie
	return $sortie;

}


// fonction de mesure de temps
function mdp_temps()
{

	// initialisation des variables
	$sortie = false;
	
	// traitement
	list($usecondes, $secondes) = explode(' ', microtime());
	$sortie = (( float ) $usecondes + ( float ) $secondes);
	
	// sortie
	return $sortie;

}


// fonction de génération aléatoire d'un entier entre min et max
function mdp_random($min, $max)
{

	// initialisation des variables
	$sortie = false;
	
	// traitement
	$min = (integer) $min;
	$max = (integer) $max;
	$sortie = (integer) mt_rand($min, $max);
	
	// sortie
	return $sortie;

}

// fonction qui tire un caractère dans une chaine (dictionnaire)
function mdp_chaine_tirage($dictionnaire)
{

	// initialisation des variables
	$sortie = false;
	
	// mesure de la taille du dictionnaire
	$taille = strlen($dictionnaire);
	
	// boucle de traitement
	if ($taille > 0) {
	
		$caractere = '';
		$position = mdp_random(0, ($taille - 1));
		mdp_debug('Hazard = ' . $position . "\n");
		
		$caractere = $dictionnaire[$position];
		mdp_debug('Caractère = ' . $caractere . "\n");
		
		$sortie = (string) $caractere;
	
	}
	
	// sortie
	return $sortie;

}


// fonction qui mélange une chaine
function mdp_chaine_melanger($chaine)
{

	// initialisation des variables
	$sortie = false;
	$melange = '';
	
	// mesure de la taille de la chaine à mélanger
	$taille = strlen($chaine);
	mdp_debug('Entrée : ' . $chaine . "\n");
	
	//
	$i = 1;
	
	while (strlen($melange) < $taille ) {
	
		mdp_debug('Tirage N°' . $i . ' : ');
		$t = strlen($chaine);
		
		if ($t > 0) {
		
			mdp_debug('Chaine = ' . $chaine . ' ; ');
			
			// position random
			$position = mdp_random(0, ($t - 1));
			mdp_debug('Hazard = ' . $position . ' ; ');
			
			//
			$melange .= $chaine[$position];
			mdp_debug('Mélange = ' . $melange . ' ; ');
			
			//
			if ($position > 0) {
			
				$a = substr($chaine, 0, $position);
			
			} else {
			
				$a = '';
			
			}
			
			mdp_debug('Morceau A = ' . $a . ' ; ');
			
			//
			if ($position < $t) {
			
				$b = substr($chaine, ($position + 1));
			
			} else {
			
				$b = '';
			
			}
			
			//
			mdp_debug('Morceau B = ' . $b . "\n");
			
			//
			$chaine = $a . $b;
		
		}
		
		$i ++;
	
	}
	
	mdp_debug('Sortie : ' . $melange . "\n");
	$sortie = (string) $melange;
	
	// sortie
	return $sortie;

}

//
function mdp_generer($longueur, $majuscules_min, $minuscules_min, $chiffres_min, $speciaux_min, $passes)
{

	// initialisation des variables
	$sortie = false;
	$chaine = '';
	$majuscules_dic = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$minuscules_dic = 'abcdefghijklmnopqrstuvwxyz';
	$chiffres_dic = '0123456789';
	$speciaux_dic = '-+*=<>%.!?,;:()[]{}@#&$_';
	$dictionnaire = array(
		'0' => $majuscules_dic,
		'1' => $minuscules_dic,
		'2' => $chiffres_dic,
		'3' => $speciaux_dic
	);
	
	// lecture des paramètres
	$longueur = (integer) $longueur;
	$majuscules_min = (integer) $majuscules_min;
	$minuscules_min = (integer) $minuscules_min;
	$chiffres_min = (integer) $chiffres_min;
	$speciaux_min = (integer) $speciaux_min;
	
	// calcul des variables complémentaires
	$minimum = $majuscules_min + $minuscules_min + $chiffres_min + $speciaux_min;
	$complement = ($longueur - $minimum);
	
	// la somme des contraintes doit être inférieure ou égale à la longueur du mot de passe
	if ($minimum <= $longueur) {
	
		// majuscules
		mdp_debug('Tirage de  ' . $majuscules_min . ' majuscules' . "\n");
		
		for ($i = 0; $i < $majuscules_min; $i ++) {
		
			// On choisit le dictionnaire
			$d = '0';
			
			// On tire un caractère dans le dictionnaire
			$tirage = '';
			$tirage = mdp_chaine_tirage($dictionnaire[$d]);
			
			// On ajoute le tirage à la chaine
			$chaine .= $tirage;
			mdp_debug('Tirage N°' . $i . ' : ' . $tirage . "\n");
		
		}
		
		
		// minuscules
		mdp_debug('Tirage de  ' . $minuscules_min . ' minuscules' . "\n");
		
		for ($i = 0; $i < $minuscules_min; $i ++) {
		
			// On choisit le dictionnaire
			$d = '1';
			
			// On tire un caractère dans le dictionnaire
			$tirage = '';
			$tirage = mdp_chaine_tirage($dictionnaire[$d]);
			
			// On ajoute le tirage à la chaine
			$chaine .= $tirage;
			mdp_debug('Tirage N°' . $i . ' : ' . $tirage . "\n");
		
		}
		
		
		// chiffres
		mdp_debug('Tirage de  ' . $chiffres_min . ' chiffres' . "\n");
		
		for ($i = 0; $i < $chiffres_min; $i ++) {
		
			// On choisit le dictionnaire
			$d = '2';
			
			// On tire un caractère dans le dictionnaire
			$tirage = '';
			$tirage = mdp_chaine_tirage($dictionnaire[$d]);
			
			// On ajoute le tirage à la chaine
			$chaine .= $tirage;
			mdp_debug('Tirage N°' . $i . ' : ' . $tirage . "\n");
		
		}
		
		
		// caractères spéciaux
		mdp_debug('Tirage de  ' . $speciaux_min . ' spéciaux' . "\n");
		
		for ($i = 0; $i < $speciaux_min; $i ++) {
		
			// On choisit le dictionnaire
			$d = '3';
			
			// On tire un caractère dans le dictionnaire
			$tirage = '';
			$tirage = mdp_chaine_tirage($dictionnaire[$d]);
			
			// On ajoute le tirage à la chaine
			$chaine .= $tirage;
			mdp_debug('Tirage N°' . $i . ' : ' . $tirage . "\n");
		
		}
		
		// complément tiré dans les dictionnaires
		mdp_debug('Tirage de  ' . $complement . ' caractères divers' . "\n");
		
		for ($i = 0; $i < $complement; $i ++) {
		
			// On fait un tirage qui choisit le dictionnaire
			$d = mdp_chaine_tirage('0123');
			
			// On tire un caractère dans le dictionnaire
			$tirage = '';
			$tirage = mdp_chaine_tirage($dictionnaire[$d]);
			
			// On ajoute le tirage à la chaine
			$chaine .= $tirage;
			mdp_debug('Tirage N°' . $i . ' : ' . $tirage . "\n");
			
		}
		
		
		// mélange
		$melange = $chaine;
		mdp_debug('Mélange de  ' . $melange . ' en ' . $passes . ' passes' . "\n");
		
		// On mélange X fois la chaine produite
		for ($m = 0; $m < $passes; $m ++) {
		
			mdp_debug('Passe N°' . $m . "\n");
			$melange = mdp_chaine_melanger($melange);
		
		}
		
		$sortie = $melange;
	
	}
	
	// sortie
	return $sortie;

}


?>