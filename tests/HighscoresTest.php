<?php

use ThatChrisR\RunescapeHighscores\Highscores\RunescapeHighscores;
use VCR\VCR;

class HighscoresTest extends PHPUnit_Framework_TestCase
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

	public function test_true()
	{
		$this->assertTrue(true);
	}

	public function test_we_can_get_a_player_back()
	{
		$player = $this->highscores->get_player($this->display_name);

		$this->assertInstanceOf('ThatChrisR\RunescapeHighscores\Highscores\Player', $player);
	}
}