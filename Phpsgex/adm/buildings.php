<?php
function build_get_resoucecost($bid=0){
	global $DB;
	$r="<table border='0'><tr> <th>Name</th> <th>Cost</th> <th>Multiplier</th> </tr>";
	
	$qr= $DB->query("select * from ".TB_PREFIX."resdata");
	while( $row= $qr->fetch_array() ){
		$qrcost= $DB->query("select cost, moltiplier from ".TB_PREFIX."t_build_resourcecost where build= $bid and resource= ".$row['id']);
		if( $bid==0 || $qrcost->num_rows ==0 ) $r.= "<tr> <td>".$row['name']."</td> <td><input type='text' name='res".$row['id']."' value='0' size='3'></td> 
			<td><input type='text' name='rmpl".$row['id']."' value='1' min='1' size='3'></td> </tr>";
		else {
			$rescost= $qrcost->fetch_array();
			$r.= "<tr> <td>".$row['name']."</td> <td><input type='text' name='res".$row['id']."' value='".$rescost['cost']."' size='3'> </td> 
			<td><input type='text' name='rmpl".$row['id']."' value='".$rescost['moltiplier']."' min='1' size='3'></td> </tr>";
		}
	}
	
	$qr= $DB->query("select * from ".TB_PREFIX."t_builds where id= $bid");
	if( $qr->num_rows ==0 ) $r.="<tr><td>Time:</td> <td><input type='text' name='time' value='0' size='3'></td> 
		<td><input type='text' name='timempl' value='0' size='3'></td></tr>";
	else {
		$aqr= $qr->fetch_array();
		$r.="<tr><td>Time:</td> <td><input type='text' name='time' value='".$aqr['time']."' size='3'></td> 
		<td><input type='text' name='timempl' value='".$aqr['time_mpl']."' size='3'></td></tr>";
	}
	
	return $r."</table>";
}

require_once("admcommon.php");

$body="<h2>Buildings</h2>";
//add new build
$body.="<form method='post'><table border='1' width='100%'>
<tr> 
	<td>
		<table border='0' class='tbleft'>
			<tr> <td>Name:</td> <td><input type='text' name='name' size='16'></td> </tr>
			<tr> <td>Image:</td> <td><input type='text' name='img' size='16'></td> </tr>
			<tr> <td>Race:</td> <td>".race_select()."</td> </tr>
		</table>
	</td> 
	<td>
		<table border='0' class='tbleft'>
			<tr> <td>Produce:</td> <td>".produce_select()."</td> </tr>
			<tr> <td>Function:</td> <td>".budfun_select()."</td> </tr>
			<tr> <td>Max Lev</td> <td><input type='text' name='maxlev' value='0' size='3'></td> </tr>
		</table>
	</td>
	<td>".build_get_resoucecost()."</td>
	<td><input type='image' src='../img/icons/add-icon.png' onclick='document.thisform.submit()' name='addbuild' value=' '></td>
</tr>
</table></form>";

//edit buildings
$body.="<h3>Edit Buildings</h3>";
$qrbuilds= $DB->query("select * from ".TB_PREFIX."t_builds");
while( $building= $qrbuilds->fetch_array() ){
	$allbud="";
	$qrbudreq= $DB->query("SELECT * FROM ".TB_PREFIX."t_build_reqbuild join ".TB_PREFIX."t_builds on (reqbuild=id) where build=".$building['id']);
	while( $rbudreq= $qrbudreq->fetch_array() ){
		$allbud.="<div><nobr><select name='reqbud[]'>";
		$qr= $DB->query("SELECT `id`, `name` FROM `".TB_PREFIX."t_builds` WHERE `id` != ".$building['id']);
		while( $row= $qr->fetch_array() ){
			$allbud.="<option value='".$row['id']."' ".(($rbudreq['reqbuild']==$row['id'])?"selected":"").">".$row['name']."</option>";
		}
		$allbud.="</select>: <input type='text' name='levbud[]' value='".$rbudreq['lev']."' size='3'></nobr></div>";
	}
	
	$allresearch="";
	$qrbudreq= $DB->query("SELECT * FROM ".TB_PREFIX."t_build_req_research join ".TB_PREFIX."t_research on (reqresearch=id) where build=".$building['id']);
	while( $rresearchreq= $qrbudreq->fetch_array() ){
		$allresearch.="<div><nobr><select name='reqresearch[]'>";
		$qr= $DB->query("SELECT `id`, `name` FROM `".TB_PREFIX."t_research`");
		while( $row= $qr->fetch_array() ){
			$allresearch.="<option value='".$row['id']."' ".(($rresearchreq['reqresearch']==$row['id'])?"selected":"").">".$row['name']."</option>";
		}
		$allresearch.="</select>: <input type='text' name='levresearch[]' value='".$rresearchreq['lev']."' size='3'></nobr></div>";
	}
	
	$body.="<form method='post' action=''><input type='hidden' name='editbuild' value='".$building['id']."'>
	<div width='100%'><table border='1' width='100%'><tr>
		<td>
			<table border='0' class='tbleft'>
				<tr><td>Name:</td><td><input type='text' name='name' value='".$building['name']."' size='16'></td></tr>
				<tr><td>Image:</td><td><input type='text' name='img' value='".$building['img']."' size='16'></td></tr>
				<tr><td>Race:</td><td>".race_select($building['arac'])."</td></tr>
				<tr> <td>Produce:</td> <td>".produce_select($building['produceres'])."</td> </tr>
				<tr> <td>Function:</td> <td>".budfun_select($building['func'])."</td> </tr>
				<tr> <td>Max Lev:</td> <td><input type='text' name='maxlev' value='".$building['maxlev']."' size='3'></td> </tr>
			</table>
		</td>
		<td>
			".build_get_resoucecost($building['id'])."
		</td>
		
		<td><div id='allreqbud".$building['id']."'>$allbud</div>";
		
		$body.="<div id='cbudreq".$building['id']."' style='display:none;'><div><nobr><select name='reqbud[]'>";
		$qr= $DB->query("SELECT `id`, `name` FROM `".TB_PREFIX."t_builds` WHERE `id` != ".$building['id']);
		while( $row= $qr->fetch_array() ){
			$body.="<option value='".$row['id']."'>".$row['name']."</option>";
		}
		$body.="<option selected value='0'></option></select>: <input type='text' name='levbud[]' value='0' size='3'></nobr></div></div>
		<a onclick=\"AddMultiField('allreqbud".$building['id']."','cbudreq".$building['id']."')\">Add Building Requisite</a>";
		
		$body.="</td>
		
		<td><div id='allresearchbud".$building['id']."'>$allresearch</div>";
		
		$body.="<div id='cresearchreq".$building['id']."' style='display:none;'><div><nobr><select name='reqresearch[]'>";
		$qr= $DB->query("SELECT `id`, `name` FROM `".TB_PREFIX."t_research`");
		while( $row= $qr->fetch_array() ){
			$body.="<option value='".$row['id']."'>".$row['name']."</option>";
		}
		$body.="<option selected value='0'></option></select>: <input type='text' name='levresearch[]' value='0' size='3'></nobr></div></div>
		<a onclick=\"AddMultiField('allresearchbud".$building['id']."','cresearchreq".$building['id']."')\">Add Research Requisite</a>";
		
		$body.="</td>
		
		<td>
			<input type='image' src='../img/icons/b_edit.png' onclick='document.thisform.submit();'>
			
			<br> <a onclick=\"return confirm('Are you sure?');\" href='?pg=buildings&delbuild=".$building['id']."' > <img src='../img/icons/x.png'> </a>
		</td>
		
		</td></tr></table>
	<div></form>";
}
?>