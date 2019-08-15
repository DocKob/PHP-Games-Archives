<?php
/**
 * This file is part of Wootook
 *
 * @license http://www.gnu.org/licenses/gpl-3.0.txt
* @see http://www.wootook.com/
 *
 * Copyright (c) 2009-2011, XNova Support Team <http://wootook.org>
 * All rights reserved.
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 *                                --> NOTICE <--
 *  This file is part of the core development branch, changing its contents will
 * make you unable to use the automatic updates manager. Please refer to the
 * documentation for further information about customizing XNova.
 *
 */

// Interface !
$lang['nfo_page_title']  = "Information";
$lang['nfo_title_head']  = "Information concernant";
$lang['nfo_name']        = "Nom";
$lang['nfo_destroy']     = "D&eacute;truire";
$lang['nfo_level']       = "Niveau";
$lang['nfo_range']       = "Port&eacute;e des capteurs";
$lang['nfo_used_energy'] = "Consommation d'&eacute;nergie";
$lang['nfo_used_deuter'] = "Consommation de Deut&eacute;rium";
$lang['nfo_prod_energy'] = "Production d'&eacute;nergie";
$lang['nfo_difference']  = "Diff&eacute;rence";
$lang['nfo_prod_p_hour'] = "Production/heure";
$lang['nfo_needed']      = "N&eacute;cessite";
$lang['nfo_dest_durati'] = "Dur&eacute;e de destruction";

$lang['nfo_struct_pt']   = "Points de structure";
$lang['nfo_shielf_pt']   = "Puissance du bouclier";
$lang['nfo_attack_pt']   = "Valeur d'attaque";
$lang['nfo_rf_again']    = "Feu rapide contre";
$lang['nfo_rf_from']     = "Feu rapide de";
$lang['nfo_capacity']    = "Capacit&eacute; de fret";
$lang['nfo_units']       = "Unit&eacute;s";
$lang['nfo_base_speed']  = "Vitesse de base";
$lang['nfo_consumption'] = "Consommation de carburant (Deut&eacute;rium)";

// ----------------------------------------------------------------------------------------------------------
// Interface porte de saut
$lang['gate_start_moon'] = "Lune de d&eacute;part";
$lang['gate_dest_moon']  = "Lune de destination :";
$lang['gate_use_gate']   = "Utiliser la porte de saut spatial";
$lang['gate_ship_sel']   = "s&eacute;lection des vaisseaux";
$lang['gate_ship_dispo'] = "disponible";
$lang['gate_jump_btn']   = "Sauter";
$lang['gate_jump_done']  = "Les op&eacute;rations de saut se sont bien pass&eacute;, prochain saut possible dans : ";
$lang['gate_wait_dest']  = "Les chargeurs d'&eacute;nergie de la porte de destination n'ont pas encore eu le temps de se recharger ! Temps d'attente : ";
$lang['gate_no_dest_g']  = "Il n'y a pas de porte de saut sur la plan&egrave;te vers laquelle vous souhaitez envoyer la flotte !";
$lang['gate_wait_star']  = "Les chargeurs d'&eacute;nergie de la porte de d&eacute;part n'ont pas encore eu le temps de se recharger ! Temps d'attente : ";
$lang['gate_wait_data']  = "Erreur, il n'y a aucune donn&eacute;e de saut !";

// ----------------------------------------------------------------------------------------------------------
// Batiments Mines!
$lang['info'][1]['name']          = "Mine de Metal";
$lang['info'][1]['description']   = "Le Metal sert &agrave; la construction des b&acirc;timents, c'est la mati&egrave;re premi&egrave;re la plus &eacute;conomique mais elle est indispensable. Sa production utilise peu d'&eacute;nergie.";
$lang['info'][2]['name']          = "Mine de cristal";
$lang['info'][2]['description']   = "Toute construction n&eacute;cessite du cristal, son extraction demande beaucoup d'&eacute;nergie. Sa production est en interd&eacute;pendance avec le Metal.";
$lang['info'][3]['name']          = "Extracteur Deuterium";
$lang['info'][3]['description']   = "LE deuterium est le carburant des vaisseaux. Il a une grande valeur &eacute;conomique; sa production engendre des b&eacute;n&eacute;fices qui servent la recherche.";

// ----------------------------------------------------------------------------------------------------------
// Batiments Energie!
$lang['info'][4]['name']          = "Centrale thermique";
$lang['info'][4]['description']   = "Le rayonnement solaire est transform&eacute; en &eacute;nergie. Les centrales thermiques sont les principales productrices d'&eacute;lectricit&eacute; servant au fonctionnement de l'industrie.";
$lang['info'][12]['name']         = "Centrale &eacute;lectrique a Hydrog&eacute;ne";
$lang['info'][12]['description']  = "Plus le niveau de votre centrale est &eacute;lev&eacute;, plus vous produirez d'&eacute;nergie. Attention, votre centrale &eacute;lectrique a Hydrog&eacute;ne consommera de l hydrog&eacute;ne !";

// ----------------------------------------------------------------------------------------------------------
// Batiments Généraux!
$lang['info'][14]['name']         = "Usine de Robots";
$lang['info'][14]['description']  = "Le d&eacute;veloppement de ce b&acirc;timent permet d'am&eacute;liorer la vitesse de construction des b&acirc;timents, vaisseaux, d&eacute;fenses et recherches.";
$lang['info'][15]['name']         = "Usine de Nanites";
$lang['info'][15]['description']  = "Une am&eacute;lioration deux fois plus puissante de l'usine de robot qui divise en deux le temps de construction des b&acirc;timents ainsi que des vaisseaux &agrave; chaque niveau.";
$lang['info'][21]['name']         = "Centre spatial";
$lang['info'][21]['description']  = "L'investissement dans un centre spatial plus d&eacute;velopp&eacute; vous permettra de construire des vaisseaux et de la d&eacute;fense plus cons&eacute;quente.";
$lang['info'][22]['name']         = "Silo de Metal";
$lang['info'][22]['description']  = "Votre silo a une capacit&eacute; r&eacute;duite, investissez dans un silo plus grand pour stocker d'avantage de metal. Attention si votre silo est plein, la production de metal s'arr&ecirc;te instantan&eacute;ment !";
$lang['info'][23]['name']         = "Silo de cristal";
$lang['info'][23]['description']  = "Votre silo a une capacit&eacute; r&eacute;duite, investissez dans un silo plus grand pour stocker d'avantage de cristal. Attention si votre silo est plein, la production de cristal s'arr&ecirc;te instantan&eacute;ment !";
$lang['info'][24]['name']         = "Entrep&ocirc;t de deuterium";
$lang['info'][24]['description']  = "Votre entrep&ocirc;t a une capacit&eacute; r&eacute;duite, investissez dans un entrep&ocirc;t plus grand pour stocker d'avantage de Deuterium. Attention si votre entrep&ocirc;t est plein, la production de deuterium s'arr&ecirc;te instantan&eacute;ment !";
$lang['info'][31]['name']         = "Centre de recherche";
$lang['info'][31]['description']  = "Le centre de recherche est n&eacute;cessaire pour d&eacute;velopper de nouvelles technologies. En construisant les niveaux sup&eacute;rieurs de ce b&acirc;timent vous faites acc&eacute;l&eacute;rer le temps de construction de vos technologies.";
$lang['info'][33]['name']         = "Terraformeur";
$lang['info'][33]['description']  = "Le d&eacute;veloppement continu des plan&egrave;tes a soulev&eacute; rapidement la question de la limitation de l'espace vital. Les m&eacute;thodes de construction souterraine et en surface se sont aver&eacute;es insuffisantes. Un petit groupe compos&eacute; de physiciens en &eacute;nergie et d'ing&eacute;nieurs en technologie de nanites a finalement trouv&eacute; la solution: la terraformation.<br>Le terraformeur peut rendre habitable des contr&eacute;es entieres ou m&ecirc;me des continents en utilisant de gigantesques quantit&eacute;s d'&eacute;nergie. Des nanites specialement d&eacute;velopp&eacute;es, assurant une qualit&eacute; constante du sol, sont produites continuellement dans ce bâtiment.<br><br>Une fois construit, le terraformeur ne peut &ecirc;tre d&eacute;truit.";
$lang['info'][34]['name']         = "D&eacute;p&ocirc;t de ravitaillement";
$lang['info'][34]['description']  = "Le d&eacute;p&ocirc;t de ravitaillement permet le stationnement prolong&eacute; des flottes d'autres membres de l'alliance ou des flottes de membres de votre liste d'amis pour augmenter la d&eacute;fense d'une plan&egrave;te. Les flottes restent en orbite et recoivent le carburant n&eacute;cessaire. Chaque niveau du d&eacute;p&ocirc;t permet de livrer 10.000 unit&eacute;s de deut&eacute;rium suppl&eacute;mentaire aux vaisseaux en orbite.";

// ----------------------------------------------------------------------------------------------------------
// Batiments Lune!
$lang['info'][41]['name']         = "Base lunaire";
$lang['info'][41]['description']  = "Une lune n'ayant pas d'atmosph&egrave;re, une base lunaire est n&eacute;cessaire pour pouvoir commencer la colonisation. Celle-ci cr&eacute;e une atmosph&egrave;re et une gravit&eacute; artificielle et maintient l'atmosph&egrave;re &agrave; une temp&eacute;rature supportable. Une base plus grande augmente la surface couverte par la biosph&egrave;re. Pour chaque niveau de base lunaire, trois champs peuvent &ecirc;tre exploit&eacute;s jusqu'&agrave; la taille maximale de la lune.<br><br>Une fois construite, la base lunaire ne peut plus &ecirc;tre d&eacute;truite.";
$lang['info'][42]['name']         = "Phalange de capteur";
$lang['info'][42]['description']  = "Des capteurs de haute d&eacute;finition scannent le spectre complet des fr&eacute;quences de tous les rayonnements qui atteignent la phalange. Des ordinateurs de haute performance combinent des oscillations &eacute;nerg&eacute;tiques minuscules et de cette fa&ccedil;on gagnent des informations concernant le mouvement de vaisseaux sur des plan&egrave;tes &eacute;loign&eacute;es. Un tel scanner a besoin d'&eacute;nergie sous forme de deut&eacute;rium.";
$lang['info'][43]['name']         = "Porte de saut spatial";
$lang['info'][43]['description']  = "Les portes de saut spatial sont d'immenses &eacute;metteurs permettant de transporter des vaisseaux &agrave; travers la galaxie sans perte de temps. Cette tranmission n&eacute;cessite une technologie &eacute;lev&eacute;e et une &eacute;norme quantit&eacute; d'&eacute;nergie.";

$lang['info'][44]['name']         = "Silo de missiles";
$lang['info'][44]['description']  = "Les silos de missiles servent &agrave; stocker les missiles. Chaque niveau de d&eacute;veloppement permet le stockage de cinq missiles interplan&eacute;taires ou de dix missiles d'interception. Un missile interplan&eacute;taire occupe la place de deux missiles d'interception. Les types de missiles se combinent &agrave; souhait.";

// ----------------------------------------------------------------------------------------------------------
// Laboratoire !
$lang['info'][106]['name']        = "Technologie Espionnage";
$lang['info'][106]['description'] = "La technologie d'espionnage se concentre surtout sur l'&eacute;tude approfondie de nouveaux capteurs plus efficaces. Plus cette technique est d&eacute;velopp&eacute;e, plus le joueur peut poss&eacute;der d'informations sur ce qui ce passe dans son environnement. Pour les sondages, c'est la diff&eacute;rence entre le propre niveau d'espionnage et le niveau adverse qui est d&eacute;terminante. Une technique d'espionnage plus &eacute;lev&eacute;e permet d'avoir plus d'informations dans son rapport mais aussi d'avoir une probabilit&eacute; moindre d'&ecirc;tre d&eacute;couvert en train d'espionner. En envoyant une grande quantit&eacute; de sondes, on augmente la chance de d&eacute;couvrir des d&eacute;tails mais on a aussi le danger d'&ecirc;tre d&eacute;couvert. La technique d'espionnage am&eacute;liore aussi l'observation des flottes adverses. Seul le niveau d'espionnage est d&eacute;terminant. D&egrave;s le niveau 2, l'affichage d'une attaque comporte le nombre de vaisseaux attaquants. Le niveau 4 permet de voir le type de vaisseaux attaquants et le nombre total de vaisseaux, le niveau 8 le nombre de vaisseaux de chaque type. Cette technologie est indispensable pour les raideurs, car elle permet de voir si la victime se donne les moyens de d&eacute;fendre l'attaque. Il est pr&eacute;f&eacute;rable de d&eacute;velopper cette technologie d&egrave;s le d&eacute;part, juste apr&egrave;s la recherche des petits transporteurs.";
$lang['info'][108]['name']        = "Technologie Ordinateur";
$lang['info'][108]['description'] = "La technologie ordinateur permet de d&eacute;velopper votre infrastructure informatique, les syst&egrave;mes devenant plus efficaces et plus performants. La vitesse et la performance de calcul augmentent, ceci permettant de commander plus de flottes &agrave; la fois. Chaque niveau de technologie ordinateur augmente d'une le nombre total de flottes commandables. Un plus grand nombre de flottes vous permet de raider plus et donc de gagner plus de ressources. Naturellement cette technologie sert aussi aux marchands, ceux-ci pouvant g&eacute;rer plus de flottes marchandes. C'est pourquoi il est recommand&eacute; de continuer de d&eacute;velopper cette technologie pendant tout le cours du jeu.";
$lang['info'][109]['name']        = "Technologie Armes";
$lang['info'][109]['description'] = "La technologie armes se concentre surtout sur la mise au point des syst&egrave;mes d'armes d&eacute;j&agrave; existants. Le but principal est d'approvisionner les syst&egrave;mes avec plus d'&eacute;nergie et de concentrer celle-ci. Ceci rend les syst&egrave;mes d'armes plus efficaces et plus destructeurs. Chaque niveau de technologie armes augmente la puissance des armes des unit&eacute;s par tranche de 10% de la valeur de base. La technologie armes est importante pour tenir ses unit&eacute;s comp&eacute;titives &agrave; long terme. Un d&eacute;veloppement permanent est recommand&eacute;.";
$lang['info'][110]['name']        = "Technologie Bouclier";
$lang['info'][110]['description'] = "La technologie de bouclier se concentre surtout sur le d&eacute;veloppement de nouvelles possibilit&eacute;s d'approvisionnement des boucliers avec de l'&eacute;nergie et permet donc de les rendre plus efficaces et r&eacute;sistants. Chaque niveau augmente l'efficacit&eacute; des boucliers par tranche de 10%.";
$lang['info'][111]['name']        = "Technologie Protection des vaisseaux spatiaux";
$lang['info'][111]['description'] = "Des alliages sp&eacute;ciaux rendent les vaisseaux spatiaux de plus en plus r&eacute;sistants. Une fois qu'un alliage puissant est d&eacute;velopp&eacute;, la structure mol&eacute;culaire des vaisseaux est transform&eacute;e par rayonnement et mise au point avec le meilleur alliage. L'efficacit&eacute; de la protection augmente de 10% par niveau atteint.";
$lang['info'][113]['name']        = "Technologie Energie";
$lang['info'][113]['description'] = "La technologie &eacute;nergie se concentre surtout sur le d&eacute;veloppement des r&eacute;seaux et du stockage d'&eacute;nergie. Une telle technologie bien d&eacute;velopp&eacute;e permet de stocker plus d'&eacute;nergie et de la transporter plus efficacement.";
$lang['info'][114]['name']        = "Technologie Hyperespace";
$lang['info'][114]['description'] = "L'int&eacute;gration de la 4eme et 5eme dimension permet le d&eacute;veloppement d'un nouveau genre de propulsion plus puissant et efficace.";
$lang['info'][115]['name']        = "R&eacute;acteur &agrave; combustion";
$lang['info'][115]['description'] = "Les r&eacute;acteurs &agrave; combustion fonctionnent par le principe approuv&eacute; de la r&eacute;action. De la mati&egrave;re &agrave; temp&eacute;rature tr&egrave;s &eacute;lev&eacute;e est repouss&eacute;e et propulse le vaisseau dans la direction oppos&eacute;e. La port&eacute;e de ces r&eacute;acteurs est assez limit&eacute;e, mais ils sont bon march&eacute;, fiables et n'ont gu&egrave;re besoin de maintenance. En outre ils ont besoin de moins de place et se trouvent donc souvent sur des vaisseaux de petite taille. Le d&eacute;veloppement de ces r&eacute;acteurs rend les vaisseaux plus rapides mais &agrave; chaque niveau la vitesse n'augmente que de 10%. Comme les r&eacute;acteurs &agrave; combustion interne sont la base de l'astronautique, il est pr&eacute;f&eacute;rable de les d&eacute;velopper le plus t&ocirc;t possible. Apr&egrave;s, il est tr&egrave;s important de les am&eacute;liorer pour avoir des vaisseaux de type transporteur et des recycleurs plus rapides.";
$lang['info'][117]['name']        = "R&eacute;acteur &agrave; impulsion";
$lang['info'][117]['description'] = "Le r&eacute;acteur &agrave; impulsion est bas&eacute; sur le principe de r&eacute;action disant que la plus grande part de la masse du rayon est gagn&eacute;e comme sous-produit de la fusion d'atomes qui sert &agrave; produire l'&eacute;nergie n&eacute;cessaire. De la masse suppl&eacute;mentaire peut &ecirc;tre initi&eacute;e.";
$lang['info'][118]['name']        = "Propulsion hyperespace";
$lang['info'][118]['description'] = "Par une d&eacute;formation spatiale et temporelle dans l'environnement du vaisseau, l'espace est comprim&eacute; ce qui permet de parcourir de longues distances dans un minimum de temps. Une propulsion d'hyperespace tr&egrave;s d&eacute;velopp&eacute;e permet de comprimer l'espace encore plus, ce qui augmente la vitesse des vaisseaux de 30% par niveau. N&eacute;cessite : Technologie Hyperespace (Niveau 3) Laboratoire de recherche (Niveau 7)";
$lang['info'][120]['name']        = "Technologie Laser";
$lang['info'][120]['description'] = "Le Laser (Renforcement de lumi&egrave;re) cr&eacute;e un rayon intense et riche en &eacute;nergie de lumi&egrave;re coh&eacute;rente. Ces installations servent dans beaucoup de domaines, p. e. aux ordinateurs optiques, armes de laser qui peuvent d&eacute;truire la protection d'un vaisseau sans probl&egrave;mes et autres. La technologie laser est une base importante pour le d&eacute;veloppement d'autres technologies d'armes. N&eacute;cessite : Laboratoire de recherche (Niveau 1) Technologie d'&eacute;nergie (Niveau 2)";
$lang['info'][121]['name']        = "Technologie Ions";
$lang['info'][121]['description'] = "Rayon mortel compos&eacute; d'ions acc&eacute;l&eacute;r&eacute;s. En touchant un objet, il cause des d&eacute;g&acirc;ts importants.";
$lang['info'][122]['name']        = "Plasma";
$lang['info'][122]['description'] = "Un rayon &eacute;volutif de la technologie ions avec un puissance d&eacute;vastatrice.";
$lang['info'][123]['name']        = "R&eacute;seau de recherche intergalactique";
$lang['info'][123]['description'] = "Les chercheurs de plusieurs plan&egrave;tes utilisent ce r&eacute;seau pour communiquer.<br>Un laboratoire est ajout&eacute; au r&eacute;seau pour chaque niveau de recherche. Les laboratoires les plus d&eacute;velopp&eacute;s seront connect&eacute;s entre eux.";
$lang['info'][124]['name']        = "Technologie Exp&eacute;ditions";
$lang['info'][124]['description'] = "La technologie d'exp&eacute;dition contient diverses technologies de scan et permet aux vaisseaux de tailles diff&eacute;rentes d'&ecirc;tre &eacute;quip&eacute;s de modules de recherche. Ceux-ci contiennent une base de donn&eacute;es et un petit laboratoire mobile. Pour ne pas mettre en p&eacute;ril la s&eacute;curit&eacute; du vaisseau, le module de recherche est &eacute;quip&eacute; de son propre bloc &eacute;nerg&eacute;tique et d'un g&eacute;n&eacute;rateur de champ &eacute;nerg&eacute;tique, qui englobe le module de recherche en cas d'urgence.";
$lang['info'][199]['name']        = "Graviton";
$lang['info'][199]['description'] = "Le graviton est un champ &eacute;nerg&eacute;tique qui permet d'avoir une gravit&eacute; minime et un d&eacute;placement plus facile.";

// ----------------------------------------------------------------------------------------------------------
// Flotte !
$lang['info'][202]['name']        = "Petit transporteur";
$lang['info'][202]['description'] = "Les petits transporteurs ont &agrave; peu pr&egrave;s la m&ecirc;me taille que les chasseurs, mais n'ont pas de propulsion puissante ou d'armes, afin d'avoir plus de place pour le fret. Le vaisseau de type petit transporteur peut transporter 5.000 unit&eacute;s de ressources. Le grand transporteur peut transporter cinq fois plus de fret. En m&ecirc;me temps sa protection et sa propulsion sont plus puissantes. En raison de leur puissance de tir limit&eacute;e, les vaisseaux de type petit transporteur sont souvent escort&eacute;s par d'autres vaisseaux.<br><br>Le d&eacute;veloppement du r&eacute;acteur &agrave; impulsion au niveau 5 permet de r&eacute;&eacute;quiper le petit transporteur avec ce type de r&eacute;acteurs, acc&eacute;l&eacute;rant alors sensiblement ce vaisseau.";
$lang['info'][203]['name']        = "Grand transporteur";
$lang['info'][203]['description'] = "Ce vaisseau n'a gu&egrave;re d'armes ou d'autres technologies &agrave; bord. Il est donc pr&eacute;f&eacute;rable de lui fournir une escorte qui lui permet de profiter de toute sa capacit&eacute; de fret. Avec son r&eacute;acteur de combustion de haute performance, le grand transporteur sert pour transporter rapidement des ressources entre les plan&egrave;tes et bien s&ucirc;r il accompagne les flottes durant leurs attaques sur d'autres plan&egrave;tes pour pouvoir conqu&eacute;rir le nombre maximal de ressources.";
$lang['info'][204]['name']        = "Chasseur L&eacute;ger";
$lang['info'][204]['description'] = "Le chasseur l&eacute;ger est un vaisseau tr&egrave;s manoeuvrable qui est stationn&eacute; sur presque toutes les plan&egrave;tes. Les co&ucirc;ts ne sont pas tr&egrave;s importants, mais la puissance du bouclier et la capacit&eacute; de fret sont tr&egrave;s limit&eacute;es.";
$lang['info'][205]['name']        = "Chasseur Lourd";
$lang['info'][205]['description'] = "La propulsion conventionnelle n'&eacute;tait plus suffisante pour le d&eacute;veloppement des chasseurs lourds. Pour rendre les futurs vaisseaux plus rapides, les ing&eacute;nieurs eurent recours au r&eacute;acteur &agrave; impulsions. Ceci augmente certe les c&ocirc;uts de production, mais &eacute;largit les possibilit&eacute;s. L'arriv&eacute;e de cette propulsion permet d'utiliser plus d'&eacute;nergie pour les armes et la protection, de plus ces vaisseaux sont produits avec des mat&eacute;riaux d'une meilleure qualit&eacute;. Ceci am&eacute;liore l'int&eacute;grit&eacute; structurelle et la puissance de tir. Le Chasseur Lourd est donc un vaisseau beaucoup plus mena&ccedil;ant que son petit fr&egrave;re, le chasseur l&eacute;ger. Ce changement fait du chasseur lourd la technologie de base pour la technologie des croiseurs.";
$lang['info'][206]['name']        = "Croiseur";
$lang['info'][206]['description'] = "Le d&eacute;veloppement des lasers lourds et des canons d'ions sonn&egrave;rent le glas de l'&eacute;poque des chasseurs. Malgr&eacute; de nombreuses modifications, la puissance des Armements et de la protection ne purent &ecirc;tre assez am&eacute;lior&eacute;es pour pouvoir battre ces canons de d&eacute;fense. Il fut donc d&eacute;cid&eacute; de construire une nouvelle classe de vaisseaux avec plus de protection et de puissance de tir. Le Croiseur &eacute;tait cr&eacute;&eacute;. Les Croiseurs ont une protection presque trois fois plus grande que celle des chasseurs lourds et leur puissance de tir est plus que deux fois plus puissante. De plus, ils sont tr&egrave;s rapides. Il n'y a pas d'arme plus puissante contre la d&eacute;fense moyenne. Les Croiseurs ont domin&eacute; l'espace pendant presque un si&egrave;cle. L'apparition de l'artillerie &eacute;lectromagn&eacute;tique et des lanceurs de plasma a mis fin &agrave; leur domination. Pourtant ils servent encore souvent dans les batailles contre les unit&eacute;s de chasseurs.";
$lang['info'][207]['name']        = "Vaisseau de Bataille";
$lang['info'][207]['description'] = "Les Vaisseaux de Batailles jouent un r&ocirc;le central dans les flottes. Avec leur artillerie lourde, leur vitesse consid&eacute;rable et la grande capacit&eacute; de fret, ils sont des adversaires respectables.";
$lang['info'][208]['name']        = "Vaisseau de Colonisation";
$lang['info'][208]['description'] = "Ce vaisseau bien prot&eacute;g&eacute; sert &agrave; la conqu&ecirc;te de nouvelles plan&egrave;tes, ce qui est fondamental pour un empire ambitieux. Pour coloniser une nouvelle plan&egrave;te, ce vaisseau y est d&eacute;mont&eacute; et ces mat&eacute;riaux servent comme ressources pour la conqu&ecirc;te de la plan&egrave;te. Pour chaque empire le nombre maximal de plan&egrave;tes qui peuvent &ecirc;tre colonis&eacute;es en plus de la plan&egrave;te-m&egrave;re est de 8.";
$lang['info'][209]['name']        = "Recycleur";
$lang['info'][209]['description'] = "Les dimensions des batailles spatiales se sont constamment &eacute;largies. Des milliers de vaisseaux ont &eacute;t&eacute; construits, mais les Champs de d&eacute;bris semblaient &ecirc;tre perdus pour toujours. Les cargos ne pouvaient pas s'approcher des Champs de d&eacute;bris sans prendre le risque d'&ecirc;tre endommag&eacute;s consid&eacute;rablement par des d&eacute;combres. Un nouveau d&eacute;veloppement dans le domaine de la technologie des boucliers a permis de construire cette nouvelle classe de vaisseau comparable aux grands cargos, le recycleur. Gr&acirc;ce au recycleur, les ressources qui semblaient &ecirc;tre perdues peuvent quand m&ecirc;me &ecirc;tre exploit&eacute;es. M&ecirc;me les d&eacute;combres de petite taille ne les menacent pas gr&acirc;ce &agrave; leurs nouveaux boucliers. Malheureusement ces installations ont besoin d'espace ce qui limite la capacit&eacute; de fret &agrave; 20.000 unit&eacute;s.";
$lang['info'][210]['name']        = "Sonde d'espionnage";
$lang['info'][210]['description'] = "Les sondes d'espionnage sont des petits drones manoeuvrables qui espionnent les plan&egrave;tes m&ecirc;me &agrave; grande distance. Leurs r&eacute;acteurs de haute performance leur permettent de parcourir de longues distances en quelques secondes. D&egrave;s qu'elles atteignent l'orbite d'une plan&egrave;te elles s'y installent et l'espionnent. Pendant cette activit&eacute;, l'ennemi peut facilement les d&eacute;couvrir et attaquer. Pour limiter leur taille, elles n'ont pas de protection, de bouclier ou d'Armements, voila pourquoi on peut facilement les d&eacute;truire.";
$lang['info'][211]['name']        = "Bombardier";
$lang['info'][211]['description'] = "Le Bombardier a &eacute;t&eacute; d&eacute;velopp&eacute; pour pouvoir d&eacute;truire les installations de d&eacute;fense des plan&egrave;tes. Avec une lunette laser il lance des bombes de plasma de fa&ccedil;on cibl&eacute;e sur la surface des plan&egrave;tes et y cause des d&eacute;g&acirc;ts d&eacute;vastateurs.<br><br>D&eacute;truit la d&eacute;fense plan&eacute;taire.<br><br>Le d&eacute;veloppement de la propulsion hyperespace au niveau 8 permet de r&eacute;&eacute;quiper le Bombardier avec ce type de propulseurs, acc&eacute;l&eacute;rant alors sensiblement ce vaisseau.";
$lang['info'][212]['name']        = "Satellite solaire";
$lang['info'][212]['description'] = "Les satellites solaires sont positionn&eacute;s dans une orbite g&eacute;ostationnaire autour d'une plan&egrave;te. Ils collectent la lumi&egrave;re du soleil et la transmettent par laser &agrave; la station de base. L'efficacit&eacute; des satellites solaires d&eacute;pend de la lumi&egrave;re du soleil. Naturellement la quantit&eacute; d'&eacute;nergie est plus grande quand l'orbite est proche du soleil. Avec leur efficacit&eacute;, les satellites solaires sont la solution pour les probl&egrave;mes d'&eacute;nergie de beaucoup de plan&egrave;tes. Attention: Les satellites solaires peuvent &ecirc;tre d&eacute;truits pendant une bataille.";
$lang['info'][213]['name']        = "Destructeur";
$lang['info'][213]['description'] = "Le Destructeur est le roi des vaisseaux de guerre. Ses tours de guerre avec artillerie d'ions, plasma et &eacute;lectromagn&eacute;tiques peuvent, gr&acirc;ce &agrave; ses capteurs de cible, toucher des chasseurs rapides avec presque 99% de certitude. Comme ils sont tr&egrave;s grands, leur facult&eacute; de manoeuvrer est tr&egrave;s limit&eacute;e. Pendant une bataille ils sont donc plus comparables &agrave; une station de guerre qu'&agrave; un vaisseau de guerre. Leur consommation d Hydrog&eacute;ne est aussi grande que leur puissance dans la bataille.";
$lang['info'][214]['name']        = "&eacute;toile de la mort";
$lang['info'][214]['description'] = "L'&eacute;toile de la mort est &eacute;quip&eacute;e d'une artillerie g&eacute;ante de gravitons qui permet de d&eacute;truire des vaisseaux de la taille des Destructeurs ou m&ecirc;me d'une lune. Comme ceci &agrave; besoin d'une quantit&eacute; d'&eacute;nergie gigantesque elle se compose presque enti&egrave;rement de g&eacute;n&eacute;rateurs. Un vaisseau de cette taille et de cette puissance a besoin d'une gigantesque quantit&eacute; de ressources et d'ouvriers qui ne peuvent &ecirc;tre fournis que par des empires spatiaux important.";
$lang['info'][215]['name']        = "Traqueur";
$lang['info'][215]['description'] = "Ce vaisseau au fuselage filiforme est ideal pour detruire des convois ennemis. Ses Armements laser nouvelle generation le rendent capable d'affronter un grand nombre de vaisseaux en meme temps. A cause de son fuselage etroit et de son armement important, les capacites disponibles pour le transport de ressources sont tres limitees. Ceci est compense par l'utilisation de reacteurs propulsion hyperespace, peu gourmands en carburant.";

// ----------------------------------------------------------------------------------------------------------
// Defenses !
$lang['info'][401]['name']        = "Lanceur de Missilles";
$lang['info'][401]['description'] = "Le Lanceur de missiles est une fa&ccedil;on simple et bon march&eacute; de se d&eacute;fendre. Comme il n'est qu'une &eacute;volution d'Armements balistiques habituelles, il n'a pas besoin de recherche. Ses faibles frais de production permettent de s'en servir pour la d&eacute;fense contre des petites flottes, par contre au fur et &agrave; mesure il perd de son importance. Apr&egrave;s il ne sert qu'&agrave; intercepter des missiles. Des rumeurs existent affirmant que les militaires sont en train de d&eacute;velopper de nouveaux lanceurs. Les installations de d&eacute;fense sont d&eacute;sactiv&eacute;es d&egrave;s qu'elles sont trop endommag&eacute;es. Apr&egrave;s une bataille, jusqu'&agrave; 70% des syst&egrave;mes endommag&eacute;s peuvent &ecirc;tre r&eacute;par&eacute;s.";
$lang['info'][402]['name']        = "Artillerie laser l&eacute;ger";
$lang['info'][402]['description'] = "Pour pouvoir compenser les d&eacute;veloppements &eacute;normes de la technologie Vaisseaux, les chercheurs ont d&ucirc; d&eacute;velopper un syst&egrave;me de d&eacute;fense capable de battre des vaisseaux plus grands et mieux &eacute;quip&eacute;s. Ceci &eacute;tait la naissance du blaster l&eacute;ger. Le bombardement concentr&eacute; de photons peut causer des d&eacute;g&acirc;ts nettement plus importants que les Armements balistiques habituelles. De plus, on l'a aussi &eacute;quip&eacute;e d'un bouclier plus puissant pour pouvoir r&eacute;sister aux nouvelles classes de vaisseaux. Pour garder des frais de production raisonnables, la structure n'a pas &eacute;t&eacute; renforc&eacute;e. Le laser l&eacute;ger offre une performance importante par rapport aux faibles frais et est donc est tr&egrave;s int&eacute;ressant, m&ecirc;me pour des civilisations plus d&eacute;velopp&eacute;es. Les installations de d&eacute;fense sont d&eacute;sactiv&eacute;es d&egrave;s qu'elles sont trop endommag&eacute;es. Apr&egrave;s une bataille, jusqu'&agrave; 70% des syst&egrave;mes endommag&eacute;s peuvent &ecirc;tre r&eacute;par&eacute;s.";
$lang['info'][403]['name']        = "Artillerie laser lourde";
$lang['info'][403]['description'] = "Le blaster lourd au laser est l'&eacute;volution cons&eacute;quente du blaster leger au laser. La structure est renforc&eacute;e et am&eacute;lior&eacute;e avec des nouveaux mat&eacute;riaux. La structure est donc plus r&eacute;sistante. En m&ecirc;me temps ont &eacute;t&eacute; aussi am&eacute;lior&eacute;s le syst&egrave;me d'&eacute;nergie et l'ordinateur de cible, ce qui permet de concentrer plus d'&eacute;nergie sur un objet. Les installations de d&eacute;fense sont d&eacute;sactiv&eacute;es d&egrave;s qu'elles sont trop endommag&eacute;es. Apr&egrave;s une bataille jusqu'&agrave; 70% des syst&egrave;mes endommag&eacute;s peuvent &ecirc;tre r&eacute;par&eacute;s.";
$lang['info'][404]['name']        = "Canon de Gauss";
$lang['info'][404]['description'] = "Pendant longtemps on a pens&eacute; que les Armements &agrave; projectiles seraient comme la technologie de la fusion et de l'&eacute;nergie, le d&eacute;veloppement de la propulsion de hyperespace et le d&eacute;veloppement de protections am&eacute;lior&eacute;es resteraient antiques jusqu'&agrave; ce que la technologie de l'&eacute;nergie, qui l'avait &eacute;vinc&eacute; &agrave; l'&eacute;poque, les a remises en jeu. Le principe &eacute;tait d&eacute;j&agrave; connu au 20i&egrave;me et au 21i&egrave;me si&egrave;cle - le principe d'acc&eacute;l&eacute;ration de particules. Un canon de Gauss (Canon &eacute;lectromagn&eacute;tique) n'est en fait rien d'autre qu'une version nettement plus grande du canon. Des projectiles qui p&egrave;sent des tonnes sont acc&eacute;l&eacute;r&eacute;s magn&eacute;tiquement et atteignent une vitesse telle que les particules de salet&eacute; autour du projectile br&ucirc;lent et le recul fait trembler la terre. M&ecirc;me les protections et boucliers modernes ont du mal &agrave; r&eacute;sister &agrave; cette force, ce n'est pas rare qu'un projectile traverse compl&egrave;tement un objet. Les installations de d&eacute;fense sont d&eacute;sactiv&eacute;es d&egrave;s qu'elles sont trop endommag&eacute;es. Apr&egrave;s une bataille, jusqu'&agrave; 70% des syst&egrave;mes endommag&eacute;s peuvent &ecirc;tre r&eacute;par&eacute;s.";
$lang['info'][405]['name']        = "Artillerie &agrave; ions";
$lang['info'][405]['description'] = "Au 21eme si&egrave;cle existait quelque chose qui se nommait PEM. Le PEM &eacute;tait le pouls &eacute;lectromagn&eacute;tique qui causait une tension suppl&eacute;mentaire dans chaque circuit, ce qui causait de nombreux incidents bloquants tous les appareils sensibles. &agrave; l'&eacute;poque, le PEM &eacute;tait bas&eacute; sur les missiles et les bombes, entre autre en relation avec des bombes atomiques. Ensuite, le PEM a &eacute;t&eacute; am&eacute;lior&eacute; pour rendre des objets incapables d'agir sans les d&eacute;truire et donc de les reprendre. Aujourd'hui, l'artillerie d'ions est la version la plus moderne du PEM. Elle lance une vague d'ions sur l'objet, ceci d&eacute;stabilise les boucliers et les parties &eacute;lectroniques - tant qu'il n'y a pas de bouclier &eacute;lectronique. Sa puissance kin&eacute;tique n'est pas importante. Les Croiseurs se servent eux aussi de la technologie d'ions, c'est d'ailleurs le seul type de vaisseau, les autres types ne disposant pas des quantit&eacute;s d'&eacute;nergie n&eacute;cessaires. Il est souvent int&eacute;ressant de ne pas d&eacute;truire un vaisseau mais de le paralyser. Les syst&egrave;mes de d&eacute;fense se d&eacute;sactivent d&egrave;s qu'ils sont trop endommag&eacute;s. Apr&egrave;s une bataille jusqu'&agrave; 70% des syst&egrave;mes endommag&eacute;s peuvent &ecirc;tre r&eacute;par&eacute;s.";
$lang['info'][406]['name']        = "Lanceur de plasma";
$lang['info'][406]['description'] = "La technologie laser a ensuite &eacute;t&eacute; perfectionn&eacute;e, la technologie d'ions a atteint sa phase finale. On pensait qu'il serait impossible de rendre les syst&egrave;mes d'Armements encore plus efficaces. La possibilit&eacute; de combiner les deux syst&egrave;mes a chang&eacute; la situation. D&eacute;j&agrave; connue de la technologie de fusion, des lasers chauffent des particules (le plus souvent Hydrog&eacute;ne) &agrave; une temp&eacute;rature extr&ecirc;me, parfois jusqu'&agrave; des millions de degr&eacute;s. La technologie d'ions permet le chargement &eacute;lectrique des particules, les r&eacute;seaux de stabilit&eacute; et l'acc&eacute;l&eacute;ration des particules. En &eacute;chauffant la charge, en la mettant sous pression et l'ionisant, on la lance par acc&eacute;l&eacute;ration dans l'espace en direction d'un objet. La balle de plasma est bleue et visuellement fascinante, par contre il est difficile de s'imaginer que l'&eacute;quipage du vaisseau cibl&eacute; soit tr&egrave;s heureux de la voir... Le lanceur de plasma est une des Armements les plus mena&ccedil;antes, mais cette technologie est assez ch&egrave;re. Les syst&egrave;mes de d&eacute;fense se d&eacute;sactivent d&egrave;s qu'ils sont trop endommag&eacute;s. Apr&egrave;s une bataille jusqu'&agrave; 70% des syst&egrave;mes endommag&eacute;s peuvent &ecirc;tre r&eacute;par&eacute;s.";
$lang['info'][407]['name']        = "Petit bouclier";
$lang['info'][407]['description'] = "Longtemps avant l'installation des g&eacute;n&eacute;rateurs de bouclier sur des vaisseaux, existaient d&eacute;j&agrave; des g&eacute;n&eacute;rateurs g&eacute;ants sur la surface des plan&egrave;tes. Ceux-ci permettaient de couvrir les plan&egrave;tes avec des champs infranchissables qui pouvaient absorber des quantit&eacute;s &eacute;normes avant de s'effondrer. Des petites flottes d'attaques &eacute;chouent souvent contre ces boucliers. Ces boucliers peuvent &ecirc;tre am&eacute;lior&eacute;s. Apr&egrave;s, on peut m&ecirc;me construire un grand bouclier qui est encore plus puissant. Pour chaque plan&egrave;te on ne peut construire qu'un seul bouclier.";
$lang['info'][408]['name']        = "Grand bouclier";
$lang['info'][408]['description'] = "L'am&eacute;lioration du petit bouclier. Il est bas&eacute; sur la m&ecirc;me technologie mais peut se servir de nettement plus d'&eacute;nergie pour se d&eacute;fendre.";

// ----------------------------------------------------------------------------------------------------------
// Missiles !
$lang['info'][502]['name']        = "Missile Interception";
$lang['info'][502]['description'] = "Le missile interception d&eacute;truit les missiles adverses. Chaque missile d'interception d&eacute;truit un missile interplan&eacute;taire.";
$lang['info'][503]['name']        = "Missile Interplan&eacute;taire";
$lang['info'][503]['description'] = "Les missiles interplan&eacute;taires d&eacute;truisent la d&eacute;fense adverse. Les syst&egrave;mes de d&eacute;fense d&eacute;truits par des missiles interplan&eacute;taires ne se r&eacute;parent pas.";

// ----------------------------------------------------------------------------------------------------------
// Officiers !
$lang['info'][601]['name']        = "G&eacute;ologue";
$lang['info'][601]['description'] = "Le g&eacute;ologue est un expert reconnu en astromin&eacute;ralogie et en astrocristallographie. Avec son &eacute;quipe d'experts en m&eacute;tallurgie et d'ing&eacute;nieurs chimiste, il assiste les gouvernements interplan&eacute;taires dans la recherche de nouvelles sources de mati&egrave;res premi&egrave;res et optimise le raffinage de celles-ci.<br><br>+5% de production. Niveau Max. : 20";
$lang['info'][602]['name']        = "Amiral";
$lang['info'][602]['description'] = "L'amiral de la flotte est un v&eacute;t&eacute;ran de guerre et un strat&egrave;ge redout&eacute;. M&ecirc;me lorsque le combat est acharn&eacute;, il garde le sang froid n&eacute;cessaire pour dominer la situation et est en contact permanent avec les amiraux sous ses ordres. Un empereur responsable ne saurait se passer de l'amiral de la flotte pour coordonner ses attaques et peut lui faire une telle confiance qu'il peut envoyer plus de flottes en combat.<br><br>+5% de bouclier, protection des vaisseaux et armes sur les vaisseaux. Niveau Max. : 20";
$lang['info'][603]['name']        = "Ingenieur";
$lang['info'][603]['description'] = "L'ing&eacute;nieur est un sp&eacute;cialiste de la gestion d'&eacute;nergie. En temps de paix, il optimise l'efficacit&eacute; des r&eacute;seaux d'&eacute;nergie des colonies.<br><br>+5% d'energie. Niveau Max. : 10";
$lang['info'][604]['name']        = "Technocrate";
$lang['info'][604]['description'] = "Les guildes de technocrates sont des scientifiques au g&eacute;nie reconnu. On les trouve aux endroits o&ugrave; la technique atteint ses limites. Personne ne parviendra &agrave; d&eacute;chiffrer le cryptage d'un technocrate, sa seule pr&eacute;sence inspire les chercheurs de tout l'empire.<br><br>-5% de temps de construction des vaisseaux. Niveau Max : 10";
$lang['info'][605]['name']        = "Constructeur";
$lang['info'][605]['description'] = "Le constructeur est un nouveau type de b&acirc;tisseur. Son ADN a &eacute;t&eacute; modifi&eacute;e pour lui conf&eacute;rer une force surhumaine. Un seul de ces \"homme\" peut construire une ville enti&egrave;re.<br><br>-10% de temps de construction. Niveau Max. : 3";
$lang['info'][606]['name']        = "Scientifique";
$lang['info'][606]['description'] = "Les scientifiques font partis d'une guilde concurente &agrave; celle des technocrates. Ils sont sp&eacute;cialis&eacute;s dans l'am&eacute;lioration des technologies.<br><br>-10% de temps de recherche. Niveau Max. : 3";
$lang['info'][607]['name']        = "Stockeur";
$lang['info'][607]['description'] = "Le stockeur fait parti de l'ancienne confr&eacute;rie de le plan&egrave;te Hsac. Sa devise est de gagner un maximum mais pour cel&agrave; il lui faut des espaces de stockage important. C'est pourquoi &agrave; l'aide du constructeur il a d&eacute;velopp&eacute; une nouvelle technique de stockage.<br><br>+50% de stockage. Niveau Max. : 2";
$lang['info'][608]['name']        = "Defenseur";
$lang['info'][608]['description'] = "Le defenseur est membre de l'arm&eacute;e imperiale. Son ardeur dans son travail lui permet de construire une d&eacute;fense redoutable en peu de temps dans les colonies hostile.<br><br>-50% de temps de construction de la d&eacute;fense.";
$lang['info'][609]['name']        = "Bunker";
$lang['info'][609]['description'] = "L'empereur a remarqu&eacute; le travail impressionnant que vous avez fournit &agrave; son empire. Pour vous remerciez il vous offre la chance de devenir Bunker. Le Bunker est la plus haute distinction de la branche Mini&egrave;re de l'arm&eacute;e imp&eacute;riale.<br><br>D&eacute;blocage du Protecteur Plan&egrave;taire";
$lang['info'][610]['name']        = "Espion";
$lang['info'][610]['description'] = "L'espion est une personne &eacute;nigmatique. Personne n'a jamais vu son visage r&eacute;el, a moins d'&ecirc;tre d&eacute;j&ageave; mort.<br><br>+5 Lvl D'espionnage. Niveau Max. : 2";
$lang['info'][611]['name']        = "Commandant";
$lang['info'][611]['description'] = "Le commandant de l'arm&eacute;e imp&eacute;riale est pass&eacute; ma&icirc;tre dans l'art du maniement des flottes. Son cerveau peut calculer les trajectoires de nombreuses flotte, beaucoup plus que celle d'un humain normal.<br><br>+3 slots de flottes. Niveau Max. : 3";
$lang['info'][612]['name']        = "Destructeur";
$lang['info'][612]['description'] = "Le destructeur est un officier sans piti&eacute;. Il a massacr&eacute; des plan&egrave;tes enti&egrave;res juste pour son plaisir. Il d&eacute;veloppe actuellement une nouvelle m&eacute;thode de production des &eacute;toiles de la mort.<br><br>2 RIP construites au lieu d'une. Niveau Max. : 1";
$lang['info'][613]['name']        = "General";
$lang['info'][613]['description'] = "Le General est une v&eacute;n&eacute;rable personne qui a servit de nombreuses ann&eacute;es dans l'arm&eacute;e. Les ouvrier constructeur de vaisseaux produisent plus vite en sa pr&eacute;sence.<br><br>+25% de vitesse des vaisseaux. Niveau Max. : 3";
$lang['info'][614]['name']        = "Raideur";
$lang['info'][614]['description'] = "L'empereur a rep&eacute;r&eacute; en vous des qualit&eacute;s ind&eacute;niable de conqu&eacute;rent. Il vous propose de devenir Raideur. Le Raideur est le grade le plus &eacute;lev&eacute; de la branche des raideurs de l'arm&eacute;e imp&eacute;riale<br><br>D&eacute;blocage de la SuperNova";
$lang['info'][615]['name']        = "Empereur";
$lang['info'][615]['description'] = "Vous avez montr&eacute; que vous &ecirc;tiez le plus grand conqu&eacute;rant de l'univers. Il est tant pour vous de prendre la place qui vous revient.<br><br>D&eacute;blocage du Destructeur Plan&egrave;taire";

?>