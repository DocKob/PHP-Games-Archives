</div>
<?php
if ((isset($_SESSION[$shortTitle.'User']['level']))&&($_SESSION[$shortTitle.'User']['level']>=3)) $adminPanel=' | <a class="small" href="'.$location.'admin.php">'.$ui['adminPanel'].'</a>';
else $adminPanel='';
echo '<div class="footer">devana created by Andrei Busuioc<br /><a class="small" href="devanapedia.php?action=list&view=modules&faction=0">'.$ui['devanapedia'].'</a> | <a class="small" href="simulator.php">'.$ui['combatSimulator'].'</a> | <a class="small" href="'.$location.'terms.php">'.$ui['terms'].'</a> | <a class="small" href="'.$location.'credits.php">'.$ui['credits'].'</a> | <a class="small" href="'.$location.'contact.php">'.$ui['contact'].'</a>'.$adminPanel.'</div>';
if ($benchmark)
{
 $endTime=misc::microTime();
 echo '<div class="benchmark">'.ceil(($endTime-$startTime)*1000).' '.$ui['ms'].'</div>';
}
?>
</div>