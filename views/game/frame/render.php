<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Date: 3/2/14
 * Time: 3:00 AM
 * Something meaningful about this file
 *
 */

?><html>

<head>
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
	<script type="text/javascript" src="http://static.portnumber53.dev/library/js/jquery.cookie.js"></script>
	<script type="text/javascript" src="/script/pubsub.js"></script>
	<script src="/socket.io/socket.io.js"></script>

	<script type="text/javascript" src="/appjs/game.js"></script>
<script>
	var socket = io.connect('http://jsgame.portnumber53.dev');

	socket.on('connect', function (data){
		setStatus('connected');
		socket.emit('subscribe', {channel: 'realtime'});
	});

	socket.on('reconnecting', function(data) {
		setStatus('reconnecting');
	});

	socket.on('message', function (data) {
		addMessage(data);
	});

	function addMessage(json_data) {
		var obj = JSON.parse(json_data);

		if (obj.action == "score_update") {
			$("#player_score").html(obj.score);
		}

		if (obj.action == "board_update") {
			//console.log(obj.colors);
			board_id = obj._id;
			var html_cells = '';
			for (var i=0; i < obj.colors.length; i++) {

				html_cells += '<div data-color="'+obj.colors[i].color+'" data-text="'+obj.colors[i].text+'" class="game_cell" '
					+ ' style="background: '+obj.colors[i].color+'">'
					+ '<span class="white">'
					+ obj.colors[i].text
					+ '</span>'
					+ '<span class="black">'
					+ obj.colors[i].text
					+ '</span>'
					+ ''
					+ '</div>';

				/*
				$("#game_board > div.game_cell:nth-child("+(i+1)+")")
					.data('color', obj.colors[i].color)
					.data('text', obj.colors[i].text)
					.css({"background":obj.colors[i].color})
					.html('<span class="white">'+obj.colors[i].text+'</span>&nbsp;<span class="black">'+obj.colors[i].text+'</span>');
				*/
			}
			$("#cells").html(html_cells);
			$(".pick")
				.data('text', obj.pick)
				.html(obj.pick);
		}
	}

	function setStatus(msg) {
		console.log('Connection status: '+msg);
	}




</script>
	<style>
		#game_board {}
		#game_board .game_cell { float: left; width: 50%; height: 100px; font-size: 30px; text-align: center; line-height: 100px}
		#game_board .game_cell > span.white { color: black; background: white; padding: 5px; }
		#game_board .game_cell > span.black { color: white; background: black; padding: 5px; }
		#cells { width: 100%; display: block; }
		#cells:before, #cells:after, .clear { clear: both; }
		.pick { clear: both; display: block; height: 30px; width: 100%; background: #dddddd; line-height: 30px; text-align: center; font-size: 30px;}
	</style>
</head>
<body>
<table>
	<tr style="width:100%; height: 200px;">
		<td align="center" style="width: 30%; height: 100%; border: 1px solid #000;" >
			<p id="player_score" style="font-size: 100px;">0</p>
		</td>
	</tr>
</table>

<div id="game_board">

	<div id="pick1" class="pick"></div>
	<div class="clear"></div>
	<div id="cells"></div>
	<div class="clear"></div>
	<div id="pick2" class="pick"></div>
</div>



<script type="text/javascript">

	var player_id = $.cookie('player_id');
	console.log('Player_id: '+player_id);
	var board_id = 0;

	var game = new gameEngine('colores');

	game.startGame();


	$("#cells").on('click', '.game_cell', function() {
		console.log(this);
		console.log($(this).data('text'));


		data = {
			player_id: player_id,
			board_id: board_id,
			clicked: "something",
			channel: 'realtime'
		};
		$.ajax({
			type: "POST",
			url: "<?php echo URL::site(Route::get('jsgame')->uri(array('controller'=>'player', 'action'=>'tap',)), TRUE); ?>",
			data: data,
			success: function() {},
			dataType: "json"
		});

		console.log($(this).data('color'));




	});
</script>
</body>

</html>
