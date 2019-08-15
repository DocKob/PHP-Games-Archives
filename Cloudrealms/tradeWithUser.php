<?
///////////////////////////////////////////////////////////////////////////////////
// cloudRealms Web MMORPG Game Engine                                             /
// Description: cloudRealms is a web based game engine that allows game           /
// developers to easily design and deploy 2D web based social MMORPG games.       /
///////////////////////////////////////////////////////////////////////////////////
// Distributor: Verdis Technologies                                               /
// Website: www.verdisx.com                                                       / 
///////////////////////////////////////////////////////////////////////////////////
// Author: Ronald A. Richardson                                                   /
// Website: www.ronaldarichardson.com                                             /
// Email: theprestig3@gmail.com                                                   /
///////////////////////////////////////////////////////////////////////////////////
// File: tradeWithUser.php                                                        /
// Modified: 6/13/2011                                                            /
///////////////////////////////////////////////////////////////////////////////////
// This file is part of cloudRealms.                                              /
//                                                                                /
// cloudRealms is free software: you can redistribute it and/or modify            /
// it under the terms of the GNU Affero General Public License as published by    /
// the Free Software Foundation, either version 3 of the License, or              /
// (at your option) any later version.                                            /
//                                                                                /
// cloudRealms is distributed in the hope that it will be useful,                 /
// but WITHOUT ANY WARRANTY; without even the implied warranty of                 /
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the                  /
// GNU Affero General Public License for more details.                            /
//                                                                                /
// You should have received a copy of the GNU Affero General Public License       /
// along with cloudRealms.  If not, see <http://www.gnu.org/licenses/>.           /
///////////////////////////////////////////////////////////////////////////////////

include('includes/connect.php');
include('classes/mmorpg.class.php');
$mmorpg = new MMORPG();
include('classes/inventory.class.php');
$inventory = new Inventory();
include('classes/trader.class.php');
$trader = new Trader();
include('classes/social.class.php');
$social = new Social();
$g = $_GET[g];
$t = $_GET[t];
if($_GET[hub]){
	$social->loadHeader();
	$social->displayHubMenu($g);
}
$tradeid = $trader->tradeid();
if($_COOKIE[tradeid]=='')
{
	setcookie("tradeid",$tradeid, time()+3600*24);
}
echo "<h3>Your trade ID for this transaction: ";
if($_COOKIE[tradeid]!='')
{
	echo $_COOKIE[tradeid];
} else {
	echo $tradeid;
}
echo "</h3>";
include('interface/loadUI.php');
$giver = $mmorpg->getCharacter($g);
$taker = $mmorpg->getCharacter($t);
?>
<style>
#draggable0 { width: 42px; height: 42px; padding: 0.5em; float:left; margin: 0px 10px 10px 0; }
#draggable1 { width: 42px; height: 42px; padding: 0.5em; float:left; margin: 0px 10px 10px 0; }
#draggable2 { width: 42px; height: 42px; padding: 0.5em; float:left; margin: 0px 10px 10px 0; }
#draggable3 { width: 42px; height: 42px; padding: 0.5em; float:left; margin: 0px 10px 10px 0; }
#draggable4 { width: 42px; height: 42px; padding: 0.5em; float:left; margin: 0px 10px 10px 0; }
#draggable5 { width: 42px; height: 42px; padding: 0.5em; float:left; margin: 0px 10px 10px 0; }
#draggable6 { width: 42px; height: 42px; padding: 0.5em; float:left; margin: 0px 10px 10px 0; }
#draggable7 { width: 42px; height: 42px; padding: 0.5em; float:left; margin: 0px 10px 10px 0; }
#draggable8 { width: 42px; height: 42px; padding: 0.5em; float:left; margin: 0px 10px 10px 0; }
#draggable9 { width: 42px; height: 42px; padding: 0.5em; float:left; margin: 0px 10px 10px 0; }
#draggable10 { width: 42px; height: 42px; padding: 0.5em; float:left; margin: 0px 10px 10px 0; }
#draggable11 { width: 42px; height: 42px; padding: 0.5em; float:left; margin: 0px 10px 10px 0; }
#draggable12 { width: 42px; height: 42px; padding: 0.5em; float:left; margin: 0px 10px 10px 0; }
#target { width: 300px; height: 200px; padding: 0.5em; float: left;}
.item {border: 1px #DEDEDE solid;cursor:move;}
.drop {border: 1px #DEDEDE solid;background:#C4C4C4;}
.drop_highlight {border: 1px #DEDEDE solid;background:#F2FF66;}
.process {margin:10px;}
.trade_result {padding:10px;margin:20px;color:#fff;background:#1DE602;}
</style>
<script>
$(function() {
	$( "#draggable0" ).draggable();
	$( "#draggable1" ).draggable();
	$( "#draggable2" ).draggable();
	$( "#draggable3" ).draggable();
	$( "#draggable4" ).draggable();
	$( "#draggable5" ).draggable();
	$( "#draggable6" ).draggable();
	$( "#draggable7" ).draggable();
	$( "#draggable8" ).draggable();
	$( "#draggable9" ).draggable();
	$( "#draggable10" ).draggable();
	$( "#draggable11" ).draggable();
	$( "#draggable12" ).draggable();
	$( "#target" ).droppable({
		drop: function( event, ui ) {
			$.post( "do/addItemToQueue.php?trade=<? echo $_COOKIE[tradeid]; ?>&item="+item+"&slot="+slot+"" )
			$( this )
			.addClass( "drop_highlight" )
			.find( "p" )
				.html( "Items in trade pile" );
		}
	});
	$( "#target" ).droppable({
		out: function(event, ui) { 
			$( this )
			.find( "p" )
				.html( "Add another item to the trade pile" );
		}
	});
});
$('#target').mouseout(function() {
	$(this).addClass("drop");
});
var auto_refresh = setInterval(function ()
{
	$('#trade_queue').load('viewer/tradeQueue.php?id=<? echo $_COOKIE[tradeid]; ?>').fadeIn("slow");
}, 1000); // refresh interval
function process_trade()
{	
	$.post("do/processTrade.php?trade=<? echo $_COOKIE[tradeid]; ?>&giver=<? echo $giver[id]; ?>&taker=<? echo $taker[id]; ?>");
	$('#trade_result').html("<br><br><span class='trade_result'>Trade completed!</span>");
	setCookie("tradeid", "", 1);
	setInterval(function ()
	{
		location.reload(true);
	}, 1000);
}
function setCookie(c_name,value,exdays)
{
	var exdate=new Date();
	exdate.setDate(exdate.getDate() + exdays);
	var c_value=escape(value) + ((exdays==null) ? "" : "; expires="+exdate.toUTCString());
	document.cookie=c_name + "=" + c_value;
}
</script>
<div class="trade_interface" style="width:300px;float:left;">
<?
$slot = $inventory->load_inventory($giver[inventory]);
for($y=0;$y < count($slot);$y++)
{
	$_slot = "slot".$y;
	?>
		<div id="draggable<? echo $y; ?>" class="item" onmousedown="item='<? echo $inventory->item_id($slot[$y]); ?>';slot='<? echo $_slot; ?>';"><img src="<? echo $inventory->item_img($slot[$y]); ?>" width="42px" height="42px"></div>
	<?
}
?>
<input type="submit" value="Process trade between you and <? echo $taker[name]; ?>" onclick="process_trade();">
<div id="trade_result"></div>
</div>
<div id="target" class="drop" onmouseout="this.className='drop'"><p>Drop the items you want to trade here</p></div>
<div style="border:1px #000 solid;float:left;width:300px;height:200px;margin-left:20px;padding:0.5em;overflow-y:scroll;">
<p>Items to be traded:</p>
<div id="trade_queue"></div>
</div>


