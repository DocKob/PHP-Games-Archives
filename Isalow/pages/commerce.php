<?php
$isalox = $marche[0];
$ors = $marche[1];
$argent = $marche[2];
$fer = $marche[3];
$nourriture = $marche[4];
$clone = $marche[5];
$electricite = $marche[6];
?>
		<br>
		<table width="670" align="center" cellpadding="0" cellspacing="0" class="txt">
              <form name="echange" method="post" action="action/marche.php">
                <tr>
                  <td class="table16px">Marché / Echanges</td>
                </tr>
                <tr>
                  <td valign="top"> <div align="center">
                      <p>
                        <input name="montant" type="text" id="montant">
                        <select name="ressource" id="ressource">
                          <option value="0" selected>Isalox 
                          <option value="1">Or 
                          <option value="2">Argent 
                          <option value="3">Fer 
                          <option value="4">Nourriture
                          <option value="5">Clone
                          <option value="6">Electricité
                        </select>
                        Contre
                        <select name="echange" id="echange">
                          <option value="0" selected>Isalox 
                          <option value="1">Or 
                          <option value="2">Argent 
                          <option value="3">Fer 
                          <option value="4">Nourriture
                          <option value="5">Clone
                          <option value="6">Electricité
                        </select>
                        <input type="submit" name="submit" value="Echanger">
                      </p>
                    </div>
                  </td>
                </tr>
              </form>
              <tr>
                <td class="table16px">Valeurs</td>
              </tr>
              <tr>
                <td valign="top"><br>
                  <table align="center" class="txt">
                    <tr>
                      <td width="80">&nbsp;</td>
                      <td width="80"><div align="center">Isalox</div></td>
                      <td width="80"><div align="center">Or</div></td>
                      <td width="80"><div align="center">Argent</div></td>
                      <td width="80"><div align="center">Fer</div></td>
                      <td width="80"><div align="center">Electricité</div></td>
                      <td width="80"><div align="center">Nourriture</div></td>
                      <td width="80"><div align="center">Clone</div></td>
                    </tr>
                    <tr>
                      <td width="80"><div align="right">Isalox</div></td>
                      <td width="80"><div align="center"><?= $isalox['0'] ?></div></td>
                      <td width="80"><div align="center"><?= $isalox['1'] ?></div></td>
                      <td width="80"><div align="center"><?= $isalox['2'] ?></div></td>
                      <td width="80"><div align="center"><?= $isalox['3'] ?></div></td>
                      <td width="80"><div align="center"><?= $isalox['6'] ?></div></td>
                      <td width="80"><div align="center"><?= $isalox['4'] ?></div></td>
                      <td width="80"><div align="center"><?= $isalox['5'] ?></div></td>
                    </tr>
                    <tr>
                      <td width="80"><div align="right">Or</div></td>
                      <td width="80"><div align="center"><?= $ors['0'] ?></div></td>
                      <td width="80"><div align="center"><?= $ors['1'] ?></div></td>
                      <td width="80"><div align="center"><?= $ors['2'] ?></div></td>
                      <td width="80"><div align="center"><?= $ors['3'] ?></div></td>
                      <td width="80"><div align="center"><?= $ors['6'] ?></div></td>
                      <td width="80"><div align="center"><?= $ors['4'] ?></div></td>
                      <td width="80"><div align="center"><?= $ors['5'] ?></div></td>
                    </tr>
                    <tr>
                      <td width="80"><div align="right">Argent</div></td>
                      <td width="80"><div align="center"><?= $argent['0'] ?></div></td>
                      <td width="80"><div align="center"><?= $argent['1'] ?></div></td>
                      <td width="80"><div align="center"><?= $argent['2'] ?></div></td>
                      <td width="80"><div align="center"><?= $argent['3'] ?></div></td>
                      <td width="80"><div align="center"><?= $argent['6'] ?></div></td>
                      <td width="80"><div align="center"><?= $argent['4'] ?></div></td>
                      <td width="80"><div align="center"><?= $argent['5'] ?></div></td>
                    </tr>
                    <tr>
                      <td width="80"><div align="right">Fer</div></td>
                      <td width="80"><div align="center"><?= $fer['0'] ?></div></td>
                      <td width="80"><div align="center"><?= $fer['1'] ?></div></td>
                      <td width="80"><div align="center"><?= $fer['2'] ?></div></td>
                      <td width="80"><div align="center"><?= $fer['3'] ?></div></td>
                      <td width="80"><div align="center"><?= $fer['6'] ?></div></td>
                      <td width="80"><div align="center"><?= $fer['4'] ?></div></td>
                      <td width="80"><div align="center"><?= $fer['5'] ?></div></td>
                    </tr>
                    <tr>
                      <td width="80"><div align="right">Electricité</div></td>
                      <td width="80"><div align="center"><?= $electricite['0'] ?></div></td>
                      <td width="80"><div align="center"><?= $electricite['1'] ?></div></td>
                      <td width="80"><div align="center"><?= $electricite['2'] ?></div></td>
                      <td width="80"><div align="center"><?= $electricite['3'] ?></div></td>
                      <td width="80"><div align="center"><?= $electricite['6'] ?></div></td>
                      <td width="80"><div align="center"><?= $electricite['4'] ?></div></td>
                      <td width="80"><div align="center"><?= $electricite['5'] ?></div></td>
                    </tr>
                    <tr>
                      <td width="80"><div align="right">Nourriture</div></td>
                      <td width="80"><div align="center"><?= $nourriture['0'] ?></div></td>
                      <td width="80"><div align="center"><?= $nourriture['1'] ?></div></td>
                      <td width="80"><div align="center"><?= $nourriture['2'] ?></div></td>
                      <td width="80"><div align="center"><?= $nourriture['3'] ?></div></td>
                      <td width="80"><div align="center"><?= $nourriture['6'] ?></div></td>
                      <td width="80"><div align="center"><?= $nourriture['4'] ?></div></td>
                      <td width="80"><div align="center"><?= $nourriture['5'] ?></div></td>
                    </tr>
                    <tr>
                      <td width="80"><div align="right">Clone</div></td>
                      <td width="80"><div align="center"><?= $clone['0'] ?></div></td>
                      <td width="80"><div align="center"><?= $clone['1'] ?></div></td>
                      <td width="80"><div align="center"><?= $clone['2'] ?></div></td>
                      <td width="80"><div align="center"><?= $clone['3'] ?></div></td>
                      <td width="80"><div align="center"><?= $clone['6'] ?></div></td>
                      <td width="80"><div align="center"><?= $clone['4'] ?></div></td>
                      <td width="80"><div align="center"><?= $clone['5'] ?></div></td>
                    </tr>
                  </table>
                  <br></td>
              </tr>
</table>
        <br>
        <table width="670" align="center" cellpadding="0" cellspacing="0" class="txt">
              <form name="commerce" method="post" action="action/commerce_vente.php">
                <tr>
                  <td class="table16px">Mise sur le marché </td>
                </tr>
                <tr><td>
                  <div>
                      <p align="center">
                        <input name="montant" type="text" id="montant" style="width:100">
                        de
                        <select name="ressource" id="ressource" style="width:100">
                          <option value="0" selected>Isalox 
                          <option value="1">Or 
                          <option value="2">Argent 
                          <option value="3">Fer 
                          <option value="4">Nourriture
                          <option value="5">Clône
                          <option value="6">Electricité
                        </select>
                        au prix de
                        <input name="valeur" type="text" id="valeur" style="width:30"> 
                        /unité de 
                        <select name="echange" id="echange" style="width:100">
                          <option value="0" selected>Isalox 
                          <option value="1">Or 
                          <option value="2">Argent 
                          <option value="3">Fer 
                          <option value="4">Nourriture
                          <option value="5">Clône
                          <option value="6">Electricité
                        </select>
                        <select name="confrerie" size="1" id="confrerie" style="width:100">
                          <option value="1">in-confrérie</option>
                          <option value="0">hors-confrérie</option>
                        </select>
                        <input name="Submit" type="submit" id="Submit" value="Mettre sur le marché" style="width:670">
                        <br>
                    </p>
                  </div></td>
                </tr>
              </form>
</table>
<br>
<table width="670" border="0" cellspacing="0" cellpadding="0" class="txt" align="center">
<tr>
<td class="table16px" width="70">&nbsp;</td>
<td class="table16px" width="225"><div align="center">Echange</div></td>
<td class="table16px" width="70"><div align="center">Taux</div></td>
<td class="table16px" width="225"><div align="center">Contre</div></td>
<td class="table16px" width="100"><div align="center">De</div></td>
<td class="table16px" width="60">&nbsp;</td>
</tr>
<?php
$ressourceTrad = array(
	0 => "isalox",
	1 => "ors",
	2 => "argent",
	3 => "fer",
	4 => "nourriture",
	5 => "clone",
	6 => "electricite"
	);

$sql = "SELECT id,pseudo,alliance,montant,valeur,echange,ressource FROM is_commerce WHERE alliance='0' OR alliance='".$alliance."' ORDER BY alliance , pseudo ASC";
$resultat_commerce = mysql_query($sql);
$inConfrerie = true;
while( $t_commerce = mysql_fetch_array($resultat_commerce) )
{
$sql = "SELECT pseudo,sexe FROM is_user WHERE pseudo = '".$pseudo."'";
$resultat_user = mysql_query($sql);
$t_user = mysql_fetch_array($resultat_user);

	if( $t_commerce['alliance'] != 0 && $inConfrerie)
	{
		echo('<tr><td colspan="6" class="table16px"><div align="center">In-Confrérie</div></td></tr>');
		$inConfrerie = false;
	}
	echo('<tr>');
	if( $t_commerce['pseudo'] == $pseudo || $t_user['sexe'] == 'z')
	{
		echo('<td class="table_ss"><a href="action/commerce_annule.php?id='.$t_commerce['id'].'"><div align="right">[ Effacer ]</div></a></td>');
	}
	if( $t_commerce['pseudo'] != $pseudo )
	{
		echo('<td class="table_ss">&nbsp;</td>');
	}
	echo('<td class="table_ss"><div align="center">'.$t_commerce['montant'].' '.$ressourceTrad[ $t_commerce['ressource'] ].'</div></td>');
	echo('<td class="table_ss"><div align="center">'.$t_commerce['valeur'].'</div></td>');
	echo('<td class="table_ss"><div align="center">'.($t_commerce['montant']*$t_commerce['valeur']).' '.$ressourceTrad[ $t_commerce['echange'] ].'</div></td>');
	echo('<td class="table_ss"><div align="center">'.$t_commerce['pseudo'].'</div></td>');
	echo('<td class="table_ss"><a href="action/commerce_achat.php?id='.$t_commerce['id'].'"><div align="right">[ Acheté ]</div></a></td>');
	echo('</tr>');
}
mysql_free_result($resultat_user);
unset($t_user);
?>
</table>