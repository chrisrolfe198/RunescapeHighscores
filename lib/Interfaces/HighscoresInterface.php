<?php

namespace ThatChrisR\RunescapeHighscores\Interfaces;

interface HighscoresInterface
{
	public function get_player($player);
	public function get_players(array $players);
}