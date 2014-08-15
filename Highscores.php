<?php

namespace ThatChrisR\RunescapeHighscores;

use GuzzleHttp\Client;
use GuzzleHttp\Event\CompleteEvent;
use GuzzleHttp\Event\ErrorEvent;

/**
 * Abstract class for Highscores
 * This works takes the raw data and formats it, any returning of that data is done in the player class
 */
abstract class Highscore
{

	protected $base_url = "http://hiscore.runescape.com/index_lite.ws?player=";

	/**
	 * Loads the skill labels out, hits the api and parses it
	 */
	protected function __construct()
	{
		$this->client = new Client();

		// Listing all the current skills - this feels bad to be here
		$this->skillLabels = array(
			"Overall", "Attack", "Defence", "Strength",
			"Constitution", "Ranged", "Prayer",
			"Magic", "Cooking", "Woodcutting",
			"Fletching", "Fishing", "Firemaking",
			"Crafting", "Smithing", "Mining",
			"Herblore", "Agility", "Thieving",
			"Slayer", "Farming", "Runecrafting",
			"Hunter", "Construction", "Summoning",
			"Dungeoneering", "Divination"
			);

		$this->minigameLabels = array(
			"Duel Tournaments", "Bounty Hunters",
			"Bounty Hunter Rogues", "Fist of Guthix",
			"Mobilising Armies", "Ba Attackers",
			"Ba Defenders", "Ba Healers",
			"Castle Wars Games", "Conquest"
			);

		$this->parseHighscoreCSV($this->getHighscoresString());
	}

	/**
	 * Attempts to load a player from the RS API
	 * Returns false on failing
	 */
	public function getHighscoresString()
	{
		$i = 6;
		$usernames = ["Das Wanderer", "122454352354", "Tommyboydied", "Gaogier", "Wise Choice", "Bexs", "Akathist"];

		$requests = [];

		while ($i > -1) {
			$url = $this->base_url.$usernames[$i];
			$requests[] = $this->client->createRequest('GET', $url);
			$i--;
		}

		$this->client->sendAll($requests, [
			'complete' => function(CompleteEvent $event) {
				echo 'Completed request to ' . $event->getRequest()->getUrl() . "<br />";
				echo 'Response ' . $event->getResponse()->getBody() . "<br /><br /><br />";
			},
			'error' => function(ErrorEvent $event) {
				echo 'Failed request to ' . $event->getRequest()->getUrl() . "<br />";
				echo '<br /><br /><br />';
			}
		]);
	}

	/**
	 * Takes the csv style output and turns it into something useable for both skills and minigames
	 */
	protected function parseHighscoreCSV($highscoreCSV)
	{
		// Splitting the highscores by the spaces
		$highscoreStats = explode("\n", $highscoreCSV);

		// Empty array to push the skills to
		$this->skills = array();

		$numberOfSkillLabels = count($this->skillLabels);
		$numberOfMinigameLabels = count($this->minigameLabels);

		// Loop over the skills and push them into an array
		for($i = 0; $i < $numberOfSkillLabels; $i++) {
			$currentSkill = $this->skillLabels[$i];

			$skillData = explode(",", $highscoreStats[$i]);

			$skillData['rank'] = $skillData['0'];
			$skillData['level'] = $skillData['1'];
			$skillData['xp'] = $skillData['2'];

			$this->skills[$currentSkill] = $skillData;
		}

		$w = 0;

		// Loop over the minigames and process them - In progress
		for ($x = $numberOfSkillLabels; $x < ($numberOfMinigameLabels + $numberOfSkillLabels); $x++) {
			$currentMinigame = $this->minigameLabels[$w];
			$minigameData = explode(",", $highscoreStats[$x]);

			$minigameData['rank'] = $minigameData['0'];
			$minigameData['score'] = $minigameData['1'];

			$this->minigames[$currentMinigame] = $minigameData;
			$w++;
		}
	}

}