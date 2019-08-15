<?php

    include("config.php");
    include("languages/$lang");

    // Stores the class for creating the universe.
    include("setup_info_class.php");

    // Load up SETUPINFO Class
    $setup_info = &new SETUPINFO_CLASS();

    ##########################
    #  Class Test Switches.  #
    ##########################
    $setup_info->switches['Show_Env_Var']['enabled']	= True;
    $setup_info->switches['Test_Cookie']['enabled']		= True;
    $setup_info->switches['Enable_Database']['enabled']	= True;
    $setup_info->switches['Display_Patches']['enabled']	= True;
    $setup_info->switches['Display_Errors']['enabled']	= True;
    ##########################

    $setup_info->testcookies();
	$setup_info->initDB();

    $title = $setup_info->appinfo['title'];
    include("header.php");

    ##########################

	$setup_info->DisplayFlush("<div align=\"center\">\n");
	$setup_info->DisplayFlush("<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\">\n");
	$setup_info->DisplayFlush("  <tr>\n");
	$setup_info->DisplayFlush("    <td><font size=\"6\" color=\"#FFFFFF\">{$setup_info->appinfo['title']}</font></td>\n");
	$setup_info->DisplayFlush("  </tr>\n");
	$setup_info->DisplayFlush("  <tr>\n");
	$setup_info->DisplayFlush("    <td align=\"center\"><font size=\"2\" color=\"#FFFFFF\"><B>{$setup_info->appinfo['description']}</B></font></td>\n");
	$setup_info->DisplayFlush("  </tr>\n");
	$setup_info->DisplayFlush("  <tr>\n");
	$setup_info->DisplayFlush("    <td align=\"center\"><font size=\"2\" color=\"#FFFFFF\"><B>Written by {$setup_info->appinfo['author']}</B></font></td>\n");
	$setup_info->DisplayFlush("  </tr>\n");
	$setup_info->DisplayFlush("</table>\n");
	$setup_info->DisplayFlush("</div><br>\n");
	$setup_info->DisplayFlush("<br>\n");

    ##########################
    # End of own HTML Tables #
    ##########################
    $setup_info->DisplayFlush("<font size=\"2\" color=#FFFF00><i>Well since a lot of people are having problems setting up Blacknova Traders on a Linux based server.</i></font><br>\n");
    $setup_info->DisplayFlush("<font size=\"2\" color=#FFFF00><i>Here is the settings that you may require to set.</i></font><br><br>\n");

    $setup_info->DisplayFlush("<font size=\"2\" color=#FFFFFF>ADMINS: <font color=#FFFF00>If you get any errors or incorrect info returned then set <font color=\"#00FF00\">$"."setup_info->switches['Show_Env_Var']['enabled'] = True;</font></font></font><br><br>\n");
    $setup_info->DisplayFlush("<font size=\"2\" color=#FFFFFF>To Enable the Cookie Test, set <font color=\"#00FF00\">$"."setup_info->switches['Test_Cookie']['enabled'] = True;</font></font><br>\n");
    $setup_info->DisplayFlush("<font size=\"2\" color=#FFFFFF>To Enable the Database Test, set <font color=\"#00FF00\">$"."setup_info->switches['Enable_Database']['enabled'] = True;</font></font><br>\n");
    $setup_info->DisplayFlush("<font size=\"2\" color=#FFFFFF>To Enable the Display All installed patches, set <font color=\"#00FF00\">$"."setup_info->switches['Display_Patches']['enabled'] = True;</font></font><br>\n");
    $setup_info->DisplayFlush("<font size=\"2\" color=#FFFFFF>To Enable the Display All Errors, set <font color=\"#00FF00\">$"."setup_info->switches['Display_Errors']['enabled'] = True;</font></font><br>\n");
    $setup_info->DisplayFlush("<font size=\"2\" color=yellow>Then refresh the page and then save it as htm or html and then Email it to me.</font><br>\n");
    $setup_info->DisplayFlush("<hr size='1'>\n");
	$setup_info->DisplayFlush("<br>\n");

    ##########################

    $Cols = 3;
    $switch_info = $setup_info->get_switches();
    $setup_info->do_Table_Title("Setup Info Switch Configuration",$Cols);
    for($n=0; $n < count($switch_info); $n++)
    {
        list($switch_name, $switch_array) = each($switch_info);
        $setup_info->do_Table_Row($switch_array['caption'],"<font color='maroon'>".$switch_array['info']."</font>",(($switch_array['value']) ? "<font color='#0000FF'>Enabled</font>" : "<font color='#FF0000'>Disabled</font>"));
    }
	$setup_info->do_Table_Footer("<br>");

    ##########################

    $setup_info->DisplayFlush("<p><hr align='center' width='80%' size='1'></p>\n");
    $setup_info->DisplayFlush("<font size=\"2\">// This is just to find out what Server Operating System your running bnt on.</font><br>\n");
    $setup_info->DisplayFlush("<font size=\"2\">// And to find out what other software is running e.g. PHP,</font><br>\n");
    $setup_info->DisplayFlush("<br>\n");

    $Cols = 3; $Wrap = True;
    $setup_info->do_Table_Title("Server Software/Operating System",$Cols);

    $software_info = $setup_info->get_server_software();

	for($n=0; $n < count($software_info); $n++)
    {
        list($software_name, $software_array) = each($software_info);
        list($software_key, $software_value) = each($software_array);
        $setup_info->do_Table_Row($software_key,$software_value);
    }

    if($setup_info->testdb_connection())
    {
        $setup_info->do_Table_Row("DB CONNECTION","<font color='#0000FF'><B>".$setup_info->db_status['status']."</B></font>");
    }
    else
    {
        $setup_info->do_Table_Row("DB CONNECTION","<font color='#FF0000'><B>".$setup_info->db_status['status']."<br>".$setup_info->db_status['error']."</B></font>");
    }

	if($setup_info->cookie_test['enabled'])
	{
	    if($setup_info->cookie_test['result'])
	    {
	        $setup_info->do_Table_Row("Cookie Test","<font color='#0000FF'><B>Passed</B></font>");
	    }
	    else
	    {
	        $setup_info->do_Table_Row("Cookie Test","<font color='#FF0000'><B>Failed testing Cookies!<br>{$setup_info->cookie_test['status']}</B></font>");
	    }
	}
	else
	{
	        $setup_info->do_Table_Row("Cookie Test","<font color='#FF0000'><B>{$setup_info->cookie_test['status']}</B></font>");
	}
    $setup_info->do_Table_Footer("");
    $setup_info->DisplayFlush("<br>\n");

    $Cols = 3; $Wrap = True;
    $setup_info->do_Table_Title("Software Versions",$Cols);

    $software_versions = $setup_info->get_software_versions();
	for($n=0; $n < count($software_versions); $n++)
    {
        list($software_name, $software_array) = each($software_versions);
        list($software_key, $software_value) = each($software_array);
        $setup_info->do_Table_Row($software_key,$software_value);
    }
    $setup_info->do_Table_Blank_Row();
    $setup_info->do_Table_Single_Row("* = Module (if any installed).");
    $setup_info->do_Table_Footer("<br>");

	#########################################
	#         Config_Local Settings.        #
	#########################################
    $setup_info->DisplayFlush("<hr align='center' width='80%' size='1'>\n");

    $setup_info->DisplayFlush("<p><font size=\"2\">// This is what you need to put in your config_local.php file.</font><br>\n");
    $setup_info->DisplayFlush("<font size=\"2\">// If you are having problems using this script then email me <a class=\"email\" href=\"mailto:{$setup_info->appinfo['email']}\">{$setup_info->appinfo['author']}</a>.</font><br>\n");
    $setup_info->DisplayFlush("<font size=\"2\">// Also if you think the info displayed is Incorrect then Email me <a class=\"email\" href=\"mailto:{$setup_info->appinfo['email']}\">{$setup_info->appinfo['author']}</a> with the following information:</font></p>\n");
    $setup_info->DisplayFlush("<ul>\n");
    $setup_info->DisplayFlush("  <li><font size=\"2\" color=#FFFF00>A htm or html saved page from within you browser of Setup Info with <font size=\"2\" color=#00FF00>$"."setup_info->switches['Show_Env_Var']['enabled'] = True;</font> This is settable within setup_info.php.</font></li>\n");
    $setup_info->DisplayFlush("  <li><font size=\"2\" color=#FFFF00>What Operating System you are using.</font></li>\n");
    $setup_info->DisplayFlush("  <li><font size=\"2\" color=#FFFF00>What Version of Apache, PHP and mySQL that you are using.</font></li>\n");
    $setup_info->DisplayFlush("  <li><font size=\"2\" color=#FFFF00>And if using Windows OS are you using IIS.</font></li>\n");
    $setup_info->DisplayFlush("</ul>\n");
    $setup_info->DisplayFlush("<p><font size=\"2\">// With this information it will help me to help you much faster and also get my Script to display more reliable information.</font></p>\n");

    $setup_info->do_Table_Title("DB Config Settings",$Cols);

    $setup_info->do_Table_Blank_Row();
    $game_root = $setup_info->get_gameroot();
    $setup_info->do_Table_Row("gameroot","<B>".(!$game_root['status'] ? "<font color='#FF0000'>{$game_root['info']}</font>" : $game_root['result'] )."</B>");
    if(!$game_root['status'])
    {
        $setup_info->do_Table_Single_Row("Please set $"."setup_info->switches['Show_Env_Var']['enabled'] = True; and email the page result to me.");
    }

    $setup_info->do_Table_Blank_Row();
    $game_path = $setup_info->get_gamepath();
    $setup_info->do_Table_Row("gamepath","<B>".(!$game_path['status'] ? "<font color='#FF0000'>{$game_path['info']}</font>" : $game_path['result'] )."</B>");
    if(!$game_path['status'])
    {
        $setup_info->do_Table_Single_Row("Please set $"."setup_info->switches['Show_Env_Var']['enabled'] = True; and email the page result to me.");
    }

    $setup_info->do_Table_Blank_Row();
    $game_domain = $setup_info->get_gamedomain();
    $setup_info->do_Table_Row("gamedomain","<B>".(!$game_domain['status'] ? "<font color='#FF0000'>{$game_domain['info']}</font>" : $game_domain['result'] )."</B>");
    if(!$game_domain['status'])
    {
        $setup_info->do_Table_Single_Row("Please set $"."setup_info->switches['Show_Env_Var']['enabled'] = True; and email the page result to me.");
    }

    $setup_info->do_Table_Blank_Row();
    $setup_info->do_Table_Single_Row("You need to set this information in db_config.php");
    $setup_info->do_Table_Blank_Row();
    $setup_info->do_Table_Footer();

    #########################################
    #      Display BNT DataBase Status.     #
    #########################################
    $setup_info->DisplayFlush("<hr align='center' width='80%' size='1'>\n");

    $setup_info->DisplayFlush("<p><font size=\"2\">// This displays status on the BNT Database.</font></p>\n");
	$Cols = 3;
	$setup_info->do_Table_Title("Blacknova Traders Database Status",$Cols);

    $DB_STATUS = $setup_info->validate_database();
	$setup_info->do_Table_Row("TableCount",$DB_STATUS['status']);
    $setup_info->do_Table_Blank_Row();
    foreach($DB_STATUS as $n => $s)
    {
        if($n!="status") 
        {
            $setup_info->do_Table_Row($DB_STATUS[$n]['name'],$DB_STATUS[$n]['info'],$DB_STATUS[$n]['status']);
        }
    }
    $setup_info->do_Table_Blank_Row();
    $setup_info->do_Table_Footer("<br>");

    #########################################
    #       Display BNT Patch Status.       #
    #########################################
    $setup_info->get_patch_info($patch_info);

    $setup_info->DisplayFlush("<hr align='center' width='80%' size='1'>\n");
    $setup_info->DisplayFlush("<p><font size=\"2\">// This displays Installed Patch information on the BNT Server.</font></p>\n");

    $Cols = 3;
    $setup_info->do_Table_Title("Testing for installed patches",$Cols);

    foreach($patch_info as $n => $s)
    {
        $setup_info->do_Table_Row($patch_info[$n][0]['name'],$patch_info[$n][0]['info'],$patch_info[$n][0]['patched']);
        if($patch_info[$n][0]['patched']!="Not Found")
        {
            $setup_info->do_Table_Row("Patch Information","<font color=\"maroon\">Author: </font><font color=\"purple\">".$patch_info[$n][1]['author']."</font><br>\n<font color=\"maroon\">Created: </font><font color=\"purple\">".$patch_info[$n][1]['created']."</font>");
        }
        $setup_info->do_Table_Blank_Row();
    }
    $setup_info->do_Table_Footer("<br>");

    #########################################
    #  This gets the Environment Variables  #
    #########################################
    $setup_info->DisplayFlush("<hr align='center' width='80%' size='1'>\n");
    $setup_info->DisplayFlush("<p><font size=\"2\">// This is used to help the admin of the server set up BNT, Or its used by me if you are having problems setting up BNT.</font></p>\n");

    $Cols = 2;
    $Wrap = True;
	$setup_info->do_Table_Title("Environment Variables",$Cols);
    if($setup_info->get_env_variables($env_info))
    {
        for ($n=0; $n <count($env_info); $n++)
        {
            $setup_info->do_Table_Row($env_info[$n]['name'],$env_info[$n]['value']);
        }
    }
    else
    {
        for ($n=0; $n <count($env_info['status']); $n++)
        {
            $env_status .= $env_info['status'][$n];
            if($n < count($env_info['status']))
            {
                $env_status .="<br>";
            }
        }
        $setup_info->do_Table_Single_Row("<B>$env_status</B>");
    }
    $setup_info->do_Table_Footer("<br>");

    #########################################
    #     Current db_config Information.    #
    #########################################
    $setup_info->DisplayFlush("<hr align='center' width='80%' size='1'>\n");
    $setup_info->DisplayFlush("<p><font size=\"2\">// This is what you already have set in db_config.php.</font><br>\n");
    $setup_info->DisplayFlush("<font size=\"2\">// This will also tell you if what you have set in db_config.php is the same as what Setup Info has Auto Detected.</font></p>\n");

	$Cols = 3;
    $setup_info->do_Table_Title("Current DB Config Information",$Cols);
    $cur_cfg_loc = $setup_info->get_current_db_config_info();

    if(is_array($cur_cfg_loc))
    {
        for ($n=0; $n<count($cur_cfg_loc)-1;$n++)
        {
            if(is_string($cur_cfg_loc[$n]) & $cur_cfg_loc[$n] =="%SEPERATOR%")
            {
                $setup_info->do_Table_Blank_Row();
            }
            if(is_array($cur_cfg_loc[$n]))
            {
                if(count($cur_cfg_loc[$n])>2)
                {
                    $setup_info->do_Table_Row($cur_cfg_loc[$n]['caption'],$cur_cfg_loc[$n]['value'],$cur_cfg_loc[$n]['status']);
                }
                else
                {
                    $setup_info->do_Table_Row($cur_cfg_loc[$n]['caption'],$cur_cfg_loc[$n]['value']);
                }
            }
        }
    }
    $setup_info->do_Table_Footer("<br>");

    #########################################
    #     Current Scheduler Information.    #
    #########################################
    $setup_info->DisplayFlush("<hr align='center' width='80%' size='1'>\n");
    $setup_info->DisplayFlush("<p><font size=\"2\">// This displays the Scheduler information.</font></p>\n");

    $Cols = 3;
    $setup_info->do_Table_Title("Scheduler Information",$Cols);

    $scheduler_info = $setup_info->get_scheduler_info();
 
    for ($n=0; $n <count($scheduler_info); $n++)
    {
        $setup_info->do_Table_Row($scheduler_info[$n]['name'],$scheduler_info[$n]['caption'], $scheduler_info[$n]['value']);
    }
    $setup_info->do_Table_Footer("<br>");

    #########################################
    #         My Script Information.        #
    #########################################
    $setup_info->appinfo;

    $setup_info->DisplayFlush("<hr size=\"1\">\n");
    $setup_info->DisplayFlush("<div align=\"center\">\n");
    $setup_info->DisplayFlush("  <center>\n");
    $setup_info->DisplayFlush("  <table cellSpacing=\"0\" width=\"100%\" border=\"0\">\n");
    $setup_info->DisplayFlush("    <tbody>\n");
    $setup_info->DisplayFlush("      <tr>\n");
    $setup_info->DisplayFlush("        <td vAlign=\"top\" noWrap align=\"left\" width=\"50%\"><font face=\"Verdana\" size=\"1\" color=\"white\">Version <font color=\"lime\">{$setup_info->appinfo['version']} (<font color=\"white\">{$setup_info->appinfo['releasetype']}</font>)</font></font></td>\n");
    $setup_info->DisplayFlush("        <td vAlign=\"top\" noWrap align=\"right\" width=\"50%\"><font face=\"Verdana\" size=\"1\" color=\"white\">Created on <font color=\"lime\">{$setup_info->appinfo['createdate']}</font></font></td>\n");
    $setup_info->DisplayFlush("      </tr>\n");
    $setup_info->DisplayFlush("      <tr>\n");
    $setup_info->DisplayFlush("        <td vAlign=\"top\" noWrap align=\"left\" width=\"50%\"><font face=\"Verdana\" size=\"1\" color=\"white\">");

    if (function_exists('md5_file'))
    {
        $hash = strtoupper(md5_file(basename($_SERVER['PHP_SELF'])));
		$setup_info->DisplayFlush(" Hash: [<font color=\"yellow\">$hash</font>] - [<font color=\"yellow\">". $setup_info->appinfo['hash']."</font>]");
    }
    else
    {
        $setup_info->DisplayFlush(" Hash: [<font color=\"yellow\">Disabled</font>]");
    }

    $setup_info->DisplayFlush("</font></td>\n");
    $setup_info->DisplayFlush("        <td vAlign=\"top\" noWrap align=\"right\" width=\"50%\"><font face=\"Verdana\" size=\"1\" color=\"white\">Updated on <font color=\"lime\">{$setup_info->appinfo['updatedate']}</font></font></td>\n");
    $setup_info->DisplayFlush("      </tr>\n");
    $setup_info->DisplayFlush("    </tbody>\n");
    $setup_info->DisplayFlush("  </table>\n");
    $setup_info->DisplayFlush("  </center>\n");
    $setup_info->DisplayFlush("</div>\n");
    $setup_info->DisplayFlush("<hr size=\"1\"><br>\n");

	if(empty($username))
	{
		TEXT_GOTOLOGIN();
	}
	else
	{
		TEXT_GOTOMAIN();
	}

    include("footer.php");

?>
