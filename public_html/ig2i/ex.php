<?php

function exemple1()
{
	// exercice : produire un rectangle bleu sur fond rouge

	$im = imagecreate(100, 50);
	// Avec imagecreate, la première couleur allouée est la couleur de fond
	$rouge = imagecolorallocate($im, 255, 0, 0);
	$bleu = imagecolorallocate($im, 0, 0, 255);
	imagefilledrectangle($im, 25, 10, 75, 40, $bleu);
	imagepng($im);
	imagedestroy($im);
}

function texte1($texte)
{
	$im = imagecreate(100, 50);		
	$blanc = imagecolorallocate($im, 255, 255, 255); 
	$noir = imagecolorallocate($im, 255,0,0);
	
	// TODO : utiliser d'autres polices téléchargées sur 1001 free fonts
	// TODO : Utiliser $font = "chemin complet du fichier de police"; 
	// 			si ça ne fonctionne pas sous windows
	// chemin physique de la page courante
	// die(__FILE__);

	putenv('GDFONTPATH=' . realpath('./ressources/polices'));
	$font = "./ressources/polices/orange juice 2.0.ttf";

	imagettftext($im, 30, 0, 0, 30, $noir, $font, $texte);

	imagepng($im);
	imagedestroy($im);
}


function echiquier($case)
{
	$im = imagecreate($case*8, $case*8);

	$c[0] = imagecolorallocate($im, 255, 255, 255);	//blanc
	$c[1] = imagecolorallocate($im, 0,0,0); //noir

	$col=0;

	/*
	bool imagefilledrectangle ( resource $image , int $x1 , int $y1 , int $x2 , int $y2 , int $color ) 
	Dessine un rectangle de couleur color dans l'image image, 
	en commençant par le sommet supérieur gauche (1) et finissant au sommet inférieur droit (2). 
	Le coin supérieur gauche est l'origine (0, 0). 
	x1 X : coordonné du point 1. 
	y1 Y : coordonné du point 1. 
	x2 X : coordonné du point 2. 
	y2 Y : coordonné du point 2. 
	*/
	
	// On commence aux coordonnées 0,0 par une case blanche
	for($i=0;$i<8;$i++)	// col <=> abs
	{
		for($j=0;$j<8;$j++)
		{
			$x1 = $case * $i; // TODO : x,y sont des fonctions de $i,$j et $case
			$y1 = $case * $j;
			$x2 = $case * ($i + 1) - 1; 
			$y2 = $case * ($j + 1) - 1;  
			imagefilledrectangle($im,$x1,$y1,$x2,$y2,$c[$col]);
			$col = 1-$col;	// la couleur à utiliser : $c[$col]
		}
		$col = 1-$col;
	}

	imagepng($im);
	imagedestroy($im);
}

function arc()
{

	// exercice : produire un arc plein

	$im = imagecreatetruecolor(200,200);	
	// avec imagecreatetruecolor, le fond est noir par défaut 
	imagecolortransparent($im, 0);			// le fond noir devient transparent

	$noir = imagecolorallocate($im, 1,1,1); //noir

	/*
	imagefilledarc ( resource $image , int $cx , int $cy , int $width , int $height 
						, int $start , int $end , int $color , int $style ) 
		cx, cy : centre 
		width, height : largeur et hauteur 
		start, end : angles de départ et d'arrivée 
		style : Un champ d'octets, combiné avec l'opérateur OR : 
		IMG_ARC_PIE IMG_ARC_CHORD IMG_ARC_NOFILL IMG_ARC_EDGED 

	IMG_ARC_PIE et IMG_ARC_CHORD sont mutuellement exclusives; 
	IMG_ARC_CHORD ne fait que connecter les angles de début et de fin avec une ligne droite, 
		tandis que IMG_ARC_PIE produit une ligne courbe. 
	IMG_ARC_NOFILL indique que l'arc (ou corde) doit être dessiné mais pas rempli. 
	IMG_ARC_EDGED, utilisé conjointement avec IMG_ARC_NOFILL, 
		indique que les angles de début et de fin doivent être connectés au centre. 
		Cette fonction est recommandée pour faire les graphiques de type camembert. 
	*/

	imagefilledarc ($im , 100,100 , 200 , 200 , 0 , 50 , $noir ,
						IMG_ARC_PIE | IMG_ARC_EDGED);			
	
	imagepng($im);
	imagedestroy($im);
}

function camembert($tabData)
{
	// Trace un camembert de diamètre 200 pixels centré dans l'image
	$im = imagecreate(240,240);
	$blanc = imagecolorallocate($im, 255, 255, 255);
	$noir = imagecolorallocate($im, 0, 0, 0);
	
	// 1) calculer la somme des valeurs du tableau 
	$somme = array_sum($tabData);

	$lastAngle = 0; 
	// angle de fin de l'arc précédent = angle de début de l'arc suivant
	
	// 2) parcourir le tableau (sauf sa dernière case)
	// * calculer l'amplitude $amp de l'arc correspondant à la valeur courante
	// * tracer l'arc correspondant à cet angle entre l'angle précédent et l'angle précédent + $amp
	// * mettre à jour la valeur de l'angle précédent
	for ($i = 0 ; $i < sizeof($tabData) ; $i++) {
	  $amp = 360 * $tabData[$i] / $somme;
	  if ($i == sizeof($tabData) - 1) {
	    $amp = 360 - $lastAngle;
	  }
	  imagefilledarc ($im, 120, 120, 200, 200, $lastAngle, $lastAngle + $amp, $noir,
						IMG_ARC_PIE | IMG_ARC_NOFILL | IMG_ARC_EDGED);	
		$lastAngle += $amp;
	}

	// 3) Tracer l'arc de cercle du dernier secteur
	//    (cf. cas particulier dans la boucle)
	
	imagepng($im);
	imagedestroy($im);	
}


function camembertAvecLegende($tabData)
{
	putenv('GDFONTPATH=' . realpath('./ressources/polices'));
	$font = "./ressources/polices/Action Man.ttf";

	$im = imagecreatetruecolor(400,240);
	imagecolortransparent($im, 0); // Fond transparent

	$blanc = imagecolorallocate($im, 255, 255, 255);
	$noir = imagecolorallocate($im, 1, 1, 1);	

	$taille = count($tabData);
	
	// 0) on génère autant de couleurs qu'il y a de valeurs dans le tableau
	// Les couleurs sont générées en partant de (0,0,0)
	// a chaque nouvelle couleur on ajoutera 255/$taille à chaque composante
	$couleurs = array();
	for ($i = 0 ; $i < $taille ; $i++) {
	  $couleurs[$i] = imagecolorallocate($im, $i*255/$taille + 1, $i*255/$taille + 1, $i*255/$taille + 1);
	}

	// 1) calculer la somme des valeurs du tableau 
	$somme = 0;
	for ($i = 0 ; $i < sizeof($tabData) ; $i++) {
	  $somme += $tabData[$i]["nb"];
	}

	$lastAngle =0; 
	// angle de fin de l'arc précédent = angle de début de l'arc suivant
	
	// 2) parcourir le tableau (sauf sa dernière case)
	// * calculer l'amplitude $amp de l'arc correspondant à la valeur courante
	// * tracer l'arc correspondant à cet angle entre l'angle précédent et l'angle précédent + $amp
	// 		cet arc est un arc plein rempli d'une des couleurs générées plus haut
	// * placer le carré correspondant à la légende de cet arc, placer le texte à côté
	// * mettre à jour la valeur de l'angle précédent
	for ($i = 0 ; $i < sizeof($tabData) ; $i++) {
	  $amp = 360 * $tabData[$i]["nb"] / $somme;
	  if ($i == sizeof($tabData) - 1) {
	    $amp = 360 - $lastAngle;
	  }
	  imagefilledarc($im, 120, 120, 200, 200, $lastAngle, $lastAngle + $amp, $couleurs[$i], IMG_ARC_PIE);	
		$lastAngle += $amp;
		
		// Légende
		$eVL = 30;  // écart Vertical Légende
		$cCL = 20;  // coté Carré Légende
		imagefilledrectangle($im, 240, ($eVL + $cCL)*$i + $eVL, 260, ($eVL + $cCL)*$i + $eVL + $cCL, $couleurs[$i]);
		imagettftext($im, 20, 0, 270, ($eVL + $cCL)*$i + $eVL + $cCL, $noir, $font, $tabData[$i]["label"]);
	}
	
	// 3) Tracer l'arc de cercle du dernier secteur
	//    (cf. cas particulier dans la boucle)
	
	imagepng($im);
	imagedestroy($im);	
}


function miniature($type,$nom,$dw,$nomMin)
{
	// Crée une miniature de l'image $nom de largeur $dw
	// et l'enregistre dans le fichier $nomMin 

	// lecture de l'image d'origine, enregistrement dans la zone mémoire $im
	switch($type)
	{
		case "jpeg" : $im =  imagecreatefromjpeg ($nom);break;
		case "png" : $im =  imagecreatefrompng ($nom);break;
		case "gif" : $im =  imagecreatefromgif ($nom);break;		
	}

	// On connait la dimension en largeur de la nouvelle image
	// dw = destination width

	$sw = imagesx($im); // largeur de l'image d'origine
	$sh = imagesy($im); // hauteur de l'image d'origine
	// TODO : calculer $dh
	$dh = $sh * $dw / $sw;

	$im2 = imagecreatetruecolor($dw, $dh);
	
	/*
	imagecopyresized ($im2, $im, $dst_x , $dst_y  , $src_x  , $src_y  , $dst_w  , $dst_h  , $src_w  , $src_h);
	
	imagecopyresized() extrait une forme rectangulaire de src_image 
	d'une largeur de src_w et d'une hauteur src_h  
	à la position (src_x,src_y) 
	et la place dans une zone rectangulaire de dst_image  
	d'une largeur de dst_w et d'une hauteur de dst_h à la position (dst_x,dst_y).
	$im = image source
	$im2 = image destination 
	 
	*/

	$dst_x= 0;
	$dst_y= 0;
	$src_x= 0; 
	$src_y= 0; 
	$dst_w= $dw ; 
	$dst_h= $dh ; 
	$src_w= $sw ; 
	$src_h= $sh ;
	
	imagecopyresized ($im2,$im,$dst_x , $dst_y  , $src_x  , $src_y  , $dst_w  , $dst_h  , $src_w  , $src_h);
	
	
	switch($type)
	{
		case "jpeg" : imagejpeg($im2,$nomMin);imagejpeg($im2);break;
		case "png" : imagepng($im2,$nomMin);imagepng($im2);break;
		case "gif" : imagegif($im2,$nomMin);imagegif($im2);break;		
	}

	imagedestroy($im);
	imagedestroy($im2);
}


function incrustation($typeCible, $nomCible, $typeSource, $nomSource, $dw, $dx, $dy, $nomMin)
{
	// Insère l'image source au point (dx,dy) dans l'image cible
	// L'image insérée sera redimensionnée pour avoir une largeur de $dw

	// lecture de l'image cible, enregistrement dans la zone mémoire $im
	switch($typeCible)
	{
		case "jpeg" : $imCible =  imagecreatefromjpeg ($nomCible);break;
		case "png" : $imCible =  imagecreatefrompng ($nomCible);break;
		case "gif" : $imCible =  imagecreatefromgif ($nomCible);break;		
	}

	// lecture de l'image source, enregistrement dans la zone mémoire $im
	switch($typeSource)
	{
		case "jpeg" : $imSource =  imagecreatefromjpeg ($nomSource);break;
		case "png" : $imSource =  imagecreatefrompng ($nomSource);break;
		case "gif" : $imSource =  imagecreatefromgif ($nomSource);break;		
	}

	// On connait la dimension en largeur de l'image à incruster
	// dw = destination width

	$sw = imagesx($imSource); // largeur de l'image d'origine
	$sh = imagesy($imSource); // hauteur de l'image d'origine
	// TODO : calculer $dh	
	$dh = $sh * $dw / $sw;

	$src_x= 0; 		// image à incruster
	$src_y= 0; 
	$src_w= $sw; 
	$src_h= $sh;

	$dst_x= $dx;
	$dst_y= $dy;
	$dst_w= $dw; 
	$dst_h= $dh; 

	imagecopyresized ($imCible, $imSource, $dst_x , $dst_y  , $src_x  , $src_y  , $dst_w  , $dst_h  , $src_w  , $src_h);
	
	
	switch($typeCible)
	{
		case "jpeg" : imagejpeg($imCible,$nomMin);imagejpeg($imCible);break;
		case "png" : imagepng($imCible,$nomMin);imagepng($imCible);break;
		case "gif" : imagegif($imCible,$nomMin);imagegif($imCible);break;		
	}

	imagedestroy($imCible);
	imagedestroy($imSource);
}


function incrustation_logo($typeCible, $nomCible, $typeSource, $nomSource, $nomMin)
{

	// On souhaite insérer un logo situé dans le dernier quart droit de l'image, 
	// à 10% des bords du dernier quart à gauche et à droite (image mode paysage)
	// ou à 10% des bords du dernier quart en haut et en bas (image mode portrait)

	// lecture de l'image cible, enregistrement dans la zone mémoire $im
	switch($typeCible)
	{
		case "jpeg" : $imCible =  imagecreatefromjpeg ($nomCible);break;
		case "png" : $imCible =  imagecreatefrompng ($nomCible);break;
		case "gif" : $imCible =  imagecreatefromgif ($nomCible);break;		
	}

	// lecture de l'image source, enregistrement dans la zone mémoire $im
	switch($typeSource)
	{
		case "jpeg" : $imSource =  imagecreatefromjpeg ($nomSource);break;
		case "png" : $imSource =  imagecreatefrompng ($nomSource);break;
		case "gif" : $imSource =  imagecreatefromgif ($nomSource);break;		
	}

	$sw = imagesx($imSource); // largeur de l'image d'origine servant de logo
	$sh = imagesy($imSource); // hauteur de l'image d'origine servant de logo
	$lw = imagesx($imCible); // largeur de l'image dans laquelle insérer le logo
	$lh = imagesy($imCible); // hauteur de l'image dans laquelle insérer le logo

	$dh = 0;	// future taille du logo
	$dw = 0; // future taille du logo

	$src_x= 0; 		// image à incruster
	$src_y= 0; 
	$src_w= 0; 
	$src_h= 0;

	$dst_x= 0;
	$dst_y= 0;
	$dst_w= 0; 
	$dst_h= 0; 

	imagecopyresized ($imCible, $imSource, $dst_x , $dst_y  , $src_x  , $src_y  , $dst_w  , $dst_h  , $src_w  , $src_h);
	
	
	switch($typeCible)
	{
		case "jpeg" : imagejpeg($imCible,$nomMin);imagejpeg($imCible);break;
		case "png" : imagepng($imCible,$nomMin);imagepng($imCible);break;
		case "gif" : imagegif($imCible,$nomMin);imagegif($imCible);break;		
	}

	imagedestroy($imCible);
	imagedestroy($imSource);
}



function copyright($type,$nom,$texte)
{
	switch($type)
	{
		case "jpeg" : $im =  imagecreatefromjpeg ($nom);break;
		case "png" : $im =  imagecreatefrompng ($nom);break;
		case "gif" : $im =  imagecreatefromgif ($nom);break;		
	}

	// Utiliser imagecolorallocatealpha pour définir une couleur semi-transparente
	$noir = imagecolorallocatealpha($im, 255,255,255,80); 
	
	putenv('GDFONTPATH=' . realpath('./ressources/polices'));
	$font = "./ressources/polices/kartoons.ttf";
	// TODO : indiquer le chemin complet de la police si ça ne fonctionne pas... 

	/*
	imageftbbox() retourne un tableau contenant 8 éléments 
		représentant les 4 points du rectangle entourant le texte : 
	0 Coin en bas, à gauche, position en X
	1 Coin en bas, à gauche, position en Y
	2 Coin en bas, à droite, position en X
	3 Coin en bas, à droite, position en Y
	4 Coin en haut, à droite, position en X
	5 Coin en haut, à droite, position en Y
	6 Coin en haut, à gauche, position en X
	7 Coin en haut, à gauche, position en Y
	*/

	// A compléter : on souhaite afficher le texte centré sur l'image, pour qu'il prenne 80% de la largeur de l'image
	// à l'aide de la fonction imagettftext

	// 1) récupérer la taille (hauteur,largeur) de l'image où écrire
	// 2) calculer la largeur du texte à produire (80% de la taille de l'image)
	// 3) calculer la largeur d'un texte en police 10 
		// utiliser le tableau imageftbbox
	// 4) en déduire la taille de police à utiliser pour obtenir le texte final 
	// 5) calculer la taille (hauteur, largeur) de ce texte dans cette taille de police  
	// 6) en déduire la position du point BAS, GAUCHE du premier caractère 
	//		du texte pour qu'il soit centré dans l'image
	// 7) Afficher le texte dans l'image, en utilisant un texte semi-transparent  (cf. canal alpha d'une couleur)

	switch($type)
	{
		case "jpeg" :  imagejpeg($im);break;
		case "png" : imagepng($im);break;
		case "gif" : imagegif($im);break;		
	}
	imagedestroy($im);
}

function copyright_logo($type,$cheminImageSrc,$texte="", $logo=false, $cheminImgCible) {
	// a compléter, prévoir le cas où le texte ou le logo est absent
}


//  champ debug pour faciliter le débuggage
if (!isset($_GET["debug"]))
	header("Content-type: image/jpeg");

// Nom : 
// Prenom : 

// A chaque exercice résolu, déposer votre travail sur le serveur et appeler l'enseignant

	//exemple1();	// tester l'exemple du cours 
	//texte1("hello");	// changer la police de caractères en utilisant une police téléchargée sur 1001 free fonts 
	//echiquier(75);		// dessiner un échiquier
	//arc();						// dessiner un arc plein 
	//camembert(array(10,50,30));		// dessiner un camembert 
	$data[]=array("nb"=>10,"label"=>"France");
	$data[]=array("nb"=>50,"label"=>"Bresil");
	$data[]=array("nb"=>30,"label"=>"Argentine");
	//camembertAvecLegende($data); // dessiner un camembert et sa légende
	
	// produire une miniature de largeur donnée d'une image
	//miniature("jpeg","ressources/images/villa.jpeg",500,"villa2.jpeg");

	// insérer une image dans une autre en indiquant sa taille et sa position 
	incrustation("jpeg","ressources/images/armand.jpeg","jpeg","ressources/images/villa.jpeg",200,50,50,"armandVilla.jpeg");

	// insérer une image dans une autre de manière esthétique
	// TODO: passer coin choisi en paramètre
	//incrustation_logo("jpeg","ressources/images/villa.jpeg","jpeg","ressources/images/isig.jpeg","isigVilla.jpeg");

	// insérer un texte centré de 80% de la taille d'une image
	//copyright("jpeg","ressources/images/villa.jpeg","Applications Multimédia\npour le Web");

	// insérer un texte et un logo dans une image 
	// copyright_logo("jpeg","ressources/images/villa.jpeg","Applications Multimédia\npour le Web", "ressources/images/isig.jpeg");

	// TODO : passer param pour chemin de l'image à enregistrer

	// TODO: sélecteur d'exercice, fonction de rechargement de page pour éviter recherche dans barre d'adresse

?>
