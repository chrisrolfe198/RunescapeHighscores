<?php

use ThatChrisR\RunescapeHighscores\Highscores\RunescapeHighscores;
use VCR\VCR;

class PlayerTest extends PHPUnit_Framework_TestCase
{
	// Sets up the player instance so that we only have one instance and call to the API/Fixture
	protected function setup()
	{
		VCR::turnOn();
		VCR::insertCassette('rsHighscores');

		$this->display_name = 'Das Wanderer';
		$this->highscores = new RunescapeHighscores();

		VCR::eject();
		VCR::turnOff();
	}

	public function test_we_can_get_a_players_rank_and_level()
	{
		$this->player = $this->highscores->get_player($this->display_name);

		$this->assertEquals(99, $this->player->defence->level);
		$this->assertEquals(102836, $this->player->defence->rank);
	}

	public function test_we_can_get_a_players_ba_rank_and_score()
	{
		$this->player = $this->highscores->get_player($this->display_name);

		$this->assertEquals(19105, $this->player->ba_healers->rank);
		$this->assertEquals(2625, $this->player->ba_healers->score);
	}
}
