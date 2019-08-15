{include file="index_header.tpl"}
<div class="wrapper-guide">
			<div id="page">

				<div id="header">
					<ul class="buttons">
						<li><a href="index.php">{$menu_index}</a></li>
						<li class="skull"><a href="#"></a></li>

						<li class="tour"><a href="{$forum_url}" target="_blank">{$forum}</a></li>
					</ul>
				</div>
				<div id="main">

					<div class="content-big">
<div class="register">
	<div class="form-reg">
		<form name="lostpassword" action="index.php?page=lostpassword&mode=send&lang={$lang}" method="post" id="formID">
			
				<div class="left-col">
					<ul class="login">

						 <h2>{$lost_pass_title}</h2>
						<label for="universe">{$uni_reg}</label><br>
        		<select name="universe" id="Uni">
            {html_options options=$AvailableUnis selected=$UNI}
			    </select><br>
			
				<li><label for="email">{$email}</label>
        	<div class="bg"><input type="text" name="email" class="text" id="email" tabindex="1" class="input" /></div></li>
							
					</ul>

				</div>
				<div class="right-col">
				  <br><br><br><br><input tabindex="2" class="submit" type="submit" value="{$send}"/>
				
				</div>
			
		</form>
	</div>
</div>
<strong class="logo">{$servername}</strong>

					</div>

<div id="footer">
						<br><br><p>{$servername} &copy; {$year} powered by {$asd}.</p>
						<ul>
							<li><a href="index.php?page=agb" target="_blank">{$menu_agb}</a></li>
							<li><a href="index.php?page=rules&amp;lang={$lang}"  target="_blank">{$menu_rules}</a></li>
							{foreach $langs as $lng} <li><a href="?lang={$lng}"><img src="./styles/images/login/{$lng}.png" alt="" width="16" height="11"></a>{/foreach}
							</ul>
					</div>
				</div>
			</div>
		</div>
{include file="index_footer.tpl"}