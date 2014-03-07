<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Date: 3/3/14
 * Time: 10:22 PM
 * Something meaningful about this file
 *
 */

class Task_Generate extends Minion_Task
{
	/**
	 * Generates a help list for all tasks
	 *
	 * @return null
	 */
	protected function _execute(array $params)
	{
		$colors = array();

		$codes = array(
			"#ff0000" => 'red',
			"#008000" => 'green',
			"#0000ff" => 'blue',
			"#ffff00" => 'yellow',
			"#00ffff" => 'cyan',
			"#ffffff" => 'white',
			"#000000" => 'black',
			"#c0c0c0" => 'gray',
			'#ffa500' => 'orange',
			'#ff00ff' => 'magenta',
			'#00ff00' => 'lime',
			'#a52a2a' => 'brown',
			'#800000' => 'maroon',
			'#808080' => 'silver',
		);
		$names = array_values($codes);
		$codes = array_keys($codes);

		$correct = 0;
		$count_correct = 0;
		$pick = $names[ (int) rand(0, count($names)-1)];
		for ($i = 0; $i < 6; $i++)
		{

			$code_pick = (int) rand(0, count($codes)-1);
			$name_pick = (int) rand(0, count($names)-1);

			if ($code_pick == $name_pick)
			{
				$correct = $i;
				$count_correct++;
			}
			$colors[] = array(
				'color' => $codes[$code_pick],
				'text'  => $names[$name_pick],
			);
		}


		$board = array(
			'pick' => $pick,
			'colors' => $colors,
		);
		$serialized = serialize($board);
		$output = array(
			'action' => 'board_update',
			'_id' => md5($serialized),
			'timestamp' => date('YmdHis'),
			'pick' => $pick,
			'colors' => $colors,
		);
		$output= json_encode($output);

		$redis = new Redis();
		$redis->connect('127.0.0.1', 6379);
		$redis->publish('realtime', $output); // New colors.

		echo $output;
		echo "\n\n";
	}
}
