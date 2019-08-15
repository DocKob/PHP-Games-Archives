<?php
/* --------------------------------------------------------------------------------------
                                      HIGHSCORES
   Credits         : phpSGEx by Aldrigo Raffaele
   Last modified by: Fhizban 09.06.2013
   Comments        : No changes
-------------------------------------------------------------------------------------- */

$opt = "usr";
if( isset($_GET['opt']) ) $opt = $_GET['opt'];

$body.="<input type='button' value='Users' onclick=\"location.href='?pg=highscores&opt=usr'\">
<input type='button' value='Ally' onclick=\"location.href='?pg=highscores&opt=ally'\"><br>";

if( $opt == "ally" ){
    $qris= $DB->query("select ally.*, sum(users.points) as allypoints from ".TB_PREFIX."ally join ".TB_PREFIX."users on (".TB_PREFIX."ally.id=".TB_PREFIX."users.ally_id) group by ".TB_PREFIX."users.ally_id order by allypoints asc");

    $body.="<h2 class='news-title'><span class='news-date'></span>".$lang['scr_highscore']." Ally</h2><div class='news-body'>
    <table width='300' border='1' cellspacing='10' cellpadding='1'>
    <tr><th>".$lang['scr_position']."</th> <th>Ally</th> <th>".$lang['prf_points']."</th></tr>";

    $i=1;
    while( $row= $qris->fetch_array() ){
        $body.="<tr><td> $i </td> <td><a href='?pg=ally&showally=".$row['id']."'>".$row['name']."</a></td> <td>".$row['allypoints']."</td></tr>";
        $i++;
    }

    $body.="</table>";
}
else if( $opt == "usr" ){
    $qris= $DB->query("SELECT ".TB_PREFIX."users.id, ".TB_PREFIX."users.rank, ".TB_PREFIX."users.username, ".TB_PREFIX."users.points, ".TB_PREFIX."ally.id as allyid, ".TB_PREFIX."ally.name as allyname FROM ".TB_PREFIX."users left outer join ".TB_PREFIX."ally on (".TB_PREFIX."users.ally_id=".TB_PREFIX."ally.id) ORDER BY `points` DESC");

    $body.="<h2 class='news-title'><span class='news-date'></span>".$lang['scr_highscore']." Users</h2><div class='news-body'>
    <table width='300' border='1' cellspacing='10' cellpadding='1'>
    <tr><th>".$lang['scr_position']."</th><th>".$lang['scr_username']."</th><th>Ally</th><th>".$lang['prf_points']."</th></tr>";

    //mostra utenti
    $i=1;
    while( $row= $qris->fetch_array() ) {
        $body.= "<tr><td> $i </td><td><a href='?pg=profile&usr=".$row['id']."'>".$row['username']."</a>";
        if( $row['rank'] >0 ) $body.=" <span class='Stile3'>[A]</span>";

        if( $row['allyid'] == null ) $body.="<th>N/A</th>";
        else $body .= "<th><a href='?pg=ally&showid=".$row['allyid']."'>".$row['allyname']."</a></th>";

        $body.="</td><td>".$row['points']."</td></tr>";
        $i++;
    }

    $body.="</table></div>";
} else $body="<h1>ERROR</h1>";
?>