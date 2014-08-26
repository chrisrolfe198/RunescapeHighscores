<?php

use ThatChrisR\RunescapeHighscores\Highscores\RunescapeHighscores;

function dd($value)
{
	$value = var_dump($value);

	echo "<pre>{$value}</pre>";
	exit;
}

require 'vendor/autoload.php';

error_reporting(E_ALL); ini_set('display_errors', '1');

$c = new RunescapeHighscores();

$p = $c->get_players(['Das Wanderer', 'Bexs']);
$sp = $c->get_player('Das Wanderer');

var_dump($c::$players);
