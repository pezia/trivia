<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ConfigReader {

    private $configFile;

    public function __construct($filename) {
        $this->configFile = $filename;
    }

    public function getConfig() {
        return require $this->configFile;
    }
}

