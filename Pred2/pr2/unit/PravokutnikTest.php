<?php 
use PHPUnit\Framework\TestCase;
require('Pravokutnik.php');

class PravokutnikTest extends TestCase {
    
  //Za spremanje objekta Pravokutnik
  protected $r;
    
  //Stvorimo novi objekt
	function setUp():void {
	    $this->r = new Pravokutnik(8,9);
	}

  //Testiramo metodu Povrsina
	function testPovrsina() {
	    $this->assertEquals(72, $this->r->Povrsina());
	}
    
    //Testiramo metodu Opseg
    function testOpseg() {
        $this->assertEquals(34, $this->r->Opseg());
    }

    //Testiramo metodu Kvadrat
    function testKvadrat() {
        
        //U ovom slučaju ne smije biti kvadrat
        $this->assertFalse($this->r->Kvadrat());
        
        //Napravi kvadrat i testiraj opet
        $this->r->Dimenzije(5,5);
        $this->assertTrue($this->r->Kvadrat());

    }

    //Testiramo Dimenzije
    function testDimenzije() {
        $w = 5;
        $h = 8;
        $this->r->Dimenzije($w, $h);
        $this->assertEquals($w, $this->r->sirina);
        $this->assertEquals($h, $this->r->visina);
    }
    
}