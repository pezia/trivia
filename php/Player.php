<?php

require_once __DIR__ . '/WritableInterface.php';

class Player implements WritableInterface {

    private $name;
    private $location;
    private $points;

    public function __construct($name) {
        $this->name = $name;
        $this->points = 0;
        $this->location = 0;
    }

    public function getPoints() {
        return $this->points;
    }

    public function getCurrentField() {
        return $this->location;
    }

    public function addPoints($points) {
        $this->points +=$points;
        return $this;
    }

    public function getLocation() {
        return $this->location;
    }

    public function setLocation($location) {
        $this->location = $location;

        return $this;
    }

    public function __toString() {
        return $this->name;
    }

    public function getName() {
        return $this->name;
    }

}
