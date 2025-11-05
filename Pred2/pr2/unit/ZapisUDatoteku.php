<?php 
class FileException extends Exception {
    function Detalji() {

        //Vraća poruku ovisno o kodu
        switch ($this->code) {
            case 0:
                return 'Nema imena datoteke';
                break;
            case 1:
                return 'Datoteka ne postoji';
                break;
            case 2:
                return 'To nije datoteka';
                break;
            case 3:
                return 'Nije dozvoljeno pisati u datoteku';
                break;
            case 4:
                return 'Niste dali ispravan mod';
                break;
            case 5:
                return 'Podaci se ne mogu zapisati';
                break;
            case 6:
                return 'Datoteka se ne može zatvoriti';
                break;
            default:
                return 'Nemamo informacija o datoteci';
                break;
        } 
    
    } 
    
}

class ZapisUDatoteku {
    
    //Za spremanje pokazivača na datoteku
    private $_fp = NULL;

    //Poruka o pogrešci
    private $_message = '';
    
    //Konstruktor
    function __construct($file = null, $mode = 'w') {
    
        //Daoteka i mod se zapisuju u poruku
        $this->_message = "Datoteka: $file Mod: $mode";
        
        //Postoji li ime datoteke
        if (empty($file)) throw new FileException($this->_message, 0);

        //Postoji li datoteka
        if (!file_exists($file)) throw new FileException($this->_message, 1);

        //Je li datoteka
        if (!is_file($file)) throw new FileException($this->_message, 2);

        //Može li se pisati
        if (!is_writable($file)) throw new FileException($this->_message, 3);

        //Provjera moda
        if (!in_array($mode, array('a', 'a+', 'w', 'w+'))) throw new FileException($this->_message, 4);
                
        //Otvori datoteku
        $this->_fp = fopen($file, $mode);

    } 
    
    function Pisi($data) {
        if (@!fwrite($this->_fp, $data . "\n")) throw new FileException($this->_message . " Podaci: $data", 5);

    } 
    
    function Zatvori() {
        if ($this->_fp) {
            if (@!fclose($this->_fp)) throw new FileException($this->_message, 6);
            $this->_fp = NULL;
        }   

    }

    //Destruktor
    function __destruct() {
        $this->close();
    }
    
}