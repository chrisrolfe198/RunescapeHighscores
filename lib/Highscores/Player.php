<?php

namespace ThatChrisR\RunescapeHighscores\Highscores;

use ThatChrisR\RunescapeHighscores\Interfaces\PlayerInterface;
use \OutOfRangeException;

class Player implements PlayerInterface
{
	protected $skill_attrs = [];
	protected $skill_indexs = ["overall", "attack", "defence", "strength", "constitution", "ranged", "prayer", "magic", "cooking", "woodcutting", "fletching", "fishing", "firemaking", "crafting", "smithing", "mining", "herblore", "agility", "thieving", "slayer", "farming", "runecrafting", "hunter", "construction", "summoning", "dungeoneering", "divination"];
	protected $minigame_attrs = [];
	protected $minigame_indexs = ["bounty hunters", "bounty hunters rogues", "dominion tower", "the crucible", "castle wars", "ba attackers", "ba defenders", "ba collectors", "ba healers", "duel tournament", "mobilising armies", "conquest", "fist of guthix", "resource race", "athletics", "we2 armadyl contribution", "we2 bandos contribution", "we2 armadyl pvp kills", "we2 bandos pvp kills", "heist guard level", "heist robber level", "cfp average"];

	public function __construct($csv)
	{
		$this->parse_csv((string) $csv);
	}

	public function __get($value)
	{
		$value = str_replace("_", " ", $value);

		if (isset($this->skill_attrs[$value])) return $this->skill_attrs[$value];
		if (isset($this->minigame_attrs[$value])) return $this->minigame_attrs[$value];
		throw new OutOfRangeException("Property doesn't exist", 1);
	}

	public function get_all_skills()
	{
		return $this->skill_attrs;
	}

	public function get_all_minigames()
	{
		return $this->minigame_attrs;
	}

	protected function parse_csv($csv)
	{
		$highscore_rows = explode("\n", $csv);
		$skill_count = count($this->skill_indexs);

		foreach ($highscore_rows as $index => $value) {
			if (empty($value)) continue;
			$split_row = explode( ',', $value);

			if ($skill_count < $index + 1) {
				$this->minigame_attrs[$this->minigame_indexs[$index - $skill_count]] = new PlayerValue($split_row);
			} else {
				$this->skill_attrs[$this->skill_indexs[$index]] = new PlayerValue($split_row);
			}
		}
	}

}
