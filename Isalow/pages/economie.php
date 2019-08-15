<?php
$sql = "SELECT  habitation , abattoir , port , centrale , stockage , Misalox , Mor , Margent , Mfer , universite , stationradar , tourdefense , caserne , usine , nerv , soldat , elite , tank , artillerie , evangelion , partisans , clone , nourriture , electricite , isalox , ors , argent , fer , thabitation , tabattoir , tport , tcentrale , timpot , tisalox , tor , targent , tfer FROM is_user WHERE pseudo='".$pseudo."'";
$resultat_user = mysql_query($sql);
$t_user = mysql_fetch_array($resultat_user);

$errors = array(
1 => "La production ne peut exc&eacute;der 20% de celle de d&eacute;part",
2 => "la production ne peut &ecirc;tre n&eacute;gative",
3 => "La production ne peut &ecirc;tre modif&eacute;e lors d'une guerre civile",
99 => "action effectu&eacute;e avec succ&egrave;s"
);
if( isset($_GET['error']) )
{
	echo("<div align='center'>");
	echo($errors[$_GET['error']]);
	echo("</div><br>");
}
?>
<table width="670"  border="0" align="center" cellpadding="0" cellspacing="0" class="txt">
  <tr>
    <td width="450" class="table16px"><div align="center">Production par tour </div></td>
    <td width="220" class="table16px"><div align="center">Occupation des centres de stockages </div></td>
  </tr>
  <tr>
    <td width="450" class="table_ss">Production de cl&ocirc;nes: <font class="gris"><? echo($t_user['thabitation']); ?></font> cl&ocirc;nes.</td>
    <td width="220" class="table_ss"><? graphique($t_user['clone'],$race_caract['place_clone'],150,$t_user['habitation']); ?></td>
  </tr>
  <tr>
    <td width="450">Production des abattoirs: <font class="gris"><? echo($t_user['tabattoir']); ?></font> nourriture.</td>
    <td width="220" rowspan="2" class="table_ss"><? graphique($t_user['nourriture'],$race_caract['place_nourriture'],5000,$t_user['stockage']); ?></td>
  </tr>
  <tr>
    <td width="450" class="table_ss">Pisciculture: <font class="gris"><? echo($t_user['tport']); ?></font> nourriture.</td>
  </tr>
  <tr>
    <td width="450" class="table_ss">Production &eacute;lectrique: <font class="gris"><? echo($t_user['tcentrale']); ?></font> M&eacute;gawats.</td>
    <td width="220" class="table_ss"><? graphique($t_user['electricite'],$race_caract['place_electricite'],50,$t_user['centrale']); ?></td>
  </tr>
  <tr>
    <td width="450" class="table_ss">Imp&ocirc;ts: <font class="gris"><? echo($t_user['timpot']); ?></font> or.</td>
    <td width="220" class="table_ss">&nbsp;</td>
  </tr>
  <tr>
    <td width="450" class="table_ss">Production d'isalox: <font class="gris"><? echo($t_user['tisalox']); ?></font> minerai d'isalox.</td>
    <td width="220" class="table_ss"><? graphique($t_user['isalox'],$race_caract['place_isalox'],0,$t_user['stockage']); ?></td>
  </tr>
  <tr>
    <td width="450" class="table_ss">Production d'or: <font class="gris"><? echo($t_user['tor']); ?></font> minerai d'or.</td>
    <td width="220" class="table_ss"><? graphique($t_user['ors'],$race_caract['place_or'],500,$t_user['stockage']); ?></td>
  </tr>
  <tr>
    <td width="450" class="table_ss">Production d'argent: <font class="gris"><? echo($t_user['targent']); ?></font> minerai d'argent.</td>
    <td width="220" class="table_ss"><? graphique($t_user['argent'],$race_caract['place_argent'],1000,$t_user['stockage']); ?></td>
  </tr>
  <tr>
    <td width="450">Production de fer: <font class="gris"><? echo($t_user['tfer']); ?></font> minerai de fer.</td>
    <td width="220">      <? graphique($t_user['fer'],$race_caract['place_fer'],2000,$t_user['stockage']); ?>      </td>
  </tr>
  <tr>
    <td colspan="2" class="table16px"><div align="center">Agir sur les productions: </div></td>
  </tr>
  <tr>
    <td colspan="2"><form action="action/economie.php" method="get" name="production" id="production">
      <div align="left">1) 
          <select name="type" id="type">
            <option value="thabitation">Production de cl&ocirc;nes</option>
            <option value="tabattoir">Production des abattoirs</option>
            <option value="tport">Pisciculture</option>
            <option value="tcentrale">Production &eacute;lectrique</option>
            <option value="timpot">Imp&ocirc;ts</option>
            <option value="tisalox">Production d'isalox</option>
            <option value="tor">Production d'or</option>
            <option value="targent">Production d'argent</option>
            <option value="tfer">Production de fer</option>
          </select>
   2) 
   <select name="augmentation" size="2" id="augmentation">
            <option value="moins">- 2%</option>
            <option value="plus">+ 2%</option>
        </select> 
   3)
   <input type="submit" name="Submit" value="Envoyer mandat">
      </div>
    </form></td>
  </tr>
  <tr>
    <td colspan="2" class="table16px"><div align="center">Production r&eacute;elle par tour </div></td>
  </tr>
  <tr>
  <td colspan="2">
<?php
$clone = $t_user['habitation'] * $t_user['thabitation'];
$nourriture = ($t_user['abattoir'] * $t_user['tabattoir']) + ($t_user['port'] * $t_user['tport']);
$electricite = $t_user['centrale'] * $t_user['tcentrale'];
$isalox = $t_user['Misalox'] * $t_user['tisalox'];
$ors = ($t_user['Mor'] * $t_user['tor']) + ($t_user['clone'] * $t_user['timpot']);
$argent = $t_user['Margent'] * $t_user['targent'];
$fer = $t_user['Mfer'] * $t_user['tfer'];

$nourriture = ceil($nourriture - ($t_user['clone'] * $race_caract['clone_cout'] ));
$nourriture = ceil($nourriture - ( $t_user['soldat'] * $race_caract['soldat_cout'] ));
$nourriture = ceil($nourriture - ( $t_user['elite'] * $race_caract['elite_cout'] ));
$ors = ceil($ors - ( $t_user['tank'] * $race_caract['tank_cout'] ));
$ors = ceil($ors - ( $t_user['artillerie'] * $race_caract['artillerie_cout'] ));
$ors = ceil($ors - ( $t_user['evangelion'] * $race_caract['evangelion_cout'] ));
$electricite -= ($t_user['stockage'] + $t_user['universite'] + $t_user['tourdefense'] + $t_user['port'] + $t_user['habitation']);
$electricite -= ( 5 * ( $t_user['stationradar'] + $t_user['caserne'] + $t_user['usine'] ) );
$electricite -= ( 20 * $t_user['nerv'] );
?>
Cl&ocirc;nes: <font class="gris"><? echo($clone); ?></font><br>
Nourriture: <font class="gris"><? echo($nourriture); ?></font><br>
Electricit&eacute;: <font class="gris"><? echo($electricite); ?></font><br>
Isalox: <font class="gris"><? echo($isalox); ?></font><br>
Or: <font class="gris"><? echo($ors); ?></font><br>
Argent: <font class="gris"><? echo($argent); ?></font><br>
Fer: <font class="gris"><? echo($fer); ?></font>
</td>
  </tr>
</table>
<br>
<table width="670"  border="0" align="center" cellpadding="0" cellspacing="0" class="txt">
  <tr>
    <td class="table16px"><div align="center">Partisans</div></td>
  </tr>
  <tr>
    <td><p>Les partisans sont le pourcentage de votre population qui adh&egrave;re &agrave; votre politique &eacute;conomique. Les partisans repr&eacute;sentant votre population active, il est important d'en prendre compte. Si vous augmentez la production, ils devront travailler plus et un m&eacute;contentement peut en d&eacute;couler. Contrairement, si vous diminuez la production, vous obtiendrez plus de partisans. Si il reste peu de partisans, une guerre civile peut &eacute;clater.</p>
      <p>Partisans &agrave; votre cause&nbsp;: <? echo($t_user['partisans']); ?>%</p>
    </td>
  </tr>
</table>
