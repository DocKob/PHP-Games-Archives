<br>
{include file="adm/overall_header.tpl"}
<center>
<br>
<table width="60%">
    <tr>
                <td>{$info_information}
                        <textarea rows="25">Información del servidor: {$info}
						
Versión PHP: {$vPHP}
PHP API: {$vAPI}
SafeMode: {$safemode}
MemoryLimit: {$memory}
Versión del Cliente MySQL: {$vMySQLc}
Versión del MySQL: {$vMySQLs}
Versión del Juego: xNova Revolution {$vGame}
URL del Juego: http://{$root}/
Ruta del juego: http://{$gameroot}/index.php
JSON disponible: {$json}
BCMath disponible: {$bcmath}
cURL disponible: {$curl}
Navegador: {$browser}

Problemas desde la instalación:
Editor utilizado (Notepad++,Etc..):
Pantallazo:
Detalles del problema:
                        </textarea>
                </td>
    </tr>
</table>
</center>
{include file="adm/overall_footer.tpl"}