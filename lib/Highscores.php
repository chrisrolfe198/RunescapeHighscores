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

		$this->minigameLabels = array(
			"Duel Tournaments", "Bounty Hunters",
			"Bounty Hunter Rogues", "Fist of Guthix",
			"Mobilising Armies", "B.A Attackers",
			"B.A Defenders", "B.A Healers",
			"Castle Wars Games", "Conquest"
			);

		$this->parseHighscoreCSV($this->getHighscoresString());
	}

	/**
	 * Attempts to load a player from the RS API
	 * Returns false on failing
	 */
	protected function getHighscoresString()
	{
		// if ($highscoresString = fopen('http://hiscore.runescape.com/index_lite.ws?player='.$this->displayName, 'r')) {
		// 	return stream_get_contents($highscoresString);
		// } else {
		// 	return false;
		// }

		return "40158,2400,217195145\n99277,97,10784313\n92935,98,12086378\n114188,97,11154627\n88425,99,14639079\n112322,90,5559045\n68455,95,9490210\n116703,96,10009458\n108288,97,11326972\n91026,97,11283768\n84534,97,10728241\n68926,93,7693481\n86582,97,11321847\n59558,89,4849832\n69041,86,3831864\n36209,97,10881162\n75248,93,7570825\n45786,89,5072388\n55220,86,3948339\n35162,99,13038727\n53607,88,4583904\n48002,92,7139246\n57583,85,3520602\n39893,91,6223827\n61853,91,6288320\n43551,99,13821937\n79290,62,346753\n-1,-1\n-1,-1\n22031,2502243\n-1,-1\n-1,-1\n10201,2469\n6946,2492\n25238,1291\n12092,2625\n-1,-1\n-1,-1\n-1,-1\n-1,-1\n-1,-1\n-1,-1\n85971,164285\n-1,-1\n-1,-1\n-1,-1\n";
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