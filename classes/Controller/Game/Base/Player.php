<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Date: 3/7/14
 * Time: 1:28 AM
 * Something meaningful about this file
 *
 */

class Controller_Game_Base_Player extends Controller
{

	public function action_tap()
	{
		$post = $this->request->post();

		$output = array(
			'post' => $post,
		);

		$output['score'] = rand(1, 234920);
		$output['action'] = 'score_update';


		$output= json_encode($output);
		$redis = new Redis();
		$redis->connect('127.0.0.1', 6379);
		$redis->publish('realtime', $output); // New score.




		echo json_encode($output);
	}
}
