<?php
//$Id: new2.php 47 2006-01-19 02:55:27Z phpfixer $
include("config.php");
//ADDDED these variables for future reference- we'll move em to config values
//*eventually* - the goal will be to move "start up" config values to some other location
//where we will only include them where needed- why include em every page load, when they are used maybe 1% of the time?
$start_lssd = 'N';  //do ships start with an lssd ?
$start_editors = 0;//starting warp editors
$start_minedeflectors = 0;//start mine deflectors
$start_emerwarp = 0; //start emergency warp units
$start_beacon = 0; //start space_beacons
$start_genesis = 0; //starting genesis torps
$escape = 'N';  //start game equip[[ped with escape pod?]]
$scoop = 'N';  //start game equipped with fuel scoop?
include("languages/$lang");

$title=$l_new_title2;

include("header.php");


bigtitle();

connectdb();

if($account_creation_closed)
{
  die($l_new_closed_message);
}
$character=htmlspecialchars($character);
$shipname=htmlspecialchars($shipname);
$character=ereg_replace("[^[:digit:][:space:][:alpha:][\']]"," ",$character);
$shipname=ereg_replace("[^[:digit:][:space:][:alpha:][\']]"," ",$shipname);

//$username = $HTTP_POST_VARS['username']; //This needs to STAY before the db query

if(!get_magic_quotes_gpc())
{
  $username = addslashes($username);
  $character = addslashes($character);
  $shipname = addslashes($shipname);
}


$result = $db->Execute ("select email, character_name, ship_name from $dbtables[ships] where email='$username' OR character_name='$character' OR ship_name='$shipname'");
$flag=0;
if ($username=='' || $character=='' || $shipname=='' ) { echo "$l_new_blank<BR>"; $flag=1;}

if ($result>0)
{
  while (!$result->EOF)
  {
    $row = $result->fields;
    if (strtolower($row[email])==strtolower($username)) { echo "$l_new_inuse  $l_new_4gotpw1 <a href=mail.php?mail=$username>$l_clickme</a> $l_new_4gotpw2<BR>"; $flag=1;}
    if (strtolower($row[character_name])==strtolower($character)) { echo "$l_new_inusechar<BR>"; $flag=1;}
    if (strtolower($row[ship_name])==strtolower($shipname)) { echo "$l_new_inuseship<BR>"; $flag=1;}
    $result->MoveNext();
  }
}

if ($flag==0)
{

  /* insert code to add player to database */
  $makepass="";
  $syllables="er,in,tia,wol,fe,pre,vet,jo,nes,al,len,son,cha,ir,ler,bo,ok,tio,nar,sim,ple,bla,ten,toe,cho,co,lat,spe,ak,er,po,co,lor,pen,cil,li,ght,wh,at,the,he,ck,is,mam,bo,no,fi,ve,any,way,pol,iti,cs,ra,dio,sou,rce,sea,rch,pa,per,com,bo,sp,eak,st,fi,rst,gr,oup,boy,ea,gle,tr,ail,bi,ble,brb,pri,dee,kay,en,be,se";
  $syllable_array=explode(",", $syllables);
  srand((double)microtime()*1000000);
  for ($count=1;$count<=4;$count++) {
    if (rand()%10 == 1) {
      $makepass .= sprintf("%0.0f",(rand()%50)+1);
    } else {
      $makepass .= sprintf("%s",$syllable_array[rand()%62]);
    }
  }
  $stamp=date("Y-m-d H:i:s");
  $query = $db->Execute("SELECT MAX(turns_used + turns) AS mturns FROM $dbtables[ships]");
  $res = $query->fields;

  $mturns = $res[mturns];

  if($mturns > $max_turns)
    $mturns = $max_turns;

  $result2 = $db->Execute("INSERT INTO $dbtables[ships] (ship_name,ship_destroyed,character_name,password,email,armor_pts,credits,ship_energy,ship_fighters,turns,on_planet,dev_warpedit,dev_genesis,dev_beacon,dev_emerwarp,dev_escapepod,dev_fuelscoop,dev_minedeflector,last_login,interface,ip_address,trade_colonists,trade_fighters,trade_torps,trade_energy,cleared_defences,lang,dhtml,dev_lssd)
 VALUES ('$shipname','N','$character','$makepass','$username',$start_armor,$start_credits,$start_energy,$start_fighters,$mturns,'N',$start_editors,$start_genesis,$start_beacon,$start_emerwarp,'$escape','$scoop',$start_minedeflectors,'$stamp','N','$ip','Y','N','N','Y',NULL,'$default_lang', 'Y','$start_lssd')");
  if(!$result2) {
    echo $db->ErrorMsg() . "<br>";
  } else {
    $result2 = $db->Execute("SELECT ship_id FROM $dbtables[ships] WHERE email='$username'");
    $shipid = $result2->fields;
//TODO build a bit better "new player" message , perhaps..
 $l_new_message = str_replace("[pass]", $makepass, $l_new_message);
$link_to_game = "http://";
$link_to_game .= ltrim($gamedomain,".");//trim off the leading . if any
$link_to_game .= str_replace($_SERVER['DOCUMENT_ROOT'],"",dirname(__FILE__));
    mail("$username", "$l_new_topic", "$l_new_message\r\n\r\n$link_to_game","From: $admin_mail\r\nReply-To: $admin_mail\r\nX-Mailer: PHP/" . phpversion());

    $db->Execute("INSERT INTO $dbtables[zones] VALUES(NULL,'$character\'s Territory', $shipid[ship_id], 'N', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 0)");
    $db->Execute("INSERT INTO $dbtables[ibank_accounts] (ship_id,balance,loan) VALUES($shipid[ship_id],0,0)");
    if($display_password)
    {
       echo $l_new_pwis . " " . $makepass . "<BR><BR>";
    }
    echo "$l_new_pwsent<BR><BR>";
    echo "<A HREF=login.php>$l_clickme</A> $l_new_login";

  }
} else {

  echo $l_new_err;
}

include("footer.php");
?>
