<?php
//add unit
$racsel="<select name='race'><option value='0'>All</option>";
$qrac= $DB->query("SELECT * FROM ".TB_PREFIX."races");
while( $racr= $qrac->fetch_array() ) $racsel.="<option value='".$racr['id']."'>".$racr['rname']."</option>"; 
$racsel.="</select>";

$rescost="";
$qr= $DB->query("SELECT * FROM ".TB_PREFIX."resdata");
while( $ftr= $qr->fetch_array() ) { $rescost.=$ftr['name'].": <input type='text' size='3' name='res".$ftr['id']."' value='0'> <br>"; }

$body.="<form action='?pg=units' method='post'></table> <br><h2>".$lang['adm_addunit']."</h2>
<table border='1' width='105%'> <tr><td>".$lang['adm_name']."/".$lang['reg_race']."/".$lang['adm_image']."</td> <td>Atk/Dif/Vel</td> <td>Cost</td><td>".$lang['adm_desc']."</td></tr>
<tr><td>Name:<br> <input type='text' name='name' size='15'> <br>Race: <br>$racsel <br>Image: <br><input type='text' name='img' value='null.gif'></td>
<td>Health: <input type='text' name='health' value='100' size='3'><br>Atk: <input type='text' size='3' name='atk' value='0'> <br>Dif: <input type='text' size='3' name='dif' value='0'> <br>Vel: <input type='text' size='3' name='vel' value='0'> <br>Cargo: <input type='text' size='5' name='cargo' value='0'></td> <td>$rescost Time: <input type='text' name='time' size='3' value='0'></td><td><textarea name='desc'></textarea></td> <td><input type='image' src='../img/icons/add-icon.png' onclick='document.thisform.submit()' name='addunt' value=' ' /></td>  </tr>
</table></form>";

//edit units
$body.= "<br><br><form method='get' action=''><input type='hidden' name='pg' value='units'>
Show by race: <select name='srac'><option value='0'>All</option>";

$qrac= $DB->query("SELECT * FROM ".TB_PREFIX."races");
while( $racr= $qrac->fetch_array() ) $body.= "<option value='".$racr['id']."'>".$racr['rname']."</option>"; 

$body.="</select> <input type='submit' value='ok'></form><br>
<table border='1' width='106%'> <tr><td>".$lang['adm_name']."/".$lang['adm_image']."/".$lang['reg_race']."</td> <td>Atk/Dif/Vel</td> <td>Cost</td><td>".$lang['adm_requirements']."</tr>";

$rac=0;
$qr= $DB->query("SELECT * FROM ".TB_PREFIX."t_unt");
if( isset($_GET['srac']) && $_GET['srac'] >0 ){ $qr= $DB->query("SELECT * FROM t_unt WHERE race =".(int)$_GET['srac']); $rac=(int)$_GET['srac']; }

while( $row= $qr->fetch_array() ){
	$racsel="<select name='race'><option value='0'>All</option>";
	$qrac= $DB->query("SELECT * FROM ".TB_PREFIX."races");
	while( $racr= $qrac->fetch_array() ) { 
		$racsel.="<option value='".$racr['id']."'";
		if( $racr['id']==$row['race'] ) $racsel.="selected";
		$racsel.=">".$racr['rname']."</option>"; 
	}
	$racsel.="</select>";
	
	$rescost="";
	$qrres= $DB->query("SELECT * FROM ".TB_PREFIX."resdata");
	while( $ftr= $qrres->fetch_array() ){
		$qrcost= $DB->query("SELECT * FROM `".TB_PREFIX."t_unt_resourcecost` WHERE `unit` =".$row['id']." AND resource =".$ftr['id']);
		if( $qrcost->num_rows ==0 ) $cost=0;
		else {
			$ar= $qrcost->fetch_array();
			$cost= $ar['cost'];	
		}
		$rescost.=$ftr['name'].": <br><input type='text' size='3' name='res".$ftr['id']."' value='$cost'><br>";
	}
	
	$body.="<form method='post' action='?pg=units&srac=$rac'><input type='hidden' name='editunt' value='".$row['id']."'>
	<tr><td style='text-align: left'>".$lang['adm_name'].": <br><input type='text' size='17' name='name' value='".$row['name']."'> <br>".$lang['adm_image']."<br><input type='text' name='img' value='".$row['img']."' size='17'> <br>".$lang['reg_race'].": <br>$racsel <br>Desc: <br><textarea name='desc'>".$row['desc']."</textarea></td>
	<td>Health: <br><input type='text' name='health' value='".$row['health']."' size='3'><br> Atk: <br><input type='text' size='3' name='atk' value='".$row['atk']."'><br>
	Dif: <br><input type='text' size='3' name='dif' value='".$row['dif']."'><br> Vel: <br><input type='text' size='3' name='vel' value='".$row['vel']."'> <br>Cargo: <br><input type='text' size='5' name='cargo' value='".$row['res_car_cap']."'></td> <td>$rescost Time: <br><input type='text' size='2' name='time' value='".$row['etime']."'></td>
	 <td>";
	//unit build req
	$qrreqbud= $DB->query("SELECT * FROM `".TB_PREFIX."t_unt_reqbuild` WHERE `unit` =".$row['id']);
	$i=1;
	while( $arb= $qrreqbud->fetch_array() ) {
		$body.="<select name='reqbud$i'>";
		
		$qrgetbuilds= $DB->query("SELECT * FROM ".TB_PREFIX."t_builds");
		while( $gb= $qrgetbuilds->fetch_array() ){
			$body.="<option value='".$gb['id']."' ";
			if( $gb['id']==$arb['reqbuild'] ) $body.="selected";
			$body.=">".$gb['name']."</option>";
		}
			
		$body.="</select>: <input type='text' name='levbud$i' value='".$arb['lev']."' size='1'></nobr> <br>";
		$i++;
	}
	
	$body.="<nobr> <div id='radd".$row['id']."' style='display:none;'><select name='reqbud$i'>";
	
	$qrgetbuilds= $DB->query("SELECT * FROM ".TB_PREFIX."t_builds");
	while( $gb= $qrgetbuilds->fetch_array() ) $body.="<option value='".$gb['id']."'>".$gb['name']."</option>";
	
	$body.="</select>: <input type='text' name='levbud$i' value='0' size='1'></div></nobr> <br><a href='#' onclick=\"javascript: showHide(radd".$row['id'].");\">".$lang['adm_add']."</a></td><td>";
	
	//unit research req
	$qrreqresearch= $DB->query("SELECT * FROM ".TB_PREFIX."t_unt_req_research WHERE unit =".$row['id']);
	$i=1;
	while( $arb= $qrreqresearch->fetch_array() ){
		$body.="<select name='reqresearch$i'>";	
		
		$qrgetresearch= $DB->query("SELECT * FROM ".TB_PREFIX."t_research");
		while( $gb= $qrgetresearch->fetch_array() ){
			$body.="<option value='".$gb['id']."' ";
			if( $gb['id']==$arb['reqresearch'] ) $body.="selected";
			$body.=">".$gb['name']."</option>";	
		}
		
		$body.="</select> <input type='text' name='levresearch$i' value='".$arb['lev']."' size='1'> <br>";
		$i++;
	}
	
	
	$body.="<nobr> <div id='raddrs".$row['id']."' style='display:none;'><select name='reqresearch$i'>";
	
	$qrgetreseach= $DB->query("SELECT * FROM ".TB_PREFIX."t_research");
	while( $gb= $qrgetreseach->fetch_array() ) $body.="<option value='".$gb['id']."'>".$gb['name']."</option>";
	
	$body.="</select>: <input type='text' name='levresearch$i' value='0' size='1'></div></nobr> <br><a href='#' onclick=\"javascript: showHide(raddrs".$row['id'].");\">".$lang['adm_add']."</a>
	</td><td><input type='image' src='../img/icons/b_edit.png' onclick='document.thisform.submit()' /><a href='?pg=units&delunt=".$row['id']."'><img src='../img/icons/x.png' /></a></td></tr></form>";	
}
$body.="</table>";
?>