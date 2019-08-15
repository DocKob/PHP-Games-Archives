<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//ES" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>{$servername}</title>
        <meta name="author" content="Brayan Narvaez" />
        <meta name="copyright" content="XNOVA Revolution 5" />
        <meta name="description" content="El apasionante juego de navegador de estrategia espacial basado en xNova Revolution 5" />
		<link rel="icon" href="favicon.ico">
        <link rel="stylesheet" type="text/css" href="styles/css/login.css" />
		<!--[if lt IE 7]><style media="screen" type="text/css">@import "styles/css/ie6.css";</style><![endif]-->
	</head>
	<body>

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

            <h2>{$info}</h2>
		
				<label for="universe">{$closed}</label>

					</ul>

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
	</body>
</html>
