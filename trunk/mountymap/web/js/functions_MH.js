<!-- dissimulation du contenu du SCRIPT pour les anciens browsers

function openPopup(target, name) {
	window.open('http://games.mountyhall.com/mountyhall/View/' + target, name, 'width=750,height=550,toolbar=0,location=0,directories=0,status=0,menubar=0,resizable=0,scrollbars=1');
}

function EPV(IdCible){
	openPopup('PJView.php?ai_IDPJ='+IdCible, 'troll_view');
}

function EAV(IdCible){
	openPopup('AllianceView.php?ai_IDAlliance='+IdCible, 'guild_view');
}

function EMV(IdCible) {
	openPopup('MonsterView.php?ai_IDPJ='+IdCible, 'monster_view');
}
function ETV(IdCible) {
	openPopup('TresorHistory.php?ai_IDTresor='+IdCible, 'treasure_view');
}

function openConfirmationDialog(message) {
	return window.confirm(message);
}

// fin de dissimulation du contenu du SCRIPT pour les anciens browsers -->