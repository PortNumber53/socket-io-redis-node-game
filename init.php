<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Date: 3/2/14
 * Time: 1:11 AM
 * Something meaningful about this file
 *
 */

if (! Route::$cache)
{
	Route::set('jsgame', 'game(/<controller>(/<action>(/<request>)))',
		array(
			'request'    => '[a-zA-Z0-9_/\-]+',
		))
		->defaults(array(
			'directory'  => 'Game',
			'controller' => 'Render',
			'action'     => 'Frame',
		));

}
