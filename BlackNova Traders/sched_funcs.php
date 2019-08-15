<?

if (preg_match("/sched_funcs.php/i", $PHP_SELF)) {
    echo "You can not access this file directly!";
    die();
}

function QUERYOK($res)
{
  if($res)
  {
    echo " ok.<BR>";
  }
  else
  {
    die(" FAILED.");
  }
}

function get_player_name($userid)
{
  global $db, $dbtables;

  $query = $db->Execute("select character_name from $dbtables[ships] where ship_id='$userid'");
  $name = $query->fields;

  return $name[character_name];
}

?>