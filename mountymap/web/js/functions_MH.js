function openPopup(url, nomPopup, options) {
	var options = options + ',height=550,toolbar=0,location=0,directories=0,status=0,menubar=0,resizable=0,scrollbars=1';
	window.open(url, nomPopup, options);
}

function EnterPJView(IdCible){
	openPopup('http://games.mountyhall.com/mountyhall/View/PJView.php?ai_IDPJ='+IdCible, 'profilTroll', 'width=750');
}

function EnterAllianceView(IdCible){
	openPopup('http://games.mountyhall.com/mountyhall/View/AllianceView.php?ai_IDAlliance='+IdCible, 'profilGuilde', 'width=750');
}

function ouvreFicheTroll(url, mode) {
	if (mode == 'popup') {
		openPopup(url, 'ficheTroll', 'top=100,left=100,width=400');
	}
	else {
		window.location.href=url;
	}
}

function majRecherche(url, mode) {
	if (mode == 'popup') {
		window.opener.location.href=url;
	}
	else {
		window.location.href=url;
	}

}

function openConfirmationDialog(message) {
	return window.confirm(message);
}