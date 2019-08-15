<?

	include("config.php");
	updatecookie();

  include("languages/$lang");
	$title=$l_map_title;
	include("header.php");

	connectdb();
  
  if(checklogin())
  {
    die();
  }

  $res = $db->Execute("SELECT * FROM $dbtables[ships] WHERE email='$username'");
  $playerinfo = $res->fields;
        $result3 = $db->Execute("SELECT distinct $dbtables[movement_log].sector_id,port_type FROM $dbtables[movement_log],$dbtables[universe] WHERE ship_id = $playerinfo[ship_id] AND $dbtables[movement_log].sector_id=$dbtables[universe].sector_id order by sector_id ASC ");
        bigtitle();
	$tile[special]="space261_md_blk.gif";
	$tile[ore]="space262_md_blk.gif";
	$tile[organics]="space263_md_blk.gif";
	$tile[energy]="space264_md_blk.gif";
	$tile[goods]="space265_md_blk.gif";
	$tile[none]="space.gif";
        $tile[unknown] ="uspace.gif";
	$cur_sector=0;
	$cur_index=0;
        $row = $result3->fields;
	echo "cursector = $cur_sector max= $sector_max";
        echo "<TABLE border=0 cellpadding=0 >\n";
        while($cur_sector < $sector_max)
        {
            $break=($cur_sector+1)%50;
            if ($break==1)
            {
               echo "<TR ><TD>$cur_sector</TD> ";
            }
            if($row[sector_id] == $cur_sector )
                {         
                   $port=$row[port_type];
                   $alt = "$row[sector_id] - $row[port_type]";
		   $cur_index=$cur_index+1;
                   $result3->Movenext();
		   $row = $result3->fields;
                }
                else
                {
                   $port="unknown";
                   $alt = "$row[sector_id] - unknown";
                }
           
                  echo "<TD><A HREF=rsmove.php?engage=1&destination=$cur_sector><img src=images/" . $tile[$port] . " alt=\"$alt\" border=0></A></TD>";

                  if ($break==0)
                  {
                     echo "<TD>$cur_sector</TD></TR>\n";

                  }
           $cur_sector = $cur_sector + 1;

              
        }
        echo "</TABLE>\n";

        echo "<BR><BR>";
        echo "<img src=images/" . $tile[special] . "> - Special Port<BR>\n";
        echo "<img src=images/" . $tile[ore] . "> - Ore Port<BR>\n";
        echo "<img src=images/" . $tile[organics] . "> - Organics Port<BR>\n";
        echo "<img src=images/" . $tile[energy] . "> - Energy Port<BR>\n";
        echo "<img src=images/" . $tile[goods] . "> - Goods Port<BR>\n";
        echo "<img src=images/" . $tile[none] . "> - No Port<BR><BR>\n";
        echo "<img src=images/" . $tile[unknown] . "> - Unexplored<BR><BR>\n";
	echo "Click <a href=main.php>here</a> to return to main menu.";
	include("footer.php");

?> 


