<?php

// Si la constante n'est pas defini on bloque l'execution du fichier
if(!defined('PHPSIMUL_PAGES') || @PHPSIMUL_PAGES != 'PHPSIMULLL') 
{
die('Erreur 404 - Le fichier n\'a pas été trouvé');
}

/* PHPsimul : Créez votre jeu de simulation en PHP
Copyright (©) - 2007 - CAPARROS Sébastien (Camaris)

Codeur officiel: Camaris & Max485
http://forum.epic-arena.fr

*/

$sFOOTER  = <<<EOF
<div id="divBack"><a href="?mod=sql&action=backup">{$LANG['GO_SCRIPT_INDEX']}</a><br /><br /></div>
<div id="divCopyrights">
Mod d'origine: Xt-Dump - <a href="http://www.dreaxteam.net" target="_blank">http://www.dreaxteam.net</a><br />
Adapté pour Mod Admin de PHPSimul par Max485
</div>
</div>
</body>
</html>
EOF;

?>
