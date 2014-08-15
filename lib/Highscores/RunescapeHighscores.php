<?php

namespace ThatChrisR\RunescapeHighscores\Highscores;

use ThatChrisR\RunescapeHighscores\Interfaces\HighscoresInterface;
use GuzzleHttp\Client;

class RunescapeHighscores implements HighscoresInterface
{
	protected $base_url = "http://hiscore.runescape.com/index_lite.ws?player=";
	protected $client;

	public function __construct()
	{
		$this->client = new Client();
	}

	public function get_player($player)
	{
		$url = $this->build_url($player);

		$response = $this->client->get($url);

		$csv_string = $response->getBody();

		return new Player($csv_string);
	}

	public function get_players()
	{
		// Get many players
	}

	protected function build_url($player)
	{
		return $this->base_url . $player;
	}
}