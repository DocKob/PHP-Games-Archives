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
		<form name="reg" action="?page=reg&mode=send&lang={$lang}" method="post" id="formID">
			
				<div class="left-col">
					<ul class="login">

						<li>
							<label for="username">{$user_reg}</label>
							<div class="bg"><input id="character" name="character" class="text" type="text" value="" alt="{$user_reg}" maxlength="15" /></div>
						</li>
						<li>

							<label for="email">{$email_reg}</label>
							<div class="bg"><input id="email" name="email" class="text" type="text" value="" alt="{$email_reg}" maxlength="255" /></div>
						</li>
									<li>

							<label for="email">{$email2_reg}</label>
							<div class="bg"><input id="email2" name="email2" class="text" type="text" value="" alt="{$email2_reg}" maxlength="255" /></div>
						</li>
						<li>
							<label for="userpass">{$pass_reg}</label>
							<div class="bg"><input id="password" name="password" class="text" type="password" value="" alt="{$pass_reg}" maxlength="15" /></div>
						</li>
												<li>
							<label for="userpass">{$pass2_reg}</label>
							<div class="bg"><input id="password2" name="password2" class="text" type="password" value="" alt="{$pass2_reg}" maxlength="15" /></div>
						</li>
												<li>
							<label for="username">{$planet_reg}</label>
							<div class="bg"><input id="planet" name="planet" class="text" type="text" value="" alt="{$planet_reg}" maxlength="15" /></div>
						</li>

					</ul>

				</div>
				<div class="right-col">
		<br /><br />					
													
						
<label>{$lang_reg}</label><br />
							<select name="lang" id="lang">
            {html_options options=$AvailableLangs selected=$lang}
			</select><br>
									
							<label for="universe">{$uni_reg}</label><br>
<select name="universe" id="universe">
{html_options options=$AvailableUnis selected=$UNI}
</select><br />
<label>{$raza_reg}</label><br />
<select name="raza"  id="raza">
<option name="0" value="0">{$raza_0}</option>
<option name="1" value="1">{$raza_1}</option>
</select>
					
			
							
					<p class="agb-text"><br>
							
								<input class="agb-check" name="rgt" type="checkbox" />	{$accept_terms_and_conditions}</p>
							

					<input class="submit" type="submit" value="{$send}" />

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