<?php
class osoba {

    //Stvaranje varijable
    var $ime;
    public $visina;
    protected $oib;       
    private $pin_kartice;
        
    //Konstruktor
    function __construct($ime_osobe,$visina_osobe) {
        $this->ime = $ime_osobe;
        $this->visina = $visina_osobe;
    }
         
    //Funkcija za postavljanje vrijednosti
    function postavi_ime($novo_ime) {
        $this->ime = $novo_ime;
    }    
    
    //Funkcija za dohvat vrijednosti
    function dohvati_ime() {
        return $this->ime;
    }
} 

class zaposlenik extends osoba {
    var $ime_zaposlenika;

    function __construct($ime_zaposlenika) {
    }
    
    public function postavi_ime($novo_ime) {
      if($novo_ime != "") {
          $this->ime = $novo_ime;
      }
      else {
          $this->ime = "Zekoslav Mrkva";
      }
    }
}

?>
