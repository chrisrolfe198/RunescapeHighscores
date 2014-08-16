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

		$players = [];

		$this->client->sendAll($requests, [
			'complete' => function(CompleteEvent $event) {
				$player_name = urldecode(str_replace($this->base_url, '', $event->getRequest()->getUrl()));

				$players[$player_name] = new Player($event->getResponse()->getBody());
			},
			'error' => function(ErrorEvent $event) {
				throw new NotFoundException;
			}
		]);
	}

	protected function build_url($player)
	{
		return $this->base_url . $player;
	}
}