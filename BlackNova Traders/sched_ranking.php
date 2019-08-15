<?

  if (preg_match("/sched_ranking.php/i", $PHP_SELF)) {
      echo "You can not access this file directly!";
      die();
  }

  echo "<B>RANKING</B><BR><BR>";
  $res = $db->Execute("SELECT ship_id FROM $dbtables[ships] WHERE ship_destroyed='N'");
  while(!$res->EOF)
  {
    gen_score($res->fields[ship_id]);
    $res->MoveNext();
  }
  echo "<BR>";
  $multiplier = 0;

?>
