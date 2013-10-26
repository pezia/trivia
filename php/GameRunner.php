<?php

include_once __DIR__ . '/Game.php';

$isWinner = false;

$aGame = new Game();

$aGame->add("Chet");
$aGame->add("Pat");
$aGame->add("Sue");


do {

    $aGame->roll(rand(0, 5) + 1);

    if (rand(0, 9) == 7) {
        $isWinner = $aGame->wrongAnswer();
    } else {
        $isWinner = $aGame->correctAnswer();
    }
} while (!$isWinner);

