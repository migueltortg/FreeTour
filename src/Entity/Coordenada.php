<?php

namespace App\Entity;

class Coordenada {
    private $x;
    private $y;

    public function getX() {
        return $this->x;
    }

    public function getY() {
        return $this->y;
    }

    public function setX($x) {
        $this->x = $x;
    }

    public function setY($y) {
        $this->y = $y;
    }

    public function __toString(){
        return $this->x.", ".$this->y;
    }
}