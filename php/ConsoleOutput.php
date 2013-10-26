<?php

require_once __DIR__ . '/OutputInterface.php';

class ConsoleOutput implements OutputInterface {

    public function write($text) {
        echo $text;
    }

}