<?php  
class Trokut extends Oblik {
    //Dodajemo samo kad koristimo svojstva (Traits)
    //Zakomentirati u primjeru bez svojstava
    use Debug;
    
    private $_stranice = array();
    private $_opseg = NULL;

    function __construct($s0 = 0, $s1 = 0, $s2 = 0) {
        //Spremamo stranice trokuta u niz
        $this->_stranice[] = $s0;
        $this->_stranice[] = $s1;
        $this->_stranice[] = $s2;

        //Izračun opsega
        $this->_opseg = array_sum($this->_stranice);
    }

    public function Povrsina() { 
        return (SQRT(
        ($this->_opseg/2) *
        (($this->_opseg/2) - $this->_stranice[0]) * 
        (($this->_opseg/2) - $this->_stranice[1]) * 
        (($this->_opseg/2) - $this->_stranice[2])
        ));
    } 
    
    public function Opseg() {
        return $this->_opseg;
    } 

}   
?>
