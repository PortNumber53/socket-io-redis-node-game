<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Date: 3/2/14
 * Time: 1:39 AM
 * Something meaningful about this file
 *
 */

?><html>
<head>
	<title>Weird chat that needs to be disconnected first</title>
	<script src="/node/socket.io/socket.io.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js"></script>
</head>
<body>
<div id="username">
	<input type="text" name="usernameTxt" /> <input type="button" name="setUsername" value="Set Username" />
</div>
<div id="sendChat" style="display:none;">
	<input type="text" name="chatTxt" /> <input type="button" name="sendBtn" value="Send" />
</div>
<br />
<div id="content"></div>
<script>
	$(document).ready(function() {
		var username = "anonymous";
		$('input[name=setUsername]').click(function(){
			if($('input[name=usernameTxt]').val() != ""){
				username = $('input[name=usernameTxt]').val();
				var msg = {type:'setUsername',user:username};
				socket.json.send(msg);
			}
			$('#username').slideUp("slow",function(){
				$('#sendChat').slideDown("slow");
			});
		});
		var socket = new io.connect('http://brain.portnumber53.com:50000/');
		var content = $('#content');

		socket.on('connect', function() {
			console.log("Connected");
		});

		socket.on('message', function(message){
			content.append(message + '<br />');
		}) ;

		socket.on('disconnect', function() {
			console.log('disconnected');
			content.html("<b>Disconnected!</b>");
		});

		$("input[name=sendBtn]").click(function(){
			var msg = {type:'chat',message:username + " : " +  $("input[name=chatTxt]").val()}
			socket.json.send(msg);
			$("input[name=chatTxt]").val("");
		});
	});
</script>
</body>
</html>
