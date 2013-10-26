<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PenaltyBox
 *
 * @author Zsolt Petrik <petrik.zsolt@marbledigital.eu>
 */
class PenaltyBox {

    public function __construct($canGetOut = true) {
        $this->canGetOut = $canGetOut;
    }

    public function canGetOut() {
        return $this->canGetOut;

    }

    public function canGetQuestion($rolled) {
        return ($rolled % 2 === 1);
    }

}
