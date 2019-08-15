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

# Extras
$LNG['fragatas'] = "Frégate";
$LNG['cazador'] = "Chasseur";
$LNG['civil'] = "Civile";
$LNG['cruceros'] = "Croisière";
$LNG['insignia'] = "Vaisseaux de guerre";
$LNG['capital'] = "Vaisseaux Capitale";

# Combates
$LNG['tech_rc'] = array (
202 => 'P. Transp.', # Fragatas 
203 => 'G. Transp.',  # Fragatas
204 => 'Chasseur Royal', # Cazador
205 => 'Chasseur Imp&eacute;rial', # Cazador
206 => 'Fr&eacute;gate', # Cruceros
207 => 'V. Guerre', # Cruceros 
208 => 'V. Colon.',  # Civil
209 => 'Recycleur',  # Fragatas
210 => 'Sonde', # Civil
211 => 'Bombardier',  # Naves Insignia 
212 => 'R&eacute;flecteur solaire', # Civil
213 => 'L&eacute;viathan', # Naves Insignia
214 => 'V. de combat Ori',# Naves capitales
215 => 'Traqueur', # Naves Insignia
216 => 'Lune Noire',# Naves capitales
217 => 'Transporteur ultime',  # Fragatas
218 => 'Avatar',# Naves capitales
219 => 'Giga-Recycleur',  # Fragatas
220 => 'Collectionneur',  # Civil

400 => 'D&eacute;fenses',
401 => "Lanceur de missiles",
402 => "Canon Laser l&eacute;ger",
403 => "Canon Laser puissant",
404 => "Canon de prautoss",
405 => "Artillerie &agrave; Ions",
406 => "Lanceur de Plasma",
407 => "Bouclier",
408 => "Grand bouclier",
409 => 'Dôme de Protection',
410 => 'Canon à Gravitons',
411 => 'Plateforme Orbitale',
);


$LNG['tech'] = array(
  0 => 'B&acirc;timents',
  1 => 'Extracteur de titane',
  2 => 'Mine de cristal',
  3 => 'Synth&eacute;tiseur de deuterium',
  4 => 'Panneaux solaires',
  6 => 'Universiter',
  7 => 'Mine de Nórium',
12 => 'Centrale &eacute;lectrique de fusion',
14 => 'Usine de robots',
15 => 'Usine de nanites',
21 => 'Centre spatial',
22 => 'Hangar de titane',
23 => 'Hangar de Cristal',
24 => 'R&eacute;servoir de deuterium',
25 => 'Reservoir de Norium',
31 => 'Laboratoire de recherches',
33 => 'Terraformeur',
34 => 'Zone 51',
44 => 'Silo de missiles',

40 => 'B&acirc;timents lunaires',
41 => 'Base lunaire',
42 => "Phalange de capteur",
43 => "Superporte des Oris",


// Technologies
100 => 'Recherches',
106 => "Technologie Espionnage",
108 => "Technologie Ordinateur",
109 => "Technologie Armes",
110 => "Technologie Bouclier",
111 => "Technologie Blindage",
113 => "Technologie Energie",
114 => "Technologie Hyperespace",
115 => "R&eacute;acteur &agrave; Combustion",
117 => "R&eacute;acteur &agrave; Impulsion",
118 => "Propulsion Hyperespace",
120 => "Technologie Laser",
121 => "Technologie Ion",
122 => "Technologie Plasma",
123 => "R&eacute;seau de Recherche Intergalactique",
124 => 'Astrophysique',
131 => 'Optimisation de la production en Titane',
132 => 'Optimisation de la production en Silicium',
133 => 'Optimisation de la production en Deut&eacute;ride',
133 => 'Optimisation de la production en Nórium',
134 => 'Exoloration de la Matière Noire',
199 => 'Gravitón',

200 => 'Vaisseaux',
202 => "Petit Transporteur",
203 => "Grand Transporteur",
204 => 'Chasseur Royal',
205 => 'Chasseur Imp&eacute;rial',
206 => 'Fr&eacute;gate',
207 => "Vaisseaux de Guerre",
208 => "Vaisseaux de Colonisation",
209 => "Recycleur",
210 => "Sonde d'espionnage",
211 => "Bombardier",
212 => 'R&eacute;flecteur solaire',
213 => 'L&eacute;viathan',
214 => 'Vaisseau de combat Ori',
215 => 'Traqueur',
216 => 'Lune Noire',
217 => 'Transporteur ultime',
218 => 'Avatar',
219 => 'Giga-Recycleur',
220 => 'Collectionneur',
400 => "Systeme de defenses",
401 => "Lance missile",
402 => "Canon laser leger",
403 => "Canon laser lourd",
404 => "Canon de Gauss",
405 => "Canon a ión",
406 => "Canon de plasma",
407 => "Petit dôme de protección",
408 => "Grand dôme de protección",
409 => 'Protecteur planetaire',
410 => 'Canon de Gravitón',
411 => 'Plataforme de Defense Orbital',

502 => 'Misiles de intercepción',
503 => 'Misiles interplanetarios',

);

$LNG['res']['descriptions'] = array(
1 => "Principal fournisseur de mati&egrave;res premi&egrave;res pour la construction de structures portantes et de vaisseaux.",
2 => "Fournisseur principal de ressources pour les installations &eacute;lectroniques et pour les alliages.",
3 => "Extrait la petite quantit&eacute; de carburant de deuterium d'une plan&egrave;te.",
4 => "Les panneaux solaires transforment les rayons de soleil en &eacute;nergie. Presque tous les b&acirc;timents ont besoin d'&eacute;nergie pour fonctionner.",
6 => 'Diminue le temps de recherche de 8%.',
7 => "Le Nórium a été découvert récemment, ressource situé près du cœur des planètes.",
12 => "La centrale &eacute;lectrique de fusion produit de l'&eacute;nergie en fusionnant 2 atomes d'hydrog&egrave;ne en un atome d'h&eacute;lium.",
14 => "Les usines de robots produisent des robots ouvriers qui servent &agrave; la construction de l'infrastructure plan&eacute;taire. Chaque niveau augmente la vitesse de construction des diff&eacute;rents b&aring;timents.",
15 => "C'est le perfectionnement de la technologie de robots. Chaque niveau augmente la vitesse de construction des vaisseaux et des b&aring;timents.",
21 => "Le centre spatial permet de construire les vaisseaux et les installations de d&eacute;fense.",
22 => "Hangar pour entreposer de plus grande capacit&eacute; de titane.",
23 => "Hangar pour entreposer de plus grande capacit&eacute; de cristal.",
24 => "R&eacute;servoirs g&eacute;ants pour le stockage de deuterium.",
25 => "reservoir geant pour le stokage du norium.",
31 => "Le laboratoire de recherche est n&eacute;cessaire pour d&eacute;velopper de nouvelles technologies.",
33 => "Permet d'agrandir la surface utile des plan&egrave;tes.",
34 => "La zone 51 permet le stationnement prolong&eacute; de flottes d'autres membres de l'alliance ou de flottes de membres de votre liste d'amis pour augmenter la d&eacute;fense d'une plan&egrave;te. Les flottes restent en orbite et re&ccedil;oivent le carburant n&eacute;cessaire depuis ce d&eacute;p&ocirc;t.",
41 => "Comme une lune n'a pas d'atmosph&egrave;re, une base lunaire est n&eacute;cessaire pour pouvoir commencer la colonisation.",
42 => "La phalange de capteur permet d'observer les mouvements de flotte. Une phalange de niveau &eacute;lev&eacute; a une plus grande port&eacute;e.",
43 => "Les superportes des Oris sont d'immenses &eacute;metteurs permettant de transporter des vaisseaux &agrave; travers la galaxie sans perte de temps.",
44 => "Les silos de missiles servent &agrave; stocker les missiles.",

106 => "Cette technologie permet d'obtenir des informations sur les autres plan&egrave;tes de l'univers.",
108 => "Avec l'augmentation des capacit&eacute;s des ordinateurs, plus de flottes peuvent &ecirc;tre command&eacute;es. Chaque niveau de technologie ordinateur augmente d'un le nombre total de flottes commandables.",
109 => "La technologie armes rend les syst&egrave;mes d'armes plus efficaces. Chaque niveau de technologie armes augmente la puissance des armes des unit&eacute;s par tranche de 10% de la valeur de base.",
110 => "Chaque niveau de la technologie de bouclier augmente l'efficacit&eacute; des boucliers par tranche de 10%.",
111 => "Des alliages spéciaux rendent les vaisseaux spatiaux de plus en plus résistants. L'efficacité des protections peut être augmentée de 10% par niveau.",
113 => "Maîtriser les diff&eacute;rents types d'&eacute;nergie est n&eacute;cessaire pour de nombreuses technologies.",
114 => "L'int&eacute;gration de la 4ème et de la 5ème dimension permet le d&eacute;veloppement d'un nouveau genre de propulsion plus puissant et efficace.",
115 => "Le d&eacute;veloppement de ces r&eacute;acteurs rend les vaisseaux plus rapides mais chaque niveau n'augmente la vitesse que de 10%.",
117 => "Le r&eacute;acteur à impulsion est bas&eacute; sur le principe de r&eacute;action disant que la plus grande part de la masse du rayon est gagn&eacute;e comme sous-produit de la fusion d'atomes qui sert à produire l'&eacute;nergie n&eacute;cessaire.",
118 => "Par une d&eacute;formation spatiale et temporelle dans l'environnement du vaisseau, l'espace est comprim&eacute; ce qui permet de parcourir de longues distances dans un minimum de temps.",
120 => "La concentration de lumi&egrave;re cr&eacute;e un rayon pouvant engendrer des d&eacute;g&aring;ts importants en touchant un objet.",
121 => "Rayon mortel compos&eacute; d'ions acc&eacute;l&eacute;r&eacute;s. En touchant un objet, il cause des d&eacute;g&aring;ts importants.",
122 => "Une am&eacute;lioration de la technologie d'ions qui n'acc&eacute;l&egrave;re pas des ions mais du plasma tr&egrave;s &eacute;nerg&eacute;tique. Ceci a un effet d&eacute;vastateur en touchant un objet.",
123 => "Les chercheurs de plusieurs plan&egrave;tes utilisent ce r&eacute;seau pour communiquer.",
124 => 'D\'autres découvertes dans l\'astrophysique permette la construction de laboratoires, dont plusieurs vaisseaux peuvent être équipés. De longues expéditions sont possibles dans des les espaces inexplorés. En outre, les progrès permettent la colonisation d\'autres planètes de l\'Univers. Deux niveaux développés de cette technologie peuvent donc être mis à profit pour coloniser une autre planète.',
131 => 'Augmente la prodution de Titane de 2%',
132 => 'Augmente la prodution de Cristal 2%',
133 => 'Augmente la prodution de Deuterium de 2%',
135 => 'Augmente la prodution de Nórium de 2%',
134 => 'La technologie d\'extraction de la matière noire a été étudiée par des scientifiques de l\'Empire, accompagné par un technocrate pour atteindre le point final, une méthode pour l\'extraction des matières sombres de la Lune.',
199 => "Une quantit&eacute; concentr&eacute;e de particules de graviton, r&eacute;seau artificiel de gravitation, est propuls&eacute;e, capable de d&eacute;truire des vaisseaux ou m&ecirc;me des lunes.",

202 => "Le petit transporteur est un vaisseau tr&egrave;s maniable et capable de transporter des mati&egrave;res premi&egrave;res sur d'autres plan&egrave;tes rapidement.",
203 => "Le d&eacute;veloppement du transporteur augmente la capacit&eacute; de fret et rend le vaisseau plus rapide que le petit transporteur.",
204 => "Le Chasseur Royal est un vaisseau tr&egrave;s manoeuvrable qui est stationn&eacute; sur presque toutes les plan&egrave;tes. Les coûts ne sont pas tr&egrave;s importants, mais la puissance du bouclier et la capacit&eacute; de fret sont tr&egrave;s limit&eacute;es.",
205 => "Cette version am&eacute;lior&eacute;e du Chasseur Royal poss&egrave;de une meilleure protection et une capacit&eacute; d'attaque plus importante.",
206 => "Les fr&eacute;gates ont une protection presque trois fois plus importante que celle des scorpions lourds et leur puissance de tir est plus de deux fois plus grande. De plus, ils sont tr&egrave;s rapides. ",
207 => "Les vaisseaux de guerre jouent un r&ocirc;le central dans les flottes. Avec leur artillerie lourde, leur vitesse consid&eacute;rable et la grande capacit&eacute; de fret, ils sont des adversaires respectables.",
208 => "Les nouvelles plan&egrave;tes peuvent &ecirc;tre colonis&eacute;es avec ce vaisseau.",
209 => "Le recycleur collecte les ressources dans les Champs de d&eacute;bris.",
210 => "Les sondes d'espionnage sont des petits drones manoeuvrables qui espionnent les plan&egrave;tes m&ecirc;me &agrave; grande distance.",
211 => "Le bombardier a &eacute;t&eacute; d&eacute;velopp&eacute; pour pouvoir d&eacute;truire les installations de d&eacute;fense des plan&egrave;tes.",
212 => "Les r&eacute;flecteurs solaires sont des plates-formes couvertes de cellules solaires, qui se trouvent dans une orbite tr&egrave;s &eacute;lev&eacute;e et stationnaire. Ils collectent la lumi&egrave;re du soleil et la transmettent par laser &agrave; la station de base.",
213 => "Le destructeur est le roi des vaisseaux de guerre.",
214 => "L'arme principale de ce vaisseau de combat est un rayon énergétique émis par la partie avant du vaisseau.",
215 => "Le traqueur est sp&eacute;cialis&eacute; dans l'interception de flottes ennemies.",
216 => 'Le successeur de l\'étoile de la mort est très populaire, plus rapide, mais pas aussi forte.',
217 => "Le transporteur ultime est une &eacute;volution du grand transporteur. Il a une plus grande capacit&eacute; de chargement et vole plus vite.",
218 => 'Il vous procurera le pire des scénarios, bien que très lent.',
219 => "Le recycleur G&Eacute;ant est muni de l'hypervitesse.",
220 => 'Après de longues années de recherche sur la matière noire, collecter cette matière sur les lunes est désormais possible.',

401 => "Le lanceur de missiles est une façon simple et bon march&eacute; de se d&eacute;fendre.",
402 => "Le bombardement concentr&eacute; de photons peut causer des d&eacute;g&aring;ts nettement plus importants que les armes balistiques habituelles.",
403 => "L'artillerie lourde au laser est l'&eacute;volution cons&eacute;quente de l'artillerie l&eacute;g&egrave;re au laser.",
404 => "Le canon de Gauss (canon &eacute;lectromagn&eacute;tique) acc&eacute;l&egrave;re un projectile pesant des tonnes en consommant une gigantesque quantit&eacute; d'&eacute;nergie.",
405 => "L'artillerie d'ions lance des vagues d'ions sur l'objet, ce qui d&eacute;stabilise les boucliers et endommage l'&eacute;lectronique.",
406 => "Les lanceurs de plasma disposent de la puissance d'une &eacute;ruption solaire et peuvent donc &ecirc;tre plus destructeurs que les destructeurs eux-m&ecirc;mes.",
407 => "Le petit bouclier couvre toute une plan&egrave;te avec un champ infranchissable qui peut absorber une quantit&eacute; &eacute;norme d'&eacute;nergie.",
408 => "L'am&eacute;lioration du petit bouclier peut se servir de nettement plus d'&eacute;nergie pour se d&eacute;fendre.",
409 => 'C\'est l\'évolution du grand bouclier. Il utilise beaucoup plus d\'énergie mais peut endurer les attaques de davantage de vaisseaux.',
410 => 'Après des années de recherche sur la force gravitationnelle, les chercheurs sont en mesure de développer un canon de gravitons qui génère un petit champ gravitionnel concentré qui peut viser l\'ennemi.',
411 => 'Il s\'agit une plateforme défensive. Elle n\'a aucun pouvoir direct, et elle est maintenue par gravité dans une orbite stable de la planète. Ce processus exige une quantité élevée d\'énergie. ',

502 => "Le missile interception d&eacute;truit les missiles adverses.",
503 => "Les missiles interplan&eacute;taires d&eacute;truisent la d&eacute;fense adverse.",

);


// ----------------------------------------------------------------------------------------------------------
// Minen Gebäude
$LNG['info'][1]['name']                   = "Extracteur de titane";
$LNG['info'][1]['description']            = "Le titane sert &agrave; la construction des b&aring;timents. C'est la mati&egrave;re premi&egrave;re la plus &eacute;conomique et elle est indispensable. Sa production utilise peu d'&eacute;nergie.";
$LNG['info'][2]['name']                   = "Extracteur de Cristal";
$LNG['info'][2]['description']            = "Toute construction n&eacute;cessite du silicium. Son extraction demande beaucoup d'&eacute;nergie. Sa production est en interd&eacute;pendance avec le titane.";
$LNG['info'][3]['name']                   = "Synth&eacute;tiseur de deuterium";
$LNG['info'][3]['description']            = "Le deuterium est le carburant des vaisseaux. Il a une grande valeur &eacute;conomique;. Sa production engendre des b&eacute;n&eacute;fices qui servent la recherche.";
$LNG['info'][7]['name']          = 'Mine de Nórium';
$LNG['info'][7]['description']   = 'Le Nórium a été découvert récemment, ressource situé près du cœur des planètes.';


// ----------------------------------------------------------------------------------------------------------
// Energie Gebäude
$LNG['info'][4]['name']                   = "Panneaux solaires";
$LNG['info'][4]['description']            = "Le rayonnement solaire est transform&eacute; en &eacute;nergie. Les centrales thermiques sont les principales productrices d'&eacute;lectricit&eacute; servant au fonctionnement de l'industrie.";
$LNG['info'][12]['name']                  = "Centrale &eacute;lectrique de fusion";
$LNG['info'][12]['description']           = "Plus le niveau de votre centrale est &eacute;lev&eacute;, plus vous produirez d'&eacute;nergie. Attention, votre centrale &eacute;lectrique   &agrave; Hydrog&egrave;ne consommera de l'hydrog&egrave;ne !";

// ----------------------------------------------------------------------------------------------------------
// Gebäude
$LNG['info'][6]['name']                     = "Midgar";
$LNG['info'][6]['description']              = "Elle réduit le temps de recherche de 8% par niveau";
$LNG['info'][14]['name']                  = "Usine de Robots";
$LNG['info'][14]['description']           = "Le d&eacute;veloppement de ce b&aring;timent permet d'am&eacute;liorer la vitesse de construction des b&aring;timents, vaisseaux, d&eacute;fenses et recherches.";
$LNG['info'][15]['name']                  = "Usine de nanites";
$LNG['info'][15]['description']           = "Une am&eacute;lioration deux fois plus puissante que l'usine de robot qui divise en deux le temps de construction des b&aring;timents ainsi que des vaisseaux &egrave; chaque niveau.";
$LNG['info'][21]['name']                  = "Centre spatial";
$LNG['info'][21]['description']           = "L'investissement dans un centre spatial plus d&eacute;velopp&eacute; vous permettra de construire des vaisseaux et de la d&eacute;fense plus cons&eacute;quente.";
$LNG['info'][22]['name']                  = "Hangar d'acier";
$LNG['info'][22]['description']           = "Votre silo a une capacit&eacute; r&eacute;duite. Investissez dans un silo plus grand pour stocker davantage de titane. Attention si votre silo est plein, la production de Titane s'arr&ecirc;te instantan&eacute;ment !";
$LNG['info'][23]['name']                  = "Hangar de silicium";
$LNG['info'][23]['description']           = "Votre silo a une capacit&eacute; r&eacute;duite. Investissez dans un silo plus grand pour stocker davantage de silicium. Attention si votre silo est plein, la production de silicium s'arr&ecirc;te instantan&eacute;ment !";
$LNG['info'][24]['name']                  = "Res&eacute;rvoir de deut&eacute;ride";
$LNG['info'][24]['description']           = "Votre entrep&ocirc;t a une capacit&eacute r&eacute;duite. Investissez dans un entrep&ocirc;t plus grand pour stocker davantage de deut&eacute;ride. Attention si votre entrep&ocirc;t est plein, la production de deut&eacute;ride s'arr&ecirc;te instantan&eacute;ment !";
$LNG['info'][25]['name']              = "Hangar de Nórium";
$LNG['info'][25]['description']       = "Le nórium brut est stocké dans ce bâtiment. Chaque mise à niveau augmente la quantité de Nórium peut être stockée. Une fois que la capacité de stockage est dépassée, les mines de cristal sont automatiquement arrêtées afin de prévenir un effondrement dans les mines";
$LNG['info'][31]['name']                  = "Laboratoire de recherches";
$LNG['info'][31]['description']           = "Le laboratoire de recherche est n&eacute;cessaire pour d&eacute;velopper de nouvelles technologies. En construisant les niveaux sup&eacute;rieurs de ce b&aring;timent, vous faites acc&eacute;l&eacute;rer le temps de construction de vos technologies.";
$LNG['info'][33]['name']                  = "Terraformeur";
$LNG['info'][33]['description']           = "Le d&eacute;veloppement continu des plan&egrave;tes a soulev&eacute; rapidement la question de la limite de l'espace vital. Les m&eacute;thodes de construction souterraine et en surface se sont av&eacute;r&eacute;es insuffisantes. Un petit groupe compos&eacute; de physiciens en &eacute;nergie et d'ing&eacute;nieurs en technologie de nanites a finalement trouv&eacute; la solution: la terraformation.<br/>Le terraformeur peut rendre habitable des contr&eacute;es enti&egrave;res ou m&ecirc;me des continents en utilisant de gigantesques quantit&eacute;s d'&eacute;nergie. Des nanites sp&eacute;cialement d&eacute;velopp&eacute;es, assurant une qualit&eacute; constante du sol, sont produites continuellement dans ce b&aring;timent.<br/><br/>Une fois construit, le terraformeur ne peut &ecirc;tre d&eacute;truit.";
$LNG['info'][34]['name']                  = "Zone 51";
$LNG['info'][34]['description']           = "La zone 51 permet le stationnement prolong&eacute; des flottes d'autres membres de l'alliance ou des flottes de membres de votre liste d'amis pour augmenter la d&eacute;fense d'une plan&egrave;te. Les flottes restent en orbite et re&ccedil;oivent le deut&eacute;ride n&eacute;cessaire. Chaque niveau du d&eacute;p&ocirc;t permet de livrer 10.000 unit&eacute;s de deut&eacute;ride suppl&eacute;mentaire aux vaisseaux en orbite.";  # Pronto este sistema sera super desarrollado.


// ----------------------------------------------------------------------------------------------------------
// Mond Gebäude
$LNG['info'][41]['name']                  = "Base Lunaire";
$LNG['info'][41]['description']           = "Une lune n'ayant pas d'atmosph&egrave;re, une base lunaire est n&eacute;cessaire pour pouvoir commencer la colonisation. Celle-ci cr&eacute;e une atmosph&egrave;re et une gravit&eacute; artificielle et maintient l'atmosph&egrave;re &agrave; une temp&eacute;rature supportable. Une base plus grande augmente la surface couverte par la biosph&egrave;re. Pour chaque niveau de base lunaire, trois champs peuvent &ecirc;tre exploit&eacute;s jusqu'&agrave; la taille maximale de la lune.<br/>Une fois construite, la base lunaire ne peut plus &ecirc;tre d&eacute;truite.";
$LNG['info'][42]['name']                  = "Phalange de capteur";
$LNG['info'][42]['description']           = "Des capteurs de haute d&eacute;finition scannent le spectre complet des fr&eacute;quences de tous les rayonnements qui atteignent la phalange. Des ordinateurs de haute performance combinent des oscillations &eacute;nerg&eacute;tiques minuscules et de cette fa&ccedil;on gagnent des informations concernant le mouvement de vaisseaux sur des plan&egrave;tes &eacute;loign&eacute;es. Un tel extracteur a besoin d'&eacute;nergie sous forme de deut&eacute;ride.";
$LNG['info'][43]['name']                  = "Superportes des Oris";
$LNG['info'][43]['description']           = "Les superporte des Oris sont d'immenses &eacute;metteurs permettant de transporter des vaisseaux &agrave; travers la galaxie sans perte de temps. Cette tranmission n&eacute;cessite une technologie &eacute;lev&eacute;e et une &eacute;norme quantit&eacute; d'&eacute;nergie.";
$LNG['info'][44]['name']                  = "Silo de Missiles";
$LNG['info'][44]['description']           = "Les silos de missiles servent &agrave; stocker les missiles. Chaque niveau de d&eacute;veloppement permet le stockage de cinq missiles interplan&eacute;taires ou de dix missiles d'interception. Un missile interplan&eacute;taire occupe la place de deux missiles d'interception. Les types de missiles se combinent &agrave; souhait.";

// ----------------------------------------------------------------------------------------------------------
// Forschung
$LNG['info'][106]['name']                 = "Technologie Espionnage";
$LNG['info'][106]['description']          = 'La technologie Espionnage se concentre surtout sur l &eacute;tude approfondie de nouveaux capteurs plus efficaces. Plus cette technique est d&eacute;velopp&eacute;e, plus le joueur peut poss&eacute;der d informations sur ce qui ce passe dans son environnement. Pour les sondages, c est la diff&eacute;rence entre le propre niveau d espionnage et le niveau adverse qui est d&eacute;terminante. Une technique d espionnage plus &eacute;lev&eacute;e permet d avoir plus d informations dans son rapport mais aussi d\'avoir une probabilit&eacute; moindre d &ecirc;tre d&eacute;couvert en train d espionner. En envoyant une grande quantit&eacute; de sondes, on augmente la chance de d&eacute;couvrir des d&eacute;tails mais on a aussi le danger d &ecirc;tre d&eacute;couvert. La technique d espionnage am&eacute;liore aussi l\'observation des flottes adverses. Seul le niveau d espionnage est d&eacute;terminant. D&egrave;s le niveau 2, l\'affichage d\'une attaque comporte le nombre de vaisseaux attaquants. Le niveau 4 permet de voir le type de vaisseaux attaquants et le nombre total de vaisseaux, le niveau 8 le nombre de vaisseaux de chaque type. Cette technologie est indispensable pour les raideurs, car elle permet de voir si la victime se donne les moyens de d&eacute;fendre l attaque. Il est pr&eacute;f&eacute;rable de d&eacute;velopper cette technologie d&egrave;s le d&eacute;part, juste apr&egrave;s la recherche des petits transporteurs.';
$LNG['info'][108]['name']                 = "Technologie Ordinateur";
$LNG['info'][108]['description']          = "La technologie ordinateur permet de d&eacute;velopper votre infrastructure informatique, les syst&egrave;mes devenant plus efficaces et plus performants. La vitesse et la performance de calcul augmentent, ceci permettant de commander plus de flottes a la fois. Chaque niveau de technologie ordinateur augmente d\'une le nombre total de flottes commandables. Un plus grand nombre de flottes vous permet de raider plus et donc de gagner plus de ressources. Naturellement cette technologie sert aussi aux marchands, ceux-ci pouvant g&eacute;rer plus de flottes marchandes. C\'est pourquoi il est recommand&eacute; de continuer de d&eacute;velopper cette technologie pendant tout le cours du jeu.";
$LNG['info'][109]['name']                 = "Technologie Arme";
$LNG['info'][109]['description']          = "La technologie armes se concentre surtout sur la mise au point des syst&egrave;mes d armes d&eacute;ja existants. Le but principal est d approvisionner les syst&egrave;mes avec plus d &eacute;nergie et de concentrer celle-ci. Ceci rend les syst&egrave;mes d armes plus efficaces et plus destructeurs. Chaque niveau de technologie armes augmente la puissance des armes des unit&eacute;s par tranche de 10% de la valeur de base. La technologie armes est importante pour tenir ses unit&eacute;s comp&eacute;titives a long terme. Un d&eacute;veloppement permanent est recommand&eacute;.";
$LNG['info'][110]['name']                 = "Technologie Bouclier";
$LNG['info'][110]['description']          = "La technologie de bouclier se concentre surtout sur le d&eacute;veloppement de nouvelles possibilit&eacute;s d approvisionnement des boucliers avec de l &eacute;nergie et permet donc de les rendre plus efficaces et r&eacute;sistants. Chaque niveau augmente l'efficacit&eacute; des boucliers par tranche de 10%.";
$LNG['info'][111]['name']                 = "Technologie protection des vaisseaux";
$LNG['info'][111]['description']          = "Des alliages sp&eacute;ciaux rendent les vaisseaux spatiaux de plus en plus r&eacute;sistants. Une fois qu'un alliage puissant est d&eacute;velopp&eacute;, la structure mol&eacute;culaire des vaisseaux est transform&eacute;e par rayonnement et mise au point avec le meilleur alliage. L efficacit&eacute; de la protection augmente de 10% par niveau atteint.";
$LNG['info'][113]['name']                 = "Technologie Energie";
$LNG['info'][113]['description']          = "La technologie &eacute;nergie se concentre surtout sur le d&eacute;veloppement des r&eacute;seaux et du stockage d &eacute;nergie. Une telle technologie bien d&eacute;velopp&eacute;e permet de stocker plus d &eacute;nergie et de la transporter plus efficacement.";
$LNG['info'][114]['name']                 = "Technologie Hyperespace";
$LNG['info'][114]['description']          = 'L int&eacute;gration de la 4eme et 5eme dimension permet le d&eacute;veloppement d un nouveau genre de propulsion plus puissant et efficace.';
$LNG['info'][115]['name']                 = "R&eacute;acteur a Combustion";
$LNG['info'][115]['description']          = "Les r&eacute;acteurs a combustion fonctionnent par le principe approuv&eacute; de la r&eacute;action. De la mati&egrave;re a temp&eacute;rature tr&egrave;s &eacute;lev&eacute;e est repouss&eacute;e et propulse le vaisseau dans la direction oppos&eacute;e. La port&eacute;e de ces r&eacute;acteurs est assez limit&eacute;e, mais ils sont bon march&eacute;, fiables et n ont gu&egrave;re besoin de maintenance. En outre ils ont besoin de moins de place et se trouvent donc souvent sur des vaisseaux de petite taille. Le d&eacute;veloppement de ces r&eacute;acteurs rend les vaisseaux plus rapides mais a chaque niveau la vitesse n augmente que de 10%. Comme les r&eacute;acteurs a combustion interne sont la base de l'astronautique, il est pr&eacute;f&eacute;rable de les d&eacute;velopper le plus t&ocirc;t possible. Apr&egrave;s, il est tr&egrave;s important de les am&eacute;liorer pour avoir des vaisseaux de type transporteur et des recycleurs plus rapides.";
$LNG['info'][117]['name']                 = "R&eacute;acteur a Impulsion";
$LNG['info'][117]['description']          = 'Le r&eacute;acteur a impulsion est bas&eacute; sur le principe de r&eacute;action disant que la plus grande part de la masse du rayon est gagn&eacute;e comme sous-produit de la fusion d atomes qui sert a produire l &eacute;nergie n&eacute;cessaire. De la masse suppl&eacute;mentaire peut &ecirc;tre initi&eacute;e.';
$LNG['info'][118]['name']                 = "Propulsion Hyperespace";
$LNG['info'][118]['description']          = "Par une d&eacute;formation spatiale et temporelle dans l environnement du vaisseau, l espace est comprim&eacute; ce qui permet de parcourir de longues distances dans un minimum de temps. Une propulsion d'hyperespace tr&egrave;s d&eacute;velopp&eacute;e permet de comprimer l\'espace encore plus, ce qui augmente la vitesse des vaisseaux de 30% par niveau.";
$LNG['info'][120]['name']                 = "Technologie Laser";
$LNG['info'][120]['description']          = "Le Laser (Renforcement de lumi&egrave;re) cr&eacute;e un rayon intense et riche en &eacute;nergie de lumi&egrave;re coh&eacute;rente. Ces installations servent dans beaucoup de domaines, p. e. aux ordinateurs optiques, armes de laser qui peuvent d&eacute;truire la protection d\'un vaisseau sans probl&egrave;mes et autres. La technologie laser est une base importante pour le d&eacute;veloppement d\'autres technologies d armes.";
$LNG['info'][121]['name']                 = "Technologie Ions";
$LNG['info'][121]['description']          = "Rayon mortel compos&eacute; d ions acc&eacute;l&eacute;r&eacute;s. En touchant un objet, il cause des d&eacute;g&aring;ts importants.";
$LNG['info'][122]['name']                 = "Technologie Plasma";
$LNG['info'][122]['description']          = "Un rayon &eacute;volutif de la technologie ions avec un puissance d&eacute;vastatrice.";
$LNG['info'][123]['name']                 = "R&eacute;seau de Recherche Intergalactique";
$LNG['info'][123]['description']          = "Les chercheurs de plusieurs plan&egrave;tes utilisent ce r&eacute;seau pour communiquer.Un laboratoire est ajout&eacute; au r&eacute;seau pour chaque niveau de recherche. Les laboratoires les plus d&eacute;velopp&eacute;s seront connect&eacute;s entre eux.";
$LNG['info'][124]['name']                   = 'Astrophysique';
$LNG['info'][124]['description']            = 'D\'autres résultats de l\'astrophysique permettent la construction de laboratoires, dont les vaisseaux sont équipés. Les longues expéditions sont possibles dans des domaines inexplorés. Cette technologie permet de procéder à la colonisation de l\'espace. Deux niveaux d\'astrophysique permet la colonisation d\'une planète.';
$LNG['info'][131]['name']                   = 'Optimisation de la production en Titane';
$LNG['info'][131]['description']            = 'Augmentre la production de titane de 2%';
$LNG['info'][132]['name']                   = 'Optimisation de la production en Silicium';
$LNG['info'][132]['description']            = 'Augmentre la production de Silicium de 2%';
$LNG['info'][133]['name']                   = 'Optimisation de la production en Deut&eacute;ride';
$LNG['info'][133]['description']            = 'Augmentre la production de Deut&eacute;ride de 2%';
$LNG['info'][135]['name']                   = 'Optimisation de la production en Nórium';
$LNG['info'][135]['description']            = 'Augmente la prodution de Nórium de 2%';
$LNG['info'][134]['name']                   = 'Extraction de la matière noire';
$LNG['info'][134]['description']            = 'La technologie d\'extraction de la matière noire a été étudiée par des scientifiques de l\'Empire, accompagné par un technocrate pour atteindre le point final, une méthode pour l\'extraction des matières sombres de la Lune.';
$LNG['info'][199]['name']                 = "Technologie Graviton";
$LNG['info'][199]['description']          = "La technologie graviton n\'est utilisée que pour la construction de la redoutable étoile de la mort et du canon à gravitons.";

// ----------------------------------------------------------------------------------------------------------
// Schiffe
$LNG['info'][202]['name']                 = "Petit Transporteur";
$LNG['info'][202]['description']          = "Les petits transporteurs ont a peu pr&egrave;s la m&ecirc;me taille que les chasseurs, mais n ont pas de propulsion puissante ou d\'armes, afin d\'avoir plus de place pour le fret. Le vaisseau de type petit transporteur peut transporter 5.000 unit&eacute;s de ressources. Le grand transporteur peut transporter cinq fois plus de fret. En m&ecirc;me temps sa protection et sa propulsion sont plus puissantes. En raison de leur puissance de tir limit&eacute;e, les vaisseaux de type petit transporteur sont souvent escort&eacute;s par d autres vaisseaux.Le d&eacute;veloppement du r&eacute;acteur a impulsion au niveau 5 permet de r&eacute;&eacute;quiper le petit transporteur avec ce type de r&eacute;acteurs, acc&eacute;l&eacute;rant alors sensiblement ce vaisseau.";
$LNG['info'][203]['name']                 = "Grand Transporteur";
$LNG['info'][203]['description']          = "Ce vaisseau n a gu&egrave;re d armes ou d autres technologies a bord. Il est donc pr&eacute;f&eacute;rable de lui fournir une escorte qui lui permet de profiter de toute sa capacit&eacute; de fret. Avec son r&eacute;acteur de combustion de haute performance, le grand transporteur sert pour transporter rapidement des ressources entre les plan&egrave;tes et bien sûr il accompagne les flottes durant leurs attaques sur d autres plan&egrave;tes pour pouvoir conqu&eacute;rir le nombre maximal de ressources.";
$LNG['info'][204]['name']                 = "Chasseur Royal ";
$LNG['info'][204]['description']          = "Le Chasseur Royale est un vaisseau tr&egrave;s manoeuvrable qui est stationn&eacute; sur presque toutes les plan&egrave;tes. Les coûts ne sont pas tr&egrave;s importants, mais la puissance du bouclier et la capacit&eacute; de fret sont tr&egrave;s limit&eacute;es.";
$LNG['info'][205]['name']                 = "Chasseur Imperial";
$LNG['info'][205]['description']          = "La propulsion conventionnelle n &eacute;tait plus suffisante pour le d&eacute;veloppement des Chasseurs Imperial. Pour rendre les futurs vaisseaux plus rapides, les ing&eacute;nieurs eurent recours au r&eacute;acteur a impulsions. Ceci augmente certe les c&ocirc;uts de production, mais &eacute;largit les possibilit&eacute;s. L arriv&eacute;e de cette propulsion permet d'utiliser plus d &eacute;nergie pour les armes et la protection, de plus ces vaisseaux sont produits avec des mat&eacute;riaux d'une meilleure qualit&eacute;. Ceci am&eacute;liore l int&eacute;grit&eacute; structurelle et la puissance de tir. Le Chasseur Lourd est donc un vaisseau beaucoup plus mena&ccedil;ant que son petit fr&egrave;re, le chasseur l&eacute;ger. Ce changement fait du chasseur lourd la technologie de base pour la technologie des croiseurs.";
$LNG['info'][206]['name']                 = "Fr&eacute;gate";
$LNG['info'][206]['description']          = "Le d&eacute;veloppement des lasers lourds et des canons d\'ions sonn&egrave;rent le glas de l'&eacute;poque des chasseurs. Malgr&eacute; de nombreuses modifications, la puissance des Armements et de la protection ne purent &ecirc;tre assez am&eacute;lior&eacute;es pour pouvoir battre ces canons de d&eacute;fense. Il fut donc d&eacute;cid&eacute; de construire une nouvelle classe de vaisseaux avec plus de protection et de puissance de tir. Le Croiseur &eacute;tait cr&eacute;&eacute;. Les Croiseurs ont une protection presque trois fois plus grande que celle des chasseurs lourds et leur puissance de tir est plus que deux fois plus puissante. De plus, ils sont tr&egrave;s rapides. Il n y a pas d arme plus puissante contre la d&eacute;fense moyenne. Les Croiseurs ont domin&eacute; l\'espace pendant presque un si&egrave;cle. L'apparition de l artillerie &eacute;lectromagn&eacute;tique et des lanceurs de plasma a mis fin a leur domination. Pourtant ils servent encore souvent dans les batailles contre les unit&eacute;s de chasseurs.";
$LNG['info'][207]['name']                 = "Vaisseau de Bataille";
$LNG['info'][207]['description']          = "Les Vaisseaux de Batailles jouent un r&ocirc;le central dans les flottes. Avec leur artillerie lourde, leur vitesse consid&eacute;rable et la grande capacit&eacute; de fret, ils sont des adversaires respectables.";
$LNG['info'][208]['name']                 = "Vaisseau de colonisation";
$LNG['info'][208]['description']          = "Ce vaisseau bien prot&eacute;g&eacute; sert a la conqu&ecirc;te de nouvelles plan&egrave;tes, ce qui est fondamental pour un empire ambitieux. Pour coloniser une nouvelle plan&egrave;te, ce vaisseau y est d&eacute;mont&eacute; et ces mat&eacute;riaux servent comme ressources pour la conqu&ecirc;te de la plan&egrave;te.";
$LNG['info'][209]['name']                 = "Recycleur";
$LNG['info'][209]['description']          = "Les dimensions des batailles spatiales se sont constamment &eacute;largies. Des milliers de vaisseaux ont &eacute;t&eacute; construits, mais les Champs de d&eacute;bris semblaient &ecirc;tre perdus pour toujours. Les cargos ne pouvaient pas s approcher des Champs de d&eacute;bris sans prendre le risque d &ecirc;tre endommag&eacute;s consid&eacute;rablement par des d&eacute;combres. Un nouveau d&eacute;veloppement dans le domaine de la technologie des boucliers a permis de construire cette nouvelle classe de vaisseau comparable aux grands cargos, le recycleur. Gr&aring;ce au recycleur, les ressources qui semblaient &ecirc;tre perdues peuvent quand m&ecirc;me &ecirc;tre exploit&eacute;es. M&ecirc;me les d&eacute;combres de petite taille ne les menacent pas gr&aring;ce a leurs nouveaux boucliers. Malheureusement ces installations ont besoin d'espace ce qui limite la capacit&eacute; de fret a 20.000 unit&eacute;s.";
$LNG['info'][210]['name']                = "Sonde d'Espionnage";
$LNG['info'][210]['description']          = "Les sondes d'espionnage sont des petits drones manoeuvrables qui espionnent les plan&egrave;tes m&ecirc;me a grande distance. Leurs r&eacute;acteurs de haute performance leur permettent de parcourir de longues distances en quelques secondes. D&egrave;s qu elles atteignent l orbite d une plan&egrave;te elles s y installent et l espionnent. Pendant cette activit&eacute;, l ennemi peut facilement les d&eacute;couvrir et attaquer. Pour limiter leur taille, elles n ont pas de protection, de bouclier ou d Armements, voila pourquoi on peut facilement les d&eacute;truire.";
$LNG['info'][211]['name']                 = "Bombardier";
$LNG['info'][211]['description']          = "Le Bombardier a &eacute;t&eacute; d&eacute;velopp&eacute; pour pouvoir d&eacute;truire les installations de d&eacute;fense des plan&egrave;tes. Avec une lunette laser il lance des bombes de plasma de facon cibl&eacute;e sur la surface des plan&egrave;tes et y cause des d&eacute;g&aring;ts d&eacute;vastateurs.D&eacute;truit la d&eacute;fense plan&eacute;taire.Le d&eacute;veloppement de la propulsion hyperespace au niveau 8 permet de r&eacute;&eacute;quiper le Bombardier avec ce type de propulseurs, acc&eacute;l&eacute;rant alors sensiblement ce vaisseau.";
$LNG['info'][212]['name']                 = "R&eacute;flecteur solaire";
$LNG['info'][212]['description']          = "Les r&eacute;flecteur solaires sont positionn&eacute;s dans une orbite g&eacute;ostationnaire autour d'une plan&egrave;te. Ils collectent la lumi&egrave;re du soleil et la transmettent par laser a la station de base. L efficacit&eacute; des satellites solaires d&eacute;pend de la lumi&egrave;re du soleil. Naturellement la quantit&eacute; d &eacute;nergie est plus grande quand l orbite est proche du soleil. Avec leur efficacit&eacute;, les satellites solaires sont la solution pour les probl&egrave;mes d &eacute;nergie de beaucoup de plan&egrave;tes. Attention: Les satellites solaires peuvent &ecirc;tre d&eacute;truits pendant une bataille.";
$LNG['info'][213]['name']                 = "L&eacute;viathan";
$LNG['info'][213]['description']          = "Le L&eacute;viathan est le roi des vaisseaux de guerre. Ses tours de guerre avec artillerie d ions, plasma et &eacute;lectromagn&eacute;tiques peuvent, gr&aring;ce a ses capteurs de cible, toucher des chasseurs rapides avec presque 99% de certitude. Comme ils sont tr&egrave;s grands, leur facult&eacute; de manoeuvrer est tr&egrave;s limit&eacute;e. Pendant une bataille ils sont donc plus comparables a une station de guerre qu a un vaisseau de guerre. Leur consommation d Hydrog&eacute;ne est aussi grande que leur puissance dans la bataille.";
$LNG['info'][214]['name']                 = "Vaisseau de combat Ori";
$LNG['info'][214]['description']          = "Chacun des vaisseaux de combat Ori doit être activé par un prêcheur. L arme principale de ce vaisseau de combat est un rayon énergétique émis par la partie avant du vaisseau. Le rayon d énergie est très semblable à celui émis par les Satellite Ori et est capable de détruire un vaisseau Ha tak avec un seul tir. Le vaisseau est protégé par un impressionnant bouclier";
$LNG['info'][215]['name']                 = "Traqueur";
$LNG['info'][215]['description']          = "Ce vaisseau au fuselage filiforme est ideal pour detruire des convois ennemis. Ses Armements laser nouvelle generation le rendent capable d affronter un grand nombre de vaisseaux en meme temps. A cause de son fuselage etroit et de son armement important, les capacites disponibles pour le transport de ressources sont tres limitees. Ceci est compense par l utilisation de reacteurs propulsion hyperespace, peu gourmands en carburant.";
$LNG['info'][216]['name']                   = 'Lune Noire';
$LNG['info'][216]['description']            = 'Ce vaisseau est un développement monstrueux de l\'étoile de la mort, se déplaçant plus vite, mais ayant perdu de sa force.';
$LNG['info'][217]['name']                 = "Transporteur ultime";
$LNG['info'][217]['description']         = "Ce transporteur peut envoyer des masses de chargement a une vitesse incroyable";
$LNG['info'][218]['name']                   = 'Avatar';
$LNG['info'][218]['description']            = 'Ce navire est une amélioration de plusieurs navires, et l\'Empereur des navires de bataille.';
$LNG['info'][219]['name']                   = "gigarecycleur";
$LNG['info'][219]['description']            = "Les chercheurs ont développ&eacute; un recycleur capable de compresser les débris afin de récolter un maximum de ressources.";
$LNG['info'][220]['name']                   = 'Collectionneur';
$LNG['info'][220]['description']            = 'Avec ce navire, il est possible après de longues années de recherche, de recueillir la matière noire sur les lunes.';

// ----------------------------------------------------------------------------------------------------------
// Verteidigung
$LNG['info'][401]['name']                 = "Lanceur de Missiles";
$LNG['info'][401]['description']          = "Le Lanceur de missiles est une facon simple et bon march&eacute; de se d&eacute;fendre. Comme il n est qu une &eacute;volution d Armements balistiques habituelles, il n a pas besoin de recherche. Ses faibles frais de production permettent de s en servir pour la d&eacute;fense contre des petites flottes, par contre au fur et a mesure il perd de son importance. Apr&egrave;s il ne sert qu a intercepter des missiles. Des rumeurs existent affirmant que les militaires sont en train de d&eacute;velopper de nouveaux lanceurs. Les installations de d&eacute;fense sont d&eacute;sactiv&eacute;es d&egrave;s qu elles sont trop endommag&eacute;es. Apr&egrave;s une bataille, jusqu a 70% des syst&egrave;mes endommag&eacute;s peuvent &ecirc;tre r&eacute;par&eacute;s.";
$LNG['info'][402]['name']                 = "Artillerie Laser L&eacute;ger";
$LNG['info'][402]['description']          = "Pour pouvoir compenser les d&eacute;veloppements &eacute;normes de la technologie Vaisseaux, les chercheurs ont dû d&eacute;velopper un syst&egrave;me de d&eacute;fense capable de battre des vaisseaux plus grands et mieux &eacute;quip&eacute;s. Ceci &eacute;tait la naissance du blaster l&eacute;ger. Le bombardement concentr&eacute; de photons peut causer des d&eacute;g&aring;ts nettement plus importants que les Armements balistiques habituelles. De plus, on l a aussi &eacute;quip&eacute;e d un bouclier plus puissant pour pouvoir r&eacute;sister aux nouvelles classes de vaisseaux. Pour garder des frais de production raisonnables, la structure n a pas &eacute;t&eacute; renforc&eacute;e. Le laser l&eacute;ger offre une performance importante par rapport aux faibles frais et est donc est tr&egrave;s int&eacute;ressant, m&ecirc;me pour des civilisations plus d&eacute;velopp&eacute;es. Les installations de d&eacute;fense sont d&eacute;sactiv&eacute;es d&egrave;s qu elles sont trop endommag&eacute;es. Apr&egrave;s une bataille, jusqu a 70% des syst&egrave;mes endommag&eacute;s peuvent &ecirc;tre r&eacute;par&eacute;s.";
$LNG['info'][403]['name']                 = "Artillerie Laser Lourd";
$LNG['info'][403]['description']          = "Le blaster lourd au laser est l &eacute;volution cons&eacute;quente du blaster leger au laser. La structure est renforc&eacute;e et am&eacute;lior&eacute;e avec des nouveaux mat&eacute;riaux. La structure est donc plus r&eacute;sistante. En m&ecirc;me temps ont &eacute;t&eacute; aussi am&eacute;lior&eacute;s le syst&egrave;me d &eacute;nergie et l ordinateur de cible, ce qui permet de concentrer plus d &eacute;nergie sur un objet. Les installations de d&eacute;fense sont d&eacute;sactiv&eacute;es d&egrave;s qu elles sont trop endommag&eacute;es. Apr&egrave;s une bataille jusqu a 70% des syst&egrave;mes endommag&eacute;s peuvent &ecirc;tre r&eacute;par&eacute;s.";
$LNG['info'][404]['name']                 = "Canon de Prautoss";
$LNG['info'][404]['description']          = "Pendant longtemps on a pens&eacute; que les Armements a projectiles seraient comme la technologie de la fusion et de l &eacute;nergie, le d&eacute;veloppement de la propulsion de hyperespace et le d&eacute;veloppement de protections am&eacute;lior&eacute;es resteraient antiques jusqu a ce que la technologie de l &eacute;nergie, qui l avait &eacute;vinc&eacute; a l &eacute;poque, les a remises en jeu. Le principe &eacute;tait d&eacute;ja connu au 20i&egrave;me et au 21i&egrave;me si&egrave;cle - le principe d acc&eacute;l&eacute;ration de particules. Un canon de Gauss (Canon &eacute;lectromagn&eacute;tique) n\'est en fait rien d'autre qu une version nettement plus grande du canon. Des projectiles qui p&egrave;sent des tonnes sont acc&eacute;l&eacute;r&eacute;s magn&eacute;tiquement et atteignent une vitesse telle que les particules de salet&eacute; autour du projectile brûlent et le recul fait trembler la terre. M&ecirc;me les protections et boucliers modernes ont du mal a r&eacute;sister a cette force, ce n est pas rare qu un projectile traverse compl&egrave;tement un objet. Les installations de d&eacute;fense sont d&eacute;sactiv&eacute;es d&egrave;s qu elles sont trop endommag&eacute;es. Apr&egrave;s une bataille, jusqu a 70% des syst&egrave;mes endommag&eacute;s peuvent &ecirc;tre r&eacute;par&eacute;s.";
$LNG['info'][405]['name']                 = "Canon a Ions";
$LNG['info'][405]['description']          = "Au 21eme si&egrave;cle existait quelque chose qui se nommait PEM. Le PEM &eacute;tait le pouls &eacute;lectromagn&eacute;tique qui causait une tension suppl&eacute;mentaire dans chaque circuit, ce qui causait de nombreux incidents bloquants tous les appareils sensibles. a l &eacute;poque, le PEM &eacute;tait bas&eacute; sur les missiles et les bombes, entre autre en relation avec des bombes atomiques. Ensuite, le PEM a &eacute;t&eacute; am&eacute;lior&eacute; pour rendre des objets incapables d agir sans les d&eacute;truire et donc de les reprendre. Aujourd'hui, l'artillerie d ions est la version la plus moderne du PEM. Elle lance une vague d'ions sur l objet, ceci d&eacute;stabilise les boucliers et les parties &eacute;lectroniques - tant qu'il n y a pas de bouclier &eacute;lectronique. Sa puissance kin&eacute;tique n est pas importante. Les Croiseurs se servent eux aussi de la technologie d ions, c est d ailleurs le seul type de vaisseau, les autres types ne disposant pas des quantit&eacute;s d'&eacute;nergie n&eacute;cessaires. Il est souvent int&eacute;ressant de ne pas d&eacute;truire un vaisseau mais de le paralyser. Les syst&egrave;mes de d&eacute;fense se d&eacute;sactivent d&egrave;s qu ils sont trop endommag&eacute;s. Apr&egrave;s une bataille jusqu a 70% des syst&egrave;mes endommag&eacute;s peuvent &ecirc;tre r&eacute;par&eacute;s.";
$LNG['info'][406]['name']                 = "Lanceur de Plasma";
$LNG['info'][406]['description']          = "La technologie laser a ensuite &eacute;t&eacute; perfectionn&eacute;e, la technologie d ions a atteint sa phase finale. On pensait qu il serait impossible de rendre les syst&egrave;mes d Armements encore plus efficaces. La possibilit&eacute; de combiner les deux syst&egrave;mes a chang&eacute; la situation. D&eacute;ja connue de la technologie de fusion, des lasers chauffent des particules (le plus souvent Hydrog&eacute;ne) a une temp&eacute;rature extr&ecirc;me, parfois jusqu a des millions de degr&eacute;s. La technologie d ions permet le chargement &eacute;lectrique des particules, les r&eacute;seaux de stabilit&eacute; et l acc&eacute;l&eacute;ration des particules. En &eacute;chauffant la charge, en la mettant sous pression et l ionisant, on la lance par acc&eacute;l&eacute;ration dans l espace en direction d un objet. La balle de plasma est bleue et visuellement fascinante, par contre il est difficile de s imaginer que l &eacute;quipage du vaisseau cibl&eacute; soit tr&egrave;s heureux de la voir... Le lanceur de plasma est une des Armements les plus mena&ccedil;antes, mais cette technologie est assez ch&egrave;re. Les syst&egrave;mes de d&eacute;fense se d&eacute;sactivent d&egrave;s qu ils sont trop endommag&eacute;s. Apr&egrave;s une bataille jusqu a 70% des syst&egrave;mes endommag&eacute;s peuvent &ecirc;tre r&eacute;par&eacute;s.";
$LNG['info'][407]['name']                 = "Petit Bouclier";
$LNG['info'][407]['description']          = "Longtemps avant l installation des g&eacute;n&eacute;rateurs de bouclier sur des vaisseaux, existaient d&eacute;ja des g&eacute;n&eacute;rateurs g&eacute;ants sur la surface des plan&egrave;tes. Ceux-ci permettaient de couvrir les plan&egrave;tes avec des champs infranchissables qui pouvaient absorber des quantit&eacute;s &eacute;normes avant de s effondrer. Des petites flottes d attaques &eacute;chouent souvent contre ces boucliers. Ces boucliers peuvent &ecirc;tre am&eacute;lior&eacute;s. Apr&egrave;s, on peut m&ecirc;me construire un grand bouclier qui est encore plus puissant. Pour chaque plan&egrave;te on ne peut construire qu un seul bouclier.";
$LNG['info'][408]['name']                 = "Grand Bouclier";
$LNG['info'][408]['description']          = "L'am&eacute;lioration du petit bouclier. Il est bas&eacute; sur la m&ecirc;me technologie mais peut se servir de nettement plus d &eacute;nergie pour se d&eacute;fendre.";
$LNG['info'][409]['name']                   = 'Dôme de protection';
$LNG['info'][409]['description']            = 'C\'est la poursuite du développement du grand bouclier. Il est basé sur les mêmes technologies, mais il peut aussi utiliser beaucoup plus d\'énergie pour dissuader les attaques de l\'ennemi.';
$LNG['info'][410]['name']                   = 'Canon à gravitons';
$LNG['info'][410]['description']            = 'Il est basé comme son nom l\'indique, sur la force Graviton, mieux connu comme arme de l\'étoile de la mort.';
$LNG['info'][411]['name']                   = 'Plateforme orbitale';
$LNG['info'][411]['description']            = 'Cette plateforme aux proportions gigantesques, est le la structure la plus grande de l\'univers connu. Cette structure défensive est maintenue par gravité dans une orbite stable de la planète. Le début de ce processus exige une énergie élevée. Les chercheurs travaillent sur les moyens de construire des vaisseaux sur cette plateforme afin de les utiliser comme un anneau extérieur de défense plus efficace. En raison de sa très grande échelle, il est possible d\'avoir un seul de ces monstres.';
// ----------------------------------------------------------------------------------------------------------
// Raketen 
$LNG['info'][502]['name']                 = "Missiles Interception";
$LNG['info'][502]['description']          = "Le missile interception d&eacute;truit les missiles adverses. Chaque Missile Interception d&eacute;truit un missile interplan&eacute;taire.";
$LNG['info'][503]['name']                 = "Missiles Interplan&egrave;taires";
$LNG['info'][503]['description']          = "Les missiles interplan&eacute;taires d&eacute;truisent la d&eacute;fense adverse. Les syst&egrave;mes de d&eacute;fense d&eacute;truits par des missiles interplan&eacute;taires ne se r&eacute;parent pas.";

?>