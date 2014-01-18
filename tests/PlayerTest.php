<?php

use ThatChrisR\RunescapeHighscores\Player;
use VCR\VCR;

class PlayerTest extends PHPUnit_Framework_TestCase
{
	protected function setup()
	{
		VCR::turnOn();
		VCR::insertCassette('rsHighscores');

		$this->displayName = 'Das Wanderer';
		$this->player = new Player($this->displayName);

		VCR::eject();
		VCR::turnOff();
	}

	public function testGetDisplayName()
	{
		$playerName = $this->player->getDisplayName();

		$this->assertEquals($playerName, $this->displayName);
	}

	public function testGetSkill()
	{
		$attackLevel = $this->player->getSkill('attack', 'level');

		$this->assertEquals($attackLevel, '97');
	}
}