{assign var=guild value=$logged_in_user->getDiplomacyGuild()}
<fieldset class="user_info">
	<legend>Infos utilisateur</legend>
	Utilisateur connecté : {$logged_in_user->getName()}<br />
	est administrateur ?  {$logged_in_user->isAdmin()}<br />
	diplomatie de la guilde {$guild->getName()} <br />
</fieldset>