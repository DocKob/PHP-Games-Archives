<?


include("config.php");
include("languages/$lang");
$title = "Logout";

SetCookie("userpass","",0,$gamepath,$gamedomain);
SetCookie("userpass","",0); // Delete from default path as well.
setcookie("username","",0); // Legacy support, delete the old login cookies.
setcookie("password","",0); // Legacy support, delete the old login cookies.
setcookie("id","",0);
setcookie("res","",0);

include("header.php");

connectdb();

$result = $db->Execute("SELECT * FROM $dbtables[ships] WHERE email='$username'");
$playerinfo = $result->fields;

$current_score = gen_score($playerinfo[ship_id]);
playerlog($playerinfo[ship_id], LOG_LOGOUT, $ip);

bigtitle();
echo "$l_logout_score $current_score.<BR>";
$l_logout_text=str_replace("[name]",$username,$l_logout_text);
echo $l_logout_text;

include("footer.php");

?>
