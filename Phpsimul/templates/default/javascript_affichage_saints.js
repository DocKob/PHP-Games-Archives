var mm;
var today= new Date();
var smonth= 1+(today.getMonth());
if (smonth==1)
{
	mm= new Array("Jour de l'An","Bazile","Genevi�ve","Odilon","Edouard","M�laine","Raymond","Lucien","Alix","Guillaume","Paulin","Tatiana","Yvette","Nina","R�mi","Marcel","Roseline","Prisca","Marius","S�bastien","Agn�s","Vincent","Barnard","Fran�ois de Sales","Conversion de St.Paul","Paule","Ang�le","Thomas d'Aquin","Gildas","Martine","Marcelle");
}
if (smonth==2) 
{
	mm= new Array("Ella","Pr�sentation du Seigneur","Blaise","V�ronique","Agathe","Gaston","Eug�nie","Jacqueline","Apolline","Arnaud","N.D de Lourdes","F�lix","B�atrice","Valentin","Claude","Julienne","Alexis","Bernadette","Gabin","Aim�e","Pierre-Damien","Isabelle","Lazare","Modeste","Rom�o","Nestor","Honorine","Romain","");
}
if (smonth==3) 
{
	mm= new Array("Aubin","Charles le Bon","Gu�nol�","Casimir","Olive","Colette","F�licit�","Jean de Dieu","Fran�oise","Vivien","Rosine","Justine","Rodrigue","Mathilde","Louise","B�n�dicte","Patrice","Cyrille","Joseph","Herbert","Cl�mence","L�a","Victorien","Catherine de Su�de","Humbert","larissa","Habib","Gontran","Gwladys","Am�d�e","Benjamin");
}
if (smonth==4) 
{
	mm= new Array("Hugues","Sandrine","Richard","Isidore","Ir�ne","Marcellin","St J.B. de la salle","Julie","Gautier","Fulbert","Stanislas","Jules","Ida","Maxime","Paterne","Benoit-Jos�","Anicet","Parfait","Emma","Odette","Anselme","Georges","Fid�le","Marc","Alida","Zita","Val�rie","Cath. de Sienne","Robert");
}
if (smonth==5) 
{
	mm= new Array("F�te du Travail","Boris","Jacques Philippe","Sylvain","Judith","Prudence","Gis�le","xxxx","Pac�me","Solange","Estelle","Achille","Rolande","Matthias","Denise","Honor�","Pascal","Eric","Yves","Roxane & Bernardin","Constantin","Emile","Didier","Donatien","Sophie","B�renger","Auguste de Cant.","Germain","Aymar","Ferdinand","Visitation");
}
if (smonth==6) 
{
	mm= new Array("Justin","Blandine","K�vin","Clotilde","Igor","Norbert","Gilbert","M�dard","Diane","Landry","Barnab�","Guy","Antoine de Padou","Elis�e","Germaine","Jean-Fran�ois-R�gis","Herv�","L�once","Romuald","Silv�re","Rodolphe","Alban","Audrey","Jean-Baptiste","Prosper","Anthelme","Fernand","Ir�n�e","StPierre/Paul","Martial");
}
if (smonth==7) 
{
	mm= new Array("Thierry","Martinien","Thomas","Florent","Antoine-Marie","Marietta","Raoul","Thibaut","Amandine","Ulrich","Beno�t","Olivier","Henri/Joel","F�te Nationale","Donald","N.D Mont Carmel","Charlotte","Fr�d�ric","Ars�ne","Marina","Victor","Marie-Madeleine","Brigitte","Christine","Jacques le Majeur","Anne","Nathalie","Samson","Marthe","Juliette","Ignace de Loyola");
}
if (smonth==8) 
{
	mm= new Array("Alphonse","Julien","Lydie","J.M. Vianney","Abel","Transfiguration","Ga�tan","Dominique","Amour","Laurent","Claire","Clarisse","Hippolyte","Evrard","Assomption","Armel","Hyacinthe","H�l�ne","Jean-Eudes","Bernard","Christophe","Fabrice","Rose","Barth�l�my","Louis","Natacha","Monique","Augustin","Sabine","Fiacre","Aristide");
}
if (smonth==9) 
{
	mm= new Array("Gilles","Ingrid","Gregoire","Rosalie","Ra�ssa","Bertrand","Reine","Nativit� de N.D.","Alain","In�s","Adelphe","Apollinaire","Aim�","Ste Croix","Roland","Edith","Renaud","Nad�ge","Emilie","Davy","Matthieu","Maurice","Constant","Th�cle","Hermann","C�me/Damien","Vincent de Paul","Venceslas","Michel","Jer�me");
}
if (smonth==10) 
{
	mm= new Array("Th�r�se de l'E.J.","Leger","G�rard","Fran�ois d'Assise","Fleur","Bruno","Serge","P�lagie","Denis","Ghislain","Firmin","Wilfried","G�raud","Juste","Th�r�sa","Edwige","Baudouin","Luc","Ren�","Adeline","C�line","Elodie","Jean de Capistran","Florentin","Doria","Dimitri","Emeline","Simon","Narcisse","Bienvenue","Wolfgang");
}
if (smonth==11) 
{
	mm= new Array("Toussaint","D�funts","Hubert","Charles Bor.","Sylvie","Bertille","Carine","Geoffroy","Th�odore","L�on","Armistice","Christian","Brice","Sidoine","Albert","Marguerite","Elisabeth","Aude","Tanguy","Edmond","Christ Roi","C�cile","Cl�ment","Flora","Catherine","Delphine","S�verin","Avent","Saturnin","Andr�");}
if (smonth==12) 
{
	mm= new Array("Florence","Viviane","Fran�ois-Xavier","Barbara","G�rald","NiColas","Ambroise","Immacul�e Conception","Pierre Fourier","Romaric","Daniel","Chantal","Lucie","Odile","Ninon","Alice","Judica�l","Gatien","Urbain","Th�ophile","Pierre Canisius","Fran�oise-Xavi�re","Armand","Ad�le","No�l","Etienne","Jean l'Ap�tre","Innocents","David","Roger","Sylvestre");
}

//------------------------
var sday= (today.getDate())-1;
//alert(mm[sday]) ;

document.write(mm[sday]) ;