<?php

namespace ThatChrisR\RunescapeHighscores;

/**
 * Abstract class for Highscores
 * This works takes the raw data and formats it, any returning of that data is done in the player class
 */
abstract class Highscores
{

	/**
	 * Loads the skill labels out, hits the api and parses it
	 */
	protected function __construct()
	{
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

		$this->parseHighscoreCSV($this->getHighscoresString());
	}

	/**
	 * Attempts to load a player from the RS API
	 * Returns false on failing
	 */
	protected function getHighscoresString()
	{
		if ($highscoresString = fopen('http://hiscore.runescape.com/index_lite.ws?player='.$this->displayName, 'r')) {
			return stream_get_contents($highscoresString);
		} else {
			return false;
		}
	}

	/**
	 * Takes the csv style output and turns it into something useable
	 */
	protected function parseHighscoreCSV($highscoreCSV)
	{
		// Splitting the highscores by the spaces
		$highscoreStats = explode("\n", $highscoreCSV);
		// Empty array to push the skills to
		$this->skills = array();

		// Loop over the skills and push them into an array
		for($i = 0; $i < count($this->skillLabels); $i++) {
			$currentSkill = $this->skillLabels[$i];

			$skillData = explode(",", $highscoreStats[$i]);

			for ($z = 0; $z < 3; $z++) {
				$skillData['rank'] = $skillData['0'];
				$skillData['level'] = $skillData['1'];
				$skillData['xp'] = $skillData['2'];
			}

			$this->skills[$currentSkill] = $skillData;
		}
	}

}