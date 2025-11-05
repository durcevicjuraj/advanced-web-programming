<?php  
class Pravokutnik {
    public $sirina = 0;
    public $visina = 0;

    //Konstruktor
    function __construct($w = 0, $h = 0) {
        $this->sirina = $w;
        $this->visina = $h;
    }
    
    function Dimenzije($w = 0, $h = 0) {
        $this->sirina = $w;
        $this->visina = $h;
    }
    
    //Računa površinu
    function Povrsina() {
        return ($this->sirina * $this->visina);
    }
    
    //Računa opsef
    function Opseg() {
        return ( ($this->sirina + $this->visina) * 2 );
    }
    
    // Provjera je li kvadrat
    function Kvadrat() {   
        if ($this->sirina == $this->visina) {
            return true;
        } else {
            return false; 
        }
        
    }

} // Kraj klase