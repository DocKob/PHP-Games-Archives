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
// File: chat_server.php                                                          /
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

?>
<div id="chat" style="display:none;">
<div id="div_chat" style="height:150px;width:600px;overflow:auto;background:url('interface/img/trans.png');padding:5px;">
	
</div>
<form id="frmmain" name="frmmain" onsubmit="return blockSubmit();">
	<input type="text" id="txt_message" id="textfield" name="txt_message" style="background-color:transparent;width:520px;color:#fff;" />
	<input type="button" name="btn_send_chat" id="btn_send_chat" class="btn" value="Send" onclick="javascript:sendChatText();" /><br />
	<input type="button" name="btn_get_chat" id="btn_get_chat" class="btn" value="Refresh Chat" onclick="javascript:getChatText();" />
	<input type="button" name="btn_reset_chat" id="btn_reset_chat" class="btn" value="Reset Chat" onclick="javascript:resetChat();" />
</form>
</div>