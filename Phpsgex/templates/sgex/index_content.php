<table border='0' width='90%' cellpadding='5' cellspacing='5'>
    <tr>

        <td>

            <div class='art-box art-block' style='margin: 0px !important;'>
                <div class='art-box-body art-block-body'>
                    <div class='art-bar art-blockheader'>
                        <h3 class='t'>Login</h3>
                    </div>
                    <div class='art-box art-blockcontent'>
                        <div class='art-box-body art-blockcontent-body'>
                            <form name='reg_login' id='reg_login' method='post' action=''>
                                <input type='hidden' name='auth' value='login'>
                                <table border='0'>
                                    <tr><td>Nik<br><input type='text' name='username' id='username' size='18' required></td></tr>
                                    <tr><td>Password<br><input type='password' name='password' id='password' size='18' required></td></tr>
                                    <tr><td colspan='2' align='center'>
                            <div style="margin-top: 5px;"><nobr><span class='art-button-wrapper'>
                                <span class='art-button-l'> </span>
                                <span class='art-button-r'> </span>
                                <input type='button' value=' <?=$lang['reg_register'];?> ' class='art-button' onClick="location.href='?pg=register'">
                            </span>

                            <span class='art-button-wrapper'>
                                <span class='art-button-l'> </span>
                                <span class='art-button-r'> </span>
                                <input type='submit' value=' <?=$lang['reg_login'];?> ' class='art-button'>
                            </span></nobr></div>

                                    <div style="margin-top: 5px;"> <a href='?pg=register&act=recoverpass'>Reset Password</a> </div>
                                        </td></tr>
                            <tr> <td colspan="2"><div style="margin-top: 5px;">
                                        <?php
                                        $plugins= Plugin::GetLoadedPlugins();
                                        foreach( $plugins as $p ){ /** @var Plugin $p */
                                            if( $p->type != "bridge" ) continue;

                                            echo $p->Content( array("login_button") );
                                        }
                                        ?>
                                    </div></td> </tr>

                                </table>
                            </form>
                            <div class='cleared'></div>
                        </div>
                    </div>
                    <div class='cleared'></div>
                </div>
            </div>

        </td>


        <td>


            <div class='art-box art-block' style='margin: 0px !important;'>
                <div class='art-box-body art-block-body'>
                    <div class='art-box art-blockcontent'>
                        <div class='art-box-body art-blockcontent-body'>

                            <form method='get' action=''>
                                <p><?php echo $lang['reg_language'];?>: <select name='lang' onchange='this.form.submit()'>
                                        <?php
                                        $dir = './lang';
                                        $handle = opendir($dir);
                                        while( $files = readdir($handle) ) {
                                            if ($files != '.' && $files != '..' && $files != 'index'){
                                                echo '<option ';
                                                if( LANG==substr($files,0,-4) ) echo 'selected';
                                                echo '>'.substr($files,0,-4).'</option>';
                                            }
                                        }
                                        ?>
                                    </select></p>
                            </form>
                            <p><nobr><?=$lang['idx_numplayers'];?>:</nobr> <span class='Stile1'><?php echo $tusr; ?></span></p>
                            <p><nobr><?=$lang['idx_lastreg'];?>:</nobr> <span class='Stile1'><?php echo $lastreg['username']; ?></span></p>


                            <div class='cleared'></div>
                        </div>
                    </div>
                    <div class='cleared'></div>
                </div>
            </div>
        </td>
<td>

        <?php
        $plugins= Plugin::GetLoadedPlugins();
        foreach( $plugins as $p ){ /** @var Plugin $p */
            if( !$p->type != "index" ) continue;

            echo "<p style='margin: 10px 15px;'>".$p->Content()."</p>";
        }
        ?>

    </td></tr></table>

<br />
<div><p>
<?php
	echo $config['news1'];
?></p></div>