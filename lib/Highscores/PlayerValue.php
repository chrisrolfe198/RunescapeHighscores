<?php

namespace ThatChrisR\RunescapeHighscores\Highscores;

use ThatChrisR\RunescapeHighscores\Interfaces\PlayerValueInterface;

class PlayerValue implements PlayerValueInterface
{
	public function __construct($values)
	{
		$this->rank = $values[0] < 0 ? 0 : $values[0];

		if (count($values) == 3) {
			$this->level = $values[1] < 0 ? 0 : $values[1];
			$this->xp = $values[2] < 0 ? 0 : $values[2];
		} else {
			$this->score = $values[1];
		}
	}

	public function __toString()
	{
		if (isset($this->xp)) return $this->level;
		return $this->rank;
	}

	public function to_array()
	{
		$array = [
			"rank" => $this->rank
		];

		if (isset($this->level)) $array["level"] = $this->level;
		if (isset($this->xp)) $array["xp"] = $this->xp;
		if (isset($this->score)) $array["score"] = $this->score;

		return $array;
	}
}
