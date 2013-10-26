<?php

require_once __DIR__ . '/OutputInterface.php';
require_once __DIR__ . '/WritableInterface.php';

class ConsoleOutput implements OutputInterface {

    public function write($text) {
        echo $text;
    }

    function reportPlayerPoints(WritableInterface $player) {
        echo $player->getName() .
        " now has " .
        $player->getPoints().
        " Gold Coins.\n";
    }

    public function reportPlayerLocation(WritableInterface $player) {
        echo $player->getName()
                . "'s new location is "
                . $player->getLocation()."\n";
    }

    public function playerAdded(WritableInterface $player) {
        echo $player->getName() . " was added\n";
    }

    public function reportPlayerInPenalty(WritableInterface $player) {
        echo $player->getName() . " was sent to the penalty box\n";
    }

}