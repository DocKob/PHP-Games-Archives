<?

  if (preg_match("/sched_apocalypse.php/i", $PHP_SELF)) {
      echo "You can not access this file directly!";
      die();
  }

  echo "<B>PLANETARY APOCALYPSE</B><BR><BR>";
  echo "The four horsemen of the apocalypse set forth...<BR>";
  $doomsday = $db->Execute("SELECT * from $dbtables[planets] WHERE colonists > $doomsday_value");
  $chance = 9;
  $reccount = $doomsday->RecordCount();
  if($reccount > 200) $chance = 7; // increase chance it will happen if we have lots of planets meeting the criteria 
  $affliction = rand(1,$chance); // the chance something bad will happen
  if($doomsday && $affliction < 3 && $reccount > 0)
  {
     $i=1;
     $targetnum=rand(1,$reccount);
     while (!$doomsday->EOF)
     {
        if ($i==$targetnum)
        {
           $targetinfo=$doomsday->fields;
           break;
        }
        $i++;
        $doomsday->MoveNext();
     }
     if($affliction == 1) // Space Plague
     {
        echo "The horsmen release the Space Plague!<BR>.";
        $db->Execute("UPDATE $dbtables[planets] SET colonists = ROUND(colonists-colonists*$space_plague_kills) WHERE planet_id = $targetinfo[planet_id]");
        $logpercent = ROUND($space_plague_kills * 100);
        playerlog($targetinfo[owner],LOG_SPACE_PLAGUE,"$targetinfo[name]|$targetinfo[sector_id]|$logpercent"); 
     }
     else
     {
        echo "The horsemen release a Plasma Storm!<BR>.";
        $db->Execute("UPDATE $dbtables[planets] SET energy = 0 WHERE planet_id = $targetinfo[planet_id]");
        playerlog($targetinfo[owner],LOG_PLASMA_STORM,"$targetinfo[name]|$targetinfo[sector_id]");
     } 
  }
  echo "<BR>";

?>
