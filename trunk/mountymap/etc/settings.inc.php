<?php

require_once dirname(__FILE__).'/../lib/core.inc.php';

header('Content-type: text/html; charset=utf-8');

$monsters_templates = array(
	'Guerrier', 'Guerrière', 'Shaman', 'Scout', 'Malade', 'Voleur', 'Voleuse', 'Champion', 'Championne', 'Héros', 'Coriace',
	'Paysan', 'Paysanne', 'Barbare', 'Implacable', 'Archaïque', 'des Abysses', 'Agressif', 'Agressive','Effrayé', 'Effrayée',
	'Fou', 'Folle', 'de Premier Cercle', 'de Second Cercle', 'de Troisième Cercle', 'de Quatrième Cercle',  'de Cinquième Cercle',
	'Prince', 'Princesse', 'Corrompu', 'Corrompue', 'Sorcier', 'Sorcière', 'Mutant', 'Mutante', 'Sombre Prophète', 'Sombre Prophètesse',
	'Gardien', 'Gardienne',  'Grand Frondeur', 'Grande Frondeuse', 'Frondeur', 'Frondeuse', 'Alpha', 'Reine', 'Ouvrier', 'Ouvrière',
	'Soldat', 'Berserker', 'Berserkere', 'Vorace', 'Enragé', 'Enragée', 'Fanatique', 'Gargantuesque', 'Cracheur', 'Cracheuse',
	'Traqueur', 'Traqueuse', 'Mentat', 'Mentat', 'Colossal', 'Colossale', 'Pestiféré', 'Pestiférée', 'Maître', 'Maîtresse',
	'Guérisseur', 'Guérisseuse', 'Médicastre',  'Archiatre', 'Morticole', 'Attentionné', 'Attentionnée', 'Esculape', 'Fustigateur',
	'Fustigatrice', 'Lobotomisateur', 'Lobotomisatrice', 'Psychophage',  'Strident', 'Stridente', 'Frénétique', 'Cogneur', 'Cogneuse',
	'Nécromant', 'Nécromante', 'Invocateur', 'Invocatrice',
);

$monsters_sizes = array('Petit', 'Petite', 'Gros', 'Grosse',);

$places_types = array(
	'Sortie de Portail', 'Portail', 'Tanière de trõll', 'Tanière', 'Trou de Météorite',
	'Petite Lice', 'Grande Lice', 'Lice', 'Croisée des cavernes', 'Caverne',
	'Auberge', 'Agence', 'Armurerie', 'Boutique', 'Bureau', 'Cahute', 'Campement', 'Cocon', 'Couvoir', 
	'Forge', 'Gouffre', 'Gowapier d\'Elevage', 'Gowapier de Dressage', 'Grotte', 'Lac souterrain', 'Maléfacterie', 'Marabouterie', 'Minéroll',
	'Nid', 'Porte d\'Outre-Monde', 'Refuge', 'Rocher', 'Sanctuaire', 'Sépulcre', 'Source', 'Téléporteur', 'Terrier', 'Tombe',
);

define('MONSTERS_TEMPLATES', serialize($monsters_templates));
define('MONSTERS_SIZES', serialize($monsters_sizes));
define('PLACES_TYPES', serialize($places_types));
?>