<?php

/*

Fichier appellé lorsque on desire se deconnecter

*/

unset($_SESSION['idadmin12345678900']); // On detruit la session

unlink('cache/controlrow'); // On detruit le cache a la deconnexion, ce qui permet de recharger les modification au cas ou cela n'aurait pas été fait

die('<script>location="?mod=default"</script>'); // On recharche la page ce qui va ammener a la page de login


?>

