{include file="index_header.tpl"}
	<div class="wrapper">
			<div id="page">
				<div id="header">
					<ul class="buttons">
						<li><a href="index.php">{$menu_index}</a></li>
						<li class="skull"><a href="#"></a></li>

						<li class="tour"><a href="{$forum_url}" target="_blank">{$forum}</a></li>
					</ul>
				</div>
				<div id="main">
					<div class="content">
						<div class="central-btn">
	<a href="index.php?page=reg&lang={$lang}">&iexcl;{$register_now}!</a>
</div>

<div class="text-flag">
    <p>{$server_description}</p>
			<p>{if $fb_active}<br><br><a href="javascript:void(0);" onclick="loginFB(); return false;"><img src="http://b.static.ak.fbcdn.net/rsrc.php/zB6N8/hash/4li2k73z.gif" alt=""></a>{/if}</p>
</div>
<strong class="logo">
	<a href="#">{$servername}</a>
</strong>					</div>

					<div class="form">
						<form action="" method="post" name="xnovarevolution">
							<fieldset>
								<ul class="login">
									<li>
										<label>{$universe}</label>
										<select name="universe" id="universe">
                                         {html_options options=$AvailableUnis selected=$UNI}
									    </select>
									</li>

									<li>
										<label for="username">{$user}</label>
										<div class="bg"><input  type="text" name="username" id="username" class="text" alt="{$user}" value="" maxlength="30" onfocus="checkSearchText(this,1,1)" onblur="checkSearchText(this,0,1)" /></div>
									</li>
									<li>
										<label for="userpass">{$pass}</label>
										<div class="bg"><input type="password" name="password" id="password" class="text" alt="{$pass}" value="" maxlength="30" onfocus="checkSearchText(this,1,2)" onblur="checkSearchText(this,0,2)" /></div>
									</li>

									<li><div class="bg submit"><input type="submit" value="{$login}" name="submit" class="submit" /></div></li>
								</ul>
								<ul class="help">
									<li><a href="index.php?page=lostpassword&lang={$lang}">{$lostpassword}</a></li>
									<li><a href="index.php?page=reg&lang={$lang}">{$register_now}</a></li>
								</ul>

							</fieldset>
						</form>
					</div>
					<div id="footer">
						<p>{$servername} &copy; {$year} powered by {$asd}.</p>
						<ul>
							<li><a href="index.php?page=agb&amp;lang={$lang}" target="_blank">{$menu_agb}</a></li>
							<li><a href="index.php?page=rules&amp;lang={$lang}"  target="_blank">{$menu_rules}</a></li>
							{foreach $langs as $lng} <li><a href="?lang={$lng}"><img src="./styles/images/login/{$lng}.png" alt="" width="16" height="11"></a>{/foreach}
							</ul>
					</div>
				</div>
			</div>
		</div>
{include file="index_footer.tpl"}