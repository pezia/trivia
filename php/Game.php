<?php

class Game {

    var $players;
    var $places;
    var $purses;
    var $questions;
    var $inPenaltyBox;
    var $currentPlayer = 0;
    var $isGettingOutOfPenaltyBox;

    function __construct($outputWriter) {
        $this->players = array();
        $this->places = array();
        $this->purses = array();
        $this->inPenaltyBox = array();

        $this->outputWriter = $outputWriter;
    }

    public function setConfig(array $cfg) {
        $this->questions = $cfg['questions'];
        foreach ($cfg['players'] as $playerName) {
            $this->add($playerName);
        }
    }

    function isPlayable() {
        return ($this->howManyPlayers() >= 2);
    }

    function add($playerName) {
        $this->players[] = $playerName;
        $this->places[] = 0;
        $this->purses[] = 0;
        $this->inPenaltyBox[] = false;

        $this->outputWriter->echoln($playerName . " was added");
        $this->outputWriter->echoln("They are player number " . count($this->players));
        return true;
    }

    function howManyPlayers() {
        return count($this->players);
    }

    function getBoardSize() {
        return 12;
    }

    function stepPlayer($roll) {
        $this->places[$this->currentPlayer] = ($this->places[$this->currentPlayer] + $roll) % $this->getBoardSize();

        $this->outputWriter->echoln($this->players[$this->currentPlayer]
                . "'s new location is "
                . $this->places[$this->currentPlayer]);
        $this->outputWriter->echoln("The category is " . $this->currentCategory());
    }

    function roll($roll) {
        $this->outputWriter->echoln($this->players[$this->currentPlayer] . " is the current player");
        $this->outputWriter->echoln("They have rolled a " . $roll);

        if ($this->inPenaltyBox[$this->currentPlayer]) {
            if ($roll % 2 != 0) {
                $this->isGettingOutOfPenaltyBox = true;

                $this->outputWriter->echoln($this->players[$this->currentPlayer] . " is getting out of the penalty box");
                $this->stepPlayer($roll);
                $this->askQuestion();
            } else {
                $this->outputWriter->echoln($this->players[$this->currentPlayer] . " is not getting out of the penalty box");
                $this->isGettingOutOfPenaltyBox = false;
            }
        } else {
            $this->stepPlayer($roll);
            $this->askQuestion();
        }
    }

    function askQuestion() {
        $this->outputWriter->echoln(array_shift($this->questions[$this->currentCategory()]));
    }

    function currentCategory() {
        $categories = array_keys($this->questions);

        return $categories[$this->places[$this->currentPlayer] % count($categories)];
    }

    function nextPlayer() {
        $this->currentPlayer = ($this->currentPlayer + 1) % count($this->players);
    }

    function currentPlayerCorrectAnswer() {
        $this->outputWriter->echoln("Answer was correct!!!!");
        $this->purses[$this->currentPlayer] ++;
        $this->outputWriter->echoln($this->players[$this->currentPlayer]
                . " now has "
                . $this->purses[$this->currentPlayer]
                . " Gold Coins.");

        $winner = $this->didPlayerWin();
        $this->nextPlayer();

        return $winner;
    }

    function wasCorrectlyAnswered() {
        if ($this->inPenaltyBox[$this->currentPlayer]) {
            if ($this->isGettingOutOfPenaltyBox) {
                $this->inPenaltyBox[$this->currentPlayer] = false;
                return $this->currentPlayerCorrectAnswer();
            } else {
                $this->nextPlayer();
                return true;
            }
        } else {
            return $this->currentPlayerCorrectAnswer();
        }
    }

    function wrongAnswer() {
        $this->outputWriter->echoln("Question was incorrectly answered");
        $this->outputWriter->echoln($this->players[$this->currentPlayer] . " was sent to the penalty box");
        $this->inPenaltyBox[$this->currentPlayer] = true;

        $this->nextPlayer();
        return true;
    }

    function didPlayerWin() {
        return !($this->purses[$this->currentPlayer] == 6);
    }

}
