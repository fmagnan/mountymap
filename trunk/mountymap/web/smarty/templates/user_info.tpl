{assign var=guild value=$logged_user->getDiplomacyGuild()}
<div class="user_info">
	Utilisateur connecté : {$logged_user->getName()}<br />
	est administrateur ?  {$logged_user->isAdmin()}<br />
	diplomatie de la guilde {$guild->getName()} <br />
</div>