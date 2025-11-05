<?php 
use PHPUnit\Framework\TestCase;
require('ZapisUDatoteku.php');

class ZapisUDatotekuTest extends TestCase {

    private $_fp = NULL;
    private $_file = 'nekadatoteka.txt';
    private $_data = 'testni podaci za upis u datoteku';

    //Otvori datoteku za pisanje
    function setUp():void {
        $this->_fp = fopen($this->_file, 'w');
    }

    //Zapiši i testiraj:
    function testPisi() {
        fwrite($this->_fp, $this->_data);
        $this->assertEquals($this->_data, file_get_contents($this->_file));
        //$this->assertEquals('podaci koji se ne nalaze u datoteci', file_get_contents($this->_file));    
    }

    //Zatvori daoteku
    function tearDown():void {
        fclose($this->_fp);
    }

}
