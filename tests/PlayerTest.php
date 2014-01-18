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

	/**
	 * Testing the getter methods
	 */

	public function testGetDisplayName()
	{
		$playerName = $this->player->getDisplayName();

		$this->assertEquals($playerName, $this->displayName);
	}

	public function testGetAttackLevel()
	{
		$attackLevel = $this->player->getSkill('attack', 'level');

		$this->assertEquals($attackLevel, '97');
	}

	public function testGetAttackRank()
	{
		$attackRank = $this->player->getSkill('attack', 'rank');

		$this->assertEquals($attackRank, '99277');
	}

	public function testGetAttackXp()
	{
		$attackXp = $this->player->getSkill('attack', 'xp');

		$this->assertEquals($attackXp, '10784313');
	}
}