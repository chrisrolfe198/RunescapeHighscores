<?php

namespace ThatChrisR\RunescapeHighscores;

use ThatChrisR\RunescapeHighscores\Highscores;

class Player extends Highscores
{
	protected $displayName;

	public function __construct($displayName)
	{
		$this->displayName = $displayName;
		// Call the parent constructor after have a display name set
		parent::__construct();
	}

	/**
	 * Getter for the display name
	 */
	public function getDisplayName()
	{
		return $this->displayName;
	}

	public function getSkill($skill,
		$typeOfStatistic)
	{
		$skill = $this->formatHighscoreString($skill);

		// Check if the skill is in the array
		if (array_key_exists($skill,
			$this->skills)) {
			return $this->skills[$skill][$typeOfStatistic];
		} else {
			return false;
		}
	}

	public function getMinigame($minigame,
		$typeOfStatistic)
	{
		$minigame = $this->formatHighscoreString($minigame);

		if (array_key_exists($minigame,
			$this->minigames)) {
			return $this->minigames[$minigame][$typeOfStatistic];
		} else {
			return false;
		}
	}

	public function getCombatLevel($legacy = false)
	{
		if($legacy) {
			return $this->getLegacyCombatLevel();
		}
		return $this->getRs3CombatLevel();
	}

	private function getRs3CombatLevel()
	{
		$skills = array();
		$defence = $this->getSkill('defence', 'level');

		array_push($skills, $this->getSkill('attack', 'level'));
		array_push($skills, $this->getSkill('strength', 'level'));
		array_push($skills, $this->getSkill('magic', 'level'));
		array_push($skills, $this->getSkill('ranged', 'level'));

		$highest = $skills[0];

		while(!empty($skills)) {
			if ($skills[0] > $highest) {
				$highest = $skills[0];
			}
			array_pop($skills);
		}

		return $highest + $defence + 2;
	}

	private function getLegacyCombatLevel()
	{
		$skills = array(
			"Attack",
			"Strength",
			"Defence",
			"Magic",
			"Ranged",
			"Prayer",
			"Summoning"
		);
		$skillLevels = array();

		foreach ($skills as $skill) {
			$skillLevels[$skill] = $this->getSkill($skill, 'level');
		}

		var_dump($skillLevels);

	}

	/**
	 * Helper Function
	 * Formats the string into lower case with an uppercase letter
	 */
	private function formatHighscoreString($highscore)
	{
		return ucwords(strtolower($highscore));
	}

}