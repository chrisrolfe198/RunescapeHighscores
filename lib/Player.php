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

	public function getSkill($skill, $typeOfStatistic)
	{
		$skill = $this->formatHighscoreString($skill);

		// Check if the skill is in the array
		if (array_key_exists($skill, $this->skills)) {
			return $this->skills[$skill][$typeOfStatistic];
		} else {
			return false;
		}
	}

	public function getMinigame($minigame, $typeOfStatistic)
	{
		$minigame = $this->formatHighscoreString($minigame);

		if (array_key_exists($minigame, $this->minigames)) {
			return $this->minigames[$minigame][$typeOfStatistic];
		} else {
			return false;
		}
	}

	public function getCombatLevel()
	{
		$attack = $this->getSkill('attack', 'level');
		$strength = $this->getSkill('strength', 'level');
		$magic = $this->getSkill('magic', 'level');
		$ranged = $this->getSkill('ranged', 'level');

		$highest = $attack;

		if ($strength > $highest) {
			$highest = $strength;
		}

		if ($magic > $highest) {
			$highest = $magic;
		}

		if ($ranged > $highest) {
			$highest = $ranged;
		}

		$defence = $this->getSkill('defence', 'level');

		return $highest + $defence + 2;
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