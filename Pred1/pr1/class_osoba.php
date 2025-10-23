<?php
class osoba {
    //Stvaranje varijable
    var $ime;
    
    //Konstruktor
    function __construct($ime_osobe) {
        $this->ime = $ime_osobe;
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
?>
