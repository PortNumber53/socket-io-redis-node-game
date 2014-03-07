<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Date: 3/2/14
 * Time: 1:12 AM
 * Something meaningful about this file
 *
 */

class Controller_Game_Base_Render extends Controller
{
	static private $session = null;

	public function before()
	{
		parent::before();
		if (empty(self::$session))
		{
			self::$session = Session::instance('cookie');
		}
		if (empty(self::$session->get('player_id')))
		{
			$player_id = (int)rand(1, 999999999);
			self::$session->set('player_id', $player_id);
			setcookie("player_id", $player_id, time()+3600, "/");
		}
	}

	public function action_frame()
	{
		$player_id = self::$session->get('player_id');

		$main = View::factory('game/frame/render')->render();

		View::bind_global('player_id', $player_id);
		View::bind_global('main', $main);
		$this->response->body($main);
	}
}
