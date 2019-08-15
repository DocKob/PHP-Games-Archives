var mm;
var today= new Date();
var smonth= 1+(today.getMonth());
if (smonth==1)
{
	mm= new Array("Jour de l'An","Bazile","Geneviève","Odilon","Edouard","Mélaine","Raymond","Lucien","Alix","Guillaume","Paulin","Tatiana","Yvette","Nina","Rémi","Marcel","Roseline","Prisca","Marius","Sébastien","Agnès","Vincent","Barnard","François de Sales","Conversion de St.Paul","Paule","Angèle","Thomas d'Aquin","Gildas","Martine","Marcelle");
}
if (smonth==2) 
{
	mm= new Array("Ella","Présentation du Seigneur","Blaise","Véronique","Agathe","Gaston","Eugénie","Jacqueline","Apolline","Arnaud","N.D de Lourdes","Félix","Béatrice","Valentin","Claude","Julienne","Alexis","Bernadette","Gabin","Aimée","Pierre-Damien","Isabelle","Lazare","Modeste","Roméo","Nestor","Honorine","Romain","");
}
if (smonth==3) 
{
	mm= new Array("Aubin","Charles le Bon","Guénolé","Casimir","Olive","Colette","Félicité","Jean de Dieu","Françoise","Vivien","Rosine","Justine","Rodrigue","Mathilde","Louise","Bénédicte","Patrice","Cyrille","Joseph","Herbert","Clémence","Léa","Victorien","Catherine de Suède","Humbert","larissa","Habib","Gontran","Gwladys","Amédée","Benjamin");
}
if (smonth==4) 
{
	mm= new Array("Hugues","Sandrine","Richard","Isidore","Irène","Marcellin","St J.B. de la salle","Julie","Gautier","Fulbert","Stanislas","Jules","Ida","Maxime","Paterne","Benoit-José","Anicet","Parfait","Emma","Odette","Anselme","Georges","Fidèle","Marc","Alida","Zita","Valérie","Cath. de Sienne","Robert");
}
if (smonth==5) 
{
	mm= new Array("Fête du Travail","Boris","Jacques Philippe","Sylvain","Judith","Prudence","Gisèle","xxxx","Pacôme","Solange","Estelle","Achille","Rolande","Matthias","Denise","Honoré","Pascal","Eric","Yves","Roxane & Bernardin","Constantin","Emile","Didier","Donatien","Sophie","Bérenger","Auguste de Cant.","Germain","Aymar","Ferdinand","Visitation");
}
if (smonth==6) 
{
	mm= new Array("Justin","Blandine","Kévin","Clotilde","Igor","Norbert","Gilbert","Médard","Diane","Landry","Barnabé","Guy","Antoine de Padou","Elisée","Germaine","Jean-François-Régis","Hervé","Léonce","Romuald","Silvère","Rodolphe","Alban","Audrey","Jean-Baptiste","Prosper","Anthelme","Fernand","Irénée","StPierre/Paul","Martial");
}
if (smonth==7) 
{
	mm= new Array("Thierry","Martinien","Thomas","Florent","Antoine-Marie","Marietta","Raoul","Thibaut","Amandine","Ulrich","Benoît","Olivier","Henri/Joel","Fête Nationale","Donald","N.D Mont Carmel","Charlotte","Frédéric","Arsène","Marina","Victor","Marie-Madeleine","Brigitte","Christine","Jacques le Majeur","Anne","Nathalie","Samson","Marthe","Juliette","Ignace de Loyola");
}
if (smonth==8) 
{
	mm= new Array("Alphonse","Julien","Lydie","J.M. Vianney","Abel","Transfiguration","Gaétan","Dominique","Amour","Laurent","Claire","Clarisse","Hippolyte","Evrard","Assomption","Armel","Hyacinthe","Hélène","Jean-Eudes","Bernard","Christophe","Fabrice","Rose","Barthélémy","Louis","Natacha","Monique","Augustin","Sabine","Fiacre","Aristide");
}
if (smonth==9) 
{
	mm= new Array("Gilles","Ingrid","Gregoire","Rosalie","Raïssa","Bertrand","Reine","Nativité de N.D.","Alain","Inès","Adelphe","Apollinaire","Aimé","Ste Croix","Roland","Edith","Renaud","Nadège","Emilie","Davy","Matthieu","Maurice","Constant","Thècle","Hermann","Côme/Damien","Vincent de Paul","Venceslas","Michel","Jerôme");
}
if (smonth==10) 
{
	mm= new Array("Thérèse de l'E.J.","Leger","Gérard","François d'Assise","Fleur","Bruno","Serge","Pélagie","Denis","Ghislain","Firmin","Wilfried","Géraud","Juste","Thérésa","Edwige","Baudouin","Luc","René","Adeline","Céline","Elodie","Jean de Capistran","Florentin","Doria","Dimitri","Emeline","Simon","Narcisse","Bienvenue","Wolfgang");
}
if (smonth==11) 
{
	mm= new Array("Toussaint","Défunts","Hubert","Charles Bor.","Sylvie","Bertille","Carine","Geoffroy","Théodore","Léon","Armistice","Christian","Brice","Sidoine","Albert","Marguerite","Elisabeth","Aude","Tanguy","Edmond","Christ Roi","Cécile","Clément","Flora","Catherine","Delphine","Séverin","Avent","Saturnin","André");}
if (smonth==12) 
{
	mm= new Array("Florence","Viviane","François-Xavier","Barbara","Gérald","NiColas","Ambroise","Immaculée Conception","Pierre Fourier","Romaric","Daniel","Chantal","Lucie","Odile","Ninon","Alice","Judicaël","Gatien","Urbain","Théophile","Pierre Canisius","Françoise-Xavière","Armand","Adèle","Noël","Etienne","Jean l'Apôtre","Innocents","David","Roger","Sylvestre");
}

//------------------------
var sday= (today.getDate())-1;
//alert(mm[sday]) ;

document.write(mm[sday]) ;