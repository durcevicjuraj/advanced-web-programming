<?php 
/* Atributi su jednaki stupcima u bazi: id, creatorId, title, content, dateAdded, dateUpdated.
 * Metode: 
 *  - getId()
 *  - getCreatorId()
 *  - getTitle()
 *  - getContent()
 *  - getDateAdded()
 *  - getDateUpdated()
 *  - getIntro()
 */
class Page {
    
    //Atributi su sa protected pravom pristupa
    protected $id = null;
    protected $creatorId = null;
    protected $title = null;
    protected $content = null;
    protected $dateAdded = null;
    protected $dateUpdated = null;
    
    //Metode za dohvat svih atributa
    function getId() {
        return $this->id;
    }   
    function getCreatorId() {
        return $this->creatorId;
    }   
    function getTitle() {
        return $this->title;
    }
    function getContent() {
        return $this->content;
    }
    function getDateAdded() {
        return $this->dateAdded;
    }   
    function getDateUpdated() {
        return $this->dateUpdated;
    }   
    
    //Vraća prvih 200 znakova ako se ne preda parametar
    function getIntro($count = 200) {
        return substr(strip_tags($this->content), 0, $count) . '...';
    }
    
}