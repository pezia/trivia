<?php

require_once __DIR__ . '/Player.php';
require_once __DIR__ . '/OutputInterface.php';

class Game {
    const WINNING_POINTS = 6;

    /**
     * Players
     * @var Player[]
     */
    private $players;
    private $inPenaltyBox;
    private $currentPlayerIndex = 0;
    private $isGettingOutOfPenaltyBox;
    private $board;
    private $categories = array();
    private $questions = array();
    private $output;

    /**
     * @todo Fix first player penalty by default
     */
    public function __construct($board, OutputInterface $output) {
        $this->players = array();
        $this->board = $board;
        $this->categories = array_unique($board);
        $this->output = $output;

        $this->inPenaltyBox = array(0);

        for ($i = 0; $i < 50; $i++) {
            foreach ($this->categories as $category) {
                $this->questions[$category][] = $category . ' Question ' . $i;
            }
        }
    }

    private function echoln($string) {
        $this->output->write($string . "\n");
    }

    public function isPlayable() {
        return ($this->howManyPlayers() >= 2);
    }

    public function addPlayer($playerName) {
        $newPlayer = new Player($playerName);
        array_push($this->players, $newPlayer);
        $this->inPenaltyBox[$this->howManyPlayers()] = false;

        $this->output->playerAdded($newPlayer);
        $this->echoln("They are player number " . count($this->players));
        return true;
    }

    public function howManyPlayers() {
        return count($this->players);
    }

    public function roll($roll) {
        $this->echoln($this->getCurrentPlayer() . " is the current player");
        $this->echoln("They have rolled a " . $roll);

        if ($this->inPenaltyBox[$this->currentPlayerIndex]) {
            if ($roll % 2 != 0) {
                $this->isGettingOutOfPenaltyBox = true;

                $this->echoln($this->getCurrentPlayer() . " is getting out of the penalty box");
                $this->movePlayer($this->getCurrentPlayer(), $roll);

                $this->reportPlayerLocation($this->getCurrentPlayer());
                $this->echoln("The category is " . $this->getCurrentCategory());
                $this->askQuestion();
            } else {
                $this->echoln($this->getCurrentPlayer() . " is not getting out of the penalty box");
                $this->isGettingOutOfPenaltyBox = false;
            }
        } else {

            $this->movePlayer($this->getCurrentPlayer(), $roll);

            $this->reportPlayerLocation($this->getCurrentPlayer());

            $this->echoln("The category is " . $this->getCurrentCategory());
            $this->askQuestion();
        }
    }

    public function askQuestion() {
        $this->echoln(array_shift($this->questions[$this->getCurrentCategory()]));
    }

    private function getCurrentCategory() {
        return $this->categories[$this->getCurrentPlayer()->getCurrentField() % count($this->categories)];
    }

    private function getCurrentPlayer() {
        return $this->players[$this->currentPlayerIndex];
    }

    public function correctAnswer() {
        if ($this->inPenaltyBox[$this->currentPlayerIndex]) {
            if ($this->isGettingOutOfPenaltyBox) {
                $this->echoln("Answer was correct!!!!");
                $this->getCurrentPlayer()->addPoints(1);
                $this->reportPlayerPoints($this->getCurrentPlayer());

                $winner = $this->didPlayerWin();
                $this->nextPlayer();

                return $winner;
            } else {
                $this->nextPlayer();
                return false;
            }
        } else {

            $this->echoln("Answer was corrent!!!!");
            $this->getCurrentPlayer()->addPoints(1);
            $this->reportPlayerPoints($this->getCurrentPlayer());

            $winner = $this->didPlayerWin();
            $this->nextPlayer();

            return $winner;
        }
    }

    public function wrongAnswer() {
        $this->echoln("Question was incorrectly answered");
        $this->echoln($this->getCurrentPlayer() . " was sent to the penalty box");
        $this->inPenaltyBox[$this->currentPlayerIndex] = true;

        $this->nextPlayer();
        return false;
    }

    private function didPlayerWin() {
        return $this->getCurrentPlayer()->getPoints() === self::WINNING_POINTS;
    }

    private function nextPlayer() {
        $this->currentPlayerIndex = ++$this->currentPlayerIndex % count($this->players);
    }

    private function movePlayer(Player $player, $roll) {
        $newField = ($player->getLocation() + $roll) % count($this->board);
        $player->setLocation($newField);
    }

    private function reportPlayerPoints(Player $player) {
        $this->output->reportPlayerPoints($player);
    }

    private function reportPlayerLocation(Player $player) {
        $this->output->reportPlayerLocation($player);
    }

}
