<?php

use ThatChrisR\RunescapeHighscores\Highscores\RunescapeHighscores;

require 'vendor/autoload.php';
$c = new RunescapeHighscores();

$p = $c->get_players(['Das Wanderer', 'TommyBoyDied', 'Bexs']);

var_dump($p["Das Wanderer"]->divination);
echo 'foobar';