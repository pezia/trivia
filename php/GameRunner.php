<?php

include_once __DIR__ . '/Game.php';
require_once __DIR__ . '/ConsoleOutput.php';

$isWinner = false;

$board = array(
    'Pop', 'Science', 'Sports', 'Rock',
    'Pop', 'Science', 'Sports', 'Rock',
    'Pop', 'Science', 'Sports', 'Rock'
);

$aGame = new Game($board, new ConsoleOutput());

$aGame->addPlayer("Chet");
$aGame->addPlayer("Pat");
$aGame->addPlayer("Sue");


do {

    $aGame->roll(rand(0, 5) + 1);

    if (rand(0, 9) == 7) {
        $isWinner = $aGame->wrongAnswer();
    } else {
        $isWinner = $aGame->correctAnswer();
    }
} while (!$isWinner);

