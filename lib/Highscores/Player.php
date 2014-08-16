<?php

namespace ThatChrisR\RunescapeHighscores\Highscores;

use ThatChrisR\RunescapeHighscores\Interfaces\PlayerInterface;
use \OutOfRangeException;

class Player implements PlayerInterface
{
	protected $attrs = [];
	protected $attr_indexs = ["overall", "attack", "defence", "strength", "constitution", "ranged", "prayer", "magic", "cooking", "woodcutting", "fletching", "fishing", "firemaking", "crafting", "smithing", "mining", "herblore", "agility", "thieving", "slayer", "farming", "runecrafting", "hunter", "construction", "summoning", "dungeoneering", "divination",
	"bounty hunters", "bounty hunters rogues", "dominion tower", "the crucible", "castle wars", "ba attackers", "ba defenders", "ba collectors", "ba healers", "duel tournament", "mobilising armies", "conquest", "fist of guthix", "resource race", "athletics", "we2 armadyl contribution", "we2 bandos contribution", "we2 armadyl pvp kills", "we2 bandos pvp kills", "heist guard level", "heist robber level", "cfp average"];

	public function __construct($csv)
	{
		$this->parse_csv((string) $csv);
	}

	public function __get($value)
	{
		$value = str_replace("_", " ", $value);

		if (isset($this->attrs[$value])) return $this->attrs[$value];
		throw new OutOfRangeException("Property doesn't exist", 1);
		
	}
	
	protected function parse_csv($csv)
	{
		$highscore_rows = explode("\n", $csv);

		foreach ($highscore_rows as $index => $value) {
			if (empty($value)) continue;

			$split_row = explode( ',', $value);

			$this->attrs[$this->attr_indexs[$index]] = new PlayerValue($split_row);
		}
	}

}