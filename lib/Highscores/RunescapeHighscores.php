<?php

namespace ThatChrisR\RunescapeHighscores\Highscores;

use ThatChrisR\RunescapeHighscores\Interfaces\HighscoresInterface;
use GuzzleHttp\Client;
use GuzzleHttp\Promise\Utils;

class RunescapeHighscores implements HighscoresInterface
{
	protected $base_url = "http://services.runescape.com/m=hiscore/index_lite.ws?player=";
	protected $client;
	public static $players = [];
	protected $errors = [];

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
			$requests[$player] = $this->client->getAsync($url);
		}

		$results = Utils::settle($requests)->wait();

		$players = [];
		$errors = [];

		// var_dump($results); exit;

		foreach ($results as $player_name => $request) {
			if (isset($request['value'])) {
				$result = $request['value'];

				if (null !== $result->getBody() and strpos($result->getBody(), '<!DOCTYPE html>') === false) {
					$players[$player_name] = new Player($result->getBody());
				}
			} else if ($request['reason']) {
				$code = $request['reason']->getCode();
				$errors[$player_name] = $code;
			}
		}

		$this->errors = $errors;

		return $players;
	}

	public function get_errors()
	{
		return $this->errors;
	}

	protected function build_url($player)
	{
		return $this->base_url . $player;
	}
}
