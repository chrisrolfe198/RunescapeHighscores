<?php

use ThatChrisR\RunescapeHighscores\Highscores\RunescapeHighscores;

require 'vendor/autoload.php';

$c = new RunescapeHighscores();

$p = $c->get_players(['Das Wanderer', 'Bexs']);

var_dump($p["Das Wanderer"]->attack);
