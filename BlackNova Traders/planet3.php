<?
	include("config.php");
	updatecookie();

	$title=$l_planet3_title;
	include("header.php");
	connectdb();

	if (checklogin()) {die();}


	$result = $db->Execute ("SELECT * FROM $dbtables[ships] WHERE email='$username'");
	$playerinfo=$result->fields;

	$result2 = $db->Execute ("SELECT * FROM $dbtables[planets] WHERE planet_id=$planet_id");
	if($result2)

    $planetinfo=$result2->fields;


  bigtitle();
	if ($playerinfo[turns]<1)
	{
		echo "$l_trade_turnneed<BR><BR>";
    TEXT_GOTOMAIN();
		include("footer.php");
		die();
	}

if($planetinfo[sector_id] <> $playerinfo[sector])
{
   echo "$l_planet2_sector<BR><BR>";
   TEXT_GOTOMAIN();
   include("footer.php");
   die();
}
  if (empty($planetinfo))

  {

    echo "$l_planet_none<br>";

    TEXT_GOTOMAIN();

		include("footer.php");

		die();

  }


	$trade_ore=round(abs($trade_ore));
	$trade_organics=round(abs($trade_organics));
	$trade_goods=round(abs($trade_goods));
	$trade_energy=round(abs($trade_energy));
	$ore_price=($ore_price + $ore_delta/4);
	$organics_price=($organics_price + $organics_delta/4);
	$goods_price=($goods_price + $goods_delta/4);
	$energy_price=($energy_price + $energy_delta/4);

	if ($planetinfo[sells]=='Y')
	{
		$cargo_exchanged= $trade_ore + $trade_organics + $trade_goods;

		$free_holds=NUM_HOLDS($playerinfo[hull]) - $playerinfo[ship_ore] - $playerinfo[ship_organics] - $playerinfo[ship_goods] - $playerinfo[ship_colonists];
		$free_power=NUM_ENERGY($playerinfo[power]) - $playerinfo[ship_energy];
		$total_cost=($trade_ore*$ore_price) + ($trade_organics*$organics_price) + ($trade_goods*$goods_price) + ($trade_energy*$energy_price);

		if ($free_holds < $cargo_exchanged)
		{
			echo "$l_notenough_cargo  <a href=planet.php?planet_id=$planet_id>$l_clickme</a> $l_toplanetmenu<BR><BR>";
		} elseif ($trade_energy > $free_power) {
			echo "$l_notenough_power <a href=planet.php?planet_id=$planet_id>$l_clickme</a> $l_toplanetmenu<BR><BR>";
		} elseif ($playerinfo[turns]<1) {
			echo "$l_notenough_turns<BR><BR>";
		} elseif ($playerinfo[credits]<$total_cost) {
			echo "$l_notenough_credits<BR><BR>";
		} elseif ($trade_organics > $planetinfo[organics]){
			echo "$l_exceed_organics  ";
		} elseif ($trade_ore > $planetinfo[ore]){
			echo "$l_exceed_ore  ";
		} elseif ($trade_goods > $planetinfo[goods]){
			echo "$l_exceed_goods  ";
		} elseif ($trade_energy > $planetinfo[energy]){
			echo "$l_exceed_energy  ";
		} else {
			echo "$l_totalcost: $total_cost<BR>$l_traded_ore: $trade_ore<BR>$l_traded_organics: $trade_organics<BR>$l_traded_goods: $trade_goods<BR>$l_traded_energy: $trade_energy<BR><BR>";
			/* Update ship cargo, credits and turns */
			$trade_result = $db->Execute ("UPDATE $dbtables[ships] SET turns=turns-1, turns_used=turns_used+1, credits=credits-$total_cost, ship_ore=ship_ore+$trade_ore, ship_organics=ship_organics+$trade_organics, ship_goods=ship_goods+$trade_goods, ship_energy=ship_energy+$trade_energy where ship_id=$playerinfo[ship_id]");

			$trade_result2 = $db->Execute ("UPDATE $dbtables[planets] SET ore=ore-$trade_ore, organics=organics-$trade_organics, goods=goods-$trade_goods, energy=energy-$trade_energy, credits=credits+$total_cost WHERE planet_id=$planet_id");
			echo "$l_trade_complete<BR><BR>";
		}
	}

    gen_score($planetinfo[owner]);
    TEXT_GOTOMAIN();
	include("footer.php");

?>
