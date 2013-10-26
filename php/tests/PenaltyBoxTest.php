<?php

require_once __DIR__.'/../PenaltyBox.php';

class PenaltyBoxTest extends PHPUnit_Framework_TestCase {

    public function testCanGetOut() {
        $penalty = new PenaltyBox();
        $this->assertTrue($penalty->canGetOut());
    }

    public function testCantGetOut() {
        $penalty = new PenaltyBox(false);
        $this->assertFalse($penalty->canGetOut());

    }

    public function testCanGetQuestion() {
        $penalty = new PenaltyBox();
        $this->assertTrue($penalty->canGetQuestion(3));
        $this->assertFalse($penalty->canGetQuestion(2));
    }

}