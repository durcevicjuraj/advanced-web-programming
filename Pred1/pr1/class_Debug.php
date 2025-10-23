<?php 
trait Debug {    
    // Ispis podataka o trenutnom objektu
    public function dumpObject() {        
        //Ime klase
        $class = get_class($this);  
              
        // Dohvat varijabli
        $attributes = get_object_vars($this);
        
        // Dohvat metoda
        $methods = get_class_methods($this);  
              
        // Ispis varijabli
        echo '<h3>Varijable</h3><ul>';
        foreach ($attributes as $k => $v) {
            echo "<li>$k: $v</li>"; 
            //var_dump($v);
        }
        echo '</ul>';
        
        //Ispis metoda
        echo '<h3>Metode</h3><ul>';
        foreach ($methods as $v) {
            echo "<li>$v</li>";
        }
        echo '</ul>';

    } 
    
}

?>