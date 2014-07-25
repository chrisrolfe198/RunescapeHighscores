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

	public function getSkill($skill, $typeOfStatistic = 'level')
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
	
	public function getLegacyCombatLevel()
	{
		$defence = $this->getSkill('defence');
		$constitution = $this->getSkill('constitution');
		$prayer = $this->getSkill('prayer');
		
		$attack = $this->getSkill('attack');
		$strength = $this->getSkill('strength');
		
		$range = $this->getSkill('ranged');
		
		$mage = $this->getSkill('magic');
		
		$base = ($defence + $constitution + floor($prayer / 2));
		$melee = ($attack + $strength);
		$ranged = (floor($range / 2) + $range);
		$magic = (floor($mage / 2) + $mage);
		
		// calculate highest of the skills
		
		$cbLevel = floor($base + $highest);
		
		return [$cbLevel, $combatType];
	}

	public function getEocOriginalCombatLevel()
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

	// Adapted from http://codepad.org/jBTbpFKR
	public function getImprovedLegacyCombatLevel()
	{
		$attack = $this->getSkill('attack');
		$strength = $this->getSkill('strength');
		$magic = $this->getSkill('magic');
		$ranged = $this->getSkill('ranged');
		$defence = $this->getSkill('defence');
		$constitution = $this->getSkill('constitution');
		$prayer = $this->getSkill('prayer');
		$summoning = $this->getSkill('prayer');

		$base = ($defence + $constitution + floor($prayer / 2) + floor($summoning / 2)) * 0.25;

		$melee = ($attack + $strength) * 0.325;
		$ranger = floor($ranged * 2) * 0.325;
		$mage = floor($magic * 2) * 0.325;

		$base = $base + max($melee, $ranger, $mage);

		return floor($base);
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