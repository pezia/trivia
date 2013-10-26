<?php

class CharacterisationTest extends PHPUnit_Framework_TestCase {

    public function testCharacterisationTest() {

        for ($i = 0; $i < 1000; $i++) {
            srand($i);
            mt_srand($i);

            if (!ob_start()) {
                throw new Exception('OB error');
            }

            include(__DIR__ . '/../GameRunner.php');

            $output = ob_get_clean();
            $filename = __DIR__ . '/outputs/ct_' . $i . '.out';
            if (!file_exists($filename)) {
                file_put_contents($filename, $output);
            } else {
                $this->assertEquals(file_get_contents($filename),$output);
            }
        }

    }

}