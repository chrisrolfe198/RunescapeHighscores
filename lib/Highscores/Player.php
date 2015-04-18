<?php

namespace ThatChrisR\RunescapeHighscores\Highscores;

use ThatChrisR\RunescapeHighscores\Interfaces\PlayerInterface;
use \OutOfRangeException;

class Player implements PlayerInterface
{
	protected $skill_attrs = [];
	protected $skill_indexs = ["overall", "attack", "defence", "strength", "constitution", "ranged", "prayer", "magic", "cooking", "woodcutting", "fletching", "fishing", "firemaking", "crafting", "smithing", "mining", "herblore", "agility", "thieving", "slayer", "farming", "runecrafting", "hunter", "construction", "summoning", "dungeoneering", "divination"];
	protected $minigame_attrs = [];
	protected $minigame_indexs = ["bounty hunters", "bounty hunters rogues", "dominion tower", "the crucible", "castle wars", "ba attackers", "ba defenders", "ba collectors", "ba healers", "duel tournament", "mobilising armies", "conquest", "fist of guthix", "resource race", "athletics", "we2 armadyl contribution", "we2 bandos contribution", "we2 armadyl pvp kills", "we2 bandos pvp kills", "heist guard level", "heist robber level", "cfp average", "cow tipping", "rats killed after april fools 2015"];

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

	public function to_array()
	{
		$skills_and_minigames = array_merge($this->skill_attrs, $this->minigame_attrs);

		foreach ($skills_and_minigames as $key => $value) {
			$skills_and_minigames[$key] = $value->to_array();
		}

		return $skills_and_minigames;
	}

	public function get_legacy_combat_level()
	{
		$defence = $this->defence->level;
		$constitution = $this->constitution->level;
		$prayer = $this->prayer->level;

		$attack = $this->attack->level;
		$strength = $this->strength->level;

		$range = $this->ranged->level;

		$mage = $this->magic->level;

		$base = ($defence + $constitution + floor($prayer / 2)) * 0.25;
		$melee = ($attack + $strength) * 0.325;
		$ranged = (floor($range / 2) + $range) * 0.325;
		$magic = (floor($mage / 2) + $mage) * 0.325;

		// calculate highest of the skills
		$highest = max($melee, $ranged, $magic);

		$cbLevel = floor($base + $highest);

		return $cbLevel;
	}

	// Adapted from http://codepad.org/jBTbpFKR
	public function get_combat_level()
	{
		$attack = $this->attack->level;
		$strength = $this->strength->level;
		$magic = $this->magic->level;
		$ranged = $this->ranged->level;
		$defence = $this->defence->level;
		$constitution = $this->constitution->level;
		$prayer = $this->prayer->level;
		$summoning = $this->summoning->level;

		$base = ($defence + $constitution + floor($prayer / 2) + floor($summoning / 2)) * 0.25;

		$melee = ($attack + $strength) * 0.325;
		$ranger = floor($ranged * 2) * 0.325;
		$mage = floor($magic * 2) * 0.325;

		$base = $base + max($melee, $ranger, $mage);

		return floor($base);
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
