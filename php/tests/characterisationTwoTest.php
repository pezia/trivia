<?php
/*
include_once __DIR__ . '/../Game.php';

// <editor-fold desc="Random pool generation" defaultstate="collapsed">
function createRandomPools($numRolls, $numAnswers) {
    $rolls = array();
    $answers = array();
    $rollsFilename = __DIR__ . '/pools/rolls.txt';
    $answersFilename = __DIR__ . '/pools/answers.txt';

    if (!file_exists($rollsFilename)) {
        for ($i = 0; $i < $numRolls; $i++) {
            $rolls[] = mt_rand(1, 6);
        }

        file_put_contents($rollsFilename, implode("\n", $rolls));
    }

    if (!file_exists($answersFilename)) {
        for ($i = 0; $i < $numAnswers; $i++) {
            $answers[] = mt_rand(0, 9);
        }

        file_put_contents($answersFilename, implode("\n", $answers));
    }
}

function readRandomPools() {
    $rollsFilename = __DIR__ . '/pools/rolls.txt';
    $answersFilename = __DIR__ . '/pools/answers.txt';

    return array(
        'rolls' => file($rollsFilename),
        'answers' => file($answersFilename),
    );
}

createRandomPools(10000, 100000);

//</editor-fold>

class CharacterisationTwoTest extends PHPUnit_Framework_TestCase {

    private static $randomPools;

    public static function setUpBeforeClass() {
        createRandomPools(10000, 100000);
        self::$randomPools = readRandomPools();
    }

    public function testCharacterisation() {
        $this->markTestSkipped();
        return;

        $rollIndex = 0;
        $answerIndex = 0;

        for ($i = 0; $i < 1000; $i++) {
            if (!ob_start()) {
                throw new Exception('OB error');
            }

            $aGame = new Game();

            $aGame->add("Chet");
            $aGame->add("Pat");
            $aGame->add("Sue");

            do {
                $roll = self::$randomPools['rolls'][(++$rollIndex % count(self::$randomPools['rolls']))];
                $answer = self::$randomPools['answers'][(++$answerIndex % count(self::$randomPools['answers']))];

                $aGame->roll($roll);

                if ($answer == 7) {
                    $notAWinner = $aGame->wrongAnswer();
                } else {
                    $notAWinner = $aGame->wasCorrectlyAnswered();
                }
            } while ($notAWinner);

            $output = ob_get_clean();
            $filename = __DIR__ . '/outputs2/ct_' . $i . '.out';
            if (!file_exists($filename)) {
                file_put_contents($filename, $output);
            } else {
                $this->assertEquals(file_get_contents($filename), $output, 'Output does not match for ' . $i);
            }
        }
    }

}*/