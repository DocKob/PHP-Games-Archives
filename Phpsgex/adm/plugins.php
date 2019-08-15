<?php
require_once '../plugins/plugin.php';

$body="<table border='1'>";

$plugins= Plugin::GetAllPluginsNames();

foreach( $plugins as $pl ){
    $body.= "<tr> <td>$pl</td> </tr>";
}

$body.="</table>";