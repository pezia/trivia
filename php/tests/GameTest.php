<?php

require_once __DIR__ . '/../Game.php';
require_once __DIR__ . '/../OutputInterface.php';

class FakeOutput implements OutputInterface {

    private $buffer;

    public function write($text) {
        $this->buffer .= $text;
    }

    public function getBuffer() {
        return $this->buffer;
    }

    public function clearBuffer() {
        $this->buffer = '';
    }

}

class GameTest extends PHPUnit_Framework_TestCase {

    public function testAddDifferentPlayers() {
        $fakeOutput = new FakeOutput();
        $game = new Game(array(), $fakeOutput);

        $game->addPlayer('Player1');

        $this->assertEquals("Player1 was added\nThey are player number 1\n", $fakeOutput->getBuffer());

        $fakeOutput->clearBuffer();

        $game->addPlayer('Player2');

        $this->assertEquals("Player2 was added\nThey are player number 2\n", $fakeOutput->getBuffer());
    }

    public function testFreePlayerMoveAfterRoll() {
        $fakeOutput = new FakeOutput();
        $game = new Game(array('Pop'), $fakeOutput);
    }

}