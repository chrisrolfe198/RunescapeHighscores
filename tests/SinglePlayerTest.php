<?php

use ThatChrisR\RunescapeHighscores\Player;
use VCR\VCR;

class PlayerTest extends PHPUnit_Framework_TestCase
{
	// Sets up the player instance so that we only have one instance and call to the API/Fixture
	protected function setup()
	{
		VCR::turnOn();
		VCR::insertCassette('rsHighscores');

		$this->displayName = 'Das Wanderer';
		$this->player = new Player($this->displayName);

		VCR::eject();
		VCR::turnOff();
	}
}