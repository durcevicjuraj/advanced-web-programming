<?php
require('Pravokutnik.php');

//Definiramo test klasu
class JednostavniTest extends PHPUnit_Framework_TestCase {
    
    //Testiramo metodu Povrsina
    function testPovrsina() {        
        //Stvaramo novi pravokutnik
        $r = new Pravokutnik(8,9);
        $r2 = new Pravokutnik(4,6);
        
        //Tvrdnja koja provjerava izračun
        $this->assertEquals(72, $r->Povrsina());
        $this->assertEquals(24, $r2->Povrsina());
        
    } 
    
}