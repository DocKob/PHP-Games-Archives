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
// File: chat.php                                                                 /
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
<script>
var sendReq = getXmlHttpRequestObject();
var receiveReq = getXmlHttpRequestObject();
var lastMessage = 0;
var mTimer;
//Function for initializating the page.
function startChat() {
	//Set the focus to the Message Box.
	document.getElementById('txt_message').focus();
	//Start Recieving Messages.
	getChatText();
}		
//Gets the browser specific XmlHttpRequest Object
function getXmlHttpRequestObject() {
	if (window.XMLHttpRequest) {
		return new XMLHttpRequest();
	} else if(window.ActiveXObject) {
		return new ActiveXObject("Microsoft.XMLHTTP");
	} else {
		document.getElementById('p_status').innerHTML = 'Status: Cound not create XmlHttpRequest Object.  Consider upgrading your browser.';
	}
}

//Gets the current messages from the server
function getChatText() {
	if (receiveReq.readyState == 4 || receiveReq.readyState == 0) {
		receiveReq.open("GET", 'getChat.php?chat=1&last=' + lastMessage, true);
		receiveReq.onreadystatechange = handleReceiveChat; 
		receiveReq.send(null);
	}			
}
//Add a message to the chat server.
function sendChatText() {
	if(document.getElementById('txt_message').value == '') {
		alert("You have not entered a message");
		return;
	}
	if (sendReq.readyState == 4 || sendReq.readyState == 0) {
		sendReq.open("POST", 'getChat.php?chat=1&last=' + lastMessage, true);
		sendReq.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
		sendReq.onreadystatechange = handleSendChat; 
		var param = 'message=' + document.getElementById('txt_message').value;
		param += '&name=<? echo $name; ?>';
		param += '&chat=1';
		sendReq.send(param);
		document.getElementById('txt_message').value = '';
	}							
}
//When our message has been sent, update our page.
function handleSendChat() {
	//Clear out the existing timer so we don't have 
	//multiple timer instances running.
	clearInterval(mTimer);
	getChatText();
}
//Function for handling the return of chat text
function handleReceiveChat() {
	if (receiveReq.readyState == 4) {
		var chat_div = document.getElementById('div_chat');
		var xmldoc = receiveReq.responseXML;
		var message_nodes = xmldoc.getElementsByTagName("message"); 
		var n_messages = message_nodes.length
		for (i = 0; i < n_messages; i++) {
			var user_node = message_nodes[i].getElementsByTagName("user");
			var text_node = message_nodes[i].getElementsByTagName("text");
			var time_node = message_nodes[i].getElementsByTagName("time");
			chat_div.innerHTML += time_node[0].firstChild.nodeValue + " | ";
			chat_div.innerHTML += user_node[0].firstChild.nodeValue + ": ";
			chat_div.innerHTML += text_node[0].firstChild.nodeValue + '<br />';
			chat_div.scrollTop = chat_div.scrollHeight;
			lastMessage = (message_nodes[i].getAttribute('id'));
		}
		mTimer = setTimeout('getChatText();',2000); //Refresh our chat in 2 seconds
	}
}
//This functions handles when the user presses enter.  Instead of submitting the form, we
//send a new message to the server and return false.
function blockSubmit() {
	sendChatText();
	return false;
}
//This cleans out the database so we can start a new chat session.
function resetChat() {
	if (sendReq.readyState == 4 || sendReq.readyState == 0) {
		sendReq.open("POST", 'getChat.php?chat=1&last=' + lastMessage, true);
		sendReq.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
		sendReq.onreadystatechange = handleResetChat; 
		var param = 'action=reset';
		sendReq.send(param);
		document.getElementById('txt_message').value = '';
	}							
}
//This function handles the response after the page has been refreshed.
function handleResetChat() {
	document.getElementById('div_chat').innerHTML = '';
	getChatText();
}	
</script>