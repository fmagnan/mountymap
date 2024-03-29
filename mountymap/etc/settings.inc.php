<?php

require_once dirname(__FILE__).'/../lib/core.inc.php';

getTime();

$monsters_data = array(
	'Abishaii Bleu' => array('level' => 15, 'see_invisible' => true, 'family' => 'Démon'),
	'Abishaii Noir' => array('level' => 9, 'see_invisible' => true, 'family' => 'Démon'),
	'Abishaii Rouge' => array('level' => 17, 'see_invisible' => true, 'family' => 'Démon'),
	'Abishaii Rose' => array('level' => 1, 'see_invisible' => false, 'family' => 'Démon'),
	'Abishaii Vert' => array('level' => 12, 'see_invisible' => true, 'family' => 'Démon'),
	'Ame-en-peine' => array('level' => 7, 'see_invisible' => true, 'family' => 'Mort-Vivant'),
	'Amibe Géante' => array('level' => 8, 'see_invisible' => false, 'family' => 'Monstre'),
	'Anaconda des Catacombes' => array('level' => 6, 'see_invisible' => false, 'family' => 'Monstre'),
	'Ankheg' => array('level' => 10, 'see_invisible' => false, 'family' => 'Insecte'),
	'Anoploure Purpurin' => array('level' => 24, 'see_invisible' => false, 'family' => 'Insecte'),
	'Aragnarok du Chaos' => array('level' => 16, 'see_invisible' => true, 'family' => 'Insecte'),
	'Araignée Géante' => array('level' => 2, 'see_invisible' => false, 'family' => 'Insecte'),
	'Ashashin' => array('level' => 21, 'see_invisible' => false, 'family' => 'Humanoide'),
	'Balrog' => array('level' => 50, 'see_invisible' => true, 'family' => 'Démon'),
	'Banshee' => array('level' => 15, 'see_invisible' => true, 'family' => 'Mort-Vivant'),
	'Barghest' => array('level' => 24, 'see_invisible' => true, 'family' => 'Démon'),
	'Basilisk' => array('level' => 11, 'see_invisible' => false, 'family' => 'Monstre'),
	'Behemoth' => array('level' => 25, 'see_invisible' => true, 'family' => 'Démon'),
	'Behir' => array('level' => 13, 'see_invisible' => false, 'family' => 'Monstre'),
	'Beholder' => array('level' => 50, 'see_invisible' => true, 'family' => 'Monstre'),
	'Blob Acide' => array('level' => 19, 'see_invisible' => true, 'family' => 'Démon'),
	'Boggart' => array('level' => 3, 'see_invisible' => false, 'family' => 'Humanoide'),
	'Bondin' => array('level' => 8, 'see_invisible' => false, 'family' => 'Monstre'),
	'Bouj\'Dla' => array('level' => 13, 'see_invisible' => false, 'family' => 'Monstre'),
	'Bouj\'Dla Placide' => array('level' => 23, 'see_invisible' => true, 'family' => 'Monstre'),
	'Bulette' => array('level' => 14, 'see_invisible' => false, 'family' => 'Monstre'),
	'Caillouteux' => array('level' => 2, 'see_invisible' => false, 'family' => 'Humanoide'),
	'Capitan' => array('level' => 24, 'see_invisible' => false, 'family' => 'Mort-Vivant'),
	'Carnosaure' => array('level' => 16, 'see_invisible' => false, 'family' => 'Monstre'),
	'Champi-Glouton' => array('level' => 4, 'see_invisible' => true, 'family' => 'Humanoide'),
	'Chauve-Souris Géante' => array('level' => 2, 'see_invisible' => true, 'family' => 'Animal'),
	'Cheval à Dents de Sabre' => array('level' => 18, 'see_invisible' => false, 'family' => 'Animal'),
	'Chevalier du Chaos' => array('level' => 22, 'see_invisible' => true, 'family' => 'Démon'),
	'Chimère' => array('level' => 11, 'see_invisible' => true, 'family' => 'Monstre'),
	'Chonchon' => array('level' => 20, 'see_invisible' => false, 'family' => 'Monstre'),
	'Coccicruelle' => array('level' => 16, 'see_invisible' => false, 'family' => 'Insecte'),
	'Cockatrice' => array('level' => 5, 'see_invisible' => false, 'family' => 'Monstre'),
	'Collet Optaire' => array('level' => 14, 'see_invisible' => true, 'family' => 'Insecte'),
	'Crasc' => array('level' => 10, 'see_invisible' => false, 'family' => 'Monstre'),
	'Crasc Maexus' => array('level' => 25, 'see_invisible' => false, 'family' => 'Monstre'),
	'Crasc Médius' => array('level' => 17, 'see_invisible' => false, 'family' => 'Monstre'),
	'Croquemitaine' => array('level' => 6, 'see_invisible' => false, 'family' => 'Mort-Vivant'),
	'Cube Gélatineux' => array('level' => 21, 'see_invisible' => false, 'family' => 'Monstre'),
	'Daemonite' => array('level' => 19, 'see_invisible' => true, 'family' => 'Démon'),
	'Diablotin' => array('level' => 1, 'see_invisible' => true, 'family' => 'Démon'),
	'Dindon' => array('level' => -4, 'see_invisible' => false, 'family' => 'Animal'),
	'Dindon du Chaos' => array('level' => -4, 'see_invisible' => false, 'family' => 'Animal'),
	'Dindon Du Feu' => array('level' => -4, 'see_invisible' => false, 'family' => 'Animal'),
	'Dindon Du Glacier' => array('level' => -4, 'see_invisible' => false, 'family' => 'Animal'),
	'Dindon du Glouglou' => array('level' => -4, 'see_invisible' => false, 'family' => 'Animal'),
	'Dindon Du Hum' => array('level' => -4, 'see_invisible' => false, 'family' => 'Animal'),
	'Dindon Du Manger' => array('level' => -4, 'see_invisible' => false, 'family' => 'Animal'),
	'Dindon Effrayé' => array('level' => -4, 'see_invisible' => false, 'family' => 'Animal'),
	'Djinn' => array('level' => 21, 'see_invisible' => false, 'family' => 'Monstre'),
	'Ectoplasme' => array('level' => 15, 'see_invisible' => true, 'family' => 'Mort-Vivant'),
	'Effrit' => array('level' => 22, 'see_invisible' => true, 'family' => 'Monstre'),
	'Elémentaire d\'Air' => array('level' => 18, 'see_invisible' => true, 'family' => 'Démon'),
	'Elémentaire d\'Eau' => array('level' => 14, 'see_invisible' => false, 'family' => 'Démon'),
	'Elémentaire de Feu' => array('level' => 17, 'see_invisible' => false, 'family' => 'Démon'),
	'Elémentaire de Terre' => array('level' => 19, 'see_invisible' => false, 'family' => 'Démon'),
	'Elémentaire du Chaos' => array('level' => 17, 'see_invisible' => false, 'family' => 'Démon'),
	'Erinyes' => array('level' => 8, 'see_invisible' => true, 'family' => 'Démon'),
	'Esprit-Follet' => array('level' => 15, 'see_invisible' => false, 'family' => 'Monstre'),
	'Esprit du Gnu Vengeur' => array('level' => 1, 'see_invisible' => false, 'family' => 'Mort-Vivant'),
	'Essaim Cratérien' => array('level' => 25, 'see_invisible' => true, 'family' => 'Insecte'),
	'Essaim Sanguinaire' => array('level' => 18, 'see_invisible' => true, 'family' => 'Insecte'),
	'Ettin' => array('level' => 10, 'see_invisible' => false, 'family' => 'Humanoide'),
	'Familier' => array('level' => 1, 'see_invisible' => false, 'family' => 'Monstre'),
	'Fantôme' => array('level' => 19, 'see_invisible' => true, 'family' => 'Mort-Vivant'),
	'Flagelleur Mental' => array('level' => 24, 'see_invisible' => false, 'family' => 'Humanoide'),
	'Feu Follet' => array('level' => 16, 'see_invisible' => false, 'family' => 'Monstre'),
	'Foudroyeur' => array('level' => 23, 'see_invisible' => false, 'family' => 'Insecte'),
	'Fumeux' => array('level' => 17, 'see_invisible' => true, 'family' => 'Démon'),
	'Fungus Géant' => array('level' => 6, 'see_invisible' => true, 'family' => 'Monstre'),
	'Fungus Violet' => array('level' => 3, 'see_invisible' => true, 'family' => 'Monstre'),
	'Furgolin' => array('level' => 9, 'see_invisible' => false, 'family' => 'Humanoide'),
	'Gargouille' => array('level' => 5, 'see_invisible' => false, 'family' => 'Monstre'),
	'Géant de Pierre' => array('level' => 14, 'see_invisible' => false, 'family' => 'Humanoide'),
	'Géant des Gouffres' => array('level' => 18, 'see_invisible' => false, 'family' => 'Humanoide'),
	'Glouton' => array('level' => 15, 'see_invisible' => false, 'family' => 'Animal'),
	'Gnoll' => array('level' => 3, 'see_invisible' => false, 'family' => 'Humanoide'),
	'Gnu Sauvage' => array('level' => 1, 'see_invisible' => true, 'family' => 'Animal'),
	'Gobelin Magique' => array('level' => 1, 'see_invisible' => false, 'family' => 'Humanoide'),
	'Goblin' => array('level' => 1, 'see_invisible' => false, 'family' => 'Humanoide'),
	'Goblours' => array('level' => 4, 'see_invisible' => false, 'family' => 'Humanoide'),
	'Golem d\'Argile' => array('level' => 14, 'see_invisible' => false, 'family' => 'Humanoide'),
	'Golem de Bois' => array('level' => 9, 'see_invisible' => false, 'family' => 'Humanoide'),
	'Golem de Chair' => array('level' => 9, 'see_invisible' => false, 'family' => 'Humanoide'),
	'Golem de Fer' => array('level' => 24, 'see_invisible' => false, 'family' => 'Humanoide'),
	'Golem de Pierre' => array('level' => 19, 'see_invisible' => false, 'family' => 'Humanoide'),
	'Gorgone' => array('level' => 11, 'see_invisible' => false, 'family' => 'Monstre'),
	'Goule' => array('level' => 4, 'see_invisible' => true, 'family' => 'Mort-Vivant'),
	'Gowap Apprivoisé' => array('level' => -3, 'see_invisible' => false, 'family' => 'Animal'),
	'Gowap Sauvage' => array('level' => 1, 'see_invisible' => false, 'family' => 'Animal'),
	'Gremlins' => array('level' => 3, 'see_invisible' => false, 'family' => 'Humanoide'),
	'Gritche' => array('level' => 25, 'see_invisible' => true, 'family' => 'Démon'),
	'Grouilleux' => array('level' => 2, 'see_invisible' => false, 'family' => 'Monstre'),
	'Grylle' => array('level' => 20, 'see_invisible' => false, 'family' => 'Monstre'),
	'Harpie' => array('level' => 4, 'see_invisible' => false, 'family' => 'Monstre'),
	'Hellrot' => array('level' => 15, 'see_invisible' => true, 'family' => 'Démon'),
	'Homme-Lézard' => array('level' => 4, 'see_invisible' => false, 'family' => 'Humanoide'),
	'Hurleur' => array('level' => 8, 'see_invisible' => false, 'family' => 'Humanoide'),
	'Hydre' => array('level' => 50, 'see_invisible' => false, 'family' => 'Monstre'),
	'Incube' => array('level' => 10, 'see_invisible' => true, 'family' => 'Démon'),
	'Kilamo et La Mouche' => array('level' => 1, 'see_invisible' => false, 'family' => 'Monstre'),
	'Kobold' => array('level' => 1, 'see_invisible' => false, 'family' => 'Humanoide'),
	'Labeilleux' => array('level' => 20, 'see_invisible' => false, 'family' => 'Insecte'),
	'Lapin Blanc' => array('level' => 21, 'see_invisible' => true, 'family' => 'Animal'),
	'Lapin de Pähäk Furax' => array('level' => 21, 'see_invisible' => true, 'family' => 'Animal'),
	'Les Yeux' => array('level' => 52, 'see_invisible' => true, 'family' => 'Démon'),
	'Lézard Géant' => array('level' => 5, 'see_invisible' => false, 'family' => 'Monstre'),
	'Liche' => array('level' => 50, 'see_invisible' => true, 'family' => 'Mort-Vivant'),
	'Limace Géante' => array('level' => 9, 'see_invisible' => false, 'family' => 'Insecte'),
	'Loup-Garou' => array('level' => 8, 'see_invisible' => false, 'family' => 'Humanoide'),
	'Lutin' => array('level' => 2, 'see_invisible' => false, 'family' => 'Humanoide'),
	'Lutin du Père N\'hoyël' => array('level' => 1, 'see_invisible' => false, 'family' => 'Humanoide'),
	'Mante Fulcreuse' => array('level' => 22, 'see_invisible' => false, 'family' => 'Insecte'),
	'Manticore' => array('level' => 7, 'see_invisible' => false, 'family' => 'Monstre'),
	'Marilith' => array('level' => 22, 'see_invisible' => true, 'family' => 'Démon'),
	'Méduse' => array('level' => 6, 'see_invisible' => false, 'family' => 'Humanoide'),
	'Mégacéphale' => array('level' => 25, 'see_invisible' => false, 'family' => 'Humanoide'),
	'Mille-Pattes Géant' => array('level' => 12, 'see_invisible' => false, 'family' => 'Insecte'),
	'Mimique' => array('level' => 7, 'see_invisible' => false, 'family' => 'Monstre'),
	'Minotaure' => array('level' => 6, 'see_invisible' => false, 'family' => 'Humanoide'),
	'Molosse Satanique' => array('level' => 7, 'see_invisible' => true, 'family' => 'Démon'),
	'Momie' => array('level' => 4, 'see_invisible' => true, 'family' => 'Mort-Vivant'),
	'Monstre Rouilleur' => array('level' => 4, 'see_invisible' => false, 'family' => 'Monstre'),
	'Mouch\'oo Sauvage' => array('level' => 12, 'see_invisible' => false, 'family' => 'Monstre'),
	'Mouch\'oo Majestueux Sauvage' => array('level' => 21, 'see_invisible' => false, 'family' => 'Monstre'),
	'Naga' => array('level' => 9, 'see_invisible' => false, 'family' => 'Monstre'),
	'Nâ-Hàniym-Hééé' => array('level' => -6, 'see_invisible' => false, 'family' => 'Mort-Vivant'),
	'Nécrochore' => array('level' => 25, 'see_invisible' => true, 'family' => 'Mort-Vivant'),
	'Nécromant' => array('level' => 25, 'see_invisible' => true, 'family' => 'Mort-Vivant'),
	'Nécrophage' => array('level' => 7, 'see_invisible' => false, 'family' => 'Mort-Vivant'),
	'Nuage d\'Insectes' => array('level' => 5, 'see_invisible' => false, 'family' => 'Insecte'),
	'Nuée de Vermine' => array('level' => 10, 'see_invisible' => false, 'family' => 'Insecte'),
	'Ombre' => array('level' => 2, 'see_invisible' => true, 'family' => 'Mort-Vivant'),
	'Ombre de Roches' => array('level' => 12, 'see_invisible' => true, 'family' => 'Monstre'),
	'Ogre' => array('level' => 6, 'see_invisible' => false, 'family' => 'Humanoide'),
	'Orque' => array('level' => 3, 'see_invisible' => false, 'family' => 'Humanoide'),
	'Ours-Garou' => array('level' => 13, 'see_invisible' => false, 'family' => 'Humanoide'),
	'Palefroi Infernal' => array('level' => 20, 'see_invisible' => true, 'family' => 'Démon'),
	'Père N\'hoyël Furax' => array('level' => 1, 'see_invisible' => false, 'family' => 'Humanoide'),
	'Phoenix' => array('level' => 23, 'see_invisible' => false, 'family' => 'Monstre'),	//('Phoenix' => array('level' => 25, 'see_invisible' => true, 'family' => 'Monstre'),
	'Pititabeille' => array('level' => -5, 'see_invisible' => true, 'family' => 'Insecte'),
	'Plante Carnivore' => array('level' => 4, 'see_invisible' => true, 'family' => 'Monstre'),
	'Pseudo-Dragon' => array('level' => 1, 'see_invisible' => false, 'family' => 'Démon'),
	'Rat-Garou' => array('level' => 3, 'see_invisible' => false, 'family' => 'Humanoide'),
	'Rat Géant' => array('level' => 1, 'see_invisible' => false, 'family' => 'Animal'),
	'Rocketeux' => array('level' => 6, 'see_invisible' => false, 'family' => 'Humanoide'),
	'Sagouin' => array('level' => 3, 'see_invisible' => false, 'family' => 'Animal'),
	'Scarabée Géant' => array('level' => 5, 'see_invisible' => false, 'family' => 'Insecte'),
	'Scorpion Géant' => array('level' => 10, 'see_invisible' => false, 'family' => 'Insecte'),
	'Shai' => array('level' => 16, 'see_invisible' => true, 'family' => 'Démon'),
	'Shàû\'Kõ Bàhnàné' => array('level' => 23, 'see_invisible' => true, 'Délire'),
	'Slaad' => array('level' => 5, 'see_invisible' => false, 'family' => 'Monstre'),
	'Sorcière' => array('level' => 15, 'see_invisible' => true, 'family' => 'Humanoide'),
	'Spectre' => array('level' => 13, 'see_invisible' => false, 'family' => 'Mort-Vivant'),
	'Sphinx' => array('level' => 23, 'see_invisible' => true, 'family' => 'Humanoide'),
	'Squelette' => array('level' => 1, 'see_invisible' => true, 'family' => 'Mort-Vivant'),
	'Strige' => array('level' => 1, 'see_invisible' => false, 'family' => 'Insecte'),
	'Super Bouffon en Chasse' => array('level' => -5, 'see_invisible' => true, 'family' => 'Troll'),
	'Super Bouffon, Gardien des Arcanes' => array('level' => -5, 'see_invisible' => true, 'family' => 'Troll'),
	'Succube' => array('level' => 10, 'see_invisible' => true, 'family' => 'Démon'),
	'Tempête de Givre' => array('level' => 1, 'see_invisible' => false, 'family' => 'Monstre'),
	'Tertre Errant' => array('level' => 19, 'see_invisible' => true, 'family' => 'Monstre'),
	'Thri-kreen' => array('level' => 8, 'see_invisible' => false, 'family' => 'Insecte'),
	'Tigre-Garou' => array('level' => 9, 'see_invisible' => false, 'family' => 'Humanoide'),
	'Titan' => array('level' => 20, 'see_invisible' => false, 'family' => 'Humanoide'),
	'Trancheur' => array('level' => 21, 'see_invisible' => false, 'family' => 'Monstre'),
	'Troll Noir' => array('level' => 0, 'see_invisible' => false, 'family' => 'Humanoide'),
	'Tubercule Tueur' => array('level' => 11, 'see_invisible' => true, 'family' => 'Animal'),
	'Tutoki' => array('level' => 2, 'see_invisible' => false, 'family' => 'Monstre'),
	'TyranOeil' => array('level' => 0, 'see_invisible' => true, 'family' => 'Monstre'),
	'Vampire' => array('level' => 22, 'see_invisible' => true, 'family' => 'Mort-Vivant'),
	'Ver Carnivore Géant' => array('level' => 13, 'see_invisible' => false, 'family' => 'Monstre'),
	'Veskan du Chaos' => array('level' => 14, 'see_invisible' => false, 'family' => 'Humanoide'),
	'Vouivre' => array('level' => 23, 'see_invisible' => false, 'family' => 'Monstre'),
	'Worg' => array('level' => 5, 'see_invisible' => false, 'family' => 'Monstre'),
	'Xorn' => array('level' => 11, 'see_invisible' => false, 'family' => 'Démon'),
	'Yaquinquin Qué Nunnainemiiiii' => array('level' => 1, 'see_invisible' => true, 'family' => 'Monstre'),
	'Yéti' => array('level' => 7, 'see_invisible' => false, 'family' => 'Humanoide'),
	'Yuan-ti' => array('level' => 12, 'see_invisible' => false, 'family' => 'Humanoide'),
	'Zombie' => array('level' => 2, 'see_invisible' => true, 'family' => 'Mort-Vivant'),
);

$giant_female_monsters = array('Amibe', 'Araignée', 'Chauve-Souris', 'Limace',);
$giant_male_monsters = array('Lézard', 'Milles-Pattes', 'Rat', 'Scarabée', 'Scorpion', 'Ver Carnivore',);

$monsters_templates = array(
	'Agressif' => 1, 'Agressive' => 1,
	'Alpha' => 11,
	'Archaïque' => -1,
	'Archiatre' => 2,
	'Attentionné' => 2, 'Attentionnée' => 2,
	'Barbare' => 1,
	'Berserker' => 2, 'Berserkere' => 2,
	'Champion' => 4, 'Championne' => 4,
	'Cogneur' => 2, 'Cogneuse' => 2,
	'Colossal' => 7, 'Colossale' => 7,
	'Coriace' => 1,
	'Corrompu' => 1, 'Corrompue' => 1,
	'Cracheur' => 2, 'Cracheuse' => 2,
	'de Premier Cercle' => -1,
	'de Second Cercle' => 0,
	'de Troisième Cercle' => 2,
	'de Quatrième Cercle' => 4,
	'de Cinquième Cercle' => 5,
	'des Abysses' => 3,
	'Effrayé' => -1, 'Effrayée' => -1,
	'Enragé' => 3, 'Enragée' => 3,
	'Esculape' => 2,
	'Fanatique' => 2,
	'Fou' => 1, 'Folle' => 1,
	'Frénétique' => 3,
	'Fustigateur' => 2, 'Fustigatrice' => 2,
	'Gardien' => 20, 'Gardienne' => 20,
	'Gargantuesque' => 3,
	'Grand Frondeur' => 4, 'Frondeur' => 2, 'Grande Frondeuse' => 4, 'Frondeuse' => 2,
	'Gros' => 0,
	'Guérisseur' => 2, 'Guérisseuse' => 2,
	'Guerrier' => 1, 'Guerrière' => 1,
	'Héros' => 5,
	'Implacable' => 3,
	'Invocateur' => 5, 'Invocatrice' => 5,
	'Lobotomisateur' => 2, 'Lobotomisatrice' => 2,
	'Maître' => 8, 'Maîtresse' => 8,
	'Malade' => -1,
	'Médicastre' => 2,
	'Mentat' => 2,
	'Morticole' => 2,
	'Mutant' => 2, 'Mutante' => 2,
	'Nécromant' => 5, 'Nécromante' => 5,
	'Ouvrier' => 0, 'Ouvrière' => 0,
	'Paysan' => -1, 'Paysanne' => -1,
	'Pestiféré' => 0, 'Pestiférée' => 0,
	'Petit' => -1,
	'Prince' => 8, 'Princesse' => 8,
	'Psychophage' => 2,
	'Reine' => 11,
	'Scout' => 2,
	'Shaman' => 0,
	'Soldat' => 2,
	'Sombre Prophète' => 1, 'Sombre Prophètesse' => 1,
	'Strident' => 3, 'Stridente' => 3,
	'Traqueur' => 1, 'Traqueuse' => 1,
	'Vorace' => 1,
	'Voleur' => 2, 'Voleuse' => 2,
	'Sorcier' => 0, 'Sorcière' => 0,
);

$monsters_sizes = array('Petit' => -1, 'Petite' => -1, 'Gros' => 1, 'Grosse' => 1);

$monsters_ages = array(
	'Accompli' => 6,
	'Accomplie' => 6,
	'Achevé' => 7,
	'Achevée' => 7,
	'Adulte' => array('Humanoide' => 1, 'Monstre' => 2, 'Animal' => 3),
	'Ancestral' => 6,
	'Ancêtre' => 7,
	'Ancien' => array('Mort-Vivant' => 2, 'Animal' => 6),
	'Antédiluvien' => 7,
	'Antique' => 5,
	'Bébé' => 0,
	'Briscard' => 4,
	'Chef de harde' => 5,
	'Développé' => 4,
	'Développée' => 4,
	'Doyen' => 5,
	'Doyenne' => 5,
	'Enfançon' => 1,
	'Favori' => 3,
	'Favorite' => 3,
	'Imago' => 3,
	'Immature' => 1,
	'Initial' => 0,
	'Initiale' => 0,
	'Jeune' => array('Humanoide' => 1, 'Monstre'=> 1, 'Animal' => 2),
	'Juvénile' => 2,
	'Larve' => 0,
	'Légendaire' => 6,
	'Majeur' => 4,
	'Majeure' => 4,
	'Mature' => 4,
	'Mineur' => 2,
	'Mineure' => 2,
	'Mûr' => 5,
	'Mûre' => 5,
	'Mythique' => 7,
	'Naissant' => 0,
	'Naissante' => 0,
	'Nouveau' => 0,
	'Nouvelle' => 0,
	'Novice' => 1,
	'Récent' => 1,
	'Séculaire' => 4,
	'Supérieur' => 5,
	'Supérieure' => 5,
	'Suprême' => 6,
	'Ultime' => 7,
	'Vénérable' => 3,
	'Vétéran' => 3,
);

$places_types = array(
	'Sortie de Portail', 'Portail', 'Tanière de trõll', 'Tanière', 'Trou de Météorite',
	'Petite Lice', 'Grande Lice', 'Lice', 'Croisée des cavernes', 'Caverne',
	'Auberge', 'Agence', 'Armurerie', 'Boutique', 'Bureau', 'Cahute', 'Campement', 'Cocon', 'Couvoir', 
	'Forge', 'Gouffre', 'Gowapier d\'Elevage', 'Gowapier de Dressage', 'Grotte', 'Lac souterrain', 'Maléfacterie', 'Marabouterie', 'Minéroll',
	'Nid', 'Porte d\'Outre-Monde', 'Refuge', 'Rocher', 'Sanctuaire', 'Sépulcre', 'Source', 'Téléporteur', 'Terrier', 'Tombe',
);

$trolls_races = array('Durakuir', 'Kastar', 'Skrim', 'Tomawak');

define('MONSTERS_DATA', serialize($monsters_data));
define('GIANT_FEMALE_MONSTERS', serialize($giant_female_monsters));
define('GIANT_MALE_MONSTERS', serialize($giant_male_monsters));
define('MONSTERS_TEMPLATES', serialize($monsters_templates));
define('MONSTERS_SIZES', serialize($monsters_sizes));
define('PLACES_TYPES', serialize($places_types));
define('MONSTERS_AGES', serialize($monsters_ages));
define('TROLLS_RACES', serialize($trolls_races));

$unprotected_scripts = array(
	'/login.php', '/register.php', '/forgot_password.php', '/update_public_data.php',
);

$menu_items = array(
	'/search.php' => array('title' => 'recherche', 'admin' => false),
	'/members.php' => array('title' => 'membres', 'admin' => false),
	'/preferences.php' => array('title' => 'options', 'admin' => false),
	'/map.php' => array('title' => 'carte', 'admin' => false),
	'/users.php' => array('title' => 'utilisateurs', 'admin' => true),
	'/logout.php' => array('title' => 'quitter', 'admin' => false),
);
define('MENU_ITEMS', serialize($menu_items));

header('Content-type: text/html; charset=utf-8');

session_start();
if (!array_key_exists('logged_user_id', $_SESSION) && !in_array($_SERVER['PHP_SELF'], $unprotected_scripts)) {
	header("Location: login.php");
	exit();
}

if (array_key_exists($script = $_SERVER['SCRIPT_NAME'], $menu_items) && $menu_items[$script]['admin'] && !getLoggedInUser()->isAdmin()) {
	header("Location: index.php");
	exit();
}

?>