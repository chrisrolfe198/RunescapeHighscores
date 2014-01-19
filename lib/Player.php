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

	/**
	 * Helper Function
	 * Formats the string into lower case with an uppercase letter
	 */
	private function formatHighscoreString($skill)
	{
		return ucwords(strtolower($skill));
	}

}