
<body>
<script type="text/javascript">
    function galaxy_submit(value) {
      document.getElementById('auto').name = value;
      document.getElementById('galaxy_form').submit();
    }

    function fenster(target_url,win_name) {
      var new_win = window.open(target_url,win_name,'resizable=yes,scrollbars=yes,menubar=no,toolbar=no,width=640,height=480,top=0,left=0');
new_win.focus();
    }
  </script>
<script type="text/javascript" src="scripts/tw-sack.js"></script>
<script type="text/javascript">
var ajax = new sack();
var strInfo = "";

function whenLoading(){
  //var e = document.getElementById('fleetstatus');
  //e.innerHTML = "<?php echo $this->getData('Sending_fleet')?>";
}

function whenLoaded(){
  //    var e = document.getElementById('fleetstatus');
  // e.innerHTML = "<?php echo $this->getData('Sent_fleet')?>";
}

function whenInteractive(){
  //var e = document.getElementById('fleetstatus');
  // e.innerHTML = "<?php echo $this->getData('Obtaining_data')?>";
}

/*
   We can overwrite functions of the sack object easily. :-)
   This function will replace the sack internal function runResponse(),
   which normally evaluates the xml return value via eval(this.response).
*/

function whenResponse(){

 /*
 *
 *  600   OK
 *  601   no planet exists there
 *  602   no moon exists there
 *  603   player is in noob protection
 *  604   player is too strong
 *  605   player is in u-mode
 *  610   not enough espionage probes, sending x (parameter is the second return value)
 *  611   no espionage probes, nothing send
 *  612   no fleet slots free, nothing send
 *  613   not enough deuterium to send a probe
 *
 */

  // the first three digit long return value
  retVals = this.response.split(" ");
  // and the other content of the response
  // but since we only got it if we can send some but not all probes
  // theres no need to complicate things with better parsing
  // each case gets a different table entry, no language file used :P
  switch(retVals[0]) {
  case "600":
    addToTable("done", "success");
        changeSlots(retVals[1]);
    setShips("probes", retVals[2]);
    setShips("recyclers", retVals[3]);
    setShips("missiles", retVals[4]);
        break;
  case "601":
    addToTable("<?php echo $this->getData('an_error_has_happened_while_it_was_sent')?>", "error");
    break;
  case "602":
    addToTable("<?php echo $this->getData('error_there_is_no_moon')?>", "error");
    break;
  case "603":
    addToTable("<?php echo $this->getData('error_the_player_is_under_the_protection_of_beginners')?>", "error");
    break;
  case "604":
    addToTable("<?php echo $this->getData('error_the_player_is_too_strong')?>", "error");
    break;
  case "605":
    addToTable("Nie mozna skanowac graczy bedacych na urlopie", "vacation");
    break;
  case "610":
    addToTable("<?php echo $this->getData('error_only_x_available_probes_sending')?>", "notice");
    break;
  case "611":
    addToTable("Brak sond szpiegowskich", "error");
    break;
  case "612":
    addToTable("Osiagnieta maksymalna ilosc flot", "error");
    break;
  case "613":
    addToTable("Masz za malo deuteru", "error");
    break;
  case "614":
    addToTable("Nie mozna skanowac planety nie skolonizowanej", "error");
    break;
  case "615":
    addToTable("<?php echo $this->getData('error_there_is_no_sufficient_fuel')?>", "error");
    break;
  case "616":
    addToTable("Multialarm!", "error");
    break;
  case "617":
	addToTable("Nie masz recyklerow", "error");
  break;
  }
}

function doit(order, galaxy, system, planet, planettype, shipcount){
  	if(order==2)
	strInfo = "Wysylanie "+shipcount+" "+(shipcount>1?"sond":"sondy")+" na "+galaxy+":"+system+":"+planet+"...";
   if(order==8)
	strInfo = "Wysylanie "+shipcount+" "+(shipcount>1?"recykler":"recyklerow")+" na "+galaxy+":"+system+":"+planet+"...";

    ajax.requestFile = "floten3.php?action=send";

    // no longer needed, since we don't want to write the cryptic
    // response somewhere into the output html
    //ajax.element = 'fleetstatus';
    //ajax.onLoading = whenLoading;
    //ajax.onLoaded = whenLoaded;
    //ajax.onInteractive = whenInteractive;

    // added, overwrite the function runResponse with our own and
    // turn on its execute flag
    ajax.runResponse = whenResponse;
    ajax.execute = true;

    ajax.setVar("thisgalaxy", <?php echo $this->getData('tg')?>)
    ajax.setVar("thissystem", <?php echo $this->getData('ts')?>);
    ajax.setVar("thisplanet", <?php echo $this->getData('tp')?>);
    ajax.setVar("thisplanettype", <?php echo $this->getData('tpt')?>);
    ajax.setVar("speed210", 1000000000);
    ajax.setVar("speed209", 2000);
    ajax.setVar("mission", order);
    ajax.setVar("galaxy", galaxy);
    ajax.setVar("system", system);
    ajax.setVar("planet", planet);
    ajax.setVar("speedfactor", 1000);
    ajax.setVar("planettype", planettype);
    ajax.setVar("z_gali", 1);
    if(order==2)
    ajax.setVar("ship210", shipcount);
    if(order==8)
    ajax.setVar("ship209", shipcount);

    ajax.setVar("speed", 10);
    //ajax.setVar("reply", "short");
    ajax.runAJAX();

}

/*
 * This function will manage the table we use to output up to three lines of
 * actions the user did. If there is no action, the tr with id 'fleetstatusrow'
 * will be hidden (display: none;) - if we want to output a line, its display
 * value is cleaned and therefore its visible. If there are more than 2 lines
 * we want to remove the first row to restrict the history to not more than
 * 3 entries. After using the object function of the table we fill the newly
 * created row with text. Let the browser do the parsing work. :D
 */
function addToTable(strDataResult, strClass) {
  var e = document.getElementById('fleetstatusrow');
  var e2 = document.getElementById('fleetstatustable');

  // make the table row visible
  e.style.display = '';

  if(e2.rows.length > 2) {
    e2.deleteRow(2);
  }

  var row = e2.insertRow('test');

  var td1 = document.createElement("td");
  var td1text = document.createTextNode(strInfo);
  td1.appendChild(td1text);

  var td2 = document.createElement("td");

  var span = document.createElement("span");
  var spantext = document.createTextNode(strDataResult);

  var spanclass = document.createAttribute("class");
  spanclass.nodeValue = strClass;
  span.setAttributeNode(spanclass);

  span.appendChild(spantext);
  td2.appendChild(span);

  row.appendChild(td1);
  row.appendChild(td2);
}

function changeSlots(slotsInUse) {
  var e = document.getElementById('slots');
  e.innerHTML = slotsInUse;
}

function setShips(ship, count) {
  var e = document.getElementById(ship);
  e.innerHTML = count;
}

</script>


<br><br>
<center>

<form action="" method="post" id="galaxy_form">
<input id="auto" value="dr" type="hidden">
<table border="0">
  <tr>
    <td>
      <table>
        <tbody><tr>
         <td class="c" colspan="3"><?php echo $this->getData('Galaxy')?></td>
        </tr>
        <tr>
          <td class="l"><input name="galaxyLeft" value="&lt;-" onClick="galaxy_submit('galaxyLeft')" type="button"></td>
          <td class="l"><input name="galaxy" value="<?php echo $this->getData('galaxy')?>" size="5" maxlength="3" tabindex="1" type="text">
          </td><td class="l"><input name="galaxyRight" value="-&gt;" onClick="galaxy_submit('galaxyRight')" type="button"></td>
        </tr>
       </tbody></table>
      </td>
      <td>
       <table>
        <tbody><tr>
         <td class="c" colspan="3"><?php echo $this->getData('Solar_system')?></td>
        </tr>
         <tr>
          <td class="l"><input name="systemLeft" value="&lt;-" onClick="galaxy_submit('systemLeft')" type="button"></td>
          <td class="l"><input name="system" value="<?php echo $this->getData('system')?>" size="5" maxlength="3" tabindex="2" type="text">
          </td><td class="l"><input name="systemRight" value="-&gt;" onClick="galaxy_submit('systemRight')" type="button"></td>
         </tr>
        </tbody></table>
       </td>
      </tr>
      <tr>
        <td colspan="2" align="center"> <input value="<?php echo $this->getData('Show')?>" type="submit"></td>
      </tr>
     </tbody></table>
</form>
   <table width="569">
<tbody><tr>
	<td class="c" colspan="8"><?php echo $this->getData('Solar_system_at')?></td>
	</tr>
	<tr>
	  <td class="c"><?php echo $this->getData('Pos')?></td>
	  <td class="c"><?php echo $this->getData('Planet')?></td>
	  <td class="c"><?php echo $this->getData('Name')?></td>
	  <td class="c"><?php echo $this->getData('Moon')?></td>
	  <td class="c"><?php echo $this->getData('Debris')?></td>
	  <td class="c"><?php echo $this->getData('Player')?> (<?php echo $this->getData('State')?>)</td>
	  <td class="c"><?php echo $this->getData('Alliance')?></td>
	  <td class="c"><?php echo $this->getData('Actions')?></td>
	</tr>
    <?php echo $this->getData('echo_galaxy')?>
	<tr>
	  <td class="c" colspan="6"><table width="100%" cellpadding="0" cellspacing="0"><td><?php echo $this->getData('deuter')?></td><td><?php echo $this->getData('rec')?></td><td><?php echo $this->getData('ss')?></td><td><?php echo $this->getData('planetcount')?></td><td>Sloty <span id="slots"><?php echo $this->getData('wolne')?></span> z <?php echo $this->getData('zajete')?></td></table></td>
	  <td class="c" colspan="2"><a href="#" onmouseover="this.T_WIDTH=150;return escape('<table><tr><td class=\'c\' colspan=\'2\'><?php echo $this->getData('Legend')?></td></tr><tr><td width=\'125\'><?php echo $this->getData('Strong_player')?></td><td><span class=\'strong\'>f</span></td></tr><tr><td><?php echo $this->getData('Weak_player')?></td><td><span class=\'noob\'>d</span></td></tr><tr><td><?php echo $this->getData('Way_vacation')?></td><td><span class=\'vacation\'>v</span></td></tr><tr><td><?php echo $this->getData('Pendent_user')?></td><td><span class=\'banned\'>s</span></td></tr><tr><td><?php echo $this->getData('Inactive_7_days')?></td><td><span class=\'inactive\'>i</span></td></tr><tr><td><?php echo $this->getData('Inactive_28_days')?></td><td><span class=\'longinactive\'>I</span></td></tr><tr><td>Admin</td><td><span class=\'espionagereport\'>A</span></td></tr></table>')"><?php echo $this->getData('Legend')?></a></td>
	</tr>
	<tr>
	</tr>
	<tr style="display: none; align:left" id="fleetstatusrow">
	  <th colspan="8"><div style="align:left" id="fleetstatus"></div>
		<table style="font-weight: bold; align:left" id="fleetstatustable" width="100%">
		</table>
	  </th>
	</tr>
</table>

</center> <!-- OH MY GOD! --->

<script type="text/javascript" src="scripts/wz_tooltip.js"></script>
