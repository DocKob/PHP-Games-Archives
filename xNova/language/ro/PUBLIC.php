<?php

/**
 _  \_/ |\ | /¯¯\ \  / /\    |¯¯) |_¯ \  / /¯¯\ |  |   |´¯|¯` | /¯¯\ |\ |5
 ¯  /¯\ | \| \__/  \/ /--\   |¯¯\ |__  \/  \__/ |__ \_/   |   | \__/ | \|Core.
 * @author: Copyright (C) 2011 by Brayan Narvaez (Prinick) developer of xNova Revolution
 * @link: http://www.xnovarevolution.con.ar

 * @package 2Moons
 * @author Slaver <slaver7@gmail.com>
 * @copyright 2009 Lucky <douglas@crockford.com> (XGProyecto)
 * @copyright 2011 Slaver <slaver7@gmail.com> (Fork/2Moons)
 * @license http://www.gnu.org/licenses/gpl.html GNU GPLv3 License
 * @version 1.3 (2011-01-21)
 * @link http://code.google.com/p/2moons/

 * Please do not remove the credits
*/

//general
$LNG['index']				= 'Index';
$LNG['register']			= 'Registru';
$LNG['forum']				= 'Forum';
$LNG['send']				= 'Aceptă';
$LNG['menu_index']			= 'Acasă';
$LNG['menu_news']			= 'Stiri';
$LNG['menu_rules']			= 'Reguli';
$LNG['menu_agb']			= 'T&C'; 
$LNG['menu_pranger']		= 'Banati';
$LNG['menu_top100']		    = 'Salon de Faimă';
$LNG['menu_disclamer']		= 'Contact';
$LNG['uni_closed']			= '(offline)';
	 
/* ------------------------------------------------------------------------------------------ */

$LNG['music_off']			= 'Muzică: OFF';
$LNG['music_on']			= 'Muzică: ON';


//index.php
//case lostpassword
$LNG['mail_not_exist'] 		    = 'Adresa de email nu există!';
$LNG['mail_title']				= 'Parolă nouă';
$LNG['mail_text']				= 'Noua parolă este: ';
$LNG['mail_sended']			    = 'Parola ta a fost trimisă cu succes!';
$LNG['mail_sended_fail']		= 'E-mail netrimis.';
$LNG['server_infos']			= array(
	"Un joc de strategie spatială in timp real.",
	"Joacă alături de sute de jucători.",
	"Nu este nevoie să descarci nimic, se necesită doar un navigator standard.",
	"Inregistrează-mă Gratuit",
);

//case default
$LNG['login_error_1']			= 'Utilizator/Parolă Incorectă!';
$LNG['login_error_2']			= 'Cineva sa conectat de la alt calculator cu acest cont!';
$LNG['login_error_3']			= 'Sesiunea a expirat te rog identificăte din nou pentru a continua!';
$LNG['screenshots']			= 'Imagini';
$LNG['universe']				= 'Univers';
$LNG['chose_a_uni']			= 'Alege Universul';



/* ------------------------------------------------------------------------------------------ */

//lostpassword.tpl
$LNG['lost_pass_title']		    = 'Recuperare parolă';
$LNG['retrieve_pass']			= 'Restabileste';
$LNG['email']					= 'Adresă de E-mail';

//index_body.tpl
$LNG['user']					= 'Utilizator';
$LNG['pass']					= 'Parolă';
$LNG['remember_pass']			= 'Tine minte';
$LNG['lostpassword']			= 'Memorează parola';
$LNG['welcome_to']				= 'Bine ai venit in ';
$LNG['server_description']		= '<strong>%s</strong> este un joc de strategie in spatiu. Competitie cu jucători 24h/zi 7/zile din săptămană pentru cucerirea universului. Tot ce ai nevoie este doar un navigator standard (<a class="" href="http://www.mozilla.com" target="_blank">Recomandăm Firefox</a>).';
$LNG['server_register']		    = 'Inregistrează-te acum';
$LNG['server_message']			= 'Inregistrează-te acum si experimentează o nouă si emotionantă aventură in universul';
$LNG['login']					= 'Intră';
$LNG['disclamer']				= 'Contactare';
$LNG['login_info']				= 'Accept <a onclick="ajax(\'?page=rules&amp;\'+\'getajax=1&amp;\'+\'lang=%1$s\');" style="cursor:pointer;">Regulile</a> si <a onclick="ajax(\'?page=agb&amp;\'+\'getajax=1&amp;\'+\'lang=%1$s\');" style="cursor:pointer;">T&C</a>';

/* ------------------------------------------------------------------------------------------ */

//reg.php - Registrierung
$LNG['register_closed']			    = 'Inregistrare inchisă!';
$LNG['register_at']				    = 'Inregistrat in ';
$LNG['reg_mail_message_pass']		= 'Incă un pas pentru activarea numelui tău de utilizator';
$LNG['reg_mail_reg_done']			= 'Bine ai venit la %s!';
$LNG['invalid_mail_adress']		    = 'E-Mail Incorect!<br>';
$LNG['empty_user_field']			= 'Te rog, completează toate campurile!<br>';
$LNG['password_lenght_error']		= 'Parola trebuie să contină cel putin 4 caractere!<br>';
$LNG['user_field_no_alphanumeric']	= 'Te rog introduce en el nombre de usuario sólo caracteres alfanuméricos!<br>';
$LNG['user_field_no_space']		    = 'Te rog, nu introduce numele de utilizator in alb!<br>';
$LNG['planet_field_no_alphanumeric']= 'Te rog, introdu doar caractere alfanumerice in numele planetei!<br>';
$LNG['planet_field_no_space']		= 'Te rog, nu lăsa gol numele planetei!<br>';
$LNG['terms_and_conditions']		= 'Aceptă <a onclick="ajax(\'?page=rules&amp;\'+\'getajax=1&amp;\'+\'lang=%1$s\');" style="cursor:pointer;">Reguli</a> si <a onclick="ajax(\'?page=agb&amp;\'+\'getajax=1&amp;\'+\'lang=%1$s\');" style="cursor:pointer;">T&C</a> te rog!<br>';
$LNG['user_already_exists']		    = 'Numele de utilizator ales este deja in folosintă!<br>';
$LNG['mail_already_exists']		    = 'Adresa de email aleasă este deja utilizată!<br>';
$LNG['wrong_captcha']				= 'Cod de Securitate incorect!<br>';
$LNG['different_passwords']		    = 'Ai introdus două parole diferite!<br>';
$LNG['different_mails']			    = 'Ai introdus două adrese de E-Mail diferite!<br>';
$LNG['welcome_message_from']		= 'Administrator';
$LNG['welcome_message_sender']		= 'Administrator';
$LNG['welcome_message_subject']	    = 'Bine ai venit';
$LNG['welcome_message_content']	    = 'Bine ai venit la %s!<br>Construieste intai pentru inceput primul nivel al centralei electrice, pentru că energia este necesară pentru o productie in viitor de materii prime. Pentru asta, fă click in Edificii din meniul stanga. Cand aceast este gata, poti incepe constructia minelor. Mergi inapoi in meniul Edificiilor si construieste o mină de niobiu, si apoi o mină de germaniu. Echipa noastră vă doreste distractie placută in explorarea universului!';
$LNG['newpass_smtp_email_error']	= '<br><br>Sa produs o eroare. Parola ta este: ';
$LNG['reg_completed']				= 'Multumesc pentru inregistrare! Vei primi un email cu o adresă de activare.';
$LNG['planet_already_exists']		= 'Planeta este deja colonizată! <br>';

//registry_form.tpl
$LNG['server_message_reg']			= 'Inregistrează-te acum si alăturăte';
$LNG['register_at_reg']			    = 'Inregistrat in';
$LNG['uni_reg']					    = 'Universul';
$LNG['user_reg']					= 'Utilizator';
$LNG['pass_reg']					= 'Parola';
$LNG['pass2_reg']					= 'Confirmă parola';
$LNG['email_reg']					= 'Adresă E-mail';
$LNG['email2_reg']					= 'Confirmă E-mail';
$LNG['planet_reg']					= 'Numele planetei principale';
$LNG['lang_reg']					= 'Limba';
$LNG['register_now']				= 'Inregistrează-te';
$LNG['captcha_reg']				    = 'Cheie de securitate';
$LNG['accept_terms_and_conditions'] = 'Acept Regulile si T&C';
$LNG['captcha_reload']				= 'Reancarcă';
$LNG['captcha_help']				= 'Ajutor';
$LNG['captcha_get_image']			= 'Incarcă Bild-CAPTCHA';
$LNG['captcha_reload']				= 'CAPTCHA Nou';
$LNG['captcha_get_audio']			= 'Incarcă Sunet-CAPTCHA';
$LNG['user_active']                 = 'Utilizatorul %s a fost activat!';
$LNG['raza_reg']                                        = 'Rasă';
$LNG['raza_0']                                  = 'Gultra';
$LNG['raza_1']                                   = 'Voltra';

//registry_closed.tpl
$LNG['info']						= 'Informatii';
$LNG['reg_closed']					= 'Inregistrări inchise';

//Rules
$LNG['rules_overview']				= "Reguli";
$LNG['rules']						= array(
	"Cuentas"					=> "Fiecare jucător este liber pentru a detine doar un cont in fiecare univers. Fiecare cont are dreptul de a fi folosit doar de un jucător in acelasi timp, singura exceptie este cea de sitting.
Sitting-ul permite unui jucător a avea contul său supervizat sub următoarele conditii:

- Un administrator trebuie să fie informat inainte ca Sitting-ul să se realizeze prin deschiderea unui ticket.
- Nu sunt permise miscările de flotă pe timpul sitting-ului numai incazul unui atac, inca care poti salva flota prin desfăşurarea sau transportul către o planetă sau lună proprietate a contului.
- Un cont poate fi supervizat timp maxim de 48 ore continue (permisul de administrare va fi obtinut in cazurile in care este necesară o mărire de timp).
Supervizorul, in contul de sitting si, si pe tot timpul sesiunii(cat aceasta durează):

- Consuma resurse in clădiri sau cercetări.
- A face Fleetsave a unei flote in pericol iminent din partea unei flote atacante, doar cu misiunea de desfăsurare sau transport către una dintre planetele proprii ale contului.
- Pune contul in modul de vacantă.

Sitter-ul nu poate:

- Transporta resurse, nici intre planete / luni ale contului pe care acesta supervizează, nici către oricare altă planetă / lună.
- Consuma resurse in structuri de apărare sau nave.
- Superviza un cont dacă deja a supervizat altul in ultimele 7 zile.
- Superviza un cont pe care a mai supervizat in ultimele 7 zile.
- Scoaterea unui cont din modul de vacantă.",


	"Pushing"					=> "Nu este permis nici unui cont de a obtine profit neloial dintr-un cont de jucator clasat mai jos pe tema de resurse.
Aceasta include dar nu este limitată la:

- Resurse trimise de la un cont de punctaj mic catre alta de punctaj superior fără a obtine nimic tangibil la schimb.
- Un jucător să distrugă flota intr-un atac contra unei planete mult mai puternice in idea de a menţine campul de asteroizi, şi, astfel, beneficia de el.
- Credite care nu sunt returnate in 48 de ore.
- Operaţiuni în care jucatorul clasat mai sus nu inapoiaza resursele in 48 de ore.
- Jucătorii care răspund la şantaj din partea unui jucator clasat mai sus prin metoda de plata a resurselor.
- Schimburi ce semnifică un beneficiu nedrept pentru jucătorul de punctaj mai mare de din urmatoarea gama de relaţii:

03:02:01 În cazul în care fiecare unitate de deuteriu este în valoare de 2 unităţi de germaniu sau 3 unităţi sau niobiu.

02:01:01 În cazul în care fiecare unitate de deuteriu este în valoare de 1 unităţi de germaniu sau 2 unităţi de niobiu.
",

	"Bashing"					=> "Nu este permis a ataca orice planetă sau lună proprietate a unui jucător mai mult de 6 ori intro perioadă maximă 24 ore.

Bashing este permis doar cand Alianta este in război cu altă Aliantă. Războiul trebuie să fie anuntat in forum iar liderii trebuie să fie de acord cu termenii si conditiile de utilizare.",

	
	"Bugusing"					=> "Utilizarea unui bug destinat pentru profit, sau neraportarea acestuia intentionate este total restrictionat.",


	"Amenintări in viata reală"	=> "Este interzis incercarea de a localiza si de a face rău unui operator, a unui membru din  echipă, al unui administrator de univers sau oricarei alte persoane.",

	"Spam"			=> "Orice incercare de a satura o interfaţă a jucatorului prin orice metoda este interzisă. Asta include dar nu se limitează la:

- Mesaje personale de spam
- Probe de spam
- Spam in General",

  "Războaie"                    => "După ce liderii aliantelor sunt de acord cu războiul, acesta este oficial pornit. Si continuă pană cand una dintre aliante il anulează. Pentru anularea oficiale războiul necesită anularea pactului de război din joc, si publicarea acestuia in forum in linia publicată initial.
În timp ce războiul este în curs de desfăşurare, regula de bashing nu se aplică între atacurile dintre aceste alianţe. Înseamnă că membrii acestor parteneriate care se află in război se pot ataca un număr infinit de ori cu pedeapsa pe care o presupune.
În timp ce una dintre alianţe renunţă şi anulează războiul, regula de Bashing intră în vigoare din nou, şi membrii care incalcă această regulă, după ce războiul sa încheiat vor fi pedepsiti cu ban de 1 zi. Poate Fi pedepsit mai mult în cazul în care gradul de atac este foarte mare.

Dacă oricare dintre alianţele are o flotă în zbor. Şi războiul este anulat înainte de sosirea ei. Acestia nu vor fi pedepsiţi pentru acest atac. Dar orice flotă trimisă după anularea războiului se inregistrează ca Bashing.


Pentru un nou război liderii au nevoie de a crea un subiect nou în forum de declaratii de război / diplomaţie.
Aveţi posibilitatea să setaţi reguli specifice, sau termeni care liderii doresc un război. Orice standard stabilite şi convenite cu contratia alianţa trebuie să fie în acord, şi nu trebuie să contrazică regulile stabilite aici.",

);

$LNG['rules_info1']				= "Cu toate acestea, se arată în acest <a href=\"%s\" target=\"_blank\"> Forum </ a> şi pe pagina de pornire a informaţiilor despre acest joc ...";
$LNG['rules_info2']				= "Pentru a completa aceasta, <a onclick=\"ajax('?page=agb&getajax=1');\" style=\"cursor:pointer;\">T&C</a> trebuie să fie respectate!</font>";


//AGB

$LNG['agb_overview']				= "Termeni si Conditii";
$LNG['agb']						= array(
	"Conţinut de serviciu"				=> array( 
		"recunoaşterea politicilor sunt o condiţie necesară pentru participarea la joc.
Acestea se aplică la toate ofertele de către operatori, inclusiv Forumul şi alte conţinuturi ale jocului.",

                "Serviciul este gratuit.
Prin urmare, nu există nici o pretenţie de disponibilitatea, livrare, funcţionalitatea, sau daune.
În plus, jucătorul nu trebuie să facă cereri pentru a restabili o poveste tratată in mod negativ.",
	),

	"	Afiliaţi"				=> array(
		"La deschiderea sesiunii in joc si / sau membrii forumului se va deschide in joc.",

                "Ce începe cu declaraţia de membri poate fi reziliat de către membru, sau ştergerea contului in scris de către un administrator.
Stergerea datelor pentru motive tehnice nu se poate face de imediat.",

                "Completat de către operator nici un utilizator nu are dreptul de a participa la operaţiunile de operator.
Operatorul îşi rezervă dreptul de a şterge conturile.
Decizia de a sterge un cont este exclusiv a operatorilor si administratorilor.
Orice cerere legală in calitate de membru este exclusă.",

                "Toate drepturile rămân cu operatorul.",
        ),

	"Continut / Responsabilitate"	=> "Pentru conţinutul diverselor capacităţi de comunicare ale jocului, utilizatorii sunt responsabili. Pornografia, rasismul, abuzul sau orice altceva care încalcă legea împotriva conţinuturilor străine la răspunderea operatorului.
Încălcarea poate duce la anularea sau revocarea imediată.",

	"Proceduri interzise"			=> array(
		"Utilizatorul nu este autorizat sa foloseasca hardware / software sau alte substanţe sau mecanisme asociate cu site-ul, care poate interfera cu funcţiile şi a jocului.
Utilizatorul nu poate continua să accepte orice măsură care poate provoca stres nejustificat sau cresterea capacitătii tehnice.
utilizatorului nu ii este permis de a manipula conţinutul generat de operator sau de a se interfera in orice mod cu jocul",
		
		"Orice bot, script sau caracteristici automate sunt interzise.
Jocul poate fi jucat doar în browser. Chiar şi funcţiile acestuia nu ar trebui să fie utilizate pentru a obţine un avantaj în joc.
Prin urmare, orice formă de publicitate va fi blocată. Decizia ca atunci când un program este benefic pentru jucători, este de competenta exclusivă a unui moderator / cu managerii sau operatorii.",
		
	
	),

	"Restrictii de utilizare"		=> array(
		"Un jucător poate folosi doar câte un cont pentru fiecare dintre universuri, asa numitii \ multinationali \ nu sunt permisi şi vor fi ştersi fără preaviz sau poate vor fi blocati.
Decizia de atunci când există un număr \ sau mai multi \ este exclusiv pentru moderatori şi manageri sau operatori. ",
		
		"Date afiliate la reguli.",
		
		"Blocajele sunt la discreţia operatorilor permanente sau temporare.
În mod similar, închiderea se poate extinde la una sau toate zonele de joc.
Decizia este suspendata când şi cât timp un jucător se află singur doar cu moderatorul/ii, cu managerul/ii sau operatorul/ii.",
	),

	"Confidenţialitate"					=> array(
		"Operatorul îşi rezervă dreptul de a stoca datele jucătorilor pentru a monitoriza conformitatea cu standardele, condiţiile de utilizare şi legislaţia aplicabilă.
Salvate toate obligate şi prezentate de către jucător sau informaţiile dvs. de cont.
Aceste IP-uri (sunt asociate cu perioade de utilizare şi de a folosi adresa de e-mail dat în timpul înregistrării şi alte date.
In forum, ce este stocat în profil. ",
		
		"Aceste date vor fi aratate în anumite circumstanţe, pentru a îndeplini obligaţiile legale ale angajaţilor şi a altor persoane autorizate.
Mai mult decât atât, datele pot fi (dacă este necesar) emise, în anumite condiţii către terţi. ",
		
		"Utilizatorul poate obiecta faţă de stocarea datelor cu caracter personal în orice moment. O cale de atac este un drept de retragere(cerere de stergere a contului).",
	),

	"Drepturile de proprietar ale conturilor"	=> array(
		"Toate conturile şi toate obiectele virtuale sunt încă în posesia şi dreptul de proprietate asupra operatorului.
Jucatorul nu obţine dreptul de proprietate şi alte drepturi la orice cont sau părţi.
Toate drepturile rămân cu operatorul.
Un transfer al exploataţiei sau alte drepturi de utilizator va avea loc în orice moment. ",
		
		"Vânzarea neautorizata, utilizarea, copierea, distribuirea, reproducerea sau incalcarea drepturilor (de exemplu, de cont) că operatorul va fi raportat autorităţilor şi urmărit in justiţiei.
În mod expres se permite transferul gratuit, cont permanent şi acţiunile de fondurile proprii în univers, cu excepţia cazului şi cu excepţia cazurilor permise de normele de utilizare ",
            ),

	"Responsabilitate"	=> "Operatorul din fiecare univers nu este raspunzator pentru pagube.
O răspundere este exclusă, cu excepţia pentru daunele cauzate de greşeli intenţionate sau neglijenţă gravă şi toate daunele aduse asupra vieţii şi sănătatii.
În acest sens, a fost declarat în mod explicit faptul că jocurile video pot reprezenta un risc semnificativ pentru sănătate.
Prejudiciul nu este în sensul de operator. ",

	"Modificări în Termeni"	=> "Operatorul îşi rezervă dreptul de a modifica aceşti termeni în orice moment sau de a prelungi.
O modificare sau completare vor fi publicate cel puţin o săptămână înainte de intrarea în Forum.",
);

//Facebook Connect

$LNG['fb_perm']                = "Accesul interzis. %s ai nevoie de toate drepturile pentru a putea intra cu Facebook. De asemenea, se poate intra si fără un cont Facebook! ";

//NEWS

$LNG['news_overview']			= "Stiri";
$LNG['news_from']				= "Deschis %s pentru %s";
$LNG['news_does_not_exist']	    = "Nu există stiri!";

//Impressum

$LNG['disclamer']				= "Plângere";
$LNG['disclamer_name']			= "Nume";
$LNG['disclamer_adress']		= "Adresă";
$LNG['disclamer_tel']			= "Telefon:";
$LNG['disclamer_email']		    = "Adresă E-mail";

// Tradus de alin(alinvrajitorul@hotmail.com) de la xnovarevforum.com.ar

?>