<?php

// Si la constante n'est pas defini on bloque l'execution du fichier
if(!defined('PHPSIMUL_PAGES') || @PHPSIMUL_PAGES != 'PHPSIMULLL') 
{
die('Erreur 404 - Le fichier n\'a pas été trouvé');
}

/* PHPsimul : Créez votre jeu de simulation en PHP
Copyright (©) - 2007 - CAPARROS Sébastien (Camaris)

Codeur officiel: Camaris & Max485
http://forum.epic-arena.fr

Merci à  Xavier Langlois pour ce mod

Attention : Ce mod n'a pas été optimisé pour PHPSimul, il se peut donc qu'il surgisse certains bug
		Les seuls modifications apporté sont les URL du fichier agenda1.php & du CSS 
		Ainsi que le nom de la table qui a été mis en caracteres standard
*/

?>

	<style language="css" type="text/css">@import url("admin/tpl/style_agenda.css");</style>

	<script language="JavaScript">
		function popupCentree(nomFichier,largeur,hauteur)
		{   var top=(screen.height-hauteur)/2;
		   	var left=(screen.width-largeur)/2;
		    window.open(nomFichier,"","top="+top+",left="+left+",width="+largeur+",height="+hauteur+",resizable=no,menubar=no,scrollbars=no,statusbar=no");
		}
		function getContent(fonction, requete, etape,  destination){//alert ("fonction = "+fonction+"\n"+"requete = "+requete+"\n"+"etape = "+etape+"\n"+"destination = "+destination);
			var xhr_object = null; 
			if(window.XMLHttpRequest){ xhr_object = new XMLHttpRequest();}
			else if(window.ActiveXObject){ xhr_object = new ActiveXObject("Microsoft.XMLHTTP");}
			else{alert("Votre navigateur ne supporte pas les objets XMLHTTPRequest..."); return; } 
			xhr_object.open("GET", "" + requete + "", true); 
			xhr_object.onreadystatechange = function() { 
				switch(xhr_object.readyState){
					case 0:	alert("xhr_object.readyState = 0\nErreur, opération impossible !");infobulle = "<span class='msgError'>Erreur, opération impossible !";break;
					case 1:	infobulle = "<span class='msgOk'>Requête en cours.";break;
					case 2:	infobulle = "<span class='msgOk'>Données transférées.";break;
					case 3:	infobulle = "<span class='msgOk'>Affichage des données.";break;
					case 4:	infobulle = " ";
						str = xhr_object.responseText;
						//alert(myDecoding(str));
						if(!str){str = "~X~Aucune valeur retournée";}
						if(myDecoding(str).substring(0,3) == "~X~"){alert("Une erreur définie est survenue côté serveur !");str = myDecoding(str);document.formFile.content.value = str.substring(3, str.length);return;}
						if(destination){
							document.getElementById("" + destination + "").innerHTML = strf;
						}else{
							if(etape){
								strf = fonction + '(' + etape + ',"' + str + '")';
								eval(strf);
							}else{
								strf = fonction + '("' + str + '")';
								eval(strf);
							}
						}
					break;
				}
				document.getElementById("info_bulle").innerHTML = infobulle;
			} 
			xhr_object.send(null);
		} 
		coding_list = new Array([' ','~s~'],['\\n','~j~'],['\'','~dq~'],['"','~q~'],['°','~o~']);
		coding_list_count = coding_list.length;
		function myEncoding(str){
			for(i=0;i<coding_list_count;i++){
			   str = str.replace(RegExp(coding_list[i][0], 'g'), coding_list[i][1]);
			}
			return escape(str);
		}
		function myDecoding(str){
			str = unescape(str);
			str = str.replace(RegExp('~j~', 'g'), '\n'); 
			for(i=0;i<coding_list_count;i++){
			   str = str.replace(RegExp(coding_list[i][1], 'g'),coding_list[i][0]);
			}
			return str;
		}
		function showNotes(str){
			if(!str){
				getContent("showNotes", "admin/agenda1.php?function=getNotes");
			}else{
				strNotes = "<select class=\"lstFiles\" name=\"lstFiles\"size=\"10\" onChange=\"record_id=this.options[this.selectedIndex].value;showRecord();\">";
			 	strNotes += myDecoding(str);
				strNotes += "</select>";
				document.getElementById("notes").innerHTML = strNotes;
			}
		}
		function showContacts(str){
			if(!str){
				getContent("showContacts", "admin/agenda1.php?function=getContacts");
			}else{
				strContacts = "<select class=\"lstFiles\" name=\"lstFiles\"size=\"10\" onChange=\"record_id=this.options[this.selectedIndex].value;showRecord();\">";
			 	strContacts += myDecoding(str);
				strContacts += "</select>";
				document.getElementById("contacts").innerHTML = strContacts;
			}
		}
		var record_id = 0;
		function showRecord(str){
			if(!str){
				if((record_id == 0)||(record_id == "rien")){
					alert("Opération impossible !\n\n -:[ Enregistrement indéfini ]:-");
					return;
				}
				getContent("showRecord", "admin/agenda1.php?function=getRecord&id=" + record_id + "");
				record_id = 0;
			}else{
				record = new Array();
				eval(str);
				document.formFile.id.value = record['id'];
				document.formFile.type[record['type']].checked = true;
				document.formFile.title.value = myDecoding(record['titre']);
				document.formFile.content.value = myDecoding(record['contenu']);
				document.formFile.date_tache.value = record['date_tache'];
				if(record['type']==2){
					tab = record['date_tache'].split("-");
					document.getElementById("divDate").innerHTML = "A faire le " + Math.round(tab[2])+" "+mois[(Math.round(tab[1])-1)]+" "+tab[0];
				}
			}
		}
		function delRecord(str){
			if(!str){
				getContent("delRecord", "admin/agenda1.php?function=deleteRecord&id=" + record_id + "");
				record_id = 0;
			}else{
				document.formFile.content.value = myDecoding(str);
				loadRecords();
			}
		}
		function getType(){
			var nb = document.formFile.type.length;
			for(var i = 0 ; i < nb ; i ++){
				if (document.formFile.type[i].checked){
					return document.formFile.type[i].value;
				}
			}
		}
		function save(str) {
			if(!str){
				if(document.formFile.title.value == ""){
					alert("Opération impossible ! \n\n -:[ Titre manquant ]:-");
					return;
				}
				p = '&id=' + document.formFile.id.value + '';
				p += '&type=' + getType() + '';
				p += '&titre=' + myEncoding(document.formFile.title.value) + '';
				p += '&contenu=' + myEncoding(document.formFile.content.value) + '';
				p += '&date_tache=' + document.formFile.date_tache.value + '';
			}
			if(document.formFile.id.value){
				if(!str){
					getContent('save', 'admin/agenda1.php?function=updateRecord' + p + '');
				}else{
					document.formFile.content.value = myDecoding(str);
					loadRecords();
				}
			}else{
				if(!str){
					getContent('save', 'admin/agenda1.php?function=insertRecord' + p + '');
				}else{
					document.formFile.content.value = myDecoding(str);
					loadRecords();
				}
			}
			
		}
		date_taches = "";
		function setShowTaches(a,m,j){
			a = (a) ? a + "-" : "";
			m = (m) ? m + "-" : "";
			j = (j) ? j : "";
			date_taches = "" + a + m + j + "";
			showTaches();
		}
		function showTaches(str){
			if(!str){
				//alert(date_taches);
				if(date_taches == ""){date_taches = "2006";}
				getContent("showTaches", "admin/agenda1.php?function=getTasks&date_taches="+date_taches+"");
				date_taches = "";
			}else{
				strTaches = "<select class=\"lstFiles\" name=\"lstFiles\"size=\"10\" onChange=\"record_id=this.options[this.selectedIndex].value;showRecord();\">";
			 	strTaches += myDecoding(str);
				strTaches += "</select>";
				document.getElementById("taches").innerHTML = strTaches;
			}
		}
		ferie=new Array("01/01","01/05","08/05","14/07","15/08","01/11","11/11","25/12")
		mois=new Array("Janvier","Février","Mars","Avril","Mai","Juin","Juillet","Août","Septembre","Octobre","Novembre","Décembre")
		var maDate =new Date();
		function auhourdhui(){
			lemois = ((maDate.getMonth()+1)<10) ? "0"+(maDate.getMonth()+1) : maDate.getMonth()+1;
			lejour = (maDate.getDate()<10) ? "0"+maDate.getDate() : maDate.getDate();
			setShowTaches(maDate.getFullYear(), lemois, lejour);
			setCalendar("", "");
		}
		function doDay(a,m,j) {
			document.formFile.date_tache.value=""+a+"-"+m+"-"+j+"";
			lj = new Date(Math.round(a),(Math.round(m)-1),Math.round(j));
			document.formFile.type[2].checked = true;
			document.getElementById("divDate").innerHTML = "A faire le " + parseFloat(j)+" "+mois[(Math.round(m)-1)]+" "+a;
			setShowTaches(a,m,j);
		}
		function estFerie(j,m) {
			nb=ferie.length;
			for(i=0;i<nb;i++) {
				if ((ferie[i].substring(0,2)==j)&&(ferie[i].substring(3,5)==m)) return true;
			}
			return false
		}
		str_month_tasks = ""; str_m = ""; str_a = "";
		function setCalendar(m, a){
			str_m = m;
			str_a = a;
			if(str_m == "") {
				str_m = maDate.getMonth()+1;
				str_a = maDate.getFullYear();
			}
			if(Math.round(str_m)<10) str_m ="0"+ str_m;
			preCalendar(1);
		}
		function preCalendar(etape, str){
			if(!str){
				getContent("preCalendar", "admin/agenda1.php?function=getMonthString&date="+str_a + "-" + str_m, 1);
			}else{
				switch(etape){
					case 1:
						eval("str_month_tasks = '" + str + "';");
						calendar(str_m, str_a);
					break;
				}
			}
		}
		function checkTaches(a,m,j){
			ext = ""+ a + "-" + m +"-"+ j + "";
			return (str_month_tasks.indexOf(ext)>=0) ? true : false;
		}
		function calendar(m, a) {
			d_jour=new Date();
			d=new Date(a,m-1,1);
			dfin=new Date(a,m-1,1);
			nb_jour=31;
			aff_j="";
			for(var k=32;k>27;k--) {
				dfin.setMonth(m-1);
				dfin.setDate(k);
				if (dfin.getMonth()!=m-1) {nb_jour=k-1;}
			}
			j1=d.getDay();
			if (j1==0) j1=7;
			jour=0;
			str = "";
			lid="";
			str += "<TABLE border=0 cellspacing=0 cellpadding='2'>";
			month_ante = ((d.getMonth())<10)? "0"+(d.getMonth()) : d.getMonth() ;
			month_current = ((d.getMonth()+1)<10)? "0"+(d.getMonth()+1) : d.getMonth()+1 ;
			month_post = ((d.getMonth()+2)<10)? "0"+(d.getMonth()+2) : d.getMonth()+2 ;
			str += "<tr><td align='center' colspan='7'><input type=\"button\" value=\"-\"  onClick=\"calendar("+ month_ante +","+ a +")\" /><input type=\"button\" value=\""+mois[d.getMonth()]+"\" style=\"width:75px;\" onClick=\"setShowTaches('"+a+"','"+month_current+"');setCalendar("+month_current+", "+a+");\" /><input type=\"button\" value=\"+\" onClick=\"calendar("+ month_post +","+ a +")\" /></td></tr>";
			str += "<tr><td align='center' colspan='7'><input type=\"button\" value=\"-\" onClick=\"calendar("+ month_current +","+ (Math.round(a)-1) +")\" ><input type=\"button\" value=\""+a+"\" style=\"width:75px;\" onClick=\"setShowTaches('"+a+"');\" /><input type=\"button\" value=\"+\" onClick=\"calendar("+ month_current +","+ (Math.round(a)+1) +")\" /></td></tr>";
			str += "<TR><TD>L</TD><TD>M</TD><TD>M</TD><TD>J</TD><TD>V</TD><TD>S</TD><TD>D</TD></TR>";
			for(var i=0;i<6;i++) {
				str += "<TR>";
				for (var j=0;j<7;j++) {
					jour=7*i+j-j1+2;
					aff_j=jour;
					if ((jour==d_jour.getDate())&&(m==d_jour.getMonth()+1)){ lid="boutonToday";}else{ lid="";}
					if ((7*i+j>=j1-1)&&(jour<=nb_jour)) {
						lemois="";
						lejour="";
						if((d.getMonth()+1)<10) { lemois ="0"+(d.getMonth()+1);}else{ lemois = (d.getMonth()+1);}
						
						if(jour<10){lejour ="0"+jour;}else{lejour = jour;}
						
						laclass="boutonJ";
						if(checkTaches(a,lemois,lejour)){laclass="boutonJOQP";}
						if ((j==6)||(estFerie(jour,m))){
							str += "<TD bgcolor='#66FF66'><input type=\"button\" id=\""+lid+"\" class=\""+laclass+"\"  onClick=\"doDay('"+a+"','"+lemois+"','"+lejour+"');\"value=\""+aff_j+"\" />";
						}else {
							str += "<TD><input id=\""+lid+"\" class=\""+laclass+"\" type=\"button\" onClick=\"doDay('"+a+"','"+lemois+"','"+lejour+"');\" value=\""+aff_j+"\" />";
						}
					}
					else str += "<TD width='10'>&nbsp;</TD>";
				}
				str += "</TR>";
			}
			str += "</TABLE>";
			document.getElementById("divCalendar").innerHTML = str;
			document.formFile.title.focus();
		}
		function resetForm(){
			document.formFile.reset();
			document.formFile.id.value="";
			document.getElementById('content').innerHTML ="";;
			document.getElementById('divDate').innerHTML ="";
		}
		function loadRecords(){
			resetForm();
			showNotes();
			showContacts();
			auhourdhui();
		}
		function init(){
			//setCalendar(maDate.getMonth()+1, maDate.getFullYear());
			loadRecords();
		}
		function changeDate(flag){
			if(flag){
				lannee = maDate.getFullYear();
				lemois = ((maDate.getMonth()+1)<10) ? "0"+(maDate.getMonth()+1) : maDate.getMonth()+1;
				lejour = (maDate.getDate()<10) ? "0"+maDate.getDate() : maDate.getDate();
				document.formFile.date_tache.value=""+lannee+"-"+lemois+"-"+lejour+"";
				document.getElementById("divDate").innerHTML = "A faire le " + Math.round(lejour)+" "+mois[(Math.round(lemois)-1)]+" "+lannee;
			}else{
				document.formFile.date_tache.value="0000-00-00";
				document.getElementById("divDate").innerHTML = "";
			}
		}
	</script>


<body onLoad="loadRecords();">

<div class="classCalendrier"><br><br><br><br><br><br>
<center>
	<div id="divCalendar"></div>
	<form>
		<span id="taches"><select class="lstFiles" size="10"><option value="rien" disabled>Attente des données</option></select></span><br>
		<input class="cmdDel" type="button" value="Supprimer" onClick="if(this.form.lstFiles.selectedIndex!=(-1)){record_id = this.form.lstFiles.options[this.form.lstFiles.selectedIndex].value;delRecord();}" />
	</form>
</center>
</div>
<div class="classNotes"><br><br><br><br><br><br>
	<center>
		<form>
			<span id="notes"><select class="lstFiles" size="10"><option value="rien" disabled>Attente des données</option></select></span><br>
			<input class="cmdDel" type="button" value="Supprimer la note" onClick="if(this.form.lstFiles.selectedIndex!=(-1)){record_id = this.form.lstFiles.options[this.form.lstFiles.selectedIndex].value;delRecord();}" />
		</form>
		<form>
			<span id="contacts"><select class="lstFiles" size="10"><option value="rien" disabled>Attente des données</option></select></span><br>
			<input type="button" class="cmdDel" value="Supprimer le contact" onClick="if(this.form.lstFiles.selectedIndex!=(-1)){record_id=this.form.lstFiles.options[this.form.lstFiles.selectedIndex].value;delRecord();}" />
		</form>
	</center>
</div>
<div class="classFichier"><br><br><br><br><br><br>
	<form name="formFile">
		<center>
			<input type="hidden" value="" name="id" />
			<input type="hidden" value="0000-00-00" size="10" name="date_tache" />
			<input type="text" value="" name="title" size="35" maxlength="100" /><br><br>
		</center>
			<input type="radio" name="type" value="0" onChange="changeDate(false);" checked><label for="radio1">Note</label>&nbsp;&nbsp;
			<input type="radio" name="type" value="1" onChange="changeDate(false);"><label for="radio2">Contact</label>	
			<input type="radio" name="type" value="2" onChange="changeDate(true);"><label for="radio0">Tâche. </label><span id="divDate" onClick=""></span><br /><br />
		<center>
			<textarea id="content" name="content" cols="50" rows="19" wrap="off"> </textarea><br>
			<input type="reset" value="Nouveau" onClick="resetForm();" />
			<input type="button" name="cmdCreate" value="Enregistrer" onClick="save();calendar(maDate.getMonth() + 1, maDate.getFullYear());" />
			<input type="button" onClick="showTaches();" value="test" />
		</center>
	</form>
</div>

<div id="info_bulle"></div>
</body>
</html>