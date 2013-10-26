<?php

class Game {
    var $players;
    var $places;
    var $purses ;
    var $inPenaltyBox ;

    var $popQuestions;
    var $scienceQuestions;
    var $sportsQuestions;
    var $rockQuestions;

    var $currentPlayer = 0;
    var $isGettingOutOfPenaltyBox;

    public $categories = Array("Pop","Science","Sports","Rock");
    public $questions = Array();

    function  __construct(){

   	$this->players = array();
        $this->places = array(0);
        $this->purses  = array(0);
        $this->inPenaltyBox  = array(0);

        for ($i = 0; $i < 50; $i++) {
            foreach ($this->categories as $category) {
                $this->questions[$category][] = $category . " Question " . $i;
            }
    	}
    }

    private function echoln($string) {
      echo $string."\n";
    }

	function createRockQuestion($index){
		return "Rock Question " . $index;
	}

	function isPlayable() {
		return ($this->howManyPlayers() >= 2);
	}

	function add($playerName) {
	   array_push($this->players, $playerName);
	   $this->places[$this->howManyPlayers()] = 0;
	   $this->purses[$this->howManyPlayers()] = 0;
	   $this->inPenaltyBox[$this->howManyPlayers()] = false;

	    $this->echoln($playerName . " was added");
	    $this->echoln("They are player number " . count($this->players));
		return true;
	}

	function howManyPlayers() {
		return count($this->players);
	}

	function  roll($roll) {
		$this->echoln($this->players[$this->currentPlayer] . " is the current player");
		$this->echoln("They have rolled a " . $roll);

		if ($this->inPenaltyBox[$this->currentPlayer]) {
			if ($roll % 2 != 0) {
				$this->isGettingOutOfPenaltyBox = true;

				$this->echoln($this->players[$this->currentPlayer] . " is getting out of the penalty box");
                            $this->places[$this->currentPlayer] = $this->places[$this->currentPlayer] + $roll;
				if ($this->places[$this->currentPlayer] > 11) $this->places[$this->currentPlayer] = $this->places[$this->currentPlayer] - 12;

				$this->echoln($this->players[$this->currentPlayer]
						. "'s new location is "
						.$this->places[$this->currentPlayer]);
				$this->echoln("The category is " . $this->getCurrentCategory());
				$this->askQuestion();
			} else {
				$this->echoln($this->players[$this->currentPlayer] . " is not getting out of the penalty box");
				$this->isGettingOutOfPenaltyBox = false;
				}

		} else {

		$this->movePlayer($this->currentPlayer, $roll);

			$this->echoln($this->players[$this->currentPlayer]
					. "'s new location is "
					.$this->places[$this->currentPlayer]);
			$this->echoln("The category is " . $this->getCurrentCategory());
			$this->askQuestion();
		}

	}

	function  askQuestion() {
            $this->echoln(array_shift($this->questions[$this->getCurrentCategory()]));
	}



	function getCurrentCategory() {
            return $this->categories[$this->places[$this->currentPlayer] % 4];
	}

	function correctAnswer() {
		if ($this->inPenaltyBox[$this->currentPlayer]){
			if ($this->isGettingOutOfPenaltyBox) {
				$this->echoln("Answer was correct!!!!");
                                $this->purses[$this->currentPlayer]++;
				$this->echoln($this->players[$this->currentPlayer]
						. " now has "
						.$this->purses[$this->currentPlayer]
						. " Gold Coins.");

				$winner = $this->didPlayerWin();
				$this->nextPlayer();

				return $winner;
			} else {
				$this->nextPlayer();
				return false;
			}



		} else {

			$this->echoln("Answer was corrent!!!!");
		$this->purses[$this->currentPlayer]++;
			$this->echoln($this->players[$this->currentPlayer]
					. " now has "
					.$this->purses[$this->currentPlayer]
					. " Gold Coins.");

			$winner = $this->didPlayerWin();
                        $this->nextPlayer();

			return $winner;
		}
	}

	function wrongAnswer(){
		$this->echoln("Question was incorrectly answered");
		$this->echoln($this->players[$this->currentPlayer] . " was sent to the penalty box");
	$this->inPenaltyBox[$this->currentPlayer] = true;

		$this->nextPlayer();
		return false;
	}


	function didPlayerWin() {
		return $this->purses[$this->currentPlayer] === 6;
	}

        private function nextPlayer() {
            $this->currentPlayer = ++$this->currentPlayer % count($this->players);

        }

        private function movePlayer($player, $roll) {
            $this->places[$player] = $this->places[$player] + $roll;
                if ($this->places[$player] > 11) $this->places[$player] = $this->places[$player] - 12;
        }
}
