<?php
/**
 * This file is part of Wootook
 *
 * @license http://www.gnu.org/licenses/gpl-3.0.txt
 * @see http://wootook.org/
 *
 * Copyright (c) 2009-Present, Wootook Support Team <http://wootook.org>
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
 * documentation for further information about customizing Wootook.
 *
 */

define('INSIDE' , true);
define('INSTALL' , false);
define('IN_ADMIN', true);
require_once dirname(dirname(__FILE__)) .'/application/bootstrap.php';

	if (in_array($user['authlevel'], array(LEVEL_ADMIN, LEVEL_OPERATOR, LEVEL_MODERATOR))) {
		includeLang('admin/multi');

		$query   = doquery("SELECT * FROM {{table}}", 'multi');

		$parse                 = $lang;
		$parse['adm_mt_table'] = "";
		$i                     = 0;

		$RowsTPL = gettemplate('admin/multi_rows');
		$PageTPL = gettemplate('admin/multi_body');

		while ($infos = $query->fetch(PDO::FETCH_ASSOC)) {
			$Bloc['player'] = $infos['player'];
			$Bloc['text']   = $infos['text'];

			$parse['adm_mt_table'] .= parsetemplate( $RowsTPL, $Bloc );
			$i++;
		}

		$parse['adm_mt_count'] = $i;

		$page = parsetemplate( $PageTPL, $parse );
		display( $page, $lang['adm_mt_title'], false, '', true);

	} else {
		message( $lang['sys_noalloaw'], $lang['sys_noaccess'] );
	}

?>