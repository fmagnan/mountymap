{assign var=guild value=$logged_in_user->getDiplomacyGuild()}
<div class="user_info">
	Utilisateur connecté : {$logged_in_user->getName()}<br />
	est administrateur ?  {$logged_in_user->isAdmin()}<br />
	diplomatie de la guilde {$guild->getName()} <br />
</div>