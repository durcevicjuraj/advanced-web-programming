<?php
require('iRadovi.php');

class DiplomskiRadovi implements iRadovi {
    private $naziv_rada;
    private $tekst_rada;
    private $link_rada;
    private $oib_tvrtke;
    private $pdo;
    
    public function __construct() {
        try {
            $this->pdo = new PDO(
                'mysql:dbname=radovi;host=127.0.0.1;charset=utf8',
                'root',
                ''
            );
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Database connection failed: " . $e->getMessage());
        }
    }
    
    public function create($data) {
        $this->naziv_rada = $data['naziv_rada'];
        $this->tekst_rada = $data['tekst_rada'];
        $this->link_rada = $data['link_rada'];
        $this->oib_tvrtke = $data['oib_tvrtke'];
    }
    
    public function save() {
        try {
            $query = "INSERT INTO diplomski_radovi 
                      (naziv_rada, tekst_rada, link_rada, oib_tvrtke, datum_dodavanja) 
                      VALUES (:naziv_rada, :tekst_rada, :link_rada, :oib_tvrtke, NOW())";
            
            $stmt = $this->pdo->prepare($query);
            
            $result = $stmt->execute([
                ':naziv_rada' => $this->naziv_rada,
                ':tekst_rada' => $this->tekst_rada,
                ':link_rada' => $this->link_rada,
                ':oib_tvrtke' => $this->oib_tvrtke
            ]);
            
            return $result;
            
        } catch (PDOException $e) {
            echo "Error saving data: " . $e->getMessage() . "<br>";
            return false;
        }
    }
    
    public function read() {
        try {
            $query = "SELECT * FROM diplomski_radovi ORDER BY datum_dodavanja DESC";
            $stmt = $this->pdo->query($query);
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            return $results;
            
        } catch (PDOException $e) {
            echo "Error reading data: " . $e->getMessage() . "<br>";
            return [];
        }
    }
}
?>