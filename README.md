RunescapeHighscores
===================

A PHP layer on top of the RuneScape Highscores.

## Install

### Installing via composer

If you run this command with composer it'll require it into your project

`composer require that-chris-r/runescape-highscores`

Or add this to your composer.json

```javascript
{
	"require": {
		"that-chris-r/runescape-highscores": "1.*"
	}
}
```

### Installing via git

Alternatively you can clone this repository and use the files in lib.

## Using the classes

You'll need to reference the namespace at the head of the file like so:
`use ThatChrisR\RunescapeHighscores\Player;`

Once that's done you can then create a new player like so:
`$player = new Player('Das Wanderer');`

The RS API offers you access to rank, level and experience for skill levels.

You can access the skills by calling the getSkill method like so:
`$player->getSkill('dungeoneering', 'level');`
The first parameter being the skill you are trying to retrieve, the second the type of information you want.

Accessing the minigame information is very similar, however the types of information are either rank or score.

`$player->getMinigame('Ba Attackers', 'rank')`

## Issues
If you have any issues please raise them via github
