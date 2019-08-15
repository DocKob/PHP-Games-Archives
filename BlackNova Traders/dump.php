<?
	include("config.php");
	updatecookie();

  include("languages/$lang");
	$title=$l_dump_title;
	include("header.php");

	connectdb();

	if (checklogin()) {die();}

	$result = $db->Execute ("SELECT * FROM $dbtables[ships] WHERE email='$username'");
	$playerinfo=$result->fields;

	$result2 = $db->Execute("SELECT * FROM $dbtables[universe] WHERE sector_id=$playerinfo[sector]");
	$sectorinfo=$result2->fields;
        bigtitle();

	if ($playerinfo[turns]<1)
	{
		echo "$l_dump_turn<BR><BR>";
		TEXT_GOTOMAIN();
		include("footer.php");
		die();
	}
	if ($playerinfo[ship_colonists]==0)
	{
		echo "$l_dump_nocol<BR><BR>";
	} elseif ($sectorinfo[port_type]=="special") {
		$update = $db->Execute("UPDATE $dbtables[ships] SET ship_colonists=0, turns=turns-1, turns_used=turns_used+1 WHERE ship_id=$playerinfo[ship_id]");
		echo "$l_dump_dumped<BR><BR>";
	} else {
		echo "$l_dump_nono<BR><BR>";
	}
	TEXT_GOTOMAIN();
	include("footer.php");

?>
