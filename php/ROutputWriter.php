<?php
include_once  __DIR__.DIRECTORY_SEPARATOR.'iOutputWriter.php';
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class LnOutputWriter implements iOutputWriter {

    public function echoln ($string) {
       return $string."\n";
    }


}