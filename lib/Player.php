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

	public function getSkill($skill, $type)
	{
		$skill = $this->formatSkillString($skill);

		// Check if the skill is in the array
		if (array_key_exists($skill, $this->skills)) {
			return $this->skills[$skill][$type];
		} else {
			return false;
		}
	}

	// Formats the string to match what is expected, a lower case word with the first letter uppercase
	private function formatSkillString($skill)
	{
		return ucfirst(strtolower($skill));
	}

}