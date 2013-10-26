<?php

require_once __DIR__ . '/Player.php';
require_once __DIR__ . '/WritableInterface.php';

interface OutputInterface {

    function write($text);

    function reportPlayerPoints(WritableInterface $player);

    function reportPlayerLocation(WritableInterface $player);

    function playerAdded(WritableInterface $player);
}
