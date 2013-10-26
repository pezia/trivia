<?php

require_once __DIR__ . '/../Game.php';
require_once __DIR__ . '/../OutputInterface.php';
require_once __DIR__ . '/../WritableInterface.php';

class FakeOutput implements OutputInterface {

    private $buffer;
    private $playerLocations = array();
    private $playerPoints = array();
    private $playerNames = array();

    public function write($text) {
        $this->buffer .= $text;
    }

    public function getBuffer() {
        return $this->buffer;
    }

    public function clearBuffer() {
        $this->buffer = '';
    }

    public function reportPlayerPoints(WritableInterface $player) {
        $this->playerPoints[$player->getName()] = $player->getPoints();
    }

    public function reportPlayerLocation(WritableInterface $player) {
        $this->playerLocations[$player->getName()] = $player->getLocation();
    }

    public function getLocationForPlayerName($playerName) {
        return isset($this->playerLocations[$playerName]) ? $this->playerLocations[$playerName] : null;
    }

    public function getPointsForPlayerName($playerName) {
        return isset($this->playerPoints[$playerName]) ? $this->playerPoints[$playerName] : null;
    }

    public function playerAdded(WritableInterface $player) {
        return $this->playerNames[] = $player->getName();
    }

    public function hasPlayer($playerName) {
        return in_array($playerName, $this->playerNames);
    }

}

class GameTest extends PHPUnit_Framework_TestCase {

    public function testAddDifferentPlayers() {
        $fakeOutput = new FakeOutput();
        $game = new Game(array(), $fakeOutput);

        $game->addPlayer('Player1');

        $this->assertTrue($fakeOutput->hasPlayer('Player1'));
        $this->assertFalse($fakeOutput->hasPlayer('Player2'));

        $fakeOutput->clearBuffer();

        $game->addPlayer('Player2');

        $this->assertTrue($fakeOutput->hasPlayer('Player2'));
    }

    public function testFreePlayerMoveAfterRoll() {
        $fakeOutput = new FakeOutput();
        $game = new Game(array('Pop', 'Pop', 'Pop', 'Pop'), $fakeOutput);

        $game->addPlayer('Player1');
        $game->addPlayer('Player2');
        $game->roll(1);
        $game->wrongAnswer();
        $game->roll(2);

        $this->assertEquals(2, $fakeOutput->getLocationForPlayerName('Player2'));
    }

}