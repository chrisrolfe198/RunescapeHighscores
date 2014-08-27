<?php

namespace ThatChrisR\RunescapeHighscores\Highscores;

use ThatChrisR\RunescapeHighscores\Interfaces\HighscoresInterface;
use GuzzleHttp\Client;
use GuzzleHttp\Event\CompleteEvent;
use GuzzleHttp\Event\ErrorEvent;

class RunescapeHighscores implements HighscoresInterface
{
	protected $base_url = "http://hiscore.runescape.com/index_lite.ws?player=";
	protected $client;
	public static $players = [];
	public static $errors = [];

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

	public function get_players(array $players)
	{
		$requests = [];

		foreach ($players as $player) {
			$url = $this->build_url($player);
			$requests[] = $this->client->createRequest('GET', $url);
		}

		$results = \GuzzleHttp\batch($this->client, $requests);
		$players = [];
		$errors = [];

		foreach ($results as $request) {
			$player_name = urldecode(str_replace($this->base_url, '', $request->getUrl()));

			$result = $results[$request];
			if (null !== $result->getBody()) $players[$player_name] = new Player($result->getBody());
		}

		return $players;
	}

	protected function build_url($player)
	{
		return $this->base_url . $player;
	}
}
